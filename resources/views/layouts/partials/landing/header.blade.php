 <!--  Header Start -->
 <header
     class="sticky top-header top-0 inset-x-0 z-[5] flex flex-wrap md:justify-start md:flex-nowrap text-sm px-0 sm:py-6 py-3  bg-lightgray dark:bg-darkprimary">
     <div class="container flex items-center justify-between xl:px-0 px-5">

             <div class="brand-logo d-flex align-items-center justify-center">
                <a href="{{ url('/') }}" class="text-nowrap logo-img">
                    <img src="{{ asset('assets/images/logos/logo-light.svg') }}" class="dark:hidden block rtl:hidden" alt="Logo-Dark" />
                    <img src="{{ asset('assets/images/logos/logo-dark.svg') }}" class="dark:block hidden rtl:hidden rtl:dark:hidden" alt="Logo-light" />
                    <img src="{{ asset('assets/images/logos/logo-light-rtl.svg') }}" class="dark:hidden hidden rtl:block rtl:dark:hidden" alt="Logo-Dark" />
                    <img src="{{ asset('assets/images/logos/logo-dark-rtl.svg') }}" class="dark:hidden hidden rtl:hidden rtl:dark:block" alt="Logo-light" />
                </a>
             </div>
         <!---Lp Mobile Toggle Icons--->
         <div class="xl:hidden">
             <a class="rounded-full icon-hover h-10 w-10 flex justify-center text-link dark:text-darklink items-center hover:text-primary  relative hover:bg-lightprimary dark:hover:bg-darkprimary "
                 data-hs-overlay="#application-sidebar-lp">
                 <i class="ti ti-menu-2 text-xl relative "></i>
             </a>
         </div>

         <!-- Menu-->
         <div class="xl:flex hidden ">
             @include('layouts.partials.landing.nav')
         </div>
         <a href="{{route('self-registration')}}" class="btn xl:flex hidden">Daftar</a>
     </div>
 </header>
