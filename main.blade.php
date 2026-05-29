@php
    $kpis = config('ppdb_admin.dashboard_kpis', []);
@endphp

<x-admin-layout title="Ringkasan Operasional" :breadcrumbs="[['label' => 'Dashboard']]">
    <div class="space-y-8">

        {{-- KPI Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6" data-aos="fade-up">
            @foreach ($kpis as $kpi)
                <div class="bg-white p-6 rounded-lg border border-slate-100 shadow-sm transition-all hover:shadow-lg hover:-translate-y-1">
                    <div class="flex justify-between items-start mb-4">
                        <div @class([
                            'size-12 rounded-lg flex items-center justify-center shadow-lg',
                            'bg-emerald-900 text-white shadow-emerald-900/20' => ($kpi['tone'] ?? 'emerald') == 'emerald',
                            'bg-blue-600 text-white shadow-blue-600/20' => ($kpi['tone'] ?? 'emerald') == 'blue',
                            'bg-yellow-500 text-green-950 shadow-yellow-500/20' => ($kpi['tone'] ?? 'emerald') == 'amber',
                            'bg-red-600 text-white shadow-red-600/20' => ($kpi['tone'] ?? 'emerald') == 'red',
                        ])>
                            <iconify-icon icon="lucide:{{ $kpi['icon'] ?? 'bar-chart' }}" class="text-2xl"></iconify-icon>
                        </div>
                        <span class="text-xs font-black text-slate-300 uppercase">Live</span>
                    </div>
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">{{ $kpi['label'] }}</h3>
                    <p class="text-3xl font-black text-green-950">{{ number_format($kpiValues[$kpi['id']] ?? 0) }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Charts --}}
            <div class="lg:col-span-8 space-y-6" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white p-8 rounded-lg border border-slate-100 shadow-sm">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                        <div>
                            <h3 class="text-lg font-black text-green-950 uppercase tracking-wide">Tren Pendaftaran</h3>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Statistik pendaftar baru</p>
                        </div>
                        <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-lg">
                            <a href="{{ route('admin.dashboard', ['period' => 'weekly']) }}" 
                                @class(['px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-md transition-all', 'bg-white text-green-900 shadow-sm' => request('period', 'weekly') == 'weekly', 'text-slate-500 hover:text-slate-700' => request('period') != 'weekly'])>Mingguan</a>
                            <a href="{{ route('admin.dashboard', ['period' => 'monthly']) }}" 
                                @class(['px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-md transition-all', 'bg-white text-green-900 shadow-sm' => request('period') == 'monthly', 'text-slate-500 hover:text-slate-700' => request('period') != 'monthly'])>Bulanan</a>
                            <a href="{{ route('admin.dashboard', ['period' => 'yearly']) }}" 
                                @class(['px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-md transition-all', 'bg-white text-green-900 shadow-sm' => request('period') == 'yearly', 'text-slate-500 hover:text-slate-700' => request('period') != 'yearly'])>Tahunan</a>
                        </div>
                    </div>
                    <div class="pt-4">
                        <x-admin.chart-line-trend :points="$trend" />
                    </div>
                </div>
                
                <div class="bg-white p-8 rounded-lg border border-slate-100 shadow-sm">
                    <h3 class="text-lg font-black text-green-950 mb-8 uppercase tracking-wide">Distribusi Tahapan Siswa</h3>
                    <x-admin.chart-distribution :segments="$distribution" />
                </div>
            </div>

            {{-- Feeds --}}
            <div class="lg:col-span-4 space-y-6" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-white rounded-lg border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
                        <h3 class="font-black text-green-950 uppercase text-xs tracking-widest">Aktivitas Pendaftar</h3>
                        <iconify-icon icon="lucide:clock" class="text-slate-400"></iconify-icon>
                    </div>
                    <div class="p-6">
                        <x-admin.activity-feed :items="$activity" />
                    </div>
                </div>

                <div class="bg-emerald-950 rounded-lg border border-emerald-900 shadow-sm overflow-hidden text-white">
                    <div class="p-6 border-b border-white/5 flex items-center justify-between bg-white/5">
                        <h3 class="font-black text-yellow-500 uppercase text-xs tracking-widest">Sistem Log</h3>
                        <iconify-icon icon="lucide:scroll-text" class="text-emerald-500"></iconify-icon>
                    </div>
                    <div class="p-6">
                        <x-admin.system-log-panel :entries="$logs" />
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
