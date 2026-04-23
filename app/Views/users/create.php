<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Sinkronisasi Tema */
    body { background: #f0f5fa; font-family: 'Inter', sans-serif; }

    .content-wrapper { 
        margin-left: 240px; 
        padding: 40px; 
        transition: all 0.3s ease;
    }

    /* Card Styling */
    .card-custom { 
        border-radius: 20px; 
        border: none; 
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); 
        background: white; 
        max-width: 600px; /* Batasi lebar agar form tidak terlalu melar */
    }

    /* Input Styling */
    .form-label { font-weight: 600; color: #495057; font-size: 14px; }
    
    .form-control, .form-select {
        border-radius: 12px;
        height: 48px;
        border: 2px solid #f1f3f5;
        padding-left: 45px; /* Beri ruang untuk ikon */
        transition: all 0.3s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        background-color: #fff;
    }

    /* Input Icon Positioning */
    .input-icon-wrapper { position: relative; }
    
    .input-icon-wrapper i {
        position: absolute;
        top: 50%;
        left: 16px;
        transform: translateY(-50%);
        color: #adb5bd;
        font-size: 18px;
        z-index: 10;
        transition: 0.3s;
    }

    .input-icon-wrapper input:focus + i,
    .input-icon-wrapper select:focus + i {
        color: #0d6efd;
    }

    /* Button Styling */
    .btn-save {
        border-radius: 12px;
        padding: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }

    .btn-back {
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        background: #f8f9fa;
        border: 2px solid #f1f3f5;
        color: #6c757d;
    }

    @media (max-width: 768px) { .content-wrapper { margin-left: 0; padding: 20px; } }
</style>

<div class="content-wrapper">

    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-person-plus-fill text-primary me-2"></i>Tambah User Baru
        </h2>
        <p class="text-muted">Lengkapi formulir di bawah untuk mendaftarkan pengguna baru.</p>
    </div>

    <div class="card card-custom p-4">

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger border-0 rounded-4 mb-4">
                <i class="bi bi-exclamation-circle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('users/store') ?>" method="post" enctype="multipart/form-data">
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-icon-wrapper">
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Budi Santoso" required>
                        <i class="bi bi-person"></i>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-icon-wrapper">
                        <input type="text" name="username" class="form-control" placeholder="username123" required>
                        <i class="bi bi-at"></i>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Role Akses</label>
                    <div class="input-icon-wrapper">
                        <select name="role" class="form-select" required>
                            <option value="" hidden>Pilih Role</option>
                            <option value="user">User</option>
                        </select>
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-icon-wrapper">
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        <i class="bi bi-key"></i>
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    <label class="form-label text-muted">Foto Profil (Opsional)</label>
                    <input type="file" name="foto" class="form-control" accept="image/*" style="padding-left: 15px; padding-top: 10px;">
                    <small class="text-muted" style="font-size: 11px;">Format: JPG, PNG (Max 2MB)</small>
                </div>
            </div>

            <div class="d-flex flex-column gap-2">
                <button type="submit" class="btn btn-primary btn-save w-100">
                    <i class="bi bi-check-circle-fill me-2"></i> Simpan Data User
                </button>

                <a href="<?= base_url('login') ?>" class="btn btn-back w-100 text-center">
                     Kembali ke Login
                </a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>