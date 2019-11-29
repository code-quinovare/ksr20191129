//mobileSelect 定位
function mobileSelectInit(data, ele, title, cb, init) {
  var arr = [];
  var obj = ele;
  if (!!$(obj).attr("data-position")) {
    var eleNode = $(obj).attr("data-position").split(",");
    if (typeof data != "object") {
      var json = eval("(" + data + ")");
    } else {
      var json = data;
    }
    json.forEach(function(v, i) {
      if (v.id == eleNode[0]) {
        arr.push(i)
        if ($(".es-filter").length > 0) {
          $(obj).find("span").text(v.value).css("color", "#333")
        } else {
          $(obj).text(v.value).css("color", "#333")
        }
        if (eleNode.length > 1 && v.childs) {
          v.childs.forEach(function(v, i) {
            if (v.id == eleNode[1]) {
              arr.push(i)
              if ($(".es-filter").length > 0) {
                $(obj).find("span").text(v.value).css("color", "#333")
              } else {
                $(obj).text(v.value).css("color", "#333")
              }
              if (eleNode.length > 2 && v.childs) {
                v.childs.forEach(function(v, i) {
                  if (v.id == eleNode[2]) {
                    arr.push(i)
                    if ($(".es-filter").length > 0) {
                      $(obj).find("span").text(v.value).css("color", "#333")
                    } else {
                      $(obj).text(v.value).css("color", "#333")
                    }
                  }
                })
              }
            }
          })
        }
      }
    })
  } else {
    if (typeof data != "object") {
      var json = eval("(" + data + ")");
    } else {
      var json = data;
    }
    arr = init;
  }
  return typeData && typeData(json, obj, arr, title, cb)
}

function typeData(data, ele, pos, title, cb) {
  return O = new MobileSelect({
    trigger: ele,
    title: title,
    wheels: [
      { data: data }
    ],
    position: pos,
    callback: function(indexArr, data) {
      cb && cb(data)
      $(ele).css("color", "#333")
    }
  });
}

function regNumberLength($this, n) {
  var str = $this.val()
  if (str.length > n) {
    $this.val(str.substr(0, str.length - 1))
  }
}
$(function() {
    if ($(".fw-show").length > 0 && navigator.appVersion && navigator.appVersion.split("MicroMessenger/").length > 1) {
      $(".fw-show").click(function() {
        if ($(this).hasClass("clicked")) {
          $(".record-div").css("display", "none")
          setTimeout(function() {
            $(".record-div").css("top", "-150px").show()
          }, 300)
        } else {
          $(".record-div").css("display", "none")
          setTimeout(function() {
            $(".record-div").css("top", "-403px").show()
          }, 300)
        }
      })
    }
    if ($(".js-carbrand").length > 0) {
      if ($(".js-carbrand").text() != "请选择品牌") {
        $(".js-carbrand").css("color", "#333");
      }
    }
  })
  // 字母搜索
