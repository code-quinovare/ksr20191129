// JavaScript Document


/*选择弹出框*/
window.dialog={
    //在元素onclick事件上调用此方法，将弹窗内容通过传参加入弹窗中
    fn:function(ele,title,arry,width,radius){
        var a=dialog.makeitem(arry);
        $('body').append('<div class="cover" id="cover"><div class="item_wrap" style="width:'+width+';border-radius:'+radius+';"><h5>'+title+'</h5>'+a+'</div></div>');
        dialog.setPosition();
        dialog.cancel();
        dialog.choose(ele);
    },
    //将弹窗中要选择的项目循环排列出来
    makeitem:function(arry){
        var num=arry.length;
        var item='';
        for(var i= 0;i<num;i++){
            item+='<li>'+arry[i]+'</li>';
        }
        item='<ul class="item_list">'+item+'</ul>';
        return item;
    },
    //设置弹窗距顶部位置
    setPosition:function(){
        var h=$('.item_wrap').height();
        $('.item_wrap').css("margin-top",-(h/2));

    },
    //点击遮罩层关闭弹窗
    cancel:function(){
        $(document).click(function(e){
            if(e.target.className=="cover"){
                $('#cover').remove();
            }
        });
    },
    //点击所选项目，赋值
    choose:function(ele){

    }
};



/*
 弹窗 vs---弹窗练手1.00
 ypf 2015-11-27
 */
