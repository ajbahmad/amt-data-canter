@extends('layouts.admin')

@section('title', 'Guru')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Daftar Guru',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Guru', 'url' => '#']
    ]
])

<div class="rounded-2xl border border-slate-50 bg-white p-6">
    
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-emerald-800 tracking-tight flex items-center gap-2">
                <span class="size-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                    <iconify-icon icon="lucide:user-check" class="text-lg"></iconify-icon>
                </span>
                Daftar Guru
            </h2>
            <p class="donezo-subtitle">Kelola informasi data guru dan status kepegawaian Anda secara efisien.</p>
        </div>
        <a href="{{ route('teachers.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-800 hover:bg-emerald-900 px-5 py-2.5 text-xs font-bold text-white transition-all shadow-sm">
            <iconify-icon icon="lucide:plus" class="text-sm"></iconify-icon>
            Tambah Guru
        </a>
    </div>
    
    <div class="table-responsive">
        {{ $dataTable->table() }}
    </div>

</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/libs/DataTables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/libs/sweetalert2/css/sweetalert2.min.css')}}">
    
    <style>
        /* Subtitle Styles */
        .donezo-subtitle {
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            color: #64748b !important;
            margin-top: 0.25rem !important;
        }

        /* Localized BORDERLESS Premium DataTable Overrides */
        .table-responsive {
            margin: 1rem 0 !important;
            border-radius: 0 !important;
            border: none !important;
            overflow: visible !important;
            background-color: transparent !important;
            box-shadow: none !important;
        }
        table.dataTable {
            width: 100% !important;
            border-collapse: collapse !important;
            border: none !important;
            margin: 0 !important;
        }
        table.dataTable thead {
            background-color: #f8fafc !important;
            border: none !important;
        }
        table.dataTable thead th {
            padding: 1.125rem 1.5rem !important;
            text-align: left !important;
            font-size: 0.75rem !important;
            font-weight: 800 !important;
            color: #475569 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            border: none !important;
        }
        table.dataTable tbody tr {
            transition: background-color 0.2s ease-in-out !important;
            border: none !important;
        }
        table.dataTable tbody tr:nth-child(even) {
            background-color: #fafbfc !important;
        }
        table.dataTable tbody tr:hover {
            background-color: #f0fdf4 !important;
        }
        table.dataTable tbody td {
            padding: 1.125rem 1.5rem !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            color: #334155 !important;
            vertical-align: middle !important;
            border: none !important;
        }

        /* STYLE FOR DYNAMIC COLUMN SEARCH & SELECT INPUTS IN THEAD */
        table.dataTable thead input,
        table.dataTable thead select,
        table.dataTable tfoot input,
        table.dataTable tfoot select,
        .dataTables_wrapper table.dataTable thead input,
        .dataTables_wrapper table.dataTable thead select {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 8px !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            color: #334155 !important;
            padding: 0.375rem 0.75rem !important;
            height: 34px !important;
            transition: all 0.2s ease-in-out !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.02) !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        table.dataTable thead input:focus,
        table.dataTable thead select:focus,
        table.dataTable tfoot input:focus,
        table.dataTable tfoot select:focus {
            background-color: #ffffff !important;
            border-color: #065f46 !important; /* emerald-800 */
            box-shadow: 0 0 0 3px rgba(6, 95, 70, 0.08) !important;
            outline: none !important;
        }

        table.dataTable thead input::placeholder {
            color: #94a3b8 !important;
            font-weight: 500 !important;
        }

        /* Datatable search and length inputs styling */
        .dataTables_filter {
            margin-bottom: 1.25rem !important;
            float: right !important;
            text-align: right !important;
        }
        .dataTables_filter label {
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            color: #475569 !important;
        }
        .dataTables_filter input {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            padding: 0.5rem 1rem !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            color: #334155 !important;
            margin-left: 0.75rem !important;
            transition: all 0.2s ease-in-out !important;
            width: 240px !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.02) !important;
        }
        .dataTables_filter input:focus {
            background-color: #ffffff !important;
            border-color: #065f46 !important; /* emerald-800 */
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(6, 95, 70, 0.1) !important;
        }

        .dataTables_length {
            margin-bottom: 1.25rem !important;
            float: left !important;
        }
        .dataTables_length label {
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            color: #475569 !important;
        }
        .dataTables_length select {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 0.375rem 1.75rem 0.375rem 0.75rem !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            color: #334155 !important;
            margin: 0 0.5rem !important;
            transition: all 0.2s ease-in-out !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.02) !important;
        }
        .dataTables_length select:focus {
            border-color: #065f46 !important;
            outline: none !important;
        }

        /* Modern Pagination styling */
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 1rem !important;
            float: right !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 8px !important;
            padding: 0.375rem 0.75rem !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            color: #475569 !important;
            border: 1px solid #e2e8f0 !important;
            background: #ffffff !important;
            margin: 0 0.125rem !important;
            transition: all 0.2s ease-in-out !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f8fafc !important;
            color: #065f46 !important;
            border-color: #cbd5e1 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #065f46 !important; /* emerald-800 */
            border-color: #065f46 !important;
            color: white !important;
            box-shadow: 0 2px 4px 0 rgba(6, 95, 70, 0.15) !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background: #ffffff !important;
            color: #cbd5e1 !important;
            border-color: #f1f5f9 !important;
        }

        .dataTables_wrapper .dataTables_info {
            padding-top: 1.25rem !important;
            font-size: 0.75rem !important;
            font-weight: 750 !important;
            color: #64748b !important;
            float: left !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/DataTables/datatables.min.js') }}"></script>
    <script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    {!! $dataTable->scripts() !!}
    @include('components.confirm-toastr')
@endpush
