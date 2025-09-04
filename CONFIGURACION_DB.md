# Configuración de Base de Datos para Efectividad MEF

## Variables de Entorno Necesarias

Para conectar con la base de datos `dbmetodologia_servidor`, necesitas agregar las siguientes variables a tu archivo `.env`:

```bash
# Conexión a la base de datos de metodología
DB_METODOLOGIA_HOST=localhost
DB_METODOLOGIA_PORT=3306
DB_METODOLOGIA_DATABASE=dbmetodologia_servidor
DB_METODOLOGIA_USERNAME=tu_usuario
DB_METODOLOGIA_PASSWORD=tu_contraseña
```

## Pasos de Configuración

1. Abre tu archivo `.env`
2. Agrega las líneas anteriores al final del archivo
3. Reemplaza `tu_usuario` y `tu_contraseña` con las credenciales reales
4. Guarda el archivo
5. Ejecuta `php artisan config:clear` para limpiar la caché de configuración

## Verificación

Para verificar que la conexión funciona correctamente, puedes ejecutar:

```bash
php artisan tinker
>>> use App\Models\UsuarioEncuesta;
>>> $usuarios = UsuarioEncuesta::getUsuariosParaEncuesta(1001033716);
>>> count($usuarios);
```

Esto debería devolver el número de registros encontrados.
