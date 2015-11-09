-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: he.human-ecosystems.com
-- Generation Time: Oct 26, 2015 at 07:18 AM
-- Server version: 5.6.25
-- PHP Version: 5.6.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hebo`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `research` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `isgeodependent` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `isgeodependent` (`isgeodependent`),
  KEY `research` (`research`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `classifier_corecmessage`
--

DROP TABLE IF EXISTS `classifier_corecmessage`;
CREATE TABLE IF NOT EXISTS `classifier_corecmessage` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idcorr` bigint(20) NOT NULL,
  `idcontent` bigint(20) NOT NULL,
  `t` datetime NOT NULL,
  `n` int(11) NOT NULL,
  `research` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idcorr` (`idcorr`),
  KEY `idcontent` (`idcontent`),
  KEY `t` (`t`),
  KEY `n` (`n`),
  KEY `research` (`research`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4915753 ;

-- --------------------------------------------------------

--
-- Table structure for table `classifier_corecurrence`
--

DROP TABLE IF EXISTS `classifier_corecurrence`;
CREATE TABLE IF NOT EXISTS `classifier_corecurrence` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idw1` bigint(20) NOT NULL,
  `idw2` bigint(20) NOT NULL,
  `n` int(11) NOT NULL,
  `research` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idw1` (`idw1`,`idw2`),
  KEY `n` (`n`),
  KEY `research` (`research`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2755811 ;

-- --------------------------------------------------------

--
-- Table structure for table `classifier_words`
--

DROP TABLE IF EXISTS `classifier_words`;
CREATE TABLE IF NOT EXISTS `classifier_words` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `word` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `n` int(11) NOT NULL,
  `research` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `word` (`word`),
  KEY `n` (`n`),
  KEY `research` (`research`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=103929 ;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
CREATE TABLE IF NOT EXISTS `content` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_social` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `nick` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` text COLLATE utf8_unicode_ci NOT NULL,
  `t` datetime NOT NULL,
  `txt` text COLLATE utf8_unicode_ci NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `source` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `processed_relations` tinyint(4) NOT NULL DEFAULT '0',
  `processed_emotions` tinyint(4) NOT NULL DEFAULT '0',
  `research` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `reply_to_user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-1',
  `reply_to_content_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-1',
  `processed_classification` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_social` (`id_social`(191)),
  KEY `id_user` (`id_user`),
  KEY `nick` (`nick`(191)),
  KEY `t` (`t`),
  KEY `lat` (`lat`,`lng`),
  KEY `source` (`source`),
  KEY `processed_relations` (`processed_relations`),
  KEY `processed_emotions` (`processed_emotions`),
  KEY `research` (`research`),
  KEY `language` (`language`),
  KEY `processed_classification` (`processed_classification`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=70360 ;

-- --------------------------------------------------------

--
-- Table structure for table `content_to_class`
--

DROP TABLE IF EXISTS `content_to_class`;
CREATE TABLE IF NOT EXISTS `content_to_class` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_content` bigint(20) NOT NULL,
  `id_class` bigint(20) NOT NULL,
  `id_word` bigint(20) NOT NULL,
  `research` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_content` (`id_content`),
  KEY `id_class` (`id_class`),
  KEY `id_word` (`id_word`),
  KEY `research` (`research`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=71720 ;

-- --------------------------------------------------------

--
-- Table structure for table `emotions`
--

DROP TABLE IF EXISTS `emotions`;
CREATE TABLE IF NOT EXISTS `emotions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `emotions_content`
--

DROP TABLE IF EXISTS `emotions_content`;
CREATE TABLE IF NOT EXISTS `emotions_content` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_content` bigint(20) NOT NULL,
  `id_emotion` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_content` (`id_content`,`id_emotion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=108934 ;

-- --------------------------------------------------------

--
-- Table structure for table `emotions_words`
--

DROP TABLE IF EXISTS `emotions_words`;
CREATE TABLE IF NOT EXISTS `emotions_words` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `word` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `idemotion` bigint(20) NOT NULL,
  `lang` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNI-EMO-WO` (`word`,`idemotion`,`lang`),
  KEY `idemotion` (`idemotion`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=904 ;

-- --------------------------------------------------------

--
-- Table structure for table `relations`
--

DROP TABLE IF EXISTS `relations`;
CREATE TABLE IF NOT EXISTS `relations` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nick1` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nick2` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `c` int(11) NOT NULL,
  `research` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nick1` (`nick1`),
  KEY `nick2` (`nick2`),
  KEY `nick1_2` (`nick1`,`nick2`),
  KEY `c` (`c`),
  KEY `research` (`research`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2520 ;

-- --------------------------------------------------------

--
-- Table structure for table `research`
--

DROP TABLE IF EXISTS `research`;
CREATE TABLE IF NOT EXISTS `research` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `clat` double NOT NULL,
  `clon` double NOT NULL,
  `minlat` double NOT NULL,
  `minlon` double NOT NULL,
  `maxlat` double NOT NULL,
  `maxlon` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `label` (`label`),
  KEY `clat` (`clat`,`clon`),
  KEY `minlat` (`minlat`,`minlon`,`maxlat`,`maxlon`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_social` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nick` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `profile_url` text COLLATE utf8_unicode_ci NOT NULL,
  `image_url` text COLLATE utf8_unicode_ci NOT NULL,
  `source` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `research` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `processusers` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_social` (`id_social`(191)),
  KEY `nick` (`nick`),
  KEY `source` (`source`),
  KEY `research` (`research`),
  KEY `processusers` (`processusers`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27713 ;

-- --------------------------------------------------------

--
-- Table structure for table `words`
--

DROP TABLE IF EXISTS `words`;
CREATE TABLE IF NOT EXISTS `words` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_class` bigint(20) NOT NULL,
  `word` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `t` datetime NOT NULL,
  `research` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_class` (`id_class`),
  KEY `t` (`t`),
  KEY `research` (`research`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;
