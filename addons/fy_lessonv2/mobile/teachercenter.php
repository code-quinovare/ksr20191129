<?php
/**
 * 讲师中心
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */
 
checkauth();
$uid = $_W['member']['uid'];

$teacher = pdo_fetch("SELECT a.*,b.avatar,b.nickname FROM " .tablename($this->table_teacher). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE a.uid=:uid", array(':uid'=>$uid));
if($op=='display'){
	$title = "讲师个人中心";
	
	if(empty($teacher)){
		if($setting['teacher_income']==0){
			message("系统没有开启讲师入驻！", "", "warning");
		}else{
			header("Location:".$this->createMobileUrl('applyteacher'));
		}
	}

	$member = pdo_fetch("SELECT a.*,b.avatar,b.nickname AS mc_nickname FROM " .tablename($this->table_member). " a LEFT JOIN ".tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE a.uniacid=:uniacid AND a.uid=:uid", array(':uniacid'=>$uniacid,':uid'=>$uid));
	if(empty($member['avatar'])){
		$avatar = MODULE_URL."template/mobile/images/default_avatar.jpg";
	}else{
		$inc = strstr($member['avatar'], "http://");
		$avatar = $inc ? $member['avatar'].".jpg" : $_W['attachurl'].$member['avatar'];
	}

	/* 我的课程 */
	$mylessoncount = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_lesson_parent) . " WHERE uniacid=:uniacid AND teacherid=:teacherid ", array(':uniacid'=>$uniacid, ':teacherid'=>$teacher['id']));

	include $this->template('teachercenter');

}elseif($op=='account'){
	$title = "讲师平台帐号管理";

	if(checksubmit('submit')){
		$account = trim($_GPC['account']);
		$password = $_GPC['password'];
		if(empty($teacher['account']) && (strlen($account)<6 || strlen($account)>16)){
			message("登陆账号长度必须介于6~16位", $this->createMobileUrl('teachercenter', array('op'=>'account')), "error");
		}
		if(strlen($password)<6 || strlen($password)>16){
			message("登陆密码长度必须介于6~16位", $this->createMobileUrl('teachercenter', array('op'=>'account')), "error");
		}

		$isExist = pdo_fetch("SELECT id FROM " .tablename($this->table_teacher). " WHERE uniacid=:uniacid AND account=:account LIMIT 1", array(':uniacid'=>$uniacid, ':account'=>$account));
		if($isExist && $account!=$teacher['account']){
			message("该登录帐号已被占用，请重新输入登录帐号", $this->createMobileUrl('teachercenter', array('op'=>'account')), "error");
		}

		$update = array('password'=>md5($password.$_W['config']['setting']['authkey']));
		if(empty($teacher['account'])){
			$update['account'] = $account;
		}

		$res = pdo_update($this->table_teacher, $update, array('uniacid'=>$uniacid,'uid'=>$uid));
		if($res){
			message("保存成功", $this->createMobileUrl('teachercenter'), "success");
		}else{
			message("保存失败", $this->createMobileUrl('teachercenter', array('op'=>'account')), "error");
		}
	}

	include $this->template('teacheraccount');
}
	

?>