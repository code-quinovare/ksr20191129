<?php
global $_GPC, $_W;
$storeid=$_COOKIE["storeid"]; 
$cur_store = $this->getStoreById($storeid);
// $system=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
// $time=time()-($system['day']*24*60*60);
// pdo_update('wpdc_order',array('state'=>4),array('state'=>3,'time <='=>$time));
$GLOBALS['frames'] = $this->getMainMenu2();
$pageindex = max(1, intval($_GPC['page']));
$pagesize=8;
$type=isset($_GPC['type'])?$_GPC['type']:'now';
$where=" where uniacid=:uniacid and store_id=".$storeid;
$data[':uniacid']=$_W['uniacid']; 
if(isset($_GPC['keywords'])){
    $where.=" and (user_name LIKE  concat('%', :name,'%') || order_num LIKE  concat('%', :name,'%'))";
    $data[':name']=$_GPC['keywords']; 
    $type='all';  
}
if($_GPC['time']){
    $start=strtotime($_GPC['time']['start']);
    $end=strtotime($_GPC['time']['end']);
    $where.=" and UNIX_TIMESTAMP(time) >={$start} and UNIX_TIMESTAMP(time) <={$end}";
    $type='all';
}else{
 if($type=='wait'){
    $where.=" and state=1";
}
if($type=='now'){
    $where.=" and state=2";
}
if($type=='cancel'){
    $where.=" and state in (6,7,8)";
}
if($type=='complete'){
    $where.=" and state in (4,5)";
}
if($type=='delivery'){
    $where.=" and state=3";
}
if($type=='zt'){
    $where.=" and is_zt=1";
} 
}



$sql="SELECT * FROM ".tablename('zhvip_shoporder'). "  ".$where." ORDER BY time DESC";

$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('zhvip_shoporder'). "  ".$where." ORDER BY time DESC",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$pager = pagination($total, $pageindex, $pagesize);
$list=pdo_fetchall($select_sql,$data);

 $res2=pdo_getall('zhvip_ordergoods');
  $data3=array();
  for($i=0;$i<count($list);$i++){
    $data4=array();
    for($k=0;$k<count($res2);$k++){
      if($list[$i]['id']==$res2[$k]['order_id']){
        $data4[]=array(
          'name'=>$res2[$k]['name'],
          'num'=>$res2[$k]['number'],
          'img'=>$res2[$k]['img'],
          'money'=>$res2[$k]['money'],
          'spec'=>$res2[$k]['spec'],
          'good_id'=>$res2[$k]['good_id']
          );
      }
    }
    $data3[]=array(
      'order'=> $list[$i],
      'goods'=>$data4
      );
  }
//print_r($data3);die;
$time=date("Y-m-d");
$time2=date("Y-m-d",strtotime("-1 day"));
$time="'%$time%'";
$time2="'%$time2%'";

$wx = "select sum(money) as total from " . tablename("zhvip_shoporder")." WHERE time LIKE ".$time."  and state  in (4,5,8) and pay_type=1 and store_id=".$storeid;
$wx = pdo_fetch($wx);//今天的微信外卖销售额
$yue = "select sum(money) as total from " . tablename("zhvip_shoporder")." WHERE time LIKE ".$time."  and state  in (4,5,8) and pay_type=2 and store_id=".$storeid;
$yue = pdo_fetch($yue);//今天的余额外卖销售额
$jf = "select sum(money) as total from " . tablename("zhvip_shoporder")." WHERE time LIKE ".$time."  and state  in (4,5,8) and pay_type=3 and store_id=".$storeid;
$jf = pdo_fetch($jf);//今天的积分外卖销售额

$ztwx = "select sum(money) as total from " . tablename("zhvip_shoporder")." WHERE time LIKE ".$time2."  and state  in (4,5,8) and pay_type=1 and store_id=".$storeid;
$ztwx = pdo_fetch($ztwx);//昨天的微信外卖销售额
$ztyue = "select sum(money) as total from " . tablename("zhvip_shoporder")." WHERE time LIKE ".$time2."  and state  in (4,5,8) and pay_type=2 and store_id=".$storeid;
$ztyue = pdo_fetch($ztyue);//昨天的余额外卖销售额
$ztjf = "select sum(money) as total from " . tablename("zhvip_shoporder")." WHERE time LIKE ".$time2."  and state  in (4,5,8) and pay_type=3 and store_id=".$storeid;
$ztjf = pdo_fetch($ztjf);//昨天的积分外卖销售额






