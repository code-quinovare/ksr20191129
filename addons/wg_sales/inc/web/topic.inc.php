<?php

class Wg_sales_Web_Topic extends SalesBaseController
{
	public static $PAGE_SIZE = 10;
	public function init()
	{
		parent::init();
		$this->uid = $this->site->_W['uniacid'];
		$this->site->loadmodule('categoryModule');
		$this->site->loadmodule('articleModule');
		$this->site->loadmodule('topicModule');
		$this->site->loadmodule('topiclistModule');
	}
	public function index()
	{
		$list = $this->site->topicModule->getList(['uniacid' => $this->uid], 'display_order asc');
		$data['list'] = $list;
		$this->site->assign($data);
	}
	public function edit()
	{
		$id = intval($this->site->_GPC['id']);
		if ($this->site->ispost()) {
			$image_one[] = ['url' => trim($_POST['pic'])];
			$id = intval($_POST['id']);
			$save = ['type' => 0, 'uniacid' => $this->uid, 'title' => trim($_POST['title']), 'image' => json_encode($image_one), 'text' => trim($_POST['text']), 'display_order' => intval($_POST['display_order']), 'create_time' => time()];
			if ($save['title'] == '' || trim($_POST['pic']) == '') {
				message('标题或图片不能为空');
			}
			if ($id) {
				$re = $this->site->topicModule->update(['uniacid' => $this->uid, 'id' => $id], $save);
			} else {
				$re = $this->site->topicModule->add($save);
			}
			if ($re) {
				message('保存成功', $this->site->webUrl('topic'));
			} else {
				message('保存失败');
			}
		}
		if ($id) {
			$data['topic'] = $this->site->topicModule->getOne(['uniacid' => $this->uid, 'id' => $id]);
			$images = @json_decode($data['topic']['image'], true)[0];
			$data['topic']['image'] = $this->site->formatArrImage($images)['url'];
		}
		$data['article_type'] = $this->site->article_type;
		$this->site->assign($data);
	}
	public function topiclist()
	{
		$id = intval($this->site->_GPC['id']);
		$data['topic'] = $this->site->topicModule->getOne(['uniacid' => $this->uid, 'id' => $id]);
		if (!$data['topic']) {
			message('专题不存在');
		}
		$list = $this->site->topiclistModule->getList(['topic_id' => $id], 'display_order asc');
		$data['list'] = $list;
		$this->site->assign($data);
	}
	public function listadd()
	{
		$id = intval($this->site->_GPC['id']);
		$topic_id = intval($this->site->_GPC['topic_id']);
		$data['topic'] = $this->site->topicModule->getOne(['uniacid' => $this->uid, 'id' => $topic_id]);
		if (!$data['topic']) {
			message('专题不存在');
		}
		$data['cate'] = $this->site->categoryModule->getAllCategory(['uniacid' => $this->uid, 'del' => 0]);
		if ($this->site->ispost()) {
			$image = [];
			if ($_POST['pic']) {
				foreach ($_POST['pic'] as $k => $im) {
					if ($im) {
						$image[] = ['url' => $this->site->formatArrImage(['url' => $im])['url']];
					}
					if (count($image) > 2) {
						break;
					}
				}
			}
			$id = intval($_POST['id']);
			$save = ['category_id' => intval($_POST['category_id']), 'topic_id' => $topic_id, 'type' => intval($_POST['type']), 'article_id' => intval($_POST['article_id']), 'image' => json_encode($image), 'url' => trim($_POST['url']), 'kw' => trim($_POST['kw']), 'jump' => intval($_POST['jump']), 'title' => trim($_POST['title']), 'create_time' => time(), 'display_order' => intval($_POST['display_order'])];
			if ($save['title'] == '') {
				message('标题不能为空');
			}
			if ($save['jump'] == 1 && $save['url'] == '') {
				message('url不能为空');
			}
			if ($save['jump'] == 0) {
				if ($save['article_id'] <= 0) {
					message('文章ID不能为空');
				}
				$article = $this->site->articleModule->getOne($save['category_id'], ['id' => $save['article_id']], ['id', 'type']);
				if (!$article) {
					message('文章ID对应的文章不存在');
				}
				$save['type'] = $article['type'];
			}
			if ($id) {
				$re = $this->site->topiclistModule->update(['id' => $id], $save);
			} else {
				$re = $this->site->topiclistModule->add($save);
			}
			if ($re) {
				message('保存成功', $this->site->webUrl('topic', ['_wg' => 'topiclist', 'id' => $topic_id]));
			} else {
				message('保存失败');
			}
		}
		if ($id) {
			$data['article'] = $this->site->topiclistModule->getOne(['id' => $id, 'topic_id' => $topic_id]);
			$images = @json_decode($data['article']['image'], true);
			$new_image = [];
			if ($images) {
				foreach ($images as $im) {
					$new_image[]['url'] = $this->site->formatArrImage($im)['url'];
				}
			}
			$data['article']['image'] = $new_image;
			if (!$data['article']) {
				message('文章不存在');
			}
		}
		$data['type'] = $this->site->article_type;
		$this->site->assign($data);
	}
	public function del()
	{
		$id = intval($_POST['id']);
		$result = $this->site->topicModule->del(['id' => $id, 'uniacid' => $this->uid]);
		if ($result) {
			echo json_encode(['code' => 0]);
		} else {
			echo json_encode(['code' => 1, 'msg' => '删除失败']);
		}
		exit;
	}
	public function detaildel()
	{
		$id = intval($_POST['id']);
		$article = $this->site->topiclistModule->getOne(['id' => $id]);
		$topic = $this->site->topicModule->getOne(['id' => $article['topic_id'], 'uniacid' => $this->uid]);
		if (!$topic) {
			echo json_encode(['code' => 1, 'msg' => '删除失败']);
			exit;
		}
		$result = $this->site->topiclistModule->del(['id' => $id]);
		if ($result) {
			echo json_encode(['code' => 0]);
		} else {
			echo json_encode(['code' => 1, 'msg' => '删除失败']);
		}
		exit;
	}
}