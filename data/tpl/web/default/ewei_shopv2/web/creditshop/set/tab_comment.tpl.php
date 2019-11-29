<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-sm-2 control-label">是否开启评论</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.set.edit')) { ?>
        <label class='radio radio-inline'>
            <input type='radio' value='0' name='data[isreply]' <?php  if($data['isreply']==0) { ?>checked<?php  } ?> /> 关闭
        </label>
        <label class='radio radio-inline'>
            <input type='radio' value='1' name='data[isreply]'  <?php  if($data['isreply']==1) { ?>checked<?php  } ?> /> 开启
        </label>
        <?php  } else { ?>
        <div class='form-control-static'><?php  if($data['isreply']==1) { ?>显示<?php  } else { ?>关闭<?php  } ?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">评论敏感词</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.cover.edit')) { ?>
            <textarea name='data[desckeyword]' class='form-control' rows="5"><?php  echo $data['desckeyword'];?></textarea>
            <div class="form-control-static">一行一个或用半角英文逗号(,)隔开</div>
        <?php  } else { ?>
            <div class='form-control-static'><?php  echo $data['desckeyword'];?></div>
        <?php  } ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">替换文字</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.cover.edit')) { ?>
            <input type='text' class='form-control' name='data[replykeyword]' value="<?php  echo $data['replykeyword'];?>" />
            <div class="form-control-static">将敏感字符替换为此处文字(不填则替换成‘*’)</div>
        <?php  } else { ?>
            <div class='form-control-static'><?php  echo $data['replykeyword'];?></div>
        <?php  } ?>
    </div>
</div>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->