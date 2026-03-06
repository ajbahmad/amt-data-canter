@extends('layouts.admin')

@section('title', 'Detail Orang')

@section('content')

    @include('layouts.partials.admin.breadcrumb', [
        'title' => 'Detail Orang',
        'breadcrumbs' => [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Data Master', 'url' => '#'],
            ['name' => 'Orang', 'url' => route('persons.index')],
            ['name' => $person->first_name . ' ' . $person->last_name, 'url' => '#'],
        ],
    ])

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3 mb-6">

        <!-- Photo & Basic Info Card -->
        <div class="md:col-span-2 rounded-lg border border-gray-200 bg-white p-6">
            <div class="text-center mb-4">
                @if ($person->photo)
                    <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->full_name }}"
                        class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-blue-200">
                @else
                    <div
                        class="w-32 h-32 rounded-full mx-auto bg-gray-200 flex items-center justify-center border-4 border-blue-200">
                        <i class="ti ti-user text-5xl text-gray-400"></i>
                    </div>
                @endif
            </div>

            <h2 class="text-2xl font-bold text-center text-gray-900 mb-1">
                {{ $person->full_name }}
            </h2>

            <p class="text-center text-sm text-gray-500 mb-4">
                {{ $person->email }}
            </p>

            <div class="grid grid-cols-12 gap-4 mb-4">
                <div class="col-span-3"></div>
                <div class="col-span-6">
                    <div class="grid grid-cols-4 gap-4 mt-6">
                        <form action="{{ route('persons.update', $person->id) }}" class="hidden" enctype="multipart/form-data" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="photo_only" value="ya">
                            <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden">
                        </form>
                        <a href="{{ route('persons.index') }}"
                            class="flex-1 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-center text-sm">
                            <i class="ti ti-arrow-left mr-1"></i>Kembali
                        </a>
                        <a href="{{ route('persons.edit', $person->id) }}"
                            class="flex-1 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition text-center text-sm">
                            <i class="ti ti-edit mr-1"></i>Edit
                        </a>
                        <button onclick="updateFoto('{{ $person->id }}', '{{ route('persons.update', $person->id) }}')"
                            class="flex-1 px-4 py-2 bg-success text-white rounded-lg hover:bg-success-400 transition text-sm">
                            <i class="ti ti-photo mr-1"></i>Ubah Foto
                        </button>
                        <button onclick="deleteData('{{ $person->id }}', '{{ route('persons.destroy', $person->id) }}')"
                            class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                            <i class="ti ti-trash mr-1"></i>Hapus
                        </button>
                    </div>
                </div>
                <div class="col-span-3"></div>
            </div>

            <div class="grid grid-cols-2 mt-6 gap-4">
                <div>
                    <div class="mb-6">
                        <label class="text-sm text-gray-600">Tanggal Bergabung</label>
                        <p class="text-gray-900 font-medium">{{ $person->created_at->format('d F Y') }}</p>
                    </div>
                    <div class="mb-6">
                        <label class="text-sm text-gray-600">Jenis Kelamin</label>
                        <p class="text-gray-900 font-medium">{{ $person->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                        </p>
                    </div>
                </div>
                <div class="text-end">
                    <div class="mb-6">
                        <label class="text-sm text-gray-600">Terakhir Diperbarui</label>
                        <p class="text-gray-900 font-medium">{{ $person->updated_at->format('d F Y') }}</p>
                    </div>
                    <div class="mb-6">
                        <label class="text-sm text-gray-600">Status</label>
                        <p>
                            @if ($person->is_active)
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="ti ti-circle-check mr-1"></i>Aktif
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <i class="ti ti-circle-x mr-1"></i>Non-Aktif
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>


        </div>

        <!-- Personal Information Card -->
        <div class="md:col-span-2 rounded-lg border border-gray-200 bg-white p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">
                <i class="ti ti-info-circle mr-2"></i>Informasi Pribadi
            </h3>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <p class="text-gray-900 font-medium">{{ $person->email }}</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Telepon</label>
                    <p class="text-gray-900 font-medium">{{ $person->phone ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Tanggal Lahir</label>
                    <p class="text-gray-900 font-medium">
                        @if ($person->birth_date)
                            {{ $person->birth_date->format('d F Y') }} ({{ $person->age }} tahun)
                        @else
                            -
                        @endif
                    </p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Tempat Lahir</label>
                    <p class="text-gray-900 font-medium">{{ $person->birth_place ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Nomor Identitas</label>
                    <p class="text-gray-900 font-medium">{{ $person->identity_number ?? '-' }}</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Address Information Card -->
    @if ($person->address || $person->city || $person->province || $person->postal_code)
        <div class="rounded-lg border border-gray-200 bg-white p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">
                <i class="ti ti-map-pin mr-2"></i>Alamat
            </h3>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Alamat Lengkap</label>
                    <p class="text-gray-900 font-medium">{{ $person->address ?? '-' }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Kota</label>
                        <p class="text-gray-900 font-medium">{{ $person->city ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Provinsi</label>
                        <p class="text-gray-900 font-medium">{{ $person->province ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Kode Pos</label>
                        <p class="text-gray-900 font-medium">{{ $person->postal_code ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Person Type Memberships Card -->
    @if ($person->memberships->count() > 0)
        <div class="rounded-lg border border-gray-200 bg-white p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">
                <i class="ti ti-users mr-2"></i>Tipe Orang
            </h3>

            <div class="space-y-3">
                @foreach ($person->memberships as $membership)
                    <div class="p-3 border border-gray-200 rounded-lg bg-gray-50">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-900">{{ $membership->personType->name }}</span>
                            @if ($membership->is_active)
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    Non-Aktif
                                </span>
                            @endif
                        </div>
                        @if ($membership->joined_date)
                            <p class="text-sm text-gray-600 mt-2">
                                Bergabung: {{ $membership->joined_date->format('d F Y') }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Related Records Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @if ($person->student)
            <div class="rounded-lg border border-gray-200 bg-white p-6">
                <div class="flex items-center mb-3">
                    <i class="ti ti-book text-2xl text-blue-600 mr-3"></i>
                    <h3 class="text-lg font-bold text-gray-900">Data Siswa</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">Nomor Induk: {{ $person->student->student_id }}
                </p>
                <a href="{{ route('students.show', $person->student->id) }}"
                    class="inline-flex items-center text-blue-600 hover:text-blue-700 text-sm">
                    <i class="ti ti-arrow-right mr-1"></i>Lihat Detail
                </a>
            </div>
        @endif

        @if ($person->teacher)
            <div class="rounded-lg border border-gray-200 bg-white p-6">
                <div class="flex items-center mb-3">
                    <i class="ti ti-chalkboard text-2xl text-green-600 mr-3"></i>
                    <h3 class="text-lg font-bold text-gray-900">Data Guru</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">Nomor Induk: {{ $person->teacher->teacher_id }}
                </p>
                <a href="{{ route('teachers.show', $person->teacher->id) }}"
                    class="inline-flex items-center text-green-600 hover:text-green-700 text-sm">
                    <i class="ti ti-arrow-right mr-1"></i>Lihat Detail
                </a>
            </div>
        @endif

        @if ($person->staff)
            <div class="rounded-lg border border-gray-200 bg-white p-6">
                <div class="flex items-center mb-3">
                    <i class="ti ti-briefcase text-2xl text-orange-600 mr-3"></i>
                    <h3 class="text-lg font-bold text-gray-900">Data Staf</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">Nomor Induk: {{ $person->staff->staff_id }}</p>
                <a href="{{ route('staffs.show', $person->staff->id) }}"
                    class="inline-flex items-center text-orange-600 hover:text-orange-700 text-sm">
                    <i class="ti ti-arrow-right mr-1"></i>Lihat Detail
                </a>
            </div>
        @endif
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/libs/sweetalert2/css/sweetalert2.min.css')}}">
@endpush

@push('scripts')
    <script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>

    <script>
        function updateFoto(id, url){
            Swal.fire({
                title: 'Ubah Foto?',
                text: 'Anda yakin ingin mengubah foto orang ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Ubah!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#photoInput').click();
                    $('#photoInput').change(function(){
                        const form = $(this).closest('form');
                        form.submit();
                    })
                }
            });
        }

        function deleteData(id, url) {
            Swal.fire({
                title: 'Hapus Data?',
                text: 'Anda yakin ingin menghapus data orang ini? Tindakan ini tidak bisa dibatalkan.',
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
