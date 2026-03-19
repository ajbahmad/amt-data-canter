@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail User',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Sistem & Keamanan', 'url' => '#'],
        ['name' => 'User', 'url' => route('users.index')],
        ['name' => $user->name, 'url' => '#']
    ]
])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informasi Utama -->
    <div class="lg:col-span-2">
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                <i class="ti ti-user mr-2"></i>Informasi User
            </h2>

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Nama</label>
                        <p class="text-gray-900 dark:text-white mt-1">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Email</label>
                        <p class="text-gray-900 dark:text-white mt-1">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Person</label>
                        <p class="text-gray-900 dark:text-white mt-1">
                            @if($user->person)
                                <a href="{{ route('persons.show', $user->person->id) }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ $user->person->name }}
                                </a>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Status</label>
                        <div class="mt-1">
                            @if($user->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    <i class="ti ti-circle-check mr-2"></i>Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                    <i class="ti ti-circle-x mr-2"></i>Non Aktif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Dibuat Pada</label>
                        <p class="text-gray-900 dark:text-white mt-1">{{ $user->created_at?->format('d F Y H:i') ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-400">Last Login</label>
                        <p class="text-gray-900 dark:text-white mt-1">{{ $user->last_login_at?->format('d F Y H:i') ?? 'Belum pernah login' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Assignments -->
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 mt-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">
                <i class="ti ti-badge mr-2"></i>Penugasan Role
            </h3>

            @forelse($user->userRoles->groupBy(fn($ur) => $ur->role->application_id) as $appId => $userRoles)
                @php $app = $userRoles->first()->role->application @endphp
                <div class="mb-6 p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        <i class="ti ti-app-window mr-2"></i>{{ $app->name }}
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($userRoles as $userRole)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                <i class="ti ti-badge mr-2"></i>{{ $userRole->role->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="p-4 border border-yellow-300 bg-yellow-50 dark:bg-yellow-900/20 dark:border-yellow-700 rounded-lg">
                    <p class="text-yellow-800 dark:text-yellow-300">
                        <i class="ti ti-alert-circle mr-2"></i>User belum memiliki role di aplikasi manapun
                    </p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Sidebar Actions -->
    <div class="lg:col-span-1">
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                <i class="ti ti-settings mr-2"></i>Aksi
            </h3>

            <div class="space-y-3">
                <a href="{{ route('users.edit', $user->id) }}"
                    class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-center flex items-center justify-center gap-2">
                    <i class="ti ti-edit"></i>Edit User
                </a>

                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="w-full" id="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center justify-center gap-2"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                        <i class="ti ti-trash"></i>Hapus User
                    </button>
                </form>

                <a href="{{ route('users.index') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-center flex items-center justify-center gap-2">
                    <i class="ti ti-arrow-left"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
