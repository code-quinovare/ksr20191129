<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<form action="" class="form-horizontal form" method="post" enctype="multipart/form-data">
<div class="main">
    <div class="panel panel-default">
      <div class="panel-heading">参数设置
	</div>
      <div class="panel-body">
        <div class="form-group clearfix">
			<label class="control-label col-md-2">积分设置</label>
			<div class="col-sm-10 col-xs-12">
				<div class="input-group form-group">
					<span class="input-group-addon"><!-------积分类型：
					<input type="radio" value="1" name="jftype"  <?php  if($settings['jftype']=='1') { ?>checked<?php  } ?>/> 积分 			
					<input type="radio" value="2" name="jftype"  <?php  if($settings['jftype']=='2') { ?>checked<?php  } ?>/> 余额					
					；-------->首次签到赠送</span>
					<input type="text" name="everyday"  class="form-control" value="<?php  echo $settings['everyday'];?>" placeholder="默认赠送1积分"  maxlength="4" onkeyup="value=value.replace(/[^1234567890]+/g,'');"/>
					<span class="input-group-addon">分；续签递增</span>
					<input type="text" name="continuity"  class="form-control" value="<?php  echo $settings['continuity'];?>" placeholder="默认为0,即不递增"  maxlength="4" onkeyup="value=value.replace(/[^1234567890]+/g,'');"/>
					<span class="input-group-addon">分；递增上限</span>
					<input type="text" name="intup"  class="form-control" value="<?php  echo $settings['intup'];?>" placeholder="默认为0,即无上限"  maxlength="6" onkeyup="value=value.replace(/[^1234567890]+/g,'');"/>
					<span class="input-group-addon">分</span>
				</div>
			</div>
        </div>
        <div class="form-group clearfix">
			<label class="control-label col-md-2">时段设置</label>
			<div class="col-sm-10 col-xs-12">
				<div class="input-group form-group">
					<span class="input-group-addon">
					<input type="radio" value="0" name="time[is]"  <?php  if((int)$settings['time']['is']=='0') { ?>checked<?php  } ?>/> 不限 			
					<input type="radio" value="1" name="time[is]"  <?php  if((int)$settings['time']['is']=='1') { ?>checked<?php  } ?>/> 限制；开始时间：
					</span>
					<input type="text" name="time[a]"  class="form-control" value="<?php  echo $settings['time']['a'];?>" placeholder="如8时30分就写 830"  maxlength="4" onkeyup="value=value.replace(/[^1234567890]+/g,'');" size='6'/>
					<span class="input-group-addon">；结束时间：</span>
					<input type="text" name="time[e]"  class="form-control" value="<?php  echo $settings['time']['e'];?>" placeholder="如20时00分就写 2000"  maxlength="4" onkeyup="value=value.replace(/[^1234567890]+/g,'');" size='6'/>
					<span class="input-group-addon">；非时段提示语：</span>
					<input type="text" name="time[t]"  class="form-control" value="<?php  echo $settings['time']['t'];?>" placeholder="请在每天8时到20时来签到" />
				</div>
			</div>
        </div>
        <div class="form-group clearfix">
			<label class="control-label col-md-2">额外奖励</label>
			<div class="col-sm-10 col-xs-12">
				<div class="input-group form-group">
					<span class="input-group-addon">
						<input type="radio" value="0" name="jl[is]"  <?php  if((int)$settings['jl']['is']=='0') { ?>checked<?php  } ?>/> 关 			
						<input type="radio" value="1" name="jl[is]"  <?php  if((int)$settings['jl']['is']=='1') { ?>checked<?php  } ?>/> 开
					</span>
					<span class="input-group-addon">活动时段：</span>
					<span class="input-group-addon">
					<?php  if(empty($settings['jl']['w'])) { ?>
						<?php  $settings['jl']['w']=range (12 , 14);?>
					<?php  } ?>
						<?php  $nums = range (0 , 6);?>
						<?php  if(is_array($nums)) { foreach($nums as $i) { ?>
							<input type="checkbox" name="jl[w][]" value="<?php  echo $i;?>" <?php  if(in_array($i, $settings['jl']['w'])) { ?>checked="checked"<?php  } ?>/> <?php  echo $wna[$i];?>
						<?php  } } ?>
					</span>
					<span class="input-group-addon">得奖提示：</span>
					<input type="text" name="jl[ts]"  class="form-control" value="<?php  echo $settings['jl']['ts'];?>" placeholder="常用变量：[当天签到量] [额外奖值]" />
				</div>
				<?php  $nums = range (0 , 4);?>
				<?php  if(is_array($nums)) { foreach($nums as $i) { ?>
					<div class="input-group form-group">
						<span class="input-group-addon">奖项<?php  echo $i+1?>：</span>					
						<span class="input-group-addon">当天前</span>
						<input type="text" name="jl[a][<?php  echo $i;?>]"  class="form-control" value="<?php  echo $settings['jl']['a'][$i];?>" placeholder="(包含这个数)"  maxlength="3" onkeyup="value=value.replace(/[^1234567890]+/g,'');" size='4'/><span class="input-group-addon">位到</span>
						<input type="text" name="jl[b][<?php  echo $i;?>]"  class="form-control" value="<?php  echo $settings['jl']['b'][$i];?>" placeholder="(包含这个数)"  maxlength="3" onkeyup="value=value.replace(/[^1234567890]+/g,'');" size='4'/><span class="input-group-addon">位签到者；</span>
						<span class="input-group-addon">奖励
							<input type="radio" value="1" name="jl[t][<?php  echo $i;?>]"  <?php  if($settings['jl']['t'][$i]=='1') { ?>checked<?php  } ?>/> 积分 			
							<input type="radio" value="2" name="jl[t][<?php  echo $i;?>]"  <?php  if($settings['jl']['t'][$i]=='2') { ?>checked<?php  } ?>/> 余额(单位：分)				
						</span>
						<input type="text" name="jl[e][<?php  echo $i;?>]"  class="form-control" value="<?php  echo $settings['jl']['e'][$i];?>" placeholder=""  maxlength="4" onkeyup="value=value.replace(/[^1234567890]+/g,'');" size='5'/><span class="input-group-addon">分</span>
					</div>
				<?php  } } ?>
				<div class="help-block">规则：当天前几位签到者，给予额外奖励；余额的单位是分！奖励数额为0就是关闭奖励活动</div>
			</div>
        </div>
		<div class="form-group clearfix">
			<label class="control-label col-md-2">每日一提示</label>
			<div class="col-sm-5 col-xs-12">
				<div class="input-group form-group">
					<span class="input-group-addon">
						<input type="radio" value="0" name="tx[is]"  <?php  if((int)$settings['tx']['is']=='0') { ?>checked<?php  } ?>/> 关 			
						<input type="radio" value="1" name="tx[is]"  <?php  if((int)$settings['tx']['is']=='1') { ?>checked<?php  } ?>/> 开
					</span>
					<span class="input-group-addon">
						<input type="radio" value="1" name="tx[type]"  <?php  if((int)$settings['tx']['type']=='1') { ?>checked<?php  } ?>/> 倒计时：目标日期</span>
					<input type="text" name="tx[djs][day]"  class="form-control" value="<?php  echo $settings['tx']['djs']['day'];?>" placeholder="格式如：20160707" maxlength="8" onkeyup="value=value.replace(/[^1234567890]+/g,'');"/>
				</div>
				<div class="input-group form-group">
					<span class="input-group-addon">
					<input type="radio" value="0" name="tx[type]"  <?php  if((int)$settings['tx']['type']=='0') { ?>checked<?php  } ?>/> 星期提示时段：</span>
					<?php  echo tpl_form_field_daterange('tx[time]', $settings['tx']['time'], true);?>
				</div>				
				<?php  $nums = range (0 , 2);?>
				<?php  if(is_array($nums)) { foreach($nums as $i) { ?>
					<div class="input-group form-group">
						<span class="input-group-addon">星期<?php  echo $wna[$i];?>提示：
						</span>
						<input type="text" name="tx[xq][t][<?php  echo $i;?>]"  class="form-control" value="<?php  echo $settings['tx']['xq']['t'][$i];?>" placeholder="如：今天星期<?php  echo $wna[$i];?>，出门请带XXX" />
					</div>
				<?php  } } ?>
			</div>
			<div class="col-sm-5 col-xs-12">
				<div class="input-group form-group">
					<span class="input-group-addon">倒计时项目：</span>
					<input type="text" name="tx[djs][name]"  class="form-control" value="<?php  echo $settings['tx']['djs']['name'];?>" placeholder="如：高考倒计时" />
				</div>
				<?php  $nums = range (3 , 6);?>
				<?php  if(is_array($nums)) { foreach($nums as $i) { ?>
					<div class="input-group form-group">
						<span class="input-group-addon">星期<?php  echo $wna[$i];?>提示：
						</span>
						<input type="text" name="tx[xq][t][<?php  echo $i;?>]"  class="form-control" value="<?php  echo $settings['tx']['xq']['t'][$i];?>" placeholder="如：今天星期<?php  echo $wna[$i];?>，出门请带XXX" />
					</div>
				<?php  } } ?>
			</div>
		</div>
        <div class="form-group clearfix">
          <label class="control-label col-md-2">提示栏默认</label>
          <div class="col-md-4">
            <input type="text" class="form-control" name="welcome" placeholder="默认：亲，欢迎您签到" value="<?php  echo $settings['welcome'];?>">
          </div>
          <div class="col-md-6">
				<div class="input-group form-group">
					<span class="input-group-addon">提示栏链接：</span>
					<?php  echo tpl_form_field_link('url1[t]', $settings['url1']['t']);?>
				</div>
          </div>
        </div>
        <div class="form-group clearfix">
          <label class="control-label col-md-2">签到积分排行板</label>
          <div class="col-md-3">
				<select class="form-control input-medium" name="ispaihang">
                    <option value="0" <?php  if($settings['ispaihang']==0) { ?>selected<?php  } ?>>关闭排行板</option>
                    <option value="1" <?php  if($settings['ispaihang']==1) { ?>selected<?php  } ?>>当天排行板</option>
                    <option value="2" <?php  if($settings['ispaihang']==2) { ?>selected<?php  } ?>>7天排行板</option>
                    <option value="3" <?php  if($settings['ispaihang']==3) { ?>selected<?php  } ?>>30天排行板</option>
                    <option value="5" <?php  if($settings['ispaihang']==5) { ?>selected<?php  } ?>>本月排行板</option>
                    <option value="4" <?php  if($settings['ispaihang']==4) { ?>selected<?php  } ?>>历史排行板</option>
				</select>
          </div>
          <div class="col-md-3">
				<select class="form-control input-medium" name="paihangt">
                    <option value="0" <?php  if($settings['paihangt']==0) { ?>selected<?php  } ?>>单次(时间段内单次最高得分)</option>
                    <option value="1" <?php  if($settings['paihangt']==1) { ?>selected<?php  } ?>>总分(时间段内得分总和)</option>
                    <option value="2" <?php  if($settings['paihangt']==2) { ?>selected<?php  } ?>>次数(时间段内签到的次数)</option>
				</select>
          </div>
          <div class="col-md-2">
				<select class="form-control input-medium" name="px">
					<optgroup label="相同积分排序" />
                    <option value="1" <?php  if($settings['px']==1) { ?>selected<?php  } ?>>后来居上</option>
                    <option value="2" <?php  if($settings['px']==2) { ?>selected<?php  } ?>>先来后到</option>
				</select>
          </div> 
          <div class="col-md-2">
				<select class="form-control input-medium" name="paihangs">
					<optgroup label="显示条数,默认为前三名" />
                    <option value="3" <?php  if($settings['paihangs']==3) { ?>selected<?php  } ?>>前三名</option>
                    <option value="5" <?php  if($settings['paihangs']==5) { ?>selected<?php  } ?>>前五名</option>
                    <option value="8" <?php  if($settings['paihangs']==8) { ?>selected<?php  } ?>>前八名</option>
                    <option value="10" <?php  if($settings['paihangs']==10) { ?>selected<?php  } ?>>前十名</option>
				</select>
          </div>

        </div>

        <div class="form-group clearfix">
          <label class="control-label col-md-2">签到成功提示语</label>
          <div class="col-md-4">
            <textarea class="form-control" name="success_msg" placeholder="" rows="8"><?php  echo $settings['success_msg'];?></textarea>
            <div class="help-block">例如：签到成功啦！你已获得[签到积分]积分。</div>
          </div>
          <div class="col-md-3">
            <div class="help-block">变量说明<br>[昵称]：用户昵称<br>
