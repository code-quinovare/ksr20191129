<?php
global $_GPC, $_W;
$action = 'start';
//$GLOBALS['frames'] = $this->getMainMenu2();
$action = 'start';
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid, $action);
$info=pdo_get('wpdc_store',array('id'=>$storeid));
$coordinates=explode(',',$info['coordinates']);
		$info['coordinates']=array(
				'lat'=>$coordinates['0'],
				'lng'=>$coordinates['1'],
			);
		if($info['img']){
			if(strlen($info['img'])>51){
			$img2= explode(',',$info['img']);
		}else{
			$img2=array(
				0=>$info['img']
				);
		}
		}
		//print_r($img);die;
		if($info['environment']){
			if(strlen($info['environment'])>51){
			$environment= explode(',',$info['environment']);
		}else{
			$environment=array(
				0=>$info['environment']
				);
		}
		}
		if($info['yyzz']){
		if(strlen($info['yyzz'])>51){
			$yyzz= explode(',',$info['yyzz']);
		}else{
			$yyzz=array(
				0=>$info['yyzz']
				);
		}	
		}
if(checksubmit('submit')){
	if(!$_GPC['address']){
		message('商家地址不能为空','','error');
	}
	if(!$_GPC['op']){
		message('商家坐标不能为空','','error');
	}
			
		if($_GPC['img']){
			$data['img']=implode(",",$_GPC['img']);
		}else{
			$data['img']='';
		}
		//var_dump($data['img']);die;
		if($_GPC['yyzz']){
			$data['yyzz']=implode(",",$_GPC['yyzz']);
		}else{
			$data['yyzz']='';
		}
		if($_GPC['environment']){
			$data['environment']=implode(",",$_GPC['environment']);
		}else{
			$data['environment']='';
		}
		//	var_dump($data['img']);die;
		$data['hb_img']=$_GPC['hb_img'];
			$data['jd_time']=$_GPC['jd_time'];
			$data['is_jd']=$_GPC['is_jd'];
			$data['name']=$_GPC['name'];
			$data['address']=$_GPC['address'];
			$data['tel']=$_GPC['tel'];
			$data['announcement']=$_GPC['announcement'];
			$data['conditions']=$_GPC['conditions'];
			$data['preferential']=$_GPC['preferential'];
			$data['support']=$_GPC['support'];
			$data['start_at']=$_GPC['start_at'];
			$data['logo']=$_GPC['logo'];
			$data['bgimg']=$_GPC['bgimg'];
			$data['is_display']=$_GPC['is_display'];
			$data['box_name']=$_GPC['box_name'];					
			if($_GPC['color']){
				$data['color']=$_GPC['color'];
			}else{
				$data['color']="#34AAFF";
			}
			$data['uniacid']=$_W['uniacid'];
			$data['xyh_money']=$_GPC['xyh_money'];
			$data['xyh_open']=$_GPC['xyh_open'];
			$data['coordinates']=$_GPC['op']['lat'].','.$_GPC['op']['lng'];
			$data['details']=html_entity_decode($_GPC['details']);
				//var_dump($data);die;
				$res = pdo_update('wpdc_store', $data, array('id' => $storeid));
				if($res){
					message('编辑成功',$this->createWebUrl2('dlstoreinfo',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}


function  getCoade($storeid){
		function getaccess_token(){
			global $_W, $_GPC;
         $res=pdo_get('wpdc_system',array('uniacid' => $_W['uniacid']));
         $appid=$res['appid'];
         $secret=$res['appsecret'];
         
       $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
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

		$img=getCoade($storeid);
include $this->template('web/dlstoreinfo');