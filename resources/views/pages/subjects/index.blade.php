@extends('layouts.admin')

@section('title', 'Mata Pelajaran')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Daftar Mata Pelajaran',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Mata Pelajaran', 'url' => '#']
    ]
])



<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
    
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <i class="ti ti-books mr-2"></i>Daftar Mata Pelajaran
        </h2>
        <a href="{{ route('subjects.create') }}" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">
            <i class="ti ti-plus mr-2"></i>Tambah Mata Pelajaran
        </a>
    </div>
    
    {{ $dataTable->table() }}

</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/libs/DataTables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/libs/sweetalert2/css/sweetalert2.min.css')}}">
    


    <style>
        .dt-paging-button{
            border-radius: 50% !important;
        }
        .table-responsive{
            overflow-x: auto;
        }
        #datatable thead tr.filters th{
            padding: 10px 1px;
            font-weight: 100 !important
        }
        #datatable thead tr th{
            white-space: nowrap;
        }
    </style>

@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/DataTables/datatables.min.js') }}"></script>
    <script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    {!! $dataTable->scripts() !!}
    @include('components.confirm-toastr')

@endpush
