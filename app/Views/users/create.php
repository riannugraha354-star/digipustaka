<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

    /* 1. Background Gradient Persis Halaman Login */
    body { 
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; 
        font-family: 'Inter', sans-serif;
        margin: 0 !important;
        padding: 0 !important;
        height: 100vh;
    }

    /* Matikan Sidebar & Header Layout */
    aside, .sidebar, header, nav, .footer { display: none !important; }

    /* 2. Container Center Mutlak */
    .main-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        margin-left: 0 !important; 
    }

    /* 3. Card Putih Bersih (Clean) */
    .card-custom { 
        border-radius: 24px; 
        border: none; 
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2); 
        background: white; 
        width: 90%;
        max-width: 450px;
        overflow: hidden;
        animation: zoomIn 0.4s ease-out;
    }

    @keyframes zoomIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    .card-body-content {
        padding: 40px;
    }

    /* 4. Icon & Header */
    .icon-circle {
        width: 80px;
        height: 80px;
        background: #0d6efd;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 8px 15px rgba(13, 110, 253, 0.3);
    }

    .form-label { font-weight: 600; color: #4b5563; font-size: 14px; }
    
    /* 5. Input Style Identik Login */
    .form-control, .form-select {
        border-radius: 12px;
        height: 50px;
        border: 1px solid #e5e7eb;
        padding-left: 45px;
        background-color: #f9fafb;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #0d6efd;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }

    .input-icon-wrapper { position: relative; }
    .input-icon-wrapper i {
        position: absolute;
        top: 50%;
        left: 16px;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 18px;
    }

    /* 6. Button Style */
    .btn-save {
        border-radius: 12px;
        padding: 14px;
        font-weight: 700;
        background: #0d6efd;
        border: none;
        color: white;
        transition: all 0.3s;
        letter-spacing: 0.5px;
    }

    .btn-save:hover {
        background: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
    }

    .btn-back {
        background: #f3f4f6;
        color: #6b7280;
        border: none;
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        text-decoration: none;
        display: block;
        text-align: center;
        transition: all 0.3s;
    }

    .btn-back:hover { background: #e5e7eb; color: #374151; }

</style>

<div class="main-container">
    <div class="card card-custom">
        <div class="card-body-content">
            
            <div class="text-center mb-4">
                <div class="icon-circle">
                    <i class="bi bi-person-plus-fill text-white fs-1"></i>
                </div>
                <h3 class="fw-bold text-dark mb-1">Daftar Member</h3>
                <p class="text-muted small">Silakan lengkapi data diri Anda</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger border-0 rounded-3 mb-3 small text-center">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('users/store') ?>" method="post" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-icon-wrapper">
                        <input type="text" name="nama" class="form-control" placeholder="Nama lengkap" required>
                        <i class="bi bi-person"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Username</label>
                        <div class="input-icon-wrapper">
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                            <i class="bi bi-at"></i>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Role</label>
                        <div class="input-icon-wrapper">
                            <select name="role" class="form-select" required>
                                <option value="user" selected>User</option>
                            </select>
                            <i class="bi bi-shield-check"></i>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-icon-wrapper">
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        <i class="bi bi-lock"></i>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Foto Profil <span class="text-muted" style="font-size: 11px;">(Opsional)</span></label>
                    <input type="file" name="foto" class="form-control" style="padding-top: 12px; padding-left: 15px;">
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-save">DAFTAR SEKARANG</button>
                    <a href="<?= base_url('login') ?>" class="btn btn-back">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>