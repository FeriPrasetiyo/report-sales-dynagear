<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales Report System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }

        .navbar {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7) !important;
        }

        .navbar-brand img {
            object-fit: cover;
        }

        .nav-link {
            font-weight: 500;
            border-radius: 8px;
            transition: .3s;
        }

        .nav-link:hover {
            background: rgba(255,255,255,.15);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #0d6efd;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .dropdown-menu {
            border: 0;
            border-radius: 12px;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container-fluid px-4">

        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('img/logo.jpg') }}"
                 width="45"
                 height="45"
                 class="me-2 rounded"
                 alt="Logo">

            <div>
                <div class="fw-bold">Sales Report</div>
                <small class="text-white-50">CRM Management</small>
            </div>
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        📊 Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sales-reports.index') }}">
                        📋 Report Sales
                    </a>
                </li>

                @auth
                    @if(trim(strtolower(Auth::user()->role)) === 'admin')
                        <li class="nav-item">
                            <a class="nav-link text-warning fw-bold" href="{{ route('sales-targets.index') }}">
                                🎯 Target Sales
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">
                                👥 User Management
                            </a>
                        </li>
                    @endif
                @endauth

            </ul>

            @auth
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center"
                            type="button"
                            data-bs-toggle="dropdown">

                        <div class="user-avatar me-2">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        <div class="text-start">
                            <div class="fw-bold">
                                {{ Auth::user()->name }}
                            </div>

                            <small class="badge bg-primary">
                                {{ strtoupper(Auth::user()->role) }}
                            </small>
                        </div>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow">

                        <li>
                            <h6 class="dropdown-header">
                                Menu Pengguna
                            </h6>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                📊 Dashboard
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                👤 Profile
                            </a>
                        </li>

                        @if(trim(strtolower(Auth::user()->role)) === 'admin')
                            <li>
                                <a class="dropdown-item" href="{{ route('sales-targets.index') }}">
                                    🎯 Target Sales
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('users.index') }}">
                                    👥 User Management
                                </a>
                            </li>
                        @endif

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit" class="dropdown-item text-danger">
                                    🚪 Logout
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>
            @endauth

        </div>
    </div>
</nav>

<div class="container-fluid py-4">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>