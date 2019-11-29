<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-heading"> <h2>基础设置</div>

<form id="setform"  action="" method="post" class="form-horizontal form-validate">
    <div class="form-group">
        <label class="col-sm-2 control-label">话题上传图片限制</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('sns.set.edit')) { ?>
            <input type="text" name="data[imagesnum]" class="form-control" value="<?php  echo $data['imagesnum'];?>"  />
            <span class="help-block">如果不填写或为0，默认上传5张</span>
            <?php  } else { ?>
            <div class='form-control-static'><?php  echo $data['imagesnum'];?></div>
            <?php  } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">超级管理员</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('sns.set.edit')) { ?>
            <?php  echo tpl_selector('managers',array('key'=>'openid','text'=>'nickname', 'thumb'=>'avatar','multi'=>1,'placeholder'=>'昵称/姓名/手机号','buttontext'=>'选择会员', 'items'=>$managers,'url'=>webUrl('member/query') ))?>
            <span class='help-block'>选择的会员拥有所有版块的删除，置顶，精华，审核，发帖免审等所有权限</span>

            <?php  } else { ?>
            <div class="input-group multi-img-details" id='saler_container'>
                <?php  if(is_array($managers)) { foreach($managers as $manager) { ?>
                <div class="multi-item saler-item" openid='<?php  echo $manager['openid'];?>'>
                <input type="hidden" value="<?php  echo $manager['managers'];?>" name="managers[]">
                <img class="img-responsive img-thumbnail" src='<?php  echo $manager['avatar'];?>' onerror="this.src='./resource/images/nopic.jpg'; this.title='图片未找到.'">
                <div class='img-nickname'><?php  echo $manager['nickname'];?></div>
                <input type="hidden" value="<?php  echo $manager['managers'];?>" name="managers[]">
            </div>
            <?php  } } ?>
        </div>
        <?php  } ?>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">默认版块Banner</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('sns.set.edit')) { ?>
            <?php echo tpl_form_field_image2('data[banner]', empty($data['banner'])?'../addons/ewei_shopv2/plugin/sns/static/images/banner.png':$data['banner'])?>
            <span class='help-block'>建议尺寸:640 * 320,版块可以单独设置</span>
            <?php  } else { ?>
            <?php  if(!empty($data['banner'])) { ?>
            <a href='<?php  echo tomedia($data['banner'])?>' target='_blank'>
            <img src="<?php  echo tomedia($data['banner'])?>" style='width:100px;border:1px solid #ccc;padding:1px'/>
            </a>
            <?php  } ?>
            <?php  } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">会员默认头像</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('sns.set.edit')) { ?>
            <?php echo tpl_form_field_image2('data[avatar]', empty($data['avatar'])?'../addons/ewei_shopv2/plugin/sns/static/images/head.jpg':$data['avatar'])?>
            <span class='help-block'>W建议尺寸:100 * 100</span>
            <?php  } else { ?>
            <?php  if(!empty($data['avatar'])) { ?>
            <a href='<?php  echo tomedia($data['avatar'])?>' target='_blank'>
            <img src="<?php  echo tomedia($data['avatar'])?>" style='width:100px;border:1px solid #ccc;padding:1px'/>
            </a>
            <?php  } ?>
            <?php  } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">会员升级依据</label>
        <div class="col-sm-9">
            <?php if(cv('sns.set.edit')) { ?>
            <label class="radio radio-inline" >
                <input type="radio" name="data[leveltype]" value="0" <?php  if(empty($data['leveltype'])) { ?>checked<?php  } ?>/> 社区积分
            </label>
            <label class="radio radio-inline">
                <input type="radio" name="data[leveltype]" value="1" <?php  if($data['leveltype']==1) { ?>checked<?php  } ?>/> 话题数
            </label>
            <?php  } else { ?>
            <div class='form-control-static'><?php  if($data['leveltype']) { ?>话题数<?php  } else { ?>社区积分<?php  } ?></div>
            <?php  } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">发帖未关注提示</label>
        <div class="col-sm-9">
            <?php if(cv('sns.set.edit')) { ?>
            <input type='text' class="form-control" name='data[followtip]' value='<?php  echo $data['followtip'];?>' />
            <span  class='help-block'>如果为空默认为“想要和社友互动吗？需要您关注我们的公众号，点击【确定】关注后再来吧~”</span>
            <?php  } else { ?>
            <div class='form-control-static'><?php  echo $data['followtip'];?></div>
            <?php  } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">社区积分说明连接</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('sns.set.edit')) { ?>
            <input type="text" name="data[crediturl]" class="form-control" value="<?php  echo $data['crediturl'];?>"  />
            <span class="help-block">个人中心积分说明连接</span>
            <?php  } else { ?>
            <div class='form-control-static'><?php  echo $data['crediturl'];?></div>
            <?php  } ?>
        </div>
    </div>

    <div class="form-group">
                <label class="col-sm-2 control-label">关注引导页面</label>
                <div class="col-sm-9 col-xs-12">
                          <?php if(cv('sns.set.edit')) { ?>
                    <input type="text" name="data[followurl]" class="form-control" value="<?php  echo $data['followurl'];?>"  />
                    <span class="help-block">不填写默认为商城引导页面</span>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['followurl'];?></div>
                    <?php  } ?>
                </div>
     </div>

            <div class="form-group">
    <label class="col-sm-2 control-label">分享标题</label>
    <div class="col-sm-9 col-xs-12">
           <?php if(cv('sns.set.edit')) { ?>
        <input type="text" name="data[share_title]" id="share_title" class="form-control" value="<?php  echo $data['share_title'];?>" />
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $data['share_title'];?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">分享图标</label>
    <div class="col-sm-9 col-xs-12">
          <?php if(cv('sns.set.edit')) { ?>
        <?php  echo tpl_form_field_image2('data[share_icon]', $data['share_icon'])?>
             <?php  } else { ?>
                            <?php  if(!empty($data['share_icon'])) { ?>
                            <a href='<?php  echo tomedia($data['share_icon'])?>' target='_blank'>
                            <img src="<?php  echo tomedia($data['share_icon'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
                            </a>
                            <?php  } ?>
                        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">分享描述</label>
    <div class="col-sm-9 col-xs-12">
             <?php if(cv('sns.set.edit')) { ?>
        			<textarea name="data[share_desc]" class="form-control" ><?php  echo $data['share_desc'];?></textarea>
             <?php  } else { ?>
		        <div class='form-control-static'><?php  echo $data['share_desc'];?></div>
		    <?php  } ?>
    </div>
</div>

<div class="form-group">
        <label class="col-sm-2 control-label">模板选择</label>
        <div class="col-sm-9 col-xs-12">
        	<?php if(cv('sns.set.edit')) { ?>
	            <select class='form-control' name='data[style]'>
	                <?php  if(is_array($styles)) { foreach($styles as $style) { ?>
	                <option value='<?php  echo $style;?>' <?php  if($style==$data['style']) { ?>selected<?php  } ?>><?php  echo $style;?></option>
	                <?php  } } ?>
	            </select>
            <?php  } else { ?>
            	<?php  echo $data['style'];?>
            <?php  } ?>
        </div>
    </div>

      
         <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-9">
            	<?php if(cv('sns.set.edit')) { ?>
                	<input type="submit" value="提交" class="btn btn-primary"/>
                <?php  } ?>
            </div>
 
</form>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--4000097827-->