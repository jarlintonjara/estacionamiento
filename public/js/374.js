(self.webpackChunk=self.webpackChunk||[]).push([[374],{7757:(t,e,r)=>{t.exports=r(5666)},5666:t=>{var e=function(t){"use strict";var e,r=Object.prototype,a=r.hasOwnProperty,o="function"==typeof Symbol?Symbol:{},n=o.iterator||"@@iterator",i=o.asyncIterator||"@@asyncIterator",s=o.toStringTag||"@@toStringTag";function l(t,e,r){return Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{l({},"")}catch(t){l=function(t,e,r){return t[e]=r}}function c(t,e,r,a){var o=e&&e.prototype instanceof h?e:h,n=Object.create(o.prototype),i=new N(a||[]);return n._invoke=function(t,e,r){var a=d;return function(o,n){if(a===f)throw new Error("Generator is already running");if(a===v){if("throw"===o)throw n;return F()}for(r.method=o,r.arg=n;;){var i=r.delegate;if(i){var s=E(i,r);if(s){if(s===m)continue;return s}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if(a===d)throw a=v,r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);a=f;var l=u(t,e,r);if("normal"===l.type){if(a=r.done?v:p,l.arg===m)continue;return{value:l.arg,done:r.done}}"throw"===l.type&&(a=v,r.method="throw",r.arg=l.arg)}}}(t,r,i),n}function u(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(t){return{type:"throw",arg:t}}}t.wrap=c;var d="suspendedStart",p="suspendedYield",f="executing",v="completed",m={};function h(){}function g(){}function _(){}var y={};l(y,n,(function(){return this}));var b=Object.getPrototypeOf,w=b&&b(b(P([])));w&&w!==r&&a.call(w,n)&&(y=w);var C=_.prototype=h.prototype=Object.create(y);function x(t){["next","throw","return"].forEach((function(e){l(t,e,(function(t){return this._invoke(e,t)}))}))}function k(t,e){function r(o,n,i,s){var l=u(t[o],t,n);if("throw"!==l.type){var c=l.arg,d=c.value;return d&&"object"==typeof d&&a.call(d,"__await")?e.resolve(d.__await).then((function(t){r("next",t,i,s)}),(function(t){r("throw",t,i,s)})):e.resolve(d).then((function(t){c.value=t,i(c)}),(function(t){return r("throw",t,i,s)}))}s(l.arg)}var o;this._invoke=function(t,a){function n(){return new e((function(e,o){r(t,a,e,o)}))}return o=o?o.then(n,n):n()}}function E(t,r){var a=t.iterator[r.method];if(a===e){if(r.delegate=null,"throw"===r.method){if(t.iterator.return&&(r.method="return",r.arg=e,E(t,r),"throw"===r.method))return m;r.method="throw",r.arg=new TypeError("The iterator does not provide a 'throw' method")}return m}var o=u(a,t.iterator,r.arg);if("throw"===o.type)return r.method="throw",r.arg=o.arg,r.delegate=null,m;var n=o.arg;return n?n.done?(r[t.resultName]=n.value,r.next=t.nextLoc,"return"!==r.method&&(r.method="next",r.arg=e),r.delegate=null,m):n:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,m)}function L(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function $(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function N(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(L,this),this.reset(!0)}function P(t){if(t){var r=t[n];if(r)return r.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var o=-1,i=function r(){for(;++o<t.length;)if(a.call(t,o))return r.value=t[o],r.done=!1,r;return r.value=e,r.done=!0,r};return i.next=i}}return{next:F}}function F(){return{value:e,done:!0}}return g.prototype=_,l(C,"constructor",_),l(_,"constructor",g),g.displayName=l(_,s,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===g||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,_):(t.__proto__=_,l(t,s,"GeneratorFunction")),t.prototype=Object.create(C),t},t.awrap=function(t){return{__await:t}},x(k.prototype),l(k.prototype,i,(function(){return this})),t.AsyncIterator=k,t.async=function(e,r,a,o,n){void 0===n&&(n=Promise);var i=new k(c(e,r,a,o),n);return t.isGeneratorFunction(r)?i:i.next().then((function(t){return t.done?t.value:i.next()}))},x(C),l(C,s,"Generator"),l(C,n,(function(){return this})),l(C,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var e=[];for(var r in t)e.push(r);return e.reverse(),function r(){for(;e.length;){var a=e.pop();if(a in t)return r.value=a,r.done=!1,r}return r.done=!0,r}},t.values=P,N.prototype={constructor:N,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=e,this.done=!1,this.delegate=null,this.method="next",this.arg=e,this.tryEntries.forEach($),!t)for(var r in this)"t"===r.charAt(0)&&a.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=e)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var r=this;function o(a,o){return s.type="throw",s.arg=t,r.next=a,o&&(r.method="next",r.arg=e),!!o}for(var n=this.tryEntries.length-1;n>=0;--n){var i=this.tryEntries[n],s=i.completion;if("root"===i.tryLoc)return o("end");if(i.tryLoc<=this.prev){var l=a.call(i,"catchLoc"),c=a.call(i,"finallyLoc");if(l&&c){if(this.prev<i.catchLoc)return o(i.catchLoc,!0);if(this.prev<i.finallyLoc)return o(i.finallyLoc)}else if(l){if(this.prev<i.catchLoc)return o(i.catchLoc,!0)}else{if(!c)throw new Error("try statement without catch or finally");if(this.prev<i.finallyLoc)return o(i.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var o=this.tryEntries[r];if(o.tryLoc<=this.prev&&a.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var n=o;break}}n&&("break"===t||"continue"===t)&&n.tryLoc<=e&&e<=n.finallyLoc&&(n=null);var i=n?n.completion:{};return i.type=t,i.arg=e,n?(this.method="next",this.next=n.finallyLoc,m):this.complete(i)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),m},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),$(r),m}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.tryLoc===t){var a=r.completion;if("throw"===a.type){var o=a.arg;$(r)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(t,r,a){return this.delegate={iterator:P(t),resultName:r,nextLoc:a},"next"===this.method&&(this.arg=e),m}},t}(t.exports);try{regeneratorRuntime=e}catch(t){"object"==typeof globalThis?globalThis.regeneratorRuntime=e:Function("r","regeneratorRuntime = r")(e)}},2374:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>l});var a=r(7757),o=r.n(a);function n(t,e,r,a,o,n,i){try{var s=t[n](i),l=s.value}catch(t){return void r(t)}s.done?e(l):Promise.resolve(l).then(a,o)}function i(t){return function(){var e=this,r=arguments;return new Promise((function(a,o){var i=t.apply(e,r);function s(t){n(i,a,o,s,l,"next",t)}function l(t){n(i,a,o,s,l,"throw",t)}s(void 0)}))}}const s={name:"Usuario",data:function(){return{users:[],roles:[],sedes:[],parkings:[],parkingsFilter:[],datos:{nombre:"",apellido:"",documento:"",email:"",cargo:"",area:"",role_id:"",parking_id:"",telefono:""},titulo:"",btnCrear:!1,isLoading:!1,btnEditar:!1,id:""}},mounted:function(){this.mostrarusers()},methods:{validarCampos:function(){return!!(this.datos.nombre&&this.datos.apellido&&this.datos.email&&this.datos.role_id)||(this.$swal.fire({icon:"error",title:"Oops...",text:"Completa los campos requeridos!"}),!1)},crear:function(){var t=this;return i(o().mark((function e(){return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.validarCampos();case 2:e.sent&&(t.isLoading=!0,axios.post("api/usuario",t.datos).then((function(e){console.log(e.data),t.users.push(e.data),$("#modalForm").modal("hide"),t.$swal.fire("Usuario creado correctamente!","","success"),t.mostrarusers()})).catch((function(t){console.log(t)})).finally((function(){t.isLoading=!1})));case 4:case"end":return e.stop()}}),e)})))()},editar:function(){var t=this;return i(o().mark((function e(){return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.validarCampos();case 2:e.sent&&(t.isLoading=!0,axios.put("/api/usuario/"+t.id,t.datos).then((function(e){console.log(e.data),t.users=[].concat(e.data),t.id="",$("#modalForm").modal("hide"),t.$swal.fire("Usuario editado correctamente!","","success"),t.mostrarusers()})).catch((function(t){console.log(t)})).finally((function(){t.isLoading=!1})));case 4:case"end":return e.stop()}}),e)})))()},borrar:function(t){var e=this;confirm("¿Confirma eliminar el registro?")&&this.axios.delete("/api/usuario/".concat(t)).then((function(t){e.users=[].concat(t.data)})).catch((function(t){console.log(t)}))},abrirModalCrear:function(){var t=this;this.datos={nombre:"",apellido:"",documento:"",email:"",role_id:"",parking_id:"",cargo:"",area:"",password:"",sede_id:""},this.parkingsFilter=[],this.parkings.map((function(e){t.users.find((function(t){return t.parking_id==e.id}))||t.parkingsFilter.push(e)})),this.titulo="Crear usuario",this.btnCrear=!0,this.btnEditar=!1,$("#modalForm").modal("show")},abrirModalEditar:function(t){var e=this;this.parkingsFilter=[],this.datos={nombre:t.nombre,apellido:t.apellido,documento:t.documento,email:t.email,role_id:t.role_id,parking_id:t.parking_id,password:t.password,sede_id:t.sede_id,cargo:t.cargo,area:t.area,telefono:t.telefono},this.parkings.map((function(t){e.users.find((function(e){return e.parking_id==t.id}))||e.parkingsFilter.push(t),t.id==e.datos.parking_id&&e.parkingsFilter.push(t)})),this.titulo=" Editar usuario",this.btnCrear=!1,this.btnEditar=!0,this.id=t.id,$("#modalForm").modal("show")},mostrarusers:function(){var t=this;return i(o().mark((function e(){return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.axios.get("/api/usuario").then((function(e){t.users=e.data.users,t.roles=e.data.roles,t.sedes=e.data.sedes,t.parkings=e.data.parkings})).catch((function(t){console.log(t)}));case 2:return e.next=4,$("#tableUser").DataTable();case 4:case"end":return e.stop()}}),e)})))()},cerrarModal:function(){$("#modalForm").modal("hide")},resetPassword:function(t){var e=this;this.$swal.fire({icon:"warning",title:"Resetear Contraseña",text:"¿Estas seguro de resetear la contraseña?"}).then(function(){var r=i(o().mark((function r(a){return o().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:if(!a.isConfirmed){r.next=3;break}return r.next=3,e.axios.post("/api/resetSimplePassword",{id_user:t}).then((function(t){e.$swal.fire({icon:"success",title:"Contraseña Generada",text:"La nueva contraseña es: "+t.data.pass})}));case 3:case"end":return r.stop()}}),r)})));return function(t){return r.apply(this,arguments)}}())}}};const l=(0,r(1900).Z)(s,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("main",{staticClass:"page-content",attrs:{id:"js-page-content",role:"main"}},[t._m(0),t._v(" "),r("div",{staticClass:"col-lg-12"},[r("div",{staticClass:"panel",attrs:{id:"panel-4"}},[r("div",{staticClass:"panel-container show"},[r("div",{staticClass:"panel-content"},[r("div",{staticClass:"panel-hdr"},[r("button",{staticClass:"btn btn-success",on:{click:t.abrirModalCrear}},[t._v("Nuevo")])]),r("br"),t._v(" "),r("table",{staticClass:"table table-bordered table-hover table-striped w-100",attrs:{id:"tableUser"}},[t._m(1),t._v(" "),r("tbody",t._l(t.users,(function(e){return r("tr",{key:e.id},[r("td",[t._v(t._s(e.nombre))]),t._v(" "),r("td",[t._v(t._s(e.apellido))]),t._v(" "),r("td",[t._v(t._s(e.role.description))]),t._v(" "),r("td",[t._v(t._s(e.documento))]),t._v(" "),r("td",[t._v(t._s(e.sede.name))]),t._v(" "),r("td",[t._v(t._s(e.email))]),t._v(" "),r("td",[t._v(t._s(t.$dateFormat(e.created_at)))]),t._v(" "),r("td",[r("button",{staticClass:"btn btn-warning",on:{click:function(r){return t.abrirModalEditar(e)}}},[r("i",{staticClass:"far fa-edit"})]),t._v(" "),r("button",{staticClass:"btn btn-success",attrs:{title:"Resetear Contraseña"},on:{click:function(r){return t.resetPassword(e.id)}}},[r("i",{staticClass:"fa fa-redo"})]),t._v(" "),r("button",{staticClass:"btn btn-danger",on:{click:function(r){return t.borrar(e.id)}}},[r("i",{staticClass:"fa fa-trash"})])])])})),0)])])])])]),t._v(" "),r("div",{staticClass:"modal fade",attrs:{id:"modalForm"}},[r("div",{staticClass:"modal-dialog modal-lg"},[r("div",{staticClass:"modal-content"},[r("div",{staticClass:"modal-header"},[r("h5",{staticClass:"modal-title"},[r("i",{staticClass:"fa fa-user-plus"}),t._v(" "+t._s(t.titulo)+"\n                ")]),t._v(" "),r("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"},on:{click:function(e){return e.preventDefault(),t.cerrarModal.apply(null,arguments)}}},[r("span",{attrs:{"aria-hidden":"true"}},[t._v("×")])])]),t._v(" "),r("form",[r("div",{staticClass:"modal-body"},[r("div",{staticClass:"form-row"},[r("div",{staticClass:"form-group col-md-6"},[r("label",{attrs:{for:"Nombres"}},[t._v("Nombres")]),t._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.datos.nombre,expression:"datos.nombre"}],staticClass:"form-control",attrs:{type:"text",id:"Nombres",placeholder:"Nombres",required:""},domProps:{value:t.datos.nombre},on:{input:function(e){e.target.composing||t.$set(t.datos,"nombre",e.target.value)}}})]),t._v(" "),r("div",{staticClass:"form-group col-md-6"},[r("label",{attrs:{for:"Apellidos"}},[t._v("Apellidos")]),t._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.datos.apellido,expression:"datos.apellido"}],staticClass:"form-control",attrs:{type:"text",id:"Apellidos",placeholder:"Apellidos",required:""},domProps:{value:t.datos.apellido},on:{input:function(e){e.target.composing||t.$set(t.datos,"apellido",e.target.value)}}})])]),t._v(" "),r("div",{staticClass:"form-row"},[r("div",{staticClass:"form-group col-md-4"},[r("label",{attrs:{for:"Documento"}},[t._v("Documento")]),t._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.datos.documento,expression:"datos.documento"}],staticClass:"form-control",attrs:{type:"text",id:"Documento",placeholder:"Documento"},domProps:{value:t.datos.documento},on:{input:function(e){e.target.composing||t.$set(t.datos,"documento",e.target.value)}}})]),t._v(" "),r("div",{staticClass:"form-group col-md-4"},[r("label",{attrs:{for:"Telefono"}},[t._v("Telefono")]),t._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.datos.telefono,expression:"datos.telefono"}],staticClass:"form-control",attrs:{type:"text",id:"Telefono",placeholder:"Documento"},domProps:{value:t.datos.telefono},on:{input:function(e){e.target.composing||t.$set(t.datos,"telefono",e.target.value)}}})]),t._v(" "),r("div",{staticClass:"form-group col-md-4"},[r("label",{attrs:{for:"Email"}},[t._v("Email")]),t._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.datos.email,expression:"datos.email"}],staticClass:"form-control",attrs:{type:"email",id:"Email",placeholder:"Email"},domProps:{value:t.datos.email},on:{input:function(e){e.target.composing||t.$set(t.datos,"email",e.target.value)}}})])]),t._v(" "),r("div",{staticClass:"form-row"},[r("div",{staticClass:"form-group col-md-4"},[r("label",{attrs:{for:"Cargo"}},[t._v("Cargo")]),t._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.datos.cargo,expression:"datos.cargo"}],staticClass:"form-control",attrs:{type:"text",id:"Cargo",placeholder:"Cargo"},domProps:{value:t.datos.cargo},on:{input:function(e){e.target.composing||t.$set(t.datos,"cargo",e.target.value)}}})]),t._v(" "),r("div",{staticClass:"form-group col-md-4"},[r("label",{attrs:{for:"Area"}},[t._v("Area")]),t._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.datos.area,expression:"datos.area"}],staticClass:"form-control",attrs:{type:"text",id:"Area",placeholder:"Area"},domProps:{value:t.datos.area},on:{input:function(e){e.target.composing||t.$set(t.datos,"area",e.target.value)}}})]),t._v(" "),r("div",{staticClass:"form-group col-md-4"},[r("label",{attrs:{for:"Role"}},[t._v("Rol")]),t._v(" "),r("select",{directives:[{name:"model",rawName:"v-model",value:t.datos.role_id,expression:"datos.role_id"}],staticClass:"browser-default custom-select",attrs:{id:"Perfil"},on:{change:function(e){var r=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){return"_value"in t?t._value:t.value}));t.$set(t.datos,"role_id",e.target.multiple?r:r[0])}}},[r("option",[t._v("Seleccione un rol")]),t._v(" "),t._l(t.roles,(function(e){return r("option",{key:e.nombre+e.id,domProps:{value:e.id}},[t._v(t._s(e.nombre))])}))],2)])]),t._v(" "),r("div",{staticClass:"form-row"},["3"==t.datos.role_id?r("div",{staticClass:"form-group col-md-4",staticStyle:{display:"none"}},[r("label",{attrs:{for:"Parking"}},[t._v("Estacionamiento")]),t._v(" "),r("select",{directives:[{name:"model",rawName:"v-model",value:t.datos.parking_id,expression:"datos.parking_id"}],staticClass:"browser-default custom-select",attrs:{id:"Parking"},on:{change:function(e){var r=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){return"_value"in t?t._value:t.value}));t.$set(t.datos,"parking_id",e.target.multiple?r:r[0])}}},[r("option",{attrs:{value:"0"}},[t._v("Seleccione un estacionamiento")]),t._v(" "),t._l(t.parkingsFilter,(function(e){return r("option",{key:e.numero+e.id,domProps:{value:e.id}},[t._v(t._s(e.numero+" - "+e.sede))])}))],2)]):t._e(),t._v(" "),r("div",{staticClass:"form-group col-md-4"},[r("label",{attrs:{for:"Sede"}},[t._v("Sede")]),t._v(" "),r("select",{directives:[{name:"model",rawName:"v-model",value:t.datos.sede_id,expression:"datos.sede_id"}],staticClass:"browser-default custom-select",attrs:{id:"Sede"},on:{change:function(e){var r=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){return"_value"in t?t._value:t.value}));t.$set(t.datos,"sede_id",e.target.multiple?r:r[0])}}},[r("option",[t._v("Seleccione una Sede")]),t._v(" "),t._l(t.sedes,(function(e){return r("option",{key:e.name+e.id,domProps:{value:e.id}},[t._v(t._s(e.name))])}))],2)]),t._v(" "),t.btnCrear?r("div",{staticClass:"form-group col-md-4"},[r("label",{attrs:{for:"password"}},[t._v("Contraseña")]),t._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.datos.password,expression:"datos.password"}],staticClass:"form-control",attrs:{type:"password",id:"password",placeholder:"password"},domProps:{value:t.datos.password},on:{input:function(e){e.target.composing||t.$set(t.datos,"password",e.target.value)}}})]):t._e()])]),t._v(" "),r("div",{staticClass:"modal-footer"},[r("button",{staticClass:"btn btn-danger",attrs:{type:"button","data-dismiss":"modal"},on:{click:function(e){return e.preventDefault(),t.cerrarModal.apply(null,arguments)}}},[t._v("Cerrar")]),t._v(" "),t.btnCrear?r("button",{staticClass:"btn btn-primary",attrs:{type:"submit"},on:{click:function(e){return e.preventDefault(),t.crear.apply(null,arguments)}}},[t.isLoading?r("span",[t._v("Guardando...")]):t._e(),t._v(" "),t.isLoading?t._e():r("span",[t._v("Crear")])]):t._e(),t._v(" "),t.btnEditar?r("button",{staticClass:"btn btn-primary",attrs:{type:"submit"},on:{click:function(e){return e.preventDefault(),t.editar.apply(null,arguments)}}},[t.isLoading?r("span",[t._v("Actualizando...")]):t._e(),t._v(" "),t.isLoading?t._e():r("span",[t._v("Editar")])]):t._e()])])])])])])}),[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"subheader"},[r("h1",{staticClass:"subheader-title"},[r("i",{staticClass:"subheader-icon fal fa-chart-area"}),t._v(" Usuarios\n        ")])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("thead",{staticClass:"bg-warning-200"},[r("tr",[r("th",[t._v("Nombres")]),t._v(" "),r("th",[t._v("Apellidos")]),t._v(" "),r("th",[t._v("Rol")]),t._v(" "),r("th",[t._v("Documento")]),t._v(" "),r("th",[t._v("Sede")]),t._v(" "),r("th",[t._v("Email")]),t._v(" "),r("th",[t._v("Fecha")]),t._v(" "),r("th",[t._v("Acciones")])])])}],!1,null,null,null).exports}}]);