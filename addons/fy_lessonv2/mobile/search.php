<?php
/**
 * 微课堂搜索页
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */

$login_visit = json_decode($setting['login_visit']);
if(!empty($login_visit) && in_array('search', $login_visit)){
	checkauth();
}

$pindex = max(1, intval($_GPC['page']));
$psize = 10;

/* 课程分类 */
$categorylist = pdo_fetchall("SELECT * FROM " . tablename($this -> table_category) . " WHERE uniacid=:uniacid AND parentid=:parentid ORDER BY displayorder DESC", array(':uniacid' => $uniacid, ':parentid' => 0));
foreach ($categorylist as $k => $v) {
	$categorylist[$k]['child'] = pdo_fetchall("SELECT * FROM " . tablename($this -> table_category) . " WHERE uniacid=:uniacid AND parentid=:parentid ORDER BY displayorder DESC", array(':uniacid' => $uniacid, ':parentid' => $v['id']));
}

if ($op != 'allcategory') {
	$keyword = trim($_GPC['keyword']);
	$cat_id = intval($_GPC['cat_id']);
	$sort = trim($_GPC['sort']);

	if (!empty($keyword)) {
		$title = '"' . $keyword . '"';
	} else {
		$title = '课程列表';
	}

	$condition = " a.uniacid = '{$uniacid}' AND a.status=1 ";
	$order = " ORDER BY a.displayorder DESC, a.id DESC ";

	if (!empty($keyword)) {
		$condition .= " AND (a.bookname LIKE '%{$keyword}%' OR b.teacher LIKE '%{$keyword}%') ";
	}
	if ($cat_id > 0) {
		$condition .= " AND (a.pid='{$cat_id}' OR a.cid='{$cat_id}')";
		$nowcat = pdo_fetch("SELECT name FROM " . tablename($this -> table_category) . " WHERE uniacid='{$uniacid}' AND id='{$cat_id}'");
		$catname = $nowcat['name'];
	} else {
		$catname = '全部分类';
	}

	if ($sort == 'free') {
		$condition .= " AND a.price=0";
		$sortname = '免费课程';
	} elseif ($sort == 'price') {
		$order = " ORDER BY a.price ASC, a.displayorder DESC ";
		$condition .= " AND a.price>0";
		$sortname = '价格优先';
	} elseif ($sort == 'hot') {
		$order = " ORDER BY (a.buynum+a.virtual_buynum) DESC, a.displayorder DESC ";
		$sortname = '人气优先';
	} elseif ($sort == 'score') {
		$order = " ORDER BY a.score DESC, a.displayorder DESC ";
		$sortname = '好评优先';
	} else {
		$sortname = '综合排序';
	}

	$list = pdo_fetchall("SELECT a.* FROM " . tablename($this -> table_lesson_parent) . " a LEFT JOIN " . tablename($this -> table_teacher) . " b ON a.teacherid=b.id WHERE {$condition} {$order} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	foreach ($list as $key => $value) {
		$list[$key]['soncount'] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this -> table_lesson_son) . " WHERE parentid=:parentid", array(':parentid'=>$value['id']));
		$list[$key]['price'] = $value['price']>0 ? "¥".$value['price'] : "免费";
		if($value['price']>0){
			$list[$key]['buyTotal'] = $value['buynum'] + $value['virtual_buynum'];
		}else{
			$list[$key]['buyTotal'] = $value['buynum'] + $value['virtual_buynum'] + $value['visit_number'];
		}
		if($value['score']>0){
			$list[$key]['score_rate'] = $value['score']*100;
		}else{
			$list[$key]['score_rate'] = "";
		}
	}

	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_lesson_parent) . " a LEFT JOIN " .tablename($this->table_teacher). " b ON a.teacherid=b.id WHERE {$condition} ");
	
}

if(!$_W['isajax']){
	include $this -> template('search');
}else{
	echo json_encode($list);
}

?>