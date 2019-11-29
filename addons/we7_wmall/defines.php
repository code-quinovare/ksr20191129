<?php
defined('IN_IA') || exit('Access Denied');
!(defined('WE7_WMALL_PATH')) && define('WE7_WMALL_PATH', IA_ROOT . '/addons/we7_wmall/');
!(defined('WE7_WMALL_PLUGIN_PATH')) && define('WE7_WMALL_PLUGIN_PATH', WE7_WMALL_PATH . '/plugin/');
!(defined('WE7_WMALL_URL')) && define('WE7_WMALL_URL', $_W['siteroot'] . 'addons/we7_wmall/');
!(defined('WE7_WMALL_URL_NOHTTPS')) && define('WE7_WMALL_URL_NOHTTPS', str_replace('https://', 'http://', $_W['siteroot']) . 'addons/we7_wmall/');
!(defined('WE7_WMALL_STATIC')) && define('WE7_WMALL_STATIC', WE7_WMALL_URL . 'static/');
!(defined('WE7_WMALL_LOCAL')) && define('WE7_WMALL_LOCAL', '../addons/we7_wmall/');
!(defined('WE7_WMALL_DEBUG')) && define('WE7_WMALL_DEBUG', '1');
!(defined('WE7_WMALL_ISHTTPS')) && define('WE7_WMALL_ISHTTPS', strexists($_W['siteroot'], 'https://'));
define('IREGULAR_EMAIL', '/\\w+([-+.]\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*/i');
define('IREGULAR_MOBILE', '/^[01][3456789][0-9]{9}$/');
define('IREGULAR_PASSWORD', '/[0-9]+[a-zA-Z]+[0-9a-zA-Z]*|[a-zA-Z]+[0-9]+[0-9a-zA-Z]*/');
?>