(self.webpackChunk=self.webpackChunk||[]).push([[522],{7757:(t,e,r)=>{t.exports=r(5666)},5666:t=>{var e=function(t){"use strict";var e,r=Object.prototype,n=r.hasOwnProperty,a="function"==typeof Symbol?Symbol:{},i=a.iterator||"@@iterator",o=a.asyncIterator||"@@asyncIterator",s=a.toStringTag||"@@toStringTag";function c(t,e,r){return Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{c({},"")}catch(t){c=function(t,e,r){return t[e]=r}}function l(t,e,r,n){var a=e&&e.prototype instanceof g?e:g,i=Object.create(a.prototype),o=new S(n||[]);return i._invoke=function(t,e,r){var n=f;return function(a,i){if(n===v)throw new Error("Generator is already running");if(n===h){if("throw"===a)throw i;return O()}for(r.method=a,r.arg=i;;){var o=r.delegate;if(o){var s=E(o,r);if(s){if(s===p)continue;return s}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if(n===f)throw n=h,r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n=v;var c=u(t,e,r);if("normal"===c.type){if(n=r.done?h:d,c.arg===p)continue;return{value:c.arg,done:r.done}}"throw"===c.type&&(n=h,r.method="throw",r.arg=c.arg)}}}(t,r,o),i}function u(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(t){return{type:"throw",arg:t}}}t.wrap=l;var f="suspendedStart",d="suspendedYield",v="executing",h="completed",p={};function g(){}function m(){}function _(){}var y={};c(y,i,(function(){return this}));var w=Object.getPrototypeOf,b=w&&w(w(N([])));b&&b!==r&&n.call(b,i)&&(y=b);var x=_.prototype=g.prototype=Object.create(y);function C(t){["next","throw","return"].forEach((function(e){c(t,e,(function(t){return this._invoke(e,t)}))}))}function k(t,e){function r(a,i,o,s){var c=u(t[a],t,i);if("throw"!==c.type){var l=c.arg,f=l.value;return f&&"object"==typeof f&&n.call(f,"__await")?e.resolve(f.__await).then((function(t){r("next",t,o,s)}),(function(t){r("throw",t,o,s)})):e.resolve(f).then((function(t){l.value=t,o(l)}),(function(t){return r("throw",t,o,s)}))}s(c.arg)}var a;this._invoke=function(t,n){function i(){return new e((function(e,a){r(t,n,e,a)}))}return a=a?a.then(i,i):i()}}function E(t,r){var n=t.iterator[r.method];if(n===e){if(r.delegate=null,"throw"===r.method){if(t.iterator.return&&(r.method="return",r.arg=e,E(t,r),"throw"===r.method))return p;r.method="throw",r.arg=new TypeError("The iterator does not provide a 'throw' method")}return p}var a=u(n,t.iterator,r.arg);if("throw"===a.type)return r.method="throw",r.arg=a.arg,r.delegate=null,p;var i=a.arg;return i?i.done?(r[t.resultName]=i.value,r.next=t.nextLoc,"return"!==r.method&&(r.method="next",r.arg=e),r.delegate=null,p):i:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,p)}function L(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function j(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function S(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(L,this),this.reset(!0)}function N(t){if(t){var r=t[i];if(r)return r.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var a=-1,o=function r(){for(;++a<t.length;)if(n.call(t,a))return r.value=t[a],r.done=!1,r;return r.value=e,r.done=!0,r};return o.next=o}}return{next:O}}function O(){return{value:e,done:!0}}return m.prototype=_,c(x,"constructor",_),c(_,"constructor",m),m.displayName=c(_,s,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===m||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,_):(t.__proto__=_,c(t,s,"GeneratorFunction")),t.prototype=Object.create(x),t},t.awrap=function(t){return{__await:t}},C(k.prototype),c(k.prototype,o,(function(){return this})),t.AsyncIterator=k,t.async=function(e,r,n,a,i){void 0===i&&(i=Promise);var o=new k(l(e,r,n,a),i);return t.isGeneratorFunction(r)?o:o.next().then((function(t){return t.done?t.value:o.next()}))},C(x),c(x,s,"Generator"),c(x,i,(function(){return this})),c(x,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var e=[];for(var r in t)e.push(r);return e.reverse(),function r(){for(;e.length;){var n=e.pop();if(n in t)return r.value=n,r.done=!1,r}return r.done=!0,r}},t.values=N,S.prototype={constructor:S,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=e,this.done=!1,this.delegate=null,this.method="next",this.arg=e,this.tryEntries.forEach(j),!t)for(var r in this)"t"===r.charAt(0)&&n.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=e)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var r=this;function a(n,a){return s.type="throw",s.arg=t,r.next=n,a&&(r.method="next",r.arg=e),!!a}for(var i=this.tryEntries.length-1;i>=0;--i){var o=this.tryEntries[i],s=o.completion;if("root"===o.tryLoc)return a("end");if(o.tryLoc<=this.prev){var c=n.call(o,"catchLoc"),l=n.call(o,"finallyLoc");if(c&&l){if(this.prev<o.catchLoc)return a(o.catchLoc,!0);if(this.prev<o.finallyLoc)return a(o.finallyLoc)}else if(c){if(this.prev<o.catchLoc)return a(o.catchLoc,!0)}else{if(!l)throw new Error("try statement without catch or finally");if(this.prev<o.finallyLoc)return a(o.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var a=this.tryEntries[r];if(a.tryLoc<=this.prev&&n.call(a,"finallyLoc")&&this.prev<a.finallyLoc){var i=a;break}}i&&("break"===t||"continue"===t)&&i.tryLoc<=e&&e<=i.finallyLoc&&(i=null);var o=i?i.completion:{};return o.type=t,o.arg=e,i?(this.method="next",this.next=i.finallyLoc,p):this.complete(o)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),p},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),j(r),p}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.tryLoc===t){var n=r.completion;if("throw"===n.type){var a=n.arg;j(r)}return a}}throw new Error("illegal catch attempt")},delegateYield:function(t,r,n){return this.delegate={iterator:N(t),resultName:r,nextLoc:n},"next"===this.method&&(this.arg=e),p}},t}(t.exports);try{regeneratorRuntime=e}catch(t){"object"==typeof globalThis?globalThis.regeneratorRuntime=e:Function("r","regeneratorRuntime = r")(e)}},1522:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>d});var n=r(7757),a=r.n(n);const i={name:"sidebar",props:["session"],watch:{session:function(t){this.user=t}},data:function(){return{user:{role_id:0}}}};var o=r(1900);function s(t,e,r,n,a,i,o){try{var s=t[i](o),c=s.value}catch(t){return void r(t)}s.done?e(c):Promise.resolve(c).then(n,a)}function c(t){return function(){var e=this,r=arguments;return new Promise((function(n,a){var i=t.apply(e,r);function o(t){s(i,n,a,o,c,"next",t)}function c(t){s(i,n,a,o,c,"throw",t)}o(void 0)}))}}const l={name:"Navbar",props:["session"],data:function(){return{test:2,user:{nombre:"",multisedes:[],sede:[],curr_sede_id:0}}},watch:{session:function(t){this.user=t}},methods:{logout:function(){var t=this;return c(a().mark((function e(){var r,n;return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return r=localStorage.getItem("access_token"),n=r||"",e.next=4,axios.post("/api/logout",{access_token:n}).then((function(){localStorage.removeItem("access_token"),t.$router.push({name:"Login"})}));case 4:case"end":return e.stop()}}),e)})))()},changeSede:function(t){var e=this;return c(a().mark((function r(){return a().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,axios.post("/api/change-sede",{curr_sede_id:t.target.value,user:e.user.id}).then((function(t){t.status&&window.location.reload()}));case 2:case"end":return r.stop()}}),r)})))()}}};function u(t,e,r,n,a,i,o){try{var s=t[i](o),c=s.value}catch(t){return void r(t)}s.done?e(c):Promise.resolve(c).then(n,a)}const f={name:"Layout",components:{Sidebar:(0,o.Z)(i,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("aside",{staticClass:"page-sidebar"},[t._m(0),t._v(" "),r("nav",{staticClass:"primary-nav",attrs:{id:"js-primary-nav",role:"navigation"}},[t._m(1),t._v(" "),r("ul",{staticClass:"nav-menu",attrs:{id:"js-nav-menu"}},[r("li",{staticClass:"active open"},[r("ul",[r("router-link",{attrs:{tag:"li",to:"/dashboard","active-class":"active"}},[r("a",[t._v("Inicio")])]),t._v(" "),1==t.user.role_id?r("router-link",{attrs:{tag:"li",to:"/usuarios","active-class":"active"}},[r("a",[t._v("Usuarios")])]):t._e(),t._v(" "),1==t.user.role_id?r("router-link",{attrs:{tag:"li",to:"/sedes","active-class":"active"}},[r("a",[t._v("Sedes")])]):t._e(),t._v(" "),1==t.user.role_id?r("router-link",{attrs:{tag:"li",to:"/estacionamiento","active-class":"active"}},[r("a",[t._v("Estacionamiento")])]):t._e(),t._v(" "),1==t.user.role_id||3==t.user.role_id||2==t.user.role_id?r("router-link",{attrs:{tag:"li",to:"/reservas","active-class":"active"}},[r("a",[t._v("Reservas")])]):t._e(),t._v(" "),1==t.user.role_id?r("router-link",{attrs:{tag:"li",to:"/rol","active-class":"active"}},[r("a",[t._v("Rol")])]):t._e(),t._v(" "),1==t.user.role_id?r("router-link",{attrs:{tag:"li",to:"/settings","active-class":"active"}},[r("a",[t._v("Configuración")])]):t._e()],1)])]),t._v(" "),r("div",{staticClass:"filter-message js-filter-message bg-success-600"})])])}),[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"page-logo"},[r("a",{staticClass:"page-logo-link press-scale-down d-flex align-items-center position-relative",attrs:{href:"#","data-toggle":"modal","data-target":"#modal-shortcut"}},[r("img",{staticStyle:{width:"50%"},attrs:{src:"/images/logo_principal.jpeg",alt:"derco","aria-roledescription":"logo"}}),t._v(" "),r("span",{staticClass:"position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"})])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"nav-filter"},[r("div",{staticClass:"position-relative"},[r("input",{staticClass:"form-control",attrs:{type:"text",id:"nav_filter_input",placeholder:"Filter menu",tabindex:"0"}}),t._v(" "),r("a",{staticClass:"btn-primary btn-search-close js-waves-off",attrs:{href:"#",onclick:"return false;","data-action":"toggle","data-class":"list-filter-active","data-target":".page-sidebar"}},[r("i",{staticClass:"fal fa-chevron-up"})])])])}],!1,null,null,null).exports,Navbar:(0,o.Z)(l,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("header",{staticClass:"page-header",attrs:{role:"banner"}},[t._m(0),t._v(" "),t._m(1),t._v(" "),t._m(2),t._v(" "),r("div",{staticClass:"ml-auto d-flex"},[r("div",{staticClass:"d-flex align-items-center gap-3 justify-content-center"},[r("div",[r("select",{directives:[{name:"model",rawName:"v-model",value:t.user.curr_sede_id,expression:"user.curr_sede_id"}],staticClass:"form-select fw-bold",attrs:{name:"multiSede",id:"multiSede",disabled:1==t.user.multisedes.length},on:{change:[function(e){var r=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){return"_value"in t?t._value:t.value}));t.$set(t.user,"curr_sede_id",e.target.multiple?r:r[0])},t.changeSede]}},t._l(t.user.multisedes,(function(e){return r("option",{key:e.sede_id,domProps:{value:e.sede_id}},[t._v("SEDE "+t._s(e.sede.name))])})),0)]),t._v(" "),r("div",{staticClass:"header-icon d-flex align-items-center justify-content-center ml-2",attrs:{"data-toggle":"dropdown",title:"Usuario"}},[r("i",{staticClass:"fas fa-user"}),t._v(" "),r("span",[t._v(t._s(t.user.nombre))])]),t._v(" "),r("div",{staticClass:"dropdown-menu dropdown-menu-animated dropdown-lg"},[t._m(3),t._v(" "),r("div",{staticClass:"dropdown-divider m-0"}),t._v(" "),r("router-link",{staticClass:"dropdown-item fw-500 pt-3 pb-3",attrs:{to:{name:"perfil",query:{ps:t.user}}}},[r("span",{attrs:{"data-i18n":"drpdwn.page-logout"}},[t._v("Perfil")])]),t._v(" "),r("div",{staticClass:"dropdown-divider m-0"}),t._v(" "),r("a",{staticClass:"dropdown-item fw-500 pt-3 pb-3",attrs:{href:""},on:{click:function(e){return e.preventDefault(),t.logout.apply(null,arguments)}}},[r("span",{attrs:{"data-i18n":"drpdwn.page-logout"}},[t._v("Logout")])])],1)])])])}),[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"hidden-md-down dropdown-icon-menu position-relative"},[r("a",{staticClass:"header-btn btn js-waves-off",attrs:{href:"#","data-action":"toggle","data-class":"nav-function-hidden",title:"Hide Navigation"}},[r("i",{staticClass:"ni ni-menu"})]),t._v(" "),r("ul",[r("li",[r("a",{staticClass:"btn js-waves-off",attrs:{href:"#","data-action":"toggle","data-class":"nav-function-minify",title:"Minify Navigation"}},[r("i",{staticClass:"ni ni-minify-nav"})])]),t._v(" "),r("li",[r("a",{staticClass:"btn js-waves-off",attrs:{href:"#","data-action":"toggle","data-class":"nav-function-fixed",title:"Lock Navigation"}},[r("i",{staticClass:"ni ni-lock-nav"})])])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"hidden-lg-up"},[e("a",{staticClass:"header-btn btn press-scale-down",attrs:{href:"#","data-action":"toggle","data-class":"mobile-nav-on"}},[e("i",{staticClass:"ni ni-menu"})])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"search"},[r("form",{staticClass:"app-forms hidden-xs-down",attrs:{role:"search",action:"https://smartadmin.lodev09.com/page_search.php",autocomplete:"off"}},[r("input",{staticClass:"form-control",attrs:{type:"text",id:"search-field",placeholder:"Buscar",tabindex:"1"}}),t._v(" "),r("a",{staticClass:"btn-danger btn-search-close js-waves-off d-none",attrs:{href:"#",onclick:"return false;","data-action":"toggle","data-class":"mobile-search-on"}},[r("i",{staticClass:"fal fa-times"})])])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top"},[r("div",{staticClass:"d-flex flex-row align-items-center mt-1 mb-1 color-white"},[r("span",{staticClass:"mr-2"}),t._v(" "),r("div",{staticClass:"info-card-text"},[r("div",{staticClass:"fs-lg text-truncate text-truncate-lg"})])])])}],!1,null,null,null).exports},data:function(){return{user:null}},mounted:function(){this.init()},methods:{init:function(){var t,e=this;return(t=a().mark((function t(){var r;return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return r=localStorage.getItem("access_token"),t.next=3,axios.get("api/getSession/"+r).then((function(t){e.user=t.data}));case 3:case"end":return t.stop()}}),t)})),function(){var e=this,r=arguments;return new Promise((function(n,a){var i=t.apply(e,r);function o(t){u(i,n,a,o,s,"next",t)}function s(t){u(i,n,a,o,s,"throw",t)}o(void 0)}))})()}}};const d=(0,o.Z)(f,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[r("div",{staticClass:"page-wrapper"},[r("div",{staticClass:"page-inner"},[r("Sidebar",{attrs:{session:t.user}}),t._v(" "),r("div",{staticClass:"page-content-wrapper"},[r("Navbar",{attrs:{session:t.user}}),t._v(" "),r("router-view"),t._v(" "),r("div",{staticClass:"page-content-overlay",attrs:{"data-action":"toggle","data-class":"mobile-nav-on"}}),t._v(" "),r("footer",{staticClass:"page-footer",attrs:{role:"contentinfo"}})],1)],1)])])}),[],!1,null,null,null).exports}}]);