<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Sinkronisasi Tema & Background Full */
    body { 
        background: #f0f5fa; 
        font-family: 'Inter', sans-serif; 
        margin: 0;
    }

    /* Menghilangkan Sidebar & Header Layout jika ada */
    aside, .sidebar, header, nav { display: none !important; }

    /* Container Utama: Dibuat Full Screen & Center */
    .main-container {
        display: flex;
        justify-content: center; /* Tengah secara Horizontal */
        align-items: center;     /* Tengah secara Vertikal */
        min-height: 100vh;       /* Tinggi 100% layar browser */
        padding: 20px;
    }

    /* Card Styling */
    .card-custom { 
        border-radius: 20px; 
        border: none; 
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); 
        background: white; 
        width: 100%;
        max-width: 500px; /* Lebar form agar tidak melar */
    }

    /* Form Design */
    .form-label { font-weight: 600; color: #495057; font-size: 14px; }
    .form-control, .form-select {
        border-radius: 12px;
        height: 48px;
        border: 2px solid #f1f3f5;
        padding-left: 45px; 
        transition: all 0.3s;
    }
    .form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1); }

    /* Ikon di dalam Input */
    .input-icon-wrapper { position: relative; }
    .input-icon-wrapper i {
        position: absolute;
        top: 50%;
        left: 16px;
        transform: translateY(-50%);
        color: #adb5bd;
        font-size: 18px;
    }

    /* Button Styling */
    .btn-save {
        border-radius: 12px;
        padding: 12px;
        font-weight: 700;
        background: #0d6efd;
        border: none;
    }
    .btn-back {
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        background: #f8f9fa;
        color: #6c757d;
        border: 2px solid #f1f3f5;
        text-decoration: none;
        display: block;
        text-align: center;
    }
</style>

<div class="main-container">
    <div class="card card-custom p-4">
        
        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark mb-1">
                <i class="bi bi-person-plus-fill text-primary me-2"></i>Tambah User Baru
            </h3>
            <p class="text-muted small">Lengkapi formulir di bawah untuk mendaftarkan pengguna baru.</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger border-0 rounded-4 mb-3">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('users/store') ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <div class="input-icon-wrapper">
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Budi Santoso" required>
                    <i class="bi bi-person"></i>
                </div>
            </div>

            <div class="row">
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
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-icon-wrapper">
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    <i class="bi bi-key"></i>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label text-muted">Foto Profil (Opsional)</label>
                <input type="file" name="foto" class="form-control" style="padding-left: 15px; padding-top: 10px;">
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-save">
                    <i class="bi bi-check-circle-fill me-2"></i> SIMPAN DATA USER
                </button>
                <a href="<?= base_url('login') ?>" class="btn btn-back">
                    Kembali ke Login
                </a>
            </div>
        </form>

    </div>
</div>

<?= $this->endSection() ?>