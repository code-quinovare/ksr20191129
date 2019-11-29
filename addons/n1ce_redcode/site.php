<?php
/**
 * 验证码生成模块模块微站定义
 *
 * @author n1ce   QQ：541535641
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
define('JS', '../addons/n1ce_redcode/style/js/');
define('IMG', '../addons/n1ce_redcode/style/img/');
class N1ce_redcodeModuleSite extends WeModuleSite {
	//卡券领取
	public function doMobileCardurl(){
		global $_GPC,$_W;
		$card_id = $_GPC['card_id'];
		$openid = $_W['openid'];
		$cardArry = $this->getCard($card_id,$openid);
		include $this->template(getcard);
	}
	//自定义字段入口
	public function doMobileDiyindex(){
		global $_W, $_GPC;
		$settings = $this->module['config'];
		$brrow = mc_oauth_userinfo();
		load()->model('mc');
		$mc = mc_fetch($brrow['openid']);
		$surl = $this->module['config']['surl'];
		$picurl = pdo_fetch('select bgimg,parama from ' . tablename('n1ce_red_pic') . ' where uniacid = :uniacid order by id DESC', array(':uniacid' => $_W['uniacid']));
		$param = json_decode($picurl["parama"], true);
		$picurl = $picurl['bgimg'];
		if (checksubmit( 'submit' )) {
			$picurl = pdo_fetch('select bgimg,parama from ' . tablename('n1ce_red_pic') . ' where uniacid = :uniacid order by id DESC', array(':uniacid' => $_W['uniacid']));
			$parama = $_GPC['parama'];
			$tempary = explode("|#|", $parama);
			$p1 = array();
			$pval = array();
			foreach ($tempary as $row) {
				$_row = explode("|^|", $row);
				$p1[$_row[0]] = $_row[1];
			}
			if ($parama) {
				$param = json_decode($picurl["parama"], true);
				foreach ($param as $index => $row) {
					$pval[urlencode($index)] = urlencode($p1[$index]);
				}
			}
			$openid = $_W['openid'];
			if(empty($openid)){
				message( '参数错误!', $this->createMobileUrl('close'), 'error' );
			}
			$content = $_GPC['code'];
			if(empty($content)){
				message( '请输入验证码!', '', 'error' );
				
			}
			if($settings['brrow'] !== '2'){
				if(empty($_W['openid'])||$_W['fans']['follow']!=1){
					
					message( '请先关注公众号!', $surl, 'error' );
				}
			}
			//限定一次
			if($settings['xianzhi'] == '2'){
				$user_total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename('n1ce_red_user'). ' where uniacid = :uniacid and openid = :openid', array(':uniacid' => $_W['uniacid'],':openid' => $brrow['openid']));
				$limit_num = $settings['getnum'];
				if($user_total >= $limit_num){
					
					message( '您已经超过限制领取次数!', $this->createMobileUrl('close'), 'error' );
				}
			}
			// 新增代码限制粉丝每天领取
			if($settings['today_num']){
				$now_time = strtotime(date('Y-m-d', time()));
				$user_today = pdo_fetchcolumn("select count(*) from " .tablename('n1ce_red_user'). " where uniacid = :uniacid and openid = :openid and time >= :time",array(":uniacid" => $_W['uniacid'],":openid" => $brrow['openid'],":time" => $now_time));
				if($user_today >= $settings['today_num']){
					$nick = $mc['nickname'];
					$tempstr=str_replace("|#昵称#|",$nick,$settings['todayget']);
					$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
					message( $tempstr, $this->createMobileUrl('close'), 'error' );
				}
			}
			// 新增代码结束
			$picires = pdo_fetch('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and  code = :code', array(':code' => $content, ':uniacid' => $_W['uniacid']));
			//获取批次
			$pici = $picires['pici'];
			if(empty($pici)){
				message('验证码错误！','','error');
			}
			
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
		//概率计算排除数量为0的奖品
			$prizes = pdo_fetchall('select * from' . tablename('n1ce_red_prize') . ' where prizesum > 0 and uniacid = :uniacid and pici = :pici order by id desc', array(':uniacid' => $_W['uniacid'], ':pici' => $pici));
			if(!$prizes){
				message( '无效验证码!', '', 'error' ); 
			}
			if($picires['status'] == '1'){
				pdo_update('n1ce_red_code',array('status'=> '2'),array('id'=>$picires['id']));
				foreach ($prizes as $key => $val) {
					$arr[$val['id']] = $val['prizeodds'];
				}
				$pid = $this->get_rand($arr);
				$sends = pdo_fetch('select * from ' . tablename('n1ce_red_prize') . ' where id = :id',array(':id' => $pid));
				$money = rand($sends['min_money'], $sends['max_money']);
				$insert = array(
					'uniacid' => $_W['uniacid'],
					'openid' => $openid,
					'bopenid' => $brrow['openid'],
					'nickname' => $brrow['nickname'],
					'pici' => $pici,
					'money' => $money,
					'name' => $sends['name'],
					'code' => $content,
					'parama' => urldecode(json_encode($pval)),
					'time' => TIMESTAMP,
					//'status' => '1',
				);
				$updatas = array(
					'prizesum' => $sends['prizesum'] - 1,
				);
				if($sends['type'] == '1'){
					$settings = $this->module['config'];
					if($settings['brrow'] == '2'){
						
						$openid = $brrow['openid'];
					}
					//$action = $this->sendCommonRedpack($openid, $settings, $money);
					if($settings['affiliate'] == 2){
						$action = $this->sendSubRedPacket($openid, $money);
					}else{
						$action = $this->sendRedPacket($openid, $money);
					}
					
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					if($action === true){
						//替换粉丝标志换成昵称
						$userdata = array(
						'nickname' => $mc['nickname'],
						);
						pdo_insert('n1ce_red_user', $insert);
						//pdo_update('n1ce_reds_code',$userdata,array('uniacid' => $_W['uniacid'],'code' => $content),'AND');
						message('红包发送成功',$this->createMobileUrl('close'),'success');
					}else{
						$insert['status'] = '2';
						pdo_insert('n1ce_red_user', $insert);
						$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
						$this->sendText($settings['mopenid'],$actions);
						message('红包发送失败,等待客服手动发送给您!',$this->createMobileUrl('close'),'error');
					}
				}
				if($sends['type'] == '2'){
					$res = $this->sendWxCard($openid,$sends['cardid']);
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					if($res){
						$insert['money'] = '微信卡券';
						pdo_insert('n1ce_red_user', $insert);
						$nick = $mc['nickname'];
						$tempstr=str_replace("|#昵称#|",$nick,$settings['sendcard']);
						message('微信卡券发放成功！',$this->createMobileUrl('close'),'success');
					}
				}
				if($sends['type'] == '3'){
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					$insert['money'] = '第三方链接';
						pdo_insert('n1ce_red_user', $insert);
					//return $this->respText("@".$mc['nickname']."恭喜你获得神秘礼品"."\n\n<a href='{$sends['url']}'>点击领取>>></a>");
					message('正在跳转到领取页，请稍候！' , $sends['url'],'success');
					//return $this->respText($sends['url']);
				}
				if($sends['type'] == '4'){
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					$insert['money'] = '微擎积分';
						pdo_insert('n1ce_red_user', $insert);
					//return $this->respText("@".$mc['nickname']."恭喜你获得神秘礼品"."\n\n<a //href='{$sends['url']}'>点击领取>>></a>");
					load()->model('mc');
					$uid = mc_openid2uid($openid);
					$res = mc_credit_update($uid, 'credit1', $sends['credit'], array(0, '系统积分'.$sends['credit'].'积分'));
					if($res){
						$nick = $mc['nickname'];
						$tempstr=str_replace("|#昵称#|",$nick,$settings['sendcredit']);
						$credit = $sends['credit'];
						$tempstrs = str_replace("|#积分#|",$credit,$tempstr);
						//return $this->respText($tempstrs);
						message('恭喜你获得积分！',$this->createMobileUrl('close'),'success');
					}
					//return $this->respText($sends['url']);
				}
				if($sends['type'] == '5'){
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					$insert['money'] = '文本回复';
					pdo_insert('n1ce_red_user', $insert);
					$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$sends['txt']),ENT_QUOTES);
					$this->sendText($openid,$tempstr);
					message('请前往公众号查看提示！',$this->createMobileUrl('close'),'success');
					//return $this->respText($sends['url']);
				}
				if($sends['type'] == '7'){
					$settings = $this->module['config'];
					if($settings['brrow'] == '2'){
						
						$openid = $brrow['openid'];
					}
					
					$action = $this->sendRedgroupPacket($openid, $money,$sends['total_num']);
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					
					if($action === true){
						//替换粉丝标志换成昵称
						$userdata = array(
						'nickname' => $mc['nickname'],
						);
						pdo_insert('n1ce_red_user', $insert);
						//pdo_update('n1ce_reds_code',$userdata,array('uniacid' => $_W['uniacid'],'code' => $content),'AND');
						message('红包发送成功',$this->createMobileUrl('close'),'success');
					}else{
						$insert['status'] = '2';
						pdo_insert('n1ce_red_user', $insert);
						$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
						$this->sendText($settings['mopenid'],$actions);
						message('红包发送失败!',$this->createMobileUrl('close'),'error');
					}
				}
			
			}else{
				message('验证码被领取了!','','error');
			}
		}

		include $this->template( 'diyindex' );	
	}
	//手机端页面管理
	public function doMobileUsermsg(){
		global $_W, $_GPC;
		load()->model('mc');
		$brrow = mc_oauth_userinfo();
		$settings = $this->module['config'];
		$picurl = pdo_fetch('select bgimg from ' . tablename('n1ce_red_pic') . ' where uniacid = :uniacid order by id DESC', array(':uniacid' => $_W['uniacid']));
		$picurl = $picurl['bgimg'];
		if (checksubmit( 'submit' )) {
			if($settings['brrow'] == '2'){
				$userdata = array(
					'uniacid' => $_W['uniacid'],
					'openid' => $brrow['openid'],
					'realname' => $_GPC['realname'],
					'tell' => $_GPC['tell'],
				); 
				pdo_insert('n1ce_red_userinfo',$userdata);
			}else{
				mc_update($brrow['openid'],array('realname' => $_GPC['realname'] , 'mobile' => $_GPC['tell']));
			}
			message('提交资料成功！',$this->createMobileUrl('index'),'success');
		}
		include $this->template('usermsg');
	}
	public function doMobileIndex(){
		global $_W, $_GPC;
		//checklogin();
		$settings = $this->module['config'];
		$brrow = mc_oauth_userinfo();
		//获取昵称，坑爹的mc_fansinfo，用mc_fetch !不能实时获取到新关注的粉丝昵称
		load()->model('mc');
		$mc = mc_fetch($brrow['openid']);
		if($settings['userinfo'] == '2'){
			$usermsg = pdo_fetch("select realname,tell from " .tablename('n1ce_red_userinfo') . " where uniacid = :uniacid and openid = :openid",array(':uniacid' => $_W['uniacid'],':openid' => $brrow['openid']));
			
			if(empty($mc['realname']) || empty($mc['mobile'])){
				if(empty($usermsg['realname']) || empty($usermsg['tell'])){
					message('参与活动前请填写基本信息！',$this->createMobileUrl('usermsg'),'warning');
				}
			}
		}
		$surl = $this->module['config']['surl'];
		$picurl = pdo_fetch('select bgimg from ' . tablename('n1ce_red_pic') . ' where uniacid = :uniacid order by id DESC', array(':uniacid' => $_W['uniacid']));
		$picurl = $picurl['bgimg'];
		if (checksubmit( 'submit' )) {
			$openid = $_W['openid'];
			if(empty($openid)){
				message( '参数错误!', $this->createMobileUrl('close'), 'error' );
			}
			$content = $_GPC['code'];
			if(empty($content)){
				message( '请输入验证码!', '', 'error' );
				
			}
			if($settings['brrow'] !== '2'){
				if(empty($_W['openid'])||$_W['fans']['follow']!=1){
					
					message( '请先关注公众号!', $surl, 'error' );
				}
			}
			//限定一次
			if($settings['xianzhi'] == '2'){
				$user_total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename('n1ce_red_user'). ' where uniacid = :uniacid and openid = :openid', array(':uniacid' => $_W['uniacid'],':openid' => $brrow['openid']));
				$limit_num = $settings['getnum'];
				if($user_total >= $limit_num){
					
					message( '您已经超过限制领取次数!', $this->createMobileUrl('close'), 'error' );
				}
			}
			// 新增代码限制粉丝每天领取
			if($settings['today_num']){
				$now_time = strtotime(date('Y-m-d', time()));
				$user_today = pdo_fetchcolumn("select count(*) from " .tablename('n1ce_red_user'). " where uniacid = :uniacid and openid = :openid and time >= :time",array(":uniacid" => $_W['uniacid'],":openid" => $brrow['openid'],":time" => $now_time));
				if($user_today >= $settings['today_num']){
					$nick = $mc['nickname'];
					$tempstr=str_replace("|#昵称#|",$nick,$settings['todayget']);
					$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstr),ENT_QUOTES);
					message( $tempstr, $this->createMobileUrl('close'), 'error' );
				}
			}
			// 新增代码结束
			$picires = pdo_fetch('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and  code = :code', array(':code' => $content, ':uniacid' => $_W['uniacid']));
			//获取批次
			$pici = $picires['pici'];
			if(empty($pici)){
				message('验证码错误！','','error');
			}
			
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
		//概率计算排除数量为0的奖品
			$prizes = pdo_fetchall('select * from' . tablename('n1ce_red_prize') . ' where prizesum > 0 and uniacid = :uniacid and pici = :pici order by id desc', array(':uniacid' => $_W['uniacid'], ':pici' => $pici));
			if(!$prizes){
				message( '无效验证码!', '', 'error' ); 
			}
			if($picires['status'] == '1'){
				pdo_update('n1ce_red_code',array('status'=> '2'),array('id'=>$picires['id']));
				foreach ($prizes as $key => $val) {
					$arr[$val['id']] = $val['prizeodds'];
				}
				$pid = $this->get_rand($arr);
				$sends = pdo_fetch('select * from ' . tablename('n1ce_red_prize') . ' where id = :id',array(':id' => $pid));
				$money = rand($sends['min_money'], $sends['max_money']);
				$insert = array(
					'uniacid' => $_W['uniacid'],
					'openid' => $openid,
					'bopenid' => $brrow['openid'],
					'nickname' => $brrow['nickname'],
					'pici' => $pici,
					'money' => $money,
					'name' => $sends['name'],
					'code' => $content,
					'time' => TIMESTAMP,
					//'status' => '1',
				);
				$updatas = array(
					'prizesum' => $sends['prizesum'] - 1,
				);
				if($sends['type'] == '1'){
					$settings = $this->module['config'];
					if($settings['brrow'] == '2'){
						
						$openid = $brrow['openid'];
					}
					//$action = $this->sendCommonRedpack($openid, $settings, $money);
					if($settings['affiliate'] == 2){
						$action = $this->sendSubRedPacket($openid, $money);
					}else{
						$action = $this->sendRedPacket($openid, $money);
					}
					
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					if($action === true){
						//替换粉丝标志换成昵称
						$userdata = array(
						'nickname' => $mc['nickname'],
						);
						pdo_insert('n1ce_red_user', $insert);
						//pdo_update('n1ce_reds_code',$userdata,array('uniacid' => $_W['uniacid'],'code' => $content),'AND');
						message('红包发送成功',$this->createMobileUrl('close'),'success');
					}else{
						$insert['status'] = '2';
						pdo_insert('n1ce_red_user', $insert);
						$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
						$this->sendText($settings['mopenid'],$actions);
						message('红包发送失败!',$this->createMobileUrl('close'),'error');
					}
				}
				if($sends['type'] == '2'){
					$res = $this->sendWxCard($openid,$sends['cardid']);
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					if($res){
						$insert['money'] = '微信卡券';
						pdo_insert('n1ce_red_user', $insert);
						$nick = $mc['nickname'];
						$tempstr=str_replace("|#昵称#|",$nick,$settings['sendcard']);
						message('微信卡券发放成功！',$this->createMobileUrl('close'),'success');
					}
				}
				if($sends['type'] == '3'){
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					$insert['money'] = '第三方链接';
						pdo_insert('n1ce_red_user', $insert);
					//return $this->respText("@".$mc['nickname']."恭喜你获得神秘礼品"."\n\n<a href='{$sends['url']}'>点击领取>>></a>");
					message('正在跳转到领取页，请稍候！' , $sends['url'],'success');
					//return $this->respText($sends['url']);
				}
				if($sends['type'] == '4'){
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					$insert['money'] = '微擎积分';
						pdo_insert('n1ce_red_user', $insert);
					//return $this->respText("@".$mc['nickname']."恭喜你获得神秘礼品"."\n\n<a //href='{$sends['url']}'>点击领取>>></a>");
					load()->model('mc');
					$uid = mc_openid2uid($openid);
					$res = mc_credit_update($uid, 'credit1', $sends['credit'], array(0, '系统积分'.$sends['credit'].'积分'));
					if($res){
						$nick = $mc['nickname'];
						$tempstr=str_replace("|#昵称#|",$nick,$settings['sendcredit']);
						$credit = $sends['credit'];
						$tempstrs = str_replace("|#积分#|",$credit,$tempstr);
						//return $this->respText($tempstrs);
						message('恭喜你获得积分！',$this->createMobileUrl('close'),'success');
					}
					//return $this->respText($sends['url']);
				}
				if($sends['type'] == '5'){
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					$insert['money'] = '文本回复';
					pdo_insert('n1ce_red_user', $insert);
					$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$sends['txt']),ENT_QUOTES);
					$this->sendText($openid,$tempstr);
					message('请前往公众号查看提示！',$this->createMobileUrl('close'),'success');
					//return $this->respText($sends['url']);
				}
				if($sends['type'] == '7'){
					$settings = $this->module['config'];
					if($settings['brrow'] == '2'){
						
						$openid = $brrow['openid'];
					}
					
					$action = $this->sendRedgroupPacket($openid, $money,$sends['total_num']);
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					
					if($action === true){
						//替换粉丝标志换成昵称
						$userdata = array(
						'nickname' => $mc['nickname'],
						);
						pdo_insert('n1ce_red_user', $insert);
						//pdo_update('n1ce_reds_code',$userdata,array('uniacid' => $_W['uniacid'],'code' => $content),'AND');
						message('红包发送成功',$this->createMobileUrl('close'),'success');
					}else{
						$insert['status'] = '2';
						pdo_insert('n1ce_red_user', $insert);
						$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
						$this->sendText($settings['mopenid'],$actions);
						message('红包发送失败!',$this->createMobileUrl('close'),'error');
					}
				}
			
			}else{
				message('验证码被领取了!','','error');
			}
		}

		include $this->template( 'index' );	
	}
	public function doMobileClose(){
		global $_W, $_GPC;
		include $this->template( 'close' );	
	}
	//智能二维码
	// 修改智能二维码安卓机杂牌机问题
	public function doMobileSalt(){
		global $_W, $_GPC;
		if($_W['container'] !== 'wechat'){
			message('请用微信扫一扫打开！','','error');die();
		}
		$fansinfo = mc_oauth_userinfo();
		$salturl = $this->createMobileUrl('saltinfo',array('pici'=>$_GPC['pici'],'salt'=>$_GPC['salt']));
		$salturl = $_W['siteroot'] . 'app' . str_replace('./', '/', $salturl);
		include $this->template('wait-loading');
	}
	public function doMobileSaltinfo(){
		global $_W, $_GPC;
		$fansinfo = mc_oauth_userinfo();
		$openid = $_W['openid'];
		if(empty($openid)){
			$openid = $fansinfo['openid'];
		}
		if(empty($openid) || empty($fansinfo['headimgurl'])){
			die();
		}
		$saltcode = strrev($_GPC['salt']);
		$pici = $_GPC['pici'];
		$timeinfo = pdo_fetch('select * from ' . tablename('n1ce_red_pici') .' where uniacid = :uniacid and pici = :pici',array(':uniacid'=>$_W['uniacid'],':pici'=>$pici));
		if($timeinfo['time_limit'] == '1'){
			if ($timeinfo['starttime'] > time()) {
				
				message($timeinfo['miss_start']);
			}
			if ($timeinfo['endtime'] < time()) {
				message($timeinfo['miss_end']);
			}
		}
		$settings = $this->module['config'];
		if($settings['xianzhi'] == '2'){
			
			$user_total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename('n1ce_red_user'). ' where uniacid = :uniacid and openid = :openid', array(':uniacid' => $_W['uniacid'],':openid' => $openid));
			$limit_num = $settings['getnum'];
			if($user_total >= $limit_num){
				
				message( '您已经超过限制领取次数!', $this->createMobileUrl('close'), 'error' );
			}
		}
		// 新增代码限制粉丝每天领取
		if($settings['today_num']){
			$now_time = strtotime(date('Y-m-d', time()));
			$user_today = pdo_fetchcolumn("select count(*) from " .tablename('n1ce_red_user'). " where uniacid = :uniacid and openid = :openid and time >= :time",array(":uniacid" => $_W['uniacid'],":openid" => $openid,":time" => $now_time));
			if($user_today >= $settings['today_num']){
				$tempstr=str_replace("|#昵称#|",$nick,$settings['todayget']);
				message( $tempstr, $this->createMobileUrl('close'), 'error' );
			}
		}
		// 新增代码结束
		$codeinfo = pdo_fetch('select * from' . tablename('n1ce_red_code') . 'where uniacid = :uniacid and pici = :pici and salt = :salt',array(':uniacid'=>$_W['uniacid'],':pici'=>$pici,':salt'=>$saltcode));
		if(empty($codeinfo['code']) || empty($saltcode)){
			message('二维码无效!',$this->createMobileUrl('close'),'error');die();
		}
		
		if($_W['fans']['follow'] == 0) {
			$data = array(
				'uniacid' => $_W['uniacid'],
				'openid' => $fansinfo['openid'],
				'nickname' => $fansinfo['nickname'],
				'code' => $codeinfo['code'],
				'pici' => $pici,
				'time' => TIMESTAMP,
			);
			if($codeinfo['status']==1)
			{			
				pdo_insert('n1ce_red_scanuser',$data);
				if(pdo_insertid()){
					pdo_update('n1ce_red_code',array('status'=> '2'),array('id'=>$codeinfo['id']));
				}
			}
			$qrcodedesc = tomedia('qrcode_'.$_W['acid'].'.jpg');
			if($settings['salt_img']){
				include $this->template( 'salt-img' );die(); 
			}else{
				include $this->template( 'salt' );die(); 
			}
		}else{
			if($codeinfo['status'] == 1){

			}else
			{
				message('二维码已经被扫描!',$this->createMobileUrl('close'),'error');die();			
			}
			$prizes = pdo_fetchall('select * from' . tablename('n1ce_red_prize') . ' where prizesum > 0 and uniacid = :uniacid and pici = :pici order by id desc', array(':uniacid' => $_W['uniacid'], ':pici' => $pici));
			if(!$prizes){
				message( '奖品库存不足', $this->createMobileUrl('close'), 'error' ); 
			}
			pdo_update('n1ce_red_code',array('status'=> '2'),array('id'=>$codeinfo['id']));
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
				'openid' => $fansinfo['openid'],
				'nickname' => $fansinfo['nickname'],
				'pici' => $pici,
				'name' => $sends['name'],
				'time' => TIMESTAMP,
				'code' => $codeinfo['code'],
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
					$notice = str_replace("|#昵称#|",$fansinfo['nickname'],$settings['sendred']);
					$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
					// 卡券客服消息推送失败模板消息接口推送
					$sendlog = $this->sendText($openid,$tempstr);
					message('红包发送成功,请返回微信聊天主页面查看红包消息！',$this->createMobileUrl('close'),'success');
				}else{
					
					$insert['status'] = '2';
					pdo_insert('n1ce_red_user', $insert);
					$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
					$this->sendText($settings['mopenid'],$actions);
					$notice = str_replace("|#昵称#|",$fansinfo['nickname'],$settings['sendbad']);
					$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
					// 卡券客服消息推送失败模板消息接口推送
					
					$sendlog = $this->sendText($openid,$tempstr);
					if(is_error($sendlog)){
						$content = array(
								'first' => array(
									'value' => '消息通知->>>',
								), 
								'keyword1' => array(
									'color' => '#43CD80',
									'value' => '扫码结果通知', 
								), 
								'keyword2' => array(
									'color' => '#ADFF2F',
									'value' => '[领取红包失败]', 
								),
								'keyword3' => array(
									'color' => '#ADFF2F',
									'value' => date("Y-m-d H:i:s",TIMESTAMP), 
								),
								'remark' => array(
									'color' => '#EEB422',
									'value' => "领取失败提示:".$tempstr
								), 
							);
						$ret = $this -> sendtpl($openid, '', $settings['tempid'], $content);
					}
					message('红包正在排队发放中!!',$this->createMobileUrl('close'),'info');
				}
				
			}
			if($sends['type'] == '2'){
				$res = $this->sendWxCard($openid,$sends['cardid']);
				if($res === true){
				}else{
					$content = array(
							'first' => array(
								'value' => '消息通知->>>',
							), 
							'keyword1' => array(
								'color' => '#43CD80',
								'value' => '扫码结果通知', 
							), 
							'keyword2' => array(
								'color' => '#ADFF2F',
								'value' => '[卡券消息]', 
							),
							'keyword3' => array(
									'color' => '#ADFF2F',
									'value' => date("Y-m-d H:i:s",TIMESTAMP), 
								),
							'remark' => array(
								'color' => '#EEB422',
								'value' => "消息内容:恭喜你获得一张卡券，请点击领取>>>"
							), 
						);
					$cardUrl = $this->createMobileUrl('cardurl' , array('card_id'=>$sends['cardid']));
					$cardUrl = $_W['siteroot'] . 'app' . str_replace('./', '/', $cardUrl);
					$ret = $this -> sendtpl($openid, $cardUrl, $settings['tempid'], $content);
				}
				pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
				if($res){
					pdo_insert('n1ce_red_user', $insert);
					$notice = str_replace("|#昵称#|",$fansinfo['nickname'],$settings['sendcard']);
					$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
					// 卡券客服消息推送失败模板消息接口推送
					
					$this->sendText($openid,$tempstr);
					message('恭喜你获得一张卡券,请返回微信聊天主页面查看卡券消息！',$this->createMobileUrl('close'),success);
				}
			}
			if($sends['type'] == '3'){
				pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
				pdo_insert('n1ce_red_user', $insert);
				message('恭喜你获得神秘礼品,请点击领取礼品！',$sends['url'],'success');
			}
			if($sends['type'] == '4'){
				pdo_insert('n1ce_red_user', $insert);
				load()->model('mc');
				$uid = mc_openid2uid($openid);
				$res = mc_credit_update($uid, 'credit1', $sends['credit'], array(0, '系统积分'.$sends['credit'].'积分'));
				if($res){
					pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
					$tempstr=str_replace("|#昵称#|",$fansinfo['nickname'],$settings['sendcredit']);
					$credit = $sends['credit'];
					$tempstrs = str_replace("|#积分#|",$credit,$tempstr);
					$notice = htmlspecialchars_decode(str_replace('&quot;','&#039;',$tempstrs),ENT_QUOTES);
					// 卡券客服消息推送失败模板消息接口推送
					
					$sendlog = $this->sendText($openid,$notice);
					if(is_error($sendlog)){
						$content = array(
								'first' => array(
									'value' => '消息通知->>>',
								), 
								'keyword1' => array(
									'color' => '#43CD80',
									'value' => '扫码结果通知', 
								), 
								'keyword2' => array(
									'color' => '#ADFF2F',
									'value' => '[获得积分]', 
								),
								'keyword3' => array(
									'color' => '#ADFF2F',
									'value' => date("Y-m-d H:i:s",TIMESTAMP), 
								),
								'remark' => array(
									'color' => '#EEB422',
									'value' => "消息内容:".$notice
								), 
							);
						$ret = $this -> sendtpl($openid, '', $settings['tempid'], $content);
					}
					message('恭喜你获得积分奖励,奖励已发放,请前往会员中心查看！',$this->createMobileUrl('close'),'success');
				}
			}
			if($sends['type'] == '5'){
				pdo_update('n1ce_red_prize',$updatas,array('id'=>$pid));
				pdo_insert('n1ce_red_user', $insert);
				$notice = str_replace("|#昵称#|",$fansinfo['nickname'],$sends['txt']);
				$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
				// 卡券客服消息推送失败模板消息接口推送
				
				$sendlog = $this->sendText($openid,$tempstr);
				if(is_error($sendlog)){
					$content = array(
							'first' => array(
								'value' => '消息通知->>>',
							), 
							'keyword1' => array(
								'color' => '#43CD80',
								'value' => '扫码结果通知', 
							), 
							'keyword2' => array(
								'color' => '#ADFF2F',
								'value' => '[文字消息]', 
							),
							'keyword3' => array(
									'color' => '#ADFF2F',
									'value' => date("Y-m-d H:i:s",TIMESTAMP), 
								),
							'remark' => array(
								'color' => '#EEB422',
								'value' => "消息内容:".$tempstr
							), 
						);
					$ret = $this -> sendtpl($openid, '', $settings['tempid'], $content);
				}
				message($tempstr,$this->createMobileUrl('close'),'success');
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
							$notice = str_replace("|#昵称#|",$fansinfo['nickname'],$settings['sendred']);
							$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
							// 卡券客服消息推送失败模板消息接口推送
							
							$this->sendText($openid,$tempstr);
							if($sends['cardid']){
								$this->sendWxCard($openid,$sends['cardid']);
							}
							// 卡券客服消息推送失败模板消息接口推送
							
							$this->sendText($openid,$sends['txt']);
							message('奖品发放成功,请返回微信聊天主页面查看公众号消息！',$this->createMobileUrl('close'),'success');
						}else{
							$insert['status'] = '2';
							pdo_insert('n1ce_red_user', $insert);
							$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
							$this->sendText($settings['mopenid'],$actions);
							$notice = str_replace("|#昵称#|",$fansinfo['nickname'],$settings['sendbad']);
							$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
							// 卡券客服消息推送失败模板消息接口推送
							
							$this->sendText($openid,$tempstr);
							message('红包正在排队发放中！！',$this->createMobileUrl('close'),'info');
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
					$notice = str_replace("|#昵称#|",$fansinfo['nickname'],$settings['sendred']);
					$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
					// 卡券客服消息推送失败模板消息接口推送
					
					$this->sendText($openid,$tempstr);
					message('红包发送成功,请返回微信聊天主页面查看红包消息！',$this->createMobileUrl('close'),'success');
				}else{
					$insert['status'] = '2';
					pdo_insert('n1ce_red_user', $insert);
					$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
					$this->sendText($settings['mopenid'],$actions);
					$notice = str_replace("|#昵称#|",$fansinfo['nickname'],$settings['sendbad']);
					$tempstr = htmlspecialchars_decode(str_replace('&quot;','&#039;',$notice),ENT_QUOTES);
					// 卡券客服消息推送失败模板消息接口推送
					
					$this->sendText($openid,$tempstr);
					message('红包正在排队发放中!!',$this->createMobileUrl('close'),'info');
				}
				
			}
		}
		
	}
	//红包排行榜
	public function doMobileRank(){
		global $_W, $_GPC;
		$fans = $_W['fans'];
		$fans['avatar'] = $fans['tag']['avatar'];
		
		$sum = pdo_fetchcolumn('select sum(money) from '.tablename("n1ce_red_user")." where openid='{$fans['openid']}'");
		$sum = number_format($sum/100,2);
		
		$shares = pdo_fetchall('select openid,sum(money) as allsum from '.tablename("n1ce_red_user")." where uniacid='{$_W['uniacid']}' group by openid order by allsum desc");
		load()->model('mc');
		foreach ($shares as &$value) {
			$mc = mc_fetch($value['openid'],array('nickname','avatar'));
			$value['nickname'] = $mc['nickname'];
			$value['avatar'] = $mc['avatar'];
			$value['sum'] = number_format($value['allsum']/100,2);
		}
		
		$records = pdo_fetchall('select money,time from '.tablename("n1ce_red_user")." where openid='{$fans['openid']}' order by time desc");
		foreach ($records as &$val) {
			$val['num'] = number_format($val['money']/100,2);
			$val['time'] = date('Y-m-d H:i:s',$val['time']);
		}
		include $this->template( 'rank' );
	}
	//借权发送红包
	public function doMobileRedurl(){
		//借权获取openid并发红包
		//处理拉黑
		global $_W, $_GPC;
		$settings = $this->module['config'];
		$brrow = mc_oauth_userinfo();
		if(empty($brrow['openid'])){
			message('参数错误',$this->createMobileUrl('close'),'error');
		}
		$balcklog = $this->getBlackByOpenid($brrow['openid']);
		if($balcklog){
			message('系统记录你有重复提交行为,被限制领取～',$this->createMobileUrl('close'),'error');
		}
		$salt = $_GPC['salt'];
		if(empty($salt)){
			message('参数错误',$this->createMobileUrl('close'),'error');
		}
		$res = pdo_fetch('select id,money from' . tablename('n1ce_red_user') . ' where uniacid = :uniacid and salt = :salt and status = 3', array(':uniacid' => $_W['uniacid'], ':salt' => $salt));
		if(empty($res['id'])){
			message('红包已经被领取',$this->createMobileUrl('close'),'error');
		}
		if(checksubmit()){
			//记录进入临时log
			$retlog = $this->insertBorrowLog($brrow['openid'],$salt);
			if($retlog){
				$action = $this->sendRedPacket($brrow['openid'], $res['money']);
				if($action === true){
					$data = "恭喜你获得红包！";
					$binsert = array(
						'bopenid' => $brrow['openid'],
						'nickname' => $brrow['nickname'],
						'status' => '1',
					);
					pdo_update('n1ce_red_user',$binsert, array('id'=>$res['id']));
					$text = "亲爱的粉丝，请返回微信聊天主页面查看红包消息！";
					$this->sendText($openid,$text);
				}else{
					$data = "红包正在排队发放中！！";
					$binsert = array(
						'bopenid' => $brrow['openid'],
						'nickname' => $brrow['nickname'],
						'status' => '2',
					);
					pdo_update('n1ce_red_user',$binsert, array('id'=>$res['id']));
					
					$actions = "亲爱的管理员，有粉丝红包领取失败！\n原因：".$action;
					$this->sendText($settings['mopenid'],$actions);
				}
				message($data,$this->createMobileUrl('close'),'success');
			}else{
				pdo_insert('n1ce_red_blacklog',array('uniacid'=>$_W['uniacid'],'openid'=>$brrow['openid']));
				message('重复提交',$this->createMobileUrl('close'),'error');
			}
				
		}
		include $this->template('newindex');
	}
	//判断是不是黑名单
	public function getBlackByOpenid($openid){
		global $_W;
		$ret = pdo_get('n1ce_red_blacklog',array('uniacid'=>$_W['uniacid'],'openid'=>$openid),array('id'));
		return $ret['id'];
	}
	public function insertBorrowLog($openid,$salt){
		global $_W;
		pdo_insert('n1ce_red_borrowlog',array('uniacid'=>$_W['uniacid'],'salt'=>$salt,'check_sign'=>$openid.time()));
		return pdo_insertid();
	}
	//后台管理页面
	public function doWebIndex() {
		global $_W, $_GPC;
		checklogin();
		if (checksubmit( 'submit' )) {
			$data = array();
			$data['uniacid']              = intval( $_W['uniacid'] );
			$data['bgimg']       = $_GPC['bgimg'];
			$parama = array();
			if (isset($_GPC['parama-key'])) {
				foreach ($_GPC['parama-key'] as $index => $row) {
					if (empty($row)) {
						continue;
					}
					$parama[urlencode($row)] = urlencode($_GPC['parama-val'][$index]) . "|#|" . urlencode(intval($_GPC['parama-need'][$index])) . "|#|" . urlencode($_GPC['parama-default'][$index]);
				}
			}
			if (isset($_GPC['parama-key-new'])) {
				foreach ($_GPC['parama-key-new'] as $index => $row) {
					if (empty($row)) {
						continue;
					}
					$parama[urlencode($row)] = urlencode($_GPC['parama-val-new'][$index]) . "|#|" . urlencode(intval($_GPC['parama-need-new'][$index])) . "|#|" . urlencode($_GPC['parama-default-new'][$index]);
				}
			}
			$data['parama'] = urldecode(json_encode($parama));
			//var_dump($data['parama']);die();
			$result = pdo_insert( 'n1ce_red_pic', $data );
			if (!$result) message( '添加失败!', '', 'error' );
			message( '创建成功!', 'refresh', 'success' );
		}
		$data = pdo_fetch('select * from ' . tablename('n1ce_red_pic') . ' where uniacid = :uniacid order by id DESC', array(':uniacid' => $_W['uniacid']));
		include $this->template( 'index' );
	}
	//import_request_variables
	public function doWebImport()
	{
		global $_W, $_GPC;
		load()->func('logging');
		$pici = $_GPC['pici'];
		
		if (!empty($_GPC['foo'])) {
			try {
				include_once "reader.php";
				$tmp = $_FILES['file']['tmp_name'];
				if (empty($tmp)) {
					echo '请选择要导入的Excel文件！';
					die;
				}
				$file_name = IA_ROOT . "/addons/n1ce_redcode/xls/code.xls";
				$uniacid = $_W['uniacid'];
				
				if (copy($tmp, $file_name)) {
					$xls = new Spreadsheet_Excel_Reader();
					$xls->setOutputEncoding('utf-8');
					$xls->read($file_name);
					$data_values = "";
					$count = $xls->sheets[0]['numRows'];
					for ($i = 1; $i <= $count; $i++) {
						$code = $xls->sheets[0]['cells'][$i][1];
						
						$data = array(
							'uniacid' => $_W['uniacid'],
							'code' => trim($code),
							'pici' => $pici,
							'time' => TIMESTAMP,
						);
						$res = pdo_insert('n1ce_red_code',$data);
					}
					if ($res) {
						pdo_query("update " . tablename("n1ce_red_pici") . " set codenum = codenum + {$count} where pici = :pici and uniacid =:uniacid", array(":pici" => $pici, ":uniacid" => $uniacid));
						$url = $this->createWebUrl('code');
						echo '<script>alert(\'导入成功！\')</script>';
						echo "<script>window.location.href= '{$url}'</script>";
					} else {
						$url = $this->createWebUrl('Import', array());
						echo '<script>alert(\'导入失败！\')</script>';
						echo "<script>window.location.href= '{$url}'</script>";
					}
				} else {
					echo '复制失败！';
					die;
				}
			} catch (Exception $e) {
				logging_run($e, '', 'upload_tiku');
			}
		} else {
			include $this->template('import');
		}
	}
	//卡密删除
	public function doWebMiss() {
		global $_GPC, $_W;
		checklogin();
		$res = pdo_fetch('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and status = 2', array(':uniacid' => $_W['uniacid']));
		if($res){
		pdo_delete('n1ce_red_code', array('uniacid' => $_W['uniacid'] ,'status' =>'2'));
		message('删除成功',$this->createWebUrl("code"),'success');
		}else{
			message('暂无已使用卡密',$this->createWebUrl("code"),'error');
		}
	}
	//每批次卡密删除
	public function doWebCodedie() {
		global $_GPC, $_W;
		checklogin();
		$pici = $_GPC['pici'];
		$res = pdo_fetch('select * from ' . tablename('n1ce_red_pici') . ' where uniacid = :uniacid and pici = :pici', array(':uniacid' => $_W['uniacid'] ,':pici' => $pici));
		if($res){
		pdo_delete('n1ce_red_pici', array('uniacid' => $_W['uniacid'],'pici' => $pici));
		pdo_delete('n1ce_red_code', array('uniacid' => $_W['uniacid'],'pici' => $pici));
		pdo_delete('n1ce_red_prize', array('uniacid' => $_W['uniacid'],'pici' => $pici));
		pdo_delete('n1ce_red_user', array('uniacid' => $_W['uniacid'],'pici' => $pici));
		pdo_query('update ' . tablename('qrcode') . ' set redcode = 2 where uniacid = :uniacid and qrcid > 10000000 and pici = :pici', array(':uniacid' => $_W['uniacid'],':pici' => $pici));
		message('删除成功',$this->createWebUrl("code"),'success');
		}else{
			message('暂无卡密',$this->createWebUrl("code"),'error');
		}
	}
	//二维码失效假装失效
	public function doWebQrbad() {
		global $_GPC, $_W;
		checklogin();
		$res = pdo_query('update ' . tablename('qrcode') . ' set redcode = 2 where uniacid = :uniacid and qrcid > 10000000 and model = 1', array(':uniacid' => $_W['uniacid']));
		if($res){
		message('二维码失效',$this->createWebUrl("qrshow"),'success');
		}else{
			message('暂无可用二维码',$this->createWebUrl("qrshow"),'error');
		}
	}
	public function doWebQrbad2() {
		global $_GPC, $_W;
		checklogin();
		$res = pdo_query('delete from ' . tablename('qrcode') . ' where uniacid = :uniacid and qrcid > 10000000 and model = 2', array(':uniacid' => $_W['uniacid']));
		if($res){
		message('二维码失效',$this->createWebUrl("qrlong"),'success');
		}else{
			message('暂无可用二维码',$this->createWebUrl("qrlong"),'error');
		}
	}
	public function doWebSendred(){
		global $_W ,$_GPC;
		checklogin();
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$settings = $this->module['config'];
		if($operation=="send"){
			$id = $_GPC['id'];
			$money = $_GPC['money'];
			$openid = $_GPC['openid'];
			if($settings['affiliate'] == 2){
				$res = $this->sendSubRedPacket($openid, $money);
			}else{
				$res = $this->sendRedPacket($openid, $money);
			}
			if($res === true){
				pdo_query('update ' . tablename('n1ce_red_user') . ' set status = 1 where uniacid = :uniacid and id = :id', array(':uniacid' => $_W['uniacid'],':id' => $id));
				message('恭喜你，红包发送成功', $this->createWebUrl('usershow'), 'success');
			}else{
				message($res,'','error');
			}
			
		}	
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
	
	//下载卡密
	public function  doWebUDownload2()
	{
		global $_GPC,$_W;
		checklogin();
		$list = pdo_fetchall('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and status = 1 ORDER BY id ', array(':uniacid' => $_W['uniacid']));
		$tableheader = array('ID', $this->encode("卡密"),$this->encode("时间"));
		$html = "\xEF\xBB\xBF";
		foreach ($tableheader as $value) {  
			$html .= $value . "\t";
		}
		$html .= "\n";
		foreach ($list as $value) {
			$html .= $value['id'] . "\t";
			$html .= $this->encode( $value['code'] )  . "\t";
			$html .= ($value['time'] == 0 ? '' : date('Y-m-d H:i',$value['time'])) . "\n";

		}


		header("Content-type:text/csv");
		header("Content-Disposition:attachment; filename=卡密数据.xls");

		echo $html;
		exit();
	}
	
	function  encode($value)
	{
		return $value;
		return iconv("utf-8", "gb2312", $value);

	}
	
	public function  doWebUDownload()
	{
		global $_GPC,$_W;
		checklogin();
		$pici = $_GPC['pici'];
		$list = pdo_fetchall('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and status = 1 and pici = :pici ORDER BY id ', array(':uniacid' => $_W['uniacid'], ':pici' => $pici));
		
		$str = "ID\t".$this->encode("卡密")."\t".$this->encode("生成时间")."\n";
		
		foreach ($list as $vo) {
			$str .= $vo['id'] . "\t" . $vo['code'] . "\t" . date('Y-m-d H:i',$vo['time']) . "\n";
		}
		$filename = '第' . $pici . '批次卡密数据' . date('YmdHis') . '.xls';
		$this->export_csv( $filename, $str );
		
	}
	public function  doWebUserpost()
	{
		global $_GPC,$_W;
		checklogin();
		load()->model('mc');
		$reply = pdo_fetch('select parama from ' . tablename('n1ce_red_pic') . ' where uniacid = :uniacid order by id DESC', array(':uniacid' => $_W['uniacid']));
		$parama = json_decode($reply['parama'], true);
		$settings = $this->module['config'];
		$pici = $_GPC['pici'];
		$con = "";
		if ($pici != '') {
			$con .= " and pici = '$pici'";
			$piciname = "第".$pici."批次";
		}
		$filename = $piciname. '领取数据' . date('YmdHis') . '.xls';
		$list = pdo_fetchall('select * from ' . tablename('n1ce_red_user') . ' where uniacid = :uniacid and status = 1' . $con .' ORDER BY id ', array(':uniacid' => $_W['uniacid']));
		$tableheader = array('粉丝昵称', '姓名', '手机号码', '卡密','批次', '奖品', '红包金额/元', '领取时间');
		foreach ($parama as $index => $row) {
			array_push($tableheader, $index);
		}
		$html = "\xEF\xBB\xBF";
		foreach ($tableheader as $value) {
			$html .= $value . "\t ";
		}
		$html .= "\n";
		foreach ($list as $row) {
			$mc = mc_fetch($row['openid']);
			
			if(empty($mc['realname']) || empty($mc['mobile'])){
				$userinfo = pdo_fetch("select realname,tell from " .tablename('n1ce_red_userinfo') . " where uniacid = :uniacid and openid = :openid",array(':uniacid' => $_W['uniacid'],':openid' => $row['bopenid']));
				$mc['realname'] = $userinfo['realname'];
				$mc['mobile'] = $userinfo['tell'];
			}
			$html .= $this->encode($row['nickname']) . "\t ";
			$html .= $this->encode($mc['realname']) . "\t ";
			$html .= $this->encode($mc['mobile']) . "\t ";
			$html .= $this->encode($row['code']) . "\t ";
			$html .= $row['pici'] . "\t";
			$html .= $this->encode($row['name']) . "\t ";
			$html .= $this->encode($row['money']/100) . "\t ";
			$html .= date('Y-m-d H:i:s',$row['time']) . "\t ";
			$para = json_decode($row['parama'], true);
			foreach ($parama as $index => $val) {
				$html .= $para[$index] . "\t ";
			}
			$html .= "\n";
		}
		header("Content-type:text/csv");
		header("Content-Disposition:attachment; filename=" . $filename);
		echo $html;
		die;
	}
	public function doWebSaltdownload()
	{
		global $_GPC,$_W;
		checklogin();
		$pici = $_GPC['pici'];
		$list = pdo_fetchall('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and pici = :pici and status = 1 order by id desc',array(':uniacid' => $_W['uniacid'],':pici' => $pici));
		$str = $this->encode("卡密")."\t".$this->encode("所需打印网址")."\t".$this->encode("生成时间")."\n";
		
		foreach ($list as $vo) {
			$url = $this->createMobileUrl('salt',array('salt'=>strrev($vo['salt']),'pici'=>$pici));
			$salturl = $_W['siteroot'] . 'app' . str_replace('./', '/', $url);
			//$shorturl = $this->shortUrlsalt($salturl);
			$str .= $vo['code'] . "\t" . $salturl . "\t" . date('Y-m-d H:i',$vo['time']) . "\n";
		}
		$filename = '第' . $pici . '批次卡密二维码数据' . date('YmdHis') . '.xls';
		$this->export_csv( $filename, $str );
	}
	public function shortUrlsalt($url){
		$apiurl = "http://rrd.me/api.php?url=".urlencode($url);
		load()->func('communication');
		$res = ihttp_request($apiurl);
		//$res = json_decode($res['content'],true);
		//var_dump($res);die();
		if($res['status'] == 'OK'){
			$shorturl = $res['content'];
		}else{
			$shorturl = $res['status'];
		}
		return $shorturl;
	}
	public function  doWebUrldownload()
	{
		global $_GPC,$_W;
		checklogin();
		$pici = $_GPC['pici'];
		$acid = intval($_W['acid']);
		$wheresql = " WHERE uniacid = {$_W['uniacid']}";
		if($acid > 0) {
		$wheresql .= " AND acid = {$acid} ";
		}
		$wheresql .= " AND pici = {$pici} ";
		$wheresql .= " AND model = 1";
		$wheresql .= " AND make = 1";
		$wheresql .= " AND redcode = 1";
		$wheresql .= " AND qrcid > 10000000";
		pdo_query('update ' . tablename('qrcode') . ' set make = 1 where uniacid = :uniacid and model = 1 and redcode = 1 and qrcid > 10000000', array(':uniacid' => $_W['uniacid']));
		$list = pdo_fetchall("SELECT * FROM ".tablename('qrcode'). $wheresql . ' ORDER BY createtime DESC ');
		//$list = pdo_fetchall('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and status = 1 ORDER BY id ', array(':uniacid' => $_W['uniacid']));
		
		$str = $this->encode("卡密")."\t".$this->encode("所需打印网址")."\t".$this->encode("生成时间")."\n";
		
		foreach ($list as $vo) {
			$str .= $vo['keyword'] . "\t" . $vo['url'] . "\t" . date('Y-m-d H:i',$vo['createtime']) . "\n";
		}
		$filename = '第' . $pici . '批次卡密二维码数据' . date('YmdHis') . '.xls';
		$this->export_csv( $filename, $str );
		
	}
	public function  doWebUrldownload2()
	{
		global $_GPC,$_W;
		checklogin();
		$pici = $_GPC['pici'];
		$acid = intval($_W['acid']);
		$wheresql = " WHERE uniacid = {$_W['uniacid']}";
		if($acid > 0) {
		$wheresql .= " AND acid = {$acid} ";
		}
		$wheresql .= " AND pici = {$pici} ";
		$wheresql .= " AND model = 2";
		$wheresql .= " AND make = 1";
		$wheresql .= " AND redcode = 1";
		$wheresql .= " AND qrcid > 10000000";
		pdo_query('update ' . tablename('qrcode') . ' set make = 1 where uniacid = :uniacid and model = 2 and redcode = 1 and qrcid > 10000000', array(':uniacid' => $_W['uniacid']));
		$list = pdo_fetchall("SELECT * FROM ".tablename('qrcode'). $wheresql . ' ORDER BY createtime DESC ');
		//$list = pdo_fetchall('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and status = 1 ORDER BY id ', array(':uniacid' => $_W['uniacid']));
		
		$str = $this->encode("卡密")."\t".$this->encode("所需打印网址")."\t".$this->encode("生成时间")."\n";
		
		foreach ($list as $vo) {
			$str .= $vo['keyword'] . "\t" . $vo['url'] . "\t" . date('Y-m-d H:i',$vo['createtime']) . "\n";
		}
		$filename = '第' . $pici . '批次永久卡密二维码数据' . date('YmdHis') . '.xls';
		$this->export_csv( $filename, $str );
		
	}
	/**
 * 导出CSV
 *
 * @param $filename
 * @param $data
 */
	function export_csv($filename, $data) {
		header( "Content-type:text/csv" );
		header( "Content-Disposition:attachment;filename=" . $filename );
		header( 'Cache-Control:must-revalidate,post-check=0,pre-check=0' );
		header( 'Expires:0' );
		header( 'Pragma:public' );
		echo $data;
	}
	//生成二维码并关联关键字
	public function doWebQrcode() {
		global $_GPC, $_W;
		checklogin();
		load()->model('account');
		load()->func('communication');
		$pici = $_GPC['pici'];
		$acidarr = uni_accounts($_W['uniacid']);
		$acid = intval($_W['acid']);
		$uniacccount = WeAccount::create($acid);
		$ishave = pdo_fetchall('select * from ' . tablename('qrcode') . ' where qrcid = :qrcid and uniacid = :uniacid', array(':qrcid' => '10000000' ,':uniacid' => $_W['uniacid']));
		if(empty($ishave)){
			$insert = array(
				'uniacid' => $_W['uniacid'],
				'acid' => $acid,
				'qrcid' => '10000000',
				'keyword' => 'redcode',
				'name' => 'redcode',
				'model' => '1',
				'createtime' => TIMESTAMP,
				'status' => '1',
				'pici' => '0',
			);
			pdo_insert('qrcode', $insert);
		}
		
		$res = pdo_fetchall('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and status = 1 and pici = :pici and iscqr = 1 limit 100', array(':uniacid' => $_W['uniacid'], ':pici' => $pici));
		foreach($res as $key => $vol){
			$keyword = $vol['code'];
			$qrcid = pdo_fetch("SELECT max(qrcid) FROM ".tablename('qrcode')." WHERE acid = :acid AND model = 1 and name = :name", array(':acid' => $acid,':name' => 'redcode'));
			
			$barcode['action_info']['scene']['scene_id'] = !empty($qrcid['max(qrcid)']) ? ($qrcid['max(qrcid)']+1) : 10000001;
			$barcode['expire_seconds'] = '2592000';
			$barcode['action_name'] = 'QR_SCENE';
			$result = $uniacccount->barCodeCreateDisposable($barcode);
			if(!is_error($result)) {
			$insert = array(
				'uniacid' => $_W['uniacid'],
				'acid' => $acid,
				'qrcid' => $barcode['action_info']['scene']['scene_id'],
				'keyword' => $keyword,
				'name' => 'redcode',
				'model' => '1',
				'ticket' => $result['ticket'],
				'url' => $result['url'],
				'expire' => $result['expire_seconds'],
				'createtime' => TIMESTAMP,
				'status' => '1',
				'pici' => $pici,
			);
			$result = pdo_insert('qrcode', $insert);
			if($result){
				pdo_query('update ' . tablename('n1ce_red_code') . ' set iscqr = 2 where uniacid = :uniacid and code = :code and pici = :pici', array(':uniacid' => $_W['uniacid'],':code' => $keyword,':pici' => $pici));
			}
			}
			
		}
		$res2 = pdo_fetchall('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and status = 1 and iscqr = 1 and pici = :pici', array(':uniacid' => $_W['uniacid'],':pici' => $pici));
		if($res2){
			message('请勿刷新，二维码继续生成中', $this->createWebUrl('Qrcode',array('pici' => $pici)), 'success');
		}else{
			message('恭喜，生成带参数二维码成功！', $this->createWebUrl('code'), 'success');
		}
		
		
	}
	public function doWebQrcode2() {
		global $_GPC, $_W;
		checklogin();
		load()->model('account');
		load()->func('communication');
		$acidarr = uni_accounts($_W['uniacid']);
		$acid = intval($_W['acid']);
		$pici = $_GPC['pici'];
		$uniacccount = WeAccount::create($acid);
		//$scene_str = trim($_GPC['scene_str']) ? trim($_GPC['scene_str'])  : message('场景值不能为空');
		$ishave = pdo_fetchall('select * from ' . tablename('qrcode') . ' where qrcid = :qrcid and uniacid = :uniacid', array(':qrcid' => '10000000' ,':uniacid' => $_W['uniacid']));
		if(empty($ishave)){
			$insert = array(
				'uniacid' => $_W['uniacid'],
				'acid' => $acid,
				'qrcid' => '10000000',
				'keyword' => 'redcode',
				'name' => 'redcode',
				'model' => '1',
				'createtime' => TIMESTAMP,
				'status' => '1',
				'make' => '2',
				'pici' => '0',
			);
			pdo_insert('qrcode', $insert);
		}
		$res = pdo_fetchall('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and status = 1 and pici = :pici and iscqr = 1 limit 50', array(':uniacid' => $_W['uniacid'], ':pici' => $pici));
		foreach($res as $key => $vol){
			$keyword = $vol['code'];
			$qrcid = pdo_fetch("SELECT max(qrcid) FROM ".tablename('qrcode')." WHERE model = 1 or model = 2 and name = :name", array(':acid' => $acid,':name' => 'redcode'));
			//$barcode['action_info']['scene']['scene_id'] = !empty($qrcid) ? ($qrcid+1) : 10000001;
			$barcode['action_info']['scene']['scene_str'] = $this->createNonceStr(8);
			$barcode['action_name'] = 'QR_LIMIT_STR_SCENE';
			$result = $uniacccount->barCodeCreateFixed($barcode);
			if(!is_error($result)) {
			$insert = array(
				'uniacid' => $_W['uniacid'],
				'acid' => $acid,
				'qrcid' => !empty($qrcid['max(qrcid)']) ? ($qrcid['max(qrcid)']+1) : 10000001,
				'scene_str' => $barcode['action_info']['scene']['scene_str'],
				'keyword' => $keyword,
				'name' => 'redcode',
				'model' => '2',
				'ticket' => $result['ticket'],
				'url' => $result['url'],
				'expire' => $result['expire_seconds'],
				'createtime' => TIMESTAMP,
				'status' => '1',
				'make' => '2',
				'type' => 'scene',
				'pici' => $pici,
			);
			$result = pdo_insert('qrcode', $insert);
			if($result){
				pdo_query('update ' . tablename('n1ce_red_code') . ' set iscqr = 2 where uniacid = :uniacid and code = :code and pici = :pici', array(':uniacid' => $_W['uniacid'],':code' => $keyword,':pici' => $pici));
			}
			}
			
		}
		$res2 = pdo_fetchall('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and status = 1 and iscqr = 1 and pici = :pici', array(':uniacid' => $_W['uniacid'] , ':pici' => $pici));
		if($res2){
			message('请勿刷新，二维码继续生成中', $this->createWebUrl('Qrcode2',array('pici' => $pici)), 'success');
		}else{
			message('恭喜，生成带参数二维码成功！', $this->createWebUrl('code'), 'success');
		}
		
		
	}
	//路径声明
	private $qrcode = "../addons/n1ce_redcode/qrcode/redcode#sid#.png";
	public function doWebDown(){
		global $_W,$_GPC;
		include "phpqrcode.php";/*引入PHP QR库文件*/
		$rid = $_W['uniacid'];
		$acid = intval($_W['acid']);
		$wheresql = " WHERE uniacid = {$_W['uniacid']}";
		if($acid > 0) {
		$wheresql .= " AND acid = {$acid} ";
		}
		$wheresql .= " AND model = 1";
		$wheresql .= " AND make = 1";
		$wheresql .= " AND redcode = 1";
		$wheresql .= " AND qrcid > 10000000";
		pdo_query('update ' . tablename('qrcode') . ' set make = 1 where uniacid = :uniacid and model = 1 and redcode = 1 and qrcid > 10000000', array(':uniacid' => $_W['uniacid']));
		$scenes = pdo_fetchall("SELECT * FROM ".tablename('qrcode'). $wheresql . ' ORDER BY createtime DESC ');
			if (!empty($scenes)){//已生成过二维码的 直接取出
				foreach ($scenes as $value) {
					$this->createQrcode($value['url'],$value['qrcid']."_{$rid}");
				}
			}
			$qrs = '';
			foreach($scenes as $val){
				$qrs .= str_replace('#sid#',$val['qrcid']."_{$rid}",$this->qrcode).",";
			}
			//打包下载
			include 'pclzip.lib.php';
			$archive = new PclZip("qrcode{$rid}.zip");
			$v_list = $archive->create($qrs,PCLZIP_OPT_REMOVE_ALL_PATH);
			$fileres = file_get_contents("qrcode{$rid}.zip");
			header('Content-type: x-zip-compressed');
			header("Content-Type:application/download");
			header('Content-Disposition:attachment;filename="二维码_'.$rid.'.zip"');
			echo $fileres;
			@unlink($fileres);
		
	}
	public function doWebNewdown(){
		global $_W,$_GPC;
		include "phpqrcode.php";/*引入PHP QR库文件*/
		$rid = $_W['uniacid'];
		$pici = $_GPC['pici'];
		$acid = intval($_W['acid']);
		$wheresql = " WHERE uniacid = {$_W['uniacid']}";
		if($acid > 0) {
		$wheresql .= " AND acid = {$acid} ";
		}
		$wheresql .= " AND pici = {$pici} ";
		$wheresql .= " AND model = 2";
		$wheresql .= " AND make = 1";
		$wheresql .= " AND redcode = 1";
		$wheresql .= " AND qrcid > 10000000";
		$scenes = pdo_fetchall("SELECT * FROM ".tablename('qrcode'). $wheresql . ' ORDER BY createtime DESC ');
		pdo_query('update ' . tablename('qrcode') . ' set make = 1 where uniacid = :uniacid and model = 2 and redcode = 1 and qrcid > 10000000', array(':uniacid' => $_W['uniacid']));
		$scenes = pdo_fetchall("SELECT * FROM ".tablename('qrcode'). $wheresql . ' ORDER BY createtime DESC ');
			if (!empty($scenes)){//已生成过二维码的 直接取出
				foreach ($scenes as $value) {
					$this->createQrcode($value['url'],$value['qrcid']."_{$rid}");
				}
			}
			$qrs = '';
			foreach($scenes as $val){
				$qrs .= str_replace('#sid#',$val['qrcid']."_{$rid}",$this->qrcode).",";
			}
			//打包下载
			include 'pclzip.lib.php';
			$archive = new PclZip("qrcode{$rid}.zip");
			$v_list = $archive->create($qrs,PCLZIP_OPT_REMOVE_ALL_PATH);
			$fileres = file_get_contents("qrcode{$rid}.zip");
			header('Content-type: x-zip-compressed');
			header("Content-Type:application/download");
			header('Content-Disposition:attachment;filename="二维码_'.$rid.'.zip"');
			echo $fileres;
			@unlink($fileres);
		
	}
	public function doWebDown2(){
		global $_W,$_GPC;
		include "phpqrcode.php";/*引入PHP QR库文件*/
		$rid = $_W['uniacid'];
		$acid = intval($_W['acid']);
		$wheresql = " WHERE uniacid = {$_W['uniacid']}";
		if($acid > 0) {
		$wheresql .= " AND acid = {$acid} ";
		}
		$wheresql .= " AND redcode = 1";
		$wheresql .= " AND model = 2";
		$wheresql .= " AND qrcid > 10000000";
		$scenes = pdo_fetchall("SELECT * FROM ".tablename('qrcode'). $wheresql . ' ORDER BY createtime DESC ');
			if (!empty($scenes)){//已生成过二维码的 直接取出
				foreach ($scenes as $value) {
					$this->createQrcode($value['url'],$value['scene_str']."_{$rid}");
				}
			}
			$qrs = '';
			foreach($scenes as $val){
				$qrs .= str_replace('#sid#',$val['scene_str']."_{$rid}",$this->qrcode).",";
			}
			//打包下载
			include 'pclzip.lib.php';
			$archive = new PclZip("qrcode{$rid}.zip");
			$v_list = $archive->create($qrs,PCLZIP_OPT_REMOVE_ALL_PATH);
			$fileres = file_get_contents("qrcode{$rid}.zip");
			header('Content-type: x-zip-compressed');
			header("Content-Type:application/download");
			header('Content-Disposition:attachment;filename="二维码_'.$rid.'.zip"');
			echo $fileres;
			@unlink($fileres);
		
	}
	/*
	public function getMenus() {
        $menus = array(
				array(
					'title' => '验证码生成',
					'url'   => $this->createWebUrl('code'),
					'icon'  => 'fa fa-calendar',
				),
				array(
					'title' => '二维码查看',
					'url'   => $this->createWebUrl('qrshow'),
					'icon'  => 'fa fa-qrcode',
				),
				array(
					'title' => '领取流水',
					'url'   => $this->createWebUrl('usershow'),
					'icon'  => 'fa fa-users',
				),
				array(
					'title' => '页面设置',
					'url'   => $this->createWebUrl('index'),
					'icon'  => 'fa fa-files-o',
				),
			);
			return $menus;
	}*/
	private function createQrcode($url,$sceneid){
		$qrcode = str_replace('#sid#',$sceneid,$this->qrcode);
		if (!file_exists($qrcode)){
			//二维码图片不存在的 重新生成
			$errorCorrectionLevel = "L";
			$matrixPointSize = "8";
			QRcode::png($url, $qrcode, $errorCorrectionLevel, $matrixPointSize);
		}
	}
	private function get_rand($proArr)
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
	private function sendText($openid,$txt){
		global $_W;
		$acid=pdo_fetchcolumn("SELECT acid FROM ".tablename('account')." WHERE uniacid=:uniacid ",array(':uniacid'=>$_W['uniacid']));
		$acc = WeAccount::create($acid);
		$data = $acc->sendCustomNotice(array('touser'=>$openid,'msgtype'=>'text','text'=>array('content'=>urlencode($txt))));
		return $data;
	}
	public function getCard($card_id,$openid){
        global $_W,$_GPC;
	    //获取access_token
	    load()->classs('weixin.account');
		load()->func('communication');
		$access_token = WeAccount::token();
	    $ticket = $this->getApiTicket($access_token);
	 
	    //获得ticket后将参数拼成字符串进行sha1加密
		$now = time();
		$timestamp = $now;
		$nonceStr = $this->createNonceStr();
		$card_id = $card_id;
		$openid = $openid;
		$arr = array($card_id,$ticket,$nonceStr,$openid,$timestamp);//组装参数
        asort($arr, SORT_STRING);
		$sortString = "";
		 foreach($arr as $temp){
			$sortString = $sortString.$temp;
		 }
		$signature = sha1($sortString);
		 $cardArry = array(
			'code' =>"",
			'openid' => $openid,
			'timestamp' => $now,
			'signature' => $signature,
			'cardId' => $card_id,
			'ticket' => $ticket,
			'nonceStr' => $nonceStr,
		 );
		return $cardArry;
  
  }
	
	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
			$str.= substr($chars, mt_rand(0, strlen($chars) - 1) , 1);
		}
		return $str;
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
		return $res;
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
	//模板消息提醒
	public function sendtpl($openid, $url, $template_id, $content) {

		global $_GPC, $_W;
		load() -> classs('weixin.account');
		load() -> func('communication');
		$obj = new WeiXinAccount();
		$access_token = $obj -> fetch_available_token();
		$data = array('touser' => $openid, 'template_id' => $template_id, 'url' => $url, 'topcolor' => "#FF0000", 'data' => $content, );
		$json = json_encode($data);
		$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access_token;
		$ret = ihttp_post($url, $json);
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