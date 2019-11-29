<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-sm-2 control-label">是否显示统一兑换流程</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <label class='radio radio-inline'>
            <input type='radio' value='0' name='data[isdetail]' <?php  if($data['isdetail']==0) { ?>checked<?php  } ?> /> 关闭
        </label>
        <label class='radio radio-inline'>
            <input type='radio' value='1' name='data[isdetail]'  <?php  if($data['isdetail']==1) { ?>checked<?php  } ?> /> 显示
        </label>
        <?php  } else { ?>
        <div class='form-control-static'><?php  if($data['isdetail']==1) { ?>显示<?php  } else { ?>关闭<?php  } ?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">统一兑换流程</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <?php  echo tpl_ueditor('data[detail]',$data['detail'],array('height'=>'200'))?>
        <?php  } else { ?>
        <textarea id='credit_detail' name='data[detail]' style='display:none;'><?php  echo $data['detail'];?></textarea>
        <a href='javascript:preview_html("#credit_detail")' class="btn btn-default">查看内容</a>
        <?php  } ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">是否显示统一注意事项</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <label class='radio radio-inline'>
            <input type='radio' value='0' name='data[isnoticedetail]' <?php  if($data['isnoticedetail']==0) { ?>checked<?php  } ?> /> 关闭
        </label>
        <label class='radio radio-inline'>
            <input type='radio' value='1' name='data[isnoticedetail]'  <?php  if($data['isnoticedetail']==1) { ?>checked<?php  } ?> /> 显示
        </label>
        <?php  } else { ?>
        <div class='form-control-static'><?php  if($data['isnoticedetail']==1) { ?>显示<?php  } else { ?>关闭<?php  } ?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">统一注意事项</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <?php  echo tpl_ueditor('data[noticedetail]',$data['noticedetail'],array('height'=>'200'))?>
        <?php  } else { ?>
        <textarea id='credit_noticedetail' name='data[noticedetail]' style='display:none;'><?php  echo $data['noticedetail'];?></textarea>
        <a href='javascript:preview_html("#credit_noticedetail")' class="btn btn-default">查看内容</a>
        <?php  } ?>
    </div>
</div>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->