; (function ($) {
    var defaults = {
        //'style': 'style1',                                                                                               //默认dialog样式
        'title': { 'bool': false, 'className': 'dialog-tit', 'txt': 'dialog的抬头' },                  //是否有抬头
        'exit': { 'bool': true, 'className': 'dialog-exit' },                                               //是否有退出按钮
        'content': {},
        'footer': {},
        'marker': true
    }
    $.fn.Dialog = function (options) {
		$("#dialog").remove();
        var opts = $.extend(defaults, options);
        this.each(function () {
            var thisTable = $(this);

            thisTable.bind('mousedown', function () {
                $.DialogCreat(opts);
                //var m1 = new Mark();
                //m1.init({ animation: 'fadeIn' });
                //$('#mark').css({ 'z-index': 9998, 'position': 'fixed' }).height($(window).height());
                var ss;
                if (thisTable.data('tit') != undefined) {
                    ss = thisTable.data('tit');
                    $('#dialog .dialog-tit').html(ss);
                }
                if (thisTable.data('img') != undefined) {
                    ss = thisTable.data('img');
                    $('#dialog .dialog-src').attr('src', ss);
                }
                if (thisTable.data('img2') != undefined) {
                    ss = thisTable.data('img2');
                    $('#dialog .imgwarp').append("<img class='simg' src='"+ss+"'>");
                }
                if (thisTable.data('p1') != undefined) {
                    ss = thisTable.data('p1');
                    $('#dialog .dialog-p3').html(ss);
                }
                if (thisTable.data('p2') != undefined) {
                    ss = thisTable.data('p2');
                    $('#dialog .dialog-p4').html(ss);
                }
                //liuchao
                if (thisTable.data('huati') != undefined) {
                    ss = thisTable.data('huati');
                    $('#dialog .dialog-p5').html(ss);
                }
                if (thisTable.data('take') == "take") {
                    $('#dialog .imgwarp').append('<i class="dian"></i>');
                }

                if (thisTable.data('num') != undefined) {
                    ss = thisTable.data('num');
                    $('#dialog .dialog-p6').html(ss);
                }
                if (thisTable.data('grow') != undefined) {
                    ss = thisTable.data('grow');
                    $('#dialog .dialog-p7').html(ss);
                }
                if (thisTable.data('imgflag') != undefined) {
                    ss = thisTable.data('imgflag');
                    var ahtml = (thisTable.data('atxt') == undefined) ? '' : thisTable.data('atxt');
                    switch (ss) {
                        case 0:
                            $('#dialog .img-get').attr('src', 'http://img.pccoo.cn/wap/WebApp/images/noget.png');
                            break;
                        case 1:
                            $('#dialog .img-get').attr('src', 'http://img.pccoo.cn/wap/WebApp/images/get1.png');
                            $('#dialog .dialog-a1').html(ahtml);
                            break;
                        default:
                            $('#dialog .img-get').attr('src', 'http://img.pccoo.cn/wap/WebApp/images/noget.png');
                            break;
                    }
                }
                /*if (thisTable.data('btn') != undefined) {
                    ss = thisTable.data('btn');
                    switch (thisTable.data('btn')) {
                        case 'finish':
                            $('#dialog .btn').html('已点亮此勋章');
                            break;
                        case 'passable':
                            $('#dialog .btn').html('可点亮');
                            $('#dialog .sup').addClass('active');
                            break;
                        case 'level':
                            $('#dialog .btn').addClass('disable').html('你尚未达到进阶条件');
                            break;
                        case 'disable':
                            $('#dialog .btn').addClass('disable').html('你尚未达到点亮条件');
                            break;
                        default:
                            if (ss.indexOf('finish') != undefined && ss.indexOf('finish') == 0) {
                                var day = ss.split('finish')[1];
                                $('#dialog .btn').html('已点亮此勋章, ' + day + '天后失效');
                            }
                            break;
                    }
                }*/
				if (thisTable.data('btn') != undefined) {
                	btnTxt(thisTable);
				 }
            })

        });

    };
    $.DialogCreat = function (options,cb,cancelFilterClose) {
        tipLoadingRemove();
        var opts = $.extend(defaults, options);
		$("#dialog").remove();
        var style = (opts.style == '' || opts.style == null || opts.style == undefined) ? 'style1' : opts.style;
        $(document.body).append('<div id="dialog" class="' + style + '"><div class="dialog-warp"></div><div class="dialog-content"></div></div>')
        //设置dialog抬头
        if (opts.title.bool == true) {
            switch (opts.title.className) {
                case 'dialog-tit':
                    opts.title.txt = (opts.title.txt == undefined) ? 'dialog抬头' : opts.title.txt;
                    $('#dialog .dialog-warp').append('<div>' + opts.title.txt + '</div>');
                    $('#dialog .dialog-warp').find('div').addClass(opts.title.className);
                    break;
                default:
                    break;
            }
        }
        //设置dialog退出按钮
        if (opts.title.bool == true) {
            switch (opts.exit.className) {
                case 'dialog-exit':
                    $('#dialog .dialog-warp').append('<em>x</em>');
                    $('#dialog .dialog-warp').find('em').addClass(opts.exit.className);
                    break;
                default:
                    $('#dialog .dialog-warp').append('<em>x</em>');
                    $('#dialog .dialog-warp').find('em').addClass('dialog-exit');
                    break;
            }
        }

        //设置内容

        var ss = '';
        var temp = '';
        $.each(opts.content, function (i, n) {
            //ss = '';
            var iBq = i;
            var iJson = n;
            iJson = (iJson == undefined) ? '' : iJson;
            // ss += ss;
            switch (iBq) {
                case 'img':
                    ss += '<div class="dialog-img"><div class="imgwarp"><img src="http://img.pccoo.cn/wap/WebApp/images/neirongpinglun.png"  class="dialog-src" /></div></div>';
                    break;
                case 'imgRotate':
                    // opts.content.btn.txt = (opts.content.btn.txt == undefined) ? 'dialog按钮' : opts.content.btn.txt;
                    ss += '<div class="dialog-img"><div class="imgwarp"><img src="http://img.pccoo.cn/wap/WebApp/images/neirongpinglun.png"  class="dialog-src" /></div><div class="img-rotate"><img src="http://img.pccoo.cn/wap/WebApp/images/get1.png" class="img-get" /></div></div>';
                    break;
                case 'p':
                    $.each(iJson, function (i, n) {
                        ss += '<p class="' + iJson[i]['className'] + '">' + iJson[i]['txt'] + '</p>';
                    })

                    break;
                case 'a1':
                    // iJson[i]['className'] = (iJson[i]['className'] == undefined) ? 'dialog按钮' : iJson[i]['className'];
                    ss += '<div class="dialog-div1"><a class="dialog-a1" href="javascript:;" ></a></div>';
                    break;
                case 'btn':
                    opts.content.btn.txt = (opts.content.btn.txt == undefined) ? 'dialog按钮' : opts.content.btn.txt;
                    ss += '<div class="dialog-btn"><span class="btn ' + opts.content.btn.className + '">' + opts.content.btn.txt + '</span><sup class="sup"></sup></div>';
                    break;
                case 'ul':
                    var liclass = (opts.content.ul.liclass == null || opts.content.ul.liclass == undefined) ? 'dialog-li' : opts.content.ul.liclass;
                    if (opts.content.ul.txt.length > 0) {
                        ss += '<ul class="dialog-ul">'
                        for (var i = 0; i < opts.content.ul.txt.length; i++) {
                            ss += '<li class=' + liclass + '><a href="javascript:;">' + opts.content.ul.txt[i] + '</a></li>';
                        }
                        ss += '</ul>'
                    }
                    break;
                case 'html':
                    opts.content.html = (opts.content.html == null || opts.content.html == undefined) ? '' : opts.content.html;
                    ss += opts.content.html;
                    break;
                case 'inputxt':
                    var id, txt, _class, validator;

                    if (opts.content.inputxt.txt.length > 0) {
                        for (var i = 0; i < opts.content.inputxt.txt.length; i++) {
                            _class = (opts.content.inputxt.inputclass == undefined || opts.content.inputxt.inputclass[i] == null || opts.content.inputxt.inputclass[i] == undefined) ? 'dialog-inputxt1' :
                                opts.content.inputxt.inputclass[i];
                            id = (opts.content.inputxt.id == undefined || opts.content.inputxt.id[i] == null || opts.content.inputxt.id[i] == undefined) ? '' :
                                opts.content.inputxt.id[i];
                            txt = (opts.content.inputxt.txt == undefined || opts.content.inputxt.txt == null || opts.content.inputxt.txt == undefined) ? '' :
                                opts.content.inputxt.txt;
                            validator = (opts.content.inputxt.validator == undefined || opts.content.inputxt.validator == null || opts.content.inputxt.validator == undefined) ? '' :
                                opts.content.inputxt.validator;
                            ss += '<div class="' + _class + '"><input   type="text" id="' + opts.content.inputxt.id[i] + '" validator = "' + opts.content.inputxt.validator[i] + '"  value="" placeholder="' + opts.content.inputxt.txt[i] + '" /></div>';
                        }
                    }
                    break;
                case 'inputxt1':
                    var id, txt, _class, validator;
                    if (opts.content.inputxt1.txt.length > 0) {
                        for (var i = 0; i < opts.content.inputxt1.txt.length; i++) {
                            _class = (opts.content.inputxt1.inputclass == undefined || opts.content.inputxt1.inputclass[i] == null || opts.content.inputxt1.inputclass[i] == undefined) ? 'dialog-inputxt1' :
                                opts.content.inputxt.inputclass[i];
                            id = (opts.content.inputxt1.id == undefined || opts.content.inputxt1.id[i] == null || opts.content.inputxt1.id[i] == undefined) ? '' :
                                opts.content.inputxt.id[i];
                            txt = (opts.content.inputxt1.txt == undefined || opts.content.inputxt1.txt == null || opts.content.inputxt1.txt == undefined) ? '' :
                                opts.content.inputxt.txt;
                            validator = (opts.content.inputxt1.validator == undefined || opts.content.inputxt1.validator == null || opts.content.inputxt1.validator == undefined) ? '' :
                                opts.content.inputxt1.validator;
                            ss += '<div class="' + _class + '"><input   type="text" id="' + opts.content.inputxt1.id[i] + '" validator = "' + opts.content.inputxt1.validator[i] + '"  value="" placeholder="' + opts.content.inputxt1.txt[i] + '" /></div>';
                        }
                    }
                    break;
                case 'inputradio':
                    var value, txt, _class, validator, title = '';

                    if (opts.content.inputradio.txt.length > 0) {
                        _class = (opts.content.inputradio.inputclass == undefined || opts.content.inputradio.inputclass[i] == null || opts.content.inputradio.inputclass[i] == undefined) ? 'dialog-inputxt1' :
                            opts.content.inputradio.inputclass[i];
                        title = (opts.content.inputradio.title == undefined || opts.content.inputradio.title == null || opts.content.inputradio.title == undefined) ? '' :
                            opts.content.inputradio.title;

                        ss += '<div class="' + _class + '">' + title + '';

                        for (var i = 0; i < opts.content.inputradio.txt.length; i++) {
                            var temp = '';
                            if (i == 1) {
                                temp = 'checked';
                            }
                            txt = (opts.content.inputradio.txt == undefined || opts.content.inputradio.txt == null || opts.content.inputradio.txt == undefined) ? '' :
                                opts.content.inputradio.txt;
                            value = (opts.content.inputradio.value == undefined || opts.content.inputradio.value == null || opts.content.inputradio.value == undefined) ? '' :
                                opts.content.inputradio.value;
                            ss += '<input   type="radio" name="' + opts.content.inputradio.name[i] + '" value = "' + opts.content.inputradio.value[i] + '" checked = " ' + temp + '"  />' + opts.content.inputradio.txt[i];
                        }
                        ss += '</div>';
                    }
                    break;
                case 'inputxtnum':
                    var value, txt, _class, validator, title = '';
                    var max, length;
                    if (opts.content.inputradio.title.length > 0) {
                        _class = (opts.content.inputxtnum.inputclass == undefined || opts.content.inputxtnum.inputclass == null || opts.content.inputxtnum.inputclass == undefined) ? 'dialog-inputxtnum ' :
                            opts.content.inputradio.inputclass;
                        title = (opts.content.inputxtnum.title == undefined || opts.content.inputxtnum.title == null || opts.content.inputxtnum.title == undefined) ? '' :
                            opts.content.inputxtnum.title;
                        id = (opts.content.inputxtnum.id == undefined || opts.content.inputxtnum.id == null || opts.content.inputxtnum.id == undefined) ? '' :
                            opts.content.inputxtnum.id;
                        value = (opts.content.inputxtnum.value == undefined || opts.content.inputxtnum.value == null || opts.content.inputxtnum.value == undefined) ? '1' :
                            opts.content.inputxtnum.value;
                        max = (opts.content.inputxtnum.max == undefined || opts.content.inputxtnum.max == null || opts.content.inputxtnum.max == undefined) ? 9 :
                            opts.content.inputxtnum.max;
                        length = (opts.content.inputxtnum.length == undefined || opts.content.inputxtnum.length == null || opts.content.inputxtnum.length == undefined) ? 1 :
                            opts.content.inputxtnum.length;

                        ss += '<div class="' + _class + '"><span>' + title + '</span><span class="dialog-num"><span class="inputxtnum-minus off">-</span><input type="text" id="' + id + '" name="num" value=' + value + ' class="inputnum" maxlength=' + length + ' data-max=' + max + '><span class="inputxtnum-add ">+</span></span></div>';
                    }
                    break;
                default:
                    ss += '';
                    break;
            }



        })
        $('#dialog .dialog-content').append(ss);
        $.each(opts.footer, function (i, n) {
            var iBq = i;
            var iJson = n;
            iJson = (iJson == undefined) ? '' : iJson;
            $('#dialog .dialog-content').after('<div class="dialog-footer"></div>');
            switch (iBq) {
                case 'style':
                    $('#dialog .dialog-footer').addClass(iJson);
                    $('#dialog .dialog-footer').append('<div class="footer-left"></div><div class="footer-right"></div>')
                    break;
                case 'txt':
                    if ($('#dialog .dialog-footer').hasClass('dialog-footer1')) {
                    	if(iJson[0]==""){
                    		 $('#dialog .footer-right').html(iJson[1]);
                    		 $(".footer-left").remove();
                    		 return;
                    	}
                        $('#dialog .footer-left').html(iJson[0]);
                        $('#dialog .footer-right').html(iJson[1]);
                    }
                    break;
                default:
                    break;
            }
        })
        //定位
        Dir('center', $('#dialog'));
        $('#dialog').fadeIn(100);
        if (opts.marker) {
            $.yyCreateMark("", cancelFilterClose);
        }
        //绑定事件
        $('#dialog .dialog-exit,#dialog .footer-left').bind('mousedown click', function () {
            $.DialogClose(opts,cb);
        })
        $('#dialog .footer-right').bind('mousedown', function () {
            if (typeof (opts.callback) == 'undefined') {
                return;
            } else {
                opts.callback();
                $.DialogClose(opts);
            }
        })
        $('#dialog .dialog-li').bind('click', function () {
            $.DialogClose(opts);
            if (typeof (opts.callback) == 'undefined') {
                return;
            } else {
                opts.callback();

            }
        })


        if (opts.bind != undefined) {

            $.each(opts.bind, function (i, n) {
                switch (i) {
                    case 'selector':
                        $(opts.bind.selector).bind('click', function () {
                        })
                        return;
                        break;
                    case 'callback':
                        if (typeof (n) == 'undefined') {
                            return;
                        } else {
                            $(opts.bind.selector).bind('click', opts.bind.callback);
                        }
                        break;
                    default:
                        break;
                }
            })
        }
    }
    //关闭弹窗
    $.DialogClose = function (options,cb,cancelFilterClose) {
        if ((typeof cb == 'function') && cb) {
          cb()
        }
		var opts = $.extend(defaults, options);
		$('#dialog-warp').remove();
		$('#dialog').fadeOut(100).remove();		
		$('#mark').fadeOut(100).remove();
		if($(".selector-main").length>0 || $('.selector-mask').length>0){
			$('.selector-main').fadeOut(100).remove();
	         $('.selector-mask').fadeOut(100).remove();
        }
    }
    $(document).click(function(e){
        if(e.target.id=="mark"){
           if (!$("#mark").hasClass("close-sign")) {
             $.DialogClose();
           }
        }
    })
})(jQuery);





