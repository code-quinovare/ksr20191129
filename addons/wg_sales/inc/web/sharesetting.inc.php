<?php
class Wg_sales_Web_Sharesetting extends SalesBaseController{
    public $cate = [];

    public function init() {
        parent::init();
        $this->uid  = $this->site->_W['uniacid'];
    }

    public function index() {
        $data = $this->site->_getCache('share');
        if($this->site->ispost()) {
            $write['title']       = trim($this->site->_GPC['title']);
            $write['description'] = trim($this->site->_GPC['description']);
            $write['picurl']      = trim($this->site->_GPC['picurl']);
            if($this->site->_setCache('share',$write)) {
                message('更新成功', $this->site->webUrl('sharesetting'));
            } else {
                message('写入失败', $this->site->webUrl('sharesetting'));
            }
        }
        $this->site->assign($data);
    }
}

