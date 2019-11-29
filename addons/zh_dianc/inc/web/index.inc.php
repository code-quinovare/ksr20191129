<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
if($_GPC['id']){
setcookie("storeid",$_GPC['id']);
$cur_store = $this->getStoreById($_GPC['id']);	
$storeid=$_GPC['id'];

}else{
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);	
}

if($_GPC['time']){
	$time=strtotime($_GPC['time']['start']);
    $mttime=strtotime($_GPC['time']['end']);
}else{
	$time=strtotime(date("Y-m-d"));
	$mttime=strtotime(date("Y-m-d",strtotime("+1 day")));
}


$time2=date("Y-m-d",strtotime("-1 day"));
$time2="'%$time2%'";
$time3=strtotime(date("Y-m-d",strtotime("-6 day")));


// $sql = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time."  and seller_id=".$storeid;
// $res = pdo_fetchall($sql);
// $sql2 = "select * from " . tablename("wpdc_ydorder")." WHERE created_time LIKE ".$time."  and store_id=".$storeid;
// $res2 = pdo_fetchall($sql2);
// $sql3 = "select * from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time."  and store_id=".$storeid."  and state=2";
// $res3 = pdo_fetchall($sql3);
// $ordernum=(count($res)+count($res2)+count($res3));//今日订单统计

$sql = "select * from " . tablename("wpdc_order")." WHERE time2>=".$time."  and time2<".$mttime."  and state in (4,6,9)  and type=1  and uniacid=".$_W['uniacid']."  and seller_id=".$storeid;
$wmres = pdo_fetchall($sql);

$sql2 = "select * from " . tablename("wpdc_order")." WHERE time2>=".$time."  and time2<".$mttime."  and dn_state=2  and type=2  and uniacid=".$_W['uniacid']."  and seller_id=".$storeid;
$dnres = pdo_fetchall($sql2);
$sql3 = "select * from " . tablename("wpdc_ydorder")." WHERE time2>=".$time."  and time2<".$mttime."  and state in (2,7)  and uniacid=".$_W['uniacid']."  and store_id=".$storeid;
$ydres = pdo_fetchall($sql3);
$sql4 = "select * from " . tablename("wpdc_dmorder")." WHERE time2>=".$time."  and time2<".$mttime."  and state=2  and uniacid=".$_W['uniacid']."  and store_id=".$storeid;
$dmres= pdo_fetchall($sql4);
$ordernum=(count($wmres)+count($dnres)+count($ydres)+count($dmres));



//今日门店总销售额
$wm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time2>=".$time."  and time2<".$mttime."  and state not in (5,1,8)  and type=1  and pay_time !=''  and uniacid=".$_W['uniacid']."  and seller_id=".$storeid;
$wm = pdo_fetch($wm);//今天的外卖销售额
$dn ="select sum(money) as total from " . tablename("wpdc_order")." WHERE time2>=".$time."  and time2<".$mttime."  and dn_state not in (3,1)  and type=2  and pay_time !=''  and uniacid=".$_W['uniacid']."  and seller_id=".$storeid;
$dn = pdo_fetch($dn);//今天的店内销售额
$yd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE time2>=".$time."  and time2<".$mttime."  and state not in (0,6)  and uniacid=".$_W['uniacid']."  and store_id=".$storeid;
$yd = pdo_fetch($yd);//今天的预定销售额
$dmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time2>=".$time."  and time2<".$mttime."  and state=2  and uniacid=".$_W['uniacid']."  and store_id=".$storeid;
$dmf = pdo_fetch($dmf);//今天的当面付销售额
$total = $wm['total']+$dn['total']+$yd['total']+$dmf['total'];//今天的销售额
//今日门店总销售额




//今日门店微信总销售额
$wxwm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time2>=".$time."  and time2<".$mttime."  and state not in (5,1,8)  and type=1  and is_yue=2  and pay_time !=''  and uniacid=".$_W['uniacid']." and seller_id=".$storeid;
$wxwm = pdo_fetch($wxwm);//今天的外卖销售额
$wxdn ="select sum(money) as total from " . tablename("wpdc_order")." WHERE time2>=".$time."  and time2<".$mttime."  and dn_state not in (3,1)  and type=2  and is_yue=2  and  pay_time !=''  and uniacid=".$_W['uniacid']." and seller_id=".$storeid;
$wxdn = pdo_fetch($wxdn);//今天的店内销售额
$wxyd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE time2>=".$time."  and time2<".$mttime."  and state not in (0,6)  and is_yue=2  and  uniacid=".$_W['uniacid']."  and store_id=".$storeid;
$wxyd = pdo_fetch($wxyd);//今天的预定销售额
$wxdmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time2>=".$time."  and time2<".$mttime."  and state=2  and  is_yue=2  and uniacid=".$_W['uniacid']." and store_id=".$storeid;
$wxdmf = pdo_fetch($wxdmf);//今天的当面付销售额
$wxtotal = $wxwm['total']+$wxdn['total']+$wxyd['total']+$wxdmf['total'];//今天的销售额
//今日门店微信总销售额