[总积分]：用户目前拥有的总积分<br>
[签到总积分]：签到所得的积分总和<br>
[签到积分]：当次签到所赠送的积分<br>
[今天得分]：今天签到所赠送的积分<br>
[首次积分]：首次签到所赠送的积分<br>
[续签积分]：连续签到所递增积分值
			</div>
          </div>
          <div class="col-md-3">
            <div class="help-block">
<br>
[下期积分]：下期签到将赠送的积分<br>
[积分上限]：积分递增上限<br>
[当天签到量]：当天第几位签到者<br>
[额外奖值]：当天所得的额外奖值
			</div>
          </div>
        </div>
        <div class="form-group clearfix">
          <label class="control-label col-md-2">签到失败提示语</label>
          <div class="col-md-4">
            <textarea class="form-control" name="continuity_msg" placeholder="" rows="6"><?php  echo $settings['continuity_msg'];?></textarea>
            <div class="help-block">例如：您今天已经签到过了！明天再来吧！</div>
          </div>
          <label class="control-label col-md-2">签到封面</label>
          <div class="col-md-4">
			<?php  echo tpl_form_field_image('linklogo', $settings['linklogo'])?>
			<div class="help-block">建议尺寸900*500或720*400或360*200</div>
          </div>
        </div>
        <div class="form-group clearfix">
          <label class="control-label col-md-2">封面标题</label>
          <div class="col-md-4">
				<input type="text" class="form-control" name="linktitle" placeholder="" value="<?php  echo $settings['linktitle'];?>" >
				<div class="help-block">例如：亲爱的[昵称]，欢迎您签到！</div>
		  </div>
          <div class="col-md-6">
				<div class="input-group form-group">
					<span class="input-group-addon">封面链接：</span>
					<?php  echo tpl_form_field_link('url1[f]', $settings['url1']['f']);?>
				</div>
          </div>
        </div>
      	<div class="form-group clearfix">
          <label class="control-label col-md-2">广告位功能</label>
          <div class="col-md-4">
				<select id="common_corp" class="form-control input-medium" name="isgg">
                    <option value="0" <?php  if($settings['isgg']==0) { ?>selected<?php  } ?>>关闭</option>
                    <option value="1" <?php  if($settings['isgg']==1) { ?>selected<?php  } ?>>开启(能赚钱的签到)</option>
				</select>
          </div>
          <div class="col-md-6">
				<div class="input-group form-group">
					<span class="input-group-addon">排行链接：</span>
					<?php  echo tpl_form_field_link('url', $settings['url']);?>
				</div>
          </div>
        </div>
		
