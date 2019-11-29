<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 15/12/6
 * Time: 下午4:23
 */
include_once dirname(__FILE__) . "/BaseHandler.php";
include_once dirname(__FILE__) . "/Category.php";
class ToutiaoNews {

    public static $SIGN = 'hRajfgAA4AHx0NsjEbC-yoUWo2';
    public static $NAME = 'ToutiaoNews';
    public static $VALUE = '头条新闻';
    public static $CATEGORY = [
         1 => [
            'url' => 'https://www.toutiao.com/api/pc/feed/?category=funny&utm_source=toutiao&widen=1&max_behot_time=0&max_behot_time_tmp=0&tadrequire=true&as=5AE2583C67D8CE1&cp=5AE2583C67D8CE1&_signature=%s',
            'name' => '搞笑',
            'type' => 'gaoxiao',
            'id'   => 1
        ],
         2 => [
            'url' => 'https://www.toutiao.com/api/pc/feed/?category=%E7%BB%84%E5%9B%BE&utm_source=toutiao&max_behot_time=0&as=A1953AB3CC7756D&cp=5A3C0735B6EDBE1&_signature=%s',
            'name' => '图片',
            'type' => 'tupian',
            'id'   => 2
        ],
         3 =>[
            'url' => 'https://www.toutiao.com/api/pc/feed/?category=news_finance&utm_source=toutiao&widen=1&max_behot_time=0&max_behot_time_tmp=0&tadrequire=true&as=A1952AB35CA7595&cp=5A3C87F56955AE1&_signature=%s',
            'name' => '财经',
            'type' => 'caijing',
            'id'   => 3
        ],
         4 =>[
            'url' => 'https://www.toutiao.com/api/pc/feed/?category=news_sports&utm_source=toutiao&widen=1&max_behot_time=0&max_behot_time_tmp=0&tadrequire=true&as=A1D57AF35CD75A4&cp=5A3C97A54A842E1&_signature=%s',
            'name' => '体育',
            'type' => 'tiyu',
            'id'   => 4
        ],
         5 =>[
            'url' => 'https://www.toutiao.com/api/pc/feed/?category=news_tech&utm_source=toutiao&widen=1&max_behot_time=0&max_behot_time_tmp=0&tadrequire=true&as=A1D52A232CE74C1&cp=5A3C87144CC1CE1&_signature=%s',
            'name' => '科技',
            'type' => 'keji',
            'id'   => 5
        ],
        6 =>[
            'url' => 'https://www.toutiao.com/api/pc/feed/?category=news_car&utm_source=toutiao&widen=1&max_behot_time=0&max_behot_time_tmp=0&tadrequire=true&as=A1D58A63CC275BA&cp=5A3C37058B3A8E1&_signature=%s',
            'name' => '汽车',
            'type' => 'qiche',
            'id'   => 6
        ],
        7 =>[
            'url' => 'https://www.toutiao.com/api/pc/feed/?category=news_entertainment&utm_source=toutiao&widen=1&max_behot_time=0&max_behot_time_tmp=0&tadrequire=true&as=A165EA839CF75C8&cp=5A3C87350C287E1&_signature=%s',
            'name' => '娱乐',
            'type' => 'yule',
            'id'   => 7
        ],
        8 =>[
            'url' => 'https://www.toutiao.com/api/pc/feed/?category=news_society&utm_source=toutiao&widen=1&max_behot_time=0&max_behot_time_tmp=0&tadrequire=true&as=A1D51A134C575D8&cp=5A3C37457D78BE1&_signature=%s',
            'name' => '社会',
            'type' => 'shehui',
            'id'   => 8
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
            $url = sprintf($value['url'],self::$SIGN) ;

            $ua = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36';
            $data = json_decode($this->send_http_request($url, $ua), true);

            if($data['message'] == 'success') {
                foreach($data['data'] as $k => $news) {


                    if ($news['is_feed_ad']) continue;
                    $save                = [];
                    $save['read_times']  = (string)rand(0, 100);
                    $save['text']        = $news['abstract'] ? $news['abstract']: '';
                    $save['title']       = $news['title'];
                    $save['author']      = $news['source'];
                    $save['data_type']   = '0';
                    $save['time_step']   = (string)$news['behot_time'];
                    $save['site']        = 'toutiao.com';
                    $save['special']     = '11';
                    $save['majory_id']   = (string)$value['id'];
                    if($news['label']) {
                        $d['kw'] = $news['label'][0];
                        if(!$d['kw']) {
                            unset($d['kw']);
                        }
                    }
                    $save['url']         = 'https://www.toutiao.com' . $news['source_url'];
                    $detail           = 'https://m.toutiao.com/a' . $news['group_id'] . '/';
                    $save['md5']         = md5($detail);
                    $save['state']      = '免责声明:本网站部分文字和信息来源互联网，并不意味着赞同其观点或证实其内容的真实性。如转载搞涉及版权等问题，请联系管理员，我们会予以改正或删除相关问题，保证您的权利！';
                    $ua               = 'Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Mobile Safari/537.36';

                    $content = $this->send_http_request2($detail);
                    if (!$content) {
                        continue;
                    }

                    $content = json_decode($this->send_http_request($content . 'info/', $ua, false), true);
                    if ($content['success'] && $content['data']['content']) {
                        $save['content'] = $content['data']['content'];
                    } else {
                        continue;
                    }

                    $images = [];
                    foreach ($news['image_list'] as $vv) {
                        $images[] = [
                            'url' => 'https:'.$vv['url'],
                            'alt' => $news['title'],
                        ];
                        if (count($images) > 2) break;
                    }


                    $save['image'] = $images ? json_encode($images, JSON_UNESCAPED_UNICODE) : '';
                    if(!$content) {
                        continue;
                    } else {
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

    function send_http_request($url ,$ua ,$header = false,$post = [])
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_COOKIE, 'uuid="w:af3f9e1537924215875cc7c42a3f86a6"; _vwo_uuid_v2=AA3884D791084C95DAD55A32CF9FBA3B|bd7bb8ef7fb723e0ccf41b0e6d44cc10; Hm_lvt_23e756494636a870d09e32c92e64fdd6=1501749167; csrftoken=fe85e0e28248bfafe7e5e21619335959; WEATHER_CITY=%E5%8C%97%E4%BA%AC; _ga=GA1.2.1891033007.1501746166; tt_webid=6545735113144616461; UM_distinctid=162d852a70e94-00fad443817f2a-336a7b04-13c680-162d852a7102c0; tt_webid=6545735113144616461; CNZZDATA1259612802=1609526074-1501729169-%7C1524793884; __tasessionId=8rk2hfaai1524796529068');
        curl_setopt($curl, CURLOPT_USERAGENT, $ua);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
//    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $url);
//    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);

        curl_close($curl);


        return $response;
    }

    function send_http_request2($url ,$post = [])
    {
        $curl = curl_init();

        $ua = 'Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Mobile Safari/537.36';
        if($post) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }



        curl_setopt($curl, CURLOPT_USERAGENT, $ua);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_URL, $url);
//    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        $header =  curl_getinfo($curl);
        curl_close($curl);


        if($header['redirect_url']) {
            return $header['redirect_url'];
        }
        return $response;
    }

}



