<?php
/**
 * 讲师列表
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */
 
$this->setParentId(intval($_GPC['uid']));

$pindex =max(1,$_GPC['page']);
$psize = 10;

$condition = " uniacid=:uniacid AND status=:status ";
$params[':uniacid'] = $uniacid;
$params[':status']  = 1;

$keyword = trim($_GPC['keyword']);
if(!empty($keyword)){
	$condition .= " AND teacher LIKE :teacher ";
	$params[':teacher'] = "%{$keyword}%";
}
$teacherlist = pdo_fetchall("SELECT id,teacher,teacherdes,teacherphoto FROM " .tablename($this->table_teacher). " WHERE {$condition} ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex-1) * $psize . ',' . $psize, $params);
foreach($teacherlist as $key=>$value){
	$teacherlist[$key]['teacherdes'] = strip_tags(htmlspecialchars_decode($value['teacherdes']));
	$teacherlist[$key]['lessonCount'] = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_lesson_parent). " WHERE teacherid=:teacherid AND status=:status", array(':teacherid'=>$value['id'], ':status'=>1));
}
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_teacher) . " WHERE {$condition} ", $params);

if($op=='display'){
	$title = "讲师列表";

	include $this->template('teacherlist');
}elseif($op=='ajaxgetteacherlist'){
	echo json_encode($teacherlist);
}

?>