<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-heading">
    <h2>基础设置</h2>
</div>

<form id="setform"  action="" method="post" class="form-horizontal form-validate">
    <input type="hidden" id="tab" name="tab" value="<?php  echo $_GPC['tab'];?>" />
    <ul class="nav nav-tabs" id="myTab">
        <li <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='basic') { ?>class="active"<?php  } ?>><a href="#tab_basic">基本设置</a></li>
        <li <?php  if($_GPC['tab']=='comment') { ?>class="active"<?php  } ?>><a href="#tab_comment">评论设置</a></li>
        <li <?php  if($_GPC['tab']=='info') { ?>class="active"<?php  } ?>><a href="#tab_info">详情设置</a></li>
        <!--<li <?php  if($_GPC['tab']=='payset') { ?>class="active"<?php  } ?>><a href="#tab_payset">支付设置</a></li>-->
    </ul>
    <div class="tab-content">
        <div class="tab-pane <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='basic') { ?>active<?php  } ?>" id="tab_basic"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('creditshop/set/tab_basic', TEMPLATE_INCLUDEPATH)) : (include template('creditshop/set/tab_basic', TEMPLATE_INCLUDEPATH));?></div>
        <div class="tab-pane <?php  if($_GPC['tab']=='comment') { ?>active<?php  } ?>" id="tab_comment"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('creditshop/set/tab_comment', TEMPLATE_INCLUDEPATH)) : (include template('creditshop/set/tab_comment', TEMPLATE_INCLUDEPATH));?></div>
        <div class="tab-pane <?php  if($_GPC['tab']=='info') { ?>active<?php  } ?>" id="tab_info"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('creditshop/set/tab_info', TEMPLATE_INCLUDEPATH)) : (include template('creditshop/set/tab_info', TEMPLATE_INCLUDEPATH));?></div>
        <!--<div class="tab-pane <?php  if($_GPC['tab']=='payset') { ?>active<?php  } ?>" id="tab_payset"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('creditshop/set/tab_payset', TEMPLATE_INCLUDEPATH)) : (include template('creditshop/set/tab_payset', TEMPLATE_INCLUDEPATH));?></div>-->
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-9">
            <?php if(cv('creditshop.set.edit')) { ?>
            <input type="submit" value="提交" class="btn btn-primary"/>
            <?php  } ?>
        </div>
    </div>
</form>

<script language='javascript'>
    require(['bootstrap'],function(){
        $('#myTab a').click(function (e) {
            e.preventDefault();
            $('#tab').val( $(this).attr('href').replace('#tab_',''));
            $(this).tab('show');
        })
    });
</script>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->