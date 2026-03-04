@extends('layouts.admin')

@section('title', 'Detail Rombel')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Rombel',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Rombel', 'url' => route('class-rooms.index')],
        ['name' => 'Detail', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold ">
            <i class="ti ti-door mr-2"></i>{{ $classRoom->name }}
        </h2>
        <div class="flex gap-2">
            <a href="{{ route('class-rooms.edit', $classRoom->id) }}" class="inline-flex items-center rounded-lg bg-yellow-400 px-4 py-2 text-white hover:bg-yellow-700 transition">
                <i class="ti ti-edit mr-2"></i>Edit
            </a>
            <button onclick="deleteClassRoom('{{ route('class-rooms.destroy', $classRoom->id) }}')" class="inline-flex items-center rounded-lg bg-red-200 px-4 py-2 text-red-600 hover:bg-white transition">
                <i class="ti ti-trash mr-2"></i>Hapus
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        
        <div>
            <p class="text-sm font-medium">Sekolah</p>
            <p class="text-lg font-semibold  mt-1">{{ $classRoom->schoolInstitution->name ?? '-' }}</p>
        </div>

        <div>
            <p class="text-sm font-medium">Tahun Akademik</p>
            <p class="text-lg font-semibold  mt-1">{{ $classRoom->schoolYear->name ?? '-' }}</p>
        </div>

        <div>
            <p class="text-sm font-medium">Kelas</p>
            <p class="text-lg font-semibold  mt-1">{{ $classRoom->grade->name ?? '-' }}</p>
        </div>

        <div>
            <p class="text-sm font-medium">Nama Rombel</p>
            <p class="text-lg font-semibold  mt-1">{{ $classRoom->name }}</p>
        </div>

        <div>
            <p class="text-sm font-medium">Kapasitas</p>
            <p class="text-lg font-semibold  mt-1">{{ $classRoom->capacity }} Siswa</p>
        </div>

        <div>
            <p class="text-sm font-medium">Status</p>
            <div class="mt-1">
                @if($classRoom->is_active)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                        <i class="ti ti-circle-check mr-2"></i>Aktif
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                        <i class="ti ti-circle-x mr-2"></i>Non Aktif
                    </span>
                @endif
            </div>
        </div>

    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('class-rooms.index') }}" class="inline-flex items-center rounded-lg bg-gray-600 px-6 py-2 text-white hover:bg-gray-700 transition">
            <i class="ti ti-arrow-left mr-2"></i>Kembali
        </a>
    </div>

</div>

@endsection

@push('scripts')
    <script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    <script>
        function deleteClassRoom(url) {
            Swal.fire({
                title: 'Hapus Data',
                html: 'Apakah Anda yakin ingin menghapus data ini? Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
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
