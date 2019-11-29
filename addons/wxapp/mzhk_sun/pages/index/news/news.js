var app = getApp();

Page({
    data: {
        navTile: "",
        news: [],
        page: 1
    },
    onLoad: function(t) {
        var a = this, e = app.getSiteUrl();
        e ? a.setData({
            url: e
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), e = t.data, a.setData({
                    url: e
                });
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor ? wx.getStorageSync("System").fontcolor : "",
            backgroundColor: wx.getStorageSync("System").color ? wx.getStorageSync("System").color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/GetNews",
            cachetime: "30",
            success: function(t) {
                console.log("专题数据"), console.log(t.data), 2 == t.data ? a.setData({
                    news: []
                }) : a.setData({
                    news: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Tbbanner",
            cachetime: "30",
            success: function(t) {
                if (2 != t.data) {
                    var a = t.data, e = a[4].bname ? a[4].bname : "专题";
                    wx.setNavigationBarTitle({
                        title: e
                    });
                } else wx.setNavigationBarTitle({
                    title: "专题"
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this, n = e.data.page, o = e.data.news;
        app.util.request({
            url: "entry/wxapp/GetNews",
            data: {
                page: n
            },
            success: function(t) {
                if (2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var a = t.data;
                    o = o.concat(a), e.setData({
                        news: o,
                        page: n + 1
                    });
                }
            }
        });
    },
    onShareAppMessage: function() {},
    toArticle: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../article/article?id=" + a
        });
    }
});