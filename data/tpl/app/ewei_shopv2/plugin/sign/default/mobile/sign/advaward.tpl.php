<?php defined('IN_IA') or exit('Access Denied');?><?php  if(!empty($advaward['order'])) { ?>
    <div class="advaward">
        <div class="title" style=" font-size: 0.7rem; color: #888;">
            <span class="text"><i class="icon icon-goods1"></i> 连续<?php  echo $set['textsign'];?>有礼</span>
            <span class="subtitle">连续<?php  echo $set['textsign'];?>即可领取</span>
        </div>
        <div class="body">
            <div class="award">
                <div class="award-body">
                    <?php  if(is_array($advaward['order'])) { foreach($advaward['order'] as $item) { ?>
                        <?php  if(!empty($item['credit']) && !empty($item['day']) && $item['credit']>0) { ?>
                            <div class="item">
                                <div class="goods">+<?php  echo $item['credit'];?><br><?php  echo $set['textcredit'];?></div>
                                <div class="iconn <?php  if(!empty($item['candraw'])) { ?>candraw<?php  } ?>"><i class="icon icon-check"></i> </div>
                                <div class="days <?php  if(!empty($item['candraw'])) { ?>candraw<?php  } ?>"><?php  echo $item['day'];?>天</div>
                                <?php  if(!empty($item['drawed'])) { ?>
                                    <div class="text">已领取</div>
                                <?php  } else if(!empty($item['candraw'])) { ?>
                                    <div class="text candraw" data-type="1" data-day="<?php  echo $item['day'];?>">领取</div>
                                <?php  } else { ?>
                                    <div class="text">领取</div>
                                <?php  } ?>
                            </div>
                        <?php  } ?>
                    <?php  } } ?>
                </div>
            </div>
        </div>
    </div>
<?php  } ?>

<?php  if(!empty($advaward['sum'])) { ?>
    <div class="advaward">
        <div class="title" style=" font-size: 0.7rem; color: #888;">
            <span class="text"><i class="icon icon-magic"></i> <?php  echo $set['textsign'];?>有礼</span>
            <span class="subtitle"><?php  echo $set['textsign'];?>次数满足即可领取</span>
        </div>
        <div class="body">
            <div class="award">
                <div class="award-body">
                    <?php  if(is_array($advaward['sum'])) { foreach($advaward['sum'] as $item) { ?>
                        <?php  if(!empty($item['credit']) && !empty($item['day']) && $item['credit']>0) { ?>
                            <div class="item">
                                <div class="goods">+<?php  echo $item['credit'];?><br><?php  echo $set['textcredit'];?></div>
                                <div class="iconn <?php  if(!empty($item['candraw'])) { ?>candraw<?php  } ?>"><i class="icon icon-check"></i> </div>
                                <div class="days <?php  if(!empty($item['candraw'])) { ?>candraw<?php  } ?>"><?php  echo $item['day'];?>天</div>
                                <?php  if(!empty($item['drawed'])) { ?>
                                    <div class="text">已领取</div>
                                <?php  } else if(!empty($item['candraw'])) { ?>
                                    <div class="text candraw" data-type="2" data-day="<?php  echo $item['day'];?>">领取</div>
                                <?php  } else { ?>
                                    <div class="text">领取</div>
                                <?php  } ?>
                            </div>
                        <?php  } ?>
                    <?php  } } ?>
                </div>
            </div>
        </div>
    </div>
<?php  } ?>
