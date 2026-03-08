@extends('layouts.admin')

@section('title', 'Tambah Jadwal Kelas')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Tambah Jadwal Kelas',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Jadwal Kelas', 'url' => route('class_schedules.index')],
        ['name' => 'Tambah', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
    
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
        <i class="ti ti-plus mr-2"></i>Tambah Jadwal Kelas Baru
    </h2>

    <form action="{{ route('class_schedules.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- School Institution -->
            <div>
                <label for="school_institution_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Sekolah <span class="text-red-500">*</span>
                </label>
                <select id="school_institution_id" name="school_institution_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('school_institution_id') border-red-500 @enderror" required>
                    <option value="">-- Pilih Sekolah --</option>
                </select>
                @error('school_institution_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- School Level -->
            <div>
                <label for="school_level_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Tingkat Sekolah <span class="text-red-500">*</span>
                </label>
                <select id="school_level_id" name="school_level_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('school_level_id') border-red-500 @enderror" required>
                    <option value="">-- Pilih Tingkat --</option>
                    @foreach ($schoolLevels as $level)
                        <option value="{{ $level->id }}" @if (old('school_level_id') == $level->id) selected @endif>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_level_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Classroom -->
            <div>
                <label for="class_room_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Kelas <span class="text-red-500">*</span>
                </label>
                <select id="class_room_id" name="class_room_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('class_room_id') border-red-500 @enderror" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($classRooms as $classRoom)
                        <option value="{{ $classRoom->id }}" @if (old('class_room_id') == $classRoom->id) selected @endif>
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
                        <option value="{{ $teacher->id }}" @if (old('teacher_id') == $teacher->id) selected @endif>
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
                        <option value="{{ $subject->id }}" @if (old('subject_id') == $subject->id) selected @endif>
                            {{ $subject->name }} ({{ $subject->code }})
                        </option>
                    @endforeach
                </select>
                @error('subject_id')
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
                        <option value="{{ $semester->id }}" @if (old('semester_id') == $semester->id) selected @endif>
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
                    <option value="1" @if (old('day_of_week') == 1) selected @endif>Senin</option>
                    <option value="2" @if (old('day_of_week') == 2) selected @endif>Selasa</option>
                    <option value="3" @if (old('day_of_week') == 3) selected @endif>Rabu</option>
                    <option value="4" @if (old('day_of_week') == 4) selected @endif>Kamis</option>
                    <option value="5" @if (old('day_of_week') == 5) selected @endif>Jumat</option>
                    <option value="6" @if (old('day_of_week') == 6) selected @endif>Sabtu</option>
                    <option value="7" @if (old('day_of_week') == 7) selected @endif>Minggu</option>
                </select>
                @error('day_of_week')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Start Time Slot -->
            <div>
                <label for="start_time_slot_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Jam Mulai <span class="text-red-500">*</span>
                </label>
                <select id="start_time_slot_id" name="start_time_slot_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('start_time_slot_id') border-red-500 @enderror" required>
                    <option value="">-- Pilih Jam Mulai --</option>
                    @foreach ($timeSlots as $timeSlot)
                        <option value="{{ $timeSlot->id }}" @if (old('start_time_slot_id') == $timeSlot->id) selected @endif>
                            {{ $timeSlot->name }} ({{ $timeSlot->start_time }} - {{ $timeSlot->end_time }})
                        </option>
                    @endforeach
                </select>
                @error('start_time_slot_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- End Time Slot -->
            <div>
                <label for="end_time_slot_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Jam Selesai <span class="text-red-500">*</span>
                </label>
                <select id="end_time_slot_id" name="end_time_slot_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('end_time_slot_id') border-red-500 @enderror" required>
                    <option value="">-- Pilih Jam Selesai --</option>
                    @foreach ($timeSlots as $timeSlot)
                        <option value="{{ $timeSlot->id }}" @if (old('end_time_slot_id') == $timeSlot->id) selected @endif>
                            {{ $timeSlot->name }} ({{ $timeSlot->start_time }} - {{ $timeSlot->end_time }})
                        </option>
                    @endforeach
                </select>
                @error('end_time_slot_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3 mt-8">
            <button type="submit" class="inline-flex items-center rounded-lg bg-green-600 px-6 py-2 text-white hover:bg-green-700 transition">
                <i class="ti ti-check mr-2"></i>Simpan
            </button>
            <a href="{{ route('class_schedules.index') }}" class="inline-flex items-center rounded-lg bg-gray-600 px-6 py-2 text-white hover:bg-gray-700 transition">
                <i class="ti ti-x mr-2"></i>Batal
            </a>
        </div>
    </form>

</div>

@endsection
