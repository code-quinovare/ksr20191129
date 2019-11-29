var app = getApp();

Page({
    data: {
        navTile: "好店推荐",
        curIndex: 0,
        nav: [ "好店推荐", "离我最近" ],
        goodsList: [],
        viptype: [],
        rangeList: [],
        hklogo: "../../../style/images/hklogo.png",
        hkname: "柚子黑卡",
        is_modal_Hidden: !0,
        page: 1,
        page_near: 1,
        lat: 0,
        lon: 0,
        store_id: 0,
        operation: [],
        member: [ "商家名称", "商家名称22222", "商家名称11", "商家名称2", "商家名称12" ],
        showModalStatus: 0,
        tabBar: app.globalData.tabBar,
        whichone: 2,
        whichonetwo: 17,
        searchCont: ""
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
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
            url: "entry/wxapp/GetStoreCate",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                console.log("获取商家分类数据"), console.log(t.data), 2 == t.data ? a.setData({
                    operation: []
                }) : a.setData({
                    operation: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetStoreInlog",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                2 == t.data ? a.setData({
                    member: []
                }) : a.setData({
                    member: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                console.log("获取系统数据"), console.log(t.data), a.setData({
                    logo: t.data.hk_logo ? t.data.hk_logo : "",
                    pt_name: t.data.hk_tubiao ? t.data.hk_tubiao : "",
                    hk_bgimg: t.data.hk_bgimg ? t.data.hk_bgimg : "",
                    hk_namecolor: t.data.hk_namecolor ? t.data.hk_namecolor : "#f5ac32",
                    store_in_name: t.data.store_in_name ? t.data.store_in_name : "",
                    store_open: t.data.store_open ? t.data.store_open : 0
                });
            }
        });
    },
    onShow: function() {
        var t = this, a = t.data.curIndex;
        app.func.islogin(app, t);
        var e = t.data.options;
        e.d_user_id && app.distribution.distribution_parsent(app, e.d_user_id), 0 == a && t.shopdata(), 
        t.GetVip();
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
    hidden: function(t) {
        this.setData({
            hidden: !0
        });
    },
    shopdata: function() {
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Shop",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                if (console.log("获取店铺数据"), console.log(t.data), 2 == t.data) {
                    a.setData({
                        goodsList: []
                    });
                } else a.setData({
                    goodsList: t.data
                });
                a.getUrl();
            }
        });
    },
    navTap: function(t) {
        var a, e, o = parseInt(t.currentTarget.dataset.index), n = this, s = wx.getStorageSync("openid"), i = n.data.store_id;
        1 == o ? wx.getLocation({
            type: "wgs84",
            success: function(t) {
                console.log("获取地址"), console.log(t), a = t.latitude, e = t.longitude, app.util.request({
                    url: "entry/wxapp/Shop",
                    data: {
                        openid: s,
                        typeid: o,
                        lat: a,
                        lon: e,
                        store_id: i
                    },
                    success: function(t) {
                        console.log("获取附近店铺数据"), console.log(t.data), 2 == t.data ? n.setData({
                            goodsList: [],
                            lat: a,
                            lon: e,
                            page_near: 1
                        }) : n.setData({
                            goodsList: t.data,
                            lat: a,
                            lon: e,
                            page_near: 1
                        }), n.getUrl();
                    }
                });
            },
            fail: function(t) {
                console.log("获取地址失败"), wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.userLocation"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(t) {
                                console.log("openSetting success", t.authSetting);
                            }
                        }));
                    }
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/Shop",
            cachetime: "30",
            data: {
                openid: s,
                store_id: i
            },
            success: function(t) {
                if (console.log("获取店铺数据"), console.log(t.data), 2 == t.data) {
                    n.setData({
                        goodsList: []
                    });
                } else n.setData({
                    goodsList: t.data,
                    page: 1
                });
                n.getUrl();
            }
        }), n.setData({
            curIndex: o
        });
    },
    toShop: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/shop/shop?id=" + a
        });
    },
    lingqu: function(t) {
        var a = this, e = t.currentTarget.dataset.id, o = t.currentTarget.dataset.isvip, n = (a.data.viptype, 
        t.currentTarget.dataset.f_index), s = t.currentTarget.dataset.s_index, i = a.data.goodsList, r = wx.getStorageSync("openid");
        if (1 == o) return wx.navigateTo({
            url: "/mzhk_sun/pages/index/welfare/welfare?id=" + e
        }), !1;
        app.util.request({
            url: "entry/wxapp/Counpadd",
            cachetime: "30",
            data: {
                id: e,
                openid: r
            },
            success: function(t) {
                console.log(t), i[n].coupons[s].is_has = !0, a.setData({
                    goodsList: i
                });
            }
        });
    },
    toMember: function(t) {
        wx.navigateTo({
            url: "../member/member"
        });
    },
    getUrl: function() {
        var t = app.getSiteUrl();
        this.setData({
            url: t
        });
    },
    onHide: function() {
        this.setData({
            page: 1,
            page_near: 1
        });
    },
    onReady: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this, o = e.data.curIndex, t = wx.getStorageSync("openid"), a = e.data.store_id, n = e.data.goodsList, s = e.data.lat, i = e.data.lon;
        if (1 == o) var r = e.data.page_near; else r = e.data.page;
        app.util.request({
            url: "entry/wxapp/Shop",
            cachetime: "0",
            data: {
                openid: t,
                typeid: o,
                lat: s,
                lon: i,
                page: r,
                store_id: a
            },
            success: function(t) {
                if (console.log("获取店铺数据"), 2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var a = t.data;
                    n = n.concat(a), 1 == o ? e.setData({
                        goodsList: n,
                        page_near: r + 1
                    }) : e.setData({
                        goodsList: n,
                        page: r + 1
                    });
                }
                e.getUrl();
            }
        });
    },
    toClassify: function(t) {
        var a = this, e = a.data.curIndex, o = wx.getStorageSync("openid"), n = t.currentTarget.dataset.id, s = a.data.lat, i = a.data.lon;
        app.util.request({
            url: "entry/wxapp/Shop",
            cachetime: "0",
            data: {
                openid: o,
                typeid: e,
                lat: s,
                lon: i,
                store_id: n
            },
            success: function(t) {
                console.log("获取店铺数据"), 2 == t.data ? a.setData({
                    goodsList: [],
                    page_near: 1,
                    page: 1,
                    store_id: n
                }) : a.setData({
                    goodsList: t.data,
                    page_near: 1,
                    page: 1,
                    store_id: n
                }), a.getUrl();
            }
        });
    },
    onShareAppMessage: function() {
        return {
            path: "/mzhk_sun/pages/goods/goods?d_user_id=" + wx.getStorageSync("users").id
        };
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    toApply: function(t) {
        var a = t.currentTarget.dataset.statu, e = wx.getStorageSync("openid"), o = this;
        app.util.request({
            url: "entry/wxapp/GetstoreNotice",
            cachetime: "30",
            data: {
                openid: e
            },
            success: function(t) {
                o.setData({
                    storenotice: t.data.data.notice,
                    showModalStatus: a
                });
            }
        });
    },
    showSearch: function(t) {
        this.setData({
            showSearch: !0
        });
    },
    hideSearch: function(t) {
        this.setData({
            showSearch: !1
        });
    },
    getSearch: function(t) {
        this.setData({
            searchCont: t.detail.value
        });
    },
    searchkeyword: function(t) {
        var e = this, a = t.currentTarget.dataset.word;
        if ("" == a) return wx.showModal({
            title: "提示",
            content: "参数错误",
            showCancel: !1
        }), !1;
        var o = wx.getStorageSync("shopkeyword"), n = 0;
        if (o) {
            for (var s = [], i = [], r = 0, c = 0; c < o.length; c++) o[c] != a && (i[r] = o[c], 
            r++);
            n = 4 < i.length ? 4 : i.length;
            for (c = 0; c < n; c++) s[c] = i[c];
            s.unshift(a);
        } else s = [ a ];
        wx.setStorageSync("shopkeyword", s), e.setData({
            searchCont: a,
            skw: s
        }), app.util.request({
            url: "entry/wxapp/Shop",
            data: {
                bname: a
            },
            success: function(t) {
                console.log("活动数据"), console.log(t);
                var a = t.data;
                2 != a ? e.setData({
                    bargain: a
                }) : e.setData({
                    bargain: []
                });
            }
        });
    },
    commitSearch: function(t) {
        var e = this, a = (wx.getStorageSync("openid"), this.data.searchCont);
        if ("" == a) return wx.showModal({
            title: "提示",
            content: "请输入要搜索的店铺名称",
            showCancel: !1
        }), !1;
        var o = wx.getStorageSync("shopkeyword"), n = 0;
        if (o) {
            for (var s = [], i = [], r = 0, c = 0; c < o.length; c++) o[c] != a && (i[r] = o[c], 
            r++);
            n = 4 < i.length ? 4 : i.length;
            for (c = 0; c < n; c++) s[c] = i[c];
            s.unshift(a);
        } else s = [ a ];
        wx.setStorageSync("shopkeyword", s), e.setData({
            searchCont: a,
            skw: s
        }), app.util.request({
            url: "entry/wxapp/Shop",
            data: {
                bname: a
            },
            success: function(t) {
                console.log("店铺数据"), console.log(t);
                var a = t.data;
                2 != a ? e.setData({
                    bargain: a
                }) : e.setData({
                    bargain: []
                });
            }
        });
    }
});