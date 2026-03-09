<!-- SweetAlert2 Modal for Add Schedule -->
<script>
    const daysOfWeek = {
        1: 'Senin',
        2: 'Selasa',
        3: 'Rabu',
        4: 'Kamis',
        5: 'Jumat',
        6: 'Sabtu',
        7: 'Minggu'
    };

    function addSchedule(dayOfWeek) {
        const dayName = daysOfWeek[dayOfWeek] || 'Hari Tidak Diketahui';
        Swal.fire({
            html: `
                <h1 class="text-2xl text-start mb-5 text-success"> <i class="ti ti-calendar"></i> Tambah Jadwal Hari ` + dayName + `</h1>
                <div style="text-align: left;" class="grid grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="form-label text-sm">Lembaga <span class="text-red-700">*</span></label>
                        <select class="form-control form-control-sm" name="school_institution_id" id="swal_school_institution_id" required>
                            <option value="">-- Pilih Lembaga --</option>
                            @foreach ($schoolInstitutions as $institution)
                                <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-red-700 text-sm" id="err_school_institution_id"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label text-sm">Tingkat Sekolah <span class="text-red-700">*</span></label>
                        <select class="form-control form-control-sm" name="school_level_id" id="swal_school_level_id" required>
                            <option value="">-- Pilih Tingkat Sekolah --</option>
                            @foreach ($schoolLevels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-red-700 text-sm" id="err_school_level_id"></small>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-sm">Kelas <span class="text-red-700">*</span></label>
                        <select class="form-control form-control-sm" name="class_room_id" id="swal_class_room_id" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-red-700 text-sm" id="err_class_room_id"></small>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-sm">Semester <span class="text-red-700">*</span></label>
                        <select class="form-control form-control-sm" name="semester_id" id="swal_semester_id" required>
                            <option value="">-- Pilih Semester --</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-red-700 text-sm" id="err_semester_id"></small>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-sm">Mata Pelajaran <span class="text-red-700">*</span></label>
                        <select class="form-control form-control-sm" name="subject_id" id="swal_subject_id" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->code }} - {{ $subject->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-red-700 text-sm" id="err_subject_id"></small>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-sm">Pengajar <span class="text-red-700">*</span></label>
                        <select class="form-control form-control-sm" name="teacher_id" id="swal_teacher_id" required>
                            <option value="">-- Pilih Pengajar --</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->person?->full_name }}</option>
                            @endforeach
                        </select>
                        <small class="text-red-700 text-sm" id="err_teacher_id"></small>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-sm">Jam Mulai <span class="text-red-700">*</span></label>
                        <select class="form-control form-control-sm" name="start_time_slot_id" id="swal_start_time_slot_id" required>
                            <option value="">-- Pilih Jam Mulai --</option>
                            @foreach ($sessionTimes as $time)
                                <option value="{{ $time->id }}">{{ $time->name }} ({{ \Carbon\Carbon::parse($time->start_time)->format('H:i') }})</option>
                            @endforeach
                        </select>
                        <small class="text-red-700 text-sm" id="err_start_time_slot_id"></small>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-sm">Jam Selesai <span class="text-red-700">*</span></label>
                        <select class="form-control form-control-sm" name="end_time_slot_id" id="swal_end_time_slot_id" required>
                            <option value="">-- Pilih Jam Selesai --</option>
                            @foreach ($sessionTimes as $time)
                                <option value="{{ $time->id }}">{{ $time->name }} ({{ \Carbon\Carbon::parse($time->end_time)->format('H:i') }})</option>
                            @endforeach
                        </select>
                        <small class="text-red-700 text-sm" id="err_end_time_slot_id"></small>
                    </div>
                </div>
            `,
            // icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            allowOutsideClick: () => !Swal.isLoading(),
            showLoaderOnConfirm: true,

            didOpen: (modal) => {
                modal.querySelectorAll('select, input').forEach(el => {
                    if (!el.classList.contains('form-control')) {
                        el.classList.add('form-control');
                    }
                });
            },

            preConfirm: async () => {

                // reset error
                document.querySelectorAll('[id^="err_"]').forEach(el => el.innerHTML = '');

                try {

                    const response = await submitAddSchedule(dayOfWeek);

                    if (!response.success) {

                        // tampilkan error dari backend
                        if (response.errors) {
                            Object.keys(response.errors).forEach(field => {
                                const errEl = document.getElementById('err_' + field);
                                if (errEl) {
                                    errEl.innerHTML = response.errors[field][0];
                                }
                            });
                        }

                        // jangan tutup modal
                        return false;
                    }

                    return response;

                } catch (error) {

                    return false;

                }
            }

        }).then((result) => {

            if (result.isConfirmed && result.value.success) {

                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: "Jadwal berhasil disimpan"
                });

            }

        });
        intFilterSelect();

    }

    function submitAddSchedule(dayOfWeek) {
        // Clear previous errors
        document.querySelectorAll('[id^="err_"]').forEach(el => el.textContent = '');

        const formData = {
            day_of_week: dayOfWeek,
            class_room_id: document.getElementById('swal_class_room_id').value,
            subject_id: document.getElementById('swal_subject_id').value,
            teacher_id: document.getElementById('swal_teacher_id').value,
            start_time_slot_id: document.getElementById('swal_start_time_slot_id').value,
            end_time_slot_id: document.getElementById('swal_end_time_slot_id').value,
            semester_id: document.getElementById('swal_semester_id').value,
            school_level_id: document.getElementById('swal_school_level_id').value,
            school_institution_id: document.getElementById('swal_school_institution_id').value
        };

        $.ajax({
            type: 'POST',
            url: '{{ route('class_schedules.store') }}',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Jadwal kelas berhasil ditambahkan',
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
                        const errorEl = document.getElementById('err_' + field);
                        if (errorEl) {
                            errorEl.textContent = errors[field][0];
                        }
                    }

                } 
            }
        });
    }
</script>
