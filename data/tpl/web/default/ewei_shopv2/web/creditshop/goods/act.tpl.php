<?php defined('IN_IA') or exit('Access Denied');?>
<div class="form-group">
    <label class="col-sm-2 control-label">是否开启抽奖</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <label class="radio-inline"><input type="radio" name='type' value="0" <?php  if(empty($item['type'])) { ?>checked<?php  } ?> <?php  if(!empty($item)) { ?> disabled<?php  } ?> /> 否</label>
            <label class="radio-inline"><input type="radio" name='type' value="1" <?php  if($item['type']==1) { ?>checked<?php  } ?> <?php  if(!empty($item)) { ?> disabled<?php  } ?> /> 是</label>
            <div class="help-block">保存后不可更改</div>
        <?php  } else { ?>
            <div class='form-control-static'><?php  if(empty($item['type'])) { ?>否<?php  } else { ?>是<?php  } ?></div>
        <?php  } ?>
    </div>
</div>
<!--<div class="form-group">
    <label class="col-sm-2 control-label">活动范围</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <input type='text' class='form-control' name='area' value="<?php  echo $item['area'];?>" />
            <span class='help-block'>不填写默认"全国" (只做显示作用)</span>
        <?php  } else { ?>
            <div class='form-control-static'><?php  echo $item['area'];?></div>
        <?php  } ?>
    </div>
</div>-->

<div class="form-group rate" id='rate' style="<?php  if(empty($item['type'])) { ?>display:none<?php  } ?>">
    <label class="col-sm-2 control-label must">中奖几率</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <div class="input-group">
                <input type='text' class='form-control' value="<?php  echo $item['rate2'];?>" name='rate2' />
                <span class="input-group-addon" style="border-left: 0; border-right: 0;">分之</span>
                <input type='text' class='form-control' value="<?php  echo $item['rate1'];?>" name='rate1'/>
            </div>
            <span class="help-block" style="margin-bottom: 0;">同时填写才能生效，否则为中奖几率为0 ,填写相同值（且不等于0）为中奖率100%</span>
        <?php  } else { ?>
            <div class='form-control-static'>
                <?php  if(!empty($item['rate1']) && !empty($item['rate2'])) { ?>
                    <?php  if($item['rate1']==$item['rate2']) { ?>必中<?php  } else { ?><?php  echo $item['rate2'];?>分之<?php  echo $item['rate1'];?><?php  } ?>
                <?php  } else { ?>永不中奖
                <?php  } ?>
            </div>
        <?php  } ?>
    </div>
</div>


<script language='javascript'>
$(function(){
    $(':radio[name=type]').click(function(){
        if($(this).val()=='1'){
            $('.rate').show();
        }
        else{
            $('.rate').hide();
        }
    })
    $("input[name='isendtime']").on("click",function(){
        if($(this).val()=='1'){
            $("#usetime").hide();
            $("#endtime").show();
        }else{
            $("#usetime").show();
            $("#endtime").hide();
        }
    });
    
})    
</script>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->