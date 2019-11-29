<?php
/**
 * 收藏课程/讲师
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */
checkauth();

$ctype = intval($_GPC['ctype']); /* 收藏类型 */
$uid = $_W['member']['uid'];

$pindex =max(1,$_GPC['page']);
$psize = 10;

$condition = " b.uniacid=:uniacid AND b.uid=:uid ";
$params[':uniacid'] = $uniacid;
$params[':uid'] = $uid;

if($ctype==1){
	$title = '我收藏的课程';
	$condition .= "  AND b.ctype=:ctype ";
	$params[':ctype'] = 1;
	
	$lessonlist = pdo_fetchall("SELECT a.id,a.bookname,a.images,a.price,a.buynum,a.virtual_buynum FROM " . tablename($this->table_lesson_parent) . " a LEFT JOIN " .tablename($this->table_lesson_collect). " b ON a.id=b.outid WHERE {$condition} ORDER BY b.addtime DESC  LIMIT " . ($pindex-1) * $psize . ',' . $psize, $params);
	foreach($lessonlist as $key=>$value){
		$lessonlist[$key]['price'] = $value['price']>0 ? "¥".$value['price'] : '免费';
		$lessonlist[$key]['seccount'] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_lesson_son) . " WHERE parentid=:parentid", array(':parentid'=>$value['id']));
		if($value['price']>0){
			$lessonlist[$key]['buynum_total'] = $value['buynum'] + $value['virtual_buynum'];
		}else{
			$lessonlist[$key]['buynum_total'] = $value['buynum'] + $value['virtual_buynum'] + $value['visit_number'];
		}
	}

}elseif($ctype==2){
	$title = '我收藏的讲师';
	$condition .= "  AND b.ctype=:ctype ";
	$params[':ctype'] = 2;
	
	$teacherlist = pdo_fetchall("SELECT a.id,a.teacher,a.teacherdes,a.teacherphoto FROM " . tablename($this->table_teacher) . " a LEFT JOIN " .tablename($this->table_lesson_collect). " b ON a.id=b.outid WHERE {$condition} ORDER BY b.addtime DESC  LIMIT " . ($pindex-1) * $psize . ',' . $psize, $params);
	foreach($teacherlist as $key=>$value){
		$teacherlist[$key]['teacherdes'] = strip_tags(htmlspecialchars_decode($value['teacherdes']));
	}
}

if($op=='ajaxgetlesson'){
	echo json_encode($lessonlist);
}elseif($op=='ajaxgetteacher'){
	echo json_encode($teacherlist);
}else{
	include $this->template('collect');
}

?>