@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detail Jadwal Kelas</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Lihat informasi jadwal kelas</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('class_schedules.edit', $schedule->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('class_schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Main Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Informasi Dasar</h2>
                
                <div class="space-y-4">
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

                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Jam</label>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $schedule->timeSlot?->name ?? '-' }} ({{ $schedule->timeSlot?->start_time ?? '-' }} - {{ $schedule->timeSlot?->end_time ?? '-' }})</p>
                    </div>
                </div>
            </div>

            <!-- Schedule Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Jadwal</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Hari</label>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $schedule->day_name }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Semester</label>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $schedule->semester?->name ?? '-' }} ({{ $schedule->semester?->school_year?->name ?? '-' }})</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Status</label>
                        <p>
                            @if ($schedule->is_active)
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Aktif</span>
                            @else
                                <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Tidak Aktif</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Dibuat</label>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $schedule->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Catatan</h2>
                <p class="text-gray-900 dark:text-white">{{ $schedule->notes ?? '-' }}</p>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('class_schedules.index') }}" class="inline-flex items-center px-6 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>
@endsection
