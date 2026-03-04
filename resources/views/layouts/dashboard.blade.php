<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Data Center AL-MUJTAMA</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --sidebar-bg: #2c3e50;
            --sidebar-text: #ecf0f1;
            --sidebar-hover: #34495e;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f6fa;
        }

        /* Sidebar Styles */
        .sidebar {
            background-color: var(--sidebar-bg);
            min-height: 100vh;
            padding: 20px 0;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar .brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .sidebar .brand h5 {
            color: var(--sidebar-text);
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 16px;
        }

        .sidebar .brand p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            margin: 0;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
        }

        .sidebar-nav .nav-item {
            margin: 5px 0;
        }

        .sidebar-nav .nav-link {
            color: var(--sidebar-text);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            font-size: 14px;
        }

        .sidebar-nav .nav-link:hover {
            background-color: var(--sidebar-hover);
            border-left-color: var(--primary-color);
            color: white;
        }

        .sidebar-nav .nav-link.active {
            background-color: var(--primary-color);
            border-left-color: var(--primary-color);
            color: white;
        }

        .sidebar-nav .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }

        .sidebar-nav .has-children .collapse {
            background-color: rgba(0, 0, 0, 0.2);
        }

        .sidebar-nav .has-children .nav-sm {
            padding-left: 0;
            list-style: none;
        }

        .sidebar-nav .has-children .nav-sm .nav-link {
            padding-left: 45px;
            font-size: 13px;
        }

        .sidebar-nav .chevron {
            margin-left: auto;
            font-size: 11px;
            transition: transform 0.3s ease;
        }

        .sidebar-nav .chevron.collapsed {
            transform: rotate(-90deg);
        }

        /* Main Content */
        .main-wrapper {
            margin-left: 250px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar-top {
            background-color: white;
            padding: 15px 30px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .navbar-top .page-title {
            font-weight: 500;
            color: #2c3e50;
        }

        .navbar-top .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .navbar-top .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .navbar-top .user-name {
            display: flex;
            flex-direction: column;
            line-height: 1.3;
        }

        .navbar-top .user-name .name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
        }

        .navbar-top .user-name .role {
            font-size: 12px;
            color: #7f8c8d;
        }

        .navbar-top .dropdown-menu {
            min-width: 200px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .navbar-top .dropdown-item {
            padding: 10px 20px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .navbar-top .dropdown-item:hover {
            background-color: #f8f9fa;
            color: var(--primary-color);
        }

        .navbar-top .dropdown-item i {
            width: 16px;
            margin-right: 10px;
            color: var(--primary-color);
        }

        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .content .page-header {
            margin-bottom: 30px;
        }

        .content .page-header h1 {
            font-size: 28px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .content .page-header p {
            color: #7f8c8d;
            margin: 0;
            font-size: 14px;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }

        .card-header h5 {
            margin: 0;
            font-weight: 600;
            color: #2c3e50;
        }

        .card-body {
            padding: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                min-height: auto;
                position: relative;
                padding: 0;
            }

            .main-wrapper {
                margin-left: 0;
            }

            .content {
                padding: 20px;
            }

            .content .page-header h1 {
                font-size: 24px;
            }

            .navbar-top {
                flex-wrap: wrap;
                gap: 15px;
            }

            .navbar-top .page-title {
                flex: 1 0 100%;
            }
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="brand">
                <h5>📊 DATA CENTER</h5>
                <p>AL-MUJTAMA</p>
            </div>
            <ul class="sidebar-nav">
                {!! App\Helpers\MenuBuilderHelper::renderSidebar() !!}
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-wrapper">
            <!-- Top Navbar -->
            <nav class="navbar-top">
                <div class="page-title">
                    <h6 class="mb-0">@yield('breadcrumb', 'Dashboard')</h6>
                </div>
                <div class="user-info">
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle d-flex align-items-center gap-3" 
                           id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                           style="text-decoration: none; color: inherit;">
                            <div class="user-avatar">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="user-name">
                                <div class="name">{{ auth()->user()->name }}</div>
                                <div class="role">{{ auth()->user()->role->display_name ?? 'No Role' }}</div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-key"></i> Ubah Password</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Content -->
            <div class="content">
                @if ($message = session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>✓ Berhasil!</strong> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($message = session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>✗ Gagal!</strong> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Validasi Error!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('scripts')
</body>
</html>
