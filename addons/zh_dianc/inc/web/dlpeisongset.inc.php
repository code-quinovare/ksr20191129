<?php
global $_GPC, $_W;
$action = 'start';
//$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid, $action);
$info=pdo_get('wpdc_store',array('id'=>$storeid));
if(checksubmit('submit')){
			$data['freight']=$_GPC['freight'];
			$data['sd_time']=$_GPC['sd_time'];
			$data['ps_mode']=$_GPC['ps_mode'];
			$data['distance']=$_GPC['distance'];
			$data['uniacid']=$_W['uniacid'];
				$res = pdo_update('wpdc_store', $data, array('id' => $storeid));
				if($res){
					message('编辑成功',$this->createWebUrl2('dlpeisongset',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/dlpeisongset');