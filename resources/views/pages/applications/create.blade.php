@extends('layouts.admin')

@section('title', 'Tambah Aplikasi')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Tambah Aplikasi',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'IAM', 'url' => '#'],
        ['name' => 'Aplikasi', 'url' => route('applications.index')],
        ['name' => 'Tambah Baru', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8">
    <form action="{{ route('applications.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Aplikasi -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-app-window mr-2"></i>Nama Aplikasi <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                    placeholder="Contoh: Sistem Absensi">
                @error('name')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-tag mr-2"></i>Slug <span class="text-red-500">*</span>
                </label>
                <input type="text" id="slug" name="slug" value="{{ old('slug') }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('slug') border-red-500 @enderror"
                    placeholder="Contoh: absensi">
                @error('slug')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <i class="ti ti-file-text mr-2"></i>Deskripsi
            </label>
            <textarea id="description" name="description" rows="3"
                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('description') border-red-500 @enderror"
                placeholder="Masukkan deskripsi aplikasi">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- URL Website -->
            <div>
                <label for="website_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-world mr-2"></i>URL Website
                </label>
                <input type="text" id="website_url" name="website_url" value="{{ old('website_url') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('website_url') border-red-500 @enderror"
                    placeholder="https://aplikasi.com">
                @error('website_url')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- URL Logo -->
            <div>
                <label for="logo_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-photo mr-2"></i>URL Logo
                </label>
                <input type="text" id="logo_url" name="logo_url" value="{{ old('logo_url') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('logo_url') border-red-500 @enderror"
                    placeholder="https://aplikasi.com/logo.png">
                @error('logo_url')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- API Base URL -->
            <div>
                <label for="api_base_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-api mr-2"></i>API Base URL
                </label>
                <input type="text" id="api_base_url" name="api_base_url" value="{{ old('api_base_url') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('api_base_url') border-red-500 @enderror"
                    placeholder="https://api.aplikasi.com">
                @error('api_base_url')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- API Client ID -->
            <div>
                <label for="api_client_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-key mr-2"></i>API Client ID
                </label>
                <input type="text" id="api_client_id" name="api_client_id" value="{{ old('api_client_id') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('api_client_id') border-red-500 @enderror"
                    placeholder="Client ID untuk integrasi API">
                @error('api_client_id')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Status -->
        <div>
            <div class="flex items-center space-x-3">
                <div class="flex items-center h-10 px-4 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                    <label for="is_active" class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer">
                        Aktif
                    </label>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 justify-end border-t border-gray-200 dark:border-gray-700 pt-6">
            <a href="{{ route('applications.index') }}" class="inline-flex items-center px-6 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <i class="ti ti-x mr-2"></i>Batal
            </a>
            <button type="submit" class="inline-flex items-center px-6 py-2.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                <i class="ti ti-check mr-2"></i>Simpan
            </button>
        </div>
    </form>
</div>

@endsection

@push('styles')
<style>
    .form-input:focus {
        @apply ring-2 ring-blue-500 border-transparent;
    }
</style>
@endpush

@push('scripts')
    @include('components.confirm-toastr')
@endpush
