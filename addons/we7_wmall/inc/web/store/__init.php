<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
if (0 < $_W['we7_wmall']['sid']) 
{
	$_W['we7_wmall']['store'] = store_fetch($_W['we7_wmall']['sid']);
}
?>