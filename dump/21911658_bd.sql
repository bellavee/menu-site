-- phpMyAdmin SQL Dump
-- version 5.0.4deb2
-- https://www.phpmyadmin.net/
--
-- Host: mysql.info.unicaen.fr:3306
-- Generation Time: Nov 14, 2021 at 07:49 PM
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
-- Database: `21911658_bd`
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
(3, 'Administrateur', 'admin', '$2y$10$1NbmWLeRreec2TVs0BMzhe3kyTQPB3cqPZNubXcaDMyRSGY96tmpS', 'admin'),
(4, 'Vanier', 'vanier', '$2y$10$J3rMuLkFaCrgn2.wWItPj.rshBUacw6lg3ijcDejyopigdYhQdM0m', NULL),
(5, 'Lecarpentier', 'lecarpentier', '$2y$10$fkByrR1UJfOaKdn4e.9LFe3y//yitabOnO7ypJ6ZdjKpA1IKx047K', NULL);

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
(1, 'Phở bò', 'Nouilles, boeuf, légumes, hoisin sauce', 'Plat principal', 'Vietnamien', '61914e260aa4dpho-g72604c905_1920.jpg', 'vanier'),
(2, 'Pizza', 'Sauce tomate, bacon, fromage, champignons', 'Plat principal', 'Italie', '6191545b42acafood-photographer-david-fedulov.jpg', 'lecarpentier'),
(3, 'Udon', 'Nouilles, boeuf, soupe', 'Plat principal', 'Japon', '6191555619d68udon.jpg', 'admin'),
(4, 'Tiramisu', 'Mascarpone, cacao, gateaux, café', 'Dessert', 'Italie', '619156e97d994marianna-ole-tiramisu-unsplash.jpg', 'vanier'),
(5, 'Phá Lấu', 'Abats de boeuf, soupe, pain, sauce nước mắm', 'Plat principal', 'Vietnamien', '619158f677c9dpha-lau-57-308323.jpg', 'lecarpentier');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
