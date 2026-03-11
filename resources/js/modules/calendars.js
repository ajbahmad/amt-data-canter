/**
 * Calendar Module
 * Handles FullCalendar integration with CRUD operations
 */

const calendarModule = (() => {
    let calendar = null;
    let currentDate = null;

    /**
     * Initialize calendar
     */
    const init = () => {
        initCalendar();
        attachEventListeners();
    };

    /**
     * Initialize FullCalendar
     */
    const initCalendar = () => {
        const calendarEl = document.getElementById('calendar');
        
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today addEventButton',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay',
            },
            customButtons: {
                addEventButton: {
                    text: 'Tambah Event',
                    click: () => openCreateModal(),
                }
            },
            events: loadEvents,
            eventClick: handleEventClick,
            dateClick: handleDateClick,
            eventDidMount: eventDidMount,
            themeSystem: 'bootstrap5',
        });

        calendar.render();
    };

    /**
     * Load events from server
     */
    const loadEvents = async (info, successCallback, failureCallback) => {
        try {
            const response = await fetch(
                `${window.calendarData.eventsUrl}?start=${info.start.toISOString().split('T')[0]}&end=${info.end.toISOString().split('T')[0]}`,
                {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                }
            );

            if (!response.ok) throw new Error('Failed to load events');
            
            const events = await response.json();
            successCallback(events);
        } catch (error) {
            console.error('Error loading events:', error);
            failureCallback(error);
        }
    };

    /**
     * Handle event click
     */
    const handleEventClick = (info) => {
        const event = info.event;
        openEditModal(event);
    };

    /**
     * Handle date click
     */
    const handleDateClick = (info) => {
        currentDate = info.date;
        openCreateModal();
    };

    /**
     * Event did mount - styling
     */
    const eventDidMount = (info) => {
        if (info.event.extendedProps.is_holiday) {
            info.el.classList.add('holiday-event');
            info.el.style.fontWeight = 'bold';
        }
    };

    /**
     * Attach event listeners
     */
    const attachEventListeners = () => {
        const btnAddEvent = document.getElementById('btn-add-event');
        if (btnAddEvent) {
            btnAddEvent.addEventListener('click', openCreateModal);
        }
    };

    /**
     * Open create event modal
     */
    const openCreateModal = async () => {
        const html = await buildEventForm();
        
        Swal.fire({
            title: 'Tambah Event',
            html: html,
            width: '600px',
            didOpen: (modal) => {
                attachFormListeners(modal);
                setupDateInputs(modal);
                setupTypeChangeListener(modal);
            },
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3788d8',
            preConfirm: () => {
                const formData = getFormData();
                if (!formData.title) {
                    Swal.showValidationMessage('Judul harus diisi');
                    return false;
                }
                return formData;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                createEvent(result.value);
            }
        });
    };

    /**
     * Open edit event modal
     */
    const openEditModal = async (event) => {
        const html = await buildEventForm(event);
        
        Swal.fire({
            title: 'Edit Event',
            html: html,
            width: '600px',
            didOpen: (modal) => {
                attachFormListeners(modal);
                setupDateInputs(modal, event);
                setupTypeChangeListener(modal);
            },
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Simpan',
            denyButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3788d8',
            denyButtonColor: '#dc3545',
            preConfirm: () => {
                const formData = getFormData();
                if (!formData.title) {
                    Swal.showValidationMessage('Judul harus diisi');
                    return false;
                }
                return formData;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                updateEvent(event.id, result.value);
            } else if (result.isDenied) {
                confirmDeleteEvent(event.id);
            }
        });
    };

    /**
     * Build event form HTML
     */
    const buildEventForm = async (event = null) => {
        const typeOptions = `
            <option value="event" ${event?.extendedProps?.type === 'event' ? 'selected' : ''}>Event</option>
            <option value="holiday" ${event?.extendedProps?.type === 'holiday' ? 'selected' : ''}>Hari Libur</option>
            <option value="note" ${event?.extendedProps?.type === 'note' ? 'selected' : ''}>Catatan</option>
        `;

        const institutionOptions = window.calendarData.institutions
            .map(inst => `<option value="${inst.id}" ${event?.extendedProps?.institution_id === inst.id ? 'selected' : ''}>${inst.name}</option>`)
            .join('');

        const levelOptions = window.calendarData.levels
            .map(level => `<option value="${level.id}" ${event?.extendedProps?.level_id === level.id ? 'selected' : ''}>${level.name}</option>`)
            .join('');

        const classRoomOptions = window.calendarData.classRooms
            .map(room => `<option value="${room.id}" ${event?.extendedProps?.class_room_id === room.id ? 'selected' : ''}>${room.name}</option>`)
            .join('');

        const startDate = event 
            ? event.start.toISOString().split('T')[0]
            : (currentDate ? new Date(currentDate).toISOString().split('T')[0] : '');

        const endDate = event 
            ? (event.end ? new Date(event.end.getTime() - 86400000).toISOString().split('T')[0] : '')
            : '';

        return `
            <style>
                .swal2-html-container {
                    text-align: left;
                    max-height: 70vh;
                    overflow-y: auto;
                }
                .form-group {
                    margin-bottom: 1rem;
                }
                .form-group label {
                    display: block;
                    margin-bottom: 0.5rem;
                    font-weight: 500;
                    color: #374151;
                }
                .form-group input,
                .form-group select,
                .form-group textarea {
                    width: 100%;
                    padding: 0.5rem;
                    border: 1px solid #d1d5db;
                    border-radius: 0.375rem;
                    font-size: 0.875rem;
                }
                .form-group textarea {
                    resize: vertical;
                    min-height: 80px;
                }
                .form-row {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 1rem;
                }
                .checkbox-group {
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                }
                .checkbox-group input {
                    width: auto;
                }
            </style>

            <div class="form-group">
                <label for="title">Judul Event *</label>
                <input type="text" id="title" class="form-control" value="${event?.title || ''}" placeholder="Masukkan judul event">
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea id="description" class="form-control" placeholder="Masukkan deskripsi">${event?.extendedProps?.description || ''}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="type">Tipe Event *</label>
                    <select id="type" class="form-control">
                        ${typeOptions}
                    </select>
                </div>

                <div class="form-group">
                    <label for="color">Warna</label>
                    <input type="color" id="color" class="form-control" value="${event?.backgroundColor || '#3788d8'}" style="height: 38px;">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="start_date">Tanggal Mulai *</label>
                    <input type="date" id="start_date" class="form-control" value="${startDate}" required>
                </div>

                <div class="form-group">
                    <label for="end_date">Tanggal Akhir</label>
                    <input type="date" id="end_date" class="form-control" value="${endDate}">
                </div>
            </div>

            <div class="form-group checkbox-group">
                <input type="checkbox" id="is_holiday" ${event?.extendedProps?.is_holiday ? 'checked' : ''}>
                <label for="is_holiday" style="margin-bottom: 0;">Tandai sebagai hari libur</label>
            </div>

            <hr style="margin: 1rem 0;">

            <h5 style="margin-bottom: 1rem; font-weight: 600;">Scope Event (Opsional)</h5>

            <div class="form-group">
                <label for="school_institution_id">Lembaga</label>
                <select id="school_institution_id" class="form-control">
                    <option value="">-- Semua Institusi --</option>
                    ${institutionOptions}
                </select>
            </div>

            <div class="form-group">
                <label for="school_level_id">Tingkat Sekolah</label>
                <select id="school_level_id" class="form-control">
                    <option value="">-- Semua Tingkat --</option>
                    ${levelOptions}
                </select>
            </div>

            <div class="form-group">
                <label for="class_room_id">Kelas</label>
                <select id="class_room_id" class="form-control">
                    <option value="">-- Semua Kelas --</option>
                    ${classRoomOptions}
                </select>
            </div>
        `;
    };

    /**
     * Get form data
     */
    const getFormData = () => {
        return {
            title: document.getElementById('title').value,
            description: document.getElementById('description').value,
            type: document.getElementById('type').value,
            start_date: document.getElementById('start_date').value,
            end_date: document.getElementById('end_date').value,
            is_holiday: document.getElementById('is_holiday').checked,
            color: document.getElementById('color').value,
            school_institution_id: document.getElementById('school_institution_id').value || null,
            school_level_id: document.getElementById('school_level_id').value || null,
            class_room_id: document.getElementById('class_room_id').value || null,
        };
    };

    /**
     * Setup date inputs
     */
    const setupDateInputs = (modal, event = null) => {
        // Add date validation logic if needed
    };

    /**
     * Setup type change listener
     */
    const setupTypeChangeListener = (modal) => {
        const typeSelect = document.getElementById('type');
        const isHolidayCheckbox = document.getElementById('is_holiday');

        typeSelect.addEventListener('change', (e) => {
            if (e.target.value === 'holiday') {
                isHolidayCheckbox.checked = true;
            }
        });
    };

    /**
     * Attach form listeners
     */
    const attachFormListeners = (modal) => {
        // Add any additional form event listeners here
    };

    /**
     * Create event
     */
    const createEvent = async (data) => {
        try {
            const response = await fetch(window.calendarData.storeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.calendarData.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Failed to create event');
            }

            Swal.fire('Sukses!', 'Event berhasil dibuat', 'success').then(() => {
                calendar.refetchEvents();
            });
        } catch (error) {
            Swal.fire('Error!', error.message, 'error');
        }
    };

    /**
     * Update event
     */
    const updateEvent = async (eventId, data) => {
        try {
            const url = window.calendarData.updateUrl.replace(':id', eventId);
            const response = await fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.calendarData.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Failed to update event');
            }

            Swal.fire('Sukses!', 'Event berhasil diperbarui', 'success').then(() => {
                calendar.refetchEvents();
            });
        } catch (error) {
            Swal.fire('Error!', error.message, 'error');
        }
    };

    /**
     * Confirm delete event
     */
    const confirmDeleteEvent = () => {
        Swal.fire({
            title: 'Hapus Event?',
            text: 'Apakah Anda yakin ingin menghapus event ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Get the event ID from the current context
                const currentEvent = calendar.getEvents().find(e => e.title === document.getElementById('title').value);
                if (currentEvent) {
                    deleteEvent(currentEvent.id);
                }
            }
        });
    };

    /**
     * Delete event
     */
    const deleteEvent = async (eventId) => {
        try {
            const url = window.calendarData.deleteUrl.replace(':id', eventId);
            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': window.calendarData.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                }
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Failed to delete event');
            }

            Swal.fire('Sukses!', 'Event berhasil dihapus', 'success').then(() => {
                calendar.refetchEvents();
            });
        } catch (error) {
            Swal.fire('Error!', error.message, 'error');
        }
    };

    return {
        init,
        loadEvents,
        createEvent,
        updateEvent,
        deleteEvent,
    };
})();

// Export for use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = calendarModule;
}
