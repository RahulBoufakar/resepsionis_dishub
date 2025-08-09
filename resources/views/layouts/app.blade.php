{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Sistem Resepsionis Surat')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Optional: Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root{
            --brand: #3754d3;
            --muted: #6c757d;
            --card-radius: 14px;
        }
        html,body{ height:100%; }
        body {
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: #f5f7fb;
            color: #273043;
        }

        /* SIDEBAR */
        .app-sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, rgba(55,84,211,0.06), transparent 40%);
            border-right: 1px solid rgba(99,115,129,0.06);
        }
        .brand {
            display:flex;
            align-items:center;
            gap:.75rem;
            padding:1rem;
        }
        .brand img { width:44px; height:auto; }

        .nav-link.active {
            background: linear-gradient(90deg, rgba(55,84,211,0.12), rgba(55,84,211,0.06));
            border-radius: 10px;
            color: var(--brand) !important;
            font-weight: 600;
        }

        .card-soft {
            border-radius: var(--card-radius);
            box-shadow: 0 8px 20px rgba(32,40,60,0.04);
            background: #fff;
        }

        .topbar {
            background: #ffffffcc;
            backdrop-filter: blur(6px);
            border-bottom: 1px solid rgba(99,115,129,0.06);
        }

        .user-avatar {
            width:36px;
            height:36px;
            border-radius:50%;
            background: #e9eefb;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            color:var(--brand);
            font-weight:700;
        }

        @media (max-width: 991.98px) {
            .app-sidebar { display: none; }
        }
    </style>

    @stack('styles')
</head>
<body>
<nav class="navbar topbar shadow-sm">
    <div class="container-fluid">
        <div class="d-flex align-items-center gap-3">
            {{-- Sidebar toggle for mobile --}}
            <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 2.5 4h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 4.5z"/>
                </svg>
            </button>

            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width:38px;">
                <div class="d-none d-md-block">
                    <div style="font-weight:700; color:var(--brand);">Sistem Resepsionis Surat</div>
                    <small class="text-muted">Instansi Anda</small>
                </div>
            </a>
        </div>

        <div class="d-flex align-items-center gap-3">
            {{-- Search (optional) --}}
            <form class="d-none d-md-flex" action="{{ url()->current() }}" method="GET">
                <div class="input-group">
                    <input class="form-control" type="search" name="q" value="{{ request('q') }}" placeholder="Cari nomor / perihal..." aria-label="Search">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </form>

            {{-- User area --}}
            @auth
            <div class="d-flex align-items-center">
                <div class="me-3 text-end d-none d-lg-block">
                    <div style="font-weight:600">{{ auth()->user()->name }}</div>
                    <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
                </div>

                <div class="dropdown">
                    <a class="d-inline-flex align-items-center text-decoration-none" href="#" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                        <li><a class="dropdown-item" href="{{ route('viewer.dashboard') ?? '#' }}">Dashboard</a></li>
                        @if(auth()->user()->role === 'admin')
                        <li><a class="dropdown-item" href="{{ route('admin.users') }}">Manajemen User</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            @else
            <div>
                <a class="btn btn-outline-primary me-2" href="{{ route('login') }}">Masuk</a>
            </div>
            @endauth
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row g-0">
        {{-- Sidebar (desktop) --}}
        <aside class="col-lg-2 app-sidebar py-4 d-none d-lg-block">
            <div class="px-3">
                <div class="brand mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="logo">
                    <div>
                        <div style="font-weight:700">Instansi Anda</div>
                        <small class="text-muted">Resepsionis</small>
                    </div>
                </div>

                <nav class="nav flex-column">
                    <a class="nav-link mb-1 {{ request()->routeIs('viewer.dashboard') ? 'active' : '' }}" href="{{ route('viewer.dashboard') }}">
                        Dashboard
                    </a>

                    <a class="nav-link mb-1 {{ request()->routeIs('surat-masuk.*') ? 'active' : '' }}" href="{{ route('surat-masuk.index') }}">
                        Surat Masuk
                    </a>

                    <a class="nav-link mb-1 {{ request()->routeIs('surat-keluar.*') ? 'active' : '' }}" href="{{ route('surat-keluar.index') }}">
                        Surat Keluar
                    </a>

                    <a class="nav-link mb-1 {{ request()->routeIs('arsip.index') ? 'active' : '' }}" href="{{ route('arsip.index') }}">
                        Arsip (>1 tahun)
                    </a>

                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <hr>
                        <a class="nav-link mb-1 {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                            Manajemen User
                        </a>
                        <a class="nav-link mb-1" href="{{ url('/admin') }}">Admin Panel</a>
                    @endif
                </nav>

                <div class="mt-4">
                    <small class="text-muted">© {{ date('Y') }} Instansi Anda</small>
                </div>
            </div>
        </aside>

        {{-- Offcanvas Sidebar (mobile) --}}
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasSidebarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="brand mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="logo">
                    <div>
                        <div style="font-weight:700">Instansi Anda</div>
                        <small class="text-muted">Resepsionis</small>
                    </div>
                </div>

                <nav class="nav flex-column">
                    <a class="nav-link mb-1" href="{{ route('viewer.dashboard') }}">Dashboard</a>
                    <a class="nav-link mb-1" href="{{ route('surat-masuk.index') }}">Surat Masuk</a>
                    <a class="nav-link mb-1" href="{{ route('surat-keluar.index') }}">Surat Keluar</a>
                    <a class="nav-link mb-1" href="{{ route('arsip.index') }}">Arsip</a>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <hr>
                        <a class="nav-link mb-1" href="{{ route('admin.users') }}">Manajemen User</a>
                    @endif
                </nav>
            </div>
        </div>

        {{-- Main Content --}}
        <main class="col-lg-10 py-4">
            <div class="container-fluid">
                {{-- Flash messages --}}
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

                {{-- Page content from child views --}}
                @yield('content')
            </div>
        </main>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>