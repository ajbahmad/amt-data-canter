@extends('layouts.admin')

@section('title', 'Edit Staf')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Edit Staf',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Staf', 'url' => route('staffs.index')],
        ['name' => 'Edit', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
    <form action="{{ route('staffs.update', $staff) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Orang <span class="text-red-500">*</span>
                </label>
                <select name="person_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('person_id') border-red-500 @enderror">
                    <option value="">-- Pilih Orang --</option>
                    @foreach($persons as $person)
                        <option value="{{ $person->id }}" {{ old('person_id', $staff->person_id) == $person->id ? 'selected' : '' }}>
                            {{ $person->full_name }} ({{ $person->email }})
                        </option>
                    @endforeach
                </select>
                @error('person_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Lembaga <span class="text-red-500">*</span>
                </label>
                <select name="school_institution_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('school_institution_id') border-red-500 @enderror">
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach($schoolInstitutions as $school)
                        <option value="{{ $school->id }}" {{ old('school_institution_id', $staff->school_institution_id) == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_institution_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    ID Staf <span class="text-red-500">*</span>
                </label>
                <input type="text" name="staff_id" value="{{ old('staff_id', $staff->staff_id) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('staff_id') border-red-500 @enderror" placeholder="ID Staf">
                @error('staff_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Posisi <span class="text-red-500">*</span>
                </label>
                <input type="text" name="position" value="{{ old('position', $staff->position) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('position') border-red-500 @enderror" placeholder="Posisi/Jabatan">
                @error('position')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Departemen
                </label>
                <input type="text" name="department" value="{{ old('department', $staff->department) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500" placeholder="Nama Departemen">
                @error('department')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Tanggal Diangkat
                </label>
                <input type="date" name="hire_date" value="{{ old('hire_date', $staff->hire_date?->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('hire_date') border-red-500 @enderror">
                @error('hire_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Jenis Kepegawaian <span class="text-red-500">*</span>
                </label>
                <select name="employment_type" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('employment_type') border-red-500 @enderror">
                    <option value="">-- Pilih Jenis Kepegawaian --</option>
                    <option value="permanent" {{ old('employment_type', $staff->employment_type) === 'permanent' ? 'selected' : '' }}>Tetap</option>
                    <option value="contract" {{ old('employment_type', $staff->employment_type) === 'contract' ? 'selected' : '' }}>Kontrak</option>
                    <option value="honorary" {{ old('employment_type', $staff->employment_type) === 'honorary' ? 'selected' : '' }}>Honorer</option>
                </select>
                @error('employment_type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                    <option value="">-- Pilih Status --</option>
                    <option value="active" {{ old('status', $staff->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ old('status', $staff->status) === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="on_leave" {{ old('status', $staff->status) === 'on_leave' ? 'selected' : '' }}>Cuti</option>
                </select>
                @error('status')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Catatan
                </label>
                <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('notes') border-red-500 @enderror" placeholder="Catatan tambahan">{{ old('notes', $staff->notes) }}</textarea>
                @error('notes')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $staff->is_active) ? 'checked' : '' }} class="rounded dark:bg-gray-700">
                    <span class="ml-2">Aktif</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 transition">
                <i class="ti ti-check mr-2"></i>Update
            </button>
            <a href="{{ route('staffs.show', $staff) }}" class="inline-flex items-center rounded-lg bg-gray-300 dark:bg-gray-700 px-6 py-2 text-gray-800 dark:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600 transition">
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