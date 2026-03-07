@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Jadwal Kelas</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola jadwal kelas sekolah</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('class_schedules.grid') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 4H5a2 2 0 00-2 2v14a2 2 0 002 2h4m0-21h10a2 2 0 012 2v14a2 2 0 01-2 2h-10m0-21v21m0-21H9m11 0a2 2 0 012 2v14a2 2 0 01-2 2m0-21v21m0-21h4a2 2 0 012 2v14a2 2 0 01-2 2h-4m0-21v21"></path>
                    </svg>
                    Tampilan Grid
                </a>
                <a href="{{ route('class_schedules.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Jadwal
                </a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ $message }}
            </div>
        @endif

        <!-- DataTable Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            {{ $dataTable->table(attributes: ['class' => 'w-full display nowrap']) }}
        </div>
    </div>

    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
@endsection
