var _Page;

function _defineProperty(e, a, t) {
    return a in e ? Object.defineProperty(e, a, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[a] = t, e;
}

var app = getApp();

Page((_defineProperty(_Page = {
    data: {
        viptype: [],
        navTile: "我的",
        showModalStatus: 0,
        hklogo: "../../../style/images/hklogo.png",
        hkname: "柚子黑卡",
        storenotice: "须知",
        is_modal_Hidden: !0,
        storeinopen: !0,
        tabBar: app.globalData.tabBar,
        whichone: 3,
        whichonetwo: 18,
        userStyle: 999,
        mybanner: "",
        isopen_recharge: 0,
        open_distribution: !1,
        eatvisit_set: [],
        commonOrder: [ {
            name: "待付款",
            icon: "../../../style/images/icon03.png",
            tab: "1"
        }, {
            name: "待使用",
            icon: "../../../style/images/icon04.png",
            tab: "2"
        }, {
            name: "待收货",
            icon: "../../../style/images/icon05.png",
            tab: "3"
        }, {
            name: "完成/售后",
            icon: "../../../style/images/icon06.png",
            tab: "4"
        } ],
        navigate: [ {
            name: "普通订单",
            icon: "../../../style/images/icon016.png",
            bind: "toOrder"
        }, {
            name: "我的拼团",
            icon: "../../../style/images/icon07.png",
            bind: "toGroup"
        }, {
            name: "砍价订单",
            icon: "../../../style/images/icon08.png",
            bind: "toBargain"
        }, {
            name: "集卡订单",
            icon: "../../../style/images/icon09.png",
            bind: "tocardcollect"
        }, {
            name: "抢购订单",
            icon: "../../../style/images/icon010.png",
            bind: "toMyOrder"
        }, {
            name: "我的免单",
            icon: "../../../style/images/icon011.png",
            bind: "tofreeorder"
        }, {
            name: "我的福利",
            icon: "../../../style/images/icon012.png",
            bind: "toWelfare"
        } ]
    },
    onLoad: function(e) {
        var n = this;
        wx.setNavigationBarTitle({
            title: n.data.navTile
        });
        var o = app.getSiteUrl();
        o ? (n.setData({
            url: o
        }), app.editTabBar(o)) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                wx.setStorageSync("url", e.data), o = e.data, app.editTabBar(o), n.setData({
                    url: o
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
            showLoading: !1,
            success: function(e) {
                console.log(e), n.setData({
                    logo: e.data.hk_logo ? e.data.hk_logo : "",
                    pt_name: e.data.hk_tubiao ? e.data.hk_tubiao : "",
                    hk_bgimg: e.data.hk_bgimg ? e.data.hk_bgimg : "",
                    hk_namecolor: e.data.hk_namecolor ? e.data.hk_namecolor : "#f5ac32",
                    store_in_name: e.data.store_in_name ? e.data.store_in_name : "",
                    store_open: e.data.store_open ? e.data.store_open : 0,
                    hk_mytitle: e.data.hk_mytitle ? e.data.hk_mytitle : "会员卡专属特权•专属商品•折上折",
                    hk_mybgimg: e.data.hk_mybgimg ? o + e.data.hk_mybgimg : "",
                    userStyle: e.data.mytheme ? e.data.mytheme : 0,
                    isopen_recharge: e.data.isopen_recharge ? e.data.isopen_recharge : 0
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetadData",
            showLoading: !1,
            data: {
                inpos: "14"
            },
            success: function(e) {
                var a, t = e.data;
                2 != t ? (a = t.mybanner ? o + t.mybanner[0].pop_img : "../../../style/images/headbg.png", 
                n.setData({
                    mybanner: a
                })) : n.setData({
                    mybanner: "../../../style/images/headbg.png"
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 1
            },
            showLoading: !1,
            success: function(e) {
                var a = 2 != e.data && e.data;
                console.log("分销"), console.log(e.data), n.setData({
                    open_distribution: a
                });
            }
        }), app.util.request({
            url: "entry/wxapp/CheckGroup",
            showLoading: !1,
            success: function(e) {
                console.log("成功"), console.log(e.data);
            }
        });
    },
    onReady: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 2
            },
            showLoading: !1,
            success: function(e) {
                var a = e.data;
                2 != a && t.setData({
                    eatvisit_set: a
                });
            }
        });
    },
    gotoadinfo: function(e) {
        var a = e.currentTarget.dataset.tid, t = e.currentTarget.dataset.id;
        app.func.gotourl(app, a, t);
    },
    onShow: function() {
        var a = this;
        app.func.islogin(app, a), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                wx.setStorageSync("url", e.data), a.setData({
                    url: e.data
                });
            }
        }), a.GetVip();
    },
    GetVip: function() {
        var a = this, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            showLoading: !1,
            data: {
                openid: e
            },
            success: function(e) {
                console.log("获取vip数据"), console.log(e), a.setData({
                    viptype: e.data
                });
            }
        });
    },
    onHide: function() {
        this.setData({
            showModalStatus: 0
        });
    },
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toMyOrder: function(e) {
        wx.navigateTo({
            url: "myorder/myorder?tab=0"
        });
    },
    toOrder: function(e) {
        wx.navigateTo({
            url: "order/order?tab=0"
        });
    },
    toAwaitOrder: function(e) {
        wx.navigateTo({
            url: "order/order?tab=1"
        });
    },
    toShipOrder: function(e) {
        wx.navigateTo({
            url: "order/order?tab=2"
        });
    },
    toFinishOrder: function(e) {
        wx.navigateTo({
            url: "order/order?tab=3"
        });
    },
    toWelfare: function(e) {
        wx.navigateTo({
            url: "welfare/welfare"
        });
    },
    toGroup: function(e) {
        wx.navigateTo({
            url: "mygroup/mygroup"
        });
    },
    tocardcollect: function(e) {
        wx.navigateTo({
            url: "mycardcollect/mycardcollect"
        });
    },
    toBargain: function(e) {
        wx.navigateTo({
            url: "mybargain/mybargain"
        });
    },
    tofreeorder: function(e) {
        wx.navigateTo({
            url: "myfreeorder/myfreeorder"
        });
    },
    toApply: function(e) {
        wx.navigateTo({
            url: "apply/apply"
        });
    },
    toMember: function(e) {
        wx.navigateTo({
            url: "../member/member"
        });
    },
    scanCode: function(e) {
        wx.scanCode({
            success: function(e) {
                console.log("扫描获取数据-成功"), console.log(e);
                var a = "pay/pay?bid=" + JSON.parse(e.result).bid;
                wx.navigateTo({
                    url: a
                });
            }
        });
    },
    showModel: function(e) {
        var a = e.currentTarget.dataset.statu, t = wx.getStorageSync("openid"), n = this;
        app.util.request({
            url: "entry/wxapp/GetstoreNotice",
            cachetime: "30",
            data: {
                openid: t
            },
            success: function(e) {
                console.log("须知内容"), console.log(e.data), n.setData({
                    storenotice: e.data.data.notice,
                    showModalStatus: a
                });
            }
        });
    }
}, "toMember", function(e) {
    wx.navigateTo({
        url: "../member/member"
    });
}), _defineProperty(_Page, "toBackstage", function(e) {
    var a = wx.getStorageSync("openid");
    console.log("商家管理入口"), app.util.request({
        url: "entry/wxapp/CheckBrandUser",
        cachetime: "0",
        data: {
            openid: a
        },
        success: function(e) {
            console.log("商家数据"), console.log(e.data), e.data ? (wx.setStorageSync("brand_info", e.data.data), 
            app.globalData.islogin = 1, wx.navigateTo({
                url: "/mzhk_sun/pages/backstage/index2/index2"
            })) : wx.navigateTo({
                url: "/mzhk_sun/pages/backstage/backstage"
            });
        },
        fail: function(e) {
            var a = wx.getStorageSync("loginname");
            console.log("非绑定登陆，获取登陆信息"), console.log(a), a ? wx.navigateTo({
                url: "/mzhk_sun/pages/backstage/index2/index2"
            }) : wx.navigateTo({
                url: "/mzhk_sun/pages/backstage/backstage"
            });
        }
    });
}), _defineProperty(_Page, "updateUserInfo", function(e) {
    console.log("授权操作更新");
    app.wxauthSetting();
}), _defineProperty(_Page, "toMember", function(e) {
    wx.navigateTo({
        url: "../member/member"
    });
}), _defineProperty(_Page, "toFxCenter", function(e) {
    this.data.open_distribution;
    var a = wx.getStorageSync("openid"), t = e.detail.formId, n = wx.getStorageSync("users");
    app.util.request({
        url: "entry/wxapp/IsPromoter",
        data: {
            openid: a,
            form_id: t,
            uid: n.id,
            status: 3,
            m: app.globalData.Plugin_distribution
        },
        showLoading: !1,
        success: function(e) {
            e && 9 != e.data ? 0 == e.data ? wx.navigateTo({
                url: "/mzhk_sun/plugin/distribution/fxAddShare/fxAddShare"
            }) : wx.navigateTo({
                url: "/mzhk_sun/plugin/distribution/fxCenter/fxCenter"
            }) : wx.navigateTo({
                url: "/mzhk_sun/plugin/distribution/fxAddShare/fxAddShare"
            });
        }
    });
}), _defineProperty(_Page, "toCharge", function(e) {
    wx.navigateTo({
        url: "/mzhk_sun/pages/user/recharge/recharge"
    });
}), _defineProperty(_Page, "toEat", function(e) {
    wx.navigateTo({
        url: "/mzhk_sun/plugin/eatvisit/mycoupon/mycoupon"
    });
}), _Page));