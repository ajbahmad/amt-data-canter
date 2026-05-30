@extends('layouts.admin')

@section('title', 'Detail Siswa')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Siswa',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Siswa', 'url' => route('students.index')],
        ['name' => $student->person->full_name, 'url' => '#']
    ]
])

<div class="grid grid-cols-1 gap-6 md:grid-cols-3 mb-6">

    {{-- Left Card: Student Profile Summary --}}
    <div class="rounded-2xl border border-slate-50 bg-white p-6 flex flex-col justify-between">
        <div>
            <div class="text-center mb-6">
                @if($student->person->photo)
                    <img src="{{ asset('storage/' . $student->person->photo) }}" alt="{{ $student->person->full_name }}" class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-emerald-50">
                @else
                    <div class="w-32 h-32 rounded-full mx-auto bg-emerald-50 flex items-center justify-center border-4 border-emerald-100 text-emerald-800">
                        <iconify-icon icon="lucide:user" class="text-4xl"></iconify-icon>
                    </div>
                @endif
            </div>

            <h2 class="text-xl font-extrabold text-center text-slate-800 leading-snug mb-1">
                {{ $student->person->full_name }}
            </h2>

            <p class="text-center text-xs font-black text-slate-400 uppercase tracking-widest">
                {{ $student->student_id }}
            </p>
        </div>

        <div class="mt-8 flex gap-3">
            <a href="{{ route('students.edit', $student->id) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-emerald-800 text-white rounded-xl hover:bg-emerald-900 transition-all font-bold text-xs shadow-sm">
                <iconify-icon icon="lucide:edit-2" class="text-xs"></iconify-icon>Edit
            </a>
            <button onclick="deleteData('{{ $student->id }}', '{{ route('students.destroy', $student->id) }}')" class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-red-50 text-red-700 rounded-xl hover:bg-red-100 hover:text-red-800 transition-all font-bold text-xs">
                <iconify-icon icon="lucide:trash-2" class="text-xs"></iconify-icon>Hapus
            </button>
        </div>
    </div>

    {{-- Right Card: Student Registration & Notes Information --}}
    <div class="md:col-span-2 rounded-2xl border border-slate-50 bg-white p-6">
        <h3 class="text-base font-extrabold text-emerald-800 flex items-center gap-2 mb-6 pb-2 border-b border-slate-50">
            <span class="size-6 rounded bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:info" class="text-xs"></iconify-icon>
            </span>
            Informasi Siswa
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Nomor Induk Siswa</label>
                <p class="text-sm font-bold text-slate-800">{{ $student->student_id }}</p>
            </div>

            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Sekolah / Lembaga</label>
                <p class="text-sm font-bold text-slate-800">{{ $student->schoolInstitution->name }}</p>
            </div>

            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Status</label>
                <p class="mt-1">
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border
                        {{ $student->status === 'active' ? 'bg-emerald-50 text-emerald-800 border-emerald-100' : ($student->status === 'graduated' ? 'bg-blue-50 text-blue-800 border-blue-100' : 'bg-red-50 text-red-800 border-red-100') }}">
                        {{ ucfirst(str_replace('_', ' ', $student->status)) }}
                    </span>
                </p>
            </div>

            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Tanggal Pendaftaran</label>
                <p class="text-sm font-bold text-slate-800">{{ $student->enrollment_date ? $student->enrollment_date->format('d F Y') : '-' }}</p>
            </div>

            @if($student->notes)
            <div class="sm:col-span-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Catatan</label>
                <p class="text-sm font-bold text-slate-700 bg-slate-50 p-3.5 rounded-xl border border-slate-100">{{ $student->notes }}</p>
            </div>
            @endif
        </div>
    </div>

</div>

{{-- Bottom Card: Personal Details --}}
<div class="rounded-2xl border border-slate-50 bg-white p-6">
    <h3 class="text-base font-extrabold text-emerald-800 flex items-center gap-2 mb-6 pb-2 border-b border-slate-50">
        <span class="size-6 rounded bg-emerald-50 text-emerald-800 flex items-center justify-center">
            <iconify-icon icon="lucide:user" class="text-xs"></iconify-icon>
        </span>
        Data Orang / Biodata
    </h3>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div>
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Email</label>
            <p class="text-sm font-bold text-slate-800">{{ $student->person->email }}</p>
        </div>

        <div>
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Telepon</label>
            <p class="text-sm font-bold text-slate-800">{{ $student->person->phone ?? '-' }}</p>
        </div>

        <div>
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Tanggal Lahir</label>
            <p class="text-sm font-bold text-slate-800">
                @if($student->person->birth_date)
                    {{ $student->person->birth_date->format('d F Y') }}
                @else
                    -
                @endif
            </p>
        </div>

        <div>
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Jenis Kelamin</label>
            <p class="text-sm font-bold text-slate-800">
                @if($student->person->gender)
                    {{ $student->person->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                @else
                    -
                @endif
            </p>
        </div>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/libs/sweetalert2/css/sweetalert2.min.css')}}">
@endpush

@push('scripts')
<script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>

<script>
    function deleteData(id, url) {
        Swal.fire({
            title: 'Hapus Data?',
            text: 'Anda yakin ingin menghapus data siswa ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#065f46',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.innerHTML = `@csrf @method('DELETE')`;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endpush
