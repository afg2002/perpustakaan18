-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 17, 2023 at 09:29 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `role` varchar(50) DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2a$04$0aJLrDDqrs2wnuDvIr55U.4VbzpUd2KAqigB3YSFhMiSItFvfmLHG', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `username`, `password`, `nama`, `alamat`, `email`, `role`) VALUES
(12, 'user', '$2a$04$7.Dx69WfwxVwON5..57P7OzqpPBx9PeRkHwQp8voAIFR.UnyN2vgO', 'Afghan Eka Pangestu', 'BUKIT WARINGIN B 1/15, RT/RW 012/010, Kel/Desa KEDUNGWARINGIN, Kecamatan BOJONG GEDE', 'afghanekapangestu@gmail.com', 'member');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun_terbit` int NOT NULL,
  `sinopsis` text,
  `stok` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `sinopsis`, `stok`) VALUES
(1, 'Harry Potter and the Philosopher\'s Stone ', 'J.K. Rowling', 'Bloomsbury Publishing', 1997, 'Harry Potter dan Batu Bertuah adalah buku pertama dalam seri Harry Potter yang fenomenal. Dalam buku ini, kita diperkenalkan dengan dunia sihir yang penuh petualangan dan misteri.', 217),
(2, 'The Hunger Games', 'Suzanne Collins', 'Scholastic Corporation', 2008, 'The Hunger Games adalah sebuah kompetisi mematikan yang diadakan setiap tahun di Capitol. Dalam buku ini, kita mengikuti perjuangan Katniss Everdeen untuk bertahan hidup dalam Hunger Games.', 5),
(3, 'To Kill a Mockingbird', 'Harper Lee', 'J.B. Lippincott & Co.', 1960, 'To Kill a Mockingbird adalah sebuah kisah yang menggambarkan ketidakadilan rasial di Amerika Serikat pada tahun 1930-an. Buku ini mengikuti perjalanan Scout Finch yang belajar tentang keadilan dan empati.', 12),
(4, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Charles Scribner\'s Sons', 1925, 'The Great Gatsby adalah sebuah kisah tentang ambisi, cinta, dan kehancuran di era Roaring Twenties. Buku ini mengikuti Jay Gatsby dalam usahanya untuk merebut kembali cinta sejatinya, Daisy Buchanan.', 14),
(5, 'Pride and Prejudice', 'Jane Austen', 'T. Egerton, Whitehall', 1813, 'Pride and Prejudice mengisahkan tentang kisah cinta antara Elizabeth Bennet dan Mr. Darcy. Buku ini menggambarkan masyarakat Inggris pada abad ke-19 dan norma-norma yang mengatur pernikahan.', 9),
(6, 'The Lord of the Rings', 'J.R.R. Tolkien', 'George Allen & Unwin', 1954, 'The Lord of the Rings adalah sebuah epik fantasi yang mengisahkan perjalanan Frodo Baggins dan teman-temannya dalam misi untuk menghancurkan Cincin Sauron. Buku ini penuh dengan petualangan, peperangan, dan kekuatan magis.', 7),
(7, 'To Kill a Mockingbird', 'Harper Lee', 'J.B. Lippincott & Co.', 1960, 'To Kill a Mockingbird adalah sebuah kisah yang menggambarkan ketidakadilan rasial di Amerika Serikat pada tahun 1930-an. Buku ini mengikuti perjalanan Scout Finch yang belajar tentang keadilan dan empati.', 12),
(8, 'The Catcher in the Rye', 'J.D. Salinger', 'Little, Brown and Company', 1951, 'The Catcher in the Rye mengisahkan tentang Holden Caulfield, seorang remaja yang mencari makna dalam kehidupan dan menghadapi kebingungan dan ketidakpuasan dalam masyarakat.', 15),
(9, '1984', 'George Orwell', 'Secker & Warburg', 1949, '1984 adalah sebuah distopia yang menggambarkan dunia yang dikuasai oleh pemerintahan totaliter. Buku ini mengangkat tema-tema seperti pengawasan pemerintah, manipulasi informasi, dan kehilangan privasi.', 9),
(10, 'The Hobbit', 'J.R.R. Tolkien', 'George Allen & Unwin', 1937, 'The Hobbit adalah sebuah cerita fantasi yang mengisahkan petualangan Bilbo Baggins dalam misi untuk merebut kembali harta karun yang dicuri oleh naga Smaug. Buku ini merupakan prekuel dari The Lord of the Rings.', 8),
(11, 'Harry Potter and the Chamber of Secrets', 'J.K. Rowling', 'Bloomsbury Publishing', 1998, 'Harry Potter dan Kamar Rahasia adalah buku kedua dalam seri Harry Potter yang mengikuti petualangan Harry dan teman-temannya di Sekolah Sihir Hogwarts.', 12),
(12, 'The Chronicles of Narnia: The Lion, the Witch, and the Wardrobe', 'C.S. Lewis', 'Geoffrey Bles', 1950, 'The Lion, the Witch, and the Wardrobe adalah buku pertama dalam seri The Chronicles of Narnia. Buku ini mengisahkan empat anak yang menemukan pintu ke dunia ajaib Narnia.', 14),
(13, 'Brave New World', 'Aldous Huxley', 'Chatto & Windus', 1932, 'Brave New World adalah sebuah distopia yang menggambarkan masyarakat yang dikendalikan secara total oleh teknologi dan kebahagiaan yang dipaksakan. Buku ini mengangkat tema-tema seperti peran individu dalam masyarakat dan kebebasan.', 100),
(14, 'Jane Eyre', 'Charlotte Brontë', 'Smith, Elder & Co.', 1847, 'Jane Eyre mengisahkan perjalanan seorang wanita muda yang mencari identitas dan cinta sejati. Buku ini mengangkat tema-tema seperti kesetaraan gender dan kemandirian.', 5),
(15, 'The Alchemist', 'Paulo Coelho', 'HarperCollins', 1988, 'The Alchemist mengisahkan perjalanan seorang gembala muda yang mencari harta karun yang tersembunyi. Buku ini mengangkat tema-tema seperti takdir, impian, dan arti hidup.', 4),
(16, 'Moby-Dick', 'Herman Melville', 'Harper & Brothers', 1851, 'Moby-Dick adalah sebuah kisah tentang obsesi seorang kapten kapal penangkap ikan paus untuk memburu paus putih raksasa bernama Moby Dick. Buku ini mengangkat tema-tema seperti kekuatan alam dan obsesi manusia.', 10),
(17, 'The Adventures of Huckleberry Finn', 'Mark Twain', 'Chatto & Windus', 1884, 'The Adventures of Huckleberry Finn mengisahkan petualangan Huckleberry Finn dan Jim, seorang budak yang melarikan diri, di sungai Mississippi. Buku ini mengangkat tema-tema seperti rasisme dan kebebasan.', 10),
(18, 'The Da Vinci Code', 'Dan Brown', 'Doubleday', 2003, 'The Da Vinci Code adalah sebuah thriller misteri yang menggambarkan upaya seorang ahli simbol untuk memecahkan kode rahasia terkait dengan Gereja Katolik. Buku ini mengangkat tema-tema seperti konspirasi dan agama.', 8),
(19, 'The Picture of Dorian Gray', 'Oscar Wilde', 'Lippincott\'s Monthly Magazine', 1890, 'The Picture of Dorian Gray mengisahkan tentang seorang pria yang tidak menua dan terus mempertahankan kecantikannya, sementara lukisan wajahnya yang terkutuk menua dan memperlihatkan dosa-dosanya. Buku ini mengangkat tema-tema seperti keindahan, moralitas, dan dualitas manusia.', 12),
(20, 'The Little Prince', 'Antoine de Saint-Exupéry', 'Reynal & Hitchcock', 1943, 'The Little Prince adalah sebuah kisah tentang seorang pilot yang bertemu dengan seorang anak laki-laki dari planet lain. Buku ini mengajarkan tentang arti persahabatan, kehidupan, dan tanggung jawab.', 15),
(21, 'The Kite Runner', 'Khaled Hosseini', 'Riverhead Books', 2003, 'The Kite Runner mengisahkan tentang persahabatan dan pengkhianatan antara dua anak laki-laki di Afghanistan. Buku ini mengangkat tema-tema seperti keadilan, penebusan, dan trauma perang.The Kite Runner mengisahkan tentang persahabatan dan pengkhianatan antara dua anak laki-laki di Afghanistan. Buku ini mengangkat tema-tema seperti keadilan, penebusan, dan trauma perang.The Kite Runner mengisahkan tentang persahabatan dan pengkhianatan antara dua anak laki-laki di Afghanistan. Buku ini mengangkat tema-tema seperti keadilan, penebusan, dan trauma perang.The Kite Runner mengisahkan tentang persahabatan dan pengkhianatan antara dua anak laki-laki di Afghanistan. Buku ini mengangkat tema-tema seperti keadilan, penebusan, dan trauma perang.The Kite Runner mengisahkan tentang persahabatan dan pengkhianatan antara dua anak laki-laki di Afghanistan. Buku ini mengangkat tema-tema seperti keadilan, penebusan, dan trauma perang.The Kite Runner mengisahkan tentang persahabatan dan pengkhianatan antara dua anak laki-laki di Afghanistan. Buku ini mengangkat tema-tema seperti keadilan, penebusan, dan trauma perang.The Kite Runner mengisahkan tentang persahabatan dan pengkhianatan antara dua anak laki-laki di Afghanistan. Buku ini mengangkat tema-tema seperti keadilan, penebusan, dan trauma perang.The Kite Runner mengisahkan tentang persahabatan dan pengkhianatan antara dua anak laki-laki di Afghanistan. Buku ini mengangkat tema-tema seperti keadilan, penebusan, dan trauma perang.The Kite Runner mengisahkan tentang persahabatan dan pengkhianatan antara dua anak laki-laki di Afghanistan. Buku ini mengangkat tema-tema seperti keadilan, penebusan, dan trauma perang.The Kite Runner mengisahkan tentang persahabatan dan pengkhianatan antara dua anak laki-laki di Afghanistan. Buku ini mengangkat tema-tema seperti keadilan, penebusan, dan trauma perang.', 10);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int NOT NULL,
  `id_buku` int NOT NULL,
  `id_anggota` int NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjaman_ibfk_1` (`id_buku`),
  ADD KEY `peminjaman_ibfk_2` (`id_anggota`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
