DROP TABLE IF EXISTS `#__icagenda`;
DROP TABLE IF EXISTS `#__icagenda_category`;
DROP TABLE IF EXISTS `#__icagenda_events`;
DROP TABLE IF EXISTS `#__icagenda_registration`;
DROP TABLE IF EXISTS `#__icagenda_location`;

CREATE TABLE `#__icagenda` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` VARCHAR(255) DEFAULT NULL,
  `releasedate` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

INSERT INTO `#__icagenda` (id,version,releasedate) VALUES
(1,'none','none');
INSERT INTO `#__icagenda` (id,version,releasedate) VALUES
(2,'3.1.13','2013-09-20');

CREATE TABLE `#__icagenda_category` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL DEFAULT '1',
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`title` VARCHAR(255)  NOT NULL ,
`alias` VARCHAR( 255 ) NOT NULL ,
`color` VARCHAR(255)  NOT NULL ,
`desc` TEXT(65535)  NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE `#__icagenda_events` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`asset_id` INT(10) NOT NULL DEFAULT '0',
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL DEFAULT '1',
`approval` INT(11)  NOT NULL DEFAULT '0',
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`title` VARCHAR(255) NOT NULL ,
`alias` VARCHAR(255) NOT NULL ,
`access` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
`language` CHAR(7)  NOT NULL ,
`created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`created_by` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
`created_by_alias` VARCHAR(255) NOT NULL ,
`created_by_email` VARCHAR(100) NOT NULL ,
`modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`modified_by` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
`username` VARCHAR(255)  NOT NULL ,
`catid` INT(11)  NOT NULL ,
`image` VARCHAR(255)  NOT NULL ,
`file` VARCHAR(255)  NOT NULL ,
`displaytime` INT(10) NOT NULL DEFAULT '1',
`weekdays` VARCHAR(255)  NOT NULL ,
`startdate` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`enddate` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`period` TEXT(65535) NOT NULL ,
`dates` TEXT(65535)  NOT NULL ,
`next`  DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`time` VARCHAR(255)  NOT NULL ,
`place` VARCHAR(255)  NOT NULL ,
`website` VARCHAR(255) NOT NULL ,
`email` VARCHAR(255) NOT NULL ,
`phone` VARCHAR(255) NOT NULL ,
`name` VARCHAR(255) NOT NULL ,
`city` VARCHAR(255) NOT NULL ,
`country` VARCHAR(255) NOT NULL ,
`address` VARCHAR(255)  NOT NULL ,
`coordinate` VARCHAR(255)  NOT NULL ,
`lat` FLOAT( 20, 16 )  NOT NULL ,
`lng` FLOAT( 20, 16 )  NOT NULL ,
`desc` TEXT(65535)  NOT NULL ,
`params` TEXT  NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;


CREATE TABLE `#__icagenda_registration` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL DEFAULT '1',
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`userid` INT(11)  NOT NULL ,
`itemid` INT(11)  NOT NULL ,
`eventid` INT(11)  NOT NULL ,
`name` VARCHAR(255)  NOT NULL ,
`email` VARCHAR(255)  NOT NULL ,
`phone` VARCHAR(255)  NOT NULL ,
`date` TEXT(65535)  NOT NULL,
`period` TINYINT(1) NOT NULL DEFAULT '0',
`people` INT(2)  NOT NULL ,
`notes` TEXT(65535)  NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

