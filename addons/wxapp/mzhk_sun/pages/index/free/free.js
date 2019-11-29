var app = getApp();

Page({
    data: {
        navTile: "我要免单",
        banner: "",
        curList: [],
        page: 1,
        is_modal_Hidden: !0,
        adflashimg: []
    },
    onLoad: function(t) {
        var e = this, a = app.getSiteUrl();
        a ? (e.setData({
            url: a
        }), app.editTabBar(a)) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a = t.data, app.editTabBar(a), e.setData({
                    url: a
                });
            }
        }), app.wxauthSetting(), wx.setNavigationBarTitle({
            title: e.data.navTile
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor ? wx.getStorageSync("System").fontcolor : "",
            backgroundColor: wx.getStorageSync("System").color ? wx.getStorageSync("System").color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/QGactive",
            data: {
                showtype: 6
            },
            success: function(t) {
                console.log("获取免单数据成功"), console.log(t.data), 2 == t.data ? e.setData({
                    curList: []
                }) : e.setData({
                    curList: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetadData",
            cachetime: "30",
            data: {
                position: 7
            },
            success: function(t) {
                console.log("11111"), console.log(t.data);
                var a = t.data;
                e.setData({
                    adflashimg: a
                });
            }
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "../index"
        });
    },
    gotoadinfo: function(t) {
        var a = t.currentTarget.dataset.tid, e = t.currentTarget.dataset.id;
        app.func.gotourl(app, a, e);
    },
    formid_one: function(t) {
        console.log("搜集第一个formid"), console.log(t), app.util.request({
            url: "entry/wxapp/SaveFormid",
            cachetime: "0",
            data: {
                user_id: wx.getStorageSync("users").id,
                form_id: t.detail.formId,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {}
        });
    },
    onReady: function() {},
    onShow: function() {
        app.func.islogin(app, this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this, o = e.data.page, n = e.data.curList;
        console.log(o), app.util.request({
            url: "entry/wxapp/QGactive",
            cachetime: "30",
            data: {
                page: o,
                showtype: 6
            },
            success: function(t) {
                if (console.log("活动数据"), console.log(t.data), 2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var a = t.data;
                    n = n.concat(a), e.setData({
                        curList: n,
                        page: o + 1
                    });
                }
            }
        });
    },
    onShareAppMessage: function() {},
    toFreedet: function(t) {
        var a = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../freedet/freedet?id=" + a
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});