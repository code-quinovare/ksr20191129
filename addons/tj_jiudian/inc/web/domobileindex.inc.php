<?php
global $_W,$_GPC;
$action=$_GPC['action']?$_GPC['action']:'';
if (empty($_W['fans']['nickname'])) {
    mc_oauth_userinfo();
}
$set = pdo_get('tj_jiudian_set',array('acid'=>$_W['account']['acid']));
$set2 = pdo_get('tj_jiudian_set',array('acid'=>$_W['account']['acid']));
$xq = pdo_get('tj_jiudian_xiangqing',array('acid'=>$_W['account']['acid']));

$footer = pdo_fetchall("SELECT * FROM ".tablename("tj_jiudian_caidan")." WHERE acid = ".$_W['fans']['acid'] . " order by rank desc");
$openid = $_W['fans']['openid'];

//pdo_query("UPDATE " . tablename('tj_jiudian_order') . " SET add_status=1 WHERE acid=" . $_W['account']['acid'] . " AND pay_status=1 AND endtime<" . $time1);

if($action=="")
{
    if($_W['ispost']){
        session_start();
        $_SESSION['ruzhu'] = $_GPC['ruzhu'];
        $_SESSION['lidian'] = $_GPC['lidian'];
        message("",$this->createMobileUrl("Index",array("action"=>"info",'rooms'=>$_GPC['rooms'])));

        }

    $set['logo'] = unserialize($set['logo']);

    include $this->template("index");
}

if($action == "info")
{
    $count = pdo_fetch("SELECT COUNT(*) AS cc FROM ".tablename("tj_jiudian_house")." WHERE acid = ".$_W['account']['acid']);
    $xiangqing = pdo_get('tj_jiudian_xiangqing',array('acid'=>$_W['account']['acid']));
    //var_dump($xiangqing);
    $set = pdo_get('tj_jiudian_set',array('acid'=>$_W['account']['acid']));
    $set['logo'] = unserialize($set['logo']);

    $weekarray=array("日","一","二","三","四","五","六");
    $a=strtotime($_SESSION['ruzhu']);
    $b=strtotime($_SESSION['lidian']);
    $time=strtotime(date('Y-m-d'));
    $c=ceil($b-$a)/86400);

    $m =ceil(($b-$a)/3600);

    if($c==0){
        $c=1;
    }
    //var_dump($c);exit;
    //echo $a;echo $time;exit;
    if($a==$time){
        $time1="今天";
    }else if($a==$time+86400){
        $time1="明天";
    }else{
        $time1="周".$weekarray[date("w",$a)];
    }

    if($b==$time){
        $time2="今天";
    }else if($b==$time+86400){
        $time2="明天";
    } else{
        $time2="周".$weekarray[date("w",$b)];
    }

    $house = pdo_fetchall("SELECT * FROM ".tablename("tj_jiudian_house")." WHERE rooms=".$_GPC['rooms']." AND acid = ".$_W['account']['acid'] . " order by rank desc");
    $riqi=time();
    foreach($house as $k=>$v){
        $con=pdo_fetch("SELECT COUNT(*) AS cc FROM ".tablename("tj_jiudian_order")." WHERE tid=".$v['id']." AND pay_status=1 AND acid = ".$_W['account']['acid']." AND ((UNIX_TIMESTAMP(ruzhu)<=" . $a." AND UNIX_TIMESTAMP(lidian)>" . $a.") OR (UNIX_TIMESTAMP(lidian)>" . $b." AND UNIX_TIMESTAMP(ruzhu)<=" . $b."))");
        //var_dump($con);exit;
        $house[$k]['shengyu']=$v['shengyu']-$con['cc'];
        /*pdo_query("UPDATE " . tablename('tj_jiudian_house') . " SET shengyu=".$shengyu." WHERE id=".$v['id']." AND acid=" . $_W['account']['acid']);
        pdo_query("UPDATE " . tablename('tj_jiudian_order') . " SET add_status=1 WHERE acid=" . $_W['account']['acid'] . " AND pay_status=1 AND UNIX_TIMESTAMP(lidian)>" . $riqi);*/

    }

    $avg=pdo_fetch(" SELECT AVG(rate) AS cc FROM ".tablename('tj_jiudian_pinglun')." WHERE acid=".$_W['account']['acid']);
    $avg=substr($avg['cc'],0,strpos($avg['cc'],'.')+3 );

    $pinglun = pdo_fetch("SELECT COUNT(*) AS cc FROM ".tablename("tj_jiudian_pinglun")." WHERE acid = ".$_W['fans']['acid']);
    $zong=pdo_fetch("SELECT COUNT(*) AS cc FROM ".tablename("tj_jiudian_order")." WHERE use_status=1 AND  pay_status=1 AND acid = ".$_W['fans']['acid']);
    $d=$pinglun['cc']/$zong['cc']*100;
    //var_dump($zong['cc']);exit;
    if($d==100){
        $baifen=substr($d,0,3);
    }else{
        $baifen=substr($d,0,2);
    }

    include $this->template("info");
}

