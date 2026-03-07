<div class="flex justify-center gap-2">
    <a href="{{ route('class_schedules.show', $id) }}" class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded hover:bg-blue-200 dark:hover:bg-blue-800 transition" title="Lihat">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
    </a>
    <a href="{{ route('class_schedules.edit', $id) }}" class="inline-flex items-center px-3 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 rounded hover:bg-indigo-200 dark:hover:bg-indigo-800 transition" title="Edit">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
    </a>
    <form action="{{ route('class_schedules.destroy', $id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300 rounded hover:bg-red-200 dark:hover:bg-red-800 transition" title="Hapus">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>
    </form>
</div>
