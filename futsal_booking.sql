SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `lapangan` (
  `id` int(11) NOT NULL,
  `nama_lapangan` varchar(100) NOT NULL,
  `jenis_lapangan` varchar(50) DEFAULT NULL,
  `harga_per_jam` int(11) NOT NULL,
  `fasilitas` text DEFAULT NULL,
  `status` varchar(30) DEFAULT 'Tersedia',
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `lapangan` (`id`, `nama_lapangan`, `jenis_lapangan`, `harga_per_jam`, `fasilitas`, `status`, `gambar`) VALUES
(1, 'Lapangan A', 'Vinyl', 100000, 'Ruang ganti, toilet, parkir', 'Tersedia', 'lapangan-a.jpg'),
(2, 'Lapangan B', 'Rumput Sintetis', 120000, 'Toilet, parkir, kantin', 'Tersedia', 'lapangan-b.jpg'),
(3, 'Lapangan C', 'Vinyl', 90000, 'Toilet, parkir', 'Tersedia', 'lapangan-c.jpg');


ALTER TABLE `lapangan`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `lapangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;
