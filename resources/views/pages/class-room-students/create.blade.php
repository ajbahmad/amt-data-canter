@extends('layouts.admin')

@section('title', 'Tambah Penempatan Siswa')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Tambah Penempatan Siswa',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Penempatan Siswa', 'url' => route('class_room_students.index')],
        ['name' => 'Tambah', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
    <form action="{{ route('class_room_students.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Kelas <span class="text-red-500">*</span>
                </label>
                <select name="class_room_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('class_room_id') border-red-500 @enderror">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classRooms as $room)
                        <option value="{{ $room->id }}" {{ old('class_room_id') == $room->id ? 'selected' : '' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>
                @error('class_room_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Siswa <span class="text-red-500">*</span>
                </label>
                <select name="student_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('student_id') border-red-500 @enderror">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->person->full_name }} ({{ $student->student_id }})
                        </option>
                    @endforeach
                </select>
                @error('student_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Tanggal Bergabung
                </label>
                <input type="datetime-local" name="joined_at" value="{{ old('joined_at') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('joined_at') border-red-500 @enderror">
                @error('joined_at')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} class="rounded dark:bg-gray-700">
                    <span class="ml-2">Aktif</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 transition">
                <i class="ti ti-check mr-2"></i>Simpan
            </button>
            <a href="{{ route('class_room_students.index') }}" class="inline-flex items-center rounded-lg bg-gray-300 dark:bg-gray-700 px-6 py-2 text-gray-800 dark:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600 transition">
                <i class="ti ti-x mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

@endsection
