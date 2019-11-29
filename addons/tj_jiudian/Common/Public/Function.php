<?php
function do_data($array)
{
    global  $_W,$_GPC;
    $arr = array('c','a','eid','submit','__uniacid','__uid','__session','__entry','__state','action',
        'do','i','m','file','state','module_status:tj_hotel','module_status:1','__switch','main-lg','module_status:tj_business');
    foreach($array as $k => $v)
    {
        if(in_array($k, $arr))
        {
            unset($array[$k]);
        }
    }
    if(empty($array['acid']))
    {
        $array['acid'] = $_W['account']['acid'];
    }
    return $array;
}

function do_juli($res,$lat,$lng){

    foreach ($res as $k=>$v) {
        $lat1=$lat;
        $lng1=$lng;
        $lat2 = $res[$k]['lat'];
        $lng2 = $res[$k]['lng'];
        $earthRadius = 6367000; //approximate radius of earth in meters

        $lat1 = ($lat1 * pi()) / 180;
        $lng1 = ($lng1 * pi()) / 180;

        $lat2 = ($lat2 * pi()) / 180;
        $lng2 = ($lng2 * pi()) / 180;

        $calcLongitude = $lng2 - $lng1;
        $calcLatitude = $lat2 - $lat1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = $earthRadius * $stepTwo;
        $mi=substr($calculatedDistance, 0, strripos($calculatedDistance, '.'));
        $juli = substr($calculatedDistance / 1000, 0, strripos($calculatedDistance / 1000, '.') + 3);
        pdo_update('tj_business_information',array('juli'=>$mi),array('id'=>$res[$k]['id']));
        $res[$k]['juli']=$juli;
    }
    
    return $res;
}

if (!function_exists('webUrl')) {
    function webUrl($do = '', $query = array(), $full = true)
    {
        global $_W;
        global $_GPC;

        if (!empty($_W['plugin'])) {
            if ($_W['plugin'] == 'merch') {
                if (function_exists('merchUrl')) {
                    return merchUrl($do, $query, $full);
                }
            }

            if ($_W['plugin'] == 'newstore') {
                if (function_exists('newstoreUrl')) {
                    return newstoreUrl($do, $query, $full);
                }
            }
        }

        $dos = explode('/', trim($do));
        $routes = array();
        $routes[] = $dos[0];

        if (isset($dos[1])) {
            $routes[] = $dos[1];
        }

        if (isset($dos[2])) {
            $routes[] = $dos[2];
        }

        if (isset($dos[3])) {
            $routes[] = $dos[3];
        }

        $r = implode('.', $routes);

        if (!empty($r)) {
            $query = array_merge(array('r' => $r), $query);
        }

        $query = array_merge(array('do' => 'web'), $query);
        $query = array_merge(array('m' => 'ewei_shopv2'), $query);

        if ($full) {
            return $_W['siteroot'] . 'web/' . substr(wurl('site/entry', $query), 2);
        }

        return wurl('site/entry', $query);
    }
}


function p_arr($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

// AMNBZ-WUZLP-N63DO-VAUUD-TYBG7-GPBYM
// 腾讯地图逆解析



// 百度地图逆解析
/**
     * 根据地址获取国家、省份、城市及周边数据
     * @param  String  $ak        百度ak(密钥)
     * @param  Decimal $longitude 经度
     * @param  Decimal $latitude  纬度
     * @param  Int     $pois      是否显示周边数据
     * @return Array
     */
 function getAddressComponent($ak, $longitude, $latitude, $pois=0){

   $zuobiao =  wechat_badu($longitude,$latitude,$ak);

    $param = array(
            'ak' => $ak,
            'location' => implode(',', array($zuobiao['latitude'], $zuobiao['longitude'])),
            'pois' => $pois,
            'output' => 'json'
    );

    // 请求百度api
    $url = "http://api.map.baidu.com/geocoder/v2/";
    $response = toCurl($url, $param);

    $result = array();

    if($response){
        $result = json_decode($response, true);
    }

    return $result;

}


// 微信坐标转换成百度坐标
function wechat_badu($longitude,$latitude,$ak){
    // http://api.map.baidu.com/geoconv/v1/?coords=114.21892734521,29.575429778924&from=1&to=5&ak=你的密钥
    $url = "http://api.map.baidu.com/geoconv/v1/?coords={$longitude},{$latitude}&from=1&to=5&ak={$ak}";

    $response = toCurl($url);

    if($response){
        $result = json_decode($response, true);
    }


    $data = array(
        'longitude' =>$result['result'][0]['x'],
        'latitude' =>$result['result'][0]['y'],
        );


    return $data;

}


//腾讯转百度坐标转换
function coordinate_switchf($a,$b){
 
 
    $x = (double)$b ;
    $y = (double)$a;
    $x_pi = 3.14159265358979324;
    $z = sqrt($x * $x+$y * $y) + 0.00002 * sin($y * $x_pi);
 
    $theta = atan2($y,$x) + 0.000003 * cos($x*$x_pi);
 
    $gb = number_format($z * cos($theta) + 0.0065,6);
    $ga = number_format($z * sin($theta) + 0.006,6);
 
    $data = array('latitude'=>$ga,'longitude'=>$gb);
 
    return $data;
 
}

// 根据地址获取经纬度
function getJingWei($address){
     $url = "http://api.map.baidu.com/geocoder/v2/?address={$address}&output=json&ak=AB8650f063ed5cb61a3073ad56608cb7";
    

    $data = toCurl($url);
    if($data){
        $result = json_decode($data, true);
    }
    if($result['status']==0){
        return $result['result']['location'];
    }else{
        return array('lng'=>0,'lat'=>0);
    }
}

 function toCurl($url, $param=array()){
 
        $ch = curl_init();
 
        if(substr($url,0,5)=='https'){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
        }
 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
 
        $response = curl_exec($ch);
 
        if($error=curl_error($ch)){
            return false;
        }
 
        curl_close($ch);
 
        return $response;
 
}

/**
 * 计算两点地理坐标之间的距离
 * @param  Decimal $longitude1 起点经度
 * @param  Decimal $latitude1  起点纬度
 * @param  Decimal $longitude2 终点经度 
 * @param  Decimal $latitude2  终点纬度
 * @param  Int     $unit       单位 1:米 2:公里
 * @param  Int     $decimal    精度 保留小数位数
 * @return Decimal
 */
function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal=2){

    $EARTH_RADIUS = 6370.996; // 地球半径系数
    $PI = 3.1415926;

    $radLat1 = $latitude1 * $PI / 180.0;
    $radLat2 = $latitude2 * $PI / 180.0;

    $radLng1 = $longitude1 * $PI / 180.0;
    $radLng2 = $longitude2 * $PI /180.0;

    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;

    $distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
    $distance = $distance * $EARTH_RADIUS * 1000;

    if($unit==2){
        $distance = $distance / 1000;
    }

    return round($distance, $decimal);

}


/**
 * [multi_array_sort 二维数组按某个字段排序]
 * @param  [type] $multi_array [数组]
 * @param  [type] $sort_key    [排序字段]
 * @param  [type] $sort        [description]
 * @return [type]              [description]
 */
function multi_array_sort($multi_array,$sort_key,$sort=SORT_ASC){ 
    if(is_array($multi_array)){ 
        foreach ($multi_array as $row_array){ 
            if(is_array($row_array)){ 
                $key_array[] = $row_array[$sort_key]; 
            }else{ 
                return false; 
            } 
        } 
    }else{ 
        return false; 
    } 
        array_multisort($key_array,$sort,$multi_array); 
        return $multi_array; 
} 

