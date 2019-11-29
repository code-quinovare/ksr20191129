<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 15/12/6
 * Time: 下午4:23
 */
include_once dirname(__FILE__) . "/BaseHandler.php";
include_once dirname(__FILE__) . "/Category.php";
class BaiduNews {
    public static $NAME = 'BaiduNews';
    public static $VALUE = '百度新闻';
    public static $CATEGORY = [
        1 => [
            'show' =>false,
            'name' => '社会',
            'id'   => 1,
        ],
        2 =>[
            'show' =>false,
            'name' => '娱乐',
            'id'   => 2
        ],
        3 =>[
            'url'=>'https://m.news.baidu.com/news?tn=bdapibaiyue&t=medianewslist&act=get',
            'name' => '图片',
            'id'   => 3,
            'post' => [
                'mid'=>'03c7a16f2e8028127e42c5f7ca9e210b',
                'ts'=>'0',
                'topic'=>'',
                'type'=>'image',
                'token'=>'image',
                'ln'=>'200',
                'an'=>10,
                'withtopic'=>'0',
                'wf'=>'0',
                'internet-subscribe'=>'0',
                'ver'=>'4',
                'platform'=>'webapp',
                'nids'=>'',
            ],
        ],
        5 =>[
            'show' => false,
            'name' => '军事',
            'id'   => 5
        ],
        6 =>[
            'name' => '女人',
            'id'   => 6,
            'post' => [
                'mid'=>'03c7a16f2e8028127e42c5f7ca9e210b',
                'ts'=>'0',
                'topic'=>'女人',
                'type'=>'info',
                'token'=>'info',
                'ln'=>'200',
                'an'=>10,
                'withtopic'=>'0',
                'wf'=>'0',
                'internet-subscribe'=>'0',
                'remote_device_type'=>'1',
                'ver'=>'4',
                'pd'=>'webapp',
                'nids'=>'',
                'os_type' => 2,
                'screen_size_width' => 320,
                'screen_size_height' => 568
            ],
        ],
        7 =>[
            'name' => '搞笑',
            'id'   => 7
        ],
        8 =>[
            'show' =>false,
            'name' => '互联网',
            'id'   => 8
        ],
        9 =>[
            'name' => '科技',
            'id'   => 9
        ],
        10 =>[
            'show' => false,
            'name' => '生活',
            'id'   => 10,
        ],
        11 =>[
            'name' => '国际',
            'id'   => 11,
        ],
        12 =>[
            'name' => '国内',
            'id'   => 12
        ],
        13 =>[
            'name' => '汽车',
            'id'   => 13,
        ],
        14 =>[
            'show' =>false,
            'name' => '财经',
            'id'   => 14,
        ],
        15 =>[
            'show' => false,
            'name' => '房产',
            'id'   => 15
        ],
        16 =>[
            'show' => false,
            'name' => '时尚',
            'id'   => 16
        ],
        17 =>[
            'show' => false,
            'name' => '教育',
            'id'   => 17,
        ],
        18 =>[
            'show' => false,
            'name' => '游戏',
            'id'   => 18
        ],
        19 =>[
            'name' => '旅游',
            'id'   => 19,
        ],
        20 =>[
            'show' => false,
            'name' => '人文',
            'id'   => 20
        ],
        21 =>[
            'show' => false,
            'name' => '健康',
            'id'   => 21,
            'post' => [
                'mid'=>'03c7a16f2e8028127e42c5f7ca9e210b',
                'ts'=>'0',
                'topic'=>'',
                'type'=>'tag',
                'token'=>'tag',
                'ln'=>'200',
                'an'=>10,
                'withtopic'=>'0',
                'wf'=>'0',
                'internet-subscribe'=>'0',
                'remote_device_type'=>'1',
                'ver'=>'4',
                'pd'=>'webapp',
                'nids'=>'',
                'os_type' => 2,
                'screen_size_width' => 320,
                'screen_size_height' => 568
            ],
        ],
        22 =>[
            'name' => '星座',
            'id'   => 22,
            'post' => [
                'mid'=>'03c7a16f2e8028127e42c5f7ca9e210b',
                'ts'=>'0',
                'topic'=>'',
                'type'=>'tag',
                'token'=>'tag',
                'ln'=>'200',
                'an'=>10,
                'withtopic'=>'0',
                'wf'=>'0',
                'internet-subscribe'=>'0',
                'remote_device_type'=>'1',
                'ver'=>'4',
                'pd'=>'webapp',
                'nids'=>'',
                'os_type' => 2,
                'screen_size_width' => 320,
                'screen_size_height' => 568
            ],
        ],
        23 =>[
            'name' => '动漫',
            'id'   => 23,
            'post' => [
                'mid'=>'03c7a16f2e8028127e42c5f7ca9e210b',
                'ts'=>'0',
                'topic'=>'',
                'type'=>'tag',
                'token'=>'tag',
                'ln'=>'200',
                'an'=>10,
                'withtopic'=>'0',
                'wf'  =>'0',
                'internet-subscribe'=>'0',
                'remote_device_type'=>'1',
                'ver'     =>'4',
                'pd'      =>'webapp',
                'nids'    =>'',
                'os_type' => 2,
                'screen_size_width' => 320,
                'screen_size_height' => 568
            ],
        ],
        24 =>[
            'name' => '体育',
            'id'   => 24
        ],
    ];

