@extends('layouts.admin')

@section('title', $role->name)

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => $role->name,
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'IAM', 'url' => '#'],
        ['name' => 'Peran', 'url' => route('roles.index')],
        ['name' => $role->name, 'url' => '#']
    ]
])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <div class="rounded-lg border border-gray-200 bg-white p-6">
            <div class="flex items-start justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    <i class="ti ti-badge mr-2"></i>{{ $role->name }}
                </h2>
                <div class="flex gap-2">
                    <a href="{{ route('roles.edit', $role->id) }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                        <i class="ti ti-edit mr-2"></i>Edit
                    </a>
                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-red-600 text-white font-medium hover:bg-red-700 transition" onclick="return confirm('Hapus peran ini?')">
                            <i class="ti ti-trash mr-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Nama Peran</p>
                    <p class="text-lg text-gray-900">{{ $role->name }}</p>
                </div>

                <!-- Slug -->
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Slug</p>
                    <p class="text-lg text-gray-900">{{ $role->slug }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Aplikasi -->
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Aplikasi</p>
                    <p class="text-gray-900">{{ $role->application->name ?? '-' }}</p>
                </div>

                <!-- Cakupan -->
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Cakupan</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                        @if($role->scope === 'global') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                        @elseif($role->scope === 'institution') bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200
                        @else bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                        @endif">
                        @if($role->scope === 'global')
                            <i class="ti ti-world mr-1"></i>Global
                        @elseif($role->scope === 'institution')
                            <i class="ti ti-building mr-1"></i>Lembaga
                        @else
                            <i class="ti ti-building-community mr-1"></i>Sekolah
                        @endif
                    </span>
                </div>
            </div>

            @if($role->description)
            <div class="mt-6">
                <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Deskripsi</p>
                <p class="text-gray-900">{{ $role->description }}</p>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Lembaga (jika ada) -->
                @if($role->institution)
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Lembaga</p>
                    <p class="text-gray-900">{{ $role->institution->name }}</p>
                </div>
                @endif

                <!-- Tingkat Sekolah (jika ada) -->
                @if($role->schoolLevel)
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Tingkat Sekolah</p>
                    <p class="text-gray-900">{{ $role->schoolLevel->name }}</p>
                </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Prioritas -->
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Prioritas</p>
                    <p class="text-gray-900">{{ $role->priority }}</p>
                </div>

                <!-- Status -->
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Status</p>
                    <div class="flex gap-2">
                        @if($role->is_active)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                <i class="ti ti-circle-check mr-1"></i>Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                                <i class="ti ti-circle-x mr-1"></i>Tidak Aktif
                            </span>
                        @endif
                        @if($role->is_system)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                <i class="ti ti-lock mr-1"></i>Sistem
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-200">
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Dibuat</p>
                    <p class="text-gray-900">{{ $role->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Diperbarui</p>
                    <p class="text-gray-900">{{ $role->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Permissions Section -->
        <div class="rounded-lg border border-gray-200 bg-white p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">
                <i class="ti ti-lock-open mr-2"></i>Izin ({{ $role->permissions->count() }})
            </h3>
            @if($role->permissions->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($role->permissions as $permission)
                        <div class="flex items-center p-3 rounded-lg border border-gray-200 bg-gray-50 dark:bg-gray-700">
                            <i class="ti ti-check-circle mr-2 text-green-600 dark:text-green-400"></i>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $permission->name }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $permission->slug }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 dark:text-gray-400">Tidak ada izin yang ditetapkan untuk peran ini.</p>
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
                    <span class="text-gray-600 dark:text-gray-400">Total Izin</span>
                    <span class="text-xl font-bold text-gray-900">{{ $role->permissions->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Total Pengguna</span>
                    <span class="text-xl font-bold text-gray-900">{{ $role->users->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Total Menu</span>
                    <span class="text-xl font-bold text-gray-900">{{ $role->menus->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    @include('components.confirm-toastr')
@endpush
