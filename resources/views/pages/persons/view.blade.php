@extends('layouts.admin')

@section('title', 'Detail Orang')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Orang',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Orang', 'url' => route('persons.index')],
        ['name' => $person->full_name, 'url' => '#']
    ]
])

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">

    <!-- Photo & Basic Info Card -->
    <div class="rounded-2xl border border-slate-50 bg-white p-6 shadow-none flex flex-col justify-between">
        <div>
            <div class="text-center mb-6">
                @if($person->photo)
                    <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->full_name }}" class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-emerald-50">
                @else
                    <div class="w-32 h-32 rounded-full mx-auto bg-slate-50 flex items-center justify-center border-4 border-emerald-50">
                        <iconify-icon icon="lucide:user" class="text-5xl text-emerald-800/40"></iconify-icon>
                    </div>
                @endif
            </div>

            <h2 class="text-xl font-extrabold text-center text-slate-800 mb-1">
                {{ $person->full_name }}
            </h2>

            <p class="text-center text-xs font-semibold text-slate-400 mb-6">
                {{ $person->email }}
            </p>

            <div class="space-y-4 pt-6 border-t border-slate-100">
                <div class="flex justify-between items-center text-xs">
                    <span class="font-bold text-slate-400 uppercase tracking-wider">Tanggal Bergabung</span>
                    <span class="font-bold text-slate-800">{{ $person->created_at->format('d F Y') }}</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="font-bold text-slate-400 uppercase tracking-wider">Jenis Kelamin</span>
                    <span class="font-bold text-slate-800">{{ $person->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="font-bold text-slate-400 uppercase tracking-wider">Status Akun</span>
                    <div>
                        @if($person->is_active)
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-850">
                                Aktif
                            </span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-800">
                                Non-Aktif
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-2.5 pt-6 mt-6 border-t border-slate-100">
            <form action="{{ route('persons.update', $person->id) }}" class="hidden" enctype="multipart/form-data" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="photo_only" value="ya">
                <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden">
            </form>
            <a href="{{ route('persons.index') }}" class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 px-4 py-2.5 text-xs font-bold text-slate-700 transition-all">
                <iconify-icon icon="lucide:arrow-left" class="text-sm"></iconify-icon>
                Batal
            </a>
            <a href="{{ route('persons.edit', $person->id) }}" style="background-color: #3b82f6" class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl px-4 py-2.5 text-xs font-bold text-white transition-all shadow-sm hover:brightness-105">
                <iconify-icon icon="lucide:edit-2" class="text-sm"></iconify-icon>
                Edit
            </a>
            <button onclick="updateFoto('{{ $person->id }}', '{{ route('persons.update', $person->id) }}')" class="w-full inline-flex items-center justify-center gap-1.5 rounded-xl bg-emerald-50 text-emerald-850 hover:bg-emerald-100 px-4 py-2.5 text-xs font-bold transition-all">
                <iconify-icon icon="lucide:camera" class="text-sm"></iconify-icon>
                Ubah Foto
            </button>
            <button onclick="deleteData('{{ $person->id }}', '{{ route('persons.destroy', $person->id) }}')" class="w-full inline-flex items-center justify-center gap-1.5 rounded-xl bg-red-50 text-red-650 hover:bg-red-100 px-4 py-2.5 text-xs font-bold transition-all">
                <iconify-icon icon="lucide:trash-2" class="text-sm"></iconify-icon>
                Hapus Orang
            </button>
        </div>
    </div>

    <!-- Personal Information Card -->
    <div class="lg:col-span-2 rounded-2xl border border-slate-50 bg-white p-6 shadow-none">
        <h3 class="text-md font-extrabold text-emerald-800 mb-6 flex items-center gap-2 pb-3 border-b border-slate-100">
            <span class="size-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:info" class="text-sm"></iconify-icon>
            </span>
            Informasi Pribadi
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Email</label>
                <p class="text-sm font-bold text-slate-800">{{ $person->email }}</p>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Telepon</label>
                <p class="text-sm font-bold text-slate-800">{{ $person->phone ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tempat Lahir</label>
                <p class="text-sm font-bold text-slate-800">{{ $person->birth_place ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tanggal Lahir</label>
                <p class="text-sm font-bold text-slate-800">
                    @if($person->birth_date)
                        {{ $person->birth_date->format('d F Y') }} <span class="text-xs text-slate-400 font-medium">({{ $person->age }} tahun)</span>
                    @else
                        -
                    @endif
                </p>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Nomor Identitas</label>
                <p class="text-sm font-bold text-slate-800">{{ $person->identity_number ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Lembaga / Sekolah</label>
                <p class="text-sm font-bold text-slate-800">{{ $person->schoolInstitution?->name ?? '-' }}</p>
            </div>
        </div>
    </div>

</div>

<!-- Address Information Card -->
@if($person->address || $person->city || $person->province || $person->postal_code)
    <div class="rounded-2xl border border-slate-50 bg-white p-6 shadow-none mb-6">
        <h3 class="text-md font-extrabold text-emerald-800 mb-6 flex items-center gap-2 pb-3 border-b border-slate-100">
            <span class="size-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:map-pin" class="text-sm"></iconify-icon>
            </span>
            Informasi Alamat
        </h3>

        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Alamat Lengkap</label>
                <p class="text-sm font-bold text-slate-800 bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $person->address ?? '-' }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Kota</label>
                    <p class="text-sm font-bold text-slate-800">{{ $person->city ?? '-' }}</p>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Provinsi</label>
                    <p class="text-sm font-bold text-slate-800">{{ $person->province ?? '-' }}</p>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Kode Pos</label>
                    <p class="text-sm font-bold text-slate-800">{{ $person->postal_code ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Person Type Memberships Card -->
@if($person->memberships->count() > 0)
    <div class="rounded-2xl border border-slate-50 bg-white p-6 shadow-none mb-6">
        <h3 class="text-md font-extrabold text-emerald-800 mb-6 flex items-center gap-2 pb-3 border-b border-slate-100">
            <span class="size-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:shield" class="text-sm"></iconify-icon>
            </span>
            Tipe Peran Keanggotaan
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($person->memberships as $membership)
                <div class="p-4 border border-slate-100 rounded-xl bg-slate-50 flex flex-col justify-between gap-2">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-slate-800">{{ $membership->personType->name }}</span>
                        @if($membership->is_active)
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-850">
                                Aktif
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-red-50 text-red-800">
                                Non-Aktif
                            </span>
                        @endif
                    </div>
                    @if($membership->joined_date)
                        <p class="text-[11px] text-slate-400 font-semibold flex items-center gap-1">
                            <iconify-icon icon="lucide:calendar" class="text-xs"></iconify-icon>
                            Tanggal Bergabung: {{ $membership->joined_date->format('d F Y') }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif

<!-- Related Records Card -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    @if($person->student)
        <div class="rounded-2xl border border-slate-50 bg-white p-6 shadow-none flex flex-col justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="size-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                    <iconify-icon icon="lucide:graduation-cap" class="text-xl"></iconify-icon>
                </span>
                <div>
                    <h4 class="text-sm font-black text-slate-800">Profil Siswa</h4>
                    <p class="text-xs text-slate-400">NIS: {{ $person->student->student_id }}</p>
                </div>
            </div>
            <a href="{{ route('students.show', $person->student->id) }}" class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:text-blue-700">
                Lihat Detail Profil
                <iconify-icon icon="lucide:arrow-right" class="text-xs"></iconify-icon>
            </a>
        </div>
    @endif

    @if($person->teacher)
        <div class="rounded-2xl border border-slate-50 bg-white p-6 shadow-none flex flex-col justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="size-10 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center">
                    <iconify-icon icon="lucide:book-open" class="text-xl"></iconify-icon>
                </span>
                <div>
                    <h4 class="text-sm font-black text-slate-800">Profil Guru</h4>
                    <p class="text-xs text-slate-400">NIG: {{ $person->teacher->teacher_id }}</p>
                </div>
            </div>
            <a href="{{ route('teachers.show', $person->teacher->id) }}" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-800 hover:text-emerald-950">
                Lihat Detail Profil
                <iconify-icon icon="lucide:arrow-right" class="text-xs"></iconify-icon>
            </a>
        </div>
    @endif

    @if($person->staff)
        <div class="rounded-2xl border border-slate-50 bg-white p-6 shadow-none flex flex-col justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="size-10 rounded-xl bg-orange-50 text-orange-700 flex items-center justify-center">
                    <iconify-icon icon="lucide:briefcase" class="text-xl"></iconify-icon>
                </span>
                <div>
                    <h4 class="text-sm font-black text-slate-800">Profil Staff</h4>
                    <p class="text-xs text-slate-400">NIP: {{ $person->staff->staff_id }}</p>
                </div>
            </div>
            <a href="{{ route('staffs.show', $person->staff->id) }}" class="inline-flex items-center gap-1 text-xs font-bold text-orange-600 hover:text-orange-700">
                Lihat Detail Profil
                <iconify-icon icon="lucide:arrow-right" class="text-xs"></iconify-icon>
            </a>
        </div>
    @endif
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/libs/sweetalert2/css/sweetalert2.min.css')}}">
@endpush

@push('scripts')
    <script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    <script>
        function updateFoto(id, url){
            Swal.fire({
                title: 'Ubah Foto?',
                text: 'Apakah Anda yakin ingin mengubah foto orang ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#065f46',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Ubah!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const input = document.getElementById('photoInput');
                    input.click();
                    input.addEventListener('change', function() {
                        const form = input.closest('form');
                        form.submit();
                    });
                }
            });
        }

        function deleteData(id, url) {
            Swal.fire({
                title: 'Hapus Data Orang?',
                text: 'Seluruh biodata orang ini akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#64748b',
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
