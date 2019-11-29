<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
header('location:' . iurl('deliveryCard/order/list'));
exit();
?>