@extends('layouts.admin')

@section('title', 'Detail Jadwal Harian')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Jadwal Harian',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Akademik', 'url' => '#'],
        ['name' => 'Jadwal Harian', 'url' => route('school-day-schedules.index')],
        ['name' => 'Detail', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <i class="ti ti-calendar-time mr-2"></i>{{ $schedule->day_name }}
        </h2>
        <div class="flex gap-2">
            <a href="{{ route('school-day-schedules.edit', $schedule->id) }}" class="inline-flex items-center rounded-lg bg-yellow-600 px-4 py-2 text-white hover:bg-yellow-700 transition">
                <i class="ti ti-edit mr-2"></i>Edit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        
        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pola Jadwal</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $schedule->schedulePattern->name ?? '-' }}</p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Institusi</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $schedule->schoolInstitution->name ?? '-' }}</p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Level</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $schedule->schoolLevel->name ?? '-' }}</p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Status</p>
            <div class="mt-1">
                @if($schedule->is_holiday)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                        <i class="ti ti-circle-x mr-2"></i>Libur
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                        <i class="ti ti-circle-check mr-2"></i>Aktif
                    </span>
                @endif
            </div>
        </div>

        @if(!$schedule->is_holiday)
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Jam Mulai</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $schedule->start_time ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Jam Selesai</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $schedule->end_time ?? '-' }}</p>
            </div>
        @endif

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Dibuat</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                {{ $schedule->created_at ? \Carbon\Carbon::parse($schedule->created_at)->translatedFormat('d F Y') : '-' }}
            </p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Diperbarui</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                {{ $schedule->updated_at ? \Carbon\Carbon::parse($schedule->updated_at)->translatedFormat('d F Y') : '-' }}
            </p>
        </div>

    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('school-day-schedules.index') }}" class="inline-flex items-center rounded-lg bg-gray-600 px-6 py-2 text-white hover:bg-gray-700 transition">
            <i class="ti ti-arrow-left mr-2"></i>Kembali
        </a>
    </div>

</div>

@endsection

@push('scripts')
    @include('components.confirm-toastr')
@endpush
