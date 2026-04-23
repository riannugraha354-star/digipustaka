<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
// halaman untuk menampilkan form tambah buku
<style>
    body { background: #e7f1ff; }

    .content-wrapper {
        margin-left: 240px;
        padding: 20px;
    }

    .card-custom {
        border-radius: 16px;
        border: none;
        box-shadow: 0 6px 15px rgba(0,0,0,0.08);
        background: white;
    }

    .form-control {
        border-radius: 10px;
        height: 45px;
    }

    .btn-primary {
        background: #4dabf7;
        border: none;
        border-radius: 10px;
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        color: #4dabf7;
    }

    .input-icon input, .input-icon .custom-file-input {
        padding-left: 40px;
    }

    /* Style untuk Preview Gambar */
    .img-preview {
        width: 120px;
        height: 160px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px dashed #4dabf7;
        display: none; /* Sembunyi sebelum ada file */
        margin-bottom: 15px;
    }
</style>

<div class="content-wrapper">

    <h3 class="fw-bold text-primary mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Buku
    </h3>

    <div class="card card-custom p-4">

        <form action="<?= base_url('buku/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="text-center">
                <img src="" class="img-preview mx-auto" id="previewImg">
            </div>

            <div class="mb-3">
                <label class="fw-bold mb-1">Cover Buku</label>
                <div class="input-icon">
                    <i class="bi bi-image"></i>
                    <input type="file" name="cover" class="form-control" id="coverInput" onchange="previewFile()" accept="image/*">
                </div>
                <small class="text-muted">*Format: JPG, PNG, JPEG. Max: 2MB.</small>
            </div>

            <div class="mb-3 input-icon">
                <i class="bi bi-book"></i>
                <input type="text" name="judul" class="form-control" placeholder="Judul Buku" required>
            </div>

            <div class="mb-3 input-icon">
                <i class="bi bi-person"></i>
                <input type="text" name="penulis" class="form-control" placeholder="Penulis">
            </div>

            <div class="mb-3 input-icon">
                <i class="bi bi-building"></i>
                <input type="text" name="penerbit" class="form-control" placeholder="Penerbit">
            </div>

            <div class="mb-3 input-icon">
                <i class="bi bi-calendar"></i>
                <input type="number" name="tahun" class="form-control" placeholder="Tahun">
            </div>

            <div class="mb-3 input-icon">
                <i class="bi bi-box"></i>
                <input type="number" name="stok" class="form-control" placeholder="Stok" required>
            </div>

            <button class="btn btn-primary w-100 mb-2 py-2 fw-bold">
                <i class="bi bi-save"></i> Simpan Data Buku
            </button>

            <a href="<?= base_url('buku') ?>" class="btn btn-secondary w-100 py-2">
                Kembali
            </a>

        </form>

    </div>

</div>

<script>
    function previewFile() {
        const preview = document.querySelector('#previewImg');
        const file = document.querySelector('#coverInput').files[0];
        const reader = new FileReader();

        reader.addEventListener("load", function () {
            // Ubah source image ke file yang dipilih
            preview.src = reader.result;
            preview.style.display = "block";
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>

<?= $this->endSection() ?>