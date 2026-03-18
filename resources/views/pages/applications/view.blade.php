@extends('layouts.admin')

@section('title', $application->name)

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => $application->name,
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'IAM', 'url' => '#'],
        ['name' => 'Aplikasi', 'url' => route('applications.index')],
        ['name' => $application->name, 'url' => '#']
    ]
])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <div class="rounded-lg border border-gray-200 bg-white p-6">
            <div class="flex items-start justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    <i class="ti ti-app-window mr-2"></i>{{ $application->name }}
                </h2>
                <div class="flex gap-2">
                    <a href="{{ route('applications.edit', $application->id) }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                        <i class="ti ti-edit mr-2"></i>Edit
                    </a>
                    <form action="{{ route('applications.destroy', $application->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-red-600 text-white font-medium hover:bg-red-700 transition" onclick="return confirm('Hapus aplikasi ini?')">
                            <i class="ti ti-trash mr-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Nama Aplikasi</p>
                    <p class="text-lg text-gray-900">{{ $application->name }}</p>
                </div>

                <!-- Slug -->
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Slug</p>
                    <p class="text-lg text-gray-900">{{ $application->slug }}</p>
                </div>
            </div>

            @if($application->description)
            <div class="mt-6">
                <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Deskripsi</p>
                <p class="text-gray-900">{{ $application->description }}</p>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Website URL -->
                @if($application->website_url)
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Website</p>
                    <a href="{{ $application->website_url }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                        <i class="ti ti-world mr-1"></i>{{ $application->website_url }}
                    </a>
                </div>
                @endif

                <!-- API Base URL -->
                @if($application->api_base_url)
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">API Base URL</p>
                    <p class="text-gray-900 break-all">{{ $application->api_base_url }}</p>
                </div>
                @endif
            </div>

            @if($application->api_client_id)
            <div class="mt-6">
                <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">API Client ID</p>
                <p class="text-gray-900 font-mono">{{ $application->api_client_id }}</p>
            </div>
            @endif

            <!-- Status -->
            <div class="mt-6">
                <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">Status</p>
                @if($application->is_active)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                        <i class="ti ti-circle-check mr-1"></i>Aktif
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                        <i class="ti ti-circle-x mr-1"></i>Tidak Aktif
                    </span>
                @endif
            </div>

            <!-- Timestamps -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-200">
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Dibuat</p>
                    <p class="text-gray-900">{{ $application->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Diperbarui</p>
                    <p class="text-gray-900">{{ $application->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
    @include('components.confirm-toastr')
@endpush
