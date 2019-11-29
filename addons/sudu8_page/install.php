<?php
pdo_query("
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `ims_sudu8_page_about`;
CREATE TABLE `ims_sudu8_page_about` (
  `uniacid` int(10) NOT NULL DEFAULT '1',
  `content` mediumtext,
  `header` int(1) DEFAULT NULL,
  `tel_box` int(1) DEFAULT NULL,
  `serv_box` int(1) DEFAULT NULL,
  PRIMARY KEY (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
DROP TABLE IF EXISTS `ims_sudu8_page_banner`;
CREATE TABLE `ims_sudu8_page_banner` (
  `uniacid` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` char(20) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `flag` int(1) NOT NULL,
  `num` int(10) NOT NULL,
  `descp` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sudu8_page_base`;
CREATE TABLE `ims_sudu8_page_base` (
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
DROP TABLE IF EXISTS `ims_sudu8_page_cate`;
CREATE TABLE `ims_sudu8_page_cate` (
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
DROP TABLE IF EXISTS `ims_sudu8_page_collect`;
CREATE TABLE `ims_sudu8_page_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sudu8_page_copyright`;
CREATE TABLE `ims_sudu8_page_copyright` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `copycon` mediumtext,
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
DROP TABLE IF EXISTS `ims_sudu8_page_coupon`;
CREATE TABLE `ims_sudu8_page_coupon` (
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sudu8_page_coupon_user`;
CREATE TABLE `ims_sudu8_page_coupon_user` (
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sudu8_page_formcon`;
CREATE TABLE `ims_sudu8_page_formcon` (
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
DROP TABLE IF EXISTS `ims_sudu8_page_formlist`;
CREATE TABLE `ims_sudu8_page_formlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `formname` varchar(255) NOT NULL,
  `tp_text` varchar(8000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sudu8_page_forms`;
CREATE TABLE `ims_sudu8_page_forms` (
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
DROP TABLE IF EXISTS `ims_sudu8_page_forms_config`;
CREATE TABLE `ims_sudu8_page_forms_config` (
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
DROP TABLE IF EXISTS `ims_sudu8_page_formt`;
CREATE TABLE `ims_sudu8_page_formt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `val` varchar(50) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sudu8_page_money`;
CREATE TABLE `ims_sudu8_page_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL COMMENT '操作',
  `score` varchar(255) NOT NULL COMMENT '金钱',
  `message` varchar(255) NOT NULL COMMENT '说明',
  `creattime` int(11) NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sudu8_page_nav`;
CREATE TABLE `ims_sudu8_page_nav` (
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
DROP TABLE IF EXISTS `ims_sudu8_page_navlist`;
CREATE TABLE `ims_sudu8_page_navlist` (
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sudu8_page_order`;
CREATE TABLE `ims_sudu8_page_order` (
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
DROP TABLE IF EXISTS `ims_sudu8_page_products`;
CREATE TABLE `ims_sudu8_page_products` (
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
DROP TABLE IF EXISTS `ims_sudu8_page_recharge`;
CREATE TABLE `ims_sudu8_page_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `money` varchar(255) NOT NULL DEFAULT '0',
  `getmoney` varchar(255) NOT NULL DEFAULT '0',
  `getscore` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sudu8_page_rechargeconf`;
CREATE TABLE `ims_sudu8_page_rechargeconf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `scroe` varchar(255) NOT NULL DEFAULT '100',
  `money` varchar(255) NOT NULL DEFAULT '1',
  `title` varchar(50) NOT NULL DEFAULT '充值有礼',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sudu8_page_score`;
CREATE TABLE `ims_sudu8_page_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `score` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `creattime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sudu8_page_store`;
CREATE TABLE `ims_sudu8_page_store` (
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sudu8_page_storeconf`;
CREATE TABLE `ims_sudu8_page_storeconf` (
  `uniacid` int(11) NOT NULL,
  `mapkey` varchar(50) NOT NULL,
  `flag` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `ims_sudu8_page_user`;
CREATE TABLE `ims_sudu8_page_user` (
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
DROP TABLE IF EXISTS `ims_sudu8_page_wxapps`;
CREATE TABLE `ims_sudu8_page_wxapps` (
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


");
