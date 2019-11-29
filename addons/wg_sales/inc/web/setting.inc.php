<?php

include_once dirname(__FILE__) . '/../../crontab/Index.php';
class Wg_sales_Web_Setting extends SalesBaseController
{
	public $cate = array();
	public function init()
	{
		parent::init();
		$this->uid = $this->site->_W['uniacid'];
		$this->site->loadmodule('categoryModule');
		$this->site->loadmodule('articleAdModule');
		$this->cate = Index::getCategory();
	}
	public function index()
	{
		$data = $this->site->getSettings();
		$data['ad_list'] = $this->site->articleAdModule->getList([], '*', ['id desc']);
		if ($this->site->ispost()) {
			$write['name'] = trim($this->site->_GPC['name']);
			$write['pic'] = trim($this->site->_GPC['pic']);
			$write['site'] = trim($this->site->_GPC['site']);
			$write['token'] = trim($this->site->_GPC['token']);
			$write['comment'] = intval($this->site->_GPC['comment']);
			$write['ad_1'] = trim($this->site->_GPC['ad_1']);
			$write['ad_2'] = trim($this->site->_GPC['ad_2']);
			$write['ad_3'] = trim($this->site->_GPC['ad_3']);
			$write['pay'] = intval($this->site->_GPC['pay']);
			if ($this->site->setSettings($write)) {
				message('更新成功', $this->site->webUrl('setting'));
			} else {
				message('category.data文件写入失败', $this->site->webUrl('category'));
			}
		}
		$this->site->assign($data);
	}
	public function menu()
	{
		$data['list'] = $this->site->_getCache('menu');
		$this->site->assign($data);
	}
	public function add()
	{
		$rank = (int) $_GET['rank'];
		$list = $this->site->_getCache('menu');
		foreach ($list as $value) {
			if ($value['rank'] == $rank) {
				$data['item'] = $value;
				break;
			}
		}
		if ($this->site->ispost()) {
			$data['name'] = trim($this->site->_GPC['name']);
			$data['rank'] = intval($this->site->_GPC['rank']);
			$data['unselect'] = trim($this->site->_GPC['unselect']);
			$data['url'] = trim($this->site->_GPC['url']);
			$data['select'] = trim($this->site->_GPC['select']);
			$list[$data['rank']] = $data;
			if ($this->site->_setCache('menu', $list)) {
				message('更新成功', $this->site->webUrl('setting', ['_wg' => 'menu']));
			} else {
				message('更新底部图片失败');
			}
		}
		$this->site->assign($data);
	}
	public function delete()
	{
		$rank = (int) $_REQUEST['rank'];
		$list = $this->site->_getCache('menu');
		$new = [];
		foreach ($list as $key => $value) {
			if ($value['rank'] != $rank) {
				$new[$key] = $value;
			}
		}
		$this->site->_setCache('menu', $new);
		exit(0);
	}
}