@props(['title' => 'Dashboard'])

@php
    $pendingRegistrationsCount = \App\Models\Registration::where('status', 'pending')->count();
    $latestNotifications = \App\Models\Registration::where('status', 'pending')
        ->latest()
        ->take(5)
        ->get();
@endphp

<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 md:px-6 z-30 flex-shrink-0">
    <div class="flex items-center gap-3">
        {{-- Toggle Button --}}
        <button onclick="toggleSidebar()"
                class="p-2 rounded-lg text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 transition-all focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
            </svg>
        </button>

        <div class="ml-1">
            <h1 class="text-base md:text-lg font-bold text-gray-800 leading-tight">{{ $title }}</h1>
            <p class="hidden sm:block text-[11px] text-emerald-600 font-medium uppercase tracking-wider">PPDB · Panel kontrol</p>
        </div>
    </div>

    <div class="flex items-center gap-2 md:gap-4">

        {{-- Bell / Notifications --}}
        <div class="relative" x-data="{ isOpen: false }">
            <button @click="isOpen = !isOpen"
                    class="relative p-2 rounded-lg text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 transition-colors focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                @if($pendingRegistrationsCount > 0)
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                @endif
            </button>

            {{-- Notifications Dropdown Menu --}}
            <div x-show="isOpen"
                 @click.away="isOpen = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                 class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50 origin-top-right focus:outline-none"
                 style="display: none;">
                
                <div class="px-4 py-2.5 border-b border-gray-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-800 uppercase tracking-wider">Notifikasi</span>
                    @if($pendingRegistrationsCount > 0)
                        <span class="px-2 py-0.5 text-[10px] font-bold bg-amber-50 text-amber-600 rounded-full">
                            {{ $pendingRegistrationsCount }} Pending
                        </span>
                    @endif
                </div>

                <div class="max-h-64 overflow-y-auto">
                    @forelse($latestNotifications as $notification)
                        <a href="{{ route('admin.registrations.show', $notification->id) }}" 
                           class="flex gap-3 px-4 py-3 hover:bg-slate-50 border-b border-gray-50 last:border-0 transition-colors">
                            <div class="shrink-0 size-8 bg-amber-50 rounded-lg flex items-center justify-center text-amber-600">
                                <iconify-icon icon="lucide:user-plus" class="text-base"></iconify-icon>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-bold text-gray-800 truncate uppercase">Pendaftar Baru</p>
                                <p class="text-[11px] text-gray-500 truncate mt-0.5">{{ $notification->nama_lengkap }}</p>
                                <span class="text-[9px] font-semibold text-emerald-600 block mt-1 uppercase">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @empty
                        <div class="px-4 py-6 text-center text-gray-400">
                            <iconify-icon icon="lucide:bell-off" class="text-2xl mb-1"></iconify-icon>
                            <p class="text-xs font-medium">Tidak ada notifikasi baru</p>
                        </div>
                    @endforelse
                </div>

                <div class="px-4 py-2 border-t border-gray-100 bg-slate-50 text-center">
                    <a href="{{ route('admin.registrations.index') }}" class="text-[11px] font-bold text-emerald-600 hover:text-emerald-700 transition-colors uppercase tracking-wider">
                        Lihat Semua Pendaftaran
                    </a>
                </div>
            </div>
        </div>

        <div class="h-8 w-px bg-gray-200 mx-1 hidden md:block"></div>

        {{-- Avatar & Dropdown --}}
        <div class="relative" x-data="{ isOpen: false }">
            <div @click="isOpen = !isOpen" class="flex items-center gap-2 pl-1 cursor-pointer group select-none">
                <img class="w-9 h-9 rounded-lg border-2 border-transparent group-hover:border-emerald-500 transition-all shadow-sm"
                     src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=d1fae5&color=065f46&size=64" alt="Avatar">
                <div class="hidden md:block pr-1">
                    <p class="text-sm font-bold text-gray-700 group-hover:text-emerald-700 flex items-center gap-1">
                        {{ auth()->user()->name }}
                        <iconify-icon icon="lucide:chevron-down" class="text-xs transition-transform duration-200" :class="isOpen ? 'rotate-180' : ''"></iconify-icon>
                    </p>
                </div>
            </div>

            {{-- Avatar Dropdown Menu --}}
            <div x-show="isOpen"
                 @click.away="isOpen = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50 origin-top-right focus:outline-none"
                 style="display: none;">
                
                {{-- User Header --}}
                <div class="px-4 py-2.5 border-b border-gray-100">
                    <p class="text-xs font-semibold text-gray-400">Masuk sebagai</p>
                    <p class="text-sm font-bold text-gray-800 truncate uppercase mt-0.5">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-gray-500 font-medium truncate mt-0.5">{{ auth()->user()->email }}</p>
                </div>

                {{-- Menu Items --}}
                <div class="py-1">                    
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-gray-600 hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                        <iconify-icon icon="lucide:settings" class="text-base"></iconify-icon>
                        Pengaturan Sistem
                    </a>
                </div>

                <div class="border-t border-gray-100 py-1">
                    <button type="button" 
                            @click="isOpen = false; confirmNavbarLogout();" 
                            class="w-full flex items-center gap-2 px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 transition-colors text-left focus:outline-none">
                        <iconify-icon icon="lucide:log-out" class="text-base"></iconify-icon>
                        Keluar / Logout
                    </button>
                    <form id="navbar-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    function confirmNavbarLogout() {
        Swal.fire({
            title: 'Logout?',
            text: "Anda akan keluar dari sesi administrator.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#059669',
            cancelButtonColor: '#dc2626',
            confirmButtonText: 'YA, KELUAR',
            cancelButtonText: 'BATAL'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('navbar-logout-form').submit();
            }
        })
    }
</script>