-- phpMyAdmin SQL Dump
-- version 4.4.15.8
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 05, 2016 at 09:18 AM
-- Server version: 5.5.50-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koongkara`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `token`) VALUES
(1, 'admin', '086e1b7e1c12ba37cd473670b3a15214', '');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `code`, `name`) VALUES
(1, 1, 'Chinese'),
(2, 2, 'Cantonese'),
(3, 3, 'Taiwanese'),
(4, 4, 'Spanish'),
(5, 5, 'English'),
(6, 6, 'Janpanese'),
(7, 7, 'Thai'),
(8, 8, 'Russian'),
(9, 9, 'Myanmar'),
(10, 10, 'Indonesia'),
(11, 11, 'Korean'),
(12, 12, 'Vietnamese'),
(13, 13, 'Khmer'),
(14, 14, 'Malay'),
(15, 15, 'Portuguese');

-- --------------------------------------------------------

--
-- Table structure for table `singer_class`
--

CREATE TABLE IF NOT EXISTS `singer_class` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `singer_class`
--

INSERT INTO `singer_class` (`id`, `code`, `name`) VALUES
(1, 1, 'Male'),
(2, 2, 'Female'),
(5, 3, 'Bands');

-- --------------------------------------------------------

--
-- Table structure for table `song`
--

CREATE TABLE IF NOT EXISTS `song` (
  `id` int(11) NOT NULL,
  `url` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `song`
--

INSERT INTO `song` (`id`, `url`) VALUES
(1, 'http://mp3.zing.vn/bai-hat/Dieu-Anh-Biet-Chi-Dan/IWB8OAID.html');

-- --------------------------------------------------------

--
-- Table structure for table `song_meta`
--

CREATE TABLE IF NOT EXISTS `song_meta` (
  `id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `song_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `song_position` int(11) NOT NULL,
  `singer_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `name_count` int(11) NOT NULL,
  `lang_code` int(11) NOT NULL,
  `song_volume` int(11) NOT NULL,
  `name_spell` varchar(100) CHARACTER SET latin1 NOT NULL,
  `song_number` int(11) NOT NULL,
  `singer_spell` varchar(50) CHARACTER SET latin1 NOT NULL,
  `singer_class` int(11) NOT NULL,
  `song_type` int(11) NOT NULL,
  `album_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `album_spell` varchar(100) CHARACTER SET latin1 NOT NULL,
  `singer_photo` varchar(200) CHARACTER SET latin1 NOT NULL,
  `song_lyric` text COLLATE utf8mb4_swedish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumping data for table `song_meta`
--

INSERT INTO `song_meta` (`id`, `song_id`, `song_name`, `song_position`, `singer_name`, `name_count`, `lang_code`, `song_volume`, `name_spell`, `song_number`, `singer_spell`, `singer_class`, `song_type`, `album_name`, `album_spell`, `singer_photo`, `song_lyric`) VALUES
(1, 1, 'Điều anh biết', 0, 'Chi Dân', 3, 12, 0, 'd', 0, 'c', 1, 5, 'Điều anh biết', 'd', '', 'Anh không biết bao nhiêu sao trên trời \nAnh không biết cuộc đời mai ra sao \nDù gian lao dù ra sao thì anh vẫn luôn có \nCó một người luôn bên cạnh anh mãi thôi \nAnh không biết yêu em sao cho vừa \nAnh không biết ngọt ngào hay trăng sao \nTình yêu anh dù không mấy lời nhưng lòng a biết ý nghĩa cuộc đời này khi có em \n(ĐK) \nVà em ơi điều anh biết là Mỗi khi em cười là bao nhiêu phiền lo trong đời biến tan\nVà em ơi điều anh biết là Nỗi nhớ tơi bời mỗi khi em rời xa chốn đây em giận anh');

-- --------------------------------------------------------

--
-- Table structure for table `song_type`
--

CREATE TABLE IF NOT EXISTS `song_type` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `song_type`
--

INSERT INTO `song_type` (`id`, `code`, `name`) VALUES
(16, 1, 'Choral'),
(17, 2, 'Disco/Dance'),
(18, 3, 'Birthday'),
(19, 4, 'Barrack Ballad'),
(20, 5, 'Love songs'),
(21, 6, 'Hymn'),
(22, 7, 'Folk Songs'),
(23, 8, 'Opera'),
(24, 9, 'Special'),
(25, 10, 'Child'),
(26, 11, 'Concert'),
(27, 12, 'MTV'),
(28, 13, 'Military'),
(29, 14, 'MP3/MUSIC'),
(30, 15, 'User songs');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `token`) VALUES
(1, 'user1', 'e10adc3949ba59abbe56e057f20f883e', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_song`
--

CREATE TABLE IF NOT EXISTS `user_song` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_song`
--

INSERT INTO `user_song` (`id`, `user_id`, `song_id`, `status`) VALUES
(1, 1, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `singer_class`
--
ALTER TABLE `singer_class`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `song_meta`
--
ALTER TABLE `song_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `song_id` (`song_id`),
  ADD KEY `lang_code` (`lang_code`),
  ADD KEY `singer_class` (`singer_class`),
  ADD KEY `song_type` (`song_type`);

--
-- Indexes for table `song_type`
--
ALTER TABLE `song_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_song`
--
ALTER TABLE `user_song`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `song_id` (`song_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `singer_class`
--
ALTER TABLE `singer_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `song`
--
ALTER TABLE `song`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `song_meta`
--
ALTER TABLE `song_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `song_type`
--
ALTER TABLE `song_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_song`
--
ALTER TABLE `user_song`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `song_meta`
--
ALTER TABLE `song_meta`
  ADD CONSTRAINT `song_meta_ibfk_1` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`),
  ADD CONSTRAINT `song_meta_ibfk_2` FOREIGN KEY (`lang_code`) REFERENCES `language` (`code`),
  ADD CONSTRAINT `song_meta_ibfk_3` FOREIGN KEY (`singer_class`) REFERENCES `singer_class` (`code`),
  ADD CONSTRAINT `song_meta_ibfk_4` FOREIGN KEY (`song_type`) REFERENCES `song_type` (`code`);

--
-- Constraints for table `user_song`
--
ALTER TABLE `user_song`
  ADD CONSTRAINT `user_song_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`),
  ADD CONSTRAINT `user_song_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
