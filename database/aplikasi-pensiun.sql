-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jan 2023 pada 03.26
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasi-pensiun`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dana`
--

CREATE TABLE `dana` (
  `golongan` int(100) NOT NULL,
  `total_dana` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `dana`
--

INSERT INTO `dana` (`golongan`, `total_dana`) VALUES
(1, 2014900),
(2, 2865000),
(3, 3597800),
(4, 4425900);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_diri`
--

CREATE TABLE `data_diri` (
  `np` int(100) NOT NULL,
  `id_user` int(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` int(100) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `agama` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telp` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status_keluarga` varchar(100) NOT NULL,
  `instansi` varchar(100) NOT NULL,
  `tgl_pegawai` date NOT NULL,
  `golongan` int(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `usia_pensiun` int(100) NOT NULL,
  `iuran_perbulan` int(100) NOT NULL,
  `status_berkas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_diri`
--

INSERT INTO `data_diri` (`np`, `id_user`, `nama`, `nip`, `tempat_lahir`, `tanggal_lahir`, `agama`, `jenis_kelamin`, `alamat`, `no_telp`, `email`, `status_keluarga`, `instansi`, `tgl_pegawai`, `golongan`, `jabatan`, `usia_pensiun`, `iuran_perbulan`, `status_berkas`) VALUES
(1028, 9, 'Cynthia O michael', 210821344, 'Tempat E', '2018-06-11', 'islam', 'laki-laki', 'Alamat E', '081235432', 'Cyn@gmail.com', 'Janda/Duda', 'SMAN 10 Jakarta Timur', '2022-09-04', 4, 'Madya', 58, 300000, 'checked'),
(1030, 11, 'Adi Pratama', 210812334, 'Tempat G', '2017-01-11', 'islam', 'laki-laki', 'Alamat G No.20', '08123453', 'Adi@gmail.com', 'Belum Nikah', 'SMPN 15 Jakarta Utara', '2010-05-11', 3, 'Muda', 58, 300000, 'approve');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelampiran_file`
--

CREATE TABLE `pelampiran_file` (
  `nf` int(100) NOT NULL,
  `id_user` int(100) NOT NULL,
  `skpl` varchar(100) NOT NULL,
  `skcp` varchar(100) NOT NULL,
  `skcltn` varchar(100) NOT NULL,
  `skpi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelampiran_file`
--

INSERT INTO `pelampiran_file` (`nf`, `id_user`, `skpl`, `skcp`, `skcltn`, `skpi`) VALUES
(12, 11, '63be18a01e11d.pdf', '63be18a01eb64.pdf', '63be18a01f7e1.pdf', '63be18a020304.pdf'),
(16, 9, '63c2bd86810b3.pdf', '63c2bd86816d1.pdf', '63c2bd8682052.pdf', '63c2bd8682c13.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_berkas`
--

CREATE TABLE `status_berkas` (
  `id_status` int(11) NOT NULL,
  `status_berkas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `status_berkas`
--

INSERT INTO `status_berkas` (`id_status`, `status_berkas`) VALUES
(1, 'checked'),
(2, 'approve'),
(3, 'refuse');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `no_telp` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `nama`, `no_telp`, `tanggal_lahir`, `alamat`, `foto`, `role`) VALUES
(3, 'Fildzah Marissa', '$2y$10$nEeBAZ3x1tf.gqbeYwzYQOnbehIyYgs8dZ7K9ZuBxCPy36b8grOq.', 'Fildzah@gmail.com', 'Fildzah Marissa', '', '1970-01-01', 'Alamat Test', '63c554c14c35f.png', 'Admin'),
(7, 'Marissa', '$2y$10$bC3KkoeCf.vfJYVwSrgtouf8vTfRr1t0SVlocXiPeV8Vgcmi.Dw9W', 'marissa@gmail.com', NULL, NULL, NULL, NULL, NULL, 'Admin'),
(8, 'Nicholas', '$2y$10$bsLAJpJMlcjHdQbKeKgx7uJRBDzqJSCfYXud/Qml5/7Y2nFJ1v/yS', 'Nicho@gmail.com', NULL, NULL, NULL, NULL, NULL, 'Peserta'),
(9, 'Cynthia', '$2y$10$wSy0c5r5MCHHWBDD7cR8lOv6ht/YJM4YUB780/Yc4FmPJiZMYZI0m', 'cyn@gmail.com', NULL, NULL, NULL, NULL, NULL, 'Peserta'),
(10, 'Quenie', '$2y$10$UWxvrHgUOxXR.1VHouY8qe.3YXxIRmVDRrTvaBCDQg4WO/jYJfSS6', 'Quenie@gmail.com', NULL, NULL, NULL, NULL, NULL, 'Peserta'),
(11, 'Adi', '$2y$10$J8parAU59MzOAoQYlI3M2O.0hzjqtv0oM5H6y3oo.k9RM5EQbouF.', 'Adi@gmail.com', NULL, NULL, NULL, NULL, NULL, 'Peserta'),
(12, 'Rani', '$2y$10$9yt6q7OycBx.Xcju0ltXkuXSlksu2vRCjg1m3fJHMjJjAfJWlgQsS', 'Rani@gmail.com', NULL, NULL, NULL, NULL, NULL, 'Peserta'),
(13, 'Rafi', '$2y$10$MTjvGV0vHdDPu/q8nqO06Ozyw6hn85yf8dew5emvC35jaUN8AXjdy', 'rafi@gmail.com', NULL, NULL, NULL, NULL, NULL, 'Admin'),
(14, 'test', '$2y$10$Tmto8RcSmNUUwKx1ZKLsGuvz5KTSJyLekqXbTZC3hJ1q5//gaWGrO', 'test@gmail.com', NULL, NULL, NULL, NULL, NULL, 'Peserta');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dana`
--
ALTER TABLE `dana`
  ADD UNIQUE KEY `golongan` (`golongan`);

--
-- Indeks untuk tabel `data_diri`
--
ALTER TABLE `data_diri`
  ADD PRIMARY KEY (`np`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pelampiran_file`
--
ALTER TABLE `pelampiran_file`
  ADD PRIMARY KEY (`nf`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `status_berkas`
--
ALTER TABLE `status_berkas`
  ADD PRIMARY KEY (`id_status`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_diri`
--
ALTER TABLE `data_diri`
  MODIFY `np` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1036;

--
-- AUTO_INCREMENT untuk tabel `pelampiran_file`
--
ALTER TABLE `pelampiran_file`
  MODIFY `nf` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `status_berkas`
--
ALTER TABLE `status_berkas`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
