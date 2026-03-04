<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm(Request $request)
    {
        // Force session initialization
        $request->session()->start();
        return view('auth.login');
    }

    /**
     * Process login
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
            'remember' => 'nullable|boolean'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar di sistem',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        // Check if user is active
        $user = User::where('email', $request->email)->first();
        if ($user && !$user->is_active) {
            throw ValidationException::withMessages([
                'email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.'
            ]);
        }

        // Attempt authentication
        if (!Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $validated['remember'] ?? false)) {
            throw ValidationException::withMessages([
                'password' => 'Password yang Anda masukkan salah.'
            ]);
        }

        // Update last login
        Auth::user()->updateLastLogin();

        // Regenerate session
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Selamat datang kembali, ' . Auth::user()->name);
    }

    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        $roles = Role::where('is_active', true)->get();
        return view('auth.register', compact('roles'));
    }

    /**
     * Process register
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id'
        ], [
            'name.required' => 'Nama harus diisi',
            'name.min' => 'Nama minimal 3 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role_id.required' => 'Role harus dipilih',
            'role_id.exists' => 'Role tidak valid'
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
            'is_active' => true,
        ]);

        // Auto login
        Auth::login($user);
        $user->updateLastLogin();

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Data Center.');
    }

    /**
     * Show forgot password form
     */
    public function showResetForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Process logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout dari sistem.');
    }
}
