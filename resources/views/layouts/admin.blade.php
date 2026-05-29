<!DOCTYPE html>
<html lang="en" dir="ltr" data-color-theme="Blue_Theme" class="light selected" data-layout="vertical"
    data-boxed-layout="boxed" data-card="shadow">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Donezo Data Center</title>

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo-amt.webp') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @stack('styles')
    
    <style>
        body, #main-wrapper, .page-wrapper, .DEFAULT_THEME {
            background-color: #f8fafc !important; /* Cool grey background */
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        .container {
            max-width: 1440px !important;
        }

        .table-responsive {
            overflow-x: auto;
            max-width: 100%;
        }

        #datatable thead tr.filters th {
            padding: 10px 1px;
            font-weight: 100 !important
        }

        #datatable thead tr th,
        #datatable tbody tr td {
            white-space: nowrap;
        }

        /* Donezo Premium DataTables Styling Overrides */
        #datatable, table.dataTable, #dataTable-table, .dataTables_wrapper table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin: 1.5rem 0 !important;
            border: 1px solid #f1f5f9 !important;
            border-radius: 16px !important;
            overflow: hidden !important;
            background-color: #ffffff !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05) !important;
        }
        #datatable thead tr, table.dataTable thead tr, #dataTable-table thead tr {
            background-color: #f8fafc !important;
            border-bottom: 2px solid #e2e8f0 !important;
        }
        #datatable thead th, table.dataTable thead th, #dataTable-table thead th {
            padding: 1rem 1.5rem !important;
            text-align: left !important;
            font-size: 0.75rem !important;
            font-weight: 800 !important;
            color: #64748b !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
        }
        #datatable tbody tr, table.dataTable tbody tr, #dataTable-table tbody tr {
            transition: background-color 0.2s ease-in-out !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }
        #datatable tbody tr:hover, table.dataTable tbody tr:hover, #dataTable-table tbody tr:hover {
            background-color: #f8fafc !important;
        }
        #datatable tbody td, table.dataTable tbody td, #dataTable-table tbody td {
            padding: 1rem 1.5rem !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            color: #334155 !important;
            vertical-align: middle !important;
        }
        .dt-paging-button {
            border-radius: 50% !important;
        }
    </style>
</head>

<body class="DEFAULT_THEME bg-[#f8fafc]">

    <!-- Modal Confirmation -->
    @include('layouts.partials.admin.modal-confirmation')

    <main>
        <!--start the project-->
        <div id="main-wrapper" class="flex p-0 xl:p-5 gap-6 min-h-screen">

            <!-- Donezo Vertical Sidebar -->
            @include('layouts.partials.admin.vertical-sidebar')
            <!-- Donezo Vertical Sidebar End -->

            <div class="page-wrapper w-full flex-grow xl:ps-[290px] ps-0 pt-0 pe-0" role="main">

                <!-- Main Content -->
                <main class="h-full py-5 px-4 xl:px-6">
                    
                    {{-- Custom Donezo Header / Topbar --}}
                    <header class="w-full bg-white border border-slate-100 rounded-2xl p-4 mb-6 shadow-sm flex items-center justify-between">
                        {{-- Left: Search Task Input --}}
                        <div class="flex items-center gap-3 flex-grow max-w-md">
                            {{-- Mobile Sidebar Toggle Button --}}
                            <a class="xl:hidden p-2 text-slate-500 hover:text-emerald-700 hover:bg-slate-50 rounded-lg cursor-pointer sidebartoggler"
                                data-hs-overlay="#application-sidebar-brand"
                                aria-controls="application-sidebar-brand" aria-label="Toggle navigation">
                                <iconify-icon icon="solar:list-bold-duotone" class="text-2xl"></iconify-icon>
                            </a>
                            
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-400">
                                    <iconify-icon icon="lucide:search" class="text-lg"></iconify-icon>
                                </div>
                                <input type="text" placeholder="Search task" class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-emerald-500/20 text-slate-700 placeholder-slate-400 text-xs rounded-xl py-2.5 ps-10 pe-12 font-medium focus:outline-none transition-all">
                                <div class="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
                                    <kbd class="hidden sm:inline-block px-1.5 py-0.5 text-[9px] font-black text-slate-400 bg-white border border-slate-200 rounded-md">⌘ F</kbd>
                                </div>
                            </div>
                        </div>

                        {{-- Right: Mail, Notification, and User Profile --}}
                        <div class="flex items-center gap-4">
                            {{-- Envelope --}}
                            <a href="#" class="size-10 rounded-full border border-slate-100 hover:border-slate-200 flex items-center justify-center text-slate-500 hover:text-emerald-700 hover:bg-slate-50 transition-all shrink-0">
                                <iconify-icon icon="lucide:mail" class="text-lg"></iconify-icon>
                            </a>

                            {{-- Bell Notification --}}
                            <a href="#" class="relative size-10 rounded-full border border-slate-100 hover:border-slate-200 flex items-center justify-center text-slate-500 hover:text-emerald-700 hover:bg-slate-50 transition-all shrink-0">
                                <iconify-icon icon="lucide:bell" class="text-lg"></iconify-icon>
                                <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-emerald-600 rounded-full ring-2 ring-white"></span>
                            </a>

                            <div class="h-6 w-px bg-slate-200 mx-1"></div>

                            {{-- Profile block matching Totok Michael --}}
                            <div class="flex items-center gap-3 pl-1 select-none">
                                <img class="w-10 h-10 rounded-full border border-emerald-100 object-cover shadow-sm shrink-0"
                                     src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=f0fdf4&color=0f513d&size=64" alt="Avatar">
                                <div class="hidden sm:block text-left">
                                    <p class="text-xs font-black text-slate-800 leading-snug">{{ auth()->user()->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 mt-0.5 leading-none">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>
                    </header>

                    <!------Container-------->
                    <div class="max-w-full w-full">
                        <div class="w-full">
                            @yield('content')
                        </div>
                    </div>
                    <!-------End Container------->

                </main>
                <!-- Main Content End -->
            </div>
        </div>
        <!--end of project-->
    </main>

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.init.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/iconify-icon/dist/iconify-icon.min.js') }}"></script>
    <script src="{{ asset('assets/libs/preline/dist/preline.js') }}"></script>
    <script src="{{ asset('assets/libs/@preline/input-number/index.js') }}"></script>
    <script src="{{ asset('assets/libs/@preline/tooltip/index.js') }}"></script>
    <script src="{{ asset('assets/libs/@preline/stepper/index.js') }}"></script>

    <script>
        // Connect headerCollapse to mini-sidebar functionality
        document.addEventListener('DOMContentLoaded', function() {
            const togglers = document.querySelectorAll('.sidebartoggler');
            togglers.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const sidebar = document.getElementById('application-sidebar-brand');
                    if (sidebar) {
                        sidebar.classList.toggle('hidden');
                        sidebar.classList.toggle('-translate-x-full');
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
