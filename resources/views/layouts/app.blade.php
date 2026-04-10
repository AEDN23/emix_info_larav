<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - PT. Elastomix Indonesia</title>
    <link rel="shortcut icon" href="{{ asset('public/storage/foto/1.png') }}?v=1" type="image/png">
    <link rel="icon" href="{{ asset('public/storage/foto/1x`.png') }}?v=1" type="image/png">
    <link href="{{ asset('public/css/css2.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/css/all.min.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('public/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/dataTables.bootstrap5.min.css') }}">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg-main: #f9fafb;
            --sidebar-bg: #111827;
            --sidebar-hover: #1f2937;
            --text-sidebar: #9ca3af;
            --text-sidebar-active: #ffffff;
        }

        body {
            background-color: var(--bg-main);
            font-family: 'Inter', sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        /* Sidebar styling */
        #sidebar {
            width: 260px;
            height: 100vh;
            background-color: var(--sidebar-bg);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }

        /* Brand area */
        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            text-decoration: none;
        }

        .sidebar-brand .logo-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .sidebar-brand span {
            color: white;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* Menu container */
        .sidebar-menu {
            padding: 24px 16px;
            overflow-y: auto;
            flex-grow: 1;
        }

        /* Active link style */
        .sidebar-menu .nav-link {
            color: var(--text-sidebar);
            border-radius: 8px;
            padding: 10px 16px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
        }

        .sidebar-menu .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: white;
        }

        .sidebar-menu .nav-link.active {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }

        .sidebar-menu .nav-link i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 10px;
            text-align: center;
        }

        .menu-header {
            color: #6b7280;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 24px 0 12px 16px;
        }

        /* Main Layout */
        #main-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Header */
        .top-header {
            height: 70px;
            background: white;
            padding: 0 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .top-header .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .datetime-display {
            font-size: 0.85rem;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 8px;
            padding-right: 20px;
            border-right: 1px solid #e5e7eb;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 8px;
            transition: background 0.2s;
            position: relative;
        }

        .user-dropdown:hover {
            background: #f3f4f6;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-info .name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #111827;
            line-height: 1.2;
        }

        .user-info .role {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .dropdown-menu-custom {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 10px;
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            display: none;
            z-index: 1000;
            padding: 8px 0;
        }

        .dropdown-menu-custom.show {
            display: block;
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item-custom {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            color: #4b5563;
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.2s;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-item-custom:hover {
            background-color: #f3f4f6;
            color: #111827;
        }

        .dropdown-item-custom i {
            width: 20px;
            margin-right: 10px;
            color: #6b7280;
        }

        .dropdown-item-custom.text-danger:hover {
            background-color: #fef2f2;
            color: #dc2626;
        }

        .dropdown-item-custom.text-danger:hover i {
            color: #dc2626;
        }

        /* Content Area */
        .content-area {
            padding: 32px;
            flex-grow: 1;
            background: #f9fafb;
        }

        /* Card styles for general use */
        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border-radius: 8px;
            border: none;
        }

        /* Animation utilities */
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Sidebar -->
    <aside id="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <div class="logo-icon">
                <i class="fas fa-chart-line text-white"></i>
            </div>
            <span>EMIX INFO</span>
        </a>

        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>

            <div class="menu-header">DOKUMENTASI</div>

            <a href="{{ route('wi.index') }}" class="nav-link {{ request()->routeIs('wi.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Work Instructions
            </a>
            <a href="{{ route('std.index') }}" class="nav-link {{ request()->routeIs('std.*') ? 'active' : '' }}">
                <i class="fas fa-file-contract"></i> Support Documents
            </a>
            <a href="{{ route('msds.index') }}" class="nav-link {{ request()->routeIs('msds.*') ? 'active' : '' }}">
                <i class="fas fa-file-medical"></i> MSDS
            </a>
            <a href="{{ route('coa.index') }}" class="nav-link {{ request()->routeIs('coa.*') ? 'active' : '' }}">
                <i class="fas fa-file-signature"></i> Certificate of Analysis
            </a>

            @auth
                @if(Auth::user()->role === 'admin')
                    <div class="menu-header">ADMINISTRASI</div>
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i> Kelola User
                    </a>
                @endif
            @endauth
        </div>
    </aside>

    <!-- Main Content -->
    <div id="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <h1 class="page-title">@yield('title', 'Beranda')</h1>

            <div class="header-actions">
                <div class="datetime-display">
                    <i class="far fa-calendar-alt"></i>
                    <span id="currentDateTime">{{ now()->translatedFormat('l, d F Y') }} <span id="clock"
                            class="ms-1"></span></span>
                </div>

                @auth
                    <div class="user-dropdown" id="userMenuBtn">
                        <div class="user-info text-end d-none d-sm-block">
                            <span class="name">{{ Auth::user()->name }}</span>
                            <span class="role">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <i class="fas fa-chevron-down ms-1" style="font-size: 0.75rem; color: #6b7280;"></i>

                        <!-- Dropdown Menu -->
                        <div class="dropdown-menu-custom" id="userDropdown">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item-custom text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-4 rounded-pill">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                @endauth
            </div>
        </header>

        <!-- Dynamic Content -->
        <main class="content-area">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center animate-fade-in"
                    role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm mb-4 d-flex align-items-center animate-fade-in"
                    role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if($errors->any() && !request()->is('login'))
                <div class="alert alert-danger border-0 shadow-sm mb-4 animate-fade-in" role="alert">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <span class="fw-bold">Terjadi Kesalahan!</span>
                    </div>
                    <ul class="mb-0 ps-4 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Move jQuery here, before Bootstrap JS -->
    <script src="{{ asset('public/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/js/dataTables.bootstrap5.min.js') }}"></script>

    <script>
        // User Dropdown Logic
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');

        if (userMenuBtn) {
            userMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('show');
            });

            document.addEventListener('click', (e) => {
                if (!userMenuBtn.contains(e.target)) {
                    userDropdown.classList.remove('show');
                }
            });
        }

        // Real-time Clock
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('clock').textContent = timeString;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
    @yield('scripts')
</body>

</html>