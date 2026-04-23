<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    body {
        background: #e7f1ff;
    }

    .content-wrapper {
        margin-left: 240px;
        padding: 30px;
    }

    .card-custom {
        border-radius: 16px;
        border: none;
        box-shadow: 0 6px 15px rgba(0,0,0,0.08);
        background: #ffffff;
        max-width: 600px; /* Dibuat lebih ramping agar elegan */
        margin: auto;
    }

    .form-control, .form-select {
        border-radius: 10px;
        height: 45px;
        border: 1px solid #dee2e6;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 8px rgba(77,171,247,0.4);
        border-color: #4dabf7;
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        color: #4dabf7;
    }

    .input-icon input,
    .input-icon select {
        padding-left: 40px;
    }

    .btn-primary {
        background: #4dabf7;
        border: none;
        border-radius: 10px;
        height: 45px;
        font-weight: 600;
    }

    .btn-secondary {
        border-radius: 10px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #4dabf7;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .content-wrapper {
            margin-left: 0;
        }
    }
</style>

<div class="content-wrapper">

    <div class="mb-4 text-center">
        <h3 class="fw-bold text-primary">
            <i class="bi bi-person-gear"></i> Pengaturan Profil
        </h3>
        <p class="text-muted">Kelola informasi akun Anda di sini</p>
    </div>

    <div class="card card-custom p-4">

        <form action="<?= base_url('users/update/' . $user['id_user']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="mb-4 text-center">
                <?php if ($user['foto']): ?>
                    <img src="<?= base_url('uploads/users/' . $user['foto']) ?>" class="profile-img mb-3">
                <?php else: ?>
                    <img src="https://ui-avatars.com/api/?name=<?= $user['nama'] ?>&background=4dabf7&color=fff" class="profile-img mb-3">
                <?php endif; ?>
                <div class="px-5">
                    <input type="file" name="foto" class="form-control form-control-sm">
                    <small class="text-muted mt-1 d-block italic text-start text-center">Format: JPG/PNG, Max: 2MB</small>
                </div>
            </div>

            <label class="small fw-bold text-muted mb-1">Nama Lengkap</label>
            <div class="mb-3 input-icon">
                <i class="bi bi-person"></i>
                <input type="text" name="nama" value="<?= $user['nama'] ?>" class="form-control" placeholder="Nama Lengkap" required>
            </div>

            <label class="small fw-bold text-muted mb-1">Username</label>
            <div class="mb-3 input-icon">
                <i class="bi bi-person-circle"></i>
                <input type="text" name="username" value="<?= $user['username'] ?>" class="form-control" placeholder="Username" required>
            </div>

            <label class="small fw-bold text-muted mb-1">Password Baru</label>
            <div class="mb-3 input-icon">
                <i class="bi bi-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin diubah">
            </div>

            <label class="small fw-bold text-muted mb-1">Role Akun</label>
            <div class="mb-4 input-icon">
                <i class="bi bi-shield-lock"></i>
                <?php if (session()->get('role') == 'admin'): ?>
                    <select name="role" class="form-select">
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                    </select>
                <?php else: ?>
                    <input type="text" class="form-control bg-light" value="<?= ucfirst($user['role']) ?>" readonly>
                    <input type="hidden" name="role" value="<?= $user['role'] ?>">
                <?php endif; ?>
            </div>

            <div class="row g-2">
                <div class="col-8">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
                <div class="col-4">
                    <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary w-100">
                        Batal
                    </a>
                </div>
            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>