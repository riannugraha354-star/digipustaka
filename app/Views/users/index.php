<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Sinkronisasi Tema dengan Menu Lain */
    body { background: #f0f5fa; font-family: 'Inter', sans-serif; }

    .content-wrapper { 
        margin-left: 240px; 
        padding: 40px; 
        transition: all 0.3s ease;
    }

    /* Card & Table Styling */
    .card-custom { 
        border-radius: 20px; 
        border: none; 
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); 
        background: white; 
        overflow: hidden;
    }

    .table thead { 
        background: #f8f9fa; 
        color: #636e72; 
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
    }

    .table td { vertical-align: middle; padding: 15px; }

    /* Avatar Styling */
    .img-user {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Role Badge */
    .badge-role {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
    }
    .bg-admin { background: #fff0f0; color: #ff4d4f; }
    .bg-petugas { background: #e6f7ff; color: #1890ff; }
    .bg-peminjam { background: #f6ffed; color: #52c41a; }

    /* Action Buttons */
    .btn-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: 0.2s;
    }

    @media (max-width: 768px) { .content-wrapper { margin-left: 0; padding: 20px; } }
</style>

<div class="content-wrapper">

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-people-fill text-primary me-2"></i>Manajemen Users
            </h2>
            <p class="text-muted mb-0">Kelola hak akses dan data profil pengguna sistem.</p>
        </div>
        </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div><?= session()->getFlashdata('success') ?></div>
            </div>
        </div>
    <?php endif; ?>

    <div class="card card-custom border-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr class="text-center">
                        <th width="70">No</th>
                        <th class="text-start">User Info</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php $no = 1; foreach ($users as $u): ?>
                            <tr>
                                <td class="text-center fw-bold text-muted"><?= $no++ ?></td>
                                
                                <td class="text-start">
                                    <div class="d-flex align-items-center">
                                        <?php if ($u['foto']): ?>
                                            <img src="<?= base_url('uploads/users/' . $u['foto']) ?>" class="img-user me-3">
                                        <?php else: ?>
                                            <img src="https://ui-avatars.com/api/?name=<?= $u['nama'] ?>&background=random" class="img-user me-3">
                                        <?php endif; ?>
                                        <div>
                                            <div class="fw-bold text-dark mb-0"><?= $u['nama'] ?></div>
                                            <small class="text-muted">ID: USR-<?= str_pad($u['id_user'], 3, '0', STR_PAD_LEFT) ?></small>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <code class="text-primary fw-bold"><?= $u['username'] ?></code>
                                </td>

                                <td class="text-center">
                                    <?php 
                                        $roleClass = '';
                                        if($u['role'] == 'admin') $roleClass = 'bg-admin';
                                        elseif($u['role'] == 'petugas') $roleClass = 'bg-petugas';
                                        else $roleClass = 'bg-peminjam';
                                    ?>
                                    <span class="badge-role <?= $roleClass ?>">
                                        <?= ucfirst($u['role']) ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <?php if (session()->get('role') == 'admin') : ?>
                                            <a href="<?= base_url('users/edit/' . $u['id_user']) ?>" 
                                               class="btn btn-warning btn-action text-white shadow-sm" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>

                                            <a href="<?= base_url('users/delete/' . $u['id_user']) ?>"
                                               onclick="return confirm('Hapus user ini?')"
                                               class="btn btn-danger btn-action shadow-sm" title="Hapus">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>

                                            <a href="<?= base_url('users/wa/' . $u['id_user']) ?>" 
                                               target="_blank" 
                                               class="btn btn-success btn-action shadow-sm" title="Hubungi WhatsApp">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">No Access</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-people fs-1 d-block mb-3 text-muted"></i>
                                <span class="text-muted fw-bold">Belum ada data user yang terdaftar.</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>