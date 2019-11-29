var tool = require("../../../../style/utils/countDown.js"), app = getApp(), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        status: !0,
        navTile: "套餐详情",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        activeList: {},
        is_modal_Hidden: !0,
        winning: [],
        viptype: "0",
        showgw: 0,
        wglist: [],
        wg_flag: 0,
        hidden: !0,
        isloadWxParse: !1
    },
    onLoad: function(t) {
        var e = this;
        t = app.func.decodeScene(t), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var a = t.id;
        (a <= 0 || !a) && wx.showModal({
            title: "提示",
            content: "参数错误，获取不到商品，点击确认跳转到首页",
            showCancel: !1,
            success: function(t) {
                wx.reLaunch({
                    url: "/mzhk_sun/pages/index/index"
                });
            }
        }), e.setData({
            id: t.id
        });
        var o = app.getSiteUrl();
        o ? (e.setData({
            url: o
        }), app.editTabBar(o)) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), o = t.data, app.editTabBar(o), e.setData({
                    url: o
                });
            }
        }), app.wxauthSetting();
        var n = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: n.fontcolor ? n.fontcolor : "",
            backgroundColor: n.color ? n.color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var i = n.showgw;
        if (1 == i) {
            var s = {
                wg_title: n.wg_title,
                wg_directions: n.wg_directions,
                wg_img: n.wg_img,
                wg_keyword: n.wg_keyword,
                wg_addicon: n.wg_addicon
            };
            e.setData({
                showgw: i,
                wglist: s
            });
        }
    },
    showwgtable: function(t) {
        var e = t.currentTarget.dataset.flag;
        this.setData({
            wg_flag: e
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.func.islogin(app, a);
        var t = a.data.id;
        app.util.request({
            url: "entry/wxapp/UpdateGoods",
            data: {
                id: t,
                typeid: 1
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        });
        var e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            cachetime: "0",
            data: {
                openid: e
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                console.log("vip"), console.log(t.data), a.setData({
                    viptype: t.data.viptype
                });
            }
        }), app.util.request({
            url: "entry/wxapp/QGdetails",
            data: {
                id: t,
                showtype: 6,
                openid: e
            },
            success: function(t) {
                console.log("获取数据"), console.log(t.data), a.setData({
                    activeList: t.data
                });
                var e = t.data.content;
                a.data.isloadWxParse || (a.setData({
                    isloadWxParse: !0
                }), WxParse.wxParse("content", "html", e, a, 10));
            }
        });
    },
    toMember: function(t) {
        wx.navigateTo({
            url: "../../member/member"
        });
    },
    shareCanvas: function() {
        var t = this, e = t.data.activeList, a = [];
        a.bname = e.gname, a.url = t.data.url, a.logo = e.lb_imgs[0], a.astime = e.astime, 
        a.antime = e.antime, a.scene = "id=" + t.data.id, app.creatPoster("mzhk_sun/pages/index/freedet/freedet", 430, a, 7, "shareImg");
    },
    hidden: function(t) {
        this.setData({
            hidden: !0
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
    onHide: function() {},
    onUnload: function() {
        clearTimeout(app.globalData.timer_slideupshoworder);
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        console.log("分享");
        var t = this;
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
            path: "/mzhk_sun/pages/index/freedet/freedet?id=" + t.data.id + "&is_share=1"
        };
    },
    toShop: function(t) {
        var e = t.currentTarget.dataset.bid;
        wx.navigateTo({
            url: "../shop/shop?id=" + e
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "../index"
        });
    },
    toApply: function(t) {
        var e = t.currentTarget.dataset.gid, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/CheckGoodsStatus",
            cachetime: "0",
            data: {
                gid: e,
                ltype: 6,
                openid: a
            },
            success: function(t) {
                console.log(t.data), wx.navigateTo({
                    url: "../../member/hyorder/hyorder?id=" + e + "&price=0"
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
    }
});