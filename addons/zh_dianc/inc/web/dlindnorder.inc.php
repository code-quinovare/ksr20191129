<?php
global $_GPC, $_W;
load()->func('tpl');
$action = 'start';
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid, $action);
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$type=isset($_GPC['type'])?$_GPC['type']:'all';
$where=" where a.uniacid=:uniacid and a.type=2 and a.seller_id={$storeid}";
$data[':uniacid']=$_W['uniacid'];
if($_GPC['time']){
    $start=strtotime($_GPC['time']['start']);
    $end=strtotime($_GPC['time']['end']);
    $where.=" and a.time2 >={$start} and a.time2<={$end}";
}
if(!empty($_GPC['keywords'])){
    $where.=" and (a.order_num LIKE  concat('%', :name,'%') || d.md_name LIKE  concat('%', :name,'%'))";
    $data[':name']=$_GPC['keywords'];   
}
if($type=='wait'){
    $where.=" and a.dn_state=1";
}
if($type=='complete'){
    $where.=" and a.dn_state=2";
}
if($type=='close'){
    $where.=" and a.dn_state=3";
}
$sql="SELECT a.*,b.name,b.status as t_status,c.name as tablename,d.md_name,d.poundage as md_poundage,e.poundage FROM ".tablename('wpdc_order'). " a"  . " left join " . tablename("wpdc_table") . " b on a.table_id=b.id  left join " . tablename("wpdc_table_type") ." c on b.type_id=c.id left join " . tablename("wpdc_store") ." d on a.seller_id=d.id left join " . tablename("wpdc_storetype") ." e on d.md_type=e.id ".$where." ORDER BY a.time2 DESC";
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('wpdc_order'). " a"  . " left join " . tablename("wpdc_table") . " b on a.table_id=b.id left join " . tablename("wpdc_table_type") ." c on b.type_id=c.id left join " . tablename("wpdc_store") ." d on a.seller_id=d.id  left join " . tablename("wpdc_storetype") ." e on d.md_type=e.id ".$where." ORDER BY a.time2 DESC",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
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
//var_dump($data3);die;
$pager = pagination($total, $pageindex, $pagesize);
$time=date("Y-m-d");
$time2=date("Y-m-d",strtotime("-1 day"));
$time="'%$time%'";
$time2="'%$time2%'";

$wx = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time."  and dn_state=2 and seller_id=".$storeid." and is_yue=2 and type=2 and pay_time !=''";
$wx = pdo_fetch($wx);//今天的微信店内销售额
$yue = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time."  and dn_state=2 and seller_id=".$storeid." and is_yue=1 and type=2 and pay_time !=''";
$yue = pdo_fetch($yue);//今天的余额店内销售额
$jf = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time."  and dn_state=2 and seller_id=".$storeid." and is_yue=3 and type=2 and pay_time !=''";
$jf = pdo_fetch($jf);//今天的积分店内销售额

$ztwx = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time2."  and dn_state=2 and seller_id=".$storeid." and is_yue=2 and type=2 and pay_time !=''";
$ztwx = pdo_fetch($ztwx);//昨天的微信店内销售额
$ztyue = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time2."  and dn_state=2 and seller_id=".$storeid." and is_yue=1 and type=2 and pay_time !=''";
$ztyue = pdo_fetch($ztyue);//昨天的余额店内销售额
$ztjf = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time2."  and dn_state=2 and seller_id=".$storeid." and is_yue=3 and type=2 and pay_time !=''";
$ztjf = pdo_fetch($ztjf);//昨天的积分店内销售额






