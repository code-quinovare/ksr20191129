<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-heading">
	<span class="pull-right">
		<?php if(cv('task.add')) { ?>
		<a class='btn btn-primary btn-sm' href="<?php  echo webUrl('task/add',array('task_type'=>1))?>"><i class="fa fa-plus"></i> 添加海报</a>
		<a class='btn btn-primary btn-sm' href="<?php  echo webUrl('task/add',array('task_type'=>2))?>"><i class="fa fa-plus"></i> 添加多级海报</a>
		<?php  } ?>
		<?php if(cv('task.clear')) { ?>
		<button class="btn btn-danger btn-sm" type="button" data-toggle='ajaxPost' data-confirm="确认要清空缓存?" data-href="<?php  echo webUrl('task/clear')?>"><i class='fa fa-trash'></i> 清除当前公众号海报缓存</button>
		<?php  } ?>	
	</span>
	<h2>海报管理 <small>总数: <?php  echo $total;?></small></h2> 
</div>

<form action="./index.php" method="get" class="form-horizontal" role="form">
	<input type="hidden" name="c" value="site" />
	<input type="hidden" name="a" value="entry" />
	<input type="hidden" name="m" value="ewei_shopv2" />
	<input type="hidden" name="do" value="web" />
	<input type="hidden" name="r"  value="task" />

	<div class="page-toolbar row m-b-sm m-t-sm">
		<div class="col-sm-4">

			<div class="input-group-btn">
				<button class="btn btn-default btn-sm"  type="button" data-toggle='refresh'><i class='fa fa-refresh'></i></button>

				<?php if(cv('task.delete')) { ?>	
				<button class="btn btn-default btn-sm" type="button" data-toggle='batch-remove' data-confirm="确认要删除?" data-href="<?php  echo webUrl('task/index/delete')?>"><i class='fa fa-trash'></i> 删除</button>
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

<form action="" method="post" >


	<table class="table table-hover table-responsive">
		<thead>
			<tr>

				<th style="width:25px;"><input type='checkbox' /></th>
				<th  style='width:150px;'>海报名称</th>
				<th  style='width:150px;'>海报类型</th>
				<th style='width:80px;'>关键词</th>
				<th  style='width:80px;'>关注数</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php  if(is_array($list)) { foreach($list as $row) { ?>
			<tr>
				<td>
					<input type='checkbox'   value="<?php  echo $row['id'];?>"/>
				</td>
				<td><?php  echo $row['title'];?></td>
				<td><?php  if($row['poster_type']==1) { ?>普通海报<?php  } else if($row['poster_type']==2) { ?>多级海报<?php  } ?></td>
				<td><?php  echo $row['keyword'];?></td>
				<td><?php  echo $row['viewcount'];?></td>

				<td>
					<?php if(cv('task.log')) { ?>
					<a class='btn btn-default btn-sm' href="<?php  echo webUrl('task/log', array('id' => $row['id'],'type'=>$row['poster_type']))?>"><i class='fa fa-qrcode'></i> 关注记录</a>
					<?php  } ?>

					<?php if(cv('task.edit|task.view')) { ?>
						<a class='btn btn-default btn-sm' href="<?php  echo webUrl('task/edit', array( 'id' => $row['id'],'task_type'=>$row['poster_type']))?>"><i class='fa fa-edit'></i> <?php if(cv('task.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?></a>
					<?php  } ?>
					<?php if(cv('task.delete')) { ?><a class='btn btn-default btn-sm' data-toggle="ajaxRemove"  href="<?php  echo webUrl('task/index/delete', array('id' => $row['id']))?>"  title='删除' data-confirm="确认删除此海报吗？"><i class='fa fa-trash'></i> 删除</a></td><?php  } ?>

			</tr>
			<?php  } } ?>
		</tbody>
	</table>
	<?php  echo $pager;?>    
	<?php  } else { ?>
	<div class='panel panel-default'>
		<div class='panel-body' style='text-align: center;padding:30px;'>
			暂时没有任何海报!
		</div>
	</div>
	<?php  } ?>
</form> 

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

