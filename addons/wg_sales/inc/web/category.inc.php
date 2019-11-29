<?php

include_once dirname(__FILE__) . '/../../crontab/Index.php';
class Wg_sales_Web_Category extends SalesBaseController
{
	public $cate = array();
	public function init()
	{
		parent::init();
		$this->uid = $this->site->_W['uniacid'];
		$this->site->loadmodule('categoryModule');
		$this->cate = Index::getCategory();
	}
	public function index()
	{
		$data['index'] = $this->site->getCategoryIndex();
		$list = $this->site->categoryModule->getAllCategory(['uniacid' => $this->uid, 'del' => [0, 2]]);
		foreach ($list as &$value) {
			$source = json_decode($value['source'], true);
			if ($source) {
				foreach ($source as $s) {
					$d = explode('_', $s);
					$name = $d[0];
					$id = $d[1];
					if (isset($this->cate[$name]['category'][$id])) {
						$value['source_from'][] = ['index' => $this->cate[$name]['value'], 'name' => $this->cate[$name]['category'][$id]['name']];
					}
				}
			}
		}
		$data['list'] = $list;
		$this->site->assign($data);
	}
	public function edit()
	{
		$data = [];
		if ($this->site->_GPC['category_id'] === '0') {
			$data['category'] = $write = $this->site->getCategoryIndex();
			if ($this->site->ispost()) {
				$write['name'] = trim($this->site->_GPC['name']);
				if ($this->site->setCategoryIndex($write)) {
					message('更新成功', $this->site->webUrl('category'));
				} else {
					message('category.data文件写入失败', $this->site->webUrl('category'));
				}
			}
		} else {
			$id = (int) $this->site->_GPC['category_id'];
			$where = ['id' => $id, 'uniacid' => $this->uid, 'del' => [0, 2]];
			if ($this->site->ispost()) {
				$data['name'] = trim($this->site->_GPC['name']);
				$data['uniacid'] = $this->uid;
				$data['create_time'] = time();
				$data['jump'] = trim($_POST['jump']);
				$data['url'] = trim($_POST['url']);
				$data['display_order'] = intval($this->site->_GPC['display_order']);
				$data['source'] = json_encode([trim($this->site->_GPC['source'])]);
				if (!$data['name']) {
					message('分类名不能为空');
				}
				if ($data['jump'] == 1 && $data['url'] == '') {
					message('url不能为空');
				}
				if ($id) {
					$result = $this->site->categoryModule->update($where, $data);
				} else {
					$result = $this->site->categoryModule->add($data);
				}
				if ($result) {
					message('更新成功', $this->site->webUrl('category'));
				} else {
					message('更新失败', $this->site->webUrl('category'));
				}
			}
			if ($id) {
				$data['category'] = $this->site->categoryModule->getOne($where);
				$data['category']['source'] = json_decode($data['category']['source'], true)[0];
			}
		}
		$data['cate'] = $this->cate;
		$this->site->assign($data);
	}
	function del()
	{
		$id = (int) $this->site->_GPC['id'];
		if ($id == 0) {
			$data = $this->site->getCategoryIndex();
			$data['del'] = $data['del'] ? 0 : 1;
			$result = $this->site->setCategoryIndex($data);
			if ($result) {
				iajax(0);
			} else {
				iajax(1, 'category.data写入失败');
			}
		} else {
			$where = ['id' => $id, 'uniacid' => $this->uid];
			$result = $this->site->categoryModule->update($where, ['del' => 1]);
			if ($result) {
				iajax(0);
			} else {
				iajax(1);
			}
		}
	}
	function hide()
	{
		$id = (int) $this->site->_GPC['id'];
		$hide = (int) $this->site->_GPC['hide'] == 0 ? 0 : 2;
		$where = ['id' => $id, 'uniacid' => $this->uid];
		$result = $this->site->categoryModule->update($where, ['del' => $hide]);
		if ($result) {
			iajax(0);
		} else {
			iajax(1);
		}
	}
}