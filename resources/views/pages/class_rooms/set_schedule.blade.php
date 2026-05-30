@extends('layouts.admin')

@section('title', 'Atur Jadwal Masuk')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Atur Jadwal Masuk',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Rombel', 'url' => route('class_rooms.index')],
        ['name' => 'Jadwal Masuk', 'url' => '#']
    ]
])

<div class="rounded-2xl border border-slate-50 bg-white p-8">

    <div class="mb-8 pb-4 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-emerald-800 flex items-center gap-2">
                <span class="size-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                    <iconify-icon icon="lucide:calendar-clock" class="text-base"></iconify-icon>
                </span>
                Atur Jadwal Masuk Rombel
            </h2>
            <p class="text-xs text-slate-400 mt-1">Sesuaikan pola jadwal masuk harian untuk masing-masing rombongan belajar secara masal.</p>
        </div>

        <a href="{{ route('class_rooms.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 px-5 py-2.5 text-xs font-bold text-slate-700 transition-all">
            <iconify-icon icon="lucide:arrow-left" class="text-sm"></iconify-icon>
            Kembali Ke Rombel
        </a>
    </div>

    <form action="" method="post">
        @method('post')
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Lembaga <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="school_institution_id" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 appearance-none @error('school_institution_id') border-red-500 @enderror">
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach ($schoolInstitutions as $schoolInstitution)
                            <option value="{{ $schoolInstitution->id }}" {{ old('school_institution_id') == $schoolInstitution->id ? 'selected' : '' }}>
                                {{ $schoolInstitution->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                        <iconify-icon icon="lucide:chevron-down" class="text-xs"></iconify-icon>
                    </div>
                </div>
                @error('school_institution_id')
                    <p class="text-red-655 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                    Tingkat Sekolah <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="school_level_id" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 appearance-none @error('school_level_id') border-red-500 @enderror">
                        <option value="">-- Pilih Tingkat Sekolah --</option>
                        @foreach ($schoolLevels as $schoolLevel)
                            <option value="{{ $schoolLevel->id }}" {{ old('school_level_id') == $schoolLevel->id ? 'selected' : '' }}>
                                {{ $schoolLevel->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                        <iconify-icon icon="lucide:chevron-down" class="text-xs"></iconify-icon>
                    </div>
                </div>
                @error('school_level_id')
                    <p class="text-red-655 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                        <i class="ti ti-alert-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <div class="table-responsive mb-8">
            <table class="table-schedule w-full">
                <thead>
                    <tr>
                        <th class="w-16 text-center">No</th>
                        <th class="text-left">Nama Rombel</th>
                        <th class="text-left">Pola Jadwal Masuk</th>
                    </tr>
                </thead>
                <tbody class="class_rooms">
                    @foreach ($classRooms as $key => $cls)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="font-bold text-slate-800">{{ $cls->name }}</td>
                            <td>
                                <div class="relative">
                                    <select class="w-full text-xs border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-3 py-2 bg-white hover:border-slate-300 appearance-none" name="schedule_pattern[{{ $cls->id }}]">
                                        <option value="">Pilih Pola Jadwal</option>
                                        @foreach ($schedulePatterns as $item)
                                            <option value="{{ $item->id }}" {{ $cls->schedule_pattern_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                        <iconify-icon icon="lucide:chevron-down" class="text-xs"></iconify-icon>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex items-center">
            <button style="background-color: #3b82f6" type="submit" class="inline-flex items-center gap-2 rounded-xl px-6 py-2.5 text-xs font-bold text-white transition-all shadow-sm hover:brightness-105">
                <iconify-icon icon="lucide:save" class="text-sm"></iconify-icon>
                Simpan Pengaturan
            </button>
        </div>

    </form>

</div>

@endsection

@push('styles')
    <style>
        .table-responsive {
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            overflow: hidden;
        }
        table.table-schedule {
            border-collapse: collapse;
            margin: 0;
            width: 100%;
        }
        table.table-schedule thead {
            background-color: #f8fafc;
        }
        table.table-schedule thead th {
            padding: 1rem 1.25rem;
            font-size: 0.7rem;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #f1f5f9;
        }
        table.table-schedule tbody tr {
            border-bottom: 1px solid #f8fafc;
            transition: all 0.2s ease;
        }
        table.table-schedule tbody tr:last-child {
            border-bottom: none;
        }
        table.table-schedule tbody tr:hover {
            background-color: #f8fafc;
        }
        table.table-schedule tbody td {
            padding: 0.75rem 1.25rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #334155;
            vertical-align: middle;
        }
    </style>
@endpush

@push('scripts')
    @include('components.confirm-toastr')
    <script>
        intFilterSelect();
    </script>
@endpush