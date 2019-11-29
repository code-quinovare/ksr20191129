var wxbarcode = require("../../../../style/utils/index.js"), app = getApp();

Page({
    data: {
        orderinfo: [],
        url: "",
        navTile: "订单详情",
        statusstr: [ "", "已取消订单", "待支付", "待使用", "已支付", "已完成" ],
        statusstr_jk: [ "待发货", "待收货", "已完成" ]
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
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var o = e.ordertype ? e.ordertype : 0, r = e.order_id;
        app.util.request({
            url: "entry/wxapp/GetOrderDetail",
            cachetime: "30",
            data: {
                order_id: r,
                ordertype: o
            },
            success: function(e) {
                console.log("查看order——id:" + r), console.log(e.data), t.setData({
                    orderinfo: e.data,
                    ordertype: o
                });
            }
        });
        var n = '{ "id": ' + r + ', "ordertype": ' + o + "}";
        wxbarcode.qrcode("qrcode", n, 420, 420);
    },
    copyshipnum: function(e) {
        var t = e.currentTarget.dataset.shipnum;
        wx.setClipboardData({
            data: t,
            success: function(e) {
                wx.showToast({
                    title: "复制成功！",
                    icon: "none",
                    duration: 2e3
                });
            }
        });
    },
    gotoGoods: function(e) {
        var t, a = e.currentTarget.dataset.gid, o = this.data.ordertype;
        t = 1 == o ? "/mzhk_sun/pages/index/groupdet/groupdet?id=" + a : 2 == o ? "/mzhk_sun/pages/index/bardet/bardet?id=" + a : 3 == o ? "/mzhk_sun/pages/index/cardsdet/cardsdet?gid=" + a : 4 == o ? "/mzhk_sun/pages/index/goods/goods?gid=" + a : 6 == o ? "/mzhk_sun/pages/index/freedet/freedet?id=" + a : "/mzhk_sun/pages/index/package/package?id=" + a, 
        wx.redirectTo({
            url: t
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});