$dn2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time."   and type=2 and dn_state=2 and seller_id=".$storeid." and uniacid=".$_W['uniacid'];
$dn2 = count(pdo_fetchall($dn2));//今天店内订单量
$wxdn2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time."   and type=2 and dn_state=2 and seller_id=".$storeid." and is_yue=2 and uniacid=".$_W['uniacid'];
$wxdn2 = count(pdo_fetchall($wxdn2));//今天店内微信订单量
$yuedn2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time."   and type=2 and dn_state=2 and seller_id=".$storeid." and is_yue=1 and uniacid=".$_W['uniacid'];
$yuedn2 = count(pdo_fetchall($yuedn2));//今天店内余额订单量
$jfdn2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time."   and type=2 and dn_state=2 and seller_id=".$storeid." and is_yue=3 and uniacid=".$_W['uniacid'];
$jfdn2 = count(pdo_fetchall($jfdn2));//今天店内积分订单量




$ztdn2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time2."   and type=2 and dn_state=2 and seller_id=".$storeid." and uniacid=".$_W['uniacid'];
$ztdn2 = count(pdo_fetchall($ztdn2));//昨天店内订单量
$ztwxdn2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time2."   and type=2 and dn_state=2 and seller_id=".$storeid." and is_yue=2 and uniacid=".$_W['uniacid'];
$ztwxdn2 = count(pdo_fetchall($ztwxdn2));//昨天店内微信订单量
$ztyuedn2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time2."   and type=2 and dn_state=2 and seller_id=".$storeid." and is_yue=1 and uniacid=".$_W['uniacid'];
$ztyuedn2 = count(pdo_fetchall($ztyuedn2));//昨天店内余额订单量
$ztjfdn2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time2."   and type=2 and dn_state=2 and seller_id=".$storeid." and is_yue=3 and uniacid=".$_W['uniacid'];
$ztjfdn2 = count(pdo_fetchall($ztjfdn2));//昨天店内积分订单量




        if($_GPC['op']=='receivables'){
            $id=$_GPC['id'];
            $data2['dn_state']=2;
            $result = pdo_update('wpdc_order',$data2, array('id'=>$id));
            if($result){
                message('确认成功',$this->createWebUrl2('dlindnorder',array()),'success');
            }else{
                message('确认失败','','error');
            }
        }elseif($_GPC['op']=='close'){
            $id=$_GPC['id'];
            $table_id=$_GPC['table_id'];
            $data2['dn_state']=3;
            $result = pdo_update('wpdc_order',$data2, array('id'=>$id));
            pdo_update('wpdc_table',array('status'=>0), array('id'=>$table_id));
            if($result){
                message('关闭成功',$this->createWebUrl2('dlindnorder',array()),'success');
            }else{
                message('关闭失败','','error');
            }

        }elseif($_GPC['op']=='open'){
            $table_id=$_GPC['id'];
            $data2['status']=0;
            $result = pdo_update('wpdc_table',$data2, array('id'=>$table_id));
            if($result){
                message('重新开台成功',$this->createWebUrl2('dlindnorder',array()),'success');
            }else{
                message('重新开台失败','','error');
            }
        }
        if($_GPC['op']=='delete'){
    $res=pdo_delete('wpdc_order',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl2('dlindnorder'), 'success');
        }else{
              message('删除失败！','','error');
        }
}

if($_GPC['op']=='dy'){

$res=pdo_get('wpdc_order',array('id'=>$_GPC['id']));
$res3=pdo_get('wpdc_dyj',array('uniacid'=>$_W['uniacid'],'store_id'=>$res['seller_id'],'state'=>1,'location'=>1));
$res2=pdo_getall('wpdc_goods',array('order_id'=>$_GPC['id']));
$table=pdo_get('wpdc_table',array('id'=>$res['table_id']));
    if($res['is_yue']==1){
       $pay_type='余额支付'; 
    }elseif($res['is_yue']==2){
       $pay_type='微信支付';  
    }elseif($res['is_yue']==3){
       $pay_type='积分支付';  
    }else{
      $pay_type='餐后支付'; 
    }
  if($res3['type']!=3){
 $content = "\n\n\n\n";
  $content .= "         订单编号  #".$res['id']." \n\n";
  $content .= "          ".$res3['dyj_title']."\n\n";
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
$content .= "支付方式：".$pay_type."\n\n\n\n\n";
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
message('打印成功！', $this->createWebUrl2('dlindnorder'), 'success');
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
  message('打印成功！', $this->createWebUrl2('dlindnorder'), 'success');
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
    return $client->getContent();
  }
  
}
$rst=wp_print(SN,$content,1);
$rst2=json_decode($rst);
if($rst2->msg=='ok'){
   message('打印成功！', $this->createWebUrl2('dlindnorder'), 'success');
}
}
}

