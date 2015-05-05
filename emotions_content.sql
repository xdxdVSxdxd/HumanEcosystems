-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: he.human-ecosystems.com
-- Generation Time: May 05, 2015 at 02:41 PM
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

--
-- Dumping data for table `emotions`
--

INSERT INTO `emotions` (`id`, `name`, `label`, `color`) VALUES
(1, 'love', 'Love', '#FF8080'),
(2, 'anger', 'Anger', '#800000'),
(3, 'disgust', 'Disgust', '#800080'),
(4, 'boredom', 'Boredom', '#DD00DD'),
(5, 'fear', 'Fear', '#00FF00'),
(6, 'hate', 'Hate', '#FF0000'),
(7, 'joy', 'Joy', '#FFFF00'),
(8, 'surprise', 'Surprise', '#0060FF'),
(9, 'trust', 'Trust', '#60FF00'),
(10, 'sadness', 'Sadness', '#0000FF'),
(11, 'anticipation', 'Anticipation', '#FF8000'),
(12, 'violence', 'Violence', '#FF4000'),
(13, 'terror', 'Terror', '#008000');
