<?php

class Wg_sales_Mobile_Index extends SalesBaseController
{
	public $data = array();
	public $size = 20;
	public function init()
	{
		parent::init();
		$this->site->loadmodule('sliderModule');
		$this->site->loadmodule('articleModule');
	}
	public function index()
	{
		$category_id = intval($_GET['category_id']);
		$cate = $this->site->getCategory();
		$data['cat_index'][0] = $this->site->getCategoryIndex();
		if (!$data['cat_index'][0]['del']) {
			array_unshift($cate, $data['cat_index'][0]);
		}
		$data['cate'] = $this->site->arrayIndex($cate, 'id');
		if (!$data['cate'][$category_id]) {
			$category_id = $cate[0]['id'];
		}
		$data['config'] = $this->site->getSettings();
		if ($category_id == 0) {
			$data['top_news'] = $this->site->sliderModule->getList(['uniacid' => $this->site->site_id, 'source' => -1, 'start <' => time(), 'end >' => time()], 'display_order asc');
		} else {
		}
		$data['category'] = $data['cate'][$category_id];
		$share = $this->site->_getCache('share');
		global $_W;
		$data['share'] = ['title' => $share['title'], 'desc' => $share['description'], 'link' => $_W['siteroot'] . $_SERVER['REQUEST_URI'], 'imgUrl' => $share['picurl']];
		$this->site->assign($data);
	}
	public function more()
	{
		$data['config'] = $this->site->getSettings();
		$category_id = intval($_REQUEST['category_id']);
		$id = intval($_REQUEST['id']);
		$data['slider'] = [];
		$top = [];
		$top_ids = [];
		if ($id == 0) {
			$slider = $this->site->sliderModule->getList(['uniacid' => $this->site->site_id, 'source' => $category_id], 'display_order asc');
			foreach ($slider as $s) {
				if ($s['start'] < time() && $s['end'] > time()) {
					if ($s['type'] == 0) {
						$data['slider'][] = ['title' => $s['title'], 'src' => $this->site->formatArrImage(json_decode($s['image'], true)[0])['url'], 'url' => $s['jump'] ? $s['url'] : $this->site->mobileUrl('detail', ['category_id' => $s['category_id'], 'id' => $s['article_id']])];
						$top_ids[] = $s['article_id'];
					} else {
						$top[] = $s;
					}
				}
			}
		}
		if ($category_id == 0) {
			$cate = $this->site->getCategory();
			$article = $this->site->getNewsArticles($cate);
			foreach ($article as $value) {
				if ($value['article']) {
					foreach ($value['article'] as $v) {
						$v['category_id'] = $value['category']['id'];
						$v['kw'] = $v['kw'] ? $v['kw'] : $value['category']['name'];
						$data['article'][] = $v;
					}
				}
			}
			$data['more'] = false;
		} else {
			$where['id <'] = $id;
			$data['more'] = true;
			if ($id == 0) {
				$where = [];
			}
			$data['article'] = $this->site->articleModule->getList($category_id, $where, ['id', 'type', 'special', 'author', 'title', 'image', 'kw', 'jump', 'url', 'time_step', 'praise'], 'id desc', $this->size);
			if (count($data['article']) < $this->size) {
				$data['more'] = false;
			}
			foreach ($data['article'] as $art) {
				if (!in_array($art['id'], $top_ids)) {
					$new_article[] = $art;
				}
			}
			$data['article'] = $new_article;
		}
		if ($top) {
			$top = $this->site->arrayIndex($top, 'display_order');
		}
		$new_article = [];
		$ii = 1;
		foreach ($data['article'] as $value) {
			while (isset($top[$ii])) {
				$new_article[] = $this->_formatarticle($category_id, $top[$ii], true);
				unset($top[$ii]);
				$ii++;
			}
			$new_article[] = $this->_formatarticle($category_id, $value);
			$data['min_id'] = $value['id'];
			$ii++;
		}
		foreach ($top as $new) {
			if ($new) {
				$new_article[] = $this->_formatarticle($category_id, $new, true);
			}
		}
		$data['article'] = $new_article;
		global $_W;
		$cate = $this->site->getCategory();
		$cate = $this->site->arrayIndex($cate, 'id');
		$category = $cate[$category_id];
		$data['share'] = ['title' => $data['config']['name'] . '-' . $category['name'], 'desc' => '最新' . $category['name'] . '信息', 'link' => $this->site->webmobileUrl('detail', ['category_id' => $category_id])];
		echo json_encode($data);
		exit;
	}
	private function _formatarticle($category_id, $value, $top = false)
	{
		$image = @json_decode($value['image'], true);
		$value['count'] = 0;
		$value['time'] = $this->site->formatTime($value['time_step']);
		if (is_array($image) && $image) {
			$value['count'] = count($image) < 3 ? 1 : 3;
			foreach ($image as $key => $im) {
				$value['image_' . $key] = $this->site->formatArrImage($im)['url'];
			}
		}
		unset($value['image']);
		if ($value['category_id']) {
			$category_id = $value['category_id'];
		}
		$value['url'] = $value['jump'] ? $value['url'] : $this->site->mobileUrl('detail', ['category_id' => $category_id, 'id' => $value['id']]);
		$value['kw'] = $value['kw'] ? $value['kw'] : '';
		if (!$value['kw'] && $value['type'] > 1) {
			$value['kw'] = $this->site->article_type[$value['type']];
		}
		if ($top) {
			$value['url'] = $value['jump'] ? $value['url'] : $this->site->mobileUrl('detail', ['category_id' => $category_id, 'id' => $value['article_id']]);
			$value['id'] = $value['article_id'];
			$value['author'] = $this->site->article_type[$value['type']];
			if (!$value['kw']) {
				$value['kw'] = '置顶';
			}
			$value['time'] = $this->site->formatTime($value['create_time']);
		}
		return $value;
	}
}