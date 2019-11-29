<?php
$sql="CREATE TABLE IF NOT EXISTS `ims_sudu8_page_about` (
  `uniacid` int(10) NOT NULL DEFAULT '1',
  `content` mediumtext,
  `header` int(1) DEFAULT NULL,
  `tel_box` int(1) DEFAULT NULL,
  `serv_box` int(1) DEFAULT NULL,
  PRIMARY KEY (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_banner` (
  `uniacid` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` char(20) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `flag` int(1) NOT NULL,
  `num` int(10) NOT NULL,
  `descp` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_base` (
  `index_style` varchar(255) DEFAULT NULL,
  `about_style` varchar(255) DEFAULT NULL,
  `prolist_style` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `slide` varchar(2550) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `about` text,
  `aboutCN` varchar(255) DEFAULT '门店介绍',
  `aboutCNen` varchar(255) DEFAULT 'About Store',
  `index_about_title` varchar(255) DEFAULT NULL,
  `catename` varchar(255) DEFAULT '产品 & 服务',
  `catenameen` varchar(255) DEFAULT 'Products and Services',
  `copyright` varchar(255) DEFAULT '技术支持：小程序科技',
  `tel_b` varchar(255) DEFAULT NULL,
  `footer_style` varchar(255) DEFAULT NULL,
  `base_color` varchar(255) DEFAULT NULL,
  `base_color2` varchar(255) DEFAULT NULL,
  `index_pro_btn` varchar(255) DEFAULT NULL,
  `index_pro_lstyle` varchar(255) DEFAULT NULL,
  `index_pro_tstyle` varchar(255) DEFAULT NULL,
  `index_pro_ts_al` varchar(255) DEFAULT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `base_color_t` varchar(10) DEFAULT NULL,
  `c_title` int(2) DEFAULT NULL,
  `copyimg` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `v_img` varchar(255) DEFAULT NULL,
  `i_b_x_ts` int(2) DEFAULT NULL,
  `i_b_y_ts` int(2) DEFAULT NULL,
  `catename_x` varchar(255) DEFAULT NULL,
  `catenameen_x` varchar(255) DEFAULT NULL,
  `tel_box` int(1) DEFAULT NULL,
  `tabbar_bg` char(10) DEFAULT NULL,
  `tabbar_tc` char(10) DEFAULT NULL,
  `tabbar` text,
  `tabnum` int(1) DEFAULT NULL,
  `copy_do` int(1) DEFAULT NULL,
  `copy_id` int(5) DEFAULT NULL,
  `base_tcolor` varchar(10) DEFAULT NULL,
  `color_bar` char(8) DEFAULT NULL,
  `c_b_bg` varchar(255) DEFAULT NULL,
  `c_b_btn` int(1) DEFAULT NULL,
  `i_b_x_iw` int(3) DEFAULT NULL,
  `form_index` int(1) DEFAULT NULL,
  `tabbar_tca` char(10) DEFAULT NULL,
  `tabbar_time` int(11) DEFAULT NULL,
  `config` varchar(1000) DEFAULT NULL,
  `tabbar_t` int(1) NOT NULL DEFAULT '1',
  `hxmm` varchar(255) DEFAULT 'hx123456',
  `logo2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cid` int(11) DEFAULT NULL COMMENT '父栏目ID',
  `uniacid` int(11) DEFAULT NULL COMMENT 'uniacid',
  `name` varchar(255) DEFAULT NULL COMMENT '栏目名',
  `ename` varchar(255) DEFAULT NULL COMMENT '栏目英文名',
  `cdesc` varchar(255) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL COMMENT '栏目类型',
  `show_i` int(1) DEFAULT NULL COMMENT '首页显示',
  `statue` int(1) DEFAULT NULL COMMENT '栏目状态',
  `num` int(3) DEFAULT NULL COMMENT '栏目排序',
  `catepic` varchar(255) DEFAULT NULL COMMENT '栏目图片',
  `list_type` int(2) DEFAULT NULL COMMENT '列表显示类型',
  `list_style` int(2) DEFAULT NULL COMMENT '列表样式',
  `list_stylet` char(10) DEFAULT NULL,
  `list_tstyle` int(2) DEFAULT NULL COMMENT '首页标题样式',
  `list_tstylel` int(2) DEFAULT NULL,
  `content` mediumtext,
  `name_n` varchar(255) DEFAULT NULL,
  `pic_page_btn` int(1) DEFAULT '0',
  `cateconf` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_copyright` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `copycon` mediumtext,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '序号排序',
  `title` varchar(255) DEFAULT NULL,
  `uniacid` int(11) NOT NULL COMMENT '小程序ID',
  `price` varchar(255) NOT NULL DEFAULT '0' COMMENT '优惠价格',
  `pay_money` varchar(255) NOT NULL DEFAULT '0' COMMENT '使用条件价格',
  `btime` int(11) NOT NULL DEFAULT '0' COMMENT '使用开始日期',
  `etime` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券结束日期',
  `counts` int(11) NOT NULL DEFAULT '-1' COMMENT '优惠券总数',
  `xz_count` int(11) NOT NULL DEFAULT '0' COMMENT '每人限制领取数',
  `creattime` int(11) NOT NULL COMMENT '优惠券创建时间',
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '0关闭   1开启',
  `color` char(10) NOT NULL DEFAULT '#ff6600',
  `nownum` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_coupon_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL COMMENT '小程序id',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `cid` int(11) DEFAULT NULL COMMENT '优惠券id',
  `ltime` int(11) DEFAULT '0' COMMENT '领取时间',
  `utime` int(11) DEFAULT '0' COMMENT '使用时间',
  `btime` int(11) DEFAULT '0' COMMENT '开始时间',
  `etime` int(11) DEFAULT '0' COMMENT '结束时间',
  `flag` int(11) NOT NULL DEFAULT '0' COMMENT '0未使用1已使用2已过期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_formcon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `creattime` int(11) NOT NULL,
  `val` varchar(2000) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  `beizhu` varchar(255) NOT NULL,
  `vtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_formlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `formname` varchar(255) NOT NULL,
  `tp_text` varchar(8000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `wechat` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `single` varchar(255) DEFAULT NULL,
  `checkbox` varchar(255) DEFAULT NULL,
  `content` text,
  `time` int(10) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `vtime` int(10) DEFAULT NULL,
  `uniacid` int(11) NOT NULL,
  `sss_beizhu` varchar(255) DEFAULT NULL,
  `timef` varchar(10) DEFAULT NULL,
  `t5` varchar(255) DEFAULT NULL,
  `t6` varchar(255) DEFAULT NULL,
  `c2` varchar(255) DEFAULT NULL,
  `s2` varchar(255) DEFAULT NULL,
  `con2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_forms_config` (
  `forms_head` varchar(255) DEFAULT NULL,
  `forms_head_con` text,
  `forms_name` varchar(255) DEFAULT NULL,
  `forms_ename` varchar(255) DEFAULT NULL,
  `forms_title_s` varchar(255) DEFAULT NULL,
  `success` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT '姓名',
  `name_must` int(1) DEFAULT '1',
  `tel` varchar(255) DEFAULT '手机',
  `tel_use` int(1) DEFAULT '1',
  `tel_must` int(1) DEFAULT '1',
  `wechat` varchar(255) DEFAULT '微信',
  `wechat_use` int(1) DEFAULT '1',
  `wechat_must` int(1) DEFAULT '1',
  `address` varchar(255) DEFAULT '地址',
  `address_use` int(1) DEFAULT '1',
  `address_must` int(1) DEFAULT '1',
  `date` varchar(255) DEFAULT '预约时间',
  `date_use` int(1) DEFAULT '1',
  `date_must` int(1) DEFAULT '1',
  `single_n` varchar(255) DEFAULT '性别',
  `single_num` int(2) DEFAULT '2',
  `single_v` varchar(255) DEFAULT '男,女',
  `single_use` int(1) DEFAULT '1',
  `single_must` int(1) DEFAULT '1',
  `checkbox_n` varchar(255) DEFAULT '类型',
  `checkbox_num` int(2) DEFAULT '2',
  `checkbox_v` varchar(255) DEFAULT '栏目一,栏目二',
  `checkbox_use` int(1) DEFAULT '1',
  `content_n` varchar(255) DEFAULT '留言内容',
  `content_use` int(1) DEFAULT '1',
  `content_must` int(1) DEFAULT '1',
  `checkbox_must` int(1) DEFAULT '1',
  `mail_user` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `mail_sendto` varchar(255) DEFAULT NULL,
  `forms_btn` varchar(255) DEFAULT NULL,
  `mail_user_name` varchar(255) DEFAULT NULL,
  `forms_style` int(2) DEFAULT NULL,
  `forms_inps` int(2) DEFAULT NULL,
  `uniacid` int(11) NOT NULL,
  `subtime` int(2) DEFAULT NULL,
  `time_use` int(1) DEFAULT '1',
  `time_must` int(1) DEFAULT '1',
  `time` varchar(255) DEFAULT NULL,
  `tel_i` int(1) DEFAULT '0',
  `wechat_i` int(1) DEFAULT '0',
  `address_i` int(1) DEFAULT '0',
  `date_i` int(1) DEFAULT '0',
  `time_i` int(1) DEFAULT '0',
  `single_i` int(1) DEFAULT '0',
  `checkbox_i` int(1) DEFAULT '0',
  `content_i` int(1) DEFAULT '0',
  `t5` varchar(255) DEFAULT NULL,
  `t6` varchar(255) DEFAULT NULL,
  `c2` varchar(255) DEFAULT NULL,
  `s2` varchar(255) DEFAULT NULL,
  `con2` varchar(255) DEFAULT NULL,
  `img1` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_formt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `val` varchar(50) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL COMMENT '操作',
  `score` varchar(255) NOT NULL COMMENT '金钱',
  `message` varchar(255) NOT NULL COMMENT '说明',
  `creattime` int(11) NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uniacid` int(11) DEFAULT NULL COMMENT 'UID',
  `statue` int(1) DEFAULT NULL,
  `type` int(2) DEFAULT NULL COMMENT '首页，列表，单页，文章',
  `style` int(2) DEFAULT NULL,
  `url` varchar(999) DEFAULT NULL COMMENT '链接',
  `box_p_tb` float DEFAULT NULL COMMENT '外边距',
  `box_p_lr` float DEFAULT NULL COMMENT '左右间距',
  `number` int(2) DEFAULT NULL COMMENT '数量',
  `img_size` float DEFAULT NULL COMMENT '图片大小',
  `title_color` varchar(10) DEFAULT NULL COMMENT '标题颜色',
  `title_position` int(1) DEFAULT NULL COMMENT '标题样式',
  `title_bg` varchar(15) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `ename` varchar(50) DEFAULT NULL,
  `name_s` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_navlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  `type` int(2) NOT NULL COMMENT '0链接 1电话 2导航 3客服 4小程序 5.网页',
  `title` varchar(40) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `url2` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `product` varchar(255) DEFAULT NULL,
  `price` varchar(255) NOT NULL,
  `num` int(11) NOT NULL,
  `yhq` varchar(255) NOT NULL,
  `true_price` varchar(255) NOT NULL,
  `creattime` int(11) NOT NULL,
  `custime` int(11) DEFAULT NULL,
  `flag` int(11) NOT NULL DEFAULT '0',
  `pro_user_name` varchar(255) DEFAULT NULL,
  `pro_user_tel` varchar(255) DEFAULT NULL,
  `pro_user_txt` text NOT NULL,
  `overtime` int(11) DEFAULT NULL,
  `reback` int(11) DEFAULT '0',
  `is_more` int(1) NOT NULL DEFAULT '0',
  `coupon` int(11) DEFAULT NULL,
  `order_duo` text,
  `pro_user_add` varchar(100) DEFAULT NULL,
  `beizhu_val` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` mediumtext,
  `thumb` varchar(255) DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `etime` int(10) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `uniacid` int(11) NOT NULL,
  `cid` int(11) DEFAULT NULL,
  `pcid` int(11) DEFAULT NULL,
  `type_x` int(1) DEFAULT NULL,
  `type_y` int(1) DEFAULT NULL,
  `hits` int(11) DEFAULT NULL,
  `type_i` int(1) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `market_price` varchar(255) DEFAULT NULL,
  `label_1` int(11) DEFAULT '1',
  `label_2` int(11) DEFAULT '0',
  `sale_num` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `product_txt` text,
  `pro_flag` int(11) DEFAULT '0',
  `pro_kc` int(11) NOT NULL DEFAULT '-1',
  `pro_xz` int(11) NOT NULL DEFAULT '0',
  `sale_tnum` int(11) NOT NULL DEFAULT '0',
  `sale_type` int(11) DEFAULT '1',
  `sale_time` int(11) DEFAULT '0',
  `labels` varchar(255) DEFAULT NULL,
  `pro_flag_tel` int(1) NOT NULL DEFAULT '0',
  `pro_flag_data_name` varchar(40) DEFAULT '预约时间',
  `pro_flag_data` int(1) DEFAULT '0',
  `pro_flag_time` int(1) DEFAULT '0',
  `pro_flag_ding` int(1) DEFAULT '0',
  `is_more` int(1) DEFAULT '0',
  `more_type` text,
  `more_type_x` text,
  `more_type_num` text,
  `flag` int(1) DEFAULT '1',
  `buy_type` varchar(40) DEFAULT '购买',
  `pro_flag_add` int(1) DEFAULT '0',
  `formset` int(20) NOT NULL DEFAULT '0',
  `is_score` int(1) NOT NULL DEFAULT '0',
  `score_num` int(11) NOT NULL DEFAULT '0',
  `con2` varchar(5000) NOT NULL,
  `con3` varchar(5000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `money` varchar(255) NOT NULL DEFAULT '0',
  `getmoney` varchar(255) NOT NULL DEFAULT '0',
  `getscore` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_rechargeconf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `scroe` varchar(255) NOT NULL DEFAULT '100',
  `money` varchar(255) NOT NULL DEFAULT '1',
  `title` varchar(50) NOT NULL DEFAULT '充值有礼',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `score` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `creattime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lon` varchar(20) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `times` varchar(20) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `text` text,
  `dateline` int(11) DEFAULT NULL,
  `title1` varchar(50) DEFAULT NULL,
  `title2` varchar(50) DEFAULT NULL,
  `descp` varchar(255) DEFAULT NULL,
  `desc2` text NOT NULL,
  `province` varchar(255) DEFAULT NULL,
  `proid` int(11) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `cityid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_storeconf` (
  `uniacid` int(11) NOT NULL,
  `mapkey` varchar(50) NOT NULL,
  `flag` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned DEFAULT NULL COMMENT '小程序ID',
  `openid` varchar(255) DEFAULT NULL,
  `createtime` int(10) unsigned NOT NULL COMMENT '加入时间',
  `realname` varchar(10) DEFAULT '' COMMENT '真实姓名',
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '昵称',
  `avatar` varchar(255) DEFAULT NULL,
  `qq` varchar(15) DEFAULT '' COMMENT 'QQ号',
  `mobile` varchar(11) DEFAULT '' COMMENT '手机号码',
  `gender` tinyint(1) DEFAULT '0' COMMENT '性别(0:保密 1:男 2:女)',
  `telephone` varchar(15) DEFAULT '' COMMENT '固定电话',
  `idcardtype` tinyint(1) DEFAULT '1' COMMENT '证件类型：身份证 护照 军官证等',
  `idcard` varchar(30) DEFAULT '' COMMENT '证件号码',
  `address` varchar(255) DEFAULT '' COMMENT '邮寄地址',
  `zipcode` varchar(10) DEFAULT '' COMMENT '邮编',
  `nationality` varchar(30) DEFAULT '' COMMENT '国籍',
  `resideprovince` varchar(30) DEFAULT '' COMMENT '居住省份',
  `residecity` varchar(30) DEFAULT '' COMMENT '居住城市',
  `residedist` varchar(30) DEFAULT '' COMMENT '居住行政区/县',
  `residecommunity` varchar(30) DEFAULT '' COMMENT '居住小区',
  `residesuite` varchar(30) DEFAULT '' COMMENT '小区、写字楼门牌号',
  `graduateschool` varchar(50) DEFAULT '' COMMENT '毕业学校',
  `company` varchar(50) DEFAULT '' COMMENT '公司',
  `education` varchar(10) DEFAULT '' COMMENT '学历',
  `occupation` varchar(30) DEFAULT '' COMMENT '职业',
  `position` varchar(30) DEFAULT '' COMMENT '职位',
  `revenue` varchar(10) DEFAULT '' COMMENT '年收入',
  `affectivestatus` varchar(30) DEFAULT '' COMMENT '情感状态',
  `lookingfor` varchar(255) DEFAULT '' COMMENT ' 交友目的',
  `bloodtype` varchar(5) DEFAULT '' COMMENT '血型',
  `height` varchar(5) DEFAULT '' COMMENT '身高',
  `weight` varchar(5) DEFAULT '' COMMENT '体重',
  `alipay` varchar(30) DEFAULT '' COMMENT '支付宝帐号',
  `msn` varchar(30) DEFAULT '' COMMENT 'MSN',
  `taobao` varchar(30) DEFAULT '' COMMENT '阿里旺旺',
  `site` varchar(30) DEFAULT '' COMMENT '主页',
  `bio` text COMMENT '自我介绍',
  `interest` text COMMENT '兴趣爱好',
  `money` float NOT NULL DEFAULT '0',
  `score` float NOT NULL DEFAULT '0',
  `flag` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_wxapps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `pcid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `type_i` int(1) NOT NULL,
  `appId` varchar(20) NOT NULL,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
";
pdo_run($sql);
if(!pdo_fieldexists('sudu8_page_about',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_about')." ADD `uniacid` int(10) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_about',  'content')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_about')." ADD `content` mediumtext;");
}
if(!pdo_fieldexists('sudu8_page_about',  'header')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_about')." ADD `header` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_about',  'tel_box')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_about')." ADD `tel_box` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_about',  'serv_box')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_about')." ADD `serv_box` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_banner',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_banner')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_banner',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_banner')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_banner',  'type')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_banner')." ADD `type` char(20) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_banner',  'pic')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_banner')." ADD `pic` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_banner',  'url')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_banner')." ADD `url` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_banner',  'flag')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_banner')." ADD `flag` int(1) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_banner',  'num')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_banner')." ADD `num` int(10) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_banner',  'descp')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_banner')." ADD `descp` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'index_style')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `index_style` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'about_style')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `about_style` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'prolist_style')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `prolist_style` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'banner')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `banner` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'slide')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `slide` varchar(2550) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'name')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `name` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'logo')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `logo` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'desc')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `desc` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'address')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `address` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'time')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `time` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'tel')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `tel` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'longitude')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `longitude` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'latitude')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `latitude` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'about')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `about` text;");
}
if(!pdo_fieldexists('sudu8_page_base',  'aboutCN')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `aboutCN` varchar(255) DEFAULT '门店介绍';");
}
if(!pdo_fieldexists('sudu8_page_base',  'aboutCNen')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `aboutCNen` varchar(255) DEFAULT 'About Store';");
}
if(!pdo_fieldexists('sudu8_page_base',  'index_about_title')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `index_about_title` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'catename')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `catename` varchar(255) DEFAULT '产品 & 服务';");
}
if(!pdo_fieldexists('sudu8_page_base',  'catenameen')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `catenameen` varchar(255) DEFAULT 'Products and Services';");
}
if(!pdo_fieldexists('sudu8_page_base',  'copyright')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `copyright` varchar(255) DEFAULT '技术支持：小程序科技';");
}
if(!pdo_fieldexists('sudu8_page_base',  'tel_b')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `tel_b` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'footer_style')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `footer_style` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'base_color')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `base_color` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'base_color2')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `base_color2` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'index_pro_btn')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `index_pro_btn` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'index_pro_lstyle')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `index_pro_lstyle` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'index_pro_tstyle')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `index_pro_tstyle` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'index_pro_ts_al')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `index_pro_ts_al` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `uniacid` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_base',  'base_color_t')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `base_color_t` varchar(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'c_title')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `c_title` int(2) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'copyimg')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `copyimg` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'video')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `video` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'v_img')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `v_img` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'i_b_x_ts')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `i_b_x_ts` int(2) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'i_b_y_ts')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `i_b_y_ts` int(2) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'catename_x')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `catename_x` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'catenameen_x')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `catenameen_x` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'tel_box')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `tel_box` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'tabbar_bg')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `tabbar_bg` char(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'tabbar_tc')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `tabbar_tc` char(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'tabbar')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `tabbar` text;");
}
if(!pdo_fieldexists('sudu8_page_base',  'tabnum')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `tabnum` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'copy_do')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `copy_do` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'copy_id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `copy_id` int(5) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'base_tcolor')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `base_tcolor` varchar(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'color_bar')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `color_bar` char(8) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'c_b_bg')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `c_b_bg` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'c_b_btn')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `c_b_btn` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'i_b_x_iw')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `i_b_x_iw` int(3) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'form_index')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `form_index` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'tabbar_tca')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `tabbar_tca` char(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'tabbar_time')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `tabbar_time` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'config')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `config` varchar(1000) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_base',  'tabbar_t')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `tabbar_t` int(1) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_base',  'hxmm')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `hxmm` varchar(255) DEFAULT 'hx123456';");
}
if(!pdo_fieldexists('sudu8_page_base',  'logo2')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_base')." ADD `logo2` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_cate',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';");
}
if(!pdo_fieldexists('sudu8_page_cate',  'cid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `cid` int(11) DEFAULT NULL COMMENT '父栏目ID';");
}
if(!pdo_fieldexists('sudu8_page_cate',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `uniacid` int(11) DEFAULT NULL COMMENT 'uniacid';");
}
if(!pdo_fieldexists('sudu8_page_cate',  'name')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `name` varchar(255) DEFAULT NULL COMMENT '栏目名';");
}
if(!pdo_fieldexists('sudu8_page_cate',  'ename')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `ename` varchar(255) DEFAULT NULL COMMENT '栏目英文名';");
}
if(!pdo_fieldexists('sudu8_page_cate',  'cdesc')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `cdesc` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_cate',  'type')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `type` varchar(20) DEFAULT NULL COMMENT '栏目类型';");
}
if(!pdo_fieldexists('sudu8_page_cate',  'show_i')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `show_i` int(1) DEFAULT NULL COMMENT '首页显示';");
}
if(!pdo_fieldexists('sudu8_page_cate',  'statue')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `statue` int(1) DEFAULT NULL COMMENT '栏目状态';");
}
if(!pdo_fieldexists('sudu8_page_cate',  'num')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `num` int(3) DEFAULT NULL COMMENT '栏目排序';");
}
if(!pdo_fieldexists('sudu8_page_cate',  'catepic')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `catepic` varchar(255) DEFAULT NULL COMMENT '栏目图片';");
}
if(!pdo_fieldexists('sudu8_page_cate',  'list_type')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `list_type` int(2) DEFAULT NULL COMMENT '列表显示类型';");
}
if(!pdo_fieldexists('sudu8_page_cate',  'list_style')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `list_style` int(2) DEFAULT NULL COMMENT '列表样式';");
}
if(!pdo_fieldexists('sudu8_page_cate',  'list_stylet')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `list_stylet` char(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_cate',  'list_tstyle')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `list_tstyle` int(2) DEFAULT NULL COMMENT '首页标题样式';");
}
if(!pdo_fieldexists('sudu8_page_cate',  'list_tstylel')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `list_tstylel` int(2) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_cate',  'content')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `content` mediumtext;");
}
if(!pdo_fieldexists('sudu8_page_cate',  'name_n')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `name_n` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_cate',  'pic_page_btn')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `pic_page_btn` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_cate',  'cateconf')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_cate')." ADD `cateconf` varchar(500) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_collect',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_collect')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_collect',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_collect')." ADD `uid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_collect',  'type')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_collect')." ADD `type` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_collect',  'cid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_collect')." ADD `cid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_collect',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_collect')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_copyright',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_copyright')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_copyright',  'copycon')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_copyright')." ADD `copycon` mediumtext;");
}
if(!pdo_fieldexists('sudu8_page_copyright',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_copyright')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_coupon',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_coupon',  'num')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon')." ADD `num` int(11) NOT NULL DEFAULT '0' COMMENT '序号排序';");
}
if(!pdo_fieldexists('sudu8_page_coupon',  'title')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon')." ADD `title` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_coupon',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon')." ADD `uniacid` int(11) NOT NULL COMMENT '小程序ID';");
}
if(!pdo_fieldexists('sudu8_page_coupon',  'price')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon')." ADD `price` varchar(255) NOT NULL DEFAULT '0' COMMENT '优惠价格';");
}
if(!pdo_fieldexists('sudu8_page_coupon',  'pay_money')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon')." ADD `pay_money` varchar(255) NOT NULL DEFAULT '0' COMMENT '使用条件价格';");
}
if(!pdo_fieldexists('sudu8_page_coupon',  'btime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon')." ADD `btime` int(11) NOT NULL DEFAULT '0' COMMENT '使用开始日期';");
}
if(!pdo_fieldexists('sudu8_page_coupon',  'etime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon')." ADD `etime` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券结束日期';");
}
if(!pdo_fieldexists('sudu8_page_coupon',  'counts')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon')." ADD `counts` int(11) NOT NULL DEFAULT '-1' COMMENT '优惠券总数';");
}
if(!pdo_fieldexists('sudu8_page_coupon',  'xz_count')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon')." ADD `xz_count` int(11) NOT NULL DEFAULT '0' COMMENT '每人限制领取数';");
}
if(!pdo_fieldexists('sudu8_page_coupon',  'creattime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon')." ADD `creattime` int(11) NOT NULL COMMENT '优惠券创建时间';");
}
if(!pdo_fieldexists('sudu8_page_coupon',  'flag')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon')." ADD `flag` int(1) NOT NULL DEFAULT '1' COMMENT '0关闭   1开启';");
}
if(!pdo_fieldexists('sudu8_page_coupon',  'color')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon')." ADD `color` char(10) NOT NULL DEFAULT '#ff6600';");
}
if(!pdo_fieldexists('sudu8_page_coupon',  'nownum')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon')." ADD `nownum` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_coupon_user',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon_user')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_coupon_user',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon_user')." ADD `uniacid` int(11) DEFAULT NULL COMMENT '小程序id';");
}
if(!pdo_fieldexists('sudu8_page_coupon_user',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon_user')." ADD `uid` int(11) DEFAULT NULL COMMENT '用户id';");
}
if(!pdo_fieldexists('sudu8_page_coupon_user',  'cid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon_user')." ADD `cid` int(11) DEFAULT NULL COMMENT '优惠券id';");
}
if(!pdo_fieldexists('sudu8_page_coupon_user',  'ltime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon_user')." ADD `ltime` int(11) DEFAULT '0' COMMENT '领取时间';");
}
if(!pdo_fieldexists('sudu8_page_coupon_user',  'utime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon_user')." ADD `utime` int(11) DEFAULT '0' COMMENT '使用时间';");
}
if(!pdo_fieldexists('sudu8_page_coupon_user',  'btime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon_user')." ADD `btime` int(11) DEFAULT '0' COMMENT '开始时间';");
}
if(!pdo_fieldexists('sudu8_page_coupon_user',  'etime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon_user')." ADD `etime` int(11) DEFAULT '0' COMMENT '结束时间';");
}
if(!pdo_fieldexists('sudu8_page_coupon_user',  'flag')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_coupon_user')." ADD `flag` int(11) NOT NULL DEFAULT '0' COMMENT '0未使用1已使用2已过期';");
}
if(!pdo_fieldexists('sudu8_page_formcon',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formcon')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_formcon',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formcon')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_formcon',  'cid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formcon')." ADD `cid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_formcon',  'creattime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formcon')." ADD `creattime` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_formcon',  'val')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formcon')." ADD `val` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_formcon',  'flag')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formcon')." ADD `flag` int(1) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_formcon',  'beizhu')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formcon')." ADD `beizhu` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_formcon',  'vtime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formcon')." ADD `vtime` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_formlist',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formlist')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_formlist',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formlist')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_formlist',  'formname')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formlist')." ADD `formname` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_formlist',  'tp_text')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formlist')." ADD `tp_text` varchar(8000) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'name')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `name` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'tel')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `tel` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'wechat')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `wechat` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'address')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `address` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'date')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `date` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'single')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `single` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'checkbox')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `checkbox` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'content')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `content` text;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'time')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `time` int(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'status')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `status` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_forms',  'vtime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `vtime` int(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'sss_beizhu')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `sss_beizhu` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'timef')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `timef` varchar(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  't5')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `t5` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  't6')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `t6` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'c2')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `c2` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  's2')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `s2` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms',  'con2')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms')." ADD `con2` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'forms_head')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `forms_head` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'forms_head_con')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `forms_head_con` text;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'forms_name')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `forms_name` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'forms_ename')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `forms_ename` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'forms_title_s')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `forms_title_s` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'success')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `success` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'name')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `name` varchar(255) DEFAULT '姓名';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'name_must')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `name_must` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'tel')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `tel` varchar(255) DEFAULT '手机';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'tel_use')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `tel_use` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'tel_must')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `tel_must` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'wechat')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `wechat` varchar(255) DEFAULT '微信';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'wechat_use')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `wechat_use` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'wechat_must')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `wechat_must` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'address')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `address` varchar(255) DEFAULT '地址';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'address_use')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `address_use` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'address_must')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `address_must` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'date')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `date` varchar(255) DEFAULT '预约时间';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'date_use')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `date_use` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'date_must')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `date_must` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'single_n')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `single_n` varchar(255) DEFAULT '性别';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'single_num')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `single_num` int(2) DEFAULT '2';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'single_v')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `single_v` varchar(255) DEFAULT '男,女';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'single_use')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `single_use` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'single_must')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `single_must` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'checkbox_n')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `checkbox_n` varchar(255) DEFAULT '类型';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'checkbox_num')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `checkbox_num` int(2) DEFAULT '2';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'checkbox_v')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `checkbox_v` varchar(255) DEFAULT '栏目一,栏目二';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'checkbox_use')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `checkbox_use` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'content_n')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `content_n` varchar(255) DEFAULT '留言内容';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'content_use')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `content_use` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'content_must')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `content_must` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'checkbox_must')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `checkbox_must` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'mail_user')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `mail_user` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'mail_password')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `mail_password` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'mail_sendto')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `mail_sendto` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'forms_btn')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `forms_btn` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'mail_user_name')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `mail_user_name` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'forms_style')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `forms_style` int(2) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'forms_inps')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `forms_inps` int(2) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'subtime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `subtime` int(2) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'time_use')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `time_use` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'time_must')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `time_must` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'time')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `time` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'tel_i')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `tel_i` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'wechat_i')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `wechat_i` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'address_i')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `address_i` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'date_i')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `date_i` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'time_i')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `time_i` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'single_i')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `single_i` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'checkbox_i')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `checkbox_i` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'content_i')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `content_i` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  't5')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `t5` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  't6')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `t6` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'c2')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `c2` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  's2')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `s2` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'con2')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `con2` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_forms_config',  'img1')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_forms_config')." ADD `img1` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_formt',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formt')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_formt',  'name')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formt')." ADD `name` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_formt',  'val')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formt')." ADD `val` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_formt',  'flag')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_formt')." ADD `flag` int(1) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_money',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_money')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_money',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_money')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_money',  'orderid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_money')." ADD `orderid` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_money',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_money')." ADD `uid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_money',  'type')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_money')." ADD `type` varchar(255) NOT NULL COMMENT '操作';");
}
if(!pdo_fieldexists('sudu8_page_money',  'score')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_money')." ADD `score` varchar(255) NOT NULL COMMENT '金钱';");
}
if(!pdo_fieldexists('sudu8_page_money',  'message')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_money')." ADD `message` varchar(255) NOT NULL COMMENT '说明';");
}
if(!pdo_fieldexists('sudu8_page_money',  'creattime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_money')." ADD `creattime` int(11) NOT NULL COMMENT '时间';");
}
if(!pdo_fieldexists('sudu8_page_nav',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';");
}
if(!pdo_fieldexists('sudu8_page_nav',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `uniacid` int(11) DEFAULT NULL COMMENT 'UID';");
}
if(!pdo_fieldexists('sudu8_page_nav',  'statue')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `statue` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_nav',  'type')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `type` int(2) DEFAULT NULL COMMENT '首页，列表，单页，文章';");
}
if(!pdo_fieldexists('sudu8_page_nav',  'style')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `style` int(2) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_nav',  'url')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `url` varchar(999) DEFAULT NULL COMMENT '链接';");
}
if(!pdo_fieldexists('sudu8_page_nav',  'box_p_tb')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `box_p_tb` float DEFAULT NULL COMMENT '外边距';");
}
if(!pdo_fieldexists('sudu8_page_nav',  'box_p_lr')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `box_p_lr` float DEFAULT NULL COMMENT '左右间距';");
}
if(!pdo_fieldexists('sudu8_page_nav',  'number')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `number` int(2) DEFAULT NULL COMMENT '数量';");
}
if(!pdo_fieldexists('sudu8_page_nav',  'img_size')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `img_size` float DEFAULT NULL COMMENT '图片大小';");
}
if(!pdo_fieldexists('sudu8_page_nav',  'title_color')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `title_color` varchar(10) DEFAULT NULL COMMENT '标题颜色';");
}
if(!pdo_fieldexists('sudu8_page_nav',  'title_position')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `title_position` int(1) DEFAULT NULL COMMENT '标题样式';");
}
if(!pdo_fieldexists('sudu8_page_nav',  'title_bg')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `title_bg` varchar(15) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_nav',  'name')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `name` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_nav',  'ename')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `ename` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_nav',  'name_s')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_nav')." ADD `name_s` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_navlist',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_navlist')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_navlist',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_navlist')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_navlist',  'num')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_navlist')." ADD `num` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_navlist',  'flag')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_navlist')." ADD `flag` int(1) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_navlist',  'type')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_navlist')." ADD `type` int(2) NOT NULL COMMENT '0链接 1电话 2导航 3客服 4小程序 5.网页';");
}
if(!pdo_fieldexists('sudu8_page_navlist',  'title')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_navlist')." ADD `title` varchar(40) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_navlist',  'pic')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_navlist')." ADD `pic` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_navlist',  'url')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_navlist')." ADD `url` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_navlist',  'url2')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_navlist')." ADD `url2` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_order',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'order_id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `order_id` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `uid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'openid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `openid` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'pid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `pid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'thumb')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `thumb` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'product')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `product` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'price')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `price` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'num')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `num` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'yhq')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `yhq` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'true_price')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `true_price` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'creattime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `creattime` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'custime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `custime` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'flag')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `flag` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_order',  'pro_user_name')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `pro_user_name` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'pro_user_tel')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `pro_user_tel` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'pro_user_txt')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `pro_user_txt` text NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'overtime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `overtime` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'reback')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `reback` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_order',  'is_more')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `is_more` int(1) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_order',  'coupon')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `coupon` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'order_duo')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `order_duo` text;");
}
if(!pdo_fieldexists('sudu8_page_order',  'pro_user_add')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `pro_user_add` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_order',  'beizhu_val')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_order')." ADD `beizhu_val` text;");
}
if(!pdo_fieldexists('sudu8_page_products',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_products',  'num')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `num` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'type')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `type` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'title')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `title` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'text')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `text` mediumtext;");
}
if(!pdo_fieldexists('sudu8_page_products',  'thumb')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `thumb` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'ctime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `ctime` int(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'etime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `etime` int(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'desc')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `desc` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'cid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `cid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'pcid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `pcid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'type_x')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `type_x` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'type_y')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `type_y` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'hits')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `hits` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'type_i')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `type_i` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'video')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `video` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'price')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `price` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'market_price')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `market_price` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'label_1')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `label_1` int(11) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_products',  'label_2')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `label_2` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_products',  'sale_num')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `sale_num` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'score')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `score` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'product_txt')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `product_txt` text;");
}
if(!pdo_fieldexists('sudu8_page_products',  'pro_flag')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `pro_flag` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_products',  'pro_kc')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `pro_kc` int(11) NOT NULL DEFAULT '-1';");
}
if(!pdo_fieldexists('sudu8_page_products',  'pro_xz')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `pro_xz` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_products',  'sale_tnum')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `sale_tnum` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_products',  'sale_type')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `sale_type` int(11) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_products',  'sale_time')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `sale_time` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_products',  'labels')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `labels` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'pro_flag_tel')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `pro_flag_tel` int(1) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_products',  'pro_flag_data_name')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `pro_flag_data_name` varchar(40) DEFAULT '预约时间';");
}
if(!pdo_fieldexists('sudu8_page_products',  'pro_flag_data')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `pro_flag_data` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_products',  'pro_flag_time')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `pro_flag_time` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_products',  'pro_flag_ding')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `pro_flag_ding` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_products',  'is_more')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `is_more` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_products',  'more_type')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `more_type` text;");
}
if(!pdo_fieldexists('sudu8_page_products',  'more_type_x')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `more_type_x` text;");
}
if(!pdo_fieldexists('sudu8_page_products',  'more_type_num')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `more_type_num` text;");
}
if(!pdo_fieldexists('sudu8_page_products',  'flag')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `flag` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_products',  'buy_type')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `buy_type` varchar(40) DEFAULT '购买';");
}
if(!pdo_fieldexists('sudu8_page_products',  'pro_flag_add')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `pro_flag_add` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_products',  'formset')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `formset` int(20) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_products',  'is_score')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `is_score` int(1) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_products',  'score_num')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `score_num` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_products',  'con2')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `con2` varchar(5000) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_products',  'con3')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_products')." ADD `con3` varchar(5000) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_recharge',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_recharge')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_recharge',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_recharge')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_recharge',  'money')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_recharge')." ADD `money` varchar(255) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_recharge',  'getmoney')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_recharge')." ADD `getmoney` varchar(255) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_recharge',  'getscore')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_recharge')." ADD `getscore` varchar(255) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_rechargeconf',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_rechargeconf')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_rechargeconf',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_rechargeconf')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_rechargeconf',  'scroe')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_rechargeconf')." ADD `scroe` varchar(255) NOT NULL DEFAULT '100';");
}
if(!pdo_fieldexists('sudu8_page_rechargeconf',  'money')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_rechargeconf')." ADD `money` varchar(255) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('sudu8_page_rechargeconf',  'title')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_rechargeconf')." ADD `title` varchar(50) NOT NULL DEFAULT '充值有礼';");
}
if(!pdo_fieldexists('sudu8_page_score',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_score',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_score',  'orderid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD `orderid` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_score',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD `uid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_score',  'type')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD `type` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_score',  'score')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD `score` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_score',  'message')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD `message` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_score',  'creattime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_score')." ADD `creattime` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_store',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'thumb')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `thumb` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'logo')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `logo` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'title')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `title` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'lat')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `lat` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'lon')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `lon` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'tel')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `tel` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'times')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `times` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'country')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `country` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'text')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `text` text;");
}
if(!pdo_fieldexists('sudu8_page_store',  'dateline')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `dateline` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'title1')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `title1` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'title2')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `title2` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'descp')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `descp` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'desc2')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `desc2` text NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'province')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `province` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'proid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `proid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'city')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `city` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_store',  'cityid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_store')." ADD `cityid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_storeconf',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_storeconf')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_storeconf',  'mapkey')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_storeconf')." ADD `mapkey` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_storeconf',  'flag')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_storeconf')." ADD `flag` int(2) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_user',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_user',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `uniacid` int(10) unsigned DEFAULT NULL COMMENT '小程序ID';");
}
if(!pdo_fieldexists('sudu8_page_user',  'openid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `openid` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_user',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `createtime` int(10) unsigned NOT NULL COMMENT '加入时间';");
}
if(!pdo_fieldexists('sudu8_page_user',  'realname')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `realname` varchar(10) DEFAULT '' COMMENT '真实姓名';");
}
if(!pdo_fieldexists('sudu8_page_user',  'nickname')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '昵称';");
}
if(!pdo_fieldexists('sudu8_page_user',  'avatar')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `avatar` varchar(255) DEFAULT NULL;");
}
if(!pdo_fieldexists('sudu8_page_user',  'qq')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `qq` varchar(15) DEFAULT '' COMMENT 'QQ号';");
}
if(!pdo_fieldexists('sudu8_page_user',  'mobile')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `mobile` varchar(11) DEFAULT '' COMMENT '手机号码';");
}
if(!pdo_fieldexists('sudu8_page_user',  'gender')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `gender` tinyint(1) DEFAULT '0' COMMENT '性别(0:保密 1:男 2:女)';");
}
if(!pdo_fieldexists('sudu8_page_user',  'telephone')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `telephone` varchar(15) DEFAULT '' COMMENT '固定电话';");
}
if(!pdo_fieldexists('sudu8_page_user',  'idcardtype')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `idcardtype` tinyint(1) DEFAULT '1' COMMENT '证件类型：身份证 护照 军官证等';");
}
if(!pdo_fieldexists('sudu8_page_user',  'idcard')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `idcard` varchar(30) DEFAULT '' COMMENT '证件号码';");
}
if(!pdo_fieldexists('sudu8_page_user',  'address')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `address` varchar(255) DEFAULT '' COMMENT '邮寄地址';");
}
if(!pdo_fieldexists('sudu8_page_user',  'zipcode')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `zipcode` varchar(10) DEFAULT '' COMMENT '邮编';");
}
if(!pdo_fieldexists('sudu8_page_user',  'nationality')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `nationality` varchar(30) DEFAULT '' COMMENT '国籍';");
}
if(!pdo_fieldexists('sudu8_page_user',  'resideprovince')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `resideprovince` varchar(30) DEFAULT '' COMMENT '居住省份';");
}
if(!pdo_fieldexists('sudu8_page_user',  'residecity')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `residecity` varchar(30) DEFAULT '' COMMENT '居住城市';");
}
if(!pdo_fieldexists('sudu8_page_user',  'residedist')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `residedist` varchar(30) DEFAULT '' COMMENT '居住行政区/县';");
}
if(!pdo_fieldexists('sudu8_page_user',  'residecommunity')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `residecommunity` varchar(30) DEFAULT '' COMMENT '居住小区';");
}
if(!pdo_fieldexists('sudu8_page_user',  'residesuite')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `residesuite` varchar(30) DEFAULT '' COMMENT '小区、写字楼门牌号';");
}
if(!pdo_fieldexists('sudu8_page_user',  'graduateschool')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `graduateschool` varchar(50) DEFAULT '' COMMENT '毕业学校';");
}
if(!pdo_fieldexists('sudu8_page_user',  'company')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `company` varchar(50) DEFAULT '' COMMENT '公司';");
}
if(!pdo_fieldexists('sudu8_page_user',  'education')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `education` varchar(10) DEFAULT '' COMMENT '学历';");
}
if(!pdo_fieldexists('sudu8_page_user',  'occupation')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `occupation` varchar(30) DEFAULT '' COMMENT '职业';");
}
if(!pdo_fieldexists('sudu8_page_user',  'position')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `position` varchar(30) DEFAULT '' COMMENT '职位';");
}
if(!pdo_fieldexists('sudu8_page_user',  'revenue')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `revenue` varchar(10) DEFAULT '' COMMENT '年收入';");
}
if(!pdo_fieldexists('sudu8_page_user',  'affectivestatus')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `affectivestatus` varchar(30) DEFAULT '' COMMENT '情感状态';");
}
if(!pdo_fieldexists('sudu8_page_user',  'lookingfor')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `lookingfor` varchar(255) DEFAULT '' COMMENT ' 交友目的';");
}
if(!pdo_fieldexists('sudu8_page_user',  'bloodtype')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `bloodtype` varchar(5) DEFAULT '' COMMENT '血型';");
}
if(!pdo_fieldexists('sudu8_page_user',  'height')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `height` varchar(5) DEFAULT '' COMMENT '身高';");
}
if(!pdo_fieldexists('sudu8_page_user',  'weight')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `weight` varchar(5) DEFAULT '' COMMENT '体重';");
}
if(!pdo_fieldexists('sudu8_page_user',  'alipay')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `alipay` varchar(30) DEFAULT '' COMMENT '支付宝帐号';");
}
if(!pdo_fieldexists('sudu8_page_user',  'msn')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `msn` varchar(30) DEFAULT '' COMMENT 'MSN';");
}
if(!pdo_fieldexists('sudu8_page_user',  'taobao')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `taobao` varchar(30) DEFAULT '' COMMENT '阿里旺旺';");
}
if(!pdo_fieldexists('sudu8_page_user',  'site')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `site` varchar(30) DEFAULT '' COMMENT '主页';");
}
if(!pdo_fieldexists('sudu8_page_user',  'bio')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `bio` text COMMENT '自我介绍';");
}
if(!pdo_fieldexists('sudu8_page_user',  'interest')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `interest` text COMMENT '兴趣爱好';");
}
if(!pdo_fieldexists('sudu8_page_user',  'money')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `money` float NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_user',  'score')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `score` float NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_user',  'flag')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_user')." ADD `flag` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('sudu8_page_wxapps',  'id')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_wxapps')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('sudu8_page_wxapps',  'cid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_wxapps')." ADD `cid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_wxapps',  'pcid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_wxapps')." ADD `pcid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_wxapps',  'num')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_wxapps')." ADD `num` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_wxapps',  'type')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_wxapps')." ADD `type` varchar(20) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_wxapps',  'title')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_wxapps')." ADD `title` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_wxapps',  'desc')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_wxapps')." ADD `desc` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_wxapps',  'thumb')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_wxapps')." ADD `thumb` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_wxapps',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_wxapps')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_wxapps',  'type_i')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_wxapps')." ADD `type_i` int(1) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_wxapps',  'appId')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_wxapps')." ADD `appId` varchar(20) NOT NULL;");
}
if(!pdo_fieldexists('sudu8_page_wxapps',  'path')) {
	pdo_query("ALTER TABLE ".tablename('sudu8_page_wxapps')." ADD `path` varchar(255) NOT NULL;");
}

?>