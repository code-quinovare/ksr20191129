<?php

global $_W,$_GPC;
load()->func('file');
if($_W['role'] !== 'founder'){
	message('权限不足','','error');
}
$severce = "../addons/n1ce_redcode_plugin_affiliate";
$guid = "../addons/n1ce_redcode_plugin_guid";
$key_red = "../addons/n1ce_redcode_plugin_keyword";
if(!file_exists($severce)){
	$severce_url = "http://s.we7.cc/module-4734.html";
	$shtml = '<span class="label label-danger">未安装</span>';
}else{
	$severce_url = "./index.php?c=home&a=welcome&do=ext&m=n1ce_redcode_plugin_affiliate";
}
if(!file_exists($guid)){
	$guid_url = "http://s.we7.cc/module-5451.html";
	$ghtml = '<span class="label label-danger">未安装</span>';
}else{
	$guid_url = "./index.php?c=home&a=welcome&do=ext&m=n1ce_redcode_plugin_guid";
}
if(!file_exists($key_red)){
	$key_red_url = "#";
	$khtml = '<span class="label label-danger">未安装</span>';
}else{
	$key_red_url = "./index.php?c=home&a=welcome&do=ext&m=n1ce_redcode_plugin_keyword";
}
include $this->template('application');