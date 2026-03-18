@extends('layouts.admin')

@section('title', 'Edit Izin')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Edit Izin',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'IAM', 'url' => '#'],
        ['name' => 'Izin', 'url' => route('permissions.index')],
        ['name' => 'Edit', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8">
    <form action="{{ route('permissions.update', $permission->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Aplikasi -->
            <div>
                <label for="application_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-app-window mr-2"></i>Aplikasi <span class="text-red-500">*</span>
                </label>
                <select id="application_id" name="application_id" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('application_id') border-red-500 @enderror">
                    <option value="">-- Pilih Aplikasi --</option>
                    @foreach($applications as $app)
                        <option value="{{ $app->id }}" {{ old('application_id', $permission->application_id) == $app->id ? 'selected' : '' }}>
                            {{ $app->name }}
                        </option>
                    @endforeach
                </select>
                @error('application_id')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Izin -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-lock-open mr-2"></i>Nama Izin <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $permission->name) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                    placeholder="Contoh: Buat Absensi">
                @error('name')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Slug -->
            <div>
                <label for="slug" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-tag mr-2"></i>Slug <span class="text-red-500">*</span>
                </label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $permission->slug) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('slug') border-red-500 @enderror"
                    placeholder="Contoh: absensi:create">
                @error('slug')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Resource -->
            <div>
                <label for="resource" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-folder mr-2"></i>Resource
                </label>
                <input type="text" id="resource" name="resource" value="{{ old('resource', $permission->resource) }}"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('resource') border-red-500 @enderror"
                    placeholder="Contoh: absensi">
                @error('resource')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Action -->
            <div>
                <label for="action" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-zap mr-2"></i>Aksi
                </label>
                <input type="text" id="action" name="action" value="{{ old('action', $permission->action) }}"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('action') border-red-500 @enderror"
                    placeholder="Contoh: create, read, update, delete">
                @error('action')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Sistem -->
            <div class="flex items-end">
                <div class="flex items-center h-10 px-4 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 w-full">
                    <input type="checkbox" id="is_system" name="is_system" value="1" {{ old('is_system', $permission->is_system) ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                    <label for="is_system" class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer">
                        Izin Sistem
                    </label>
                </div>
            </div>
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <i class="ti ti-file-text mr-2"></i>Deskripsi
            </label>
            <textarea id="description" name="description" rows="3"
                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('description') border-red-500 @enderror"
                placeholder="Masukkan deskripsi izin">{{ old('description', $permission->description) }}</textarea>
            @error('description')
                <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 justify-end border-t border-gray-200 dark:border-gray-700 pt-6">
            <a href="{{ route('permissions.index') }}" class="inline-flex items-center px-6 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <i class="ti ti-x mr-2"></i>Batal
            </a>
            <button type="submit" class="inline-flex items-center px-6 py-2.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                <i class="ti ti-check mr-2"></i>Perbarui
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
    @include('components.confirm-toastr')
@endpush
