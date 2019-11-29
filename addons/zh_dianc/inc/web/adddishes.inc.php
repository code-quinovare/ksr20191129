<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$type=pdo_getall('wpdc_type',array('uniacid' => $_W['uniacid'],'store_id'=>$storeid));
if(!$type){
	message('请先添加分类',$this->createWebUrl('adddishestype',array()),'error');
}
$sql="select a.* ,b.type_name from " . tablename("wpdc_dishes") . " a"  . " left join " . tablename("wpdc_type") . " b on b.id=a.type_id   WHERE a.id=:id and  a.uniacid=:uniacid";
$list=pdo_fetch($sql,array(':id'=>$_GPC['id'],':uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
	if($_GPC['dishes_type']==1){
		$data['money']=0;
		$data['wm_money']=$_GPC['wm_money'];
		if(empty($_GPC['wm_money'])){
			message('外卖菜品价格不能为空','','error');
		}
	}
	if($_GPC['dishes_type']==2){
		$data['money']=$_GPC['money'];
		$data['wm_money']=0;
		if(empty($_GPC['money'])){
			message('店内菜品价格不能为空','','error');
		}
	}
	if($_GPC['dishes_type']==3){
		$data['wm_money']=$_GPC['wm_money'];
		$data['money']=$_GPC['money'];
		if(empty($_GPC['money'])||empty($_GPC['wm_money'])){
			message('菜品价格不能为空','','error');
		}
	}
	$data['name']=$_GPC['name'];
	$data['img']=$_GPC['img'];
	$data['num']=$_GPC['num'];
	$data['sorting']=$_GPC['sorting'];
	$data['type_id']=$_GPC['type_id'];
	$data['signature']=$_GPC['signature'];
	$data['sit_ys_num']=$_GPC['sit_ys_num'];
	$data['is_shelves']=$_GPC['is_shelves'];
	$data['dishes_type']=$_GPC['dishes_type'];
	$data['details']=html_entity_decode($_GPC['details']);
	$data['uniacid']=$_W['uniacid'];
	$data['box_fee']=$_GPC['box_fee'];
	$data['store_id']=$storeid;
	if($_GPC['id']==''){
		$sql=pdo_get('wpdc_dishes',array('name'=>$_GPC['name'],'uniacid'=>$_W['uniacid'],'type_id'=>$_GPC['type_id'],'dishes_type'=>$_GPC['dishes_type']));
		if($sql){
			message('不能添加相同菜品','','error');	
		}else{
			$res=pdo_insert('wpdc_dishes',$data);
			if($res){				
				message('添加成功',$this->createWebUrl('dishes2',array()),'success');
			}else{
				message('添加失败','','error');
			}
		}
	}else{
		$res = pdo_update('wpdc_dishes', $data, array('id' => $_GPC['id']));
		if($res){
			message('编辑成功',$this->createWebUrl('dishes2',array()),'success');
		}else{
			message('编辑失败','','error');
		}
	}		
}
include $this->template('web/adddishes');