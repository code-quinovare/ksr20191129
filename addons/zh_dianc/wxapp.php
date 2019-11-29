<?php
/**
 * 旺铺点餐模块小程序接口定义
 *

 * @author 泉州大白网络科技

 * @url 
 */
defined('IN_IA') or exit('Access Denied');
class Zh_diancModuleWxapp extends WeModuleWxapp {
  //系统信息
  public function doPageSystem(){
    global $_W, $_GPC;
    $res=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
    echo json_encode($res);
  }
      //获取openid
  public function doPageOpenid(){
    global $_W, $_GPC;
    $res=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
    $code=$_GPC['code'];
    $appid=$res['appid'];
    $secret=$res['appsecret'];
  // echo $appid;die;
    $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$secret."&js_code=".$code."&grant_type=authorization_code";
    function httpRequest($url,$data = null){
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
      if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      }
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //执行
      $output = curl_exec($curl);
      curl_close($curl);
      return $output;
    }
    $res=httpRequest($url);
    print_r($res);
  }
    //商家登录
  public function doPageStoreLogin(){
   global $_W, $_GPC;
   $user=$_GPC['user'];
   $password=md5($_GPC['password']);
   $res=pdo_get('wpdc_seller',array('account'=>$user,'pwd'=>$password,'uniacid'=>$_W['uniacid']));
   if($res){
     echo json_encode($res);
   }else{
    echo  '2';
  }
}
    //商家信息
public function doPageStore(){
  global $_W, $_GPC;
  if($_GPC['user_id']){
    $data['user_id']=$_GPC['user_id'];
    $data['store_id']=$_GPC['id'];
    $data['time']=date("Y-m-d");
    $list=pdo_get('wpdc_traffic',$data);
    if(!$list){
      pdo_insert('wpdc_traffic',$data);
    }
  }
  

  $res=pdo_get('wpdc_store',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
  if($res['img']){
    if(strlen($res['img'])>51){
      $res['img']= explode(',',$res['img']);
    }else{
      $res['img']=array(
        0=>$res['img']
        );
    }  
  }
  if($res['yyzz']){
   if(strlen($res['yyzz'])>51){
    $res['yyzz']= explode(',',$res['yyzz']);
  }else{
    $res['yyzz']=array(
      0=>$res['yyzz']
      );
  }
}
if($res['environment']){
 if(strlen($res['environment'])>51){
  $res['environment']= explode(',',$res['environment']);
}else{
  $res['environment']=array(
    0=>$res['environment']
    );
}
}


function video($video){
        $vid=trim(strrchr($video, '/'),'/');
        $vid=substr($vid,0,-5);
        $json=file_get_contents("http://vv.video.qq.com/getinfo?vids=".$vid."&platform=101001&charge=0&otype=json");
       // echo $json;die;
        $json=substr($json,13);
        $json=substr($json,0,-1);
        $a=json_decode(html_entity_decode($json));
        $sz=json_decode(json_encode($a),true);
       // print_R($sz);die;
        $url=$sz['vl']['vi']['0']['ul']['ui']['3']['url'];
        $fn=$sz['vl']['vi']['0']['fn'];
        $fvkey=$sz['vl']['vi']['0']['fvkey'];
        $url=$url.$fn.'?vkey='.$fvkey;
        return  $url;
    }

$res['store_video']=video($res['store_video']);
echo json_encode($res);
}
    //登录用户信息
public function doPageLogin(){
  global $_GPC, $_W;
  $openid=$_GPC['openid'];
  $res=pdo_get('wpdc_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
  if($res){
    $user_id=$res['id'];
    $data['openid']=$_GPC['openid'];
    $data['img']=$_GPC['img'];
    $data['name']=$_GPC['name'];
    $res = pdo_update('wpdc_user', $data, array('id' =>$user_id));
    $user=pdo_get('wpdc_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
    echo json_encode($user);
  }else{
    $data['openid']=$_GPC['openid'];
    $data['img']=$_GPC['img'];
    $data['name']=$_GPC['name'];
    $data['uniacid']=$_W['uniacid'];
    $data['join_time']=time();
    $res2=pdo_insert('wpdc_user',$data);
    $user=pdo_get('wpdc_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
    echo json_encode($user);
  }
}
    //菜品列表
public function doPageDishes(){
 global $_W, $_GPC;
        // $_GPC['dishes_type']=1;
 $type=pdo_getall('wpdc_type',array('uniacid'=>$_W['uniacid'],'store_id'=>$_GPC['id'],'is_open'=>1),array(),'','order_by ASC');
 $list=pdo_getall('wpdc_dishes',array('uniacid'=>$_W['uniacid'],'is_shelves'=>1,'dishes_type !='=>$_GPC['dishes_type'],'store_id'=>$_GPC['id']),array(),'','sorting ASC');
 $data2=array();
 for($i=0;$i<count($type);$i++){
  $data=array();
  for($k=0;$k<count($list);$k++){
    if($type[$i]['id']==$list[$k]['type_id']){
      $data[]=array(
        'id'=>$list[$k]['id'],
        'name'=>$list[$k]['name'],
        'img'=>$list[$k]['img'],
        'num'=>$list[$k]['num'],
        'money'=>$list[$k]['money'],
        'one'=>$list[$k]['one'],
        'signature'=>$list[$k]['signature'],
        'dishes_type'=>$list[$k]['dishes_type'],
        'xs_num'=>$list[$k]['xs_num'],
        'sit_ys_num'=>$list[$k]['sit_ys_num'],
        'wm_money'=>$list[$k]['wm_money'],
        'details'=>$list[$k]['details'],
        'box_fee'=>$list[$k]['box_fee']
        );
    }           
  }
  $data2[]=array(
    'id'=>$type[$i]['id'],
    'type_name'=>$type[$i]['type_name'],
    'goods'=>$data
    );
}
echo json_encode($data2);
}
//菜品规格
public function doPageDishesGg(){
  global $_W, $_GPC;
  $res=pdo_getall('wpdc_spec',array('goods_id'=>$_GPC['dishes_id']));
  echo json_encode($res);
}
//菜品详情
public function doPageDishesInfo(){
 global $_GPC, $_W;
 $res=pdo_get('wpdc_dishes',array('id'=>$_GPC['id']));
 $res2=pdo_getall('wpdc_spec',array('goods_id'=>$_GPC['id']));
 $data['dishes']=$res;
 $data['spec']=$res2;
 echo json_encode($data);
}
//url(七牛)
public function doPageUrl(){
  global $_GPC, $_W;
  echo $_W['attachurl'];
}
public function doPageUrl2(){
  global $_GPC, $_W;
  echo $_W['siteroot'];
}


    //下订单
public function doPageAddOrder(){
  global $_W, $_GPC;
 
        if($_GPC['type']==1){//外卖
          $data['user_id']=$_GPC['user_id'];
          $data['order_num']=date('YmdHis',time()).rand(1111,9999);
   
          $data['state']=1;
          $data['time']=date("Y-m-d H:i:s",time());
          $data['time2']=time();
          $data['money']=$_GPC['money'];
          $data['preferential']=$_GPC['preferential'];
          $data['tel']=$_GPC['tel'];
          $data['name']=$_GPC['name'];
          $data['note']=$_GPC['note'];//备注
          $data['address']=$_GPC['address'];
          $data['type']=$_GPC['type'];
          $data['area']=$_GPC['area'];
          $data['lat']=$_GPC['lat'];
          $data['lng']=$_GPC['lng'];
          $data['uniacid']=$_W['uniacid'];//小程序id
          $data['freight']=$_GPC['freight'];//配送费
          $data['box_fee']=$_GPC['box_fee'];//餐盒费
          $data['coupons_id']=$_GPC['coupons_id'];//优惠劵ID
          $data['voucher_id']=$_GPC['voucher_id'];//代金劵ID
          $data['seller_id']=$_GPC['seller_id'];//商家
          $data['delivery_time']=$_GPC['delivery_time'];//送达时间
          $data['is_take']=$_GPC['is_take'];//1.自取 2.不自取
          $data['is_yue']=$_GPC['is_yue'];//1余额支付  2.微信支付  3.积分支付
          $data['form_id']=$_GPC['form_id'];

          $res=pdo_insert('wpdc_order',$data);
          $order_id=pdo_insertid();

          $a=json_decode(html_entity_decode($_GPC['sz']));
          $sz=json_decode(json_encode($a),true);
             // print_R($sz);die;
            
          $data3['state']=1;
          if($_GPC['coupons_id']){
               // echo $_GPC['coupons_id'];die;
           pdo_update('wpdc_usercoupons',$data3,array('coupons_id'=>$_GPC['coupons_id'],'user_id'=>$_GPC['user_id']));
         }
         if($_GPC['voucher_id']){
              //  echo $_GPC['voucher_id'];die;
           pdo_update('wpdc_uservoucher',$data3,array('vouchers_id'=>$_GPC['voucher_id'],'user_id'=>$_GPC['user_id']));
         }
         if($res){
          if($data['is_yue']==1){
            pdo_update('wpdc_user',array('wallet -='=>$_GPC['money']),array('id'=>$_GPC['user_id']));
            $data4['money']=$_GPC['money'];
            $data4['user_id']=$_GPC['user_id'];
            $data4['type']=2;
            $data4['note']='外卖订单';
            $data4['time']=date('Y-m-d H:i:s');
            pdo_insert('wpdc_qbmx',$data4);
          }elseif($data['is_yue']==3){
            pdo_update('wpdc_user',array('total_score -='=>$_GPC['jf']),array('id'=>$_GPC['user_id']));
            $jf['score']=$_GPC['jf'];
            $jf['user_id']=$_GPC['user_id'];
            $jf['type']=2;
            $jf['note']='外卖订单';
            $jf['order_id']=$order_id;
            $jf['cerated_time']=date('Y-m-d H:i:s');
            pdo_insert('wpdc_integral',$jf);
          }
          for($i=0;$i<count($sz);$i++){
            $data2['name']=$sz[$i]['name'];
            $data2['number']=$sz[$i]['num'];
            $data2['money']=$sz[$i]['money'];
            $data2['img']=$sz[$i]['img'];
            $data2['dishes_id']=$sz[$i]['dishes_id'];
            $data2['uniacid']=$_W['uniacid'];//小程序id
            $data2['order_id']=$order_id;
            $res2=pdo_insert('wpdc_goods',$data2);
          }
          echo $order_id;
        }else{
         echo '下单失败';
       }
        }elseif($_GPC['type']==2){//店内
          $data['preferential']=$_GPC['preferential'];
          $data['user_id']=$_GPC['user_id'];
          $data['order_num']=date('YmdHis',time()).rand(1111,9999);
          $data['time']=date("Y-m-d H:i:s",time());
          $data['time2']=time();
          $data['note']=$_GPC['note'];//备注
          $data['money']=$_GPC['money'];
          $data['type']=$_GPC['type'];
          $data['dn_state']=1;
            $data['uniacid']=$_W['uniacid'];//小程序id
            $data['table_id']=$_GPC['table_id'];//桌号
            $data['coupons_id']=$_GPC['coupons_id'];//优惠劵ID
            $data['voucher_id']=$_GPC['voucher_id'];//代金劵ID
            $data['seller_id']=$_GPC['seller_id'];//商家
            $data['is_yue']=$_GPC['is_yue'];//1是  2.不是
            $data['form_id']=$_GPC['form_id'];
            $res=pdo_insert('wpdc_order',$data);
            $order_id=pdo_insertid();
            $a=json_decode(html_entity_decode($_GPC['sz']));
            $sz=json_decode(json_encode($a),true);
            $data3['state']=1;
            if($_GPC['coupons_id']){
             pdo_update('wpdc_usercoupons',$data3,array('coupons_id'=>$_GPC['coupons_id']));
           }
           if($_GPC['voucher_id']){
             pdo_update('wpdc_uservoucher',$data3,array('vouchers_id'=>$_GPC['voucher_id']));
           }
           if($res){
            if($data['is_yue']==1){
              pdo_update('wpdc_user',array('wallet -='=>$_GPC['money']),array('id'=>$_GPC['user_id']));
              $data4['money']=$_GPC['money'];
              $data4['user_id']=$_GPC['user_id'];
              $data4['type']=2;
              $data4['note']='店内订单';
              $data4['time']=date('Y-m-d H:i:s');
              pdo_insert('wpdc_qbmx',$data4);
            }elseif($data['is_yue']==3){
            pdo_update('wpdc_user',array('total_score -='=>$_GPC['jf']),array('id'=>$_GPC['user_id']));
            $jf['score']=$_GPC['jf'];
            $jf['user_id']=$_GPC['user_id'];
            $jf['type']=2;
            $jf['note']='店内订单';
            $jf['order_id']=$order_id;
            $jf['cerated_time']=date('Y-m-d H:i:s');
            pdo_insert('wpdc_integral',$jf);
          }
            pdo_update('wpdc_table',array('status'=>2),array('id'=>$_GPC['table_id']));
            for($i=0;$i<count($sz);$i++){
              $data2['name']=$sz[$i]['name'];
              $data2['number']=$sz[$i]['num'];
              $data2['money']=$sz[$i]['money'];
              $data2['img']=$sz[$i]['img'];
              $data2['dishes_id']=$sz[$i]['dishes_id'];
               $data2['uniacid']=$_W['uniacid'];//小程序id
               $data2['order_id']=$order_id;
               $res2=pdo_insert('wpdc_goods',$data2);
             }
             echo $order_id;
           }else{
            echo '下单失败';
          }
        }
      }

//达达
    public function doPageDada(){
       global $_W, $_GPC;
       include IA_ROOT.'/addons/zh_dianc/DadaOpenapi.php';
       $res=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
       $order=pdo_get('wpdc_order',array('id'=>$_GPC['order_id']));
       $store=pdo_get('wpdc_store',array('id'=>$order['seller_id']));
//*********************配置项*************************
       $config = array();
       $config['app_key'] = $res['dada_key'];
       $config['app_secret'] = $res['dada_secret'];
       $config['source_id'] = $store['source_id'];
       $config['url'] = 'http://newopen.imdada.cn/api/cityCode/list';
//$config['url'] = 'http://newopen.qa.imdada.cn/api/order/addOrder';
//echo time();die;
       $obj = new DadaOpenapi($config);
       $name=$_GPC['area'];
     $name=substr($name,strpos($name,"省")+3);




       $data=array();
//请求接口
       $reqStatus = $obj->makeRequest($data);
      // print_r($obj->getCode());die;
       if (!$reqStatus) {
    //接口请求正常，判断接口返回的结果，自定义业务操作
        if ($obj->getCode() == 0) {
          $arr=$obj->getResult();
        //var_dump($arr);die;
          foreach($arr as $v){
            if($name==$v['cityName']){
              $cityCode=$v['cityCode'];
            }
          }
//发单请求数据,只是样例数据，根据自己的需求进行更改。
          $data2 = array(
          'shop_no'=>  $store['shop_no'],//门店编号
          'origin_id'=> $order['order_num'],//订单id
          'city_code'=> $cityCode,//城市
          'tips'=> 0,//小费
          'info'=> $order['note'],//备注
          // 'cargo_type'=> 1,
          // 'cargo_weight'=> 10,
          'cargo_price'=> $order['money'],
          // 'cargo_num'=> 2,
          'is_prepay'=> 0,
          'expected_fetch_time'=>time()+600,
          //'expected_finish_time'=> 0,
          // 'invoice_title'=> '发票抬头',
          'receiver_name'=> $order['name'],
          'receiver_address'=> $order['address'],
          'receiver_phone'=> $order['tel'],
          // 'receiver_tel'=> '18599999999',
          'receiver_lat'=> $_GPC['lat'],
          'receiver_lng'=> $_GPC['lng'],
          'callback'=>'http://newopen.imdada.cn/inner/api/order/status/notify'
          );
          $config['url'] = 'http://newopen.imdada.cn/api/order/addOrder';

          $obj2 = new DadaOpenapi($config);

          $reqStatus2 = $obj2->makeRequest($data2);
          if (!$reqStatus2) {
    //接口请求正常，判断接口返回的结果，自定义业务操作
   // / print_r($obj2->getCode());echo '达达';die;
            if ($obj2->getCode() == 0) {
              echo '下单成功';
              print_r($obj2->getResult());
            }
          }

        }else{
          echo  '失败';
        }
    //echo sprintf('code:%s,msg:%s', $obj->getCode(),$obj->getMsg());
      }else{
    //请求异常或者失败
        echo 'except';
      }





    }
//优惠券
    public function doPageCoupons(){
      global $_W, $_GPC;
      $userid=$_GPC['user_id'];
      $sql="select a.* ,b.name,b.start_time,b.end_time,b.conditions,b.preferential,b.coupons_type,b.instruction,c.name as store_name,c.id as store_id from " . tablename("wpdc_usercoupons") . " a"  . " left join " . tablename("wpdc_coupons") . " b on b.id=a.coupons_id " . " left join " . tablename("wpdc_store") . " c on c.id=b.store_id  WHERE a.user_id=:user_id ";
      $list=pdo_fetchall($sql,array(':user_id'=>$userid));
      $sql2="select a.* ,b.name as store_name from " . tablename("wpdc_coupons") . " a"  . " left join " . tablename("wpdc_store") . " b on b.id=a.store_id   WHERE a.uniacid=:uniacid";
      $res=pdo_fetchall($sql2,array(':uniacid'=>$_W['uniacid']));
     //   $res=pdo_getall('wpdc_coupons',array('uniacid'=>$_W['uniacid']));
      $data['ok']=$list;
      $data['all']=$res;
      echo json_encode($data);

    }

        //领取优惠券
    public function doPageAddCoupons(){
      global $_W, $_GPC;
      $data['user_id']=$_GPC['user_id'];
      $data['coupons_id']=$_GPC['coupons_id'];
      $data['uniacid']=$_W['uniacid'];
      $data['state']=2;
      $res2=pdo_get('wpdc_usercoupons',array('user_id'=>$_GPC['user_id'],'coupons_id'=>$_GPC['coupons_id']));
      $res=pdo_insert('wpdc_usercoupons',$data);
      if($res2){
        echo  '不能重复领取';
      }else{
        if($res){
          echo '1';
        }else{
          echo '2';
        }
      }
    }

//代金券
    public function doPageVoucher(){
      global $_W, $_GPC;
      $userid=$_GPC['user_id'];
      $sql="select a.* ,b.name,b.start_time,b.end_time,b.preferential,b.voucher_type,b.instruction,c.name as store_name ,c.id as store_id from " . tablename("wpdc_uservoucher") . " a"  . " left join " . tablename("wpdc_voucher") . " b on b.id=a.vouchers_id " . " left join " . tablename("wpdc_store") . " c on c.id=b.store_id  WHERE a.user_id=:user_id";
      $list=pdo_fetchall($sql,array(':user_id'=>$userid));
      $sql2="select a.* ,b.name as store_name from " . tablename("wpdc_voucher") . " a"  . " left join " . tablename("wpdc_store") . " b on b.id=a.store_id   WHERE a.uniacid=:uniacid";
      $res=pdo_fetchall($sql2,array(':uniacid'=>$_W['uniacid']));

      $data['ok']=$list;
      $data['all']=$res;
      echo json_encode($data);
    }

//领取代金券
    public function doPageAddVoucher(){
      global $_W, $_GPC;
      $data['user_id']=$_GPC['user_id'];
      $data['vouchers_id']=$_GPC['vouchers_id'];
      $data['uniacid']=$_W['uniacid'];
      $data['state']=2;
      $res2=pdo_get('wpdc_uservoucher',array('user_id'=>$_GPC['user_id'],'vouchers_id'=>$_GPC['vouchers_id']));
      $res=pdo_insert('wpdc_uservoucher',$data);
      if($res2){
        echo  '不能重复领取';
      }else{
        if($res){
          echo '1';
        }else{
          echo '2';
        }
      }
    }
//支付
    public function doPagePay(){
      global $_W, $_GPC;
      include IA_ROOT.'/addons/zh_dianc/wxpay.php';
           // include 'wxpay.php';
      $res=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
      $appid=$res['appid'];
          $openid=$_GPC['openid'];//oQKgL0ZKHwzAY-KhiyEEAsakW5Zg
          $mch_id=$res['mchid'];
          $key=$res['wxkey'];
          $out_trade_no = $mch_id. time();
          $root=$_W['siteroot'];
          pdo_update('wpdc_order',array('sh_ordernum'=>$out_trade_no),array('id'=>$_GPC['order_id']));  

          $total_fee =$_GPC['money'];
            if(empty($total_fee)) //押金
            {
              $body = "订单付款";
              $total_fee = floatval(99*100);
            }else{
             $body = "订单付款";
             $total_fee = floatval($total_fee*100);
           }
           $weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee,$root);
           $return=$weixinpay->pay();
           echo json_encode($return);
         }
//支付
         public function doPagePay2(){
          global $_W, $_GPC;
          include IA_ROOT.'/addons/zh_dianc/wxpay.php';
          $res=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
        $appid=$res['appid'];
        $openid=$_GPC['openid'];//oQKgL0ZKHwzAY-KhiyEEAsakW5Zg
        $mch_id=$res['mchid'];
        $key=$res['wxkey'];
        $out_trade_no = $mch_id. time();
        pdo_update('wpdc_ydorder',array('ydcode'=>$out_trade_no),array('id'=>$_GPC['order_id']));
        $total_fee =$_GPC['money'];
        $root=$_W['siteroot'];
            if(empty($total_fee)) //押金
            {
              $body = "订单付款";
              $total_fee = floatval(99*100);
            }else{
             $body = "订单付款";
             $total_fee = floatval($total_fee*100);
           }
           $weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee,$root);
           $return=$weixinpay->pay();
           echo json_encode($return);
         }

         //支付
    public function doPagePay3(){
      global $_W, $_GPC;
      include IA_ROOT.'/addons/zh_dianc/wxpay.php';
           // include 'wxpay.php';
      $res=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
      $appid=$res['appid'];
          $openid=$_GPC['openid'];//oQKgL0ZKHwzAY-KhiyEEAsakW5Zg
          $mch_id=$res['mchid'];
          $key=$res['wxkey'];
          $out_trade_no = $mch_id. time();
          pdo_update('wpdc_dmorder',array('code'=>$out_trade_no),array('id'=>$_GPC['order_id']));  
          $root=$_W['siteroot'];
          $total_fee =$_GPC['money'];
          $body = "订单付款";
          $total_fee = floatval($total_fee*100);           
           $weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee,$root);
           $return=$weixinpay->pay();
           echo json_encode($return);
         }
            //支付
    public function doPagePay4(){
      global $_W, $_GPC;
      include IA_ROOT.'/addons/zh_dianc/wxpay.php';
           // include 'wxpay.php';
      $res=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
      $appid=$res['appid'];
          $openid=$_GPC['openid'];//oQKgL0ZKHwzAY-KhiyEEAsakW5Zg
          $mch_id=$res['mchid'];
          $key=$res['wxkey'];
          $out_trade_no = $mch_id. time();
          pdo_update('wpdc_czorder',array('code'=>$out_trade_no),array('id'=>$_GPC['order_id']));  
          $root=$_W['siteroot'];
          $total_fee =$_GPC['money'];
            if(empty($total_fee)) //押金
            {
              $body = "订单付款";
              $total_fee = floatval(99*100);
            }else{
             $body = "订单付款";
             $total_fee = floatval($total_fee*100);
           }
           $weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee,$root);
           $return=$weixinpay->pay();
           echo json_encode($return);
         }