//今日门店余额总销售额
$yuewm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time2>=".$time."  and time2<".$mttime."  and state not in (5,1,8)  and type=1  and is_yue=1  and pay_time !=''  and uniacid=".$_W['uniacid']." and seller_id=".$storeid;
$yuewm = pdo_fetch($yuewm);//今天的外卖销售额
$yuedn ="select sum(money) as total from " . tablename("wpdc_order")." WHERE time2>=".$time."  and time2<".$mttime."  and dn_state not in (3,1)  and type=2  and is_yue=1  and  pay_time !=''  and uniacid=".$_W['uniacid']." and seller_id=".$storeid;
$yuedn = pdo_fetch($yuedn);//今天的店内销售额
$yueyd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE time2>=".$time."  and time2<".$mttime."  and state not in (0,6)  and is_yue=1  and  uniacid=".$_W['uniacid']." and store_id=".$storeid;
$yueyd = pdo_fetch($yueyd);//今天的预定销售额
$yuedmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time2>=".$time."  and time2<".$mttime."  and state=2  and  is_yue=1  and uniacid=".$_W['uniacid']." and store_id=".$storeid;
$yuedmf = pdo_fetch($yuedmf);//今天的当面付销售额
$yuetotal = $yuewm['total']+$yuedn['total']+$yueyd['total']+$yuedmf['total'];//今天的销售额
//今日门店余额总销售额


//今日门店积分总销售额
$jfwm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time2>=".$time."  and time2<".$mttime."  and state not in (5,1,8)  and type=1  and is_yue=3  and pay_time !=''  and uniacid=".$_W['uniacid']." and seller_id=".$storeid;
$jfwm = pdo_fetch($jfwm);//今天的外卖销售额
$jfdn ="select sum(money) as total from " . tablename("wpdc_order")." WHERE time2>=".$time."  and time2<".$mttime."  and dn_state not in (3,1)  and type=2  and is_yue=3  and  pay_time !=''  and uniacid=".$_W['uniacid']." and seller_id=".$storeid;
$jfdn = pdo_fetch($jfdn);//今天的店内销售额
$jfyd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE time2>=".$time."  and time2<".$mttime."  and state not in (0,6)  and is_yue=3  and  uniacid=".$_W['uniacid']." and store_id=".$storeid;
$jfyd = pdo_fetch($jfyd);//今天的预定销售额
$jfdmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time2>=".$time."  and time2<".$mttime."  and state=2  and  is_yue=3  and uniacid=".$_W['uniacid']." and store_id=".$storeid;
$jfdmf = pdo_fetch($jfdmf);//今天的当面付销售额
$jftotal = $jfwm['total']+$jfdn['total']+$jfyd['total']+$jfdmf['total'];//今天的销售额
//今日门店积分总销售额


























$ztwm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time2."  and seller_id=".$storeid."  and state not in (5,1,8)  and type=1 and pay_time !=''";
$ztwm = pdo_fetch($ztwm);//昨天的外卖销售额
$ztdn = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time2."  and seller_id=".$storeid."  and dn_state not in (3,1)  and type=2  and pay_time !=''";
$ztdn = pdo_fetch($ztdn);//昨天的店内销售额
$ztyd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE created_time LIKE ".$time2."  and store_id=".$storeid."  and state not in (0,6)";
$ztyd = pdo_fetch($ztyd);//昨天的预定销售额
$ztdmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time2."  and state=2  and store_id=".$storeid;
$ztdmf = pdo_fetch($ztdmf);//昨天的当面付销售额
$total2 = $ztwm['total']+$ztdn['total']+$ztyd['total']+$ztdmf['total'];//昨天的销售额


