<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
if(checksubmit('submit')){
	$op=$_GPC['keywords'];
	$where="%$op%";	
}else{
	$where='%%';
}
	$pageindex = max(1, intval($_GPC['page']));
	$pagesize=10;
	$sql="select a.*,b.name as level_name  from " . tablename("zhvip_user") ."a"  . " left join " . tablename("zhvip_level") . " b on b.id=a.grade WHERE  a.nickname LIKE :name  and a.uniacid=:uniacid";
	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list = pdo_fetchall($select_sql,array(':uniacid'=>$_W['uniacid'],':name'=>$where));	   
	$total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_user") ." WHERE  nickname LIKE :name  and uniacid=:uniacid",array(':uniacid'=>$_W['uniacid'],':name'=>$where));
	$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=="delete"){
      // $res=pdo_delete("zhvip_order",array('user_id'=>$_GPC['id']));
      // $res2=pdo_delete("zhvip_usercoupons",array('user_id'=>$_GPC['id']));
      // $res3=pdo_delete("zhvip_uservoucher",array('user_id'=>$_GPC['id']));
      $res4=pdo_delete("zhvip_user",array('id'=>$_GPC['id']));
      if($res4){
         message('删除成功！', $this->createWebUrl('inuser'), 'success');
      }else{
         message('删除失败！','','error');
      }
}
if(checksubmit('submit2')){
      $res=pdo_update('zhvip_user',array('wallet +='=>$_GPC['reply']),array('id'=>$_GPC['id2']));
      if($res){
       $data['money']=$_GPC['reply'];
       $data['user_id']=$_GPC['id2'];
       $data['type']=1;
       $data['note']='后台充值';
       $data['time']=date('Y-m-d H:i:s');
       $data['uniacid']=$_W['uniacid'];//小程序id
       $res2=pdo_insert('zhvip_qbmx',$data); 
       if($res2){
       message('充值成功！', $this->createWebUrl('inuser'), 'success');
      }else{
       message('充值失败！','','error');
      }
    }
}
if(checksubmit('submit3')){
      $res=pdo_update('zhvip_user',array('integral +='=>$_GPC['reply']),array('id'=>$_GPC['id3']));
      if($res){
       $data['score']=$_GPC['reply'];
       $data['user_id']=$_GPC['id3'];
       $data['type']=1;
       $data['note']='后台充值';
       $data['cerated_time']=date('Y-m-d H:i:s');
       $data['uniacid']=$_W['uniacid'];//小程序id
       $res2=pdo_insert('zhvip_jfmx',$data); 
       if($res2){
       message('充值成功！', $this->createWebUrl('inuser'), 'success');
      }else{
       message('充值失败！','','error');
      }
    }
}
include $this->template('web/inuser');