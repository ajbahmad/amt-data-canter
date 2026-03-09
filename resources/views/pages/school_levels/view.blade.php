@extends('layouts.admin')

@section('title', 'Detail Level Sekolah')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Level Sekolah',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Level Sekolah', 'url' => route('school_levels.index')],
        ['name' => 'Detail', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 bg-white p-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Kode Level -->
        <div>
            <div class="pb-4 border-b border-gray-200">
                <p class="text-sm text-gray-600 mb-1"><i class="ti ti-code mr-2"></i>Kode Level</p>
                <p class="text-lg font-semibold text-gray-900">{{ $schoolLevel->code }}</p>
            </div>
        </div>

        <!-- Nama Level -->
        <div>
            <div class="pb-4 border-b border-gray-200">
                <p class="text-sm text-gray-600 mb-1"><i class="ti ti-school mr-2"></i>Nama Level</p>
                <p class="text-lg font-semibold text-gray-900">{{ $schoolLevel->name }}</p>
            </div>
        </div>

        <!-- Status -->
        <div>
            <div class="pb-4 border-b border-gray-200">
                <p class="text-sm text-gray-600 mb-1"><i class="ti ti-status-change mr-2"></i>Status</p>
                <div>
                    @if($schoolLevel->is_active)
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

    <!-- Deskripsi -->
    @if($schoolLevel->description)
    <div class="mb-8 pb-8 border-b border-gray-200">
        <p class="text-sm text-gray-600 mb-2"><i class="ti ti-file-description mr-2"></i>Deskripsi</p>
        <p class="text-gray-900 leading-relaxed">{{ $schoolLevel->description }}</p>
    </div>
    @endif

    <!-- Informasi Waktu -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 pb-8 border-b border-gray-200">
        <div>
            <p class="text-sm text-gray-600 mb-1"><i class="ti ti-calendar-plus mr-2"></i>Dibuat Pada</p>
            <p class="text-gray-900 font-medium">{{ $schoolLevel->created_at->translatedFormat('d F Y - H:i') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600 mb-1"><i class="ti ti-calendar-check mr-2"></i>Diperbarui Pada</p>
            <p class="text-gray-900 font-medium">{{ $schoolLevel->updated_at->translatedFormat('d F Y - H:i') }}</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-3 justify-end">
        <a href="{{ route('school_levels.index') }}" class="inline-flex items-center px-6 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
            <i class="ti ti-arrow-left mr-2"></i>Kembali
        </a>
        <a href="{{ route('school_levels.edit', $schoolLevel) }}" class="inline-flex items-center px-6 py-2.5 rounded-lg bg-amber-600 text-white font-medium hover:bg-amber-700 transition">
            <i class="ti ti-edit mr-2"></i>Edit
        </a>
        <button class="inline-flex items-center px-6 py-2.5 rounded-lg bg-red-600 text-white font-medium hover:bg-red-700 transition delete-btn" data-id="{{ $schoolLevel->id }}">
            <i class="ti ti-trash mr-2"></i>Hapus
        </button>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script>
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        let deleteUrl = '{{ route('school_levels.destroy', ':id') }}'.replace(':id', id);
        
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