$wxztwm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time2."  and seller_id=".$storeid."  and is_yue=2  and  state not in (5,1,8)  and type=1  and pay_time !=''";
$wxztwm = pdo_fetch($wxztwm);//昨天的微信外卖销售额
$wxztdn = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time2."  and seller_id=".$storeid."  and is_yue=2  and dn_state not in (3,1)  and type=2  and pay_time !=''";
$wxztdn = pdo_fetch($wxztdn);//昨天的微信店内销售额
$wxztyd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE created_time LIKE ".$time2."  and is_yue=2  and store_id=".$storeid."  and state not in (0,6)";
$wxztyd = pdo_fetch($wxztyd);//昨天的微信预定销售额
$wxztdmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time2."  and is_yue=2  and state=2  and store_id=".$storeid;
$wxztdmf = pdo_fetch($wxztdmf);//昨天的微信当面付销售额
$wxtotal2 = $wxztwm['total']+$wxztdn['total']+$wxztyd['total']+$wxztdmf['total'];//昨天的微信销售额



$yueztwm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time2."  and is_yue=1  and seller_id=".$storeid."  and state not in (5,1,8)  and type=1  and pay_time !=''";
$yueztwm = pdo_fetch($yueztwm);//昨天的余额外卖销售额
$yueztdn = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time2." and is_yue=1 and seller_id=".$storeid."  and dn_state not in (3,1)  and type=2  and pay_time !=''";
$yueztdn = pdo_fetch($yueztdn);//昨天的余额店内销售额
$yueztyd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE created_time LIKE ".$time2." and is_yue=1 and store_id=".$storeid."  and state not in (0,6)";
$yueztyd = pdo_fetch($yueztyd);//昨天的余额预定销售额
$yueztdmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time2." and is_yue=1 and state=2  and store_id=".$storeid;
$yueztdmf = pdo_fetch($yueztdmf);//昨天的余额当面付销售额
$yuetotal2 = $yueztwm['total']+$yueztdn['total']+$yueztyd['total']+$yueztdmf['total'];//昨天的余额销售额



$jfztwm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time2." and is_yue=3 and seller_id=".$storeid."  and state not in (5,1,8)  and type=1  and pay_time !=''";
$jfztwm = pdo_fetch($jfztwm);//昨天的积分外卖销售额
$jfztdn = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time2." and is_yue=3 and seller_id=".$storeid."  and dn_state not in (3,1)  and type=2  and pay_time !=''";
$jfztdn = pdo_fetch($jfztdn);//昨天的积分店内销售额
$jfztyd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE created_time LIKE ".$time2." and is_yue=3 and store_id=".$storeid."  and state not in (0,6)";
$jfztyd = pdo_fetch($jfztyd);//昨天的积分预定销售额
$jfztdmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time2." and is_yue=3 and state=2  and store_id=".$storeid;
$jfztdmf = pdo_fetch($jfztdmf);//昨天的积分当面付销售额
$jftotal2 = $jfztwm['total']+$jfztdn['total']+$jfztyd['total']+$jfztdmf['total'];//昨天的积分销售额















$qtwm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time2 >= ".$time3."  and seller_id=".$storeid."  and state not in (5,1,8)  and type=1  and pay_time !=''";
$qtwm = pdo_fetch($qtwm);//七天的外卖销售额
$qtdn = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time2 >= ".$time3."  and seller_id=".$storeid."  and dn_state not in (3,1)  and type=2  and pay_time !=''";
$qtdn = pdo_fetch($qtdn);//七天的店内销售额
$qtyd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE created_time >= ".$time3."  and store_id=".$storeid."  and state not in (0,6)";
$qtyd = pdo_fetch($qtyd);//七天的预定销售额
$qtdmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time2 >= ".$time3."  and state=2  and store_id=".$storeid;
$qtdmf = pdo_fetch($qtdmf);//七天的当面付销售额
$total3 = $qtwm['total']+$qtdn['total']+$qtyd['total']+$qtdmf['total'];//七天的销售额


$wxqtwm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time2 >= ".$time3."  and seller_id=".$storeid." and is_yue=2 and state not in (5,1,8)  and type=1  and pay_time !=''";
$wxqtwm = pdo_fetch($wxqtwm);//七天的微信外卖销售额
$wxqtdn = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time2 >= ".$time3."  and seller_id=".$storeid." and is_yue=2 and dn_state not in (3,1)  and type=2  and pay_time !=''";
$wxqtdn = pdo_fetch($wxqtdn);//七天的微信店内销售额
$wxqtyd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE created_time >= ".$time3." and is_yue=2 and store_id=".$storeid."  and state not in (0,6)";
$wxqtyd = pdo_fetch($wxqtyd);//七天的微信预定销售额
$wxqtdmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time2 >= ".$time3." and is_yue=2 and state=2  and store_id=".$storeid;
$wxqtdmf = pdo_fetch($wxqtdmf);//七天的微信当面付销售额
$wxtotal3 = $wxqtwm['total']+$wxqtdn['total']+$wxqtyd['total']+$wxqtdmf['total'];//七天的微信销售额



