webpackJsonp([58],{qaVl:function(t,s,a){"use strict";Object.defineProperty(s,"__esModule",{value:!0});var e={components:{PublicHeader:a("Cz8s").a},data:function(){return{redpack:{},select:0,price:0,old_price:0}},methods:{onLoad:function(){var t=this;this.util.request({url:"superRedpacket/meal"}).then(function(s){var a=s.data.message;a.errno||(t.redpack=a.message.data)})},selectRedpacket:function(t,s,a){this.select=t,this.price=s,this.old_price=a}},mounted:function(){this.onLoad()}},i={render:function(){var t=this,s=t.$createElement,a=t._self._c||s;return a("div",{attrs:{id:"mealRedpacket-index"}},[a("public-header",{attrs:{title:"套餐红包购买"}}),t._v(" "),a("div",{staticClass:"content"},[a("div",{staticClass:"meal-container"},[a("div",{staticClass:"top"},[a("div",{staticClass:"name"},[t._v("选择套餐红包")]),t._v(" "),a("div",{staticClass:"tip"},[t._v("\n\t\t\t\t\t提示信息\n\t\t\t\t\t"),a("span",[t._v(t._s(t.redpack.placeholder))])])]),t._v(" "),t._l(t.redpack.redpackets,function(s,e){return a("div",{staticClass:"meal-item"},[a("div",{staticClass:"item-container",class:{active:e==t.select},on:{click:function(a){t.selectRedpacket(e,s.price,s.old_price)}}},[a("div",{staticClass:"left"},[t._v(t._s(s.name))]),t._v(" "),a("div",{staticClass:"right"},[a("span",{staticClass:"old-price"},[t._v("¥"),a("span",[t._v(t._s(s.old_price))])]),t._v(" "),a("span",{staticClass:"price"},[t._v("¥"),a("span",[t._v(t._s(s.price))])])])])])})],2),t._v(" "),t._l(t.redpack.redpackets,function(s,e){return e==t.select?a("div",{staticClass:"redpacket-wrap"},[a("div",{staticClass:"redpacket-wrap-title "},[t._v(t._s(s.name)+"红包套餐内容")]),t._v(" "),t._l(s.data,function(s,e){return a("div",{staticClass:"redpacket-item"},[a("div",{staticClass:"redpacket-item-body"},[a("div",{staticClass:"item-body-price"},[t._v("\n\t\t\t\t\t\t￥\n\t\t\t\t\t\t"),a("span",{staticClass:"body-price-number"},[a("strong",[t._v(t._s(s.discount))])])]),t._v(" "),a("div",{staticClass:"item-body-name"},[a("div",{staticClass:"name-general"},[t._v(t._s(s.name))]),t._v(" "),a("div",{staticClass:"name-reduction"},[t._v("满"+t._s(s.condition)+"元可用")])])])])})],2):t._e()}),t._v(" "),a("router-link",{staticClass:"buy-record van-hairline--top van-hairline--bottom",attrs:{to:t.util.getUrl({path:"/pages/mealRedpacket/order"})}},[t._v("\n\t\t\t购买记录\n\t\t\t"),a("van-icon",{attrs:{name:"right"}})],1),t._v(" "),a("div",{staticClass:"meal-explain"},[t._v("\n\t\t\t套餐规则\n\t\t\t"),a("van-icon",{attrs:{name:"question"}})],1),t._v(" "),a("div",{staticClass:"submit-container"},[a("div",{staticClass:"final-price"},[a("div",{staticClass:"text"},[t._v("总价")]),t._v(" "),a("div",{staticClass:"price"},[t._v("￥"),a("span",[t._v(t._s(t.price))])]),t._v(" "),a("div",{staticClass:"old-price"},[t._v("￥"),a("span",[t._v(t._s(t.old_price))])])]),t._v(" "),a("div",{staticClass:"submit-button"},[t._v("立即购买")])])],2)],1)},staticRenderFns:[]};var c=a("VU/8")(e,i,!1,function(t){a("qqHF")},null,null);s.default=c.exports},qqHF:function(t,s){}});
//# sourceMappingURL=58.c59e47abc1f3751c00c4.js.map