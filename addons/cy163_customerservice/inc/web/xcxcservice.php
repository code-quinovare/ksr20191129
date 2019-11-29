<?php
global $_W, $_GPC;
$cando = $this->checkmain($_W['siteroot']);
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
	if (!empty($_GPC['displayorder'])) {
		foreach ($_GPC['displayorder'] as $id => $displayorder) {
			pdo_update(BEST_XCXCSERVICE, array('displayorder' => $displayorder), array('id' => $id, 'weid' => $_W['uniacid']));
		}
		message('小程序客服排序更新成功！', $this->createWebUrl('xcxcservice', array('op' => 'display')), 'success');
	}
	$list = pdo_fetchall("SELECT * FROM ".tablename(BEST_XCXCSERVICE)." WHERE weid = {$_W['uniacid']} ORDER BY displayorder ASC");
} elseif ($operation == 'post') {
	$id = intval($_GPC['id']);
	$cservice = pdo_fetch("select * from ".tablename(BEST_XCXCSERVICE)." where id = {$id} and weid= {$_W['uniacid']}");
	$xcxlist = pdo_fetchall("SELECT * FROM " . tablename(BEST_XCX) . " WHERE uniacid = {$_W['uniacid']}");
	if (checksubmit('submit')) {		
		if (empty($_GPC['name'])) {
			message('抱歉，请输入客服名称！');
		}
		if (empty($_GPC['xcxid'])) {
			message('抱歉，请选择所属小程序！');
		}
		if (empty($_GPC['content'])) {
			message('抱歉，请输入客服内容！');
		}
		if (empty($_GPC['thumb'])) {
			message('抱歉，请上传客服头像！');
		}		
		$data = array(
			'weid' => $_W['uniacid'],
			'name' => trim($_GPC['name']),
			'content' => trim($_GPC['content']),
			'thumb' => $_GPC['thumb'],
			'displayorder' => intval($_GPC['displayorder']),
			'kefuauto'=>trim($_GPC['kefuauto']),
			'isautosub'=>intval($_GPC['isautosub']),
			'xcxid'=>intval($_GPC['xcxid']),
		);		
		if (!empty($id)) {
			pdo_update(BEST_XCXCSERVICE, $data, array('id' => $id));
		} else {
			pdo_insert(BEST_XCXCSERVICE, $data);
		}
		message('操作成功！', $this->createWebUrl('xcxcservice', array('op' => 'display')), 'success');
	}
	
} elseif ($operation == 'delete') {
	$id = intval($_GPC['id']);
	$cservice = pdo_fetch("SELECT id FROM ".tablename(BEST_XCXCSERVICE)." WHERE id = {$id} AND weid = {$_W['uniacid']}");
	if (empty($cservice)) {
		message('抱歉，小程序客服不存在或是已经被删除！', $this->createWebUrl('xcxcservice', array('op' => 'display')), 'error');
	}
	pdo_delete(BEST_XCXCSERVICE, array('id' => $id));
	message('小程序客服删除成功！', $this->createWebUrl('xcxcservice', array('op' => 'display')), 'success');
} else {
	message('请求方式不存在');
}
include $this->template('web/xcxcservice');
?>