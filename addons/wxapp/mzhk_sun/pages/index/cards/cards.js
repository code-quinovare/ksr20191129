var app = getApp();

Page({
    data: {
        banner: [],
        navTile: "集卡",
        curIndex: 0,
        nav: [ "进行中", "往期活动" ],
        curList: [],
        oldList: [],
        page: 1,
        oldpage: 1,
        adflashimg: []
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var a = app.getSiteUrl();
        a ? e.setData({
            url: a
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a = t.data, e.setData({
                    url: a
                });
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/GetadData",
            cachetime: "30",
            data: {
                position: 4
            },
            success: function(t) {
                var a = t.data;
                e.setData({
                    adflashimg: a
                });
            }
        }), e.getptactive(), e.getptclose();
    },
    gotoadinfo: function(t) {
        var a = t.currentTarget.dataset.tid, e = t.currentTarget.dataset.id;
        app.func.gotourl(app, a, e);
    },
    onReady: function() {},
    toIndex: function(t) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    onShow: function() {},
    getUrl: function() {
        var t = app.getSiteUrl();
        this.setData({
            url: t
        });
    },
    getptactive: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/JKactive",
            cachetime: "30",
            success: function(t) {
                console.log("获取集卡商品列表"), console.log(t), 2 == t.data ? a.setData({
                    curList: []
                }) : a.setData({
                    curList: t.data
                });
            }
        });
    },
    getptclose: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/JKClose",
            cachetime: "30",
            success: function(t) {
                console.log("获取往期集卡商品列表"), console.log(t.data), 2 == t.data ? a.setData({
                    oldList: []
                }) : a.setData({
                    oldList: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this;
        if (1 == e.data.curIndex) {
            var n = e.data.oldpage, o = e.data.oldList;
            app.util.request({
                url: "entry/wxapp/JKClose",
                cachetime: "30",
                data: {
                    page: n
                },
                success: function(t) {
                    if (console.log("往期数据"), console.log(t.data), 2 == t.data) wx.showToast({
                        title: "已经没有内容了哦！！！",
                        icon: "none"
                    }); else {
                        var a = t.data;
                        o = o.concat(a), e.setData({
                            oldList: o,
                            oldpage: n + 1
                        });
                    }
                }
            });
        } else {
            var s = e.data.page, c = e.data.curList;
            app.util.request({
                url: "entry/wxapp/JKactive",
                cachetime: "30",
                data: {
                    page: s
                },
                success: function(t) {
                    if (console.log("活动数据"), console.log(t.data), 2 == t.data) wx.showToast({
                        title: "已经没有内容了哦！！！",
                        icon: "none"
                    }); else {
                        var a = t.data;
                        c = c.concat(a), e.setData({
                            curList: c,
                            page: s + 1
                        });
                    }
                }
            });
        }
    },
    onShareAppMessage: function() {},
    navTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        });
    },
    toCardsdet: function(t) {
        var a = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../cardsdet/cardsdet?gid=" + a
        });
    }
});