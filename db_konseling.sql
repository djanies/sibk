CREATE TABLE `laporan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_siswa` varchar(255) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `tanggal_kejadian` date NOT NULL,
  `deskripsi` text NOT NULL,
  `nama_guru` varchar(255) NOT NULL,
  `waktu_lapor` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
