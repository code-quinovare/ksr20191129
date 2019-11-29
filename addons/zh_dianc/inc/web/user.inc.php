<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

if($_GPC['keywords']){
	$op=$_GPC['keywords'];
	$where="%$op%";	
}else{
	$where='%%';
}

	/*	$sql="select *  from " . tablename("wpdc_user") ." WHERE  name LIKE :name  and uniacid=:uniacid";
	$list=pdo_fetchall($sql,array(':name'=>$where,'uniacid'=>$_W['uniacid']));*/
	$pageindex = max(1, intval($_GPC['page']));
	$pagesize=10;
	$sql="select *  from " . tablename("wpdc_user") ." WHERE  name LIKE :name  and uniacid=:uniacid";
	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list = pdo_fetchall($select_sql,array(':uniacid'=>$_W['uniacid'],':name'=>$where));	   
	$total=pdo_fetchcolumn("select count(*) from " . tablename("wpdc_user") ." WHERE  name LIKE :name  and uniacid=:uniacid",array(':uniacid'=>$_W['uniacid'],':name'=>$where));
	$pager = pagination($total, $pageindex, $pagesize);
	if($_GPC['id']){
		$res=pdo_delete("wpdc_order",array('user_id'=>$_GPC['id']));
		$res2=pdo_delete("wpdc_usercoupons",array('user_id'=>$_GPC['id']));
		$res3=pdo_delete("wpdc_uservoucher",array('user_id'=>$_GPC['id']));
		$res4=pdo_delete("wpdc_user",array('id'=>$_GPC['id']));
		if($res4){
		 message('删除成功！', $this->createWebUrl('user'), 'success');
		}else{
			  message('删除失败！','','error');
		}
	}
if(checksubmit('submit2')){
      $res=pdo_update('wpdc_user',array('wallet +='=>$_GPC['reply']),array('id'=>$_GPC['id2']));
      if($res){
       $data['money']=$_GPC['reply'];
       $data['user_id']=$_GPC['id2'];
       $data['type']=1;
       $data['note']='后台充值';
       $data['time']=date('Y-m-d H:i:s');
       $res2=pdo_insert('wpdc_qbmx',$data); 
       if($res2){
       message('充值成功！', $this->createWebUrl('user'), 'success');
      }else{
       message('充值失败！','','error');
      }
    }
}
if(checksubmit('submit3')){
      $res=pdo_update('wpdc_user',array('total_score +='=>$_GPC['reply']),array('id'=>$_GPC['id3']));
      if($res){
       $data['score']=$_GPC['reply'];
       $data['user_id']=$_GPC['id3'];
       $data['type']=1;
       $data['note']='后台充值';
       $data['cerated_time']=date('Y-m-d H:i:s');
       $data['uniacid']=$_W['uniacid'];//小程序id
       $res2=pdo_insert('wpdc_integral',$data); 
       if($res2){
       message('充值成功！', $this->createWebUrl('user'), 'success');
      }else{
       message('充值失败！','','error');
      }
    }
}
if(checksubmit('submit4')){
      $res=pdo_update('wpdc_user',array('user_address '=>''),array('uniacid'=>$_W['uniacid']));     
       if($res){
       message('清空成功', $this->createWebUrl('user'), 'success');
      }else{
       message('清空失败！','','error');
      }
    
}
include $this->template('web/user');