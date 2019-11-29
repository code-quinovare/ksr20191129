//关闭支付选择窗口
function payTypeClose() {
    $(".w-pay-mask,.w-pay-box").remove();
}
//拼接支付选择窗口
function DrowPayType(payWay, price,desc) {
    payWay = parseInt(payWay);
    var payTypeHtml = '';
    //公众号js支付
    if ((payWay & 1) == 1) {
        payTypeHtml += '<li class="disflex" data-tag="wxzf" data-info="微信支付">\
                            <i class="i-bg i-wx"></i>\
                            <p class="flexn">微信支付</p>\
                            <span class="pay-get"><i class="iconfont icon-right1"></i></span>\
                            </li>';
    }
    //非微信h5支付
    if ((payWay & 8) == 8 && window.location.host.indexOf("ccoo.cn")>0) {
        payTypeHtml += '<li class="disflex" data-tag="wxzfh5" data-info="微信支付">\
                            <i class="i-bg i-wx"></i>\
                            <p class="flexn">微信支付</p>\
                            <span class="pay-get"><i class="iconfont icon-right1"></i></span>\
                            </li>';
    }
    if ((payWay & 2) == 2) {
        payTypeHtml += '<li class="disflex" data-tag="zfb" data-info="支付宝">\
                            <i class="i-bg i-zfb"></i>\
                            <p class="flexn">支付宝支付</p>\
                            <span class="pay-get"><i class="iconfont icon-right1"></i></span>\
                            </li>';
    }
    var html = '<section onclick="payTypeClose()" class="w-pay-mask"></section>\
                <section class="w-pay-box">\
                  <p class="tit">请选择支付方式</p>\
                  <p class="pay-info">您正在以￥' + price + ' 购买' + desc + '</p>\
                  <p class="pay-line"><span></span></p>\
                  <div class="w-pay-choose">\
                    <ul>'+ payTypeHtml + '</ul>\
                    <p class="pay-line"><span></span></p>\
                  </div>\
                  <p class="w-pay-go payType"><span>支付</span></p>\
                  <i onclick="payTypeClose()" class="iconfont icon-guanbi w-pay-close"></i>\
                </section>';
    if ($(".w-pay-box").length === 0) {
        $("body").append(html);
        $(".w-pay-choose").find("li:first").addClass("on")
    };
    function payTypeGetOne() {
        $(".w-pay-choose").find("li").each(function () {
            $(this).click(function () {
                $(".w-pay-choose li.on").removeClass("on");
                $(this).addClass("on");
            });
        });
    }
    payTypeGetOne();
}

var ptype;//选中的支付类型
var payStrInfo;//选中的支付类型
//选择支付类型
function ChoosePayType() {
    var lion = $(".w-pay-choose li.on").length;
    if (lion < 1) {
        tipFun("请选择支付方式");
        return false;
    }
    else {
        var $this = $(".w-pay-choose li.on");
        ptype = $this.attr('data-tag');
        payStrInfo = $this.attr('data-info');
        return true;
    }
}