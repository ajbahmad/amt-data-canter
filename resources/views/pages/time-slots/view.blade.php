@extends('layouts.admin')

@section('title', 'Detail Jam Pelajaran')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Jam Pelajaran',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Jam Pelajaran', 'url' => route('time_slots.index')],
        ['name' => $timeSlot->name, 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
        <i class="ti ti-clock mr-2"></i>Informasi Jam Pelajaran
    </h3>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Sekolah</label>
            <p class="text-gray-900 dark:text-white font-medium">{{ $timeSlot->schoolInstitution->name }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Tingkat Sekolah</label>
            <p class="text-gray-900 dark:text-white font-medium">{{ $timeSlot->schoolLevel->name }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Nama Jam</label>
            <p class="text-gray-900 dark:text-white font-medium">{{ $timeSlot->name }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Jam Mulai</label>
            <p class="text-gray-900 dark:text-white font-medium">{{ $timeSlot->start_time }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Jam Berakhir</label>
            <p class="text-gray-900 dark:text-white font-medium">{{ $timeSlot->end_time }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Urutan</label>
            <p class="text-gray-900 dark:text-white font-medium">{{ $timeSlot->order_no }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Status</label>
            <p class="text-gray-900 dark:text-white font-medium">
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $timeSlot->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $timeSlot->is_active ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </p>
        </div>
    </div>
</div>

<div class="flex gap-3">
    <a href="{{ route('time_slots.edit', $timeSlot) }}" class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 transition">
        <i class="ti ti-edit mr-2"></i>Edit
    </a>
    <button onclick="deleteData('{{ $timeSlot->id }}', '{{ route('time_slots.destroy', $timeSlot->id) }}')" class="inline-flex items-center rounded-lg bg-red-600 px-6 py-2 text-white hover:bg-red-700 transition">
        <i class="ti ti-trash mr-2"></i>Hapus
    </button>
    <a href="{{ route('time_slots.index') }}" class="inline-flex items-center rounded-lg bg-gray-300 dark:bg-gray-700 px-6 py-2 text-gray-800 dark:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600 transition">
        <i class="ti ti-arrow-left mr-2"></i>Kembali
    </a>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
    <script>
        function deleteData(id, url) {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data akan dihapus secara permanen",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.innerHTML = '@csrf @method("DELETE")';
                    document.body.appendChild(form);
                    form.submit();
                }
            })
        }
    </script>
@endpush
