var app = getApp();

Page({
    data: {
        list: [ {
            title: "今日订单",
            detail: "0"
        }, {
            title: "昨日订单",
            detail: "0"
        }, {
            title: "本月订单",
            detail: "0"
        }, {
            title: "总订单量",
            detail: "0"
        }, {
            title: "今日核销",
            detail: "0"
        }, {
            title: "昨日核销",
            detail: "0"
        }, {
            title: "本月核销",
            detail: "0"
        }, {
            title: "总核销量",
            detail: "0"
        }, {
            title: "今日销售额",
            detail: "0"
        }, {
            title: "昨日销售额",
            detail: "0"
        }, {
            title: "本月销售额",
            detail: "0"
        }, {
            title: "总销售额",
            detail: "0"
        } ],
        brandinfo: [],
        is_modal_Hidden: !0,
        ordernum: "",
        show: !1,
        codeShow: !0,
        isboss: !0,
        goodsnum: 1,
        marketing: [ {
            name: "抢购订单",
            img: "../../../../style/images/m1.png",
            showtype: 0
        }, {
            name: "拼团订单",
            img: "../../../../style/images/m2.png",
            showtype: 1
        }, {
            name: "砍价订单",
            img: "../../../../style/images/m3.png",
            showtype: 2
        } ],
        marketing_two: [ {
            name: "集卡订单",
            img: "../../../../style/images/m4.png",
            showtype: 3
        }, {
            name: "免单订单",
            img: "../../../../style/images/m3.png",
            showtype: 6
        }, {
            name: "普通订单",
            img: "../../../../style/images/m5.png",
            showtype: 4
        } ]
    },
    onLoad: function(t) {
        var a = this, o = app.getSiteUrl();
        a.setData({
            url: o
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.wxauthSetting();
        var n = wx.getStorageSync("brand_info");
        if (n || wx.redirectTo({
            url: "/mzhk_sun/pages/backstage/backstage"
        }), wx.getStorageSync("openid") == n.bind_openid) var e = !1; else e = !0;
        console.log("获取店铺信息"), console.log(n), a.setData({
            brandinfo: n,
            isboss: e
        });
        var s = a.data.list;
        app.util.request({
            url: "entry/wxapp/GetOrderNum",
            cachetime: "0",
            data: {
                bid: n.bid
            },
            success: function(t) {
                console.log("获取订单数据"), console.log(t.data);
                for (var o = t.data.count, e = 0; e < s.length; e++) s[e].detail = o[e];
                n.totalamount = t.data.totalamount, a.setData({
                    list: s,
                    brandinfo: n
                });
            }
        }), app.util.request({
            url: "entry/wxapp/CheckGroup",
            success: function(t) {
                console.log("成功");
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        app.func.islogin(app, this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    scanCode: function(t) {
        var a = this;
        wx.scanCode({
            scanType: "",
            success: function(t) {
                console.log("扫描获取数据-成功"), console.log(t);
                var e = JSON.parse(t.result), o = wx.getStorageSync("brand_info").bid;
                app.util.request({
                    url: "entry/wxapp/GetOrderInfo",
                    cachetime: "0",
                    data: {
                        id: e.id,
                        ordertype: e.ordertype,
                        bid: o
                    },
                    success: function(t) {
                        console.log("获取订单数据");
                        var o = t.data;
                        o.ordertype = e.ordertype, console.log(o), a.setData({
                            writeoff: o,
                            goodsnum: 1,
                            show: !0
                        });
                    }
                });
            },
            fail: function(t) {
                console.log("扫描获取数据-失败"), console.log(t);
            }
        });
    },
    toaddlessbtn: function(t) {
        var o = this, e = o.data.goodsnum, a = t.currentTarget.dataset.ty, n = o.data.writeoff, s = n.num - n.haswrittenoffnum;
        if (1 == a) {
            if (!(e < s)) return wx.showModal({
                title: "提示信息",
                content: "该订单当前最多只能核销" + s + "个",
                showCancel: !1
            }), !1;
            e += 1;
        } else 1 < e && (e -= 1);
        o.setData({
            goodsnum: e
        });
    },
    showModel: function(t) {
        this.setData({
            show: !this.data.show
        });
    },
    showCodeModel: function(t) {
        var o = '{ "bid": ' + wx.getStorageSync("brand_info").bid + ', "showtype": 1 }';
        require("../../../../style/utils/index.js").qrcode("qrcode", o, 420, 420), this.setData({
            codeShow: !this.data.codeShow
        });
    },
    formSubmit: function(t) {
        var o = this, e = t.detail.value.orderNum, a = wx.getStorageSync("brand_info");
        if ("" == a || null == a) return wx.navigateTo({
            url: "/mzhk_sun/pages/backstage/backstage"
        }), !1;
        "" == e ? wx.showModal({
            content: "请输入订单号",
            showCancel: !1
        }) : (app.util.request({
            url: "entry/wxapp/SetBrandOrder",
            cachetime: "0",
            data: {
                bid: a.bid,
                ordernum: e
            },
            success: function(t) {
                console.log("核销订单"), console.log(t.data), a.totalamount = t.data.data.totalamount, 
                o.setData({
                    brandinfo: a
                }), wx.showToast({
                    title: "核销成功",
                    icon: "success",
                    duration: 2e3
                });
            },
            fial: function(t) {
                console.log("核销订单11"), console.log(t.data), wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1
                });
            }
        }), o.setData({
            ordernum: ""
        }));
    },
    writeoff: function(t) {
        var o = this, e = o.data.writeoff, a = wx.getStorageSync("brand_info"), n = a.bid, s = o.data.goodsnum;
        app.util.request({
            url: "entry/wxapp/SaoBrandOrder",
            cachetime: "0",
            data: {
                id: e.oid,
                bid: n,
                ordertype: e.ordertype,
                goodsnum: s
            },
            success: function(t) {
                console.log("核销订单"), console.log(t.data), a.totalamount = t.data.data.totalamount, 
                o.setData({
                    show: !1,
                    brandinfo: a
                }), wx.showToast({
                    title: "核销成功",
                    icon: "success",
                    duration: 2e3
                });
            },
            fial: function(t) {
                console.log("核销订单11"), console.log(t.data), wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1
                });
            }
        });
    },
    logout: function(t) {
        console.log("退出");
        wx.setStorageSync("brand_info", !1), wx.setStorageSync("loginname", !1), app.globalData.islogin = 0, 
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    toCash: function(t) {
        wx.navigateTo({
            url: "../cash/cash"
        });
    },
    toMyorder: function(t) {
        var o = t.currentTarget.dataset.showtype;
        wx.navigateTo({
            url: "../myorder/myorder?ordertype=" + o
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});