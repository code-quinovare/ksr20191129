<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common_css', TEMPLATE_INCLUDEPATH)) : (include template('common_css', TEMPLATE_INCLUDEPATH));?>

<ul class="nav nav-tabs">
	<?php  if(!empty($skins)) { ?>
	<li <?php  if($operation == 'post' && empty($id)) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('skins', array('op' => 'post'))?>"><i class="fa fa-plus-circle"></i> 添加万能表单皮肤</a></li>
	<?php  } ?>
	<li <?php  if($operation == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('skins', array('op' => 'display'))?>">管理万能表单皮肤</a></li>
    <?php  if($operation == 'post' && !empty($id)) { ?><li class="active"><a href="#">
    编辑万能表单皮肤
    </a></li><?php  } ?>
</ul>

<?php  if($operation == 'post' && $_W['isfounder']) { ?>
<style>
.progress {position:relative;width:100%;border-radius:3px;}
.bar {background-color: green; display:block; width:0%; height:20px; border-radius: 3px; }
.percent {position:absolute; height:20px; display:inline-block; top:0; left:5%; color:#fff }
</style>

<div class="main">

	<?php  if(!in_array($row['name'], array('weui','weui2','weui3','weui4','weuiup','weui_pg','weui_huahua','weui_ju','weui_zhandao'), TRUE)) { ?>
	<form enctype="multipart/form-data"  method="post" name="upbookfrom" id="upbookfrom">
        <div class="panel panel-default">
            <div class="panel-heading">上传皮肤文件 - 同名文件将被覆盖，请谨慎命名</div>
            <div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2">上传皮肤</label>
					<div class="col-xs-12 col-sm-9">
						<input type="button" id="uploadbookimg" onClick="$('#upload').click()" class="btn btn-success" value="点击上传皮肤文件" />
						<input type="file" name="upfile" size="30" id="upload" onChange="upfiles()" style="width:0;height:0;"/>
					</div>
				</div>
			</div>
		</div>
	</form>
	<?php  } ?>
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="form1">
        <div class="panel panel-default">
            <div class="panel-heading">万能表单皮肤设置</div>
            <div class="panel-body">
			<!--
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">公众号</label>
                    <div class="col-sm-5">
						<input type="checkbox" id="selectAll" onclick="var ck = this.checked;$(':checkbox').each(function(){this.checked = ck});">
						<a class="btn btn-success" style="margin-left: -18px;" onclick="$('#selectAll').click();">全选</a>
						<span class="btn btn-default" disabled>全选中 或 全部选 则所有公众号都能使用此皮肤</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
					<div class="col-sm-9 col-xs-12" style="margin-left:-15px;">
						<?php  if(is_array($list)) { foreach($list as $uni) { ?>
						<?php  $subaccount = count($uni['details']);?>
							<?php  if(is_array($uni['details'])) { foreach($uni['details'] as $account) { ?>
							<div class="col-sm-3" style="width:20%;">
								<div class="input-group" style="margin:2px;">
									<span class="input-group-addon">
										<label class="checkbox-inline" style="width:10px;"> <input type="checkbox" name="ids[]" <?php  if(in_array($account['acid'], $ids)) { ?>checked<?php  } ?> value="<?php  echo $account['acid'];?>" style="margin-top:-12px;"></label>
									</span>
									<span class="form-control"><?php  echo mb_substr($account['name'],0,8,'utf-8')?></span>
								</div>
							</div>
							<?php  } } ?>
						<?php  } } ?>
					</div>
				</div>
				-->
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">皮肤名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="title" class="form-control" value="<?php  echo $row['title'];?>" />
                    </div>
				</div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">皮肤文件名</label>
                    <div class="col-sm-9">
                        <input type="text" id="skinsname" name="skinsname" class="form-control" value="<?php  echo $row['name'];?>" readonly>
                    </div>
				</div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">皮肤图片</label>
                    <div class="col-xs-12 col-sm-9">
                         <?php  echo tpl_form_field_image('thumb',$row['thumb']);?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">皮肤说明</label>
                    <div class="col-xs-12 col-sm-9">
                         <textarea style="height:200px;" class="form-control" name="description" cols="70"><?php  echo $row['description'];?></textarea>
                    </div>
                </div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">启用状态</label>
					<div class="col-xs-12 col-sm-9">
					<div class="btn-group" data-toggle="buttons">					  
						<label class="btn btn-default <?php  if(empty($row) || $row['status'] == 1) { ?>active<?php  } ?>"><input type="radio" name="status" value="1" <?php  if(empty($row) || $row['status'] == 1) { ?>checked="checked"<?php  } ?> >启用</label>
						<label class="btn btn-default <?php  if(!empty($row) && $row['status'] == 0) { ?>active<?php  } ?>"><input type="radio" name="status" value="0" <?php  if(!empty($row) && $row['status'] == 0) { ?> checked="checked"<?php  } ?>>关闭</label>
					</div>
					</div>
				</div>
                
		</div>
		</div>
		<div class="form-group col-sm-12">
			<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
    </form>
</div>
<script type="text/javascript">
				
	function upfiles(){
		var data = new FormData($('#upbookfrom')[0]);
		$.ajax({
			url: '<?php  echo $this->createWebUrl('upfile')?>',
			type: 'POST',
			data: data,
			dataType: 'html',
			cache: false,
			processData: false,
			contentType: false,
			error: function(msg){ //失败 
				alert('上传失败，请联系管理员.')
			}, 
			success: function(msgurl){ //成功
				for(var i=0; i<1; i++){
				$('input[name="skinsname"]').val(msgurl);
				}
			}
		},"json")
	}
</script>
<?php  } else if($operation == 'display' && $_W['isfounder']) { ?>

<div class="main">
<?php  if(empty($skins)) { ?>
	<div class="panel panel-info">
	<div class="panel-heading">万能表单皮肤</div>
            <div class="panel-body">
			<form action="" class="form-horizontal form" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 col-lg-1 control-label">导入皮肤</label>
					<div class="col-sm-8">
					<div class="input-group">
						<input type="submit" name="export" value="点击这里 导入皮肤数据" class="btn btn-danger">
					</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php  } else { ?>
        <form action="" method="post" onsubmit="return formcheck(this)">
			<div class="panel panel-default">
				<div class="panel-body table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th style="width:60px;">ID</th>
								<th style="width:20%;">皮肤名称</th>
								<th>简介</th>
								<th style="width:10%;">文件名</th>
								<th style="width:8%;">状态</th>
								<th style="width:180px;">操作</th>
							</tr>
						</thead>
						<tbody>
			<?php  if(is_array($skins)) { foreach($skins as $row) { ?>
				<tr <?php  if($row['mode']=='9') { ?>class="success"<?php  } else if($row['mode']=='8') { ?>class="info"<?php  } ?>>
					<td><?php  echo $row['id'];?></td>
					<td><div class="type-parent"><?php  echo $row['title'];?></div></td>
					<td>
						<?php  echo $row['description'];?>
					</td>
					<td>
						<?php  echo $row['type'];?>.html
					</td>
					<td>
						<a data="<?php  echo $row['status'];?>" href="javascript:;" class="label label-default <?php  if($row['status']==1) { ?>label-primary<?php  } ?>" onclick="set(this,<?php  echo $row['id'];?>,'status','dayu_comment_category')"><?php  if($row['status']==1) { ?><i class="fa fa-check-square-o"></i> 启用<?php  } else { ?><i class="fa fa-times-circle-o"></i> 关闭<?php  } ?></a>
					</td>
					<td>
						<a href="<?php  echo $this->createWebUrl('skins', array('op' => 'post', 'id' => $row['id']))?>" class="btn btn-default"><i class="fa fa-edit"></i> 编辑</a>
						<?php  if(!in_array($row['name'], array('weui','weui2','weui3','weui4','weuiup','weui_pg','weui_huahua','weui_ju','weui_zhandao'), TRUE)) { ?><a href="<?php  echo $this->createWebUrl('skins', array('op' => 'delete', 'id' => $row['id']))?>" class="btn btn-danger" onclick="return confirm('确认删除此皮肤吗？一并删除<?php  echo $row['name'];?>.html');return false;"><i class="fa fa-remove"></i> 删除</a><?php  } ?>
					</td>
				</tr>
			<?php  } } ?>
			</tbody>
					</table>
				</div>
           </div>
        </form>
<?php  echo $pager;?>
</div>
	<script>
	function set(obj,id,type,table){
		$(obj).html($(obj).html() + "...");
		$.post("<?php  echo $this->createWebUrl('ajaxset')?>",{id:id,type:type,table:table, data: obj.getAttribute("data")},function(d){
			$(obj).html($(obj).html().replace("...",""));
				$(obj).html( d.data=='1'?'<i class="fa fa-check-square-o"></i> 启用':'<i class="fa fa-times-circle-o"></i> 关闭');

			$(obj).attr("data",d.data);
			if(d.result==1){
				$(obj).toggleClass("label-primary");
	//			$("#c_"+id).hide();
			}
		},"json");
	}
	</script>
<?php  } ?>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>