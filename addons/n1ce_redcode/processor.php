<?php
/**
 * 验证码生成模块模块处理程序
 *
 * @author n1ce   QQ：541535641
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
include 'huanghe_function.php';

class N1ce_redcodeModuleProcessor extends WeModuleProcessor {
	public function respond() {
		global $_W, $_GPC;
		load()->model('mc');
		$settings = $this->module['config'];
		//判断类型扫码还是文本
		//坑爹的扫码事件
		
		if($this->message['msgtype'] == 'event'){
			if($this->message['event'] == 'SCAN' || $this->message['event'] == 'subscribe'){
				$scene_id = $this->message['eventkey'];
				$ticket = $this->message['ticket'];
				$msgid = $ticket;
				$again = pdo_fetch('select * from ' . tablename('n1ce_red_msgid') . ' where uniacid = :uniacid and  msgid = :msgid', array(':msgid' => $msgid, ':uniacid' => $_W['uniacid']));
				if($again){
					return $this->respText('');
				}
			}
			$scene_id = str_replace('qrscene_','',$scene_id);
			
			if(is_numeric($scene_id)){
				$contents = pdo_fetch('select * from ' . tablename('qrcode') . ' where uniacid = :uniacid and  qrcid = :qrcid and ticket = :ticket and redcode = 1', array(':uniacid' => $_W['uniacid'] ,':qrcid' => $scene_id ,':ticket' => $ticket));
				
				$content = $contents['keyword'];
				
				$pici = $contents['pici'];
				
			}else{
				$contents = pdo_fetch('select * from ' . tablename('qrcode') . ' where uniacid = :uniacid and  scene_str = :scene_str and redcode = 1 and ticket = :ticket', array(':uniacid' => $_W['uniacid'] ,':scene_str' => $scene_id ,':ticket' => $ticket));
				$content = $contents['keyword'];
				
				$pici = $contents['pici'];
			}
			
		}elseif($this->message['msgtype'] == 'voice'){
			$content = trim($this->message['recognition']);
			$content = str_replace('！','',$content);
			
			$picires = pdo_fetch('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and  code = :code', array(':code' => $content, ':uniacid' => $_W['uniacid']));
			//获取批次
			$pici = $picires['pici'];
		}else{
			$content = trim($this->message['content']);
			$msgid = $this->message['msgid'];
			$again = pdo_fetch('select * from ' . tablename('n1ce_red_msgid') . ' where uniacid = :uniacid and  msgid = :msgid', array(':msgid' => $msgid, ':uniacid' => $_W['uniacid']));
			if($again){
				return $this->respText('');
			}
			$picires = pdo_fetch('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and  code = :code', array(':code' => $content, ':uniacid' => $_W['uniacid']));
			//获取批次
			$pici = $picires['pici'];
			
		}
		
		$openid = $this->message['from'];
		$settings = $this->module['config'];
		if(empty($openid)){
			return $this->respText("非法用户！");
		}
		
		$timeinfo = pdo_fetch('select * from ' . tablename('n1ce_red_pici') .' where uniacid = :uniacid and pici = :pici',array(':uniacid'=>$_W['uniacid'],':pici'=>$pici));
		if($timeinfo['time_limit'] == '1'){
			if ($timeinfo['starttime'] > time()) {
				return $this->respText($timeinfo['miss_start']);
			}
			if ($timeinfo['endtime'] < time()) {
				return $this->respText($timeinfo['miss_end']);
			}
		}
		//获取昵称，坑爹的mc_fansinfo，用mc_fetch !不能实时获取到新关注的粉丝昵称
		$mc = mc_fetch($openid);
		
		if(empty($mc['nickname']) || empty($mc['avatar']) || empty($mc['resideprovince']) || empty($mc['residecity'])){
			load()->classs( 'account' );
			load()->func( 'communication' );
			$accToken = WeAccount::token();
			$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$accToken}&openid={$openid}&lang=zh_CN";
			$json = ihttp_get($url);
			$userinfo = @json_decode($json['content'],true);
			if($userinfo['nickname']) $mc['nickname'] = $userinfo['nickname'];
			if($userinfo['headimgurl']) $mc['avatar'] = $userinfo['headimgurl'];
			if($userinfo['resideprovince']) $mc['resideprovince'] = $userinfo['resideprovince'];
			if($userinfo['residecity']) $mc['residecity'] = $userinfo['residecity'];
			mc_update($openid,array('nickname' => $mc['nickname'] , 'avatar' => $mc['avatar'] , 'resideprovince' => $mc['resideprovince'], 'residecity' => $mc['residecity']));
		}
		if(empty($pici) && empty($_SESSION['content'])){
			$nick = $mc['nickname'];
			$tempstr=str_replace("|#昵称#|",$nick,$settings['wrong']);
			$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
			return $this->respText($tempstr);
		}
		if($settings['userinfo'] == '2'){
			if(empty($mc['realname']) || empty($mc['mobile'])){
				if(!$this->inContext) {
					$reply = '参与活动前请登记你的姓名：';
					$_SESSION['content'] = $content;
					$_SESSION['pici'] = $pici;
					$this->beginContext();
					return $this->respText($reply);
					// 如果是按照规则触发到本模块, 那么先输出提示问题语句, 并启动上下文来锁定会话, 以保证下次回复依然执行到本模块
				} else {
					$contents = $this->message['content']; 
					// 如果当前会话在上下文中, 那么表示当前回复是用户回答提示问题的答案. 
					if(is_numeric($contents)) {
						if(preg_match("/^1[34578]{1}\d{9}$/",$content)){  
							$_SESSION['tel'] = $contents;
							$content = $_SESSION['content'];
							$pici = $_SESSION['pici'];
							$name = $_SESSION['name'];
							$tell = $_SESSION['tel'];
							$this->endContext();
							mc_update($openid,array('realname' => $name , 'mobile' => $tell));
						}else{  
							$reply = '请输入正确的手机号码：';
							return $this->respText($reply);
						}  
						
					} else {
						$_SESSION['name'] = $contents;
						$reply = '参与活动前请登记你的手机号码：';
						return $this->respText($reply);
					}
				}
			}
		}
		//return $this->respText('1不开启限制');
		if($settings['xianzhi'] == '2'){
			$user_total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename('n1ce_red_user'). ' where uniacid = :uniacid and openid = :openid', array(':uniacid' => $_W['uniacid'],':openid' => $openid));
			$limit_num = $settings['getnum'];
			if($user_total >= $limit_num){
				
				$nick = $mc['nickname'];
				$tempstr=str_replace("|#昵称#|",$nick,$settings['isget']);
				$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
				return $this->respText($tempstr);
			}
		}
		// 新增代码限制粉丝每天领取
		if($settings['today_num']){
			$now_time = strtotime(date('Y-m-d', time()));
			$user_today = pdo_fetchcolumn("select count(*) from " .tablename('n1ce_red_user'). " where uniacid = :uniacid and openid = :openid and time >= :time",array(":uniacid" => $_W['uniacid'],":openid" => $openid,":time" => $now_time));
			if($user_today >= $settings['today_num']){
				$nick = $mc['nickname'];
				$tempstr=str_replace("|#昵称#|",$nick,$settings['todayget']);
				$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
				return $this->respText($tempstr);
			}
		}
		// 新增代码结束
		$res = pdo_fetch('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and  code = :code and status = 1', array(':code' => $content, ':uniacid' => $_W['uniacid']));
		
		//概率计算排除数量为0的奖品
		$prizes = pdo_fetchall('select * from' . tablename('n1ce_red_prize') . ' where prizesum > 0 and uniacid = :uniacid and pici = :pici order by id desc', array(':uniacid' => $_W['uniacid'], ':pici' => $pici));
		if(!$prizes){
			$nick = $mc['nickname'];
			$tempstr=str_replace("|#昵称#|",$nick,$settings['islater']);
			$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
			return $this->respText($tempstr);
		}
		if($res){
			//防止微信5s回复
			if(!empty($msgid)){
				pdo_insert('n1ce_red_msgid',array('uniacid' => $_W['uniacid'],'msgid' => $msgid));
			}
			
			foreach ($prizes as $key => $val) {
				$arr[$val['id']] = $val['prizeodds'];
			}
			$pid = $this->get_rand($arr);
			$sends = pdo_fetch('select * from ' . tablename('n1ce_red_prize') . ' where id = :id', array(':id' => $pid));
			
			$insert = array(
					'uniacid' => $_W['uniacid'],
					'openid' => $openid,
					'nickname' => $mc['nickname'],
					'pici' => $pici,
					'time' => TIMESTAMP,
					'code' => $content,
					//'status' => '1',
				);
			$chprize = array(
				'prizesum' => $sends['prizesum'] - 1,
			);
			// 红包奖品
			if($sends['type'] == '1'){
				
				$money = rand($sends['min_money'], $sends['max_money']);
				
				$brrow = $settings['brrow'];
				if($brrow == '2'){
					pdo_update('n1ce_red_code',array('status'=>'2'),array('id'=>$res['id']));
					$insert = array(
						'uniacid' => $_W['uniacid'],
						'openid' => $openid,
						'nickname' => $mc['nickname'],
						'pici' => $pici,
						'code' => $content,
						'name' => $sends['name'],
						'money' => $money,
						'salt' => md5($openid.time()),
						'time' => TIMESTAMP,
						'status' => '3',
					);
					$redurl = $this->createMobileUrl('redurl' , array('salt' => $insert['salt']));
					pdo_update('n1ce_red_prize',$chprize,array('id'=>$pid));
					pdo_insert('n1ce_red_user', $insert);
					$news = array(
						'Title' => '红包消息',
						'Description' => '点击领取',
						'PicUrl' => '',
						'Url' => $redurl,
					);
					
					return $this->respNews($news);
				}else{
					$exits = pdo_update('n1ce_red_code',array('status'=>'2'),array('id'=>$res['id']));
					$this->sendText($openid,"红包发送中，请稍后领取！");
					if($settings['affiliate'] == 2){
						$action = $this->sendSubRedPacket($openid, $money);
					}else{
						$action = $this->sendRedPacket($openid, $money);
					}
					if($res['iscqr'] == '2'){
					 pdo_query('update ' . tablename('qrcode') . ' set redcode = 2 where uniacid = :uniacid and keyword = :keyword', array(':uniacid' => $_W['uniacid'],':keyword' => $content));
					}
					pdo_update('n1ce_red_prize',$chprize,array('id'=>$pid));
					$insert = array(
						'uniacid' => $_W['uniacid'],
						'openid' => $openid,
						'nickname' => $mc['nickname'],
						'pici' => $pici,
						'money' => $money,
						'name' => $sends['name'],
						'code' => $content,
						'time' => TIMESTAMP,
						//'status' => '1',
					);
					if($action === true){
						//替换粉丝标志换成昵称
						
						pdo_insert('n1ce_red_user', $insert);
						$nick = $mc['nickname'];
						$tempstr=str_replace("|#昵称#|",$nick,$settings['sendred']);
						$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
						$this->sendText($openid,$tempstr);
						return $this->respText('');
					}else{
						
						$insert['status'] = '2';
						$result = pdo_insert('n1ce_red_user', $insert);
						if(empty($result)){
							$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
							$this->sendText($settings['mopenid'],$actions);
							$money = $money/100;
							$msg_text = "您好，由于腾讯服务器波动，您的红包发送失败，请您凭借您的口令码:".$content."并截图，联系我们客服领取您的".$money."元红包！";
							return $this->respText($msg_text);
						}else{
							$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
							$this->sendText($settings['mopenid'],$actions);
							$nick = $mc['nickname'];
							$tempstr=str_replace("|#昵称#|",$nick,$settings['sendbad']);
							$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
							$this->sendText($openid,$tempstr);
							return $this->respText('');
						}
					}
				}
			}
			// 红包+积分
			if($sends['type'] == '9'){
				
				$money = rand($sends['min_money'], $sends['max_money']);
				load()->model('mc');
				$uid = mc_openid2uid($openid);
				$creditres = mc_credit_update($uid, 'credit1', $sends['credit'], array(0, '系统积分'.$sends['credit'].'积分'));
				$nick = $mc['nickname'];
				$credit_tempstr=str_replace("|#昵称#|",$nick,$settings['sendcredit']);
				$credit = $sends['credit'];
				$credit_tempstrs = str_replace("|#积分#|",$credit,$credit_tempstr);
				$credit_tempstrs = str_replace("|#用户#|",$openid,$credit_tempstrs);
				$credit_tempstrs = htmlspecialchars_decode(str_replace('&quot;','&#039;',$credit_tempstrs),ENT_QUOTES);
				$brrow = $settings['brrow'];
				if($brrow == '2'){
					pdo_update('n1ce_red_code',array('status'=>'2'),array('id'=>$res['id']));
					$insert = array(
						'uniacid' => $_W['uniacid'],
						'openid' => $openid,
						'nickname' => $mc['nickname'],
						'pici' => $pici,
						'code' => $content,
						'name' => $sends['name']."-积分：".$sends['credit'],
						'money' => $money,
						'salt' => md5($openid.time()),
						'time' => TIMESTAMP,
						'status' => '3',
					);
					$redurl = $this->createMobileUrl('redurl' , array('salt' => $insert['salt']));
					pdo_update('n1ce_red_prize',$chprize,array('id'=>$pid));
					pdo_insert('n1ce_red_user', $insert);
					$news = array(
						'Title' => '红包消息',
						'Description' => '点击领取',
						'PicUrl' => '',
						'Url' => $redurl,
					);
					
					$this->sendText($openid,$credit_tempstrs);
					return $this->respNews($news);
				}else{
					$exits = pdo_update('n1ce_red_code',array('status'=>'2'),array('id'=>$res['id']));
					$this->sendText($openid,"红包发送中，请稍后领取！");
					if($settings['affiliate'] == 2){
						$action = $this->sendSubRedPacket($openid, $money);
					}else{
						$action = $this->sendRedPacket($openid, $money);
					}
					
					if($res['iscqr'] == '2'){
					 pdo_query('update ' . tablename('qrcode') . ' set redcode = 2 where uniacid = :uniacid and keyword = :keyword', array(':uniacid' => $_W['uniacid'],':keyword' => $content));
					}
					pdo_update('n1ce_red_prize',$chprize,array('id'=>$pid));
					$insert = array(
						'uniacid' => $_W['uniacid'],
						'openid' => $openid,
						'nickname' => $mc['nickname'],
						'pici' => $pici,
						'money' => $money,
						'name' => $sends['name']."-积分：".$sends['credit'],
						'code' => $content,
						'time' => TIMESTAMP,
						//'status' => '1',
					);
					if($action === true){
						//替换粉丝标志换成昵称
						
						pdo_insert('n1ce_red_user', $insert);
						$nick = $mc['nickname'];
						$tempstr=str_replace("|#昵称#|",$nick,$settings['sendred']);
						$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
						$this->sendText($openid,$tempstr);
						return $this->respText($credit_tempstrs);
					}else{
						
						$insert['status'] = '2';
						pdo_insert('n1ce_red_user', $insert);
						$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
						$this->sendText($settings['mopenid'],$actions);
						$nick = $mc['nickname'];
						$tempstr=str_replace("|#昵称#|",$nick,$settings['sendbad']);
						$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
						$this->sendText($openid,$tempstr);
						return $this->respText($credit_tempstrs);
					}
				}
			}
			// 微信卡券
			if($sends['type'] == '2'){
				$cardres = $this->sendWxCard($openid,$sends['cardid']);
				pdo_update('n1ce_red_prize',$chprize,array('id'=>$pid));
				if($cardres){
					$exits = pdo_update('n1ce_red_code',array('status'=>'2'),array('id'=>$res['id']));
					if($res['iscqr'] == '2'){
					 pdo_query('update ' . tablename('qrcode') . ' set redcode = 2 where uniacid = :uniacid and keyword = :keyword', array(':uniacid' => $_W['uniacid'],':keyword' => $content));
					}
					$insert['name'] = $sends['name'];
					pdo_insert('n1ce_red_user', $insert);
					$nick = $mc['nickname'];
					$tempstr=str_replace("|#昵称#|",$nick,$settings['sendcard']);
					$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
					return $this->respText($tempstr);
				}
			}
			// 自定义链接
			if($sends['type'] == '3'){
				$exits = pdo_update('n1ce_red_code',array('status'=>'2'),array('id'=>$res['id']));
				if($res['iscqr'] == '2'){
				 pdo_query('update ' . tablename('qrcode') . ' set redcode = 2 where uniacid = :uniacid and keyword = :keyword', array(':uniacid' => $_W['uniacid'],':keyword' => $content));
				}
				pdo_update('n1ce_red_prize',$chprize,array('id'=>$pid));
				$insert['name'] = $sends['name'];
				pdo_insert('n1ce_red_user', $insert);
				return $this->respText("@".$mc['nickname']."恭喜你获得神秘礼品"."\n\n<a href='{$sends['url']}'>点击领取>>></a>");
				//return $this->respText($sends['url']);
			}
			// 微擎积分
			if($sends['type'] == '4'){
				pdo_update('n1ce_red_prize',$chprize,array('id'=>$pid));
				$insert['name'] = $sends['name'];
				pdo_insert('n1ce_red_user', $insert);
				
				load()->model('mc');
				$uid = mc_openid2uid($openid);
				$creditres = mc_credit_update($uid, 'credit1', $sends['credit'], array(0, '系统积分'.$sends['credit'].'积分'));
				if($creditres){
					$exits = pdo_update('n1ce_red_code',array('status'=>'2'),array('id'=>$res['id']));
					if($res['iscqr'] == '2'){
					 pdo_query('update ' . tablename('qrcode') . ' set redcode = 2 where uniacid = :uniacid and keyword = :keyword', array(':uniacid' => $_W['uniacid'],':keyword' => $content));
					}
					$nick = $mc['nickname'];
					$tempstr=str_replace("|#昵称#|",$nick,$settings['sendcredit']);
					$credit = $sends['credit'];
					$tempstrs = str_replace("|#积分#|",$credit,$tempstr);
					$tempstrs = str_replace("|#用户#|",$openid,$tempstrs);
					$tempstrs = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstrs),ENT_QUOTES);
					//$this->sendText($openid,$tempstr);
					return $this->respText($tempstrs);
				}
				//return $this->respText($sends['url']);
			}
			// 有赞积分
			if($sends['type'] == '8'){
				pdo_update('n1ce_red_prize',$chprize,array('id'=>$pid));
				$insert['name'] = $sends['name'];
				pdo_insert('n1ce_red_user', $insert);
				
				$appId = $this->module['config']['yzappId'];
				$appSecret = $this->module['config']['yzappSecret'];
				$response = he_youzan_addcredic($appId,$appSecret,$openid,$sends['youzan_credit']);
				if($response){
					$exits = pdo_update('n1ce_red_code',array('status'=>'2'),array('id'=>$res['id']));
					if($res['iscqr'] == '2'){
					 pdo_query('update ' . tablename('qrcode') . ' set redcode = 2 where uniacid = :uniacid and keyword = :keyword', array(':uniacid' => $_W['uniacid'],':keyword' => $content));
					}
					$nick = $mc['nickname'];
					$tempstr=str_replace("|#昵称#|",$nick,$settings['sendcredit']);
					$credit = $sends['youzan_credit'];
					$tempstrs = str_replace("|#积分#|",$credit,$tempstr);
					$tempstrs = str_replace("|#用户#|",$openid,$tempstrs);
					$tempstrs = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstrs),ENT_QUOTES);
					//$this->sendText($openid,$tempstr);
					return $this->respText($tempstrs);
				}
				//return $this->respText($sends['url']);
			}
			// 文本消息
			if($sends['type'] == '5'){
				$exits = pdo_update('n1ce_red_code',array('status'=>'2'),array('id'=>$res['id']));
				if($res['iscqr'] == '2'){
				 pdo_query('update ' . tablename('qrcode') . ' set redcode = 2 where uniacid = :uniacid and keyword = :keyword', array(':uniacid' => $_W['uniacid'],':keyword' => $content));
				}
				pdo_update('n1ce_red_prize',$chprize,array('id'=>$pid));
				$insert['name'] = $sends['name'];
				pdo_insert('n1ce_red_user', $insert);
				$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$sends['txt']),ENT_QUOTES);
				$this->sendText($openid,$tempstr);
				return $this->respText('');
				//return $this->respText($sends['url']);
			}
			// 混合奖品
			if($sends['type'] == '6'){
				$exits = pdo_update('n1ce_red_code',array('status'=>'2'),array('id'=>$res['id']));
				pdo_update('n1ce_red_prize',$chprize,array('id'=>$pid));
				$insert['name'] = $sends['name'];
				$money = rand($sends['min_money'], $sends['max_money']);
				$insert['money'] = $money;
					if($settings['brrow'] == 2){
						$insert = array(
							'uniacid' => $_W['uniacid'],
							'openid' => $openid,
							'nickname' => $mc['nickname'],
							'pici' => $pici,
							'code' => $content,
							'name' => $sends['name'],
							'money' => $money,
							'salt' => md5($openid.time()),
							'time' => TIMESTAMP,
							'status' => '3',
						);
						$redurl = $this->createMobileUrl('redurl' , array('salt' => $insert['salt']));
						$redurl = $_W['siteroot'] . 'app' . str_replace('./', '/', $redurl);
						pdo_update('n1ce_red_prize',$chprize,array('id'=>$pid));
						pdo_insert('n1ce_red_user', $insert);
						$message = array(
							'touser' => $openid,
							'msgtype' => 'news',
							'news' => array(
								'articles' => array(
									0 => array(
											'title' => urlencode('红包消息'),
											'description' => urlencode('点击领取'),
											'url' => $redurl,
											'picurl' => ''
										),
								),
							)
						);
						$account_api = WeAccount::create();
						$status = $account_api->sendCustomNotice($message);
						if (is_error($status)) {
							load()->func('logging');
							//记录文本日志
							logging_run($status['message']);
						}
						if($sends['cardid']){
							$this->sendWxCard($openid,$sends['cardid']);
						}
						return $this->respText($sends['txt']);
					}else{
						if($settings['affiliate'] == 2){
							$action = $this->sendSubRedPacket($openid, $money);
						}else{
							$action = $this->sendRedPacket($openid, $money);
						}
						if($res['iscqr'] == '2'){
						 pdo_query('update ' . tablename('qrcode') . ' set redcode = 2 where uniacid = :uniacid and keyword = :keyword', array(':uniacid' => $_W['uniacid'],':keyword' => $content));
						}
						if($action === true){
							//替换粉丝标志换成昵称
							
							pdo_insert('n1ce_red_user', $insert);
							$nick = $mc['nickname'];
							$tempstr=str_replace("|#昵称#|",$nick,$settings['sendred']);
							$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
							$this->sendText($openid,$tempstr);
							if($sends['cardid']){
								$this->sendWxCard($openid,$sends['cardid']);
							}
							return $this->respText($sends['txt']);
						}else{
							$insert['status'] = '2';
							pdo_insert('n1ce_red_user', $insert);
							$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
							$this->sendText($settings['mopenid'],$actions);
							$nick = $mc['nickname'];
							$tempstr=str_replace("|#昵称#|",$nick,$settings['sendbad']);
							$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
							return $this->respText($tempstr);
						}
					}
			}
			// 裂变红包
			if($sends['type'] == '7'){
				
				$money = rand($sends['min_money'], $sends['max_money']);
				//$action = $this->sendCommonRedpack($openid, $settings, $money);
				$brrow = $settings['brrow'];
				if($brrow == '2'){
					$exits = pdo_update('n1ce_red_code',array('status'=>'2'),array('id'=>$res['id']));
					$insert = array(
						'uniacid' => $_W['uniacid'],
						'openid' => $openid,
						'nickname' => $mc['nickname'],
						'pici' => $pici,
						'code' => $content,
						'name' => $sends['name'],
						'money' => $money,
						'salt' => md5($openid.time()),
						'time' => TIMESTAMP,
						'status' => '3',
					);
					$redurl = $this->createMobileUrl('redurl' , array('salt'=>$insert['salt'],'total_num'=> $sends['total_num']));
					pdo_update('n1ce_red_prize',$chprize,array('id'=>$pid));
					pdo_insert('n1ce_red_user', $insert);
					$news = array(
						'Title' => '红包消息',
						'Description' => '点击领取',
						'PicUrl' => '',
						'Url' => $redurl,
					);
					
					return $this->respNews($news);
				}else{
					$exits = pdo_update('n1ce_red_code',array('status'=>'2'),array('id'=>$res['id']));
					$action = $this->sendRedgroupPacket($openid, $money,$sends['total_num']);
					pdo_update('n1ce_red_prize',$chprize,array('id'=>$pid));
					
					if($res['iscqr'] == '2'){
					 pdo_query('update ' . tablename('qrcode') . ' set redcode = 2 where uniacid = :uniacid and keyword = :keyword', array(':uniacid' => $_W['uniacid'],':keyword' => $content));
					}
					$insert = array(
						'uniacid' => $_W['uniacid'],
						'openid' => $openid,
						'nickname' => $mc['nickname'],
						'money' => $money,
						'name' => $sends['name'],
						'code' => $content,
						'time' => TIMESTAMP,
						//'status' => '1',
					);
					if($action === true){
						//替换粉丝标志换成昵称
						
						pdo_insert('n1ce_red_user', $insert);
						$nick = $mc['nickname'];
						$tempstr=str_replace("|#昵称#|",$nick,$settings['sendred']);
						$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
						return $this->respText($tempstr);
					}else{
						$insert['status'] = '2';
						pdo_insert('n1ce_red_user', $insert);
						$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
						$this->sendText($settings['mopenid'],$actions);
						$nick = $mc['nickname'];
						$tempstr=str_replace("|#昵称#|",$nick,$settings['sendbad']);
						$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
						return $this->respText($tempstr);
					}
				}
			}
			
		}else{
			$nick = $mc['nickname'];
			$tempstr=str_replace("|#昵称#|",$nick,$settings['islater']);
			$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
			return $this->respText($tempstr);
			//return $this->respText($content);
		}
	}
	private function sendRedPacket($openid,$money){
		global $_W,$_GPC;
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
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
		if(!empty($cfg['scene_id'])){
	      $pars['scene_id'] = $cfg['scene_id'];
	    }
		$pars['nonce_str'] = random(32);
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
	private function sendText($openid,$txt){
		global $_W;
		$acid=pdo_fetchcolumn("SELECT acid FROM ".tablename('account')." WHERE uniacid=:uniacid ",array(':uniacid'=>$_W['uniacid']));
		$acc = WeAccount::create($acid);
		$data = $acc->sendCustomNotice(array('touser'=>$openid,'msgtype'=>'text','text'=>array('content'=>urlencode($txt))));
		return $data;
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
}