//地图
         public function doPageMap() {
          global $_GPC, $_W;
          $op=$_GPC['op'];
          $url="https://apis.map.qq.com/ws/geocoder/v1/?location=".$op."&key=EOJBZ-HSBW6-G2VSM-EE3KV-4OAAK-RXFWT&get_poi=0&coord_type=1";
          $html = file_get_contents($url);
          echo  $html;
        }


        public function doPageMap2(){
          global $_GPC, $_W;
          $op=$_GPC['op'];
          $url="https://apis.map.qq.com/ws/geocoder/v1/?address=".$op."&key=EOJBZ-HSBW6-G2VSM-EE3KV-4OAAK-RXFWT";
          $html = file_get_contents($url);
          echo  $html;
        }



//计算距离
        public function doPageJuLi(){
          global $_GPC, $_W;
          $from=$_GPC['start'];
          $to=$_GPC['end'];
          $url="https://apis.map.qq.com/ws/distance/v1/?mode=driving&from=".$from."&to=".$to."&key=EOJBZ-HSBW6-G2VSM-EE3KV-4OAAK-RXFWT";
          $html = file_get_contents($url);
          echo  $html;
        }

//转换坐标
        public function doPageZhuanh(){
          global $_GPC, $_W;
          $op=$_GPC['op'];
          $system=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
          $url="https://apis.map.qq.com/ws/coord/v1/translate?locations=".$op."&type=3&key=".$system['map_key'];
          $html = file_get_contents($url);
          echo  $html;
        }
//支付订单改变状态
        public function doPagePayOrder(){
          global $_W, $_GPC;
          $system=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
          $order=pdo_get('wpdc_order',array('id'=>$_GPC['order_id']));
           $store=pdo_get('wpdc_store',array('id'=>$order['seller_id']));
       if($order['type']==1){//外卖
       	$data['state']=3;
        if($store['is_jd']==1 and $store['jd_time']==0){
	$rrkd=pdo_get('wpdc_rrset',array('store_id'=>$order['seller_id'],'uniacid'=>$_W['uniacid']));
	$arr=explode(',',$store['coordinates']);
	$startlat=$arr[0];
	$startlng=$arr[1];
	preg_match('/(.*?(省|自治区|北京市|天津市))+(.*?(市|自治州))/', $store['address'], $matches);
	preg_match('/(.*?(省|自治区|北京市|天津市))+(.*?(市|自治州))/', $order['address'], $matches2);
	//var_dump($matches2);die;
	if($store['ps_mode']==4&&$order['is_take']==2){
	//调人人快递
	include IA_ROOT.'/addons/zh_dianc/rrkd/rrkd.php';
	$userName = $rrkd['username']; // 商户账号 人人快递提供
	$appKey = $rrkd['appkey']; // appKey 人人快递提供
	$timeStamp = @date ( 'Y-m-d' ); // 时间 加入请求头用以校验 【非常重要】
	$interfaceUrl = 'http://code.rrkd.cn/v2/addorderfortdd'; // 下单接口地址【测试环境】
	$sign = strtolower ( md5 ( $appKey . md5 ( $timeStamp ) . strtolower ( md5 ( $userName . $store['address'] . $order['address'] ) ) ) ); // 下单接口sign值生成规则请参加文档
	$postData = [  // 参数含义参见文档
	'userName' => $userName,
	'goodsName' => '食品',
	'goodsWeight' => 1,
	'goodsWorth' => ceil($order['money']),
	'startingLng' => $startlng,
	'startingLat' => $startlat,
	'consigneeLng' => $order['lng'],
	'consigneeLat' => $order['lat'],
	'mapFrom' => 1,
	'startingProvince' => $matches[1],
	'startingCity' => $matches[3],
	'startingAddress' => $store['address'],
	'startingPhone' => $store['tel'],
	'startingName' => $store['name'],
	'consigneeName' =>  $order['name'],
	'consigneePhone' => $order['tel'],
	'callbackUrl' => 'http://xxxx.com',
	'consigneeProvince' => $matches2[1],
	'consigneeCity' => $matches2[3],
	'consigneeAddress' => $order['address'],
	'businessNo' =>$order['order_num'], // 商家方订单号
	'dispatchers' => '',
	'payType' => 4,//支付方式
	'serviceFees' => 0,
	'remark' => $order['note'],
	'sign' => $sign,
	'version' => 2.0 
	];
	$header [] = "Content-Type: application/json"; // 指定请求头为application/json 【非常重要】
	$header [] = "timestamp:" . $timeStamp; // 【非常重要】
	$result = Rrkd::curlPost($interfaceUrl, json_encode($postData),10,$header);
	if (! empty ( $result )) {
	$res = json_decode ( $result, true );
	if (! $res ['status']) {
		$data['state']=2;
		exit ();
	}

	$data['state']=3;

	}
}  
        }else{
            $data['state']=2;
        }

      $data['pay_time']=time();
      $res=pdo_update('wpdc_order',$data,array('id'=>$_GPC['order_id']));
      if($res){
          pdo_update('wpdc_store',array('sales +='=>1),array('id'=>$order['seller_id']));
          $good=pdo_getall('wpdc_goods',array('order_id'=>$_GPC['order_id']));
          for($i=0;$i<count($good);$i++){
            pdo_update('wpdc_dishes', array('num -=' => $good[$i]['number']), array('id' => $good[$i]['dishes_id']));
            pdo_update('wpdc_dishes', array('xs_num +=' => $good[$i]['number']), array('id' => $good[$i]['dishes_id']));
          }
          echo '1';

        }else{
          echo '2';
        }
    }elseif($order['type']==2){//店内
      $data['dn_state']=2;
      $data['pay_type']=1;
      $data['pay_time']=time();
      $res=pdo_update('wpdc_order',$data,array('id'=>$_GPC['order_id']));
      if($res){


/////////////////分销/////////////////

        $set=pdo_get('wpdc_fxset',array('uniacid'=>$_W['uniacid']));
        $order=pdo_get('wpdc_order',array('id'=>$_GPC['order_id']));
        $store=pdo_get('wpdc_store',array('id'=>$order['seller_id']));
        $type=pdo_get('wpdc_storetype',array('id'=>$store['md_type']));
        if($set['is_open']==1){//开启分销
          if($set['is_type']==1){//开启分类分销
              if($set['is_ej']==2){//不开启二级分销
               $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
               if($user){
                    $userid=$user['user_id'];//上线id
                    $money=$order['money']*($type['commission']/100);//一级佣金
                    pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
                    $data6['user_id']=$userid;//上线id
                    $data6['son_id']=$order['user_id'];//下线id
                    $data6['money']=$money;//金额
                    $data6['time']=time();//时间
                    $data6['uniacid']=$_W['uniacid'];
                    pdo_insert('wpdc_earnings',$data6);
                  }
      }else{//开启二级
          $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
          $user2=pdo_get('wpdc_fxuser',array('fx_user'=>$user['user_id']));//上线的上线
          if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($type['commission']/100);//一级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data6);
          }
          if($user2){
            $userid2=$user2['user_id'];//上线的上线id
            $money=$order['money']*($type['commission2']/100);//二级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid2));
            $data7['user_id']=$userid2;//上线id
            $data7['son_id']=$order['user_id'];//下线id
            $data7['money']=$money;//金额
            $data7['time']=time();//时间
            $data7['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data7);
          }
        }
          }else{
            if($set['is_ej']==2){//不开启二级分销
           $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
           if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($set['commission']/100);//一级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data6);
          }
      }else{//开启二级
       $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
          $user2=pdo_get('wpdc_fxuser',array('fx_user'=>$user['user_id']));//上线的上线
          if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($set['commission']/100);//一级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data6);
          }
          if($user2){
            $userid2=$user2['user_id'];//上线的上线id
            $money=$order['money']*($set['commission2']/100);//二级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid2));
            $data7['user_id']=$userid2;//上线id
            $data7['son_id']=$order['user_id'];//下线id
            $data7['money']=$money;//金额
            $data7['time']=time();//时间
            $data7['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data7);
          }
        }
          }
        }
      
/////////////////分销/////////////////

/////////////////积分///////////////////////////
        if($order['is_yue']!=3){
          if($store['is_dnjf']==1 and $system['is_jf']==1){
            if($store['integral2']>0){
              $jifen=round(($store['integral2']/100)*$order['money']);
            pdo_update('wpdc_user',array('total_score +='=>$jifen),array('id'=>$order['user_id']));
            $data5['score']=$jifen;
            $data5['user_id']=$order['user_id'];
            $data5['note']='店内消费';
            $data5['type']=1;
            $data5['cerated_time']=date('Y-m-d H:i:s');
            $data5['uniacid']=$_W['uniacid'];//小程序id
            pdo_insert('wpdc_integral',$data5);
          }elseif($system['integral2']>0){
            $jifen=round(($system['integral2']/100)*$order['money']);
            pdo_update('wpdc_user',array('total_score +='=>$jifen),array('id'=>$order['user_id']));
            $data5['score']=$jifen;
            $data5['user_id']=$order['user_id'];
            $data5['note']='店内消费';
            $data5['type']=1;
            $data5['cerated_time']=date('Y-m-d H:i:s');
            $data5['uniacid']=$_W['uniacid'];//小程序id
            pdo_insert('wpdc_integral',$data5);
          }  
        }
        }
        
        
 /////////////////积分///////////////////////////
            //pdo_update('wpdc_table',array('status'=>3),array('id'=>$_GPC['table_id']));
          $good=pdo_getall('wpdc_goods',array('order_id'=>$_GPC['order_id']));
          for($i=0;$i<count($good);$i++){
            pdo_update('wpdc_dishes', array('num -=' => $good[$i]['number']), array('id' => $good[$i]['dishes_id']));
            pdo_update('wpdc_dishes', array('xs_num +=' => $good[$i]['number']), array('id' => $good[$i]['dishes_id']));
          }
          echo '1';

          
        }else{
          echo '2';
        }
      }

    }


//我的订单

    public function doPageMyorder(){
      global $_W, $_GPC;
      $user_id=$_GPC['user_id'];
    //$res=pdo_getall('dc_order',array('user_id'=>$userid));
      $sql="select a.* ,b.logo,b.name as store_name,b.tel as store_tel from " . tablename("wpdc_order") . " a"  . " left join " . tablename("wpdc_store") . " b on b.id=a.seller_id   WHERE a.user_id=:user_id  and a.del=:del ORDER BY id DESC ";
      $res=pdo_fetchall($sql,array(':user_id'=>$user_id,'del'=>2));


   // $res=pdo_getall('wpdc_order',array('user_id'=>$user_id), array() , '' , 'id Desc');
      $res2=pdo_getall('wpdc_goods');
  //  $res3=pdo_get('wpdc_store',array('uniacid'=>$_W['uniacid']));
      $data2=array();
      for($i=0;$i<count($res);$i++){
        $data=array();
        for($k=0;$k<count($res2);$k++){
          if($res[$i]['id']==$res2[$k]['order_id']){
            $data[]=array(
              'name'=>$res2[$k]['name'],
              'num'=>$res2[$k]['number'],
              'img'=>$res2[$k]['img'],
              'money'=>$res2[$k]['money'],
              'dishes_id'=>$res2[$k]['dishes_id']
              );
          }
        }
        $data2[]=array(
          'id'=>$res[$i]['id'],
          'order_num'=>$res[$i]['order_num'],
          'time'=>$res[$i]['time'],
          'state'=>$res[$i]['state'],
          'dn_state'=>$res[$i]['dn_state'],
          'money'=>$res[$i]['money'],
          'type'=>$res[$i]['type'],
          'tel'=>$res[$i]['store_tel'],
          'goods'=>$data,
          'img'=> $res[$i]['logo'],
          'name'=> $res[$i]['store_name'],
          'is_yue'=> $res[$i]['is_yue']
          );
      }
      echo json_encode($data2);

    }



//订单详情
    public function doPageOrderInfo(){
      global $_W, $_GPC;
        // $res=pdo_get('wpdc_order',array('id'=>$_GPC['id']));
      $sql="select a.* ,b.name as table_name ,c.name  as  table_name_type from " . tablename("wpdc_order") . " a"  . " left join " . tablename("wpdc_table") . " b on b.id=a.table_id " . " left join " . tablename("wpdc_table_type") . " c on b.type_id=c.id WHERE a.id=:id";
      $res=pdo_fetch($sql,array(':id'=>$_GPC['id']));
      $res2=pdo_getall('wpdc_goods',array('order_id'=>$_GPC['id']));
      $res3=pdo_get('wpdc_store',array('id'=>$res['seller_id']));
      $data['order']=$res;
      $data['good']=$res2;
      $data['store']=$res3;
      echo json_encode($data);
    }
//取消订单
    public function doPageCancelOrder(){
      global $_W, $_GPC;
      $order=pdo_get('wpdc_order',array('id'=>$_GPC['order_id']));
      if($order['type']==1){
       $data['state']=5;
     }elseif($order['type']==2){
      $data['dn_state']=3;
    }
    $data['cancel_time']=time();
    $res=pdo_update('wpdc_order',$data,array('id'=>$_GPC['order_id']));
    if($res){
      $data3['state']=2;
      if($order['coupons_id']){
       pdo_update('wpdc_usercoupons',$data3,array('coupons_id'=>$order['coupons_id'],'user_id'=> $order['user_id']));
     }
     if($order['voucher_id']){
       pdo_update('wpdc_uservoucher',$data3,array('vouchers_id'=>$order['voucher_id'],'user_id'=> $order['user_id']));
     }
     echo '1';  
   }else{
    echo '2';
  }  
}
//删除订单
public function doPageDelOrder(){
  global $_W, $_GPC;
  $res=pdo_update('wpdc_order',array('del'=>1),array('id'=>$_GPC['order_id']));
  if($res){
    echo '1';
  }else{
    echo '2';
  }
}

//更新用户地址信息
public function doPageUpdAdd(){
  global $_W, $_GPC;
  $data['user_name']=$_GPC['user_name'];
  $data['user_tel']=$_GPC['user_tel'];
  $data['user_address']=$_GPC['user_address'];
  $res=pdo_update('wpdc_user',$data,array('id'=>$_GPC['user_id']));
  if($res){
    echo '1';
  }else{
    echo '2';
  }
}

 //评论
public function  doPagePl(){
  global $_W, $_GPC;
        $data['seller_id']=$_GPC['seller_id'];//商家id
        $data['order_id']=$_GPC['order_id'];//订单id
        $data['order_num']=$_GPC['order_num'];//订单号
        $data['score']=$_GPC['score'];//分数
        $data['content']=$_GPC['content'];//内容
        $data['img']=$_GPC['img'];//图片
        $data['cerated_time']=date("Y-m-d H:i:s",time());//创建时间
        $data['user_id']=$_GPC['user_id'];//用户id
        $data['uniacid']=$_W['uniacid'];//小程序id
        $data['status']=1;//未回复
        $res=pdo_insert('wpdc_assess',$data);
        $order=pdo_get('wpdc_order',array('id'=>$_GPC['order_id']));
        if($res){
         $total=pdo_get('wpdc_assess', array('uniacid'=>$_W['uniacid'],'seller_id'=>$_GPC['seller_id']), array('sum(score) as total'));
         $count=pdo_get('wpdc_assess', array('uniacid'=>$_W['uniacid'],'seller_id'=>$_GPC['seller_id']), array('count(id) as count'));
         if($total['total']>0 and $count['count']>0){
          $pf=($total['total']/$count['count']);
          $pf=number_format($pf,1);
        }else{
          $pf=0;
        }
        pdo_update('wpdc_store',array('score'=>$pf),array('id'=>$_GPC['seller_id']));
          // echo $order['type'];die;
        if($order['type']==1){
          $data2['state']=6;
        }elseif($order['type']==2){
         $data2['dn_state']=4;
       }
            //wpdc_integral
        $system=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
        if($system['is_jf']==1){
          $data3['score']=$_GPC['total_score'];
           $data3['user_id']=$_GPC['user_id'];
           $data3['type']=1;
           $data3['order_id']=$_GPC['order_id'];
           $data3['note']='评价订单';
           $data3['cerated_time']=date('Y-m-d H:i:s');
          $data3['uniacid']=$_W['uniacid'];//小程序id
          pdo_insert('wpdc_integral',$data3);
          pdo_update('wpdc_user',array('total_score +='=>$_GPC['total_score']),array('id'=>$_GPC['user_id']));
        }
      pdo_update('wpdc_order',$data2,array('id'=>$_GPC['order_id']));
      echo '1';
    }else{

      echo '2';

    }

  }

//积分明细
  public function doPageJfmx(){
    global $_W, $_GPC;
    $res=pdo_getall('wpdc_integral',array('user_id'=>$_GPC['user_id']),array(),'','id DESC');
    echo json_encode($res);
  }

    //查看评论
  public function doPageStorePl(){
   global $_W, $_GPC;
   $sql="select a.* ,b.name as user_name,b.img  as  user_img from " . tablename("wpdc_assess") . " a"  . " left join " . tablename("wpdc_user") . " b on b.id=a.user_id   WHERE a.seller_id=:seller_id ORDER BY id DESC";
   $list=pdo_fetchall($sql,array(':seller_id'=>$_GPC['id']));
   echo json_encode($list);
 }

//幻灯片
 public function doPageAd(){
  global $_W, $_GPC;
  $res=pdo_getall('wpdc_slide',array('uniacid'=>$_W['uniacid']));
  echo json_encode($res);

}
//广告
public function doPageAd2(){
  global $_W, $_GPC;
  $res=pdo_getall('wpdc_ad',array('uniacid'=>$_W['uniacid'],'status'=>1),array(),'','orderby asc');
  echo json_encode($res);

}
//广告详情
public function doPageAdInfo(){
  global $_W, $_GPC;
  $res=pdo_get('wpdc_ad',array('id'=>$_GPC['id']));
  echo json_encode($res);
}

//预定
public function doPageReservation(){
  global $_W, $_GPC;
  $system=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
         $data['store_id']=$_GPC['store_id'];//商家id
         $data['user_id']=$_GPC['user_id'];//用户id
         $data['xz_date']=$_GPC['xz_date'];//选择日期
         $data['yjdd_date']=$_GPC['yjdd_date'];//预计到店时间
         $data['table_type_id']=$_GPC['table_type_id'];//桌位类型ID
         $data['link_name']=$_GPC['link_name'];//联系人
         $data['link_tel']=$_GPC['link_tel'];//联系电话
         $data['jc_num']=$_GPC['jc_num'];//就餐人数
         $data['remark']=$_GPC['remark'];//备注
         $data['pay_money']=$_GPC['money'];//付款金额
         $data['ydcode']=$_GPC['ydcode'];//
         $data['order_num']=date('YmdHis',time()).rand(1111,9999);//订单号
         $data['table_type_name']=$_GPC['table_type_name'];//桌台类型名称
         $data['zd_cost']=$_GPC['zd_cost'];//桌台类型最低消费
         $data['state']=0;//待支付
         $data['del']=2;//未删除
         $data['uniacid']=$_W['uniacid'];//小程序id
         $data['created_time']=date('Y-m-d H:i:s');//下单时间
         $data['time2']=time();//下单时间搓
         $data['is_yue']=$_GPC['is_yue'];//余额
         $data['form_id']=$_GPC['form_id'];//余额
         
         $res=pdo_insert('wpdc_ydorder',$data);
         $order_id=pdo_insertid();
         if($res){
          if($_GPC['is_yue']==1){
            pdo_update('wpdc_ydorder',array('state'=>1),array('id'=>$order_id));
           pdo_update('wpdc_user',array('wallet -='=>$_GPC['money']),array('id'=>$_GPC['user_id']));
           $data4['money']=$_GPC['money'];
           $data4['user_id']=$_GPC['user_id'];
           $data4['type']=2;
           $data4['note']='预约订单';
           $data4['time']=date('Y-m-d H:i:s');
           pdo_insert('wpdc_qbmx',$data4);
           pdo_update('wpdc_ydorder',array('state'=>1),array('id'=>$order_id));
         }elseif($_GPC['is_yue']==3){
          pdo_update('wpdc_ydorder',array('state'=>1),array('id'=>$order_id));
            pdo_update('wpdc_user',array('total_score -='=>$_GPC['jf']),array('id'=>$_GPC['user_id']));
            $jf['score']=$_GPC['jf'];
            $jf['user_id']=$_GPC['user_id'];
            $jf['type']=2;
            $jf['note']='预约订单';
            $jf['order_id']=$order_id;
            $jf['cerated_time']=date('Y-m-d H:i:s');
            pdo_insert('wpdc_integral',$jf);
         }elseif($_GPC['is_yue']==0){
          pdo_update('wpdc_ydorder',array('state'=>1),array('id'=>$order_id));
         }
        

        echo $order_id;
      }else{
        echo '预定失败';
      }
    }


    //删除预约
    public function doPageDelYd(){
      global $_W, $_GPC;
      $data['del']=1;
      $res=pdo_update('wpdc_ydorder',$data,array('id'=>$_GPC['id']));
      if($res){
        echo  '1';
      }else{
        echo  '2';
      }
    }
    //取消预约
    public function doPageCancelReservation(){
      global $_W, $_GPC;
      $data['state']=4;
      $res=pdo_update('wpdc_ydorder',$data,array('id'=>$_GPC['id']));
      if($res){
        echo  '1';
      }else{
        echo  '2';
      }
    }
    //申请退款预约
    public function doPageYdRefund(){
      global $_W, $_GPC;
      $data['state']=5;
      $res=pdo_update('wpdc_ydorder',$data,array('id'=>$_GPC['id']));
      if($res){
        echo  '1';
      }else{
        echo  '2';
      }
    }



    //查看我的预约
    public function doPageMyReservation(){
      global $_W, $_GPC;
      $sql="select a.* ,b.name,b.tel,b.logo from " . tablename("wpdc_ydorder") . " a"  . " left join " . tablename("wpdc_store") . " b on b.id=a.store_id   WHERE a.user_id=:user_id and a.del=:del and a.state!=0 ORDER BY a.id DESC";
      $list=pdo_fetchall($sql,array(':user_id'=>$_GPC['user_id'],':del'=>2));
      echo json_encode($list);
    }




    //查看我的预约详情
    public function doPageReservationInfo(){
      global $_W, $_GPC;
      $sql="select a.* ,b.name,b.tel,b.logo from " . tablename("wpdc_ydorder") . " a"  . " left join " . tablename("wpdc_store") . " b on b.id=a.store_id   WHERE a.id=:id ";
      $list=pdo_fetch($sql,array(':id'=>$_GPC['id']));
      echo json_encode($list);
    }

//座位类型
    public function doPageTableType(){
     global $_W, $_GPC;
     $res=pdo_getall('wpdc_table_type',array('uniacid'=>$_W['uniacid'],'seller_id'=>$_GPC['store_id']));
     echo json_encode($res);
   }
//座号
   public function doPageTable(){
    global $_W, $_GPC;
    $res=pdo_getall('wpdc_table',array('uniacid'=>$_W['uniacid'],'type_id'=>$_GPC['type_id'],'status'=>0));
    echo json_encode($res);
  }