<?php  if($settings['isgg']=='1') { ?>
      	<div class="form-group clearfix">
          <label class="control-label col-md-2">商品推荐</label>
          <div class="col-md-3">
				<select id="common_corp" class="form-control input-medium" name="isint">
                    <option value="0" <?php  if($settings['isint']=='0') { ?>selected<?php  } ?>>关闭</option>
					<?php  if(is_array($shopnane)) { foreach($shopnane as $row) { ?>
						<?php  $shid=$shoplis[$row['a']];?>
						<option value="<?php  echo $shid;?>" <?php  if($settings['isint'] == $shid) { ?>selected<?php  } ?>><?php  echo $row['b'];?></option>
					<?php  } } ?>
					<option value="99" <?php  if($settings['isint'] == '99') { ?>selected<?php  } ?>>系统文章</option>
					<optgroup label="待增加...." />
				</select>
			 <div class="help-block">随机显示商城里的商品</div>
          </div>
		    <div class="col-md-1">
				<select class="form-control input-medium" name="shops">
					<optgroup label="最多显示条数" />
                    <option value="1" <?php  if($settings['shops']==1) { ?>selected<?php  } ?>>1</option>
                    <option value="2" <?php  if($settings['shops']==2) { ?>selected<?php  } ?>>2</option>
                    <option value="3" <?php  if($settings['shops']==3) { ?>selected<?php  } ?>>3</option>
                    <option value="4" <?php  if($settings['shops']==4) { ?>selected<?php  } ?>>4</option>
                    <option value="5" <?php  if($settings['shops']==5) { ?>selected<?php  } ?>>5</option>
                    <option value="6" <?php  if($settings['shops']==6) { ?>selected<?php  } ?>>6</option>
				</select>
          </div>
        </div>
			<hr/>展位设置(此设置会加入活动链接,可用在企业的通知,调研,或节日游戏活动,也可以是外部商品,更可以做固定广告位)<hr/>	
			<?php  $nums = range (0 , 4);?>
			<?php  if(is_array($nums)) { foreach($nums as $i) { ?>
			<div class="form-group clearfix">
				<label class="control-label col-md-2">展位<?php  echo $i+1?>封面图片</label>
				<div class="col-sm-3">
					<?php  echo tpl_form_field_image('wailink['. $i .'][picurl]', $settings['wailink'][$i]['picurl'])?>
					<div class="help-block">正方形图片,大小 120*120 左右则可</div>
				</div>
				<div class="col-sm-7">
					<div class="input-group form-group">
						<span class="input-group-addon">标题：</span>
						<input type="text" class="form-control" name="wailink[<?php  echo $i;?>][title]" placeholder="广告位\商品\活动\通知\调研\游戏\应用...." value="<?php  echo $settings['wailink'][$i]['title'];?>" >
					</div>
					<div class="input-group form-group">
						<span class="input-group-addon">链接：</span>
						<?php  $lsa=$settings['wailink'][$i]['url'];?>	
						<?php  echo tpl_form_field_link('wailink['. $i .'][url]', $lsa);?>
					</div>
					<div class="input-group form-group">
						<span class="input-group-addon">密钥：</span>
						<input type="text" class="form-control" name="wailink[<?php  echo $i;?>][a]" id="wailink[<?php  echo $i;?>][a]"  placeholder="接口密钥linkkey" value="<?php  echo $settings['wailink'][$i]['a'];?>" autocomplete="off">
						<span class="input-group-addon js-clip" style="cursor:pointer" onclick="oCopy('wailink[<?php  echo $i;?>][a]');" title="点击复制密钥"><i class="fa fa-copy"></i></span>
						<span class="input-group-addon js-clip" style="cursor:pointer" onclick="tokenGen('wailink[<?php  echo $i;?>][a]');" title="点击随机生成接口密钥"><i class="fa fa-recycle"></i></span>
					</div>
					<div class="input-group form-group">
						<span class="input-group-addon">设置：</span><span class="input-group-addon">
							<input type="radio" value="0" name="wailink[<?php  echo $i;?>][is]"  <?php  if($settings['wailink'][$i]['is']=='0') { ?>checked<?php  } ?>/> 关闭
							<input type="radio" value="1" name="wailink[<?php  echo $i;?>][is]"  <?php  if($settings['wailink'][$i]['is']=='1') { ?>checked<?php  } ?>/> 当次
							<input type="radio" value="2" name="wailink[<?php  echo $i;?>][is]"  <?php  if($settings['wailink'][$i]['is']=='2') { ?>checked<?php  } ?>/> 当天
							<input type="radio" value="3" name="wailink[<?php  echo $i;?>][is]"  <?php  if($settings['wailink'][$i]['is']=='3') { ?>checked<?php  } ?>/> 总分
						</span>
						<span class="input-group-addon">得分在</span>
						<input type="text" name="wailink[<?php  echo $i;?>][fs]"  class="form-control" value="<?php  echo $settings['wailink'][$i]['fs'];?>" placeholder="包含"  maxlength="8" onkeyup="value=value.replace(/[^1234567890]+/g,'0');"/>
						<span class="input-group-addon">到</span>
						<input type="text" name="wailink[<?php  echo $i;?>][fsu]"  class="form-control" value="<?php  echo $settings['wailink'][$i]['fsu'];?>" placeholder="包含"  maxlength="8" onkeyup="value=value.replace(/[^1234567890]+/g,'0');"/>
						<span class="input-group-addon">时展示</span>
					</div>
					<div class="input-group form-group">
						<span class="input-group-addon">时间：</span>
						<?php  echo tpl_form_field_daterange('wailink['. $i .'][time]', $settings['wailink'][$i]['time'], true);?>
					</div>
				</div>
			</div><hr/>	
			<?php  } } ?>
		<?php  } ?>	
			
      </div>
	</div>
</div>
<?php  echo $txtr;?>
<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
</form>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
