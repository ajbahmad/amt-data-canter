@extends('layouts.admin')

@section('title', 'Tahun Akademik')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Daftar Tahun Akademik',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Tahun Akademik', 'url' => '#']
    ]
])

<div id="dismiss-toast"
    class="toast-onload opacity-0   hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 max-w-xs bg-primary rounded-md"
    role="alert">
    <div class="flex gap-2 p-3">
        <i class="ti ti-alert-circle text-white text-lg"></i>
        <div>
            <h5 class="font-semibold text-white">Selamat datang, {{ Auth::user()->name }}</h5>
            <p class="text-fs_12 text-white">Senang melihat Anda kembali!</p>
        </div>
        <div class="ms-auto">
            <button type="button" data-hs-remove-element="#dismiss-toast">
                <i class="ti ti-x text-lg text-white opacity-70 leading-none"></i>
            </button>
        </div>
    </div>
</div>


<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
    
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <i class="ti ti-calendar mr-2"></i>Daftar Tahun Akademik
        </h2>
        <a href="{{ route('school_years.create') }}" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">
            <i class="ti ti-plus mr-2"></i>Tambah Tahun Akademik
        </a>
    </div>
    
    {{ $dataTable->table() }}

</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/libs/DataTables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/libs/sweetalert2/css/sweetalert2.min.css')}}">
    


    

@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/DataTables/datatables.min.js') }}"></script>
    <script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    {!! $dataTable->scripts() !!}
    @include('components.confirm-toastr')
@endpush

