<?php
pdo_query("DROP TABLE IF EXISTS `ims_dayu_member`;
CREATE TABLE IF NOT EXISTS `ims_dayu_member` (
`id` int(10) NOT NULL AUTO_INCREMENT,
`weid` int(10) NOT NULL DEFAULT '0',
`uid` int(10) NOT NULL DEFAULT '0',
`openid` varchar(50) NOT NULL,
`realname` varchar(50) NOT NULL,
`mobile` varchar(11) NOT NULL,
`nickname` varchar(50) NOT NULL,
`avatar` varchar(255) NOT NULL,
`groupid` int(10) NOT NULL DEFAULT '0',
`gender` tinyint(1) NOT NULL DEFAULT '1',
`province` varchar(30) NOT NULL,
`city` varchar(30) NOT NULL,
`dist` varchar(30) NOT NULL,
`address` varchar(100) NOT NULL,
`realaddress` varchar(200) NOT NULL,
`company` varchar(50) NOT NULL,
`qq` varchar(15) NOT NULL,
`alipay` varchar(50) NOT NULL,
`idcard` varchar(30) NOT NULL,
`frontid` varchar(255) NOT NULL,
`backid` varchar(255) NOT NULL,
`fdriving` varchar(255) NOT NULL,
`bdriving` varchar(255) NOT NULL,
`status` tinyint(1) NOT NULL DEFAULT '1',
`modules` int(2) NOT NULL DEFAULT '0',
`updatetime` int(10) NOT NULL DEFAULT '0',
`createtime` int(10) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`),
KEY `weid` (`weid`),
KEY `openid` (`openid`),
KEY `idcard` (`idcard`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_dayu_yuyuepay`;
CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay` (
`reid` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`title` varchar(100) NOT NULL,
`subtitle` varchar(20) NOT NULL,
`description` varchar(1000) NOT NULL,
`content` text NOT NULL,
`information` varchar(500) NOT NULL,
`thumb` varchar(200) NOT NULL,
`icon` varchar(200) NOT NULL,
`inhome` tinyint(4) NOT NULL DEFAULT '0',
`starttime` int(10) NOT NULL DEFAULT '0',
`endtime` int(10) unsigned NOT NULL,
`status` int(1) NOT NULL DEFAULT '0',
`pretotal` int(10) unsigned NOT NULL DEFAULT '0',
`pay` int(1) unsigned NOT NULL DEFAULT '1',
`yuyuename` varchar(50) NOT NULL,
`noticeemail` varchar(50) NOT NULL,
`k_templateid` varchar(50) NOT NULL,
`kfid` varchar(50) NOT NULL,
`m_templateid` varchar(50) NOT NULL,
`mobile` varchar(50) NOT NULL,
`skins` varchar(20) NOT NULL DEFAULT 'weui',
`code` tinyint(1) DEFAULT NULL DEFAULT '0',
`remove` varchar(100) NOT NULL,
`share_url` varchar(100) NOT NULL,
`isthumb` tinyint(1) NOT NULL DEFAULT '0',
`outlink` varchar(200) NOT NULL,
`isdel` tinyint(1) NOT NULL DEFAULT '0',
`follow` tinyint(1) DEFAULT NULL DEFAULT '1',
`is_num` tinyint(1) DEFAULT NULL DEFAULT '0',
`is_time` tinyint(1) DEFAULT NULL DEFAULT '0',
`is_addr` tinyint(1) DEFAULT NULL DEFAULT '1',
`is_list` tinyint(1) NOT NULL DEFAULT '1',
`iscard` tinyint(1) NOT NULL DEFAULT '0',
`timelist` tinyint(1) NOT NULL DEFAULT '0',
`day` int(10) unsigned NOT NULL DEFAULT '8',
`srvtime` text NOT NULL,
`out1` varchar(200) NOT NULL,
`out2` varchar(200) NOT NULL,
`out3` varchar(200) NOT NULL,
`out4` varchar(200) NOT NULL,
`out5` varchar(200) NOT NULL,
`out6` varchar(200) NOT NULL,
`out7` varchar(200) NOT NULL,
`score_total` int(11) NOT NULL DEFAULT '0' COMMENT '总分',
`score_vr` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟分',
`score_num` int(11) NOT NULL DEFAULT '0' COMMENT '人数',
`restrict` tinyint(1) DEFAULT NULL DEFAULT '0',
`daynum` int(11) NOT NULL DEFAULT '0',
`smsid` int(11) NOT NULL DEFAULT '0',
`smstype` int(1) NOT NULL DEFAULT '0',
`displayorder` int(3) NOT NULL DEFAULT '0',
`createtime` int(10) NOT NULL DEFAULT '0',
`role` int(11) NOT NULL DEFAULT '0',
`par` text NOT NULL,
`switch` text NOT NULL,
`store` tinyint(1) DEFAULT NULL DEFAULT '0',
`cid` int(11) NOT NULL,
`guanli` tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`reid`),
KEY `weid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_dayu_yuyuepay_category`;
CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_category` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL DEFAULT '0',
`title` varchar(100) NOT NULL,
`icon` varchar(255) NOT NULL,
`list` tinyint(1) NOT NULL,
`color` text NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_dayu_yuyuepay_data`;
CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_data` (
`redid` bigint(20) NOT NULL AUTO_INCREMENT,
`reid` int(11) NOT NULL,
`rerid` int(11) NOT NULL,
`refid` int(11) NOT NULL,
`data` varchar(800) NOT NULL,
`displayorder` int(11) unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (`redid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_dayu_yuyuepay_fields`;
CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_fields` (
`refid` int(11) NOT NULL AUTO_INCREMENT,
`reid` int(11) NOT NULL DEFAULT '0',
`title` varchar(200) NOT NULL,
`type` varchar(20) NOT NULL,
`essential` tinyint(4) NOT NULL DEFAULT '0',
`bind` varchar(30) NOT NULL,
`value` varchar(300) NOT NULL,
`image` varchar(250) NOT NULL,
`description` varchar(500) NOT NULL,
`displayorder` int(11) unsigned NOT NULL DEFAULT '0',
`loc` tinyint(1) NOT NULL DEFAULT '0',
`cami` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`refid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_dayu_yuyuepay_group`;
CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_group` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`reid` int(11) NOT NULL,
`groupid` varchar(100) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_dayu_yuyuepay_info`;
CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_info` (
`rerid` int(11) NOT NULL AUTO_INCREMENT,
`reid` int(11) NOT NULL,
`member` varchar(50) NOT NULL,
`mobile` varchar(11) NOT NULL,
`address` varchar(1024) NOT NULL,
`openid` varchar(50) NOT NULL,
`status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
`xmid` int(11) NOT NULL,
`num` int(3) unsigned NOT NULL DEFAULT '1',
`price` decimal(10,2) NOT NULL DEFAULT '0.00',
`ordersn` varchar(20) NOT NULL COMMENT '订单编号',
`transid` varchar(30) NOT NULL COMMENT '微信订单号',
`paystatus` tinyint(4) NOT NULL COMMENT '付款状态',
`paytype` tinyint(4) NOT NULL COMMENT '付款方式',
`kf` varchar(50) NOT NULL,
`yuyuetime` int(10) NOT NULL DEFAULT '0' COMMENT '客服确认时间',
`restime` varchar(50) NOT NULL,
`thumb` text NOT NULL,
`kfinfo` varchar(500) NOT NULL COMMENT '客服信息',
`paydetail` varchar(100) NOT NULL,
`remit` varchar(250) NOT NULL,
`createtime` int(10) NOT NULL DEFAULT '0',
`sid` int(11) NOT NULL,
`share` varchar(50) NOT NULL,
`commentid` int(11) NOT NULL DEFAULT '0',
`signid` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`rerid`),
KEY `reid` (`reid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_dayu_yuyuepay_record`;
CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_record` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`rerid` int(11) NOT NULL,
`openid` varchar(50) NOT NULL,
`thumb` text NOT NULL,
`info` varchar(500) NOT NULL,
`ostatus` tinyint(1) NOT NULL,
`status` tinyint(1) NOT NULL,
`createtime` int(10) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_dayu_yuyuepay_reply`;
CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_reply` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`rid` int(11) NOT NULL,
`reid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_dayu_yuyuepay_role`;
CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_role` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`reid` int(11) NOT NULL,
`roleid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_dayu_yuyuepay_slide`;
CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_slide` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL DEFAULT '0',
`title` varchar(50) DEFAULT NULL,
`link` varchar(255) DEFAULT NULL,
`thumb` varchar(255) DEFAULT NULL,
`displayorder` int(11) DEFAULT NULL DEFAULT '0',
`enabled` int(11) DEFAULT NULL DEFAULT '0',
`cid` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `indx_weid` (`weid`),
KEY `indx_enabled` (`enabled`),
KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_dayu_yuyuepay_staff`;
CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_staff` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL DEFAULT '0',
`reid` int(11) NOT NULL DEFAULT '0',
`nickname` varchar(50) NOT NULL,
`openid` varchar(50) NOT NULL,
`createtime` int(10) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_dayu_yuyuepay_xiangmu`;
CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_xiangmu` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`reid` int(11) NOT NULL,
`title` varchar(50) NOT NULL,
`type` tinyint(1) NOT NULL DEFAULT '0',
`daynum` int(4) NOT NULL DEFAULT '0',
`price` decimal(10,2) NOT NULL DEFAULT '0.00',
`prices` decimal(10,2) NOT NULL DEFAULT '0.00',
`isc` tinyint(1) NOT NULL DEFAULT '0',
`content` text NOT NULL,
`displayorder` tinyint(3) NOT NULL DEFAULT '0',
`isshow` tinyint(1) NOT NULL DEFAULT '0',
`thumb` varchar(255) NOT NULL,
PRIMARY KEY (`id`),
KEY `weid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");
