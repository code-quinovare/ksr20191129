var app = getApp();

Page({
    data: {
        putForward: "",
        paymoney: "0",
        navTile: "线下买单",
        index: 0,
        viptype: 0,
        mode: [ {
            name: "八折",
            coupon: "8",
            mode: "1"
        } ],
        check: !0,
        rules: "<p>这是规则</p><p>这是规则</p><p>这是规则</p><p>这是规则</p>",
        isShow: !0,
        is_modal_Hidden: !0,
        storeinfo: []
    },
    onLoad: function(o) {
        var t = this;
        wx.setNavigationBarTitle({
            title: t.data.navTile
        });
        var e = app.getSiteUrl();
        t.setData({
            url: e,
            options: o
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.wxauthSetting();
        var n = o.bid;
        console.log("商家信息bid"), console.log(n), n ? app.util.request({
            url: "entry/wxapp/GetStoreInfo",
            cachetime: "30",
            data: {
                bid: n
            },
            success: function(o) {
                console.log("获取店铺数据"), console.log(o.data), t.setData({
                    storeinfo: o.data
                }), t.GetVip();
            }
        }) : wx.redirectTo({
            url: "/mzhk_sun/pages/backstage/backstage"
        });
    },
    GetVip: function() {
        var t = this, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            data: {
                openid: o
            },
            success: function(o) {
                console.log("获取vip数据"), console.log(o), t.setData({
                    viptype: o.data.viptype
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        app.func.islogin(app, this), this.GetVip();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toggleRule: function(o) {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    enterMmoney: function(o) {
        var t, e = this, n = e.data.storeinfo, a = o.detail.value;
        t = 0 <= a ? 0 < n.memdiscount ? (a * n.memdiscount / 10).toFixed(2) : (100 * a / 100).toFixed(2) : "0.00", 
        e.data.viptype <= 0 && (t = (100 * a / 100).toFixed(2)), console.log("扫码金额等"), console.log(a), 
        console.log(n.memdiscount), console.log(t), e.setData({
            paymoney: t,
            putForward: a
        });
    },
    toMember: function(o) {
        wx.navigateTo({
            url: "../../member/member"
        });
    },
    formSubmit: function(o) {
        var t = this, e = t.data.putForward, n = t.data.paymoney;
        t.data.check;
        if (e <= 0) return wx.showModal({
            title: "提示",
            content: "请输入正确的金额",
            showCancel: !1
        }), !1;
        if (n < 1) return wx.showModal({
            title: "提示",
            content: "实际支付金额必须大于1元",
            showCancel: !1
        }), !1;
        var a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                openid: a,
                price: n,
                paytype: 2,
                bid: t.options.bid
            },
            success: function(o) {
                console.log(9999), console.log(o.data), wx.requestPayment({
                    timeStamp: o.data.timeStamp,
                    nonceStr: o.data.nonceStr,
                    package: o.data.package,
                    signType: o.data.signType,
                    paySign: o.data.paySign,
                    success: function(o) {
                        console.log("支付成功"), app.util.request({
                            url: "entry/wxapp/PayOffline",
                            cachetime: "0",
                            data: {
                                bid: t.options.bid,
                                price: n
                            },
                            success: function(o) {
                                console.log("成功"), wx.showModal({
                                    title: "提示",
                                    content: "支付成功",
                                    showCancel: !1,
                                    success: function(o) {
                                        wx.redirectTo({
                                            url: "/mzhk_sun/pages/user/user"
                                        });
                                    }
                                });
                            },
                            fail: function(o) {
                                console.log("shibai"), console.log(r);
                            }
                        });
                    },
                    fail: function(o) {
                        wx.showToast({
                            title: "支付失败",
                            icon: "none",
                            duration: 2e3
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(o) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});