@extends('layouts.admin')

@section('title', 'Edit Kelas')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Edit Kelas',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Kelas', 'url' => route('grades.index')],
        ['name' => 'Edit', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">

    <form action="{{ route('grades.update', $grade->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-6">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Sekolah <span class="text-red-500">*</span>
                </label>
                <select name="school_institution_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('school_institution_id') border-red-500 @enderror">
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach($schoolInstitutions as $schoolInstitution)
                        <option value="{{ $schoolInstitution->id }}" {{ old('school_institution_id', $grade->school_institution_id) == $schoolInstitution->id ? 'selected' : '' }}>{{ $schoolInstitution->name }}</option>
                    @endforeach
                </select>
                @error('school_institution_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Jenjang Sekolah <span class="text-red-500">*</span>
                </label>
                <select name="school_level_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('school_level_id') border-red-500 @enderror">
                    <option value="">-- Pilih Jenjang Sekolah --</option>
                    @foreach($schoolLevels as $schoolLevel)
                        <option value="{{ $schoolLevel->id }}" {{ old('school_level_id', $grade->school_level_id) == $schoolLevel->id ? 'selected' : '' }}>{{ $schoolLevel->name }}</option>
                    @endforeach
                </select>
                @error('school_level_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nama Kelas <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $grade->name) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" placeholder="Contoh: Kelas 7">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nomor Urutan
                </label>
                <input type="number" name="order_no" value="{{ old('order_no', $grade->order_no) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('order_no') border-red-500 @enderror" placeholder="0">
                @error('order_no')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="mb-6">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $grade->is_active) ? 'checked' : '' }} class="w-4 h-4 text-blue-600">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Aktif</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 transition">
                <i class="ti ti-check mr-2"></i>Simpan Perubahan
            </button>
            <a href="{{ route('grades.index') }}" class="inline-flex items-center rounded-lg bg-gray-600 px-6 py-2 text-white hover:bg-gray-700 transition">
                <i class="ti ti-x mr-2"></i>Batal
            </a>
        </div>
    </form>

</div>

@endsection
@push('scripts')
    @include('components.confirm-toastr')
    <script>
        intFilterSelect();
    </script>
@endpush