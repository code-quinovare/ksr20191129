<?php
global $_GPC, $_W;
$action = 'start';
$GLOBALS['frames'] = $this->getNaveMenu($_COOKIE['cityname'], $action);
$info=pdo_getall('chbl_sun_information',array('id'=>$_GPC['id']));
$type=pdo_getall('chbl_sun_type',array('uniacid'=>$_W['uniacid']));
if($info['img']){
			if(strpos($info['img'],',')){
			$img= explode(',',$info['img']);
		}else{
			$img=array(
				0=>$info['img']
				);
		}
		}
if(checksubmit('submit')){
		if($_GPC['img']){
			$data['img']=implode(",",$_GPC['img']);
		}else{
			$data['img']='';
		}
		    $data['user_id']='100000001';
			$data['user_name']=$_GPC['user_name'];
			$data['views']=$_GPC['views'];
			$data['user_tel']=$_GPC['user_tel'];
			$data['details']=$_GPC['details'];
			$data['type_id']=$_GPC['type_id'];
			$data['type2_id']=$_GPC['type2_id'];
			$data['user_img2']=$_GPC['user_img2'];
			$data['hot']=$_GPC['hot'];
			$data['top']=2;
			$data['address']=$_GPC['address'];
			$data['uniacid']=$_W['uniacid'];
			$data['state']=2;
			$data['cityname']=$_COOKIE['cityname'];
			$data['time']=time();
			$data['sh_time']=time();

				$res = pdo_insert('chbl_sun_information', $data);
				if($res){
					message('新增成功',$this->createWebUrl2('dlininformation',array()),'success');
				}else{
					message('新增失败','','error');
				}
		}
include $this->template('web/dlinaddinformation');