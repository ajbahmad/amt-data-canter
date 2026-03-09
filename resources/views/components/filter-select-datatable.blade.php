<script>
    $(document).ready(function() {
        $('#datatable').on('init.dt', function () {
            setTimeout(() => {
                initFilterSelectDataTable();
            }, 500);
        });
    })

    function initFilterSelectDataTable() {
            // get school_levels by school_institution_id
        if ($('select[data-name=school_level_id]').length) {
            $('[data-name=school_institution_id]').change(function() {
                let school_institution_id = $(this).find(':selected').val();
                let url                   = '{{ route('school_levels.index') }}?school_institution_id=' + school_institution_id;
                let target                = $('select[data-name=school_level_id]');
                let label                 = 'Filter Sekolah';
                ajaxGet(url, target, label);
            })
        }

        // get teachers by school_institution_id
        if ($('select[data-name=teacher_id]').length) {
            $('[data-name=school_institution_id]').change(function(){
                let school_institution_id  = $(this).find(':selected').val();
                let url                    = '{{ route('teachers.index') }}?school_institution_id=' + school_institution_id;
                let target                 = $('select[data-name=teacher_id]');
                let label                  = 'Filter Guru';
                ajaxGet(url, target, label, 'item.id', 'item.person.first_name + " " + item.person.last_name');
            })
        }

        // get class_rooms by school_level_id
        if ($('select[data-name=class_room_id]').length) {
            $('[data-name=school_level_id]').change(function(){
                let school_level_id = $(this).find(':selected').val();
                let url             = '{{ route('class_rooms.index') }}?school_level_id=' + school_level_id;
                let target          = $('select[data-name=class_room_id]');
                let label           = 'Filter Kelas';
                ajaxGet(url, target, label);
            })
        }


        // get subjects by school_level_id
        if ($('select[data-name=subject_id]').length) {
            $('[data-name=school_level_id]').change(function(){
                let school_level_id = $(this).find(':selected').val();
                let url             = '{{ route('subjects.index') }}?school_level_id=' + school_level_id;
                let target          = $('select[data-name=subject_id]');
                let label           = 'Filter Mata Pelajaran';
                ajaxGet(url, target, label);
            })
        }

        // get school_years by school_level_id
        if ($('select[data-name=school_year_id]').length) {
            $('[data-name=school_level_id]').change(function(){
                let school_level_id = $(this).find(':selected').val();
                let url             = '{{ route('school_years.index') }}?school_level_id=' + school_level_id;
                let target          = $('select[data-name=school_year_id]');
                let label           = 'Filter Tahun Ajaran';
                ajaxGet(url, target, label);
            })
        }

        // get semesters by school_level_id
        if ($('select[data-name=semester_id]').length) {
            $('[data-name=school_level_id]').change(function(){
                let school_level_id = $(this).find(':selected').val();
                let url             = '{{ route('semesters.index') }}?school_level_id=' + school_level_id;
                let target          = $('select[data-name=semester_id]');
                let label           = 'Filter Semester';
                ajaxGet(url, target, label);
            })
        }


        // get grades by school_level_id
        if ($('select[data-name=grade_id]').length) {
            $('[data-name=school_level_id]').change(function(){
                let school_level_id = $(this).find(':selected').val();
                let url             = '{{ route('grades.index') }}?school_level_id=' + school_level_id;
                let target          = $('select[data-name=grade_id]');
                let label           = 'Filter Kelas';
                ajaxGet(url, target, label);
            })
        }


        // get schedule_patterns by school_level_id
        if ($('select[data-name=schedule_pattern_id]').length) {
            $('[data-name=school_level_id]').change(function(){
                let school_level_id = $(this).find(':selected').val();
                let url             = '{{ route('schedule-patterns.index') }}?school_level_id=' + school_level_id;
                let target          = $('select[data-name=schedule_pattern_id]');
                let label           = 'Filter Pola Jadwal';
                ajaxGet(url, target, label);
            })
        }

    }

    function targetAction(attrTarget, label, data, idField, nameField){
        $(attrTarget).empty();
        $(attrTarget).append(new Option(label, ''));
        $.each(data, function(index, item) {
            $(attrTarget).append(new Option(eval(nameField), eval(idField)));
        });
    }

    function ajaxGet(url, target, label, idField='item.id', nameField='item.name') {
        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                targetAction(target, label, response, idField, nameField);
            }, 
            error: function(xhr, status, error) {
                return [];
            }
        });
    }
</script>
