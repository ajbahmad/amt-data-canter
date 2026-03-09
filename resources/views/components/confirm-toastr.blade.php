<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/css/sweetalert2.min.css') }}">
<script src="{{ asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
@if (session('success'))
    <script>
        Swal.fire({
            text: '{{ session('success') }}',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false,
            position: 'top-end',
            toast: true
        });
    </script>
@endif
@if (session('error'))
    <script>
        Swal.fire({
            text: "{{ session('error') }}",
            icon: 'error',
            timer: 3000,
            showConfirmButton: false,
            position: 'top-end',
            toast: true
        });
    </script>
@endif

<script>
    function editData(id, url) {
        Swal.fire({
            title: 'Edit Data',
            html: 'Apakah Anda yakin ingin mengedit data ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }

    function deleteData(id, deleteUrl) {
        Swal.fire({
            title: 'Hapus Data',
            html: 'Apakah Anda yakin ingin menghapus data ini? Data yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a form and submit it with DELETE method
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
        })
    }

    $(document).ready(function() {
        // intFilterSelect();
    });

    function intFilterSelect(){

        // filter select school_level_id berdasarkan school_institution_id
        if ($('select[name=school_level_id]').length) {
            $('select[name=school_institution_id]').change(function() {
                let school_institution_id = $(this).find(':selected').val();
                let url                   = '{{ route('school_levels.index') }}?school_institution_id=' + school_institution_id;
                let target                = $('select[name=school_level_id]');
                let label                 = 'Pilih Tingkat Sekolah';
                ajaxGet(url, target, label);
            })
        }

        // filter select teacher_id berdasarkan school_institution_id
        if ($('select[name=teacher_id]').length) {
            $('select[name=school_institution_id]').change(function() {
                let school_institution_id = $(this).find(':selected').val();
                let url                   = '{{ route('teachers.index') }}?school_institution_id=' + school_institution_id;
                let target                = $('select[name=teacher_id]');
                let label                 = 'Pilih Pengajar';
                ajaxGet(url, target, label, 'item.id', 'item.person.first_name + " " + item.person.last_name');
            })
        }

        // filter select start_time_slot_id berdasarkan school_level_id
        if ($('select[name=start_time_slot_id]').length) {
            $('select[name=school_level_id]').change(function(){
            let school_level_id = $(this).find(':selected').val();
            let url             = '{{ route('time_slots.index') }}?school_level_id=' + school_level_id;
            let target          = $('select[name=start_time_slot_id]');
            let label           = 'Pilih Jam Mulai';
                ajaxGet(url, target, label, 'item.id', 'item.name + " (" + item.start_time + " - " + item.end_time + ")"');
            })
        }

        // filter select end_time_slot_id berdasarkan school_level_id
        if ($('select[name=end_time_slot_id]').length) {
            $('select[name=school_level_id]').change(function(){
                let school_level_id = $(this).find(':selected').val();
                let url                 = '{{ route('time_slots.index') }}?school_level_id=' + school_level_id;
            let target              = $('select[name=end_time_slot_id]');
            let label               = 'Pilih Jam Selesai';
                ajaxGet(url, target, label, 'item.id', 'item.name + " (" + item.start_time + " - " + item.end_time + ")"');
            })
        }
        // filter select grade_id berdasarkan school_level_id
        if ($('select[name=grade_id]').length) {
            $('select[name=school_level_id]').change(function() {
                let school_level_id = $(this).find(':selected').val();
                let url             = '{{ route('grades.index') }}?school_level_id=' + school_level_id;
                let target          = $('select[name=grade_id]');
            let label           = 'Pilih Kelas';
                ajaxGet(url, target, label);
            })
        }
        // filter select semester_id berdasarkan school_level_id
        if ($('select[name=semester_id]').length) {
            $('select[name=school_level_id]').change(function() {
                let school_level_id = $(this).find(':selected').val();
                let url             = '{{ route('semesters.index') }}?school_level_id=' + school_level_id;
                let target          = $('select[name=semester_id]');
                let label           = 'Pilih Semester';
                ajaxGet(url, target, label);
            })
        }

        // filter select subject_id berdasarkan school_level_id
        if ($('select[name=subject_id]').length) {
            $('select[name=school_level_id]').change(function() {
                let school_level_id = $(this).find(':selected').val();
                let url             = '{{ route('subjects.index') }}?school_level_id=' + school_level_id;
                let target          = $('select[name=subject_id]');
                let label           = 'Pilih Mata Pelajaran';
                ajaxGet(url, target, label);
            })
        }

         // filter select class_room_id berdasarkan school_level_id
         if ($('select[name=class_room_id]').length) {
             $('select[name=school_level_id]').change(function() {
                 let school_level_id = $(this).find(':selected').val();
                 let url             = '{{ route('class_rooms.index') }}?school_level_id=' + school_level_id;
                 let target          = $('select[name=class_room_id]');
                 let label           = 'Pilih Kelas';
                 ajaxGet(url, target, label);
             })
         }


        $('[name=school_level_id]').change(function() {
            let school_level_id = $(this).val();

            if ($('.class_rooms').length || $('[name=class_room_id]').length) {
                $.ajax({
                    url: '{{ route('class_rooms.index') }}?school_level_id=' + school_level_id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        if (response.length > 0) {
                            if ($('.class_rooms').length) {
                                classRooms(response);
                            }
                            if ($('.schedule_patterns').length) {
                                schedulePatterns(school_level_id);
                            }
                        }
                    }
                })
            }
            
        })
    }

    function schedulePatterns(schoolLevelId) {
        $.ajax({
            url: '{{ route('schedule-patterns.index') }}?school_level_id=' + schoolLevelId,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                if (response.length > 0) {
                    $('.schedule_patterns').empty();
                    $('.schedule_patterns').append(new Option('-- Pilih Pola Jadwal --', ''));
                    $.each(response, function(index, item) {
                        $('.schedule_patterns').append(new Option(item.name, item.id));
                    });
                }
            }
        })
    }

    function classRooms(data) {
        $('.class_rooms').html('');
        $.each(data, function(index, items) {
            var html = `
            <tr>
                <td class="border p-1 text-center"> ${index + 1} </td>
                <td class="border p-1"> ${items.name} </td>
                <td class="border p-1">
                    <select class="form-select p-0 px-3 w-full schedule_patterns" name="schedule_pattern[${items.id}]">
                        <option value="">Pilih Pola Jadwal</option>
                    </select>
                </td>
            </tr>
            `;
            $('.class_rooms').append(html);
        })

    }
</script>
@include('components.filter-select-datatable')    