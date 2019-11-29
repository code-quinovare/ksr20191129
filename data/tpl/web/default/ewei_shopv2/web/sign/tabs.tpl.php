<?php defined('IN_IA') or exit('Access Denied');?><ul class="menu-head-top">
	<li><a href="<?php  echo webUrl('sign')?>"><?php  echo $this->plugintitle?> <i class="fa fa-caret-right"></i></a></li>
</ul>

<?php if(cv('sign.rule|sign.set')) { ?>
<div class='menu-header'>签到设置</div>
<ul>
	<?php if(cv('sign.rule')) { ?>
		<li <?php  if($_GPC['r']=='sign.rule') { ?> class="active"<?php  } ?>><a href="<?php  echo webUrl('sign/rule')?>">签到规则</a></li>
	<?php  } ?>
	<?php if(cv('sign.set')) { ?>
		<li <?php  if($_GPC['r']=='sign.set') { ?> class="active"<?php  } ?>><a href="<?php  echo webUrl('sign/set')?>">签到入口</a></li>
	<?php  } ?>
</ul>
<?php  } ?>

<?php if(cv('sign.records')) { ?>
	<div class='menu-header'>签到记录</div>
	<ul>
		<li <?php  if($_GPC['r']=='sign.records') { ?> class="active"<?php  } ?>><a href="<?php  echo webUrl('sign/records')?>">签到记录</a></li>
	</ul>
<?php  } ?>
