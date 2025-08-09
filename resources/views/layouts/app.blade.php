{{-- resources/views/layouts/app.blade.php --}}
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title-page', 'Sistem Resepsionis Surat')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    {{-- PASTIKAN PATH INI BENAR SESUAI PROYEK ANDA --}}
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}" /> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    @stack('styles')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-person-fill"></i> {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                             <a href="{{ route('profile.edit') ?? '#' }}" class="dropdown-item">
                                <i class="bi bi-gear-fill me-2"></i> Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                            </form>
                        </div>
                    </li>
                    @endauth
                </ul>
            </div>
        </nav>

        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('admin.dashboard') : route('viewer.dashboard') }}" class="brand-link">
                    <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="brand-image opacity-75 shadow" />
                    <span class="brand-text fw-light">Sistem Resepsionis</span>
                </a>
            </div>

            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        {{-- Dashboard --}}
                        <li class="nav-item">
                            <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('admin.dashboard') : route('viewer.dashboard') }}"
                               class="nav-link {{ request()->routeIs('admin.dashboard') || request()->routeIs('viewer.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        {{-- Surat Masuk --}}
                        <li class="nav-item">
                            <a href="{{ route('surat-masuk.index') }}" class="nav-link {{ request()->routeIs('surat-masuk.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-inbox-fill"></i>
                                <p>Surat Masuk</p>
                            </a>
                        </li>

                        {{-- Surat Keluar --}}
                        <li class="nav-item">
                            <a href="{{ route('surat-keluar.index') }}" class="nav-link {{ request()->routeIs('surat-keluar.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-send-fill"></i>
                                <p>Surat Keluar</p>
                            </a>
                        </li>

                        {{-- Arsip Surat --}}
                        <li class="nav-item">
                            <a href="{{ route('arsip.index') }}" class="nav-link {{ request()->routeIs('arsip.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-archive-fill"></i>
                                <p>Arsip Surat</p>
                            </a>
                        </li>

                        {{-- Manajemen User (Admin only) --}}
                        @if(auth()->check() && auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-people-fill"></i>
                                <p>Manajemen User</p>
                            </a>
                        </li>
                        @endif

                        {{-- Logout --}}
                        <li class="nav-item mt-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link text-start w-100" style="color: inherit; text-decoration: none;">
                                    <i class="nav-icon bi bi-box-arrow-right"></i>
                                    <p class="mb-0">Logout</p>
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">@yield('title', 'Dashboard')</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('admin.dashboard') : route('viewer.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">@yield('title', 'Dashboard')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    {{-- flash messages --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"></script>
    {{-- PASTIKAN PATH INI BENAR SESUAI PROYEK ANDA --}}
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    @stack('scripts')
    @yield('scripts')
</body>
</html>