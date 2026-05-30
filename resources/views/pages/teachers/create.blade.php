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

<div class="rounded-2xl border border-slate-50 bg-white p-8">

    <div class="mb-8 pb-4 border-b border-slate-100">
        <h2 class="text-xl font-extrabold text-emerald-800 flex items-center gap-2">
            <span class="size-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:user-plus" class="text-base"></iconify-icon>
            </span>
            Form Tambah Guru
        </h2>
        <p class="text-xs text-slate-400 mt-1">Lengkapi informasi biodata dan detail kepegawaian guru baru di bawah ini.</p>
    </div>

    <form action="{{ route('teachers.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-6">
            
            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    <i class="ti ti-user mr-1 text-emerald-700"></i>Orang <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="person_id" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 appearance-none @error('person_id') border-red-500 @enderror">
                        <option value="">-- Pilih Orang --</option>
                        @foreach($persons as $person)
                            <option value="{{ $person->id }}" {{ old('person_id') == $person->id ? 'selected' : '' }}>{{ $person->full_name }} ({{ $person->email }})</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                        <iconify-icon icon="lucide:chevron-down" class="text-xs"></iconify-icon>
                    </div>
                </div>
                @error('person_id')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
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
                            <option value="{{ $school->id }}" {{ old('school_institution_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
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
                    <i class="ti ti-id mr-1 text-emerald-700"></i>Nomor Induk Guru <span class="text-red-500">*</span>
                </label>
                <input type="text" name="teacher_id" value="{{ old('teacher_id') }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('teacher_id') border-red-500 @enderror" placeholder="Contoh: GUR-00001">
                @error('teacher_id')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    <i class="ti ti-award mr-1 text-emerald-700"></i>Nomor Sertifikasi
                </label>
                <input type="text" name="certification_number" value="{{ old('certification_number') }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('certification_number') border-red-500 @enderror" placeholder="Nomor sertifikasi">
                @error('certification_number')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    <i class="ti ti-calendar mr-1 text-emerald-700"></i>Tanggal Diangkat
                </label>
                <input type="date" name="hire_date" value="{{ old('hire_date') }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('hire_date') border-red-500 @enderror">
                @error('hire_date')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    <i class="ti ti-briefcase mr-1 text-emerald-700"></i>Tipe Kepegawaian <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="employment_type" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 appearance-none @error('employment_type') border-red-500 @enderror">
                        <option value="">-- Pilih Tipe Kepegawaian --</option>
                        <option value="permanent" {{ old('employment_type') === 'permanent' ? 'selected' : '' }}>Tetap</option>
                        <option value="contract" {{ old('employment_type') === 'contract' ? 'selected' : '' }}>Kontrak</option>
                        <option value="honorary" {{ old('employment_type') === 'honorary' ? 'selected' : '' }}>Honorer</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                        <iconify-icon icon="lucide:chevron-down" class="text-xs"></iconify-icon>
                    </div>
                </div>
                @error('employment_type')
                    <p class="text-red-655 text-[10px] mt-1.5 font-bold flex items-center gap-1">
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
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="retired" {{ old('status') === 'retired' ? 'selected' : '' }}>Pensiun</option>
                        <option value="resigned" {{ old('status') === 'resigned' ? 'selected' : '' }}>Mengundurkan Diri</option>
                        <option value="on_leave" {{ old('status') === 'on_leave' ? 'selected' : '' }}>Cuti</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                        <iconify-icon icon="lucide:chevron-down" class="text-xs"></iconify-icon>
                    </div>
                </div>
                @error('status')
                    <p class="text-red-655 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

        </div>

        <div class="mb-6">
            <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                <i class="ti ti-sparkles mr-1 text-emerald-700"></i>Keahlian / Spesialisasi
            </label>
            <textarea name="specialization" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 resize-none @error('specialization') border-red-500 @enderror" placeholder="Keahlian atau spesialisasi guru..." rows="2">{{ old('specialization') }}</textarea>
            @error('specialization')
                <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                    <i class="ti ti-alert-circle"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                <i class="ti ti-notes mr-1 text-emerald-700"></i>Catatan
            </label>
            <textarea name="notes" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 resize-none @error('notes') border-red-500 @enderror" placeholder="Catatan tambahan..." rows="3">{{ old('notes') }}</textarea>
            @error('notes')
                <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                    <i class="ti ti-alert-circle"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-8">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 transition-all">
                <span class="text-xs font-black text-slate-600 uppercase tracking-wider">Aktif</span>
            </label>
        </div>

        <div class="flex items-center gap-3">
            <button style="background-color: #3b82f6" type="submit" class="inline-flex items-center gap-2 rounded-xl px-6 py-2.5 text-xs font-bold text-white transition-all shadow-sm hover:brightness-105">
                <iconify-icon icon="lucide:check" class="text-sm"></iconify-icon>
                Simpan
            </button>
            <a href="{{ route('teachers.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 px-6 py-2.5 text-xs font-bold text-slate-700 transition-all">
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