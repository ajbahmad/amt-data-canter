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

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <i class="ti ti-calendar-month mr-2"></i>{{ $semester->name }}
        </h2>
        <div class="flex gap-2">
            <a href="{{ route('semesters.edit', $semester->id) }}" class="inline-flex items-center rounded-lg bg-yellow-600 px-4 py-2 text-white hover:bg-yellow-700 transition">
                <i class="ti ti-edit mr-2"></i>Edit
            </a>
            <button onclick="deleteSemester('{{ route('semesters.destroy', $semester->id) }}')" class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700 transition">
                <i class="ti ti-trash mr-2"></i>Hapus
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        
        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tahun Akademik</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $semester->schoolYear->name ?? '-' }}</p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Nama Semester</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $semester->name }}</p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tanggal Mulai</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                {{ $semester->start_date ? \Carbon\Carbon::parse($semester->start_date)->translatedFormat('d F Y') : '-' }}
            </p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tanggal Akhir</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                {{ $semester->end_date ? \Carbon\Carbon::parse($semester->end_date)->translatedFormat('d F Y') : '-' }}
            </p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Status</p>
            <div class="mt-1">
                @if($semester->is_active)
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
        <a href="{{ route('semesters.index') }}" class="inline-flex items-center rounded-lg bg-gray-600 px-6 py-2 text-white hover:bg-gray-700 transition">
            <i class="ti ti-arrow-left mr-2"></i>Kembali
        </a>
    </div>

</div>

@endsection

@push('scripts')
    <script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    <script>
        function deleteSemester(url) {
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
