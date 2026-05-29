<aside id="application-sidebar-brand"
    class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full xl:rtl:-translate-x-0 rtl:translate-x-full  left-0 rtl:left-auto xl:rtl:right-5 rtl:right-0 transform hidden xl:block xl:translate-x-0 xl:end-auto xl:bottom-0 fixed top-0 with-vertical  left-sidebar transition-all duration-300 h-screen z-[2] flex-shrink-0  w-[270px] border-border dark:border-darkborder bg-white dark:bg-dark xl:top-5 xl:start-5 shadow-md xl:rounded-md">
    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
    <div class="p-3.5 flex justify-between">
        <div class="brand-logo d-flex align-items-center justify-center">
            <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
                <img src="{{ asset('assets/images/logos/data-center.png') }}" style="width: 50px" class="w-1/2"/>
            </a>
        </div>
        <div class="hide-menu">
            <h1 class="text-lg font-bold">DATA CENTER</h1>
            <p class="text-sm">Kelola data dengan efisien</p>
        </div>

    </div>
    <div class="scroll-sidebar" data-simplebar="">
        <div class="px-4 mt-5 mini-layout" data-te-sidenav-menu-ref>
            <x-admin.vertical-menu />
        </div>
    </div>

    @include('layouts.partials.admin.buttom-user-info')
</aside>

{{-- Active Menu Styles --}}
<style>

/* Active submenu item - colors handled by dynamic classes */
.dropdown-submenu a.active {
    font-weight: 600 !important;
}

.dropdown-submenu a.active .w-1\.5 {
    opacity: 1 !important;
}

/* Auto expand dropdown with active child */
.hs-accordion.sidebar-item.active .hs-accordion-content {
    /* display: block !important; */
}

.hs-accordion.sidebar-item.active .ti-chevron-right {
    display: none !important;
}

.hs-accordion.sidebar-item.active .ti-chevron-up {
    display: block !important;
}

/* Dark mode adjustments - colors handled by dynamic classes */
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
