-- Table structure for table `data_nasabah`
--

CREATE TABLE `data_nasabah` (
  `id` int(11) NOT NULL AUTO_INCREMENT, -- Tambahkan AUTO_INCREMENT di sini
  `nama_nasabah` varchar(200) NOT NULL,
  `nama_terenkripsi` text NOT NULL,
  `nama_terdeskripsi` text NOT NULL,
  PRIMARY KEY (`id`) -- Tambahkan PRIMARY KEY untuk kolom `id`
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
