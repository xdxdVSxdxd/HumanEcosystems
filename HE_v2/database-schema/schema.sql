CREATE TABLE `classes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `research` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE `classifier_corecmessage` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE `classifier_corecurrence` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idw1` bigint(20) NOT NULL,
  `idw2` bigint(20) NOT NULL,
  `n` int(11) NOT NULL,
  `research` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idw1` (`idw1`,`idw2`),
  KEY `n` (`n`),
  KEY `research` (`research`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE `classifier_words` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `word` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `n` int(11) NOT NULL,
  `research` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `word` (`word`),
  KEY `n` (`n`),
  KEY `research` (`research`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE `content` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE `content_to_class` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE `emotions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;


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


CREATE TABLE `emotions_content` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_content` bigint(20) NOT NULL,
  `id_emotion` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_content` (`id_content`,`id_emotion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE `emotions_words` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `word` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `idemotion` bigint(20) NOT NULL,
  `lang` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idemotion` (`idemotion`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE `relations` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE `research` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE `users` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE `words` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_class` bigint(20) NOT NULL,
  `word` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `t` datetime NOT NULL,
  `research` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_class` (`id_class`),
  KEY `t` (`t`),
  KEY `research` (`research`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
