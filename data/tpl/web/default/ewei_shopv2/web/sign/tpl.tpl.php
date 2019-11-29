<?php defined('IN_IA') or exit('Access Denied');?><?php  if($tpltype==1) { ?>
    <div class="input-group">
        <span class="input-group-addon">连续签到</span>
        <input class="form-control" type="number" value="<?php  echo intval($item['day'])?>" <?php if(cv('sign.rule.edit')) { ?> name="reword_order[day][]"<?php  } else { ?>disabled<?php  } ?> />
        <span class="input-group-addon" style="border-left: 0; border-right: 0;">天 奖励</span>
        <input class="form-control" type="number" value="<?php  echo intval($item['credit'])?>" <?php if(cv('sign.rule.edit')) { ?> name="reword_order[credit][]"<?php  } else { ?>disabled<?php  } ?> />
        <span class="input-group-addon" style="border-left: 0; border-right: 0;">积分</span>
        <span class="form-control <?php if(cv('sign.rule.edit')) { ?>btn btn-default delrule<?php  } else { ?> btn-disabled<?php  } ?>">删除</span>
    </div>
<?php  } else if($tpltype==2) { ?>
    <div class="input-group">
        <span class="input-group-addon">总签到</span>
        <input class="form-control" type="number" value="<?php  echo intval($item['day'])?>" <?php if(cv('sign.rule.edit')) { ?> name="reword_sum[day][]"<?php  } else { ?>disabled<?php  } ?> />
        <span class="input-group-addon" style="border-left: 0; border-right: 0;">天 奖励</span>
        <input class="form-control" type="number" value="<?php  echo intval($item['credit'])?>" <?php if(cv('sign.rule.edit')) { ?> name="reword_sum[credit][]"<?php  } else { ?>disabled<?php  } ?> />
        <span class="input-group-addon" style="border-left: 0; border-right: 0;">积分</span>
        <span class="form-control <?php if(cv('sign.rule.edit')) { ?>btn btn-default delrule<?php  } else { ?> btn-disabled<?php  } ?>">删除</span>
    </div>
<?php  } else if($tpltype==3) { ?>
    <div class="input-group">
        <span class="input-group-addon">日期</span>
        <?php if(cv('sign.rule.edit')) { ?>
            <?php echo tpl_form_field_date('reword_special[date][]', !empty($item['date']) ? date('Y-m-d',$item['date']) : date('Y-m-d'), false)?>
        <?php  } else { ?>
            <input class="form-control" value="<?php  echo date('Y-m-d', $item['date'])?>" style="width: 90px; padding: 5px;" disabled />
        <?php  } ?>
        <span class="input-group-addon" style="border-left: 0; border-right: 0;">标题</span>
        <input class="form-control" value="<?php  echo $item['title'];?>" placeholder="非必填" style="width: 90px;" <?php if(cv('sign.rule.edit')) { ?> name="reword_special[title][]"<?php  } else { ?>disabled<?php  } ?> />
        <span class="input-group-addon" style="border-left: 0; border-right: 0;">颜色</span>
        <input class="form-control" value="<?php  if(empty($item['color'])) { ?>#cccccc<?php  } else { ?><?php  echo $item['color'];?><?php  } ?>" type="color" style="width: 50px; padding: 5px;" <?php if(cv('sign.rule.edit')) { ?> name="reword_special[color][]"<?php  } else { ?>disabled<?php  } ?> />
        <span class="input-group-addon" style="border-left: 0; border-right: 0;">奖励</span>
        <input class="form-control" type="number" value="<?php  echo $item['credit'];?>" style="width: 70px;" <?php if(cv('sign.rule.edit')) { ?> name="reword_special[credit][]"<?php  } else { ?>disabled<?php  } ?>/>
        <span class="input-group-addon" style="border-left: 0; border-right: 0;">积分</span>
        <span class="form-control <?php if(cv('sign.rule.edit')) { ?>btn btn-default delrule<?php  } else { ?> btn-disabled<?php  } ?>">删除</span>
    </div>
<?php  } ?>
