<?php
global $_GPC, $_W;
$action = 'start';
$storeid=$_COOKIE["storeid"];
pdo_update('wpdc_dmorder',array('state'=>2),array('state'=>0));
$system=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
$cur_store = $this->getStoreById($storeid);
//$GLOBALS['frames'] = $this->getMainMenu2();
$GLOBALS['frames'] = $this->getNaveMenu($storeid, $action);
$where=" where a.uniacid=:uniacid and a.state=2 and a.store_id={$storeid}";
$data[':uniacid']=$_W['uniacid'];
if($_GPC['time']){
    $start=strtotime($_GPC['time']['start']);
    $end=strtotime($_GPC['time']['end']);
    $where.=" and a.time2 >={$start} and a.time2<={$end}";
}
if(!empty($_GPC['keywords'])){
    $where.=" and (c.name LIKE  concat('%', :name,'%') || b.md_name LIKE  concat('%', :name,'%'))";
    $data[':name']=$_GPC['keywords'];   
}
$sql="SELECT a.*,b.md_name,b.poundage as md_poundage,c.name,d.poundage FROM ".tablename('wpdc_dmorder'). " a"  . " left join " . tablename("wpdc_store") . " b on a.store_id=b.id " . " left join " . tablename("wpdc_user") . " c on c.id=a.user_id left join " . tablename("wpdc_storetype") ." d on b.md_type=d.id ".$where."  ORDER BY a.time2 DESC";
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('wpdc_dmorder'). " a"  . " left join " . tablename("wpdc_store") . " b on a.store_id=b.id " . " left join " . tablename("wpdc_user") . " c on c.id=a.user_id left join " . tablename("wpdc_storetype") ." d on b.md_type=d.id ".$where." ORDER BY a.time2 DESC",$data);


$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);


$time=date("Y-m-d");
$time2=date("Y-m-d",strtotime("-1 day"));
$time="'%$time%'";
$time2="'%$time2%'";
$wx = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time." and store_id=".$storeid."  and state=2 and is_yue=2";
$wx = pdo_fetch($wx);//今天的微信外卖销售额
$yue = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time." and store_id=".$storeid."  and state=2 and is_yue=1";
$yue = pdo_fetch($yue);//今天的余额外卖销售额
$jf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time." and store_id=".$storeid."  and state=2 and is_yue=3";
$jf = pdo_fetch($jf);//今天的积分外卖销售额

$ztwx = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time2." and store_id=".$storeid."  and state=2 and is_yue=2";
$ztwx = pdo_fetch($ztwx);//昨天的微信外卖销售额
$ztyue = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time2." and store_id=".$storeid."  and state=2 and is_yue=1";
$ztyue = pdo_fetch($ztyue);//昨天的余额外卖销售额
$ztjf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time2." and store_id=".$storeid."  and state=2 and is_yue=3";
$ztjf = pdo_fetch($ztjf);//昨天的积分外卖销售额






$dm2 = "select * from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time." and store_id=".$storeid." and state=2 and uniacid=".$_W['uniacid'];
$dm2 = count(pdo_fetchall($dm2));//今天外卖订单量
$wxdm2 = "select * from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time." and store_id=".$storeid." and state=2 and is_yue=2 and uniacid=".$_W['uniacid'];
$wxdm2 = count(pdo_fetchall($wxdm2));//今天外卖微信订单量
$yuedm2 = "select * from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time." and store_id=".$storeid." and state=2 and is_yue=1 and uniacid=".$_W['uniacid'];
$yuedm2 = count(pdo_fetchall($yuedm2));//今天外卖余额订单量
$jfdm2 = "select * from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time." and store_id=".$storeid." and state=2 and is_yue=3 and uniacid=".$_W['uniacid'];
$jfdm2 = count(pdo_fetchall($jfdm2));//今天外卖积分订单量




$ztdm2 = "select * from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time2." and store_id=".$storeid." and state=2 and uniacid=".$_W['uniacid'];
$ztdm2 = count(pdo_fetchall($ztdm2));//昨天外卖订单量
$ztwxdm2 = "select * from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time2." and store_id=".$storeid." and state=2 and is_yue=2 and uniacid=".$_W['uniacid'];
$ztwxdm2 = count(pdo_fetchall($ztwxdm2));//昨天外卖微信订单量
$ztyuedm2 = "select * from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time2." and store_id=".$storeid." and state=2 and is_yue=1 and uniacid=".$_W['uniacid'];
$ztyuedm2 = count(pdo_fetchall($ztyuedm2));//昨天外卖余额订单量
$ztjfdm2 = "select * from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time2." and store_id=".$storeid." and state=2 and is_yue=3 and uniacid=".$_W['uniacid'];
$ztjfdm2 = count(pdo_fetchall($ztjfdm2));//昨天外卖积分订单量


if($_GPC['op']=='dy'){
 $res=pdo_get('wpdc_dmorder',array('id'=>$_GPC['order_id']));
  $user=pdo_get('wpdc_user',array('id'=>$res['user_id']));
  $store=pdo_get('wpdc_store',array('id'=>$res['store_id']));
  $res3=pdo_get('wpdc_dyj',array('uniacid'=>$_W['uniacid'],'store_id'=>$res['store_id'],'state'=>1,'location'=>1));
  if($res3['type']!=3){
$content = "\n\n";
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
    message('打印成功！', $this->createWebUrl2('dlindmorder'), 'success');
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
    message('打印成功！', $this->createWebUrl2('dlindmorder'), 'success');
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
  message('打印成功！', $this->createWebUrl2('dlindmorder'), 'success');
}


}
}


include $this->template('web/dlindmorder');