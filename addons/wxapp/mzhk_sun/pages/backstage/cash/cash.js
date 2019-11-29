var app = getApp();

Page({
    data: {
        ratesMoney: "0.00",
        putForward: "",
        minPut: "100",
        mode: [],
        list: [],
        check: !1,
        commissionMoney: "0.00",
        isShow: !0,
        is_modal_Hidden: !0,
        defaulttype: 0,
        index: 0,
        cangetMoney: "0.00"
    },
    onLoad: function(t) {
        var e = this;
        app.wxauthSetting(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var a = wx.getStorageSync("brand_info");
        app.util.request({
            url: "entry/wxapp/GetBrandMoney",
            cachetime: "0",
            data: {
                bid: a.bid
            },
            success: function(t) {
                console.log("获取要提现的数据"), console.log(t.data), e.setData({
                    list: t.data,
                    mode: t.data.wd_type,
                    defaulttype: t.data.wd_type[0].id
                });
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
    toggleRule: function(t) {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    cashAll: function(t) {
        var e, a = this, o = a.data.list, n = a.data.list.canuseamount, i = a.data.index, d = a.data.mode, s = (n * o.commission / 100).toFixed(2), c = ((100 * n - 100 * s - 100 * (e = ((100 * n - n * o.commission) / 100 * d[i].wd_rates / 100).toFixed(2))) / 100).toFixed(2);
        a.setData({
            putForward: n,
            commissionMoney: s,
            ratesMoney: e,
            cangetMoney: c
        });
    },
    bindPickerChange: function(t) {
        var e, a, o = this, n = o.data.list, i = o.data.mode, d = o.data.putForward, s = t.detail.value, c = o.data.commissionMoney ? o.data.commissionMoney : 0;
        a = d ? ((100 * d - 100 * c - 100 * (e = ((100 * d - d * n.commission) / 100 * i[s].wd_rates / 100).toFixed(2))) / 100).toFixed(2) : e = "0.00", 
        this.setData({
            defaulttype: i[s].id,
            index: s,
            ratesMoney: e,
            cangetMoney: a
        });
    },
    enterMmoney: function(t) {
        var e, a, o = this, n = o.data.list, i = t.detail.value, d = o.data.index, s = o.data.mode, c = 0;
        a = i ? ((100 * (i = parseInt(i)) - 100 * (c = (i * n.commission / 100).toFixed(2)) - 100 * (e = ((100 * i - i * n.commission) / 100 * s[d].wd_rates / 100).toFixed(2))) / 100).toFixed(2) : e = c = "0.00", 
        o.setData({
            putForward: i,
            commissionMoney: c,
            ratesMoney: e,
            cangetMoney: a
        });
    },
    checkboxChange: function(t) {
        this.setData({
            check: !this.data.check
        });
    },
    formSubmit: function(t) {
        var e, a, o, n = this, i = !0, d = "", s = n.data.putForward, c = n.data.check, u = n.data.index, l = n.data.mode, r = wx.getStorageSync("brand_info");
        if (c ? s ? 2 == l[u].id ? (e = t.detail.value.zfb_uname, a = t.detail.value.zfb_account, 
        o = t.detail.value.zfb_phone, "" == e ? d = "请填写您的名字" : "" == a ? d = "请输入支付宝账号" : /^1(3|4|5|7|8)\d{9}$/.test(o) ? i = !1 : d = "请输入正确的手机号码") : 3 == l[u].id ? (e = t.detail.value.yhk_uname, 
        a = t.detail.value.yhk_account, o = t.detail.value.yhk_phone, "" == e ? d = "请填写您的名字" : "" == a ? d = "请输入银行卡号" : /^1(3|4|5|7|8)\d{9}$/.test(o) ? i = !1 : d = "请输入正确的手机号码") : (e = t.detail.value.wx_uname, 
        a = "", o = t.detail.value.wx_phone, "" == e ? d = "请填写您的名字" : /^1(3|4|5|7|8)\d{9}$/.test(o) ? i = !1 : d = "请输入正确的手机号码") : d = "请输入提现金额" : d = "请阅读提现须知", 
        1 == i) wx.showModal({
            title: "提示",
            content: d,
            showCancel: !1
        }); else {
            var m = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/SaveWithDraw",
                cachetime: "0",
                data: {
                    bid: r.bid,
                    openid: m,
                    wd_type: l[u].id,
                    money: s,
                    account: a,
                    uname: e,
                    phone: o
                },
                success: function(t) {
                    console.log("提交数据"), console.log(t.data), wx.showModal({
                        title: "提示",
                        content: "提现提交成功",
                        showCancel: !1,
                        success: function(t) {
                            wx.redirectTo({
                                url: "/mzhk_sun/pages/backstage/index2/index2"
                            });
                        }
                    });
                }
            });
        }
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});