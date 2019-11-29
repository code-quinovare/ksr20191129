var app = getApp();

Page({
    data: {
        hk_bgimg: "",
        hk_namecolor: "#f5ac32",
        user_info: [],
        d_info: [],
        hidden: !0
    },
    onLoad: function(t) {
        var o = this, e = app.getSiteUrl();
        e ? (app.editTabBar(e), o.setData({
            url: e
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                wx.setStorageSync("url", t.data), e = t.data, o.setData({
                    url: e
                });
            }
        })) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                wx.setStorageSync("url", t.data), e = t.data, app.editTabBar(e), o.setData({
                    url: e
                });
            }
        });
        wx.getStorageSync("System");
        app.util.request({
            url: "entry/wxapp/System",
            success: function(t) {
                wx.setStorageSync("System", t.data), o.setData({
                    hk_bgimg: t.data.hk_bgimg ? t.data.hk_bgimg : "",
                    hk_namecolor: t.data.hk_namecolor ? t.data.hk_namecolor : "#f5ac32"
                });
            }
        });
        var n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/IsPromoter",
            data: {
                openid: n,
                m: app.globalData.Plugin_distribution
            },
            showLoading: !1,
            success: function(t) {
                if (t) if (9 != t.data) {
                    var e = t.data;
                    o.setData({
                        user_info: e
                    });
                } else wx.redirectTo({
                    url: "/mzhk_sun/plugin/distribution/fxAddShare/fxAddShare"
                });
            }
        });
        var a = wx.getStorageSync("users");
        app.util.request({
            url: "entry/wxapp/GetDistribution",
            data: {
                uid: a.id,
                m: app.globalData.Plugin_distribution
            },
            showLoading: !1,
            success: function(t) {
                console.log("9696969696969696"), console.log(t.data), 2 != t.data && o.setData({
                    d_info: t.data
                });
            }
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    onReady: function() {},
    onShow: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
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
    shareCanvas: function() {
        var t = wx.getStorageSync("users"), e = [];
        e.uid = t.id, e.title = "扫码赚钱", e.url = this.data.url, e.scene = "d_user_id=" + t.id, 
        this.creatPoster("mzhk_sun/pages/index/index", 430, e, 8, "shareImg");
    },
    creatPoster: function(t, e, o, n, s) {
        var l = this, a = app.siteInfo.siteroot.split("/app/")[0] + "/attachment/", u = "", r = "", c = "", i = o.scene;
        wx.showLoading({
            title: "获取图片中..."
        });
        var d = o.uid ? o.uid : 0;
        app.util.request({
            url: "entry/wxapp/GetwxCode",
            data: {
                scene: i,
                page: t,
                width: e,
                uid: d,
                m: app.globalData.Plugin_distribution
            },
            success: function(i) {
                console.log("获取小程序二维码"), console.log(i), u = i.data.wxcode_pic, r = i.data.blogo, 
                c = i.data.postertoptitle ? i.data.postertoptitle : o.title;
                var t = new Promise(function(e, t) {
                    wx.getImageInfo({
                        src: r,
                        success: function(t) {
                            console.log("图片缓存1"), console.log(t), e(t.path);
                        },
                        fail: function(t) {
                            console.log("图片1保存失败"), e(r), console.log(t);
                        }
                    });
                }), e = new Promise(function(e, t) {
                    wx.getImageInfo({
                        src: a + u,
                        success: function(t) {
                            app.util.request({
                                url: "entry/wxapp/DelwxCode",
                                data: {
                                    imgurl: u,
                                    m: app.globalData.Plugin_distribution
                                },
                                success: function(t) {
                                    console.log(t.data);
                                }
                            }), console.log("图片缓存2"), console.log(t), e(t.path);
                        },
                        fail: function(t) {
                            console.log("图片2保存失败"), e(a + u), console.log(t);
                        }
                    });
                });
                Promise.all([ t, e ]).then(function(t) {
                    console.log(t), console.log("进入 promise"), console.log(i);
                    var e = wx.createCanvasContext(s), o = c, n = t[0], a = t[1];
                    e.rect(0, 0, 600, 770), e.setFillStyle("#fff"), e.fill(), e.drawImage(n, 0, 0, 600, 418), 
                    e.setFillStyle("#000"), e.setFontSize(34), l.drawText(o, 20, 414, 500, e), e.drawImage(a, 60, 550, 180, 180), 
                    e.drawImage("../../../../style/images/zhiwen.png", 380, 550, 130, 130), e.setFontSize(22), 
                    e.setFillStyle("#999"), e.fillText("长按识别二维码进入", 350, 710), e.stroke(), e.draw(), 
                    console.log("结束 promise"), wx.hideLoading(), wx.showLoading({
                        title: "开始生成海报..."
                    }), new Promise(function(t, e) {
                        setTimeout(function() {
                            t("second ok");
                        }, 500);
                    }).then(function(t) {
                        console.log(t), wx.canvasToTempFilePath({
                            x: 0,
                            y: 0,
                            width: 602,
                            height: 771,
                            destWidth: 602,
                            destHeight: 771,
                            canvasId: s,
                            success: function(t) {
                                console.log("进入 canvasToTempFilePath"), l.setData({
                                    prurl: t.tempFilePath,
                                    hidden: !1
                                }), wx.hideLoading();
                            },
                            fail: function(t) {
                                console.log(t);
                            }
                        });
                    });
                });
            }
        });
    },
    drawText: function(t, e, o, n, a) {
        var i = t.split(""), s = "", l = [];
        a.font = "30rpx Arial", a.fillStyle = "#222222", a.textBaseline = "middle";
        for (var u = 0; u < i.length; u++) a.measureText(s).width < n || (l.push(s), s = ""), 
        s += i[u];
        l.push(s);
        for (var r = 0; r < l.length; r++) a.fillText(l[r], e, o + 30 * (r + 1));
    },
    toFxCash: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/plugin/distribution/fxCash/fxCash"
        });
    },
    toFxWd: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/plugin/distribution/fxWithdraw/fxWithdraw"
        });
    },
    toFxOrder: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/plugin/distribution/fxOrder/fxOrder"
        });
    },
    toFxDetail: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/plugin/distribution/fxDetail/fxDetail"
        });
    },
    toFxTeam: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/plugin/distribution/fxTeam/fxTeam"
        });
    },
    toFxGoods: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/plugin/distribution/fxGoods/fxGoods"
        });
    }
});