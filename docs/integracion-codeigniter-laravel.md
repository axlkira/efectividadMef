# Integración de Sesiones CodeIgniter 3 con Laravel para Control de Acceso y Permisos

## Resumen

Esta guía explica **cómo reutilizar sesiones de CodeIgniter 3 (CI3)** en aplicaciones Laravel, permitiendo capturar variables como documento, rol y permisos personalizados. Así, puedes restringir el acceso a ciertos módulos según los permisos de usuario definidos en la base de datos de CI3.

---

## ¿Cómo funciona el flujo?

1. El usuario se loguea en el sistema principal (CI3).
2. El dashboard de CI3 ofrece un enlace a un módulo Laravel (por ejemplo, `/observatorioapp/public/sisben`).
3. Laravel **lee la sesión activa de CI3** usando un endpoint especial (`get_session_data`) y trae variables como documento, rol, nombre y cualquier permiso necesario (ejemplo: `consultarsisben`).
4. Laravel **valida los permisos** antes de permitir acceso al módulo o vista.

---

## 1. Preparar CodeIgniter 3

### A. Agrega los permisos como campos en la tabla de usuarios

Ejemplo de campo personalizado para Sisbén:

```sql
ALTER TABLE t_usuarioprotocolo ADD consultarsisben INT DEFAULT 0;
```

### B. Expón los datos de sesión en un endpoint

Agrega en tu controlador (`c_login.php`) el método `get_session_data`:

```php
public function get_session_data() {
    if ($this->session->userdata('documento')) {
        $documento = $this->session->userdata('documento');
        $usuario = $this->db->get_where('t_usuarioprotocolo', ['documento' => $documento])->row();
        $data = array(
            'documento'        => $usuario->documento,
            'nombre1'          => $usuario->nombre1,
            'apellido1'        => $usuario->apellido1,
            'rol'              => $usuario->rol,
            'consultarsisben'  => $usuario->consultarsisben ?? 0
        );
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'No session']);
    }
}
```

Este endpoint devuelve la sesión activa y los permisos del usuario.

## 2. Middleware en Laravel

Crea un middleware (ejemplo: `CheckCodeigniterSession.php`) para leer la sesión:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CheckCodeigniterSession
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('documento')) {
            $url = 'https://unidadfamiliamedellin.com.co/metodologia2servidor/index.php/c_login/get_session_data';
            $cookies = [];
            foreach ($_COOKIE as $name => $value) {
                $cookies[$name] = $value;
            }
            $response = Http::withCookies($cookies, parse_url($url, PHP_URL_HOST))
                ->get($url);
            $data = $response->json();
            if (isset($data['documento'])) {
                Session::put('documento', $data['documento']);
                Session::put('rol', $data['rol'] ?? null);
                Session::put('nombre1', $data['nombre1'] ?? '');
                Session::put('apellido1', $data['apellido1'] ?? '');
                Session::put('consultarsisben', $data['consultarsisben'] ?? 0);
            } else {
                // Redirige al login de CI3 si no hay sesión
                return redirect('https://unidadfamiliamedellin.com.co/metodologia2servidor/index.php/c_login/fc_vlogin');
            }
        }

        // Permite solo a usuarios con permiso consultarsisben = 1
        if (Session::get('consultarsisben') != 1) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
```

> **Nota:** Puedes agregar cualquier campo de permisos que tengas en tu tabla, solo agrégalo en el endpoint y en la sesión de Laravel.

## 3. Usar la sesión en tus controladores y vistas

En cualquier controlador o vista de Laravel, puedes acceder así:

```php
$documento = session('documento');
$rol = session('rol');
$permiso_sisben = session('consultarsisben');
```

Puedes usarlo para mostrar u ocultar elementos, auditar, filtrar datos, etc.

## 4. Checklist para nuevas aplicaciones

- [ ] ¿Tu tabla de usuarios en CI3 tiene el campo de permiso que necesitas?
  - Si no, créalo y usa 1/0 para sí/no.

- [ ] ¿El método `get_session_data` devuelve ese campo?
  - Si no, agrega el campo al array y retorna por JSON.

- [ ] ¿El middleware de Laravel pide ese campo y lo guarda en sesión?
  - Si no, ponlo en `Session::put()` y valida con un `if`.

- [ ] ¿Estás usando el middleware en tus rutas protegidas?
  - Si no, agrega el middleware a la(s) ruta(s) o controlador(es) que requieren protección.

- [ ] ¿Necesitas más permisos?
  - Solo agrega más campos en la tabla, el endpoint y la validación del middleware.

- [ ] ¿Vas a cambiar el dominio del backend CI3?
  - Actualiza la URL en el middleware.

## 5. Reutilización

Puedes copiar este flujo para cualquier proyecto Laravel que deba usar autenticación o permisos de tu plataforma principal en CodeIgniter 3.

Solo recuerda:
- El endpoint de sesión debe exponer todos los campos necesarios.
- El middleware debe validarlos y pasarlos a Laravel vía Session.

## 6. Seguridad y tips

- No expongas información sensible de más en el endpoint de sesión.
- Limita el acceso a las rutas/funciones sensibles solo a los que tengan el permiso requerido.
- Si tienes muchos tipos de permisos, puedes manejar un array y validar varios campos a la vez.

## Ejemplo de uso en una vista de Blade

```blade
@if(session('consultarsisben') == 1)
    <a href="/observatorioapp/public/sisben">Ir al módulo Sisbén</a>
@endif
```
