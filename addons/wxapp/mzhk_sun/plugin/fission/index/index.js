Page({
    data: {
        list: [ {
            pic: "http://wx4.sinaimg.cn/small/005ysW6agy1ftkrhn7x33j306o0500ue.jpg",
            title: "这是不同的状态",
            desc: "内容啊内容啊内容啊内容啊内容啊",
            price: "11.00",
            old_price: "20.00",
            status: 1
        }, {
            pic: "http://wx4.sinaimg.cn/small/005ysW6agy1ftkrhn7x33j306o0500ue.jpg",
            title: "标题啊标题啊",
            desc: "内容啊内容啊内容啊内容啊内容啊",
            price: "11.00",
            old_price: "20.00",
            status: 0
        } ]
    },
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    navTap: function(n) {
        var t = parseInt(n.currentTarget.dataset.index);
        this.setData({
            curIndex: t
        });
    },
    toDetail: function(n) {
        wx.navigateTo({
            url: "/mzhk_sun/plugin/fission/detail/detail"
        });
    },
    toIndex: function(n) {
        wx.redirectTo({
            url: "/mzhk_sun/pages/index/index"
        });
    }
});