//下订单发短信
  public function doPageSms(){
    global $_W, $_GPC;
    $res=pdo_get('wpdc_sms',array('uniacid'=>$_W['uniacid'],'store_id'=>$_GPC['store_id']));
    $tpl_id=$res['tpl_id'];
    $tel=$res['tel'];
    $key=$res['appkey'];
    $url = "http://v.juhe.cn/sms/send?mobile=".$tel."&tpl_id=".$tpl_id."&tpl_value=%23code%23%3D654654&key=".$key;
    $data=file_get_contents($url);
    print_r($data);
  }


//预约发短信
  public function doPageSms2(){
    global $_W, $_GPC;
    $res=pdo_get('wpdc_sms',array('uniacid'=>$_W['uniacid'],'store_id'=>$_GPC['store_id']));
    $tpl_id=$res['tpl2_id'];
    $tel=$res['tel'];
    $key=$res['appkey'];
    $url = "http://v.juhe.cn/sms/send?mobile=".$tel."&tpl_id=".$tpl_id."&tpl_value=%23code%23%3D654654&key=".$key;
    $data=file_get_contents($url);
    print_r($data);
  }
//店内发短信
  public function doPageSms3(){
    global $_W, $_GPC;
    $res=pdo_get('wpdc_sms',array('uniacid'=>$_W['uniacid'],'store_id'=>$_GPC['store_id']));
    $tpl_id=$res['tpl3_id'];
    $tel=$res['tel'];
    $key=$res['appkey'];
    $url = "http://v.juhe.cn/sms/send?mobile=".$tel."&tpl_id=".$tpl_id."&tpl_value=%23code%23%3D654654&key=".$key;
    $data=file_get_contents($url);
    print_r($data);
  }
  //短信配置
  public function doPageSmsSet(){
  global $_W, $_GPC;
  $res=pdo_get('wpdc_sms',array('uniacid'=>$_W['uniacid'],'store_id'=>$_GPC['store_id']));
  echo  json_encode($res);
  }
//查看是否为外卖新用户
  public function doPageNew(){
    global $_W, $_GPC;
    $res=pdo_get('wpdc_order',array('user_id'=>$_GPC['user_id'],'type'=>1,'seller_id'=>$_GPC['store_id']));
    if($res){
        echo  '2';//不是
      }else{
        echo  '1';//是
      }
    }

//计算商家评分
    public function doPageScore(){
      global $_W, $_GPC;
      $total=pdo_get('wpdc_assess', array('uniacid'=>$_W['uniacid'],'seller_id'=>$_GPC['seller_id']), array('sum(score) as total'));
      $count=pdo_get('wpdc_assess', array('uniacid'=>$_W['uniacid'],'seller_id'=>$_GPC['seller_id']), array('count(id) as count'));
      if($total['total']>0 and $count['count']>0){
        echo ($total['total']/$count['count']);
      }else{
        echo '0';
      }
    }



//确认收货
    public function doPageComplete(){
      global $_W, $_GPC;
      $data['state']=4;
     // $data['completion_time']=time();
    $system=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
      $res=pdo_update('wpdc_order',$data,array('id'=>$_GPC['id']));
      if($res){

/////////////////分销/////////////////

        $set=pdo_get('wpdc_fxset',array('uniacid'=>$_W['uniacid']));
        $order=pdo_get('wpdc_order',array('id'=>$_GPC['id']));
        $store=pdo_get('wpdc_store',array('id'=>$order['seller_id']));
        $type=pdo_get('wpdc_storetype',array('id'=>$store['md_type']));
        if($set['is_open']==1){//开启分销
          if($set['is_type']==1){//开启分类分销
              if($set['is_ej']==2){//不开启二级分销
               $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
               if($user){
                    $userid=$user['user_id'];//上线id
                    $money=$order['money']*($type['commission']/100);//一级佣金
                    pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
                    $data6['user_id']=$userid;//上线id
                    $data6['son_id']=$order['user_id'];//下线id
                    $data6['money']=$money;//金额
                    $data6['time']=time();//时间
                    $data6['uniacid']=$_W['uniacid'];
                    pdo_insert('wpdc_earnings',$data6);
                  }
      }else{//开启二级
          $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
          $user2=pdo_get('wpdc_fxuser',array('fx_user'=>$user['user_id']));//上线的上线
          if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($type['commission']/100);//一级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data6);
          }
          if($user2){
            $userid2=$user2['user_id'];//上线的上线id
            $money=$order['money']*($type['commission2']/100);//二级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid2));
            $data7['user_id']=$userid2;//上线id
            $data7['son_id']=$order['user_id'];//下线id
            $data7['money']=$money;//金额
            $data7['time']=time();//时间
            $data7['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data7);
          }
        }
          }else{
            if($set['is_ej']==2){//不开启二级分销
           $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
           if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($set['commission']/100);//一级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data6);
          }
      }else{//开启二级
       $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
          $user2=pdo_get('wpdc_fxuser',array('fx_user'=>$user['user_id']));//上线的上线
          if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($set['commission']/100);//一级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data6);
          }
          if($user2){
            $userid2=$user2['user_id'];//上线的上线id
            $money=$order['money']*($set['commission2']/100);//二级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid2));
            $data7['user_id']=$userid2;//上线id
            $data7['son_id']=$order['user_id'];//下线id
            $data7['money']=$money;//金额
            $data7['time']=time();//时间
            $data7['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data7);
          }
        }
          }
        }
      
/////////////////分销/////////////////


/////////////////积分///////////////////////////
        if($order['is_yue']!=3){
          if($store['is_wmjf']==1 and $system['is_jf']==1){
          if($store['integral2']){
              $jifen=round(($store['integral2']/100)*$order['money']);
              pdo_update('wpdc_user',array('total_score +='=>$jifen),array('id'=>$order['user_id']));
              $data5['score']=$jifen;
              $data5['user_id']=$order['user_id'];
              $data5['note']='外卖消费';
              $data5['type']=1;
              $data5['cerated_time']=date('Y-m-d H:i:s');
              $data5['uniacid']=$_W['uniacid'];//小程序id
              pdo_insert('wpdc_integral',$data5);
          }elseif($system['integral2']){
            $jifen=round(($system['integral2']/100)*$order['money']);
              pdo_update('wpdc_user',array('total_score +='=>$jifen),array('id'=>$order['user_id']));
              $data5['score']=$jifen;
              $data5['user_id']=$order['user_id'];
              $data5['note']='外卖消费';
              $data5['type']=1;
              $data5['cerated_time']=date('Y-m-d H:i:s');
              $data5['uniacid']=$_W['uniacid'];//小程序id
              pdo_insert('wpdc_integral',$data5);
          }
      }
        }
        
       
 /////////////////积分///////////////////////////











        echo '1';
      }else{
        echo  '2';
      }
    }

//通过桌号查桌子名称和类型
    public function doPageZhuohao(){
     global $_W, $_GPC;
     $res=pdo_get('wpdc_table',array('id'=>$_GPC['id'])); 
     $res2=pdo_get('wpdc_table_type',array('id'=>$res['type_id']));
     $data['table_name']=$res['name'];
     $data['type_name']=$res2['name'];
     $data['status']=$res['status'];
     echo json_encode($data);
   }
//帮助中心
   public function doPageGetHelp(){
     global $_W, $_GPC;
     $res= pdo_getall('wpdc_help',array('uniacid'=>$_W['uniacid']),array() , '' , 'sort ASC');
     echo json_encode($res);
   }

















//上传
   public function doPageUpload(){
    $uptypes=array(  
      'image/jpg',  
      'image/jpeg',  
      'image/png',  
      'image/pjpeg',  
      'image/gif',  
      'image/bmp',  
      'image/x-png'  
      );  
    $max_file_size=2000000;     //上传文件大小限制, 单位BYTE  
    $destination_folder="../attachment/"; //上传文件路径  
    $watermark=2;      //是否附加水印(1为加水印,其他为不加水印);  
    $watertype=1;      //水印类型(1为文字,2为图片)  
    $waterposition=1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);  
    $waterstring="666666";  //水印字符串  
    // $waterimg="xplore.gif";    //水印图片  
    $imgpreview=1;      //是否生成预览图(1为生成,其他为不生成);  
    $imgpreviewsize=1/2;    //缩略图比例  
    if (!is_uploaded_file($_FILES["upfile"]['tmp_name'])) 
    //是否存在文件
    {
     echo "图片不存在!";  
     exit;  
   }  
   $file = $_FILES["upfile"];
   if($max_file_size < $file["size"])
    //检查文件大小
   {  
    echo "文件太大!"; 
    exit;
  }  
  if(!in_array($file["type"], $uptypes))  
    //检查文件类型  
  {
    echo "文件类型不符!".$file["type"];
    exit;
  }
  if(!file_exists($destination_folder))
  {
    mkdir($destination_folder);
  }  

  $filename=$file["tmp_name"];  
  $image_size = getimagesize($filename);  
  $pinfo=pathinfo($file["name"]);  
  $ftype=$pinfo['extension'];  
  $destination = $destination_folder.time().".".$ftype;  
  if (file_exists($destination) && $overwrite != true)  
  {  
    echo "同名文件已经存在了";  
    exit;  
  }  
  if(!move_uploaded_file ($filename, $destination))  
  {  
    echo "移动文件出错";  
    exit;
  }
  $pinfo=pathinfo($destination);  
  $fname=$pinfo['basename'];  
  if($watermark==1)
  {  
    $iinfo=getimagesize($destination,$iinfo);  
    $nimage=imagecreatetruecolor($image_size[0],$image_size[1]);  
    $white=imagecolorallocate($nimage,255,255,255);  
    $black=imagecolorallocate($nimage,0,0,0);  
    $red=imagecolorallocate($nimage,255,0,0);  
    imagefill($nimage,0,0,$white);  
    switch ($iinfo[2])  
    {  
      case 1:  
      $simage =imagecreatefromgif($destination);  
      break;  
      case 2:  
      $simage =imagecreatefromjpeg($destination);  
      break;  
      case 3:  
      $simage =imagecreatefrompng($destination);  
      break;  
      case 6:  
      $simage =imagecreatefromwbmp($destination);  
      break;  
      default:  
      die("不支持的文件类型");  
      exit;  
    }  
    imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);  
    imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);  
    switch($watertype)  
    {  
            case 1:   //加水印字符串  
            imagestring($nimage,2,3,$image_size[1]-15,$waterstring,$black);  
            break;  
            case 2:   //加水印图片  
            $simage1 =imagecreatefromgif("xplore.gif");  
            imagecopy($nimage,$simage1,0,0,0,0,85,15);  
            imagedestroy($simage1);  
            break;
          }
          switch ($iinfo[2])  
          {  
            case 1:  
            //imagegif($nimage, $destination);  
            imagejpeg($nimage, $destination);  
            break;  
            case 2:  
            imagejpeg($nimage, $destination);  
            break;  
            case 3:  
            imagepng($nimage, $destination);  
            break;  
            case 6:  
            imagewbmp($nimage, $destination);
            //imagejpeg($nimage, $destination);  
            break;
          }
        //覆盖原上传文件  
          imagedestroy($nimage);
          imagedestroy($simage);
        }
        echo $fname;
        @require_once (IA_ROOT . '/framework/function/file.func.php');
        @$filename=$fname;
        @file_remote_upload($filename);
      }







































//发送模板消息(支付订单)



      public function doPageMessage(){
       global $_W, $_GPC;
       function getaccess_token($_W){
         $res=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
         $appid=$res['appid'];
         $secret=$res['appsecret'];
         $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL,$url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
         $data = curl_exec($ch);
         curl_close($ch);
         $data = json_decode($data,true);
         return $data['access_token'];
       }
      //设置与发送模板信息
       function set_msg($_W){
         $access_token = getaccess_token($_W);
         $res=pdo_get('wpdc_sms',array('uniacid'=>$_W['uniacid']));
         $res2=pdo_get('wpdc_order',array('id'=>$_GET['id']));
         $formwork ='{
           "touser": "'.$_GET["openid"].'",
           "template_id": "'.$res["tid"].'",
           "form_id":"'.$_GET['form_id'].'",
           "data": {
             "keyword1": {
               "value": "'.$res2['order_num'].'",
               "color": "#173177"
             },
             "keyword2": {
               "value":"'.$res2['name'].'",
               "color": "#173177"
             },
             "keyword3": {
               "value": "'.$res2['tel'].'",
               "color": "#173177"
             },
             "keyword4": {
               "value":  "'.$res2['money'].'",
               "color": "#173177"
             },
             "keyword5": {
               "value": "'.date("Y-m-d H:i:s",$res2['pay_time']).'",
               "color": "#173177"
             }
           }
         }';
             // $formwork=$data;
         $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$access_token."";
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL,$url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
         curl_setopt($ch, CURLOPT_POST,1);
         curl_setopt($ch, CURLOPT_POSTFIELDS,$formwork);
         $data = curl_exec($ch);
         curl_close($ch);
         return $data;
       }
       echo set_msg($_W);
     }

//发送模板消息(当面付)

     public function doPageMessage2(){
      global $_W, $_GPC;
      function getaccess_token($_W){
       $res=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
       $appid=$res['appid'];
       $secret=$res['appsecret'];
       $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL,$url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
       $data = curl_exec($ch);
       curl_close($ch);
       $data = json_decode($data,true);
       return $data['access_token'];
     }
      //设置与发送模板信息
     function set_msg($_W){
       $access_token = getaccess_token($_W);
       $res=pdo_get('wpdc_sms',array('uniacid'=>$_W['uniacid']));
       $formwork ='{
         "touser": "'.$_GET["openid"].'",
         "template_id": "'.$res["dm_tid"].'",
         "form_id":"'.$_GET['form_id'].'",
         "data": {
           "keyword1": {
             "value": "'.$_GET['name'].'",
             "color": "#173177"
           },
           "keyword2": {
             "value":"'.$_GET['money'].'",
             "color": "#173177"
           },
           "keyword3": {
             "value": "'.date('Y-m-d H:i:s').'",
             "color": "#173177"
           }
         }  
       }';
             // $formwork=$data;
       $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$access_token."";
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL,$url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
       curl_setopt($ch, CURLOPT_POST,1);
       curl_setopt($ch, CURLOPT_POSTFIELDS,$formwork);
       $data = curl_exec($ch);
       curl_close($ch);
       return $data;
     }
     echo set_msg($_W);
   }
//预定



   public function doPageMessage3(){
     global $_W, $_GPC;
     function getaccess_token($_W){
       $res=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
       $appid=$res['appid'];
       $secret=$res['appsecret'];
       $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL,$url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
       $data = curl_exec($ch);
       curl_close($ch);
       $data = json_decode($data,true);
       return $data['access_token'];
     }



      //设置与发送模板信息
     function set_msg($_W){
       $access_token = getaccess_token($_W);
       $res=pdo_get('wpdc_sms',array('uniacid'=>$_W['uniacid']));
       $formwork ='{
         "touser": "'.$_GET["openid"].'",
         "template_id": "'.$res["yy_tid"].'",
         "form_id":"'.$_GET['form_id'].'",
         "data": {
           "keyword1": {
             "value": "'.$_GET['store_name'].'",
             "color": "#173177"
           },
           "keyword2": {
             "value":"'.$_GET['xz_date'].'　'.$_GET['yjdd_date'].'",
             "color": "#173177"
           },
           "keyword3": {
             "value": "'.$_GET['link_name'].'",
             "color": "#173177"
           },
           "keyword4": {
             "value": "'.$_GET['link_tel'].'",
             "color": "#173177"
           },
           "keyword5": {
             "value": "'.$_GET['jc_num'].'",
             "color": "#173177"
           },
           "keyword6": {
             "value": "'.$_GET['remark'].'",
             "color": "#173177"
           }
         }
       }';
             // $formwork=$data;
       $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$access_token."";
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL,$url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
       curl_setopt($ch, CURLOPT_POST,1);
       curl_setopt($ch, CURLOPT_POSTFIELDS,$formwork);
       $data = curl_exec($ch);
       curl_close($ch);
       return $data;
     }
     echo set_msg($_W);
   }





 public function doPagePrint(){ // $times打印次数
  global $_W, $_GPC;
  
  $res=pdo_get('wpdc_order',array('id'=>$_GPC['order_id']));
  $res3=pdo_get('wpdc_dyj',array('uniacid'=>$_W['uniacid'],'store_id'=>$res['seller_id'],'state'=>1,'location'=>1));
  //var_dump($res3);die;
  $res2=pdo_getall('wpdc_goods',array('order_id'=>$_GPC['order_id']));
if($res['is_yue']==1){
  $is_yue="余额支付";
}elseif($res['is_yue']==2){
  $is_yue="微信支付";
}elseif($res['is_yue']==3){
  $is_yue="积分支付";
}
if($res['is_take']==1){
  $is_take= "店内自提\n";
}
if($res3['type']!=3){
 $content = "\n\n\n\n";
 if($res3['type']==1 and $res3['num']){
   $content = "^N".$res3['num']."\n";
 }
 
  $content .= "         订单编号  #".$res['id']." \n\n";
  $content .= "          ".$is_take." \n";
  $content .= "          ".$res3['dyj_title']."\n\n";
  $content .= "----------".$is_yue."------------\n";
  $content .= "--------------------------------\n";
  $content .= "下单时间：".$res['time']."\n";
  $content .= "--------------------------------\n";
  if($res['is_take']==1){
  $content .= "自提时间：".$res['delivery_time']."\n";
  $content .= "--------------------------------\n";
}
  $content .='名称'.str_repeat(" ",15)."数量  价格\n";
  $content .= "--------------------------------\n";
  $name='';
for($i=0;$i<count($res2);$i++){
  $name=$res2[$i]['name'];
  $content .= "".$name."\n";
  $content .=str_repeat(" ",20).$res2[$i]['number']."   ".number_format($res2[$i]['number']*$res2[$i]['money'],2)."\n";
}
$content .= "--------------------------------\n";
$content .= "餐盒费：　　　　　　　　".$res['box_fee']."\n";
$content .= "--------------------------------\n";
$content .= "配送费：　　　　　　　　".$res['freight']."\n";
$content .= "--------------------------------\n";
$content .= "优惠：　　　　　　　　 -".number_format($res['preferential'],2)."\n";
$content .= "--------------------------------\n";
$content .= "已付：　　　　　　　　　".$res['money']."\n";
$content .= "--------------------------------\n";
$content .= "送货地点：".$res['address']."\n\n";
$content .= "联系电话：".$res['tel']."\n\n";
$content .= "联系人：".$res['name']."\n\n";

if($res['note']){
  $content .= "备注：".$res['note']."\n\n\n\n\n\n";
}
}
// $content .= "^Q +https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzI1NTQ5NDQzMQ==&scene=124#wechat_redirect";
    //echo 1;die;
if($res3['type']==1){//365打印
  
$selfMessage = array(
  'deviceNo'=>$res3['dyj_id'],  
  'printContent'=>$content,
  'key'=>$res3['dyj_key'],
  'times'=>'1'
  );        
$url = "http://open.printcenter.cn:8080/addOrder";
$options = array(
  'http' => array(
    'header' => "Content-type: application/x-www-form-urlencoded ",
    'method'  => 'POST',
    'content' => http_build_query($selfMessage),
    ),
  );
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

return $result;
}
if($res3['type']==2){//易联云
  include("print.class.php");
  $print = new Yprint();
  $apiKey = $res3['api'];
  $msign = $res3['token'];
  $partner=$res3['yy_id'];
  $machine_code=$res3['mid'];
 
//打印
  $print->action_print( $partner,$machine_code,$content,$apiKey,$msign);
}
if($res3['type']==3){//飞蛾
  $content .= "　　　　　订单编号  #".$res['id']." <BR>";
  $content .= "　　　　　".$is_take." \n";
  $content .= "          ".$res3['dyj_title']."<BR>";
  $content .= "-------------".$is_yue."-----------<BR>";
  $content .= "--------------------------------<BR>";
  $content .= "下单时间：".$res['time']."<BR>";
  $content .= "--------------------------------<BR>";
  if($res['is_take']==1){
  $content .= "自提时间：".$res['delivery_time']."<BR>";
  $content .= "--------------------------------<BR>";
}
  $content .="名称　　　　　 数量　  单价 <BR>";
  $content .= "-------------------------------<BR>";
  $name='';
for($i=0;$i<count($res2);$i++){
  $name=$res2[$i]['name'];
  $content .= "".$name."<BR>";
  $content .="　　　　　　 　　".$res2[$i]['number']." 　 ".number_format($res2[$i]['number']*$res2[$i]['money'],2)."<BR>";
}
$content .= "--------------------------------<BR>";
$content .= "餐盒费：　　　　　　　".$res['box_fee']."<BR>";
$content .= "--------------------------------<BR>";
$content .= "配送费：　　　　　　　".$res['freight']."<BR>";
$content .= "--------------------------------<BR>";
$content .= "优惠：　　　　　　　　-".number_format($res['preferential'],2)."<BR>";
$content .= "--------------------------------<BR>";
$content .= "已付：　　　　　　　  ".$res['money']."<BR>";
$content .= "--------------------------------<BR>";
$content .= "送货地点：".$res['address']."<BR><BR>";
$content .= "联系电话：".$res['tel']."<BR><BR>";
$content .= "联系人：".$res['name']."<BR><BR>";

if($res['note']){
  $content .= "备注：".$res['note']."<BR><BR><BR>";
}
 header("Content-type: text/html; charset=utf-8");
include 'HttpClient.class.php';
define('USER', $res3['fezh']); //*必填*：飞鹅云后台注册账号
define('UKEY', $res3['fe_ukey']); //*必填*: 飞鹅云注册账号后生成的UKEY
define('SN', $res3['fe_dycode']);    //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API
//以下参数不需要修改
define('IP','api.feieyun.cn');      //接口IP或域名
define('PORT',80);            //接口IP端口
define('PATH','/Api/Open/');    //接口路径
define('STIME', time());          //公共参数，请求时间
define('SIG', sha1(USER.UKEY.STIME));
function wp_print($printer_sn,$orderInfo,$times){
    $content = array(     
      'user'=>USER,
      'stime'=>STIME,
      'sig'=>SIG,
      'apiname'=>'Open_printMsg',

      'sn'=>$printer_sn,
      'content'=>$orderInfo,
        'times'=>$times//打印次数
    );
    
  $client = new HttpClient(IP,PORT);
  if(!$client->post(PATH,$content)){
    echo 'error';
  }
  else{
    //服务器返回的JSON字符串，建议要当做日志记录起来
    echo $client->getContent();
  }
  
}
wp_print(SN,$content,1);


}

}




 public function doPagePrint2(){ // $times打印次数
  global $_W, $_GPC;
  $res=pdo_get('wpdc_order',array('id'=>$_GPC['order_id']));
  $res3=pdo_get('wpdc_dyj',array('uniacid'=>$_W['uniacid'],'store_id'=>$res['seller_id'],'state'=>1,'location'=>2));
  $res2=pdo_getall('wpdc_goods',array('order_id'=>$_GPC['order_id']));

if($res['is_yue']==1){
  $is_yue="余额支付";
}elseif($res['is_yue']==2){
  $is_yue="微信支付";
}elseif($res['is_yue']==3){
  $is_yue="积分支付";
}
if($res['is_take']==1){
  $is_take= "店内自提\n";
}
if($res3['type']!=3){
 $content = "\n\n\n\n";
 if($res3['type']==1 and $res3['num']){
   $content = "^N".$res3['num']."\n";
 }
  $content .= "         订单编号  #".$res['id']." \n\n";
  $content .= "          ".$is_take." \n";
  $content .= "          ".$res3['dyj_title']."\n\n";
  $content .= "----------".$is_yue."------------\n";
  $content .= "--------------------------------\n";
  $content .= "下单时间：".$res['time']."\n";
  $content .= "--------------------------------\n";
if($res['is_take']==1){
  $content .= "自提时间：".$res['delivery_time']."\n";
  $content .= "--------------------------------\n";
}
  $content .='名称'.str_repeat(" ",15)."数量  价格\n";
  $content .= "--------------------------------\n";
  $name='';
for($i=0;$i<count($res2);$i++){
  $name=$res2[$i]['name'];
  $content .= "".$name."\n";
  $content .=str_repeat(" ",20).$res2[$i]['number']."   ".number_format($res2[$i]['number']*$res2[$i]['money'],2)."\n";
}
$content .= "--------------------------------\n";
$content .= "餐盒费：　　　　　　　　".$res['box_fee']."\n";
$content .= "--------------------------------\n";
$content .= "配送费：　　　　　　　　".$res['freight']."\n";
$content .= "--------------------------------\n";
$content .= "优惠：　　　　　　　　 -".number_format($res['preferential'],2)."\n";
$content .= "--------------------------------\n";
$content .= "已付：　　　　　　　　　".$res['money']."\n";
$content .= "--------------------------------\n";
$content .= "送货地点：".$res['address']."\n\n";
$content .= "联系电话：".$res['tel']."\n\n";
$content .= "联系人：".$res['name']."\n\n";

if($res['note']){
  $content .= "备注：".$res['note']."\n\n\n\n\n\n";
}
}
if($res3['type']==1){//365打印

$selfMessage = array(
  'deviceNo'=>$res3['dyj_id'],  
  'printContent'=>$content,
  'key'=>$res3['dyj_key'],
  'times'=>'1'
  );        
$url = "http://open.printcenter.cn:8080/addOrder";
$options = array(
  'http' => array(
    'header' => "Content-type: application/x-www-form-urlencoded ",
    'method'  => 'POST',
    'content' => http_build_query($selfMessage),
    ),
  );
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

return $result;
}
if($res3['type']==2){//易联云
  include("print.class.php");
  $print = new Yprint();
  $apiKey = $res3['api'];
  $msign = $res3['token'];
  $partner=$res3['yy_id'];
  $machine_code=$res3['mid'];
//打印
  $print->action_print( $partner,$machine_code,$content,$apiKey,$msign);
}
if($res3['type']==3){//飞蛾
  $content .= "　　　　　订单编号  #".$res['id']." <BR>";
  $content .= "　　　　　".$is_take." \n";
  $content .= "          ".$res3['dyj_title']."<BR>";
  $content .= "-------------".$is_yue."-----------<BR>";
  $content .= "--------------------------------<BR>";
  $content .= "下单时间：".$res['time']."<BR>";
  $content .= "--------------------------------<BR>";
  if($res['is_take']==1){
  $content .= "自提时间：".$res['delivery_time']."<BR>";
  $content .= "--------------------------------<BR>";
}
  $content .="名称　　　　　 数量　  单价 <BR>";
  $content .= "-------------------------------<BR>";
  $name='';
for($i=0;$i<count($res2);$i++){
  $name=$res2[$i]['name'];
  $content .= "".$name."<BR>";
  $content .="　　　　　　 　　".$res2[$i]['number']." 　 ".number_format($res2[$i]['number']*$res2[$i]['money'],2)."<BR>";
}
$content .= "--------------------------------<BR>";
$content .= "餐盒费：　　　　　　　".$res['box_fee']."<BR>";
$content .= "--------------------------------<BR>";
$content .= "配送费：　　　　　　　".$res['freight']."<BR>";
$content .= "--------------------------------<BR>";
$content .= "优惠：　　　　　　　　-".number_format($res['preferential'],2)."<BR>";
$content .= "--------------------------------<BR>";
$content .= "已付：　　　　　　　  ".$res['money']."<BR>";
$content .= "--------------------------------<BR>";
$content .= "送货地点：".$res['address']."<BR><BR>";
$content .= "联系电话：".$res['tel']."<BR><BR>";
$content .= "联系人：".$res['name']."<BR><BR>";

if($res['note']){
  $content .= "备注：".$res['note']."<BR><BR><BR>";
}
 header("Content-type: text/html; charset=utf-8");
include 'HttpClient.class.php';
define('USER', $res3['fezh']); //*必填*：飞鹅云后台注册账号
define('UKEY', $res3['fe_ukey']); //*必填*: 飞鹅云注册账号后生成的UKEY
define('SN', $res3['fe_dycode']);    //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API
//以下参数不需要修改
define('IP','api.feieyun.cn');      //接口IP或域名
define('PORT',80);            //接口IP端口
define('PATH','/Api/Open/');    //接口路径
define('STIME', time());          //公共参数，请求时间
define('SIG', sha1(USER.UKEY.STIME));
function wp_print($printer_sn,$orderInfo,$times){
    $content = array(     
      'user'=>USER,
      'stime'=>STIME,
      'sig'=>SIG,
      'apiname'=>'Open_printMsg',

      'sn'=>$printer_sn,
      'content'=>$orderInfo,
        'times'=>$times//打印次数
    );
    
  $client = new HttpClient(IP,PORT);
  if(!$client->post(PATH,$content)){
    echo 'error';
  }
  else{
    //服务器返回的JSON字符串，建议要当做日志记录起来
    echo $client->getContent();
  }
  
}
wp_print(SN,$content,1);


}

}






