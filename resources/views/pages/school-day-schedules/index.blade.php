@extends('layouts.admin')

@section('title', 'Jadwal Harian')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Jadwal Harian',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Akademik', 'url' => '#'],
        ['name' => 'Jadwal Harian', 'url' => '#']
    ]
])


<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
    
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <i class="ti ti-calendar-month mr-2"></i>Jadwal Harian
        </h2>
    </div>
    
    {!! $dataTable->table(['class' => 'display nowrap w-full'], true) !!}

</div>


@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/libs/DataTables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/libs/sweetalert2/css/sweetalert2.min.css')}}">
    


    

@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/DataTables/datatables.min.js') }}"></script>
    <script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    {!! $dataTable->scripts() !!}
    @include('components.confirm-toastr')

    <script>
function editData(id, url) {

    $.ajax({
        url: `/school-day-schedules/${id}`,
        type: "GET",
        dataType: "json",
        success: function (response) {

            const schedule = response.data;

            Swal.fire({
                title: 'Edit Jadwal Harian',
                html: `
                    <form id="editScheduleForm" class="text-left">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Hari
                            </label>
                            <input type="text" value="${schedule.day_name}" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white dark:border-gray-600" disabled>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jam Mulai
                            </label>
                            <input type="time" name="start_time" id="start_time" value="${schedule.start_time || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jam Selesai
                            </label>
                            <input type="time" name="end_time" id="end_time" value="${schedule.end_time || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        </div>
                        
                        <div class="mb-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_holiday" id="is_holiday" ${schedule.is_holiday ? 'checked' : ''} class="w-4 h-4 text-blue-600">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Jadikan Hari Libur</span>
                            </label>
                        </div>
                    </form>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                didOpen: () => {

                    const isHolidayCheckbox = document.getElementById('is_holiday');
                    const startTimeInput = document.getElementById('start_time');
                    const endTimeInput = document.getElementById('end_time');

                    function updateTimeInputs() {
                        if (isHolidayCheckbox.checked) {
                            startTimeInput.disabled = true;
                            endTimeInput.disabled = true;
                            startTimeInput.value = '';
                            endTimeInput.value = '';
                        } else {
                            startTimeInput.disabled = false;
                            endTimeInput.disabled = false;
                        }
                    }

                    updateTimeInputs();
                    isHolidayCheckbox.addEventListener('change', updateTimeInputs);
                }

            }).then((result) => {

                if (result.isConfirmed) {

                    const data = {
                        start_time: $('#start_time').val() || null,
                        end_time: $('#end_time').val() || null,
                        is_holiday: $('#is_holiday').is(':checked') ? 1 : 0,
                        _method: 'PUT'
                    };

                    $.ajax({
                        url: `/school-day-schedules/${id}`,
                        type: "POST",
                        data: JSON.stringify(data),
                        contentType: "application/json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (res) {

                            if (res.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: res.message,
                                    timer: 1500
                                }).then(() => {
                                    // reload datatable
                                    $('#datatable').DataTable().ajax.reload();
                                    // location.reload();
                                });
                            }

                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menyimpan data'
                            });
                        }
                    });

                }

            });

        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat memuat data'
            });
        }
    });

}
</script>

@endpush
