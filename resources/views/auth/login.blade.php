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
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
            --light-blue: #dbeafe;
        }

        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .login-header {
            background: var(--primary-color);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .login-header i {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .login-header h4 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .login-header p {
            margin: 5px 0 0 0;
            font-size: 13px;
            opacity: 0.9;
        }

        .login-body {
            padding: 30px;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .input-group-text {
            background: #f3f4f6;
            border: 2px solid #e5e7eb;
            border-right: none;
            color: #6b7280;
        }

        .input-group .form-control {
            border-left: none;
        }

        .btn-login {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            font-size: 15px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #1e40af;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            position: relative;
            color: #6b7280;
            font-size: 13px;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6b7280;
        }

        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .alert {
            border-radius: 8px;
            font-size: 14px;
            border: none;
        }

        .password-toggle {
            cursor: pointer;
            color: #6b7280;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-graduation-cap"></i>
                <h4>SPK Beasiswa</h4>
                <p>MA Muhammadiyah 1 Bandung</p>
            </div>

            <div class="login-body">
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    @if (session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan email"
                                required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Masukkan password" required>
                            <span class="input-group-text password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember" style="font-size: 14px;">
                            Ingat Saya
                        </label>
                    </div>

                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i> Masuk
                    </button>

                    <div class="divider">
                        <span>atau</span>
                    </div>

                    <div class="register-link">
                        Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