//店内
 public function doPageDnPrint(){ // $times打印次数
  global $_W, $_GPC;
  $res=pdo_get('wpdc_order',array('id'=>$_GPC['order_id']));
  $res3=pdo_get('wpdc_dyj',array('uniacid'=>$_W['uniacid'],'store_id'=>$res['seller_id'],'state'=>1,'location'=>1));
  $res2=pdo_getall('wpdc_goods',array('order_id'=>$_GPC['order_id']));
  $table=pdo_get('wpdc_table',array('id'=>$res['table_id']));
if($res['is_yue']==1){
  $is_yue="余额支付";
}elseif($res['is_yue']==2){
  $is_yue="微信支付";
}elseif($res['is_yue']==3){
  $is_yue="积分支付";
}else{
  $is_yue="餐后支付";
}
if($res3['type']!=3){
 $content = "\n\n\n\n";
  if($res3['type']==1 and $res3['num']){
   $content = "^N".$res3['num']."\n";
 }
  $content .= "         订单编号  #".$res['id']." \n\n";
  $content .= "          ".$is_take." \n";
  $content .= "          ".$res3['dyj_title']."\n\n";
  $content .= "----------".$is_yue."------------\n";
  $content .= "--------------------------------\n";
  $content .= "下单时间：".$res['time']."\n";
  $content .= "--------------------------------\n";
  $content .='名称'.str_repeat(" ",15)."数量  价格\n";
  $content .= "--------------------------------\n";
  $name='';
for($i=0;$i<count($res2);$i++){
  $name=$res2[$i]['name'];
  $content .= "".$name."\n";
  $content .=str_repeat(" ",20).$res2[$i]['number']."   ".number_format($res2[$i]['number']*$res2[$i]['money'],2)."\n";
}
$content .= "--------------------------------\n";
$content .= "已优惠：　　　　　　　　   -".number_format($res['preferential'], 2)."\n";
$content .= "--------------------------------\n";
$content .= "合计：".$res['money']."元\n\n";
$content .= "桌号：".$table['name']."\n\n";
if($res['note']){
  $content .= "备注：".$res['note']."\n\n";
}
$content .= "支付方式：".$is_yue."\n\n\n\n\n";
}
// $content .= "^Q +https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzI1NTQ5NDQzMQ==&scene=124#wechat_redirect";
    //echo 1;die;
if($res3['type']==1){//365打印
  $selfMessage = array(
    'deviceNo'=>$res3['dyj_id'],  
    'printContent'=>$content,
    'key'=>$res3['dyj_key'],
    'times'=>'1'
    );        
  $url = "http://open.printcenter.cn:8080/addOrder";
  $options = array(
    'http' => array(
      'header' => "Content-type: application/x-www-form-urlencoded",
      'method'  => 'POST',
      'content' => http_build_query($selfMessage),
      ),
    );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);

  return $result;
}
if($res3['type']==2){//易联云
  include("print.class.php");
  $print = new Yprint();
  $apiKey = $res3['api'];
  $msign = $res3['token'];
  $partner=$res3['yy_id'];
  $machine_code=$res3['mid'];
//打印
  $print->action_print( $partner,$machine_code,$content,$apiKey,$msign);
}
if($res3['type']==3){//飞蛾
  $content .= "　　　　　订单编号  #".$res['id']." <BR>";
  $content .= "　　　　　".$is_take." \n";
  $content .= "          ".$res3['dyj_title']."<BR>";
  $content .= "-------------".$is_yue."-----------<BR>";
  $content .= "--------------------------------<BR>";
  $content .= "下单时间：".$res['time']."<BR>";
  $content .= "--------------------------------<BR>";
  if($res['is_take']==1){
  $content .= "自提时间：".$res['delivery_time']."<BR>";
  $content .= "--------------------------------<BR>";
}
  $content .="名称　　　　　 数量　  单价 <BR>";
  $content .= "-------------------------------<BR>";
  $name='';
for($i=0;$i<count($res2);$i++){
  $name=$res2[$i]['name'];
  $content .= "".$name."<BR>";
  $content .="　　　　　　 　　".$res2[$i]['number']." 　 ".number_format($res2[$i]['number']*$res2[$i]['money'],2)."<BR>";
}

$content .= "--------------------------------<BR>";
$content .= "已优惠：　　　　　　-".number_format($res['preferential'],2)."<BR>";
$content .= "合计：".$res['money']."元<BR>";
$content .= "桌号：".$table['name']."<BR>";
if($res['note']){
  $content .= "备注：".$res['note']."<BR>";
}
$content .= "支付方式：".$is_yue."<BR>";
 header("Content-type: text/html; charset=utf-8");
include 'HttpClient.class.php';
define('USER', $res3['fezh']); //*必填*：飞鹅云后台注册账号
define('UKEY', $res3['fe_ukey']); //*必填*: 飞鹅云注册账号后生成的UKEY
define('SN', $res3['fe_dycode']);    //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API
//以下参数不需要修改
define('IP','api.feieyun.cn');      //接口IP或域名
define('PORT',80);            //接口IP端口
define('PATH','/Api/Open/');    //接口路径
define('STIME', time());          //公共参数，请求时间
define('SIG', sha1(USER.UKEY.STIME));
function wp_print($printer_sn,$orderInfo,$times){
    $content = array(     
      'user'=>USER,
      'stime'=>STIME,
      'sig'=>SIG,
      'apiname'=>'Open_printMsg',

      'sn'=>$printer_sn,
      'content'=>$orderInfo,
        'times'=>$times//打印次数
    );
    
  $client = new HttpClient(IP,PORT);
  if(!$client->post(PATH,$content)){
    echo 'error';
  }
  else{
    //服务器返回的JSON字符串，建议要当做日志记录起来
    echo $client->getContent();
  }
  
}
wp_print(SN,$content,1);


}
}



 public function doPageDnPrint2(){ // $times打印次数
  global $_W, $_GPC;
  $res=pdo_get('wpdc_order',array('id'=>$_GPC['order_id']));
  $res3=pdo_get('wpdc_dyj',array('uniacid'=>$_W['uniacid'],'store_id'=>$res['seller_id'],'state'=>1,'location'=>2));
  $res2=pdo_getall('wpdc_goods',array('order_id'=>$_GPC['order_id']));
  $table=pdo_get('wpdc_table',array('id'=>$res['table_id']));
if($res['is_yue']==1){
  $is_yue="余额支付";
}elseif($res['is_yue']==2){
  $is_yue="微信支付";
}elseif($res['is_yue']==3){
  $is_yue="积分支付";
}else{
  $is_yue="餐后支付";
}
if($res3['type']!=3){
 $content = "\n\n\n\n";
  if($res3['type']==1 and $res3['num']){
   $content = "^N".$res3['num']."\n";
 }
  $content .= "         订单编号  #".$res['id']." \n\n";
  $content .= "          ".$is_take." \n";
  $content .= "          ".$res3['dyj_title']."\n\n";
  $content .= "----------".$is_yue."------------\n";
  $content .= "--------------------------------\n";
  $content .= "下单时间：".$res['time']."\n";
  $content .= "--------------------------------\n";
  $content .='名称'.str_repeat(" ",15)."数量  价格\n";
  $content .= "--------------------------------\n";
  $name='';
for($i=0;$i<count($res2);$i++){
  $name=$res2[$i]['name'];
  $content .= "".$name."\n";
  $content .=str_repeat(" ",20).$res2[$i]['number']."   ".number_format($res2[$i]['number']*$res2[$i]['money'],2)."\n";
}
$content .= "--------------------------------\n";
$content .= "已优惠：　　　　　　　　   -".number_format($res['preferential'], 2)."\n";
$content .= "--------------------------------\n";
$content .= "合计：".$res['money']."元\n\n";
$content .= "桌号：".$table['name']."\n\n";
if($res['note']){
  $content .= "备注：".$res['note']."\n\n";
}
$content .= "支付方式：".$is_yue."\n\n\n\n\n";
}
//echo $content;die;

// $content .= "^Q +https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzI1NTQ5NDQzMQ==&scene=124#wechat_redirect";
    //echo 1;die;
if($res3['type']==1){//365打印
  $selfMessage = array(
    'deviceNo'=>$res3['dyj_id'],  
    'printContent'=>$content,
    'key'=>$res3['dyj_key'],
    'times'=>'1'
    );        
  $url = "http://open.printcenter.cn:8080/addOrder";
  $options = array(
    'http' => array(
      'header' => "Content-type: application/x-www-form-urlencoded",
      'method'  => 'POST',
      'content' => http_build_query($selfMessage),
      ),
    );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);

  return $result;
}
if($res3['type']==2){//易联云
  include("print.class.php");
  $print = new Yprint();
  $apiKey = $res3['api'];
  $msign = $res3['token'];
  $partner=$res3['yy_id'];
  $machine_code=$res3['mid'];
//打印

  $print->action_print( $partner,$machine_code,$content,$apiKey,$msign);
}
if($res3['type']==3){//飞蛾
  $content .= "　　　　　订单编号  #".$res['id']." <BR>";
  $content .= "　　　　　".$is_take." \n";
  $content .= "          ".$res3['dyj_title']."<BR>";
  $content .= "-------------".$is_yue."-----------<BR>";
  $content .= "--------------------------------<BR>";
  $content .= "下单时间：".$res['time']."<BR>";
  $content .= "--------------------------------<BR>";
  if($res['is_take']==1){
  $content .= "自提时间：".$res['delivery_time']."<BR>";
  $content .= "--------------------------------<BR>";
}
  $content .="名称　　　　　 数量　  单价 <BR>";
  $content .= "-------------------------------<BR>";
  $name='';
for($i=0;$i<count($res2);$i++){
  $name=$res2[$i]['name'];
  $content .= "".$name."<BR>";
  $content .="　　　　　　 　　".$res2[$i]['number']." 　 ".number_format($res2[$i]['number']*$res2[$i]['money'],2)."<BR>";
}

$content .= "--------------------------------<BR>";
$content .= "已优惠：　　　　　　-".number_format($res['preferential'],2)."<BR>";
$content .= "合计：".$res['money']."元<BR>";
$content .= "桌号：".$table['name']."<BR>";
if($res['note']){
  $content .= "备注：".$res['note']."<BR>";
}
$content .= "支付方式：".$is_yue."<BR>";
 header("Content-type: text/html; charset=utf-8");
include 'HttpClient.class.php';
define('USER', $res3['fezh']); //*必填*：飞鹅云后台注册账号
define('UKEY', $res3['fe_ukey']); //*必填*: 飞鹅云注册账号后生成的UKEY
define('SN', $res3['fe_dycode']);    //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API
//以下参数不需要修改
define('IP','api.feieyun.cn');      //接口IP或域名
define('PORT',80);            //接口IP端口
define('PATH','/Api/Open/');    //接口路径
define('STIME', time());          //公共参数，请求时间
define('SIG', sha1(USER.UKEY.STIME));
function wp_print($printer_sn,$orderInfo,$times){
    $content = array(     
      'user'=>USER,
      'stime'=>STIME,
      'sig'=>SIG,
      'apiname'=>'Open_printMsg',

      'sn'=>$printer_sn,
      'content'=>$orderInfo,
        'times'=>$times//打印次数
    );
    
  $client = new HttpClient(IP,PORT);
  if(!$client->post(PATH,$content)){
    echo 'error';
  }
  else{
    //服务器返回的JSON字符串，建议要当做日志记录起来
    echo $client->getContent();
  }
  
}
wp_print(SN,$content,1);


}
}



//当面付
public function doPageDmPrint(){ // $times打印次数
  global $_W, $_GPC;
  $res=pdo_get('wpdc_dmorder',array('id'=>$_GPC['order_id']));
  $user=pdo_get('wpdc_user',array('id'=>$res['user_id']));
  $store=pdo_get('wpdc_store',array('id'=>$res['store_id']));
  $res3=pdo_get('wpdc_dyj',array('uniacid'=>$_W['uniacid'],'store_id'=>$res['store_id'],'state'=>1,'location'=>1));
  if($res3['type']!=3){
$content = "\n\n";
 if($res3['type']==1 and $res3['num']){
   $content = "^N".$res3['num']."\n";
 }
$content .= "              收银台\n\n\n";
  $content .= "--------------------------------\n";
$content .= "金额    ：".$res['money']."元\n";
  $content .= "--------------------------------\n";
$content .= "付款人  ：".$user['name']."\n";
  $content .= "--------------------------------\n";
$content .= "商家名称：".$store['name']."\n";
  $content .= "--------------------------------\n";
$content .= "付款时间：".$res['time']."\n";
  $content .= "--------------------------------\n";
if($res['is_yue']==1){
  $content .= "支付方式：余额支付\n\n\n\n\n";
}elseif($res['is_yue']==2){
  $content .= "支付方式：微信支付\n\n\n\n\n";
}elseif($res['is_yue']==3){
  $content .= "支付方式：积分支付\n\n\n\n\n";
}
}

if($res3['type']==1){//365打印
  
  $selfMessage = array(
    'deviceNo'=>$res3['dyj_id'],  
    'printContent'=>$content,
    'key'=>$res3['dyj_key'],
    'times'=>'1'
    );        
  $url = "http://open.printcenter.cn:8080/addOrder";
  $options = array(
    'http' => array(
      'header' => "Content-type: application/x-www-form-urlencoded",
      'method'  => 'POST',
      'content' => http_build_query($selfMessage),
      ),
    );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
  return $result;
}
if($res3['type']==2){//易联云

  include("print.class.php");
  $print = new Yprint();
  $apiKey = $res3['api'];
  $msign = $res3['token'];
  $partner=$res3['yy_id'];
  $machine_code=$res3['mid'];
//打印
  $print->action_print( $partner,$machine_code,$content,$apiKey,$msign);
}
if($res3['type']==3){//飞蛾
 $content .= "              收银台<BR>";
  $content .= "--------------------------------<BR>";
$content .= "金额    ：".$res['money']."元<BR>";
  $content .= "--------------------------------<BR>";
$content .= "付款人  ：".$user['name']."<BR>";
  $content .= "--------------------------------<BR>";
$content .= "商家名称：".$store['name']."<BR>";
  $content .= "--------------------------------<BR>";
$content .= "付款时间：".$res['time']."<BR>";
  $content .= "--------------------------------<BR>";
if($res['is_yue']==1){
  $content .= "支付方式：余额支付<BR>";
}elseif($res['is_yue']==2){
  $content .= "支付方式：微信支付<BR>";
}elseif($res['is_yue']==3){
  $content .= "支付方式：积分支付<BR>";
}
 header("Content-type: text/html; charset=utf-8");
include 'HttpClient.class.php';
define('USER', $res3['fezh']); //*必填*：飞鹅云后台注册账号
define('UKEY', $res3['fe_ukey']); //*必填*: 飞鹅云注册账号后生成的UKEY
define('SN', $res3['fe_dycode']);    //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API
//以下参数不需要修改
define('IP','api.feieyun.cn');      //接口IP或域名
define('PORT',80);            //接口IP端口
define('PATH','/Api/Open/');    //接口路径
define('STIME', time());          //公共参数，请求时间
define('SIG', sha1(USER.UKEY.STIME));
function wp_print($printer_sn,$orderInfo,$times){
    $content = array(     
      'user'=>USER,
      'stime'=>STIME,
      'sig'=>SIG,
      'apiname'=>'Open_printMsg',

      'sn'=>$printer_sn,
      'content'=>$orderInfo,
        'times'=>$times//打印次数
    );
    
  $client = new HttpClient(IP,PORT);
  if(!$client->post(PATH,$content)){
    echo 'error';
  }
  else{
    //服务器返回的JSON字符串，建议要当做日志记录起来
    echo $client->getContent();
  }
  
}
wp_print(SN,$content,1);


}
}



