# Documentación del Módulo de Efectividad MEF

## Índice
1. [Introducción](#introducción)
2. [Arquitectura General](#arquitectura-general)
3. [Controlador](#controlador)
4. [Modelo](#modelo)
5. [Vista](#vista)
6. [Flujo de Datos](#flujo-de-datos)
7. [Seguridad y Buenas Prácticas](#seguridad-y-buenas-prácticas)

## Introducción

### Propósito del módulo
El módulo de Efectividad MEF (Medida de Efectividad Familiar) está diseñado para evaluar la satisfacción de los usuarios respecto a los servicios prestados por los profesionales del programa. Permite realizar encuestas de satisfacción a los titulares de hogares que han recibido visitas de tipo 1.

### Alcance y funcionalidades principales
- Visualización de usuarios asignados a un profesional específico
- Filtrado de usuarios según criterios predefinidos (visita tipo 1, tiempo transcurrido)
- Realización de encuestas de satisfacción
- Almacenamiento de resultados de encuestas
- Exclusión automática de usuarios ya encuestados

### Contexto en el sistema general
Este módulo forma parte del sistema de gestión de la Unidad Familia Medellín, integrándose con el sistema de metodología existente para evaluar la efectividad de las intervenciones realizadas por los profesionales en los hogares.

## Arquitectura General

### Descripción de capas y su interacción
El módulo sigue el patrón de arquitectura MVC (Modelo-Vista-Controlador):
- **Controlador**: Maneja las peticiones HTTP, procesa los datos y coordina la interacción entre el modelo y la vista.
- **Modelo**: Gestiona el acceso a datos y la lógica de negocio relacionada con los usuarios y las encuestas.
- **Vista**: Presenta la interfaz de usuario y maneja la interacción con el usuario final.

### Resumen del flujo de información
1. El usuario accede al módulo con su documento de identidad
2. El controlador solicita al modelo los datos de usuarios asignados
3. La vista presenta los datos en formato tabular
4. El usuario interactúa con la vista para realizar encuestas
5. El controlador procesa y almacena las respuestas de las encuestas
6. La vista se actualiza dinámicamente para reflejar los cambios

## Controlador

### Ubicación
`app/Http/Controllers/EfectividadMefController.php`

### Responsabilidades
- Gestionar las peticiones HTTP relacionadas con la efectividad MEF
- Coordinar la obtención de datos de usuarios para encuestas
- Procesar y almacenar las respuestas de las encuestas

### Métodos Clave
- **index($documento_profesional)**: Muestra la vista principal con los usuarios asignados al profesional.
- **guardarEncuesta(Request $request)**: Procesa y almacena los datos de la encuesta de satisfacción.

### Validaciones
- Verificación de la existencia del documento del profesional
- Validación implícita de los campos requeridos en el formulario de encuesta

## Modelo

### Ubicación
- `app/Models/UsuarioEncuesta.php`
- `app/Models/EncuestaSatisfaccionMef.php`

### Responsabilidades
#### UsuarioEncuesta
- Gestionar la información de los usuarios disponibles para encuestas
- Filtrar usuarios según criterios específicos (visita tipo 1, tiempo transcurrido)
- Excluir usuarios ya encuestados

#### EncuestaSatisfaccionMef
- Almacenar y gestionar las respuestas de las encuestas de satisfacción
- Definir la estructura de datos para las encuestas

### Métodos Clave
#### UsuarioEncuesta
- **getUsuariosParaEncuesta($usuarioId)**: Obtiene la lista de usuarios asignados a un profesional que cumplen con los criterios de filtrado.

### Seguridad
- Uso de consultas parametrizadas para prevenir inyección SQL
- Implementación de filtros para asegurar que solo se muestren usuarios asignados al profesional autenticado

## Vista

### Ubicación
`resources/views/efectividadMef/index.blade.php`

### Responsabilidades
- Presentar la lista de usuarios disponibles para encuestas
- Proporcionar un formulario interactivo para realizar encuestas
- Mostrar retroalimentación visual sobre el estado de las encuestas

### Características Técnicas
- **Framework CSS**: Tailwind CSS para diseño responsivo
- **Librerías JavaScript**: jQuery, DataTables
- **Iconos**: Font Awesome
- **Tema**: Soporte para modo claro/oscuro

### Interacción AJAX
- Envío asíncrono de datos de encuestas al servidor
- Actualización dinámica de la tabla de usuarios al completar una encuesta
- Notificaciones visuales de éxito/error mediante modales

## Flujo de Datos

### Proceso principal del módulo
1. **Carga inicial**:
   - El usuario accede a la URL `/efectividad-mef/{documento_profesional}`
   - El controlador invoca `UsuarioEncuesta::getUsuariosParaEncuesta($documento_profesional)`
   - El modelo ejecuta una consulta SQL compleja que:
     - Obtiene usuarios asignados al profesional
     - Filtra por usuarios con visita tipo 1 (línea 200)
     - Excluye usuarios con más de 20 días desde la visita
     - Excluye usuarios que ya tienen encuesta guardada
   - La vista renderiza la tabla con los usuarios filtrados

2. **Realización de encuesta**:
   - El usuario hace clic en el botón "Encuesta" de un usuario específico
   - Se abre un modal con el formulario de encuesta
   - El usuario completa el formulario y envía los datos
   - JavaScript captura los datos y los envía mediante AJAX al endpoint `/efectividad-mef/guardar-encuesta`
   - El controlador procesa los datos y los almacena en la tabla `t22_encuestas_satisfaccion_mef`
   - La vista elimina dinámicamente la fila del usuario encuestado de la tabla

### Ejemplos de interacción usuario-sistema
- **Filtrado automático**: El sistema solo muestra usuarios que cumplen con los criterios establecidos
- **Validación de formularios**: El sistema valida que todos los campos requeridos estén completos antes de enviar
- **Retroalimentación visual**: El sistema muestra un modal de éxito al completar una encuesta
- **Actualización dinámica**: La tabla se actualiza sin recargar la página al completar una encuesta

## Seguridad y Buenas Prácticas

### Validaciones de sesión y permisos
- Acceso restringido por documento de profesional
- Filtrado de datos para mostrar solo usuarios asignados al profesional autenticado
- Validación de datos en el cliente y en el servidor

### Autor(es)
Equipo de Desarrollo - Unidad Familia Medellín

### Fecha de última actualización
Septiembre, 2025
