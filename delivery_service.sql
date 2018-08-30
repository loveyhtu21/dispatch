-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 30, 2018 at 07:47 PM
-- Server version: 5.7.23-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `delivery_service`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_assign_to`
--

CREATE TABLE `order_assign_to` (
  `a_order_id` int(11) NOT NULL,
  `a_pigeon_id` int(11) NOT NULL,
  `a_user_id` int(11) NOT NULL,
  `a_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `a_updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_assign_to`
--

INSERT INTO `order_assign_to` (`a_order_id`, `a_pigeon_id`, `a_user_id`, `a_created_at`, `a_updated_at`) VALUES
(1, 8, 2, '2018-08-29 13:45:57', '0000-00-00 00:00:00'),
(6, 9, 5, '2018-08-30 10:55:08', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pigeon_leave`
--

CREATE TABLE `pigeon_leave` (
  `leave_id` int(11) NOT NULL,
  `l_pigeon_id` int(11) NOT NULL,
  `l_start_date` date NOT NULL,
  `l_end_date` date NOT NULL,
  `leave_type` varchar(100) NOT NULL,
  `l_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `l_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pigeon_record`
--

CREATE TABLE `pigeon_record` (
  `pigeon_id` int(11) NOT NULL,
  `p_user_id` int(11) DEFAULT NULL,
  `pigeon_first_name` varchar(100) NOT NULL,
  `pigeon_last_name` varchar(100) NOT NULL,
  `pigeon_speed` float NOT NULL,
  `pigeon_range` float NOT NULL,
  `pigeon_cost` int(11) NOT NULL,
  `p_max_weight` float NOT NULL,
  `p_downtime` int(11) DEFAULT NULL,
  `p_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `p_updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pigeon_record`
--

INSERT INTO `pigeon_record` (`pigeon_id`, `p_user_id`, `pigeon_first_name`, `pigeon_last_name`, `pigeon_speed`, `pigeon_range`, `pigeon_cost`, `p_max_weight`, `p_downtime`, `p_created_at`, `p_updated_at`) VALUES
(8, 1, 'Antonio', '', 70, 600, 2, 20, 2, '2018-08-30 07:37:21', '0000-00-00 00:00:00'),
(9, 1, 'Carillo', '', 65, 1000, 2, 20, 3, '2018-08-30 06:50:08', '0000-00-00 00:00:00'),
(10, 1, 'Alejandro', '', 70, 800, 2, 20, 2, '2018-08-30 06:50:12', '0000-00-00 00:00:00'),
(11, 1, 'Bonito', '', 80, 500, 2, 20, 3, '2018-08-30 06:50:16', '0000-00-00 00:00:00'),
(13, 1, 'Bonito', '', 80, 500, 2, 20, 3, '2018-08-30 06:54:22', '0000-00-00 00:00:00'),
(14, 1, 'Bonito', '', 80, 500, 2, 20, 3, '2018-08-30 06:58:10', '0000-00-00 00:00:00'),
(15, 1, 'Bonito', '', 80, 500, 2, 20, 3, '2018-08-30 07:00:19', '0000-00-00 00:00:00'),
(16, 1, 'Bonito', '', 80, 500, 2, 20, 3, '2018-08-30 07:11:10', '0000-00-00 00:00:00'),
(17, 1, 'Bonito', '', 80, 500, 2, 20, 3, '2018-08-30 08:09:24', '0000-00-00 00:00:00'),
(18, 1, 'Bonito', '', 80, 500, 13, 20, 3, '2018-08-30 08:14:49', '0000-00-00 00:00:00'),
(19, 1, 'Bonito', '', 80, 500, 13, 20, 3, '2018-08-30 08:16:11', '0000-00-00 00:00:00'),
(20, 1, 'Bonito', '', 80, 500, 2, 20, 3, '2018-08-30 14:09:42', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, '5tLXTO2jgt3QverysAAdKe', 1268889823, 1535635927, 1, 'Admin', 'istrator', 'ADMIN', '0'),
(2, '::1', 'akanksha.ak1292@gmail.com', '$2y$08$wvBnObIPDwlGoPX4AHNS1uWfa0gDSb6t5zAeB4joXV3h6.TeAbplu', NULL, 'akanksha.ak1292@gmail.com', NULL, NULL, NULL, NULL, 1535529118, 1535529493, 1, 'Akanksha', 'Kushwaha', '', ''),
(3, '::1', 'akanksha@gmail.com', '$2y$08$oK9XlrIc0bSPVPLk6X3I8eh/3C4DfIh5QqoXbLECadxmmKiIp7K5O', NULL, 'akanksha@gmail.com', NULL, NULL, NULL, NULL, 1535539069, NULL, 1, 'akanksha', 'kushwaha', NULL, '9876543123'),
(4, '::1', 'akanksha11@gmail.com', '$2y$08$mNH2B6vRK/Pru63HFNdjHOXhYpra4qE9P1doiLI1BWthHSyBLH3wi', NULL, 'akanksha11@gmail.com', NULL, NULL, NULL, NULL, 1535539272, NULL, 1, 'akanksha', 'kushwaha', NULL, '9876543123'),
(21, '::1', 'akanksha1@gmail.com', '$2y$08$ZilM/.9NxkQKkbYmPlYDDeefTL9RwuudDuMBdzzF8BocWq4i34y92', NULL, 'akanksha1@gmail.com', NULL, NULL, NULL, NULL, 1535611595, NULL, 1, 'akanksha', 'kushwaha', NULL, '9876543123'),
(22, '::1', 'akaswsswss@gmail.com', '$2y$08$WrK2woliaJqrymepb1Ef8.ZDjBgdQefx1O6pddVFnrdf3Iko.WpLa', NULL, 'akaswsswss@gmail.com', NULL, NULL, NULL, NULL, 1535635808, NULL, 1, 'akanksha', 'kushwaha', NULL, '9876543123'),
(23, '::1', 'akasswss@gmail.com', '$2y$08$2I7KjJnFRqtcrF1p9HKZI.lWzQZVhCZO09IJMy2I.rmyTfiQnAeIC', NULL, 'akasswss@gmail.com', NULL, NULL, NULL, NULL, 1535635858, NULL, 1, 'akanksha', 'kushwaha', NULL, '9876543123'),
(24, '::1', 'akassws@gmail.com', '$2y$08$sQ.jjJ64vBz.O2k06kEwO.tztB/do1rdTExiZiIsA.Vn.hrVxq5Ju', NULL, 'akassws@gmail.com', NULL, NULL, NULL, NULL, 1535635876, NULL, 1, 'akanksha', 'kushwaha', NULL, '9876543123');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 3, 2),
(5, 4, 2),
(22, 21, 2),
(23, 22, 2),
(24, 23, 2),
(25, 24, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_order`
--

CREATE TABLE `user_order` (
  `order_id` int(11) NOT NULL,
  `o_user_id` int(11) NOT NULL,
  `order_distance` float NOT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `order_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order_updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_order`
--

INSERT INTO `user_order` (`order_id`, `o_user_id`, `order_distance`, `order_date`, `order_time`, `order_status`, `order_created_at`, `order_updated_at`) VALUES
(1, 2, 500, '2018-03-30', '11:00:00', 'pending', '2018-08-29 11:53:56', '0000-00-00 00:00:00'),
(2, 2, 900, '2018-08-31', '11:00:00', 'complete', '2018-08-30 13:14:48', '0000-00-00 00:00:00'),
(3, 2, 500, '2018-03-30', '11:00:00', 'complete', '2018-08-30 12:58:33', '0000-00-00 00:00:00'),
(5, 4, 500, '2018-08-31', '11:00:00', 'accept', '2018-08-30 10:55:08', '0000-00-00 00:00:00'),
(6, 4, 500, '2018-08-31', '11:00:00', 'pending', '2018-08-30 07:41:42', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_assign_to`
--
ALTER TABLE `order_assign_to`
  ADD PRIMARY KEY (`a_order_id`);

--
-- Indexes for table `pigeon_leave`
--
ALTER TABLE `pigeon_leave`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `pigeon_record`
--
ALTER TABLE `pigeon_record`
  ADD PRIMARY KEY (`pigeon_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `user_order`
--
ALTER TABLE `user_order`
  ADD PRIMARY KEY (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `order_assign_to`
--
ALTER TABLE `order_assign_to`
  MODIFY `a_order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `pigeon_leave`
--
ALTER TABLE `pigeon_leave`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pigeon_record`
--
ALTER TABLE `pigeon_record`
  MODIFY `pigeon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `user_order`
--
ALTER TABLE `user_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
