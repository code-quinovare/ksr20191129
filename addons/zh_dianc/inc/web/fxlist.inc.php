<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=' WHERE  a.uniacid=:uniacid';
$where2=' WHERE  uniacid=:uniacid';
$data[':uniacid']=$_W['uniacid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and (a.user_tel LIKE  concat('%', :name,'%') || a.user_name LIKE  concat('%', :name,'%'))";   
    $where2.=" and (user_tel LIKE  concat('%', :name,'%') || user_name LIKE  concat('%', :name,'%'))";  
    $data[':name']=$op;
} 
  //$sql="SELECT * FROM ".tablename('wpdc_distribution') .  "  ". $where." ORDER BY id DESC";

   $sql="select a.* ,b.img,b.commission from " . tablename("wpdc_distribution") . " a"  . " left join " . tablename("wpdc_user") . " b on b.id=a.user_id  ". $where." ORDER BY id DESC";
  $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('wpdc_distribution') .  "".$where2." ORDER BY id DESC",$data);
$list=pdo_fetchall( $sql,$data);

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
$operation=$_GPC['op'];
if($operation=='adopt'){//审核通过
    $id=$_GPC['id'];
    $res=pdo_update('wpdc_distribution',array('state'=>2),array('id'=>$id));  
    if($res){
        message('审核成功',$this->createWebUrl('fxlist',array()),'success');
    }else{
        message('审核失败','','error');
    }
}
if($operation=='reject'){
     $id=$_GPC['id'];
    $res=pdo_update('wpdc_distribution',array('state'=>3),array('id'=>$id));
     if($res){
        message('拒绝成功',$this->createWebUrl('fxlist',array()),'success');
    }else{
        message('拒绝失败','','error');
    }
}
if($operation=='delete'){
     $id=$_GPC['id'];
     $res=pdo_delete('wpdc_distribution',array('id'=>$id));
     if($res){
        message('删除成功',$this->createWebUrl('fxlist',array()),'success');
    }else{
        message('删除失败','','error');
    }

}
if($_GPC['id2']){
  $id=$_GPC['id2'];
  pdo_update('wpdc_user',array('commission +='=>$_GPC['reply']),array('id'=>$id));
  $data3['user_id']=$id;//上线id
  $data3['son_id']=0;
  $data3['money']=$_GPC['reply'];//金额
  $data3['time']=time();//时间
  $data3['uniacid']=$_W['uniacid'];
  $res=pdo_insert('wpdc_earnings',$data3);
  if($res){
        message('充值成功',$this->createWebUrl('fxlist',array()),'success');
    }else{
        message('充值失败','','error');
    }
}

include $this->template('web/fxlist');