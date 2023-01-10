-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jan 2023 pada 12.40
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
(1011, 2, 'nama', 2107411030, 'tempat', '2023-01-01', 'agama', 'Gender', 'alamat', '081232144', 'email@email', 'status', 'instansi', '2023-01-03', 1, 'jabatan', 58, 12312345, 'checked'),
(1013, 1, 'Quenie Salbiyah', 2107411033, 'Pekanbaru', '2023-01-01', 'islam', 'perempuan', 'Jl Mekar Sari', '23423492347', 'a@a', 'Belum Nikah', 'PNJ', '2023-01-04', 1, 'Pratama', 58, 40000, 'checked');

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
(1, 'Quenie', '$2y$10$YZh/ykyd7oYuqEmZnVg6meu/0Jy56doGlxrrjbTSjmt.P6CxwUy.a', 'a@a', 'Quenie', '', '1970-01-01', 'Jl Cobain Dehh', '63bbc57fd0660.png', 'Peserta'),
(2, 'Salbiyah', '$2y$10$kU0aIUOXzEgGrYNHK5ZxJ..Fd078LAf2W1KYQcdPLLW9tlbPHQkx.', 'Salbiyah@gmail.com', 'Quenie Salbiyah', '0812312331', '2011-06-11', 'Jalan Mekar Sari', '', 'Peserta'),
(3, 'Fildzah Marissa', '$2y$10$nEeBAZ3x1tf.gqbeYwzYQOnbehIyYgs8dZ7K9ZuBxCPy36b8grOq.', 'Fildzah@gmail.com', '', '', '1970-01-01', '', '', 'Admin');

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
  MODIFY `np` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1019;

--
-- AUTO_INCREMENT untuk tabel `pelampiran_file`
--
ALTER TABLE `pelampiran_file`
  MODIFY `nf` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
