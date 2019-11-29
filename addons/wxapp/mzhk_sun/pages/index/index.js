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
        indexstyle: 999,
        imgUrls: [],
        url: "",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        activeList: [],
        activeList_two: [],
        welfareList: [],
        hklogo: "../../../style/images/hklogo.png",
        hkname: "首页",
        hk_bgimg: "",
        usersinfo: [],
        is_modal_Hidden: !0,
        searchCont: "",
        technical: {
            tech_img: "../../../style/images/support1.png",
            tech_title: "柚子团队出品",
            tech_phone: "0592-66666666"
        },
        operation: [ {
            title: "砍价",
            src: "../../../style/images/2.png",
            bind: "toBargain"
        }, {
            title: "集卡",
            src: "../../../style/images/1.png",
            bind: "toCards"
        }, {
            title: "抢购",
            src: "../../../style/images/3.png",
            bind: "toTimebuy"
        }, {
            title: "拼团",
            src: "../../../style/images/4.png",
            bind: "toGroup"
        }, {
            title: "专题",
            src: "../../../style/images/5.png",
            bind: "toNews"
        } ],
        page: 1,
        adimg: [],
        adflashimg: [],
        adtbbannerimg: [],
        haveadtbbannerimg: 0,
        adadoneimg: [],
        adadtwoimg: !1,
        adhomebuoy: [],
        showAd: 0,
        Popimg: [],
        showcheck: 0,
        tabBar_default: 2,
        otherApplets: [],
        is_hyopen: 2,
        whichone: 0,
        whichonetwo: 15,
        is_homeshow_circle: 0,
        bargain: [],
        sunburn: [],
        loadinghidden: app.globalData.loadinghidden,
        wxappletscode: "",
        showPublic: 0,
        wxappletscode_cache: ""
    },
    onLoad: function(e) {
        var g = this;
        e = app.func.decodeScene(e), g.setData({
            options: e
        });
        var u = app.getSiteUrl();
        u ? (app.editTabBar(u), g.setData({
            url: u
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                wx.setStorageSync("url", e.data), u = e.data, g.setData({
                    url: u
                });
            }
        })) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                wx.setStorageSync("url", e.data), u = e.data, app.editTabBar(u), g.setData({
                    url: u
                });
            }
        }), app.globalData.loadinghidden && g.setData({
            loadinghidden: !0
        });
        var a = wx.getStorageSync("goodskeyword");
        g.setData({
            kw: a
        }), app.wxauthSetting();
        wx.getStorageSync("System");
        app.util.request({
            url: "entry/wxapp/System",
            showLoading: app.globalData.loadinghidden,
            success: function(e) {
                wx.setStorageSync("System", e.data), wx.setNavigationBarColor({
                    frontColor: e.data.fontcolor ? e.data.fontcolor : "#000000",
                    backgroundColor: e.data.color ? e.data.color : "#ffffff",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                });
                var a = {
                    tech_img: u + e.data.tech_img,
                    tech_title: e.data.tech_title,
                    tech_phone: e.data.tech_phone,
                    is_show_tech: e.data.is_show_tech
                }, t = e.data.hk_logo ? e.data.hk_logo : "", o = e.data.hk_tubiao ? e.data.hk_tubiao : "", n = e.data.is_open_pop ? e.data.is_open_pop : 0, i = e.data.version ? e.data.version : "99999";
                if (i == app.siteInfo.version) var r = e.data.showcheck ? e.data.showcheck : 0; else if ("99999" == i) r = e.data.showcheck ? e.data.showcheck : 0; else r = 0;
                var s = e.data.is_homeshow_circle, d = e.data.hometheme ? e.data.hometheme : 0, c = e.data.home_circle_name ? e.data.home_circle_name : "";
                1 == d && 1 == s && app.util.request({
                    url: "entry/wxapp/GetIndexCircle",
                    showLoading: !1,
                    data: {
                        position: 1
                    },
                    success: function(e) {
                        2 != e.data && g.setData({
                            sunburn: e.data
                        });
                    }
                }), app.globalData.loadinghidden = !0;
                var p = e.data.wxappletscode ? u + e.data.wxappletscode : "";
                g.setData({
                    logo: t,
                    pt_name: o,
                    hk_bgimg: e.data.hk_bgimg ? e.data.hk_bgimg : "",
                    hk_namecolor: e.data.hk_namecolor ? e.data.hk_namecolor : "#f5ac32",
                    technical: a,
                    showAd: n,
                    showcheck: r,
                    indexstyle: d,
                    is_homeshow_circle: s,
                    home_circle_name: c,
                    loadinghidden: !0,
                    wxappletscode: p
                }), p && wx.getImageInfo({
                    src: p,
                    success: function(e) {
                        g.setData({
                            wxappletscode_cache: e.path
                        });
                    },
                    fail: function(e) {
                        console.log(e);
                    }
                });
            }
        }), wx.setNavigationBarTitle({
            title: wx.getStorageSync("System").pt_name ? wx.getStorageSync("System").pt_name : g.data.hkname
        }), app.util.request({
            url: "entry/wxapp/GetadData",
            showLoading: !1,
            data: {
                inpos: "1,2,8,10,11,13"
            },
            success: function(e) {
                var a = e.data;
                if (app.globalData.hasshowpopad ? g.setData({
                    showAd: 0
                }) : (app.globalData.hasshowpopad = !0, g.setData({
                    adimg: a.pop ? a.pop : []
                })), 2 != a) {
                    var t = 5;
                    if (a.tbbanner) {
                        var o = 1;
                        t = Math.ceil(a.tbbanner.length / 5);
                    } else o = 2;
                    var n = !1;
                    1 < t && (n = !0), console.log(t), app.globalData.loadinghidden = !0, g.setData({
                        adflashimg: a.flash ? a.flash : [],
                        adtbbannerimg: a.tbbanner ? a.tbbanner : [],
                        adadoneimg: a.adone ? a.adone : [],
                        adadtwoimg: !!a.adtwo && a.adtwo[0],
                        haveadtbbannerimg: o,
                        adhomebuoy: !!a.homebuoy && a.homebuoy[0],
                        loadinghidden: !0,
                        indicatorDots: n,
                        adtLen: t
                    });
                } else g.setData({
                    haveadtbbannerimg: 2
                });
            }
        }), g.getActive(), app.util.request({
            url: "entry/wxapp/GetOtherApplets",
            showLoading: !1,
            data: {
                position: 1
            },
            success: function(e) {
                g.setData({
                    otherApplets: e.data.wxappjump,
                    otherAppletsurl: e.data.url,
                    is_hyopen: e.data.is_hyopen
                });
            },
            fail: function(e) {}
        }), app.util.request({
            url: "entry/wxapp/CheckGroup",
            showLoading: !1,
            success: function(e) {}
        }), app.util.request({
            url: "entry/wxapp/CheckLottery",
            showLoading: !1,
            success: function(e) {}
        });
    },
    closeAd: function(e) {
        this.setData({
            showAd: !1
        });
    },
    closePublic: function(e) {
        this.setData({
            showPublic: 0
        });
    },
    publicimgsave: function() {
        var a = this;
        if ("" == a.data.wxappletscode_cache) return wx.showToast({
            title: "图片未加载完，请稍后",
            icon: "none",
            duration: 800
        }), !1;
        wx.saveImageToPhotosAlbum({
            filePath: a.data.wxappletscode_cache,
            success: function(e) {
                console.log("成功"), wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(e) {
                        e.confirm && (console.log("用户点击确定"), a.setData({
                            showPublic: 0
                        }));
                    }
                });
            },
            fail: function(e) {
                console.log(e), console.log("失败"), wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(e) {
                                console.log("openSetting success", e.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    GotootherApplets: function(e) {
        var a = this.data.otherApplets;
        wx.navigateToMiniProgram({
            appId: a.appid,
            path: a.path,
            extarData: {
                open: "auth"
            },
            envVersion: "develop",
            success: function(e) {
                console.log("跳转成功");
            },
            fail: function(e) {
                console.log("跳转失败");
            }
        });
    },
    goDetails: function(e) {
        wx.navigateTo({
            url: "psDetails/psDetails"
        });
    },
    formid_one: function(e) {
        app.util.request({
            url: "entry/wxapp/SaveFormid",
            showLoading: !1,
            cachetime: "0",
            data: {
                user_id: wx.getStorageSync("users").id,
                form_id: e.detail.formId,
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {}
        });
    },
    onShow: function() {
        app.func.islogin(app, this);
        var e = this.data.options;
        e.d_user_id && app.distribution.distribution_parsent(app, e.d_user_id), this.getFree(), 
        this.GetVip();
    },
    onReady: function() {},
    onUnload: function() {
        clearTimeout(app.globalData.timer_slideupshoworder);
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
                a.setData({
                    viptype: e.data
                });
            }
        });
    },
    onPullDownRefresh: function() {
        this.onShow(), wx.stopPullDownRefresh();
    },
    callphone: function(e) {
        var a = e.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    getUrl: function() {
        var a = this, t = app.getSiteUrl("index-get");
        t ? a.setData({
            url: t
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                wx.setStorageSync("url", e.data), t = e.data, a.setData({
                    url: t
                });
            }
        });
    },
    getActive: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Activity",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                for (var a = e.data.activeList, t = e.data.activeList_two, o = {}, n = 0; n < a.length; n++) (o = a[n]).n = 0, 
                a[n] = o;
                i.setData({
                    activeList: a,
                    activeList_two: t
                });
            }
        });
    },
    getFree: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Free",
            showLoading: !1,
            data: {
                page: 0
            },
            success: function(e) {
                2 == e.data ? a.setData({
                    welfareList: []
                }) : a.setData({
                    welfareList: e.data,
                    page: 1
                });
            }
        });
    },
    onReachBottom: function() {
        var t = this, o = t.data.page, n = t.data.welfareList;
        app.util.request({
            url: "entry/wxapp/Free",
            data: {
                page: o
            },
            success: function(e) {
                if (2 == e.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var a = e.data;
                    n = n.concat(a), t.setData({
                        welfareList: n,
                        page: o + 1
                    });
                }
            }
        });
    },
    onShareAppMessage: function(e) {
        return {
            path: "/mzhk_sun/pages/index/index?d_user_id=" + wx.getStorageSync("users").id
        };
    }
}, "callphone", function(e) {
    var a = e.currentTarget.dataset.phone;
    wx.makePhoneCall({
        phoneNumber: a
    });
}), _defineProperty(_Page, "toCards", function(e) {
    wx.navigateTo({
        url: "cards/cards"
    });
}), _defineProperty(_Page, "toBargain", function(e) {
    wx.navigateTo({
        url: "bargain/bargain"
    });
}), _defineProperty(_Page, "toTimebuy", function(e) {
    wx.navigateTo({
        url: "timebuy/timebuy"
    });
}), _defineProperty(_Page, "toGroup", function(e) {
    wx.navigateTo({
        url: "group/group"
    });
}), _defineProperty(_Page, "toMember", function(e) {
    wx.navigateTo({
        url: "../member/member"
    });
}), _defineProperty(_Page, "togroupdet", function(e) {
    wx.navigateTo({
        url: "groupdet/groupdet"
    });
}), _defineProperty(_Page, "tocardsdet", function(e) {
    wx.navigateTo({
        url: "cardsdet/cardsdet"
    });
}), _defineProperty(_Page, "toPackage", function(e) {
    wx.navigateTo({
        url: "package/package"
    });
}), _defineProperty(_Page, "toBardet", function(e) {
    wx.navigateTo({
        url: "bardet/bardet"
    });
}), _defineProperty(_Page, "toFree", function(e) {
    wx.navigateTo({
        url: "free/free"
    });
}), _defineProperty(_Page, "toNews", function() {
    wx.navigateTo({
        url: "news/news"
    });
}), _defineProperty(_Page, "putongbon", function(e) {
    var a = e.currentTarget.dataset.id;
    wx.navigateTo({
        url: "../index/goods/goods?gid=" + a
    });
}), _defineProperty(_Page, "ptbon", function(e) {
    var a = e.currentTarget.dataset.id;
    wx.navigateTo({
        url: "../index/groupdet/groupdet?id=" + a
    });
}), _defineProperty(_Page, "kjbon", function(e) {
    var a = e.currentTarget.dataset.id;
    console.log(a), wx.navigateTo({
        url: "../index/bardet/bardet?id=" + a
    });
}), _defineProperty(_Page, "qgbon", function(e) {
    var a = e.currentTarget.dataset.id;
    wx.navigateTo({
        url: "../index/package/package?id=" + a
    });
}), _defineProperty(_Page, "mdbon", function(e) {
    var a = e.currentTarget.dataset.id;
    wx.navigateTo({
        url: "../index/freedet/freedet?id=" + a
    });
}), _defineProperty(_Page, "jkbon", function(e) {
    var a = e.currentTarget.dataset.id;
    wx.navigateTo({
        url: "../index/cardsdet/cardsdet?gid=" + a
    });
}), _defineProperty(_Page, "toWelfare", function(e) {
    var a = e.currentTarget.dataset.id;
    console.log(a), wx.navigateTo({
        url: "welfare/welfare?id=" + a
    });
}), _defineProperty(_Page, "gotoadinfo", function(e) {
    var a = e.currentTarget.dataset.tid, t = e.currentTarget.dataset.id;
    app.func.gotourl(app, a, t, this);
}), _defineProperty(_Page, "gotoimgUrls", function(e) {
    var a = e.currentTarget.dataset.tyid, t = e.currentTarget.dataset.gid;
    console.log(a + "--" + t);
    var o = "";
    2 == a ? o = "/mzhk_sun/pages/index/bargain/bargain" : 3 == a ? o = "/mzhk_sun/pages/index/cards/cards" : 4 == a ? o = "/mzhk_sun/pages/index/timebuy/timebuy" : 5 == a ? o = "/mzhk_sun/pages/index/group/group" : 6 == a ? o = "/mzhk_sun/pages/index/shop/shop?id=" + t : 7 == a ? o = "/mzhk_sun/pages/index/bardet/bardet?id=" + t : 8 == a ? o = "/mzhk_sun/pages/index/cardsdet/cardsdet?id=" + t : 9 == a ? o = "/mzhk_sun/pages/index/package/package?id=" + t : 10 == a ? o = "/mzhk_sun/pages/index/groupdet/groupdet?id=" + t : 11 == a && (o = "/mzhk_sun/pages/index/welfare/welfare?id=" + t), 
    "" != o && wx.navigateTo({
        url: o
    });
}), _defineProperty(_Page, "gotopopurl", function(e) {
    var a = e.currentTarget.dataset.pop_urltype, t = e.currentTarget.dataset.pop_urltxt, o = "";
    2 == a ? o = "/mzhk_sun/pages/index/bargain/bargain" : 3 == a ? o = "/mzhk_sun/pages/index/cards/cards" : 4 == a ? o = "/mzhk_sun/pages/index/timebuy/timebuy" : 5 == a ? o = "/mzhk_sun/pages/index/group/group" : 6 == a ? o = "/mzhk_sun/pages/index/shop/shop?id=" + t : 7 == a ? o = "/mzhk_sun/pages/index/bardet/bardet?id=" + t : 8 == a ? o = "/mzhk_sun/pages/index/cardsdet/cardsdet?id=" + t : 9 == a ? o = "/mzhk_sun/pages/index/package/package?id=" + t : 10 == a ? o = "/mzhk_sun/pages/index/groupdet/groupdet?id=" + t : 11 == a && (o = "/mzhk_sun/pages/index/welfare/welfare?id=" + t), 
    "" != o && wx.navigateTo({
        url: o
    });
}), _defineProperty(_Page, "updateUserInfo", function(e) {
    app.wxauthSetting();
}), _defineProperty(_Page, "showSearch", function(e) {
    this.setData({
        showSearch: !0
    });
}), _defineProperty(_Page, "hideSearch", function(e) {
    this.setData({
        showSearch: !1
    });
}), _defineProperty(_Page, "onHide", function() {
    this.hideSearch();
}), _defineProperty(_Page, "getSearch", function(e) {
    this.setData({
        searchCont: e.detail.value
    });
}), _defineProperty(_Page, "searchkeyword", function(e) {
    var t = this, a = e.currentTarget.dataset.word;
    if ("" == a) return wx.showModal({
        title: "提示",
        content: "参数错误",
        showCancel: !1
    }), !1;
    var o = wx.getStorageSync("goodskeyword"), n = 0;
    if (o) {
        for (var i = [], r = [], s = 0, d = 0; d < o.length; d++) o[d] != a && (r[s] = o[d], 
        s++);
        n = 4 < r.length ? 4 : r.length;
        for (d = 0; d < n; d++) i[d] = r[d];
        i.unshift(a);
    } else i = [ a ];
    wx.setStorageSync("goodskeyword", i), t.setData({
        searchCont: a,
        kw: i
    }), app.util.request({
        url: "entry/wxapp/Actives",
        data: {
            gname: a
        },
        success: function(e) {
            console.log("活动数据"), console.log(e);
            var a = e.data;
            2 != a ? t.setData({
                bargain: a
            }) : t.setData({
                bargain: []
            });
        }
    });
}), _defineProperty(_Page, "commitSearch", function(e) {
    var t = this, a = this.data.searchCont;
    if ("" == a) return wx.showModal({
        title: "提示",
        content: "请输入要搜索的商品名称",
        showCancel: !1
    }), !1;
    var o = wx.getStorageSync("goodskeyword"), n = 0;
    if (console.log(o), o) {
        for (var i = [], r = [], s = 0, d = 0; d < o.length; d++) o[d] != a && (r[s] = o[d], 
        s++);
        n = 4 < r.length ? 4 : r.length;
        for (d = 0; d < n; d++) i[d] = r[d];
        i.unshift(a);
    } else i = [ a ];
    wx.setStorageSync("goodskeyword", i), t.setData({
        kw: i
    }), app.util.request({
        url: "entry/wxapp/Actives",
        data: {
            gname: a
        },
        success: function(e) {
            console.log("活动数据"), console.log(e);
            var a = e.data;
            2 != a ? t.setData({
                bargain: a
            }) : t.setData({
                bargain: []
            });
        }
    });
}), _Page));