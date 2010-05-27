/*
SQLyog 企业版 - MySQL GUI v7.14 
MySQL - 5.1.41 : Database - ihush_acl
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
  `is_app` enum('YES','NO') NOT NULL DEFAULT 'YES',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `app` */

LOCK TABLES `app` WRITE;

insert  into `app`(`id`,`name`,`path`,`pid`,`is_app`) values (1,'权限系统','',0,'NO'),(2,'权限管理','',1,'NO'),(3,'角色管理','/acl/rolelist',2,'YES'),(4,'用户管理','/acl/userlist',2,'YES'),(5,'资源管理','/acl/resourcelist',2,'YES'),(6,'菜单管理','/acl/applist',2,'YES'),(7,'常用工具','',0,'NO'),(8,'测试菜单','',7,'NO'),(9,'测试应用','/test/',8,'YES');

UNLOCK TABLES;

/*Table structure for table `app_role` */

DROP TABLE IF EXISTS `app_role`;

CREATE TABLE `app_role` (
  `app_id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  PRIMARY KEY (`app_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `app_role` */

LOCK TABLES `app_role` WRITE;

insert  into `app_role`(`app_id`,`role_id`) values (1,1),(1,2),(2,1),(2,2),(3,1),(4,1),(4,2),(5,1),(5,2),(6,1),(6,2),(7,1),(7,2),(7,3),(7,4),(7,5),(8,1),(8,2),(8,3),(8,4),(8,5),(9,1),(9,2),(9,3),(9,4),(9,5);

UNLOCK TABLES;

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

/*Data for the table `resource` */

LOCK TABLES `resource` WRITE;

insert  into `resource`(`id`,`app_id`,`name`,`description`) values (1,0,'acl_user_add','添加新后台用户'),(2,0,'acl_user_passwd','权限管理中密码修改');

UNLOCK TABLES;

/*Table structure for table `resource_role` */

DROP TABLE IF EXISTS `resource_role`;

CREATE TABLE `resource_role` (
  `resource_id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  PRIMARY KEY (`resource_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `resource_role` */

LOCK TABLES `resource_role` WRITE;

insert  into `resource_role`(`resource_id`,`role_id`) values (1,1),(2,1);

UNLOCK TABLES;

/*Table structure for table `role` */

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `alias` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `role` */

LOCK TABLES `role` WRITE;

insert  into `role`(`id`,`name`,`alias`) values (1,'SA','超级管理员'),(2,'AM','普通管理员'),(3,'CS','客服人员'),(4,'LS','物流人员'),(5,'FS','财务人员');

UNLOCK TABLES;

/*Table structure for table `role_priv` */

DROP TABLE IF EXISTS `role_priv`;

CREATE TABLE `role_priv` (
  `role_id` int(10) NOT NULL,
  `priv_id` int(10) NOT NULL,
  PRIMARY KEY (`role_id`,`priv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `role_priv` */

LOCK TABLES `role_priv` WRITE;

insert  into `role_priv`(`role_id`,`priv_id`) values (1,1),(1,2),(1,3),(1,4),(1,5),(2,3),(2,4),(2,5);

UNLOCK TABLES;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `pass` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name_pass` (`name`,`pass`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `user` */

LOCK TABLES `user` WRITE;

insert  into `user`(`id`,`name`,`pass`) values (2,'admin','77e2edcc9b40441200e31dc57dbb8829'),(1,'sa','788ef84d5a89a1ce91c310ec164f8d47');

UNLOCK TABLES;

/*Table structure for table `user_role` */

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `user_id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_role` */

LOCK TABLES `user_role` WRITE;

insert  into `user_role`(`user_id`,`role_id`) values (1,1),(2,2);

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
