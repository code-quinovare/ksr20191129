<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-heading">
	<h2>
		<?php  if($type=='0') { ?>兑换记录
		<?php  } else if($type=='1') { ?>抽奖记录
		<?php  } else if($type=='2') { ?>待发货
		<?php  } else if($type=='3') { ?>待收货
		<?php  } else if($type=='4') { ?>已完成
		<?php  } else if($type=='5') { ?>待核销
		<?php  } else if($type=='6') { ?>已核销
		<?php  } else if($type=='7') { ?>全部核销<?php  } ?>
		<small>参与活动数:  <span class='text-danger'><?php  echo $total;?></span></small>
	</h2>
</div>
<form action="" method="get" class="form-horizontal table-search">
	<input type="hidden" name="c" value="site" />
	<input type="hidden" name="a" value="entry" />
	<input type="hidden" name="m" value="ewei_shopv2" />
	<input type="hidden" name="do" value="web" />
	<input type="hidden" name="r" value="<?php  echo $_GPC['r'];?>" />
	<input type="hidden" name="type" value="<?php  echo $type;?>" />
	<div class="page-toolbar row m-b-sm m-t-sm">
		<div class="col-sm-5">
			<div class="btn-group btn-group-sm" style='float:left'>
				<button class="btn btn-default btn-sm" type="button" data-toggle='refresh'><i class='fa fa-refresh'></i></button>
			</div>
			<div class='input-group input-group-sm'>
				<?php  echo tpl_daterange('time', array('sm'=>true,'placeholder'=>'参与时间'),true);?>
			</div>
		</div>
		<div class="col-sm-7 pull-right">
			<select name='status' class="form-control input-sm select-md" style="width:100px;">
				<option value='' <?php  if($_GPC['status']=='') { ?>selected<?php  } ?>>状态</option>
				<?php  if(empty($type)) { ?>
				<option value='2' <?php  if($_GPC['status']=='2') { ?>selected<?php  } ?>>未兑换</option>
				<option value='3' <?php  if($_GPC['status']=='3') { ?>selected<?php  } ?> >已兑换</option>
				<?php  } else { ?>
				<option value='1' <?php  if($_GPC['status']=='1') { ?>selected<?php  } ?>>未中奖</option>
				<option value='2' <?php  if($_GPC['status']=='2') { ?>selected<?php  } ?> >已中奖</option>
				<option value='3' <?php  if($_GPC['status']=='3') { ?>selected<?php  } ?> >已兑换</option>
				<?php  } ?>
			</select>
			<select name='searchfield' class='form-control  input-sm select-md' style="width:120px;">
				<option value='member' <?php  if($_GPC['searchfield']=='member') { ?>selected<?php  } ?>>会员信息</option>
				<option value='address' <?php  if($_GPC['searchfield']=='address') { ?>selected<?php  } ?>>收件人信息</option>
				<option value='logno' <?php  if($_GPC['searchfield']=='logno') { ?>selected<?php  } ?>>活动编号</option>
				<option value='eno' <?php  if($_GPC['searchfield']=='eno') { ?>selected<?php  } ?>>兑换码</option>
				<option value='store' <?php  if($_GPC['searchfield']=='store') { ?>selected<?php  } ?>>兑换门店</option>
				<option value='express' <?php  if($_GPC['searchfield']=='express') { ?>selected<?php  } ?>>快递单号</option>
				<option value='goods' <?php  if($_GPC['searchfield']=='goods') { ?>selected<?php  } ?>>商品名称</option>
			</select>
			<div class="input-group">
				<input type="text" class="form-control input-sm" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词" />
				<span class="input-group-btn">
					<button class="btn btn-sm btn-primary" type="submit"> 搜索</button>
					<?php if(cv('creditshop.log.export')) { ?>
						<button type="submit" name="export" value="1" class="btn btn-success btn-sm">导出</button>
					<?php  } ?>
				</span>
			</div>
		</div>
	</div>
