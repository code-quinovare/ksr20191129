<?php
/**
 * 分销中心
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */

checkauth();
$uid = $_W['member']['uid'];

if($comsetting['is_sale']==0){
	message("系统未开启该功能", $this->createMobileUrl('index'), "warning");
}

$member = pdo_fetch("SELECT a.*,b.nickname,b.avatar FROM " .tablename($this->table_member). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE a.uid=:uid", array(':uid'=>$uid));

/* 已购买VIP等级 */
$memberVip = pdo_fetchall("SELECT * FROM " .tablename($this->table_member_vip). " WHERE uid=:uid AND validity>:validity", array(':uid'=>$uid,':validity'=>time()));
if($comsetting['sale_rank']==2 && empty($memberVip)){
	message("您不是VIP会员，无法访问该功能", $this->createMobileUrl('index'), "warning");
}
if($member['status']!=1){
	message("您的身份未激活，无法访问该功能", $this->createMobileUrl('index'), "warning");
}
$cash_lower = empty($memberVip) ? $comsetting['cash_lower_common'] : $comsetting['cash_lower_vip'];

/* 粉丝信息 */
$fans = pdo_fetch("SELECT follow FROM " .tablename($this->table_fans). " WHERE uid=:uid", array(':uid'=>$uid));

if(empty($member['avatar'])){
	$avatar = MODULE_URL."template/mobile/images/default_avatar.jpg";
}else{
	$inc = strstr($member['avatar'], "http://");
	$avatar = $inc ? $member['avatar'] : $_W['attachurl'].$member['avatar'];
}

if($op=='display'){
	$title = $font['sale_center'] ? $font['sale_center'] : "分销中心";
	
	/* 检查是否在微信中访问 */
	$userAgent = $this->checkUserAgent();
	
	/* 如果存在上级会员，则获取上级会员昵称 */
	if($member['parentid']>0){
		$parent = pdo_fetch("SELECT nickname FROM " .tablename($this->table_mc_members). " WHERE uid=:uid", array(':uid'=>$member['parentid']));
	}

	/* 如果存在分销级别，则获取分销级别名称 */
	$levelname = "默认级别";
	if($member['agent_level']>0){
		$level = pdo_fetch("SELECT levelname FROM " .tablename($this->table_commission_level). " WHERE id=:id", array(':id'=>$member['agent_level']));
		if(!empty($level)){
			$levelname = $level['levelname'];
		}
	}

	/* 计算我的团队成员数量 */
	$teamlist = pdo_fetchall("SELECT uid FROM " .tablename($this->table_member). " WHERE parentid=:uid", array(':uid'=>$uid));
	/* 一级会员人数 */
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_member). " WHERE parentid=:uid", array(':uid'=>$uid));

	/* 推广海报二维码 */
	$posterUrl = $this->createMobileUrl('qrcode');

	include $this->template('cindex');
}elseif($op=='commissionlog'){
	$pindex =max(1,$_GPC['page']);
	$psize = 10;

	$list = pdo_fetchall("SELECT * FROM " .tablename($this->table_commission_log). " WHERE uid=:uid ORDER BY id DESC LIMIT " . ($pindex-1) * $psize . ',' . $psize, array(':uid'=>$uid));

	$commossion_award = $font['commossion_award'] ? $font['commossion_award'] : '分销奖励';
	foreach($list as $key=>$value){
		$list[$key]['comtype'] = $value['grade']==-1 ? '管理员操作' : $commossion_award;
		$list[$key]['addtime'] = date("Y-m-d", $value['addtime']);
	}
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_commission_log). " WHERE uid=:uid", array(':uid'=>$uid));

	$title = $font['commission_log'] ? $font['commission_log']."(".$total.")" : "佣金明细(".$total.")";

	if(!$_W['isajax']){
		include $this->template('commissionlog');
	}else{
		echo json_encode($list);
	}
}elseif($op=='cashlog'){
	$pindex =max(1,$_GPC['page']);
	$psize = 10;

	$list = pdo_fetchall("SELECT * FROM " .tablename($this->table_cashlog). " WHERE uid=:uid AND lesson_type=:lesson_type ORDER BY id DESC LIMIT " . ($pindex-1) * $psize . ',' . $psize, array(':uid'=>$uid,':lesson_type'=>1));
	foreach($list as $key=>$value){
		if($value['cash_way']==1){
			$list[$key]['cash_way'] = '帐户余额';
		}elseif($value['cash_way']==2){
			$list[$key]['cash_way'] = '微信钱包';
		}elseif($value['cash_way']==3){
			$list[$key]['cash_way'] = '支付宝';
		}

		if($value['status']==0){
			$list[$key]['statu'] = "待打款";
		}elseif($value['status']==1){
			$list[$key]['statu'] = "已打款";
		}elseif($value['status']==-1){
			$list[$key]['statu'] = "无效佣金";
		}
		$list[$key]['remark'] = $value['remark']?$value['remark']:"";
		$list[$key]['addtime'] = date("Y-m-d", $value['addtime']);
	}
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_cashlog). " WHERE uid=:uid AND lesson_type=:lesson_type", array(':uid'=>$uid,':lesson_type'=>1));

	$title = $font['commossion_cash_log'] ? $font['commossion_cash_log']."(".$total.")" : "佣金提现明细(".$total.")";

	if(!$_W['isajax']){
		include $this->template('cashlog');
	}else{
		echo json_encode($list);
	}
}elseif($op=='cash'){
	$title = $font['commission_cash'] ? $font['commission_cash'] : "佣金提现";
	$setting_cashway = unserialize($comsetting['cash_way']);

	if($member['nopay_commission'] < $cash_lower){
		message("当前提现最低额度为{$cash_lower}元，您的可提现额度不够", "", "warning");
	}

	$lastcashlog = pdo_fetch("SELECT pay_account FROM " .tablename($this->table_cashlog). " WHERE uniacid=:uniacid AND uid=:uid AND cash_way=3 ORDER BY id DESC LIMIT 1", array(':uniacid'=>$uniacid, ':uid'=>$uid));

	if(checksubmit('submit')){
		$cash_way = intval($_GPC['cash_way']); //1.提现到余额  2.提现到微信钱包  3.提现到支付宝
		$cash_num = floatval($_GPC['cash_num']);
		$pay_account = trim($_GPC['pay_account']);
		
		if(empty($cash_way)){
			message("请选择提现方式", $this->createMobileUrl('commission', array('op'=>'cash')), "error");
		}
		if($cash_way==3 && empty($pay_account)){
			message("请输入提现帐号", $this->createMobileUrl('commission', array('op'=>'cash')), "error");
		}
		if($cash_num > $member['nopay_commission']){
			message("您的可提现佣金额度为{$member['nopay_commission']}元", $this->createMobileUrl('commission', array('op'=>'cash')), "error");
		}
		if($cash_num < $cash_lower){
			message("当前系统最低提现额度为{$cash_lower}元", $this->createMobileUrl('commission', array('op'=>'cash')), "error");
		}
		/*当前登录会员关联的粉丝*/
		$fans = pdo_fetch("SELECT openid FROM " .tablename($this->table_fans). " WHERE uid=:uid", array(':uid'=>$uid));
		if($cash_way==2 && empty($fans['openid'])){
			message("当前帐号未关联微信，无法提现到微信钱包", $this->createMobileUrl('commission', array('op'=>'cash')), "error");
		}

		/**
		 * 减少会员可提现佣金和增加会员已提现佣金
		 */
		$upmember = array(
			'nopay_commission'	=> $member['nopay_commission'] - $cash_num,
			'pay_commission'	=> $member['pay_commission'] + $cash_num,
		);
		$succ = pdo_update($this->table_member, $upmember, array('id'=>$member['id']));

		if($succ){
			$cashlog = array(
				'uniacid'	  => $uniacid,
				'cash_way'	  => $cash_way, //1.提现到余额  2.提现到微信钱包 3.支付宝
				'pay_account' => $pay_account,
				'uid'		  => $uid,
				'openid'	  => $fans['openid'],
				'cash_num'    => $cash_num,
				'lesson_type' => 1, /* 提现类型 1.分销佣金提现 2.课程收入提现 */
				'addtime'	  => time(),
			);
			
			if($cash_way==1){
				$cashlog['cash_type'] = 2; //提现到余额默认为自动到账
			}elseif($cash_way==3){
				$cashlog['cash_type'] = 1; //提现到支付宝默认为管理员审核
			}else{
				$cashlog['cash_type'] = $comsetting['cash_type'];
			}

			if($cash_way==1){/*  1.提现到余额 */
				load()->model('mc');
				$result = mc_credit_update($uid, 'credit2', $cash_num, array('1'=>'微课堂分销佣金提现'));

				if($result){
					$cashlog['status']       = 1;
					$cashlog['disposetime']  = time();
					$cashlog['remark']		 = "";

					pdo_insert($this->table_cashlog, $cashlog);
					message("提现成功，佣金已发放到您的账户余额！", $this->createMobileUrl('commission'), "success");
				}

			}elseif($cash_way==2 || $cash_way==3){/*  2.提现到微信钱包 3.提现到支付宝 */
				if($cashlog['cash_type']==1){ /* 提现方式为管理员审核 */
					$cashlog['status'] = 0;
					pdo_insert($this->table_cashlog, $cashlog);

					/* 模版消息通知管理员 */
					if($cash_way==2){
						$cash_name = "微信钱包";
					}elseif($cash_way==3){
						$cash_name = "支付宝钱包";
					}
			
					$manage = explode(",", $setting['manageopenid']);
					$tplmessage = pdo_fetch("SELECT newcash FROM " .tablename($this->table_tplmessage). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));
					foreach($manage as $manageopenid){
						$sendneworder = array(
							'touser'      => $manageopenid,
							'template_id' => $tplmessage['newcash'],
							'url'         => "",
							'topcolor'    => "#7B68EE",
							'data'        => array(
								'first'=> array(
									'value' => "亲，您收到一条新的用户提现申请",
									'color' => "#428BCA",
								),
								'keyword1'  => array(
									'value' => $member['nickname'],
									'color' => "#428BCA",
								),
								'keyword2'  => array(
									'value' => date('Y-m-d H:i', time()),
									'color' => "#428BCA",
								),
								'keyword3'  => array(
									'value' => $cash_num."元",
									'color' => "#428BCA",
								),
								'keyword4'  => array(
									'value' => $cash_name,
									'color' => "#428BCA",
								),
								'remark'	=> array(
									'value' => "详情请登录网站后台查看！",
									'color' => "#222222",
								),
							)
						);
						$this->send_template_message(urldecode(json_encode($sendneworder)),$viporder['acid']);
					}

					message("提交申请成功，请等待管理员审核！", $this->createMobileUrl('commission'), "success");
				}elseif($comsetting['cash_type']==2){ /* 提现方式为自动提现到微信零钱钱包 */
					$post = array('total_amount'=>$cash_num, 'desc'=>'用户申请微课堂佣金提现');
					$fans = array('openid'=>$fans['openid'], 'nickname'=>$member['nickname']);
					$result = $this->companyPay($post,$fans);

					if($result['result_code']=='SUCCESS'){
						$cashlog['status']           = 1;
						$cashlog['disposetime']      = strtotime($result['payment_time']);
						$cashlog['partner_trade_no'] = $result['partner_trade_no'];
						$cashlog['payment_no']	     = $result['payment_no'];
						$cashlog['remark']			 = "";

						pdo_insert($this->table_cashlog, $cashlog);
						message("提现成功，佣金已发放到您的微信钱包！", $this->createMobileUrl('commission'), "success");

					}else{
						/*回滚操作*/
						$rollback = array(
							'nopay_commission'	=> $member['nopay_commission'],
							'pay_commission'	=> $member['pay_commission'],
						);
						pdo_update($this->table_member, $rollback, array('id'=>$member['id']));
						
						message($result['return_msg'], $this->createMobileUrl("commission",array('op'=>'cash')), "error");
					}
				}
			}
		}

	}

	include $this->template('cash');
}

?>