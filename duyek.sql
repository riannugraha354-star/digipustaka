-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Apr 2026 pada 18.01
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `duyek`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `cover` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `penulis`, `penerbit`, `tahun`, `stok`, `cover`) VALUES
(1, 'Laskar Pelangi', 'Andrea Hirata', 'Bentangg', '2005', 92, '1776708785_edc7c472f7998a2a95e1.jpg'),
(2, 'Bumi', 'Tere Liye', 'Gramedia', '2014', 43, '1776710441_ce1407a7cb1e7eec44ce.jpg'),
(3, 'Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia', '2009', 38, '1776710521_9b605140e999c44ffc2d.jpg'),
(4, 'Atomic Habits', 'James Clear', 'Penguin', '2018', 60, '1776710606_647297eed17f5275c9c3.jpg'),
(5, 'Rich Dad Poor Dad', 'Robert Kiyosaki', 'Warner Books', '1997', 24, '1776710737_d872b2dcc6eaf0f395b3.jpg'),
(10, 'Sewu Dino', 'SimpleMan', ' PT Bukune Kreatif Cipta', '2023', 19, '1776710797_6ccd424f84cb0a6fada8.jpg'),
(11, 'Sabtu Bersama Bapak', 'Adhitya Mulya', ' GagasMedia', '2014', 32, '1776710847_e0d281ebe77b34bf2ec0.jpg'),
(15, 'Love You More', 'Keyla Azni', 'Rian nugraha', '2025', 9, '1776841037_da69621a264ddda98d7f.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_pinjam` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('pending','dipinjam','menunggu_kembali','kembali') DEFAULT 'dipinjam',
  `denda` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_pinjam`, `id_user`, `id_buku`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `denda`) VALUES
(1, 2, 6, '2026-04-09', '2026-04-16', '', 0),
(9, 2, 6, '2026-04-09', '2026-04-16', 'dipinjam', 0),
(115, 2, 1, '2026-04-20', '2026-04-27', 'kembali', 0),
(117, 2, 1, '2026-04-20', '2026-04-27', 'kembali', 0),
(123, 2, 3, '2026-04-20', '2026-04-20', 'kembali', 0),
(124, 2, 2, '2026-04-21', '2026-04-21', 'dipinjam', 0),
(125, 2, 4, '2026-04-21', '2026-04-21', 'dipinjam', 0),
(126, 2, 1, '2026-04-21', '2026-04-21', 'dipinjam', 0),
(127, 2, 2, '2026-04-21', '2026-04-24', 'dipinjam', 0),
(128, 2, 4, '2026-04-21', '2026-04-24', 'dipinjam', 0),
(129, 2, 10, '2026-04-21', '2026-04-28', 'dipinjam', 0),
(130, 2, 1, '2026-04-22', '2026-04-29', 'dipinjam', 0),
(131, 2, 15, '2026-04-22', '2026-04-29', 'dipinjam', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `password` varchar(100) NOT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `role`, `password`, `telepon`, `foto`) VALUES
(1, 'duyekadmin', 'duyekadmin', 'admin', '$2y$10$FMQRdH0ecCbZZVWtN2n7/u1YZN/gr7X98Er4NG4sqDAWCXlZwmB6S', NULL, '1776838997_45e3afa3c320c008b270.png'),
(2, 'duyekuser', 'duyekuser', 'user', '$2y$10$YZTlqRLsL6Sd47ghu8xdK.z2FkukMl70S/R98Tq4fwhTlLbx1SDom', NULL, '1776839036_0f9df167a4bae98e3316.png'),
(3, 'rian', 'rian', 'user', '$2y$10$.M9WdIX4RgytGIJ4G.Kf4uojf0Nt8noauUJgw9PI/oaiLIXC7r8vS', NULL, '1776871868_807df28bd00d8fda14cf.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_pinjam`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_pinjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
