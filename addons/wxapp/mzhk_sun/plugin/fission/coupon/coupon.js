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
    toShop: function(n) {},
    callPhone: function(n) {
        wx.makePhoneCall({
            phoneNumber: "130000000"
        });
    },
    getAddress: function(n) {
        wx.getLocation({
            success: function(n) {}
        });
    }
});