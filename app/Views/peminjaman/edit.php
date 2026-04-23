<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    body { background: #e7f1ff; }

    .content-wrapper {
        margin-left: 220px;
        padding: 25px;
    }

    .card-custom {
        border-radius: 16px;
        border: none;
        box-shadow: 0 6px 15px rgba(0,0,0,0.08);
        background: white;
    }

    .title { color: #1864ab; }

    .btn-custom { border-radius: 10px; }
</style>

<div class="content-wrapper">

    <h3 class="fw-bold title mb-4">
        <i class="bi bi-pencil-square"></i> Edit Peminjaman
    </h3>

    <div class="card card-custom p-4">

        <form action="<?= base_url('peminjaman/update/'.$peminjaman['id_pinjam']) ?>" method="post">

            <!-- User -->
            <div class="mb-3">
                <label class="form-label">User</label>
                <select name="id_user" class="form-control">
                    <?php foreach($users as $u): ?>
                        <option value="<?= $u['id_user'] ?>"
                            <?= $peminjaman['id_user'] == $u['id_user'] ? 'selected' : '' ?>>
                            <?= $u['nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Buku -->
            <div class="mb-3">
                <label class="form-label">Buku</label>
                <select name="id_buku" class="form-control">
                    <?php foreach($buku as $b): ?>
                        <option value="<?= $b['id_buku'] ?>"
                            <?= $peminjaman['id_buku'] == $b['id_buku'] ? 'selected' : '' ?>>
                            <?= $b['judul'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tanggal -->
            <div class="mb-3">
                <label class="form-label">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam"
                       value="<?= $peminjaman['tanggal_pinjam'] ?>"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali"
                       value="<?= $peminjaman['tanggal_kembali'] ?>"
                       class="form-control">
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="dipinjam" <?= $peminjaman['status']=='dipinjam'?'selected':'' ?>>Dipinjam</option>
                    <option value="dikembalikan" <?= $peminjaman['status']=='dikembalikan'?'selected':'' ?>>Dikembalikan</option>
                </select>
            </div>

            <button class="btn btn-primary btn-custom">
                <i class="bi bi-save"></i> Update
            </button>

            <a href="<?= base_url('peminjaman') ?>" class="btn btn-secondary btn-custom">
                Kembali
            </a>

        </form>

    </div>

</div>

<?= $this->endSection() ?>