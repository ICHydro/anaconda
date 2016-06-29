
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";



DROP TABLE IF EXISTS `attachment`;
CREATE TABLE IF NOT EXISTS `attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) DEFAULT NULL,
  `filelink` varchar(255) DEFAULT NULL,
  `part` int(11) DEFAULT NULL,
  `emailid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emailid` (`emailid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure for table `calibration`
--

DROP TABLE IF EXISTS `calibration`;
CREATE TABLE IF NOT EXISTS `calibration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `height` double DEFAULT NULL,
  `measure` enum('mm','cm','m') DEFAULT NULL,
  `sensorid` int(11) NOT NULL,
  `yourname` varchar(255) DEFAULT NULL,
  `youremail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_calibration_sensor1` (`sensorid`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure for table `catchment`
--

DROP TABLE IF EXISTS `catchment`;
CREATE TABLE IF NOT EXISTS `catchment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `name_es` varchar(255) DEFAULT NULL,
  `name_ne` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `description_es` text,
  `description_ne` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `catchment`
--

INSERT INTO `catchment` (`id`, `name`, `name_es`, `name_ne`, `description`, `description_es`, `description_ne`) VALUES
(1, 'Catchment Area: One', 'Área de influencia : Uno', ' Catchment क्षेत्र : एक', 'Catchment areas (especially Catchment 1) are generally established and modified by local governments. These boundaries can be modeled using geographic information systems (GIS).There can be large variability in the services provided within different catchments in the same area depending upon how and when those catchments were established. They are usually contiguous but can overlap when they describe competing services', '\r\nLas zonas de captación (especialmente de captación 1 ) son generalmente establecidos y modificados por los gobiernos locales . Estos límites pueden ser modelados utilizando sistemas de información geográfica ( GIS ) .No puede ser una gran variabilidad en los servicios prestados en las diferentes zonas de captación en la misma zona , dependiendo de cómo y cuándo se establecieron esas cuencas . Por lo general son contiguas, sino que pueden solaparse cuando describen servicios de la competencia', 'Catchment क्षेत्रहरु ( विशेष गरी 1 Catchment ) साधारण स्थापित र परिमार्जन स्थानीय सरकारहरूले द्वारा छन् । यी सीमा भौगोलिक सूचना प्रणाली ( जीआईएस ) को प्रयोग गरेर .त्यहाँ ती catchments स्थापित थिए कसरी र कहिले निर्भर गर्दछ नै क्षेत्रमा विभिन्न catchments भित्र प्रदान सेवाहरूमा ठूलो variability हुन सक्छ modeled गर्न सकिन्छ। तिनीहरूले सामान्यतया सन्निहित छन् तर तिनीहरूले प्रतिस्पर्धा सेवाहरू वर्णन गर्दा ओभरल्याप गर्न सक्नुहुन्छ'),
(2, 'Catchment Area: Two', 'Área de influencia : Dos', 'Catchment स्थान: दुई', 'Catchment areas (especially Catchment 2) are generally established and modified by local governments. These boundaries can be modeled using geographic information systems (GIS).There can be large variability in the services provided within different catchments in the same area depending upon how and when those catchments were established. They are usually contiguous but can overlap when they describe competing services', 'Las zonas de captación (especialmente de captación 2 ) son generalmente establecidos y modificados por los gobiernos locales . Estos límites pueden ser modelados utilizando sistemas de información geográfica ( GIS ) .No puede ser una gran variabilidad en los servicios prestados en las diferentes zonas de captación en la misma zona , dependiendo de cómo y cuándo se establecieron esas cuencas . Por lo general son contiguas, sino que pueden solaparse cuando describen servicios de la competencia\r\n', 'Catchment क्षेत्रहरु ( विशेष गरी 2 Catchment ) साधारण स्थापित र परिमार्जन स्थानीय सरकारहरूले द्वारा छन् । यी सीमा भौगोलिक सूचना प्रणाली ( जीआईएस ) को प्रयोग गरेर .त्यहाँ ती catchments स्थापित थिए कसरी र कहिले निर्भर गर्दछ नै क्षेत्रमा विभिन्न catchments भित्र प्रदान सेवाहरूमा ठूलो variability हुन सक्छ modeled गर्न सकिन्छ। तिनीहरूले सामान्यतया सन्निहित छन् तर तिनीहरूले प्रतिस्पर्धा सेवाहरू वर्णन गर्दा ओभरल्याप गर्न सक्नुहुन्छ'),
(3, 'Catchment Area: 3', 'Área de influencia : 3', 'Catchment स्थान: 3', 'Catchment areas (especially Catchment 3) are generally established and modified by local governments. These boundaries can be modeled using geographic information systems (GIS).There can be large variability in the services provided within different catchments in the same area depending upon how and when those catchments were established. They are usually contiguous but can overlap when they describe competing services', 'Las zonas de captación (especialmente de captación 3 ) son generalmente establecidos y modificados por los gobiernos locales . Estos límites pueden ser modelados utilizando sistemas de información geográfica ( GIS ) .No puede ser una gran variabilidad en los servicios prestados en las diferentes zonas de captación en la misma zona , dependiendo de cómo y cuándo se establecieron esas cuencas . Por lo general son contiguas, sino que pueden solaparse cuando describen servicios de la competencia\r\n', 'Catchment क्षेत्रहरु ( विशेष गरी 3 Catchment ) साधारण स्थापित र परिमार्जन स्थानीय सरकारहरूले द्वारा छन् । यी सीमा भौगोलिक सूचना प्रणाली ( जीआईएस ) को प्रयोग गरेर .त्यहाँ ती catchments स्थापित थिए कसरी र कहिले निर्भर गर्दछ नै क्षेत्रमा विभिन्न catchments भित्र प्रदान सेवाहरूमा ठूलो variability हुन सक्छ modeled गर्न सकिन्छ। तिनीहरूले सामान्यतया सन्निहित छन् तर तिनीहरूले प्रतिस्पर्धा सेवाहरू वर्णन गर्दा ओभरल्याप गर्न सक्नुहुन्छ');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `email`
--

