<?php
/**
 * 我的足迹
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


$condition = " b.uniacid=:uniacid AND b.uid=:uid ";
$params[':uniacid'] = $uniacid;
$params[':uid'] = $uid;

$lessonlist = pdo_fetchall("SELECT a.id,a.bookname,a.images,a.price,a.buynum+a.virtual_buynum AS buynum, b.addtime FROM " . tablename($this->table_lesson_parent) . " a LEFT JOIN " .tablename($this->table_lesson_history). " b ON a.id=b.lessonid WHERE {$condition} ORDER BY b.addtime DESC  LIMIT " . ($pindex-1) * $psize . ',' . $psize, $params);
foreach($lessonlist as $key=>$value){
	$lessonlist[$key]['addtime'] = date('Y-m-d H:i', $value['addtime']);
	$lessonlist[$key]['seccount'] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_lesson_son) . " WHERE  parentid=:parentid", array(':parentid'=>$value['id']));
	$lessonlist[$key]['price'] = $value['price']>0 ? "¥".$value['price'] : "免费";
}



if($op=='ajaxgetlist'){
	echo json_encode($lessonlist);
}else{
	$title = '我的足迹';
	include $this->template('history');
}

?>