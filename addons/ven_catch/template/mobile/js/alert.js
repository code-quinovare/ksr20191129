
//任务弹框
var taskBtn = $(".task-box .task-title"), taskList = $(".task-box .task-list"),
    changeTask1 = $(".nav .right-nav .task"),changeTask11 = $(".nav .right-nav .usercp"), changeTask2 = $(".change-task-box"), taskBox = $(".task-box"),
    blackBox = $(".black-box");
$(changeTask1).on("click", function () {
    scrollTop = $("body").scrollTop();
    $(taskBox).show();
    $(blackBox).show();
    $("body").css({
        'overflow': 'hidden',
        'position': 'fixed',
        'top': scrollTop * -1
    });
    $(taskBtn[0]).addClass("active").siblings().removeClass("active");
    $(taskList[1]).hide();
    $(taskList[0]).show();
})
$(changeTask11).on("click", function () {
    scrollTop = $("body").scrollTop();
    $(taskBox).show();
    $(blackBox).show();
    $("body").css({
        'overflow': 'hidden',
        'position': 'fixed',
        'top': scrollTop * -1
    });
    $(taskBtn[1]).addClass("active").siblings().removeClass("active");
    $(taskList[0]).hide();
    $(taskList[1]).show();
})

$(changeTask2).on("click", function () {
    $(taskBox).hide();
    $(blackBox).hide();
    $("body").css({
        'overflow': 'auto',
        'position': 'static',
        'top': 'auto'
    });
    $("body").scrollTop(scrollTop);
})
$(taskBtn[0]).on("click", function () {
    $(this).addClass("active").siblings().removeClass("active");
    $(taskList[1]).hide();
    $(taskList[0]).show();
})
$(taskBtn[1]).on("click", function () {
    $(this).addClass("active").siblings().removeClass("active");
    $(taskList[0]).hide();
    $(taskList[1]).show();
})


//排行弹框
var rankBtn = $(".rank-box .rank-title"), rankList = $(".rank-box .rank-list"),
    changerank1 = $(".nav .right-nav .rank"),changerank11 = $(".nav .right-nav .usercp"), changerank2 = $(".change-rank-box"), rankBox = $(".rank-box"),
    blackBox = $(".black-box");
$(changerank1).on("click", function () {
    scrollTop = $("body").scrollTop();
    $(rankBox).show();
    $(blackBox).show();
    $("body").css({
        'overflow': 'hidden',
        'position': 'fixed',
        'top': scrollTop * -1
    });
    $(rankBtn[0]).addClass("active").siblings().removeClass("active");
    $(rankList[1]).hide();
    $(rankList[0]).show();
})
$(changerank11).on("click", function () {
    scrollTop = $("body").scrollTop();
    $(rankBox).show();
    $(blackBox).show();
    $("body").css({
        'overflow': 'hidden',
        'position': 'fixed',
        'top': scrollTop * -1
    });
    $(rankBtn[1]).addClass("active").siblings().removeClass("active");
    $(rankList[0]).hide();
    $(rankList[1]).show();
})

$(changerank2).on("click", function () {
    $(rankBox).hide();
    $(blackBox).hide();
    $("body").css({
        'overflow': 'auto',
        'position': 'static',
        'top': 'auto'
    });
    $("body").scrollTop(scrollTop);
})
$(rankBtn[0]).on("click", function () {
    $(this).addClass("active").siblings().removeClass("active");
    $(rankList[1]).hide();
    $(rankList[0]).show();
})
$(rankBtn[1]).on("click", function () {
    $(this).addClass("active").siblings().removeClass("active");
    $(rankList[0]).hide();
    $(rankList[1]).show();
})

//礼品弹框
var awardBtn = $(".award-box .award-title"), awardList = $(".award-box .award-list"),
    changeaward1 = $(".nav .right-nav .award"),changeaward11 = $(".nav .right-nav .usercp"), changeaward2 = $(".change-award-box"), awardBox = $(".award-box"),
    blackBox = $(".black-box");
$(changeaward1).on("click", function () {
    scrollTop = $("body").scrollTop();
    $(awardBox).show();
    $(blackBox).show();
    $("body").css({
        'overflow': 'hidden',
        'position': 'fixed',
        'top': scrollTop * -1
    });
    $(awardBtn[0]).addClass("active").siblings().removeClass("active");
    $(awardList[1]).hide();
    $(awardList[0]).show();
})
$(changeaward11).on("click", function () {
    scrollTop = $("body").scrollTop();
    $(awardBox).show();
    $(blackBox).show();
    $("body").css({
        'overflow': 'hidden',
        'position': 'fixed',
        'top': scrollTop * -1
    });
    $(awardBtn[1]).addClass("active").siblings().removeClass("active");
    $(awardList[0]).hide();
    $(awardList[1]).show();
})

$(changeaward2).on("click", function () {
    $(awardBox).hide();
    $(blackBox).hide();
    $("body").css({
        'overflow': 'auto',
        'position': 'static',
        'top': 'auto'
    });
    $("body").scrollTop(scrollTop);
})
$(awardBtn[0]).on("click", function () {
    $(this).addClass("active").siblings().removeClass("active");
    $(awardList[1]).hide();
    $(awardList[0]).show();
})
$(awardBtn[1]).on("click", function () {
    $(this).addClass("active").siblings().removeClass("active");
    $(awardList[0]).hide();
    $(awardList[1]).show();
})

//游戏介绍弹框
var ruleBtn = $(".rule-box .rule-title"), ruleList = $(".rule-box .rule-list"),
    changerule1 = $(".nav .right-nav .rule"),changerule11 = $(".nav .right-nav .usercp"), changerule2 = $(".change-rule-box"), ruleBox = $(".rule-box"),
    blackBox = $(".black-box");
$(changerule1).on("click", function () {
    scrollTop = $("body").scrollTop();
    $(ruleBox).show();
    $(blackBox).show();
    $("body").css({
        'overflow': 'hidden',
        'position': 'fixed',
        'top': scrollTop * -1
    });
    $(ruleBtn[0]).addClass("active").siblings().removeClass("active");
    $(ruleList[1]).hide();
    $(ruleList[0]).show();
})
$(changerule11).on("click", function () {
    scrollTop = $("body").scrollTop();
    $(ruleBox).show();
    $(blackBox).show();
    $("body").css({
        'overflow': 'hidden',
        'position': 'fixed',
        'top': scrollTop * -1
    });
    $(ruleBtn[1]).addClass("active").siblings().removeClass("active");
    $(ruleList[0]).hide();
    $(ruleList[1]).show();
})

$(changerule2).on("click", function () {
    $(ruleBox).hide();
    $(blackBox).hide();
    $("body").css({
        'overflow': 'auto',
        'position': 'static',
        'top': 'auto'
    });
    $("body").scrollTop(scrollTop);
})
$(ruleBtn[0]).on("click", function () {
    $(this).addClass("active").siblings().removeClass("active");
    $(ruleList[1]).hide();
    $(ruleList[0]).show();
})
$(ruleBtn[1]).on("click", function () {
    $(this).addClass("active").siblings().removeClass("active");
    $(ruleList[0]).hide();
    $(ruleList[1]).show();
})
