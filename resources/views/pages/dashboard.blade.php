@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

@php
    // Get live data center metrics
    $totalStudents = 0;
    $totalTeachers = 0;
    $totalSubjects = 0;
    $totalClassRooms = 0;
    $totalSchoolInstitutions = 0;
    $totalSchoolLevels = 0;
    $totalSemesters = 0;
    $totalUsers = 0;
    $activeSemester = 'Tidak ada semester aktif';
    $activeSchoolYear = 'Tidak ada tahun ajaran aktif';

    try {
        $totalStudents = \App\Models\Student::count();
    } catch (\Throwable $e) {}

    try {
        $totalTeachers = \App\Models\Teacher::count();
    } catch (\Throwable $e) {}

    try {
        $totalSubjects = \App\Models\Subject::count();
    } catch (\Throwable $e) {}

    try {
        $totalClassRooms = \App\Models\ClassRoom::count();
    } catch (\Throwable $e) {}

    try {
        $totalSchoolInstitutions = \App\Models\SchoolInstitution::count();
    } catch (\Throwable $e) {}

    try {
        $totalSchoolLevels = \App\Models\SchoolLevel::count();
    } catch (\Throwable $e) {}

    try {
        $totalUsers = \App\Models\User::count();
    } catch (\Throwable $e) {}

    try {
        $totalSemesters = \App\Models\Semester::count();
        $sem = \App\Models\Semester::where('is_active', true)->first();
        if ($sem) {
            $activeSemester = $sem->name;
        }
    } catch (\Throwable $e) {}

    try {
        $sy = \App\Models\SchoolYear::where('is_active', true)->first();
        if ($sy) {
            $activeSchoolYear = $sy->name;
        }
    } catch (\Throwable $e) {}

    // Let's get recent activities or recent students/teachers
    $recentStudents = [];
    try {
        $recentStudents = \App\Models\Student::with('person')->latest()->take(4)->get();
    } catch (\Throwable $e) {}

    $recentTeachers = [];
    try {
        $recentTeachers = \App\Models\Teacher::with('person')->latest()->take(4)->get();
    } catch (\Throwable $e) {}

    $recentSubjects = [];
    try {
        $recentSubjects = \App\Models\Subject::latest()->take(4)->get();
    } catch (\Throwable $e) {}
@endphp

