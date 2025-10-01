<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPK Beasiswa MA Muhammadiyah 1 Bandung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1e3a8a;
            --secondary: #3b82f6;
            --accent: #60a5fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background: #f3f4f6;
        }

        /* Background Image */
        .bg-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .bg-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.5);
        }

        .gradient-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.6) 0%, rgba(59, 130, 246, 0.5) 50%, rgba(96, 165, 250, 0.4) 100%);
        }

        /* Floating Shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            animation: float 20s infinite ease-in-out;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            top: -150px;
            right: -150px;
        }

        .shape-2 {
            width: 250px;
            height: 250px;
            bottom: -120px;
            left: -120px;
            animation-delay: 5s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-30px);
            }
        }

        /* Login Container - UKURAN DIPERKECIL */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 380px;
            padding: 20px;
        }

        /* Login Card */
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        /* Header - DIPERKECIL */
        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 20px 25px;
            text-align: center;
            color: white;
            position: relative;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="0.5" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .logo-box {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 12px;
            padding: 8px;
            margin: 0 auto 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        .logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .card-header h1 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 3px;
            position: relative;
            z-index: 1;
        }

        .card-header p {
            font-size: 11px;
            opacity: 0.95;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        /* Body - DIPERKECIL */
        .card-body {
            padding: 20px 25px;
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 18px;
        }

        .welcome-text h2 {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 3px;
        }

        .welcome-text p {
            font-size: 12px;
            color: #6b7280;
            margin: 0;
        }

        /* Form - DIPERKECIL */
        .form-group {
            margin-bottom: 14px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px 10px 38px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 13px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--secondary);
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af;
            font-size: 14px;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Options */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            font-size: 12px;
        }

        .remember-checkbox {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            color: #6b7280;
        }

        .remember-checkbox input {
            width: 15px;
            height: 15px;
            cursor: pointer;
            accent-color: var(--secondary);
        }

        .forgot-link {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: var(--primary);
        }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 11px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-submit:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            margin: 16px 0;
            color: #9ca3af;
            font-size: 11px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            padding: 0 10px;
        }

        /* Register Link */
        .register-link {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
        }

        .register-link a {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .register-link a:hover {
            color: var(--primary);
        }

        /* Alert - AUTO HIDE */
        .alert {
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 12px;
            margin-bottom: 14px;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 15px;
                max-width: 100%;
            }

            .card-header {
                padding: 18px 20px;
            }

            .logo-box {
                width: 45px;
                height: 45px;
            }

            .card-header h1 {
                font-size: 17px;
            }

            .card-body {
                padding: 20px;
            }

            .welcome-text h2 {
                font-size: 17px;
            }
        }
    </style>
</head>

<body>
    <!-- Background -->
    <div class="bg-wrapper">
        <img src="{{ asset('img/bg.jpg') }}" alt="Background" class="bg-image">
        <div class="gradient-overlay"></div>
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="card-header">
                <div class="logo-box">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo">
                </div>
                <h1>SPK Beasiswa</h1>
                <p>MA Muhammadiyah 1 Bandung</p>
            </div>

            <!-- Body -->
            <div class="card-body">
                <div class="welcome-text">
                    <h2>Selamat Datang!</h2>
                    <p>Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    @if (session('error'))
                        <div class="alert alert-danger" id="alert-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success" id="alert-success">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" class="form-control" placeholder="nama@email.com"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Masukkan password" required>
                            <i class="fas fa-eye password-toggle" id="togglePassword" onclick="togglePassword()"></i>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="remember-checkbox">
                            <input type="checkbox" name="remember">
                            <span>Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk
                    </button>

                    <div class="divider">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const toggle = document.getElementById('togglePassword');

            if (password.type === 'password') {
                password.type = 'text';
                toggle.classList.remove('fa-eye');
                toggle.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                toggle.classList.remove('fa-eye-slash');
                toggle.classList.add('fa-eye');
            }
        }

        // AUTO HIDE ALERT SETELAH 4 DETIK
        document.addEventListener('DOMContentLoaded', function() {
            const alertSuccess = document.getElementById('alert-success');
            const alertError = document.getElementById('alert-error');

            if (alertSuccess) {
                setTimeout(() => {
                    alertSuccess.style.opacity = '0';
                    alertSuccess.style.transform = 'translateY(-10px)';
                    setTimeout(() => alertSuccess.remove(), 300);
                }, 4000);
            }

            if (alertError) {
                setTimeout(() => {
                    alertError.style.opacity = '0';
                    alertError.style.transform = 'translateY(-10px)';
                    setTimeout(() => alertError.remove(), 300);
                }, 4000);
            }
        });
    </script>
</body>

</html>
