var app = getApp();

function count_down(t, a, e) {
    parseInt(e);
    var i = t.data.bargainList, n = a - Date.parse(new Date());
    if (i[e].clock = date_format(n), n <= 0) return i[e].clock = "已经截止", void t.setData({
        bargainList: i
    });
    setTimeout(function() {
        n -= 100, count_down(t, t.data.bargainList[e].endTime, e);
    }, 100), t.setData({
        bargainList: i
    });
}

function date_format(t) {
    var a = Math.floor(t / 1e3), e = Math.floor(a / 3600 / 24), i = Math.floor((a - 60 * e * 60 * 24) / 3600), n = Math.floor(a / 3600), o = fill_zero_prefix(Math.floor((a - 3600 * n) / 60));
    return "距离结束还剩：" + e + "天" + i + "时" + o + "分" + fill_zero_prefix(a - 3600 * n - 60 * o) + "秒";
}

function fill_zero_prefix(t) {
    return t < 10 ? "0" + t : t;
}

Page({
    data: {
        showModalStatus: !1,
        activeList: [],
        kanjia: [],
        price: [],
        showstatu: "0",
        bargainList: [ {
            endTime: "1523519898765",
            clock: ""
        } ],
        is_modal_Hidden: !0,
        hostname: "",
        hostimg: "",
        helpuser: [],
        ishost: 0
    },
    onLoad: function(a) {
        var e = this;
        a = app.func.decodeScene(a);
        var i = app.getSiteUrl();
        i ? e.setData({
            url: i
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), i = t.data, e.setData({
                    url: i
                });
            }
        });
        var t = a.id;
        (t <= 0 || !t) && wx.showModal({
            title: "提示",
            content: "参数错误，获取不到商品，点击确认跳转到首页",
            showCancel: !1,
            success: function(t) {
                wx.reLaunch({
                    url: "/mzhk_sun/pages/index/index"
                });
            }
        }), e.setData({
            id: a.id,
            cs_id: a.cs_id
        }), wx.setNavigationBarTitle({
            title: e.data.navTile
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/KJdetails",
            cachetime: "30",
            method: "GET",
            data: {
                id: t
            },
            success: function(t) {
                console.log(t), e.setData({
                    activeList: t.data
                }), e.getUrl();
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1,
                    success: function(t) {
                        1 == a.is_share ? wx.redirectTo({
                            url: "/mzhk_sun/pages/index/bargain/bargain"
                        }) : wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        app.func.islogin(app, e);
        var i = wx.getStorageSync("openid"), t = e.data.cs_id, a = e.data.id;
        app.util.request({
            url: "entry/wxapp/IsHelp",
            cachetime: "0",
            data: {
                openid: i,
                cs_id: t,
                id: a
            },
            success: function(t) {
                console.log("砍价数据"), console.log(t.data);
                var a = 0;
                i == t.data.openid && (a = 1), e.setData({
                    join: t.data.status,
                    hostname: t.data.hostname,
                    hostimg: t.data.hostimg,
                    helpuser: t.data.helpuser,
                    ishost: a,
                    kanjia: t.data
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1,
                    success: function(t) {
                        1 == options.is_share ? wx.redirectTo({
                            url: "/mzhk_sun/pages/index/bargain/bargain"
                        }) : wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }
        });
    },
    getUrl: function() {
        var a = this, e = app.getSiteUrl();
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
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        console.log("分享");
        var a = this.data.activeList, e = a.gid, i = this.data.kanjia.cs_id, n = (a.biaoti ? a.biaoti + "：" : "") + a.gname;
        return "button" === t.from && console.log(t.target), {
            title: n,
            path: "/mzhk_sun/pages/index/help/help?id=" + e + "&cs_id=" + i + "&is_share=1",
            success: function(t) {
                console.log("转发成功");
            },
            fail: function(t) {
                console.log("转发失败");
            }
        };
    },
    order: function(t) {},
    bargain: function(t) {},
    power: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a);
    },
    powerDrawer: function(t) {
        var a = this, e = t.currentTarget.dataset.statu, i = a.data.activeList, n = (a.data.kanjia, 
        a.data.kanjia.openid), o = i.gid, s = a.data.cs_id, r = wx.getStorageSync("openid");
        return r ? r == n ? (wx.showToast({
            title: "您是砍主，每人只能砍一次哦",
            icon: "none"
        }), !1) : (app.util.request({
            url: "entry/wxapp/Help",
            data: {
                gid: o,
                cs_id: s,
                openid: r
            },
            success: function(t) {
                a.setData({
                    kanjia: t.data,
                    price: t.data.cutprice
                }), a.onShow();
            }
        }), void a.util(e)) : (app.wxauthSetting(), !1);
    },
    Drawer: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a);
        this.onShow();
    },
    util: function(t) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height("468rpx").step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    help: function(t) {
        wx.updateShareMenu({
            withShareTicket: !0,
            success: function() {}
        });
    },
    toDetail: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../bardet/bardet?id=" + a
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});