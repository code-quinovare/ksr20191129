<?php

class Wg_sales_Mobile_Detail extends SalesBaseController{

    /**
     * @var  Wg_salesModuleSite $site
     */
    public $site = null;
    public $data = [];
    public $size = 10;
    public function init() {
        parent::init();

        $this->site->loadmodule('articleModule');
        $this->site->loadmodule('categoryModule');
        $this->site->loadmodule('articleAdModule');
        $this->site->loadmodule('commentModule');
        $this->site->loadmodule('orderModule');
    }

    public function index() {
        $category_id = intval($_REQUEST['category_id']);
        $id          = intval($_REQUEST['id']);
        $data['cate']      = $this->site->getCategory();
        $data['category']  = $this->site->categoryModule->getOne(['id' => $category_id]);
        $data['category_id'] = $category_id;
        $flag = true;
        if(!$data['category']) {
            $flag = false;
        } else {
            $data['config']    = $this->site->getSettings();
            $data['article']     = $this->site->articleModule->getOne($category_id,['id' => $id]);

            //
            $key = 'wg_sales_comment_article_'.$category_id.'_'.$id;
            if($_COOKIE[$key]) {
            }else {
                $this->site->articleModule->update($category_id,['id' => $id],['read_times +='=>'1']);
                setcookie($key, 1, time()+3600,'/');
            }

            if($data['article']['type'] == 3) {
                $video = json_decode($data['article']['content'], true);
                $data['article']['video_type'] = $video['video_type'];
                $data['article']['video_url']  = $video['video_url'];
                $data['article']['image']      = json_decode($data['article']['image'], true)[0]['url'];
                $data['article']['content']    = $video['content'];
            } else {
                if ($data['article']['data_type'] == 1) {
                    $content = '';
                    $c = json_decode($data['article']['content'], true)['content'];
                    foreach ($c as $value) {
                        if ($value['type'] == 'image') {
                            $data['slider'][] = $value['data']['original'];
                            $content .= '<p><img src="' . $value['data']['original']['url'] . '"/></p>';
                        } elseif ($value['type'] == 'text') {
                            $content .= '<p>' . $value['data'] . '<p/>';
                        }
                    }

                    $data['article']['content'] = $content;
                }
                if (!$data['article']) {
                    $flag = false;
                }
            }
            //share
            global $_W;
            $s_images = @json_decode($data['article']['image'], true);
            if(is_array($s_images) && $s_images) {
                $s_image = $this->site->formatArrImage($s_images[0])['url'];
            } else {
                $share = $this->site->_getCache('share');
                $s_image = $share['picurl'];
            }
            if(strpos($s_image,'http') === false) {
                $s_image = $_W['attachurl'].$s_image;
            }
            $data['share'] = [
                'title'  => $data['article']['title'],
                'desc'   => $data['article']['text'] ? $data['article']['text'] : '',
                'link'   => $_W['siteurl'].'&fromfuid='.$_SESSION['wg']['user'][$this->site->site_id]['id'],
                'imgUrl' => $s_image,
            ];
        }

        if($flag) {
            $where['id <'] = $id;
            $data['relation']  = $this->site->articleModule->getList(
                $category_id,
                $where,
                ['id','title','jump','url'],
                'id desc',
                2);
            $data['comment']  = $this->site->commentModule->getList($category_id,['article_id' => $id],[
                'id','type','article_id','uid','content','praise','create_time',
            ],'id desc',10);
            $data['comment'] = $this->site->formatComment($data['comment']);
        }

        $data['list'] = $this->site->getNewsArticles($data['cate']);

        $ad_id = json_decode($data['article']['goods_info'], true);
        $ad_ids = [];
        //ad-global
        $ad_setting = $this->site->getSettings();
        foreach(self::$AD_TYPE as $key => $value) {
            if(!isset($ad_id[$key]) && $ad_setting[$key]) {
                $ad_id[$key] = $ad_setting[$key];
            }
        }

        foreach($ad_id as $value) {
            $ad_ids[] = $value;
        }
        if($ad_ids) {
            $data['ads'] = $this->site->articleAdModule->getList([
                'id' => $ad_ids,
            ],['*']);
            $ads = $this->site->arrayIndex($data['ads'],'id');
            foreach($ad_id as $k => $v) {
                $data[$k] = $ads[$v];
            }
        }


        $this->site->assign($data);

        if(!$flag) {
            $this->site->display('detail/error');
        }
        if($data['article']['type'] == 2) {
            $this->site->display('detail/image');
        }
        $this->site->display('detail/pay');
    }

