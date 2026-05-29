@props([
    'title' => 'Dashboard',
    'breadcrumbs' => [],
])

<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — PPDB Admin</title>
    <link rel="shortcut icon" href="{{ asset('logo-amt.webp') }}" type="image/webp">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 10px; }
        @media (min-width: 768px) {
            #sidebar.collapsed { width: 5rem; }
            #sidebar.collapsed .sidebar-text,
            #sidebar.collapsed .sidebar-label { opacity: 0; display: none; }
            #sidebar.collapsed .sidebar-item { justify-content: center; padding-left: 0; padding-right: 0; gap: 0; }
            #sidebar.collapsed .brand-text { display: none; }
            #sidebar.collapsed .brand-container { justify-content: center; padding-left: 0; padding-right: 0; gap: 0; }
            #sidebar.collapsed .user-info { display: none; }
            #sidebar.collapsed .user-profile-container { padding-left: 0; padding-right: 0; }
            #sidebar.collapsed .user-profile-container > div { justify-content: center; gap: 0; }
        }
    </style>
</head>
<body class="h-full bg-gray-50 text-gray-800 antialiased overflow-hidden">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar Component --}}
    <x-admin-sidebar />

    {{-- Mobile Overlay --}}
    <div id="sidebarOverlay"
         class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm hidden md:hidden"
         onclick="toggleSidebar()"></div>

    {{-- Main --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Navbar Component --}}
        <x-admin-navbar :title="$title" />

        {{-- Content --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto">
            <div class="p-4 md:p-8 max-w-none">
                <nav class="mb-6 flex flex-wrap items-center text-xs text-gray-400 gap-2" aria-label="Breadcrumb">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600">Admin</a>
                    @foreach ($breadcrumbs as $crumb)
                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        @isset($crumb['route'])
                            <a href="{{ $crumb['route'] }}" class="hover:text-emerald-600">{{ $crumb['label'] }}</a>
                        @else
                            <span class="text-gray-600 font-medium">{{ $crumb['label'] }}</span>
                        @endisset
                    @endforeach
                </nav>

                {{ $slot }}
            </div>
        </main>
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        if (window.innerWidth < 768) {
            const isHidden = sidebar.classList.contains('-translate-x-full');
            if (isHidden) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        } else {
            sidebar.classList.toggle('collapsed');
        }
    }
    function showToast(message, type = 'success') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: type,
            title: message
        });
    }

    function confirmDelete(event, message = 'Tindakan ini tidak dapat dibatalkan!') {
        event.preventDefault();
        const form = event.currentTarget.closest('form') || event.target.closest('form');
        if (!form) return;
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
        return false;
    }

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            document.getElementById('sidebarOverlay').classList.add('hidden');
            document.getElementById('sidebar').classList.remove('-translate-x-full');
        }
    });
</script>

{{ $scripts ?? '' }}
</body>
</html>
