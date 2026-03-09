@extends('layouts.admin')

@section('title', 'Detail Wali Kelas')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Wali Kelas',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Wali Kelas', 'url' => route('class_room_homeroom_teachers.index')],
        ['name' => $classRoomHomeroomTeacher->teacher->person->full_name, 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 bg-white p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">
        <i class="ti ti-users mr-2"></i>Informasi Wali Kelas
    </h3>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Kelas</label>
            <p class="text-gray-900 font-medium">{{ $classRoomHomeroomTeacher->classRoom->name }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Nama Guru Wali</label>
            <p class="text-gray-900 font-medium">{{ $classRoomHomeroomTeacher->teacher->person->full_name }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Email</label>
            <p class="text-gray-900 font-medium">{{ $classRoomHomeroomTeacher->teacher->person->email ?? '-' }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Tanggal Ditugaskan</label>
            <p class="text-gray-900 font-medium">{{ $classRoomHomeroomTeacher->assigned_at ? $classRoomHomeroomTeacher->assigned_at->format('d F Y H:i') : '-' }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Status</label>
            <p class="text-gray-900 font-medium">
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $classRoomHomeroomTeacher->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $classRoomHomeroomTeacher->is_active ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </p>
        </div>
    </div>
</div>

<div class="flex gap-3">
    <a href="{{ route('class_room_homeroom_teachers.edit', $classRoomHomeroomTeacher) }}" class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 transition">
        <i class="ti ti-edit mr-2"></i>Edit
    </a>
    <button onclick="deleteData('{{ $classRoomHomeroomTeacher->id }}', '{{ route('class_room_homeroom_teachers.destroy', $classRoomHomeroomTeacher->id) }}')" class="inline-flex items-center rounded-lg bg-red-600 px-6 py-2 text-white hover:bg-red-700 transition">
        <i class="ti ti-trash mr-2"></i>Hapus
    </button>
    <a href="{{ route('class_room_homeroom_teachers.index') }}" class="inline-flex items-center rounded-lg bg-gray-300 dark:bg-gray-700 px-6 py-2 text-gray-800 dark:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600 transition">
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
