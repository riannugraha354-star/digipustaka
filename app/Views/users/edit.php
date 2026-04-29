<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Background khas DigiPustaka */
    body { background-color: #f4f7fa; }
    .content-wrapper { margin-left: 240px; padding: 40px; transition: 0.3s; }

    /* Header Styling - KEMBALI SEJAJAR TENGAH (Sesuai image_d12438) */
    .page-header {
        text-align: center; /* Memastikan semua teks di dalam header ke tengah */
        margin-bottom: 30px;
    }

    .page-header h2 { 
        color: #1a3a5f; 
        font-weight: 800; 
        display: flex; 
        align-items: center; 
        justify-content: center; /* Membuat Ikon dan Teks sejajar di tengah */
        gap: 12px;
        margin-bottom: 5px;
    }
    
    .page-header p { 
        color: #6c757d; 
        font-size: 14px; 
        margin-left: 0; /* Hapus margin agar tidak miring ke kanan */
        margin-top: 0;
    }

    /* Card Styling - Floating Modern */
    .card-custom {
        border-radius: 25px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        background: #ffffff;
        max-width: 550px;
        margin: auto;
        padding: 30px;
        border: 1px solid rgba(0, 123, 255, 0.05);
    }

    /* Avatar Box - Dibuat Bulat Sesuai Referensi image_d12438 */
    .profile-img-container {
        position: relative;
        display: inline-block;
        margin-bottom: 25px;
    }
    .profile-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%; /* Kembali ke bulat sempurna sesuai image_d12438 */
        border: 4px solid #fff;
        box-shadow: 0 8px 20px rgba(0, 123, 255, 0.15);
    }

    /* Form Styling */
    .form-label-custom {
        font-size: 11px;
        font-weight: 700;
        color: #8e9aaf;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 8px;
        display: block;
        text-align: left; /* Label tetap rata kiri */
    }
    .input-icon-group {
        position: relative;
        margin-bottom: 20px;
    }
    .input-icon-group i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #007bff;
        font-size: 18px;
    }
    .form-control-custom {
        padding: 12px 15px 12px 45px;
        border-radius: 12px;
        border: 1px solid #eef2f7;
        background: #fcfdfe;
        transition: 0.3s;
        font-size: 14px;
    }
    .form-control-custom:focus {
        background: #fff;
        border-color: #007bff;
        box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1);
        outline: none;
    }

    /* Button Styling */
    .btn-save {
        background: linear-gradient(45deg, #007bff, #00d4ff);
        border: none; color: white;
        padding: 12px;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
        transition: 0.3s;
    }
    .btn-save:hover { transform: translateY(-2px); color: white; box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3); }

    .btn-cancel {
        background: #f8f9fa;
        color: #6c757d;
        border: 1px solid #eef2f7;
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-cancel:hover { background: #e9ecef; color: #495057; }

    @media (max-width: 992px) { .content-wrapper { margin-left: 0; } }
</style>
<div class="content-wrapper">
    <div class="page-header mb-4">
        <h2><i class="bi bi-person-gear text-primary"></i> Pengaturan Profil</h2>
        <p>Kelola identitas dan keamanan akun DigiPustaka Anda.</p>
    </div>

    <div class="card card-custom">
        <form action="<?= base_url('users/update/' . $user['id_user']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="text-center">
                <div class="profile-img-container">
                    <?php if ($user['foto']): ?>
                        <img src="<?= base_url('uploads/users/' . $user['foto']) ?>" class="profile-img">
                    <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?= $user['nama'] ?>&background=007bff&color=fff&size=120" class="profile-img">
                    <?php endif; ?>
                </div>
                <div class="mb-4 px-4 text-start">
                    <label class="form-label-custom text-center">Ganti Foto Profil</label>
                    <input type="file" name="foto" class="form-control form-control-sm border-0 bg-light">
                    <small class="text-muted d-block text-center mt-2" style="font-size: 11px;">Max size 2MB (JPG/PNG)</small>
                </div>
            </div>

            <label class="form-label-custom">Nama Lengkap</label>
            <div class="input-icon-group">
                <i class="bi bi-person"></i>
                <input type="text" name="nama" value="<?= $user['nama'] ?>" class="form-control form-control-custom" placeholder="Nama Lengkap" required>
            </div>

            <label class="form-label-custom">Username</label>
            <div class="input-icon-group">
                <i class="bi bi-at"></i>
                <input type="text" name="username" value="<?= $user['username'] ?>" class="form-control form-control-custom" placeholder="Username" required>
            </div>

            <label class="form-label-custom">Keamanan (Password Baru)</label>
            <div class="input-icon-group">
                <i class="bi bi-shield-lock"></i>
                <input type="password" name="password" class="form-control form-control-custom" placeholder="Isi hanya jika ingin ganti password">
            </div>

            <label class="form-label-custom">Hak Akses</label>
            <div class="input-icon-group">
                <i class="bi bi-key"></i>
                <?php if (session()->get('role') == 'admin'): ?>
                    <select name="role" class="form-control form-control-custom form-select">
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Administrator</option>
                        <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>Petugas / User</option>
                    </select>
                <?php else: ?>
                    <input type="text" class="form-control form-control-custom bg-light" value="<?= ucfirst($user['role']) ?>" readonly>
                    <input type="hidden" name="role" value="<?= $user['role'] ?>">
                <?php endif; ?>
            </div>

            <hr class="my-4 opacity-25">

            <div class="row g-3">
                <div class="col-sm-8">
                    <button type="submit" class="btn btn-save w-100">
                        <i class="bi bi-check2-circle me-2"></i> Simpan Perubahan
                    </button>
                </div>
                <div class="col-sm-4">
                    <a href="<?= base_url('/') ?>" class="btn btn-cancel w-100 text-decoration-none d-block text-center">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>