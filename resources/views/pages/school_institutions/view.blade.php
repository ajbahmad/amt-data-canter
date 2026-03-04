@extends('layouts.admin')

@section('title', 'Detail Lembaga Sekolah')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Lembaga Sekolah',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Lembaga Sekolah', 'url' => route('school_institutions.index')],
        ['name' => 'Detail', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Informasi Dasar -->
        <div>
            <div class="pb-4 border-b border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1"><i class="ti ti-code mr-2"></i>Kode Sekolah</p>
                <p class="text-lg font-semibold ">{{ $schoolInstitution->code }}</p>
            </div>
        </div>

        <div>
            <div class="pb-4 border-b border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1"><i class="ti ti-school mr-2"></i>Nama Sekolah</p>
                <p class="text-lg font-semibold ">{{ $schoolInstitution->name }}</p>
            </div>
        </div>

        <div>
            <div class="pb-4 border-b border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1"><i class="ti ti-number mr-2"></i>NPSN</p>
                <p class="text-lg font-semibold ">{{ $schoolInstitution->npsn ?? '-' }}</p>
            </div>
        </div>

        <div>
            <div class="pb-4 border-b border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1"><i class="ti ti-mail mr-2"></i>Email</p>
                <p class="text-lg font-semibold ">{{ $schoolInstitution->email ?? '-' }}</p>
            </div>
        </div>

        <div>
            <div class="pb-4 border-b border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1"><i class="ti ti-phone mr-2"></i>Telepon</p>
                <p class="text-lg font-semibold ">{{ $schoolInstitution->phone ?? '-' }}</p>
            </div>
        </div>

        <div>
            <div class="pb-4 border-b border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1"><i class="ti ti-status-change mr-2"></i>Status</p>
                <div>
                    @if($schoolInstitution->is_active)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            <i class="ti ti-circle-check mr-2"></i>Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            <i class="ti ti-circle-x mr-2"></i>Tidak Aktif
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Alamat -->
    <div class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2"><i class="ti ti-map-pin mr-2"></i>Alamat</p>
        <p class="leading-relaxed">{{ $schoolInstitution->address ?? '-' }}</p>
    </div>

    <!-- Informasi Waktu -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
        <div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1"><i class="ti ti-calendar-plus mr-2"></i>Dibuat Pada</p>
            <p class="font-medium">{{ $schoolInstitution->created_at->translatedFormat('d F Y - H:i') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1"><i class="ti ti-calendar-check mr-2"></i>Diperbarui Pada</p>
            <p class="font-medium">{{ $schoolInstitution->updated_at->translatedFormat('d F Y - H:i') }}</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-3 justify-end">
        <a href="{{ route('school_institutions.index') }}" class="inline-flex items-center px-6 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
            <i class="ti ti-arrow-left mr-2"></i> Kembali
        </a>
        <a href="{{ route('school_institutions.edit', $schoolInstitution) }}" class="inline-flex items-center px-6 py-2.5 rounded-lg bg-white text-warning font-medium hover:bg-warning hover:text-white transition">
            <i class="ti ti-edit mr-2"></i> Edit
        </a>
        <button class="inline-flex items-center px-6 py-2.5 rounded-lg bg-white text-error font-medium hover:bg-error hover:text-white transition delete-btn" data-id="{{ $schoolInstitution->id }}">
            <i class="ti ti-trash mr-2"></i> Hapus
        </button>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
<script>
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        let deleteUrlTemplate = '{{ route("school_institutions.destroy", ":id") }}';
        let deleteUrl = deleteUrlTemplate.replace(':id', id);
        
        Swal.fire({
            title: 'Hapus Data',
            text: 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan!',
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create and submit a DELETE form
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;
                form.innerHTML = `
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
</script>
@endpush
