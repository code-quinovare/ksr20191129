<?php

class Wg_sales_Web_Slider extends SalesBaseController
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
		$data['source'] = intval($_GET['source']);
		$data['cate'] = $this->site->categoryModule->getAllCategory(['uniacid' => $this->uid, 'del' => 0]);
		$list = $this->site->sliderModule->getList(['uniacid' => $this->uid, 'source' => $data['source'], 'type' => 0], 'display_order asc');
		$data['list'] = $list;
		$this->site->assign($data);
	}
	public function setting()
	{
		$category_id = intval($this->site->_GPC['category_id']);
		$id = intval($this->site->_GPC['id']);
		$data['cate'] = $this->site->categoryModule->getAllCategory(['uniacid' => $this->uid, 'del' => 0]);
		$in = false;
		foreach ($data['cate'] as $cate) {
			if ($cate['id'] == $category_id) {
				$category_id = $cate['id'];
				$in = true;
				break;
			}
		}
		if (!$in) {
			$category_id = $data['cate'][0]['id'];
		}
		$count = $this->site->sliderModule->count(['uniacid' => $this->uid, 'category_id' => $category_id]);
		if ($count > 30) {
			echo json_encode(['code' => 1, 'msg' => '最多添加6张轮播图']);
			exit;
		}
		if ($id) {
			$article = $this->site->articleModule->getOne($category_id, ['id' => $id]);
			if ($article) {
				$image = @json_decode($article['image'], true);
				if ($image && count($image) > 0) {
					$add = $this->site->sliderModule->add(['uniacid' => $this->uid, 'category_id' => $category_id, 'article_id' => $id, 'image' => $this->site->formatArrImage($image[0])['url'], 'title' => $article['title'], 'create_time' => time(), 'display_order' => 10, 'start' => time(), 'end' => time() + 3600 * 2]);
					if ($add) {
						echo json_encode(['code' => 0]);
						exit;
					}
				} else {
					echo json_encode(['code' => 1, 'msg' => '文章无图片']);
					exit;
				}
			}
		}
		echo json_encode(['code' => 1, 'msg' => '添加失败']);
		exit;
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
		if (!$in && $source == -1) {
			$source = -1;
			$source_name = '首页TOP-NEWS';
		} elseif (!$in) {
			$index = $this->site->getCategoryIndex();
			$source = 0;
			$source_name = $index['name'];
		}
		$slider = [];
		$image_one[] = ['url' => trim($_POST['pic'])];
		if ($this->site->ispost()) {
			$id = intval($_POST['id']);
			$save = ['uniacid' => $this->uid, 'category_id' => $category_id, 'source' => $source, 'type' => 0, 'article_id' => intval($_POST['article_id']), 'image' => json_encode($image_one), 'url' => trim($_POST['url']), 'jump' => intval($_POST['jump']), 'title' => trim($_POST['title']), 'create_time' => time(), 'display_order' => intval($_POST['display_order']), 'start' => strtotime(trim($_POST['start'])), 'end' => strtotime(trim($_POST['end']))];
			if (($save['title'] == '' || trim($_POST['pic']) == '') && $save['source'] != -1) {
				message('标题或图片不能为空');
			}
			if ($save['jump'] == 1 && $save['url'] == '') {
				message('url不能为空');
			}
			if ($save['jump'] == 0) {
				if ($save['article_id'] <= 0) {
					message('文章ID不能为空');
				}
				$article = $this->site->articleModule->getOne($category_id, ['id' => $save['article_id']], 'id');
				if (!$article) {
					message('文章ID对应的文章不存在');
				}
			}
			if ($id) {
				$re = $this->site->sliderModule->update(['uniacid' => $this->uid, 'id' => $id], $save);
			} else {
				$re = $this->site->sliderModule->add($save);
			}
			if ($re) {
				message('保存成功', $this->site->webUrl('slider', ['source' => $source]));
			} else {
				message('保存失败');
			}
		}
		if ($id) {
			$slider = $this->site->sliderModule->getOne(['uniacid' => $this->uid, 'id' => $id]);
			$images = @json_decode($slider['image'], true)[0];
			$slider['image'] = $this->site->formatArrImage($images)['url'];
			if (!$slider) {
				message('轮播图不存在', $this->site->webUrl('article'));
			}
		}
		$data['source'] = $source;
		$data['source_name'] = $source_name;
		$data['slider'] = $slider;
		$this->site->assign($data);
	}
	public function spider()
	{
		$url = $_POST['url'];
		if (!$url) {
			echo json_encode(['code' => 1, 'msg' => 'url地址错误']);
			exit;
		}
		$url = sprintf(self::$URL, $url);
		$data = json_decode(file_get_contents($url), true);
		if ($data['ec'] == 200 && $data['data']) {
			$data['data']['time_step'] = date('Y-m-d H:i:s', $data['data']['time_step']);
			echo json_encode(['code' => 0, 'msg' => '', 'data' => $data['data']]);
			exit;
		} else {
			echo json_encode(['code' => 1, 'msg' => '抓取失败']);
			exit;
		}
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