<?php



/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

 
global $_W;

global $_GPC;
 

$type = ((trim($_GPC['type']) ? trim($_GPC['type']) : 'credit'));



if ($type == 'credit') {

    $setting = uni_setting();

    $recharge = $setting['recharge'];
 

    if (checksubmit()) {

        $credit = floatval($_GPC['credit']);

        $select = floatval($_GPC['select']);



        if (!$credit && !$select) {

            message('请输入充值金额', referer(), 'error');

        }



        $fee = $credit;



        if (!$fee) {

            $fee = $select;

        }



        $chargerecord = pdo_fetch('SELECT * FROM ' . tablename('mc_credits_recharge') . ' WHERE uniacid = :uniacid AND uid = :uid AND fee = :fee AND type = :type AND status = 0', array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid'], ':fee' => $fee, ':type' => 'credit'));



        if (empty($chargerecord)) {

            $chargerecord = array('uid' => $_W['member']['uid'], 'openid' => $_W['openid'], 'uniacid' => $_W['uniacid'], 'tid' => date('YmdHi') . random(8, 1), 'fee' => $fee, 'type' => 'credit', 'status' => 0, 'createtime' => TIMESTAMP);



            if (!pdo_insert("mc_credits_recharge", $chargerecord)) {

                message('创建充值订单失败，请重试！', url('entry', array('m' => 'recharge', 'do' => 'pay')), 'error');

            }

        }

        $params = array('tid' => $chargerecord['tid'], 'ordersn' => $chargerecord['tid'], 'title' => '会员余额充值', 'fee' => $chargerecord['fee'], 'user' => $_W['member']['uid']);

        $mine = array();



        if (!empty($recharge)) {

            $back = -1;



            foreach ($recharge as $k => $li) {

                if ($li['recharge'] <= $fee) {

                    $back = $k;

                }

            }



            if (!empty($recharge[$back])) {

                $mine = array(

                    array('name' => '充' . $recharge[$back]['recharge'] . '返' . $recharge[$back]['back'], 'value' => '返￥' . $recharge[$back]['back'] . '元')

                );

            }

        }





        $this->pay($params, $mine);

        exit();

    }



    $member = mc_fetch($_W['member']['uid']);

    $name = $member['mobile'];



    if (empty($name)) {

        $name = $member['realname'];

    }

    if (empty($name)) {

        $name = $member['uid'];

    }





    include $this->template('recharge');

    return;

}



$fee = floatval($_GPC['fee']);



$setting = pdo_get('mc_card', array('uniacid' => $_W['uniacid'], 'status' => 1));



if (empty($setting)) {

    message('会员卡未开启,请联系商家', referer(), 'error');

}



if ($type == 'card_nums') {

    if (!$setting['nums_status']) {

        message('会员卡未开启' . $setting['nums_text'] . '充值,请联系商家', referer(), 'error');

    }



    $setting['nums'] = iunserializer($setting['nums']);



    if (empty($setting['nums'][$fee])) {

        message('充值金额错误,请联系商家', referer(), 'error');

    }



    $mine = array(

        array('name' => '充' . $fee . '返' . $setting['nums'][$fee]['num'] . '次', 'value' => '返' . $setting['nums'][$fee]['num'] . '次')

    );

    $tag = $setting['nums'][$fee]['num'];

}



if ($type == 'card_times') {

    if (!$setting['times_status']) {

        message('会员卡未开启' . $setting['times_text'] . '充值,请联系商家', referer(), 'error');

    }



    $setting['times'] = iunserializer($setting['times']);



    if (empty($setting['times'][$fee])) {

        message('充值金额错误,请联系商家', referer(), 'error');

    }

    $member_card = pdo_get('mc_card_members', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']));



    if (TIMESTAMP < $member_card['endtime']) {

        $endtime = $member_card['endtime'] + ($setting['times'][$fee]['time'] * 86400);

    } else {

        $endtime = strtotime($setting['times'][$fee]['time'] . 'days');

    }



    $mine = array(

        array('name' => '充' . $fee . '返' . $setting['times'][$fee]['time'] . '天', 'value' => date('Y-m-d', $endtime) . '到期')

    );

    $tag = $setting['times'][$fee]['time'];

}



$chargerecord = pdo_fetch('SELECT * FROM ' . tablename('mc_credits_recharge') . ' WHERE uniacid = :uniacid AND uid = :uid AND fee = :fee AND type = :type  AND status = 0 AND tag = :tag', array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid'], ':fee' => $fee, ':type' => $type, ':tag' => $tag));



if (empty($chargerecord)) {

    $chargerecord = array('uid' => $_W['member']['uid'], 'openid' => $_W['openid'], 'uniacid' => $_W['uniacid'], 'tid' => date('YmdHi') . random(8, 1), 'fee' => $fee, 'type' => $type, 'tag' => $tag, 'status' => 0, 'createtime' => TIMESTAMP);



    if (!pdo_insert("mc_credits_recharge", $chargerecord)) {

        message('创建充值订单失败，请重试！', url('mc/bond/mycard'), 'error');

    }

}



$types = array('card_nums' => $setting['nums_text'], 'card_times' => $setting['times_text']);

$params = array('tid' => $chargerecord['tid'], 'ordersn' => $chargerecord['tid'], 'title' => '会员卡' . $types[$type] . '充值', 'fee' => $chargerecord['fee'], 'user' => $_W['member']['uid']);

$this->pay($params, $mine);

exit();

