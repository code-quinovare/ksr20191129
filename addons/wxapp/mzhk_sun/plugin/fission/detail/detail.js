Page({
    data: {},
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    callPhone: function(n) {
        wx.makePhoneCall({
            phoneNumber: "13000"
        });
    },
    getAddress: function(n) {
        wx.getLocation({
            type: "gcj02",
            success: function(n) {
                var o = n.latitude, t = n.longitude;
                wx.openLocation({
                    latitude: o,
                    longitude: t,
                    scale: 28
                });
            }
        });
    },
    toShop: function(n) {},
    getCoupon: function(n) {},
    toIndex: function(n) {
        wx.navigateTo({
            url: "/mzhk_sun/plugin/fission/coupon/coupon"
        });
    }
});