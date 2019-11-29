<?php
define('IN_MOBILE', true);
require '../../../../framework/bootstrap.inc.php';
global $_W, $_GPC;
$input = file_get_contents('php://input');
$isxml = true;
if (!empty($input) && empty($_GET['out_trade_no'])) {
	$obj = isimplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
	$res = $data = json_decode(json_encode($obj), true);
	if (empty($data)) {
		$result = array(
			'return_code' => 'FAIL',
			'return_msg' => ''
		);
		echo array2xml($result);
		exit;
	}
	if ($data['result_code'] != 'SUCCESS' || $data['return_code'] != 'SUCCESS') {
		$result = array(
			'return_code' => 'FAIL',
			'return_msg' => empty($data['return_msg']) ? $data['err_code_des'] : $data['return_msg']
		);
		echo array2xml($result);
		exit;
	}
	$get = $data;
} else {
	$isxml = false;
	$get = $_GET;
}
load()->web('common');
load()->model('mc');
load()->func('communication');
$_W['uniacid'] = $_W['weid'] = intval($get['attach']);
$_W['uniaccount'] = $_W['account'] = uni_fetch($_W['uniacid']);
$_W['acid'] = $_W['uniaccount']['acid'];
$paySetting = uni_setting($_W['uniacid'], array('payment'));
if($res['return_code'] == 'SUCCESS' && $res['result_code'] == 'SUCCESS' ){
	$logno = trim($res['out_trade_no']);
	if (empty($logno)) {
		exit;
	}
$str=$_W['siteroot'];
	$n = 0;
for($i = 1;$i <= 3;$i++) {
    $n = strpos($str, '/', $n);
    $i != 3 && $n++;
}
$url=substr($str,0,$n);
	$order=pdo_get('wpdc_order',array('sh_ordernum'=>$logno));
	$store=pdo_get('wpdc_store',array('id'=>$order['seller_id']));
	$sms=pdo_get('wpdc_sms',array('store_id'=>$order['seller_id']));
	$system=pdo_get('wpdc_system',array('uniacid'=>$order['uniacid']));
	$user=pdo_get('wpdc_user',array('id'=>$order['user_id']));


	$ydorder=pdo_get('wpdc_ydorder',array('ydcode'=>$logno));
	$ydstore=pdo_get('wpdc_store',array('id'=>$ydorder['store_id']));
	$yduser=pdo_get('wpdc_user',array('id'=>$ydorder['user_id']));
	$ydsms=pdo_get('wpdc_sms',array('store_id'=>$ydorder['store_id']));


	$dmorder=pdo_get('wpdc_dmorder',array('code'=>$logno));
	$dmuser=pdo_get('wpdc_user',array('id'=>$dmorder['user_id']));
	$dmstore=pdo_get('wpdc_store',array('id'=>$dmorder['store_id']));

	$czorder=pdo_get('wpdc_czorder',array('code'=>$logno));

	if($czorder and $czorder['state']==1){

		pdo_update('wpdc_czorder',array('state'=>2),array('id'=>$czorder['id']));

		file_get_contents("".$url."/app/index.php?i=".$czorder['uniacid']."&c=entry&a=wxapp&do=Recharge&m=zh_dianc&user_id=".$czorder['user_id']."&money=".$czorder['money']);//改变订单状态

	}

	if($dmorder and $dmorder['state']==1){//当面付

	file_get_contents("".$url."/app/index.php?i=".$dmorder['uniacid']."&c=entry&a=wxapp&do=Dmpay&m=zh_dianc&order_id=".$dmorder['id']);//改变订单状态

	file_get_contents("".$url."/app/index.php?i=".$dmorder['uniacid']."&c=entry&a=wxapp&do=message2&m=zh_dianc&openid=".$dmuser['openid']."&form_id=".$dmorder['form_id']."&name=".$dmstore['name']."&money=".$dmorder['money']);//模板消息

	file_get_contents("".$url."/app/index.php?i=".$dmorder['uniacid']."&c=entry&a=wxapp&do=Dmprint&m=zh_dianc&order_id=".$dmorder['id']);//打印

	file_get_contents("".$url."/app/index.php?i=".$dmorder['uniacid']."&c=entry&a=wxapp&do=Dmprint2&m=zh_dianc&order_id=".$dmorder['id']);//打印

	}

	// $url="".$_W['siteroot']."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=PayOrder&m=zh_dianc&order_id=".$order['id'];

	if($ydorder and $ydorder['state']==0){//预约

		pdo_update('wpdc_ydorder',array('state'=>1),array('ydcode'=>$logno));

		if($system['is_email']==1){

			file_get_contents("".$url."/app/index.php?i=".$ydorder['uniacid']."&c=entry&a=wxapp&do=Email&m=zh_dianc&store_id=".$ydorder['store_id']."&type='预约'");//邮件

		}

		if($ydsms['is_yysms']==1){

			file_get_contents("".$url."/app/index.php?i=".$ydorder['uniacid']."&c=entry&a=wxapp&do=sms2&m=zh_dianc&store_id=".$ydorder['store_id']);//短信

		}

		

		file_get_contents("".$url."/app/index.php?i=".$ydorder['uniacid']."&c=entry&a=wxapp&do=message3&m=zh_dianc&xz_date=".$ydorder['xz_date']."&openid=".$yduser['openid']."&form_id=".$ydorder['form_id']."&store_name=".$ydstore['name']."&yjdd_date=".$ydorder['yjdd_date']."&link_name=".$ydorder['link_name']."&link_tel=".$ydorder['link_tel']."&jc_num=".$ydorder['jc_num']."&remark=".$ydorder['remark']);//模板消息



		file_get_contents("".$url."/app/index.php?i=".$ydorder['uniacid']."&c=entry&a=wxapp&do=moban2&m=zh_dianc&id=".$ydorder['id']);//模板消息

	}













	if($order['type']==1 && $order['state']==1){//外卖

	file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=PayOrder&m=zh_dianc&order_id=".$order['id']);//改变订单状态

	if($sms['is_wmsms']==1){

		file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=sms&m=zh_dianc&store_id=".$order['seller_id']);//短信

	}

	if($system['is_email']==1){

		file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=Email&m=zh_dianc&store_id=".$order['seller_id']."&type='外卖'");//邮件

	}

	file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=message&m=zh_dianc&id=".$order['id']."&openid=".$user['openid']."&form_id=".$order['form_id']);//模板消息









	file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=moban&m=zh_dianc&id=".$order['id']);//模板消息











	file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=print&m=zh_dianc&order_id=".$order['id']);//打印小票

	file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=print2&m=zh_dianc&order_id=".$order['id']);//打印小票

	if($store['ps_mode']==1){

	file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=dada&m=zh_dianc&order_id=".$order['id']."&area=".$order['area']."&lat=".$order['lat']."&lng=".$order['lng']);//达达	

	}

	

	}elseif($order['type']==2 && $order['dn_state']==1){

		file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=PayOrder&m=zh_dianc&order_id=".$order['id']);

		if($sms['is_dnsms']==1){

			file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=sms3&m=zh_dianc&store_id=".$order['seller_id']);

		}

		

		if($system['is_email']==1){

			file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=Email&m=zh_dianc&store_id=".$order['seller_id']."&type='店内'");

		}

		file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=message&m=zh_dianc&id=".$order['id']."&openid=".$user['openid']."&form_id=".$order['form_id']);//模板消息

		file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=dnprint&m=zh_dianc&order_id=".$order['id']);//打印小票

		file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=dnprint2&m=zh_dianc&order_id=".$order['id']);//打印小票

		if($store['ps_mode']==1){

			file_get_contents("".$url."/app/index.php?i=".$order['uniacid']."&c=entry&a=wxapp&do=dada&m=zh_dianc&order_id=".$order['id']."&area=".$order['area']."&lat=".$order['lat']."&lng=".$order['lng']);//达达	

			}

	}

	

	







































































			$result = array(

				'return_code' => 'SUCCESS',

				'return_msg' => 'OK'

			);

			echo array2xml($result);

			exit;

	

	}else{

		//订单已经处理过了

		$result = array(

			'return_code' => 'SUCCESS',

			'return_msg' => 'OK'

		);

		echo array2xml($result);

		exit;

	}

