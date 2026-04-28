<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Sinkronisasi Tema Dashboard */
    body { background: #f0f5fa; font-family: 'Inter', sans-serif; }
    .content-wrapper { margin-left: 240px; padding: 40px; transition: all 0.3s ease; }

    .card-custom { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); background: white; overflow: hidden; }
    
    /* Info Box DANA */
    .dana-box {
        background: linear-gradient(135deg, #0085ff 0%, #005bc4 100%);
        color: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Badge Status */
    .badge-status { padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 11px; text-transform: uppercase; }
    .bg-pending { background: #fff7e6; color: #fa8c16; }
    .bg-success-light { background: #f6ffed; color: #52c41a; }
    .bg-danger-light { background: #fff1f0; color: #ff4d4f; }

    .table td { vertical-align: middle; padding: 15px; }
    .img-bukti { width: 60px; height: 60px; object-fit: cover; border-radius: 10px; cursor: pointer; transition: 0.3s; }
    .img-bukti:hover { transform: scale(1.1); }

    @media (max-width: 768px) { .content-wrapper { margin-left: 0; padding: 20px; } }
</style>

<div class="content-wrapper">
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1"><i class="bi bi-cash-stack text-primary me-2"></i>Tagihan Denda</h2>
        <p class="text-muted">Silakan selesaikan pembayaran denda keterlambatan Anda.</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4" style="border-radius: 15px; background-color: #f8d7da; color: #842029;">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-3"></i>
                <div>
                    <strong class="d-block">Gagal Meminjam!</strong>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <div class="dana-box shadow-sm">
        <div>
            <h5 class="mb-1 fw-bold"><i class="bi bi-wallet2 me-2"></i>Pembayaran via DANA</h5>
            <p class="mb-0 opacity-75">Transfer ke: <strong>087871684300</strong> (Dana DigiPustaka)</p>
        </div>
        <div class="text-end">
            <i class="bi bi-qr-code-scan fs-1"></i>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card card-custom">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3" width="80">ID</th>
                        <th class="py-3">Nominal Denda</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3 text-center">Bukti Bayar</th>
                        <th class="py-3 text-center" width="250">Aksi Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($denda)): ?>
                        <?php foreach ($denda as $d) : ?>
                            <tr>
                                <td class="px-4 fw-bold text-muted">#<?= $d['id_denda'] ?></td>
                                <td>
                                    <span class="fw-bold text-dark">Rp <?= number_format($d['denda'], 0, ',', '.') ?></span>
                                </td>
                                <td class="text-center">
                                    <?php 
                                        $statusClass = 'bg-pending';
                                        $statusText = $d['status'];
                                        if($d['status'] == 'lunas') $statusClass = 'bg-success-light';
                                        if($d['status'] == 'ditolak') $statusClass = 'bg-danger-light';
                                    ?>
                                    <span class="badge-status <?= $statusClass ?>"><?= str_replace('_', ' ', $statusText) ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($d['bukti']) : ?>
                                        <a href="<?= base_url('uploads/bukti/' . $d['bukti']) ?>" target="_blank">
                                            <img src="<?= base_url('uploads/bukti/' . $d['bukti']) ?>" class="img-bukti border shadow-sm">
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted small italic">Belum upload</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($d['status'] == 'belum_bayar' || $d['status'] == 'ditolak') : ?>
                                        <form action="<?= base_url('denda/bayar/' . $d['id_denda']) ?>" method="post" enctype="multipart/form-data" class="d-flex gap-2">
                                            <input type="hidden" name="metode_bayar" value="Transfer">
                                            <input type="file" name="bukti" class="form-control form-control-sm" required>
                                            <button type="submit" class="btn btn-primary btn-sm shadow-sm">
                                                <i class="bi bi-upload"></i>
                                            </button>
                                        </form>
                                    <?php else : ?>
                                        <div class="text-center text-muted small">
                                            <i class="bi bi-check-all text-success"></i> Sudah diproses
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-emoji-smile fs-2 d-block mb-2"></i>
                                Kamu tidak memiliki tunggakan denda.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>