    public function video() {
        $category_id = intval($_REQUEST['category_id']);
        $id          = intval($_REQUEST['id']);
        $data['article']     = $this->site->articleModule->getOne($category_id,['id' => $id]);
        if($data['article']['type'] == 3) {
            $video = json_decode($data['article']['content'], true);
            $data['article']['video_type'] = $video['video_type'];
            $data['article']['video_url']  = $video['video_url'];
            $data['article']['image']      = json_decode($data['article']['image'], true)[0]['url'];
            $data['article']['content']    = $video['content'];
        }
        $this->site->assign($data);
        $this->site->display('detail/video4');
    }



    //匿名评论目前
    public function comment() {
        $data['content']     = trim($_REQUEST['content']);
        $data['article_id']  = intval($_REQUEST['article_id']);
        $data['create_time'] = time();
        $category_id         = intval($_REQUEST['category_id']);
        $article             = $this->site->articleModule->getOne($category_id,['id' => $data['article_id']],['special']);

        //登录用户
        if($_SESSION['wg']['user'][$this->site->site_id]) {
            $data['uid'] =$_SESSION['wg']['user'][$this->site->site_id]['id'];
        }
        if($article['special'] & $this->site->special['uncomment']) {
            if(!$data['content']) {
                echo json_encode(['code' => 1,'msg' => '内容不能为空']);exit;
            }
            $result = $this->site->commentModule->add($category_id,$data);
            if($result) {
                $this->site->articleModule->update($category_id,['id' => $data['article_id']],['comment_times +='=>'1']);
                echo json_encode(['code' => 0,'msg' => '']);exit;
            }
        }
        echo json_encode(['code' => 1,'msg' => '评论失败']);exit;

    }

    public function praise() {
        $id = intval($_REQUEST['id']);
        $category_id = intval($_REQUEST['category_id']);
        $key = 'wg_sales_praise_'.$category_id.'_'.$id;
        if($_COOKIE[$key]) {
            echo json_encode(['code' => 1,'msg' => '']);exit;
        }
        $this->site->commentModule->update($category_id,['id' => $id],['praise +='=>'1']);
        setcookie($key, 1, time()+3600*24,'/');
        echo json_encode(['code' => 0,'msg' => '']);exit;
    }

    public function praisearticle() {
        $id = intval($_REQUEST['id']);
        $category_id = intval($_REQUEST['category_id']);
        $key = 'wg_sales_praise_article_'.$category_id.'_'.$id;
        if($_COOKIE[$key]) {
            echo json_encode(['code' => 1,'msg' => '']);exit;
        }
        $this->site->articleModule->update($category_id,['id' => $id],['praise +='=>'1']);
        setcookie($key, 1, time()+3600*24,'/');
        echo json_encode(['code' => 0,'msg' => '']);exit;
    }
    public function commentlist() {

    }

    public function reward() {
        $this->site->loadmodule('userModule');
        $category_id = (int)$_REQUEST['category_id'];
        $article_id  = (int)$_REQUEST['article_id'];
        $id          = (int)$_REQUEST['id'];
        $where = [
            'category_id' => $category_id,
            'article_id'  => $article_id,
            'status'      => 2,
        ];

        $data['more'] = true;
        if($id > 0) {
            $where['id <'] = $id;
        }
        $list = $this->site->orderModule->getList(
            $where,
            ['uid','pay_money','id'],
            'id desc',
            $this->size);
        if($list) {
            foreach($list as $reward) {
                if($reward['uid']) {
                    $user_ids[] = $reward['uid'];
                }
            }

            $user_ids = array_unique($user_ids);
            $users = $this->site->userModule->getList(['id' => $user_ids],['nickname','headimgurl','id']);
            $users = $this->site->arrayIndex($users,'id');

            foreach($list as &$value) {
                if(!$users[$value['uid']]['headimgurl']) {
                    $users[$value['uid']]['headimgurl'] = STATIC_ROOT .'/images/head.png';
                }
                $value['headimgurl'] = $users[$value['uid']]['headimgurl'];
                $value['nickname']   = $users[$value['uid']]['nickname'];
            }
        }
        if(count($list) < $this->size) {
            $data['more'] = false;
        }
        $data['list'] = $list;
        echo json_encode($data);exit;
    }

}