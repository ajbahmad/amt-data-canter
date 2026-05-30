@extends('layouts.admin')

@section('title', 'Detail Rombel')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Rombel',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Rombel', 'url' => route('class_rooms.index')],
        ['name' => $classRoom->name, 'url' => '#']
    ]
])

<div class="rounded-2xl border border-slate-50 bg-white p-8 shadow-none">

    <div class="mb-8 pb-4 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-xl font-extrabold text-emerald-800 flex items-center gap-2">
            <span class="size-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:school" class="text-base"></iconify-icon>
            </span>
            Rombongan Belajar: {{ $classRoom->name }}
        </h2>
        
        <div class="flex items-center gap-2">
            <a href="{{ route('class_rooms.edit', $classRoom->id) }}" style="background-color: #3b82f6" class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2.5 text-xs font-bold text-white transition-all shadow-sm hover:brightness-105">
                <iconify-icon icon="lucide:edit-2" class="text-sm"></iconify-icon>
                Edit
            </a>
            <button onclick="deleteClassRoom('{{ route('class_rooms.destroy', $classRoom->id) }}')" class="inline-flex items-center gap-1.5 rounded-xl bg-red-50 text-red-650 hover:bg-red-100 px-4 py-2.5 text-xs font-bold transition-all">
                <iconify-icon icon="lucide:trash-2" class="text-sm"></iconify-icon>
                Hapus
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Sekolah / Lembaga</label>
            <p class="text-sm font-bold text-slate-800">{{ $classRoom->schoolInstitution->name ?? '-' }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tahun Akademik</label>
            <p class="text-sm font-bold text-slate-800">{{ $classRoom->schoolYear->name ?? '-' }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tingkat Kelas</label>
            <p class="text-sm font-bold text-slate-800">{{ $classRoom->grade->name ?? '-' }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Nama Rombel</label>
            <p class="text-sm font-bold text-slate-800">{{ $classRoom->name }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Kapasitas Maksimal</label>
            <p class="text-sm font-bold text-slate-800">{{ $classRoom->capacity }} Siswa</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Status Keaktifan</label>
            <div class="mt-1">
                @if($classRoom->is_active)
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-850">
                        Aktif
                    </span>
                @else
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-800">
                        Non-Aktif
                    </span>
                @endif
            </div>
        </div>

    </div>

    <div class="pt-6 border-t border-slate-100 flex items-center">
        <a href="{{ route('class_rooms.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 px-6 py-2.5 text-xs font-bold text-slate-700 transition-all">
            <iconify-icon icon="lucide:arrow-left" class="text-sm"></iconify-icon>
            Kembali
        </a>
    </div>

</div>

@endsection

@push('scripts')
    <script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    <script>
        function deleteClassRoom(url) {
            Swal.fire({
                title: 'Hapus Rombel?',
                text: 'Apakah Anda yakin ingin menghapus data rombel ini? Tindakan ini tidak bisa dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }
    </script>
@endpush
