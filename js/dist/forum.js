(()=>{var o={n:t=>{var r=t&&t.__esModule?()=>t.default:()=>t;return o.d(r,{a:r}),r},d:(t,r)=>{for(var e in r)o.o(r,e)&&!o.o(t,e)&&Object.defineProperty(t,e,{enumerable:!0,get:r[e]})},o:(o,t)=>Object.prototype.hasOwnProperty.call(o,t),r:o=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(o,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(o,"__esModule",{value:!0})}},t={};(()=>{"use strict";o.r(t);const r=flarum.core.compat["common/extend"],e=flarum.core.compat["forum/app"];var n=o.n(e);const a=flarum.core.compat["forum/utils/UserControls"];var s=o.n(a);const u=flarum.core.compat["common/app"];var i=o.n(u);function c(o,t){return c=Object.setPrototypeOf?Object.setPrototypeOf.bind():function(o,t){return o.__proto__=t,o},c(o,t)}const l=flarum.core.compat["common/components/Button"];var d=o.n(l);const p=flarum.core.compat["common/components/Modal"];var f=o.n(p);const b=flarum.core.compat["common/utils/withAttr"];var y=o.n(b),v=function(o){var t,r;function e(){for(var t,r=arguments.length,e=new Array(r),n=0;n<r;n++)e[n]=arguments[n];return(t=o.call.apply(o,[this].concat(e))||this).password="",t}r=o,(t=e).prototype=Object.create(r.prototype),t.prototype.constructor=t,c(t,r);var n=e.prototype;return n.className=function(){return"SudoModal Modal--small"},n.title=function(){return i().translator.trans("clarkwinkelmann-sudo-mode.lib.sudo.title")},n.content=function(){var o=this;return m(".Modal-body",[m(".Form-group",[m("p",i().translator.trans("clarkwinkelmann-sudo-mode.lib.sudo.message"))]),m(".Form-group",[m("input.FormControl",{type:"password",autocomplete:"current-password",value:this.password,onchange:y()("value",(function(t){o.password=t})),placeholder:i().translator.trans("clarkwinkelmann-sudo-mode.lib.sudo.password")})]),m(".Form-group",[d().component({type:"submit",className:"Button Button--primary"},i().translator.trans("clarkwinkelmann-sudo-mode.lib.sudo.submit"))])])},n.onsubmit=function(o){var t=this;o.preventDefault(),this.loading=!0,i().request({method:"POST",url:i().forum.attribute("apiUrl")+"/sudo-mode",body:{password:this.password},errorHandler:this.onerror}).then((function(o){"object"==typeof o&&o.expires&&(i().forum.data.attributes.sudoModeExpires=o.expires),t.loading=!1,t.hide(),t.attrs.onsubmit()}))},e}(f());n().initializers.add("clarkwinkelmann-sudo-mode",(function(){function o(o,t){if(!t.attribute("couldEditWithSudo"))return o(t);((i().forum.attribute("sudoModeExpires")||0)>dayjs().unix()?Promise.resolve(!1):i().modal.modalList.some((function(o){return o.componentClass===v}))?Promise.reject():new Promise((function(o){i().modal.show(v,{onsubmit:function(){o(!0)}},!0)}))).then((function(r){r?n().store.find("users",t.id()).then((function(){setTimeout((function(){o(t)}),300)})):o(t)}))}(0,r.override)(s(),"editAction",o),(0,r.override)(s(),"deleteAction",o)}))})(),module.exports=t})();
//# sourceMappingURL=forum.js.map