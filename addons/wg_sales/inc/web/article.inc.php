<?php
class Wg_sales_Web_Article extends SalesBaseController{

    public static $URL = 'https://api.datougou.cn/index/news?site=%s&sign=%s&timestamp=%s&url=%s';
    /**
     * @var  Wg_salesModuleSite $site
     */
    public $site = null;
    public $uid  = null;
    public static $PAGE_SIZE = 10;

    public static $TYPE = [];
    public static $VIDEO_TYPE = [];
    public function init() {
        parent::init();
        self::$TYPE = $this->site->article_type;
        self::$VIDEO_TYPE = $this->site->article_video_type;
        $this->uid  = $this->site->_W['uniacid'];
        $this->site->loadmodule('categoryModule');
        $this->site->loadmodule('articleModule');
        $this->site->loadmodule('articleAdModule');

    }

    public function index() {
        $data['category_id'] = trim($this->site->_GPC['category_id']);
        $data['cate']        = $this->site->categoryModule->getAllCategory(['uniacid' => $this->uid,'del' => 0]);
        $category_id = 0;
        if($data['cate']) {
            foreach($data['cate'] as $cate) {
                if($cate['id'] == $data['category_id']) {
                    $category_id = $cate['id'];
                    break;
                }
            }
            if(!$category_id) {
                $category_id = $data['cate'][0]['id'];
            }

            $count = $this->site->articleModule->count($category_id,[]);// 查询满足要求的总记录数 $map表示查询条件
            $page = intval($_GET['p']) ? intval($_GET['p']):1;
            $this->site->loadmodule('page', [], false);
            $pag  = new Page($count, self::$PAGE_SIZE);
            $show = $pag->show();// 分页显示输出

            $field = ['id','type','author','title','image','url','text','praise','read_times','time_step','jump'];
            $list = $this->site->articleModule->getList($category_id,[],$field,'id desc',[$page, self::$PAGE_SIZE]);


            $data['category_id'] = $category_id;
            $data['list'] = $list;
            $data['show'] = $show;
        }


        $this->site->assign($data);
    }

    public function getOne() {
        $category_id   = intval($_POST['category_id']);
        $article_id = intval($_POST['article_id']);
        $article = $this->site->articleModule->getOne($category_id,['id' => $article_id], ['id','title','image']);
        if(!$article) {
            echo json_encode(['code' => 1, 'msg' => '文章不存在']);
        } else {
            $image = @json_decode($article['image'], true);
            if($image) {
                foreach($image as $im) {
                    $new_image[] = $this->site->formatArrImage($im);
                }
            } else {
                $new_image = [];
            }
            $article['image'] = $new_image;
            echo json_encode(['code' => 0, 'data' => $article]);
        }
        exit;
    }

