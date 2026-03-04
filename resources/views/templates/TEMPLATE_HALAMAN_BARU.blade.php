{{-- 
TEMPLATE HALAMAN UNTUK PENGEMBANGAN BARU
Salin file ini untuk halaman-halaman baru dan sesuaikan sesuai kebutuhan.

Struktur:
- extends('layouts.admin') : Layout utama dengan sidebar, navbar
- @section('title', '...') : Judul halaman
- @push('styles') : CSS tambahan jika ada
- @section('content') : Konten utama
- @include('layouts.partials.admin.breadcrumb') : Breadcrumb navigasi
- @push('scripts') : JS tambahan jika ada
--}}

@extends('layouts.admin')

@section('title', 'Nama Halaman')

@push('styles')
<style>
    /* Custom styles untuk halaman ini */
    .custom-class {
        /* styles */
    }
</style>
@endpush

@section('content')

{{-- BREADCRUMB SECTION --}}
@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Nama Halaman',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['name' => 'Module', 'url' => '#'],
        ['name' => 'Halaman Saat Ini', 'url' => '#'] 
    ]
])

{{-- ALERT MESSAGES --}}
@if(session('success'))
    <div class="mb-6 rounded-lg bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 p-4">
        <div class="flex items-center">
            <i class="ti ti-check-circle text-green-600 dark:text-green-400 text-xl mr-3"></i>
            <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mb-6 rounded-lg bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-700 p-4">
        <div class="flex items-center">
            <i class="ti ti-alert-circle text-red-600 dark:text-red-400 text-xl mr-3"></i>
            <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
        </div>
    </div>
@endif

{{-- ERROR VALIDATION --}}
@if ($errors->any())
    <div class="mb-6 rounded-lg bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-700 p-4">
        <strong class="text-red-600 dark:text-red-400">
            <i class="ti ti-alert-triangle mr-2"></i>Terjadi Kesalahan Validasi
        </strong>
        <ul class="mt-2 list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li class="text-sm text-red-600 dark:text-red-400">• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- PAGE CONTENT --}}
<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
    
    {{-- HEADER SECTION --}}
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <i class="ti ti-layout-list mr-2"></i>Judul Konten
        </h2>
        <a href="#" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
            <i class="ti ti-plus mr-2"></i>Tambah Baru
        </a>
    </div>

    {{-- TABLE / LIST SECTION --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Kolom 1</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Kolom 2</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Status</th>
                    <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop data disini --}}
                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-4 py-3 text-gray-900 dark:text-white">Data 1</td>
                    <td class="px-4 py-3 text-gray-900 dark:text-white">Data 2</td>
                    <td class="px-4 py-3">
                        <span class="inline-block rounded-full bg-green-100 dark:bg-green-900/30 px-3 py-1 text-xs font-medium text-green-800 dark:text-green-300">
                            Aktif
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="#" class="rounded-lg bg-blue-100 dark:bg-blue-900/30 p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50">
                                <i class="ti ti-edit"></i>
                            </a>
                            <button type="button" onclick="deleteConfirm(this)" class="rounded-lg bg-red-100 dark:bg-red-900/30 p-2 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                {{-- End loop --}}
            </tbody>
        </table>
    </div>

    {{-- PAGINATION (jika perlu) --}}
    <div class="mt-6 flex items-center justify-between">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Menampilkan <strong>1</strong> sampai <strong>10</strong> dari <strong>100</strong> data
        </p>
        <div class="flex gap-2">
            <button class="rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                Sebelumnya
            </button>
            <button class="rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                Berikutnya
            </button>
        </div>
    </div>

</div>

@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Custom JS untuk halaman ini
    
    // Contoh: Konfirmasi delete
    window.deleteConfirm = function(button) {
        if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            // Submit form delete
            console.log('Delete confirmed');
        }
    }
});
</script>
@endpush