    public static $POST = array(
        'mid'   => '03c7a16f2e8028127e42c5f7ca9e210b',
        'ts'    => '0',
        'topic' => '',
        'type'  => 'info',
        'token' => 'info',
        'ln'    => '200',
        'an'    => 10,
        'withtopic'=>'0',
        'wf'    => '0',
        'internet-subscribe'=>'0',
        'ver'=>'4',
        'pd'=>'webapp',
        'nids'=>'',
        'remote_device_type' => '1',
        'os_type'=>2,
        'screen_size_width'=>320,
        'screen_size_height'=>568
    );

    public static $DETAIL = 'https://m.news.baidu.com/news?tn=bdapibaiyue&t=recommendinfo&wf=1&remote_device_type=iphone&os_type=2&screen_size_width=326&screen_size_height=500';
    public static $LIST   = 'https://m.news.baidu.com/news?tn=bdapibaiyue&t=recommendlist';

    public static function getCategory() {
        return ['name' => self::$NAME, 'category' => self::$CATEGORY];
    }

    public function run($id, $tables) {
        $dbHandler = BaseHandler::getHandler();
        $success   = 0;
        foreach (self::$CATEGORY as  $key => $value) {
            if($key != $id) {
                continue;
            }
            $url = $value['url']  ? $value['url']  : self::$LIST;
            $p   = $value['post'] ? $value['post'] : self::$POST;
            $p['topic'] = $value['name'];

            $data = json_decode($this->send_http_request($url,$p), true);

            if($data['data']['news']) {
                foreach($data['data']['news'] as $k => $news) {
                    if(!$news['abs']) continue;
                    if(strpos($news['url'], 'baijiahao') !== false) continue;
                    $images = [];
                    $save = [];
                    $save['read_times'] = (string)rand(100, 500);
                    $save['text']       = $news['abs'];
                    $save['title']      = $news['title'];
                    $save['author']     = $news['site'];
                    $save['data_type']  = '1';
                    $save['type']       = '1';//普通文章
                    $save['time_step']  = (string)intval($news['ts']/1000);
                    $save['site']       = 'm.news.baidu.com';
                    $save['special']    = '11';
                    $save['majory_id']  = (string)$value['id'];
                    $save['url']        = $news['url'];
                    $save['md5']        = md5($news['url']);
                    $news['puid']       = $news['nid'];
                    $save['state']      = '免责声明:本网站部分文字和信息来源互联网，并不意味着赞同其观点或证实其内容的真实性。如转载搞涉及版权等问题，请联系管理员，我们会予以改正或删除相关问题，保证您的权利！';
                    $content            = json_decode($this->send_http_request(self::$DETAIL, ['nids' => $news['nid']]),true);
                    $save['content']   = '';
                    if($news['imageurls']) {
                        $images = $news['imageurls'];
                    }
                    if(!$content) {
                        continue;
                    } else {
                        $ccc = $content['data']['news'][0]['content'];
                        $save['image']   = json_encode($images,JSON_UNESCAPED_UNICODE);
                        $save['content'] = json_encode(['content' => $ccc],JSON_UNESCAPED_UNICODE);
                        $this->save($save, $dbHandler, $tables);
                        usleep(200000);
                    }
                }
            } else {
                echo $value['name']." fail\n";
            }
            sleep(1);
        }

        echo date("Y-m-d H:i:s")."success ---- ". $success."\n";
    }

    public function save($data, $dbHandler, $tables) {

        foreach ($data as $k1 => $v3) {
            $new[$k1] = 'VARCHAR';
        }
        foreach($tables as $table) {
            $sql    = SqlBuilder::createInsertSql($data, $new, $table);
            $result = DBMysqlNamespace::query($dbHandler, $sql);
            if(!$result) {
                echo 'fail ' . $data['title'] .  "({$data['md5']})add table {$table} fail\n";
            } else{
                echo 'success '. $data['title'] .  "({$data['md5']})add table {$table}\n";
            }
        }

    }

    function send_http_request($url, $post = [])
    {
        $curl = curl_init();

        $ua = 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X; en-us] AppleWebKit/537.51.1 (KHTML, like Gecko] Version/7.0 Mobile/11A465 Safari/9537.53';
        if($post) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt ($curl, CURLOPT_REFERER, "https://m.news.baidu.com/news?fr=mohome&ssid=4bb4d1dbd1ccd3ead807&from=844b&uid=&pu=sz%401320_2001%2Cta%40iphone_1_9.1_3_601&bd_page_type=1");
        curl_setopt($curl, CURLOPT_USERAGENT, $ua);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

}



