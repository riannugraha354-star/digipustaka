<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

    body { 
        background: #f8fafc; 
        font-family: 'Inter', sans-serif;
    }

    .content-wrapper { 
        margin-left: 260px; /* Sesuaikan dengan lebar sidebar */
        padding: 40px; 
        transition: all 0.3s ease;
    }

    .title { 
        color: #1e293b; 
        letter-spacing: -0.5px;
        font-weight: 800;
    }

    /* Welcome Box dengan warna Biru yang Senada Sidebar */
    .welcome-box {
        background: linear-gradient(135deg, #0d6efd 0%, #00d2ff 100%);
        color: white; 
        border-radius: 24px; 
        border: none;
        box-shadow: 0 10px 30px rgba(13, 110, 253, 0.2);
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
        border-radius: 24px; 
        border: none; 
        background: #ffffff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        position: relative;
        min-height: 120px; 
    }

    .card-custom:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
    }

    .icon-box {
        font-size: 24px; 
        width: 50px; 
        height: 50px;
        display: flex; 
        align-items: center; 
        justify-content: center;
        border-radius: 16px; 
        color: white;
    }

    /* Palette Warna yang Sudah Di-Upgrade agar Senada */
    .bg-users { background: linear-gradient(45deg, #6366f1, #818cf8); } 
    .bg-buku { background: linear-gradient(45deg, #0ea5e9, #38bdf8); } 
    .bg-peminjaman { background: linear-gradient(45deg, #0d6efd, #0dcaf0); }
    .bg-denda { background: linear-gradient(45deg, #f59e0b, #fbbf24); }
    .bg-setting { background: linear-gradient(45deg, #64748b, #94a3b8); }
    /* Backup DB sekarang pakai Biru-Azure agar senada dengan Sidebar */
    .bg-backup { background: linear-gradient(45deg, #0ea5e9, #22d3ee); }

    .card-link { 
        text-decoration: none !important; 
        display: block;
    }

    .card-text-main {
        font-weight: 700;
        font-size: 1.1rem;
        color: #334155;
    }

    .label-db {
        font-size: 0.7rem;
        letter-spacing: 1.2px;
        color: #94a3b8;
    }

    @media (max-width: 768px) { 
        .content-wrapper { margin-left: 0; padding: 20px; } 
    }
</style>

<div class="content-wrapper">

    <div class="mb-4 d-flex align-items-center justify-content-between">
        <div>
            <h2 class="title mb-1">
                Dashboard <?= (session()->get('role') == 'admin') ? 'Admin' : 'User' ?>
            </h2>
            <p class="text-muted small">
                Selamat datang kembali, <span class="text-primary fw-bold"><?= session()->get('nama') ?></span> 👋
            </p>
        </div>
        <div class="d-none d-md-block">
             <span class="badge bg-white text-primary border px-3 py-2 rounded-pill shadow-sm">
                <i class="bi bi-calendar3 me-2"></i> <?= date('d M Y') ?>
             </span>
        </div>
    </div>

    <div class="card welcome-box p-4 mb-5 border-0">
        <div class="row align-items-center">
            <div class="col-auto d-none d-md-block">
                <div class="bg-white p-3 rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
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
                        <span class="d-block label-db text-uppercase fw-bold mb-1">DATABASE</span>
                        <span class="card-text-main">Data Users</span>
                    </div>
                    <div class="icon-box bg-users shadow-sm">
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
                        <span class="d-block label-db text-uppercase fw-bold mb-1">KATALOG</span>
                        <span class="card-text-main">Koleksi Buku</span>
                    </div>
                    <div class="icon-box bg-buku shadow-sm">
                        <i class="bi bi-book-half"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= base_url('peminjaman') ?>" class="card-link">
                <div class="card card-custom p-4 d-flex flex-row justify-content-between align-items-center">
                    <div>
                        <span class="d-block label-db text-uppercase fw-bold mb-1">SIRKULASI</span>
                        <span class="card-text-main">Peminjaman</span>
                    </div>
                    <div class="icon-box bg-peminjaman shadow-sm">
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
                        <span class="d-block label-db text-uppercase fw-bold mb-1">KEUANGAN</span>
                        <span class="card-text-main"><?= $labelDenda ?></span>
                    </div>
                    <div class="icon-box bg-denda shadow-sm">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= base_url('users/edit/' . session()->get('id_user')) ?>" class="card-link">
                <div class="card card-custom p-4 d-flex flex-row justify-content-between align-items-center">
                    <div>
                        <span class="d-block label-db text-uppercase fw-bold mb-1">AKUN</span>
                        <span class="card-text-main">Settings</span>
                    </div>
                    <div class="icon-box bg-setting shadow-sm">
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
                        <span class="d-block label-db text-uppercase fw-bold mb-1">SISTEM</span>
                        <span class="card-text-main">Backup DB</span>
                    </div>
                    <div class="icon-box bg-backup shadow-sm">
                        <i class="bi bi-database-fill-check"></i>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>