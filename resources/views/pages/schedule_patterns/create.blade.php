@extends('layouts.admin')

@section('title', 'Tambah Pola Jadwal')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Tambah Pola Jadwal',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Akademik', 'url' => '#'],
        ['name' => 'Pola Jadwal', 'url' => route('schedule_patterns.index')],
        ['name' => 'Tambah Baru', 'url' => '#'],
    ],
])

<div class="rounded-2xl border border-slate-50 bg-white p-8">

    <div class="mb-8 pb-4 border-b border-slate-100">
        <h2 class="text-xl font-extrabold text-emerald-800 flex items-center gap-2">
            <span class="size-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:calendar" class="text-base"></iconify-icon>
            </span>
            Form Tambah Pola Jadwal
        </h2>
        <p class="text-xs text-slate-400 mt-1">Daftarkan pola jadwal mingguan baru (dengan hari belajar Senin-Sabtu secara default) ke dalam database.</p>
    </div>

    <form action="{{ route('schedule_patterns.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Lembaga/Institusi -->
            <div>
                <label for="school_institution_id" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Lembaga <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select id="school_institution_id" name="school_institution_id" required class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 appearance-none @error('school_institution_id') border-red-500 @enderror">
                        <option value="">-- Pilih Lembaga --</option>
                        @forelse($schoolInstitutions as $school)
                            <option value="{{ $school->id }}" {{ old('school_institution_id') == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                        @empty
                            <option value="" disabled>Tidak ada lembaga aktif</option>
                        @endforelse
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                        <iconify-icon icon="lucide:chevron-down" class="text-xs"></iconify-icon>
                    </div>
                </div>
                @error('school_institution_id')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Level Sekolah -->
            <div>
                <label for="school_level_id" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Sekolah <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select id="school_level_id" name="school_level_id" required class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 appearance-none @error('school_level_id') border-red-500 @enderror">
                        <option value="">-- Pilih Sekolah --</option>
                        @forelse($schoolLevels as $level)
                            <option value="{{ $level->id }}" {{ old('school_level_id') == $level->id ? 'selected' : '' }}>
                                {{ $level->name }}
                            </option>
                        @empty
                            <option value="" disabled>Tidak ada sekolah aktif</option>
                        @endforelse
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                        <iconify-icon icon="lucide:chevron-down" class="text-xs"></iconify-icon>
                    </div>
                </div>
                @error('school_level_id')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Nama Pola Jadwal -->
            <div class="col-span-2">
                <label for="name" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Nama Pola Jadwal <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('name') border-red-500 @enderror"
                    placeholder="Contoh: Jam Belajar Normal, Jam Belajar Khusus Ramadhan">
                @error('name')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="mb-8">
            <label for="description" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                Deskripsi
            </label>
            <textarea id="description" name="description" rows="3"
                class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 resize-none @error('description') border-red-500 @enderror"
                placeholder="Masukkan deskripsi pola jadwal (misal: Jam belajar untuk semester ganjil)">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                    <i class="ti ti-alert-circle"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3 pt-6 border-t border-slate-100">
            <button style="background-color: #3b82f6" type="submit" class="inline-flex items-center gap-2 rounded-xl px-6 py-2.5 text-xs font-bold text-white transition-all shadow-sm hover:brightness-105">
                <iconify-icon icon="lucide:check" class="text-sm"></iconify-icon>
                Simpan
            </button>
            <a href="{{ route('schedule_patterns.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 px-6 py-2.5 text-xs font-bold text-slate-700 transition-all">
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