//当面付
public function doPageDmPrint2(){ // $times打印次数
  global $_W, $_GPC;
    $res=pdo_get('wpdc_dmorder',array('id'=>$_GPC['order_id']));
  $user=pdo_get('wpdc_user',array('id'=>$res['user_id']));
  $store=pdo_get('wpdc_store',array('id'=>$res['store_id']));
  $res3=pdo_get('wpdc_dyj',array('uniacid'=>$_W['uniacid'],'store_id'=>$res['store_id'],'state'=>1,'location'=>2));

if($res3['type']!=3){
$content = "\n\n";
 if($res3['type']==1 and $res3['num']){
   $content = "^N".$res3['num']."\n";
 }
$content .= "              收银台\n\n\n";
  $content .= "--------------------------------\n";
$content .= "金额    ：".$res['money']."元\n";
  $content .= "--------------------------------\n";
$content .= "付款人  ：".$user['name']."\n";
  $content .= "--------------------------------\n";
$content .= "商家名称：".$store['name']."\n";
  $content .= "--------------------------------\n";
$content .= "付款时间：".$res['time']."\n";
  $content .= "--------------------------------\n";
if($res['is_yue']==1){
  $content .= "支付方式：余额支付\n\n\n\n\n";
}elseif($res['is_yue']==2){
  $content .= "支付方式：微信支付\n\n\n\n\n";
}elseif($res['is_yue']==3){
  $content .= "支付方式：积分支付\n\n\n\n\n";
}
 }
// $content .= "^Q +https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzI1NTQ5NDQzMQ==&scene=124#wechat_redirect";
    //echo 1;die;
if($res3['type']==1){//365打印
  $selfMessage = array(
    'deviceNo'=>$res3['dyj_id'],  
    'printContent'=>$content,
    'key'=>$res3['dyj_key'],
    'times'=>'1'
    );        
  $url = "http://open.printcenter.cn:8080/addOrder";
  $options = array(
    'http' => array(
      'header' => "Content-type: application/x-www-form-urlencoded",
      'method'  => 'POST',
      'content' => http_build_query($selfMessage),
      ),
    );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);

  return $result;
}
if($res3['type']==2){//易联云
  include("print.class.php");
  $print = new Yprint();
  $apiKey = $res3['api'];
  $msign = $res3['token'];
  $partner=$res3['yy_id'];
  $machine_code=$res3['mid'];
//打印
  $print->action_print( $partner,$machine_code,$content,$apiKey,$msign);
}
if($res3['type']==3){//飞蛾
 $content .= "              收银台<BR>";
  $content .= "--------------------------------<BR>";
$content .= "金额    ：".$res['money']."元<BR>";
  $content .= "--------------------------------<BR>";
$content .= "付款人  ：".$user['name']."<BR>";
  $content .= "--------------------------------<BR>";
$content .= "商家名称：".$store['name']."<BR>";
  $content .= "--------------------------------<BR>";
$content .= "付款时间：".$res['time']."<BR>";
  $content .= "--------------------------------<BR>";
if($res['is_yue']==1){
  $content .= "支付方式：余额支付<BR>";
}elseif($res['is_yue']==2){
  $content .= "支付方式：微信支付<BR>";
}elseif($res['is_yue']==3){
  $content .= "支付方式：积分支付<BR>";
}
 header("Content-type: text/html; charset=utf-8");
include 'HttpClient.class.php';
define('USER', $res3['fezh']); //*必填*：飞鹅云后台注册账号
define('UKEY', $res3['fe_ukey']); //*必填*: 飞鹅云注册账号后生成的UKEY
define('SN', $res3['fe_dycode']);    //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API
//以下参数不需要修改
define('IP','api.feieyun.cn');      //接口IP或域名
define('PORT',80);            //接口IP端口
define('PATH','/Api/Open/');    //接口路径
define('STIME', time());          //公共参数，请求时间
define('SIG', sha1(USER.UKEY.STIME));
function wp_print($printer_sn,$orderInfo,$times){
    $content = array(     
      'user'=>USER,
      'stime'=>STIME,
      'sig'=>SIG,
      'apiname'=>'Open_printMsg',

      'sn'=>$printer_sn,
      'content'=>$orderInfo,
        'times'=>$times//打印次数
    );
    
  $client = new HttpClient(IP,PORT);
  if(!$client->post(PATH,$content)){
    echo 'error';
  }
  else{
    //服务器返回的JSON字符串，建议要当做日志记录起来
    echo $client->getContent();
  }
  
}
wp_print(SN,$content,1);


}
}





public function doPageWxapp(){
  global $_W, $_GPC;
  function getaccess_token($_W){
   $res=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
             // $appid=$res['appid'];
             // $secret=$res['appsecret'];
   $appid="wxa78792229b3293cc";
   $secret="fce19e77d6fb1fda0785003398d4ab57";
   $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL,$url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
   $data = curl_exec($ch);
   curl_close($ch);
   $data = json_decode($data,true);
   return $data['access_token'];
 }

 function set_msg($_W){
   $access_token =getaccess_token($_W);
   $cardid ='pH-cKwjHcGt1dsn9lxBTmNpVMvsU';

                // $post = '{
                //                 "card_id":"' . $cardid . '",
                //                 "general_coupon": {
                //                         "base_info": {
                //                                 "custom_url_name": "小程序",
                //                                 "custom_url": "http://www.qq.com",
                //                                 "custom_app_brand_user_name": "gh_8394dc4da2d8@app",
                //                                 "custom_app_brand_pass":"sudu8_page/index/index",
                //                                 "custom_url_sub_title": "点击进入",
                //                                 "promotion_url_name": "更多信息",
                //                                 "promotion_url": "http://www.qq.com",
                //                                 "promotion_app_brand_user_name": "gh_8394dc4da2d8@app",
                //                                 "promotion_app_brand_pass":"sudu8_page/index/index"
                //                         }
                //                 }
                // }';
                //  $post = '{
                //   "offset": 0,
                //   "count": 10, 
                //   "status_list": ["CARD_STATUS_VERIFY_OK", "CARD_STATUS_DISPATCH"]
                // }';
   $post = '{
    "card_id":"pH-cKwjHcGt1dsn9lxBTmNpVMvsU"
  }';

             // https://api.weixin.qq.com/card/batchget?access_token=TOKEN
 //$url = "https://api.weixin.qq.com/card/update?access_token=".$access_token."";//更新卡券
 //$url = "https://api.weixin.qq.com/card/batchget?access_token=".$access_token."";//查看卡券列表
 $url = "https://api.weixin.qq.com/card/get?access_token=".$access_token."";//查看卡券详情

 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL,$url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
 curl_setopt($ch, CURLOPT_POST,1);
 curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
 $data = curl_exec($ch);
 curl_close($ch);
 return $data;
}
echo set_msg($_W);

}




//商家分类
public function doPageStoreType(){
  global $_W, $_GPC;
  $res=pdo_getall('wpdc_storetype',array('uniacid'=>$_W['uniacid']),array(),'','num asc');
  echo json_encode($res);
}
//商家列表
public function doPageStoreList(){
  global $_W, $_GPC;
  // $lat='30.532568';
  //   $lng='114.360314';
    $lat=$_GPC['lat'];
   $lng=$_GPC['lng'];
  $where=" WHERE uniacid=:uniacid and is_open=1";
  if($_GPC['type_id']){
    $where .=" and md_type = :md_type";
    $data[':md_type']=$_GPC['type_id'];      
  }
  $data[':uniacid']=$_W['uniacid'];
  $pageindex = max(1, intval($_GPC['page']));
  $pagesize=$_GPC['pagesize'];
 // $sql="select *  from " . tablename("wpdc_store") . "".$where." order by number asc";
  $sql="SELECT *, ROUND(6378.138*2*ASIN(SQRT(POW(SIN(($lat*PI()/180-SUBSTRING_INDEX(coordinates, ',', 1)*PI()/180)/2),2)+COS($lat*PI()/180)*COS(SUBSTRING_INDEX(coordinates, ',', 1)*PI()/180)*POW(SIN(($lng*PI()/180-SUBSTRING_INDEX(coordinates, ',', -1)*PI()/180)/2),2)))*1000) AS juli  
FROM ".tablename("wpdc_store").$where ." ORDER BY juli ASC";
  $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
  $list = pdo_fetchall($select_sql,$data);
  echo json_encode($list);
}
//搜索商家
public function doPageSearchStore(){
  global $_W, $_GPC;
  $op=$_GPC['key'];
  $where="%$op%";
  $sql="select *  from " . tablename("wpdc_store") ." WHERE  name LIKE :name || address LIKE :address and uniacid=:uniacid and is_open=1";
  $list=pdo_fetchall($sql,array(':name'=>$where,':address'=>$where,'uniacid'=>$_W['uniacid']));
  echo json_encode($list);
}
//根据评分排序
public function doPageStoreListPf(){
  global $_W, $_GPC;
  if($_GPC['type_id']){
    $res=pdo_getall('wpdc_store',array('uniacid'=>$_W['uniacid'],'md_type'=>$_GPC['type_id'],'is_open'=>1),array(),'','score DESC');
    echo json_encode($res);   
  }else{
    $res=pdo_getall('wpdc_store',array('uniacid'=>$_W['uniacid'],'is_open'=>1),array(),'','score DESC');
    echo json_encode($res);
  }
}
//根据销量排序
public function doPageStoreListXl(){
  global $_W, $_GPC;
  if($_GPC['type_id']){
    $res=pdo_getall('wpdc_store',array('uniacid'=>$_W['uniacid'],'md_type'=>$_GPC['type_id'],'is_open'=>1),array(),'','sales DESC');
    echo json_encode($res);
  }else{
    $res=pdo_getall('wpdc_store',array('uniacid'=>$_W['uniacid'],'is_open'=>1),array(),'','sales DESC');
    echo json_encode($res);  
  }

}
//根据距离排序
public function doPageStoreListJl(){
 global $_W, $_GPC;
 echo asort($_GPC['sz']);
}

//商家满减
public function doPageReduction(){
  global $_W, $_GPC;
  $res=pdo_getall('wpdc_reduction',array('store_id'=>$_GPC['id']),array(),'','full DESC');
  echo json_encode($res);
}

//退款
public function doPageTuik(){
 global $_W, $_GPC;
 $res=pdo_update('wpdc_order',array('state'=>7),array('id'=>$_GPC['order_id']));
 if($res){
  echo '1';
}else{
  echo '2';
}
}


//邮件
public function doPageEmail(){
  global $_W, $_GPC;

  $row = pdo_get("uni_settings", array('notify !=' => ''), array('notify'));
  $row['notify'] = @iunserializer($row['notify']);
  if (!empty($row['notify']) && !empty($row['notify']['mail'])) {
    $config = $row['notify']['mail'];
  }
  function ihttp_email2($to, $subject, $body, $global = false) {
    global $_W, $_GPC;
    $system=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
    static $mailer;
    set_time_limit(0);
    if (empty($mailer)) {
      if (!class_exists('PHPMailer')) {
        load()->library('phpmailer');
      }
      $mailer = new PHPMailer();
      global $_W;
      $config = $GLOBALS['_W']['setting']['mail'];
      $config=array( 
        'username' =>$system['username'],
        'password' => $system['password'],
        'smtp' =>array( 
          'type' => $system['type'],
          'server' => '',
          'port' => '',
          'authmode' => 0
          ) ,
        'sender' => $system['sender'],
        'signature' =>$system['signature']
        );
      $config['charset'] = 'utf-8';
      if ($config['smtp']['type'] == '163') {
        $config['smtp']['server'] = 'smtp.163.com';
        $config['smtp']['port'] = 25;
      } elseif ($config['smtp']['type'] == 'qq') {
        $config['smtp']['server'] = 'ssl://smtp.qq.com';
        $config['smtp']['port'] = 465;
      } else {
        if (!empty($config['smtp']['authmode'])) {
          $config['smtp']['server'] = 'ssl://' . $config['smtp']['server'];
        }
      }
      if (!empty($config['smtp']['authmode'])) {
        if (!extension_loaded('openssl')) {
          return error(1, '请开启 php_openssl 扩展！');
        }
      }
      $mailer->signature = $config['signature'];
      $mailer->isSMTP();
      $mailer->CharSet = $config['charset'];
      $mailer->Host = $config['smtp']['server'];
      $mailer->Port = $config['smtp']['port'];
      $mailer->SMTPAuth = true;
      $mailer->Username = $config['username'];
      $mailer->Password = $config['password'];
      !empty($config['smtp']['authmode']) && $mailer->SMTPSecure = 'ssl';
      $mailer->From = $config['username'];
      $mailer->FromName = $config['sender'];
      $mailer->isHTML(true);
    }
    if ($body) {
      if (is_array($body)) {
        $body = '';
        foreach($body as $value) {
          if (substr($value, 0, 1) == '@') {
            if(!is_file($file = ltrim($value, '@'))){
              return error(1, $file . ' 附件不存在或非文件！');
            }
            $mailer->addAttachment($file);  
          } else {
            $body .= $value . '\n';
          }
        }
      } else {
        if (substr($body, 0, 1) == '@') {
          $mailer->addAttachment(ltrim($body, '@'));  
          $body = '';
        }
      }
    }
    if (!empty($mailer->signature)) {
      $body .= htmlspecialchars_decode($mailer->signature);
    }
    $mailer->Subject = $subject;
    $mailer->Body = $body;
    $mailer->addAddress($to);
    if ($mailer->send()) {
      return true;
    } else {
      return error(1, $mailer->ErrorInfo);

    }
  }
  $store_id=$_GPC['store_id'];
  $store=pdo_get('wpdc_sms',array('store_id'=>$store_id));
  $body="您有新的".$_GPC['type']."订单,请去后台处理!<br><br>";
  $result = ihttp_email2($store['email'],'订单通知', $body);
  print_r($result);
}

public function doPageDmOrder(){
    global $_W, $_GPC;
    $data['money']=$_GPC['money'];
    $data['user_id']=$_GPC['user_id'];
    $data['store_id']=$_GPC['store_id'];
    $data['uniacid']=$_W['uniacid'];
    $data['time']=date('Y-m-d H:i:s');
    $data['time2']=time();
    $data['is_yue']=$_GPC['is_yue'];
    $data['form_id']=$_GPC['form_id'];
    $data['state']=1;
    $res=pdo_insert('wpdc_dmorder',$data);
    $order_id=pdo_insertid();
    if($res){
      echo $order_id;
    }else{
      echo '下单失败';
    }
}

public function doPageDmpay(){
  global $_W, $_GPC;
  $system=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
  $order_id=$_GPC['order_id'];
  $order=pdo_get('wpdc_dmorder',array('id'=>$order_id));
  $res=pdo_update('wpdc_dmorder',array('state'=>2),array('id'=>$order_id));
  if($res){
      if($order['is_yue']==1){
           pdo_update('wpdc_user',array('wallet -='=>$order['money']),array('id'=>$order['user_id']));
           $data4['money']=$order['money'];
           $data4['user_id']=$order['user_id'];
           $data4['type']=2;
           $data4['note']='当面付订单';
           $data4['time']=date('Y-m-d H:i:s');
           pdo_insert('wpdc_qbmx',$data4);
         }elseif($order['is_yue']==3){
          pdo_update('wpdc_user',array('total_score -='=>$_GPC['jf']),array('id'=>$order['user_id']));
            $jf['score']=$_GPC['jf'];
            $jf['user_id']=$_GPC['user_id'];
            $jf['type']=2;
            $jf['note']='当面付订单';
            $jf['order_id']=$order_id;
            $jf['cerated_time']=date('Y-m-d H:i:s');
            pdo_insert('wpdc_integral',$jf);
         }

/////////////////分销/////////////////

        $set=pdo_get('wpdc_fxset',array('uniacid'=>$_W['uniacid']));
        $store=pdo_get('wpdc_store',array('id'=>$order['store_id']));
        $type=pdo_get('wpdc_storetype',array('id'=>$store['md_type']));
        if($set['is_open']==1){//开启分销
          if($set['is_type']==1){//开启分类分销
              if($set['is_ej']==2){//不开启二级分销
               $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
               if($user){
                    $userid=$user['user_id'];//上线id
                    $money=$order['money']*($type['commission']/100);//一级佣金
                    pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
                    $data6['user_id']=$userid;//上线id
                    $data6['son_id']=$order['user_id'];//下线id
                    $data6['money']=$money;//金额
                    $data6['time']=time();//时间
                    $data6['uniacid']=$_W['uniacid'];
                    pdo_insert('wpdc_earnings',$data6);
                  }
      }else{//开启二级
          $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
          $user2=pdo_get('wpdc_fxuser',array('fx_user'=>$user['user_id']));//上线的上线
          if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($type['commission']/100);//一级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data6);
          }
          if($user2){
            $userid2=$user2['user_id'];//上线的上线id
            $money=$order['money']*($type['commission2']/100);//二级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid2));
            $data7['user_id']=$userid2;//上线id
            $data7['son_id']=$order['user_id'];//下线id
            $data7['money']=$money;//金额
            $data7['time']=time();//时间
            $data7['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data7);
          }
        }
          }else{
            if($set['is_ej']==2){//不开启二级分销
           $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
           if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($set['commission']/100);//一级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data6);
          }
      }else{//开启二级
       $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
          $user2=pdo_get('wpdc_fxuser',array('fx_user'=>$user['user_id']));//上线的上线
          if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($set['commission']/100);//一级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data6);
          }
          if($user2){
            $userid2=$user2['user_id'];//上线的上线id
            $money=$order['money']*($set['commission2']/100);//二级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid2));
            $data7['user_id']=$userid2;//上线id
            $data7['son_id']=$order['user_id'];//下线id
            $data7['money']=$money;//金额
            $data7['time']=time();//时间
            $data7['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data7);
          }
        }
          }
        }
      
/////////////////分销/////////////////







////////////////积分///////////////////////
        if($order['is_yue']!=3){
           if($store['is_dmjf']==1 and $system['is_jf']==1){
          if($store['integral2']){
            $jifen=round(($store['integral2']/100)*$order['money']);
            pdo_update('wpdc_user',array('total_score +='=>$jifen),array('id'=>$order['user_id']));
            $data5['score']=$jifen;
            $data5['user_id']=$order['user_id'];
            $data5['note']='当面付消费';
            $data5['type']=1;
            $data5['cerated_time']=date('Y-m-d H:i:s');
            $data5['uniacid']=$_W['uniacid'];//小程序id
            pdo_insert('wpdc_integral',$data5); 
      }elseif($system['integral2']){
        $jifen=round(($system['integral2']/100)*$order['money']);
            pdo_update('wpdc_user',array('total_score +='=>$jifen),array('id'=>$order['user_id']));
            $data5['score']=$jifen;
            $data5['user_id']=$order['user_id'];
            $data5['note']='当面付消费';
            $data5['type']=1;
            $data5['cerated_time']=date('Y-m-d H:i:s');
            $data5['uniacid']=$_W['uniacid'];//小程序id
            pdo_insert('wpdc_integral',$data5); 
      }
  }
  }
       
////////////////积分///////////////////////

    echo $order_id;
  }else{
    echo '下单失败';
  }
}


//手机端订单
public function doPageStoreOrder(){
  global $_W, $_GPC;
  $store_id=$_GPC['store_id'];
    $pageindex = max(1, intval($_GPC['page']));
  $pagesize=10;
  $time=$_GPC['time'];
  $time="'%$time%'";
   $sql="SELECT * FROM ".tablename('wpdc_order'). "  WHERE  seller_id=".$_GPC['store_id']." and time LIKE ".$time." and type=1 and del=2 ORDER BY id DESC";
  $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
  $res = pdo_fetchall($select_sql);
  $res2=pdo_getall('wpdc_goods');
  $data2=array();
  for($i=0;$i<count($res);$i++){
    $data=array();
    for($k=0;$k<count($res2);$k++){
      if($res[$i]['id']==$res2[$k]['order_id']){
        $data[]=array(
          'name'=>$res2[$k]['name'],
          'num'=>$res2[$k]['number'],
          'img'=>$res2[$k]['img'],
          'money'=>$res2[$k]['money'],
          'dishes_id'=>$res2[$k]['dishes_id']
          );
      }
    }
    $data2[]=array(
      'order'=> $res[$i],
      'goods'=>$data
      );
  }
  echo json_encode($data2);
}

//今天的外卖销售额
public function doPageWmSale(){
  global $_W, $_GPC;
  $time=date("Y-m-d");
  $time="'%$time%'";
  $storeid=$_GPC['store_id'];
$wm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid." and state not in (5,1,8) and type=1 and pay_time !=''";
$wm = pdo_fetch($wm);//今天的外卖销售额
$dn = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid." and dn_state not in (3,1) and type=2 and pay_time !=''";
$dn = pdo_fetch($dn);//今天的店内销售额
$yd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE created_time LIKE ".$time." and store_id=".$storeid." and state not in (0,6)";
$yd = pdo_fetch($yd);//今天的预定销售额
$dmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time." and state=2 and  store_id=".$storeid;
$dmf = pdo_fetch($dmf);//今天的当面付销售额
$total = $wm['total']+$dn['total']+$yd['total']+$dmf['total'];//今天的销售额
echo $total;
}
//昨天的外卖销售额
public function doPageWmSale2(){
  global $_W, $_GPC;
  $time=date("Y-m-d",time()-24*60*60);
  $time="'%$time%'";
  $storeid=$_GPC['store_id'];
  $ztwm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid." and state not in (5,1,8) and type=1 and pay_time !=''";
  $ztwm = pdo_fetch($ztwm);//昨天的外卖销售额
  $ztdn = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid." and dn_state not in (3,1) and type=2 and pay_time !=''";
  $ztdn = pdo_fetch($ztdn);//昨天的店内销售额
  $ztyd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE created_time LIKE ".$time." and store_id=".$storeid." and state not in (0,6)";
  $ztyd = pdo_fetch($ztyd);//昨天的预定销售额
  $ztdmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time." and state=2 and store_id=".$storeid;
  $ztdmf = pdo_fetch($ztdmf);//昨天的当面付销售额
  $total = $ztwm['total']+$ztdn['total']+$ztyd['total']+$ztdmf['total'];//昨天的销售额
  echo $total;
}
//总外卖销售额
public function doPageWmSale3(){
  global $_W, $_GPC;
  $storeid=$_GPC['store_id'];
  $wm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE   seller_id=".$storeid." and state not in (5,1,8) and type=1 and pay_time !=''";
  $wm = pdo_fetch($wm);//总的外卖销售额
  $dn = "select sum(money) as total from " . tablename("wpdc_order")." WHERE  seller_id=".$storeid." and dn_state not in (3,1) and type=2 and pay_time !=''";
  $dn = pdo_fetch($dn);//总的店内销售额
  $yd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE   store_id=".$storeid." and state not in (0,6)";
  $yd = pdo_fetch($yd);//总的预定销售额
  $dmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE  state=2 and  store_id=".$storeid;
  $dmf = pdo_fetch($dmf);//总的当面付销售额
  $total = $wm['total']+$dn['total']+$yd['total']+$dmf['total'];//总的销售额
  echo $total;
}
//商家可提现金额
  public function doPageStoreKtx(){
    global $_W, $_GPC;
    $storeid=$_GPC['store_id'];
    $system=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
    $store=pdo_get('wpdc_store',array('id'=>$storeid));
    if($store['poundage']){
      $poundage=$store['poundage'];
    }else{
      $storetype=pdo_get('wpdc_storetype',array('id'=>$store['md_type']));
      $poundage=$storetype['poundage'];
    }
    $sql = "select sum(money) as total from " . tablename("wpdc_order")." WHERE  seller_id=".$storeid." and state  in (4,6,9) and type=1 and pay_time !=''";
    $total = pdo_fetch($sql);//可提现金额外卖
    $sql3 = "select sum(money) as total from " . tablename("wpdc_order")." WHERE  seller_id=".$storeid." and dn_state  in (2,4) and type=2 and pay_time !=''";
    $total3 = pdo_fetch($sql3);//可提现金额店内
    $sql4 = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE  store_id=".$storeid." and state  in (7,2)";
    $total4 = pdo_fetch($sql4);//可提现金额预定
    $sql5 = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE state=2 and store_id=".$storeid;
    $total5 = pdo_fetch($sql5);//可提现金额预定

    $total6=$total['total']+$total3['total']+$total4['total']+$total5['total'];
$total6=number_format($total6-($total6*($poundage/100)),2, ".", "");
    $sql2 = "select sum(sj_cost) as total from " . tablename("wpdc_withdrawal")." WHERE  store_id=".$storeid." and state in (1,2)";
    $total2 = pdo_fetch($sql2);//已提现金额
    $ktxcost=$total6-$total2['total'];
  //  $ktxcost=number_format($ktxcost-($ktxcost*($poundage/100)),2,".", "");
    echo $ktxcost;
  }
//今天的外卖订单
public function doPageWmOrder(){
  global $_W, $_GPC;
  $time=date("Y-m-d");
  $time="'%$time%'";
  $storeid=$_GPC['store_id'];
  $wm = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid."  and state!=1";
  $wm = pdo_fetchall($wm);
  $yd = "select * from " . tablename("wpdc_ydorder")." WHERE created_time LIKE ".$time." and store_id=".$storeid."  and state!=0";
  $yd = pdo_fetchall($yd);
  $dm = "select * from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time." and store_id=".$storeid."  and state!=1";
  $dm = pdo_fetchall($dm);
  echo (count($wm)+count($yd)+count($dm));
}
  //今天的外卖订单
