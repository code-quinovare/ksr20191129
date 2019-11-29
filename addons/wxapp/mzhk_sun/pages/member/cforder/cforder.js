var app = getApp();

Page({
    data: {
        hasAddress: !1,
        address: [],
        navTile: "提交订单",
        goods: [],
        showuremark: "20字以内",
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
        orderNum: "1111111111111",
        orderTime: "2018-02-02 10:30",
        deliveryfee: 0,
        is_modal_Hidden: !0,
        typeid: 0,
        order_id: 0,
        continuesubmit: !1,
        shiptypetitle: [ "", "到店消费", "送货上门", "快递" ],
        tel: "",
        isclickpay: !1
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarTitle({
            title: t.data.navTile
        });
        var a = app.getSiteUrl();
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
        }), app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                console.log(e.data);
                var a = t.data.choose;
                if (1 == e.data.isopen_recharge) {
                    a = a.concat([ {
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    } ]);
                }
                console.log("69696969696969"), console.log(a), t.setData({
                    choose: a
                }), wx.setNavigationBarColor({
                    frontColor: e.data.fontcolor ? e.data.fontcolor : "",
                    backgroundColor: e.data.color ? e.data.color : "",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                });
            }
        }), t.setData({
            id: e.id,
            price: e.price
        });
    },
    onReady: function() {
        var e = wx.getStorageSync("openid"), s = this;
        app.util.request({
            url: "entry/wxapp/Cforder",
            method: "GET",
            data: {
                id: s.data.id,
                price: s.data.price,
                openid: e
            },
            success: function(e) {
                console.log(e);
                var a, t, i = e.data.ship_type[0];
                if (0 < e.data.nowprice ? (console.log("nowprice"), a = e.data.nowprice) : (console.log("price"), 
                a = s.data.price), 2 == i) {
                    t = parseFloat(a) + parseFloat(e.data.ship_delivery_fee);
                    var o = e.data.ship_delivery_fee;
                } else if (3 == i) {
                    t = parseFloat(a) + parseFloat(e.data.ship_express_fee);
                    o = e.data.ship_express_fee;
                } else {
                    t = parseFloat(a);
                    o = "0.00";
                }
                var r = (e.data.shopprice - a).toFixed(2);
                s.setData({
                    goods: e.data,
                    totalprice: t,
                    price: s.data.price,
                    deliveryfee: o,
                    cardprice: r,
                    sincetype: i,
                    tel: e.data.telnumber ? e.data.telnumber : ""
                }), s.getUrl();
            }
        });
    },
    onShow: function() {
        app.func.islogin(app, this);
    },
    getUrl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), a.setData({
                    url: e.data
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
        var a = e.currentTarget.dataset.type, t = this;
        t.data.distribution;
        if (t.data.continuesubmit) return wx.showModal({
            title: "提示",
            content: "点击付款之后无法再修改配送方式；如需修改，请退出该页面重新下单",
            showCancel: !1
        }), !1;
        var i = t.data.goods, o = 0;
        o = 2 == a ? i.ship_delivery_fee : 3 == a ? i.ship_express_fee : 0;
        var r = parseFloat(o) + parseFloat(t.data.price);
        o = 0 == o ? "0.00" : o, t.setData({
            totalprice: r,
            deliveryfee: o,
            sincetype: a
        });
    },
    powerDrawer: function(e) {
        var a = e.currentTarget.dataset.statu;
        this.util(a);
    },
    util: function(e) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height("550rpx").step(), this.setData({
                animationData: a
            }), "close" == e && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == e && this.setData({
            showModalStatus: !0
        });
    },
    coupon: function(e) {
        var a = this, t = e.currentTarget.dataset.price, i = a.data.totalprice, o = parseFloat(i) - parseFloat(t);
        console.log(i), o < 0 && (o = 0), a.setData({
            cardprice: t,
            curprice: o
        }), a.util("close");
    },
    showModel: function(e) {
        var a = e.currentTarget.dataset.statu;
        console.log(), this.setData({
            showRemark: a
        });
    },
    showPay: function(e) {
        var a = e.currentTarget.dataset.statu;
        this.setData({
            payStatus: a
        });
    },
    remark: function(e) {
        var a = e.detail.value;
        this.setData({
            uremark: a,
            showuremark: a
        });
    },
    radioChange: function(e) {
        var a = e.detail.value;
        console.log(a), this.setData({
            payType: a
        });
    },
    formSubmit: function(e) {
        var a = !0, t = "", i = this, o = wx.getStorageSync("openid"), r = i.data.sincetype, s = (i.data.distributFee, 
        i.data.deliveryfee), n = i.data.payType, d = i.data.time, c = i.data.uremark, l = i.data.shiptypetitle[r], p = (o = wx.getStorageSync("openid"), 
        e.detail.value.price), u = e.detail.value.id, y = e.detail.value.name, h = e.detail.value.tel, g = e.detail.value.count, f = e.detail.value.city, m = e.detail.value.detai, v = e.detail.value.province, w = e.detail.value.telnum, x = e.detail.formId;
        if ("1" == r) if (h && "" != h) if ("" == n) t = "请选择支付方式"; else {
            a = !1;
            var S = {
                price: p,
                id: u,
                openid: o,
                uremark: c,
                time: d,
                telNumber: h,
                sincetype: l,
                payType: n
            };
        } else t = "请输入正确的消费电话号码"; else if ("" == n && (t = "请选择支付方式"), "" == y) t = "请选择收货地址"; else {
            a = !1;
            S = {
                price: p,
                id: u,
                openid: o,
                uremark: c,
                cityName: f,
                detailInfo: m,
                telNumber: w,
                countyName: g,
                name: y,
                sincetype: l,
                provinceName: v,
                deliveryfee: s,
                paytype: n
            };
        }
        if (1 == a) return wx.showModal({
            title: "提示",
            content: t,
            showCancel: !1
        }), !1;
        if (i.data.isclickpay) return console.log("多次点击pay"), wx.showToast({
            title: "请稍后...",
            icon: "none",
            duration: 2e3
        }), !1;
        i.setData({
            isclickpay: !0
        });
        var _ = i.data.continuesubmit, D = i.data.order_id, k = {
            payType: n,
            resulttype: 0,
            orderarr: "",
            SendMessagePay: "",
            PayOrder: "",
            SendSms: "",
            PayOrderurl: "entry/wxapp/PaykjOrder",
            PayredirectTourl: "/mzhk_sun/pages/user/mybargain/mybargain"
        };
        _ && 0 < D ? (console.log("正在执行继续支付"), k.orderarr = {
            price: p,
            openid: o,
            order_id: D,
            ordertype: 5
        }, k.SendMessagePay = {
            id: u,
            price: p,
            order_id: D,
            openid: o,
            form_id: x,
            typeid: 5
        }, k.PayOrder = {
            order_id: D,
            openid: o
        }, app.func.orderarr(app, i, k)) : (console.log("正在执行新支付"), app.util.request({
            url: "entry/wxapp/AddkjOrder",
            data: S,
            success: function(e) {
                console.log(e);
                var a = e.data;
                0 < a ? (i.setData({
                    order_id: a
                }), k.orderarr = {
                    price: p,
                    openid: o,
                    order_id: a,
                    ordertype: 5
                }, k.SendMessagePay = {
                    id: u,
                    price: p,
                    order_id: a,
                    openid: o,
                    form_id: x,
                    typeid: 5
                }, k.PayOrder = {
                    order_id: a,
                    openid: o
                }, app.func.orderarr(app, i, k)) : (wx.showModal({
                    title: "提示",
                    content: "订单信息提交失败，请重新提交",
                    showCancel: !1,
                    success: function(e) {}
                }), i.setData({
                    isclickpay: !1
                }));
            },
            fail: function(e) {
                wx.showModal({
                    title: "提示信息",
                    content: e.data.message,
                    showCancel: !1,
                    success: function(e) {}
                }), i.setData({
                    isclickpay: !1
                });
            }
        }));
    },
    toAddress: function() {
        var a = this;
        wx.chooseAddress({
            success: function(e) {
                console.log("获取地址成功"), a.setData({
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