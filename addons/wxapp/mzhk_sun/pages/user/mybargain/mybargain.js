var _data;

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp();

Page({
    data: (_data = {
        navTile: "砍价订单",
        curIndex: 0,
        nav: [ "全部", "待支付", "待使用", "待收货", "完成/售后" ],
        status: [ 0, 2, 3, 4, 5 ],
        statusstr: [ "", "已取消订单", "待支付", "待使用", "待收货", "已完成" ],
        orderlist: [],
        page: [ 1, 1, 1, 1, 1 ]
    }, _defineProperty(_data, "orderlist", []), _defineProperty(_data, "url", ""), _defineProperty(_data, "isclick", !1), 
    _defineProperty(_data, "choose", [ {
        name: "微信支付",
        value: "1",
        icon: "/style/images/wx.png",
        checked: "checked"
    } ]), _defineProperty(_data, "payStatus", 0), _defineProperty(_data, "payType", "1"), 
    _defineProperty(_data, "g_order_id", 0), _defineProperty(_data, "g_f_index", ""), 
    _data),
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = app.getSiteUrl();
        a.setData({
            url: e
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                console.log(t.data);
                var e = a.data.choose;
                if (1 == t.data.isopen_recharge) {
                    e = e.concat([ {
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    } ]);
                }
                a.setData({
                    choose: e,
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
        });
        var o = t.tab ? t.tab : 0, r = a.data.status[o], n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getCutOrder",
            data: {
                orderstatus: r,
                openid: n
            },
            success: function(t) {
                console.log("第一次订单数据"), console.log(t.data), 2 == t.data ? a.setData({
                    orderlist: [],
                    curIndex: o
                }) : a.setData({
                    orderlist: t.data,
                    curIndex: o
                });
            }
        });
    },
    bargainTap: function(t) {
        var e = this, a = parseInt(t.currentTarget.dataset.index), o = e.data.status[a], r = wx.getStorageSync("openid"), n = [ 1, 1, 1, 1, 1 ];
        app.util.request({
            url: "entry/wxapp/getCutOrder",
            data: {
                orderstatus: o,
                openid: r
            },
            success: function(t) {
                console.log("切换订单数据"), console.log(t.data), 2 == t.data ? e.setData({
                    orderlist: [],
                    page: n
                }) : e.setData({
                    orderlist: t.data,
                    page: n
                });
            }
        }), this.setData({
            curIndex: a
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var a = this, o = a.data.curIndex, t = a.data.status[o], e = wx.getStorageSync("openid"), r = a.data.orderlist, n = a.data.page, s = n[o];
        console.log(o), app.util.request({
            url: "entry/wxapp/getCutOrder",
            data: {
                orderstatus: t,
                openid: e,
                page: s
            },
            success: function(t) {
                if (2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var e = t.data;
                    r = r.concat(e), n[o] = s + 1, console.log(n), a.setData({
                        orderlist: r,
                        page: n
                    });
                }
            }
        });
    },
    radioChange: function(t) {
        var e = t.detail.value;
        console.log(e), this.setData({
            payType: e
        });
    },
    showPay: function(t) {
        var e = t.currentTarget.dataset.statu, a = 0, o = "", r = 0;
        1 == e && (a = t.currentTarget.dataset.order_id, o = t.currentTarget.dataset.f_index, 
        r = t.currentTarget.dataset.price), this.setData({
            payStatus: e,
            g_order_id: a,
            g_f_index: o,
            totalprice: r,
            payType: 1
        });
    },
    toPay: function(t) {
        var e = this, a = wx.getStorageSync("openid"), o = e.data.g_order_id, r = e.data.g_f_index, n = e.data.payType, s = e.data.orderlist;
        if (e.data.isclick) return wx.showToast({
            title: "请稍后",
            icon: "none",
            duration: 1e3
        }), !1;
        e.setData({
            isclick: !0
        });
        var d = {
            payType: n,
            resulttype: 3,
            orderarr: "",
            SendMessagePay: "",
            PayOrder: "",
            SendSms: "",
            PayOrderurl: "entry/wxapp/PaykjOrder",
            PayredirectTourl: {
                status: 3,
                f_index: r,
                orderlist: s
            }
        };
        d.orderarr = {
            openid: a,
            order_id: o,
            ordertype: 5
        }, d.PayOrder = {
            order_id: o,
            openid: a
        }, app.func.orderarr(app, e, d);
    },
    toOrderder: function(t) {
        var e = t.currentTarget.dataset.order_id;
        wx.navigateTo({
            url: "../orderdet/orderdet?order_id=" + e + "&ordertype=2"
        });
    },
    toRefundcannel: function(t) {
        var a = this, e = t.currentTarget.dataset.order_id, o = t.currentTarget.dataset.f_index, r = a.data.orderlist;
        wx.showModal({
            title: "提示",
            content: "确认取消退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: e,
                        ordertype: 2,
                        status: 1,
                        refund: 4
                    },
                    success: function(t) {
                        2 == t.data ? wx.showToast({
                            title: "申请失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "申请成功！",
                            icon: "success",
                            duration: 500
                        }), r[o].isrefund = 0, a.setData({
                            orderlist: r
                        }));
                    },
                    fail: function(e) {
                        console.log(e.data), wx.showModal({
                            title: "提示信息",
                            content: e.data.message,
                            showCancel: !1,
                            success: function(t) {
                                r[o].status = e.data.data.status, console.log(r), a.setData({
                                    orderlist: r
                                });
                            }
                        });
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    toRefund: function(t) {
        var a = this, e = t.currentTarget.dataset.order_id, o = t.currentTarget.dataset.f_index, r = a.data.orderlist;
        wx.showModal({
            title: "提示",
            content: "确认申请退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: e,
                        ordertype: 2,
                        refund: 1
                    },
                    success: function(t) {
                        console.log(123456), console.log(t.data), console.log(789456), 2 == t.data ? wx.showToast({
                            title: "申请失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "申请成功！",
                            icon: "success",
                            duration: 500
                        }), r[o].isrefund = 1, console.log(r), a.setData({
                            orderlist: r
                        }));
                    },
                    fail: function(e) {
                        console.log(e.data), wx.showModal({
                            title: "提示信息",
                            content: e.data.message,
                            showCancel: !1,
                            success: function(t) {
                                r[o].status = e.data.data.status, console.log(r), a.setData({
                                    orderlist: r
                                });
                            }
                        });
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    toReceipt: function(t) {
        var e = this, a = t.currentTarget.dataset.order_id, o = t.currentTarget.dataset.f_index, r = e.data.orderlist, n = wx.getStorageSync("openid");
        wx.showModal({
            title: "提示",
            content: "确定要确认收货吗？",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderFinish",
                    data: {
                        order_id: a,
                        openid: n,
                        ordertype: 2
                    },
                    success: function(t) {
                        console.log(123456), console.log(t.data), console.log(789456), 2 == t.data ? wx.showToast({
                            title: "收货失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "收货成功！",
                            icon: "success",
                            duration: 500
                        }), r[o].status = 5, console.log(r), e.setData({
                            orderlist: r
                        }));
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    toCancel: function(t) {
        var e = this, a = t.currentTarget.dataset.order_id, o = t.currentTarget.dataset.f_index, r = e.data.orderlist;
        wx.showModal({
            title: "提示",
            content: "确认取消该订单吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: a,
                        ordertype: 2,
                        status: 1
                    },
                    success: function(t) {
                        console.log(123456), console.log(t.data), 2 == t.data ? wx.showToast({
                            title: "取消订单失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "取消订单成功！",
                            icon: "success",
                            duration: 500
                        }), r[o].status = 1, console.log(r), e.setData({
                            orderlist: r
                        }));
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    }
});