/*
* WebApp 公用功能
* */

//快捷发布

function quickPost(ele) {
    /* var html='<section class="post-wrap">' +
        '<img src="http://img.pccoo.cn/wap/WebApp/images/link_page_banner.png" class="img">' +
        '<ul class="post-list">' +
        '<li><a href="#"><span><img src="http://img.pccoo.cn/wap/WebApp/images/y-bbs.png"> </span><em>发布帖子</em></a></li>' +
        '<li><a href="#"><span><img src="http://img.pccoo.cn/wap/WebApp/images/y-huodong.png"> </span><em>创建活动</em></a></li>' +
        '<li><a href="#"><span><img src="http://img.pccoo.cn/wap/WebApp/images/y-post.png"> </span><em>分类信息</em></a></li>' +
        '<li><a href="#"><span><img src="http://img.pccoo.cn/wap/WebApp/images/y-xiuchang.png"> </span><em>晒美照</em></a></li>' +
        '<li><a href="#"><span><img src="http://img.pccoo.cn/wap/WebApp/images/y-help.png"> </span><em>找帮助</em></a></li>' +
        '<li><a href="#"><span><img src="http://img.pccoo.cn/wap/WebApp/images/y-ewm.png"> </span><em>二维码</em></a></li>' +
        '<li><a href="#"><span><img src="http://img.pccoo.cn/wap/WebApp/images/y-qiandao.png"> </span><em>分类信息</em></a></li>' +
        '<li><a href="#"><span><img src="http://img.pccoo.cn/wap/WebApp/images/y-che.png"> </span><em>分类信息</em></a></li>' +
        '</ul>' +
        '</section>';
    $("body").append(html);*/
    $(ele).toggleClass("on");
    if (!$(ele).hasClass("on")) {
        $(".post-wrap").hide();
    } else {
        $(".post-wrap").show();
    }
}

//滚动提醒
var left = $("#moving_text").scrollLeft();
function move() {
    var width = $(".text_cont li").outerWidth();
    $(".text_cont li:last-child").html($(".text_cont li:first-child").html());
    $("div.text_cont").css("width", width * 2 + 1);
    $("#moving_text").scrollLeft(left++)
    //$("#moving_text").scrollLeft()
    if (left >= width) {
        left = 0;
    }
}

function goMove(ele, word, url) {
    if (word == "undefined") { return; }
    if(url==undefined){ url="/message/" }
    var moving = setInterval(move, 60);
    createMove(ele, word, url);
    $(".clos").click(function (e) {
        e.preventDefault();
        clearTimeout(moving);
        $(".text-wrap").fadeOut();
        $(".text-wrap").remove();
    });
}

function createMove(ele, word, url) {
    if ($(".text-wrap").length > 0) {
        $(".text-wrap").remove();
    }
    var html = '<div class="text-wrap">' +
        '<span class="icon inform"></span><span class="icon clos"></span>' +
        '<div id="moving_text"> <div class="text_cont">' +
        '<a href="' + url + '"><ul><li>' + word + '</li><li></li></ul></a>' +
        '</div></div></div>';
    $(ele).append(html);
    move();
    var height = $(document).scrollTop()
    if (height > 50) {
        $('.text-wrap').css('position', 'fixed')
    } else {
        $('.text-wrap').css('position', 'absolute')
    }
}
//智能组前面的盒子去掉底部横线
$(function() {
  if($('.news_wrap').length!=0 && $('.smart-info').length!=0){
    $('.smart-info').prev('li').css({
      'border-bottom': 'none'
    });
  }
})