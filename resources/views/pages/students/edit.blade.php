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

<div class="rounded-2xl border border-slate-50 bg-white p-8">

    <div class="mb-8 pb-4 border-b border-slate-100">
        <h2 class="text-xl font-extrabold text-emerald-800 flex items-center gap-2">
            <span class="size-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:user-check" class="text-base"></iconify-icon>
            </span>
            Form Edit Siswa
        </h2>
        <p class="text-xs text-slate-400 mt-1">Perbarui informasi biodata dan status pendaftaran siswa di bawah ini.</p>
    </div>

    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-6">
            
            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    <i class="ti ti-user mr-1 text-emerald-700"></i>Orang <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="person_id" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 appearance-none @error('person_id') border-red-500 @enderror">
                        <option value="">-- Pilih Orang --</option>
                        @foreach($persons as $person)
                            <option value="{{ $person->id }}" {{ old('person_id', $student->person_id) == $person->id ? 'selected' : '' }}>{{ $person->full_name }} ({{ $person->email }})</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                        <iconify-icon icon="lucide:chevron-down" class="text-xs"></iconify-icon>
                    </div>
                </div>
                @error('person_id')
                    <p class="text-red-655 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    <i class="ti ti-building mr-1 text-emerald-700"></i>Lembaga <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="school_institution_id" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 appearance-none @error('school_institution_id') border-red-500 @enderror">
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach($schoolInstitutions as $school)
                            <option value="{{ $school->id }}" {{ old('school_institution_id', $student->school_institution_id) == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                        <iconify-icon icon="lucide:chevron-down" class="text-xs"></iconify-icon>
                    </div>
                </div>
                @error('school_institution_id')
                    <p class="text-red-655 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    <i class="ti ti-id mr-1 text-emerald-700"></i>Nomor Induk Siswa <span class="text-red-500">*</span>
                </label>
                <input type="text" name="student_id" value="{{ old('student_id', $student->student_id) }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('student_id') border-red-500 @enderror">
                @error('student_id')
                    <p class="text-red-600 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    <i class="ti ti-file mr-1 text-emerald-700"></i>Nomor Pendaftaran
                </label>
                <input type="text" name="enrollment_number" value="{{ old('enrollment_number', $student->enrollment_number) }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('enrollment_number') border-red-500 @enderror">
                @error('enrollment_number')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    <i class="ti ti-calendar mr-1 text-emerald-700"></i>Tanggal Pendaftaran
                </label>
                <input type="date" name="enrollment_date" value="{{ old('enrollment_date', $student->enrollment_date) }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('enrollment_date') border-red-500 @enderror">
                @error('enrollment_date')
                    <p class="text-red-600 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    <i class="ti ti-activity mr-1 text-emerald-700"></i>Status <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="status" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 appearance-none @error('status') border-red-500 @enderror">
                        <option value="">-- Pilih Status --</option>
                        <option value="active" {{ old('status', $student->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="graduated" {{ old('status', $student->status) === 'graduated' ? 'selected' : '' }}>Lulus</option>
                        <option value="dropped_out" {{ old('status', $student->status) === 'dropped_out' ? 'selected' : '' }}>Putus Sekolah</option>
                        <option value="suspended" {{ old('status', $student->status) === 'suspended' ? 'selected' : '' }}>Ditunda</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                        <iconify-icon icon="lucide:chevron-down" class="text-xs"></iconify-icon>
                    </div>
                </div>
                @error('status')
                    <p class="text-red-600 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

        </div>

        <div class="mb-6">
            <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                <i class="ti ti-notes mr-1 text-emerald-700"></i>Catatan
            </label>
            <textarea name="notes" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 resize-none @error('notes') border-red-500 @enderror" placeholder="Tulis catatan penting di sini..." rows="3">{{ old('notes', $student->notes) }}</textarea>
            @error('notes')
                <p class="text-red-600 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                    <i class="ti ti-alert-circle"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-8">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $student->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 transition-all">
                <span class="text-xs font-black text-slate-600 uppercase tracking-wider">Aktif</span>
            </label>
        </div>

        <div class="flex items-center gap-3">
            <button style="background-color: #3b82f6" type="submit" class="inline-flex items-center gap-2 rounded-xl px-6 py-2.5 text-xs font-bold text-white transition-all shadow-sm hover:brightness-105">
                <iconify-icon icon="lucide:check" class="text-sm"></iconify-icon>
                Simpan
            </button>
            <a href="{{ route('students.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 px-6 py-2.5 text-xs font-bold text-slate-700 transition-all">
                <iconify-icon icon="lucide:x" class="text-sm"></iconify-icon>
                Batal
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