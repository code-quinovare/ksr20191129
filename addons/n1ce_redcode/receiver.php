<?php
/**
 * 模块订阅器
 *
 * @author 黄河
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class N1ce_redcodeModuleReceiver extends WeModuleReceiver {
	public function receive() {
		global $_W ,$_GPC;
		if($this->message['event'] == 'subscribe'){
			$settings = $this->module['config'];
				
			$openid = $this->message['from'];
			$scan = pdo_fetch('SELECT * FROM ' . tablename('n1ce_red_scanuser') . ' WHERE openid = :openid and uniacid = :uniacid ORDER BY time DESC LIMIT 1',array(':openid'=>$openid,':uniacid'=>$_W['uniacid']));
			
			if($scan['status'] == '1'){
				//防止重复关注限制
				pdo_update('n1ce_red_scanuser',array('status'=>'2'),array('id'=>$scan['id']));
				//发送奖品
				$prizes = pdo_fetchall('select * from ' . tablename('n1ce_red_prize') . ' where prizesum > 0 and uniacid = :uniacid and pici = :pici order by id desc', array(':uniacid' => $_W['uniacid'], ':pici' => $scan['pici']));
				if(!$prizes){
					$notice = str_replace("|#昵称#|",$scan['nickname'],$settings['islater']);
					$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
					$this->sendText($openid,$tempstr);die();
				}
				foreach ($prizes as $key => $val) {
					$arr[$val['id']] = $val['prizeodds'];
				}
				$pid = $this->get_rand($arr);
				$sends = pdo_fetch('select * from ' . tablename('n1ce_red_prize') . ' where id = :id', array(':id' => $pid));
				$updatas = array(
					'prizesum' => $sends['prizesum'] - 1,
				);
				
				
				$insert = array(
					'uniacid' => $_W['uniacid'],
					'openid' => $openid,
					'nickname' => $scan['nickname'],
					'pici' => $scan['pici'],
					'name' => $sends['name'],
					'time' => TIMESTAMP,
					'code' => $scan['code'],
				);
				if($sends['type'] == '1'){
					
					$money = rand($sends['min_money'], $sends['max_money']);
					$this->sendText($openid,"红包发送中，请稍后！");
					if($settings['affiliate'] == 2){
						$action = $this->sendSubRedPacket($openid, $money);
					}else{
						$action = $this->sendRedPacket($openid, $money);
					}
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					$insert['money'] = $money;
					if($action === true){
						//替换粉丝标志换成昵称
						
						pdo_insert('n1ce_red_user', $insert);
						$notice = str_replace("|#昵称#|",$scan['nickname'],$settings['sendred']);
						$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
						$this->sendText($openid,$tempstr);die();
					}else{
						
						$insert['status'] = '2';
						pdo_insert('n1ce_red_user', $insert);
						$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
						$this->sendText($settings['mopenid'],$actions);
						$notice = str_replace("|#昵称#|",$scan['nickname'],$settings['sendbad']);
						$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
						$this->sendText($openid,$tempstr);die();
					}
					
				}
				if($sends['type'] == '2'){
					$res = $this->sendWxCard($openid,$sends['cardid']);
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					if($res){
						pdo_insert('n1ce_red_user', $insert);
						$notice = str_replace("|#昵称#|",$scan['nickname'],$settings['sendcard']);
						$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
						$this->sendText($openid,$tempstr);die();
					}
				}
				if($sends['type'] == '3'){
					pdo_insert('n1ce_red_user', $insert);
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					$prizeurl = htmlspecialchars_decode(str_replace('&quot;','&#039;',$sends['url']),ENT_QUOTES);
					$text = "<a href='" . $prizeurl . "'>请点击领取礼品！</a>";
					$this->sendText($openid,$text);die();
				}
				if($sends['type'] == '4'){
					pdo_insert('n1ce_red_user', $insert);
					load()->model('mc');
					$uid = mc_openid2uid($openid);
					$res = mc_credit_update($uid, 'credit1', $sends['credit'], array(0, '系统积分'.$sends['credit'].'积分'));
					if($res){
						pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
						$tempstr=str_replace("|#昵称#|",$scan['nickname'],$settings['sendcredit']);
						$credit = $sends['credit'];
						$tempstrs = str_replace("|#积分#|",$credit,$tempstr);
						$notice = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstrs),ENT_QUOTES);
						$this->sendText($openid,$notice);die();
					}
				}
				if($sends['type'] == '5'){
					pdo_insert('n1ce_red_user', $insert);
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					$notice = str_replace("|#昵称#|",$scan['nickname'],$sends['txt']);
					$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
					$this->sendText($openid,$tempstr);die();
				}
				if($sends['type'] == '6'){
					$money = rand($sends['min_money'], $sends['max_money']);
					$insert['money'] = $money;
						if($money){
							if($settings['affiliate'] == 2){
								$action = $this->sendSubRedPacket($openid, $money);
							}else{
								$action = $this->sendRedPacket($openid, $money);
							}
							pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
							if($action === true){
								//替换粉丝标志换成昵称
								
								pdo_insert('n1ce_red_user', $insert);
								$notice = str_replace("|#昵称#|",$scan['nickname'],$settings['sendred']);
								$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
								$this->sendText($openid,$tempstr);
								if($sends['cardid']){
									$this->sendWxCard($openid,$sends['cardid']);
								}
								$this->sendText($openid,$sends['txt']);die();
							}else{
								$insert['status'] = '2';
								pdo_insert('n1ce_red_user', $insert);
								$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
								$this->sendText($settings['mopenid'],$actions);
								$notice = str_replace("|#昵称#|",$scan['nickname'],$settings['sendbad']);
								$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
								$this->sendText($openid,$tempstr);die();
							}
						}
				}
				if($sends['type'] == '7'){
					
					$money = rand($sends['min_money'], $sends['max_money']);
					$insert['money'] = $money;
					$action = $this->sendRedgroupPacket($openid, $money,$sends['total_num']);
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					if($action === true){
						//替换粉丝标志换成昵称
						
						pdo_insert('n1ce_red_user', $insert);
						$notice = str_replace("|#昵称#|",$scan['nickname'],$settings['sendred']);
						$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
						$this->sendText($openid,$tempstr);die();
					}else{
						$insert['status'] = '2';
						pdo_insert('n1ce_red_user', $insert);
						$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
						$this->sendText($settings['mopenid'],$actions);
						$notice = str_replace("|#昵称#|",$scan['nickname'],$settings['sendbad']);
						$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
						$this->sendText($openid,$tempstr);die();
					}
					
				}
			}
			
			
		}
	}
	private function sendText($openid,$txt){
		global $_W;
		$acid=pdo_fetchcolumn("SELECT acid FROM ".tablename('account')." WHERE uniacid=:uniacid ",array(':uniacid'=>$_W['uniacid']));
		$acc = WeAccount::create($acid);
		$data = $acc->sendCustomNotice(array('touser'=>$openid,'msgtype'=>'text','text'=>array('content'=>urlencode($txt))));
		return $data;
	}
	private function sendRedPacket($openid,$money){
		global $_W,$_GPC;
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
		load()->func('communication');
		$pars = array();
		$cfg = $this->module['config'];
		$pars['nonce_str'] = random(32);
		if(!empty($cfg['scene_id'])){
	      $pars['scene_id'] = $cfg['scene_id'];
	    }
		$pars['mch_billno'] = $cfg['pay_mchid'] . date('YmdHis') . rand( 100, 999 );
		$pars['mch_id'] = $cfg['pay_mchid'];
		$pars['wxappid'] = $cfg['appid'];
		$pars['send_name'] = $cfg['send_name'];
		$pars['re_openid'] = $openid;
		$pars['total_amount'] = $money;
		$pars['total_num'] = 1;
		$pars['wishing'] = $cfg['wishing'];
		$pars['client_ip'] = $_W['clientip'];
		$pars['act_name'] = $cfg['act_name'];
		$pars['remark'] = $cfg['remark'];
		ksort($pars, SORT_STRING);
		$string1 = '';
		foreach($pars as $k => $v) {
			$string1 .= "{$k}={$v}&";
		}
		$string1 .= "key={$cfg['pay_signkey']}";
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
		$extras = array();
		if($cfg['rootca']){
			$extras['CURLOPT_CAINFO'] = IA_ROOT .'/attachment/n1ce_redcode/cert_2/' . $_W['uniacid'] . '/' . $cfg['rootca'];
		}
		
		$extras['CURLOPT_SSLCERT'] = IA_ROOT .'/attachment/n1ce_redcode/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_cert'];
		$extras['CURLOPT_SSLKEY'] = IA_ROOT .'/attachment/n1ce_redcode/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_key'];
		$procResult = false;
		$resp = ihttp_request($url, $xml, $extras);
		if(is_error($resp)) {
			$setting = $this->module['config'];
			$setting['api']['error'] = $resp['message'];
			$this->saveSettings($setting);
			$procResult = $resp['message'];
		} else {
			$xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
			$dom = new DOMDocument();
			if($dom->loadXML($xml)) {
				$xpath = new DOMXPath($dom);
				$code = $xpath->evaluate('string(//xml/return_code)');
				$ret = $xpath->evaluate('string(//xml/result_code)');
				if(strtolower($code) == 'success' && strtolower($ret) == 'success') {
					$procResult = true;
					$setting = $this->module['config'];
					$setting['api']['error'] = '';
					$this->saveSettings($setting);
				} else {
					$error = $xpath->evaluate('string(//xml/err_code_des)');
					$setting = $this->module['config'];
					$setting['api']['error'] = $error;
					$this->saveSettings($setting);
					$procResult = $error;
				}
			} else {
				$procResult = 'error response';
			}
		}
		return $procResult;
	}
	//裂变红包
	private function sendRedgroupPacket($openid,$money,$total_num){
		global $_W,$_GPC;
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack';
		load()->func('communication');
		$pars = array();
		$cfg = $this->module['config'];
		$pars['nonce_str'] = random(32);
		$pars['mch_billno'] = $cfg['pay_mchid'] . date('YmdHis') . rand( 100, 999 );
		$pars['mch_id'] = $cfg['pay_mchid'];
		$pars['wxappid'] = $cfg['appid'];
		if(!empty($cfg['scene_id'])){
	      $pars['scene_id'] = $cfg['scene_id'];
	    }
		$pars['send_name'] = $cfg['send_name'];
		$pars['re_openid'] = $openid;
		$pars['total_amount'] = $money;
		$pars['total_num'] = $total_num;
		$pars['amt_type'] = 'ALL_RAND';
		$pars['wishing'] = $cfg['wishing'];
		$pars['act_name'] = $cfg['act_name'];
		$pars['remark'] = $cfg['remark'];
		ksort($pars, SORT_STRING);
		$string1 = '';
		foreach($pars as $k => $v) {
			$string1 .= "{$k}={$v}&";
		}
		$string1 .= "key={$cfg['pay_signkey']}";
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
		$extras = array();
		if($cfg['rootca']){
			$extras['CURLOPT_CAINFO'] = IA_ROOT .'/attachment/n1ce_redcode/cert_2/' . $_W['uniacid'] . '/' . $cfg['rootca'];
		}
		$extras['CURLOPT_SSLCERT'] = IA_ROOT .'/attachment/n1ce_redcode/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_cert'];
		$extras['CURLOPT_SSLKEY'] = IA_ROOT .'/attachment/n1ce_redcode/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_key'];
		$procResult = false;
		$resp = ihttp_request($url, $xml, $extras);
		if(is_error($resp)) {
			$setting = $this->module['config'];
			$setting['api']['error'] = $resp['message'];
			$this->saveSettings($setting);
			$procResult = $resp['message'];
		} else {
			$xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
			$dom = new DOMDocument();
			if($dom->loadXML($xml)) {
				$xpath = new DOMXPath($dom);
				$code = $xpath->evaluate('string(//xml/return_code)');
				$ret = $xpath->evaluate('string(//xml/result_code)');
				if(strtolower($code) == 'success' && strtolower($ret) == 'success') {
					$procResult = true;
					$setting = $this->module['config'];
					$setting['api']['error'] = '';
					$this->saveSettings($setting);
				} else {
					$error = $xpath->evaluate('string(//xml/err_code_des)');
					$setting = $this->module['config'];
					$setting['api']['error'] = $error;
					$this->saveSettings($setting);
					$procResult = $error;
				}
			} else {
				$procResult = 'error response';
			}
		}
		return $procResult;
	}
	private function sendWxCard($from_user, $cardid,$code = '') {
		load()->classs('weixin.account');
		load()->func('communication');
		$access_token = WeAccount::token();
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
	
		$now = time();
		$nonce_str = $this->createNonceStr(8);
		$data = array(
				'api_ticket'=>$this->getApiTicket($access_token),
				'nonce_str'=>$nonce_str,
				'timestamp'=>$now,
				'code'=>$code,
				'card_id'=>$cardid,
				'openid'=>$from_user,
		);
		ksort($data);
		$buff = "";
		foreach ($data as $v) {
			$buff .= $v;
		}
		$sign = sha1($buff);
		$card_ext = array('code'=>$code,'openid'=>$from_user,'signature'=>$sign);
		$post = '{"touser":"' . $from_user . '","msgtype":"wxcard","wxcard":{"card_id":"' . $cardid . '","card_ext":"'.json_encode($card_ext).'"}}';
		load()->func('communication');
		$res = ihttp_post($url, $post);
		$res = json_decode($res['content'],true);
		if ($res['errcode'] == 0) return true;
		return $res['errmsg'];
	}
	
	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
			$str.= substr($chars, mt_rand(0, strlen($chars) - 1) , 1);
		}
		return $str;
	}
	
	private function getApiTicket($access_token){
		global $_W, $_GPC;
		$w = $_W['uniacid'];
		$cookiename = "wx{$w}a{$w}pi{$w}ti{$w}ck{$w}et";
		$apiticket = $_COOKIE[$cookiename];
		if (empty($apiticket)){
			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$access_token}&type=wx_card";
			load()->func('communication');
			$res = ihttp_get($url);
			$res = json_decode($res['content'],true);
			if (!empty($res['ticket'])){
				setcookie($cookiename,$res['ticket'],time()+$res['expires_in']);
				$apiticket = $res['ticket'];
			}else{
				message('获取api_ticket失败：'.$res['errmsg']);
			}
		}
		return $apiticket;
	}
	function get_rand($proArr)
    {
        $result = '';
        $proSum = array_sum($proArr);
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset($proArr);
        return $result;
    }
	/**
	by 黄河 
	QQ：541535641
	**/
	public function getOtherSettings($name){
		global $_W;
		$sql = 'SELECT `settings` FROM ' . tablename('uni_account_modules') . ' WHERE `uniacid` = :uniacid AND `module` = :module';
		$settings = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':module' => $name));
		$settings = iunserializer($settings);
		return $settings;
	}
	/**
	* 服务商红包
	* by：黄河  QQ：541535641
	**/
	private function sendSubRedPacket($openid,$money){
		global $_W,$_GPC;
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
		load()->func('communication');
		$pars = array();
		$cfg = $this->getOtherSettings('n1ce_redcode_plugin_affiliate');
		$pars['nonce_str'] = random(32);
		if(!empty($cfg['scene_id'])){
	      $pars['scene_id'] = $cfg['scene_id'];
	    }
		$pars['mch_billno'] = $cfg['mch_id'] . date('YmdHis') . rand( 100, 999 );
		$pars['mch_id'] = $cfg['mch_id'];
		$pars['sub_mch_id'] = $cfg['sub_mch_id'];
		$pars['wxappid'] = $cfg['wxappid'];
		$pars['msgappid'] = $cfg['msgappid'];
		$pars['send_name'] = $cfg['send_name'];
		$pars['re_openid'] = $openid;
		$pars['total_amount'] = $money;
		$pars['total_num'] = 1;
		$pars['wishing'] = $cfg['wishing'];
		$pars['client_ip'] = $_W['clientip'];
		$pars['act_name'] = $cfg['act_name'];
		$pars['remark'] = $cfg['remark'];
		if($cfg['consume_mch_id'] == 2){
			$pars['consume_mch_id'] = $cfg['mch_id'];
		}
		ksort($pars, SORT_STRING);
		$string1 = '';
		foreach($pars as $k => $v) {
			$string1 .= "{$k}={$v}&";
		}
		$string1 .= "key={$cfg['pay_signkey']}";
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
		$extras = array();
		if($cfg['rootca']){
			$extras['CURLOPT_CAINFO'] = IA_ROOT .'/attachment/n1ce_affiliate/cert_2/' . $_W['uniacid'] . '/' . $cfg['rootca'];
		}
		
		$extras['CURLOPT_SSLCERT'] = IA_ROOT .'/attachment/n1ce_affiliate/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_cert'];
		$extras['CURLOPT_SSLKEY'] = IA_ROOT .'/attachment/n1ce_affiliate/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_key'];
		$procResult = false;
		$resp = ihttp_request($url, $xml, $extras);
		if(is_error($resp)) {
			$setting = $this->module['config'];
			$setting['api']['error'] = $resp['message'];
			$this->saveSettings($setting);
			$procResult = $resp['message'];
		} else {
			$xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
			$dom = new DOMDocument();
			if($dom->loadXML($xml)) {
				$xpath = new DOMXPath($dom);
				$code = $xpath->evaluate('string(//xml/return_code)');
				$ret = $xpath->evaluate('string(//xml/result_code)');
				if(strtolower($code) == 'success' && strtolower($ret) == 'success') {
					$procResult = true;
					$setting = $this->module['config'];
					$setting['api']['error'] = '';
					$this->saveSettings($setting);
				} else {
					$error = $xpath->evaluate('string(//xml/err_code_des)');
					$setting = $this->module['config'];
					$setting['api']['error'] = $error;
					$this->saveSettings($setting);
					$procResult = $error;
				}
			} else {
				$procResult = 'error response';
			}
		}
		return $procResult;
	}
}