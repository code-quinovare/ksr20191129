<?php

defined('IN_IA') or exit ('Access Denied');

class Core extends WeModuleSite{
	public $tb_form = 'dayu_form';
	public $tb_data = 'dayu_form_data';
	public $tb_field = 'dayu_form_fields';
	public $tb_reply = 'dayu_form_reply';
	public $tb_info = 'dayu_form_info';
	public $tb_staff = 'dayu_form_staff';
	public $tb_custom = 'dayu_form_custom';
	public $tb_linkage = 'dayu_form_linkage';
	public $tb_role = 'dayu_form_role';
	public $tb_category = 'dayu_form_category';
	public $tb_slide = 'dayu_form_slide';
	
    public $_appid = '';
    public $_appsecret = '';
    public $_accountlevel = '';
    public $_account = '';

    public $_weid = '';
    public $_openid = '';
    public $_nickname = '';
    public $_headimgurl = '';

    public $_auth2_openid = '';
    public $_auth2_nickname = '';
    public $_auth2_headimgurl = '';

    public function __construct(){
        global $_W, $_GPC;
    }

	public function showMessage($msg, $redirect='', $type='', $btn='', $time='') {
		global $_W;
		$time = !empty($time) ? $time*1000 : '3000';
		if($redirect == 'refresh') {
			$redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
		} elseif (!empty($redirect) && !strexists($redirect, 'http://')) {
			$urls = parse_url($redirect);
			$redirect = $_W['siteroot'] . 'app/index.php?' . $urls['query'];
		}
		if($redirect == '') {
			$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'info';
		} else {
			$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'success';
		}
		if($_W['isajax'] || $type == 'ajax') {
			$vars = array();
			$vars['message'] = $msg;
			$vars['redirect'] = $redirect;
			$vars['type'] = $type;
			exit(json_encode($vars));
		}
		$btn = !empty($btn) ? $btn : '确定';
		if (empty($msg) && !empty($redirect)) {
			header('location: '.$redirect);
		}
		$label = $type;
		if($type == 'error') {
			$label = 'danger';
			$info = '出错了，原因：';
		}
		if($type == 'ajax' || $type == 'sql') {
			$label = 'warning';
			$info = '访问受限，原因：';
		}
		if($type == 'info') {
			$label = 'info';
			$info = '提示';
		}
		if($type == 'success') {
			$info = '操作成功';
		}
		if (defined('IN_API')) {
			exit($msg);
		}
		include $this->template('messages', TEMPLATE_INCLUDEPATH);
		exit();
	}
	
    public function get_floor($val) {
        global $_W, $_GPC;	
		$floor = array (
			'1' => array('ename' => '1', 'name' => '一层'),
			'-1' => array('ename' => 'f1', 'name' => '负一层'),
			'-2' => array('ename' => 'f2', 'name' => '负二层')
		);
		return $floor[$val];
    }
	
	public function get_category($id){
        global $_W;
		return pdo_get($this->tb_category, array('weid' => $_W['uniacid'], 'id' => $id), array());
	}
	
	public function get_form($reid){
        global $_W;
		return pdo_get($this->tb_form, array('weid' => $_W['uniacid'], 'reid' => $reid), array());
	}
	
