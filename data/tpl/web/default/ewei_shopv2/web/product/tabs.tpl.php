<?php defined('IN_IA') or exit('Access Denied');?><div class='menu-header'>产品注册</div>
<ul>
	<?php if(cv('product')) { ?>
		<li <?php  if($_W[ 'action']=='product' ) { ?>class="active" <?php  } ?>><a href="<?php  echo webUrl('product')?>">注册列表</a></li>
	<?php  } ?>

</ul>

<?php if(cv('product.set')) { ?>
	<div class='menu-header'>设置</div>
	<ul>
		<li <?php  if($_W[ 'action']=='set' ) { ?>class="active" <?php  } ?>><a href="<?php  echo webUrl('product/set')?>">基础设置</a></li>
	</ul>
<?php  } ?>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4-->