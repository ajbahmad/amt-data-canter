@extends('layouts.admin')

@section('title', 'Jadwal Kelas')

@section('content')

    @include('layouts.partials.admin.breadcrumb', [
        'title' => 'Jadwal Kelas',
        'breadcrumbs' => [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Data Master', 'url' => '#'],
            ['name' => 'Jadwal Kelas', 'url' => '#'],
        ],
    ])

    <div class="grid box grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <div class="kanban-board ">
                <div class="kanban-column bg-white">
                    <div class="kanban-header">
                        <i class="fa fa-id-badge ms-2"></i> Kode Guru / Kode Mapel
                    </div>
                    <div class="kanban-content">
                        <table class="table table-sm table-bordered table-teacher-subject ">
                            <thead>
                                <tr>
                                    <th class="font-bold">Kode</th>
                                    <th class="font-bold">Pengajar</th>
                                    <th class="font-bold">Kode</th>
                                    <th class="font-bold">Mapel</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teachers as $personnel)
                                    @foreach ($personnel->teacherSubjectAssignments as $key => $subject)
                                        <tr>
                                            @if ($key == 0)
                                                <td {{ count($personnel->teacherSubjectAssignments) > 1 ? 'rowspan=' . count($personnel->teacherSubjectAssignments) : '' }}
                                                    class="font-bold text-primary" style="padding:1px 10px">
                                                    {{ nameInitials($personnel->person->full_name) }}
                                                </td>
                                                <td {{ count($personnel->teacherSubjectAssignments) > 1 ? 'rowspan=' . count($personnel->teacherSubjectAssignments) : '' }}
                                                    class="" style="padding:1px 10px">
                                                    {{ $personnel->person->full_name }}
                                                </td>
                                            @endif
                                            <td class="font-bold text-success" style="padding:1px 10px">
                                                {{ $subject->subject->code ?? '-' }}
                                            </td>
                                            <td class="" style="padding:1px 10px">
                                                {{ $subject->subject->name ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>



                @php
                    $daysOfWeek = [
                        1 => 'Senin',
                        2 => 'Selasa',
                        3 => 'Rabu',
                        4 => 'Kamis',
                        5 => 'Jumat',
                        6 => 'Sabtu',
                        7 => 'Minggu'
                    ];
                    $skipCell = [];
                @endphp

                @foreach ($daysOfWeek as $dayIndex => $dayName)
                    @php
                        $dayData = $schedules[$dayIndex] ?? [];
                    @endphp

                    <div class="kanban-column bg-white {{ strtolower($dayName) }}" data-day="{{ $dayIndex }}">
                        <div class="kanban-header">
                            <i class="fa fa-calendar ms-2"></i>{{ $dayName }}
                        </div>
                        <div class="kanban-content">
                            <button class="add-schedule-btn w-full" data-day="{{ $dayIndex }}">
                                <i class="fa fa-plus ms-2"></i> Tambah Jadwal
                            </button>
                            <div class="">
                                <table class="table table-sm table-bordered schedule-table">
                                    <thead>
                                        <tr>
                                            <th>Jam Ke</th>
                                            @foreach ($classes as $cls)
                                                <th class="text-center p-0">{{ $cls->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($sessionTimes as $sessionIndex => $sessionTime)
                                            <tr>
                                                <td style="width: 100px">
                                                    <div class="flex gap-1">
                                                        <div
                                                            class="bg-lightprimary text-gray-800 text-xs font-medium ms-2 w-10 text-center px-2.5 py-0.5 rounded">
                                                            {{ $sessionTime->name }}</div>
                                                        <div
                                                            class="bg-lightprimary text-gray-800 text-xs font-medium ms-2 px-2.5 py-0.5 rounded">
                                                            {{ \Carbon\Carbon::parse($sessionTime->start_time)->format('H:i') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($sessionTime->end_time)->format('H:i') }}
                                                        </div>
                                                    </div>
                                                </td>

                                                @foreach ($classes as $class)
                                                    @if (isset($skipCell[$dayIndex][$sessionTime->id][$class->id]))
                                                        @continue
                                                    @endif

                                                    @php
                                                        // Filter schedule berdasarkan class_room_id, start_time_slot_id, dan end_time_slot_id
                                                        $classSchedules = collect($dayData['schedules'] ?? [])
                                                            ->filter(function($s) use ($class, $sessionTime) {
                                                                return $s->class_room_id === $class->id && 
                                                                       $s->start_time_slot_id === $sessionTime->id;
                                                            });
                                                        
                                                        $scheduleItem = $classSchedules->first();
                                                        $rowspan = 1;
                                                    @endphp

                                                    @if ($scheduleItem)
                                                        @php
                                                            $startId = $scheduleItem->start_time_slot_id;
                                                            $endId = $scheduleItem->end_time_slot_id;

                                                            $startIndex = $sessionTimes->search(
                                                                fn($st) => $st->id == $startId,
                                                            );
                                                            $endIndex = $sessionTimes->search(
                                                                fn($st) => $st->id == $endId,
                                                            );

                                                            $rowspan = $endIndex - $startIndex + 1;

                                                            for ($i = $startIndex + 1; $i <= $endIndex; $i++) {
                                                                $skipCell[$dayIndex][$sessionTimes[$i]->id][
                                                                    $class->id
                                                                ] = true;
                                                            }
                                                        @endphp
                                                    @endif

                                                    <td
                                                        @if ($rowspan > 1) rowspan="{{ $rowspan }}" class="schedule-cols p-0" @else class="p-0 schedule-cols bg-slate-100" @endif>

                                                        @if ($scheduleItem)
                                                            <div class="">
                                                                <div
                                                                    class="tooltip-container bg-success text-white text-xs font-medium ms-2 px-2.5 py-0.5 rounded cursor-help">
                                                                    {{ $scheduleItem->subject?->code ?? '-' }}
                                                                    <span
                                                                        class="tooltip-text">{{ $scheduleItem->subject?->name ?? '-' }}</span>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div
                                                                    class="tooltip-container bg-primary text-white text-xs font-medium ms-2 px-2.5 py-0.5 rounded cursor-help">
                                                                    {{ nameInitials($scheduleItem->teacher?->person?->full_name) ?? '-' }}
                                                                    <span
                                                                        class="tooltip-text">{{ $scheduleItem->teacher?->person?->full_name ?? '-' }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="grid box p-3 border box-detail absolute border-slate-200 mt-2 text-left"
                                                                style="z-index: 2;margin-left:-130px; background-color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px;">
                                                                <div class="">
                                                                    <div>
                                                                        <div>
                                                                            <strong>Lembaga:</strong>
                                                                            {{ $scheduleItem->schoolInstitution?->name ?? '-' }}
                                                                        </div>
                                                                        <div>
                                                                            <strong>Sekolah:</strong>
                                                                            {{ $scheduleItem->schoolLevel?->name ?? '-' }}
                                                                        </div>
                                                                        <div>
                                                                            <strong>Tahun:</strong>
                                                                            {{ $scheduleItem->semester->schoolYear?->name ?? '-' }}
                                                                        </div>
                                                                        <div>
                                                                            <strong>Semester:</strong>
                                                                            {{ $scheduleItem->semester?->name ?? '-' }}
                                                                        </div>
                                                                        <div>
                                                                            <strong>Mata Pelajaran:</strong>
                                                                            {{ $scheduleItem->subject?->name ?? '-' }}
                                                                        </div>
                                                                        <div>
                                                                            <strong>Pengajar:</strong>
                                                                            {{ $scheduleItem->teacher?->person?->full_name ?? '-' }}
                                                                        </div>


                                                                        <div>
                                                                            <strong>Jam Ke : </strong>
                                                                            {{ $scheduleItem->startTimeSlot?->name }}
                                                                            -
                                                                            {{ $scheduleItem->endTimeSlot?->name }}
                                                                        </div>

                                                                        <div>
                                                                            <strong>Waktu : </strong>
                                                                            {{ \Carbon\Carbon::parse($scheduleItem->startTimeSlot?->start_time)->format('H:i') }}
                                                                            -
                                                                            {{ \Carbon\Carbon::parse($scheduleItem->endTimeSlot?->end_time)->format('H:i') }}
                                                                        </div>

                                                                    </div>
                                                                    <div class="flex mt-2 gap-1 align-items-center">
                                                                        <button class="btn text-dark bg-yellow-500 px-2 py-1 ms-2"
                                                                            onclick="editSchedule('{{ $scheduleItem->id }}');"><i
                                                                                class="ti ti-edit"></i> Edit </button>
                                                                        <button class="btn bg-red-700 px-2 py-1"
                                                                            onclick="deleteSchedule('{{ $scheduleItem->id }}');"><i
                                                                                class="ti ti-trash"></i> Delete
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </td>
                                                @endforeach

                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables-colresize@1.0.0/dist/dataTables.colResize.css">
    <style>
        .kanban-board {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            /* 2 kolom tetap */
            gap: 20px;
            padding: 20px 0;
        }

        .kanban-column {
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            max-height: 380px;
            width: 100%;
            /* isi lebar grid */
        }
        /* .kanban-column.senin { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
            .kanban-column.selasa { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
            .kanban-column.rabu { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
            .kanban-column.kamis { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
            .kanban-column.jumat { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
            .kanban-column.sabtu { background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); }
            .kanban-column.minggu { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); } */

        .kanban-header {
            padding: 20px;
            font-weight: bold;
            font-size: 18px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .kanban-content {
            padding: 15px;
            flex: 1;
            overflow: visible;
            height: 100px !important;
            overflow: auto !important;
        }

        .schedule-card {
            background: white;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .schedule-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .schedule-time {
            font-size: 12px;
            color: #666;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .schedule-subject {
            font-weight: bold;
            color: #333;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .schedule-teacher {
            font-size: 11px;
            color: #999;
            margin-bottom: 8px;
        }

        .schedule-actions {
            display: flex;
            gap: 5px;
            margin-top: 8px;
        }

        .schedule-actions button {
            padding: 4px 8px;
            font-size: 11px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-edit-schedule {
            background: #3498db;
            color: white;
            flex: 1;
        }

        .btn-edit-schedule:hover {
            background: #2980b9;
        }

        .btn-delete-schedule {
            background: #e74c3c;
            color: white;
            flex: 1;
        }

        .btn-delete-schedule:hover {
            background: #c0392b;
        }

        .add-schedule-btn {
            background: white;
            color: #333;
            padding: 15px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s;
            margin-bottom: 10px;
        }

        .add-schedule-btn:hover {
            border-color: #3498db;
            color: #3498db;
            background: #ecf0f1;
        }

        .empty-state {
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            padding: 30px 15px;
            font-size: 14px;
        }

        .table-teacher-subject tr td,
        .schedule-table tr td {
            white-space: nowrap !important;
        }

        .schedule-cols:hover {
            background-color: rgba(52, 152, 219, 0.1);
            cursor: pointer;
            color: #2980b9;
        }


        .tooltip-container {
            position: relative;
            display: inline-block;
        }

        .tooltip-text {
            visibility: hidden;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 8px 12px;
            border-radius: 6px;
            position: absolute;
            z-index: 999;
            bottom: 120%;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
            font-size: 12px;
            font-weight: 500;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .tooltip-container:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #333 transparent transparent transparent;
        }

        .box-detail {
            display: none;
        }

        td.active>.box-detail {
            display: block;
        }

        .border-none {
            border: none !important;
        }

        .table {
            border-collapse: separate !important;
            border-spacing: 2px 2px !important;
            width: 100% !important;
        }
        .table.table-bordered tr th,
        .table.table-bordered tr td {
            border: 1px solid #dee2e6 !important;
        }
        .table .p-0 {
            padding: 0.1rem !important;
            text-align: center;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Add schedule button
            $('.add-schedule-btn').on('click', function() {
                const day = $(this).data('day');
                addSchedule(day);
            });

            $('.schedule-cols').click(function(e) {
                e.stopPropagation();
                $('td.active').removeClass('active');
                $(this).toggleClass('active');
            });

            // Klik di luar td untuk menghapus active class
            $(document).click(function() {
                $('td.active').removeClass('active');
            });
        });

        function addSchedule(dayOfWeek) {
            $('#form-add')[0].reset();
            $('#input-add-day_of_week').val(dayOfWeek);
            $('.err').text('');
        }

        function deleteSchedule(id) {
            Swal.fire({
                title: 'Hapus Jadwal?',
                text: "Jadwal yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route("class_schedules.destroy", ":id") }}'.replace(':id', id),
                        data : {
                            _method: 'DELETE'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status) {
                                location.reload();
                                Swal.fire('Terhapus!', response.message, 'success');
                            } else {
                                location.reload();
                                Swal.fire('Error!', response.message, 'error');
                            }
                        }
                    });
                }
            });
        }

    </script>
    @include('pages.class_schedules.modal-add')
    @include('pages.class_schedules.modal-edit')
@endpush
