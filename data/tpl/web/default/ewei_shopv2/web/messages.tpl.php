<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-heading">
	<span class="pull-right">
		<?php if(cv('messages.add')) { ?>
		<a class='btn btn-primary btn-sm' href="<?php  echo webUrl('messages/add')?>"><i class="fa fa-plus"></i> 添加任务</a>
		<?php  } ?>
	</span>
	<h2>消息群发任务 <small>总数: <?php  echo $total;?></small></h2>
</div>

<form action="./index.php" method="get" class="form-horizontal" role="form">
	<input type="hidden" name="c" value="site" />
	<input type="hidden" name="a" value="entry" />
	<input type="hidden" name="m" value="ewei_shopv2" />
	<input type="hidden" name="do" value="web" />
	<input type="hidden" name="r"  value="messages" />

	<div class="page-toolbar row m-b-sm m-t-sm">
		<div class="col-sm-6 pull-right">
			<div class="input-group">				 
				<input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词"> <span class="input-group-btn">

					<button class="btn btn-sm btn-primary" type="submit"> 搜索</button> </span>
			</div>
		</div>
	</div>
</form>

<?php  if(count($list)>0) { ?>

<form action="" method="post" >

	<table class="table table-hover table-responsive">
		<thead>
			<tr>
				<th>任务名称</th>
				<th>发送条数/未发送数/成功数/失败数</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php  if(is_array($list)) { foreach($list as $row) { ?>
			<tr>
				<td><?php  echo $row['title'];?></td>
				<td><?php  echo $row['num'];?>/<?php  echo $row['nosend'];?>/<?php  echo $row['sendsuccess'];?>/<?php  echo $row['sendfail'];?></td>
				<td><?php  echo $row['statustext'];?></td>

				<td  style="overflow:visible;">
					<div class="btn-group btn-group-sm" >
						<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="javascript:;">操作 <span class="caret"></span></a>
						<ul class="dropdown-menu dropdown-menu-left" role="menu" style='z-index: 9999'>

							<?php if(cv('messages.run')) { ?>
							<li><a  data-toggle="ajaxRemove"  href="<?php  echo webUrl('messages/build', array('id' => $row['id']))?>"><i class='fa fa-plus-circle'></i> 生成发送列表</a></li>
							<?php  } ?>
							<?php if(cv('messages.run')) { ?>
							<li><a  href="<?php  echo webUrl('messages/run', array('id' => $row['id']))?>"><i class='fa fa-qrcode'></i> 开始发送</a></li>
							<?php  } ?>
							<?php if(cv('messages.edit|messages.view')) { ?>
							<li><a  data-toggle="ajaxRemove" href="<?php  echo webUrl('messages/reset', array('id' => $row['id']))?>"><i class='fa fa-refresh'></i> 重置发送</a></li>
							<?php  } ?>
							<?php if(cv('messages.edit|messages.view')) { ?>
							<li><a  href="<?php  echo webUrl('messages/edit', array( 'id' => $row['id']))?>"><i class='fa fa-edit'></i> <?php if(cv('messages.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?></a></li>
							<?php  } ?>
							<?php if(cv('messages.delete')) { ?>
							<li><a  data-toggle="ajaxRemove"  href="<?php  echo webUrl('messages/delete', array('id' => $row['id']))?>"  title='删除' data-confirm="确认删除此任务吗？"><i class='fa fa-trash'></i> 删除</a></li>
							<?php  } ?>
							<?php if(cv('messages.view')) { ?>
							<li><a  href="<?php  echo webUrl('messages/showsign', array( 'id' => $row['id']))?>">查看发送日志</a></li>
							<?php  } ?>
						</ul>
					</div>
				</td>
			</tr>
			<?php  } } ?>
		</tbody>
	</table>
	<?php  echo $pager;?>    
	<?php  } else { ?>
	<div class='panel panel-default'>
		<div class='panel-body' style='text-align: center;padding:30px;'>
			暂时没有任何任务!
		</div>
	</div>
	<?php  } ?>
</form> 

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--青岛易联互动网络科技有限公司-->