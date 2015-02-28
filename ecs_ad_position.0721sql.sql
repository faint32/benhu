/*
MySQL Data Transfer
Source Host: localhost
Source Database: benhushop
Target Host: localhost
Target Database: benhushop
Date: 2014-7-21 15:36:53
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for ecs_ad_position
-- ----------------------------
CREATE TABLE `ecs_ad_position` (
  `position_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `position_name` varchar(60) NOT NULL DEFAULT '',
  `ad_width` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ad_height` smallint(5) unsigned NOT NULL DEFAULT '0',
  `position_desc` varchar(255) NOT NULL DEFAULT '',
  `position_style` text NOT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `ecs_ad_position` VALUES ('1', '首页轮播图', '780', '350', '', '<table cellpadding=\"0\" cellspacing=\"0\">\r\n{foreach from=$ads item=ad}\r\n<tr><td>{$ad}</td></tr>\r\n{/foreach}\r\n</table>');
