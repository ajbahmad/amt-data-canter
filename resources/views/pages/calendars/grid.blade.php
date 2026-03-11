@extends('layouts.admin')

@section('title', 'Kalender Sekolah')

@section('content')

    @include('layouts.partials.admin.breadcrumb', [
        'title' => 'Kalender Sekolah',
        'breadcrumbs' => [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Referensi', 'url' => '#'],
            ['name' => 'Kalender Sekolah', 'url' => '#'],
        ],
    ])

    <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                <i class="ti ti-calendar-event mr-2"></i>Kalender Sekolah
            </h2>
            <a href="{{ route('calendars.index') }}" class="inline-flex ms-auto me-2 items-center rounded-lg bg-success px-4 py-2 text-white hover:bg-success-700 transition">
                <i class="ti ti-table mr-2"></i> Lihat table
            </a>
            <button type="button" id="btn-add-event"
                class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">
                <i class="ti ti-plus mr-2"></i>Tambah Catatan
            </button>
        </div>

        <!-- Calendar Container -->
        <div id="calendar"
            style="background: white; border: 1px solid #ddd; border-radius: 8px; padding: 20px; min-height: 600px;"></div>
    </div>

    <!-- Data untuk JavaScript -->
    <script>
        window.calendarData = {
            institutions: @json($institutions ?? []),
            levels: @json($levels ?? []),
            classRooms: @json($classRooms ?? []),
            eventsUrl: "{{ route('calendars.events') }}",
            storeUrl: "{{ route('calendars.store') }}",
            updateUrl: "{{ route('calendars.update', ':id') }}",
            deleteUrl: "{{ route('calendars.destroy', ':id') }}",
            csrfToken: "{{ csrf_token() }}",
        };
    </script>

@endsection
@push('styles')
    <style>
        .fc-day {cursor: pointer;}
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/fullcalendar/index.global.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        let calendar = null;

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                initCalendar();
            }, 100);
        });

        function initCalendar() {
            var calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: loadEvents,
                eventClick: function(info) {
                    openEditModal(info.event);
                },
                dateClick: function(info) {
                    openCreateModal(info.date);
                }
            });

            calendar.render();
        }

        // Load events dari server
        function loadEvents(info, successCallback, failureCallback) {
            const startDate = info.start.toISOString().split('T')[0];
            const endDate = info.end.toISOString().split('T')[0];

            fetch(`${window.calendarData.eventsUrl}?start=${startDate}&end=${endDate}`)
                .then(response => response.json())
                .then(data => {
                    successCallback(data);
                })
                .catch(error => {
                    failureCallback(error);
                });
        }

        // Buka modal tambah event
        function openCreateModal(date) {
            const dateStr = date.toISOString().split('T')[0];

            Swal.fire({
                html: '<div class="text-fs_28 font-bold mb-4">Tambah Catatan</div>' + buildForm({
                    start_date: dateStr
                }),
                width: '600px',
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3b82f6',
                didOpen: () => {
                    // Init Select2 untuk multi-select
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
                    createEvent(result.value);
                }
            });
        }

        // Buka modal edit event
        function openEditModal(event) {
            const eventData = {
                title: event.title,
                start_date: event.start.toISOString().split('T')[0],
                end_date: event.end ? new Date(event.end.getTime() - 86400000).toISOString().split('T')[0] : '',
                color: event.backgroundColor,
                ...event.extendedProps
            };

            Swal.fire({
                html: '<div class="text-fs_28 font-bold mb-4">Edit Catatan</div>' + buildForm(eventData),
                width: '600px',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'Simpan',
                denyButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3b82f6',
                denyButtonColor: '#ef4444',
                didOpen: () => {
                    // Init Select2 untuk multi-select
                    setTimeout(() => {
                        $('#school_institution_id, #school_level_id, #class_room_id').select2({
                            width: '100%',
                            allowClear: true,
                            placeholder: 'Pilih...'
                        });

                        // Set selected values jika ada
                        if (eventData.school_institution_ids) {
                            $('#school_institution_id').val(eventData.school_institution_ids).trigger(
                                'change');
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
                    updateEvent(event.id, result.value);
                } else if (result.isDenied) {
                    confirmDelete(event.id);
                }
            });
        }

        // Build form HTML
        function buildForm(event = {}) {
            const institutions = window.calendarData.institutions || [];
            const levels = window.calendarData.levels || [];
            const classRooms = window.calendarData.classRooms || [];

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
            <label>Lembaga (Pilih Multiple)</label>
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

        // Get form data
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

        // Create event
        function createEvent(data) {
            fetch(window.calendarData.storeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.calendarData.csrfToken,
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(text || 'Gagal membuat event');
                        });
                    }
                    return response.json();
                })
                .then(result => {
                    Swal.fire('Sukses!', 'Event berhasil dibuat', 'success').then(() => {
                        calendar.refetchEvents();
                    });
                })
                .catch(error => {
                    Swal.fire('Error!', error.message, 'error');
                });
        }

        // Update event
        function updateEvent(eventId, data) {
            const url = window.calendarData.updateUrl.replace(':id', eventId);

            fetch(url, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.calendarData.csrfToken,
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(text || 'Gagal mengupdate event');
                        });
                    }
                    return response.json();
                })
                .then(result => {
                    Swal.fire('Sukses!', 'Event berhasil diperbarui', 'success').then(() => {
                        calendar.refetchEvents();
                    });
                })
                .catch(error => {
                    Swal.fire('Error!', error.message, 'error');
                });
        }

        // Confirm delete
        function confirmDelete(eventId) {
            Swal.fire({
                title: 'Hapus Event?',
                text: 'Apakah Anda yakin ingin menghapus event ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Hapus',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteEvent(eventId);
                }
            });
        }

        // Delete event
        function deleteEvent(eventId) {
            const url = window.calendarData.deleteUrl.replace(':id', eventId);

            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': window.calendarData.csrfToken,
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Gagal menghapus event');
                    return response.json();
                })
                .then(result => {
                    Swal.fire('Sukses!', 'Event berhasil dihapus', 'success').then(() => {
                        calendar.refetchEvents();
                    });
                })
                .catch(error => {
                    Swal.fire('Error!', error.message, 'error');
                });
        }

        // Tombol tambah event
        document.addEventListener('DOMContentLoaded', function() {
            const btnAdd = document.getElementById('btn-add-event');
            if (btnAdd) {
                btnAdd.addEventListener('click', () => {
                    openCreateModal(new Date());
                });
            }
        });
    </script>
@endpush
