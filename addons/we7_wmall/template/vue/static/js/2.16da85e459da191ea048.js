webpackJsonp([2],{"3gNd":function(t,a){},"hYB/":function(t,a){},nU8l:function(t,a,e){"use strict";Object.defineProperty(a,"__esModule",{value:!0});var o=e("Gu7T"),i=e.n(o),s=e("mvHQ"),d=e.n(s),r=e("woOf"),n=e.n(r),c=e("Dd8w"),l=e.n(c),u=e("NYxO"),h=e("mzkE"),y=e("Cz8s"),f=e("kEnp"),p=e("rniE"),m={data:function(){return{getLocationFail:!1,showPreLoading:!0,is_use_diy:0,diydata:{diy:{data:{}},storeExtra:{condition:{order:"",mode:"",dis:""},filter_title:"综合排序",multiple:!1,filter:!1},stores:{loading:!0,finished:!1,page:1,psize:5,loaded:0,empty:0,data:[]},popup:{storeSearch:!1},superRedpacketData:{},config:{}},menufooter:this.util.getStorage("menufooter"),order_remind:{},showFixedSearchBar:!1}},components:{PublicHeader:y.a,PublicFooter:h.a,diy:f.a,OrderStatusWarpper:p.a},methods:l()({},Object(u.b)(["setLocation","getLocation"]),{onToggleDiscount:function(t,a){"waimai_stores"==this.diydata.diy.data.items[a].id?this.diydata.diy.data.items[a].data[t].activity.is_show_all=!this.diydata.diy.data.items[a].data[t].activity.is_show_all:this.diydata.stores.data[t].activity.is_show_all=!this.diydata.stores.data[t].activity.is_show_all},onCloseRedpacket:function(){this.diydata.superRedpacketData.is_show=!1,this.diydata.superRedpacketData=n()({},this.diydata.superRedpacketData)},onChangeStoreExtra:function(t){"multiple"==t?(this.diydata.storeExtra.multiple=!0,this.diydata.storeExtra.filter=!1):(this.diydata.storeExtra.multiple=!1,this.diydata.storeExtra.filter=!0),this.diydata.popup.storeSearch=!0},onStoreOrderby:function(t,a,e){if("order"==t)this.diydata.storeExtra.condition.order=a,this.diydata.storeExtra.multiple=!1,this.diydata.storeExtra.filter_title="sailed"!=a&&"distance"!=a?e:"综合排序";else{if("discounts"==t)return this.diydata.storeExtra.condition.dis==a&&(a=""),this.diydata.storeExtra.condition.dis=a,!1;if("mode"==t)return this.diydata.storeExtra.condition.mode==a&&(a=""),this.diydata.storeExtra.condition.mode=a,!1;"clear"==t?(this.diydata.storeExtra.condition.dis="",this.diydata.storeExtra.condition.order="",this.diydata.storeExtra.condition.mode="",this.diydata.storeExtra.filter=!1,this.diydata.storeExtra.filter_title="综合排序"):"finish"==t&&(this.diydata.storeExtra.filter=!1)}this.diydata.popup.storeSearch=!1,this.onGetStore(!0)},onGetStore:function(t){var a=this,e=this;t&&(e.diydata.stores={page:1,psize:20,loaded:0,empty:!1,loading:!0}),e.diydata.stores.loading=!0,this.util.request({url:"wmall/home/index/store",data:{lat:e.locationInfo.location_x,lng:e.locationInfo.location_y,page:e.diydata.stores.page,psize:e.diydata.stores.psize,condition:d()(e.diydata.storeExtra.condition)}}).then(function(o){var s=o.data.message.message;t&&(e.diydata.stores.data=[]),e.diydata.stores.data=[].concat(i()(a.diydata.stores.data),i()(s.stores)),s.pagetotal<=e.diydata.stores.page&&(e.diydata.stores.loaded=1,e.diydata.stores.data.length||(e.diydata.stores.empty=!0),e.diydata.stores.finished=!0),e.diydata.stores.loading=!1,e.diydata.stores.page++,e.diydata.stores.loaded||s.stores.length||a.onGetStore()})},onLoad:function(){var t=this,a=this;this.util.request({url:"wmall/home/index/index",data:{lat:this.locationInfo.location_x,lng:this.locationInfo.location_y,menufooter:1,order_remind:1}}).then(function(e){a.showPreLoading=!1;var o=e.data.message;o.errno?t.$toast(o.message):(a.diydata.config=o.message.config,a.diydata.diy=o.message.diy,a.diy=o.message.diy,a.util.setWXTitle(a.diydata.config.title),a.diydata.superRedpacketData=o.message.superRedpacketData,a.diydata.superRedpacketData.is_show=!0,a.diydata.stores.data=[].concat(i()(t.diydata.stores.data),i()(o.message.stores.stores)),o.message.stores.pagetotal<=a.diydata.stores.page&&(a.diydata.stores.loaded=1,a.diydata.stores.data.length||(a.diydata.stores.empty=!0),a.diydata.stores.finished=!0),a.diydata.stores.loading=!1,a.diydata.stores.page++,a.diydata.stores.loaded||o.message.stores.length||a.onGetStore(),a.diydata.cart_sum=o.message.cart_sum,a.menufooter=window.menufooter,a.order_remind=window.order)})},onInit:function(){var t=this;this.getLocation(),this.locationInfo.location_x?(t.getLocationFail=!1,t.locationInfo.last_location_x=this.locationInfo.location_x,t.onLoad()):this.util.getLocation({successLocation:function(a){t.setLocation({location_x:a.location_x,location_y:a.location_y}),t.onLoad()},successAddress:function(a){t.setLocation({location_x:a.location_x,location_y:a.location_y,address:a.address})},fail:function(a){t.setLocation({last_location_x:0,location_x:0,address:"获取定位失败"}),t.getLocationFail=!0,t.onLoad()}})},onGetCartNums:function(){var t=this;this.util.request({url:"wmall/home/index/cart"}).then(function(a){var e=a.data.message;e.errno?t.util.$toast(e.message):t.diydata.cart_sum=e.message.cart_sum})}}),created:function(){},activated:function(){if(this.locationInfo.last_location_x!=this.locationInfo.location_x)return this.diydata.stores={page:1,psize:20,loaded:0,empty:!1,loading:!1,data:[]},this.diydata.storeExtra={condition:{order:"",mode:"",dis:""},filter_title:"综合排序",multiple:!1,filter:!1},void this.onInit();this.onGetCartNums()},computed:l()({},Object(u.c)(["locationInfo"])),mounted:function(){var t=this;t.onInit(),window.addEventListener("scroll",function(){var a=window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop;t.showFixedSearchBar=a>100})}},g={render:function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{attrs:{id:"home"}},[e("div",{attrs:{id:"allmap"}}),t._v(" "),t.order_remind&&t.order_remind.log?e("order-status-warpper",{attrs:{order:t.order_remind}}):t._e(),t._v(" "),e("public-footer",{attrs:{menufooter:t.menufooter}}),t._v(" "),e("div",{staticClass:"container"},[e("diy",{attrs:{diydata:t.diydata,preLoading:t.showPreLoading,getLocationFail:t.getLocationFail,showFixedSearchBar:t.showFixedSearchBar},on:{onToggleDiscount:t.onToggleDiscount,onChangeStoreExtra:t.onChangeStoreExtra,onStoreOrderby:t.onStoreOrderby,onGetStore:t.onGetStore,onCloseRedpacket:t.onCloseRedpacket}})],1)],1)},staticRenderFns:[]};var _=e("VU/8")(m,g,!1,function(t){e("hYB/")},null,null);a.default=_.exports},rniE:function(t,a,e){"use strict";var o={props:{order:{type:Object,default:function(){return{order:{log:{title:""}}}}}},data:function(){return{active:!1}},methods:{onChangeActive:function(){this.active=!this.active}}},i={render:function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{attrs:{id:"order-status-warpper"}},[e("div",{staticClass:"order-status-warpper",class:{active:t.active},on:{click:t.onChangeActive}},[e("img",{attrs:{src:t.order.logo,alt:""}}),t._v(" "),e("div",{staticClass:"text"},[t.order.log&&t.order.log.title?e("div",{staticClass:"order-status"},[t._v(t._s(t.order.log.title))]):t._e(),t._v(" "),e("div",{staticClass:"time"},[t._v("请耐心等待")])]),t._v(" "),e("span",{staticClass:"order-status-close"},[t._v("×")])])])},staticRenderFns:[]};var s=e("VU/8")(o,i,!1,function(t){e("3gNd")},null,null);a.a=s.exports}});
//# sourceMappingURL=2.16da85e459da191ea048.js.map