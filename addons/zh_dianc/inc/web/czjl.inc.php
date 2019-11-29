<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$pageindex = max(1, intval($_GPC['page']));
$pagesize=15;
$sql="select a.* ,b.name,b.img from " . tablename("wpdc_qbmx") . " a"  . " left join " . tablename("wpdc_user") . " b on b.id=a.user_id"." where ( a.note='钱包充值' || a.note='后台充值' || a.note='在线充值' ) and b.uniacid = :uniacid order by a.id asc";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list = pdo_fetchall($select_sql,array(':uniacid'=>$_W['uniacid']));	   
$total=pdo_fetchcolumn("select count(*) from " . tablename("wpdc_qbmx") . " a"  . " left join " . tablename("wpdc_user") . " b on b.id=a.user_id where ( a.note='钱包充值' || a.note='后台充值' || a.note='在线充值' ) and b.uniacid = :uniacid",array(':uniacid'=>$_W['uniacid']));
$pager = pagination($total, $pageindex, $pagesize);
include $this->template('web/czjl');
