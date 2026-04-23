<ul class="nav nav-pills flex-column mt-3">

    <li class="nav-item text-center mb-4">
        <a class="nav-link fw-bold text-primary fs-5" href="<?= base_url('/') ?>" style="background: none !important;">
            <i class="bi bi-book-half"></i> DigiPustaka
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link <?= (url_is('/') || url_is('dashboard')) ? 'active' : '' ?>" href="<?= base_url('/') ?>">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
    </li>

    <?php if (session()->get('role') == 'admin'): ?>
        <li class="nav-item">
            <a class="nav-link <?= (url_is('users*')) ? 'active' : '' ?>" href="<?= base_url('/users') ?>">
                <i class="bi bi-people me-2"></i> Users
            </a>
        </li>
    <?php endif; ?>

    <li class="nav-item">
        <a class="nav-link <?= (url_is('buku*')) ? 'active' : '' ?>" href="<?= base_url('/buku') ?>">
            <i class="bi bi-book me-2"></i> Data Buku
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link <?= (url_is('peminjaman') && !url_is('peminjaman/denda')) ? 'active' : '' ?>" href="<?= base_url('/peminjaman') ?>">
            <i class="bi bi-arrow-left-right me-2"></i> Peminjaman
        </a>
    </li>

    <?php if (session()->get('role') == 'admin'): ?>
        <li class="nav-item">
            <a class="nav-link <?= (url_is('peminjaman/denda')) ? 'active' : '' ?>" href="<?= base_url('peminjaman/denda') ?>">
                <i class="bi bi-cash-stack me-2"></i> Data Denda
            </a>
        </li>
    <?php endif; ?>

    <li class="nav-item">
        <?php $idu = session('id_user'); ?>
        <a class="nav-link <?= (url_is('users/edit/*')) ? 'active' : '' ?>" href="<?= base_url('users/edit/' . $idu) ?>">
            <i class="bi bi-gear me-2"></i> Setting
        </a>
    </li>

    <?php if (session()->get('role') == 'admin') : ?>
        <li class="nav-item px-3 mt-3">
            <a href="<?= base_url('/backup') ?>" class="btn btn-success btn-sm w-100 shadow-sm text-white">
                <i class="bi bi-database-fill-check"></i> Backup Database
            </a>
        </li>
    <?php endif; ?>

    <li class="nav-item mt-3">
        <a class="nav-link text-danger" href="<?= base_url('/logout') ?>" onclick="return confirm('Yakin ingin logout?')">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
    </li>

</ul>

<hr class="mx-3 my-4">

<div class="text-center pb-4">
    <div class="mb-2">
        <?php if (session()->get('foto')): ?>
            <img src="<?= base_url('uploads/users/' . session()->get('foto')) ?>"
                height="70" width="70" style="object-fit: cover;"
                class="rounded-circle border border-2 border-primary shadow-sm" />
        <?php else: ?>
            <img src="https://ui-avatars.com/api/?name=<?= session('nama') ?>&background=0d6efd&color=fff"
                height="70" width="70" class="rounded-circle border border-2 border-primary shadow-sm" />
        <?php endif; ?>
    </div>

    <div class="px-3">
        <h6 class="mb-0 fw-bold text-dark"><?= session('nama'); ?></h6>
        <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">
            <?= session('role'); ?>
        </small>
    </div>
</div>