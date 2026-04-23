<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    body { background: #e7f1ff; }
    .content-wrapper { margin-left: 240px; padding: 20px; }
    .card-custom { border-radius: 16px; border: none; box-shadow: 0 6px 15px rgba(0,0,0,0.08); background: white; }
    .form-control { border-radius: 10px; height: 45px; }
    .btn-primary { background: #4dabf7; border: none; border-radius: 10px; }
    .input-icon { position: relative; }
    .input-icon i { position: absolute; top: 50%; left: 12px; transform: translateY(-50%); color: #4dabf7; }
    .input-icon input, .input-icon select { padding-left: 40px; }
    
    /* Style Preview Cover */
    .preview-cover {
        width: 100px;
        height: 130px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #4dabf7;
        margin-bottom: 10px;
    }
</style>

<div class="content-wrapper">

    <h3 class="fw-bold text-primary mb-3">
        <i class="bi bi-pencil-square"></i> Edit Buku
    </h3>

    <div class="card card-custom p-4">

        <form action="<?= base_url('buku/update/' . $buku['id_buku']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="row">
                <div class="col-md-3 text-center mb-3">
                    <label class="d-block fw-bold mb-2">Cover Saat Ini</label>
                    <?php 
                        $cover = (!empty($buku['cover']) && file_exists('img/' . $buku['cover'])) ? $buku['cover'] : 'default.jpg';
                    ?>
                    <img src="<?= base_url('img/' . $cover) ?>" class="preview-cover" id="imgPreview">
                    <p class="small text-muted">Abaikan jika tidak ingin mengubah cover</p>
                </div>

                <div class="col-md-9">
                    <div class="mb-3">
                        <label class="fw-bold mb-1">Ganti Cover Baru</label>
                        <input type="file" name="cover" class="form-control" onchange="previewImg()">
                    </div>

                    <div class="mb-3 input-icon">
                        <i class="bi bi-book"></i>
                        <input type="text" name="judul" value="<?= esc($buku['judul']) ?>" class="form-control" placeholder="Judul Buku" required>
                    </div>

                    <div class="mb-3 input-icon">
                        <i class="bi bi-person"></i>
                        <input type="text" name="penulis" value="<?= esc($buku['penulis']) ?>" class="form-control" placeholder="Penulis">
                    </div>

                    <div class="mb-3 input-icon">
                        <i class="bi bi-building"></i>
                        <input type="text" name="penerbit" value="<?= esc($buku['penerbit']) ?>" class="form-control" placeholder="Penerbit">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3 input-icon">
                            <i class="bi bi-calendar"></i>
                            <input type="number" name="tahun" value="<?= esc($buku['tahun']) ?>" class="form-control" placeholder="Tahun Terbit">
                        </div>
                        <div class="col-md-6 mb-3 input-icon">
                            <i class="bi bi-box"></i>
                            <input type="number" name="stok" value="<?= esc($buku['stok']) ?>" class="form-control" placeholder="Jumlah Stok" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-2 py-2 fw-bold">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>

                    <a href="<?= base_url('buku') ?>" class="btn btn-secondary w-100 py-2">
                        Batal
                    </a>
                </div>
            </div>

        </form>

    </div>

</div>

<script>
    function previewImg() {
        const cover = document.querySelector('input[name="cover"]');
        const imgPreview = document.querySelector('#imgPreview');

        const fileCover = new FileReader();
        fileCover.readAsDataURL(cover.files[0]);

        fileCover.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>

<?= $this->endSection() ?>