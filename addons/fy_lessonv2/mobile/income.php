<?php
/**
 * 讲师收入明细
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */

checkauth();
$uid = $_W['member']['uid'];

$pindex =max(1,$_GPC['page']);
$psize = 10;

$list = pdo_fetchall("SELECT * FROM " .tablename($this->table_teacher_income). " WHERE uniacid=:uniacid AND uid=:uid ORDER BY id DESC LIMIT " . ($pindex-1) * $psize . ',' . $psize, array(':uniacid'=>$uniacid, ':uid'=>$uid));
foreach($list as $key=>$value){
	$list[$key]['remark']  = "课程价格：".$value['orderprice']."元，收入提成：".$value['teacher_income']."%";
	$list[$key]['addtime'] = date("Y-m-d", $value['addtime']);
}
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_teacher_income). " WHERE uniacid=:uniacid AND uid=:uid", array(':uniacid'=>$uniacid, ':uid'=>$uid));

$title = "我的收入明细(".$total.")";

if(!$_W['isajax']){
	include $this->template('incomelog');
}else{
	echo json_encode($list);
}


?>