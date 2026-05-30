@extends('layouts.admin')

@section('title', 'Tambah Tahun Akademik')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Tambah Tahun Akademik',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Tahun Akademik', 'url' => route('school_years.index')],
        ['name' => 'Tambah Baru', 'url' => '#']
    ]
])

<div class="rounded-2xl border border-slate-50 bg-white p-8">

    <div class="mb-8 pb-4 border-b border-slate-100">
        <h2 class="text-xl font-extrabold text-emerald-800 flex items-center gap-2">
            <span class="size-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:calendar" class="text-base"></iconify-icon>
            </span>
            Form Tambah Tahun Akademik
        </h2>
        <p class="text-xs text-slate-400 mt-1">Daftarkan tahun ajaran akademik baru lengkap dengan tanggal mulai dan tanggal berakhir.</p>
    </div>

    <form action="{{ route('school_years.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Sekolah -->
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

            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Sekolah <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="school_level_id" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 appearance-none @error('school_level_id') border-red-500 @enderror">
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach($schoolLevels as $schoolLevel)
                            <option value="{{ $schoolLevel->id }}" {{ old('school_level_id') == $schoolLevel->id ? 'selected' : '' }}>{{ $schoolLevel->name }}</option>
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
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Tahun Akademik -->
            <div>
                <label for="name" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Tahun Akademik <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('name') border-red-500 @enderror"
                    placeholder="Contoh: 2025/2026">
                @error('name')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Tanggal Mulai -->
            <div>
                <label for="start_date" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Tanggal Mulai <span class="text-red-500">*</span>
                </label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" required
                    class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('start_date') border-red-500 @enderror">
                @error('start_date')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Tanggal Akhir -->
            <div>
                <label for="end_date" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Tanggal Akhir <span class="text-red-500">*</span>
                </label>
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" required
                    class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('end_date') border-red-500 @enderror">
                @error('end_date')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Status -->
        <div class="mb-8">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                    class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 transition-all">
                <span class="text-xs font-black text-slate-600 uppercase tracking-wider">Status Aktif</span>
            </label>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex items-center gap-3 pt-6 border-t border-slate-100">
            <button style="background-color: #3b82f6" type="submit" class="inline-flex items-center gap-2 rounded-xl px-6 py-2.5 text-xs font-bold text-white transition-all shadow-sm hover:brightness-105">
                <iconify-icon icon="lucide:check" class="text-sm"></iconify-icon>
                Simpan
            </button>
            <a href="{{ route('school_years.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 px-6 py-2.5 text-xs font-bold text-slate-700 transition-all">
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