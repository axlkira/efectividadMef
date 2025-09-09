<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Encuestas de Satisfacción</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff', 100: '#e0f2fe', 200: '#bae6fd',
                            300: '#7dd3fc', 400: '#38bdf8', 500: '#0ea5e9',
                            600: '#0284c7', 700: '#0369a1', 800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
        .modal-overlay {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(3px);
        }
        .modal-content {
            max-height: 90vh;
        }
        .required-field::after {
            content: "*";
            color: #ef4444;
            margin-left: 2px;
        }
        /* DataTables Light Mode */
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate .paginate_button { color: #475569 !important; }
        .dataTables_wrapper .dataTables_filter input, .dataTables_wrapper .dataTables_length select { background-color: #f8fafc; border: 1px solid #e2e8f0; }
        table.dataTable thead th { color: #475569; border-bottom: 1px solid #e2e8f0; }
        table.dataTable tbody td { color: #334155; border-bottom: 1px solid #f1f5f9; }
        
        /* DataTables Dark Mode */
        .dark .dataTables_wrapper .dataTables_length, .dark .dataTables_wrapper .dataTables_filter, .dark .dataTables_wrapper .dataTables_info, .dark .dataTables_wrapper .dataTables_paginate .paginate_button { color: #94a3b8 !important; }
        .dark .dataTables_wrapper .dataTables_filter input, .dark .dataTables_wrapper .dataTables_length select { background-color: #1e293b; border: 1px solid #334155; color: #f1f5f9; }
        .dark table.dataTable thead th { color: #94a3b8; border-bottom: 1px solid #334155; }
        .dark table.dataTable tbody td { color: #cbd5e1; border-bottom: 1px solid #334155; }
        .dark table.dataTable tbody tr:hover { background-color: #1e293b; }

        /* DataTables General */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #0ea5e9 !important; color: white !important; }

    </style>
    <script>
        // Set theme on initial load
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 h-full">
    
    <div class="flex h-full">
        <!-- Desktop Sidebar -->
        <aside class="sidebar bg-white dark:bg-gray-800 w-64 flex-shrink-0 h-full shadow-lg hidden md:flex flex-col">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="bg-primary-500 w-10 h-10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-poll text-white text-xl"></i>
                    </div>
                    <h1 class="text-xl font-bold ml-3 dark:text-white">Efectividad MEF
                </div>
            </div>
            
            <nav class="mt-5 flex-1">
                <a href="#" class="flex items-center px-5 py-3 text-primary-500 bg-primary-50 dark:bg-gray-700 font-medium">
                    <i class="fas fa-users mr-3"></i> Gestión de Usuarios
                </a>
                <a href="#" class="flex items-center px-5 py-3 text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                    <i class="fas fa-chart-bar mr-3"></i> Reportes
                </a>
            </nav>
            
            <div class="p-5 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-gray-700 flex items-center justify-center">
                        <i class="fas fa-user text-primary-500 dark:text-primary-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium dark:text-white">Administrador</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">admin@encuestasapp.com</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar -->
        <div id="mobile-sidebar" class="fixed inset-0 z-40 hidden md:hidden">
            <div id="mobile-sidebar-overlay" class="absolute inset-0 bg-gray-900/50"></div>
            <aside class="sidebar-mobile relative bg-white dark:bg-gray-800 w-64 h-full shadow-lg flex flex-col transition-transform duration-300 ease-in-out -translate-x-full">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="bg-primary-500 w-10 h-10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-poll text-white text-xl"></i>
                        </div>
                        <h1 class="text-xl font-bold ml-3 dark:text-white">EncuestasApp</h1>
                    </div>
                    <button id="close-mobile-menu" class="text-gray-500 dark:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                 <nav class="mt-5 flex-1">
                    <a href="#" class="flex items-center px-5 py-3 text-primary-500 bg-primary-50 dark:bg-gray-700 font-medium">
                        <i class="fas fa-users mr-3"></i> Gestión de Usuarios
                    </a>
                    <a href="#" class="flex items-center px-5 py-3 text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                        <i class="fas fa-chart-bar mr-3"></i> Reportes
                    </a>
                </nav>
                <div class="p-5 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-gray-700 flex items-center justify-center">
                            <i class="fas fa-user text-primary-500 dark:text-primary-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium dark:text-white">Administrador</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">admin@encuestasapp.com</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
        
        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 shadow-sm">
                <div class="flex items-center justify-between px-4 py-3">
                    <div class="flex items-center">
                        <button id="mobile-menu-button" class="md:hidden text-gray-500 dark:text-gray-300 mr-3">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h2 class="text-lg font-semibold dark:text-white">Gestión de Usuarios</h2>
                    </div>
                    
                    <div class="flex items-center">
                        <button id="theme-toggle" class="p-2 rounded-full text-gray-700 dark:text-yellow-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-sun dark:hidden"></i>
                            <i class="fas fa-moon hidden dark:block"></i>
                        </button>
                    </div>
                </div>
            </header>
            
            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-gray-100 dark:bg-gray-900">
                <div class="max-w-7xl mx-auto">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5"><div class="flex justify-between"><div><p class="text-gray-500 dark:text-gray-400 text-sm">Total Usuarios</p><p class="text-2xl font-bold dark:text-white">3,086</p></div><div class="w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center"><i class="fas fa-users text-blue-500 dark:text-blue-400"></i></div></div></div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5"><div class="flex justify-between"><div><p class="text-gray-500 dark:text-gray-400 text-sm">Encuestas Completadas</p><p class="text-2xl font-bold dark:text-white">1,115</p></div><div class="w-12 h-12 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center"><i class="fas fa-check-circle text-green-500 dark:text-green-400"></i></div></div></div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5"><div class="flex justify-between"><div><p class="text-gray-500 dark:text-gray-400 text-sm">Satisfacción Promedio</p><p class="text-2xl font-bold dark:text-white">4.5/5</p></div><div class="w-12 h-12 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center"><i class="fas fa-star text-yellow-500 dark:text-yellow-400"></i></div></div></div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5"><div class="flex justify-between"><div><p class="text-gray-500 dark:text-gray-400 text-sm">Pendientes</p><p class="text-2xl font-bold dark:text-white">189</p></div><div class="w-12 h-12 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center"><i class="fas fa-clock text-red-500 dark:text-red-400"></i></div></div></div>
                    </div>
                    
                    <!-- Users Table -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
                         <div class="overflow-x-auto p-4">
                            <table id="usersTable" class="display w-full">
                                <thead>
                                    <tr>
                                        <th>Folio</th>
                                        <th>Nombre</th>
                                        <th>Comuna</th>
                                        <th>Barrio</th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
                                        <th>Celular</th>
                                        <th>Línea Estación</th>
                                        <th>Fecha Visita</th>
                                        <th>Encuesta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usuarios as $usuario)
                                    <tr>
                                        <td>{{ $usuario->folio }}</td>
                                        <td>{{ $usuario->nombre1 }} {{ $usuario->nombre2 }} {{ $usuario->apellido1 }} {{ $usuario->apellido2 }}</td>
                                        <td>{{ $usuario->comuna }}</td>
                                        <td>{{ $usuario->barrio }}</td>
                                        <td>{{ $usuario->direccion }}</td>
                                        <td>{{ $usuario->telefono }}</td>
                                        <td>{{ $usuario->celular }}</td>
                                        <td>{{ $usuario->descripcion_linea }}</td>
                                        <td>{{ $usuario->fecharegistro }}</td>
                                        <td>
                                            <button class='open-survey-btn text-primary-500 hover:text-primary-700' data-folio="{{ $usuario->folio }}">
                                                <i class='fas fa-poll mr-1'></i> Encuesta
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Survey Modal -->
    <div id="survey-modal" class="fixed inset-0 z-50 hidden">
        <div class="modal-overlay absolute w-full h-full"></div>
        
        <div class="absolute w-full h-full flex items-center justify-center p-4">
            <div class="modal-content bg-white dark:bg-gray-800 w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2 rounded-xl shadow-xl flex flex-col">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-xl font-semibold dark:text-white">Encuesta de Satisfacción: Folio <span id="modalFolio" class="text-primary-500"></span></h3>
                    <button id="close-modal-btn" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="p-6 flex-1 overflow-y-auto">
                    <form id="surveyForm" class="space-y-6" novalidate>
                        <!-- Question Cards will be dynamically inserted here -->
                    </form>
                </div>
                
                <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex justify-end bg-gray-50 dark:bg-gray-800/50 rounded-b-xl">
                    <button id="cancel-survey-btn" type="button" class="px-4 py-2 mr-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">Cancelar</button>
                    <button id="submit-survey-btn" type="submit" class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition">Guardar Encuesta</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="fixed inset-0 z-50 hidden">
        <div class="modal-overlay absolute w-full h-full"></div>
        <div class="absolute w-full h-full flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-xl shadow-xl text-center p-8">
                <div class="w-24 h-24 mx-auto bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-5xl text-green-500"></i>
                </div>
                <h3 class="text-2xl font-bold mt-6 dark:text-white">¡Éxito!</h3>
                <p class="text-gray-600 dark:text-gray-300 mt-2">La encuesta ha sido guardada correctamente.</p>
                <button id="close-success-modal" class="mt-8 px-6 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition w-full">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <div id="toast"></div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            // --- THEME SWITCHER ---
            const themeToggle = $('#theme-toggle');
            const htmlEl = $('html');
            themeToggle.on('click', function() {
                htmlEl.toggleClass('dark');
                localStorage.setItem('theme', htmlEl.hasClass('dark') ? 'dark' : 'light');
                updateThemeIcon();
            });

            function updateThemeIcon() {
                if (htmlEl.hasClass('dark')) {
                    themeToggle.find('.fa-sun').addClass('hidden');
                    themeToggle.find('.fa-moon').removeClass('hidden');
                } else {
                    themeToggle.find('.fa-sun').removeClass('hidden');
                    themeToggle.find('.fa-moon').addClass('hidden');
                }
            }
            updateThemeIcon();

            // --- MOBILE SIDEBAR ---
            const mobileMenuButton = $('#mobile-menu-button');
            const mobileSidebar = $('#mobile-sidebar');
            const mobileSidebarContent = mobileSidebar.find('.sidebar-mobile');
            const closeMobileMenu = $('#close-mobile-menu');
            const mobileSidebarOverlay = $('#mobile-sidebar-overlay');

            mobileMenuButton.on('click', function() {
                mobileSidebar.removeClass('hidden');
                setTimeout(() => {
                    mobileSidebarContent.removeClass('-translate-x-full');
                }, 10);
            });

            function hideMobileMenu() {
                mobileSidebarContent.addClass('-translate-x-full');
                setTimeout(() => {
                    mobileSidebar.addClass('hidden');
                }, 300);
            }

            closeMobileMenu.on('click', hideMobileMenu);
            mobileSidebarOverlay.on('click', hideMobileMenu);

            // --- DATATABLE INITIALIZATION ---
            const table = $('#usersTable').DataTable({
                responsive: true,
                language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' }
            });

            // --- SURVEY MODAL ---
            const surveyModal = $('#survey-modal');
            const successModal = $('#success-modal');
            const surveyForm = $('#surveyForm');
            const questions = [
                { id: 'status', type: 'select', label: 'Estado de la encuesta', options: ['Seleccione', 'Finalización efectiva', 'Contactar después', 'No quiere atender', 'Teléfonos errados'] },
                { id: 'serviceSatisfaction', type: 'radio', label: 'Respecto al servicio, te sentiste:', options: ['Muy insatisfecho', 'Insatisfecho', 'Neutral', 'Satisfecho', 'Muy satisfecho'] },
                { id: 'opportunityHelpful', type: 'radio', label: '¿Te sirvió alguna oportunidad brindada?', options: ['Sí', 'No'] },
                { id: 'managerTreatment', type: 'radio', label: '¿Cómo te sentiste con el trato del gestor?', options: ['Muy insatisfecho', 'Insatisfecho', 'Neutral', 'Satisfecho', 'Muy satisfecho'] },
                { id: 'likedAspect', type: 'select', label: '¿Qué aspecto te gustó más?', options: ['Seleccione', 'Las oportunidades', 'Las actividades y talleres', 'El trato del gestor', 'Ninguno', 'Todos'] },
                { id: 'dislikedAspect', type: 'select', label: '¿Qué aspecto te gustó menos?', options: ['Seleccione', 'Las oportunidades', 'Las actividades y talleres', 'El trato del gestor', 'Todo me agradó'] },
                { id: 'respondentName', type: 'text', label: 'Nombre de quien contesta' },
                { id: 'respondentPhone', type: 'tel', label: 'Número telefónico de contacto' }
            ];

            function buildSurveyForm() {
                let formHtml = '';
                questions.forEach(q => {
                    formHtml += `<div class="question-card bg-gray-50 dark:bg-gray-700/60 p-5 rounded-lg">`;
                    formHtml += `<label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 required-field">${q.label}</label>`;
                    if (q.type === 'select') {
                        formHtml += `<select name="${q.id}" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500" required>`;
                        q.options.forEach(opt => formHtml += `<option value="${opt === 'Seleccione' ? '' : opt}">${opt}</option>`);
                        formHtml += `</select>`;
                    } else if (q.type === 'radio') {
                        formHtml += `<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">`;
                        q.options.forEach(opt => {
                            formHtml += `<label class="flex items-center p-3 bg-white dark:bg-gray-600 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-500 transition-all duration-200"><input type="radio" name="${q.id}" value="${opt}" class="h-4 w-4 text-primary-500 focus:ring-primary-500" required><span class="ml-2 text-sm dark:text-gray-200">${opt}</span></label>`;
                        });
                        formHtml += `</div>`;
                    } else { // text, tel, etc.
                        formHtml += `<input type="${q.type}" name="${q.id}" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500" required>`;
                    }
                    formHtml += `</div>`;
                });
                surveyForm.html(formHtml);
            }

            function openSurveyModal(folio) {
                $('#modalFolio').text(folio);
                buildSurveyForm();
                surveyModal.removeClass('hidden');
            }

            function closeSurveyModal() {
                surveyModal.addClass('hidden');
                surveyForm.html(''); // Clear form to rebuild next time
            }

            function showSuccessModal() {
                closeSurveyModal();
                successModal.removeClass('hidden');
            }

            function hideSuccessModal() {
                successModal.addClass('hidden');
            }

            $('#usersTable tbody').on('click', '.open-survey-btn', function() {
                const folio = $(this).data('folio');
                openSurveyModal(folio);
            });

            $('#close-modal-btn, #cancel-survey-btn, .modal-overlay').on('click', closeSurveyModal);
            $('#close-success-modal').on('click', hideSuccessModal);

            $('#submit-survey-btn').on('click', function(e) {
                e.preventDefault();
                let isValid = true;
                surveyForm.find('[required]').each(function() {
                     $(this).closest('.question-card').removeClass('border-2 border-red-500');
                    if ($(this).is(':radio') && !$(`input[name=${this.name}]:checked`).val()) {
                        isValid = false;
                        $(this).closest('.question-card').addClass('border-2 border-red-500');
                    } else if ($(this).is('select, input[type=text], input[type=tel]') && !$(this).val()) {
                         isValid = false;
                         $(this).closest('.question-card').addClass('border-2 border-red-500');
                    }
                });

                if (isValid) {
                    // Obtener datos del formulario
                    const formData = new FormData(surveyForm[0]);
                    const folio = $('#modalFolio').text();
                    
                    // Buscar el idintegrantetitular del folio actual
                    let idintegrantetitular = '';
                    $('#usersTable tbody tr').each(function() {
                        if ($(this).find('td:first').text() === folio) {
                            idintegrantetitular = $(this).find('.open-survey-btn').data('folio');
                        }
                    });
                    
                    // Preparar datos para enviar
                    const data = {
                        folio: folio,
                        idintegrantetitular: idintegrantetitular,
                        documento_profesional: {{ request()->route('documento_profesional') }},
                        status: formData.get('status'),
                        serviceSatisfaction: formData.get('serviceSatisfaction'),
                        opportunityHelpful: formData.get('opportunityHelpful'),
                        managerTreatment: formData.get('managerTreatment'),
                        likedAspect: formData.get('likedAspect'),
                        dislikedAspect: formData.get('dislikedAspect'),
                        respondentName: formData.get('respondentName'),
                        respondentPhone: formData.get('respondentPhone'),
                        _token: '{{ csrf_token() }}'
                    };
                    
                    // Enviar datos al servidor
                    $.ajax({
                        url: '{{ route("efectividad-mef.guardar-encuesta") }}',
                        type: 'POST',
                        data: data,
                        success: function(response) {
                            if (response.success) {
                                showSuccessModal();
                            }
                        },
                        error: function() {
                            showToast('Error al guardar la encuesta.', 'error');
                        }
                    });
                } else {
                    showToast('Por favor, complete todos los campos obligatorios.', 'error');
                }
            });

            function showToast(message, type = 'error') {
                const toast = $('#toast');
                toast.text(message).removeClass('success error').addClass(type).addClass('show');
                setTimeout(() => { toast.removeClass('show'); }, 3000);
            }
        });
    </script>
</body>
</html>