$wm2 = "select * from " . tablename("zhvip_shoporder")." WHERE time LIKE ".$time."   and state  in (4,5,8) and uniacid=".$_W['uniacid'] ." and store_id=".$storeid;
$wm2 = count(pdo_fetchall($wm2));//今天外卖订单量
$wxwm2 = "select * from " . tablename("zhvip_shoporder")." WHERE time LIKE ".$time."   and state  in (4,5,8) and pay_type=1 and uniacid=".$_W['uniacid']." and store_id=".$storeid;
$wxwm2 = count(pdo_fetchall($wxwm2));//今天外卖微信订单量
$yuewm2 = "select * from " . tablename("zhvip_shoporder")." WHERE time LIKE ".$time."   and state  in (4,5,8) and pay_type=2 and uniacid=".$_W['uniacid']." and store_id=".$storeid;
$yuewm2 = count(pdo_fetchall($yuewm2));//今天外卖余额订单量
$jfwm2 = "select * from " . tablename("zhvip_shoporder")." WHERE time LIKE ".$time."   and state  in (4,5,8) and pay_type=3 and uniacid=".$_W['uniacid']." and store_id=".$storeid;
$jfwm2 = count(pdo_fetchall($jfwm2));//今天外卖积分订单量




$ztwm2 = "select * from " . tablename("zhvip_shoporder")." WHERE time LIKE ".$time2."   and state  in (4,5,8) and uniacid=".$_W['uniacid']." and store_id=".$storeid;
$ztwm2 = count(pdo_fetchall($ztwm2));//昨天外卖订单量
$ztwxwm2 = "select * from " . tablename("zhvip_shoporder")." WHERE time LIKE ".$time2."   and state  in (4,5,8) and pay_type=1 and uniacid=".$_W['uniacid']." and store_id=".$storeid;
$ztwxwm2 = count(pdo_fetchall($ztwxwm2));//昨天外卖微信订单量
$ztyuewm2 = "select * from " . tablename("zhvip_shoporder")." WHERE time LIKE ".$time2."   and state  in (4,5,8) and pay_type=2 and uniacid=".$_W['uniacid']." and store_id=".$storeid;
$ztyuewm2 = count(pdo_fetchall($ztyuewm2));//昨天外卖余额订单量
$ztjfwm2 = "select * from " . tablename("zhvip_shoporder")." WHERE time LIKE ".$time2."   and state  in (4,5,8) and pay_type=3 and uniacid=".$_W['uniacid']." and store_id=".$storeid;
$ztjfwm2 = count(pdo_fetchall($ztjfwm2));//昨天外卖积分订单量








if(checksubmit('submit3')){
    $res=pdo_update('zhvip_shoporder',array('state'=>3,'kd_num'=>$_GPC['reply'],'kd_name'=>$_GPC['reply2']),array('id'=>$_GPC['fh_id']));
    if($res){
        message('发货成功！', $this->createWebUrl('mallorder'), 'success');
    }else{
        message('发货失败！','','error');
    }
}







// if($_GPC['op']=='jd'){
//     $data2['state']=3;
//     $res=pdo_update('wpdc_order',$data2,array('id'=>$_GPC['id']));
//     if($res){
//         message('接单成功！', $this->createWebUrl('order'), 'success');
//     }else{
//         message('接单失败！','','error');
//     }
// }
if($_GPC['op']=='wc'){
    $data2['state']=4;
    $data2['complete_time']=date("Y-m-d H:i:s");
    $res=pdo_update('zhvip_shoporder',$data2,array('id'=>$_GPC['id']));
    if($res){
        message('完成成功！', $this->createWebUrl('mallorder'), 'success');
    }else{
        message('完成失败！','','error');
    }

}


// if(checksubmit('export_submit', true)) {
//     $time=date("Y-m-d");
//     $time="'%$time%'";
//         $count = pdo_fetchcolumn("SELECT COUNT(*) FROM". tablename("wpdc_order")." WHERE type=1 and time LIKE ".$time);
//         $pagesize = ceil($count/5000);
//         //array_unshift( $names,  '活动名称'); 

//         $header = array(
//             'item'=>'序号',
//             'md_name' => '门店名称',
//            'order_num' => '订单号', 
//            'name' => '联系人', 
//            'tel' => '联系电话',
//            'address' => '联系地址',
//            'time' => '下单时间',
//            'money' => '金额',
//            'state' => '外卖状态',
//            // 'dn_state' => '店内状态',
//            'goods' => '商品'

