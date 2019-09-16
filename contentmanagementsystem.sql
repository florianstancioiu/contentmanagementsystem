-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 16, 2019 at 03:18 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.3.7-2+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `contentmanagementsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_logs`
--

CREATE TABLE `auth_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'log_in, log_out, expired, registered',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drinks`
--

CREATE TABLE `drinks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drinks`
--

INSERT INTO `drinks` (`id`, `title`, `slug`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'A title', 'a-title', '2019-09-16 07:15:28', NULL, NULL),
(2, 'B title', 'b-title', '2019-09-16 07:15:28', NULL, NULL),
(3, 'C title', 'c-title', '2019-09-16 07:15:28', NULL, NULL),
(4, 'D title', 'd-title', '2019-09-16 07:15:28', NULL, NULL),
(5, 'Testoase pe ski jet', 'testoase-la-munte', '2019-09-16 07:15:28', NULL, NULL),
(6, 'Plumb', 'bacovia-e-mort-traiasca-bacovia', '2019-09-16 07:15:28', NULL, NULL),
(7, 'Vreme trece, Vreme vine', 'e-bine-e-bine', '2019-09-16 07:15:28', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_keys`
--

CREATE TABLE `language_keys` (
  `id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_visible` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_links`
--

CREATE TABLE `menu_links` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_visible` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `lang`, `content`, `description`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Home', 'home', 'en', 'This is the freaking homepage', 'work', 1, '2019-08-30 12:51:17', NULL, NULL),
(2, 'Contact', 'contact', 'en', 'bla bla bla', 'bla bla bla', 1, '2019-08-30 13:32:16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `lang`, `content`, `description`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Workhgdf4525', 'work1 adsw', 'en', 'hope1', 'work1', 1, '2019-08-30 12:51:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `display_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trees`
--

CREATE TABLE `trees` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `introduction` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_fruits` int(11) NOT NULL,
  `has_flowers` int(11) NOT NULL,
  `fruit_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `colour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `growth_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ripe_season` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `average_years` int(11) NOT NULL,
  `average_height` int(11) NOT NULL,
  `average_width` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trees`
--

INSERT INTO `trees` (`id`, `title`, `slug`, `introduction`, `description`, `image`, `has_fruits`, `has_flowers`, `fruit_title`, `colour`, `growth_location`, `ripe_season`, `average_years`, `average_height`, `average_width`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'aaa 111  aaa', '42432a', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(3, 'aaa 111  aaa 465465', '424323a', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(5, '46546', '42432234a', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(6, '46546 aaa', '42434532a', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(7, '46546 abdsf', '424324367647a', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(8, '46asdgfd', '4243276657a', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(9, '46as asdasdasd', '4243246546875a', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(10, '46 asdasdasd', 'fghhg', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(11, 'asdasd', '42432ghrtyha', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(12, 'as asdasdasd', '42432hgfhgfh', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(15, 'as asdasdasd', '42432hgfhgfh554', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(16, 'as asdasdasd', '42432hgfhgfh5435', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(23, '46asdgfd', '4243276657ggg', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(24, '46as asdasdasd', '4243246546875ggggsdf', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(25, '46 asdasdasd', 'fghhg45ggregre', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(26, 'as asdasdasd', '42432hgfhgfhsdfsdfds', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(27, 'as asdasdasd', '42432hgfhgfh554ghdgfdg', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL),
(28, 'as asdasdasd', '42432hgfhgfh5435ghfghgfhfgh', 'asdasd', 'dfsgdfgf', 'images/242y241024QBQx5boSp5v22vGiXoeteelPg6ps7l.png', 0, 0, 'dfgfdg', 'dfgdfg', 'dfgdfg', 'dfgfdg', 123, 345, 234, 1, '2019-09-06 13:50:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `first_name`, `last_name`, `email`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Admin', 'User', 'admin@cms.test', '$2y$10$q8isE/BvX7dGBEgwHp.Y6uSCrJSVvNplKLuDc17edPekpMjNVLCbu', '2019-08-30 12:44:21', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vegetables`
--

CREATE TABLE `vegetables` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `introduction` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `growth_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ripe_season` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `average_years` int(11) NOT NULL,
  `average_height` int(11) NOT NULL,
  `average_width` int(11) NOT NULL,
  `has_flowers` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vegetables`
--

INSERT INTO `vegetables` (`id`, `title`, `slug`, `introduction`, `description`, `image`, `colour`, `growth_location`, `ripe_season`, `average_years`, `average_height`, `average_width`, `has_flowers`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test 444 aa', '111 aaa', 'test11aa', 'test11aa', 'images/242y241024Bl2FyUUIuY7BHBAuohy5wkufKjKG38.png', 'testa', 'testa', 'testa', 1234, 1234, 1234, 0, 1, '2019-09-07 12:56:39', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_logs`
--
ALTER TABLE `auth_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drinks`
--
ALTER TABLE `drinks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_keys`
--
ALTER TABLE `language_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_links`
--
ALTER TABLE `menu_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trees`
--
ALTER TABLE `trees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vegetables`
--
ALTER TABLE `vegetables`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_logs`
--
ALTER TABLE `auth_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drinks`
--
ALTER TABLE `drinks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_keys`
--
ALTER TABLE `language_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_links`
--
ALTER TABLE `menu_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trees`
--
ALTER TABLE `trees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vegetables`
--
ALTER TABLE `vegetables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
