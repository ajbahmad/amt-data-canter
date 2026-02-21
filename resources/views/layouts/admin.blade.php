<!DOCTYPE html>
<html lang="en" dir="ltr" data-color-theme="Blue_Theme" class="light selected" data-layout="vertical"
    data-boxed-layout="boxed" data-card="shadow">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - A R E C</title>

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @stack('styles')
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
                        <div class="max-w-full">
                            <div class="container full-container max-w-full">
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
        function waitForjQuery(callback) {
            if (window.jQuery && window.$) {
                callback();
            } else {
                setTimeout(function() {
                    waitForjQuery(callback);
                }, 50);
            }
        }

        // Load vector map scripts after jQuery is ready
        waitForjQuery(function() {
            // Load JVectorMap scripts dynamically
            var script1 = document.createElement('script');
            script1.src = "{{ asset('assets/libs/jvectormap/jquery-jvectormap.min.js') }}";
            script1.onload = function() {
                var script2 = document.createElement('script');
                script2.src = "{{ asset('assets/js/extra-libs/jvectormap/jquery-jvectormap-us-aea-en.js') }}";
                script2.onload = function() {
                    var script3 = document.createElement('script');
                    script3.src = "{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}";
                    script3.onload = function() {
                        var script4 = document.createElement('script');
                        script4.src = "{{ asset('assets/js/dashboards/dashboard.js') }}";
                        document.head.appendChild(script4);
                    };
                    document.head.appendChild(script3);
                };
                document.head.appendChild(script2);
            };
            document.head.appendChild(script1);
        });
    </script>

    <script>
        function handleColorTheme(e) {
            document.documentElement.setAttribute("data-color-theme", e);
        }

        // Connect headerCollapse to mini-sidebar functionality
        document.addEventListener('DOMContentLoaded', function() {
            const headerCollapseBtn = document.getElementById('headerCollapse');
            // get storage value for sidebar type
            const sidebarType = localStorage.getItem('sidebarType') || userSettings.sidebarType || 'full';
            document.body.setAttribute("data-sidebartype", sidebarType);

            if (headerCollapseBtn) {
                headerCollapseBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Get current sidebar type
                    var currentSidebarType = document.body.getAttribute("data-sidebartype");

                    // Toggle between full and mini-sidebar
                    if (currentSidebarType === "full") {
                        document.body.setAttribute("data-sidebartype", "mini-sidebar");
                        localStorage.setItem('sidebarType', 'mini-sidebar');
                    } else {
                        document.body.setAttribute("data-sidebartype", "full");
                        localStorage.setItem('sidebarType', 'full');
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
