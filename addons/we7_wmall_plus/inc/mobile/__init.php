<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
mload()->model('store');
mload()->model('order');

$config = sys_config();
$_W['we7_wmall_plus']['config'] = $config;

function cloud_w_upgrade_version($family, $version, $release) {
	$verfile = MODULE_ROOT . '/version.php';
	$verdat = <<<VER
<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
define('MODULE_FAMILY', '{$family}');
define('MODULE_VERSION', '{$version}');
define('MODULE_RELEASE_DATE', '{$release}');
VER;
	file_put_contents($verfile, trim($verdat));
}
