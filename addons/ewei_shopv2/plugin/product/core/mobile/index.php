<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginMobilePage
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

	public function validate(){
		global $_W;
		global $_GPC;
		if ($_W['ispost']) {
			$num = preg_replace('# #','',$_GPC['num']);
			$productname = trim($_GPC['productname']);
			$verifycode = trim($_GPC['verifycode']);

			if (empty($num)) {
				show_json(0, '请输入正确的注册码');
			}

			if (empty($verifycode)) {
				show_json(0, '请输入验证码');
			}

			$code = md5(strtolower($verifycode) . $_W['config']['setting']['authkey']);
			if ($code != trim($_GPC['__code'])) {
				show_json(-1, '请输入正确的验证码');
			}

			// 只能注册三次验证
			$total = pdo_fetchcolumn('select count(*) from '.tablename('ewei_shop_product').' where uniacid=:uniacid and openid=:openid',array(':uniacid'=>$_W['uniacid'],'openid'=>$_W['openid']));
			if ($total==3) {
				show_json(0, '您注册的产品数量已达上限！');
			}
		
			// 验证注册码状态
			$result = $this->model->checkProject($num);

			if ($result->systemState=='008') {
				show_json(0, '参数为空或值错误');
			}

			if ($result->systemState=='002') {
				show_json(0, '该注册码已被注册！');
			}

			if ($result->systemState=='003') {
				show_json(0, '您查询的注册码不存在！');
			}
			//写入数据库，更改会员积分
			if ($result->systemState=='001') {
				$xmlstring = simplexml_load_string($result->reply, 'SimpleXMLElement', LIBXML_NOCDATA);
				$item = json_decode(json_encode($xmlstring),true);
				$data = array(
					'openid'=>$_W['openid'],
					'productname'=>$productname,
					'num'=>$num,
					'zcode'=>$item['item']['zcode'],
					'createtime'=>time(),
					'uniacid'=>$_W['uniacid']
					);
				pdo_insert('ewei_shop_product',$data);

				$credits = '500.00';

				m('member')->setCredit($_W['openid'], 'credit1', $credits, array(0, '会员产品注册成功,积分+' . $credits));

				show_json(1);
			}
			
		}
	}
		
}

?>
