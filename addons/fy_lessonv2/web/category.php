<?php
/**
 * 课程分类管理
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 * ============================================================================
 */
 
if ($operation == 'display') {
	if (checksubmit('submit')) { /* 排序 */
		if (is_array($_GPC['category'])) {
			foreach ($_GPC['category'] as $pid => $val) {
				$data = array('displayorder' => intval($_GPC['category'][$pid]));
				pdo_update($this->table_category, $data, array('id' => $pid));
			}
		}
		if (is_array($_GPC['son'])) {
			foreach ($_GPC['son'] as $sid => $val) {
				$data = array('displayorder' => intval($_GPC['son'][$sid]));
				pdo_update($this->table_category, $data, array('id' => $sid));
			}
		}
		message('操作成功!', referer, 'success');
	}

	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	
	$condition = " uniacid=:uniacid AND parentid=:parentid ";
	$params[':uniacid'] = $uniacid;
	$params[':parentid'] = 0;

	$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE {$condition} ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
	foreach($category as $k=>$v){
		$category[$k]['son'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE uniacid=:uniacid AND parentid=:parentid ORDER BY displayorder DESC, id DESC", array(':uniacid'=>$uniacid,':parentid'=>$v['id']));
	}

	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_category) . " WHERE {$condition}", $params);
	$pager = pagination($total, $pindex, $psize);

}elseif($operation == 'post') {
	$id = intval($_GPC['id']); /* 当前分类id */
	$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE uniacid=:uniacid AND parentid=:parentid ORDER BY displayorder DESC", array(':uniacid'=>$uniacid,':parentid'=>0));

	if (!empty($id)) {
		$category = pdo_fetch("SELECT * FROM " . tablename($this->table_category) . " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$uniacid,':id'=>$id));
		if(empty($category)){
			message("该分类不存在或已被删除！", "", "error");
		}
	}

	if (checksubmit('submit')) {
		if (empty($_GPC['catename'])) {
			message("抱歉，请输入分类名称！");
		}

		$data = array(
			'uniacid'      => $_W['uniacid'],
			'name'         => trim($_GPC['catename']),
			'ico'          => trim($_GPC['ico']),
			'parentid'     => intval($_GPC['parentid']),
			'displayorder' => intval($_GPC['displayorder']),
			'is_show'	   => intval($_GPC['is_show']),
			'link'		   => trim($_GPC['link']),
			'addtime'      => time(),
		);

		if (!empty($id)) {
			unset($data['addtime']);
			$res = pdo_update($this->table_category, $data, array('id' => $id));
			if($res){
				$this->addSysLog($_W['uid'], $_W['username'], 3, "课程分类", "编辑ID:{$id}的课程分类");
			}
		} else {
			pdo_insert($this->table_category, $data);
			$cid = pdo_insertid();
			if($cid){
				$this->addSysLog($_W['uid'], $_W['username'], 3, "课程分类", "新增ID:{$cid}的课程分类");
			}
		}
		message("更新分类成功！", $this->createWebUrl('category', array('op' => 'display')), "success");
	}

}elseif ($operation == 'delete') {
	$id = intval($_GPC['id']);
	$category = pdo_fetch("SELECT id, parentid FROM " . tablename($this->table_category) . " WHERE uniacid = '$uniacid' AND id = '{$id}'");
	if (empty($category)) {
		message("抱歉，分类不存在或是已经被删除！", $this->createWebUrl('category', array('op' => 'display')), "error");
	}

	$res = pdo_delete($this->table_category, array('uniacid'=>$uniacid,'id' => $id));
	if($res){
		$this->addSysLog($_W['uid'], $_W['username'], 2, "课程分类", "删除ID:{$id}的课程分类");
	}

	message("删除分类成功！", $this->createWebUrl('category', array('op' => 'display')), "success");

}elseif($op=='changeShow'){
	$id = intval($_GPC['id']);
	$category = pdo_fetch("SELECT * FROM " . tablename($this->table_category) . " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$uniacid,':id'=>$id));
	if (empty($category)) {
		message("抱歉，分类不存在或是已经被删除！", $this->createWebUrl('category', array('op' => 'display')), "error");
	}

	if($category['is_show']==1){
		$data['is_show'] = 0;
		$message = "隐藏分类";
	}else{
		$data['is_show'] = 1;
		$message = "显示分类";
	}

	if(pdo_update($this->table_category, $data, array('id'=>$id))){
		message("{$message}成功", $this->createWebUrl('category', array('op' => 'display')), "success");
	}else{
		message("{$message}失败", $this->createWebUrl('category', array('op' => 'display')), "error");
	}
}

include $this->template('category');

?>