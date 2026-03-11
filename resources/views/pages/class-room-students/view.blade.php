@extends('layouts.admin')

@section('title', 'Detail Penempatan Siswa')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Penempatan Siswa',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Penempatan Siswa', 'url' => route('class_room_students.index')],
        ['name' => $classRoomStudent->student->person->full_name, 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
        <i class="ti ti-school mr-2"></i>Informasi Penempatan Siswa
    </h3>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Kelas</label>
            <p class="text-gray-900 dark:text-white font-medium">{{ $classRoomStudent->classRoom->name }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Nama Siswa</label>
            <p class="text-gray-900 dark:text-white font-medium">{{ $classRoomStudent->student->person->full_name }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Lembaga</label>
            <p class="text-gray-900 dark:text-white font-medium">{{ $classRoomStudent->schoolInstitution?->name ?? '-' }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Sekolah</label>
            <p class="text-gray-900 dark:text-white font-medium">{{ $classRoomStudent->schoolLevel?->name ?? '-' }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">NIS</label>
            <p class="text-gray-900 dark:text-white font-medium">{{ $classRoomStudent->student->student_id }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Email</label>
            <p class="text-gray-900 dark:text-white font-medium">{{ $classRoomStudent->student->person->email ?? '-' }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Tanggal Bergabung</label>
            <p class="text-gray-900 dark:text-white font-medium">{{ $classRoomStudent->joined_at ? $classRoomStudent->joined_at->format('d F Y H:i') : '-' }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Status</label>
            <p class="text-gray-900 dark:text-white font-medium">
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $classRoomStudent->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $classRoomStudent->is_active ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </p>
        </div>
    </div>
</div>

<div class="flex gap-3">
    <a href="{{ route('class_room_students.edit', $classRoomStudent) }}" class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 transition">
        <i class="ti ti-edit mr-2"></i>Edit
    </a>
    <button onclick="deleteData('{{ $classRoomStudent->id }}', '{{ route('class_room_students.destroy', $classRoomStudent->id) }}')" class="inline-flex items-center rounded-lg bg-red-600 px-6 py-2 text-white hover:bg-red-700 transition">
        <i class="ti ti-trash mr-2"></i>Hapus
    </button>
    <a href="{{ route('class_room_students.index') }}" class="inline-flex items-center rounded-lg bg-gray-300 dark:bg-gray-700 px-6 py-2 text-gray-800 dark:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600 transition">
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
