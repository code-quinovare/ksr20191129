define(['jquery','common'],function($,module){
	var module = {};
	
	//警告框
	module.alert = function(message){
		var alertStr = '<div id="alertclass">'+message+'</div>';
		if($('#alertclass').length > 0){
			$('#alertclass').text(message).show();
			setTimeout(function(){
				$('#alertclass').fadeOut();
			},1500);
		}else{
			$('body').append(alertStr);
			setTimeout(function(){
				$('#alertclass').fadeOut();
			},1500);
		}
	};	
	
	/*
		使用微信jssdk上传图片依赖以下html
		<div class="upload_images_wxjs">
			<div class="upload_images_views">
			</div>
			<span class="upload_btn">+</span>
		</div>
		num是限定的图片数量。
	*/
	module.uploadImageByWxJs = function(num){
		$('body').on('click','.upload_btn',function(){
			var elemt = $(this).parent();
			require(['makeVoice'],function(wxJs){
				var nownumber = elemt.find('.upload_images_views img').length*1;		
				if(nownumber >=num){
					module.alert('图片已达最大数量');return false;
				}
				wxJs.chooseImage(num-nownumber,function(data){
					var imgstr = '';
					for(var i= 0;i<data.length;i++){
						imgstr += '<li class="fl"><img src="'+data[i][0]+'"><input value="'+data[i][1]+'" type="hidden" name="images"></li>';
					}
					elemt.find('.upload_images_views').append(imgstr);
				});
			});
		})
	};
	
	//删除图片
	module.deleteImagesInWxJs = function(){
		$('body').on('click','.upload_images_views img',function(){
			var thisimg = $(this);
			module.confirm('重要提示','确定要删除此图片吗？',function(bool){
				if(bool){
					thisimg.parent().remove();
				}
			});
		});
	}
	
	//预览图片
	module.preViewsImages = function(url){
		var domstr = '<div class="preview_class"><div class="weui_mask"></div><img src="'+url+'"></div>';
		$('body').append(domstr);
		$('.preview_class').click(function(){
			$(this).remove();
		});
	};
	
	//确定框
	module.confirm = function(title,msg,callback){	
		$("body").append(
			'<div class="weui_dialog_confirm" id="confirm_dialog">'
				+'<div class="weui_mask"></div>'
				+'<div class="weui_dialog">'
					+'<div class="weui_dialog_hd"><strong class="weui_dialog_title">'+title+'</strong></div>'
					+'<div class="weui_dialog_bd">'+msg+'</div>'
					+'<div class="weui_dialog_ft">'
						+'<a href="javascript:;" class="weui_btn_dialog default" id="confirm_cancel">取消</a>'
						+'<a href="javascript:;" class="weui_btn_dialog primary" id="confirm_confirm">确定</a>'
					+'</div>'
				+'</div>'
			+'</div>');
		$('body').off('click','#confirm_confirm');
		$('body').off('click','#confirm_cancel');		
		$('body').on('click','#confirm_confirm',function() {
			$('#confirm_dialog').remove();
			if( callback ) callback(true);
		});
		$("#confirm_cancel").click( function() {
			$('.weui_dialog_confirm').remove();
			if( callback ) callback(false);
		});
	};
	
	//http请求
	module.Http = function(type,datatype,url,data,successCall,beforeCall,isLoading,comCall){
		isLoading = !isLoading;
		$.ajax({
			type: type,
			url: url,
			dataType: datatype,
			data : data,
			beforeSend:function(){
				if(isLoading) module.loading(true);
				if(beforeCall) beforeCall();
			},
			success: function(data){
				if(successCall) successCall(data);
			},
			complete:function(){					
				if(isLoading) module.loading(false);
				if(comCall) comCall();
			},				
			error: function(xhr, type){
				console.log(xhr);
			}
		});	
	};
	
	//加载中提示
	module.loading = function(bool) {
		var loadingid = 'modal-loading';
		var modalobj = $('#' + loadingid);	
		if(bool){
			if(modalobj.length == 0) {
				$(document.body).append('<div id="' + loadingid + '" class="modal" tabindex="-1" role="dialog" aria-hidden="true"></div>');
				modalobj = $('#' + loadingid);
				html = 
					'<div class="weui_mask"></div>'+
					'<div class="modal-loading">'+
					'	<div style="text-align:center; background-color: transparent;">'+
					'		<img style="width:48px; height:48px; margin-top:75%;z-index:666;position:relative" src="../attachment/images/global/loading.gif">'+
					'	</div>'+
					'</div>';
				modalobj.html(html);
			}
			modalobj.show();			
		}else{
			modalobj.hide();
		}
	};
	
	//返回顶部
	module.goToTop = function(){
		var topStr = '<div id="gotoTop" style="display: none;">'
			+'<div class="arrow"></div>'
			+'<div class="stick"></div>'
			+'</div>';
		if($('#gotoTop').length == 0){
			$('body').append(topStr);			
		}
		
		var wheight = $(window).height();
		$(window).scroll(function() {
			var s = $(window).scrollTop();
			if( s > wheight*2) {
				$("#gotoTop").fadeIn(100);
			} else {
				$("#gotoTop").fadeOut(200);
			};				
        });
		
		$('body').on('click','#gotoTop',function(){
			$('html,body').animate({scrollTop:0}, 700);	
		});
    };
	
	//加载更多数据
	module.getMoreData = function(insertBox,initpage,url,data,callback){
		var isGetFlag = true;
		var page = initpage;
		$(window).scroll(function(){
			if ($(document).height() - $(this).scrollTop() - $(this).height()<10 && isGetFlag){
				isGetFlag = false;
				$.ajax({
					type: 'post',
					url: url + '&page=' + page,
					dataType: 'json',
					data : data,
					beforeSend:function(){
						$(insertBox).append('<div id="get_more_loading" class="get_more_loading"><img src="../addons/zofui_task/public/images/loading.gif"> 正在加载</div>');
					},
					success: function(data){
						if(data.status == 'ok'){
							$(insertBox).append(data.data);
							isGetFlag = true;
							page ++;
							if(callback) callback();
						}else{
							isGetFlag = false;
						}
					},
					complete:function(){
						$('#get_more_loading').remove();
						if(!isGetFlag){
							$(insertBox).append('<div class="get_more_loading">已无更多内容</div>');
						}
					},
					error: function(xhr, type){
						console.log(xhr);
					}
				});
			};	
		});			
    };
	
	//操作cookie
	module.cookie = {
		'prefix' : '',
		// 保存 Cookie
		'set' : function(name, value, seconds) {
			expires = new Date();
			value = encodeURI(value);
			expires.setTime(expires.getTime() + (1000 * seconds));
			document.cookie = this.name(name) + "=" + escape(value) + "; expires=" + expires.toGMTString() + "; path=/";
		},
		// 获取 Cookie
		'get' : function(name) {
			cookie_name = this.name(name) + "=";
			cookie_length = document.cookie.length;
			cookie_begin = 0;
			while (cookie_begin < cookie_length)
			{
				value_begin = cookie_begin + cookie_name.length;
				if (document.cookie.substring(cookie_begin, value_begin) == cookie_name)
				{
					var value_end = document.cookie.indexOf ( ";", value_begin);
					if (value_end == -1)
					{
						value_end = cookie_length;
					}
					return decodeURI(unescape(document.cookie.substring(value_begin, value_end)));
				}
				cookie_begin = document.cookie.indexOf ( " ", cookie_begin) + 1;
				if (cookie_begin == 0)
				{
					break;
				}
			}
			return null;
		},
		// 清除 Cookie
		'del' : function(name) {
			var expireNow = new Date();
			document.cookie = this.name(name) + "=" + "; expires=Thu, 01-Jan-70 00:00:01 GMT" + "; path=/";
		},
		'name' : function(name) {
			return this.prefix + name;
		}
	};	
	
	//图片上传
	module.uploadImage = function(elem,uniacid,callback){
		require(['webuploader'], function(webuploader){
			var agent = navigator.userAgent;
			var isAndroid = agent.indexOf("Android") > -1 || agent.indexOf("Linux") > -1;			
			defaultOptions = {
				pick: {
					id: elem,
					multiple : false
				},			
				auto: true,
				swf: "/web/resource/componets/webuploader/Uploader.swf",
				server: "./index.php?i="+uniacid+"&j=&c=utility&a=file&do=upload&type=image",
				chunked: false,
				compress: false,
				fileNumLimit: 2,
				fileSizeLimit: 4 * 1024 * 1024,
				fileSingleSizeLimit: 4 * 1024 * 1024,
				accept: {
					title: "Images",
					extensions: "gif,jpg,jpeg,bmp,png",
					mimeTypes: "image/*"
				}				
			};
			if (isAndroid) {
				defaultOptions.sendAsBinary = true;
			}
			options = $.extend({}, defaultOptions);
			var uploader = webuploader.create(options);
			uploader.on( "fileQueued", function( file ) {			
				module.loading(true);					
			});
			
			uploader.on("uploadSuccess", function(file, result) {			
				module.loading(false);				
				if(result.error && result.error.message){
					alert(result.error.message);
				} else {
					callback(result,elem);
					//console.log(result);
					uploader.reset();	
				}
			});
			
			uploader.onError = function( code ) {
				uploader.reset();
				if(code == "Q_EXCEED_SIZE_LIMIT"){
					alert("错误信息: 图片大于 4M 无法上传.");
					return
				}
				alert("错误信息: " + code );
			};		
		})		
	};
	
	//显示与隐藏
	module.hideIt = function(clickelem,targetelem,callback){
		$('body').on('touchstart',clickelem,function(){
			setTimeout(function(){
				$(targetelem).hide();
				if(callback) callback();			
			},500);	
		});		
	};
	
	module.showIt = function(clickelem,targetelem,callback){
		$('body').on('touchstart',clickelem,function(){	
			setTimeout(function(){		
				$(targetelem).show();
				if(callback) callback();
			},500);				
		});		
	};	
	
	//倒计时
	module.updateTime = function (){
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
				$(this).html("已经结束啦！");		
			}
	 });
		setTimeout(function(){common.updateTime()},1000);
	};	
	
	
	//关闭与开启actionSheet elem是actionSheet的外层box ,依赖weui.css
	module.actionSheetShow = function(elem,clickDom){
        var mask = $(elem +' #mask');
        var weuiActionsheet = $(elem +' #weui_actionsheet');
        weuiActionsheet.addClass('weui_actionsheet_toggle').find('#actionsheet_cancel').show(); //find是后加
        mask.show().addClass('weui_fade_toggle').click(function () {
           module.hideActionSheet(weuiActionsheet, mask,elem);
		   $(clickDom).attr('data-isShow','0');
        });	
        $(elem +' #actionsheet_cancel').click(function () {
            module.hideActionSheet(weuiActionsheet, mask,elem);
			$(this).hide(); //后加
			$(clickDom).attr('data-isShow','0');
        });
        weuiActionsheet.unbind('transitionend').unbind('webkitTransitionEnd');		
	};
	
	module.hideActionSheet = function(weuiActionsheet, mask) {
		weuiActionsheet.removeClass('weui_actionsheet_toggle');
		mask.removeClass('weui_fade_toggle');
		weuiActionsheet.on('transitionend', function () {
			mask.hide();
		}).on('webkitTransitionEnd', function () {
			mask.hide();
		})
	};	
	
	//绑定事件
	module.bind = function(bindelem,config){
		var events = config.events || {};
		for(t in events){
			for(tt in events[t]){
				$(bindelem).on(t,events[t],events[t][tt]);
			}
		}
	};
	
	//创建url
	module.createUrl = function(dostr,opstr,obj){
		var str = '&do='+dostr+'&op='+opstr;
		for(t in obj){
			str += '&'+t+'='+obj[t];
		}
		return window.sysinfo.siteroot+'app/index.php?i='+window.sysinfo.uniacid+'&c=entry'+str+'&m=zofui_task';
	};
	
	//懒加载
	/* module.lazyLoadImages = function(){
		require(['lazyLoad'], function(lazyLoad){
			$("img.lazy").lazyload({
				effect : "fadeIn"
			});		
		})
	}; */
	module.lazyLoadImages = function(){
		require(['lazyLoad'], function(lazyLoad){
			$("img.lazy").each(function(){
				var thissrcurl = $(this).attr('src');
				if(thissrcurl == '' || thissrcurl == undefined){
					$(this).lazyload({effect : "fadeIn"});
				}
			});		
		})
	};	
	//验证 
	module.verify = function(type,parama,paramb){
		if(type == 'number'){
			if(parama == 'int'){ // 正整数
				var R = /^[1-9]*[1-9][0-9]*$/;
			}else if(parama == 'intAndLetter'){ //数字和字母
				var R = /^[A-Za-z0-9]*$/;
			}else if(parama == 'money'){ //金额,最多2个小数
				var R = /^\d+\.?\d{0,2}$/;
			}
			return R.test(paramb);
		}else if(type == 'mobile'){ //手机
			var R = /^1[3|4|5|7|8]\d{9}$/;
			return R.test(parama);
		}else if(type == 'cn'){ //中文
			var R = /^[\u2E80-\u9FFF]+$/;
			return R.test(parama);
		}
		
		
		
		
	};	
	
	
	return module;
});