@extends('layouts.tailwind')

@section('title', 'Consulta Sisbén')

@section('content')

<!-- Encabezado -->
<header class="mb-6">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-200 flex items-center gap-3">
        <i class="fas fa-search-location text-blue-600 dark:text-blue-500"></i>
        <span>Módulo de Consulta Sisbén</span>
    </h1>
</header>

<!-- Formulario de Búsqueda -->
<div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md mb-8">
    <form id="search-form">
        <label for="cedula" class="block text-lg font-medium mb-2 text-gray-700 dark:text-gray-300">Consultar por Cédula</label>
        <div class="flex flex-col sm:flex-row gap-4">
                        <input type="text" id="cedula" name="cedula" value="{{ $cedula_buscada ?? old('cedula') }}" class="flex-grow w-full px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Digite el número de documento" required>
            <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg flex items-center justify-center gap-2">
                <i class="fas fa-search"></i>
                <span>Buscar</span>
            </button>
        </div>
    </form>
</div>

<!-- Sección de Resultados -->
<div id="results-area">
    @isset($resultados)
        <!-- Resumen Global -->
        <div class="mb-8 p-4 border-l-4 border-blue-500 bg-white dark:bg-gray-800 rounded-r-lg shadow-md flex flex-wrap justify-between items-center gap-4">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Fecha de Corte</p>
                <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $fechaCorte }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Total de Hogares en el Sistema</p>
                <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ number_format($totalHogares, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Total de Integrantes en el Sistema</p>
                <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ number_format($totalIntegrantes, 0, ',', '.') }}</p>
            </div>
        </div>

        @if ($resultados->count() > 0)
            <h2 class="text-2xl font-bold mb-4 text-gray-700 dark:text-gray-300">Hogares Encontrados para {{ $cedula_buscada }} ({{ $resultados->count() }})</h2>
        @endif

        @forelse ($resultados as $hogar)
            <!-- Tarjeta por cada hogar -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-blue-600 dark:text-blue-400"><i class="fas fa-home mr-2"></i>Ficha: {{ $hogar['info_general']->ide_ficha_origen ?? 'N/A' }}</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                        <!-- Info Hogar -->
                        <div class="space-y-3 p-4 bg-green-50 dark:bg-green-900/30 rounded-lg border border-green-200 dark:border-green-800 text-gray-700 dark:text-gray-300">
                             <h4 class="text-md font-semibold border-b pb-2 mb-3 border-green-300 dark:border-green-700 text-green-800 dark:text-green-300 flex items-center"><i class="fas fa-map-marker-alt mr-3 text-green-500"></i>Información del Hogar</h4>
                             <p><strong>Dirección:</strong> {{ $hogar['info_general']->dir_vivienda ?? 'No especificada' }}</p>
                                                          <p><strong>Comuna:</strong> {{ isset($hogar['info_general']->comuna) ? $hogar['info_general']->comuna->nombre_comuna_corregimiento : 'N/A' }}</p>
                                                          <p><strong>Barrio:</strong> {{ isset($hogar['info_general']->barrio) ? $hogar['info_general']->barrio->nombre_barrio_vereda : 'N/A' }}</p>
                             <p><strong>Teléfono:</strong> {{ $hogar['info_general']->num_tel_contacto ?? 'N/A' }}</p>
                        </div>
                        <!-- Info Titular -->
                        <div class="space-y-3 p-4 bg-purple-50 dark:bg-purple-900/30 rounded-lg border border-purple-200 dark:border-purple-800 text-gray-700 dark:text-gray-300">
                            <h4 class="text-md font-semibold border-b pb-2 mb-3 border-purple-300 dark:border-purple-700 text-purple-800 dark:text-purple-300 flex items-center"><i class="fas fa-user-shield mr-3"></i>Titular del Hogar</h4>
                            @if ($hogar['jefe_hogar'])
                                <p><strong>Nombre:</strong> {{ $hogar['jefe_hogar']->nombre_persona_hogar_concatenado }}</p>
                                <p><strong>Documento:</strong> {{ $hogar['jefe_hogar']->num_documento }}</p>
                            @else
                                <p class="text-yellow-600 dark:text-yellow-400">No se encontró un titular.</p>
                            @endif
                        </div>
                    </div>
                    <!-- Tabla de Integrantes -->
                    <div>
                        <h4 class="text-md font-semibold mb-3 text-gray-800 dark:text-gray-200"><i class="fas fa-users mr-2"></i>Integrantes del Hogar ({{ $hogar['miembros']->count() }})</h4>
                        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nombre</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Documento</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Clasificación</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($hogar['miembros'] as $miembro)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 {{ $miembro->num_documento == $cedula_buscada ? 'bg-blue-100 dark:bg-blue-900/30' : '' }}">
                                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $miembro->nombre_persona_hogar_concatenado }}</td>
                                                                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $miembro->num_documento }}</td>
                                                                                        <td class="px-4 py-3 font-mono text-gray-700 dark:text-gray-300">{{ $miembro->clasificacion }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16">
                <i class="fas fa-exclamation-circle text-6xl text-yellow-500 mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-300">Sin Resultados</h2>
                <p class="text-gray-500 dark:text-gray-400">No se encontró información para el documento <strong>{{ $cedula_buscada }}</strong>.</p>
            </div>
        @endforelse
    @else
        <!-- Estado Inicial -->
        <div class="text-center py-16 text-gray-500 dark:text-gray-400">
            <i class="fas fa-file-alt text-6xl text-gray-400 dark:text-gray-600 mb-4"></i>
            <h2 class="text-2xl font-semibold">Listo para tu consulta</h2>
            <p>Ingresa un documento para ver la información del Sisbén.</p>
        </div>
    @endisset
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            var cedula = $('#cedula').val().trim();
            if (cedula) {
                let url = `{{ url('sisben/consulta') }}/${cedula}`;
                @if(isset($documento_profesional) && $documento_profesional)
                    url += `/{{ $documento_profesional }}`;
                @endif
                window.location.href = url;
            }
        });
    });
</script>
@endsection
