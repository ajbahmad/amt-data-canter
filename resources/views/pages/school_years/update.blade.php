@extends('layouts.admin')

@section('title', 'Edit Tahun Akademik')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Edit Tahun Akademik',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Tahun Akademik', 'url' => route('school_years.index')],
        ['name' => 'Edit', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8">
    <form action="{{ route('school_years.update', $schoolYear) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Sekolah -->
            <div>
                <label for="school_institution_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-building mr-2"></i>Sekolah <span class="text-red-500">*</span>
                </label>
                <select id="school_institution_id" name="school_institution_id" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('school_institution_id') border-red-500 @enderror">
                    <option value="">-- Pilih Sekolah --</option>
                    @forelse($schoolInstitutions as $school)
                        <option value="{{ $school->id }}" {{ old('school_institution_id', $schoolYear->school_institution_id) == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @empty
                        <option value="" disabled>Tidak ada sekolah aktif</option>
                    @endforelse
                </select>
                @error('school_institution_id')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Tahun Akademik -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-calendar mr-2"></i>Tahun Akademik <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $schoolYear->name) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                    placeholder="Contoh: 2025/2026">
                @error('name')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Tanggal Mulai -->
            <div>
                <label for="start_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-calendar-event mr-2"></i>Tanggal Mulai <span class="text-red-500">*</span>
                </label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $schoolYear->start_date->format('Y-m-d')) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('start_date') border-red-500 @enderror">
                @error('start_date')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Akhir -->
            <div>
                <label for="end_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-calendar-event mr-2"></i>Tanggal Akhir <span class="text-red-500">*</span>
                </label>
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $schoolYear->end_date->format('Y-m-d')) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('end_date') border-red-500 @enderror">
                @error('end_date')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6">
            <!-- Status -->
            <div class="flex items-center">
                <div class="flex items-center h-10 px-4 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $schoolYear->is_active) ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                    <label for="is_active" class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer">
                        <i class="ti ti-check mr-1"></i>Status Aktif
                    </label>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex items-center gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
            <button type="submit" class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2.5 text-white font-semibold hover:bg-blue-700 transition">
                <i class="ti ti-check mr-2"></i>Update
            </button>
            <a href="{{ route('school_years.index') }}" class="inline-flex items-center rounded-lg bg-gray-300 dark:bg-gray-600 px-6 py-2.5 text-gray-900 dark:text-white font-semibold hover:bg-gray-400 dark:hover:bg-gray-700 transition">
                <i class="ti ti-x mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
    @include('components.confirm-toastr')
@endpush