    public function edit() {
        $category_id   = intval($this->site->_GPC['category_id']);
        $source        = intval($_POST['source']);
        $id            = intval($this->site->_GPC['id']);
        $data['cate']  = $this->site->categoryModule->getAllCategory(['uniacid' => $this->uid,'del' => 0]);
        $in = false;
        if($source) {
            $category_id = $source;
        }
        foreach($data['cate'] as $cate) {
            if($cate['id'] == $category_id) {
                $category_id   = $cate['id'];
                $category_name = $cate['name'];
                $in = true;
                break;
            }
        }
        if(!$in) {
            $category_id   = $data['cate'][0]['id'];
            $category_name = $data['cate'][0]['name'];
        }
        $article = [];

        $data['ad_list'] = $this->site->articleAdModule->getList([],'*',['id desc']);

        if($this->site->ispost()) {
            if(!$category_id) {
                message('请先添加分类');
            }
            //image
            $pic   = $_POST['pic'];
            $type  = intval($_POST['type']);
            $type  = isset(self::$TYPE[$type]) ? $type : '';
            if(!$type) {
                message('类型错误');
            }
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

            $id = intval($_POST['id']);
            $special = 0;
            if($_POST['comment']) {
                $special = $this->site->special['comment'];
            }
            if($_POST['uncomment']) {
                $special |= $this->site->special['uncomment'];
            }
            if($_POST['pay']) {
                $special |= $this->site->special['pay'];
            }
            if($_POST['first']) {
                $special |= $this->site->special['first'];
            }

            $ad_info = [
                'ad_1' => intval($_POST['ad_1']),
                'ad_2' => intval($_POST['ad_2']),
                'ad_3' => intval($_POST['ad_3']),
            ];

            $save = [
                'title'      => trim($_POST['title']),
                'type'       => $type,
                'state'      => trim($_POST['state']),
                'author'     => trim($_POST['author']),
                'kw'         => trim($_POST['kw']),
                'jump'       => trim($_POST['jump']),
                'praise'     => intval($_POST['praise']),
                'read_times' => intval($_POST['read_times']),
                'text'       => trim($_POST['text']),
                'content'    => trim($_POST['myEditor']),
                'url'        => trim($_POST['url']),
                'data_type'  => 0,
                'image'      => json_encode($image),
                'time_step'  => strtotime($_POST['time_step']),
                'goods_info' => json_encode($ad_info),
                'special'    => $special,
            ];


            if($save['title'] == '') {
                message('标题不能为空');
            }
            if($save['jump']==1 && $save['url'] == '') {
                message('跳转地址不能为空');
            }
            //新闻
            if($type == 1) {
                if($save['content'] == '' && $save['jump']==0) {
                    message('内容不能为空');
                }
            }elseif ($type == 2) {
                $image_content = $_POST['content_image'];
                $image_slider  = [];
                if($image_content) {
                    foreach ($image_content as $kk => $imm) {
                        if($imm) {
                            $zz = [
                                'url'   => $this->site->formatArrImage(['url' => $imm])['url'],
                                'brief' => htmlspecialchars(trim($_POST['content_image_brief'][$kk]))
                            ];
                            $image_slider[] = [
                                'type' => 'image',
                                'data' => [
                                    'original' => $zz,
                                    'big'      => $zz,
                                    ]
                                ];
                        }
                    }
                }
                if(!$image) {
                    message('图集至少一张封面图');
                }
                if(!$image_slider) {
                    message('图集不能为空');
                }
                $save['data_type'] = 1;
                $save['content']   = json_encode([
                    'content' => $image_slider
                ],JSON_UNESCAPED_UNICODE);

            }elseif ($type == 3) {
                if(!$image) {
                    message('视频至少一张封面图');
                }
                $video['video_type'] = trim($_POST['video_type']);
                $video['content']    = $save['content'];
                $video['video_url']  = trim($_POST['video_url']);
                if($video['video_type'] == 'iframe') {
                    preg_match("/<iframe.*?src='(.+?)'.*?>/i", $video['video_url'],$arr1);
                    preg_match("/<iframe.*?src=\"(.+?)\".*?>/i", $video['video_url'],$arr2);
                    preg_match("/<iframe.*?src=(.+?) .*?>/i", $video['video_url'],$arr3);
                    if($arr1[1]) {
                        $video['video_url'] = $arr1[1];
                    }elseif($arr2[1]) {
                        $video['video_url'] = $arr2[1];
                    } elseif($arr3[1]) {
                        $video['video_url'] = $arr3[1];
                    }
                }

                if(!$video['video_type'] || !$video['video_url']) {
                    message('视频类型或地址错误');
                }
                $save['data_type'] = 1;
                $save['content']   = json_encode($video);
            }


            if($id) {
                $this->site->articleModule->update($category_id,['id' => $id],$save);
                $re = $id;
            } else {
                $save['md5'] = md5(time().rand(0,99999999));
                $re = $this->site->articleModule->add($category_id,$save);
            }
            if($re) {
                message('保存成功', $this->site->webUrl('article',['category_id' => $category_id]));
            } else {
                message('保存失败');
            }
        }
        if($id) {
            $article = $this->site->articleModule->getOne($category_id,['id' => $id]);
            if(!$article) {
                message('文章不存在', $this->site->webUrl('article'));
            }
            $data['category_id']   = $category_id;
            $data['category_name'] = $category_name;
            $content_image = [];
            //视频流处理
            if($article['type'] == 3) {
                $video = json_decode($article['content'], true);
                $article['video_type'] = $video['video_type'];
                $article['video_url']  = $video['video_url'];
                $article['content']    = $video['content'];
                if($article['video_type'] == 'iframe') {
                    $article['video_url']  = $this->site->getVideoTemplate($video['video_url']);
                }

            } else{
                if($article['data_type'] == 1) {
                    $content = json_decode($article['content'],true)['content'];
                    $ccc = '';
                    if($content) {
                        foreach($content as $value) {
                            if($value['type'] == 'text') {
                                $ccc.="<p>".$value['data']."</p>";
                            }elseif($value['type'] == 'image') {
                                $ccc.="<p><img src='{$value['data']['big']['url']}'></p>";
                                //图集
                                $content_image[] = $value['data']['big'];
                                if($value['data']['big']['brief']) {
                                    $ccc.="<p>".$value['data']['big']['brief']."</p>";
                                }

                            }
                        }
                    }
                    $article['content'] = $ccc;
                } else {
                    $imgpreg = "/<img.*?src=\"(.+?)\".*?>/i";
                    preg_match_all($imgpreg,$article['content'],$img);
                    if($img) {
                        foreach ($img[1] as $vvv) {
                            $content_image[] = [
                                'url' => $vvv
                            ];
                        }
                    }

                }
            }


            $images = @json_decode($article['image'], true);
            if($images) {
                foreach($images as &$im) {
                    $im['url'] = $this->site->formatArrImage($im)['url'];
                }
            }
            //图集
            $article['content_image'] = $content_image;
            $article['image'] = $images;

            //ad
            $ad_info = json_decode($article['goods_info'],true);
            if($ad_info) {
                $data = array_merge($data,$ad_info);
            }

        }


        $data['type']    = self::$TYPE;
        $data['video_type']    = self::$VIDEO_TYPE;
        $data['article'] = $article;

        $this->site->assign($data);
    }

