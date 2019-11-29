<?php

class Wg_sales_Mobile_Pub extends SalesBaseController
{
	public $site = null;
	public $data = array();
	public $size = 10;
	public function init()
	{
		parent::init();
		$this->site->loadmodule('pubModule');
		if (!$this->uid) {
			message('请您在微信端打开');
		}
	}
	public function index()
	{
		$data['ad'] = $this->site->module['config']['ad'];
		$id = intval($this->site->_GPC['id']);
		if ($this->site->ispost()) {
			$pic = $_POST['image'];
			$image = [];
			if ($pic) {
				foreach ($pic as $k => $im) {
					if ($im) {
						$image[] = ['url' => $this->site->formatArrImage(['url' => $im])['url']];
					}
					if (count($image) > 2) {
						break;
					}
				}
			}
			$save = ['title' => trim($_POST['title']), 'type' => 1, 'author' => trim($_POST['author']), 'cate' => intval($_POST['cate']), 'uid' => $this->uid, 'category_id' => intval($_POST['category_id']), 'kw' => trim($_POST['kw']), 'jump' => 0, 'content' => trim($_POST['content']), 'image' => json_encode($image), 'time_step' => time(), 'special' => 0b1];
			if ($id) {
				$re = $this->site->pubModule->update(['id' => $id], $save);
				$re = $id;
			} else {
				$save['md5'] = md5(time() . rand(0, 99999999));
				$re = $this->site->pubModule->add($save);
			}
			if ($re) {
				message('更新成功', $this->site->mobileUrl('center'));
			}
		}
		$data['article']['author'] = $this->user_info['nickname'];
		if ($id) {
			$article = $this->site->pubModule->getOne(['id' => $id]);
			$images = @json_decode($article['image'], true);
			$article['image'] = $images;
			$data['article'] = $article;
		}
		$data['cate'] = isset($article['cate']) ? $article['cate'] : 1;
		load()->func('tpl');
		$data['category'] = $this->site->getCategory();
		$data['config'] = $this->site->getSettings();
		$this->site->assign($data);
	}
}