//         );

        
        
//         $keys = array_keys($header);
//         $html = "\xEF\xBB\xBF";
//         foreach ($header as $li) {
//             $html .= $li . "\t ,";
//         }
//         $html .= "\n";
//         for ($j = 1; $j <= $pagesize; $j++) {
//             $sql = "select a.*,b.md_name from " . tablename("wpdc_order")."  a"  . " inner join " . tablename("wpdc_store")." b on a.seller_id=b.id  WHERE a.type=1 and a.time LIKE ".$time."  limit " . ($j - 1) * 5000 . ",5000 ";
//             $list = pdo_fetchall($sql);
   
            

//         }
//             if (!empty($list)) {
//                 $size = ceil(count($list) / 500);
//                 for ($i = 0; $i < $size; $i++) {
//                     $buffer = array_slice($list, $i * 500, 500);
//                     $user = array();
//                     foreach ($buffer as $k =>$row) {
//                         $row['item']= $k+1;
//                         if($row['state']==0){
//                             $row['state']='无状态';
//                         }elseif($row['state']==1){
//                             $row['state']='待付款';
//                         }elseif($row['state']==2){
//                             $row['state']='等待接单';
//                         }elseif($row['state']==3){
//                             $row['state']='等待送达';
//                         }elseif($row['state']==4){
//                             $row['state']='完成';
//                         }elseif($row['state']==5){
//                             $row['state']='取消订单';
//                         }elseif($row['state']==6){
//                             $row['state']='评论完成';
//                         }elseif($row['state']==7){
//                             $row['state']='待退款';
//                         }elseif($row['state']==8){
//                             $row['state']='退款成功';
//                         }elseif($row['state']==9){
//                             $row['state']='退款失败';
//                         }

//                         // if($row['dn_state']==0){
//                         //     $row['dn_state']='无状态';
//                         // }elseif($row['dn_state']==1){
//                         //     $row['dn_state']='待付款';
//                         // }elseif($row['dn_state']==2){
//                         //     $row['dn_state']='已完成';
//                         // }elseif($row['dn_state']==3){
//                         //     $row['dn_state']='关闭订单';
//                         // }elseif($row['dn_state']==4){
//                         //     $row['dn_state']='已评论';
//                         // }
//                         $good=pdo_getall('wpdc_goods',array('order_id'=>$row['id']));
//                         for($i=0;$i<count($good);$i++){
//                             $date6='';
//                             $date6 .=$good[$i]['name'].'*'.$good[$i]['number']."  ";
//                         }
//                         $row['goods']=$date6;
//                         foreach ($keys as $key) {
//                             $data5[] = $row[$key];
//                         }
//                         $user[] = implode("\t ,", $data5) . "\t ,";
//                         unset($data5);
//                     }
//                     $html .= implode("\n", $user) . "\n";
//                 }
//             }
        
//         header("Content-type:text/csv");
//         header("Content-Disposition:attachment; filename=今日外卖订单数据.csv");
//         echo $html;
//         exit();
//     }

// if($_GPC['op']=='dy'){

