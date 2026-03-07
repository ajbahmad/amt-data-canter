@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Jadwal Kelas - Tampilan Grid</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Lihat jadwal kelas per hari</p>
        </div>

        <!-- Filter Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
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
                        Reset Filter
                    </button>
                </div>
            </form>
        </div>

        @if ($selectedClassRoom && $selectedSemester && count($schedulesByDay) > 0)
            <!-- Teacher & Subject Code Card -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-md p-6 mb-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white/20 backdrop-blur rounded-lg p-4 text-white text-center">
                        <div class="text-sm font-medium opacity-90">Kode Guru</div>
                        <div class="text-2xl font-bold mt-2">GRU</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur rounded-lg p-4 text-white text-center">
                        <div class="text-sm font-medium opacity-90">Kode Mapel</div>
                        <div class="text-2xl font-bold mt-2">MP</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur rounded-lg p-4 text-white text-center">
                        <div class="text-sm font-medium opacity-90">Kelas</div>
                        <div class="text-2xl font-bold mt-2">{{ isset($schedulesByDay[1][0]) ? $schedulesByDay[1][0]->classRoom?->name : '-' }}</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur rounded-lg p-4 text-white text-center">
                        <div class="text-sm font-medium opacity-90">Semester</div>
                        <div class="text-2xl font-bold mt-2">{{ isset($schedulesByDay[1][0]) ? $schedulesByDay[1][0]->semester?->name : '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Weekly Schedule Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach ($schedulesByDay as $dayNum => $dayData)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <!-- Day Header -->
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                            <h3 class="text-lg font-bold text-white">{{ $dayData['name'] }}</h3>
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
                                            <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-xs font-medium">
                                                {{ $schedule->timeSlot?->name ?? '-' }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-500">
                                            {{ $schedule->timeSlot?->start_time ?? '-' }} - {{ $schedule->timeSlot?->end_time ?? '-' }}
                                        </p>
                                        @if ($schedule->notes)
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                                                📝 {{ $schedule->notes }}
                                            </p>
                                        @endif
                                        <div class="mt-3 flex gap-2">
                                            <a href="{{ route('class_schedules.show', $schedule->id) }}" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                                Lihat
                                            </a>
                                            <a href="{{ route('class_schedules.edit', $schedule->id) }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                                                Edit
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="p-8 text-center">
                                    <p class="text-gray-500 dark:text-gray-400">Tidak ada jadwal pada hari ini</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif ($selectedClassRoom || $selectedSemester)
            <div class="bg-yellow-50 dark:bg-yellow-900/30 border-2 border-yellow-300 dark:border-yellow-700 rounded-lg p-6 text-center">
                <svg class="w-12 h-12 mx-auto text-yellow-600 dark:text-yellow-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-lg font-medium text-yellow-800 dark:text-yellow-200">Silakan pilih kelas dan semester untuk melihat jadwal</p>
            </div>
        @else
            <div class="bg-gray-50 dark:bg-gray-900 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <p class="text-lg font-medium text-gray-700 dark:text-gray-300">Pilih kelas dan semester untuk melihat jadwal mingguan</p>
            </div>
        @endif

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('class_schedules.index') }}" class="inline-flex items-center px-6 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>
@endsection
