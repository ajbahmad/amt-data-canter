@extends('layouts.admin')

@section('title', 'Kalender Akademik')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Daftar Kalender Akademik',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Kalender Akademik', 'url' => '#']
    ]
])


<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">

    <div class="mb-6 flex items-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <i class="ti ti-door mr-2"></i>Daftar Kalender Akademik
        </h2>
        
        <a href="{{ route('calendars.grid') }}" class="inline-flex ms-auto me-2 items-center rounded-lg bg-success px-4 py-2 text-white hover:bg-success-700 transition">
            <i class="ti ti-calendar mr-2"></i> Lihat kalender
        </a>

        <button type="button" id="btn-add-event"
            class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">
            <i class="ti ti-plus mr-2"></i>Tambah Catatan
        </button>
    </div>
    
    {{ $dataTable->table() }}

</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/libs/DataTables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/libs/sweetalert2/css/sweetalert2.min.css')}}">
    


    <style>
        .dt-paging-button{
            border-radius: 50% !important;
        }
        .table-responsive{
            overflow-x: auto;
        }
        #datatable thead tr.filters th{
            padding: 10px 1px;
            font-weight: 100 !important
        }
        #datatable thead tr th{
            white-space: nowrap;
        }
    </style>

@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/libs/DataTables/datatables.min.js') }}"></script>
    <script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    {!! $dataTable->scripts() !!}
    @include('components.confirm-toastr')

    <script>
        // Data untuk form
        const calendarData = {
            institutions: @json($institutions ?? []),
            levels: @json($levels ?? []),
            classRooms: @json($classRooms ?? []),
            csrfToken: "{{ csrf_token() }}",
        };

        // Edit Calendar Event
        function editCalendarEvent(eventId) {
            $.ajax({
                url: `/calendars/${eventId}/show`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': calendarData.csrfToken,
                },
                success: function(data) {
                    openEditModal(data);
                },
                error: function(err) {
                    console.error('Error:', err);
                    Swal.fire('Error!', 'Gagal memuat data event', 'error');
                }
            });
        }

        // Delete Calendar Event
        function deleteCalendarEvent(eventId) {
            Swal.fire({
                title: 'Hapus Event?',
                text: 'Apakah Anda yakin ingin menghapus event ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/calendars/${eventId}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': calendarData.csrfToken,
                        },
                        success: function(result) {
                            Swal.fire('Sukses!', 'Event berhasil dihapus', 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function(err) {
                            console.error('Error:', err);
                            Swal.fire('Error!', 'Gagal menghapus event', 'error');
                        }
                    });
                }
            });
        }

        // Open Add Modal
        function openAddModal() {
            const dateStr = new Date().toISOString().split('T')[0];
            
            Swal.fire({
                html: '<div class="text-fs_28 font-bold mb-4">Tambah Catatan</div>' +  buildForm({ start_date: dateStr }),
                width: '600px',
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3b82f6',
                didOpen: () => {
                    setTimeout(() => {
                        $('#school_institution_id, #school_level_id, #class_room_id').select2({
                            width: '100%',
                            allowClear: true,
                            placeholder: 'Pilih...'
                        });
                    }, 100);
                },
                preConfirm: () => {
                    const title = document.getElementById('title')?.value;
                    if (!title) {
                        Swal.showValidationMessage('Judul harus diisi');
                        return false;
                    }
                    return getFormData();
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    createCalendarEvent(result.value);
                }
            });
        }

        // Open Edit Modal
        function openEditModal(event) {
            const eventData = {
                id: event.id,
                title: event.title,
                description: event.description,
                start_date: event.start_date,
                end_date: event.end_date,
                type: event.type,
                is_holiday: event.is_holiday,
                color: event.color,
                school_institution_ids: event.school_institution_ids || [],
                school_level_ids: event.school_level_ids || [],
                class_room_ids: event.class_room_ids || [],
            };

            Swal.fire({
                html: '<div class="text-fs_28 font-bold mb-4">Edit Catatan</div>' +  buildForm(eventData),
                width: '600px',
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3b82f6',
                didOpen: () => {
                    setTimeout(() => {
                        $('#school_institution_id, #school_level_id, #class_room_id').select2({
                            width: '100%',
                            allowClear: true,
                            placeholder: 'Pilih...'
                        });
                        
                        if (eventData.school_institution_ids) {
                            $('#school_institution_id').val(eventData.school_institution_ids).trigger('change');
                        }
                        if (eventData.school_level_ids) {
                            $('#school_level_id').val(eventData.school_level_ids).trigger('change');
                        }
                        if (eventData.class_room_ids) {
                            $('#class_room_id').val(eventData.class_room_ids).trigger('change');
                        }
                    }, 100);
                },
                preConfirm: () => {
                    const title = document.getElementById('title')?.value;
                    if (!title) {
                        Swal.showValidationMessage('Judul harus diisi');
                        return false;
                    }
                    return getFormData();
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    updateCalendarEvent(eventData.id, result.value);
                }
            });
        }

        // Build Form HTML
        function buildForm(event = {}) {
            const institutions = calendarData.institutions || [];
            const levels = calendarData.levels || [];
            const classRooms = calendarData.classRooms || [];

            return `
                <style>
                    .swal2-html-container { text-align: left; }
                    .form-group { margin-bottom: 12px; }
                    .form-group label { display: block; margin-bottom: 4px; font-weight: 500; font-size: 13px; }
                    .form-group input, .form-group select, .form-group textarea {
                        width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px; box-sizing: border-box;
                    }
                    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
                    .checkbox-group { display: flex; align-items: center; gap: 8px; }
                    .checkbox-group input { width: auto; }
                    hr { margin: 12px 0; }
                    .select2-container { z-index: 99999 !important; }
                    .select2-dropdown { z-index: 99999 !important; }
                    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                        border-right: none !important;;
                        top: -5px !important;
                    }
                    .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
                        font-size: 13px !important;
                        display: flex !important;
                    }
                </style>

                <div class="form-group">
                    <label>Judul Event *</label>
                    <input type="text" id="title" value="${event.title || ''}" placeholder="Masukkan judul">
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea id="description" placeholder="Masukkan deskripsi" style="min-height: 60px;">${event.description || ''}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Tipe Event</label>
                        <select id="type">
                            <option value="event" ${event.type === 'event' ? 'selected' : ''}>Event</option>
                            <option value="holiday" ${event.type === 'holiday' ? 'selected' : ''}>Hari Libur</option>
                            <option value="note" ${event.type === 'note' ? 'selected' : ''}>Catatan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Warna</label>
                        <input type="color" id="color" value="${event.color || '#3b82f6'}" style="height: 36px;">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Tanggal Mulai *</label>
                        <input type="date" id="start_date" value="${event.start_date || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Akhir</label>
                        <input type="date" id="end_date" value="${event.end_date || ''}">
                    </div>
                </div>

                <div class="form-group checkbox-group">
                    <input type="checkbox" id="is_holiday" ${event.is_holiday ? 'checked' : ''}>
                    <label for="is_holiday" style="margin-bottom: 0;">Tandai sebagai hari libur</label>
                </div>

                <hr>

                <h5 style="margin-bottom: 12px; font-size: 14px;">Scope Event (Opsional)</h5>

                <div class="form-group">
                    <label>Institusi Sekolah (Pilih Multiple)</label>
                    <select id="school_institution_id" multiple="multiple" style="width: 100%;">
                        ${institutions.map(i => `<option value="${i.id}">${i.name}</option>`).join('')}
                    </select>
                </div>

                <div class="form-group">
                    <label>Tingkat Sekolah (Pilih Multiple)</label>
                    <select id="school_level_id" multiple="multiple" style="width: 100%;">
                        ${levels.map(l => `<option value="${l.id}">${l.name}</option>`).join('')}
                    </select>
                </div>

                <div class="form-group">
                    <label>Kelas (Pilih Multiple)</label>
                    <select id="class_room_id" multiple="multiple" style="width: 100%;">
                        ${classRooms.map(c => `<option value="${c.id}">${c.name}</option>`).join('')}
                    </select>
                </div>
            `;
        }

        // Get Form Data
        function getFormData() {
            const getMultiSelectValues = (id) => {
                const select = document.getElementById(id);
                if (!select) return [];
                const values = Array.from(select.selectedOptions).map(o => o.value);
                return values.length > 0 ? values : null;
            };

            return {
                title: document.getElementById('title').value,
                description: document.getElementById('description').value,
                type: document.getElementById('type').value,
                start_date: document.getElementById('start_date').value,
                end_date: document.getElementById('end_date').value,
                is_holiday: document.getElementById('is_holiday').checked,
                color: document.getElementById('color').value,
                school_institution_ids: getMultiSelectValues('school_institution_id'),
                school_level_ids: getMultiSelectValues('school_level_id'),
                class_room_ids: getMultiSelectValues('class_room_id'),
            };
        }

        // Create Calendar Event
        function createCalendarEvent(data) {
            $.ajax({
                url: '/calendars',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': calendarData.csrfToken,
                },
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(result) {
                    Swal.fire('Sukses!', 'Event berhasil dibuat', 'success').then(() => {
                        $('#datatable').DataTable().ajax.reload(null, false);
                    });
                },
                error: function(err) {
                    console.error('Error:', err);
                    let errorMsg = 'Gagal membuat event';
                    if (err.responseText) {
                        errorMsg = err.responseText;
                    }
                    Swal.fire('Error!', errorMsg, 'error');
                }
            });
        }

        // Update Calendar Event
        function updateCalendarEvent(eventId, data) {
            $.ajax({
                url: `/calendars/${eventId}`,
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': calendarData.csrfToken,
                },
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(result) {
                    Swal.fire('Sukses!', 'Event berhasil diperbarui', 'success').then(() => {
                        $('#datatable').DataTable().ajax.reload(null, false);
                    });
                },
                error: function(err) {
                    console.error('Error:', err);
                    let errorMsg = 'Gagal mengupdate event';
                    if (err.responseText) {
                        errorMsg = err.responseText;
                    }
                    Swal.fire('Error!', errorMsg, 'error');
                }
            });
        }

        // Event listener untuk tombol add
        document.addEventListener('DOMContentLoaded', function() {
            const btnAdd = document.getElementById('btn-add-event');
            if (btnAdd) {
                btnAdd.addEventListener('click', openAddModal);
            }
        });
    </script>

@endpush
