<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Sinkronisasi Tema DigiPustaka */
    body { background-color: #f4f7fa; font-family: 'Inter', sans-serif; }
    .content-wrapper { margin-left: 240px; padding: 40px; transition: 0.3s; }

    /* Header Styling */
    .page-header h2 { color: #1a3a5f; font-weight: 800; display: flex; align-items: center; gap: 12px; }
    .page-header p { color: #6c757d; font-size: 14px; margin-left: 45px; }

    /* Info Box DANA - Modern Gradient */
    .dana-box {
        background: linear-gradient(135deg, #007bff 0%, #00d4ff 100%);
        color: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        border: none;
    }
    .dana-box::after {
        content: ''; position: absolute; top: -20px; right: -20px;
        width: 150px; height: 150px; background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    /* Card & Table Styling */
    .card-custom {
        border-radius: 25px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        background: white;
        overflow: hidden;
    }
    .table thead th {
        background-color: #fcfdfe;
        color: #8e9aaf;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        border-top: none;
        padding: 20px;
    }
    .table tbody td { padding: 20px; vertical-align: middle; color: #495057; border-color: #f1f4f8; }

    /* Badge Status Modern */
    .badge-status {
        padding: 6px 14px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 10px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .bg-pending { background: #fff7e6; color: #fa8c16; border: 1px solid #ffe7ba; }
    .bg-success-light { background: #e6fffa; color: #047857; border: 1px solid #b2f5ea; }
    .bg-danger-light { background: #fff5f5; color: #c53030; border: 1px solid #fed7d7; }

    /* Upload Styling */
    .btn-upload {
        background: #007bff;
        color: white;
        border-radius: 10px;
        padding: 8px 15px;
        font-weight: 600;
        transition: 0.3s;
        border: none;
    }
    .btn-upload:hover { background: #0056b3; transform: translateY(-2px); }
    
    .form-control-upload {
        border-radius: 10px;
        border: 1px dashed #ced4da;
        background: #f8f9fa;
        font-size: 12px;
    }

    .img-bukti { 
        width: 50px; height: 50px; 
        object-fit: cover; 
        border-radius: 12px; 
        border: 2px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: 0.3s;
    }
    .img-bukti:hover { transform: scale(1.2) rotate(3deg); }

    @media (max-width: 992px) { .content-wrapper { margin-left: 0; padding: 20px; } }
</style>

<div class="content-wrapper">
    <div class="page-header mb-4">
        <h2><i class="bi bi-cash-stack text-primary"></i> Tagihan Denda</h2>
        <p>Lihat riwayat dan selesaikan pembayaran denda Anda.</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4" style="border-radius: 18px;">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-circle-fill fs-4 me-3"></i>
                <div><?= session()->getFlashdata('error') ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" style="border-radius: 18px;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div><?= session()->getFlashdata('success') ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="dana-box shadow-sm d-flex align-items-center justify-content-between">
        <div>
            <span class="badge bg-white text-primary fw-bold mb-2 px-3 py-2 rounded-pill shadow-sm" style="font-size: 10px;">METODE PEMBAYARAN</span>
            <h4 class="mb-1 fw-bold">Transfer via DANA</h4>
            <p class="mb-0 opacity-100 fw-medium">Nomor Tujuan: <span class="bg-white text-dark px-2 py-1 rounded mx-1">087871684300</span> a/n DigiPustaka</p>
        </div>
        <div class="text-end d-none d-md-block">
            <i class="bi bi-qr-code-scan" style="font-size: 4rem; opacity: 0.8;"></i>
        </div>
    </div>

    <div class="card card-custom">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="100">Invoice</th>
                        <th>Nominal</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Bukti Bayar</th>
                        <th class="text-center" width="300">Aksi Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($denda)): ?>
                        <?php foreach ($denda as $d) : ?>
                            <tr>
                                <td class="fw-bold text-primary">#DEN-<?= $d['id_denda'] ?></td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark fs-5">Rp <?= number_format($d['denda'], 0, ',', '.') ?></span>
                                        <small class="text-muted" style="font-size: 10px;">Denda Keterlambatan</small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php 
                                        $statusClass = 'bg-pending';
                                        $icon = 'bi-clock-history';
                                        if($d['status'] == 'lunas') { $statusClass = 'bg-success-light'; $icon = 'bi-check-circle'; }
                                        if($d['status'] == 'ditolak') { $statusClass = 'bg-danger-light'; $icon = 'bi-x-circle'; }
                                    ?>
                                    <span class="badge-status <?= $statusClass ?>">
                                        <i class="bi <?= $icon ?>"></i> <?= str_replace('_', ' ', $d['status']) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if ($d['bukti']) : ?>
                                        <a href="<?= base_url('uploads/bukti/' . $d['bukti']) ?>" target="_blank">
                                            <img src="<?= base_url('uploads/bukti/' . $d['bukti']) ?>" class="img-bukti">
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted small"><i class="bi bi-image"></i> Kosong</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($d['status'] == 'belum_bayar' || $d['status'] == 'ditolak') : ?>
                                        <form action="<?= base_url('denda/bayar/' . $d['id_denda']) ?>" method="post" enctype="multipart/form-data">
                                            <div class="input-group">
                                                <input type="hidden" name="metode_bayar" value="Transfer">
                                                <input type="file" name="bukti" class="form-control form-control-sm form-control-upload" required>
                                                <button type="submit" class="btn btn-upload shadow-sm">
                                                    <i class="bi bi-send-fill"></i>
                                                </button>
                                            </div>
                                        </form>
                                    <?php else : ?>
                                        <div class="text-center py-2 px-3 rounded-pill bg-light text-muted" style="font-size: 12px;">
                                            <i class="bi bi-shield-check text-success me-1"></i> Pembayaran Terverifikasi
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-emoji-smile fs-1 text-primary opacity-25 d-block mb-3"></i>
                                    <h5 class="text-dark fw-bold mb-1">Wah, Kamu Hebat!</h5>
                                    <p class="text-muted small">Tidak ada tunggakan denda yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>