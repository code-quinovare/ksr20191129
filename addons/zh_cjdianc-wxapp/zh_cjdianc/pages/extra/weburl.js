var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        app.setNavigationBarColor(this), app.pageOnLoad(this), console.log(o);
        console.log(wx.getStorageSync("vr")), this.setData({
            vr: o.url
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {}
});