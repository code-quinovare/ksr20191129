<?php
defined('IN_IA') || exit('Access Denied');
icheckauth();
if (!(empty($_W['member']))) 
{
	if (MODULE_FAMILY == 'wxapp') 
	{
		echo '绑定粉丝成功';
		exit();
	}
	imessage('绑定粉丝成功', 'close', 'success');
}
if (MODULE_FAMILY == 'wxapp') 
{
	echo '绑定粉丝失败,请重新绑定';
	exit();
}
imessage('绑定粉丝失败,请重新绑定', 'close', 'info');
?>