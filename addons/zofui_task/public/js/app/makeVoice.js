// 分享	
	wx.ready(function (){
		//分享朋友
		wx.onMenuShareAppMessage({
			title: shareData.title,
			desc: shareData.desc,
			link: shareData.link,
			imgUrl:shareData.imgUrl,
			trigger: function (res) {
			},
			success: function (res) {
			},
			cancel: function (res) {
			},
			fail: function (res) {
				alert(JSON.stringify(res));
			}
		});
		//分享QQ
		wx.onMenuShareQQ({
			title: shareData.title,
			desc: shareData.desc,
			link: shareData.link,
			imgUrl:shareData.imgUrl,
			trigger: function (res) {
			},
			success: function (res) {
			},
			cancel: function (res) {
			},
			fail: function (res) {
				alert(JSON.stringify(res));
			}
		});
		//分享QQ空间
		wx.onMenuShareQZone({
			title: shareData.title,
			desc: shareData.desc,
			link: shareData.link,
			imgUrl:shareData.imgUrl,
			trigger: function (res) {
			},
			success: function (res) {
			},
			cancel: function (res) {
			},
			fail: function (res) {
				alert(JSON.stringify(res));
			}
		});	
		//朋友圈
		wx.onMenuShareTimeline({
			title: shareData.title,
			link: shareData.link,
			imgUrl:shareData.imgUrl,
			trigger: function (res) {
			},
			success: function (res) {
			},
			cancel: function (res) {
			},
			fail: function (res) {
				alert(JSON.stringify(res));
			}
		});
	})
// 音频
define(['jquery','common'],function($,common){

	var makeVoice = {};
	var voice = {
		localId: '',
		serverId: ''
	};
	
	//录音
	makeVoice.startRecord = function (callback) {
		wx.startRecord();
		if( callback ) callback();
	};

	//停止
	makeVoice.stopRecord = function (callback) {
		wx.stopRecord({
		  success: function (res) {
			voice.localId = res.localId;
			if( callback ) callback(res);
		  },
		  fail: function (res) {
			alert(JSON.stringify(res));
		  }
		});
	};

  //监听录音自动停止
	makeVoice.onVoiceRecordEnd = function (callback) {
		wx.onVoiceRecordEnd({
			complete: function (res) {
				voice.localId = res.localId;
				if( callback ) callback(res);
			}
		});
	};

	//选择图片
	makeVoice.chooseImage = function (num,callback) {
		wx.chooseImage({
			count: num, // 默认9
			sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有
			sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
			success: function (res) {
				var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
				makeVoice.uploadImage(localIds,callback);
			}
		});
	};
	//上传图片
	makeVoice.uploadImage =  function(localIds,callback) {
		var i = 0,length = localIds.length;
		var imagesurl = [];
		function upload() {
			wx.uploadImage({
				localId: localIds[i], // 需要上传的图片的本地ID，由chooseImage接口获得
				isShowProgressTips: 1, // 默认为1，显示进度提示
				success: function (res) {
					i ++;
					common.Http('post','json',common.createUrl('ajaxdeal','uploadimages'),{serverId:res.serverId},function(data){
						var imagearr = [data.url,data.attachment];
						imagesurl.push(imagearr);
						if(i < length){
							upload();
						}else{
							callback(imagesurl);
						}						
					});
				}
			});
		}
		upload();
    }
	
	//播放音频
	makeVoice.playVoice = function (callback) {
		if (voice.localId == '') {
			common.alert('请先录制一段声音');
			return;
		}
		wx.playVoice({
			localId: voice.localId
		});
		if( callback ) callback();
	};

	//暂停播放音频
	makeVoice.pauseVoice = function (callback) {
		wx.pauseVoice({
			localId: voice.localId
		});
		if( callback ) callback();
	};

	//停止播放音频
	makeVoice.stopVoice = function (callback) {
		wx.stopVoice({
			localId: voice.localId,
		});
		if( callback ) callback();
	};

	//监听录音播放停止
	makeVoice.onVoicePlayEnd = function (callback) {
		wx.onVoicePlayEnd({
			complete: function (res) {
				if( callback ) callback(res);
			}
		});
	};
	
	//上传语音
	makeVoice.uploadVoice = function (callback) {
		if (voice.localId == '') {
			common.alert('请先录制一段声音');
			return;
		}
		wx.uploadVoice({
			localId: voice.localId,
			success: function (res) {
				voice.serverId = res.serverId;
				if( callback ) callback(res);
			}
		});
	};
	makeVoice.translateVoice = function(callback){
		wx.translateVoice({
		   localId: voice.localId, // 需要识别的音频的本地Id，由录音相关接口获得
			isShowProgressTips: 1, // 默认为1，显示进度提示
			success: function (res) {
				//alert(res.translateResult); // 语音识别的结果
				if( callback ) callback(res);
			}
		});
	};
	//预览图片
	makeVoice.previewImage = function(focusImage,images){
		wx.previewImage({
		  current: focusImage,
		  urls: images
		});			
	}

	
	return makeVoice;
});

