<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$area=pdo_getall('wpdc_area',array('uniacid'=>$_W['uniacid']),array(),'','num asc');
$operation = empty($_GPC['op']) ? 'display' : trim($_GPC['op']);
$type=pdo_getall('wpdc_storetype',array('uniacid'=>$_W['uniacid']),array(),'','num asc');
$where="WHERE a.uniacid=:uniacid";
$data[':uniacid']=$_W['uniacid'];
$system=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
$time=time()-($system['day']*24*60*60);
pdo_update('wpdc_order',array('state'=>4),array('state'=>3,'time <='=>$time));

	//echo $_GPC['area'];die;
    if($_GPC['keywords']){
    	$where .=" and a.md_name LIKE :name ";
    	 $op=$_GPC['keywords'];
          $data[':name']="%$op%";
    	
    }
    if($_GPC['type']){
    	$where .=" and b.id=:bid";
    	$data[':bid']=$_GPC['type'];
    }
    if($_GPC['area']){
    	$where .=" and c.id=:cid";
    	$data[':cid']=$_GPC['area'];
    }
 
if($_W['role']=='operator'){
    //查找商家ID;
    $seller=pdo_get('wpdc_account',array('weid'=>$_W['uniacid'],'uid'=>$_W['user']['uid']));
    $seller_id=$seller['storeid'];
    $where.=" and a.id =:id";
    $data[':id']=$seller_id;
}
$sql="select a.*,b.type_name,c.area_name from " . tablename("wpdc_store") . " a"  . " left join " . tablename("wpdc_storetype") . " b on b.id=a.md_type " . " left join " . tablename("wpdc_area") . " c on c.id=a.md_area ".$where." order by a.number asc";

$list=pdo_fetchall($sql,$data);	


if($operation=='delete'){
	$res=pdo_delete('wpdc_store',array('id'=>$_GPC['id']));
	if($res){
		message('删除成功！', $this->createWebUrl('store'), 'success');
	}else{
		message('删除失败！','','error');
	}
}
if($_GPC['is_open']){
   $res=pdo_update('wpdc_store',array('is_open'=>$_GPC['is_open']),array('id'=>$_GPC['updid']));
    if($res){
        message('修改成功！', $this->createWebUrl('store'), 'success');
    }else{
        message('修改失败！','','error');
    } 
}

//一键复制
if($operation=='copy'){
$id = intval($_GPC['id']);
    $store = pdo_get("wpdc_store",array('uniacid'=>$_W['uniacid'],'id'=>$id));
   if(empty($store)){  
     message('门店不存在或已删除！','','error');
    } 
    //复制门店数据表
    $sql = "INSERT INTO ".tablename('wpdc_store')."(name,address,time,tel,announcement,conditions,preferential,support,is_rest,img,start_at,freight,logo,details,time2,color,uniacid,xyh_money,xyh_open,integral,coordinates,distance,is_yy,is_wm,is_dn,is_sy,is_pd,ps_mode,bq_logo,is_display,yyzz,environment,
    sd_time,md_logo,md_name,md_area,md_type,md_content,number,score,sales,is_jd,jd_time,source_id,shop_no,is_mp3,is_video,store_mp3,store_video,is_yypay,yy_name,wm_name,dn_name,sy_name,pd_name,box_name) SELECT REPLACE(name,name,CONCAT(name,'-".random(5)."')),address,time,tel,announcement,conditions,preferential,support,is_rest,img,start_at,freight,logo,details,time2,color,uniacid,xyh_money,xyh_open,integral,coordinates,distance,is_yy,is_wm,is_dn,is_sy,is_pd,ps_mode,bq_logo,is_display,yyzz,environment,sd_time,md_logo,REPLACE(md_name,md_name,CONCAT(md_name,'-".random(5)."')),md_area,md_type,md_content,number,score,sales,is_jd,jd_time,source_id,shop_no,is_mp3,is_video,store_mp3,store_video,is_yypay,yy_name,wm_name,dn_name,sy_name,pd_name,box_name FROM ".tablename('wpdc_store')." WHERE id='".$id."';";
    $result = pdo_query($sql);
    $new_storeid = pdo_insertid();
    //复制菜品分类
    $all_class = pdo_getall("wpdc_type",array('uniacid'=>$_W['uniacid'],'store_id'=>$id));
    foreach ($all_class as $key => $classItem) {
        $class_sql = "INSERT INTO ".tablename('wpdc_type')."(type_name,store_id,uniacid,order_by) SELECT type_name,REPLACE(store_id,store_id,'".$new_storeid."'),uniacid,order_by FROM ".tablename('wpdc_type')." WHERE id='".$classItem['id']."';";
        $class_result = pdo_query($class_sql);
        $new_classid = pdo_insertid();
        //获取该分类下老的商品列表
        $goods_list = pdo_getall("wpdc_dishes",array('uniacid'=>$_W['uniacid'],'store_id'=>$id,'type_id'=>$classItem['id']));
        foreach ($goods_list as $key2 => $goodsItem) {
            $goods_sql = "INSERT INTO ".tablename('wpdc_dishes')."(name,store_id,img,num,money,type_id,signature,one,uniacid,xs_num,sit_ys_num,is_shelves,dishes_type,box_fee,wm_money,details,sorting) SELECT name,REPLACE(store_id,store_id,'".$new_storeid."'),img,num,money,REPLACE(type_id,type_id,'".$new_classid."'),signature,one,uniacid,xs_num,sit_ys_num,is_shelves,dishes_type,box_fee,wm_money,details,sorting FROM ".tablename('wpdc_dishes')." WHERE id='".$goodsItem['id']."';";
            $goods_result = pdo_query($goods_sql);
            $new_goodsid = pdo_insertid();
            //获取老的商品规格
            $spec_list = pdo_getall("wpdc_spec",array('goods_id'=>$goodsItem['id']));
            $spec_check = array();
            foreach ($spec_list as $key3 => $specItem) {
                $spec_sql = "INSERT INTO ".tablename('wpdc_spec')."(name,cost,num,goods_id) SELECT name,cost,num,REPLACE(goods_id,goods_id,'".$new_goodsid."') FROM ".tablename('wpdc_spec')." WHERE id='".$specItem['id']."';";
                $spec_result = pdo_query($spec_sql);
                $new_specid = pdo_insertid();               
            }
          
        }
    }
    message("门店复制成功",$this->createWebUrl('store'), 'success');
}
include $this->template('web/store');