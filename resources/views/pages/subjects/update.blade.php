@extends('layouts.admin')

@section('title', 'Edit Mata Pelajaran')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Edit Mata Pelajaran',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Mata Pelajaran', 'url' => route('subjects.index')],
        ['name' => 'Edit', 'url' => '#']
    ]
])

<div class="rounded-2xl border border-slate-50 bg-white p-8">

    <div class="mb-8 pb-4 border-b border-slate-100">
        <h2 class="text-xl font-extrabold text-emerald-800 flex items-center gap-2">
            <span class="size-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:book-open" class="text-base"></iconify-icon>
            </span>
            Form Edit Mata Pelajaran
        </h2>
        <p class="text-xs text-slate-400 mt-1">Perbarui kurikulum mata pelajaran (mapel) beserta kode mapel dan keterhubungannya dengan level sekolah.</p>
    </div>

    <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-6">
            
            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Lembaga <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="school_institution_id" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 appearance-none @error('school_institution_id') border-red-500 @enderror">
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach($schoolInstitutions as $schoolInstitution)
                            <option value="{{ $schoolInstitution->id }}" {{ old('school_institution_id', $subject->school_institution_id) == $schoolInstitution->id ? 'selected' : '' }}>{{ $schoolInstitution->name }}</option>
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
                    Sekolah <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="school_level_id" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 appearance-none @error('school_level_id') border-red-500 @enderror">
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach($schoolLevels as $schoolLevel)
                            <option value="{{ $schoolLevel->id }}" {{ old('school_level_id', $subject->school_level_id) == $schoolLevel->id ? 'selected' : '' }}>{{ $schoolLevel->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                        <iconify-icon icon="lucide:chevron-down" class="text-xs"></iconify-icon>
                    </div>
                </div>
                @error('school_level_id')
                    <p class="text-red-655 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Nama Mata Pelajaran <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $subject->name) }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('name') border-red-500 @enderror" placeholder="Contoh: Matematika">
                @error('name')
                    <p class="text-red-655 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Kode Mata Pelajaran
                </label>
                <input type="text" name="code" value="{{ old('code', $subject->code) }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('code') border-red-500 @enderror" placeholder="Contoh: MTK">
                @error('code')
                    <p class="text-red-655 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

        </div>

        <!-- Status -->
        <div class="mb-8">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $subject->is_active) ? 'checked' : '' }}
                    class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 transition-all">
                <span class="text-xs font-black text-slate-600 uppercase tracking-wider">Status Aktif</span>
            </label>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3 pt-6 border-t border-slate-100">
            <button style="background-color: #3b82f6" type="submit" class="inline-flex items-center gap-2 rounded-xl px-6 py-2.5 text-xs font-bold text-white transition-all shadow-sm hover:brightness-105">
                <iconify-icon icon="lucide:check" class="text-sm"></iconify-icon>
                Simpan Perubahan
            </button>
            <a href="{{ route('subjects.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 px-6 py-2.5 text-xs font-bold text-slate-700 transition-all">
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