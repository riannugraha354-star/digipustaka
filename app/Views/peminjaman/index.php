<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    body { background: #e7f1ff; }
    .content-wrapper { margin-left: 220px; padding: 25px; }
    .card-custom { 
        border-radius: 16px; 
        border: none; 
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08); 
        background: white; 
    }
    .table thead { background: #4dabf7; color: white; }
    .badge-status { 
        padding: 6px 12px; 
        border-radius: 10px; 
        font-size: 13px; 
        font-weight: 500; 
        display: inline-block; 
        min-width: 125px; 
        text-align: center; 
    }
    .badge-pending { background: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6; }
    .badge-dipinjam { background: #e7f5ff; color: #1971c2; border: 1px solid #a5d8ff; }
    .badge-proses-kembali { background: #fff9db; color: #f08c00; border: 1px solid #ffe066; }
    .badge-kembali { background: #ebfbee; color: #2f9e44; border: 1px solid #b2f2bb; }
    .btn-custom { border-radius: 10px; transition: 0.3s; display: flex; align-items: center; gap: 5px; font-weight: 500; }
    .btn-custom:hover { transform: translateY(-2px); }
    .title { color: #1864ab; }

    @media (max-width: 768px) { .content-wrapper { margin-left: 0; } }
</style>

<div class="content-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold title">
                <i class="bi bi-arrow-left-right"></i> Data Peminjaman
            </h3>
            <small class="text-muted">Daftar riwayat, tenggat waktu, dan denda</small>
        </div>

        <div class="d-flex gap-2">
            <a href="<?= base_url('peminjaman/print') ?>" target="_blank" class="btn btn-success btn-custom text-white shadow-sm">
                <i class="bi bi-printer"></i> Print Laporan
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" style="border-radius: 12px;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div><?= session()->getFlashdata('success') ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show" style="border-radius: 12px;">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div><strong>Peringatan!</strong> <?= session()->getFlashdata('error') ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card card-custom p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="text-center">
                    <tr>
                        <th width="50">No</th>
                        <th>User</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Denda</th>
                        <th>Status</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($peminjaman)): ?>
                        <?php $no = 1; foreach ($peminjaman as $p): ?>
                            <tr>
                                <td class="text-center font-monospace"><?= $no++ ?></td>
                                <td><i class="bi bi-person-circle text-primary me-2"></i><strong><?= $p['nama'] ?></strong></td>
                                <td><i class="bi bi-book text-secondary me-2"></i><?= $p['judul'] ?></td>
                                <td class="text-center"><?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?></td>

                                <td class="text-center">
                                    <?php
                                    $tgl_kembali = strtotime($p['tanggal_kembali']);
                                    $hari_ini = strtotime(date('Y-m-d'));
                                    $is_telat = ($hari_ini > $tgl_kembali && $p['status'] == 'dipinjam');
                                    ?>
                                    <span class="<?= $is_telat ? 'text-danger fw-bold' : 'text-primary' ?>">
                                        <?= date('d M Y', $tgl_kembali) ?>
                                        <?php if ($is_telat): ?>
                                            <br><small class="badge bg-danger" style="font-size: 9px;">TERLAMBAT</small>
                                        <?php endif; ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <?php if (!empty($p['jumlah_denda']) && $p['jumlah_denda'] > 0): ?>
                                        <span class="text-danger fw-bold">
                                            Rp <?= number_format($p['jumlah_denda'], 0, ',', '.') ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php if ($p['status'] == 'pending'): ?>
                                        <span class="badge-status badge-pending">
                                            <i class="bi bi-hourglass-split"></i> Menunggu
                                        </span>
                                    <?php elseif ($p['status'] == 'dipinjam'): ?>
                                        <span class="badge-status badge-dipinjam">
                                            <i class="bi bi-clock-history"></i> Dipinjam
                                        </span>
                                    <?php elseif ($p['status'] == 'menunggu_kembali'): ?>
                                        <span class="badge-status badge-proses-kembali">
                                            <i class="bi bi-arrow-repeat"></i> Proses Kembali
                                        </span>
                                    <?php else: ?>
                                        <span class="badge-status badge-kembali">
                                            <i class="bi bi-check-all"></i> Selesai
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <?php if (session()->get('role') == 'admin'): ?>
                                            <?php if ($p['status'] == 'pending'): ?>
                                                <a href="<?= base_url('peminjaman/konfirmasi_pinjam/' . $p['id_pinjam']) ?>"
                                                    class="btn btn-primary btn-sm btn-custom">
                                                    <i class="bi bi-check-lg"></i> Setuju
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($p['status'] == 'menunggu_kembali'): ?>
                                                <a href="<?= base_url('peminjaman/konfirmasi_kembali/' . $p['id_pinjam']) ?>"
                                                    class="btn btn-success btn-sm btn-custom">
                                                    <i class="bi bi-box-arrow-in-down"></i> Terima
                                                </a>
                                            <?php endif; ?>

                                            <a href="<?= base_url('peminjaman/delete/' . $p['id_pinjam']) ?>"
                                                class="btn btn-outline-danger btn-sm btn-custom"
                                                onclick="return confirm('Hapus data peminjaman ini?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <?php if ($p['status'] == 'dipinjam'): ?>
                                                <a href="<?= base_url('peminjaman/ajukan_kembali/' . $p['id_pinjam']) ?>"
                                                    class="btn btn-warning btn-sm btn-custom"
                                                    onclick="return confirm('Kembalikan buku ini?')">
                                                    <i class="bi bi-arrow-left"></i> Kembalikan
                                                </a>
                                            <?php elseif ($p['status'] == 'pending'): ?>
                                                <span class="text-muted small italic">Menunggu Persetujuan...</span>
                                            <?php elseif ($p['status'] == 'menunggu_kembali'): ?>
                                                <span class="text-warning small italic">Menunggu Verifikasi...</span>
                                            <?php else: ?>
                                                <span class="text-success small fw-bold"><i class="bi bi-shield-check"></i> Selesai</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">Belum ada riwayat peminjaman.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>