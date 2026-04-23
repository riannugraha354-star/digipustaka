<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Sinkronisasi Tema Admin Dashboard */
    body { background: #f0f5fa; font-family: 'Inter', sans-serif; }
    .content-wrapper { margin-left: 240px; padding: 40px; transition: all 0.3s ease; }

    .card-custom { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); background: white; overflow: hidden; }

    /* Table Styling */
    .table thead { background: #f8f9fa; color: #636e72; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; }
    .table td { vertical-align: middle; padding: 15px; }

    /* Status Badge */
    .badge-status { padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 11px; text-transform: uppercase; }
    .bg-verif { background: #e6f7ff; color: #1890ff; } /* Menunggu */
    .bg-lunas { background: #f6ffed; color: #52c41a; } /* Lunas */
    .bg-tolak { background: #fff1f0; color: #ff4d4f; } /* Ditolak */
    .bg-belum { background: #f5f5f5; color: #8c8c8c; } /* Belum Bayar */

    /* Image Preview */
    .img-admin-preview { width: 80px; height: 50px; object-fit: cover; border-radius: 8px; cursor: pointer; transition: 0.2s; border: 1px solid #eee; }
    .img-admin-preview:hover { transform: scale(1.05); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

    /* Action Buttons */
    .btn-verif { background: #52c41a; color: white; border: none; padding: 5px 12px; border-radius: 8px; font-size: 13px; transition: 0.3s; }
    .btn-verif:hover { background: #389e0d; color: white; box-shadow: 0 4px 10px rgba(82, 196, 26, 0.3); }
    
    .btn-tolak { background: #ff4d4f; color: white; border: none; padding: 5px 12px; border-radius: 8px; font-size: 13px; transition: 0.3s; }
    .btn-tolak:hover { background: #cf1322; color: white; box-shadow: 0 4px 10px rgba(255, 77, 79, 0.3); }

    @media (max-width: 768px) { .content-wrapper { margin-left: 0; padding: 20px; } }
</style>

<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-shield-check text-primary me-2"></i>Verifikasi Denda
            </h2>
            <p class="text-muted mb-0">Validasi bukti transfer dan kelola status pembayaran pengguna.</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card card-custom">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr class="text-center">
                        <th width="70">ID</th>
                        <th class="text-start">User</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Bukti Transaksi</th>
                        <th width="220">Konfirmasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($denda)): ?>
                        <?php foreach ($denda as $d) : ?>
                            <tr class="text-center">
                                <td class="fw-bold text-muted">#<?= $d['id_denda'] ?></td>
                                <td class="text-start">
                                    <div class="fw-bold text-dark"><?= $d['nama'] ?? 'User ID: '.$d['id_user'] ?></div>
                                    <small class="text-muted">Peminjaman ID: <?= $d['id_peminjaman'] ?? '-' ?></small>
                                </td>
                                <td><span class="text-primary fw-bold">Rp <?= number_format($d['denda'], 0, ',', '.') ?></span></td>
                                <td>
                                    <?php 
                                        $statusClass = 'bg-belum';
                                        if($d['status'] == 'menunggu_verifikasi') $statusClass = 'bg-verif';
                                        elseif($d['status'] == 'lunas') $statusClass = 'bg-lunas';
                                        elseif($d['status'] == 'ditolak') $statusClass = 'bg-tolak';
                                    ?>
                                    <span class="badge-status <?= $statusClass ?>">
                                        <?= str_replace('_', ' ', $d['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($d['bukti']) : ?>
                                        <a href="<?= base_url('uploads/bukti/' . $d['bukti']) ?>" target="_blank">
                                            <img src="<?= base_url('uploads/bukti/' . $d['bukti']) ?>" class="img-admin-preview shadow-sm" title="Klik untuk memperbesar">
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted small italic">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($d['status'] == 'menunggu_verifikasi') : ?>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="<?= base_url('admin/denda/verifikasi/' . $d['id_denda']) ?>" 
                                               class="btn btn-verif text-decoration-none shadow-sm"
                                               onclick="return confirm('Verifikasi pembayaran ini?')">
                                                <i class="bi bi-check-lg"></i> Terima
                                            </a>
                                            <a href="<?= base_url('admin/denda/tolak/' . $d['id_denda']) ?>" 
                                               class="btn btn-tolak text-decoration-none shadow-sm"
                                               onclick="return confirm('Tolak bukti pembayaran ini?')">
                                                <i class="bi bi-x-lg"></i> Tolak
                                            </a>
                                        </div>
                                    <?php else : ?>
                                        <span class="text-muted small">- Selesai -</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-muted"></i>
                                <span class="text-muted">Tidak ada data denda yang masuk.</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>