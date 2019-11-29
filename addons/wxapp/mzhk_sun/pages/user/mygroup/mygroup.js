var app = getApp();

Page({
    data: {
        navTile: "我的拼团",
        curIndex: 0,
        nav: [ "全部", "待付款", "拼团中", "已成团", "待收货", "完成/售后" ],
        orderlist: [],
        status: [ 0, 2, 3, 4, 6, 5 ],
        statusstr: [ "", "已取消订单", "待支付", "拼团中", "已成团", "已完成", "待收货" ],
        url: "",
        page: [ 1, 1, 1, 1, 1, 1 ],
        isclick: !1,
        choose: [ {
            name: "微信支付",
            value: "1",
            icon: "/style/images/wx.png",
            checked: "checked"
        } ],
        payStatus: 0,
        payType: "1",
        g_order_id: 0,
        g_f_index: ""
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = app.getSiteUrl();
        e ? a.setData({
            url: e
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), e = t.data, a.setData({
                    url: e
                });
            }
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
        var o = wx.getStorageSync("openid"), r = t.tab;
        r = r || 0;
        var n = a.data.status[r];
        app.util.request({
            url: "entry/wxapp/getGroupOrder",
            data: {
                orderstatus: n,
                openid: o
            },
            success: function(t) {
                2 == t.data ? a.setData({
                    orderlist: [],
                    curIndex: r
                }) : a.setData({
                    orderlist: t.data,
                    curIndex: r
                });
            }
        }), app.util.request({
            url: "entry/wxapp/CheckGroup",
            success: function(t) {
                console.log("成功"), console.log(t.data);
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var a = this, o = a.data.curIndex;
        o = null == o ? 0 : o;
        var t = a.data.status[o], e = wx.getStorageSync("openid"), r = a.data.orderlist, n = a.data.page, s = n[o];
        console.log(o + "---" + s), app.util.request({
            url: "entry/wxapp/getGroupOrder",
            cachetime: "10",
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
    bargainTap: function(t) {
        var e = this, a = parseInt(t.currentTarget.dataset.index), o = e.data.status[a], r = wx.getStorageSync("openid"), n = [ 1, 1, 1, 1, 1, 1 ];
        app.util.request({
            url: "entry/wxapp/getGroupOrder",
            data: {
                orderstatus: o,
                openid: r
            },
            success: function(t) {
                2 == t.data ? e.setData({
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
    radioChange: function(t) {
        var e = t.detail.value;
        console.log(e), this.setData({
            payType: e
        });
    },
    showPay: function(t) {
        var e = t.currentTarget.dataset.statu, a = 0, o = 0, r = "", n = 0, s = 0;
        1 == e && (o = t.currentTarget.dataset.order_id, a = t.currentTarget.dataset.g_order_id, 
        r = t.currentTarget.dataset.f_index, n = t.currentTarget.dataset.price, s = t.currentTarget.dataset.is_lead), 
        this.setData({
            payStatus: e,
            order_id: o,
            g_order_id: a,
            g_f_index: r,
            totalprice: n,
            is_lead: s,
            payType: 1
        });
    },
    toPay: function(t) {
        var e = this, a = wx.getStorageSync("openid"), o = e.data.g_order_id, r = e.data.order_id, n = e.data.g_f_index, s = e.data.payType, d = e.data.orderlist, i = e.data.is_lead;
        if (e.data.isclick) return wx.showToast({
            title: "请稍后",
            icon: "none",
            duration: 1e3
        }), !1;
        e.setData({
            isclick: !0
        });
        var c = {
            payType: s,
            resulttype: 3,
            orderarr: "",
            SendMessagePay: "",
            PayOrder: "",
            SendSms: "",
            PayOrderurl: "entry/wxapp/PayptOrder",
            PayredirectTourl: {
                status: 3,
                f_index: n,
                orderlist: d
            }
        };
        c.orderarr = {
            openid: a,
            order_id: r,
            g_order_id: o,
            ordertype: 1,
            is_lead: i
        }, c.PayOrder = {
            order_id: r,
            g_order_id: o,
            openid: a
        }, app.func.orderarr(app, e, c);
    },
    toRefundcannel: function(t) {
        var a = this, e = t.currentTarget.dataset.order_id, o = t.currentTarget.dataset.g_order_id, r = t.currentTarget.dataset.f_index, n = a.data.orderlist;
        wx.showModal({
            title: "提示",
            content: "确认取消退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: e,
                        g_order_id: o,
                        ordertype: 1,
                        status: 1,
                        refund: 4
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
                        }), n[r].isrefund = 0, console.log(n), a.setData({
                            orderlist: n
                        }));
                    },
                    fail: function(e) {
                        console.log(e.data), wx.showModal({
                            title: "提示信息",
                            content: e.data.message,
                            showCancel: !1,
                            success: function(t) {
                                n[r].status = e.data.data.status, console.log(n), a.setData({
                                    orderlist: n
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
        var a = this, e = t.currentTarget.dataset.order_id, o = t.currentTarget.dataset.g_order_id, r = t.currentTarget.dataset.f_index, n = a.data.orderlist;
        wx.showModal({
            title: "提示",
            content: "确认申请退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: e,
                        g_order_id: o,
                        ordertype: 1,
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
                        }), n[r].isrefund = 1, console.log(n), a.setData({
                            orderlist: n
                        }));
                    },
                    fail: function(e) {
                        console.log(e.data), wx.showModal({
                            title: "提示信息",
                            content: e.data.message,
                            showCancel: !1,
                            success: function(t) {
                                n[r].status = e.data.data.status, console.log(n), a.setData({
                                    orderlist: n
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
        var e = this, a = t.currentTarget.dataset.order_id, o = t.currentTarget.dataset.g_order_id, r = t.currentTarget.dataset.f_index, n = e.data.orderlist, s = wx.getStorageSync("openid");
        wx.showModal({
            title: "提示",
            content: "确定要确认收货吗？",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderFinish",
                    data: {
                        order_id: a,
                        g_order_id: o,
                        openid: s,
                        ordertype: 1
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
                        }), n[r].status = 5, console.log(n), e.setData({
                            orderlist: n
                        }));
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    toCancel: function(t) {
        var e = this, a = t.currentTarget.dataset.order_id, o = t.currentTarget.dataset.g_order_id, r = t.currentTarget.dataset.f_index, n = e.data.orderlist;
        wx.showModal({
            title: "提示",
            content: "确认取消该订单吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: a,
                        g_order_id: o,
                        ordertype: 1,
                        status: 1
                    },
                    success: function(t) {
                        console.log(123456), console.log(t.data), console.log(789456), 2 == t.data ? wx.showToast({
                            title: "取消订单失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "取消订单成功！",
                            icon: "success",
                            duration: 500
                        }), n[r].status = 1, console.log(n), e.setData({
                            orderlist: n
                        }));
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    toShare: function(t) {
        var e = t.currentTarget.dataset.id, a = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../../index/goCantuan/goCantuan?id=" + e + "&gid=" + a
        });
    },
    toOrderder: function(t) {
        var e = t.currentTarget.dataset.order_id;
        wx.navigateTo({
            url: "../orderdet/orderdet?order_id=" + e + "&ordertype=1"
        });
    }
});