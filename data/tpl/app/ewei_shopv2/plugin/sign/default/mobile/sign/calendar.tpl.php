<?php defined('IN_IA') or exit('Access Denied');?><?php  if(is_array($calendar)) { foreach($calendar as $week) { ?>
<div class="week">
    <?php  if(is_array($week)) { foreach($week as $day) { ?>
    <nav class="day <?php  if(!empty($day['today'])) { ?>today<?php  } ?>" data-day="<?php  echo $day['day'];?>" data-month="<?php  echo $day['month'];?>" data-date="<?php  echo $day['date'];?>" data-signed="<?php  echo $day['signed'];?>">
        <?php  if(!empty($day['day'])) { ?>
            <p class="num"><?php  echo $day['day'];?></p>
            <?php  if(!empty($day['title'])) { ?>
                <p class="act" style="background: <?php  echo $day['color'];?>;"><?php  echo $day['title'];?></p>
            <?php  } ?>
            <?php  if(!empty($day['signed'])) { ?>
                <i class="icon icon-check signed"></i>
            <?php  } ?>
        <?php  } ?>
    </nav>
    <?php  } } ?>
</div>
<?php  } } ?>
