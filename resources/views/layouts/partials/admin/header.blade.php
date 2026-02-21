<!--  Header Start -->
<header
    class="sticky top-0 inset-x-0 z-[2] flex flex-wrap md:justify-start md:flex-nowrap text-fs_15 py-3 lg:py-0 mb-6 bg-white dark:bg-dark rounded-md shadow-md">
    <div class="with-vertical w-full">
        <div class="w-full mx-auto px-4 lg:px-6" aria-label="Global">
            <div class="relative md:flex md:items-center md:justify-between">
                <div class="hs-collapse  grow md:block">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2 lg:w-auto w-full justify-between">

                            <div class="relative">
                                <a class="xl:flex hidden text-xl icon-hover cursor-pointer text-link dark:text-darklink sidebartoggler h-10 w-10 hover:text-primary hover:bg-lightprimary dark:hover:bg-darkprimary  justify-center items-center rounded-full"
                                    id="headerCollapse" href="javascript:void(0)">
                                    <iconify-icon icon="solar:list-bold-duotone" class="text-2xl relative z-[1]"></iconify-icon>
                                </a>
                                <!--Mobile Sidebar Toggle -->
                                <div class="sticky top-0 inset-x-0 xl:hidden">
                                    <div class="flex items-center">
                                        <!-- Navigation Toggle -->
                                        <a class="text-xl icon-hover cursor-pointer text-link dark:text-darklink sidebartoggler h-10 w-10 hover:text-primary hover:bg-lightprimary dark:hover:bg-darkprimary flex justify-center items-center rounded-full"
                                            data-hs-overlay="#application-sidebar-brand"
                                            aria-controls="application-sidebar-brand" aria-label="Toggle navigation">
                                            <iconify-icon icon="solar:list-bold-duotone"
                                                class="text-2xl relative z-[1]"></iconify-icon>
                                        </a>
                                        <!-- End Navigation Toggle -->
                                    </div>
                                </div>
                                <!-- End Sidebar Toggle -->
                            </div>

                            <div class="flex lg:hidden  md:w-fit overflow-hidden">
                                <div class="brand-logo d-flex align-items-center justify-center">
                                    <a href="{{ route('admin.dashboard') }}" class="text-nowrap logo-img">
                                        <img src="{{ asset('assets/images/logos/logo-light.svg') }}"
                                            class="dark:hidden block rtl:hidden" alt="Logo-Dark" />
                                        <img src="{{ asset('assets/images/logos/logo-dark.svg') }}"
                                            class="dark:block hidden rtl:hidden rtl:dark:hidden" alt="Logo-light" />
                                        <img src="{{ asset('assets/images/logos/logo-light-rtl.svg') }}"
                                            class="dark:hidden hidden rtl:block rtl:dark:hidden" alt="Logo-Dark" />
                                        <img src="{{ asset('assets/images/logos/logo-dark-rtl.svg') }}"
                                            class="dark:hidden hidden rtl:hidden rtl:dark:block" alt="Logo-light" />
                                    </a>
                                </div>
                            </div>

                            <div class="lg:hidden">
                                <button type="button"
                                    class="p-2 hs-collapse-toggle inline-flex h-10 w-10 text-link dark:text-darklink hover:text-primary hover:bg-lightprimary dark:hover:bg-darkprimary  justify-center items-center rounded-full"
                                    data-hs-collapse="#hs-basic-collapse-heading" aria-label="Toggle navigation">
                                    <i class="ti ti-dots text-xl"></i>
                                </button>
                            </div>

                            <!-- Menu-->
                            <div id="navbar-offcanvas-example lg:block hidden"
                                class="hs-overlay hs-overlay-open:translate-x-0 z-[2] -translate-x-full fixed top-0 start-0 transition-all duration-300 transform h-full max-w-xs bg-white dark:bg-dark  basis-full grow sm:order-1 lg:static lg:block lg:h-auto sm:max-w-none w-[270px] lg:border-r-transparent lg:transition-none lg:translate-x-0  lg:basis-auto hidden "
                                tabindex="-1" data-hs-overlay-close-on-resize>
                                <div class="lg:flex gap-2 h-[70px]  items-center ">
                                    <div class="flex lg:hidden lg:p-0 p-5">
                                        <div class="brand-logo d-flex align-items-center justify-center">
                                            <a href="{{ route('admin.dashboard') }}" class="text-nowrap logo-img">
                                                <img src="{{ asset('assets/images/logos/logo-light.svg') }}"
                                                    class="dark:hidden block rtl:hidden" alt="Logo-Dark" />
                                                <img src="{{ asset('assets/images/logos/logo-dark.svg') }}"
                                                    class="dark:block hidden rtl:hidden rtl:dark:hidden"
                                                    alt="Logo-light" />
                                                <img src="{{ asset('assets/images/logos/logo-light-rtl.svg') }}"
                                                    class="dark:hidden hidden rtl:block rtl:dark:hidden"
                                                    alt="Logo-Dark" />
                                                <img src="{{ asset('assets/images/logos/logo-dark-rtl.svg') }}"
                                                    class="dark:hidden hidden rtl:hidden rtl:dark:block"
                                                    alt="Logo-light" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="icon-nav items-center gap-2  lg:flex hidden">

                            <!-- Theme Toggle  -->
                            <button type="button"
                                class="hs-dark-mode-active:hidden icon-hover block hs-dark-mode group items-center font-medium hover:text-primary text-link dark:text-darklink h-10 w-10 hover:bg-lightprimary dark:hover:bg-darkprimary  justify-center rounded-full"
                                data-hs-theme-click-value="dark" id="dark-layout">
                                <iconify-icon icon="solar:moon-line-duotone"
                                    class=" text-2xl  text-link dark:text-darklink relative  hover:text-primary"></iconify-icon>
                            </button>
                            <button type="button"
                                class="hs-dark-mode-active:block icon-hover hidden hs-dark-mode group  items-center  font-medium hover:text-primary text-link dark:text-darklink h-10 w-10 hover:bg-lightprimary dark:hover:bg-darkprimary  justify-center rounded-full"
                                data-hs-theme-click-value="light" id="light-layout">
                                <iconify-icon icon="solar:sun-2-line-duotone"
                                    class=" text-2xl  text-link dark:text-darklink relative  hover:text-primary"></iconify-icon>
                            </button>

                            <!-- Notifications DD -->
                            <div
                                class="hs-dropdown xl:[--strategy:absolute] [--adaptive:none] md:[--trigger:hover] sm:relative group/menu">
                                <a id="hs-dropdown-hover-event-notification"
                                    class="relative hs-dropdown-toggle h-10 w-10 text-link dark:text-darklink cursor-pointer hover:bg-lightprimary  hover:text-primary dark:hover:bg-darkprimary flex justify-center items-center rounded-full group-hover/menu:bg-lightprimary group-hover/menu:text-primary">
                                    <iconify-icon icon="solar:bell-bing-line-duotone"
                                        class="text-2xl relative z-[1]"></iconify-icon>
                                    <span class="flex absolute top-2 end-3 -mt-0.5 -me-2">
                                        <span
                                            class="animate-ping absolute inline-flex size-full rounded-full bg-teal-400 opacity-75 dark:bg-teal-600"></span>
                                        <span
                                            class="relative inline-flex text-xs bg-teal-500 text-white rounded-full py-0.5 px-1">
                                            <div class="h-1 rounded-full bg-primary"></div>
                                        </span>
                                    </span>
                                </a>
                                <div class="card hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 right-0 rtl:right-auto rtl:left-0 mt-2 min-w-max top-auto w-full sm:w-[360px] hidden z-[2]"
                                    aria-labelledby="hs-dropdown-hover-event-notification">
                                    <div class="flex items-center pt-6 px-7 gap-4">
                                        <h3 class="mb-0 text-lg font-semibold ">Notifikasi</h3>
                                        <span class="py-1 px-3 border-0 badge text-xs font-medium bg-warning text-white">5</span>
                                    </div>
                                    <div class="message-body max-h-[320px] pt-4" data-simplebar>
                                        <a href="javascript:void(0)"
                                            class="dropdown-item px-7 py-3 flex items-center bg-hover">
                                            <span
                                                class="flex-shrink-0 h-12 w-12 rounded-full bg-lightprimary dark:bg-darkprimary flex justify-center items-center">
                                                <iconify-icon icon="solar:widget-3-line-duotone"
                                                    class="text-primary text-xl"></iconify-icon>
                                            </span>
                                            <div class="ps-4">
                                                <h5 class="font-medium text-sm">
                                                    Launch Admin
                                                </h5>
                                                <span class="text-xs block my-0.5">Just see the my new
                                                    admin!</span>
                                                <p class="text-xs">9.00 AM</p>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="dropdown-item px-7 py-3 flex items-center bg-hover">
                                            <span
                                                class="flex-shrink-0 h-12 w-12 rounded-full bg-lightsuccess dark:bg-darksuccess flex justify-center items-center">
                                                <iconify-icon icon="solar:user-circle-outline"
                                                    class="text-success text-xl"></iconify-icon>
                                            </span>
                                            <div class="ps-4">
                                                <h5 class="font-medium text-sm ">
                                                    Meeting Today
                                                </h5>
                                                <span class="text-xs block my-0.5">Just a reminder that you have
                                                    meeting</span>
                                                <p class="text-xs">10.00 AM</p>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="dropdown-item px-7 py-3 flex items-center bg-hover">
                                            <span
                                                class="flex-shrink-0 h-12 w-12 rounded-full bg-lighterror dark:bg-darkerror flex justify-center items-center">
                                                <iconify-icon icon="solar:calendar-line-duotone"
                                                    class="text-error text-xl"></iconify-icon>
                                            </span>
                                            <div class="ps-4">
                                                <h5 class="font-medium text-sm ">
                                                    Go for Event
                                                </h5>
                                                <span class="text-xs block my-0.5">Just a reminder that you have
                                                    event</span>
                                                <p class="text-xs">09.00 AM</p>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="dropdown-item px-7 py-3 flex items-center bg-hover">
                                            <span
                                                class="flex-shrink-0 h-12 w-12 rounded-full bg-lightindigo dark:bg-darkindigo flex justify-center items-center">
                                                <iconify-icon icon="solar:dollar-line-duotone"
                                                    class="text-indigo text-xl"></iconify-icon>
                                            </span>
                                            <div class="ps-4">
                                                <h5 class="font-medium text-sm ">
                                                    Pay Bills
                                                </h5>
                                                <span class="text-xs block my-0.5">Just a reminder that you have pay
                                                </span>
                                                <p class="text-xs">11.00 AM</p>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="dropdown-item px-7 py-3 flex items-center bg-hover">
                                            <span
                                                class="flex-shrink-0 h-12 w-12 rounded-full bg-lightinfo dark:bg-darkinfo flex justify-center items-center">
                                                <iconify-icon icon="solar:settings-linear"
                                                    class="text-info text-xl"></iconify-icon>
                                            </span>
                                            <div class="ps-4">
                                                <h5 class="font-medium text-sm ">
                                                    Settings
                                                </h5>
                                                <span class="text-xs block my-0.5">You can customize the
                                                    template</span>
                                                <p class="text-xs">12.00 AM</p>
                                            </div>
                                        </a>

                                    </div>
                                    <div class="pt-3 pb-6 px-7">
                                        <a href="#" class="btn w-full block">
                                            Lihat Semua Notifikasi
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Profile DD -->
                            <div
                                class="hs-dropdown xl:[--strategy:absolute] [--adaptive:none] md:[--trigger:hover] sm:relative ms-3">
                                <a id="hs-dropdown-hover-event-profile"
                                    class="relative hs-dropdown-toggle cursor-pointer align-middle rounded-full">
                                    <div class="flex gap-4">
                                        <div class="relative">
                                            @if(Auth::check() && Auth::user()->photo)
                                                <img class="object-cover w-11 h-11 rounded-full" src="{{ asset('storage/' . Auth::user()->photo) }}" alt="User Profile" aria-hidden="true">
                                            @else
                                                <img class="object-cover w-11 h-11 rounded-full" src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Default Profile" aria-hidden="true">
                                            @endif
                                            <span class="h-3.5 w-3.5 rounded-full bg-success block absolute top-0 -end-1 border-2 border-white dark:border-dark"></span>
                                        </div>
                                        @if(Auth::check())
                                            <div class="hidden sm:block">
                                                <h6 class="font-bold text-dark dark:text-white text-base mb-1 profile-name">
                                                    {{ Auth::user()->name }}
                                                </h6>
                                                <p class="text-sm leading-tight mb-0 text-link dark:text-darklink">
                                                    {{ Auth::user()->role ?? 'User' }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                <div class="card hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 mt-2 min-w-max top-auto right-0 rtl:right-auto rtl:left-0 w-full sm:w-[385px] hidden z-[2] border-none "
                                    aria-labelledby="hs-dropdown-hover-event-profile">
                                    <div class="card-body p-7">
                                        <div class="flex items-center pb-5 justify-between">
                                            <h3 class="mb-0 text-lg font-semibold text-dark dark:text-white">User Profile</h3>
                                        </div>
                                        <div class="message-body max-h-[450px]" data-simplebar>
                                            <div class>
                                                <div class="flex items-center gap-6 pb-5 border-b dark:border-darkborder">
                                                    @if(Auth::check() && Auth::user()->photo)
                                                        <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                                                            class="h-[90px] w-[90px] rounded-full object-cover"
                                                            alt="User Profile">
                                                    @else
                                                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}"
                                                            class="h-[90px] w-[90px] rounded-full object-cover"
                                                            alt="Default Profile">
                                                    @endif
                                                    <div class>
                                                        @if(Auth::check())
                                                            <h5 class="card-title">
                                                                {{ Auth::user()->name }}
                                                            </h5>
                                                            <span class="card-subtitle">{{ Auth::user()->role ?? 'User' }}</span>
                                                            <p class="mb-0 mt-1 flex items-center">
                                                                <iconify-icon icon="solar:mailbox-line-duotone" class="text-base me-1"></iconify-icon>
                                                                {{ Auth::user()->email }}
                                                            </p>
                                                        @else
                                                            <h5 class="card-title">
                                                                Guest
                                                            </h5>
                                                            <span class="card-subtitle">User</span>
                                                            <p class="mb-0 mt-1 flex items-center">
                                                                <iconify-icon icon="solar:mailbox-line-duotone" class="text-base me-1"></iconify-icon>
                                                                -
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <ul class="mt-3 flex flex-col gap-3.5">
                                                    <li>
                                                        <a href="/admin/profile"
                                                            class="flex gap-5 items-center bg-hover relative group p-2 rounded-sm">
                                                            <span
                                                                class="bg-lightinfo dark:bg-darkinfo p-2 hover:bg-info group text-info hover:text-white rounded-sm flex justify-center items-center">
                                                                <iconify-icon icon="solar:wallet-2-line-duotone"
                                                                    class="text-2xl "></iconify-icon>
                                                            </span>

                                                            <div>
                                                                <h6
                                                                    class="font-medium text-base leading-tight mb-1  group-hover:text-primary">
                                                                    My Profile
                                                                </h6>
                                                                <p class="text-sm  font-normal leading-tight">
                                                                    Account settings</p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="mt-5">
                                            {{-- <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                                @csrf --}}
                                                <button type="submit" class="btn w-full block" data-hs-overlay="#hs-vertically-centered-modal">
                                                    Log Out
                                                </button>
                                            {{-- </form> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:hidden block">
                <div id="hs-basic-collapse-heading"
                    class="hs-collapse hidden w-full overflow-hidden transition-[height] duration-300"
                    aria-labelledby="hs-basic-collapse">
                    <div class="mt-2">
                        <div class="flex justify-between items-center">
                            <div class="lg:hidden flex items-center"></div>
                            <div class="flex items-center gap-1">
                                <!-- Theme Toggle  -->
                                <button type="button"
                                    class="hs-dark-mode-active:hidden icon-hover h-10 w-10 block hs-dark-mode group items-center font-medium hover:text-primary text-link dark:text-darklink hover:bg-lightprimary dark:hover:bg-darkprimary  justify-center rounded-full"
                                    data-hs-theme-click-value="dark" id="dark-layout">
                                    <iconify-icon icon="solar:moon-line-duotone"
                                        class="text-2xl  text-link dark:text-darklink relative  hover:text-primary"></iconify-icon>
                                </button>
                                <button type="button"
                                    class="hs-dark-mode-active:block icon-hover h-10 w-10 hidden hs-dark-mode group  items-center  font-medium hover:text-primary text-link dark:text-darklink hover:bg-lightprimary dark:hover:bg-darkprimary  justify-center rounded-full"
                                    data-hs-theme-click-value="light" id="light-layout">
                                    <iconify-icon icon="solar:sun-2-line-duotone"
                                        class="text-2xl  text-link dark:text-darklink relative  hover:text-primary"></iconify-icon>
                                </button>

                                <!-- Notifications DD -->

                                <div
                                    class="hs-dropdown xl:[--strategy:absolute] [--adaptive:none] md:[--trigger:hover] sm:relative group/menu">
                                    <a id="hs-dropdown-hover-event-notification"
                                        class="relative hs-dropdown-toggle h-10 w-10 text-link dark:text-darklink cursor-pointer hover:bg-lightprimary  hover:text-primary dark:hover:bg-darkprimary flex justify-center items-center rounded-full group-hover/menu:bg-lightprimary group-hover/menu:text-primary">
                                        <iconify-icon icon="solar:bell-bing-line-duotone"
                                            class="text-2xl relative z-[1]"></iconify-icon>
                                        <span class="flex absolute top-2 end-3 -mt-0.5 -me-2">
                                            <span
                                                class="animate-ping absolute inline-flex size-full rounded-full bg-teal-400 opacity-75 dark:bg-teal-600"></span>
                                            <span
                                                class="relative inline-flex text-xs bg-teal-500 text-white rounded-full py-0.5 px-1">
                                                <div class="h-1 rounded-full bg-primary"></div>
                                            </span>
                                        </span>
                                    </a>
                                    <div class="card hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 right-0 rtl:right-auto rtl:left-0 mt-2 min-w-max top-auto w-full sm:w-[360px] hidden z-[2]"
                                        aria-labelledby="hs-dropdown-hover-event-notification">
                                        <div class="flex items-center pt-6 px-7 gap-4">
                                            <h3 class="mb-0 text-lg font-semibold ">
                                                Notifications</h3>
                                            <span
                                                class="py-1 px-3 border-0 badge text-xs font-medium bg-warning text-white">5
                                                new</span>
                                        </div>
                                        <div class="message-body max-h-[320px] pt-4" data-simplebar>
                                            <a href="javascript:void(0)"
                                                class="dropdown-item px-7 py-3 flex items-center bg-hover">
                                                <span
                                                    class="flex-shrink-0 h-12 w-12 rounded-full bg-lightprimary dark:bg-darkprimary flex justify-center items-center">
                                                    <iconify-icon icon="solar:widget-3-line-duotone"
                                                        class="text-primary text-xl"></iconify-icon>
                                                </span>
                                                <div class="ps-4">
                                                    <h5 class="font-medium text-sm">
                                                        Launch Admin
                                                    </h5>
                                                    <span class="text-xs block my-0.5">Just see the my new
                                                        admin!</span>
                                                    <p class="text-xs">9.00 AM</p>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)"
                                                class="dropdown-item px-7 py-3 flex items-center bg-hover">
                                                <span
                                                    class="flex-shrink-0 h-12 w-12 rounded-full bg-lightsuccess dark:bg-darksuccess flex justify-center items-center">
                                                    <iconify-icon icon="solar:user-circle-outline"
                                                        class="text-success text-xl"></iconify-icon>
                                                </span>
                                                <div class="ps-4">
                                                    <h5 class="font-medium text-sm ">
                                                        Meeting Today
                                                    </h5>
                                                    <span class="text-xs block my-0.5">Just a reminder that you have
                                                        meeting</span>
                                                    <p class="text-xs">10.00 AM</p>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)"
                                                class="dropdown-item px-7 py-3 flex items-center bg-hover">
                                                <span
                                                    class="flex-shrink-0 h-12 w-12 rounded-full bg-lighterror dark:bg-darkerror flex justify-center items-center">
                                                    <iconify-icon icon="solar:calendar-line-duotone"
                                                        class="text-error text-xl"></iconify-icon>
                                                </span>
                                                <div class="ps-4">
                                                    <h5 class="font-medium text-sm ">
                                                        Go for Event
                                                    </h5>
                                                    <span class="text-xs block my-0.5">Just a reminder that you have
                                                        event</span>
                                                    <p class="text-xs">09.00 AM</p>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)"
                                                class="dropdown-item px-7 py-3 flex items-center bg-hover">
                                                <span
                                                    class="flex-shrink-0 h-12 w-12 rounded-full bg-lightindigo dark:bg-darkindigo flex justify-center items-center">
                                                    <iconify-icon icon="solar:dollar-line-duotone"
                                                        class="text-indigo text-xl"></iconify-icon>
                                                </span>
                                                <div class="ps-4">
                                                    <h5 class="font-medium text-sm ">
                                                        Pay Bills
                                                    </h5>
                                                    <span class="text-xs block my-0.5">Just a reminder that you have
                                                        pay
                                                    </span>
                                                    <p class="text-xs">11.00 AM</p>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)"
                                                class="dropdown-item px-7 py-3 flex items-center bg-hover">
                                                <span
                                                    class="flex-shrink-0 h-12 w-12 rounded-full bg-lightinfo dark:bg-darkinfo flex justify-center items-center">
                                                    <iconify-icon icon="solar:settings-linear"
                                                        class="text-info text-xl"></iconify-icon>
                                                </span>
                                                <div class="ps-4">
                                                    <h5 class="font-medium text-sm ">
                                                        Settings
                                                    </h5>
                                                    <span class="text-xs block my-0.5">You can customize the
                                                        template</span>
                                                    <p class="text-xs">12.00 AM</p>
                                                </div>
                                            </a>

                                        </div>
                                        <div class="pt-3 pb-6 px-7">
                                            <a href="#" class="btn w-full block">
                                                See All Notification
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Profile DD -->
                                <div
                                    class="hs-dropdown xl:[--strategy:absolute] [--adaptive:none] md:[--trigger:hover] sm:relative ms-3">
                                    <a id="hs-dropdown-hover-event-profile"
                                        class="relative hs-dropdown-toggle cursor-pointer align-middle rounded-full">
                                        <div class="flex gap-4">
                                            <div class="relative">
                                                <img class="object-cover w-11 h-11 rounded-full"
                                                    src="{{ asset('assets/images/profile/user-1.jpg') }}" alt aria-hidden="true">
                                                <span
                                                    class="h-3.5 w-3.5 rounded-full bg-success block absolute top-0 -end-1 border-2 border-white dark:border-dark"></span>

                                            </div>
                                            <div class="hidden sm:block">
                                                <h6
                                                    class="font-bold text-dark dark:text-white text-base mb-1 profile-name">
                                                    Mike Nielsen
                                                </h6>
                                                <p class="text-sm leading-tight mb-0 text-link dark:text-darklink">
                                                    Admin
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="card hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 mt-2 min-w-max top-auto right-0 rtl:right-auto rtl:left-0 w-full sm:w-[385px] hidden z-[2] border-none "
                                        aria-labelledby="hs-dropdown-hover-event-profile">
                                        <div class="card-body p-7">
                                            <div class="flex items-center pb-5 justify-between">
                                                <h3 class="mb-0 text-lg font-semibold text-dark dark:text-white">User
                                                    Profile</h3>
                                            </div>
                                            <div class="message-body max-h-[450px]" data-simplebar>
                                                <div class>
                                                    <div
                                                        class="flex items-center gap-6 pb-5 border-b dark:border-darkborder">
                                                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}"
                                                            class="h-[90px] w-[90px] rounded-full object-cover"
                                                            alt="profile">
                                                        <div class>
                                                            <h5 class="card-title">
                                                                Mike Nielsen
                                                            </h5>
                                                            <span class="card-subtitle">super
                                                                admin</span>
                                                            <p class=" mb-0 mt-1 flex items-center">
                                                                <iconify-icon icon="solar:mailbox-line-duotone"
                                                                    class="text-base me-1"></iconify-icon>
                                                                info@spike.com
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <ul class="mt-3 flex flex-col gap-3.5">
                                                        <li>
                                                            <a href="page-user-profile.html"
                                                                class="flex gap-5 items-center bg-hover relative group p-2 rounded-sm">
                                                                <span
                                                                    class="bg-lightinfo dark:bg-darkinfo p-2 hover:bg-info group text-info hover:text-white rounded-sm flex justify-center items-center">
                                                                    <iconify-icon icon="solar:wallet-2-line-duotone"
                                                                        class="text-2xl "></iconify-icon>
                                                                </span>

                                                                <div>
                                                                    <h6
                                                                        class="font-medium text-base leading-tight mb-1  group-hover:text-primary">
                                                                        My Profile
                                                                    </h6>
                                                                    <p class="text-sm  font-normal leading-tight">
                                                                        Account settings</p>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="app-email.html"
                                                                class="flex gap-5 items-center p-2 rounded-sm bg-hover relative group">
                                                                <span
                                                                    class="bg-lightsuccess dark:bg-darksuccess p-2 hover:bg-success group text-success hover:text-white rounded-sm flex justify-center items-center">
                                                                    <iconify-icon
                                                                        icon="solar:shield-minimalistic-line-duotone"
                                                                        class="text-2xl"></iconify-icon>
                                                                </span>

                                                                <div>
                                                                    <h6
                                                                        class="font-medium text-base leading-tight mb-1  group-hover:text-primary">
                                                                        My Inbox
                                                                    </h6>
                                                                    <p class="text-sm  font-normal leading-tight">
                                                                        Messages & Emails</p>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="app-kanban.html"
                                                                class="flex gap-5 items-center p-2 rounded-sm bg-hover relative group">
                                                                <span
                                                                    class="bg-lighterror dark:bg-darkerror p-2 hover:bg-error group text-error hover:text-white rounded-sm flex justify-center items-center">
                                                                    <iconify-icon icon="solar:card-2-line-duotone"
                                                                        class="text-2xl"></iconify-icon>
                                                                </span>

                                                                <div>
                                                                    <h6
                                                                        class="font-medium text-base leading-tight mb-1  group-hover:text-primary">
                                                                        My Task
                                                                    </h6>
                                                                    <p class="text-sm  font-normal leading-tight">
                                                                        To-do and Daily Tasks</p>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="mt-5">
                                                <a href="authentication-login.html" class="btn w-full block">
                                                    Log Out
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="with-horizontal w-full">
        <div class="bg-white dark:bg-dark">
            <div class="container">
                <div class="w-full mx-auto">
                    <div class="relative md:flex md:items-center md:justify-between">
                        <div class="hs-collapse  grow md:block">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="flex h-[70px] justify-center items-center w-10 md:w-full overflow-hidden">
                                        <div class="brand-logo d-flex align-items-center justify-center">
                                            <a href="{{route('admin.dashboard')}}" class="text-nowrap logo-img">
                                                <img src="{{ asset('assets/images/logos/logo-light.svg') }}"
                                                    class="dark:hidden block rtl:hidden" alt="Logo-Dark" />
                                                <img src="{{ asset('assets/images/logos/logo-dark.svg') }}"
                                                    class="dark:block hidden rtl:hidden rtl:dark:hidden"
                                                    alt="Logo-light" />
                                                <img src="{{ asset('assets/images/logos/logo-light-rtl.svg') }}"
                                                    class="dark:hidden hidden rtl:block rtl:dark:hidden"
                                                    alt="Logo-Dark" />
                                                <img src="{{ asset('assets/images/logos/logo-dark-rtl.svg') }}"
                                                    class="dark:hidden hidden rtl:hidden rtl:dark:block"
                                                    alt="Logo-light" />
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                <div class="icon-nav items-center gap-2  lg:flex hidden">
                                    <div class="hs-dropdown relative inline-flex [--auto-close:inside]">
                                        <a href="#" class="relative block hs-dropdown-toggle"
                                            id="hs-dropdown-default">
                                            <input type="text"
                                                class="form-control rounded-full py-[9px]  ps-12 border-bordergray  text-dark dark:text-darklink text-fs_15  placeholder:text-dark dark:placeholder:text-darklink placeholder:opacity-100 font-medium"
                                                placeholder="Try to searching ...">
                                            <iconify-icon icon="solar:magnifer-linear"
                                                class="text-dark dark:text-darklink absolute top-3  start-1 text-fs_15  ms-3"></iconify-icon>
                                        </a>



                                        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden w-[385px] bg-white shadow-md rounded-lg p-0 mt-2 dark:bg-gray-800 dark:divide-gray-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full"
                                            aria-labelledby="hs-dropdown-default">
                                            <div
                                                class="flex flex-col bg-white dark:bg-dark  shadow-sm  pointer-events-auto rounded-md">
                                                <div class="p-4 overflow-y-auto">
                                                    <input type="text"
                                                        class="form-control rounded-sm py-2 border-bordergray text-dark dark:text-darklink text-sm  placeholder:text-dark dark:placeholder:text-darklink placeholder:opacity-100 font-medium"
                                                        placeholder="Try to searching ...">
                                                </div>
                                                <div
                                                    class="items-center gap-x-2 py-3 px-5 border-t border-border dark:border-darkborder">

                                                    <div class="overflow-hidden">
                                                        <h5 class="card-title mb-2">Quick Page Links</h5>
                                                        <div class="message-body max-h-[300px]" data-simplebar="">
                                                            <ul>
                                                                <li class="bg-hover py-2 px-3 rounded-sm">
                                                                    <a href="#"
                                                                        class="font-semibold text-sm text-link dark:text-darklink ">
                                                                        Modern
                                                                        <p
                                                                            class="text-sm text-link dark:text-darklink opacity-50 font-normal">
                                                                            /dashboards/modern</p>
                                                                    </a>
                                                                </li>
                                                                <li class="bg-hover py-2 px-3 rounded-sm">
                                                                    <a href="#"
                                                                        class="font-semibold text-sm text-link dark:text-darklink">
                                                                        eCommerce
                                                                        <p
                                                                            class="text-sm text-link dark:text-darklink opacity-50 font-normal">
                                                                            /dashboards/ecommerce</p>
                                                                    </a>
                                                                </li>
                                                                <li class="bg-hover py-2 px-3 rounded-sm">
                                                                    <a href="#"
                                                                        class="font-semibold text-sm text-link dark:text-darklink">
                                                                        Contacts
                                                                        <p
                                                                            class="text-sm text-link dark:text-darklink opacity-50 font-normal">
                                                                            /apps/contacts</p>
                                                                    </a>
                                                                </li>
                                                                <li class="bg-hover py-2 px-3 rounded-sm">
                                                                    <a href="#"
                                                                        class="font-semibold text-sm text-link dark:text-darklink">
                                                                        Shop
                                                                        <p
                                                                            class="text-sm text-link dark:text-darklink opacity-50 font-normal">
                                                                            /ecommerce/products</p>
                                                                    </a>
                                                                </li>
                                                                <li class="bg-hover py-2 px-3 rounded-sm">
                                                                    <a href="#"
                                                                        class="font-semibold text-sm text-link dark:text-darklink">
                                                                        Checkout
                                                                        <p
                                                                            class="text-sm text-link dark:text-darklink opacity-50 font-normal">
                                                                            /ecommerce/checkout</p>
                                                                    </a>
                                                                </li>
                                                                <li class="bg-hover py-2 px-3 rounded-sm">
                                                                    <a href="#"
                                                                        class="font-semibold text-sm text-link dark:text-darklink">
                                                                        Chats
                                                                        <p
                                                                            class="text-sm text-link dark:text-darklink opacity-50 font-normal">
                                                                            /apps/chats</p>
                                                                    </a>
                                                                </li>
                                                                <li class="bg-hover py-2 px-3 rounded-sm">
                                                                    <a href="#"
                                                                        class="font-semibold text-sm text-link dark:text-darklink">
                                                                        Notes
                                                                        <p
                                                                            class="text-sm text-link dark:text-darklink opacity-50 font-normal">
                                                                            /apps/notes</p>
                                                                    </a>
                                                                </li>
                                                                <li class="bg-hover py-2 px-3 rounded-sm">
                                                                    <a href="#"
                                                                        class="font-semibold text-sm text-link dark:text-darklink">
                                                                        Pricing
                                                                        <p
                                                                            class="text-sm text-link dark:text-darklink opacity-50 font-normal">
                                                                            /pages/pricing</p>
                                                                    </a>
                                                                </li>
                                                                <li class="bg-hover py-2 px-3 rounded-sm">
                                                                    <a href="#"
                                                                        class="font-semibold text-sm text-link dark:text-darklink">
                                                                        Account Setting
                                                                        <p
                                                                            class="text-sm text-link dark:text-darklink opacity-50 font-normal">
                                                                            /pages/account-settings</p>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <!-- Theme Toggle  -->
                                    <button type="button"
                                        class="hs-dark-mode-active:hidden icon-hover block hs-dark-mode group items-center font-medium hover:text-primary text-link dark:text-darklink h-10 w-10 hover:bg-lightprimary dark:hover:bg-darkprimary  justify-center rounded-full"
                                        data-hs-theme-click-value="dark" id="dark-layout">
                                        <iconify-icon icon="solar:moon-line-duotone"
                                            class=" text-2xl  text-link dark:text-darklink relative  hover:text-primary"></iconify-icon>

                                    </button>
                                    <button type="button"
                                        class="hs-dark-mode-active:block icon-hover hidden hs-dark-mode group  items-center  font-medium hover:text-primary text-link dark:text-darklink h-10 w-10 hover:bg-lightprimary dark:hover:bg-darkprimary  justify-center rounded-full"
                                        data-hs-theme-click-value="light" id="light-layout">
                                        <iconify-icon icon="solar:sun-2-line-duotone"
                                            class=" text-2xl  text-link dark:text-darklink relative  hover:text-primary"></iconify-icon>

                                    </button>
                                    <div
                                        class="hs-dropdown xl:[--strategy:absolute] [--adaptive:none] md:[--trigger:hover] sm:relative  group/menu">
                                        <a id="hs-dropdown-hover-event-messages"
                                            class="relative hs-dropdown-toggle h-10 w-10 text-link dark:text-darklink cursor-pointer hover:bg-lightprimary  hover:text-primary dark:hover:bg-darkprimary flex justify-center items-center rounded-full group-hover/menu:bg-lightprimary group-hover/menu:text-primary">
                                            <iconify-icon icon="solar:chat-dots-line-duotone"
                                                class=" text-2xl relative z-[1]"></iconify-icon>
                                            <span class="flex absolute top-2 end-[9px] -mt-0.5 -me-2">
                                                <span
                                                    class="animate-ping absolute inline-flex size-full rounded-full bg-yellow-400 opacity-75 dark:bg-yellow-600"></span>
                                                <span
                                                    class="relative inline-flex text-xs bg-yellow-500 text-white rounded-full py-0.5 px-1">
                                                    <div class="h-1 rounded-full bg-primary"></div>
                                                </span>
                                            </span>
                                        </a>
                                        <div class="card hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 right-0 rtl:right-auto rtl:left-0 mt-2 min-w-max top-auto w-full sm:w-[385px] hidden z-[2]"
                                            aria-labelledby="hs-dropdown-hover-event-messages">
                                            <div class="flex items-center pt-6 px-7 gap-4">
                                                <h3 class="mb-0 text-lg font-semibold text-dark dark:text-white">
                                                    Messages</h3>
                                                <span
                                                    class="py-1 px-3 border-0 badge text-xs font-medium bg-info text-white">5
                                                    new</span>
                                            </div>
                                            <div class="message-body max-h-[320px] pt-4" data-simplebar="">
                                                <a href="javascript:void(0)"
                                                    class="dropdown-item px-7 py-3 flex justify-between items-center bg-hover">
                                                    <div class="flex items-center">
                                                        <span class="flex-shrink-0">
                                                            <img src="{{ asset('assets/images/profile/user-2.jpg') }}"
                                                                alt="user" class="rounded-full w-12 h-12">
                                                            </span>
                                                        <div class="ps-4">
                                                            <h5 class="mb-1 font-medium text-sm">
                                                                Mark Edverds
                                                            </h5>
                                                            <span class="text-xs block ">just sent you new
                                                                message</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-xs block  self-start pt-1.5">09:00 AM</span>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="dropdown-item px-7 py-3 flex items-center justify-between bg-hover">
                                                    <div class="flex items-center">
                                                        <span class="flex-shrink-0">
                                                            <img src="{{ asset('assets/images/profile/user-3.jpg') }}"
                                                                alt="user" class="rounded-full w-11">
                                                            </span>
                                                        <div class="ps-4">
                                                            <h5 class="mb-1 font-medium text-sm">
                                                                John Mckay
                                                            </h5>
                                                            <span class="text-xs block ">new message from john</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-xs block  self-start pt-1.5">10.00 AM</span>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="dropdown-item px-7 py-3 flex items-center justify-between bg-hover">
                                                    <div class="flex items-center">
                                                        <span class="flex-shrink-0">
                                                            <img src="{{ asset('assets/images/profile/user-4.jpg') }}"
                                                                alt="user" class="rounded-full w-12 h-12">
                                                            </span>
                                                        <div class="ps-4">
                                                            <h5 class="mb-1 font-medium text-sm">
                                                                Roman Ray
                                                            </h5>
                                                            <span class="text-xs block ">new message from roman</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-xs block  self-start pt-1.5">09:08 AM</span>
                                                </a>

                                                <a href="javascript:void(0)"
                                                    class="dropdown-item px-7 py-3 flex justify-between items-center bg-hover">
                                                    <div class="flex items-center">
                                                        <span class="flex-shrink-0">
                                                            <img src="{{ asset('assets/images/profile/user-5.jpg') }}"
                                                                alt="user" class="rounded-full w-11">
                                                            </span>
                                                        <div class="ps-4">
                                                            <h5 class="mb-1 font-medium text-sm">
                                                                Jolly Writes
                                                            </h5>
                                                            <span class="text-xs block ">just sent you new
                                                                message</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-xs block  self-start pt-1.5">10:00 AM</span>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="dropdown-item px-7 py-3 flex items-center justify-between bg-hover">
                                                    <div class="flex items-center">
                                                        <span class="flex-shrink-0">
                                                            <img src="{{ asset('assets/images/profile/user-6.jpg') }}"
                                                                alt="user" class="rounded-full w-11">
                                                        </span>
                                                        <div class="ps-4">
                                                            <h5 class="mb-1 font-medium text-sm">
                                                                Ruby Allen
                                                            </h5>
                                                            <span class="text-xs block ">just sent you new
                                                                message</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-xs block  self-start pt-1.5">11.00 AM</span>
                                                </a>
                                            </div>
                                            <div class="pt-3 pb-6 px-7">
                                                <a href="#" class="btn w-full block">
                                                    See All Messages
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Notifications DD -->

                                    <div
                                        class="hs-dropdown xl:[--strategy:absolute] [--adaptive:none] md:[--trigger:hover] sm:relative group/menu">
                                        <a id="hs-dropdown-hover-event-notification"
                                            class="relative hs-dropdown-toggle h-10 w-10 text-link dark:text-darklink cursor-pointer hover:bg-lightprimary  hover:text-primary dark:hover:bg-darkprimary flex justify-center items-center rounded-full group-hover/menu:bg-lightprimary group-hover/menu:text-primary">
                                            <iconify-icon icon="solar:bell-bing-line-duotone"
                                                class="text-2xl relative z-[1]"></iconify-icon>
                                            <span class="flex absolute top-2 end-3 -mt-0.5 -me-2">
                                                <span
                                                    class="animate-ping absolute inline-flex size-full rounded-full bg-teal-400 opacity-75 dark:bg-teal-600"></span>
                                                <span
                                                    class="relative inline-flex text-xs bg-teal-500 text-white rounded-full py-0.5 px-1">
                                                    <div class="h-1 rounded-full bg-primary"></div>
                                                </span>
                                            </span>
                                        </a>
                                        <div class="card hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 right-0 rtl:right-auto rtl:left-0 mt-2 min-w-max top-auto w-full sm:w-[360px] hidden z-[2]"
                                            aria-labelledby="hs-dropdown-hover-event-notification">
                                            <div class="flex items-center pt-6 px-7 gap-4">
                                                <h3 class="mb-0 text-lg font-semibold ">
                                                    Notifications</h3>
                                                <span
                                                    class="py-1 px-3 border-0 badge text-xs font-medium bg-warning text-white">5
                                                    new</span>
                                            </div>
                                            <div class="message-body max-h-[320px] pt-4" data-simplebar>
                                                <a href="javascript:void(0)"
                                                    class="dropdown-item px-7 py-3 flex items-center bg-hover">
                                                    <span
                                                        class="flex-shrink-0 h-12 w-12 rounded-full bg-lightprimary dark:bg-darkprimary flex justify-center items-center">
                                                        <iconify-icon icon="solar:widget-3-line-duotone"
                                                            class="text-primary text-xl"></iconify-icon>
                                                    </span>
                                                    <div class="ps-4">
                                                        <h5 class="font-medium text-sm">
                                                            Launch Admin
                                                        </h5>
                                                        <span class="text-xs block my-0.5">Just see the my new
                                                            admin!</span>
                                                        <p class="text-xs">9.00 AM</p>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="dropdown-item px-7 py-3 flex items-center bg-hover">
                                                    <span
                                                        class="flex-shrink-0 h-12 w-12 rounded-full bg-lightsuccess dark:bg-darksuccess flex justify-center items-center">
                                                        <iconify-icon icon="solar:user-circle-outline"
                                                            class="text-success text-xl"></iconify-icon>
                                                    </span>
                                                    <div class="ps-4">
                                                        <h5 class="font-medium text-sm ">
                                                            Meeting Today
                                                        </h5>
                                                        <span class="text-xs block my-0.5">Just a reminder that you
                                                            have
                                                            meeting</span>
                                                        <p class="text-xs">10.00 AM</p>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="dropdown-item px-7 py-3 flex items-center bg-hover">
                                                    <span
                                                        class="flex-shrink-0 h-12 w-12 rounded-full bg-lighterror dark:bg-darkerror flex justify-center items-center">
                                                        <iconify-icon icon="solar:calendar-line-duotone"
                                                            class="text-error text-xl"></iconify-icon>
                                                    </span>
                                                    <div class="ps-4">
                                                        <h5 class="font-medium text-sm ">
                                                            Go for Event
                                                        </h5>
                                                        <span class="text-xs block my-0.5">Just a reminder that you
                                                            have
                                                            event</span>
                                                        <p class="text-xs">09.00 AM</p>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="dropdown-item px-7 py-3 flex items-center bg-hover">
                                                    <span
                                                        class="flex-shrink-0 h-12 w-12 rounded-full bg-lightindigo dark:bg-darkindigo flex justify-center items-center">
                                                        <iconify-icon icon="solar:dollar-line-duotone"
                                                            class="text-indigo text-xl"></iconify-icon>
                                                    </span>
                                                    <div class="ps-4">
                                                        <h5 class="font-medium text-sm ">
                                                            Pay Bills
                                                        </h5>
                                                        <span class="text-xs block my-0.5">Just a reminder that you
                                                            have pay
                                                        </span>
                                                        <p class="text-xs">11.00 AM</p>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="dropdown-item px-7 py-3 flex items-center bg-hover">
                                                    <span
                                                        class="flex-shrink-0 h-12 w-12 rounded-full bg-lightinfo dark:bg-darkinfo flex justify-center items-center">
                                                        <iconify-icon icon="solar:settings-linear"
                                                            class="text-info text-xl"></iconify-icon>
                                                    </span>
                                                    <div class="ps-4">
                                                        <h5 class="font-medium text-sm ">
                                                            Settings
                                                        </h5>
                                                        <span class="text-xs block my-0.5">You can customize the
                                                            template</span>
                                                        <p class="text-xs">12.00 AM</p>
                                                    </div>
                                                </a>

                                            </div>
                                            <div class="pt-3 pb-6 px-7">
                                                <a href="#" class="btn w-full block">
                                                    See All Notification
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Profile DD -->
                                    <div
                                        class="hs-dropdown xl:[--strategy:absolute] [--adaptive:none] md:[--trigger:hover] sm:relative ms-3">
                                        <a id="hs-dropdown-hover-event-profile"
                                            class="relative hs-dropdown-toggle cursor-pointer align-middle rounded-full">
                                            <div class="flex gap-4">
                                                <div class="relative">
                                                    <img class="object-cover w-11 h-11 rounded-full"
                                                        src="{{ asset('assets/images/profile/user-1.jpg') }}" alt
                                                        aria-hidden="true">
                                                    <span
                                                        class="h-3.5 w-3.5 rounded-full bg-success block absolute top-0 -end-1 border-2 border-white dark:border-dark"></span>

                                                </div>
                                                <div class="hidden sm:block">
                                                    <h6
                                                        class="font-bold text-dark dark:text-white text-base mb-1 profile-name">
                                                        Mike Nielsen
                                                    </h6>
                                                    <p class="text-sm leading-tight mb-0 text-link dark:text-darklink">
                                                        Admin
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="card hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 mt-2 min-w-max top-auto right-0 rtl:right-auto rtl:left-0 w-full sm:w-[385px] hidden z-[2] border-none "
                                            aria-labelledby="hs-dropdown-hover-event-profile">
                                            <div class="card-body p-7">
                                                <div class="flex items-center pb-5 justify-between">
                                                    <h3 class="mb-0 text-lg font-semibold text-dark dark:text-white">
                                                        User
                                                        Profile</h3>
                                                </div>
                                                <div class="message-body max-h-[450px]" data-simplebar>
                                                    <div class>
                                                        <div
                                                            class="flex items-center gap-6 pb-5 border-b dark:border-darkborder">
                                                            <img src="{{ asset('assets/images/profile/user-1.jpg') }}"
                                                                class="h-[90px] w-[90px] rounded-full object-cover"
                                                                alt="profile">
                                                            <div class>
                                                                <h5 class="card-title">
                                                                    Mike Nielsen
                                                                </h5>
                                                                <span class="card-subtitle">super
                                                                    admin</span>
                                                                <p class=" mb-0 mt-1 flex items-center">
                                                                    <iconify-icon icon="solar:mailbox-line-duotone"
                                                                        class="text-base me-1"></iconify-icon>
                                                                    info@spike.com
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <ul class="mt-3 flex flex-col gap-3.5">
                                                            <li>
                                                                <a href="page-user-profile.html"
                                                                    class="flex gap-5 items-center bg-hover relative group p-2 rounded-sm">
                                                                    <span
                                                                        class="bg-lightinfo dark:bg-darkinfo p-2 hover:bg-info group text-info hover:text-white rounded-sm flex justify-center items-center">
                                                                        <iconify-icon
                                                                            icon="solar:wallet-2-line-duotone"
                                                                            class="text-2xl "></iconify-icon>
                                                                    </span>

                                                                    <div>
                                                                        <h6
                                                                            class="font-medium text-base leading-tight mb-1  group-hover:text-primary">
                                                                            My Profile
                                                                        </h6>
                                                                        <p class="text-sm  font-normal leading-tight">
                                                                            Account settings</p>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="app-email.html"
                                                                    class="flex gap-5 items-center p-2 rounded-sm bg-hover relative group">
                                                                    <span
                                                                        class="bg-lightsuccess dark:bg-darksuccess p-2 hover:bg-success group text-success hover:text-white rounded-sm flex justify-center items-center">
                                                                        <iconify-icon
                                                                            icon="solar:shield-minimalistic-line-duotone"
                                                                            class="text-2xl"></iconify-icon>
                                                                    </span>

                                                                    <div>
                                                                        <h6
                                                                            class="font-medium text-base leading-tight mb-1  group-hover:text-primary">
                                                                            My Inbox
                                                                        </h6>
                                                                        <p class="text-sm  font-normal leading-tight">
                                                                            Messages & Emails</p>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="app-kanban.html"
                                                                    class="flex gap-5 items-center p-2 rounded-sm bg-hover relative group">
                                                                    <span
                                                                        class="bg-lighterror dark:bg-darkerror p-2 hover:bg-error group text-error hover:text-white rounded-sm flex justify-center items-center">
                                                                        <iconify-icon icon="solar:card-2-line-duotone"
                                                                            class="text-2xl"></iconify-icon>
                                                                    </span>

                                                                    <div>
                                                                        <h6
                                                                            class="font-medium text-base leading-tight mb-1  group-hover:text-primary">
                                                                            My Task
                                                                        </h6>
                                                                        <p class="text-sm  font-normal leading-tight">
                                                                            To-do and Daily Tasks</p>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="mt-5">
                                                    <a href="authentication-login.html" class="btn w-full block">
                                                        Log Out
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>
<!--  Header End -->
