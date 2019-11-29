<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
	#page-address-selector  .fui-radio.fui-radio-danger:before{
		border-width: 2px 2px 0 0;
		height: 0.4rem;
		width: .7rem;
	}
</style>
<div class='fui-page  fui-page-current address-selector-page' id="page-address-selector">

	<div class="fui-header">
	    <div class="fui-header-left">
			<a class="back"></a>
	    </div>
	    <div class="title" style="padding-left: 1.5rem">
			<div style="padding:0.4rem ">
				<div class="search-input">
					<i class="icon icon-search"></i>
					<input type="text" id="search" name="keywords" placeholder="输入关键字..." style="border: 0;background: #efefef;" value="<?php  echo $keywords;?>">
				</div>
			</div>
		</div>

	</div>

	<div class='fui-content'>
		<div id="noaddress" class='content-empty' <?php  if(!empty($list)) { ?>style='display:none'<?php  } ?>>
			<!--<i class='icon icon-location'></i>-->
			<!--<br/>您还没有任何收货地址-->
			<img src="<?php echo EWEI_SHOPV2_STATIC;?>images/noadd.png" style="width: 6rem;margin-bottom: .5rem;"><br/><p style="color: #999;font-size: .75rem">您暂时没有任何收货地址哦！</p>
		</div>
	    <div id="addresslist" class="fui-list-group">
			<?php  if(is_array($list)) { foreach($list as $address) { ?>
				<div  class="fui-list address-item"
					  data-isdefault="<?php  echo $address['isdefault'];?>"
					  data-addressid="<?php  echo $address['id'];?>">
					<div class="fui-list-media">
					<input type="radio" name="selected" class="fui-radio  fui-radio-danger" <?php  if(!empty($address['isdefault'])) { ?> checked<?php  } ?>/>
					</div>
					<div class="fui-list-inner">
					<div class="title"><span class='realname'><?php  echo $address['realname'];?></span> <span class='mobile'><?php  echo $address['mobile'];?></span></div>
					<div class="text">
						<span class='address'>
							<?php  if(!empty($address['isdefault'])) { ?>
							<span class="tacitlyapprove">默认</span>
							<?php  } ?>
							<?php  echo $address['province'];?><?php  echo $address['city'];?><?php  echo $address['area'];?><?php  if(!empty($new_area) && !empty($address_street)) { ?> <?php  echo $address['street'];?><?php  } ?> <?php  echo $address['address'];?>
						</span>
					</div>

					</div>
					<a  href="<?php  echo mobileUrl('member/address/post',array('id'=>$address['id']))?>" class="external" data-nocache="true">
					<div class="fui-list-angle">
						<i class='icon icon-icon_huida_tianxiebtn'></i>
					</div>
					</a>
				</div>
			<?php  } } ?>
	    </div>

	</div>
	<div class='fui-navbar'>
		<a href="<?php  echo mobileUrl('member/address/post')?>" class='nav-item btn btn-danger' data-nocache="true" style="background: #01c7a8;border: 1px solid #01c7a8;color:#fff;"><i class="icon icon-add"></i> 新增地址</a>
	</div>
	<script  id='tpl_address_item' type='text/html'>
		<div  class="fui-list address-item" data-isdefault="<%address.isdefault%>" data-addressid="<%address.id%>">
		    <div class="fui-list-media">
			<input type="radio" name="selected" class="fui-radio  fui-radio-danger" />
		    </div>
		    <div class="fui-list-inner">
			<div class="title"><span class='realname'><%address.realname%></span> <span class='mobile'><%address.mobile%></span></div>
			<div class="text">
			    <span class='address'><%address.province%><%address.city%><%address.area%> <%address.address%></span>
			</div>
		    </div>
		    <a href="<?php  echo mobileUrl('member/address/post')?>&id=<%address.id%>" data-nocache="true">
			<div class="fui-list-angle">
			    <i class='icon icon-edit'></i>
			</div>
		    </a>
		</div>
	</script>
    <script language='javascript'>
	    require(['biz/member/address'], function (modal) {
		modal.initSelector()
                });</script>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->