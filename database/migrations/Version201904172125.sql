-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 17, 2019 at 09:32 PM
-- Server version: 10.2.22-MariaDB-cll-lve
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u28492p22384_teach`
--

-- --------------------------------------------------------

--
-- Table structure for table `contactmoment`
--

CREATE TABLE `contactmoment` (
  `id` int(11) NOT NULL,
  `les_id` int(11) NOT NULL,
  `starttijd` datetime NOT NULL,
  `eindtijd` datetime NOT NULL,
  `ruimte` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ical_uid` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `owner` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `contactmoment_module`
-- (See below for the actual view)
--
CREATE TABLE `contactmoment_module` (
`modulenaam` varchar(10)
,`kalenderweek` varchar(2)
,`blokweek` varchar(2)
,`id` int(11)
,`les_id` int(11)
,`starttijd` datetime
,`eindtijd` datetime
,`ruimte` text
,`ical_uid` varchar(250)
,`created_at` datetime
,`updated_at` datetime
,`owner` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `contactmoment_toekomst_geimporteerd_verleden`
-- (See below for the actual view)
--
CREATE TABLE `contactmoment_toekomst_geimporteerd_verleden` (
`id` int(11)
,`les_id` int(11)
,`starttijd` datetime
,`eindtijd` datetime
,`ruimte` text
,`ical_uid` varchar(250)
,`created_at` datetime
,`updated_at` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `contactmoment_vandaag`
-- (See below for the actual view)
--
CREATE TABLE `contactmoment_vandaag` (
`kalenderweek` varchar(2)
,`blokweek` varchar(2)
,`modulenaam` varchar(10)
,`id` int(11)
,`les_id` int(11)
,`starttijd` datetime
,`eindtijd` datetime
,`ruimte` text
,`ical_uid` varchar(250)
,`created_at` datetime
,`updated_at` datetime
,`owner` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `les`
--

CREATE TABLE `les` (
  `id` int(11) NOT NULL,
  `naam` text COLLATE utf8_unicode_ci NOT NULL,
  `opmerkingen` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `jaar` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `kalenderweek` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `module_naam` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lesweek`
--

CREATE TABLE `lesweek` (
  `jaar` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `kalenderweek` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `onderwijsweek` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blokweek` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `naam` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `contactmoment_id` int(11) NOT NULL,
  `waarde` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inhoud` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratingwaarde`
--

CREATE TABLE `ratingwaarde` (
  `naam` varchar(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure for view `contactmoment_module`
--
DROP TABLE IF EXISTS `contactmoment_module`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u28492p22384_teach`@`localhost` SQL SECURITY DEFINER VIEW `contactmoment_module`  AS  select `module`.`naam` AS `modulenaam`,`lesweek`.`kalenderweek` AS `kalenderweek`,`lesweek`.`blokweek` AS `blokweek`,`contactmoment`.`id` AS `id`,`contactmoment`.`les_id` AS `les_id`,`contactmoment`.`starttijd` AS `starttijd`,`contactmoment`.`eindtijd` AS `eindtijd`,`contactmoment`.`ruimte` AS `ruimte`,`contactmoment`.`ical_uid` AS `ical_uid`,`contactmoment`.`created_at` AS `created_at`,`contactmoment`.`updated_at` AS `updated_at`,`contactmoment`.`owner` AS `owner` from (((`module` join `les` on(`les`.`module_naam` = `module`.`naam`)) join `contactmoment` on(`contactmoment`.`les_id` = `les`.`id`)) join `lesweek` on(`les`.`jaar` = `lesweek`.`jaar` and `les`.`kalenderweek` = `lesweek`.`kalenderweek`)) ;

-- --------------------------------------------------------

--
-- Structure for view `contactmoment_toekomst_geimporteerd_verleden`
--
DROP TABLE IF EXISTS `contactmoment_toekomst_geimporteerd_verleden`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u28492p22384_teach`@`localhost` SQL SECURITY DEFINER VIEW `contactmoment_toekomst_geimporteerd_verleden`  AS  select `contactmoment`.`id` AS `id`,`contactmoment`.`les_id` AS `les_id`,`contactmoment`.`starttijd` AS `starttijd`,`contactmoment`.`eindtijd` AS `eindtijd`,`contactmoment`.`ruimte` AS `ruimte`,`contactmoment`.`ical_uid` AS `ical_uid`,`contactmoment`.`created_at` AS `created_at`,`contactmoment`.`updated_at` AS `updated_at` from `contactmoment` where `contactmoment`.`starttijd` > curdate() and `contactmoment`.`ical_uid` is not null and (`contactmoment`.`updated_at` < curdate() or `contactmoment`.`updated_at` is null) ;

-- --------------------------------------------------------

--
-- Structure for view `contactmoment_vandaag`
--
DROP TABLE IF EXISTS `contactmoment_vandaag`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u28492p22384_teach`@`localhost` SQL SECURITY DEFINER VIEW `contactmoment_vandaag`  AS  select `lesweek`.`kalenderweek` AS `kalenderweek`,`lesweek`.`blokweek` AS `blokweek`,`module`.`naam` AS `modulenaam`,`contactmoment`.`id` AS `id`,`contactmoment`.`les_id` AS `les_id`,`contactmoment`.`starttijd` AS `starttijd`,`contactmoment`.`eindtijd` AS `eindtijd`,`contactmoment`.`ruimte` AS `ruimte`,`contactmoment`.`ical_uid` AS `ical_uid`,`contactmoment`.`created_at` AS `created_at`,`contactmoment`.`updated_at` AS `updated_at`,`contactmoment`.`owner` AS `owner` from (((`contactmoment` join `les` on(`contactmoment`.`les_id` = `les`.`id`)) join `lesweek` on(`les`.`jaar` = `lesweek`.`jaar` and `les`.`kalenderweek` = `lesweek`.`kalenderweek`)) join `module` on(`les`.`module_naam` = `module`.`naam`)) where cast(`contactmoment`.`starttijd` as date) = curdate() order by `contactmoment`.`starttijd` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contactmoment`
--
ALTER TABLE `contactmoment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `starttijd` (`starttijd`),
  ADD UNIQUE KEY `ical_uid` (`ical_uid`),
  ADD KEY `fk_contactmoment_les` (`les_id`),
  ADD KEY `IDX_929E7431CF60E67C` (`owner`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `les`
--
ALTER TABLE `les`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_leslesweek` (`jaar`,`kalenderweek`),
  ADD KEY `fk_lesmodule` (`module_naam`);

--
-- Indexes for table `lesweek`
--
ALTER TABLE `lesweek`
  ADD PRIMARY KEY (`jaar`,`kalenderweek`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`migration`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`naam`),
  ADD UNIQUE KEY `naam` (`naam`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`,`token`),
  ADD KEY `password_resets_token_index` (`token`),
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`ip`,`contactmoment_id`),
  ADD KEY `fk_rating_contactmoment` (`contactmoment_id`),
  ADD KEY `fk_rating_waarde` (`waarde`);

--
-- Indexes for table `ratingwaarde`
--
ALTER TABLE `ratingwaarde`
  ADD PRIMARY KEY (`naam`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contactmoment`
--
ALTER TABLE `contactmoment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `les`
--
ALTER TABLE `les`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contactmoment`
--
ALTER TABLE `contactmoment`
  ADD CONSTRAINT `FK_929E7431CF60E67C` FOREIGN KEY (`owner`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_contactmoment_les` FOREIGN KEY (`les_id`) REFERENCES `les` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `les`
--
ALTER TABLE `les`
  ADD CONSTRAINT `fk_leslesweek` FOREIGN KEY (`jaar`,`kalenderweek`) REFERENCES `lesweek` (`jaar`, `kalenderweek`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lesmodule` FOREIGN KEY (`module_naam`) REFERENCES `module` (`naam`) ON UPDATE CASCADE;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `fk_rating_contactmoment` FOREIGN KEY (`contactmoment_id`) REFERENCES `contactmoment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rating_waarde` FOREIGN KEY (`waarde`) REFERENCES `ratingwaarde` (`naam`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
