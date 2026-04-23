<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restore Database | DigiPustaka</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #f8d7da 0%, #f1f2f6 100%);
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .restore-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            border: none;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 20px 40px rgba(220, 53, 69, 0.15);
        }

        .danger-icon {
            width: 70px;
            height: 70px;
            background: #dc3545;
            color: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            margin: 0 auto 20px;
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.3);
        }

        .alert-custom {
            border-radius: 12px;
            border: none;
            font-size: 13px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 2px solid #eee;
        }

        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
        }

        .btn-restore {
            background: #dc3545;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-restore:hover {
            background: #bb2d3b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        .btn-back {
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            color: #6c757d;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-back:hover {
            color: #212529;
            background: #f8f9fa;
        }
    </style>
</head>

<body>

    <div class="restore-card">
        <div class="danger-icon">
            <i class="bi bi-database-fill-exclamation"></i>
        </div>

        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark mb-1">Restore Database</h3>
            <p class="text-muted small">Kembalikan data sistem dari file backup (.sql)</p>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-custom d-flex align-items-center mb-3">
                <i class="bi bi-x-circle-fill me-2"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-custom d-flex align-items-center mb-3">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="alert alert-warning alert-custom mb-4">
            <div class="d-flex">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                <div>
                    <strong>Perhatian!</strong><br>
                    Proses ini akan <b>menimpa seluruh data</b> yang ada saat ini dengan data dari file yang Anda pilih.
                </div>
            </div>
        </div>

        <form action="<?= base_url('restore/process') ?>" method="post" enctype="multipart/form-data"
              onsubmit="return confirm('Peringatan Terakhir: Anda yakin ingin menimpa database?')">

            <div class="mb-4">
                <label class="form-label fw-bold text-muted small">PILIH FILE BACKUP (.SQL)</label>
                <div class="input-group">
                    <input type="file" name="file_sql" class="form-control" accept=".sql" required>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-danger btn-restore text-white">
                    <i class="bi bi-arrow-repeat me-2"></i> Mulai Restore Data
                </button>
                <a href="<?= base_url('/') ?>" class="btn btn-back text-center">
                    <i class="bi bi-arrow-left me-1"></i> Batal & Kembali
                </a>
            </div>
        </form>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>