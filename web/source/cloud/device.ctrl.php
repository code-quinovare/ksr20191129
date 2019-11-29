<?php
defined('IN_IA') or exit('Access Denied');
if ($do == 'online') {
	
	exit;
} elseif ($do == 'offline') {
	
	exit;
} else {
}
template('cloud/device');