if($action=='show'){
    $res = pdo_get('tj_jiudian_house',array('id'=>$_GPC['id'],'acid'=>$_W['account']['acid']));
    echo json_encode($res);
}

//下订单
if($action == "order_buy")
{
    $res=pdo_get('tj_jiudian_house',array('id'=>$_GPC['id']));
    $money=intval($_GPC['day'])*intval($res['price']);
    include $this->template("order_buy");
}

//我的订单
if($action == "order_list")
{
    $order=pdo_fetchall(" SELECT a.*,b.img FROM ".tablename('tj_jiudian_order')." AS a LEFT JOIN ".tablename('tj_jiudian_house')." AS b ON a.tid=b.id WHERE a.pay_status=1 AND a.openid='".$_W['fans']['openid']."' AND a.acid=".$_W['account']['acid'] . " order by createtime desc ");
    include $this->template("order_list");
}
//未付款订单
if($action == "weiorder_list")
{
    $order=pdo_fetchall(" SELECT a.*,b.img FROM ".tablename('tj_jiudian_order')." AS a LEFT JOIN ".tablename('tj_jiudian_house')." AS b ON a.tid=b.id WHERE a.pay_status=0 AND a.openid='".$_W['fans']['openid']."' AND a.acid=".$_W['account']['acid'] . " order by createtime desc ");
    include $this->template("order_list");
}
//待使用订单
if($action == "daiorder_list")
{
    $order=pdo_fetchall(" SELECT a.*,b.img FROM ".tablename('tj_jiudian_order')." AS a LEFT JOIN ".tablename('tj_jiudian_house')." AS b ON a.tid=b.id WHERE a.use_status=0 AND a.pay_status=1 AND a.openid='".$_W['fans']['openid']."' AND a.acid=".$_W['account']['acid'] . " order by createtime desc ");

    include $this->template("order_list");
}
//带评论订单
if($action == "pingorder_list")
{
    $order=pdo_fetchall(" SELECT a.*,b.img FROM ".tablename('tj_jiudian_order')." AS a LEFT JOIN ".tablename('tj_jiudian_house')." AS b ON a.tid=b.id WHERE a.use_status=1 AND a.ping=0 AND a.pay_status=1 AND a.openid='".$_W['fans']['openid']."' AND a.acid=".$_W['account']['acid'] . " order by createtime desc ");
    include $this->template("order_list");
}
//退款订单
if($action == "tuiorder_list")
{
    $order=pdo_fetchall(" SELECT a.*,b.img FROM ".tablename('tj_jiudian_order')." AS a LEFT JOIN ".tablename('tj_jiudian_house')." AS b ON a.tid=b.id WHERE  a.pay_status=-1 OR a.pay_status=-2 AND a.openid='".$_W['fans']['openid']."' AND a.acid=".$_W['account']['acid'] . " order by createtime desc ");
    include $this->template("order_list");
}
//订单详情
if($action == "order_info")
{
    $res=pdo_get('tj_jiudian_order',array('id'=>$_GPC['id']));
    $row=pdo_get('tj_jiudian_house',array('id'=>$res['tid']));
    
    include $this->template("order_info");
}

//服务详情
if($action == "fuwu_info")
{
    $set = pdo_get('tj_jiudian_set',array('acid'=>$_W['account']['acid']));
    $res = pdo_get('tj_jiudian_xiangqing',array('acid'=>$_W['account']['acid']));
    include $this->template("fuwu_info");
}

//收银台
if($action == "shouyin"){

    include $this->template("shouyin");
}

