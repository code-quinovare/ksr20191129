<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$_W['page']['title'] = '为你优选';
$sid = $store['id'];
$do = 'recommend';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';
if($op == 'list') {
	$recommends = pdo_getall('tiny_wmall_plus_store', array('is_recommend' => 1), array('id','title','logo'));
	foreach($recommends as $k => &$v){
		$v['logo'] = tomedia($v['logo']);
	}
}
include $this->template('plateform/recommend');