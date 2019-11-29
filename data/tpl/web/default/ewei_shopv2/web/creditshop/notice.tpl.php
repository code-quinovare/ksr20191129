<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class='page-heading'><h2>通知设置</h2></div>
<div class='alert alert-info'>请将公众平台模板消息所在行业选择为： IT科技/互联网|电子商务</div>
<form <?php if(cv('creditshop.notice.edit')) { ?> action="" method="post" <?php  } ?> class="form-horizontal form-validate" enctype="multipart/form-data" >
    <input type='hidden' name='setid' value="<?php  echo $set['id'];?>" />
    <input type='hidden' name='op' value="notice" />
    <div class="panel panel-default">
        <div class='panel-heading'>卖家通知</div>
        <div class='panel-body'>
            <div class="form-group">
                <label class="col-sm-2 control-label">商品兑换成功通知</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('creditshop.notice.edit')) { ?>
                    <input type="text" name="tm[new]" class="form-control" value="<?php  echo $set['tm']['new'];?>" />
                    <div class="help-block">通知公众平台模板消息编号: OPENTM205041965  或 OPENTM207024290 </div>
                    <?php  } else { ?>
                        <input type="hidden" name="tm[new]" value="<?php  echo $set['tm']['new'];?>" />
                        <div class="form-control-static"><?php  echo $set['tm']['new'];?></div>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('creditshop.notice.edit')) { ?>
                    <?php  echo tpl_selector('openids',array('key'=>'openid','text'=>'nickname', 'thumb'=>'avatar','multi'=>1,'placeholder'=>'昵称/姓名/手机号','buttontext'=>'选择通知人', 'items'=>$salers,'url'=>webUrl('member/query') ))?>
                    <span class='help-block'>商品兑换后商家通知，可以指定多个人，如果不填写则不通知</span>
                    <?php  } else { ?>
                    <div class="input-group multi-img-details" id='saler_container'>
                        <?php  if(is_array($salers)) { foreach($salers as $saler) { ?>
                        <div class="multi-item saler-item" openid='<?php  echo $saler['openid'];?>'>
                             <input type="hidden" value="<?php  echo $saler['openid'];?>" name="openids[]">
                            <img class="img-responsive img-thumbnail" src='<?php  echo $saler['avatar'];?>' onerror="this.src='./resource/images/nopic.jpg'; this.title='图片未找到.'">
                                 <div class='img-nickname'><?php  echo $saler['nickname'];?></div>
                            <input type="hidden" value="<?php  echo $saler['openid'];?>" name="openids[]">
                        </div>
                        <?php  } } ?>
                    </div>
                    <?php  } ?>
                </div>
            </div>
        </div>
        <div class='panel-heading'>买家通知</div>
        <div class='panel-body'>
             <div class="form-group">
                <label class="col-sm-2 control-label">中奖结果通知</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('creditshop.notice.edit')) { ?>
                        <input type="text" name="tm[award]" class="form-control" value="<?php  echo $set['tm']['award'];?>" />
                        <div class="help-block">公众平台模板消息编号: OPENTM204650588 【订单消息通知】</div>
                    <?php  } else { ?>
                        <input type="hidden" name="tm[award]" value="<?php  echo $set['tm']['award'];?>" />
                        <div class="form-control-static"><?php  echo $set['tm']['award'];?></div>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">奖品兑换成功通知</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('creditshop.notice.edit')) { ?>
                        <input type="text" name="tm[exchange]" class="form-control" value="<?php  echo $set['tm']['exchange'];?>" />
                        <div class="help-block">公众平台模板消息编号: OPENTM207327376 </div>
                    <?php  } else { ?>
                        <input type="hidden" name="tm[exchange]" value="<?php  echo $set['tm']['exchange'];?>" />
                        <div class="form-control-static"><?php  echo $set['tm']['exchange'];?></div>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">发货提醒</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('creditshop.notice.edit')) { ?>
                        <input type="text" name="tm[send]" class="form-control" value="<?php  echo $set['tm']['send'];?>" />
                        <div class="help-block">公众平台模板消息编号: OPENTM203331384 </div>
                    <?php  } else { ?>
                        <input type="hidden" name="tm[send]" value="<?php  echo $set['tm']['send'];?>" />
                        <div class="form-control-static"><?php  echo $set['tm']['send'];?></div>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('creditshop.notice.edit')) { ?>
                    <input type="submit" value="提交" class="btn btn-primary"  />
                    <?php  } ?>
                 </div>
            </div>
        </div>
    </div>
</form>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>     
<!--913702023503242914-->