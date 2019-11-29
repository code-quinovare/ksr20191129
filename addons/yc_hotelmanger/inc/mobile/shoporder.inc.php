<?php



/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

global $_GPC;

global $_W;



if (!$this->is_weixin()) {

    message('请在微信中打开');

}



   load()->model("mc"); 
    $uid= mc_openid2uid($this->openid);
     if(!$uid){
        $uid=$_W['fans']['uid'];
    }   
    $userjf= pdo_fetch('SELECT uid,credit3 FROM ' . tablename($this->members) . ' WHERE uniacid = ' . $this->_weid . ' and uid= '.$uid);
    $levelt=pdo_fetchall('SELECT levelname,ordercount,discount FROM ' . tablename($this->mlevel) . ' WHERE uniacid = ' . $this->_weid .' ORDER BY ordercount DESC'); 
    $zk='';
    foreach ($levelt as $key => $level) {
        if($level['ordercount']>$userjf['credit3']){
            continue;
        }else{
            $zk= $level['discount'];
            break;
        }
    } 
$zk=$zk==0?1:$zk;
if ($_GPC['op'] == 'buy') {

    $goodsid = intval($_GPC['id']);

    $num = intval($_GPC['order_num']);

    $ordersn = build_order_no();

    $code = '';

    $info = '';

    $sql = 'SELECT * FROM ' . tablename($this->shop) . 'WHERE id=' . $goodsid;

    $good = pdo_fetch($sql);

    if (empty($good)) {

        $info = "商品不存在，请联系商家！";

        message($info, '', 'error');

    }

    if ($good) {

        $fee = floatval($good['goods_xprice'] * $num * $zk);

        if ($fee <= 0) {

            $info = '支付错误, 金额小于0';

            message($info, '', 'error');

        }

    } elseif ($good['num'] == 0) {

        $info = "此商品已经售完，请联系商家！";

        message($info, '', 'error');

    }

    include $this->template('shoporderinfo');

    exit();

//    exit(json_encode(array('code'=> $code,'info'=>$info)));

}

if ($_GPC['op'] == 'rpay') {
    
    $ordersn = $_GPC['ordersn'];

    $goods_name = $_GPC['goods_name'];

    $orderlist = pdo_fetch('SELECT * FROM ' . tablename($this->shoporder) . 'WHERE  uniacid =' . $this->_weid . ' and openid =\'' . $this->openid . '\' and ordersn =' . $ordersn);
 
    
    if ($orderlist['order_status'] > 0) {

        message('订单已付款!', '', 'error');

        return;

    } else {

        $params['tid'] = $orderlist['ordersn'];

        $params['user'] = $_W['fans']['from_user'];

        $params['fee'] = floatval($orderlist['fee'] * $zk);

        $params['title'] = $goods_name;

        $params['ordersn'] = $orderlist['ordersn'];

        $params['virtual'] = true;

        include $this->template('shoppay');

    }

}

if ($_GPC['op'] == 'pay') {

    $goodsid = intval($_GPC['id']);

    $num = intval($_GPC['order_num']);

    $code = '';

    $info = '';

    $sql = 'SELECT * FROM ' . tablename($this->shop) . 'WHERE id=' . $goodsid;

    $good = pdo_fetch($sql);

    if (empty($good)) {

        $code = -1;

        $info = "商品不存在，请联系商家！";

        message($info, '', 'error');

    }

    if ($good) {

        $ordersn = $_GPC['ordersn'];

        $orderlist = pdo_fetch('SELECT * FROM ' . tablename($this->shoporder) . 'WHERE  uniacid =' . $this->_weid . ' and openid =\'' . $this->openid . '\' and ordersn =' . $ordersn);

        if ($orderlist['order_status'] > 0) {

            return;

        } else {

//                echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 

            $fee = floatval($good['goods_xprice'] * $num * $zk);

            if ($fee <= 0) {

                $info = '支付错误, 金额小于0';

                message($info, '', 'error');

            }

//            $fee = 0.01;

            $data = array('uniacid' => $this->_weid, 'openid' => $this->openid, 'ordersn' => $_GPC['ordersn'], 'goodsid' => $goodsid, 'fee' => $fee, 'order_num' => $num, 'order_time' => time(), 'order_status' => $_GPC['order_status'], 'pay_time' => '', 'username' => $_GPC['username'], 'userphone' => $_GPC['userphone'], 'useraddress' => $_GPC['useraddress']);

            $orderre = pdo_insert($this->shoporder, $data);

            $params['tid'] = $data['ordersn'];

            $params['user'] = $_W['fans']['from_user'];

            $params['fee'] = $fee;

            $params['title'] = $good['goods_name'];

            $params['ordersn'] = $data['ordersn'];

            $params['virtual'] = true;

            include $this->template('shoppay');

        }

    }

}

if ($_GPC['op'] == 'detail') {

    $id=$_GPC['id'];

    $orderinfosq = 'SELECT o.*,b.* FROM ' . tablename($this->shoporder) . ' o LEFT JOIN ' . tablename($this->shop) . ' b ON  o.goodsid = b.id and b.id=:id ';

    $orderdetail = pdo_fetch($orderinfosq, array(':id' => $id));

    include $this->template('shoporderdetail');

}

if ($_GPC['op'] == 'list') {



    $ordersqls = 'SELECT o.*,b.* FROM ' . tablename($this->shoporder) . ' o LEFT JOIN ' . tablename($this->shop) . ' b ON  o.goodsid = b.id and o.uniacid = :uniacid AND o.openid =:openid ';

    $orders = pdo_fetchall($ordersqls, array(':uniacid' => $this->_weid, ':openid' => $this->openid));



    include $this->template('shoporderlist');

}



function build_order_no() {

    return date("Ymd") . substr(implode(NULL, array_map("ord", str_split(substr(uniqid(), 7, 13), 1))), 0, 8);

}

