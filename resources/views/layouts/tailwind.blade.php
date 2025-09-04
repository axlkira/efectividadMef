<!DOCTYPE html>
<html lang="es" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Observatorio Sisbén')</title>
    <!-- Tailwind CSS, jQuery y Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Estilos para transiciones suaves y mejor UX */
        body, input, button {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
    </style>
    <script>
        // Habilitar modo oscuro en Tailwind
        tailwind.config = { darkMode: 'class' }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans antialiased">

    <!-- Menú Lateral (Sidebar) -->
    <aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full lg:translate-x-0 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto">
            <a href="#" class="flex items-center pl-2.5 mb-5">
                <i class="fas fa-chart-bar text-2xl text-blue-600 dark:text-blue-500"></i>
                <span class="self-center text-xl font-semibold whitespace-nowrap ml-3 text-gray-800 dark:text-white">Observatorio</span>
            </a>
            <ul class="space-y-2 font-medium">
                @if(isset($documento_profesional) && $documento_profesional)
                <li>
                    <a href="https://unidadfamiliamedellin.com.co/metodologia2servidor/index.php/c_principalservidor/fc_principalservidor?documento={{ $documento_profesional }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="fas fa-tachometer-alt w-5 h-5 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ isset($documento_profesional) ? route('sisben.index', ['documento_profesional' => $documento_profesional]) : route('sisben.index') }}" class="flex items-center p-2 text-white bg-blue-600 rounded-lg dark:bg-blue-700 group">
                        <i class="fas fa-id-card w-5 h-5"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Consulta Sisbén</span>
                    </a>
                </li>
                <li>
                    <a href="https://unidadfamiliamedellin.com.co/metodologia2servidor/index.php/c_login/fc_vlogin" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="fas fa-sign-out-alt w-5 h-5 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"></i>
                        <span class="ml-3">Salir</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-30 hidden lg:hidden"></div>

    <!-- Contenido Principal -->
    <div class="lg:ml-64">
        <!-- Barra de Navegación Superior -->
        <nav class="sticky top-0 z-30 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700">
            <div class="px-4 py-3">
                <div class="flex items-center justify-between lg:justify-end">
                    <!-- Botón de Hamburguesa (solo en móvil) -->
                    <button id="sidebar-toggle" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none dark:text-gray-400 dark:hover:bg-gray-700">
                        <span class="sr-only">Abrir menú</span>
                        <i class="fas fa-bars w-6 h-6"></i>
                    </button>
                    <!-- Botón de Tema -->
                    <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-sm p-2.5">
                        <i id="theme-icon" class="fas fa-moon"></i>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Contenido de la Página Específica -->
        <main class="p-4 md:p-6">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            // --- MANEJO DEL TEMA (MODO OSCURO/CLARO) ---
            const themeToggle = $('#theme-toggle');
            const themeIcon = $('#theme-icon');
            const applyTheme = (theme) => {
                if (theme === 'dark') {
                    $('html').addClass('dark');
                    themeIcon.removeClass('fa-moon').addClass('fa-sun');
                } else {
                    $('html').removeClass('dark');
                    themeIcon.removeClass('fa-sun').addClass('fa-moon');
                }
            };
            const savedTheme = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const currentTheme = savedTheme || (systemPrefersDark ? 'dark' : 'light');
            applyTheme(currentTheme);
            themeToggle.on('click', () => {
                const newTheme = $('html').hasClass('dark') ? 'light' : 'dark';
                localStorage.setItem('theme', newTheme);
                applyTheme(newTheme);
            });

            // --- MANEJO DEL MENÚ LATERAL ---
            const sidebar = $('#sidebar');
            const sidebarToggle = $('#sidebar-toggle');
            const sidebarOverlay = $('#sidebar-overlay');

            function openSidebar() {
                sidebar.removeClass('-translate-x-full');
                sidebarOverlay.removeClass('hidden');
            }

            function closeSidebar() {
                sidebar.addClass('-translate-x-full');
                sidebarOverlay.addClass('hidden');
            }

            sidebarToggle.on('click', function(e) {
                e.stopPropagation();
                if (sidebar.hasClass('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });

            sidebarOverlay.on('click', function() {
                closeSidebar();
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