/*
 提示 vs---提示练手1.00
 ypf 2015-11-27
 */
; (function ($) {
    var defaults = {
        'type': 'defaults',
        'dir': 'center',
        'animation': 'fadeIn',
        'txt': '提示',
        'delay': 3000,
    }
    $.MsgCreat = function (opt) {
        var opts = $.extend(defaults, opt);
        $('#msg').remove();
        $(document.body).prepend('<div id="msg"  class = "' + opts.type + '"><div class="msg-txt">' + opts.txt + '</div></div>');

        Dir(opts.dir, $('#msg'));

        switch (opts.animation) {
            case 'slideDown':
                $('#msg').slideDown(100);
                break;
            case 'show':
                $('#msg').show(100);
                break;
            case 'fadeIn':
                $('#msg').fadeIn(100);
                break;
            default:
                $('#msg').fadeIn(100);
                break;
        }
        $.MsgClose();
    }
    $.fn.Msg = function (opt) {
        var opts = $.extend(defaults, opt);
        this.each(function () {
            $Msg = $(this);
            $Msg.on('click', function () {
                $.MsgCreat(opt);
            })

        })
    }

    $.MsgClose = function (opt) {
        var opts = $.extend(defaults, opt);
        setTimeout(function () {
            $('#msg').fadeOut(100);
            setTimeout(function () {
                $('#msg').remove();
            });
        }, opts.delay)
    }
})(jQuery);