	public function get_info($reid,$type){
		global $_GPC,$_W;
		if ($type==1){
			return pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->tb_info)." WHERE reid = :reid and openid = :openid", array(":reid" => $reid, ":openid" => $_W['openid']));
		}elseif ($type==2){
			return pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->tb_info)." WHERE reid = :reid", array(":reid" => $reid));
		}
	}
	
    public function get_status_name($reid, $status) {
		$status = $this->get_status($reid,$status);
		return $status['name'];
    }
    public function get_status($reid, $status) {
        global $_W, $_GPC;
		$activity=$this->get_form($reid);
		$par = iunserializer($activity['par']);		
		$state1 = !empty($par['state1']) ? $par['state1'] : '待受理';
		$state2 = !empty($par['state2']) ? $par['state2'] : '受理中';
		$state3 = !empty($par['state3']) ? $par['state3'] : '已完成';
		$state4 = !empty($par['state4']) ? $par['state4'] : '拒绝受理';
		$state5 = !empty($par['state5']) ? $par['state5'] : '已取消';
		$state8 = !empty($par['state8']) ? $par['state8'] : '退回修改';		
		$state = array (
			'0' => array('css' => 'weui_btn_default', 'css2' => 'btn-default', 'name' => $state1),
			'1' => array('css' => 'weui_btn_primary', 'css2' => 'btn-success', 'name' => $state2),
			'2' => array('css' => 'weui_btn_warn', 'css2' => 'btn-warning', 'name' => $state4),
			'3' => array('css' => 'bg-blue', 'css2' => 'btn-primary', 'name' => $state3),
			'7' => array('css' => 'weui_btn_disabled weui_btn_warn', 'css2' => 'btn-danger', 'name' => '已退款'),
			'8' => array('css' => 'bg-orange', 'css2' => 'btn-warning', 'name' => $state8),
			'9' => array('css' => 'weui_btn_disabled weui_btn_warn', 'css2' => 'btn-warning', 'name' => $state5)
		);
		return $state[$status];
    }
	
    public function get_color($reid, $color) {
        global $_W, $_GPC;	
		$state = array (
			'' => array('css' => 'weui_btn_primary', 'css2' => 'btn-default'),
			'0' => array('css' => 'weui_btn_primary', 'css2' => 'btn-default'),
			'1' => array('css' => 'bg-blue', 'css2' => 'btn-success'),
			'2' => array('css' => 'bg-orange', 'css2' => 'btn-warning'),
			'3' => array('css' => 'weui_btn_warn', 'css2' => 'btn-primary')
		);
		return $state[$color];
    }
	
	public function error_code($code, $errmsg = '未知错误') {
		$errors = array(
			'-1' => '系统繁忙',
			'0' => '请求成功',
			'40001' => '获取access_token时AppSecret错误，或者access_token无效',
			'40002' => '不合法的凭证类型',
			'40003' => '不合法的OpenID',
			'40004' => '不合法的媒体文件类型',
			'40005' => '不合法的文件类型',
			'40006' => '不合法的文件大小',
			'40007' => '不合法的媒体文件id',
			'40008' => '不合法的消息类型',
			'40009' => '不合法的图片文件大小',
			'40010' => '不合法的语音文件大小',
			'40011' => '不合法的视频文件大小',
			'40012' => '不合法的缩略图文件大小',
			'40013' => '不合法的APPID',
			'40014' => '不合法的access_token',
			'40015' => '不合法的菜单类型',
			'40016' => '不合法的按钮个数',
			'40017' => '不合法的按钮个数',
			'40018' => '不合法的按钮名字长度',
			'40019' => '不合法的按钮KEY长度',
			'40020' => '不合法的按钮URL长度',
			'40021' => '不合法的菜单版本号',
			'40022' => '不合法的子菜单级数',
			'40023' => '不合法的子菜单按钮个数',
			'40024' => '不合法的子菜单按钮类型',
			'40025' => '不合法的子菜单按钮名字长度',
			'40026' => '不合法的子菜单按钮KEY长度',
			'40027' => '不合法的子菜单按钮URL长度',
			'40028' => '不合法的自定义菜单使用用户',
			'40029' => '不合法的oauth_code',
			'40030' => '不合法的refresh_token',
			'40031' => '不合法的openid列表',
			'40032' => '不合法的openid列表长度',
			'40033' => '不合法的请求字符，不能包含\uxxxx格式的字符',
			'40035' => '不合法的参数',
			'40038' => '不合法的请求格式',
			'40039' => '不合法的URL长度',
			'40050' => '不合法的分组id',
			'40051' => '分组名字不合法',
			'41001' => '缺少access_token参数',
			'41002' => '缺少appid参数',
			'41003' => '缺少refresh_token参数',
			'41004' => '缺少secret参数',
			'41005' => '缺少多媒体文件数据',
			'41006' => '缺少media_id参数',
			'41007' => '缺少子菜单数据',
			'41008' => '缺少oauth code',
			'41009' => '缺少openid',
			'42001' => 'access_token超时',
			'42002' => 'refresh_token超时',
			'42003' => 'oauth_code超时',
			'43001' => '需要GET请求',
			'43002' => '需要POST请求',
			'43003' => '需要HTTPS请求',
			'43004' => '需要接收者关注',
			'43005' => '需要好友关系',
			'44001' => '多媒体文件为空',
			'44002' => 'POST的数据包为空',
			'44003' => '图文消息内容为空',
			'44004' => '文本消息内容为空',
			'45001' => '多媒体文件大小超过限制',
			'45002' => '消息内容超过限制',
			'45003' => '标题字段超过限制',
			'45004' => '描述字段超过限制',
			'45005' => '链接字段超过限制',
			'45006' => '图片链接字段超过限制',
			'45007' => '语音播放时间超过限制',
			'45008' => '图文消息超过限制',
			'45009' => '接口调用超过限制',
			'45010' => '创建菜单个数超过限制',
			'45015' => '回复时间超过限制',
			'45016' => '系统分组，不允许修改',
			'45017' => '分组名字过长',
			'45018' => '分组数量超过上限',
			'45056' => '创建的标签数过多，请注意不能超过100个',
			'45057' => '该标签下粉丝数超过10w，不允许直接删除',
			'45058' => '不能修改0/1/2这三个系统默认保留的标签',
			'45059' => '有粉丝身上的标签数已经超过限制',
			'45157' => '标签名非法，请注意不能和其他标签重名',
			'45158' => '标签名长度超过30个字节',
			'45159' => '非法的标签',
			'46001' => '不存在媒体数据',
			'46002' => '不存在的菜单版本',
			'46003' => '不存在的菜单数据',
			'46004' => '不存在的用户',
			'47001' => '解析JSON/XML内容错误',
			'48001' => 'api功能未授权',
			'50001' => '用户未授权该api',
			'40070' => '基本信息baseinfo中填写的库存信息SKU不合法。',
			'41011' => '必填字段不完整或不合法，参考相应接口。',
			'40056' => '无效code，请确认code长度在20个字符以内，且处于非异常状态（转赠、删除）。',
			'43009' => '无自定义SN权限，请参考开发者必读中的流程开通权限。',
			'43010' => '无储值权限,请参考开发者必读中的流程开通权限。',
			'43011' => '无积分权限,请参考开发者必读中的流程开通权限。',
			'40078' => '无效卡券，未通过审核，已被置为失效。',
			'40079' => '基本信息base_info中填写的date_info不合法或核销卡券未到生效时间。',
			'45021' => '文本字段超过长度限制，请参考相应字段说明。',
			'40080' => '卡券扩展信息cardext不合法。',
			'40097' => '基本信息base_info中填写的参数不合法。',
			'49004' => '签名错误。',
			'43012' => '无自定义cell跳转外链权限，请参考开发者必读中的申请流程开通权限。',
			'40099' => '该code已被核销。',
			'61005' => '缺少接入平台关键数据，等待微信开放平台推送数据，请十分钟后再试或是检查“授权事件接收URL”是否写错（index.php?c=account&amp;a=auth&amp;do=ticket地址中的&amp;符号容易被替换成&amp;amp;）',
			'61023' => '请重新授权接入该公众号',
		);
		$code = strval($code);
		if($code == '40001' || $code == '42001') {
			$cachekey = "accesstoken:{$this->account['acid']}";
			cache_delete($cachekey);
			return '微信公众平台授权异常, 系统已修复这个错误, 请刷新页面重试.';
		}
		if($errors[$code]) {
			return $errors[$code];
		} else {
			return $errmsg;
		}
	}

	public function get_count($reid){
		global $_GPC,$_W;
		return pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->tb_info)." WHERE reid = :reid", array(":reid" => $reid));
	}

	public function from_export_parse($htmlheader,$from,$reid){
		$activity = pdo_get($this->tb_form, array('reid' => $reid));
		$par = iunserializer($activity['par']);
		$la = iunserializer($activity['linkage']);
   //         $tablelength = count($htmlheader) + 1;
            /* 输入到CSV文件 */
		$keys = array_keys($htmlheader);
				$html = "\xEF\xBB\xBF";
		foreach ($htmlheader as $li) {
			$html .= $li . "\t ,";
		}
				/* 输出内容 */
		$html .= "\n";
		$count = count($from);
		$pagesize = ceil($count/5000);
		for ($j = 1; $j <= $pagesize; $j++) {
			$list = array_slice($from, ($j-1) * 5000, 5000);
			if (!empty($list)) {
				$size = ceil(count($list) / 500);
				for ($i = 0; $i < $size; $i++) {
					$buffer = array_slice($list, $i * 500, 500);
					$user = array();
					foreach ($buffer as $row) {
						$status = $this->get_status($row['reid'],$row['status']);		
						if($activity['plural']){
							if(!empty($row['thumb'])){
								foreach (iunserializer($row['thumb']) as $pic) {
									$row['thumb'] = tomedia($pic)."，";
								}
							}else{
								$row['thumb'] = "无";
							}
						}
						if(!empty($la)){
							$row['la'] = iunserializer($row['linkage']);
							$row['l1t'] = $this->get_linkage($row['la']['l1'],'');
							$row['l2t'] = $this->get_linkage($row['la']['l2'],'');				
							$row['l1'] = $row['l1t']['title'];
							$row['l2'] = $row['l2t']['title'];
						}
						if($par['var1']){			
							$row['var1'] = $row['var1'];
						}
						if($par['var2']){			
							$row['var2'] = $row['var2'];
						}
						if($par['var3']){			
							$row['var3'] = $row['var3'];
						}
						$row['status'] = $status['name'];
						$row['html'] = $row['kfinfo'];
						$row['createtime'] = date('Y-m-d H:i:s', $row['createtime']);
						foreach ($keys as $key) {
							foreach ($row['fields'] as $index => $field) {
								if (strstr($field, 'images') || strstr($field, 'dayu_form')) {
									$row[] = str_replace(array("\n", "\r", "\t"), '', $_W['attachurl'] . $field);
								} else {
									$row[] = str_replace(array("\n", "\r", ",", "\t"), '，', $field);
								}
							}
							$data[] = $row[$key];
						}
						$user[] = implode("\t ,", $data) . "\t ,";
						unset($data);
					}
					$html .= implode("\n", $user) . "\n";
				}
			}
		}
		return $html;
	}
}
function array_multi2single($array)  
{  
    //首先定义一个静态数组常量用来保存结果  
    static $result_array = array();  
    //对多维数组进行循环  
    foreach ($array as $value) {  
        //判断是否是数组，如果是递归调用方法  
        if (is_array($value)) {  
            array_multi2single($value);  
        } else  //如果不是，将结果放入静态数组常量  
            $result_array [] = $value;  
    }  
    //返回结果（静态数组常量）  
    return $result_array;  
} 