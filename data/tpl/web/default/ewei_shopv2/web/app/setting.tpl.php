<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<form <?php if(cv('app.setting.edit')) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" enctype="multipart/form-data" >

    <div class="page-heading">
        <?php if(cv('app.setting.edit')) { ?>
            <span class="pull-right">
                <input type="submit" value="提交" class="btn btn-primary">
            </span>
        <?php  } ?>
        <h2>基本设置</h2>
    </div>

    <div class="form-group">
        <label class="col-xs-12 col-sm-3 col-md-2 control-label must" style="padding-top: 0;">AppID<br>(小程序ID)</label>
        <div class="col-sm-9">
            <input class="form-control valid" value="<?php  echo $data['appid'];?>" <?php if(cv('app.setting.edit')) { ?>name="data[appid]"<?php  } else { ?>disabled<?php  } ?> />
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-12 col-sm-3 col-md-2 control-label must" style="padding-top: 0;">AppSecret<br>(小程序密钥)</label>
        <div class="col-sm-9">
            <input class="form-control valid" name="data[secret]" value="<?php  echo $data['secret'];?>" <?php if(cv('app.setting.edit')) { ?>name="data[secret]"<?php  } else { ?>disabled<?php  } ?> />
        </div>
    </div>

    <div class="form-group-title"></div>

    <div class="form-group">
        <label class="col-xs-12 col-sm-3 col-md-2 control-label">维护小程序</label>
        <div class="col-sm-9">
            <label class="radio-inline"><input class="toggle" data-show="1" data-class="closetext" type="radio" value="1" <?php  if(!empty($data['isclose'])) { ?>checked<?php  } ?>  <?php if(cv('app.setting.edit')) { ?>name="data[isclose]"<?php  } else { ?>disabled<?php  } ?> > 维护中</label>
            <label class="radio-inline"><input class="toggle" data-show="0" data-class="closetext" type="radio" value="0" <?php  if(empty($data['isclose'])) { ?>checked<?php  } ?> <?php if(cv('app.setting.edit')) { ?>name="data[isclose]"<?php  } else { ?>disabled<?php  } ?> >正常</label>
        </div>
    </div>

    <div class="form-group closetext" <?php  if(empty($data['isclose'])) { ?>style="display: none"<?php  } ?>>
        <label class="col-xs-12 col-sm-3 col-md-2 control-label must">维护说明</label>
        <div class="col-sm-9">
            <textarea class="form-control" <?php if(cv('app.setting.edit')) { ?>name="data[closetext]"<?php  } else { ?>disabled<?php  } ?>><?php  echo $data['closetext'];?></textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-12 col-sm-3 col-md-2 control-label">开启用户绑定</label>
        <div class="col-sm-9">
            <label class="radio-inline"><input class="toggle" data-show="1" data-class="openbind" type="radio" value="1" <?php  if(!empty($data['openbind'])) { ?>checked<?php  } ?> <?php if(cv('app.setting.edit')) { ?>name="data[openbind]"<?php  } else { ?>disabled<?php  } ?>> 开启</label>
            <label class="radio-inline"><input class="toggle" data-show="0" data-class="openbind" type="radio" value="0" <?php  if(empty($data['openbind'])) { ?>checked<?php  } ?> <?php if(cv('app.setting.edit')) { ?>name="data[openbind]"<?php  } else { ?>disabled<?php  } ?>>关闭</label>
            <div class="help-block">注意：如果<span class="text-danger">小程序开启用户绑定或者WAP端开启</span> 都为开启用户绑定</div>
        </div>
    </div>

    <div class="form-group openbind" <?php  if(empty($data['openbind'])) { ?>style="display: none"<?php  } ?>>
        <label class="col-sm-2 control-label must">绑定短信模板</label>
        <div class="col-sm-9 col-xs-12">
            <select class="select2" style="display: block; width: 100%" <?php if(cv('app.setting.edit')) { ?>name="data[sms_bind]"<?php  } else { ?>disabled<?php  } ?>>
            <option value=''>从短信消息库中选择</option>
            <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
            <option value="<?php  echo $template_val['id'];?>" <?php  if($data['sms_bind']==$template_val['id']) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
            <?php  } } ?>
            </select>
        </div>
    </div>

    <div class="form-group openbind" <?php  if(empty($data['openbind'])) { ?>style="display: none"<?php  } ?>>
        <label class="col-sm-2 control-label">绑定提示文字</label>
        <div class="col-sm-9 col-xs-12">
            <textarea class="form-control" <?php if(cv('app.setting.edit')) { ?>name="data[bindtext]"<?php  } else { ?>disabled<?php  } ?>><?php  echo $data['bindtext'];?></textarea>
            <div class="help-block">提示：此处文字显示在会员中心提示绑定手机号位置，不填默认显示“绑定手机号可合并或同步您其他账号数据”</div>
        </div>
    </div>

    <div class="form-group-title"></div>

    <div class="form-group">
        <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否显示分销</label>
        <div class="col-sm-9">
            <label class="radio-inline"><input type="radio" value="0" <?php  if(empty($data['hidecom'])) { ?>checked<?php  } ?> <?php if(cv('app.setting.edit')) { ?>name="data[hidecom]"<?php  } else { ?>disabled<?php  } ?> >显示</label>
            <label class="radio-inline"><input type="radio" value="1" <?php  if(!empty($data['hidecom'])) { ?>checked<?php  } ?>  <?php if(cv('app.setting.edit')) { ?>name="data[hidecom]"<?php  } else { ?>disabled<?php  } ?> > 不显示</label>
            <div class="help-block">提示：此处关闭后则不在会员中心显示分销入口</div>
        </div>
    </div>

</form>

<script type="text/javascript">
    $(".toggle").unbind('click').click(function () {
        var show = $(this).data('show');
        var classs = $(this).data('class');
        var eml = $("."+classs);
        if(show){
            eml.show();
        }else {
            eml.hide();
        }
    })
    
    $("form").submit(function () {
        var openbind = $("input[name='data[openbind]']:checked").val();
        if(openbind==1){
            var sms_bind = $("select[name='data[sms_bind]'] option:selected").val();
            if(!sms_bind){
                tip.msgbox.err('开启用户绑定请先选择绑定短信模板');
                $('form').attr('stop',1);
                return;
            }
        }
        $('form').removeAttr('stop');
        return true;
    })
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>