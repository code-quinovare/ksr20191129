<?php
global $_GPC, $_W;
$action = 'start';
$GLOBALS['frames'] = $this->getNaveMenu($_COOKIE['cityname'], $action);
$info=pdo_get('chbl_sun_car',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
	
			$data['link_name']=$_GPC['link_name'];
			$data['link_tel']=$_GPC['link_tel'];
			$data['typename']=$_GPC['typename'];
			$data['start_place']=$_GPC['start_place'];
			$data['end_place']=$_GPC['end_place'];
			$data['num']=$_GPC['num'];
			if($_GPC['typename']=='车找货'){
				$data['tj_place']=$_GPC['tj_place'];
			}
			if($_GPC['typename']=='货找车'){
				$data['hw_wet']=$_GPC['hw_wet'];
			}
			$data['cityname']=$_COOKIE['cityname'];;
		
			//$data['top']=$_GPC['top'];
			$data['other']=$_GPC['other'];
			
				$res = pdo_update('chbl_sun_car', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl2('dlincarinfo',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/dlinseecar');