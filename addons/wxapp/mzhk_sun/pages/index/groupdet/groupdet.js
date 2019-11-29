var app = getApp(), tool = require("../../../../style/utils/countDown.js"), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        id: "",
        navTile: "活动详情",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        activeList: [],
        lingshou: [],
        active: [],
        guess: [],
        curIndex: 0,
        nav: [ "商品详情" ],
        bargainList: [ {
            endTime: "1523519898765",
            clock: ""
        } ],
        isend: 1,
        is_modal_Hidden: !0,
        viptype: "0",
        hidden: !0,
        swiperIndex: 1,
        showgw: 0,
        wglist: [],
        wg_flag: 0,
        isendtitle: "",
        isloadWxParse: !1
    },
    onLoad: function(t) {
        var e = this;
        t = app.func.decodeScene(t), e.setData({
            options: t
        }), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var a = t.id;
        if (a <= 0 || !a) return wx.showModal({
            title: "提示",
            content: "参数错误，获取不到商品，点击确认跳转到首页",
            showCancel: !1,
            success: function(t) {
                wx.reLaunch({
                    url: "/mzhk_sun/pages/index/index"
                });
            }
        }), !1;
        app.wxauthSetting(), e.setData({
            id: t.id
        });
        var n = app.getSiteUrl();
        n ? e.setData({
            url: n
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                wx.setStorageSync("url", t.data), n = t.data, e.setData({
                    url: n
                });
            }
        });
        var o = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: o.fontcolor ? o.fontcolor : "",
            backgroundColor: o.color ? o.color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var i = o.showgw;
        if (1 == i) {
            var s = {
                wg_title: o.wg_title,
                wg_directions: o.wg_directions,
                wg_img: o.wg_img,
                wg_keyword: o.wg_keyword,
                wg_addicon: o.wg_addicon
            };
            e.setData({
                showgw: i,
                wglist: s
            });
        }
    },
    showwgtable: function(t) {
        var e = t.currentTarget.dataset.flag;
        this.setData({
            wg_flag: e
        });
    },
    onReady: function() {},
    onShow: function() {
        var s = this;
        app.func.islogin(app, s), (e = s.data.options).d_user_id && app.distribution.distribution_parsent(app, e.d_user_id);
        var e = s.data.options;
        app.util.request({
            url: "entry/wxapp/UpdateGoods",
            showLoading: !1,
            data: {
                id: s.data.id,
                typeid: 1
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        });
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: t
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                console.log("vip"), console.log(t.data), s.setData({
                    viptype: t.data.viptype
                });
            }
        });
        var r = s.data.isend;
        app.util.request({
            url: "entry/wxapp/PTdetails",
            cachetime: "30",
            showLoading: !1,
            method: "GET",
            data: {
                id: s.data.id
            },
            success: function(t) {
                wx.setStorageSync("groupgoods" + t.data.gid, t.data), console.log("详情"), console.log(t.data), 
                s.setData({
                    activeList: t.data
                });
                var e = t.data.content;
                s.data.isloadWxParse || (s.setData({
                    isloadWxParse: !0
                }), WxParse.wxParse("content", "html", e, s, 10));
                var a, n = t.data, o = tool.countDown(s, n.enftime);
                o ? (n.clock = "离结束剩：" + o[0] + "天" + o[1] + "时" + o[3] + "分" + o[4] + "秒", a = "", 
                r = 0) : (n.clock = "已经截止", a = "已经结束", r = 1), s.setData({
                    activeList: n,
                    isend: r,
                    isendtitle: a
                });
                var i = setInterval(function() {
                    var t = tool.countDown(s, n.enftime);
                    t ? (n.clock = "离结束剩：" + t[0] + "天" + t[1] + "时" + t[3] + "分" + t[4] + "秒", a = "", 
                    r = 0) : (n.clock = "已经截止", a = "已经结束", clearInterval(i), r = 1), s.setData({
                        activeList: n,
                        isend: r,
                        isendtitle: a
                    });
                }, 1e3);
                s.gerdange();
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1,
                    success: function(t) {
                        1 == e.is_share ? wx.redirectTo({
                            url: "/mzhk_sun/pages/index/group/group"
                        }) : wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }
        });
    },
    thegrouptime: function(t) {
        var e = tool.countDown(this, t.enftime);
        e ? (t.clock = "离结束剩：" + e[0] + "天" + e[1] + "时" + e[3] + "分" + e[4] + "秒", isend = 0) : (t.clock = "已经截止", 
        clearInterval(cdInterval), isend = 1), this.setData({
            activeList: t,
            isend: isend
        });
    },
    toMember: function(t) {
        wx.navigateTo({
            url: "../../member/member"
        });
    },
    getUrl: function() {
        var e = this, a = app.getSiteUrl();
        a ? e.setData({
            url: a
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                wx.setStorageSync("url", t.data), a = t.data, e.setData({
                    url: a
                });
            }
        });
    },
    dialogue: function(t) {
        var e = t.currentTarget.dataset.phone;
        console.log(e), wx.makePhoneCall({
            phoneNumber: e
        });
    },
    hidden: function(t) {
        this.setData({
            hidden: !0
        });
    },
    save: function() {
        var e = this;
        wx.saveImageToPhotosAlbum({
            filePath: e.data.prurl,
            success: function(t) {
                wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(t) {
                        t.confirm && (console.log("用户点击确定"), e.setData({
                            hidden: !0
                        }));
                    }
                });
            },
            fail: function(t) {
                console.log("失败"), wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(t) {
                                console.log("openSetting success", t.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    shareCanvas: function() {
        var t = this.data.activeList, e = [];
        e.gid = t.gid, e.bname = t.gname, e.url = this.data.url, e.logo = t.lb_imgs[0], 
        e.shopprice = t.shopprice, e.ptprice = t.ptprice;
        var a = wx.getStorageSync("users");
        e.scene = "d_user_id=" + a.id + "&id=" + this.data.id, app.creatPoster("mzhk_sun/pages/index/groupdet/groupdet", 430, e, 2, "shareImg");
    },
    max: function(t) {
        var e = t.currentTarget.dataset.address, a = Number(t.currentTarget.dataset.longitude), n = Number(t.currentTarget.dataset.latitude);
        if (0 == a && 0 == n) return wx.showToast({
            title: "该地址有问题，可能无法显示~",
            icon: "none",
            duration: 1e3
        }), !1;
        wx.openLocation({
            name: e,
            latitude: n,
            longitude: a,
            scale: 18,
            address: e
        });
    },
    gerdange: function() {
        var e = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/danpin",
            showLoading: !1,
            cachetime: "30",
            method: "GET",
            data: {
                id: e.data.id,
                openid: t
            },
            success: function(t) {
                console.log("团单数据"), console.log(t), e.setData({
                    lingshou: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {
        clearTimeout(app.globalData.timer_slideupshoworder);
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        console.log("分享");
        var t = this, e = t.data.url, a = t.data.activeList;
        app.util.request({
            url: "entry/wxapp/UpdateGoods",
            showLoading: !1,
            data: {
                id: t.data.id,
                typeid: 2
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        });
        var n = (t.data.activeList.biaoti ? t.data.activeList.biaoti + "：" : "") + t.data.activeList.gname, o = wx.getStorageSync("users");
        return {
            title: n,
            path: "/mzhk_sun/pages/index/groupdet/groupdet?id=" + t.data.id + "&is_share=1&d_user_id=" + o.id,
            imageUrl: e + a.lb_imgs[0]
        };
    },
    index: function(t) {
        wx.reLaunch({
            url: "../index"
        });
    },
    Alone: function(t) {
        var e = t.currentTarget.dataset.id, a = t.currentTarget.dataset.price;
        if (this.data.isend) return wx.showModal({
            title: "提示信息",
            content: "该拼团商品已结束！！！",
            showCancel: !1
        }), !1;
        var n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/CheckGoodsStatus",
            cachetime: "0",
            data: {
                gid: e,
                openid: n,
                ltype: 1
            },
            success: function(t) {
                console.log(t.data), wx.navigateTo({
                    url: "../../member/ptorder/ptorder?id=" + e + "&price=" + a + "&buytype=1"
                });
            },
            fail: function(t) {
                return wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1
                }), !1;
            }
        });
    },
    groups: function(t) {
        var e = t.currentTarget.dataset.id, a = this.data.isend, n = wx.getStorageSync("openid");
        if (a) return wx.showModal({
            title: "提示信息",
            content: "该拼团商品已结束！！！",
            showCancel: !1
        }), !1;
        app.util.request({
            url: "entry/wxapp/CheckGoodsStatus",
            cachetime: "0",
            data: {
                gid: e,
                openid: n,
                ltype: 1
            },
            success: function(t) {
                console.log(t.data), wx.navigateTo({
                    url: "../../member/ptorder/ptorder?id=" + e
                });
            },
            fail: function(t) {
                return wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1
                }), !1;
            }
        });
    },
    gopt: function(t) {
        var e = t.currentTarget.dataset.id, a = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../../index/goCantuan/goCantuan?id=" + e + "&gid=" + a
        });
    },
    navTap: function(t) {
        var e = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: e
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    swiperChange: function(t) {
        this.setData({
            swiperIndex: t.detail.current + 1
        });
    }
});