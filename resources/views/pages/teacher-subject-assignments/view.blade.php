@extends('layouts.admin')

@section('title', 'Detail Penugasan Guru Mapel')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Penugasan Guru Mapel',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Penugasan Guru Mapel', 'url' => route('teacher_subject_assignments.index')],
        ['name' => $teacherSubjectAssignment->teacher->person->full_name, 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 bg-white p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">
        <i class="ti ti-book mr-2"></i>Informasi Penugasan Guru Mapel
    </h3>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label class="text-sm text-gray-600 ">Nama Guru</label>
            <p class="text-gray-900 font-medium">{{ $teacherSubjectAssignment->teacher->person->full_name }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 ">Email Guru</label>
            <p class="text-gray-900 font-medium">{{ $teacherSubjectAssignment->teacher->person->email ?? '-' }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 ">Mata Pelajaran</label>
            <p class="text-gray-900 font-medium">{{ $teacherSubjectAssignment->subject->name }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 ">Kelas</label>
            <p class="text-gray-900 font-medium">{{ $teacherSubjectAssignment->classRoom->name }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 ">Semester</label>
            <p class="text-gray-900 font-medium">{{ $teacherSubjectAssignment->semester->name }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 ">Tanggal Ditugaskan</label>
            <p class="text-gray-900 font-medium">{{ $teacherSubjectAssignment->assigned_at ? $teacherSubjectAssignment->assigned_at->format('d F Y H:i') : '-' }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600 ">Status</label>
            <p class="text-gray-900 font-medium">
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $teacherSubjectAssignment->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $teacherSubjectAssignment->is_active ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </p>
        </div>
    </div>
</div>

<div class="flex gap-3">
    <a href="{{ route('teacher_subject_assignments.edit', $teacherSubjectAssignment) }}" class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 transition">
        <i class="ti ti-edit mr-2"></i>Edit
    </a>
    <button onclick="deleteData('{{ $teacherSubjectAssignment->id }}', '{{ route('teacher_subject_assignments.destroy', $teacherSubjectAssignment->id) }}')" class="inline-flex items-center rounded-lg bg-red-600 px-6 py-2 text-white hover:bg-red-700 transition">
        <i class="ti ti-trash mr-2"></i>Hapus
    </button>
    <a href="{{ route('teacher_subject_assignments.index') }}" class="inline-flex items-center rounded-lg bg-gray-300 dark:bg-gray-700 px-6 py-2 text-gray-800 dark:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600 transition">
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
