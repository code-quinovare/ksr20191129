<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-heading"> 
	<span class='pull-right'>
		<?php if(cv('creditshop.category.add')) { ?>
			<a class="btn btn-primary btn-sm" href="<?php  echo webUrl('creditshop/category/add')?>">添加新商品分类</a>
		<?php  } ?>
		<a class="btn btn-default  btn-sm" href="<?php  echo webUrl('creditshop/category')?>">返回列表</a>
	</span>
	<h2><?php  if(!empty($item['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>商品分类 <small><?php  if(!empty($item['id'])) { ?>修改【<?php  echo $item['name'];?>】<?php  } ?></small></h2> 
</div>

    <form  <?php if( ce('creditshop.category' ,$item) ) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" enctype="multipart/form-data" >
 
                <?php  if(!empty($item)) { ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">分类链接(点击复制)</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class='form-control-static'>
                            <a href='javascript:;' title='点击复制链接' class="js-clip" data-url="<?php  echo mobileUrl('creditshop/lists',array('cate'=>$item['id']),true)?>">
                                <?php  echo mobileUrl('creditshop/lists',array('cate'=>$item['id']),true)?>
                            </a>
                            <span style="cursor: pointer;" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="auto right"
                                  data-content="<img src='<?php  echo $qrcode;?>' width='130' alt='链接二维码'>" data-placement="auto right">
                                <i class="glyphicon glyphicon-qrcode"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <?php  } ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">排序</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if( ce('creditshop.category' ,$item) ) { ?>
                        	<input type="text" name="displayorder" class="form-control" value="<?php  echo $item['displayorder'];?>" />
                        <?php  } else { ?>
                        	<div class='form-control-static'><?php  echo $item['displayorder'];?></div>
                        <?php  } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label must">分类名称</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if( ce('creditshop.category' ,$item) ) { ?>
                        	<input type="text" name="catename" class="form-control" value="<?php  echo $item['name'];?>" data-rule-required="true" />
                        <?php  } else { ?>
                        	<div class='form-control-static'><?php  echo $item['name'];?></div>
                        <?php  } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">分类图片</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if( ce('creditshop.category' ,$item) ) { ?>
	                        <?php  echo tpl_form_field_image2('thumb', $item['thumb'])?>
	                        <span class="help-block">建议尺寸: 100*100，或正方型图片 </span>
                        <?php  } else { ?>
	                        <?php  if(!empty($item['thumb'])) { ?>
	                        <a href='<?php  echo tomedia($item['thumb'])?>' target='_blank'>
	                           <img src="<?php  echo tomedia($item['thumb'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
	                        </a>
	                        <?php  } ?>
                        <?php  } ?>
                    </div>
                </div>
                <div class="form-group">
                        <label class="col-sm-2 control-label">是否首页推荐</label>
                        <div class="col-sm-9 col-xs-12">
                             <?php if( ce('creditshop.goods' ,$item) ) { ?>
	                            <label class="radio-inline">
	                                <input type="radio" name='isrecommand' value="0" <?php  if(empty($item['isrecommand'])) { ?>checked<?php  } ?> /> 否
	                            </label>
	                            <label class="radio-inline">
	                                <input type="radio" name='isrecommand' value="1" <?php  if($item['isrecommand']==1) { ?>checked<?php  } ?> /> 是
	                            </label>
                             <?php  } else { ?>
                             	<div class='form-control-static'><?php  if(empty($item['isrecommand'])) { ?>是<?php  } else { ?>否<?php  } ?></div>
                             <?php  } ?>
                        </div>
                    </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">是否显示</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if( ce('creditshop.category' ,$item) ) { ?>
                            <label class='radio-inline'>
                                <input type='radio' name='enabled' value=0' <?php  if($item['enabled']==0) { ?>checked<?php  } ?> /> 否
                            </label>
	                        <label class='radio-inline'>
	                            <input type='radio' name='enabled' value=1' <?php  if($item['enabled']==1) { ?>checked<?php  } ?> /> 是
	                        </label>
                        <?php  } else { ?>
                        	<div class='form-control-static'><?php  if(empty($item['enabled'])) { ?>否<?php  } else { ?>是<?php  } ?></div>
                        <?php  } ?>
                    </div>
                </div>

                <div class="form-group"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                         <?php if( ce('creditshop.category' ,$item) ) { ?>
                            <input type="submit" value="提交" class="btn btn-primary"  />
                        <?php  } ?>
                       <input type="button" name="back" onclick='history.back()' <?php if(cv('creditshop.category.add|creditshop.category.edit')) { ?>style='margin-left:10px;'<?php  } ?> value="返回列表" class="btn btn-default" />
                    </div>
                </div>

 

    </form>
 
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>


<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->