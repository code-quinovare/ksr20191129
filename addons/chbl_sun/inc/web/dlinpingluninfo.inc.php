<?php
global $_GPC, $_W;
$action = 'start';
$GLOBALS['frames'] = $this->getNaveMenu($_COOKIE['cityname'], $action);

		$sql="select a.* ,b.name,c.title,c.content as zxcontent from " . tablename("chbl_sun_zx_assess") ." a" . " left join " . tablename("chbl_sun_user") . "b on b.id=a.user_id"  . " left join " . tablename("chbl_sun_zx") . " c on c.id=a.zx_id where a.uniacid=:uniacid and a.id=:id";
		$list=pdo_fetch($sql, array(':uniacid'=>$_W['uniacid'],':id'=>$_GPC['id']));
		include $this->template('web/dlinpingluninfo');
	

