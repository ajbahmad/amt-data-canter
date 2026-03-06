@extends('layouts.admin')

@section('title', 'Edit Siswa')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Edit Siswa',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Siswa', 'url' => route('students.index')],
        ['name' => 'Edit', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 bg-white p-6">

    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-6">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Orang <span class="text-red-500">*</span>
                </label>
                <select name="person_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('person_id') border-red-500 @enderror">
                    <option value="">-- Pilih Orang --</option>
                    @foreach($persons as $person)
                        <option value="{{ $person->id }}" {{ old('person_id', $student->person_id) == $person->id ? 'selected' : '' }}>{{ $person->full_name }} ({{ $person->email }})</option>
                    @endforeach
                </select>
                @error('person_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Sekolah <span class="text-red-500">*</span>
                </label>
                <select name="school_institution_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('school_institution_id') border-red-500 @enderror">
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach($schoolInstitutions as $school)
                        <option value="{{ $school->id }}" {{ old('school_institution_id', $student->school_institution_id) == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                    @endforeach
                </select>
                @error('school_institution_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Induk Siswa <span class="text-red-500">*</span>
                </label>
                <input type="text" name="student_id" value="{{ old('student_id', $student->student_id) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('student_id') border-red-500 @enderror">
                @error('student_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Pendaftaran
                </label>
                <input type="text" name="enrollment_number" value="{{ old('enrollment_number', $student->enrollment_number) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('enrollment_number') border-red-500 @enderror">
                @error('enrollment_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Pendaftaran
                </label>
                <input type="date" name="enrollment_date" value="{{ old('enrollment_date', $student->enrollment_date) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('enrollment_date') border-red-500 @enderror">
                @error('enrollment_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                    <option value="">-- Pilih Status --</option>
                    <option value="active" {{ old('status', $student->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="graduated" {{ old('status', $student->status) === 'graduated' ? 'selected' : '' }}>Lulus</option>
                    <option value="dropped_out" {{ old('status', $student->status) === 'dropped_out' ? 'selected' : '' }}>Putus Sekolah</option>
                    <option value="suspended" {{ old('status', $student->status) === 'suspended' ? 'selected' : '' }}>Ditunda</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Catatan
            </label>
            <textarea name="notes" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('notes') border-red-500 @enderror" placeholder="Catatan tambahan" rows="3">{{ old('notes', $student->notes) }}</textarea>
            @error('notes')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $student->is_active) ? 'checked' : '' }} class="w-4 h-4 text-blue-600">
                <span class="text-sm font-medium text-gray-700">Aktif</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 transition">
                <i class="ti ti-check mr-2"></i>Simpan
            </button>
            <a href="{{ route('students.show', $student->id) }}" class="inline-flex items-center rounded-lg bg-gray-300 px-6 py-2 text-gray-800 hover:bg-gray-400 transition">
                <i class="ti ti-x mr-2"></i>Batal
            </a>
        </div>

    </form>

</div>

@endsection
