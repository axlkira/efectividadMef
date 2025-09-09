# Manual de Usuario - Módulo de Efectividad MEF

## Índice
1. [Introducción](#introducción)
2. [Acceso al Sistema](#acceso-al-sistema)
3. [Interfaz Principal](#interfaz-principal)
4. [Gestión de Encuestas](#gestión-de-encuestas)
5. [Preguntas Frecuentes](#preguntas-frecuentes)

## Introducción

El Módulo de Efectividad MEF (Medida de Efectividad Familiar) es una herramienta diseñada para evaluar la satisfacción de los usuarios respecto a los servicios prestados por los profesionales del programa. Este manual le guiará a través de las funcionalidades principales del sistema.

## Acceso al Sistema

### Ingreso al Sistema

1. Abra su navegador web e ingrese a la URL proporcionada por el administrador del sistema.
2. Ingrese sus credenciales en la página de inicio de sesión.

[AQUÍ VA LA IMAGEN: Captura de pantalla de la página de inicio de sesión]

3. Una vez autenticado, será redirigido automáticamente al módulo de Efectividad MEF con su documento de profesional.

## Interfaz Principal

La interfaz principal del módulo muestra una tabla con los usuarios asignados a su perfil que están pendientes de encuesta.

[AQUÍ VA LA IMAGEN: Captura de pantalla de la interfaz principal con la tabla de usuarios]

### Elementos de la Interfaz

1. **Menú de Navegación**: Ubicado en el lado izquierdo, permite acceder a las diferentes secciones del sistema.
   - **Gestión de Usuarios**: Recarga la página actual.
   - **Salir**: Cierra la sesión y regresa a la página de inicio.

2. **Tabla de Usuarios**: Muestra los usuarios asignados que cumplen con los criterios para realizar encuestas:
   - Han recibido al menos una visita tipo 1
   - No han pasado más de 20 días desde la fecha de la visita
   - No tienen una encuesta guardada previamente

3. **Botón de Tema**: Permite cambiar entre modo claro y oscuro según su preferencia.

## Gestión de Encuestas

### Realizar una Nueva Encuesta

1. En la tabla de usuarios, identifique el usuario al que desea realizar la encuesta.
2. Haga clic en el botón "Encuesta" ubicado en la última columna de la fila correspondiente.

[AQUÍ VA LA IMAGEN: Captura del botón de encuesta en la tabla]

3. Se abrirá un formulario modal con las preguntas de la encuesta.

[AQUÍ VA LA IMAGEN: Captura del formulario modal de encuesta]

4. Complete todos los campos requeridos:
   - **Estado de la encuesta**: Seleccione si la encuesta fue completada o no.
   - **Satisfacción con el servicio**: Evalúe del 1 al 5 la satisfacción general.
   - **Oportunidad brindada**: Indique si la oportunidad fue útil (Sí/No).
   - **Trato del gestor**: Evalúe del 1 al 5 el trato recibido.
   - **Aspecto que más gustó**: Describa brevemente lo que más gustó al usuario.
   - **Aspecto que menos gustó**: Describa brevemente lo que menos gustó al usuario.
   - **Nombre del encuestado**: Nombre completo de la persona que responde.
   - **Teléfono del encuestado**: Número de contacto actualizado.

5. Haga clic en el botón "Guardar Encuesta" para enviar los datos.

[AQUÍ VA LA IMAGEN: Captura del botón de guardar encuesta]

6. Si todos los campos están correctamente completados, aparecerá un mensaje de confirmación y el usuario desaparecerá automáticamente de la tabla.

[AQUÍ VA LA IMAGEN: Captura del mensaje de confirmación]

### Validaciones del Formulario

- Todos los campos marcados con asterisco (*) son obligatorios.
- Si intenta enviar el formulario con campos incompletos, estos se resaltarán en rojo.
- El sistema valida automáticamente el formato del número de teléfono.

## Preguntas Frecuentes

### ¿Por qué no veo algunos usuarios en la tabla?

El sistema filtra automáticamente los usuarios según estos criterios:
- Solo muestra usuarios que han recibido al menos una visita tipo 1 (línea 200)
- Solo muestra usuarios cuya visita se realizó en los últimos 20 días
- No muestra usuarios que ya tienen una encuesta guardada

### ¿Qué sucede si cierro el formulario sin guardar?

Si cierra el formulario de encuesta sin guardar, los datos ingresados se perderán y deberá comenzar nuevamente.

### ¿Puedo editar una encuesta ya guardada?

No, una vez guardada la encuesta no puede ser modificada. Asegúrese de verificar todos los datos antes de guardar.

### ¿Cómo puedo cambiar entre modo claro y oscuro?

Haga clic en el ícono de sol/luna ubicado en la esquina superior derecha de la pantalla para cambiar entre los modos de visualización.

---

Para soporte técnico adicional, contacte al administrador del sistema.

**Fecha de última actualización**: Septiembre, 2025
