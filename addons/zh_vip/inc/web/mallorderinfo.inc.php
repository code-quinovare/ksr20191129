<?php
global $_GPC, $_W;
$storeid=$_COOKIE["storeid"]; 
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getMainMenu2();
$item=pdo_get('zhvip_shoporder',array('id'=>$_GPC['id']));
$goods=pdo_getall('zhvip_ordergoods',array('order_id'=>$_GPC['id']));
if(checksubmit('submit')){
	$data['state']=$_GPC['state'];
	$data['money']=$_GPC['money'];
	$data['preferential']=$_GPC['preferential'];
	if($_GPC['dn_state']=="2"){
		$data['pay_time']=time();
	}
	$res=pdo_update('zhvip_shoporder',$data,array('id'=>$_GPC['id']));
	if($res){
             message('编辑成功！', $this->createWebUrl('mallorderinfo',array('id'=>$_GPC['id'])), 'success');
        }else{
             message('编辑失败！','','error');
        }
}
if(checksubmit('submit3')){
    $res=pdo_update('zhvip_shoporder',array('state'=>3,'kd_num'=>$_GPC['reply'],'kd_name'=>$_GPC['reply2']),array('id'=>$_GPC['fh_id']));
    if($res){
        message('发货成功！', $this->createWebUrl('mallorderinfo',array('id'=>$_GPC['fh_id'])), 'success');
    }else{
        message('发货失败！','','error');
    }
}
if($_GPC['op']=='tg'){
        $id=$_GPC['id'];
        include_once IA_ROOT . '/addons/zh_vip/cert/WxPay.Api.php';
        load()->model('account');
        load()->func('communication');
        $WxPayApi = new WxPayApi();
        $input = new WxPayRefund();
       //$path_cert = IA_ROOT . '/addons/zh_vip/cert/apiclient_cert.pem';
       // $path_key = IA_ROOT . '/addons/zh_vip/cert/apiclient_key.pem';
        $path_cert = IA_ROOT . "/addons/zh_vip/cert/".'apiclient_cert_' . $_W['uniacid'] . '.pem';
        $path_key = IA_ROOT . "/addons/zh_vip/cert/".'apiclient_key_' . $_W['uniacid'] . '.pem';
        $account_info = $_W['account'];
        $refund_order =pdo_get('zhvip_shoporder',array('id'=>$id));  
        $res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
        $appid=$res['appid'];
        $key=$res['wxkey'];
        $mchid=$res['mchid']; 
        //print_r( $refund_order );die;
        $out_trade_no=$refund_order['code'];//商户订单号
        $fee = $refund_order['money'] * 100;
            //$refundid = $refund_order['transid'];
            //$refundid='4200000022201710178579320894';
            $input->SetAppid($appid);
            $input->SetMch_id($mchid);
            $input->SetOp_user_id($mchid);
            $input->SetRefund_fee($fee);
            $input->SetTotal_fee($fee);
           // $input->SetTransaction_id($refundid);
            $input->SetOut_refund_no($refund_order['order_num']);
            $input->SetOut_trade_no($out_trade_no);
            $result = $WxPayApi->refund($input, 6, $path_cert, $path_key, $key);   
     //var_dump($result);die;
            if ($result['result_code'] == 'SUCCESS') {//退款成功
           pdo_update('zhvip_shoporder',array('state'=>7),array('id'=>$id));
           message('退款成功',$this->createWebUrl('mallorderinfo',array()),'success');
         
    }else{
        message($result['err_code_des'],'','error');
}
}

if($_GPC['op']=='jj'){
    $res=pdo_update('zhvip_shoporder',array('state'=>8),array('id'=>$_GPC['id']));
    if($res){
        message('拒绝退款成功',$this->createWebUrl('mallorderinfo',array()),'success');
    }else{
       message('拒绝退款失败','','error');
    }
}
include $this->template('web/mallorderinfo');