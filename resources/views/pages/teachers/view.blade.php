@extends('layouts.admin')

@section('title', 'Detail Guru')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Guru',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Guru', 'url' => route('teachers.index')],
        ['name' => $teacher->person->full_name, 'url' => '#']
    ]
])

<div class="grid grid-cols-1 gap-6 md:grid-cols-3 mb-6">

    <!-- Profil Card -->
    <div class="rounded-2xl border border-slate-50 bg-white p-6 shadow-none flex flex-col justify-between">
        <div>
            <div class="text-center mb-6">
                @if($teacher->person->photo)
                    <img src="{{ asset('storage/' . $teacher->person->photo) }}" alt="{{ $teacher->person->full_name }}" class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-emerald-50">
                @else
                    <div class="w-32 h-32 rounded-full mx-auto bg-slate-50 flex items-center justify-center border-4 border-emerald-50">
                        <iconify-icon icon="lucide:user" class="text-5xl text-emerald-800/40"></iconify-icon>
                    </div>
                @endif
            </div>

            <h2 class="text-xl font-extrabold text-center text-slate-800 mb-1">
                {{ $teacher->person->full_name }}
            </h2>

            <p class="text-center text-xs font-bold text-emerald-800 bg-emerald-50 rounded-full px-3 py-1 w-max mx-auto mb-6">
                {{ $teacher->teacher_id }}
            </p>
        </div>

        <div class="flex gap-3 pt-6 border-t border-slate-100">
            <a href="{{ route('teachers.edit', $teacher->id) }}" style="background-color: #3b82f6" class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl px-4 py-2.5 text-xs font-bold text-white transition-all shadow-sm hover:brightness-105">
                <iconify-icon icon="lucide:edit-2" class="text-sm"></iconify-icon>
                Edit
            </a>
            <button onclick="deleteData('{{ $teacher->id }}', '{{ route('teachers.destroy', $teacher->id) }}')" class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl bg-red-50 text-red-650 hover:bg-red-100 px-4 py-2.5 text-xs font-bold transition-all">
                <iconify-icon icon="lucide:trash-2" class="text-sm"></iconify-icon>
                Hapus
            </button>
        </div>
    </div>

    <!-- Informasi Guru Card -->
    <div class="md:col-span-2 rounded-2xl border border-slate-50 bg-white p-6 shadow-none">
        <h3 class="text-md font-extrabold text-emerald-800 mb-6 flex items-center gap-2 pb-3 border-b border-slate-100">
            <span class="size-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:info" class="text-sm"></iconify-icon>
            </span>
            Informasi Guru
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Nomor Induk Guru</label>
                <p class="text-sm font-bold text-slate-800">{{ $teacher->teacher_id }}</p>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Sekolah</label>
                <p class="text-sm font-bold text-slate-800">{{ $teacher->schoolInstitution->name }}</p>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tipe Kepegawaian</label>
                <p class="text-sm font-bold text-slate-800">{{ ucfirst(str_replace('_', ' ', $teacher->employment_type)) }}</p>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Status Kepegawaian</label>
                <div>
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold 
                        @if($teacher->status === 'active') bg-emerald-50 text-emerald-850 
                        @elseif($teacher->status === 'retired') bg-blue-50 text-blue-800 
                        @else bg-red-50 text-red-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $teacher->status)) }}
                    </span>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tanggal Diangkat</label>
                <p class="text-sm font-bold text-slate-800">{{ $teacher->hire_date ? $teacher->hire_date->format('d F Y') : '-' }}</p>
            </div>

            @if($teacher->specialization)
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Keahlian / Spesialisasi</label>
                    <p class="text-sm font-bold text-slate-800 bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $teacher->specialization }}</p>
                </div>
            @endif

            @if($teacher->notes)
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Catatan</label>
                    <p class="text-sm font-bold text-slate-800 bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $teacher->notes }}</p>
                </div>
            @endif
        </div>
    </div>

</div>

<!-- Data Orang Card -->
<div class="rounded-2xl border border-slate-50 bg-white p-6 shadow-none mb-6">
    <h3 class="text-md font-extrabold text-emerald-800 mb-6 flex items-center gap-2 pb-3 border-b border-slate-100">
        <span class="size-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
            <iconify-icon icon="lucide:user" class="text-sm"></iconify-icon>
        </span>
        Data Pribadi Orang
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</label>
            <p class="text-sm font-bold text-slate-800">{{ $teacher->person->full_name }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Alamat Email</label>
            <p class="text-sm font-bold text-slate-800">{{ $teacher->person->email }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">No. Telepon</label>
            <p class="text-sm font-bold text-slate-800">{{ $teacher->person->phone ?? '-' }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Jenis Kelamin</label>
            <p class="text-sm font-bold text-slate-800">{{ $teacher->person->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tempat Lahir</label>
            <p class="text-sm font-bold text-slate-800">{{ $teacher->person->birth_place ?? '-' }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tanggal Lahir</label>
            <p class="text-sm font-bold text-slate-800">{{ $teacher->person->birth_date ? $teacher->person->birth_date->format('d F Y') : '-' }}</p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
    <script>
        function deleteData(id, url) {
            Swal.fire({
                title: 'Hapus Data Guru?',
                text: "Seluruh data terkait guru ini akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.innerHTML = '@csrf @method("DELETE")';
                    document.body.appendChild(form);
                    form.submit();
                }
            })
        }
    </script>
@endpush
