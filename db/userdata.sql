-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2024 at 08:55 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `userdata`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(20) NOT NULL,
  `mobilenum` varchar(15) NOT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `mobilenum`, `photo`) VALUES
(19, 'goody', 'goo@gmail.com', '09087642632', '5c99888593222cbf2f3f8701db5ff7eb.jpg'),
(20, 'basil tab', 'basil@gmail.com', '09077645382', '9f7f8eeb27c2f72ac874965536df1070.jpg'),
(21, 'teddy', 'bear@gmail.com', '00805555864', '1692891acfc2f54959231084993eb0e2.jpg'),
(22, 'emma', 'west@gmail.com', '07012365478', 'fc60c2d3e1e661d7f23fea908222752f.jpg'),
(23, 'lilian', 'lily@gmail.com', '09187653485', '5710f1fd7637ed643dcac5991487c776.jpg'),
(24, 'loml', 'loml@yahoo.com', '11111111112', '0e6075ec130772fd2c5cb206505c0afe.jpg'),
(26, 'kemi', 'kemi@gmail.com', '22119384758', 'b36401ef48f3b30cadd7151400fd618c.jpg'),
(31, 'praise', 'praise@gmail.com', '09066605427', '257777429e24568785063e696d09355b.jpg'),
(33, 'felix', 'felix@gmail.com', '22345678294', 'c0ef0a62f94469357b6a5ef718b667dc.jpg'),
(41, 'tobi', 'tobi@gmail.com', '09764862522', 'd67d4c4fb9756db07e4710c3cdc0a1b9.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
