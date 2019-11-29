<?php 
$sql="CREATE TABLE IF NOT EXISTS `ims_n1ce_message_fans` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL DEFAULT '0',
  `openid` varchar(64) NOT NULL DEFAULT '0',
  `time` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_n1ce_red_blacklog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `openid` varchar(200) NOT NULL DEFAULT 'openid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_n1ce_red_borrowlog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `salt` varchar(200) NOT NULL DEFAULT 'abcd',
  `check_sign` varchar(200) NOT NULL DEFAULT 'abc',
  PRIMARY KEY (`id`),
  UNIQUE KEY `check_sign` (`check_sign`),
  UNIQUE KEY `salt` (`salt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_n1ce_red_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `code` varchar(64) NOT NULL DEFAULT '1',
  `pici` int(10) NOT NULL DEFAULT '0',
  `time` varchar(16) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `iscqr` tinyint(4) NOT NULL DEFAULT '1',
  `salt` varchar(32) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  KEY `code_2` (`code`),
  KEY `code_3` (`code`),
  KEY `code_4` (`code`),
  KEY `code_5` (`code`),
  KEY `code_6` (`code`),
  KEY `code_7` (`code`),
  KEY `code_8` (`code`),
  KEY `code_9` (`code`),
  KEY `code_10` (`code`),
  KEY `code_11` (`code`),
  KEY `code_12` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_n1ce_red_creditcode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `creditcode` varchar(64) NOT NULL DEFAULT '1',
  `pici` int(10) NOT NULL DEFAULT '0',
  `time` varchar(16) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_n1ce_red_msgid` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `msgid` varchar(64) NOT NULL DEFAULT '0',
  `time` varchar(16) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_n1ce_red_pic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `bgimg` varchar(64) NOT NULL DEFAULT '0',
  `parama` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_n1ce_red_pici` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `pici` int(10) NOT NULL DEFAULT '0',
  `codenum` varchar(64) NOT NULL DEFAULT '0',
  `time` varchar(16) NOT NULL DEFAULT '1',
  `time_limit` int(1) NOT NULL DEFAULT '0',
  `starttime` int(10) DEFAULT '0',
  `endtime` int(10) DEFAULT '0',
  `miss_start` varchar(200) DEFAULT NULL,
  `miss_end` varchar(200) DEFAULT NULL,
  `codeinfo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_n1ce_red_prize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT '0',
  `pici` int(10) NOT NULL DEFAULT '0',
  `prizeodds` int(10) NOT NULL DEFAULT '0',
  `prizesum` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `min_money` varchar(16) DEFAULT '',
  `max_money` varchar(16) DEFAULT '',
  `cardid` varchar(100) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `txt` varchar(255) DEFAULT '',
  `total_num` int(10) unsigned NOT NULL DEFAULT '0',
  `prizenum` tinyint(4) NOT NULL DEFAULT '0',
  `credit` int(10) NOT NULL DEFAULT '0',
  `time` varchar(32) NOT NULL DEFAULT '1',
  `name` varchar(100) DEFAULT '',
  `youzan_credit` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_n1ce_red_scanuser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `openid` varchar(64) NOT NULL DEFAULT '1',
  `nickname` varchar(64) NOT NULL DEFAULT '1',
  `code` varchar(64) DEFAULT '',
  `pici` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `time` varchar(16) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_n1ce_red_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `openid` varchar(64) NOT NULL DEFAULT '1',
  `bopenid` varchar(64) NOT NULL DEFAULT '1',
  `nickname` varchar(64) NOT NULL DEFAULT '1',
  `name` varchar(100) DEFAULT '',
  `code` varchar(64) DEFAULT '',
  `money` varchar(16) NOT NULL DEFAULT '0',
  `time` varchar(16) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `salt` varchar(32) DEFAULT '',
  `pici` int(10) NOT NULL DEFAULT '0',
  `parama` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_n1ce_red_userinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `openid` varchar(64) NOT NULL DEFAULT '1',
  `realname` varchar(64) NOT NULL DEFAULT '0',
  `tell` varchar(32) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `openid` (`openid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
pdo_run($sql);
if(!pdo_fieldexists("ims_n1ce_message_fans", "id")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_message_fans")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("ims_n1ce_message_fans", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_message_fans")." ADD   `uniacid` int(10) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_message_fans", "openid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_message_fans")." ADD   `openid` varchar(64) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_message_fans", "time")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_message_fans")." ADD   `time` int(10) DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_blacklog", "id")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_blacklog")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("ims_n1ce_red_blacklog", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_blacklog")." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_blacklog", "openid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_blacklog")." ADD   `openid` varchar(200) NOT NULL DEFAULT 'openid';");
}
if(!pdo_fieldexists("ims_n1ce_red_borrowlog", "id")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_borrowlog")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("ims_n1ce_red_borrowlog", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_borrowlog")." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_borrowlog", "salt")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_borrowlog")." ADD   `salt` varchar(200) NOT NULL DEFAULT 'abcd';");
}
if(!pdo_fieldexists("ims_n1ce_red_borrowlog", "check_sign")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_borrowlog")." ADD   `check_sign` varchar(200) NOT NULL DEFAULT 'abc';");
}
if(!pdo_fieldexists("ims_n1ce_red_borrowlog", "check_sign")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_borrowlog")." ADD   UNIQUE KEY `check_sign` (`check_sign`);");
}
if(!pdo_fieldexists("ims_n1ce_red_borrowlog", "salt")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_borrowlog")." ADD   UNIQUE KEY `salt` (`salt`);");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "id")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "code")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   `code` varchar(64) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "pici")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   `pici` int(10) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "time")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   `time` varchar(16) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "status")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "iscqr")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   `iscqr` tinyint(4) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "salt")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   `salt` varchar(32) DEFAULT '';");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "code")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   KEY `code` (`code`);");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "code_2")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   KEY `code_2` (`code`);");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "code_3")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   KEY `code_3` (`code`);");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "code_4")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   KEY `code_4` (`code`);");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "code_5")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   KEY `code_5` (`code`);");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "code_6")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   KEY `code_6` (`code`);");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "code_7")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   KEY `code_7` (`code`);");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "code_8")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   KEY `code_8` (`code`);");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "code_9")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   KEY `code_9` (`code`);");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "code_10")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   KEY `code_10` (`code`);");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "code_11")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   KEY `code_11` (`code`);");
}
if(!pdo_fieldexists("ims_n1ce_red_code", "code_12")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_code")." ADD   KEY `code_12` (`code`);");
}
if(!pdo_fieldexists("ims_n1ce_red_creditcode", "id")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_creditcode")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("ims_n1ce_red_creditcode", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_creditcode")." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_creditcode", "creditcode")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_creditcode")." ADD   `creditcode` varchar(64) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_creditcode", "pici")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_creditcode")." ADD   `pici` int(10) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_creditcode", "time")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_creditcode")." ADD   `time` varchar(16) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_creditcode", "status")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_creditcode")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_msgid", "id")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_msgid")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("ims_n1ce_red_msgid", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_msgid")." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_msgid", "msgid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_msgid")." ADD   `msgid` varchar(64) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_msgid", "time")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_msgid")." ADD   `time` varchar(16) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_pic", "id")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_pic")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("ims_n1ce_red_pic", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_pic")." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_pic", "bgimg")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_pic")." ADD   `bgimg` varchar(64) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_pic", "parama")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_pic")." ADD   `parama` varchar(1000) DEFAULT NULL;");
}
if(!pdo_fieldexists("ims_n1ce_red_pici", "id")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_pici")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("ims_n1ce_red_pici", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_pici")." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_pici", "pici")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_pici")." ADD   `pici` int(10) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_pici", "codenum")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_pici")." ADD   `codenum` varchar(64) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_pici", "time")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_pici")." ADD   `time` varchar(16) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_pici", "time_limit")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_pici")." ADD   `time_limit` int(1) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_pici", "starttime")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_pici")." ADD   `starttime` int(10) DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_pici", "endtime")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_pici")." ADD   `endtime` int(10) DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_pici", "miss_start")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_pici")." ADD   `miss_start` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("ims_n1ce_red_pici", "miss_end")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_pici")." ADD   `miss_end` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("ims_n1ce_red_pici", "codeinfo")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_pici")." ADD   `codeinfo` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "id")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `uniacid` int(10) DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "pici")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `pici` int(10) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "prizeodds")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `prizeodds` int(10) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "prizesum")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `prizesum` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "type")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `type` tinyint(4) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "min_money")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `min_money` varchar(16) DEFAULT '';");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "max_money")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `max_money` varchar(16) DEFAULT '';");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "cardid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `cardid` varchar(100) DEFAULT '';");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "url")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `url` varchar(255) DEFAULT '';");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "txt")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `txt` varchar(255) DEFAULT '';");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "total_num")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `total_num` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "prizenum")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `prizenum` tinyint(4) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "credit")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `credit` int(10) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "time")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `time` varchar(32) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "name")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `name` varchar(100) DEFAULT '';");
}
if(!pdo_fieldexists("ims_n1ce_red_prize", "youzan_credit")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_prize")." ADD   `youzan_credit` int(10) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_scanuser", "id")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_scanuser")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("ims_n1ce_red_scanuser", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_scanuser")." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_scanuser", "openid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_scanuser")." ADD   `openid` varchar(64) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_scanuser", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_scanuser")." ADD   `nickname` varchar(64) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_scanuser", "code")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_scanuser")." ADD   `code` varchar(64) DEFAULT '';");
}
if(!pdo_fieldexists("ims_n1ce_red_scanuser", "pici")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_scanuser")." ADD   `pici` int(10) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_scanuser", "status")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_scanuser")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_scanuser", "time")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_scanuser")." ADD   `time` varchar(16) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_user", "id")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_user")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("ims_n1ce_red_user", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_user")." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_user", "openid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_user")." ADD   `openid` varchar(64) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_user", "bopenid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_user")." ADD   `bopenid` varchar(64) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_user", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_user")." ADD   `nickname` varchar(64) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_user", "name")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_user")." ADD   `name` varchar(100) DEFAULT '';");
}
if(!pdo_fieldexists("ims_n1ce_red_user", "code")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_user")." ADD   `code` varchar(64) DEFAULT '';");
}
if(!pdo_fieldexists("ims_n1ce_red_user", "money")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_user")." ADD   `money` varchar(16) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_user", "time")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_user")." ADD   `time` varchar(16) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_user", "status")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_user")." ADD   `status` tinyint(4) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_user", "salt")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_user")." ADD   `salt` varchar(32) DEFAULT '';");
}
if(!pdo_fieldexists("ims_n1ce_red_user", "pici")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_user")." ADD   `pici` int(10) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_user", "parama")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_user")." ADD   `parama` varchar(1000) DEFAULT NULL;");
}
if(!pdo_fieldexists("ims_n1ce_red_userinfo", "id")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_userinfo")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("ims_n1ce_red_userinfo", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_userinfo")." ADD   `uniacid` int(10) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_userinfo", "openid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_userinfo")." ADD   `openid` varchar(64) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists("ims_n1ce_red_userinfo", "realname")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_userinfo")." ADD   `realname` varchar(64) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_userinfo", "tell")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_userinfo")." ADD   `tell` varchar(32) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists("ims_n1ce_red_userinfo", "openid")) {
 pdo_query("ALTER TABLE ".tablename("ims_n1ce_red_userinfo")." ADD   KEY `openid` (`openid`);");
}

 ?>