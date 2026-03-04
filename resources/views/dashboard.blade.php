@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
    <div class="page-header">
        <h1>Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
        <p>Kelola data center pendidikan AL-MUJTAMA Anda dengan mudah</p>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-2">Total Pengguna</p>
                            <h3 class="mb-0">{{ $totalUsers }}</h3>
                        </div>
                        <div style="font-size: 32px; color: #667eea;">👥</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-2">Total Role</p>
                            <h3 class="mb-0">{{ $totalRoles }}</h3>
                        </div>
                        <div style="font-size: 32px; color: #764ba2;">🎭</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-2">Role Anda</p>
                            <h5 class="mb-0">{{ auth()->user()->role->display_name ?? 'No Role' }}</h5>
                        </div>
                        <div style="font-size: 32px; color: #28a745;">🔐</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-2">Last Login</p>
                            <p class="mb-0 small">
                                @if(auth()->user()->last_login_at)
                                    {{ auth()->user()->last_login_at->diffForHumans() }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div style="font-size: 32px; color: #ffc107;">⏰</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5>📊 Menu yang Tersedia</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Menu berikut dapat Anda akses berdasarkan role Anda:</p>
                    <div class="row">
                        @php
                            $menus = \App\Helpers\MenuBuilderHelper::getMenusForUser();
                        @endphp

                        @if($menus->isEmpty())
                            <div class="col-12">
                                <p class="text-muted">Tidak ada menu tersedia. Hubungi administrator untuk mendapatkan akses menu.</p>
                            </div>
                        @else
                            @foreach($menus as $menu)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <a href="{{ $menu->route ? route($menu->route) : '#' }}" 
                                       class="text-decoration-none"
                                       style="display: block; padding: 15px; background-color: #f8f9fa; border-radius: 8px; transition: all 0.3s ease;">
                                        <div style="font-size: 24px; margin-bottom: 8px;">
                                            <i class="{{ $menu->icon }}"></i>
                                        </div>
                                        <h6 class="mb-1" style="color: #2c3e50;">{{ $menu->label }}</h6>
                                        <small style="color: #7f8c8d;">{{ $menu->description ?? 'Kelola ' . strtolower($menu->label) }}</small>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>ℹ️ Info Akun Anda</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Nama</label>
                        <p class="mb-0">{{ auth()->user()->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Email</label>
                        <p class="mb-0">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Role</label>
                        <p class="mb-0">
                            <span class="badge bg-primary">{{ auth()->user()->role->display_name ?? 'No Role' }}</span>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Status</label>
                        <p class="mb-0">
                            @if(auth()->user()->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </p>
                    </div>
                    @if(auth()->user()->phone)
                        <div class="mb-3">
                            <label class="text-muted small">Telepon</label>
                            <p class="mb-0">{{ auth()->user()->phone }}</p>
                        </div>
                    @endif
                    @if(auth()->user()->last_login_at)
                        <div class="mb-3">
                            <label class="text-muted small">Login Terakhir</label>
                            <p class="mb-0">{{ auth()->user()->last_login_at->format('d M Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>🔒 Keamanan Akun</h5>
                </div>
                <div class="card-body">
                    <ul style="list-style: none; padding-left: 0;">
                        <li class="mb-2">
                            <i class="fas fa-check-circle" style="color: #28a745;"></i>
                            <span>Password sudah dienkripsi dengan aman</span>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle" style="color: #28a745;"></i>
                            <span>Session dilindungi dengan CSRF token</span>
                        </li>
                        <li>
                            <i class="fas fa-shield-alt" style="color: #0d6efd;"></i>
                            <span><a href="#" style="text-decoration: none;">Ubah password</a></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>📚 Panduan Penggunaan</h5>
                </div>
                <div class="card-body">
                    <ul style="list-style: none; padding-left: 0;">
                        <li class="mb-2">
                            <i class="fas fa-book" style="color: #667eea;"></i>
                            <span><a href="#" style="text-decoration: none;">Dokumentasi Lengkap</a></span>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-video" style="color: #667eea;"></i>
                            <span><a href="#" style="text-decoration: none;">Video Tutorial</a></span>
                        </li>
                        <li>
                            <i class="fas fa-headset" style="color: #667eea;"></i>
                            <span><a href="#" style="text-decoration: none;">Hubungi Support</a></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
