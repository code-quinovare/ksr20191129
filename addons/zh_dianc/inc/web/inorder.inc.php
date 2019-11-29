<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$system=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
$time=time()-($system['day']*24*60*60);
pdo_update('wpdc_order',array('state'=>4),array('state'=>3,'time <='=>$time));
$where=" where a.uniacid=:uniacid and a.type=1 and a.seller_id={$storeid}";
$data[':uniacid']=$_W['uniacid']; 
$pageindex = max(1, intval($_GPC['page']));
$pagesize=8;
$type=isset($_GPC['type'])?$_GPC['type']:'now';
if(isset($_GPC['keywords'])){
    $where.=" and (a.name LIKE  concat('%', :name,'%') || a.order_num LIKE  concat('%', :name,'%') || b.md_name LIKE  concat('%', :name,'%'))";
    $data[':name']=$_GPC['keywords'];   
    $type='all';
}
if($_GPC['time']){
    $start=strtotime($_GPC['time']['start']);
    $end=strtotime($_GPC['time']['end']);
    $where.=" and a.time2 >={$start} and a.time2<={$end}";
    $type='all';
}else{
 if($type=='wait'){
    $where.=" and a.state=1";
}
if($type=='now'){
    $where.=" and a.state=2";
}
if($type=='cancel'){
    $where.=" and a.state in (5,9,7,8)";
}
if($type=='complete'){
    $where.=" and a.state=4";
}
if($type=='delivery'){
    $where.=" and a.state=3";
}
if($type=='zt'){
    $where.=" and a.is_take=1";
} 
}


$sql="SELECT a.*,b.md_name,b.poundage as md_poundage,c.poundage FROM ".tablename('wpdc_order'). " a"  . " left join " . tablename("wpdc_store") . " b on a.seller_id=b.id " . " left join " . tablename("wpdc_storetype") . " c on b.md_type=c.id ".$where." ORDER BY a.time2 DESC";
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('wpdc_order'). " a"  . " left join " . tablename("wpdc_store") . " b on a.seller_id=b.id  " . " left join " . tablename("wpdc_storetype") . " c on b.md_type=c.id ".$where." ORDER BY a.time2 DESC",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$pager = pagination($total, $pageindex, $pagesize);
$list=pdo_fetchall($select_sql,$data);
 $res2=pdo_getall('wpdc_goods');
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
          'dishes_id'=>$res2[$k]['dishes_id']
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



$wx = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid." and state  in (4,6,9) and is_yue=2 and type=1 and pay_time !=''";
$wx = pdo_fetch($wx);//今天的微信外卖销售额
$yue = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid." and state  in (4,6,9) and is_yue=1 and type=1 and pay_time !=''";
$yue = pdo_fetch($yue);//今天的余额外卖销售额
$jf = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid." and state  in (4,6,9) and is_yue=3 and type=1 and pay_time !=''";
$jf = pdo_fetch($jf);//今天的积分外卖销售额

$ztwx = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time2." and seller_id=".$storeid." and state  in (4,6,9) and is_yue=2 and type=1 and pay_time !=''";
$ztwx = pdo_fetch($ztwx);//昨天的微信外卖销售额
$ztyue = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time2." and seller_id=".$storeid." and state  in (4,6,9) and is_yue=1 and type=1 and pay_time !=''";
$ztyue = pdo_fetch($ztyue);//昨天的余额外卖销售额
$ztjf = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time2." and seller_id=".$storeid." and state  in (4,6,9) and is_yue=3 and type=1 and pay_time !=''";
$ztjf = pdo_fetch($ztjf);//昨天的积分外卖销售额






$wm2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid."  and type=1 and state  in (4,6,9) and uniacid=".$_W['uniacid'];
$wm2 = count(pdo_fetchall($wm2));//今天外卖订单量
$wxwm2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid."  and type=1 and state  in (4,6,9) and is_yue=2 and uniacid=".$_W['uniacid'];
$wxwm2 = count(pdo_fetchall($wxwm2));//今天外卖微信订单量
$yuewm2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid."  and type=1 and state  in (4,6,9) and is_yue=1 and uniacid=".$_W['uniacid'];
$yuewm2 = count(pdo_fetchall($yuewm2));//今天外卖余额订单量
$jfwm2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid."  and type=1 and state  in (4,6,9) and is_yue=3 and uniacid=".$_W['uniacid'];
$jfwm2 = count(pdo_fetchall($jfwm2));//今天外卖积分订单量




