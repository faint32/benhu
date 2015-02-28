/*
MySQL Data Transfer
Source Host: localhost
Source Database: benhushop
Target Host: localhost
Target Database: benhushop
Date: 2014-7-21 15:36:15
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for ecs_ad
-- ----------------------------
CREATE TABLE `ecs_ad` (
  `ad_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `position_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `media_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ad_name` varchar(60) NOT NULL DEFAULT '',
  `ad_link` varchar(255) NOT NULL DEFAULT '',
  `ad_code` text NOT NULL,
  `start_time` int(11) NOT NULL DEFAULT '0',
  `end_time` int(11) NOT NULL DEFAULT '0',
  `link_man` varchar(60) NOT NULL DEFAULT '',
  `link_email` varchar(60) NOT NULL DEFAULT '',
  `link_phone` varchar(60) NOT NULL DEFAULT '',
  `click_count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`ad_id`),
  KEY `position_id` (`position_id`),
  KEY `enabled` (`enabled`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `ecs_ad` VALUES ('1', '1', '0', '轮播1', '', '1405896810040055943.gif', '1405843200', '1408435200', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('2', '1', '0', '轮播2', '', '1405896833401795171.gif', '1405843200', '1408435200', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('3', '1', '0', '轮播3', '', '1405896857592373637.gif', '1405843200', '1408435200', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('4', '1', '0', '轮播4', '', '1405896873622841258.gif', '1405843200', '1408435200', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('5', '1', '0', '轮播5', '', '1405896893450536186.gif', '1405843200', '1408435200', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('6', '1', '0', '轮播6', '', '1405896925371270292.gif', '1405843200', '1408435200', '', '', '', '0', '1');
