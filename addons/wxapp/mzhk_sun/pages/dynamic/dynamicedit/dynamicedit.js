var app = getApp();

Page({
    data: {
        navTile: "",
        uploadPic: [],
        Pic: "",
        disabled: !1,
        placeHolder: "输入内容...",
        isuploadsuccess: !0,
        isclick: !1,
        content: "",
        form_id: "",
        is_modal_Hidden: !0
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = app.getSiteUrl();
        e ? (a.setData({
            url: e
        }), app.editTabBar(e)) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), e = t.data, app.editTabBar(e), a.setData({
                    url: e
                });
            }
        }), app.wxauthSetting(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor ? wx.getStorageSync("System").fontcolor : "",
            backgroundColor: wx.getStorageSync("System").color ? wx.getStorageSync("System").color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        app.func.islogin(app, this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    uploadPic: function(t) {
        var a = this, e = app.util.url("entry/wxapp/Touploadtwo") + "&m=mzhk_sun";
        wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                a.setData({
                    uploadPic: t.tempFilePaths,
                    isuploadsuccess: !1
                }), a.uploadimg({
                    url: e,
                    path: t.tempFilePaths
                }, {});
            }
        });
    },
    uploadimg: function(o, i) {
        console.log(o), console.log("开始上传图片");
        var n = this, c = o.i ? o.i : 0, a = (o.utype && o.utype, void 0);
        a = 0 == c ? "" : n.data.Pic, wx.uploadFile({
            url: o.url,
            filePath: o.path[c],
            name: "file",
            formData: i,
            success: function(t) {
                console.log("success:" + c), a = 0 < a.length ? a + "," + t.data : t.data, console.log(a), 
                n.data.isclick && wx.showToast({
                    icon: "none",
                    title: "提交中，请稍后...",
                    duration: 2e4
                }), n.setData({
                    Pic: a
                });
            },
            fail: function(t) {
                console.log("fail:" + c);
            },
            complete: function() {
                if (++c == o.path.length) {
                    console.log("图片上传完毕");
                    var t = n.data.isclick;
                    if (n.setData({
                        isuploadsuccess: !0
                    }), t) {
                        var a = n.data.content, e = n.data.form_id;
                        n.autoformSubmit(a, e);
                    }
                } else {
                    console.log("上传下一张"), (t = n.data.isclick) && wx.showToast({
                        icon: "none",
                        title: "提交中，请稍后...",
                        duration: 2e4
                    }), o.i = c, n.uploadimg(o, i);
                }
            }
        });
    },
    cominput: function(t) {
        var a = t.detail.value, e = /[^\u0020-\u007E\u00A0-\u00BE\u2E80-\uA4CF\uF900-\uFAFF\uFE30-\uFE4F\uFF00-\uFFEF\u0080-\u009F\u2000-\u201f\u2026\u2022\u20ac\r\n]/g;
        a.match(e) && (a = a.replace(e, "")), this.setData({
            content: a
        });
    },
    formSubmit: function(t) {
        var a = this, e = t.detail.value.content, o = wx.getStorageSync("openid"), i = a.data.Pic;
        return a.data.isuploadsuccess ? (console.log(i), "" == e && "" == i ? (wx.showToast({
            icon: "none",
            title: "请发张照片或者写些东西吧！"
        }), !1) : (wx.showLoading({
            title: "提交中，请稍后..."
        }), a.setData({
            disabled: !0
        }), void app.util.request({
            url: "entry/wxapp/SaveCircle",
            cachetime: "0",
            data: {
                user_id: wx.getStorageSync("users").id,
                content: e,
                pic: i,
                openid: o,
                form_id: t.detail.formId
            },
            success: function(t) {
                wx.showToast({
                    icon: "none",
                    title: "提交成功！",
                    duration: 1e3
                }), wx.hideLoading(), wx.redirectTo({
                    url: "/mzhk_sun/pages/dynamic/dynamic"
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1
                }), a.setData({
                    disabled: !1,
                    isclick: !1
                });
            }
        }))) : (wx.showToast({
            icon: "none",
            title: "提交中，请稍后...",
            duration: 2e4
        }), a.setData({
            isclick: !0,
            content: e,
            form_id: t.detail.formId
        }), !1);
    },
    autoformSubmit: function(t, a) {
        var e = this, o = wx.getStorageSync("openid"), i = e.data.Pic;
        e.data.isuploadsuccess;
        if ("" == t && "" == i) return wx.showToast({
            icon: "none",
            title: "请发张照片或者写些东西吧！"
        }), !1;
        e.setData({
            disabled: !0
        }), app.util.request({
            url: "entry/wxapp/SaveCircle",
            cachetime: "0",
            data: {
                user_id: wx.getStorageSync("users").id,
                content: t,
                pic: i,
                openid: o,
                form_id: a
            },
            success: function(t) {
                wx.showToast({
                    icon: "none",
                    title: "提交成功！",
                    duration: 1e3
                }), wx.hideLoading(), wx.redirectTo({
                    url: "/mzhk_sun/pages/dynamic/dynamic"
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1
                }), e.setData({
                    disabled: !1
                });
            }
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});