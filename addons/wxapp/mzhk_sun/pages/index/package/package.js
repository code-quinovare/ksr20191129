var app = getApp(), tool = require("../../../../style/utils/countDown.js"), WxParse = require("../../wxParse/wxParse.js");

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
        nav: [ "商品详情" ],
        bargainList: "1527519898765",
        is_modal_Hidden: !0,
        viptype: "0",
        hidden: !0,
        swiperIndex: 1,
        isclose: !1,
        showgw: 0,
        wglist: [],
        wg_flag: 0
    },
    map: function(t) {
        wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var e = t.latitude, a = t.longitude;
                wx.openLocation({
                    latitude: e,
                    longitude: a,
                    scale: 28
                });
            }
        });
    },
    onLoad: function(e) {
        var a = this;
        e = app.func.decodeScene(e), a.setData({
            options: e
        }), wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var n = app.getSiteUrl();
        n ? a.setData({
            url: n
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), n = t.data, a.setData({
                    url: n
                });
            }
        }), app.wxauthSetting();
        var t = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: t.fontcolor ? t.fontcolor : "",
            backgroundColor: t.color ? t.color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var i = t.showgw;
        if (1 == i) {
            var o = {
                wg_title: t.wg_title,
                wg_directions: t.wg_directions,
                wg_img: t.wg_img,
                wg_keyword: t.wg_keyword,
                wg_addicon: t.wg_addicon
            };
            a.setData({
                showgw: i,
                wglist: o
            });
        }
        var s, r = e.id;
        if (r <= 0 || !r) return wx.showModal({
            title: "提示",
            content: "参数错误，获取不到商品，点击确认跳转到首页",
            showCancel: !1,
            success: function(t) {
                wx.reLaunch({
                    url: "/mzhk_sun/pages/index/index"
                });
            }
        }), !1;
        a.setData({
            id: e.id
        }), app.util.request({
            url: "entry/wxapp/QGdetails",
            cachetime: "30",
            data: {
                id: r
            },
            success: function(t) {
                console.log("获取数据"), console.log(t.data), s = t.data.clocktime, a.countDown(s), 
                a.setData({
                    activeList: t.data
                });
                var e = t.data.content;
                WxParse.wxParse("content", "html", e, a, 10), a.getUrl();
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1,
                    success: function(t) {
                        1 == e.is_share ? wx.redirectTo({
                            url: "/mzhk_sun/pages/index/timebuy/timebuy"
                        }) : wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }
        });
    },
    hidden: function(t) {
        this.setData({
            hidden: !0
        });
    },
    showwgtable: function(t) {
        var e = t.currentTarget.dataset.flag;
        this.setData({
            wg_flag: e
        });
    },
    save: function() {
        var e = this;
        wx.saveImageToPhotosAlbum({
            filePath: e.data.prurl,
            success: function(t) {
                wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(t) {
                        t.confirm && (console.log("用户点击确定"), e.setData({
                            hidden: !0
                        }));
                    }
                });
            },
            fail: function(t) {
                console.log("失败"), wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(t) {
                                console.log("openSetting success", t.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    shareCanvas: function() {
        var t = this, e = t.data.activeList, a = [];
        a.gid = e.gid, a.bname = e.gname, a.url = t.data.url, a.logo = e.lb_imgs[0], a.shopprice = e.shopprice, 
        a.qgprice = e.qgprice;
        var n = wx.getStorageSync("users");
        a.scene = "d_user_id=" + n.id + "&id=" + t.data.id, app.creatPoster("mzhk_sun/pages/index/package/package", 430, a, 4, "shareImg");
    },
    toMember: function(t) {
        wx.navigateTo({
            url: "../../member/member"
        });
    },
    max: function(t) {
        var e = t.currentTarget.dataset.address, a = Number(t.currentTarget.dataset.longitude), n = Number(t.currentTarget.dataset.latitude);
        if (0 == a && 0 == n) return wx.showToast({
            title: "该地址有问题，可能无法显示~",
            icon: "none",
            duration: 1e3
        }), !1;
        wx.openLocation({
            name: e,
            latitude: n,
            longitude: a,
            scale: 18,
            address: e
        });
    },
    countDown: function(t) {
        var e = this, a = t, n = [], i = setInterval(function() {
            var t = tool.countDown(e, a);
            t ? (n[0] = t[0], n[1] = t[1], n[2] = t[3], n[3] = t[4]) : (e.setData({
                isclose: !0
            }), clearInterval(i), n[0] = "00", n[1] = "00", n[2] = "00", clcok[3] = "00"), e.setData({
                clock: n
            });
        }, 1e3);
    },
    onReady: function() {},
    dialogue: function(t) {
        var e = t.currentTarget.dataset.phone;
        console.log(e), wx.makePhoneCall({
            phoneNumber: e
        });
    },
    onShow: function() {
        var e = this;
        app.func.islogin(app, e);
        var t = e.data.options;
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id), app.util.request({
            url: "entry/wxapp/UpdateGoods",
            data: {
                id: e.data.id,
                typeid: 1
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        });
        var a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            cachetime: "0",
            data: {
                openid: a
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                console.log("vip"), console.log(t.data), e.setData({
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
    onUnload: function() {
        clearTimeout(app.globalData.timer_slideupshoworder);
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = this, e = t.data.url, a = t.data.activeList;
        app.util.request({
            url: "entry/wxapp/UpdateGoods",
            data: {
                id: t.data.id,
                typeid: 2
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        });
        var n = (t.data.activeList.biaoti ? t.data.activeList.biaoti + "：" : "") + t.data.activeList.gname, i = wx.getStorageSync("users");
        return {
            title: n,
            path: "/mzhk_sun/pages/index/package/package?id=" + t.data.id + "&is_share=1&d_user_id=" + i.id,
            imageUrl: e + a.lb_imgs[0]
        };
    },
    index: function(t) {
        wx.reLaunch({
            url: "../index"
        });
    },
    navTap: function(t) {
        var e = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: e
        });
    },
    toCforder: function(t) {
        var e = t.currentTarget.dataset.id, a = t.currentTarget.dataset.price, n = wx.getStorageSync("openid"), i = this.data.activeList, o = this.data.viptype;
        1 != i.is_vip && 0 < o && (a = 0 < i.vipprice ? i.vipprice : a), app.util.request({
            url: "entry/wxapp/CheckGoodsStatus",
            cachetime: "10",
            data: {
                gid: e,
                openid: n,
                ltype: 0
            },
            success: function(t) {
                wx.navigateTo({
                    url: "../../member/order/order?id=" + e + "&price=" + a
                });
            },
            fail: function(t) {
                return wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1
                }), !1;
            }
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    swiperChange: function(t) {
        this.setData({
            swiperIndex: t.detail.current + 1
        });
    }
});