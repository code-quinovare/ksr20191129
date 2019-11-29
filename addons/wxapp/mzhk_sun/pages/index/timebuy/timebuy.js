var app = getApp();

Page({
    data: {
        banner: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15227233856.png",
        navTile: "抢购",
        curIndex: 0,
        nav: [ "限时抢购", "往期活动" ],
        curList: [],
        url: [],
        oldList: [],
        page: 1,
        oldpage: 1,
        adflashimg: []
    },
    onLoad: function(a) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var t = app.getSiteUrl();
        t ? e.setData({
            url: t
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(a) {
                wx.setStorageSync("url", a.data), t = a.data, e.setData({
                    url: t
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
            url: "entry/wxapp/QGactive",
            success: function(a) {
                console.log(a.data), 2 == a.data ? e.setData({
                    curList: []
                }) : e.setData({
                    curList: a.data
                });
            }
        }), e.getptclose(), app.util.request({
            url: "entry/wxapp/GetadData",
            cachetime: "30",
            data: {
                position: 5
            },
            success: function(a) {
                console.log("11111"), console.log(a.data);
                var t = a.data;
                e.setData({
                    adflashimg: t
                });
            }
        });
    },
    toIndex: function(a) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    gotoadinfo: function(a) {
        var t = a.currentTarget.dataset.tid, e = a.currentTarget.dataset.id;
        app.func.gotourl(app, t, e);
    },
    onReady: function() {},
    onShow: function() {},
    getUrl: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "30",
            success: function(a) {
                wx.setStorageSync("url", a.data), t.setData({
                    url: a.data
                });
            }
        });
    },
    getptclose: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/QGClose",
            cachetime: "30",
            success: function(a) {
                2 == a.data ? t.setData({
                    oldList: []
                }) : t.setData({
                    oldList: a.data
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
                url: "entry/wxapp/QGClose",
                cachetime: "30",
                data: {
                    page: n
                },
                success: function(a) {
                    if (console.log("往期数据"), console.log(a.data), 2 == a.data) wx.showToast({
                        title: "已经没有内容了哦！！！",
                        icon: "none"
                    }); else {
                        var t = a.data;
                        o = o.concat(t), e.setData({
                            oldList: o,
                            oldpage: n + 1
                        });
                    }
                }
            });
        } else {
            var s = e.data.page, c = e.data.curList;
            app.util.request({
                url: "entry/wxapp/QGactive",
                cachetime: "30",
                data: {
                    page: s
                },
                success: function(a) {
                    if (console.log("活动数据"), console.log(a.data), 2 == a.data) wx.showToast({
                        title: "已经没有内容了哦！！！",
                        icon: "none"
                    }); else {
                        var t = a.data;
                        c = c.concat(t), e.setData({
                            curList: c,
                            page: s + 1
                        });
                    }
                }
            });
        }
    },
    onShareAppMessage: function() {},
    navTap: function(a) {
        var t = parseInt(a.currentTarget.dataset.index);
        this.setData({
            curIndex: t
        });
    },
    toPackage: function(a) {
        var t = a.currentTarget.dataset.id;
        console.log(t), wx.navigateTo({
            url: "../package/package?id=" + t
        });
    }
});