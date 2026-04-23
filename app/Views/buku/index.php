<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Sinkronisasi Font & Background */
    body { background: #f0f5fa; font-family: 'Inter', sans-serif; }

    .content-wrapper { 
        margin-left: 240px; 
        padding: 40px; 
        transition: all 0.3s ease;
    }

    /* Card Styling */
    .card-custom { 
        border-radius: 20px; 
        border: none; 
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); 
        background: white; 
        overflow: hidden;
    }

    /* Header & Search Bar */
    .title-text { color: #2d3436; letter-spacing: -0.5px; }
    
    .search-container {
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
    }
    
    .search-container:focus-within {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        border-color: #0d6efd;
    }

    /* Table Styling */
    .table thead { 
        background: #f8f9fa; 
        color: #636e72; 
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
    }
    
    .table td { vertical-align: middle; padding: 15px; color: #2d3436; }
    
    /* Cover Buku Modern */
    .img-cover {
        width: 55px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .img-cover:hover { transform: scale(1.15) rotate(2deg); }

    /* Stok Badge */
    .badge-stok { 
        background: #e7f1ff; 
        color: #0d6efd; 
        padding: 6px 12px; 
        border-radius: 10px; 
        font-weight: 700; 
        font-size: 0.85rem;
    }

    /* Button Actions */
    .btn-action {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s;
    }
    
    .btn-add {
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }

    @media (max-width: 768px) { .content-wrapper { margin-left: 0; padding: 20px; } }
</style>

<div class="content-wrapper">

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold title-text mb-1">
                <i class="bi bi-book-half text-primary me-2"></i>Katalog Buku
            </h2>
            <p class="text-muted mb-0">
                <?= session()->get('role') == 'admin' ? 'Kelola koleksi buku perpustakaan Anda.' : 'Temukan bacaan menarik untuk hari ini.' ?>
            </p>
        </div>

        <?php if (session()->get('role') == 'admin') : ?>
            <a href="<?= base_url('buku/create') ?>" class="btn btn-primary btn-add">
                <i class="bi bi-plus-circle-fill me-2"></i> Tambah Koleksi
            </a>
        <?php endif; ?>
    </div>

    <div class="card card-custom p-3 mb-4 border-0">
        <form method="get" action="<?= base_url('buku') ?>">
            <div class="input-group search-container">
                <span class="input-group-text bg-white border-0 py-3 ps-3">
                    <i class="bi bi-search text-primary"></i>
                </span>
                <input type="text" 
                       name="keyword" 
                       class="form-control border-0 shadow-none" 
                       placeholder="Cari judul buku, penulis, atau kategori..."
                       value="<?= esc($keyword ?? '') ?>">
                <?php if (!empty($keyword)) : ?>
                    <a href="<?= base_url('buku') ?>" class="btn btn-light border-0 py-3 px-3 text-muted">Reset</a>
                <?php endif; ?>
                <button class="btn btn-primary px-4 fw-bold" type="submit">Cari</button>
            </div>
        </form>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div><?= session()->getFlashdata('success') ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card card-custom border-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center" width="70">No</th>
                        <th width="100">Cover</th> 
                        <th>Detail Buku</th>
                        <th>Penulis</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center" width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($buku)): ?>
                        <?php $no=1; foreach($buku as $b): ?>
                        <tr>
                            <td class="text-center fw-bold text-muted"><?= $no++ ?></td>
                            
                            <td>
                                <?php 
                                    $pathFile = 'img/' . $b['cover']; 
                                    if (!empty($b['cover']) && file_exists(FCPATH . $pathFile)): 
                                ?>
                                    <img src="<?= base_url($pathFile) ?>" class="img-cover">
                                <?php else: ?>
                                    <img src="<?= base_url('img/default.jpg') ?>" class="img-cover">
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="fw-bold fs-6 mb-0"><?= esc($b['judul']) ?></div>
                                <small class="text-muted">ID: BUKU-<?= $b['id_buku'] ?></small>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-1 me-2">
                                        <i class="bi bi-person-fill text-primary"></i>
                                    </div>
                                    <?= esc($b['penulis']) ?>
                                </div>
                            </td>

                            <td class="text-center">
                                <span class="badge-stok">
                                    <?= $b['stok'] ?> <small>Buku</small>
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?= base_url('buku/detail/'.$b['id_buku']) ?>" class="btn btn-info btn-action text-white shadow-sm" title="Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    <?php if (session()->get('role') == 'admin') : ?>
                                        <a href="<?= base_url('buku/edit/'.$b['id_buku']) ?>" class="btn btn-warning btn-action text-white shadow-sm" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <a href="<?= base_url('buku/delete/'.$b['id_buku']) ?>" class="btn btn-danger btn-action shadow-sm" onclick="return confirm('Hapus buku ini?')" title="Hapus">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (session()->get('role') == 'user') : ?>
                                        <?php if ($b['stok'] > 0) : ?>
                                            <a href="<?= base_url('pinjam/'.$b['id_buku']) ?>" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm">
                                                <i class="bi bi-box-arrow-in-right me-1"></i> Pinjam
                                            </a>
                                        <?php else : ?>
                                            <span class="badge bg-light text-muted p-2 px-3 rounded-pill">Habis</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="100" class="opacity-25 mb-3">
                                <p class="text-muted fw-bold">Ups! Buku tidak ditemukan.</p>
                                <a href="<?= base_url('buku') ?>" class="btn btn-sm btn-outline-primary rounded-pill">Lihat Semua Buku</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>