$ztwm2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time2."  and seller_id=".$storeid." and type=1 and state  in (4,6,9) and uniacid=".$_W['uniacid'];
$ztwm2 = count(pdo_fetchall($ztwm2));//昨天外卖订单量
$ztwxwm2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time2."  and seller_id=".$storeid." and type=1 and state  in (4,6,9) and is_yue=2 and uniacid=".$_W['uniacid'];
$ztwxwm2 = count(pdo_fetchall($ztwxwm2));//昨天外卖微信订单量
$ztyuewm2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time2." and seller_id=".$storeid."  and type=1 and state  in (4,6,9) and is_yue=1 and uniacid=".$_W['uniacid'];
$ztyuewm2 = count(pdo_fetchall($ztyuewm2));//昨天外卖余额订单量
$ztjfwm2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time2." and seller_id=".$storeid."  and type=1 and state  in (4,6,9) and is_yue=3 and uniacid=".$_W['uniacid'];
$ztjfwm2 = count(pdo_fetchall($ztjfwm2));//昨天外卖积分订单量




if($_GPC['op']=='jd'){
    $data2['state']=3;
    	//获取快递设置
	$kd=pdo_get('wpdc_store',array('id'=>$storeid,'uniacid'=>$_W['uniacid']));
	$rrkd=pdo_get('wpdc_rrset',array('store_id'=>$storeid,'uniacid'=>$_W['uniacid']));
	//订单信息
	$orderInfo=pdo_get('wpdc_order',array('id'=>$_GPC['id']));
	//var_dump($orderInfo);die;
	$arr=explode(',',$kd['coordinates']);
	$startlat=$arr[0];
	$startlng=$arr[1];
	preg_match('/(.*?(省|自治区|北京市|天津市))+(.*?(市|自治州))/', $kd['address'], $matches);
	preg_match('/(.*?(省|自治区|北京市|天津市))+(.*?(市|自治州))/', $orderInfo['address'], $matches2);
  //var_dump($matches2);die;
	if($kd['ps_mode']==4&&$orderInfo['is_take']==2){
	//调人人快递
	include IA_ROOT.'/addons/zh_dianc/rrkd/rrkd.php';
	$userName = $rrkd['username']; // 商户账号 人人快递提供
	$appKey = $rrkd['appkey']; // appKey 人人快递提供
	$timeStamp = @date ( 'Y-m-d' ); // 时间 加入请求头用以校验 【非常重要】
	$interfaceUrl = 'http://code.rrkd.cn/v2/addorderfortdd'; // 下单接口地址【测试环境】
	//$startingAddress = '青羊区少城路12号'; // 发货地
	//$consigneeAddress = '青羊区少城大厦802'; // 收货地

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
	'businessNo' =>$orderInfo['order_num'], // 商家方订单号
	'dispatchers' => '',
	'payType' => 4,//支付方式
	'serviceFees' => 0,
	'remark' => $orderInfo['note'],
	'sign' => $sign,
	'version' => 2.0 
	];

	//var_dump($postData);die;

	$header [] = "Content-Type: application/json"; // 指定请求头为application/json 【非常重要】
	$header [] = "timestamp:" . $timeStamp; // 【非常重要】

	$result = Rrkd::curlPost($interfaceUrl, json_encode($postData),10,$header);
	if (! empty ( $result )) {
	$res = json_decode ( $result, true );
	if (! $res ['status']) {
		 message('接单失败！','','error');
		exit ();
	}
	pdo_update('wpdc_order',$data2,array('id'=>$_GPC['id']));
	message('接单成功！', $this->createWebUrl('inorder'), 'success');

	}
}else{
    $res=pdo_update('wpdc_order',$data2,array('id'=>$_GPC['id']));
if($res){
        message('接单成功！', $this->createWebUrl('inorder'), 'success');
    }else{
        message('接单失败！','','error');
    }
}
}

