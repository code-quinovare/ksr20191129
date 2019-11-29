require(['jquery','common','makeVoice','area'],function($,common,makeVoice){
	var pageManage = {
		$container : $('.fenda_container'),
		isGetPageed : false, //判断是否已经获取了初始化页面模板，杜绝多次触发getpage方法。		
		init : function(config){
			this.bind(config);
			if($.inArray(getPage,['new','urg','high','pubed','userexe','userpubed','indexsch','task','love','moneylog','pubguy','takeguy','userfocus','follow','guydetail','pvtpub','pvtaccept','findsch','depositlog','scorelog']) >= 0 && !this.isGetPageed) {
				this.isGetPageed = true;
				this.getPage(initParams.insertelem);
				common.getMoreData(initParams.insertelem,2,getpageurl,{a:1},function(){
					dealImages.squareImage('.nead_square_images img'); //处理图片
					common.lazyLoadImages(); //懒加载
				});
				common.goToTop();
			}
			
		},
		bind : function(config){ //给每个页面的元素绑定事件。
			var events = config.events || {};
			var $container = config.$container || this.$container;
			for(var t in events){
				for(var type in events[t]){			
					$container.on(type,t,events[t][type]);
				}
			}
			for(func in config.init){	
				config.init[func]();
			}			
		},
		getPage : function(insertelemt){ //异步加载初始化页面，这样使html模板只存在一份，便于编辑修改。
			common.Http('POST','json',getpageurl,initPageData,function(data){
				$(insertelemt).append(data.data);
				dealImages.squareImage('.nead_square_images img'); //处理图片
				common.lazyLoadImages(); //懒加载
			},function(){
				$('body').append('<li id="page_before_show"><img src="../addons/zofui_task/public/images/loading.gif"></li>');
			},true,function(){
				$('#page_before_show').remove();
			});
		}
	};
//主页	
	var index = { 
		events : {
			'.publist_item a' : {
				click : function(){
					common.cookie.set('taskPageFilter','0',1000);
				}
			}		
		}
	};	
	
//pub页面
	var pub = {
		params : {
			isurledit : false,
		},
		init :{
			initAreaSelect : function(){ //初始化页面省份数据
				var startstr = '<option selected="-1" value="全国">全国</option>';
				searchAndCity.fn.structArea(startstr,'select[name=pubprovince]');
			},
			initimage : function(){
				dealImages.initUploadImages(5,'');
			}			
		},
		events : {
			'.pub_money_money span' : { //选择赏金金额
				click : function(){
					$(this).parents('.pub_money_money').find('.font_activity').removeClass('font_activity');
					$(this).addClass('font_activity');
					if($(this).text() == '其他'){
						$('.pub_edit_money').show();
					}else{
						$('.pub_edit_money').hide();
					}
					var money = $(this).next().val();
					$('input[name=othermoney]').val(money);
					pub.fn.countMoney();
				}
			},
			'#publish' : { //确认发布内容
				click : function(){
					var data = {
						title : $('.pub_task_divedit').html(),
						money : $('input[name=othermoney]').val()*1,
						times : $('input[name=times]').val()*1,
						tasknumber : $('input[name=tasknumber]').val()*1,
						pubprovince : $('select[name=pubprovince]').val(),
						pubcity : $('select[name=pubcity]').val(),
						pubtasktype : $('select[name=pubtasktype]').val(),
						ishide : $('input[name=ishide]:checked').val(),
						creditscore : $('input[name=creditscore]').val(),
						maxreply : $('input[name=maxreply]').val()*1,
						deposit : $('input[name=deposit]').val()*1,
						images : []
					};
					if(data.ishide != 1) data.ishide = 2;
					data.images = dealImages.getImageValue();
					if(data.title == '' || data.title.length > 800){
						common.alert('请编辑标题,最多800个字符');return false;
					}
					if(data.creditscore <= 0){
						common.alert('您的信誉积分小于0，不能发布任务。');return false;
					}
					if(!common.verify('number','money',data.money)){
						common.alert('请输入正确的金额，最多2位小数');return false;
					}
					if(data.money < initParams.leasttaskmoney){
						common.alert('任务赏金不能低于'+initParams.leasttaskmoney+'元');return false;
					}					
					if(!common.verify('number','int',data.tasknumber)){
						common.alert('请输入正确任务数，必须是正整数');return false;
					}
					if(!common.verify('number','int',data.maxreply) || data.maxreply > 1000){
						common.alert('限制回复数量在1-1000之间');return false;
					}
					if(data.pubprovince != '全国' && data.pubcity == ''){
						common.alert('您还没有选择城市');return false;
					}
					if(data.deposit < data.money*data.tasknumber){
						common.confirm('提示','任务总赏金须小于您的保证金'+data.deposit+'元，点击确定去增加保证金，点击取消关闭。',function(bool){
							if(bool){
								location.href = common.createUrl('user','adddeposit');
							}
						});
						return false;
					}

					if(data.maxreply > data.tasknumber){
						common.alert('限制回复数应小于任务总数量');return false;
					}					
					if(data.pubtasktype == ''){
						common.alert('您还没有选择任务类型');return false;
					}
					common.confirm('重要提示','发布后不能修改，将扣除您的余额 '+$('.count_total_money').text(),function(bool){
						if(bool){
							common.Http('POST','json',common.createUrl('ajaxdeal','publish'),data,function(data){
								if(data.status == 1 || data.status == 2) common.alert('发布失败，存在空项');
								if(data.status == 3) {
									common.confirm('重要提示','您的任务保证金不足，去增加保证金吗？',function(bool){
										if(bool) location.href = common.createUrl('user','adddeposit');
									});
								}
								if(data.status == 4) {
									common.confirm('重要提示','您的余额不足,去充值吗？',function(bool){
										if(bool) location.href = common.createUrl('user','money');
									});
								}
								if(data.status == 5) {
									var noticestrr = '';
									if(initParams.isverify == 1){
										var noticestrr = '任务已发布，请等待管理员审核您发布的任务。';
									}
									common.confirm('发布成功',noticestrr+'点击确定前往任务页面，点击取消停留此页',function(bool){
										if(bool) location.href = common.createUrl('task','task',{'id':data.id});
										if(!bool) location.href="";
									});										
									
								}
								if(data.status == 6) common.alert('出现异常');
								if(data.status == 7) common.alert('您的信誉分数小于0，不能发布任务。');
								if(data.status == 8) common.alert('任务总金额必须小于您的保证金');
							});
						}
					});
				}
			},
			'input[name=othermoney],input[name=tasknumber]' : { //计算消费金额
				'input propertychange' : function(){
					pub.fn.countMoney();
				}
			},
			'.weui_textarea' : {  //计算字数
				'input propertychange' : function(){
					pub.fn.countfontnumber();
				}
			},
			'.weui_textarea_counter .ti-trash' : { //清空编辑框
				click : function(){
					common.confirm('重要提示','确定要清空吗？',function(bool){
						if(bool){
							$('.pub_task_divedit').empty();
						}
					});
				}
			},
			'.weui_textarea_counter .ti-microphone' : {  //录音
				click : function(){			
					isShowSheet(this,'#sideup_pub_record');
					makeVoice.startRecord();
				}
			},
			'#pub_record_confirm' : {  //完成录音
				click : function(){
					makeVoice.stopRecord(function(){
						makeVoice.translateVoice(function(res){
							$('.indexnotice').remove();
							$('.pub_task_divedit').append(res.translateResult);
							pub.fn.countfontnumber();
							isShowSheet('.weui_textarea_counter .ti-microphone','#sideup_ask_record');
						});				
					});
				}
			},
			'#sideup_pub_record #actionsheet_cancel,#sideup_pub_record #mask' : { //关闭录音
				click : function(){
					makeVoice.stopRecord();
				}
			},
			'select[name=pubprovince]' : {  // 选择省市
				change : function(){
					var thisvalue = $(this).find('option:selected').val();
					if(thisvalue == '全国'){
						$('.is_show_pubcity').hide();
					}else{
						searchAndCity.fn.changeArea('select[name=pubprovince]','select[name=pubcity]');
						$('.is_show_pubcity').show();
					}
				}
			},
			'.pub_textarea .ti-link' : { //显示增加链接
				click : function(){
					$('.deleteurl').parent().hide();
					isShowSheet(this,'#sideup_link');
					pub.params.isurledit = false; //不是编辑
				}
			},
			'#pub_link_confirm' : { //增加链接确定
				click : function(){
					var linkname = $('input[name=linkname]').val();
					var linkurl = $('input[name=linkurl]').val();
					if(linkname == '' || linkurl == ''){
						common.alert('请输入名称和链接');return false;
					}
					if(pub.params.isurledit){
						aclass.text(linkname).attr('href',linkurl);
					}else{
						var str = '<a href="'+linkurl+'" target="_blank">'+linkname+'</a>';
						$('.pub_task_divedit').append(str);					
					}				
					$('#sideup_link #actionsheet_cancel').click();
					pub.fn.countfontnumber();
					$('body').animate({scrollTop:0}, 0);
					$('.indexnotice').remove();
				}
			},
			'.pub_task_divedit a' : {
				click : function(){
					aclass = $(this);
					pub.params.isurledit = true; //是编辑
					var linkname = $(this).text();
					var linkurl = $(this).attr('href');
					$('input[name=linkname]').val(linkname);
					$('input[name=linkurl]').val(linkurl);
					$('.deleteurl').parent().show();
					isShowSheet(this,'#sideup_link');
					$('.pub_task_divedit').blur();
					return false;
				}
			},
			'.deleteurl' : { //删除超链接
				click : function(){
					aclass.remove();
					$('#sideup_link #actionsheet_cancel').click();
				}
			},
			'.pub_task_divedit' : { //获取焦点 清理默认提示
				focus : function(){
					$(this).find('.indexnotice').remove();
				}
			}
		},
		fn : {
			countMoney : function(){ //计算消费金额		
				var money = $('input[name=othermoney]').val();
				var tasknumber = $('input[name=tasknumber]').val();
				var server = Math.max.apply(Math,[money*tasknumber*initParams.servermoney/100,initParams.leastserver]);
				$('.count_total_money').text((money*tasknumber + server*1).toFixed(2)).next().text((money*tasknumber).toFixed(2)).next().text(server.toFixed(2));
			},
			countfontnumber : function(){ //计算字数
				var thistextarea = $('.weui_textarea');
				var thishtml = thistextarea.html();
				var len = thishtml.length;
				if(len > 800){
					thistextarea.html(thishtml.substring(0,800));
					len = 800;
				}
				$('#textareanum').text(len);
			}
		}
	};
	
	//显示与隐藏sheet，elema 点击的元素，elemb 要激活的最外层dom
	var isShowSheet = function(elema,elemb){ 
		common.hideActionSheet($('.weui_actionsheet'),$('.weui_actionsheet #mask'));
		$('.weui_mask_transition').hide();
		$('.changeShow0').not(elema).attr('data-isShow','0');
		var isShow = $(elema).attr('data-isShow');

		if(isShow == '1'){
			common.hideActionSheet($(elemb + ' #weui_actionsheet'),$(elemb + ' #mask'),elema);
			$(elema).attr('data-isShow','0');
		}else{
			common.actionSheetShow(elemb,elema);
			$(elema).attr('data-isShow','1');
		}		
	};
	
	
//顶部搜索与选择城市	
	var searchAndCity = {
		init : function(){
			if($.inArray(urlParams.do,['index','find']) >= 0) pageManage.init(searchAndCity); //只有在index和find页面才初始化当前对象
		},
		events : {
			'#showSearch' : { //点击搜索图标后，显示搜索框等
				click : function(){
					$('.page_top_item').hide();
					$("#search_bar").show();
					$("#search_show").show();
				}
			},
			'#search_cancel , #search_bar .weui_mask' : { //取消搜索
				click : function(){
					$('#search_input').val('');	
					$("#search_bar").hide().prev().show();
				}
			},
			'#search_clear' : {
				click : function(){
					$('#search_input').focus().val('');
				}
			},
			'#search_input' : {
				'input' : function(){
					var $searchShow = $("#search_show");
					if ($(this).val()) {
						$searchShow.show();
					} else {
						$searchShow.hide();
					}
				}
			},
			//以下是城市选择
			'#showCity' : {
				click : function(){
					searchAndCity.fn.getLocationa();
					isShowSheet(this,'#sideup_city');
				}
			},
			'#select_hot_city span' : { //热门城市
				click : function(){
					var thiscity = $(this).text();
					searchAndCity.fn.setCityCookie(thiscity);
				}
			},
			'select[name=province]' : { //选择省份后，改变相应的城市
				change : function(){
					searchAndCity.fn.changeArea('select[name=province]','select[name=city]');
				}
			},
			'#city_confirm' : {
				click : function(){
					var city = $('select[name=city] option:selected').val();
					if(city == '0' || city == undefined){
						common.alert('请先选择城市');return false;
					}
					searchAndCity.fn.setCityCookie(city);
				}
			}
			
		},
		fn : {
			setCityCookie : function(city){
				var city = city.replace(/市/,''); //删掉定位城市中的'市'字符
				if(urlParams.do == 'index') var cookiestr = 'zofui_task_city';
				if(urlParams.do == 'find') var cookiestr = 'zofui_guy_city';
				common.cookie.set(cookiestr,city,3600*24*7);
				location.href="";
			},
			getLocationa : function(){ //初始化省份数据、地理定位
				var str = '<option selected="" value="0">选择省份</option>';
				searchAndCity.fn.structArea(str,'select[name=province]');
				wx.ready(function (){
					wx.getLocation({
					  success: function (res) {
						common.Http('POST','json',common.createUrl('ajaxdeal','location'),{latitude:res.latitude,longitude:res.longitude},function(data){
							$('#reset_location').text(data.result.addressComponent.city).bind('click',function(){
								searchAndCity.fn.setCityCookie(data.result.addressComponent.city);
							});
						},'',true);
					  },
					  cancel: function (res) {
						common.alert('无法定位您的城市');
					  }
					});
				});				
			},
			structArea :function (startstr,appendDom){ //组合省市
				var str = startstr;
				for(item in area){
					str += '<option data-id="'+item+'" value="'+area[item].province+'">'+area[item].province+'</option>';
				}
				if($(appendDom).html() == ''){
					$(appendDom).append(str);
				}				
			},
			changeArea : function(provinceSelect,appendDom){  //切换省份
				var selected = $(provinceSelect +' option:selected');
				var id = selected.attr('data-id');					
				var city = selected.attr('data-id');
				var str = '<option selected="" value="">选择城市</option>';
				for(i=0; i<area[id].city.length;i++){
					str += '<option value="'+area[id].city[i]+'">'+area[id].city[i]+'</option>';
				}
				$(appendDom).empty().append(str);				
			}
		}
	};
//找人页面
	var find = {   
		events : {
			'.guylist_list .weui_media_hd,.guylist_list .weui_media_bd' : {
				click : function(){
					var url = $(this).attr('data-url');
					if(url == '0'){
						common.alert('对方没有设置人物类型');return false;
					}
					location.href = url;
				}
			},
			'.guylist_targericon span' : { //关注或取消关注
				click : function(){
					var thisclass = $(this);
					find.fn.focusGuy(thisclass,find);
				}
			},
			'.search_ago_item' : {
				click : function(){
					var id = $(this).attr('data-sortid');
					common.cookie.set('guySortId',id,1800);
					location.href = "";
				}
			}
		},
		fn : {
			focusGuy : function(elemt,thispage){ // 关注与取消关注
				pageManage.$container.off('click','.guylist_targericon span'); //取消绑定				
				var uid = elemt.parent().attr('data-uid');			
				var status = elemt.attr('data-status');
				common.Http('POST','html',common.createUrl('ajaxdeal','focus'),{uid:uid},function(data){
					if(data == 1){
						if(status == 1) {
							elemt.attr('data-status',0).removeClass('focused ti-minus').addClass('focus ti-plus');
							common.alert('已取消订阅');
						}
						if(status == 0) {
							elemt.attr('data-status',1).removeClass('focus ti-plus').addClass('focused ti-minus');
							common.alert('已加入订阅');
						}
					}
					if(data == 2) common.alert('发生异常');
					if(data == 3) common.alert('不能订阅自己');
					pageManage.init(thispage); //重新绑定
				},'',true);
			}
		}
	};
	
	
//用户中心	
	var user = {
		init : {
			uploadCode : function(){
				if(urlParams.op != 'auth' && urlParams.op != 'setting') return false;
				common.uploadImage('.auth_up_images',window.sysinfo.uniacid,function(data){
					$('.auth_up_images img').attr('src',data.url);
					$('input[name=images]').val(data.attachment);
				});	
			},
			initAreaSelect : function(){ //初始化页面省份数据
				var startstra = (initParams.city == '0' || initParams.city == '')?'':'<option selected="" value="'+initParams.city+'" disabled>'+initParams.city+'</option>';
				var startstr = startstra + '<option  value="全国">全国</option>';
				searchAndCity.fn.structArea(startstr,'select[name=settingprovince]');
			}
		},
		params : {
			waitTime : 60
		},	
		events : {
			'#drwmoney' : {
				click : function(){
					isShowSheet(this,'#sideup_draw');
				}
			},
			'.draw_money_type label' : {
				click : function(){
					$(this).siblings('.font_activity').removeClass('font_activity');
					$(this).addClass('font_activity');
					if($(this).find('input').val() == 'other'){
						$('.draw_money_input input').show().focus();
					}else{
						$('.draw_money_input input').hide();
					}
				}
			},
			'#money_confirm' : { //确认提现
				click : function(){
					var type = $('input[name=drawmoney]:checked').val();
					var usermoney = $('input[name=usermoney]').val();
					if(type == 'other') {
						var money = $('input[name=money]').val();
						if(!common.verify('number','money',money)){
							common.alert('请输入正确的数字,最多2位小数');return false;
						}
						if(money > usermoney){
							common.alert('余额不足');return false;
						}
					}
					if(type == 'all') var money = usermoney;
					if(money < initParams.leastdraw || money < 1){
						common.alert('提现金额不能低于'+initParams.leastdraw+'元');return false;
					}
					common.confirm('重要提示','确定提现吗？',function(bool){
						if(bool){
							common.Http('POST','html',common.createUrl('ajaxdeal','getmoney'),{type:type,money:money},function(data){
								if(data == 1) common.alert('您的余额不足');
								if(data == 2) common.alert('提现金额必须大于'+initParams.leastdraw+'元');							
								if(data == 3){
									pageManage.$container.off('click','#money_confirm');
									common.alert('您已提现,等待财务处理');
									setTimeout(function(){location.href=""},1000);
								}
								if(data == 4) common.alert('出现异常');
								if(data == 5) common.alert('您有提现还没处理完，待处理完再提现');
							});
						}
					});

				}
			},
			'#updateuser' : { //更新用户信息
				click : function(){
					pageManage.$container.off('click','#updateuser');
					common.Http('POST','html',common.createUrl('ajaxdeal','updatauser'),{},function(data){
						if(data == 1)	common.alert('更新过于频繁，两分钟后再试');
						if(data == 2){
							common.alert('已更新个人信息');
							setTimeout(function(){location.href="";},1000);
						}
					});					
				}
			},
			'.auth_top span' : {
				click : function(){
					var showclass = $(this).attr('data-class');
					$('.font_activity').removeClass('font_activity');
					$(this).addClass('font_activity');
					$('.auth_hide_class').hide();
					$(showclass).show();
				}
			},
			'#getvertify' : {
				click:function(){
					var mobile = $('input[name=mobile]').val();
					if(!common.verify('mobile',mobile)){		
						common.alert('请输入正确的手机号');return false;
					}
					common.Http('POST','html',common.createUrl('ajaxdeal','tovertify'),{mobile:mobile},function(data){
						if(data == 0){
							common.alert('验证码已发送，请填入');
						}else if(data == 1){
							common.alert('手机已经存在了');
						}else if(data == 2){
							common.alert('验证码已发送，请填入');
							user.fn.timeDesc('#getvertify');
						}else{
							common.alert('触发次数太多或参数错误');
						}			
					});
				}
			},			
			'input[name=epositsubmit]' : { //增加保证金
				click : function(){
					var data = {
						nowdeposit : $('input[name=nowdeposit]').val(),
						adddeposit : $('input[name=adddeposit]').val()
					};
					if((data.nowdeposit*1 + data.adddeposit*1) < initParams.deposit){
						common.alert('保证金至少'+initParams.deposit+'元,您至少增加'+(initParams.deposit*1-data.nowdeposit)+'元');return false;
					}
					if(data.adddeposit < 1 || !common.verify('number','int',data.adddeposit)){
						common.alert('增加金额最少1元,且为正整数');return false;
					}
				}
			},
			'input[name=drwdepositsubmit]' : { //取保证金
				click : function(){
					var data = {
						drwdeposit : $('input[name=drwdeposit]').val(),
						allowdeposit : $('input[name=allowdeposit]').val()
					};
					if(data.drwdeposit*1 > data.allowdeposit*1){
						common.alert('您提取的金额超过限值'+data.allowdeposit+'元');return false;
					}
					if(data.drwdeposit < 1){
						common.alert('提取金额最少1元');return false;
					}
					common.confirm('重要提示','确定要提取吗？',function(bool){
						if(bool){
							common.Http('post','html',common.createUrl('ajaxdeal','drwdeposit'),data,function(data){
								if(data == 1 || data == 3) common.alert('出现异常');
								if(data == 2) {
									common.alert('提取保证金申请成功，请等待财务处理');
									setTimeout(function(){location.href=""},1000);
								}
								if(data == 4) common.alert('您有一笔提取还没处理完');
								if(data == 5) common.alert('您有正在进行中的任务，暂时不能提取。');
							})
						}
					});
				}
			},			
			'.publist_item a' : {
				click : function(){
					if(urlParams.op == 'userexe') var cookiestr = 'myself';
					if(urlParams.op == 'userpubed') var cookiestr = '1';
					common.cookie.set('taskPageFilter',cookiestr,1000);
				}
			},
			'#setting_confirm' : {  //确认设置
				click : function(){
					var data = {
						mobile:$('input[name=mobile]').val(),
						mobilecode:$('input[name=mobilecode]').val(),
						images:$('input[name=images]').val(),
						guytype:$('select[name=guytype]').val(),
						guysort:$('select[name=guysort]').val(),
						guydesc:$('textarea[name=guydesc]').val(),
						contacttype1:$('input[name=contacttype1]:checked').val(),
						contacttype2:$('input[name=contacttype2]:checked').val(),
						province : $('select[name=settingprovince]').val(),
						city : $('select[name=settingcity]').val()
					};
					if(!common.verify('mobile',data.mobile)){common.alert('请输入正确的手机号');return false;}
					if(data.images == undefined){common.alert('请上传微信二维码图片');return false;}
					if(data.guytype == ''){common.alert('请选择您的类型');return false;}
					if(data.guysort == ''){common.alert('请选择您的业务分类');return false;}					
					if(data.guydesc == ''){common.alert('请填写您的业务简述');return false;}
					if(data.province != '全国' && data.city == ''){common.alert('请选择城市');return false;}
					if(data.province == '全国') data.city = '0';
					
					common.Http('POST','html',common.createUrl('ajaxdeal','setting'),data,function(data){
						if(data == 1){
							common.alert('已成功设置');
							setTimeout(function(){location.href=""},1000);
						}
						if(data == 2) common.alert('您没有修改或出现异常');
						if(data == 3) {
							common.confirm('提示','您还没有交纳任务保证金，不能设置个人信息。点击确定去交纳任务保证金。',function(bool){
								if(bool){
									location.href = common.createUrl('user','adddeposit');
								}else{
									location.href="";
								}
							});
						}
						if(data == 4) common.alert('手机验证码不正确');
					});
				}
			},
			'select[name=settingprovince]' : {  // 选择省市
				change : function(){
					var thisvalue = $(this).find('option:selected').val();
					if(thisvalue == '全国'){
						$('.is_show_city').hide();
					}else{
						searchAndCity.fn.changeArea('select[name=settingprovince]','select[name=settingcity]');
						$('.is_show_city').show();
					}
				}
			},
			'.focus_list .weui_media_hd,.focus_list .weui_media_bd' : { //关注页面跳转
				click : function(){
					var url = $(this).attr('data-url');
					if(url == '0'){
						common.alert('对方没有设置人物类型');return false;
					}
					location.href = url;
				}
			},
			'.guylist_targericon span' : { //关注或取消关注
				click : function(){
					var thisclass = $(this);
					find.fn.focusGuy(thisclass,find);
				}
			},
			'#score_rule' : { //查看积分规则
				click : function(){
					isShowSheet(this,'#sideup_scorerule');
				}
			},
			'#showFilter,#filtercontent .weui_mask' : { //筛选
				click : function(){
					$('#filtercontent').toggle();
				}
			},
			'#addmoney':{
				click: function(){
					isShowSheet(this,'#sideup_addmoney');
				}
			},
			'#topay' : {
				click: function(){
					var money = $('input[name=moneyvalue]').val();
					if(!common.verify('number','int',money)){
						common.alert('请输入正确金额，必须是正整数');return false;
					}
				}
			}
		},
		fn : {
			timeDesc : function(elem){ //倒计时效果
				var thisele = $(elem);
				if (user.params.waitTime == 0) {
					thisele.attr("disabled",false).val('获取验证码');
					user.params.waitTime = 60;  
				} else {  			
					thisele.attr("disabled", true).val("重新发送(" + user.params.waitTime + ")");  
					user.params.waitTime--;  
					setTimeout(function() {  
						user.fn.timeDesc(elem)  
					},  
					1000)  
				}
			}
		}		
	};

//任务页面
	var task = {
		init : {
			squareImage : function(){ // 处理图片
				dealImages.squareImage('.task_content img');
			},
			initTimeDesc : function(){ //倒计时
				updateEndTime();
			},
			initimage : function(){
				dealImages.initUploadImages(5,'.task_content_img img,.task_answer_images img');
			}
		},
		events : {
			'.task_reply' : {  //回复
				click : function(){
					var status = $('input[name=taskstatus]').val();
					var lastnumber = $('input[name=lastnumber]').val();
					var creditscore = $('input[name=creditscore]').val();
					if(lastnumber == 0){
						common.alert('此任务已经被抢光了');return false;
					}
					var alert = task.fn.dealtaskalert(status);
					if(!alert) return false;
					
					if(creditscore <= 0){
						common.alert('您的信誉积分小于0，不能回复任务。');return false;
					}					
					isShowSheet(this,'#sideup_answertask');
					$("#comment_content").focus();
				}
			},
			'.answertask_pub' : { //回复发表
				click : function(){
					var status = $('input[name=taskstatus]').val();
					var replaycontent = $('textarea[name=replaycontent]').val();
					var taskid = $('input[name=taskid]').val();	
					var imgaes = dealImages.getImageValue();
					var alert = task.fn.dealtaskalert(status);
					if(!alert) return false;
					
					if(replaycontent == '' || taskid == '' || replaycontent.length > 200){
						common.alert('回复内容字符在1-200之间');return false;
					}
					common.confirm('重要提示','确定要回复吗？',function(bool){
						if(bool){
							common.Http('POST','html',common.createUrl('ajaxdeal','replaytask'),{content:replaycontent,taskid:taskid,imgaes:imgaes},function(data){
								if(data == 1) common.alert('此任务已经被抢完了');
								if(data == 2) common.alert('不能回复自己的任务');
								if(data == 4) common.alert('您的信誉分数太低,不能回复任务');
								if(data == 5) common.alert('您回复的数量已达此任务的最大限制了');
								if(data == 6) common.alert('任务已经结束了');
								if(data == 3) {
									pageManage.$container.off('click','.answertask_pub');
									common.alert('已回复成功，等待作者采纳');
									setTimeout(function(){location.href=""},1000);
								}
							});
						}
					});
				}
			},
			'.task_setting' : { //设置任务
				click : function(){
					var status = $('input[name=taskstatus]').val();
					var alert = task.fn.dealtaskalert(status);
					if(!alert) return false;			
					isShowSheet(this,'#sideup_tasksetting');
				}
			},
			'input[name=isurg]' : {
				click : function(){
					if($(this).is(':checked')){
						$('.sideuper_urgmoney').show();
					}else{
						$('.sideuper_urgmoney').hide();
					}
				}
			},
			'#confirmsetting' : { // 提交设置
				click : function(){
					var data = {
						taskid : $('input[name=taskid]').val(),
						ishide : $('input[name=ishide]:checked').val(),
						isurg : $('input[name=isurg]:checked').val(),
						urgmoney : $('input[name=urgmoney]').val(),
						nowlastnumber : $('input[name=nowlastnumber]').val(),
						isurged : $('input[name=isurged]').val()
					};
					if(data.ishide != 1) data.ishide = 2;
					if(data.isurg != 1) data.isurg = 0;
					if(data.isurg == 1){
						var neadmoney = data.nowlastnumber*data.urgmoney;
						var server = neadmoney*initParams.servermoney/100;
						var noticestr = '确定要保存设置吗？将扣除您的余额:'+(neadmoney*1+server*1).toFixed(2)+'元，其中平台服务费:'+server.toFixed(2)+'元。';
						if(!common.verify('number','money',data.urgmoney) || data.urgmoney <= 0){common.alert('请输入正确的金额,最多2位小数');return false;}
						if(data.urgmoney < initParams.urgleastmoney) {common.alert('加急金额单价最少'+initParams.urgleastmoney+'元');return false;}
						if(data.isurged > 0) {common.alert('此任务已经加急，请取消加急后提交');return false;}
					}else{
						var noticestr = '确定要保存设置吗？';
					}
					common.confirm('重要提示',noticestr,function(bool){
						if(bool){
							common.Http('POST','html',common.createUrl('ajaxdeal','tasksetting'),data,function(data){
								if(data == 1) {
									common.confirm('重要提示','您的余额不足,点击确定去充值，点击取消停留在当前页面。',function(bool){
										if(bool) location.href = common.createUrl('user','money');
									});
								}
								if(data == 2) {
									pageManage.$container.off('click','#confirmsetting');
									common.alert('您已设置成功');
									setTimeout(function(){location.href=""},1000);									
								}
							});
						}
					})
					
				}
			},
			'#task_toindex' : {
				click : function(){
					$('.backtosite').toggle('100');
				}
			},
			'.backtosite p' : {
				click : function(){
					var thiddo = $(this).attr('data-do');
					location.href = common.createUrl(thiddo,'');
				}
			},
			'#task_love' : { //收藏
				click : function(){
					var taskid = $('input[name=taskid]').val();
					var thisclass = $(this);
					var type = thisclass.hasClass('font_ff5f27'); 
					common.Http('post','html',common.createUrl('ajaxdeal','love'),{taskid:taskid},function(data){
						if(type){
							thisclass.removeClass('font_ff5f27');
							common.alert('已取消收藏');
						}else{
							thisclass.addClass('font_ff5f27');
							common.alert('已加入收藏');
						}
					});
				}
			},
			'#tasker_accept' : { //采纳
				click : function(){
					var thisclass = $(this);
					task.fn.dealReply(thisclass,'accept');
				}
			},
			'#tasker_refuse' : { //拒绝
				click : function(){
					var thisclass = $(this);
					task.fn.dealReply(thisclass,'refuse');
				}
			},
			'.task_answer_top' : {
				click : function(){
					$('.task_filter_answer').toggle();
				}
			},
			'.task_answer_top p' : {
				click : function(){
					var type = $(this).attr('data-type');
					common.cookie.set('taskPageFilter',type,1800);
					location.href = "";		
				}
			},
			'.task_footer li' : { //底部文章变色
				click : function(){
					$(this).addClass('font_ff5f27').siblings().removeClass('font_ff5f27');
					if(!$(this).hasClass('task_toindex')) $('.backtosite').hide();
				}
			},
			'.task_account' : { //结算
				click : function(){
					var data = {
						taskid : $('input[name=taskid]').val()
					};
					var status = $('input[name=taskstatus]').val();
					var alert = task.fn.dealtaskalert(status);
					if(!alert) return false;
					
					common.confirm('重要提示','结算后会将剩余资金退回到您的账户，但任务会被结束。确定要提前结算吗？',function(bool){
						if(bool){
							common.Http('post','html',common.createUrl('ajaxdeal','accounttask'),data,function(data){
								if(data == 1){
									common.alert('此任务已结算');
									setTimeout(function(){location.href=""},1000);									
								}
								if(data == 2) common.alert('发生异常');
							})
						}
					});
				}
			},
			'.admin_verify' : { //呼出审核
				click : function(){
					isShowSheet(this,'#sideup_verify');
				}
			},
			'.verifytask' : {
				click : function(){
					var data = {
						taskid : $('input[name=taskid]').val(),
						type : $(this).attr('data-type')
					};
					if(data.type == 1) var noticestrr = '不通过审核会将资金退回到用户账户。确定要操作吗？';
					if(data.type == 2) var noticestrr = '确定要审核通过吗？';
					common.confirm('重要提示',noticestrr,function(bool){
						if(bool){
							common.Http('post','html',common.createUrl('ajaxdeal','verifytask'),data,function(data){
								if(data == 1){
									common.alert('操作成功');
									setTimeout(function(){location.href=""},1000);	
								}
								if(data == 2) common.alert('发生异常');
							})
						}
					});
				}
			}
		},
		fn : {
			dealReply : function(elemt,type){
				var replyid = elemt.parent().attr('data-replyid');
				var taskid = $('input[name=taskid]').val();
				if(type == 'accept'){
					var noticestr = '确定要采纳吗？';
					var resstr = '已经采纳成功';
				}else{
					var noticestr = '拒绝后双方信誉分数都减1点，确定要拒绝吗？';
					var resstr = '已经拒绝，双方信誉分数降1点。';
				}
				var dealelemt = elemt.parents('.task_answer_main_item');
				common.confirm('重要提示',noticestr,function(bool){
					if(bool){
						common.Http('POST','html',common.createUrl('ajaxdeal','dealreply'),{replyid:replyid,taskid:taskid,type:type},function(data){
							if(data == 1) common.alert('出现异常');
							if(data == 2) {
								common.alert(resstr);
								elemt.parent().find('label').remove();
								
								if(type == 'accept') dealelemt.find('.task_status_blue').addClass('task_status_green').text('已采纳').removeClass('task_status_blue');
								if(type == 'refuse') dealelemt.find('.task_status_blue').addClass('task_status_red').text('已拒绝').removeClass('task_status_blue');
							}
						})
					}
				});
			},
			dealtaskalert : function(status){
				if(status == 2){
					common.alert('此任务已结束');return false;
				}
				if(status == 3){
					common.alert('此任务处于审核中');return false;
				}
				if(status == 4){
					common.alert('此任务已被关闭');return false;
				}
				return true;
			}
		}
	};
	
//人物个人页面
	var guy  = {
		init : {
			initimage : function(){
				dealImages.initUploadImages(5,'');
			}			
		},
		events : {
			'.guylist_targericon span' : { //关注或取消关注
				click : function(){
					var thisclass = $(this);
					find.fn.focusGuy(thisclass,guy);
				}
			},
			'#guy_viewqrcode' : { //预览二维码
				click : function(){
					var img = $(this).attr('data-src');
					if(img == undefined){
						common.alert('对方没有开放微信二维码');
					}else{
						makeVoice.previewImage(img,[img]);
					}
				}
			},
			'.givetask_btn' : { //展开上拉框
				click : function(){
					isShowSheet(this,'#sideup_guy');
				}
			},
			'#guy_nomobile' : { //点击电话
				click : function(){
					common.alert('对方没有开放手机号码');
				}
			},
			'#guy_confirm' : { //确定发起任务
				click : function(){
					var type = $(this).attr('data-guytype');
					var imgaes = dealImages.getImageValue();
					var data = {
						tasktitle : $('textarea[name=tasktitle]').val(),
						taskmoney : $('input[name=taskmoney]').val(),
						tasktime : $('input[name=tasktime]').val(),
						guyuid : $('input[name=guyuid]').val(),
						images : imgaes,
						type : type
					};
					//计算平台使用费
					var server = Math.max.apply(Math,[data.taskmoney*initParams.servermoney/100,initParams.leastserver]);
					if(data.tasktitle == '') common.alert('请输入任务内容');
					if(!common.verify('number','money',data.taskmoney)) {common.alert('请输入正确的金额,最多2位小数');return false}
					if(!common.verify('number','int',data.tasktime)) {common.alert('请输入正确时限,必须是整数');return false}
					if(data.taskmoney <= server) {common.alert('任务赏金不能低于平台服务费');return false}
					if(data.type == 1) var alertstr = '确定发给对方吗？';
					if(data.type == 2) var alertstr = '将扣除您的余额'+(data.taskmoney*1)+'元，确定发给对方吗？';
					
					common.confirm('重要提示',alertstr,function(bool){
						if(bool){ 
							common.Http('POST','json',common.createUrl('ajaxdeal','pubprivatetask'),data,function(dataa){
								if(dataa.status == 1) common.confirm('提示','已成功发起任务，点击确定去私包任务页面看看，点击取消停留在此页面。',function(bool){
									if(bool){
										location.href = common.createUrl('privatetask','',{'id':dataa.id});
									}else{
										location.href = "";
									}
								});
								if(dataa.status == 2) common.alert('出现异常错误');
								if(dataa.status == 3) common.alert('不能给自己发起任务');
								if(dataa.status == 4) common.confirm('提示','您的余额不足，点击确定去充值，点击取消停留在当前页面',function(bool){
									if(bool){
										location.href = "";
									}
								});
								if(dataa.status == 5){		
									if(data.type == 1) common.alert('对方保证金不足，不能接受您的索要');
									if(data.type == 2) {
										common.confirm('提示','您的任务保证金不足，点击确定去增加。',function(bool){
											if(bool){
												if(bool) location.href = common.createUrl('user','adddeposit');
											}
										});										
									}							
								};
								if(dataa.status == 6) common.alert('您和对方之间有未完成的任务。');
							});
						}
					});
				}
			},
			'input[name=taskmoney]' : {
				'input propertychange' : function(){
					var taskmoney = $('input[name=taskmoney]').val();
					var server = Math.max.apply(Math,[taskmoney*initParams.servermoney/100,initParams.leastserver]);
					$('#sideup_guy .server').text(server.toFixed(2)).siblings('.income').text((taskmoney-server).toFixed(2));
				}
			}
		}
	};
	
//私包任务页面	
	var privatetask = {
		init : {
			initTimeDesc : function(){ //倒计时
				updateEndTime();
			},
			squareImage : function(){ // 处理图片
				dealImages.squareImage('.private_content_img img');
			},
			initimage : function(){
				dealImages.initUploadImages(5,'.private_content_img img , .complete_box img'); //上传图、预览回复的图片
			}
		},
		events : {
			'#workertaketask' : {
				click : function(){
					privatetask.fn.dealfunc('workertaketask','确定要接受此任务吗？',common.createUrl('ajaxdeal','workertaketask'),'您已接受此任务，请尽快完成');
				}
			},
			'#workerrefusetask' : {
				click : function(){
					privatetask.fn.dealfunc('workerrefusetask','确定要拒绝此任务吗？',common.createUrl('ajaxdeal','workerrefusetask'),'您已拒绝了此任务');
				}
			},			
			'#paythetaskmoney' : { //支付赏金让对方执行任务
				click : function(){
					var data = privatetask.fn.getData();
					common.confirm('重要提示','确定要支付此任务赏金让对方执行任务吗？您需支付'+data.taskmoney+'元',function(bool){
						if(bool){
							common.Http('POST','html',common.createUrl('ajaxdeal','paytaskmoney'),data,function(data){
								if(data == 1) common.confirm('提示','您的余额不足，点击确定去充值，点击取消停留在当前页面',function(bool){
									if(bool){
										location.href = common.createUrl('user','money');
									}
								});
								if(data == 2){
									common.alert('您已支付，等待对方执行任务');
									setTimeout(function(){location.href=""},1000);
								}
								if(data == 3) common.alert('出现异常错误');
							});
						}
					});
				}
			},
			'#refusegeivetask' : { //拒绝支付任务
				click : function(){
					privatetask.fn.dealfunc('refusegeivetask','确定要拒绝此任务吗？',common.createUrl('ajaxdeal','refusegeivetask'),'拒绝成功');
				}
			},
			'#completethetask' : { //完成任务呼出上拉
				click : function(){
					isShowSheet(this,'#sideup_complete');
				}
			},
			'#confirmcomplete' : {  //雇员提交完成任务
				click : function(){
					privatetask.fn.dealfunc('confirmcomplete','确定要提交完成吗？',common.createUrl('ajaxdeal','completetask'),'任务已提交完成');
				}
			},
			'#cancelthetask' : { //雇员主动取消任务
				click : function(){
					privatetask.fn.dealfunc('cancelthetask','取消任务后您将被减掉1点信誉积分，确定要取消任务吗？',common.createUrl('ajaxdeal','canceltask'),'任务已取消了');
				}
			},
			'#confirmtaskresult' : { //雇主确认完成任务
				click : function(){
					privatetask.fn.dealfunc('completethetask','确定要完成任务吗？确定后将为对方发放任务收益。',common.createUrl('ajaxdeal','confirmtask'),'任务已完成');
				}
			},
			'#refusetaskresult' : { //雇主拒绝任务结果呼出上拉框
				click : function(){
					$('.confirmcomplain').hide();
					$('.confirmrefuse').show();
					isShowSheet(this,'#sideup_privatetask');
				}
			},
			'#confirmrefuse' : { //确定拒绝
				click : function(){
					privatetask.fn.dealfunc('confirmrefuse','确定要拒绝任务结果吗？若虚假拒绝会被受到最严重封号处罚！',common.createUrl('ajaxdeal','confirmrefuse'),'任务结果已被拒绝，请等待对方确认。');
				}
			},
			'#acceptrefuse' : {  //雇员接受雇主对结果的拒绝
				click : function(){
					privatetask.fn.dealfunc('acceptrefuse','确定要接受对方的拒绝吗？',common.createUrl('ajaxdeal','acceptrefuse'),'已经接受对方的拒绝，任务已结束。');
				}
			},
			'#complainboss' : { // 投诉对方
				click : function(){
					$('.confirmcomplain').show();
					$('.confirmrefuse').hide();
					isShowSheet(this,'#sideup_privatetask');
				}
			},
			'#confirmcomplain' : {
				click : function(){
					privatetask.fn.dealfunc('confirmcomplain','确定要投诉对方的拒绝吗？',common.createUrl('ajaxdeal','omplainboss'),'已经投诉成功，请等待客服处理。');					
				}
			},
			'.ti-id-badge' : {  //看二维码
				click :function(){
					var img = $(this).attr('data-src');
					if(img == ''){
						common.alert('对方没有开放微信二维码');
					}else{
						makeVoice.previewImage(img,[img]);
					}					
				}
			},
			'#callhim' : { //手机号码
				click : function(){
					var number = $(this).attr('href');
					if(number == 'tel:0'){
						common.alert('对方没有设置手机号码');return false;
					}
				}
			}
		},
		fn : {
			getData : function(){
				var data = {
					taskmoney : $('input[name=taskmoney]').val(),
					taskid : $('input[name=taskid]').val(),
					refusereason : $('textarea[name=refusereason]').val(),
					completecontent : $('textarea[name=completecontent]').val(),
					images : dealImages.getImageValue()
				};
				return data;
			},
			dealfunc : function(from,notice,url,resultstr){
				var data = privatetask.fn.getData();
				if(data.refusereason == '' && (from == 'confirmrefuse' || from == 'confirmcomplain')){
					common.alert('请输入理由!');return false;
				}
				common.confirm('重要提示',notice,function(bool){
					if(bool){
						common.Http('POST','html',url,data,function(data){
							if(data == 1) {
								common.confirm('提示',resultstr,function(){
									location.href="";
								});
							}
							if(data == 2) common.alert('出现异常错误');
						});
					}
				});					
			}
		}
	};
	
	//倒计时
 	var updateEndTime = function (){
		var date = new Date();
		var time = date.getTime();  //当前时间距1970年1月1日之间的毫秒数 
		$(".lasttime").each(function(i){
			var endTime = $(this).attr('data-time') + '000'; //结束时间字符串
			var lag = (endTime - time); //当前时间和结束时间之间的秒数	
			if(lag > 0){
				var second = Math.floor(lag/1000%60);     
				var minite = Math.floor(lag/1000/60%60);
				var hour = Math.floor(lag/1000/60/60%24);
				var day = Math.floor(lag/1000/60/60/24);
				$(this).find('.day').text(day);
				$(this).find('.hour').text(hour);
				$(this).find('.minite').text(minite);
				$(this).find('.second').text(second);				
			}else{
				$(this).html("已经结束");
			}
	 });
		setTimeout(function(){updateEndTime()},1000);
	};	


/*
	图片处理,依赖以下html
	<div class="">
		<ul class="pub_images_box fl">
		</ul>
		<div class="ti-plus fl" id="pub_upload_images"></div>
	</div>
*/
	var dealImages = {
		squareImage : function(elemt){ //处理正方形图片
			$(elemt).each(function(){
				var thiswidth = $(this).width();
				$(this).css({'height':thiswidth});
			});
		},
		previewImage : function(elemt){ //预览图片		
			pageManage.$container.on('click',elemt,function(){			
				var thisimg = $(this);
				var focusImage = thisimg.attr('src');
				common.preViewsImages(focusImage);
			})
		},
		deleteImage : function(){ //点击图片，删除图片
			common.deleteImagesInWxJs();
		},
		uploadImage : function(){
			common.uploadImageByWxJs(5);
		},
		getImageValue : function(){ //获取图片地址数组
			var imgaes = [];
			$('.pub_images_box input').each(function(){
				imgaes.push($(this).val());
			});
			return imgaes
		},
		initUploadImages : function(limit,elemt){ //初始化多图上传
			dealImages.uploadImage();
			if(elemt != '') dealImages.previewImage(elemt);
			dealImages.deleteImage();
		}
	};
	
	
	//打印
	var log = function(str){
		console.log(str);
	};	
	var pay = {};
	
	pageManage.init(eval(urlParams.do));
	searchAndCity.init();
});
