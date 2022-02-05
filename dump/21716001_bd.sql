-- phpMyAdmin SQL Dump
-- version 5.0.4deb2
-- https://www.phpmyadmin.net/
--
-- Host: mysql.info.unicaen.fr:3306
-- Generation Time: Nov 14, 2021 at 08:10 PM
-- Server version: 10.5.11-MariaDB-1
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `21716001_bd`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `yourname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `yourname`, `username`, `password`, `status`) VALUES
(1, 'Lecarpentier', 'lecarpentier', '$2y$10$nUx1xnko/KTIWyO4TEg/deiY/6qHGCiB9H7r2iC8SCNoi.B7wDirG', NULL),
(2, 'Vanier', 'vanier', '$2y$10$q2BHtVoZl0aotuUMOR35wucmVM8.K7PJHED.yVKEGrK9w6mCN6kve', NULL),
(3, 'Administrateur', 'admin', '$2y$10$YmDRdFucUcHHWzNjVa9ubupR3l.F.MTflXPjW6EdNjNp4miJtPQ.y', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `account` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`, `type`, `origin`, `image`, `account`) VALUES
(1, 'Phở bò', 'Nouilles, boeuf, légumes, hoisin sauce', 'Plat principal', 'Vietnamien', '61914e2916728pho-g72604c905_1920.jpg', 'vanier'),
(2, 'Pizza', 'Sauce tomate, bacon, fromage, champignons', 'Plat principal', 'Italie', '6191515056cc3food-photographer-david-fedulov.jpg', 'lecarpentier'),
(3, 'Udon', 'Nouilles, boeuf, soupe', 'Plat principal', 'Japon', '61915559becdfudon.jpg', 'admin'),
(4, 'Tiramisu', 'Mascarpone, cacao, gateaux, café', 'Dessert', 'Italie', '619156fd84fc5marianna-ole-tiramisu-unsplash.jpg', 'vanier'),
(5, 'Phá Lấu', 'Abats de boeuf, soupe, pain, sauce nước mắm', 'Plat principal', 'Vietnamien', '61915906dbd59pha-lau-57-308323.jpg', 'lecarpentier');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
