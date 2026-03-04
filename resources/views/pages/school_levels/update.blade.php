@extends('layouts.admin')

@section('title', 'Edit Level Sekolah')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Edit Level Sekolah',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Level Sekolah', 'url' => route('school_levels.index')],
        ['name' => 'Edit', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8">
    <form action="{{ route('school_levels.update', $schoolLevel) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kode Level -->
            <div>
                <label for="code" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-code mr-2"></i>Kode Level <span class="text-red-500">*</span>
                </label>
                <input type="text" id="code" name="code" value="{{ old('code', $schoolLevel->code) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('code') border-red-500 @enderror"
                    placeholder="Contoh: sd, smp, sma, smk">
                @error('code')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Level -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-school mr-2"></i>Nama Level <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $schoolLevel->name) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                    placeholder="Contoh: Sekolah Dasar, Sekolah Menengah Pertama">
                @error('name')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <i class="ti ti-file-description mr-2"></i>Deskripsi
            </label>
            <textarea id="description" name="description" rows="3"
                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('description') border-red-500 @enderror"
                placeholder="Masukkan deskripsi level sekolah">{{ old('description', $schoolLevel->description) }}</textarea>
            @error('description')
                <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <div class="flex items-center h-10 px-4 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 w-fit">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $schoolLevel->is_active) ? 'checked' : '' }}
                    class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                <label for="is_active" class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer">
                    Status Aktif
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 justify-end border-t border-gray-200 dark:border-gray-700 pt-6">
            <a href="{{ route('school_levels.index') }}" class="inline-flex items-center px-6 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <i class="ti ti-x mr-2"></i>Batal
            </a>
            <button type="submit" class="inline-flex items-center px-6 py-2.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                <i class="ti ti-check mr-2"></i>Perbarui
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
