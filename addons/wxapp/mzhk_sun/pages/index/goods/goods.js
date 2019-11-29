var app = getApp(), tool = require("../../../../style/utils/countDown.js");

Page({
    data: {
        status: !0,
        navTile: "套餐详情",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        packList: [],
        guess: [],
        curIndex: 0,
        nav: [ "商品详情", "" ],
        bargainList: "1527519898765",
        is_modal_Hidden: !0,
        viptype: "0",
        showgw: 0,
        wglist: [],
        wg_flag: 0
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = app.getSiteUrl();
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
        }), app.wxauthSetting();
        var i = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: i.fontcolor ? i.fontcolor : "",
            backgroundColor: i.color ? i.color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var o = i.showgw;
        if (1 == o) {
            var n = {
                wg_title: i.wg_title,
                wg_directions: i.wg_directions,
                wg_img: i.wg_img,
                wg_keyword: i.wg_keyword,
                wg_addicon: i.wg_addicon
            };
            a.setData({
                showgw: o,
                wglist: n
            });
        }
        a.setData({
            id: t.gid
        }), app.util.request({
            url: "entry/wxapp/QGdetails",
            cachetime: "30",
            data: {
                id: a.data.id
            },
            success: function(t) {
                console.log("获取数据"), console.log(t.data), a.setData({
                    activeList: t.data
                }), a.getUrl();
            }
        });
    },
    showwgtable: function(t) {
        var a = t.currentTarget.dataset.flag;
        this.setData({
            wg_flag: a
        });
    },
    toMember: function(t) {
        wx.navigateTo({
            url: "../../member/member"
        });
    },
    dialogue: function(t) {
        var a = t.currentTarget.dataset.phone;
        console.log(a), wx.makePhoneCall({
            phoneNumber: a
        });
    },
    max: function(t) {
        var a = t.currentTarget.dataset.address, e = Number(t.currentTarget.dataset.longitude), i = Number(t.currentTarget.dataset.latitude);
        if (0 == e && 0 == i) return wx.showToast({
            title: "该地址有问题，可能无法显示~",
            icon: "none",
            duration: 1e3
        }), !1;
        wx.openLocation({
            name: a,
            latitude: i,
            longitude: e,
            scale: 18,
            address: a
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        a.islogin(), app.util.request({
            url: "entry/wxapp/UpdateGoods",
            data: {
                id: a.data.id,
                typeid: 1
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        });
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            cachetime: "30",
            data: {
                openid: t
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                console.log("vip"), console.log(t.data), a.setData({
                    viptype: t.data.viptype
                });
            }
        });
    },
    islogin: function() {
        var a = this;
        wx.getStorageSync("have_wxauth") || wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] ? (wx.setStorageSync("have_wxauth", 1), wx.getUserInfo({
                    success: function(t) {
                        a.setData({
                            is_modal_Hidden: !0
                        });
                    }
                })) : a.setData({
                    is_modal_Hidden: !1
                });
            }
        });
    },
    getUrl: function() {
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
        });
    },
    onHide: function() {},
    onUnload: function() {
        clearTimeout(app.globalData.timer_slideupshoworder);
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = this, a = t.data.url, e = t.data.activeList;
        return app.util.request({
            url: "entry/wxapp/UpdateGoods",
            data: {
                id: t.data.id,
                typeid: 2
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        }), {
            title: (t.data.activeList.biaoti ? t.data.activeList.biaoti + "：" : "") + t.data.activeList.gname,
            path: "/mzhk_sun/pages/index/goods/goods?gid=" + t.data.id + "&is_share=1",
            imageUrl: a + e.lb_imgs[0]
        };
    },
    index: function(t) {
        wx.navigateTo({
            url: "../index"
        });
    },
    navTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        });
    },
    toCforder: function(t) {
        var a = t.currentTarget.dataset.id, e = t.currentTarget.dataset.price, i = this.data.activeList, o = this.data.viptype;
        1 != i.is_vip && 0 < o && (e = 0 < i.vipprice ? i.vipprice : e), wx.navigateTo({
            url: "../../member/order/order?id=" + a + "&price=" + e + "&typeid=1"
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});