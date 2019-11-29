var app = getApp(), eatvisit = require("../../resource/js/eatvisit.js");

Page({
    data: {
        curIndex: 0,
        nav: [ "火热进行中", "已抢完" ],
        page: [ 1, 1 ],
        is_modal_Hidden: !0,
        whichone: 1,
        open_eatvisit: [],
        goodslist: [],
        eattabname: []
    },
    onLoad: function(t) {
        var s = this;
        t = app.func.decodeScene(t), s.setData({
            options: t
        });
        var a = eatvisit.eattabname(app, s);
        s.setData({
            eattabname: a
        }), app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 2
            },
            showLoading: !1,
            success: function(t) {
                var a = t.data;
                2 != a ? s.setData({
                    eatvisit_set: a
                }) : wx.showModal({
                    title: "提示消息",
                    content: "吃探功能未开启",
                    showCancel: !1,
                    success: function(t) {
                        wx.redirectTo({
                            url: "/mzhk_sun/pages/inedx/index"
                        });
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                s.setData({
                    pt_name: t.data.hk_tubiao ? t.data.hk_tubiao : ""
                }), wx.setNavigationBarColor({
                    frontColor: t.data.fontcolor ? t.data.fontcolor : "#000000",
                    backgroundColor: t.data.color ? t.data.color : "#ffffff",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                });
            }
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    onReady: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/GetGoods",
            data: {
                m: app.globalData.Plugin_eatvisit
            },
            showLoading: !1,
            success: function(t) {
                if (console.log(t.data), 2 != t.data) {
                    var a = t.data.url, s = t.data.goodslist, o = t.data.status;
                    e.setData({
                        goodsstatus: o,
                        goodsurl: a,
                        goodslist: s
                    });
                } else e.setData({
                    goodslist: []
                });
            }
        });
    },
    onShow: function() {
        app.func.islogin(app, this);
        var t = this.data.options;
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this, i = e.data.page, n = e.data.curIndex, d = i[n];
        app.util.request({
            url: "entry/wxapp/GetGoods",
            data: {
                goodstype: index,
                page: d,
                m: app.globalData.Plugin_eatvisit
            },
            showLoading: !1,
            success: function(t) {
                if (console.log(t.data), 2 != t.data) {
                    var a = t.data.url, s = t.data.goodslist, o = t.data.status;
                    i[n] = d + 1, e.setData({
                        goodsstatus: o,
                        goodsurl: a,
                        goodslist: s,
                        pages: i
                    });
                } else e.setData({
                    goodslist: []
                });
            }
        });
    },
    onShareAppMessage: function() {
        return {
            path: "/mzhk_sun/plugin/eatvisit/life/life?d_user_id=" + wx.getStorageSync("users").id
        };
    },
    navTap: function(t) {
        var e = this, a = parseInt(t.currentTarget.dataset.index);
        app.util.request({
            url: "entry/wxapp/GetGoods",
            data: {
                goodstype: a,
                m: app.globalData.Plugin_eatvisit
            },
            showLoading: !1,
            success: function(t) {
                if (console.log(t.data), 2 != t.data) {
                    var a = t.data.url, s = t.data.goodslist, o = t.data.status;
                    e.setData({
                        goodsstatus: o,
                        goodsurl: a,
                        goodslist: s,
                        pages: [ 1, 1 ]
                    });
                } else e.setData({
                    goodslist: [],
                    pages: [ 1, 1 ]
                });
            }
        }), this.setData({
            curIndex: a
        });
    },
    toLifeDet: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/mzhk_sun/plugin/eatvisit/lifedet/lifedet?id=" + a
        });
    }
});