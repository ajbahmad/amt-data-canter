@extends('layouts.admin')

@section('title', 'Detail Siswa')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Siswa',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Siswa', 'url' => route('students.index')],
        ['name' => $student->person->full_name, 'url' => '#']
    ]
])

<div class="grid grid-cols-1 gap-6 md:grid-cols-3 mb-6">

    <div class="rounded-lg border border-gray-200 bg-white p-6">
        <div class="text-center mb-4">
            @if($student->person->photo)
                <img src="{{ asset('storage/' . $student->person->photo) }}" alt="{{ $student->person->full_name }}" class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-blue-200">
            @else
                <div class="w-32 h-32 rounded-full mx-auto bg-gray-200 flex items-center justify-center border-4 border-blue-200">
                    <i class="ti ti-user text-5xl text-gray-400"></i>
                </div>
            @endif
        </div>

        <h2 class="text-2xl font-bold text-center text-gray-900 mb-1">
            {{ $student->person->full_name }}
        </h2>

        <p class="text-center text-sm text-gray-500 mb-4">
            {{ $student->student_id }}
        </p>

        <div class="mt-6 flex gap-2">
            <a href="{{ route('students.edit', $student->id) }}" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center text-sm">
                <i class="ti ti-edit mr-1"></i>Edit
            </a>
            <button onclick="deleteData('{{ $student->id }}', '{{ route('students.destroy', $student->id) }}')" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                <i class="ti ti-trash mr-1"></i>Hapus
            </button>
        </div>
    </div>

    <div class="md:col-span-2 rounded-lg border border-gray-200 bg-white p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">
            <i class="ti ti-info-circle mr-2"></i>Informasi Siswa
        </h3>

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="text-sm text-gray-600">Nomor Induk Siswa</label>
                <p class="text-gray-900 font-medium">{{ $student->student_id }}</p>
            </div>

            <div>
                <label class="text-sm text-gray-600">Sekolah</label>
                <p class="text-gray-900 font-medium">{{ $student->schoolInstitution->name }}</p>
            </div>

            <div>
                <label class="text-sm text-gray-600">Status</label>
                <p class="text-gray-900 font-medium">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $student->status === 'active' ? 'bg-blue-100 text-blue-800' : ($student->status === 'graduated' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst(str_replace('_', ' ', $student->status)) }}
                    </span>
                </p>
            </div>

            <div>
                <label class="text-sm text-gray-600">Tanggal Pendaftaran</label>
                <p class="text-gray-900 font-medium">{{ $student->enrollment_date ? $student->enrollment_date->format('d F Y') : '-' }}</p>
            </div>

            @if($student->notes)
            <div>
                <label class="text-sm text-gray-600">Catatan</label>
                <p class="text-gray-900 font-medium">{{ $student->notes }}</p>
            </div>
            @endif
        </div>
    </div>

</div>

<div class="rounded-lg border border-gray-200 bg-white p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">
        <i class="ti ti-user mr-2"></i>Data Orang
    </h3>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label class="text-sm text-gray-600">Email</label>
            <p class="text-gray-900 font-medium">{{ $student->person->email }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600">Telepon</label>
            <p class="text-gray-900 font-medium">{{ $student->person->phone ?? '-' }}</p>
        </div>

        <div>
            <label class="text-sm text-gray-600">Tanggal Lahir</label>
            <p class="text-gray-900 font-medium">
                @if($student->person->birth_date)
                    {{ $student->person->birth_date->format('d F Y') }}
                @else
                    -
                @endif
            </p>
        </div>

        <div>
            <label class="text-sm text-gray-600">Jenis Kelamin</label>
            <p class="text-gray-900 font-medium">
                @if($student->person->gender)
                    {{ $student->person->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                @else
                    -
                @endif
            </p>
        </div>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/libs/sweetalert2/css/sweetalert2.min.css')}}">
@endpush
@push('scripts')
<script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>

<script>
    function deleteData(id, url) {
        Swal.fire({
            title: 'Hapus Data?',
            text: 'Anda yakin ingin menghapus data siswa ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.innerHTML = `@csrf @method('DELETE')`;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endpush
