<?php
/**
 * 我的团队
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */
 
checkauth();
$uid = $_W['member']['uid'];

$mid   = intval($_GPC['mid']);
$level = $_GPC['level']?intval($_GPC['level']):'1';
$title = $font['my_team'] ? $font['my_team'] : "我的团队";

$pindex =max(1,$_GPC['page']);
$psize = 10;

$userid = $mid ? $mid : $uid;
$member = pdo_fetch("SELECT nickname FROM " .tablename($this->table_mc_members). " WHERE uid=:uid", array(':uid'=>$userid));

$teamlist = pdo_fetchall("SELECT a.uid,a.nopay_commission+a.pay_commission AS commission,a.addtime, b.nickname,b.avatar FROM " .tablename($this->table_member). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE a.parentid=:parentid ORDER BY a.id DESC LIMIT " . ($pindex-1) * $psize . ',' . $psize, array(':parentid'=>$userid));
/* 一级会员人数 */
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_member). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE a.parentid=:parentid", array(':parentid'=>$userid));

foreach($teamlist as $k1=>$v1){
	$direct2 = pdo_fetchall("SELECT uid FROM " .tablename($this->table_member). " WHERE parentid=:parentid", array(':parentid'=>$v1['uid']));
	/* 二级会员人数 */
	$direct2_num = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_member). " WHERE parentid=:parentid", array(':parentid'=>$v1['uid']));
	
	$teamlist[$k1]['recnum']  = $direct2_num;
	$teamlist[$k1]['addtime'] = date('Y-m-d', $v1['addtime']);
	
	if(empty($v1['avatar'])){
		$teamlist[$k1]['avatar'] = MODULE_URL."template/mobile/images/default_avatar.jpg";
	}else{
		$inc = strstr($v1['avatar'], "http://");
		$teamlist[$k1]['avatar'] = $inc ? $v1['avatar'] : $_W['attachurl'].$v1['avatar'];
	}
}


$sontitle = $level==1?"我的团队成员({$total})":"[".$member['nickname']."]的团队成员({$total})";

if(!$_W['isajax']){
	include $this->template('team');
}else{
	echo json_encode($teamlist);
}


?>