$yueqtwm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time2 >= ".$time3."  and seller_id=".$storeid." and is_yue=1 and state not in (5,1,8)  and type=1  and pay_time !=''";
$yueqtwm = pdo_fetch($yueqtwm);//七天的余额外卖销售额
$yueqtdn = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time2 >= ".$time3."  and seller_id=".$storeid." and is_yue=1 and dn_state not in (3,1)  and type=2  and pay_time !=''";
$yueqtdn = pdo_fetch($yueqtdn);//七天的余额店内销售额
$yueqtyd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE created_time >= ".$time3."  and store_id=".$storeid." and is_yue=1 and state not in (0,6)";
$yueqtyd = pdo_fetch($yueqtyd);//七天的余额预定销售额
$yueqtdmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time2 >= ".$time3."  and state=2 and is_yue=1 and store_id=".$storeid;
$yueqtdmf = pdo_fetch($yueqtdmf);//七天的余额当面付销售额
$yuetotal3 = $yueqtwm['total']+$yueqtdn['total']+$yueqtyd['total']+$yueqtdmf['total'];//七天的余额销售额



$jfqtwm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time2 >= ".$time3."  and seller_id=".$storeid." and is_yue=3 and state not in (5,1,8)  and type=1  and pay_time !=''";
$jfqtwm = pdo_fetch($jfqtwm);//七天的积分外卖销售额
$jfqtdn = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time2 >= ".$time3."  and seller_id=".$storeid." and is_yue=3 and dn_state not in (3,1)  and type=2  and pay_time !=''";
$jfqtdn = pdo_fetch($jfqtdn);//七天的积分店内销售额
$jfqtyd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE created_time >= ".$time3."  and store_id=".$storeid." and is_yue=3 and state not in (0,6)";
$jfqtyd = pdo_fetch($jfqtyd);//七天的积分预定销售额
$jfqtdmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time2 >= ".$time3."  and state=2 and is_yue=3 and store_id=".$storeid;
$jfqtdmf = pdo_fetch($jfqtdmf);//七天的积分当面付销售额
$jftotal3 = $jfqtwm['total']+$jfqtdn['total']+$jfqtyd['total']+$jfqtdmf['total'];//七天的积分销售额








$sql6=count(pdo_getall('wpdc_order',array('seller_id'=>$storeid,'state'=>2)));//待接单的外卖
$sql7=count(pdo_getall('wpdc_order',array('seller_id'=>$storeid,'state'=>3)));//待送达的外卖
$sql8=count(pdo_getall('wpdc_order',array('seller_id'=>$storeid,'dn_state'=>1)));//待付款的店内
$sql9=count(pdo_getall('wpdc_ydorder',array('store_id'=>$storeid,'state'=>1)));//待审核的预约订单
$sql10=count(pdo_getall('wpdc_order',array('seller_id'=>$storeid,'state'=>4)));//完成的外卖订单

$sql11=count(pdo_getall('wpdc_table',array('store_id'=>$storeid,'status !='=>0)));//已开台的桌子
$sql12=count(pdo_getall('wpdc_table',array('store_id'=>$storeid,'status'=>0)));//未开台的桌子

$sql13=count(pdo_getall('wpdc_dishes',array('store_id'=>$storeid,'dishes_type'=>array(1,3),'is_shelves'=>1 )));//外卖已上架的菜品
$sql14=count(pdo_getall('wpdc_dishes',array('store_id'=>$storeid,'dishes_type'=>array(1,3),'is_shelves'=>2 )));//外卖未上架的菜品


$sql15=count(pdo_getall('wpdc_dishes',array('store_id'=>$storeid,'dishes_type'=>array(2,3),'is_shelves'=>1 )));//店内已上架的菜品
$sql16=count(pdo_getall('wpdc_dishes',array('store_id'=>$storeid,'dishes_type'=>array(2,3),'is_shelves'=>2 )));//店内未上架的菜品

include $this->template('web/index');