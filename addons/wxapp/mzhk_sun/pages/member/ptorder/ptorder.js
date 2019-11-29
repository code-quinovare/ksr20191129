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
        totalprice: "0.00",
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
        order_id: 0,
        g_order_id: 0,
        come_order_id: 0,
        continuesubmit: !1,
        buytype: 0,
        is_modal_Hidden: !0,
        shiptypetitle: [ "无", "到店消费", "送货上门", "快递" ],
        tel: "",
        isclickpay: !1
    },
    onLoad: function(e) {
        var o, i = this;
        wx.setNavigationBarTitle({
            title: i.data.navTile
        });
        var t = app.getSiteUrl();
        if (t ? i.setData({
            url: t
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), t = e.data, i.setData({
                    url: t
                });
            }
        }), app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                console.log(e.data);
                var t = i.data.choose;
                if (1 == e.data.isopen_recharge) {
                    t = t.concat([ {
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    } ]);
                }
                console.log("69696969696969"), console.log(t), i.setData({
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
        }), e.order_id) {
            var a = e.order_id;
            i.setData({
                come_order_id: a
            });
        }
        e.buytype && (o = e.buytype, i.setData({
            buytype: o
        })), console.log("options"), console.log(e);
        var s, r = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/PTorder",
            data: {
                id: e.id,
                openid: r
            },
            success: function(e) {
                var t = e.data.ship_type[0];
                if (1 == o && (e.data.ptprice = e.data.shopprice), 2 == t) {
                    s = parseFloat(e.data.ptprice) + parseFloat(e.data.ship_delivery_fee);
                    var a = e.data.ship_delivery_fee;
                } else if (3 == t) {
                    s = parseFloat(e.data.ptprice) + parseFloat(e.data.ship_express_fee);
                    a = e.data.ship_express_fee;
                } else {
                    s = parseFloat(e.data.ptprice);
                    a = "0.00";
                }
                var r = (e.data.shopprice - e.data.ptprice).toFixed(2);
                console.log("拼团数据"), console.log(e.data), i.setData({
                    goods: e.data,
                    totalprice: s,
                    deliveryfee: a,
                    sincetype: t,
                    cardprice: r,
                    tel: e.data.telnumber ? e.data.telnumber : ""
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
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
        var r = a.data.goods, o = 0;
        o = 2 == t ? r.ship_delivery_fee : 3 == t ? r.ship_express_fee : 0;
        var i = parseFloat(o) + parseFloat(r.ptprice);
        o = 0 == o ? "0.00" : o, a.setData({
            totalprice: i,
            deliveryfee: o,
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
        var t = this, a = e.currentTarget.dataset.price, r = t.data.totalprice, o = parseFloat(r) - parseFloat(a);
        console.log(r), o < 0 && (o = 0), t.setData({
            cardprice: a,
            curprice: o
        }), t.util("close");
    },
    showModel: function(e) {
        var t = e.currentTarget.dataset.statu;
        console.log(), this.setData({
            showRemark: t
        });
    },
    showPay: function(e) {
        var t = e.currentTarget.dataset.statu;
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
        console.log(t), this.setData({
            payType: t
        });
    },
    formSubmit: function(e) {
        var t = !0, a = "", r = this, o = wx.getStorageSync("openid"), i = r.data.sincetype, s = (r.data.distributFee, 
        r.data.payType), d = r.data.time, n = r.data.uremark, c = r.data.shiptypetitle[i], l = e.detail.value.price, p = e.detail.value.id, u = e.detail.value.name, y = e.detail.value.tel, g = e.detail.value.count, f = e.detail.value.city, h = e.detail.value.detai, _ = e.detail.value.province, m = e.detail.value.telnum, v = r.data.deliveryfee, w = r.data.come_order_id;
        if (0 < w) {
            console.log("不是团长");
            var x = 0;
        } else {
            console.log("团长");
            x = 1;
        }
        var S = r.data.buytype;
        if ("1" == i) if (y && "" != y) if ("" == s) a = "请选择支付方式"; else {
            t = !1;
            var D = {
                price: l,
                id: p,
                openid: o,
                uremark: n,
                time: d,
                telNumber: y,
                sincetype: c,
                come_order_id: w,
                buytype: S,
                payType: s
            };
        } else a = "请输入消费电话"; else if ("" == s && (a = "请选择支付方式"), "" == u) a = "请选择收货地址"; else {
            var b;
            t = !1;
            D = (_defineProperty(b = {
                price: l,
                id: p,
                openid: o,
                uremark: n,
                cityName: f,
                detailInfo: h,
                telNumber: m,
                countyName: g,
                name: u,
                sincetype: c
            }, "openid", o), _defineProperty(b, "provinceName", _), _defineProperty(b, "come_order_id", w), 
            _defineProperty(b, "deliveryfee", v), _defineProperty(b, "buytype", S), _defineProperty(b, "payType", s), 
            b);
        }
        if (1 == t) return wx.showModal({
            title: "提示",
            content: a,
            showCancel: !1
        }), !1;
        if (r.data.isclickpay) return console.log("多次点击pay"), wx.showToast({
            title: "请稍后...",
            icon: "none",
            duration: 2e3
        }), !1;
        r.setData({
            isclickpay: !0
        });
        var P = e.detail.formId, T = r.data.continuesubmit, k = r.data.order_id, F = r.data.g_order_id, M = {
            payType: s,
            resulttype: 0,
            orderarr: "",
            SendMessagePay: "",
            PayOrder: "",
            SendSms: "",
            PayOrderurl: "entry/wxapp/PayptOrder",
            PayredirectTourl: "/mzhk_sun/pages/user/mygroup/mygroup"
        };
        T && 0 < F && 0 < k ? (console.log("正在执行继续支付"), M.orderarr = {
            price: l,
            openid: o,
            order_id: k,
            g_order_id: F,
            is_lead: x,
            ordertype: 1,
            buytype: S
        }, M.SendMessagePay = {
            id: p,
            price: l,
            order_id: F,
            openid: o,
            form_id: P,
            typeid: 2
        }, M.PayOrder = {
            openid: o,
            order_id: k,
            g_order_id: F
        }, app.func.orderarr(app, r, M)) : (console.log("正在执行新支付"), app.util.request({
            url: "entry/wxapp/AddptOrder",
            data: D,
            success: function(e) {
                k = e.data.order_id, F = e.data.g_order_id, 0 < k && 0 < F ? (r.setData({
                    order_id: k,
                    g_order_id: F
                }), M.orderarr = {
                    price: l,
                    openid: o,
                    order_id: k,
                    g_order_id: F,
                    is_lead: x,
                    ordertype: 1
                }, M.SendMessagePay = {
                    id: p,
                    price: l,
                    order_id: F,
                    openid: o,
                    form_id: P,
                    typeid: 2
                }, M.PayOrder = {
                    openid: o,
                    order_id: k,
                    g_order_id: F
                }, app.func.orderarr(app, r, M)) : (wx.showModal({
                    title: "提示",
                    content: "订单信息提交失败，请重新提交",
                    showCancel: !1,
                    success: function(e) {}
                }), r.setData({
                    isclickpay: !1
                }));
            },
            fail: function(e) {
                console.log("失败00005"), wx.showModal({
                    title: "提示信息",
                    content: e.data.message,
                    showCancel: !1
                }), r.setData({
                    isclickpay: !1
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