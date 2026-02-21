<!-- Bottom User Profile -->
<div class="px-4 pt-4 relative hide-menu">
    <div class="bg-lightprimary dark:bg-darkprimary p-6 rounded-md">
        <div>
            <div class="flex items-center">
                {{-- @if(Auth::user()->photo)
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="h-11 w-11 rounded-full object-cover" alt="profile" />
                @else --}}
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="h-11 w-11 rounded-full object-cover" alt="profile" />
                {{-- @endif --}}
                <div class="ml-4 rtl:mr-4 rtl:ml-0 flex-1 min-w-0">
                    <h5 class="text-md font-semibold text-dark dark:text-white truncate" style="max-width: 100%;">Name</h5>
                    <p class="text-sm font-normal text-link dark:text-darklink truncate">Role</p>
                </div>
                <div class="ms-auto hs-tooltip hs-tooltip-toggle">
                    <!-- Logout Button triggers Modal -->
                    <button type="button" class="text-link hover:text-primary dark:text-primary flex items-center" data-hs-overlay="#hs-vertically-centered-modal">
                        <iconify-icon icon="solar:logout-line-duotone" class="text-3xl"></iconify-icon>
                        <span class="tooltip hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible" role="tooltip">
                            Logout
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