function Dir(dir, selector) {
    var _left, _top, _bottom, _right;
    if (dir == 'center') {
        _left = ($(document).width() - selector.outerWidth()) / 2 + 'px';
        _top = ($(window).height() - selector.height()) / 2 + 'px';
        selector.css({ 'left': _left, 'top': _top });
    } else if (dir == 'centerTop') {
        _left = ($(document).width() - selector.outerWidth()) / 2 + 'px';
        _top = 0 + 'px';;
        selector.css({ 'left': _left, 'top': _top })
    } else if (dir == 'centerBottom') {
        _left = ($(document).width() - selector.outerWidth()) / 2 + 'px';
        _bottom = 0 + 'px';
        selector.css({ 'left': left, 'bottom': _bottom })
    } else if (dir == 'centerTop20') {
        _left = ($(document).width() - selector.outerWidth()) / 2 + 'px';
        _top = 20 + 'px';
        selector.css({ 'left': _left, 'top': _top })
    } else if (dir == 'centerBottom20') {
        _left = ($(document).width() - selector.outerWidth()) / 2 + 'px';
        _bottom = 20 + 'px';
        selector.css({ 'left': _left, 'bottom': _bottom })
    } else if (dir == 'left') {
        _top = 0 + 'px';
        _left = 0 + 'px';
        selector.css({ 'left': _left, 'top': top });
    } else if (dir == 'leftCenter') {
        _left = 0 + 'px';
        _top = ($(document).height() - selector.outerWidth()) / 2 + 'px';
        selector.css({ 'left': _left, 'top': _top });
    } else {
        _left = ($(document).width() - selector.outerWidth()) / 2 + 'px';
        _top = ($(document).height() - selector.height()) / 2 + 'px';
        selector.css({ 'left': _left, 'top': _top });
    }
}


