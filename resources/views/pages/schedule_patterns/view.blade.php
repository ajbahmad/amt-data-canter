@extends('layouts.admin')

@section('title', 'Detail Pola Jadwal')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Detail Pola Jadwal',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Akademik', 'url' => '#'],
        ['name' => 'Pola Jadwal', 'url' => route('schedule_patterns.index')],
        ['name' => 'Detail Pola', 'url' => '#']
    ]
])

<div class="rounded-2xl border border-slate-50 bg-white p-8 mb-6 shadow-none">
    
    <div class="mb-8 pb-4 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-xl font-extrabold text-emerald-800 flex items-center gap-2">
            <span class="size-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:calendar" class="text-base"></iconify-icon>
            </span>
            Pola Jadwal: {{ $schedulePattern->name }}
        </h2>
        
        <div class="flex items-center gap-2">
            <a href="{{ route('schedule_patterns.edit', $schedulePattern) }}" style="background-color: #3b82f6" class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2.5 text-xs font-bold text-white transition-all shadow-sm hover:brightness-105">
                <iconify-icon icon="lucide:edit-2" class="text-sm"></iconify-icon>
                Edit
            </a>
            <button class="inline-flex items-center gap-1.5 rounded-xl bg-red-50 text-red-655 hover:bg-red-100 px-4 py-2.5 text-xs font-bold transition-all delete-btn" data-id="{{ $schedulePattern->id }}">
                <iconify-icon icon="lucide:trash-2" class="text-sm"></iconify-icon>
                Hapus
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Nama Pola Jadwal</label>
            <p class="text-sm font-bold text-slate-800">{{ $schedulePattern->name }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Lembaga</label>
            <p class="text-sm font-bold text-slate-800">{{ $schedulePattern->schoolInstitution->name }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Sekolah / Jenjang</label>
            <p class="text-sm font-bold text-slate-800">{{ $schedulePattern->schoolLevel->name }}</p>
        </div>
    </div>

    <!-- Deskripsi -->
    @if($schedulePattern->description)
        <div class="mb-8 pb-6 border-b border-slate-100">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">Deskripsi Keterangan</label>
            <p class="text-sm font-bold text-slate-800 bg-slate-50 p-4 rounded-lg border border-slate-100 leading-relaxed">{{ $schedulePattern->description }}</p>
        </div>
    @endif

    <!-- Informasi Waktu Pembuatan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Dibuat Pada</label>
            <p class="text-xs font-bold text-slate-500">{{ $schedulePattern->created_at->translatedFormat('d F Y - H:i') }}</p>
        </div>
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Diperbarui Pada</label>
            <p class="text-xs font-bold text-slate-500">{{ $schedulePattern->updated_at->translatedFormat('d F Y - H:i') }}</p>
        </div>
    </div>
</div>

<!-- Section Jadwal Harian -->
<div class="rounded-2xl border border-slate-50 bg-white p-8">
    <div class="mb-6 pb-4 border-b border-slate-100">
        <h3 class="text-lg font-extrabold text-emerald-800 flex items-center gap-2">
            <span class="size-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                <iconify-icon icon="lucide:clock" class="text-sm"></iconify-icon>
            </span>
            Konfigurasi Jadwal Harian
        </h3>
        <p class="text-xs text-slate-400 mt-1">Atur jam operasional masuk, pulang, atau status libur untuk setiap hari belajar dalam pola jadwal ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $days = [
                0 => 'Senin',
                1 => 'Selasa',
                2 => 'Rabu',
                3 => 'Kamis',
                4 => 'Jumat',
                5 => 'Sabtu',
                6 => 'Minggu'
            ];
        @endphp
        
        @foreach($schedulePattern->schoolDaySchedules()->orderBy('day_of_week')->get() as $schedule)
            <div class="rounded-xl border border-slate-100 p-5 bg-slate-50 hover:bg-white hover:shadow-md hover:border-emerald-100 transition-all duration-200 flex flex-col justify-between min-h-[140px]">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-wider">{{ $days[$schedule->day_of_week] ?? 'Hari' }}</span>
                        @if($schedule->is_holiday)
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-red-50 text-red-700">
                                Libur
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-850">
                                Aktif
                            </span>
                        @endif
                    </div>

                    @if($schedule->is_holiday)
                        <div class="text-slate-400 font-bold text-sm py-1 flex items-center gap-1.5">
                            <iconify-icon icon="lucide:info" class="text-base text-red-400"></iconify-icon>
                            Tidak ada kegiatan belajar
                        </div>
                    @else
                        <div class="text-slate-800 font-extrabold text-base py-1 flex items-center gap-2">
                            <iconify-icon icon="lucide:clock-4" class="text-emerald-700 text-lg"></iconify-icon>
                            <span>{{ $schedule->start_time ? Carbon\Carbon::parse($schedule->start_time)->format('H:i') : '-' }}</span>
                            <span class="text-slate-300 font-normal">s/d</span>
                            <span>{{ $schedule->end_time ? Carbon\Carbon::parse($schedule->end_time)->format('H:i') : '-' }}</span>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end pt-3 mt-3 border-t border-slate-100/70">
                    <button type="button" 
                        onclick="editSchedule('{{ $schedule->id }}', '{{ $days[$schedule->day_of_week] }}', '{{ $schedule->start_time }}', '{{ $schedule->end_time }}', {{ $schedule->is_holiday ? 'true' : 'false' }})" 
                        class="inline-flex items-center gap-1 px-3 py-1.5 text-[11px] font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200/50 rounded-lg transition-all">
                        <iconify-icon icon="lucide:edit-3"></iconify-icon>
                        Ubah Waktu
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Navigation Back -->
    <div class="pt-6 mt-8 border-t border-slate-100 flex items-center">
        <a href="{{ route('schedule_patterns.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 px-6 py-2.5 text-xs font-bold text-slate-700 transition-all">
            <iconify-icon icon="lucide:arrow-left" class="text-sm"></iconify-icon>
            Kembali ke Daftar
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{asset('assets/libs/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
<script>
    // Delete Schedule Pattern confirmation
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        let deleteUrl = '{{ route('schedule_patterns.destroy', ':id') }}'.replace(':id', id);
        
        Swal.fire({
            title: 'Hapus Pola Jadwal?',
            text: 'Apakah Anda yakin ingin menghapus pola jadwal ini? Semua konfigurasi jadwal harian terkait akan terhapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
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
        });
    });

    // Edit daily schedule popup (ajax update)
    function editSchedule(id, dayName, startTime, endTime, isHoliday) {
        // format time for inputs (remove seconds if present)
        let formattedStart = startTime && startTime !== 'null' ? startTime.substring(0, 5) : '';
        let formattedEnd = endTime && endTime !== 'null' ? endTime.substring(0, 5) : '';

        Swal.fire({
            title: `Edit Jadwal Hari ${dayName}`,
            html: `
                <form id="editScheduleForm" class="text-left py-2">
                    <div class="mb-4">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">
                            Hari
                        </label>
                        <input type="text" value="${dayName}" class="w-full text-sm border border-slate-200 rounded-lg outline-none text-slate-500 font-semibold px-4 py-2.5 bg-slate-50" disabled>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">
                            Jam Mulai
                        </label>
                        <input type="time" name="start_time" id="start_time" value="${formattedStart}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all outline-none text-slate-700 font-medium px-4 py-2.5 bg-white">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">
                            Jam Selesai
                        </label>
                        <input type="time" name="end_time" id="end_time" value="${formattedEnd}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all outline-none text-slate-700 font-medium px-4 py-2.5 bg-white">
                    </div>
                    
                    <div class="mb-2">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" name="is_holiday" id="is_holiday" ${isHoliday ? 'checked' : ''} class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 transition-all">
                            <span class="text-xs font-black text-slate-600 uppercase tracking-wider">Jadikan Hari Libur</span>
                        </label>
                    </div>
                </form>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#64748b',
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
                        startTimeInput.classList.add('bg-slate-50');
                        endTimeInput.classList.add('bg-slate-50');
                    } else {
                        startTimeInput.disabled = false;
                        endTimeInput.disabled = false;
                        startTimeInput.classList.remove('bg-slate-50');
                        endTimeInput.classList.remove('bg-slate-50');
                    }
                }

                updateTimeInputs();
                isHolidayCheckbox.addEventListener('change', updateTimeInputs);
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX update
                let updateUrl = '{{ route("school_day_schedules.update", ":id") }}'.replace(':id', id);
                let data = {
                    start_time: $('#start_time').val() || null,
                    end_time: $('#end_time').val() || null,
                    is_holiday: $('#is_holiday').is(':checked') ? 1 : 0,
                    _method: 'PUT'
                };

                $.ajax({
                    url: updateUrl,
                    type: "POST",
                    data: JSON.stringify(data),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message || 'Jadwal hari berhasil diperbarui',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function (xhr) {
                        let errorMsg = 'Terjadi kesalahan saat menyimpan data';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMsg
                        });
                    }
                });
            }
        });
    }
</script>
@endpush
