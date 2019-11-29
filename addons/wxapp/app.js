App({
    globalData: {
        userInfo: null,
        hasshowpopad: !1,
        loadinghidden: !1,
        timer_slideupshoworder: "",
        Plugin_distribution: "mzhk_sun_plugin_distribution",
        Plugin_eatvisit: "mzhk_sun_plugin_eatvisit",
        tabBar: {
            color: "#9E9E9E",
            selectedColor: "#f00",
            backgroundColor: "#fff",
            borderStyle: "#ccc",
            list: [ {
                pagePath: "/mzhk_sun/pages/index/index",
                text: "首页",
                iconPath: "/style/images/index.png",
                selectedIconPath: "/style/images/indexSele.png",
                selectedColor: "#ef8200",
                index: 0
            }, {
                pagePath: "/mzhk_sun/pages/active/active",
                text: "活动推荐",
                iconPath: "/style/images/active.png",
                selectedIconPath: "/style/images/activeSele.png",
                selectedColor: "#ef8200",
                index: 1
            }, {
                pagePath: "/mzhk_sun/pages/goods/goods",
                text: "好店推荐",
                iconPath: "/style/images/goods.png",
                selectedIconPath: "/style/images/goodsSele.png",
                selectedColor: "#ef8200",
                index: 2,
                default: 1
            }, {
                pagePath: "/mzhk_sun/pages/user/user",
                text: "我的",
                iconPath: "/style/images/user.png",
                selectedIconPath: "/style/images/userSele.png",
                selectedColor: "#ef8200",
                index: 3
            } ],
            position: "bottom"
        }
    },
    siteInfo: require("siteinfo.js"),
    util: require("/we7/js/util.js"),
    func: require("func.js"),
    distribution: require("/zhy/distribution/distribution.js"),
    onLaunch: function() {
        wx.removeStorage({
            key: "tab_navdata",
            success: function(e) {}
        }), wx.removeStorage({
            key: "System",
            success: function(e) {}
        });
        this.getSiteUrl(), wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=System&m=mzhk_sun",
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                wx.setStorageSync("System", e.data);
            }
        });
    },
    editTabBar: function(t) {
        var e = getCurrentPages(), i = e[e.length - 1], s = i.__route__;
        0 != s.indexOf("/") && (s = "/" + s);
        var o = this.globalData.tabBar, n = wx.getStorageSync("tab_navdata");
        n ? (o.url = t, o.list = n, i.setData({
            tabBar: o,
            tabBar_default: 2
        })) : this.util.request({
            url: "entry/wxapp/GetadData",
            showLoading: !1,
            data: {
                position: 9
            },
            success: function(e) {
                2 != (n = e.data) ? (wx.setStorageSync("tab_navdata", n), n ? (o.url = t, o.list = n, 
                i.setData({
                    tabBar: o,
                    tabBar_default: 2
                })) : i.setData({
                    tabBar: o,
                    tabBar_default: 1
                })) : i.setData({
                    tabBar: o,
                    tabBar_default: 1
                });
            }
        });
    },
    creatPoster: function(e, t, a, l, r) {
        console.log("-------------------"), console.log(e);
        var c = this, i = getCurrentPages(), u = i[i.length - 1], s = (u.__route__, this.siteInfo.siteroot.split("/app/")[0] + "/attachment/"), o = "";
        wx.showLoading({
            title: "获取图片中..."
        });
        var n = a.gid ? a.gid : 0, d = a.scene;
        wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=GetwxCode&m=mzhk_sun",
            header: {
                "content-type": "application/json"
            },
            data: {
                scene: d,
                page: e,
                width: t,
                gid: n
            },
            success: function(n) {
                console.log("获取小程序二维码"), console.log(n.data), o = n.data;
                var e = new Promise(function(t, e) {
                    wx.getImageInfo({
                        src: a.url + a.logo,
                        success: function(e) {
                            console.log("图片缓存1"), console.log(e), t(e.path);
                        },
                        fail: function(e) {
                            console.log("图片1保存失败"), t(a.url + a.logo), console.log(e);
                        }
                    });
                }), t = new Promise(function(t, e) {
                    wx.getImageInfo({
                        src: s + o,
                        success: function(e) {
                            wx.request({
                                url: c.siteInfo.siteroot + "?i=" + c.siteInfo.uniacid + "&from=wxapp&c=entry&a=wxapp&do=DelwxCode&m=mzhk_sun",
                                data: {
                                    imgurl: o
                                },
                                success: function(e) {
                                    console.log(e.data);
                                }
                            }), console.log("图片缓存2"), console.log(e), t(e.path);
                        },
                        fail: function(e) {
                            wx.request({
                                url: c.siteInfo.siteroot + "?i=" + c.siteInfo.uniacid + "&from=wxapp&c=entry&a=wxapp&do=DelwxCode&m=mzhk_sun",
                                data: {
                                    imgurl: o
                                },
                                success: function(e) {
                                    console.log(e.data);
                                }
                            }), console.log("图片2保存失败"), t(s + o), console.log(e);
                        }
                    });
                });
                Promise.all([ e, t ]).then(function(e) {
                    console.log(e), console.log("进入 promise"), console.log(n);
                    var t = wx.createCanvasContext(r), i = a.bname, s = e[0], o = e[1];
                    t.rect(0, 0, 600, 770), t.setFillStyle("#fff"), t.fill(), 5 == l || 7 == l ? (t.drawImage(s, 0, 0, 600, 336), 
                    t.setFillStyle("#fff7e0"), t.fillRect(50, 280, 450, 160), t.setFillStyle("#000"), 
                    t.setFontSize(34), c.drawText(i, 70, 290, 400, t), t.setFontSize(22)) : (t.drawImage(s, 0, 0, 600, 418), 
                    t.setFillStyle("#000"), t.setFontSize(34), c.drawText(i, 20, 414, 500, t)), 1 == l ? (t.setFillStyle("#666"), 
                    t.setFontSize(26), t.fillText("营业时间:", 30, 500), t.setFillStyle("#ef8200"), t.setFontSize(26), 
                    t.fillText(a.starttime + "-" + a.endtime, 150, 500)) : 2 == l ? (t.setFillStyle("#666"), 
                    t.setFontSize(26), t.fillText("拼团价:", 30, 500), t.setFillStyle("#ef8200"), t.setFontSize(30), 
                    t.fillText(a.ptprice, 120, 500), t.setFillStyle("#666"), t.setFontSize(26), t.fillText("原价:", 240, 500), 
                    t.fillText(a.shopprice, 300, 500)) : 3 == l ? (t.setFillStyle("#666"), t.setFontSize(26), 
                    t.fillText("砍价:", 30, 500), t.setFillStyle("#ef8200"), t.setFontSize(30), t.fillText(a.kjprice, 120, 500), 
                    t.setFillStyle("#666"), t.setFontSize(26), t.fillText("原价:", 240, 500), t.fillText(a.shopprice, 300, 500)) : 4 == l ? (t.setFillStyle("#666"), 
                    t.setFontSize(26), t.fillText("抢购价:", 20, 500), t.setFillStyle("#ef8200"), t.setFontSize(30), 
                    t.fillText(a.qgprice, 120, 500), t.setFillStyle("#666"), t.setFontSize(26), t.fillText("原价:", 235, 500), 
                    t.fillText(a.shopprice, 300, 500)) : 5 == l ? (t.setFontSize(22), t.setFillStyle("#666"), 
                    t.fillText("活动时间：", 70, 400), t.fillText(a.astime + "至" + a.antime, 180, 400), t.setFontSize(44), 
                    t.setFillStyle("#f33030"), t.fillText("集卡赢大奖", 164, 500)) : 6 == l ? (t.setFillStyle("#666"), 
                    t.setFontSize(26), c.drawText(a.sharetitle, 20, 480, 400, t)) : 7 == l && (t.setFontSize(22), 
                    t.setFillStyle("#666"), t.fillText("活动时间：", 70, 400), t.fillText(a.astime + "至" + a.antime, 180, 400), 
                    t.setFontSize(44), t.setFillStyle("#f33030"), t.fillText("免单等你拿", 164, 500)), t.drawImage(o, 40, 550, 180, 180), 
                    t.drawImage("../../../../style/images/zhiwen.png", 340, 550, 130, 130), t.setFontSize(22), 
                    t.setFillStyle("#999"), t.fillText("长按识别二维码进入", 310, 710), t.stroke(), t.draw(), 
                    console.log("结束 promise"), wx.hideLoading(), wx.showLoading({
                        title: "开始生成海报..."
                    }), new Promise(function(e, t) {
                        setTimeout(function() {
                            e("second ok");
                        }, 500);
                    }).then(function(e) {
                        console.log(e), wx.canvasToTempFilePath({
                            x: 0,
                            y: 0,
                            width: 602,
                            height: 771,
                            destWidth: 602,
                            destHeight: 771,
                            canvasId: r,
                            success: function(e) {
                                console.log("进入 canvasToTempFilePath"), u.setData({
                                    prurl: e.tempFilePath,
                                    hidden: !1
                                }), wx.hideLoading();
                            },
                            fail: function(e) {
                                console.log(e);
                            }
                        });
                    });
                });
            }
        });
    },
    drawText: function(e, t, i, s, o) {
        var n = e.split(""), a = "", l = [];
        o.font = "30rpx Arial", o.fillStyle = "#222222", o.textBaseline = "middle";
        for (var r = 0; r < n.length; r++) o.measureText(a).width < s || (l.push(a), a = ""), 
        a += n[r];
        l.push(a);
        for (var c = 0; c < l.length; c++) o.fillText(l[c], t, i + 30 * (c + 1));
    },
    getSiteUrl: function() {
        var t = wx.getStorageSync("url");
        if (t) return t;
        wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=Url&m=mzhk_sun",
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                return t = e.data, wx.setStorageSync("url", t), t;
            }
        });
    },
    getOpenid: function(e) {
        var i = this, t = wx.getStorageSync("openid");
        if (t) return t;
        wx.login({
            success: function(e) {
                var t = e.code;
                i.util.request({
                    url: "entry/wxapp/openid",
                    showLoading: !1,
                    data: {
                        code: t
                    },
                    success: function(e) {
                        return wx.setStorageSync("openid", e.data.openid), e.data.openid;
                    }
                });
            }
        });
    },
    wxauthSetting: function(e) {
        var n = this, t = getCurrentPages(), a = t[t.length - 1];
        wx.login({
            success: function(e) {
                var t = e.code;
                wx.setStorageSync("code", t), n.util.request({
                    url: "entry/wxapp/openid",
                    showLoading: !1,
                    data: {
                        code: t
                    },
                    success: function(e) {
                        wx.setStorageSync("key", e.data.session_key), wx.setStorageSync("openid", e.data.openid);
                        var o = e.data.openid;
                        wx.getSetting({
                            success: function(e) {
                                e.authSetting["scope.userInfo"] && wx.getUserInfo({
                                    success: function(e) {
                                        var t = e.userInfo.nickName, i = e.userInfo.avatarUrl, s = e.userInfo.gender;
                                        a.setData({
                                            thumb: i,
                                            nickname: t
                                        }), wx.setStorageSync("user_info", e.userInfo), n.util.request({
                                            url: "entry/wxapp/Login",
                                            showLoading: !1,
                                            cachetime: "0",
                                            data: {
                                                openid: o,
                                                img: i,
                                                name: t,
                                                gender: s
                                            },
                                            success: function(e) {
                                                wx.setStorageSync("users", e.data), wx.getStorageSync("have_wxauth") || (console.log("没有登录在保存登陆数据后执行一次onshow"), 
                                                a.onShow()), wx.setStorageSync("uniacid", e.data.uniacid), a.setData({
                                                    is_modal_Hidden: !0,
                                                    usersinfo: e.data
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
    }
});