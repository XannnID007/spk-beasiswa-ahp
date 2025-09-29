<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SPK Beasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
            --sidebar-width: 260px;
            --navbar-height: 65px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f3f4f6;
        }

        /* Navbar Fixed */
        .navbar-top {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--navbar-height);
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 25px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 18px;
            margin-right: auto;
        }

        .navbar-brand i {
            font-size: 28px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .user-profile:hover {
            background: #f3f4f6;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: #374151;
        }

        .user-role {
            font-size: 12px;
            color: #6b7280;
        }

        /* Sidebar Fixed */
        .sidebar {
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--navbar-height));
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            overflow-y: auto;
            padding: 20px 0;
            z-index: 999;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu-item {
            margin: 5px 15px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: #6b7280;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        }

        .menu-link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .menu-link:hover {
            background: #f3f4f6;
            color: var(--primary-color);
        }

        .menu-link.active {
            background: var(--primary-color);
            color: white;
        }

        .menu-link.active:hover {
            background: #1e40af;
        }

        .menu-title {
            font-size: 11px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px 30px 8px 30px;
            margin-top: 10px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 25px;
            min-height: calc(100vh - var(--navbar-height));
        }

        .page-header {
            background: white;
            padding: 20px 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .page-subtitle {
            font-size: 14px;
            color: #6b7280;
            margin: 5px 0 0 0;
        }

        .content-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 25px;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 8px;
            margin-top: 8px;
        }

        .dropdown-item {
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .dropdown-item:hover {
            background: #f3f4f6;
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar Top -->
    <nav class="navbar-top">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
            <i class="fas fa-graduation-cap"></i>
            <span>SPK Beasiswa</span>
        </a>

        <div class="navbar-right">
            <div class="dropdown">
                <div class="user-profile" data-bs-toggle="dropdown">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">Administrator</div>
                    </div>
                    <i class="fas fa-chevron-down" style="font-size: 12px; color: #9ca3af;"></i>
                </div>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                            <i class="fas fa-user"></i> Profil
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.settings') }}">
                            <i class="fas fa-cog"></i> Pengaturan
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <div class="menu-title">Master Data</div>

            <li class="menu-item">
                <a href="{{ route('admin.beasiswa.index') }}"
                    class="menu-link {{ request()->routeIs('admin.beasiswa.*') ? 'active' : '' }}">
                    <i class="fas fa-award"></i>
                    <span>Data Beasiswa</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.siswa.index') }}"
                    class="menu-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Data Siswa</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.kriteria.index') }}"
                    class="menu-link {{ request()->routeIs('admin.kriteria.*') ? 'active' : '' }}">
                    <i class="fas fa-list-check"></i>
                    <span>Data Kriteria</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.sub-kriteria.index') }}"
                    class="menu-link {{ request()->routeIs('admin.sub-kriteria.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i>
                    <span>Data Sub-Kriteria</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.pengajuan.index') }}"
                    class="menu-link {{ request()->routeIs('admin.pengajuan.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Pengajuan Beasiswa</span>
                </a>
            </li>

            <div class="menu-title">Perhitungan AHP</div>

            <li class="menu-item">
                <a href="{{ route('admin.penilaian.index') }}"
                    class="menu-link {{ request()->routeIs('admin.penilaian.*') ? 'active' : '' }}">
                    <i class="fas fa-edit"></i>
                    <span>Input Penilaian</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.perhitungan.index') }}"
                    class="menu-link {{ request()->routeIs('admin.perhitungan.*') ? 'active' : '' }}">
                    <i class="fas fa-calculator"></i>
                    <span>Proses Perhitungan</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.hasil.index') }}"
                    class="menu-link {{ request()->routeIs('admin.hasil.*') ? 'active' : '' }}">
                    <i class="fas fa-trophy"></i>
                    <span>Hasil & Ranking</span>
                </a>
            </li>

            <div class="menu-title">Laporan</div>

            <li class="menu-item">
                <a href="{{ route('admin.laporan.index') }}"
                    class="menu-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <i class="fas fa-file-pdf"></i>
                    <span>Cetak Laporan</span>
                </a>
            </li>

            <div class="menu-title">Pengaturan</div>

            <li class="menu-item">
                <a href="{{ route('admin.users.index') }}"
                    class="menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i>
                    <span>Manajemen User</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
