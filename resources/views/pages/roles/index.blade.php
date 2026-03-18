@extends('layouts.admin')

@section('title', 'Peran')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Daftar Peran',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'IAM', 'url' => '#'],
        ['name' => 'Peran', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
    
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <i class="ti ti-badge mr-2"></i>Daftar Peran
        </h2>
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
