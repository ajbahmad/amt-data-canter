@php
    use App\Support\AdminNav;

    $adminNavGroups = config('ppdb_admin.navigation', []);
@endphp

<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 flex flex-col w-68 bg-emerald-800 text-white shadow-2xl transform -translate-x-full transition-all duration-300 ease-in-out md:relative md:translate-x-0 border-r border-white/5">

    <div class="flex items-center gap-4 h-20 px-6 bg-emerald-900 border-b border-yellow-500 flex-shrink-0 overflow-hidden relative brand-container">
        {{-- Subtle Batik Accent --}}
        <div class="absolute inset-0 opacity-5 pointer-events-none mix-blend-overlay" style="background-color: #0d9488">
        </div>
        
        <img src="{{ asset('logo-amt.webp') }}" alt="Logo" class="size-10 shrink-0">
        <div class="flex flex-col z-10 brand-text">
            <span class="text-sm font-black tracking-[0.2em] text-yellow-500 uppercase">ADMIN PANEL</span>
            <span class="text-xs font-bold text-white/60">PPDB SMK AL-MUJTAMA'</span>
        </div>
    </div>

    <nav class="flex-1 px-4 py-8 space-y-8 overflow-y-auto sidebar-scroll">
        @foreach ($adminNavGroups as $group)
            <div>
                <p class="px-4 mb-4 text-[10px] font-black text-emerald-500/50 uppercase tracking-[0.25em] sidebar-label">
                    {{ $group['section_label'] ?? $group['id'] }}
                </p>

                <div class="space-y-1">
                    @foreach ($group['items'] ?? [] as $item)
                        @php
                            $routeName = $item['route'] ?? '';
                            $href = AdminNav::routeUrl($routeName);
                            $missing = $href === '#';
                            $active = AdminNav::routeIsActive($routeName);
                            $itemClasses = $active
                                ? 'bg-emerald-900 text-white shadow-lg border-l-4 border-yellow-500 pl-3'
                                : 'text-emerald-100/60 hover:bg-emerald-900/50 hover:text-white hover:pl-5 pl-4';
                        @endphp
                        <a href="{{ $href }}"
                            @if ($missing) title="Route belum terdaftar" @endif
                            class="group flex items-center gap-3 py-3 rounded-lg text-sm font-bold transition-all duration-300 sidebar-item {{ $itemClasses }} {{ $missing ? 'opacity-40 pointer-events-none' : '' }}">
                            <div class="shrink-0 transition-transform duration-300 group-hover:scale-110">
                                <x-admin.nav-icon :name="$item['icon'] ?? 'layout-dashboard'" class="w-5 h-5" />
                            </div>
                            <span class="whitespace-nowrap tracking-tight sidebar-text">{{ $item['label'] ?? $item['id'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </nav>

    <div class="p-6 border-t border-white/5 bg-emerald-900/30 user-profile-container">
        <div class="flex items-center gap-4">
            <div class="relative">
                <img class="size-10 rounded-full border-2 border-yellow-500/30 shrink-0"
                    src="https://ui-avatars.com/api/?name=Admin+PPDB&background=f59e0b&color=064e3b&size=64" alt="">
                <div class="absolute bottom-0 right-0 size-3 bg-green-500 border-2 border-emerald-800 rounded-full"></div>
            </div>
            <div class="min-w-0 user-info">
                <p class="text-sm font-black text-white truncate">Administrator</p>
                <p class="text-[10px] font-bold text-yellow-500 uppercase tracking-widest">Main Office</p>
            </div>
            <button type="button" 
                onclick="confirmAdminLogout()"
                class="ml-auto text-emerald-500 hover:text-red-400 transition-all hover:scale-110 user-info"
                title="Keluar">
                <iconify-icon icon="lucide:log-out" class="text-xl"></iconify-icon>
            </button>
            <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>

    <script>
        function confirmAdminLogout() {
            Swal.fire({
                title: 'Logout Admin?',
                text: "Anda akan keluar dari panel kontrol.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#065f46',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'YA, KELUAR',
                cancelButtonText: 'BATAL'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('admin-logout-form').submit();
                }
            })
        }
    </script>
</aside>