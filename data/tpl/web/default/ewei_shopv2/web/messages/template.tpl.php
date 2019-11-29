<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-heading"> 
    <span class='pull-right'>
            <?php if(cv('messages.template.add')) { ?>
               <a class='btn btn-primary btn-sm' href="<?php  echo webUrl('messages/template/add')?>"><i class="fa fa-plus"></i> 添加新模板</a>
              <?php  } ?>

    </span>
    <h2>模板消息库管理</h2> </div>

<form action="" method="post">


  <form action="./index.php" method="get" class="form-horizontal form-search" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="ewei_shopv2" />
                <input type="hidden" name="do" value="web" />
                <input type="hidden" name="r"  value="messages/template" />
<div class="page-toolbar row m-b-sm m-t-sm">
                            <div class="col-sm-4">

			   <div class="input-group-btn">
			        <button class="btn btn-default btn-sm"  type="button" data-toggle='refresh'><i class='fa fa-refresh'></i></button>


				<?php if(cv('messages.template.delete')) { ?>
			        <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle='batch-remove' data-confirm="确认要删除?" data-href="<?php  echo webUrl('messages.template',array('op'=>'delete'))?>"><i class='fa fa-trash'></i> 删除</button>
					<?php  } ?>

			   </div>
                               </div>


                            <div class="col-sm-6 pull-right">


				<div class="input-group">
                                        <input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词"> <span class="input-group-btn">

                                     <button class="btn btn-sm btn-primary" type="submit"> 搜索</button> </span>
                                </div>

                            </div>
</div>
  </form>


<?php  if(count($list)>0) { ?>
            <table class="table table-responsive table-hover">
                <thead>
                    <tr>
                          <th style="width:25px;"><input type='checkbox' /></th>
                        <th >模板名称</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr><td>
									<input type='checkbox'   value="<?php  echo $row['id'];?>"/>
							</td>
                        <td><?php  echo $row['title'];?></td>
                        <td>
                            <?php if(cv('messages.template.edit')) { ?>
                            <a class='btn btn-default  btn-sm' href="<?php  echo webUrl('messages/template/edit', array('id' => $row['id']))?>" ><i class='fa fa-edit'></i> <?php if(cv('messages.template.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?></a><?php  } ?>
                            <?php if(cv('messages.template.delete')) { ?><a class='btn btn-default  btn-sm'  data-toggle='ajaxRemove' href="<?php  echo webUrl('messages/template/delete', array('id' => $row['id']))?>" data-confirm="确认删除此模板吗？" ><i class='fa fa-trash'></i> 删除</a><?php  } ?>
                            <a class='btn btn-default  btn-sm'   data-toggle="ajaxModal" href="<?php  echo webUrl('messages/template/check', array('id'=>$row['id']))?>" title='校验模板'><i class='fa fa-credit-card'></i> 校验模板</a>
                       </td>
                    </tr>
                    <?php  } } ?>
                 
                </tbody>
            </table>
    <?php  echo $pager;?>
               <?php  } else { ?>
<div class='panel panel-default'>
	<div class='panel-body' style='text-align: center;padding:30px;'>
		 暂时没有任何群发模板!
	</div>
</div>
<?php  } ?>
  
         </div>
 
</form>
 
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4-->