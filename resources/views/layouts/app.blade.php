<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - PT. Elastomix Indonesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <style>
        :root {
            --sidebar-width: 260px;
            --topbar-height: 60px;
            --primary-blue: #337ab7;
            --dark-blue: #2e6da4;
            --bg-light: #f4f7f9;
            --sidebar-bg: #f8f9fa;
            --text-main: #333;
            --text-muted: #777;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            border-right: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        .sidebar-header .data-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 5px;
        }

        .sidebar-header .date-text {
            font-size: 0.85rem;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-menu {
            padding: 20px 0;
            flex-grow: 1;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            color: var(--text-main);
            font-size: 0.9rem;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .menu-item i {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }

        .menu-item.active {
            background-color: var(--primary-blue);
            color: var(--white);
            border-left-color: #23527c;
        }

        .menu-item:hover:not(.active) {
            background-color: #f0f0f0;
        }

        .menu-category {
            padding: 15px 20px 5px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        /* Main Content Area */
        .main-container {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        .topbar {
            height: var(--topbar-height);
            background-color: var(--white);
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .company-logo {
            height: 35px;
        }

        .company-name {
            font-weight: 600;
            color: #555;
            font-size: 1.1rem;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-profile-wrapper {
            position: relative;
        }

        .user-profile {
            background-color: #34495e;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .user-profile:hover {
            background-color: #2c3e50;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 10px;
            background-color: var(--white);
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            min-width: 180px;
            display: none;
            z-index: 1000;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            text-decoration: none;
            color: var(--text-main);
            font-size: 0.85rem;
            transition: background-color 0.2s;
            border: none;
            width: 100%;
            background: none;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #f5f5f5;
        }

        .dropdown-item i {
            width: 18px;
            margin-right: 10px;
            color: var(--text-muted);
        }

        .dropdown-divider {
            height: 1px;
            background-color: #eee;
            margin: 5px 0;
        }

        /* Content */
        .content {
            padding: 30px;
        }

        .page-title {
            font-size: 1.5rem;
            color: #444;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }


        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-container {
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="data-label">Data</div>
            <div class="date-text">
                <i class="far fa-calendar-alt"></i>
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>

        <nav class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Beranda
            </a>

            <div class="menu-category">MENU TREE</div>
            <a href="{{ route('wi.index') }}" class="menu-item {{ request()->routeIs('wi.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Work Instructions
            </a>
            <a href="{{ route('std.index') }}" class="menu-item {{ request()->routeIs('std.*') ? 'active' : '' }}">
                <i class="fas fa-file-contract"></i> Support Documents
            </a>
            <a href="{{ route('msds.index') }}" class="menu-item {{ request()->routeIs('msds.*') ? 'active' : '' }}">
                <i class="fas fa-file-medical"></i> MSDS
            </a>
            <a href="{{ route('coa.index') }}" class="menu-item {{ request()->routeIs('coa.*') ? 'active' : '' }}">
                <i class="fas fa-file-signature"></i> Certificate of Analysis
            </a>

            <form action="{{ route('logout') }}" method="POST" style="margin-top: 20px;">
                @csrf
                <button type="submit" class="menu-item"
                    style="width: 100%; border: none; background: none; cursor: pointer; text-align: left;">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <img src="{{ asset('public/storage/foto/1.png') }}" alt="EMIX" class="company-logo">
                <span class="company-name">PT. Elastomix Indonesia</span>
            </div>
            <div class="topbar-right">
                <div class="user-profile-wrapper">
                    <div class="user-profile" id="userDropdownTrigger">
                        <i class="fas fa-user-alt"></i>
                    </div>
                    <div class="dropdown-menu" id="userDropdownMenu">
                        <div style="padding: 10px 15px; border-bottom: 1px solid #eee;">
                            <div style="font-size: 0.85rem; font-weight: 600; color: #333;">{{ Auth::user()->name }}
                            </div>
                            <div style="font-size: 0.75rem; color: #777;">{{ ucfirst(Auth::user()->role) }}</div>
                        </div>

                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('users.index') }}" class="dropdown-item">
                                <i class="fas fa-users-cog"></i> Kelola User
                            </a>
                            <div class="dropdown-divider"></div>
                        @endif

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item" style="color: #dc3545;">
                                <i class="fas fa-sign-out-alt" style="color: #dc3545;"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="content">
            @yield('content')
        </main>

    </div>

    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const trigger = document.getElementById('userDropdownTrigger');
            const menu = document.getElementById('userDropdownMenu');

            if (trigger && menu) {
                trigger.addEventListener('click', function (e) {
                    e.stopPropagation();
                    menu.classList.toggle('show');
                });

                document.addEventListener('click', function (e) {
                    if (!menu.contains(e.target) && !trigger.contains(e.target)) {
                        menu.classList.remove('show');
                    }
                });
            }
        });
    </script>
</body>

</html>