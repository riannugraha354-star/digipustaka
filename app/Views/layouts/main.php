<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DigiPustaka | Management System</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

    <style>
        body {
            font-family: "Inter", "Segoe UI", Roboto, Arial, sans-serif;
            background-color: #f0f5fa; /* Warna dasar aplikasi */
            margin: 0;
            display: flex;
        }

        .sidebar {
            width: 240px; /* Sesuai dengan margin dashboard */
            background-color: #ffffff;
            height: 100vh;
            position: fixed; /* Biar sidebar nggak ikut scroll */
            left: 0;
            top: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            z-index: 1000;
            overflow-y: auto;
        }

        .content {
            flex-grow: 1;
            margin-left: 240px; /* Memberi ruang untuk sidebar fixed */
            min-height: 100vh;
            padding: 0; /* Padding diatur di dalam content-wrapper dashboard saja */
            width: calc(100% - 240px);
        }

        /* Hilangkan scrollbar di sidebar untuk tampilan lebih clean */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: #f1f1f1;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -240px; /* Sembunyikan di mobile */
            }
            .content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <nav class="sidebar">
        <?php include(APPPATH . 'Views/layouts/menu.php'); ?>
    </nav>

    <main class="content">
        <?= $this->renderSection('content') ?>
    </main>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>