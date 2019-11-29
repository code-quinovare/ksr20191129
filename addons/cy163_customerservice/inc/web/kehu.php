<?php
global $_W, $_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
	$keyword = trim($_GPC['keyword']);
	if(!empty($keyword)){
		$hasbiaoqian = pdo_fetchall("SELECT * FROM ".tablename(BEST_BIAOQIAN)." WHERE weid = {$_W['uniacid']} AND (realname like '%{$keyword}%' OR telphone like '%{$keyword}%' OR name like '%{$keyword}%')");
		if(!empty($hasbiaoqian)){
			$total = count($hasbiaoqian);
			$list = array();
			foreach($hasbiaoqian as $k=>$v){
				 $isfankefu = pdo_fetch("SELECT * FROM ".tablename(BEST_FANSKEFU)." WHERE fansopenid = '{$v['fensiopenid']}' AND kefuopenid = '{$v['kefuopenid']}'");
				if(!empty($isfankefu)){
					$list[$k] = $isfankefu;
				}
			}
		}else{
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename(BEST_FANSKEFU)." WHERE weid = {$_W['uniacid']} AND fansnickname like '%{$keyword}%'");
			$allpage = ceil($total/10)+1;
			$page = intval($_GPC["page"]);
			$pindex = max(1, $page);
			$psize = 10;
			$list = pdo_fetchall("SELECT * FROM ".tablename(BEST_FANSKEFU)." WHERE weid = {$_W['uniacid']} AND fansnickname like '%{$keyword}%' ORDER BY  id DESC LIMIT ".($pindex - 1)*$psize.",".$psize);
		}
	}else{
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename(BEST_FANSKEFU)." WHERE weid = {$_W['uniacid']}");
		$allpage = ceil($total/10)+1;
		$page = intval($_GPC["page"]);
		$pindex = max(1, $page);
		$psize = 10;
		$list = pdo_fetchall("SELECT * FROM ".tablename(BEST_FANSKEFU)." WHERE weid = {$_W['uniacid']} ORDER BY id DESC LIMIT ".($pindex - 1)*$psize.",".$psize);
	}
	$pager = pagination($total, $pindex, $psize);
	foreach($list as $k=>$v){
		$biaoqianres = pdo_fetch("SELECT * FROM ".tablename(BEST_BIAOQIAN)." WHERE fensiopenid = '{$v['fansopenid']}' AND kefuopenid = '{$v['kefuopenid']}'");
		$list[$k]['name'] = $biaoqianres['name'];
		$list[$k]['realname'] = $biaoqianres['realname'];
		$list[$k]['telphone'] = $biaoqianres['telphone'];
		$list[$k]['chat'] = pdo_fetchall("SELECT * FROM ".tablename(BEST_CHAT)." WHERE fkid = {$v['id']} ORDER BY time DESC");
	}
}elseif ($operation == 'deletedu') {
	$id = intval($_GPC['id']);
	$chat = pdo_fetch("SELECT id FROM ".tablename(BEST_CHAT)." WHERE id = {$id}");
	if (empty($chat)) {
		$resarr['error'] = 1;
		$resarr['msg'] = '不存在该聊天记录！';
		echo json_encode($resarr);
		exit();
	}
	pdo_delete(BEST_CHAT,array('id'=>$id));
	$resarr['error'] = 0;
	$resarr['msg'] = '删除成功！';
	echo json_encode($resarr);
	exit();
}elseif ($operation == 'changebiaoqian') {
	$id = intval($_GPC['id']);
	$name = trim($_GPC['name']);
	$realname = trim($_GPC['realname']);
	$telphone = trim($_GPC['telphone']);
	$chat = pdo_fetch("SELECT * FROM ".tablename(BEST_FANSKEFU)." WHERE weid = {$_W['uniacid']} AND id = {$id}");
	$hasbiaoqian = pdo_fetch("SELECT * FROM ".tablename(BEST_BIAOQIAN)." WHERE weid = {$_W['uniacid']} AND fensiopenid = '{$chat['fansopenid']}' AND kefuopenid = '{$chat['kefuopenid']}'");
	if (empty($hasbiaoqian)) {
		$data['weid'] = $_W['uniacid'];
		$data['kefuopenid'] = $chat['kefuopenid'];
		$data['fensiopenid'] = $chat['fansopenid'];
		$data['name'] = $name;
		$data['realname'] = $realname;
		$data['telphone'] = $telphone;
		pdo_insert(BEST_BIAOQIAN,$data);
	}else{
		$data['name'] = $name;
		$data['realname'] = $realname;
		$data['telphone'] = $telphone;
		pdo_update(BEST_BIAOQIAN,$data,array('fensiopenid'=>$chat['fansopenid'],'kefuopenid'=>$chat['kefuopenid']));
	}
	$resarr['error'] = 0;
	$resarr['msg'] = '操作成功！';
	echo json_encode($resarr);
	exit();
}elseif($operation == 'lahei'){
	$id = intval($_GPC['id']);
	$data['ishei'] = 1;
	pdo_update(BEST_FANSKEFU,$data,array('id'=>$id));
	message('加入黑名单成功！', $this->createWebUrl('kehu'), 'success');
}elseif($operation == 'yichu'){
	$id = intval($_GPC['id']);
	$data['ishei'] = 0;
	pdo_update(BEST_FANSKEFU,$data,array('id'=>$id));
	message('移除黑名单成功！', $this->createWebUrl('kehu'), 'success');
}elseif($operation == 'delbd'){
	$id = intval($_GPC['id']);
	$data['bdopenid'] = '';
	pdo_update(BEST_FANSKEFU,$data,array('id'=>$id));
	message('解除绑定成功！', $this->createWebUrl('kehu'), 'success');
}else {
	message('请求方式不存在');
}
include $this->template('web/kehu');
?>