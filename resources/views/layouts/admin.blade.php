<!DOCTYPE html>
<html lang="en" dir="ltr" data-color-theme="Blue_Theme" class="light selected" data-layout="vertical"
    data-boxed-layout="boxed" data-card="shadow">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - AMT DATA CENTER</title>

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/data-center.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @stack('styles')
    <style>
        /* Red Background Utilities */

        .bg-red-100 {
            background-color: #fee2e2;
        }

        .bg-red-200 {
            background-color: #fecaca;
        }

        .bg-red-300 {
            background-color: #fca5a5;
        }

        .bg-red-400 {
            background-color: #f87171;
        }

        .bg-red-500 {
            background-color: #ef4444;
        }

        .bg-red-600 {
            background-color: #dc2626;
        }

        .bg-red-700 {
            background-color: #b91c1c;
        }


        .text-red-100 {
            color: #fee2e2;
        }

        .text-red-200 {
            color: #fecaca;
        }

        .text-red-300 {
            color: #fca5a5;
        }

        .text-red-400 {
            color: #f87171;
        }

        .text-red-500 {
            color: #ef4444;
        }

        .text-red-600 {
            color: #dc2626;
        }

        .text-red-700 {
            color: #b91c1c;
        }

        .dt-paging-button {
            border-radius: 50% !important;
        }

        .container {
            max-width: 1345px !important;
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

        /* Collapse Sidebar Hide Menu */
        body[data-sidebartype="mini-sidebar"] .left-sidebar .hide-menu {
            display: none !important;
        }
        body[data-sidebartype="mini-sidebar"] .left-sidebar:hover .hide-menu {
            display: block !important;
        }

        /* Centering elements when collapsed (not hovered) */
        body[data-sidebartype="mini-sidebar"] .left-sidebar:not(:hover) .p-3.5 {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        body[data-sidebartype="mini-sidebar"] .left-sidebar:not(:hover) .brand-logo {
            width: auto !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            overflow: visible !important;
        }
        body[data-sidebartype="mini-sidebar"] .left-sidebar:not(:hover) .brand-logo img {
            width: 40px !important;
            max-width: 40px !important;
        }
        body[data-sidebartype="mini-sidebar"] .left-sidebar:not(:hover) .mini-layout {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        body[data-sidebartype="mini-sidebar"] .left-sidebar:not(:hover) .sidebar-link {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        body[data-sidebartype="mini-sidebar"] .left-sidebar:not(:hover) .sidebar-link i {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        body[data-sidebartype="mini-sidebar"] .left-sidebar:not(:hover) .sidebar-link::before {
            left: 0 !important;
            width: 100% !important;
            border-radius: 8px !important;
        }

        /* Force hide all active dropdown submenu contents in mini sidebar when not hovered */
        body[data-sidebartype="mini-sidebar"] .left-sidebar:not(:hover) .hs-accordion-content {
            display: none !important;
        }

        /* Adjust page-wrapper margin dynamically for screens 1280px and wider */
        @media (min-width: 1280px) {
            html[dir="ltr"] body[data-sidebartype="full"] .page-wrapper {
                margin-left: 270px !important;
                margin-right: 0 !important;
            }
            html[dir="ltr"] body[data-sidebartype="mini-sidebar"] .page-wrapper {
                margin-left: 65px !important;
                margin-right: 0 !important;
            }
            html[dir="rtl"] body[data-sidebartype="full"] .page-wrapper {
                margin-right: 270px !important;
                margin-left: 0 !important;
            }
            html[dir="rtl"] body[data-sidebartype="mini-sidebar"] .page-wrapper {
                margin-right: 65px !important;
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body class="DEFAULT_THEME bg-lightprimary dark:bg-darkbody">

    <!-- Toast -->
    {{-- @include('layouts.partials.admin.toast') --}}
    <!-- End Toast -->

    <!-- Modal Confirmation -->
    @include('layouts.partials.admin.modal-confirmation')

    <main>
        <!--start the project-->
        <div id="main-wrapper" class="flex p-5">

            <!-- Vertical Sidebar -->
            @include('layouts.partials.admin.vertical-sidebar')
            <!-- Vertical Sidebar End -->

            <div class="page-wrapper w-full" role="main">

                <!-- Main Content -->
                <main class="h-full ">
                    <div class="container full-container py-5 xl:ps-6 ps-0 pt-0 pe-0 remove-ps max-w-full">

                        <!--  Header Start -->
                        @include('layouts.partials.admin.header')
                        <!--  Header End -->

                        <!-- Horizontal Sidebar Menu -->
                        {{-- @include('layouts.partials.admin.horizontal-sidebar') --}}
                        <!-- Horizontal Sidebar Menu End -->

                        <!------Container-------->
                        <div class="max-w-full w-full">
                            <div class="w-full">
                                @yield('content')
                            </div>
                        </div>
                        <!-------End Container------->

                    </div>
                </main>
                <!-- Main Content End -->
                <!-- Footer -->
                @include('layouts.partials.admin.footer')
                <!-- Footer End -->
            </div>
        </div>
        <!--end of project-->
    </main>
    <!-- Menu Canvas-->
    {{-- @include('layouts.partials.admin.menu-canvas') --}}
    <!-- End Menu Canvas-->
    <!------- Customizer button--------->
    {{-- @include('layouts.partials.admin.customizer-button') --}}
    <!------- End Customizer button--------->

    <!------- Customizer Options--------->
    {{-- @include('layouts.partials.admin.customizer-options') --}}
    <!------- End Customizer Options--------->
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
        // Wait for jQuery to be available before loading vector map plugins
        // function waitForjQuery(callback) {
        //     if (window.jQuery && window.$) {
        //         callback();
        //     } else {
        //         setTimeout(function() {
        //             waitForjQuery(callback);
        //         }, 50);
        //     }
        // }

        // Load vector map scripts after jQuery is ready
        // waitForjQuery(function() {
        //     // Load JVectorMap scripts dynamically
        //     var script1 = document.createElement('script');
        //     script1.src = "{{ asset('assets/libs/jvectormap/jquery-jvectormap.min.js') }}";
        //     script1.onload = function() {
        //         var script2 = document.createElement('script');
        //         script2.src = "{{ asset('assets/js/extra-libs/jvectormap/jquery-jvectormap-us-aea-en.js') }}";
        //         script2.onload = function() {
        //             var script3 = document.createElement('script');
        //             script3.src = "{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}";
        //             script3.onload = function() {
        //                 var script4 = document.createElement('script');
        //                 script4.src = "{{ asset('assets/js/dashboards/dashboard.js') }}";
        //                 document.head.appendChild(script4);
        //             };
        //             document.head.appendChild(script3);
        //         };
        //         document.head.appendChild(script2);
        //     };
        //     document.head.appendChild(script1);
        // });
    </script>

    <script>
        function handleColorTheme(e) {
            document.documentElement.setAttribute("data-color-theme", e);
        }

        // Connect headerCollapse to mini-sidebar functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Get storage value safely
            const defaultSidebarType = typeof userSettings !== 'undefined' ? userSettings.sidebarType : 'full';
            const sidebarType = localStorage.getItem('sidebarType') || defaultSidebarType || 'full';
            document.body.setAttribute("data-sidebartype", sidebarType);

            // Toggle function
            function toggleSidebar() {
                var currentSidebarType = document.body.getAttribute("data-sidebartype") || 'full';
                var newSidebarType = currentSidebarType === "full" ? "mini-sidebar" : "full";
                
                document.body.setAttribute("data-sidebartype", newSidebarType);
                localStorage.setItem('sidebarType', newSidebarType);
            }

            // Bind to all elements with class sidebartoggler
            const togglers = document.querySelectorAll('.sidebartoggler');
            togglers.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleSidebar();
                });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
