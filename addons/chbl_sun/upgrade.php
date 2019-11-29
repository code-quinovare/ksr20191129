<?php
pdo_query("CREATE TABLE IF NOT EXISTS `ims_chbl_sun_account` (
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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_activerecord` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`uniacid` int(10) unsigned NOT NULL DEFAULT '0',
`uid` int(10),
`pid` int(10) DEFAULT '0',
`num` int(10) DEFAULT '0',
`createtime` int(10) unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_area` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`area_name` varchar(50) NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_banner` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`bname` varchar(45) NOT NULL,
`lb_imgs` varchar(500) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_car_my_tag` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`tag_id` int(11) NOT NULL,
`car_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_car_tag` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`typename` varchar(30) NOT NULL,
`tagname` varchar(30) NOT NULL,
`uniacid` varchar(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_car_top` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`uniacid` int(11) NOT NULL,
`num` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_carpaylog` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`car_id` int(44) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_earnings` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`son_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_fabuset` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type` int(5),
`price` varchar(15) DEFAULT '0',
`uniacid` varchar(15),
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_fx` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`zf_user_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_fxuser` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`fx_user` int(11) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_goods_spec` (
`spec_value` varchar(45) NOT NULL,
`id` int(11) NOT NULL AUTO_INCREMENT,
`spec_name` varchar(100) NOT NULL,
`sort` int(4) NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_hblq` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`tz_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_help` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`question` varchar(200) NOT NULL,
`answer` text NOT NULL,
`sort` int(4) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`created_time` datetime NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_hotcity` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`cityname` varchar(50) NOT NULL,
`time` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`user_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_in` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_label` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`label_name` varchar(20) NOT NULL,
`type2_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_like` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`information_id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`zx_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_mylabel` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`label_id` int(11) NOT NULL,
`information_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_paylog` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`fid` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
`note` varchar(100) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_share` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`information_id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`store_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_spec_value` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`goods_id` int(11) NOT NULL,
`spec_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`name` varchar(50) NOT NULL,
`num` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_store_wallet` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`store_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`note` varchar(20) NOT NULL,
`type` int(11) NOT NULL,
`time` varchar(20) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_storein` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_storepaylog` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`store_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_storetype2` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(20) NOT NULL,
`type_id` int(11) NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`state` int(4) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_top` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`uniacid` int(11) NOT NULL,
`num` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_type2` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(20) NOT NULL,
`type_id` int(11) NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`state` int(4) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_tzpaylog` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`tz_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_user_vipcard` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uid` text NOT NULL,
`vipcard_id` int(11) NOT NULL,
`card_number` varchar(45) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_userformid` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`form_id` varchar(50) NOT NULL,
`time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
`openid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_yellowpaylog` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`hy_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_yellowset` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`days` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_zx_type` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type_name` varchar(100) NOT NULL,
`icon` varchar(100) NOT NULL,
`sort` int(4) NOT NULL,
`time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chbl_sun_zx_zj` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`zx_id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `weid` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'storeid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `storeid` varchar(1000) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `uid` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'from_user')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `from_user` varchar(100) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'accountname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `accountname` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'password')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `password` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'salt')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `salt` varchar(10) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'pwd')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `pwd` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'mobile')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `mobile` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'email')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `email` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'username')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `username` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'pay_account')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `pay_account` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'displayorder')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'dateline')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `dateline` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'status')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `status` tinyint(1) unsigned NOT NULL DEFAULT '2';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'role')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `role` tinyint(1) unsigned NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'lastvisit')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `lastvisit` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'lastip')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `lastip` varchar(15) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'areaid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `areaid` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'is_admin_order')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `is_admin_order` tinyint(1) unsigned NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'is_notice_order')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `is_notice_order` tinyint(1) unsigned NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'is_notice_queue')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `is_notice_queue` tinyint(1) unsigned NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'is_notice_service')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `is_notice_service` tinyint(1) unsigned NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'is_notice_boss')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `is_notice_boss` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'remark')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `remark` varchar(1000) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'lat')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'lng')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000';");
	}	
}
if(pdo_tableexists('chbl_sun_account')) {
	if(!pdo_fieldexists('chbl_sun_account',  'cityname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_account')." ADD `cityname` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `uniacid` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'subtitle')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `subtitle` varchar(45);");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'title')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `title` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `createtime` int(13) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'content')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `content` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'sort')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `sort` int(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'antime')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `antime` timestamp;");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'hits')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `hits` int(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'status')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `status` tinyint(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'astime')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `astime` timestamp;");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'thumb')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `thumb` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `num` int(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'sharenum')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `sharenum` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'thumb_url')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `thumb_url` text;");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'part_num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `part_num` varchar(15) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'share_plus')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `share_plus` varchar(15) DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'new_partnum')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `new_partnum` varchar(15) DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `user_id` varchar(100);");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'storeinfo')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `storeinfo` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'showindex')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `showindex` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_active')) {
	if(!pdo_fieldexists('chbl_sun_active',  'active_num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_active')." ADD `active_num` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_activerecord')) {
	if(!pdo_fieldexists('chbl_sun_activerecord',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_activerecord')." ADD `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_activerecord')) {
	if(!pdo_fieldexists('chbl_sun_activerecord',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_activerecord')." ADD `uniacid` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_activerecord')) {
	if(!pdo_fieldexists('chbl_sun_activerecord',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_activerecord')." ADD `uid` int(10);");
	}	
}
if(pdo_tableexists('chbl_sun_activerecord')) {
	if(!pdo_fieldexists('chbl_sun_activerecord',  'pid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_activerecord')." ADD `pid` int(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_activerecord')) {
	if(!pdo_fieldexists('chbl_sun_activerecord',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_activerecord')." ADD `num` int(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_activerecord')) {
	if(!pdo_fieldexists('chbl_sun_activerecord',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_activerecord')." ADD `createtime` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_ad')) {
	if(!pdo_fieldexists('chbl_sun_ad',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_ad')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_ad')) {
	if(!pdo_fieldexists('chbl_sun_ad',  'title')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_ad')." ADD `title` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_ad')) {
	if(!pdo_fieldexists('chbl_sun_ad',  'logo')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_ad')." ADD `logo` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_ad')) {
	if(!pdo_fieldexists('chbl_sun_ad',  'status')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_ad')." ADD `status` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_ad')) {
	if(!pdo_fieldexists('chbl_sun_ad',  'src')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_ad')." ADD `src` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_ad')) {
	if(!pdo_fieldexists('chbl_sun_ad',  'orderby')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_ad')." ADD `orderby` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_ad')) {
	if(!pdo_fieldexists('chbl_sun_ad',  'xcx_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_ad')." ADD `xcx_name` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_ad')) {
	if(!pdo_fieldexists('chbl_sun_ad',  'appid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_ad')." ADD `appid` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_ad')) {
	if(!pdo_fieldexists('chbl_sun_ad',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_ad')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_ad')) {
	if(!pdo_fieldexists('chbl_sun_ad',  'type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_ad')." ADD `type` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_ad')) {
	if(!pdo_fieldexists('chbl_sun_ad',  'cityname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_ad')." ADD `cityname` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_ad')) {
	if(!pdo_fieldexists('chbl_sun_ad',  'wb_src')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_ad')." ADD `wb_src` varchar(300) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_ad')) {
	if(!pdo_fieldexists('chbl_sun_ad',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_ad')." ADD `state` int(4) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_address')) {
	if(!pdo_fieldexists('chbl_sun_address',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_address')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_address')) {
	if(!pdo_fieldexists('chbl_sun_address',  'consignee')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_address')." ADD `consignee` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_address')) {
	if(!pdo_fieldexists('chbl_sun_address',  'phone')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_address')." ADD `phone` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_address')) {
	if(!pdo_fieldexists('chbl_sun_address',  'address')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_address')." ADD `address` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_address')) {
	if(!pdo_fieldexists('chbl_sun_address',  'stree')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_address')." ADD `stree` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_address')) {
	if(!pdo_fieldexists('chbl_sun_address',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_address')." ADD `uid` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_address')) {
	if(!pdo_fieldexists('chbl_sun_address',  'isdefault')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_address')." ADD `isdefault` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_address')) {
	if(!pdo_fieldexists('chbl_sun_address',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_address')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_area')) {
	if(!pdo_fieldexists('chbl_sun_area',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_area')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_area')) {
	if(!pdo_fieldexists('chbl_sun_area',  'area_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_area')." ADD `area_name` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_area')) {
	if(!pdo_fieldexists('chbl_sun_area',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_area')." ADD `num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_area')) {
	if(!pdo_fieldexists('chbl_sun_area',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_area')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_banner')) {
	if(!pdo_fieldexists('chbl_sun_banner',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_banner')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_banner')) {
	if(!pdo_fieldexists('chbl_sun_banner',  'bname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_banner')." ADD `bname` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_banner')) {
	if(!pdo_fieldexists('chbl_sun_banner',  'lb_imgs')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_banner')." ADD `lb_imgs` varchar(500) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_banner')) {
	if(!pdo_fieldexists('chbl_sun_banner',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_banner')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_bargain')) {
	if(!pdo_fieldexists('chbl_sun_bargain',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_bargain')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_bargain')) {
	if(!pdo_fieldexists('chbl_sun_bargain',  'gname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_bargain')." ADD `gname` varchar(100);");
	}	
}
if(pdo_tableexists('chbl_sun_bargain')) {
	if(!pdo_fieldexists('chbl_sun_bargain',  'marketprice')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_bargain')." ADD `marketprice` varchar(45);");
	}	
}
if(pdo_tableexists('chbl_sun_bargain')) {
	if(!pdo_fieldexists('chbl_sun_bargain',  'selftime')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_bargain')." ADD `selftime` varchar(100);");
	}	
}
if(pdo_tableexists('chbl_sun_bargain')) {
	if(!pdo_fieldexists('chbl_sun_bargain',  'pic')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_bargain')." ADD `pic` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_bargain')) {
	if(!pdo_fieldexists('chbl_sun_bargain',  'details')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_bargain')." ADD `details` text;");
	}	
}
if(pdo_tableexists('chbl_sun_bargain')) {
	if(!pdo_fieldexists('chbl_sun_bargain',  'status')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_bargain')." ADD `status` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_bargain')) {
	if(!pdo_fieldexists('chbl_sun_bargain',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_bargain')." ADD `uniacid` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_bargain')) {
	if(!pdo_fieldexists('chbl_sun_bargain',  'starttime')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_bargain')." ADD `starttime` timestamp;");
	}	
}
if(pdo_tableexists('chbl_sun_bargain')) {
	if(!pdo_fieldexists('chbl_sun_bargain',  'shopprice')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_bargain')." ADD `shopprice` varchar(45);");
	}	
}
if(pdo_tableexists('chbl_sun_bargain')) {
	if(!pdo_fieldexists('chbl_sun_bargain',  'endtime')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_bargain')." ADD `endtime` timestamp;");
	}	
}
if(pdo_tableexists('chbl_sun_bargain')) {
	if(!pdo_fieldexists('chbl_sun_bargain',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_bargain')." ADD `num` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_bargain')) {
	if(!pdo_fieldexists('chbl_sun_bargain',  'content')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_bargain')." ADD `content` text;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'start_place')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `start_place` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'end_place')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `end_place` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'start_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `start_time` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `num` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'link_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `link_name` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'link_tel')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `link_tel` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'typename')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `typename` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'other')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `other` varchar(300) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'sh_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `sh_time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'top_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `top_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'top')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `top` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `state` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'tj_place')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `tj_place` varchar(300) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'hw_wet')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `hw_wet` varchar(10) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'star_lat')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `star_lat` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'star_lng')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `star_lng` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'end_lat')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `end_lat` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'end_lng')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `end_lng` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'is_open')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `is_open` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'start_time2')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `start_time2` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car')) {
	if(!pdo_fieldexists('chbl_sun_car',  'cityname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car')." ADD `cityname` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car_my_tag')) {
	if(!pdo_fieldexists('chbl_sun_car_my_tag',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car_my_tag')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_car_my_tag')) {
	if(!pdo_fieldexists('chbl_sun_car_my_tag',  'tag_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car_my_tag')." ADD `tag_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car_my_tag')) {
	if(!pdo_fieldexists('chbl_sun_car_my_tag',  'car_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car_my_tag')." ADD `car_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car_tag')) {
	if(!pdo_fieldexists('chbl_sun_car_tag',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car_tag')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_car_tag')) {
	if(!pdo_fieldexists('chbl_sun_car_tag',  'typename')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car_tag')." ADD `typename` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car_tag')) {
	if(!pdo_fieldexists('chbl_sun_car_tag',  'tagname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car_tag')." ADD `tagname` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car_tag')) {
	if(!pdo_fieldexists('chbl_sun_car_tag',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car_tag')." ADD `uniacid` varchar(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car_top')) {
	if(!pdo_fieldexists('chbl_sun_car_top',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car_top')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_car_top')) {
	if(!pdo_fieldexists('chbl_sun_car_top',  'type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car_top')." ADD `type` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car_top')) {
	if(!pdo_fieldexists('chbl_sun_car_top',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car_top')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car_top')) {
	if(!pdo_fieldexists('chbl_sun_car_top',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car_top')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_car_top')) {
	if(!pdo_fieldexists('chbl_sun_car_top',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_car_top')." ADD `num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_carpaylog')) {
	if(!pdo_fieldexists('chbl_sun_carpaylog',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_carpaylog')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_carpaylog')) {
	if(!pdo_fieldexists('chbl_sun_carpaylog',  'car_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_carpaylog')." ADD `car_id` int(44) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_carpaylog')) {
	if(!pdo_fieldexists('chbl_sun_carpaylog',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_carpaylog')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_carpaylog')) {
	if(!pdo_fieldexists('chbl_sun_carpaylog',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_carpaylog')." ADD `time` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_carpaylog')) {
	if(!pdo_fieldexists('chbl_sun_carpaylog',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_carpaylog')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_comments')) {
	if(!pdo_fieldexists('chbl_sun_comments',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_comments')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_comments')) {
	if(!pdo_fieldexists('chbl_sun_comments',  'information_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_comments')." ADD `information_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_comments')) {
	if(!pdo_fieldexists('chbl_sun_comments',  'details')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_comments')." ADD `details` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_comments')) {
	if(!pdo_fieldexists('chbl_sun_comments',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_comments')." ADD `time` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_comments')) {
	if(!pdo_fieldexists('chbl_sun_comments',  'reply')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_comments')." ADD `reply` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_comments')) {
	if(!pdo_fieldexists('chbl_sun_comments',  'hf_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_comments')." ADD `hf_time` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_comments')) {
	if(!pdo_fieldexists('chbl_sun_comments',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_comments')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_comments')) {
	if(!pdo_fieldexists('chbl_sun_comments',  'store_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_comments')." ADD `store_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_comments')) {
	if(!pdo_fieldexists('chbl_sun_comments',  'score')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_comments')." ADD `score` decimal(10,1) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_commission_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_commission_withdrawal',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_commission_withdrawal')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_commission_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_commission_withdrawal',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_commission_withdrawal')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_commission_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_commission_withdrawal',  'type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_commission_withdrawal')." ADD `type` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_commission_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_commission_withdrawal',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_commission_withdrawal')." ADD `state` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_commission_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_commission_withdrawal',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_commission_withdrawal')." ADD `time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_commission_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_commission_withdrawal',  'sh_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_commission_withdrawal')." ADD `sh_time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_commission_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_commission_withdrawal',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_commission_withdrawal')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_commission_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_commission_withdrawal',  'user_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_commission_withdrawal')." ADD `user_name` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_commission_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_commission_withdrawal',  'account')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_commission_withdrawal')." ADD `account` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_commission_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_commission_withdrawal',  'tx_cost')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_commission_withdrawal')." ADD `tx_cost` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_commission_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_commission_withdrawal',  'sj_cost')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_commission_withdrawal')." ADD `sj_cost` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_coupon_order')) {
	if(!pdo_fieldexists('chbl_sun_coupon_order',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_coupon_order')." ADD `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_coupon_order')) {
	if(!pdo_fieldexists('chbl_sun_coupon_order',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_coupon_order')." ADD `uniacid` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_coupon_order')) {
	if(!pdo_fieldexists('chbl_sun_coupon_order',  'pid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_coupon_order')." ADD `pid` int(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_coupon_order')) {
	if(!pdo_fieldexists('chbl_sun_coupon_order',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_coupon_order')." ADD `uid` int(10);");
	}	
}
if(pdo_tableexists('chbl_sun_coupon_order')) {
	if(!pdo_fieldexists('chbl_sun_coupon_order',  'cid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_coupon_order')." ADD `cid` int(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_coupon_order')) {
	if(!pdo_fieldexists('chbl_sun_coupon_order',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_coupon_order')." ADD `createtime` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_coupon_order')) {
	if(!pdo_fieldexists('chbl_sun_coupon_order',  'status')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_coupon_order')." ADD `status` tinyint(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_coupon_order')) {
	if(!pdo_fieldexists('chbl_sun_coupon_order',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_coupon_order')." ADD `num` int(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_distribution')) {
	if(!pdo_fieldexists('chbl_sun_distribution',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_distribution')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_distribution')) {
	if(!pdo_fieldexists('chbl_sun_distribution',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_distribution')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_distribution')) {
	if(!pdo_fieldexists('chbl_sun_distribution',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_distribution')." ADD `time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_distribution')) {
	if(!pdo_fieldexists('chbl_sun_distribution',  'user_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_distribution')." ADD `user_name` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_distribution')) {
	if(!pdo_fieldexists('chbl_sun_distribution',  'user_tel')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_distribution')." ADD `user_tel` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_distribution')) {
	if(!pdo_fieldexists('chbl_sun_distribution',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_distribution')." ADD `state` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_distribution')) {
	if(!pdo_fieldexists('chbl_sun_distribution',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_distribution')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_earnings')) {
	if(!pdo_fieldexists('chbl_sun_earnings',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_earnings')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_earnings')) {
	if(!pdo_fieldexists('chbl_sun_earnings',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_earnings')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_earnings')) {
	if(!pdo_fieldexists('chbl_sun_earnings',  'son_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_earnings')." ADD `son_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_earnings')) {
	if(!pdo_fieldexists('chbl_sun_earnings',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_earnings')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_earnings')) {
	if(!pdo_fieldexists('chbl_sun_earnings',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_earnings')." ADD `time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_earnings')) {
	if(!pdo_fieldexists('chbl_sun_earnings',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_earnings')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fabuset')) {
	if(!pdo_fieldexists('chbl_sun_fabuset',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fabuset')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_fabuset')) {
	if(!pdo_fieldexists('chbl_sun_fabuset',  'type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fabuset')." ADD `type` int(5);");
	}	
}
if(pdo_tableexists('chbl_sun_fabuset')) {
	if(!pdo_fieldexists('chbl_sun_fabuset',  'price')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fabuset')." ADD `price` varchar(15) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_fabuset')) {
	if(!pdo_fieldexists('chbl_sun_fabuset',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fabuset')." ADD `uniacid` varchar(15);");
	}	
}
if(pdo_tableexists('chbl_sun_fx')) {
	if(!pdo_fieldexists('chbl_sun_fx',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fx')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_fx')) {
	if(!pdo_fieldexists('chbl_sun_fx',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fx')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fx')) {
	if(!pdo_fieldexists('chbl_sun_fx',  'zf_user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fx')." ADD `zf_user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fx')) {
	if(!pdo_fieldexists('chbl_sun_fx',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fx')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fx')) {
	if(!pdo_fieldexists('chbl_sun_fx',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fx')." ADD `time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fx')) {
	if(!pdo_fieldexists('chbl_sun_fx',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fx')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fxset')) {
	if(!pdo_fieldexists('chbl_sun_fxset',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxset')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_fxset')) {
	if(!pdo_fieldexists('chbl_sun_fxset',  'fx_details')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxset')." ADD `fx_details` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fxset')) {
	if(!pdo_fieldexists('chbl_sun_fxset',  'tx_details')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxset')." ADD `tx_details` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fxset')) {
	if(!pdo_fieldexists('chbl_sun_fxset',  'is_fx')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxset')." ADD `is_fx` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fxset')) {
	if(!pdo_fieldexists('chbl_sun_fxset',  'is_ej')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxset')." ADD `is_ej` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fxset')) {
	if(!pdo_fieldexists('chbl_sun_fxset',  'tx_rate')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxset')." ADD `tx_rate` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fxset')) {
	if(!pdo_fieldexists('chbl_sun_fxset',  'commission')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxset')." ADD `commission` varchar(10) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fxset')) {
	if(!pdo_fieldexists('chbl_sun_fxset',  'commission2')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxset')." ADD `commission2` varchar(10) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fxset')) {
	if(!pdo_fieldexists('chbl_sun_fxset',  'tx_money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxset')." ADD `tx_money` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fxset')) {
	if(!pdo_fieldexists('chbl_sun_fxset',  'img')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxset')." ADD `img` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fxset')) {
	if(!pdo_fieldexists('chbl_sun_fxset',  'img2')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxset')." ADD `img2` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fxset')) {
	if(!pdo_fieldexists('chbl_sun_fxset',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxset')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fxset')) {
	if(!pdo_fieldexists('chbl_sun_fxset',  'is_open')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxset')." ADD `is_open` int(11) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_fxset')) {
	if(!pdo_fieldexists('chbl_sun_fxset',  'instructions')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxset')." ADD `instructions` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fxuser')) {
	if(!pdo_fieldexists('chbl_sun_fxuser',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxuser')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_fxuser')) {
	if(!pdo_fieldexists('chbl_sun_fxuser',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxuser')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fxuser')) {
	if(!pdo_fieldexists('chbl_sun_fxuser',  'fx_user')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxuser')." ADD `fx_user` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_fxuser')) {
	if(!pdo_fieldexists('chbl_sun_fxuser',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_fxuser')." ADD `time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_gift')) {
	if(!pdo_fieldexists('chbl_sun_gift',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift')." ADD `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_gift')) {
	if(!pdo_fieldexists('chbl_sun_gift',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift')." ADD `uniacid` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_gift')) {
	if(!pdo_fieldexists('chbl_sun_gift',  'title')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift')." ADD `title` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_gift')) {
	if(!pdo_fieldexists('chbl_sun_gift',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift')." ADD `createtime` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_gift')) {
	if(!pdo_fieldexists('chbl_sun_gift',  'content')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift')." ADD `content` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_gift')) {
	if(!pdo_fieldexists('chbl_sun_gift',  'sort')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift')." ADD `sort` int(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_gift')) {
	if(!pdo_fieldexists('chbl_sun_gift',  'hits')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift')." ADD `hits` int(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_gift')) {
	if(!pdo_fieldexists('chbl_sun_gift',  'status')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift')." ADD `status` tinyint(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_gift')) {
	if(!pdo_fieldexists('chbl_sun_gift',  'thumb')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift')." ADD `thumb` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_gift')) {
	if(!pdo_fieldexists('chbl_sun_gift',  'thumb2')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift')." ADD `thumb2` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_gift')) {
	if(!pdo_fieldexists('chbl_sun_gift',  'pid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift')." ADD `pid` int(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_gift')) {
	if(!pdo_fieldexists('chbl_sun_gift',  'rate')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift')." ADD `rate` mediumint(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_gift_order')) {
	if(!pdo_fieldexists('chbl_sun_gift_order',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift_order')." ADD `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_gift_order')) {
	if(!pdo_fieldexists('chbl_sun_gift_order',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift_order')." ADD `uniacid` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_gift_order')) {
	if(!pdo_fieldexists('chbl_sun_gift_order',  'pid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift_order')." ADD `pid` int(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_gift_order')) {
	if(!pdo_fieldexists('chbl_sun_gift_order',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift_order')." ADD `uid` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_gift_order')) {
	if(!pdo_fieldexists('chbl_sun_gift_order',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift_order')." ADD `createtime` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_gift_order')) {
	if(!pdo_fieldexists('chbl_sun_gift_order',  'status')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift_order')." ADD `status` tinyint(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_gift_order')) {
	if(!pdo_fieldexists('chbl_sun_gift_order',  'consignee')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift_order')." ADD `consignee` varchar(45);");
	}	
}
if(pdo_tableexists('chbl_sun_gift_order')) {
	if(!pdo_fieldexists('chbl_sun_gift_order',  'tel')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift_order')." ADD `tel` varchar(45);");
	}	
}
if(pdo_tableexists('chbl_sun_gift_order')) {
	if(!pdo_fieldexists('chbl_sun_gift_order',  'note')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_gift_order')." ADD `note` varchar(150);");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'store_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `store_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'goods_volume')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `goods_volume` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'spec_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `spec_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'goods_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `goods_name` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'goods_num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `goods_num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'goods_price')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `goods_price` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'goods_cost')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `goods_cost` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'type_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `type_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'freight')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `freight` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'delivery')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `delivery` varchar(500) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'quality')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `quality` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'free')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `free` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'all_day')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `all_day` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'service')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `service` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'refund')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `refund` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'weeks')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `weeks` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'lb_imgs')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `lb_imgs` varchar(500) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'imgs')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `imgs` varchar(500) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'goods_details')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `goods_details` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `state` int(4) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'sy_num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `sy_num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'is_show')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `is_show` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'sales')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `sales` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'spec_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `spec_name` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'spec_value')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `spec_value` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'spec_names')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `spec_names` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods')) {
	if(!pdo_fieldexists('chbl_sun_goods',  'spec_values')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods')." ADD `spec_values` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods_spec')) {
	if(!pdo_fieldexists('chbl_sun_goods_spec',  'spec_value')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods_spec')." ADD `spec_value` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods_spec')) {
	if(!pdo_fieldexists('chbl_sun_goods_spec',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods_spec')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_goods_spec')) {
	if(!pdo_fieldexists('chbl_sun_goods_spec',  'spec_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods_spec')." ADD `spec_name` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods_spec')) {
	if(!pdo_fieldexists('chbl_sun_goods_spec',  'sort')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods_spec')." ADD `sort` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_goods_spec')) {
	if(!pdo_fieldexists('chbl_sun_goods_spec',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_goods_spec')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_groups')) {
	if(!pdo_fieldexists('chbl_sun_groups',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_groups')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_groups')) {
	if(!pdo_fieldexists('chbl_sun_groups',  'gname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_groups')." ADD `gname` varchar(100);");
	}	
}
if(pdo_tableexists('chbl_sun_groups')) {
	if(!pdo_fieldexists('chbl_sun_groups',  'marketprice')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_groups')." ADD `marketprice` decimal(10,2);");
	}	
}
if(pdo_tableexists('chbl_sun_groups')) {
	if(!pdo_fieldexists('chbl_sun_groups',  'selftime')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_groups')." ADD `selftime` varchar(100);");
	}	
}
if(pdo_tableexists('chbl_sun_groups')) {
	if(!pdo_fieldexists('chbl_sun_groups',  'pic')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_groups')." ADD `pic` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_groups')) {
	if(!pdo_fieldexists('chbl_sun_groups',  'details')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_groups')." ADD `details` text;");
	}	
}
if(pdo_tableexists('chbl_sun_groups')) {
	if(!pdo_fieldexists('chbl_sun_groups',  'status')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_groups')." ADD `status` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_groups')) {
	if(!pdo_fieldexists('chbl_sun_groups',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_groups')." ADD `uniacid` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_groups')) {
	if(!pdo_fieldexists('chbl_sun_groups',  'starttime')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_groups')." ADD `starttime` timestamp;");
	}	
}
if(pdo_tableexists('chbl_sun_groups')) {
	if(!pdo_fieldexists('chbl_sun_groups',  'shopprice')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_groups')." ADD `shopprice` decimal(10,2);");
	}	
}
if(pdo_tableexists('chbl_sun_groups')) {
	if(!pdo_fieldexists('chbl_sun_groups',  'endtime')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_groups')." ADD `endtime` timestamp;");
	}	
}
if(pdo_tableexists('chbl_sun_groups')) {
	if(!pdo_fieldexists('chbl_sun_groups',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_groups')." ADD `num` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_groups')) {
	if(!pdo_fieldexists('chbl_sun_groups',  'content')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_groups')." ADD `content` text;");
	}	
}
if(pdo_tableexists('chbl_sun_groups')) {
	if(!pdo_fieldexists('chbl_sun_groups',  'groups_num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_groups')." ADD `groups_num` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_groups')) {
	if(!pdo_fieldexists('chbl_sun_groups',  'is_deliver')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_groups')." ADD `is_deliver` int(2) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_hblq')) {
	if(!pdo_fieldexists('chbl_sun_hblq',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_hblq')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_hblq')) {
	if(!pdo_fieldexists('chbl_sun_hblq',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_hblq')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_hblq')) {
	if(!pdo_fieldexists('chbl_sun_hblq',  'tz_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_hblq')." ADD `tz_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_hblq')) {
	if(!pdo_fieldexists('chbl_sun_hblq',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_hblq')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_hblq')) {
	if(!pdo_fieldexists('chbl_sun_hblq',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_hblq')." ADD `time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_hblq')) {
	if(!pdo_fieldexists('chbl_sun_hblq',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_hblq')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_help')) {
	if(!pdo_fieldexists('chbl_sun_help',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_help')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_help')) {
	if(!pdo_fieldexists('chbl_sun_help',  'question')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_help')." ADD `question` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_help')) {
	if(!pdo_fieldexists('chbl_sun_help',  'answer')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_help')." ADD `answer` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_help')) {
	if(!pdo_fieldexists('chbl_sun_help',  'sort')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_help')." ADD `sort` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_help')) {
	if(!pdo_fieldexists('chbl_sun_help',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_help')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_help')) {
	if(!pdo_fieldexists('chbl_sun_help',  'created_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_help')." ADD `created_time` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_hotcity')) {
	if(!pdo_fieldexists('chbl_sun_hotcity',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_hotcity')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_hotcity')) {
	if(!pdo_fieldexists('chbl_sun_hotcity',  'cityname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_hotcity')." ADD `cityname` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_hotcity')) {
	if(!pdo_fieldexists('chbl_sun_hotcity',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_hotcity')." ADD `time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_hotcity')) {
	if(!pdo_fieldexists('chbl_sun_hotcity',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_hotcity')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_hotcity')) {
	if(!pdo_fieldexists('chbl_sun_hotcity',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_hotcity')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_in')) {
	if(!pdo_fieldexists('chbl_sun_in',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_in')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_in')) {
	if(!pdo_fieldexists('chbl_sun_in',  'type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_in')." ADD `type` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_in')) {
	if(!pdo_fieldexists('chbl_sun_in',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_in')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_in')) {
	if(!pdo_fieldexists('chbl_sun_in',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_in')." ADD `num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_in')) {
	if(!pdo_fieldexists('chbl_sun_in',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_in')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'details')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `details` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'img')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `img` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'user_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `user_name` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'user_tel')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `user_tel` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'hot')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `hot` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'top')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `top` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'givelike')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `givelike` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'views')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `views` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'type2_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `type2_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'type_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `type_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `state` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'sh_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `sh_time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'top_type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `top_type` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'address')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `address` varchar(500) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'hb_money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `hb_money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'hb_num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `hb_num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'hb_type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `hb_type` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'hb_keyword')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `hb_keyword` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'hb_random')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `hb_random` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'hong')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `hong` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'store_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `store_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'del')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `del` int(11) NOT NULL DEFAULT '2';");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'user_img2')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `user_img2` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'dq_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `dq_time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'cityname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `cityname` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_information')) {
	if(!pdo_fieldexists('chbl_sun_information',  'hbfx_num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_information')." ADD `hbfx_num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_label')) {
	if(!pdo_fieldexists('chbl_sun_label',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_label')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_label')) {
	if(!pdo_fieldexists('chbl_sun_label',  'label_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_label')." ADD `label_name` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_label')) {
	if(!pdo_fieldexists('chbl_sun_label',  'type2_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_label')." ADD `type2_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_like')) {
	if(!pdo_fieldexists('chbl_sun_like',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_like')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_like')) {
	if(!pdo_fieldexists('chbl_sun_like',  'information_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_like')." ADD `information_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_like')) {
	if(!pdo_fieldexists('chbl_sun_like',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_like')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_like')) {
	if(!pdo_fieldexists('chbl_sun_like',  'zx_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_like')." ADD `zx_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_mylabel')) {
	if(!pdo_fieldexists('chbl_sun_mylabel',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_mylabel')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_mylabel')) {
	if(!pdo_fieldexists('chbl_sun_mylabel',  'label_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_mylabel')." ADD `label_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_mylabel')) {
	if(!pdo_fieldexists('chbl_sun_mylabel',  'information_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_mylabel')." ADD `information_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_news')) {
	if(!pdo_fieldexists('chbl_sun_news',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_news')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_news')) {
	if(!pdo_fieldexists('chbl_sun_news',  'title')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_news')." ADD `title` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_news')) {
	if(!pdo_fieldexists('chbl_sun_news',  'details')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_news')." ADD `details` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_news')) {
	if(!pdo_fieldexists('chbl_sun_news',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_news')." ADD `num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_news')) {
	if(!pdo_fieldexists('chbl_sun_news',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_news')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_news')) {
	if(!pdo_fieldexists('chbl_sun_news',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_news')." ADD `time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_news')) {
	if(!pdo_fieldexists('chbl_sun_news',  'img')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_news')." ADD `img` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_news')) {
	if(!pdo_fieldexists('chbl_sun_news',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_news')." ADD `state` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_news')) {
	if(!pdo_fieldexists('chbl_sun_news',  'type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_news')." ADD `type` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_news')) {
	if(!pdo_fieldexists('chbl_sun_news',  'cityname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_news')." ADD `cityname` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `user_id` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'store_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `store_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'user_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `user_name` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'address')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `address` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'tel')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `tel` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'pay_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `pay_time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'complete_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `complete_time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'fh_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `fh_time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `state` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'order_num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `order_num` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'good_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `good_id` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'good_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `good_name` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'good_img')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `good_img` varchar(400) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'good_money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `good_money` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'out_trade_no')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `out_trade_no` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'good_spec')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `good_spec` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'del')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `del` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'del2')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `del2` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'freight')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `freight` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'note')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `note` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_order')) {
	if(!pdo_fieldexists('chbl_sun_order',  'good_num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_order')." ADD `good_num` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_paylog')) {
	if(!pdo_fieldexists('chbl_sun_paylog',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_paylog')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_paylog')) {
	if(!pdo_fieldexists('chbl_sun_paylog',  'fid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_paylog')." ADD `fid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_paylog')) {
	if(!pdo_fieldexists('chbl_sun_paylog',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_paylog')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_paylog')) {
	if(!pdo_fieldexists('chbl_sun_paylog',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_paylog')." ADD `time` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_paylog')) {
	if(!pdo_fieldexists('chbl_sun_paylog',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_paylog')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_paylog')) {
	if(!pdo_fieldexists('chbl_sun_paylog',  'note')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_paylog')." ADD `note` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_share')) {
	if(!pdo_fieldexists('chbl_sun_share',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_share')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_share')) {
	if(!pdo_fieldexists('chbl_sun_share',  'information_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_share')." ADD `information_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_share')) {
	if(!pdo_fieldexists('chbl_sun_share',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_share')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_share')) {
	if(!pdo_fieldexists('chbl_sun_share',  'store_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_share')." ADD `store_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_shop_car')) {
	if(!pdo_fieldexists('chbl_sun_shop_car',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_shop_car')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_shop_car')) {
	if(!pdo_fieldexists('chbl_sun_shop_car',  'gid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_shop_car')." ADD `gid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_shop_car')) {
	if(!pdo_fieldexists('chbl_sun_shop_car',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_shop_car')." ADD `num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_shop_car')) {
	if(!pdo_fieldexists('chbl_sun_shop_car',  'combine')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_shop_car')." ADD `combine` varchar(110) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_shop_car')) {
	if(!pdo_fieldexists('chbl_sun_shop_car',  'gname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_shop_car')." ADD `gname` varchar(55) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_shop_car')) {
	if(!pdo_fieldexists('chbl_sun_shop_car',  'price')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_shop_car')." ADD `price` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_shop_car')) {
	if(!pdo_fieldexists('chbl_sun_shop_car',  'pic')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_shop_car')." ADD `pic` varchar(110) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_shop_car')) {
	if(!pdo_fieldexists('chbl_sun_shop_car',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_shop_car')." ADD `uid` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_shop_car')) {
	if(!pdo_fieldexists('chbl_sun_shop_car',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_shop_car')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_sms')) {
	if(!pdo_fieldexists('chbl_sun_sms',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_sms')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_sms')) {
	if(!pdo_fieldexists('chbl_sun_sms',  'appkey')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_sms')." ADD `appkey` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_sms')) {
	if(!pdo_fieldexists('chbl_sun_sms',  'tpl_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_sms')." ADD `tpl_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_sms')) {
	if(!pdo_fieldexists('chbl_sun_sms',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_sms')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_sms')) {
	if(!pdo_fieldexists('chbl_sun_sms',  'is_open')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_sms')." ADD `is_open` int(11) NOT NULL DEFAULT '2';");
	}	
}
if(pdo_tableexists('chbl_sun_sms')) {
	if(!pdo_fieldexists('chbl_sun_sms',  'tid1')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_sms')." ADD `tid1` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_sms')) {
	if(!pdo_fieldexists('chbl_sun_sms',  'tid2')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_sms')." ADD `tid2` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_sms')) {
	if(!pdo_fieldexists('chbl_sun_sms',  'tid3')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_sms')." ADD `tid3` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_spec_value')) {
	if(!pdo_fieldexists('chbl_sun_spec_value',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_spec_value')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_spec_value')) {
	if(!pdo_fieldexists('chbl_sun_spec_value',  'goods_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_spec_value')." ADD `goods_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_spec_value')) {
	if(!pdo_fieldexists('chbl_sun_spec_value',  'spec_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_spec_value')." ADD `spec_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_spec_value')) {
	if(!pdo_fieldexists('chbl_sun_spec_value',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_spec_value')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_spec_value')) {
	if(!pdo_fieldexists('chbl_sun_spec_value',  'name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_spec_value')." ADD `name` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_spec_value')) {
	if(!pdo_fieldexists('chbl_sun_spec_value',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_spec_value')." ADD `num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'store_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `store_name` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'address')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `address` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'announcement')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `announcement` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'storetype_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `storetype_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'storetype2_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `storetype2_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'area_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `area_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'yy_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `yy_time` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'keyword')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `keyword` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'skzf')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `skzf` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'wifi')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `wifi` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'mftc')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `mftc` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'jzxy')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `jzxy` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'tgbj')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `tgbj` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'sfxx')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `sfxx` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'tel')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `tel` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'logo')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `logo` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'weixin_logo')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `weixin_logo` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'ad')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `ad` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `state` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'password')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `password` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'details')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `details` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'coordinates')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `coordinates` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'views')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `views` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'score')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `score` decimal(10,1) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `type` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'sh_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `sh_time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'time_over')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `time_over` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'img')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `img` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'vr_link')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `vr_link` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'start_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `start_time` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'end_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `end_time` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'wallet')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `wallet` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'user_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `user_name` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'pwd')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `pwd` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'dq_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `dq_time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'cityname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `cityname` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `time` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'fx_num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `fx_num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'ewm_logo')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `ewm_logo` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store')) {
	if(!pdo_fieldexists('chbl_sun_store',  'is_top')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store')." ADD `is_top` int(4) NOT NULL DEFAULT '2';");
	}	
}
if(pdo_tableexists('chbl_sun_store_active')) {
	if(!pdo_fieldexists('chbl_sun_store_active',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_active')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_store_active')) {
	if(!pdo_fieldexists('chbl_sun_store_active',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_active')." ADD `user_id` varchar(45);");
	}	
}
if(pdo_tableexists('chbl_sun_store_active')) {
	if(!pdo_fieldexists('chbl_sun_store_active',  'store_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_active')." ADD `store_name` varchar(45);");
	}	
}
if(pdo_tableexists('chbl_sun_store_active')) {
	if(!pdo_fieldexists('chbl_sun_store_active',  'tel')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_active')." ADD `tel` varchar(15);");
	}	
}
if(pdo_tableexists('chbl_sun_store_active')) {
	if(!pdo_fieldexists('chbl_sun_store_active',  'address')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_active')." ADD `address` varchar(45);");
	}	
}
if(pdo_tableexists('chbl_sun_store_active')) {
	if(!pdo_fieldexists('chbl_sun_store_active',  'dq_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_active')." ADD `dq_time` int(15);");
	}	
}
if(pdo_tableexists('chbl_sun_store_active')) {
	if(!pdo_fieldexists('chbl_sun_store_active',  'time_type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_active')." ADD `time_type` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_store_active')) {
	if(!pdo_fieldexists('chbl_sun_store_active',  'active_type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_active')." ADD `active_type` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_store_active')) {
	if(!pdo_fieldexists('chbl_sun_store_active',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_active')." ADD `state` int(11) DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_store_active')) {
	if(!pdo_fieldexists('chbl_sun_store_active',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_active')." ADD `uniacid` int(45);");
	}	
}
if(pdo_tableexists('chbl_sun_store_active')) {
	if(!pdo_fieldexists('chbl_sun_store_active',  'time_over')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_active')." ADD `time_over` int(15);");
	}	
}
if(pdo_tableexists('chbl_sun_store_active')) {
	if(!pdo_fieldexists('chbl_sun_store_active',  'rz_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_active')." ADD `rz_time` int(15);");
	}	
}
if(pdo_tableexists('chbl_sun_store_wallet')) {
	if(!pdo_fieldexists('chbl_sun_store_wallet',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_wallet')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_store_wallet')) {
	if(!pdo_fieldexists('chbl_sun_store_wallet',  'store_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_wallet')." ADD `store_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store_wallet')) {
	if(!pdo_fieldexists('chbl_sun_store_wallet',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_wallet')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store_wallet')) {
	if(!pdo_fieldexists('chbl_sun_store_wallet',  'note')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_wallet')." ADD `note` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store_wallet')) {
	if(!pdo_fieldexists('chbl_sun_store_wallet',  'type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_wallet')." ADD `type` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_store_wallet')) {
	if(!pdo_fieldexists('chbl_sun_store_wallet',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_store_wallet')." ADD `time` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storein')) {
	if(!pdo_fieldexists('chbl_sun_storein',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storein')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_storein')) {
	if(!pdo_fieldexists('chbl_sun_storein',  'type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storein')." ADD `type` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storein')) {
	if(!pdo_fieldexists('chbl_sun_storein',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storein')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storein')) {
	if(!pdo_fieldexists('chbl_sun_storein',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storein')." ADD `num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storein')) {
	if(!pdo_fieldexists('chbl_sun_storein',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storein')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storepaylog')) {
	if(!pdo_fieldexists('chbl_sun_storepaylog',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storepaylog')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_storepaylog')) {
	if(!pdo_fieldexists('chbl_sun_storepaylog',  'store_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storepaylog')." ADD `store_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storepaylog')) {
	if(!pdo_fieldexists('chbl_sun_storepaylog',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storepaylog')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storepaylog')) {
	if(!pdo_fieldexists('chbl_sun_storepaylog',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storepaylog')." ADD `time` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storepaylog')) {
	if(!pdo_fieldexists('chbl_sun_storepaylog',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storepaylog')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storetype')) {
	if(!pdo_fieldexists('chbl_sun_storetype',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storetype')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_storetype')) {
	if(!pdo_fieldexists('chbl_sun_storetype',  'type_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storetype')." ADD `type_name` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storetype')) {
	if(!pdo_fieldexists('chbl_sun_storetype',  'img')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storetype')." ADD `img` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storetype')) {
	if(!pdo_fieldexists('chbl_sun_storetype',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storetype')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storetype')) {
	if(!pdo_fieldexists('chbl_sun_storetype',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storetype')." ADD `num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storetype')) {
	if(!pdo_fieldexists('chbl_sun_storetype',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storetype')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storetype')) {
	if(!pdo_fieldexists('chbl_sun_storetype',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storetype')." ADD `state` int(4) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_storetype2')) {
	if(!pdo_fieldexists('chbl_sun_storetype2',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storetype2')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_storetype2')) {
	if(!pdo_fieldexists('chbl_sun_storetype2',  'name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storetype2')." ADD `name` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storetype2')) {
	if(!pdo_fieldexists('chbl_sun_storetype2',  'type_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storetype2')." ADD `type_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storetype2')) {
	if(!pdo_fieldexists('chbl_sun_storetype2',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storetype2')." ADD `num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storetype2')) {
	if(!pdo_fieldexists('chbl_sun_storetype2',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storetype2')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_storetype2')) {
	if(!pdo_fieldexists('chbl_sun_storetype2',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_storetype2')." ADD `state` int(4) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'appid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `appid` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'appsecret')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `appsecret` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'mchid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `mchid` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'wxkey')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `wxkey` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'url_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `url_name` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'details')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `details` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'url_logo')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `url_logo` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'bq_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `bq_name` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'link_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `link_name` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'link_logo')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `link_logo` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'support')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `support` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'bq_logo')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `bq_logo` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'fontcolor')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `fontcolor` varchar(20);");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'color')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `color` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'tz_appid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `tz_appid` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'tz_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `tz_name` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'pt_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `pt_name` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'tz_audit')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `tz_audit` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'sj_audit')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `sj_audit` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'mapkey')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `mapkey` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'tel')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `tel` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'gd_key')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `gd_key` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'hb_sxf')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `hb_sxf` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'tx_money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `tx_money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'tx_sxf')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `tx_sxf` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'tx_details')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `tx_details` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'rz_xuz')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `rz_xuz` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'ft_xuz')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `ft_xuz` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'fx_money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `fx_money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_hhr')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_hhr` int(4) NOT NULL DEFAULT '2';");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_hbfl')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_hbfl` int(4) NOT NULL DEFAULT '2';");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_zx')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_zx` int(4) NOT NULL DEFAULT '2';");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_car')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_car` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'pc_xuz')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `pc_xuz` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'pc_money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `pc_money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_sjrz')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_sjrz` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_pcfw')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_pcfw` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'total_num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `total_num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_goods')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_goods` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'apiclient_cert')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `apiclient_cert` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'apiclient_key')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `apiclient_key` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_openzx')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_openzx` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_hyset')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_hyset` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_tzopen')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_tzopen` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_pageopen')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_pageopen` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'cityname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `cityname` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_tel')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_tel` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'tx_mode')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `tx_mode` int(4) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'many_city')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `many_city` int(4) NOT NULL DEFAULT '2';");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'tx_type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `tx_type` int(4) NOT NULL DEFAULT '2';");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_hbzf')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_hbzf` int(4) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'hb_img')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `hb_img` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'tz_num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `tz_num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'client_ip')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `client_ip` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'hb_content')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `hb_content` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_vipcardopen')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_vipcardopen` int(4) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_jkopen')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_jkopen` int(4) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'address')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `address` varchar(150);");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'sj_ruzhu')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `sj_ruzhu` int(5);");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_kanjiaopen')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_kanjiaopen` int(4) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'bargain_price')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `bargain_price` varchar(10);");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'sign')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `sign` varchar(12);");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'bargain_title')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `bargain_title` varchar(15);");
	}	
}
if(pdo_tableexists('chbl_sun_system')) {
	if(!pdo_fieldexists('chbl_sun_system',  'is_pintuanopen')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_system')." ADD `is_pintuanopen` int(4);");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'index')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `index` varchar(10);");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'indeximg')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `indeximg` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'indeximgs')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `indeximgs` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'coupon')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `coupon` varchar(10);");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'couponimg')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `couponimg` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'couponimgs')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `couponimgs` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'fans')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `fans` varchar(10);");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'fansimg')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `fansimg` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'fansimgs')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `fansimgs` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'mine')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `mine` varchar(10);");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'mineimg')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `mineimg` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'mineimgs')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `mineimgs` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'fontcolor')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `fontcolor` varchar(10);");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'fontcolored')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `fontcolored` varchar(10);");
	}	
}
if(pdo_tableexists('chbl_sun_tab')) {
	if(!pdo_fieldexists('chbl_sun_tab',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tab')." ADD `uniacid` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_top')) {
	if(!pdo_fieldexists('chbl_sun_top',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_top')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_top')) {
	if(!pdo_fieldexists('chbl_sun_top',  'type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_top')." ADD `type` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_top')) {
	if(!pdo_fieldexists('chbl_sun_top',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_top')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_top')) {
	if(!pdo_fieldexists('chbl_sun_top',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_top')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_top')) {
	if(!pdo_fieldexists('chbl_sun_top',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_top')." ADD `num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_type')) {
	if(!pdo_fieldexists('chbl_sun_type',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_type')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_type')) {
	if(!pdo_fieldexists('chbl_sun_type',  'type_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_type')." ADD `type_name` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_type')) {
	if(!pdo_fieldexists('chbl_sun_type',  'img')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_type')." ADD `img` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_type')) {
	if(!pdo_fieldexists('chbl_sun_type',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_type')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_type')) {
	if(!pdo_fieldexists('chbl_sun_type',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_type')." ADD `num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_type')) {
	if(!pdo_fieldexists('chbl_sun_type',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_type')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_type')) {
	if(!pdo_fieldexists('chbl_sun_type',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_type')." ADD `state` int(4) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_type2')) {
	if(!pdo_fieldexists('chbl_sun_type2',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_type2')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_type2')) {
	if(!pdo_fieldexists('chbl_sun_type2',  'name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_type2')." ADD `name` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_type2')) {
	if(!pdo_fieldexists('chbl_sun_type2',  'type_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_type2')." ADD `type_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_type2')) {
	if(!pdo_fieldexists('chbl_sun_type2',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_type2')." ADD `num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_type2')) {
	if(!pdo_fieldexists('chbl_sun_type2',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_type2')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_type2')) {
	if(!pdo_fieldexists('chbl_sun_type2',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_type2')." ADD `state` int(4) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_tzpaylog')) {
	if(!pdo_fieldexists('chbl_sun_tzpaylog',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tzpaylog')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_tzpaylog')) {
	if(!pdo_fieldexists('chbl_sun_tzpaylog',  'tz_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tzpaylog')." ADD `tz_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_tzpaylog')) {
	if(!pdo_fieldexists('chbl_sun_tzpaylog',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tzpaylog')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_tzpaylog')) {
	if(!pdo_fieldexists('chbl_sun_tzpaylog',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tzpaylog')." ADD `time` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_tzpaylog')) {
	if(!pdo_fieldexists('chbl_sun_tzpaylog',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_tzpaylog')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user')) {
	if(!pdo_fieldexists('chbl_sun_user',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_user')) {
	if(!pdo_fieldexists('chbl_sun_user',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user')." ADD `openid` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user')) {
	if(!pdo_fieldexists('chbl_sun_user',  'img')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user')." ADD `img` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user')) {
	if(!pdo_fieldexists('chbl_sun_user',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user')." ADD `time` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user')) {
	if(!pdo_fieldexists('chbl_sun_user',  'name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user')." ADD `name` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user')) {
	if(!pdo_fieldexists('chbl_sun_user',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user')) {
	if(!pdo_fieldexists('chbl_sun_user',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user')) {
	if(!pdo_fieldexists('chbl_sun_user',  'user_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user')." ADD `user_name` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user')) {
	if(!pdo_fieldexists('chbl_sun_user',  'user_tel')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user')." ADD `user_tel` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user')) {
	if(!pdo_fieldexists('chbl_sun_user',  'user_address')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user')." ADD `user_address` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user')) {
	if(!pdo_fieldexists('chbl_sun_user',  'commission')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user')." ADD `commission` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user')) {
	if(!pdo_fieldexists('chbl_sun_user',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user')." ADD `state` int(4) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_user_active')) {
	if(!pdo_fieldexists('chbl_sun_user_active',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_active')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_user_active')) {
	if(!pdo_fieldexists('chbl_sun_user_active',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_active')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user_active')) {
	if(!pdo_fieldexists('chbl_sun_user_active',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_active')." ADD `uid` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user_active')) {
	if(!pdo_fieldexists('chbl_sun_user_active',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_active')." ADD `num` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_active')) {
	if(!pdo_fieldexists('chbl_sun_user_active',  'img')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_active')." ADD `img` varchar(150);");
	}	
}
if(pdo_tableexists('chbl_sun_user_active')) {
	if(!pdo_fieldexists('chbl_sun_user_active',  'jikanum')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_active')." ADD `jikanum` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_active')) {
	if(!pdo_fieldexists('chbl_sun_user_active',  'active_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_active')." ADD `active_id` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_active')) {
	if(!pdo_fieldexists('chbl_sun_user_active',  'kapian_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_active')." ADD `kapian_id` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_active')) {
	if(!pdo_fieldexists('chbl_sun_user_active',  'sharenum')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_active')." ADD `sharenum` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_bargain')) {
	if(!pdo_fieldexists('chbl_sun_user_bargain',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_bargain')." ADD `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_user_bargain')) {
	if(!pdo_fieldexists('chbl_sun_user_bargain',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_bargain')." ADD `openid` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user_bargain')) {
	if(!pdo_fieldexists('chbl_sun_user_bargain',  'gid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_bargain')." ADD `gid` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_bargain')) {
	if(!pdo_fieldexists('chbl_sun_user_bargain',  'mch_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_bargain')." ADD `mch_id` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_bargain')) {
	if(!pdo_fieldexists('chbl_sun_user_bargain',  'status')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_bargain')." ADD `status` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_bargain')) {
	if(!pdo_fieldexists('chbl_sun_user_bargain',  'price')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_bargain')." ADD `price` decimal(10,0);");
	}	
}
if(pdo_tableexists('chbl_sun_user_bargain')) {
	if(!pdo_fieldexists('chbl_sun_user_bargain',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_bargain')." ADD `uniacid` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_bargain')) {
	if(!pdo_fieldexists('chbl_sun_user_bargain',  'add_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_bargain')." ADD `add_time` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_bargain')) {
	if(!pdo_fieldexists('chbl_sun_user_bargain',  'kanjia')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_bargain')." ADD `kanjia` decimal(11,0) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user_bargain')) {
	if(!pdo_fieldexists('chbl_sun_user_bargain',  'prices')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_bargain')." ADD `prices` decimal(11,2);");
	}	
}
if(pdo_tableexists('chbl_sun_user_bargain')) {
	if(!pdo_fieldexists('chbl_sun_user_bargain',  'kanjias')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_bargain')." ADD `kanjias` decimal(11,2);");
	}	
}
if(pdo_tableexists('chbl_sun_user_groups')) {
	if(!pdo_fieldexists('chbl_sun_user_groups',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_groups')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_user_groups')) {
	if(!pdo_fieldexists('chbl_sun_user_groups',  'mch_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_groups')." ADD `mch_id` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_groups')) {
	if(!pdo_fieldexists('chbl_sun_user_groups',  'gid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_groups')." ADD `gid` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_groups')) {
	if(!pdo_fieldexists('chbl_sun_user_groups',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_groups')." ADD `openid` varchar(100);");
	}	
}
if(pdo_tableexists('chbl_sun_user_groups')) {
	if(!pdo_fieldexists('chbl_sun_user_groups',  'order_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_groups')." ADD `order_id` varchar(100);");
	}	
}
if(pdo_tableexists('chbl_sun_user_groups')) {
	if(!pdo_fieldexists('chbl_sun_user_groups',  'addtime')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_groups')." ADD `addtime` varchar(100);");
	}	
}
if(pdo_tableexists('chbl_sun_user_groups')) {
	if(!pdo_fieldexists('chbl_sun_user_groups',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_groups')." ADD `uniacid` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_groups')) {
	if(!pdo_fieldexists('chbl_sun_user_groups',  'status')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_groups')." ADD `status` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_groups')) {
	if(!pdo_fieldexists('chbl_sun_user_groups',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_groups')." ADD `num` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_groups')) {
	if(!pdo_fieldexists('chbl_sun_user_groups',  'price')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_groups')." ADD `price` decimal(10,2);");
	}	
}
if(pdo_tableexists('chbl_sun_user_groups')) {
	if(!pdo_fieldexists('chbl_sun_user_groups',  'buynum')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_groups')." ADD `buynum` int(11);");
	}	
}
if(pdo_tableexists('chbl_sun_user_vipcard')) {
	if(!pdo_fieldexists('chbl_sun_user_vipcard',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_vipcard')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_user_vipcard')) {
	if(!pdo_fieldexists('chbl_sun_user_vipcard',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_vipcard')." ADD `uid` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user_vipcard')) {
	if(!pdo_fieldexists('chbl_sun_user_vipcard',  'vipcard_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_vipcard')." ADD `vipcard_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user_vipcard')) {
	if(!pdo_fieldexists('chbl_sun_user_vipcard',  'card_number')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_vipcard')." ADD `card_number` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_user_vipcard')) {
	if(!pdo_fieldexists('chbl_sun_user_vipcard',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_user_vipcard')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_userformid')) {
	if(!pdo_fieldexists('chbl_sun_userformid',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userformid')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_userformid')) {
	if(!pdo_fieldexists('chbl_sun_userformid',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userformid')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_userformid')) {
	if(!pdo_fieldexists('chbl_sun_userformid',  'form_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userformid')." ADD `form_id` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_userformid')) {
	if(!pdo_fieldexists('chbl_sun_userformid',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userformid')." ADD `time` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_userformid')) {
	if(!pdo_fieldexists('chbl_sun_userformid',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userformid')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_userformid')) {
	if(!pdo_fieldexists('chbl_sun_userformid',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userformid')." ADD `openid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_userinfo')) {
	if(!pdo_fieldexists('chbl_sun_userinfo',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userinfo')." ADD `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_userinfo')) {
	if(!pdo_fieldexists('chbl_sun_userinfo',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userinfo')." ADD `uniacid` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_userinfo')) {
	if(!pdo_fieldexists('chbl_sun_userinfo',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userinfo')." ADD `uid` varchar(100);");
	}	
}
if(pdo_tableexists('chbl_sun_userinfo')) {
	if(!pdo_fieldexists('chbl_sun_userinfo',  'name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userinfo')." ADD `name` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_userinfo')) {
	if(!pdo_fieldexists('chbl_sun_userinfo',  'tel')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userinfo')." ADD `tel` varchar(60);");
	}	
}
if(pdo_tableexists('chbl_sun_userinfo')) {
	if(!pdo_fieldexists('chbl_sun_userinfo',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userinfo')." ADD `createtime` int(10) unsigned NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_userinfo')) {
	if(!pdo_fieldexists('chbl_sun_userinfo',  'status')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userinfo')." ADD `status` tinyint(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_userinfo')) {
	if(!pdo_fieldexists('chbl_sun_userinfo',  'nickName')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userinfo')." ADD `nickName` varchar(60);");
	}	
}
if(pdo_tableexists('chbl_sun_userinfo')) {
	if(!pdo_fieldexists('chbl_sun_userinfo',  'avatarUrl')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userinfo')." ADD `avatarUrl` varchar(200);");
	}	
}
if(pdo_tableexists('chbl_sun_userinfo')) {
	if(!pdo_fieldexists('chbl_sun_userinfo',  'fromuid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_userinfo')." ADD `fromuid` int(10) DEFAULT '0';");
	}	
}
if(pdo_tableexists('chbl_sun_vipcard')) {
	if(!pdo_fieldexists('chbl_sun_vipcard',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_vipcard')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_vipcard')) {
	if(!pdo_fieldexists('chbl_sun_vipcard',  'name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_vipcard')." ADD `name` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_vipcard')) {
	if(!pdo_fieldexists('chbl_sun_vipcard',  'img')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_vipcard')." ADD `img` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_vipcard')) {
	if(!pdo_fieldexists('chbl_sun_vipcard',  'price')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_vipcard')." ADD `price` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_vipcard')) {
	if(!pdo_fieldexists('chbl_sun_vipcard',  'desc')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_vipcard')." ADD `desc` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_vipcard')) {
	if(!pdo_fieldexists('chbl_sun_vipcard',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_vipcard')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_vipcard')) {
	if(!pdo_fieldexists('chbl_sun_vipcard',  'discount')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_vipcard')." ADD `discount` varchar(45) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_withdrawal',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_withdrawal')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_withdrawal',  'name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_withdrawal')." ADD `name` varchar(10) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_withdrawal',  'username')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_withdrawal')." ADD `username` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_withdrawal',  'type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_withdrawal')." ADD `type` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_withdrawal',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_withdrawal')." ADD `time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_withdrawal',  'sh_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_withdrawal')." ADD `sh_time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_withdrawal',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_withdrawal')." ADD `state` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_withdrawal',  'tx_cost')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_withdrawal')." ADD `tx_cost` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_withdrawal',  'sj_cost')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_withdrawal')." ADD `sj_cost` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_withdrawal',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_withdrawal')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_withdrawal',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_withdrawal')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_withdrawal',  'method')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_withdrawal')." ADD `method` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_withdrawal')) {
	if(!pdo_fieldexists('chbl_sun_withdrawal',  'store_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_withdrawal')." ADD `store_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowpaylog')) {
	if(!pdo_fieldexists('chbl_sun_yellowpaylog',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowpaylog')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowpaylog')) {
	if(!pdo_fieldexists('chbl_sun_yellowpaylog',  'hy_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowpaylog')." ADD `hy_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowpaylog')) {
	if(!pdo_fieldexists('chbl_sun_yellowpaylog',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowpaylog')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowpaylog')) {
	if(!pdo_fieldexists('chbl_sun_yellowpaylog',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowpaylog')." ADD `time` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowpaylog')) {
	if(!pdo_fieldexists('chbl_sun_yellowpaylog',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowpaylog')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowset')) {
	if(!pdo_fieldexists('chbl_sun_yellowset',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowset')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowset')) {
	if(!pdo_fieldexists('chbl_sun_yellowset',  'days')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowset')." ADD `days` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowset')) {
	if(!pdo_fieldexists('chbl_sun_yellowset',  'money')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowset')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowset')) {
	if(!pdo_fieldexists('chbl_sun_yellowset',  'num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowset')." ADD `num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowset')) {
	if(!pdo_fieldexists('chbl_sun_yellowset',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowset')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'logo')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `logo` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'company_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `company_name` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'company_address')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `company_address` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'type_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `type_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'link_tel')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `link_tel` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'sort')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `sort` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'rz_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `rz_time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'sh_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `sh_time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `state` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'rz_type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `rz_type` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'time_over')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `time_over` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'coordinates')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `coordinates` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'content')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `content` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'imgs')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `imgs` varchar(500) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'views')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `views` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'tel2')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `tel2` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'cityname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `cityname` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yellowstore')) {
	if(!pdo_fieldexists('chbl_sun_yellowstore',  'dq_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yellowstore')." ADD `dq_time` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yingxiao')) {
	if(!pdo_fieldexists('chbl_sun_yingxiao',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yingxiao')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_yingxiao')) {
	if(!pdo_fieldexists('chbl_sun_yingxiao',  'toutiao')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yingxiao')." ADD `toutiao` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yingxiao')) {
	if(!pdo_fieldexists('chbl_sun_yingxiao',  'ttimg')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yingxiao')." ADD `ttimg` varchar(150) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yingxiao')) {
	if(!pdo_fieldexists('chbl_sun_yingxiao',  'pintuan')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yingxiao')." ADD `pintuan` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yingxiao')) {
	if(!pdo_fieldexists('chbl_sun_yingxiao',  'ptimg')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yingxiao')." ADD `ptimg` varchar(150) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yingxiao')) {
	if(!pdo_fieldexists('chbl_sun_yingxiao',  'jika')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yingxiao')." ADD `jika` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yingxiao')) {
	if(!pdo_fieldexists('chbl_sun_yingxiao',  'jkimg')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yingxiao')." ADD `jkimg` varchar(150) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yingxiao')) {
	if(!pdo_fieldexists('chbl_sun_yingxiao',  'kanjia')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yingxiao')." ADD `kanjia` varchar(45) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yingxiao')) {
	if(!pdo_fieldexists('chbl_sun_yingxiao',  'kjimg')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yingxiao')." ADD `kjimg` varchar(150) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yingxiao')) {
	if(!pdo_fieldexists('chbl_sun_yingxiao',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yingxiao')." ADD `uniacid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjset')) {
	if(!pdo_fieldexists('chbl_sun_yjset',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjset')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_yjset')) {
	if(!pdo_fieldexists('chbl_sun_yjset',  'type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjset')." ADD `type` int(4) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_yjset')) {
	if(!pdo_fieldexists('chbl_sun_yjset',  'typer')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjset')." ADD `typer` varchar(10) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjset')) {
	if(!pdo_fieldexists('chbl_sun_yjset',  'sjper')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjset')." ADD `sjper` varchar(10) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjset')) {
	if(!pdo_fieldexists('chbl_sun_yjset',  'hyper')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjset')." ADD `hyper` varchar(10) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjset')) {
	if(!pdo_fieldexists('chbl_sun_yjset',  'pcper')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjset')." ADD `pcper` varchar(10) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjset')) {
	if(!pdo_fieldexists('chbl_sun_yjset',  'tzper')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjset')." ADD `tzper` varchar(10) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjset')) {
	if(!pdo_fieldexists('chbl_sun_yjset',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjset')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjtx')) {
	if(!pdo_fieldexists('chbl_sun_yjtx',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjtx')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_yjtx')) {
	if(!pdo_fieldexists('chbl_sun_yjtx',  'account_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjtx')." ADD `account_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjtx')) {
	if(!pdo_fieldexists('chbl_sun_yjtx',  'tx_type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjtx')." ADD `tx_type` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjtx')) {
	if(!pdo_fieldexists('chbl_sun_yjtx',  'tx_cost')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjtx')." ADD `tx_cost` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjtx')) {
	if(!pdo_fieldexists('chbl_sun_yjtx',  'status')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjtx')." ADD `status` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjtx')) {
	if(!pdo_fieldexists('chbl_sun_yjtx',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjtx')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjtx')) {
	if(!pdo_fieldexists('chbl_sun_yjtx',  'cerated_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjtx')." ADD `cerated_time` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjtx')) {
	if(!pdo_fieldexists('chbl_sun_yjtx',  'sj_cost')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjtx')." ADD `sj_cost` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjtx')) {
	if(!pdo_fieldexists('chbl_sun_yjtx',  'account')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjtx')." ADD `account` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjtx')) {
	if(!pdo_fieldexists('chbl_sun_yjtx',  'name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjtx')." ADD `name` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjtx')) {
	if(!pdo_fieldexists('chbl_sun_yjtx',  'sx_cost')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjtx')." ADD `sx_cost` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjtx')) {
	if(!pdo_fieldexists('chbl_sun_yjtx',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjtx')." ADD `time` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_yjtx')) {
	if(!pdo_fieldexists('chbl_sun_yjtx',  'is_del')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_yjtx')." ADD `is_del` int(4) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_zx')) {
	if(!pdo_fieldexists('chbl_sun_zx',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_zx')) {
	if(!pdo_fieldexists('chbl_sun_zx',  'type_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx')." ADD `type_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx')) {
	if(!pdo_fieldexists('chbl_sun_zx',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx')) {
	if(!pdo_fieldexists('chbl_sun_zx',  'title')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx')." ADD `title` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx')) {
	if(!pdo_fieldexists('chbl_sun_zx',  'content')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx')." ADD `content` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx')) {
	if(!pdo_fieldexists('chbl_sun_zx',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx')." ADD `time` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx')) {
	if(!pdo_fieldexists('chbl_sun_zx',  'yd_num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx')." ADD `yd_num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx')) {
	if(!pdo_fieldexists('chbl_sun_zx',  'pl_num')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx')." ADD `pl_num` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx')) {
	if(!pdo_fieldexists('chbl_sun_zx',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx')) {
	if(!pdo_fieldexists('chbl_sun_zx',  'imgs')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx')." ADD `imgs` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx')) {
	if(!pdo_fieldexists('chbl_sun_zx',  'state')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx')." ADD `state` int(4) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('chbl_sun_zx')) {
	if(!pdo_fieldexists('chbl_sun_zx',  'sh_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx')." ADD `sh_time` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx')) {
	if(!pdo_fieldexists('chbl_sun_zx',  'type')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx')." ADD `type` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx')) {
	if(!pdo_fieldexists('chbl_sun_zx',  'cityname')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx')." ADD `cityname` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx')) {
	if(!pdo_fieldexists('chbl_sun_zx',  'jianjie')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx')." ADD `jianjie` varchar(50);");
	}	
}
if(pdo_tableexists('chbl_sun_zx_assess')) {
	if(!pdo_fieldexists('chbl_sun_zx_assess',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_assess')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_assess')) {
	if(!pdo_fieldexists('chbl_sun_zx_assess',  'zx_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_assess')." ADD `zx_id` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_assess')) {
	if(!pdo_fieldexists('chbl_sun_zx_assess',  'score')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_assess')." ADD `score` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_assess')) {
	if(!pdo_fieldexists('chbl_sun_zx_assess',  'content')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_assess')." ADD `content` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_assess')) {
	if(!pdo_fieldexists('chbl_sun_zx_assess',  'img')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_assess')." ADD `img` varchar(500) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_assess')) {
	if(!pdo_fieldexists('chbl_sun_zx_assess',  'cerated_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_assess')." ADD `cerated_time` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_assess')) {
	if(!pdo_fieldexists('chbl_sun_zx_assess',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_assess')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_assess')) {
	if(!pdo_fieldexists('chbl_sun_zx_assess',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_assess')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_assess')) {
	if(!pdo_fieldexists('chbl_sun_zx_assess',  'status')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_assess')." ADD `status` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_assess')) {
	if(!pdo_fieldexists('chbl_sun_zx_assess',  'reply')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_assess')." ADD `reply` text NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_assess')) {
	if(!pdo_fieldexists('chbl_sun_zx_assess',  'reply_time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_assess')." ADD `reply_time` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_type')) {
	if(!pdo_fieldexists('chbl_sun_zx_type',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_type')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_type')) {
	if(!pdo_fieldexists('chbl_sun_zx_type',  'type_name')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_type')." ADD `type_name` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_type')) {
	if(!pdo_fieldexists('chbl_sun_zx_type',  'icon')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_type')." ADD `icon` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_type')) {
	if(!pdo_fieldexists('chbl_sun_zx_type',  'sort')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_type')." ADD `sort` int(4) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_type')) {
	if(!pdo_fieldexists('chbl_sun_zx_type',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_type')." ADD `time` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_type')) {
	if(!pdo_fieldexists('chbl_sun_zx_type',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_type')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_zj')) {
	if(!pdo_fieldexists('chbl_sun_zx_zj',  'id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_zj')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_zj')) {
	if(!pdo_fieldexists('chbl_sun_zx_zj',  'zx_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_zj')." ADD `zx_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_zj')) {
	if(!pdo_fieldexists('chbl_sun_zx_zj',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_zj')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_zj')) {
	if(!pdo_fieldexists('chbl_sun_zx_zj',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_zj')." ADD `uniacid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('chbl_sun_zx_zj')) {
	if(!pdo_fieldexists('chbl_sun_zx_zj',  'time')) {
		pdo_query("ALTER TABLE ".tablename('chbl_sun_zx_zj')." ADD `time` int(11) NOT NULL;");
	}	
}
