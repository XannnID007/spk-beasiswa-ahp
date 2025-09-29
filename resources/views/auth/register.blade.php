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
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
        }

        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            padding: 40px 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }

        .register-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .register-header {
            background: var(--primary-color);
            color: white;
            padding: 25px 30px;
            text-align: center;
        }

        .register-header i {
            font-size: 42px;
            margin-bottom: 10px;
        }

        .register-header h4 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .register-header p {
            margin: 5px 0 0 0;
            font-size: 13px;
            opacity: 0.9;
        }

        .register-body {
            padding: 30px;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-register {
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

        .btn-register:hover {
            background: #1e40af;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6b7280;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .alert {
            border-radius: 8px;
            font-size: 14px;
            border: none;
        }

        .required {
            color: #dc2626;
        }

        .info-box {
            background: #dbeafe;
            border-left: 4px solid #3b82f6;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <i class="fas fa-user-plus"></i>
                <h4>Pendaftaran Akun Siswa</h4>
                <p>MA Muhammadiyah 1 Bandung</p>
            </div>

            <div class="register-body">
                <div class="info-box">
                    <i class="fas fa-info-circle"></i> Data lengkap dapat dilengkapi setelah login saat mengajukan
                    beasiswa
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            <ul class="mb-0" style="padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">NIS <span class="required">*</span></label>
                        <input type="text" class="form-control" name="nis" placeholder="Nomor Induk Siswa"
                            value="{{ old('nis') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" class="form-control" name="nama_lengkap" placeholder="Nama lengkap siswa"
                            value="{{ old('nama_lengkap') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas <span class="required">*</span></label>
                        <select class="form-select" name="kelas" required>
                            <option value="">Pilih Kelas</option>
                            <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>X (Sepuluh)</option>
                            <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>XI (Sebelas)</option>
                            <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>XII (Duabelas)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span class="required">*</span></label>
                        <input type="email" class="form-control" name="email" placeholder="contoh@email.com"
                            value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password <span class="required">*</span></label>
                        <input type="password" class="form-control" name="password" placeholder="Minimal 6 karakter"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password <span class="required">*</span></label>
                        <input type="password" class="form-control" name="password_confirmation"
                            placeholder="Ulangi password" required>
                    </div>

                    <button type="submit" class="btn btn-register mt-3">
                        <i class="fas fa-user-check me-2"></i> Daftar Sekarang
                    </button>

                    <div class="login-link">
                        Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
