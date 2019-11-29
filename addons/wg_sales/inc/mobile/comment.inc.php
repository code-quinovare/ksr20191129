<?php
class Wg_sales_Mobile_Comment extends SalesBaseController
{
	public $data = array();
	public $size = 10;
	public function init()
	{
		parent::init();
		$this->site->loadmodule('pubModule');
		$this->site->loadmodule('articleModule');
		$this->site->loadmodule('categoryModule');
		$this->site->loadmodule('commentModule');
	}
	public function index()
	{
		$category_id = intval($_REQUEST['category_id']);
		$data['cate'] = $this->site->getCategory();
		$article_id = intval($_REQUEST['id']);
		$data['category'] = $this->site->categoryModule->getOne(['id' => $category_id]);
		$data['article'] = $this->site->articleModule->getOne($category_id, ['id' => $article_id], ['id', 'special']);
		$data['config'] = $this->site->getSettings();
		$this->site->assign($data);
	}
	public function more()
	{
		$category_id = intval($_REQUEST['category_id']);
		$id = intval($_REQUEST['id']);
		$article_id = intval($_REQUEST['article_id']);
		$data['more'] = true;
		$where = ['article_id' => $article_id];
		if ($id > 0) {
			$where['id <'] = $id;
		}
		$data['comment'] = $this->site->commentModule->getList($category_id, $where, ['id', 'type', 'article_id', 'uid', 'content', 'praise', 'create_time'], 'id desc', $this->size);
		$data['comment'] = $this->site->formatComment($data['comment']);
		foreach ($data['comment'] as $co) {
			$data['min_id'] = $co['id'];
		}
		if (count($data['comment']) < $this->size) {
			$data['more'] = false;
		}
		echo json_encode($data);
		exit;
	}
}