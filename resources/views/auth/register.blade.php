<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Data Center AL-MUJTAMA</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 450px;
        }

        .register-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            padding: 40px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .register-header .logo {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 32px;
        }

        .register-header h2 {
            color: #2c3e50;
            margin-bottom: 5px;
            font-weight: 700;
        }

        .register-header p {
            color: #7f8c8d;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input.is-invalid,
        .form-group select.is-invalid {
            border-color: #dc3545;
            background-color: #fff5f5;
        }

        .form-group input.is-invalid:focus,
        .form-group select.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .form-error {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.4);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .register-footer {
            text-align: center;
            border-top: 1px solid #e0e0e0;
            padding-top: 20px;
        }

        .register-footer p {
            color: #7f8c8d;
            font-size: 14px;
            margin: 0;
        }

        .register-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            border: none;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        @media (max-width: 480px) {
            .register-card {
                padding: 30px 20px;
            }

            .register-header {
                margin-bottom: 25px;
            }

            .register-header .logo {
                width: 60px;
                height: 60px;
                font-size: 28px;
            }

            .register-header h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="logo">📋</div>
                <h2>Daftar Akun</h2>
                <p>Buat akun Data Center AL-MUJTAMA</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Validasi Error!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li style="font-size: 13px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap Anda"
                        required
                        class="@error('name') is-invalid @enderror"
                    >
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder="Masukkan email Anda"
                        required
                        class="@error('email') is-invalid @enderror"
                    >
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role_id">Role / Posisi</label>
                    <select 
                        id="role_id" 
                        name="role_id" 
                        required
                        class="@error('role_id') is-invalid @enderror"
                    >
                        <option value="">-- Pilih Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Minimal 6 karakter"
                        required
                        class="@error('password') is-invalid @enderror"
                    >
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="Ulangi password Anda"
                        required
                        class="@error('password_confirmation') is-invalid @enderror"
                    >
                    @error('password_confirmation')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-register">Daftar Sekarang</button>

                <div class="register-footer">
                    <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
