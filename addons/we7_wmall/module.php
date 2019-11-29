<?php
//http://www.shuotupu.com
//说图谱网

defined('IN_IA') || exit('Access Denied');
include IA_ROOT . '/addons/we7_wmall/version.php';
include 'defines.php';
include 'model.php';
class We7_wmallModule extends WeModule 
{
	public function welcomeDisplay() 
	{
		header('location: ' . iurl('dashboard/index'));
		exit();
	}
}
?>