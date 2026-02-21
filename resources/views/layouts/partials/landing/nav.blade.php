<ul class="flex items-center gap-5">
    <li>
        <a href="/"  class="hover:text-primary hover:bg-lightprimary dark:hover:text-primary text-dark dark:text-white font-medium text-base py-2 px-3  rounded-md ">Home</a>
    </li>
    {{-- <li>
        <div
            class="hs-dropdown  [--strategy:static] xl:[--strategy:absolute] [--adaptive:none] xl:[--trigger:hover] relative group/menu">
            <button type="button"
                class="xl:w-auto w-full gap-2 header-link hover:text-primary hover:bg-lightprimary dark:hover:text-primary text-dark dark:text-white font-medium text-base py-2 px-3  rounded-md flex items-center group-hover/menu:text-primary group-hover/menu:bg-lightprimary">
                Demos
                <i class="ti ti-chevron-down  ms-auto xl:text-sm text-lg"></i>
            </button>

            <div class="hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] sm:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 xl:-left-80 hidden z-10 sm:mt-3 top-full xl:w-[1150px] before:absolute xl:bg-white bg-transparent dark:bg-dark xl:shadow-md shadow-none">
                <div class="xl:p-6 p-3">
                    <div class="mb-5">
                        <h5 class="card-title">Different
                            Demos</h5>
                        <p>Included with the
                            Package</p>
                    </div>

                    <div class="grid xl:grid-cols-5 grid-cols-1 gap-6">
                        <div>
                            <div
                                class="border-1 border-light-dark overflow-hidden rounded-md relative flex justify-center items-center group">
                                <img src="{{ asset('assets/images/demos/demo-main.jpg') }}" alt class="max-w-full w-full" />
                                <a target="_blank" href="../main/index.html" class="preview-btn ">Live
                                    Preview</a>
                                <div class="bg-overlay">
                                </div>
                            </div>
                            <div class="text-center p-3 text-sm font-semibold text-dark dark:text-white">
                                Main</div>
                        </div>
                        <div>
                            <div
                                class="border border-light-dark overflow-hidden rounded-md relative flex justify-center items-center group">
                                <img src="{{ asset('assets/images/demos/demo-dark.jpg') }}" alt class="max-w-full w-full" />
                                <a target="_blank" href="../dark/index.html" class="preview-btn ">Live
                                    Preview</a>
                                <div class="bg-overlay">
                                </div>
                            </div>
                            <div class="text-center p-3 text-sm font-semibold text-dark dark:text-white">
                                Dark</div>
                        </div>
                        <div>
                            <div
                                class="border border-light-dark overflow-hidden rounded-md relative flex justify-center items-center group">
                                <img src="{{ asset('assets/images/demos/demo-horizontal.jpg') }}" alt class="max-w-full w-full" />
                                <a target="_blank" href="../horizontal/index.html" class="preview-btn ">Live
                                    Preview</a>
                                <div class="bg-overlay">
                                </div>
                            </div>
                            <div class="text-center p-3 text-sm font-semibold text-dark dark:text-white">
                                Horizontal</div>
                        </div>
                        <div>
                            <div
                                class="border border-light-dark overflow-hidden rounded-md relative flex justify-center items-center group">
                                <img src="{{ asset('assets/images/demos/demo-minisidebar.jpg') }}" alt class="max-w-full w-full" />
                                <a target="_blank" href="../minisidebar/index.html" class="preview-btn ">Live
                                    Preview</a>
                                <div class="bg-overlay">
                                </div>
                                </div>
                                <div class="text-center p-3 text-sm font-semibold text-dark dark:text-white">
                                    Minisidebar</div>
                                </div>
                                <div>
                                    <div
                                        class="border border-light-dark overflow-hidden rounded-md relative flex justify-center items-center group">
                                        <img src="{{ asset('assets/images/demos/demo-rtl.jpg') }}" alt class="max-w-full w-full" />
                                        <a target="_blank" href="../rtl/index.html" class="preview-btn ">Live
                                            Preview</a>
                                        <div class="bg-overlay">
                                        </div>
                                    </div>
                                    <div class="text-center p-3 text-sm font-semibold text-dark dark:text-white">
                                        RTL</div>
                                </div>
                                </div>
                                <div class="my-5">
                                    <h5 class="card-title">Different Apps</h5>
                                </div>

                                <div class="grid xl:grid-cols-5 grid-cols-1 gap-6">
                                    <div>
                                        <div
                                            class="border border-light-dark overflow-hidden rounded-md relative flex justify-center items-center group">
                                            <img src="{{ asset('assets/images/apps/app-calendar.jpg') }}" alt class="max-w-full w-full" />
                                <a target="_blank" href="../main/app-calendar.html" class="preview-btn ">Live
                                    Preview</a>
                                <div class="bg-overlay">
                                </div>
                            </div>
                            <div class="text-center p-3 text-sm font-semibold text-dark dark:text-white">
                                Calendar</div>
                        </div>
                        <div>
                            <div
                                class="border border-light-dark overflow-hidden rounded-md relative flex justify-center items-center group">
                                <img src="{{ asset('assets/images/apps/app-chat.jpg') }}" alt class="max-w-full w-full" />
                                <a target="_blank" href="../main/app-chat.html" class="preview-btn ">Live
                                    Preview</a>
                                <div class="bg-overlay">
                                </div>
                            </div>
                            <div class="text-center p-3 text-sm font-semibold text-dark dark:text-white">
                                Chat</div>
                        </div>
                        <div>
                            <div
                                class="border border-light-dark overflow-hidden rounded-md relative flex justify-center items-center group">
                                <img src="{{ asset('assets/images/apps/app-email.jpg') }}" alt class="max-w-full w-full" />
                                <a target="_blank" href="../main/app-email.html" class="preview-btn ">Live
                                    Preview</a>
                                <div class="bg-overlay">
                                </div>
                            </div>
                            <div class="text-center p-3 text-sm font-semibold text-dark dark:text-white">
                                Email</div>
                        </div>
                        <div>
                            <div
                                class="border border-light-dark overflow-hidden rounded-md relative flex justify-center items-center group">
                                <img src="{{ asset('assets/images/apps/app-contact.jpg') }}" alt class="max-w-full w-full" />
                                <a target="_blank" href="../main/app-contact2.html" class="preview-btn ">Live
                                    Preview</a>
                                <div class="bg-overlay">
                                </div>
                            </div>
                            <div class="text-center p-3 text-sm font-semibold text-dark dark:text-white">
                                Contact</div>
                        </div>
                        <div>
                            <div
                                class="border border-light-dark overflow-hidden rounded-md relative flex justify-center items-center group">
                                <img src="{{ asset('assets/images/apps/app-invoice.jpg') }}" alt class="max-w-full w-full" />
                                <a target="_blank" href="../main/app-invoice.html" class="preview-btn ">Live
                                    Preview</a>
                                <div class="bg-overlay">
                                </div>
                            </div>
                            <div class="text-center p-3 text-sm font-semibold text-dark dark:text-white">
                                Invoice</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <li>
        <div
            class="hs-dropdown  [--strategy:static] xl:[--strategy:absolute] [--adaptive:none] xl:[--trigger:hover] relative group/menu">
            <button type="button"
                class=" xl:w-auto w-full gap-2  header-link hover:text-primary dark:hover:text-primary hover:bg-lightprimary text-dark dark:text-white font-medium text-base py-2 px-3  rounded-md flex items-center group-hover/menu:text-primary group-hover/menu:bg-lightprimary">
                Pages
                <i class="ti ti-chevron-down  ms-auto xl:text-sm text-xl"></i>
            </button>

            <div
                class="hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] sm:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 xl:-right-80 hidden z-10 sm:mt-3 top-full xl:w-[900px] before:absolute xl:bg-white bg-transparent dark:bg-dark xl:shadow-md shadow-none">
                <div class="grid grid-cols-12">
                    <div class="lg:col-span-8 col-span-12 flex items-stretch lg:px-8 lg:pr-0 px-0 py-8 pb-0">
                        <div class="grid grid-cols-12 lg:gap-3 w-full">
                            <div class="col-span-12 lg:col-span-6 flex items-stretch pb-2.5">
                                <ul class="flex flex-col gap-5">
                                    <li>
                                        <a href="../main/app-chat.html"
                                            class="flex gap-3 items-center group relative ">
                                            <span
                                                class="bg-lightgray dark:bg-darkprimary  h-11 w-11 flex justify-center items-center rounded-sm">
                                                <img src="{{ asset('assets/images/svgs/icon-dd-chat.svg') }}" class="h-6 w-6">
                                                </span>
                                                <div class>
                                                    <h6 class="text-fs_15  group-hover:text-primary mb-1 ">
                                                        Chat Application
                                                    </h6>
                                                    <p class="text-xs text-dark dark:text-darklink opacity-90 font-normal">
                                                        New messages arrived</p>
                                                </div>

                                                </a>
                                                </li>
                                                <li>
                                                    <a href="../main/app-invoice.html"
                                                        class="flex gap-3 items-center group relative ">
                                                        <span
                                                            class="bg-lightgray dark:bg-darkprimary  h-11 w-11 flex justify-center items-center rounded-sm">
                                                            <img src="{{ asset('assets/images/svgs/icon-dd-invoice.svg') }}" class="h-6 w-6">
                                                        </span>
                                                        <div class>
                                                            <h6 class="text-fs_15  mb-1  group-hover:text-primary ">
                                                                Invoice App
                                                            </h6>
                                                            <p class="text-xs text-link dark:text-darklink  font-normal">
                                                                Get latest invoice</p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../main/app-contact.html"
                                                        class="flex gap-3 items-center group relative ">
                                                        <span
                                                            class="bg-lightgray dark:bg-darkprimary  h-11 w-11 flex justify-center items-center rounded-sm">
                                                            <img src="{{ asset('assets/images/svgs/icon-dd-mobile.svg') }}" class="h-6 w-6">
                                            </span>
                                            <div class>
                                                <h6 class="text-fs_15  mb-1  group-hover:text-primary">
                                                    Contact Application
                                                </h6>
                                                <p class="text-xs text-link dark:text-darklink  font-normal">
                                                    2 Unsaved Contacts</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../main/app-email.html"
                                            class="flex gap-3 items-center group relative ">
                                            <span
                                                class="bg-lightgray dark:bg-darkprimary  h-11 w-11 flex justify-center items-center rounded-sm">
                                                <img src="{{ asset('assets/images/svgs/icon-dd-message-box.svg') }}"
                                                    class="h-6 w-6">
                                            </span>
                                            <div class>
                                                <h6 class="text-fs_15  mb-1  group-hover:text-primary ">
                                                    Email App
                                                </h6>
                                                <p class="text-xs text-link dark:text-darklink  font-normal">
                                                    Get new emails</p>
                                            </div>
                                        </a>
                                    </li>
                                    </ul>
                                    </div>
                                    <div class="col-span-12 lg:col-span-6 flex items-stretch">
                                        <ul class="flex flex-col gap-5">
                                            <li>
                                                <a href="../main/eco-shop.html"
                                                    class="flex gap-3 items-center group relative ">
                                                    <span
                                                        class="bg-lightgray dark:bg-darkprimary  h-11 w-11 flex justify-center items-center rounded-sm">
                                                        <img src="{{ asset('assets/images/svgs/icon-dd-cart.svg') }}" class="h-6 w-6">
                                                    </span>
                                                    <div class>
                                                        <h6 class="text-fs_15  mb-1  group-hover:text-primary ">
                                                            eCommerce App
                                                        </h6>
                                                        <p class="text-xs text-link dark:text-darklink  font-normal">
                                                            learn more information</p>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="../main/app-calendar.html"
                                                    class="flex gap-3 items-center group relative ">
                                                    <span
                                                        class="bg-lightgray dark:bg-darkprimary  h-11 w-11 flex justify-center items-center rounded-sm">
                                                        <img src="{{ asset('assets/images/svgs/icon-dd-date.svg') }}" class="h-6 w-6">
                                                    </span>
                                                    <div class>
                                                        <h6 class="text-fs_15  mb-1  group-hover:text-primary ">
                                                            Calendar App
                                                        </h6>
                                                        <p class="text-xs text-link dark:text-darklink  font-normal">
                                                            Get dates</p>
                                                    </div>
                                                </a>
                                            </li>
                                    <li>
                                        <a href="../main/app-contact2.html"
                                            class="flex gap-3 items-center group relative ">
                                            <span
                                                class="bg-lightgray dark:bg-darkprimary  h-11 w-11 flex justify-center items-center rounded-sm">
                                                <img src="{{ asset('assets/images/svgs/icon-dd-lifebuoy.svg') }}" class="h-6 w-6">
                                            </span>
                                            <div class>
                                                <h6 class="text-fs_15  mb-1  group-hover:text-primary ">
                                                    Contact List Table

                                                </h6>
                                                <p class="text-xs text-link dark:text-darklink  font-normal">
                                                    Add new contact</p>
                                            </div>

                                        </a>
                                    </li>
                                    <li>
                                        <a href="../main/app-notes.html"
                                            class="flex gap-3 items-center group relative ">
                                            <span
                                                class="bg-lightgray dark:bg-darkprimary  h-11 w-11 flex justify-center items-center rounded-sm">
                                                <img src="{{ asset('assets/images/svgs/icon-dd-application.svg') }}" class="h-6 w-6">
                                                </span>
                                            <div class>
                                                <h6 class="text-fs_15  mb-1  group-hover:text-primary ">
                                                    Notes Application

                                                </h6>
                                                <p class="text-xs text-link dark:text-darklink  font-normal">
                                                    To-do and Daily tasks</p>
                                            </div>

                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-4 col-span-12  flex items-strech">
                        <div class="lg:p-3 lg:border-s border-border dark:border-darkborder">
                            <h5 class="text-lg font-semibold mb-4 text-dark dark:text-white">
                                Quick Links</h5>
                            <ul class="flex flex-col gap-4 pb-3">
                                <li><a href="../main/page-pricing.html"
                                        class="text-sm font-semibold text-link dark:text-darklink  hover:text-primary hover:dark:text-primary ">Pricing
                                        Page</a></li>
                                <li><a href="../main/authentication-login.html"
                                        class="text-sm font-semibold text-link dark:text-darklink  hover:text-primary hover:dark:text-primary ">Authentication
                                        Design</a></li>
                                <li><a href="../main/authentication-register.html"
                                        class="text-sm font-semibold text-link dark:text-darklink  hover:text-primary hover:dark:text-primary ">Register
                                        Now</a></li>
                                <li><a href="../main/authentication-error.html"
                                        class="text-sm font-semibold text-link dark:text-darklink  hover:text-primary hover:dark:text-primary ">404
                                        Error
                                        Page</a></li>
                                <li><a href="../main/app-notes.html"
                                        class="text-sm font-semibold text-link dark:text-darklink  hover:text-primary hover:dark:text-primary ">Notes
                                        App</a>
                                </li>
                                <li><a href="../main/page-user-profile.html"
                                        class="text-sm font-semibold text-link dark:text-darklink  hover:text-primary hover:dark:text-primary ">User
                                        Application</a></li>
                                <li><a href="../main/blog-posts.html"
                                        class="text-sm font-semibold text-link dark:text-darklink  hover:text-primary hover:dark:text-primary">Blog
                                        Design</a></li>
                                <li><a href="../main/eco-checkout.html"
                                        class="text-sm font-semibold text-link dark:text-darklink  hover:text-primary hover:dark:text-primary">Shopping
                                        Cart</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li> --}}
    <li>
        <a href="#layanan" class="hover:text-primary hover:bg-lightprimary dark:hover:text-primary text-dark dark:text-white font-medium text-base py-2 px-3  rounded-md ">Layanan</a>
    </li>
    <li>
        <a href="#about" class="hover:text-primary hover:bg-lightprimary dark:hover:text-primary text-dark dark:text-white font-medium text-base py-2 px-3  rounded-md ">Tentang Kami</a>
    </li>
    <li>
        <a href="#contct" class="hover:text-primary hover:bg-lightprimary dark:hover:text-primary text-dark dark:text-white font-medium text-base py-2 px-3  rounded-md">Kontak</a>
    </li>
</ul>
