<?php
pdo_query("DROP TABLE IF EXISTS `ims_chbl_sun_account`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_account` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`weid` int(10) unsigned NOT NULL DEFAULT '0',
`storeid` varchar(1000) NOT NULL,
`uid` int(10) unsigned NOT NULL DEFAULT '0',
`from_user` varchar(100) NOT NULL DEFAULT '',
`accountname` varchar(50) NOT NULL DEFAULT '',
`password` varchar(200) NOT NULL DEFAULT '',
`salt` varchar(10) NOT NULL DEFAULT '',
`pwd` varchar(50) NOT NULL,
`mobile` varchar(20) NOT NULL,
`email` varchar(20) NOT NULL,
`username` varchar(50) NOT NULL,
`pay_account` varchar(200) NOT NULL,
`displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
`dateline` int(10) unsigned NOT NULL DEFAULT '0',
`status` tinyint(1) unsigned NOT NULL DEFAULT '2',
`role` tinyint(1) unsigned NOT NULL DEFAULT '1',
`lastvisit` int(10) unsigned NOT NULL DEFAULT '0',
`lastip` varchar(15) NOT NULL,
`areaid` int(10) NOT NULL DEFAULT '0',
`is_admin_order` tinyint(1) unsigned NOT NULL DEFAULT '1',
`is_notice_order` tinyint(1) unsigned NOT NULL DEFAULT '1',
`is_notice_queue` tinyint(1) unsigned NOT NULL DEFAULT '1',
`is_notice_service` tinyint(1) unsigned NOT NULL DEFAULT '1',
`is_notice_boss` tinyint(1) NOT NULL DEFAULT '0',
`remark` varchar(1000) NOT NULL DEFAULT '',
`lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000',
`lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000',
`cityname` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_active`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_active` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`uniacid` int(10) unsigned NOT NULL DEFAULT '0',
`subtitle` varchar(45),
`title` varchar(200),
`createtime` int(13) unsigned NOT NULL DEFAULT '0',
`content` text NOT NULL,
`sort` int(10) DEFAULT '0',
`antime` timestamp,
`hits` int(10) DEFAULT '0',
`status` tinyint(10) DEFAULT '0',
`astime` timestamp,
`thumb` varchar(200),
`num` int(10) DEFAULT '0',
`sharenum` int(11),
`thumb_url` text,
`part_num` varchar(15) DEFAULT '0',
`share_plus` varchar(15) DEFAULT '1',
`new_partnum` varchar(15) DEFAULT '1',
`user_id` varchar(100),
`storeinfo` varchar(200),
`showindex` int(11),
`active_num` int(11),
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_activerecord`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_activerecord` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`uniacid` int(10) unsigned NOT NULL DEFAULT '0',
`uid` int(10),
`pid` int(10) DEFAULT '0',
`num` int(10) DEFAULT '0',
`createtime` int(10) unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_ad`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_ad` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`title` varchar(50) NOT NULL,
`logo` varchar(200) NOT NULL,
`status` int(11) NOT NULL,
`src` varchar(100) NOT NULL,
`orderby` int(11) NOT NULL,
`xcx_name` varchar(20) NOT NULL,
`appid` varchar(20) NOT NULL,
`uniacid` int(11) NOT NULL,
`type` int(11) NOT NULL,
`cityname` varchar(50) NOT NULL,
`wb_src` varchar(300) NOT NULL,
`state` int(4) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_address`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_address` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`consignee` varchar(45) NOT NULL,
`phone` int(11) NOT NULL,
`address` text NOT NULL,
`stree` text NOT NULL,
`uid` text NOT NULL,
`isdefault` int(11) NOT NULL DEFAULT '0',
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_area`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_area` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`area_name` varchar(50) NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_banner`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_banner` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`bname` varchar(45) NOT NULL,
`lb_imgs` varchar(500) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_bargain`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_bargain` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`gname` varchar(100),
`marketprice` varchar(45),
`selftime` varchar(100),
`pic` varchar(200),
`details` text,
`status` int(11),
`uniacid` int(11),
`starttime` timestamp,
`shopprice` varchar(45),
`endtime` timestamp,
`num` int(11),
`content` text,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_car`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_car` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`start_place` varchar(100) NOT NULL,
`end_place` varchar(100) NOT NULL,
`start_time` varchar(30) NOT NULL,
`num` int(4) NOT NULL,
`link_name` varchar(30) NOT NULL,
`link_tel` varchar(20) NOT NULL,
`typename` varchar(30) NOT NULL,
`other` varchar(300) NOT NULL,
`time` int(11) NOT NULL,
`sh_time` int(11) NOT NULL,
`top_id` int(11) NOT NULL,
`top` int(4) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`state` int(4) NOT NULL,
`tj_place` varchar(300) NOT NULL,
`hw_wet` varchar(10) NOT NULL,
`star_lat` varchar(20) NOT NULL,
`star_lng` varchar(20) NOT NULL,
`end_lat` varchar(20) NOT NULL,
`end_lng` varchar(20) NOT NULL,
`is_open` int(4) NOT NULL,
`start_time2` int(11) NOT NULL,
`cityname` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_car_my_tag`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_car_my_tag` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`tag_id` int(11) NOT NULL,
`car_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_car_tag`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_car_tag` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`typename` varchar(30) NOT NULL,
`tagname` varchar(30) NOT NULL,
`uniacid` varchar(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_car_top`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_car_top` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`uniacid` int(11) NOT NULL,
`num` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_carpaylog`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_carpaylog` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`car_id` int(44) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_comments`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_comments` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`information_id` int(11) NOT NULL,
`details` varchar(200) NOT NULL,
`time` varchar(20) NOT NULL,
`reply` varchar(200) NOT NULL,
`hf_time` varchar(20) NOT NULL,
`user_id` int(11) NOT NULL,
`store_id` int(11) NOT NULL,
`score` decimal(10,1) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_commission_withdrawal`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_commission_withdrawal` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`type` int(11) NOT NULL,
`state` int(11) NOT NULL,
`time` int(11) NOT NULL,
`sh_time` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`user_name` varchar(20) NOT NULL,
`account` varchar(100) NOT NULL,
`tx_cost` decimal(10,2) NOT NULL,
`sj_cost` decimal(10,2) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_coupon_order`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_coupon_order` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`uniacid` int(10) unsigned NOT NULL DEFAULT '0',
`pid` int(10) DEFAULT '0',
`uid` int(10),
`cid` int(10) DEFAULT '0',
`createtime` int(10) unsigned NOT NULL DEFAULT '0',
`status` tinyint(10) DEFAULT '0',
`num` int(10) DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_distribution`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_distribution` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`time` int(11) NOT NULL,
`user_name` varchar(20) NOT NULL,
`user_tel` varchar(20) NOT NULL,
`state` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_earnings`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_earnings` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`son_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_fabuset`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_fabuset` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type` int(5),
`price` varchar(15) DEFAULT '0',
`uniacid` varchar(15),
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_fx`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_fx` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`zf_user_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_fxset`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_fxset` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`fx_details` text NOT NULL,
`tx_details` text NOT NULL,
`is_fx` int(11) NOT NULL,
`is_ej` int(11) NOT NULL,
`tx_rate` int(11) NOT NULL,
`commission` varchar(10) NOT NULL,
`commission2` varchar(10) NOT NULL,
`tx_money` int(11) NOT NULL,
`img` varchar(100) NOT NULL,
`img2` varchar(100) NOT NULL,
`uniacid` int(11) NOT NULL,
`is_open` int(11) NOT NULL DEFAULT '1',
`instructions` text NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_fxuser`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_fxuser` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`fx_user` int(11) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_gift`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_gift` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`uniacid` int(10) unsigned NOT NULL DEFAULT '0',
`title` varchar(200),
`createtime` int(10) unsigned NOT NULL DEFAULT '0',
`content` text NOT NULL,
`sort` int(10) DEFAULT '0',
`hits` int(10) DEFAULT '0',
`status` tinyint(10) DEFAULT '0',
`thumb` varchar(200),
`thumb2` varchar(200),
`pid` int(10) DEFAULT '0',
`rate` mediumint(10) DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_gift_order`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_gift_order` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`uniacid` int(10) unsigned NOT NULL DEFAULT '0',
`pid` int(10) DEFAULT '0',
`uid` varchar(100) NOT NULL,
`createtime` int(10) unsigned NOT NULL DEFAULT '0',
`status` tinyint(10) DEFAULT '0',
`consignee` varchar(45),
`tel` varchar(45),
`note` varchar(150),
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_goods`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_goods` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`store_id` int(11) NOT NULL,
`goods_volume` varchar(45) NOT NULL,
`spec_id` int(11) NOT NULL,
`goods_name` varchar(100) NOT NULL,
`goods_num` int(11) NOT NULL,
`goods_price` decimal(10,2) NOT NULL,
`goods_cost` decimal(10,2) NOT NULL,
`type_id` int(11) NOT NULL,
`freight` decimal(10,2) NOT NULL,
`delivery` varchar(500) NOT NULL,
`quality` int(4) NOT NULL,
`free` int(4) NOT NULL,
`all_day` int(4) NOT NULL,
`service` int(4) NOT NULL,
`refund` int(4) NOT NULL,
`weeks` int(4) NOT NULL,
`lb_imgs` varchar(500) NOT NULL,
`imgs` varchar(500) NOT NULL,
`time` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`goods_details` text NOT NULL,
`state` int(4) NOT NULL DEFAULT '1',
`sy_num` int(11) NOT NULL,
`is_show` int(11) NOT NULL,
`sales` int(11) NOT NULL,
`spec_name` varchar(45) NOT NULL,
`spec_value` varchar(200) NOT NULL,
`spec_names` varchar(45) NOT NULL,
`spec_values` varchar(200) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_goods_spec`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_goods_spec` (
`spec_value` varchar(45) NOT NULL,
`id` int(11) NOT NULL AUTO_INCREMENT,
`spec_name` varchar(100) NOT NULL,
`sort` int(4) NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_groups`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_groups` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`gname` varchar(100),
`marketprice` decimal(10,2),
`selftime` varchar(100),
`pic` varchar(200),
`details` text,
`status` int(11),
`uniacid` int(11),
`starttime` timestamp,
`shopprice` decimal(10,2),
`endtime` timestamp,
`num` int(11),
`content` text,
`groups_num` int(11),
`is_deliver` int(2) DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_hblq`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_hblq` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`tz_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_help`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_help` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`question` varchar(200) NOT NULL,
`answer` text NOT NULL,
`sort` int(4) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`created_time` datetime NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_hotcity`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_hotcity` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`cityname` varchar(50) NOT NULL,
`time` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`user_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_in`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_in` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_information`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_information` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`details` text NOT NULL,
`img` text NOT NULL,
`user_id` int(11) NOT NULL,
`user_name` varchar(20) NOT NULL,
`user_tel` varchar(20) NOT NULL,
`hot` int(11) NOT NULL,
`top` int(11) NOT NULL,
`givelike` int(11) NOT NULL,
`views` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`type2_id` int(11) NOT NULL,
`type_id` int(11) NOT NULL,
`state` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` int(11) NOT NULL,
`sh_time` int(11) NOT NULL,
`top_type` int(11) NOT NULL,
`address` varchar(500) NOT NULL,
`hb_money` decimal(10,2) NOT NULL,
`hb_num` int(11) NOT NULL,
`hb_type` int(11) NOT NULL,
`hb_keyword` varchar(20) NOT NULL,
`hb_random` int(11) NOT NULL,
`hong` text NOT NULL,
`store_id` int(11) NOT NULL,
`del` int(11) NOT NULL DEFAULT '2',
`user_img2` varchar(100) NOT NULL,
`dq_time` int(11) NOT NULL,
`cityname` varchar(50) NOT NULL,
`hbfx_num` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_label`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_label` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`label_name` varchar(20) NOT NULL,
`type2_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_like`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_like` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`information_id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`zx_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_mylabel`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_mylabel` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`label_id` int(11) NOT NULL,
`information_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_news`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_news` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`title` varchar(50) NOT NULL,
`details` text NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`time` int(11) NOT NULL,
`img` varchar(100) NOT NULL,
`state` int(11) NOT NULL,
`type` int(11) NOT NULL,
`cityname` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_order`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_order` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` text NOT NULL,
`store_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`user_name` varchar(20) NOT NULL,
`address` varchar(200) NOT NULL,
`tel` varchar(20) NOT NULL,
`time` int(11) NOT NULL,
`pay_time` int(11) NOT NULL,
`complete_time` int(11) NOT NULL,
`fh_time` int(11) NOT NULL,
`state` int(11) NOT NULL,
`order_num` varchar(20) NOT NULL,
`good_id` varchar(45) NOT NULL,
`good_name` varchar(200) NOT NULL,
`good_img` varchar(400) NOT NULL,
`good_money` varchar(100) NOT NULL,
`out_trade_no` varchar(50) NOT NULL,
`good_spec` varchar(200) NOT NULL,
`del` int(11) NOT NULL,
`del2` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`freight` decimal(10,2) NOT NULL,
`note` varchar(100) NOT NULL,
`good_num` varchar(45) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_paylog`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_paylog` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`fid` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
`note` varchar(100) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_share`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_share` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`information_id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`store_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_shop_car`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_shop_car` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`gid` int(11) NOT NULL,
`num` int(11) NOT NULL,
`combine` varchar(110) NOT NULL,
`gname` varchar(55) NOT NULL,
`price` varchar(45) NOT NULL,
`pic` varchar(110) NOT NULL,
`uid` text NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_sms`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_sms` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`appkey` varchar(100) NOT NULL,
`tpl_id` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`is_open` int(11) NOT NULL DEFAULT '2',
`tid1` varchar(50) NOT NULL,
`tid2` varchar(50) NOT NULL,
`tid3` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_spec_value`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_spec_value` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`goods_id` int(11) NOT NULL,
`spec_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`name` varchar(50) NOT NULL,
`num` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_store`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_store` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`store_name` varchar(50) NOT NULL,
`address` varchar(200) NOT NULL,
`announcement` varchar(100) NOT NULL,
`storetype_id` int(11) NOT NULL,
`storetype2_id` int(11) NOT NULL,
`area_id` int(11) NOT NULL,
`yy_time` varchar(50) NOT NULL,
`keyword` varchar(50) NOT NULL,
`skzf` int(11) NOT NULL,
`wifi` int(11) NOT NULL,
`mftc` int(11) NOT NULL,
`jzxy` int(11) NOT NULL,
`tgbj` int(11) NOT NULL,
`sfxx` int(11) NOT NULL,
`tel` varchar(20) NOT NULL,
`logo` varchar(100) NOT NULL,
`weixin_logo` varchar(100) NOT NULL,
`ad` text NOT NULL,
`state` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`password` varchar(100) NOT NULL,
`details` text NOT NULL,
`uniacid` int(11) NOT NULL,
`coordinates` varchar(50) NOT NULL,
`views` int(11) NOT NULL,
`score` decimal(10,1) NOT NULL,
`type` int(11) NOT NULL,
`sh_time` int(11) NOT NULL,
`time_over` int(11) NOT NULL,
`img` text NOT NULL,
`vr_link` text NOT NULL,
`num` int(11) NOT NULL,
`start_time` varchar(20) NOT NULL,
`end_time` varchar(20) NOT NULL,
`wallet` decimal(10,2) NOT NULL,
`user_name` varchar(30) NOT NULL,
`pwd` varchar(50) NOT NULL,
`dq_time` int(11) NOT NULL,
`cityname` varchar(50) NOT NULL,
`time` datetime NOT NULL,
`fx_num` int(11) NOT NULL,
`ewm_logo` varchar(100) NOT NULL,
`is_top` int(4) NOT NULL DEFAULT '2',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_store_active`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_store_active` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` varchar(45),
`store_name` varchar(45),
`tel` varchar(15),
`address` varchar(45),
`dq_time` int(15),
`time_type` int(11),
`active_type` int(11),
`state` int(11) DEFAULT '1',
`uniacid` int(45),
`time_over` int(15),
`rz_time` int(15),
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_store_wallet`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_store_wallet` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`store_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`note` varchar(20) NOT NULL,
`type` int(11) NOT NULL,
`time` varchar(20) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_storein`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_storein` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_storepaylog`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_storepaylog` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`store_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_storetype`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_storetype` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type_name` varchar(20) NOT NULL,
`img` varchar(100) NOT NULL,
`uniacid` int(11) NOT NULL,
`num` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`state` int(4) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_storetype2`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_storetype2` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(20) NOT NULL,
`type_id` int(11) NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`state` int(4) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_system`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_system` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`appid` varchar(100) NOT NULL,
`appsecret` varchar(200) NOT NULL,
`mchid` varchar(20) NOT NULL,
`wxkey` varchar(100) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`url_name` varchar(20) NOT NULL,
`details` text NOT NULL,
`url_logo` varchar(100) NOT NULL,
`bq_name` varchar(50) NOT NULL,
`link_name` varchar(30) NOT NULL,
`link_logo` varchar(100) NOT NULL,
`support` varchar(20) NOT NULL,
`bq_logo` varchar(100) NOT NULL,
`fontcolor` varchar(20),
`color` varchar(20) NOT NULL,
`tz_appid` varchar(30) NOT NULL,
`tz_name` varchar(30) NOT NULL,
`pt_name` varchar(30) NOT NULL,
`tz_audit` int(11) NOT NULL,
`sj_audit` int(11) NOT NULL,
`mapkey` varchar(200) NOT NULL,
`tel` varchar(20) NOT NULL,
`gd_key` varchar(100) NOT NULL,
`hb_sxf` int(11) NOT NULL,
`tx_money` decimal(10,2) NOT NULL,
`tx_sxf` int(11) NOT NULL,
`tx_details` text NOT NULL,
`rz_xuz` text NOT NULL,
`ft_xuz` text NOT NULL,
`fx_money` decimal(10,2) NOT NULL,
`is_hhr` int(4) NOT NULL DEFAULT '2',
`is_hbfl` int(4) NOT NULL DEFAULT '2',
`is_zx` int(4) NOT NULL DEFAULT '2',
`is_car` int(4) NOT NULL,
`pc_xuz` text NOT NULL,
`pc_money` decimal(10,2) NOT NULL,
`is_sjrz` int(4) NOT NULL,
`is_pcfw` int(4) NOT NULL,
`total_num` int(11) NOT NULL,
`is_goods` int(4) NOT NULL,
`apiclient_cert` text NOT NULL,
`apiclient_key` text NOT NULL,
`is_openzx` int(4) NOT NULL,
`is_hyset` int(4) NOT NULL,
`is_tzopen` int(4) NOT NULL,
`is_pageopen` int(11) NOT NULL,
`cityname` varchar(50) NOT NULL,
`is_tel` int(4) NOT NULL,
`tx_mode` int(4) NOT NULL DEFAULT '1',
`many_city` int(4) NOT NULL DEFAULT '2',
`tx_type` int(4) NOT NULL DEFAULT '2',
`is_hbzf` int(4) NOT NULL DEFAULT '1',
`hb_img` varchar(100) NOT NULL,
`tz_num` int(11) NOT NULL,
`client_ip` varchar(30) NOT NULL,
`hb_content` varchar(100) NOT NULL,
`is_vipcardopen` int(4) NOT NULL DEFAULT '1',
`is_jkopen` int(4) NOT NULL DEFAULT '1',
`address` varchar(150),
`sj_ruzhu` int(5),
`is_kanjiaopen` int(4) DEFAULT '0',
`bargain_price` varchar(10),
`sign` varchar(12),
`bargain_title` varchar(15),
`is_pintuanopen` int(4),
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_tab`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_tab` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`index` varchar(10),
`indeximg` varchar(200),
`indeximgs` varchar(200),
`coupon` varchar(10),
`couponimg` varchar(200),
`couponimgs` varchar(200),
`fans` varchar(10),
`fansimg` varchar(200),
`fansimgs` varchar(200),
`mine` varchar(10),
`mineimg` varchar(200),
`mineimgs` varchar(200),
`fontcolor` varchar(10),
`fontcolored` varchar(10),
`uniacid` int(11),
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_top`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_top` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`uniacid` int(11) NOT NULL,
`num` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_type`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_type` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type_name` varchar(20) NOT NULL,
`img` varchar(100) NOT NULL,
`uniacid` int(11) NOT NULL,
`num` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`state` int(4) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_type2`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_type2` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(20) NOT NULL,
`type_id` int(11) NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`state` int(4) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_tzpaylog`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_tzpaylog` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`tz_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_user`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_user` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`openid` varchar(100) NOT NULL,
`img` varchar(200) NOT NULL,
`time` varchar(20) NOT NULL,
`name` varchar(20) NOT NULL,
`uniacid` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`user_name` varchar(20) NOT NULL,
`user_tel` varchar(20) NOT NULL,
`user_address` varchar(200) NOT NULL,
`commission` decimal(10,2) NOT NULL,
`state` int(4) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_user_active`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_user_active` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uniacid` int(11) NOT NULL,
`uid` varchar(100) NOT NULL,
`num` int(11),
`img` varchar(150),
`jikanum` int(11),
`active_id` int(11),
`kapian_id` int(11),
`sharenum` int(11),
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_user_bargain`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_user_bargain` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`openid` varchar(200) NOT NULL,
`gid` int(11),
`mch_id` int(11),
`status` int(11),
`price` decimal(10,0),
`uniacid` int(11),
`add_time` int(11),
`kanjia` decimal(11,0) NOT NULL,
`prices` decimal(11,2),
`kanjias` decimal(11,2),
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_user_groups`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_user_groups` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`mch_id` int(11),
`gid` int(11),
`openid` varchar(100),
`order_id` varchar(100),
`addtime` varchar(100),
`uniacid` int(11),
`status` int(11),
`num` int(11),
`price` decimal(10,2),
`buynum` int(11),
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_user_vipcard`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_user_vipcard` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uid` text NOT NULL,
`vipcard_id` int(11) NOT NULL,
`card_number` varchar(45) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_userformid`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_userformid` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`form_id` varchar(50) NOT NULL,
`time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
`openid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_userinfo`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_userinfo` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`uniacid` int(10) unsigned NOT NULL DEFAULT '0',
`uid` varchar(100),
`name` varchar(200),
`tel` varchar(60),
`createtime` int(10) unsigned NOT NULL DEFAULT '0',
`status` tinyint(10) DEFAULT '0',
`nickName` varchar(60),
`avatarUrl` varchar(200),
`fromuid` int(10) DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_vipcard`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_vipcard` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(45) NOT NULL,
`img` varchar(100) NOT NULL,
`price` varchar(45) NOT NULL,
`desc` text NOT NULL,
`uniacid` int(11) NOT NULL,
`discount` varchar(45) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_withdrawal`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_withdrawal` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(10) NOT NULL,
`username` varchar(100) NOT NULL,
`type` int(11) NOT NULL,
`time` int(11) NOT NULL,
`sh_time` int(11) NOT NULL,
`state` int(11) NOT NULL,
`tx_cost` decimal(10,2) NOT NULL,
`sj_cost` decimal(10,2) NOT NULL,
`user_id` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`method` int(11) NOT NULL,
`store_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_yellowpaylog`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_yellowpaylog` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`hy_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_yellowset`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_yellowset` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`days` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_yellowstore`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_yellowstore` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`logo` varchar(200) NOT NULL,
`company_name` varchar(100) NOT NULL,
`company_address` varchar(200) NOT NULL,
`type_id` int(11) NOT NULL,
`link_tel` varchar(20) NOT NULL,
`sort` int(11) NOT NULL,
`rz_time` int(11) NOT NULL,
`sh_time` int(11) NOT NULL,
`state` int(4) NOT NULL,
`rz_type` int(4) NOT NULL,
`time_over` int(4) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`coordinates` varchar(50) NOT NULL,
`content` text NOT NULL,
`imgs` varchar(500) NOT NULL,
`views` int(11) NOT NULL,
`tel2` varchar(20) NOT NULL,
`cityname` varchar(50) NOT NULL,
`dq_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_yingxiao`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_yingxiao` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`toutiao` varchar(45) NOT NULL,
`ttimg` varchar(150) NOT NULL,
`pintuan` varchar(45) NOT NULL,
`ptimg` varchar(150) NOT NULL,
`jika` varchar(45) NOT NULL,
`jkimg` varchar(150) NOT NULL,
`kanjia` varchar(45) NOT NULL,
`kjimg` varchar(150) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_yjset`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_yjset` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type` int(4) NOT NULL DEFAULT '1',
`typer` varchar(10) NOT NULL,
`sjper` varchar(10) NOT NULL,
`hyper` varchar(10) NOT NULL,
`pcper` varchar(10) NOT NULL,
`tzper` varchar(10) NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_yjtx`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_yjtx` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account_id` int(11) NOT NULL,
`tx_type` int(4) NOT NULL,
`tx_cost` decimal(10,2) NOT NULL,
`status` int(4) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`cerated_time` datetime NOT NULL,
`sj_cost` decimal(10,2) NOT NULL,
`account` varchar(30) NOT NULL,
`name` varchar(30) NOT NULL,
`sx_cost` decimal(10,2) NOT NULL,
`time` datetime NOT NULL,
`is_del` int(4) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_zx`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_zx` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type_id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`title` varchar(200) NOT NULL,
`content` text NOT NULL,
`time` datetime NOT NULL,
`yd_num` int(11) NOT NULL,
`pl_num` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`imgs` text NOT NULL,
`state` int(4) NOT NULL DEFAULT '1',
`sh_time` datetime NOT NULL,
`type` int(4) NOT NULL,
`cityname` varchar(50) NOT NULL,
`jianjie` varchar(50),
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_zx_assess`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_zx_assess` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`zx_id` int(4) NOT NULL,
`score` int(11) NOT NULL,
`content` text NOT NULL,
`img` varchar(500) NOT NULL,
`cerated_time` datetime NOT NULL,
`user_id` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`status` int(4) NOT NULL,
`reply` text NOT NULL,
`reply_time` datetime NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_zx_type`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_zx_type` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type_name` varchar(100) NOT NULL,
`icon` varchar(100) NOT NULL,
`sort` int(4) NOT NULL,
`time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chbl_sun_zx_zj`;
CREATE TABLE IF NOT EXISTS `ims_chbl_sun_zx_zj` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`zx_id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");