// 遮罩 vs---遮罩练手1.00
// ypf 2015-11-27
// 
; (function ($) {
    var defaults = {
        'dir': 'center',
        'animation': 'fadeIn',
        'markH': null,
        'selector': '',
    }
    $.fn.yyMark = function (opt) {
        var opts = $.extend(defaults, opt);
        var $this = $(this);
        $this.on('click', function () {
            $.yyCreateMark(opts);
        })
    }
    $.yyCreateMark = function (opt,closeSign) {
        var opts = $.extend(defaults, opt);
        var markH = $(window).height();
        var markW = $(window).width();
        var top, height;
        if (opts.selector == null || opts.selector == undefined || opts.selector=='') {
            top = 0;
        } else {
            top = opts.selector.offset().top + opts.selector.height();
        }
        if (closeSign) {
          $(document.body).append('<div id="mark" class="close-sign" style="position:fixed;left:0px;top:' + top + 'px;width:' + markW + 'px;height:' + markH + 'px;"></div>');
        } else {
          $(document.body).append('<div id="mark" style="position:fixed;left:0px;top:' + top + 'px;width:' + markW + 'px;height:' + markH + 'px;"></div>');
        }
        switch (opts.animation) {
            case 'slideDown':
                $('#mark').slideDown(100);
                break;
            case 'show':
                $('#mark').show(100);
                break;
            case 'fadeIn':
                $('#mark').fadeIn(100);
                break;
            default:
                $('#mark').slideDown(100);
                break;
        }
        //$('#mark').bind('touchmove scroll', function (e) {
        //    e.preventDefault();
        //})

    }

    $.yyCloseMark = function () {
		 	$('#dialog').fadeOut(100).remove();
            $('#mark').fadeOut(100).remove();
    }

    $.markToggle = function (opt) {
        var opts = $.extend(defaults, opt);
        var markH = $(window).height();
        var markW = $(window).width();
        var _selector = opts.selector;
        var _top = $(_selector).offset().top + parseInt($(_selector).height());
        _top = (_top == undefined) ? 0 : _top;
        if (!$('#mark').hasClass('temp')) {
            $(document.body).append('<div id="mark" class= "temp" style="position:absolute;left:0px;top:' + _top + 'px;width:' + markW + 'px;height:' + markH + 'px;"></div>');
        }
        switch (opts.animation) {
            case 'slideDown':
                $('#mark').slideDown(100);
                break;
            case 'show':
                $('#mark').show(100);
                break;
            case 'fadeIn':
                $('#mark').fadeIn(100);
                break;
            default:
                $('#mark').slideDown(100);
                break;
        }

        //$('#mark').bind('touchmove scroll', function (e) {
        //    e.preventDefault();
        //})
    }
})(jQuery);


