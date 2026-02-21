<div id="dismiss-toast"
    class="toast-onload opacity-0   hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 max-w-xs bg-primary rounded-md"
    role="alert">
    <div class="flex gap-2 p-3">
        <i class="ti ti-alert-circle text-white text-lg"></i>
        <div>
            <h5 class="font-semibold text-white">Selamat datang, {{ Auth::user()->name }}</h5>
            <p class="text-fs_12 text-white">Senang melihat Anda kembali!</p>
        </div>
        <div class="ms-auto">
            <button type="button" data-hs-remove-element="#dismiss-toast">
                <i class="ti ti-x text-lg text-white opacity-70 leading-none"></i>
            </button>
        </div>
    </div>
</div>
