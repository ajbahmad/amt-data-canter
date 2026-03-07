<!-- BEGIN: Modal Add -->
<button data-tw-toggle="modal" class="hidden btn-modal-add" data-tw-target="#add-confirmation-modal"></button>
<div id="add-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="intro-y box">
                <div id="input" class="p-5">
                    <div class="flex flex-col sm:flex-row items-center pb-5">
                        <h2 class="font-medium text-lg mr-auto">
                            Tambah {{ $title }}
                        </h2>
                    </div>
                    <form action="{{ route($route.'.store') }}" id="form-add" enctype="multipart/form-data" method="post">
                        @csrf

                        <div class="grid grid-cols-12 gap-x-6 mt-5">

                            <div class="intro-y col-span-12 lg:col-span-6">
                                <div>
                                    <label for="input-add-day_of_week" class="form-label">Hari <span class="text-danger">*</span></label>
                                    <select id="input-add-day_of_week" name="day_of_week" class="form-control" required>
                                        <option value="">Pilih Hari</option>
                                        <option value="0">Senin</option>
                                        <option value="1">Selasa</option>
                                        <option value="2">Rabu</option>
                                        <option value="3">Kamis</option>
                                        <option value="4">Jumat</option>
                                        <option value="5">Sabtu</option>
                                        <option value="6">Minggu</option>
                                    </select>
                                    <div class="form-help text-danger err err-day_of_week"></div>
                                </div>
                            </div>

                            <div class="intro-y col-span-12 lg:col-span-6">
                                <div>
                                    <label for="input-add-class_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                                    <select id="input-add-class_id" name="class_id" class="form-control" required>
                                        <option value="">Pilih Kelas</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>   
                                    <div class="form-help text-danger err err-class_id"></div>
                                </div>
                            </div>

                            <div class="intro-y col-span-12 lg:col-span-6">
                                <div>
                                    <label for="input-add-start_session_time_id" class="form-label">Jam Mulai Pelajaran <span class="text-danger">*</span></label>
                                    <select id="input-add-start_session_time_id" name="start_session_time_id" class="form-control" required>
                                        <option value="">Pilih Jam Mulai Pelajaran</option>
                                        @foreach($sessionTimes as $sessionTime)
                                            <option value="{{ $sessionTime->id }}">{{ $sessionTime->time_period }} ({{ $sessionTime->start_time }} - {{ $sessionTime->end_time }})</option>
                                        @endforeach
                                    </select>
                                    <div class="form-help text-danger err err-start_session_time_id"></div>
                                </div>
                            </div>

                            <div class="intro-y col-span-12 lg:col-span-6">
                                <div>
                                    <label for="input-add-end_session_time_id" class="form-label">Jam Selesai Pelajaran <span class="text-danger">*</span></label>
                                    <select id="input-add-end_session_time_id" name="end_session_time_id" class="form-control" required>
                                        <option value="">Pilih Jam Selesai Pelajaran</option>
                                        @foreach($sessionTimes as $sessionTime)
                                            <option value="{{ $sessionTime->id }}">{{ $sessionTime->time_period }} ({{ $sessionTime->start_time }} - {{ $sessionTime->end_time }})</option>
                                        @endforeach
                                    </select>
                                    <div class="form-help text-danger err err-end_session_time_id"></div>
                                </div>
                            </div>

                            

                            <div class="intro-y col-span-12 lg:col-span-6">
                                <div>
                                    <label for="input-add-subject_id" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                                    <select id="input-add-subject_id" name="subject_id" class="form-control" required>
                                        <option value="">Pilih Mata Pelajaran</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-help text-danger err err-subject_id"></div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12 lg:col-span-6">
                                <div>
                                    <label for="input-add-personnel_id" class="form-label">Guru / Pengajar <span class="text-danger">*</span></label>
                                    <select id="input-add-personnel_id" name="personnel_id" class="form-control" required>
                                        <option value="">Pilih Guru / Pengajar</option>
                                    </select>
                                    <div class="form-help text-danger err err-personnel_id"></div>
                                </div>
                            </div>

                            <div class="intro-y col-span-12">
                                <div>
                                    <label for="input-add-description" class="form-label">Deskripsi</label>
                                    <textarea id="input-add-description" name="description" class="form-control" placeholder="Deskripsi (opsional)"></textarea>
                                    <div class="form-help text-danger err err-description"></div>
                                </div>
                            </div>

                            <div class="intro-y col-span-12">
                                <label class="form-label">
                                    <input type="checkbox" id="input-add-is_active" name="is_active" value="1" checked> Aktif
                                </label>
                            </div>
                        </div>

                        <div class="mt-5">
                            <button type="button" data-tw-dismiss="modal" id="btn-add-cancel" class="btn btn-outline-secondary w-24 mr-1">Batal</button>
                            <button type="submit" id="btn-add" class="btn btn-custom-warning w-24">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Modal Add -->

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('#input-add-subject_id').change(function(){
            const subject_id = $(this).val();
            $('#btn-add').removeClass('btn-custom-warning').addClass('btn-light').text('Loading...');
            $.ajax({
                type: 'GET',
                url: '{{ url("class_schedules.get_teachers") }}',
                data : {
                    param: 'subject_id',
                    value: subject_id
                },
                success: function (response) {
                    console.log(response);
                    
                    let options = '<option value="">Pilih Guru / Pengajar</option>';
                    $.each(response, function(key, personnel) {
                        options += '<option value="'+personnel.id+'">'+personnel.name+'</option>';
                    });
                    $('#input-add-personnel_id').html(options);
                    $('#btn-add').removeClass('btn-light').addClass('btn-custom-warning').text('Simpan');
                },
                error: function(err){
                    $('#btn-add').removeClass('btn-light').addClass('btn-custom-warning').text('Simpan');
                },
            })
        })

        $('#form-add').on('submit',function(e){
            e.preventDefault();
            $('#btn-add').removeClass('btn-custom-warning').addClass('btn-light').text('Loading...');
            $('.err').text('');
            $.ajax({
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,  
                cache: false,
                url: $(this).attr('action'),
                success: function (response) {
                    if (response.status == true) {
                        location.reload();
                    } else {
                        $.each(response.errors, function(key, value) {
                            $('.err-'+key).text(value[0]);
                        })
                    }
                    $('#btn-add').removeClass('btn-light').addClass('btn-custom-warning').text('Simpan');
                },
                error: function(err){
                    $.each(err.responseJSON.errors, function(key, value) {
                        $('.err-'+key).text(value[0]);
                    })
                    $('#btn-add').removeClass('btn-light').addClass('btn-custom-warning').text('Simpan');
                },
            })
        })
    })

    function add(){
        $('#btn-add').removeClass('btn-custom-warning').addClass('btn-light').text('Loading...');
        $('#form-add')[0].reset();
        $('.err').text('');
        $('#btn-add').removeClass('btn-light').addClass('btn-custom-warning').text('Simpan');
    }
</script>