if(checksubmit('export_submit', true)) {
    $time=date("Y-m-d");
    $time="'%$time%'";
        $count = pdo_fetchcolumn("SELECT COUNT(*) FROM". tablename("wpdc_order")." WHERE time LIKE ".$time."and type=1 and seller_id =".$storeid);
        $pagesize = ceil($count/5000);
        //array_unshift( $names,  '活动名称'); 
        $header = array(
            'item'=>'序号',
            'md_name' => '门店名称',
           'order_num' => '订单号', 
           'name' => '联系人', 
           'tel' => '联系电话',
           'address' => '联系地址',
           'time' => '下单时间',
           'money' => '金额',
           'state' => '外卖状态',
           // 'dn_state' => '店内状态',
           'goods' => '商品'

        );

        $keys = array_keys($header);
        $html = "\xEF\xBB\xBF";
        foreach ($header as $li) {
            $html .= $li . "\t ,";
        }
        $html .= "\n";
        for ($j = 1; $j <= $pagesize; $j++) {
            $sql = "select a.*,b.md_name from " . tablename("wpdc_order")."  a"  . " inner join " . tablename("wpdc_store")." b on a.seller_id=b.id  WHERE a.time LIKE ".$time." and a.type=1 and a.seller_id =".$storeid." limit " . ($j - 1) * 5000 . ",5000 ";
            $list = pdo_fetchall($sql);
   
            

        }
            if (!empty($list)) {
                $size = ceil(count($list) / 500);
                for ($i = 0; $i < $size; $i++) {
                    $buffer = array_slice($list, $i * 500, 500);
                    $user = array();
                    foreach ($buffer as $k =>$row) {
                        $row['item']= $k+1;
                        if($row['state']==0){
                            $row['state']='无状态';
                        }elseif($row['state']==1){
                            $row['state']='待付款';
                        }elseif($row['state']==2){
                            $row['state']='等待接单';
                        }elseif($row['state']==3){
                            $row['state']='等待送达';
                        }elseif($row['state']==4){
                            $row['state']='完成';
                        }elseif($row['state']==5){
                            $row['state']='取消订单';
                        }elseif($row['state']==6){
                            $row['state']='评论完成';
                        }elseif($row['state']==7){
                            $row['state']='待退款';
                        }elseif($row['state']==8){
                            $row['state']='退款成功';
                        }elseif($row['state']==9){
                            $row['state']='退款失败';
                        }
                        // if($row['dn_state']==0){
                        //     $row['dn_state']='无状态';
                        // }elseif($row['dn_state']==1){
                        //     $row['dn_state']='待付款';
                        // }elseif($row['dn_state']==2){
                        //     $row['dn_state']='已完成';
                        // }elseif($row['dn_state']==3){
                        //     $row['dn_state']='关闭订单';
                        // }elseif($row['dn_state']==4){
                        //     $row['dn_state']='已评论';
                        // }
                        $good=pdo_getall('wpdc_goods',array('order_id'=>$row['id']));
                        $date6='';
                        for($i=0;$i<count($good);$i++){
                            $date6 .=$good[$i]['name'].'*'.$good[$i]['number']."  ";
                        }
                        $row['goods']=$date6;
                        foreach ($keys as $key) {
                            $data5[] = $row[$key];
                        }
                        $user[] = implode("\t ,", $data5) . "\t ,";
                        unset($data5);
                    }
                    $html .= implode("\n", $user) . "\n";
                }
            }
        
        header("Content-type:text/csv");
        header("Content-Disposition:attachment; filename=今日外卖订单数据.csv");
        echo $html;
        exit();
    }

    if($_GPC['op']=='delete'){
    $res=pdo_delete('wpdc_order',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('inorder'), 'success');
        }else{
              message('删除失败！','','error');
        }
}


    if($_GPC['op']=='tg'){
        $id=$_GPC['id'];
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
           
            //var_dump($result);die;
            if ($result['result_code'] == 'SUCCESS') {//退款成功
           pdo_update('wpdc_order',array('state'=>8),array('id'=>$id));
           message('退款成功',$this->createWebUrl('inorder',array()),'success');
         
      
                

    }else{
        message('退款失败','','error');
        


}
}
if($_GPC['op']=='jj'){
    $res=pdo_update('wpdc_order',array('state'=>9),array('id'=>$_GPC['id']));
    if($res){
        message('拒绝退款成功',$this->createWebUrl('inorder',array()),'success');
    }else{
 message('拒绝退款失败','','error');
    }
}
if($_GPC['op']=='dy'){

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
message('打印成功！', $this->createWebUrl('inorder'), 'success');
return $result;
}
if($res3['type']==2){//易联云
  require IA_ROOT.'/addons/zh_dianc/print.class.php';
  $print = new Yprint();
  $apiKey = $res3['api'];
  $msign = $res3['token'];
  $partner=$res3['yy_id'];
  $machine_code=$res3['mid'];
 
//打印
  $print->action_print( $partner,$machine_code,$content,$apiKey,$msign);
  message('打印成功！', $this->createWebUrl('inorder'), 'success');
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
include IA_ROOT.'/addons/zh_dianc/HttpClient.class.php';
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
    return  $client->getContent();
   
  }
  
}
$rst=wp_print(SN,$content,1);
$rst2=json_decode($rst);
if($rst2->msg=='ok'){
  message('打印成功！', $this->createWebUrl('inorder'), 'success');
}
}
}
include $this->template('web/inorder');