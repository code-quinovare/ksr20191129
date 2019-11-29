function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var app = getApp();

Page({
    data: {
        hasAddress: !1,
        address: [],
        navTile: "提交订单",
        goods: [],
        sincetype: "0",
        cardprice: "0",
        curprice: "0",
        showModalStatus: !1,
        cards: [],
        showRemark: 0,
        choose: [ {
            name: "微信支付",
            value: "1",
            icon: "/style/images/wx.png",
            checked: "checked"
        } ],
        payStatus: 0,
        payType: "1",
        uremark: "",
        showuremark: "20字以内",
        orderNum: "1111111111111",
        orderTime: "2018-02-02 10:30",
        deliveryfee: 0,
        is_modal_Hidden: !0,
        typeid: 0,
        order_id: 0,
        continuesubmit: !1,
        shiptypetitle: [ "", "到店消费", "送货上门", "快递" ],
        tel: "",
        isclickpay: !1,
        goodsnum: 1
    },
    onLoad: function(s) {
        var n = this;
        wx.setNavigationBarTitle({
            title: n.data.navTile
        });
        var e = app.getSiteUrl();
        n.setData({
            url: e
        });
        var t = wx.getStorageSync("openid");
        app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                console.log(e.data);
                var t = n.data.choose;
                if (1 == e.data.isopen_recharge) {
                    t = t.concat([ {
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    } ]);
                }
                console.log("69696969696969"), console.log(t), n.setData({
                    choose: t
                }), wx.setNavigationBarColor({
                    frontColor: e.data.fontcolor ? e.data.fontcolor : "",
                    backgroundColor: e.data.color ? e.data.color : "",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                });
            }
        }), n.setData({
            id: s.id,
            price: s.price,
            typeid: s.typeid ? s.typeid : 0
        });
        t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Cforder",
            data: {
                id: s.id,
                openid: t
            },
            success: function(e) {
                console.log("yueyue"), console.log(e.data);
                var t, a, o = e.data.ship_type[0];
                if (t = n.data.price, 2 == o) {
                    a = parseFloat(t) + parseFloat(e.data.ship_delivery_fee);
                    var r = e.data.ship_delivery_fee;
                } else if (3 == o) {
                    a = parseFloat(t) + parseFloat(e.data.ship_express_fee);
                    r = e.data.ship_express_fee;
                } else {
                    a = parseFloat(t);
                    r = "0.00";
                }
                a = a.toFixed(2);
                var i = (e.data.shopprice - t).toFixed(2);
                n.setData({
                    goods: e.data,
                    totalprice: a,
                    price: s.price,
                    deliveryfee: r,
                    cardprice: i,
                    sincetype: o,
                    tel: e.data.telnumber ? e.data.telnumber : ""
                }), n.getUrl();
            }
        });
    },
    toaddlessbtn: function(e) {
        return wx.showToast({
            title: "多份购买暂时关闭！！！",
            icon: "none"
        }), !1;
    },
    onReady: function() {},
    onShow: function() {},
    getUrl: function() {
        var e = app.getSiteUrl();
        this.setData({
            url: e
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bindTimeChange: function(e) {
        this.setData({
            time: e.detail.value
        });
    },
    chooseType: function(e) {
        var t = e.currentTarget.dataset.type, a = this;
        a.data.distribution;
        if (a.data.continuesubmit) return wx.showModal({
            title: "提示",
            content: "点击付款之后无法再修改配送方式；如需修改，请退出该页面重新下单",
            showCancel: !1
        }), !1;
        var o = a.data.goods, r = 0;
        r = 2 == t ? o.ship_delivery_fee : 3 == t ? o.ship_express_fee : 0;
        var i = (parseFloat(r), parseFloat(a.data.price));
        r = 0 == r ? "0.00" : r;
        i = parseFloat(r) + parseFloat(a.data.price);
        a.setData({
            totalprice: i,
            deliveryfee: r,
            sincetype: t
        });
    },
    powerDrawer: function(e) {
        var t = e.currentTarget.dataset.statu;
        this.util(t);
    },
    util: function(e) {
        var t = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = t).opacity(0).height(0).step(), this.setData({
            animationData: t.export()
        }), setTimeout(function() {
            t.opacity(1).height("550rpx").step(), this.setData({
                animationData: t
            }), "close" == e && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == e && this.setData({
            showModalStatus: !0
        });
    },
    coupon: function(e) {
        var t = e.currentTarget.dataset.price, a = this.data.totalprice, o = parseFloat(a) - parseFloat(t);
        console.log(a), o < 0 && (o = 0), this.setData({
            cardprice: t,
            curprice: o
        }), this.util("close");
    },
    showModel: function(e) {
        var t = e.currentTarget.dataset.statu;
        console.log(), this.setData({
            showRemark: t
        });
    },
    showPay: function(e) {
        var t = e.currentTarget.dataset.statu, a = this.data.hasAddress;
        if (1 != this.data.sincetype && !a) return wx.showToast({
            title: "收货地址不能为空！！！",
            icon: "none",
            duration: 2e3
        }), !1;
        this.setData({
            payStatus: t
        });
    },
    remark: function(e) {
        var t = e.detail.value;
        this.setData({
            uremark: t,
            showuremark: t
        });
    },
    radioChange: function(e) {
        var t = e.detail.value;
        this.setData({
            payType: t
        });
    },
    formSubmit: function(e) {
        var t = !0, a = "", o = this, r = wx.getStorageSync("openid"), i = o.data.sincetype, s = o.data.deliveryfee, n = o.data.payType, d = o.data.time, c = o.data.uremark, l = o.data.shiptypetitle[i], p = (r = wx.getStorageSync("openid"), 
        o.data.totalprice), u = e.detail.value.id, y = e.detail.value.name, h = e.detail.value.tel, f = e.detail.value.count, g = e.detail.value.city, m = e.detail.value.detai, v = e.detail.value.province, w = e.detail.value.telnum, _ = o.data.goodsnum, x = o.data.typeid;
        if ("1" == i) if (h && "" != h) if ("" == n) a = "请选择支付方式"; else {
            t = !1;
            var S = {
                price: p,
                id: u,
                openid: r,
                uremark: c,
                time: d,
                telNumber: h,
                sincetype: l,
                goodsnum: _,
                typeid: x,
                payType: n
            };
        } else a = "请输入正确的消费电话号码"; else if ("" == n && (a = "请选择支付方式"), "" == y) a = "请选择收货地址"; else {
            var D;
            t = !1;
            S = (_defineProperty(D = {
                price: p,
                id: u,
                openid: r,
                uremark: c,
                cityName: g,
                detailInfo: m,
                telNumber: w,
                countyName: f,
                name: y,
                sincetype: l
            }, "openid", r), _defineProperty(D, "provinceName", v), _defineProperty(D, "deliveryfee", s), 
            _defineProperty(D, "goodsnum", _), _defineProperty(D, "typeid", x), _defineProperty(D, "payType", n), 
            D);
        }
        if (1 == t) return wx.showModal({
            title: "提示",
            content: a,
            showCancel: !1
        }), !1;
        if (o.data.isclickpay) return console.log("多次点击pay"), wx.showToast({
            title: "请稍后...",
            icon: "none",
            duration: 2e3
        }), !1;
        if (o.setData({
            isclickpay: !0
        }), 1 == x) var T = 4, k = 4; else T = 0, k = 1;
        var P = e.detail.formId, b = {
            payType: n,
            resulttype: 0,
            orderarr: "",
            SendMessagePay: "",
            PayOrder: "",
            SendSms: "",
            PayOrderurl: "entry/wxapp/PayqgOrder",
            PayredirectTourl: "/mzhk_sun/pages/user/myorder/myorder"
        }, F = o.data.continuesubmit, M = o.data.order_id;
        F && 0 < M ? (console.log("正在执行继续支付"), b.orderarr = {
            price: p,
            openid: r,
            order_id: M,
            ordertype: T
        }, b.SendMessagePay = {
            id: u,
            price: p,
            order_id: M,
            openid: r,
            form_id: P,
            typeid: k
        }, b.PayOrder = {
            order_id: M,
            typeid: x
        }, 1 == x && (b.PayredirectTourl = "/mzhk_sun/pages/user/order/order"), app.func.orderarr(app, o, b)) : (console.log("正在执行新支付"), 
        app.util.request({
            url: "entry/wxapp/AddqgOrder",
            data: S,
            success: function(e) {
                console.log(e);
                var t = e.data;
                0 < t ? (o.setData({
                    order_id: t
                }), b.orderarr = {
                    price: p,
                    openid: r,
                    order_id: t,
                    ordertype: T
                }, b.SendMessagePay = {
                    id: u,
                    price: p,
                    order_id: t,
                    openid: r,
                    form_id: P,
                    typeid: k
                }, b.PayOrder = {
                    order_id: t,
                    typeid: x
                }, 1 == x && (b.PayredirectTourl = "/mzhk_sun/pages/user/order/order"), app.func.orderarr(app, o, b)) : (wx.showModal({
                    title: "提示",
                    content: "订单信息提交失败，请重新提交",
                    showCancel: !1,
                    success: function(e) {}
                }), o.setData({
                    isclickpay: !1
                }));
            },
            fail: function(e) {
                o.setData({
                    isclickpay: !1
                }), wx.showModal({
                    title: "提示",
                    content: e.data.message,
                    showCancel: !1,
                    success: function(e) {}
                });
            }
        }));
    },
    toAddress: function() {
        var t = this;
        wx.chooseAddress({
            success: function(e) {
                console.log("获取地址成功"), t.setData({
                    address: e,
                    hasAddress: !0
                });
            },
            fail: function(e) {
                console.log("获取地址失败"), wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.address"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(e) {
                                console.log("openSetting success", e.authSetting);
                            }
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