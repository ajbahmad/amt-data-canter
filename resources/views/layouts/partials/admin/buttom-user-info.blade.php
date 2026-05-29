<!-- Bottom User Profile -->
<div class="px-4 py-4 relative hide-menu border-t border-slate-100">
    <div class="flex items-center gap-3">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=f0fdf4&color=0f513d&size=64" class="h-10 w-10 rounded-full border-2 border-emerald-100 object-cover shadow-sm shrink-0" alt="profile" />
        <div class="min-w-0 flex-grow">
            <h5 class="text-xs font-black text-slate-800 truncate leading-snug">{{ auth()->user()->name }}</h5>
            <p class="text-[10px] font-semibold text-slate-400 truncate mt-0.5">{{ auth()->user()->email }}</p>
        </div>
        <button type="button" class="text-slate-400 hover:text-emerald-700 flex items-center p-1.5 rounded-lg hover:bg-slate-50 transition-colors shrink-0" data-hs-overlay="#hs-vertically-centered-modal" title="Keluar">
            <iconify-icon icon="solar:logout-line-duotone" class="text-xl"></iconify-icon>
        </button>
    </div>
</div>