</form>
<?php  if(count($list)>0) { ?>
<table class="table table-responsive">
	<thead>
		<th>商品</th>
		<th>类型</th>
		<th>用户</th>
		<th>消耗</th>
		<th>状态</th>
		<th>操作</th>
	</thead>
</table>
<table class="table table-responsive table-bordered">
	<thead>
		<tr>
			<th style='width:190px;'>编号/商品</th>
			<th style='width:100px;'>信息</th>
			<th style='width:100px;'>粉丝</th>
			<th style='width:100px;'>会员</th>
			<th style='width:90px;'>消耗</th>
			<th style='width:90px;'>状态</th>
			<th style="width:220px;">操作</th>
		</tr>
	</thead>
	<tbody>
		<?php  if(is_array($list)) { foreach($list as $row) { ?>
		<tr>
			<td><?php  echo $row['logno'];?><br/><img src="<?php  echo tomedia($row['thumb'])?>" style='width:30px;height:30px;padding1px;border:1px solid #ccc' /> <?php  echo $row['title'];?></td>
			<td style='line-height:22px;'>
				<?php  if($row['type']==1) { ?>
				<span class='label label-danger'>抽奖</span> <?php  } else { ?>
				<span class='label label-primary'>兑换</span> <?php  } ?>
				<br/> 
				<?php  if($row['iscoupon']==0) { ?> 
					<?php  if($row['isverify']==1) { ?>
						<span class='label label-warning' <?php  if(!empty($row[ 'storename'])) { ?>data-toggle='popover' data-placement='top' data-trigger='hover' data-content='<?php  echo $row['storename'];?>' data-title='兑换门店' <?php  } ?>>
							线下兑换 <?php  if(!empty($row['storename'])) { ?><i class='fa fa-question-circle'></i><?php  } ?>
						</span>
					<?php  } else { ?>
						<span class='label label-success'>快递配送</span> 
					<?php  } ?> 
				<?php  } else { ?>
					<?php  if($row['goodstype'] == 1) { ?>
						<span class='label label-success'>优惠券</span>
					<?php  } else if($row['goodstype'] == 2) { ?>
						<span class='label label-warning'>余额</span>
					<?php  } else if($row['goodstype'] == 3) { ?>
						<span class='label label-danger'>红包</span>
					<?php  } ?>
				<?php  } ?>
			</td>
			<td>
				<img src="<?php  echo tomedia($row['avatar'])?>" style='width:30px;height:30px;padding1px;border:1px solid #ccc' /> <?php  echo $row['nickname'];?>
			</td>
			<td>
				<?php echo empty($row['realname'])?$row['mrealname']:$row['realname']?><br /> <?php echo empty($row['mobile'])?$row['mmobile']:$row['mobile']?>
			</td>
			<td><?php  if($row['credit']>0) { ?>-<?php  echo $row['credit'];?>积分<br/><?php  } ?> <?php  if($row['money']>0 || $row['dispatch'] > 0) { ?> -<?php  echo number_format($row['money'] + $row['dispatch'],2)?>现金 <?php  } ?>
			</td>
			<td style='line-height:22px;'>
				<?php  if($row['status'] ==1 && $row['type']==1) { ?><span class='label label-danger'>未中奖</span><?php  } ?>
				<?php  if($row['goodstype']==0) { ?>
					<?php  if($row['isverify']==1) { ?>
						<?php  if($row['status'] ==2) { ?><span class='label label-warning'>待核销</span><?php  } ?>
						<?php  if($set['isreply'] == 1) { ?>
							<?php  if($row['status'] ==3 && $row['iscomment'] == 0 ) { ?><span class='label label-default'>等待评价</span><?php  } ?>
							<?php  if($row['status'] ==3 && $row['iscomment'] == 1 ) { ?><span class='label label-success'>追加评价</span><?php  } ?>
							<?php  if($row['status'] ==3 && $row['iscomment'] == 2 ) { ?><span class='label label-danger'>已完成</span><?php  } ?>
						<?php  } else { ?>
							<?php  if($row['status'] ==3) { ?><span class='label label-danger'>已完成</span><?php  } ?>
						<?php  } ?>
					<?php  } else { ?>
						<?php  if($row['status'] ==2 && $row['addressid'] == 0 ) { ?><span class='label label-warning'><?php  if($row['type']==0) { ?>已兑换<?php  } else { ?>已中奖<?php  } ?></span><?php  } ?>
						<?php  if($row['status'] ==2 && $row['addressid'] > 0 && $row['time_send'] == 0) { ?><span class='label label-default'>待发货</span><?php  } ?>
						<?php  if($row['status'] ==3 && $row['time_send'] > 0 && $row['time_finish'] ==0 ) { ?><span class='label label-success'>已发货</span><?php  } ?>
						<?php  if($set['isreply'] == 1) { ?>
							<?php  if($row['status'] ==3 && $row['time_finish'] > 0 && $row['iscomment'] == 0 ) { ?><span class='label label-default'>等待评价</span><?php  } ?>
							<?php  if($row['status'] ==3 && $row['time_finish'] > 0 && $row['iscomment'] == 1 ) { ?><span class='label label-success'>追加评价</span><?php  } ?>
							<?php  if($row['status'] ==3 && $row['time_finish'] > 0 && $row['iscomment'] == 2 ) { ?><span class='label label-danger'>已完成</span><?php  } ?>
						<?php  } else { ?>
							<?php  if($row['status'] ==3 && $row['time_finish'] > 0) { ?><span class='label label-danger'>已完成</span><?php  } ?>
						<?php  } ?>
					<?php  } ?>
				<?php  } else if($row['goodstype']==1) { ?>
					<?php  if($set['isreply'] == 1) { ?>
						<?php  if($row['status'] ==3 && $row['iscomment'] == 0 ) { ?><span class='label label-default'>等待评价</span><?php  } ?>
						<?php  if($row['status'] ==3 && $row['iscomment'] == 1 ) { ?><span class='label label-success'>追加评价</span><?php  } ?>
						<?php  if($row['status'] ==3 && $row['iscomment'] == 2 ) { ?><span class='label label-danger'>已发放</span><?php  } ?>
					<?php  } else { ?>
						<?php  if($row['status'] ==3) { ?><span class='label label-danger'>已发放</span><?php  } ?>
					<?php  } ?>
				<?php  } else if($row['goodstype']==2) { ?>
					<?php  if($set['isreply'] == 1) { ?>
						<?php  if($row['status'] ==3 && $row['iscomment'] == 0 ) { ?><span class='label label-default'>等待评价</span><?php  } ?>
						<?php  if($row['status'] ==3 && $row['iscomment'] == 1 ) { ?><span class='label label-success'>追加评价</span><?php  } ?>
						<?php  if($row['status'] ==3 && $row['iscomment'] == 2 ) { ?><span class='label label-danger'>已发放</span><?php  } ?>
					<?php  } else { ?>
						<?php  if($row['status'] ==3 ) { ?><span class='label label-danger'>已发放<?php  } ?>
					 <?php  } ?>
                 <?php  } else if($row['goodstype']==3) { ?>
                     <?php  if($set['isreply'] == 1) { ?>
                         <?php  if($row['status'] ==3 && $row['iscomment'] == 0 ) { ?><span class='label label-success'>等待评价</span><?php  } ?>
                         <?php  if($row['status'] ==3 && $row['iscomment'] == 1 ) { ?><span class='label label-success'>追加评价</span><?php  } ?>
                         <?php  if($row['status'] ==3 && $row['iscomment'] == 2 ) { ?><span class='label label-danger'>已发放</span><?php  } ?>
                     <?php  } else { ?>
                        <?php  if($row['status'] ==3) { ?><span class='label label-danger'>已发放</span><?php  } ?>
                     <?php  } ?>
                 <?php  } ?>
				<br/>
				<?php  if($row['paytype']==-1) { ?>
					<span class='label label-default'>无需支付</span>
				<?php  } else { ?>
					<?php  if($row['paytype']==0) { ?>
						<?php  if($row['paystatus']==0) { ?><span class='label label-default'>余额未支付</span> <?php  } else { ?><span class='label label-warning'>余额已支付</span> <?php  } ?>
				<?php  } else if($row['paytype']==1) { ?>
					<?php  if($row['paystatus']==0) { ?><span class='label label-default'>微信未支付</span><?php  } else { ?><span class='label label-warning'>微信已支付</span><?php  } ?>
				<?php  } else if($row['paytype']==2) { ?>
					<?php  if($row['paystatus']==0) { ?><span class='label label-default'>支付宝未支付</span><?php  } else { ?><span class='label label-warning'>支付宝已支付</span><?php  } ?>
					<?php  } ?>
				<?php  } ?>
				<br/>
				<?php  if($row['dispatchstatus']==-1) { ?><span class='label label-default'>无需运费</span>
				<?php  } else if($row['dispatchstatus']==0) { ?><span class='label label-default'>未支付运费</span>
				<?php  } else if($row['dispatchstatus']==1) { ?><span class='label label-primary'>已支付运费</span> <?php  } ?>
			</td>
			<td>
				<?php if(cv('creditshop.log.detail')) { ?>
					<a class='btn btn-default btn-sm' href="<?php  echo webUrl('creditshop/log/detail',array('id' => $row['id']));?>"><i class='fa fa-edit'></i> 详情</a>
				<?php  } ?>
				<?php  if($row['addressid']!=0 && $row['expresssn']>0) { ?>
				<a class='btn btn-default btn-sm' data-toggle="ajaxModal" href="<?php  echo webUrl('util/express', array('id' => $row['id'],'express'=>$row['express'],'expresssn'=>$row['expresssn']))?>">
					<i class='fa fa-exchange'></i> 物流信息
				</a>
				<?php  } ?>
				<?php if(cv('creditshop.log.exchange')) { ?>
					<?php  if($row['canexchange']) { ?>
						<a class='btn btn-default btn-sm' data-toggle='ajaxModal' href="<?php  echo webUrl('creditshop/log/doexchange',array('id' => $row['id'],'type'=>$row['goodstype']));?>"><i class='fa fa-exchange'></i> 兑换</a>
				<?php  } ?>
				<?php  } ?>
				<?php  if($item['merchid'] == 0) { ?>
				<?php if(cv('creditshop.log.remarksaler')) { ?>
				<a class='btn btn-default btn-sm' data-toggle='ajaxModal' href="<?php  echo webUrl('creditshop/log/remarksaler', array('id' => $row['id']))?>" ><i class='fa fa-flag-o'></i> 备注</a>
				<?php  } ?>
				<?php  } ?>
			</td>
		</tr>
		<?php  } } ?>
	</tbody>
</table>
<?php  echo $pager;?> <?php  } else { ?>
<div class='panel panel-default'>
	<div class='panel-body' style='text-align: center;padding:30px;'>
		暂时没有任何记录!
	</div>
	<?php  } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--青岛易联互动网络科技有限公司-->