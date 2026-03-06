@extends('layouts.admin')

@section('title', 'Detail Guru')

@section('content')
    @include('layouts.partials.admin.breadcrumb', [
        'title' => 'Detail Guru',
        'breadcrumbs' => [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Data Master', 'url' => '#'],
            ['name' => 'Guru', 'url' => route('teachers.index')],
            ['name' => $teacher->person->full_name, 'url' => '#'],
        ],
    ])

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3 mb-6">

        <div class="rounded-lg border border-gray-200 bg-white p-6">
            <div class="text-center mb-4">
                @if ($teacher->person->photo)
                    <img src="{{ asset('storage/' . $teacher->person->photo) }}" alt="{{ $teacher->person->full_name }}"
                        class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-blue-200">
                @else
                    <div
                        class="w-32 h-32 rounded-full mx-auto bg-gray-200 flex items-center justify-center border-4 border-blue-200">
                        <i class="ti ti-user text-5xl text-gray-400"></i>
                    </div>
                @endif
            </div>

            <h2 class="text-2xl font-bold text-center text-gray-900 mb-1">
                {{ $teacher->person->full_name }}
            </h2>

            <p class="text-center text-sm text-gray-500 mb-4">
                {{ $teacher->teacher_id }}
            </p>

            <div class="mt-6 flex gap-2">
                <a href="{{ route('teachers.edit', $teacher->id) }}"
                    class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center text-sm">
                    <i class="ti ti-edit mr-1"></i>Edit
                </a>
                <button onclick="deleteData('{{ $teacher->id }}', '{{ route('teachers.destroy', $teacher->id) }}')"
                    class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                    <i class="ti ti-trash mr-1"></i>Hapus
                </button>
            </div>
        </div>

        <div class="md:col-span-2 rounded-lg border border-gray-200 bg-white p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">
                <i class="ti ti-info-circle mr-2"></i>Informasi Guru
            </h3>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Nomor Induk Guru</label>
                    <p class="text-gray-900 font-medium">{{ $teacher->teacher_id }}</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Sekolah</label>
                    <p class="text-gray-900 font-medium">{{ $teacher->schoolInstitution->name }}</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Tipe Kepegawaian</label>
                    <p class="text-gray-900 font-medium">
                        {{ ucfirst(str_replace('_', ' ', $teacher->employment_type)) }}
                    </p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Status</label>
                    <p class="text-gray-900 font-medium">
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $teacher->status === 'active' ? 'bg-blue-100 text-blue-800' : ($teacher->status === 'retired' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $teacher->status)) }}
                        </span>
                    </p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Tanggal Diangkat</label>
                    <p class="text-gray-900 font-medium">
                        {{ $teacher->hire_date ? $teacher->hire_date->format('d F Y') : '-' }}</p>
                </div>

                @if ($teacher->specialization)
                    <div>
                        <label class="text-sm text-gray-600">Keahlian/Spesialisasi</label>
                        <p class="text-gray-900 font-medium">{{ $teacher->specialization }}</p>
                    </div>
                @endif

                @if ($teacher->notes)
                    <div>
                        <label class="text-sm text-gray-600">Catatan</label>
                        <p class="text-gray-900 font-medium">{{ $teacher->notes }}</p>
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
                <label class="text-sm text-gray-600">Nama</label>
                <p class="text-gray-900 font-medium">{{ $teacher->person->full_name }}</p>
            </div>

            <div>
                <label class="text-sm text-gray-600">Email</label>
                <p class="text-gray-900 font-medium">{{ $teacher->person->email }}</p>
            </div>

            <div>
                <label class="text-sm text-gray-600">No. Telepon</label>
                <p class="text-gray-900 font-medium">{{ $teacher->person->phone ?? '-' }}</p>
            </div>

            <div>
                <label class="text-sm text-gray-600">Jenis Kelamin</label>
                <p class="text-gray-900 font-medium">{{ ucfirst($teacher->person->gender) }}</p>
            </div>

            <div>
                <label class="text-sm text-gray-600">Tanggal Lahir</label>
                <p class="text-gray-900 font-medium">
                    {{ $teacher->person->birth_date ? $teacher->person->birth_date->format('d F Y') : '-' }}</p>
            </div>

            <div>
                <label class="text-sm text-gray-600">Tempat Lahir</label>
                <p class="text-gray-900 font-medium">{{ $teacher->person->birth_place ?? '-' }}</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
    <script>
        function deleteData(id, url) {
            Swal.fire({
                title: 'Hapus Data Guru?',
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
                    form.innerHTML = '@csrf @method('DELETE')';
                    document.body.appendChild(form);
                    form.submit();
                }
            })
        }
    </script>
@endpush