//  $res=pdo_get('wpdc_order',array('id'=>$_GPC['order_id']));
//   $res3=pdo_get('wpdc_dyj',array('uniacid'=>$_W['uniacid'],'store_id'=>$res['seller_id'],'state'=>1,'location'=>1));
//   $res2=pdo_getall('wpdc_goods',array('order_id'=>$_GPC['order_id']));
// if($res['is_yue']==1){
//   $is_yue="余额支付";
// }elseif($res['is_yue']==2){
//   $is_yue="微信支付";
// }elseif($res['is_yue']==3){
//   $is_yue="积分支付";
// }
// if($res['is_take']==1){
//   $is_take= "店内自提\n";
// }
// if($res3['type']!=3){
//  $content = "\n\n\n\n";
//   $content .= "         订单编号  #".$res['id']." \n\n";
//   $content .= "          ".$is_take." \n";
//   $content .= "          ".$res3['dyj_title']."\n\n";
//   $content .= "----------".$is_yue."------------\n";
//   $content .= "--------------------------------\n";
//   $content .= "下单时间：".$res['time']."\n";
//   $content .= "--------------------------------\n";
//   if($res['is_take']==1){
//   $content .= "自提时间：".$res['delivery_time']."\n";
//   $content .= "--------------------------------\n";
// }
//   $content .='名称'.str_repeat(" ",15)."数量  价格\n";
//   $content .= "--------------------------------\n";
//   $name='';
// for($i=0;$i<count($res2);$i++){
//   $name=$res2[$i]['name'];
//   $content .= "".$name."\n";
//   $content .=str_repeat(" ",20).$res2[$i]['number']."   ".number_format($res2[$i]['number']*$res2[$i]['money'],2)."\n";
// }
// $content .= "--------------------------------\n";
// $content .= "餐盒费：　　　　　　　　".$res['box_fee']."\n";
// $content .= "--------------------------------\n";
// $content .= "配送费：　　　　　　　　".$res['freight']."\n";
// $content .= "--------------------------------\n";
// $content .= "优惠：　　　　　　　　 -".number_format($res['preferential'],2)."\n";
// $content .= "--------------------------------\n";
// $content .= "已付：　　　　　　　　　".$res['money']."\n";
// $content .= "--------------------------------\n";
// $content .= "送货地点：".$res['address']."\n\n";
// $content .= "联系电话：".$res['tel']."\n\n";
// $content .= "联系人：".$res['name']."\n\n";

// if($res['note']){
//   $content .= "备注：".$res['note']."\n\n\n\n\n\n";
// }
// }
// // $content .= "^Q +https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzI1NTQ5NDQzMQ==&scene=124#wechat_redirect";
//     //echo 1;die;
// if($res3['type']==1){//365打印
    
// $selfMessage = array(
//   'deviceNo'=>$res3['dyj_id'],  
//   'printContent'=>$content,
//   'key'=>$res3['dyj_key'],
//   'times'=>'1'
//   );        
// $url = "http://open.printcenter.cn:8080/addOrder";
// $options = array(
//   'http' => array(
//     'header' => "Content-type: application/x-www-form-urlencoded ",
//     'method'  => 'POST',
//     'content' => http_build_query($selfMessage),
//     ),
//   );
// $context  = stream_context_create($options);
// $result = file_get_contents($url, false, $context);
// message('打印成功！', $this->createWebUrl('order'), 'success');
// return $result;
// }
// if($res3['type']==2){//易联云
//   require IA_ROOT.'/addons/zh_vip/print.class.php';
//   $print = new Yprint();
//   $apiKey = $res3['api'];
//   $msign = $res3['token'];
//   $partner=$res3['yy_id'];
//   $machine_code=$res3['mid'];
 
// //打印
//   $print->action_print( $partner,$machine_code,$content,$apiKey,$msign);
//   message('打印成功！', $this->createWebUrl('order'), 'success');
// }
// if($res3['type']==3){//飞蛾
//   $content .= "　　　　　订单编号  #".$res['id']." <BR>";
//   $content .= "　　　　　".$is_take." \n";
//   $content .= "          ".$res3['dyj_title']."<BR>";
//   $content .= "-------------".$is_yue."-----------<BR>";
//   $content .= "--------------------------------<BR>";
//   $content .= "下单时间：".$res['time']."<BR>";
//   $content .= "--------------------------------<BR>";
//   if($res['is_take']==1){
//   $content .= "自提时间：".$res['delivery_time']."<BR>";
//   $content .= "--------------------------------<BR>";
// }
//   $content .="名称　　　　　 数量　  单价 <BR>";
//   $content .= "-------------------------------<BR>";
//   $name='';
// for($i=0;$i<count($res2);$i++){
//   $name=$res2[$i]['name'];
//   $content .= "".$name."<BR>";
//   $content .="　　　　　　 　　".$res2[$i]['number']." 　 ".number_format($res2[$i]['number']*$res2[$i]['money'],2)."<BR>";
// }
// $content .= "--------------------------------<BR>";
// $content .= "餐盒费：　　　　　　　".$res['box_fee']."<BR>";
// $content .= "--------------------------------<BR>";
// $content .= "配送费：　　　　　　　".$res['freight']."<BR>";
// $content .= "--------------------------------<BR>";
// $content .= "优惠：　　　　　　　　-".number_format($res['preferential'],2)."<BR>";
// $content .= "--------------------------------<BR>";
// $content .= "已付：　　　　　　　  ".$res['money']."<BR>";
// $content .= "--------------------------------<BR>";
// $content .= "送货地点：".$res['address']."<BR><BR>";
// $content .= "联系电话：".$res['tel']."<BR><BR>";
// $content .= "联系人：".$res['name']."<BR><BR>";