if($_GPC['op']=='time'){
    $res=pdo_update('wpdc_order',array('pay_time'=>time()),array('id'=>$_GPC['id']));
     if($res){
        message('写入成功！', $this->createWebUrl2('dlindnorder'), 'success');
    }else{
        message('写入失败！','','error');
    }
}






if(checksubmit('export_submit', true)) {
    $time=date("Y-m-d");
    $time="'%$time%'";
        $count = pdo_fetchcolumn("SELECT COUNT(*) FROM". tablename("wpdc_order")." WHERE time LIKE ".$time."and type=2 and seller_id =".$storeid);
        $pagesize = ceil($count/5000);
        //array_unshift( $names,  '活动名称'); 
        $header = array(
            'item'=>'序号',
            'md_name' => '门店名称',
           'order_num' => '订单号', 
           // 'name' => '联系人', 
           // 'tel' => '联系电话',
           // 'address' => '联系地址',
           'time' => '下单时间',
           'money' => '金额',
           'table_name' => '桌号',
           // 'state' => '外卖状态',
         'dn_state' => '店内状态',
           'goods' => '商品'

        );

        $keys = array_keys($header);
        $html = "\xEF\xBB\xBF";
        foreach ($header as $li) {
            $html .= $li . "\t ,";
        }
        $html .= "\n";
        for ($j = 1; $j <= $pagesize; $j++) {
            $sql = "select a.*,b.md_name,c.name as table_name from " . tablename("wpdc_order")."  a"  . " left join " . tablename("wpdc_store")." b on a.seller_id=b.id " . " left join " . tablename("wpdc_table") . " c on c.id=a.table_id  WHERE a.time LIKE ".$time." and a.type=2 and a.seller_id =".$storeid." limit " . ($j - 1) * 5000 . ",5000 ";
            $list = pdo_fetchall($sql);
   
            

        }
            if (!empty($list)) {
                $size = ceil(count($list) / 500);
                for ($i = 0; $i < $size; $i++) {
                    $buffer = array_slice($list, $i * 500, 500);
                    $user = array();
                    foreach ($buffer as $k =>$row) {
                        $row['item']= $k+1;
                        // if($row['state']==0){
                        //     $row['state']='无状态';
                        // }elseif($row['state']==1){
                        //     $row['state']='待付款';
                        // }elseif($row['state']==2){
                        //     $row['state']='等待接单';
                        // }elseif($row['state']==3){
                        //     $row['state']='等待送达';
                        // }elseif($row['state']==4){
                        //     $row['state']='完成';
                        // }elseif($row['state']==5){
                        //     $row['state']='取消订单';
                        // }elseif($row['state']==6){
                        //     $row['state']='评论完成';
                        // }
                        if($row['dn_state']==0){
                            $row['dn_state']='无状态';
                        }elseif($row['dn_state']==1){
                            $row['dn_state']='待付款';
                        }elseif($row['dn_state']==2){
                            $row['dn_state']='已完成';
                        }elseif($row['dn_state']==3){
                            $row['dn_state']='关闭订单';
                        }elseif($row['dn_state']==4){
                            $row['dn_state']='已评论';
                        }
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
        header("Content-Disposition:attachment; filename=今日店内订单数据.csv");
        echo $html;
        exit();
    }
include $this->template('web/dlindnorder');