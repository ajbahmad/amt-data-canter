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
    <!-- Schedule Grid View - 2x4 Cards Layout -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Card 1: Kode Guru / Kode Mapel -->
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden flex flex-col">
            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-4 py-3">
                <h3 class="text-base font-bold text-white flex items-center">
                    <i class="ti ti-id-badge mr-2"></i>Kode Guru / Mapel
                </h3>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-3">
                <div class="space-y-2">
                    @php
                        $teachers = [];
                        foreach ($schedulesByDay as $dayData) {
                            foreach ($dayData['schedules'] as $schedule) {
                                $teacherId = $schedule->teacher_id;
                                if (!isset($teachers[$teacherId])) {
                                    $teachers[$teacherId] = [
                                        'teacher' => $schedule->teacher,
                                        'subjects' => []
                                    ];
                                }
                                if ($schedule->subject && !in_array($schedule->subject->id, array_column($teachers[$teacherId]['subjects'], 'id'))) {
                                    $teachers[$teacherId]['subjects'][] = $schedule->subject;
                                }
                            }
                        }
                    @endphp

                    @forelse ($teachers as $teacherId => $data)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                            <p class="text-xs font-bold text-purple-600 dark:text-purple-400">
                                <i class="ti ti-user mr-1"></i>{{ nameInitials($data['teacher']?->person?->full_name ?? '-') }}
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ $data['teacher']?->person?->full_name ?? '-' }}</p>
                            @foreach ($data['subjects'] as $subject)
                                <div class="flex items-center text-xs mb-1">
                                    <span class="inline-block px-2 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded font-semibold">
                                        {{ $subject->code }}
                                    </span>
                                    <span class="text-gray-600 dark:text-gray-400 ml-2">{{ $subject->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                            <i class="ti ti-inbox text-xl mb-2"></i>
                            <p class="text-xs">Tidak ada data</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Cards 2-8: Days (Senin - Minggu) -->
        @foreach ($schedulesByDay as $dayNum => $dayData)
            <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden flex flex-col">
                <!-- Day Header with Color -->
                @php
                    $dayColors = [
                        1 => 'from-blue-600 to-blue-700',      // Senin
                        2 => 'from-red-600 to-red-700',        // Selasa
                        3 => 'from-green-600 to-green-700',    // Rabu
                        4 => 'from-yellow-600 to-yellow-700',  // Kamis
                        5 => 'from-purple-600 to-purple-700',  // Jumat
                        6 => 'from-pink-600 to-pink-700',      // Sabtu
                        7 => 'from-indigo-600 to-indigo-700'   // Minggu
                    ];
                    $colorClass = $dayColors[$dayNum] ?? 'from-gray-600 to-gray-700';
                @endphp
                <div class="bg-gradient-to-r {{ $colorClass }} px-4 py-3">
                    <h3 class="text-base font-bold text-white">
                        <i class="ti ti-calendar mr-2"></i>{{ $dayData['name'] }}
                    </h3>
                </div>

                <!-- Content -->
                <div class="flex-1 overflow-y-auto p-3">
                    <div class="space-y-2">
                        @if (count($dayData['schedules']) > 0)
                            @foreach ($dayData['schedules'] as $schedule)
                                <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded border border-gray-200 dark:border-gray-600 hover:shadow-md transition cursor-pointer">
                                    <!-- Subject Code & Name -->
                                    <div class="mb-1">
                                        <span class="inline-block px-2 py-0.5 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded text-xs font-bold">
                                            {{ $schedule->subject?->code ?? '-' }}
                                        </span>
                                        <p class="text-xs font-semibold text-gray-900 dark:text-white mt-1">
                                            {{ $schedule->subject?->name ?? '-' }}
                                        </p>
                                    </div>

                                    <!-- Teacher -->
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">
                                        <i class="ti ti-user text-xs mr-1"></i>{{ $schedule->teacher?->person?->full_name ?? '-' }}
                                    </p>

                                    <!-- Time -->
                                    <p class="text-xs text-blue-600 dark:text-blue-400 font-medium">
                                        <i class="ti ti-clock text-xs mr-1"></i>{{ $schedule->startTimeSlot?->start_time ?? '-' }} - {{ $schedule->endTimeSlot?->end_time ?? '-' }}
                                    </p>

                                    <!-- Actions -->
                                    <div class="mt-2 flex gap-1">
                                        <a href="{{ route('class_schedules.show', $schedule->id) }}" class="flex-1 text-center text-xs bg-blue-500 hover:bg-blue-600 text-white rounded py-1 transition">
                                            <i class="ti ti-eye text-xs"></i>
                                        </a>
                                        <a href="{{ route('class_schedules.edit', $schedule->id) }}" class="flex-1 text-center text-xs bg-indigo-500 hover:bg-indigo-600 text-white rounded py-1 transition">
                                            <i class="ti ti-edit text-xs"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="flex flex-col items-center justify-center h-32 text-gray-400 dark:text-gray-500">
                                <i class="ti ti-inbox text-2xl mb-2"></i>
                                <p class="text-xs text-center">Tidak ada jadwal</p>
                            </div>
                        @endif
                    </div>
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

@push('styles')
    <style>
        /* Kanban board grid layout - 2x4 */
        .grid {
            @apply grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6;
        }

        /* Card styling */
        .rounded-lg {
            @apply transition-all duration-300;
        }

        /* Scrollable content */
        .overflow-y-auto {
            max-height: 400px;
        }

        /* Hover effects */
        .dark\:bg-gray-700:hover {
            @apply shadow-lg;
        }
    </style>
@endpush

@endsection