public function doPageWmOrder2(){
  global $_W, $_GPC;
  $time=date("Y-m-d");
  $time="'%$time%'";
  $storeid=$_GPC['store_id'];
  $wm = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid."  and type=1 and state in (6,4)";
  $wm = pdo_fetchall($wm);
   $dn = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid."  and type=2 and dn_state in (2,4)";
  $dn = pdo_fetchall($dn);
   $yd = "select * from " . tablename("wpdc_ydorder")." WHERE created_time LIKE ".$time." and store_id=".$storeid."  and state=2";
  $yd = pdo_fetchall($yd);
   $dm = "select * from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time." and store_id=".$storeid."  and state=2";
  $dm = pdo_fetchall($dm);
  echo (count($wm)+count($dn)+count($yd)+count($dm));
}
  //接单
public function doPageJieOrder(){
 global $_W, $_GPC;
 $data2['state']=3;
 $res=pdo_update('wpdc_order',$data2,array('id'=>$_GPC['order_id']));
 if($res){
  echo '1';
}else{
  echo '2';
}
}
  //通过退款
public function doPageTg(){
 global $_W, $_GPC;
 $id=$_GPC['order_id'];
 include_once IA_ROOT . '/addons/zh_dianc/cert/WxPay.Api.php';
 load()->model('account');
 load()->func('communication');
 $WxPayApi = new WxPayApi();
 $input = new WxPayRefund();
       //$path_cert = IA_ROOT . '/addons/zh_dianc/cert/apiclient_cert.pem';
       // $path_key = IA_ROOT . '/addons/zh_dianc/cert/apiclient_key.pem';
 $path_cert = IA_ROOT . "/addons/zh_dianc/cert/".'apiclient_cert_' . $_W['uniacid'] . '.pem';
 $path_key = IA_ROOT . "/addons/zh_dianc/cert/".'apiclient_key_' . $_W['uniacid'] . '.pem';
 $account_info = $_W['account'];
 $refund_order =pdo_get('wpdc_order',array('id'=>$id));  
 $res=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
 $appid=$res['appid'];
 $key=$res['wxkey'];
 $mchid=$res['mchid']; 
        $out_trade_no=$refund_order['sh_ordernum'];//商户订单号
        $fee = $refund_order['money'] * 100;
            //$refundid = $refund_order['transid'];
            //$refundid='4200000022201710178579320894';
        $input->SetAppid($appid);
        $input->SetMch_id($mchid);
        $input->SetOp_user_id($mchid);
        $input->SetRefund_fee($fee);
        $input->SetTotal_fee($fee);
           // $input->SetTransaction_id($refundid);
        $input->SetOut_refund_no($id);

        $input->SetOut_trade_no($out_trade_no);

        $result = $WxPayApi->refund($input, 6, $path_cert, $path_key, $key);

          // var_dump($result);die;
    if ($result['result_code'] == 'SUCCESS') {//退款成功
     pdo_update('wpdc_order',array('state'=>8),array('id'=>$id));
     echo  '1';
   }else{
     echo  '2';
   }
 }
//拒绝退款
 public function doPageJj(){
  global $_W, $_GPC;
  $id=$_GPC['order_id'];
  $res=pdo_update('wpdc_order',array('state'=>9),array('id'=>$_GPC['id']));
  if($res){
    echo '1';
  }else{
   echo '2';
 }
}

//删除订单
public function doPageDel(){
  global $_W, $_GPC;
  $res=pdo_update('wpdc_order',array('del'=>1),array('id'=>$_GPC['order_id']));
  if($res){
    echo '1';
  }else{
    echo '2';
  }
}
//关店
public function doPageClose(){
  global $_W, $_GPC;
  $res=pdo_update('wpdc_store',array('is_rest'=>1),array('id'=>$_GPC['store_id']));
  if($res){
    echo '1';
  }else{
    echo '2';
  }     
}
//开店
public function doPageOpen(){
  global $_W, $_GPC;
  $res=pdo_update('wpdc_store',array('is_rest'=>2),array('id'=>$_GPC['store_id']));
  if($res){
    echo '1';
  }else{
    echo '2';
  }     
}

//新订单提醒
public function doPageNewOrder(){
  global $_W, $_GPC;
      global $_W,$_GPC;
        $time=time();
        $time2=$time-10;
        $seller_id=$_GPC['store_id'];
        $res=pdo_get('wpdc_order',array('state'=>2,'seller_id'=>$seller_id));//外卖
        $res2=pdo_get('wpdc_order',array('time2 >='=>$time2,'type'=>2,'seller_id'=>$seller_id));//店内
        $res3=pdo_get('wpdc_ydorder',array('state'=>1,'store_id'=>$seller_id));//预定
        if($res){
            echo 1;
        }elseif($res2){
            echo 2;
        }elseif($res3){
             echo 3;
        }else{
            echo '暂无新订单!';
        }
    }
  //访问量
    public function doPageTraffic(){
      global $_W, $_GPC;
      $res=pdo_getall('wpdc_traffic',array('time'=>date("Y-m-d"),'store_id'=>$_GPC['store_id']));
      echo count($res);
    }

//商家二维码
    public function doPageStoreCode(){
      global $_W, $_GPC;
      function  getCoade($storeid){
        function getaccess_token(){
          global $_W, $_GPC;
          $res=pdo_get('wpdc_system',array('uniacid' => $_W['uniacid']));
          $appid=$res['appid'];
          $secret=$res['appsecret'];
              // print_r($res);die;
          $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL,$url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
          $data = curl_exec($ch);
          curl_close($ch);
          $data = json_decode($data,true);
          return $data['access_token'];
        }
        function set_msg($storeid){
         $access_token = getaccess_token();
         $data2=array(
          "scene"=>$storeid,
          "page"=>"zh_dianc/pages/info/info",
          "width"=>400
          );
         $data2 = json_encode($data2);
         $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$access_token."";
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL,$url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
         curl_setopt($ch, CURLOPT_POST,1);
         curl_setopt($ch, CURLOPT_POSTFIELDS,$data2);
         $data = curl_exec($ch);
         curl_close($ch);
         return $data;
       }
       $img=set_msg($storeid);
       $img=base64_encode($img);
       return $img;
     }

     $base64_image_content="data:image/jpeg;base64,".getCoade($_GPC['store_id']);
     if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
      $type = $result[2];
      $new_file = IA_ROOT ."/addons/zh_dianc/img/";
      if(!file_exists($new_file))
      {
    //检查是否有该文件夹，如果没有就创建，并给予最高权限
        mkdir($new_file, 0777);
      }
      $wname="{$_GPC['store_id']}".".{$type}";
    //$wname="1511.jpeg";
      $new_file = $new_file.$wname;
      file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)));

    }
    echo "/addons/zh_dianc/img/".$wname;

//     $size = 60;
// //字体类型，本例为黑体
//     $font = IA_ROOT . '/addons/zh_dianc/img/simhei.ttf';
//     $res=pdo_get('wpdc_store',array('id'=>$_GPC['store_id']));
//     if($res['hb_img']){
//       $img =$_W['attachurl'].$res['hb_img'];
//     }else{
//       $img = IA_ROOT ."/addons/zh_dianc/tu.jpg";
//     }
    
//     $pathname=IA_ROOT ."/addons/zh_dianc/img/{$_GPC['store_id']}.jpg";
// //显示的文字
//     $store=pdo_get('wpdc_store',array('id'=>$_GPC['store_id']));
//     $text =$store['name'];
//     $len = mb_strlen($text,"UTF-8");
//     $left_x = (640-$len*15)/2;

// //$text1 = "志汇科技";
// //创建一个长为500高为80的空白图片
// // $img = imagecreate(500, 80);
// $img = imagecreatefromjpeg($img);// 加载已有图像
// //给图片分配颜色
// // imagecolorallocate($img, 0xff, 0xcc, 0xcc);
// //设置字体颜色
// $black = imagecolorallocate($img, 255, 255, 255);
// //将ttf文字写到图片中
// imagettftext($img, $size, 0,$left_x,1380, $black, $font, $text);
// //imagettftext($img, $size, 0,180,216, $black, $font, $text1);
// //发送头信息
// header('Content-Type: image/png');
// //输出图片
// // ImagePNG($img);
// //保存图片至指定路径
// ImagePNG($img, $pathname);
// imagedestroy($img);





// $bg_image=$pathname;
// $sub_image=$new_file;
// $add_x=240;
// $add_y=459;
// $add_w=600;
// $add_h=600;
// $out_image=IA_ROOT ."/addons/zh_dianc/img2/{$_GPC['store_id']}.jpg";

// if($sub_image){
//   $bg_image_c = imagecreatefromstring(file_get_contents($bg_image));
//   $sub_image_c = imagecreatefromstring(file_get_contents($sub_image));

//   imagecopyresampled($bg_image_c, $sub_image_c, $add_x, $add_y, 0, 0, $add_w, $add_h, imagesx($sub_image_c), imagesy($sub_image_c));

//   imagejpeg($bg_image_c, $out_image, 100);
//   imagedestroy($sub_image_c);
//   imagedestroy($bg_image_c);
// }





}






//商品分类
public function doPageJftype(){
  global $_W, $_GPC;
  $res=pdo_getall('wpdc_jftype',array('uniacid'=>$_W['uniacid']),array(),'','num asc');
  echo json_encode($res);
}

//商品列表
public function doPageJfGoods(){
  global $_W, $_GPC;
  $res=pdo_getall('wpdc_jfgoods',array('uniacid'=>$_W['uniacid']),array(),'','num asc');
  echo json_encode($res);
}
 //商品详情
public function doPageJfGoodsInfo(){
  global $_W, $_GPC;
  $res=pdo_getall('wpdc_jfgoods',array('id'=>$_GPC['id']));
  echo json_encode($res); 
}
 //分类下的商品
public function doPageJftypeGoods(){
  global $_W, $_GPC;
  $res=pdo_getall('wpdc_jfgoods',array('type_id'=>$_GPC['type_id']),array(),'','num asc');
  echo json_encode($res);
}
//积分商城广告
public function doPageAd3(){
  global $_W, $_GPC;
  $res=pdo_getall('wpdc_ad',array('uniacid'=>$_W['uniacid'],'status'=>1,'type'=>3),array(),'','orderby asc');
  echo json_encode($res);
}
//兑换商品
public function doPageExchange(){
  global $_W, $_GPC;
      $data['user_id']=$_GPC['user_id'];//用户id
      $data['good_id']=$_GPC['good_id'];//商品id
      $data['user_name']=$_GPC['user_name'];//用户名称
      $data['user_tel']=$_GPC['user_tel'];//用户电话
      $data['address']=$_GPC['address'];//地址
      $data['integral']=$_GPC['integral'];//积分
      $data['good_name']=$_GPC['good_name'];//商品名称
      $data['good_img']=$_GPC['good_img'];//商品图片
      $data['time']=date("Y-m-d H:i:s");
      $res=pdo_insert('wpdc_jfrecord',$data);
      if($res){
        pdo_update('wpdc_jfgoods',array('number -='=>1),array('id'=>$_GPC['good_id']));
          if($_GPC['type']==1){//虚拟红包
            pdo_update('wpdc_user',array('wallet +='=>$_GPC['hb_money']),array('id'=>$_GPC['user_id']));
            $data2['money']=$_GPC['hb_money'];
            $data2['user_id']=$_GPC['user_id'];
            $data2['type']=1;
            $data2['note']='积分兑换';
            $data2['time']=date('Y-m-d H:i:s');
            pdo_insert('wpdc_qbmx',$data2);
          }
          $data3['score']=$_GPC['integral'];
          $data3['user_id']=$_GPC['user_id'];
          $data3['note']='兑换商品';
          $data3['type']=2;
          $data3['cerated_time']=date('Y-m-d H:i:s');
          $data3['uniacid']=$_W['uniacid'];//小程序id
          pdo_insert('wpdc_integral',$data3); 
          pdo_update('wpdc_user',array('total_score -='=>$_GPC['integral']),array('id'=>$_GPC['user_id']));
          echo '1';
        }else{
          echo '2';
        }
      }
  //兑换明细
      public function doPageDhmx(){
        global $_W, $_GPC;
        $res=pdo_getall('wpdc_jfrecord',array('user_id'=>$_GPC['user_id']),array(),'','id DESC');
        echo json_encode($res);
      }
  //钱包明细
      public function doPageQbmx(){
        global $_W, $_GPC;
        $res=pdo_getall('wpdc_qbmx',array('user_id'=>$_GPC['user_id']),array(),'','id DESC');
        echo json_encode($res);
      }
//通过用户id请求用户信息
      public function doPageUserInfo(){
        global $_W, $_GPC;
        $res=pdo_get('wpdc_user',array('id'=>$_GPC['user_id']));
        echo json_encode($res);
      }
//充值活动
      public function doPageCzhd(){
       global $_W, $_GPC;
       $res=pdo_getall('wpdc_czhd',array('uniacid'=>$_W['uniacid']),array(),'','full DESC');
       echo json_encode($res);
     }
//充值
     public function doPageRecharge(){
      global $_W, $_GPC;
      $res=pdo_update('wpdc_user',array('wallet +='=>$_GPC['money']),array('id'=>$_GPC['user_id']));
      if($res){
       $data['money']=$_GPC['money'];
       $data['user_id']=$_GPC['user_id'];
       $data['type']=1;
       $data['note']='在线充值';
       $data['time']=date('Y-m-d H:i:s');
       $res2=pdo_insert('wpdc_qbmx',$data); 
       if($res2){
        echo '1';
      }else{
        echo '2';
      }
    }
  }

//入驻
  public function doPageRuZhu(){
    global $_W, $_GPC;
    $data['store_name']=$_GPC['store_name'];
    $data['tel']=$_GPC['tel'];
    $data['user_name']=$_GPC['user_name'];
    $data['img']=$_GPC['img'];
    $data['sp_img']=$_GPC['sp_img'];
    $data['sfz_img']=$_GPC['sfz_img'];
    $data['sfz_img2']=$_GPC['sfz_img2'];
    $data['state']=1;
    $data['user_id']=$_GPC['user_id'];
    $data['address']=$_GPC['address'];
    $data['time']=time();
    $data['uniacid']=$_W['uniacid'];
    $res=pdo_insert('wpdc_ruzhu',$data);
    if($res){
      echo '1';
    }else{
      echo '2';
    }
  }

  //查看我的入驻
  public function doPageMyRuZhu(){
    global $_W, $_GPC;
    $res=pdo_get('wpdc_ruzhu',array('user_id'=>$_GPC['user_id']));
    echo json_encode($res);
  }
  //申请分销商
  public function doPageDistribution(){
    global $_W, $_GPC;
    pdo_delete('wpdc_distribution',array('user_id'=>$_GPC['user_id']));
    $data['user_id']=$_GPC['user_id'];
    $data['user_name']=$_GPC['user_name'];
    $data['user_tel']=$_GPC['user_tel'];
    $data['time']=time();
    $data['state']=1;
    $data['uniacid']=$_W['uniacid'];
    $res=pdo_insert('wpdc_distribution',$data);
    if($res){
      echo  '1';
    }else{
      echo '2';
    }
  }
//查看我的申请
  public function doPageMyDistribution(){
    global $_W, $_GPC;
    $res=pdo_get('wpdc_distribution',array('user_id'=>$_GPC['user_id']));
    echo json_encode($res);
  }
//分销设置
  public function doPageFxSet(){
    global $_W, $_GPC;
    $res=pdo_get('wpdc_fxset',array('uniacid'=>$_W['uniacid']));
    echo json_encode($res);
  }
  //查看我的上线
  public function doPageMySx(){
    global $_W, $_GPC;
    $sql="select a.* ,b.name from " . tablename("wpdc_fxuser") . " a"  . " left join " . tablename("wpdc_user") . " b on b.id=a.user_id   WHERE a.fx_user=:fx_user ";
    $res=pdo_fetch($sql,array(':fx_user'=>$_GPC['user_id']));
    echo json_encode($res);
  }
   //查看我的佣金收益
  public function doPageEarnings(){
    global $_W, $_GPC;
    $sql="select a.* ,b.name,b.img from " . tablename("wpdc_earnings") . " a"  . " left join " . tablename("wpdc_user") . " b on b.id=a.son_id   WHERE a.user_id=:user_id order by id DESC";
    $res=pdo_fetchall($sql,array(':user_id'=>$_GPC['user_id']));
    echo json_encode($res);
  }
//我的二维码
  public function doPageMyCode(){
   global $_W, $_GPC;
   function  getCoade($storeid){
    function getaccess_token(){
      global $_W, $_GPC;
      $res=pdo_get('wpdc_system',array('uniacid' => $_W['uniacid']));
      $appid=$res['appid'];
      $secret=$res['appsecret'];
              // print_r($res);die;
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
      $data = curl_exec($ch);
      curl_close($ch);
      $data = json_decode($data,true);
      return $data['access_token'];
    }
    function set_msg($storeid){
     $access_token = getaccess_token();
     $data2=array(
      "scene"=>$storeid,
          // /"page"=>"zh_dianc/pages/info/info",
      "width"=>400
      );
     $data2 = json_encode($data2);
     $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$access_token."";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL,$url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
     curl_setopt($ch, CURLOPT_POST,1);
     curl_setopt($ch, CURLOPT_POSTFIELDS,$data2);
     $data = curl_exec($ch);
     curl_close($ch);
     return $data;
   }
   $img=set_msg($storeid);
   $img=base64_encode($img);
   return $img;
 }
 echo getCoade($_GPC['user_id']);

}
//佣金提现
public function doPageYjtx(){
 global $_W, $_GPC;
 $data['user_id']=$_GPC['user_id'];
     $data['type']=$_GPC['type'];//类型
     $data['user_name']=$_GPC['user_name'];//姓名
     $data['account']=$_GPC['account'];//账号
     $data['tx_cost']=$_GPC['tx_cost'];//提现金额
     $data['sj_cost']=$_GPC['sj_cost'];//实际到账金额
     $data['state']=1;
     $data['time']=time();
     $data['uniacid']=$_W['uniacid'];
     $res=pdo_insert('wpdc_commission_withdrawal',$data);
     if($res){
      pdo_update('wpdc_user',array('commission -='=>$_GPC['tx_cost']),array('id'=>$_GPC['user_id']));
      echo '1';
    }else{
      echo '2';
    }
  }
//提现明细
  public function doPageYjtxList(){
   global $_W, $_GPC;
   $res=pdo_getall('wpdc_commission_withdrawal',array('user_id'=>$_GPC['user_id']),array(),'','id DESC');
   echo json_encode($res);
 }

//绑定分销商
 public function doPageBinding(){
  global $_W, $_GPC;
  $set=pdo_get('wpdc_fxset',array('uniacid'=>$_W['uniacid']));
  $res=pdo_get('wpdc_fxuser',array('fx_user'=>$_GPC['fx_user']));
  $res2=pdo_get('wpdc_fxuser',array('user_id'=>$_GPC['fx_user'],'fx_user'=>$_GPC['user_id']));
  if($set['is_open']==1){
    if($_GPC['user_id']==$_GPC['fx_user']){
   echo '自己不能绑定自己';
 }elseif($res || $res2){
   echo '不能重复绑定';
 }else{
   $res3=pdo_insert('wpdc_fxuser',array('user_id'=>$_GPC['user_id'],'fx_user'=>$_GPC['fx_user'],'time'=>time()));
   if($res3){
    echo  '1';
  }else{
    echo  '2';
  }
}
  }
  

}

//查看我的团队
public function doPageMyTeam(){
 global $_W, $_GPC;
 $sql="select a.* ,b.name,b.img from " . tablename("wpdc_fxuser") . " a"  . " left join " . tablename("wpdc_user") . " b on b.id=a.fx_user   WHERE a.user_id=:user_id order by id DESC";
 $res=pdo_fetchall($sql,array(':user_id'=>$_GPC['user_id']));
 $res2=array();
 for($i=0;$i<count($res);$i++){
  $sql2="select a.* ,b.name,b.img from " . tablename("wpdc_fxuser") . " a"  . " left join " . tablename("wpdc_user") . " b on b.id=a.fx_user   WHERE a.user_id=:user_id order by id DESC";
  $res3=pdo_fetchall($sql2,array(':user_id'=>$res[$i]['fx_user']));
  $res2[]=$res3;

}

$res4=array();
for($k=0;$k<count($res2);$k++){
  for($j=0;$j<count($res2[$k]);$j++){
    $res4[]=$res2[$k][$j]; 
  }

}
$data['one']=$res;
$data['two']=$res4;
  // print_r($data);die;
echo json_encode($data);
}

//查看佣金
public function doPageMyCommission(){
  global $_W, $_GPC;
    $system=pdo_get('wpdc_fxset',array('uniacid'=>$_W['uniacid']));//tx_money
    $user=pdo_get('wpdc_user',array('id'=>$_GPC['user_id']));
    if($user['commission']<$system['tx_money']){
      $ke=0.00;
    }else{
      $ke=$user['commission'];
    }
    $sq = "select sum(tx_cost) as tx_cost from " . tablename("wpdc_commission_withdrawal")." WHERE  user_id=".$_GPC['user_id'];
    $sq = pdo_fetch($sq);
    $sq= $sq['tx_cost'];

    $cg = "select sum(tx_cost) as tx_cost from " . tablename("wpdc_commission_withdrawal")." WHERE  state=2 and user_id=".$_GPC['user_id'];
    $cg = pdo_fetch($cg);
    $cg= $cg['tx_cost'];
  
    $lei = "select sum(money) as tx_cost from " . tablename("wpdc_earnings")." WHERE  user_id=".$_GPC['user_id'];
    $lei = pdo_fetch($lei);
    $lei= $lei['tx_cost'];

    $data['ke']=$ke;
    $data['sq']=$sq;
    $data['cg']=$cg;
    $data['lei']=$lei;
    echo json_encode($data);
  }
