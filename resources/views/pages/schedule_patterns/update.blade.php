@extends('layouts.admin')

@section('title', 'Edit Pola Jadwal')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Edit Pola Jadwal',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Akademik', 'url' => '#'],
        ['name' => 'Pola Jadwal', 'url' => route('schedule_patterns.index')],
        ['name' => 'Edit Pola', 'url' => '#']
    ]
])

<div class="rounded-2xl border border-slate-50 bg-white p-8">

    <div class="mb-8 pb-4 border-b border-slate-100">
        <h2 class="text-xl font-extrabold text-emerald-800 flex items-center gap-2">
            <span class="size-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:calendar" class="text-base"></iconify-icon>
            </span>
            Form Edit Pola Jadwal
        </h2>
        <p class="text-xs text-slate-400 mt-1">Perbarui nama dan keterangan pola jadwal sekolah. Lembaga dan jenjang tidak dapat diubah setelah dibuat.</p>
    </div>

    <form action="{{ route('schedule_patterns.update', $schedulePattern->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Hidden Inputs for Immutable values to satisfy Laravel validation -->
        <input type="hidden" name="school_institution_id" value="{{ $schedulePattern->school_institution_id }}">
        <input type="hidden" name="school_level_id" value="{{ $schedulePattern->school_level_id }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Lembaga/Institusi (Disabled) -->
            <div>
                <label class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2">
                    Lembaga <span class="text-slate-300">(Tidak dapat diubah)</span>
                </label>
                <div class="relative">
                    <select disabled class="w-full text-sm border border-slate-200 rounded-lg outline-none text-slate-400 font-medium px-4 py-3 bg-slate-50 appearance-none">
                        <option selected>{{ $schedulePattern->schoolInstitution->name }}</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-300">
                        <iconify-icon icon="lucide:lock" class="text-xs"></iconify-icon>
                    </div>
                </div>
            </div>

            <!-- Level Sekolah (Disabled) -->
            <div>
                <label class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2">
                    Sekolah <span class="text-slate-300">(Tidak dapat diubah)</span>
                </label>
                <div class="relative">
                    <select disabled class="w-full text-sm border border-slate-200 rounded-lg outline-none text-slate-400 font-medium px-4 py-3 bg-slate-50 appearance-none">
                        <option selected>{{ $schedulePattern->schoolLevel->name }}</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-300">
                        <iconify-icon icon="lucide:lock" class="text-xs"></iconify-icon>
                    </div>
                </div>
            </div>

            <!-- Nama Pola Jadwal -->
            <div class="col-span-2">
                <label for="name" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Nama Pola Jadwal <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $schedulePattern->name) }}" required
                    class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('name') border-red-500 @enderror"
                    placeholder="Contoh: Jam Belajar Normal">
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
                placeholder="Masukkan deskripsi pola jadwal">{{ old('description', $schedulePattern->description) }}</textarea>
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
                Simpan Perubahan
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
@endpush
