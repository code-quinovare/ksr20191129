<?php
global $_GPC,$_W;
$action = $_GPC['action']?$_GPC['action']:'';
if(empty($action)) {
    $pagesize = 12;
    $pageindex = max(1, intval($_GPC['page']));
    $openid = $_GPC['openid'];
    if ($openid) {
        $where = " AND openid = '{$openid}'";
    }
    $total = count(pdo_fetchall(' SELECT * FROM ' . tablename('tj_jiudian_order') . 'WHERE pay_status=1 AND rooms=1 AND acid=' . $_W['account']['acid'] . $where . " ORDER BY createtime DESC"));
    $pager = pagination($total, $pageindex, $pagesize);
    $p = ($pageindex - 1) * $pagesize;
    $res = pdo_fetchall(' SELECT * FROM ' . tablename('tj_jiudian_order') . 'WHERE  acid=' . $_W['account']['acid'] . $where ." ORDER BY createtime DESC LIMIT " . $p . "," . $pagesize);
}
if($action=='day') {
    $pagesize = 12;
    $pageindex = max(1, intval($_GPC['page']));
    $openid = $_GPC['openid'];
   
    $total = count(pdo_fetchall(' SELECT * FROM ' . tablename('tj_jiudian_order') . 'WHERE pay_status=1 AND rooms=1 AND acid=' . $_W['account']['acid'] . $where . " ORDER BY createtime DESC"));
    $pager = pagination($total, $pageindex, $pagesize);
    $p = ($pageindex - 1) * $pagesize;
    $res = pdo_fetchall(' SELECT * FROM ' . tablename('tj_jiudian_order') . 'WHERE pay_status=1 AND rooms=1 AND acid=' . $_W['account']['acid'] . $where ." ORDER BY createtime DESC LIMIT " . $p . "," . $pagesize);
}
if($action=='zhong'){
    $pagesize = 12;
    $pageindex = max(1, intval($_GPC['page']));
    $total = count(pdo_fetchall(' SELECT * FROM ' . tablename('tj_jiudian_order') . 'WHERE pay_status=1 AND rooms=2 AND acid=' . $_W['account']['acid'] . " ORDER BY createtime DESC"));
    $pager = pagination($total, $pageindex, $pagesize);
    $p = ($pageindex - 1) * $pagesize;
    $res = pdo_fetchall(' SELECT * FROM ' . tablename('tj_jiudian_order') . 'WHERE pay_status=1 AND rooms=2 AND acid=' . $_W['account']['acid'] . " ORDER BY createtime DESC LIMIT " . $p . "," . $pagesize);

}

if($action=='night'){
    $pagesize = 12;
    $pageindex = max(1, intval($_GPC['page']));
    $total = count(pdo_fetchall(' SELECT * FROM ' . tablename('tj_jiudian_order') . 'WHERE pay_status=1 AND rooms=3 AND acid=' . $_W['account']['acid'] . " ORDER BY createtime DESC"));
    $pager = pagination($total, $pageindex, $pagesize);
    $p = ($pageindex - 1) * $pagesize;
    $res = pdo_fetchall(' SELECT * FROM ' . tablename('tj_jiudian_order') . 'WHERE pay_status=1 AND rooms=3 AND acid=' . $_W['account']['acid'] . " ORDER BY createtime DESC LIMIT " . $p . "," . $pagesize);

}

if($action=='shouyin'){
    $pagesize = 12;
    $pageindex = max(1, intval($_GPC['page']));
    $total = count(pdo_fetchall(' SELECT * FROM ' . tablename('tj_jiudian_shouyin') . 'WHERE pay_status=1 AND acid=' . $_W['account']['acid'] . " ORDER BY time DESC"));
    $pager = pagination($total, $pageindex, $pagesize);
    $p = ($pageindex - 1) * $pagesize;
    $res = pdo_fetchall(' SELECT * FROM ' . tablename('tj_jiudian_shouyin') . 'WHERE pay_status=1 AND acid=' . $_W['account']['acid'] . " ORDER BY time DESC LIMIT " . $p . "," . $pagesize);

}

if($action=='tuikuan'){
    $pagesize = 12;
    $pageindex = max(1, intval($_GPC['page']));
    $total = count(pdo_fetchall(' SELECT * FROM ' . tablename('tj_jiudian_order') . 'WHERE pay_status=-1 OR pay_status=-2 AND acid=' . $_W['account']['acid'] . " ORDER BY createtime DESC"));
    $pager = pagination($total, $pageindex, $pagesize);
    $p = ($pageindex - 1) * $pagesize;
    $res = pdo_fetchall(' SELECT * FROM ' . tablename('tj_jiudian_order') . 'WHERE pay_status=-1 OR pay_status=-2 AND acid=' . $_W['account']['acid'] . " ORDER BY createtime DESC LIMIT " . $p . "," . $pagesize);

}

if($action == 'tk1'){
    $sql = "SELECT * FROM ".tablename('tj_jiudian_order')." WHERE `id` = {$_GET['id']}";
    $order = pdo_fetch($sql);

    $money = $order['money'];

    $openid = $order['openid'];

    require dirname(__DIR__)."/app/Order.class.php";

    $obj = new Order($money,$openid);
    $result = $obj->top_up();

    if($result == true){
        pdo_update("tj_jiudian_order",array('pay_status' => -1),array('id' => $_GET['id']));
        message('退款成功',$this->createWebUrl('Order',array('action' => 'tuikuan')),'success');
    }else{
        message($result['err_code_des'],$this->createWebUrl('Order',array('action' => 'tuikuan')),'error');
    }
}



if($action=='delete'){
    $res=pdo_delete('tj_jiudian_order',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功', $this->createWebUrl('Order'));
    }
}

if($action=='del_shouyin'){
    $res=pdo_delete('tj_jiudian_shouyin',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功', $this->createWebUrl('Order',array('action'=>'shouyin')));
    }
}

if($action=='hexiao'){
    $data = array(
        'use_status' => 1,
    );
    $res=pdo_update('tj_jiudian_order',$data,array('id'=>$_GPC['id']));
    if($res){
        message('核销成功', $this->createWebUrl('Order',array('action'=>'')));
    }
}

include $this->template('web/order');