// if($res['note']){
//   $content .= "备注：".$res['note']."<BR><BR><BR>";
// }
//  header("Content-type: text/html; charset=utf-8");
// include IA_ROOT.'/addons/zh_vip/HttpClient.class.php';
// define('USER', $res3['fezh']); //*必填*：飞鹅云后台注册账号
// define('UKEY', $res3['fe_ukey']); //*必填*: 飞鹅云注册账号后生成的UKEY
// define('SN', $res3['fe_dycode']);    //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API
// //以下参数不需要修改
// define('IP','api.feieyun.cn');      //接口IP或域名
// define('PORT',80);            //接口IP端口
// define('PATH','/Api/Open/');    //接口路径
// define('STIME', time());          //公共参数，请求时间
// define('SIG', sha1(USER.UKEY.STIME));
// function wp_print($printer_sn,$orderInfo,$times){
//     $content = array(     
//       'user'=>USER,
//       'stime'=>STIME,
//       'sig'=>SIG,
//       'apiname'=>'Open_printMsg',

//       'sn'=>$printer_sn,
//       'content'=>$orderInfo,
//         'times'=>$times//打印次数
//     );
    
//   $client = new HttpClient(IP,PORT);
//   if(!$client->post(PATH,$content)){
//     echo 'error';
//   }
//   else{
//     //服务器返回的JSON字符串，建议要当做日志记录起来
//     return  $client->getContent();
   
//   }
  
// }
// $rst=wp_print(SN,$content,1);
// $rst2=json_decode($rst);
// if($rst2->msg=='ok'){
//   message('打印成功！', $this->createWebUrl('order'), 'success');
// }

// }
// }




    if($_GPC['op']=='delete'){
    $res=pdo_delete('zhvip_shoporder',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('mallorder'), 'success');
        }else{
              message('删除失败！','','error');
        }
}

 if($_GPC['op']=='tg'){
        $id=$_GPC['id'];
        include_once IA_ROOT . '/addons/zh_vip/cert/WxPay.Api.php';
        load()->model('account');
        load()->func('communication');
        $WxPayApi = new WxPayApi();
        $input = new WxPayRefund();
       //$path_cert = IA_ROOT . '/addons/zh_vip/cert/apiclient_cert.pem';
       // $path_key = IA_ROOT . '/addons/zh_vip/cert/apiclient_key.pem';
        $path_cert = IA_ROOT . "/addons/zh_vip/cert/".'apiclient_cert_' . $_W['uniacid'] . '.pem';
        $path_key = IA_ROOT . "/addons/zh_vip/cert/".'apiclient_key_' . $_W['uniacid'] . '.pem';
        $account_info = $_W['account'];
        $refund_order =pdo_get('zhvip_shoporder',array('id'=>$id));  
        $res=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
        $appid=$res['appid'];
        $key=$res['wxkey'];
        $mchid=$res['mchid']; 
        //print_r( $refund_order );die;
        $out_trade_no=$refund_order['code'];//商户订单号
        $fee = $refund_order['money'] * 100;
            //$refundid = $refund_order['transid'];
            //$refundid='4200000022201710178579320894';
            $input->SetAppid($appid);
            $input->SetMch_id($mchid);
            $input->SetOp_user_id($mchid);
            $input->SetRefund_fee($fee);
            $input->SetTotal_fee($fee);
           // $input->SetTransaction_id($refundid);
            $input->SetOut_refund_no($refund_order['order_num']);
            $input->SetOut_trade_no($out_trade_no);
            $result = $WxPayApi->refund($input, 6, $path_cert, $path_key, $key);
           
     //var_dump($result);die;
            if ($result['result_code'] == 'SUCCESS') {//退款成功
           pdo_update('zhvip_shoporder',array('state'=>7),array('id'=>$id));
           message('退款成功',$this->createWebUrl('mallorder',array()),'success');
         
    }else{
        message($result['err_code_des'],'','error');
}
}

if($_GPC['op']=='jj'){
    $res=pdo_update('zhvip_shoporder',array('state'=>8),array('id'=>$_GPC['id']));
    if($res){
        message('拒绝退款成功',$this->createWebUrl('mallorder',array()),'success');
    }else{
       message('拒绝退款失败','','error');
    }
}
include $this->template('web/mallorder');