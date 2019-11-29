<?php

class Wg_sales_Web_Top extends SalesBaseController
{
	public static $MAX_SLIDER = 6;
	public static $PAGE_SIZE = 10;
	public function init()
	{
		parent::init();
		$this->uid = $this->site->_W['uniacid'];
		$this->site->loadmodule('categoryModule');
		$this->site->loadmodule('articleModule');
		$this->site->loadmodule('sliderModule');
	}
	public function index()
	{
		$data['index'] = $this->site->getCategoryIndex();
		$data['source'] = intval($this->site->_GPC['source']);
		$data['cate'] = $this->site->categoryModule->getAllCategory(['uniacid' => $this->uid, 'del' => 0]);
		$list = $this->site->sliderModule->getList(['uniacid' => $this->uid, 'source' => $data['source'], 'type >' => 0], 'display_order asc');
		$data['list'] = $list;
		$this->site->assign($data);
	}
	public function edit()
	{
		$category_id = intval($this->site->_GPC['category_id']);
		$id = intval($this->site->_GPC['id']);
		$source = intval($_GET['source']);
		$data['cate'] = $this->site->categoryModule->getAllCategory(['uniacid' => $this->uid, 'del' => 0]);
		$in = false;
		$source_name = '';
		foreach ($data['cate'] as $cate) {
			if ($cate['id'] == $source) {
				$source = $cate['id'];
				$source_name = $cate['name'];
				$in = true;
				break;
			}
		}
		if (!$in) {
			$index = $this->site->getCategoryIndex();
			$source = 0;
			$source_name = $index['name'];
		}
		$slider = [];
		if ($this->site->ispost()) {
			$id = intval($_POST['id']);
			$image = [];
			foreach ($_POST['pic'] as $k => $im) {
				if ($im) {
					$image[] = ['url' => $this->site->formatArrImage(['url' => $im])['url']];
				}
				if (count($image) > 2) {
					break;
				}
			}
			$save = ['uniacid' => $this->uid, 'category_id' => $category_id, 'source' => $source, 'type' => intval($_POST['type']), 'kw' => trim($_POST['kw']), 'article_id' => intval($_POST['article_id']), 'image' => json_encode($image), 'url' => trim($_POST['url']), 'jump' => intval($_POST['jump']), 'title' => trim($_POST['title']), 'create_time' => time(), 'display_order' => intval($_POST['display_order']) ? intval($_POST['display_order']) : 1, 'start' => strtotime(trim($_POST['start'])), 'end' => strtotime(trim($_POST['end']))];
			if ($save['title'] == '' || $save['image'] == '') {
				message('标题或图片不能为空');
			}
			if ($save['jump'] == 1 && $save['url'] == '') {
				message('url不能为空');
			}
			if ($save['jump'] == 0) {
				if ($save['article_id'] <= 0) {
					message('文章ID不能为空');
				}
				$article = $this->site->articleModule->getOne($category_id, ['id' => $save['article_id']], ['id', 'type']);
				if (!$article) {
					message('文章ID对应的文章不存在');
				}
				$save['type'] = $article['type'];
			}
			if ($id) {
				$re = $this->site->sliderModule->update(['uniacid' => $this->uid, 'id' => $id], $save);
			} else {
				$re = $this->site->sliderModule->add($save);
			}
			if ($re) {
				message('保存成功', $this->site->webUrl('top', ['source' => $source]));
			} else {
				message('保存失败');
			}
		}
		if ($id) {
			$slider = $this->site->sliderModule->getOne(['uniacid' => $this->uid, 'id' => $id]);
			$images = @json_decode($slider['image'], true);
			$new_image = [];
			if ($images) {
				foreach ($images as $im) {
					$new_image[]['url'] = $this->site->formatArrImage($im)['url'];
				}
			}
			$slider['image'] = $new_image;
			if (!$slider) {
				message('轮播图不存在');
			}
		}
		$data['type'] = $this->site->article_type;
		$data['source'] = $source;
		$data['source_name'] = $source_name;
		$data['slider'] = $slider;
		$this->site->assign($data);
	}
	public function del()
	{
		$id = intval($_POST['id']);
		$result = $this->site->sliderModule->del(['id' => $id, 'uniacid' => $this->uid]);
		if ($result) {
			echo json_encode(['code' => 0]);
		} else {
			echo json_encode(['code' => 1, 'msg' => '删除失败']);
		}
		exit;
	}
}