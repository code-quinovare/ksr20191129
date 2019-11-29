var app = getApp(), tool = require("../../../../style/utils/countDown.js"), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        kanjia: [],
        activeList: [],
        navTile: "套餐详情",
        showModalStatus: !1,
        imgsrc: "",
        bargainList: [ {
            endTime: "1523519898765",
            clock: ""
        } ],
        is_modal_Hidden: !0,
        viptype: "0",
        hidden: !0,
        showStatus: !0,
        thumb: "",
        nickname: "",
        swiperIndex: 1,
        showgw: 0,
        wglist: [],
        wg_flag: 0
    },
    onLoad: function(e) {
        var a = this, t = (e = app.func.decodeScene(e)).id;
        if (t <= 0 || !t) return wx.showModal({
            title: "提示",
            content: "参数错误，获取不到商品，点击确认跳转到首页",
            showCancel: !1,
            success: function(t) {
                wx.reLaunch({
                    url: "/mzhk_sun/pages/index/index"
                });
            }
        }), !1;
        a.setData({
            id: e.id,
            options: e
        });
        var o = app.getSiteUrl();
        o ? a.setData({
            url: o
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), o = t.data, a.setData({
                    url: o
                });
            }
        }), wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var n = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: n.fontcolor ? n.fontcolor : "",
            backgroundColor: n.color ? n.color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var i = n.showgw;
        if (1 == i) {
            var s = {
                wg_title: n.wg_title,
                wg_directions: n.wg_directions,
                wg_img: n.wg_img,
                wg_keyword: n.wg_keyword,
                wg_addicon: n.wg_addicon
            };
            a.setData({
                showgw: i,
                wglist: s
            });
        }
        app.wxauthSetting(), console.log("options"), console.log(e), app.util.request({
            url: "entry/wxapp/KJdetails",
            cachetime: "30",
            data: {
                id: t
            },
            success: function(t) {
                console.log("商品信息s"), console.log(t.data), a.setData({
                    activeList: t.data
                });
                var e = t.data.content;
                WxParse.wxParse("content", "html", e, a, 10), console.log("商品信息e");
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1,
                    success: function(t) {
                        1 == e.is_share ? wx.redirectTo({
                            url: "/mzhk_sun/pages/index/bargain/bargain"
                        }) : wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }
        });
    },
    showwgtable: function(t) {
        var e = t.currentTarget.dataset.flag;
        this.setData({
            wg_flag: e
        });
    },
    max: function(t) {
        var e = t.currentTarget.dataset.address, a = Number(t.currentTarget.dataset.longitude), o = Number(t.currentTarget.dataset.latitude);
        if (0 == a && 0 == o) return wx.showToast({
            title: "该地址有问题，可能无法显示~",
            icon: "none",
            duration: 1e3
        }), !1;
        wx.openLocation({
            name: e,
            latitude: o,
            longitude: a,
            scale: 18,
            address: e
        });
    },
    dialogue: function(t) {
        var e = t.currentTarget.dataset.phone;
        console.log(e), wx.makePhoneCall({
            phoneNumber: e
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    shareCanvas: function() {
        var t = this, e = t.data.activeList, a = [];
        a.gid = e.gid, a.bname = e.gname, a.url = t.data.url, a.logo = e.lb_imgs[0], a.shopprice = e.shopprice, 
        a.kjprice = e.kjprice;
        var o = wx.getStorageSync("users");
        a.scene = "d_user_id=" + o.id + "&id=" + t.data.id, app.creatPoster("mzhk_sun/pages/index/bardet/bardet", 430, a, 3, "shareImg");
    },
    shareCanvas_help: function() {
        var t = this, e = t.data.kanjia.cs_id, a = t.data.activeList, o = [];
        o.bname = a.gname, o.url = t.data.url, o.logo = a.lb_imgs[0], o.sharetitle = a.biaoti ? a.biaoti : "老铁，快来帮我砍一刀，快来支援我", 
        o.scene = "cs_id=" + e + "&id=" + t.data.id + "&is_share=1", app.creatPoster("mzhk_sun/pages/index/help/help", 430, o, 6, "shareImg"), 
        this.setData({
            showStatus: !0
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
                console.log("成功"), wx.showModal({
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
    toMember: function(t) {
        wx.navigateTo({
            url: "../../member/member"
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.func.islogin(app, a);
        var t = a.data.options;
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id), app.util.request({
            url: "entry/wxapp/UpdateGoods",
            data: {
                id: a.data.id,
                typeid: 1
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        });
        var e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            cachetime: "0",
            data: {
                openid: e
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                console.log("vip"), console.log(t.data), a.setData({
                    viptype: t.data.viptype
                });
            }
        });
        var o = a.data.id;
        app.util.request({
            url: "entry/wxapp/ISkanjia",
            data: {
                id: o,
                openid: e
            },
            success: function(t) {
                console.log(t);
                var e = t.data.status;
                a.setData({
                    join: e,
                    kanjia: t.data
                });
            }
        });
    },
    countDownClock: function() {
        var t = "", e = this.data.activeList, a = tool.countDown(this, e.enftime);
        if (!a) return !(t = "已经截止");
        t = "距离结束还剩：" + a[0] + "天" + a[1] + "时" + a[3] + "分" + a[4] + "秒", this.setData({
            clock: t
        });
    },
    getUrl: function() {
        var e = this, a = app.getSiteUrl();
        a ? e.setData({
            url: a
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a = t.data, e.setData({
                    url: a
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {
        clearTimeout(app.globalData.timer_slideupshoworder);
    },
    onPullDownRefresh: function() {
        this.onShow(), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        console.log("分享");
        var e = this, a = e.data.activeList, o = a.gid, n = e.data.kanjia, i = n.cs_id, s = e.data.url;
        console.log(a), console.log(n);
        var r = (a.biaoti ? a.biaoti + "：" : "") + a.gname;
        console.log(o), "button" === t.from && console.log(t.target);
        var c = wx.getStorageSync("users");
        if (0 < i) var u = "/mzhk_sun/pages/index/help/help?id=" + o + "&cs_id=" + i + "&is_share=1"; else u = "/mzhk_sun/pages/index/bardet/bardet?id=" + o + "&is_share=1&d_user_id=" + c.id;
        return {
            title: r,
            path: u,
            imageUrl: s + a.lb_imgs[0],
            success: function(t) {
                e.setData({
                    showModalStatus: !1
                }), console.log("转发成功"), app.util.request({
                    url: "entry/wxapp/UpdateGoods",
                    data: {
                        id: o,
                        typeid: 2
                    },
                    success: function(t) {
                        console.log("更新数据"), console.log(t.data);
                    }
                });
            },
            fail: function(t) {
                console.log("转发失败"), e.setData({
                    showModalStatus: !1
                });
            }
        };
    },
    order: function(t) {},
    showShareModel: function(t) {
        var e = this, a = t.currentTarget.dataset.id, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/CheckGoodsStatus",
            cachetime: "0",
            data: {
                gid: a,
                openid: o,
                ltype: 2
            },
            success: function(t) {
                e.setData({
                    showStatus: !1
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
    CloseShareModel: function(t) {
        this.setData({
            showStatus: !0
        });
    },
    powerDrawer: function(t) {
        var e = this, a = t.currentTarget.dataset.statu, o = t.currentTarget.dataset.join;
        if ("open" == a) {
            var n = t.currentTarget.dataset.id, i = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/CheckGoodsStatus",
                cachetime: "0",
                data: {
                    gid: n,
                    openid: i,
                    ltype: 2
                },
                success: function(t) {
                    console.log(t.data), app.util.request({
                        url: "entry/wxapp/ZKanjia",
                        data: {
                            gid: n,
                            openid: i
                        },
                        success: function(t) {
                            console.log("砍价"), console.log(t.data), e.setData({
                                kanjia: t.data,
                                join: o
                            }), e.util(a);
                        }
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
        } else e.util(a);
    },
    util: function(t) {
        var e = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = e).opacity(0).height(0).step(), this.setData({
            animationData: e.export()
        }), setTimeout(function() {
            e.opacity(1).height("488rpx").step(), this.setData({
                animationData: e
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
    toCforder: function(t) {
        var e = t.currentTarget.dataset.id, a = t.currentTarget.dataset.price, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/CheckGoodsStatus",
            cachetime: "10",
            data: {
                gid: e,
                openid: o,
                ltype: 2,
                isbuy: 1
            },
            success: function(t) {
                console.log(t.data), wx.navigateTo({
                    url: "../../member/cforder/cforder?id=" + e + "&price=" + a
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