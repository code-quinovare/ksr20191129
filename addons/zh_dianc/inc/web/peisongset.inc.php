<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$info=pdo_get('wpdc_store',array('id'=>$storeid));
if(checksubmit('submit')){
			$data['freight']=$_GPC['freight'];
			$data['sd_time']=$_GPC['sd_time'];
			$data['ps_mode']=$_GPC['ps_mode'];
			$data['distance']=$_GPC['distance'];
			$data['uniacid']=$_W['uniacid'];
				$res = pdo_update('wpdc_store', $data, array('id' => $storeid));
				if($res){
					message('编辑成功',$this->createWebUrl('peisongset',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/peisongset');