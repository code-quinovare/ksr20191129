var app = getApp();

Page({
    data: {
        isShow: !0,
        distribution_set: [],
        promoter_data: [],
        payStyle: [],
        isclickpay: !1,
        payStyle_data: [ {
            id: 1,
            name: "wx",
            icon: "../../../../style/images/wx.png",
            title: "微信"
        }, {
            id: 2,
            name: "zfb",
            icon: "../../../../style/images/zfblogo.png",
            title: "支付宝"
        }, {
            id: 3,
            name: "yhk",
            icon: "../../../../style/images/yhlogo.png",
            title: "银行卡"
        }, {
            id: 4,
            name: "yue",
            icon: "../../../../style/images/yuelogo.png",
            title: "余额"
        } ]
    },
    onLoad: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(a) {
                wx.setStorageSync("url", a.data);
                var t = a.data;
                e.setData({
                    url: t
                });
            }
        });
        var t = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: t.fontcolor ? t.fontcolor : "#000000",
            backgroundColor: t.color ? t.color : "#ffffff",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {
        var l = this, a = wx.getStorageSync("openid"), t = wx.getStorageSync("users");
        app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 1
            },
            showLoading: !1,
            success: function(a) {
                var t = a.data;
                if (2 != t) {
                    var e = t.withdrawtype.split(","), i = l.data.payStyle_data, o = [], n = 0;
                    for (var s in i) for (var c in e) i[s].id == e[c] && (o[n] = i[s], n++);
                    o.length <= 0 && (o[0] = i[0]), l.setData({
                        distribution_set: t,
                        payStyle: o
                    });
                }
            }
        }), app.util.request({
            url: "entry/wxapp/IsPromoter",
            data: {
                openid: a,
                uid: t.id,
                m: app.globalData.Plugin_distribution
            },
            showLoading: !1,
            success: function(a) {
                var t = a.data;
                l.setData({
                    promoter_data: t
                });
            }
        });
    },
    onShow: function() {},
    onReachBottom: function() {},
    checkboxChange: function(a) {
        this.setData({
            check: !this.data.check
        });
    },
    toggleRule: function(a) {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    choosePay: function(a) {
        var t = a.currentTarget.dataset.index, e = a.currentTarget.dataset.name;
        this.setData({
            curIndex: t,
            payName: e
        });
    },
    formSubmit: function(a) {
        var t, e, i, o = this, n = !0, s = "", c = o.data.check, l = o.data.payName, u = a.detail.value.putForward, r = a.detail.formId;
        if (o.data.isclickpay) return console.log("多次点击pay"), wx.showToast({
            title: "请稍后...",
            icon: "none",
            duration: 2e3
        }), !1;
        if (o.setData({
            isclickpay: !0
        }), c ? u ? "wx" == l ? (t = a.detail.value.wx_uname, e = "", i = a.detail.value.wx_phone, 
        "" == t ? s = "请填写您的名字" : "" == i ? s = "请输入正确的手机号码" : n = !1) : "zfb" == l ? (t = a.detail.value.zfb_uname, 
        e = a.detail.value.zfb_account, i = a.detail.value.zfb_phone, "" == t ? s = "请填写支付宝账号认证的名字" : "" == e ? s = "请输入支付宝账号" : "" == i ? s = "请输入正确的手机号码" : n = !1) : "yhk" == l ? (t = a.detail.value.yhk_uname, 
        e = a.detail.value.yhk_account, i = a.detail.value.yhk_phone, "" == t ? s = "请填写持卡人名字" : "" == e ? s = "请输入银行卡号" : "" == i ? s = "请输入正确的手机号码" : n = !1) : "yue" == l ? (i = e = t = "", 
        n = !1) : s = "请选择提现方式" : s = "请输入提现金额" : s = "请阅读提现须知", 1 == n) wx.showToast({
            title: s,
            icon: "none"
        }), o.setData({
            isclickpay: !1
        }); else {
            var d = wx.getStorageSync("users"), p = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/SaveWithDraw",
                cachetime: "0",
                data: {
                    uid: d.id,
                    openid: p,
                    wd_type: {
                        wx: 1,
                        zfb: 2,
                        yhk: 3,
                        yue: 4
                    }[l],
                    money: u,
                    account: e,
                    uname: t,
                    phone: i,
                    formid: r,
                    m: app.globalData.Plugin_distribution
                },
                success: function(a) {
                    wx.showModal({
                        title: "提示",
                        content: "提现提交成功",
                        showCancel: !1,
                        success: function(a) {
                            wx.navigateBack({
                                delta: 1
                            });
                        }
                    });
                },
                fail: function(a) {
                    o.setData({
                        isclickpay: !1
                    }), wx.showModal({
                        title: "提示",
                        content: a.data.message,
                        showCancel: !1,
                        success: function(a) {}
                    });
                }
            });
        }
    }
});