/*
 遮罩 vs---练手1.00
 ypf 2015-11-09
 遮罩 创建MarkCreate() 关闭 MarkClose()
 */

//遮罩函数
function Mark() {
    this.settings = {
        centent: '<div id="mark"></div>',
        animation: 'show',
        markH: null,
    };
    this.oSelector = null;
}
//关闭遮罩
function MarkClose() {
        $('#mark').fadeOut(100).remove();
}

; (function ($) {
    Mark.prototype.init = function (opt, selector) {
        $.extend(this.settings, opt);
        this.oSelector = $(selector);

        this.create();

    }

    Mark.prototype.create = function () {
        var _top = 48;
        var markH, markW, aa;
        var _this = this.oSelector;
        if (this.settings.markH != null) {
            markH = $('.listdata').height();
        }
        markH = (markH > 0) ? markH : $(window).height();
        markW = $(window).width();
       // $(document.body).append('<div id="mark" style="position:absolute;left:0;top:' + top + 'px;width:' + markW + 'px;height:' + markH + 'px;"></div>');

        switch (this.settings.animation) {
            case 'slideDown':
                $('#mark').slideDown(100);
                break;
            case 'show':
                $('#mark').show(100);
                break;
            case 'fadeIn':
                $('#mark').fadeIn(100);
                break;
            default:
                $('#mark').slideDown(100);
                break;
        }

        //$('#mark').bind('touchmove scroll', function (e) {
        //    e.preventDefault();
        //})
    }
})(jQuery);
//创建遮罩
function MarkCreate() {
    var m1 = new Mark();
    m1.init({ markH: 1 }, '.listheader-span');
}