-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jan 2025 pada 04.09
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
-- Database: `sampah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `IdAdmin` varchar(6) NOT NULL,
  `namaAdmin` varchar(30) NOT NULL,
  `usernameAdmin` varchar(20) NOT NULL,
  `passwordAdmin` varchar(20) NOT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`IdAdmin`, `namaAdmin`, `usernameAdmin`, `passwordAdmin`, `level`) VALUES
('ADM001', 'Admin 1', 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `idBerita` varchar(6) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `sumber` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`idBerita`, `judul`, `isi`, `gambar`, `sumber`) VALUES
('BRT001', 'Cara Mengelola Sampah Rumah Tangga dengan Mudah', 'Masih banyak masyarakat di sekitar kita yang membakar sampah plastik bersamaan dengan jenis sampah lainnya. Namun sebenarnya ini tidak aman bagi kesehatan dan lingkungan di sekitar karena menghasilkan asap putih beracun. Karena itulah Anda sebaiknya mengetahui cara mengelola sampah rumah tangga.', '67872b3a71fcd.jpg', 'https://www.cnnindonesia.com/gaya-hidup/20190911112043-284-429492/cara-mengelola-sampah-rumah-tangga-dengan-mudah'),
('BRT002', 'Jenis Sampah yang Harus Diketahui, Bisa Bantu Atasi Pencemaran Lingkungan', 'Masih ingatkah kamu pada November 2018, seekor paus sperma (Physeter macrocephalus) ditemukan warga terdampar di sekitar Pulau Kapota, Kabupaten Wakatobi, Sulawesi Tenggara. Paus sepanjang 9,5 meter dan memiliki lebar 1,85 meter itu ditemukan dalam kondisi dikelilingi sampah plastik dan potongan-potongan kayu.', '60c0d65de0730.jpg', 'https://www.liputan6.com/citizen6/read/3920824/jenis-sampah-yang-harus-diketahui-bisa-bantu-atasi-pencemaran-lingkungan'),
('BRT003', 'Begini Cara Siasati Mahalnya Biaya Daur Ulang Sampah', 'Cara terbaik pengolahan sampah tak lain adalah didaur ulang untuk dijadikan bahan olahan yang memiliki nilai ekonomi lebih tinggi seperti pupuk, perkakas rumah tangga hingga bahan bakar.', '60c0d68a0f8c9.jpeg', 'https://finance.detik.com/industri/d-5571337/begini-cara-siasati-mahalnya-biaya-daur-ulang-sampah?_ga=2.190545323.1631923535.1623248634-1587519274.1622629293'),
('BRT004', 'Indonesia - Finlandia bahas kerjasama pengelolaan sampah menjadi energi', 'Pengolahan sampah menjadi energi dengan menggunakan proses termal semakin populer sebagai teknologi alternatif untuk pengolahan sampah di dunia. Sebagai salah satu negara pemilik teknologi mengubah sampah menjadi energi, Finlandia menawarkan kerjasama kepada Indonesia. Hal tersebut disampaikan Menteri Perekonomian dan Tenaga Kerja Finlandia, H.E. Mika Lintilä saat bertemu Menteri Lingkungan Hidup dan Kehutanan Indonesia Siti Nurbaya di Jakarta, Selasa (06/06/2017).', '60c0d6ac6d9f3.jpg', 'https://sipsn.menlhk.go.id/sipsn/baca/5');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penarikan`
--

