@extends('layouts.admin')

@section('title', 'Detail Kelas')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Kelas',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Kelas', 'url' => route('grades.index')],
        ['name' => 'Detail', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <i class="ti ti-book mr-2"></i>{{ $grade->name }}
        </h2>
        <div class="flex gap-2">
            <a href="{{ route('grades.edit', $grade->id) }}" class="inline-flex items-center rounded-lg bg-yellow-600 px-4 py-2 text-white hover:bg-yellow-700 transition">
                <i class="ti ti-edit mr-2"></i>Edit
            </a>
            <button onclick="deleteGrade('{{ route('grades.destroy', $grade->id) }}')" class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700 transition">
                <i class="ti ti-trash mr-2"></i>Hapus
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        
        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Sekolah</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $grade->schoolLevel->name ?? '-' }}</p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Nama Kelas</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $grade->name }}</p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Nomor Urutan</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $grade->order_no }}</p>
        </div>

    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('grades.index') }}" class="inline-flex items-center rounded-lg bg-gray-600 px-6 py-2 text-white hover:bg-gray-700 transition">
            <i class="ti ti-arrow-left mr-2"></i>Kembali
        </a>
    </div>

</div>

@endsection

@push('scripts')
    <script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    <script>
        function deleteGrade(url) {
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
