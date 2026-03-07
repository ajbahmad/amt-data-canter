@extends('layouts.admin')

@section('title', 'Tambah Wali Kelas')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Tambah Wali Kelas',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Wali Kelas', 'url' => route('class_room_homeroom_teachers.index')],
        ['name' => 'Tambah', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
    <form action="{{ route('class_room_homeroom_teachers.store') }}" method="POST">
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
                    Guru Wali <span class="text-red-500">*</span>
                </label>
                <select name="teacher_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('teacher_id') border-red-500 @enderror">
                    <option value="">-- Pilih Guru Wali --</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->person->full_name }}
                        </option>
                    @endforeach
                </select>
                @error('teacher_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Tanggal Ditugaskan
                </label>
                <input type="datetime-local" name="assigned_at" value="{{ old('assigned_at') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('assigned_at') border-red-500 @enderror">
                @error('assigned_at')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
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
            <a href="{{ route('class_room_homeroom_teachers.index') }}" class="inline-flex items-center rounded-lg bg-gray-300 dark:bg-gray-700 px-6 py-2 text-gray-800 dark:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600 transition">
                <i class="ti ti-x mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
    @include('components.confirm-toastr')
@endpush
