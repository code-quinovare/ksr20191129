<?php
defined('IN_IA') or exit('Access Denied');
//require 'inc/func/core.php';
require IA_ROOT.'/addons/zh_dianc/inc/func/core.php';
class zh_diancModuleSite extends Core {

    
    public function doMobileNewOrder(){
        global $_W,$_GPC;
        $time=time();
        $time2=$time-10;

        $seller_id=$_GPC['store'];
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

    public function doMobileJdOrder(){
        global $_W,$_GPC;
          $seller_id=$_GPC['id'];
             $store=pdo_get('wpdc_store',array('id'=>$seller_id));
             if($store['is_jd']==1){
                $time=time()-$store['jd_time'];
                $data['state']=3;
                $res=pdo_update("wpdc_order",$data,array('seller_id'=>$seller_id,'time2 <='=>$time,'state'=>2));
                if($res){
                    echo  '1';
                }else{
                    echo  '2';
                }
             }
    }
    public function doMobileUpdate(){
        global $_W,$_GPC;
        if($_GPC['name']){
           $data['name']=$_GPC['name']; 
        }
        if($_GPC['money']){
           $data['money']=$_GPC['money']; 
        }
        if($_GPC['wm_money']){
           $data['wm_money']=$_GPC['wm_money']; 
        }
        if($_GPC['box_fee']){
           $data['box_fee']=$_GPC['box_fee']; 
        }
        if($_GPC['num']){
           $data['num']=$_GPC['num']; 
        }
        if($_GPC['xs_num']){
           $data['xs_num']=$_GPC['xs_num']; 
        }
        $res=pdo_update('wpdc_dishes',$data,array('id'=>$_GPC['id']));
        if($res){
            echo '1';
        }else{
            echo '2';
        }
    }
    public function doMobileUpdUser(){
        global $_W,$_GPC;
        //var_dump($_GPC['id']);die;
        $res=pdo_delete('wpdc_user',array('id'=>$_GPC['id']));
        pdo_delete('wpdc_order',array('user_id'=>$_GPC['id']));
        pdo_delete('wpdc_ydorder',array('user_id'=>$_GPC['id']));
         if($res){
            echo '1';
        }else{
            echo '2';
        }
    }
    public function doMobileUpdCai(){
        global $_W,$_GPC;
        $res=pdo_delete('wpdc_dishes',array('id'=>$_GPC['id']));
        $res=pdo_delete('wpdc_spec',array('goods_id'=>$_GPC['id']));
         if($res){
            echo '1';
        }else{
            echo '2';
        }
    }
    //删除充值活动
    public function doMobileDelCz(){
		global $_W,$_GPC;
		$res=pdo_delete('wpdc_czhd',array('id'=>$_GPC['id']));
		if($res){
			echo '1';
		}else{
			echo '2';
		}
    }
    //添加充值活动
    public function doMobileAddCz(){
    	global $_W,$_GPC;
    	for($i=0;$i<count($_GPC['list']);$i++){
    		$data['full']=$_GPC['list'][$i]['full'];
    		$data['reduction']=$_GPC['list'][$i]['reduction'];
    		$data['uniacid']=$_W['uniacid'];
    		pdo_insert('wpdc_czhd',$data);
    	}
    }
    //删除签到活动
    public function doMobileDelQd(){
		global $_W,$_GPC;
		$res=pdo_delete('wpdc_continuous',array('id'=>$_GPC['id']));
		if($res){
			echo '1';
		}else{
			echo '2';
		}
    }
    //添加签到规则
    public function doMobileAddQd(){
    	global $_W,$_GPC;
    	pdo_delete('wpdc_continuous');
    	for($i=0;$i<count($_GPC['list']);$i++){
    		$data['day']=$_GPC['list'][$i]['day'];
    		$data['integral']=$_GPC['list'][$i]['integral'];
    		$data['uniacid']=$_W['uniacid'];
    		pdo_insert('wpdc_continuous',$data);
    	}
    	$res=pdo_get('wpdc_signset',array('uniacid'=>$_W['uniacid']));
    	if($res){
    		$data2['one']=$_GPC['one'];
    		$data2['integral']=$_GPC['integral'];
    		$data2['is_open']=$_GPC['is_open'];
    		$data2['is_bq']=$_GPC['is_bq'];
    		$data2['bq_integral']=$_GPC['bq_integral'];
    		pdo_update('wpdc_signset',$data2,array('uniacid'=>$_W['uniacid']));
    	}else{
    		$data2['one']=$_GPC['one'];
    		$data2['integral']=$_GPC['integral'];
    		$data2['is_open']=$_GPC['is_open'];
    		$data2['is_bq']=$_GPC['is_bq'];
    		$data2['bq_integral']=$_GPC['bq_integral'];
    		$data2['uniacid']=$_W['uniacid'];
    		pdo_insert('wpdc_signset',$data2);
    	}
    	$res2=pdo_get('wpdc_special',array('uniacid'=>$_W['uniacid']));
    	if($res2){
    		$data3['day']=$_GPC['day'];
    		$data3['integral']=$_GPC['integral2'];
    		$data3['title']=$_GPC['title'];
    		$data3['color']=$_GPC['color'];
    		pdo_update('wpdc_special',$data3,array('id'=>1));
    	}else{
    		$data3['day']=$_GPC['day'];
    		$data3['integral']=$_GPC['integral2'];
    		$data3['title']=$_GPC['title'];
    		$data3['color']=$_GPC['color'];
    		$data3['uniacid']=$_W['uniacid'];
    		pdo_insert('wpdc_special',$data3);
    	}
    }
//下架
    public function doMobileXj(){
    	global $_W,$_GPC;
    	$res=pdo_update('wpdc_dishes',array('is_shelves'=>2),array('id'=>$_GPC['id']));
    	if($res){
    		echo  '1';
    	}else{
    		echo  '2';
    	}
    }
     public function doMobileSj(){
    	global $_W,$_GPC;
    	$res=pdo_update('wpdc_dishes',array('is_shelves'=>1),array('id'=>$_GPC['id']));
    	if($res){
    		echo  '1';
    	}else{
    		echo  '2';
    	}
    }
    public function doMobileTime(){
          global $_W,$_GPC;
        $m=$_GPC['yue'];
        $y=$_GPC['nian'];
        //  $m=2;
        // $y=2017;
        @$day=date("t",strtotime("$y-$m"));
        $storeid=$_GPC['store_id'];
         if($m>9){
                $m=$m;
            }elseif($m<=9){
                $m="0".$m;
            }
        $data=array();
        for($i=1;$i<=$day;$i++){
           
            if($i>9){
                $i=$i;
            }elseif($i<=9){
                $i="0".$i;
            }
            $time=$y."-".$m."-".$i;
            $time="'%$time%'";
            $wm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid." and state not in (5,1,8) and type=1 and pay_time !=''";
            $wm = pdo_fetch($wm);//外卖销售额
            $dn = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid." and dn_state not in (3,1) and type=2 and pay_time !=''";
            $dn = pdo_fetch($dn);//店内销售额
            $yd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE created_time LIKE ".$time." and store_id=".$storeid." and state not in (0,6)";
            $yd = pdo_fetch($yd);//预定销售额
            $dmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time." and state=2 and store_id=".$storeid;
            $dmf = pdo_fetch($dmf);//当面付销售额
            $total = $wm['total']+$dn['total']+$yd['total']+$dmf['total'];//销售额


            $wm2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid." and state not in (5,1,8) and type=1 and pay_time !=''";
            $wm2 = count(pdo_fetchall($wm2));//外卖销售量

            $dn2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid." and dn_state not in (3,1) and type=2 and pay_time !=''";
            $dn2 = count(pdo_fetchall($dn2));//店内销售量
            $yd2 = "select * from " . tablename("wpdc_ydorder")." WHERE created_time LIKE ".$time." and store_id=".$storeid." and state not in (0,6)";
            $yd2 = count(pdo_fetchall($yd2));//预定销售量
            $dmf2 = "select * from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time." and state=2 and store_id=".$storeid;
            $dmf2 = count(pdo_fetchall($dmf2));//当面付销售量
            $number=$wm2+$dn2+$yd2+$dmf2;//销售量
           
            $data[]=array(
                    'money'=>$total,
                    'number'=>$number
                );
        }
       // print_r($data);die;
       echo json_encode($data);

    }
     public function doMobileTime2(){
          global $_W,$_GPC;
      
        $y=$_GPC['nian'];
        $storeid=$_GPC['store_id'];
        $data=array();
        for($i=1;$i<=12;$i++){
            if($i>9){
                $i=$i;
            }elseif($i<=9){
                $i="0".$i;
            }
            $time=$y."-".$i;
            $time="'%$time%'";
            $wm = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid." and state not in (5,1,8) and type=1 and pay_time !=''";
            $wm = pdo_fetch($wm);//外卖销售额
            $dn = "select sum(money) as total from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid." and dn_state not in (3,1) and type=2 and pay_time !=''";
            $dn = pdo_fetch($dn);//店内销售额
            $yd = "select sum(pay_money) as total from " . tablename("wpdc_ydorder")." WHERE created_time LIKE ".$time." and store_id=".$storeid." and state not in (0,6)";
            $yd = pdo_fetch($yd);//预定销售额
            $dmf = "select sum(money) as total from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time." and state=2 and store_id=".$storeid;
            $dmf = pdo_fetch($dmf);//当面付销售额
            $total = $wm['total']+$dn['total']+$yd['total']+$dmf['total'];//销售额


            $wm2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid." and state not in (5,1,8) and type=1 and pay_time !=''";
            $wm2 = count(pdo_fetchall($wm2));//外卖销售量
            $dn2 = "select * from " . tablename("wpdc_order")." WHERE time LIKE ".$time." and seller_id=".$storeid." and dn_state not in (3,1) and type=2 and pay_time !=''";
            $dn2 = count(pdo_fetchall($dn2));//店内销售量
            $yd2 = "select * from " . tablename("wpdc_ydorder")." WHERE created_time LIKE ".$time." and store_id=".$storeid." and state not in (0,6)";
            $yd2 = count(pdo_fetchall($yd2));//预定销售量
            $dmf2 = "select * from " . tablename("wpdc_dmorder")." WHERE time LIKE ".$time." and state=2 and store_id=".$storeid;
            $dmf2 = count(pdo_fetchall($dmf2));//当面付销售量
            $number=$wm2+$dn2+$yd2+$dmf2;//销售量
           
            $data[]=array(
                    'money'=>$total,
                    'number'=>$number
                );
        }
       echo json_encode($data);

    }


public function doMobileSelectUser(){
   global $_W, $_GPC;
  // echo  $_GPC['keywords'];
    //查出已是商家用户
$sjuser=pdo_getall('wpdc_store',array('uniacid'=>$_W['uniacid']),'user_id');
//二维数组转一维
function i_array_column($input, $columnKey, $indexKey=null){
    if(!function_exists('array_column')){ 
        $columnKeyIsNumber  = (is_numeric($columnKey))?true:false; 
        $indexKeyIsNull            = (is_null($indexKey))?true :false; 
        $indexKeyIsNumber     = (is_numeric($indexKey))?true:false; 
        $result                         = array(); 
        foreach((array)$input as $key=>$row){ 
            if($columnKeyIsNumber){ 
                $tmp= array_slice($row, $columnKey, 1); 
                $tmp= (is_array($tmp) && !empty($tmp))?current($tmp):null; 
            }else{ 
                $tmp= isset($row[$columnKey])?$row[$columnKey]:null; 
            } 
            if(!$indexKeyIsNull){ 
                if($indexKeyIsNumber){ 
                  $key = array_slice($row, $indexKey, 1); 
                  $key = (is_array($key) && !empty($key))?current($key):null; 
                  $key = is_null($key)?0:$key; 
                }else{ 
                  $key = isset($row[$indexKey])?$row[$indexKey]:0; 
                } 
            } 
            $result[$key] = $tmp; 
        } 
        return $result; 
    }else{
        return array_column($input, $columnKey, $indexKey);
    }
}
$yuser=i_array_column($sjuser, 'user_id');
$string='';
if($yuser){
foreach($yuser as $v){
    $string.="'".$v."',";
}
$string=rtrim($string, ",");
}
if($yuser){
$sql =" select id,name from ".tablename('wpdc_user')." where uniacid={$_W['uniacid']}  and id not in ({$string}) and  (name like '%{$_GPC['keywords']}%' || openid like '%{$_GPC['keywords']}%')";  
}else{
 $sql =" select id,name from ".tablename('wpdc_user')." where uniacid={$_W['uniacid']}   and  (name like '%{$_GPC['keywords']}%' || openid like '%{$_GPC['keywords']}%')";     
}
$user=pdo_fetchall($sql);
echo json_encode($user);
}



















     

}