@extends('layouts.admin')

@section('title', 'Detail Semester')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Semester',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Semester', 'url' => route('semesters.index')],
        ['name' => 'Detail', 'url' => '#']
    ]
])

<div class="rounded-2xl border border-slate-50 bg-white p-8 shadow-none">
    
    <div class="mb-8 pb-4 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-xl font-extrabold text-emerald-800 flex items-center gap-2">
            <span class="size-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:calendar-days" class="text-base"></iconify-icon>
            </span>
            Semester: {{ $semester->name }}
        </h2>
        
        <div class="flex items-center gap-2">
            <a href="{{ route('semesters.edit', $semester->id) }}" style="background-color: #3b82f6" class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2.5 text-xs font-bold text-white transition-all shadow-sm hover:brightness-105">
                <iconify-icon icon="lucide:edit-2" class="text-sm"></iconify-icon>
                Edit
            </a>
            <button onclick="deleteSemester('{{ route('semesters.destroy', $semester->id) }}')" class="inline-flex items-center gap-1.5 rounded-xl bg-red-50 text-red-655 hover:bg-red-100 px-4 py-2.5 text-xs font-bold transition-all">
                <iconify-icon icon="lucide:trash-2" class="text-sm"></iconify-icon>
                Hapus
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tahun Akademik</label>
            <p class="text-sm font-bold text-slate-800">{{ $semester->schoolYear->name ?? '-' }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Nama Semester</label>
            <p class="text-sm font-bold text-slate-800">{{ $semester->name }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tanggal Mulai</label>
            <p class="text-sm font-bold text-slate-800">
                {{ $semester->start_date ? \Carbon\Carbon::parse($semester->start_date)->translatedFormat('d F Y') : '-' }}
            </p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tanggal Akhir</label>
            <p class="text-sm font-bold text-slate-800">
                {{ $semester->end_date ? \Carbon\Carbon::parse($semester->end_date)->translatedFormat('d F Y') : '-' }}
            </p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Status Keaktifan</label>
            <div class="mt-1">
                @if($semester->is_active)
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

    <!-- Navigation Back -->
    <div class="pt-6 border-t border-slate-100 flex items-center">
        <a href="{{ route('semesters.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 px-6 py-2.5 text-xs font-bold text-slate-700 transition-all">
            <iconify-icon icon="lucide:arrow-left" class="text-sm"></iconify-icon>
            Kembali
        </a>
    </div>

</div>

@endsection

@push('scripts')
    <script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    <script>
        function deleteSemester(url) {
            Swal.fire({
                title: 'Hapus Semester?',
                html: 'Apakah Anda yakin ingin menghapus data ini? Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }
    </script>
@endpush
