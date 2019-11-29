<?php defined('IN_IA') or exit('Access Denied');?><div class='menu-header'><?php  echo $this->plugintitle?></div>
<ul>
    <li <?php  if($_W['action']=='') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('messages')?>">消息群发</a></li>
    <li <?php  if($_W['action']=='template') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('messages/template')?>">模板设置</a></li>
</ul>

<!--4000097827-->