<?php

class Wg_sales_Web_Kwsetting extends SalesBaseController
{
	public $cate = array();
	public function init()
	{
		parent::init();
		$this->uid = $this->site->_W['uniacid'];
	}
	public function index()
	{
		$data = $this->site->getKw();
		if ($this->site->ispost()) {
			$write['title'] = trim($this->site->_GPC['title']);
			$write['description'] = trim($this->site->_GPC['description']);
			$write['picurl'] = trim($this->site->_GPC['picurl']);
			$write['url'] = trim($this->site->_GPC['url']);
			if ($this->site->setKw($write)) {
				message('更新成功', $this->site->webUrl('kwsetting'));
			} else {
				message('写入失败', $this->site->webUrl('kwsetting'));
			}
		}
		$this->site->assign($data);
	}
}