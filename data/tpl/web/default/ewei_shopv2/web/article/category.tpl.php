<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-heading">
	<h2>分类管理</h2>
</div>
<div class="alert alert-info">提示: 排序数字越大越靠前; 如果设置该分类不显示则消息列表中不会出现此类文章;</div>
<form action="<?php  echo webUrl('article/category/save')?>" method="post" class="form-validate">

	<table class="table table-hover  table-responsive">
		<thead class="navbar-inner">
			<tr>
				<th style="width:60px;">ID</th>
				<th style="width:60px;">排序</th>
				<th>分类名称</th>
				<th style="width:60px;">显示</th>
				<th style="width:80px;">操作</th>
			</tr>
		</thead>
		<tbody id='tbody-items'>
			<?php  if(is_array($list)) { foreach($list as $row) { ?>
			<tr>
				<td>
					<?php  echo $row['id'];?>
				</td>
				<td>
					<?php if(cv('article.category.edit')) { ?>
						<input type="text" class="form-control" name="cate[<?php  echo $row['id'];?>][displayorder]" value="<?php  echo $row['displayorder'];?>"> 
					<?php  } else { ?>
						<?php  echo $row['displayorder'];?> 
					<?php  } ?>
				</td>
				<td>
					<?php if(cv('article.category.edit')) { ?>
						<input type="text" class="form-control" name="cate[<?php  echo $row['id'];?>][name]" value="<?php  echo $row['category_name'];?>"> 
					<?php  } else { ?> 
						<?php  echo $row['name'];?> 
					<?php  } ?>
				</td>
				<td>
					<?php if(cv('article.category.edit')) { ?>
						<input type="checkbox" name="cate[<?php  echo $row['id'];?>][isshow]" value="1" <?php  if(!empty($row['isshow'])) { ?> checked="checked"<?php  } ?>>
					<?php  } else { ?>
						<?php echo !empty($row['isshow'])?'是':'否'?>
					<?php  } ?>
				</td>
				<td>
					<?php if(cv('article.category.edit')) { ?>
						<a data-toggle="ajaxRemove" href="<?php  echo webUrl('article/category/delete', array('id' => $row['id']))?>" class="btn btn-default btn-sm" data-confirm="确认删除此分类?">
						<i class="fa fa-trash"></i> 删除</a>
					<?php  } ?>
				</td>
				</td>
			</tr>
			<?php  } } ?>
		</tbody>

		<tr>
			<td colspan="5">
				<?php if(cv('article.category.edit')) { ?>
					<input type="button" class="btn btn-default" value="添加分类" onclick='addCategory()'> 
				<?php  } ?> 
				<?php if(cv('article.category.edit')) { ?>
					<input type="submit" class="btn btn-primary" value="保存分类"> 
				<?php  } ?>
			</td> 
		</tr>
	</table>
	<?php  echo $pager;?>

</form>

<?php if(cv('article.category.edit')) { ?>
	<script>
		function addCategory() {
			var html = '<tr>';
			html += '<td><i class="fa fa-plus"></i></td>';
			html += '<td></td>';
			html += '<td>';
			html += '<input type="text" class="form-control" name="cate_new[]" value="">';
			html += '</td>';
			html += '<td></td>';
			html += '<td></td></tr>';;
			$('#tbody-items').append(html);
		}
	</script>
<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--4000097827-->