//签到
  public function doPageSign(){
      global $_W, $_GPC;
      $time2=explode(',',$_GPC['time']);
      $time2=$time2[0]."-".$time2[1]."-".$time2[2];
      $time2=strtotime($time2);
      $data['time2']=$time2;
      $data['user_id']=$_GPC['user_id'];
      $data['time']=$_GPC['time'];
      $data['integral']=$_GPC['integral'];
      $data['uniacid']=$_W['uniacid'];
      $res=pdo_insert('wpdc_signlist',$data);
      if($res){
         
          if($_GPC['one']){
            pdo_update('wpdc_user',array('total_score +='=>$_GPC['one'],'day +='=>1),array('id'=>$_GPC['user_id']));//签到增加积分/签到天数
          $data2['score']=$_GPC['one'];
          $data2['user_id']=$_GPC['user_id'];
          $data2['note']='首次签到';
          $data2['type']=1;
          $data2['cerated_time']=date('Y-m-d H:i:s');
          $data2['uniacid']=$_W['uniacid'];//小程序id
          pdo_insert('wpdc_integral',$data2);//添加积分明细
          }else{
             pdo_update('wpdc_user',array('total_score +='=>$_GPC['integral'],'day +='=>1),array('id'=>$_GPC['user_id']));//签到增加积分/签到天数
          $data2['score']=$_GPC['integral'];
          $data2['user_id']=$_GPC['user_id'];
          $data2['note']='每日签到';
          $data2['type']=1;
          $data2['cerated_time']=date('Y-m-d H:i:s');
          $data2['uniacid']=$_W['uniacid'];//小程序id
          pdo_insert('wpdc_integral',$data2);//添加积分明细
          }
          $list=pdo_getall('wpdc_continuous',array('uniacid'=>$_W['uniacid']));//连续签到列表

          $my=pdo_getall('wpdc_signlist',array('user_id'=>$_GPC['user_id']),array(),'','time2 DESC');
     // print_r($list);die;
          $time=date('Y,n,j',time());//今天
          $jt=pdo_get('wpdc_signlist',array('user_id'=>$_GPC['user_id'],'time'=>$time));//查看今天有没有签到
          if($jt){//签到了
            $num=0;
            for($i=0;$i<count($my);$i++){
                  if(date('Y,n,j',time()-$i*60*60*24)==$my[$i]['time']){//从今天开始匹对
                    $num=$num+1;
                  }else{
                   black;
                  }
            }
          }else{
            $num=0;
            for($i=0;$i<count($my);$i++){
                  if(date('Y,n,j',time()-($i+1)*60*60*24)==$my[$i]['time']){//从昨天开始匹对
                    $num=$num+1;
                  }else{
                   black;
                  }
            }
          }

            for($k=0;$k<count($list);$k++){
                if($num==$list[$k]['day']){
                  $data3['score']=$list[$k]['integral'];
                  $data3['user_id']=$_GPC['user_id'];
                  $data3['note']="连续签到".$list[$k]['day']."天";
                  $data3['type']=1;
                  $data3['cerated_time']=date('Y-m-d H:i:s');
                  $data3['uniacid']=$_W['uniacid'];//小程序id
                  $qd=pdo_get('wpdc_integral',array('uniacid'=>$_W['uniacid'],'note'=>$data3['note'],'user_id'=>$_GPC['user_id']));
                  if(!$qd){
                    pdo_insert('wpdc_integral',$data3);//添加积分明细
                    pdo_update('wpdc_user',array('total_score +='=>$list[$k]['integral']),array('id'=>$_GPC['user_id']));//连续签到增加积分
                  }
                  black;
                }
            }
       echo '1';
      }else{
        echo '2';
      }
  }
  //补签
  public function doPageSign2(){
      global $_W, $_GPC;
      $time2=explode(',',$_GPC['time']);
      $time2=$time2[0]."-".$time2[1]."-".$time2[2];
      $time2=strtotime($time2);
      $data['time2']=$time2;
      $data['user_id']=$_GPC['user_id'];
      $data['time']=$_GPC['time'];
      $data['integral']=$_GPC['integral'];
      $data['uniacid']=$_W['uniacid'];
      $res=pdo_insert('wpdc_signlist',$data);
      $res2=pdo_get('wpdc_signset',array('uniacid'=>$_W['uniacid']));
      if($res){
          pdo_update('wpdc_user',array('total_score -='=>$res2['bq_integral']),array('id'=>$_GPC['user_id']));//签到增加积分/签到天数
          $data4['score']=$res2['bq_integral'];
          $data4['user_id']=$_GPC['user_id'];
          $data4['note']='补签';
          $data4['type']=2;
          $data4['cerated_time']=date('Y-m-d H:i:s');
          $data4['uniacid']=$_W['uniacid'];//小程序id
          pdo_insert('wpdc_integral',$data4);//添加积分明细

          if($_GPC['one']){
            pdo_update('wpdc_user',array('total_score +='=>$_GPC['one'],'day +='=>1),array('id'=>$_GPC['user_id']));//签到增加积分/签到天数
          $data2['score']=$_GPC['one'];
          $data2['user_id']=$_GPC['user_id'];
          $data2['note']='首次签到';
          $data2['type']=1;
          $data2['cerated_time']=date('Y-m-d H:i:s');
          $data2['uniacid']=$_W['uniacid'];//小程序id
          pdo_insert('wpdc_integral',$data2);//添加积分明细
          }else{
             pdo_update('wpdc_user',array('total_score +='=>$_GPC['integral'],'day +='=>1),array('id'=>$_GPC['user_id']));//签到增加积分/签到天数
          $data2['score']=$_GPC['integral'];
          $data2['user_id']=$_GPC['user_id'];
          $data2['note']='每日签到';
          $data2['type']=1;
          $data2['cerated_time']=date('Y-m-d H:i:s');
          $data2['uniacid']=$_W['uniacid'];//小程序id
          pdo_insert('wpdc_integral',$data2);//添加积分明细
          }

          $list=pdo_getall('wpdc_continuous',array('uniacid'=>$_W['uniacid']));//连续签到列表

          $my=pdo_getall('wpdc_signlist',array('user_id'=>$_GPC['user_id']),array(),'','time2 DESC');
     // print_r($list);die;
          $time=date('Y,n,j',time());//今天
          $jt=pdo_get('wpdc_signlist',array('user_id'=>$_GPC['user_id'],'time'=>$time));//查看今天有没有签到
          if($jt){//签到了
            $num=0;
            for($i=0;$i<count($my);$i++){
                  if(date('Y,n,j',time()-$i*60*60*24)==$my[$i]['time']){//从今天开始匹对
                    $num=$num+1;
                  }else{
                   black;
                  }
            }
          }else{
            $num=0;
            for($i=0;$i<count($my);$i++){
                  if(date('Y,n,j',time()-($i+1)*60*60*24)==$my[$i]['time']){//从昨天开始匹对
                    $num=$num+1;
                  }else{
                   black;
                  }
               }
          }

            for($k=0;$k<count($list);$k++){
                if($num==$list[$k]['day']){
                  $data3['score']=$list[$k]['integral'];
                  $data3['user_id']=$_GPC['user_id'];
                  $data3['note']="连续签到".$list[$k]['day']."天";
                  $data3['type']=1;
                  $data3['cerated_time']=date('Y-m-d H:i:s');
                  $data3['uniacid']=$_W['uniacid'];//小程序id
                  $qd=pdo_get('wpdc_integral',array('uniacid'=>$_W['uniacid'],'note'=>$data3['note'],'user_id'=>$_GPC['user_id']));
                  if(!$qd){
                    pdo_insert('wpdc_integral',$data3);//添加积分明细
                    pdo_update('wpdc_user',array('total_score +='=>$list[$k]['integral']),array('id'=>$_GPC['user_id']));//连续签到增加积分
                  }
                  black;
                }
            }
            // $special=pdo_getall('wpdc_special',array('uniacid'=>$_W['uniacid']));
            // for($j=0;$j<count($special);$j++){
            //     if($_GPC['time']==date('Y,m,d',strtotime($special[$j]['day']))){

            //     }
            // }
          echo '1';
      }else{
        echo '2';
      }
  }
  //查看是否补签
  public function doPageIsbq(){
      global $_W, $_GPC;
      $time=date('Y-m-d');

      $time="'%$time%'";
     // echo $time;die;
      $sql="select *  from " . tablename("wpdc_integral") ." WHERE  cerated_time LIKE ".$time." and user_id=".$_GPC['user_id']." and note='补签'";
    //  echo $sql;die;
      $res=pdo_fetch($sql);
      if($res){
        echo '1';
      }else{
        echo '2';
      }
  }
  //查看我的签到
  public function doPageMySign(){
      global $_W, $_GPC;
      $res=pdo_getall('wpdc_signlist',array('user_id'=>$_GPC['user_id']));
      echo json_encode($res);
  }
  //签到排行
  public function doPageRank(){
      global $_W, $_GPC;
      $res=pdo_getall('wpdc_user',array('uniacid'=>$_W['uniacid'],'day !='=>''),array(),'','day DESC');
      echo json_encode($res);
  }
  //查看连签奖励
  public function doPageContinuousList(){
      global $_W, $_GPC;
      $res=pdo_getall('wpdc_continuous',array('uniacid'=>$_W['uniacid']),array(),'','day asc');
      echo json_encode($res);
  }
  //查看特殊日期奖励
  public function doPageSpecial(){
      global $_W, $_GPC;
      $res=pdo_getall('wpdc_special',array('uniacid'=>$_W['uniacid']));
      echo json_encode($res);
  }
  //查看签到规则
  public function doPageSignset(){
      global $_W, $_GPC;
      $res=pdo_getall('wpdc_signset',array('uniacid'=>$_W['uniacid']));
      echo json_encode($res);
  }
//查看连续签到天数
  public function doPageContinuous(){
        global $_W, $_GPC;
        $my=pdo_getall('wpdc_signlist',array('user_id'=>$_GPC['user_id']),array(),'','time2 desc');
        $time=date('Y,n,j',time());//今天
        $jt=pdo_get('wpdc_signlist',array('user_id'=>$_GPC['user_id'],'time'=>$time));//查看今天有没有签到
        if($jt){//签到了
          $num=0;
          for($i=0;$i<count($my);$i++){
                if(date('Y,n,j',time()-$i*60*60*24)==$my[$i]['time']){//从今天开始匹对
                  $num=$num+1;
                }else{
                 black;
                }
          }
        }else{
          $num=0;
          for($i=0;$i<count($my);$i++){
                if(date('Y,n,j',time()-($i+1)*60*60*24)==$my[$i]['time']){//从昨天开始匹对
                  $num=$num+1;
                }else{
                 black;
                }
          }
        }
            echo $num;

        
  }



// public function doPageQiye(){

//    function arraytoxml($data){
//         $str='<xml>';
//         foreach($data as $k=>$v) {
//             $str.='<'.$k.'>'.$v.'</'.$k.'>';
//         }
//         $str.='</xml>';
//         return $str;
//     }
//     function xmltoarray($xml) { 
//         //禁止引用外部xml实体 
//         libxml_disable_entity_loader(true); 
//         $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA); 
//         $val = json_decode(json_encode($xmlstring),true); 
//         return $val;
//     } 

//     function curl($param="",$url) {
//         global $_GPC, $_W;
//         $postUrl = $url;
//         $curlPost = $param;
//         $ch = curl_init();                                      //初始化curl
//         curl_setopt($ch, CURLOPT_URL,$postUrl);                 //抓取指定网页
//         curl_setopt($ch, CURLOPT_HEADER, 0);                    //设置header
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
//         curl_setopt($ch, CURLOPT_POST, 1);                      //post提交方式
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);           // 增加 HTTP Header（头）里的字段 
//         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // 终止从服务端进行验证
//         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
//         curl_setopt($ch,CURLOPT_SSLCERT,IA_ROOT . "/addons/zh_dianc/cert/apiclient_cert_".$_W['uniacid'].".pem"); //这个是证书的位置绝对路径
//         curl_setopt($ch,CURLOPT_SSLKEY,IA_ROOT . "/addons/zh_dianc/cert/apiclient_key_".$_W['uniacid'].".pem"); //这个也是证书的位置绝对路径
//         $data = curl_exec($ch);                                 //运行curl
//         curl_close($ch);
//         return $data;
//     }
      

//     $data=array(
//         'mch_appid'=>'wx80fa1d36c435231a',//商户账号appid
//         'mchid'=>'1280966201',//商户号
//         'nonce_str'=>rand(1111111111,9999999999),//随机字符串
//         'partner_trade_no'=>date("YmdHis"),//商户订单号
//         'openid'=>'oTgQS0fTkFTWN9G_iKtFRKnJYW3I',//用户openid
//         'check_name'=>'NO_CHECK',//校验用户姓名选项,
//         're_user_name'=>'何力',//收款用户姓名
//         'amount'=>100,//金额
//         'desc'=>'企业打款测试',//企业付款描述信息
//         'spbill_create_ip'=>'106.15.225.46',//Ip地址
//     );

//     $key='whxcx888whxcx888whxcx888whxcx888';///这个就是个API密码。32位的。。随便MD5一下就可以了
//    // $key=md5($key);
//     $data=array_filter($data);
//     ksort($data);
//     $str='';
//     foreach($data as $k=>$v) {
//         $str.=$k.'='.$v.'&';
//     }
//     $str.='key='.$key;
//     $data['sign']=md5($str);
// //echo $data['sign'];die;
//     $xml=arraytoxml($data);
//     $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
//     $res=curl($xml,$url);
//     $return=xmltoarray($res);
//     print_r($return);
//     // function unicode() {
//     //     $str = uniqid(mt_rand(),1);
//     //     $str=sha1($str);
//     // return md5($str);
//     // }
   
// }


//////////以下uupt

//获取订单价格
public function doPageGetOrderPrice(){
global $_W, $_GPC;
include IA_ROOT.'/addons/zh_dianc/uupt/upt.php';
//订单信息
$orderinfo=pdo_get('wpdc_order',array('id'=>$_GPC['order_id']));
//获取商家信息
$sellerinfo=pdo_get('wpdc_store',array('id'=>$orderinfo['seller_id']));
$arr= explode(",", $sellerinfo['coordinates']); 
//获取uu配置
$uupt=pdo_get('wpdc_uuset',array('store_id'=>$orderinfo['seller_id'])); 
header("Content-type: text/html; charset=utf-8"); 
$guid = str_replace('-', '', upt::guid());
//var_dump($guid);die;
$appid = $uupt['appid'];
$appKey = $uupt['appkey'];
$openid= $uupt['OpenId'];
$name=substr($orderinfo['area'],strpos($orderinfo['area'],"省")+3);
$city_name=$name.'市';
$url="http://openapi.uupaotui.com/v2_0/getorderprice.ashx"; 
$data=array(
            'origin_id'       =>$_GPC['order_id'],
            'from_address'   => $sellerinfo['address'],
            'to_address'   => $orderinfo['address'],
            'city_name' => $city_name,
            'to_lng'     => $orderinfo['lng'],//经度
             'to_lat'     =>  $orderinfo['lat'],
              'from_lng'     => $arr[1],
             'from_lat'     => $arr[0], 
              'nonce_str' => strtolower($guid),
            'timestamp'     => time(),
             'appid'     => $appid,
             'openid'=>$openid,     
  );

ksort($data);
$data['sign'] = upt::sign($data, $appKey);
//var_dump($data);die;
$res =upt::request_post($url, $data);
//var_dump($res);die;
//$a=json_decode($res);
//echo $a->total_money;die;
echo json_encode($res);

}

//发布订单

public function  doPageUuAddOrder(){
global $_W, $_GPC;
include IA_ROOT.'/addons/zh_dianc/uupt/upt.php';
//订单信息
$orderinfo=pdo_get('wpdc_order',array('id'=>$_GPC['order_id']));
/*//获取商家信息
$sellerinfo=pdo_get('wpdc_store',array('id'=>$orderinfo['seller_id']));
$arr= explode(",", $sellerinfo['coordinates']); */
//获取uu配置
$uupt=pdo_get('wpdc_uuset',array('store_id'=>$orderinfo['seller_id'])); 
header("Content-type: text/html; charset=utf-8"); 
$guid = str_replace('-', '', upt::guid());
//var_dump($guid);die;
$appid = $uupt['appid'];
$appKey = $uupt['appkey'];
$openid= $uupt['OpenId'];
//var_dump($orderinfo);die;
// $_GPC['price_token']='81e2118fff3841c884e3e16f935f6107';
//  $_GPC['total_money']="16.00";
//  $_GPC['need_paymoney']="1.00";
 $url="http://openapi.uupaotui.com/v2_0/addorder.ashx"; 
  $data=array(
       'price_token'=>$_GPC['price_token'],
            'order_price'   => $_GPC['total_money'],
            'balance_paymoney'   => $_GPC['need_paymoney'],
            'receiver' =>$orderinfo['name'],
            'receiver_phone'     => $orderinfo['tel'],
              'callback_url'     => 'http://www.test.com/callback' ,
              'push_type'     => '2',//使用优惠券
             'special_type'     => '0' , 
             'callme_withtake'=>'1',
            'nonce_str' => strtolower($guid),
            'timestamp'     => time(),
             'appid'     => $appid,
             'openid'=>$openid,     
  );
  /*$data=array(
      'price_token'=>$_GPC['price_token'],
            'order_price'   => $_GPC['total_money'],
            'balance_paymoney'   => $_GPC['need_paymoney'],
            'receiver' => $orderinfo['name'],
            'receiver_phone'     => $orderinfo['tel'],//经度
             'callback_url'     => 'http://www.test.com/callback' ,
              'push_type'     => '2',//使用优惠券
             'special_type'     => '0' , 
             'callme_withtake'=>'1',

              'nonce_str' => strtolower($guid),
            'timestamp'     => time(),
             'appid'     => $appid,
             'openid'=>$openid,     

  );*/
  

ksort($data);
$data['sign'] = upt::sign($data, $appKey);
//var_dump($data);die;
$res =upt::request_post($url, $data);
echo json_encode($res);

}

//查看订单详情

public function doPageUuGetorderdetail(){
global $_W, $_GPC;
include IA_ROOT.'/addons/zh_dianc/uupt/upt.php';
//订单信息
$orderinfo=pdo_get('wpdc_order',array('id'=>$_GPC['order_id']));
//获取uu配置
$uupt=pdo_get('wpdc_uuset',array('store_id'=>$orderinfo['seller_id'])); 
header("Content-type: text/html; charset=utf-8"); 
$guid = str_replace('-', '', upt::guid());
//var_dump($guid);die;
$appid = $uupt['appid'];
$appKey = $uupt['appkey'];
$openid= $uupt['OpenId'];
  $url="http://openapi.uupaotui.com/v2_0/getorderdetail.ashx"; 
  $data=array(
       //'order_code' =>'U10508001712261102685047079',
       'origin_id'=>$_GPC['order_id'],
        'nonce_str' => strtolower($guid),
        'timestamp'     => time(),
        'appid'     => $appid,
        'openid'=>$openid,     
  );

ksort($data);
$data['sign'] = upt::sign($data, $appKey);
$res =upt::request_post($url, $data);
echo json_encode($res);

}






//充值下订单
public function doPageAddCzorder(){
    global $_W, $_GPC;
    $data['user_id']=$_GPC['user_id'];
    $data['money']=$_GPC['money'];
    $data['form_id']=$_GPC['form_id'];
    $data['state']=1;
    $data['uniacid']=$_W['uniacid'];
    $data['time']=date("Y-m-d H:i:s");
    $res=pdo_insert('wpdc_czorder',$data);
    $order_id=pdo_insertid();
    if($res){
      echo $order_id;
    }else{
      echo '下单失败!';
    }
}








//手机端店内订单
public function doPageAppDnOrder(){
  global $_W, $_GPC;
  $pageindex = max(1, intval($_GPC['page']));
  $pagesize=10;
  $time=$_GPC['time'];
  $time="'%$time%'";
  $sql="SELECT a.*,b.name,b.status as t_status,c.name as tablename  FROM ".tablename('wpdc_order'). " a"  . " left join " . tablename("wpdc_table") . " b on a.table_id=b.id  left join " . tablename("wpdc_table_type") ." c on b.type_id=c.id WHERE  a.uniacid=:uniacid and a.time LIKE ".$time." and a.type=2 and a.seller_id=:seller_id ORDER BY a.time2 DESC";
  $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
  $list = pdo_fetchall($select_sql,array(':seller_id'=>$_GPC['store_id'],':uniacid'=>$_W['uniacid']));
  echo json_encode($list);
}

//确认订单
public function doPageOkDnOrder(){
  global $_W, $_GPC;
   $id=$_GPC['id'];
  $data['dn_state']=2;
  $result = pdo_update('wpdc_order',$data,array('id'=>$id));
  if($result){
      echo '1';
  }else{
      echo '2';
  }
}
//关闭订单
public function doPageDownDnOrder(){
  global $_W, $_GPC;
   $id=$_GPC['id'];
  $data['dn_state']=3;
  $result = pdo_update('wpdc_order',$data,array('id'=>$id));
  if($result){
      echo '1';
  }else{
      echo '2';
  }
}
//重新开台
public function doPageOpenTable(){
  global $_W, $_GPC;
   $table_id=$_GPC['id'];
   $data2['status']=0;
   $result = pdo_update('wpdc_table',$data2, array('id'=>$table_id));
   if($result){
      echo '1';
  }else{
      echo '2';
  }
}

           
//手机端预定订单
public function doPageAppYdOrder(){
  global $_W, $_GPC;
  $pageindex = max(1, intval($_GPC['page']));
  $pagesize=10;
  $time=$_GPC['time'];
  $time="'%$time%'";//created_time
   $sql="SELECT * FROM ".tablename('wpdc_ydorder'). "  WHERE  store_id=".$_GPC['store_id']." and created_time LIKE ".$time." and state!=0 ORDER BY id DESC";
  $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
  $list = pdo_fetchall($select_sql);
  echo json_encode($list);
}


//确认
public function doPageOkYdOrder(){
    global $_W, $_GPC;
        $data2['state']=2;
        $rst=pdo_update('wpdc_ydorder',$data2,array('id'=>$_GPC['order_id']));
        if($rst){
/////////////////分销/////////////////

        $set=pdo_get('wpdc_fxset',array('uniacid'=>$_W['uniacid']));
        $order=pdo_get('wpdc_ydorder',array('id'=>$_GPC['id']));
        $store=pdo_get('wpdc_store',array('id'=>$order['seller']));
        $type=pdo_get('wpdc_storetype',array('id'=>$store['md_type']));
        if($set['is_open']==1){//开启分销
          if($set['is_type']==1){//开启分类分销
              if($set['is_ej']==2){//不开启二级分销
               $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
               if($user){
                    $userid=$user['user_id'];//上线id
                    $money=$order['money']*($type['commission']/100);//一级佣金
                    pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
                    $data6['user_id']=$userid;//上线id
                    $data6['son_id']=$order['user_id'];//下线id
                    $data6['money']=$money;//金额
                    $data6['time']=time();//时间
                    $data6['uniacid']=$_W['uniacid'];
                    pdo_insert('wpdc_earnings',$data6);
                  }
      }else{//开启二级
          $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
          $user2=pdo_get('wpdc_fxuser',array('fx_user'=>$user['user_id']));//上线的上线
          if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($type['commission']/100);//一级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data6);
          }
          if($user2){
            $userid2=$user2['user_id'];//上线的上线id
            $money=$order['money']*($type['commission2']/100);//二级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid2));
            $data7['user_id']=$userid2;//上线id
            $data7['son_id']=$order['user_id'];//下线id
            $data7['money']=$money;//金额
            $data7['time']=time();//时间
            $data7['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data7);
          }
        }
          }else{
            if($set['is_ej']==2){//不开启二级分销
           $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
           if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($set['commission']/100);//一级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data6);
          }
      }else{//开启二级
       $user=pdo_get('wpdc_fxuser',array('fx_user'=>$order['user_id']));
          $user2=pdo_get('wpdc_fxuser',array('fx_user'=>$user['user_id']));//上线的上线
          if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($set['commission']/100);//一级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data6);
          }
          if($user2){
            $userid2=$user2['user_id'];//上线的上线id
            $money=$order['money']*($set['commission2']/100);//二级佣金
            pdo_update('wpdc_user',array('commission +='=>$money),array('id'=>$userid2));
            $data7['user_id']=$userid2;//上线id
            $data7['son_id']=$order['user_id'];//下线id
            $data7['money']=$money;//金额
            $data7['time']=time();//时间
            $data7['uniacid']=$_W['uniacid'];
            pdo_insert('wpdc_earnings',$data7);
          }
        }
          }
        }
      
