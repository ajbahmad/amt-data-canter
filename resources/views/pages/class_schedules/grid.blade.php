@extends('layouts.admin')

@section('title', 'Jadwal Kelas - Tampilan Grid')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Jadwal Kelas - Tampilan Grid',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Jadwal Kelas', 'url' => route('class_schedules.index')],
        ['name' => 'Grid', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 mb-6">
    
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
        <i class="ti ti-layout-grid mr-2"></i>Tampilan Grid Jadwal Kelas
    </h2>

    <!-- Filter Section -->
    <form method="GET" action="{{ route('class_schedules.grid') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="class_room_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Pilih Kelas
            </label>
            <select id="class_room_id" name="class_room_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                <option value="">-- Pilih Kelas --</option>
                @foreach ($classRooms as $classRoom)
                    <option value="{{ $classRoom->id }}" @if ($selectedClassRoom == $classRoom->id) selected @endif>
                        {{ $classRoom->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="semester_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Pilih Semester
            </label>
            <select id="semester_id" name="semester_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                <option value="">-- Pilih Semester --</option>
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->id }}" @if ($selectedSemester == $semester->id) selected @endif>
                        {{ $semester->name }} ({{ $semester->school_year?->name }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end">
            <button type="reset" class="w-full px-4 py-2 bg-gray-500 text-white font-medium rounded-lg hover:bg-gray-600 transition" onclick="window.location='{{ route('class_schedules.grid') }}'">
                <i class="ti ti-refresh mr-2"></i>Reset Filter
            </button>
        </div>
    </form>
</div>

@if ($selectedClassRoom && $selectedSemester && count($schedulesByDay) > 0)
    <!-- Schedule Grid View -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach ($schedulesByDay as $dayNum => $dayData)
            <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                <!-- Day Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h3 class="text-lg font-bold text-white">
                        <i class="ti ti-calendar mr-2"></i>{{ $dayData['name'] }}
                    </h3>
                </div>

                <!-- Schedules List -->
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @if (count($dayData['schedules']) > 0)
                        @foreach ($dayData['schedules'] as $schedule)
                            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $schedule->subject?->code ?? '-' }} - {{ $schedule->subject?->name ?? '-' }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $schedule->teacher?->person?->full_name ?? '-' }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-xs font-medium">
                                            {{ $schedule->startTimeSlot?->name ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mb-3">
                                    <i class="ti ti-clock mr-1"></i>{{ $schedule->startTimeSlot?->start_time ?? '-' }} - {{ $schedule->endTimeSlot?->end_time ?? '-' }}
                                </p>
                                <div class="flex gap-2">
                                    <a href="{{ route('class_schedules.show', $schedule->id) }}" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                        <i class="ti ti-eye mr-1"></i>Lihat
                                    </a>
                                    <a href="{{ route('class_schedules.edit', $schedule->id) }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                                        <i class="ti ti-edit mr-1"></i>Edit
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                            <i class="ti ti-inbox text-2xl mb-2"></i>
                            <p>Tidak ada jadwal pada hari ini</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@elseif ($selectedClassRoom || $selectedSemester)
    <div class="rounded-lg border-2 border-yellow-300 bg-yellow-50 dark:bg-yellow-900/30 p-6 text-center">
        <i class="ti ti-alert-circle text-4xl text-yellow-600 dark:text-yellow-400 mb-4"></i>
        <p class="text-lg font-medium text-yellow-800 dark:text-yellow-200">Silakan pilih kelas dan semester untuk melihat jadwal</p>
    </div>
@else
    <div class="rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 p-12 text-center">
        <i class="ti ti-calendar-off text-6xl text-gray-400 dark:text-gray-600 mb-4"></i>
        <p class="text-lg font-medium text-gray-700 dark:text-gray-300">Pilih kelas dan semester untuk melihat jadwal mingguan</p>
    </div>
@endif

@endsection
