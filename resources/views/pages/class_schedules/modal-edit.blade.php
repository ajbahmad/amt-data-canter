<!-- SweetAlert2 Modal for Edit Schedule -->
<script>
    function editSchedule(id) {
        // Fetch schedule data
        $.ajax({
            type: 'GET',
            url: '{{ route("class_schedules.show", ":id") }}'.replace(':id', id),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                const schedule = response.data;
                
                const daysOfWeek = {
                    1: 'Senin',
                    2: 'Selasa',
                    3: 'Rabu',
                    4: 'Kamis',
                    5: 'Jumat',
                    6: 'Sabtu',
                    7: 'Minggu'
                };

                Swal.fire({
                    html: `
                        <h1 class="text-2xl text-start mb-5 text-warning"> <i class="ti ti-calendar"></i> Edit Jadwal Hari ` + daysOfWeek[schedule.day_of_week] + `</h1>

                        <div style="text-align: left;" class="grid grid-cols-2 gap-6">
                            <input type="hidden" id="edit_day_of_week" value="${schedule.day_of_week}">

                            <div class="form-group">
                                <label class="form-label text-sm">Lembaga <span class="text-red-700">*</span></label>
                                <select class="form-control form-control-sm" id="edit_school_institution_id" required>
                                    @foreach ($schoolInstitutions as $institution)
                                        <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-red-700 text-sm" id="err_school_institution_id"></small>
                            </div>
                            <div class="form-group">
                                <label class="form-label text-sm">Tingkat Sekolah <span class="text-red-700">*</span></label>
                                <select class="form-control form-control-sm" id="edit_school_level_id" required>
                                    @foreach ($schoolLevels as $level)
                                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-red-700 text-sm" id="err_school_level_id"></small>
                            </div>
                            

                            <div class="form-group">
                                <label class="form-label text-sm">Kelas <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_class_room_id" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-red-700 text-sm" id="err_edit_class_room_id"></small>
                            </div>

                            <div class="form-group">
                                <label class="form-label text-sm">Semester <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_semester_id" required>
                                    <option value="">-- Pilih Semester --</option>
                                    @foreach ($semesters as $semester)
                                        <option value="{{ $semester->id }}">{{ $semester->name }} ({{ $semester->school_year?->name }})</option>
                                    @endforeach
                                </select>
                                <small class="text-red-700 text-sm" id="err_edit_semester_id"></small>
                            </div>

                            <div class="form-group">
                                <label class="form-label text-sm">Mata Pelajaran <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_subject_id" required>
                                    <option value="">-- Pilih Mapel --</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->code }} - {{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-red-700 text-sm" id="err_edit_subject_id"></small>
                            </div>

                            <div class="form-group">
                                <label class="form-label text-sm">Pengajar <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_teacher_id" required>
                                    <option value="">-- Pilih Pengajar --</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->person?->full_name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-red-700 text-sm" id="err_edit_teacher_id"></small>
                            </div>

                            <div class="form-group">
                                <label class="form-label text-sm">Jam Mulai <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_start_time_slot_id" required>
                                    <option value="">-- Pilih Jam Mulai --</option>
                                    @foreach ($sessionTimes as $time)
                                        <option value="{{ $time->id }}">{{ $time->name }} ({{ \Carbon\Carbon::parse($time->start_time)->format('H:i') }})</option>
                                    @endforeach
                                </select>
                                <small class="text-red-700 text-sm" id="err_edit_start_time_slot_id"></small>
                            </div>

                            <div class="form-group">
                                <label class="form-label text-sm">Jam Selesai <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_end_time_slot_id" required>
                                    <option value="">-- Pilih Jam Selesai --</option>
                                    @foreach ($sessionTimes as $time)
                                        <option value="{{ $time->id }}">{{ $time->name }} ({{ \Carbon\Carbon::parse($time->end_time)->format('H:i') }})</option>
                                    @endforeach
                                </select>
                                <small class="text-red-700 text-sm" id="err_edit_end_time_slot_id"></small>
                            </div>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Update',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                    didOpen: (modal) => {
                        // Set values
                        document.getElementById('edit_class_room_id').value = schedule.class_room_id;
                        document.getElementById('edit_subject_id').value = schedule.subject_id;
                        document.getElementById('edit_teacher_id').value = schedule.teacher_id;
                        document.getElementById('edit_start_time_slot_id').value = schedule.start_time_slot_id;
                        document.getElementById('edit_end_time_slot_id').value = schedule.end_time_slot_id;
                        document.getElementById('edit_semester_id').value = schedule.semester_id;
                        document.getElementById('edit_school_institution_id').value = schedule.school_institution_id;
                        document.getElementById('edit_school_level_id').value = schedule.school_level_id;

                        // Add Bootstrap styles
                        modal.querySelectorAll('select, input').forEach(el => {
                            if (!el.classList.contains('form-control')) {
                                el.classList.add('form-control');
                            }
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitEditSchedule(id);
                    }
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Gagal mengambil data jadwal'
                });
            }
        });
    }

    function submitEditSchedule(id) {
        // Clear previous errors
        document.querySelectorAll('[id^="err_edit_"]').forEach(el => el.textContent = '');

        const formData = {
            day_of_week: document.getElementById('edit_day_of_week').value,
            class_room_id: document.getElementById('edit_class_room_id').value,
            subject_id: document.getElementById('edit_subject_id').value,
            teacher_id: document.getElementById('edit_teacher_id').value,
            start_time_slot_id: document.getElementById('edit_start_time_slot_id').value,
            end_time_slot_id: document.getElementById('edit_end_time_slot_id').value,
            semester_id: document.getElementById('edit_semester_id').value,
            school_institution_id: document.getElementById('edit_school_institution_id').value,
            school_level_id: document.getElementById('edit_school_level_id').value,
        };

        $.ajax({
            type: 'PUT',
            url: '{{ route("class_schedules.update", ":id") }}'.replace(':id', id),
            data: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Jadwal kelas berhasil diperbarui',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    for (const field in errors) {
                        const errorEl = document.getElementById('err_edit_' + field);
                        if (errorEl) {
                            errorEl.textContent = errors[field][0];
                        }
                    }
                    
                } 
            }
        });
    }
</script>
