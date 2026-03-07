@extends('layouts.admin')

@section('title', 'Edit Jam Pelajaran')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Edit Jam Pelajaran',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Jam Pelajaran', 'url' => route('time_slots.index')],
        ['name' => 'Edit', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
    <form action="{{ route('time_slots.update', $timeSlot) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Sekolah <span class="text-red-500">*</span>
                </label>
                <select name="school_institution_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('school_institution_id') border-red-500 @enderror">
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach($schoolInstitutions as $school)
                        <option value="{{ $school->id }}" {{ old('school_institution_id', $timeSlot->school_institution_id) == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_institution_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Tingkat Sekolah <span class="text-red-500">*</span>
                </label>
                <select name="school_level_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('school_level_id') border-red-500 @enderror">
                    <option value="">-- Pilih Tingkat Sekolah --</option>
                    @foreach($schoolLevels as $level)
                        <option value="{{ $level->id }}" {{ old('school_level_id', $timeSlot->school_level_id) == $level->id ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_level_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nama Jam <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $timeSlot->name) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" placeholder="Contoh: Jam 1">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Jam Mulai <span class="text-red-500">*</span>
                </label>
                <input type="time" name="start_time" value="{{ old('start_time', $timeSlot->start_time) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('start_time') border-red-500 @enderror">
                @error('start_time')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Jam Berakhir <span class="text-red-500">*</span>
                </label>
                <input type="time" name="end_time" value="{{ old('end_time', $timeSlot->end_time) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('end_time') border-red-500 @enderror">
                @error('end_time')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Urutan
                </label>
                <input type="number" name="order_no" value="{{ old('order_no', $timeSlot->order_no) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500" min="0" placeholder="0">
                @error('order_no')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $timeSlot->is_active) ? 'checked' : '' }} class="rounded dark:bg-gray-700">
                    <span class="ml-2">Aktif</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 transition">
                <i class="ti ti-check mr-2"></i>Update
            </button>
            <a href="{{ route('time_slots.show', $timeSlot) }}" class="inline-flex items-center rounded-lg bg-gray-300 dark:bg-gray-700 px-6 py-2 text-gray-800 dark:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600 transition">
                <i class="ti ti-x mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

@endsection
@push('scripts')
    @include('components.confirm-toastr')
@endpush