    public function spider() {
        $url = $_POST['url'];
        if(!$url) {
            echo json_encode(['code' => 1, 'msg' => 'url地址错误']);
            exit;
        }
        $data = $this->site->getSettings();
        $sign = $this->site->getSignedData($data['token'],[
            'site'      => $data['site'],
            'timestamp' => time(),
            'url'       => $url
        ]);
        $url  = sprintf(self::$URL, $data['site'],$sign['sign'],time(), $url);
        $data = json_decode($this->site->send_http_request($url), true);
        if($data['ec'] == 200 && $data['data']) {
            $data['data']['time_step'] = date('Y-m-d H:i:s', $data['data']['time_step']);
            echo json_encode(['code' => 0, 'msg' => '', 'data' => $data['data']]);
            exit;
        } else {
            echo json_encode(['code' => 1, 'msg' => $data['em']]);
            exit;
        }
    }

    public function del() {
        $id = intval($_POST['id']);
        $category_id = intval($_POST['category_id']);
        //all-category
        $data['cate']  = $this->site->categoryModule->getAllCategory(['uniacid' => $this->uid,'del' => 0]);

        $in = false;
        foreach($data['cate'] as $cate) {
            if($cate['id'] == $category_id) {
                $in = true;
                break;
            }
        }
        if(!$in) {
            echo json_encode(['code' => 1, 'msg' => '删除失败']);
            exit;
        }

        $result = $this->site->articleModule->del($category_id, ['id' => $id]);
        if($result) {
            echo json_encode(['code' => 0]);
        } else {
            echo json_encode(['code' => 2, 'msg' => '删除失败']);
        }
        exit;
    }

}

