<?php

class Wg_sales_Web_Webpub extends SalesBaseController{

    public $cate = [];

    public $size = 10;

    public function init() {
        parent::init();

        $this->site->loadmodule('pubModule');
        $this->site->loadmodule('categoryModule');
        $this->site->loadmodule('articleModule');
    }

    public function index() {
        $pindex = max(1, intval($this->site->_GPC['page']));
        $cate = intval($_GET['cate']);
        $cate = $cate ? $cate : 1;

        $where = [
            'uid'  => $this->uid,
            'cate' => $cate
        ];

        $total  = $this->site->pubModule->count($where);
        $page   = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $data['category'] = $this->site->categoryModule->getAllCategory(['uniacid' => $this->uid,'del' => 0]);
        $data['category'] = $this->site->arrayIndex($data['category'],'id');
        $data['list'] = $this->site->pubModule->getList($where,'*',['id desc'],[$page, $this->size]);
        $data['pager'] = pagination($total, $pindex, $this->size);
        $data['cate']  = $cate;
        $this->site->assign($data);
    }

    public function edit() {
        //
        $id    = (int)$this->site->_GPC['id'];
        $where = ['id' => $id];
        if($this->site->ispost()) {

            $pic   = $_POST['image'];
            $image = [];
            if($pic) {
                foreach ($pic as $k => $im) {
                    if($im) {
                        $image[] = [
                            'url'   => $this->site->formatArrImage(['url' => $im])['url'],
                        ];
                    }
                    if(count($image) > 2) break;
                }
            }
            $data['category_id'] = intval($_POST['category_id']);
            $data['title']       = trim($_POST['title']);
            $data['content']     = trim($_POST['content']);
            $data['image']       = json_encode($image);

            if(!$data['content'] || !$data['title']) {
                message('内容或标题不能为空');
            }

            if($id) {
                $result =  $this->site->pubModule->update($where, $data);
            } else {
                $result =  $this->site->pubModule->add($data);
            }
            if($result) {
                message('更新成功', $this->site->webUrl('pub'));
            } else {
                message('更新失败');
            }
        }
        if($id) {
            $data['article'] = $this->site->pubModule->getOne($where);
            $images = @json_decode( $data['article']['image'], true);
            if($images) {
                foreach($images as &$im) {
                    $im['url'] = $this->site->formatArrImage($im)['url'];
                }
            }
            $data['article']['image'] = $images;
        }
        $data['cate']  = $this->site->categoryModule->getAllCategory(['uniacid' => $this->uid,'del' => 0]);

        $this->site->assign($data);
    }

    function del() {
        $id    = (int)$this->site->_GPC['id'];

        $article = $this->site->pubModule->getOne(['id' => $id]);
        $category_id = $article['category_id'];
        $article_id  = $article['article_id'];
        if($article_id){
            $this->site->articleModule->del($category_id,['id' => $article['article_id']]);
        }
        $this->site->pubModule->del(['id' => $id]);
        echo json_encode(['code' => 0]);exit;
    }

    function status() {
        $id     = (int)$this->site->_GPC['id'];
        $status = (int)$this->site->_GPC['status'];


        $article = $this->site->pubModule->getOne(['id' => $id]);
        $category_id = $article['category_id'];
        $article_id  = $article['article_id'];
        //通过
        if($status == 1) {
            unset(
                $article['id'],
                $article['uid'],
                $article['cate'],
                $article['status'],
                $article['money'],
                $article['category_id'],
                $article['article_id'],
                $article['update_time']
            );

            $article_id = $this->site->articleModule->add($category_id,$article);
            if($article_id) {

            }else{
                echo json_encode(['code' => 1]);exit;
            }

        }elseif($article_id){
            $this->site->articleModule->del($category_id,['id' => $article['article_id']]);
        }

        $this->site->pubModule->update(['id' => $id],[
            'article_id' => $article_id,
            'status' => $status,
            'update_time' => time()
        ]);
        echo json_encode(['code' => 0]);exit;
    }
}

