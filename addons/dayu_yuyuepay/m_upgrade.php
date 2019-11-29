<?php
pdo_query("CREATE TABLE IF NOT EXISTS `ims_dayu_member` (
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

CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_category` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL DEFAULT '0',
`title` varchar(100) NOT NULL,
`icon` varchar(255) NOT NULL,
`list` tinyint(1) NOT NULL,
`color` text NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_data` (
`redid` bigint(20) NOT NULL AUTO_INCREMENT,
`reid` int(11) NOT NULL,
`rerid` int(11) NOT NULL,
`refid` int(11) NOT NULL,
`data` varchar(800) NOT NULL,
`displayorder` int(11) unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (`redid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_group` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`reid` int(11) NOT NULL,
`groupid` varchar(100) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_reply` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`rid` int(11) NOT NULL,
`reid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_role` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`reid` int(11) NOT NULL,
`roleid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_dayu_yuyuepay_staff` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL DEFAULT '0',
`reid` int(11) NOT NULL DEFAULT '0',
`nickname` varchar(50) NOT NULL,
`openid` varchar(50) NOT NULL,
`createtime` int(10) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'id')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `id` int(10) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `weid` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `uid` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `openid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'realname')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `realname` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'mobile')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `mobile` varchar(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `nickname` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'avatar')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `avatar` varchar(255) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'groupid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `groupid` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'gender')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `gender` tinyint(1) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'province')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `province` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'city')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `city` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'dist')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `dist` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'address')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `address` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'realaddress')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `realaddress` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'company')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `company` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'qq')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `qq` varchar(15) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'alipay')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `alipay` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'idcard')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `idcard` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'frontid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `frontid` varchar(255) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'backid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `backid` varchar(255) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'fdriving')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `fdriving` varchar(255) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'bdriving')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `bdriving` varchar(255) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'status')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `status` tinyint(1) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'modules')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `modules` int(2) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'updatetime')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `updatetime` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_member')) {
	if(!pdo_fieldexists('dayu_member',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('dayu_member')." ADD `createtime` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'reid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `reid` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'title')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `title` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'subtitle')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `subtitle` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'description')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `description` varchar(1000) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'content')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `content` text NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'information')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `information` varchar(500) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'thumb')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `thumb` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'icon')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `icon` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'inhome')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `inhome` tinyint(4) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'starttime')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `starttime` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'endtime')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `endtime` int(10) unsigned NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'status')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `status` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'pretotal')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `pretotal` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'pay')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `pay` int(1) unsigned NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'yuyuename')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `yuyuename` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'noticeemail')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `noticeemail` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'k_templateid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `k_templateid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'kfid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `kfid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'm_templateid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `m_templateid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'mobile')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `mobile` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'skins')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `skins` varchar(20) NOT NULL DEFAULT 'weui';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'code')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `code` tinyint(1) DEFAULT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'remove')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `remove` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'share_url')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `share_url` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'isthumb')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `isthumb` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'outlink')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `outlink` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'isdel')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `isdel` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'follow')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `follow` tinyint(1) DEFAULT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'is_num')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `is_num` tinyint(1) DEFAULT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'is_time')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `is_time` tinyint(1) DEFAULT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'is_addr')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `is_addr` tinyint(1) DEFAULT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'is_list')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `is_list` tinyint(1) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'iscard')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `iscard` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'timelist')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `timelist` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'day')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `day` int(10) unsigned NOT NULL DEFAULT '8';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'srvtime')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `srvtime` text NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'out1')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `out1` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'out2')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `out2` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'out3')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `out3` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'out4')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `out4` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'out5')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `out5` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'out6')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `out6` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'out7')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `out7` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'score_total')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `score_total` int(11) NOT NULL DEFAULT '0' COMMENT '总分';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'score_vr')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `score_vr` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟分';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'score_num')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `score_num` int(11) NOT NULL DEFAULT '0' COMMENT '人数';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'restrict')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `restrict` tinyint(1) DEFAULT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'daynum')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `daynum` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'smsid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `smsid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'smstype')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `smstype` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'displayorder')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `displayorder` int(3) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `createtime` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'role')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `role` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'par')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `par` text NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'switch')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `switch` text NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'store')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `store` tinyint(1) DEFAULT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'cid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `cid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay')) {
	if(!pdo_fieldexists('dayu_yuyuepay',  'guanli')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay')." ADD `guanli` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_category')) {
	if(!pdo_fieldexists('dayu_yuyuepay_category',  'id')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_category')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_category')) {
	if(!pdo_fieldexists('dayu_yuyuepay_category',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_category')." ADD `weid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_category')) {
	if(!pdo_fieldexists('dayu_yuyuepay_category',  'title')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_category')." ADD `title` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_category')) {
	if(!pdo_fieldexists('dayu_yuyuepay_category',  'icon')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_category')." ADD `icon` varchar(255) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_category')) {
	if(!pdo_fieldexists('dayu_yuyuepay_category',  'list')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_category')." ADD `list` tinyint(1) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_category')) {
	if(!pdo_fieldexists('dayu_yuyuepay_category',  'color')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_category')." ADD `color` text NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_data')) {
	if(!pdo_fieldexists('dayu_yuyuepay_data',  'redid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_data')." ADD `redid` bigint(20) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_data')) {
	if(!pdo_fieldexists('dayu_yuyuepay_data',  'reid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_data')." ADD `reid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_data')) {
	if(!pdo_fieldexists('dayu_yuyuepay_data',  'rerid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_data')." ADD `rerid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_data')) {
	if(!pdo_fieldexists('dayu_yuyuepay_data',  'refid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_data')." ADD `refid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_data')) {
	if(!pdo_fieldexists('dayu_yuyuepay_data',  'data')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_data')." ADD `data` varchar(800) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_data')) {
	if(!pdo_fieldexists('dayu_yuyuepay_data',  'displayorder')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_data')." ADD `displayorder` int(11) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_fields')) {
	if(!pdo_fieldexists('dayu_yuyuepay_fields',  'refid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_fields')." ADD `refid` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_fields')) {
	if(!pdo_fieldexists('dayu_yuyuepay_fields',  'reid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_fields')." ADD `reid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_fields')) {
	if(!pdo_fieldexists('dayu_yuyuepay_fields',  'title')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_fields')." ADD `title` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_fields')) {
	if(!pdo_fieldexists('dayu_yuyuepay_fields',  'type')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_fields')." ADD `type` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_fields')) {
	if(!pdo_fieldexists('dayu_yuyuepay_fields',  'essential')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_fields')." ADD `essential` tinyint(4) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_fields')) {
	if(!pdo_fieldexists('dayu_yuyuepay_fields',  'bind')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_fields')." ADD `bind` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_fields')) {
	if(!pdo_fieldexists('dayu_yuyuepay_fields',  'value')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_fields')." ADD `value` varchar(300) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_fields')) {
	if(!pdo_fieldexists('dayu_yuyuepay_fields',  'image')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_fields')." ADD `image` varchar(250) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_fields')) {
	if(!pdo_fieldexists('dayu_yuyuepay_fields',  'description')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_fields')." ADD `description` varchar(500) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_fields')) {
	if(!pdo_fieldexists('dayu_yuyuepay_fields',  'displayorder')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_fields')." ADD `displayorder` int(11) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_fields')) {
	if(!pdo_fieldexists('dayu_yuyuepay_fields',  'loc')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_fields')." ADD `loc` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_fields')) {
	if(!pdo_fieldexists('dayu_yuyuepay_fields',  'cami')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_fields')." ADD `cami` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_group')) {
	if(!pdo_fieldexists('dayu_yuyuepay_group',  'id')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_group')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_group')) {
	if(!pdo_fieldexists('dayu_yuyuepay_group',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_group')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_group')) {
	if(!pdo_fieldexists('dayu_yuyuepay_group',  'reid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_group')." ADD `reid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_group')) {
	if(!pdo_fieldexists('dayu_yuyuepay_group',  'groupid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_group')." ADD `groupid` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'rerid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `rerid` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'reid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `reid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'member')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `member` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'mobile')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `mobile` varchar(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'address')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `address` varchar(1024) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `openid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'status')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'xmid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `xmid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'num')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `num` int(3) unsigned NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'price')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `price` decimal(10,2) NOT NULL DEFAULT '0.00';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'ordersn')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `ordersn` varchar(20) NOT NULL COMMENT '订单编号';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'transid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `transid` varchar(30) NOT NULL COMMENT '微信订单号';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'paystatus')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `paystatus` tinyint(4) NOT NULL COMMENT '付款状态';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'paytype')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `paytype` tinyint(4) NOT NULL COMMENT '付款方式';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'kf')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `kf` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'yuyuetime')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `yuyuetime` int(10) NOT NULL DEFAULT '0' COMMENT '客服确认时间';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'restime')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `restime` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'thumb')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `thumb` text NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'kfinfo')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `kfinfo` varchar(500) NOT NULL COMMENT '客服信息';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'paydetail')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `paydetail` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'remit')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `remit` varchar(250) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `createtime` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'sid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `sid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'share')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `share` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'commentid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `commentid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_info')) {
	if(!pdo_fieldexists('dayu_yuyuepay_info',  'signid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_info')." ADD `signid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_record')) {
	if(!pdo_fieldexists('dayu_yuyuepay_record',  'id')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_record')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_record')) {
	if(!pdo_fieldexists('dayu_yuyuepay_record',  'rerid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_record')." ADD `rerid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_record')) {
	if(!pdo_fieldexists('dayu_yuyuepay_record',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_record')." ADD `openid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_record')) {
	if(!pdo_fieldexists('dayu_yuyuepay_record',  'thumb')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_record')." ADD `thumb` text NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_record')) {
	if(!pdo_fieldexists('dayu_yuyuepay_record',  'info')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_record')." ADD `info` varchar(500) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_record')) {
	if(!pdo_fieldexists('dayu_yuyuepay_record',  'ostatus')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_record')." ADD `ostatus` tinyint(1) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_record')) {
	if(!pdo_fieldexists('dayu_yuyuepay_record',  'status')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_record')." ADD `status` tinyint(1) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_record')) {
	if(!pdo_fieldexists('dayu_yuyuepay_record',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_record')." ADD `createtime` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_reply')) {
	if(!pdo_fieldexists('dayu_yuyuepay_reply',  'id')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_reply')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_reply')) {
	if(!pdo_fieldexists('dayu_yuyuepay_reply',  'rid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_reply')." ADD `rid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_reply')) {
	if(!pdo_fieldexists('dayu_yuyuepay_reply',  'reid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_reply')." ADD `reid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_role')) {
	if(!pdo_fieldexists('dayu_yuyuepay_role',  'id')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_role')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_role')) {
	if(!pdo_fieldexists('dayu_yuyuepay_role',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_role')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_role')) {
	if(!pdo_fieldexists('dayu_yuyuepay_role',  'reid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_role')." ADD `reid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_role')) {
	if(!pdo_fieldexists('dayu_yuyuepay_role',  'roleid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_role')." ADD `roleid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_slide')) {
	if(!pdo_fieldexists('dayu_yuyuepay_slide',  'id')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_slide')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_slide')) {
	if(!pdo_fieldexists('dayu_yuyuepay_slide',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_slide')." ADD `weid` int(11) DEFAULT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_slide')) {
	if(!pdo_fieldexists('dayu_yuyuepay_slide',  'title')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_slide')." ADD `title` varchar(50) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_slide')) {
	if(!pdo_fieldexists('dayu_yuyuepay_slide',  'link')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_slide')." ADD `link` varchar(255) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_slide')) {
	if(!pdo_fieldexists('dayu_yuyuepay_slide',  'thumb')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_slide')." ADD `thumb` varchar(255) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_slide')) {
	if(!pdo_fieldexists('dayu_yuyuepay_slide',  'displayorder')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_slide')." ADD `displayorder` int(11) DEFAULT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_slide')) {
	if(!pdo_fieldexists('dayu_yuyuepay_slide',  'enabled')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_slide')." ADD `enabled` int(11) DEFAULT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_slide')) {
	if(!pdo_fieldexists('dayu_yuyuepay_slide',  'cid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_slide')." ADD `cid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_staff')) {
	if(!pdo_fieldexists('dayu_yuyuepay_staff',  'id')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_staff')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_staff')) {
	if(!pdo_fieldexists('dayu_yuyuepay_staff',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_staff')." ADD `weid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_staff')) {
	if(!pdo_fieldexists('dayu_yuyuepay_staff',  'reid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_staff')." ADD `reid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_staff')) {
	if(!pdo_fieldexists('dayu_yuyuepay_staff',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_staff')." ADD `nickname` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_staff')) {
	if(!pdo_fieldexists('dayu_yuyuepay_staff',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_staff')." ADD `openid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_staff')) {
	if(!pdo_fieldexists('dayu_yuyuepay_staff',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_staff')." ADD `createtime` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_xiangmu')) {
	if(!pdo_fieldexists('dayu_yuyuepay_xiangmu',  'id')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_xiangmu')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_xiangmu')) {
	if(!pdo_fieldexists('dayu_yuyuepay_xiangmu',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_xiangmu')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_xiangmu')) {
	if(!pdo_fieldexists('dayu_yuyuepay_xiangmu',  'reid')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_xiangmu')." ADD `reid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_xiangmu')) {
	if(!pdo_fieldexists('dayu_yuyuepay_xiangmu',  'title')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_xiangmu')." ADD `title` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_xiangmu')) {
	if(!pdo_fieldexists('dayu_yuyuepay_xiangmu',  'type')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_xiangmu')." ADD `type` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_xiangmu')) {
	if(!pdo_fieldexists('dayu_yuyuepay_xiangmu',  'daynum')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_xiangmu')." ADD `daynum` int(4) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_xiangmu')) {
	if(!pdo_fieldexists('dayu_yuyuepay_xiangmu',  'price')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_xiangmu')." ADD `price` decimal(10,2) NOT NULL DEFAULT '0.00';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_xiangmu')) {
	if(!pdo_fieldexists('dayu_yuyuepay_xiangmu',  'prices')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_xiangmu')." ADD `prices` decimal(10,2) NOT NULL DEFAULT '0.00';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_xiangmu')) {
	if(!pdo_fieldexists('dayu_yuyuepay_xiangmu',  'isc')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_xiangmu')." ADD `isc` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_xiangmu')) {
	if(!pdo_fieldexists('dayu_yuyuepay_xiangmu',  'content')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_xiangmu')." ADD `content` text NOT NULL;");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_xiangmu')) {
	if(!pdo_fieldexists('dayu_yuyuepay_xiangmu',  'displayorder')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_xiangmu')." ADD `displayorder` tinyint(3) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_xiangmu')) {
	if(!pdo_fieldexists('dayu_yuyuepay_xiangmu',  'isshow')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_xiangmu')." ADD `isshow` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('dayu_yuyuepay_xiangmu')) {
	if(!pdo_fieldexists('dayu_yuyuepay_xiangmu',  'thumb')) {
		pdo_query("ALTER TABLE ".tablename('dayu_yuyuepay_xiangmu')." ADD `thumb` varchar(255) NOT NULL;");
	}	
}
