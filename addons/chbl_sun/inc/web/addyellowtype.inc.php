<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('chbl_sun_yellowtype',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
		if(checksubmit('submit')){
			$data['img']=$_GPC['img'];
			$data['num']=$_GPC['num'];
			$data['type_name']=$_GPC['type_name'];
			$data['money']=$_GPC['money'];
			$data['state']=$_GPC['state'];
			$data['uniacid']=$_W['uniacid'];
			if($_GPC['id']==''){				
				$res=pdo_insert('chbl_sun_yellowtype',$data);
				if($res){
					message('添加成功',$this->createWebUrl('yellowtype',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('chbl_sun_yellowtype', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('yellowtype',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addyellowtype');