@extends('layouts.admin')

@section('title', 'Rombel')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Daftar Rombel',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Rombel', 'url' => '#']
    ]
])


<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">

    <div class="mb-6 flex items-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <i class="ti ti-door mr-2"></i>Daftar Rombel
        </h2>
        
        <a href="{{ route('class_rooms.set_schedule') }}" class="inline-flex ms-auto me-2 items-center rounded-lg bg-success px-4 py-2 text-white hover:bg-success-700 transition">
            <i class="ti ti-clock mr-2"></i>Atur Jadwal Masuk
        </a>

        <a href="{{ route('class_rooms.create') }}" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">
            <i class="ti ti-plus mr-2"></i>Tambah Rombel
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