function betterScrollTo(betterData, sendData, toEle, cb) {
  var betterData = (typeof betterData) == "object" ? betterData : eval("(" + betterData + ")");

  var Wrapper = $('.better-scroll').get(0);
  var Scroller = $('.better-ul').get(0);
  var cities = $('.better-hook').get(0);
  var shortcut = $('.better-litter').get(0);

  var bScroll = null;
  var shortcutList = [];
  var anchorMap = {};
  if ($(".betterc-close").length == 0) {
    $(".better-scroll").append("<p class='betterc-close' onclick='betterclose()'>取消</p>")
  }
  if ($(".betterc-all").length == 0) {
    $(".better-scroll").append("<p class='betterc-all'>不限</p>")
  }

  function initCities() {
    var y = 0;
    var titleHeight = 36;
    var itemHeight = 50;

    var lists = '';
    var en = '<ul class="">';
    betterData.forEach(function(group) {
      var name = group.hot;
      if (name == "热门") {
        name = "品牌";
        lists += '<div class="better-hot hot">' + name + '</div>';
        lists += '<ul class="ul-hot disflex">';
      } else {
        lists += '<div class="better-hot">' + name + '</div>';
        lists += '<ul>';
      }
      group.list.forEach(function(g) {
        lists += '<li class="item" data-name="' + g.value + '" data-id="' + g.id + '"><span class="border-1px name">' + g.value + '</span></li>';
      });
      lists += '</ul>';

      var name = group.hot.substr(0, 1);
      en += '<li data-anchor="' + name + '" class="item">' + name + '</li>';
      var len = group.list.length;
      anchorMap[name] = y;
      shortcutList.push(name)
      if (name == "热") {
        cities.innerHTML = lists;
        y -= titleHeight + parseInt($(".ul-hot").height() + 10);
      } else {
        y -= titleHeight + len * itemHeight;
      }


    });
    en += '</ul>';

    cities.innerHTML = lists;

    shortcut.innerHTML = en;
    bScroll = new IScroll(Wrapper, {
      probeType: 3,
      click: true
    });
    $(".better-scroll").show();
    getBetterInfo(sendData, toEle, cb);


    bScroll.on("scroll", function() {
      for (var key in anchorMap) {
        if (this.y < anchorMap[key]) {
          $(".better-litter li").each(function() {
            if ($(this).text() == key) {
              $(this).addClass("active").siblings().removeClass('active');
              $(".better-fixed").text(key)
            }
          })
        }
      }
    })
  }
  //bind Event
  function bindEvent() {
    var touch = {};
    var firstTouch;
    shortcut.addEventListener('touchstart', function(e) {
      var anchor = e.target.getAttribute('data-anchor');
      $(e.target).addClass("active").siblings().removeClass("active");
      firstTouch = e.touches[0];
      touch.y1 = firstTouch.pageY;
      touch.anchor = anchor;
      scrollTo(anchor);

    });

    shortcut.addEventListener('touchmove', function(e) {

      firstTouch = e.touches[0];
      touch.y2 = firstTouch.pageY;

      var anchorHeight = 16;
      var delta = (touch.y2 - touch.y1) / anchorHeight | 0;
      var anchor = shortcutList[shortcutList.indexOf(touch.anchor) + delta];
      $(".better-litter li").each(function() {
        if ($(this).text() == anchor) {
          $(this).addClass("active").siblings().removeClass('active');
        }
      })
      scrollTo(anchor);

      e.preventDefault();
      e.stopPropagation();

    });

    function scrollTo(anchor) {
      if (!!anchor && $(".better-fixed").text() != anchor) {
        $(".better-fixed").text(anchor)
      }
      var maxScrollY = Wrapper.clientHeight - Scroller.clientHeight;
      var y = Math.min(0, Math.max(maxScrollY, anchorMap[anchor]));
      if (typeof y !== 'undefined') {
        bScroll.scrollTo(0, y);
      }
    }
  }

  initCities();

  bindEvent();
  var toPos = $("#brand").attr("data-position");
  toPos = toPos ? toPos : false;
  $('.better-hook li').each(function() {
    if ($(this).attr("data-id") == toPos) {
      $(this).css("color", "#f00");
      bScroll.refresh();
      bScroll.scrollTo(0, -$(this).offset().top + 300);
      return false;
    }
  })
  console.log(1)
  $(".betterc-all").click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    betterclose();
    $("#" + sendData).val(0);
    $(toEle).text("不限");
    cb && cb();
  })
}

function getBetterInfo(sendData, toEle, cb) {
  $(".better-ul .li-group").each(function() {
    $(this).find("li").each(function() {
      $(this).on("click", function(e) {
        if ($(".js-carbrand").length > 0) {
          $(".js-carbrand").css("color", "#333")
        }
        $("#" + sendData).val($(this).attr("data-id"), $(this).text())
        $(toEle).text($(this).text())
        cb && cb();
        betterclose()
        e.stopPropagation();
        e.preventDefault();
      })
    })
  })
}
$(".better-scroll-mask").click(function() {
    betterclose();
  })
  //关闭
function betterclose() {
  $(".better-scroll").hide();
  setTimeout(function() {
    $(".better-scroll-mask").hide();
  }, 100);
  if ($("#brand .icon-sanjiao").length > 0) {
    $("#brand .icon-sanjiao").removeClass("on");
  }
}

function fBlur(ele) {
  $(ele).focus(function() {
    $(this).blur();
  })
}