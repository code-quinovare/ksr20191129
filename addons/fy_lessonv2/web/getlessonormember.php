<?php
/**
 * 查找课程或会员
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 * ============================================================================
 */

$op = $_GPC['op'];
if($op=='getLesson'){
	$uniacid = intval($_GPC['uniacid']);
	$keyword = trim($_GPC['keyword']);

	$condition = " uniacid=:uniacid ";
	$param[':uniacid'] = $uniacid;
	if(!empty($keyword)){
		$condition .= " AND bookname LIKE :keyword ";
		$param[':keyword'] = "%".$keyword."%";
	}

	$list = pdo_fetchall("SELECT id,bookname,price,teacher_income,images,validity FROM " .tablename($this->table_lesson_parent). " WHERE {$condition}", $param);

	include $this->template('getLesson');
}elseif($op=='getMember'){
	$uniacid = intval($_GPC['uniacid']);
	$keyword = trim($_GPC['keyword']);

	$condition = " a.uniacid=:uniacid ";
	$param[':uniacid'] = $uniacid;
	if(!empty($keyword)){
		$condition .= " AND (b.nickname LIKE :keyword OR b.realname LIKE :keyword OR b.mobile LIKE :keyword OR b.uid=:uid ) ";
		$param[':keyword'] = "%".$keyword."%";
		$param[':uid'] = $keyword;
	}

	$list = pdo_fetchall("SELECT b.uid,b.mobile,b.nickname,b.realname,b.avatar FROM " .tablename($this->table_member). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE {$condition} ORDER BY uid ASC", $param);
	foreach($list as $k=>$v){
		if(empty($v['avatar'])){
			$list[$k]['avatar'] = MODULE_URL."template/mobile/images/default_avatar.jpg";
		}else{
			$list[$k]['avatar'] = strstr($v['avatar'], "http://") ? $v['avatar'] : $_W['attachurl'].$v['avatar'];
		}
	}

	include $this->template('getMember');
}

?>