@extends('layouts.admin')

@section('title', 'Detail Tahun Akademik')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Tahun Akademik',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Tahun Akademik', 'url' => route('school_years.index')],
        ['name' => 'Detail', 'url' => '#']
    ]
])

<div class="rounded-2xl border border-slate-50 bg-white p-8 shadow-none">
    
    <div class="mb-8 pb-4 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-xl font-extrabold text-emerald-800 flex items-center gap-2">
            <span class="size-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:calendar" class="text-base"></iconify-icon>
            </span>
            Tahun Akademik: {{ $schoolYear->name }}
        </h2>
        
        <div class="flex items-center gap-2">
            <a href="{{ route('school_years.edit', $schoolYear) }}" style="background-color: #3b82f6" class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2.5 text-xs font-bold text-white transition-all shadow-sm hover:brightness-105">
                <iconify-icon icon="lucide:edit-2" class="text-sm"></iconify-icon>
                Edit
            </a>
            <button class="inline-flex items-center gap-1.5 rounded-xl bg-red-50 text-red-655 hover:bg-red-100 px-4 py-2.5 text-xs font-bold transition-all delete-btn" data-id="{{ $schoolYear->id }}">
                <iconify-icon icon="lucide:trash-2" class="text-sm"></iconify-icon>
                Hapus
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Sekolah</label>
            <p class="text-sm font-bold text-slate-800">{{ $schoolYear->schoolInstitution->name }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tahun Akademik</label>
            <p class="text-sm font-bold text-slate-800">{{ $schoolYear->name }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tanggal Mulai</label>
            <p class="text-sm font-bold text-slate-800">{{ $schoolYear->start_date->translatedFormat('d F Y') }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tanggal Akhir</label>
            <p class="text-sm font-bold text-slate-800">{{ $schoolYear->end_date->translatedFormat('d F Y') }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Status Keaktifan</label>
            <div class="mt-1">
                @if($schoolYear->is_active)
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

    <!-- Periode Akademik -->
    <div class="mb-8 pb-6 border-b border-slate-100">
        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">Periode Rentang Waktu</label>
        <p class="text-sm font-bold text-slate-800 bg-slate-50 p-4 rounded-lg border border-slate-100 leading-relaxed">
            {{ $schoolYear->start_date->translatedFormat('d F Y') }} s/d {{ $schoolYear->end_date->translatedFormat('d F Y') }}
        </p>
    </div>

    <!-- Informasi Waktu -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Dibuat Pada</label>
            <p class="text-xs font-bold text-slate-500">{{ $schoolYear->created_at->translatedFormat('d F Y - H:i') }}</p>
        </div>
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Diperbarui Pada</label>
            <p class="text-xs font-bold text-slate-500">{{ $schoolYear->updated_at->translatedFormat('d F Y - H:i') }}</p>
        </div>
    </div>

    <!-- Navigation Back -->
    <div class="pt-6 border-t border-slate-100 flex items-center">
        <a href="{{ route('school_years.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 px-6 py-2.5 text-xs font-bold text-slate-700 transition-all">
            <iconify-icon icon="lucide:arrow-left" class="text-sm"></iconify-icon>
            Kembali
        </a>
    </div>

</div>

@endsection

@push('scripts')
<script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
<script>
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        let deleteUrl = '{{ route("school_years.destroy", ":id") }}'.replace(':id', id);
        
        Swal.fire({
            title: 'Hapus Tahun Akademik?',
            text: 'Apakah Anda yakin ingin menghapus data tahun akademik ini? Tindakan ini tidak dapat dibatalkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create and submit a DELETE form
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;
                form.innerHTML = `
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
</script>
@endpush
