(()=>{var o={n:t=>{var e=t&&t.__esModule?()=>t.default:()=>t;return o.d(e,{a:e}),e},d:(t,e)=>{for(var r in e)o.o(e,r)&&!o.o(t,r)&&Object.defineProperty(t,r,{enumerable:!0,get:e[r]})},o:(o,t)=>Object.prototype.hasOwnProperty.call(o,t),r:o=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(o,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(o,"__esModule",{value:!0})}},t={};(()=>{"use strict";o.r(t);const e=flarum.core.compat["admin/app"];var r=o.n(e);const n=flarum.core.compat["common/app"];var a=o.n(n);function s(o,t){return s=Object.setPrototypeOf?Object.setPrototypeOf.bind():function(o,t){return o.__proto__=t,o},s(o,t)}const u=flarum.core.compat["common/components/Button"];var i=o.n(u);const l=flarum.core.compat["common/components/Modal"];var c=o.n(l);const d=flarum.core.compat["common/utils/withAttr"];var p=o.n(d),f=function(o){var t,e;function r(){for(var t,e=arguments.length,r=new Array(e),n=0;n<e;n++)r[n]=arguments[n];return(t=o.call.apply(o,[this].concat(r))||this).password="",t}e=o,(t=r).prototype=Object.create(e.prototype),t.prototype.constructor=t,s(t,e);var n=r.prototype;return n.className=function(){return"SudoModal Modal--small"},n.title=function(){return a().translator.trans("clarkwinkelmann-sudo-mode.lib.sudo.title")},n.content=function(){var o=this;return m(".Modal-body",[m(".Form-group",[m("p",a().translator.trans("clarkwinkelmann-sudo-mode.lib.sudo.message"))]),m(".Form-group",[m("input.FormControl",{type:"password",autocomplete:"current-password",value:this.password,onchange:p()("value",(function(t){o.password=t})),placeholder:a().translator.trans("clarkwinkelmann-sudo-mode.lib.sudo.password")})]),m(".Form-group",[i().component({type:"submit",className:"Button Button--primary"},a().translator.trans("clarkwinkelmann-sudo-mode.lib.sudo.submit"))])])},n.onsubmit=function(o){var t=this;o.preventDefault(),this.loading=!0,a().request({method:"POST",url:a().forum.attribute("apiUrl")+"/sudo-mode",body:{password:this.password},errorHandler:this.onerror}).then((function(o){console.log(o),"object"==typeof o&&o.expires&&(console.log("set",o.expires),a().forum.data.attributes.sudoModeExpires=o.expires),t.loading=!1,t.hide(),t.attrs.onsubmit()}))},r}(c());r().initializers.add("clarkwinkelmann-sudo-mode",(function(){r().extensionData.for("clarkwinkelmann-sudo-mode").registerSetting({type:"number",setting:"sudo-mode.duration",label:r().translator.trans("clarkwinkelmann-sudo-mode.admin.settings.duration"),placeholder:"3600"}),function o(){var t;r().forum&&(t=a().forum.attribute("sudoModeExpires")||0,console.log("check",t),t>dayjs().unix()?Promise.resolve(!1):a().modal.modalList.some((function(o){return o.componentClass===f}))?Promise.reject():new Promise((function(o){a().modal.show(f,{onsubmit:function(){o(!0)}},!0)}))),setTimeout((function(){requestAnimationFrame(o)}),5e3)}()}))})(),module.exports=t})();
//# sourceMappingURL=admin.js.map