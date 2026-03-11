@extends('layouts.admin')

@section('title', 'Detail Pola Jadwal Sekolah')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Pola Jadwal Sekolah',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Akademik', 'url' => '#'],
        ['name' => 'Pola Jadwal Sekolah', 'url' => route('schedule-patterns.index')],
        ['name' => 'Detail', 'url' => '#']
    ]
])

<div class="grid grid-cols-1 gap-6 mb-6">
    <div class="rounded-lg border border-gray-200 bg-white p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-gray-600">Nama Pola Jadwal</p>
                <p class="text-lg font-semibold text-gray-900">{{ $schedulePattern->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Institusi</p>
                <p class="text-lg font-semibold text-gray-900">{{ $schedulePattern->schoolInstitution->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Sekolah</p>
                <p class="text-lg font-semibold text-gray-900">{{ $schedulePattern->schoolLevel->name }}</p>
            </div>
        </div>
        @if($schedulePattern->description)
            <div class="mt-4">
                <p class="text-sm text-gray-600">Deskripsi</p>
                <p class="text-gray-900">{{ $schedulePattern->description }}</p>
            </div>
        @endif
    </div>
</div>

<h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Jadwal Harian</h3>

<div class="grid grid-cols-1 gap-4">
    @php
        $days = [
            0 => 'Senin',
            1 => 'Selasa',
            2 => 'Rabu',
            3 => 'Kamis',
            4 => 'Jumat',
            5 => 'Sabtu',
            6 => 'Minggu'
        ];
    @endphp
    
    @foreach($schedulePattern->schoolDaySchedules()->orderBy('day_of_week')->get() as $schedule)
        <div class="rounded-lg border border-gray-200 bg-white p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-900">{{ $days[$schedule->day_of_week] ?? 'Unknown' }}</h4>
                    @if($schedule->is_holiday)
                        <p class="text-sm text-red-600"><i class="ti ti-circle-check mr-1"></i>Hari Libur</p>
                    @else
                        <p class="text-sm text-gray-600">
                            {{ $schedule->start_time ?? '-' }} s/d {{ $schedule->end_time ?? '-' }}
                        </p>
                    @endif
                </div>
                <form action="{{ route('school-day-schedules.update', $schedule->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <button type="button" onclick="editSchedule('{{ $schedule->id }}', '{{ $schedule->start_time }}', '{{ $schedule->end_time }}', {{ $schedule->is_holiday ? 'true' : 'false' }})" class="btn btn-rounded w-8 h-8 bg-white border border-warning text-warning hover:bg-warning hover:text-white p-0 btn-sm">
                        <i class="ti ti-edit"></i>
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-6 flex justify-start gap-3">
    <a href="{{ route('schedule-patterns.edit', $schedulePattern->id) }}" class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 transition">
        <i class="ti ti-edit mr-2"></i>Edit
    </a>
    <button type="button" onclick="deleteData('{{ $schedulePattern->id }}', '{{ route('schedule-patterns.destroy', $schedulePattern->id) }}')" class="inline-flex items-center rounded-lg bg-red-600 px-6 py-2 text-white hover:bg-red-700 transition">
        <i class="ti ti-trash mr-2"></i>Hapus
    </button>
    <a href="{{ route('schedule-patterns.index') }}" class="inline-flex items-center rounded-lg bg-gray-600 px-6 py-2 text-white hover:bg-gray-700 transition">
        <i class="ti ti-arrow-left mr-2"></i>Kembali
    </a>
</div>

@endsection

@push('scripts')
    @include('components.confirm-toastr')
    <script>
        intFilterSelect();
    </script>
@endpush