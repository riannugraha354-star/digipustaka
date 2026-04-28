<style>
    /* Styling Sidebar Khusus */
    .sidebar-menu { padding: 15px; }
    
    .nav-link {
        border-radius: 12px !important;
        margin-bottom: 5px;
        padding: 12px 15px !important;
        transition: all 0.3s ease;
        color: #5f6d7d !important;
        font-weight: 500;
    }

    /* Efek Active Hover ala-ala Apple/Modern Dashboard */
    .nav-link:hover {
        background: rgba(13, 110, 253, 0.05) !important;
        color: #0d6efd !important;
        transform: translateX(5px);
    }

    .nav-link.active {
        background: linear-gradient(45deg, #0d6efd, #0dcaf0) !important;
        color: white !important;
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
    }

    .nav-link.active i { color: white !important; }
    .nav-link i { font-size: 1.1rem; }

    /* Logo Styling */
    .brand-wrapper {
        padding: 20px 10px;
        margin-bottom: 20px;
    }

    /* Profile Section di Bawah */
    .profile-card {
        background: #f8f9fa;
        border-radius: 20px;
        margin: 20px 15px;
        padding: 15px;
        border: 1px solid #edf2f7;
    }
    
    .logout-link:hover {
        background: rgba(220, 53, 69, 0.05) !important;
        color: #dc3545 !important;
    }
</style>

<div class="sidebar-menu">
    <div class="brand-wrapper text-center">
        <a class="d-flex align-items-center justify-content-center text-decoration-none" href="<?= base_url('/') ?>">
            <div class="bg-primary rounded-3 p-2 me-2 shadow-sm">
                <i class="bi bi-book-half text-white"></i>
            </div>
            <span class="fw-bold text-dark fs-5" style="letter-spacing: -0.5px;">DigiPustaka</span>
        </a>
    </div>

    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a class="nav-link <?= (url_is('/') || url_is('dashboard')) ? 'active' : '' ?>" href="<?= base_url('/') ?>">
                <i class="bi bi-grid-fill me-2"></i> Dashboard
            </a>
        </li>

        <?php if (session()->get('role') == 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link <?= (url_is('users*')) ? 'active' : '' ?>" href="<?= base_url('/users') ?>">
                    <i class="bi bi-people-fill me-2"></i> Users
                </a>
            </li>
        <?php endif; ?>

        <li class="nav-item">
            <a class="nav-link <?= (url_is('buku*')) ? 'active' : '' ?>" href="<?= base_url('/buku') ?>">
                <i class="bi bi-journal-bookmark-fill me-2"></i> Data Buku
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= (url_is('peminjaman') && !url_is('peminjaman/denda')) ? 'active' : '' ?>" href="<?= base_url('/peminjaman') ?>">
                <i class="bi bi-arrow-left-right me-2"></i> Peminjaman
            </a>
        </li>

        <?php if (session()->get('role') == 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link <?= (url_is('admin/denda*') || url_is('peminjaman/denda*')) ? 'active' : '' ?>" href="<?= base_url('/admin/denda') ?>">
                    <i class="bi bi-patch-check-fill me-2"></i> Verifikasi Denda
                </a>
            </li>
        <?php endif; ?>

        <?php if (session()->get('role') == 'user'): ?>
            <li class="nav-item">
                <a class="nav-link <?= (url_is('denda*')) ? 'active' : '' ?>" href="<?= base_url('/denda') ?>">
                    <i class="bi bi-wallet2 me-2"></i> Denda Saya
                </a>
            </li>
        <?php endif; ?>

        <li class="nav-item">
            <?php $idu = session('id_user'); ?>
            <a class="nav-link <?= (url_is('users/edit/' . $idu)) ? 'active' : '' ?>" href="<?= base_url('users/edit/' . $idu) ?>">
                <i class="bi bi-gear-fill me-2"></i> Setting
            </a>
        </li>

        <?php if (session()->get('role') == 'admin') : ?>
            <li class="nav-item px-2 mt-4">
                <a href="<?= base_url('/backup') ?>" class="btn btn-primary btn-sm w-100 rounded-pill shadow-sm py-2">
                    <i class="bi bi-cloud-arrow-down-fill me-1"></i> Backup DB
                </a>
            </li>
        <?php endif; ?>

        <li class="nav-item mt-2">
            <a class="nav-link logout-link text-danger" href="<?= base_url('/logout') ?>" onclick="return confirm('Yakin ingin logout?')">
                <i class="bi bi-power me-2"></i> Logout
            </a>
        </li>
    </ul>

    <div class="profile-card text-center shadow-sm">
        <div class="position-relative d-inline-block mb-2">
            <?php if (session()->get('foto')): ?>
                <img src="<?= base_url('uploads/users/' . session()->get('foto')) ?>"
                    height="60" width="60" style="object-fit: cover;"
                    class="rounded-circle border border-2 border-white shadow-sm" />
            <?php else: ?>
                <img src="https://ui-avatars.com/api/?name=<?= urlencode(session('nama')) ?>&background=0d6efd&color=fff"
                    height="60" width="60" class="rounded-circle border border-2 border-white shadow-sm" />
            <?php endif; ?>
            <div class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle" style="width: 15px; height: 15px;"></div>
        </div>

        <div class="overflow-hidden">
            <h6 class="mb-0 fw-bold text-dark text-truncate small"><?= session('nama'); ?></h6>
            <span class="text-muted" style="font-size: 0.7rem;"><?= strtoupper(session('role')); ?></span>
        </div>
    </div>
</div>