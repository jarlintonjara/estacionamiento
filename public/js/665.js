(self.webpackChunk=self.webpackChunk||[]).push([[665],{7757:(t,e,r)=>{t.exports=r(5666)},5666:t=>{var e=function(t){"use strict";var e,r=Object.prototype,n=r.hasOwnProperty,a="function"==typeof Symbol?Symbol:{},o=a.iterator||"@@iterator",i=a.asyncIterator||"@@asyncIterator",s=a.toStringTag||"@@toStringTag";function c(t,e,r){return Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{c({},"")}catch(t){c=function(t,e,r){return t[e]=r}}function l(t,e,r,n){var a=e&&e.prototype instanceof h?e:h,o=Object.create(a.prototype),i=new $(n||[]);return o._invoke=function(t,e,r){var n=d;return function(a,o){if(n===m)throw new Error("Generator is already running");if(n===p){if("throw"===a)throw o;return N()}for(r.method=a,r.arg=o;;){var i=r.delegate;if(i){var s=L(i,r);if(s){if(s===v)continue;return s}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if(n===d)throw n=p,r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n=m;var c=u(t,e,r);if("normal"===c.type){if(n=r.done?p:f,c.arg===v)continue;return{value:c.arg,done:r.done}}"throw"===c.type&&(n=p,r.method="throw",r.arg=c.arg)}}}(t,r,i),o}function u(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(t){return{type:"throw",arg:t}}}t.wrap=l;var d="suspendedStart",f="suspendedYield",m="executing",p="completed",v={};function h(){}function g(){}function y(){}var w={};c(w,o,(function(){return this}));var _=Object.getPrototypeOf,b=_&&_(_(P([])));b&&b!==r&&n.call(b,o)&&(w=b);var x=y.prototype=h.prototype=Object.create(w);function C(t){["next","throw","return"].forEach((function(e){c(t,e,(function(t){return this._invoke(e,t)}))}))}function E(t,e){function r(a,o,i,s){var c=u(t[a],t,o);if("throw"!==c.type){var l=c.arg,d=l.value;return d&&"object"==typeof d&&n.call(d,"__await")?e.resolve(d.__await).then((function(t){r("next",t,i,s)}),(function(t){r("throw",t,i,s)})):e.resolve(d).then((function(t){l.value=t,i(l)}),(function(t){return r("throw",t,i,s)}))}s(c.arg)}var a;this._invoke=function(t,n){function o(){return new e((function(e,a){r(t,n,e,a)}))}return a=a?a.then(o,o):o()}}function L(t,r){var n=t.iterator[r.method];if(n===e){if(r.delegate=null,"throw"===r.method){if(t.iterator.return&&(r.method="return",r.arg=e,L(t,r),"throw"===r.method))return v;r.method="throw",r.arg=new TypeError("The iterator does not provide a 'throw' method")}return v}var a=u(n,t.iterator,r.arg);if("throw"===a.type)return r.method="throw",r.arg=a.arg,r.delegate=null,v;var o=a.arg;return o?o.done?(r[t.resultName]=o.value,r.next=t.nextLoc,"return"!==r.method&&(r.method="next",r.arg=e),r.delegate=null,v):o:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,v)}function k(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function S(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function $(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(k,this),this.reset(!0)}function P(t){if(t){var r=t[o];if(r)return r.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var a=-1,i=function r(){for(;++a<t.length;)if(n.call(t,a))return r.value=t[a],r.done=!1,r;return r.value=e,r.done=!0,r};return i.next=i}}return{next:N}}function N(){return{value:e,done:!0}}return g.prototype=y,c(x,"constructor",y),c(y,"constructor",g),g.displayName=c(y,s,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===g||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,y):(t.__proto__=y,c(t,s,"GeneratorFunction")),t.prototype=Object.create(x),t},t.awrap=function(t){return{__await:t}},C(E.prototype),c(E.prototype,i,(function(){return this})),t.AsyncIterator=E,t.async=function(e,r,n,a,o){void 0===o&&(o=Promise);var i=new E(l(e,r,n,a),o);return t.isGeneratorFunction(r)?i:i.next().then((function(t){return t.done?t.value:i.next()}))},C(x),c(x,s,"Generator"),c(x,o,(function(){return this})),c(x,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var e=[];for(var r in t)e.push(r);return e.reverse(),function r(){for(;e.length;){var n=e.pop();if(n in t)return r.value=n,r.done=!1,r}return r.done=!0,r}},t.values=P,$.prototype={constructor:$,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=e,this.done=!1,this.delegate=null,this.method="next",this.arg=e,this.tryEntries.forEach(S),!t)for(var r in this)"t"===r.charAt(0)&&n.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=e)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var r=this;function a(n,a){return s.type="throw",s.arg=t,r.next=n,a&&(r.method="next",r.arg=e),!!a}for(var o=this.tryEntries.length-1;o>=0;--o){var i=this.tryEntries[o],s=i.completion;if("root"===i.tryLoc)return a("end");if(i.tryLoc<=this.prev){var c=n.call(i,"catchLoc"),l=n.call(i,"finallyLoc");if(c&&l){if(this.prev<i.catchLoc)return a(i.catchLoc,!0);if(this.prev<i.finallyLoc)return a(i.finallyLoc)}else if(c){if(this.prev<i.catchLoc)return a(i.catchLoc,!0)}else{if(!l)throw new Error("try statement without catch or finally");if(this.prev<i.finallyLoc)return a(i.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var a=this.tryEntries[r];if(a.tryLoc<=this.prev&&n.call(a,"finallyLoc")&&this.prev<a.finallyLoc){var o=a;break}}o&&("break"===t||"continue"===t)&&o.tryLoc<=e&&e<=o.finallyLoc&&(o=null);var i=o?o.completion:{};return i.type=t,i.arg=e,o?(this.method="next",this.next=o.finallyLoc,v):this.complete(i)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),v},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),S(r),v}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.tryLoc===t){var n=r.completion;if("throw"===n.type){var a=n.arg;S(r)}return a}}throw new Error("illegal catch attempt")},delegateYield:function(t,r,n){return this.delegate={iterator:P(t),resultName:r,nextLoc:n},"next"===this.method&&(this.arg=e),v}},t}(t.exports);try{regeneratorRuntime=e}catch(t){"object"==typeof globalThis?globalThis.regeneratorRuntime=e:Function("r","regeneratorRuntime = r")(e)}},2665:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>u});var n=r(7757),a=r.n(n);function o(t,e,r,n,a,o,i){try{var s=t[o](i),c=s.value}catch(t){return void r(t)}s.done?e(c):Promise.resolve(c).then(n,a)}function i(t){return function(){var e=this,r=arguments;return new Promise((function(n,a){var i=t.apply(e,r);function s(t){o(i,n,a,s,c,"next",t)}function c(t){o(i,n,a,s,c,"throw",t)}s(void 0)}))}}function s(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}var c;const l={name:"Setting",components:{},data:function(){var t;return s(t={isLoading:!1,items:[],user:{},datos:{time:"",sede_id:0,email:"",email1:"",email2:"",email3:"",email4:""},titulo:""},"isLoading",!1),s(t,"sedes",[]),t},mounted:(c=i(a().mark((function t(){return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,this.init();case 2:case"end":return t.stop()}}),t,this)}))),function(){return c.apply(this,arguments)}),methods:{init:function(){var t=this;return i(a().mark((function e(){var r;return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return r=localStorage.getItem("access_token"),e.next=3,axios.get("api/getSession/"+r).then((function(e){t.user=e.data}));case 3:t.renderCardSettings(t.user.sede_id);case 4:case"end":return e.stop()}}),e)})))()},renderCardSettings:function(){var t=arguments,e=this;return i(a().mark((function r(){var n;return a().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return n=t.length>0&&void 0!==t[0]?t[0]:0,r.next=3,e.axios.get("/api/setting?sede_id=".concat(n)).then((function(t){e.datos=t.data[0],e.getSedes()})).catch((function(t){console.log(t),e.datos=[]}));case 3:case"end":return r.stop()}}),r)})))()},getSedes:function(){var t=this;return i(a().mark((function e(){return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.axios.get("/api/sede").then((function(e){t.sedes=e.data.sedes})).catch((function(t){console.log(t)}));case 2:case"end":return e.stop()}}),e)})))()},guardar:function(){var t=this;this.isLoading=!0,axios.put("/api/setting/"+this.datos.id,this.datos).then((function(e){t.items=[].concat(e.data),$("#modalForm").modal("hide"),t.$swal.fire("Editado correctamente!","","success"),t.init()})).catch((function(t){console.log(t)})).finally((function(){t.isLoading=!1}))},envio:function(){var t=this;axios.post("/api/emailProgramacionSemanal").then((function(e){e.data.success?t.$swal.fire("Correo enviado","","success"):t.$swal.fire({icon:"error",title:"Error de envio",text:e.data.error})})).catch((function(e){t.$swal.fire({icon:"error",title:"Error de envio",text:"Ocurrio un error"})}))},changeSelect:function(t){this.renderCardSettings(t.target.value)}}};const u=(0,r(1900).Z)(l,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("main",{staticClass:"page-content",attrs:{id:"js-page-content",role:"main"}},[t._m(0),t._v(" "),r("br"),t._v(" "),r("div",{staticClass:"col-lg-12"},[r("div",{staticClass:"panel-hdr mb-2 py-4"},[r("div",{staticClass:"panel-toolbar"},[r("select",{directives:[{name:"model",rawName:"v-model",value:t.datos.sede_id,expression:"datos.sede_id"}],staticClass:"browser-default custom-select",staticStyle:{width:"200px"},attrs:{name:"sede",id:"sede"},on:{change:[function(e){var r=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){return"_value"in t?t._value:t.value}));t.$set(t.datos,"sede_id",e.target.multiple?r:r[0])},t.changeSelect]}},t._l(t.sedes,(function(e){return r("option",{key:e.id+e.name,domProps:{value:e.id}},[t._v(t._s(e.name))])})),0)])]),t._v(" "),r("div",{staticClass:"panel",attrs:{id:"panel-4"}},[t._m(1),t._v(" "),r("div",{staticClass:"panel-container show"},[r("div",{staticClass:"panel-content"},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-md-12"},[r("button",{staticClass:"btn btn-success",on:{click:t.envio}},[t._v("Envio de correo")])])]),r("br"),t._v(" "),r("div",{staticClass:"row"},[r("div",{staticClass:"col-md-6"},[r("div",{staticClass:"input-group mb-3"},[t._m(2),t._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.datos.time,expression:"datos.time"}],staticClass:"form-control",attrs:{id:"time",type:"time",name:"time"},domProps:{value:t.datos.time},on:{input:function(e){e.target.composing||t.$set(t.datos,"time",e.target.value)}}})])]),t._v(" "),r("div",{staticClass:"col-md-6"},[r("div",{staticClass:"input-group mb-3"},[t._m(3),t._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.datos.email,expression:"datos.email"}],staticClass:"form-control",attrs:{type:"email",id:"email",name:"email","aria-label":"Email"},domProps:{value:t.datos.email},on:{input:function(e){e.target.composing||t.$set(t.datos,"email",e.target.value)}}})])]),t._v(" "),r("div",{staticClass:"col-md-12"},[r("div",{staticClass:"input-group"},[t._m(4),t._v(" "),r("div",{staticClass:"col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.datos.email1,expression:"datos.email1"}],staticClass:"form-control",attrs:{type:"email",id:"email1",name:"email1","aria-label":"Email1"},domProps:{value:t.datos.email1},on:{input:function(e){e.target.composing||t.$set(t.datos,"email1",e.target.value)}}})]),t._v(" "),r("div",{staticClass:"col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.datos.email2,expression:"datos.email2"}],staticClass:"form-control",attrs:{type:"email",id:"email2",name:"email2","aria-label":"Email2"},domProps:{value:t.datos.email2},on:{input:function(e){e.target.composing||t.$set(t.datos,"email2",e.target.value)}}})]),t._v(" "),r("div",{staticClass:"col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.datos.email3,expression:"datos.email3"}],staticClass:"form-control",attrs:{type:"email",id:"email3",name:"email3","aria-label":"Email3"},domProps:{value:t.datos.email3},on:{input:function(e){e.target.composing||t.$set(t.datos,"email3",e.target.value)}}})]),t._v(" "),r("div",{staticClass:"col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.datos.email4,expression:"datos.email4"}],staticClass:"form-control",attrs:{type:"email",id:"email4",name:"email4","aria-label":"Email4"},domProps:{value:t.datos.email4},on:{input:function(e){e.target.composing||t.$set(t.datos,"email4",e.target.value)}}})])])])]),t._v(" "),r("br"),t._v(" "),r("div",{staticClass:"row"},[r("div",{staticClass:"col align-self-end"},[r("button",{staticClass:"btn btn-primary",attrs:{type:"submit"},on:{click:function(e){return e.preventDefault(),t.guardar.apply(null,arguments)}}},[t.isLoading?t._e():r("span",[t._v("Guardar Cambios")]),t._v(" "),t.isLoading?r("span",[t._v("Guardando...")]):t._e()])])])])])])])])}),[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"subheader"},[r("h1",{staticClass:"subheader-title"},[r("i",{staticClass:"subheader-icon fal fa-chart-area"}),t._v(" Configuraciones \n            "),r("small")])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"panel-hdr"},[r("h2",{staticStyle:{"text-align":"center","font-size":"1.125rem"}},[r("b",[t._v("Envío de correo")])]),t._v(" "),r("div",{staticClass:"panel-toolbar"},[r("button",{staticClass:"btn btn-panel waves-effect waves-themed",attrs:{"data-action":"panel-collapse","data-toggle":"tooltip","data-offset":"0,10","data-original-title":"Collapse"}}),t._v(" "),r("button",{staticClass:"btn btn-panel waves-effect waves-themed",attrs:{"data-action":"panel-fullscreen","data-toggle":"tooltip","data-offset":"0,10","data-original-title":"Fullscreen"}})])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"input-group-prepend"},[r("span",{staticClass:"input-group-text"},[t._v("Hora")])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"input-group-prepend"},[r("span",{staticClass:"input-group-text"},[t._v("Correo principal")])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"input-group-prepend col-12 col-sm-12"},[r("span",{staticClass:"input-group-text"},[t._v("Correos de copia")])])}],!1,null,null,null).exports}}]);