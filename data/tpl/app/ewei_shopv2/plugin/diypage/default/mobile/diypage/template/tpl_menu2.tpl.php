<?php defined('IN_IA') or exit('Access Denied');?><?php  if(!empty($diyitem['data'])) { ?>
    <div class="fui-menu-group" style="margin-top: <?php  echo $diyitem['style']['margintop'];?>px;">
        <?php  if(is_array($diyitem['data'])) { foreach($diyitem['data'] as $menuitem) { ?>
            <?php  if(!empty($menuitem['text'])) { ?>
                <a class="fui-menu-item" style="<?php  if($diyitem['style']['background']!='#ffffff') { ?>background:<?php  echo $diyitem['style']['background'];?>;<?php  } ?> color: <?php  echo $menuitem['textcolor'];?>;" href="<?php  echo $menuitem['linkurl'];?>" data-nocache="true"><?php  if(!empty($menuitem['iconclass'])) { ?><i class="icon <?php  echo $menuitem['iconclass'];?>" style="color: <?php  echo $menuitem['iconcolor'];?>;"></i><?php  } ?> <?php  echo $menuitem['text'];?></a>
            <?php  } ?>
        <?php  } } ?>
    </div>
<?php  } ?>
<!--913702023503242914-->