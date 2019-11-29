
$(function(){

	//轮播图
	function img_focus(){
		var myScroll2;
		var timer;
		var i=0;
		var obj=$('#wrapper8');
		var ocircle=obj.find('.circle');
		var ospan='<span class="active"></span>'
		var obj_w=obj.width();
		var oli=obj.find('.focus-pic li');
		var oli_l=oli.length;
		oli.width(obj_w);
		$('#scroller8').width(oli_l*obj_w);
		for(var j=1; j<oli_l; j++){
			ospan+='<span></span>'
			};
		ocircle.html(ospan);
		myScroll2 = new iScroll('wrapper8', {
			snap: true,
			momentum: false,
			hScrollbar: false,
			onScrollEnd: function () {
				$('.circle span').removeClass('active');
				$('.circle span').eq(this.currPageX).addClass('active');
			},
			onBeforeScrollStart:function(){//滑动清除定时器
				clearInterval(timer);
				},
			onTouchEnd:function(){
				timer=setInterval(gund,5000);
				i=myScroll2.currPageX;//同步手动与自动定时器
			},
		 });
	
		timer=setInterval(gund,5000); 
		function gund(){ //每5秒滚动
		    i++;
		    if(i==oli_l){
			    i=0;
			    myScroll2.scrollToPage(0, 0, 1000); //滚回第一页
		    } else {
			    myScroll2.scrollToPage('next', 0);
		    };
		};	
	};
	
	if($('#wrapper8').length>0){img_focus()};
});