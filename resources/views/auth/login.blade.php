<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sales Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0d6efd, #0b2447);
        }

        .login-wrapper {
            min-height: 100vh;
        }

        .login-card {
            max-width: 430px;
            width: 100%;
            border-radius: 20px;
        }

        .logo-login {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 18px;
        }

        @media (max-width: 576px) {
            .login-card {
                margin: 15px;
                border-radius: 16px;
            }

            .login-title {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

<div class="container login-wrapper d-flex align-items-center justify-content-center">

    <div class="card login-card shadow-lg border-0">

        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <img src="{{ asset('img/logo.jpg') }}"
                     alt="Logo"
                     class="logo-login mb-3">

                <h4 class="fw-bold login-title mb-1">
                    Sales Report System
                </h4>

                <p class="text-muted mb-0">
                    Silakan login untuk melanjutkan
                </p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    Email atau password salah.
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           class="form-control form-control-lg"
                           value="{{ old('email') }}"
                           placeholder="Masukkan email"
                           required
                           autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Password
                    </label>

                    <input type="password"
                           name="password"
                           class="form-control form-control-lg"
                           placeholder="Masukkan password"
                           required>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               name="remember"
                               id="remember_me">

                        <label class="form-check-label" for="remember_me">
                            Ingat saya
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-decoration-none">
                            Lupa password?
                        </a>
                    @endif

                </div>

                <button type="submit"
                        class="btn btn-primary btn-lg w-100">
                    Login
                </button>

            </form>

            <div class="text-center mt-4">
                <small class="text-muted">
                    © {{ date('Y') }} Sales Report Management
                </small>
            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>