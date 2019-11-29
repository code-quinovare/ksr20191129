<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'product',
	'name'    => '产品注册',
	'v3'      => true,
	'menu'    => array(
		'plugincom' => 1,
		'items'     => array(
			array(
				'title'   => '产品注册',
				'route'   => '',
				'extends' => array('product')
				),
			array('title' => '注册列表', 'route' => 'list'),
			array('title' => '平台设置', 'route' => 'set')
			)
		)
	);

?>