/////////////////分销/////////////////



//////////积分/////////
        
 if($order['money'] and $store['is_yyjf']==1 and $system['is_jf']==1){
    if($store['integral2']){
       $jifen=round(($store['integral2']/100)*$order['money']);
          pdo_update('wpdc_user',array('total_score +='=>$jifen),array('id'=>$order['user_id']));
          $data5['score']=$jifen;
          $data5['user_id']=$order['user_id'];
          $data5['note']='预约消费';
          $data5['type']=1;
          $data5['cerated_time']=date('Y-m-d H:i:s');
          $data5['uniacid']=$_W['uniacid'];//小程序id
          pdo_insert('wpdc_integral',$data5);  
    }elseif($system['integral2']){
      $jifen=round(($system['integral2']/100)*$order['money']);
          pdo_update('wpdc_user',array('total_score +='=>$jifen),array('id'=>$order['user_id']));
          $data5['score']=$jifen;
          $data5['user_id']=$order['user_id'];
          $data5['note']='预约消费';
          $data5['type']=1;
          $data5['cerated_time']=date('Y-m-d H:i:s');
          $data5['uniacid']=$_W['uniacid'];//小程序id
          pdo_insert('wpdc_integral',$data5);  
    }
          
        }

////////////积分//////////
           echo '1';
        }else{
            echo '2';
        }
        


}

//通过预约退款
public function doPageYdtk(){
  global $_W, $_GPC;
   $id=$_GPC['order_id'];
    include_once IA_ROOT . '/addons/zh_dianc/cert/WxPay.Api.php';
    load()->model('account');
    load()->func('communication');
    $WxPayApi = new WxPayApi();
    $input = new WxPayRefund();
   //$path_cert = IA_ROOT . '/addons/zh_dianc/cert/apiclient_cert.pem';
   // $path_key = IA_ROOT . '/addons/zh_dianc/cert/apiclient_key.pem';
    $path_cert = IA_ROOT . "/addons/zh_dianc/cert/".'apiclient_cert_' . $_W['uniacid'] . '.pem';
    $path_key = IA_ROOT . "/addons/zh_dianc/cert/".'apiclient_key_' . $_W['uniacid'] . '.pem';
    $account_info = $_W['account'];
    $refund_order =pdo_get('wpdc_ydorder',array('id'=>$id));  
    $res=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
    $appid=$res['appid'];
    $key=$res['wxkey'];
    $mchid=$res['mchid']; 
    $out_trade_no=$refund_order['ydcode'];//商户订单号
    $fee = $refund_order['pay_money'] * 100;
        //$refundid = $refund_order['transid'];
        //$refundid='4200000022201710178579320894';
        $input->SetAppid($appid);
        $input->SetMch_id($mchid);
        $input->SetOp_user_id($mchid);
        $input->SetRefund_fee($fee);
        $input->SetTotal_fee($fee);
       // $input->SetTransaction_id($refundid);
        $input->SetOut_refund_no($id);
     
       $input->SetOut_trade_no($out_trade_no);
   
        $result = $WxPayApi->refund($input, 6, $path_cert, $path_key, $key);
       
       //var_dump($result);die;
        if ($result['result_code'] == 'SUCCESS') {//退款成功
       pdo_update('wpdc_ydorder',array('state'=>6),array('id'=>$id));
       echo '1';
    }else{
        echo '2';
  }
}
//拒绝预约退款
public function doPageTkjj(){
  global $_W, $_GPC;
  $res=pdo_update('wpdc_ydorder',array('state'=>7),array('id'=>$_GPC['order_id']));
  if($res){
    echo '1';
  }else{
    echo '2';
  }
}
//手机端当面付订单
public function doPageAppDmOrder(){
  global $_W, $_GPC;
 $pageindex = max(1, intval($_GPC['page']));
  $pagesize=10;
  $time=$_GPC['time'];
  $time="'%$time%'";
  $sql="SELECT a.*,b.md_name,c.name FROM ".tablename('wpdc_dmorder'). " a"  . " left join " . tablename("wpdc_store") . " b on a.store_id=b.id " . " left join " . tablename("wpdc_user") . " c on c.id=a.user_id WHERE a.time LIKE ".$time." and a.store_id=:store_id and a.state=2 ORDER BY a.time2 DESC";
   $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
  $res=pdo_fetchall($select_sql,array(':store_id'=>$_GPC['store_id']));
    echo json_encode($res);
}
//菜品分类
public function doPageAppDishesType(){
   global $_W, $_GPC;
   $res=pdo_getall('wpdc_type',array('store_id'=>$_GPC['store_id']));
   echo json_encode($res);
}
//添加分类
public function doPageAddDishesType(){
  global $_W, $_GPC;
    $data['order_by']=$_GPC['order_by'];//排序
      $data['type_name']=$_GPC['type_name'];//名称
      $data['is_open']=$_GPC['is_open'];//是否开启1是2否
      $data['store_id']=$_GPC['store_id'];//商家id
      $data['uniacid']=$_W['uniacid'];
      if($_GPC['id']==''){
        $res=pdo_insert('wpdc_type',$data);
        if($res){
          echo '1';
        }else{
          echo '2';
        }
      }else{
        $res = pdo_update('wpdc_type', $data, array('id' => $_GPC['id']));
        if($res){
          echo '1';
        }else{
          echo '2';
        }
      }
}

//菜品详情
public function doPageAppDishesInfo(){
    global $_W, $_GPC;
    $res=pdo_get('wpdc_dishes',array('id'=>$_GPC['id']));
    echo json_encode($res);
}
//菜品列表
public function doPageAppDishes(){
  global $_W, $_GPC;
//   $sql="select a.* ,b.type_name from " . tablename("wpdc_dishes") . " a"  . " left join " . tablename("wpdc_type") . " b on b.id=a.type_id WHERE a.uniacid=:uniacid and a.type_id=:type_id order by sorting asc";
// $res=pdo_fetchall($sql,array(':type_id'=>$_GPC['type_id'],':uniacid'=>$_W['uniacid']));
// echo json_encode($res);
$type=pdo_getall('wpdc_type',array('uniacid'=>$_W['uniacid'],'store_id'=>$_GPC['store_id']),array(),'','order_by ASC');
 $list=pdo_getall('wpdc_dishes',array('uniacid'=>$_W['uniacid'],'store_id'=>$_GPC['store_id']),array(),'','sorting ASC');
 $data2=array();
 for($i=0;$i<count($type);$i++){
  $data=array();
  for($k=0;$k<count($list);$k++){
    if($type[$i]['id']==$list[$k]['type_id']){
      $data[]=array(
        'id'=>$list[$k]['id'],
        'name'=>$list[$k]['name'],
        'img'=>$list[$k]['img'],
        'num'=>$list[$k]['num'],
        'money'=>$list[$k]['money'],
        'signature'=>$list[$k]['signature'],
        'dishes_type'=>$list[$k]['dishes_type'],
        'xs_num'=>$list[$k]['xs_num'],
        'sit_ys_num'=>$list[$k]['sit_ys_num'],
        'wm_money'=>$list[$k]['wm_money'],
        'details'=>$list[$k]['details'],
        'box_fee'=>$list[$k]['box_fee'],
        'is_shelves'=>$list[$k]['is_shelves'],
        'sorting'=>$list[$k]['sorting']
        );
    }           
  }
  $data2[]=array(
    'id'=>$type[$i]['id'],
    'type_name'=>$type[$i]['type_name'],
    'goods'=>$data
    );
}
echo json_encode($data2);
}
//上下架
public function doPageUpdDishes(){
  global $_W, $_GPC;
  $data2['is_shelves']=$_GPC['is_shelves'];
  $res=pdo_update('wpdc_dishes',$data2,array('id'=>$_GPC['dishes_id']));
  if($res){
    echo '1';
  }else{
    echo '2';
  }
}
//添加菜品
public function doPageAddDishes(){
  global $_W, $_GPC;
  $data['money']=$_GPC['money'];//店内价格
  $data['wm_money']=$_GPC['wm_money'];//外卖价格
  $data['name']=$_GPC['name'];//名称
  $data['img']=$_GPC['img'];//图片
  $data['num']=$_GPC['num'];//数量
  $data['sorting']=$_GPC['sorting'];//排序
  $data['type_id']=$_GPC['type_id'];//分类
  // $data['signature']=$_GPC['signature'];//招牌1.是2.否
  $data['sit_ys_num']=$_GPC['sit_ys_num'];//月销售数量
  $data['is_shelves']=$_GPC['is_shelves'];//是否上架1.是2.否
  $data['dishes_type']=$_GPC['dishes_type'];//1外卖2.店内3.外卖+店内
  $data['box_fee']=$_GPC['box_fee'];//餐盒费
  $data['store_id']=$_GPC['store_id'];//商家id
    $data['uniacid']=$_W['uniacid'];
  if($_GPC['id']==''){
    $sql=pdo_get('wpdc_dishes',array('name'=>$_GPC['name'],'uniacid'=>$_W['uniacid'],'type_id'=>$_GPC['type_id'],'dishes_type'=>$_GPC['dishes_type']));
    if($sql){
      echo '不能添加相同菜品!';
    }else{
      $res=pdo_insert('wpdc_dishes',$data);
      if($res){       
       echo '1';
      }else{
       echo '2';
      }
    }
  }else{
    $res = pdo_update('wpdc_dishes', $data, array('id' => $_GPC['id']));
    if($res){
      echo '1';
    }else{
      echo '2';
    }
  }
}
//删除菜品
public function doPageDelDishes(){
    global $_W, $_GPC;
    $result = pdo_delete('wpdc_dishes', array('id'=>$_GPC['dishes_id']));
    if($result){
      echo '1';
    }else{
      echo '2';
    }
}
//删除分类
public function doPageDelDishesType(){
    global $_W, $_GPC;
    $rst=pdo_getall('wpdc_dishes',array('type_id'=>$_GPC['id']));
    if(!$rst){
    $result = pdo_delete('wpdc_type', array('id'=>$_GPC['id']));
    if($result){
      echo '1';
    }else{
      echo '2';
    }
  }else{
    echo '该分类下有菜品无法删除!';
  }
}

//添加规格
  public function doPageAddSpec(){
    global $_W, $_GPC;
    $data['name']=$_GPC['name'];//名称
    $data['cost']=$_GPC['cost'];//价格
    $data['goods_id']=$_GPC['dishes_id'];//菜品id
    if($_GPC['id']==''){
        $res=pdo_insert('wpdc_spec',$data);
        if($res){
          echo '1';
        }else{
          echo '2';
        }
      }else{
        $res = pdo_update('wpdc_spec', $data, array('id' => $_GPC['id']));
        if($res){
          echo '1';
        }else{
          echo '2';
        }
      }
  }

//规格列表
public function  doPageAppSpec(){
    global $_W, $_GPC;
    $list = pdo_getall('wpdc_spec',array('goods_id'=>$_GPC['dishes_id']));
    echo json_encode($list);
}
//删除规格
  public function doPageDelSpec(){
    global $_W, $_GPC;
    $result = pdo_delete('wpdc_spec', array('id'=>$_GPC['spec_id']));
    if($result){
      echo '1';
    }else{
      echo '2';
    }
  }
  //开启关闭音乐
  public function doPageIsOpenYy(){
    global $_W, $_GPC;
    $res=pdo_update('wpdc_store',array('is_mp3'=>$_GPC['is_mp3']),array('id'=>$_GPC['store_id']));
    if($res){
      echo '1';
    }else{
      echo '2';
    }
  }
//商家提现
public function doPageStoreTx(){
    global $_W, $_GPC;
    $data['sj_cost']=$_GPC['tx_cost'];
    $data['store_id']=$_GPC['store_id'];
    $data['name']=$_GPC['name'];
    $data['username']=$_GPC['username'];
    $data['type']=$_GPC['type'];
    $data['state']=1;
    $data['tx_cost']=$_GPC['tx_cost'];
    $data['uniacid']=$_W['uniacid'];
    $data['time']=date("Y-m-d H:i:s");
    $res=pdo_insert('wpdc_withdrawal',$data);
    if($res){
      echo '1';
    }else{
      echo '2';
    }
}
//商家提现明细
  public function doPageStoreTxList(){
      global $_W, $_GPC;
      $res=pdo_getall('wpdc_withdrawal',array('store_id'=>$_GPC['store_id']));
      echo json_encode($res);
  }

public function doPageMoBan(){
  global $_W, $_GPC;
    function getaccess_token($_W){
      $sms=pdo_get('wpdc_sms',array('uniacid'=>$_W['uniacid']));
      $appid = $sms['wx_appid'];
      $appsecret = $sms['wx_secret'];
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
      $data = curl_exec($ch);
      curl_close($ch);
      $data = json_decode($data,true);
      return $data['access_token'];
   }
 
 function set_msg($_W){
    $access_token = getaccess_token($_W);
    $order=pdo_get('wpdc_order',array('id'=>$_GET['id']));
     $sms=pdo_get('wpdc_sms',array('uniacid'=>$_W['uniacid']));
     $sms2=pdo_get('wpdc_sms',array('store_id'=>$order['seller_id'],'uniacid'=>$_W['uniacid']));
      $system=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
      
        if(!$order['note']){
        $order['note']="无";
      }
    //下面是要填充模板的信息
    $formwork ='{
           "touser":"'.$sms2['sj_openid'].'",
           "template_id":"'.$sms['sj_tid'].'",
           "url":"http://weixin.qq.com/download",
           "miniprogram":{
             "appid":"'.$system['appid'].'",
             "pagepath":"zh_dianc/pages/home/home"
           },
           "data":{
                   "first": {
                       "value":"您有新的外卖订单请及时处理!",
                       "color":"#88baf9"
                   },
                   "keyword1": {
                       "value":"'.$order['order_num'].'",
                       "color":"#f76b47"
                   },
                   "keyword2":{
                       "value":"'.$order['money'].'",
                       "color":"#f76b47"
                   },
                   "keyword3":{
                       "value":"'.$order['delivery_time'].'",
                       "color":"#f76b47"
                   },
                   "keyword4":{
                       "value":"'.$order['name'].'/'.$order['tel'].'",
                       "color":"#f76b47"
                   },
                   "keyword5":{
                       "value":"'.$order['address'].'",
                       "color":"#f76b47"
                   },
                   "remark":{
                       "value":"备注:'.$order['note'].'",
                       "color":"#88baf9"
                   }
           }
       }';
    $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$access_token}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$formwork);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
echo set_msg($_W);
}



public function doPageMoBan2(){
  global $_W, $_GPC;
    function getaccess_token($_W){
      $sms=pdo_get('wpdc_sms',array('uniacid'=>$_W['uniacid']));
      $appid = $sms['wx_appid'];
    $appsecret = $sms['wx_secret'];
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
      $data = curl_exec($ch);
      curl_close($ch);
      $data = json_decode($data,true);
      return $data['access_token'];
   }
 
 function set_msg($_W){
    $access_token = getaccess_token($_W);
    $order=pdo_get('wpdc_ydorder',array('id'=>$_GET['id']));
     $sms=pdo_get('wpdc_sms',array('uniacid'=>$_W['uniacid']));
     $sms2=pdo_get('wpdc_sms',array('store_id'=>$order['store_id'],'uniacid'=>$_W['uniacid']));
      $system=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
      $store=pdo_get('wpdc_store',array('id'=>$order['store_id']));
      
    //下面是要填充模板的信息
    $formwork ='{
           "touser":"'.$sms2['sj_openid'].'",
           "template_id":"'.$sms['sj_tid2'].'",
           "url":"http://weixin.qq.com/download",
           "miniprogram":{
             "appid":"'.$system['appid'].'",
             "pagepath":"zh_dianc/pages/home/home"
           },
           "data":{
                   "first": {
                       "value":"您有新的预定订单请及时处理!",
                       "color":"#88baf9"
                   },
                   "keyword1": {
                       "value":"'.$store['name'].'",
                       "color":"#f76b47"
                   },
                   "keyword2":{
                       "value":"'.$order['link_name'].'",
                       "color":"#f76b47"
                   },
                   "keyword3":{
                       "value":"'.$order['table_type_name'].'-'.$order['jc_num'].'人",
                       "color":"#f76b47"
                   },
                   "keyword4":{
                       "value":"'.$order['xz_date'].'  '.$order['yjdd_date'].'",
                       "color":"#f76b47"
                   },
                   "remark":{
                       "value":"备注:'.$order['remark'].'",
                       "color":"#88baf9"
                   }
           }
       }';
    $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$access_token}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$formwork);
    $data = curl_exec($ch);
    curl_close($ch);
  //  return $data;
}
echo set_msg($_W);
}



public function doPageTest(){
 //echo time();die;
       global $_W, $_GPC;
       function getaccess_token($_W){
         $res=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
         $appid="wx17bca7410622986b";
         $secret="0901bacf03fd8e27eeb49ee27fe52ec2";
         $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL,$url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
         $data = curl_exec($ch);
         curl_close($ch);
         $data = json_decode($data,true);
         return $data['access_token'];
       }
      //设置与发送模板信息
       function set_msg($_W){
         $access_token = getaccess_token($_W);
         $formwork ='{
            "card": {
                "card_type": "CASH",
                "cash": {
                    "base_info": {
                        "logo_url": "http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9",
                        "pay_info": {
                            "swipe_card": {
                                "use_mid_list": [
                                    "1449746102"
                                ],
                                "create_mid": "1449746102",
                                "is_swipe_card": true
                            }
                        },
                        "brand_name": "微信餐厅",
                        "code_type": "CODE_TYPE_NONE",
                        "title":"111",
                        "color": "Color010",
                        "service_phone": "020-88888888",
                        "description": "不可与其他优惠同享\n如需团购券发票，请在消费时向商户 提出",
                         "date_info": {
                          "type": "DATE_TYPE_FIX_TIME_RANGE",
                          "begin_timestamp": 1510176179,
                          "end_timestamp": 1521476179
                      },
                        "can_share": false,
                        "center_title": "立即使用",
                        "center_app_brand_user_name": "gh_4167443e74d0@app",
                        "center_app_brand_pass": "zh_dianc/pages/home/home",
                        "can_give_friend": false,
                         "sku": {
                          "quantity": 500000
                      },
                        "get_limit": 30,
                        "custom_url_name": "立即使用",
                        "custom_url": "http://www.qq.com",
                        "custom_url_sub_title": "6个汉字tips",
                        "promotion_url_name": "更多优惠",
                        "promotion_url": "http://www.qq.com"
                    },
                     "advanced_info": {
                       "use_condition": {
                           "accept_category": "鞋类",
                           "reject_category": "阿迪达斯",
                           "can_use_with_other_discount": true,
                           "least_cost":"51"
                       },
                       "abstract": {
                           "abstract": "微信餐厅推出多种新季菜品，期待您的光临",
                           "icon_url_list": [
                               "http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0"
                           ]
                       },
                       "text_image_list": [
                           {
                               "image_url": "http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0",
                               "text": "此菜品精选食材，以独特的烹饪方法，最大程度地刺激食 客的味蕾"
                           },
                           {
                               "image_url": "http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0",
                               "text": "此菜品迎合大众口味，老少皆宜，营养均衡"
                           }
                       ]
                   },


                    "reduce_cost": 5
                }
            }
        }';
             // $formwork=$data;
         $url = "https://api.weixin.qq.com/card/create?access_token=".$access_token."";
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL,$url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
         curl_setopt($ch, CURLOPT_POST,1);
         curl_setopt($ch, CURLOPT_POSTFIELDS,$formwork);
         $data = curl_exec($ch);
         curl_close($ch);
         return $data;
       }
       echo set_msg($_W);
  
}


//人人快递生成订单
public function doPageRrOrder(){
	global $_W, $_GPC;
	$data2['state']=3;
	//订单信息
	$orderInfo=pdo_get('wpdc_order',array('id'=>$_GPC['order_id']));
	$kd=pdo_get('wpdc_store',array('id'=>$orderInfo['seller_id'],'uniacid'=>$_W['uniacid']));
	$rrkd=pdo_get('wpdc_rrset',array('store_id'=>$orderInfo['seller_id'],'uniacid'=>$_W['uniacid']));
	$arr=explode(',',$kd['coordinates']);
	$startlat=$arr[0];
	$startlng=$arr[1];
	preg_match('/(.*?(省|自治区|北京市|天津市))+(.*?(市|自治州))/', $kd['address'], $matches);
	preg_match('/(.*?(省|自治区|北京市|天津市))+(.*?(市|自治州))/', $orderInfo['address'], $matches2);
	include IA_ROOT.'/addons/zh_dianc/rrkd/rrkd.php';
	$userName = $rrkd['username']; // 商户账号 人人快递提供
	$appKey = $rrkd['appkey']; // appKey 人人快递提供
	$timeStamp = @date ( 'Y-m-d' ); // 时间 加入请求头用以校验 【非常重要】
	$interfaceUrl = 'http://code.rrkd.cn/v2/addorderfortdd'; // 下单接口地址【测试环境】
	$sign = strtolower ( md5 ( $appKey . md5 ( $timeStamp ) . strtolower ( md5 ( $userName . $kd['address'] . $orderInfo['address'] ) ) ) ); // 下单接口sign值生成规则请参加文档
	$postData = [  // 参数含义参见文档
	'userName' => $userName,
	'goodsName' => '食品',
	'goodsWeight' => 1,
	'goodsWorth' => ceil($orderInfo['money']),
	'startingLng' => $startlng,
	'startingLat' => $startlat,
	'consigneeLng' => $orderInfo['lng'],
	'consigneeLat' => $orderInfo['lat'],
	'mapFrom' => 1,
	'startingProvince' => $matches[1],
	'startingCity' => $matches[3],
	'startingAddress' => $kd['address'],
	'startingPhone' => $kd['tel'],
	'startingName' => $kd['name'],
	'consigneeName' =>  $orderInfo['name'],
	'consigneePhone' => $orderInfo['tel'],
	'callbackUrl' => 'http://xxxx.com',
	'consigneeProvince' => $matches2[1],
	'consigneeCity' => $matches2[3],
	'consigneeAddress' => $orderInfo['address'],
	'businessNo' => $orderInfo['order_num'], // 商家方订单号
	'dispatchers' => '',
	'payType' => 4,//支付方式
	'serviceFees' => 0,
	'remark' => '这是备注',
	'sign' => $sign,
	'version' => 2.0 
	];
	$header [] = "Content-Type: application/json"; // 指定请求头为application/json 【非常重要】
	$header [] = "timestamp:" . $timeStamp; // 【非常重要】

	$result = Rrkd::curlPost($interfaceUrl, json_encode($postData),10,$header);
	if (! empty ( $result )) {
	$res = json_decode ( $result, true );
	if (! $res ['status']) {
		 echo '下单失败,原因：' . $res ['msg'];
		exit ();
	}
	pdo_update('wpdc_order',array('state'=>3),array('id'=>$_GPC['order_id']));
	echo '下单成功，订单号：' . $res ['orderNo'], '，价格：' . $res ['price'];

	}

}
























}//////////////////////////////////////////////////////////