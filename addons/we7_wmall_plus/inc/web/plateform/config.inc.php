<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$_W['page']['title'] = '参数设置';
$do = 'config';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'basic';

$config = sys_config();
if(empty($config['id'])) {
	$init_config = array(
		'uniacid' => $_W['uniacid']
	);
	pdo_insert('tiny_wmall_plus_config', $init_config);
}

$setting = uni_setting($_W['uniacid']);
if($op == 'basic') {
	if(checksubmit('submit')) {
		$data = array(
			'uniacid' => $_W['uniacid'],
			'title' => trim($_GPC['title']),
			'mobile' => trim($_GPC['mobile']),
			'content' => trim($_GPC['content']),
			'thumb' => trim($_GPC['thumb']),
			'follow_guide_status' => intval($_GPC['follow_guide_status']),
			'followurl' => trim($_GPC['followurl']),
			'public_tpl' => trim($_GPC['public_tpl']),
			'notice' => iserializer($_GPC['notice']),
			'version' => intval($_GPC['version']),
			'default_sid' => intval($_GPC['default_sid']),
			'copyright' => iserializer($_GPC['copyright']),
			'manager' => iserializer($_GPC['manager']),
			'store_orderby_type' => trim($_GPC['store_orderby_type']),
		);
		if(!empty($config['id'])) {
			pdo_update('tiny_wmall_plus_config', $data, array('uniacid' => $_W['uniacid']));
		} else {
			pdo_insert('tiny_wmall_plus_config', $data);
		}
		message('设置参数成功', referer(), 'success');
	}
	$stores = pdo_getall('tiny_wmall_plus_store', array('uniacid' => $_W['uniacid']));
	include $this->template('plateform/config-basic');
}

if($op == 'pay') {
	load()->func('file');
	if(checksubmit('submit')) {
		$payment = array(
			'wechat' => intval($_GPC['wechat']),
			'alipay' => intval($_GPC['alipay']),
			'credit' => intval($_GPC['credit']),
			'delivery' => intval($_GPC['delivery']),
			'wechat_cert' => $config['payment']['wechat_cert'],
			'alipay_cert' => $config['payment']['alipay_cert'],
		);
		$data = array(
			'uniacid' => $_W['uniacid'],
			'payment' => iserializer($payment),
		);
		if(!empty($config['id'])) {
			pdo_update('tiny_wmall_plus_config', $data, array('uniacid' => $_W['uniacid']));
		} else {
			pdo_insert('tiny_wmall_plus_config', $data);
		}
		$keys = $config['payment']['wechat_cert'];
		if(!isset($keys['apiclient_cert'])) {
			$keys = array(
				'apiclient_cert' => '',
				'apiclient_key' => '',
				'rootca' => '',
			);
		}
		$cert_root = 'cert/';
		$ok = 1;
		$cert = 0;
		foreach($keys as $key => $val) {
			if(!empty($_GPC[$key])) {
				$cert = 1;
				@unlink(MODULE_ROOT . '/'. $cert_root . $keys[$key]."/{$key}.pem");
				@rmdir(MODULE_ROOT . '/'.  $cert_root . $keys[$key]);
				$keys[$key] = random(10);
				$status = ifile_put_contents($cert_root.$keys[$key]."/{$key}.pem", trim($_GPC[$key]));
				if(!$status && $ok) {
					$ok = 0;
				}
			}
		}
		if(!$ok) {
			message('保存微信证书文件失败', referer(), 'error');
		}
		if($cert == 1) {
			$payment['wechat_cert'] = $keys;
			$data = array(
				'payment' => iserializer($payment),
			);
			pdo_update('tiny_wmall_plus_config', $data, array('uniacid' => $_W['uniacid']));
		}

		$keys = $config['payment']['alipay_cert'];
		if(!isset($keys['private_key'])) {
			$keys = array(
				'private_key' => '',
				'public_key' => '',
			);
		}
		unset($keys['app_id']);
		$cert_root = 'cert/';
		$ok = 1;
		$cert = 0;
		foreach($keys as $key => $val) {
			if(!empty($_GPC[$key])) {
				$cert = 1;
				@unlink(MODULE_ROOT . '/'. $cert_root . $keys[$key]."/{$key}.pem");
				@rmdir(MODULE_ROOT . '/'.  $cert_root . $keys[$key]);
				$keys[$key] = random(10);
				$text = "-----BEGIN RSA PRIVATE KEY-----\n" . trim($_GPC[$key]) . "\n-----END RSA PRIVATE KEY-----";
				$status = ifile_put_contents($cert_root.$keys[$key]."/{$key}.pem", $text);
				if(!$status && $ok) {
					$ok = 0;
				}
			}
		}
		if(!$ok) {
			message('保存微信证书文件失败', referer(), 'error');
		}
		if($cert == 1) {
			$payment['alipay_cert'] = $keys;
			$payment['alipay_cert']['app_id'] = trim($_GPC['app_id']);
		} else {
			$payment['alipay_cert']['app_id'] = trim($_GPC['app_id']);
		}
		$payment['available'] = array();
		foreach($payment as $key => $row) {
			if(in_array($key, array('credit', 'wechat', 'alipay', 'delivery')) && $row == 1) {
				$payment['available'][] = $key;
			}
		}
		$data = array(
			'payment' => iserializer($payment),
		);
		pdo_update('tiny_wmall_plus_config', $data, array('uniacid' => $_W['uniacid']));
		message('设置参数成功', referer(), 'success');
	}
	include $this->template('plateform/config-pay');
}

if($op == 'report') {
	if(checksubmit('submit')) {
		$report = array();
		foreach($_GPC['report'] as $value) {
			$value = trim($value);
			if(empty($value)) continue;
			$report[] = $value;
		}
		if(!empty($report)) {
			$data = array('report' => iserializer($report));
			pdo_update('tiny_wmall_plus_config', $data , array('uniacid' => $_W['uniacid']));
		}
		message('设置投诉类型成功', referer(), 'success');
	}
	include $this->template('plateform/config-report');
}




