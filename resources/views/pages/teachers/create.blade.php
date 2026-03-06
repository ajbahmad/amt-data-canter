@extends('layouts.admin')

@section('title', 'Tambah Guru')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Tambah Guru',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Guru', 'url' => route('teachers.index')],
        ['name' => 'Tambah', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">

    <form action="{{ route('teachers.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-6">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Orang <span class="text-red-500">*</span>
                </label>
                <select name="person_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('person_id') border-red-500 @enderror">
                    <option value="">-- Pilih Orang --</option>
                    @foreach($persons as $person)
                        <option value="{{ $person->id }}" {{ old('person_id') == $person->id ? 'selected' : '' }}>{{ $person->full_name }} ({{ $person->email }})</option>
                    @endforeach
                </select>
                @error('person_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Sekolah <span class="text-red-500">*</span>
                </label>
                <select name="school_institution_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('school_institution_id') border-red-500 @enderror">
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach($schoolInstitutions as $school)
                        <option value="{{ $school->id }}" {{ old('school_institution_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                    @endforeach
                </select>
                @error('school_institution_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nomor Induk Guru <span class="text-red-500">*</span>
                </label>
                <input type="text" name="teacher_id" value="{{ old('teacher_id') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('teacher_id') border-red-500 @enderror" placeholder="Contoh: GUR-00001">
                @error('teacher_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nomor Sertifikasi
                </label>
                <input type="text" name="certification_number" value="{{ old('certification_number') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('certification_number') border-red-500 @enderror" placeholder="Nomor sertifikasi">
                @error('certification_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Tanggal Diangkat
                </label>
                <input type="date" name="hire_date" value="{{ old('hire_date') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('hire_date') border-red-500 @enderror">
                @error('hire_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Tipe Kepegawaian <span class="text-red-500">*</span>
                </label>
                <select name="employment_type" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('employment_type') border-red-500 @enderror">
                    <option value="">-- Pilih Tipe Kepegawaian --</option>
                    <option value="permanent" {{ old('employment_type') === 'permanent' ? 'selected' : '' }}>Tetap</option>
                    <option value="contract" {{ old('employment_type') === 'contract' ? 'selected' : '' }}>Kontrak</option>
                    <option value="honorary" {{ old('employment_type') === 'honorary' ? 'selected' : '' }}>Honorer</option>
                </select>
                @error('employment_type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                    <option value="">-- Pilih Status --</option>
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="retired" {{ old('status') === 'retired' ? 'selected' : '' }}>Pensiun</option>
                    <option value="resigned" {{ old('status') === 'resigned' ? 'selected' : '' }}>Mengundurkan Diri</option>
                    <option value="on_leave" {{ old('status') === 'on_leave' ? 'selected' : '' }}>Cuti</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Keahlian/Spesialisasi
                </label>
                <textarea name="specialization" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('specialization') border-red-500 @enderror" placeholder="Keahlian atau spesialisasi guru" rows="3">{{ old('specialization') }}</textarea>
                @error('specialization')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Catatan
            </label>
            <textarea name="notes" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('notes') border-red-500 @enderror" placeholder="Catatan tambahan" rows="3">{{ old('notes') }}</textarea>
            @error('notes')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} class="w-4 h-4 text-blue-600">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Aktif</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 transition">
                <i class="ti ti-check mr-2"></i>Simpan
            </button>
            <a href="{{ route('teachers.index') }}" class="inline-flex items-center rounded-lg bg-gray-300 dark:bg-gray-600 px-6 py-2 text-gray-800 dark:text-white hover:bg-gray-400 dark:hover:bg-gray-700 transition">
                <i class="ti ti-x mr-2"></i>Batal
            </a>
        </div>

    </form>

</div>

@endsection
