-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: he.human-ecosystems.com
-- Generation Time: May 05, 2015 at 01:48 PM
-- Server version: 5.1.56
-- PHP Version: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `humanecosystems`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_of_location`
--

CREATE TABLE IF NOT EXISTS `category_of_location` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_category` bigint(20) NOT NULL,
  `id_location` bigint(20) NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_category` (`id_category`),
  KEY `id_location` (`id_location`),
  KEY `city` (`city`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2276 ;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clat` double NOT NULL,
  `clon` double NOT NULL,
  `minlat` double NOT NULL,
  `minlon` double NOT NULL,
  `maxlat` double NOT NULL,
  `maxlon` double NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `city` (`city`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `classifier_corecmessage`
--

CREATE TABLE IF NOT EXISTS `classifier_corecmessage` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idcorr` bigint(20) NOT NULL,
  `idcontent` bigint(20) NOT NULL,
  `t` datetime NOT NULL,
  `n` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idcorr` (`idcorr`),
  KEY `n` (`n`),
  KEY `t` (`t`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16683889 ;

-- --------------------------------------------------------

--
-- Table structure for table `classifier_corecurrence`
--

CREATE TABLE IF NOT EXISTS `classifier_corecurrence` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idw1` bigint(20) NOT NULL,
  `idw2` bigint(20) NOT NULL,
  `n` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idw1` (`idw1`,`idw2`),
  KEY `n` (`n`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5030017 ;

-- --------------------------------------------------------

--
-- Table structure for table `classifier_words`
--

CREATE TABLE IF NOT EXISTS `classifier_words` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `n` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `word` (`word`),
  KEY `n` (`n`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=235761 ;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_social` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `nick` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `link` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `t` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `txt` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `source` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `reply_to_user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `reply_to_content_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `processed_relations` smallint(6) NOT NULL DEFAULT '0',
  `city` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `processed_emotions` tinyint(4) NOT NULL DEFAULT '0',
  `language` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `processed_classification` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `lat` (`lat`,`lng`),
  KEY `id_social` (`id_social`),
  KEY `source` (`source`),
  KEY `reply_to_user_id` (`reply_to_user_id`),
  KEY `reply_to_content_id` (`reply_to_content_id`),
  KEY `nick` (`nick`),
  KEY `processed_relations` (`processed_relations`),
  KEY `city` (`city`),
  KEY `processed_emotions` (`processed_emotions`),
  KEY `processed_classification` (`processed_classification`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4499303 ;

-- --------------------------------------------------------

--
-- Table structure for table `content_bkp_20141020`
--

CREATE TABLE IF NOT EXISTS `content_bkp_20141020` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_social` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `nick` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `link` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `t` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `txt` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `source` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `reply_to_user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `reply_to_content_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `processed_relations` smallint(6) NOT NULL DEFAULT '0',
  `city` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `processed_emotions` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `lat` (`lat`,`lng`),
  KEY `id_social` (`id_social`),
  KEY `source` (`source`),
  KEY `reply_to_user_id` (`reply_to_user_id`),
  KEY `reply_to_content_id` (`reply_to_content_id`),
  KEY `nick` (`nick`),
  KEY `processed_relations` (`processed_relations`),
  KEY `city` (`city`),
  KEY `processed_emotions` (`processed_emotions`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3325493 ;

-- --------------------------------------------------------

--
-- Table structure for table `content_to_class`
--

CREATE TABLE IF NOT EXISTS `content_to_class` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_content` bigint(20) NOT NULL,
  `id_class` bigint(20) NOT NULL,
  `id_word` bigint(20) NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_content` (`id_content`),
  KEY `id_class` (`id_class`),
  KEY `id_word` (`id_word`),
  KEY `city` (`city`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4879952 ;

-- --------------------------------------------------------

--
-- Table structure for table `emotions`
--

CREATE TABLE IF NOT EXISTS `emotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `label` (`label`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `emotions_content`
--

CREATE TABLE IF NOT EXISTS `emotions_content` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_content` bigint(20) NOT NULL,
  `id_emotion` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_content` (`id_content`),
  KEY `id_emotion` (`id_emotion`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=118332 ;

-- --------------------------------------------------------

--
-- Table structure for table `emotions_words`
--

CREATE TABLE IF NOT EXISTS `emotions_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  `idemotion` int(11) NOT NULL,
  `lang` varchar(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idemotion` (`idemotion`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=238 ;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_social` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street` text COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  `main_category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `citycity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_social` (`id_social`),
  KEY `lat` (`lat`,`lng`),
  KEY `main_category` (`main_category`),
  KEY `citycity` (`citycity`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1390 ;

-- --------------------------------------------------------

--
-- Table structure for table `location_categories`
--

CREATE TABLE IF NOT EXISTS `location_categories` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_social` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_social` (`id_social`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=388 ;

-- --------------------------------------------------------

--
-- Table structure for table `nhv_anx`
--

CREATE TABLE IF NOT EXISTS `nhv_anx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_str` varchar(255) NOT NULL,
  `language` varchar(5) NOT NULL,
  `url` text NOT NULL,
  `from_user_id` varchar(255) NOT NULL,
  `from_user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `to_user_id` varchar(255) NOT NULL,
  `location` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  `profile_image` text NOT NULL,
  `t` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `txt` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `t` (`t`),
  KEY `lat` (`lat`),
  KEY `lng` (`lng`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=535 ;

-- --------------------------------------------------------

--
-- Table structure for table `nhv_hate`
--

CREATE TABLE IF NOT EXISTS `nhv_hate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_str` varchar(255) NOT NULL,
  `language` varchar(5) NOT NULL,
  `url` text NOT NULL,
  `from_user_id` varchar(255) NOT NULL,
  `from_user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `to_user_id` varchar(255) NOT NULL,
  `location` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  `profile_image` text NOT NULL,
  `t` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `txt` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `t` (`t`),
  KEY `lat` (`lat`),
  KEY `lng` (`lng`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=473 ;

-- --------------------------------------------------------

--
-- Table structure for table `nhv_joy`
--

CREATE TABLE IF NOT EXISTS `nhv_joy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_str` varchar(255) NOT NULL,
  `language` varchar(5) NOT NULL,
  `url` text NOT NULL,
  `from_user_id` varchar(255) NOT NULL,
  `from_user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `to_user_id` varchar(255) NOT NULL,
  `location` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  `profile_image` text NOT NULL,
  `t` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `txt` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `t` (`t`),
  KEY `lat` (`lat`),
  KEY `lng` (`lng`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=892 ;

-- --------------------------------------------------------

--
-- Table structure for table `nhv_love`
--

CREATE TABLE IF NOT EXISTS `nhv_love` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_str` varchar(255) NOT NULL,
  `language` varchar(5) NOT NULL,
  `url` text NOT NULL,
  `from_user_id` varchar(255) NOT NULL,
  `from_user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `to_user_id` varchar(255) NOT NULL,
  `location` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  `profile_image` text NOT NULL,
  `t` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `txt` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `t` (`t`),
  KEY `lat` (`lat`),
  KEY `lng` (`lng`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1981 ;

-- --------------------------------------------------------

--
-- Table structure for table `relations`
--

CREATE TABLE IF NOT EXISTS `relations` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nick1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nick2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `c` int(11) NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nick1` (`nick1`),
  KEY `nick2` (`nick2`),
  KEY `c` (`c`),
  KEY `city` (`city`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=531587 ;

-- --------------------------------------------------------

--
-- Table structure for table `sp_water`
--

CREATE TABLE IF NOT EXISTS `sp_water` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_str` varchar(255) NOT NULL,
  `language` varchar(5) NOT NULL,
  `url` text NOT NULL,
  `from_user_id` varchar(255) NOT NULL,
  `from_user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `to_user_id` varchar(255) NOT NULL,
  `location` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  `profile_image` text NOT NULL,
  `t` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `txt` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `t` (`t`),
  KEY `lat` (`lat`),
  KEY `lng` (`lng`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1321 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_social` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nick` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_url` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `image_url` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `source` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `processuser` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_social` (`id_social`),
  KEY `source` (`source`),
  KEY `city` (`city`),
  KEY `nick` (`nick`),
  FULLTEXT KEY `profile_url` (`profile_url`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=618903 ;

-- --------------------------------------------------------

--
-- Table structure for table `words`
--

CREATE TABLE IF NOT EXISTS `words` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_class` bigint(20) NOT NULL,
  `word` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `t` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `city` (`city`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=135 ;
