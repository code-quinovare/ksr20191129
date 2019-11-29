var app = getApp();

Page({
    data: {
        navTile: "活动推荐",
        curIndex: 0,
        nav: [ "正在进行", "往期活动" ],
        activeList: [],
        url: [],
        viptype: [],
        hklogo: "../../../style/images/hklogo.png",
        hkname: "柚子黑卡",
        oldActiveList: [],
        ActivePage: 1,
        oldActivePage: 1,
        is_modal_Hidden: !0,
        tabBar: app.globalData.tabBar,
        whichone: 1,
        whichonetwo: 16
    },
    onLoad: function(t) {
        var a = this;
        t = app.func.decodeScene(t), a.setData({
            options: t
        }), wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = app.getSiteUrl();
        e ? (a.setData({
            url: e
        }), app.editTabBar(e)) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                wx.setStorageSync("url", t.data), e = t.data, app.editTabBar(e), a.setData({
                    url: e
                });
            }
        }), app.wxauthSetting(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            success: function(t) {
                console.log(t), a.setData({
                    logo: t.data.hk_logo ? t.data.hk_logo : "",
                    pt_name: t.data.hk_tubiao ? t.data.hk_tubiao : "",
                    hk_bgimg: t.data.hk_bgimg ? t.data.hk_bgimg : "",
                    hk_namecolor: t.data.hk_namecolor ? t.data.hk_namecolor : "#f5ac32"
                });
            }
        });
    },
    onReady: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Actives",
            cachetime: "30",
            success: function(t) {
                console.log(t), 2 == t.data ? a.setData({
                    activeList: []
                }) : a.setData({
                    activeList: t.data
                }), a.GetVip();
            }
        });
    },
    onShow: function() {
        app.func.islogin(app, this);
        var t = this.data.options;
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id);
    },
    gotoadinfo: function(t) {
        var a = t.currentTarget.dataset.tid, e = t.currentTarget.dataset.id;
        app.func.gotourl(app, a, e);
    },
    GetVip: function() {
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            showLoading: !1,
            data: {
                openid: t
            },
            success: function(t) {
                console.log("获取vip数据"), console.log(t), a.setData({
                    viptype: t.data
                });
            }
        });
    },
    getUrl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            showLoading: !1,
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this;
        if (1 == e.data.curIndex) {
            var n = e.data.oldActiveList, o = e.data.oldActivePage;
            app.util.request({
                url: "entry/wxapp/OldActives",
                cachetime: "30",
                data: {
                    page: o
                },
                success: function(t) {
                    if (console.log(t), 2 == t.data) wx.showToast({
                        title: "已经没有内容了哦！！！",
                        icon: "none"
                    }); else {
                        var a = t.data;
                        n = n.concat(a), e.setData({
                            oldActiveList: n,
                            oldActivePage: o + 1
                        });
                    }
                }
            });
        } else {
            var i = e.data.activeList, r = e.data.ActivePage;
            console.log(123456789), console.log(r), app.util.request({
                url: "entry/wxapp/Actives",
                cachetime: "30",
                data: {
                    page: r
                },
                success: function(t) {
                    if (console.log(t), 2 == t.data) wx.showToast({
                        title: "已经没有内容了哦！！！",
                        icon: "none"
                    }); else {
                        var a = t.data;
                        i = i.concat(a), e.setData({
                            activeList: i,
                            ActivePage: r + 1
                        });
                    }
                }
            });
        }
    },
    onShareAppMessage: function() {
        return {
            path: "/mzhk_sun/pages/active/active?d_user_id=" + wx.getStorageSync("users").id
        };
    },
    navTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index);
        if (1 == a) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/OldActives",
                cachetime: "30",
                showLoading: !1,
                success: function(t) {
                    e.setData({
                        oldActiveList: t.data
                    }), e.getUrl();
                }
            });
        }
        this.setData({
            curIndex: a
        });
    },
    ptbon: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/groupdet/groupdet?id=" + a
        });
    },
    kjbon: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/bardet/bardet?id=" + a
        });
    },
    qgbon: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/package/package?id=" + a
        });
    },
    mdbon: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/freedet/freedet?id=" + a
        });
    },
    jkbon: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/cardsdet/cardsdet?gid=" + a
        });
    },
    hybon: function(t) {
        var a = t.currentTarget.dataset.id;
        console.log(a), wx.navigateTo({
            url: "../index/welfare/welfare?id=" + a
        });
    },
    togroupdet: function(t) {
        wx.navigateTo({
            url: "../index/groupdet/groupdet"
        });
    },
    tocardsdet: function(t) {
        wx.navigateTo({
            url: "../index/cardsdet/cardsdet"
        });
    },
    topackage: function(t) {
        wx.navigateTo({
            url: "../index/package/package"
        });
    },
    tobardet: function(t) {
        wx.navigateTo({
            url: "../index/bardet/bardet"
        });
    },
    toMember: function(t) {
        wx.navigateTo({
            url: "../member/member"
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});