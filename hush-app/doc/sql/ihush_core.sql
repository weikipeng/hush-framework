/*
SQLyog 企业版 - MySQL GUI v7.14 
MySQL - 5.1.41 : Database - ihush_core
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `app` */

DROP TABLE IF EXISTS `app`;

CREATE TABLE `app` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `path` varchar(50) NOT NULL DEFAULT '',
  `pid` int(10) NOT NULL DEFAULT '0',
  `order` int(10) NOT NULL DEFAULT '0',
  `is_app` enum('YES','NO') NOT NULL DEFAULT 'YES',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `app_role` */

DROP TABLE IF EXISTS `app_role`;

CREATE TABLE `app_role` (
  `app_id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  PRIMARY KEY (`app_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `bpm_flow` */

DROP TABLE IF EXISTS `bpm_flow`;

CREATE TABLE `bpm_flow` (
  `bpm_flow_id` int(11) NOT NULL AUTO_INCREMENT,
  `bpm_flow_name` varchar(100) NOT NULL,
  `bpm_flow_type` int(11) DEFAULT NULL,
  `bpm_flow_desc` text,
  `bpm_flow_status` int(11) NOT NULL,
  PRIMARY KEY (`bpm_flow_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `bpm_flow_op` */

DROP TABLE IF EXISTS `bpm_flow_op`;

CREATE TABLE `bpm_flow_op` (
  `bpm_flow_op_id` int(11) NOT NULL AUTO_INCREMENT,
  `bpm_flow_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bpm_flow_op_action` varchar(100) NOT NULL,
  `bpm_flow_op_detail` varchar(255) NOT NULL,
  `bpm_flow_op_time` int(11) NOT NULL,
  PRIMARY KEY (`bpm_flow_op_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `bpm_flow_role` */

DROP TABLE IF EXISTS `bpm_flow_role`;

CREATE TABLE `bpm_flow_role` (
  `bpm_flow_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`bpm_flow_id`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `bpm_model` */

DROP TABLE IF EXISTS `bpm_model`;

CREATE TABLE `bpm_model` (
  `bpm_model_id` int(11) NOT NULL AUTO_INCREMENT,
  `bpm_flow_id` int(11) NOT NULL,
  `bpm_model_json` text,
  `bpm_model_form` text,
  `bpm_model_status` int(11) NOT NULL,
  PRIMARY KEY (`bpm_model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `bpm_model_field` */

DROP TABLE IF EXISTS `bpm_model_field`;

CREATE TABLE `bpm_model_field` (
  `bpm_model_field_id` int(11) NOT NULL AUTO_INCREMENT,
  `bpm_model_id` int(11) NOT NULL,
  `bpm_model_field_name` varchar(100) NOT NULL,
  `bpm_model_field_alias` varchar(255) DEFAULT NULL,
  `bpm_model_field_type` int(11) NOT NULL,
  `bpm_model_field_attr` varchar(255) DEFAULT NULL,
  `bpm_model_field_length` int(11) NOT NULL DEFAULT '0',
  `bpm_model_field_option` text,
  PRIMARY KEY (`bpm_model_field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `bpm_node` */

DROP TABLE IF EXISTS `bpm_node`;

CREATE TABLE `bpm_node` (
  `bpm_node_id` int(11) NOT NULL AUTO_INCREMENT,
  `bpm_flow_id` int(11) NOT NULL,
  `bpm_node_type` int(11) NOT NULL,
  `bpm_node_attr` int(11) NOT NULL,
  `bpm_node_name` varchar(100) NOT NULL,
  `bpm_node_code` text,
  `bpm_node_next` int(11) DEFAULT '0',
  `bpm_node_pos_left` int(11) DEFAULT NULL,
  `bpm_node_pos_top` int(11) DEFAULT NULL,
  `bpm_node_status` int(11) NOT NULL,
  PRIMARY KEY (`bpm_node_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Table structure for table `bpm_node_path` */

DROP TABLE IF EXISTS `bpm_node_path`;

CREATE TABLE `bpm_node_path` (
  `bpm_flow_id` int(11) NOT NULL,
  `bpm_node_id_from` int(11) NOT NULL,
  `bpm_node_id_to` int(11) NOT NULL,
  PRIMARY KEY (`bpm_flow_id`,`bpm_node_id_from`,`bpm_node_id_to`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `bpm_request` */

DROP TABLE IF EXISTS `bpm_request`;

CREATE TABLE `bpm_request` (
  `bpm_request_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `bpm_flow_id` int(11) NOT NULL,
  `bpm_node_id` int(11) NOT NULL,
  `bpm_request_subject` varchar(255) NOT NULL,
  `bpm_request_body` text NOT NULL,
  `bpm_request_sent` int(11) NOT NULL,
  `bpm_request_status` int(11) NOT NULL,
  `bpm_request_comment` text NOT NULL,
  PRIMARY KEY (`bpm_request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `bpm_request_audit` */

DROP TABLE IF EXISTS `bpm_request_audit`;

CREATE TABLE `bpm_request_audit` (
  `bpm_request_audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `bpm_request_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `bpm_request_audit_done` int(11) NOT NULL DEFAULT '0',
  `bpm_request_audit_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bpm_request_audit_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `bpm_request_op` */

DROP TABLE IF EXISTS `bpm_request_op`;

CREATE TABLE `bpm_request_op` (
  `bpm_request_op_id` int(11) NOT NULL AUTO_INCREMENT,
  `bpm_request_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `bpm_request_op_action` varchar(100) NOT NULL,
  `bpm_request_op_detail` text NOT NULL,
  `bpm_request_op_time` int(11) NOT NULL,
  PRIMARY KEY (`bpm_request_op_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `resource` */

DROP TABLE IF EXISTS `resource`;

CREATE TABLE `resource` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `app_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_id` (`app_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `resource_role` */

DROP TABLE IF EXISTS `resource_role`;

CREATE TABLE `resource_role` (
  `resource_id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  PRIMARY KEY (`resource_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `role` */

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `alias` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Table structure for table `role_priv` */

DROP TABLE IF EXISTS `role_priv`;

CREATE TABLE `role_priv` (
  `role_id` int(10) NOT NULL,
  `priv_id` int(10) NOT NULL,
  PRIMARY KEY (`role_id`,`priv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `pass` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name_pass` (`name`,`pass`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `user_role` */

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `user_id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
