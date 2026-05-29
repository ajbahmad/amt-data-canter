@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Title and Top Buttons --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Plan, prioritize, and accomplish your tasks with ease.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="inline-flex items-center gap-2 bg-[#0f513d] hover:bg-[#0c4030] text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-sm">
                <iconify-icon icon="lucide:plus" class="text-base"></iconify-icon>
                Add Project
            </button>
            <button class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-[#0f513d] border border-[#0f513d]/20 text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-sm">
                Import Data
            </button>
        </div>
    </div>

    {{-- Donezo KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Card 1: Total Projects --}}
        <div class="bg-[#0f513d] text-white p-6 rounded-2xl relative overflow-hidden shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <span class="text-xs font-semibold text-emerald-100">Total Projects</span>
                <span class="size-8 rounded-full bg-white/10 flex items-center justify-center text-white">
                    <iconify-icon icon="lucide:arrow-up-right" class="text-sm"></iconify-icon>
                </span>
            </div>
            <p class="text-4xl font-extrabold tracking-tight mb-2">24</p>
            <p class="text-[10px] font-bold text-emerald-300 flex items-center gap-1">
                <iconify-icon icon="lucide:arrow-up-right" class="text-xs"></iconify-icon>
                Increased from last month
            </p>
        </div>

        {{-- Card 2: Ended Projects --}}
        <div class="bg-white border border-slate-100 p-6 rounded-2xl relative overflow-hidden shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <span class="text-xs font-bold text-slate-400">Ended Projects</span>
                <span class="size-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-800">
                    <iconify-icon icon="lucide:arrow-up-right" class="text-sm"></iconify-icon>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-slate-850 tracking-tight mb-2">10</p>
            <p class="text-[10px] font-bold text-emerald-600 flex items-center gap-1">
                <iconify-icon icon="lucide:arrow-up-right" class="text-xs"></iconify-icon>
                Increased from last month
            </p>
        </div>

        {{-- Card 3: Running Projects --}}
        <div class="bg-white border border-slate-100 p-6 rounded-2xl relative overflow-hidden shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <span class="text-xs font-bold text-slate-400">Running Projects</span>
                <span class="size-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-800">
                    <iconify-icon icon="lucide:arrow-up-right" class="text-sm"></iconify-icon>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-slate-850 tracking-tight mb-2">12</p>
            <p class="text-[10px] font-bold text-emerald-600 flex items-center gap-1">
                <iconify-icon icon="lucide:arrow-up-right" class="text-xs"></iconify-icon>
                Increased from last month
            </p>
        </div>

        {{-- Card 4: Pending Project --}}
        <div class="bg-white border border-slate-100 p-6 rounded-2xl relative overflow-hidden shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <span class="text-xs font-bold text-slate-400">Pending Project</span>
                <span class="size-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-800">
                    <iconify-icon icon="lucide:arrow-up-right" class="text-sm"></iconify-icon>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-slate-850 tracking-tight mb-2">2</p>
            <p class="text-[10px] font-bold text-amber-600 flex items-center gap-1">
                On Discuss
            </p>
        </div>
    </div>

    {{-- Middle Row (Project Analytics, Reminders, Project) --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        {{-- Card A: Project Analytics (Left) --}}
        <div class="lg:col-span-5 bg-white border border-slate-100 p-6 rounded-2xl shadow-sm">
            <h3 class="text-sm font-extrabold text-slate-800 mb-6 uppercase tracking-wide">Project Analytics</h3>
            <div class="flex items-end justify-between h-48 px-2 relative">
                
                {{-- Dynamic patterned visual columns --}}
                <div class="flex flex-col items-center gap-2 w-full">
                    <div class="w-8 bg-slate-50 border border-dashed border-emerald-500/30 rounded-t-lg h-24 relative overflow-hidden">
                        <div class="absolute inset-0 bg-emerald-500/10 [background:repeating-linear-gradient(45deg,transparent,transparent_4px,#10b981_4px,#10b981_8px)] opacity-20"></div>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400">S</span>
                </div>

                <div class="flex flex-col items-center gap-2 w-full">
                    <div class="w-8 bg-[#0f513d] rounded-t-lg h-36"></div>
                    <span class="text-[10px] font-bold text-slate-400">M</span>
                </div>

                <div class="flex flex-col items-center gap-2 w-full">
                    <div class="w-8 bg-[#10b981] rounded-t-lg h-28 relative flex items-center justify-center">
                        <span class="absolute -top-6 px-1 py-0.5 bg-slate-50 border border-slate-100 rounded text-[8px] font-black text-emerald-800">74%</span>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400">T</span>
                </div>

                <div class="flex flex-col items-center gap-2 w-full">
                    <div class="w-8 bg-emerald-950 rounded-t-lg h-40"></div>
                    <span class="text-[10px] font-bold text-slate-400">W</span>
                </div>

                <div class="flex flex-col items-center gap-2 w-full">
                    <div class="w-8 bg-slate-50 border border-dashed border-emerald-500/30 rounded-t-lg h-20 relative overflow-hidden">
                        <div class="absolute inset-0 bg-emerald-500/10 [background:repeating-linear-gradient(45deg,transparent,transparent_4px,#10b981_4px,#10b981_8px)] opacity-20"></div>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400">T</span>
                </div>

                <div class="flex flex-col items-center gap-2 w-full">
                    <div class="w-8 bg-slate-50 border border-dashed border-[#0f513d]/20 rounded-t-lg h-32 relative overflow-hidden">
                        <div class="absolute inset-0 bg-[#0f513d]/10 [background:repeating-linear-gradient(-45deg,transparent,transparent_4px,#0f513d_4px,#0f513d_8px)] opacity-20"></div>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400">F</span>
                </div>

                <div class="flex flex-col items-center gap-2 w-full">
                    <div class="w-8 bg-slate-50 border border-dashed border-emerald-500/30 rounded-t-lg h-24 relative overflow-hidden">
                        <div class="absolute inset-0 bg-emerald-500/10 [background:repeating-linear-gradient(45deg,transparent,transparent_4px,#10b981_4px,#10b981_8px)] opacity-20"></div>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400">S</span>
                </div>

            </div>
        </div>

        {{-- Card B: Reminders (Center) --}}
        <div class="lg:col-span-3 bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between">
            <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wide">Reminders</h3>
            <div class="my-4 space-y-2">
                <h4 class="text-base font-black text-[#0f513d]">Meeting with Arc Company</h4>
                <p class="text-xs font-semibold text-slate-400">Time: 02.00 pm - 04.00 pm</p>
            </div>
            <button class="w-full inline-flex items-center justify-center gap-2 bg-[#0f513d] hover:bg-[#0c4030] text-white text-xs font-bold py-2.5 rounded-xl transition-all shadow-sm">
                <iconify-icon icon="lucide:video" class="text-base"></iconify-icon>
                Start Meeting
            </button>
        </div>

        {{-- Card C: Project (Right) --}}
        <div class="lg:col-span-4 bg-white border border-slate-100 p-6 rounded-2xl shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wide">Project</h3>
                <button class="inline-flex items-center gap-1 border border-slate-100 hover:bg-slate-50 text-slate-650 text-[10px] font-bold px-3 py-1.5 rounded-lg transition-all">
                    <iconify-icon icon="lucide:plus" class="text-[10px]"></iconify-icon>
                    New
                </button>
            </div>
            
            <div class="space-y-4">
                {{-- Item 1 --}}
                <div class="flex items-center justify-between border-b border-slate-50 pb-3 last:border-0 last:pb-0">
                    <div class="flex items-center gap-3">
                        <div class="size-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <iconify-icon icon="lucide:code-2" class="text-sm"></iconify-icon>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-slate-800">Develop API Endpoints</h4>
                            <p class="text-[9px] text-slate-400 mt-0.5">Due date: Nov 26, 2024</p>
                        </div>
                    </div>
                </div>

                {{-- Item 2 --}}
                <div class="flex items-center justify-between border-b border-slate-50 pb-3 last:border-0 last:pb-0">
                    <div class="flex items-center gap-3">
                        <div class="size-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                            <iconify-icon icon="lucide:users" class="text-sm"></iconify-icon>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-slate-800">Onboarding Flow</h4>
                            <p class="text-[9px] text-slate-400 mt-0.5">Due date: Nov 28, 2024</p>
                        </div>
                    </div>
                </div>

                {{-- Item 3 --}}
                <div class="flex items-center justify-between border-b border-slate-50 pb-3 last:border-0 last:pb-0">
                    <div class="flex items-center gap-3">
                        <div class="size-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                            <iconify-icon icon="lucide:palette" class="text-sm"></iconify-icon>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-slate-800">Build Dashboard</h4>
                            <p class="text-[9px] text-slate-400 mt-0.5">Due date: Nov 30, 2024</p>
                        </div>
                    </div>
                </div>

                {{-- Item 4 --}}
                <div class="flex items-center justify-between border-b border-slate-50 pb-3 last:border-0 last:pb-0">
                    <div class="flex items-center gap-3">
                        <div class="size-8 rounded-lg bg-emerald-50 text-[#0f513d] flex items-center justify-center shrink-0">
                            <iconify-icon icon="lucide:gauge" class="text-sm"></iconify-icon>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-slate-800">Optimize Page Load</h4>
                            <p class="text-[9px] text-slate-400 mt-0.5">Due date: Dec 5, 2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Bottom Row (Team Collaboration, Project Progress, Time Tracker) --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        {{-- Card D: Team Collaboration (Left) --}}
        <div class="lg:col-span-5 bg-white border border-slate-100 p-6 rounded-2xl shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wide">Team Collaboration</h3>
                <button class="inline-flex items-center gap-1 border border-slate-100 hover:bg-slate-50 text-slate-650 text-[10px] font-bold px-3 py-1.5 rounded-lg transition-all">
                    <iconify-icon icon="lucide:plus" class="text-[10px]"></iconify-icon>
                    Add Member
                </button>
            </div>
            
            <div class="space-y-4">
                {{-- Member 1 --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Alexandra+Deff&background=fdf2f8&color=db2777&size=64" class="size-8 rounded-full border border-pink-100 shadow-sm shrink-0" alt="">
                        <div>
                            <h4 class="text-xs font-black text-slate-800">Alexandra Deff</h4>
                            <p class="text-[9px] text-slate-400 mt-0.5">Working on <strong class="text-slate-600 font-bold">Github Project Repository</strong></p>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 text-[8px] font-black uppercase text-emerald-700 bg-emerald-50 rounded-full">Completed</span>
                </div>

                {{-- Member 2 --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Edwin+Adenike&background=ecfdf5&color=047857&size=64" class="size-8 rounded-full border border-emerald-100 shadow-sm shrink-0" alt="">
                        <div>
                            <h4 class="text-xs font-black text-slate-800">Edwin Adenike</h4>
                            <p class="text-[9px] text-slate-400 mt-0.5">Working on <strong class="text-slate-600 font-bold">Integrate User Authentication System</strong></p>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 text-[8px] font-black uppercase text-amber-700 bg-amber-50 rounded-full">In Progress</span>
                </div>

                {{-- Member 3 --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Isaac+O&background=eff6ff&color=1d4ed8&size=64" class="size-8 rounded-full border border-blue-100 shadow-sm shrink-0" alt="">
                        <div>
                            <h4 class="text-xs font-black text-slate-800">Isaac Oluwatemilorun</h4>
                            <p class="text-[9px] text-slate-400 mt-0.5">Working on <strong class="text-slate-600 font-bold">Develop Search and Filter Functionality</strong></p>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 text-[8px] font-black uppercase text-red-750 bg-red-50 rounded-full">Pending</span>
                </div>
            </div>
        </div>

        {{-- Card E: Project Progress (Center) --}}
        <div class="lg:col-span-4 bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between">
            <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wide">Project Progress</h3>
            
            {{-- Donezo Semi-circular radial gauge in pure CSS/SVG --}}
            <div class="relative flex flex-col items-center justify-center my-4">
                <svg class="w-40 h-24" viewBox="0 0 100 50">
                    {{-- Base semicircle path --}}
                    <path d="M 10 50 A 40 40 0 0 1 90 50" fill="none" stroke="#e2e8f0" stroke-width="12" stroke-linecap="round"/>
                    {{-- Progress path (41%) --}}
                    <path d="M 10 50 A 40 40 0 0 1 50 15" fill="none" stroke="#0f513d" stroke-width="12" stroke-linecap="round"/>
                </svg>
                <div class="absolute bottom-2 text-center">
                    <p class="text-2xl font-black text-slate-850">41%</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wide">Project Ended</p>
                </div>
            </div>

            <div class="flex items-center justify-center gap-4 text-[9px] font-black uppercase text-slate-400 tracking-wider">
                <div class="flex items-center gap-1.5">
                    <span class="size-2 rounded-full bg-emerald-500"></span> Completed
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="size-2 rounded-full bg-[#0f513d]"></span> In Progress
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="size-2 rounded-full bg-slate-200"></span> Pending
                </div>
            </div>
        </div>

        {{-- Card F: Time Tracker (Right) --}}
        <div class="lg:col-span-3 bg-emerald-950 text-white p-6 rounded-2xl shadow-sm flex flex-col justify-between relative overflow-hidden">
            {{-- Abstract wavy background lines --}}
            <div class="absolute inset-0 opacity-10 [background:repeating-linear-gradient(45deg,transparent,transparent_10px,#10b981_10px,#10b981_20px)] pointer-events-none"></div>
            
            <h3 class="text-xs font-black uppercase tracking-widest text-emerald-300 relative z-10">Time Tracker</h3>
            
            <div class="text-center my-6 relative z-10">
                <p class="text-3xl font-extrabold tracking-widest font-mono">01:24:08</p>
            </div>

            <div class="flex items-center justify-center gap-3 relative z-10">
                <button class="size-10 rounded-full bg-white text-emerald-900 flex items-center justify-center hover:scale-105 transition-all shadow-sm">
                    <iconify-icon icon="lucide:pause" class="text-base"></iconify-icon>
                </button>
                <button class="size-10 rounded-full bg-red-600 text-white flex items-center justify-center hover:scale-105 transition-all shadow-sm">
                    <iconify-icon icon="lucide:square" class="text-base"></iconify-icon>
                </button>
            </div>
        </div>

    </div>

</div>
@endsection
