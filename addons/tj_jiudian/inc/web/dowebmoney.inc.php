<?php
global $_GPC,$_W;
$action = $_GPC['action']?$_GPC['action']:'';
if(empty($action)) {
    $pagesize = 12;
    $pageindex = max(1, intval($_GPC['page']));
    $total = count(pdo_fetchall(' SELECT * FROM ' . tablename('tj_jiudian_deposit') . 'WHERE  uniacid=' . $_W['uniacid'] . " ORDER BY id DESC"));
    $pager = pagination($total, $pageindex, $pagesize);
    $p = ($pageindex - 1) * $pagesize;
    $res = pdo_fetchall(' SELECT * FROM ' . tablename('tj_jiudian_deposit') . 'WHERE uniacid=' . $_W['uniacid'] . " AND uid>0 ORDER BY id DESC LIMIT " . $p . "," . $pagesize);
     foreach ($res as &$row) {
        $row['addtime'] = date('Y-m-d H:i', $row['addtime']);
        $member = pdo_fetch(' SELECT uid,nickname,avatar,realname,telephone,mobile FROM ' . tablename('mc_members') . 'WHERE uniacid=' . $_W['uniacid'] . " AND uid = ".$row['uid']);
        $row['realname'] = $member['realname'];
        $row['avatar'] = $member['avatar'];
        $row['tel'] = $member['mobile'];
    }
    /*echo "<pre>";
    print_r($res);*/
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





include $this->template('web/money');
