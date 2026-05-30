@extends('layouts.admin')

@section('title', 'Tambah Lembaga')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Tambah Lembaga',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Lembaga', 'url' => route('school_institutions.index')],
        ['name' => 'Tambah Baru', 'url' => '#']
    ]
])

<div class="rounded-2xl border border-slate-50 bg-white p-8">

    <div class="mb-8 pb-4 border-b border-slate-100">
        <h2 class="text-xl font-extrabold text-emerald-800 flex items-center gap-2">
            <span class="size-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:building" class="text-base"></iconify-icon>
            </span>
            Form Tambah Lembaga
        </h2>
        <p class="text-xs text-slate-400 mt-1">Lengkapi informasi kode sekolah, nama unit lembaga, serta kontak operasional di bawah ini.</p>
    </div>

    <form action="{{ route('school_institutions.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Kode Sekolah -->
            <div>
                <label for="code" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Kode Sekolah <span class="text-red-500">*</span>
                </label>
                <input type="text" id="code" name="code" value="{{ old('code') }}" required
                    class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('code') border-red-500 @enderror"
                    placeholder="Contoh: SD-001">
                @error('code')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Nama Sekolah -->
            <div>
                <label for="name" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Nama Sekolah <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('name') border-red-500 @enderror"
                    placeholder="Masukkan nama sekolah">
                @error('name')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Email
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('email') border-red-500 @enderror"
                    placeholder="email@sekolah.com">
                @error('email')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Telepon -->
            <div>
                <label for="phone" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Telepon
                </label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                    class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('phone') border-red-500 @enderror"
                    placeholder="Nomor telepon sekolah">
                @error('phone')
                    <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Alamat -->
        <div class="mb-6">
            <label for="address" class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                Alamat Lengkap
            </label>
            <textarea id="address" name="address" rows="3"
                class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 resize-none @error('address') border-red-500 @enderror"
                placeholder="Masukkan alamat lengkap sekolah">{{ old('address') }}</textarea>
            @error('address')
                <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                    <i class="ti ti-alert-circle"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Status -->
        <div class="mb-8">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                    class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 transition-all">
                <span class="text-xs font-black text-slate-600 uppercase tracking-wider">Status Aktif</span>
            </label>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3 pt-6 border-t border-slate-100">
            <button style="background-color: #3b82f6" type="submit" class="inline-flex items-center gap-2 rounded-xl px-6 py-2.5 text-xs font-bold text-white transition-all shadow-sm hover:brightness-105">
                <iconify-icon icon="lucide:check" class="text-sm"></iconify-icon>
                Simpan
            </button>
            <a href="{{ route('school_institutions.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 px-6 py-2.5 text-xs font-bold text-slate-700 transition-all">
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