<!DOCTYPE html>
<html data-hs-theme-switch lang="en" dir="ltr" data-color-theme="Blue_Theme" class="light selected" data-layout="vertical" data-boxed-layout="boxed" data-card="shadow">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Adirama Education Center')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Theme Styles -->
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="DEFAULT_THEME bg-white dark:bg-dark ">
    <!-- Main Content -->
    <main>
        <div id="main-wrapper" class="flex landingpage">
            <div class="w-full" role="main">
                <!-- Header -->
                @include('layouts.partials.landing.header')
                 <!-- Main Content -->
                <div class="max-w-full">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    @yield('outofcontent')

    @include('layouts.partials.landing.footer')

    <!-- Scripts -->
    <script src="{{ asset('assets/js/theme/app.init.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/iconify-icon/dist/iconify-icon.min.js') }}"></script>
    <script src="{{ asset('assets/libs/preline/dist/preline.js') }}"></script>
    <script src="{{ asset('assets/libs/@preline/input-number/index.js') }}"></script>
    <script src="{{ asset('assets/libs/@preline/tooltip/index.js') }}"></script>
    <script src="{{ asset('assets/libs/@preline/stepper/index.js') }}"></script>
    <script>
            function handleColorTheme(e) {
                document.documentElement.setAttribute("data-color-theme", e);
            }
    </script>
    @stack('scripts')
</body>
</html>
