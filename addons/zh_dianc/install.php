<?php
pdo_query("DROP TABLE IF EXISTS `ims_wpdc_account`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_account` (
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
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_ad`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_ad` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`logo` varchar(300) NOT NULL,
`src` varchar(300) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`created_time` datetime NOT NULL,
`orderby` int(4) NOT NULL,
`status` int(4) NOT NULL,
`type` int(11) NOT NULL,
`store_id` int(11) NOT NULL,
`appid` varchar(30) NOT NULL,
`xcx_name` varchar(30) NOT NULL,
`title` varchar(50) NOT NULL,
`item` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_area`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_area` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`area_name` varchar(20) NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_assess`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_assess` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`seller_id` int(11) NOT NULL,
`order_id` int(11) NOT NULL,
`order_num` varchar(30) NOT NULL,
`score` int(11) NOT NULL,
`content` text NOT NULL,
`img` varchar(1000) NOT NULL,
`cerated_time` datetime NOT NULL,
`user_id` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`reply` varchar(1000) NOT NULL,
`status` int(4) NOT NULL,
`reply_time` datetime NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_commission_withdrawal`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_commission_withdrawal` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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

DROP TABLE IF EXISTS `ims_wpdc_continuous`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_continuous` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`day` int(11) NOT NULL,
`integral` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_coupons`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_coupons` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(20) NOT NULL,
`start_time` varchar(20) NOT NULL,
`end_time` varchar(20) NOT NULL,
`conditions` varchar(10) NOT NULL,
`preferential` varchar(10) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`coupons_type` int(4) NOT NULL,
`instruction` varchar(300) NOT NULL,
`store_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_czhd`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_czhd` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`full` int(11) NOT NULL,
`reduction` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_czorder`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_czorder` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`money` decimal(10,2) NOT NULL,
`user_id` int(11) NOT NULL,
`state` int(11) NOT NULL,
`code` varchar(100) NOT NULL,
`form_id` varchar(100) NOT NULL,
`uniacid` int(11) NOT NULL,
`time` varchar(20) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_dishes`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_dishes` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(100) NOT NULL,
`img` varchar(500) NOT NULL,
`num` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`type_id` int(11) NOT NULL,
`signature` int(11) NOT NULL,
`one` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`xs_num` int(11) NOT NULL,
`sit_ys_num` int(11) NOT NULL,
`is_shelves` int(4) NOT NULL,
`dishes_type` int(4) NOT NULL,
`box_fee` decimal(10,2) NOT NULL,
`wm_money` decimal(10,2) NOT NULL,
`details` text NOT NULL,
`sorting` int(11) NOT NULL,
`store_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_distribution`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_distribution` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`time` int(11) NOT NULL,
`user_name` varchar(20) NOT NULL,
`user_tel` varchar(20) NOT NULL,
`state` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_dmorder`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_dmorder` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`money` decimal(10,2) NOT NULL,
`store_id` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`time` varchar(20) NOT NULL,
`time2` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`is_yue` int(11) NOT NULL DEFAULT '1',
`form_id` varchar(100) NOT NULL,
`code` varchar(200) NOT NULL,
`state` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_dyj`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_dyj` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`dyj_title` varchar(50) NOT NULL,
`dyj_id` varchar(50) NOT NULL,
`dyj_key` varchar(50) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`type` int(11) NOT NULL,
`name` varchar(20) NOT NULL,
`mid` varchar(100) NOT NULL,
`api` varchar(100) NOT NULL,
`store_id` int(11) NOT NULL,
`state` int(11) NOT NULL,
`location` int(11) NOT NULL,
`yy_id` varchar(20) NOT NULL,
`token` varchar(50) NOT NULL,
`dyj_title2` varchar(50) NOT NULL,
`dyj_id2` varchar(50) NOT NULL,
`dyj_key2` varchar(50) NOT NULL,
`num` int(11) NOT NULL DEFAULT '1',
`fezh` varchar(40) NOT NULL,
`fe_ukey` varchar(50) NOT NULL,
`fe_dycode` varchar(20) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_earnings`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_earnings` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`son_id` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`time` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_fxset`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_fxset` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
`is_type` int(11) NOT NULL DEFAULT '2',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_fxuser`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_fxuser` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`fx_user` int(11) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_goods`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_goods` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`img` varchar(300) NOT NULL,
`number` int(11) NOT NULL,
`order_id` int(11) NOT NULL,
`name` varchar(50) NOT NULL,
`money` decimal(10,2) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`dishes_id` int(11) NOT NULL,
`spec` varchar(20) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_help`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_help` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`question` varchar(200) NOT NULL,
`answer` text NOT NULL,
`sort` int(4) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`created_time` datetime NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_integral`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_integral` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`score` int(11) NOT NULL,
`type` int(4) NOT NULL,
`order_id` int(11) NOT NULL,
`cerated_time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
`note` varchar(20) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_jfgoods`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_jfgoods` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL,
`img` varchar(100) NOT NULL,
`money` int(11) NOT NULL,
`type_id` int(11) NOT NULL,
`goods_details` text NOT NULL,
`process_details` text NOT NULL,
`attention_details` text NOT NULL,
`number` int(11) NOT NULL,
`time` varchar(50) NOT NULL,
`is_open` int(11) NOT NULL,
`type` int(11) NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`hb_moeny` decimal(10,2) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_jfrecord`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_jfrecord` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`good_id` int(11) NOT NULL,
`time` varchar(20) NOT NULL,
`user_name` varchar(20) NOT NULL,
`user_tel` varchar(20) NOT NULL,
`address` varchar(200) NOT NULL,
`note` varchar(20) NOT NULL,
`integral` int(11) NOT NULL,
`good_name` varchar(50) NOT NULL,
`good_img` varchar(100) NOT NULL,
`state` int(11) NOT NULL DEFAULT '2',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_jftype`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_jftype` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(20) NOT NULL,
`img` varchar(100) NOT NULL,
`num` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_order`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_order` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`order_num` varchar(20) NOT NULL,
`state` int(11) NOT NULL,
`time` varchar(20) NOT NULL,
`pay_time` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`preferential` varchar(10) NOT NULL,
`tel` varchar(20) NOT NULL,
`name` varchar(20) NOT NULL,
`address` varchar(200) NOT NULL,
`delivery_time` varchar(20) NOT NULL,
`time2` int(11) NOT NULL,
`cancel_time` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`type` int(4) NOT NULL,
`dn_state` int(4) NOT NULL,
`table_id` int(11) NOT NULL,
`freight` decimal(10,2) NOT NULL,
`box_fee` decimal(10,2) NOT NULL,
`coupons_id` int(11) NOT NULL,
`voucher_id` int(11) NOT NULL,
`seller_id` int(11) NOT NULL,
`note` varchar(200) NOT NULL,
`area` varchar(20) NOT NULL,
`lat` varchar(20) NOT NULL,
`lng` varchar(20) NOT NULL,
`del` int(11) NOT NULL DEFAULT '2',
`sh_ordernum` varchar(50) NOT NULL,
`pay_type` int(11) NOT NULL,
`del2` int(11) NOT NULL,
`is_take` int(11) NOT NULL,
`is_yue` int(11) NOT NULL,
`completion_time` int(11) NOT NULL,
`form_id` varchar(100) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_qbmx`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_qbmx` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`money` decimal(10,2) NOT NULL,
`type` int(11) NOT NULL,
`note` varchar(20) NOT NULL,
`time` varchar(20) NOT NULL,
`user_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_reduction`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_reduction` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL,
`full` int(11) NOT NULL,
`reduction` int(11) NOT NULL,
`type` int(11) NOT NULL,
`store_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_rrset`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_rrset` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`store_id` int(11) NOT NULL,
`username` varchar(30) NOT NULL,
`appkey` varchar(50) NOT NULL,
`is_open` int(11) NOT NULL DEFAULT '1',
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_ruzhu`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_ruzhu` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`store_name` varchar(20) NOT NULL,
`tel` varchar(20) NOT NULL,
`user_name` varchar(20) NOT NULL,
`img` varchar(100) NOT NULL,
`state` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`time` int(11) NOT NULL,
`address` varchar(200) NOT NULL,
`sp_img` varchar(100) NOT NULL,
`sfz_img` varchar(100) NOT NULL,
`sfz_img2` varchar(100) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_seller`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_seller` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`account` varchar(30) NOT NULL,
`pwd` varchar(50) NOT NULL,
`cerated_time` datetime NOT NULL,
`uniacid` varchar(50) NOT NULL,
`store_id` int(11) NOT NULL,
`state` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_signlist`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_signlist` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`time` varchar(20) NOT NULL,
`integral` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
`time2` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_signset`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_signset` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`one` int(11) NOT NULL,
`integral` int(11) NOT NULL,
`is_open` int(11) NOT NULL,
`is_bq` int(11) NOT NULL,
`bq_integral` int(11) NOT NULL,
`details` text NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_sms`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_sms` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_name` varchar(100) NOT NULL,
`password` varchar(100) NOT NULL,
`model` varchar(30) NOT NULL,
`model2` varchar(30) NOT NULL,
`tel` varchar(20) NOT NULL,
`tid` varchar(100) NOT NULL,
`signature` varchar(200) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`yy_tid` varchar(50) NOT NULL,
`dm_tid` varchar(50) NOT NULL,
`store_id` int(11) NOT NULL,
`email` varchar(50) NOT NULL,
`appkey` varchar(100) NOT NULL,
`tpl_id` int(11) NOT NULL,
`tpl2_id` int(11) NOT NULL,
`is_wmsms` int(11) NOT NULL DEFAULT '1',
`is_yysms` int(11) NOT NULL DEFAULT '1',
`is_dnsms` int(11) NOT NULL DEFAULT '1',
`tpl3_id` int(11) NOT NULL,
`sj_tid` varchar(50) NOT NULL,
`sj_tid2` varchar(50) NOT NULL,
`wx_appid` varchar(20) NOT NULL,
`wx_secret` varchar(50) NOT NULL,
`sj_openid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_spec`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_spec` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`goods_id` int(11) NOT NULL,
`name` varchar(50) NOT NULL,
`cost` decimal(10,2) NOT NULL,
`num` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_special`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_special` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`day` varchar(20) NOT NULL,
`integral` int(11) NOT NULL,
`title` varchar(20) NOT NULL,
`color` varchar(20) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_store`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_store` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL,
`address` varchar(500) NOT NULL,
`time` varchar(100) NOT NULL,
`tel` varchar(20) NOT NULL,
`announcement` varchar(500) NOT NULL,
`conditions` varchar(10) NOT NULL,
`preferential` varchar(10) NOT NULL,
`support` varchar(500) NOT NULL,
`is_rest` int(11) NOT NULL,
`img` text NOT NULL,
`start_at` varchar(20) NOT NULL,
`freight` varchar(20) NOT NULL,
`logo` varchar(200) NOT NULL,
`details` text NOT NULL,
`bgimg` text NOT NULL,
`time2` varchar(20) NOT NULL,
`color` varchar(20) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`xyh_money` decimal(10,2) NOT NULL,
`xyh_open` int(4) NOT NULL,
`integral` int(11) NOT NULL,
`coordinates` varchar(50) NOT NULL,
`distance` varchar(100) NOT NULL,
`is_yy` int(4) NOT NULL,
`is_wm` int(4) NOT NULL,
`is_dn` int(4) NOT NULL,
`is_sy` int(4) NOT NULL,
`is_pd` int(4) NOT NULL,
`ps_mode` int(4) NOT NULL,
`bq_logo` varchar(100) NOT NULL,
`is_display` int(4) NOT NULL,
`yyzz` text NOT NULL,
`environment` text NOT NULL,
`sd_time` varchar(20) NOT NULL,
`md_logo` varchar(200) NOT NULL,
`md_name` varchar(50) NOT NULL,
`md_area` int(11) NOT NULL,
`md_type` int(11) NOT NULL,
`md_content` varchar(300) NOT NULL,
`number` int(11) NOT NULL,
`score` decimal(10,1) NOT NULL,
`sales` int(11) NOT NULL,
`is_jd` int(11) NOT NULL,
`jd_time` int(11) NOT NULL,
`source_id` int(11) NOT NULL,
`shop_no` varchar(20) NOT NULL,
`is_mp3` int(11) NOT NULL,
`is_video` int(11) NOT NULL,
`store_mp3` text NOT NULL,
`store_video` text NOT NULL,
`is_yypay` int(11) NOT NULL,
`yy_name` varchar(20) NOT NULL,
`yy_img` varchar(100) NOT NULL,
`wm_name` varchar(20) NOT NULL,
`wm_img` varchar(100) NOT NULL,
`dn_name` varchar(20) NOT NULL,
`dn_img` varchar(100) NOT NULL,
`sy_name` varchar(20) NOT NULL,
`sy_img` varchar(100) NOT NULL,
`pd_name` varchar(20) NOT NULL,
`pd_img` varchar(100) NOT NULL,
`box_name` varchar(20) NOT NULL,
`storecode` varchar(200) NOT NULL,
`is_czztpd` int(11) NOT NULL DEFAULT '1',
`is_chzf` int(11) DEFAULT '1',
`time3` varchar(20) NOT NULL,
`time4` varchar(20) NOT NULL,
`hb_img` varchar(100) NOT NULL,
`is_open` int(11) NOT NULL DEFAULT '1',
`is_jf` int(11) NOT NULL DEFAULT '1',
`is_wmjf` int(11) NOT NULL DEFAULT '1',
`is_yyjf` int(11) NOT NULL DEFAULT '1',
`is_dnjf` int(11) NOT NULL DEFAULT '1',
`is_dmjf` int(11) NOT NULL DEFAULT '1',
`poundage` varchar(20) NOT NULL,
`is_jfpay` int(11) NOT NULL DEFAULT '1',
`is_yuejf` int(11) NOT NULL DEFAULT '1',
`integral2` int(11) NOT NULL,
`is_yue` int(11) NOT NULL DEFAULT '1',
`user_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_storetype`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_storetype` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type_name` varchar(50) NOT NULL,
`num` int(11) NOT NULL,
`img` varchar(200) NOT NULL,
`uniacid` int(11) NOT NULL,
`commission` int(11) NOT NULL,
`commission2` int(11) NOT NULL,
`poundage` varchar(20) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_system`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_system` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`appid` varchar(100) NOT NULL,
`appsecret` varchar(200) NOT NULL,
`link` varchar(200) NOT NULL,
`mchid` varchar(20) NOT NULL,
`wxkey` varchar(100) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`url_name` varchar(20) NOT NULL,
`details` text NOT NULL,
`url_logo` varchar(100) NOT NULL,
`bq_name` varchar(50) NOT NULL,
`link_name` varchar(30) NOT NULL,
`link_logo` varchar(100) NOT NULL,
`more` int(11) NOT NULL DEFAULT '1',
`default_store` int(11) NOT NULL,
`support` varchar(20) NOT NULL,
`bq_logo` varchar(100) NOT NULL,
`color` varchar(20) NOT NULL,
`map_key` varchar(100) NOT NULL,
`tz_appid` varchar(30) NOT NULL,
`tz_name` varchar(30) NOT NULL,
`pt_name` varchar(30) NOT NULL,
`dada_key` varchar(50) NOT NULL,
`dada_secret` varchar(50) NOT NULL,
`apiclient_cert` text NOT NULL,
`apiclient_key` text NOT NULL,
`day` int(11) NOT NULL,
`username` varchar(20) NOT NULL,
`password` varchar(50) NOT NULL,
`type` varchar(10) NOT NULL,
`sender` varchar(50) NOT NULL,
`signature` varchar(200) NOT NULL,
`is_email` int(11) NOT NULL,
`tx_money` decimal(10,2) NOT NULL,
`tx_rate` int(11) NOT NULL,
`tx_details` text NOT NULL,
`tel` varchar(20) NOT NULL,
`dc_name` varchar(20) NOT NULL,
`wm_name` varchar(20) NOT NULL,
`yd_name` varchar(20) NOT NULL,
`typeset` int(11) NOT NULL,
`integral` int(11) NOT NULL,
`cjwt` text NOT NULL,
`rzxy` text NOT NULL,
`is_ruzhu` int(11) NOT NULL,
`is_yue` int(11) NOT NULL DEFAULT '1',
`integral2` int(11) NOT NULL,
`is_jf` int(11) NOT NULL DEFAULT '1',
`is_jfpay` int(11) NOT NULL DEFAULT '1',
`jf_proportion` int(11) NOT NULL DEFAULT '1',
`is_zfb` int(11) NOT NULL DEFAULT '1',
`is_yhk` int(11) NOT NULL DEFAULT '1',
`is_wx` int(11) NOT NULL DEFAULT '1',
`ip` varchar(30) NOT NULL,
`jfgn` int(11) NOT NULL DEFAULT '1',
`fxgn` int(11) NOT NULL DEFAULT '1',
`msgn` int(11) NOT NULL DEFAULT '1',
`is_img` int(11) NOT NULL DEFAULT '2',
`is_psxx` int(11) NOT NULL DEFAULT '2',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_table`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_table` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL,
`num` int(4) NOT NULL,
`type_id` varchar(50) NOT NULL,
`tag` varchar(50) NOT NULL,
`orderby` int(11) NOT NULL,
`status` int(4) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`store_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_table_type`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_table_type` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL,
`fw_cost` decimal(10,2) NOT NULL,
`zd_cost` decimal(10,2) NOT NULL,
`yd_cost` decimal(10,2) NOT NULL,
`num` int(11) NOT NULL,
`orderby` int(11) NOT NULL,
`ss_seller` varchar(50) NOT NULL,
`seller_id` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_traffic`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_traffic` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`store_id` int(11) NOT NULL,
`time` varchar(20) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_type`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_type` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`type_name` varchar(50) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`order_by` int(4) NOT NULL,
`store_id` int(11) NOT NULL,
`is_open` int(11) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_user`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_user` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(100) NOT NULL,
`join_time` int(11) NOT NULL,
`img` varchar(500) NOT NULL,
`openid` varchar(200) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`user_name` varchar(50) NOT NULL,
`user_tel` varchar(50) NOT NULL,
`user_address` varchar(100) NOT NULL,
`total_score` int(11) NOT NULL,
`wallet` decimal(10,2) NOT NULL,
`commission` decimal(10,2) NOT NULL,
`day` int(11) NOT NULL,
`order_money` decimal(10,2) NOT NULL,
`order_number` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_usercoupons`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_usercoupons` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`coupons_id` int(11) NOT NULL,
`state` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_uservoucher`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_uservoucher` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`vouchers_id` int(11) NOT NULL,
`state` int(11) NOT NULL,
`uniacid` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_uuset`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_uuset` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`store_id` int(11) NOT NULL,
`appid` varchar(50) NOT NULL,
`appkey` varchar(50) NOT NULL,
`account` varchar(30) NOT NULL,
`OpenId` varchar(50) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`is_open` int(4) NOT NULL DEFAULT '2',
`is_check` int(4) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_voucher`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_voucher` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(20) NOT NULL,
`start_time` varchar(20) NOT NULL,
`end_time` varchar(20) NOT NULL,
`preferential` varchar(10) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`voucher_type` int(4) NOT NULL,
`instruction` varchar(300) NOT NULL,
`store_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_withdrawal`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_withdrawal` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(10) NOT NULL,
`username` varchar(100) NOT NULL,
`type` int(11) NOT NULL,
`time` varchar(20) NOT NULL,
`sh_time` varchar(20) NOT NULL,
`state` int(11) NOT NULL,
`tx_cost` decimal(10,2) NOT NULL,
`sj_cost` decimal(10,2) NOT NULL,
`store_id` int(11) NOT NULL,
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_wpdc_ydorder`;
CREATE TABLE IF NOT EXISTS `ims_wpdc_ydorder` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`xz_date` varchar(30) NOT NULL,
`yjdd_date` varchar(30) NOT NULL,
`table_type_id` int(11) NOT NULL,
`link_name` varchar(50) NOT NULL,
`link_tel` varchar(50) NOT NULL,
`jc_num` int(4) NOT NULL,
`remark` varchar(500) NOT NULL,
`state` int(4) NOT NULL,
`uniacid` varchar(50) NOT NULL,
`created_time` varchar(30) NOT NULL,
`time2` int(11) NOT NULL,
`order_num` varchar(30) NOT NULL,
`table_type_name` varchar(50) NOT NULL,
`store_id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`zd_cost` decimal(10,2) NOT NULL,
`pay_money` decimal(10,2) NOT NULL,
`ydcode` varchar(100) NOT NULL,
`del` int(11) NOT NULL,
`is_yue` int(11) NOT NULL DEFAULT '2',
`completion_time` int(11) NOT NULL,
`form_id` varchar(100) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");
