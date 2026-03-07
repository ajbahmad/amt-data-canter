@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Jadwal Kelas</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Perbarui jadwal kelas</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <form action="{{ route('class_schedules.update', $schedule->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Classroom -->
                    <div>
                        <label for="class_room_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Kelas <span class="text-red-500">*</span>
                        </label>
                        <select id="class_room_id" name="class_room_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('class_room_id') border-red-500 @enderror" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($classRooms as $classRoom)
                                <option value="{{ $classRoom->id }}" @if (old('class_room_id', $schedule->class_room_id) == $classRoom->id) selected @endif>
                                    {{ $classRoom->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_room_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Teacher -->
                    <div>
                        <label for="teacher_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Guru <span class="text-red-500">*</span>
                        </label>
                        <select id="teacher_id" name="teacher_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('teacher_id') border-red-500 @enderror" required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}" @if (old('teacher_id', $schedule->teacher_id) == $teacher->id) selected @endif>
                                    {{ $teacher->person?->full_name }} ({{ $teacher->teacher_id }})
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mapel <span class="text-red-500">*</span>
                        </label>
                        <select id="subject_id" name="subject_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('subject_id') border-red-500 @enderror" required>
                            <option value="">-- Pilih Mapel --</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" @if (old('subject_id', $schedule->subject_id) == $subject->id) selected @endif>
                                    {{ $subject->name }} ({{ $subject->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Time Slot -->
                    <div>
                        <label for="time_slot_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jam <span class="text-red-500">*</span>
                        </label>
                        <select id="time_slot_id" name="time_slot_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('time_slot_id') border-red-500 @enderror" required>
                            <option value="">-- Pilih Jam --</option>
                            @foreach ($timeSlots as $timeSlot)
                                <option value="{{ $timeSlot->id }}" @if (old('time_slot_id', $schedule->time_slot_id) == $timeSlot->id) selected @endif>
                                    {{ $timeSlot->name }} ({{ $timeSlot->start_time }} - {{ $timeSlot->end_time }})
                                </option>
                            @endforeach
                        </select>
                        @error('time_slot_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Semester -->
                    <div>
                        <label for="semester_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Semester <span class="text-red-500">*</span>
                        </label>
                        <select id="semester_id" name="semester_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('semester_id') border-red-500 @enderror" required>
                            <option value="">-- Pilih Semester --</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}" @if (old('semester_id', $schedule->semester_id) == $semester->id) selected @endif>
                                    {{ $semester->name }} ({{ $semester->school_year?->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('semester_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Day of Week -->
                    <div>
                        <label for="day_of_week" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Hari <span class="text-red-500">*</span>
                        </label>
                        <select id="day_of_week" name="day_of_week" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('day_of_week') border-red-500 @enderror" required>
                            <option value="">-- Pilih Hari --</option>
                            <option value="1" @if (old('day_of_week', $schedule->day_of_week) == 1) selected @endif>Senin</option>
                            <option value="2" @if (old('day_of_week', $schedule->day_of_week) == 2) selected @endif>Selasa</option>
                            <option value="3" @if (old('day_of_week', $schedule->day_of_week) == 3) selected @endif>Rabu</option>
                            <option value="4" @if (old('day_of_week', $schedule->day_of_week) == 4) selected @endif>Kamis</option>
                            <option value="5" @if (old('day_of_week', $schedule->day_of_week) == 5) selected @endif>Jumat</option>
                            <option value="6" @if (old('day_of_week', $schedule->day_of_week) == 6) selected @endif>Sabtu</option>
                            <option value="7" @if (old('day_of_week', $schedule->day_of_week) == 7) selected @endif>Minggu</option>
                        </select>
                        @error('day_of_week')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Catatan
                    </label>
                    <textarea id="notes" name="notes" rows="4" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror" placeholder="Masukkan catatan tambahan...">{{ old('notes', $schedule->notes) }}</textarea>
                    @error('notes')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="mt-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" @if (old('is_active', $schedule->is_active)) checked @endif class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Aktif</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 mt-8">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Perbarui
                    </button>
                    <a href="{{ route('class_schedules.show', $schedule->id) }}" class="inline-flex items-center px-6 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
