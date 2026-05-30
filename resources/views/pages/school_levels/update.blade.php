@extends('layouts.admin')

@section('title', 'Edit Sekolah')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Edit Sekolah',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Sekolah', 'url' => route('school_levels.index')],
        ['name' => 'Edit', 'url' => '#']
    ]
])

<div class="rounded-2xl border border-slate-50 bg-white p-8">

    <div class="mb-8 pb-4 border-b border-slate-100">
        <h2 class="text-xl font-extrabold text-emerald-800 flex items-center gap-2">
            <span class="size-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:layers" class="text-base"></iconify-icon>
            </span>
            Form Edit Level Sekolah
        </h2>
        <p class="text-xs text-slate-400 mt-1">Perbarui tingkatan level jenjang pendidikan (seperti SD, SMP, SMA) ke dalam sistem database.</p>
    </div>

    <form action="{{ route('school_levels.update', $schoolLevel) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="col-span-2">
                <label for="school_institution_id" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Lembaga <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select id="school_institution_id" name="school_institution_id" required class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 appearance-none @error('school_institution_id') border-red-500 @enderror">
                        <option value="">-- Pilih Lembaga --</option>
                        @forelse($schoolInstitutions as $school)
                            <option value="{{ $school->id }}" {{ $schoolLevel->school_institution_id == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                        @empty
                            <option value="" disabled>Tidak ada sekolah aktif</option>
                        @endforelse
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

            <!-- Kode Level -->
            <div>
                <label for="code" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Kode Level <span class="text-red-500">*</span>
                </label>
                <input type="text" id="code" name="code" value="{{ old('code', $schoolLevel->code) }}" required
                    class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('code') border-red-500 @enderror"
                    placeholder="Contoh: sd, smp, sma, smk">
                @error('code')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Nama Level -->
            <div>
                <label for="name" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Nama Level <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $schoolLevel->name) }}" required
                    class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('name') border-red-500 @enderror"
                    placeholder="Contoh: Sekolah Dasar, Sekolah Menengah Pertama">
                @error('name')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- NPSN -->
            <div class="col-span-2">
                <label for="npsn" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    NPSN
                </label>
                <input type="text" id="npsn" name="npsn" value="{{ old('npsn', $schoolLevel->npsn) }}"
                    class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('npsn') border-red-500 @enderror"
                    placeholder="Masukkan NPSN (Opsional)">
                @error('npsn')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="mb-6">
            <label for="description" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                Deskripsi
            </label>
            <textarea id="description" name="description" rows="3"
                class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 resize-none @error('description') border-red-500 @enderror"
                placeholder="Masukkan deskripsi Sekolah">{{ old('description', $schoolLevel->description) }}</textarea>
            @error('description')
                <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                    <i class="ti ti-alert-circle"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Status -->
        <div class="mb-8">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $schoolLevel->is_active) ? 'checked' : '' }}
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
            <a href="{{ route('school_levels.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 px-6 py-2.5 text-xs font-bold text-slate-700 transition-all">
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