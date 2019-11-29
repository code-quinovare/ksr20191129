<?php

class Wg_sales_Web_Comment extends SalesBaseController
{
	public static $PAGE_SIZE = 10;
	public function init()
	{
		parent::init();
		$this->uid = $this->site->_W['uniacid'];
		$this->site->loadmodule('categoryModule');
		$this->site->loadmodule('commentModule');
		$this->site->loadmodule('articleModule');
	}
	public function index()
	{
		$data['article_id'] = intval($_GET['article_id']);
		$data['category_id'] = trim($this->site->_GPC['category_id']);
		$data['cate'] = $this->site->categoryModule->getAllCategory(['uniacid' => $this->uid, 'del' => 0]);
		$category_id = 0;
		if ($data['cate']) {
			foreach ($data['cate'] as $cate) {
				if ($cate['id'] == $data['category_id']) {
					$category_id = $cate['id'];
					break;
				}
			}
			if (!$category_id) {
				$category_id = $data['cate'][0]['id'];
			}
			$list = [];
			$count = $this->site->commentModule->count($category_id, []);
			$this->site->loadmodule('page', [], false);
			$pag = new Page($count, self::$PAGE_SIZE);
			$show = $pag->show();
			if ($data['article_id']) {
				$where = ['article_id' => $data['article_id']];
			} else {
				$where = [];
			}
			$page = intval($_GET['p']) ? intval($_GET['p']) : 1;
			$list = $this->site->commentModule->getList($category_id, $where, '*', 'id desc', [$page, self::$PAGE_SIZE]);
			if ($list) {
				foreach ($list as $comment) {
					$article_ids[] = $comment['article_id'];
				}
				$article_ids = array_unique($article_ids);
				$articles = $this->site->articleModule->getList($category_id, ['id' => $article_ids], ['title', 'id'], 'id desc', self::$PAGE_SIZE);
				$articles = $this->site->arrayIndex($articles, 'id');
				foreach ($list as &$value) {
					$value['article'] = $articles[$value['article_id']];
				}
			}
			$data['category_id'] = $category_id;
			$data['list'] = $list;
			$data['show'] = $show;
		}
		$this->site->assign($data);
	}
	public function del()
	{
		$id = intval($_POST['id']);
		$category_id = intval($_POST['category_id']);
		$data['cate'] = $this->site->categoryModule->getAllCategory(['uniacid' => $this->uid, 'del' => 0]);
		$in = false;
		foreach ($data['cate'] as $cate) {
			if ($cate['id'] == $category_id) {
				$in = true;
				break;
			}
		}
		if (!$in) {
			echo json_encode(['code' => 1, 'msg' => '删除失败']);
			exit;
		}
		$result = $this->site->commentModule->del($category_id, ['id' => $id]);
		if ($result) {
			echo json_encode(['code' => 0]);
		} else {
			echo json_encode(['code' => 2, 'msg' => '删除失败']);
		}
		exit;
	}
}