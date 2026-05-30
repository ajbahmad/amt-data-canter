<aside id="application-sidebar-brand"
    class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full xl:rtl:-translate-x-0 rtl:translate-x-full left-0 rtl:left-auto xl:rtl:right-5 rtl:right-0 transform hidden xl:block xl:translate-x-0 xl:end-auto xl:bottom-0 fixed top-0 with-vertical left-sidebar transition-all duration-300 h-screen z-[2] flex-shrink-0 w-[270px] border-r border-slate-100 bg-white shadow-none">
    
    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
    
    {{-- Data Center Brand Logo Section --}}
    <div class="p-6 flex items-center gap-3">
        <div class="size-10 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-800 shadow-sm shrink-0">
            <img src="{{ asset('logo-amt.webp') }}" alt="" class="w-10 h-10">
        </div>
        <div class="hide-menu">
            <h1 class="text-lg font-bold">DATA CENTER</h1>
            <p class="text-sm" style="font-size: 0.9em">Kelola data dengan efisien</p>
        </div>
    </div>

    {{-- Vertical Sidebar Menus --}}
    <div class="scroll-sidebar flex-grow flex flex-col justify-between overflow-y-auto" data-simplebar="" style="height: calc(100vh - 200px);">
        <div class="px-4 mt-2 mini-layout" data-te-sidenav-menu-ref>
            <x-admin.vertical-menu />
        </div>

        {{-- Data Center Mobile App Promo Card --}}
        
    </div>

    {{-- Dynamic Bottom Profile Block --}}
    @include('layouts.partials.admin.buttom-user-info')
</aside>

{{-- Active Sidenav Styles --}}
<style>
/* Sidebar Styles */
#application-sidebar-brand {
    background-color: #ffffff !important;
    border-right: 1px solid #f1f5f9 !important;
    box-shadow: none !important;
    border-radius: 0 !important;
    top: 0 !important;
    left: 0 !important;
    height: 100vh !important;
    display: flex !important;
    flex-direction: column !important;
}

.sidebar-link {
    display: flex !important;
    align-items: center !important;
    gap: 0.75rem !important;
    padding: 0.75rem 1rem !important;
    border-radius: 0.5rem !important;
    font-size: 0.875rem !important;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    font-weight: 500 !important;
    color: #64748b !important; /* Cool grey text */
    transition: all 0.2s ease-in-out !important;
    border-left: 4px solid transparent !important;
    background-color: transparent !important;
}

.sidebar-link:hover {
    background-color: #f8fafc !important;
    color: #0f513d !important;
}

/* Handle recursive component's active states gracefully */
.sidebar-item.active > .sidebar-link,
.sidebar-link.active {
    background-color: #f0fdf4 !important; /* Light green tint */
    color: #0f513d !important; /* Bold green */
    font-weight: 700 !important;
    border-left: 4px solid #0f513d !important; /* Left border green */
}

.sidebar-label {
    font-size: 0.65rem !important;
    font-weight: 800 !important;
    letter-spacing: 0.1em !important;
    color: #94a3b8 !important;
    text-transform: uppercase !important;
    margin-top: 1.5rem !important;
    margin-bottom: 0.5rem !important;
    padding-left: 1rem !important;
}

.dropdown-submenu a.active {
    font-weight: 700 !important;
    color: #0f513d !important;
}

.dropdown-submenu a.active .w-1\.5 {
    opacity: 1 !important;
}
</style>

{{-- Active Menu JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-expand accordion if it has active child
    const activeAccordions = document.querySelectorAll('.hs-accordion.sidebar-item.active');

    activeAccordions.forEach(accordion => {
        const content = accordion.querySelector('.hs-accordion-content');
        const chevronRight = accordion.querySelector('.ti-chevron-right');
        const chevronUp = accordion.querySelector('.ti-chevron-up');

        if (content) {
            // Add hs-accordion-active class to show content
            accordion.classList.add('hs-accordion-active');
            content.style.display = 'block';

            // Update chevron icons
            if (chevronRight) chevronRight.style.display = 'none';
            if (chevronUp) chevronUp.style.display = 'block';
        }
    });

    // Smooth scroll to active menu item
    const activeMenuItem = document.querySelector('.sidebar-link.active');
    if (activeMenuItem) {
        setTimeout(() => {
            activeMenuItem.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }, 100);
    }
});
</script>