DROP TABLE IF EXISTS `email`;
CREATE TABLE IF NOT EXISTS `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msgno` int(11) DEFAULT NULL,
  `sender` varchar(255) DEFAULT NULL,
  `senderemail` varchar(255) DEFAULT NULL,
  `sendermailbox` varchar(255) DEFAULT NULL,
  `senderhost` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` text,
  `size` int(11) DEFAULT NULL,
  `extra` text,
  `creationdate` datetime DEFAULT NULL,
  `online` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `file`
--

DROP TABLE IF EXISTS `file`;
CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filelink` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `extension` varchar(255) DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `sensorid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_file_sensor1` (`sensorid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1450878781),
('m150214_044831_init_user', 1450878791),
('m170610_152817_i18n', 1462146099);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profile_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `profile`
--

INSERT INTO `profile` (`id`, `user_id`, `created_at`, `updated_at`, `full_name`) VALUES
(1, 1, '2015-12-23 12:53:11', '2016-05-01 19:41:06', 'the one'),
(2, 2, '2016-05-01 19:57:02', '2016-05-01 19:57:02', 'test'),
(3, 3, '2016-05-01 21:22:52', '2016-05-01 21:22:52', 'Wouter');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `can_admin` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `role`
--

INSERT INTO `role` (`id`, `name`, `created_at`, `updated_at`, `can_admin`) VALUES
(1, 'Admin', '2015-12-23 12:53:11', NULL, 1),
(2, 'User', '2015-12-23 12:53:11', NULL, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sensor`
--

DROP TABLE IF EXISTS `sensor`;
CREATE TABLE IF NOT EXISTS `sensor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `catchmentid` int(11) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `sensortype` varchar(255) DEFAULT NULL,
  `units` varchar(4) DEFAULT NULL,
  `height` double DEFAULT NULL,
  `width` double DEFAULT NULL,
  `angle` double DEFAULT NULL,
  `property` varchar(255) DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sensor_catchment1` (`catchmentid`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `sensor`
--

INSERT INTO `sensor` (`id`, `name`, `catchmentid`, `latitude`, `longitude`, `sensortype`, `units`, `height`, `width`, `angle`, `property`, `admin_email`) VALUES
(1, 'sensor 1', 1, 10, 10, 'Weighing Gauge', NULL, 10, 10, 520, NULL, NULL),
(2, 'Sensor 2', 1, 13, 123, 'Weighing Gauge', NULL, 10, 10, 250, NULL, NULL),
(4, 'S2123', 1, 10, 10, 'Weighing Gauge', NULL, NULL, NULL, NULL, NULL, NULL),
(5, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(6, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(7, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(8, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(9, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(10, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(11, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(12, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(13, '123456', 1, 20, 40, 'Weighing Gauge', 'inch', NULL, NULL, NULL, 'Observation 2', 'lalala@example.com'),
(14, '', 2, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, 'Observation 2', 'bart.demaesschalck@gmail.com'),
(15, '123123', 2, 20, 20, 'Weighing Gauge', 'inch', NULL, NULL, NULL, 'Observation 2', 'bart.demaesschalck@gmail.com'),
(16, 'Sensor 3', 2, 20, 40, 'Weighing Gauge', 'inch', NULL, NULL, NULL, 'Observation 2', 'bart.demaesschalck@gmail.com');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logged_in_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logged_in_at` timestamp NULL DEFAULT NULL,
  `created_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  `banned_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`email`),
  UNIQUE KEY `user_username` (`username`),
  KEY `user_role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `role_id`, `status`, `email`, `username`, `password`, `auth_key`, `access_token`, `logged_in_ip`, `logged_in_at`, `created_ip`, `created_at`, `updated_at`, `banned_at`, `banned_reason`) VALUES
(1, 1, 1, 'neo@neo.com', 'neo', '$2y$13$dyVw4WkZGkABf2UrGWrhHO4ZmVBv.K4puhOL59Y9jQhIdj63TlV.O', 'sB-taQ_hcmvBecCmIN0df3FptS9nabDc', 'FggrSfeqersuWKrKDeKWBQ0RuPEW1vC2', '127.0.0.1', '2016-05-01 20:05:35', NULL, '2015-12-23 12:53:11', NULL, NULL, NULL),
(2, 2, 1, 'bart.demaesschalck@gmail.com', 'test', '$2y$13$mHKbYQtg30G.n3vomNGmaOithwPTO3NNhuQQKeojLYqKwzZ0rUr1C', NULL, NULL, '127.0.0.1', '2016-05-01 20:09:14', NULL, '2016-05-01 19:57:02', '2016-05-01 19:57:02', NULL, NULL),
(3, 1, 1, 'w.buytaert@imperial.ac.uk', 'admin', '$2y$13$DLwSclZTa3xY/Ixl53Dnp.qhYmgbx9W8Q9m0mpXSijU4dVB.1d/kK', NULL, NULL, NULL, NULL, NULL, '2016-05-01 21:22:52', '2016-05-01 21:22:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_auth`
--

DROP TABLE IF EXISTS `user_auth`;
CREATE TABLE IF NOT EXISTS `user_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_attributes` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_auth_provider_id` (`provider_id`),
  KEY `user_auth_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_token`
--

DROP TABLE IF EXISTS `user_token`;
CREATE TABLE IF NOT EXISTS `user_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` smallint(6) NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_token_token` (`token`),
  KEY `user_token_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `attachment`
--
ALTER TABLE `attachment`
  ADD CONSTRAINT `attachment_ibfk_1` FOREIGN KEY (`emailid`) REFERENCES `email` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `calibration`
--
ALTER TABLE `calibration`
  ADD CONSTRAINT `fk_calibration_sensor1` FOREIGN KEY (`sensorid`) REFERENCES `sensor` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `fk_file_sensor1` FOREIGN KEY (`sensorid`) REFERENCES `sensor` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Beperkingen voor tabel `sensor`
--
ALTER TABLE `sensor`
  ADD CONSTRAINT `fk_sensor_catchment1` FOREIGN KEY (`catchmentid`) REFERENCES `catchment` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Beperkingen voor tabel `user_auth`
--
ALTER TABLE `user_auth`
  ADD CONSTRAINT `user_auth_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Beperkingen voor tabel `user_token`
--
ALTER TABLE `user_token`
  ADD CONSTRAINT `user_token_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
SET FOREIGN_KEY_CHECKS=1;


