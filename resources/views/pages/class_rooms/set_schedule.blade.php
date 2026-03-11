@extends('layouts.admin')

@section('title', 'Atur Jadwal Masuk')

@section('content')

    @include('layouts.partials.admin.breadcrumb', [
        'title' => 'Atur Jadwal Masuk',
        'breadcrumbs' => [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Data Master', 'url' => '#'],
            ['name' => 'Rombel', 'url' => route('class_rooms.index')],
            ['name' => 'Jadwal Masuk', 'url' => '#'],
        ],
    ])


    <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">

        <div class="mb-6 flex items-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                <i class="ti ti-door mr-2"></i>Atur Jadwal Masuk
            </h2>

            <a href="{{ route('class_rooms.index') }}"
                class="inline-flex items-center ms-auto rounded-lg bg-gray-100 px-4 py-2 hover:bg-slate-700 transition">
                <i class="ti ti-arrow-left mr-2"></i>Kembali Ke Rombel
            </a>
        </div>
        <form action="" method="post">
            @method('post')
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Lembaga <span class="text-red-500">*</span>
                    </label>
                    <select name="school_institution_id"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('school_institution_id') border-red-500 @enderror">
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach ($schoolInstitutions as $schoolInstitution)
                            <option value="{{ $schoolInstitution->id }}"
                                {{ old('school_institution_id') == $schoolInstitution->id ? 'selected' : '' }}>
                                {{ $schoolInstitution->name }}</option>
                        @endforeach
                    </select>
                    @error('school_institution_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tingkat Sekolah <span class="text-red-500">*</span>
                    </label>
                    <select name="school_level_id"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('school_level_id') border-red-500 @enderror">
                        <option value="">-- Pilih Tingkat Sekolah --</option>
                        @foreach ($schoolLevels as $schoolLevel)
                            <option value="{{ $schoolLevel->id }}"
                                {{ old('school_level_id') == $schoolLevel->id ? 'selected' : '' }}>{{ $schoolLevel->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('school_level_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <table class="table w-full">
                <thead>
                    <tr>
                        <th class="border w-1 p-2 text-center bg-gray-100"> No </th>
                        <th class="border p-2 text-start bg-gray-100"> Nama Kelas </th>
                        <th class="border p-2 text-start bg-gray-100"> Pola Jadwal </th>
                    </tr>
                </thead>
                <tbody class="class_rooms">
                    @foreach ($classRooms as $key => $cls)
                        <tr>
                            <td class="border p-1 text-center"> {{ $key + 1 }} </td>
                            <td class="border p-1"> {{ $cls->name }} </td>
                            <td class="border p-1">
                                <select class="form-select p-0 px-3 w-full schedule_patterns" name="schedule_pattern[{{ $cls->id }}]">
                                    <option value="">Pilih Pola Jadwal</option>
                                    @foreach ($schedulePatterns as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $cls->schedule_pattern_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit"
                class="inline-flex items-center ms-auto rounded-lg bg-success px-4 py-2 mt-4 text-white transition">
                <i class="ti ti-database mr-2"></i> Simpan pengaturan
            </button>

        </form>

    </div>

@endsection

@push('styles')
    <style>
        .dt-paging-button {
            border-radius: 50% !important;
        }

        .table-responsive {
            overflow-x: auto;
        }

        #datatable thead tr.filters th {
            padding: 10px 1px;
            font-weight: 100 !important
        }

        #datatable thead tr th {
            white-space: nowrap;
        }
    </style>
@endpush

@push('scripts')
    @include('components.confirm-toastr')
    <script>
        intFilterSelect();
    </script>
@endpush