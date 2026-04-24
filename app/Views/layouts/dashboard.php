<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

    body { 
        background: #f0f5fa; 
        font-family: 'Inter', sans-serif;
    }

    .content-wrapper { 
        margin-left: 240px; 
        padding: 40px; 
        transition: all 0.3s ease;
    }

    .title { 
        color: #2c3e50; 
        letter-spacing: -1px;
    }

    .welcome-box {
        background: linear-gradient(135deg, #007bff 0%, #00d2ff 100%);
        color: white; 
        border-radius: 20px; 
        border: none;
        box-shadow: 0 10px 20px rgba(0, 123, 255, 0.2);
        position: relative;
        overflow: hidden;
    }

    .welcome-box::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .card-custom {
        border-radius: 20px; 
        border: none; 
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        cursor: pointer; 
        position: relative;
        /* Kunci tinggi agar semua card sejajar rata */
        min-height: 115px; 
    }

    .card-custom:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }

    .icon-box {
        font-size: 26px; 
        width: 55px; 
        height: 55px;
        display: flex; 
        align-items: center; 
        justify-content: center;
        border-radius: 15px; 
        color: white;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .bg-users { background: linear-gradient(45deg, #6f42c1, #a389d4); } 
    .bg-buku { background: linear-gradient(45deg, #007bff, #66b5ff); } 
    .bg-peminjaman { background: linear-gradient(45deg, #00d2ff, #3a7bd5); }
    .bg-denda { background: linear-gradient(45deg, #f39c12, #f1c40f); }
    .bg-setting { background: linear-gradient(45deg, #636e72, #b2bec3); }
    .bg-backup { background: linear-gradient(45deg, #27ae60, #2ecc71); }

    .card-link { 
        text-decoration: none !important; 
        display: block;
    }

    .card-text-main {
        font-weight: 700;
        font-size: 1.1rem;
        color: #2d3436;
    }

    @media (max-width: 768px) { 
        .content-wrapper { margin-left: 0; padding: 20px; } 
    }
</style>

<div class="content-wrapper">

    <div class="mb-4">
        <h2 class="fw-bold title">
            <i class="bi bi-grid-1x2-fill text-primary"></i> Dashboard <?= (session()->get('role') == 'admin') ? 'Admin' : 'User' ?>
        </h2>
        <p class="text-muted">
            Selamat datang kembali, <span class="text-primary fw-bold"><?= session()->get('nama') ?></span> 👋
        </p>
    </div>

    <div class="card welcome-box p-4 mb-5 border-0">
        <div class="row align-items-center">
            <div class="col-auto d-none d-md-block">
                <div class="bg-white p-3 rounded-circle shadow-sm">
                    <i class="bi bi-emoji-smile-fill text-primary" style="font-size: 40px;"></i>
                </div>
            </div>
            <div class="col">
                <h4 class="mb-1 fw-bold">Halo, <?= session()->get('nama') ?>! 📚</h4>
                <p class="mb-0 opacity-75">
                    <?= (session()->get('role') == 'admin') 
                        ? 'Sistem siap dikelola. Pantau aktivitas perpustakaan hari ini.' 
                        : 'Mau baca apa hari ini? Cek koleksi buku terbaru kami.' ?>
                </p>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <?php if (session()->get('role') == 'admin') : ?>
        <div class="col-md-4">
            <a href="<?= base_url('users') ?>" class="card-link">
                <div class="card card-custom p-4 d-flex flex-row justify-content-between align-items-center">
                    <div>
                        <span class="d-block text-muted small text-uppercase fw-bold mb-1">Database</span>
                        <span class="card-text-main">Data Users</span>
                    </div>
                    <div class="icon-box bg-users">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; ?>

        <div class="col-md-4">
            <a href="<?= base_url('buku') ?>" class="card-link">
                <div class="card card-custom p-4 d-flex flex-row justify-content-between align-items-center">
                    <div>
                        <span class="d-block text-muted small text-uppercase fw-bold mb-1">Katalog</span>
                        <span class="card-text-main">Koleksi Buku</span>
                    </div>
                    <div class="icon-box bg-buku">
                        <i class="bi bi-book-half"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= base_url('peminjaman') ?>" class="card-link">
                <div class="card card-custom p-4 d-flex flex-row justify-content-between align-items-center">
                    <div>
                        <span class="d-block text-muted small text-uppercase fw-bold mb-1">Sirkulasi</span>
                        <span class="card-text-main">Peminjaman</span>
                    </div>
                    <div class="icon-box bg-peminjaman">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <?php 
                $urlDenda = (session()->get('role') == 'admin') ? 'admin/denda' : 'denda'; 
                $labelDenda = (session()->get('role') == 'admin') ? 'Verifikasi Denda' : 'Denda Saya';
            ?>
            <a href="<?= base_url($urlDenda) ?>" class="card-link">
                <div class="card card-custom p-4 d-flex flex-row justify-content-between align-items-center">
                    <div>
                        <span class="d-block text-muted small text-uppercase fw-bold mb-1">Keuangan</span>
                        <span class="card-text-main"><?= $labelDenda ?></span>
                    </div>
                    <div class="icon-box bg-denda">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= base_url('users/edit/' . session()->get('id_user')) ?>" class="card-link">
                <div class="card card-custom p-4 d-flex flex-row justify-content-between align-items-center">
                    <div>
                        <span class="d-block text-muted small text-uppercase fw-bold mb-1">Akun</span>
                        <span class="card-text-main">Settings</span>
                    </div>
                    <div class="icon-box bg-setting">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                </div>
            </a>
        </div>

        <?php if (session()->get('role') == 'admin') : ?>
        <div class="col-md-4">
            <a href="<?= base_url('backup') ?>" class="card-link">
                <div class="card card-custom p-4 d-flex flex-row justify-content-between align-items-center">
                    <div>
                        <span class="d-block text-muted small text-uppercase fw-bold mb-1">Sistem</span>
                        <span class="card-text-main">Backup DB</span>
                    </div>
                    <div class="icon-box bg-backup">
                        <i class="bi bi-database-fill-check"></i>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>