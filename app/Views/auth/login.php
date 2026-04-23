<!DOCTYPE html>
<html lang="en">
//halaman login
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | DigiPustaka</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            border: none;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            background: #0d6efd;
            color: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 20px;
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            font-size: 14px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 2px solid #eee;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }

        .btn-login {
            background: #0d6efd;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }

        .alert {
            border-radius: 12px;
            border: none;
            font-size: 14px;
        }

        .footer-links a {
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            transition: 0.3s;
        }

        .btn-outline-custom {
            border: 2px solid #eee;
            border-radius: 10px;
            color: #666;
            font-weight: 600;
        }

        .btn-outline-custom:hover {
            background: #f8f9fa;
            color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
</head>

<body>

    <div class="login-card shadow">
        <div class="brand-logo">
            <i class="bi bi-book-half"></i>
        </div>
        
        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark mb-1">DigiPustaka</h3>
            <p class="text-muted small">Silakan masuk ke akun Anda</p>
        </div>

        <?php if (session()->getFlashdata('error') || session()->getFlashdata('salahpw')): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>
                    <?= session()->getFlashdata('error') ?: session()->getFlashdata('salahpw') ?>
                </div>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/proses-login') ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border: 2px solid #eee;">
                        <i class="bi bi-person text-muted"></i>
                    </span>
                    <input type="text" name="username" class="form-control border-start-0" 
                           placeholder="Username" required style="border-radius: 0 12px 12px 0;">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border: 2px solid #eee;">
                        <i class="bi bi-lock text-muted"></i>
                    </span>
                    <input type="password" name="password" class="form-control border-start-0" 
                           placeholder="••••••••" required style="border-radius: 0 12px 12px 0;">
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-login w-100 mb-3">
                Sign In <i class="bi bi-arrow-right ms-2"></i>
            </button>
        </form>

        <hr class="my-4 text-muted">

        <div class="footer-links d-flex flex-column gap-2">
            <a href="<?= base_url('users/create') ?>" class="btn btn-outline-custom btn-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Belum punya akun? Daftar
            </a>
            <div class="d-flex gap-2">
                <a href="<?= base_url('restore') ?>" class="btn btn-link btn-sm text-danger flex-grow-1 p-0">
                    <i class="bi bi-database-fill-gear"></i> Restore Database
                </a>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>