var app = getApp();

Page({
    data: {
        navTile: "开通会员",
        curIndex: 0,
        nav: [ "开通会员", "激活码直接激活" ],
        cards: [],
        jhm: "",
        is_modal_Hidden: !0,
        isclick: !1,
        member: [],
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        phoneNum: "",
        hk_userrules: "",
        choose: [ {
            name: "微信支付",
            value: "1",
            icon: "/style/images/wx.png",
            checked: "checked"
        } ],
        payStatus: 0,
        payType: "1",
        totalprice: 0,
        id: 0
    },
    onLoad: function(t) {
        var e = this;
        e.setData({
            options: t
        }), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var a = app.getSiteUrl();
        e.setData({
            url: a
        }), app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                console.log(t.data);
                var a = e.data.choose;
                if (1 == t.data.isopen_recharge) {
                    a = a.concat([ {
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    } ]);
                }
                e.setData({
                    choose: a,
                    hk_userrules: t.data.hk_userrules
                }), wx.setNavigationBarColor({
                    frontColor: t.data.fontcolor ? t.data.fontcolor : "",
                    backgroundColor: t.data.color ? t.data.color : "",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetActiveLog",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), 2 == t.data ? e.setData({
                    member: []
                }) : e.setData({
                    member: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShareAppMessage: function(t) {
        return {
            title: "开通会员",
            path: "/mzhk_sun/pages/member/member?d_user_id=" + wx.getStorageSync("users").id
        };
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    onShow: function() {
        var a = this;
        app.func.islogin(app, a);
        var t = a.data.options;
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id);
        var e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/VIP",
            data: {
                openid: e
            },
            success: function(t) {
                a.setData({
                    cards: t.data.vip,
                    phoneNum: t.data.telphone
                });
            }
        });
    },
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
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    navTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        });
    },
    bindInput: function(t) {
        var a = parseInt(t.currentTarget.dataset.type);
        1 == a ? this.setData({
            jhm: t.detail.value
        }) : 2 == a && this.setData({
            phoneNum: t.detail.value
        });
    },
    submitJH: function(t) {
        var a = this.data.jhm, e = wx.getStorageSync("openid");
        if ("" == a || null == a) return wx.showModal({
            content: "请输入激活码！！！",
            showCancel: !0,
            success: function(t) {}
        }), !1;
        var n = this.data.phoneNum;
        if (!n || "" == n) return wx.showModal({
            title: "提示信息",
            content: "请输入正确的手机号码",
            success: function(t) {}
        }), !1;
        app.util.request({
            url: "entry/wxapp/MUMVIP",
            data: {
                jhm: a,
                openid: e,
                phone: n
            },
            success: function(t) {
                console.log(t), wx.showModal({
                    content: "恭喜你，激活成功啦~",
                    showCancel: !0,
                    success: function(t) {
                        setTimeout(function() {
                            wx.navigateBack();
                        }, 500);
                    }
                });
            }
        });
    },
    radioChange: function(t) {
        var a = t.detail.value;
        console.log(a), this.setData({
            payType: a
        });
    },
    showPay: function(t) {
        var a = t.currentTarget.dataset.statu, e = 0, n = 0;
        1 == a && (e = t.currentTarget.dataset.price, n = t.currentTarget.dataset.id), this.setData({
            payStatus: a,
            totalprice: e,
            id: n
        });
    },
    buyVIP: function(t) {
        var a = this, e = a.data.id, n = a.data.totalprice, o = wx.getStorageSync("openid"), r = a.data.payType, i = a.data.phoneNum;
        if (!i || "" == i) return wx.showModal({
            title: "提示信息",
            content: "请输入正确的手机号码",
            success: function(t) {}
        }), !1;
        if (a.data.isclick) return console.log("重复点击"), !1;
        a.setData({
            isclick: !0
        });
        var s = {
            payType: r,
            resulttype: 2,
            orderarr: "",
            SendMessagePay: "",
            PayOrder: "",
            SendSms: "",
            PayOrderurl: "",
            PayredirectTourl: ""
        };
        s.orderarr = {
            id: e,
            price: n,
            openid: o,
            paytypes: 1
        }, s.PayOrder = {
            id: e,
            price: n,
            openid: o,
            phone: i,
            payType: r
        }, app.func.orderarr(app, a, s);
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});