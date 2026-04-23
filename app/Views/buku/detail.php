<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .content-wrapper { margin-left: 240px; padding: 25px; }
    .card-detail { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    .info-label { font-weight: bold; color: #4dabf7; width: 150px; display: inline-block; }
    @media (max-width: 768px) { .content-wrapper { margin-left: 0; } }
</style>

<div class="content-wrapper">
    <div class="mb-4">
        <a href="<?= base_url('buku') ?>" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
        <h3 class="fw-bold text-primary">Detail Informasi Buku</h3>
    </div>

    <div class="card card-detail p-4">
        <div class="row">
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <i class="bi bi-book text-primary" style="font-size: 8rem;"></i>
            </div>
            <div class="col-md-8">
                <h2 class="fw-bold mb-4"><?= esc($buku['judul']) ?></h2>
                
                <div class="mb-3">
                    <span class="info-label">Penulis</span>
                    <span class="text-muted">: <?= esc($buku['penulis']) ?></span>
                </div>
                <div class="mb-3">
                    <span class="info-label">Penerbit</span>
                    <span class="text-muted">: <?= esc($buku['penerbit']) ?></span>
                </div>
                <div class="mb-3">
                    <span class="info-label">Tahun Terbit</span>
                    <span class="text-muted">: <?= esc($buku['tahun']) ?></span>
                </div>
                <div class="mb-3">
                    <span class="info-label">Stok Tersedia</span>
                    <span class="badge bg-info text-dark"><?= $buku['stok'] ?> Buku</span>
                </div>

                <hr>

                <div class="mt-4">
                    <?php if (session()->get('role') == 'user' && $buku['stok'] > 0) : ?>
                        <a href="<?= base_url('pinjam/'.$buku['id_buku']) ?>" class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-box-arrow-in-right"></i> Pinjam Sekarang
                        </a>
                    <?php elseif (session()->get('role') == 'admin') : ?>
                        <a href="<?= base_url('buku/edit/'.$buku['id_buku']) ?>" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit Data
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>