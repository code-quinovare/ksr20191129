var app = getApp();

Page({
    data: {
        banner: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15227233856.png",
        navTile: "商品列表",
        curIndex: 0,
        nav: [ "限时抢购", "往期活动" ],
        curList: [],
        url: [],
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
            url: "entry/wxapp/QGactive",
            data: {
                showtype: 1
            },
            success: function(t) {
                console.log(t.data), 2 == t.data ? e.setData({
                    curList: []
                }) : e.setData({
                    curList: t.data
                });
            }
        }), e.getptclose(), app.util.request({
            url: "entry/wxapp/GetadData",
            cachetime: "30",
            data: {
                position: 5
            },
            success: function(t) {
                console.log("11111"), console.log(t.data);
                var a = t.data;
                e.setData({
                    adflashimg: a
                });
            }
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    gotoadinfo: function(t) {
        var a = t.currentTarget.dataset.tid, e = t.currentTarget.dataset.id;
        app.func.gotourl(app, a, e);
    },
    onReady: function() {},
    onShow: function() {},
    getUrl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    getptclose: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/QGClose",
            cachetime: "30",
            success: function(t) {
                2 == t.data ? a.setData({
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
            var o = e.data.oldpage, n = e.data.oldList;
            app.util.request({
                url: "entry/wxapp/QGClose",
                cachetime: "30",
                data: {
                    page: o,
                    showtype: 1
                },
                success: function(t) {
                    if (console.log("往期数据"), console.log(t.data), 2 == t.data) wx.showToast({
                        title: "已经没有内容了哦！！！",
                        icon: "none"
                    }); else {
                        var a = t.data;
                        n = n.concat(a), e.setData({
                            oldList: n,
                            oldpage: o + 1
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
                    page: s,
                    showtype: 1
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
    toPackage: function(t) {
        var a = t.currentTarget.dataset.id;
        console.log(a), wx.navigateTo({
            url: "../goods/goods?gid=" + a
        });
    }
});