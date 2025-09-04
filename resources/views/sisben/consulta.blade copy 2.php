{{-- 
  Archivo: resources/views/sisben/consulta.blade.php
  Descripción: Vista de Blade para el Módulo de Consulta Sisbén.
  
  Uso en el Controlador:
  - Para la vista inicial: return view('sisben.consulta');
  - Después de una búsqueda: return view('sisben.consulta', ['results' => $results, 'cedula' => $cedula]);
  
  La variable $results debe ser una colección de Eloquent o un array de objetos 
  con los datos de la tabla `sisben_data`.
--}}

<!DOCTYPE html>
<html lang="es" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo de Consulta Sisbén</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Estilos personalizados para transiciones suaves y mejor UX */
        body, .bg-gray-100, .bg-gray-900, .bg-white, .bg-gray-800, .border-gray-300, .border-gray-700, input, button, .data-card {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }
        .data-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .dark .data-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
        }
    </style>
    <script>
        // Configuración de Tailwind para habilitar modo oscuro
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 font-sans min-h-screen">

    <div class="container mx-auto p-4 md:p-8">

        <!-- Encabezado: Título y Selector de Tema -->
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-blue-600 dark:text-blue-400 flex items-center gap-3">
                <i class="fas fa-search-location"></i>
                <span>Módulo de Consulta Sisbén</span>
            </h1>
            <button id="theme-toggle" class="p-2 rounded-full text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-900 focus:ring-blue-500">
                <i id="theme-icon" class="fas fa-moon text-xl"></i>
            </button>
        </header>

        <!-- Formulario de Búsqueda -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg mb-8">
            {{-- El action apunta a una ruta de Laravel que debe ser definida en web.php --}}
            <form id="search-form">
                {{-- El token CSRF se omite ya que la URL se construye con JS para una ruta GET --}}
                <label for="cedula" class="block text-lg font-medium mb-2">Consultar por Cédula</label>
                <div class="flex flex-col sm:flex-row gap-4">
                    <input type="text" id="cedula" name="cedula" value="{{ $cedula_buscada ?? old('cedula') }}" class="flex-grow w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Digite el número de cédula" required>
                    <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg flex items-center justify-center gap-2 transform hover:scale-105 transition-transform">
                        <i class="fas fa-search"></i>
                        <span>Buscar</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Sección de Resultados -->
        <div id="results-area">

            {{-- Estado de carga --}}
            <div id="loading-state" class="text-center py-16 hidden">
                <i class="fas fa-spinner fa-spin text-6xl text-blue-500"></i>
                <p class="mt-4 text-lg animate-pulse">Buscando información...</p>
            </div>

            {{-- Lógica de Blade para mostrar resultados, estado inicial o sin resultados --}}
            @isset($resultados)

                {{-- Resumen Global --}}
                <div class="mb-8 p-4 border-l-4 border-blue-500 bg-white dark:bg-gray-800 rounded-r-lg shadow-md flex flex-wrap justify-between items-center gap-4">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Fecha de Corte de la Data</p>
                        <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $fechaCorte }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total de Hogares en el Sistema</p>
                        <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ number_format($totalHogares, 0, ',', '.') }}</p>
                    </div>
                </div>

                @forelse ($resultados as $hogar)
                    {{-- Título de la sección de resultados --}}
                    @if ($loop->first)
                        <h2 class="text-2xl font-bold mb-4 text-gray-700 dark:text-gray-300">Hogares Encontrados para la Cédula {{ $cedula_buscada }} ({{ $resultados->count() }})</h2>
                    @endif

                    {{-- Tarjeta por cada hogar --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden data-card mb-8">
                        {{-- Encabezado de la tarjeta --}}
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                <i class="fas fa-home mr-2"></i>Ficha de Origen: {{ $hogar['info_general']->ide_ficha_origen ?? 'N/A' }}
                            </h3>
                            <span class="font-bold text-sm bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full">Hogar {{ $loop->iteration }}</span>
                        </div>

                        {{-- Contenido de la tarjeta --}}
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                                {{-- Columna 1: Información General del Hogar --}}
                                <div class="space-y-3 p-4 bg-green-50 dark:bg-green-900/30 rounded-lg border border-green-200 dark:border-green-800">
                                    <h4 class="text-md font-semibold border-b pb-2 mb-3 border-green-300 dark:border-green-700 text-green-800 dark:text-green-300 flex items-center"><i class="fas fa-map-marker-alt mr-3 text-green-500"></i>Información del Hogar</h4>
                                    <p><strong>Dirección:</strong> {{ $hogar['info_general']->dir_vivienda ?? 'No especificada' }}</p>
                                    <p><strong>Comuna (Cód.):</strong> {{ $hogar['info_general']->cod_comuna ?? 'N/A' }}</p>
                                    <p><strong>Barrio (Cód.):</strong> {{ $hogar['info_general']->cod_barrio ?? 'N/A' }}</p>
                                    <p><strong>Tel. Contacto:</strong> {{ $hogar['info_general']->num_tel_contacto ?? 'N/A' }}</p>
                                    <p><strong># Personas:</strong> <span class="bg-gray-200 dark:bg-gray-700 px-2 py-1 rounded-md text-sm">{{ $hogar['info_general']->num_personas_hogar ?? 'N/A' }}</span></p>
                                </div>

                                {{-- Columna 2: Información del Titular --}}
                                <div class="space-y-3 p-4 bg-purple-50 dark:bg-purple-900/30 rounded-lg border border-purple-200 dark:border-purple-800">
                                    <h4 class="text-md font-semibold border-b pb-2 mb-3 border-purple-300 dark:border-purple-700 text-purple-800 dark:text-purple-300 flex items-center"><i class="fas fa-user-shield mr-3"></i>Titular del Hogar</h4>
                                    @if ($hogar['jefe_hogar'])
                                        <p><strong>Nombre:</strong> {{ $hogar['jefe_hogar']->nombre_persona_hogar_concatenado }}</p>
                                        <p><strong>Documento:</strong> {{ $hogar['jefe_hogar']->num_documento }}</p>
                                        <p><strong>Clasificación:</strong> <span class="font-mono bg-purple-200 dark:bg-purple-800/60 px-2 py-1 rounded text-sm font-semibold">{{ $hogar['jefe_hogar']->clasificacion ?? 'N/A' }}</span></p>
                                    @else
                                        <p class="text-yellow-600 dark:text-yellow-400">No se encontró un titular asignado para este hogar.</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Tabla de Integrantes --}}
                            <div>
                                <h4 class="text-md font-semibold mb-3 text-gray-800 dark:text-gray-200"><i class="fas fa-users mr-2"></i>Integrantes del Hogar ({{ $hogar['miembros']->count() }})</h4>
                                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-100 dark:bg-gray-700">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID Persona</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre Completo</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Documento</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tel. Contacto</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Clasificación</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($hogar['miembros'] as $miembro)
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 {{ $miembro->num_documento == $cedula_buscada ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm">{{ $miembro->ide_persona }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900 dark:text-white">{{ $miembro->nombre_persona_hogar_concatenado }}</td>
                                                    <td class="px-4 py-3">{{ $miembro->num_documento }}</td>
                                                    <td class="px-4 py-3">{{ $miembro->num_tel_contacto ?? 'N/A' }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-mono">{{ $miembro->cod_calificacion }} ({{ $miembro->clasificacion }})</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Estado sin resultados --}}
                    <div id="no-results-state" class="text-center py-16">
                        <i class="fas fa-exclamation-circle text-6xl text-yellow-500 mb-4"></i>
                        <h2 class="text-2xl font-semibold">Sin Resultados</h2>
                        <p class="text-gray-500 dark:text-gray-400">No se encontró información para la cédula <strong>{{ $cedula_buscada }}</strong>.</p>
                    </div>
                @endforelse

            @else
                {{-- Estado inicial --}}
                <div id="initial-state" class="text-center py-16 text-gray-500 dark:text-gray-400">
                    <i class="fas fa-file-alt text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                    <h2 class="text-2xl font-semibold">Listo para tu consulta</h2>
                    <p>Ingresa una cédula para ver la información del Sisbén.</p>
                </div>
            @endisset
        </div>
    </div>

<script>
$(document).ready(function() {
    
    // --- MANEJO DEL FORMULARIO (PARA MOSTRAR ESTADO DE CARGA) ---
    $('#search-form').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío tradicional del formulario

        const cedula = $('#cedula').val().trim();

        // Validar que la cédula no esté vacía y sea numérica
        if (cedula && /^\d+$/.test(cedula)) {
            // Ocultar resultados y mostrar estado de carga
            $('#results-area').hide();
            $('#loading-state').removeClass('hidden').show(); // Asegurarse de que esté visible

            // Construir la nueva URL y redirigir
            const searchUrl = `{{ url('/sisben/consulta') }}/${cedula}`;
            window.location.href = searchUrl;
        } else {
            // Opcional: mostrar un mensaje de error si la cédula no es válida
            alert('Por favor, ingrese un número de cédula válido.');
        }
    });

    // --- MANEJO DEL TEMA (MODO OSCURO/CLARO) ---
    const themeToggle = $('#theme-toggle');
    const themeIcon = $('#theme-icon');
    
    // Función para aplicar el tema
    const applyTheme = (theme) => {
        if (theme === 'dark') {
            $('html').addClass('dark');
            themeIcon.removeClass('fa-moon').addClass('fa-sun');
        } else {
            $('html').removeClass('dark');
            themeIcon.removeClass('fa-sun').addClass('fa-moon');
        }
    };

    // Cargar el tema guardado o el del sistema
    const savedTheme = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
        applyTheme('dark');
    } else {
        applyTheme('light');
    }

    // Listener para el botón de cambio de tema
    themeToggle.on('click', function() {
        const isDark = $('html').hasClass('dark');
        const newTheme = isDark ? 'light' : 'dark';
        localStorage.setItem('theme', newTheme);
        applyTheme(newTheme);
    });
});
</script>

</body>
</html>
