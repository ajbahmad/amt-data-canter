@extends('layouts.admin')

@section('title', 'Profil Saya')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
{{-- Breadcrumb (consistent partial) --}}
@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Profil Saya',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['name' => 'Akun', 'url' => '#'],
        ['name' => 'Profil', 'url' => route('admin.profile.show')] 
    ]
])

<div class="mx-auto">
    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 p-4">
            <div class="flex items-center">
                <i class="ti ti-check-circle text-green-600 dark:text-green-400 text-xl mr-3"></i>
                <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
            </div>
        </div>
    @endif

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show success toast if needed
    @if(session('success'))
        Swal.fire({ 
            icon: 'success', 
            title: 'Berhasil!', 
            text: '{{ session('success') }}', 
            timer: 3000, 
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    @endif

    // Tab handling
    const tabNavs = document.querySelectorAll('.tab-nav');
    const tabPanels = document.querySelectorAll('.tab-panel');
    const tabButtons = document.querySelectorAll('.tab-btn');

    function showTab(name){
        // Hide all panels
        tabPanels.forEach(p => { 
            if(p.id === 'tab-'+name) {
                p.classList.remove('hidden');
                p.classList.add('fade-in');
            } else {
                p.classList.add('hidden');
                p.classList.remove('fade-in');
            }
        });
        
        // Update nav styles
        tabNavs.forEach(b => { 
            if(b.dataset.tab === name) {
                b.classList.add('border-blue-500', 'text-blue-600', 'dark:text-blue-400');
                b.classList.remove('border-transparent', 'text-gray-700', 'dark:text-gray-300');
            } else {
                b.classList.remove('border-blue-500', 'text-blue-600', 'dark:text-blue-400');
                b.classList.add('border-transparent', 'text-gray-700', 'dark:text-gray-300');
            }
        });
        
        // Update button styles
        tabButtons.forEach(b => { 
            if(b.dataset.tabTarget === name) {
                b.classList.add('bg-blue-50', 'dark:bg-blue-900/30', 'text-blue-600', 'dark:text-blue-400', 'border-blue-200', 'dark:border-blue-700');
                b.classList.remove('bg-gray-50', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300', 'border-gray-200', 'dark:border-gray-600');
            } else {
                b.classList.remove('bg-blue-50', 'dark:bg-blue-900/30', 'text-blue-600', 'dark:text-blue-400', 'border-blue-200', 'dark:border-blue-700');
                b.classList.add('bg-gray-50', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300', 'border-gray-200', 'dark:border-gray-600');
            }
        });
    }

    // Initialize default tab
    showTab('edit');

    // Add event listeners
    tabNavs.forEach(n => n.addEventListener('click', () => showTab(n.dataset.tab)));
    tabButtons.forEach(b => b.addEventListener('click', () => showTab(b.dataset.tabTarget)));

    // Auto-select tab on validation errors
    @if($errors->any())
        @if($errors->has('current_password') || $errors->has('password'))
            showTab('password');
        @else
            showTab('edit');
        @endif
    @endif

    // Photo preview and remove
    const photoInput = document.getElementById('photo');
    const previewImage = document.getElementById('preview-image');
    const previewPlaceholder = document.getElementById('preview-placeholder');
    const removeAvatarBtn = document.getElementById('remove-avatar');

    if(photoInput){
        photoInput.addEventListener('change', function(e){
            const file = e.target.files[0];
            if(file){
                // Validate file size (2MB)
                if(file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file maksimal 2MB',
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                        showConfirmButton: false
                    });
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e){
                    if(previewPlaceholder) previewPlaceholder.style.display = 'none';
                    let img = previewImage;
                    if(!img){
                        img = document.createElement('img');
                        img.id = 'preview-image';
                        img.className = 'h-20 w-20 object-cover rounded-full border-2 border-gray-200 dark:border-gray-600';
                        const container = previewPlaceholder.parentNode;
                        container.insertBefore(img, previewPlaceholder);
                    }
                    img.src = e.target.result;
                    img.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    }

    if(removeAvatarBtn){
        removeAvatarBtn.addEventListener('click', function(){
            Swal.fire({
                title: 'Hapus Foto Profil?',
                text: "Foto profil Anda akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ route("admin.profile.remove-avatar") }}', {
                        method: 'DELETE',
                        headers: { 
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(data => { 
                        if(data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Foto profil berhasil dihapus',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus foto',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    });
                }
            });
        });
    }

    // Password strength
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('password-strength');
    const strengthText = document.getElementById('password-strength-text');
    
    if(passwordInput){
        passwordInput.addEventListener('input', function(){
            const s = calculatePasswordStrength(this.value);
            updatePasswordStrength(s);
        });
    }

    function calculatePasswordStrength(password){
        let score = 0;
        if(password.length >= 8) score += 25;
        if(/[a-z]/.test(password)) score += 25;
        if(/[A-Z]/.test(password)) score += 25;
        if(/[0-9]/.test(password)) score += 25;
        return score;
    }

    function updatePasswordStrength(score){
        strengthBar.style.width = score + '%';
        if(score === 0){ 
            strengthBar.className = 'h-3 bg-gray-300 dark:bg-gray-600 transition-all duration-300'; 
            strengthText.textContent = 'Belum diisi'; 
            strengthText.className = 'text-sm font-medium text-dark dark:text-gray-400';
        }
        else if(score < 50){ 
            strengthBar.className = 'h-3 bg-red-500 transition-all duration-300'; 
            strengthText.textContent = 'Lemah'; 
            strengthText.className = 'text-sm font-medium text-red-500';
        }
        else if(score < 75){ 
            strengthBar.className = 'h-3 bg-yellow-500 transition-all duration-300'; 
            strengthText.textContent = 'Sedang'; 
            strengthText.className = 'text-sm font-medium text-yellow-500';
        }
        else { 
            strengthBar.className = 'h-3 bg-green-500 transition-all duration-300'; 
            strengthText.textContent = 'Kuat'; 
            strengthText.className = 'text-sm font-medium text-green-500';
        }
    }

    // Reset buttons
    document.querySelectorAll('button[type="button"]:not(.tab-btn):not(.tab-nav):not(#remove-avatar)').forEach(btn => {
        if(btn.textContent.trim() === 'Reset') {
            btn.addEventListener('click', function() {
                const form = this.closest('form');
                if(form) {
                    form.reset();
                    if(passwordInput && strengthBar && strengthText) {
                        updatePasswordStrength(0);
                    }
                }
            });
        }
    });
});

function togglePassword(fieldId){
    const f = document.getElementById(fieldId);
    const i = document.getElementById(fieldId + '_icon');
    if(!f) return;
    if(f.type === 'password'){ 
        f.type = 'text'; 
        if(i) i.className = 'ti ti-eye-off'; 
    }
    else { 
        f.type = 'password'; 
        if(i) i.className = 'ti ti-eye'; 
    }
}
</script>

<style>
.fade-in {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endpush

@endsection
