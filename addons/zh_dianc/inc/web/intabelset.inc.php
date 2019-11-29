<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$info=pdo_get('wpdc_store',array('id'=>$storeid));
if(checksubmit('submit')){
		$data['is_czztpd']=$_GPC['is_czztpd'];
		$data['is_chzf']=$_GPC['is_chzf'];
		$data['uniacid']=$_W['uniacid'];
		$res = pdo_update('wpdc_store', $data, array('id' => $storeid));
		if($res){
			message('编辑成功',$this->createWebUrl('intabelset',array()),'success');
		}else{
			message('编辑失败','','error');
		}
}
include $this->template('web/intabelset');