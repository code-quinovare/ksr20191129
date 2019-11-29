<?php

class Wg_sales_Web_Ad extends SalesBaseController
{
	public $cate = array();
	public function init()
	{
		parent::init();
		$this->uid = $this->site->_W['uniacid'];
		$this->site->loadmodule('articleAdModule');
	}
	public function index()
	{
		$pindex = max(1, intval($this->site->_GPC['page']));
		$where = [];
		$total = $this->site->articleAdModule->count($where);
		$page = intval($_GET['page']) ? intval($_GET['page']) : 1;
		$data['list'] = $this->site->articleAdModule->getList($where, '*', ['id desc'], [$page, 20]);
		$data['pager'] = pagination($total, $pindex, 20);
		$this->site->assign($data);
	}
	public function edit()
	{
		$id = (int) $this->site->_GPC['id'];
		$where = ['id' => $id];
		if ($this->site->ispost()) {
			$data['type'] = intval($this->site->_GPC['type']);
			$data['name'] = trim($_POST['name']);
			if ($data['type'] == 1) {
				$de['ad_image'] = trim($_POST['ad_image']);
				$de['ad_url'] = trim($_POST['ad_url']);
				$de['ad_price'] = trim($_POST['ad_price']);
				$de['ad_title'] = trim($_POST['ad_title']);
				$data['content'] = json_encode($de);
			} else {
				$data['type'] = 2;
				$data['content'] = trim($_POST['content']);
			}
			if (!$data['name']) {
				message('广告名不能为空');
			}
			if ($id) {
				$result = $this->site->articleAdModule->update($where, $data);
			} else {
				$result = $this->site->articleAdModule->add($data);
			}
			if ($result) {
				message('更新成功', $this->site->webUrl('ad'));
			} else {
				message('更新失败');
			}
		}
		if ($id) {
			$data = $this->site->articleAdModule->getOne($where);
			if ($data['type'] == 1) {
				$data = array_merge($data, json_decode($data['content'], true));
				unset($data['content']);
			}
		}
		$this->site->assign($data);
	}
	function del()
	{
		$id = (int) $this->site->_GPC['id'];
		$this->site->articleAdModule->del(['id' => $id]);
		echo json_encode(['code' => 0]);
		exit;
	}
}