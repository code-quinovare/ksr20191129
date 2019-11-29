<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'fieldset_display';
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=" where b.uniacid=:uniacid";
if(!empty($_GPC['keywords'])){
    $where.=" and a.details LIKE  concat('%', :name,'%') ";
    $data[':name']=$_GPC['keywords'];   
}	
$data[':uniacid']=$_W['uniacid'];
$sql="select a.* ,b.details as tzinfo from " . tablename("chbl_sun_comments") . " a"  . " left join " . tablename("chbl_sun_information") . " b on a.information_id=b.id ".$where." order by time DESC";
$total=pdo_fetchcolumn("select count(*) from " . tablename("chbl_sun_comments") . " a"  . " left join " . tablename("chbl_sun_information") . " b on a.information_id=b.id".$where,$data);
	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list=pdo_fetchall($select_sql,$data);
	$pager = pagination($total, $pageindex, $pagesize);

	if($operation=='delete'){
		$res=pdo_delete('chbl_sun_comments',array('id'=>$_GPC['id']));
		if($res){
			message('删除成功',$this->createWebUrl('tzpinglun',array()),'success');
		}else{
			message('删除失败','','error');
		}
	}


include $this->template('web/tzpinglun');