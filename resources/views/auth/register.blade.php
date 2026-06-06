<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar — Data Center AL-MUJTAMA</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/webp" href="https://ppdb.smkalmujtamak.sch.id/logo-amt.webp" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome & Vite -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/js/app.js', 'resources/css/app.css'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Mengikuti skema warna hijau botol Al-Mujtama final */
        .bg-custom-gradient {
            background-color: #0a4332 !important; 
            position: relative;
            overflow-x: hidden;
        }
        /* Model lengkungan background bawah disamakan */
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

    <!-- Card Register Container (Sedikit dilebarkan max-w-lg agar form role & input nyaman berdampingan) -->
    <div class="max-w-lg w-full bg-white rounded-2xl shadow-2xl overflow-hidden z-10 my-6 transition-all duration-300">
        
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
                    <strong class="block mb-1">Validasi Gagal:</strong>
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Form Register -->
        <form method="POST" action="{{ route('register') }}" id="register-form" class="p-6 space-y-6">
            @csrf

            {{-- Input Nama Lengkap --}}
            <div class="relative pt-2">
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder=" " 
                       class="peer w-full pl-4 pr-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-700 focus:border-emerald-700 outline-none transition bg-gray-50/30 focus:bg-white font-medium text-sm text-gray-800 z-10 @error('name') border-red-500 @enderror" required>
                <label for="name" 
                       class="absolute text-sm text-gray-400 duration-200 transform -translate-y-7 scale-85 top-6 z-20 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-85 peer-focus:-translate-y-7 peer-focus:text-emerald-700 font-medium pointer-events-none bg-white px-1.5">
                    Nama Lengkap
                </label>
            </div>

            {{-- Input Email --}}
            <div class="relative pt-2">
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder=" " 
                       class="peer w-full pl-4 pr-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-700 focus:border-emerald-700 outline-none transition bg-gray-50/30 focus:bg-white font-medium text-sm text-gray-800 z-10 @error('email') border-red-500 @enderror" required>
                <label for="email" 
                       class="absolute text-sm text-gray-400 duration-200 transform -translate-y-7 scale-85 top-6 z-20 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-85 peer-focus:-translate-y-7 peer-focus:text-emerald-700 font-medium pointer-events-none bg-white px-1.5">
                    Alamat Email
                </label>
            </div>

            {{-- Input Role / Posisi (Floating Style) --}}
            <div class="relative pt-2">
                <select id="role_id" name="role_id" required 
                        class="peer w-full pl-4 pr-10 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-700 focus:border-emerald-700 outline-none transition bg-gray-50/30 focus:bg-white font-medium text-sm text-gray-800 z-10 appearance-none @error('role_id') border-red-500 @enderror">
                    <option value="" disabled {{ old('role_id') ? '' : 'selected' }}></option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>
                            {{ $role->display_name }}
                        </option>
                    @endforeach
                </select>
                <label for="role_id" 
                       class="absolute text-sm text-gray-400 duration-200 transform -translate-y-7 scale-85 top-6 z-20 origin-[0] left-4 peer-focus:scale-85 peer-focus:-translate-y-7 peer-focus:text-emerald-700 font-medium pointer-events-none bg-white px-1.5 {{ old('role_id') ? '' : 'peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0' }}">
                    Pilih Role / Posisi
                </label>
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none pt-2 z-20">
                    <i class="fas fa-chevron-down text-xs"></i>
                </div>
            </div>

            {{-- Input Password --}}
            <div class="relative pt-2">
                <input type="password" id="password" name="password" placeholder=" " 
                       class="peer w-full pl-4 pr-12 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-700 focus:border-emerald-700 outline-none transition bg-gray-50/30 focus:bg-white font-medium text-sm text-gray-800 z-10 @error('password') border-red-500 @enderror" required>
                <label for="password" 
                       class="absolute text-sm text-gray-400 duration-200 transform -translate-y-7 scale-85 top-6 z-20 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-85 peer-focus:-translate-y-7 peer-focus:text-emerald-700 font-medium pointer-events-none bg-white px-1.5">
                    Password (Minimal 6 Karakter)
                </label>
                <button type="button" id="toggle-pwd" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-emerald-800 transition z-20 pt-2">
                    <i class="fas fa-eye" id="eye-icon"></i>
                </button>
            </div>

            {{-- Input Konfirmasi Password --}}
            <div class="relative pt-2">
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder=" " 
                       class="peer w-full pl-4 pr-12 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-700 focus:border-emerald-700 outline-none transition bg-gray-50/30 focus:bg-white font-medium text-sm text-gray-800 z-10 @error('password_confirmation') border-red-500 @enderror" required>
                <label for="password_confirmation" 
                       class="absolute text-sm text-gray-400 duration-200 transform -translate-y-7 scale-85 top-6 z-20 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-85 peer-focus:-translate-y-7 peer-focus:text-emerald-700 font-medium pointer-events-none bg-white px-1.5">
                    Konfirmasi Password
                </label>
                <button type="button" id="toggle-pwd-confirm" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-emerald-800 transition z-20 pt-2">
                    <i class="fas fa-eye" id="eye-icon-confirm"></i>
                </button>
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" id="btn-submit" 
                    class="w-full bg-emerald-800 text-white py-3.5 px-4 rounded-xl hover:bg-emerald-700 active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 transition font-bold text-sm shadow-md shadow-emerald-900/10 flex items-center justify-center gap-2">
                <i class="fas fa-user-plus"></i>
                <span id="btn-text">Daftar Sekarang</span>
            </button>
            
            {{-- Garis Pembatas --}}
            <div class="relative flex items-center py-1">
                <div class="flex-grow border-t border-gray-200"></div>
                <span class="flex-shrink mx-4 text-gray-400 font-medium text-xs uppercase tracking-wider">Atau</span>
                <div class="flex-grow border-t border-gray-200"></div>
            </div>
            
            {{-- Tombol Kembali ke Login --}}
            <div class="text-center text-sm font-medium text-gray-500">
                Sudah memiliki akses akun? 
                <a href="{{ route('login') }}" class="font-bold text-emerald-800 hover:text-emerald-600 transition-colors ml-1">
                    Login di sini
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

    <!-- Script Logic Eye Toggles & Loading Form -->
    <script>
        // Toggle Password Utama
        const togglePwd = document.getElementById('toggle-pwd');
        const pwdInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        togglePwd.addEventListener('click', () => {
            const isHidden = pwdInput.type === 'password';
            pwdInput.type = isHidden ? 'text' : 'password';
            eyeIcon.className = isHidden ? 'fas fa-eye-slash' : 'fas fa-eye';
        });

        // Toggle Konfirmasi Password
        const togglePwdConfirm = document.getElementById('toggle-pwd-confirm');
        const pwdConfirmInput = document.getElementById('password_confirmation');
        const eyeIconConfirm = document.getElementById('eye-icon-confirm');

        togglePwdConfirm.addEventListener('click', () => {
            const isHidden = pwdConfirmInput.type === 'password';
            pwdConfirmInput.type = isHidden ? 'text' : 'password';
            eyeIconConfirm.className = isHidden ? 'fas fa-eye-slash' : 'fas fa-eye';
        });

        // Efek loading sewaktu form disubmit
        const form = document.getElementById('register-form');
        const btnSubmit = document.getElementById('btn-submit');
        const btnText = document.getElementById('btn-text');

        form.addEventListener('submit', () => {
            btnSubmit.disabled = true;
            btnSubmit.style.opacity = '0.8';
            btnText.textContent = 'Mendaftarkan akun...';
        });
    </script>
</body>
</html>