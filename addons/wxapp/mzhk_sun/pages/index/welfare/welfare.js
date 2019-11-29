var app = getApp();

Page({
    data: {
        navTile: "福利详情",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        welfareList: [],
        url: [],
        viptype: "0",
        is_modal_Hidden: !0
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        t.id;
        e.setData({
            id: t.id
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
        }), app.wxauthSetting();
    },
    onReady: function() {},
    toIndex: function(t) {
        wx.redirectTo({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    onShow: function() {
        var e = this;
        app.func.islogin(app, e), e.getUrl(), app.util.request({
            url: "entry/wxapp/welfare",
            method: "GET",
            data: {
                id: e.data.id
            },
            success: function(t) {
                console.log(122), console.log(t), e.setData({
                    welfareList: t.data
                });
            }
        });
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/isLingqu",
            cachetime: "30",
            data: {
                id: e.data.id,
                openid: t
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                console.log(t), 0 < t.data.id ? e.setData({
                    receive: 1
                }) : e.setData({
                    receive: 0
                });
            }
        }), app.util.request({
            url: "entry/wxapp/ISVIP",
            cachetime: "0",
            data: {
                openid: t
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                e.setData({
                    viptype: t.data.viptype
                });
            }
        });
    },
    getUrl: function() {
        var e = this, a = app.getSiteUrl();
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
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    callphone: function(t) {
        var e = t.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: e
        });
    },
    toMember: function(t) {
        wx.redirectTo({
            url: "../../member/member"
        });
    },
    receive: function(t) {
        var e = this, a = t.currentTarget.dataset.id, n = wx.getStorageSync("openid"), i = e.data.receive;
        0 == i ? app.util.request({
            url: "entry/wxapp/Counpadd",
            cachetime: "30",
            data: {
                openid: n,
                id: a
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                e.setData({
                    receive: 1
                }), 2 == t.data.status ? wx.showToast({
                    title: "您已领取过啦",
                    icon: "none",
                    duration: 1e3
                }) : wx.showToast({
                    title: "领取成功",
                    icon: "success",
                    duration: 1e3
                });
            }
        }) : wx.showToast({
            title: "您已领取过啦~",
            icon: "none",
            duration: 1e3
        });
    },
    showmap: function(t) {
        var e = t.currentTarget.dataset.address, a = Number(t.currentTarget.dataset.longitude), n = Number(t.currentTarget.dataset.latitude);
        0 == a && 0 == n && wx.showToast({
            title: "该地址可能无法在地图上显示~",
            icon: "none",
            duration: 1e3
        }), wx.openLocation({
            name: e,
            latitude: n,
            longitude: a,
            scale: 18,
            address: e
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});