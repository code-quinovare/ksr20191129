<?php defined('IN_IA') or exit('Access Denied');?> <?php  $category = m('plugin')->getList(1);$apps = false;if ($_W['role'] == 'founder' || empty($_W['role']))$apps = true;?>
 <?php  if(is_array($category)) { foreach($category as $ck => $cv) { ?>
    <?php  if(count($cv['plugins'])<=0) { ?><?php  continue;?><?php  } ?>
     <div class='menu-header'><?php  echo $cv['name'];?></div>
    <ul class="plugin_tabs">
        <?php  if(is_array($cv['plugins'])) { foreach($cv['plugins'] as $plugin) { ?>
            <?php  if(com_run('perm::check_plugin',$plugin['identity'])) { ?>
	        <?php if(cv($plugin['identity'])) { ?>
	        	<li <?php  if($_GPC['p'] == $plugin['identity']) { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl($plugin['identity'])?>"><?php  echo $plugin['name'];?></a></li>
	        <?php  } ?>
            <?php  } ?>
        <?php  } } ?>
   </ul>
 <?php  } } ?>
    <?php  if($apps) { ?>
    <div class='menu-header'>更多应用</div>
 
    <?php  } ?>
 <?php  if(p("grant")) { ?>
 <ul class="plugin_tabs">
     <li><a href="<?php  echo webUrl('plugingrant')?>">应用授权</a></li>
 </ul>
 <?php  } ?>


