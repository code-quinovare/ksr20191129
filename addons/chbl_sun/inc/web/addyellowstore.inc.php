<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('chbl_sun_yellowstore',array('id'=>$_GPC['id']));
//$area=pdo_getall('chbl_sun_area',array('uniacid'=>$_W['uniacid']));
$type=pdo_getall('chbl_sun_storetype',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
$system=pdo_get('chbl_sun_system',array('uniacid'=>$_W['uniacid']));
//入住类型
$typein=pdo_getall('chbl_sun_yellowset',array('uniacid'=>$_W['uniacid']));	
if($info['imgs']){
			if(strpos($info['imgs'],',')){
			$imgs= explode(',',$info['imgs']);
		}else{
			$imgs=array(
				0=>$info['imgs']
				);
		}
		}
		/* $coordinates=explode(',',$info['coordinates']);
        $list['coordinates']=array(
                'lat'=>$coordinates['0'],
                'lng'=>$coordinates['1'],
            );  */
            //var_dump( $list['coordinates']);die;	
        if(checksubmit('submit')){
        	if($_GPC['imgs']){
        		$data['imgs']=implode(",",$_GPC['imgs']);
        	}else{
        		$data['imgs']='';
        	}
        	$data['company_name']=$_GPC['company_name'];
        	$data['company_address']=$_GPC['company_address'];
        	$data['link_tel']=$_GPC['link_tel'];
        	$data['logo']=$_GPC['logo'];
        	$data['content']=$_GPC['content'];
        	//$data['coordinates']=$_GPC['op']['lat'].','.$_GPC['op']['lng'];
            $data['coordinates']=$_GPC['coordinates'];
        	$data['sort']=$_GPC['sort'];
            $data['views']=$_GPC['views'];
        	$data['rz_type']=$_GPC['rz_type'];
        	$data['time_over']=2;
            $data['state']=2;
            $data['uniacid']=$_W['uniacid'];
            $data['sh_time']=time();
        	$data['type_id']=$_GPC['type_id'];
            $data['cityname']=$system['cityname'];
            //查找入驻天数
            $days=pdo_get('chbl_sun_yellowset',array('id'=>$_GPC['rz_type']));
            $data['dq_time']=time()+$days['days']*60*60*24;
        	$res = pdo_insert('chbl_sun_yellowstore', $data);
        	if($res){
        		message('编辑成功',$this->createWebUrl('yellowstore',array()),'success');
        	}else{
        		message('编辑失败','','error');
        	}

        }
include $this->template('web/addyellowstore');