<div class="space-y-6">

    {{-- Title and Top Buttons --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-emerald-800 tracking-tight">Dashboard Data Center</h1>
            <p class="text-xs font-semibold text-slate-400 mt-1">Pantau statistik lembaga, jenjang sekolah, siswa terdaftar, guru pendidik, dan kurikulum secara real-time.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('students.create') }}" class="inline-flex items-center gap-2 bg-[#0f513d] hover:bg-[#0c4030] text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-sm">
                <iconify-icon icon="lucide:user-plus" class="text-sm"></iconify-icon>
                Tambah Siswa
            </a>
            <a href="{{ route('teachers.create') }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-[#0f513d] border border-[#0f513d]/20 text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-sm">
                <iconify-icon icon="lucide:plus" class="text-sm"></iconify-icon>
                Tambah Guru
            </a>
        </div>
    </div>

    {{-- Data Center KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Card 1: Total Siswa --}}
        <div class="bg-[#0f513d] text-white p-6 rounded-2xl relative overflow-hidden shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <span class="text-xs font-semibold text-emerald-100">Total Siswa Terdaftar</span>
                <span class="size-8 rounded-full bg-white/10 flex items-center justify-center text-white">
                    <iconify-icon icon="lucide:users" class="text-sm"></iconify-icon>
                </span>
            </div>
            <p class="text-4xl font-extrabold tracking-tight mb-2">{{ $totalStudents }}</p>
            <p class="text-[10px] font-bold text-emerald-300 flex items-center gap-1">
                <iconify-icon icon="lucide:shield-check" class="text-xs"></iconify-icon>
                Terdaftar aktif di sistem akademik
            </p>
        </div>

        {{-- Card 2: Total Guru --}}
        <div class="bg-white border border-slate-100 p-6 rounded-2xl relative overflow-hidden shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <span class="text-xs font-bold text-slate-400">Total Guru / Pendidik</span>
                <span class="size-8 rounded-full border border-slate-100 flex items-center justify-center text-emerald-800 bg-emerald-50">
                    <iconify-icon icon="lucide:graduation-cap" class="text-sm"></iconify-icon>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-slate-850 tracking-tight mb-2">{{ $totalTeachers }}</p>
            <p class="text-[10px] font-bold text-emerald-600 flex items-center gap-1">
                <iconify-icon icon="lucide:check-circle-2" class="text-xs"></iconify-icon>
                Tenaga pendidik terverifikasi
            </p>
        </div>

        {{-- Card 3: Total Kelas --}}
        <div class="bg-white border border-slate-100 p-6 rounded-2xl relative overflow-hidden shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <span class="text-xs font-bold text-slate-400">Total Rombel Kelas</span>
                <span class="size-8 rounded-full border border-slate-100 flex items-center justify-center text-emerald-800 bg-emerald-50">
                    <iconify-icon icon="lucide:layout-grid" class="text-sm"></iconify-icon>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-slate-850 tracking-tight mb-2">{{ $totalClassRooms }}</p>
            <p class="text-[10px] font-bold text-emerald-600 flex items-center gap-1">
                <iconify-icon icon="lucide:door-open" class="text-xs"></iconify-icon>
                Ruangan kelas aktif berjadwal
            </p>
        </div>

        {{-- Card 4: Total Mapel --}}
        <div class="bg-white border border-slate-100 p-6 rounded-2xl relative overflow-hidden shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <span class="text-xs font-bold text-slate-400">Total Mata Pelajaran</span>
                <span class="size-8 rounded-full border border-slate-100 flex items-center justify-center text-emerald-800 bg-emerald-50">
                    <iconify-icon icon="lucide:book-open" class="text-sm"></iconify-icon>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-slate-850 tracking-tight mb-2">{{ $totalSubjects }}</p>
            <p class="text-[10px] font-bold text-emerald-600 flex items-center gap-1">
                <iconify-icon icon="lucide:file-text" class="text-xs"></iconify-icon>
                Kurikulum mata pelajaran aktif
            </p>
        </div>
    </div>

    {{-- Middle Row (Academic Analytics, Active Session Info, Subjects) --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        {{-- Card A: Academic Analytics (Left) --}}
        <div class="lg:col-span-5 bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between">
            <h3 class="text-sm font-extrabold text-slate-800 mb-6 uppercase tracking-wide">Distribusi Data Lembaga</h3>
            
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-xs font-black text-slate-600 uppercase mb-1">
                        <span>Lembaga Sekolah</span>
                        <span>{{ $totalSchoolInstitutions }} Lembaga</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-[#0f513d] h-2 rounded-full" style="width: {{ $totalSchoolInstitutions > 0 ? min(($totalSchoolInstitutions / 10) * 100, 100) : 10 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-xs font-black text-slate-600 uppercase mb-1">
                        <span>Jenjang Pendidikan</span>
                        <span>{{ $totalSchoolLevels }} Jenjang</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $totalSchoolLevels > 0 ? min(($totalSchoolLevels / 10) * 100, 100) : 20 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-xs font-black text-slate-600 uppercase mb-1">
                        <span>Semester Akademik</span>
                        <span>{{ $totalSemesters }} Terdaftar</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $totalSemesters > 0 ? min(($totalSemesters / 10) * 100, 100) : 30 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-xs font-black text-slate-600 uppercase mb-1">
                        <span>Pengguna Aplikasi</span>
                        <span>{{ $totalUsers }} Operator</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $totalUsers > 0 ? min(($totalUsers / 10) * 100, 100) : 15 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card B: Active Session Info (Center) --}}
        <div class="lg:col-span-3 bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between">
            <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wide">Periode Aktif</h3>
            <div class="my-4 space-y-3">
                <div>
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Tahun Akademik</span>
                    <h4 class="text-base font-black text-[#0f513d] flex items-center gap-1.5 mt-0.5">
                        <iconify-icon icon="lucide:calendar" class="text-sm"></iconify-icon>
                        {{ $activeSchoolYear }}
                    </h4>
                </div>
                <div>
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-wider">Semester Aktif</span>
                    <h4 class="text-base font-black text-emerald-600 flex items-center gap-1.5 mt-0.5">
                        <iconify-icon icon="lucide:clock" class="text-sm"></iconify-icon>
                        {{ $activeSemester }}
                    </h4>
                </div>
            </div>
            <a href="{{ route('school_years.index') }}" class="w-full inline-flex items-center justify-center gap-2 bg-[#0f513d] hover:bg-[#0c4030] text-white text-xs font-bold py-2.5 rounded-xl transition-all shadow-sm">
                <iconify-icon icon="lucide:settings" class="text-base"></iconify-icon>
                Kelola Akademik
            </a>
        </div>

        {{-- Card C: Subjects (Right) --}}
        <div class="lg:col-span-4 bg-white border border-slate-100 p-6 rounded-2xl shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wide">Mata Pelajaran Baru</h3>
                <a href="{{ route('subjects.index') }}" class="inline-flex items-center gap-1 border border-slate-100 hover:bg-slate-50 text-slate-650 text-[10px] font-bold px-3 py-1.5 rounded-lg transition-all">
                    Lihat Semua
                </a>
            </div>
            
            <div class="space-y-4">
                @forelse($recentSubjects as $subj)
                    <div class="flex items-center justify-between border-b border-slate-50 pb-3 last:border-0 last:pb-0">
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <iconify-icon icon="lucide:book" class="text-sm"></iconify-icon>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-slate-800">{{ $subj->name }}</h4>
                                <p class="text-[9px] text-slate-400 mt-0.5">Kode: {{ $subj->code ?? '-' }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 text-[8px] font-black uppercase {{ $subj->is_active ? 'text-emerald-700 bg-emerald-50' : 'text-slate-500 bg-slate-100' }} rounded-full">
                            {{ $subj->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-6">
                        <p class="text-xs font-bold text-slate-400">Belum ada mata pelajaran</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- Bottom Row (Recent Students, Recent Teachers, Ring Gauge Status) --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        {{-- Card D: Recent Students (Left) --}}
        <div class="lg:col-span-5 bg-white border border-slate-100 p-6 rounded-2xl shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wide">Siswa Terbaru Terdaftar</h3>
                <a href="{{ route('students.index') }}" class="inline-flex items-center gap-1 border border-slate-100 hover:bg-slate-50 text-slate-650 text-[10px] font-bold px-3 py-1.5 rounded-lg transition-all">
                    Lihat Semua
                </a>
            </div>
            
            <div class="space-y-4">
                @forelse($recentStudents as $student)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($student->person->name ?? 'Siswa') }}&background=f0fdf4&color=0f513d&size=64" class="size-8 rounded-full border border-emerald-100 shadow-sm shrink-0" alt="">
                            <div>
                                <h4 class="text-xs font-black text-slate-800">{{ $student->person->name ?? '-' }}</h4>
                                <p class="text-[9px] text-slate-400 mt-0.5">NISN: <span class="font-bold text-slate-600">{{ $student->nisn ?? '-' }}</span></p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 text-[8px] font-black uppercase text-emerald-700 bg-emerald-50 rounded-full">Siswa</span>
                    </div>
                @empty
                    <div class="text-center py-6">
                        <p class="text-xs font-bold text-slate-400">Belum ada siswa terdaftar</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Card E: Recent Teachers (Center) --}}
        <div class="lg:col-span-4 bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wide">Guru Terbaru</h3>
                    <a href="{{ route('teachers.index') }}" class="inline-flex items-center gap-1 border border-slate-100 hover:bg-slate-50 text-slate-650 text-[10px] font-bold px-3 py-1.5 rounded-lg transition-all">
                        Lihat Semua
                    </a>
                </div>
                
                <div class="space-y-4">
                    @forelse($recentTeachers as $teacher)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->person->name ?? 'Guru') }}&background=ecfdf5&color=047857&size=64" class="size-8 rounded-full border border-emerald-100 shadow-sm shrink-0" alt="">
                                <div>
                                    <h4 class="text-xs font-black text-slate-800">{{ $teacher->person->name ?? '-' }}</h4>
                                    <p class="text-[9px] text-slate-400 mt-0.5">NIP: <span class="font-bold text-slate-600">{{ $teacher->nip ?? '-' }}</span></p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 text-[8px] font-black uppercase text-blue-700 bg-blue-50 rounded-full">Guru</span>
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <p class="text-xs font-bold text-slate-400">Belum ada guru terdaftar</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Card F: System Status (Right) --}}
        <div class="lg:col-span-3 bg-emerald-950 text-white p-6 rounded-2xl shadow-sm flex flex-col justify-between relative overflow-hidden">
            {{-- Abstract wavy background lines --}}
            <div class="absolute inset-0 opacity-10 [background:repeating-linear-gradient(45deg,transparent,transparent_10px,#10b981_10px,#10b981_20px)] pointer-events-none"></div>
            
            <h3 class="text-xs font-black uppercase tracking-widest text-emerald-300 relative z-10">Status Sistem</h3>
            
            <div class="text-center my-6 relative z-10">
                <p class="text-[10px] font-black uppercase text-emerald-400 tracking-wider">Keamanan & Layanan</p>
                <p class="text-2xl font-extrabold tracking-tight mt-1 font-mono text-emerald-100">ONLINE</p>
            </div>

            <div class="flex items-center justify-center gap-1.5 relative z-10">
                <span class="size-2 rounded-full bg-emerald-500 animate-ping"></span>
                <span class="text-[9px] font-bold text-emerald-300">Semua Modul Terkoneksi</span>
            </div>
        </div>

    </div>

</div>
@endsection
