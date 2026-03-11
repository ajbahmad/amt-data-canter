@extends('layouts.admin')

@section('title', 'Detail Kartu ID')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Kartu ID',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Kartu ID', 'url' => route('id_cards.index')],
        ['name' => 'Detail', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 bg-white p-6">

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">
            <i class="ti ti-id mr-2"></i>{{ $idCard->card_uid }}
        </h2>
        <div class="flex gap-2">
            <a href="{{ route('id_cards.edit', $idCard->id) }}" class="inline-flex items-center rounded-lg bg-yellow-600 px-4 py-2 text-white hover:bg-yellow-700 transition">
                <i class="ti ti-edit mr-2"></i>Edit
            </a>
            <button onclick="deleteIdCard('{{ route('id_cards.destroy', $idCard->id) }}')" class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700 transition">
                <i class="ti ti-trash mr-2"></i>Hapus
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        
        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">UID Kartu</p>
            <p class="text-lg font-semibold text-gray-900 mt-1"><code>{{ $idCard->card_uid }}</code></p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Nomor Kartu</p>
            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $idCard->card_number ?? '-' }}</p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Person</p>
            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $idCard->person ? $idCard->person->full_name : '-' }}</p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Lembaga</p>
            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $idCard->schoolInstitution ? $idCard->schoolInstitution->name : '-' }}</p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Sekolah</p>
            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $idCard->schoolLevel ? $idCard->schoolLevel->name : '-' }}</p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Status</p>
            <div class="mt-1">
                @php
                    $statusMap = [
                        'active' => ['label' => 'Aktif', 'color' => 'green'],
                        'lost' => ['label' => 'Hilang', 'color' => 'red'],
                        'blocked' => ['label' => 'Diblokir', 'color' => 'yellow'],
                        'expired' => ['label' => 'Expired', 'color' => 'gray'],
                    ];
                    $statusData = $statusMap[$idCard->status] ?? ['label' => $idCard->status, 'color' => 'gray'];
                    $colorMap = [
                        'green' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                        'red' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                        'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                        'gray' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
                    ];
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $colorMap[$statusData['color']] }}">
                    <i class="ti ti-circle-check mr-2"></i>{{ $statusData['label'] }}
                </span>
            </div>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tanggal Keluaran</p>
            <p class="text-lg font-semibold text-gray-900 mt-1">
                {{ $idCard->issued_at ? $idCard->issued_at->translatedFormat('d F Y') : '-' }}
            </p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tanggal Expired</p>
            <p class="text-lg font-semibold text-gray-900 mt-1">
                {{ $idCard->expired_at ? $idCard->expired_at->translatedFormat('d F Y') : '-' }}
            </p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Dibuat</p>
            <p class="text-lg font-semibold text-gray-900 mt-1">
                {{ $idCard->created_at ? $idCard->created_at->translatedFormat('d F Y H:i') : '-' }}
            </p>
        </div>

    </div>

    @if($history && count($history) > 0)
    <div class="mt-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">
            <i class="ti ti-history mr-2"></i>Riwayat Kartu
        </h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-gray-300 dark:border-gray-600">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold text-gray-900">Tanggal</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-900">Tindakan</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-900">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($history as $record)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                            <small>{{ $record->created_at ? $record->created_at->translatedFormat('d F Y H:i') : '-' }}</small>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $actionMap = [
                                    'issued' => ['label' => 'Dikeluarkan', 'color' => 'green'],
                                    'blocked' => ['label' => 'Diblokir', 'color' => 'yellow'],
                                    'lost' => ['label' => 'Hilang', 'color' => 'red'],
                                    'replaced' => ['label' => 'Diganti', 'color' => 'blue'],
                                    'unblocked' => ['label' => 'Deblokir', 'color' => 'green'],
                                    'expired' => ['label' => 'Expired', 'color' => 'gray'],
                                ];
                                $actionData = $actionMap[$record->action] ?? ['label' => $record->action, 'color' => 'gray'];
                                $colorMap = [
                                    'green' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                    'red' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                    'blue' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                    'gray' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold {{ $colorMap[$actionData['color']] }}">
                                {{ $actionData['label'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                            <small>{{ $record->notes ?? '-' }}</small>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="mt-6 flex gap-3">
        <a href="{{ route('id_cards.index') }}" class="inline-flex items-center rounded-lg bg-gray-600 px-6 py-2 text-white hover:bg-gray-700 transition">
            <i class="ti ti-arrow-left mr-2"></i>Kembali
        </a>
    </div>

</div>

@endsection

@push('scripts')
    <script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    <script>
        function deleteIdCard(url) {
            Swal.fire({
                title: 'Hapus Data',
                html: 'Apakah Anda yakin ingin menghapus kartu ID ini? Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }
    </script>
@endpush