if($action=='shouyin1'){
    if($_W['ispost']){
        //订单详情
        $order = array(
            'openid' => $openid,
            'acid' => $_W['account']['acid'],
            'nickname' => $_W['fans']['nickname'],
            'numberid' => date('YmdHis') . mt_rand(10, 99),
            'beizhu' => $_GPC['beizhu'],
            'money' => $_GPC['money'],
            'pay_status'=>0,
            'time' => time(),
        );
        //var_dump($order);exit;
        pdo_insert('tj_jiudian_shouyin',$order);
        //流水
        $record = array(
            'openid' => $openid,
            'acid' => $_W['account']['acid'],
            'numberid' => $order['numberid'],
            'money' => $_GPC['money'],
            'status'=>2,
            'createtime' => time(),
        );
        $result=pdo_insert('tj_jiudian_records',$record);
        !$result && message('无法生成支付订单！', $this->createMobileUrl('Index', array()), 'error');
        header('Location:' . $this->createMobileUrl('pay', array('orderid' => $record['numberid'])));
    }
}
//提交订单
if($action=='order'){
    if($_W['ispost']){
        $order['tid']=$_GPC['tid'];
        $order['title']=$_GPC['title'];
        $order['count']=$_GPC['count'];
        $order['money']=$_GPC['money'];
        $order['day']=$_GPC['day'];
        $order['username']=$_GPC['username'];
        $order['time']=$_GPC['time'];
        $order['phone']=$_GPC['phone'];
        $order['price']=$_GPC['price'];
        $order['class']=$_GPC['class'];
        $order['rooms']=$_GPC['rooms'];
        $order['createtime']=time();
        $order['acid']=$_W['account']['acid'];
        $order['numberid']=date('YmdHis') . mt_rand(10, 99);
        $order['openid']=$_W['fans']['openid'];
        $order['ruzhu']=$_SESSION['ruzhu'];
        $order['lidian']=$_SESSION['lidian'];
        $aa=pdo_insert('tj_jiudian_order',$order);
        //var_dump($order);exit;
        $record = array(
            'openid' => $openid,
            'acid' => $_W['account']['acid'],
            'numberid' => $order['numberid'],
            'money' => $order['money'],
            'status'=>1,
            'openid'=>$_W['fans']['openid'],
            'day'=>$order['day'],
            'createtime' => time(),
        );
        $result=pdo_insert('tj_jiudian_records',$record);
        
        !$result && message('无法生成支付订单！', $this->createMobileUrl('Index', array()), 'error');
        header('Location:' . $this->createMobileUrl('pay', array('orderid' => $record['numberid'])));
    }
}
//核销
//展示二维码
if($_GPC['action']=='qrcode'){
    //var_dump($_GPC['id']);var_dump($_GPC['bid']);exit;
    $a=time();
    $b='jiudian'.$a.'.png';
    $aa=substr($this->createMobileUrl('Index',array('action'=>'hexiao','id'=>$_GPC['id'],'tim'=>$b)),2);
    $qr=$_W['siteroot'].$aa;
   /* $order=pdo_fetch(' SELECT a.*,b.shop_name,b.logo,b.id as busid FROM '.tablename('tj_business_order')." AS a INNER JOIN ".tablename('tj_business_information')." AS b on a.bid=b.id WHERE a.id=".$_GPC['id']." AND a.show_status=0 AND a.pay_status=1 AND a.acid=".$_W['account']['acid']);
    $order['logos'] = unserialize($order['logos']);*/
    //var_dump($b);exit;
    QRcode::png($qr, $b);

    include $this->template('qrcode');
    /*$url='../app/'.$a.'.png';
    unlink($url);*/

}

//核销页面
if($action=="hexiao"){
    $openid=$_W['fans']['openid'];
    $set=pdo_get('tj_jiudian_set',array('acid'=>$_W['account']['acid']));
    $aa=explode("/",$set['he_openid']);
    if(in_array($openid,$aa)){

        $res=pdo_get('tj_jiudian_order',array('id'=>$_GPC['id']));
        $img=pdo_get('tj_jiudian_house',array('id'=>$res['tid']));
        if($res['use_status']==1){
            message('订单已核销！');
        }


        //var_dump($aa);var_dump($openid1);exit;
        //var_dump($_GPC['id']);var_dump($_GPC['bid']);exit;
        $url='../app/'.$_GPC['tim'];
        //var_dump($url);exit;
        //unlink($url);
    }else{
        message('您没有操作权限！',$this->createMobileUrl('User'));
    }
    include $this->template("hexiao");
}
//核销订单
if($_GPC['action']=='use'){
    $time=date('Y-m-d H:i:s');
    $res=pdo_update('tj_jiudian_order',array('use_status'=>1,'he_openid'=>$_W['fans']['openid'],'hename'=>$_W['fans']['nickname'],'hetime'=>$time),array('id'=>$_GPC['id']));
    if($res){
        message('使用成功',$this->createMobileUrl('Index'));
    }else{
        message('核销失败');
    }
}
//删除订单
if($_GPC['action']=='delete'){
    $res=pdo_update('tj_jiudian_order',array('show_status'=>1),array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createMobileUrl('Index',array('action'=>'order_list')));
    }else{
        message('删除失败');
    }
}

