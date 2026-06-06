<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — Data Center AL-MUJTAMA</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/webp" href="https://ppdb.smkalmujtamak.sch.id/logo-amt.webp" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome & SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite(['resources/js/app.js', 'resources/css/app.css'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .bg-custom-gradient {
            background-color: #0a4332 !important; 
            position: relative;
            overflow-x: hidden;
        }
        .bg-custom-gradient:before {
            content: '';
            position: absolute;
            top: 25%;
            left: 0;
            width: 100%;
            height: 75%;
            background: #f1f5f9; 
            border-top-left-radius: 40px;
            border-top-right-radius: 40px;
            z-index: -1;
        }
    </style>
</head>
<body class="bg-custom-gradient min-h-screen flex flex-col items-center justify-center p-4">

    <!-- Card Login Container -->
    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl overflow-hidden z-10 transition-all duration-300">
        
        <!-- Header Brand & Logo -->
        <div class="flex flex-col items-center pt-8 pb-2 px-6">
            <img src="https://ppdb.smkalmujtamak.sch.id/logo-amt.webp" alt="AMT Logo" class="w-16 h-16 object-cover mb-3 drop-shadow-md">
            <h1 class="text-center text-2xl font-extrabold text-gray-800 tracking-tight">DATA CENTER</h1>
            <p class="text-center text-xs font-semibold text-emerald-700 uppercase tracking-widest mt-1">AL-MUJTAMA EDUCATION</p>
        </div>

        <!-- Session & Error Alerts -->
        <div class="px-6 pt-2">
            @if ($errors->any())
                <div class="p-3 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-xs text-red-700 font-medium">
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="p-3 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-xs text-green-700 font-medium">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}" id="login-form" class="p-6 space-y-6">
            @csrf

            {{-- Input Email (Floating Label Potong Border) --}}
            <div class="relative pt-2">
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder=" " 
                       class="peer w-full pl-4 pr-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-700 focus:border-emerald-700 outline-none transition bg-gray-50/30 focus:bg-white font-medium text-sm text-gray-800 z-10" required>
                
                <!-- Perubahan kelas transform untuk memotong border atas -->
                <label for="email" 
                       class="absolute text-sm text-gray-400 duration-200 transform -translate-y-7 scale-85 top-6 z-20 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-85 peer-focus:-translate-y-7 peer-focus:text-emerald-700 font-medium pointer-events-none bg-white px-1.5">
                    Alamat Email
                </label>
            </div>

            {{-- Input Password (Floating Label Potong Border) --}}
            <div class="relative pt-2">
                <input type="password" id="password" name="password" placeholder=" " 
                       class="peer w-full pl-4 pr-12 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-700 focus:border-emerald-700 outline-none transition bg-gray-50/30 focus:bg-white font-medium text-sm text-gray-800 z-10" required>
                
                <!-- Perubahan kelas transform untuk memotong border atas -->
                <label for="password" 
                       class="absolute text-sm text-gray-400 duration-200 transform -translate-y-7 scale-85 top-6 z-20 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-85 peer-focus:-translate-y-7 peer-focus:text-emerald-700 font-medium pointer-events-none bg-white px-1.5">
                    Password
                </label>
                
                <!-- Toggle Password Tombol -->
                <button type="button" id="toggle-pwd" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-emerald-800 transition z-20 pt-2">
                    <i class="fas fa-eye" id="eye-icon"></i>
                </button>
            </div>

            {{-- Opsi Remember & Lupa Password --}}
            <div class="flex justify-between items-center px-1">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}
                           class="h-4 w-4 text-emerald-700 focus:ring-emerald-600 border-gray-300 rounded cursor-pointer">
                    <label for="remember" class="ml-2 block text-xs font-semibold text-gray-600 cursor-pointer select-none">Ingat Saya</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-bold text-emerald-800 hover:text-emerald-600 transition-colors">Lupa Password?</a>
                @endif
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" id="btn-submit" 
                    class="w-full bg-emerald-800 text-white py-3.5 px-4 rounded-xl hover:bg-emerald-700 active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 transition font-bold text-sm shadow-md shadow-emerald-900/10 flex items-center justify-center gap-2">
                <i class="fas fa-sign-in-alt"></i>
                <span id="btn-text">Masuk ke Sistem</span>
            </button>
            
            {{-- Garis Pembatas --}}
            <div class="relative flex items-center py-1">
                <div class="flex-grow border-t border-gray-200"></div>
                <span class="flex-shrink mx-4 text-gray-400 font-medium text-xs uppercase tracking-wider">Atau</span>
                <div class="flex-grow border-t border-gray-200"></div>
            </div>
            
            {{-- Tombol Integrasi Registrasi --}}
            <div class="text-center text-sm font-medium text-gray-500">
                Belum memiliki akses akun? 
                <a href="{{ route('register') }}" class="font-bold text-emerald-800 hover:text-emerald-600 transition-colors ml-1">
                    Daftar di sini
                </a>
            </div>
        </form>
        
        <!-- Footer Info -->
        <div class="bg-gray-50/80 px-6 py-4 border-t border-gray-100 text-center">
            <p class="text-[11px] font-medium text-gray-400 uppercase tracking-wider">
                &copy; {{ date('Y') }} Data Center AL-MUJTAMA — v2.5
            </p>
        </div>
    </div>

    <!-- Script Logic Loading & Toggle Mata Password -->
    <script>
        const toggleBtn = document.getElementById('toggle-pwd');
        const pwdInput  = document.getElementById('password');
        const eyeIcon   = document.getElementById('eye-icon');

        toggleBtn.addEventListener('click', () => {
            const isHidden = pwdInput.type === 'password';
            pwdInput.type  = isHidden ? 'text' : 'password';
            eyeIcon.className = isHidden ? 'fas fa-eye-slash' : 'fas fa-eye';
        });

        const form      = document.getElementById('login-form');
        const btnSubmit = document.getElementById('btn-submit');
        const btnText   = document.getElementById('btn-text');

        form.addEventListener('submit', () => {
            btnSubmit.disabled = true;
            btnSubmit.style.opacity = '0.8';
            btnText.textContent = 'Memproses autentikasi...';
        });
    </script>
</body>
</html>