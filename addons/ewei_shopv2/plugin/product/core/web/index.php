<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		$page = (empty($_GPC['page']) ? '' : $_GPC['page']);
		$pindex = max(1, intval($page));
		$psize = 10;
		
		
		$condition = ' and a.uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);


		if (!empty($_GPC['keywords'])) {
			$_GPC['keywords'] = trim($_GPC['keywords']);
			$condition .= ' and ( a.num like :keywords or b.nickname like :keywords ) ';
			$params[':keywords'] = '%' . $_GPC['keywords'] . '%';
		}

		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

	

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND a.createtime >= :starttime AND a.createtime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}
		
		$sql = 'select a.id,a.openid,a.num,a.zcode,a.productname,a.createtime,b.nickname from ' . tablename('ewei_shop_product') . ' a left join '.tablename('ewei_shop_member').' b on b.openid=a.openid where 1 ' . $condition . ' order by a.id desc LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;

		// echo $sql;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_product') . ' a left join '.tablename('ewei_shop_member').' b on b.openid=a.openid where 1 ' . $condition, $params);


		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	
	public function add()
	{

		$this->post();
	}

	public function edit()
	{
		$this->post();
	}

	protected function post()
	{
		global $_W;
		global $_GPC;


		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_product') . ' WHERE id =:id  and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));
		if (!empty($item['openid'])) {
			$member = m('member')->getMember($item['openid']);
		}

		if ($_W['ispost']) {
			$data = array(
				'uniacid' => $_W['uniacid'], 
				'productname' => trim($_GPC['productname']), 
				'num' => preg_replace('# #','',$_GPC['num']), 
				'openid' => trim($_GPC['openid'])
				);
			
			$total = pdo_fetchcolumn('select count(*) from '.tablename('ewei_shop_product').' where uniacid=:uniacid and openid=:openid',array(':uniacid'=>$_W['uniacid'],'openid'=>$data['openid']));
			if ($total==3) {
				show_json(0, '该会员注册的产品数量已达上限！');
			}
			if ($data['openid']=='') {
				show_json(0, '会员微信号不能为空');
			}
			// 验证注册码状态
			$result = $this->model->checkProject($data['num']);

			if ($result->systemState=='008') {
				show_json(0, '参数为空或值错误');
			}

			if ($result->systemState=='002') {
				show_json(0, '该注册码已被注册！');
			}

			if ($result->systemState=='003') {
				show_json(0, '您查询的注册码不存在！');
			}
			if ($result->systemState=='001') {
				$xmlstring = simplexml_load_string($result->reply, 'SimpleXMLElement', LIBXML_NOCDATA);
				$item = json_decode(json_encode($xmlstring),true);
				$data['zcode'] = $item['item']['zcode'];
				if (!empty($item['id'])) {
					pdo_update('ewei_shop_product', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
					plog('perm.product.edit', '编辑产品 ID: ' . $id . ' 注册码: ' . $data['num']);
				}else {
					pdo_insert('ewei_shop_product', $data);

					$id = pdo_insertid();
					$credits = '500.00';
					m('member')->setCredit($data['openid'], 'credit1', $credits, array(0, '会员产品注册成功,积分+' . $credits));
					plog('perm.product.add', '添加产品 ID: ' . $id . ' 注册码: ' . $data['num']);
				}
				
			}

			show_json(1);
		}

		

		include $this->template();
	}
	
}

?>
