/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50536
Source Host           : localhost:3306
Source Database       : cicms

Target Server Type    : MYSQL
Target Server Version : 50536
File Encoding         : 65001

Date: 2015-06-15 00:05:36
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `57sy_common_adminloginlog`
-- ----------------------------
DROP TABLE IF EXISTS `57sy_common_adminloginlog`;
CREATE TABLE `57sy_common_adminloginlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(16) NOT NULL COMMENT '用户名',
  `logintime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `ip` char(15) NOT NULL COMMENT '登陆的ip地址',
  PRIMARY KEY (`id`),
  KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=228 DEFAULT CHARSET=utf8 COMMENT='后台用户登陆的日志表';

-- ----------------------------
-- Records of 57sy_common_adminloginlog
-- ----------------------------
INSERT INTO 57sy_common_adminloginlog VALUES ('85', 'wangjian', '2015-01-01 21:47:52', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('86', 'wangjian', '2015-01-01 22:13:25', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('87', 'wangjian', '2015-01-01 22:48:54', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('88', 'wangjian', '2015-01-01 23:49:08', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('89', 'wangjian', '2015-01-02 00:51:05', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('90', 'wangjian', '2015-01-02 17:40:03', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('91', 'wangjian', '2015-01-02 18:40:56', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('92', 'wangjian', '2015-01-02 21:53:55', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('93', 'wangjian', '2015-01-02 22:32:19', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('94', 'wangjian', '2015-01-03 00:26:16', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('95', 'wangjian', '2015-01-03 15:27:55', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('96', 'wangjian', '2015-01-03 16:27:35', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('97', 'wangjian', '2015-01-03 17:28:32', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('98', 'wangjian', '2015-01-03 18:50:02', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('99', 'wangjian', '2015-01-03 19:31:39', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('100', 'wangjian', '2015-01-03 20:31:57', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('101', 'wangjian', '2015-01-04 21:28:43', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('102', 'wangjian', '2015-01-04 22:29:11', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('103', 'wangjian', '2015-01-04 23:30:04', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('104', 'wangjian', '2015-01-07 20:27:46', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('105', 'wangjian', '2015-01-07 21:28:33', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('106', 'wangjian', '2015-01-11 22:26:59', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('107', 'yyyyyyy', '2015-01-11 23:23:28', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('108', 'wangjian', '2015-01-11 23:23:39', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('109', 'wangjian', '2015-01-20 20:32:56', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('110', '57sy.com', '2015-01-20 20:37:29', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('111', '57sy.com', '2015-01-20 21:37:53', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('112', '57sy.com', '2015-01-20 21:42:43', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('113', 'wangjian', '2015-01-20 21:49:10', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('114', 'wangjian', '2015-01-25 11:44:47', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('115', '57sy.com', '2015-01-25 12:09:51', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('116', 'wangjian', '2015-01-25 12:45:04', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('117', 'wangjian', '2015-01-25 13:46:23', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('118', 'wangjian', '2015-01-25 13:53:55', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('119', 'wangjian', '2015-01-25 13:59:47', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('120', 'wangjian', '2015-01-25 14:00:16', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('121', 'wangjian', '2015-01-25 14:00:40', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('122', 'wangjian', '2015-01-25 14:00:53', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('123', 'wangjian', '2015-01-25 21:40:51', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('124', 'wangjian', '2015-02-06 19:19:53', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('125', 'wangjian', '2015-02-06 19:54:38', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('126', 'wangjian', '2015-02-06 19:55:41', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('127', 'wangjian', '2015-02-06 19:55:53', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('128', '57sy.com', '2015-02-14 16:10:05', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('129', '57sy.com', '2015-02-14 16:10:41', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('130', 'wangjian', '2015-02-14 16:11:42', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('131', 'wangjian', '2015-02-14 16:29:56', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('132', 'wangjian', '2015-02-17 21:15:27', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('133', 'wangjian', '2015-02-17 22:15:49', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('134', 'wangjian', '2015-02-17 23:19:10', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('135', '57sy.com', '2015-02-17 23:45:51', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('136', 'wangjian', '2015-02-17 23:48:38', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('137', 'wangjian', '2015-02-18 00:20:39', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('138', 'wangjian', '2015-02-18 11:51:50', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('139', 'wangjian', '2015-02-18 13:02:28', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('140', 'wangjian', '2015-02-18 14:17:29', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('141', 'wangjian', '2015-02-18 15:22:12', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('142', 'wangjian', '2015-02-18 16:22:27', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('143', 'wangjian', '2015-02-18 23:04:29', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('144', 'wangjian', '2015-02-19 00:06:29', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('145', 'wangjian', '2015-02-20 14:53:18', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('146', 'wangjian', '2015-02-20 15:05:32', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('147', 'wangjian', '2015-02-20 15:13:24', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('148', 'wangjian', '2015-02-21 01:18:17', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('149', 'wangjian', '2015-02-21 01:20:13', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('150', 'wangjian', '2015-02-21 01:20:42', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('151', 'wangjian', '2015-02-21 01:40:16', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('152', 'wangjian', '2015-02-21 02:18:55', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('153', 'wangjian', '2015-02-21 02:20:28', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('154', 'wangjian', '2015-02-21 03:20:41', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('155', 'wangjian', '2015-02-23 00:03:41', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('156', 'wangjian', '2015-02-24 00:12:20', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('157', 'wangjian', '2015-02-24 00:13:46', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('158', '57sy.com', '2015-02-24 00:14:02', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('159', '57sy.com', '2015-02-24 00:17:29', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('160', '57sy.com', '2015-02-24 00:17:45', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('161', 'wangjian', '2015-02-25 09:30:33', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('162', 'wangjian', '2015-02-25 10:41:30', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('163', 'wangjian', '2015-02-25 15:30:15', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('164', 'wangjian', '2015-02-25 15:30:18', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('165', 'wangjian', '2015-02-25 15:38:08', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('166', 'wangjian', '2015-02-25 15:47:20', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('167', 'wangjian', '2015-02-25 15:47:26', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('168', 'wangjian', '2015-02-25 15:47:38', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('169', 'wangjian', '2015-02-25 15:47:51', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('170', 'wangjian', '2015-02-25 15:48:29', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('171', 'wangjian', '2015-02-25 15:49:17', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('172', 'wangjian', '2015-02-25 15:50:24', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('173', 'wangjian', '2015-02-25 15:59:26', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('174', 'wangjian', '2015-02-25 17:05:30', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('175', 'wangjian', '2015-02-26 09:24:55', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('176', 'wangjian', '2015-02-26 11:21:43', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('177', 'wangjian', '2015-02-26 14:37:23', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('178', 'wangjian', '2015-02-26 15:38:51', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('179', 'wangjian', '2015-02-26 16:39:53', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('180', 'wangjian', '2015-02-27 16:00:45', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('181', 'wangjian', '2015-02-27 17:05:15', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('182', 'wangjian', '2015-03-23 23:31:29', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('183', 'wangjian', '2015-03-24 21:18:21', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('184', 'wangjian', '2015-03-24 22:27:00', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('185', 'wangjian', '2015-03-26 22:08:34', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('186', '57sy.com', '2015-03-26 22:09:10', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('187', '57sy.com', '2015-04-12 16:59:30', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('188', 'wangjian', '2015-04-12 16:59:39', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('189', 'wangjian', '2015-05-26 00:06:12', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('190', '57sy.com', '2015-06-11 21:28:52', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('191', 'wangjian', '2015-06-11 21:29:00', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('192', 'wangjian', '2015-06-11 21:41:16', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('193', 'wangjian', '2015-06-11 21:41:34', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('194', 'wangjian', '2015-06-11 21:42:03', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('195', 'wangjian', '2015-06-11 21:42:26', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('196', 'wangjian', '2015-06-11 21:42:35', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('197', 'wangjian', '2015-06-11 21:43:58', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('198', 'wangjian', '2015-06-11 21:44:07', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('199', 'wangjian', '2015-06-11 21:45:47', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('200', 'wangjian', '2015-06-11 21:50:48', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('201', 'wangjian', '2015-06-11 21:51:58', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('202', 'wangjian', '2015-06-11 21:53:16', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('203', 'wangjian', '2015-06-11 21:59:11', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('204', 'wangjian', '2015-06-11 21:59:22', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('205', 'wangjian', '2015-06-11 22:01:05', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('206', 'wangjian', '2015-06-11 22:12:54', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('207', 'wangjian', '2015-06-11 22:13:17', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('208', 'wangjian', '2015-06-11 22:13:31', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('209', 'wangjian', '2015-06-11 22:13:45', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('210', 'wangjian', '2015-06-11 22:14:29', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('211', 'wangjian', '2015-06-11 22:15:54', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('212', 'wangjian', '2015-06-11 22:16:54', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('213', 'wangjian', '2015-06-12 09:49:51', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('214', 'wangjian', '2015-06-12 09:50:26', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('215', 'wangjian', '2015-06-12 09:50:42', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('216', 'wangjian', '2015-06-12 10:12:49', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('217', 'wangjian', '2015-06-12 21:51:51', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('218', 'wangjian', '2015-06-12 22:32:53', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('219', 'wangjian', '2015-06-12 23:17:22', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('220', 'wangjian', '2015-06-12 23:17:31', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('221', '57sy.com', '2015-06-12 23:48:33', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('222', 'wangjian', '2015-06-13 13:19:20', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('223', 'wangjian', '2015-06-13 14:19:30', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('224', 'wangjian', '2015-06-13 15:20:33', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('225', 'wangjian', '2015-06-14 21:29:40', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('226', 'wangjian', '2015-06-14 22:29:49', '127.0.0.1');
INSERT INTO 57sy_common_adminloginlog VALUES ('227', 'wangjian', '2015-06-14 23:30:03', '127.0.0.1');

-- ----------------------------
-- Table structure for `57sy_common_admin_nav`
-- ----------------------------
DROP TABLE IF EXISTS `57sy_common_admin_nav`;
CREATE TABLE `57sy_common_admin_nav` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL COMMENT '导航名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1开启 0关闭',
  `pid` mediumint(8) NOT NULL DEFAULT '0' COMMENT '父级id',
  `addtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `disorder` smallint(6) NOT NULL DEFAULT '0',
  `url` varchar(60) DEFAULT NULL COMMENT 'url地址',
  `path` varchar(255) DEFAULT '0' COMMENT 'id直接字符串结合',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=148 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 57sy_common_admin_nav
-- ----------------------------
INSERT INTO 57sy_common_admin_nav VALUES ('21', '系统管理', '1', '0', '2014-02-03 17:29:36', '1', 'max_1', '0');
INSERT INTO 57sy_common_admin_nav VALUES ('22', '模块管理', '1', '0', '2014-02-03 17:29:47', '12', 'max_3', '0');
INSERT INTO 57sy_common_admin_nav VALUES ('23', '后台导航管理', '1', '21', '0000-00-00 00:00:00', '2', 't_nav', '0-21');
INSERT INTO 57sy_common_admin_nav VALUES ('30', '导航列表', '1', '23', '0000-00-00 00:00:00', '1', 'nav/index/', '0-21-23');
INSERT INTO 57sy_common_admin_nav VALUES ('31', '导航添加', '1', '30', '0000-00-00 00:00:00', '13', 'nav/add/', '0-21-23-30');
INSERT INTO 57sy_common_admin_nav VALUES ('40', '导航编辑', '1', '30', '2014-02-28 00:57:00', '14', 'nav/edit/', '0-21-23-30');
INSERT INTO 57sy_common_admin_nav VALUES ('58', '角色配置', '1', '66', '2014-02-28 16:01:13', '7', 'role/index/', '0-21-66');
INSERT INTO 57sy_common_admin_nav VALUES ('59', '后台用户', '1', '66', '2014-03-01 00:59:50', '11', 'sys_admin/index/', '0-21-66');
INSERT INTO 57sy_common_admin_nav VALUES ('60', '后台用户添加', '1', '59', '2014-03-01 02:20:33', '4', 'sys_admin/add/', '0-21-66-59');
INSERT INTO 57sy_common_admin_nav VALUES ('61', '角色编辑', '1', '58', '2014-03-02 23:48:47', '3', 'role/edit/', '0-21-66-58');
INSERT INTO 57sy_common_admin_nav VALUES ('62', '后台用户编辑', '1', '59', '2014-03-02 23:50:01', '5', 'sys_admin/edit', '0-21-66-59');
INSERT INTO 57sy_common_admin_nav VALUES ('64', '日志管理', '1', '21', '2014-03-03 03:45:48', '4', 't_log', '0-21');
INSERT INTO 57sy_common_admin_nav VALUES ('65', 'log列表', '1', '64', '2014-03-03 03:52:28', '90', 'log/index/', '0-21-64');
INSERT INTO 57sy_common_admin_nav VALUES ('66', '后台团队', '1', '21', '2014-03-03 20:52:59', '3', 't_houtai_tuandui', '0-21');
INSERT INTO 57sy_common_admin_nav VALUES ('67', '网站基本信息', '1', '21', '2014-03-03 20:55:11', '1', 't_webinfo', '0-21');
INSERT INTO 57sy_common_admin_nav VALUES ('68', '系统基本参数', '1', '67', '2014-03-03 20:56:28', '1', 'sysconfig/index/', '0-21-67');
INSERT INTO 57sy_common_admin_nav VALUES ('69', '系统参数添加', '1', '68', '2014-03-03 22:40:03', '2', 'sysconfig/add/', '0-21-67-68');
INSERT INTO 57sy_common_admin_nav VALUES ('70', '修改基本参数', '1', '68', '2014-03-04 00:33:16', '5', 'sysconfig/edit/', '0-21-67-68');
INSERT INTO 57sy_common_admin_nav VALUES ('71', '系统帮助', '1', '21', '2014-03-05 16:53:42', '10000', '', '0-21');
INSERT INTO 57sy_common_admin_nav VALUES ('72', 'bug反馈', '1', '71', '2014-03-05 16:54:15', '1', 'http://www.57sy.com', '0-21-71');
INSERT INTO 57sy_common_admin_nav VALUES ('73', '欢迎页面', '1', '67', '2014-03-06 17:34:59', '0', 'admin/main/', '0-21-67');
INSERT INTO 57sy_common_admin_nav VALUES ('95', '广告管理', '1', '22', '2014-06-12 14:00:51', '7', 't_ad', '0-22');
INSERT INTO 57sy_common_admin_nav VALUES ('96', '广告列表', '1', '95', '2014-06-12 14:01:42', '1', 'ad/index/', '0-22-95');
INSERT INTO 57sy_common_admin_nav VALUES ('97', '广告类型', '1', '95', '2014-06-12 14:02:20', '3', 'adtype/index/', '0-22-95');
INSERT INTO 57sy_common_admin_nav VALUES ('98', '类型添加', '1', '97', '2014-06-12 14:28:25', '1', 'adtype/add/', '0-22-95-97');
INSERT INTO 57sy_common_admin_nav VALUES ('99', '类型编辑', '1', '97', '2014-06-12 14:28:42', '2', 'adtype/edit/', '0-22-95-97');
INSERT INTO 57sy_common_admin_nav VALUES ('100', '广告类型删除', '1', '97', '2014-06-12 14:37:51', '5', 'adtype/del', '0-22-95-97');
INSERT INTO 57sy_common_admin_nav VALUES ('101', '广告添加', '1', '96', '2014-06-12 14:47:02', '1', 'ad/add/', '0-22-95-96');
INSERT INTO 57sy_common_admin_nav VALUES ('102', '广告编辑', '1', '96', '2014-06-12 16:17:21', '5', 'ad/edit/', '0-22-95-96');
INSERT INTO 57sy_common_admin_nav VALUES ('103', '广告删除', '1', '96', '2014-06-12 16:19:28', '6', 'ad/del/', '0-22-95-96');
INSERT INTO 57sy_common_admin_nav VALUES ('135', '系统基本参数删除', '1', '68', '2015-01-01 23:50:41', '8', 'sysconfig/del/', '0-21-67-68');
INSERT INTO 57sy_common_admin_nav VALUES ('128', '导航删除', '1', '30', '2015-01-01 20:57:05', '2', 'nav/del/', '0-21-23-30');
INSERT INTO 57sy_common_admin_nav VALUES ('136', '后台用户密码修改', '1', '59', '2015-01-11 22:49:01', '3', 'sys_admin/passwd', '0-21-66-59');
INSERT INTO 57sy_common_admin_nav VALUES ('137', '更新站点缓存', '1', '67', '2015-02-25 10:44:10', '3', 'cache/index', '0-21-67');
INSERT INTO 57sy_common_admin_nav VALUES ('138', '网站用户', '1', '22', '2015-02-26 14:39:34', '3', 't_member', '0-22');
INSERT INTO 57sy_common_admin_nav VALUES ('139', '用户列表', '1', '138', '2015-02-26 14:40:22', '1', 'member/index', '0-22-138');
INSERT INTO 57sy_common_admin_nav VALUES ('140', '新闻管理', '1', '22', '2015-06-13 13:38:41', '10', 'news/index', '0-22');
INSERT INTO 57sy_common_admin_nav VALUES ('141', '新闻列表', '1', '140', '2015-06-13 13:39:19', '1', 'news/index', '0-22-140');
INSERT INTO 57sy_common_admin_nav VALUES ('142', '新闻类别', '1', '140', '2015-06-13 13:41:35', '2', 'newstype/index', '0-22-140');
INSERT INTO 57sy_common_admin_nav VALUES ('143', '新闻类别添加', '1', '142', '2015-06-13 14:13:54', '1', 'newstype/add', '0-22-140-142');
INSERT INTO 57sy_common_admin_nav VALUES ('144', '新闻类别编辑', '1', '142', '2015-06-13 15:08:19', '3', 'newstype/edit', '0-22-140-142');
INSERT INTO 57sy_common_admin_nav VALUES ('145', '新闻添加', '1', '141', '2015-06-14 21:43:20', '1', 'news/add', '0-22-140-141');
INSERT INTO 57sy_common_admin_nav VALUES ('146', '新闻修改', '1', '141', '2015-06-14 23:17:20', '3', 'news/edit', '0-22-140-141');
INSERT INTO 57sy_common_admin_nav VALUES ('147', '新闻删除', '1', '141', '2015-06-14 23:59:39', '5', 'news/del', '0-22-140-141');

-- ----------------------------
-- Table structure for `57sy_common_category_data`
-- ----------------------------
DROP TABLE IF EXISTS `57sy_common_category_data`;
CREATE TABLE `57sy_common_category_data` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `pid` mediumint(8) unsigned NOT NULL,
  `typeid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `typename` varchar(30) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 开启 0 关闭',
  `disorder` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `seotitle` varchar(100) NOT NULL COMMENT 'seo标题',
  `keywords` varchar(100) NOT NULL COMMENT '关键词',
  `description` varchar(100) NOT NULL COMMENT '栏目描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45062 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 57sy_common_category_data
-- ----------------------------

-- ----------------------------
-- Table structure for `57sy_common_category_type`
-- ----------------------------
DROP TABLE IF EXISTS `57sy_common_category_type`;
CREATE TABLE `57sy_common_category_type` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `cname` varchar(30) NOT NULL COMMENT '分类名称',
  `addtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加日期',
  `addperson` varchar(30) NOT NULL COMMENT '添加人',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1开启 0 关闭',
  `modifytime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改日期',
  `remark` varchar(200) NOT NULL COMMENT '备注说明',
  PRIMARY KEY (`id`),
  KEY `cname` (`cname`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 57sy_common_category_type
-- ----------------------------

-- ----------------------------
-- Table structure for `57sy_common_log_201506`
-- ----------------------------
DROP TABLE IF EXISTS `57sy_common_log_201506`;
CREATE TABLE `57sy_common_log_201506` (
  `log_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `log_url` varchar(50) NOT NULL,
  `log_person` varchar(16) NOT NULL,
  `log_time` datetime NOT NULL,
  `log_ip` char(15) NOT NULL,
  `log_sql` text NOT NULL,
  `log_status` tinyint(1) NOT NULL DEFAULT '1',
  `log_message` text NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 57sy_common_log_201506
-- ----------------------------
INSERT INTO 57sy_common_log_201506 VALUES ('1', 'news/add', 'wangjian', '2015-06-15 00:04:52', '127.0.0.1', 'INSERT INTO `57sy_extra_news` (`title`, `keysword`, `introduce`, `weight`, `content`, `status`, `create_date`, `modify_date`, `flag`, `click`, `typeid`, `addperson`, `image`) VALUES (\'cscc\', \'cczxc\', \'zxczxc&amp;lt;br /&amp;gt;\', 0, \'zxczxc&lt;br /&gt;\', 1, 1434297886, 1434297886, \'\', 0, 1, \'wangjian\', \'20150615/143429789221499.jpg\')', '1', '添加名称为cscc成功');

-- ----------------------------
-- Table structure for `57sy_common_role`
-- ----------------------------
DROP TABLE IF EXISTS `57sy_common_role`;
CREATE TABLE `57sy_common_role` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `rolename` varchar(20) DEFAULT NULL COMMENT '角色名称',
  `addtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加日期',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `perm` text COMMENT '对应的权限',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 57sy_common_role
-- ----------------------------
INSERT INTO 57sy_common_role VALUES ('8', '系统管理', '2014-05-07 10:24:32', '1', 'a:12:{i:0;s:9:\"t_webinfo\";i:1;s:11:\"main/index/\";i:2;s:16:\"sysconfig/index/\";i:3;s:14:\"sysconfig/add/\";i:4;s:5:\"t_nav\";i:5;s:10:\"nav/index/\";i:6;s:6:\"t_news\";i:7;s:11:\"news/index/\";i:8;s:15:\"newstype/index/\";i:9;s:0:\"\";i:10;s:9:\"ad/index/\";i:11;s:13:\"adtype/index/\";}');
INSERT INTO 57sy_common_role VALUES ('9', '查看角色', '2014-06-19 09:30:25', '1', 'a:6:{i:0;s:5:\"t_nav\";i:1;s:10:\"nav/index/\";i:2;s:5:\"t_log\";i:3;s:10:\"log/index/\";i:4;s:9:\"t_product\";i:5;s:14:\"product/index/\";}');
INSERT INTO 57sy_common_role VALUES ('10', '编辑组', '2015-01-02 18:09:10', '1', null);
INSERT INTO 57sy_common_role VALUES ('11', '产品组', '2015-01-02 18:12:14', '1', null);
INSERT INTO 57sy_common_role VALUES ('12', '技术部', '2015-01-02 18:12:50', '1', null);
INSERT INTO 57sy_common_role VALUES ('13', '老板组', '2015-01-02 18:13:03', '1', null);
INSERT INTO 57sy_common_role VALUES ('14', '老师组', '2015-01-02 18:13:10', '1', null);
INSERT INTO 57sy_common_role VALUES ('15', '学生组', '2015-01-02 18:13:18', '1', null);
INSERT INTO 57sy_common_role VALUES ('16', '班长组', '2015-01-02 18:13:26', '1', null);
INSERT INTO 57sy_common_role VALUES ('17', 'php工程师组', '2015-01-02 18:13:35', '1', 'a:38:{i:0;s:5:\"max_1\";i:1;s:9:\"t_webinfo\";i:2;s:11:\"admin/main/\";i:3;s:16:\"sysconfig/index/\";i:4;s:14:\"sysconfig/add/\";i:5;s:15:\"sysconfig/edit/\";i:6;s:14:\"sysconfig/del/\";i:7;s:5:\"t_nav\";i:8;s:10:\"nav/index/\";i:9;s:8:\"nav/del/\";i:10;s:8:\"nav/add/\";i:11;s:9:\"nav/edit/\";i:12;s:16:\"t_houtai_tuandui\";i:13;s:11:\"role/index/\";i:14;s:10:\"role/edit/\";i:15;s:16:\"sys_admin/index/\";i:16;s:14:\"sys_admin/add/\";i:17;s:14:\"sys_admin/edit\";i:18;s:5:\"t_log\";i:19;s:10:\"log/index/\";i:20;s:7:\"t_model\";i:21;s:15:\"category/index/\";i:22;s:13:\"category/add/\";i:23;s:14:\"category/edit/\";i:24;s:20:\"category_data/index/\";i:25;s:18:\"category_data/add/\";i:26;s:19:\"category_data/edit/\";i:27;s:0:\"\";i:28;s:19:\"http://www.57sy.com\";i:29;s:4:\"t_ad\";i:30;s:9:\"ad/index/\";i:31;s:7:\"ad/add/\";i:32;s:8:\"ad/edit/\";i:33;s:7:\"ad/del/\";i:34;s:13:\"adtype/index/\";i:35;s:11:\"adtype/add/\";i:36;s:12:\"adtype/edit/\";i:37;s:10:\"adtype/del\";}');
INSERT INTO 57sy_common_role VALUES ('18', 'js工程师组', '2015-01-02 18:13:43', '1', 'a:23:{i:0;s:5:\"max_1\";i:1;s:9:\"t_webinfo\";i:2;s:11:\"admin/main/\";i:3;s:16:\"sysconfig/index/\";i:4;s:14:\"sysconfig/add/\";i:5;s:15:\"sysconfig/edit/\";i:6;s:14:\"sysconfig/del/\";i:7;s:5:\"t_nav\";i:8;s:10:\"nav/index/\";i:9;s:8:\"nav/del/\";i:10;s:8:\"nav/add/\";i:11;s:9:\"nav/edit/\";i:12;s:16:\"t_houtai_tuandui\";i:13;s:11:\"role/index/\";i:14;s:16:\"sys_admin/index/\";i:15;s:14:\"sys_admin/add/\";i:16;s:14:\"sys_admin/edit\";i:17;s:5:\"max_3\";i:18;s:4:\"t_ad\";i:19;s:9:\"ad/index/\";i:20;s:7:\"ad/del/\";i:21;s:13:\"adtype/index/\";i:22;s:10:\"adtype/del\";}');
INSERT INTO 57sy_common_role VALUES ('19', 'php程序员7', '2015-01-02 18:52:10', '0', 'a:18:{i:0;s:5:\"max_1\";i:1;s:9:\"t_webinfo\";i:2;s:11:\"admin/main/\";i:3;s:5:\"t_nav\";i:4;s:10:\"nav/index/\";i:5;s:8:\"nav/del/\";i:6;s:8:\"nav/add/\";i:7;s:9:\"nav/edit/\";i:8;s:16:\"t_houtai_tuandui\";i:9;s:11:\"role/index/\";i:10;s:10:\"role/edit/\";i:11;s:16:\"sys_admin/index/\";i:12;s:14:\"sys_admin/add/\";i:13;s:14:\"sys_admin/edit\";i:14;s:5:\"t_log\";i:15;s:10:\"log/index/\";i:16;s:0:\"\";i:17;s:19:\"http://www.57sy.com\";}');
INSERT INTO 57sy_common_role VALUES ('20', 'ccccc', '2015-02-26 16:40:57', '1', null);

-- ----------------------------
-- Table structure for `57sy_common_session`
-- ----------------------------
DROP TABLE IF EXISTS `57sy_common_session`;
CREATE TABLE `57sy_common_session` (
  `username` varchar(50) DEFAULT '',
  `time` varchar(14) DEFAULT '',
  `userid` int(11) NOT NULL DEFAULT '0',
  `session_id` text NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `userid` (`userid`) USING BTREE,
  FULLTEXT KEY `session_id` (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 57sy_common_session
-- ----------------------------
INSERT INTO 57sy_common_session VALUES ('wangjian', '1434117111', '1', '2750hFWs0aKFY1b/MTjZiR4tUY8SR6y8FxCCby2hK/GRdE43A5xirdSt/PZHSKdb9lYgmgNLoyr1/MsKfBTzfXCO4CJeAeLf05E0GaZa4sYdokay+SoqBbWAEPKLwzQ+wLAT5THAhOOR5PWMCY2TKuQwVTf8RH1eJQ/GQ2ybikt3AbrjRzbITaOHVIs+wN8wxrLYOBXD699BRcJUy606Wwmuq1SZQA');
INSERT INTO 57sy_common_session VALUES ('57sy.com', '1434124113', '17', 'ea76MHaBJP6xu/IMKcVz5ZpBPtmc/jEKFVfeZdRsCk/y+ObdCmt+6fw6MdbkDJiwD7GFydegmIwotZHMdwxt4CbUcKgN8/4LTYOTJQL1z726DlmPpUurJwRed0YvXJtc/fKeontI6+VeLMElsClkAn4/W1uiuCU1q7rDveJz9tulnrKeGfOqsEcHqmpRyFfBglTe68RrvUjWbUp/Z6D0AokH9nRXcLtD');

-- ----------------------------
-- Table structure for `57sy_common_sysconfig`
-- ----------------------------
DROP TABLE IF EXISTS `57sy_common_sysconfig`;
CREATE TABLE `57sy_common_sysconfig` (
  `varname` varchar(20) DEFAULT NULL,
  `value` text,
  `info` varchar(100) DEFAULT NULL COMMENT '说明',
  `groupid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `type` varchar(10) NOT NULL DEFAULT 'string' COMMENT '变量类型',
  `disorder` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  UNIQUE KEY `varname` (`varname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统配置信息表';

-- ----------------------------
-- Records of 57sy_common_sysconfig
-- ----------------------------
INSERT INTO 57sy_common_sysconfig VALUES ('cfg_tu', '300', '缩略图默认宽度', '3', 'string', '0');
INSERT INTO 57sy_common_sysconfig VALUES ('cfg_isopen_huiyuan', 'Y', '是否开启会员功能', '2', 'boolean', '0');
INSERT INTO 57sy_common_sysconfig VALUES ('web_site_status', 'Y', '站点是否开启', '1', 'boolean', '1');
INSERT INTO 57sy_common_sysconfig VALUES ('web_site_name', 'cms内容管理系统', '网站标题', '1', 'string', '3');
INSERT INTO 57sy_common_sysconfig VALUES ('var_close_reason', '网站升级中。。。。。。。', '关闭原因', '1', 'textarea', '4');

-- ----------------------------
-- Table structure for `57sy_common_system_user`
-- ----------------------------
DROP TABLE IF EXISTS `57sy_common_system_user`;
CREATE TABLE `57sy_common_system_user` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(16) NOT NULL COMMENT '后台管理的用户名',
  `nick` varchar(50) DEFAULT NULL COMMENT '昵称',
  `passwd` char(32) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `gid` smallint(8) unsigned NOT NULL DEFAULT '0' COMMENT '属于哪个群组',
  `addtime` datetime NOT NULL COMMENT '添加日期',
  `super_admin` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否是超级管理员 1是有一切权限 0不是需要配置权限',
  `perm` text COMMENT '用户的其他权限',
  `login_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 57sy_common_system_user
-- ----------------------------
INSERT INTO 57sy_common_system_user VALUES ('1', 'wangjian', null, '44bc64daf3c37a7ada23e63a137310bd', '1', '2', '0000-00-00 00:00:00', '1', '', '97');
INSERT INTO 57sy_common_system_user VALUES ('16', 'tttttt123', null, '44bc64daf3c37a7ada23e63a137310bd', '1', '0', '2015-01-04 23:14:07', '0', 'a:1:{i:0;s:15:\"sysconfig/edit/\";}', '0');
INSERT INTO 57sy_common_system_user VALUES ('3', 'taotao', null, '44bc64daf3c37a7ada23e63a137310bd', '1', '9', '2014-03-01 02:07:15', '0', '', '0');
INSERT INTO 57sy_common_system_user VALUES ('4', 'haohao91', null, 'wangjian', '1', '2', '2014-03-01 02:07:36', '0', '', '0');
INSERT INTO 57sy_common_system_user VALUES ('5', '陪陪12', null, 'wangjian', '1', '3', '2014-03-01 02:08:27', '0', '', '0');
INSERT INTO 57sy_common_system_user VALUES ('6', 'caiying', null, '44bc64daf3c37a7ada23e63a137310bd', '1', '3', '2014-03-01 15:23:30', '0', '', '0');
INSERT INTO 57sy_common_system_user VALUES ('7', 'lili', null, '98781d5569adb6555e15f5194c149483', '1', '1', '2014-03-01 15:25:50', '0', '', '0');
INSERT INTO 57sy_common_system_user VALUES ('8', '5555', null, '5b1b68a9abf4d2cd155c81a9225fd158', '1', '3', '2014-03-01 15:26:39', '0', 'a:1:{i:0;s:8:\"dd/list/\";}', '0');
INSERT INTO 57sy_common_system_user VALUES ('9', '3334441', null, 'dcb64c94e1b81cd1cd3eb4a73ad27d99', '1', '1', '2014-03-01 15:27:01', '0', 'a:1:{i:0;s:3:\"555\";}', '0');
INSERT INTO 57sy_common_system_user VALUES ('10', 'lili_', null, '44bc64daf3c37a7ada23e63a137310bd', '1', '3', '2014-03-02 10:05:43', '0', '', '0');
INSERT INTO 57sy_common_system_user VALUES ('11', 'yang', null, '44bc64daf3c37a7ada23e63a137310bd', '1', '3', '2014-03-02 10:05:53', '0', '', '0');
INSERT INTO 57sy_common_system_user VALUES ('12', 'feifei', null, '44bc64daf3c37a7ada23e63a137310bd', '1', '3', '2014-03-02 10:06:04', '0', '', '0');
INSERT INTO 57sy_common_system_user VALUES ('13', '5567777', null, '3d2172418ce305c7d16d4b05597c6a59', '0', '2', '2014-03-03 03:35:51', '0', 'a:1:{i:0;s:11:\"role/index/\";}', '0');
INSERT INTO 57sy_common_system_user VALUES ('14', 'tttttt', null, '44bc64daf3c37a7ada23e63a137310bd', '1', '8', '2014-05-07 10:15:37', '0', '', '0');
INSERT INTO 57sy_common_system_user VALUES ('15', 'yyyyyyy', null, 'e10adc3949ba59abbe56e057f20f883e', '1', '0', '2014-05-07 10:18:27', '1', null, '0');
INSERT INTO 57sy_common_system_user VALUES ('17', '57sy.com', null, '44bc64daf3c37a7ada23e63a137310bd', '1', '18', '2015-01-04 23:16:35', '0', '', '10');
INSERT INTO 57sy_common_system_user VALUES ('18', 'xiaoli', null, '11ddbaf3386aea1f2974eee984542152', '1', '0', '2015-01-11 23:35:24', '0', 'a:1:{i:0;s:14:\"sys_admin/add/\";}', '0');
INSERT INTO 57sy_common_system_user VALUES ('19', 'gggggg', '1111', '60d25c2d918be5f46443a81ac1ae5f87', '1', '20', '2015-06-11 22:15:42', '0', '', '0');
INSERT INTO 57sy_common_system_user VALUES ('20', 'sasaasa', '碉堡了的1', 'cd87cd5ef753a06ee79fc75dc7cfe66c', '1', '20', '2015-06-12 22:03:39', '0', '', '0');

-- ----------------------------
-- Table structure for `57sy_common_user`
-- ----------------------------
DROP TABLE IF EXISTS `57sy_common_user`;
CREATE TABLE `57sy_common_user` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(16) NOT NULL COMMENT '用户名',
  `passwd` char(32) NOT NULL COMMENT '密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1正常0失效',
  `regdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册日期',
  `expire` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '过期日期 0永久',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='网站用户表';

-- ----------------------------
-- Records of 57sy_common_user
-- ----------------------------
INSERT INTO 57sy_common_user VALUES ('1', 'webuser', '44bc64daf3c37a7ada23e63a137310bd', '1', '1399082867', '0');
INSERT INTO 57sy_common_user VALUES ('2', 'taotao', '44bc64daf3c37a7ada23e63a137310bd', '1', '1399083755', '1399170120');
INSERT INTO 57sy_common_user VALUES ('3', 'haohao', '44bc64daf3c37a7ada23e63a137310bd', '1', '1399083888', '0');
INSERT INTO 57sy_common_user VALUES ('4', 'aojiao', 'd108ea09b955e95d68a9668a2b9c9443', '1', '1399083913', '1399861500');
INSERT INTO 57sy_common_user VALUES ('5', '1233', '78bf4f00f81a36b57950e239f1df91c1', '1', '1399085460', '0');
INSERT INTO 57sy_common_user VALUES ('6', '45666', 'b35b31a24acc2da3bd9e3feb30fc7e79', '1', '1399085469', '0');
INSERT INTO 57sy_common_user VALUES ('8', '566yyy', '8523109c9a85dbfc46eb1f46955b5449', '1', '1399085486', '0');
INSERT INTO 57sy_common_user VALUES ('10', '5345', 'a2b45e7eaa7a1376c3fb1b13fd31620b', '1', '1399085657', '0');
INSERT INTO 57sy_common_user VALUES ('11', 'mytest', '11c5587af2863955b7c04c59a8732ccc', '1', '1399085666', '0');
INSERT INTO 57sy_common_user VALUES ('12', '45rere', 'fdf4511ac15862ff29a861c389dede90', '0', '1399085706', '0');
INSERT INTO 57sy_common_user VALUES ('13', 'wangjian', '44bc64daf3c37a7ada23e63a137310bd', '1', '1424917192', '0');
INSERT INTO 57sy_common_user VALUES ('14', 'yanghhhjjj', '44bc64daf3c37a7ada23e63a137310bd', '1', '1424918043', '0');
INSERT INTO 57sy_common_user VALUES ('15', 'yanghhhjjjtt', '44bc64daf3c37a7ada23e63a137310bd', '1', '1424918079', '0');
INSERT INTO 57sy_common_user VALUES ('16', 'test001', '44bc64daf3c37a7ada23e63a137310bd', '1', '2015', '0');
INSERT INTO 57sy_common_user VALUES ('17', 'test002', '44bc64daf3c37a7ada23e63a137310bd', '1', '2015', '1424935423');
INSERT INTO 57sy_common_user VALUES ('18', 'oo9911', '44bc64daf3c37a7ada23e63a137310bd', '1', '1424937661', '0');
INSERT INTO 57sy_common_user VALUES ('19', 'oo99112', '44bc64daf3c37a7ada23e63a137310bd', '1', '1424937665', '0');
INSERT INTO 57sy_common_user VALUES ('20', 'oo991124', '44bc64daf3c37a7ada23e63a137310bd', '1', '1424937669', '0');
INSERT INTO 57sy_common_user VALUES ('21', 'oo9911246', '44bc64daf3c37a7ada23e63a137310bd', '1', '1424937679', '0');
INSERT INTO 57sy_common_user VALUES ('22', 'oo991124666', '44bc64daf3c37a7ada23e63a137310bd', '1', '1424937709', '0');
INSERT INTO 57sy_common_user VALUES ('23', 'ffffff', 'eed8cdc400dfd4ec85dff70a170066b7', '1', '1427209208', '0');
INSERT INTO 57sy_common_user VALUES ('24', 'ffffff5', 'eed8cdc400dfd4ec85dff70a170066b7', '1', '1427209216', '0');
INSERT INTO 57sy_common_user VALUES ('25', 'xiaoli123', '44bc64daf3c37a7ada23e63a137310bd', '1', '1427209228', '0');
INSERT INTO 57sy_common_user VALUES ('26', '777777', 'f63f4fbc9f8c85d409f2f59f2b9e12d5', '1', '1427210196', '0');

-- ----------------------------
-- Table structure for `57sy_extra_ad`
-- ----------------------------
DROP TABLE IF EXISTS `57sy_extra_ad`;
CREATE TABLE `57sy_extra_ad` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '广告名称',
  `pic` varchar(200) DEFAULT NULL COMMENT '广告图片地址',
  `pic2` varchar(255) DEFAULT NULL COMMENT '第2张图片',
  `pic_des` varchar(200) DEFAULT NULL COMMENT '图片描述',
  `pic_url` varchar(255) DEFAULT NULL COMMENT '图片指向地址',
  `words` text COMMENT '这个地方当广告是文字类型的时候标示文字描述',
  `ad_type` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '和广告类别对应',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0图片广告1文字广告',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1开启0关闭',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加日期',
  `begin_date` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开始日期',
  `end_date` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '结束日期',
  `add_person` varchar(20) NOT NULL COMMENT '添加者',
  `attr_1` varchar(255) DEFAULT NULL COMMENT '属性1',
  `attr_2` varchar(255) DEFAULT NULL COMMENT '广告属性2',
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 57sy_extra_ad
-- ----------------------------
INSERT INTO 57sy_extra_ad VALUES ('18', '首页广告', '142445444719412.jpg', '142445444719412.jpg', '测试图片', 'http://www.57sy.com', '55', '23', '0', '0', '1424454447', '2015', '2015', 'wangjian', '111', '错错错');
INSERT INTO 57sy_extra_ad VALUES ('19', '首页广告', '23/142485594622379.jpg', '23/1424855946223791.jpg', '测试图片', 'http://www.57sy.com', '', '23', '0', '1', '1424454927', '2015', '2015', 'wangjian', '111', '反反复复');
INSERT INTO 57sy_extra_ad VALUES ('20', '首页广告', '142445503323964.jpg', '1424455033239641.jpg', '44555', 'http://www.57sy.com', '', '15', '0', '1', '1424455033', '1424109366', '1424282169', 'wangjian', '巴巴爸爸', 'ad');
INSERT INTO 57sy_extra_ad VALUES ('21', '66777', '142445506621370.jpg', '1424455066213701.jpg', '56565', '56', '', '16', '0', '1', '1424455066', '1422727059', '1424455063', 'wangjian', 'hhjjj', 'jyyy');
INSERT INTO 57sy_extra_ad VALUES ('22', '首页右边的广告', '142445511614216.jpg', '1424455116142161.jpg', '描述信息', 'http://www.57sy.com', '', '12', '0', '0', '1424455116', '1424023109', '1424282312', 'wangjian', '存储vv', '232323');
INSERT INTO 57sy_extra_ad VALUES ('23', '文字广告', '', '', '', '', '文字广告描述', '4', '1', '1', '1424457073', '1420396264', '1423506669', 'wangjian', 'test_001', '文字，，，');
INSERT INTO 57sy_extra_ad VALUES ('24', '习近平挥棒打虎卡通形', '142445720123641.jpg', '1424457201236411.jpg', '习近平挥棒打虎卡通形', 'http://news.qq.com/', '', '18', '0', '1', '1424457201', '1422815594', '1424889197', 'wangjian', '22', '222');
INSERT INTO 57sy_extra_ad VALUES ('25', '全国201个城市空气质量超标 烟花燃放致重污染', '', '', '', '', '综合新华社电 燃放烟花爆竹是我国春节的传统习俗，但也加剧了空气污染。中国环境监测总站消息显示，受到集中燃放烟花爆竹的影响，18日夜间至19日白天，全国201个城市的空气质量超标，其中40多个城市空气为重度污染。  中国环境监测总站工作人员介绍，京津冀地区空气质量受到烟花爆竹影响较为明显，PM2.5浓度在18日21时以及19日凌晨2时分别形成峰值，正是对应了烟花爆竹集中燃放的时段。  在烟花爆竹燃放结束后，从凌晨3时后PM2.5浓度出现快速下降，所以进一步验证了PM2.5浓度升高是由于烟花爆竹集中燃放引起的。  全国其他污染较重城市主要分布在东北、华北、四川、甘肃等地，包括辽宁沈阳、辽阳，黑龙江哈尔滨，内蒙', '8', '1', '1', '1424457259', '1422815653', '1424457256', 'wangjian', '12搜索', '反反复复');
INSERT INTO 57sy_extra_ad VALUES ('26', '撒旦', '', '', '', '', '大', '23', '1', '1', '1424457349', '1424716543', '1426185346', 'wangjian', '爱的', '爱的');
INSERT INTO 57sy_extra_ad VALUES ('27', '323232', '', '23/142462390010049.jpg', '', 'http://www.57sy.com', '', '23', '0', '1', '1424457354', '1422723116', '1425055919', 'wangjian', '', '');
INSERT INTO 57sy_extra_ad VALUES ('38', '5555广告歌\'', '6/142462258913857.jpg', '6/142462351328494.jpg', '他他他', 'http://www.baidu.com', '文字描述', '6', '0', '1', '1424622231', '1422723048', '1424623851', 'wangjian', '广告歌2', '古古怪怪333');
INSERT INTO 57sy_extra_ad VALUES ('39', '343434', '21/142720759225325.jpg', '21/1427207592253251.jpg', '333', '3', '', '21', '0', '1', '1427207592', '0', '0', 'wangjian', '', '');

-- ----------------------------
-- Table structure for `57sy_extra_adtype`
-- ----------------------------
DROP TABLE IF EXISTS `57sy_extra_adtype`;
CREATE TABLE `57sy_extra_adtype` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `typename` varchar(30) NOT NULL COMMENT '广告类型',
  `updatetime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改日期',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加日期',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 57sy_extra_adtype
-- ----------------------------
INSERT INTO 57sy_extra_adtype VALUES ('2', '首页广告', '1424459541', '1402553787', '1');
INSERT INTO 57sy_extra_adtype VALUES ('3', '底部广告', '1424459538', '1402553874', '1');
INSERT INTO 57sy_extra_adtype VALUES ('4', '妇女广告', '1402554563', '1402554563', '1');
INSERT INTO 57sy_extra_adtype VALUES ('5', 'test1', '1402554571', '1402554571', '1');
INSERT INTO 57sy_extra_adtype VALUES ('6', 'test2', '1402554578', '1402554578', '1');
INSERT INTO 57sy_extra_adtype VALUES ('7', 'test3', '1402554585', '1402554585', '1');
INSERT INTO 57sy_extra_adtype VALUES ('8', 'test4ww', '1424232566', '1402554598', '1');
INSERT INTO 57sy_extra_adtype VALUES ('9', 'test56611', '1424232566', '1402554605', '1');
INSERT INTO 57sy_extra_adtype VALUES ('11', '校友风采12', '1424232565', '1402554619', '1');
INSERT INTO 57sy_extra_adtype VALUES ('12', 'test9', '1424232565', '1402554626', '1');
INSERT INTO 57sy_extra_adtype VALUES ('13', 'test11ddddd', '1424232567', '1402554633', '1');
INSERT INTO 57sy_extra_adtype VALUES ('14', '恩恩33', '1424232564', '1402554647', '1');
INSERT INTO 57sy_extra_adtype VALUES ('15', '322323dd', '1424232564', '1402554653', '1');
INSERT INTO 57sy_extra_adtype VALUES ('16', '柔柔弱弱', '1424232568', '1402554685', '1');
INSERT INTO 57sy_extra_adtype VALUES ('17', 'test12', '1424232563', '1402554695', '1');
INSERT INTO 57sy_extra_adtype VALUES ('18', 'test13', '1424232563', '1402554700', '1');
INSERT INTO 57sy_extra_adtype VALUES ('19', '左边广告', '1424232568', '1402554706', '1');
INSERT INTO 57sy_extra_adtype VALUES ('20', '公告底部广告', '1424232562', '1402554713', '1');
INSERT INTO 57sy_extra_adtype VALUES ('21', '商品终端页面广告', '1424459534', '1402554723', '1');
INSERT INTO 57sy_extra_adtype VALUES ('22', '产品页面广告', '1424459533', '1424180958', '1');
INSERT INTO 57sy_extra_adtype VALUES ('23', '首页广告1', '1434294637', '1424180978', '1');

-- ----------------------------
-- Table structure for `57sy_extra_news`
-- ----------------------------
DROP TABLE IF EXISTS `57sy_extra_news`;
CREATE TABLE `57sy_extra_news` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '标题',
  `keysword` varchar(200) DEFAULT NULL COMMENT '关键词',
  `introduce` varchar(200) DEFAULT NULL COMMENT '介绍',
  `content` text COMMENT '新闻内容',
  `weight` smallint(5) unsigned DEFAULT '0' COMMENT '权重',
  `create_date` int(11) unsigned NOT NULL COMMENT '添加日期',
  `modify_date` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改日期',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1开启 0关闭',
  `addperson` varchar(30) DEFAULT NULL COMMENT '添加者',
  `typeid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `flag` set('h','c','f','a','p') NOT NULL COMMENT '文章属性',
  `click` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击数量',
  `image` varchar(255) DEFAULT NULL COMMENT '图片地址',
  PRIMARY KEY (`id`),
  KEY `title` (`title`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='新闻表';

-- ----------------------------
-- Records of 57sy_extra_news
-- ----------------------------
INSERT INTO 57sy_extra_news VALUES ('50', 'php 二维数组去除重复值', 'vvvv', 'php 二维数组去除重复值<br />', 'php 二维数组去除重复值&lt;br /&gt;', '78', '1434294351', '1434294351', '1', 'wangjian', '6', 'c,f', '89', '20150614/143429662618334.jpg');
INSERT INTO 57sy_extra_news VALUES ('54', 'cscc', 'cczxc', 'zxczxc&amp;lt;br /&amp;gt;', 'zxczxc&lt;br /&gt;', '0', '1434297886', '1434297886', '1', 'wangjian', '1', '', '0', '20150615/143429789221499.jpg');

-- ----------------------------
-- Table structure for `57sy_extra_newstype`
-- ----------------------------
DROP TABLE IF EXISTS `57sy_extra_newstype`;
CREATE TABLE `57sy_extra_newstype` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `typename` varchar(30) NOT NULL,
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `disorder` int(11) NOT NULL DEFAULT '0',
  `seotitle` varchar(100) NOT NULL COMMENT 'seo',
  `keywords` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COMMENT='新闻类别';

-- ----------------------------
-- Records of 57sy_extra_newstype
-- ----------------------------
INSERT INTO 57sy_extra_newstype VALUES ('1', '中国新闻', '0', '1', '0', '4554', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('2', '外国新闻', '0', '1', '5', 'asdsa', 'vbb', 'adasdadasdasdassad');
INSERT INTO 57sy_extra_newstype VALUES ('3', '河南新闻', '1', '1', '0', 'bmmm_123', 'bmmm_123', 'bmmm_123');
INSERT INTO 57sy_extra_newstype VALUES ('4', '哈哈哈', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('5', '655665', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('6', '非官方的', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('7', '难难难', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('8', '功夫风光好', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('9', '45455454', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('10', '某某某', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('11', 'vnbvb', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('12', '的风格大方', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('13', '45232112', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('14', '宝宝变变变', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('15', '你能那么忙', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('16', 'vbcv', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('17', '大概的风格大方', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('18', '发ssd', '17', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('19', '123444', '16', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('20', '667777', '19', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('21', '54554', '17', '0', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('22', '44', '3', '1', '5', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('23', 'bnnnn', '10', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('24', '4444', '22', '1', '12', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('25', '55', '24', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('26', '222255', '22', '1', '7', 'tty123', '555555', 'rrrrr');
INSERT INTO 57sy_extra_newstype VALUES ('27', 'qwqwqwwq', '1', '1', '0', 'qwwqqw', 'qwwqq', 'qw');
INSERT INTO 57sy_extra_newstype VALUES ('28', 'asasssa', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('29', 'cccccc', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('30', '11222', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('31', 'sassa', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('32', 'c12222', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('33', 'gggggg', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('34', 'gggggg', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('35', 'ttttt', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('36', 'yyyyyyy', '1', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('37', 'ccccc', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('38', 'dsdssdsd', '0', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('39', '我是某某11', '10', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('40', '踩踩踩踩踩', '37', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('41', '11111', '40', '1', '0', '', '', '');
INSERT INTO 57sy_extra_newstype VALUES ('42', '反反复复吩咐', '38', '1', '0', '', '', '');

-- ----------------------------
-- Table structure for `57sy_extra_product`
-- ----------------------------
DROP TABLE IF EXISTS `57sy_extra_product`;
CREATE TABLE `57sy_extra_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL COMMENT '名称',
  `image` char(40) NOT NULL COMMENT '图片',
  `introduce` text NOT NULL COMMENT '介绍',
  `url` char(100) DEFAULT NULL COMMENT '官网',
  `weight` int(10) DEFAULT NULL,
  `modify_date` char(11) DEFAULT NULL,
  `create_date` char(11) DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1开启0关闭',
  `addperson` char(16) NOT NULL COMMENT '添加人',
  `typeid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '类别ID',
  `typename` varchar(30) NOT NULL COMMENT '类别名称',
  PRIMARY KEY (`id`),
  KEY `title` (`title`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='产品表';

-- ----------------------------
-- Records of 57sy_extra_product
-- ----------------------------
INSERT INTO 57sy_extra_product VALUES ('25', 'sasaasas', '140262391728630.png', '', '', '0', '1402623917', '1402623917', '0', 'wangjian', '45059', '我的产品');
INSERT INTO 57sy_extra_product VALUES ('26', '2233', '140262832619336.jpg', '', 'sss', '0', '1402628326', '1402628319', '0', 'wangjian', '45058', '产品123');
INSERT INTO 57sy_extra_product VALUES ('24', 'asasas', '140262370114321.jpg', 'aaas', 'assa', '122', '1402623701', '1402623640', '0', 'wangjian', '45058', '产品123');
