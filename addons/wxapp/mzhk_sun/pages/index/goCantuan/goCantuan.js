var app = getApp();

Page({
    data: {
        hideShopPopup: !0,
        num: 3,
        oldH: [ "http://oydnzfrbv.bkt.clouddn.com/tx.png", "http://oydnzfrbv.bkt.clouddn.com/tx.png" ],
        lavepeople: [],
        lavenum: 0,
        details: "",
        orderinfo: "",
        grouplist: "",
        ishas: !1,
        is_modal_Hidden: !0,
        lavenumhave: 0
    },
    onLoad: function(t) {
        var a = this, e = t.gid, o = t.id;
        a.setData({
            gid: e,
            id: o
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), a.setData({
            isshare: t.isshare ? t.isshare : 0
        });
        var n = app.getSiteUrl();
        n ? a.setData({
            url: n
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), n = t.data, a.setData({
                    url: n
                });
            }
        }), app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/CheckGroup",
            success: function(t) {
                console.log("成功"), console.log(t.data);
            }
        });
    },
    login: function() {
        app.wxauthSetting();
    },
    nowPindan: function(t) {
        var a = wx.getStorageSync("openid"), e = t.currentTarget.dataset.id, o = t.currentTarget.dataset.gid;
        app.util.request({
            url: "entry/wxapp/CheckGroupOrder",
            cachetime: "10",
            data: {
                order_id: e
            },
            success: function(t) {
                console.log(t.data), app.util.request({
                    url: "entry/wxapp/CheckGoodsStatus",
                    cachetime: "0",
                    data: {
                        gid: o,
                        openid: a,
                        ltype: 1
                    },
                    success: function(t) {
                        console.log(t.data), wx.navigateTo({
                            url: "../../member/ptorder/ptorder?id=" + o + "&order_id=" + e
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
            fail: function(t) {
                return wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1
                }), wx.navigateTo({
                    url: "/mzhk_sun/pages/index/group/group"
                }), !1;
            }
        });
    },
    closePopupTap: function(t) {
        this.setData({
            hideShopPopup: !0
        });
    },
    bindGuiGeTap: function() {
        this.setData({
            hideShopPopup: !1
        });
    },
    labelItemTap: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.propertychildindex;
        this.setData({
            currentIndex: a,
            currentName: t.currentTarget.dataset.propertychildname
        });
    },
    labelItemTaB: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.propertychildindex;
        this.setData({
            currentSel: a,
            currentNamet: t.currentTarget.dataset.propertychildname
        });
    },
    numJianTap: function() {
        if (this.data.buyNumber > this.data.buyNumMin) {
            var t = this.data.buyNumber;
            t--, this.setData({
                buyNumber: t
            });
        }
    },
    numJiaTap: function() {
        if (this.data.buyNumber < this.data.buyNumMax) {
            var t = this.data.buyNumber;
            t++, this.setData({
                buyNumber: t
            });
        }
    },
    buyNow: function(t) {
        console.log(t), this.data.oldH.push(t.detail.userInfo.avatarUrl);
        var a = this.data.oldH;
        this.setData({
            oldH: a,
            newPintuanPeople: 1,
            newHeader: t.detail.userInfo,
            hideShopPopup: !0
        }), this.setData({
            old: this.data.num + 1,
            newH: 5 - this.data.num - 1
        }), console.log(this.data.oldH), console.log(this.data.newHeader.avatarUrl);
    },
    onReady: function() {},
    onShow: function() {
        var o, n, i = this, r = [], s = !1;
        app.func.islogin(app, i);
        var u = wx.getStorageSync("openid"), d = i.data.id, l = i.data.gid;
        app.util.request({
            url: "entry/wxapp/GroupsDetails",
            cachetime: "0",
            data: {
                id: d,
                gid: l
            },
            success: function(t) {
                console.log(111111111111), console.log(t.data), console.log(222222222222), o = Number(t.data.orderinfo.neednum) - Number(t.data.orderinfo.peoplenum);
                for (var a = Number(t.data.orderinfo.peoplenum) - Number(t.data.orderinfo.buynum), e = 0; e < o; e++) r[e] = "/resource/images/pintuan/mytx.png";
                if (n = t.data.grouplist, t.data.orderinfo.openid == u) s = !0; else for (e = 0; e < n.length; e++) n[e].openid == u && (s = !0);
                i.setData({
                    details: t.data.goodsinfo,
                    orderinfo: t.data.orderinfo,
                    grouplist: t.data.grouplist,
                    lavepeople: r,
                    lavenum: o,
                    lavenumhave: a,
                    ishas: s,
                    id: d,
                    gid: l
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toIndex: function(t) {
        wx.redirectTo({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    otherGoods: function(t) {
        wx.redirectTo({
            url: "/mzhk_sun/pages/index/group/group"
        });
    },
    onShareAppMessage: function(t) {
        app.util.request({
            url: "entry/wxapp/UpdateGoods",
            data: {
                id: t.target.dataset.gid,
                typeid: 2
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        });
        var a = t.target.dataset.id, e = t.target.dataset.gid, o = wx.getStorageSync("openid");
        return "button" === t.from && console.log(t.target), {
            title: (this.data.details.biaoti ? this.data.details.biaoti + "：" : "") + this.data.details.gname,
            path: "/mzhk_sun/pages/index/goCantuan/goCantuan?id=" + a + "&userid=" + o + "&gid=" + e + "&isshare=1",
            success: function(t) {},
            fail: function(t) {}
        };
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});