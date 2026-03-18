@extends('layouts.admin')

@section('title', $permission->name)

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => $permission->name,
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'IAM', 'url' => '#'],
        ['name' => 'Izin', 'url' => route('permissions.index')],
        ['name' => $permission->name, 'url' => '#']
    ]
])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <div class="rounded-lg border border-gray-200 bg-white p-6">
            <div class="flex items-start justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    <i class="ti ti-lock-open mr-2"></i>{{ $permission->name }}
                </h2>
                <div class="flex gap-2">
                    <a href="{{ route('permissions.edit', $permission->id) }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                        <i class="ti ti-edit mr-2"></i>Edit
                    </a>
                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-red-600 text-white font-medium hover:bg-red-700 transition" onclick="return confirm('Hapus izin ini?')">
                            <i class="ti ti-trash mr-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Nama Izin</p>
                    <p class="text-lg text-gray-900">{{ $permission->name }}</p>
                </div>

                <!-- Slug -->
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Slug</p>
                    <p class="text-lg text-gray-900 font-mono">{{ $permission->slug }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Aplikasi -->
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Aplikasi</p>
                    <p class="text-gray-900">{{ $permission->application->name ?? '-' }}</p>
                </div>

                <!-- Resource -->
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Resource</p>
                    <p class="text-gray-900">{{ $permission->resource ?? '-' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Action -->
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Aksi</p>
                    <p class="text-gray-900">{{ $permission->action ?? '-' }}</p>
                </div>

                <!-- Sistem -->
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Status</p>
                    @if($permission->is_system)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                            <i class="ti ti-lock mr-1"></i>Sistem
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                            <i class="ti ti-circle-minus mr-1"></i>Kustom
                        </span>
                    @endif
                </div>
            </div>

            @if($permission->description)
            <div class="mt-6">
                <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Deskripsi</p>
                <p class="text-gray-900">{{ $permission->description }}</p>
            </div>
            @endif

            <!-- Timestamps -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-200">
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Dibuat</p>
                    <p class="text-gray-900">{{ $permission->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Diperbarui</p>
                    <p class="text-gray-900">{{ $permission->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Roles Section -->
        <div class="rounded-lg border border-gray-200 bg-white p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">
                <i class="ti ti-badge mr-2"></i>Peran dengan Izin Ini ({{ $permission->roles->count() }})
            </h3>
            @if($permission->roles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($permission->roles as $role)
                        <a href="{{ route('roles.show', $role->id) }}" class="flex items-center p-3 rounded-lg border border-gray-200 bg-gray-50 dark:bg-gray-700 hover:border-blue-500 dark:hover:border-blue-400 transition">
                            <i class="ti ti-badge mr-2 text-blue-600 dark:text-blue-400"></i>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $role->name }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $role->application->name ?? 'N/A' }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 dark:text-gray-400">Tidak ada peran yang memiliki izin ini.</p>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <!-- Quick Stats -->
        <div class="rounded-lg border border-gray-200 bg-white p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Statistik</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Total Peran</span>
                    <span class="text-xl font-bold text-gray-900">{{ $permission->roles->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Tipe Izin</span>
                    <span class="text-sm font-semibold
                        @if($permission->is_system) text-yellow-600 dark:text-yellow-400
                        @else text-blue-600 dark:text-blue-400
                        @endif">
                        {{ $permission->is_system ? 'Sistem' : 'Kustom' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Permission Pattern -->
        <div class="rounded-lg border border-gray-200 bg-white p-6 mt-6">
            <h3 class="text-lg font-bold text-gray-900 mb-3">Pola Izin</h3>
            <div class="space-y-2 text-sm">
                <p class="text-gray-600 dark:text-gray-400">
                    <span class="font-semibold text-gray-900">Format:</span><br>
                    <code class="bg-gray-100 dark:bg-gray-900 px-2 py-1 rounded text-xs font-mono">resource:action</code>
                </p>
                <p class="text-gray-600 dark:text-gray-400">
                    <span class="font-semibold text-gray-900">Contoh:</span><br>
                    <code class="bg-gray-100 dark:bg-gray-900 px-2 py-1 rounded text-xs font-mono">absensi:create</code>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    @include('components.confirm-toastr')
@endpush
