@extends('layouts.admin')

@section('title', 'Edit Lembaga Sekolah')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Edit Lembaga Sekolah',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Lembaga Sekolah', 'url' => route('school_institutions.index')],
        ['name' => 'Edit', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8">
    <form action="{{ route('school_institutions.update', $schoolInstitution) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kode Sekolah -->
            <div>
                <label for="code" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-code mr-2"></i>Kode Sekolah <span class="text-red-500">*</span>
                </label>
                <input type="text" id="code" name="code" value="{{ old('code', $schoolInstitution->code) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('code') border-red-500 @enderror"
                    placeholder="Masukkan kode sekolah">
                @error('code')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Sekolah -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-school mr-2"></i>Nama Sekolah <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $schoolInstitution->name) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                    placeholder="Masukkan nama sekolah">
                @error('name')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- NPSN -->
            <div>
                <label for="npsn" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-number mr-2"></i>NPSN
                </label>
                <input type="text" id="npsn" name="npsn" value="{{ old('npsn', $schoolInstitution->npsn) }}"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('npsn') border-red-500 @enderror"
                    placeholder="Nomor Pokok Sekolah Nasional">
                @error('npsn')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-mail mr-2"></i>Email
                </label>
                <input type="email" id="email" name="email" value="{{ old('email', $schoolInstitution->email) }}"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                    placeholder="email@sekolah.com">
                @error('email')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Telepon -->
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-phone mr-2"></i>Telepon
                </label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $schoolInstitution->phone) }}"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('phone') border-red-500 @enderror"
                    placeholder="Nomor telepon sekolah">
                @error('phone')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="flex items-end">
                <div class="flex items-center space-x-3 w-full">
                    <div class="flex items-center h-10 px-4 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $schoolInstitution->is_active) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <label for="is_active" class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer">
                            Status Aktif
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alamat -->
        <div>
            <label for="address" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <i class="ti ti-map-pin mr-2"></i>Alamat
            </label>
            <textarea id="address" name="address" rows="4"
                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('address') border-red-500 @enderror"
                placeholder="Masukkan alamat lengkap sekolah">{{ old('address', $schoolInstitution->address) }}</textarea>
            @error('address')
                <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 justify-end border-t border-gray-200 dark:border-gray-700 pt-6">
            <a href="{{ route('school_institutions.index') }}" class="inline-flex items-center px-6 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <i class="ti ti-x mr-2"></i>Batal
            </a>
            <button type="submit" class="inline-flex items-center px-6 py-2.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                <i class="ti ti-check mr-2"></i>Perbarui
            </button>
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
