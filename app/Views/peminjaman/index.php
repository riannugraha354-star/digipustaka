<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Background & Layout Base DigiPustaka */
    body { background-color: #f4f7fa; }
    .content-wrapper { margin-left: 240px; padding: 40px; transition: 0.3s; }

    /* Header Styling seirama dengan Dashboard Admin */
    .page-header h2 { 
        color: #1a3a5f; 
        font-weight: 800; 
        display: flex; 
        align-items: center; 
        gap: 12px;
    }
    .page-header p { color: #6c757d; font-size: 14px; margin-left: 45px; }

    /* Container Tabel Bergaya Floating Card Modern */
    .table-container {
        background: white;
        border-radius: 25px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0,0,0,0.02);
    }

    /* Tabel Styling dengan Garis (Updated) */
    .table { 
        margin-bottom: 0; 
        border-collapse: collapse; /* Agar garis menyatu rapi */
    }

    .table thead th {
        border-bottom: 2px solid #f1f4f8; /* Garis bawah header lebih tegas */
        border-right: 1px solid #f1f4f8;  /* Garis vertikal antar kolom */
        background-color: #f8fbff;       /* Warna background header agar beda dengan isi */
        color: #adb5bd;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 20px 15px;
        text-align: center;
    }

    /* Hilangkan garis vertikal di ujung kanan header */
    .table thead th:last-child { border-right: none; }

    .table tbody tr { 
        transition: 0.3s;
    }
    .table tbody tr:hover { background-color: #f8fbff; }

    .table td { 
        padding: 20px 15px; 
        vertical-align: middle; 
        font-size: 14px;
        color: #495057;
        /* Garis Tabel Halus */
        border-bottom: 1px solid #f1f4f8; 
        border-right: 1px solid #f1f4f8;
    }

    /* Hilangkan garis vertikal di ujung kanan baris */
    .table td:last-child { border-right: none; }

    /* Avatar & User Info - Mirip Halaman Verifikasi Denda */
    .user-box { display: flex; align-items: center; gap: 12px; }
    .avatar-circle {
        width: 38px; height: 38px;
        background: #007bff;
        color: white;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 13px;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
    }

    /* Badge Status Pill Style */
    .badge-status {
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
    }
    /* Status Hijau untuk Selesai/Lunas */
    .status-selesai { background: #e6f9ed; color: #1f9d55; }
    .status-pinjam { background: #e7f3ff; color: #007bff; }
    /* Status Oranye untuk Terdenda/Pending */
    .status-pending { background: #fff4e6; color: #fd7e14; }

    /* Action Buttons */
    .btn-action {
        width: 35px; height: 35px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        border: none; transition: 0.3s;
        text-decoration: none;
    }
    .btn-confirm { background: #e7f3ff; color: #007bff; }
    .btn-confirm:hover { background: #007bff; color: white; }
    .btn-delete { background: #ffeded; color: #ff4d4d; }
    .btn-delete:hover { background: #ff4d4d; color: white; }

    /* Tombol Print Gradient */
    .btn-print {
        background: linear-gradient(45deg, #007bff, #00d4ff);
        border: none; color: white;
        padding: 10px 22px;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
        transition: 0.3s;
    }
    .btn-print:hover { transform: translateY(-2px); color: white; box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3); }

    @media (max-width: 992px) { .content-wrapper { margin-left: 0; } }
</style>

<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-start page-header mb-4">
        <div>
            <h2>
                <i class="bi bi-arrow-left-right text-primary"></i> 
                Data Peminjaman
            </h2>
            <p>Monitor riwayat sirkulasi buku dan status denda secara real-time.</p>
        </div>
        <a href="<?= base_url('peminjaman/print') ?>" target="_blank" class="btn btn-print">
            <i class="bi bi-printer me-2"></i> Cetak Laporan
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 15px;">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th class="text-start">User & Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Denda</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($peminjaman)): ?>
                        <?php $no = 1; foreach ($peminjaman as $p): ?>
                            <tr>
                                <td class="text-center fw-bold text-muted">#<?= str_pad($no++, 2, '0', STR_PAD_LEFT) ?></td>
                                <td>
                                    <div class="user-box">
                                        <div class="avatar-circle"><?= strtoupper(substr($p['nama'], 0, 1)) ?></div>
                                        <div>
                                            <div class="fw-bold text-dark d-block"><?= $p['nama'] ?></div>
                                            <small class="text-muted"><i class="bi bi-book me-1"></i><?= $p['judul'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center text-muted"><?= date('d/m/y', strtotime($p['tanggal_pinjam'])) ?></td>
                                <td class="text-center">
                                    <?php
                                        $tgl_k = strtotime($p['tanggal_kembali']);
                                        $telat = (time() > $tgl_k && $p['status'] == 'dipinjam');
                                    ?>
                                    <span class="<?= $telat ? 'text-danger fw-bold' : '' ?>">
                                        <?= date('d/m/y', $tgl_k) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if ($p['jumlah_denda'] > 0): ?>
                                        <span class="text-danger fw-bold">Rp<?= number_format($p['jumlah_denda'], 0, ',', '.') ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($p['status'] == 'pending'): ?>
                                        <span class="badge-status status-pending">Pending</span>
                                    <?php elseif ($p['status'] == 'dipinjam'): ?>
                                        <span class="badge-status status-pinjam">Dipinjam</span>
                                    <?php else: ?>
                                        <span class="badge-status status-selesai">Selesai</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <?php if (session()->get('role') == 'admin'): ?>
                                            <?php if ($p['status'] == 'pending'): ?>
                                                <a href="<?= base_url('peminjaman/konfirmasi_pinjam/' . $p['id_pinjam']) ?>" class="btn-action btn-confirm" title="Konfirmasi">
                                                    <i class="bi bi-check-lg"></i>
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?= base_url('peminjaman/delete/' . $p['id_pinjam']) ?>" class="btn-action btn-delete" onclick="return confirm('Hapus?')">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center py-5 text-muted italic">Belum ada riwayat peminjaman.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>