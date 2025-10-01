<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SPK Beasiswa MA Muhammadiyah 1 Bandung</title>
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
            overflow-x: hidden;
            background: #f3f4f6;
            padding: 30px 0;
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

        /* Register Container - UKURAN DIPERKECIL */
        .register-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        /* Register Card */
        .register-card {
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
            margin-bottom: 14px;
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

        /* Info Box */
        .info-box {
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
            border-left: 3px solid var(--secondary);
            padding: 8px 12px;
            border-radius: 8px;
            margin-bottom: 14px;
            font-size: 11px;
            color: #1e40af;
            display: flex;
            align-items: start;
            gap: 7px;
        }

        .info-box i {
            font-size: 13px;
            margin-top: 1px;
        }

        /* Form Grid - 2 Columns */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }

        .form-group {
            margin-bottom: 12px;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
        }

        .required {
            color: #dc2626;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 13px;
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 9px 10px 9px 34px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 12px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239ca3af' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            cursor: pointer;
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--secondary);
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af;
            font-size: 13px;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
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
            margin: 14px 0;
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

        /* Login Link */
        .login-link {
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }

        .login-link a {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .login-link a:hover {
            color: var(--primary);
        }

        /* Alert */
        .alert {
            padding: 9px 11px;
            border-radius: 8px;
            font-size: 11px;
            margin-bottom: 12px;
            border: none;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
        }

        .alert-danger ul {
            margin: 5px 0 0 0;
            padding-left: 16px;
        }

        .alert-danger li {
            margin: 2px 0;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .register-container {
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

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
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

    <!-- Register Container -->
    <div class="register-container">
        <div class="register-card">
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
                    <h2>Daftar Akun Baru</h2>
                    <p>Lengkapi data untuk membuat akun siswa</p>
                </div>

                <div class="info-box">
                    <i class="fas fa-info-circle"></i>
                    <span>Data lengkap dapat dilengkapi setelah login saat mengajukan beasiswa</span>
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger" id="alert-error">
                            <strong><i class="fas fa-exclamation-circle"></i> Terdapat kesalahan:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Row: NIS & Kelas -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">NIS <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-id-card input-icon"></i>
                                <input type="text" name="nis" class="form-control"
                                    placeholder="Nomor Induk Siswa" value="{{ old('nis') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kelas <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-school input-icon"></i>
                                <select name="kelas" class="form-select" required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>X (Sepuluh)
                                    </option>
                                    <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>XI (Sebelas)
                                    </option>
                                    <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>XII (Duabelas)
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Full Width: Nama Lengkap -->
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="nama_lengkap" class="form-control"
                                placeholder="Nama lengkap siswa" value="{{ old('nama_lengkap') }}" required>
                        </div>
                    </div>

                    <!-- Full Width: Email -->
                    <div class="form-group">
                        <label class="form-label">Email <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" class="form-control" placeholder="contoh@email.com"
                                value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <!-- Row: Password & Konfirmasi -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Password <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Min. 6 karakter" required>
                                <i class="fas fa-eye password-toggle" id="togglePassword"
                                    onclick="togglePassword('password', 'togglePassword')"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="Ulangi password" required>
                                <i class="fas fa-eye password-toggle" id="togglePasswordConfirm"
                                    onclick="togglePassword('password_confirmation', 'togglePasswordConfirm')"></i>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-user-check me-2"></i>Daftar Sekarang
                    </button>

                    <div class="divider">
                        <span>atau</span>
                    </div>

                    <div class="login-link">
                        Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const password = document.getElementById(inputId);
            const toggle = document.getElementById(iconId);

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

        // AUTO HIDE ALERT SETELAH 5 DETIK
        document.addEventListener('DOMContentLoaded', function() {
            const alertError = document.getElementById('alert-error');

            if (alertError) {
                setTimeout(() => {
                    alertError.style.opacity = '0';
                    alertError.style.transform = 'translateY(-10px)';
                    alertError.style.transition = 'all 0.3s ease';
                    setTimeout(() => alertError.remove(), 300);
                }, 5000);
            }
        });
    </script>
</body>

</html>