//评论
if($action=='pinglun'){
    $pingjia=pdo_fetchall("SELECT a.*,b.*,c.title,c.ruzhu FROM ".tablename("tj_jiudian_pinglun")." AS a LEFT JOIN ".tablename('tj_jiudian_huifu')." AS b on a.id=b.pinglun_id LEFT JOIN ".tablename('tj_jiudian_order')." AS c on a.oid=c.id WHERE a.acid = ".$_W['account']['acid'] . " order by time desc LIMIT 0,8 ");
    foreach ($pingjia as $k => $v) {
        $pingjia[$k]['images']=unserialize($pingjia[$k]['images']);
    }
    include $this->template("pinglun");
}
if($action=='xing'){
    /*$query = mysql_query("select * from tj_jiudian_raty where id=1");
    $rs = mysql_fetch_array($query);*/
    $rs=pdo_get('tj_jiudian_raty',array('id'=>1));
    $aver = 0;
    if ($rs) {
        $aver = $rs['total'] / $rs['voter'];
        $aver = round($aver, 1) * 10;
    }
    include $this->template("xing");
}
if($action=='ajax'){
    $score = $_POST['score'];
    $res=pdo_get('tj_jiudian_pinglun',array('oid'=>$_GPC['oid'],'openid'=>$_W['fans']['openid']));
    //echo $score;exit;
    if (isset($score)) {
        if ($res) {
            echo "1";
        } else {
            //$query = mysql_query("update tj_jiudian_raty set voter=voter+1,total=total+'$score' where id=1");
            echo 100;
        }
    }
}
//提交评论
if($action=='tijiao_pinglun'){
    if($_W['ispost']){
        $data['oid']=$_GPC['oid'];
        if($_GPC['rate']==''){
            $data['rate']=5;
        }else{
            $data['rate']=$_GPC['rate'];
        }
        $data['info']=$_GPC['info'];
        $data['openid']=$_W['fans']['openid'];
        $data['nickname']=$_W['fans']['nickname'];
        $data['avatar']=$_W['fans']['avatar'];
        $data['acid']=$_W['account']['acid'];
        $data['time']=time();
        $media = $_GPC['images'];
        if($media != "")
        {
            $images = serialize(Base::downloadimgages($media));  //图片上传
        }
        $data['images'] = $images;
        $res=pdo_insert('tj_jiudian_pinglun',$data);
        if($res){
            pdo_update('tj_jiudian_order',array('ping'=>1),array('id'=>$data['oid']));
            message('评论成功',$this->createMobileUrl('Index'));
        }
    }
}
if($action=='huifu'){
    if($_W['ispost']){
        $data['pinglun_id']=$_GPC['pinglun_id'];
        $data['huifu']=$_GPC['huifu'];
        $data['hopenid']=$_W['fans']['openid'];
        $data['acid']=$_W['account']['acid'];
        $data['createtime']=time();
        $res=pdo_insert('tj_jiudian_huifu',$data);
        if($res){
            message('回复成功',$this->createMobileUrl('Index'));
        }
    }
}
if($action=='pajax'){
        $page=(int)$_GPC['page'];
        $size=8;
        $list=pdo_fetchall("SELECT a.*,b.*,c.title,c.ruzhu FROM ".tablename("tj_jiudian_pinglun")." AS a LEFT JOIN ".tablename('tj_jiudian_huifu')." AS b on a.id=b.pinglun_id LEFT JOIN ".tablename('tj_jiudian_order')." AS c on a.oid=c.id WHERE a.acid = ".$_W['account']['acid'] . " order by time desc  LIMIT ". ($page - 1) *  $size . ',' . $size);
    foreach ($list as $k => $v) {
        $list[$k]['time']=date('Y-m-d',$list[$k]['time']);
        $list[$k]['images']=unserialize($list[$k]['images']);
    }
    echo json_encode($list);

}

if($_GPC['action']=='delete_pinglun'){
    $res=pdo_delete('tj_jiudian_pinglun',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createMobileUrl('Index',array('action'=>'pinglun')));
    }else{
        message('删除失败');
    }
}

if($action == 'tk'){

    pdo_update("tj_jiudian_order",array('pay_status' => -2),array('id' => $_GET['id']));
    message('申请退款成功，请等待客服审核！',$this->createMobileUrl('Index'),'success');

}


/*if($action == 'tk1'){
    $sql = "SELECT * FROM ".tablename('tj_jiudian_order')." WHERE `id` = {$_GET['id']}";
    $order = pdo_fetch($sql);

    $money = $order['money'];

    $openid = $order['openid'];

    require dirname(__DIR__)."/app/Order.class.php";

    $obj = new Order($money,$openid);
    $result = $obj->top_up();

    if($result != true){
        pdo_update("tj_jiudian_order",array('pay_status' => -1),array('id' => $_GET['id']));
        message('退款成功',$this->createWebUrl('Order',array('action' => 'tuikuan')),'success');
    }else{
        message($result['err_code_des'],$this->createWebUrl('Order',array('action' => 'tuikuan')),'error');
    }
}*/