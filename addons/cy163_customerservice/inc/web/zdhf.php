<?php
global $_W, $_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
	$list = pdo_fetchall("SELECT * FROM ".tablename(BEST_ZIDONGHUIFU)." WHERE weid = {$_W['uniacid']}");
} elseif ($operation == 'post') {
	$id = intval($_GPC['id']);
	if (checksubmit('submit')) {
		$type = intval($_GPC['type']);
		if($type == 0){
			message("请选择匹配类型！");
		}
		$data = array(
			'weid' => $_W['uniacid'],
			'title' => $_GPC['title'],
			'content'=> $_GPC['content'],
			'type'=> $type,
		);
		if (!empty($id)) {
			pdo_update(BEST_ZIDONGHUIFU, $data, array('id' => $id));
		} else {
			pdo_insert(BEST_ZIDONGHUIFU, $data);
		}
		message('操作成功！', $this->createWebUrl('zdhf', array('op' => 'display')), 'success');
	}
	$zdhf = pdo_fetch("select * from ".tablename(BEST_ZIDONGHUIFU)." where id = {$id} and weid= {$_W['uniacid']}");
} elseif ($operation == 'delete') {
	$id = intval($_GPC['id']);
	$zdhf = pdo_fetch("SELECT id FROM ".tablename(BEST_ZIDONGHUIFU)." WHERE id = {$id}");
	if (empty($zdhf)) {
		message('抱歉，自动回复不存在或是已经被删除！', $this->createWebUrl('zdhf', array('op' => 'display')), 'error');
	}
	pdo_delete(BEST_ZIDONGHUIFU, array('id' => $id));
	message('自动回复删除成功！', $this->createWebUrl('zdhf', array('op' => 'display')), 'success');
} else {
	message('请求方式不存在');
}
include $this->template('web/zdhf');
?>