-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Des 2025 pada 05.07
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_buku`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(150) NOT NULL,
  `penerbit` varchar(150) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `id_kategori`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `harga`, `stok`, `deskripsi`, `gambar`, `created_at`) VALUES
(8, 5, 'rich dad poor dad', 'robert kiyosaki', 'gramedia pustaka utama', 2020, '90000.00', 50, 'literasi keuangan', '7fa7fa2ebd479e221cad55cbe710faf6.jpg', '2025-11-15 08:30:31'),
(9, 1, 'paulo coelho', 'sang alchemist', 'gramedia pustaka utama', 2025, '150000.00', 30, 'novel', '909293f1916157facb5d854d98b4e179.jpeg', '2025-11-15 08:31:19'),
(10, 4, 'filosofi teras', 'henry manampiring', 'gramedia pustaka utama', 2015, '85000.00', 40, 'novel filsuf dunia', '28af5655a1c87360a249a30d78574a55.jpeg', '2025-11-15 08:33:45'),
(11, 3, 'sejarah dunia yang di sembunyikan', 'jonathan black', 'gramedia pustaka utama', 2021, '130000.00', 25, 'buku sejarah dunia yang di sembunyikan oleh elit global', '6d3195aa90098dc6be1bffa5fac1dd0a.jpeg', '2025-11-15 11:39:55'),
(12, 1, 'senja bersama ayah', 'rahayyup', 'gramedia pustaka utama', 2021, '85000.00', 40, 'cerita gadis remaja yang menikmati senja bersama ayahnya', '21d35cb6ae47b4e0bdb3c36033345607.jpeg', '2025-11-17 10:37:55'),
(13, 1, 'naruto', 'masashi kisimoto', 'gramedia pustaka utama', 2010, '50000.00', 100, 'komik anime jepang', '6f11eb4d5fd7f1501edcf1fa1689b336.jpg', '2025-11-17 10:39:12'),
(14, 1, 'perahu kertas', 'dee lestari', 'gramedia pustaka utama', 2025, '125000.00', 50, 'cerita menarik', 'e9e50fa0142b0e4a4e207e5335d6eaae.jpeg', '2025-11-17 10:40:39'),
(15, 1, 'bumi manusia', 'pramudya ananta toer', 'lentera upantara', 2018, '175000.00', 100, 'bumi manusia', 'de86d0fd030f79daefe1808cc09beb1c.jpeg', '2025-11-17 10:43:13'),
(16, 2, 'belajar database mysql', 'irsyad', 'gramedia pustaka utama', 2025, '50000.00', 20, 'belajar mysql pemula', 'd5ea9415890439f3a874b15bd2505119.jpg', '2025-11-17 10:46:23'),
(17, 3, 'bukan 350 tahun di jajah', 'A.B lapian', 'gramedia pustaka utama', 2025, '150000.00', 100, 'berapa lama yang sebenarnya indonesia di jajah ', '2ced1d8dd18ce395fc4f4b3cd40dd721.jpeg', '2025-11-17 10:48:58'),
(18, 3, 'di balik tragedi 1965', 'harry jan silalahi', 'gramedia pustaka utama', 2015, '125000.00', 30, 'ada apa dengan indonesia di balik tahun 1965 ', 'a1086d48dd72a73a126adc80bc5e7f60.jpeg', '2025-11-17 10:52:32'),
(19, 4, 'Retorika', 'irsyad', 'gramedia pustaka utama', 2020, '85000.00', 100, 'retorika aristoteles', '1396a82af8be59e922284da790774237.jpeg', '2025-11-20 02:18:41'),
(20, 5, 'psychology of money', 'morgan housel', 'gramedia pustaka utama', 2021, '100000.00', 100, 'literasi keuangan', '91b87d93b8bd26831abe200c22e18ab2.jpeg', '2025-11-20 02:21:55'),
(21, 5, 'pengantar ekonomi mikro', 'sri rahayu', 'Bentang Pustaka', 2025, '100000.00', 100, 'literasi ekonomi mikro', '87e13a6f3b60a81fb8eee2bcc3da652d.jpeg', '2025-11-20 02:24:21'),
(22, 2, 'bahasa inggris otodidak', 'wahida murriska', 'garda cendekia', 2022, '45000.00', 100, 'jago bahasa inggris otodidak', '89ae602e04242398ad6d936f40919675.jpeg', '2025-11-20 02:27:46'),
(23, 2, 'fisika modern', 'indrawati wilujeng', 'gramedia pustaka utama', 2025, '105000.00', 100, 'belajar fisika di jaman modern', '82ede0e8d0e76b544f9fcbd17dc57906.jpeg', '2025-11-20 02:30:03'),
(24, 2, 'matematika diskrit', 'arif munandar', 'gramedia pustaka utama', 2022, '183000.00', 100, 'matematika diskrit', 'dd5a2166247bdd088feeee1cc4531e92.jpeg', '2025-11-20 02:32:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_buku`, `jumlah`, `harga`, `judul_buku`, `qty`, `harga_satuan`) VALUES
(14, 15, 15, 1, 175000, '', 0, '0.00'),
(15, 15, 17, 1, 150000, '', 0, '0.00'),
(16, 16, 21, 1, 100000, '', 0, '0.00'),
(17, 16, 22, 1, 45000, '', 0, '0.00'),
(18, 16, 23, 1, 105000, '', 0, '0.00'),
(19, 17, 20, 1, 100000, '', 0, '0.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `slug`) VALUES
(1, 'Fiksi', 'fiksi'),
(2, 'Non-Fiksi', 'non-fiksi'),
(3, 'Sejarah', 'sejarah'),
(4, 'Filsafat', 'filsafat'),
(5, 'Bisnis & Keuangan', 'bisnis-keuangan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal_pesan` datetime NOT NULL,
  `batas_bayar` datetime NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `ongkir` int(11) NOT NULL DEFAULT 0,
  `metode_pembayaran` varchar(50) NOT NULL,
  `id_voucher` int(11) DEFAULT NULL,
  `kode_voucher_digunakan` varchar(50) DEFAULT NULL,
  `nilai_diskon_voucher` decimal(10,2) DEFAULT NULL,
  `nama_penerima` varchar(150) NOT NULL,
  `alamat_kirim` text NOT NULL,
  `status_pesanan` enum('Menunggu Pembayaran','Diproses','Dikirim','Selesai','Dibatalkan') NOT NULL DEFAULT 'Menunggu Pembayaran'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `user_id`, `tanggal_pesan`, `batas_bayar`, `total_bayar`, `ongkir`, `metode_pembayaran`, `id_voucher`, `kode_voucher_digunakan`, `nilai_diskon_voucher`, `nama_penerima`, `alamat_kirim`, `status_pesanan`) VALUES
(15, 2, '2025-11-20 03:03:06', '0000-00-00 00:00:00', '330000.00', 15000, 'qris', 1, 'cloudbooks1', '10000.00', 'irsyad', 'karawang', 'Menunggu Pembayaran'),
(16, 1, '2025-11-20 03:42:55', '0000-00-00 00:00:00', '255000.00', 15000, 'qris', 1, 'cloudbooks1', '10000.00', 'irsyad', 'tpr', 'Diproses'),
(17, 1, '2025-12-14 09:30:06', '0000-00-00 00:00:00', '115000.00', 15000, 'qris', NULL, NULL, '0.00', 'doni', 'jakarta', 'Menunggu Pembayaran');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `tgl_daftar` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `nama_lengkap`, `email`, `password`, `role`, `created_at`, `tgl_daftar`) VALUES
(1, 'irsyadul ibad', 'irsyadyhad@gmail.com', '$2y$10$LaXf7/81o.E4Lt9jSs2DiO1qNTzIVDSbinbyw6BEz6n36fSG2Cjke', 'customer', '2025-11-12 07:45:22', '2025-11-17 17:20:47'),
(2, 'admin', 'admin@gmail.com', '$2y$10$Q8RLd5GWnnoGi8UwuVr5fewa9QunkfTPqIQhYtMJG8bGRc28uJaSS', 'admin', '2025-11-12 08:09:39', '2025-11-17 17:20:47'),
(3, 'alex', 'alex@gmail.com', '$2y$10$Z.apEPTFqNW8uM01q6n5Quxh75q1I0qkZtwoqkpt2psWMBA3b1gEm', 'customer', '2025-11-17 10:23:11', '2025-11-17 11:23:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vouchers`
--

CREATE TABLE `vouchers` (
  `id_voucher` int(11) NOT NULL,
  `kode_voucher` varchar(50) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `tipe_diskon` enum('persen','tetap') NOT NULL,
  `nilai_diskon` decimal(10,2) NOT NULL,
  `maks_diskon` decimal(10,2) DEFAULT NULL,
  `min_pembelian` decimal(10,2) NOT NULL DEFAULT 0.00,
  `kuota_global` int(11) NOT NULL,
  `kuota_per_user` int(11) NOT NULL DEFAULT 1,
  `tgl_mulai` datetime NOT NULL,
  `tgl_akhir` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `vouchers`
--

INSERT INTO `vouchers` (`id_voucher`, `kode_voucher`, `deskripsi`, `tipe_diskon`, `nilai_diskon`, `maks_diskon`, `min_pembelian`, `kuota_global`, `kuota_per_user`, `tgl_mulai`, `tgl_akhir`, `is_active`, `created_at`) VALUES
(1, 'cloudbooks1', 'voucher opening', 'persen', '10.00', '10000.00', '150000.00', 50, 2, '2025-11-15 12:18:00', '2025-12-15 12:18:00', 1, '2025-11-15 18:20:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `voucher_usage`
--

CREATE TABLE `voucher_usage` (
  `id` int(11) NOT NULL,
  `id_voucher` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `used_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `voucher_usage`
--

INSERT INTO `voucher_usage` (`id`, `id_voucher`, `user_id`, `id_pesanan`, `used_at`) VALUES
(1, 1, 2, 15, '2025-11-20 09:03:06'),
(2, 1, 1, 16, '2025-11-20 09:42:55');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `fk_buku_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `fk_detail_pesanan_idx` (`id_pesanan`),
  ADD KEY `fk_detail_buku_idx` (`id_buku`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `fk_user_idx` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id_voucher`),
  ADD UNIQUE KEY `kode_voucher` (`kode_voucher`);

--
-- Indeks untuk tabel `voucher_usage`
--
ALTER TABLE `voucher_usage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_voucher` (`id_voucher`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id_voucher` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `voucher_usage`
--
ALTER TABLE `voucher_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `fk_buku_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `fk_detail_buku` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `fk_detail_pesanan` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`);

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_user_pesanan` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `voucher_usage`
--
ALTER TABLE `voucher_usage`
  ADD CONSTRAINT `voucher_usage_ibfk_1` FOREIGN KEY (`id_voucher`) REFERENCES `vouchers` (`id_voucher`),
  ADD CONSTRAINT `voucher_usage_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
