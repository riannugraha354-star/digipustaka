<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 30px; }
        .header-print { text-align: center; margin-bottom: 30px; border-bottom: 3px double #000; padding-bottom: 10px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header-print">
        <h2>LAPORAN PEMINJAMAN PERPUSTAKAAN</h2>
        <p>Di Aplikasi DigiPustaka</p>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($peminjaman as $p): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $p['nama'] ?></td>
                <td><?= $p['judul'] ?></td>
                <td><?= $p['tanggal_pinjam'] ?></td>
                <td><?= $p['tanggal_kembali'] ?></td>
                <td><?= ucfirst($p['status']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-4 no-print text-end">
        <button onclick="window.print()" class="btn btn-primary">Cetak Laporan</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>

    <script>
        // Otomatis muncul dialog print saat halaman terbuka
        window.onload = function() { window.print(); }
    </script>
</body>
</html>