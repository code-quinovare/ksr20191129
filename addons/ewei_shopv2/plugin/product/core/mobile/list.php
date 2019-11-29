<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class List_EweiShopV2Page extends PluginMobilePage
{
	
	public function __construct(){
		global $_W;
		global $_GPC;
		$this->model = m('plugin')->loadModel($GLOBALS['_W']['plugin']);

		//$_W['openid'] = 'oGV2J1KUYw1eGNqUh563NLpO9l_4';

	}
	public function main()
	{
		global $_W;
		global $_GPC;

		include $this->template();
	}

	public function get_list(){
		global $_W;
		global $_GPC;
	
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and uniacid=:uniacid  and openid=:openid ';
		$params = array(':uniacid' => $_W['uniacid'],'openid'=>$_W['openid']);

		$sql = 'select * from ' . tablename('ewei_shop_product') . '  where 1 ' . $condition . ' order by id desc LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;


		$list = pdo_fetchall($sql, $params);

		foreach ($list as &$row) {
			$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
		}

		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_product') . '  where 1 ' . $condition, $params);

		show_json(1, array('list' => $list, 'total' => $total, 'pagesize' => $psize));
	}
		
}

?>
