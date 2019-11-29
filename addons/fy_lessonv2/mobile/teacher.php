<?php
/**
 * 讲师课程
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */
 
$this->setParentId(intval($_GPC['uid']));
checkauth();
$uid = $_W['member']['uid'];

$teacherid = intval($_GPC['teacherid']);/* 讲师id */

/* 讲师信息 */
$teacher = pdo_fetch("SELECT * FROM " .tablename($this->table_teacher). " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$uniacid, ':id'=>$teacherid));
if(empty($teacher)){
	message("该讲师不存在或已被删除！", "", "error");
}

/* 判断当前用户是否为讲师 */
if($uid==$teacher['uid']){
	$teacherself = true;
}

/* 查询是否收藏该课程 */
$collect = pdo_fetch("SELECT * FROM " .tablename($this->table_lesson_collect). " WHERE uniacid=:uniacid AND uid=:uid AND outid=:outid AND ctype=:ctype LIMIT 1", array(':uniacid'=>$uniacid,':uid'=>$uid,':outid'=>$teacherid,':ctype'=>2));

$pindex =max(1,$_GPC['page']);
$psize = 10;

/* 讲师名下课程列表 */
$condition = " b.uniacid=:uniacid AND b.id=:id AND a.status=:status ";
$params[':uniacid'] = $uniacid;
$params[':id'] = $teacherid;
$params[':status'] = 1;

$lesson_list = pdo_fetchall("SELECT a.*,b.teacher,b.teacherphoto,b.teacherdes FROM " .tablename($this->table_lesson_parent). " a LEFT JOIN " .tablename($this->table_teacher). " b ON a.teacherid=b.id WHERE {$condition} ORDER BY a.displayorder DESC,a.addtime DESC LIMIT " . ($pindex-1) * $psize . ',' . $psize, $params);

$student_num = 0;
foreach($lesson_list as $key=>$value){
	if($value['price']>0){
		$student_num += $value['virtual_buynum']+$value['buynum'];
	}else{
		$student_num += $value['virtual_buynum']+$value['buynum'] + $value['visit_number'];
	}
	$lesson_list[$key]['price'] = $value['price']>0 ? "¥".$value['price'] : '免费';
	if($value['price']>0){
		$lesson_list[$key]['virtualandbuynum'] = $value['virtual_buynum'] + $value['buynum'];
	}else{
		$lesson_list[$key]['virtualandbuynum'] = $value['virtual_buynum'] + $value['buynum'] + $value['visit_number'];
	}
	$lesson_list[$key]['seccount'] = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_lesson_son). " WHERE parentid=:parentid AND status=:status", array(':parentid'=>$value['id'],':status'=>1));
}

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_lesson_parent). " a LEFT JOIN " .tablename($this->table_teacher). " b ON a.teacherid=b.id WHERE {$condition}", $params);

if($op=='display'){
	$title = $teacher['teacher']."讲师主页";

	/* 分享信息 */
	$shareurl = $_W['siteroot'] .'app/'. $this->createMobileUrl('teacher', array('teacherid'=>$teacherid,'uid'=>$uid));
	$shareteacher = unserialize($comsetting['shareteacher']);
	$shareteacher['title'] = $shareteacher['title']?str_replace("【讲师名称】","[".$teacher['teacher']."]",$shareteacher['title']):substr(strip_tags(htmlspecialchars_decode($teacher['teacherdes'])), 0, 240);

	include $this->template('teacher');
}elseif($op=='ajaxgetlesson'){
	echo json_encode($lesson_list);
}

?>