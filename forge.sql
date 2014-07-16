-- phpMyAdmin SQL Dump
-- version 4.2.0
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2014 at 10:30 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `forge`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

USE forge;

CREATE TABLE IF NOT EXISTS `events` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hosted_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `start_time`, `end_time`, `location`, `created_by`, `hosted_by`, `event_type`, `description`, `is_private`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Pint Night at Pazzos!', '2014-07-07 18:15:40', '2014-07-07 18:15:40', 'demo lat-log', 'John Smith', 'Pazzos Pizza Pub', 'Promotion Drinking Event', ' Serving the best hand-tossed pizza in Lexington and the largest draft selection in Central Kentucky! 47 Beers On Draught!', 0, NULL, '2014-07-07 22:15:40', '2014-07-07 22:15:40'),
(2, '5Across', '2014-07-07 18:15:40', '2014-07-07 18:15:40', 'demo lat-log', 'Nick Such', 'Awesome Inc', 'Competition', '5 Across is an informal gathering of entrepreneurs, investors, and service providers from Lexington, KY. Each 5 Across meeting features presentations from local entrepreneurs who pitch their ideas to a panel of judges.', 0, NULL, '2014-07-07 22:15:40', '2014-07-07 22:15:40'),
(3, 'Test', '2014-07-07 18:15:40', '2014-07-07 18:15:40', 'eLink Design', 'admin', '', '', 'A brief Description', 0, NULL, '2014-07-08 21:26:27', '2014-07-08 21:26:27'),
(4, 'Lane''s Pity Party', '2014-07-07 18:15:40', '2014-07-07 18:15:40', 'His desk', 'admin', '', '', 'After not receiving his computer parts...he is going to have a pity party', 0, NULL, '2014-07-08 21:27:14', '2014-07-08 21:27:14');

-- --------------------------------------------------------

--
-- Table structure for table `events-tags-relation`
--

CREATE TABLE IF NOT EXISTS `events-tags-relation` (
  `event_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_06_29_043350_setup_users_table', 1),
('2014_06_29_043439_create_events_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reminders`
--

CREATE TABLE IF NOT EXISTS `password_reminders` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
`id` int(10) unsigned NOT NULL,
  `tag_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmation_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isconfirmed` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `confirmation_code`, `remember_token`, `isconfirmed`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@example.org', '$2y$10$/B/EfCsZBRJJWURRmMLU1OK2oVkmuMqeOJYKoKZBmUH1gFIWdFVDG', '425bbc6192cd67e7ccf8a31bae0ed713', 'FVet9ELc5mQ2UsFuSVB9oeSFkhQeC80XTX27WoEHa2xMefcqIoh2fy0f3yk1', 1, NULL, '2014-07-07 22:15:40', '2014-07-08 21:30:01'),
(2, 'user', 'user@example.org', '$2y$10$FEnKIJeVWoekP9XgZKaK1OYFm/QmHvIifNbrbblayj.rbjFdUQSpu', '0adf2093b4711741baddbad399da6166', NULL, 1, NULL, '2014-07-07 22:15:40', '2014-07-07 22:15:40');

-- --------------------------------------------------------

--
-- Table structure for table `users_social_keys`
--

CREATE TABLE IF NOT EXISTS `users_social_keys` (
  `user_id` int(10) unsigned NOT NULL,
  `fb_userkey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fb_secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tw_userkey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tw_secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `In_userkey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `In_secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events-tags-relation`
--
ALTER TABLE `events-tags-relation`
 ADD KEY `events_tags_relation_event_id_index` (`event_id`), ADD KEY `events_tags_relation_tag_id_index` (`tag_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_social_keys`
--
ALTER TABLE `users_social_keys`
 ADD KEY `users_social_keys_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `events-tags-relation`
--
ALTER TABLE `events-tags-relation`
ADD CONSTRAINT `events_tags_relation_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `events_tags_relation_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_social_keys`
--
ALTER TABLE `users_social_keys`
ADD CONSTRAINT `users_social_keys_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
