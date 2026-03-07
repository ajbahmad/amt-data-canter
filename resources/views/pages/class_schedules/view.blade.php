@extends('layouts.admin')

@section('title', 'Detail Jadwal Kelas')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Jadwal Kelas',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Jadwal Kelas', 'url' => route('class_schedules.index')],
        ['name' => 'Detail', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
    
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <i class="ti ti-eye mr-2"></i>Detail Jadwal Kelas
        </h2>
        <div class="flex gap-2">
            <a href="{{ route('class_schedules.edit', $schedule->id) }}" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">
                <i class="ti ti-edit mr-2"></i>Edit
            </a>
            <form action="{{ route('class_schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700 transition">
                    <i class="ti ti-trash mr-2"></i>Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Main Information -->
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                <i class="ti ti-info-circle mr-2"></i>Informasi Dasar
            </h3>
            
            <div class="space-y-3">
                <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Sekolah</label>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $schedule->schoolInstitution?->name ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Tingkat Sekolah</label>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $schedule->schoolLevel?->name ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Kelas</label>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $schedule->classRoom?->name ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Guru</label>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $schedule->teacher?->person?->full_name ?? '-' }} ({{ $schedule->teacher?->teacher_id ?? '-' }})</p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Mapel</label>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $schedule->subject?->name ?? '-' }} ({{ $schedule->subject?->code ?? '-' }})</p>
                </div>
            </div>
        </div>

        <!-- Schedule Information -->
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                <i class="ti ti-calendar mr-2"></i>Jadwal
            </h3>
            
            <div class="space-y-3">
                <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Hari</label>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $schedule->day_name }}</p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Jam Mulai</label>
                    <p class="text-gray-900 dark:text-white font-medium">
                        {{ $schedule->startTimeSlot?->name ?? '-' }}
                        <span class="text-gray-500 text-sm">({{ $schedule->startTimeSlot?->start_time ?? '-' }})</span>
                    </p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Jam Selesai</label>
                    <p class="text-gray-900 dark:text-white font-medium">
                        {{ $schedule->endTimeSlot?->name ?? '-' }}
                        <span class="text-gray-500 text-sm">({{ $schedule->endTimeSlot?->end_time ?? '-' }})</span>
                    </p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Semester</label>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $schedule->semester?->name ?? '-' }} ({{ $schedule->semester?->school_year?->name ?? '-' }})</p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Dibuat</label>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $schedule->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Back Button -->
<div class="mt-6">
    <a href="{{ route('class_schedules.index') }}" class="inline-flex items-center rounded-lg bg-gray-600 px-6 py-2 text-white hover:bg-gray-700 transition">
        <i class="ti ti-arrow-left mr-2"></i>Kembali
    </a>
</div>

@endsection