CREATE TABLE `penarikan` (
  `idTarik` varchar(6) NOT NULL,
  `idUser` varchar(6) NOT NULL,
  `namaUser` varchar(30) NOT NULL,
  `tglTarik` date NOT NULL,
  `jmlPenarikan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penarikan`
--

INSERT INTO `penarikan` (`idTarik`, `idUser`, `namaUser`, `tglTarik`, `jmlPenarikan`) VALUES
('TRK001', 'USR001', 'Achmad Farid Alfa Waid', '2025-01-15', 25000),
('TRK002', 'USR004', 'Maudy Ayunda', '2025-01-16', 90000),
('TRK003', 'USR002', 'Ilma Dina Nur Rosidah', '2025-01-16', 9000),
('TRK004', 'USR004', 'Maudy Ayunda', '2025-01-15', 200000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `idJual` varchar(6) NOT NULL,
  `idSampah` varchar(6) NOT NULL,
  `berat` varchar(15) NOT NULL,
  `tglPenjualan` date NOT NULL,
  `namaPembeli` varchar(30) NOT NULL,
  `nomorPembeli` varchar(13) NOT NULL,
  `harga` int(11) NOT NULL,
  `totalPendapatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`idJual`, `idSampah`, `berat`, `tglPenjualan`, `namaPembeli`, `nomorPembeli`, `harga`, `totalPendapatan`) VALUES
('JUL001', 'SMP011', '10', '2025-01-13', 'Hendro Wirasta', '0123941023470', 6000, 60000),
('JUL002', 'SMP014', '20', '2025-01-12', 'Akram Asyam Mukarim Jayadi', '0123984019324', 12000, 240000),
('JUL003', 'SMP007', '39', '2025-01-15', 'Aco', '09234853425', 2000, 78000),
('JUL004', 'SMP001', '6', '2025-01-17', 'Anto', '98723456234', 1000, 6000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `saldo_bank`
--

CREATE TABLE `saldo_bank` (
  `idTransaksi` varchar(6) NOT NULL,
  `aksi` enum('Penambahan','Pengurangan','','') NOT NULL,
  `tanggal` date NOT NULL,
  `aktor` varchar(6) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `totalSaldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `saldo_bank`
--

INSERT INTO `saldo_bank` (`idTransaksi`, `aksi`, `tanggal`, `aktor`, `jumlah`, `totalSaldo`) VALUES
('SLD001', 'Penambahan', '2021-12-17', 'ADM001', 400000, 400000),
('SLD002', 'Penambahan', '2021-12-17', 'ADM001', 15000, 415000),
('SLD003', 'Pengurangan', '2021-12-17', 'USR002', 5000, 410000),
('SLD004', 'Penambahan', '2024-11-27', 'ADM001', 4000, 409000),
('SLD005', 'Pengurangan', '2024-07-10', 'USR004', 20000, 389000),
('SLD006', 'Pengurangan', '2025-01-10', 'USR002', 5000, 384000),
('SLD007', '', '2021-12-17', 'ADM001', 389000, 389000),
('SLD008', 'Penambahan', '2021-12-17', 'ADM001', 5000, 394000),
('SLD009', 'Penambahan', '2024-07-10', 'ADM001', 20000, 414000),
('SLD010', 'Penambahan', '2025-01-10', 'ADM001', 5000, 419000),
('SLD011', 'Pengurangan', '2021-12-17', 'ADM001', 400000, 19000),
('SLD012', 'Pengurangan', '2021-12-17', 'ADM001', 15000, 4000),
('SLD013', 'Pengurangan', '2024-11-27', 'ADM001', 4000, 0),
('SLD014', 'Penambahan', '2025-01-13', 'ADM001', 30000, 30000),
('SLD015', 'Pengurangan', '2025-01-14', 'USR002', 10000, 20000),
('SLD016', 'Penambahan', '2025-01-12', 'ADM001', 120000, 140000),
('SLD017', 'Pengurangan', '2025-01-11', 'USR004', 60000, 80000),
('SLD018', '', '2025-01-12', 'ADM001', 200000, 200000),
('SLD019', 'Pengurangan', '2025-02-07', 'USR004', 40000, 160000),
('SLD020', '', '2025-01-13', 'ADM001', 190000, 190000),
('SLD021', 'Pengurangan', '2025-01-15', 'USR004', 100000, 90000),
('SLD022', 'Penambahan', '2025-02-07', 'ADM001', 40000, 130000),
('SLD023', 'Penambahan', '2025-01-14', 'ADM001', 10000, 140000),
('SLD024', 'Penambahan', '2025-01-11', 'ADM001', 60000, 200000),
('SLD025', 'Penambahan', '2025-01-15', 'ADM001', 100000, 300000),
('SLD026', 'Pengurangan', '2025-01-15', 'USR001', 25000, 275000),
('SLD027', 'Pengurangan', '2025-01-16', 'USR004', 90000, 190000),
('SLD028', '', '2025-01-16', 'ADM001', 190000, 190000),
('SLD029', 'Penambahan', '2025-01-15', 'ADM001', 78000, 268000),
('SLD030', '', '2025-01-15', 'ADM001', 263000, 263000),
('SLD031', 'Penambahan', '2025-01-17', 'ADM001', 6000, 269000),
('SLD032', 'Pengurangan', '2025-01-16', 'USR002', 9000, 260000),
('SLD033', 'Pengurangan', '2025-01-15', 'USR004', 200000, 60000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sampah`
--

CREATE TABLE `sampah` (
  `idSampah` varchar(6) NOT NULL,
  `jenisSampah` varchar(15) NOT NULL,
  `namaSampah` varchar(30) NOT NULL,
  `satuan` varchar(5) NOT NULL,
  `harga` int(11) NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `deskripsi` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sampah`
--

INSERT INTO `sampah` (`idSampah`, `jenisSampah`, `namaSampah`, `satuan`, `harga`, `gambar`, `deskripsi`) VALUES
('SMP001', 'Anorganik', 'Kresek', 'KG', 200, '60d468d995875.jpg', 'Semua jenis kresek (warna apapun)'),
('SMP002', 'Anorganik', 'Plastik', 'KG', 600, '60c0a74d10227.jpg', 'Semua jenis plastik'),
('SMP003', 'Anorganik', 'Karah warna', 'KG', 600, '60c0a75ce594a.jpg', 'Yang dapat dikumpulkan seperti sampah bekas shampoo, sabun, handbody, dll.'),
('SMP004', 'Anorganik', 'botol mineral plastik', 'KG', 1500, '60c0a6224066b.jpg', 'Semua jenis botol plastik yang berbahan plastik.'),
('SMP005', 'Anorganik', 'Botol mineral kaca', 'KG', 200, '60c0a77d59f11.jpg', 'Semua jenis botol yang berbahan kaca.'),
('SMP006', 'Anorganik', 'Gelas mineral plastik', 'KG', 1500, '60c0a7992a1af.jpg', 'Semua jenis gelas mineral yang berbahan plastik.'),
('SMP007', 'Anorganik', 'Kaleng', 'KG', 600, '60c0a7a9ce00e.jpg', 'Semua jenis kaleng.'),
('SMP008', 'Anorganik', 'Kardus/Karton', 'KG', 1100, '60c0a7bcdf002.jpg', 'Semua jenis kardus/karton.'),
('SMP009', 'Organik', 'Dedaunan', 'KG', 100, '60c0a7c765fee.jpg', 'Semua jenis dedaunan yang nantinya dapat diolah menjadi pupuk.'),
('SMP010', 'Organik', 'Sampah hasil masak', 'KG', 50, '60c0a7d21f406.jpeg', 'Semua sampah sisa hasil masak dapat dikumpulkan.'),
('SMP011', 'Anorganik', 'Besi', 'KG', 1000, '60c0a7e0df741.jpg', 'Semua jenis besi.'),
('SMP012', 'Anorganik', 'Baja', 'KG', 1500, '60c0a7f2891ef.jfif', 'Semua jenis baja.'),
('SMP013', 'Anorganik', 'Tembaga', 'KG', 45000, '60c0a801c1069.jpg', 'Semua jenis tembaga.'),
('SMP014', 'Anorganik', 'Aluminium', 'KG', 7000, '60c0a80e7a6cb.jpg', 'Semua jenis aluminium.'),
('SMP015', 'Anorganik', 'Zeng', 'KG', 250, '60c0a8236ab5a.png', 'Semua jenis zeng.'),
('SMP016', 'Anorganik', 'Kain', 'KG', 200, '60c0a8309477f.jpg', 'Semua jenis kain.'),
('SMP017', 'Anorganik', 'Sandal dan Sepatu', 'KG', 85, '60c0a8411719a.jpg', 'Semua jenis dan merek sandal sepatu.'),
('SMP018', 'Anorganik', 'Lampu', 'KG', 100, '60c0a84f6efcf.jpg', 'Semua jenis lampu.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `setoran`
--

CREATE TABLE `setoran` (
  `idSetor` varchar(6) NOT NULL,
  `idUser` varchar(6) NOT NULL,
  `idSampah` varchar(6) NOT NULL,
  `tglSetor` date NOT NULL,
  `berat` varchar(15) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `setoran`
--

INSERT INTO `setoran` (`idSetor`, `idUser`, `idSampah`, `tglSetor`, `berat`, `total`) VALUES
('STR001', 'USR001', 'SMP001', '2025-01-11', '8', 1600),
('STR002', 'USR002', 'SMP011', '2025-01-12', '9', 9000),
('STR003', 'USR004', 'SMP014', '2025-01-13', '23', 161000),
('STR004', 'USR004', 'SMP013', '2025-01-28', '5', 225000),
('STR005', 'USR001', 'SMP017', '2025-01-14', '23', 1955),
('STR006', 'USR001', 'SMP007', '2025-01-15', '40', 24000),
('STR007', 'USR006', 'SMP011', '2025-01-13', '30', 30000),
('STR008', 'USR003', 'SMP005', '2025-01-15', '20', 4000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock_sampah`
--

CREATE TABLE `stock_sampah` (
  `idStock` varchar(6) NOT NULL,
  `namaSampah` varchar(30) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `stock_sampah`
--

INSERT INTO `stock_sampah` (`idStock`, `namaSampah`, `stock`) VALUES
('STK001', 'Kresek', 2),
('STK002', 'Plastik', 0),
('STK003', 'Karah warna', 0),
('STK004', 'botol mineral plastik', 0),
('STK005', 'Botol mineral kaca', 20),
('STK006', 'Gelas mineral plastik', 0),
('STK007', 'Kaleng', 1),
('STK008', 'Kardus/Karton', 0),
('STK009', 'Dedaunan', 0),
('STK010', 'Sampah hasil masak', 0),
('STK011', 'Besi', 29),
('STK012', 'Baja', 0),
('STK013', 'Tembaga', 5),
('STK014', 'Aluminium', 3),
('STK015', 'Zeng', 0),
('STK016', 'Kain', 0),
('STK017', 'Sandal dan Sepatu', 23),
('STK018', 'Lampu', 0),
('STK019', 'testing', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `idUser` varchar(6) NOT NULL,
  `namaUser` varchar(30) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `ket` varchar(200) NOT NULL,
  `telepon` varchar(13) NOT NULL,
  `username` varchar(20) NOT NULL,
  `passwordUser` varchar(20) NOT NULL,
  `jmlSetoran` int(11) NOT NULL,
  `jmlPenarikan` int(11) NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`idUser`, `namaUser`, `gambar`, `nik`, `alamat`, `ket`, `telepon`, `username`, `passwordUser`, `jmlSetoran`, `jmlPenarikan`, `saldo`) VALUES
('USR001', 'Achmad Farid Alfa Waid', '&lt;br /&gt;\r\n&lt;b&gt;Warning&lt;/b&gt;:  Undefined variable $data in &lt;b&gt;C:xampphtdocswastephp-main_Rev-003wastephp-maineditpengguna.php&lt;/b&gt; on line &lt;b&gt;56&lt;/b&gt;&lt;br /&gt;\r\n&lt;br /&gt;\r\n&lt;b&gt;Warning&lt;/b&gt;:  Trying to acces', '3515012608010001', 'Sidoarjo, Jawa Timur , Indonesia', 'ada', '0895339390517', 'farid', '12345678', 3, 1, 2555),
('USR002', 'Ilma Dina Nur Rosidah', '&lt;br /&gt;\r\n&lt;b&gt;Warning&lt;/b&gt;:  Undefined variable $data in &lt;b&gt;C:xampphtdocswastephp-main_Rev-003wastephp-maineditpengguna.php&lt;/b&gt; on line &lt;b&gt;56&lt;/b&gt;&lt;br /&gt;\r\n&lt;br /&gt;\r\n&lt;b&gt;Warning&lt;/b&gt;:  Trying to acces', '111222333444', 'Pilang', 'ada', '08536955889', 'dina', '12345', 1, 1, 0),
('USR003', 'apakjr', '', '000000001', 'lengkong, mojokerto', '', '089533', 'apak', 'apak', 1, 0, 4000),
('USR004', 'Maudy Ayunda', '6782c8069dee4.jpg', '3515012608010002', 'Pilang, Mliriprowo', '', '085788988012', 'maudy', 'maudy', 2, 2, 96000),
('USR005', 'Muhammad Zulfan Fahmi oke', '&lt;br /&gt;\r\n&lt;b&gt;Warning&lt;/b&gt;:  Undefined variable $data in &lt;b&gt;C:xampphtdocswastephp-main_Rev-003wastephp-maineditpengguna.php&lt;/b&gt; on line &lt;b&gt;56&lt;/b&gt;&lt;br /&gt;\r\n&lt;br /&gt;\r\n&lt;b&gt;Warning&lt;/b&gt;:  Trying to acces', '3515012608010005', 'Dsn. Mlaten, Ds. Mliriprowo, RT.04/RW.03, Kec. Tarik, Kab. Sidoarjo', 'ada', '085365955055', 'zulfan', 'zulfan', 0, 0, 0),
('USR006', 'Achmad Rehan', '&lt;br /&gt;\r\n&lt;b&gt;Warning&lt;/b&gt;:  Undefined variable $data in &lt;b&gt;C:xampphtdocswastephp-main_Rev-003wastephp-maineditpengguna.php&lt;/b&gt; on line &lt;b&gt;56&lt;/b&gt;&lt;br /&gt;\r\n&lt;br /&gt;\r\n&lt;b&gt;Warning&lt;/b&gt;:  Trying to acces', '351501260801098', 'Dsn. Pilang, Ds. Mliriprowo, Kec. Tarik', '', '0895339390897', 'faridwaid', 'faridwaid', 1, 0, 30000);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`IdAdmin`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`idBerita`);

--
-- Indeks untuk tabel `penarikan`
--
ALTER TABLE `penarikan`
  ADD PRIMARY KEY (`idTarik`),
  ADD KEY `idUser` (`idUser`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`idJual`),
  ADD KEY `idSampah` (`idSampah`);

--
-- Indeks untuk tabel `saldo_bank`
--
ALTER TABLE `saldo_bank`
  ADD PRIMARY KEY (`idTransaksi`);

--
-- Indeks untuk tabel `sampah`
--
ALTER TABLE `sampah`
  ADD PRIMARY KEY (`idSampah`);

--
-- Indeks untuk tabel `setoran`
--
ALTER TABLE `setoran`
  ADD PRIMARY KEY (`idSetor`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idSampah` (`idSampah`);

--
-- Indeks untuk tabel `stock_sampah`
--
ALTER TABLE `stock_sampah`
  ADD PRIMARY KEY (`idStock`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `penarikan`
--
ALTER TABLE `penarikan`
  ADD CONSTRAINT `idUser` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`idSampah`) REFERENCES `sampah` (`idSampah`);

--
-- Ketidakleluasaan untuk tabel `setoran`
--
ALTER TABLE `setoran`
  ADD CONSTRAINT `setoran_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`),
  ADD CONSTRAINT `setoran_ibfk_2` FOREIGN KEY (`idSampah`) REFERENCES `sampah` (`idSampah`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
