<?php
$sql="CREATE TABLE IF NOT EXISTS `ims_wg_sales_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `type` int(11) NOT NULL,
  `content` text NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_article_ad` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cate` int(11) NOT NULL DEFAULT '1' COMMENT '1:文章,2:广告',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0:未审核,1:审核过,2:拒绝',
  `money` int(11) NOT NULL DEFAULT '0',
  `article_id` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...',
  `author` varchar(256) NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(150) NOT NULL DEFAULT '',
  `image` varchar(2000) NOT NULL,
  `kw` varchar(20) DEFAULT '',
  `url` varchar(1024) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `time_step` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `jump` int(11) NOT NULL DEFAULT '0',
  `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制',
  `md5` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_article_news_1` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...',
  `site` varchar(100) NOT NULL,
  `author` varchar(256) NOT NULL DEFAULT '',
  `majory_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(500) NOT NULL DEFAULT '',
  `image` varchar(2000) NOT NULL,
  `kw` varchar(250) DEFAULT NULL,
  `url` varchar(1024) NOT NULL DEFAULT '',
  `text` varchar(300) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `praise` int(11) NOT NULL DEFAULT '0',
  `read_times` int(10) unsigned NOT NULL DEFAULT '0',
  `time_step` int(11) NOT NULL DEFAULT '0',
  `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json',
  `jump` int(11) NOT NULL DEFAULT '0',
  `comment_times` int(11) NOT NULL DEFAULT '0',
  `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制',
  `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明',
  `goods_info` varchar(500) NOT NULL DEFAULT '' COMMENT '推荐商品信息',
  `md5` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_article_news_2` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...',
  `site` varchar(100) NOT NULL,
  `author` varchar(256) NOT NULL DEFAULT '',
  `majory_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(500) NOT NULL DEFAULT '',
  `image` varchar(2000) NOT NULL,
  `kw` varchar(250) DEFAULT NULL,
  `url` varchar(1024) NOT NULL DEFAULT '',
  `text` varchar(300) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `praise` int(11) NOT NULL DEFAULT '0',
  `read_times` int(10) unsigned NOT NULL DEFAULT '0',
  `time_step` int(11) NOT NULL DEFAULT '0',
  `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json',
  `jump` int(11) NOT NULL DEFAULT '0',
  `comment_times` int(11) NOT NULL DEFAULT '0',
  `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制',
  `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明',
  `goods_info` varchar(500) NOT NULL DEFAULT '' COMMENT '推荐商品信息',
  `md5` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_article_news_3` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...',
  `site` varchar(100) NOT NULL,
  `author` varchar(256) NOT NULL DEFAULT '',
  `majory_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(500) NOT NULL DEFAULT '',
  `image` varchar(2000) NOT NULL,
  `kw` varchar(250) DEFAULT NULL,
  `url` varchar(1024) NOT NULL DEFAULT '',
  `text` varchar(300) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `praise` int(11) NOT NULL DEFAULT '0',
  `read_times` int(10) unsigned NOT NULL DEFAULT '0',
  `time_step` int(11) NOT NULL DEFAULT '0',
  `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json',
  `jump` int(11) NOT NULL DEFAULT '0',
  `comment_times` int(11) NOT NULL DEFAULT '0',
  `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制',
  `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明',
  `goods_info` varchar(500) NOT NULL DEFAULT '' COMMENT '推荐商品信息',
  `md5` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_article_news_4` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...',
  `site` varchar(100) NOT NULL,
  `author` varchar(256) NOT NULL DEFAULT '',
  `majory_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(500) NOT NULL DEFAULT '',
  `image` varchar(2000) NOT NULL,
  `kw` varchar(250) DEFAULT NULL,
  `url` varchar(1024) NOT NULL DEFAULT '',
  `text` varchar(300) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `praise` int(11) NOT NULL DEFAULT '0',
  `read_times` int(10) unsigned NOT NULL DEFAULT '0',
  `time_step` int(11) NOT NULL DEFAULT '0',
  `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json',
  `jump` int(11) NOT NULL DEFAULT '0',
  `comment_times` int(11) NOT NULL DEFAULT '0',
  `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制',
  `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明',
  `goods_info` varchar(500) NOT NULL DEFAULT '' COMMENT '推荐商品信息',
  `md5` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_article_news_5` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...',
  `site` varchar(100) NOT NULL,
  `author` varchar(256) NOT NULL DEFAULT '',
  `majory_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(500) NOT NULL DEFAULT '',
  `image` varchar(2000) NOT NULL,
  `kw` varchar(250) DEFAULT NULL,
  `url` varchar(1024) NOT NULL DEFAULT '',
  `text` varchar(300) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `praise` int(11) NOT NULL DEFAULT '0',
  `read_times` int(10) unsigned NOT NULL DEFAULT '0',
  `time_step` int(11) NOT NULL DEFAULT '0',
  `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json',
  `jump` int(11) NOT NULL DEFAULT '0',
  `comment_times` int(11) NOT NULL DEFAULT '0',
  `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制',
  `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明',
  `goods_info` varchar(500) NOT NULL DEFAULT '' COMMENT '推荐商品信息',
  `md5` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_article_news_6` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...',
  `site` varchar(100) NOT NULL,
  `author` varchar(256) NOT NULL DEFAULT '',
  `majory_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(500) NOT NULL DEFAULT '',
  `image` varchar(2000) NOT NULL,
  `kw` varchar(250) DEFAULT NULL,
  `url` varchar(1024) NOT NULL DEFAULT '',
  `text` varchar(300) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `praise` int(11) NOT NULL DEFAULT '0',
  `read_times` int(10) unsigned NOT NULL DEFAULT '0',
  `time_step` int(11) NOT NULL DEFAULT '0',
  `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json',
  `jump` int(11) NOT NULL DEFAULT '0',
  `comment_times` int(11) NOT NULL DEFAULT '0',
  `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制',
  `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明',
  `goods_info` varchar(500) NOT NULL DEFAULT '' COMMENT '推荐商品信息',
  `md5` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_article_news_7` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...',
  `site` varchar(100) NOT NULL,
  `author` varchar(256) NOT NULL DEFAULT '',
  `majory_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(500) NOT NULL DEFAULT '',
  `image` varchar(2000) NOT NULL,
  `kw` varchar(250) DEFAULT NULL,
  `url` varchar(1024) NOT NULL DEFAULT '',
  `text` varchar(300) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `praise` int(11) NOT NULL DEFAULT '0',
  `read_times` int(10) unsigned NOT NULL DEFAULT '0',
  `time_step` int(11) NOT NULL DEFAULT '0',
  `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json',
  `jump` int(11) NOT NULL DEFAULT '0',
  `comment_times` int(11) NOT NULL DEFAULT '0',
  `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制',
  `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明',
  `goods_info` varchar(500) NOT NULL DEFAULT '' COMMENT '推荐商品信息',
  `md5` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_article_news_8` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...',
  `site` varchar(100) NOT NULL,
  `author` varchar(256) NOT NULL DEFAULT '',
  `majory_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(500) NOT NULL DEFAULT '',
  `image` varchar(2000) NOT NULL,
  `kw` varchar(250) DEFAULT NULL,
  `url` varchar(1024) NOT NULL DEFAULT '',
  `text` varchar(300) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `praise` int(11) NOT NULL DEFAULT '0',
  `read_times` int(10) unsigned NOT NULL DEFAULT '0',
  `time_step` int(11) NOT NULL DEFAULT '0',
  `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json',
  `jump` int(11) NOT NULL DEFAULT '0',
  `comment_times` int(11) NOT NULL DEFAULT '0',
  `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制',
  `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明',
  `md5` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_article_news_9` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...',
  `site` varchar(100) NOT NULL,
  `author` varchar(256) NOT NULL DEFAULT '',
  `majory_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(500) NOT NULL DEFAULT '',
  `image` varchar(2000) NOT NULL,
  `kw` varchar(250) DEFAULT NULL,
  `url` varchar(1024) NOT NULL DEFAULT '',
  `text` varchar(300) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `praise` int(11) NOT NULL DEFAULT '0',
  `read_times` int(10) unsigned NOT NULL DEFAULT '0',
  `time_step` int(11) NOT NULL DEFAULT '0',
  `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json',
  `jump` int(11) NOT NULL DEFAULT '0',
  `comment_times` int(11) NOT NULL DEFAULT '0',
  `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制',
  `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明',
  `md5` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(20) NOT NULL DEFAULT '',
  `display_order` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `source` varchar(300) NOT NULL,
  `del` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `jump` int(11) NOT NULL DEFAULT '0',
  `url` varchar(1024) NOT NULL DEFAULT '',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_comment_1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名',
  `article_id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL DEFAULT '0',
  `content` varchar(300) NOT NULL DEFAULT '',
  `praise` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id',
  `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `comment_id` (`comment_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_comment_2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名',
  `article_id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL DEFAULT '0',
  `content` varchar(300) NOT NULL DEFAULT '',
  `praise` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id',
  `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `comment_id` (`comment_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_comment_3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名',
  `article_id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL DEFAULT '0',
  `content` varchar(300) NOT NULL DEFAULT '',
  `praise` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id',
  `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `comment_id` (`comment_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_comment_4` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名',
  `article_id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL DEFAULT '0',
  `content` varchar(300) NOT NULL DEFAULT '',
  `praise` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id',
  `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `comment_id` (`comment_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_comment_5` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名',
  `article_id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL DEFAULT '0',
  `content` varchar(300) NOT NULL DEFAULT '',
  `praise` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id',
  `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `comment_id` (`comment_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_comment_6` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名',
  `article_id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL DEFAULT '0',
  `content` varchar(300) NOT NULL DEFAULT '',
  `praise` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id',
  `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `comment_id` (`comment_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_comment_7` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名',
  `article_id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL DEFAULT '0',
  `content` varchar(300) NOT NULL DEFAULT '',
  `praise` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id',
  `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `comment_id` (`comment_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_comment_8` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名',
  `article_id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL DEFAULT '0',
  `content` varchar(300) NOT NULL DEFAULT '',
  `praise` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id',
  `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `comment_id` (`comment_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_comment_9` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名',
  `article_id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL DEFAULT '0',
  `content` varchar(300) NOT NULL DEFAULT '',
  `praise` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id',
  `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `comment_id` (`comment_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_reward` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `pay_money` int(11) NOT NULL DEFAULT '0' COMMENT '实际支付金额',
  `order_no` varchar(50) NOT NULL COMMENT '订单id',
  `pay_type` int(11) NOT NULL DEFAULT '1' COMMENT '支付类型',
  `fail_reason` varchar(100) NOT NULL DEFAULT '' COMMENT '失败',
  `trade_no` varchar(50) NOT NULL DEFAULT '' COMMENT '微信流水号',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1待处理,2成功，3失败',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `message` varchar(100) NOT NULL DEFAULT '',
  `mch_id` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_no` (`order_no`),
  KEY `category_id` (`category_id`,`article_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `expire_time` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:轮播图,置顶(1:普通,2:图集,3:视频)',
  `uniacid` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `source` int(11) NOT NULL DEFAULT '0',
  `article_id` int(11) NOT NULL DEFAULT '0',
  `jump` int(11) NOT NULL DEFAULT '0',
  `url` varchar(200) NOT NULL,
  `image` varchar(2000) NOT NULL,
  `title` varchar(100) NOT NULL,
  `kw` varchar(10) NOT NULL DEFAULT '',
  `display_order` int(11) NOT NULL DEFAULT '0',
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`source`,`display_order`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0',
  `uniacid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `text` varchar(150) NOT NULL DEFAULT '',
  `kw` varchar(10) NOT NULL DEFAULT '',
  `image` varchar(2000) NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`display_order`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_topic_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL DEFAULT '0',
  `jump` int(11) NOT NULL DEFAULT '0',
  `url` varchar(200) NOT NULL,
  `image` varchar(2000) NOT NULL,
  `title` varchar(100) NOT NULL,
  `kw` varchar(10) NOT NULL DEFAULT '',
  `display_order` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`topic_id`,`display_order`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wg_sales_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL,
  `nickname` varchar(20) NOT NULL DEFAULT '',
  `tel` varchar(30) NOT NULL DEFAULT '',
  `headimgurl` varchar(255) NOT NULL DEFAULT '',
  `openid` varchar(255) NOT NULL DEFAULT '',
  `unionid` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL DEFAULT '',
  `province` varchar(50) NOT NULL DEFAULT '',
  `country` varchar(50) NOT NULL DEFAULT '',
  `subscribe` int(10) DEFAULT '0',
  `sex` int(11) DEFAULT '0',
  `add_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `subscribe_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`,`uniacid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
";
pdo_run($sql);
if(!pdo_fieldexists('wg_sales_ad',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_ad')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_ad',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_ad')." ADD `name` varchar(20) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_ad',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_ad')." ADD `type` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_ad',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_ad')." ADD `content` text NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_ad',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_ad')." ADD `create_time` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `uid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'cate')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `cate` int(11) NOT NULL DEFAULT '1' COMMENT '1:文章,2:广告';");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `status` int(11) NOT NULL DEFAULT '0' COMMENT '0:未审核,1:审核过,2:拒绝';");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'money')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `money` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `article_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...';");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'author')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `author` varchar(256) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'category_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `category_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `title` varchar(150) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'image')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `image` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'kw')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `kw` varchar(20) DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'url')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `url` varchar(1024) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `content` longtext NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'time_step')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `time_step` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'update_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `update_time` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'jump')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `jump` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'special')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制';");
}
if(!pdo_fieldexists('wg_sales_article_ad',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD `md5` varchar(32) NOT NULL;");
}
if(!pdo_indexexists('wg_sales_article_ad',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD UNIQUE KEY `md5` (`md5`);");
}
if(!pdo_indexexists('wg_sales_article_ad',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_ad')." ADD KEY `uid` (`uid`);");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...';");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'site')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `site` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'author')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `author` varchar(256) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'majory_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `majory_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `title` varchar(500) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'image')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `image` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'kw')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `kw` varchar(250) DEFAULT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'url')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `url` varchar(1024) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'text')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `text` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `content` longtext NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'read_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `read_times` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'time_step')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `time_step` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'data_type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json';");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'jump')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `jump` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `comment_times` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'special')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制';");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'state')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明';");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'goods_info')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `goods_info` varchar(500) NOT NULL DEFAULT '' COMMENT '推荐商品信息';");
}
if(!pdo_fieldexists('wg_sales_article_news_1',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD `md5` varchar(32) NOT NULL;");
}
if(!pdo_indexexists('wg_sales_article_news_1',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_1')." ADD UNIQUE KEY `md5` (`md5`);");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...';");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'site')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `site` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'author')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `author` varchar(256) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'majory_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `majory_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `title` varchar(500) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'image')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `image` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'kw')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `kw` varchar(250) DEFAULT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'url')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `url` varchar(1024) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'text')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `text` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `content` longtext NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'read_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `read_times` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'time_step')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `time_step` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'data_type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json';");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'jump')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `jump` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `comment_times` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'special')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制';");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'state')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明';");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'goods_info')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `goods_info` varchar(500) NOT NULL DEFAULT '' COMMENT '推荐商品信息';");
}
if(!pdo_fieldexists('wg_sales_article_news_2',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD `md5` varchar(32) NOT NULL;");
}
if(!pdo_indexexists('wg_sales_article_news_2',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_2')." ADD UNIQUE KEY `md5` (`md5`);");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...';");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'site')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `site` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'author')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `author` varchar(256) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'majory_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `majory_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `title` varchar(500) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'image')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `image` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'kw')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `kw` varchar(250) DEFAULT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'url')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `url` varchar(1024) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'text')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `text` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `content` longtext NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'read_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `read_times` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'time_step')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `time_step` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'data_type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json';");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'jump')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `jump` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `comment_times` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'special')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制';");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'state')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明';");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'goods_info')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `goods_info` varchar(500) NOT NULL DEFAULT '' COMMENT '推荐商品信息';");
}
if(!pdo_fieldexists('wg_sales_article_news_3',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD `md5` varchar(32) NOT NULL;");
}
if(!pdo_indexexists('wg_sales_article_news_3',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_3')." ADD UNIQUE KEY `md5` (`md5`);");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...';");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'site')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `site` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'author')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `author` varchar(256) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'majory_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `majory_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `title` varchar(500) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'image')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `image` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'kw')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `kw` varchar(250) DEFAULT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'url')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `url` varchar(1024) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'text')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `text` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `content` longtext NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'read_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `read_times` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'time_step')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `time_step` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'data_type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json';");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'jump')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `jump` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `comment_times` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'special')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制';");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'state')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明';");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'goods_info')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `goods_info` varchar(500) NOT NULL DEFAULT '' COMMENT '推荐商品信息';");
}
if(!pdo_fieldexists('wg_sales_article_news_4',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD `md5` varchar(32) NOT NULL;");
}
if(!pdo_indexexists('wg_sales_article_news_4',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_4')." ADD UNIQUE KEY `md5` (`md5`);");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...';");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'site')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `site` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'author')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `author` varchar(256) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'majory_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `majory_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `title` varchar(500) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'image')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `image` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'kw')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `kw` varchar(250) DEFAULT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'url')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `url` varchar(1024) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'text')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `text` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `content` longtext NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'read_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `read_times` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'time_step')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `time_step` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'data_type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json';");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'jump')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `jump` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `comment_times` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'special')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制';");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'state')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明';");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'goods_info')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `goods_info` varchar(500) NOT NULL DEFAULT '' COMMENT '推荐商品信息';");
}
if(!pdo_fieldexists('wg_sales_article_news_5',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD `md5` varchar(32) NOT NULL;");
}
if(!pdo_indexexists('wg_sales_article_news_5',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_5')." ADD UNIQUE KEY `md5` (`md5`);");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...';");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'site')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `site` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'author')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `author` varchar(256) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'majory_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `majory_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `title` varchar(500) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'image')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `image` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'kw')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `kw` varchar(250) DEFAULT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'url')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `url` varchar(1024) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'text')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `text` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `content` longtext NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'read_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `read_times` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'time_step')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `time_step` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'data_type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json';");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'jump')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `jump` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `comment_times` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'special')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制';");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'state')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明';");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'goods_info')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `goods_info` varchar(500) NOT NULL DEFAULT '' COMMENT '推荐商品信息';");
}
if(!pdo_fieldexists('wg_sales_article_news_6',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD `md5` varchar(32) NOT NULL;");
}
if(!pdo_indexexists('wg_sales_article_news_6',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_6')." ADD UNIQUE KEY `md5` (`md5`);");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...';");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'site')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `site` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'author')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `author` varchar(256) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'majory_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `majory_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `title` varchar(500) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'image')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `image` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'kw')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `kw` varchar(250) DEFAULT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'url')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `url` varchar(1024) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'text')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `text` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `content` longtext NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'read_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `read_times` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'time_step')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `time_step` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'data_type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json';");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'jump')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `jump` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `comment_times` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'special')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制';");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'state')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明';");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'goods_info')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `goods_info` varchar(500) NOT NULL DEFAULT '' COMMENT '推荐商品信息';");
}
if(!pdo_fieldexists('wg_sales_article_news_7',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD `md5` varchar(32) NOT NULL;");
}
if(!pdo_indexexists('wg_sales_article_news_7',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_7')." ADD UNIQUE KEY `md5` (`md5`);");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...';");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'site')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `site` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'author')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `author` varchar(256) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'majory_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `majory_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `title` varchar(500) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'image')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `image` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'kw')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `kw` varchar(250) DEFAULT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'url')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `url` varchar(1024) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'text')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `text` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `content` longtext NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'read_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `read_times` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'time_step')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `time_step` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'data_type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json';");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'jump')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `jump` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `comment_times` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'special')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制';");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'state')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明';");
}
if(!pdo_fieldexists('wg_sales_article_news_8',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD `md5` varchar(32) NOT NULL;");
}
if(!pdo_indexexists('wg_sales_article_news_8',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_8')." ADD UNIQUE KEY `md5` (`md5`);");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...';");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'site')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `site` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'author')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `author` varchar(256) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'majory_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `majory_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `title` varchar(500) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'image')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `image` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'kw')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `kw` varchar(250) DEFAULT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'url')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `url` varchar(1024) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'text')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `text` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `content` longtext NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'read_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `read_times` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'time_step')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `time_step` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'data_type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json';");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'jump')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `jump` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `comment_times` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'special')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `special` int(11) NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制';");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'state')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明';");
}
if(!pdo_fieldexists('wg_sales_article_news_9',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD `md5` varchar(32) NOT NULL;");
}
if(!pdo_indexexists('wg_sales_article_news_9',  'md5')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_article_news_9')." ADD UNIQUE KEY `md5` (`md5`);");
}
if(!pdo_fieldexists('wg_sales_category',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_category')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_category',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_category')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wg_sales_category',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_category')." ADD `name` varchar(20) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_category',  'display_order')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_category')." ADD `display_order` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_category',  'parent_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_category')." ADD `parent_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_category',  'source')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_category')." ADD `source` varchar(300) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_category',  'del')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_category')." ADD `del` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_category',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_category')." ADD `create_time` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_category',  'jump')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_category')." ADD `jump` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_category',  'url')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_category')." ADD `url` varchar(1024) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_category',  'update_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_category')." ADD `update_time` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_1',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_1')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_comment_1',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_1')." ADD `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名';");
}
if(!pdo_fieldexists('wg_sales_comment_1',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_1')." ADD `article_id` bigint(20) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_comment_1',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_1')." ADD `uid` bigint(20) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_1',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_1')." ADD `content` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_1',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_1')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_1',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_1')." ADD `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id';");
}
if(!pdo_fieldexists('wg_sales_comment_1',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_1')." ADD `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数';");
}
if(!pdo_fieldexists('wg_sales_comment_1',  'ip')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_1')." ADD `ip` varchar(20) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_1',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_1')." ADD `create_time` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_indexexists('wg_sales_comment_1',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_1')." ADD KEY `article_id` (`article_id`);");
}
if(!pdo_indexexists('wg_sales_comment_1',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_1')." ADD KEY `comment_id` (`comment_id`);");
}
if(!pdo_indexexists('wg_sales_comment_1',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_1')." ADD KEY `uid` (`uid`);");
}
if(!pdo_fieldexists('wg_sales_comment_2',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_2')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_comment_2',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_2')." ADD `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名';");
}
if(!pdo_fieldexists('wg_sales_comment_2',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_2')." ADD `article_id` bigint(20) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_comment_2',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_2')." ADD `uid` bigint(20) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_2',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_2')." ADD `content` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_2',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_2')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_2',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_2')." ADD `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id';");
}
if(!pdo_fieldexists('wg_sales_comment_2',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_2')." ADD `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数';");
}
if(!pdo_fieldexists('wg_sales_comment_2',  'ip')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_2')." ADD `ip` varchar(20) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_2',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_2')." ADD `create_time` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_indexexists('wg_sales_comment_2',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_2')." ADD KEY `article_id` (`article_id`);");
}
if(!pdo_indexexists('wg_sales_comment_2',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_2')." ADD KEY `comment_id` (`comment_id`);");
}
if(!pdo_indexexists('wg_sales_comment_2',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_2')." ADD KEY `uid` (`uid`);");
}
if(!pdo_fieldexists('wg_sales_comment_3',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_3')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_comment_3',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_3')." ADD `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名';");
}
if(!pdo_fieldexists('wg_sales_comment_3',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_3')." ADD `article_id` bigint(20) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_comment_3',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_3')." ADD `uid` bigint(20) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_3',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_3')." ADD `content` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_3',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_3')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_3',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_3')." ADD `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id';");
}
if(!pdo_fieldexists('wg_sales_comment_3',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_3')." ADD `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数';");
}
if(!pdo_fieldexists('wg_sales_comment_3',  'ip')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_3')." ADD `ip` varchar(20) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_3',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_3')." ADD `create_time` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_indexexists('wg_sales_comment_3',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_3')." ADD KEY `article_id` (`article_id`);");
}
if(!pdo_indexexists('wg_sales_comment_3',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_3')." ADD KEY `comment_id` (`comment_id`);");
}
if(!pdo_indexexists('wg_sales_comment_3',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_3')." ADD KEY `uid` (`uid`);");
}
if(!pdo_fieldexists('wg_sales_comment_4',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_4')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_comment_4',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_4')." ADD `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名';");
}
if(!pdo_fieldexists('wg_sales_comment_4',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_4')." ADD `article_id` bigint(20) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_comment_4',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_4')." ADD `uid` bigint(20) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_4',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_4')." ADD `content` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_4',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_4')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_4',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_4')." ADD `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id';");
}
if(!pdo_fieldexists('wg_sales_comment_4',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_4')." ADD `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数';");
}
if(!pdo_fieldexists('wg_sales_comment_4',  'ip')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_4')." ADD `ip` varchar(20) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_4',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_4')." ADD `create_time` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_indexexists('wg_sales_comment_4',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_4')." ADD KEY `article_id` (`article_id`);");
}
if(!pdo_indexexists('wg_sales_comment_4',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_4')." ADD KEY `comment_id` (`comment_id`);");
}
if(!pdo_indexexists('wg_sales_comment_4',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_4')." ADD KEY `uid` (`uid`);");
}
if(!pdo_fieldexists('wg_sales_comment_5',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_5')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_comment_5',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_5')." ADD `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名';");
}
if(!pdo_fieldexists('wg_sales_comment_5',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_5')." ADD `article_id` bigint(20) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_comment_5',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_5')." ADD `uid` bigint(20) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_5',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_5')." ADD `content` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_5',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_5')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_5',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_5')." ADD `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id';");
}
if(!pdo_fieldexists('wg_sales_comment_5',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_5')." ADD `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数';");
}
if(!pdo_fieldexists('wg_sales_comment_5',  'ip')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_5')." ADD `ip` varchar(20) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_5',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_5')." ADD `create_time` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_indexexists('wg_sales_comment_5',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_5')." ADD KEY `article_id` (`article_id`);");
}
if(!pdo_indexexists('wg_sales_comment_5',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_5')." ADD KEY `comment_id` (`comment_id`);");
}
if(!pdo_indexexists('wg_sales_comment_5',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_5')." ADD KEY `uid` (`uid`);");
}
if(!pdo_fieldexists('wg_sales_comment_6',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_6')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_comment_6',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_6')." ADD `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名';");
}
if(!pdo_fieldexists('wg_sales_comment_6',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_6')." ADD `article_id` bigint(20) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_comment_6',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_6')." ADD `uid` bigint(20) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_6',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_6')." ADD `content` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_6',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_6')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_6',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_6')." ADD `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id';");
}
if(!pdo_fieldexists('wg_sales_comment_6',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_6')." ADD `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数';");
}
if(!pdo_fieldexists('wg_sales_comment_6',  'ip')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_6')." ADD `ip` varchar(20) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_6',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_6')." ADD `create_time` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_indexexists('wg_sales_comment_6',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_6')." ADD KEY `article_id` (`article_id`);");
}
if(!pdo_indexexists('wg_sales_comment_6',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_6')." ADD KEY `comment_id` (`comment_id`);");
}
if(!pdo_indexexists('wg_sales_comment_6',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_6')." ADD KEY `uid` (`uid`);");
}
if(!pdo_fieldexists('wg_sales_comment_7',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_7')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_comment_7',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_7')." ADD `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名';");
}
if(!pdo_fieldexists('wg_sales_comment_7',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_7')." ADD `article_id` bigint(20) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_comment_7',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_7')." ADD `uid` bigint(20) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_7',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_7')." ADD `content` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_7',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_7')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_7',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_7')." ADD `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id';");
}
if(!pdo_fieldexists('wg_sales_comment_7',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_7')." ADD `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数';");
}
if(!pdo_fieldexists('wg_sales_comment_7',  'ip')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_7')." ADD `ip` varchar(20) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_7',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_7')." ADD `create_time` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_indexexists('wg_sales_comment_7',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_7')." ADD KEY `article_id` (`article_id`);");
}
if(!pdo_indexexists('wg_sales_comment_7',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_7')." ADD KEY `comment_id` (`comment_id`);");
}
if(!pdo_indexexists('wg_sales_comment_7',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_7')." ADD KEY `uid` (`uid`);");
}
if(!pdo_fieldexists('wg_sales_comment_8',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_8')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_comment_8',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_8')." ADD `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名';");
}
if(!pdo_fieldexists('wg_sales_comment_8',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_8')." ADD `article_id` bigint(20) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_comment_8',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_8')." ADD `uid` bigint(20) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_8',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_8')." ADD `content` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_8',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_8')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_8',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_8')." ADD `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id';");
}
if(!pdo_fieldexists('wg_sales_comment_8',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_8')." ADD `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数';");
}
if(!pdo_fieldexists('wg_sales_comment_8',  'ip')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_8')." ADD `ip` varchar(20) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_8',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_8')." ADD `create_time` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_indexexists('wg_sales_comment_8',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_8')." ADD KEY `article_id` (`article_id`);");
}
if(!pdo_indexexists('wg_sales_comment_8',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_8')." ADD KEY `comment_id` (`comment_id`);");
}
if(!pdo_indexexists('wg_sales_comment_8',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_8')." ADD KEY `uid` (`uid`);");
}
if(!pdo_fieldexists('wg_sales_comment_9',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_9')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_comment_9',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_9')." ADD `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名';");
}
if(!pdo_fieldexists('wg_sales_comment_9',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_9')." ADD `article_id` bigint(20) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_comment_9',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_9')." ADD `uid` bigint(20) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_9',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_9')." ADD `content` varchar(300) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_9',  'praise')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_9')." ADD `praise` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_comment_9',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_9')." ADD `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id';");
}
if(!pdo_fieldexists('wg_sales_comment_9',  'comment_times')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_9')." ADD `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数';");
}
if(!pdo_fieldexists('wg_sales_comment_9',  'ip')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_9')." ADD `ip` varchar(20) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_comment_9',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_9')." ADD `create_time` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_indexexists('wg_sales_comment_9',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_9')." ADD KEY `article_id` (`article_id`);");
}
if(!pdo_indexexists('wg_sales_comment_9',  'comment_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_9')." ADD KEY `comment_id` (`comment_id`);");
}
if(!pdo_indexexists('wg_sales_comment_9',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_comment_9')." ADD KEY `uid` (`uid`);");
}
if(!pdo_fieldexists('wg_sales_reward',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_reward',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_reward',  'category_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `category_id` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_reward',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `article_id` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_reward',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `uid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_reward',  'money')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `money` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_reward',  'pay_money')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `pay_money` int(11) NOT NULL DEFAULT '0' COMMENT '实际支付金额';");
}
if(!pdo_fieldexists('wg_sales_reward',  'order_no')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `order_no` varchar(50) NOT NULL COMMENT '订单id';");
}
if(!pdo_fieldexists('wg_sales_reward',  'pay_type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `pay_type` int(11) NOT NULL DEFAULT '1' COMMENT '支付类型';");
}
if(!pdo_fieldexists('wg_sales_reward',  'fail_reason')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `fail_reason` varchar(100) NOT NULL DEFAULT '' COMMENT '失败';");
}
if(!pdo_fieldexists('wg_sales_reward',  'trade_no')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `trade_no` varchar(50) NOT NULL DEFAULT '' COMMENT '微信流水号';");
}
if(!pdo_fieldexists('wg_sales_reward',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `status` int(11) NOT NULL DEFAULT '1' COMMENT '1待处理,2成功，3失败';");
}
if(!pdo_fieldexists('wg_sales_reward',  'update_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `update_time` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_reward',  'message')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `message` varchar(100) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_reward',  'mch_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `mch_id` varchar(20) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_reward',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD `create_time` int(11) NOT NULL;");
}
if(!pdo_indexexists('wg_sales_reward',  'order_no')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD UNIQUE KEY `order_no` (`order_no`);");
}
if(!pdo_indexexists('wg_sales_reward',  'category_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_reward')." ADD KEY `category_id` (`category_id`,`article_id`) USING BTREE;");
}
if(!pdo_fieldexists('wg_sales_setting',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_setting')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_setting',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_setting')." ADD `name` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_setting',  'value')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_setting')." ADD `value` text NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_setting',  'expire_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_setting')." ADD `expire_time` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_setting',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_setting')." ADD `create_time` int(11) NOT NULL;");
}
if(!pdo_indexexists('wg_sales_setting',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_setting')." ADD UNIQUE KEY `name` (`name`);");
}
if(!pdo_fieldexists('wg_sales_slider',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_slider',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:轮播图,置顶(1:普通,2:图集,3:视频)';");
}
if(!pdo_fieldexists('wg_sales_slider',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_slider',  'category_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD `category_id` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_slider',  'source')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD `source` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_slider',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD `article_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_slider',  'jump')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD `jump` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_slider',  'url')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD `url` varchar(200) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_slider',  'image')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD `image` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_slider',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD `title` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_slider',  'kw')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD `kw` varchar(10) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_slider',  'display_order')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD `display_order` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_slider',  'start')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD `start` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_slider',  'end')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD `end` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_slider',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD `create_time` int(11) NOT NULL;");
}
if(!pdo_indexexists('wg_sales_slider',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_slider')." ADD KEY `uniacid` (`uniacid`,`source`,`display_order`) USING BTREE;");
}
if(!pdo_fieldexists('wg_sales_topic',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_topic',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic')." ADD `type` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_topic',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_topic',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic')." ADD `title` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_topic',  'text')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic')." ADD `text` varchar(150) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_topic',  'kw')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic')." ADD `kw` varchar(10) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_topic',  'image')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic')." ADD `image` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_topic',  'display_order')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic')." ADD `display_order` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_topic',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic')." ADD `create_time` int(11) NOT NULL;");
}
if(!pdo_indexexists('wg_sales_topic',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic')." ADD KEY `uniacid` (`uniacid`,`display_order`) USING BTREE;");
}
if(!pdo_fieldexists('wg_sales_topic_list',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic_list')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_topic_list',  'topic_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic_list')." ADD `topic_id` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_topic_list',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic_list')." ADD `type` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_topic_list',  'category_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic_list')." ADD `category_id` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_topic_list',  'article_id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic_list')." ADD `article_id` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_topic_list',  'jump')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic_list')." ADD `jump` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_topic_list',  'url')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic_list')." ADD `url` varchar(200) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_topic_list',  'image')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic_list')." ADD `image` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_topic_list',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic_list')." ADD `title` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_topic_list',  'kw')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic_list')." ADD `kw` varchar(10) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_topic_list',  'display_order')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic_list')." ADD `display_order` int(11) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_topic_list',  'create_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic_list')." ADD `create_time` int(11) NOT NULL;");
}
if(!pdo_indexexists('wg_sales_topic_list',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_topic_list')." ADD KEY `uniacid` (`topic_id`,`display_order`) USING BTREE;");
}
if(!pdo_fieldexists('wg_sales_user',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wg_sales_user',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD `uniacid` int(11) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wg_sales_user',  'nickname')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD `nickname` varchar(20) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_user',  'tel')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD `tel` varchar(30) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_user',  'headimgurl')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD `headimgurl` varchar(255) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_user',  'openid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD `openid` varchar(255) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_user',  'unionid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD `unionid` varchar(255) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_user',  'city')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD `city` varchar(50) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_user',  'province')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD `province` varchar(50) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_user',  'country')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD `country` varchar(50) NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('wg_sales_user',  'subscribe')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD `subscribe` int(10) DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_user',  'sex')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD `sex` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_user',  'add_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD `add_time` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_user',  'update_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD `update_time` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('wg_sales_user',  'subscribe_time')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD `subscribe_time` int(11) DEFAULT '0';");
}
if(!pdo_indexexists('wg_sales_user',  'openid')) {
	pdo_query("ALTER TABLE ".tablename('wg_sales_user')." ADD UNIQUE KEY `openid` (`openid`,`uniacid`);");
}

?>