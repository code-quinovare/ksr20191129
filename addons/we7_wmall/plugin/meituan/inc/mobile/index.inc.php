<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
pload()->classs('product');
$product = new product(1);
$result = $product->queryListByEdishCodes(625, 59);
p($result);
exit();
$result = $product->queryListByEPoiId(0, 20, 59);
p($result);
exit();
$description = get_config_text('eleme:description');
include itemplate('index');
?>