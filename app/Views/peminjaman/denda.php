<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="content-wrapper" style="margin-left: 240px; padding: 30px;">
    <div class="mb-4">
        <h3 class="fw-bold"><i class="bi bi-cash-stack text-danger"></i> Data Denda & Tunggakan</h3>
        <p class="text-muted">Daftar pengguna yang terlambat mengembalikan buku.</p>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Buku</th>
                            <th>Tgl Kembali Seharusnya</th>
                            <th>Keterlambatan</th>
                            <th>Total Denda</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($peminjaman as $p) : 
                            // Hitung selisih hari jika belum kembali
                            $tgl_sekarang_dt = new DateTime($tgl_sekarang);
                            $tgl_kembali_dt = new DateTime($p['tanggal_kembali']);
                            $selisih = 0;
                            if ($tgl_sekarang_dt > $tgl_kembali_dt && $p['status'] == 'dipinjam') {
                                $diff = $tgl_sekarang_dt->diff($tgl_kembali_dt);
                                $selisih = $diff->days;
                            }
                        ?>
                        <tr>
                            <td><strong><?= $p['nama'] ?></strong></td>
                            <td><?= $p['judul'] ?></td>
                            <td><span class="badge bg-secondary"><?= date('d M Y', strtotime($p['tanggal_kembali'])) ?></span></td>
                            <td>
                                <?php if($p['status'] == 'kembali'): ?>
                                    <span class="text-success">Sudah Dikembalikan</span>
                                <?php else: ?>
                                    <span class="text-danger fw-bold"><?= $selisih ?> Hari</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="text-danger fw-bold">
                                    Rp <?= number_format($p['denda'] > 0 ? $p['denda'] : $selisih * 1000, 0, ',', '.') ?>
                                </span>
                            </td>
                            <td>
                                <?php if($p['status'] == 'dipinjam'): ?>
                                    <span class="badge bg-warning">Masih Dipinjam</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Selesai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>