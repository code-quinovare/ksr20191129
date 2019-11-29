var app = getApp(), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        navTile: "店铺详情",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        welfareList: [],
        phoneNumber: "",
        goods: [],
        hidden: !0,
        viptype: [],
        goodstype: [ "", "普", "砍", "拼", "集", "抢", "免" ],
        goodssaletype: [ "", "已售", "已砍", "已拼", "已集", "已抢", "已有" ],
        goodstype_btn: [ "去购买", "去购买", "去砍价", "去拼团", "去集卡", "去抢购", "抢免单" ],
        isloadWxParse: !1
    },
    onLoad: function(e) {
        var t = this, a = (e = app.func.decodeScene(e)).id;
        wx.setNavigationBarTitle({
            title: t.data.navTile
        }), t.setData({
            id: a
        });
        var n = app.getSiteUrl();
        n ? t.setData({
            url: n
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), n = e.data, t.setData({
                    url: n
                });
            }
        }), app.wxauthSetting(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor ? wx.getStorageSync("System").fontcolor : "",
            backgroundColor: wx.getStorageSync("System").color ? wx.getStorageSync("System").color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    toIndex: function(e) {
        wx.redirectTo({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    onShow: function() {
        var o = this;
        app.func.islogin(app, o);
        var e = o.data.id, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/shopXq",
            cachetime: "0",
            data: {
                id: e,
                openid: t
            },
            success: function(e) {
                console.log(e.data);
                var t = e.data.phone, a = e.data;
                o.setData({
                    welfareList: a,
                    phoneNumber: t,
                    goods: e.data.goods
                }), o.getUrl();
                var n = a.content;
                o.data.isloadWxParse || (o.setData({
                    isloadWxParse: !0
                }), WxParse.wxParse("content", "html", n, o, 10));
            }
        });
    },
    getUrl: function() {
        var t = this, a = app.getSiteUrl();
        a ? t.setData({
            url: a
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), a = e.data, t.setData({
                    url: a
                });
            }
        });
    },
    dialogue: function(e) {
        var t = this.data.phoneNumber;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    hidden: function(e) {
        this.setData({
            hidden: !0
        });
    },
    toGetGoods: function(e) {
        var t = e.currentTarget.dataset.id, a = (e.currentTarget.dataset.is_vip, wx.getStorageSync("openid"), 
        e.currentTarget.dataset.lid);
        1 == a ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/goods/goods?gid=" + t
        }) : 2 == a ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/bardet/bardet?id=" + t
        }) : 3 == a ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/groupdet/groupdet?id=" + t
        }) : 4 == a ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/cardsdet/cardsdet?gid=" + t
        }) : 5 == a ? wx.navigateTo({
            url: "/mzhk_sun/pages/index/package/package?id=" + t
        }) : 6 == a && wx.navigateTo({
            url: "/mzhk_sun/pages/index/freedet/freedet?id=" + t
        });
    },
    lingqu: function(e) {
        var t = this, a = e.currentTarget.dataset.id, n = e.currentTarget.dataset.isvip, o = (t.data.viptype, 
        e.currentTarget.dataset.f_index), r = wx.getStorageSync("openid"), i = t.data.welfareList;
        if (1 == n) return wx.navigateTo({
            url: "/mzhk_sun/pages/index/welfare/welfare?id=" + a
        }), !1;
        app.util.request({
            url: "entry/wxapp/Counpadd",
            cachetime: "30",
            data: {
                id: a,
                openid: r
            },
            success: function(e) {
                i.coupons[o].is_has = !0, console.log(i), t.setData({
                    welfareList: i
                });
            }
        });
    },
    max: function(e) {
        var t = e.currentTarget.dataset.address, a = Number(e.currentTarget.dataset.longitude), n = Number(e.currentTarget.dataset.latitude);
        if (0 == a && 0 == n) return wx.showToast({
            title: "该地址有问题，可能无法显示~",
            icon: "none",
            duration: 1e3
        }), !1;
        wx.openLocation({
            name: t,
            latitude: n,
            longitude: a,
            scale: 18,
            address: t
        });
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var e = this.data.url, t = this.data.welfareList;
        return {
            title: t.bname,
            path: "mzhk_sun/pages/index/shop/shop?id=" + this.data.id,
            imageUrl: e + t.logo[0]
        };
    },
    shareCanvas: function() {
        var e = this.data.welfareList, t = [];
        t.bname = e.bname, t.url = this.data.url, t.logo = e.logo[0], t.starttime = e.starttime, 
        t.endtime = e.endtime, t.scene = "id=" + this.data.id, app.creatPoster("mzhk_sun/pages/index/shop/shop", 430, t, 1, "shareImg");
    },
    drawText: function(e, t, a, n, o) {
        var r = e.split(""), i = "", s = [];
        o.font = "20px Arial", o.fillStyle = "black", o.textBaseline = "middle";
        for (var d = 0; d < r.length; d++) o.measureText(i).width < n || (s.push(i), i = ""), 
        i += r[d];
        s.push(i);
        for (var u = 0; u < s.length; u++) o.fillText(s[u], t, a + 30 * (u + 1));
    },
    save: function() {
        var t = this;
        wx.saveImageToPhotosAlbum({
            filePath: t.data.prurl,
            success: function(e) {
                wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(e) {
                        e.confirm && (console.log("用户点击确定"), t.setData({
                            hidden: !0
                        }));
                    }
                });
            }
        });
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});