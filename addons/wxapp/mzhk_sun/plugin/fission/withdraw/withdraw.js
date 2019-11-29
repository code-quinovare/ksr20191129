var wxbarcode = require("../../../../style/utils/index.js");

Page({
    data: {},
    onLoad: function(o) {
        wxbarcode.qrcode("qrcode", "11111111111", 360, 360);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getCode: function(o) {
        console.log(o), this.setData({
            code: o.detail.value
        });
    },
    toHx: function(o) {}
});