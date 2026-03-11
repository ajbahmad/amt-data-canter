@extends('layouts.admin')

@section('title', 'Detail Tipe Orang')

@section('content')

    @include('layouts.partials.admin.breadcrumb', [
        'title' => 'Detail Tipe Orang',
        'breadcrumbs' => [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Data Master', 'url' => '#'],
            ['name' => 'Tipe Orang', 'url' => route('person_types.index')],
            ['name' => 'Detail', 'url' => '#'],
        ],
    ])

    <div class="rounded-lg border border-gray-200  bg-white  p-6 mb-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $personType->name }}</h3>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700  mb-2">Deskripsi</label>
            <p class="text-gray-900">{{ $personType->description ?? 'Tidak ada deskripsi' }}</p>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700  mb-2">Status</label>
            <span
                class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $personType->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $personType->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700  mb-2">Lembaga</label>
            <p class="text-gray-900">{{ $personType->schoolInstitution?->name ?? '-' }}</p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('person_types.index') }}"
                class="inline-flex items-center rounded-lg bg-gray-300 px-6 py-2 text-gray-800 hover:bg-gray-400 transition">
                <i class="ti ti-arrow-left mr-2"></i>Kembali
            </a>
            <a href="{{ route('person_types.edit', $personType->id) }}"
                class="inline-flex items-center rounded-lg bg-yellow-600 px-6 py-2 text-white hover:bg-yellow-700 transition">
                <i class="ti ti-edit mr-2"></i>Edit
            </a>
            <form action="{{ route('person_types.destroy', $personType->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="button"
                    class="inline-flex items-center rounded-lg bg-red-600 px-6 py-2 text-white hover:bg-red-700 transition"
                    onclick="confirmDelete()">
                    <i class="ti ti-trash mr-2"></i>Hapus
                </button>
            </form>

        </div>
    </div>

    @if ($personType->memberships && count($personType->memberships) > 0)
        <div class="rounded-lg border border-gray-200  bg-white  p-6">
            <h4 class="text-lg font-bold mb-4 text-gray-900">Orang dengan Tipe Ini</h4>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Nama</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Tanggal Bergabung</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($personType->memberships as $membership)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 text-gray-900">{{ $membership->person->full_name }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $membership->person->email }}</td>
                                <td class="px-6 py-3 text-gray-900">{{ $membership->joined_date?->format('d M Y') ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif


@endsection


@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/css/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js') }}"></script>


    <script>
        function confirmDelete() {
            Swal.fire({
                title: 'Hapus Tipe Orang?',
                text: 'Data akan dihapus secara permanen',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    document.querySelector('form').submit();
                }
            });
        }
    </script>
@endpush
