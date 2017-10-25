/*
 AngularJS v1.6.6
 (c) 2010-2017 Google, Inc. http://angularjs.org
 License: MIT
*/
(function(u){'use strict';function oe(a){if(E(a))t(a.objectMaxDepth)&&(Lc.objectMaxDepth=Ub(a.objectMaxDepth)?a.objectMaxDepth:NaN);else return Lc}function Ub(a){return Y(a)&&0<a}function M(a,b){b=b||Error;return function(){var d=arguments[0],c;c="["+(a?a+":":"")+d+"] http://errors.angularjs.org/1.6.6/"+(a?a+"/":"")+d;for(d=1;d<arguments.length;d++){c=c+(1==d?"?":"&")+"p"+(d-1)+"=";var e=encodeURIComponent,f;f=arguments[d];f="function"==typeof f?f.toString().replace(/ \{[\s\S]*$/,""):"undefined"==
typeof f?"undefined":"string"!=typeof f?JSON.stringify(f):f;c+=e(f)}return new b(c)}}function xa(a){if(null==a||$a(a))return!1;if(I(a)||D(a)||B&&a instanceof B)return!0;var b="length"in Object(a)&&a.length;return Y(b)&&(0<=b&&(b-1 in a||a instanceof Array)||"function"===typeof a.item)}function p(a,b,d){var c,e;if(a)if(A(a))for(c in a)"prototype"!==c&&"length"!==c&&"name"!==c&&a.hasOwnProperty(c)&&b.call(d,a[c],c,a);else if(I(a)||xa(a)){var f="object"!==typeof a;c=0;for(e=a.length;c<e;c++)(f||c in
a)&&b.call(d,a[c],c,a)}else if(a.forEach&&a.forEach!==p)a.forEach(b,d,a);else if(Mc(a))for(c in a)b.call(d,a[c],c,a);else if("function"===typeof a.hasOwnProperty)for(c in a)a.hasOwnProperty(c)&&b.call(d,a[c],c,a);else for(c in a)ra.call(a,c)&&b.call(d,a[c],c,a);return a}function Nc(a,b,d){for(var c=Object.keys(a).sort(),e=0;e<c.length;e++)b.call(d,a[c[e]],c[e]);return c}function Vb(a){return function(b,d){a(d,b)}}function pe(){return++sb}function Wb(a,b,d){for(var c=a.$$hashKey,e=0,f=b.length;e<f;++e){var g=
b[e];if(E(g)||A(g))for(var k=Object.keys(g),h=0,l=k.length;h<l;h++){var m=k[h],n=g[m];d&&E(n)?ea(n)?a[m]=new Date(n.valueOf()):ab(n)?a[m]=new RegExp(n):n.nodeName?a[m]=n.cloneNode(!0):Xb(n)?a[m]=n.clone():(E(a[m])||(a[m]=I(n)?[]:{}),Wb(a[m],[n],!0)):a[m]=n}}c?a.$$hashKey=c:delete a.$$hashKey;return a}function P(a){return Wb(a,ya.call(arguments,1),!1)}function qe(a){return Wb(a,ya.call(arguments,1),!0)}function Z(a){return parseInt(a,10)}function Yb(a,b){return P(Object.create(a),b)}function C(){}
function bb(a){return a}function ka(a){return function(){return a}}function Zb(a){return A(a.toString)&&a.toString!==ha}function w(a){return"undefined"===typeof a}function t(a){return"undefined"!==typeof a}function E(a){return null!==a&&"object"===typeof a}function Mc(a){return null!==a&&"object"===typeof a&&!Oc(a)}function D(a){return"string"===typeof a}function Y(a){return"number"===typeof a}function ea(a){return"[object Date]"===ha.call(a)}function $b(a){switch(ha.call(a)){case "[object Error]":return!0;
case "[object Exception]":return!0;case "[object DOMException]":return!0;default:return a instanceof Error}}function A(a){return"function"===typeof a}function ab(a){return"[object RegExp]"===ha.call(a)}function $a(a){return a&&a.window===a}function cb(a){return a&&a.$evalAsync&&a.$watch}function Na(a){return"boolean"===typeof a}function re(a){return a&&Y(a.length)&&se.test(ha.call(a))}function Xb(a){return!(!a||!(a.nodeName||a.prop&&a.attr&&a.find))}function te(a){var b={};a=a.split(",");var d;for(d=
0;d<a.length;d++)b[a[d]]=!0;return b}function za(a){return N(a.nodeName||a[0]&&a[0].nodeName)}function db(a,b){var d=a.indexOf(b);0<=d&&a.splice(d,1);return d}function pa(a,b,d){function c(a,b,c){c--;if(0>c)return"...";var d=b.$$hashKey,g;if(I(a)){g=0;for(var f=a.length;g<f;g++)b.push(e(a[g],c))}else if(Mc(a))for(g in a)b[g]=e(a[g],c);else if(a&&"function"===typeof a.hasOwnProperty)for(g in a)a.hasOwnProperty(g)&&(b[g]=e(a[g],c));else for(g in a)ra.call(a,g)&&(b[g]=e(a[g],c));d?b.$$hashKey=d:delete b.$$hashKey;
return b}function e(a,b){if(!E(a))return a;var d=g.indexOf(a);if(-1!==d)return k[d];if($a(a)||cb(a))throw qa("cpws");var d=!1,e=f(a);void 0===e&&(e=I(a)?[]:Object.create(Oc(a)),d=!0);g.push(a);k.push(e);return d?c(a,e,b):e}function f(a){switch(ha.call(a)){case "[object Int8Array]":case "[object Int16Array]":case "[object Int32Array]":case "[object Float32Array]":case "[object Float64Array]":case "[object Uint8Array]":case "[object Uint8ClampedArray]":case "[object Uint16Array]":case "[object Uint32Array]":return new a.constructor(e(a.buffer),
a.byteOffset,a.length);case "[object ArrayBuffer]":if(!a.slice){var b=new ArrayBuffer(a.byteLength);(new Uint8Array(b)).set(new Uint8Array(a));return b}return a.slice(0);case "[object Boolean]":case "[object Number]":case "[object String]":case "[object Date]":return new a.constructor(a.valueOf());case "[object RegExp]":return b=new RegExp(a.source,a.toString().match(/[^/]*$/)[0]),b.lastIndex=a.lastIndex,b;case "[object Blob]":return new a.constructor([a],{type:a.type})}if(A(a.cloneNode))return a.cloneNode(!0)}
var g=[],k=[];d=Ub(d)?d:NaN;if(b){if(re(b)||"[object ArrayBuffer]"===ha.call(b))throw qa("cpta");if(a===b)throw qa("cpi");I(b)?b.length=0:p(b,function(a,c){"$$hashKey"!==c&&delete b[c]});g.push(a);k.push(b);return c(a,b,d)}return e(a,d)}function ac(a,b){return a===b||a!==a&&b!==b}function sa(a,b){if(a===b)return!0;if(null===a||null===b)return!1;if(a!==a&&b!==b)return!0;var d=typeof a,c;if(d===typeof b&&"object"===d)if(I(a)){if(!I(b))return!1;if((d=a.length)===b.length){for(c=0;c<d;c++)if(!sa(a[c],
b[c]))return!1;return!0}}else{if(ea(a))return ea(b)?ac(a.getTime(),b.getTime()):!1;if(ab(a))return ab(b)?a.toString()===b.toString():!1;if(cb(a)||cb(b)||$a(a)||$a(b)||I(b)||ea(b)||ab(b))return!1;d=S();for(c in a)if("$"!==c.charAt(0)&&!A(a[c])){if(!sa(a[c],b[c]))return!1;d[c]=!0}for(c in b)if(!(c in d)&&"$"!==c.charAt(0)&&t(b[c])&&!A(b[c]))return!1;return!0}return!1}function eb(a,b,d){return a.concat(ya.call(b,d))}function Ra(a,b){var d=2<arguments.length?ya.call(arguments,2):[];return!A(b)||b instanceof
RegExp?b:d.length?function(){return arguments.length?b.apply(a,eb(d,arguments,0)):b.apply(a,d)}:function(){return arguments.length?b.apply(a,arguments):b.call(a)}}function Pc(a,b){var d=b;"string"===typeof a&&"$"===a.charAt(0)&&"$"===a.charAt(1)?d=void 0:$a(b)?d="$WINDOW":b&&u.document===b?d="$DOCUMENT":cb(b)&&(d="$SCOPE");return d}function fb(a,b){if(!w(a))return Y(b)||(b=b?2:null),JSON.stringify(a,Pc,b)}function Qc(a){return D(a)?JSON.parse(a):a}function Rc(a,b){a=a.replace(ue,"");var d=Date.parse("Jan 01, 1970 00:00:00 "+
a)/6E4;return T(d)?b:d}function bc(a,b,d){d=d?-1:1;var c=a.getTimezoneOffset();b=Rc(b,c);d*=b-c;a=new Date(a.getTime());a.setMinutes(a.getMinutes()+d);return a}function Aa(a){a=B(a).clone().empty();var b=B("<div>").append(a).html();try{return a[0].nodeType===Oa?N(b):b.match(/^(<[^>]+>)/)[1].replace(/^<([\w-]+)/,function(a,b){return"<"+N(b)})}catch(d){return N(b)}}function Sc(a){try{return decodeURIComponent(a)}catch(b){}}function Tc(a){var b={};p((a||"").split("&"),function(a){var c,e,f;a&&(e=a=a.replace(/\+/g,
"%20"),c=a.indexOf("="),-1!==c&&(e=a.substring(0,c),f=a.substring(c+1)),e=Sc(e),t(e)&&(f=t(f)?Sc(f):!0,ra.call(b,e)?I(b[e])?b[e].push(f):b[e]=[b[e],f]:b[e]=f))});return b}function cc(a){var b=[];p(a,function(a,c){I(a)?p(a,function(a){b.push(ia(c,!0)+(!0===a?"":"="+ia(a,!0)))}):b.push(ia(c,!0)+(!0===a?"":"="+ia(a,!0)))});return b.length?b.join("&"):""}function gb(a){return ia(a,!0).replace(/%26/gi,"&").replace(/%3D/gi,"=").replace(/%2B/gi,"+")}function ia(a,b){return encodeURIComponent(a).replace(/%40/gi,
"@").replace(/%3A/gi,":").replace(/%24/g,"$").replace(/%2C/gi,",").replace(/%3B/gi,";").replace(/%20/g,b?"%20":"+")}function ve(a,b){var d,c,e=Ha.length;for(c=0;c<e;++c)if(d=Ha[c]+b,D(d=a.getAttribute(d)))return d;return null}function we(a,b){var d,c,e={};p(Ha,function(b){b+="app";!d&&a.hasAttribute&&a.hasAttribute(b)&&(d=a,c=a.getAttribute(b))});p(Ha,function(b){b+="app";var e;!d&&(e=a.querySelector("["+b.replace(":","\\:")+"]"))&&(d=e,c=e.getAttribute(b))});d&&(xe?(e.strictDi=null!==ve(d,"strict-di"),
b(d,c?[c]:[],e)):u.console.error("Angular: disabling automatic bootstrap. <script> protocol indicates an extension, document.location.href does not match."))}function Uc(a,b,d){E(d)||(d={});d=P({strictDi:!1},d);var c=function(){a=B(a);if(a.injector()){var c=a[0]===u.document?"document":Aa(a);throw qa("btstrpd",c.replace(/</,"&lt;").replace(/>/,"&gt;"));}b=b||[];b.unshift(["$provide",function(b){b.value("$rootElement",a)}]);d.debugInfoEnabled&&b.push(["$compileProvider",function(a){a.debugInfoEnabled(!0)}]);
b.unshift("ng");c=hb(b,d.strictDi);c.invoke(["$rootScope","$rootElement","$compile","$injector",function(a,b,c,d){a.$apply(function(){b.data("$injector",d);c(b)(a)})}]);return c},e=/^NG_ENABLE_DEBUG_INFO!/,f=/^NG_DEFER_BOOTSTRAP!/;u&&e.test(u.name)&&(d.debugInfoEnabled=!0,u.name=u.name.replace(e,""));if(u&&!f.test(u.name))return c();u.name=u.name.replace(f,"");$.resumeBootstrap=function(a){p(a,function(a){b.push(a)});return c()};A($.resumeDeferredBootstrap)&&$.resumeDeferredBootstrap()}function ye(){u.name=
"NG_ENABLE_DEBUG_INFO!"+u.name;u.location.reload()}function ze(a){a=$.element(a).injector();if(!a)throw qa("test");return a.get("$$testability")}function Vc(a,b){b=b||"_";return a.replace(Ae,function(a,c){return(c?b:"")+a.toLowerCase()})}function Be(){var a;if(!Wc){var b=tb();(la=w(b)?u.jQuery:b?u[b]:void 0)&&la.fn.on?(B=la,P(la.fn,{scope:Sa.scope,isolateScope:Sa.isolateScope,controller:Sa.controller,injector:Sa.injector,inheritedData:Sa.inheritedData}),a=la.cleanData,la.cleanData=function(b){for(var c,
e=0,f;null!=(f=b[e]);e++)(c=la._data(f,"events"))&&c.$destroy&&la(f).triggerHandler("$destroy");a(b)}):B=U;$.element=B;Wc=!0}}function ib(a,b,d){if(!a)throw qa("areq",b||"?",d||"required");return a}function ub(a,b,d){d&&I(a)&&(a=a[a.length-1]);ib(A(a),b,"not a function, got "+(a&&"object"===typeof a?a.constructor.name||"Object":typeof a));return a}function Ia(a,b){if("hasOwnProperty"===a)throw qa("badname",b);}function Xc(a,b,d){if(!b)return a;b=b.split(".");for(var c,e=a,f=b.length,g=0;g<f;g++)c=
b[g],a&&(a=(e=a)[c]);return!d&&A(a)?Ra(e,a):a}function vb(a){for(var b=a[0],d=a[a.length-1],c,e=1;b!==d&&(b=b.nextSibling);e++)if(c||a[e]!==b)c||(c=B(ya.call(a,0,e))),c.push(b);return c||a}function S(){return Object.create(null)}function dc(a){if(null==a)return"";switch(typeof a){case "string":break;case "number":a=""+a;break;default:a=!Zb(a)||I(a)||ea(a)?fb(a):a.toString()}return a}function Ce(a){function b(a,b,c){return a[b]||(a[b]=c())}var d=M("$injector"),c=M("ng");a=b(a,"angular",Object);a.$$minErr=
a.$$minErr||M;return b(a,"module",function(){var a={};return function(f,g,k){var h={};if("hasOwnProperty"===f)throw c("badname","module");g&&a.hasOwnProperty(f)&&(a[f]=null);return b(a,f,function(){function a(b,c,d,g){g||(g=e);return function(){g[d||"push"]([b,c,arguments]);return p}}function b(a,c,d){d||(d=e);return function(b,e){e&&A(e)&&(e.$$moduleName=f);d.push([a,c,arguments]);return p}}if(!g)throw d("nomod",f);var e=[],q=[],G=[],L=a("$injector","invoke","push",q),p={_invokeQueue:e,_configBlocks:q,
_runBlocks:G,info:function(a){if(t(a)){if(!E(a))throw c("aobj","value");h=a;return this}return h},requires:g,name:f,provider:b("$provide","provider"),factory:b("$provide","factory"),service:b("$provide","service"),value:a("$provide","value"),constant:a("$provide","constant","unshift"),decorator:b("$provide","decorator",q),animation:b("$animateProvider","register"),filter:b("$filterProvider","register"),controller:b("$controllerProvider","register"),directive:b("$compileProvider","directive"),component:b("$compileProvider",
"component"),config:L,run:function(a){G.push(a);return this}};k&&L(k);return p})}})}function ja(a,b){if(I(a)){b=b||[];for(var d=0,c=a.length;d<c;d++)b[d]=a[d]}else if(E(a))for(d in b=b||{},a)if("$"!==d.charAt(0)||"$"!==d.charAt(1))b[d]=a[d];return b||a}function De(a,b){var d=[];Ub(b)&&(a=$.copy(a,null,b));return JSON.stringify(a,function(a,b){b=Pc(a,b);if(E(b)){if(0<=d.indexOf(b))return"...";d.push(b)}return b})}function Ee(a){P(a,{errorHandlingConfig:oe,bootstrap:Uc,copy:pa,extend:P,merge:qe,equals:sa,
element:B,forEach:p,injector:hb,noop:C,bind:Ra,toJson:fb,fromJson:Qc,identity:bb,isUndefined:w,isDefined:t,isString:D,isFunction:A,isObject:E,isNumber:Y,isElement:Xb,isArray:I,version:Fe,isDate:ea,lowercase:N,uppercase:wb,callbacks:{$$counter:0},getTestability:ze,reloadWithDebugInfo:ye,$$minErr:M,$$csp:Ja,$$encodeUriSegment:gb,$$encodeUriQuery:ia,$$stringify:dc});ec=Ce(u);ec("ng",["ngLocale"],["$provide",function(a){a.provider({$$sanitizeUri:Ge});a.provider("$compile",Yc).directive({a:He,input:Zc,
textarea:Zc,form:Ie,script:Je,select:Ke,option:Le,ngBind:Me,ngBindHtml:Ne,ngBindTemplate:Oe,ngClass:Pe,ngClassEven:Qe,ngClassOdd:Re,ngCloak:Se,ngController:Te,ngForm:Ue,ngHide:Ve,ngIf:We,ngInclude:Xe,ngInit:Ye,ngNonBindable:Ze,ngPluralize:$e,ngRepeat:af,ngShow:bf,ngStyle:cf,ngSwitch:df,ngSwitchWhen:ef,ngSwitchDefault:ff,ngOptions:gf,ngTransclude:hf,ngModel:jf,ngList:kf,ngChange:lf,pattern:$c,ngPattern:$c,required:ad,ngRequired:ad,minlength:bd,ngMinlength:bd,maxlength:cd,ngMaxlength:cd,ngValue:mf,
ngModelOptions:nf}).directive({ngInclude:of}).directive(xb).directive(dd);a.provider({$anchorScroll:pf,$animate:qf,$animateCss:rf,$$animateJs:sf,$$animateQueue:tf,$$AnimateRunner:uf,$$animateAsyncRun:vf,$browser:wf,$cacheFactory:xf,$controller:yf,$document:zf,$$isDocumentHidden:Af,$exceptionHandler:Bf,$filter:ed,$$forceReflow:Cf,$interpolate:Df,$interval:Ef,$http:Ff,$httpParamSerializer:Gf,$httpParamSerializerJQLike:Hf,$httpBackend:If,$xhrFactory:Jf,$jsonpCallbacks:Kf,$location:Lf,$log:Mf,$parse:Nf,
$rootScope:Of,$q:Pf,$$q:Qf,$sce:Rf,$sceDelegate:Sf,$sniffer:Tf,$templateCache:Uf,$templateRequest:Vf,$$testability:Wf,$timeout:Xf,$window:Yf,$$rAF:Zf,$$jqLite:$f,$$Map:ag,$$cookieReader:bg})}]).info({angularVersion:"1.6.6"})}function jb(a,b){return b.toUpperCase()}function yb(a){return a.replace(cg,jb)}function fc(a){a=a.nodeType;return 1===a||!a||9===a}function fd(a,b){var d,c,e=b.createDocumentFragment(),f=[];if(gc.test(a)){d=e.appendChild(b.createElement("div"));c=(dg.exec(a)||["",""])[1].toLowerCase();
c=aa[c]||aa._default;d.innerHTML=c[1]+a.replace(eg,"<$1></$2>")+c[2];for(c=c[0];c--;)d=d.lastChild;f=eb(f,d.childNodes);d=e.firstChild;d.textContent=""}else f.push(b.createTextNode(a));e.textContent="";e.innerHTML="";p(f,function(a){e.appendChild(a)});return e}function U(a){if(a instanceof U)return a;var b;D(a)&&(a=Q(a),b=!0);if(!(this instanceof U)){if(b&&"<"!==a.charAt(0))throw hc("nosel");return new U(a)}if(b){b=u.document;var d;a=(d=fg.exec(a))?[b.createElement(d[1])]:(d=fd(a,b))?d.childNodes:
[];ic(this,a)}else A(a)?gd(a):ic(this,a)}function jc(a){return a.cloneNode(!0)}function zb(a,b){!b&&fc(a)&&B.cleanData([a]);a.querySelectorAll&&B.cleanData(a.querySelectorAll("*"))}function hd(a,b,d,c){if(t(c))throw hc("offargs");var e=(c=Ab(a))&&c.events,f=c&&c.handle;if(f)if(b){var g=function(b){var c=e[b];t(d)&&db(c||[],d);t(d)&&c&&0<c.length||(a.removeEventListener(b,f),delete e[b])};p(b.split(" "),function(a){g(a);Bb[a]&&g(Bb[a])})}else for(b in e)"$destroy"!==b&&a.removeEventListener(b,f),delete e[b]}
function kc(a,b){var d=a.ng339,c=d&&kb[d];c&&(b?delete c.data[b]:(c.handle&&(c.events.$destroy&&c.handle({},"$destroy"),hd(a)),delete kb[d],a.ng339=void 0))}function Ab(a,b){var d=a.ng339,d=d&&kb[d];b&&!d&&(a.ng339=d=++gg,d=kb[d]={events:{},data:{},handle:void 0});return d}function lc(a,b,d){if(fc(a)){var c,e=t(d),f=!e&&b&&!E(b),g=!b;a=(a=Ab(a,!f))&&a.data;if(e)a[yb(b)]=d;else{if(g)return a;if(f)return a&&a[yb(b)];for(c in b)a[yb(c)]=b[c]}}}function Cb(a,b){return a.getAttribute?-1<(" "+(a.getAttribute("class")||
"")+" ").replace(/[\n\t]/g," ").indexOf(" "+b+" "):!1}function Db(a,b){b&&a.setAttribute&&p(b.split(" "),function(b){a.setAttribute("class",Q((" "+(a.getAttribute("class")||"")+" ").replace(/[\n\t]/g," ").replace(" "+Q(b)+" "," ")))})}function Eb(a,b){if(b&&a.setAttribute){var d=(" "+(a.getAttribute("class")||"")+" ").replace(/[\n\t]/g," ");p(b.split(" "),function(a){a=Q(a);-1===d.indexOf(" "+a+" ")&&(d+=a+" ")});a.setAttribute("class",Q(d))}}function ic(a,b){if(b)if(b.nodeType)a[a.length++]=b;else{var d=
b.length;if("number"===typeof d&&b.window!==b){if(d)for(var c=0;c<d;c++)a[a.length++]=b[c]}else a[a.length++]=b}}function id(a,b){return Fb(a,"$"+(b||"ngController")+"Controller")}function Fb(a,b,d){9===a.nodeType&&(a=a.documentElement);for(b=I(b)?b:[b];a;){for(var c=0,e=b.length;c<e;c++)if(t(d=B.data(a,b[c])))return d;a=a.parentNode||11===a.nodeType&&a.host}}function jd(a){for(zb(a,!0);a.firstChild;)a.removeChild(a.firstChild)}function Gb(a,b){b||zb(a);var d=a.parentNode;d&&d.removeChild(a)}function hg(a,
b){b=b||u;if("complete"===b.document.readyState)b.setTimeout(a);else B(b).on("load",a)}function gd(a){function b(){u.document.removeEventListener("DOMContentLoaded",b);u.removeEventListener("load",b);a()}"complete"===u.document.readyState?u.setTimeout(a):(u.document.addEventListener("DOMContentLoaded",b),u.addEventListener("load",b))}function kd(a,b){var d=Hb[b.toLowerCase()];return d&&ld[za(a)]&&d}function ig(a,b){var d=function(c,d){c.isDefaultPrevented=function(){return c.defaultPrevented};var f=
b[d||c.type],g=f?f.length:0;if(g){if(w(c.immediatePropagationStopped)){var k=c.stopImmediatePropagation;c.stopImmediatePropagation=function(){c.immediatePropagationStopped=!0;c.stopPropagation&&c.stopPropagation();k&&k.call(c)}}c.isImmediatePropagationStopped=function(){return!0===c.immediatePropagationStopped};var h=f.specialHandlerWrapper||jg;1<g&&(f=ja(f));for(var l=0;l<g;l++)c.isImmediatePropagationStopped()||h(a,c,f[l])}};d.elem=a;return d}function jg(a,b,d){d.call(a,b)}function kg(a,b,d){var c=
b.relatedTarget;c&&(c===a||lg.call(a,c))||d.call(a,b)}function $f(){this.$get=function(){return P(U,{hasClass:function(a,b){a.attr&&(a=a[0]);return Cb(a,b)},addClass:function(a,b){a.attr&&(a=a[0]);return Eb(a,b)},removeClass:function(a,b){a.attr&&(a=a[0]);return Db(a,b)}})}}function Pa(a,b){var d=a&&a.$$hashKey;if(d)return"function"===typeof d&&(d=a.$$hashKey()),d;d=typeof a;return d="function"===d||"object"===d&&null!==a?a.$$hashKey=d+":"+(b||pe)():d+":"+a}function md(){this._keys=[];this._values=
[];this._lastKey=NaN;this._lastIndex=-1}function nd(a){a=Function.prototype.toString.call(a).replace(mg,"");return a.match(ng)||a.match(og)}function pg(a){return(a=nd(a))?"function("+(a[1]||"").replace(/[\s\r\n]+/," ")+")":"fn"}function hb(a,b){function d(a){return function(b,c){if(E(b))p(b,Vb(a));else return a(b,c)}}function c(a,b){Ia(a,"service");if(A(b)||I(b))b=q.instantiate(b);if(!b.$get)throw Ba("pget",a);return n[a+"Provider"]=b}function e(a,b){return function(){var c=z.invoke(b,this);if(w(c))throw Ba("undef",
a);return c}}function f(a,b,d){return c(a,{$get:!1!==d?e(a,b):b})}function g(a){ib(w(a)||I(a),"modulesToLoad","not an array");var b=[],c;p(a,function(a){function d(a){var b,c;b=0;for(c=a.length;b<c;b++){var e=a[b],g=q.get(e[0]);g[e[1]].apply(g,e[2])}}if(!m.get(a)){m.set(a,!0);try{D(a)?(c=ec(a),z.modules[a]=c,b=b.concat(g(c.requires)).concat(c._runBlocks),d(c._invokeQueue),d(c._configBlocks)):A(a)?b.push(q.invoke(a)):I(a)?b.push(q.invoke(a)):ub(a,"module")}catch(e){throw I(a)&&(a=a[a.length-1]),e.message&&
e.stack&&-1===e.stack.indexOf(e.message)&&(e=e.message+"\n"+e.stack),Ba("modulerr",a,e.stack||e.message||e);}}});return b}function k(a,c){function d(b,e){if(a.hasOwnProperty(b)){if(a[b]===h)throw Ba("cdep",b+" <- "+l.join(" <- "));return a[b]}try{return l.unshift(b),a[b]=h,a[b]=c(b,e),a[b]}catch(g){throw a[b]===h&&delete a[b],g;}finally{l.shift()}}function e(a,c,g){var f=[];a=hb.$$annotate(a,b,g);for(var h=0,k=a.length;h<k;h++){var l=a[h];if("string"!==typeof l)throw Ba("itkn",l);f.push(c&&c.hasOwnProperty(l)?
c[l]:d(l,g))}return f}return{invoke:function(a,b,c,d){"string"===typeof c&&(d=c,c=null);c=e(a,c,d);I(a)&&(a=a[a.length-1]);d=a;if(Ca||"function"!==typeof d)d=!1;else{var g=d.$$ngIsClass;Na(g)||(g=d.$$ngIsClass=/^(?:class\b|constructor\()/.test(Function.prototype.toString.call(d)));d=g}return d?(c.unshift(null),new (Function.prototype.bind.apply(a,c))):a.apply(b,c)},instantiate:function(a,b,c){var d=I(a)?a[a.length-1]:a;a=e(a,b,c);a.unshift(null);return new (Function.prototype.bind.apply(d,a))},get:d,
annotate:hb.$$annotate,has:function(b){return n.hasOwnProperty(b+"Provider")||a.hasOwnProperty(b)}}}b=!0===b;var h={},l=[],m=new Ib,n={$provide:{provider:d(c),factory:d(f),service:d(function(a,b){return f(a,["$injector",function(a){return a.instantiate(b)}])}),value:d(function(a,b){return f(a,ka(b),!1)}),constant:d(function(a,b){Ia(a,"constant");n[a]=b;G[a]=b}),decorator:function(a,b){var c=q.get(a+"Provider"),d=c.$get;c.$get=function(){var a=z.invoke(d,c);return z.invoke(b,null,{$delegate:a})}}}},
q=n.$injector=k(n,function(a,b){$.isString(b)&&l.push(b);throw Ba("unpr",l.join(" <- "));}),G={},L=k(G,function(a,b){var c=q.get(a+"Provider",b);return z.invoke(c.$get,c,void 0,a)}),z=L;n.$injectorProvider={$get:ka(L)};z.modules=q.modules=S();var v=g(a),z=L.get("$injector");z.strictDi=b;p(v,function(a){a&&z.invoke(a)});return z}function pf(){var a=!0;this.disableAutoScrolling=function(){a=!1};this.$get=["$window","$location","$rootScope",function(b,d,c){function e(a){var b=null;Array.prototype.some.call(a,
function(a){if("a"===za(a))return b=a,!0});return b}function f(a){if(a){a.scrollIntoView();var c;c=g.yOffset;A(c)?c=c():Xb(c)?(c=c[0],c="fixed"!==b.getComputedStyle(c).position?0:c.getBoundingClientRect().bottom):Y(c)||(c=0);c&&(a=a.getBoundingClientRect().top,b.scrollBy(0,a-c))}else b.scrollTo(0,0)}function g(a){a=D(a)?a:Y(a)?a.toString():d.hash();var b;a?(b=k.getElementById(a))?f(b):(b=e(k.getElementsByName(a)))?f(b):"top"===a&&f(null):f(null)}var k=b.document;a&&c.$watch(function(){return d.hash()},
function(a,b){a===b&&""===a||hg(function(){c.$evalAsync(g)})});return g}]}function lb(a,b){if(!a&&!b)return"";if(!a)return b;if(!b)return a;I(a)&&(a=a.join(" "));I(b)&&(b=b.join(" "));return a+" "+b}function qg(a){D(a)&&(a=a.split(" "));var b=S();p(a,function(a){a.length&&(b[a]=!0)});return b}function Ka(a){return E(a)?a:{}}function rg(a,b,d,c){function e(a){try{a.apply(null,ya.call(arguments,1))}finally{if(L--,0===L)for(;z.length;)try{z.pop()()}catch(b){d.error(b)}}}function f(){y=null;k()}function g(){v=
J();v=w(v)?null:v;sa(v,K)&&(v=K);s=K=v}function k(){var a=s;g();if(Ta!==h.url()||a!==v)Ta=h.url(),s=v,p(H,function(a){a(h.url(),v)})}var h=this,l=a.location,m=a.history,n=a.setTimeout,q=a.clearTimeout,G={};h.isMock=!1;var L=0,z=[];h.$$completeOutstandingRequest=e;h.$$incOutstandingRequestCount=function(){L++};h.notifyWhenNoOutstandingRequests=function(a){0===L?a():z.push(a)};var v,s,Ta=l.href,ma=b.find("base"),y=null,J=c.history?function(){try{return m.state}catch(a){}}:C;g();h.url=function(b,d,e){w(e)&&
(e=null);l!==a.location&&(l=a.location);m!==a.history&&(m=a.history);if(b){var f=s===e;if(Ta===b&&(!c.history||f))return h;var k=Ta&&La(Ta)===La(b);Ta=b;s=e;!c.history||k&&f?(k||(y=b),d?l.replace(b):k?(d=l,e=b.indexOf("#"),e=-1===e?"":b.substr(e),d.hash=e):l.href=b,l.href!==b&&(y=b)):(m[d?"replaceState":"pushState"](e,"",b),g());y&&(y=b);return h}return y||l.href.replace(/%27/g,"'")};h.state=function(){return v};var H=[],ta=!1,K=null;h.onUrlChange=function(b){if(!ta){if(c.history)B(a).on("popstate",
f);B(a).on("hashchange",f);ta=!0}H.push(b);return b};h.$$applicationDestroyed=function(){B(a).off("hashchange popstate",f)};h.$$checkUrlChange=k;h.baseHref=function(){var a=ma.attr("href");return a?a.replace(/^(https?:)?\/\/[^/]*/,""):""};h.defer=function(a,b){var c;L++;c=n(function(){delete G[c];e(a)},b||0);G[c]=!0;return c};h.defer.cancel=function(a){return G[a]?(delete G[a],q(a),e(C),!0):!1}}function wf(){this.$get=["$window","$log","$sniffer","$document",function(a,b,d,c){return new rg(a,c,b,
d)}]}function xf(){this.$get=function(){function a(a,c){function e(a){a!==n&&(q?q===a&&(q=a.n):q=a,f(a.n,a.p),f(a,n),n=a,n.n=null)}function f(a,b){a!==b&&(a&&(a.p=b),b&&(b.n=a))}if(a in b)throw M("$cacheFactory")("iid",a);var g=0,k=P({},c,{id:a}),h=S(),l=c&&c.capacity||Number.MAX_VALUE,m=S(),n=null,q=null;return b[a]={put:function(a,b){if(!w(b)){if(l<Number.MAX_VALUE){var c=m[a]||(m[a]={key:a});e(c)}a in h||g++;h[a]=b;g>l&&this.remove(q.key);return b}},get:function(a){if(l<Number.MAX_VALUE){var b=
m[a];if(!b)return;e(b)}return h[a]},remove:function(a){if(l<Number.MAX_VALUE){var b=m[a];if(!b)return;b===n&&(n=b.p);b===q&&(q=b.n);f(b.n,b.p);delete m[a]}a in h&&(delete h[a],g--)},removeAll:function(){h=S();g=0;m=S();n=q=null},destroy:function(){m=k=h=null;delete b[a]},info:function(){return P({},k,{size:g})}}}var b={};a.info=function(){var a={};p(b,function(b,e){a[e]=b.info()});return a};a.get=function(a){return b[a]};return a}}function Uf(){this.$get=["$cacheFactory",function(a){return a("templates")}]}
function Yc(a,b){function d(a,b,c){var d=/^\s*([@&<]|=(\*?))(\??)\s*([\w$]*)\s*$/,e=S();p(a,function(a,g){if(a in n)e[g]=n[a];else{var f=a.match(d);if(!f)throw ba("iscp",b,g,a,c?"controller bindings definition":"isolate scope definition");e[g]={mode:f[1][0],collection:"*"===f[2],optional:"?"===f[3],attrName:f[4]||g};f[4]&&(n[a]=e[g])}});return e}function c(a){var b=a.charAt(0);if(!b||b!==N(b))throw ba("baddir",a);if(a!==a.trim())throw ba("baddir",a);}function e(a){var b=a.require||a.controller&&a.name;
!I(b)&&E(b)&&p(b,function(a,c){var d=a.match(l);a.substring(d[0].length)||(b[c]=d[0]+c)});return b}var f={},g=/^\s*directive:\s*([\w-]+)\s+(.*)$/,k=/(([\w-]+)(?::([^;]+))?;?)/,h=te("ngSrc,ngSrcset,src,srcset"),l=/^(?:(\^\^?)?(\?)?(\^\^?)?)?/,m=/^(on[a-z]+|formaction)$/,n=S();this.directive=function ma(b,d){ib(b,"name");Ia(b,"directive");D(b)?(c(b),ib(d,"directiveFactory"),f.hasOwnProperty(b)||(f[b]=[],a.factory(b+"Directive",["$injector","$exceptionHandler",function(a,c){var d=[];p(f[b],function(g,
f){try{var h=a.invoke(g);A(h)?h={compile:ka(h)}:!h.compile&&h.link&&(h.compile=ka(h.link));h.priority=h.priority||0;h.index=f;h.name=h.name||b;h.require=e(h);var k=h,l=h.restrict;if(l&&(!D(l)||!/[EACM]/.test(l)))throw ba("badrestrict",l,b);k.restrict=l||"EA";h.$$moduleName=g.$$moduleName;d.push(h)}catch(m){c(m)}});return d}])),f[b].push(d)):p(b,Vb(ma));return this};this.component=function y(a,b){function c(a){function e(b){return A(b)||I(b)?function(c,d){return a.invoke(b,this,{$element:c,$attrs:d})}:
b}var g=b.template||b.templateUrl?b.template:"",f={controller:d,controllerAs:sg(b.controller)||b.controllerAs||"$ctrl",template:e(g),templateUrl:e(b.templateUrl),transclude:b.transclude,scope:{},bindToController:b.bindings||{},restrict:"E",require:b.require};p(b,function(a,b){"$"===b.charAt(0)&&(f[b]=a)});return f}if(!D(a))return p(a,Vb(Ra(this,y))),this;var d=b.controller||function(){};p(b,function(a,b){"$"===b.charAt(0)&&(c[b]=a,A(d)&&(d[b]=a))});c.$inject=["$injector"];return this.directive(a,
c)};this.aHrefSanitizationWhitelist=function(a){return t(a)?(b.aHrefSanitizationWhitelist(a),this):b.aHrefSanitizationWhitelist()};this.imgSrcSanitizationWhitelist=function(a){return t(a)?(b.imgSrcSanitizationWhitelist(a),this):b.imgSrcSanitizationWhitelist()};var q=!0;this.debugInfoEnabled=function(a){return t(a)?(q=a,this):q};var G=!1;this.preAssignBindingsEnabled=function(a){return t(a)?(G=a,this):G};var L=!1;this.strictComponentBindingsEnabled=function(a){return t(a)?(L=a,this):L};var z=10;this.onChangesTtl=
function(a){return arguments.length?(z=a,this):z};var v=!0;this.commentDirectivesEnabled=function(a){return arguments.length?(v=a,this):v};var s=!0;this.cssClassDirectivesEnabled=function(a){return arguments.length?(s=a,this):s};this.$get=["$injector","$interpolate","$exceptionHandler","$templateRequest","$parse","$controller","$rootScope","$sce","$animate","$$sanitizeUri",function(a,b,c,e,n,F,R,x,W,r){function O(){try{if(!--Fa)throw ga=void 0,ba("infchng",z);R.$apply(function(){for(var a=[],b=0,
c=ga.length;b<c;++b)try{ga[b]()}catch(d){a.push(d)}ga=void 0;if(a.length)throw a;})}finally{Fa++}}function mc(a,b){if(b){var c=Object.keys(b),d,e,g;d=0;for(e=c.length;d<e;d++)g=c[d],this[g]=b[g]}else this.$attr={};this.$$element=a}function Ua(a,b,c){Ba.innerHTML="<span "+b+">";b=Ba.firstChild.attributes;var d=b[0];b.removeNamedItem(d.name);d.value=c;a.attributes.setNamedItem(d)}function na(a,b){try{a.addClass(b)}catch(c){}}function ca(a,b,c,d,e){a instanceof B||(a=B(a));var g=Va(a,b,a,c,d,e);ca.$$addScopeClass(a);
var f=null;return function(b,c,d){if(!a)throw ba("multilink");ib(b,"scope");e&&e.needsNewScope&&(b=b.$parent.$new());d=d||{};var h=d.parentBoundTranscludeFn,k=d.transcludeControllers;d=d.futureParentElement;h&&h.$$boundTransclude&&(h=h.$$boundTransclude);f||(f=(d=d&&d[0])?"foreignobject"!==za(d)&&ha.call(d).match(/SVG/)?"svg":"html":"html");d="html"!==f?B(ja(f,B("<div>").append(a).html())):c?Sa.clone.call(a):a;if(k)for(var l in k)d.data("$"+l+"Controller",k[l].instance);ca.$$addScopeInfo(d,b);c&&
c(d,b);g&&g(b,d,d,h);c||(a=g=null);return d}}function Va(a,b,c,d,e,g){function f(a,c,d,e){var g,k,l,m,q,n,H;if(s)for(H=Array(c.length),m=0;m<h.length;m+=3)g=h[m],H[g]=c[g];else H=c;m=0;for(q=h.length;m<q;)k=H[h[m++]],c=h[m++],g=h[m++],c?(c.scope?(l=a.$new(),ca.$$addScopeInfo(B(k),l)):l=a,n=c.transcludeOnThisElement?Ma(a,c.transclude,e):!c.templateOnThisElement&&e?e:!e&&b?Ma(a,b):null,c(g,l,k,d,n)):g&&g(a,k.childNodes,void 0,e)}for(var h=[],k=I(a)||a instanceof B,l,m,q,n,s,H=0;H<a.length;H++){l=new mc;
11===Ca&&Da(a,H,k);m=M(a[H],[],l,0===H?d:void 0,e);(g=m.length?Y(m,a[H],l,b,c,null,[],[],g):null)&&g.scope&&ca.$$addScopeClass(l.$$element);l=g&&g.terminal||!(q=a[H].childNodes)||!q.length?null:Va(q,g?(g.transcludeOnThisElement||!g.templateOnThisElement)&&g.transclude:b);if(g||l)h.push(H,g,l),n=!0,s=s||g;g=null}return n?f:null}function Da(a,b,c){var d=a[b],e=d.parentNode,g;if(d.nodeType===Oa)for(;;){g=e?d.nextSibling:a[b+1];if(!g||g.nodeType!==Oa)break;d.nodeValue+=g.nodeValue;g.parentNode&&g.parentNode.removeChild(g);
c&&g===a[b+1]&&a.splice(b+1,1)}}function Ma(a,b,c){function d(e,g,f,h,k){e||(e=a.$new(!1,k),e.$$transcluded=!0);return b(e,g,{parentBoundTranscludeFn:c,transcludeControllers:f,futureParentElement:h})}var e=d.$$slots=S(),g;for(g in b.$$slots)e[g]=b.$$slots[g]?Ma(a,b.$$slots[g],c):null;return d}function M(a,b,c,d,e){var g=c.$attr,f;switch(a.nodeType){case 1:f=za(a);T(b,Ea(f),"E",d,e);for(var h,l,m,q,n=a.attributes,s=0,H=n&&n.length;s<H;s++){var J=!1,G=!1;h=n[s];l=h.name;m=h.value;h=Ea(l);(q=Pa.test(h))&&
(l=l.replace(od,"").substr(8).replace(/_(.)/g,function(a,b){return b.toUpperCase()}));(h=h.match(Qa))&&$(h[1])&&(J=l,G=l.substr(0,l.length-5)+"end",l=l.substr(0,l.length-6));h=Ea(l.toLowerCase());g[h]=l;if(q||!c.hasOwnProperty(h))c[h]=m,kd(a,h)&&(c[h]=!0);xa(a,b,m,h,q);T(b,h,"A",d,e,J,G)}"input"===f&&"hidden"===a.getAttribute("type")&&a.setAttribute("autocomplete","off");if(!La)break;g=a.className;E(g)&&(g=g.animVal);if(D(g)&&""!==g)for(;a=k.exec(g);)h=Ea(a[2]),T(b,h,"C",d,e)&&(c[h]=Q(a[3])),g=g.substr(a.index+
a[0].length);break;case Oa:oa(b,a.nodeValue);break;case 8:if(!Ka)break;nc(a,b,c,d,e)}b.sort(ka);return b}function nc(a,b,c,d,e){try{var f=g.exec(a.nodeValue);if(f){var h=Ea(f[1]);T(b,h,"M",d,e)&&(c[h]=Q(f[2]))}}catch(k){}}function pd(a,b,c){var d=[],e=0;if(b&&a.hasAttribute&&a.hasAttribute(b)){do{if(!a)throw ba("uterdir",b,c);1===a.nodeType&&(a.hasAttribute(b)&&e++,a.hasAttribute(c)&&e--);d.push(a);a=a.nextSibling}while(0<e)}else d.push(a);return B(d)}function U(a,b,c){return function(d,e,g,f,h){e=
pd(e[0],b,c);return a(d,e,g,f,h)}}function V(a,b,c,d,e,g){var f;return a?ca(b,c,d,e,g):function(){f||(f=ca(b,c,d,e,g),b=c=g=null);return f.apply(this,arguments)}}function Y(a,b,d,e,g,f,h,k,l){function m(a,b,c,d){if(a){c&&(a=U(a,c,d));a.require=x.require;a.directiveName=W;if(K===x||x.$$isolateScope)a=ua(a,{isolateScope:!0});h.push(a)}if(b){c&&(b=U(b,c,d));b.require=x.require;b.directiveName=W;if(K===x||x.$$isolateScope)b=ua(b,{isolateScope:!0});k.push(b)}}function q(a,e,g,f,l){function m(a,b,c,d){var e;
cb(a)||(d=c,c=b,b=a,a=void 0);ta&&(e=L);c||(c=ta?fa.parent():fa);if(d){var g=l.$$slots[d];if(g)return g(a,b,e,c,O);if(w(g))throw ba("noslot",d,Aa(fa));}else return l(a,b,e,c,O)}var n,x,F,y,R,L,z,fa;b===g?(f=d,fa=d.$$element):(fa=B(g),f=new mc(fa,d));R=e;K?y=e.$new(!0):s&&(R=e.$parent);l&&(z=m,z.$$boundTransclude=l,z.isSlotFilled=function(a){return!!l.$$slots[a]});J&&(L=da(fa,f,z,J,y,e,K));K&&(ca.$$addScopeInfo(fa,y,!0,!(v&&(v===K||v===K.$$originalDirective))),ca.$$addScopeClass(fa,!0),y.$$isolateBindings=
K.$$isolateBindings,x=qa(e,f,y,y.$$isolateBindings,K),x.removeWatches&&y.$on("$destroy",x.removeWatches));for(n in L){x=J[n];F=L[n];var W=x.$$bindings.bindToController;if(G){F.bindingInfo=W?qa(R,f,F.instance,W,x):{};var r=F();r!==F.instance&&(F.instance=r,fa.data("$"+x.name+"Controller",r),F.bindingInfo.removeWatches&&F.bindingInfo.removeWatches(),F.bindingInfo=qa(R,f,F.instance,W,x))}else F.instance=F(),fa.data("$"+x.name+"Controller",F.instance),F.bindingInfo=qa(R,f,F.instance,W,x)}p(J,function(a,
b){var c=a.require;a.bindToController&&!I(c)&&E(c)&&P(L[b].instance,X(b,c,fa,L))});p(L,function(a){var b=a.instance;if(A(b.$onChanges))try{b.$onChanges(a.bindingInfo.initialChanges)}catch(d){c(d)}if(A(b.$onInit))try{b.$onInit()}catch(e){c(e)}A(b.$doCheck)&&(R.$watch(function(){b.$doCheck()}),b.$doCheck());A(b.$onDestroy)&&R.$on("$destroy",function(){b.$onDestroy()})});n=0;for(x=h.length;n<x;n++)F=h[n],wa(F,F.isolateScope?y:e,fa,f,F.require&&X(F.directiveName,F.require,fa,L),z);var O=e;K&&(K.template||
null===K.templateUrl)&&(O=y);a&&a(O,g.childNodes,void 0,l);for(n=k.length-1;0<=n;n--)F=k[n],wa(F,F.isolateScope?y:e,fa,f,F.require&&X(F.directiveName,F.require,fa,L),z);p(L,function(a){a=a.instance;A(a.$postLink)&&a.$postLink()})}l=l||{};for(var n=-Number.MAX_VALUE,s=l.newScopeDirective,J=l.controllerDirectives,K=l.newIsolateScopeDirective,v=l.templateDirective,y=l.nonTlbTranscludeDirective,R=!1,L=!1,ta=l.hasElementTranscludeDirective,F=d.$$element=B(b),x,W,z,r=e,O,t=!1,Jb=!1,u,Da=0,C=a.length;Da<
C;Da++){x=a[Da];var Ua=x.$$start,D=x.$$end;Ua&&(F=pd(b,Ua,D));z=void 0;if(n>x.priority)break;if(u=x.scope)x.templateUrl||(E(u)?(aa("new/isolated scope",K||s,x,F),K=x):aa("new/isolated scope",K,x,F)),s=s||x;W=x.name;if(!t&&(x.replace&&(x.templateUrl||x.template)||x.transclude&&!x.$$tlb)){for(u=Da+1;t=a[u++];)if(t.transclude&&!t.$$tlb||t.replace&&(t.templateUrl||t.template)){Jb=!0;break}t=!0}!x.templateUrl&&x.controller&&(J=J||S(),aa("'"+W+"' controller",J[W],x,F),J[W]=x);if(u=x.transclude)if(R=!0,
x.$$tlb||(aa("transclusion",y,x,F),y=x),"element"===u)ta=!0,n=x.priority,z=F,F=d.$$element=B(ca.$$createComment(W,d[W])),b=F[0],la(g,ya.call(z,0),b),z[0].$$parentNode=z[0].parentNode,r=V(Jb,z,e,n,f&&f.name,{nonTlbTranscludeDirective:y});else{var na=S();if(E(u)){z=[];var Va=S(),Ma=S();p(u,function(a,b){var c="?"===a.charAt(0);a=c?a.substring(1):a;Va[a]=b;na[b]=null;Ma[b]=c});p(F.contents(),function(a){var b=Va[Ea(za(a))];b?(Ma[b]=!0,na[b]=na[b]||[],na[b].push(a)):z.push(a)});p(Ma,function(a,b){if(!a)throw ba("reqslot",
b);});for(var N in na)na[N]&&(na[N]=V(Jb,na[N],e))}else z=B(jc(b)).contents();F.empty();r=V(Jb,z,e,void 0,void 0,{needsNewScope:x.$$isolateScope||x.$$newScope});r.$$slots=na}if(x.template)if(L=!0,aa("template",v,x,F),v=x,u=A(x.template)?x.template(F,d):x.template,u=Ia(u),x.replace){f=x;z=gc.test(u)?qd(ja(x.templateNamespace,Q(u))):[];b=z[0];if(1!==z.length||1!==b.nodeType)throw ba("tplrt",W,"");la(g,F,b);C={$attr:{}};u=M(b,[],C);var nc=a.splice(Da+1,a.length-(Da+1));(K||s)&&Z(u,K,s);a=a.concat(u).concat(nc);
ea(d,C);C=a.length}else F.html(u);if(x.templateUrl)L=!0,aa("template",v,x,F),v=x,x.replace&&(f=x),q=ia(a.splice(Da,a.length-Da),F,d,g,R&&r,h,k,{controllerDirectives:J,newScopeDirective:s!==x&&s,newIsolateScopeDirective:K,templateDirective:v,nonTlbTranscludeDirective:y}),C=a.length;else if(x.compile)try{O=x.compile(F,d,r);var T=x.$$originalDirective||x;A(O)?m(null,Ra(T,O),Ua,D):O&&m(Ra(T,O.pre),Ra(T,O.post),Ua,D)}catch($){c($,Aa(F))}x.terminal&&(q.terminal=!0,n=Math.max(n,x.priority))}q.scope=s&&!0===
s.scope;q.transcludeOnThisElement=R;q.templateOnThisElement=L;q.transclude=r;l.hasElementTranscludeDirective=ta;return q}function X(a,b,c,d){var e;if(D(b)){var g=b.match(l);b=b.substring(g[0].length);var f=g[1]||g[3],g="?"===g[2];"^^"===f?c=c.parent():e=(e=d&&d[b])&&e.instance;if(!e){var h="$"+b+"Controller";e=f?c.inheritedData(h):c.data(h)}if(!e&&!g)throw ba("ctreq",b,a);}else if(I(b))for(e=[],f=0,g=b.length;f<g;f++)e[f]=X(a,b[f],c,d);else E(b)&&(e={},p(b,function(b,g){e[g]=X(a,b,c,d)}));return e||
null}function da(a,b,c,d,e,g,f){var h=S(),k;for(k in d){var l=d[k],m={$scope:l===f||l.$$isolateScope?e:g,$element:a,$attrs:b,$transclude:c},n=l.controller;"@"===n&&(n=b[l.name]);m=F(n,m,!0,l.controllerAs);h[l.name]=m;a.data("$"+l.name+"Controller",m.instance)}return h}function Z(a,b,c){for(var d=0,e=a.length;d<e;d++)a[d]=Yb(a[d],{$$isolateScope:b,$$newScope:c})}function T(b,c,e,g,h,k,l){if(c===h)return null;var m=null;if(f.hasOwnProperty(c)){h=a.get(c+"Directive");for(var n=0,q=h.length;n<q;n++)if(c=
h[n],(w(g)||g>c.priority)&&-1!==c.restrict.indexOf(e)){k&&(c=Yb(c,{$$start:k,$$end:l}));if(!c.$$bindings){var s=m=c,H=c.name,J={isolateScope:null,bindToController:null};E(s.scope)&&(!0===s.bindToController?(J.bindToController=d(s.scope,H,!0),J.isolateScope={}):J.isolateScope=d(s.scope,H,!1));E(s.bindToController)&&(J.bindToController=d(s.bindToController,H,!0));if(J.bindToController&&!s.controller)throw ba("noctrl",H);m=m.$$bindings=J;E(m.isolateScope)&&(c.$$isolateBindings=m.isolateScope)}b.push(c);
m=c}}return m}function $(b){if(f.hasOwnProperty(b))for(var c=a.get(b+"Directive"),d=0,e=c.length;d<e;d++)if(b=c[d],b.multiElement)return!0;return!1}function ea(a,b){var c=b.$attr,d=a.$attr;p(a,function(d,e){"$"!==e.charAt(0)&&(b[e]&&b[e]!==d&&(d=d.length?d+(("style"===e?";":" ")+b[e]):b[e]),a.$set(e,d,!0,c[e]))});p(b,function(b,e){a.hasOwnProperty(e)||"$"===e.charAt(0)||(a[e]=b,"class"!==e&&"style"!==e&&(d[e]=c[e]))})}function ia(a,b,d,g,f,h,k,l){var m=[],n,q,s=b[0],J=a.shift(),x=Yb(J,{templateUrl:null,
transclude:null,replace:null,$$originalDirective:J}),G=A(J.templateUrl)?J.templateUrl(b,d):J.templateUrl,F=J.templateNamespace;b.empty();e(G).then(function(c){var e,H;c=Ia(c);if(J.replace){c=gc.test(c)?qd(ja(F,Q(c))):[];e=c[0];if(1!==c.length||1!==e.nodeType)throw ba("tplrt",J.name,G);c={$attr:{}};la(g,b,e);var K=M(e,[],c);E(J.scope)&&Z(K,!0);a=K.concat(a);ea(d,c)}else e=s,b.html(c);a.unshift(x);n=Y(a,e,d,f,b,J,h,k,l);p(g,function(a,c){a===e&&(g[c]=b[0])});for(q=Va(b[0].childNodes,f);m.length;){c=
m.shift();H=m.shift();var v=m.shift(),y=m.shift(),K=b[0];if(!c.$$destroyed){if(H!==s){var L=H.className;l.hasElementTranscludeDirective&&J.replace||(K=jc(e));la(v,B(H),K);na(B(K),L)}H=n.transcludeOnThisElement?Ma(c,n.transclude,y):y;n(q,c,K,g,H)}}m=null}).catch(function(a){$b(a)&&c(a)});return function(a,b,c,d,e){a=e;b.$$destroyed||(m?m.push(b,c,d,a):(n.transcludeOnThisElement&&(a=Ma(b,n.transclude,e)),n(q,b,c,d,a)))}}function ka(a,b){var c=b.priority-a.priority;return 0!==c?c:a.name!==b.name?a.name<
b.name?-1:1:a.index-b.index}function aa(a,b,c,d){function e(a){return a?" (module: "+a+")":""}if(b)throw ba("multidir",b.name,e(b.$$moduleName),c.name,e(c.$$moduleName),a,Aa(d));}function oa(a,c){var d=b(c,!0);d&&a.push({priority:0,compile:function(a){a=a.parent();var b=!!a.length;b&&ca.$$addBindingClass(a);return function(a,c){var e=c.parent();b||ca.$$addBindingClass(e);ca.$$addBindingInfo(e,d.expressions);a.$watch(d,function(a){c[0].nodeValue=a})}}})}function ja(a,b){a=N(a||"html");switch(a){case "svg":case "math":var c=
u.document.createElement("div");c.innerHTML="<"+a+">"+b+"</"+a+">";return c.childNodes[0].childNodes;default:return b}}function va(a,b){if("srcdoc"===b)return x.HTML;var c=za(a);if("src"===b||"ngSrc"===b){if(-1===["img","video","audio","source","track"].indexOf(c))return x.RESOURCE_URL}else if("xlinkHref"===b||"form"===c&&"action"===b||"link"===c&&"href"===b)return x.RESOURCE_URL}function xa(a,c,d,e,g){var f=va(a,e),k=h[e]||g,l=b(d,!g,f,k);if(l){if("multiple"===e&&"select"===za(a))throw ba("selmulti",
Aa(a));if(m.test(e))throw ba("nodomevents");c.push({priority:100,compile:function(){return{pre:function(a,c,g){c=g.$$observers||(g.$$observers=S());var h=g[e];h!==d&&(l=h&&b(h,!0,f,k),d=h);l&&(g[e]=l(a),(c[e]||(c[e]=[])).$$inter=!0,(g.$$observers&&g.$$observers[e].$$scope||a).$watch(l,function(a,b){"class"===e&&a!==b?g.$updateClass(a,b):g.$set(e,a)}))}}}})}}function la(a,b,c){var d=b[0],e=b.length,g=d.parentNode,f,h;if(a)for(f=0,h=a.length;f<h;f++)if(a[f]===d){a[f++]=c;h=f+e-1;for(var k=a.length;f<
k;f++,h++)h<k?a[f]=a[h]:delete a[f];a.length-=e-1;a.context===d&&(a.context=c);break}g&&g.replaceChild(c,d);a=u.document.createDocumentFragment();for(f=0;f<e;f++)a.appendChild(b[f]);B.hasData(d)&&(B.data(c,B.data(d)),B(d).off("$destroy"));B.cleanData(a.querySelectorAll("*"));for(f=1;f<e;f++)delete b[f];b[0]=c;b.length=1}function ua(a,b){return P(function(){return a.apply(null,arguments)},a,b)}function wa(a,b,d,e,g,f){try{a(b,d,e,g,f)}catch(h){c(h,Aa(d))}}function pa(a,b){if(L)throw ba("missingattr",
a,b);}function qa(a,c,d,e,g){function f(b,c,e){A(d.$onChanges)&&!ac(c,e)&&(ga||(a.$$postDigest(O),ga=[]),m||(m={},ga.push(h)),m[b]&&(e=m[b].previousValue),m[b]=new Kb(e,c))}function h(){d.$onChanges(m);m=void 0}var k=[],l={},m;p(e,function(e,h){var m=e.attrName,q=e.optional,s,H,x,G;switch(e.mode){case "@":q||ra.call(c,m)||(pa(m,g.name),d[h]=c[m]=void 0);q=c.$observe(m,function(a){if(D(a)||Na(a))f(h,a,d[h]),d[h]=a});c.$$observers[m].$$scope=a;s=c[m];D(s)?d[h]=b(s)(a):Na(s)&&(d[h]=s);l[h]=new Kb(oc,
d[h]);k.push(q);break;case "=":if(!ra.call(c,m)){if(q)break;pa(m,g.name);c[m]=void 0}if(q&&!c[m])break;H=n(c[m]);G=H.literal?sa:ac;x=H.assign||function(){s=d[h]=H(a);throw ba("nonassign",c[m],m,g.name);};s=d[h]=H(a);q=function(b){G(b,d[h])||(G(b,s)?x(a,b=d[h]):d[h]=b);return s=b};q.$stateful=!0;q=e.collection?a.$watchCollection(c[m],q):a.$watch(n(c[m],q),null,H.literal);k.push(q);break;case "<":if(!ra.call(c,m)){if(q)break;pa(m,g.name);c[m]=void 0}if(q&&!c[m])break;H=n(c[m]);var F=H.literal,v=d[h]=
H(a);l[h]=new Kb(oc,d[h]);q=a.$watch(H,function(a,b){if(b===a){if(b===v||F&&sa(b,v))return;b=v}f(h,a,b);d[h]=a},F);k.push(q);break;case "&":q||ra.call(c,m)||pa(m,g.name);H=c.hasOwnProperty(m)?n(c[m]):C;if(H===C&&q)break;d[h]=function(b){return H(a,b)}}});return{initialChanges:l,removeWatches:k.length&&function(){for(var a=0,b=k.length;a<b;++a)k[a]()}}}var Ja=/^\w/,Ba=u.document.createElement("div"),Ka=v,La=s,Fa=z,ga;mc.prototype={$normalize:Ea,$addClass:function(a){a&&0<a.length&&W.addClass(this.$$element,
a)},$removeClass:function(a){a&&0<a.length&&W.removeClass(this.$$element,a)},$updateClass:function(a,b){var c=rd(a,b);c&&c.length&&W.addClass(this.$$element,c);(c=rd(b,a))&&c.length&&W.removeClass(this.$$element,c)},$set:function(a,b,d,e){var g=kd(this.$$element[0],a),f=sd[a],h=a;g?(this.$$element.prop(a,b),e=g):f&&(this[f]=b,h=f);this[a]=b;e?this.$attr[a]=e:(e=this.$attr[a])||(this.$attr[a]=e=Vc(a,"-"));g=za(this.$$element);if("a"===g&&("href"===a||"xlinkHref"===a)||"img"===g&&"src"===a)this[a]=
b=r(b,"src"===a);else if("img"===g&&"srcset"===a&&t(b)){for(var g="",f=Q(b),k=/(\s+\d+x\s*,|\s+\d+w\s*,|\s+,|,\s+)/,k=/\s/.test(f)?k:/(,)/,f=f.split(k),k=Math.floor(f.length/2),l=0;l<k;l++)var m=2*l,g=g+r(Q(f[m]),!0),g=g+(" "+Q(f[m+1]));f=Q(f[2*l]).split(/\s/);g+=r(Q(f[0]),!0);2===f.length&&(g+=" "+Q(f[1]));this[a]=b=g}!1!==d&&(null===b||w(b)?this.$$element.removeAttr(e):Ja.test(e)?this.$$element.attr(e,b):Ua(this.$$element[0],e,b));(a=this.$$observers)&&p(a[h],function(a){try{a(b)}catch(d){c(d)}})},
$observe:function(a,b){var c=this,d=c.$$observers||(c.$$observers=S()),e=d[a]||(d[a]=[]);e.push(b);R.$evalAsync(function(){e.$$inter||!c.hasOwnProperty(a)||w(c[a])||b(c[a])});return function(){db(e,b)}}};var Ga=b.startSymbol(),Ha=b.endSymbol(),Ia="{{"===Ga&&"}}"===Ha?bb:function(a){return a.replace(/\{\{/g,Ga).replace(/}}/g,Ha)},Pa=/^ngAttr[A-Z]/,Qa=/^(.+)Start$/;ca.$$addBindingInfo=q?function(a,b){var c=a.data("$binding")||[];I(b)?c=c.concat(b):c.push(b);a.data("$binding",c)}:C;ca.$$addBindingClass=
q?function(a){na(a,"ng-binding")}:C;ca.$$addScopeInfo=q?function(a,b,c,d){a.data(c?d?"$isolateScopeNoTemplate":"$isolateScope":"$scope",b)}:C;ca.$$addScopeClass=q?function(a,b){na(a,b?"ng-isolate-scope":"ng-scope")}:C;ca.$$createComment=function(a,b){var c="";q&&(c=" "+(a||"")+": ",b&&(c+=b+" "));return u.document.createComment(c)};return ca}]}function Kb(a,b){this.previousValue=a;this.currentValue=b}function Ea(a){return a.replace(od,"").replace(tg,jb)}function rd(a,b){var d="",c=a.split(/\s+/),
e=b.split(/\s+/),f=0;a:for(;f<c.length;f++){for(var g=c[f],k=0;k<e.length;k++)if(g===e[k])continue a;d+=(0<d.length?" ":"")+g}return d}function qd(a){a=B(a);var b=a.length;if(1>=b)return a;for(;b--;){var d=a[b];(8===d.nodeType||d.nodeType===Oa&&""===d.nodeValue.trim())&&ug.call(a,b,1)}return a}function sg(a,b){if(b&&D(b))return b;if(D(a)){var d=td.exec(a);if(d)return d[3]}}function yf(){var a={},b=!1;this.has=function(b){return a.hasOwnProperty(b)};this.register=function(b,c){Ia(b,"controller");E(b)?
P(a,b):a[b]=c};this.allowGlobals=function(){b=!0};this.$get=["$injector","$window",function(d,c){function e(a,b,c,d){if(!a||!E(a.$scope))throw M("$controller")("noscp",d,b);a.$scope[b]=c}return function(f,g,k,h){var l,m,n;k=!0===k;h&&D(h)&&(n=h);if(D(f)){h=f.match(td);if(!h)throw ud("ctrlfmt",f);m=h[1];n=n||h[3];f=a.hasOwnProperty(m)?a[m]:Xc(g.$scope,m,!0)||(b?Xc(c,m,!0):void 0);if(!f)throw ud("ctrlreg",m);ub(f,m,!0)}if(k)return k=(I(f)?f[f.length-1]:f).prototype,l=Object.create(k||null),n&&e(g,n,
l,m||f.name),P(function(){var a=d.invoke(f,l,g,m);a!==l&&(E(a)||A(a))&&(l=a,n&&e(g,n,l,m||f.name));return l},{instance:l,identifier:n});l=d.instantiate(f,g,m);n&&e(g,n,l,m||f.name);return l}}]}function zf(){this.$get=["$window",function(a){return B(a.document)}]}function Af(){this.$get=["$document","$rootScope",function(a,b){function d(){e=c.hidden}var c=a[0],e=c&&c.hidden;a.on("visibilitychange",d);b.$on("$destroy",function(){a.off("visibilitychange",d)});return function(){return e}}]}function Bf(){this.$get=
["$log",function(a){return function(b,d){a.error.apply(a,arguments)}}]}function pc(a){return E(a)?ea(a)?a.toISOString():fb(a):a}function Gf(){this.$get=function(){return function(a){if(!a)return"";var b=[];Nc(a,function(a,c){null===a||w(a)||A(a)||(I(a)?p(a,function(a){b.push(ia(c)+"="+ia(pc(a)))}):b.push(ia(c)+"="+ia(pc(a))))});return b.join("&")}}}function Hf(){this.$get=function(){return function(a){function b(a,e,f){null===a||w(a)||(I(a)?p(a,function(a,c){b(a,e+"["+(E(a)?c:"")+"]")}):E(a)&&!ea(a)?
Nc(a,function(a,c){b(a,e+(f?"":"[")+c+(f?"":"]"))}):d.push(ia(e)+"="+ia(pc(a))))}if(!a)return"";var d=[];b(a,"",!0);return d.join("&")}}}function qc(a,b){if(D(a)){var d=a.replace(vg,"").trim();if(d){var c=b("Content-Type"),c=c&&0===c.indexOf(vd),e;(e=c)||(e=(e=d.match(wg))&&xg[e[0]].test(d));if(e)try{a=Qc(d)}catch(f){if(!c)return a;throw rc("baddata",a,f);}}}return a}function wd(a){var b=S(),d;D(a)?p(a.split("\n"),function(a){d=a.indexOf(":");var e=N(Q(a.substr(0,d)));a=Q(a.substr(d+1));e&&(b[e]=
b[e]?b[e]+", "+a:a)}):E(a)&&p(a,function(a,d){var f=N(d),g=Q(a);f&&(b[f]=b[f]?b[f]+", "+g:g)});return b}function xd(a){var b;return function(d){b||(b=wd(a));return d?(d=b[N(d)],void 0===d&&(d=null),d):b}}function yd(a,b,d,c){if(A(c))return c(a,b,d);p(c,function(c){a=c(a,b,d)});return a}function Ff(){var a=this.defaults={transformResponse:[qc],transformRequest:[function(a){return E(a)&&"[object File]"!==ha.call(a)&&"[object Blob]"!==ha.call(a)&&"[object FormData]"!==ha.call(a)?fb(a):a}],headers:{common:{Accept:"application/json, text/plain, */*"},
post:ja(sc),put:ja(sc),patch:ja(sc)},xsrfCookieName:"XSRF-TOKEN",xsrfHeaderName:"X-XSRF-TOKEN",paramSerializer:"$httpParamSerializer",jsonpCallbackParam:"callback"},b=!1;this.useApplyAsync=function(a){return t(a)?(b=!!a,this):b};var d=this.interceptors=[];this.$get=["$browser","$httpBackend","$$cookieReader","$cacheFactory","$rootScope","$q","$injector","$sce",function(c,e,f,g,k,h,l,m){function n(b){function d(a,b){for(var c=0,e=b.length;c<e;){var g=b[c++],f=b[c++];a=a.then(g,f)}b.length=0;return a}
function e(a,b){var c,d={};p(a,function(a,e){A(a)?(c=a(b),null!=c&&(d[e]=c)):d[e]=a});return d}function g(a){var b=P({},a);b.data=yd(a.data,a.headers,a.status,f.transformResponse);a=a.status;return 200<=a&&300>a?b:h.reject(b)}if(!E(b))throw M("$http")("badreq",b);if(!D(m.valueOf(b.url)))throw M("$http")("badreq",b.url);var f=P({method:"get",transformRequest:a.transformRequest,transformResponse:a.transformResponse,paramSerializer:a.paramSerializer,jsonpCallbackParam:a.jsonpCallbackParam},b);f.headers=
function(b){var c=a.headers,d=P({},b.headers),g,f,h,c=P({},c.common,c[N(b.method)]);a:for(g in c){f=N(g);for(h in d)if(N(h)===f)continue a;d[g]=c[g]}return e(d,ja(b))}(b);f.method=wb(f.method);f.paramSerializer=D(f.paramSerializer)?l.get(f.paramSerializer):f.paramSerializer;c.$$incOutstandingRequestCount();var k=[],n=[];b=h.resolve(f);p(v,function(a){(a.request||a.requestError)&&k.unshift(a.request,a.requestError);(a.response||a.responseError)&&n.push(a.response,a.responseError)});b=d(b,k);b=b.then(function(b){var c=
b.headers,d=yd(b.data,xd(c),void 0,b.transformRequest);w(d)&&p(c,function(a,b){"content-type"===N(b)&&delete c[b]});w(b.withCredentials)&&!w(a.withCredentials)&&(b.withCredentials=a.withCredentials);return q(b,d).then(g,g)});b=d(b,n);return b=b.finally(function(){c.$$completeOutstandingRequest(C)})}function q(c,d){function g(a){if(a){var c={};p(a,function(a,d){c[d]=function(c){function d(){a(c)}b?k.$applyAsync(d):k.$$phase?d():k.$apply(d)}});return c}}function l(a,c,d,e,g){function f(){q(c,a,d,e,
g)}R&&(200<=a&&300>a?R.put(O,[a,c,wd(d),e,g]):R.remove(O));b?k.$applyAsync(f):(f(),k.$$phase||k.$apply())}function q(a,b,d,e,g){b=-1<=b?b:0;(200<=b&&300>b?K.resolve:K.reject)({data:a,status:b,headers:xd(d),config:c,statusText:e,xhrStatus:g})}function H(a){q(a.data,a.status,ja(a.headers()),a.statusText,a.xhrStatus)}function v(){var a=n.pendingRequests.indexOf(c);-1!==a&&n.pendingRequests.splice(a,1)}var K=h.defer(),F=K.promise,R,x,W=c.headers,r="jsonp"===N(c.method),O=c.url;r?O=m.getTrustedResourceUrl(O):
D(O)||(O=m.valueOf(O));O=G(O,c.paramSerializer(c.params));r&&(O=L(O,c.jsonpCallbackParam));n.pendingRequests.push(c);F.then(v,v);!c.cache&&!a.cache||!1===c.cache||"GET"!==c.method&&"JSONP"!==c.method||(R=E(c.cache)?c.cache:E(a.cache)?a.cache:z);R&&(x=R.get(O),t(x)?x&&A(x.then)?x.then(H,H):I(x)?q(x[1],x[0],ja(x[2]),x[3],x[4]):q(x,200,{},"OK","complete"):R.put(O,F));w(x)&&((x=zd(c.url)?f()[c.xsrfCookieName||a.xsrfCookieName]:void 0)&&(W[c.xsrfHeaderName||a.xsrfHeaderName]=x),e(c.method,O,d,l,W,c.timeout,
c.withCredentials,c.responseType,g(c.eventHandlers),g(c.uploadEventHandlers)));return F}function G(a,b){0<b.length&&(a+=(-1===a.indexOf("?")?"?":"&")+b);return a}function L(a,b){if(/[&?][^=]+=JSON_CALLBACK/.test(a))throw rc("badjsonp",a);if((new RegExp("[&?]"+b+"=")).test(a))throw rc("badjsonp",b,a);return a+=(-1===a.indexOf("?")?"?":"&")+b+"=JSON_CALLBACK"}var z=g("$http");a.paramSerializer=D(a.paramSerializer)?l.get(a.paramSerializer):a.paramSerializer;var v=[];p(d,function(a){v.unshift(D(a)?l.get(a):
l.invoke(a))});n.pendingRequests=[];(function(a){p(arguments,function(a){n[a]=function(b,c){return n(P({},c||{},{method:a,url:b}))}})})("get","delete","head","jsonp");(function(a){p(arguments,function(a){n[a]=function(b,c,d){return n(P({},d||{},{method:a,url:b,data:c}))}})})("post","put","patch");n.defaults=a;return n}]}function Jf(){this.$get=function(){return function(){return new u.XMLHttpRequest}}}function If(){this.$get=["$browser","$jsonpCallbacks","$document","$xhrFactory",function(a,b,d,c){return yg(a,
c,a.defer,b,d[0])}]}function yg(a,b,d,c,e){function f(a,b,d){a=a.replace("JSON_CALLBACK",b);var f=e.createElement("script"),m=null;f.type="text/javascript";f.src=a;f.async=!0;m=function(a){f.removeEventListener("load",m);f.removeEventListener("error",m);e.body.removeChild(f);f=null;var g=-1,G="unknown";a&&("load"!==a.type||c.wasCalled(b)||(a={type:"error"}),G=a.type,g="error"===a.type?404:200);d&&d(g,G)};f.addEventListener("load",m);f.addEventListener("error",m);e.body.appendChild(f);return m}return function(e,
k,h,l,m,n,q,G,L,z){function v(){ma&&ma();y&&y.abort()}function s(a,b,c,e,g,f){t(H)&&d.cancel(H);ma=y=null;a(b,c,e,g,f)}k=k||a.url();if("jsonp"===N(e))var r=c.createCallback(k),ma=f(k,r,function(a,b){var d=200===a&&c.getResponse(r);s(l,a,d,"",b,"complete");c.removeCallback(r)});else{var y=b(e,k);y.open(e,k,!0);p(m,function(a,b){t(a)&&y.setRequestHeader(b,a)});y.onload=function(){var a=y.statusText||"",b="response"in y?y.response:y.responseText,c=1223===y.status?204:y.status;0===c&&(c=b?200:"file"===
ua(k).protocol?404:0);s(l,c,b,y.getAllResponseHeaders(),a,"complete")};y.onerror=function(){s(l,-1,null,null,"","error")};y.onabort=function(){s(l,-1,null,null,"","abort")};y.ontimeout=function(){s(l,-1,null,null,"","timeout")};p(L,function(a,b){y.addEventListener(b,a)});p(z,function(a,b){y.upload.addEventListener(b,a)});q&&(y.withCredentials=!0);if(G)try{y.responseType=G}catch(J){if("json"!==G)throw J;}y.send(w(h)?null:h)}if(0<n)var H=d(v,n);else n&&A(n.then)&&n.then(v)}}function Df(){var a="{{",
b="}}";this.startSymbol=function(b){return b?(a=b,this):a};this.endSymbol=function(a){return a?(b=a,this):b};this.$get=["$parse","$exceptionHandler","$sce",function(d,c,e){function f(a){return"\\\\\\"+a}function g(c){return c.replace(n,a).replace(q,b)}function k(a,b,c,d){var e=a.$watch(function(a){e();return d(a)},b,c);return e}function h(f,h,q,n){function s(a){try{var b=a;a=q?e.getTrusted(q,b):e.valueOf(b);return n&&!t(a)?a:dc(a)}catch(d){c(Fa.interr(f,d))}}if(!f.length||-1===f.indexOf(a)){var p;
h||(h=g(f),p=ka(h),p.exp=f,p.expressions=[],p.$$watchDelegate=k);return p}n=!!n;var r,y,J=0,H=[],ta=[];p=f.length;for(var K=[],F=[];J<p;)if(-1!==(r=f.indexOf(a,J))&&-1!==(y=f.indexOf(b,r+l)))J!==r&&K.push(g(f.substring(J,r))),J=f.substring(r+l,y),H.push(J),ta.push(d(J,s)),J=y+m,F.push(K.length),K.push("");else{J!==p&&K.push(g(f.substring(J)));break}q&&1<K.length&&Fa.throwNoconcat(f);if(!h||H.length){var R=function(a){for(var b=0,c=H.length;b<c;b++){if(n&&w(a[b]))return;K[F[b]]=a[b]}return K.join("")};
return P(function(a){var b=0,d=H.length,e=Array(d);try{for(;b<d;b++)e[b]=ta[b](a);return R(e)}catch(g){c(Fa.interr(f,g))}},{exp:f,expressions:H,$$watchDelegate:function(a,b){var c;return a.$watchGroup(ta,function(d,e){var g=R(d);A(b)&&b.call(this,g,d!==e?c:g,a);c=g})}})}}var l=a.length,m=b.length,n=new RegExp(a.replace(/./g,f),"g"),q=new RegExp(b.replace(/./g,f),"g");h.startSymbol=function(){return a};h.endSymbol=function(){return b};return h}]}function Ef(){this.$get=["$rootScope","$window","$q",
"$$q","$browser",function(a,b,d,c,e){function f(f,h,l,m){function n(){q?f.apply(null,G):f(v)}var q=4<arguments.length,G=q?ya.call(arguments,4):[],L=b.setInterval,p=b.clearInterval,v=0,s=t(m)&&!m,r=(s?c:d).defer(),ma=r.promise;l=t(l)?l:0;ma.$$intervalId=L(function(){s?e.defer(n):a.$evalAsync(n);r.notify(v++);0<l&&v>=l&&(r.resolve(v),p(ma.$$intervalId),delete g[ma.$$intervalId]);s||a.$apply()},h);g[ma.$$intervalId]=r;return ma}var g={};f.cancel=function(a){return a&&a.$$intervalId in g?(g[a.$$intervalId].promise.$$state.pur=
!0,g[a.$$intervalId].reject("canceled"),b.clearInterval(a.$$intervalId),delete g[a.$$intervalId],!0):!1};return f}]}function tc(a){a=a.split("/");for(var b=a.length;b--;)a[b]=gb(a[b]);return a.join("/")}function Ad(a,b){var d=ua(a);b.$$protocol=d.protocol;b.$$host=d.hostname;b.$$port=Z(d.port)||zg[d.protocol]||null}function Bd(a,b){if(Ag.test(a))throw mb("badpath",a);var d="/"!==a.charAt(0);d&&(a="/"+a);var c=ua(a);b.$$path=decodeURIComponent(d&&"/"===c.pathname.charAt(0)?c.pathname.substring(1):
c.pathname);b.$$search=Tc(c.search);b.$$hash=decodeURIComponent(c.hash);b.$$path&&"/"!==b.$$path.charAt(0)&&(b.$$path="/"+b.$$path)}function uc(a,b){return a.slice(0,b.length)===b}function va(a,b){if(uc(b,a))return b.substr(a.length)}function La(a){var b=a.indexOf("#");return-1===b?a:a.substr(0,b)}function nb(a){return a.replace(/(#.+)|#$/,"$1")}function vc(a,b,d){this.$$html5=!0;d=d||"";Ad(a,this);this.$$parse=function(a){var d=va(b,a);if(!D(d))throw mb("ipthprfx",a,b);Bd(d,this);this.$$path||(this.$$path=
"/");this.$$compose()};this.$$compose=function(){var a=cc(this.$$search),d=this.$$hash?"#"+gb(this.$$hash):"";this.$$url=tc(this.$$path)+(a?"?"+a:"")+d;this.$$absUrl=b+this.$$url.substr(1);this.$$urlUpdatedByLocation=!0};this.$$parseLinkUrl=function(c,e){if(e&&"#"===e[0])return this.hash(e.slice(1)),!0;var f,g;t(f=va(a,c))?(g=f,g=d&&t(f=va(d,f))?b+(va("/",f)||f):a+g):t(f=va(b,c))?g=b+f:b===c+"/"&&(g=b);g&&this.$$parse(g);return!!g}}function wc(a,b,d){Ad(a,this);this.$$parse=function(c){var e=va(a,
c)||va(b,c),f;w(e)||"#"!==e.charAt(0)?this.$$html5?f=e:(f="",w(e)&&(a=c,this.replace())):(f=va(d,e),w(f)&&(f=e));Bd(f,this);c=this.$$path;var e=a,g=/^\/[A-Z]:(\/.*)/;uc(f,e)&&(f=f.replace(e,""));g.exec(f)||(c=(f=g.exec(c))?f[1]:c);this.$$path=c;this.$$compose()};this.$$compose=function(){var b=cc(this.$$search),e=this.$$hash?"#"+gb(this.$$hash):"";this.$$url=tc(this.$$path)+(b?"?"+b:"")+e;this.$$absUrl=a+(this.$$url?d+this.$$url:"");this.$$urlUpdatedByLocation=!0};this.$$parseLinkUrl=function(b,d){return La(a)===
La(b)?(this.$$parse(b),!0):!1}}function Cd(a,b,d){this.$$html5=!0;wc.apply(this,arguments);this.$$parseLinkUrl=function(c,e){if(e&&"#"===e[0])return this.hash(e.slice(1)),!0;var f,g;a===La(c)?f=c:(g=va(b,c))?f=a+d+g:b===c+"/"&&(f=b);f&&this.$$parse(f);return!!f};this.$$compose=function(){var b=cc(this.$$search),e=this.$$hash?"#"+gb(this.$$hash):"";this.$$url=tc(this.$$path)+(b?"?"+b:"")+e;this.$$absUrl=a+d+this.$$url;this.$$urlUpdatedByLocation=!0}}function Lb(a){return function(){return this[a]}}
function Dd(a,b){return function(d){if(w(d))return this[a];this[a]=b(d);this.$$compose();return this}}function Lf(){var a="!",b={enabled:!1,requireBase:!0,rewriteLinks:!0};this.hashPrefix=function(b){return t(b)?(a=b,this):a};this.html5Mode=function(a){if(Na(a))return b.enabled=a,this;if(E(a)){Na(a.enabled)&&(b.enabled=a.enabled);Na(a.requireBase)&&(b.requireBase=a.requireBase);if(Na(a.rewriteLinks)||D(a.rewriteLinks))b.rewriteLinks=a.rewriteLinks;return this}return b};this.$get=["$rootScope","$browser",
"$sniffer","$rootElement","$window",function(d,c,e,f,g){function k(a,b,d){var e=l.url(),g=l.$$state;try{c.url(a,b,d),l.$$state=c.state()}catch(f){throw l.url(e),l.$$state=g,f;}}function h(a,b){d.$broadcast("$locationChangeSuccess",l.absUrl(),a,l.$$state,b)}var l,m;m=c.baseHref();var n=c.url(),q;if(b.enabled){if(!m&&b.requireBase)throw mb("nobase");q=n.substring(0,n.indexOf("/",n.indexOf("//")+2))+(m||"/");m=e.history?vc:Cd}else q=La(n),m=wc;var G=q.substr(0,La(q).lastIndexOf("/")+1);l=new m(q,G,"#"+
a);l.$$parseLinkUrl(n,n);l.$$state=c.state();var p=/^\s*(javascript|mailto):/i;f.on("click",function(a){var e=b.rewriteLinks;if(e&&!a.ctrlKey&&!a.metaKey&&!a.shiftKey&&2!==a.which&&2!==a.button){for(var h=B(a.target);"a"!==za(h[0]);)if(h[0]===f[0]||!(h=h.parent())[0])return;if(!D(e)||!w(h.attr(e))){var e=h.prop("href"),k=h.attr("href")||h.attr("xlink:href");E(e)&&"[object SVGAnimatedString]"===e.toString()&&(e=ua(e.animVal).href);p.test(e)||!e||h.attr("target")||a.isDefaultPrevented()||!l.$$parseLinkUrl(e,
k)||(a.preventDefault(),l.absUrl()!==c.url()&&(d.$apply(),g.angular["ff-684208-preventDefault"]=!0))}}});nb(l.absUrl())!==nb(n)&&c.url(l.absUrl(),!0);var z=!0;c.onUrlChange(function(a,b){uc(a,G)?(d.$evalAsync(function(){var c=l.absUrl(),e=l.$$state,g;a=nb(a);l.$$parse(a);l.$$state=b;g=d.$broadcast("$locationChangeStart",a,c,b,e).defaultPrevented;l.absUrl()===a&&(g?(l.$$parse(c),l.$$state=e,k(c,!1,e)):(z=!1,h(c,e)))}),d.$$phase||d.$digest()):g.location.href=a});d.$watch(function(){if(z||l.$$urlUpdatedByLocation){l.$$urlUpdatedByLocation=
!1;var a=nb(c.url()),b=nb(l.absUrl()),g=c.state(),f=l.$$replace,m=a!==b||l.$$html5&&e.history&&g!==l.$$state;if(z||m)z=!1,d.$evalAsync(function(){var b=l.absUrl(),c=d.$broadcast("$locationChangeStart",b,a,l.$$state,g).defaultPrevented;l.absUrl()===b&&(c?(l.$$parse(a),l.$$state=g):(m&&k(b,f,g===l.$$state?null:l.$$state),h(a,g)))})}l.$$replace=!1});return l}]}function Mf(){var a=!0,b=this;this.debugEnabled=function(b){return t(b)?(a=b,this):a};this.$get=["$window",function(d){function c(a){$b(a)&&(a.stack&&
f?a=a.message&&-1===a.stack.indexOf(a.message)?"Error: "+a.message+"\n"+a.stack:a.stack:a.sourceURL&&(a=a.message+"\n"+a.sourceURL+":"+a.line));return a}function e(a){var b=d.console||{},e=b[a]||b.log||C;return function(){var a=[];p(arguments,function(b){a.push(c(b))});return Function.prototype.apply.call(e,b,a)}}var f=Ca||/\bEdge\//.test(d.navigator&&d.navigator.userAgent);return{log:e("log"),info:e("info"),warn:e("warn"),error:e("error"),debug:function(){var c=e("debug");return function(){a&&c.apply(b,
arguments)}}()}}]}function Bg(a){return a+""}function Cg(a,b){return"undefined"!==typeof a?a:b}function Ed(a,b){return"undefined"===typeof a?b:"undefined"===typeof b?a:a+b}function Dg(a,b){switch(a.type){case r.MemberExpression:if(a.computed)return!1;break;case r.UnaryExpression:return 1;case r.BinaryExpression:return"+"!==a.operator?1:!1;case r.CallExpression:return!1}return void 0===b?Fd:b}function V(a,b,d){var c,e,f=a.isPure=Dg(a,d);switch(a.type){case r.Program:c=!0;p(a.body,function(a){V(a.expression,
b,f);c=c&&a.expression.constant});a.constant=c;break;case r.Literal:a.constant=!0;a.toWatch=[];break;case r.UnaryExpression:V(a.argument,b,f);a.constant=a.argument.constant;a.toWatch=a.argument.toWatch;break;case r.BinaryExpression:V(a.left,b,f);V(a.right,b,f);a.constant=a.left.constant&&a.right.constant;a.toWatch=a.left.toWatch.concat(a.right.toWatch);break;case r.LogicalExpression:V(a.left,b,f);V(a.right,b,f);a.constant=a.left.constant&&a.right.constant;a.toWatch=a.constant?[]:[a];break;case r.ConditionalExpression:V(a.test,
b,f);V(a.alternate,b,f);V(a.consequent,b,f);a.constant=a.test.constant&&a.alternate.constant&&a.consequent.constant;a.toWatch=a.constant?[]:[a];break;case r.Identifier:a.constant=!1;a.toWatch=[a];break;case r.MemberExpression:V(a.object,b,f);a.computed&&V(a.property,b,f);a.constant=a.object.constant&&(!a.computed||a.property.constant);a.toWatch=a.constant?[]:[a];break;case r.CallExpression:c=d=a.filter?!b(a.callee.name).$stateful:!1;e=[];p(a.arguments,function(a){V(a,b,f);c=c&&a.constant;e.push.apply(e,
a.toWatch)});a.constant=c;a.toWatch=d?e:[a];break;case r.AssignmentExpression:V(a.left,b,f);V(a.right,b,f);a.constant=a.left.constant&&a.right.constant;a.toWatch=[a];break;case r.ArrayExpression:c=!0;e=[];p(a.elements,function(a){V(a,b,f);c=c&&a.constant;e.push.apply(e,a.toWatch)});a.constant=c;a.toWatch=e;break;case r.ObjectExpression:c=!0;e=[];p(a.properties,function(a){V(a.value,b,f);c=c&&a.value.constant;e.push.apply(e,a.value.toWatch);a.computed&&(V(a.key,b,!1),c=c&&a.key.constant,e.push.apply(e,
a.key.toWatch))});a.constant=c;a.toWatch=e;break;case r.ThisExpression:a.constant=!1;a.toWatch=[];break;case r.LocalsExpression:a.constant=!1,a.toWatch=[]}}function Gd(a){if(1===a.length){a=a[0].expression;var b=a.toWatch;return 1!==b.length?b:b[0]!==a?b:void 0}}function Hd(a){return a.type===r.Identifier||a.type===r.MemberExpression}function Id(a){if(1===a.body.length&&Hd(a.body[0].expression))return{type:r.AssignmentExpression,left:a.body[0].expression,right:{type:r.NGValueParameter},operator:"="}}
function Jd(a){this.$filter=a}function Kd(a){this.$filter=a}function xc(a,b,d){this.ast=new r(a,d);this.astCompiler=d.csp?new Kd(b):new Jd(b)}function yc(a){return A(a.valueOf)?a.valueOf():Eg.call(a)}function Nf(){var a=S(),b={"true":!0,"false":!1,"null":null,undefined:void 0},d,c;this.addLiteral=function(a,c){b[a]=c};this.setIdentifierFns=function(a,b){d=a;c=b;return this};this.$get=["$filter",function(e){function f(a,b,c){return null==a||null==b?a===b:"object"!==typeof a||(a=yc(a),"object"!==typeof a||
c)?a===b||a!==a&&b!==b:!1}function g(a,b,c,d,e){var g=d.inputs,h;if(1===g.length){var k=f,g=g[0];return a.$watch(function(a){var b=g(a);f(b,k,g.isPure)||(h=d(a,void 0,void 0,[b]),k=b&&yc(b));return h},b,c,e)}for(var l=[],m=[],n=0,p=g.length;n<p;n++)l[n]=f,m[n]=null;return a.$watch(function(a){for(var b=!1,c=0,e=g.length;c<e;c++){var k=g[c](a);if(b||(b=!f(k,l[c],g[c].isPure)))m[c]=k,l[c]=k&&yc(k)}b&&(h=d(a,void 0,void 0,m));return h},b,c,e)}function k(a,b,c,d,e){function f(a){return d(a)}function h(a,
c,d){l=a;A(b)&&b(a,c,d);t(a)&&d.$$postDigest(function(){t(l)&&k()})}var k,l;return k=d.inputs?g(a,h,c,d,e):a.$watch(f,h,c)}function h(a,b,c,d){function e(a){var b=!0;p(a,function(a){t(a)||(b=!1)});return b}var g,f;return g=a.$watch(function(a){return d(a)},function(a,c,d){f=a;A(b)&&b(a,c,d);e(a)&&d.$$postDigest(function(){e(f)&&g()})},c)}function l(a,b,c,d){var e=a.$watch(function(a){e();return d(a)},b,c);return e}function m(a,b){if(!b)return a;var c=a.$$watchDelegate,d=!1,e=c!==h&&c!==k?function(c,
e,g,f){g=d&&f?f[0]:a(c,e,g,f);return b(g,c,e)}:function(c,d,e,g){e=a(c,d,e,g);c=b(e,c,d);return t(e)?c:e},d=!a.inputs;c&&c!==g?(e.$$watchDelegate=c,e.inputs=a.inputs):b.$stateful||(e.$$watchDelegate=g,e.inputs=a.inputs?a.inputs:[a]);e.inputs&&(e.inputs=e.inputs.map(function(a){return a.isPure===Fd?function(b){return a(b)}:a}));return e}var n={csp:Ja().noUnsafeEval,literals:pa(b),isIdentifierStart:A(d)&&d,isIdentifierContinue:A(c)&&c};return function(b,c){var d,f,p;switch(typeof b){case "string":return p=
b=b.trim(),d=a[p],d||(":"===b.charAt(0)&&":"===b.charAt(1)&&(f=!0,b=b.substring(2)),d=new zc(n),d=(new xc(d,e,n)).parse(b),d.constant?d.$$watchDelegate=l:f?d.$$watchDelegate=d.literal?h:k:d.inputs&&(d.$$watchDelegate=g),a[p]=d),m(d,c);case "function":return m(b,c);default:return m(C,c)}}}]}function Pf(){var a=!0;this.$get=["$rootScope","$exceptionHandler",function(b,d){return Ld(function(a){b.$evalAsync(a)},d,a)}];this.errorOnUnhandledRejections=function(b){return t(b)?(a=b,this):a}}function Qf(){var a=
!0;this.$get=["$browser","$exceptionHandler",function(b,d){return Ld(function(a){b.defer(a)},d,a)}];this.errorOnUnhandledRejections=function(b){return t(b)?(a=b,this):a}}function Ld(a,b,d){function c(){return new e}function e(){var a=this.promise=new f;this.resolve=function(b){h(a,b)};this.reject=function(b){m(a,b)};this.notify=function(b){q(a,b)}}function f(){this.$$state={status:0}}function g(){for(;!t&&u.length;){var a=u.shift();if(!a.pur){a.pur=!0;var c=a.value,c="Possibly unhandled rejection: "+
("function"===typeof c?c.toString().replace(/ \{[\s\S]*$/,""):w(c)?"undefined":"string"!==typeof c?De(c,void 0):c);$b(a.value)?b(a.value,c):b(c)}}}function k(b){!d||b.pending||2!==b.status||b.pur||(0===t&&0===u.length&&a(g),u.push(b));!b.processScheduled&&b.pending&&(b.processScheduled=!0,++t,a(function(){var c,e,f;f=b.pending;b.processScheduled=!1;b.pending=void 0;try{for(var k=0,l=f.length;k<l;++k){b.pur=!0;e=f[k][0];c=f[k][b.status];try{A(c)?h(e,c(b.value)):1===b.status?h(e,b.value):m(e,b.value)}catch(n){m(e,
n)}}}finally{--t,d&&0===t&&a(g)}}))}function h(a,b){a.$$state.status||(b===a?n(a,s("qcycle",b)):l(a,b))}function l(a,b){function c(b){f||(f=!0,l(a,b))}function d(b){f||(f=!0,n(a,b))}function e(b){q(a,b)}var g,f=!1;try{if(E(b)||A(b))g=b.then;A(g)?(a.$$state.status=-1,g.call(b,c,d,e)):(a.$$state.value=b,a.$$state.status=1,k(a.$$state))}catch(h){d(h)}}function m(a,b){a.$$state.status||n(a,b)}function n(a,b){a.$$state.value=b;a.$$state.status=2;k(a.$$state)}function q(c,d){var e=c.$$state.pending;0>=
c.$$state.status&&e&&e.length&&a(function(){for(var a,c,g=0,f=e.length;g<f;g++){c=e[g][0];a=e[g][3];try{q(c,A(a)?a(d):d)}catch(h){b(h)}}})}function G(a){var b=new f;m(b,a);return b}function r(a,b,c){var d=null;try{A(c)&&(d=c())}catch(e){return G(e)}return d&&A(d.then)?d.then(function(){return b(a)},G):b(a)}function z(a,b,c,d){var e=new f;h(e,a);return e.then(b,c,d)}function v(a){if(!A(a))throw s("norslvr",a);var b=new f;a(function(a){h(b,a)},function(a){m(b,a)});return b}var s=M("$q",TypeError),t=
0,u=[];P(f.prototype,{then:function(a,b,c){if(w(a)&&w(b)&&w(c))return this;var d=new f;this.$$state.pending=this.$$state.pending||[];this.$$state.pending.push([d,a,b,c]);0<this.$$state.status&&k(this.$$state);return d},"catch":function(a){return this.then(null,a)},"finally":function(a,b){return this.then(function(b){return r(b,y,a)},function(b){return r(b,G,a)},b)}});var y=z;v.prototype=f.prototype;v.defer=c;v.reject=G;v.when=z;v.resolve=y;v.all=function(a){var b=new f,c=0,d=I(a)?[]:{};p(a,function(a,
e){c++;z(a).then(function(a){d[e]=a;--c||h(b,d)},function(a){m(b,a)})});0===c&&h(b,d);return b};v.race=function(a){var b=c();p(a,function(a){z(a).then(b.resolve,b.reject)});return b.promise};return v}function Zf(){this.$get=["$window","$timeout",function(a,b){var d=a.requestAnimationFrame||a.webkitRequestAnimationFrame,c=a.cancelAnimationFrame||a.webkitCancelAnimationFrame||a.webkitCancelRequestAnimationFrame,e=!!d,f=e?function(a){var b=d(a);return function(){c(b)}}:function(a){var c=b(a,16.66,!1);
return function(){b.cancel(c)}};f.supported=e;return f}]}function Of(){function a(a){function b(){this.$$watchers=this.$$nextSibling=this.$$childHead=this.$$childTail=null;this.$$listeners={};this.$$listenerCount={};this.$$watchersCount=0;this.$id=++sb;this.$$ChildScope=null}b.prototype=a;return b}var b=10,d=M("$rootScope"),c=null,e=null;this.digestTtl=function(a){arguments.length&&(b=a);return b};this.$get=["$exceptionHandler","$parse","$browser",function(f,g,k){function h(a){a.currentScope.$$destroyed=
!0}function l(a){9===Ca&&(a.$$childHead&&l(a.$$childHead),a.$$nextSibling&&l(a.$$nextSibling));a.$parent=a.$$nextSibling=a.$$prevSibling=a.$$childHead=a.$$childTail=a.$root=a.$$watchers=null}function m(){this.$id=++sb;this.$$phase=this.$parent=this.$$watchers=this.$$nextSibling=this.$$prevSibling=this.$$childHead=this.$$childTail=null;this.$root=this;this.$$destroyed=!1;this.$$listeners={};this.$$listenerCount={};this.$$watchersCount=0;this.$$isolateBindings=null}function n(a){if(s.$$phase)throw d("inprog",
s.$$phase);s.$$phase=a}function q(a,b){do a.$$watchersCount+=b;while(a=a.$parent)}function G(a,b,c){do a.$$listenerCount[c]-=b,0===a.$$listenerCount[c]&&delete a.$$listenerCount[c];while(a=a.$parent)}function r(){}function z(){for(;y.length;)try{y.shift()()}catch(a){f(a)}e=null}function v(){null===e&&(e=k.defer(function(){s.$apply(z)}))}m.prototype={constructor:m,$new:function(b,c){var d;c=c||this;b?(d=new m,d.$root=this.$root):(this.$$ChildScope||(this.$$ChildScope=a(this)),d=new this.$$ChildScope);
d.$parent=c;d.$$prevSibling=c.$$childTail;c.$$childHead?(c.$$childTail.$$nextSibling=d,c.$$childTail=d):c.$$childHead=c.$$childTail=d;(b||c!==this)&&d.$on("$destroy",h);return d},$watch:function(a,b,d,e){var f=g(a);if(f.$$watchDelegate)return f.$$watchDelegate(this,b,d,f,a);var h=this,k=h.$$watchers,l={fn:b,last:r,get:f,exp:e||a,eq:!!d};c=null;A(b)||(l.fn=C);k||(k=h.$$watchers=[],k.$$digestWatchIndex=-1);k.unshift(l);k.$$digestWatchIndex++;q(this,1);return function(){var a=db(k,l);0<=a&&(q(h,-1),
a<k.$$digestWatchIndex&&k.$$digestWatchIndex--);c=null}},$watchGroup:function(a,b){function c(){h=!1;k?(k=!1,b(e,e,f)):b(e,d,f)}var d=Array(a.length),e=Array(a.length),g=[],f=this,h=!1,k=!0;if(!a.length){var l=!0;f.$evalAsync(function(){l&&b(e,e,f)});return function(){l=!1}}if(1===a.length)return this.$watch(a[0],function(a,c,g){e[0]=a;d[0]=c;b(e,a===c?e:d,g)});p(a,function(a,b){var k=f.$watch(a,function(a,g){e[b]=a;d[b]=g;h||(h=!0,f.$evalAsync(c))});g.push(k)});return function(){for(;g.length;)g.shift()()}},
$watchCollection:function(a,b){function c(a){e=a;var b,d,g,h;if(!w(e)){if(E(e))if(xa(e))for(f!==n&&(f=n,p=f.length=0,l++),a=e.length,p!==a&&(l++,f.length=p=a),b=0;b<a;b++)h=f[b],g=e[b],d=h!==h&&g!==g,d||h===g||(l++,f[b]=g);else{f!==q&&(f=q={},p=0,l++);a=0;for(b in e)ra.call(e,b)&&(a++,g=e[b],h=f[b],b in f?(d=h!==h&&g!==g,d||h===g||(l++,f[b]=g)):(p++,f[b]=g,l++));if(p>a)for(b in l++,f)ra.call(e,b)||(p--,delete f[b])}else f!==e&&(f=e,l++);return l}}c.$stateful=!0;var d=this,e,f,h,k=1<b.length,l=0,m=
g(a,c),n=[],q={},s=!0,p=0;return this.$watch(m,function(){s?(s=!1,b(e,e,d)):b(e,h,d);if(k)if(E(e))if(xa(e)){h=Array(e.length);for(var a=0;a<e.length;a++)h[a]=e[a]}else for(a in h={},e)ra.call(e,a)&&(h[a]=e[a]);else h=e})},$digest:function(){var a,g,h,l,m,q,p,G=b,y,v=[],w,B;n("$digest");k.$$checkUrlChange();this===s&&null!==e&&(k.defer.cancel(e),z());c=null;do{p=!1;y=this;for(q=0;q<t.length;q++){try{B=t[q],l=B.fn,l(B.scope,B.locals)}catch(C){f(C)}c=null}t.length=0;a:do{if(q=y.$$watchers)for(q.$$digestWatchIndex=
q.length;q.$$digestWatchIndex--;)try{if(a=q[q.$$digestWatchIndex])if(m=a.get,(g=m(y))!==(h=a.last)&&!(a.eq?sa(g,h):T(g)&&T(h)))p=!0,c=a,a.last=a.eq?pa(g,null):g,l=a.fn,l(g,h===r?g:h,y),5>G&&(w=4-G,v[w]||(v[w]=[]),v[w].push({msg:A(a.exp)?"fn: "+(a.exp.name||a.exp.toString()):a.exp,newVal:g,oldVal:h}));else if(a===c){p=!1;break a}}catch(E){f(E)}if(!(q=y.$$watchersCount&&y.$$childHead||y!==this&&y.$$nextSibling))for(;y!==this&&!(q=y.$$nextSibling);)y=y.$parent}while(y=q);if((p||t.length)&&!G--)throw s.$$phase=
null,d("infdig",b,v);}while(p||t.length);for(s.$$phase=null;J<u.length;)try{u[J++]()}catch(D){f(D)}u.length=J=0;k.$$checkUrlChange()},$destroy:function(){if(!this.$$destroyed){var a=this.$parent;this.$broadcast("$destroy");this.$$destroyed=!0;this===s&&k.$$applicationDestroyed();q(this,-this.$$watchersCount);for(var b in this.$$listenerCount)G(this,this.$$listenerCount[b],b);a&&a.$$childHead===this&&(a.$$childHead=this.$$nextSibling);a&&a.$$childTail===this&&(a.$$childTail=this.$$prevSibling);this.$$prevSibling&&
(this.$$prevSibling.$$nextSibling=this.$$nextSibling);this.$$nextSibling&&(this.$$nextSibling.$$prevSibling=this.$$prevSibling);this.$destroy=this.$digest=this.$apply=this.$evalAsync=this.$applyAsync=C;this.$on=this.$watch=this.$watchGroup=function(){return C};this.$$listeners={};this.$$nextSibling=null;l(this)}},$eval:function(a,b){return g(a)(this,b)},$evalAsync:function(a,b){s.$$phase||t.length||k.defer(function(){t.length&&s.$digest()});t.push({scope:this,fn:g(a),locals:b})},$$postDigest:function(a){u.push(a)},
$apply:function(a){try{n("$apply");try{return this.$eval(a)}finally{s.$$phase=null}}catch(b){f(b)}finally{try{s.$digest()}catch(c){throw f(c),c;}}},$applyAsync:function(a){function b(){c.$eval(a)}var c=this;a&&y.push(b);a=g(a);v()},$on:function(a,b){var c=this.$$listeners[a];c||(this.$$listeners[a]=c=[]);c.push(b);var d=this;do d.$$listenerCount[a]||(d.$$listenerCount[a]=0),d.$$listenerCount[a]++;while(d=d.$parent);var e=this;return function(){var d=c.indexOf(b);-1!==d&&(c[d]=null,G(e,1,a))}},$emit:function(a,
b){var c=[],d,e=this,g=!1,h={name:a,targetScope:e,stopPropagation:function(){g=!0},preventDefault:function(){h.defaultPrevented=!0},defaultPrevented:!1},k=eb([h],arguments,1),l,m;do{d=e.$$listeners[a]||c;h.currentScope=e;l=0;for(m=d.length;l<m;l++)if(d[l])try{d[l].apply(null,k)}catch(n){f(n)}else d.splice(l,1),l--,m--;if(g)return h.currentScope=null,h;e=e.$parent}while(e);h.currentScope=null;return h},$broadcast:function(a,b){var c=this,d=this,e={name:a,targetScope:this,preventDefault:function(){e.defaultPrevented=
!0},defaultPrevented:!1};if(!this.$$listenerCount[a])return e;for(var g=eb([e],arguments,1),h,k;c=d;){e.currentScope=c;d=c.$$listeners[a]||[];h=0;for(k=d.length;h<k;h++)if(d[h])try{d[h].apply(null,g)}catch(l){f(l)}else d.splice(h,1),h--,k--;if(!(d=c.$$listenerCount[a]&&c.$$childHead||c!==this&&c.$$nextSibling))for(;c!==this&&!(d=c.$$nextSibling);)c=c.$parent}e.currentScope=null;return e}};var s=new m,t=s.$$asyncQueue=[],u=s.$$postDigestQueue=[],y=s.$$applyAsyncQueue=[],J=0;return s}]}function Ge(){var a=
/^\s*(https?|ftp|mailto|tel|file):/,b=/^\s*((https?|ftp|file|blob):|data:image\/)/;this.aHrefSanitizationWhitelist=function(b){return t(b)?(a=b,this):a};this.imgSrcSanitizationWhitelist=function(a){return t(a)?(b=a,this):b};this.$get=function(){return function(d,c){var e=c?b:a,f;f=ua(d).href;return""===f||f.match(e)?d:"unsafe:"+f}}}function Fg(a){if("self"===a)return a;if(D(a)){if(-1<a.indexOf("***"))throw wa("iwcard",a);a=Md(a).replace(/\\\*\\\*/g,".*").replace(/\\\*/g,"[^:/.?&;]*");return new RegExp("^"+
a+"$")}if(ab(a))return new RegExp("^"+a.source+"$");throw wa("imatcher");}function Nd(a){var b=[];t(a)&&p(a,function(a){b.push(Fg(a))});return b}function Sf(){this.SCE_CONTEXTS=oa;var a=["self"],b=[];this.resourceUrlWhitelist=function(b){arguments.length&&(a=Nd(b));return a};this.resourceUrlBlacklist=function(a){arguments.length&&(b=Nd(a));return b};this.$get=["$injector",function(d){function c(a,b){return"self"===a?zd(b):!!a.exec(b.href)}function e(a){var b=function(a){this.$$unwrapTrustedValue=
function(){return a}};a&&(b.prototype=new a);b.prototype.valueOf=function(){return this.$$unwrapTrustedValue()};b.prototype.toString=function(){return this.$$unwrapTrustedValue().toString()};return b}var f=function(a){throw wa("unsafe");};d.has("$sanitize")&&(f=d.get("$sanitize"));var g=e(),k={};k[oa.HTML]=e(g);k[oa.CSS]=e(g);k[oa.URL]=e(g);k[oa.JS]=e(g);k[oa.RESOURCE_URL]=e(k[oa.URL]);return{trustAs:function(a,b){var c=k.hasOwnProperty(a)?k[a]:null;if(!c)throw wa("icontext",a,b);if(null===b||w(b)||
""===b)return b;if("string"!==typeof b)throw wa("itype",a);return new c(b)},getTrusted:function(d,e){if(null===e||w(e)||""===e)return e;var g=k.hasOwnProperty(d)?k[d]:null;if(g&&e instanceof g)return e.$$unwrapTrustedValue();if(d===oa.RESOURCE_URL){var g=ua(e.toString()),n,q,p=!1;n=0;for(q=a.length;n<q;n++)if(c(a[n],g)){p=!0;break}if(p)for(n=0,q=b.length;n<q;n++)if(c(b[n],g)){p=!1;break}if(p)return e;throw wa("insecurl",e.toString());}if(d===oa.HTML)return f(e);throw wa("unsafe");},valueOf:function(a){return a instanceof
g?a.$$unwrapTrustedValue():a}}}]}function Rf(){var a=!0;this.enabled=function(b){arguments.length&&(a=!!b);return a};this.$get=["$parse","$sceDelegate",function(b,d){if(a&&8>Ca)throw wa("iequirks");var c=ja(oa);c.isEnabled=function(){return a};c.trustAs=d.trustAs;c.getTrusted=d.getTrusted;c.valueOf=d.valueOf;a||(c.trustAs=c.getTrusted=function(a,b){return b},c.valueOf=bb);c.parseAs=function(a,d){var e=b(d);return e.literal&&e.constant?e:b(d,function(b){return c.getTrusted(a,b)})};var e=c.parseAs,
f=c.getTrusted,g=c.trustAs;p(oa,function(a,b){var d=N(b);c[("parse_as_"+d).replace(Ac,jb)]=function(b){return e(a,b)};c[("get_trusted_"+d).replace(Ac,jb)]=function(b){return f(a,b)};c[("trust_as_"+d).replace(Ac,jb)]=function(b){return g(a,b)}});return c}]}function Tf(){this.$get=["$window","$document",function(a,b){var d={},c=!((!a.nw||!a.nw.process)&&a.chrome&&(a.chrome.app&&a.chrome.app.runtime||!a.chrome.app&&a.chrome.runtime&&a.chrome.runtime.id))&&a.history&&a.history.pushState,e=Z((/android (\d+)/.exec(N((a.navigator||
{}).userAgent))||[])[1]),f=/Boxee/i.test((a.navigator||{}).userAgent),g=b[0]||{},k=g.body&&g.body.style,h=!1,l=!1;k&&(h=!!("transition"in k||"webkitTransition"in k),l=!!("animation"in k||"webkitAnimation"in k));return{history:!(!c||4>e||f),hasEvent:function(a){if("input"===a&&Ca)return!1;if(w(d[a])){var b=g.createElement("div");d[a]="on"+a in b}return d[a]},csp:Ja(),transitions:h,animations:l,android:e}}]}function Vf(){var a;this.httpOptions=function(b){return b?(a=b,this):a};this.$get=["$exceptionHandler",
"$templateCache","$http","$q","$sce",function(b,d,c,e,f){function g(k,h){g.totalPendingRequests++;if(!D(k)||w(d.get(k)))k=f.getTrustedResourceUrl(k);var l=c.defaults&&c.defaults.transformResponse;I(l)?l=l.filter(function(a){return a!==qc}):l===qc&&(l=null);return c.get(k,P({cache:d,transformResponse:l},a)).finally(function(){g.totalPendingRequests--}).then(function(a){d.put(k,a.data);return a.data},function(a){h||(a=Gg("tpload",k,a.status,a.statusText),b(a));return e.reject(a)})}g.totalPendingRequests=
0;return g}]}function Wf(){this.$get=["$rootScope","$browser","$location",function(a,b,d){return{findBindings:function(a,b,d){a=a.getElementsByClassName("ng-binding");var g=[];p(a,function(a){var c=$.element(a).data("$binding");c&&p(c,function(c){d?(new RegExp("(^|\\s)"+Md(b)+"(\\s|\\||$)")).test(c)&&g.push(a):-1!==c.indexOf(b)&&g.push(a)})});return g},findModels:function(a,b,d){for(var g=["ng-","data-ng-","ng\\:"],k=0;k<g.length;++k){var h=a.querySelectorAll("["+g[k]+"model"+(d?"=":"*=")+'"'+b+'"]');
if(h.length)return h}},getLocation:function(){return d.url()},setLocation:function(b){b!==d.url()&&(d.url(b),a.$digest())},whenStable:function(a){b.notifyWhenNoOutstandingRequests(a)}}}]}function Xf(){this.$get=["$rootScope","$browser","$q","$$q","$exceptionHandler",function(a,b,d,c,e){function f(f,h,l){A(f)||(l=h,h=f,f=C);var m=ya.call(arguments,3),n=t(l)&&!l,q=(n?c:d).defer(),p=q.promise,r;r=b.defer(function(){try{q.resolve(f.apply(null,m))}catch(b){q.reject(b),e(b)}finally{delete g[p.$$timeoutId]}n||
a.$apply()},h);p.$$timeoutId=r;g[r]=q;return p}var g={};f.cancel=function(a){return a&&a.$$timeoutId in g?(g[a.$$timeoutId].promise.$$state.pur=!0,g[a.$$timeoutId].reject("canceled"),delete g[a.$$timeoutId],b.defer.cancel(a.$$timeoutId)):!1};return f}]}function ua(a){Ca&&(X.setAttribute("href",a),a=X.href);X.setAttribute("href",a);return{href:X.href,protocol:X.protocol?X.protocol.replace(/:$/,""):"",host:X.host,search:X.search?X.search.replace(/^\?/,""):"",hash:X.hash?X.hash.replace(/^#/,""):"",hostname:X.hostname,
port:X.port,pathname:"/"===X.pathname.charAt(0)?X.pathname:"/"+X.pathname}}function zd(a){a=D(a)?ua(a):a;return a.protocol===Od.protocol&&a.host===Od.host}function Yf(){this.$get=ka(u)}function Pd(a){function b(a){try{return decodeURIComponent(a)}catch(b){return a}}var d=a[0]||{},c={},e="";return function(){var a,g,k,h,l;try{a=d.cookie||""}catch(m){a=""}if(a!==e)for(e=a,a=e.split("; "),c={},k=0;k<a.length;k++)g=a[k],h=g.indexOf("="),0<h&&(l=b(g.substring(0,h)),w(c[l])&&(c[l]=b(g.substring(h+1))));
return c}}function bg(){this.$get=Pd}function ed(a){function b(d,c){if(E(d)){var e={};p(d,function(a,c){e[c]=b(c,a)});return e}return a.factory(d+"Filter",c)}this.register=b;this.$get=["$injector",function(a){return function(b){return a.get(b+"Filter")}}];b("currency",Qd);b("date",Rd);b("filter",Hg);b("json",Ig);b("limitTo",Jg);b("lowercase",Kg);b("number",Sd);b("orderBy",Td);b("uppercase",Lg)}function Hg(){return function(a,b,d,c){if(!xa(a)){if(null==a)return a;throw M("filter")("notarray",a);}c=
c||"$";var e;switch(Bc(b)){case "function":break;case "boolean":case "null":case "number":case "string":e=!0;case "object":b=Mg(b,d,c,e);break;default:return a}return Array.prototype.filter.call(a,b)}}function Mg(a,b,d,c){var e=E(a)&&d in a;!0===b?b=sa:A(b)||(b=function(a,b){if(w(a))return!1;if(null===a||null===b)return a===b;if(E(b)||E(a)&&!Zb(a))return!1;a=N(""+a);b=N(""+b);return-1!==a.indexOf(b)});return function(f){return e&&!E(f)?ga(f,a[d],b,d,!1):ga(f,a,b,d,c)}}function ga(a,b,d,c,e,f){var g=
Bc(a),k=Bc(b);if("string"===k&&"!"===b.charAt(0))return!ga(a,b.substring(1),d,c,e);if(I(a))return a.some(function(a){return ga(a,b,d,c,e)});switch(g){case "object":var h;if(e){for(h in a)if(h.charAt&&"$"!==h.charAt(0)&&ga(a[h],b,d,c,!0))return!0;return f?!1:ga(a,b,d,c,!1)}if("object"===k){for(h in b)if(f=b[h],!A(f)&&!w(f)&&(g=h===c,!ga(g?a:a[h],f,d,c,g,g)))return!1;return!0}return d(a,b);case "function":return!1;default:return d(a,b)}}function Bc(a){return null===a?"null":typeof a}function Qd(a){var b=
a.NUMBER_FORMATS;return function(a,c,e){w(c)&&(c=b.CURRENCY_SYM);w(e)&&(e=b.PATTERNS[1].maxFrac);return null==a?a:Ud(a,b.PATTERNS[1],b.GROUP_SEP,b.DECIMAL_SEP,e).replace(/\u00A4/g,c)}}function Sd(a){var b=a.NUMBER_FORMATS;return function(a,c){return null==a?a:Ud(a,b.PATTERNS[0],b.GROUP_SEP,b.DECIMAL_SEP,c)}}function Ng(a){var b=0,d,c,e,f,g;-1<(c=a.indexOf(Vd))&&(a=a.replace(Vd,""));0<(e=a.search(/e/i))?(0>c&&(c=e),c+=+a.slice(e+1),a=a.substring(0,e)):0>c&&(c=a.length);for(e=0;a.charAt(e)===Cc;e++);
if(e===(g=a.length))d=[0],c=1;else{for(g--;a.charAt(g)===Cc;)g--;c-=e;d=[];for(f=0;e<=g;e++,f++)d[f]=+a.charAt(e)}c>Wd&&(d=d.splice(0,Wd-1),b=c-1,c=1);return{d:d,e:b,i:c}}function Og(a,b,d,c){var e=a.d,f=e.length-a.i;b=w(b)?Math.min(Math.max(d,f),c):+b;d=b+a.i;c=e[d];if(0<d){e.splice(Math.max(a.i,d));for(var g=d;g<e.length;g++)e[g]=0}else for(f=Math.max(0,f),a.i=1,e.length=Math.max(1,d=b+1),e[0]=0,g=1;g<d;g++)e[g]=0;if(5<=c)if(0>d-1){for(c=0;c>d;c--)e.unshift(0),a.i++;e.unshift(1);a.i++}else e[d-
1]++;for(;f<Math.max(0,b);f++)e.push(0);if(b=e.reduceRight(function(a,b,c,d){b+=a;d[c]=b%10;return Math.floor(b/10)},0))e.unshift(b),a.i++}function Ud(a,b,d,c,e){if(!D(a)&&!Y(a)||isNaN(a))return"";var f=!isFinite(a),g=!1,k=Math.abs(a)+"",h="";if(f)h="\u221e";else{g=Ng(k);Og(g,e,b.minFrac,b.maxFrac);h=g.d;k=g.i;e=g.e;f=[];for(g=h.reduce(function(a,b){return a&&!b},!0);0>k;)h.unshift(0),k++;0<k?f=h.splice(k,h.length):(f=h,h=[0]);k=[];for(h.length>=b.lgSize&&k.unshift(h.splice(-b.lgSize,h.length).join(""));h.length>
b.gSize;)k.unshift(h.splice(-b.gSize,h.length).join(""));h.length&&k.unshift(h.join(""));h=k.join(d);f.length&&(h+=c+f.join(""));e&&(h+="e+"+e)}return 0>a&&!g?b.negPre+h+b.negSuf:b.posPre+h+b.posSuf}function Mb(a,b,d,c){var e="";if(0>a||c&&0>=a)c?a=-a+1:(a=-a,e="-");for(a=""+a;a.length<b;)a=Cc+a;d&&(a=a.substr(a.length-b));return e+a}function da(a,b,d,c,e){d=d||0;return function(f){f=f["get"+a]();if(0<d||f>-d)f+=d;0===f&&-12===d&&(f=12);return Mb(f,b,c,e)}}function ob(a,b,d){return function(c,e){var f=
c["get"+a](),g=wb((d?"STANDALONE":"")+(b?"SHORT":"")+a);return e[g][f]}}function Xd(a){var b=(new Date(a,0,1)).getDay();return new Date(a,0,(4>=b?5:12)-b)}function Yd(a){return function(b){var d=Xd(b.getFullYear());b=+new Date(b.getFullYear(),b.getMonth(),b.getDate()+(4-b.getDay()))-+d;b=1+Math.round(b/6048E5);return Mb(b,a)}}function Dc(a,b){return 0>=a.getFullYear()?b.ERAS[0]:b.ERAS[1]}function Rd(a){function b(a){var b;if(b=a.match(d)){a=new Date(0);var f=0,g=0,k=b[8]?a.setUTCFullYear:a.setFullYear,
h=b[8]?a.setUTCHours:a.setHours;b[9]&&(f=Z(b[9]+b[10]),g=Z(b[9]+b[11]));k.call(a,Z(b[1]),Z(b[2])-1,Z(b[3]));f=Z(b[4]||0)-f;g=Z(b[5]||0)-g;k=Z(b[6]||0);b=Math.round(1E3*parseFloat("0."+(b[7]||0)));h.call(a,f,g,k,b)}return a}var d=/^(\d{4})-?(\d\d)-?(\d\d)(?:T(\d\d)(?::?(\d\d)(?::?(\d\d)(?:\.(\d+))?)?)?(Z|([+-])(\d\d):?(\d\d))?)?$/;return function(c,d,f){var g="",k=[],h,l;d=d||"mediumDate";d=a.DATETIME_FORMATS[d]||d;D(c)&&(c=Pg.test(c)?Z(c):b(c));Y(c)&&(c=new Date(c));if(!ea(c)||!isFinite(c.getTime()))return c;
for(;d;)(l=Qg.exec(d))?(k=eb(k,l,1),d=k.pop()):(k.push(d),d=null);var m=c.getTimezoneOffset();f&&(m=Rc(f,m),c=bc(c,f,!0));p(k,function(b){h=Rg[b];g+=h?h(c,a.DATETIME_FORMATS,m):"''"===b?"'":b.replace(/(^'|'$)/g,"").replace(/''/g,"'")});return g}}function Ig(){return function(a,b){w(b)&&(b=2);return fb(a,b)}}function Jg(){return function(a,b,d){b=Infinity===Math.abs(Number(b))?Number(b):Z(b);if(T(b))return a;Y(a)&&(a=a.toString());if(!xa(a))return a;d=!d||isNaN(d)?0:Z(d);d=0>d?Math.max(0,a.length+
d):d;return 0<=b?Ec(a,d,d+b):0===d?Ec(a,b,a.length):Ec(a,Math.max(0,d+b),d)}}function Ec(a,b,d){return D(a)?a.slice(b,d):ya.call(a,b,d)}function Td(a){function b(b){return b.map(function(b){var c=1,d=bb;if(A(b))d=b;else if(D(b)){if("+"===b.charAt(0)||"-"===b.charAt(0))c="-"===b.charAt(0)?-1:1,b=b.substring(1);if(""!==b&&(d=a(b),d.constant))var e=d(),d=function(a){return a[e]}}return{get:d,descending:c}})}function d(a){switch(typeof a){case "number":case "boolean":case "string":return!0;default:return!1}}
function c(a,b){var c=0,d=a.type,h=b.type;if(d===h){var h=a.value,l=b.value;"string"===d?(h=h.toLowerCase(),l=l.toLowerCase()):"object"===d&&(E(h)&&(h=a.index),E(l)&&(l=b.index));h!==l&&(c=h<l?-1:1)}else c=d<h?-1:1;return c}return function(a,f,g,k){if(null==a)return a;if(!xa(a))throw M("orderBy")("notarray",a);I(f)||(f=[f]);0===f.length&&(f=["+"]);var h=b(f),l=g?-1:1,m=A(k)?k:c;a=Array.prototype.map.call(a,function(a,b){return{value:a,tieBreaker:{value:b,type:"number",index:b},predicateValues:h.map(function(c){var e=
c.get(a);c=typeof e;if(null===e)c="string",e="null";else if("object"===c)a:{if(A(e.valueOf)&&(e=e.valueOf(),d(e)))break a;Zb(e)&&(e=e.toString(),d(e))}return{value:e,type:c,index:b}})}});a.sort(function(a,b){for(var d=0,e=h.length;d<e;d++){var g=m(a.predicateValues[d],b.predicateValues[d]);if(g)return g*h[d].descending*l}return(m(a.tieBreaker,b.tieBreaker)||c(a.tieBreaker,b.tieBreaker))*l});return a=a.map(function(a){return a.value})}}function Qa(a){A(a)&&(a={link:a});a.restrict=a.restrict||"AC";
return ka(a)}function Nb(a,b,d,c,e){this.$$controls=[];this.$error={};this.$$success={};this.$pending=void 0;this.$name=e(b.name||b.ngForm||"")(d);this.$dirty=!1;this.$valid=this.$pristine=!0;this.$submitted=this.$invalid=!1;this.$$parentForm=Ob;this.$$element=a;this.$$animate=c;Zd(this)}function Zd(a){a.$$classCache={};a.$$classCache[$d]=!(a.$$classCache[pb]=a.$$element.hasClass(pb))}function ae(a){function b(a,b,c){c&&!a.$$classCache[b]?(a.$$animate.addClass(a.$$element,b),a.$$classCache[b]=!0):
!c&&a.$$classCache[b]&&(a.$$animate.removeClass(a.$$element,b),a.$$classCache[b]=!1)}function d(a,c,d){c=c?"-"+Vc(c,"-"):"";b(a,pb+c,!0===d);b(a,$d+c,!1===d)}var c=a.set,e=a.unset;a.clazz.prototype.$setValidity=function(a,g,k){w(g)?(this.$pending||(this.$pending={}),c(this.$pending,a,k)):(this.$pending&&e(this.$pending,a,k),be(this.$pending)&&(this.$pending=void 0));Na(g)?g?(e(this.$error,a,k),c(this.$$success,a,k)):(c(this.$error,a,k),e(this.$$success,a,k)):(e(this.$error,a,k),e(this.$$success,a,
k));this.$pending?(b(this,"ng-pending",!0),this.$valid=this.$invalid=void 0,d(this,"",null)):(b(this,"ng-pending",!1),this.$valid=be(this.$error),this.$invalid=!this.$valid,d(this,"",this.$valid));g=this.$pending&&this.$pending[a]?void 0:this.$error[a]?!1:this.$$success[a]?!0:null;d(this,a,g);this.$$parentForm.$setValidity(a,g,this)}}function be(a){if(a)for(var b in a)if(a.hasOwnProperty(b))return!1;return!0}function Fc(a){a.$formatters.push(function(b){return a.$isEmpty(b)?b:b.toString()})}function Wa(a,
b,d,c,e,f){var g=N(b[0].type);if(!e.android){var k=!1;b.on("compositionstart",function(){k=!0});b.on("compositionend",function(){k=!1;l()})}var h,l=function(a){h&&(f.defer.cancel(h),h=null);if(!k){var e=b.val();a=a&&a.type;"password"===g||d.ngTrim&&"false"===d.ngTrim||(e=Q(e));(c.$viewValue!==e||""===e&&c.$$hasNativeValidators)&&c.$setViewValue(e,a)}};if(e.hasEvent("input"))b.on("input",l);else{var m=function(a,b,c){h||(h=f.defer(function(){h=null;b&&b.value===c||l(a)}))};b.on("keydown",function(a){var b=
a.keyCode;91===b||15<b&&19>b||37<=b&&40>=b||m(a,this,this.value)});if(e.hasEvent("paste"))b.on("paste cut",m)}b.on("change",l);if(ce[g]&&c.$$hasNativeValidators&&g===d.type)b.on("keydown wheel mousedown",function(a){if(!h){var b=this.validity,c=b.badInput,d=b.typeMismatch;h=f.defer(function(){h=null;b.badInput===c&&b.typeMismatch===d||l(a)})}});c.$render=function(){var a=c.$isEmpty(c.$viewValue)?"":c.$viewValue;b.val()!==a&&b.val(a)}}function Pb(a,b){return function(d,c){var e,f;if(ea(d))return d;
if(D(d)){'"'===d.charAt(0)&&'"'===d.charAt(d.length-1)&&(d=d.substring(1,d.length-1));if(Sg.test(d))return new Date(d);a.lastIndex=0;if(e=a.exec(d))return e.shift(),f=c?{yyyy:c.getFullYear(),MM:c.getMonth()+1,dd:c.getDate(),HH:c.getHours(),mm:c.getMinutes(),ss:c.getSeconds(),sss:c.getMilliseconds()/1E3}:{yyyy:1970,MM:1,dd:1,HH:0,mm:0,ss:0,sss:0},p(e,function(a,c){c<b.length&&(f[b[c]]=+a)}),new Date(f.yyyy,f.MM-1,f.dd,f.HH,f.mm,f.ss||0,1E3*f.sss||0)}return NaN}}function qb(a,b,d,c){return function(e,
f,g,k,h,l,m){function n(a){return a&&!(a.getTime&&a.getTime()!==a.getTime())}function q(a){return t(a)&&!ea(a)?d(a)||void 0:a}Gc(e,f,g,k);Wa(e,f,g,k,h,l);var p=k&&k.$options.getOption("timezone"),r;k.$$parserName=a;k.$parsers.push(function(a){if(k.$isEmpty(a))return null;if(b.test(a))return a=d(a,r),p&&(a=bc(a,p)),a});k.$formatters.push(function(a){if(a&&!ea(a))throw rb("datefmt",a);if(n(a))return(r=a)&&p&&(r=bc(r,p,!0)),m("date")(a,c,p);r=null;return""});if(t(g.min)||g.ngMin){var z;k.$validators.min=
function(a){return!n(a)||w(z)||d(a)>=z};g.$observe("min",function(a){z=q(a);k.$validate()})}if(t(g.max)||g.ngMax){var v;k.$validators.max=function(a){return!n(a)||w(v)||d(a)<=v};g.$observe("max",function(a){v=q(a);k.$validate()})}}}function Gc(a,b,d,c){(c.$$hasNativeValidators=E(b[0].validity))&&c.$parsers.push(function(a){var c=b.prop("validity")||{};return c.badInput||c.typeMismatch?void 0:a})}function de(a){a.$$parserName="number";a.$parsers.push(function(b){if(a.$isEmpty(b))return null;if(Tg.test(b))return parseFloat(b)});
a.$formatters.push(function(b){if(!a.$isEmpty(b)){if(!Y(b))throw rb("numfmt",b);b=b.toString()}return b})}function Xa(a){t(a)&&!Y(a)&&(a=parseFloat(a));return T(a)?void 0:a}function Hc(a){var b=a.toString(),d=b.indexOf(".");return-1===d?-1<a&&1>a&&(a=/e-(\d+)$/.exec(b))?Number(a[1]):0:b.length-d-1}function ee(a,b,d){a=Number(a);var c=(a|0)!==a,e=(b|0)!==b,f=(d|0)!==d;if(c||e||f){var g=c?Hc(a):0,k=e?Hc(b):0,h=f?Hc(d):0,g=Math.max(g,k,h),g=Math.pow(10,g);a*=g;b*=g;d*=g;c&&(a=Math.round(a));e&&(b=Math.round(b));
f&&(d=Math.round(d))}return 0===(a-b)%d}function fe(a,b,d,c,e){if(t(c)){a=a(c);if(!a.constant)throw rb("constexpr",d,c);return a(b)}return e}function Ic(a,b){function d(a,b){if(!a||!a.length)return[];if(!b||!b.length)return a;var c=[],d=0;a:for(;d<a.length;d++){for(var e=a[d],f=0;f<b.length;f++)if(e===b[f])continue a;c.push(e)}return c}function c(a){var b=a;I(a)?b=a.map(c).join(" "):E(a)&&(b=Object.keys(a).filter(function(b){return a[b]}).join(" "));return b}function e(a){var b=a;if(I(a))b=a.map(e);
else if(E(a)){var c=!1,b=Object.keys(a).filter(function(b){b=a[b];!c&&w(b)&&(c=!0);return b});c&&b.push(void 0)}return b}a="ngClass"+a;var f;return["$parse",function(g){return{restrict:"AC",link:function(k,h,l){function m(a,b){var c=[];p(a,function(a){if(0<b||s[a])s[a]=(s[a]||0)+b,s[a]===+(0<b)&&c.push(a)});return c.join(" ")}function n(a){if(a===b){var c=w,c=m(c&&c.split(" "),1);l.$addClass(c)}else c=w,c=m(c&&c.split(" "),-1),l.$removeClass(c);u=a}function q(a){a=c(a);a!==w&&r(a)}function r(a){if(u===
b){var c=w&&w.split(" "),e=a&&a.split(" "),g=d(c,e),c=d(e,c),g=m(g,-1),c=m(c,1);l.$addClass(c);l.$removeClass(g)}w=a}var t=l[a].trim(),z=":"===t.charAt(0)&&":"===t.charAt(1),t=g(t,z?e:c),v=z?q:r,s=h.data("$classCounts"),u=!0,w;s||(s=S(),h.data("$classCounts",s));"ngClass"!==a&&(f||(f=g("$index",function(a){return a&1})),k.$watch(f,n));k.$watch(t,v,z)}}}]}function Qb(a,b,d,c,e,f,g,k,h){this.$modelValue=this.$viewValue=Number.NaN;this.$$rawModelValue=void 0;this.$validators={};this.$asyncValidators=
{};this.$parsers=[];this.$formatters=[];this.$viewChangeListeners=[];this.$untouched=!0;this.$touched=!1;this.$pristine=!0;this.$dirty=!1;this.$valid=!0;this.$invalid=!1;this.$error={};this.$$success={};this.$pending=void 0;this.$name=h(d.name||"",!1)(a);this.$$parentForm=Ob;this.$options=Rb;this.$$parsedNgModel=e(d.ngModel);this.$$parsedNgModelAssign=this.$$parsedNgModel.assign;this.$$ngModelGet=this.$$parsedNgModel;this.$$ngModelSet=this.$$parsedNgModelAssign;this.$$pendingDebounce=null;this.$$parserValid=
void 0;this.$$currentValidationRunId=0;Object.defineProperty(this,"$$scope",{value:a});this.$$attr=d;this.$$element=c;this.$$animate=f;this.$$timeout=g;this.$$parse=e;this.$$q=k;this.$$exceptionHandler=b;Zd(this);Ug(this)}function Ug(a){a.$$scope.$watch(function(b){b=a.$$ngModelGet(b);if(b!==a.$modelValue&&(a.$modelValue===a.$modelValue||b===b)){a.$modelValue=a.$$rawModelValue=b;a.$$parserValid=void 0;for(var d=a.$formatters,c=d.length,e=b;c--;)e=d[c](e);a.$viewValue!==e&&(a.$$updateEmptyClasses(e),
a.$viewValue=a.$$lastCommittedViewValue=e,a.$render(),a.$$runValidators(a.$modelValue,a.$viewValue,C))}return b})}function Jc(a){this.$$options=a}function ge(a,b){p(b,function(b,c){t(a[c])||(a[c]=b)})}function Ga(a,b){a.prop("selected",b);a.attr("selected",b)}var Lc={objectMaxDepth:5},Vg=/^\/(.+)\/([a-z]*)$/,ra=Object.prototype.hasOwnProperty,N=function(a){return D(a)?a.toLowerCase():a},wb=function(a){return D(a)?a.toUpperCase():a},Ca,B,la,ya=[].slice,ug=[].splice,Wg=[].push,ha=Object.prototype.toString,
Oc=Object.getPrototypeOf,qa=M("ng"),$=u.angular||(u.angular={}),ec,sb=0;Ca=u.document.documentMode;var T=Number.isNaN||function(a){return a!==a};C.$inject=[];bb.$inject=[];var I=Array.isArray,se=/^\[object (?:Uint8|Uint8Clamped|Uint16|Uint32|Int8|Int16|Int32|Float32|Float64)Array]$/,Q=function(a){return D(a)?a.trim():a},Md=function(a){return a.replace(/([-()[\]{}+?*.$^|,:#<!\\])/g,"\\$1").replace(/\x08/g,"\\x08")},Ja=function(){if(!t(Ja.rules)){var a=u.document.querySelector("[ng-csp]")||u.document.querySelector("[data-ng-csp]");
if(a){var b=a.getAttribute("ng-csp")||a.getAttribute("data-ng-csp");Ja.rules={noUnsafeEval:!b||-1!==b.indexOf("no-unsafe-eval"),noInlineStyle:!b||-1!==b.indexOf("no-inline-style")}}else{a=Ja;try{new Function(""),b=!1}catch(d){b=!0}a.rules={noUnsafeEval:b,noInlineStyle:!1}}}return Ja.rules},tb=function(){if(t(tb.name_))return tb.name_;var a,b,d=Ha.length,c,e;for(b=0;b<d;++b)if(c=Ha[b],a=u.document.querySelector("["+c.replace(":","\\:")+"jq]")){e=a.getAttribute(c+"jq");break}return tb.name_=e},ue=/:/g,
Ha=["ng-","data-ng-","ng:","x-ng-"],xe=function(a){var b=a.currentScript;if(!b)return!0;if(!(b instanceof u.HTMLScriptElement||b instanceof u.SVGScriptElement))return!1;b=b.attributes;return[b.getNamedItem("src"),b.getNamedItem("href"),b.getNamedItem("xlink:href")].every(function(b){if(!b)return!0;if(!b.value)return!1;var c=a.createElement("a");c.href=b.value;if(a.location.origin===c.origin)return!0;switch(c.protocol){case "http:":case "https:":case "ftp:":case "blob:":case "file:":case "data:":return!0;
default:return!1}})}(u.document),Ae=/[A-Z]/g,Wc=!1,Oa=3,Fe={full:"1.6.6",major:1,minor:6,dot:6,codeName:"interdimensional-cable"};U.expando="ng339";var kb=U.cache={},gg=1;U._data=function(a){return this.cache[a[this.expando]]||{}};var cg=/-([a-z])/g,Xg=/^-ms-/,Bb={mouseleave:"mouseout",mouseenter:"mouseover"},hc=M("jqLite"),fg=/^<([\w-]+)\s*\/?>(?:<\/\1>|)$/,gc=/<|&#?\w+;/,dg=/<([\w:-]+)/,eg=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:-]+)[^>]*)\/>/gi,aa={option:[1,'<select multiple="multiple">',
"</select>"],thead:[1,"<table>","</table>"],col:[2,"<table><colgroup>","</colgroup></table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_default:[0,"",""]};aa.optgroup=aa.option;aa.tbody=aa.tfoot=aa.colgroup=aa.caption=aa.thead;aa.th=aa.td;var lg=u.Node.prototype.contains||function(a){return!!(this.compareDocumentPosition(a)&16)},Sa=U.prototype={ready:gd,toString:function(){var a=[];p(this,function(b){a.push(""+b)});return"["+a.join(", ")+"]"},
eq:function(a){return 0<=a?B(this[a]):B(this[this.length+a])},length:0,push:Wg,sort:[].sort,splice:[].splice},Hb={};p("multiple selected checked disabled readOnly required open".split(" "),function(a){Hb[N(a)]=a});var ld={};p("input select option textarea button form details".split(" "),function(a){ld[a]=!0});var sd={ngMinlength:"minlength",ngMaxlength:"maxlength",ngMin:"min",ngMax:"max",ngPattern:"pattern",ngStep:"step"};p({data:lc,removeData:kc,hasData:function(a){for(var b in kb[a.ng339])return!0;
return!1},cleanData:function(a){for(var b=0,d=a.length;b<d;b++)kc(a[b])}},function(a,b){U[b]=a});p({data:lc,inheritedData:Fb,scope:function(a){return B.data(a,"$scope")||Fb(a.parentNode||a,["$isolateScope","$scope"])},isolateScope:function(a){return B.data(a,"$isolateScope")||B.data(a,"$isolateScopeNoTemplate")},controller:id,injector:function(a){return Fb(a,"$injector")},removeAttr:function(a,b){a.removeAttribute(b)},hasClass:Cb,css:function(a,b,d){b=yb(b.replace(Xg,"ms-"));if(t(d))a.style[b]=d;
else return a.style[b]},attr:function(a,b,d){var c=a.nodeType;if(c!==Oa&&2!==c&&8!==c&&a.getAttribute){var c=N(b),e=Hb[c];if(t(d))null===d||!1===d&&e?a.removeAttribute(b):a.setAttribute(b,e?c:d);else return a=a.getAttribute(b),e&&null!==a&&(a=c),null===a?void 0:a}},prop:function(a,b,d){if(t(d))a[b]=d;else return a[b]},text:function(){function a(a,d){if(w(d)){var c=a.nodeType;return 1===c||c===Oa?a.textContent:""}a.textContent=d}a.$dv="";return a}(),val:function(a,b){if(w(b)){if(a.multiple&&"select"===
za(a)){var d=[];p(a.options,function(a){a.selected&&d.push(a.value||a.text)});return d}return a.value}a.value=b},html:function(a,b){if(w(b))return a.innerHTML;zb(a,!0);a.innerHTML=b},empty:jd},function(a,b){U.prototype[b]=function(b,c){var e,f,g=this.length;if(a!==jd&&w(2===a.length&&a!==Cb&&a!==id?b:c)){if(E(b)){for(e=0;e<g;e++)if(a===lc)a(this[e],b);else for(f in b)a(this[e],f,b[f]);return this}e=a.$dv;g=w(e)?Math.min(g,1):g;for(f=0;f<g;f++){var k=a(this[f],b,c);e=e?e+k:k}return e}for(e=0;e<g;e++)a(this[e],
b,c);return this}});p({removeData:kc,on:function(a,b,d,c){if(t(c))throw hc("onargs");if(fc(a)){c=Ab(a,!0);var e=c.events,f=c.handle;f||(f=c.handle=ig(a,e));c=0<=b.indexOf(" ")?b.split(" "):[b];for(var g=c.length,k=function(b,c,g){var k=e[b];k||(k=e[b]=[],k.specialHandlerWrapper=c,"$destroy"===b||g||a.addEventListener(b,f));k.push(d)};g--;)b=c[g],Bb[b]?(k(Bb[b],kg),k(b,void 0,!0)):k(b)}},off:hd,one:function(a,b,d){a=B(a);a.on(b,function e(){a.off(b,d);a.off(b,e)});a.on(b,d)},replaceWith:function(a,
b){var d,c=a.parentNode;zb(a);p(new U(b),function(b){d?c.insertBefore(b,d.nextSibling):c.replaceChild(b,a);d=b})},children:function(a){var b=[];p(a.childNodes,function(a){1===a.nodeType&&b.push(a)});return b},contents:function(a){return a.contentDocument||a.childNodes||[]},append:function(a,b){var d=a.nodeType;if(1===d||11===d){b=new U(b);for(var d=0,c=b.length;d<c;d++)a.appendChild(b[d])}},prepend:function(a,b){if(1===a.nodeType){var d=a.firstChild;p(new U(b),function(b){a.insertBefore(b,d)})}},
wrap:function(a,b){var d=B(b).eq(0).clone()[0],c=a.parentNode;c&&c.replaceChild(d,a);d.appendChild(a)},remove:Gb,detach:function(a){Gb(a,!0)},after:function(a,b){var d=a,c=a.parentNode;if(c){b=new U(b);for(var e=0,f=b.length;e<f;e++){var g=b[e];c.insertBefore(g,d.nextSibling);d=g}}},addClass:Eb,removeClass:Db,toggleClass:function(a,b,d){b&&p(b.split(" "),function(b){var e=d;w(e)&&(e=!Cb(a,b));(e?Eb:Db)(a,b)})},parent:function(a){return(a=a.parentNode)&&11!==a.nodeType?a:null},next:function(a){return a.nextElementSibling},
find:function(a,b){return a.getElementsByTagName?a.getElementsByTagName(b):[]},clone:jc,triggerHandler:function(a,b,d){var c,e,f=b.type||b,g=Ab(a);if(g=(g=g&&g.events)&&g[f])c={preventDefault:function(){this.defaultPrevented=!0},isDefaultPrevented:function(){return!0===this.defaultPrevented},stopImmediatePropagation:function(){this.immediatePropagationStopped=!0},isImmediatePropagationStopped:function(){return!0===this.immediatePropagationStopped},stopPropagation:C,type:f,target:a},b.type&&(c=P(c,
b)),b=ja(g),e=d?[c].concat(d):[c],p(b,function(b){c.isImmediatePropagationStopped()||b.apply(a,e)})}},function(a,b){U.prototype[b]=function(b,c,e){for(var f,g=0,k=this.length;g<k;g++)w(f)?(f=a(this[g],b,c,e),t(f)&&(f=B(f))):ic(f,a(this[g],b,c,e));return t(f)?f:this}});U.prototype.bind=U.prototype.on;U.prototype.unbind=U.prototype.off;var Yg=Object.create(null);md.prototype={_idx:function(a){if(a===this._lastKey)return this._lastIndex;this._lastKey=a;return this._lastIndex=this._keys.indexOf(a)},_transformKey:function(a){return T(a)?
Yg:a},get:function(a){a=this._transformKey(a);a=this._idx(a);if(-1!==a)return this._values[a]},set:function(a,b){a=this._transformKey(a);var d=this._idx(a);-1===d&&(d=this._lastIndex=this._keys.length);this._keys[d]=a;this._values[d]=b},delete:function(a){a=this._transformKey(a);a=this._idx(a);if(-1===a)return!1;this._keys.splice(a,1);this._values.splice(a,1);this._lastKey=NaN;this._lastIndex=-1;return!0}};var Ib=md,ag=[function(){this.$get=[function(){return Ib}]}],ng=/^([^(]+?)=>/,og=/^[^(]*\(\s*([^)]*)\)/m,
Zg=/,/,$g=/^\s*(_?)(\S+?)\1\s*$/,mg=/((\/\/.*$)|(\/\*[\s\S]*?\*\/))/mg,Ba=M("$injector");hb.$$annotate=function(a,b,d){var c;if("function"===typeof a){if(!(c=a.$inject)){c=[];if(a.length){if(b)throw D(d)&&d||(d=a.name||pg(a)),Ba("strictdi",d);b=nd(a);p(b[1].split(Zg),function(a){a.replace($g,function(a,b,d){c.push(d)})})}a.$inject=c}}else I(a)?(b=a.length-1,ub(a[b],"fn"),c=a.slice(0,b)):ub(a,"fn",!0);return c};var he=M("$animate"),sf=function(){this.$get=C},tf=function(){var a=new Ib,b=[];this.$get=
["$$AnimateRunner","$rootScope",function(d,c){function e(a,b,c){var d=!1;b&&(b=D(b)?b.split(" "):I(b)?b:[],p(b,function(b){b&&(d=!0,a[b]=c)}));return d}function f(){p(b,function(b){var c=a.get(b);if(c){var d=qg(b.attr("class")),e="",f="";p(c,function(a,b){a!==!!d[b]&&(a?e+=(e.length?" ":"")+b:f+=(f.length?" ":"")+b)});p(b,function(a){e&&Eb(a,e);f&&Db(a,f)});a.delete(b)}});b.length=0}return{enabled:C,on:C,off:C,pin:C,push:function(g,k,h,l){l&&l();h=h||{};h.from&&g.css(h.from);h.to&&g.css(h.to);if(h.addClass||
h.removeClass)if(k=h.addClass,l=h.removeClass,h=a.get(g)||{},k=e(h,k,!0),l=e(h,l,!1),k||l)a.set(g,h),b.push(g),1===b.length&&c.$$postDigest(f);g=new d;g.complete();return g}}}]},qf=["$provide",function(a){var b=this,d=null,c=null;this.$$registeredAnimations=Object.create(null);this.register=function(c,d){if(c&&"."!==c.charAt(0))throw he("notcsel",c);var g=c+"-animation";b.$$registeredAnimations[c.substr(1)]=g;a.factory(g,d)};this.customFilter=function(a){1===arguments.length&&(c=A(a)?a:null);return c};
this.classNameFilter=function(a){if(1===arguments.length&&(d=a instanceof RegExp?a:null)&&/[(\s|\/)]ng-animate[(\s|\/)]/.test(d.toString()))throw d=null,he("nongcls","ng-animate");return d};this.$get=["$$animateQueue",function(a){function b(a,c,d){if(d){var e;a:{for(e=0;e<d.length;e++){var f=d[e];if(1===f.nodeType){e=f;break a}}e=void 0}!e||e.parentNode||e.previousElementSibling||(d=null)}d?d.after(a):c.prepend(a)}return{on:a.on,off:a.off,pin:a.pin,enabled:a.enabled,cancel:function(a){a.end&&a.end()},
enter:function(c,d,h,l){d=d&&B(d);h=h&&B(h);d=d||h.parent();b(c,d,h);return a.push(c,"enter",Ka(l))},move:function(c,d,h,l){d=d&&B(d);h=h&&B(h);d=d||h.parent();b(c,d,h);return a.push(c,"move",Ka(l))},leave:function(b,c){return a.push(b,"leave",Ka(c),function(){b.remove()})},addClass:function(b,c,d){d=Ka(d);d.addClass=lb(d.addclass,c);return a.push(b,"addClass",d)},removeClass:function(b,c,d){d=Ka(d);d.removeClass=lb(d.removeClass,c);return a.push(b,"removeClass",d)},setClass:function(b,c,d,f){f=Ka(f);
f.addClass=lb(f.addClass,c);f.removeClass=lb(f.removeClass,d);return a.push(b,"setClass",f)},animate:function(b,c,d,f,m){m=Ka(m);m.from=m.from?P(m.from,c):c;m.to=m.to?P(m.to,d):d;m.tempClasses=lb(m.tempClasses,f||"ng-inline-animate");return a.push(b,"animate",m)}}}]}],vf=function(){this.$get=["$$rAF",function(a){function b(b){d.push(b);1<d.length||a(function(){for(var a=0;a<d.length;a++)d[a]();d=[]})}var d=[];return function(){var a=!1;b(function(){a=!0});return function(d){a?d():b(d)}}}]},uf=function(){this.$get=
["$q","$sniffer","$$animateAsyncRun","$$isDocumentHidden","$timeout",function(a,b,d,c,e){function f(a){this.setHost(a);var b=d();this._doneCallbacks=[];this._tick=function(a){c()?e(a,0,!1):b(a)};this._state=0}f.chain=function(a,b){function c(){if(d===a.length)b(!0);else a[d](function(a){!1===a?b(!1):(d++,c())})}var d=0;c()};f.all=function(a,b){function c(f){e=e&&f;++d===a.length&&b(e)}var d=0,e=!0;p(a,function(a){a.done(c)})};f.prototype={setHost:function(a){this.host=a||{}},done:function(a){2===
this._state?a():this._doneCallbacks.push(a)},progress:C,getPromise:function(){if(!this.promise){var b=this;this.promise=a(function(a,c){b.done(function(b){!1===b?c():a()})})}return this.promise},then:function(a,b){return this.getPromise().then(a,b)},"catch":function(a){return this.getPromise()["catch"](a)},"finally":function(a){return this.getPromise()["finally"](a)},pause:function(){this.host.pause&&this.host.pause()},resume:function(){this.host.resume&&this.host.resume()},end:function(){this.host.end&&
this.host.end();this._resolve(!0)},cancel:function(){this.host.cancel&&this.host.cancel();this._resolve(!1)},complete:function(a){var b=this;0===b._state&&(b._state=1,b._tick(function(){b._resolve(a)}))},_resolve:function(a){2!==this._state&&(p(this._doneCallbacks,function(b){b(a)}),this._doneCallbacks.length=0,this._state=2)}};return f}]},rf=function(){this.$get=["$$rAF","$q","$$AnimateRunner",function(a,b,d){return function(b,e){function f(){a(function(){g.addClass&&(b.addClass(g.addClass),g.addClass=
null);g.removeClass&&(b.removeClass(g.removeClass),g.removeClass=null);g.to&&(b.css(g.to),g.to=null);k||h.complete();k=!0});return h}var g=e||{};g.$$prepared||(g=pa(g));g.cleanupStyles&&(g.from=g.to=null);g.from&&(b.css(g.from),g.from=null);var k,h=new d;return{start:f,end:f}}}]},ba=M("$compile"),oc=new function(){};Yc.$inject=["$provide","$$sanitizeUriProvider"];Kb.prototype.isFirstChange=function(){return this.previousValue===oc};var od=/^((?:x|data)[:\-_])/i,tg=/[:\-_]+(.)/g,ud=M("$controller"),
td=/^(\S+)(\s+as\s+([\w$]+))?$/,Cf=function(){this.$get=["$document",function(a){return function(b){b?!b.nodeType&&b instanceof B&&(b=b[0]):b=a[0].body;return b.offsetWidth+1}}]},vd="application/json",sc={"Content-Type":vd+";charset=utf-8"},wg=/^\[|^\{(?!\{)/,xg={"[":/]$/,"{":/}$/},vg=/^\)]\}',?\n/,rc=M("$http"),Fa=$.$interpolateMinErr=M("$interpolate");Fa.throwNoconcat=function(a){throw Fa("noconcat",a);};Fa.interr=function(a,b){return Fa("interr",a,b.toString())};var Kf=function(){this.$get=function(){function a(a){var b=
function(a){b.data=a;b.called=!0};b.id=a;return b}var b=$.callbacks,d={};return{createCallback:function(c){c="_"+(b.$$counter++).toString(36);var e="angular.callbacks."+c,f=a(c);d[e]=b[c]=f;return e},wasCalled:function(a){return d[a].called},getResponse:function(a){return d[a].data},removeCallback:function(a){delete b[d[a].id];delete d[a]}}}},ah=/^([^?#]*)(\?([^#]*))?(#(.*))?$/,zg={http:80,https:443,ftp:21},mb=M("$location"),Ag=/^\s*[\\/]{2,}/,bh={$$absUrl:"",$$html5:!1,$$replace:!1,absUrl:Lb("$$absUrl"),
url:function(a){if(w(a))return this.$$url;var b=ah.exec(a);(b[1]||""===a)&&this.path(decodeURIComponent(b[1]));(b[2]||b[1]||""===a)&&this.search(b[3]||"");this.hash(b[5]||"");return this},protocol:Lb("$$protocol"),host:Lb("$$host"),port:Lb("$$port"),path:Dd("$$path",function(a){a=null!==a?a.toString():"";return"/"===a.charAt(0)?a:"/"+a}),search:function(a,b){switch(arguments.length){case 0:return this.$$search;case 1:if(D(a)||Y(a))a=a.toString(),this.$$search=Tc(a);else if(E(a))a=pa(a,{}),p(a,function(b,
c){null==b&&delete a[c]}),this.$$search=a;else throw mb("isrcharg");break;default:w(b)||null===b?delete this.$$search[a]:this.$$search[a]=b}this.$$compose();return this},hash:Dd("$$hash",function(a){return null!==a?a.toString():""}),replace:function(){this.$$replace=!0;return this}};p([Cd,wc,vc],function(a){a.prototype=Object.create(bh);a.prototype.state=function(b){if(!arguments.length)return this.$$state;if(a!==vc||!this.$$html5)throw mb("nostate");this.$$state=w(b)?null:b;this.$$urlUpdatedByLocation=
!0;return this}});var Ya=M("$parse"),Eg={}.constructor.prototype.valueOf,Sb=S();p("+ - * / % === !== == != < > <= >= && || ! = |".split(" "),function(a){Sb[a]=!0});var ch={n:"\n",f:"\f",r:"\r",t:"\t",v:"\v","'":"'",'"':'"'},zc=function(a){this.options=a};zc.prototype={constructor:zc,lex:function(a){this.text=a;this.index=0;for(this.tokens=[];this.index<this.text.length;)if(a=this.text.charAt(this.index),'"'===a||"'"===a)this.readString(a);else if(this.isNumber(a)||"."===a&&this.isNumber(this.peek()))this.readNumber();
else if(this.isIdentifierStart(this.peekMultichar()))this.readIdent();else if(this.is(a,"(){}[].,;:?"))this.tokens.push({index:this.index,text:a}),this.index++;else if(this.isWhitespace(a))this.index++;else{var b=a+this.peek(),d=b+this.peek(2),c=Sb[b],e=Sb[d];Sb[a]||c||e?(a=e?d:c?b:a,this.tokens.push({index:this.index,text:a,operator:!0}),this.index+=a.length):this.throwError("Unexpected next character ",this.index,this.index+1)}return this.tokens},is:function(a,b){return-1!==b.indexOf(a)},peek:function(a){a=
a||1;return this.index+a<this.text.length?this.text.charAt(this.index+a):!1},isNumber:function(a){return"0"<=a&&"9">=a&&"string"===typeof a},isWhitespace:function(a){return" "===a||"\r"===a||"\t"===a||"\n"===a||"\v"===a||"\u00a0"===a},isIdentifierStart:function(a){return this.options.isIdentifierStart?this.options.isIdentifierStart(a,this.codePointAt(a)):this.isValidIdentifierStart(a)},isValidIdentifierStart:function(a){return"a"<=a&&"z">=a||"A"<=a&&"Z">=a||"_"===a||"$"===a},isIdentifierContinue:function(a){return this.options.isIdentifierContinue?
this.options.isIdentifierContinue(a,this.codePointAt(a)):this.isValidIdentifierContinue(a)},isValidIdentifierContinue:function(a,b){return this.isValidIdentifierStart(a,b)||this.isNumber(a)},codePointAt:function(a){return 1===a.length?a.charCodeAt(0):(a.charCodeAt(0)<<10)+a.charCodeAt(1)-56613888},peekMultichar:function(){var a=this.text.charAt(this.index),b=this.peek();if(!b)return a;var d=a.charCodeAt(0),c=b.charCodeAt(0);return 55296<=d&&56319>=d&&56320<=c&&57343>=c?a+b:a},isExpOperator:function(a){return"-"===
a||"+"===a||this.isNumber(a)},throwError:function(a,b,d){d=d||this.index;b=t(b)?"s "+b+"-"+this.index+" ["+this.text.substring(b,d)+"]":" "+d;throw Ya("lexerr",a,b,this.text);},readNumber:function(){for(var a="",b=this.index;this.index<this.text.length;){var d=N(this.text.charAt(this.index));if("."===d||this.isNumber(d))a+=d;else{var c=this.peek();if("e"===d&&this.isExpOperator(c))a+=d;else if(this.isExpOperator(d)&&c&&this.isNumber(c)&&"e"===a.charAt(a.length-1))a+=d;else if(!this.isExpOperator(d)||
c&&this.isNumber(c)||"e"!==a.charAt(a.length-1))break;else this.throwError("Invalid exponent")}this.index++}this.tokens.push({index:b,text:a,constant:!0,value:Number(a)})},readIdent:function(){var a=this.index;for(this.index+=this.peekMultichar().length;this.index<this.text.length;){var b=this.peekMultichar();if(!this.isIdentifierContinue(b))break;this.index+=b.length}this.tokens.push({index:a,text:this.text.slice(a,this.index),identifier:!0})},readString:function(a){var b=this.index;this.index++;
for(var d="",c=a,e=!1;this.index<this.text.length;){var f=this.text.charAt(this.index),c=c+f;if(e)"u"===f?(e=this.text.substring(this.index+1,this.index+5),e.match(/[\da-f]{4}/i)||this.throwError("Invalid unicode escape [\\u"+e+"]"),this.index+=4,d+=String.fromCharCode(parseInt(e,16))):d+=ch[f]||f,e=!1;else if("\\"===f)e=!0;else{if(f===a){this.index++;this.tokens.push({index:b,text:c,constant:!0,value:d});return}d+=f}this.index++}this.throwError("Unterminated quote",b)}};var r=function(a,b){this.lexer=
a;this.options=b};r.Program="Program";r.ExpressionStatement="ExpressionStatement";r.AssignmentExpression="AssignmentExpression";r.ConditionalExpression="ConditionalExpression";r.LogicalExpression="LogicalExpression";r.BinaryExpression="BinaryExpression";r.UnaryExpression="UnaryExpression";r.CallExpression="CallExpression";r.MemberExpression="MemberExpression";r.Identifier="Identifier";r.Literal="Literal";r.ArrayExpression="ArrayExpression";r.Property="Property";r.ObjectExpression="ObjectExpression";
r.ThisExpression="ThisExpression";r.LocalsExpression="LocalsExpression";r.NGValueParameter="NGValueParameter";r.prototype={ast:function(a){this.text=a;this.tokens=this.lexer.lex(a);a=this.program();0!==this.tokens.length&&this.throwError("is an unexpected token",this.tokens[0]);return a},program:function(){for(var a=[];;)if(0<this.tokens.length&&!this.peek("}",")",";","]")&&a.push(this.expressionStatement()),!this.expect(";"))return{type:r.Program,body:a}},expressionStatement:function(){return{type:r.ExpressionStatement,
expression:this.filterChain()}},filterChain:function(){for(var a=this.expression();this.expect("|");)a=this.filter(a);return a},expression:function(){return this.assignment()},assignment:function(){var a=this.ternary();if(this.expect("=")){if(!Hd(a))throw Ya("lval");a={type:r.AssignmentExpression,left:a,right:this.assignment(),operator:"="}}return a},ternary:function(){var a=this.logicalOR(),b,d;return this.expect("?")&&(b=this.expression(),this.consume(":"))?(d=this.expression(),{type:r.ConditionalExpression,
test:a,alternate:b,consequent:d}):a},logicalOR:function(){for(var a=this.logicalAND();this.expect("||");)a={type:r.LogicalExpression,operator:"||",left:a,right:this.logicalAND()};return a},logicalAND:function(){for(var a=this.equality();this.expect("&&");)a={type:r.LogicalExpression,operator:"&&",left:a,right:this.equality()};return a},equality:function(){for(var a=this.relational(),b;b=this.expect("==","!=","===","!==");)a={type:r.BinaryExpression,operator:b.text,left:a,right:this.relational()};
return a},relational:function(){for(var a=this.additive(),b;b=this.expect("<",">","<=",">=");)a={type:r.BinaryExpression,operator:b.text,left:a,right:this.additive()};return a},additive:function(){for(var a=this.multiplicative(),b;b=this.expect("+","-");)a={type:r.BinaryExpression,operator:b.text,left:a,right:this.multiplicative()};return a},multiplicative:function(){for(var a=this.unary(),b;b=this.expect("*","/","%");)a={type:r.BinaryExpression,operator:b.text,left:a,right:this.unary()};return a},
unary:function(){var a;return(a=this.expect("+","-","!"))?{type:r.UnaryExpression,operator:a.text,prefix:!0,argument:this.unary()}:this.primary()},primary:function(){var a;this.expect("(")?(a=this.filterChain(),this.consume(")")):this.expect("[")?a=this.arrayDeclaration():this.expect("{")?a=this.object():this.selfReferential.hasOwnProperty(this.peek().text)?a=pa(this.selfReferential[this.consume().text]):this.options.literals.hasOwnProperty(this.peek().text)?a={type:r.Literal,value:this.options.literals[this.consume().text]}:
this.peek().identifier?a=this.identifier():this.peek().constant?a=this.constant():this.throwError("not a primary expression",this.peek());for(var b;b=this.expect("(","[",".");)"("===b.text?(a={type:r.CallExpression,callee:a,arguments:this.parseArguments()},this.consume(")")):"["===b.text?(a={type:r.MemberExpression,object:a,property:this.expression(),computed:!0},this.consume("]")):"."===b.text?a={type:r.MemberExpression,object:a,property:this.identifier(),computed:!1}:this.throwError("IMPOSSIBLE");
return a},filter:function(a){a=[a];for(var b={type:r.CallExpression,callee:this.identifier(),arguments:a,filter:!0};this.expect(":");)a.push(this.expression());return b},parseArguments:function(){var a=[];if(")"!==this.peekToken().text){do a.push(this.filterChain());while(this.expect(","))}return a},identifier:function(){var a=this.consume();a.identifier||this.throwError("is not a valid identifier",a);return{type:r.Identifier,name:a.text}},constant:function(){return{type:r.Literal,value:this.consume().value}},
arrayDeclaration:function(){var a=[];if("]"!==this.peekToken().text){do{if(this.peek("]"))break;a.push(this.expression())}while(this.expect(","))}this.consume("]");return{type:r.ArrayExpression,elements:a}},object:function(){var a=[],b;if("}"!==this.peekToken().text){do{if(this.peek("}"))break;b={type:r.Property,kind:"init"};this.peek().constant?(b.key=this.constant(),b.computed=!1,this.consume(":"),b.value=this.expression()):this.peek().identifier?(b.key=this.identifier(),b.computed=!1,this.peek(":")?
(this.consume(":"),b.value=this.expression()):b.value=b.key):this.peek("[")?(this.consume("["),b.key=this.expression(),this.consume("]"),b.computed=!0,this.consume(":"),b.value=this.expression()):this.throwError("invalid key",this.peek());a.push(b)}while(this.expect(","))}this.consume("}");return{type:r.ObjectExpression,properties:a}},throwError:function(a,b){throw Ya("syntax",b.text,a,b.index+1,this.text,this.text.substring(b.index));},consume:function(a){if(0===this.tokens.length)throw Ya("ueoe",
this.text);var b=this.expect(a);b||this.throwError("is unexpected, expecting ["+a+"]",this.peek());return b},peekToken:function(){if(0===this.tokens.length)throw Ya("ueoe",this.text);return this.tokens[0]},peek:function(a,b,d,c){return this.peekAhead(0,a,b,d,c)},peekAhead:function(a,b,d,c,e){if(this.tokens.length>a){a=this.tokens[a];var f=a.text;if(f===b||f===d||f===c||f===e||!(b||d||c||e))return a}return!1},expect:function(a,b,d,c){return(a=this.peek(a,b,d,c))?(this.tokens.shift(),a):!1},selfReferential:{"this":{type:r.ThisExpression},
$locals:{type:r.LocalsExpression}}};var Fd=2;Jd.prototype={compile:function(a){var b=this;this.state={nextId:0,filters:{},fn:{vars:[],body:[],own:{}},assign:{vars:[],body:[],own:{}},inputs:[]};V(a,b.$filter);var d="",c;this.stage="assign";if(c=Id(a))this.state.computing="assign",d=this.nextId(),this.recurse(c,d),this.return_(d),d="fn.assign="+this.generateFunction("assign","s,v,l");c=Gd(a.body);b.stage="inputs";p(c,function(a,c){var d="fn"+c;b.state[d]={vars:[],body:[],own:{}};b.state.computing=d;
var k=b.nextId();b.recurse(a,k);b.return_(k);b.state.inputs.push({name:d,isPure:a.isPure});a.watchId=c});this.state.computing="fn";this.stage="main";this.recurse(a);a='"'+this.USE+" "+this.STRICT+'";\n'+this.filterPrefix()+"var fn="+this.generateFunction("fn","s,l,a,i")+d+this.watchFns()+"return fn;";a=(new Function("$filter","getStringValue","ifDefined","plus",a))(this.$filter,Bg,Cg,Ed);this.state=this.stage=void 0;return a},USE:"use",STRICT:"strict",watchFns:function(){var a=[],b=this.state.inputs,
d=this;p(b,function(b){a.push("var "+b.name+"="+d.generateFunction(b.name,"s"));b.isPure&&a.push(b.name,".isPure="+JSON.stringify(b.isPure)+";")});b.length&&a.push("fn.inputs=["+b.map(function(a){return a.name}).join(",")+"];");return a.join("")},generateFunction:function(a,b){return"function("+b+"){"+this.varsPrefix(a)+this.body(a)+"};"},filterPrefix:function(){var a=[],b=this;p(this.state.filters,function(d,c){a.push(d+"=$filter("+b.escape(c)+")")});return a.length?"var "+a.join(",")+";":""},varsPrefix:function(a){return this.state[a].vars.length?
"var "+this.state[a].vars.join(",")+";":""},body:function(a){return this.state[a].body.join("")},recurse:function(a,b,d,c,e,f){var g,k,h=this,l,m,n;c=c||C;if(!f&&t(a.watchId))b=b||this.nextId(),this.if_("i",this.lazyAssign(b,this.computedMember("i",a.watchId)),this.lazyRecurse(a,b,d,c,e,!0));else switch(a.type){case r.Program:p(a.body,function(b,c){h.recurse(b.expression,void 0,void 0,function(a){k=a});c!==a.body.length-1?h.current().body.push(k,";"):h.return_(k)});break;case r.Literal:m=this.escape(a.value);
this.assign(b,m);c(b||m);break;case r.UnaryExpression:this.recurse(a.argument,void 0,void 0,function(a){k=a});m=a.operator+"("+this.ifDefined(k,0)+")";this.assign(b,m);c(m);break;case r.BinaryExpression:this.recurse(a.left,void 0,void 0,function(a){g=a});this.recurse(a.right,void 0,void 0,function(a){k=a});m="+"===a.operator?this.plus(g,k):"-"===a.operator?this.ifDefined(g,0)+a.operator+this.ifDefined(k,0):"("+g+")"+a.operator+"("+k+")";this.assign(b,m);c(m);break;case r.LogicalExpression:b=b||this.nextId();
h.recurse(a.left,b);h.if_("&&"===a.operator?b:h.not(b),h.lazyRecurse(a.right,b));c(b);break;case r.ConditionalExpression:b=b||this.nextId();h.recurse(a.test,b);h.if_(b,h.lazyRecurse(a.alternate,b),h.lazyRecurse(a.consequent,b));c(b);break;case r.Identifier:b=b||this.nextId();d&&(d.context="inputs"===h.stage?"s":this.assign(this.nextId(),this.getHasOwnProperty("l",a.name)+"?l:s"),d.computed=!1,d.name=a.name);h.if_("inputs"===h.stage||h.not(h.getHasOwnProperty("l",a.name)),function(){h.if_("inputs"===
h.stage||"s",function(){e&&1!==e&&h.if_(h.isNull(h.nonComputedMember("s",a.name)),h.lazyAssign(h.nonComputedMember("s",a.name),"{}"));h.assign(b,h.nonComputedMember("s",a.name))})},b&&h.lazyAssign(b,h.nonComputedMember("l",a.name)));c(b);break;case r.MemberExpression:g=d&&(d.context=this.nextId())||this.nextId();b=b||this.nextId();h.recurse(a.object,g,void 0,function(){h.if_(h.notNull(g),function(){a.computed?(k=h.nextId(),h.recurse(a.property,k),h.getStringValue(k),e&&1!==e&&h.if_(h.not(h.computedMember(g,
k)),h.lazyAssign(h.computedMember(g,k),"{}")),m=h.computedMember(g,k),h.assign(b,m),d&&(d.computed=!0,d.name=k)):(e&&1!==e&&h.if_(h.isNull(h.nonComputedMember(g,a.property.name)),h.lazyAssign(h.nonComputedMember(g,a.property.name),"{}")),m=h.nonComputedMember(g,a.property.name),h.assign(b,m),d&&(d.computed=!1,d.name=a.property.name))},function(){h.assign(b,"undefined")});c(b)},!!e);break;case r.CallExpression:b=b||this.nextId();a.filter?(k=h.filter(a.callee.name),l=[],p(a.arguments,function(a){var b=
h.nextId();h.recurse(a,b);l.push(b)}),m=k+"("+l.join(",")+")",h.assign(b,m),c(b)):(k=h.nextId(),g={},l=[],h.recurse(a.callee,k,g,function(){h.if_(h.notNull(k),function(){p(a.arguments,function(b){h.recurse(b,a.constant?void 0:h.nextId(),void 0,function(a){l.push(a)})});m=g.name?h.member(g.context,g.name,g.computed)+"("+l.join(",")+")":k+"("+l.join(",")+")";h.assign(b,m)},function(){h.assign(b,"undefined")});c(b)}));break;case r.AssignmentExpression:k=this.nextId();g={};this.recurse(a.left,void 0,
g,function(){h.if_(h.notNull(g.context),function(){h.recurse(a.right,k);m=h.member(g.context,g.name,g.computed)+a.operator+k;h.assign(b,m);c(b||m)})},1);break;case r.ArrayExpression:l=[];p(a.elements,function(b){h.recurse(b,a.constant?void 0:h.nextId(),void 0,function(a){l.push(a)})});m="["+l.join(",")+"]";this.assign(b,m);c(b||m);break;case r.ObjectExpression:l=[];n=!1;p(a.properties,function(a){a.computed&&(n=!0)});n?(b=b||this.nextId(),this.assign(b,"{}"),p(a.properties,function(a){a.computed?
(g=h.nextId(),h.recurse(a.key,g)):g=a.key.type===r.Identifier?a.key.name:""+a.key.value;k=h.nextId();h.recurse(a.value,k);h.assign(h.member(b,g,a.computed),k)})):(p(a.properties,function(b){h.recurse(b.value,a.constant?void 0:h.nextId(),void 0,function(a){l.push(h.escape(b.key.type===r.Identifier?b.key.name:""+b.key.value)+":"+a)})}),m="{"+l.join(",")+"}",this.assign(b,m));c(b||m);break;case r.ThisExpression:this.assign(b,"s");c(b||"s");break;case r.LocalsExpression:this.assign(b,"l");c(b||"l");break;
case r.NGValueParameter:this.assign(b,"v"),c(b||"v")}},getHasOwnProperty:function(a,b){var d=a+"."+b,c=this.current().own;c.hasOwnProperty(d)||(c[d]=this.nextId(!1,a+"&&("+this.escape(b)+" in "+a+")"));return c[d]},assign:function(a,b){if(a)return this.current().body.push(a,"=",b,";"),a},filter:function(a){this.state.filters.hasOwnProperty(a)||(this.state.filters[a]=this.nextId(!0));return this.state.filters[a]},ifDefined:function(a,b){return"ifDefined("+a+","+this.escape(b)+")"},plus:function(a,
b){return"plus("+a+","+b+")"},return_:function(a){this.current().body.push("return ",a,";")},if_:function(a,b,d){if(!0===a)b();else{var c=this.current().body;c.push("if(",a,"){");b();c.push("}");d&&(c.push("else{"),d(),c.push("}"))}},not:function(a){return"!("+a+")"},isNull:function(a){return a+"==null"},notNull:function(a){return a+"!=null"},nonComputedMember:function(a,b){var d=/[^$_a-zA-Z0-9]/g;return/^[$_a-zA-Z][$_a-zA-Z0-9]*$/.test(b)?a+"."+b:a+'["'+b.replace(d,this.stringEscapeFn)+'"]'},computedMember:function(a,
b){return a+"["+b+"]"},member:function(a,b,d){return d?this.computedMember(a,b):this.nonComputedMember(a,b)},getStringValue:function(a){this.assign(a,"getStringValue("+a+")")},lazyRecurse:function(a,b,d,c,e,f){var g=this;return function(){g.recurse(a,b,d,c,e,f)}},lazyAssign:function(a,b){var d=this;return function(){d.assign(a,b)}},stringEscapeRegex:/[^ a-zA-Z0-9]/g,stringEscapeFn:function(a){return"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)},escape:function(a){if(D(a))return"'"+a.replace(this.stringEscapeRegex,
this.stringEscapeFn)+"'";if(Y(a))return a.toString();if(!0===a)return"true";if(!1===a)return"false";if(null===a)return"null";if("undefined"===typeof a)return"undefined";throw Ya("esc");},nextId:function(a,b){var d="v"+this.state.nextId++;a||this.current().vars.push(d+(b?"="+b:""));return d},current:function(){return this.state[this.state.computing]}};Kd.prototype={compile:function(a){var b=this;V(a,b.$filter);var d,c;if(d=Id(a))c=this.recurse(d);d=Gd(a.body);var e;d&&(e=[],p(d,function(a,c){var d=
b.recurse(a);d.isPure=a.isPure;a.input=d;e.push(d);a.watchId=c}));var f=[];p(a.body,function(a){f.push(b.recurse(a.expression))});a=0===a.body.length?C:1===a.body.length?f[0]:function(a,b){var c;p(f,function(d){c=d(a,b)});return c};c&&(a.assign=function(a,b,d){return c(a,d,b)});e&&(a.inputs=e);return a},recurse:function(a,b,d){var c,e,f=this,g;if(a.input)return this.inputs(a.input,a.watchId);switch(a.type){case r.Literal:return this.value(a.value,b);case r.UnaryExpression:return e=this.recurse(a.argument),
this["unary"+a.operator](e,b);case r.BinaryExpression:return c=this.recurse(a.left),e=this.recurse(a.right),this["binary"+a.operator](c,e,b);case r.LogicalExpression:return c=this.recurse(a.left),e=this.recurse(a.right),this["binary"+a.operator](c,e,b);case r.ConditionalExpression:return this["ternary?:"](this.recurse(a.test),this.recurse(a.alternate),this.recurse(a.consequent),b);case r.Identifier:return f.identifier(a.name,b,d);case r.MemberExpression:return c=this.recurse(a.object,!1,!!d),a.computed||
(e=a.property.name),a.computed&&(e=this.recurse(a.property)),a.computed?this.computedMember(c,e,b,d):this.nonComputedMember(c,e,b,d);case r.CallExpression:return g=[],p(a.arguments,function(a){g.push(f.recurse(a))}),a.filter&&(e=this.$filter(a.callee.name)),a.filter||(e=this.recurse(a.callee,!0)),a.filter?function(a,c,d,f){for(var n=[],q=0;q<g.length;++q)n.push(g[q](a,c,d,f));a=e.apply(void 0,n,f);return b?{context:void 0,name:void 0,value:a}:a}:function(a,c,d,f){var n=e(a,c,d,f),q;if(null!=n.value){q=
[];for(var p=0;p<g.length;++p)q.push(g[p](a,c,d,f));q=n.value.apply(n.context,q)}return b?{value:q}:q};case r.AssignmentExpression:return c=this.recurse(a.left,!0,1),e=this.recurse(a.right),function(a,d,f,g){var n=c(a,d,f,g);a=e(a,d,f,g);n.context[n.name]=a;return b?{value:a}:a};case r.ArrayExpression:return g=[],p(a.elements,function(a){g.push(f.recurse(a))}),function(a,c,d,e){for(var f=[],q=0;q<g.length;++q)f.push(g[q](a,c,d,e));return b?{value:f}:f};case r.ObjectExpression:return g=[],p(a.properties,
function(a){a.computed?g.push({key:f.recurse(a.key),computed:!0,value:f.recurse(a.value)}):g.push({key:a.key.type===r.Identifier?a.key.name:""+a.key.value,computed:!1,value:f.recurse(a.value)})}),function(a,c,d,e){for(var f={},q=0;q<g.length;++q)g[q].computed?f[g[q].key(a,c,d,e)]=g[q].value(a,c,d,e):f[g[q].key]=g[q].value(a,c,d,e);return b?{value:f}:f};case r.ThisExpression:return function(a){return b?{value:a}:a};case r.LocalsExpression:return function(a,c){return b?{value:c}:c};case r.NGValueParameter:return function(a,
c,d){return b?{value:d}:d}}},"unary+":function(a,b){return function(d,c,e,f){d=a(d,c,e,f);d=t(d)?+d:0;return b?{value:d}:d}},"unary-":function(a,b){return function(d,c,e,f){d=a(d,c,e,f);d=t(d)?-d:-0;return b?{value:d}:d}},"unary!":function(a,b){return function(d,c,e,f){d=!a(d,c,e,f);return b?{value:d}:d}},"binary+":function(a,b,d){return function(c,e,f,g){var k=a(c,e,f,g);c=b(c,e,f,g);k=Ed(k,c);return d?{value:k}:k}},"binary-":function(a,b,d){return function(c,e,f,g){var k=a(c,e,f,g);c=b(c,e,f,g);
k=(t(k)?k:0)-(t(c)?c:0);return d?{value:k}:k}},"binary*":function(a,b,d){return function(c,e,f,g){c=a(c,e,f,g)*b(c,e,f,g);return d?{value:c}:c}},"binary/":function(a,b,d){return function(c,e,f,g){c=a(c,e,f,g)/b(c,e,f,g);return d?{value:c}:c}},"binary%":function(a,b,d){return function(c,e,f,g){c=a(c,e,f,g)%b(c,e,f,g);return d?{value:c}:c}},"binary===":function(a,b,d){return function(c,e,f,g){c=a(c,e,f,g)===b(c,e,f,g);return d?{value:c}:c}},"binary!==":function(a,b,d){return function(c,e,f,g){c=a(c,
e,f,g)!==b(c,e,f,g);return d?{value:c}:c}},"binary==":function(a,b,d){return function(c,e,f,g){c=a(c,e,f,g)==b(c,e,f,g);return d?{value:c}:c}},"binary!=":function(a,b,d){return function(c,e,f,g){c=a(c,e,f,g)!=b(c,e,f,g);return d?{value:c}:c}},"binary<":function(a,b,d){return function(c,e,f,g){c=a(c,e,f,g)<b(c,e,f,g);return d?{value:c}:c}},"binary>":function(a,b,d){return function(c,e,f,g){c=a(c,e,f,g)>b(c,e,f,g);return d?{value:c}:c}},"binary<=":function(a,b,d){return function(c,e,f,g){c=a(c,e,f,
g)<=b(c,e,f,g);return d?{value:c}:c}},"binary>=":function(a,b,d){return function(c,e,f,g){c=a(c,e,f,g)>=b(c,e,f,g);return d?{value:c}:c}},"binary&&":function(a,b,d){return function(c,e,f,g){c=a(c,e,f,g)&&b(c,e,f,g);return d?{value:c}:c}},"binary||":function(a,b,d){return function(c,e,f,g){c=a(c,e,f,g)||b(c,e,f,g);return d?{value:c}:c}},"ternary?:":function(a,b,d,c){return function(e,f,g,k){e=a(e,f,g,k)?b(e,f,g,k):d(e,f,g,k);return c?{value:e}:e}},value:function(a,b){return function(){return b?{context:void 0,
name:void 0,value:a}:a}},identifier:function(a,b,d){return function(c,e,f,g){c=e&&a in e?e:c;d&&1!==d&&c&&null==c[a]&&(c[a]={});e=c?c[a]:void 0;return b?{context:c,name:a,value:e}:e}},computedMember:function(a,b,d,c){return function(e,f,g,k){var h=a(e,f,g,k),l,m;null!=h&&(l=b(e,f,g,k),l+="",c&&1!==c&&h&&!h[l]&&(h[l]={}),m=h[l]);return d?{context:h,name:l,value:m}:m}},nonComputedMember:function(a,b,d,c){return function(e,f,g,k){e=a(e,f,g,k);c&&1!==c&&e&&null==e[b]&&(e[b]={});f=null!=e?e[b]:void 0;
return d?{context:e,name:b,value:f}:f}},inputs:function(a,b){return function(d,c,e,f){return f?f[b]:a(d,c,e)}}};xc.prototype={constructor:xc,parse:function(a){a=this.ast.ast(a);var b=this.astCompiler.compile(a);b.literal=0===a.body.length||1===a.body.length&&(a.body[0].expression.type===r.Literal||a.body[0].expression.type===r.ArrayExpression||a.body[0].expression.type===r.ObjectExpression);b.constant=a.constant;return b}};var wa=M("$sce"),oa={HTML:"html",CSS:"css",URL:"url",RESOURCE_URL:"resourceUrl",
JS:"js"},Ac=/_([a-z])/g,Gg=M("$compile"),X=u.document.createElement("a"),Od=ua(u.location.href);Pd.$inject=["$document"];ed.$inject=["$provide"];var Wd=22,Vd=".",Cc="0";Qd.$inject=["$locale"];Sd.$inject=["$locale"];var Rg={yyyy:da("FullYear",4,0,!1,!0),yy:da("FullYear",2,0,!0,!0),y:da("FullYear",1,0,!1,!0),MMMM:ob("Month"),MMM:ob("Month",!0),MM:da("Month",2,1),M:da("Month",1,1),LLLL:ob("Month",!1,!0),dd:da("Date",2),d:da("Date",1),HH:da("Hours",2),H:da("Hours",1),hh:da("Hours",2,-12),h:da("Hours",
1,-12),mm:da("Minutes",2),m:da("Minutes",1),ss:da("Seconds",2),s:da("Seconds",1),sss:da("Milliseconds",3),EEEE:ob("Day"),EEE:ob("Day",!0),a:function(a,b){return 12>a.getHours()?b.AMPMS[0]:b.AMPMS[1]},Z:function(a,b,d){a=-1*d;return a=(0<=a?"+":"")+(Mb(Math[0<a?"floor":"ceil"](a/60),2)+Mb(Math.abs(a%60),2))},ww:Yd(2),w:Yd(1),G:Dc,GG:Dc,GGG:Dc,GGGG:function(a,b){return 0>=a.getFullYear()?b.ERANAMES[0]:b.ERANAMES[1]}},Qg=/((?:[^yMLdHhmsaZEwG']+)|(?:'(?:[^']|'')*')|(?:E+|y+|M+|L+|d+|H+|h+|m+|s+|a|Z|G+|w+))([\s\S]*)/,
Pg=/^-?\d+$/;Rd.$inject=["$locale"];var Kg=ka(N),Lg=ka(wb);Td.$inject=["$parse"];var He=ka({restrict:"E",compile:function(a,b){if(!b.href&&!b.xlinkHref)return function(a,b){if("a"===b[0].nodeName.toLowerCase()){var e="[object SVGAnimatedString]"===ha.call(b.prop("href"))?"xlink:href":"href";b.on("click",function(a){b.attr(e)||a.preventDefault()})}}}}),xb={};p(Hb,function(a,b){function d(a,d,e){a.$watch(e[c],function(a){e.$set(b,!!a)})}if("multiple"!==a){var c=Ea("ng-"+b),e=d;"checked"===a&&(e=function(a,
b,e){e.ngModel!==e[c]&&d(a,b,e)});xb[c]=function(){return{restrict:"A",priority:100,link:e}}}});p(sd,function(a,b){xb[b]=function(){return{priority:100,link:function(a,c,e){if("ngPattern"===b&&"/"===e.ngPattern.charAt(0)&&(c=e.ngPattern.match(Vg))){e.$set("ngPattern",new RegExp(c[1],c[2]));return}a.$watch(e[b],function(a){e.$set(b,a)})}}}});p(["src","srcset","href"],function(a){var b=Ea("ng-"+a);xb[b]=function(){return{priority:99,link:function(d,c,e){var f=a,g=a;"href"===a&&"[object SVGAnimatedString]"===
ha.call(c.prop("href"))&&(g="xlinkHref",e.$attr[g]="xlink:href",f=null);e.$observe(b,function(b){b?(e.$set(g,b),Ca&&f&&c.prop(f,e[g])):"href"===a&&e.$set(g,null)})}}}});var Ob={$addControl:C,$$renameControl:function(a,b){a.$name=b},$removeControl:C,$setValidity:C,$setDirty:C,$setPristine:C,$setSubmitted:C};Nb.$inject=["$element","$attrs","$scope","$animate","$interpolate"];Nb.prototype={$rollbackViewValue:function(){p(this.$$controls,function(a){a.$rollbackViewValue()})},$commitViewValue:function(){p(this.$$controls,
function(a){a.$commitViewValue()})},$addControl:function(a){Ia(a.$name,"input");this.$$controls.push(a);a.$name&&(this[a.$name]=a);a.$$parentForm=this},$$renameControl:function(a,b){var d=a.$name;this[d]===a&&delete this[d];this[b]=a;a.$name=b},$removeControl:function(a){a.$name&&this[a.$name]===a&&delete this[a.$name];p(this.$pending,function(b,d){this.$setValidity(d,null,a)},this);p(this.$error,function(b,d){this.$setValidity(d,null,a)},this);p(this.$$success,function(b,d){this.$setValidity(d,null,
a)},this);db(this.$$controls,a);a.$$parentForm=Ob},$setDirty:function(){this.$$animate.removeClass(this.$$element,Za);this.$$animate.addClass(this.$$element,Tb);this.$dirty=!0;this.$pristine=!1;this.$$parentForm.$setDirty()},$setPristine:function(){this.$$animate.setClass(this.$$element,Za,Tb+" ng-submitted");this.$dirty=!1;this.$pristine=!0;this.$submitted=!1;p(this.$$controls,function(a){a.$setPristine()})},$setUntouched:function(){p(this.$$controls,function(a){a.$setUntouched()})},$setSubmitted:function(){this.$$animate.addClass(this.$$element,
"ng-submitted");this.$submitted=!0;this.$$parentForm.$setSubmitted()}};ae({clazz:Nb,set:function(a,b,d){var c=a[b];c?-1===c.indexOf(d)&&c.push(d):a[b]=[d]},unset:function(a,b,d){var c=a[b];c&&(db(c,d),0===c.length&&delete a[b])}});var ie=function(a){return["$timeout","$parse",function(b,d){function c(a){return""===a?d('this[""]').assign:d(a).assign||C}return{name:"form",restrict:a?"EAC":"E",require:["form","^^?form"],controller:Nb,compile:function(d,f){d.addClass(Za).addClass(pb);var g=f.name?"name":
a&&f.ngForm?"ngForm":!1;return{pre:function(a,d,e,f){var n=f[0];if(!("action"in e)){var q=function(b){a.$apply(function(){n.$commitViewValue();n.$setSubmitted()});b.preventDefault()};d[0].addEventListener("submit",q);d.on("$destroy",function(){b(function(){d[0].removeEventListener("submit",q)},0,!1)})}(f[1]||n.$$parentForm).$addControl(n);var p=g?c(n.$name):C;g&&(p(a,n),e.$observe(g,function(b){n.$name!==b&&(p(a,void 0),n.$$parentForm.$$renameControl(n,b),p=c(n.$name),p(a,n))}));d.on("$destroy",function(){n.$$parentForm.$removeControl(n);
p(a,void 0);P(n,Ob)})}}}}}]},Ie=ie(),Ue=ie(!0),Sg=/^\d{4,}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+(?:[+-][0-2]\d:[0-5]\d|Z)$/,dh=/^[a-z][a-z\d.+-]*:\/*(?:[^:@]+(?::[^@]+)?@)?(?:[^\s:/?#]+|\[[a-f\d:]+])(?::\d+)?(?:\/[^?#]*)?(?:\?[^#]*)?(?:#.*)?$/i,eh=/^(?=.{1,254}$)(?=.{1,64}@)[-!#$%&'*+/0-9=?A-Z^_`a-z{|}~]+(\.[-!#$%&'*+/0-9=?A-Z^_`a-z{|}~]+)*@[A-Za-z0-9]([A-Za-z0-9-]{0,61}[A-Za-z0-9])?(\.[A-Za-z0-9]([A-Za-z0-9-]{0,61}[A-Za-z0-9])?)*$/,Tg=/^\s*(-|\+)?(\d+|(\d*(\.\d*)))([eE][+-]?\d+)?\s*$/,je=/^(\d{4,})-(\d{2})-(\d{2})$/,
ke=/^(\d{4,})-(\d\d)-(\d\d)T(\d\d):(\d\d)(?::(\d\d)(\.\d{1,3})?)?$/,Kc=/^(\d{4,})-W(\d\d)$/,le=/^(\d{4,})-(\d\d)$/,me=/^(\d\d):(\d\d)(?::(\d\d)(\.\d{1,3})?)?$/,ce=S();p(["date","datetime-local","month","time","week"],function(a){ce[a]=!0});var ne={text:function(a,b,d,c,e,f){Wa(a,b,d,c,e,f);Fc(c)},date:qb("date",je,Pb(je,["yyyy","MM","dd"]),"yyyy-MM-dd"),"datetime-local":qb("datetimelocal",ke,Pb(ke,"yyyy MM dd HH mm ss sss".split(" ")),"yyyy-MM-ddTHH:mm:ss.sss"),time:qb("time",me,Pb(me,["HH","mm",
"ss","sss"]),"HH:mm:ss.sss"),week:qb("week",Kc,function(a,b){if(ea(a))return a;if(D(a)){Kc.lastIndex=0;var d=Kc.exec(a);if(d){var c=+d[1],e=+d[2],f=d=0,g=0,k=0,h=Xd(c),e=7*(e-1);b&&(d=b.getHours(),f=b.getMinutes(),g=b.getSeconds(),k=b.getMilliseconds());return new Date(c,0,h.getDate()+e,d,f,g,k)}}return NaN},"yyyy-Www"),month:qb("month",le,Pb(le,["yyyy","MM"]),"yyyy-MM"),number:function(a,b,d,c,e,f){Gc(a,b,d,c);de(c);Wa(a,b,d,c,e,f);var g,k;if(t(d.min)||d.ngMin)c.$validators.min=function(a){return c.$isEmpty(a)||
w(g)||a>=g},d.$observe("min",function(a){g=Xa(a);c.$validate()});if(t(d.max)||d.ngMax)c.$validators.max=function(a){return c.$isEmpty(a)||w(k)||a<=k},d.$observe("max",function(a){k=Xa(a);c.$validate()});if(t(d.step)||d.ngStep){var h;c.$validators.step=function(a,b){return c.$isEmpty(b)||w(h)||ee(b,g||0,h)};d.$observe("step",function(a){h=Xa(a);c.$validate()})}},url:function(a,b,d,c,e,f){Wa(a,b,d,c,e,f);Fc(c);c.$$parserName="url";c.$validators.url=function(a,b){var d=a||b;return c.$isEmpty(d)||dh.test(d)}},
email:function(a,b,d,c,e,f){Wa(a,b,d,c,e,f);Fc(c);c.$$parserName="email";c.$validators.email=function(a,b){var d=a||b;return c.$isEmpty(d)||eh.test(d)}},radio:function(a,b,d,c){var e=!d.ngTrim||"false"!==Q(d.ngTrim);w(d.name)&&b.attr("name",++sb);b.on("click",function(a){var g;b[0].checked&&(g=d.value,e&&(g=Q(g)),c.$setViewValue(g,a&&a.type))});c.$render=function(){var a=d.value;e&&(a=Q(a));b[0].checked=a===c.$viewValue};d.$observe("value",c.$render)},range:function(a,b,d,c,e,f){function g(a,c){b.attr(a,
d[a]);d.$observe(a,c)}function k(a){n=Xa(a);T(c.$modelValue)||(m?(a=b.val(),n>a&&(a=n,b.val(a)),c.$setViewValue(a)):c.$validate())}function h(a){q=Xa(a);T(c.$modelValue)||(m?(a=b.val(),q<a&&(b.val(q),a=q<n?n:q),c.$setViewValue(a)):c.$validate())}function l(a){p=Xa(a);T(c.$modelValue)||(m&&c.$viewValue!==b.val()?c.$setViewValue(b.val()):c.$validate())}Gc(a,b,d,c);de(c);Wa(a,b,d,c,e,f);var m=c.$$hasNativeValidators&&"range"===b[0].type,n=m?0:void 0,q=m?100:void 0,p=m?1:void 0,r=b[0].validity;a=t(d.min);
e=t(d.max);f=t(d.step);var z=c.$render;c.$render=m&&t(r.rangeUnderflow)&&t(r.rangeOverflow)?function(){z();c.$setViewValue(b.val())}:z;a&&(c.$validators.min=m?function(){return!0}:function(a,b){return c.$isEmpty(b)||w(n)||b>=n},g("min",k));e&&(c.$validators.max=m?function(){return!0}:function(a,b){return c.$isEmpty(b)||w(q)||b<=q},g("max",h));f&&(c.$validators.step=m?function(){return!r.stepMismatch}:function(a,b){return c.$isEmpty(b)||w(p)||ee(b,n||0,p)},g("step",l))},checkbox:function(a,b,d,c,e,
f,g,k){var h=fe(k,a,"ngTrueValue",d.ngTrueValue,!0),l=fe(k,a,"ngFalseValue",d.ngFalseValue,!1);b.on("click",function(a){c.$setViewValue(b[0].checked,a&&a.type)});c.$render=function(){b[0].checked=c.$viewValue};c.$isEmpty=function(a){return!1===a};c.$formatters.push(function(a){return sa(a,h)});c.$parsers.push(function(a){return a?h:l})},hidden:C,button:C,submit:C,reset:C,file:C},Zc=["$browser","$sniffer","$filter","$parse",function(a,b,d,c){return{restrict:"E",require:["?ngModel"],link:{pre:function(e,
f,g,k){k[0]&&(ne[N(g.type)]||ne.text)(e,f,g,k[0],b,a,d,c)}}}}],fh=/^(true|false|\d+)$/,mf=function(){function a(a,d,c){var e=t(c)?c:9===Ca?"":null;a.prop("value",e);d.$set("value",c)}return{restrict:"A",priority:100,compile:function(b,d){return fh.test(d.ngValue)?function(b,d,f){b=b.$eval(f.ngValue);a(d,f,b)}:function(b,d,f){b.$watch(f.ngValue,function(b){a(d,f,b)})}}}},Me=["$compile",function(a){return{restrict:"AC",compile:function(b){a.$$addBindingClass(b);return function(b,c,e){a.$$addBindingInfo(c,
e.ngBind);c=c[0];b.$watch(e.ngBind,function(a){c.textContent=dc(a)})}}}}],Oe=["$interpolate","$compile",function(a,b){return{compile:function(d){b.$$addBindingClass(d);return function(c,d,f){c=a(d.attr(f.$attr.ngBindTemplate));b.$$addBindingInfo(d,c.expressions);d=d[0];f.$observe("ngBindTemplate",function(a){d.textContent=w(a)?"":a})}}}}],Ne=["$sce","$parse","$compile",function(a,b,d){return{restrict:"A",compile:function(c,e){var f=b(e.ngBindHtml),g=b(e.ngBindHtml,function(b){return a.valueOf(b)});
d.$$addBindingClass(c);return function(b,c,e){d.$$addBindingInfo(c,e.ngBindHtml);b.$watch(g,function(){var d=f(b);c.html(a.getTrustedHtml(d)||"")})}}}}],lf=ka({restrict:"A",require:"ngModel",link:function(a,b,d,c){c.$viewChangeListeners.push(function(){a.$eval(d.ngChange)})}}),Pe=Ic("",!0),Re=Ic("Odd",0),Qe=Ic("Even",1),Se=Qa({compile:function(a,b){b.$set("ngCloak",void 0);a.removeClass("ng-cloak")}}),Te=[function(){return{restrict:"A",scope:!0,controller:"@",priority:500}}],dd={},gh={blur:!0,focus:!0};
p("click dblclick mousedown mouseup mouseover mouseout mousemove mouseenter mouseleave keydown keyup keypress submit focus blur copy cut paste".split(" "),function(a){var b=Ea("ng-"+a);dd[b]=["$parse","$rootScope",function(d,c){return{restrict:"A",compile:function(e,f){var g=d(f[b]);return function(b,d){d.on(a,function(d){var e=function(){g(b,{$event:d})};gh[a]&&c.$$phase?b.$evalAsync(e):b.$apply(e)})}}}}]});var We=["$animate","$compile",function(a,b){return{multiElement:!0,transclude:"element",priority:600,
terminal:!0,restrict:"A",$$tlb:!0,link:function(d,c,e,f,g){var k,h,l;d.$watch(e.ngIf,function(d){d?h||g(function(d,f){h=f;d[d.length++]=b.$$createComment("end ngIf",e.ngIf);k={clone:d};a.enter(d,c.parent(),c)}):(l&&(l.remove(),l=null),h&&(h.$destroy(),h=null),k&&(l=vb(k.clone),a.leave(l).done(function(a){!1!==a&&(l=null)}),k=null))})}}}],Xe=["$templateRequest","$anchorScroll","$animate",function(a,b,d){return{restrict:"ECA",priority:400,terminal:!0,transclude:"element",controller:$.noop,compile:function(c,
e){var f=e.ngInclude||e.src,g=e.onload||"",k=e.autoscroll;return function(c,e,m,n,q){var p=0,r,z,v,s=function(){z&&(z.remove(),z=null);r&&(r.$destroy(),r=null);v&&(d.leave(v).done(function(a){!1!==a&&(z=null)}),z=v,v=null)};c.$watch(f,function(f){var m=function(a){!1===a||!t(k)||k&&!c.$eval(k)||b()},y=++p;f?(a(f,!0).then(function(a){if(!c.$$destroyed&&y===p){var b=c.$new();n.template=a;a=q(b,function(a){s();d.enter(a,null,e).done(m)});r=b;v=a;r.$emit("$includeContentLoaded",f);c.$eval(g)}},function(){c.$$destroyed||
y!==p||(s(),c.$emit("$includeContentError",f))}),c.$emit("$includeContentRequested",f)):(s(),n.template=null)})}}}}],of=["$compile",function(a){return{restrict:"ECA",priority:-400,require:"ngInclude",link:function(b,d,c,e){ha.call(d[0]).match(/SVG/)?(d.empty(),a(fd(e.template,u.document).childNodes)(b,function(a){d.append(a)},{futureParentElement:d})):(d.html(e.template),a(d.contents())(b))}}}],Ye=Qa({priority:450,compile:function(){return{pre:function(a,b,d){a.$eval(d.ngInit)}}}}),kf=function(){return{restrict:"A",
priority:100,require:"ngModel",link:function(a,b,d,c){var e=d.ngList||", ",f="false"!==d.ngTrim,g=f?Q(e):e;c.$parsers.push(function(a){if(!w(a)){var b=[];a&&p(a.split(g),function(a){a&&b.push(f?Q(a):a)});return b}});c.$formatters.push(function(a){if(I(a))return a.join(e)});c.$isEmpty=function(a){return!a||!a.length}}}},pb="ng-valid",$d="ng-invalid",Za="ng-pristine",Tb="ng-dirty",rb=M("ngModel");Qb.$inject="$scope $exceptionHandler $attrs $element $parse $animate $timeout $q $interpolate".split(" ");
Qb.prototype={$$initGetterSetters:function(){if(this.$options.getOption("getterSetter")){var a=this.$$parse(this.$$attr.ngModel+"()"),b=this.$$parse(this.$$attr.ngModel+"($$$p)");this.$$ngModelGet=function(b){var c=this.$$parsedNgModel(b);A(c)&&(c=a(b));return c};this.$$ngModelSet=function(a,c){A(this.$$parsedNgModel(a))?b(a,{$$$p:c}):this.$$parsedNgModelAssign(a,c)}}else if(!this.$$parsedNgModel.assign)throw rb("nonassign",this.$$attr.ngModel,Aa(this.$$element));},$render:C,$isEmpty:function(a){return w(a)||
""===a||null===a||a!==a},$$updateEmptyClasses:function(a){this.$isEmpty(a)?(this.$$animate.removeClass(this.$$element,"ng-not-empty"),this.$$animate.addClass(this.$$element,"ng-empty")):(this.$$animate.removeClass(this.$$element,"ng-empty"),this.$$animate.addClass(this.$$element,"ng-not-empty"))},$setPristine:function(){this.$dirty=!1;this.$pristine=!0;this.$$animate.removeClass(this.$$element,Tb);this.$$animate.addClass(this.$$element,Za)},$setDirty:function(){this.$dirty=!0;this.$pristine=!1;this.$$animate.removeClass(this.$$element,
Za);this.$$animate.addClass(this.$$element,Tb);this.$$parentForm.$setDirty()},$setUntouched:function(){this.$touched=!1;this.$untouched=!0;this.$$animate.setClass(this.$$element,"ng-untouched","ng-touched")},$setTouched:function(){this.$touched=!0;this.$untouched=!1;this.$$animate.setClass(this.$$element,"ng-touched","ng-untouched")},$rollbackViewValue:function(){this.$$timeout.cancel(this.$$pendingDebounce);this.$viewValue=this.$$lastCommittedViewValue;this.$render()},$validate:function(){if(!T(this.$modelValue)){var a=
this.$$lastCommittedViewValue,b=this.$$rawModelValue,d=this.$valid,c=this.$modelValue,e=this.$options.getOption("allowInvalid"),f=this;this.$$runValidators(b,a,function(a){e||d===a||(f.$modelValue=a?b:void 0,f.$modelValue!==c&&f.$$writeModelToScope())})}},$$runValidators:function(a,b,d){function c(){var c=!0;p(h.$validators,function(d,e){var g=Boolean(d(a,b));c=c&&g;f(e,g)});return c?!0:(p(h.$asyncValidators,function(a,b){f(b,null)}),!1)}function e(){var c=[],d=!0;p(h.$asyncValidators,function(e,
g){var h=e(a,b);if(!h||!A(h.then))throw rb("nopromise",h);f(g,void 0);c.push(h.then(function(){f(g,!0)},function(){d=!1;f(g,!1)}))});c.length?h.$$q.all(c).then(function(){g(d)},C):g(!0)}function f(a,b){k===h.$$currentValidationRunId&&h.$setValidity(a,b)}function g(a){k===h.$$currentValidationRunId&&d(a)}this.$$currentValidationRunId++;var k=this.$$currentValidationRunId,h=this;(function(){var a=h.$$parserName||"parse";if(w(h.$$parserValid))f(a,null);else return h.$$parserValid||(p(h.$validators,function(a,
b){f(b,null)}),p(h.$asyncValidators,function(a,b){f(b,null)})),f(a,h.$$parserValid),h.$$parserValid;return!0})()?c()?e():g(!1):g(!1)},$commitViewValue:function(){var a=this.$viewValue;this.$$timeout.cancel(this.$$pendingDebounce);if(this.$$lastCommittedViewValue!==a||""===a&&this.$$hasNativeValidators)this.$$updateEmptyClasses(a),this.$$lastCommittedViewValue=a,this.$pristine&&this.$setDirty(),this.$$parseAndValidate()},$$parseAndValidate:function(){var a=this.$$lastCommittedViewValue,b=this;if(this.$$parserValid=
w(a)?void 0:!0)for(var d=0;d<this.$parsers.length;d++)if(a=this.$parsers[d](a),w(a)){this.$$parserValid=!1;break}T(this.$modelValue)&&(this.$modelValue=this.$$ngModelGet(this.$$scope));var c=this.$modelValue,e=this.$options.getOption("allowInvalid");this.$$rawModelValue=a;e&&(this.$modelValue=a,b.$modelValue!==c&&b.$$writeModelToScope());this.$$runValidators(a,this.$$lastCommittedViewValue,function(d){e||(b.$modelValue=d?a:void 0,b.$modelValue!==c&&b.$$writeModelToScope())})},$$writeModelToScope:function(){this.$$ngModelSet(this.$$scope,
this.$modelValue);p(this.$viewChangeListeners,function(a){try{a()}catch(b){this.$$exceptionHandler(b)}},this)},$setViewValue:function(a,b){this.$viewValue=a;this.$options.getOption("updateOnDefault")&&this.$$debounceViewValueCommit(b)},$$debounceViewValueCommit:function(a){var b=this.$options.getOption("debounce");Y(b[a])?b=b[a]:Y(b["default"])&&(b=b["default"]);this.$$timeout.cancel(this.$$pendingDebounce);var d=this;0<b?this.$$pendingDebounce=this.$$timeout(function(){d.$commitViewValue()},b):this.$$scope.$root.$$phase?
this.$commitViewValue():this.$$scope.$apply(function(){d.$commitViewValue()})},$overrideModelOptions:function(a){this.$options=this.$options.createChild(a)}};ae({clazz:Qb,set:function(a,b){a[b]=!0},unset:function(a,b){delete a[b]}});var jf=["$rootScope",function(a){return{restrict:"A",require:["ngModel","^?form","^?ngModelOptions"],controller:Qb,priority:1,compile:function(b){b.addClass(Za).addClass("ng-untouched").addClass(pb);return{pre:function(a,b,e,f){var g=f[0];b=f[1]||g.$$parentForm;if(f=f[2])g.$options=
f.$options;g.$$initGetterSetters();b.$addControl(g);e.$observe("name",function(a){g.$name!==a&&g.$$parentForm.$$renameControl(g,a)});a.$on("$destroy",function(){g.$$parentForm.$removeControl(g)})},post:function(b,c,e,f){function g(){k.$setTouched()}var k=f[0];if(k.$options.getOption("updateOn"))c.on(k.$options.getOption("updateOn"),function(a){k.$$debounceViewValueCommit(a&&a.type)});c.on("blur",function(){k.$touched||(a.$$phase?b.$evalAsync(g):b.$apply(g))})}}}}}],Rb,hh=/(\s+|^)default(\s+|$)/;Jc.prototype=
{getOption:function(a){return this.$$options[a]},createChild:function(a){var b=!1;a=P({},a);p(a,function(d,c){"$inherit"===d?"*"===c?b=!0:(a[c]=this.$$options[c],"updateOn"===c&&(a.updateOnDefault=this.$$options.updateOnDefault)):"updateOn"===c&&(a.updateOnDefault=!1,a[c]=Q(d.replace(hh,function(){a.updateOnDefault=!0;return" "})))},this);b&&(delete a["*"],ge(a,this.$$options));ge(a,Rb.$$options);return new Jc(a)}};Rb=new Jc({updateOn:"",updateOnDefault:!0,debounce:0,getterSetter:!1,allowInvalid:!1,
timezone:null});var nf=function(){function a(a,d){this.$$attrs=a;this.$$scope=d}a.$inject=["$attrs","$scope"];a.prototype={$onInit:function(){var a=this.parentCtrl?this.parentCtrl.$options:Rb,d=this.$$scope.$eval(this.$$attrs.ngModelOptions);this.$options=a.createChild(d)}};return{restrict:"A",priority:10,require:{parentCtrl:"?^^ngModelOptions"},bindToController:!0,controller:a}},Ze=Qa({terminal:!0,priority:1E3}),ih=M("ngOptions"),jh=/^\s*([\s\S]+?)(?:\s+as\s+([\s\S]+?))?(?:\s+group\s+by\s+([\s\S]+?))?(?:\s+disable\s+when\s+([\s\S]+?))?\s+for\s+(?:([$\w][$\w]*)|(?:\(\s*([$\w][$\w]*)\s*,\s*([$\w][$\w]*)\s*\)))\s+in\s+([\s\S]+?)(?:\s+track\s+by\s+([\s\S]+?))?$/,
gf=["$compile","$document","$parse",function(a,b,d){function c(a,b,c){function e(a,b,c,d,f){this.selectValue=a;this.viewValue=b;this.label=c;this.group=d;this.disabled=f}function f(a){var b;if(!p&&xa(a))b=a;else{b=[];for(var c in a)a.hasOwnProperty(c)&&"$"!==c.charAt(0)&&b.push(c)}return b}var n=a.match(jh);if(!n)throw ih("iexp",a,Aa(b));var q=n[5]||n[7],p=n[6];a=/ as /.test(n[0])&&n[1];var r=n[9];b=d(n[2]?n[1]:q);var z=a&&d(a)||b,t=r&&d(r),s=r?function(a,b){return t(c,b)}:function(a){return Pa(a)},
w=function(a,b){return s(a,A(a,b))},u=d(n[2]||n[1]),y=d(n[3]||""),J=d(n[4]||""),H=d(n[8]),B={},A=p?function(a,b){B[p]=b;B[q]=a;return B}:function(a){B[q]=a;return B};return{trackBy:r,getTrackByValue:w,getWatchables:d(H,function(a){var b=[];a=a||[];for(var d=f(a),e=d.length,g=0;g<e;g++){var k=a===d?g:d[g],l=a[k],k=A(l,k),l=s(l,k);b.push(l);if(n[2]||n[1])l=u(c,k),b.push(l);n[4]&&(k=J(c,k),b.push(k))}return b}),getOptions:function(){for(var a=[],b={},d=H(c)||[],g=f(d),k=g.length,n=0;n<k;n++){var q=d===
g?n:g[n],p=A(d[q],q),t=z(c,p),q=s(t,p),v=u(c,p),G=y(c,p),p=J(c,p),t=new e(q,t,v,G,p);a.push(t);b[q]=t}return{items:a,selectValueMap:b,getOptionFromViewValue:function(a){return b[w(a)]},getViewValueFromOption:function(a){return r?pa(a.viewValue):a.viewValue}}}}}var e=u.document.createElement("option"),f=u.document.createElement("optgroup");return{restrict:"A",terminal:!0,require:["select","ngModel"],link:{pre:function(a,b,c,d){d[0].registerOption=C},post:function(d,k,h,l){function m(a){var b=(a=s.getOptionFromViewValue(a))&&
a.element;b&&!b.selected&&(b.selected=!0);return a}function n(a,b){a.element=b;b.disabled=a.disabled;a.label!==b.label&&(b.label=a.label,b.textContent=a.label);b.value=a.selectValue}var q=l[0],r=l[1],w=h.multiple;l=0;for(var z=k.children(),v=z.length;l<v;l++)if(""===z[l].value){q.hasEmptyOption=!0;q.emptyOption=z.eq(l);break}k.empty();l=!!q.emptyOption;B(e.cloneNode(!1)).val("?");var s,u=c(h.ngOptions,k,d),A=b[0].createDocumentFragment();q.generateUnknownOptionValue=function(a){return"?"};w?(q.writeValue=
function(a){if(s){var b=a&&a.map(m)||[];s.items.forEach(function(a){a.element.selected&&-1===Array.prototype.indexOf.call(b,a)&&(a.element.selected=!1)})}},q.readValue=function(){var a=k.val()||[],b=[];p(a,function(a){(a=s.selectValueMap[a])&&!a.disabled&&b.push(s.getViewValueFromOption(a))});return b},u.trackBy&&d.$watchCollection(function(){if(I(r.$viewValue))return r.$viewValue.map(function(a){return u.getTrackByValue(a)})},function(){r.$render()})):(q.writeValue=function(a){if(s){var b=k[0].options[k[0].selectedIndex],
c=s.getOptionFromViewValue(a);b&&b.removeAttribute("selected");c?(k[0].value!==c.selectValue&&(q.removeUnknownOption(),k[0].value=c.selectValue,c.element.selected=!0),c.element.setAttribute("selected","selected")):q.selectUnknownOrEmptyOption(a)}},q.readValue=function(){var a=s.selectValueMap[k.val()];return a&&!a.disabled?(q.unselectEmptyOption(),q.removeUnknownOption(),s.getViewValueFromOption(a)):null},u.trackBy&&d.$watch(function(){return u.getTrackByValue(r.$viewValue)},function(){r.$render()}));
l&&(a(q.emptyOption)(d),k.prepend(q.emptyOption),8===q.emptyOption[0].nodeType?(q.hasEmptyOption=!1,q.registerOption=function(a,b){""===b.val()&&(q.hasEmptyOption=!0,q.emptyOption=b,q.emptyOption.removeClass("ng-scope"),r.$render(),b.on("$destroy",function(){var a=q.$isEmptyOptionSelected();q.hasEmptyOption=!1;q.emptyOption=void 0;a&&r.$render()}))}):q.emptyOption.removeClass("ng-scope"));d.$watchCollection(u.getWatchables,function(){var a=s&&q.readValue();if(s)for(var b=s.items.length-1;0<=b;b--){var c=
s.items[b];t(c.group)?Gb(c.element.parentNode):Gb(c.element)}s=u.getOptions();var d={};s.items.forEach(function(a){var b;if(t(a.group)){b=d[a.group];b||(b=f.cloneNode(!1),A.appendChild(b),b.label=null===a.group?"null":a.group,d[a.group]=b);var c=e.cloneNode(!1);b.appendChild(c);n(a,c)}else b=e.cloneNode(!1),A.appendChild(b),n(a,b)});k[0].appendChild(A);r.$render();r.$isEmpty(a)||(b=q.readValue(),(u.trackBy||w?sa(a,b):a===b)||(r.$setViewValue(b),r.$render()))})}}}}],$e=["$locale","$interpolate","$log",
function(a,b,d){var c=/{}/g,e=/^when(Minus)?(.+)$/;return{link:function(f,g,k){function h(a){g.text(a||"")}var l=k.count,m=k.$attr.when&&g.attr(k.$attr.when),n=k.offset||0,q=f.$eval(m)||{},r={},t=b.startSymbol(),z=b.endSymbol(),v=t+l+"-"+n+z,s=$.noop,u;p(k,function(a,b){var c=e.exec(b);c&&(c=(c[1]?"-":"")+N(c[2]),q[c]=g.attr(k.$attr[b]))});p(q,function(a,d){r[d]=b(a.replace(c,v))});f.$watch(l,function(b){var c=parseFloat(b),e=T(c);e||c in q||(c=a.pluralCat(c-n));c===u||e&&T(u)||(s(),e=r[c],w(e)?(null!=
b&&d.debug("ngPluralize: no rule defined for '"+c+"' in "+m),s=C,h()):s=f.$watch(e,h),u=c)})}}}],af=["$parse","$animate","$compile",function(a,b,d){var c=M("ngRepeat"),e=function(a,b,c,d,e,m,n){a[c]=d;e&&(a[e]=m);a.$index=b;a.$first=0===b;a.$last=b===n-1;a.$middle=!(a.$first||a.$last);a.$odd=!(a.$even=0===(b&1))};return{restrict:"A",multiElement:!0,transclude:"element",priority:1E3,terminal:!0,$$tlb:!0,compile:function(f,g){var k=g.ngRepeat,h=d.$$createComment("end ngRepeat",k),l=k.match(/^\s*([\s\S]+?)\s+in\s+([\s\S]+?)(?:\s+as\s+([\s\S]+?))?(?:\s+track\s+by\s+([\s\S]+?))?\s*$/);
if(!l)throw c("iexp",k);var m=l[1],n=l[2],q=l[3],r=l[4],l=m.match(/^(?:(\s*[$\w]+)|\(\s*([$\w]+)\s*,\s*([$\w]+)\s*\))$/);if(!l)throw c("iidexp",m);var t=l[3]||l[1],z=l[2];if(q&&(!/^[$a-zA-Z_][$a-zA-Z0-9_]*$/.test(q)||/^(null|undefined|this|\$index|\$first|\$middle|\$last|\$even|\$odd|\$parent|\$root|\$id)$/.test(q)))throw c("badident",q);var v,s,u,w,y={$id:Pa};r?v=a(r):(u=function(a,b){return Pa(b)},w=function(a){return a});return function(a,d,f,g,l){v&&(s=function(b,c,d){z&&(y[z]=b);y[t]=c;y.$index=
d;return v(a,y)});var m=S();a.$watchCollection(n,function(f){var g,n,r=d[0],v,y=S(),B,A,G,C,E,D,I;q&&(a[q]=f);if(xa(f))E=f,n=s||u;else for(I in n=s||w,E=[],f)ra.call(f,I)&&"$"!==I.charAt(0)&&E.push(I);B=E.length;I=Array(B);for(g=0;g<B;g++)if(A=f===E?g:E[g],G=f[A],C=n(A,G,g),m[C])D=m[C],delete m[C],y[C]=D,I[g]=D;else{if(y[C])throw p(I,function(a){a&&a.scope&&(m[a.id]=a)}),c("dupes",k,C,G);I[g]={id:C,scope:void 0,clone:void 0};y[C]=!0}for(v in m){D=m[v];C=vb(D.clone);b.leave(C);if(C[0].parentNode)for(g=
0,n=C.length;g<n;g++)C[g].$$NG_REMOVED=!0;D.scope.$destroy()}for(g=0;g<B;g++)if(A=f===E?g:E[g],G=f[A],D=I[g],D.scope){v=r;do v=v.nextSibling;while(v&&v.$$NG_REMOVED);D.clone[0]!==v&&b.move(vb(D.clone),null,r);r=D.clone[D.clone.length-1];e(D.scope,g,t,G,z,A,B)}else l(function(a,c){D.scope=c;var d=h.cloneNode(!1);a[a.length++]=d;b.enter(a,null,r);r=d;D.clone=a;y[D.id]=D;e(D.scope,g,t,G,z,A,B)});m=y})}}}}],bf=["$animate",function(a){return{restrict:"A",multiElement:!0,link:function(b,d,c){b.$watch(c.ngShow,
function(b){a[b?"removeClass":"addClass"](d,"ng-hide",{tempClasses:"ng-hide-animate"})})}}}],Ve=["$animate",function(a){return{restrict:"A",multiElement:!0,link:function(b,d,c){b.$watch(c.ngHide,function(b){a[b?"addClass":"removeClass"](d,"ng-hide",{tempClasses:"ng-hide-animate"})})}}}],cf=Qa(function(a,b,d){a.$watch(d.ngStyle,function(a,d){d&&a!==d&&p(d,function(a,c){b.css(c,"")});a&&b.css(a)},!0)}),df=["$animate","$compile",function(a,b){return{require:"ngSwitch",controller:["$scope",function(){this.cases=
{}}],link:function(d,c,e,f){var g=[],k=[],h=[],l=[],m=function(a,b){return function(c){!1!==c&&a.splice(b,1)}};d.$watch(e.ngSwitch||e.on,function(c){for(var d,e;h.length;)a.cancel(h.pop());d=0;for(e=l.length;d<e;++d){var r=vb(k[d].clone);l[d].$destroy();(h[d]=a.leave(r)).done(m(h,d))}k.length=0;l.length=0;(g=f.cases["!"+c]||f.cases["?"])&&p(g,function(c){c.transclude(function(d,e){l.push(e);var f=c.element;d[d.length++]=b.$$createComment("end ngSwitchWhen");k.push({clone:d});a.enter(d,f.parent(),
f)})})})}}}],ef=Qa({transclude:"element",priority:1200,require:"^ngSwitch",multiElement:!0,link:function(a,b,d,c,e){a=d.ngSwitchWhen.split(d.ngSwitchWhenSeparator).sort().filter(function(a,b,c){return c[b-1]!==a});p(a,function(a){c.cases["!"+a]=c.cases["!"+a]||[];c.cases["!"+a].push({transclude:e,element:b})})}}),ff=Qa({transclude:"element",priority:1200,require:"^ngSwitch",multiElement:!0,link:function(a,b,d,c,e){c.cases["?"]=c.cases["?"]||[];c.cases["?"].push({transclude:e,element:b})}}),kh=M("ngTransclude"),
hf=["$compile",function(a){return{restrict:"EAC",terminal:!0,compile:function(b){var d=a(b.contents());b.empty();return function(a,b,f,g,k){function h(){d(a,function(a){b.append(a)})}if(!k)throw kh("orphan",Aa(b));f.ngTransclude===f.$attr.ngTransclude&&(f.ngTransclude="");f=f.ngTransclude||f.ngTranscludeSlot;k(function(a,c){var d;if(d=a.length)a:{d=0;for(var f=a.length;d<f;d++){var g=a[d];if(g.nodeType!==Oa||g.nodeValue.trim()){d=!0;break a}}d=void 0}d?b.append(a):(h(),c.$destroy())},null,f);f&&!k.isSlotFilled(f)&&
h()}}}}],Je=["$templateCache",function(a){return{restrict:"E",terminal:!0,compile:function(b,d){"text/ng-template"===d.type&&a.put(d.id,b[0].text)}}}],lh={$setViewValue:C,$render:C},mh=["$element","$scope",function(a,b){function d(){g||(g=!0,b.$$postDigest(function(){g=!1;e.ngModelCtrl.$render()}))}function c(a){k||(k=!0,b.$$postDigest(function(){b.$$destroyed||(k=!1,e.ngModelCtrl.$setViewValue(e.readValue()),a&&e.ngModelCtrl.$render())}))}var e=this,f=new Ib;e.selectValueMap={};e.ngModelCtrl=lh;
e.multiple=!1;e.unknownOption=B(u.document.createElement("option"));e.hasEmptyOption=!1;e.emptyOption=void 0;e.renderUnknownOption=function(b){b=e.generateUnknownOptionValue(b);e.unknownOption.val(b);a.prepend(e.unknownOption);Ga(e.unknownOption,!0);a.val(b)};e.updateUnknownOption=function(b){b=e.generateUnknownOptionValue(b);e.unknownOption.val(b);Ga(e.unknownOption,!0);a.val(b)};e.generateUnknownOptionValue=function(a){return"? "+Pa(a)+" ?"};e.removeUnknownOption=function(){e.unknownOption.parent()&&
e.unknownOption.remove()};e.selectEmptyOption=function(){e.emptyOption&&(a.val(""),Ga(e.emptyOption,!0))};e.unselectEmptyOption=function(){e.hasEmptyOption&&Ga(e.emptyOption,!1)};b.$on("$destroy",function(){e.renderUnknownOption=C});e.readValue=function(){var b=a.val(),b=b in e.selectValueMap?e.selectValueMap[b]:b;return e.hasOption(b)?b:null};e.writeValue=function(b){var c=a[0].options[a[0].selectedIndex];c&&Ga(B(c),!1);e.hasOption(b)?(e.removeUnknownOption(),c=Pa(b),a.val(c in e.selectValueMap?
c:b),Ga(B(a[0].options[a[0].selectedIndex]),!0)):e.selectUnknownOrEmptyOption(b)};e.addOption=function(a,b){if(8!==b[0].nodeType){Ia(a,'"option value"');""===a&&(e.hasEmptyOption=!0,e.emptyOption=b);var c=f.get(a)||0;f.set(a,c+1);d()}};e.removeOption=function(a){var b=f.get(a);b&&(1===b?(f.delete(a),""===a&&(e.hasEmptyOption=!1,e.emptyOption=void 0)):f.set(a,b-1))};e.hasOption=function(a){return!!f.get(a)};e.$hasEmptyOption=function(){return e.hasEmptyOption};e.$isUnknownOptionSelected=function(){return a[0].options[0]===
e.unknownOption[0]};e.$isEmptyOptionSelected=function(){return e.hasEmptyOption&&a[0].options[a[0].selectedIndex]===e.emptyOption[0]};e.selectUnknownOrEmptyOption=function(a){null==a&&e.emptyOption?(e.removeUnknownOption(),e.selectEmptyOption()):e.unknownOption.parent().length?e.updateUnknownOption(a):e.renderUnknownOption(a)};var g=!1,k=!1;e.registerOption=function(a,b,f,g,k){if(f.$attr.ngValue){var p,r=NaN;f.$observe("value",function(a){var d,f=b.prop("selected");t(r)&&(e.removeOption(p),delete e.selectValueMap[r],
d=!0);r=Pa(a);p=a;e.selectValueMap[r]=a;e.addOption(a,b);b.attr("value",r);d&&f&&c()})}else g?f.$observe("value",function(a){e.readValue();var d,f=b.prop("selected");t(p)&&(e.removeOption(p),d=!0);p=a;e.addOption(a,b);d&&f&&c()}):k?a.$watch(k,function(a,d){f.$set("value",a);var g=b.prop("selected");d!==a&&e.removeOption(d);e.addOption(a,b);d&&g&&c()}):e.addOption(f.value,b);f.$observe("disabled",function(a){if("true"===a||a&&b.prop("selected"))e.multiple?c(!0):(e.ngModelCtrl.$setViewValue(null),e.ngModelCtrl.$render())});
b.on("$destroy",function(){var a=e.readValue(),b=f.value;e.removeOption(b);d();(e.multiple&&a&&-1!==a.indexOf(b)||a===b)&&c(!0)})}}],Ke=function(){return{restrict:"E",require:["select","?ngModel"],controller:mh,priority:1,link:{pre:function(a,b,d,c){var e=c[0],f=c[1];if(f){if(e.ngModelCtrl=f,b.on("change",function(){e.removeUnknownOption();a.$apply(function(){f.$setViewValue(e.readValue())})}),d.multiple){e.multiple=!0;e.readValue=function(){var a=[];p(b.find("option"),function(b){b.selected&&!b.disabled&&
(b=b.value,a.push(b in e.selectValueMap?e.selectValueMap[b]:b))});return a};e.writeValue=function(a){p(b.find("option"),function(b){var c=!!a&&(-1!==Array.prototype.indexOf.call(a,b.value)||-1!==Array.prototype.indexOf.call(a,e.selectValueMap[b.value]));c!==b.selected&&Ga(B(b),c)})};var g,k=NaN;a.$watch(function(){k!==f.$viewValue||sa(g,f.$viewValue)||(g=ja(f.$viewValue),f.$render());k=f.$viewValue});f.$isEmpty=function(a){return!a||0===a.length}}}else e.registerOption=C},post:function(a,b,d,c){var e=
c[1];if(e){var f=c[0];e.$render=function(){f.writeValue(e.$viewValue)}}}}}},Le=["$interpolate",function(a){return{restrict:"E",priority:100,compile:function(b,d){var c,e;t(d.ngValue)||(t(d.value)?c=a(d.value,!0):(e=a(b.text(),!0))||d.$set("value",b.text()));return function(a,b,d){var h=b.parent();(h=h.data("$selectController")||h.parent().data("$selectController"))&&h.registerOption(a,b,d,c,e)}}}}],ad=function(){return{restrict:"A",require:"?ngModel",link:function(a,b,d,c){c&&(d.required=!0,c.$validators.required=
function(a,b){return!d.required||!c.$isEmpty(b)},d.$observe("required",function(){c.$validate()}))}}},$c=function(){return{restrict:"A",require:"?ngModel",link:function(a,b,d,c){if(c){var e,f=d.ngPattern||d.pattern;d.$observe("pattern",function(a){D(a)&&0<a.length&&(a=new RegExp("^"+a+"$"));if(a&&!a.test)throw M("ngPattern")("noregexp",f,a,Aa(b));e=a||void 0;c.$validate()});c.$validators.pattern=function(a,b){return c.$isEmpty(b)||w(e)||e.test(b)}}}}},cd=function(){return{restrict:"A",require:"?ngModel",
link:function(a,b,d,c){if(c){var e=-1;d.$observe("maxlength",function(a){a=Z(a);e=T(a)?-1:a;c.$validate()});c.$validators.maxlength=function(a,b){return 0>e||c.$isEmpty(b)||b.length<=e}}}}},bd=function(){return{restrict:"A",require:"?ngModel",link:function(a,b,d,c){if(c){var e=0;d.$observe("minlength",function(a){e=Z(a)||0;c.$validate()});c.$validators.minlength=function(a,b){return c.$isEmpty(b)||b.length>=e}}}}};u.angular.bootstrap?u.console&&console.log("WARNING: Tried to load angular more than once."):
(Be(),Ee($),$.module("ngLocale",[],["$provide",function(a){function b(a){a+="";var b=a.indexOf(".");return-1==b?0:a.length-b-1}a.value("$locale",{DATETIME_FORMATS:{AMPMS:["AM","PM"],DAY:"Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(" "),ERANAMES:["Before Christ","Anno Domini"],ERAS:["BC","AD"],FIRSTDAYOFWEEK:6,MONTH:"January February March April May June July August September October November December".split(" "),SHORTDAY:"Sun Mon Tue Wed Thu Fri Sat".split(" "),SHORTMONTH:"Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" "),
STANDALONEMONTH:"January February March April May June July August September October November December".split(" "),WEEKENDRANGE:[5,6],fullDate:"EEEE, MMMM d, y",longDate:"MMMM d, y",medium:"MMM d, y h:mm:ss a",mediumDate:"MMM d, y",mediumTime:"h:mm:ss a","short":"M/d/yy h:mm a",shortDate:"M/d/yy",shortTime:"h:mm a"},NUMBER_FORMATS:{CURRENCY_SYM:"$",DECIMAL_SEP:".",GROUP_SEP:",",PATTERNS:[{gSize:3,lgSize:3,maxFrac:3,minFrac:0,minInt:1,negPre:"-",negSuf:"",posPre:"",posSuf:""},{gSize:3,lgSize:3,maxFrac:2,
minFrac:2,minInt:1,negPre:"-\u00a4",negSuf:"",posPre:"\u00a4",posSuf:""}]},id:"en-us",localeID:"en_US",pluralCat:function(a,c){var e=a|0,f=c;void 0===f&&(f=Math.min(b(a),3));Math.pow(10,f);return 1==e&&0==f?"one":"other"}})}]),B(function(){we(u.document,Uc)}))})(window);!window.angular.$$csp().noInlineStyle&&window.angular.element(document.head).prepend('<style type="text/css">@charset "UTF-8";[ng\\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide:not(.ng-hide-animate){display:none !important;}ng\\:form{display:block;}.ng-animate-shim{visibility:hidden;}.ng-anchor{position:absolute;}</style>');
//# sourceMappingURL=angular.min.js.map

/*! 
 * angular-loading-bar v0.9.0
 * https://chieffancypants.github.io/angular-loading-bar
 * Copyright (c) 2016 Wes Cruver
 * License: MIT
 */
!function(){"use strict";angular.module("angular-loading-bar",["cfp.loadingBarInterceptor"]),angular.module("chieffancypants.loadingBar",["cfp.loadingBarInterceptor"]),angular.module("cfp.loadingBarInterceptor",["cfp.loadingBar"]).config(["$httpProvider",function(a){var b=["$q","$cacheFactory","$timeout","$rootScope","$log","cfpLoadingBar",function(b,c,d,e,f,g){function h(){d.cancel(j),g.complete(),l=0,k=0}function i(b){var d,e=c.get("$http"),f=a.defaults;!b.cache&&!f.cache||b.cache===!1||"GET"!==b.method&&"JSONP"!==b.method||(d=angular.isObject(b.cache)?b.cache:angular.isObject(f.cache)?f.cache:e);var g=void 0!==d?void 0!==d.get(b.url):!1;return void 0!==b.cached&&g!==b.cached?b.cached:(b.cached=g,g)}var j,k=0,l=0,m=g.latencyThreshold;return{request:function(a){return a.ignoreLoadingBar||i(a)||(e.$broadcast("cfpLoadingBar:loading",{url:a.url}),0===k&&(j=d(function(){g.start()},m)),k++,g.set(l/k)),a},response:function(a){return a&&a.config?(a.config.ignoreLoadingBar||i(a.config)||(l++,e.$broadcast("cfpLoadingBar:loaded",{url:a.config.url,result:a}),l>=k?h():g.set(l/k)),a):(f.error("Broken interceptor detected: Config object not supplied in response:\n https://github.com/chieffancypants/angular-loading-bar/pull/50"),a)},responseError:function(a){return a&&a.config?(a.config.ignoreLoadingBar||i(a.config)||(l++,e.$broadcast("cfpLoadingBar:loaded",{url:a.config.url,result:a}),l>=k?h():g.set(l/k)),b.reject(a)):(f.error("Broken interceptor detected: Config object not supplied in rejection:\n https://github.com/chieffancypants/angular-loading-bar/pull/50"),b.reject(a))}}}];a.interceptors.push(b)}]),angular.module("cfp.loadingBar",[]).provider("cfpLoadingBar",function(){this.autoIncrement=!0,this.includeSpinner=!0,this.includeBar=!0,this.latencyThreshold=100,this.startSize=.02,this.parentSelector="body",this.spinnerTemplate='<div id="loading-bar-spinner"><div class="spinner-icon"></div></div>',this.loadingBarTemplate='<div id="loading-bar"><div class="bar"><div class="peg"></div></div></div>',this.$get=["$injector","$document","$timeout","$rootScope",function(a,b,c,d){function e(){if(k||(k=a.get("$animate")),c.cancel(m),!r){var e=b[0],g=e.querySelector?e.querySelector(n):b.find(n)[0];g||(g=e.getElementsByTagName("body")[0]);var h=angular.element(g),i=g.lastChild&&angular.element(g.lastChild);d.$broadcast("cfpLoadingBar:started"),r=!0,v&&k.enter(o,h,i),u&&k.enter(q,h,o),f(w)}}function f(a){if(r){var b=100*a+"%";p.css("width",b),s=a,t&&(c.cancel(l),l=c(function(){g()},250))}}function g(){if(!(h()>=1)){var a=0,b=h();a=b>=0&&.25>b?(3*Math.random()+3)/100:b>=.25&&.65>b?3*Math.random()/100:b>=.65&&.9>b?2*Math.random()/100:b>=.9&&.99>b?.005:0;var c=h()+a;f(c)}}function h(){return s}function i(){s=0,r=!1}function j(){k||(k=a.get("$animate")),d.$broadcast("cfpLoadingBar:completed"),f(1),c.cancel(m),m=c(function(){var a=k.leave(o,i);a&&a.then&&a.then(i),k.leave(q)},500)}var k,l,m,n=this.parentSelector,o=angular.element(this.loadingBarTemplate),p=o.find("div").eq(0),q=angular.element(this.spinnerTemplate),r=!1,s=0,t=this.autoIncrement,u=this.includeSpinner,v=this.includeBar,w=this.startSize;return{start:e,set:f,status:h,inc:g,complete:j,autoIncrement:this.autoIncrement,includeSpinner:this.includeSpinner,latencyThreshold:this.latencyThreshold,parentSelector:this.parentSelector,startSize:this.startSize}}]})}();
/*!
 * Angular Datepicker v2.1.23
 *
 * Released by 720kb.net under the MIT license
 * www.opensource.org/licenses/MIT
 *
 * 2017-06-28
 */


!function(e,a){"use strict";var t=function(){if(a.userAgent&&(a.userAgent.match(/Android/i)||a.userAgent.match(/webOS/i)||a.userAgent.match(/iPhone/i)||a.userAgent.match(/iPad/i)||a.userAgent.match(/iPod/i)||a.userAgent.match(/BlackBerry/i)||a.userAgent.match(/Windows Phone/i)))return!0}(),n=function(e,a,n){return n&&(t=!1),t?['<div class="_720kb-datepicker-calendar-header">','<div class="_720kb-datepicker-calendar-header-middle _720kb-datepicker-mobile-item _720kb-datepicker-calendar-month">','<select ng-model="month" title="{{ dateMonthTitle }}" ng-change="selectedMonthHandle(month)">','<option ng-repeat="item in months" ng-selected="item === month" ng-disabled=\'!isSelectableMaxDate(item + " " + day + ", " + year) || !isSelectableMinDate(item + " " + day + ", " + year)\' ng-value="$index + 1" value="$index + 1">',"{{ item }}","</option>","</select>","</div>","</div>",'<div class="_720kb-datepicker-calendar-header">','<div class="_720kb-datepicker-calendar-header-middle _720kb-datepicker-mobile-item _720kb-datepicker-calendar-month">','<select ng-model="mobileYear" title="{{ dateYearTitle }}" ng-change="setNewYear(mobileYear)">','<option ng-repeat="item in paginationYears track by $index" ng-selected="year === item" ng-disabled="!isSelectableMinYear(item) || !isSelectableMaxYear(item)" ng-value="item" value="item">',"{{ item }}","</option>","</select>","</div>","</div>"]:['<div class="_720kb-datepicker-calendar-header">','<div class="_720kb-datepicker-calendar-header-left">','<a class="_720kb-datepicker-calendar-month-button" href="javascript:void(0)" ng-class="{\'_720kb-datepicker-item-hidden\': !willPrevMonthBeSelectable()}" ng-click="prevMonth()" title="{{ buttonPrevTitle }}">',e,"</a>","</div>",'<div class="_720kb-datepicker-calendar-header-middle _720kb-datepicker-calendar-month">',"{{month}}&nbsp;",'<a href="javascript:void(0)" ng-click="paginateYears(year); showYearsPagination = !showYearsPagination;">',"<span>","{{year}}","<i ng-class=\"{'_720kb-datepicker-calendar-header-closed-pagination': !showYearsPagination, '_720kb-datepicker-calendar-header-opened-pagination': showYearsPagination}\"></i>","</span>","</a>","</div>",'<div class="_720kb-datepicker-calendar-header-right">','<a class="_720kb-datepicker-calendar-month-button" ng-class="{\'_720kb-datepicker-item-hidden\': !willNextMonthBeSelectable()}" href="javascript:void(0)" ng-click="nextMonth()" title="{{ buttonNextTitle }}">',a,"</a>","</div>","</div>"]},i=function(e,a){return['<div class="_720kb-datepicker-calendar-header" ng-show="showYearsPagination">','<div class="_720kb-datepicker-calendar-years-pagination">','<a ng-class="{\'_720kb-datepicker-active\': y === year, \'_720kb-datepicker-disabled\': !isSelectableMaxYear(y) || !isSelectableMinYear(y)}" href="javascript:void(0)" ng-click="setNewYear(y)" ng-repeat="y in paginationYears track by $index">',"{{y}}","</a>","</div>",'<div class="_720kb-datepicker-calendar-years-pagination-pages">','<a href="javascript:void(0)" ng-click="paginateYears(paginationYears[0])" ng-class="{\'_720kb-datepicker-item-hidden\': paginationYearsPrevDisabled}">',e,"</a>",'<a href="javascript:void(0)" ng-click="paginateYears(paginationYears[paginationYears.length -1 ])" ng-class="{\'_720kb-datepicker-item-hidden\': paginationYearsNextDisabled}">',a,"</a>","</div>","</div>"]},r=function(e,a,t){var r=['<div class="_720kb-datepicker-calendar {{datepickerClass}} {{datepickerID}}" ng-class="{\'_720kb-datepicker-forced-to-open\': checkVisibility()}" ng-blur="hideCalendar()">',"</div>"],d=n(e,a,t),l=i(e,a),c=['<div class="_720kb-datepicker-calendar-days-header">','<div ng-repeat="d in daysInString">',"{{d}}","</div>","</div>"],o=['<div class="_720kb-datepicker-calendar-body">','<a href="javascript:void(0)" ng-repeat="px in prevMonthDays" class="_720kb-datepicker-calendar-day _720kb-datepicker-disabled">',"{{px}}","</a>","<a href=\"javascript:void(0)\" ng-repeat=\"item in days\" ng-click=\"setDatepickerDay(item)\" ng-class=\"{'_720kb-datepicker-active': selectedDay === item && selectedMonth === monthNumber && selectedYear === year, '_720kb-datepicker-disabled': !isSelectableMinDate(year + '/' + monthNumber + '/' + item ) || !isSelectableMaxDate(year + '/' + monthNumber + '/' + item) || !isSelectableDate(monthNumber, year, item) || !isSelectableDay(monthNumber, year, item),'_720kb-datepicker-today': item === today.getDate() && monthNumber === (today.getMonth() + 1) && year === today.getFullYear() && !selectedDay}\" class=\"_720kb-datepicker-calendar-day\">","{{item}}","</a>",'<a href="javascript:void(0)" ng-repeat="nx in nextMonthDays" class="_720kb-datepicker-calendar-day _720kb-datepicker-disabled">',"{{nx}}","</a>","</div>"],s=function(e){r.splice(r.length-1,0,e)};return d.forEach(s),l.forEach(s),c.forEach(s),o.forEach(s),r.join("")},d=function(a,n,i,d,l,c){return{restrict:"AEC",scope:{dateSet:"@",dateMinLimit:"@",dateMaxLimit:"@",dateMonthTitle:"@",dateYearTitle:"@",buttonNextTitle:"@",buttonPrevTitle:"@",dateDisabledDates:"@",dateEnabledDates:"@",dateDisabledWeekdays:"@",dateSetHidden:"@",dateTyper:"@",dateWeekStartDay:"@",datepickerAppendTo:"@",datepickerToggle:"@",datepickerClass:"@",datepickerShow:"@"},link:function(o,s,m){var u,b,h,y=m.selector,p=e.element(y?s[0].querySelector("."+y):s[0].children[0]),g=m.buttonPrev||'<b class="_720kb-datepicker-default-button">&lang;</b>',M=m.buttonNext||'<b class="_720kb-datepicker-default-button">&rang;</b>',k=m.dateFormat,f=o.$eval(o.dateDisabledDates),D=o.$eval(o.dateEnabledDates),v=o.$eval(o.dateDisabledWeekdays),N=new Date,S=!1,w=!1,x=void 0!==m.datepickerMobile&&"false"!==m.datepickerMobile,Y=i.DATETIME_FORMATS,T=r(g,M,x),_=function(){S||w||!u||o.hideCalendar()},L=function(e,a){var t,n,i,r,d,l=new Date(a,e,0).getDate(),c=new Date(a+"/"+e+"/1").getDay(),s=new Date(a+"/"+e+"/"+l).getDay(),m=[],u=[];for(o.days=[],o.dateWeekStartDay=o.validateWeekDay(o.dateWeekStartDay),d=(o.dateWeekStartDay+6)%7,t=1;t<=l;t+=1)o.days.push(t);if(c===o.dateWeekStartDay)o.prevMonthDays=[];else{for(i=c-o.dateWeekStartDay,c<o.dateWeekStartDay&&(i+=7),r=1===Number(e)?12:e-1,t=1;t<=new Date(a,r,0).getDate();t+=1)m.push(t);o.prevMonthDays=m.slice(-i)}if(s===d)o.nextMonthDays=[];else{for(n=6-s+o.dateWeekStartDay,s<o.dateWeekStartDay&&(n-=7),t=1;t<=n;t+=1)u.push(t);o.nextMonthDays=u}},$=function(){o.month=d("date")(new Date(o.dateMinLimit),"MMMM"),o.monthNumber=Number(d("date")(new Date(o.dateMinLimit),"MM")),o.day=Number(d("date")(new Date(o.dateMinLimit),"dd")),o.year=Number(d("date")(new Date(o.dateMinLimit),"yyyy")),L(o.monthNumber,o.year)},A=function(){o.month=d("date")(new Date(o.dateMaxLimit),"MMMM"),o.monthNumber=Number(d("date")(new Date(o.dateMaxLimit),"MM")),o.day=Number(d("date")(new Date(o.dateMaxLimit),"dd")),o.year=Number(d("date")(new Date(o.dateMaxLimit),"yyyy")),L(o.monthNumber,o.year)},P=function(){o.year=Number(o.year)-1},W=function(){o.year=Number(o.year)+1},E=function(e,a){var t,n,i,r,d,l,c,o,s,m=/(\[[^\[]*\])|(\\)?([Hh]mm(ss)?|MMMM|MMM|MM|M|dd?d?|yy?yy?y?|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|kk?|mm?|ss?|S{1,9}|x|X|zz?|ZZ?|.)/g;for(l=0;l<Y.MONTH.length;l+=1){if(o=Y.MONTH[l],s=Y.SHORTMONTH[l],-1!==e.indexOf(o)){e=e.replace(o,l+1);break}if(-1!==e.indexOf(s)){e=e.replace(s,l+1);break}}for(n=e.split(/\D/).filter(function(e){return e.length>0}),t=a.match(m).filter(function(e){return null!==e.match(/^[a-zA-Z]+$/i)}),l=0;l<t.length;l+=1)switch(c=t[l],!0){case-1!==c.indexOf("d"):r=n[l-(t.length-n.length)];break;case-1!==c.indexOf("M"):i=n[l-(t.length-n.length)];break;case-1!==c.indexOf("y"):d=n[l-(t.length-n.length)]}return new Date(d+"/"+i+"/"+r)},H=function(){if(!o.isSelectableMinDate(o.year+"/"+o.monthNumber+"/"+o.day)||!o.isSelectableMaxDate(o.year+"/"+o.monthNumber+"/"+o.day))return!1;var e=new Date(o.year+"/"+o.monthNumber+"/"+o.day);m.dateFormat?p.val(d("date")(e,k)):p.val(e),p.triggerHandler("input"),p.triggerHandler("change")},O={add:function(e,a){var t;e.className.indexOf(a)>-1||((t=e.className.split(" ")).push(a),e.className=t.join(" "))},remove:function(e,a){var t,n;if(-1!==e.className.indexOf(a)){for(n=e.className.split(" "),t=0;t<n.length;t+=1)if(n[t]===a){n=n.slice(0,t).concat(n.slice(t+1));break}e.className=n.join(" ")}}},F=function(){b=a.document.getElementsByClassName("_720kb-datepicker-calendar"),e.forEach(b,function(e,a){b[a].classList?b[a].classList.remove("_720kb-datepicker-open"):O.remove(b[a],"_720kb-datepicker-open")}),u.classList?(u.classList.add("_720kb-datepicker-open"),N=k?E(p[0].value.toString(),k):new Date(p[0].value.toString()),o.selectedMonth=Number(d("date")(N,"MM")),o.selectedDay=Number(d("date")(N,"dd")),o.selectedYear=Number(d("date")(N,"yyyy"))):O.add(u,"_720kb-datepicker-open"),o.today=new Date,c(function(){o.selectedDay?(o.year=o.selectedYear,o.monthNumber=o.selectedMonth):(o.year=o.today.getFullYear(),o.monthNumber=o.today.getMonth()+1),o.month=d("date")(new Date(o.year,o.monthNumber-1),"MMMM"),L(o.monthNumber,o.year)},0)},j=function(){return!!o.datepickerShow&&(N=k?E(p[0].value.toString(),k):new Date(p[0].value.toString()),o.selectedMonth=Number(d("date")(N,"MM")),o.selectedDay=Number(d("date")(N,"dd")),o.selectedYear=Number(d("date")(N,"yyyy")),o.$eval(o.datepickerShow))},I=o.$watch("dateSet",function(e){e&&!isNaN(Date.parse(e))&&(N=new Date(e),o.month=d("date")(N,"MMMM"),o.monthNumber=Number(d("date")(N,"MM")),o.day=Number(d("date")(N,"dd")),o.year=Number(d("date")(N,"yyyy")),L(o.monthNumber,o.year),"true"!==o.dateSetHidden&&H())}),C=o.$watch("dateMinLimit",function(e){e&&$()}),B=o.$watch("dateMaxLimit",function(e){e&&A()}),G=o.$watch("dateFormat",function(e){e&&H()}),z=o.$watch("dateDisabledDates",function(e){e&&(f=o.$eval(e),o.isSelectableDate(o.monthNumber,o.year,o.day)||(p.val(""),p.triggerHandler("input"),p.triggerHandler("change")))}),R=o.$watch("dateEnabledDates",function(e){e&&(D=o.$eval(e),o.isSelectableDate(o.monthNumber,o.year,o.day)||(p.val(""),p.triggerHandler("input"),p.triggerHandler("change")))});for(o.nextMonth=function(){12===o.monthNumber?(o.monthNumber=1,W()):o.monthNumber+=1,o.dateMaxLimit&&(o.isSelectableMaxDate(o.year+"/"+o.monthNumber+"/"+o.days[0])||A()),o.month=d("date")(new Date(o.year,o.monthNumber-1),"MMMM"),L(o.monthNumber,o.year),o.day=void 0},o.willPrevMonthBeSelectable=function(){var e=o.monthNumber,a=o.year,t=d("date")(new Date(new Date(a+"/"+e+"/01").getTime()-864e5),"dd");return 1===e?(e=12,a-=1):e-=1,!(o.dateMinLimit&&!o.isSelectableMinDate(a+"/"+e+"/"+t))},o.willNextMonthBeSelectable=function(){var e=o.monthNumber,a=o.year;return 12===e?(e=1,a+=1):e+=1,!(o.dateMaxLimit&&!o.isSelectableMaxDate(a+"/"+e+"/01"))},o.prevMonth=function(){1===o.monthNumber?(o.monthNumber=12,P()):o.monthNumber-=1,o.dateMinLimit&&(o.isSelectableMinDate(o.year+"/"+o.monthNumber+"/"+o.days[o.days.length-1])||$()),o.month=d("date")(new Date(o.year,o.monthNumber-1),"MMMM"),L(o.monthNumber,o.year),o.day=void 0},o.selectedMonthHandle=function(e){o.monthNumber=Number(d("date")(new Date(e+"/01/2000"),"MM")),L(o.monthNumber,o.year),H()},o.setNewYear=function(e){if(t||(o.day=void 0),o.dateMaxLimit&&o.year<Number(e)){if(!o.isSelectableMaxYear(e))return}else if(o.dateMinLimit&&o.year>Number(e)&&!o.isSelectableMinYear(e))return;o.paginateYears(e),o.showYearsPagination=!1,c(function(){o.year=Number(e),L(o.monthNumber,o.year)},0)},o.hideCalendar=function(){u.classList?u.classList.remove("_720kb-datepicker-open"):O.remove(u,"_720kb-datepicker-open")},o.setDatepickerDay=function(e){o.isSelectableDay(o.monthNumber,o.year,e)&&o.isSelectableDate(o.monthNumber,o.year,e)&&o.isSelectableMaxDate(o.year+"/"+o.monthNumber+"/"+e)&&o.isSelectableMinDate(o.year+"/"+o.monthNumber+"/"+e)&&(o.day=Number(e),o.selectedDay=o.day,o.selectedMonth=o.monthNumber,o.selectedYear=o.year,H(),m.hasOwnProperty("dateRefocus")&&p[0].focus(),o.hideCalendar())},o.paginateYears=function(e){var a,n=[],i=10,r=10;for(o.paginationYears=[],t&&(i=50,r=50,o.dateMinLimit&&o.dateMaxLimit&&(i=(e=new Date(o.dateMaxLimit).getFullYear())-new Date(o.dateMinLimit).getFullYear(),r=1)),a=i;a>0;a-=1)n.push(Number(e)-a);for(a=0;a<r;a+=1)n.push(Number(e)+a);"true"===o.dateTyper&&p.on("keyup blur",function(){if(p[0].value&&p[0].value.length&&p[0].value.length>0)try{(N=k?E(p[0].value.toString(),k):new Date(p[0].value.toString())).getFullYear()&&!isNaN(N.getDay())&&!isNaN(N.getMonth())&&o.isSelectableDay(N.getMonth(),N.getFullYear(),N.getDay())&&o.isSelectableDate(N.getMonth(),N.getFullYear(),N.getDay())&&o.isSelectableMaxDate(N)&&o.isSelectableMinDate(N)&&o.$apply(function(){o.month=d("date")(N,"MMMM"),o.monthNumber=Number(d("date")(N,"MM")),o.day=Number(d("date")(N,"dd")),4===N.getFullYear().toString().length&&(o.year=Number(d("date")(N,"yyyy"))),L(o.monthNumber,o.year)})}catch(e){return e}}),o.dateMaxLimit&&n&&n.length&&!o.isSelectableMaxYear(Number(n[n.length-1])+1)?o.paginationYearsNextDisabled=!0:o.paginationYearsNextDisabled=!1,o.dateMinLimit&&n&&n.length&&!o.isSelectableMinYear(Number(n[0])-1)?o.paginationYearsPrevDisabled=!0:o.paginationYearsPrevDisabled=!1,o.paginationYears=n},o.isSelectableDay=function(e,a,t){var n=0;if(v&&v.length>0)for(n;n<=v.length;n+=1)if(v[n]===new Date(e+"/"+t+"/"+a).getDay())return!1;return!0},o.isSelectableDate=function(e,a,t){var n=0;if(f&&f.length>0)for(n;n<=f.length;n+=1)if(new Date(f[n]).getTime()===new Date(e+"/"+t+"/"+a).getTime())return!1;if(D){for(n;n<=D.length;n+=1)if(new Date(D[n]).getTime()===new Date(e+"/"+t+"/"+a).getTime())return!0;return!1}return!0},o.isSelectableMinDate=function(e){return!(o.dateMinLimit&&new Date(o.dateMinLimit)&&new Date(e).getTime()<new Date(o.dateMinLimit).getTime())},o.isSelectableMaxDate=function(e){return!(o.dateMaxLimit&&new Date(o.dateMaxLimit)&&new Date(e).getTime()>new Date(o.dateMaxLimit).getTime())},o.isSelectableMaxYear=function(e){return!(o.dateMaxLimit&&e>new Date(o.dateMaxLimit).getFullYear())},o.isSelectableMinYear=function(e){return!(o.dateMinLimit&&e<new Date(o.dateMinLimit).getFullYear())},o.validateWeekDay=function(e){var a=Number(e,10);return(!a||a<0||a>6)&&(a=0),a},T=T.replace(/{{/g,l.startSymbol()).replace(/}}/g,l.endSymbol()),o.dateMonthTitle=o.dateMonthTitle||"Select month",o.dateYearTitle=o.dateYearTitle||"Select year",o.buttonNextTitle=o.buttonNextTitle||"Next",o.buttonPrevTitle=o.buttonPrevTitle||"Prev",o.month=d("date")(N,"MMMM"),o.monthNumber=Number(d("date")(N,"MM")),o.day=Number(d("date")(N,"dd")),o.dateWeekStartDay=o.validateWeekDay(o.dateWeekStartDay),o.dateMaxLimit?o.year=Number(d("date")(new Date(o.dateMaxLimit),"yyyy")):o.year=Number(d("date")(N,"yyyy")),o.months=Y.MONTH,o.daysInString=[],h=o.dateWeekStartDay;h<=o.dateWeekStartDay+6;h+=1)o.daysInString.push(h%7);o.daysInString=o.daysInString.map(function(e){return d("date")(new Date(new Date("06/08/2014").valueOf()+864e5*e),"EEE")}),o.datepickerAppendTo&&-1!==o.datepickerAppendTo.indexOf(".")?(o.datepickerID="datepicker-id-"+(new Date).getTime()+(Math.floor(6*Math.random())+8),e.element(document.getElementsByClassName(o.datepickerAppendTo.replace(".",""))[0]).append(n(e.element(T))(o,function(a){u=e.element(a)[0]}))):o.datepickerAppendTo&&-1!==o.datepickerAppendTo.indexOf("#")?(o.datepickerID="datepicker-id-"+(new Date).getTime()+(Math.floor(6*Math.random())+8),e.element(document.getElementById(o.datepickerAppendTo.replace("#",""))).append(n(e.element(T))(o,function(a){u=e.element(a)[0]}))):o.datepickerAppendTo&&"body"===o.datepickerAppendTo?(o.datepickerID="datepicker-id-"+((new Date).getTime()+(Math.floor(6*Math.random())+8)),e.element(document).find("body").append(n(e.element(T))(o,function(a){u=e.element(a)[0]}))):(p.after(n(e.element(T))(o)),u=s[0].querySelector("._720kb-datepicker-calendar")),function(){return!o.datepickerToggle||o.$eval(o.datepickerToggle)}()&&p.on("focus click focusin",function(){w=!0,S||w||!u?F():o.hideCalendar()}),p.on("focusout blur",function(){w=!1}),e.element(u).on("mouseenter",function(){S=!0}),e.element(u).on("mouseleave",function(){S=!1}),e.element(u).on("focusin",function(){S=!0}),e.element(a).on("click focus focusin",_),(o.dateMinLimit&&!o.isSelectableMinYear(o.year)||!o.isSelectableMinDate(o.year+"/"+o.monthNumber+"/"+o.day))&&$(),(o.dateMaxLimit&&!o.isSelectableMaxYear(o.year)||!o.isSelectableMaxDate(o.year+"/"+o.monthNumber+"/"+o.day))&&A(),o.paginateYears(o.year),L(o.monthNumber,o.year),o.checkVisibility=j,o.$on("$destroy",function(){I(),C(),B(),G(),z(),R(),p.off("focus click focusout blur"),e.element(u).off("mouseenter mouseleave focusin"),e.element(a).off("click focus focusin",_)})}}};e.module("720kb.datepicker",[]).directive("datepicker",["$window","$compile","$locale","$filter","$interpolate","$timeout",d])}(angular,navigator);
//# sourceMappingURL=angular-datepicker.sourcemap.map
/**
 * State-based routing for AngularJS
 * @version v0.4.3
 * @link http://angular-ui.github.com/
 * @license MIT License, http://www.opensource.org/licenses/MIT
 */
"undefined"!=typeof module&&"undefined"!=typeof exports&&module.exports===exports&&(module.exports="ui.router"),function(a,b,c){"use strict";function d(a,b){return T(new(T(function(){},{prototype:a})),b)}function e(a){return S(arguments,function(b){b!==a&&S(b,function(b,c){a.hasOwnProperty(c)||(a[c]=b)})}),a}function f(a,b){var c=[];for(var d in a.path){if(a.path[d]!==b.path[d])break;c.push(a.path[d])}return c}function g(a){if(Object.keys)return Object.keys(a);var b=[];return S(a,function(a,c){b.push(c)}),b}function h(a,b){if(Array.prototype.indexOf)return a.indexOf(b,Number(arguments[2])||0);var c=a.length>>>0,d=Number(arguments[2])||0;for(d=d<0?Math.ceil(d):Math.floor(d),d<0&&(d+=c);d<c;d++)if(d in a&&a[d]===b)return d;return-1}function i(a,b,c,d){var e,i=f(c,d),j={},k=[];for(var l in i)if(i[l]&&i[l].params&&(e=g(i[l].params),e.length))for(var m in e)h(k,e[m])>=0||(k.push(e[m]),j[e[m]]=a[e[m]]);return T({},j,b)}function j(a,b,c){if(!c){c=[];for(var d in a)c.push(d)}for(var e=0;e<c.length;e++){var f=c[e];if(a[f]!=b[f])return!1}return!0}function k(a,b){var c={};return S(a,function(a){c[a]=b[a]}),c}function l(a){var b={},c=Array.prototype.concat.apply(Array.prototype,Array.prototype.slice.call(arguments,1));return S(c,function(c){c in a&&(b[c]=a[c])}),b}function m(a){var b={},c=Array.prototype.concat.apply(Array.prototype,Array.prototype.slice.call(arguments,1));for(var d in a)-1==h(c,d)&&(b[d]=a[d]);return b}function n(a,b){var c=R(a),d=c?[]:{};return S(a,function(a,e){b(a,e)&&(d[c?d.length:e]=a)}),d}function o(a,b){var c=R(a)?[]:{};return S(a,function(a,d){c[d]=b(a,d)}),c}function p(a){return a.then(c,function(){})&&a}function q(a,b){var d=1,f=2,i={},j=[],k=i,l=T(a.when(i),{$$promises:i,$$values:i});this.study=function(i){function n(a,c){if(t[c]!==f){if(s.push(c),t[c]===d)throw s.splice(0,h(s,c)),new Error("Cyclic dependency: "+s.join(" -> "));if(t[c]=d,P(a))r.push(c,[function(){return b.get(a)}],j);else{var e=b.annotate(a);S(e,function(a){a!==c&&i.hasOwnProperty(a)&&n(i[a],a)}),r.push(c,a,e)}s.pop(),t[c]=f}}function o(a){return Q(a)&&a.then&&a.$$promises}if(!Q(i))throw new Error("'invocables' must be an object");var q=g(i||{}),r=[],s=[],t={};return S(i,n),i=s=t=null,function(d,f,g){function h(){--v||(w||e(u,f.$$values),s.$$values=u,s.$$promises=s.$$promises||!0,delete s.$$inheritedValues,n.resolve(u))}function i(a){s.$$failure=a,n.reject(a)}function j(c,e,f){function j(a){l.reject(a),i(a)}function k(){if(!N(s.$$failure))try{l.resolve(b.invoke(e,g,u)),l.promise.then(function(a){u[c]=a,h()},j)}catch(a){j(a)}}var l=a.defer(),m=0;S(f,function(a){t.hasOwnProperty(a)&&!d.hasOwnProperty(a)&&(m++,t[a].then(function(b){u[a]=b,--m||k()},j))}),m||k(),t[c]=p(l.promise)}if(o(d)&&g===c&&(g=f,f=d,d=null),d){if(!Q(d))throw new Error("'locals' must be an object")}else d=k;if(f){if(!o(f))throw new Error("'parent' must be a promise returned by $resolve.resolve()")}else f=l;var n=a.defer(),s=p(n.promise),t=s.$$promises={},u=T({},d),v=1+r.length/3,w=!1;if(p(s),N(f.$$failure))return i(f.$$failure),s;f.$$inheritedValues&&e(u,m(f.$$inheritedValues,q)),T(t,f.$$promises),f.$$values?(w=e(u,m(f.$$values,q)),s.$$inheritedValues=m(f.$$values,q),h()):(f.$$inheritedValues&&(s.$$inheritedValues=m(f.$$inheritedValues,q)),f.then(h,i));for(var x=0,y=r.length;x<y;x+=3)d.hasOwnProperty(r[x])?h():j(r[x],r[x+1],r[x+2]);return s}},this.resolve=function(a,b,c,d){return this.study(a)(b,c,d)}}function r(){var a=b.version.minor<3;this.shouldUnsafelyUseHttp=function(b){a=!!b},this.$get=["$http","$templateCache","$injector",function(b,c,d){return new s(b,c,d,a)}]}function s(a,b,c,d){this.fromConfig=function(a,b,c){return N(a.template)?this.fromString(a.template,b):N(a.templateUrl)?this.fromUrl(a.templateUrl,b):N(a.templateProvider)?this.fromProvider(a.templateProvider,b,c):null},this.fromString=function(a,b){return O(a)?a(b):a},this.fromUrl=function(e,f){return O(e)&&(e=e(f)),null==e?null:d?a.get(e,{cache:b,headers:{Accept:"text/html"}}).then(function(a){return a.data}):c.get("$templateRequest")(e)},this.fromProvider=function(a,b,d){return c.invoke(a,null,d||{params:b})}}function t(a,b,e){function f(b,c,d,e){if(q.push(b),o[b])return o[b];if(!/^\w+([-.]+\w+)*(?:\[\])?$/.test(b))throw new Error("Invalid parameter name '"+b+"' in pattern '"+a+"'");if(p[b])throw new Error("Duplicate parameter name '"+b+"' in pattern '"+a+"'");return p[b]=new W.Param(b,c,d,e),p[b]}function g(a,b,c,d){var e=["",""],f=a.replace(/[\\\[\]\^$*+?.()|{}]/g,"\\$&");if(!b)return f;switch(c){case!1:e=["(",")"+(d?"?":"")];break;case!0:f=f.replace(/\/$/,""),e=["(?:/(",")|/)?"];break;default:e=["("+c+"|",")?"]}return f+e[0]+b+e[1]}function h(e,f){var g,h,i,j,k;return g=e[2]||e[3],k=b.params[g],i=a.substring(m,e.index),h=f?e[4]:e[4]||("*"==e[1]?".*":null),h&&(j=W.type(h)||d(W.type("string"),{pattern:new RegExp(h,b.caseInsensitive?"i":c)})),{id:g,regexp:h,segment:i,type:j,cfg:k}}b=T({params:{}},Q(b)?b:{});var i,j=/([:*])([\w\[\]]+)|\{([\w\[\]]+)(?:\:\s*((?:[^{}\\]+|\\.|\{(?:[^{}\\]+|\\.)*\})+))?\}/g,k=/([:]?)([\w\[\].-]+)|\{([\w\[\].-]+)(?:\:\s*((?:[^{}\\]+|\\.|\{(?:[^{}\\]+|\\.)*\})+))?\}/g,l="^",m=0,n=this.segments=[],o=e?e.params:{},p=this.params=e?e.params.$$new():new W.ParamSet,q=[];this.source=a;for(var r,s,t;(i=j.exec(a))&&(r=h(i,!1),!(r.segment.indexOf("?")>=0));)s=f(r.id,r.type,r.cfg,"path"),l+=g(r.segment,s.type.pattern.source,s.squash,s.isOptional),n.push(r.segment),m=j.lastIndex;t=a.substring(m);var u=t.indexOf("?");if(u>=0){var v=this.sourceSearch=t.substring(u);if(t=t.substring(0,u),this.sourcePath=a.substring(0,m+u),v.length>0)for(m=0;i=k.exec(v);)r=h(i,!0),s=f(r.id,r.type,r.cfg,"search"),m=j.lastIndex}else this.sourcePath=a,this.sourceSearch="";l+=g(t)+(!1===b.strict?"/?":"")+"$",n.push(t),this.regexp=new RegExp(l,b.caseInsensitive?"i":c),this.prefix=n[0],this.$$paramNames=q}function u(a){T(this,a)}function v(){function a(a){return null!=a?a.toString().replace(/(~|\/)/g,function(a){return{"~":"~~","/":"~2F"}[a]}):a}function e(a){return null!=a?a.toString().replace(/(~~|~2F)/g,function(a){return{"~~":"~","~2F":"/"}[a]}):a}function f(){return{strict:p,caseInsensitive:m}}function i(a){return O(a)||R(a)&&O(a[a.length-1])}function j(){for(;w.length;){var a=w.shift();if(a.pattern)throw new Error("You cannot override a type's .pattern at runtime.");b.extend(r[a.name],l.invoke(a.def))}}function k(a){T(this,a||{})}W=this;var l,m=!1,p=!0,q=!1,r={},s=!0,w=[],x={string:{encode:a,decode:e,is:function(a){return null==a||!N(a)||"string"==typeof a},pattern:/[^\/]*/},int:{encode:a,decode:function(a){return parseInt(a,10)},is:function(a){return a!==c&&null!==a&&this.decode(a.toString())===a},pattern:/-?\d+/},bool:{encode:function(a){return a?1:0},decode:function(a){return 0!==parseInt(a,10)},is:function(a){return!0===a||!1===a},pattern:/0|1/},date:{encode:function(a){return this.is(a)?[a.getFullYear(),("0"+(a.getMonth()+1)).slice(-2),("0"+a.getDate()).slice(-2)].join("-"):c},decode:function(a){if(this.is(a))return a;var b=this.capture.exec(a);return b?new Date(b[1],b[2]-1,b[3]):c},is:function(a){return a instanceof Date&&!isNaN(a.valueOf())},equals:function(a,b){return this.is(a)&&this.is(b)&&a.toISOString()===b.toISOString()},pattern:/[0-9]{4}-(?:0[1-9]|1[0-2])-(?:0[1-9]|[1-2][0-9]|3[0-1])/,capture:/([0-9]{4})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])/},json:{encode:b.toJson,decode:b.fromJson,is:b.isObject,equals:b.equals,pattern:/[^\/]*/},any:{encode:b.identity,decode:b.identity,equals:b.equals,pattern:/.*/}};v.$$getDefaultValue=function(a){if(!i(a.value))return a.value;if(!l)throw new Error("Injectable functions cannot be called at configuration time");return l.invoke(a.value)},this.caseInsensitive=function(a){return N(a)&&(m=a),m},this.strictMode=function(a){return N(a)&&(p=a),p},this.defaultSquashPolicy=function(a){if(!N(a))return q;if(!0!==a&&!1!==a&&!P(a))throw new Error("Invalid squash policy: "+a+". Valid policies: false, true, arbitrary-string");return q=a,a},this.compile=function(a,b){return new t(a,T(f(),b))},this.isMatcher=function(a){if(!Q(a))return!1;var b=!0;return S(t.prototype,function(c,d){O(c)&&(b=b&&N(a[d])&&O(a[d]))}),b},this.type=function(a,b,c){if(!N(b))return r[a];if(r.hasOwnProperty(a))throw new Error("A type named '"+a+"' has already been defined.");return r[a]=new u(T({name:a},b)),c&&(w.push({name:a,def:c}),s||j()),this},S(x,function(a,b){r[b]=new u(T({name:b},a))}),r=d(r,{}),this.$get=["$injector",function(a){return l=a,s=!1,j(),S(x,function(a,b){r[b]||(r[b]=new u(a))}),this}],this.Param=function(a,d,e,f){function j(a){var b=Q(a)?g(a):[];return-1===h(b,"value")&&-1===h(b,"type")&&-1===h(b,"squash")&&-1===h(b,"array")&&(a={value:a}),a.$$fn=i(a.value)?a.value:function(){return a.value},a}function k(c,d,e){if(c.type&&d)throw new Error("Param '"+a+"' has two type configurations.");return d||(c.type?b.isString(c.type)?r[c.type]:c.type instanceof u?c.type:new u(c.type):"config"===e?r.any:r.string)}function m(){var b={array:"search"===f&&"auto"},c=a.match(/\[\]$/)?{array:!0}:{};return T(b,c,e).array}function p(a,b){var c=a.squash;if(!b||!1===c)return!1;if(!N(c)||null==c)return q;if(!0===c||P(c))return c;throw new Error("Invalid squash policy: '"+c+"'. Valid policies: false, true, or arbitrary string")}function s(a,b,d,e){var f,g,i=[{from:"",to:d||b?c:""},{from:null,to:d||b?c:""}];return f=R(a.replace)?a.replace:[],P(e)&&f.push({from:e,to:c}),g=o(f,function(a){return a.from}),n(i,function(a){return-1===h(g,a.from)}).concat(f)}function t(){if(!l)throw new Error("Injectable functions cannot be called at configuration time");var a=l.invoke(e.$$fn);if(null!==a&&a!==c&&!x.type.is(a))throw new Error("Default value ("+a+") for parameter '"+x.id+"' is not an instance of Type ("+x.type.name+")");return a}function v(a){function b(a){return function(b){return b.from===a}}function c(a){var c=o(n(x.replace,b(a)),function(a){return a.to});return c.length?c[0]:a}return a=c(a),N(a)?x.type.$normalize(a):t()}function w(){return"{Param:"+a+" "+d+" squash: '"+A+"' optional: "+z+"}"}var x=this;e=j(e),d=k(e,d,f);var y=m();d=y?d.$asArray(y,"search"===f):d,"string"!==d.name||y||"path"!==f||e.value!==c||(e.value="");var z=e.value!==c,A=p(e,z),B=s(e,y,z,A);T(this,{id:a,type:d,location:f,array:y,squash:A,replace:B,isOptional:z,value:v,dynamic:c,config:e,toString:w})},k.prototype={$$new:function(){return d(this,T(new k,{$$parent:this}))},$$keys:function(){for(var a=[],b=[],c=this,d=g(k.prototype);c;)b.push(c),c=c.$$parent;return b.reverse(),S(b,function(b){S(g(b),function(b){-1===h(a,b)&&-1===h(d,b)&&a.push(b)})}),a},$$values:function(a){var b={},c=this;return S(c.$$keys(),function(d){b[d]=c[d].value(a&&a[d])}),b},$$equals:function(a,b){var c=!0,d=this;return S(d.$$keys(),function(e){var f=a&&a[e],g=b&&b[e];d[e].type.equals(f,g)||(c=!1)}),c},$$validates:function(a){var d,e,f,g,h,i=this.$$keys();for(d=0;d<i.length&&(e=this[i[d]],(f=a[i[d]])!==c&&null!==f||!e.isOptional);d++){if(g=e.type.$normalize(f),!e.type.is(g))return!1;if(h=e.type.encode(g),b.isString(h)&&!e.type.pattern.exec(h))return!1}return!0},$$parent:c},this.ParamSet=k}function w(a,d){function e(a){var b=/^\^((?:\\[^a-zA-Z0-9]|[^\\\[\]\^$*+?.()|{}]+)*)/.exec(a.source);return null!=b?b[1].replace(/\\(.)/g,"$1"):""}function f(a,b){return a.replace(/\$(\$|\d{1,2})/,function(a,c){return b["$"===c?0:Number(c)]})}function g(a,b,c){if(!c)return!1;var d=a.invoke(b,b,{$match:c});return!N(d)||d}function h(d,e,f,g,h){function m(a,b,c){return"/"===q?a:b?q.slice(0,-1)+a:c?q.slice(1)+a:a}function n(a){function b(a){var b=a(f,d);return!!b&&(P(b)&&d.replace().url(b),!0)}if(!a||!a.defaultPrevented){p&&d.url();p=c;var e,g=j.length;for(e=0;e<g;e++)if(b(j[e]))return;k&&b(k)}}function o(){return i=i||e.$on("$locationChangeSuccess",n)}var p,q=g.baseHref(),r=d.url();return l||o(),{sync:function(){n()},listen:function(){return o()},update:function(a){if(a)return void(r=d.url());d.url()!==r&&(d.url(r),d.replace())},push:function(a,b,e){var f=a.format(b||{});null!==f&&b&&b["#"]&&(f+="#"+b["#"]),d.url(f),p=e&&e.$$avoidResync?d.url():c,e&&e.replace&&d.replace()},href:function(c,e,f){if(!c.validates(e))return null;var g=a.html5Mode();b.isObject(g)&&(g=g.enabled),g=g&&h.history;var i=c.format(e);if(f=f||{},g||null===i||(i="#"+a.hashPrefix()+i),null!==i&&e&&e["#"]&&(i+="#"+e["#"]),i=m(i,g,f.absolute),!f.absolute||!i)return i;var j=!g&&i?"/":"",k=d.port();return k=80===k||443===k?"":":"+k,[d.protocol(),"://",d.host(),k,j,i].join("")}}}var i,j=[],k=null,l=!1;this.rule=function(a){if(!O(a))throw new Error("'rule' must be a function");return j.push(a),this},this.otherwise=function(a){if(P(a)){var b=a;a=function(){return b}}else if(!O(a))throw new Error("'rule' must be a function");return k=a,this},this.when=function(a,b){var c,h=P(b);if(P(a)&&(a=d.compile(a)),!h&&!O(b)&&!R(b))throw new Error("invalid 'handler' in when()");var i={matcher:function(a,b){return h&&(c=d.compile(b),b=["$match",function(a){return c.format(a)}]),T(function(c,d){return g(c,b,a.exec(d.path(),d.search()))},{prefix:P(a.prefix)?a.prefix:""})},regex:function(a,b){if(a.global||a.sticky)throw new Error("when() RegExp must not be global or sticky");return h&&(c=b,b=["$match",function(a){return f(c,a)}]),T(function(c,d){return g(c,b,a.exec(d.path()))},{prefix:e(a)})}},j={matcher:d.isMatcher(a),regex:a instanceof RegExp};for(var k in j)if(j[k])return this.rule(i[k](a,b));throw new Error("invalid 'what' in when()")},this.deferIntercept=function(a){a===c&&(a=!0),l=a},this.$get=h,h.$inject=["$location","$rootScope","$injector","$browser","$sniffer"]}function x(a,e){function f(a){return 0===a.indexOf(".")||0===a.indexOf("^")}function m(a,b){if(!a)return c;var d=P(a),e=d?a:a.name;if(f(e)){if(!b)throw new Error("No reference point given for path '"+e+"'");b=m(b);for(var g=e.split("."),h=0,i=g.length,j=b;h<i;h++)if(""!==g[h]||0!==h){if("^"!==g[h])break;if(!j.parent)throw new Error("Path '"+e+"' not valid for state '"+b.name+"'");j=j.parent}else j=b;g=g.slice(h).join("."),e=j.name+(j.name&&g?".":"")+g}var k=A[e];return!k||!d&&(d||k!==a&&k.self!==a)?c:k}function n(a,b){B[a]||(B[a]=[]),B[a].push(b)}function q(a){for(var b=B[a]||[];b.length;)r(b.shift())}function r(b){b=d(b,{self:b,resolve:b.resolve||{},toString:function(){return this.name}});var c=b.name;if(!P(c)||c.indexOf("@")>=0)throw new Error("State must have a valid name");if(A.hasOwnProperty(c))throw new Error("State '"+c+"' is already defined");var e=-1!==c.indexOf(".")?c.substring(0,c.lastIndexOf(".")):P(b.parent)?b.parent:Q(b.parent)&&P(b.parent.name)?b.parent.name:"";if(e&&!A[e])return n(e,b.self);for(var f in D)O(D[f])&&(b[f]=D[f](b,D.$delegates[f]));return A[c]=b,!b[C]&&b.url&&a.when(b.url,["$match","$stateParams",function(a,c){z.$current.navigable==b&&j(a,c)||z.transitionTo(b,a,{inherit:!0,location:!1})}]),q(c),b}function s(a){return a.indexOf("*")>-1}function t(a){for(var b=a.split("."),c=z.$current.name.split("."),d=0,e=b.length;d<e;d++)"*"===b[d]&&(c[d]="*");return"**"===b[0]&&(c=c.slice(h(c,b[1])),c.unshift("**")),"**"===b[b.length-1]&&(c.splice(h(c,b[b.length-2])+1,Number.MAX_VALUE),c.push("**")),b.length==c.length&&c.join("")===b.join("")}function u(a,b){return P(a)&&!N(b)?D[a]:O(b)&&P(a)?(D[a]&&!D.$delegates[a]&&(D.$delegates[a]=D[a]),D[a]=b,this):this}function v(a,b){return Q(a)?b=a:b.name=a,r(b),this}function w(a,e,f,h,j,l,n,q,r){function u(b,c,d,f){var g=a.$broadcast("$stateNotFound",b,c,d);if(g.defaultPrevented)return n.update(),E;if(!g.retry)return null;if(f.$retry)return n.update(),F;var h=z.transition=e.when(g.retry);return h.then(function(){return h!==z.transition?(a.$broadcast("$stateChangeCancel",b.to,b.toParams,c,d),B):(b.options.$retry=!0,z.transitionTo(b.to,b.toParams,b.options))},function(){return E}),n.update(),h}function v(a,c,d,g,i,l){function m(){var c=[];return S(a.views,function(d,e){var g=d.resolve&&d.resolve!==a.resolve?d.resolve:{};g.$template=[function(){return f.load(e,{view:d,locals:i.globals,params:n,notify:l.notify})||""}],c.push(j.resolve(g,i.globals,i.resolve,a).then(function(c){if(O(d.controllerProvider)||R(d.controllerProvider)){var f=b.extend({},g,i.globals);c.$$controller=h.invoke(d.controllerProvider,null,f)}else c.$$controller=d.controller;c.$$state=a,c.$$controllerAs=d.controllerAs,c.$$resolveAs=d.resolveAs,i[e]=c}))}),e.all(c).then(function(){return i.globals})}var n=d?c:k(a.params.$$keys(),c),o={$stateParams:n};i.resolve=j.resolve(a.resolve,o,i.resolve,a);var p=[i.resolve.then(function(a){i.globals=a})];return g&&p.push(g),e.all(p).then(m).then(function(a){return i})}var w=new Error("transition superseded"),B=p(e.reject(w)),D=p(e.reject(new Error("transition prevented"))),E=p(e.reject(new Error("transition aborted"))),F=p(e.reject(new Error("transition failed")));return y.locals={resolve:null,globals:{$stateParams:{}}},z={params:{},current:y.self,$current:y,transition:null},z.reload=function(a){return z.transitionTo(z.current,l,{reload:a||!0,inherit:!1,notify:!0})},z.go=function(a,b,c){return z.transitionTo(a,b,T({inherit:!0,relative:z.$current},c))},z.transitionTo=function(b,c,f){c=c||{},f=T({location:!0,inherit:!1,relative:null,notify:!0,reload:!1,$retry:!1},f||{});var g,j=z.$current,o=z.params,q=j.path,r=m(b,f.relative),s=c["#"];if(!N(r)){var t={to:b,toParams:c,options:f},A=u(t,j.self,o,f);if(A)return A;if(b=t.to,c=t.toParams,f=t.options,r=m(b,f.relative),!N(r)){if(!f.relative)throw new Error("No such state '"+b+"'");throw new Error("Could not resolve '"+b+"' from state '"+f.relative+"'")}}if(r[C])throw new Error("Cannot transition to abstract state '"+b+"'");if(f.inherit&&(c=i(l,c||{},z.$current,r)),!r.params.$$validates(c))return F;c=r.params.$$values(c),b=r;var E=b.path,G=0,H=E[G],I=y.locals,J=[];if(f.reload){if(P(f.reload)||Q(f.reload)){if(Q(f.reload)&&!f.reload.name)throw new Error("Invalid reload state object");var K=!0===f.reload?q[0]:m(f.reload);if(f.reload&&!K)throw new Error("No such reload state '"+(P(f.reload)?f.reload:f.reload.name)+"'");for(;H&&H===q[G]&&H!==K;)I=J[G]=H.locals,G++,H=E[G]}}else for(;H&&H===q[G]&&H.ownParams.$$equals(c,o);)I=J[G]=H.locals,G++,H=E[G];if(x(b,c,j,o,I,f))return s&&(c["#"]=s),z.params=c,U(z.params,l),U(k(b.params.$$keys(),l),b.locals.globals.$stateParams),f.location&&b.navigable&&b.navigable.url&&(n.push(b.navigable.url,c,{$$avoidResync:!0,replace:"replace"===f.location}),n.update(!0)),z.transition=null,e.when(z.current);if(c=k(b.params.$$keys(),c||{}),s&&(c["#"]=s),f.notify&&a.$broadcast("$stateChangeStart",b.self,c,j.self,o,f).defaultPrevented)return a.$broadcast("$stateChangeCancel",b.self,c,j.self,o),null==z.transition&&n.update(),D;for(var L=e.when(I),M=G;M<E.length;M++,H=E[M])I=J[M]=d(I),L=v(H,c,H===b,L,I,f);var O=z.transition=L.then(function(){var d,e,g;if(z.transition!==O)return a.$broadcast("$stateChangeCancel",b.self,c,j.self,o),B;for(d=q.length-1;d>=G;d--)g=q[d],g.self.onExit&&h.invoke(g.self.onExit,g.self,g.locals.globals),g.locals=null;for(d=G;d<E.length;d++)e=E[d],e.locals=J[d],e.self.onEnter&&h.invoke(e.self.onEnter,e.self,e.locals.globals);return z.transition!==O?(a.$broadcast("$stateChangeCancel",b.self,c,j.self,o),B):(z.$current=b,z.current=b.self,z.params=c,U(z.params,l),z.transition=null,f.location&&b.navigable&&n.push(b.navigable.url,b.navigable.locals.globals.$stateParams,{$$avoidResync:!0,replace:"replace"===f.location}),f.notify&&a.$broadcast("$stateChangeSuccess",b.self,c,j.self,o),n.update(!0),z.current)}).then(null,function(d){return d===w?B:z.transition!==O?(a.$broadcast("$stateChangeCancel",b.self,c,j.self,o),B):(z.transition=null,g=a.$broadcast("$stateChangeError",b.self,c,j.self,o,d),g.defaultPrevented||n.update(),e.reject(d))});return p(O),O},z.is=function(a,b,d){d=T({relative:z.$current},d||{});var e=m(a,d.relative);return N(e)?z.$current===e&&(!b||g(b).reduce(function(a,c){var d=e.params[c];return a&&(!d||d.type.equals(l[c],b[c]))},!0)):c},z.includes=function(a,b,d){if(d=T({relative:z.$current},d||{}),P(a)&&s(a)){if(!t(a))return!1;a=z.$current.name}var e=m(a,d.relative);if(!N(e))return c;if(!N(z.$current.includes[e.name]))return!1;if(!b)return!0;for(var f=g(b),h=0;h<f.length;h++){var i=f[h],j=e.params[i];if(j&&!j.type.equals(l[i],b[i]))return!1}return g(b).reduce(function(a,c){var d=e.params[c];return a&&!d||d.type.equals(l[c],b[c])},!0)},z.href=function(a,b,d){d=T({lossy:!0,inherit:!0,absolute:!1,relative:z.$current},d||{});var e=m(a,d.relative);if(!N(e))return null;d.inherit&&(b=i(l,b||{},z.$current,e));var f=e&&d.lossy?e.navigable:e;return f&&f.url!==c&&null!==f.url?n.href(f.url,k(e.params.$$keys().concat("#"),b||{}),{absolute:d.absolute}):null},z.get=function(a,b){if(0===arguments.length)return o(g(A),function(a){return A[a].self});var c=m(a,b||z.$current);return c&&c.self?c.self:null},z}function x(a,b,c,d,e,f){function g(a,b,c){function d(b){return"search"!=a.params[b].location}var e=a.params.$$keys().filter(d),f=l.apply({},[a.params].concat(e));return new W.ParamSet(f).$$equals(b,c)}if(!f.reload&&a===c&&(e===c.locals||!1===a.self.reloadOnSearch&&g(c,d,b)))return!0}var y,z,A={},B={},C="abstract",D={parent:function(a){if(N(a.parent)&&a.parent)return m(a.parent);var b=/^(.+)\.[^.]+$/.exec(a.name);return b?m(b[1]):y},data:function(a){return a.parent&&a.parent.data&&(a.data=a.self.data=d(a.parent.data,a.data)),a.data},url:function(a){var b=a.url,c={params:a.params||{}};if(P(b))return"^"==b.charAt(0)?e.compile(b.substring(1),c):(a.parent.navigable||y).url.concat(b,c);if(!b||e.isMatcher(b))return b;throw new Error("Invalid url '"+b+"' in state '"+a+"'")},navigable:function(a){return a.url?a:a.parent?a.parent.navigable:null},ownParams:function(a){var b=a.url&&a.url.params||new W.ParamSet;return S(a.params||{},function(a,c){b[c]||(b[c]=new W.Param(c,null,a,"config"))}),b},params:function(a){var b=l(a.ownParams,a.ownParams.$$keys());return a.parent&&a.parent.params?T(a.parent.params.$$new(),b):new W.ParamSet},views:function(a){var b={};return S(N(a.views)?a.views:{"":a},function(c,d){d.indexOf("@")<0&&(d+="@"+a.parent.name),c.resolveAs=c.resolveAs||a.resolveAs||"$resolve",b[d]=c}),b},path:function(a){return a.parent?a.parent.path.concat(a):[]},includes:function(a){var b=a.parent?T({},a.parent.includes):{};return b[a.name]=!0,b},$delegates:{}};y=r({name:"",url:"^",views:null,abstract:!0}),y.navigable=null,this.decorator=u,this.state=v,this.$get=w,w.$inject=["$rootScope","$q","$view","$injector","$resolve","$stateParams","$urlRouter","$location","$urlMatcherFactory"]}function y(){function a(a,b){return{load:function(a,c){var d;return c=T({template:null,controller:null,view:null,locals:null,notify:!0,async:!0,params:{}},c),c.view&&(d=b.fromConfig(c.view,c.params,c.locals)),d}}}this.$get=a,a.$inject=["$rootScope","$templateFactory"]}function z(){var a=!1;this.useAnchorScroll=function(){a=!0},this.$get=["$anchorScroll","$timeout",function(b,c){return a?b:function(a){return c(function(){a[0].scrollIntoView()},0,!1)}}]}function A(a,c,d,e,f){function g(){return c.has?function(a){return c.has(a)?c.get(a):null}:function(a){try{return c.get(a)}catch(a){return null}}}function h(a,c){var d=function(){return{enter:function(a,b,c){b.after(a),c()},leave:function(a,b){a.remove(),b()}}};if(k)return{enter:function(a,c,d){b.version.minor>2?k.enter(a,null,c).then(d):k.enter(a,null,c,d)},leave:function(a,c){b.version.minor>2?k.leave(a).then(c):k.leave(a,c)}};if(j){var e=j&&j(c,a);return{enter:function(a,b,c){e.enter(a,null,b),c()},leave:function(a,b){e.leave(a),b()}}}return d()}var i=g(),j=i("$animator"),k=i("$animate");return{restrict:"ECA",terminal:!0,priority:400,transclude:"element",compile:function(c,g,i){return function(c,g,j){function k(){if(m&&(m.remove(),m=null),o&&(o.$destroy(),o=null),n){var a=n.data("$uiViewAnim");s.leave(n,function(){a.$$animLeave.resolve(),m=null}),m=n,n=null}}function l(h){var l,m=C(c,j,g,e),t=m&&a.$current&&a.$current.locals[m];if(h||t!==p){l=c.$new(),p=a.$current.locals[m],l.$emit("$viewContentLoading",m);var u=i(l,function(a){var e=f.defer(),h=f.defer(),i={$animEnter:e.promise,$animLeave:h.promise,$$animLeave:h};a.data("$uiViewAnim",i),s.enter(a,g,function(){e.resolve(),o&&o.$emit("$viewContentAnimationEnded"),(b.isDefined(r)&&!r||c.$eval(r))&&d(a)}),k()});n=u,o=l,o.$emit("$viewContentLoaded",m),o.$eval(q)}}var m,n,o,p,q=j.onload||"",r=j.autoscroll,s=h(j,c);g.inheritedData("$uiView");c.$on("$stateChangeSuccess",function(){l(!1)}),l(!0)}}}}function B(a,c,d,e){return{restrict:"ECA",priority:-400,compile:function(f){var g=f.html();return f.empty?f.empty():f[0].innerHTML=null,function(f,h,i){var j=d.$current,k=C(f,i,h,e),l=j&&j.locals[k];if(!l)return h.html(g),void a(h.contents())(f);h.data("$uiView",{name:k,state:l.$$state}),h.html(l.$template?l.$template:g);var m=b.extend({},l);f[l.$$resolveAs]=m;var n=a(h.contents());if(l.$$controller){l.$scope=f,l.$element=h;var o=c(l.$$controller,l);l.$$controllerAs&&(f[l.$$controllerAs]=o,f[l.$$controllerAs][l.$$resolveAs]=m),O(o.$onInit)&&o.$onInit(),h.data("$ngControllerController",o),h.children().data("$ngControllerController",o)}n(f)}}}}function C(a,b,c,d){var e=d(b.uiView||b.name||"")(a),f=c.inheritedData("$uiView");return e.indexOf("@")>=0?e:e+"@"+(f?f.state.name:"")}function D(a,b){var c,d=a.match(/^\s*({[^}]*})\s*$/);if(d&&(a=b+"("+d[1]+")"),!(c=a.replace(/\n/g," ").match(/^([^(]+?)\s*(\((.*)\))?$/))||4!==c.length)throw new Error("Invalid state ref '"+a+"'");return{state:c[1],paramExpr:c[3]||null}}function E(a){var b=a.parent().inheritedData("$uiView");if(b&&b.state&&b.state.name)return b.state}function F(a){var b="[object SVGAnimatedString]"===Object.prototype.toString.call(a.prop("href")),c="FORM"===a[0].nodeName;return{attr:c?"action":b?"xlink:href":"href",isAnchor:"A"===a.prop("tagName").toUpperCase(),clickable:!c}}function G(a,b,c,d,e){return function(f){var g=f.which||f.button,h=e();if(!(g>1||f.ctrlKey||f.metaKey||f.shiftKey||a.attr("target"))){var i=c(function(){b.go(h.state,h.params,h.options)});f.preventDefault();var j=d.isAnchor&&!h.href?1:0;f.preventDefault=function(){j--<=0&&c.cancel(i)}}}}function H(a,b){return{relative:E(a)||b.$current,inherit:!0}}function I(a,c){return{restrict:"A",require:["?^uiSrefActive","?^uiSrefActiveEq"],link:function(d,e,f,g){var h,i=D(f.uiSref,a.current.name),j={state:i.state,href:null,params:null},k=F(e),l=g[1]||g[0],m=null;j.options=T(H(e,a),f.uiSrefOpts?d.$eval(f.uiSrefOpts):{});var n=function(c){c&&(j.params=b.copy(c)),j.href=a.href(i.state,j.params,j.options),m&&m(),l&&(m=l.$$addStateInfo(i.state,j.params)),null!==j.href&&f.$set(k.attr,j.href)};i.paramExpr&&(d.$watch(i.paramExpr,function(a){a!==j.params&&n(a)},!0),j.params=b.copy(d.$eval(i.paramExpr))),n(),k.clickable&&(h=G(e,a,c,k,function(){return j}),e[e.on?"on":"bind"]("click",h),d.$on("$destroy",function(){e[e.off?"off":"unbind"]("click",h)}))}}}function J(a,b){return{restrict:"A",require:["?^uiSrefActive","?^uiSrefActiveEq"],link:function(c,d,e,f){function g(b){m.state=b[0],m.params=b[1],m.options=b[2],m.href=a.href(m.state,m.params,m.options),n&&n(),j&&(n=j.$$addStateInfo(m.state,m.params)),m.href&&e.$set(i.attr,m.href)}var h,i=F(d),j=f[1]||f[0],k=[e.uiState,e.uiStateParams||null,e.uiStateOpts||null],l="["+k.map(function(a){return a||"null"}).join(", ")+"]",m={state:null,params:null,options:null,href:null},n=null;c.$watch(l,g,!0),g(c.$eval(l)),i.clickable&&(h=G(d,a,b,i,function(){return m}),d[d.on?"on":"bind"]("click",h),c.$on("$destroy",function(){d[d.off?"off":"unbind"]("click",h)}))}}}function K(a,b,c){return{restrict:"A",controller:["$scope","$element","$attrs","$timeout",function(b,d,e,f){function g(b,c,e){var f=a.get(b,E(d)),g=h(b,c),i={state:f||{name:b},params:c,hash:g};return p.push(i),q[g]=e,function(){var a=p.indexOf(i);-1!==a&&p.splice(a,1)}}function h(a,c){if(!P(a))throw new Error("state should be a string");return Q(c)?a+V(c):(c=b.$eval(c),Q(c)?a+V(c):a)}function i(){for(var a=0;a<p.length;a++)l(p[a].state,p[a].params)?j(d,q[p[a].hash]):k(d,q[p[a].hash]),m(p[a].state,p[a].params)?j(d,n):k(d,n)}function j(a,b){f(function(){a.addClass(b)})}function k(a,b){a.removeClass(b)}function l(b,c){return a.includes(b.name,c)}function m(b,c){return a.is(b.name,c)}var n,o,p=[],q={};n=c(e.uiSrefActiveEq||"",!1)(b);try{o=b.$eval(e.uiSrefActive)}catch(a){}o=o||c(e.uiSrefActive||"",!1)(b),Q(o)&&S(o,function(c,d){if(P(c)){var e=D(c,a.current.name);g(e.state,b.$eval(e.paramExpr),d)}}),this.$$addStateInfo=function(a,b){if(!(Q(o)&&p.length>0)){var c=g(a,b,o);return i(),c}},b.$on("$stateChangeSuccess",i),i()}]}}function L(a){var b=function(b,c){return a.is(b,c)};return b.$stateful=!0,b}function M(a){var b=function(b,c,d){return a.includes(b,c,d)};return b.$stateful=!0,b}var N=b.isDefined,O=b.isFunction,P=b.isString,Q=b.isObject,R=b.isArray,S=b.forEach,T=b.extend,U=b.copy,V=b.toJson;b.module("ui.router.util",["ng"]),b.module("ui.router.router",["ui.router.util"]),b.module("ui.router.state",["ui.router.router","ui.router.util"]),b.module("ui.router",["ui.router.state"]),b.module("ui.router.compat",["ui.router"]),q.$inject=["$q","$injector"],b.module("ui.router.util").service("$resolve",q),b.module("ui.router.util").provider("$templateFactory",r);var W;t.prototype.concat=function(a,b){var c={caseInsensitive:W.caseInsensitive(),strict:W.strictMode(),squash:W.defaultSquashPolicy()};return new t(this.sourcePath+a+this.sourceSearch,T(c,b),this)},t.prototype.toString=function(){return this.source},t.prototype.exec=function(a,b){function c(a){function b(a){return a.split("").reverse().join("")}function c(a){return a.replace(/\\-/g,"-")}return o(o(b(a).split(/-(?!\\)/),b),c).reverse()}var d=this.regexp.exec(a);if(!d)return null;b=b||{};var e,f,g,h=this.parameters(),i=h.length,j=this.segments.length-1,k={};if(j!==d.length-1)throw new Error("Unbalanced capture group in route '"+this.source+"'");var l,m;for(e=0;e<j;e++){for(g=h[e],l=this.params[g],m=d[e+1],f=0;f<l.replace.length;f++)l.replace[f].from===m&&(m=l.replace[f].to);m&&!0===l.array&&(m=c(m)),N(m)&&(m=l.type.decode(m)),k[g]=l.value(m)}for(;e<i;e++){for(g=h[e],k[g]=this.params[g].value(b[g]),l=this.params[g],m=b[g],f=0;f<l.replace.length;f++)l.replace[f].from===m&&(m=l.replace[f].to);N(m)&&(m=l.type.decode(m)),k[g]=l.value(m)}return k},t.prototype.parameters=function(a){return N(a)?this.params[a]||null:this.$$paramNames},t.prototype.validates=function(a){return this.params.$$validates(a)},t.prototype.format=function(a){function b(a){return encodeURIComponent(a).replace(/-/g,function(a){return"%5C%"+a.charCodeAt(0).toString(16).toUpperCase()})}a=a||{};var c=this.segments,d=this.parameters(),e=this.params;if(!this.validates(a))return null;var f,g=!1,h=c.length-1,i=d.length,j=c[0];for(f=0;f<i;f++){var k=f<h,l=d[f],m=e[l],n=m.value(a[l]),p=m.isOptional&&m.type.equals(m.value(),n),q=!!p&&m.squash,r=m.type.encode(n);if(k){var s=c[f+1],t=f+1===h;if(!1===q)null!=r&&(R(r)?j+=o(r,b).join("-"):j+=encodeURIComponent(r)),j+=s;else if(!0===q){var u=j.match(/\/$/)?/\/?(.*)/:/(.*)/;j+=s.match(u)[1]}else P(q)&&(j+=q+s);t&&!0===m.squash&&"/"===j.slice(-1)&&(j=j.slice(0,-1))}else{if(null==r||p&&!1!==q)continue;if(R(r)||(r=[r]),0===r.length)continue;r=o(r,encodeURIComponent).join("&"+l+"="),j+=(g?"&":"?")+l+"="+r,g=!0}}return j},u.prototype.is=function(a,b){return!0},u.prototype.encode=function(a,b){return a},u.prototype.decode=function(a,b){return a},u.prototype.equals=function(a,b){return a==b},u.prototype.$subPattern=function(){var a=this.pattern.toString();return a.substr(1,a.length-2)},u.prototype.pattern=/.*/,u.prototype.toString=function(){return"{Type:"+this.name+"}"},u.prototype.$normalize=function(a){return this.is(a)?a:this.decode(a)},u.prototype.$asArray=function(a,b){function d(a,b){function d(a,b){return function(){return a[b].apply(a,arguments)}}function e(a){return R(a)?a:N(a)?[a]:[]}function f(a){switch(a.length){case 0:return c;case 1:return"auto"===b?a[0]:a;default:return a}}function g(a){return!a}function h(a,b){return function(c){if(R(c)&&0===c.length)return c;c=e(c);var d=o(c,a);return!0===b?0===n(d,g).length:f(d)}}function i(a){return function(b,c){var d=e(b),f=e(c);if(d.length!==f.length)return!1;for(var g=0;g<d.length;g++)if(!a(d[g],f[g]))return!1;return!0}}this.encode=h(d(a,"encode")),this.decode=h(d(a,"decode")),this.is=h(d(a,"is"),!0),this.equals=i(d(a,"equals")),this.pattern=a.pattern,this.$normalize=h(d(a,"$normalize")),this.name=a.name,this.$arrayMode=b}if(!a)return this;if("auto"===a&&!b)throw new Error("'auto' array mode is for query parameters only");return new d(this,a)},b.module("ui.router.util").provider("$urlMatcherFactory",v),b.module("ui.router.util").run(["$urlMatcherFactory",function(a){}]),w.$inject=["$locationProvider","$urlMatcherFactoryProvider"],b.module("ui.router.router").provider("$urlRouter",w),x.$inject=["$urlRouterProvider","$urlMatcherFactoryProvider"],b.module("ui.router.state").factory("$stateParams",function(){return{}}).constant("$state.runtime",{autoinject:!0}).provider("$state",x).run(["$injector",function(a){a.get("$state.runtime").autoinject&&a.get("$state")}]),y.$inject=[],b.module("ui.router.state").provider("$view",y),b.module("ui.router.state").provider("$uiViewScroll",z),A.$inject=["$state","$injector","$uiViewScroll","$interpolate","$q"],B.$inject=["$compile","$controller","$state","$interpolate"],b.module("ui.router.state").directive("uiView",A),b.module("ui.router.state").directive("uiView",B),I.$inject=["$state","$timeout"],J.$inject=["$state","$timeout"],K.$inject=["$state","$stateParams","$interpolate"],b.module("ui.router.state").directive("uiSref",I).directive("uiSrefActive",K).directive("uiSrefActiveEq",K).directive("uiState",J),L.$inject=["$state"],M.$inject=["$state"],b.module("ui.router.state").filter("isState",L).filter("includedByState",M)}(window,window.angular);
/*! 12.2.13 */
!function(){function a(a,b){window.XMLHttpRequest.prototype[a]=b(window.XMLHttpRequest.prototype[a])}function b(a,b,c){try{Object.defineProperty(a,b,{get:c})}catch(d){}}if(window.FileAPI||(window.FileAPI={}),!window.XMLHttpRequest)throw"AJAX is not supported. XMLHttpRequest is not defined.";if(FileAPI.shouldLoad=!window.FormData||FileAPI.forceLoad,FileAPI.shouldLoad){var c=function(a){if(!a.__listeners){a.upload||(a.upload={}),a.__listeners=[];var b=a.upload.addEventListener;a.upload.addEventListener=function(c,d){a.__listeners[c]=d,b&&b.apply(this,arguments)}}};a("open",function(a){return function(b,d,e){c(this),this.__url=d;try{a.apply(this,[b,d,e])}catch(f){f.message.indexOf("Access is denied")>-1&&(this.__origError=f,a.apply(this,[b,"_fix_for_ie_crossdomain__",e]))}}}),a("getResponseHeader",function(a){return function(b){return this.__fileApiXHR&&this.__fileApiXHR.getResponseHeader?this.__fileApiXHR.getResponseHeader(b):null==a?null:a.apply(this,[b])}}),a("getAllResponseHeaders",function(a){return function(){return this.__fileApiXHR&&this.__fileApiXHR.getAllResponseHeaders?this.__fileApiXHR.getAllResponseHeaders():null==a?null:a.apply(this)}}),a("abort",function(a){return function(){return this.__fileApiXHR&&this.__fileApiXHR.abort?this.__fileApiXHR.abort():null==a?null:a.apply(this)}}),a("setRequestHeader",function(a){return function(b,d){if("__setXHR_"===b){c(this);var e=d(this);e instanceof Function&&e(this)}else this.__requestHeaders=this.__requestHeaders||{},this.__requestHeaders[b]=d,a.apply(this,arguments)}}),a("send",function(a){return function(){var c=this;if(arguments[0]&&arguments[0].__isFileAPIShim){var d=arguments[0],e={url:c.__url,jsonp:!1,cache:!0,complete:function(a,d){a&&angular.isString(a)&&-1!==a.indexOf("#2174")&&(a=null),c.__completed=!0,!a&&c.__listeners.load&&c.__listeners.load({type:"load",loaded:c.__loaded,total:c.__total,target:c,lengthComputable:!0}),!a&&c.__listeners.loadend&&c.__listeners.loadend({type:"loadend",loaded:c.__loaded,total:c.__total,target:c,lengthComputable:!0}),"abort"===a&&c.__listeners.abort&&c.__listeners.abort({type:"abort",loaded:c.__loaded,total:c.__total,target:c,lengthComputable:!0}),void 0!==d.status&&b(c,"status",function(){return 0===d.status&&a&&"abort"!==a?500:d.status}),void 0!==d.statusText&&b(c,"statusText",function(){return d.statusText}),b(c,"readyState",function(){return 4}),void 0!==d.response&&b(c,"response",function(){return d.response});var e=d.responseText||(a&&0===d.status&&"abort"!==a?a:void 0);b(c,"responseText",function(){return e}),b(c,"response",function(){return e}),a&&b(c,"err",function(){return a}),c.__fileApiXHR=d,c.onreadystatechange&&c.onreadystatechange(),c.onload&&c.onload()},progress:function(a){if(a.target=c,c.__listeners.progress&&c.__listeners.progress(a),c.__total=a.total,c.__loaded=a.loaded,a.total===a.loaded){var b=this;setTimeout(function(){c.__completed||(c.getAllResponseHeaders=function(){},b.complete(null,{status:204,statusText:"No Content"}))},FileAPI.noContentTimeout||1e4)}},headers:c.__requestHeaders};e.data={},e.files={};for(var f=0;f<d.data.length;f++){var g=d.data[f];null!=g.val&&null!=g.val.name&&null!=g.val.size&&null!=g.val.type?e.files[g.key]=g.val:e.data[g.key]=g.val}setTimeout(function(){if(!FileAPI.hasFlash)throw'Adode Flash Player need to be installed. To check ahead use "FileAPI.hasFlash"';c.__fileApiXHR=FileAPI.upload(e)},1)}else{if(this.__origError)throw this.__origError;a.apply(c,arguments)}}}),window.XMLHttpRequest.__isFileAPIShim=!0,window.FormData=FormData=function(){return{append:function(a,b,c){b.__isFileAPIBlobShim&&(b=b.data[0]),this.data.push({key:a,val:b,name:c})},data:[],__isFileAPIShim:!0}},window.Blob=Blob=function(a){return{data:a,__isFileAPIBlobShim:!0}}}}(),function(){function a(a){return"input"===a[0].tagName.toLowerCase()&&a.attr("type")&&"file"===a.attr("type").toLowerCase()}function b(){try{var a=new ActiveXObject("ShockwaveFlash.ShockwaveFlash");if(a)return!0}catch(b){if(void 0!==navigator.mimeTypes["application/x-shockwave-flash"])return!0}return!1}function c(a){var b=0,c=0;if(window.jQuery)return jQuery(a).offset();if(a.offsetParent)do b+=a.offsetLeft-a.scrollLeft,c+=a.offsetTop-a.scrollTop,a=a.offsetParent;while(a);return{left:b,top:c}}if(FileAPI.shouldLoad){if(FileAPI.hasFlash=b(),FileAPI.forceLoad&&(FileAPI.html5=!1),!FileAPI.upload){var d,e,f,g,h,i=document.createElement("script"),j=document.getElementsByTagName("script");if(window.FileAPI.jsUrl)d=window.FileAPI.jsUrl;else if(window.FileAPI.jsPath)e=window.FileAPI.jsPath;else for(f=0;f<j.length;f++)if(h=j[f].src,g=h.search(/\/ng\-file\-upload[\-a-zA-z0-9\.]*\.js/),g>-1){e=h.substring(0,g+1);break}null==FileAPI.staticPath&&(FileAPI.staticPath=e),i.setAttribute("src",d||e+"FileAPI.min.js"),document.getElementsByTagName("head")[0].appendChild(i)}FileAPI.ngfFixIE=function(d,e,f){if(!b())throw'Adode Flash Player need to be installed. To check ahead use "FileAPI.hasFlash"';var g=function(){var b=e.parent();d.attr("disabled")?b&&b.removeClass("js-fileapi-wrapper"):(e.attr("__ngf_flash_")||(e.unbind("change"),e.unbind("click"),e.bind("change",function(a){h.apply(this,[a]),f.apply(this,[a])}),e.attr("__ngf_flash_","true")),b.addClass("js-fileapi-wrapper"),a(d)||(b.css("position","absolute").css("top",c(d[0]).top+"px").css("left",c(d[0]).left+"px").css("width",d[0].offsetWidth+"px").css("height",d[0].offsetHeight+"px").css("filter","alpha(opacity=0)").css("display",d.css("display")).css("overflow","hidden").css("z-index","900000").css("visibility","visible"),e.css("width",d[0].offsetWidth+"px").css("height",d[0].offsetHeight+"px").css("position","absolute").css("top","0px").css("left","0px")))};d.bind("mouseenter",g);var h=function(a){for(var b=FileAPI.getFiles(a),c=0;c<b.length;c++)void 0===b[c].size&&(b[c].size=0),void 0===b[c].name&&(b[c].name="file"),void 0===b[c].type&&(b[c].type="undefined");a.target||(a.target={}),a.target.files=b,a.target.files!==b&&(a.__files_=b),(a.__files_||a.target.files).item=function(b){return(a.__files_||a.target.files)[b]||null}}},FileAPI.disableFileInput=function(a,b){b?a.removeClass("js-fileapi-wrapper"):a.addClass("js-fileapi-wrapper")}}}(),window.FileReader||(window.FileReader=function(){var a=this,b=!1;this.listeners={},this.addEventListener=function(b,c){a.listeners[b]=a.listeners[b]||[],a.listeners[b].push(c)},this.removeEventListener=function(b,c){a.listeners[b]&&a.listeners[b].splice(a.listeners[b].indexOf(c),1)},this.dispatchEvent=function(b){var c=a.listeners[b.type];if(c)for(var d=0;d<c.length;d++)c[d].call(a,b)},this.onabort=this.onerror=this.onload=this.onloadstart=this.onloadend=this.onprogress=null;var c=function(b,c){var d={type:b,target:a,loaded:c.loaded,total:c.total,error:c.error};return null!=c.result&&(d.target.result=c.result),d},d=function(d){b||(b=!0,a.onloadstart&&a.onloadstart(c("loadstart",d)));var e;"load"===d.type?(a.onloadend&&a.onloadend(c("loadend",d)),e=c("load",d),a.onload&&a.onload(e),a.dispatchEvent(e)):"progress"===d.type?(e=c("progress",d),a.onprogress&&a.onprogress(e),a.dispatchEvent(e)):(e=c("error",d),a.onerror&&a.onerror(e),a.dispatchEvent(e))};this.readAsDataURL=function(a){FileAPI.readAsDataURL(a,d)},this.readAsText=function(a){FileAPI.readAsText(a,d)}});
/*! 12.2.13 */
!window.XMLHttpRequest||window.FileAPI&&FileAPI.shouldLoad||(window.XMLHttpRequest.prototype.setRequestHeader=function(a){return function(b,c){if("__setXHR_"===b){var d=c(this);d instanceof Function&&d(this)}else a.apply(this,arguments)}}(window.XMLHttpRequest.prototype.setRequestHeader));var ngFileUpload=angular.module("ngFileUpload",[]);ngFileUpload.version="12.2.13",ngFileUpload.service("UploadBase",["$http","$q","$timeout",function(a,b,c){function d(d){function e(a){j.notify&&j.notify(a),k.progressFunc&&c(function(){k.progressFunc(a)})}function h(a){return null!=d._start&&g?{loaded:a.loaded+d._start,total:d._file&&d._file.size||a.total,type:a.type,config:d,lengthComputable:!0,target:a.target}:a}function i(){a(d).then(function(a){if(g&&d._chunkSize&&!d._finished&&d._file){var b=d._file&&d._file.size||0;e({loaded:Math.min(d._end,b),total:b,config:d,type:"progress"}),f.upload(d,!0)}else d._finished&&delete d._finished,j.resolve(a)},function(a){j.reject(a)},function(a){j.notify(a)})}d.method=d.method||"POST",d.headers=d.headers||{};var j=d._deferred=d._deferred||b.defer(),k=j.promise;return d.disableProgress||(d.headers.__setXHR_=function(){return function(a){a&&a.upload&&a.upload.addEventListener&&(d.__XHR=a,d.xhrFn&&d.xhrFn(a),a.upload.addEventListener("progress",function(a){a.config=d,e(h(a))},!1),a.upload.addEventListener("load",function(a){a.lengthComputable&&(a.config=d,e(h(a)))},!1))}}),g?d._chunkSize&&d._end&&!d._finished?(d._start=d._end,d._end+=d._chunkSize,i()):d.resumeSizeUrl?a.get(d.resumeSizeUrl).then(function(a){d._start=d.resumeSizeResponseReader?d.resumeSizeResponseReader(a.data):parseInt((null==a.data.size?a.data:a.data.size).toString()),d._chunkSize&&(d._end=d._start+d._chunkSize),i()},function(a){throw a}):d.resumeSize?d.resumeSize().then(function(a){d._start=a,d._chunkSize&&(d._end=d._start+d._chunkSize),i()},function(a){throw a}):(d._chunkSize&&(d._start=0,d._end=d._start+d._chunkSize),i()):i(),k.success=function(a){return k.then(function(b){a(b.data,b.status,b.headers,d)}),k},k.error=function(a){return k.then(null,function(b){a(b.data,b.status,b.headers,d)}),k},k.progress=function(a){return k.progressFunc=a,k.then(null,null,function(b){a(b)}),k},k.abort=k.pause=function(){return d.__XHR&&c(function(){d.__XHR.abort()}),k},k.xhr=function(a){return d.xhrFn=function(b){return function(){b&&b.apply(k,arguments),a.apply(k,arguments)}}(d.xhrFn),k},f.promisesCount++,k["finally"]&&k["finally"]instanceof Function&&k["finally"](function(){f.promisesCount--}),k}function e(a){var b={};for(var c in a)a.hasOwnProperty(c)&&(b[c]=a[c]);return b}var f=this;f.promisesCount=0,this.isResumeSupported=function(){return window.Blob&&window.Blob.prototype.slice};var g=this.isResumeSupported();this.isUploadInProgress=function(){return f.promisesCount>0},this.rename=function(a,b){return a.ngfName=b,a},this.jsonBlob=function(a){null==a||angular.isString(a)||(a=JSON.stringify(a));var b=new window.Blob([a],{type:"application/json"});return b._ngfBlob=!0,b},this.json=function(a){return angular.toJson(a)},this.isFile=function(a){return null!=a&&(a instanceof window.Blob||a.flashId&&a.name&&a.size)},this.upload=function(a,b){function c(b,c){if(b._ngfBlob)return b;if(a._file=a._file||b,null!=a._start&&g){a._end&&a._end>=b.size&&(a._finished=!0,a._end=b.size);var d=b.slice(a._start,a._end||b.size);return d.name=b.name,d.ngfName=b.ngfName,a._chunkSize&&(c.append("_chunkSize",a._chunkSize),c.append("_currentChunkSize",a._end-a._start),c.append("_chunkNumber",Math.floor(a._start/a._chunkSize)),c.append("_totalSize",a._file.size)),d}return b}function h(b,d,e){if(void 0!==d)if(angular.isDate(d)&&(d=d.toISOString()),angular.isString(d))b.append(e,d);else if(f.isFile(d)){var g=c(d,b),i=e.split(",");i[1]&&(g.ngfName=i[1].replace(/^\s+|\s+$/g,""),e=i[0]),a._fileKey=a._fileKey||e,b.append(e,g,g.ngfName||g.name)}else if(angular.isObject(d)){if(d.$$ngfCircularDetection)throw"ngFileUpload: Circular reference in config.data. Make sure specified data for Upload.upload() has no circular reference: "+e;d.$$ngfCircularDetection=!0;try{for(var j in d)if(d.hasOwnProperty(j)&&"$$ngfCircularDetection"!==j){var k=null==a.objectKey?"[i]":a.objectKey;d.length&&parseInt(j)>-1&&(k=null==a.arrayKey?k:a.arrayKey),h(b,d[j],e+k.replace(/[ik]/g,j))}}finally{delete d.$$ngfCircularDetection}}else b.append(e,d)}function i(){a._chunkSize=f.translateScalars(a.resumeChunkSize),a._chunkSize=a._chunkSize?parseInt(a._chunkSize.toString()):null,a.headers=a.headers||{},a.headers["Content-Type"]=void 0,a.transformRequest=a.transformRequest?angular.isArray(a.transformRequest)?a.transformRequest:[a.transformRequest]:[],a.transformRequest.push(function(b){var c,d=new window.FormData;b=b||a.fields||{},a.file&&(b.file=a.file);for(c in b)if(b.hasOwnProperty(c)){var e=b[c];a.formDataAppender?a.formDataAppender(d,c,e):h(d,e,c)}return d})}return b||(a=e(a)),a._isDigested||(a._isDigested=!0,i()),d(a)},this.http=function(b){return b=e(b),b.transformRequest=b.transformRequest||function(b){return window.ArrayBuffer&&b instanceof window.ArrayBuffer||b instanceof window.Blob?b:a.defaults.transformRequest[0].apply(this,arguments)},b._chunkSize=f.translateScalars(b.resumeChunkSize),b._chunkSize=b._chunkSize?parseInt(b._chunkSize.toString()):null,d(b)},this.translateScalars=function(a){if(angular.isString(a)){if(a.search(/kb/i)===a.length-2)return parseFloat(1024*a.substring(0,a.length-2));if(a.search(/mb/i)===a.length-2)return parseFloat(1048576*a.substring(0,a.length-2));if(a.search(/gb/i)===a.length-2)return parseFloat(1073741824*a.substring(0,a.length-2));if(a.search(/b/i)===a.length-1)return parseFloat(a.substring(0,a.length-1));if(a.search(/s/i)===a.length-1)return parseFloat(a.substring(0,a.length-1));if(a.search(/m/i)===a.length-1)return parseFloat(60*a.substring(0,a.length-1));if(a.search(/h/i)===a.length-1)return parseFloat(3600*a.substring(0,a.length-1))}return a},this.urlToBlob=function(c){var d=b.defer();return a({url:c,method:"get",responseType:"arraybuffer"}).then(function(a){var b=new Uint8Array(a.data),e=a.headers("content-type")||"image/WebP",f=new window.Blob([b],{type:e}),g=c.match(/.*\/(.+?)(\?.*)?$/);g.length>1&&(f.name=g[1]),d.resolve(f)},function(a){d.reject(a)}),d.promise},this.setDefaults=function(a){this.defaults=a||{}},this.defaults={},this.version=ngFileUpload.version}]),ngFileUpload.service("Upload",["$parse","$timeout","$compile","$q","UploadExif",function(a,b,c,d,e){function f(a,b,c){var e=[i.emptyPromise()];return angular.forEach(a,function(d,f){0===d.type.indexOf("image/jpeg")&&i.attrGetter("ngfFixOrientation",b,c,{$file:d})&&e.push(i.happyPromise(i.applyExifRotation(d),d).then(function(b){a.splice(f,1,b)}))}),d.all(e)}function g(a,b,c,e){var f=i.attrGetter("ngfResize",b,c);if(!f||!i.isResizeSupported()||!a.length)return i.emptyPromise();if(f instanceof Function){var g=d.defer();return f(a).then(function(d){h(d,a,b,c,e).then(function(a){g.resolve(a)},function(a){g.reject(a)})},function(a){g.reject(a)})}return h(f,a,b,c,e)}function h(a,b,c,e,f){function g(d,g){if(0===d.type.indexOf("image")){if(a.pattern&&!i.validatePattern(d,a.pattern))return;a.resizeIf=function(a,b){return i.attrGetter("ngfResizeIf",c,e,{$width:a,$height:b,$file:d})};var j=i.resize(d,a);h.push(j),j.then(function(a){b.splice(g,1,a)},function(a){d.$error="resize",(d.$errorMessages=d.$errorMessages||{}).resize=!0,d.$errorParam=(a?(a.message?a.message:a)+": ":"")+(d&&d.name),f.$ngfValidations.push({name:"resize",valid:!1}),i.applyModelValidation(f,b)})}}for(var h=[i.emptyPromise()],j=0;j<b.length;j++)g(b[j],j);return d.all(h)}var i=e;return i.getAttrWithDefaults=function(a,b){if(null!=a[b])return a[b];var c=i.defaults[b];return null==c?c:angular.isString(c)?c:JSON.stringify(c)},i.attrGetter=function(b,c,d,e){var f=this.getAttrWithDefaults(c,b);if(!d)return f;try{return e?a(f)(d,e):a(f)(d)}catch(g){if(b.search(/min|max|pattern/i))return f;throw g}},i.shouldUpdateOn=function(a,b,c){var d=i.attrGetter("ngfModelOptions",b,c);return d&&d.updateOn?d.updateOn.split(" ").indexOf(a)>-1:!0},i.emptyPromise=function(){var a=d.defer(),c=arguments;return b(function(){a.resolve.apply(a,c)}),a.promise},i.rejectPromise=function(){var a=d.defer(),c=arguments;return b(function(){a.reject.apply(a,c)}),a.promise},i.happyPromise=function(a,c){var e=d.defer();return a.then(function(a){e.resolve(a)},function(a){b(function(){throw a}),e.resolve(c)}),e.promise},i.updateModel=function(c,d,e,h,j,k,l){function m(f,g,j,l,m){d.$$ngfPrevValidFiles=f,d.$$ngfPrevInvalidFiles=g;var n=f&&f.length?f[0]:null,o=g&&g.length?g[0]:null;c&&(i.applyModelValidation(c,f),c.$setViewValue(m?n:f)),h&&a(h)(e,{$files:f,$file:n,$newFiles:j,$duplicateFiles:l,$invalidFiles:g,$invalidFile:o,$event:k});var p=i.attrGetter("ngfModelInvalid",d);p&&b(function(){a(p).assign(e,m?o:g)}),b(function(){})}function n(){function a(a,b){return a.name===b.name&&(a.$ngfOrigSize||a.size)===(b.$ngfOrigSize||b.size)&&a.type===b.type}function b(b){var c;for(c=0;c<r.length;c++)if(a(b,r[c]))return!0;for(c=0;c<s.length;c++)if(a(b,s[c]))return!0;return!1}if(j){q=[],t=[];for(var c=0;c<j.length;c++)b(j[c])?t.push(j[c]):q.push(j[c])}}function o(a){return angular.isArray(a)?a:[a]}function p(){function a(){b(function(){m(w?r.concat(v):v,w?s.concat(u):u,j,t,x)},z&&z.debounce?z.debounce.change||z.debounce:0)}var f=y?q:v;g(f,d,e,c).then(function(){y?i.validate(q,w?r.length:0,c,d,e).then(function(b){v=b.validsFiles,u=b.invalidsFiles,a()}):a()},function(){for(var b=0;b<f.length;b++){var c=f[b];if("resize"===c.$error){var d=v.indexOf(c);d>-1&&(v.splice(d,1),u.push(c)),a()}}})}var q,r,s,t=[],u=[],v=[];r=d.$$ngfPrevValidFiles||[],s=d.$$ngfPrevInvalidFiles||[],c&&c.$modelValue&&(r=o(c.$modelValue));var w=i.attrGetter("ngfKeep",d,e);q=(j||[]).slice(0),("distinct"===w||i.attrGetter("ngfKeepDistinct",d,e)===!0)&&n(d,e);var x=!w&&!i.attrGetter("ngfMultiple",d,e)&&!i.attrGetter("multiple",d);if(!w||q.length){i.attrGetter("ngfBeforeModelChange",d,e,{$files:j,$file:j&&j.length?j[0]:null,$newFiles:q,$duplicateFiles:t,$event:k});var y=i.attrGetter("ngfValidateAfterResize",d,e),z=i.attrGetter("ngfModelOptions",d,e);i.validate(q,w?r.length:0,c,d,e).then(function(a){l?m(q,[],j,t,x):(z&&z.allowInvalid||y?v=q:(v=a.validFiles,u=a.invalidFiles),i.attrGetter("ngfFixOrientation",d,e)&&i.isExifSupported()?f(v,d,e).then(function(){p()}):p())})}},i}]),ngFileUpload.directive("ngfSelect",["$parse","$timeout","$compile","Upload",function(a,b,c,d){function e(a){var b=a.match(/Android[^\d]*(\d+)\.(\d+)/);if(b&&b.length>2){var c=d.defaults.androidFixMinorVersion||4;return parseInt(b[1])<4||parseInt(b[1])===c&&parseInt(b[2])<c}return-1===a.indexOf("Chrome")&&/.*Windows.*Safari.*/.test(a)}function f(a,b,c,d,f,h,i,j){function k(){return"input"===b[0].tagName.toLowerCase()&&c.type&&"file"===c.type.toLowerCase()}function l(){return t("ngfChange")||t("ngfSelect")}function m(b){if(j.shouldUpdateOn("change",c,a)){var e=b.__files_||b.target&&b.target.files,f=[];if(!e)return;for(var g=0;g<e.length;g++)f.push(e[g]);j.updateModel(d,c,a,l(),f.length?f:null,b)}}function n(a,d){function e(b){a.attr("id","ngf-"+b),d.attr("id","ngf-label-"+b)}for(var f=0;f<b[0].attributes.length;f++){var g=b[0].attributes[f];"type"!==g.name&&"class"!==g.name&&"style"!==g.name&&("id"===g.name?(e(g.value),u.push(c.$observe("id",e))):a.attr(g.name,g.value||"required"!==g.name&&"multiple"!==g.name?g.value:g.name))}}function o(){if(k())return b;var a=angular.element('<input type="file">'),c=angular.element("<label>upload</label>");return c.css("visibility","hidden").css("position","absolute").css("overflow","hidden").css("width","0px").css("height","0px").css("border","none").css("margin","0px").css("padding","0px").attr("tabindex","-1"),n(a,c),g.push({el:b,ref:c}),document.body.appendChild(c.append(a)[0]),a}function p(c){if(b.attr("disabled"))return!1;if(!t("ngfSelectDisabled",a)){var d=q(c);if(null!=d)return d;r(c);try{k()||document.body.contains(x[0])||(g.push({el:b,ref:x.parent()}),document.body.appendChild(x.parent()[0]),x.bind("change",m))}catch(f){}return e(navigator.userAgent)?setTimeout(function(){x[0].click()},0):x[0].click(),!1}}function q(a){var b=a.changedTouches||a.originalEvent&&a.originalEvent.changedTouches;if(b){if("touchstart"===a.type)return w=b[0].clientX,v=b[0].clientY,!0;if("touchend"===a.type){var c=b[0].clientX,d=b[0].clientY;if(Math.abs(c-w)>20||Math.abs(d-v)>20)return a.stopPropagation(),a.preventDefault(),!1}return!0}}function r(b){j.shouldUpdateOn("click",c,a)&&x.val()&&(x.val(null),j.updateModel(d,c,a,l(),null,b,!0))}function s(a){if(x&&!x.attr("__ngf_ie10_Fix_")){if(!x[0].parentNode)return void(x=null);a.preventDefault(),a.stopPropagation(),x.unbind("click");var b=x.clone();return x.replaceWith(b),x=b,x.attr("__ngf_ie10_Fix_","true"),x.bind("change",m),x.bind("click",s),x[0].click(),!1}x.removeAttr("__ngf_ie10_Fix_")}var t=function(a,b){return j.attrGetter(a,c,b)};j.registerModelChangeValidator(d,c,a);var u=[];t("ngfMultiple")&&u.push(a.$watch(t("ngfMultiple"),function(){x.attr("multiple",t("ngfMultiple",a))})),t("ngfCapture")&&u.push(a.$watch(t("ngfCapture"),function(){x.attr("capture",t("ngfCapture",a))})),t("ngfAccept")&&u.push(a.$watch(t("ngfAccept"),function(){x.attr("accept",t("ngfAccept",a))})),u.push(c.$observe("accept",function(){x.attr("accept",t("accept"))}));var v=0,w=0,x=b;k()||(x=o()),x.bind("change",m),k()?b.bind("click",r):b.bind("click touchstart touchend",p),-1!==navigator.appVersion.indexOf("MSIE 10")&&x.bind("click",s),d&&d.$formatters.push(function(a){return(null==a||0===a.length)&&x.val()&&x.val(null),a}),a.$on("$destroy",function(){k()||x.parent().remove(),angular.forEach(u,function(a){a()})}),h(function(){for(var a=0;a<g.length;a++){var b=g[a];document.body.contains(b.el[0])||(g.splice(a,1),b.ref.remove())}}),window.FileAPI&&window.FileAPI.ngfFixIE&&window.FileAPI.ngfFixIE(b,x,m)}var g=[];return{restrict:"AEC",require:"?ngModel",link:function(e,g,h,i){f(e,g,h,i,a,b,c,d)}}}]),function(){function a(a){return"img"===a.tagName.toLowerCase()?"image":"audio"===a.tagName.toLowerCase()?"audio":"video"===a.tagName.toLowerCase()?"video":/./}function b(b,c,d,e,f,g,h,i){function j(a){var g=b.attrGetter("ngfNoObjectUrl",f,d);b.dataUrl(a,g)["finally"](function(){c(function(){var b=(g?a.$ngfDataUrl:a.$ngfBlobUrl)||a.$ngfDataUrl;i?e.css("background-image","url('"+(b||"")+"')"):e.attr("src",b),b?e.removeClass("ng-hide"):e.addClass("ng-hide")})})}c(function(){var c=d.$watch(f[g],function(c){var k=h;if("ngfThumbnail"===g&&(k||(k={width:e[0].naturalWidth||e[0].clientWidth,height:e[0].naturalHeight||e[0].clientHeight}),0===k.width&&window.getComputedStyle)){var l=getComputedStyle(e[0]);l.width&&l.width.indexOf("px")>-1&&l.height&&l.height.indexOf("px")>-1&&(k={width:parseInt(l.width.slice(0,-2)),height:parseInt(l.height.slice(0,-2))})}return angular.isString(c)?(e.removeClass("ng-hide"),i?e.css("background-image","url('"+c+"')"):e.attr("src",c)):void(!c||!c.type||0!==c.type.search(a(e[0]))||i&&0!==c.type.indexOf("image")?e.addClass("ng-hide"):k&&b.isResizeSupported()?(k.resizeIf=function(a,e){return b.attrGetter("ngfResizeIf",f,d,{$width:a,$height:e,$file:c})},b.resize(c,k).then(function(a){j(a)},function(a){throw a})):j(c))});d.$on("$destroy",function(){c()})})}ngFileUpload.service("UploadDataUrl",["UploadBase","$timeout","$q",function(a,b,c){var d=a;return d.base64DataUrl=function(a){if(angular.isArray(a)){var b=c.defer(),e=0;return angular.forEach(a,function(c){d.dataUrl(c,!0)["finally"](function(){if(e++,e===a.length){var c=[];angular.forEach(a,function(a){c.push(a.$ngfDataUrl)}),b.resolve(c,a)}})}),b.promise}return d.dataUrl(a,!0)},d.dataUrl=function(a,e){if(!a)return d.emptyPromise(a,a);if(e&&null!=a.$ngfDataUrl||!e&&null!=a.$ngfBlobUrl)return d.emptyPromise(e?a.$ngfDataUrl:a.$ngfBlobUrl,a);var f=e?a.$$ngfDataUrlPromise:a.$$ngfBlobUrlPromise;if(f)return f;var g=c.defer();return b(function(){if(window.FileReader&&a&&(!window.FileAPI||-1===navigator.userAgent.indexOf("MSIE 8")||a.size<2e4)&&(!window.FileAPI||-1===navigator.userAgent.indexOf("MSIE 9")||a.size<4e6)){var c=window.URL||window.webkitURL;if(c&&c.createObjectURL&&!e){var f;try{f=c.createObjectURL(a)}catch(h){return void b(function(){a.$ngfBlobUrl="",g.reject()})}b(function(){if(a.$ngfBlobUrl=f,f){g.resolve(f,a),d.blobUrls=d.blobUrls||[],d.blobUrlsTotalSize=d.blobUrlsTotalSize||0,d.blobUrls.push({url:f,size:a.size}),d.blobUrlsTotalSize+=a.size||0;for(var b=d.defaults.blobUrlsMaxMemory||268435456,e=d.defaults.blobUrlsMaxQueueSize||200;(d.blobUrlsTotalSize>b||d.blobUrls.length>e)&&d.blobUrls.length>1;){var h=d.blobUrls.splice(0,1)[0];c.revokeObjectURL(h.url),d.blobUrlsTotalSize-=h.size}}})}else{var i=new FileReader;i.onload=function(c){b(function(){a.$ngfDataUrl=c.target.result,g.resolve(c.target.result,a),b(function(){delete a.$ngfDataUrl},1e3)})},i.onerror=function(){b(function(){a.$ngfDataUrl="",g.reject()})},i.readAsDataURL(a)}}else b(function(){a[e?"$ngfDataUrl":"$ngfBlobUrl"]="",g.reject()})}),f=e?a.$$ngfDataUrlPromise=g.promise:a.$$ngfBlobUrlPromise=g.promise,f["finally"](function(){delete a[e?"$$ngfDataUrlPromise":"$$ngfBlobUrlPromise"]}),f},d}]),ngFileUpload.directive("ngfSrc",["Upload","$timeout",function(a,c){return{restrict:"AE",link:function(d,e,f){b(a,c,d,e,f,"ngfSrc",a.attrGetter("ngfResize",f,d),!1)}}}]),ngFileUpload.directive("ngfBackground",["Upload","$timeout",function(a,c){return{restrict:"AE",link:function(d,e,f){b(a,c,d,e,f,"ngfBackground",a.attrGetter("ngfResize",f,d),!0)}}}]),ngFileUpload.directive("ngfThumbnail",["Upload","$timeout",function(a,c){return{restrict:"AE",link:function(d,e,f){var g=a.attrGetter("ngfSize",f,d);b(a,c,d,e,f,"ngfThumbnail",g,a.attrGetter("ngfAsBackground",f,d))}}}]),ngFileUpload.config(["$compileProvider",function(a){a.imgSrcSanitizationWhitelist&&a.imgSrcSanitizationWhitelist(/^\s*(https?|ftp|mailto|tel|webcal|local|file|data|blob):/),a.aHrefSanitizationWhitelist&&a.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|tel|webcal|local|file|data|blob):/)}]),ngFileUpload.filter("ngfDataUrl",["UploadDataUrl","$sce",function(a,b){return function(c,d,e){if(angular.isString(c))return b.trustAsResourceUrl(c);var f=c&&((d?c.$ngfDataUrl:c.$ngfBlobUrl)||c.$ngfDataUrl);return c&&!f?(!c.$ngfDataUrlFilterInProgress&&angular.isObject(c)&&(c.$ngfDataUrlFilterInProgress=!0,a.dataUrl(c,d)),""):(c&&delete c.$ngfDataUrlFilterInProgress,(c&&f?e?b.trustAsResourceUrl(f):f:c)||"")}}])}(),ngFileUpload.service("UploadValidate",["UploadDataUrl","$q","$timeout",function(a,b,c){function d(a){var b="",c=[];if(a.length>2&&"/"===a[0]&&"/"===a[a.length-1])b=a.substring(1,a.length-1);else{var e=a.split(",");if(e.length>1)for(var f=0;f<e.length;f++){var g=d(e[f]);g.regexp?(b+="("+g.regexp+")",f<e.length-1&&(b+="|")):c=c.concat(g.excludes)}else 0===a.indexOf("!")?c.push("^((?!"+d(a.substring(1)).regexp+").)*$"):(0===a.indexOf(".")&&(a="*"+a),b="^"+a.replace(new RegExp("[.\\\\+*?\\[\\^\\]$(){}=!<>|:\\-]","g"),"\\$&")+"$",b=b.replace(/\\\*/g,".*").replace(/\\\?/g,"."))}return{regexp:b,excludes:c}}function e(a,b){null==b||a.$dirty||(a.$setDirty?a.$setDirty():a.$dirty=!0)}var f=a;return f.validatePattern=function(a,b){if(!b)return!0;var c=d(b),e=!0;if(c.regexp&&c.regexp.length){var f=new RegExp(c.regexp,"i");e=null!=a.type&&f.test(a.type)||null!=a.name&&f.test(a.name)}for(var g=c.excludes.length;g--;){var h=new RegExp(c.excludes[g],"i");e=e&&(null==a.type||h.test(a.type))&&(null==a.name||h.test(a.name))}return e},f.ratioToFloat=function(a){var b=a.toString(),c=b.search(/[x:]/i);return b=c>-1?parseFloat(b.substring(0,c))/parseFloat(b.substring(c+1)):parseFloat(b)},f.registerModelChangeValidator=function(a,b,c){a&&a.$formatters.push(function(d){if(a.$dirty){var e=d;d&&!angular.isArray(d)&&(e=[d]),f.validate(e,0,a,b,c).then(function(){f.applyModelValidation(a,e)})}return d})},f.applyModelValidation=function(a,b){e(a,b),angular.forEach(a.$ngfValidations,function(b){a.$setValidity(b.name,b.valid)})},f.getValidationAttr=function(a,b,c,d,e){var g="ngf"+c[0].toUpperCase()+c.substr(1),h=f.attrGetter(g,a,b,{$file:e});if(null==h&&(h=f.attrGetter("ngfValidate",a,b,{$file:e}))){var i=(d||c).split(".");h=h[i[0]],i.length>1&&(h=h&&h[i[1]])}return h},f.validate=function(a,c,d,e,g){function h(b,c,h){if(a){for(var i=a.length,j=null;i--;){var n=a[i];if(n){var o=f.getValidationAttr(e,g,b,c,n);null!=o&&(h(n,o,i)||(-1===k.indexOf(b)?(n.$error=b,(n.$errorMessages=n.$errorMessages||{})[b]=!0,n.$errorParam=o,-1===m.indexOf(n)&&m.push(n),l||a.splice(i,1),j=!1):a.splice(i,1)))}}null!==j&&d.$ngfValidations.push({name:b,valid:j})}}function i(c,h,i,n,o){function p(b,d,e){function f(f){if(f())if(-1===k.indexOf(c)){if(d.$error=c,(d.$errorMessages=d.$errorMessages||{})[c]=!0,d.$errorParam=e,-1===m.indexOf(d)&&m.push(d),!l){var g=a.indexOf(d);g>-1&&a.splice(g,1)}b.resolve(!1)}else{var h=a.indexOf(d);h>-1&&a.splice(h,1),b.resolve(!0)}else b.resolve(!0)}null!=e?n(d,e).then(function(a){f(function(){return!o(a,e)})},function(){f(function(){return j("ngfValidateForce",{$file:d})})}):b.resolve(!0)}var q=[f.emptyPromise(!0)];a&&(a=void 0===a.length?[a]:a,angular.forEach(a,function(a){var d=b.defer();return q.push(d.promise),!i||null!=a.type&&0===a.type.search(i)?void("dimensions"===c&&null!=f.attrGetter("ngfDimensions",e)?f.imageDimensions(a).then(function(b){p(d,a,j("ngfDimensions",{$file:a,$width:b.width,$height:b.height}))},function(){d.resolve(!1)}):"duration"===c&&null!=f.attrGetter("ngfDuration",e)?f.mediaDuration(a).then(function(b){p(d,a,j("ngfDuration",{$file:a,$duration:b}))},function(){d.resolve(!1)}):p(d,a,f.getValidationAttr(e,g,c,h,a))):void d.resolve(!0)}));var r=b.defer();return b.all(q).then(function(a){for(var b=!0,e=0;e<a.length;e++)if(!a[e]){b=!1;break}d.$ngfValidations.push({name:c,valid:b}),r.resolve(b)}),r.promise}d=d||{},d.$ngfValidations=d.$ngfValidations||[],angular.forEach(d.$ngfValidations,function(a){a.valid=!0});var j=function(a,b){return f.attrGetter(a,e,g,b)},k=(f.attrGetter("ngfIgnoreInvalid",e,g)||"").split(" "),l=f.attrGetter("ngfRunAllValidations",e,g);if(null==a||0===a.length)return f.emptyPromise({validFiles:a,invalidFiles:[]});a=void 0===a.length?[a]:a.slice(0);var m=[];h("pattern",null,f.validatePattern),h("minSize","size.min",function(a,b){return a.size+.1>=f.translateScalars(b)}),h("maxSize","size.max",function(a,b){return a.size-.1<=f.translateScalars(b)});var n=0;if(h("maxTotalSize",null,function(b,c){return n+=b.size,n>f.translateScalars(c)?(a.splice(0,a.length),!1):!0}),h("validateFn",null,function(a,b){return b===!0||null===b||""===b}),!a.length)return f.emptyPromise({validFiles:[],invalidFiles:m});var o=b.defer(),p=[];return p.push(i("maxHeight","height.max",/image/,this.imageDimensions,function(a,b){return a.height<=b})),p.push(i("minHeight","height.min",/image/,this.imageDimensions,function(a,b){return a.height>=b})),p.push(i("maxWidth","width.max",/image/,this.imageDimensions,function(a,b){return a.width<=b})),p.push(i("minWidth","width.min",/image/,this.imageDimensions,function(a,b){return a.width>=b})),p.push(i("dimensions",null,/image/,function(a,b){return f.emptyPromise(b)},function(a){return a})),p.push(i("ratio",null,/image/,this.imageDimensions,function(a,b){for(var c=b.toString().split(","),d=!1,e=0;e<c.length;e++)Math.abs(a.width/a.height-f.ratioToFloat(c[e]))<.01&&(d=!0);return d})),p.push(i("maxRatio","ratio.max",/image/,this.imageDimensions,function(a,b){return a.width/a.height-f.ratioToFloat(b)<1e-4})),p.push(i("minRatio","ratio.min",/image/,this.imageDimensions,function(a,b){return a.width/a.height-f.ratioToFloat(b)>-1e-4})),p.push(i("maxDuration","duration.max",/audio|video/,this.mediaDuration,function(a,b){return a<=f.translateScalars(b)})),p.push(i("minDuration","duration.min",/audio|video/,this.mediaDuration,function(a,b){return a>=f.translateScalars(b)})),p.push(i("duration",null,/audio|video/,function(a,b){return f.emptyPromise(b)},function(a){return a})),p.push(i("validateAsyncFn",null,null,function(a,b){return b},function(a){return a===!0||null===a||""===a})),b.all(p).then(function(){if(l)for(var b=0;b<a.length;b++){var d=a[b];d.$error&&a.splice(b--,1)}l=!1,h("maxFiles",null,function(a,b,d){return b>c+d}),o.resolve({validFiles:a,invalidFiles:m})}),o.promise},f.imageDimensions=function(a){if(a.$ngfWidth&&a.$ngfHeight){var d=b.defer();return c(function(){d.resolve({width:a.$ngfWidth,height:a.$ngfHeight})}),d.promise}if(a.$ngfDimensionPromise)return a.$ngfDimensionPromise;var e=b.defer();return c(function(){return 0!==a.type.indexOf("image")?void e.reject("not image"):void f.dataUrl(a).then(function(b){function d(){var b=h[0].naturalWidth||h[0].clientWidth,c=h[0].naturalHeight||h[0].clientHeight;h.remove(),a.$ngfWidth=b,a.$ngfHeight=c,e.resolve({width:b,height:c})}function f(){h.remove(),e.reject("load error")}function g(){c(function(){h[0].parentNode&&(h[0].clientWidth?d():i++>10?f():g())},1e3)}var h=angular.element("<img>").attr("src",b).css("visibility","hidden").css("position","fixed").css("max-width","none !important").css("max-height","none !important");h.on("load",d),h.on("error",f);var i=0;g(),angular.element(document.getElementsByTagName("body")[0]).append(h)},function(){e.reject("load error")})}),a.$ngfDimensionPromise=e.promise,a.$ngfDimensionPromise["finally"](function(){delete a.$ngfDimensionPromise}),a.$ngfDimensionPromise},f.mediaDuration=function(a){if(a.$ngfDuration){var d=b.defer();return c(function(){d.resolve(a.$ngfDuration)}),d.promise}if(a.$ngfDurationPromise)return a.$ngfDurationPromise;var e=b.defer();return c(function(){return 0!==a.type.indexOf("audio")&&0!==a.type.indexOf("video")?void e.reject("not media"):void f.dataUrl(a).then(function(b){function d(){var b=h[0].duration;a.$ngfDuration=b,h.remove(),e.resolve(b)}function f(){h.remove(),e.reject("load error")}function g(){c(function(){h[0].parentNode&&(h[0].duration?d():i>10?f():g())},1e3)}var h=angular.element(0===a.type.indexOf("audio")?"<audio>":"<video>").attr("src",b).css("visibility","none").css("position","fixed");h.on("loadedmetadata",d),h.on("error",f);var i=0;g(),angular.element(document.body).append(h)},function(){e.reject("load error")})}),a.$ngfDurationPromise=e.promise,a.$ngfDurationPromise["finally"](function(){delete a.$ngfDurationPromise}),a.$ngfDurationPromise},f}]),ngFileUpload.service("UploadResize",["UploadValidate","$q",function(a,b){var c=a,d=function(a,b,c,d,e){var f=e?Math.max(c/a,d/b):Math.min(c/a,d/b);return{width:a*f,height:b*f,marginX:a*f-c,marginY:b*f-d}},e=function(a,e,f,g,h,i,j,k){var l=b.defer(),m=document.createElement("canvas"),n=document.createElement("img");return n.setAttribute("style","visibility:hidden;position:fixed;z-index:-100000"),document.body.appendChild(n),n.onload=function(){var a=n.width,b=n.height;if(n.parentNode.removeChild(n),null!=k&&k(a,b)===!1)return void l.reject("resizeIf");try{if(i){var o=c.ratioToFloat(i),p=a/b;o>p?(e=a,f=e/o):(f=b,e=f*o)}e||(e=a),f||(f=b);var q=d(a,b,e,f,j);m.width=Math.min(q.width,e),m.height=Math.min(q.height,f);var r=m.getContext("2d");r.drawImage(n,Math.min(0,-q.marginX/2),Math.min(0,-q.marginY/2),q.width,q.height),l.resolve(m.toDataURL(h||"image/WebP",g||.934))}catch(s){l.reject(s)}},n.onerror=function(){n.parentNode.removeChild(n),l.reject()},n.src=a,l.promise};return c.dataUrltoBlob=function(a,b,c){for(var d=a.split(","),e=d[0].match(/:(.*?);/)[1],f=atob(d[1]),g=f.length,h=new Uint8Array(g);g--;)h[g]=f.charCodeAt(g);var i=new window.Blob([h],{type:e});return i.name=b,i.$ngfOrigSize=c,i},c.isResizeSupported=function(){var a=document.createElement("canvas");return window.atob&&a.getContext&&a.getContext("2d")&&window.Blob},c.isResizeSupported()&&Object.defineProperty(window.Blob.prototype,"name",{get:function(){return this.$ngfName},set:function(a){this.$ngfName=a},configurable:!0}),c.resize=function(a,d){if(0!==a.type.indexOf("image"))return c.emptyPromise(a);var f=b.defer();return c.dataUrl(a,!0).then(function(b){e(b,d.width,d.height,d.quality,d.type||a.type,d.ratio,d.centerCrop,d.resizeIf).then(function(e){if("image/jpeg"===a.type&&d.restoreExif!==!1)try{e=c.restoreExif(b,e)}catch(g){setTimeout(function(){throw g},1)}try{var h=c.dataUrltoBlob(e,a.name,a.size);f.resolve(h)}catch(g){f.reject(g)}},function(b){"resizeIf"===b&&f.resolve(a),f.reject(b)})},function(a){f.reject(a)}),f.promise},c}]),function(){function a(a,c,d,e,f,g,h,i,j,k){function l(){return c.attr("disabled")||s("ngfDropDisabled",a)}function m(b,c,d){if(b){var e;try{e=b&&b.getData&&b.getData("text/html")}catch(f){}q(b.items,b.files,s("ngfAllowDir",a)!==!1,s("multiple")||s("ngfMultiple",a)).then(function(a){a.length?n(a,c):o(d,e).then(function(a){n(a,c)})})}}function n(b,c){i.updateModel(e,d,a,s("ngfChange")||s("ngfDrop"),b,c)}function o(b,c){if(!i.shouldUpdateOn(b,d,a)||"string"!=typeof c)return i.rejectPromise([]);var e=[];c.replace(/<(img src|img [^>]* src) *=\"([^\"]*)\"/gi,function(a,b,c){e.push(c)});var f=[],g=[];if(e.length){angular.forEach(e,function(a){f.push(i.urlToBlob(a).then(function(a){g.push(a)}))});var h=k.defer();return k.all(f).then(function(){h.resolve(g)},function(a){h.reject(a)}),h.promise}return i.emptyPromise()}function p(a,b,c,d){var e=s("ngfDragOverClass",a,{$event:c}),f="dragover";if(angular.isString(e))f=e;else if(e&&(e.delay&&(w=e.delay),e.accept||e.reject)){var g=c.dataTransfer.items;if(null!=g&&g.length)for(var h=e.pattern||s("ngfPattern",a,{$event:c}),j=g.length;j--;){if(!i.validatePattern(g[j],h)){f=e.reject;break}f=e.accept}else f=e.accept}d(f)}function q(b,c,e,f){function g(a,b){var c=k.defer();if(null!=a)if(a.isDirectory){var d=[i.emptyPromise()];if(m){var e={type:"directory"};e.name=e.path=(b||"")+a.name,n.push(e)}var f=a.createReader(),h=[],p=function(){f.readEntries(function(e){try{e.length?(h=h.concat(Array.prototype.slice.call(e||[],0)),p()):(angular.forEach(h.slice(0),function(c){n.length<=j&&l>=o&&d.push(g(c,(b?b:"")+a.name+"/"))}),k.all(d).then(function(){c.resolve()},function(a){c.reject(a)}))}catch(f){c.reject(f)}},function(a){c.reject(a)})};p()}else a.file(function(a){try{a.path=(b?b:"")+a.name,m&&(a=i.rename(a,a.path)),n.push(a),o+=a.size,c.resolve()}catch(d){c.reject(d)}},function(a){c.reject(a)});return c.promise}var j=i.getValidationAttr(d,a,"maxFiles");null==j&&(j=Number.MAX_VALUE);var l=i.getValidationAttr(d,a,"maxTotalSize");null==l&&(l=Number.MAX_VALUE);var m=s("ngfIncludeDir",a),n=[],o=0,p=[i.emptyPromise()];if(b&&b.length>0&&"file:"!==h.location.protocol)for(var q=0;q<b.length;q++){if(b[q].webkitGetAsEntry&&b[q].webkitGetAsEntry()&&b[q].webkitGetAsEntry().isDirectory){var r=b[q].webkitGetAsEntry();if(r.isDirectory&&!e)continue;null!=r&&p.push(g(r))}else{var t=b[q].getAsFile();null!=t&&(n.push(t),o+=t.size)}if(n.length>j||o>l||!f&&n.length>0)break}else if(null!=c)for(var u=0;u<c.length;u++){var v=c.item(u);if((v.type||v.size>0)&&(n.push(v),o+=v.size),n.length>j||o>l||!f&&n.length>0)break}var w=k.defer();return k.all(p).then(function(){if(f||m||!n.length)w.resolve(n);else{for(var a=0;n[a]&&"directory"===n[a].type;)a++;w.resolve([n[a]])}},function(a){w.reject(a)}),w.promise}var r=b(),s=function(a,b,c){return i.attrGetter(a,d,b,c)};if(s("dropAvailable")&&g(function(){a[s("dropAvailable")]?a[s("dropAvailable")].value=r:a[s("dropAvailable")]=r}),!r)return void(s("ngfHideOnDropNotAvailable",a)===!0&&c.css("display","none"));null==s("ngfSelect")&&i.registerModelChangeValidator(e,d,a);var t,u=null,v=f(s("ngfStopPropagation")),w=1;c[0].addEventListener("dragover",function(b){if(!l()&&i.shouldUpdateOn("drop",d,a)){if(b.preventDefault(),v(a)&&b.stopPropagation(),navigator.userAgent.indexOf("Chrome")>-1){var e=b.dataTransfer.effectAllowed;b.dataTransfer.dropEffect="move"===e||"linkMove"===e?"move":"copy"}g.cancel(u),t||(t="C",p(a,d,b,function(d){t=d,c.addClass(t),s("ngfDrag",a,{$isDragging:!0,$class:t,$event:b})}))}},!1),c[0].addEventListener("dragenter",function(b){!l()&&i.shouldUpdateOn("drop",d,a)&&(b.preventDefault(),v(a)&&b.stopPropagation())},!1),c[0].addEventListener("dragleave",function(b){!l()&&i.shouldUpdateOn("drop",d,a)&&(b.preventDefault(),
v(a)&&b.stopPropagation(),u=g(function(){t&&c.removeClass(t),t=null,s("ngfDrag",a,{$isDragging:!1,$event:b})},w||100))},!1),c[0].addEventListener("drop",function(b){!l()&&i.shouldUpdateOn("drop",d,a)&&(b.preventDefault(),v(a)&&b.stopPropagation(),t&&c.removeClass(t),t=null,m(b.dataTransfer,b,"dropUrl"))},!1),c[0].addEventListener("paste",function(b){navigator.userAgent.toLowerCase().indexOf("firefox")>-1&&s("ngfEnableFirefoxPaste",a)&&b.preventDefault(),!l()&&i.shouldUpdateOn("paste",d,a)&&m(b.clipboardData||b.originalEvent.clipboardData,b,"pasteUrl")},!1),navigator.userAgent.toLowerCase().indexOf("firefox")>-1&&s("ngfEnableFirefoxPaste",a)&&(c.attr("contenteditable",!0),c.on("keypress",function(a){a.metaKey||a.ctrlKey||a.preventDefault()}))}function b(){var a=document.createElement("div");return"draggable"in a&&"ondrop"in a&&!/Edge\/12./i.test(navigator.userAgent)}ngFileUpload.directive("ngfDrop",["$parse","$timeout","$window","Upload","$http","$q",function(b,c,d,e,f,g){return{restrict:"AEC",require:"?ngModel",link:function(h,i,j,k){a(h,i,j,k,b,c,d,e,f,g)}}}]),ngFileUpload.directive("ngfNoFileDrop",function(){return function(a,c){b()&&c.css("display","none")}}),ngFileUpload.directive("ngfDropAvailable",["$parse","$timeout","Upload",function(a,c,d){return function(e,f,g){if(b()){var h=a(d.attrGetter("ngfDropAvailable",g));c(function(){h(e),h.assign&&h.assign(e,!0)})}}}])}(),ngFileUpload.service("UploadExif",["UploadResize","$q",function(a,b){function c(a,b,c,d){switch(b){case 2:return a.transform(-1,0,0,1,c,0);case 3:return a.transform(-1,0,0,-1,c,d);case 4:return a.transform(1,0,0,-1,0,d);case 5:return a.transform(0,1,1,0,0,0);case 6:return a.transform(0,1,-1,0,d,0);case 7:return a.transform(0,-1,-1,0,d,c);case 8:return a.transform(0,-1,1,0,0,c)}}function d(a){for(var b="",c=new Uint8Array(a),d=c.byteLength,e=0;d>e;e++)b+=String.fromCharCode(c[e]);return window.btoa(b)}var e=a;return e.isExifSupported=function(){return window.FileReader&&(new FileReader).readAsArrayBuffer&&e.isResizeSupported()},e.readOrientation=function(a){var c=b.defer(),d=new FileReader,e=a.slice?a.slice(0,65536):a;return d.readAsArrayBuffer(e),d.onerror=function(a){return c.reject(a)},d.onload=function(a){var b={orientation:1},d=new DataView(this.result);if(65496!==d.getUint16(0,!1))return c.resolve(b);for(var e=d.byteLength,f=2;e>f;){var g=d.getUint16(f,!1);if(f+=2,65505===g){if(1165519206!==d.getUint32(f+=2,!1))return c.resolve(b);var h=18761===d.getUint16(f+=6,!1);f+=d.getUint32(f+4,h);var i=d.getUint16(f,h);f+=2;for(var j=0;i>j;j++)if(274===d.getUint16(f+12*j,h)){var k=d.getUint16(f+12*j+8,h);return k>=2&&8>=k&&(d.setUint16(f+12*j+8,1,h),b.fixedArrayBuffer=a.target.result),b.orientation=k,c.resolve(b)}}else{if(65280!==(65280&g))break;f+=d.getUint16(f,!1)}}return c.resolve(b)},c.promise},e.applyExifRotation=function(a){if(0!==a.type.indexOf("image/jpeg"))return e.emptyPromise(a);var f=b.defer();return e.readOrientation(a).then(function(b){return b.orientation<2||b.orientation>8?f.resolve(a):void e.dataUrl(a,!0).then(function(g){var h=document.createElement("canvas"),i=document.createElement("img");i.onload=function(){try{h.width=b.orientation>4?i.height:i.width,h.height=b.orientation>4?i.width:i.height;var g=h.getContext("2d");c(g,b.orientation,i.width,i.height),g.drawImage(i,0,0);var j=h.toDataURL(a.type||"image/WebP",.934);j=e.restoreExif(d(b.fixedArrayBuffer),j);var k=e.dataUrltoBlob(j,a.name);f.resolve(k)}catch(l){return f.reject(l)}},i.onerror=function(){f.reject()},i.src=g},function(a){f.reject(a)})},function(a){f.reject(a)}),f.promise},e.restoreExif=function(a,b){var c={};return c.KEY_STR="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",c.encode64=function(a){var b,c,d,e,f,g="",h="",i="",j=0;do b=a[j++],c=a[j++],h=a[j++],d=b>>2,e=(3&b)<<4|c>>4,f=(15&c)<<2|h>>6,i=63&h,isNaN(c)?f=i=64:isNaN(h)&&(i=64),g=g+this.KEY_STR.charAt(d)+this.KEY_STR.charAt(e)+this.KEY_STR.charAt(f)+this.KEY_STR.charAt(i),b=c=h="",d=e=f=i="";while(j<a.length);return g},c.restore=function(a,b){a.match("data:image/jpeg;base64,")&&(a=a.replace("data:image/jpeg;base64,",""));var c=this.decode64(a),d=this.slice2Segments(c),e=this.exifManipulation(b,d);return"data:image/jpeg;base64,"+this.encode64(e)},c.exifManipulation=function(a,b){var c=this.getExifArray(b),d=this.insertExif(a,c);return new Uint8Array(d)},c.getExifArray=function(a){for(var b,c=0;c<a.length;c++)if(b=a[c],255===b[0]&225===b[1])return b;return[]},c.insertExif=function(a,b){var c=a.replace("data:image/jpeg;base64,",""),d=this.decode64(c),e=d.indexOf(255,3),f=d.slice(0,e),g=d.slice(e),h=f;return h=h.concat(b),h=h.concat(g)},c.slice2Segments=function(a){for(var b=0,c=[];;){if(255===a[b]&218===a[b+1])break;if(255===a[b]&216===a[b+1])b+=2;else{var d=256*a[b+2]+a[b+3],e=b+d+2,f=a.slice(b,e);c.push(f),b=e}if(b>a.length)break}return c},c.decode64=function(a){var b,c,d,e,f,g="",h="",i=0,j=[],k=/[^A-Za-z0-9\+\/\=]/g;k.exec(a)&&console.log("There were invalid base64 characters in the input text.\nValid base64 characters are A-Z, a-z, 0-9, NaNExpect errors in decoding."),a=a.replace(/[^A-Za-z0-9\+\/\=]/g,"");do d=this.KEY_STR.indexOf(a.charAt(i++)),e=this.KEY_STR.indexOf(a.charAt(i++)),f=this.KEY_STR.indexOf(a.charAt(i++)),h=this.KEY_STR.indexOf(a.charAt(i++)),b=d<<2|e>>4,c=(15&e)<<4|f>>2,g=(3&f)<<6|h,j.push(b),64!==f&&j.push(c),64!==h&&j.push(g),b=c=g="",d=e=f=h="";while(i<a.length);return j},c.restore(a,b)},e}]);
/*! @flowjs/ng-flow 2.7.7 */
!function(a,b,c){"use strict";function d(b){if(this.support=!("undefined"==typeof File||"undefined"==typeof Blob||"undefined"==typeof FileList||!Blob.prototype.slice&&!Blob.prototype.webkitSlice&&!Blob.prototype.mozSlice),this.support){this.supportDirectory=/Chrome/.test(a.navigator.userAgent)||/Firefox/.test(a.navigator.userAgent)||/Edge/.test(a.navigator.userAgent),this.files=[],this.defaults={chunkSize:1048576,forceChunkSize:!1,simultaneousUploads:3,singleFile:!1,fileParameterName:"file",progressCallbacksInterval:500,speedSmoothingFactor:.1,query:{},headers:{},withCredentials:!1,preprocess:null,method:"multipart",testMethod:"GET",uploadMethod:"POST",prioritizeFirstAndLastChunk:!1,allowDuplicateUploads:!1,target:"/",testChunks:!0,generateUniqueIdentifier:null,maxChunkRetries:0,chunkRetryInterval:null,permanentErrors:[404,413,415,500,501],successStatuses:[200,201,202],onDropStopPropagation:!1,initFileFn:null,readFileFn:f},this.opts={},this.events={};var c=this;this.onDrop=function(a){c.opts.onDropStopPropagation&&a.stopPropagation(),a.preventDefault();var b=a.dataTransfer;b.items&&b.items[0]&&b.items[0].webkitGetAsEntry?c.webkitReadDataTransfer(a):c.addFiles(b.files,a)},this.preventEvent=function(a){a.preventDefault()},this.opts=d.extend({},this.defaults,b||{})}}function e(a,b,d){this.flowObj=a,this.bytes=null,this.file=b,this.name=b.fileName||b.name,this.size=b.size,this.relativePath=b.relativePath||b.webkitRelativePath||this.name,this.uniqueIdentifier=d===c?a.generateUniqueIdentifier(b):d,this.chunks=[],this.paused=!1,this.error=!1,this.averageSpeed=0,this.currentSpeed=0,this._lastProgressCallback=Date.now(),this._prevUploadedSize=0,this._prevProgress=0,this.bootstrap()}function f(a,b,c,d,e){var f="slice";a.file.slice?f="slice":a.file.mozSlice?f="mozSlice":a.file.webkitSlice&&(f="webkitSlice"),e.readFinished(a.file[f](b,c,d))}function g(a,b,c){this.flowObj=a,this.fileObj=b,this.offset=c,this.tested=!1,this.retries=0,this.pendingRetry=!1,this.preprocessState=0,this.readState=0,this.loaded=0,this.total=0,this.chunkSize=this.flowObj.opts.chunkSize,this.startByte=this.offset*this.chunkSize,this.computeEndByte=function(){var a=Math.min(this.fileObj.size,(this.offset+1)*this.chunkSize);return this.fileObj.size-a<this.chunkSize&&!this.flowObj.opts.forceChunkSize&&(a=this.fileObj.size),a},this.endByte=this.computeEndByte(),this.xhr=null;var d=this;this.event=function(a,b){b=Array.prototype.slice.call(arguments),b.unshift(d),d.fileObj.chunkEvent.apply(d.fileObj,b)},this.progressHandler=function(a){a.lengthComputable&&(d.loaded=a.loaded,d.total=a.total),d.event("progress",a)},this.testHandler=function(a){var b=d.status(!0);"error"===b?(d.event(b,d.message()),d.flowObj.uploadNextChunk()):"success"===b?(d.tested=!0,d.event(b,d.message()),d.flowObj.uploadNextChunk()):d.fileObj.paused||(d.tested=!0,d.send())},this.doneHandler=function(a){var b=d.status();if("success"===b||"error"===b)delete this.data,d.event(b,d.message()),d.flowObj.uploadNextChunk();else{d.event("retry",d.message()),d.pendingRetry=!0,d.abort(),d.retries++;var c=d.flowObj.opts.chunkRetryInterval;null!==c?setTimeout(function(){d.send()},c):d.send()}}}function h(a,b){var c=a.indexOf(b);c>-1&&a.splice(c,1)}function i(a,b){return"function"==typeof a&&(b=Array.prototype.slice.call(arguments),a=a.apply(null,b.slice(1))),a}function j(a,b){setTimeout(a.bind(b),0)}function k(a,b){return l(arguments,function(b){b!==a&&l(b,function(b,c){a[c]=b})}),a}function l(a,b,c){if(a){var d;if("undefined"!=typeof a.length){for(d=0;d<a.length;d++)if(b.call(c,a[d],d)===!1)return}else for(d in a)if(a.hasOwnProperty(d)&&b.call(c,a[d],d)===!1)return}}var m=a.navigator.msPointerEnabled;d.prototype={on:function(a,b){a=a.toLowerCase(),this.events.hasOwnProperty(a)||(this.events[a]=[]),this.events[a].push(b)},off:function(a,b){a!==c?(a=a.toLowerCase(),b!==c?this.events.hasOwnProperty(a)&&h(this.events[a],b):delete this.events[a]):this.events={}},fire:function(a,b){b=Array.prototype.slice.call(arguments),a=a.toLowerCase();var c=!1;return this.events.hasOwnProperty(a)&&l(this.events[a],function(a){c=a.apply(this,b.slice(1))===!1||c},this),"catchall"!=a&&(b.unshift("catchAll"),c=this.fire.apply(this,b)===!1||c),!c},webkitReadDataTransfer:function(a){function b(a){a.readEntries(function(f){f.length?(g+=f.length,l(f,function(a){if(a.isFile){var e=a.fullPath;a.file(function(a){c(a,e)},d)}else a.isDirectory&&b(a.createReader())}),b(a)):e()},d)}function c(a,b){a.relativePath=b.substring(1),h.push(a),e()}function d(a){throw a}function e(){0==--g&&f.addFiles(h,a)}var f=this,g=a.dataTransfer.items.length,h=[];l(a.dataTransfer.items,function(a){var d=a.webkitGetAsEntry();return d?void(d.isFile?c(a.getAsFile(),d.fullPath):b(d.createReader())):void e()})},generateUniqueIdentifier:function(a){var b=this.opts.generateUniqueIdentifier;if("function"==typeof b)return b(a);var c=a.relativePath||a.webkitRelativePath||a.fileName||a.name;return a.size+"-"+c.replace(/[^0-9a-zA-Z_-]/gim,"")},uploadNextChunk:function(a){var b=!1;if(this.opts.prioritizeFirstAndLastChunk&&(l(this.files,function(a){return!a.paused&&a.chunks.length&&"pending"===a.chunks[0].status()?(a.chunks[0].send(),b=!0,!1):!a.paused&&a.chunks.length>1&&"pending"===a.chunks[a.chunks.length-1].status()?(a.chunks[a.chunks.length-1].send(),b=!0,!1):void 0}),b))return b;if(l(this.files,function(a){return a.paused||l(a.chunks,function(a){return"pending"===a.status()?(a.send(),b=!0,!1):void 0}),b?!1:void 0}),b)return!0;var c=!1;return l(this.files,function(a){return a.isComplete()?void 0:(c=!0,!1)}),c||a||j(function(){this.fire("complete")},this),!1},assignBrowse:function(a,c,d,e){a instanceof Element&&(a=[a]),l(a,function(a){var f;"INPUT"===a.tagName&&"file"===a.type?f=a:(f=b.createElement("input"),f.setAttribute("type","file"),k(f.style,{visibility:"hidden",position:"absolute",width:"1px",height:"1px"}),a.appendChild(f),a.addEventListener("click",function(){f.click()},!1)),this.opts.singleFile||d||f.setAttribute("multiple","multiple"),c&&f.setAttribute("webkitdirectory","webkitdirectory"),l(e,function(a,b){f.setAttribute(b,a)});var g=this;f.addEventListener("change",function(a){a.target.value&&(g.addFiles(a.target.files,a),a.target.value="")},!1)},this)},assignDrop:function(a){"undefined"==typeof a.length&&(a=[a]),l(a,function(a){a.addEventListener("dragover",this.preventEvent,!1),a.addEventListener("dragenter",this.preventEvent,!1),a.addEventListener("drop",this.onDrop,!1)},this)},unAssignDrop:function(a){"undefined"==typeof a.length&&(a=[a]),l(a,function(a){a.removeEventListener("dragover",this.preventEvent),a.removeEventListener("dragenter",this.preventEvent),a.removeEventListener("drop",this.onDrop)},this)},isUploading:function(){var a=!1;return l(this.files,function(b){return b.isUploading()?(a=!0,!1):void 0}),a},_shouldUploadNext:function(){var a=0,b=!0,c=this.opts.simultaneousUploads;return l(this.files,function(d){l(d.chunks,function(d){return"uploading"===d.status()&&(a++,a>=c)?(b=!1,!1):void 0})}),b&&a},upload:function(){var a=this._shouldUploadNext();if(a!==!1){this.fire("uploadStart");for(var b=!1,c=1;c<=this.opts.simultaneousUploads-a;c++)b=this.uploadNextChunk(!0)||b;b||j(function(){this.fire("complete")},this)}},resume:function(){l(this.files,function(a){a.isComplete()||a.resume()})},pause:function(){l(this.files,function(a){a.pause()})},cancel:function(){for(var a=this.files.length-1;a>=0;a--)this.files[a].cancel()},progress:function(){var a=0,b=0;return l(this.files,function(c){a+=c.progress()*c.size,b+=c.size}),b>0?a/b:0},addFile:function(a,b){this.addFiles([a],b)},addFiles:function(a,b){var c=[];l(a,function(a){if((!m||m&&a.size>0)&&(a.size%4096!==0||"."!==a.name&&"."!==a.fileName)){var d=this.generateUniqueIdentifier(a);if(this.opts.allowDuplicateUploads||!this.getFromUniqueIdentifier(d)){var f=new e(this,a,d);this.fire("fileAdded",f,b)&&c.push(f)}}},this),this.fire("filesAdded",c,b)&&(l(c,function(a){this.opts.singleFile&&this.files.length>0&&this.removeFile(this.files[0]),this.files.push(a)},this),this.fire("filesSubmitted",c,b))},removeFile:function(a){for(var b=this.files.length-1;b>=0;b--)this.files[b]===a&&(this.files.splice(b,1),a.abort(),this.fire("fileRemoved",a))},getFromUniqueIdentifier:function(a){var b=!1;return l(this.files,function(c){c.uniqueIdentifier===a&&(b=c)}),b},getSize:function(){var a=0;return l(this.files,function(b){a+=b.size}),a},sizeUploaded:function(){var a=0;return l(this.files,function(b){a+=b.sizeUploaded()}),a},timeRemaining:function(){var a=0,b=0;return l(this.files,function(c){c.paused||c.error||(a+=c.size-c.sizeUploaded(),b+=c.averageSpeed)}),a&&!b?Number.POSITIVE_INFINITY:a||b?Math.floor(a/b):0}},e.prototype={measureSpeed:function(){var a=Date.now()-this._lastProgressCallback;if(a){var b=this.flowObj.opts.speedSmoothingFactor,c=this.sizeUploaded();this.currentSpeed=Math.max((c-this._prevUploadedSize)/a*1e3,0),this.averageSpeed=b*this.currentSpeed+(1-b)*this.averageSpeed,this._prevUploadedSize=c}},chunkEvent:function(a,b,c){switch(b){case"progress":if(Date.now()-this._lastProgressCallback<this.flowObj.opts.progressCallbacksInterval)break;this.measureSpeed(),this.flowObj.fire("fileProgress",this,a),this.flowObj.fire("progress"),this._lastProgressCallback=Date.now();break;case"error":this.error=!0,this.abort(!0),this.flowObj.fire("fileError",this,c,a),this.flowObj.fire("error",c,this,a);break;case"success":if(this.error)return;this.measureSpeed(),this.flowObj.fire("fileProgress",this,a),this.flowObj.fire("progress"),this._lastProgressCallback=Date.now(),this.isComplete()&&(this.currentSpeed=0,this.averageSpeed=0,this.flowObj.fire("fileSuccess",this,c,a));break;case"retry":this.flowObj.fire("fileRetry",this,a)}},pause:function(){this.paused=!0,this.abort()},resume:function(){this.paused=!1,this.flowObj.upload()},abort:function(a){this.currentSpeed=0,this.averageSpeed=0;var b=this.chunks;a&&(this.chunks=[]),l(b,function(a){"uploading"===a.status()&&(a.abort(),this.flowObj.uploadNextChunk())},this)},cancel:function(){this.flowObj.removeFile(this)},retry:function(){this.bootstrap(),this.flowObj.upload()},bootstrap:function(){"function"==typeof this.flowObj.opts.initFileFn&&this.flowObj.opts.initFileFn(this),this.abort(!0),this.error=!1,this._prevProgress=0;for(var a=this.flowObj.opts.forceChunkSize?Math.ceil:Math.floor,b=Math.max(a(this.size/this.flowObj.opts.chunkSize),1),c=0;b>c;c++)this.chunks.push(new g(this.flowObj,this,c))},progress:function(){if(this.error)return 1;if(1===this.chunks.length)return this._prevProgress=Math.max(this._prevProgress,this.chunks[0].progress()),this._prevProgress;var a=0;l(this.chunks,function(b){a+=b.progress()*(b.endByte-b.startByte)});var b=a/this.size;return this._prevProgress=Math.max(this._prevProgress,b>.9999?1:b),this._prevProgress},isUploading:function(){var a=!1;return l(this.chunks,function(b){return"uploading"===b.status()?(a=!0,!1):void 0}),a},isComplete:function(){var a=!1;return l(this.chunks,function(b){var c=b.status();return"pending"===c||"uploading"===c||"reading"===c||1===b.preprocessState||1===b.readState?(a=!0,!1):void 0}),!a},sizeUploaded:function(){var a=0;return l(this.chunks,function(b){a+=b.sizeUploaded()}),a},timeRemaining:function(){if(this.paused||this.error)return 0;var a=this.size-this.sizeUploaded();return a&&!this.averageSpeed?Number.POSITIVE_INFINITY:a||this.averageSpeed?Math.floor(a/this.averageSpeed):0},getType:function(){return this.file.type&&this.file.type.split("/")[1]},getExtension:function(){return this.name.substr((~-this.name.lastIndexOf(".")>>>0)+2).toLowerCase()}},g.prototype={getParams:function(){return{flowChunkNumber:this.offset+1,flowChunkSize:this.flowObj.opts.chunkSize,flowCurrentChunkSize:this.endByte-this.startByte,flowTotalSize:this.fileObj.size,flowIdentifier:this.fileObj.uniqueIdentifier,flowFilename:this.fileObj.name,flowRelativePath:this.fileObj.relativePath,flowTotalChunks:this.fileObj.chunks.length}},getTarget:function(a,b){return a+=a.indexOf("?")<0?"?":"&",a+b.join("&")},test:function(){this.xhr=new XMLHttpRequest,this.xhr.addEventListener("load",this.testHandler,!1),this.xhr.addEventListener("error",this.testHandler,!1);var a=i(this.flowObj.opts.testMethod,this.fileObj,this),b=this.prepareXhrRequest(a,!0);this.xhr.send(b)},preprocessFinished:function(){this.endByte=this.computeEndByte(),this.preprocessState=2,this.send()},readFinished:function(a){this.readState=2,this.bytes=a,this.send()},send:function(){var a=this.flowObj.opts.preprocess,b=this.flowObj.opts.readFileFn;if("function"==typeof a)switch(this.preprocessState){case 0:return this.preprocessState=1,void a(this);case 1:return}switch(this.readState){case 0:return this.readState=1,void b(this.fileObj,this.startByte,this.endByte,this.fileObj.file.type,this);case 1:return}if(this.flowObj.opts.testChunks&&!this.tested)return void this.test();this.loaded=0,this.total=0,this.pendingRetry=!1,this.xhr=new XMLHttpRequest,this.xhr.upload.addEventListener("progress",this.progressHandler,!1),this.xhr.addEventListener("load",this.doneHandler,!1),this.xhr.addEventListener("error",this.doneHandler,!1);var c=i(this.flowObj.opts.uploadMethod,this.fileObj,this),d=this.prepareXhrRequest(c,!1,this.flowObj.opts.method,this.bytes);this.xhr.send(d)},abort:function(){var a=this.xhr;this.xhr=null,a&&a.abort()},status:function(a){return 1===this.readState?"reading":this.pendingRetry||1===this.preprocessState?"uploading":this.xhr?this.xhr.readyState<4?"uploading":this.flowObj.opts.successStatuses.indexOf(this.xhr.status)>-1?"success":this.flowObj.opts.permanentErrors.indexOf(this.xhr.status)>-1||!a&&this.retries>=this.flowObj.opts.maxChunkRetries?"error":(this.abort(),"pending"):"pending"},message:function(){return this.xhr?this.xhr.responseText:""},progress:function(){if(this.pendingRetry)return 0;var a=this.status();return"success"===a||"error"===a?1:"pending"===a?0:this.total>0?this.loaded/this.total:0},sizeUploaded:function(){var a=this.endByte-this.startByte;return"success"!==this.status()&&(a=this.progress()*a),a},prepareXhrRequest:function(a,b,c,d){var e=i(this.flowObj.opts.query,this.fileObj,this,b);e=k(e,this.getParams());var f=i(this.flowObj.opts.target,this.fileObj,this,b),g=null;if("GET"===a||"octet"===c){var h=[];l(e,function(a,b){h.push([encodeURIComponent(b),encodeURIComponent(a)].join("="))}),f=this.getTarget(f,h),g=d||null}else g=new FormData,l(e,function(a,b){g.append(b,a)}),"undefined"!=typeof d&&g.append(this.flowObj.opts.fileParameterName,d,this.fileObj.file.name);return this.xhr.open(a,f,!0),this.xhr.withCredentials=this.flowObj.opts.withCredentials,l(i(this.flowObj.opts.headers,this.fileObj,this,b),function(a,b){this.xhr.setRequestHeader(b,a)},this),g}},d.evalOpts=i,d.extend=k,d.each=l,d.FlowFile=e,d.FlowChunk=g,d.version="2.13.0","object"==typeof module&&module&&"object"==typeof module.exports?module.exports=d:(a.Flow=d,"function"==typeof define&&define.amd&&define("flow",[],function(){return d}))}(window,document),angular.module("flow.provider",[]).provider("flowFactory",function(){"use strict";this.defaults={},this.factory=function(a){return new Flow(a)},this.events=[],this.on=function(a,b){this.events.push([a,b])},this.$get=function(){var a=this.factory,b=this.defaults,c=this.events;return{create:function(d){var e=a(angular.extend({},b,d));return angular.forEach(c,function(a){e.on(a[0],a[1])}),e}}}}),angular.module("flow.init",["flow.provider"]).controller("flowCtrl",["$scope","$attrs","$parse","flowFactory",function(a,b,c,d){var e=angular.extend({},a.$eval(b.flowInit)),f=a.$eval(b.flowObject)||d.create(e),g=function(b){var c=Array.prototype.slice.call(arguments);c.shift();var d=a.$broadcast.apply(a,["flow::"+b,f].concat(c));return{progress:1,filesSubmitted:1,fileSuccess:1,fileError:1,complete:1}[b]&&a.$apply(),d.defaultPrevented?!1:void 0};f.on("catchAll",g),a.$on("$destroy",function(){f.off("catchAll",g)}),a.$flow=f,b.hasOwnProperty("flowName")&&(c(b.flowName).assign(a,f),a.$on("$destroy",function(){c(b.flowName).assign(a)}))}]).directive("flowInit",[function(){return{scope:!0,controller:"flowCtrl"}}]),angular.module("flow.btn",["flow.init"]).directive("flowBtn",[function(){return{restrict:"EA",scope:!1,require:"^flowInit",link:function(a,b,c){var d=c.hasOwnProperty("flowDirectory"),e=c.hasOwnProperty("flowSingleFile"),f=c.hasOwnProperty("flowAttrs")&&a.$eval(c.flowAttrs);a.$flow.assignBrowse(b,d,e,f)}}}]),angular.module("flow.dragEvents",["flow.init"]).directive("flowPreventDrop",function(){return{scope:!1,link:function(a,b,c){b.bind("drop dragover",function(a){a.preventDefault()})}}}).directive("flowDragEnter",["$timeout",function(a){return{scope:!1,link:function(b,c,d){function e(a){var b=!1,c=a.dataTransfer||a.originalEvent.dataTransfer;return angular.forEach(c&&c.types,function(a){"Files"===a&&(b=!0)}),b}var f,g=!1;c.bind("dragover",function(c){e(c)&&(g||(b.$apply(d.flowDragEnter),g=!0),a.cancel(f),c.preventDefault())}),c.bind("dragleave drop",function(c){a.cancel(f),f=a(function(){b.$eval(d.flowDragLeave),f=null,g=!1},100)})}}}]),angular.module("flow.drop",["flow.init"]).directive("flowDrop",function(){return{scope:!1,require:"^flowInit",link:function(a,b,c){function d(){a.$flow.assignDrop(b)}function e(){a.$flow.unAssignDrop(b)}c.flowDropEnabled?a.$watch(c.flowDropEnabled,function(a){a?d():e()}):d()}}}),!function(a){"use strict";function b(a){return a.charAt(0).toUpperCase()+a.slice(1)}var c=a.module("flow.events",["flow.init"]),d={fileSuccess:["$file","$message"],fileProgress:["$file"],fileAdded:["$file","$event"],filesAdded:["$files","$event"],filesSubmitted:["$files","$event"],fileRetry:["$file"],fileRemoved:["$file"],fileError:["$file","$message"],uploadStart:[],complete:[],progress:[],error:["$message","$file"]};a.forEach(d,function(d,e){var f="flow"+b(e);"flowUploadStart"==f&&(f="flowUploadStarted"),c.directive(f,[function(){return{require:"^flowInit",controller:["$scope","$attrs",function(b,c){b.$on("flow::"+e,function(){var e=Array.prototype.slice.call(arguments),g=e.shift();if(b.$flow===e.shift()){var h={};a.forEach(d,function(a,b){h[a]=e[b]}),b.$eval(c[f],h)===!1&&g.preventDefault()}})}]}}])})}(angular),angular.module("flow.img",["flow.init"]).directive("flowImg",[function(){return{scope:!1,require:"^flowInit",link:function(a,b,c){var d=c.flowImg;a.$watch(d,function(b){if(b){var d=new FileReader;d.readAsDataURL(b.file),d.onload=function(b){a.$apply(function(){c.$set("src",b.target.result)})}}})}}}]),angular.module("flow.transfers",["flow.init"]).directive("flowTransfers",[function(){return{scope:!0,require:"^flowInit",link:function(a){a.transfers=a.$flow.files}}}]),angular.module("flow",["flow.provider","flow.init","flow.events","flow.btn","flow.drop","flow.transfers","flow.img","flow.dragEvents"]);
"use strict";function string2array(a){return a.split(",").map(Function.prototype.call,String.prototype.trim)}function pasteHtmlAtCaret(a){var b,c;if(window.getSelection){if(b=window.getSelection(),b.getRangeAt&&b.rangeCount){c=b.getRangeAt(0),c.deleteContents();var d=document.createElement("div");d.innerHTML=a;for(var e,f,g=document.createDocumentFragment();e=d.firstChild;)f=g.appendChild(e);c.insertNode(g),f&&(c=c.cloneRange(),c.setStartAfter(f),c.collapse(!0),b.removeAllRanges(),b.addRange(c))}}else document.selection&&"Control"!=document.selection.type&&document.selection.createRange().pasteHTML(a)}var VERSION="3.0.13";angular.module("ngWig",["ngwig-app-templates"]),angular.ngWig={version:VERSION},angular.module("ngWig").component("ngWig",{bindings:{content:"=ngModel",options:"<?",onPaste:"&",buttons:"@",beforeExecCommand:"&",afterExecCommand:"&",placeholder:"@?"},require:{ngModelController:"ngModel"},templateUrl:"ng-wig/views/ng-wig.html",controller:["$scope","$element","$q","$attrs","$window","$document","ngWigToolbar",function(a,b,c,d,e,f,g){var h=this,i=angular.element(b[0].querySelector("#ng-wig-editable"));this.required="required"in d,this.isSourceModeAllowed="sourceModeAllowed"in d,this.editMode=!1,this.toolbarButtons=g.getToolbarButtons(this.buttons&&string2array(this.buttons)),d.$observe("disabled",function(a){h.disabled=a,i.attr("contenteditable",!a)}),this.isEditorActive=function(){return i[0]===f[0].activeElement},this.toggleEditMode=function(){h.editMode=!h.editMode,e.getSelection().removeAllRanges&&e.getSelection().removeAllRanges()},this.execCommand=function(a,b){if(h.editMode)return!1;if(f[0].queryCommandSupported&&!f[0].queryCommandSupported(a))throw'The command "'+a+'" is not supported';if("createlink"!==a&&"insertImage"!==a||(b=e.prompt("Please enter the URL","http://"))){h.beforeExecCommand({command:a,options:b});var c=f[0].getSelection().toString();"createlink"===a&&""===c?f[0].execCommand("insertHtml",!1,'<a href="'+b+'">'+b+"</a>"):f[0].execCommand(a,!1,b),h.afterExecCommand({command:a,options:b}),i.length&&i[0].focus()}},this.$onInit=function(){var b=Boolean(h.placeholder);h.ngModelController.$render=function(){return h.ngModelController.$viewValue?i.html(h.ngModelController.$viewValue):b?i.empty():i.html("<p></p>")},i.bind("blur keyup change focus click",function(){!b||i.html().length&&"<br>"!==i.html()||i.empty(),h.ngModelController.$setViewValue(i.html()),a.$applyAsync()})},i.on("paste",function(a){if(d.onPaste){var b=void 0;b=window.clipboardData&&window.clipboardData.getData?window.clipboardData.getData("Text"):(a.originalEvent||a).clipboardData.getData("text/plain"),a.preventDefault(),c.when(h.onPaste({$event:a,pasteContent:b})).then(function(a){pasteHtmlAtCaret(a)})}})}]}),angular.module("ngWig").provider("ngWigToolbar",function(){var a={list1:{title:"Unordered List",command:"insertunorderedlist",styleClass:"list-ul"},list2:{title:"Ordered List",command:"insertorderedlist",styleClass:"list-ol"},bold:{title:"Bold",command:"bold",styleClass:"bold"},italic:{title:"Italic",command:"italic",styleClass:"italic"},link:{title:"Link",command:"createlink",styleClass:"link"}},b=["list1","list2","bold","italic","link"],c=function(){return!!this.command&&document.queryCommandState(this.command)};this.setButtons=function(a){if(!angular.isArray(a))throw'Argument "buttons" should be an array';b=a},this.addStandardButton=function(c,d,e,f){if(!c||!d||!e)throw'Arguments "name", "title" and "command" are required';f=f||"",a[c]={title:d,command:e,styleClass:f},b.push(c)},this.addCustomButton=function(c,d){if(!c||!d)throw'Arguments "name" and "pluginName" are required';a[c]={pluginName:d,isComplex:!0},b.push(c)},this.$get=function(){return{getToolbarButtons:function(d){var e=[];return(d||b).forEach(function(b){if(!a[b])throw'There is no "'+b+'" in your library. Possible variants: '+Object.keys(a);var d=angular.copy(a[b]);d.isActive=c,e.push(d)}),e}}}}),angular.module("ngWig").component("ngWigPlugin",{bindings:{plugin:"<",execCommand:"=",editMode:"=",disabled:"=",options:"<",content:"="},controller:["$scope","$element","$compile",function(a,b,c){var d=this;this.$onInit=function(){b.replaceWith(c("<"+d.plugin.pluginName+' plugin="$ctrl.plugin"exec-command="$ctrl.execCommand"edit-mode="$ctrl.editMode"disabled="$ctrl.disabled"options="$ctrl.options"content="$ctrl.content"/>')(a))}}]}),angular.module("ngwig-app-templates",["ng-wig/views/ng-wig.html"]),angular.module("ng-wig/views/ng-wig.html",[]).run(["$templateCache",function(a){a.put("ng-wig/views/ng-wig.html",'<div class="ng-wig">\n  <ul class="nw-toolbar">\n    <li class="nw-toolbar__item" ng-repeat="button in $ctrl.toolbarButtons">\n        <div ng-if="!button.isComplex">\n          <button type="button"\n                  class="nw-button {{button.styleClass}}"\n                  title="{{button.title}}"\n                  ng-click="$ctrl.execCommand(button.command)"\n                  ng-class="{ \'nw-button--active\': !$ctrl.disabled && $ctrl.isEditorActive() && button.isActive() }"\n                  ng-disabled="$ctrl.editMode || $ctrl.disabled">\n            {{ button.title }}\n          </button>\n        </div>\n        <div ng-if="button.isComplex">\n          <ng-wig-plugin\n              exec-command="$ctrl.execCommand"\n              plugin="button"\n              edit-mode="$ctrl.editMode"\n              disabled="$ctrl.disabled"\n              options="$ctrl.options"\n              content="$ctrl.content"></ng-wig-plugin>\n        </div>\n    </li><!--\n    --><li class="nw-toolbar__item">\n      <button type="button"\n              class="nw-button nw-button--source"\n              title="Edit HTML"\n              ng-class="{ \'nw-button--active\': $ctrl.editMode }"\n              ng-if="$ctrl.isSourceModeAllowed"\n              ng-click="$ctrl.toggleEditMode()"\n              ng-disabled="$ctrl.disabled">\n        Edit HTML\n      </button>\n    </li>\n  </ul>\n\n  <div class="nw-editor-container">\n    <div class="nw-editor__src-container" ng-show="$ctrl.editMode">\n      <textarea ng-model="$ctrl.content"\n                ng-disabled="$ctrl.disabled"\n                class="nw-editor__src"></textarea>\n    </div>\n    <div class="nw-editor" ng-class="{ \'nw-disabled\': $ctrl.disabled }">\n      <div id="ng-wig-editable"\n           class="nw-editor__res"\n           ng-class="{\'nw-invisible\': $ctrl.editMode}"\n           ng-disabled="$ctrl.disabled"\n           contenteditable\n           placeholder="{{$ctrl.placeholder}}">\n      </div>\n    </div>\n  </div>\n</div>\n')}]);
(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory((function webpackLoadOptionalExternalModule() { try { return require("fs"); } catch(e) {} }()), require("path"));
	else if(typeof define === 'function' && define.amd)
		define(["fs", "path"], factory);
	else if(typeof exports === 'object')
		exports["Twig"] = factory((function webpackLoadOptionalExternalModule() { try { return require("fs"); } catch(e) {} }()), require("path"));
	else
		root["Twig"] = factory(root["fs"], root["path"]);
})(this, function(__WEBPACK_EXTERNAL_MODULE_19__, __WEBPACK_EXTERNAL_MODULE_20__) {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	/**
	 * Twig.js
	 *
	 * @copyright 2011-2016 John Roepke and the Twig.js Contributors
	 * @license   Available under the BSD 2-Clause License
	 * @link      https://github.com/twigjs/twig.js
	 */

	var Twig = {
	    VERSION: '0.10.2'
	};

	__webpack_require__(1)(Twig);
	__webpack_require__(2)(Twig);
	__webpack_require__(3)(Twig);
	__webpack_require__(5)(Twig);
	__webpack_require__(6)(Twig);
	__webpack_require__(7)(Twig);
	__webpack_require__(17)(Twig);
	__webpack_require__(18)(Twig);
	__webpack_require__(21)(Twig);
	__webpack_require__(22)(Twig);
	__webpack_require__(23)(Twig);
	__webpack_require__(24)(Twig);
	__webpack_require__(25)(Twig);
	__webpack_require__(26)(Twig);
	__webpack_require__(27)(Twig);

	module.exports = Twig.exports;


/***/ },
/* 1 */
/***/ function(module, exports) {

	// ## twig.core.js
	//
	// This file handles template level tokenizing, compiling and parsing.
	module.exports = function (Twig) {
	    "use strict";

	    Twig.trace = false;
	    Twig.debug = false;

	    // Default caching to true for the improved performance it offers
	    Twig.cache = true;

	    Twig.noop = function() {};

	    Twig.placeholders = {
	        parent: "{{|PARENT|}}"
	    };

	    /**
	     * Fallback for Array.indexOf for IE8 et al
	     */
	    Twig.indexOf = function (arr, searchElement /*, fromIndex */ ) {
	        if (Array.prototype.hasOwnProperty("indexOf")) {
	            return arr.indexOf(searchElement);
	        }
	        if (arr === void 0 || arr === null) {
	            throw new TypeError();
	        }
	        var t = Object(arr);
	        var len = t.length >>> 0;
	        if (len === 0) {
	            return -1;
	        }
	        var n = 0;
	        if (arguments.length > 0) {
	            n = Number(arguments[1]);
	            if (n !== n) { // shortcut for verifying if it's NaN
	                n = 0;
	            } else if (n !== 0 && n !== Infinity && n !== -Infinity) {
	                n = (n > 0 || -1) * Math.floor(Math.abs(n));
	            }
	        }
	        if (n >= len) {
	            // console.log("indexOf not found1 ", JSON.stringify(searchElement), JSON.stringify(arr));
	            return -1;
	        }
	        var k = n >= 0 ? n : Math.max(len - Math.abs(n), 0);
	        for (; k < len; k++) {
	            if (k in t && t[k] === searchElement) {
	                return k;
	            }
	        }
	        if (arr == searchElement) {
	            return 0;
	        }
	        // console.log("indexOf not found2 ", JSON.stringify(searchElement), JSON.stringify(arr));

	        return -1;
	    }

	    Twig.forEach = function (arr, callback, thisArg) {
	        if (Array.prototype.forEach ) {
	            return arr.forEach(callback, thisArg);
	        }

	        var T, k;

	        if ( arr == null ) {
	          throw new TypeError( " this is null or not defined" );
	        }

	        // 1. Let O be the result of calling ToObject passing the |this| value as the argument.
	        var O = Object(arr);

	        // 2. Let lenValue be the result of calling the Get internal method of O with the argument "length".
	        // 3. Let len be ToUint32(lenValue).
	        var len = O.length >>> 0; // Hack to convert O.length to a UInt32

	        // 4. If IsCallable(callback) is false, throw a TypeError exception.
	        // See: http://es5.github.com/#x9.11
	        if ( {}.toString.call(callback) != "[object Function]" ) {
	          throw new TypeError( callback + " is not a function" );
	        }

	        // 5. If thisArg was supplied, let T be thisArg; else let T be undefined.
	        if ( thisArg ) {
	          T = thisArg;
	        }

	        // 6. Let k be 0
	        k = 0;

	        // 7. Repeat, while k < len
	        while( k < len ) {

	          var kValue;

	          // a. Let Pk be ToString(k).
	          //   This is implicit for LHS operands of the in operator
	          // b. Let kPresent be the result of calling the HasProperty internal method of O with argument Pk.
	          //   This step can be combined with c
	          // c. If kPresent is true, then
	          if ( k in O ) {

	            // i. Let kValue be the result of calling the Get internal method of O with argument Pk.
	            kValue = O[ k ];

	            // ii. Call the Call internal method of callback with T as the this value and
	            // argument list containing kValue, k, and O.
	            callback.call( T, kValue, k, O );
	          }
	          // d. Increase k by 1.
	          k++;
	        }
	        // 8. return undefined
	    };

	    Twig.merge = function(target, source, onlyChanged) {
	        Twig.forEach(Object.keys(source), function (key) {
	            if (onlyChanged && !(key in target)) {
	                return;
	            }

	            target[key] = source[key]
	        });

	        return target;
	    };

	    /**
	     * Exception thrown by twig.js.
	     */
	    Twig.Error = function(message, file) {
	       this.message = message;
	       this.name = "TwigException";
	       this.type = "TwigException";
	       this.file = file;
	    };

	    /**
	     * Get the string representation of a Twig error.
	     */
	    Twig.Error.prototype.toString = function() {
	        var output = this.name + ": " + this.message;

	        return output;
	    };

	    /**
	     * Wrapper for logging to the console.
	     */
	    Twig.log = {
	        trace: function() {if (Twig.trace && console) {console.log(Array.prototype.slice.call(arguments));}},
	        debug: function() {if (Twig.debug && console) {console.log(Array.prototype.slice.call(arguments));}}
	    };


	    if (typeof console !== "undefined") {
	        if (typeof console.error !== "undefined") {
	            Twig.log.error = function() {
	                console.error.apply(console, arguments);
	            }
	        } else if (typeof console.log !== "undefined") {
	            Twig.log.error = function() {
	                console.log.apply(console, arguments);
	            }
	        }
	    } else {
	        Twig.log.error = function(){};
	    }

	    /**
	     * Wrapper for child context objects in Twig.
	     *
	     * @param {Object} context Values to initialize the context with.
	     */
	    Twig.ChildContext = function(context) {
	        var ChildContext = function ChildContext() {};
	        ChildContext.prototype = context;
	        return new ChildContext();
	    };

	    /**
	     * Container for methods related to handling high level template tokens
	     *      (for example: {{ expression }}, {% logic %}, {# comment #}, raw data)
	     */
	    Twig.token = {};

	    /**
	     * Token types.
	     */
	    Twig.token.type = {
	        output:                 'output',
	        logic:                  'logic',
	        comment:                'comment',
	        raw:                    'raw',
	        output_whitespace_pre:  'output_whitespace_pre',
	        output_whitespace_post: 'output_whitespace_post',
	        output_whitespace_both: 'output_whitespace_both',
	        logic_whitespace_pre:   'logic_whitespace_pre',
	        logic_whitespace_post:  'logic_whitespace_post',
	        logic_whitespace_both:  'logic_whitespace_both'
	    };

	    /**
	     * Token syntax definitions.
	     */
	    Twig.token.definitions = [
	        {
	            type: Twig.token.type.raw,
	            open: '{% raw %}',
	            close: '{% endraw %}'
	        },
	        {
	            type: Twig.token.type.raw,
	            open: '{% verbatim %}',
	            close: '{% endverbatim %}'
	        },
	        // *Whitespace type tokens*
	        //
	        // These typically take the form `{{- expression -}}` or `{{- expression }}` or `{{ expression -}}`.
	        {
	            type: Twig.token.type.output_whitespace_pre,
	            open: '{{-',
	            close: '}}'
	        },
	        {
	            type: Twig.token.type.output_whitespace_post,
	            open: '{{',
	            close: '-}}'
	        },
	        {
	            type: Twig.token.type.output_whitespace_both,
	            open: '{{-',
	            close: '-}}'
	        },
	        {
	            type: Twig.token.type.logic_whitespace_pre,
	            open: '{%-',
	            close: '%}'
	        },
	        {
	            type: Twig.token.type.logic_whitespace_post,
	            open: '{%',
	            close: '-%}'
	        },
	        {
	            type: Twig.token.type.logic_whitespace_both,
	            open: '{%-',
	            close: '-%}'
	        },
	        // *Output type tokens*
	        //
	        // These typically take the form `{{ expression }}`.
	        {
	            type: Twig.token.type.output,
	            open: '{{',
	            close: '}}'
	        },
	        // *Logic type tokens*
	        //
	        // These typically take a form like `{% if expression %}` or `{% endif %}`
	        {
	            type: Twig.token.type.logic,
	            open: '{%',
	            close: '%}'
	        },
	        // *Comment type tokens*
	        //
	        // These take the form `{# anything #}`
	        {
	            type: Twig.token.type.comment,
	            open: '{#',
	            close: '#}'
	        }
	    ];


	    /**
	     * What characters start "strings" in token definitions. We need this to ignore token close
	     * strings inside an expression.
	     */
	    Twig.token.strings = ['"', "'"];

	    Twig.token.findStart = function (template) {
	        var output = {
	                position: null,
	                close_position: null,
	                def: null
	            },
	            i,
	            token_template,
	            first_key_position,
	            close_key_position;

	        for (i=0;i<Twig.token.definitions.length;i++) {
	            token_template = Twig.token.definitions[i];
	            first_key_position = template.indexOf(token_template.open);
	            close_key_position = template.indexOf(token_template.close);

	            Twig.log.trace("Twig.token.findStart: ", "Searching for ", token_template.open, " found at ", first_key_position);

	            //Special handling for mismatched tokens
	            if (first_key_position >= 0) {
	                //This token matches the template
	                if (token_template.open.length !== token_template.close.length) {
	                    //This token has mismatched closing and opening tags
	                    if (close_key_position < 0) {
	                        //This token's closing tag does not match the template
	                        continue;
	                    }
	                }
	            }
	            // Does this token occur before any other types?
	            if (first_key_position >= 0 && (output.position === null || first_key_position < output.position)) {
	                output.position = first_key_position;
	                output.def = token_template;
	                output.close_position = close_key_position;
	            } else if (first_key_position >= 0 && output.position !== null && first_key_position === output.position) {
	                /*This token exactly matches another token,
	                greedily match to check if this token has a greater specificity*/
	                if (token_template.open.length > output.def.open.length) {
	                    //This token's opening tag is more specific than the previous match
	                    output.position = first_key_position;
	                    output.def = token_template;
	                    output.close_position = close_key_position;
	                } else if (token_template.open.length === output.def.open.length) {
	                    if (token_template.close.length > output.def.close.length) {
	                        //This token's opening tag is as specific as the previous match,
	                        //but the closing tag has greater specificity
	                        if (close_key_position >= 0 && close_key_position < output.close_position) {
	                            //This token's closing tag exists in the template,
	                            //and it occurs sooner than the previous match
	                            output.position = first_key_position;
	                            output.def = token_template;
	                            output.close_position = close_key_position;
	                        }
	                    } else if (close_key_position >= 0 && close_key_position < output.close_position) {
	                        //This token's closing tag is not more specific than the previous match,
	                        //but it occurs sooner than the previous match
	                        output.position = first_key_position;
	                        output.def = token_template;
	                        output.close_position = close_key_position;
	                    }
	                }
	            }
	        }

	        delete output['close_position'];

	        return output;
	    };

	    Twig.token.findEnd = function (template, token_def, start) {
	        var end = null,
	            found = false,
	            offset = 0,

	            // String position variables
	            str_pos = null,
	            str_found = null,
	            pos = null,
	            end_offset = null,
	            this_str_pos = null,
	            end_str_pos = null,

	            // For loop variables
	            i,
	            l;

	        while (!found) {
	            str_pos = null;
	            str_found = null;
	            pos = template.indexOf(token_def.close, offset);

	            if (pos >= 0) {
	                end = pos;
	                found = true;
	            } else {
	                // throw an exception
	                throw new Twig.Error("Unable to find closing bracket '" + token_def.close +
	                                "'" + " opened near template position " + start);
	            }

	            // Ignore quotes within comments; just look for the next comment close sequence,
	            // regardless of what comes before it. https://github.com/justjohn/twig.js/issues/95
	            if (token_def.type === Twig.token.type.comment) {
	              break;
	            }
	            // Ignore quotes within raw tag
	            // Fixes #283
	            if (token_def.type === Twig.token.type.raw) {
	                break;
	            }

	            l = Twig.token.strings.length;
	            for (i = 0; i < l; i += 1) {
	                this_str_pos = template.indexOf(Twig.token.strings[i], offset);

	                if (this_str_pos > 0 && this_str_pos < pos &&
	                        (str_pos === null || this_str_pos < str_pos)) {
	                    str_pos = this_str_pos;
	                    str_found = Twig.token.strings[i];
	                }
	            }

	            // We found a string before the end of the token, now find the string's end and set the search offset to it
	            if (str_pos !== null) {
	                end_offset = str_pos + 1;
	                end = null;
	                found = false;
	                while (true) {
	                    end_str_pos = template.indexOf(str_found, end_offset);
	                    if (end_str_pos < 0) {
	                        throw "Unclosed string in template";
	                    }
	                    // Ignore escaped quotes
	                    if (template.substr(end_str_pos - 1, 1) !== "\\") {
	                        offset = end_str_pos + 1;
	                        break;
	                    } else {
	                        end_offset = end_str_pos + 1;
	                    }
	                }
	            }
	        }
	        return end;
	    };

	    /**
	     * Convert a template into high-level tokens.
	     */
	    Twig.tokenize = function (template) {
	        var tokens = [],
	            // An offset for reporting errors locations in the template.
	            error_offset = 0,

	            // The start and type of the first token found in the template.
	            found_token = null,
	            // The end position of the matched token.
	            end = null;

	        while (template.length > 0) {
	            // Find the first occurance of any token type in the template
	            found_token = Twig.token.findStart(template);

	            Twig.log.trace("Twig.tokenize: ", "Found token: ", found_token);

	            if (found_token.position !== null) {
	                // Add a raw type token for anything before the start of the token
	                if (found_token.position > 0) {
	                    tokens.push({
	                        type: Twig.token.type.raw,
	                        value: template.substring(0, found_token.position)
	                    });
	                }
	                template = template.substr(found_token.position + found_token.def.open.length);
	                error_offset += found_token.position + found_token.def.open.length;

	                // Find the end of the token
	                end = Twig.token.findEnd(template, found_token.def, error_offset);

	                Twig.log.trace("Twig.tokenize: ", "Token ends at ", end);

	                tokens.push({
	                    type:  found_token.def.type,
	                    value: template.substring(0, end).trim()
	                });

	                if (template.substr( end + found_token.def.close.length, 1 ) === "\n") {
	                    switch (found_token.def.type) {
	                        case "logic_whitespace_pre":
	                        case "logic_whitespace_post":
	                        case "logic_whitespace_both":
	                        case "logic":
	                            // Newlines directly after logic tokens are ignored
	                            end += 1;
	                            break;
	                    }
	                }

	                template = template.substr(end + found_token.def.close.length);

	                // Increment the position in the template
	                error_offset += end + found_token.def.close.length;

	            } else {
	                // No more tokens -> add the rest of the template as a raw-type token
	                tokens.push({
	                    type: Twig.token.type.raw,
	                    value: template
	                });
	                template = '';
	            }
	        }

	        return tokens;
	    };


	    Twig.compile = function (tokens) {
	        try {

	            // Output and intermediate stacks
	            var output = [],
	                stack = [],
	                // The tokens between open and close tags
	                intermediate_output = [],

	                token = null,
	                logic_token = null,
	                unclosed_token = null,
	                // Temporary previous token.
	                prev_token = null,
	                // Temporary previous output.
	                prev_output = null,
	                // Temporary previous intermediate output.
	                prev_intermediate_output = null,
	                // The previous token's template
	                prev_template = null,
	                // Token lookahead
	                next_token = null,
	                // The output token
	                tok_output = null,

	                // Logic Token values
	                type = null,
	                open = null,
	                next = null;

	            var compile_output = function(token) {
	                Twig.expression.compile.apply(this, [token]);
	                if (stack.length > 0) {
	                    intermediate_output.push(token);
	                } else {
	                    output.push(token);
	                }
	            };

	            var compile_logic = function(token) {
	                // Compile the logic token
	                logic_token = Twig.logic.compile.apply(this, [token]);

	                type = logic_token.type;
	                open = Twig.logic.handler[type].open;
	                next = Twig.logic.handler[type].next;

	                Twig.log.trace("Twig.compile: ", "Compiled logic token to ", logic_token,
	                                                 " next is: ", next, " open is : ", open);

	                // Not a standalone token, check logic stack to see if this is expected
	                if (open !== undefined && !open) {
	                    prev_token = stack.pop();
	                    prev_template = Twig.logic.handler[prev_token.type];

	                    if (Twig.indexOf(prev_template.next, type) < 0) {
	                        throw new Error(type + " not expected after a " + prev_token.type);
	                    }

	                    prev_token.output = prev_token.output || [];

	                    prev_token.output = prev_token.output.concat(intermediate_output);
	                    intermediate_output = [];

	                    tok_output = {
	                        type: Twig.token.type.logic,
	                        token: prev_token
	                    };
	                    if (stack.length > 0) {
	                        intermediate_output.push(tok_output);
	                    } else {
	                        output.push(tok_output);
	                    }
	                }

	                // This token requires additional tokens to complete the logic structure.
	                if (next !== undefined && next.length > 0) {
	                    Twig.log.trace("Twig.compile: ", "Pushing ", logic_token, " to logic stack.");

	                    if (stack.length > 0) {
	                        // Put any currently held output into the output list of the logic operator
	                        // currently at the head of the stack before we push a new one on.
	                        prev_token = stack.pop();
	                        prev_token.output = prev_token.output || [];
	                        prev_token.output = prev_token.output.concat(intermediate_output);
	                        stack.push(prev_token);
	                        intermediate_output = [];
	                    }

	                    // Push the new logic token onto the logic stack
	                    stack.push(logic_token);

	                } else if (open !== undefined && open) {
	                    tok_output = {
	                        type: Twig.token.type.logic,
	                        token: logic_token
	                    };
	                    // Standalone token (like {% set ... %}
	                    if (stack.length > 0) {
	                        intermediate_output.push(tok_output);
	                    } else {
	                        output.push(tok_output);
	                    }
	                }
	            };

	            while (tokens.length > 0) {
	                token = tokens.shift();
	                prev_output = output[output.length - 1];
	                prev_intermediate_output = intermediate_output[intermediate_output.length - 1];
	                next_token = tokens[0];
	                Twig.log.trace("Compiling token ", token);
	                switch (token.type) {
	                    case Twig.token.type.raw:
	                        if (stack.length > 0) {
	                            intermediate_output.push(token);
	                        } else {
	                            output.push(token);
	                        }
	                        break;

	                    case Twig.token.type.logic:
	                        compile_logic.call(this, token);
	                        break;

	                    // Do nothing, comments should be ignored
	                    case Twig.token.type.comment:
	                        break;

	                    case Twig.token.type.output:
	                        compile_output.call(this, token);
	                        break;

	                    //Kill whitespace ahead and behind this token
	                    case Twig.token.type.logic_whitespace_pre:
	                    case Twig.token.type.logic_whitespace_post:
	                    case Twig.token.type.logic_whitespace_both:
	                    case Twig.token.type.output_whitespace_pre:
	                    case Twig.token.type.output_whitespace_post:
	                    case Twig.token.type.output_whitespace_both:
	                        if (token.type !== Twig.token.type.output_whitespace_post && token.type !== Twig.token.type.logic_whitespace_post) {
	                            if (prev_output) {
	                                //If the previous output is raw, pop it off
	                                if (prev_output.type === Twig.token.type.raw) {
	                                    output.pop();

	                                    //If the previous output is not just whitespace, trim it
	                                    if (prev_output.value.match(/^\s*$/) === null) {
	                                        prev_output.value = prev_output.value.trim();
	                                        //Repush the previous output
	                                        output.push(prev_output);
	                                    }
	                                }
	                            }

	                            if (prev_intermediate_output) {
	                                //If the previous intermediate output is raw, pop it off
	                                if (prev_intermediate_output.type === Twig.token.type.raw) {
	                                    intermediate_output.pop();

	                                    //If the previous output is not just whitespace, trim it
	                                    if (prev_intermediate_output.value.match(/^\s*$/) === null) {
	                                        prev_intermediate_output.value = prev_intermediate_output.value.trim();
	                                        //Repush the previous intermediate output
	                                        intermediate_output.push(prev_intermediate_output);
	                                    }
	                                }
	                            }
	                        }

	                        //Compile this token
	                        switch (token.type) {
	                            case Twig.token.type.output_whitespace_pre:
	                            case Twig.token.type.output_whitespace_post:
	                            case Twig.token.type.output_whitespace_both:
	                                compile_output.call(this, token);
	                                break;
	                            case Twig.token.type.logic_whitespace_pre:
	                            case Twig.token.type.logic_whitespace_post:
	                            case Twig.token.type.logic_whitespace_both:
	                                compile_logic.call(this, token);
	                                break;
	                        }

	                        if (token.type !== Twig.token.type.output_whitespace_pre && token.type !== Twig.token.type.logic_whitespace_pre) {
	                            if (next_token) {
	                                //If the next token is raw, shift it out
	                                if (next_token.type === Twig.token.type.raw) {
	                                    tokens.shift();

	                                    //If the next token is not just whitespace, trim it
	                                    if (next_token.value.match(/^\s*$/) === null) {
	                                        next_token.value = next_token.value.trim();
	                                        //Unshift the next token
	                                        tokens.unshift(next_token);
	                                    }
	                                }
	                            }
	                        }

	                        break;
	                }

	                Twig.log.trace("Twig.compile: ", " Output: ", output,
	                                                 " Logic Stack: ", stack,
	                                                 " Pending Output: ", intermediate_output );
	            }

	            // Verify that there are no logic tokens left in the stack.
	            if (stack.length > 0) {
	                unclosed_token = stack.pop();
	                throw new Error("Unable to find an end tag for " + unclosed_token.type +
	                                ", expecting one of " + unclosed_token.next);
	            }
	            return output;
	        } catch (ex) {
	            if (this.options.rethrow) {
	                if (ex.type == 'TwigException' && !ex.file) {
	                    ex.file = this.id;
	                }

	                throw ex
	            }
	            else {
	                Twig.log.error("Error compiling twig template " + this.id + ": ");
	                if (ex.stack) {
	                    Twig.log.error(ex.stack);
	                } else {
	                    Twig.log.error(ex.toString());
	                }
	            }
	        }
	    };

	    /**
	     * Parse a compiled template.
	     *
	     * @param {Array} tokens The compiled tokens.
	     * @param {Object} context The render context.
	     *
	     * @return {string} The parsed template.
	     */
	    Twig.parse = function (tokens, context, allow_async) {
	        var that = this,
	            output = [],

	            // Store any error that might be thrown by the promise chain.
	            err = null,

	            // This will be set to is_async if template renders synchronously
	            is_async = true,
	            promise = null,

	            // Track logic chains
	            chain = true;


	        function handleException(ex) {
	            if (that.options.rethrow) {
	                if (typeof ex === 'string') {
	                    ex = new Twig.Error(ex)
	                }

	                if (ex.type == 'TwigException' && !ex.file) {
	                    ex.file = that.id;
	                }

	                throw ex;
	            }
	            else {
	                Twig.log.error("Error parsing twig template " + that.id + ": ");
	                if (ex.stack) {
	                    Twig.log.error(ex.stack);
	                } else {
	                    Twig.log.error(ex.toString());
	                }

	                if (Twig.debug) {
	                    return ex.toString();
	                }
	            }
	        }

	        promise = Twig.async.forEach(tokens, function parseToken(token) {
	            Twig.log.debug("Twig.parse: ", "Parsing token: ", token);

	            switch (token.type) {
	                case Twig.token.type.raw:
	                    output.push(Twig.filters.raw(token.value));
	                    break;

	                case Twig.token.type.logic:
	                    var logic_token = token.token;

	                    return Twig.logic.parseAsync.apply(that, [logic_token, context, chain])
	                    .then(function(logic) {
	                        if (logic.chain !== undefined) {
	                            chain = logic.chain;
	                        }
	                        if (logic.context !== undefined) {
	                            context = logic.context;
	                        }
	                        if (logic.output !== undefined) {
	                            output.push(logic.output);
	                        }
	                    });
	                    break;

	                case Twig.token.type.comment:
	                    // Do nothing, comments should be ignored
	                    break;

	                //Fall through whitespace to output
	                case Twig.token.type.output_whitespace_pre:
	                case Twig.token.type.output_whitespace_post:
	                case Twig.token.type.output_whitespace_both:
	                case Twig.token.type.output:
	                    Twig.log.debug("Twig.parse: ", "Output token: ", token.stack);
	                    // Parse the given expression in the given context
	                    return Twig.expression.parseAsync.apply(that, [token.stack, context])
	                    .then(function(o) {
	                        output.push(o);
	                    });
	            }
	        })
	        .then(function() {
	            output = Twig.output.apply(that, [output]);
	            is_async = false;
	            return output;
	        })
	        .catch(function(e) {
	            if (allow_async)
	                handleException(e);

	            err = e;
	        });

	        // If `allow_async` we will always return a promise since we do not
	        // know in advance if we are going to run asynchronously or not.
	        if (allow_async)
	            return promise;

	        // Handle errors here if we fail synchronously.
	        if (err !== null)
	            return handleException(err);

	        // If `allow_async` is not true we should not allow the user
	        // to use asynchronous functions or filters.
	        if (is_async)
	            throw new Twig.Error('You are using Twig.js in sync mode in combination with async extensions.');

	        return output;
	    };

	    /**
	     * Tokenize and compile a string template.
	     *
	     * @param {string} data The template.
	     *
	     * @return {Array} The compiled tokens.
	     */
	    Twig.prepare = function(data) {
	        var tokens, raw_tokens;

	        // Tokenize
	        Twig.log.debug("Twig.prepare: ", "Tokenizing ", data);
	        raw_tokens = Twig.tokenize.apply(this, [data]);

	        // Compile
	        Twig.log.debug("Twig.prepare: ", "Compiling ", raw_tokens);
	        tokens = Twig.compile.apply(this, [raw_tokens]);

	        Twig.log.debug("Twig.prepare: ", "Compiled ", tokens);

	        return tokens;
	    };

	    /**
	     * Join the output token's stack and escape it if needed
	     *
	     * @param {Array} Output token's stack
	     *
	     * @return {string|String} Autoescaped output
	     */
	    Twig.output = function(output) {
	        if (!this.options.autoescape) {
	            return output.join("");
	        }

	        var strategy = 'html';
	        if(typeof this.options.autoescape == 'string')
	            strategy = this.options.autoescape;

	        // [].map would be better but it's not supported by IE8-
	        var escaped_output = [];
	        Twig.forEach(output, function (str) {
	            if (str && (str.twig_markup !== true && str.twig_markup != strategy)) {
	                str = Twig.filters.escape(str, [ strategy ]);
	            }
	            escaped_output.push(str);
	        });
	        return Twig.Markup(escaped_output.join(""));
	    }

	    // Namespace for template storage and retrieval
	    Twig.Templates = {
	        /**
	         * Registered template loaders - use Twig.Templates.registerLoader to add supported loaders
	         * @type {Object}
	         */
	        loaders: {},

	        /**
	         * Registered template parsers - use Twig.Templates.registerParser to add supported parsers
	         * @type {Object}
	         */
	        parsers: {},

	        /**
	         * Cached / loaded templates
	         * @type {Object}
	         */
	        registry: {}
	    };

	    /**
	     * Is this id valid for a twig template?
	     *
	     * @param {string} id The ID to check.
	     *
	     * @throws {Twig.Error} If the ID is invalid or used.
	     * @return {boolean} True if the ID is valid.
	     */
	    Twig.validateId = function(id) {
	        if (id === "prototype") {
	            throw new Twig.Error(id + " is not a valid twig identifier");
	        } else if (Twig.cache && Twig.Templates.registry.hasOwnProperty(id)) {
	            throw new Twig.Error("There is already a template with the ID " + id);
	        }
	        return true;
	    }

	    /**
	     * Register a template loader
	     *
	     * @example
	     * Twig.extend(function(Twig) {
	     *    Twig.Templates.registerLoader('custom_loader', function(location, params, callback, error_callback) {
	     *        // ... load the template ...
	     *        params.data = loadedTemplateData;
	     *        // create and return the template
	     *        var template = new Twig.Template(params);
	     *        if (typeof callback === 'function') {
	     *            callback(template);
	     *        }
	     *        return template;
	     *    });
	     * });
	     *
	     * @param {String} method_name The method this loader is intended for (ajax, fs)
	     * @param {Function} func The function to execute when loading the template
	     * @param {Object|undefined} scope Optional scope parameter to bind func to
	     *
	     * @throws Twig.Error
	     *
	     * @return {void}
	     */
	    Twig.Templates.registerLoader = function(method_name, func, scope) {
	        if (typeof func !== 'function') {
	            throw new Twig.Error('Unable to add loader for ' + method_name + ': Invalid function reference given.');
	        }
	        if (scope) {
	            func = func.bind(scope);
	        }
	        this.loaders[method_name] = func;
	    };

	    /**
	     * Remove a registered loader
	     *
	     * @param {String} method_name The method name for the loader you wish to remove
	     *
	     * @return {void}
	     */
	    Twig.Templates.unRegisterLoader = function(method_name) {
	        if (this.isRegisteredLoader(method_name)) {
	            delete this.loaders[method_name];
	        }
	    };

	    /**
	     * See if a loader is registered by its method name
	     *
	     * @param {String} method_name The name of the loader you are looking for
	     *
	     * @return {boolean}
	     */
	    Twig.Templates.isRegisteredLoader = function(method_name) {
	        return this.loaders.hasOwnProperty(method_name);
	    };

	    /**
	     * Register a template parser
	     *
	     * @example
	     * Twig.extend(function(Twig) {
	     *    Twig.Templates.registerParser('custom_parser', function(params) {
	     *        // this template source can be accessed in params.data
	     *        var template = params.data
	     *
	     *        // ... custom process that modifies the template
	     *
	     *        // return the parsed template
	     *        return template;
	     *    });
	     * });
	     *
	     * @param {String} method_name The method this parser is intended for (twig, source)
	     * @param {Function} func The function to execute when parsing the template
	     * @param {Object|undefined} scope Optional scope parameter to bind func to
	     *
	     * @throws Twig.Error
	     *
	     * @return {void}
	     */
	    Twig.Templates.registerParser = function(method_name, func, scope) {
	        if (typeof func !== 'function') {
	            throw new Twig.Error('Unable to add parser for ' + method_name + ': Invalid function regerence given.');
	        }

	        if (scope) {
	            func = func.bind(scope);
	        }

	        this.parsers[method_name] = func;
	    };

	    /**
	     * Remove a registered parser
	     *
	     * @param {String} method_name The method name for the parser you wish to remove
	     *
	     * @return {void}
	     */
	    Twig.Templates.unRegisterParser = function(method_name) {
	        if (this.isRegisteredParser(method_name)) {
	            delete this.parsers[method_name];
	        }
	    };

	    /**
	     * See if a parser is registered by its method name
	     *
	     * @param {String} method_name The name of the parser you are looking for
	     *
	     * @return {boolean}
	     */
	    Twig.Templates.isRegisteredParser = function(method_name) {
	        return this.parsers.hasOwnProperty(method_name);
	    };

	    /**
	     * Save a template object to the store.
	     *
	     * @param {Twig.Template} template   The twig.js template to store.
	     */
	    Twig.Templates.save = function(template) {
	        if (template.id === undefined) {
	            throw new Twig.Error("Unable to save template with no id");
	        }
	        Twig.Templates.registry[template.id] = template;
	    };

	    /**
	     * Load a previously saved template from the store.
	     *
	     * @param {string} id   The ID of the template to load.
	     *
	     * @return {Twig.Template} A twig.js template stored with the provided ID.
	     */
	    Twig.Templates.load = function(id) {
	        if (!Twig.Templates.registry.hasOwnProperty(id)) {
	            return null;
	        }
	        return Twig.Templates.registry[id];
	    };

	    /**
	     * Load a template from a remote location using AJAX and saves in with the given ID.
	     *
	     * Available parameters:
	     *
	     *      async:       Should the HTTP request be performed asynchronously.
	     *                      Defaults to true.
	     *      method:      What method should be used to load the template
	     *                      (fs or ajax)
	     *      parser:      What method should be used to parse the template
	     *                      (twig or source)
	     *      precompiled: Has the template already been compiled.
	     *
	     * @param {string} location  The remote URL to load as a template.
	     * @param {Object} params The template parameters.
	     * @param {function} callback  A callback triggered when the template finishes loading.
	     * @param {function} error_callback  A callback triggered if an error occurs loading the template.
	     *
	     *
	     */
	    Twig.Templates.loadRemote = function(location, params, callback, error_callback) {
	        var loader;

	        // Default to async
	        if (params.async === undefined) {
	            params.async = true;
	        }

	        // Default to the URL so the template is cached.
	        if (params.id === undefined) {
	            params.id = location;
	        }

	        // Check for existing template
	        if (Twig.cache && Twig.Templates.registry.hasOwnProperty(params.id)) {
	            // A template is already saved with the given id.
	            if (typeof callback === 'function') {
	                callback(Twig.Templates.registry[params.id]);
	            }
	            // TODO: if async, return deferred promise
	            return Twig.Templates.registry[params.id];
	        }

	        //if the parser name hasn't been set, default it to twig
	        params.parser = params.parser || 'twig';

	        // Assume 'fs' if the loader is not defined
	        loader = this.loaders[params.method] || this.loaders.fs;
	        return loader.apply(this, arguments);
	    };

	    // Determine object type
	    function is(type, obj) {
	        var clas = Object.prototype.toString.call(obj).slice(8, -1);
	        return obj !== undefined && obj !== null && clas === type;
	    }

	    /**
	     * Create a new twig.js template.
	     *
	     * Parameters: {
	     *      data:   The template, either pre-compiled tokens or a string template
	     *      id:     The name of this template
	     *      blocks: Any pre-existing block from a child template
	     * }
	     *
	     * @param {Object} params The template parameters.
	     */
	    Twig.Template = function ( params ) {
	        var data = params.data,
	            id = params.id,
	            blocks = params.blocks,
	            macros = params.macros || {},
	            base = params.base,
	            path = params.path,
	            url = params.url,
	            name = params.name,
	            method = params.method,
	            // parser options
	            options = params.options;

	        // # What is stored in a Twig.Template
	        //
	        // The Twig Template hold several chucks of data.
	        //
	        //     {
	        //          id:     The token ID (if any)
	        //          tokens: The list of tokens that makes up this template.
	        //          blocks: The list of block this template contains.
	        //          base:   The base template (if any)
	        //            options:  {
	        //                Compiler/parser options
	        //
	        //                strict_variables: true/false
	        //                    Should missing variable/keys emit an error message. If false, they default to null.
	        //            }
	        //     }
	        //

	        this.id     = id;
	        this.method = method;
	        this.base   = base;
	        this.path   = path;
	        this.url    = url;
	        this.name   = name;
	        this.macros = macros;
	        this.options = options;

	        this.reset(blocks);

	        if (is('String', data)) {
	            this.tokens = Twig.prepare.apply(this, [data]);
	        } else {
	            this.tokens = data;
	        }

	        if (id !== undefined) {
	            Twig.Templates.save(this);
	        }
	    };

	    Twig.Template.prototype.reset = function(blocks) {
	        Twig.log.debug("Twig.Template.reset", "Reseting template " + this.id);
	        this.blocks = {};
	        this.importedBlocks = [];
	        this.originalBlockTokens = {};
	        this.child = {
	            blocks: blocks || {}
	        };
	        this.extend = null;
	    };

	    Twig.Template.prototype.render = function (context, params, allow_async) {
	        params = params || {};

	        var that = this,

	            // Store any error that might be thrown by the promise chain.
	            err = null,

	            // This will be set to is_async if template renders synchronously
	            is_async = true,
	            promise = null,

	            result,
	            url;

	        this.context = context || {};

	        // Clear any previous state
	        this.reset();
	        if (params.blocks) {
	            this.blocks = params.blocks;
	        }
	        if (params.macros) {
	            this.macros = params.macros;
	        }

	        var cb = function(output) {
	            // Does this template extend another
	            if (that.extend) {
	                var ext_template;

	                // check if the template is provided inline
	                if ( that.options.allowInlineIncludes ) {
	                    ext_template = Twig.Templates.load(that.extend);
	                    if ( ext_template ) {
	                        ext_template.options = that.options;
	                    }
	                }

	                // check for the template file via include
	                if (!ext_template) {
	                    url = Twig.path.parsePath(that, that.extend);

	                    ext_template = Twig.Templates.loadRemote(url, {
	                        method: that.getLoaderMethod(),
	                        base: that.base,
	                        async:  false,
	                        id:     url,
	                        options: that.options
	                    });
	                }

	                that.parent = ext_template;

	                return that.parent.renderAsync(that.context, {
	                    blocks: that.blocks
	                });
	            }

	            if (params.output == 'blocks') {
	                return that.blocks;
	            } else if (params.output == 'macros') {
	                return that.macros;
	            } else {
	                return output;
	            }
	        };

	        promise = Twig.parseAsync.apply(this, [this.tokens, this.context])
	        .then(cb)
	        .then(function(v) {
	            is_async = false;
	            result = v;
	            return v;
	        })
	        .catch(function(e) {
	            if (allow_async)
	                throw e;

	            err = e;
	        })

	        // If `allow_async` we will always return a promise since we do not
	        // know in advance if we are going to run asynchronously or not.
	        if (allow_async)
	            return promise;

	        // Handle errors here if we fail synchronously.
	        if (err !== null)
	            throw err;

	        // If `allow_async` is not true we should not allow the user
	        // to use asynchronous functions or filters.
	        if (is_async)
	            throw new Twig.Error('You are using Twig.js in sync mode in combination with async extensions.');

	        return result;
	    };

	    Twig.Template.prototype.importFile = function(file) {
	        var url, sub_template;
	        if (!this.url && this.options.allowInlineIncludes) {
	            file = this.path ? Twig.path.parsePath(this, file) : file;
	            sub_template = Twig.Templates.load(file);

	            if (!sub_template) {
	                sub_template = Twig.Templates.loadRemote(url, {
	                    id: file,
	                    method: this.getLoaderMethod(),
	                    async: false,
	                    path: file,
	                    options: this.options
	                });

	                if (!sub_template) {
	                    throw new Twig.Error("Unable to find the template " + file);
	                }
	            }

	            sub_template.options = this.options;

	            return sub_template;
	        }

	        url = Twig.path.parsePath(this, file);

	        // Load blocks from an external file
	        sub_template = Twig.Templates.loadRemote(url, {
	            method: this.getLoaderMethod(),
	            base: this.base,
	            async: false,
	            options: this.options,
	            id: url
	        });

	        return sub_template;
	    };

	    Twig.Template.prototype.importBlocks = function(file, override) {
	        var sub_template = this.importFile(file),
	            context = this.context,
	            that = this,
	            key;

	        override = override || false;

	        sub_template.render(context);

	        // Mixin blocks
	        Twig.forEach(Object.keys(sub_template.blocks), function(key) {
	            if (override || that.blocks[key] === undefined) {
	                that.blocks[key] = sub_template.blocks[key];
	                that.importedBlocks.push(key);
	            }
	        });
	    };

	    Twig.Template.prototype.importMacros = function(file) {
	        var url = Twig.path.parsePath(this, file);

	        // load remote template
	        var remoteTemplate = Twig.Templates.loadRemote(url, {
	            method: this.getLoaderMethod(),
	            async: false,
	            id: url
	        });

	        return remoteTemplate;
	    };

	    Twig.Template.prototype.getLoaderMethod = function() {
	        if (this.path) {
	            return 'fs';
	        }
	        if (this.url) {
	            return 'ajax';
	        }
	        return this.method || 'fs';
	    };

	    Twig.Template.prototype.compile = function(options) {
	        // compile the template into raw JS
	        return Twig.compiler.compile(this, options);
	    };

	    /**
	     * Create safe output
	     *
	     * @param {string} Content safe to output
	     *
	     * @return {String} Content wrapped into a String
	     */

	    Twig.Markup = function(content, strategy) {
	        if(typeof strategy == 'undefined') {
	            strategy = true;
	        }

	        if (typeof content === 'string' && content.length > 0) {
	            content = new String(content);
	            content.twig_markup = strategy;
	        }
	        return content;
	    };

	    return Twig;

	};


/***/ },
/* 2 */
/***/ function(module, exports) {

	// ## twig.compiler.js
	//
	// This file handles compiling templates into JS
	module.exports = function (Twig) {
	    /**
	     * Namespace for compilation.
	     */
	    Twig.compiler = {
	        module: {}
	    };

	    // Compile a Twig Template to output.
	    Twig.compiler.compile = function(template, options) {
	        // Get tokens
	        var tokens = JSON.stringify(template.tokens)
	            , id = template.id
	            , output;

	        if (options.module) {
	            if (Twig.compiler.module[options.module] === undefined) {
	                throw new Twig.Error("Unable to find module type " + options.module);
	            }
	            output = Twig.compiler.module[options.module](id, tokens, options.twig);
	        } else {
	            output = Twig.compiler.wrap(id, tokens);
	        }
	        return output;
	    };

	    Twig.compiler.module = {
	        amd: function(id, tokens, pathToTwig) {
	            return 'define(["' + pathToTwig + '"], function (Twig) {\n\tvar twig, templates;\ntwig = Twig.twig;\ntemplates = ' + Twig.compiler.wrap(id, tokens) + '\n\treturn templates;\n});';
	        }
	        , node: function(id, tokens) {
	            return 'var twig = require("twig").twig;\n'
	                + 'exports.template = ' + Twig.compiler.wrap(id, tokens)
	        }
	        , cjs2: function(id, tokens, pathToTwig) {
	            return 'module.declare([{ twig: "' + pathToTwig + '" }], function (require, exports, module) {\n'
	                        + '\tvar twig = require("twig").twig;\n'
	                        + '\texports.template = ' + Twig.compiler.wrap(id, tokens)
	                    + '\n});'
	        }
	    };

	    Twig.compiler.wrap = function(id, tokens) {
	        return 'twig({id:"'+id.replace('"', '\\"')+'", data:'+tokens+', precompiled: true});\n';
	    };

	    return Twig;
	};


/***/ },
/* 3 */
/***/ function(module, exports, __webpack_require__) {

	// ## twig.expression.js
	//
	// This file handles tokenizing, compiling and parsing expressions.
	module.exports = function (Twig) {
	    "use strict";

	    function parseParams(thisArg, params, context) {
	        if (params)
	            return Twig.expression.parseAsync.apply(thisArg, [params, context]);

	        return Twig.Promise.resolve(false);
	    }

	    /**
	     * Namespace for expression handling.
	     */
	    Twig.expression = { };

	    __webpack_require__(4)(Twig);

	    /**
	     * Reserved word that can't be used as variable names.
	     */
	    Twig.expression.reservedWords = [
	        "true", "false", "null", "TRUE", "FALSE", "NULL", "_context", "and", "b-and", "or", "b-or", "b-xor", "in", "not in", "if"
	    ];

	    /**
	     * The type of tokens used in expressions.
	     */
	    Twig.expression.type = {
	        comma:      'Twig.expression.type.comma',
	        operator: {
	            unary:  'Twig.expression.type.operator.unary',
	            binary: 'Twig.expression.type.operator.binary'
	        },
	        string:     'Twig.expression.type.string',
	        bool:       'Twig.expression.type.bool',
	        slice:      'Twig.expression.type.slice',
	        array: {
	            start:  'Twig.expression.type.array.start',
	            end:    'Twig.expression.type.array.end'
	        },
	        object: {
	            start:  'Twig.expression.type.object.start',
	            end:    'Twig.expression.type.object.end'
	        },
	        parameter: {
	            start:  'Twig.expression.type.parameter.start',
	            end:    'Twig.expression.type.parameter.end'
	        },
	        subexpression: {
	            start:  'Twig.expression.type.subexpression.start',
	            end:    'Twig.expression.type.subexpression.end'
	        },
	        key: {
	            period:   'Twig.expression.type.key.period',
	            brackets: 'Twig.expression.type.key.brackets'
	        },
	        filter:     'Twig.expression.type.filter',
	        _function:  'Twig.expression.type._function',
	        variable:   'Twig.expression.type.variable',
	        number:     'Twig.expression.type.number',
	        _null:     'Twig.expression.type.null',
	        context:    'Twig.expression.type.context',
	        test:       'Twig.expression.type.test'
	    };

	    Twig.expression.set = {
	        // What can follow an expression (in general)
	        operations: [
	            Twig.expression.type.filter,
	            Twig.expression.type.operator.unary,
	            Twig.expression.type.operator.binary,
	            Twig.expression.type.array.end,
	            Twig.expression.type.object.end,
	            Twig.expression.type.parameter.end,
	            Twig.expression.type.subexpression.end,
	            Twig.expression.type.comma,
	            Twig.expression.type.test
	        ],
	        expressions: [
	            Twig.expression.type._function,
	            Twig.expression.type.bool,
	            Twig.expression.type.string,
	            Twig.expression.type.variable,
	            Twig.expression.type.number,
	            Twig.expression.type._null,
	            Twig.expression.type.context,
	            Twig.expression.type.parameter.start,
	            Twig.expression.type.array.start,
	            Twig.expression.type.object.start,
	            Twig.expression.type.subexpression.start,
	            Twig.expression.type.operator.unary
	        ]
	    };

	    // Most expressions allow a '.' or '[' after them, so we provide a convenience set
	    Twig.expression.set.operations_extended = Twig.expression.set.operations.concat([
	                    Twig.expression.type.key.period,
	                    Twig.expression.type.key.brackets,
	                    Twig.expression.type.slice]);

	    // Some commonly used compile and parse functions.
	    Twig.expression.fn = {
	        compile: {
	            push: function(token, stack, output) {
	                output.push(token);
	            },
	            push_both: function(token, stack, output) {
	                output.push(token);
	                stack.push(token);
	            }
	        },
	        parse: {
	            push: function(token, stack, context) {
	                stack.push(token);
	            },
	            push_value: function(token, stack, context) {
	                stack.push(token.value);
	            }
	        }
	    };

	    // The regular expressions and compile/parse logic used to match tokens in expressions.
	    //
	    // Properties:
	    //
	    //      type:  The type of expression this matches
	    //
	    //      regex: One or more regular expressions that matche the format of the token.
	    //
	    //      next:  Valid tokens that can occur next in the expression.
	    //
	    // Functions:
	    //
	    //      compile: A function that compiles the raw regular expression match into a token.
	    //
	    //      parse:   A function that parses the compiled token into output.
	    //
	    Twig.expression.definitions = [
	        {
	            type: Twig.expression.type.test,
	            regex: /^is\s+(not)?\s*([a-zA-Z_][a-zA-Z0-9_]*(\s?as)?)/,
	            next: Twig.expression.set.operations.concat([Twig.expression.type.parameter.start]),
	            compile: function(token, stack, output) {
	                token.filter   = token.match[2];
	                token.modifier = token.match[1];
	                delete token.match;
	                delete token.value;
	                output.push(token);
	            },
	            parse: function(token, stack, context) {
	                var value = stack.pop();

	                return parseParams(this, token.params, context)
	                .then(function(params) {
	                    var result = Twig.test(token.filter, value, params);

	                    if (token.modifier == 'not') {
	                        stack.push(!result);
	                    } else {
	                        stack.push(result);
	                    }
	                });
	            }
	        },
	        {
	            type: Twig.expression.type.comma,
	            // Match a comma
	            regex: /^,/,
	            next: Twig.expression.set.expressions.concat([Twig.expression.type.array.end, Twig.expression.type.object.end]),
	            compile: function(token, stack, output) {
	                var i = stack.length - 1,
	                    stack_token;

	                delete token.match;
	                delete token.value;

	                // pop tokens off the stack until the start of the object
	                for(;i >= 0; i--) {
	                    stack_token = stack.pop();
	                    if (stack_token.type === Twig.expression.type.object.start
	                            || stack_token.type === Twig.expression.type.parameter.start
	                            || stack_token.type === Twig.expression.type.array.start) {
	                        stack.push(stack_token);
	                        break;
	                    }
	                    output.push(stack_token);
	                }
	                output.push(token);
	            }
	        },
	        {
	            /**
	             * Match a number (integer or decimal)
	             */
	            type: Twig.expression.type.number,
	            // match a number
	            regex: /^\-?\d+(\.\d+)?/,
	            next: Twig.expression.set.operations,
	            compile: function(token, stack, output) {
	                token.value = Number(token.value);
	                output.push(token);
	            },
	            parse: Twig.expression.fn.parse.push_value
	        },
	        {
	            type: Twig.expression.type.operator.binary,
	            // Match any of ?:, +, *, /, -, %, ~, <, <=, >, >=, !=, ==, **, ?, :, and, b-and, or, b-or, b-xor, in, not in
	            // and, or, in, not in can be followed by a space or parenthesis
	            regex: /(^\?\:|^(b\-and)|^(b\-or)|^(b\-xor)|^[\+\-~%\?]|^[\:](?!\d\])|^[!=]==?|^[!<>]=?|^\*\*?|^\/\/?|^(and)[\(|\s+]|^(or)[\(|\s+]|^(in)[\(|\s+]|^(not in)[\(|\s+]|^\.\.)/,
	            next: Twig.expression.set.expressions,
	            transform: function(match, tokens) {
	                switch(match[0]) {
	                    case 'and(':
	                    case 'or(':
	                    case 'in(':
	                    case 'not in(':
	                        //Strip off the ( if it exists
	                        tokens[tokens.length - 1].value = match[2];
	                        return match[0];
	                        break;
	                    default:
	                        return '';
	                }
	            },
	            compile: function(token, stack, output) {
	                delete token.match;

	                token.value = token.value.trim();
	                var value = token.value,
	                    operator = Twig.expression.operator.lookup(value, token);

	                Twig.log.trace("Twig.expression.compile: ", "Operator: ", operator, " from ", value);

	                while (stack.length > 0 &&
	                       (stack[stack.length-1].type == Twig.expression.type.operator.unary || stack[stack.length-1].type == Twig.expression.type.operator.binary) &&
	                            (
	                                (operator.associativity === Twig.expression.operator.leftToRight &&
	                                 operator.precidence    >= stack[stack.length-1].precidence) ||

	                                (operator.associativity === Twig.expression.operator.rightToLeft &&
	                                 operator.precidence    >  stack[stack.length-1].precidence)
	                            )
	                       ) {
	                     var temp = stack.pop();
	                     output.push(temp);
	                }

	                if (value === ":") {
	                    // Check if this is a ternary or object key being set
	                    if (stack[stack.length - 1] && stack[stack.length-1].value === "?") {
	                        // Continue as normal for a ternary
	                    } else {
	                        // This is not a ternary so we push the token to the output where it can be handled
	                        //   when the assocated object is closed.
	                        var key_token = output.pop();

	                        if (key_token.type === Twig.expression.type.string ||
	                                key_token.type === Twig.expression.type.variable) {
	                            token.key = key_token.value;
	                        } else if (key_token.type === Twig.expression.type.number) {
	                            // Convert integer keys into string keys
	                            token.key = key_token.value.toString();
	                        } else if (key_token.expression &&
	                            (key_token.type === Twig.expression.type.parameter.end ||
	                            key_token.type == Twig.expression.type.subexpression.end)) {
	                            token.params = key_token.params;
	                        } else {
	                            throw new Twig.Error("Unexpected value before ':' of " + key_token.type + " = " + key_token.value);
	                        }

	                        output.push(token);
	                        return;
	                    }
	                } else {
	                    stack.push(operator);
	                }
	            },
	            parse: function(token, stack, context) {
	                if (token.key) {
	                    // handle ternary ':' operator
	                    stack.push(token);
	                } else if (token.params) {
	                    // handle "{(expression):value}"
	                    return Twig.expression.parseAsync.apply(this, [token.params, context])
	                    .then(function(key) {
	                        token.key = key;
	                        stack.push(token);

	                        //If we're in a loop, we might need token.params later, especially in this form of "(expression):value"
	                        if (!context.loop) {
	                            delete(token.params);
	                        }
	                    });
	                } else {
	                    Twig.expression.operator.parse(token.value, stack);
	                }
	            }
	        },
	        {
	            type: Twig.expression.type.operator.unary,
	            // Match any of not
	            regex: /(^not\s+)/,
	            next: Twig.expression.set.expressions,
	            compile: function(token, stack, output) {
	                delete token.match;

	                token.value = token.value.trim();
	                var value = token.value,
	                    operator = Twig.expression.operator.lookup(value, token);

	                Twig.log.trace("Twig.expression.compile: ", "Operator: ", operator, " from ", value);

	                while (stack.length > 0 &&
	                       (stack[stack.length-1].type == Twig.expression.type.operator.unary || stack[stack.length-1].type == Twig.expression.type.operator.binary) &&
	                            (
	                                (operator.associativity === Twig.expression.operator.leftToRight &&
	                                 operator.precidence    >= stack[stack.length-1].precidence) ||

	                                (operator.associativity === Twig.expression.operator.rightToLeft &&
	                                 operator.precidence    >  stack[stack.length-1].precidence)
	                            )
	                       ) {
	                     var temp = stack.pop();
	                     output.push(temp);
	                }

	                stack.push(operator);
	            },
	            parse: function(token, stack, context) {
	                Twig.expression.operator.parse(token.value, stack);
	            }
	        },
	        {
	            /**
	             * Match a string. This is anything between a pair of single or double quotes.
	             */
	            type: Twig.expression.type.string,
	            // See: http://blog.stevenlevithan.com/archives/match-quoted-string
	            regex: /^(["'])(?:(?=(\\?))\2[\s\S])*?\1/,
	            next: Twig.expression.set.operations_extended,
	            compile: function(token, stack, output) {
	                var value = token.value;
	                delete token.match

	                // Remove the quotes from the string
	                if (value.substring(0, 1) === '"') {
	                    value = value.replace('\\"', '"');
	                } else {
	                    value = value.replace("\\'", "'");
	                }
	                token.value = value.substring(1, value.length-1).replace( /\\n/g, "\n" ).replace( /\\r/g, "\r" );
	                Twig.log.trace("Twig.expression.compile: ", "String value: ", token.value);
	                output.push(token);
	            },
	            parse: Twig.expression.fn.parse.push_value
	        },
	        {
	            /**
	             * Match a subexpression set start.
	             */
	            type: Twig.expression.type.subexpression.start,
	            regex: /^\(/,
	            next: Twig.expression.set.expressions.concat([Twig.expression.type.subexpression.end]),
	            compile: function(token, stack, output) {
	                token.value = '(';
	                output.push(token);
	                stack.push(token);
	            },
	            parse: Twig.expression.fn.parse.push
	        },
	        {
	            /**
	             * Match a subexpression set end.
	             */
	            type: Twig.expression.type.subexpression.end,
	            regex: /^\)/,
	            next: Twig.expression.set.operations_extended,
	            validate: function(match, tokens) {
	                // Iterate back through previous tokens to ensure we follow a subexpression start
	                var i = tokens.length - 1,
	                    found_subexpression_start = false,
	                    next_subexpression_start_invalid = false,
	                    unclosed_parameter_count = 0;

	                while(!found_subexpression_start && i >= 0) {
	                    var token = tokens[i];

	                    found_subexpression_start = token.type === Twig.expression.type.subexpression.start;

	                    // If we have previously found a subexpression end, then this subexpression start is the start of
	                    // that subexpression, not the subexpression we are searching for
	                    if (found_subexpression_start && next_subexpression_start_invalid) {
	                        next_subexpression_start_invalid = false;
	                        found_subexpression_start = false;
	                    }

	                    // Count parameter tokens to ensure we dont return truthy for a parameter opener
	                    if (token.type === Twig.expression.type.parameter.start) {
	                        unclosed_parameter_count++;
	                    } else if (token.type === Twig.expression.type.parameter.end) {
	                        unclosed_parameter_count--;
	                    } else if (token.type === Twig.expression.type.subexpression.end) {
	                        next_subexpression_start_invalid = true;
	                    }

	                    i--;
	                }

	                // If we found unclosed parameters, return false
	                // If we didnt find subexpression start, return false
	                // Otherwise return true

	                return (found_subexpression_start && (unclosed_parameter_count === 0));
	            },
	            compile: function(token, stack, output) {
	                // This is basically a copy of parameter end compilation
	                var stack_token,
	                    end_token = token;

	                stack_token = stack.pop();
	                while(stack.length > 0 && stack_token.type != Twig.expression.type.subexpression.start) {
	                    output.push(stack_token);
	                    stack_token = stack.pop();
	                }

	                // Move contents of parens into preceding filter
	                var param_stack = [];
	                while(token.type !== Twig.expression.type.subexpression.start) {
	                    // Add token to arguments stack
	                    param_stack.unshift(token);
	                    token = output.pop();
	                }

	                param_stack.unshift(token);

	                var is_expression = false;

	                //If the token at the top of the *stack* is a function token, pop it onto the output queue.
	                // Get the token preceding the parameters
	                stack_token = stack[stack.length-1];

	                if (stack_token === undefined ||
	                    (stack_token.type !== Twig.expression.type._function &&
	                    stack_token.type !== Twig.expression.type.filter &&
	                    stack_token.type !== Twig.expression.type.test &&
	                    stack_token.type !== Twig.expression.type.key.brackets)) {

	                    end_token.expression = true;

	                    // remove start and end token from stack
	                    param_stack.pop();
	                    param_stack.shift();

	                    end_token.params = param_stack;

	                    output.push(end_token);
	                } else {
	                    // This should never be hit
	                    end_token.expression = false;
	                    stack_token.params = param_stack;
	                }
	            },
	            parse: function(token, stack, context) {
	                var new_array = [],
	                    array_ended = false,
	                    value = null;

	                if (token.expression) {
	                    return Twig.expression.parseAsync.apply(this, [token.params, context])
	                    .then(function(value) {
	                        stack.push(value);
	                    });
	                } else {
	                    throw new Twig.Error("Unexpected subexpression end when token is not marked as an expression");
	                }
	            }
	        },
	        {
	            /**
	             * Match a parameter set start.
	             */
	            type: Twig.expression.type.parameter.start,
	            regex: /^\(/,
	            next: Twig.expression.set.expressions.concat([Twig.expression.type.parameter.end]),
	            validate: function(match, tokens) {
	                var last_token = tokens[tokens.length - 1];
	                // We can't use the regex to test if we follow a space because expression is trimmed
	                return last_token && (Twig.indexOf(Twig.expression.reservedWords, last_token.value.trim()) < 0);
	            },
	            compile: Twig.expression.fn.compile.push_both,
	            parse: Twig.expression.fn.parse.push
	        },
	        {
	            /**
	             * Match a parameter set end.
	             */
	            type: Twig.expression.type.parameter.end,
	            regex: /^\)/,
	            next: Twig.expression.set.operations_extended,
	            compile: function(token, stack, output) {
	                var stack_token,
	                    end_token = token;

	                stack_token = stack.pop();
	                while(stack.length > 0 && stack_token.type != Twig.expression.type.parameter.start) {
	                    output.push(stack_token);
	                    stack_token = stack.pop();
	                }

	                // Move contents of parens into preceding filter
	                var param_stack = [];
	                while(token.type !== Twig.expression.type.parameter.start) {
	                    // Add token to arguments stack
	                    param_stack.unshift(token);
	                    token = output.pop();
	                }
	                param_stack.unshift(token);

	                var is_expression = false;

	                // Get the token preceding the parameters
	                token = output[output.length-1];

	                if (token === undefined ||
	                    (token.type !== Twig.expression.type._function &&
	                    token.type !== Twig.expression.type.filter &&
	                    token.type !== Twig.expression.type.test &&
	                    token.type !== Twig.expression.type.key.brackets)) {

	                    end_token.expression = true;

	                    // remove start and end token from stack
	                    param_stack.pop();
	                    param_stack.shift();

	                    end_token.params = param_stack;

	                    output.push(end_token);

	                } else {
	                    end_token.expression = false;
	                    token.params = param_stack;
	                }
	            },
	            parse: function(token, stack, context) {
	                var new_array = [],
	                    array_ended = false,
	                    value = null;

	                if (token.expression) {
	                    return Twig.expression.parseAsync.apply(this, [token.params, context])
	                    .then(function(value) {
	                        stack.push(value);
	                    });
	                } else {

	                    while (stack.length > 0) {
	                        value = stack.pop();
	                        // Push values into the array until the start of the array
	                        if (value && value.type && value.type == Twig.expression.type.parameter.start) {
	                            array_ended = true;
	                            break;
	                        }
	                        new_array.unshift(value);
	                    }

	                    if (!array_ended) {
	                        throw new Twig.Error("Expected end of parameter set.");
	                    }

	                    stack.push(new_array);
	                }
	            }
	        },
	        {
	            type: Twig.expression.type.slice,
	            regex: /^\[(\d*\:\d*)\]/,
	            next: Twig.expression.set.operations_extended,
	            compile: function(token, stack, output) {
	                var sliceRange = token.match[1].split(':');

	                //sliceStart can be undefined when we pass parameters to the slice filter later
	                var sliceStart = (sliceRange[0]) ? parseInt(sliceRange[0]) : undefined;
	                var sliceEnd = (sliceRange[1]) ? parseInt(sliceRange[1]) : undefined;

	                token.value = 'slice';
	                token.params = [sliceStart, sliceEnd];

	                //sliceEnd can't be undefined as the slice filter doesn't check for this, but it does check the length
	                //of the params array, so just shorten it.
	                if (!sliceEnd) {
	                    token.params = [sliceStart];
	                }

	                output.push(token);
	            },
	            parse: function(token, stack, context) {
	                var input = stack.pop(),
	                    params = token.params;

	                stack.push(Twig.filter.apply(this, [token.value, input, params]));
	            }
	        },
	        {
	            /**
	             * Match an array start.
	             */
	            type: Twig.expression.type.array.start,
	            regex: /^\[/,
	            next: Twig.expression.set.expressions.concat([Twig.expression.type.array.end]),
	            compile: Twig.expression.fn.compile.push_both,
	            parse: Twig.expression.fn.parse.push
	        },
	        {
	            /**
	             * Match an array end.
	             */
	            type: Twig.expression.type.array.end,
	            regex: /^\]/,
	            next: Twig.expression.set.operations_extended,
	            compile: function(token, stack, output) {
	                var i = stack.length - 1,
	                    stack_token;
	                // pop tokens off the stack until the start of the object
	                for(;i >= 0; i--) {
	                    stack_token = stack.pop();
	                    if (stack_token.type === Twig.expression.type.array.start) {
	                        break;
	                    }
	                    output.push(stack_token);
	                }
	                output.push(token);
	            },
	            parse: function(token, stack, context) {
	                var new_array = [],
	                    array_ended = false,
	                    value = null;

	                while (stack.length > 0) {
	                    value = stack.pop();
	                    // Push values into the array until the start of the array
	                    if (value.type && value.type == Twig.expression.type.array.start) {
	                        array_ended = true;
	                        break;
	                    }
	                    new_array.unshift(value);
	                }
	                if (!array_ended) {
	                    throw new Twig.Error("Expected end of array.");
	                }

	                stack.push(new_array);
	            }
	        },
	        // Token that represents the start of a hash map '}'
	        //
	        // Hash maps take the form:
	        //    { "key": 'value', "another_key": item }
	        //
	        // Keys must be quoted (either single or double) and values can be any expression.
	        {
	            type: Twig.expression.type.object.start,
	            regex: /^\{/,
	            next: Twig.expression.set.expressions.concat([Twig.expression.type.object.end]),
	            compile: Twig.expression.fn.compile.push_both,
	            parse: Twig.expression.fn.parse.push
	        },

	        // Token that represents the end of a Hash Map '}'
	        //
	        // This is where the logic for building the internal
	        // representation of a hash map is defined.
	        {
	            type: Twig.expression.type.object.end,
	            regex: /^\}/,
	            next: Twig.expression.set.operations_extended,
	            compile: function(token, stack, output) {
	                var i = stack.length-1,
	                    stack_token;

	                // pop tokens off the stack until the start of the object
	                for(;i >= 0; i--) {
	                    stack_token = stack.pop();
	                    if (stack_token && stack_token.type === Twig.expression.type.object.start) {
	                        break;
	                    }
	                    output.push(stack_token);
	                }
	                output.push(token);
	            },
	            parse: function(end_token, stack, context) {
	                var new_object = {},
	                    object_ended = false,
	                    token = null,
	                    token_key = null,
	                    has_value = false,
	                    value = null;

	                while (stack.length > 0) {
	                    token = stack.pop();
	                    // Push values into the array until the start of the object
	                    if (token && token.type && token.type === Twig.expression.type.object.start) {
	                        object_ended = true;
	                        break;
	                    }
	                    if (token && token.type && (token.type === Twig.expression.type.operator.binary || token.type === Twig.expression.type.operator.unary) && token.key) {
	                        if (!has_value) {
	                            throw new Twig.Error("Missing value for key '" + token.key + "' in object definition.");
	                        }
	                        new_object[token.key] = value;

	                        // Preserve the order that elements are added to the map
	                        // This is necessary since JavaScript objects don't
	                        // guarantee the order of keys
	                        if (new_object._keys === undefined) new_object._keys = [];
	                        new_object._keys.unshift(token.key);

	                        // reset value check
	                        value = null;
	                        has_value = false;

	                    } else {
	                        has_value = true;
	                        value = token;
	                    }
	                }
	                if (!object_ended) {
	                    throw new Twig.Error("Unexpected end of object.");
	                }

	                stack.push(new_object);
	            }
	        },

	        // Token representing a filter
	        //
	        // Filters can follow any expression and take the form:
	        //    expression|filter(optional, args)
	        //
	        // Filter parsing is done in the Twig.filters namespace.
	        {
	            type: Twig.expression.type.filter,
	            // match a | then a letter or _, then any number of letters, numbers, _ or -
	            regex: /^\|\s?([a-zA-Z_][a-zA-Z0-9_\-]*)/,
	            next: Twig.expression.set.operations_extended.concat([
	                    Twig.expression.type.parameter.start]),
	            compile: function(token, stack, output) {
	                token.value = token.match[1];
	                output.push(token);
	            },
	            parse: function(token, stack, context) {
	                var that = this,
	                    input = stack.pop();

	                return parseParams(this, token.params, context)
	                .then(function(params) {
	                    return Twig.filter.apply(that, [token.value, input, params]);
	                })
	                .then(function(value) {
	                    stack.push(value);
	                });
	            }
	        },
	        {
	            type: Twig.expression.type._function,
	            // match any letter or _, then any number of letters, numbers, _ or - followed by (
	            regex: /^([a-zA-Z_][a-zA-Z0-9_]*)\s*\(/,
	            next: Twig.expression.type.parameter.start,
	            validate: function(match, tokens) {
	                // Make sure this function is not a reserved word
	                return match[1] && (Twig.indexOf(Twig.expression.reservedWords, match[1]) < 0);
	            },
	            transform: function(match, tokens) {
	                return '(';
	            },
	            compile: function(token, stack, output) {
	                var fn = token.match[1];
	                token.fn = fn;
	                // cleanup token
	                delete token.match;
	                delete token.value;

	                output.push(token);
	            },
	            parse: function(token, stack, context) {

	                var that = this,
	                    fn = token.fn,
	                    value;

	                return parseParams(this, token.params, context)
	                .then(function(params) {
	                    if (Twig.functions[fn]) {
	                        // Get the function from the built-in functions
	                        value = Twig.functions[fn].apply(that, params);

	                    } else if (typeof context[fn] == 'function') {
	                        // Get the function from the user/context defined functions
	                        value = context[fn].apply(context, params);

	                    } else {
	                        throw new Twig.Error(fn + ' function does not exist and is not defined in the context');
	                    }

	                    return value;
	                })
	                .then(function(result) {
	                    stack.push(result);
	                });
	            }
	        },

	        // Token representing a variable.
	        //
	        // Variables can contain letters, numbers, underscores and
	        // dashes, but must start with a letter or underscore.
	        //
	        // Variables are retrieved from the render context and take
	        // the value of 'undefined' if the given variable doesn't
	        // exist in the context.
	        {
	            type: Twig.expression.type.variable,
	            // match any letter or _, then any number of letters, numbers, _ or -
	            regex: /^[a-zA-Z_][a-zA-Z0-9_]*/,
	            next: Twig.expression.set.operations_extended.concat([
	                    Twig.expression.type.parameter.start]),
	            compile: Twig.expression.fn.compile.push,
	            validate: function(match, tokens) {
	                return (Twig.indexOf(Twig.expression.reservedWords, match[0]) < 0);
	            },
	            parse: function(token, stack, context) {
	                // Get the variable from the context
	                return Twig.expression.resolveAsync.apply(this, [context[token.value], context])
	                .then(function(value) {
	                    stack.push(value);
	                });
	            }
	        },
	        {
	            type: Twig.expression.type.key.period,
	            regex: /^\.([a-zA-Z0-9_]+)/,
	            next: Twig.expression.set.operations_extended.concat([
	                    Twig.expression.type.parameter.start]),
	            compile: function(token, stack, output) {
	                token.key = token.match[1];
	                delete token.match;
	                delete token.value;

	                output.push(token);
	            },
	            parse: function(token, stack, context, next_token) {
	                var that = this,
	                    key = token.key,
	                    object = stack.pop(),
	                    value;

	                return parseParams(this, token.params, context)
	                .then(function(params) {
	                    if (object === null || object === undefined) {
	                        if (that.options.strict_variables) {
	                            throw new Twig.Error("Can't access a key " + key + " on an null or undefined object.");
	                        } else {
	                            value = undefined;
	                        }
	                    } else {
	                        var capitalize = function (value) {
	                            return value.substr(0, 1).toUpperCase() + value.substr(1);
	                        };

	                        // Get the variable from the context
	                        if (typeof object === 'object' && key in object) {
	                            value = object[key];
	                        } else if (object["get" + capitalize(key)] !== undefined) {
	                            value = object["get" + capitalize(key)];
	                        } else if (object["is" + capitalize(key)] !== undefined) {
	                            value = object["is" + capitalize(key)];
	                        } else {
	                            value = undefined;
	                        }
	                    }

	                    // When resolving an expression we need to pass next_token in case the expression is a function
	                    return Twig.expression.resolveAsync.apply(that, [value, context, params, next_token, object]);
	                })
	                .then(function(result) {
	                    stack.push(result);
	                });
	            }
	        },
	        {
	            type: Twig.expression.type.key.brackets,
	            regex: /^\[([^\]\:]*)\]/,
	            next: Twig.expression.set.operations_extended.concat([
	                    Twig.expression.type.parameter.start]),
	            compile: function(token, stack, output) {
	                var match = token.match[1];
	                delete token.value;
	                delete token.match;

	                // The expression stack for the key
	                token.stack = Twig.expression.compile({
	                    value: match
	                }).stack;

	                output.push(token);
	            },
	            parse: function(token, stack, context, next_token) {
	                // Evaluate key
	                var that = this,
	                    params = null,
	                    object,
	                    value;

	                return parseParams(this, token.params, context)
	                .then(function(parameters) {
	                    params = parameters;
	                    return Twig.expression.parseAsync.apply(that, [token.stack, context]);
	                })
	                .then(function(key) {
	                    object = stack.pop();

	                    if (object === null || object === undefined) {
	                        if (that.options.strict_variables) {
	                            throw new Twig.Error("Can't access a key " + key + " on an null or undefined object.");
	                        } else {
	                            return null;
	                        }
	                    }

	                    // Get the variable from the context
	                    if (typeof object === 'object' && key in object) {
	                        value = object[key];
	                    } else {
	                        value = null;
	                    }

	                    // When resolving an expression we need to pass next_token in case the expression is a function
	                    return Twig.expression.resolveAsync.apply(that, [value, object, params, next_token]);
	                })
	                .then(function(result) {
	                    stack.push(result);
	                });
	            }
	        },
	        {
	            /**
	             * Match a null value.
	             */
	            type: Twig.expression.type._null,
	            // match a number
	            regex: /^(null|NULL|none|NONE)/,
	            next: Twig.expression.set.operations,
	            compile: function(token, stack, output) {
	                delete token.match;
	                token.value = null;
	                output.push(token);
	            },
	            parse: Twig.expression.fn.parse.push_value
	        },
	        {
	            /**
	             * Match the context
	             */
	            type: Twig.expression.type.context,
	            regex: /^_context/,
	            next: Twig.expression.set.operations_extended.concat([
	                    Twig.expression.type.parameter.start]),
	            compile: Twig.expression.fn.compile.push,
	            parse: function(token, stack, context) {
	                stack.push(context);
	            }
	        },
	        {
	            /**
	             * Match a boolean
	             */
	            type: Twig.expression.type.bool,
	            regex: /^(true|TRUE|false|FALSE)/,
	            next: Twig.expression.set.operations,
	            compile: function(token, stack, output) {
	                token.value = (token.match[0].toLowerCase( ) === "true");
	                delete token.match;
	                output.push(token);
	            },
	            parse: Twig.expression.fn.parse.push_value
	        }
	    ];

	    /**
	     * Resolve a context value.
	     *
	     * If the value is a function, it is executed with a context parameter.
	     *
	     * @param {string} key The context object key.
	     * @param {Object} context The render context.
	     */
	    Twig.expression.resolveAsync = function(value, context, params, next_token, object) {
	        if (typeof value == 'function') {
	            var promise = Twig.Promise.resolve(params);

	            /*
	            If value is a function, it will have been impossible during the compile stage to determine that a following
	            set of parentheses were parameters for this function.

	            Those parentheses will have therefore been marked as an expression, with their own parameters, which really
	            belong to this function.

	            Those parameters will also need parsing in case they are actually an expression to pass as parameters.
	             */
	            if (next_token && next_token.type === Twig.expression.type.parameter.end) {
	                //When parsing these parameters, we need to get them all back, not just the last item on the stack.
	                var tokens_are_parameters = true;

	                promise = promise.then(function() {
	                    return next_token.params && Twig.expression.parseAsync.apply(this, [next_token.params, context, tokens_are_parameters]);
	                })
	                .then(function(p) {
	                    //Clean up the parentheses tokens on the next loop
	                    next_token.cleanup = true;

	                    return p;
	                });
	            }

	            return promise.then(function(params) {
	                return value.apply(object || context, params || []);
	            });
	        } else {
	            return Twig.Promise.resolve(value);
	        }
	    };

	    Twig.expression.resolve = function(value, context, params, next_token, object) {
	        var is_async = true,
	            result;

	        Twig.expression.resolveAsync.apply(this, [value, context, params, next_token, object])
	        .then(function(r) {
	            is_async = false;
	            result = r;
	        });

	        if (is_async)
	            throw new Twig.Error('You are using Twig.js in sync mode in combination with async extensions.');

	        return result;
	    }

	    /**
	     * Registry for logic handlers.
	     */
	    Twig.expression.handler = {};

	    /**
	     * Define a new expression type, available at Twig.logic.type.{type}
	     *
	     * @param {string} type The name of the new type.
	     */
	    Twig.expression.extendType = function (type) {
	        Twig.expression.type[type] = "Twig.expression.type." + type;
	    };

	    /**
	     * Extend the expression parsing functionality with a new definition.
	     *
	     * Token definitions follow this format:
	     *  {
	     *      type:     One of Twig.expression.type.[type], either pre-defined or added using
	     *                    Twig.expression.extendType
	     *
	     *      next:     Array of types from Twig.expression.type that can follow this token,
	     *
	     *      regex:    A regex or array of regex's that should match the token.
	     *
	     *      compile: function(token, stack, output) called when this token is being compiled.
	     *                   Should return an object with stack and output set.
	     *
	     *      parse:   function(token, stack, context) called when this token is being parsed.
	     *                   Should return an object with stack and context set.
	     *  }
	     *
	     * @param {Object} definition A token definition.
	     */
	    Twig.expression.extend = function (definition) {
	        if (!definition.type) {
	            throw new Twig.Error("Unable to extend logic definition. No type provided for " + definition);
	        }
	        Twig.expression.handler[definition.type] = definition;
	    };

	    // Extend with built-in expressions
	    while (Twig.expression.definitions.length > 0) {
	        Twig.expression.extend(Twig.expression.definitions.shift());
	    }

	    /**
	     * Break an expression into tokens defined in Twig.expression.definitions.
	     *
	     * @param {string} expression The string to tokenize.
	     *
	     * @return {Array} An array of tokens.
	     */
	    Twig.expression.tokenize = function (expression) {
	        var tokens = [],
	            // Keep an offset of the location in the expression for error messages.
	            exp_offset = 0,
	            // The valid next tokens of the previous token
	            next = null,
	            // Match information
	            type, regex, regex_array,
	            // The possible next token for the match
	            token_next,
	            // Has a match been found from the definitions
	            match_found, invalid_matches = [], match_function;

	        match_function = function () {
	            var match = Array.prototype.slice.apply(arguments),
	                string = match.pop(),
	                offset = match.pop();

	            Twig.log.trace("Twig.expression.tokenize",
	                           "Matched a ", type, " regular expression of ", match);

	            if (next && Twig.indexOf(next, type) < 0) {
	                invalid_matches.push(
	                    type + " cannot follow a " + tokens[tokens.length - 1].type +
	                           " at template:" + exp_offset + " near '" + match[0].substring(0, 20) +
	                           "...'"
	                );
	                // Not a match, don't change the expression
	                return match[0];
	            }

	            // Validate the token if a validation function is provided
	            if (Twig.expression.handler[type].validate &&
	                    !Twig.expression.handler[type].validate(match, tokens)) {
	                return match[0];
	            }

	            invalid_matches = [];

	            tokens.push({
	                type:  type,
	                value: match[0],
	                match: match
	            });

	            match_found = true;
	            next = token_next;
	            exp_offset += match[0].length;

	            // Does the token need to return output back to the expression string
	            // e.g. a function match of cycle( might return the '(' back to the expression
	            // This allows look-ahead to differentiate between token types (e.g. functions and variable names)
	            if (Twig.expression.handler[type].transform) {
	                return Twig.expression.handler[type].transform(match, tokens);
	            }
	            return '';
	        };

	        Twig.log.debug("Twig.expression.tokenize", "Tokenizing expression ", expression);

	        while (expression.length > 0) {
	            expression = expression.trim();
	            for (type in Twig.expression.handler) {
	                if (Twig.expression.handler.hasOwnProperty(type)) {
	                    token_next = Twig.expression.handler[type].next;
	                    regex = Twig.expression.handler[type].regex;
	                    Twig.log.trace("Checking type ", type, " on ", expression);
	                    if (regex instanceof Array) {
	                        regex_array = regex;
	                    } else {
	                        regex_array = [regex];
	                    }

	                    match_found = false;
	                    while (regex_array.length > 0) {
	                        regex = regex_array.pop();
	                        expression = expression.replace(regex, match_function);
	                    }
	                    // An expression token has been matched. Break the for loop and start trying to
	                    //  match the next template (if expression isn't empty.)
	                    if (match_found) {
	                        break;
	                    }
	                }
	            }
	            if (!match_found) {
	                if (invalid_matches.length > 0) {
	                    throw new Twig.Error(invalid_matches.join(" OR "));
	                } else {
	                    throw new Twig.Error("Unable to parse '" + expression + "' at template position" + exp_offset);
	                }
	            }
	        }

	        Twig.log.trace("Twig.expression.tokenize", "Tokenized to ", tokens);
	        return tokens;
	    };

	    /**
	     * Compile an expression token.
	     *
	     * @param {Object} raw_token The uncompiled token.
	     *
	     * @return {Object} The compiled token.
	     */
	    Twig.expression.compile = function (raw_token) {
	        var expression = raw_token.value,
	            // Tokenize expression
	            tokens = Twig.expression.tokenize(expression),
	            token = null,
	            output = [],
	            stack = [],
	            token_template = null;

	        Twig.log.trace("Twig.expression.compile: ", "Compiling ", expression);

	        // Push tokens into RPN stack using the Shunting-yard algorithm
	        // See http://en.wikipedia.org/wiki/Shunting_yard_algorithm

	        while (tokens.length > 0) {
	            token = tokens.shift();
	            token_template = Twig.expression.handler[token.type];

	            Twig.log.trace("Twig.expression.compile: ", "Compiling ", token);

	            // Compile the template
	            token_template.compile && token_template.compile(token, stack, output);

	            Twig.log.trace("Twig.expression.compile: ", "Stack is", stack);
	            Twig.log.trace("Twig.expression.compile: ", "Output is", output);
	        }

	        while(stack.length > 0) {
	            output.push(stack.pop());
	        }

	        Twig.log.trace("Twig.expression.compile: ", "Final output is", output);

	        raw_token.stack = output;
	        delete raw_token.value;

	        return raw_token;
	    };


	    /**
	     * Parse an RPN expression stack within a context.
	     *
	     * @param {Array} tokens An array of compiled expression tokens.
	     * @param {Object} context The render context to parse the tokens with.
	     *
	     * @return {Object} The result of parsing all the tokens. The result
	     *                  can be anything, String, Array, Object, etc... based on
	     *                  the given expression.
	     */
	    Twig.expression.parse = function (tokens, context, tokens_are_parameters, allow_async) {
	        var that = this;

	        // If the token isn't an array, make it one.
	        if (!(tokens instanceof Array)) {
	            tokens = [tokens];
	        }

	        // The output stack
	        var stack = [],
	            next_token,
	            output = null,
	            promise = null,
	            is_async = true,
	            token_template = null,
	            loop_token_fixups = [];

	        promise = Twig.async.forEach(tokens, function (token, index) {
	            //If the token is marked for cleanup, we don't need to parse it
	            if (token.cleanup) {
	                return;
	            }

	            var result = null;

	            //Determine the token that follows this one so that we can pass it to the parser
	            if (tokens.length > index + 1) {
	                next_token = tokens[index + 1];
	            }

	            token_template = Twig.expression.handler[token.type];

	            if (token_template.parse)
	                result = token_template.parse.apply(that, [token, stack, context, next_token]);

	            //Store any binary tokens for later if we are in a loop.
	            if (context.loop && token.type === Twig.expression.type.operator.binary) {
	                loop_token_fixups.push(token);
	            }

	            return result;
	        })
	        .then(function() {
	            //Check every fixup and remove "key" as long as they still have "params". This covers the use case where
	            //a ":" operator is used in a loop with a "(expression):" statement. We need to be able to evaluate the expression
	            Twig.forEach(loop_token_fixups, function (loop_token_fixup) {
	                if (loop_token_fixup.params && loop_token_fixup.key) {
	                    delete loop_token_fixup["key"];
	                }
	            });

	            //If parse has been called with a set of tokens that are parameters, we need to return the whole stack,
	            //wrapped in an Array.
	            if (tokens_are_parameters) {
	                var params = [];
	                while (stack.length > 0) {
	                    params.unshift(stack.pop());
	                }

	                stack.push(params);
	            }

	            if (allow_async)
	                return Twig.Promise.resolve(stack.pop());
	        })
	        .then(function(v) {
	            is_async = false;
	            return v;
	        });

	        if (allow_async)
	            return promise;

	        if (is_async)
	            throw new Twig.Error('You are using Twig.js in sync mode in combination with async extensions.');

	        // Pop the final value off the stack
	        return stack.pop();
	    };

	    return Twig;

	};


/***/ },
/* 4 */
/***/ function(module, exports) {

	// ## twig.expression.operator.js
	//
	// This file handles operator lookups and parsing.
	module.exports = function (Twig) {
	    "use strict";

	    /**
	     * Operator associativity constants.
	     */
	    Twig.expression.operator = {
	        leftToRight: 'leftToRight',
	        rightToLeft: 'rightToLeft'
	    };

	    var containment = function(a, b) {
	        if (b === undefined || b === null) {
	            return null;
	        } else if (b.indexOf !== undefined) {
	            // String
	            return a === b || a !== '' && b.indexOf(a) > -1;
	        } else {
	            var el;
	            for (el in b) {
	                if (b.hasOwnProperty(el) && b[el] === a) {
	                    return true;
	                }
	            }
	            return false;
	        }
	    };

	    /**
	     * Get the precidence and associativity of an operator. These follow the order that C/C++ use.
	     * See http://en.wikipedia.org/wiki/Operators_in_C_and_C++ for the table of values.
	     */
	    Twig.expression.operator.lookup = function (operator, token) {
	        switch (operator) {
	            case "..":
	                token.precidence = 20;
	                token.associativity = Twig.expression.operator.leftToRight;
	                break;

	            case ',':
	                token.precidence = 18;
	                token.associativity = Twig.expression.operator.leftToRight;
	                break;

	            // Ternary
	            case '?:':
	            case '?':
	            case ':':
	                token.precidence = 16;
	                token.associativity = Twig.expression.operator.rightToLeft;
	                break;

	            case 'or':
	                token.precidence = 14;
	                token.associativity = Twig.expression.operator.leftToRight;
	                break;

	            case 'and':
	                token.precidence = 13;
	                token.associativity = Twig.expression.operator.leftToRight;
	                break;

	            case 'b-or':
	                token.precidence = 12;
	                token.associativity = Twig.expression.operator.leftToRight;
	                break;

	            case 'b-xor':
	                token.precidence = 11;
	                token.associativity = Twig.expression.operator.leftToRight;
	                break;

	            case 'b-and':
	                token.precidence = 10;
	                token.associativity = Twig.expression.operator.leftToRight;
	                break;

	            case '==':
	            case '!=':
	                token.precidence = 9;
	                token.associativity = Twig.expression.operator.leftToRight;
	                break;

	            case '<':
	            case '<=':
	            case '>':
	            case '>=':
	            case 'not in':
	            case 'in':
	                token.precidence = 8;
	                token.associativity = Twig.expression.operator.leftToRight;
	                break;

	            case '~': // String concatination
	            case '+':
	            case '-':
	                token.precidence = 6;
	                token.associativity = Twig.expression.operator.leftToRight;
	                break;

	            case '//':
	            case '**':
	            case '*':
	            case '/':
	            case '%':
	                token.precidence = 5;
	                token.associativity = Twig.expression.operator.leftToRight;
	                break;

	            case 'not':
	                token.precidence = 3;
	                token.associativity = Twig.expression.operator.rightToLeft;
	                break;

	            default:
	                throw new Twig.Error("Failed to lookup operator: " + operator + " is an unknown operator.");
	        }
	        token.operator = operator;
	        return token;
	    };

	    /**
	     * Handle operations on the RPN stack.
	     *
	     * Returns the updated stack.
	     */
	    Twig.expression.operator.parse = function (operator, stack) {
	        Twig.log.trace("Twig.expression.operator.parse: ", "Handling ", operator);
	        var a, b, c;

	        if (operator === '?') {
	            c = stack.pop();
	        }

	        b = stack.pop();
	        if (operator !== 'not') {
	            a = stack.pop();
	        }

	        if (operator !== 'in' && operator !== 'not in') {
	            if (a && Array.isArray(a)) {
	                a = a.length;
	            }

	            if (b && Array.isArray(b)) {
	                b = b.length;
	            }
	        }

	        switch (operator) {
	            case ':':
	                // Ignore
	                break;

	            case '?:':
	                if (Twig.lib.boolval(a)) {
	                    stack.push(a);
	                } else {
	                    stack.push(b);
	                }
	                break;
	            case '?':
	                if (a === undefined) {
	                    //An extended ternary.
	                    a = b;
	                    b = c;
	                    c = undefined;
	                }

	                if (Twig.lib.boolval(a)) {
	                    stack.push(b);
	                } else {
	                    stack.push(c);
	                }
	                break;

	            case '+':
	                b = parseFloat(b);
	                a = parseFloat(a);
	                stack.push(a + b);
	                break;

	            case '-':
	                b = parseFloat(b);
	                a = parseFloat(a);
	                stack.push(a - b);
	                break;

	            case '*':
	                b = parseFloat(b);
	                a = parseFloat(a);
	                stack.push(a * b);
	                break;

	            case '/':
	                b = parseFloat(b);
	                a = parseFloat(a);
	                stack.push(a / b);
	                break;

	            case '//':
	                b = parseFloat(b);
	                a = parseFloat(a);
	                stack.push(Math.floor(a / b));
	                break;

	            case '%':
	                b = parseFloat(b);
	                a = parseFloat(a);
	                stack.push(a % b);
	                break;

	            case '~':
	                stack.push( (a != null ? a.toString() : "")
	                          + (b != null ? b.toString() : "") );
	                break;

	            case 'not':
	            case '!':
	                stack.push(!Twig.lib.boolval(b));
	                break;

	            case '<':
	                stack.push(a < b);
	                break;

	            case '<=':
	                stack.push(a <= b);
	                break;

	            case '>':
	                stack.push(a > b);
	                break;

	            case '>=':
	                stack.push(a >= b);
	                break;

	            case '===':
	                stack.push(a === b);
	                break;

	            case '==':
	                stack.push(a == b);
	                break;

	            case '!==':
	                stack.push(a !== b);
	                break;

	            case '!=':
	                stack.push(a != b);
	                break;

	            case 'or':
	                stack.push(Twig.lib.boolval(a) || Twig.lib.boolval(b));
	                break;

	            case 'b-or':
	                stack.push(a | b);
	                break;

	            case 'b-xor':
	                stack.push(a ^ b);
	                break;

	            case 'and':
	                stack.push(Twig.lib.boolval(a) && Twig.lib.boolval(b));
	                break;

	            case 'b-and':
	                stack.push(a & b);
	                break;

	            case '**':
	                stack.push(Math.pow(a, b));
	                break;

	            case 'not in':
	                stack.push( !containment(a, b) );
	                break;

	            case 'in':
	                stack.push( containment(a, b) );
	                break;

	            case '..':
	                stack.push( Twig.functions.range(a, b) );
	                break;

	            default:
	                debugger;
	                throw new Twig.Error("Failed to parse operator: " + operator + " is an unknown operator.");
	        }
	    };

	    return Twig;

	};


/***/ },
/* 5 */
/***/ function(module, exports) {

	// ## twig.filters.js
	//
	// This file handles parsing filters.
	module.exports = function (Twig) {

	    // Determine object type
	    function is(type, obj) {
	        var clas = Object.prototype.toString.call(obj).slice(8, -1);
	        return obj !== undefined && obj !== null && clas === type;
	    }

	    Twig.filters = {
	        // String Filters
	        upper:  function(value) {
	            if ( typeof value !== "string" ) {
	               return value;
	            }

	            return value.toUpperCase();
	        },
	        lower: function(value) {
	            if ( typeof value !== "string" ) {
	               return value;
	            }

	            return value.toLowerCase();
	        },
	        capitalize: function(value) {
	            if ( typeof value !== "string" ) {
	                 return value;
	            }

	            return value.substr(0, 1).toUpperCase() + value.toLowerCase().substr(1);
	        },
	        title: function(value) {
	            if ( typeof value !== "string" ) {
	               return value;
	            }

	            return value.toLowerCase().replace( /(^|\s)([a-z])/g , function(m, p1, p2){
	                return p1 + p2.toUpperCase();
	            });
	        },
	        length: function(value) {
	            if (Twig.lib.is("Array", value) || typeof value === "string") {
	                return value.length;
	            } else if (Twig.lib.is("Object", value)) {
	                if (value._keys === undefined) {
	                    return Object.keys(value).length;
	                } else {
	                    return value._keys.length;
	                }
	            } else {
	                return 0;
	            }
	        },

	        // Array/Object Filters
	        reverse: function(value) {
	            if (is("Array", value)) {
	                return value.reverse();
	            } else if (is("String", value)) {
	                return value.split("").reverse().join("");
	            } else if (is("Object", value)) {
	                var keys = value._keys || Object.keys(value).reverse();
	                value._keys = keys;
	                return value;
	            }
	        },
	        sort: function(value) {
	            if (is("Array", value)) {
	                return value.sort();
	            } else if (is('Object', value)) {
	                // Sorting objects isn't obvious since the order of
	                // returned keys isn't guaranteed in JavaScript.
	                // Because of this we use a "hidden" key called _keys to
	                // store the keys in the order we want to return them.

	                delete value._keys;
	                var keys = Object.keys(value),
	                    sorted_keys = keys.sort(function(a, b) {
	                        var a1, a2;

	                        // if a and b are comparable, we're fine :-)
	                        if((value[a] > value[b]) == !(value[a] <= value[b])) {
	                            return value[a] > value[b] ? 1 :
				           value[a] < value[b] ? -1 :
					   0;
	                        }
	                        // if a and b can be parsed as numbers, we can compare
	                        // their numeric value
	                        else if(!isNaN(a1 = parseFloat(value[a])) &&
	                                !isNaN(b1 = parseFloat(value[b]))) {
	                            return a1 > b1 ? 1 :
				           a1 < b1 ? -1 :
					   0;
	                        }
	                        // if one of the values is a string, we convert the
	                        // other value to string as well
	                        else if(typeof value[a] == 'string') {
	                            return value[a] > value[b].toString() ? 1 :
	                                   value[a] < value[b].toString() ? -1 :
					   0;
	                        }
	                        else if(typeof value[b] == 'string') {
	                            return value[a].toString() > value[b] ? 1 :
	                                   value[a].toString() < value[b] ? -1 :
					   0;
	                        }
	                        // everything failed - return 'null' as sign, that
	                        // the values are not comparable
	                        else {
	                            return null;
	                        }
	                    });
	                value._keys = sorted_keys;
	                return value;
	            }
	        },
	        keys: function(value) {
	            if (value === undefined || value === null){
	                return;
	           }

	            var keyset = value._keys || Object.keys(value),
	                output = [];

	            Twig.forEach(keyset, function(key) {
	                if (key === "_keys") return; // Ignore the _keys property
	                if (value.hasOwnProperty(key)) {
	                    output.push(key);
	                }
	            });
	            return output;
	        },
	        url_encode: function(value) {
	            if (value === undefined || value === null){
	                return;
	            }

	            var result = encodeURIComponent(value);
	            result = result.replace("'", "%27");
	            return result;
	        },
	        join: function(value, params) {
	            if (value === undefined || value === null){
	                return;
	            }

	            var join_str = "",
	                output = [],
	                keyset = null;

	            if (params && params[0]) {
	                join_str = params[0];
	            }
	            if (is("Array", value)) {
	                output = value;
	            } else {
	                keyset = value._keys || Object.keys(value);
	                Twig.forEach(keyset, function(key) {
	                    if (key === "_keys") return; // Ignore the _keys property
	                    if (value.hasOwnProperty(key)) {
	                        output.push(value[key]);
	                    }
	                });
	            }
	            return output.join(join_str);
	        },
	        "default": function(value, params) {
	            if (params !== undefined && params.length > 1) {
	                throw new Twig.Error("default filter expects one argument");
	            }
	            if (value === undefined || value === null || value === '' ) {
	                if (params === undefined) {
	                    return '';
	                }

	                return params[0];
	            } else {
	                return value;
	            }
	        },
	        json_encode: function(value) {
	            if(value === undefined || value === null) {
	                return "null";
	            }
	            else if ((typeof value == 'object') && (is("Array", value))) {
	                output = [];

	                Twig.forEach(value, function(v) {
	                    output.push(Twig.filters.json_encode(v));
	                });

	                return "[" + output.join(",") + "]";
	            }
	            else if (typeof value == 'object') {
	                var keyset = value._keys || Object.keys(value),
	                output = [];

	                Twig.forEach(keyset, function(key) {
	                    output.push(JSON.stringify(key) + ":" + Twig.filters.json_encode(value[key]));
	                });

	                return "{" + output.join(",") + "}";
	            }
	            else {
	                return JSON.stringify(value);
	            }
	        },
	        merge: function(value, params) {
	            var obj = [],
	                arr_index = 0,
	                keyset = [];

	            // Check to see if all the objects being merged are arrays
	            if (!is("Array", value)) {
	                // Create obj as an Object
	                obj = { };
	            } else {
	                Twig.forEach(params, function(param) {
	                    if (!is("Array", param)) {
	                        obj = { };
	                    }
	                });
	            }
	            if (!is("Array", obj)) {
	                obj._keys = [];
	            }

	            if (is("Array", value)) {
	                Twig.forEach(value, function(val) {
	                    if (obj._keys) obj._keys.push(arr_index);
	                    obj[arr_index] = val;
	                    arr_index++;
	                });
	            } else {
	                keyset = value._keys || Object.keys(value);
	                Twig.forEach(keyset, function(key) {
	                    obj[key] = value[key];
	                    obj._keys.push(key);

	                    // Handle edge case where a number index in an object is greater than
	                    //   the array counter. In such a case, the array counter is increased
	                    //   one past the index.
	                    //
	                    // Example {{ ["a", "b"]|merge({"4":"value"}, ["c", "d"])
	                    // Without this, d would have an index of "4" and overwrite the value
	                    //   of "value"
	                    var int_key = parseInt(key, 10);
	                    if (!isNaN(int_key) && int_key >= arr_index) {
	                        arr_index = int_key + 1;
	                    }
	                });
	            }

	            // mixin the merge arrays
	            Twig.forEach(params, function(param) {
	                if (is("Array", param)) {
	                    Twig.forEach(param, function(val) {
	                        if (obj._keys) obj._keys.push(arr_index);
	                        obj[arr_index] = val;
	                        arr_index++;
	                    });
	                } else {
	                    keyset = param._keys || Object.keys(param);
	                    Twig.forEach(keyset, function(key) {
	                        if (!obj[key]) obj._keys.push(key);
	                        obj[key] = param[key];

	                        var int_key = parseInt(key, 10);
	                        if (!isNaN(int_key) && int_key >= arr_index) {
	                            arr_index = int_key + 1;
	                        }
	                    });
	                }
	            });
	            if (params.length === 0) {
	                throw new Twig.Error("Filter merge expects at least one parameter");
	            }

	            return obj;
	        },
	        date: function(value, params) {
	            var date = Twig.functions.date(value);
	            var format = params && params.length ? params[0] : 'F j, Y H:i';
	            return Twig.lib.date(format, date);
	        },

	        date_modify: function(value, params) {
	            if (value === undefined || value === null) {
	                return;
	            }
	            if (params === undefined || params.length !== 1) {
	                throw new Twig.Error("date_modify filter expects 1 argument");
	            }

	            var modifyText = params[0], time;

	            if (Twig.lib.is("Date", value)) {
	                time = Twig.lib.strtotime(modifyText, value.getTime() / 1000);
	            }
	            if (Twig.lib.is("String", value)) {
	                time = Twig.lib.strtotime(modifyText, Twig.lib.strtotime(value));
	            }
	            if (Twig.lib.is("Number", value)) {
	                time = Twig.lib.strtotime(modifyText, value);
	            }

	            return new Date(time * 1000);
	        },

	        replace: function(value, params) {
	            if (value === undefined||value === null){
	                return;
	            }

	            var pairs = params[0],
	                tag;
	            for (tag in pairs) {
	                if (pairs.hasOwnProperty(tag) && tag !== "_keys") {
	                    value = Twig.lib.replaceAll(value, tag, pairs[tag]);
	                }
	            }
	            return value;
	        },

	        format: function(value, params) {
	            if (value === undefined || value === null){
	                return;
	            }

	            return Twig.lib.vsprintf(value, params);
	        },

	        striptags: function(value) {
	            if (value === undefined || value === null){
	                return;
	            }

	            return Twig.lib.strip_tags(value);
	        },

	        escape: function(value, params) {
	            if (value === undefined|| value === null){
	                return;
	            }

	            var strategy = "html";
	            if(params && params.length && params[0] !== true)
	                strategy = params[0];

	            if(strategy == "html") {
	                var raw_value = value.toString().replace(/&/g, "&amp;")
	                            .replace(/</g, "&lt;")
	                            .replace(/>/g, "&gt;")
	                            .replace(/"/g, "&quot;")
	                            .replace(/'/g, "&#039;");
	                return Twig.Markup(raw_value, 'html');
	            } else if(strategy == "js") {
	                var raw_value = value.toString();
	                var result = "";

	                for(var i = 0; i < raw_value.length; i++) {
	                    if(raw_value[i].match(/^[a-zA-Z0-9,\._]$/))
	                        result += raw_value[i];
	                    else {
	                        var char_code = raw_value.charCodeAt(i);

	                        if(char_code < 0x80)
	                            result += "\\x" + char_code.toString(16).toUpperCase();
	                        else
	                            result += Twig.lib.sprintf("\\u%04s", char_code.toString(16).toUpperCase());
	                    }
	                }

	                return Twig.Markup(result, 'js');
	            } else if(strategy == "css") {
	                var raw_value = value.toString();
	                var result = "";

	                for(var i = 0; i < raw_value.length; i++) {
	                    if(raw_value[i].match(/^[a-zA-Z0-9]$/))
	                        result += raw_value[i];
	                    else {
	                        var char_code = raw_value.charCodeAt(i);
	                        result += "\\" + char_code.toString(16).toUpperCase() + " ";
	                    }
	                }

	                return Twig.Markup(result, 'css');
	            } else if(strategy == "url") {
	                var result = Twig.filters.url_encode(value);
	                return Twig.Markup(result, 'url');
	            } else if(strategy == "html_attr") {
	                var raw_value = value.toString();
	                var result = "";

	                for(var i = 0; i < raw_value.length; i++) {
	                    if(raw_value[i].match(/^[a-zA-Z0-9,\.\-_]$/))
	                        result += raw_value[i];
	                    else if(raw_value[i].match(/^[&<>"]$/))
	                        result += raw_value[i].replace(/&/g, "&amp;")
	                                .replace(/</g, "&lt;")
	                                .replace(/>/g, "&gt;")
	                                .replace(/"/g, "&quot;");
	                    else {
	                        var char_code = raw_value.charCodeAt(i);

	                        // The following replaces characters undefined in HTML with
	                        // the hex entity for the Unicode replacement character.
	                        if(char_code <= 0x1f && char_code != 0x09 && char_code != 0x0a && char_code != 0x0d)
	                            result += "&#xFFFD;";
	                        else if(char_code < 0x80)
	                            result += Twig.lib.sprintf("&#x%02s;", char_code.toString(16).toUpperCase());
	                        else
	                            result += Twig.lib.sprintf("&#x%04s;", char_code.toString(16).toUpperCase());
	                    }
	                }

	                return Twig.Markup(result, 'html_attr');
	            } else {
	                throw new Twig.Error("escape strategy unsupported");
	            }
	        },

	        /* Alias of escape */
	        "e": function(value, params) {
	            return Twig.filters.escape(value, params);
	        },

	        nl2br: function(value) {
	            if (value === undefined || value === null){
	                return;
	            }
	            var linebreak_tag = "BACKSLASH_n_replace",
	                br = "<br />" + linebreak_tag;

	            value = Twig.filters.escape(value)
	                        .replace(/\r\n/g, br)
	                        .replace(/\r/g, br)
	                        .replace(/\n/g, br);

	            value = Twig.lib.replaceAll(value, linebreak_tag, "\n");

	            return Twig.Markup(value);
	        },

	        /**
	         * Adapted from: http://phpjs.org/functions/number_format:481
	         */
	        number_format: function(value, params) {
	            var number = value,
	                decimals = (params && params[0]) ? params[0] : undefined,
	                dec      = (params && params[1] !== undefined) ? params[1] : ".",
	                sep      = (params && params[2] !== undefined) ? params[2] : ",";

	            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	            var n = !isFinite(+number) ? 0 : +number,
	                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	                s = '',
	                toFixedFix = function (n, prec) {
	                    var k = Math.pow(10, prec);
	                    return '' + Math.round(n * k) / k;
	                };
	            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	            if (s[0].length > 3) {
	                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	            }
	            if ((s[1] || '').length < prec) {
	                s[1] = s[1] || '';
	                s[1] += new Array(prec - s[1].length + 1).join('0');
	            }
	            return s.join(dec);
	        },

	        trim: function(value, params) {
	            if (value === undefined|| value === null){
	                return;
	            }

	            var str = Twig.filters.escape( '' + value ),
	                whitespace;
	            if ( params && params[0] ) {
	                whitespace = '' + params[0];
	            } else {
	                whitespace = ' \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000';
	            }
	            for (var i = 0; i < str.length; i++) {
	                if (whitespace.indexOf(str.charAt(i)) === -1) {
	                    str = str.substring(i);
	                    break;
	                }
	            }
	            for (i = str.length - 1; i >= 0; i--) {
	                if (whitespace.indexOf(str.charAt(i)) === -1) {
	                    str = str.substring(0, i + 1);
	                    break;
	                }
	            }
	            return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
	        },

	        truncate: function (value, params) {
	            var length = 30,
	                preserve = false,
	                separator = '...';

	            value =  value + '';
	            if (params) {
	                if (params[0]) {
	                    length = params[0];
	                }
	                if (params[1]) {
	                    preserve = params[1];
	                }
	                if (params[2]) {
	                    separator = params[2];
	                }
	            }

	            if (value.length > length) {

	                if (preserve) {
	                    length = value.indexOf(' ', length);
	                    if (length === -1) {
	                        return value;
	                    }
	                }

	                value =  value.substr(0, length) + separator;
	            }

	            return value;
	        },

	        slice: function(value, params) {
	            if (value === undefined || value === null) {
	                return;
	            }
	            if (params === undefined || params.length < 1) {
	                throw new Twig.Error("slice filter expects at least 1 argument");
	            }

	            // default to start of string
	            var start = params[0] || 0;
	            // default to length of string
	            var length = params.length > 1 ? params[1] : value.length;
	            // handle negative start values
	            var startIndex = start >= 0 ? start : Math.max( value.length + start, 0 );

	            if (Twig.lib.is("Array", value)) {
	                var output = [];
	                for (var i = startIndex; i < startIndex + length && i < value.length; i++) {
	                    output.push(value[i]);
	                }
	                return output;
	            } else if (Twig.lib.is("String", value)) {
	                return value.substr(startIndex, length);
	            } else {
	                throw new Twig.Error("slice filter expects value to be an array or string");
	            }
	        },

	        abs: function(value) {
	            if (value === undefined || value === null) {
	                return;
	            }

	            return Math.abs(value);
	        },

	        first: function(value) {
	            if (is("Array", value)) {
	                return value[0];
	            } else if (is("Object", value)) {
	                if ('_keys' in value) {
	                    return value[value._keys[0]];
	                }
	            } else if ( typeof value === "string" ) {
	                return value.substr(0, 1);
	            }

	            return;
	        },

	        split: function(value, params) {
	            if (value === undefined || value === null) {
	                return;
	            }
	            if (params === undefined || params.length < 1 || params.length > 2) {
	                throw new Twig.Error("split filter expects 1 or 2 argument");
	            }
	            if (Twig.lib.is("String", value)) {
	                var delimiter = params[0],
	                    limit = params[1],
	                    split = value.split(delimiter);

	                if (limit === undefined) {

	                    return split;

	                } else if (limit < 0) {

	                    return value.split(delimiter, split.length + limit);

	                } else {

	                    var limitedSplit = [];

	                    if (delimiter == '') {
	                        // empty delimiter
	                        // "aabbcc"|split('', 2)
	                        //     -> ['aa', 'bb', 'cc']

	                        while(split.length > 0) {
	                            var temp = "";
	                            for (var i=0; i<limit && split.length > 0; i++) {
	                                temp += split.shift();
	                            }
	                            limitedSplit.push(temp);
	                        }

	                    } else {
	                        // non-empty delimiter
	                        // "one,two,three,four,five"|split(',', 3)
	                        //     -> ['one', 'two', 'three,four,five']

	                        for (var i=0; i<limit-1 && split.length > 0; i++) {
	                            limitedSplit.push(split.shift());
	                        }

	                        if (split.length > 0) {
	                            limitedSplit.push(split.join(delimiter));
	                        }
	                    }

	                    return limitedSplit;
	                }

	            } else {
	                throw new Twig.Error("split filter expects value to be a string");
	            }
	        },
	        last: function(value) {
	            if (Twig.lib.is('Object', value)) {
	                var keys;

	                if (value._keys === undefined) {
	                    keys = Object.keys(value);
	                } else {
	                    keys = value._keys;
	                }

	                return value[keys[keys.length - 1]];
	            }

	            // string|array
	            return value[value.length - 1];
	        },
	        raw: function(value) {
	            return Twig.Markup(value);
	        },
	        batch: function(items, params) {
	            var size = params.shift(),
	                fill = params.shift(),
	                result,
	                last,
	                missing;

	            if (!Twig.lib.is("Array", items)) {
	                throw new Twig.Error("batch filter expects items to be an array");
	            }

	            if (!Twig.lib.is("Number", size)) {
	                throw new Twig.Error("batch filter expects size to be a number");
	            }

	            size = Math.ceil(size);

	            result = Twig.lib.chunkArray(items, size);

	            if (fill && items.length % size != 0) {
	                last = result.pop();
	                missing = size - last.length;

	                while (missing--) {
	                    last.push(fill);
	                }

	                result.push(last);
	            }

	            return result;
	        },
	        round: function(value, params) {
	            params = params || [];

	            var precision = params.length > 0 ? params[0] : 0,
	                method = params.length > 1 ? params[1] : "common";

	            value = parseFloat(value);

	            if(precision && !Twig.lib.is("Number", precision)) {
	                throw new Twig.Error("round filter expects precision to be a number");
	            }

	            if (method === "common") {
	                return Twig.lib.round(value, precision);
	            }

	            if(!Twig.lib.is("Function", Math[method])) {
	                throw new Twig.Error("round filter expects method to be 'floor', 'ceil', or 'common'");
	            }

	            return Math[method](value * Math.pow(10, precision)) / Math.pow(10, precision);
	        }
	    };

	    Twig.filter = function(filter, value, params) {
	        if (!Twig.filters[filter]) {
	            throw "Unable to find filter " + filter;
	        }
	        return Twig.filters[filter].apply(this, [value, params]);
	    };

	    Twig.filter.extend = function(filter, definition) {
	        Twig.filters[filter] = definition;
	    };

	    return Twig;

	};


/***/ },
/* 6 */
/***/ function(module, exports) {

	// ## twig.functions.js
	//
	// This file handles parsing filters.
	module.exports = function (Twig) {
	    /**
	     * @constant
	     * @type {string}
	     */
	    var TEMPLATE_NOT_FOUND_MESSAGE = 'Template "{name}" is not defined.';

	    // Determine object type
	    function is(type, obj) {
	        var clas = Object.prototype.toString.call(obj).slice(8, -1);
	        return obj !== undefined && obj !== null && clas === type;
	    }

	    Twig.functions = {
	        //  attribute, block, constant, date, dump, parent, random,.

	        // Range function from http://phpjs.org/functions/range:499
	        // Used under an MIT License
	        range: function (low, high, step) {
	            // http://kevin.vanzonneveld.net
	            // +   original by: Waldo Malqui Silva
	            // *     example 1: range ( 0, 12 );
	            // *     returns 1: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
	            // *     example 2: range( 0, 100, 10 );
	            // *     returns 2: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100]
	            // *     example 3: range( 'a', 'i' );
	            // *     returns 3: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i']
	            // *     example 4: range( 'c', 'a' );
	            // *     returns 4: ['c', 'b', 'a']
	            var matrix = [];
	            var inival, endval, plus;
	            var walker = step || 1;
	            var chars = false;

	            if (!isNaN(low) && !isNaN(high)) {
	                inival = parseInt(low, 10);
	                endval = parseInt(high, 10);
	            } else if (isNaN(low) && isNaN(high)) {
	                chars = true;
	                inival = low.charCodeAt(0);
	                endval = high.charCodeAt(0);
	            } else {
	                inival = (isNaN(low) ? 0 : low);
	                endval = (isNaN(high) ? 0 : high);
	            }

	            plus = ((inival > endval) ? false : true);
	            if (plus) {
	                while (inival <= endval) {
	                    matrix.push(((chars) ? String.fromCharCode(inival) : inival));
	                    inival += walker;
	                }
	            } else {
	                while (inival >= endval) {
	                    matrix.push(((chars) ? String.fromCharCode(inival) : inival));
	                    inival -= walker;
	                }
	            }

	            return matrix;
	        },
	        cycle: function(arr, i) {
	            var pos = i % arr.length;
	            return arr[pos];
	        },
	        dump: function() {
	            var EOL = '\n',
	                indentChar = '  ',
	                indentTimes = 0,
	                out = '',
	                args = Array.prototype.slice.call(arguments),
	                indent = function(times) {
	                    var ind  = '';
	                    while (times > 0) {
	                        times--;
	                        ind += indentChar;
	                    }
	                    return ind;
	                },
	                displayVar = function(variable) {
	                    out += indent(indentTimes);
	                    if (typeof(variable) === 'object') {
	                        dumpVar(variable);
	                    } else if (typeof(variable) === 'function') {
	                        out += 'function()' + EOL;
	                    } else if (typeof(variable) === 'string') {
	                        out += 'string(' + variable.length + ') "' + variable + '"' + EOL;
	                    } else if (typeof(variable) === 'number') {
	                        out += 'number(' + variable + ')' + EOL;
	                    } else if (typeof(variable) === 'boolean') {
	                        out += 'bool(' + variable + ')' + EOL;
	                    }
	                },
	                dumpVar = function(variable) {
	                    var i;
	                    if (variable === null) {
	                        out += 'NULL' + EOL;
	                    } else if (variable === undefined) {
	                        out += 'undefined' + EOL;
	                    } else if (typeof variable === 'object') {
	                        out += indent(indentTimes) + typeof(variable);
	                        indentTimes++;
	                        out += '(' + (function(obj) {
	                            var size = 0, key;
	                            for (key in obj) {
	                                if (obj.hasOwnProperty(key)) {
	                                    size++;
	                                }
	                            }
	                            return size;
	                        })(variable) + ') {' + EOL;
	                        for (i in variable) {
	                            out += indent(indentTimes) + '[' + i + ']=> ' + EOL;
	                            displayVar(variable[i]);
	                        }
	                        indentTimes--;
	                        out += indent(indentTimes) + '}' + EOL;
	                    } else {
	                        displayVar(variable);
	                    }
	                };

	            // handle no argument case by dumping the entire render context
	            if (args.length == 0) args.push(this.context);

	            Twig.forEach(args, function(variable) {
	                dumpVar(variable);
	            });

	            return out;
	        },
	        date: function(date, time) {
	            var dateObj;
	            if (date === undefined || date === null || date === "") {
	                dateObj = new Date();
	            } else if (Twig.lib.is("Date", date)) {
	                dateObj = date;
	            } else if (Twig.lib.is("String", date)) {
	                if (date.match(/^[0-9]+$/)) {
	                    dateObj = new Date(date * 1000);
	                }
	                else {
	                    dateObj = new Date(Twig.lib.strtotime(date) * 1000);
	                }
	            } else if (Twig.lib.is("Number", date)) {
	                // timestamp
	                dateObj = new Date(date * 1000);
	            } else {
	                throw new Twig.Error("Unable to parse date " + date);
	            }
	            return dateObj;
	        },
	        block: function(block) {
	            if (this.originalBlockTokens[block]) {
	                return Twig.logic.parse.apply(this, [this.originalBlockTokens[block], this.context]).output;
	            } else {
	                return this.blocks[block];
	            }
	        },
	        parent: function() {
	            // Add a placeholder
	            return Twig.placeholders.parent;
	        },
	        attribute: function(object, method, params) {
	            if (Twig.lib.is('Object', object)) {
	                if (object.hasOwnProperty(method)) {
	                    if (typeof object[method] === "function") {
	                        return object[method].apply(undefined, params);
	                    }
	                    else {
	                        return object[method];
	                    }
	                }
	            }
	            // Array will return element 0-index
	            return object[method] || undefined;
	        },
	        max: function(values) {
	            if(Twig.lib.is("Object", values)) {
	                delete values["_keys"];
	                return Twig.lib.max(values);
	            }

	            return Twig.lib.max.apply(null, arguments);
	        },
	        min: function(values) {
	            if(Twig.lib.is("Object", values)) {
	                delete values["_keys"];
	                return Twig.lib.min(values);
	            }

	            return Twig.lib.min.apply(null, arguments);
	        },
	        template_from_string: function(template) {
	            if (template === undefined) {
	                template = '';
	            }
	            return Twig.Templates.parsers.twig({
	                options: this.options,
	                data: template
	            });
	        },
	        random: function(value) {
	            var LIMIT_INT31 = 0x80000000;

	            function getRandomNumber(n) {
	                var random = Math.floor(Math.random() * LIMIT_INT31);
	                var limits = [0, n];
	                var min = Math.min.apply(null, limits),
	                    max = Math.max.apply(null, limits);
	                return min + Math.floor((max - min + 1) * random / LIMIT_INT31);
	            }

	            if(Twig.lib.is("Number", value)) {
	                return getRandomNumber(value);
	            }

	            if(Twig.lib.is("String", value)) {
	                return value.charAt(getRandomNumber(value.length-1));
	            }

	            if(Twig.lib.is("Array", value)) {
	                return value[getRandomNumber(value.length-1)];
	            }

	            if(Twig.lib.is("Object", value)) {
	                var keys = Object.keys(value);
	                return value[keys[getRandomNumber(keys.length-1)]];
	            }

	            return getRandomNumber(LIMIT_INT31-1);
	        },

	        /**
	         * Returns the content of a template without rendering it
	         * @param {string} name
	         * @param {boolean} [ignore_missing=false]
	         * @returns {string}
	         */
	        source: function(name, ignore_missing) {
	            var templateSource;
	            var templateFound = false;
	            var isNodeEnvironment = typeof module !== 'undefined' && typeof module.exports !== 'undefined' && typeof window === 'undefined';
	            var loader;
	            var path;

	            //if we are running in a node.js environment, set the loader to 'fs' and ensure the
	            // path is relative to the CWD of the running script
	            //else, set the loader to 'ajax' and set the path to the value of name
	            if (isNodeEnvironment) {
	                loader = 'fs';
	                path = __dirname + '/' + name;
	            } else {
	                loader = 'ajax';
	                path = name;
	            }

	            //build the params object
	            var params = {
	                id: name,
	                path: path,
	                method: loader,
	                parser: 'source',
	                async: false,
	                fetchTemplateSource: true
	            };

	            //default ignore_missing to false
	            if (typeof ignore_missing === 'undefined') {
	                ignore_missing = false;
	            }

	            //try to load the remote template
	            //
	            //on exception, log it
	            try {
	                templateSource = Twig.Templates.loadRemote(name, params);

	                //if the template is undefined or null, set the template to an empty string and do NOT flip the
	                // boolean indicating we found the template
	                //
	                //else, all is good! flip the boolean indicating we found the template
	                if (typeof templateSource === 'undefined' || templateSource === null) {
	                    templateSource = '';
	                } else {
	                    templateFound = true;
	                }
	            } catch (e) {
	                Twig.log.debug('Twig.functions.source: ', 'Problem loading template  ', e);
	            }

	            //if the template was NOT found AND we are not ignoring missing templates, return the same message
	            // that is returned by the PHP implementation of the twig source() function
	            //
	            //else, return the template source
	            if (!templateFound && !ignore_missing) {
	                return TEMPLATE_NOT_FOUND_MESSAGE.replace('{name}', name);
	            } else {
	                return templateSource;
	            }
	        }
	    };

	    Twig._function = function(_function, value, params) {
	        if (!Twig.functions[_function]) {
	            throw "Unable to find function " + _function;
	        }
	        return Twig.functions[_function](value, params);
	    };

	    Twig._function.extend = function(_function, definition) {
	        Twig.functions[_function] = definition;
	    };

	    return Twig;

	};


/***/ },
/* 7 */
/***/ function(module, exports, __webpack_require__) {

	// ## twig.lib.js
	//
	// This file contains 3rd party libraries used within twig.
	//
	// Copies of the licenses for the code included here can be found in the
	// LICENSES.md file.
	//

	module.exports = function(Twig) {

	    // Namespace for libraries
	    Twig.lib = { };

	    Twig.lib.sprintf = __webpack_require__(8);
	    Twig.lib.vsprintf = __webpack_require__(9);
	    Twig.lib.round = __webpack_require__(10);
	    Twig.lib.max = __webpack_require__(11);
	    Twig.lib.min = __webpack_require__(12);
	    Twig.lib.strip_tags = __webpack_require__(13);
	    Twig.lib.strtotime = __webpack_require__(14);
	    Twig.lib.date = __webpack_require__(15);
	    Twig.lib.boolval = __webpack_require__(16);

	    Twig.lib.is = function(type, obj) {
	        var clas = Object.prototype.toString.call(obj).slice(8, -1);
	        return obj !== undefined && obj !== null && clas === type;
	    };

	    // shallow-copy an object
	    Twig.lib.copy = function(src) {
	        var target = {},
	            key;
	        for (key in src)
	            target[key] = src[key];

	        return target;
	    };

	    Twig.lib.extend = function (src, add) {
	        var keys = Object.keys(add),
	            i;

	        i = keys.length;

	        while (i--) {
	            src[keys[i]] = add[keys[i]];
	        }

	        return src;
	    };

	    Twig.lib.replaceAll = function(string, search, replace) {
	        return string.split(search).join(replace);
	    };

	    // chunk an array (arr) into arrays of (size) items, returns an array of arrays, or an empty array on invalid input
	    Twig.lib.chunkArray = function (arr, size) {
	        var returnVal = [],
	            x = 0,
	            len = arr.length;

	        if (size < 1 || !Twig.lib.is("Array", arr)) {
	            return [];
	        }

	        while (x < len) {
	            returnVal.push(arr.slice(x, x += size));
	        }

	        return returnVal;
	    };

	    return Twig;
	};


/***/ },
/* 8 */
/***/ function(module, exports) {

	'use strict';

	module.exports = function sprintf() {
	  //  discuss at: http://locutus.io/php/sprintf/
	  // original by: Ash Searle (http://hexmen.com/blog/)
	  // improved by: Michael White (http://getsprink.com)
	  // improved by: Jack
	  // improved by: Kevin van Zonneveld (http://kvz.io)
	  // improved by: Kevin van Zonneveld (http://kvz.io)
	  // improved by: Kevin van Zonneveld (http://kvz.io)
	  // improved by: Dj
	  // improved by: Allidylls
	  //    input by: Paulo Freitas
	  //    input by: Brett Zamir (http://brett-zamir.me)
	  //   example 1: sprintf("%01.2f", 123.1)
	  //   returns 1: '123.10'
	  //   example 2: sprintf("[%10s]", 'monkey')
	  //   returns 2: '[    monkey]'
	  //   example 3: sprintf("[%'#10s]", 'monkey')
	  //   returns 3: '[####monkey]'
	  //   example 4: sprintf("%d", 123456789012345)
	  //   returns 4: '123456789012345'
	  //   example 5: sprintf('%-03s', 'E')
	  //   returns 5: 'E00'

	  var regex = /%%|%(\d+\$)?([\-+'#0 ]*)(\*\d+\$|\*|\d+)?(?:\.(\*\d+\$|\*|\d+))?([scboxXuideEfFgG])/g;
	  var a = arguments;
	  var i = 0;
	  var format = a[i++];

	  var _pad = function _pad(str, len, chr, leftJustify) {
	    if (!chr) {
	      chr = ' ';
	    }
	    var padding = str.length >= len ? '' : new Array(1 + len - str.length >>> 0).join(chr);
	    return leftJustify ? str + padding : padding + str;
	  };

	  var justify = function justify(value, prefix, leftJustify, minWidth, zeroPad, customPadChar) {
	    var diff = minWidth - value.length;
	    if (diff > 0) {
	      if (leftJustify || !zeroPad) {
	        value = _pad(value, minWidth, customPadChar, leftJustify);
	      } else {
	        value = [value.slice(0, prefix.length), _pad('', diff, '0', true), value.slice(prefix.length)].join('');
	      }
	    }
	    return value;
	  };

	  var _formatBaseX = function _formatBaseX(value, base, prefix, leftJustify, minWidth, precision, zeroPad) {
	    // Note: casts negative numbers to positive ones
	    var number = value >>> 0;
	    prefix = prefix && number && {
	      '2': '0b',
	      '8': '0',
	      '16': '0x'
	    }[base] || '';
	    value = prefix + _pad(number.toString(base), precision || 0, '0', false);
	    return justify(value, prefix, leftJustify, minWidth, zeroPad);
	  };

	  // _formatString()
	  var _formatString = function _formatString(value, leftJustify, minWidth, precision, zeroPad, customPadChar) {
	    if (precision !== null && precision !== undefined) {
	      value = value.slice(0, precision);
	    }
	    return justify(value, '', leftJustify, minWidth, zeroPad, customPadChar);
	  };

	  // doFormat()
	  var doFormat = function doFormat(substring, valueIndex, flags, minWidth, precision, type) {
	    var number, prefix, method, textTransform, value;

	    if (substring === '%%') {
	      return '%';
	    }

	    // parse flags
	    var leftJustify = false;
	    var positivePrefix = '';
	    var zeroPad = false;
	    var prefixBaseX = false;
	    var customPadChar = ' ';
	    var flagsl = flags.length;
	    var j;
	    for (j = 0; j < flagsl; j++) {
	      switch (flags.charAt(j)) {
	        case ' ':
	          positivePrefix = ' ';
	          break;
	        case '+':
	          positivePrefix = '+';
	          break;
	        case '-':
	          leftJustify = true;
	          break;
	        case "'":
	          customPadChar = flags.charAt(j + 1);
	          break;
	        case '0':
	          zeroPad = true;
	          customPadChar = '0';
	          break;
	        case '#':
	          prefixBaseX = true;
	          break;
	      }
	    }

	    // parameters may be null, undefined, empty-string or real valued
	    // we want to ignore null, undefined and empty-string values
	    if (!minWidth) {
	      minWidth = 0;
	    } else if (minWidth === '*') {
	      minWidth = +a[i++];
	    } else if (minWidth.charAt(0) === '*') {
	      minWidth = +a[minWidth.slice(1, -1)];
	    } else {
	      minWidth = +minWidth;
	    }

	    // Note: undocumented perl feature:
	    if (minWidth < 0) {
	      minWidth = -minWidth;
	      leftJustify = true;
	    }

	    if (!isFinite(minWidth)) {
	      throw new Error('sprintf: (minimum-)width must be finite');
	    }

	    if (!precision) {
	      precision = 'fFeE'.indexOf(type) > -1 ? 6 : type === 'd' ? 0 : undefined;
	    } else if (precision === '*') {
	      precision = +a[i++];
	    } else if (precision.charAt(0) === '*') {
	      precision = +a[precision.slice(1, -1)];
	    } else {
	      precision = +precision;
	    }

	    // grab value using valueIndex if required?
	    value = valueIndex ? a[valueIndex.slice(0, -1)] : a[i++];

	    switch (type) {
	      case 's':
	        return _formatString(value + '', leftJustify, minWidth, precision, zeroPad, customPadChar);
	      case 'c':
	        return _formatString(String.fromCharCode(+value), leftJustify, minWidth, precision, zeroPad);
	      case 'b':
	        return _formatBaseX(value, 2, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
	      case 'o':
	        return _formatBaseX(value, 8, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
	      case 'x':
	        return _formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
	      case 'X':
	        return _formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad).toUpperCase();
	      case 'u':
	        return _formatBaseX(value, 10, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
	      case 'i':
	      case 'd':
	        number = +value || 0;
	        // Plain Math.round doesn't just truncate
	        number = Math.round(number - number % 1);
	        prefix = number < 0 ? '-' : positivePrefix;
	        value = prefix + _pad(String(Math.abs(number)), precision, '0', false);
	        return justify(value, prefix, leftJustify, minWidth, zeroPad);
	      case 'e':
	      case 'E':
	      case 'f': // @todo: Should handle locales (as per setlocale)
	      case 'F':
	      case 'g':
	      case 'G':
	        number = +value;
	        prefix = number < 0 ? '-' : positivePrefix;
	        method = ['toExponential', 'toFixed', 'toPrecision']['efg'.indexOf(type.toLowerCase())];
	        textTransform = ['toString', 'toUpperCase']['eEfFgG'.indexOf(type) % 2];
	        value = prefix + Math.abs(number)[method](precision);
	        return justify(value, prefix, leftJustify, minWidth, zeroPad)[textTransform]();
	      default:
	        return substring;
	    }
	  };

	  return format.replace(regex, doFormat);
	};
	//# sourceMappingURL=sprintf.js.map

/***/ },
/* 9 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	module.exports = function vsprintf(format, args) {
	  //  discuss at: http://locutus.io/php/vsprintf/
	  // original by: ejsanders
	  //   example 1: vsprintf('%04d-%02d-%02d', [1988, 8, 1])
	  //   returns 1: '1988-08-01'

	  var sprintf = __webpack_require__(8);

	  return sprintf.apply(this, [format].concat(args));
	};
	//# sourceMappingURL=vsprintf.js.map

/***/ },
/* 10 */
/***/ function(module, exports) {

	'use strict';

	module.exports = function round(value, precision, mode) {
	  //  discuss at: http://locutus.io/php/round/
	  // original by: Philip Peterson
	  //  revised by: Onno Marsman (https://twitter.com/onnomarsman)
	  //  revised by: T.Wild
	  //  revised by: Rafał Kukawski (http://blog.kukawski.pl)
	  //    input by: Greenseed
	  //    input by: meo
	  //    input by: William
	  //    input by: Josep Sanz (http://www.ws3.es/)
	  // bugfixed by: Brett Zamir (http://brett-zamir.me)
	  //      note 1: Great work. Ideas for improvement:
	  //      note 1: - code more compliant with developer guidelines
	  //      note 1: - for implementing PHP constant arguments look at
	  //      note 1: the pathinfo() function, it offers the greatest
	  //      note 1: flexibility & compatibility possible
	  //   example 1: round(1241757, -3)
	  //   returns 1: 1242000
	  //   example 2: round(3.6)
	  //   returns 2: 4
	  //   example 3: round(2.835, 2)
	  //   returns 3: 2.84
	  //   example 4: round(1.1749999999999, 2)
	  //   returns 4: 1.17
	  //   example 5: round(58551.799999999996, 2)
	  //   returns 5: 58551.8

	  var m, f, isHalf, sgn; // helper variables
	  // making sure precision is integer
	  precision |= 0;
	  m = Math.pow(10, precision);
	  value *= m;
	  // sign of the number
	  sgn = value > 0 | -(value < 0);
	  isHalf = value % 1 === 0.5 * sgn;
	  f = Math.floor(value);

	  if (isHalf) {
	    switch (mode) {
	      case 'PHP_ROUND_HALF_DOWN':
	        // rounds .5 toward zero
	        value = f + (sgn < 0);
	        break;
	      case 'PHP_ROUND_HALF_EVEN':
	        // rouds .5 towards the next even integer
	        value = f + f % 2 * sgn;
	        break;
	      case 'PHP_ROUND_HALF_ODD':
	        // rounds .5 towards the next odd integer
	        value = f + !(f % 2);
	        break;
	      default:
	        // rounds .5 away from zero
	        value = f + (sgn > 0);
	    }
	  }

	  return (isHalf ? value : Math.round(value)) / m;
	};
	//# sourceMappingURL=round.js.map

/***/ },
/* 11 */
/***/ function(module, exports) {

	'use strict';

	var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol ? "symbol" : typeof obj; };

	module.exports = function max() {
	  //  discuss at: http://locutus.io/php/max/
	  // original by: Onno Marsman (https://twitter.com/onnomarsman)
	  //  revised by: Onno Marsman (https://twitter.com/onnomarsman)
	  // improved by: Jack
	  //      note 1: Long code cause we're aiming for maximum PHP compatibility
	  //   example 1: max(1, 3, 5, 6, 7)
	  //   returns 1: 7
	  //   example 2: max([2, 4, 5])
	  //   returns 2: 5
	  //   example 3: max(0, 'hello')
	  //   returns 3: 0
	  //   example 4: max('hello', 0)
	  //   returns 4: 'hello'
	  //   example 5: max(-1, 'hello')
	  //   returns 5: 'hello'
	  //   example 6: max([2, 4, 8], [2, 5, 7])
	  //   returns 6: [2, 5, 7]

	  var ar;
	  var retVal;
	  var i = 0;
	  var n = 0;
	  var argv = arguments;
	  var argc = argv.length;
	  var _obj2Array = function _obj2Array(obj) {
	    if (Object.prototype.toString.call(obj) === '[object Array]') {
	      return obj;
	    } else {
	      var ar = [];
	      for (var i in obj) {
	        if (obj.hasOwnProperty(i)) {
	          ar.push(obj[i]);
	        }
	      }
	      return ar;
	    }
	  };
	  var _compare = function _compare(current, next) {
	    var i = 0;
	    var n = 0;
	    var tmp = 0;
	    var nl = 0;
	    var cl = 0;

	    if (current === next) {
	      return 0;
	    } else if ((typeof current === 'undefined' ? 'undefined' : _typeof(current)) === 'object') {
	      if ((typeof next === 'undefined' ? 'undefined' : _typeof(next)) === 'object') {
	        current = _obj2Array(current);
	        next = _obj2Array(next);
	        cl = current.length;
	        nl = next.length;
	        if (nl > cl) {
	          return 1;
	        } else if (nl < cl) {
	          return -1;
	        }
	        for (i = 0, n = cl; i < n; ++i) {
	          tmp = _compare(current[i], next[i]);
	          if (tmp === 1) {
	            return 1;
	          } else if (tmp === -1) {
	            return -1;
	          }
	        }
	        return 0;
	      }
	      return -1;
	    } else if ((typeof next === 'undefined' ? 'undefined' : _typeof(next)) === 'object') {
	      return 1;
	    } else if (isNaN(next) && !isNaN(current)) {
	      if (current === 0) {
	        return 0;
	      }
	      return current < 0 ? 1 : -1;
	    } else if (isNaN(current) && !isNaN(next)) {
	      if (next === 0) {
	        return 0;
	      }
	      return next > 0 ? 1 : -1;
	    }

	    if (next === current) {
	      return 0;
	    }

	    return next > current ? 1 : -1;
	  };

	  if (argc === 0) {
	    throw new Error('At least one value should be passed to max()');
	  } else if (argc === 1) {
	    if (_typeof(argv[0]) === 'object') {
	      ar = _obj2Array(argv[0]);
	    } else {
	      throw new Error('Wrong parameter count for max()');
	    }
	    if (ar.length === 0) {
	      throw new Error('Array must contain at least one element for max()');
	    }
	  } else {
	    ar = argv;
	  }

	  retVal = ar[0];
	  for (i = 1, n = ar.length; i < n; ++i) {
	    if (_compare(retVal, ar[i]) === 1) {
	      retVal = ar[i];
	    }
	  }

	  return retVal;
	};
	//# sourceMappingURL=max.js.map

/***/ },
/* 12 */
/***/ function(module, exports) {

	'use strict';

	var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol ? "symbol" : typeof obj; };

	module.exports = function min() {
	  //  discuss at: http://locutus.io/php/min/
	  // original by: Onno Marsman (https://twitter.com/onnomarsman)
	  //  revised by: Onno Marsman (https://twitter.com/onnomarsman)
	  // improved by: Jack
	  //      note 1: Long code cause we're aiming for maximum PHP compatibility
	  //   example 1: min(1, 3, 5, 6, 7)
	  //   returns 1: 1
	  //   example 2: min([2, 4, 5])
	  //   returns 2: 2
	  //   example 3: min(0, 'hello')
	  //   returns 3: 0
	  //   example 4: min('hello', 0)
	  //   returns 4: 'hello'
	  //   example 5: min(-1, 'hello')
	  //   returns 5: -1
	  //   example 6: min([2, 4, 8], [2, 5, 7])
	  //   returns 6: [2, 4, 8]

	  var ar;
	  var retVal;
	  var i = 0;
	  var n = 0;
	  var argv = arguments;
	  var argc = argv.length;
	  var _obj2Array = function _obj2Array(obj) {
	    if (Object.prototype.toString.call(obj) === '[object Array]') {
	      return obj;
	    }
	    var ar = [];
	    for (var i in obj) {
	      if (obj.hasOwnProperty(i)) {
	        ar.push(obj[i]);
	      }
	    }
	    return ar;
	  };

	  var _compare = function _compare(current, next) {
	    var i = 0;
	    var n = 0;
	    var tmp = 0;
	    var nl = 0;
	    var cl = 0;

	    if (current === next) {
	      return 0;
	    } else if ((typeof current === 'undefined' ? 'undefined' : _typeof(current)) === 'object') {
	      if ((typeof next === 'undefined' ? 'undefined' : _typeof(next)) === 'object') {
	        current = _obj2Array(current);
	        next = _obj2Array(next);
	        cl = current.length;
	        nl = next.length;
	        if (nl > cl) {
	          return 1;
	        } else if (nl < cl) {
	          return -1;
	        }
	        for (i = 0, n = cl; i < n; ++i) {
	          tmp = _compare(current[i], next[i]);
	          if (tmp === 1) {
	            return 1;
	          } else if (tmp === -1) {
	            return -1;
	          }
	        }
	        return 0;
	      }
	      return -1;
	    } else if ((typeof next === 'undefined' ? 'undefined' : _typeof(next)) === 'object') {
	      return 1;
	    } else if (isNaN(next) && !isNaN(current)) {
	      if (current === 0) {
	        return 0;
	      }
	      return current < 0 ? 1 : -1;
	    } else if (isNaN(current) && !isNaN(next)) {
	      if (next === 0) {
	        return 0;
	      }
	      return next > 0 ? 1 : -1;
	    }

	    if (next === current) {
	      return 0;
	    }

	    return next > current ? 1 : -1;
	  };

	  if (argc === 0) {
	    throw new Error('At least one value should be passed to min()');
	  } else if (argc === 1) {
	    if (_typeof(argv[0]) === 'object') {
	      ar = _obj2Array(argv[0]);
	    } else {
	      throw new Error('Wrong parameter count for min()');
	    }

	    if (ar.length === 0) {
	      throw new Error('Array must contain at least one element for min()');
	    }
	  } else {
	    ar = argv;
	  }

	  retVal = ar[0];

	  for (i = 1, n = ar.length; i < n; ++i) {
	    if (_compare(retVal, ar[i]) === -1) {
	      retVal = ar[i];
	    }
	  }

	  return retVal;
	};
	//# sourceMappingURL=min.js.map

/***/ },
/* 13 */
/***/ function(module, exports) {

	'use strict';

	module.exports = function strip_tags(input, allowed) {
	  // eslint-disable-line camelcase
	  //  discuss at: http://locutus.io/php/strip_tags/
	  // original by: Kevin van Zonneveld (http://kvz.io)
	  // improved by: Luke Godfrey
	  // improved by: Kevin van Zonneveld (http://kvz.io)
	  //    input by: Pul
	  //    input by: Alex
	  //    input by: Marc Palau
	  //    input by: Brett Zamir (http://brett-zamir.me)
	  //    input by: Bobby Drake
	  //    input by: Evertjan Garretsen
	  // bugfixed by: Kevin van Zonneveld (http://kvz.io)
	  // bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
	  // bugfixed by: Kevin van Zonneveld (http://kvz.io)
	  // bugfixed by: Kevin van Zonneveld (http://kvz.io)
	  // bugfixed by: Eric Nagel
	  // bugfixed by: Kevin van Zonneveld (http://kvz.io)
	  // bugfixed by: Tomasz Wesolowski
	  //  revised by: Rafał Kukawski (http://blog.kukawski.pl)
	  //   example 1: strip_tags('<p>Kevin</p> <br /><b>van</b> <i>Zonneveld</i>', '<i><b>')
	  //   returns 1: 'Kevin <b>van</b> <i>Zonneveld</i>'
	  //   example 2: strip_tags('<p>Kevin <img src="someimage.png" onmouseover="someFunction()">van <i>Zonneveld</i></p>', '<p>')
	  //   returns 2: '<p>Kevin van Zonneveld</p>'
	  //   example 3: strip_tags("<a href='http://kvz.io'>Kevin van Zonneveld</a>", "<a>")
	  //   returns 3: "<a href='http://kvz.io'>Kevin van Zonneveld</a>"
	  //   example 4: strip_tags('1 < 5 5 > 1')
	  //   returns 4: '1 < 5 5 > 1'
	  //   example 5: strip_tags('1 <br/> 1')
	  //   returns 5: '1  1'
	  //   example 6: strip_tags('1 <br/> 1', '<br>')
	  //   returns 6: '1 <br/> 1'
	  //   example 7: strip_tags('1 <br/> 1', '<br><br/>')
	  //   returns 7: '1 <br/> 1'

	  // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
	  allowed = (((allowed || '') + '').toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');

	  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
	  var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;

	  return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
	    return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
	  });
	};
	//# sourceMappingURL=strip_tags.js.map

/***/ },
/* 14 */
/***/ function(module, exports) {

	'use strict';

	module.exports = function strtotime(text, now) {
	  //  discuss at: http://locutus.io/php/strtotime/
	  // original by: Caio Ariede (http://caioariede.com)
	  // improved by: Kevin van Zonneveld (http://kvz.io)
	  // improved by: Caio Ariede (http://caioariede.com)
	  // improved by: A. Matías Quezada (http://amatiasq.com)
	  // improved by: preuter
	  // improved by: Brett Zamir (http://brett-zamir.me)
	  // improved by: Mirko Faber
	  //    input by: David
	  // bugfixed by: Wagner B. Soares
	  // bugfixed by: Artur Tchernychev
	  // bugfixed by: Stephan Bösch-Plepelits (http://github.com/plepe)
	  //      note 1: Examples all have a fixed timestamp to prevent
	  //      note 1: tests to fail because of variable time(zones)
	  //   example 1: strtotime('+1 day', 1129633200)
	  //   returns 1: 1129719600
	  //   example 2: strtotime('+1 week 2 days 4 hours 2 seconds', 1129633200)
	  //   returns 2: 1130425202
	  //   example 3: strtotime('last month', 1129633200)
	  //   returns 3: 1127041200
	  //   example 4: strtotime('2009-05-04 08:30:00 GMT')
	  //   returns 4: 1241425800
	  //   example 5: strtotime('2009-05-04 08:30:00+00')
	  //   returns 5: 1241425800
	  //   example 6: strtotime('2009-05-04 08:30:00+02:00')
	  //   returns 6: 1241418600
	  //   example 7: strtotime('2009-05-04T08:30:00Z')
	  //   returns 7: 1241425800

	  var parsed;
	  var match;
	  var today;
	  var year;
	  var date;
	  var days;
	  var ranges;
	  var len;
	  var times;
	  var regex;
	  var i;
	  var fail = false;

	  if (!text) {
	    return fail;
	  }

	  // Unecessary spaces
	  text = text.replace(/^\s+|\s+$/g, '').replace(/\s{2,}/g, ' ').replace(/[\t\r\n]/g, '').toLowerCase();

	  // in contrast to php, js Date.parse function interprets:
	  // dates given as yyyy-mm-dd as in timezone: UTC,
	  // dates with "." or "-" as MDY instead of DMY
	  // dates with two-digit years differently
	  // etc...etc...
	  // ...therefore we manually parse lots of common date formats
	  var pattern = new RegExp(['^(\\d{1,4})', '([\\-\\.\\/:])', '(\\d{1,2})', '([\\-\\.\\/:])', '(\\d{1,4})', '(?:\\s(\\d{1,2}):(\\d{2})?:?(\\d{2})?)?', '(?:\\s([A-Z]+)?)?$'].join(''));
	  match = text.match(pattern);

	  if (match && match[2] === match[4]) {
	    if (match[1] > 1901) {
	      switch (match[2]) {
	        case '-':
	          // YYYY-M-D
	          if (match[3] > 12 || match[5] > 31) {
	            return fail;
	          }

	          return new Date(match[1], parseInt(match[3], 10) - 1, match[5], match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	        case '.':
	          // YYYY.M.D is not parsed by strtotime()
	          return fail;
	        case '/':
	          // YYYY/M/D
	          if (match[3] > 12 || match[5] > 31) {
	            return fail;
	          }

	          return new Date(match[1], parseInt(match[3], 10) - 1, match[5], match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	      }
	    } else if (match[5] > 1901) {
	      switch (match[2]) {
	        case '-':
	          // D-M-YYYY
	          if (match[3] > 12 || match[1] > 31) {
	            return fail;
	          }

	          return new Date(match[5], parseInt(match[3], 10) - 1, match[1], match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	        case '.':
	          // D.M.YYYY
	          if (match[3] > 12 || match[1] > 31) {
	            return fail;
	          }

	          return new Date(match[5], parseInt(match[3], 10) - 1, match[1], match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	        case '/':
	          // M/D/YYYY
	          if (match[1] > 12 || match[3] > 31) {
	            return fail;
	          }

	          return new Date(match[5], parseInt(match[1], 10) - 1, match[3], match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	      }
	    } else {
	      switch (match[2]) {
	        case '-':
	          // YY-M-D
	          if (match[3] > 12 || match[5] > 31 || match[1] < 70 && match[1] > 38) {
	            return fail;
	          }

	          year = match[1] >= 0 && match[1] <= 38 ? +match[1] + 2000 : match[1];
	          return new Date(year, parseInt(match[3], 10) - 1, match[5], match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	        case '.':
	          // D.M.YY or H.MM.SS
	          if (match[5] >= 70) {
	            // D.M.YY
	            if (match[3] > 12 || match[1] > 31) {
	              return fail;
	            }

	            return new Date(match[5], parseInt(match[3], 10) - 1, match[1], match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	          }
	          if (match[5] < 60 && !match[6]) {
	            // H.MM.SS
	            if (match[1] > 23 || match[3] > 59) {
	              return fail;
	            }

	            today = new Date();
	            return new Date(today.getFullYear(), today.getMonth(), today.getDate(), match[1] || 0, match[3] || 0, match[5] || 0, match[9] || 0) / 1000;
	          }

	          // invalid format, cannot be parsed
	          return fail;
	        case '/':
	          // M/D/YY
	          if (match[1] > 12 || match[3] > 31 || match[5] < 70 && match[5] > 38) {
	            return fail;
	          }

	          year = match[5] >= 0 && match[5] <= 38 ? +match[5] + 2000 : match[5];
	          return new Date(year, parseInt(match[1], 10) - 1, match[3], match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	        case ':':
	          // HH:MM:SS
	          if (match[1] > 23 || match[3] > 59 || match[5] > 59) {
	            return fail;
	          }

	          today = new Date();
	          return new Date(today.getFullYear(), today.getMonth(), today.getDate(), match[1] || 0, match[3] || 0, match[5] || 0) / 1000;
	      }
	    }
	  }

	  // other formats and "now" should be parsed by Date.parse()
	  if (text === 'now') {
	    return now === null || isNaN(now) ? new Date().getTime() / 1000 | 0 : now | 0;
	  }
	  if (!isNaN(parsed = Date.parse(text))) {
	    return parsed / 1000 | 0;
	  }
	  // Browsers !== Chrome have problems parsing ISO 8601 date strings, as they do
	  // not accept lower case characters, space, or shortened time zones.
	  // Therefore, fix these problems and try again.
	  // Examples:
	  //   2015-04-15 20:33:59+02
	  //   2015-04-15 20:33:59z
	  //   2015-04-15t20:33:59+02:00
	  pattern = new RegExp(['^([0-9]{4}-[0-9]{2}-[0-9]{2})', '[ t]', '([0-9]{2}:[0-9]{2}:[0-9]{2}(\\.[0-9]+)?)', '([\\+-][0-9]{2}(:[0-9]{2})?|z)'].join(''));
	  match = text.match(pattern);
	  if (match) {
	    // @todo: time zone information
	    if (match[4] === 'z') {
	      match[4] = 'Z';
	    } else if (match[4].match(/^([\+-][0-9]{2})$/)) {
	      match[4] = match[4] + ':00';
	    }

	    if (!isNaN(parsed = Date.parse(match[1] + 'T' + match[2] + match[4]))) {
	      return parsed / 1000 | 0;
	    }
	  }

	  date = now ? new Date(now * 1000) : new Date();
	  days = {
	    'sun': 0,
	    'mon': 1,
	    'tue': 2,
	    'wed': 3,
	    'thu': 4,
	    'fri': 5,
	    'sat': 6
	  };
	  ranges = {
	    'yea': 'FullYear',
	    'mon': 'Month',
	    'day': 'Date',
	    'hou': 'Hours',
	    'min': 'Minutes',
	    'sec': 'Seconds'
	  };

	  function lastNext(type, range, modifier) {
	    var diff;
	    var day = days[range];

	    if (typeof day !== 'undefined') {
	      diff = day - date.getDay();

	      if (diff === 0) {
	        diff = 7 * modifier;
	      } else if (diff > 0 && type === 'last') {
	        diff -= 7;
	      } else if (diff < 0 && type === 'next') {
	        diff += 7;
	      }

	      date.setDate(date.getDate() + diff);
	    }
	  }

	  function process(val) {
	    // @todo: Reconcile this with regex using \s, taking into account
	    // browser issues with split and regexes
	    var splt = val.split(' ');
	    var type = splt[0];
	    var range = splt[1].substring(0, 3);
	    var typeIsNumber = /\d+/.test(type);
	    var ago = splt[2] === 'ago';
	    var num = (type === 'last' ? -1 : 1) * (ago ? -1 : 1);

	    if (typeIsNumber) {
	      num *= parseInt(type, 10);
	    }

	    if (ranges.hasOwnProperty(range) && !splt[1].match(/^mon(day|\.)?$/i)) {
	      return date['set' + ranges[range]](date['get' + ranges[range]]() + num);
	    }

	    if (range === 'wee') {
	      return date.setDate(date.getDate() + num * 7);
	    }

	    if (type === 'next' || type === 'last') {
	      lastNext(type, range, num);
	    } else if (!typeIsNumber) {
	      return false;
	    }

	    return true;
	  }

	  times = '(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec' + '|sunday|sun\\.?|monday|mon\\.?|tuesday|tue\\.?|wednesday|wed\\.?' + '|thursday|thu\\.?|friday|fri\\.?|saturday|sat\\.?)';
	  regex = '([+-]?\\d+\\s' + times + '|' + '(last|next)\\s' + times + ')(\\sago)?';

	  match = text.match(new RegExp(regex, 'gi'));
	  if (!match) {
	    return fail;
	  }

	  for (i = 0, len = match.length; i < len; i++) {
	    if (!process(match[i])) {
	      return fail;
	    }
	  }

	  return date.getTime() / 1000;
	};
	//# sourceMappingURL=strtotime.js.map

/***/ },
/* 15 */
/***/ function(module, exports) {

	'use strict';

	module.exports = function date(format, timestamp) {
	  //  discuss at: http://locutus.io/php/date/
	  // original by: Carlos R. L. Rodrigues (http://www.jsfromhell.com)
	  // original by: gettimeofday
	  //    parts by: Peter-Paul Koch (http://www.quirksmode.org/js/beat.html)
	  // improved by: Kevin van Zonneveld (http://kvz.io)
	  // improved by: MeEtc (http://yass.meetcweb.com)
	  // improved by: Brad Touesnard
	  // improved by: Tim Wiel
	  // improved by: Bryan Elliott
	  // improved by: David Randall
	  // improved by: Theriault (https://github.com/Theriault)
	  // improved by: Theriault (https://github.com/Theriault)
	  // improved by: Brett Zamir (http://brett-zamir.me)
	  // improved by: Theriault (https://github.com/Theriault)
	  // improved by: Thomas Beaucourt (http://www.webapp.fr)
	  // improved by: JT
	  // improved by: Theriault (https://github.com/Theriault)
	  // improved by: Rafał Kukawski (http://blog.kukawski.pl)
	  // improved by: Theriault (https://github.com/Theriault)
	  //    input by: Brett Zamir (http://brett-zamir.me)
	  //    input by: majak
	  //    input by: Alex
	  //    input by: Martin
	  //    input by: Alex Wilson
	  //    input by: Haravikk
	  // bugfixed by: Kevin van Zonneveld (http://kvz.io)
	  // bugfixed by: majak
	  // bugfixed by: Kevin van Zonneveld (http://kvz.io)
	  // bugfixed by: Brett Zamir (http://brett-zamir.me)
	  // bugfixed by: omid (http://locutus.io/php/380:380#comment_137122)
	  // bugfixed by: Chris (http://www.devotis.nl/)
	  //      note 1: Uses global: locutus to store the default timezone
	  //      note 1: Although the function potentially allows timezone info
	  //      note 1: (see notes), it currently does not set
	  //      note 1: per a timezone specified by date_default_timezone_set(). Implementers might use
	  //      note 1: $locutus.currentTimezoneOffset and
	  //      note 1: $locutus.currentTimezoneDST set by that function
	  //      note 1: in order to adjust the dates in this function
	  //      note 1: (or our other date functions!) accordingly
	  //   example 1: date('H:m:s \\m \\i\\s \\m\\o\\n\\t\\h', 1062402400)
	  //   returns 1: '07:09:40 m is month'
	  //   example 2: date('F j, Y, g:i a', 1062462400)
	  //   returns 2: 'September 2, 2003, 12:26 am'
	  //   example 3: date('Y W o', 1062462400)
	  //   returns 3: '2003 36 2003'
	  //   example 4: var $x = date('Y m d', (new Date()).getTime() / 1000)
	  //   example 4: $x = $x + ''
	  //   example 4: var $result = $x.length // 2009 01 09
	  //   returns 4: 10
	  //   example 5: date('W', 1104534000)
	  //   returns 5: '52'
	  //   example 6: date('B t', 1104534000)
	  //   returns 6: '999 31'
	  //   example 7: date('W U', 1293750000.82); // 2010-12-31
	  //   returns 7: '52 1293750000'
	  //   example 8: date('W', 1293836400); // 2011-01-01
	  //   returns 8: '52'
	  //   example 9: date('W Y-m-d', 1293974054); // 2011-01-02
	  //   returns 9: '52 2011-01-02'
	  //        test: skip-1 skip-2 skip-5

	  var jsdate, f;
	  // Keep this here (works, but for code commented-out below for file size reasons)
	  // var tal= [];
	  var txtWords = ['Sun', 'Mon', 'Tues', 'Wednes', 'Thurs', 'Fri', 'Satur', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	  // trailing backslash -> (dropped)
	  // a backslash followed by any character (including backslash) -> the character
	  // empty string -> empty string
	  var formatChr = /\\?(.?)/gi;
	  var formatChrCb = function formatChrCb(t, s) {
	    return f[t] ? f[t]() : s;
	  };
	  var _pad = function _pad(n, c) {
	    n = String(n);
	    while (n.length < c) {
	      n = '0' + n;
	    }
	    return n;
	  };
	  f = {
	    // Day
	    d: function d() {
	      // Day of month w/leading 0; 01..31
	      return _pad(f.j(), 2);
	    },
	    D: function D() {
	      // Shorthand day name; Mon...Sun
	      return f.l().slice(0, 3);
	    },
	    j: function j() {
	      // Day of month; 1..31
	      return jsdate.getDate();
	    },
	    l: function l() {
	      // Full day name; Monday...Sunday
	      return txtWords[f.w()] + 'day';
	    },
	    N: function N() {
	      // ISO-8601 day of week; 1[Mon]..7[Sun]
	      return f.w() || 7;
	    },
	    S: function S() {
	      // Ordinal suffix for day of month; st, nd, rd, th
	      var j = f.j();
	      var i = j % 10;
	      if (i <= 3 && parseInt(j % 100 / 10, 10) === 1) {
	        i = 0;
	      }
	      return ['st', 'nd', 'rd'][i - 1] || 'th';
	    },
	    w: function w() {
	      // Day of week; 0[Sun]..6[Sat]
	      return jsdate.getDay();
	    },
	    z: function z() {
	      // Day of year; 0..365
	      var a = new Date(f.Y(), f.n() - 1, f.j());
	      var b = new Date(f.Y(), 0, 1);
	      return Math.round((a - b) / 864e5);
	    },

	    // Week
	    W: function W() {
	      // ISO-8601 week number
	      var a = new Date(f.Y(), f.n() - 1, f.j() - f.N() + 3);
	      var b = new Date(a.getFullYear(), 0, 4);
	      return _pad(1 + Math.round((a - b) / 864e5 / 7), 2);
	    },

	    // Month
	    F: function F() {
	      // Full month name; January...December
	      return txtWords[6 + f.n()];
	    },
	    m: function m() {
	      // Month w/leading 0; 01...12
	      return _pad(f.n(), 2);
	    },
	    M: function M() {
	      // Shorthand month name; Jan...Dec
	      return f.F().slice(0, 3);
	    },
	    n: function n() {
	      // Month; 1...12
	      return jsdate.getMonth() + 1;
	    },
	    t: function t() {
	      // Days in month; 28...31
	      return new Date(f.Y(), f.n(), 0).getDate();
	    },

	    // Year
	    L: function L() {
	      // Is leap year?; 0 or 1
	      var j = f.Y();
	      return j % 4 === 0 & j % 100 !== 0 | j % 400 === 0;
	    },
	    o: function o() {
	      // ISO-8601 year
	      var n = f.n();
	      var W = f.W();
	      var Y = f.Y();
	      return Y + (n === 12 && W < 9 ? 1 : n === 1 && W > 9 ? -1 : 0);
	    },
	    Y: function Y() {
	      // Full year; e.g. 1980...2010
	      return jsdate.getFullYear();
	    },
	    y: function y() {
	      // Last two digits of year; 00...99
	      return f.Y().toString().slice(-2);
	    },

	    // Time
	    a: function a() {
	      // am or pm
	      return jsdate.getHours() > 11 ? 'pm' : 'am';
	    },
	    A: function A() {
	      // AM or PM
	      return f.a().toUpperCase();
	    },
	    B: function B() {
	      // Swatch Internet time; 000..999
	      var H = jsdate.getUTCHours() * 36e2;
	      // Hours
	      var i = jsdate.getUTCMinutes() * 60;
	      // Minutes
	      // Seconds
	      var s = jsdate.getUTCSeconds();
	      return _pad(Math.floor((H + i + s + 36e2) / 86.4) % 1e3, 3);
	    },
	    g: function g() {
	      // 12-Hours; 1..12
	      return f.G() % 12 || 12;
	    },
	    G: function G() {
	      // 24-Hours; 0..23
	      return jsdate.getHours();
	    },
	    h: function h() {
	      // 12-Hours w/leading 0; 01..12
	      return _pad(f.g(), 2);
	    },
	    H: function H() {
	      // 24-Hours w/leading 0; 00..23
	      return _pad(f.G(), 2);
	    },
	    i: function i() {
	      // Minutes w/leading 0; 00..59
	      return _pad(jsdate.getMinutes(), 2);
	    },
	    s: function s() {
	      // Seconds w/leading 0; 00..59
	      return _pad(jsdate.getSeconds(), 2);
	    },
	    u: function u() {
	      // Microseconds; 000000-999000
	      return _pad(jsdate.getMilliseconds() * 1000, 6);
	    },

	    // Timezone
	    e: function e() {
	      // Timezone identifier; e.g. Atlantic/Azores, ...
	      // The following works, but requires inclusion of the very large
	      // timezone_abbreviations_list() function.
	      /*              return that.date_default_timezone_get();
	       */
	      var msg = 'Not supported (see source code of date() for timezone on how to add support)';
	      throw new Error(msg);
	    },
	    I: function I() {
	      // DST observed?; 0 or 1
	      // Compares Jan 1 minus Jan 1 UTC to Jul 1 minus Jul 1 UTC.
	      // If they are not equal, then DST is observed.
	      var a = new Date(f.Y(), 0);
	      // Jan 1
	      var c = Date.UTC(f.Y(), 0);
	      // Jan 1 UTC
	      var b = new Date(f.Y(), 6);
	      // Jul 1
	      // Jul 1 UTC
	      var d = Date.UTC(f.Y(), 6);
	      return a - c !== b - d ? 1 : 0;
	    },
	    O: function O() {
	      // Difference to GMT in hour format; e.g. +0200
	      var tzo = jsdate.getTimezoneOffset();
	      var a = Math.abs(tzo);
	      return (tzo > 0 ? '-' : '+') + _pad(Math.floor(a / 60) * 100 + a % 60, 4);
	    },
	    P: function P() {
	      // Difference to GMT w/colon; e.g. +02:00
	      var O = f.O();
	      return O.substr(0, 3) + ':' + O.substr(3, 2);
	    },
	    T: function T() {
	      // The following works, but requires inclusion of the very
	      // large timezone_abbreviations_list() function.
	      /*              var abbr, i, os, _default;
	      if (!tal.length) {
	        tal = that.timezone_abbreviations_list();
	      }
	      if ($locutus && $locutus.default_timezone) {
	        _default = $locutus.default_timezone;
	        for (abbr in tal) {
	          for (i = 0; i < tal[abbr].length; i++) {
	            if (tal[abbr][i].timezone_id === _default) {
	              return abbr.toUpperCase();
	            }
	          }
	        }
	      }
	      for (abbr in tal) {
	        for (i = 0; i < tal[abbr].length; i++) {
	          os = -jsdate.getTimezoneOffset() * 60;
	          if (tal[abbr][i].offset === os) {
	            return abbr.toUpperCase();
	          }
	        }
	      }
	      */
	      return 'UTC';
	    },
	    Z: function Z() {
	      // Timezone offset in seconds (-43200...50400)
	      return -jsdate.getTimezoneOffset() * 60;
	    },

	    // Full Date/Time
	    c: function c() {
	      // ISO-8601 date.
	      return 'Y-m-d\\TH:i:sP'.replace(formatChr, formatChrCb);
	    },
	    r: function r() {
	      // RFC 2822
	      return 'D, d M Y H:i:s O'.replace(formatChr, formatChrCb);
	    },
	    U: function U() {
	      // Seconds since UNIX epoch
	      return jsdate / 1000 | 0;
	    }
	  };

	  var _date = function _date(format, timestamp) {
	    jsdate = timestamp === undefined ? new Date() // Not provided
	    : timestamp instanceof Date ? new Date(timestamp) // JS Date()
	    : new Date(timestamp * 1000) // UNIX timestamp (auto-convert to int)
	    ;
	    return format.replace(formatChr, formatChrCb);
	  };

	  return _date(format, timestamp);
	};
	//# sourceMappingURL=date.js.map

/***/ },
/* 16 */
/***/ function(module, exports) {

	'use strict';

	module.exports = function boolval(mixedVar) {
	  // original by: Will Rowe
	  //   example 1: boolval(true)
	  //   returns 1: true
	  //   example 2: boolval(false)
	  //   returns 2: false
	  //   example 3: boolval(0)
	  //   returns 3: false
	  //   example 4: boolval(0.0)
	  //   returns 4: false
	  //   example 5: boolval('')
	  //   returns 5: false
	  //   example 6: boolval('0')
	  //   returns 6: false
	  //   example 7: boolval([])
	  //   returns 7: false
	  //   example 8: boolval('')
	  //   returns 8: false
	  //   example 9: boolval(null)
	  //   returns 9: false
	  //   example 10: boolval(undefined)
	  //   returns 10: false
	  //   example 11: boolval('true')
	  //   returns 11: true

	  if (mixedVar === false) {
	    return false;
	  }

	  if (mixedVar === 0 || mixedVar === 0.0) {
	    return false;
	  }

	  if (mixedVar === '' || mixedVar === '0') {
	    return false;
	  }

	  if (Array.isArray(mixedVar) && mixedVar.length === 0) {
	    return false;
	  }

	  if (mixedVar === null || mixedVar === undefined) {
	    return false;
	  }

	  return true;
	};
	//# sourceMappingURL=boolval.js.map

/***/ },
/* 17 */
/***/ function(module, exports) {

	module.exports = function(Twig) {
	    'use strict';

	    Twig.Templates.registerLoader('ajax', function(location, params, callback, error_callback) {
	        var template,
	            xmlhttp,
	            precompiled = params.precompiled,
	            parser = this.parsers[params.parser] || this.parser.twig;

	        if (typeof XMLHttpRequest === "undefined") {
	            throw new Twig.Error('Unsupported platform: Unable to do ajax requests ' +
	                                 'because there is no "XMLHTTPRequest" implementation');
	        }

	        xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            var data = null;

	            if(xmlhttp.readyState === 4) {
	                if (xmlhttp.status === 200 || (window.cordova && xmlhttp.status == 0)) {
	                    Twig.log.debug("Got template ", xmlhttp.responseText);

	                    if (precompiled === true) {
	                        data = JSON.parse(xmlhttp.responseText);
	                    } else {
	                        data = xmlhttp.responseText;
	                    }

	                    params.url = location;
	                    params.data = data;

	                    template = parser.call(this, params);

	                    if (typeof callback === 'function') {
	                        callback(template);
	                    }
	                } else {
	                    if (typeof error_callback === 'function') {
	                        error_callback(xmlhttp);
	                    }
	                }
	            }
	        };
	        xmlhttp.open("GET", location, !!params.async);
	        xmlhttp.send();

	        if (params.async) {
	            // TODO: return deferred promise
	            return true;
	        } else {
	            return template;
	        }
	    });

	};


/***/ },
/* 18 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = function(Twig) {
	    'use strict';

	    var fs, path;

	    try {
	    	// require lib dependencies at runtime
	    	fs = __webpack_require__(19);
	    	path = __webpack_require__(20);
	    } catch (e) {
	    	// NOTE: this is in a try/catch to avoid errors cross platform
	    }

	    Twig.Templates.registerLoader('fs', function(location, params, callback, error_callback) {
	        var template,
	            data = null,
	            precompiled = params.precompiled,
	            parser = this.parsers[params.parser] || this.parser.twig;

	        if (!fs || !path) {
	            throw new Twig.Error('Unsupported platform: Unable to load from file ' +
	                                 'because there is no "fs" or "path" implementation');
	        }

	        var loadTemplateFn = function(err, data) {
	            if (err) {
	                if (typeof error_callback === 'function') {
	                    error_callback(err);
	                }
	                return;
	            }

	            if (precompiled === true) {
	                data = JSON.parse(data);
	            }

	            params.data = data;
	            params.path = params.path || location;

	            // template is in data
	            template = parser.call(this, params);

	            if (typeof callback === 'function') {
	                callback(template);
	            }
	        };
	        params.path = params.path || location;

	        if (params.async) {
	            fs.stat(params.path, function (err, stats) {
	                if (err || !stats.isFile()) {
	                    if (typeof error_callback === 'function') {
	                        error_callback(new Twig.Error('Unable to find template file ' + params.path));
	                    }
	                    return;
	                }
	                fs.readFile(params.path, 'utf8', loadTemplateFn);
	            });
	            // TODO: return deferred promise
	            return true;
	        } else {
	            try {
	                if (!fs.statSync(params.path).isFile()) {
	                    throw new Twig.Error('Unable to find template file ' + params.path);
	                }
	            } catch (err) {
	                throw new Twig.Error('Unable to find template file ' + params.path);
	            }
	            data = fs.readFileSync(params.path, 'utf8');
	            loadTemplateFn(undefined, data);
	            return template
	        }
	    });

	};


/***/ },
/* 19 */
/***/ function(module, exports) {

	module.exports = require("fs");

/***/ },
/* 20 */
/***/ function(module, exports) {

	module.exports = require("path");

/***/ },
/* 21 */
/***/ function(module, exports) {

	// ## twig.logic.js
	//
	// This file handles tokenizing, compiling and parsing logic tokens. {% ... %}
	module.exports = function (Twig) {
	    "use strict";

	    /**
	     * Namespace for logic handling.
	     */
	    Twig.logic = {};

	    /**
	     * Logic token types.
	     */
	    Twig.logic.type = {
	        if_:       'Twig.logic.type.if',
	        endif:     'Twig.logic.type.endif',
	        for_:      'Twig.logic.type.for',
	        endfor:    'Twig.logic.type.endfor',
	        else_:     'Twig.logic.type.else',
	        elseif:    'Twig.logic.type.elseif',
	        set:       'Twig.logic.type.set',
	        setcapture:'Twig.logic.type.setcapture',
	        endset:    'Twig.logic.type.endset',
	        filter:    'Twig.logic.type.filter',
	        endfilter: 'Twig.logic.type.endfilter',
	        shortblock: 'Twig.logic.type.shortblock',
	        block:     'Twig.logic.type.block',
	        endblock:  'Twig.logic.type.endblock',
	        extends_:  'Twig.logic.type.extends',
	        use:       'Twig.logic.type.use',
	        include:   'Twig.logic.type.include',
	        spaceless: 'Twig.logic.type.spaceless',
	        endspaceless: 'Twig.logic.type.endspaceless',
	        macro:     'Twig.logic.type.macro',
	        endmacro:  'Twig.logic.type.endmacro',
	        import_:   'Twig.logic.type.import',
	        from:      'Twig.logic.type.from',
	        embed:     'Twig.logic.type.embed',
	        endembed:  'Twig.logic.type.endembed'
	    };


	    // Regular expressions for handling logic tokens.
	    //
	    // Properties:
	    //
	    //      type:  The type of expression this matches
	    //
	    //      regex: A regular expression that matches the format of the token
	    //
	    //      next:  What logic tokens (if any) pop this token off the logic stack. If empty, the
	    //             logic token is assumed to not require an end tag and isn't push onto the stack.
	    //
	    //      open:  Does this tag open a logic expression or is it standalone. For example,
	    //             {% endif %} cannot exist without an opening {% if ... %} tag, so open = false.
	    //
	    //  Functions:
	    //
	    //      compile: A function that handles compiling the token into an output token ready for
	    //               parsing with the parse function.
	    //
	    //      parse:   A function that parses the compiled token into output (HTML / whatever the
	    //               template represents).
	    Twig.logic.definitions = [
	        {
	            /**
	             * If type logic tokens.
	             *
	             *  Format: {% if expression %}
	             */
	            type: Twig.logic.type.if_,
	            regex: /^if\s+([\s\S]+)$/,
	            next: [
	                Twig.logic.type.else_,
	                Twig.logic.type.elseif,
	                Twig.logic.type.endif
	            ],
	            open: true,
	            compile: function (token) {
	                var expression = token.match[1];
	                // Compile the expression.
	                token.stack = Twig.expression.compile.apply(this, [{
	                    type:  Twig.expression.type.expression,
	                    value: expression
	                }]).stack;
	                delete token.match;
	                return token;
	            },
	            parse: function (token, context, chain) {
	                var that = this;

	                return Twig.expression.parseAsync.apply(this, [token.stack, context])
	                .then(function(result) {
	                    chain = true;

	                    if (Twig.lib.boolval(result)) {
	                        chain = false;

	                        return Twig.parseAsync.apply(that, [token.output, context]);
	                    }

	                    return '';
	                })
	                .then(function(output) {
	                    return {
	                        chain: chain,
	                        output: output
	                    };
	                });
	            }
	        },
	        {
	            /**
	             * Else if type logic tokens.
	             *
	             *  Format: {% elseif expression %}
	             */
	            type: Twig.logic.type.elseif,
	            regex: /^elseif\s+([^\s].*)$/,
	            next: [
	                Twig.logic.type.else_,
	                Twig.logic.type.elseif,
	                Twig.logic.type.endif
	            ],
	            open: false,
	            compile: function (token) {
	                var expression = token.match[1];
	                // Compile the expression.
	                token.stack = Twig.expression.compile.apply(this, [{
	                    type:  Twig.expression.type.expression,
	                    value: expression
	                }]).stack;
	                delete token.match;
	                return token;
	            },
	            parse: function (token, context, chain) {
	                var that = this;

	                return Twig.expression.parseAsync.apply(this, [token.stack, context])
	                .then(function(result) {
	                    if (chain && Twig.lib.boolval(result)) {
	                        chain = false;

	                        return Twig.parseAsync.apply(that, [token.output, context]);
	                    }

	                    return '';
	                })
	                .then(function(output) {
	                    return {
	                        chain: chain,
	                        output: output
	                    }
	                });
	            }
	        },
	        {
	            /**
	             * Else if type logic tokens.
	             *
	             *  Format: {% elseif expression %}
	             */
	            type: Twig.logic.type.else_,
	            regex: /^else$/,
	            next: [
	                Twig.logic.type.endif,
	                Twig.logic.type.endfor
	            ],
	            open: false,
	            parse: function (token, context, chain) {
	                var promise = Twig.Promise.resolve('');

	                if (chain) {
	                    promise = Twig.parseAsync.apply(this, [token.output, context]);
	                }

	                return promise.then(function(output) {
	                    return {
	                        chain: chain,
	                        output: output
	                    };
	                });
	            }
	        },
	        {
	            /**
	             * End if type logic tokens.
	             *
	             *  Format: {% endif %}
	             */
	            type: Twig.logic.type.endif,
	            regex: /^endif$/,
	            next: [ ],
	            open: false
	        },
	        {
	            /**
	             * For type logic tokens.
	             *
	             *  Format: {% for expression %}
	             */
	            type: Twig.logic.type.for_,
	            regex: /^for\s+([a-zA-Z0-9_,\s]+)\s+in\s+([^\s].*?)(?:\s+if\s+([^\s].*))?$/,
	            next: [
	                Twig.logic.type.else_,
	                Twig.logic.type.endfor
	            ],
	            open: true,
	            compile: function (token) {
	                var key_value = token.match[1],
	                    expression = token.match[2],
	                    conditional = token.match[3],
	                    kv_split = null;

	                token.key_var = null;
	                token.value_var = null;

	                if (key_value.indexOf(",") >= 0) {
	                    kv_split = key_value.split(',');
	                    if (kv_split.length === 2) {
	                        token.key_var = kv_split[0].trim();
	                        token.value_var = kv_split[1].trim();
	                    } else {
	                        throw new Twig.Error("Invalid expression in for loop: " + key_value);
	                    }
	                } else {
	                    token.value_var = key_value;
	                }

	                // Valid expressions for a for loop
	                //   for item     in expression
	                //   for key,item in expression

	                // Compile the expression.
	                token.expression = Twig.expression.compile.apply(this, [{
	                    type:  Twig.expression.type.expression,
	                    value: expression
	                }]).stack;

	                // Compile the conditional (if available)
	                if (conditional) {
	                    token.conditional = Twig.expression.compile.apply(this, [{
	                        type:  Twig.expression.type.expression,
	                        value: conditional
	                    }]).stack;
	                }

	                delete token.match;
	                return token;
	            },
	            parse: function (token, context, continue_chain) {
	                // Parse expression
	                var output = [],
	                    len,
	                    index = 0,
	                    keyset,
	                    that = this,
	                    conditional = token.conditional,
	                    buildLoop = function(index, len) {
	                        var isConditional = conditional !== undefined;
	                        return {
	                            index: index+1,
	                            index0: index,
	                            revindex: isConditional?undefined:len-index,
	                            revindex0: isConditional?undefined:len-index-1,
	                            first: (index === 0),
	                            last: isConditional?undefined:(index === len-1),
	                            length: isConditional?undefined:len,
	                            parent: context
	                        };
	                    },
	                    // run once for each iteration of the loop
	                    loop = function(key, value) {
	                        var inner_context = Twig.ChildContext(context);

	                        inner_context[token.value_var] = value;

	                        if (token.key_var) {
	                            inner_context[token.key_var] = key;
	                        }

	                        // Loop object
	                        inner_context.loop = buildLoop(index, len);

	                        var promise = conditional === undefined ?
	                            Twig.Promise.resolve(true) :
	                            Twig.expression.parseAsync.apply(that, [conditional, inner_context]);

	                        promise.then(function(condition) {
	                            if (!condition)
	                                return;

	                            return Twig.parseAsync.apply(that, [token.output, inner_context])
	                            .then(function(o) {
	                                output.push(o);
	                                index += 1;
	                            });
	                        })
	                        .then(function() {
	                            // Delete loop-related variables from the context
	                            delete inner_context['loop'];
	                            delete inner_context[token.value_var];
	                            delete inner_context[token.key_var];

	                            // Merge in values that exist in context but have changed
	                            // in inner_context.
	                            Twig.merge(context, inner_context, true);
	                        });
	                    };


	                return Twig.expression.parseAsync.apply(this, [token.expression, context])
	                .then(function(result) {
	                    if (Twig.lib.is('Array', result)) {
	                        len = result.length;
	                        Twig.async.forEach(result, function (value) {
	                            var key = index;

	                            return loop(key, value);
	                        });
	                    } else if (Twig.lib.is('Object', result)) {
	                        if (result._keys !== undefined) {
	                            keyset = result._keys;
	                        } else {
	                            keyset = Object.keys(result);
	                        }
	                        len = keyset.length;
	                        Twig.forEach(keyset, function(key) {
	                            // Ignore the _keys property, it's internal to twig.js
	                            if (key === "_keys") return;

	                            loop(key,  result[key]);
	                        });
	                    }

	                    // Only allow else statements if no output was generated
	                    continue_chain = (output.length === 0);

	                    return {
	                        chain: continue_chain,
	                        output: Twig.output.apply(that, [output])
	                    };
	                });
	            }
	        },
	        {
	            /**
	             * End if type logic tokens.
	             *
	             *  Format: {% endif %}
	             */
	            type: Twig.logic.type.endfor,
	            regex: /^endfor$/,
	            next: [ ],
	            open: false
	        },
	        {
	            /**
	             * Set type logic tokens.
	             *
	             *  Format: {% set key = expression %}
	             */
	            type: Twig.logic.type.set,
	            regex: /^set\s+([a-zA-Z0-9_,\s]+)\s*=\s*([\s\S]+)$/,
	            next: [ ],
	            open: true,
	            compile: function (token) {
	                var key = token.match[1].trim(),
	                    expression = token.match[2],
	                    // Compile the expression.
	                    expression_stack  = Twig.expression.compile.apply(this, [{
	                        type:  Twig.expression.type.expression,
	                        value: expression
	                    }]).stack;

	                token.key = key;
	                token.expression = expression_stack;

	                delete token.match;
	                return token;
	            },
	            parse: function (token, context, continue_chain) {
	                var key = token.key;

	                return Twig.expression.parseAsync.apply(this, [token.expression, context])
	                .then(function(value) {
	                    if (value === context) {
	                        /*  If storing the context in a variable, it needs to be a clone of the current state of context.
	                            Otherwise we have a context with infinite recursion.
	                            Fixes #341
	                        */
	                        value = Twig.lib.copy(value);
	                    }

	                    context[key] = value;

	                    return {
	                        chain: continue_chain,
	                        context: context
	                    };
	                });
	            }
	        },
	        {
	            /**
	             * Set capture type logic tokens.
	             *
	             *  Format: {% set key %}
	             */
	            type: Twig.logic.type.setcapture,
	            regex: /^set\s+([a-zA-Z0-9_,\s]+)$/,
	            next: [
	                Twig.logic.type.endset
	            ],
	            open: true,
	            compile: function (token) {
	                var key = token.match[1].trim();

	                token.key = key;

	                delete token.match;
	                return token;
	            },
	            parse: function (token, context, continue_chain) {
	                var that = this,
	                    key = token.key;

	                return Twig.parseAsync.apply(this, [token.output, context])
	                .then(function(value) {
	                    // set on both the global and local context
	                    that.context[key] = value;
	                    context[key] = value;

	                    return {
	                        chain: continue_chain,
	                        context: context
	                    };
	                });
	            }
	        },
	        {
	            /**
	             * End set type block logic tokens.
	             *
	             *  Format: {% endset %}
	             */
	            type: Twig.logic.type.endset,
	            regex: /^endset$/,
	            next: [ ],
	            open: false
	        },
	        {
	            /**
	             * Filter logic tokens.
	             *
	             *  Format: {% filter upper %} or {% filter lower|escape %}
	             */
	            type: Twig.logic.type.filter,
	            regex: /^filter\s+(.+)$/,
	            next: [
	                Twig.logic.type.endfilter
	            ],
	            open: true,
	            compile: function (token) {
	                var expression = "|" + token.match[1].trim();
	                // Compile the expression.
	                token.stack = Twig.expression.compile.apply(this, [{
	                    type:  Twig.expression.type.expression,
	                    value: expression
	                }]).stack;
	                delete token.match;
	                return token;
	            },
	            parse: function (token, context, chain) {
	                return Twig.parseAsync.apply(this, [token.output, context])
	                .then(function(unfiltered) {
	                    var stack = [{
	                        type: Twig.expression.type.string,
	                        value: unfiltered
	                    }].concat(token.stack);

	                    return Twig.expression.parseAsync.apply(that, [stack, context]);
	                })
	                .then(function(output) {
	                    return {
	                        chain: chain,
	                        output: output
	                    }
	                });
	            }
	        },
	        {
	            /**
	             * End filter logic tokens.
	             *
	             *  Format: {% endfilter %}
	             */
	            type: Twig.logic.type.endfilter,
	            regex: /^endfilter$/,
	            next: [ ],
	            open: false
	        },
	        {
	            /**
	             * Block logic tokens.
	             *
	             *  Format: {% block title %}
	             */
	            type: Twig.logic.type.block,
	            regex: /^block\s+([a-zA-Z0-9_]+)$/,
	            next: [
	                Twig.logic.type.endblock
	            ],
	            open: true,
	            compile: function (token) {
	                token.block = token.match[1].trim();
	                delete token.match;
	                return token;
	            },
	            parse: function (token, context, chain) {
	                var that = this,
	                    block_output,
	                    output,
	                    promise = Twig.Promise.resolve(),
	                    isImported = Twig.indexOf(this.importedBlocks, token.block) > -1,
	                    hasParent = this.blocks[token.block] && Twig.indexOf(this.blocks[token.block], Twig.placeholders.parent) > -1;

	                // Don't override previous blocks unless they're imported with "use"
	                // Loops should be exempted as well.
	                if (this.blocks[token.block] === undefined || isImported || hasParent || context.loop || token.overwrite) {
	                    if (token.expression) {
	                        promise = Twig.expression.parseAsync.apply(this, [token.output, context])
	                        .then(function(value) {
	                            return Twig.expression.parseAsync.apply(that, [{
	                                type: Twig.expression.type.string,
	                                value: value
	                            }, context]);
	                        });
	                    } else {
	                        promise = Twig.parseAsync.apply(this, [token.output, context])
	                        .then(function(value) {
	                            return Twig.expression.parseAsync.apply(that, [{
	                                type: Twig.expression.type.string,
	                                value: value
	                            }, context]);
	                        });
	                    }

	                    promise = promise.then(function(block_output) {
	                        if (isImported) {
	                            // once the block is overridden, remove it from the list of imported blocks
	                            that.importedBlocks.splice(that.importedBlocks.indexOf(token.block), 1);
	                        }

	                        if (hasParent) {
	                            that.blocks[token.block] = Twig.Markup(that.blocks[token.block].replace(Twig.placeholders.parent, block_output));
	                        } else {
	                            that.blocks[token.block] = block_output;
	                        }

	                        that.originalBlockTokens[token.block] = {
	                            type: token.type,
	                            block: token.block,
	                            output: token.output,
	                            overwrite: true
	                        };
	                    });
	                }

	                return promise.then(function() {
	                    // Check if a child block has been set from a template extending this one.
	                    if (that.child.blocks[token.block]) {
	                        output = that.child.blocks[token.block];
	                    } else {
	                        output = that.blocks[token.block];
	                    }

	                    return {
	                        chain: chain,
	                        output: output
	                    };
	                });
	            }
	        },
	        {
	            /**
	             * Block shorthand logic tokens.
	             *
	             *  Format: {% block title expression %}
	             */
	            type: Twig.logic.type.shortblock,
	            regex: /^block\s+([a-zA-Z0-9_]+)\s+(.+)$/,
	            next: [ ],
	            open: true,
	            compile: function (token) {
	                token.expression = token.match[2].trim();

	                token.output = Twig.expression.compile({
	                    type: Twig.expression.type.expression,
	                    value: token.expression
	                }).stack;

	                token.block = token.match[1].trim();
	                delete token.match;
	                return token;
	            },
	            parse: function (token, context, chain) {
	                return Twig.logic.handler[Twig.logic.type.block].parse.apply(this, arguments);
	            }
	        },
	        {
	            /**
	             * End block logic tokens.
	             *
	             *  Format: {% endblock %}
	             */
	            type: Twig.logic.type.endblock,
	            regex: /^endblock(?:\s+([a-zA-Z0-9_]+))?$/,
	            next: [ ],
	            open: false
	        },
	        {
	            /**
	             * Block logic tokens.
	             *
	             *  Format: {% extends "template.twig" %}
	             */
	            type: Twig.logic.type.extends_,
	            regex: /^extends\s+(.+)$/,
	            next: [ ],
	            open: true,
	            compile: function (token) {
	                var expression = token.match[1].trim();
	                delete token.match;

	                token.stack   = Twig.expression.compile.apply(this, [{
	                    type:  Twig.expression.type.expression,
	                    value: expression
	                }]).stack;

	                return token;
	            },
	            parse: function (token, context, chain) {
	                var template,
	                    that = this,
	                    innerContext = Twig.ChildContext(context);

	                // Resolve filename
	                return Twig.expression.parseAsync.apply(this, [token.stack, context])
	                .then(function(file) {
	                    // Set parent template
	                    that.extend = file;

	                    if (file instanceof Twig.Template) {
	                        template = file;
	                    } else {
	                        // Import file
	                        template = that.importFile(file);
	                    }

	                    // Render the template in case it puts anything in its context
	                    return template.renderAsync(innerContext);
	                })
	                .then(function() {
	                    // Extend the parent context with the extended context
	                    Twig.lib.extend(context, innerContext);

	                    return {
	                        chain: chain,
	                        output: ''
	                    };
	                });
	            }
	        },
	        {
	            /**
	             * Block logic tokens.
	             *
	             *  Format: {% use "template.twig" %}
	             */
	            type: Twig.logic.type.use,
	            regex: /^use\s+(.+)$/,
	            next: [ ],
	            open: true,
	            compile: function (token) {
	                var expression = token.match[1].trim();
	                delete token.match;

	                token.stack = Twig.expression.compile.apply(this, [{
	                    type:  Twig.expression.type.expression,
	                    value: expression
	                }]).stack;

	                return token;
	            },
	            parse: function (token, context, chain) {
	                var that = this;

	                // Resolve filename
	                return Twig.expression.parseAsync.apply(this, [token.stack, context])
	                .then(function(file) {
	                    // Import blocks
	                    that.importBlocks(file);

	                    return {
	                        chain: chain,
	                        output: ''
	                    };
	                });
	            }
	        },
	        {
	            /**
	             * Block logic tokens.
	             *
	             *  Format: {% includes "template.twig" [with {some: 'values'} only] %}
	             */
	            type: Twig.logic.type.include,
	            regex: /^include\s+(.+?)(?:\s|$)(ignore missing(?:\s|$))?(?:with\s+([\S\s]+?))?(?:\s|$)(only)?$/,
	            next: [ ],
	            open: true,
	            compile: function (token) {
	                var match = token.match,
	                    expression = match[1].trim(),
	                    ignoreMissing = match[2] !== undefined,
	                    withContext = match[3],
	                    only = ((match[4] !== undefined) && match[4].length);

	                delete token.match;

	                token.only = only;
	                token.ignoreMissing = ignoreMissing;

	                token.stack = Twig.expression.compile.apply(this, [{
	                    type:  Twig.expression.type.expression,
	                    value: expression
	                }]).stack;

	                if (withContext !== undefined) {
	                    token.withStack = Twig.expression.compile.apply(this, [{
	                        type:  Twig.expression.type.expression,
	                        value: withContext.trim()
	                    }]).stack;
	                }

	                return token;
	            },
	            parse: function (token, context, chain) {
	                // Resolve filename
	                var innerContext = {},
	                    i,
	                    template,
	                    that = this,
	                    promise = Twig.Promise.resolve();

	                if (!token.only) {
	                    innerContext = Twig.ChildContext(context);
	                }

	                if (token.withStack !== undefined) {
	                    promise = Twig.expression.parseAsync.apply(this, [token.withStack, context])
	                    .then(function(withContext) {
	                        for (i in withContext) {
	                            if (withContext.hasOwnProperty(i))
	                                innerContext[i] = withContext[i];
	                        }
	                    });
	                }

	                return promise
	                .then(function() {
	                    return Twig.expression.parseAsync.apply(that, [token.stack, context]);
	                })
	                .then(function(file) {
	                    if (file instanceof Twig.Template) {
	                        template = file;
	                    } else {
	                        // Import file
	                        try {
	                            template = that.importFile(file);
	                        } catch (err) {
	                            if (token.ignoreMissing) {
	                                return '';
	                            }

	                            throw err;
	                        }
	                    }

	                    return template.renderAsync(innerContext);
	                })
	                .then(function(output) {
	                    return {
	                        chain: chain,
	                        output: output
	                    };
	                });
	            }
	        },
	        {
	            type: Twig.logic.type.spaceless,
	            regex: /^spaceless$/,
	            next: [
	                Twig.logic.type.endspaceless
	            ],
	            open: true,

	            // Parse the html and return it without any spaces between tags
	            parse: function (token, context, chain) {
	                // Parse the output without any filter
	                return Twig.parseAsync.apply(this, [token.output, context])
	                .then(function(unfiltered) {
	                    var // A regular expression to find closing and opening tags with spaces between them
	                        rBetweenTagSpaces = />\s+</g,
	                        // Replace all space between closing and opening html tags
	                        output = unfiltered.replace(rBetweenTagSpaces,'><').trim();
	                        // Rewrap output as a Twig.Markup
	                        output = Twig.Markup(output);
	                    return {
	                        chain: chain,
	                        output: output
	                    };
	                });
	            }
	        },

	        // Add the {% endspaceless %} token
	        {
	            type: Twig.logic.type.endspaceless,
	            regex: /^endspaceless$/,
	            next: [ ],
	            open: false
	        },
	        {
	            /**
	             * Macro logic tokens.
	             *
	             * Format: {% maro input(name, value, type, size) %}
	             *
	             */
	            type: Twig.logic.type.macro,
	            regex: /^macro\s+([a-zA-Z0-9_]+)\s*\(\s*((?:[a-zA-Z0-9_]+(?:,\s*)?)*)\s*\)$/,
	            next: [
	                Twig.logic.type.endmacro
	            ],
	            open: true,
	            compile: function (token) {
	                var macroName = token.match[1],
	                    parameters = token.match[2].split(/[\s,]+/);

	                //TODO: Clean up duplicate check
	                for (var i=0; i<parameters.length; i++) {
	                    for (var j=0; j<parameters.length; j++){
	                        if (parameters[i] === parameters[j] && i !== j) {
	                            throw new Twig.Error("Duplicate arguments for parameter: "+ parameters[i]);
	                        }
	                    }
	                }

	                token.macroName = macroName;
	                token.parameters = parameters;

	                delete token.match;
	                return token;
	            },
	            parse: function (token, context, chain) {
	                var template = this;
	                this.macros[token.macroName] = function() {
	                    // Pass global context and other macros
	                    var macroContext = {
	                        _self: template.macros
	                    }
	                    // Add parameters from context to macroContext
	                    for (var i=0; i<token.parameters.length; i++) {
	                        var prop = token.parameters[i];
	                        if(typeof arguments[i] !== 'undefined') {
	                            macroContext[prop] = arguments[i];
	                        } else {
	                            macroContext[prop] = undefined;
	                        }
	                    }

	                    // Render
	                    return Twig.parseAsync.apply(template, [token.output, macroContext]);
	                };

	                return {
	                    chain: chain,
	                    output: ''
	                };

	            }
	        },
	        {
	            /**
	             * End macro logic tokens.
	             *
	             * Format: {% endmacro %}
	             */
	             type: Twig.logic.type.endmacro,
	             regex: /^endmacro$/,
	             next: [ ],
	             open: false
	        },
	        {
	            /*
	            * import logic tokens.
	            *
	            * Format: {% import "template.twig" as form %}
	            */
	            type: Twig.logic.type.import_,
	            regex: /^import\s+(.+)\s+as\s+([a-zA-Z0-9_]+)$/,
	            next: [ ],
	            open: true,
	            compile: function (token) {
	                var expression = token.match[1].trim(),
	                    contextName = token.match[2].trim();
	                delete token.match;

	                token.expression = expression;
	                token.contextName = contextName;

	                token.stack = Twig.expression.compile.apply(this, [{
	                    type: Twig.expression.type.expression,
	                    value: expression
	                }]).stack;

	                return token;
	            },
	            parse: function (token, context, chain) {
	                var that = this,
	                    output = { chain: chain, output: '' };

	                if (token.expression === '_self') {
	                    context[token.contextName] = this.macros;
	                    return Twig.Promise.resolve(output);
	                }

	                return Twig.expression.parseAsync.apply(this, [token.stack, context])
	                .then(function(file) {
	                    return that.importFile(file || token.expression);
	                })
	                .then(function(template) {
	                    context[token.contextName] = template.renderAsync({}, {output: 'macros'});

	                    return output;
	                });
	            }
	        },
	        {
	            /*
	            * from logic tokens.
	            *
	            * Format: {% from "template.twig" import func as form %}
	            */
	            type: Twig.logic.type.from,
	            regex: /^from\s+(.+)\s+import\s+([a-zA-Z0-9_, ]+)$/,
	            next: [ ],
	            open: true,
	            compile: function (token) {
	                var expression = token.match[1].trim(),
	                    macroExpressions = token.match[2].trim().split(/\s*,\s*/),
	                    macroNames = {};

	                for (var i=0; i<macroExpressions.length; i++) {
	                    var res = macroExpressions[i];

	                    // match function as variable
	                    var macroMatch = res.match(/^([a-zA-Z0-9_]+)\s+as\s+([a-zA-Z0-9_]+)$/);
	                    if (macroMatch) {
	                        macroNames[macroMatch[1].trim()] = macroMatch[2].trim();
	                    }
	                    else if (res.match(/^([a-zA-Z0-9_]+)$/)) {
	                        macroNames[res] = res;
	                    }
	                    else {
	                        // ignore import
	                    }

	                }

	                delete token.match;

	                token.expression = expression;
	                token.macroNames = macroNames;

	                token.stack = Twig.expression.compile.apply(this, [{
	                    type: Twig.expression.type.expression,
	                    value: expression
	                }]).stack;

	                return token;
	            },
	            parse: function (token, context, chain) {
	                var that = this,
	                    promise = Twig.Promise.resolve(this.macros);

	                if (token.expression !== "_self") {
	                    promise = Twig.expression.parseAsync.apply(this, [token.stack, context])
	                    .then(function(file) {
	                        return that.importFile(file || token.expression);
	                    })
	                    .then(function(template) {
	                        return template.renderAsync({}, {output: 'macros'});
	                    });
	                }

	                return promise
	                .then(function(macros) {
	                    for (var macroName in token.macroNames) {
	                        if (macros.hasOwnProperty(macroName)) {
	                            context[token.macroNames[macroName]] = macros[macroName];
	                        }
	                    }

	                    return {
	                        chain: chain,
	                        output: ''
	                    }
	                });
	            }
	        },
	        {
	            /**
	             * The embed tag combines the behaviour of include and extends.
	             * It allows you to include another template's contents, just like include does.
	             *
	             *  Format: {% embed "template.twig" [with {some: 'values'} only] %}
	             */
	            type: Twig.logic.type.embed,
	            regex: /^embed\s+(.+?)(?:\s|$)(ignore missing(?:\s|$))?(?:with\s+([\S\s]+?))?(?:\s|$)(only)?$/,
	            next: [
	                Twig.logic.type.endembed
	            ],
	            open: true,
	            compile: function (token) {
	                var match = token.match,
	                    expression = match[1].trim(),
	                    ignoreMissing = match[2] !== undefined,
	                    withContext = match[3],
	                    only = ((match[4] !== undefined) && match[4].length);

	                delete token.match;

	                token.only = only;
	                token.ignoreMissing = ignoreMissing;

	                token.stack = Twig.expression.compile.apply(this, [{
	                    type:  Twig.expression.type.expression,
	                    value: expression
	                }]).stack;

	                if (withContext !== undefined) {
	                    token.withStack = Twig.expression.compile.apply(this, [{
	                        type:  Twig.expression.type.expression,
	                        value: withContext.trim()
	                    }]).stack;
	                }

	                return token;
	            },
	            parse: function (token, context, chain) {
	                // Resolve filename
	                var innerContext = {},
	                    that = this,
	                    i,
	                    template,
	                    promise = Twig.Promise.resolve();

	                if (!token.only) {
	                    for (i in context) {
	                        if (context.hasOwnProperty(i))
	                            innerContext[i] = context[i];
	                    }
	                }

	                if (token.withStack !== undefined) {
	                    promise = Twig.expression.parseAsync.apply(this, [token.withStack, context])
	                    .then(function(withContext) {
	                        for (i in withContext) {
	                            if (withContext.hasOwnProperty(i))
	                                innerContext[i] = withContext[i];
	                        }
	                    });
	                }

	                return promise.then(function() {
	                    return Twig.expression.parseAsync.apply(that, [token.stack, innerContext]);
	                })
	                .then(function(file) {
	                    if (file instanceof Twig.Template) {
	                        template = file;
	                    } else {
	                        // Import file
	                        try {
	                            template = that.importFile(file);
	                        } catch (err) {
	                            if (token.ignoreMissing) {
	                                return '';
	                            }

	                            throw err;
	                        }
	                    }

	                    // reset previous blocks
	                    that.blocks = {};

	                    // parse tokens. output will be not used
	                    return Twig.parseAsync.apply(that, [token.output, innerContext])
	                    .then(function() {
	                        // render tempalte with blocks defined in embed block
	                        return template.renderAsync(innerContext, {'blocks':that.blocks});
	                    });
	                })
	                .then(function(output) {
	                    return {
	                        chain: chain,
	                        output: output
	                    };
	                });
	            }
	        },
	        /* Add the {% endembed %} token
	         *
	         */
	        {
	            type: Twig.logic.type.endembed,
	            regex: /^endembed$/,
	            next: [ ],
	            open: false
	        }

	    ];


	    /**
	     * Registry for logic handlers.
	     */
	    Twig.logic.handler = {};

	    /**
	     * Define a new token type, available at Twig.logic.type.{type}
	     */
	    Twig.logic.extendType = function (type, value) {
	        value = value || ("Twig.logic.type" + type);
	        Twig.logic.type[type] = value;
	    };

	    /**
	     * Extend the logic parsing functionality with a new token definition.
	     *
	     * // Define a new tag
	     * Twig.logic.extend({
	     *     type: Twig.logic.type.{type},
	     *     // The pattern to match for this token
	     *     regex: ...,
	     *     // What token types can follow this token, leave blank if any.
	     *     next: [ ... ]
	     *     // Create and return compiled version of the token
	     *     compile: function(token) { ... }
	     *     // Parse the compiled token with the context provided by the render call
	     *     //   and whether this token chain is complete.
	     *     parse: function(token, context, chain) { ... }
	     * });
	     *
	     * @param {Object} definition The new logic expression.
	     */
	    Twig.logic.extend = function (definition) {

	        if (!definition.type) {
	            throw new Twig.Error("Unable to extend logic definition. No type provided for " + definition);
	        } else {
	            Twig.logic.extendType(definition.type);
	        }
	        Twig.logic.handler[definition.type] = definition;
	    };

	    // Extend with built-in expressions
	    while (Twig.logic.definitions.length > 0) {
	        Twig.logic.extend(Twig.logic.definitions.shift());
	    }

	    /**
	     * Compile a logic token into an object ready for parsing.
	     *
	     * @param {Object} raw_token An uncompiled logic token.
	     *
	     * @return {Object} A compiled logic token, ready for parsing.
	     */
	    Twig.logic.compile = function (raw_token) {
	        var expression = raw_token.value.trim(),
	            token = Twig.logic.tokenize.apply(this, [expression]),
	            token_template = Twig.logic.handler[token.type];

	        // Check if the token needs compiling
	        if (token_template.compile) {
	            token = token_template.compile.apply(this, [token]);
	            Twig.log.trace("Twig.logic.compile: ", "Compiled logic token to ", token);
	        }

	        return token;
	    };

	    /**
	     * Tokenize logic expressions. This function matches token expressions against regular
	     * expressions provided in token definitions provided with Twig.logic.extend.
	     *
	     * @param {string} expression the logic token expression to tokenize
	     *                (i.e. what's between {% and %})
	     *
	     * @return {Object} The matched token with type set to the token type and match to the regex match.
	     */
	    Twig.logic.tokenize = function (expression) {
	        var token = {},
	            token_template_type = null,
	            token_type = null,
	            token_regex = null,
	            regex_array = null,
	            regex = null,
	            match = null;

	        // Ignore whitespace around expressions.
	        expression = expression.trim();

	        for (token_template_type in Twig.logic.handler) {
	            if (Twig.logic.handler.hasOwnProperty(token_template_type)) {
	                // Get the type and regex for this template type
	                token_type = Twig.logic.handler[token_template_type].type;
	                token_regex = Twig.logic.handler[token_template_type].regex;

	                // Handle multiple regular expressions per type.
	                regex_array = [];
	                if (token_regex instanceof Array) {
	                    regex_array = token_regex;
	                } else {
	                    regex_array.push(token_regex);
	                }

	                // Check regular expressions in the order they were specified in the definition.
	                while (regex_array.length > 0) {
	                    regex = regex_array.shift();
	                    match = regex.exec(expression.trim());
	                    if (match !== null) {
	                        token.type  = token_type;
	                        token.match = match;
	                        Twig.log.trace("Twig.logic.tokenize: ", "Matched a ", token_type, " regular expression of ", match);
	                        return token;
	                    }
	                }
	            }
	        }

	        // No regex matches
	        throw new Twig.Error("Unable to parse '" + expression.trim() + "'");
	    };

	    /**
	     * Parse a logic token within a given context.
	     *
	     * What are logic chains?
	     *      Logic chains represent a series of tokens that are connected,
	     *          for example:
	     *          {% if ... %} {% else %} {% endif %}
	     *
	     *      The chain parameter is used to signify if a chain is open of closed.
	     *      open:
	     *          More tokens in this chain should be parsed.
	     *      closed:
	     *          This token chain has completed parsing and any additional
	     *          tokens (else, elseif, etc...) should be ignored.
	     *
	     * @param {Object} token The compiled token.
	     * @param {Object} context The render context.
	     * @param {boolean} chain Is this an open logic chain. If false, that means a
	     *                        chain is closed and no further cases should be parsed.
	     */
	    Twig.logic.parse = function (token, context, chain, allow_async) {
	        var output = '',
	            promise,
	            is_async = true,
	            token_template;

	        context = context || { };

	        Twig.log.debug("Twig.logic.parse: ", "Parsing logic token ", token);

	        token_template = Twig.logic.handler[token.type];

	        if (token_template.parse) {
	            output = token_template.parse.apply(this, [token, context, chain]);
	        }

	        promise = Twig.isPromise(output) ? output : Twig.Promise.resolve(output);

	        promise.then(function(o) {
	            is_async = false;
	            output = o;
	        });

	        if (allow_async)
	            return promise || Twig.Promise.resolve(output);

	        if (is_async)
	            throw new Twig.Error('You are using Twig.js in sync mode in combination with async extensions.');

	        return output;
	    };

	    return Twig;

	};


/***/ },
/* 22 */
/***/ function(module, exports) {

	module.exports = function(Twig) {
	    'use strict';

	    Twig.Templates.registerParser('source', function(params) {
	        return params.data || '';
	    });
	};


/***/ },
/* 23 */
/***/ function(module, exports) {

	module.exports = function(Twig) {
	    'use strict';

	    Twig.Templates.registerParser('twig', function(params) {
	        return new Twig.Template(params);
	    });
	};


/***/ },
/* 24 */
/***/ function(module, exports, __webpack_require__) {

	// ## twig.path.js
	//
	// This file handles path parsing
	module.exports = function (Twig) {
	    "use strict";

	    /**
	     * Namespace for path handling.
	     */
	    Twig.path = {};

	    /**
	     * Generate the canonical version of a url based on the given base path and file path and in
	     * the previously registered namespaces.
	     *
	     * @param  {string} template The Twig Template
	     * @param  {string} file     The file path, may be relative and may contain namespaces.
	     *
	     * @return {string}          The canonical version of the path
	     */
	     Twig.path.parsePath = function(template, file) {
	        var namespaces = null,
	            file = file || "";

	        if (typeof template === 'object' && typeof template.options === 'object') {
	            namespaces = template.options.namespaces;
	        }

	        if (typeof namespaces === 'object' && (file.indexOf('::') > 0) || file.indexOf('@') >= 0){
	            for (var k in namespaces){
	                if (namespaces.hasOwnProperty(k)) {
	                    file = file.replace(k + '::', namespaces[k]);
	                    file = file.replace('@' + k, namespaces[k]);
	                }
	            }

	            return file;
	        }

	        return Twig.path.relativePath(template, file);
	    };

	    /**
	     * Generate the relative canonical version of a url based on the given base path and file path.
	     *
	     * @param {Twig.Template} template The Twig.Template.
	     * @param {string} file The file path, relative to the base path.
	     *
	     * @return {string} The canonical version of the path.
	     */
	    Twig.path.relativePath = function(template, file) {
	        var base,
	            base_path,
	            sep_chr = "/",
	            new_path = [],
	            file = file || "",
	            val;

	        if (template.url) {
	            if (typeof template.base !== 'undefined') {
	                base = template.base + ((template.base.charAt(template.base.length-1) === '/') ? '' : '/');
	            } else {
	                base = template.url;
	            }
	        } else if (template.path) {
	            // Get the system-specific path separator
	            var path = __webpack_require__(20),
	                sep = path.sep || sep_chr,
	                relative = new RegExp("^\\.{1,2}" + sep.replace("\\", "\\\\"));
	            file = file.replace(/\//g, sep);

	            if (template.base !== undefined && file.match(relative) == null) {
	                file = file.replace(template.base, '');
	                base = template.base + sep;
	            } else {
	                base = path.normalize(template.path);
	            }

	            base = base.replace(sep+sep, sep);
	            sep_chr = sep;
	        } else if ((template.name || template.id) && template.method && template.method !== 'fs' && template.method !== 'ajax') {
	            // Custom registered loader
	            base = template.base || template.name || template.id;
	        } else {
	            throw new Twig.Error("Cannot extend an inline template.");
	        }

	        base_path = base.split(sep_chr);

	        // Remove file from url
	        base_path.pop();
	        base_path = base_path.concat(file.split(sep_chr));

	        while (base_path.length > 0) {
	            val = base_path.shift();
	            if (val == ".") {
	                // Ignore
	            } else if (val == ".." && new_path.length > 0 && new_path[new_path.length-1] != "..") {
	                new_path.pop();
	            } else {
	                new_path.push(val);
	            }
	        }

	        return new_path.join(sep_chr);
	    };

	    return Twig;
	};


/***/ },
/* 25 */
/***/ function(module, exports) {

	// ## twig.tests.js
	//
	// This file handles expression tests. (is empty, is not defined, etc...)
	module.exports = function (Twig) {
	    "use strict";
	    Twig.tests = {
	        empty: function(value) {
	            if (value === null || value === undefined) return true;
	            // Handler numbers
	            if (typeof value === "number") return false; // numbers are never "empty"
	            // Handle strings and arrays
	            if (value.length && value.length > 0) return false;
	            // Handle objects
	            for (var key in value) {
	                if (value.hasOwnProperty(key)) return false;
	            }
	            return true;
	        },
	        odd: function(value) {
	            return value % 2 === 1;
	        },
	        even: function(value) {
	            return value % 2 === 0;
	        },
	        divisibleby: function(value, params) {
	            return value % params[0] === 0;
	        },
	        defined: function(value) {
	            return value !== undefined;
	        },
	        none: function(value) {
	            return value === null;
	        },
	        'null': function(value) {
	            return this.none(value); // Alias of none
	        },
	        'same as': function(value, params) {
	            return value === params[0];
	        },
	        sameas: function(value, params) {
	            console.warn('`sameas` is deprecated use `same as`');
	            return Twig.tests['same as'](value, params);
	        },
	        iterable: function(value) {
	            return value && (Twig.lib.is("Array", value) || Twig.lib.is("Object", value));
	        }
	        /*
	        constant ?
	         */
	    };

	    Twig.test = function(test, value, params) {
	        if (!Twig.tests[test]) {
	            throw "Test " + test + " is not defined.";
	        }
	        return Twig.tests[test](value, params);
	    };

	    Twig.test.extend = function(test, definition) {
	        Twig.tests[test] = definition;
	    };

	    return Twig;
	};


/***/ },
/* 26 */
/***/ function(module, exports) {

	// ## twig.async.js
	//
	// This file handles asynchronous tasks within twig.
	module.exports = function (Twig) {
	    "use strict";

	    Twig.parseAsync = function (tokens, context) {
	        return Twig.parse.apply(this, [tokens, context, true]);
	    }

	    Twig.expression.parseAsync = function (tokens, context, tokens_are_parameters) {
	        return Twig.expression.parse.apply(this, [tokens, context, tokens_are_parameters, true]);
	    }

	    Twig.logic.parseAsync = function (token, context, chain) {
	        return Twig.logic.parse.apply(this, [token, context, chain, true]);
	    }

	    Twig.Template.prototype.renderAsync = function (context, params) {
	        return this.render(context, params, true);
	    }

	    Twig.async = {};

	    /**
	     * Checks for `thenable` objects
	     */
	    Twig.isPromise = function(obj) {
	        return obj && (typeof obj.then == 'function');
	    }

	    /**
	     * An alternate implementation of a Promise that does not fully follow
	     * the spec, but instead works fully synchronous while still being
	     * thenable.
	     *
	     * These promises can be mixed with regular promises at which point
	     * the synchronous behaviour is lost.
	     */
	    Twig.Promise = function(executor) {
	        // State
	        var state = 'unknown';
	        var value = null;
	        var handlers = null;

	        function changeState(newState, v) {
	            state = newState;
	            value = v;
	            notify();
	        };
	        function onResolve(v) { changeState('resolve', v); }
	        function onReject(e) { changeState('reject', e); }

	        function notify() {
	            if (!handlers) return;

	            Twig.forEach(handlers, function(h) {
	                append(h.resolve, h.reject);
	            });
	            handlers = null;
	        }

	        function append(onResolved, onRejected) {
	            var h = {
	                resolve: onResolved,
	                reject: onRejected
	            };

	            // The promise has yet to be rejected or resolved.
	            if (state == 'unknown') {
	                handlers = handlers || [];
	                return handlers.push(h);
	            }

	            // The state has been changed to either resolve, or reject
	            // which means we should call the handler.
	            if (h[state])
	                h[state](value);
	        }

	        function run(fn, resolve, reject) {
	            var done = false;
	            try {
	                fn(function(v) {
	                    if (done) return;
	                    done = true;
	                    resolve(v);
	                }, function(e) {
	                    if (done) return;
	                    done = true;
	                    reject(e);
	                });
	            } catch(e) {
	                done = true;
	                reject(e);
	            }
	        }

	        function ready(result) {
	            try {
	                if (!Twig.isPromise(result)) {
	                    return onResolve(result);
	                }

	                run(result.then.bind(result), ready, onReject);
	            } catch (e) {
	                onReject(e);
	            }
	        }

	        run(executor, ready, onReject);

	        return {
	            then: function(onResolved, onRejected) {
	                var hasResolved = typeof onResolved == 'function';
	                var hasRejected = typeof onRejected == 'function';

	                return new Twig.Promise(function(resolve, reject) {
	                    append(function(result) {
	                        if (hasResolved) {
	                            try {
	                                resolve(onResolved(result));
	                            } catch (e) {
	                                reject(e);
	                            }
	                        } else {
	                            resolve(result);
	                        }
	                    }, function(err) {
	                        if (hasRejected) {
	                            try {
	                                resolve(onRejected(err));
	                            } catch (e) {
	                                reject(e);
	                            }
	                        } else {
	                            reject(err);
	                        }
	                    });
	                });
	            },
	            catch: function(onRejected) {
	                return this.then(null, onRejected);
	            }
	        };
	    }

	    Twig.Promise.resolve = function(value) {
	        return new Twig.Promise(function(resolve) {
	            resolve(value);
	        });
	    };

	    Twig.Promise.reject = function(e) {
	        return new Twig.Promise(function(resolve, reject) {
	            reject(e);
	        });
	    };

	    Twig.Promise.all = function(promises) {
	        var results = [];

	        return Twig.async.forEach(promises, function(p, index) {
	            if (!Twig.isPromise(p)) {
	                results[index] = p;
	                return;
	            }

	            return p.then(function(v) {
	                results[index] = v;
	            });
	        })
	        .then(function() {
	            return results;
	        });
	    };

	    /**
	    * Go over each item in a fashion compatible with Twig.forEach,
	    * allow the function to return a promise or call the third argument
	    * to signal it is finished.
	    *
	    * Each item in the array will be called sequentially.
	    */
	    Twig.async.forEach = function forEachAsync(arr, callback) {
	        var arg_index = 0;
	        var callbacks = {};
	        var promise = new Twig.Promise(function(resolve, reject) {
	            callbacks = {
	                resolve: resolve,
	                reject: reject
	            };
	        });

	        function fail(err) {
	            callbacks.reject(err);
	        }

	        function next(value) {
	            if (!Twig.isPromise(value))
	                return iterate();

	            value.then(next, fail);
	        }

	        function iterate() {
	            var index = arg_index++;

	            if (index == arr.length) {
	                callbacks.resolve();
	                return;
	            }

	            next(callback(arr[index], index));
	        }

	        iterate();

	        return promise;
	    };

	    return Twig;

	};


/***/ },
/* 27 */
/***/ function(module, exports) {

	// ## twig.exports.js
	//
	// This file provides extension points and other hooks into the twig functionality.

	module.exports = function (Twig) {
	    "use strict";
	    Twig.exports = {
	        VERSION: Twig.VERSION
	    };

	    /**
	     * Create and compile a twig.js template.
	     *
	     * @param {Object} param Paramteres for creating a Twig template.
	     *
	     * @return {Twig.Template} A Twig template ready for rendering.
	     */
	    Twig.exports.twig = function twig(params) {
	        'use strict';
	        var id = params.id,
	            options = {
	                strict_variables: params.strict_variables || false,
	                // TODO: turn autoscape on in the next major version
	                autoescape: params.autoescape != null && params.autoescape || false,
	                allowInlineIncludes: params.allowInlineIncludes || false,
	                rethrow: params.rethrow || false,
	                namespaces: params.namespaces
	            };

	        if (Twig.cache && id) {
	            Twig.validateId(id);
	        }

	        if (params.debug !== undefined) {
	            Twig.debug = params.debug;
	        }
	        if (params.trace !== undefined) {
	            Twig.trace = params.trace;
	        }

	        if (params.data !== undefined) {
	            return Twig.Templates.parsers.twig({
	                data: params.data,
	                path: params.hasOwnProperty('path') ? params.path : undefined,
	                module: params.module,
	                id:   id,
	                options: options
	            });

	        } else if (params.ref !== undefined) {
	            if (params.id !== undefined) {
	                throw new Twig.Error("Both ref and id cannot be set on a twig.js template.");
	            }
	            return Twig.Templates.load(params.ref);
	        
	        } else if (params.method !== undefined) {
	            if (!Twig.Templates.isRegisteredLoader(params.method)) {
	                throw new Twig.Error('Loader for "' + params.method + '" is not defined.');
	            }
	            return Twig.Templates.loadRemote(params.name || params.href || params.path || id || undefined, {
	                id: id,
	                method: params.method,
	                parser: params.parser || 'twig',
	                base: params.base,
	                module: params.module,
	                precompiled: params.precompiled,
	                async: params.async,
	                options: options

	            }, params.load, params.error);

	        } else if (params.href !== undefined) {
	            return Twig.Templates.loadRemote(params.href, {
	                id: id,
	                method: 'ajax',
	                parser: params.parser || 'twig',
	                base: params.base,
	                module: params.module,
	                precompiled: params.precompiled,
	                async: params.async,
	                options: options

	            }, params.load, params.error);

	        } else if (params.path !== undefined) {
	            return Twig.Templates.loadRemote(params.path, {
	                id: id,
	                method: 'fs',
	                parser: params.parser || 'twig',
	                base: params.base,
	                module: params.module,
	                precompiled: params.precompiled,
	                async: params.async,
	                options: options

	            }, params.load, params.error);
	        }
	    };

	    // Extend Twig with a new filter.
	    Twig.exports.extendFilter = function(filter, definition) {
	        Twig.filter.extend(filter, definition);
	    };

	    // Extend Twig with a new function.
	    Twig.exports.extendFunction = function(fn, definition) {
	        Twig._function.extend(fn, definition);
	    };

	    // Extend Twig with a new test.
	    Twig.exports.extendTest = function(test, definition) {
	        Twig.test.extend(test, definition);
	    };

	    // Extend Twig with a new definition.
	    Twig.exports.extendTag = function(definition) {
	        Twig.logic.extend(definition);
	    };

	    // Provide an environment for extending Twig core.
	    // Calls fn with the internal Twig object.
	    Twig.exports.extend = function(fn) {
	        fn(Twig);
	    };


	    /**
	     * Provide an extension for use with express 2.
	     *
	     * @param {string} markup The template markup.
	     * @param {array} options The express options.
	     *
	     * @return {string} The rendered template.
	     */
	    Twig.exports.compile = function(markup, options) {
	        var id = options.filename,
	            path = options.filename,
	            template;

	        // Try to load the template from the cache
	        template = new Twig.Template({
	            data: markup,
	            path: path,
	            id: id,
	            options: options.settings['twig options']
	        }); // Twig.Templates.load(id) ||

	        return function(context) {
	            return template.render(context);
	        };
	    };

	    /**
	     * Provide an extension for use with express 3.
	     *
	     * @param {string} path The location of the template file on disk.
	     * @param {Object|Function} The options or callback.
	     * @param {Function} fn callback.
	     * 
	     * @throws Twig.Error
	     */
	    Twig.exports.renderFile = function(path, options, fn) {
	        // handle callback in options
	        if (typeof options === 'function') {
	            fn = options;
	            options = {};
	        }

	        options = options || {};

	        var settings = options.settings || {};

	        var params = {
	            path: path,
	            base: settings.views,
	            load: function(template) {
	                // render and return template as a simple string, see https://github.com/twigjs/twig.js/pull/348 for more information
	                fn(null, '' + template.render(options));
	            }
	        };

	        // mixin any options provided to the express app.
	        var view_options = settings['twig options'];

	        if (view_options) {
	            for (var option in view_options) {
	                if (view_options.hasOwnProperty(option)) {
	                    params[option] = view_options[option];
	                }
	            }
	        }

	        Twig.exports.twig(params);
	    };

	    // Express 3 handler
	    Twig.exports.__express = Twig.exports.renderFile;

	    /**
	     * Shoud Twig.js cache templates.
	     * Disable during development to see changes to templates without
	     * reloading, and disable in production to improve performance.
	     *
	     * @param {boolean} cache
	     */
	    Twig.exports.cache = function(cache) {
	        Twig.cache = cache;
	    };

	    //We need to export the path module so we can effectively test it
	    Twig.exports.path = Twig.path;

	    //Export our filters.
	    //Resolves #307
	    Twig.exports.filters = Twig.filters;

	    return Twig;
	};


/***/ }
/******/ ])
});
;
/**
 * Bunch of useful filters for angularJS(with no external dependencies!)
 * @version v0.5.17 - 2017-09-22 * @link https://github.com/a8m/angular-filter
 * @author Ariel Mashraki <ariel@mashraki.co.il>
 * @license MIT License, http://www.opensource.org/licenses/MIT
 */!function(a,b,c){"use strict";function d(a){return E(a)?a:Object.keys(a).map(function(b){return a[b]})}function e(a){return null===a}function f(a,b){var d=Object.keys(a);return d.map(function(d){return b[d]!==c&&b[d]==a[d]}).indexOf(!1)==-1}function g(a,b){function c(a,b,c){for(var d=0;b+d<=a.length;){if(a.charAt(b+d)==c)return d;d++}return-1}for(var d=0,e=0;e<=b.length;e++){var f=c(a,d,b.charAt(e));if(f==-1)return!1;d+=f+1}return!0}function h(a,b,c){var d=0;return a.filter(function(a){var e=y(c)?d<b&&c(a):d<b;return d=e?d+1:d,e})}function i(a,b){return Math.round(a*Math.pow(10,b))/Math.pow(10,b)}function j(a,b,c){b=b||[];var d=Object.keys(a);return d.forEach(function(d){if(D(a[d])&&!E(a[d])){var e=c?c+"."+d:c;j(a[d],b,e||d)}else{var f=c?c+"."+d:d;b.push(f)}}),b}function k(a){return a&&a.$evalAsync&&a.$watch}function l(){return function(a,b){return a>b}}function m(){return function(a,b){return a>=b}}function n(){return function(a,b){return a<b}}function o(){return function(a,b){return a<=b}}function p(){return function(a,b){return a==b}}function q(){return function(a,b){return a!=b}}function r(){return function(a,b){return a===b}}function s(){return function(a,b){return a!==b}}function t(a){return function(b,c){return b=D(b)?d(b):b,!(!E(b)||z(c))&&b.some(function(b){return B(c)&&D(b)||A(c)?a(c)(b):b===c})}}function u(a,b){return b=b||0,b>=a.length?a:E(a[b])?u(a.slice(0,b).concat(a[b],a.slice(b+1)),b):u(a,b+1)}function v(a){return function(b,c){function e(a,b){return!z(b)&&a.some(function(a){return I(a,b)})}if(b=D(b)?d(b):b,!E(b))return b;var f=[],g=a(c);return z(c)?b.filter(function(a,b,c){return c.indexOf(a)===b}):b.filter(function(a){var b=g(a);return!e(f,b)&&(f.push(b),!0)})}}function w(a,b,c){return b?a+c+w(a,--b,c):a}function x(){return function(a){return B(a)?a.split(" ").map(function(a){return a.charAt(0).toUpperCase()+a.substring(1)}).join(" "):a}}var y=b.isDefined,z=b.isUndefined,A=b.isFunction,B=b.isString,C=b.isNumber,D=b.isObject,E=b.isArray,F=b.forEach,G=b.extend,H=b.copy,I=b.equals;String.prototype.contains||(String.prototype.contains=function(){return String.prototype.indexOf.apply(this,arguments)!==-1}),b.module("a8m.angular",[]).filter("isUndefined",function(){return function(a){return b.isUndefined(a)}}).filter("isDefined",function(){return function(a){return b.isDefined(a)}}).filter("isFunction",function(){return function(a){return b.isFunction(a)}}).filter("isString",function(){return function(a){return b.isString(a)}}).filter("isNumber",function(){return function(a){return b.isNumber(a)}}).filter("isArray",function(){return function(a){return b.isArray(a)}}).filter("isObject",function(){return function(a){return b.isObject(a)}}).filter("isEqual",function(){return function(a,c){return b.equals(a,c)}}),b.module("a8m.conditions",[]).filter({isGreaterThan:l,">":l,isGreaterThanOrEqualTo:m,">=":m,isLessThan:n,"<":n,isLessThanOrEqualTo:o,"<=":o,isEqualTo:p,"==":p,isNotEqualTo:q,"!=":q,isIdenticalTo:r,"===":r,isNotIdenticalTo:s,"!==":s}),b.module("a8m.is-null",[]).filter("isNull",function(){return function(a){return e(a)}}),b.module("a8m.after-where",[]).filter("afterWhere",function(){return function(a,b){if(a=D(a)?d(a):a,!E(a)||z(b))return a;var c=a.map(function(a){return f(b,a)}).indexOf(!0);return a.slice(c===-1?0:c)}}),b.module("a8m.after",[]).filter("after",function(){return function(a,b){return a=D(a)?d(a):a,E(a)?a.slice(b):a}}),b.module("a8m.before-where",[]).filter("beforeWhere",function(){return function(a,b){if(a=D(a)?d(a):a,!E(a)||z(b))return a;var c=a.map(function(a){return f(b,a)}).indexOf(!0);return a.slice(0,c===-1?a.length:++c)}}),b.module("a8m.before",[]).filter("before",function(){return function(a,b){return a=D(a)?d(a):a,E(a)?a.slice(0,b?--b:b):a}}),b.module("a8m.chunk-by",["a8m.filter-watcher"]).filter("chunkBy",["filterWatcher",function(a){return function(b,c,d){function e(a,b){for(var c=[];a--;)c[a]=b;return c}function f(a,b,c){return E(a)?a.map(function(a,d,f){return d*=b,a=f.slice(d,d+b),!z(c)&&a.length<b?a.concat(e(b-a.length,c)):a}).slice(0,Math.ceil(a.length/b)):a}return a.isMemoized("chunkBy",arguments)||a.memoize("chunkBy",arguments,this,f(b,c,d))}}]),b.module("a8m.concat",[]).filter("concat",[function(){return function(a,b){if(z(b))return a;if(E(a))return D(b)?a.concat(d(b)):a.concat(b);if(D(a)){var c=d(a);return D(b)?c.concat(d(b)):c.concat(b)}return a}}]),b.module("a8m.contains",[]).filter({contains:["$parse",t],some:["$parse",t]}),b.module("a8m.count-by",[]).filter("countBy",["$parse",function(a){return function(b,c){var e,f={},g=a(c);return b=D(b)?d(b):b,!E(b)||z(c)?b:(b.forEach(function(a){e=g(a),f[e]||(f[e]=0),f[e]++}),f)}}]),b.module("a8m.defaults",[]).filter("defaults",["$parse",function(a){return function(b,c){if(b=D(b)?d(b):b,!E(b)||!D(c))return b;var e=j(c);return b.forEach(function(b){e.forEach(function(d){var e=a(d),f=e.assign;z(e(b))&&f(b,e(c))})}),b}}]),b.module("a8m.every",[]).filter("every",["$parse",function(a){return function(b,c){return b=D(b)?d(b):b,!(E(b)&&!z(c))||b.every(function(b){return D(b)||A(c)?a(c)(b):b===c})}}]),b.module("a8m.filter-by",[]).filter("filterBy",["$parse",function(a){return function(b,e,f,g){var h;return f=B(f)||C(f)?String(f).toLowerCase():c,b=D(b)?d(b):b,!E(b)||z(f)?b:b.filter(function(b){return e.some(function(c){if(~c.indexOf("+")){var d=c.replace(/\s+/g,"").split("+");h=d.map(function(c){return a(c)(b)}).join(" ")}else h=a(c)(b);return!(!B(h)&&!C(h))&&(h=String(h).toLowerCase(),g?h===f:h.contains(f))})})}}]),b.module("a8m.first",[]).filter("first",["$parse",function(a){return function(b){var e,f,g;return b=D(b)?d(b):b,E(b)?(g=Array.prototype.slice.call(arguments,1),e=C(g[0])?g[0]:1,f=C(g[0])?C(g[1])?c:g[1]:g[0],g.length?h(b,e,f?a(f):f):b[0]):b}}]),b.module("a8m.flatten",[]).filter("flatten",function(){return function(a,b){return b=b||!1,a=D(a)?d(a):a,E(a)?b?[].concat.apply([],a):u(a,0):a}}),b.module("a8m.fuzzy-by",[]).filter("fuzzyBy",["$parse",function(a){return function(b,c,e,f){var h,i,j=f||!1;return b=D(b)?d(b):b,!E(b)||z(c)||z(e)?b:(i=a(c),b.filter(function(a){return h=i(a),!!B(h)&&(h=j?h:h.toLowerCase(),e=j?e:e.toLowerCase(),g(h,e)!==!1)}))}}]),b.module("a8m.fuzzy",[]).filter("fuzzy",function(){return function(a,b,c){function e(a,b){var c,d,e=Object.keys(a);return 0<e.filter(function(e){return c=a[e],!!d||!!B(c)&&(c=f?c:c.toLowerCase(),d=g(c,b)!==!1)}).length}var f=c||!1;return a=D(a)?d(a):a,!E(a)||z(b)?a:(b=f?b:b.toLowerCase(),a.filter(function(a){return B(a)?(a=f?a:a.toLowerCase(),g(a,b)!==!1):!!D(a)&&e(a,b)}))}}),b.module("a8m.group-by",["a8m.filter-watcher"]).filter("groupBy",["$parse","filterWatcher",function(a,b){return function(c,d){function e(a,b){var c,d={};return F(a,function(a){c=b(a),d[c]||(d[c]=[]),d[c].push(a)}),d}return!D(c)||z(d)?c:b.isMemoized("groupBy",arguments)||b.memoize("groupBy",arguments,this,e(c,a(d)))}}]),b.module("a8m.is-empty",[]).filter("isEmpty",function(){return function(a){return D(a)?!d(a).length:!a.length}}),b.module("a8m.join",[]).filter("join",function(){return function(a,b){return z(a)||!E(a)?a:(z(b)&&(b=" "),a.join(b))}}),b.module("a8m.last",[]).filter("last",["$parse",function(a){return function(b){var e,f,g,i=H(b);return i=D(i)?d(i):i,E(i)?(g=Array.prototype.slice.call(arguments,1),e=C(g[0])?g[0]:1,f=C(g[0])?C(g[1])?c:g[1]:g[0],g.length?h(i.reverse(),e,f?a(f):f).reverse():i[i.length-1]):i}}]),b.module("a8m.map",[]).filter("map",["$parse",function(a){return function(b,c){return b=D(b)?d(b):b,!E(b)||z(c)?b:b.map(function(b){return a(c)(b)})}}]),b.module("a8m.omit",[]).filter("omit",["$parse",function(a){return function(b,c){return b=D(b)?d(b):b,!E(b)||z(c)?b:b.filter(function(b){return!a(c)(b)})}}]),b.module("a8m.pick",[]).filter("pick",["$parse",function(a){return function(b,c){return b=D(b)?d(b):b,!E(b)||z(c)?b:b.filter(function(b){return a(c)(b)})}}]),b.module("a8m.range",[]).filter("range",function(){return function(a,b,c,d,e){c=c||0,d=d||1;for(var f=0;f<parseInt(b);f++){var g=c+f*d;a.push(A(e)?e(g):g)}return a}}),b.module("a8m.remove-with",[]).filter("removeWith",function(){return function(a,b){return z(b)?a:(a=D(a)?d(a):a,a.filter(function(a){return!f(b,a)}))}}),b.module("a8m.remove",[]).filter("remove",function(){return function(a){a=D(a)?d(a):a;var b=Array.prototype.slice.call(arguments,1);return E(a)?a.filter(function(a){return!b.some(function(b){return I(b,a)})}):a}}),b.module("a8m.reverse",[]).filter("reverse",[function(){return function(a){return a=D(a)?d(a):a,B(a)?a.split("").reverse().join(""):E(a)?a.slice().reverse():a}}]),b.module("a8m.search-field",[]).filter("searchField",["$parse",function(a){return function(b){var c,e;b=D(b)?d(b):b;var f=Array.prototype.slice.call(arguments,1);return E(b)&&f.length?b.map(function(b){return e=f.map(function(d){return(c=a(d))(b)}).join(" "),G(b,{searchField:e})}):b}}]),b.module("a8m.to-array",[]).filter("toArray",function(){return function(a,b){return D(a)?b?Object.keys(a).map(function(b){return G(a[b],{$key:b})}):d(a):a}}),b.module("a8m.unique",[]).filter({unique:["$parse",v],uniq:["$parse",v]}),b.module("a8m.where",[]).filter("where",function(){return function(a,b){return z(b)?a:(a=D(a)?d(a):a,a.filter(function(a){return f(b,a)}))}}),b.module("a8m.xor",[]).filter("xor",["$parse",function(a){return function(b,c,e){function f(b,c){var d=a(e);return c.some(function(a){return e?I(d(a),d(b)):I(a,b)})}return e=e||!1,b=D(b)?d(b):b,c=D(c)?d(c):c,E(b)&&E(c)?b.concat(c).filter(function(a){return!(f(a,b)&&f(a,c))}):b}}]),b.module("a8m.math.abs",[]).filter("abs",function(){return function(a){return Math.abs(a)}}),b.module("a8m.math.byteFmt",[]).filter("byteFmt",function(){var a=[{str:"B",val:1024}];return["KB","MB","GB","TB","PB","EB","ZB","YB"].forEach(function(b,c){a.push({str:b,val:1024*a[c].val})}),function(b,c){if(C(c)&&isFinite(c)&&c%1===0&&c>=0&&C(b)&&isFinite(b)){for(var d=0;d<a.length-1&&b>=a[d].val;)d++;return b/=d>0?a[d-1].val:1,i(b,c)+" "+a[d].str}return"NaN"}}),b.module("a8m.math.degrees",[]).filter("degrees",function(){return function(a,b){if(C(b)&&isFinite(b)&&b%1===0&&b>=0&&C(a)&&isFinite(a)){var c=180*a/Math.PI;return Math.round(c*Math.pow(10,b))/Math.pow(10,b)}return"NaN"}}),b.module("a8m.math.kbFmt",[]).filter("kbFmt",function(){var a=[{str:"KB",val:1024}];return["MB","GB","TB","PB","EB","ZB","YB"].forEach(function(b,c){a.push({str:b,val:1024*a[c].val})}),function(b,c){if(C(c)&&isFinite(c)&&c%1===0&&c>=0&&C(b)&&isFinite(b)){for(var d=0;d<a.length-1&&b>=a[d].val;)d++;return b/=d>0?a[d-1].val:1,i(b,c)+" "+a[d].str}return"NaN"}}),b.module("a8m.math.max",[]).filter("max",["$parse",function(a){function b(b,c){var d=b.map(function(b){return a(c)(b)});return d.indexOf(Math.max.apply(Math,d))}return function(a,c){return E(a)?z(c)?Math.max.apply(Math,a):a[b(a,c)]:a}}]),b.module("a8m.math.min",[]).filter("min",["$parse",function(a){function b(b,c){var d=b.map(function(b){return a(c)(b)});return d.indexOf(Math.min.apply(Math,d))}return function(a,c){return E(a)?z(c)?Math.min.apply(Math,a):a[b(a,c)]:a}}]),b.module("a8m.math.percent",[]).filter("percent",function(){return function(a,b,c){var d=B(a)?Number(a):a;return b=b||100,c=c||!1,!C(d)||isNaN(d)?a:c?Math.round(d/b*100):d/b*100}}),b.module("a8m.math.radians",[]).filter("radians",function(){return function(a,b){if(C(b)&&isFinite(b)&&b%1===0&&b>=0&&C(a)&&isFinite(a)){var c=3.14159265359*a/180;return Math.round(c*Math.pow(10,b))/Math.pow(10,b)}return"NaN"}}),b.module("a8m.math.radix",[]).filter("radix",function(){return function(a,b){var c=/^[2-9]$|^[1-2]\d$|^3[0-6]$/;return C(a)&&c.test(b)?a.toString(b).toUpperCase():a}}),b.module("a8m.math.shortFmt",[]).filter("shortFmt",function(){return function(a,b){return C(b)&&isFinite(b)&&b%1===0&&b>=0&&C(a)&&isFinite(a)?a<1e3?""+a:a<1e6?i(a/1e3,b)+" K":a<1e9?i(a/1e6,b)+" M":i(a/1e9,b)+" B":"NaN"}}),b.module("a8m.math.sum",[]).filter("sum",function(){return function(a,b){return E(a)?a.reduce(function(a,b){return a+b},b||0):a}}),b.module("a8m.ends-with",[]).filter("endsWith",function(){return function(a,b,c){var d,e=c||!1;return!B(a)||z(b)?a:(a=e?a:a.toLowerCase(),d=a.length-b.length,a.indexOf(e?b:b.toLowerCase(),d)!==-1)}}),b.module("a8m.latinize",[]).filter("latinize",[function(){function a(a){return a.replace(/[^\u0000-\u007E]/g,function(a){return c[a]||a})}for(var b=[{base:"A",letters:"AⒶＡÀÁÂẦẤẪẨÃĀĂẰẮẴẲȦǠÄǞẢÅǺǍȀȂẠẬẶḀĄȺⱯ"},{base:"AA",letters:"Ꜳ"},{base:"AE",letters:"ÆǼǢ"},{base:"AO",letters:"Ꜵ"},{base:"AU",letters:"Ꜷ"},{base:"AV",letters:"ꜸꜺ"},{base:"AY",letters:"Ꜽ"},{base:"B",letters:"BⒷＢḂḄḆɃƂƁ"},{base:"C",letters:"CⒸＣĆĈĊČÇḈƇȻꜾ"},{base:"D",letters:"DⒹＤḊĎḌḐḒḎĐƋƊƉꝹ"},{base:"DZ",letters:"ǱǄ"},{base:"Dz",letters:"ǲǅ"},{base:"E",letters:"EⒺＥÈÉÊỀẾỄỂẼĒḔḖĔĖËẺĚȄȆẸỆȨḜĘḘḚƐƎ"},{base:"F",letters:"FⒻＦḞƑꝻ"},{base:"G",letters:"GⒼＧǴĜḠĞĠǦĢǤƓꞠꝽꝾ"},{base:"H",letters:"HⒽＨĤḢḦȞḤḨḪĦⱧⱵꞍ"},{base:"I",letters:"IⒾＩÌÍÎĨĪĬİÏḮỈǏȈȊỊĮḬƗ"},{base:"J",letters:"JⒿＪĴɈ"},{base:"K",letters:"KⓀＫḰǨḲĶḴƘⱩꝀꝂꝄꞢ"},{base:"L",letters:"LⓁＬĿĹĽḶḸĻḼḺŁȽⱢⱠꝈꝆꞀ"},{base:"LJ",letters:"Ǉ"},{base:"Lj",letters:"ǈ"},{base:"M",letters:"MⓂＭḾṀṂⱮƜ"},{base:"N",letters:"NⓃＮǸŃÑṄŇṆŅṊṈȠƝꞐꞤ"},{base:"NJ",letters:"Ǌ"},{base:"Nj",letters:"ǋ"},{base:"O",letters:"OⓄＯÒÓÔỒỐỖỔÕṌȬṎŌṐṒŎȮȰÖȪỎŐǑȌȎƠỜỚỠỞỢỌỘǪǬØǾƆƟꝊꝌ"},{base:"OI",letters:"Ƣ"},{base:"OO",letters:"Ꝏ"},{base:"OU",letters:"Ȣ"},{base:"OE",letters:"Œ"},{base:"oe",letters:"œ"},{base:"P",letters:"PⓅＰṔṖƤⱣꝐꝒꝔ"},{base:"Q",letters:"QⓆＱꝖꝘɊ"},{base:"R",letters:"RⓇＲŔṘŘȐȒṚṜŖṞɌⱤꝚꞦꞂ"},{base:"S",letters:"SⓈＳẞŚṤŜṠŠṦṢṨȘŞⱾꞨꞄ"},{base:"T",letters:"TⓉＴṪŤṬȚŢṰṮŦƬƮȾꞆ"},{base:"TZ",letters:"Ꜩ"},{base:"U",letters:"UⓊＵÙÚÛŨṸŪṺŬÜǛǗǕǙỦŮŰǓȔȖƯỪỨỮỬỰỤṲŲṶṴɄ"},{base:"V",letters:"VⓋＶṼṾƲꝞɅ"},{base:"VY",letters:"Ꝡ"},{base:"W",letters:"WⓌＷẀẂŴẆẄẈⱲ"},{base:"X",letters:"XⓍＸẊẌ"},{base:"Y",letters:"YⓎＹỲÝŶỸȲẎŸỶỴƳɎỾ"},{base:"Z",letters:"ZⓏＺŹẐŻŽẒẔƵȤⱿⱫꝢ"},{base:"a",letters:"aⓐａẚàáâầấẫẩãāăằắẵẳȧǡäǟảåǻǎȁȃạậặḁąⱥɐ"},{base:"aa",letters:"ꜳ"},{base:"ae",letters:"æǽǣ"},{base:"ao",letters:"ꜵ"},{base:"au",letters:"ꜷ"},{base:"av",letters:"ꜹꜻ"},{base:"ay",letters:"ꜽ"},{base:"b",letters:"bⓑｂḃḅḇƀƃɓ"},{base:"c",letters:"cⓒｃćĉċčçḉƈȼꜿↄ"},{base:"d",letters:"dⓓｄḋďḍḑḓḏđƌɖɗꝺ"},{base:"dz",letters:"ǳǆ"},{base:"e",letters:"eⓔｅèéêềếễểẽēḕḗĕėëẻěȅȇẹệȩḝęḙḛɇɛǝ"},{base:"f",letters:"fⓕｆḟƒꝼ"},{base:"g",letters:"gⓖｇǵĝḡğġǧģǥɠꞡᵹꝿ"},{base:"h",letters:"hⓗｈĥḣḧȟḥḩḫẖħⱨⱶɥ"},{base:"hv",letters:"ƕ"},{base:"i",letters:"iⓘｉìíîĩīĭïḯỉǐȉȋịįḭɨı"},{base:"j",letters:"jⓙｊĵǰɉ"},{base:"k",letters:"kⓚｋḱǩḳķḵƙⱪꝁꝃꝅꞣ"},{base:"l",letters:"lⓛｌŀĺľḷḹļḽḻſłƚɫⱡꝉꞁꝇ"},{base:"lj",letters:"ǉ"},{base:"m",letters:"mⓜｍḿṁṃɱɯ"},{base:"n",letters:"nⓝｎǹńñṅňṇņṋṉƞɲŉꞑꞥ"},{base:"nj",letters:"ǌ"},{base:"o",letters:"oⓞｏòóôồốỗổõṍȭṏōṑṓŏȯȱöȫỏőǒȍȏơờớỡởợọộǫǭøǿɔꝋꝍɵ"},{base:"oi",letters:"ƣ"},{base:"ou",letters:"ȣ"},{base:"oo",letters:"ꝏ"},{base:"p",letters:"pⓟｐṕṗƥᵽꝑꝓꝕ"},{base:"q",letters:"qⓠｑɋꝗꝙ"},{base:"r",letters:"rⓡｒŕṙřȑȓṛṝŗṟɍɽꝛꞧꞃ"},{base:"s",letters:"sⓢｓßśṥŝṡšṧṣṩșşȿꞩꞅẛ"},{base:"t",letters:"tⓣｔṫẗťṭțţṱṯŧƭʈⱦꞇ"},{base:"tz",letters:"ꜩ"},{base:"u",letters:"uⓤｕùúûũṹūṻŭüǜǘǖǚủůűǔȕȗưừứữửựụṳųṷṵʉ"},{base:"v",letters:"vⓥｖṽṿʋꝟʌ"},{base:"vy",letters:"ꝡ"},{base:"w",letters:"wⓦｗẁẃŵẇẅẘẉⱳ"},{base:"x",letters:"xⓧｘẋẍ"},{base:"y",letters:"yⓨｙỳýŷỹȳẏÿỷẙỵƴɏỿ"},{base:"z",letters:"zⓩｚźẑżžẓẕƶȥɀⱬꝣ"}],c={},d=0;d<b.length;d++)for(var e=b[d].letters.split(""),f=0;f<e.length;f++)c[e[f]]=b[d].base;return function(b){return B(b)?a(b):b}}]),b.module("a8m.ltrim",[]).filter("ltrim",function(){return function(a,b){var c=b||"\\s";return B(a)?a.replace(new RegExp("^"+c+"+"),""):a}}),b.module("a8m.match",[]).filter("match",function(){return function(a,b,c){var d=new RegExp(b,c);return B(a)?a.match(d):null}}),b.module("a8m.phoneUS",[]).filter("phoneUS",function(){return function(a){return a+="","("+a.slice(0,3)+") "+a.slice(3,6)+"-"+a.slice(6)}}),b.module("a8m.repeat",[]).filter("repeat",[function(){return function(a,b,c){var d=~~b;return B(a)&&d?w(a,--b,c||""):a}}]),b.module("a8m.rtrim",[]).filter("rtrim",function(){return function(a,b){var c=b||"\\s";return B(a)?a.replace(new RegExp(c+"+$"),""):a}}),b.module("a8m.slugify",[]).filter("slugify",[function(){return function(a,b){var c=z(b)?"-":b;return B(a)?a.toLowerCase().replace(/\s+/g,c):a}}]),b.module("a8m.split",[]).filter("split",function(){function a(a){return a.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g,"\\$&")}return function(b,c,d){var f,g,h,i;return z(b)||!B(b)?null:(z(c)&&(c=""),isNaN(d)&&(d=0),f=new RegExp(a(c),"g"),g=b.match(f),e(g)||d>=g.length?[b]:0===d?b.split(c):(h=b.split(c),i=h.splice(0,d+1),h.unshift(i.join(c)),h))}}),b.module("a8m.starts-with",[]).filter("startsWith",function(){return function(a,b,c){var d=c||!1;return!B(a)||z(b)?a:(a=d?a:a.toLowerCase(),!a.indexOf(d?b:b.toLowerCase()))}}),b.module("a8m.stringular",[]).filter("stringular",function(){return function(a){var b=Array.prototype.slice.call(arguments,1);return a.replace(/{(\d+)}/g,function(a,c){return z(b[c])?a:b[c]})}}),b.module("a8m.strip-tags",[]).filter("stripTags",function(){return function(a){return B(a)?a.replace(/<\S[^><]*>/g,""):a}}),b.module("a8m.test",[]).filter("test",function(){return function(a,b,c){var d=new RegExp(b,c);return B(a)?d.test(a):a}}),b.module("a8m.trim",[]).filter("trim",function(){return function(a,b){var c=b||"\\s";return B(a)?a.replace(new RegExp("^"+c+"+|"+c+"+$","g"),""):a}}),b.module("a8m.truncate",[]).filter("truncate",function(){return function(a,b,c,d){return b=z(b)?a.length:b,d=d||!1,c=c||"",!B(a)||a.length<=b?a:a.substring(0,d?a.indexOf(" ",b)===-1?a.length:a.indexOf(" ",b):b)+c}}),b.module("a8m.ucfirst",[]).filter({ucfirst:x,titleize:x}),b.module("a8m.uri-component-encode",[]).filter("uriComponentEncode",["$window",function(a){return function(b){return B(b)?a.encodeURIComponent(b):b}}]),b.module("a8m.uri-encode",[]).filter("uriEncode",["$window",function(a){return function(b){return B(b)?a.encodeURI(b):b}}]),b.module("a8m.wrap",[]).filter("wrap",function(){return function(a,b,c){return B(a)&&y(b)?[b,a,c||b].join(""):a}}),b.module("a8m.filter-watcher",[]).provider("filterWatcher",function(){this.$get=["$window","$rootScope",function(a,b){function c(b,c){function d(){var b=[];return function(c,d){if(D(d)&&!e(d)){if(~b.indexOf(d))return"[Circular]";b.push(d)}return a==d?"$WINDOW":a.document==d?"$DOCUMENT":k(d)?"$SCOPE":d}}return[b,JSON.stringify(c,d())].join("#").replace(/"/g,"")}function d(a){var b=a.targetScope.$id;F(l[b],function(a){delete j[a]}),delete l[b]}function f(){m(function(){b.$$phase||(j={})},2e3)}function g(a,b){var c=a.$id;return z(l[c])&&(a.$on("$destroy",d),l[c]=[]),l[c].push(b)}function h(a,b){var d=c(a,b);return j[d]}function i(a,b,d,e){var h=c(a,b);return j[h]=e,k(d)?g(d,h):f(),e}var j={},l={},m=a.setTimeout;return{isMemoized:h,memoize:i}}]}),b.module("angular.filter",["a8m.ucfirst","a8m.uri-encode","a8m.uri-component-encode","a8m.slugify","a8m.latinize","a8m.strip-tags","a8m.stringular","a8m.truncate","a8m.starts-with","a8m.ends-with","a8m.wrap","a8m.trim","a8m.ltrim","a8m.rtrim","a8m.repeat","a8m.test","a8m.match","a8m.split","a8m.phoneUS","a8m.to-array","a8m.concat","a8m.contains","a8m.unique","a8m.is-empty","a8m.after","a8m.after-where","a8m.before","a8m.before-where","a8m.defaults","a8m.where","a8m.reverse","a8m.remove","a8m.remove-with","a8m.group-by","a8m.count-by","a8m.chunk-by","a8m.search-field","a8m.fuzzy-by","a8m.fuzzy","a8m.omit","a8m.pick","a8m.every","a8m.filter-by","a8m.xor","a8m.map","a8m.first","a8m.last","a8m.flatten","a8m.join","a8m.range","a8m.math.max","a8m.math.min","a8m.math.abs","a8m.math.percent","a8m.math.radix","a8m.math.sum","a8m.math.degrees","a8m.math.radians","a8m.math.byteFmt","a8m.math.kbFmt","a8m.math.shortFmt","a8m.angular","a8m.conditions","a8m.is-null","a8m.filter-watcher"])}(window,window.angular);
// ┌────────────────────────────────────────────────────────────────────┐ \\
// │ Raphaël 2.1.1 - JavaScript Vector Library                          │ \\
// ├────────────────────────────────────────────────────────────────────┤ \\
// │ Copyright © 2008-2012 Dmitry Baranovskiy (http://raphaeljs.com)    │ \\
// │ Copyright © 2008-2012 Sencha Labs (http://sencha.com)              │ \\
// ├────────────────────────────────────────────────────────────────────┤ \\
// │ Licensed under the MIT (http://raphaeljs.com/license.html) license.│ \\
// └────────────────────────────────────────────────────────────────────┘ \\
!function(a){var b,c,d="0.4.2",e="hasOwnProperty",f=/[\.\/]/,g="*",h=function(){},i=function(a,b){return a-b},j={n:{}},k=function(a,d){a=String(a);var e,f=c,g=Array.prototype.slice.call(arguments,2),h=k.listeners(a),j=0,l=[],m={},n=[],o=b;b=a,c=0;for(var p=0,q=h.length;q>p;p++)"zIndex"in h[p]&&(l.push(h[p].zIndex),h[p].zIndex<0&&(m[h[p].zIndex]=h[p]));for(l.sort(i);l[j]<0;)if(e=m[l[j++]],n.push(e.apply(d,g)),c)return c=f,n;for(p=0;q>p;p++)if(e=h[p],"zIndex"in e)if(e.zIndex==l[j]){if(n.push(e.apply(d,g)),c)break;do if(j++,e=m[l[j]],e&&n.push(e.apply(d,g)),c)break;while(e)}else m[e.zIndex]=e;else if(n.push(e.apply(d,g)),c)break;return c=f,b=o,n.length?n:null};k._events=j,k.listeners=function(a){var b,c,d,e,h,i,k,l,m=a.split(f),n=j,o=[n],p=[];for(e=0,h=m.length;h>e;e++){for(l=[],i=0,k=o.length;k>i;i++)for(n=o[i].n,c=[n[m[e]],n[g]],d=2;d--;)b=c[d],b&&(l.push(b),p=p.concat(b.f||[]));o=l}return p},k.on=function(a,b){if(a=String(a),"function"!=typeof b)return function(){};for(var c=a.split(f),d=j,e=0,g=c.length;g>e;e++)d=d.n,d=d.hasOwnProperty(c[e])&&d[c[e]]||(d[c[e]]={n:{}});for(d.f=d.f||[],e=0,g=d.f.length;g>e;e++)if(d.f[e]==b)return h;return d.f.push(b),function(a){+a==+a&&(b.zIndex=+a)}},k.f=function(a){var b=[].slice.call(arguments,1);return function(){k.apply(null,[a,null].concat(b).concat([].slice.call(arguments,0)))}},k.stop=function(){c=1},k.nt=function(a){return a?new RegExp("(?:\\.|\\/|^)"+a+"(?:\\.|\\/|$)").test(b):b},k.nts=function(){return b.split(f)},k.off=k.unbind=function(a,b){if(!a)return k._events=j={n:{}},void 0;var c,d,h,i,l,m,n,o=a.split(f),p=[j];for(i=0,l=o.length;l>i;i++)for(m=0;m<p.length;m+=h.length-2){if(h=[m,1],c=p[m].n,o[i]!=g)c[o[i]]&&h.push(c[o[i]]);else for(d in c)c[e](d)&&h.push(c[d]);p.splice.apply(p,h)}for(i=0,l=p.length;l>i;i++)for(c=p[i];c.n;){if(b){if(c.f){for(m=0,n=c.f.length;n>m;m++)if(c.f[m]==b){c.f.splice(m,1);break}!c.f.length&&delete c.f}for(d in c.n)if(c.n[e](d)&&c.n[d].f){var q=c.n[d].f;for(m=0,n=q.length;n>m;m++)if(q[m]==b){q.splice(m,1);break}!q.length&&delete c.n[d].f}}else{delete c.f;for(d in c.n)c.n[e](d)&&c.n[d].f&&delete c.n[d].f}c=c.n}},k.once=function(a,b){var c=function(){return k.unbind(a,c),b.apply(this,arguments)};return k.on(a,c)},k.version=d,k.toString=function(){return"You are running Eve "+d},"undefined"!=typeof module&&module.exports?module.exports=k:"undefined"!=typeof define?define("eve",[],function(){return k}):a.eve=k}(this),function(a,b){"function"==typeof define&&define.amd?define(["eve"],function(c){return b(a,c)}):b(a,a.eve)}(this,function(a,b){function c(a){if(c.is(a,"function"))return u?a():b.on("raphael.DOMload",a);if(c.is(a,V))return c._engine.create[D](c,a.splice(0,3+c.is(a[0],T))).add(a);var d=Array.prototype.slice.call(arguments,0);if(c.is(d[d.length-1],"function")){var e=d.pop();return u?e.call(c._engine.create[D](c,d)):b.on("raphael.DOMload",function(){e.call(c._engine.create[D](c,d))})}return c._engine.create[D](c,arguments)}function d(a){if("function"==typeof a||Object(a)!==a)return a;var b=new a.constructor;for(var c in a)a[z](c)&&(b[c]=d(a[c]));return b}function e(a,b){for(var c=0,d=a.length;d>c;c++)if(a[c]===b)return a.push(a.splice(c,1)[0])}function f(a,b,c){function d(){var f=Array.prototype.slice.call(arguments,0),g=f.join("␀"),h=d.cache=d.cache||{},i=d.count=d.count||[];return h[z](g)?(e(i,g),c?c(h[g]):h[g]):(i.length>=1e3&&delete h[i.shift()],i.push(g),h[g]=a[D](b,f),c?c(h[g]):h[g])}return d}function g(){return this.hex}function h(a,b){for(var c=[],d=0,e=a.length;e-2*!b>d;d+=2){var f=[{x:+a[d-2],y:+a[d-1]},{x:+a[d],y:+a[d+1]},{x:+a[d+2],y:+a[d+3]},{x:+a[d+4],y:+a[d+5]}];b?d?e-4==d?f[3]={x:+a[0],y:+a[1]}:e-2==d&&(f[2]={x:+a[0],y:+a[1]},f[3]={x:+a[2],y:+a[3]}):f[0]={x:+a[e-2],y:+a[e-1]}:e-4==d?f[3]=f[2]:d||(f[0]={x:+a[d],y:+a[d+1]}),c.push(["C",(-f[0].x+6*f[1].x+f[2].x)/6,(-f[0].y+6*f[1].y+f[2].y)/6,(f[1].x+6*f[2].x-f[3].x)/6,(f[1].y+6*f[2].y-f[3].y)/6,f[2].x,f[2].y])}return c}function i(a,b,c,d,e){var f=-3*b+9*c-9*d+3*e,g=a*f+6*b-12*c+6*d;return a*g-3*b+3*c}function j(a,b,c,d,e,f,g,h,j){null==j&&(j=1),j=j>1?1:0>j?0:j;for(var k=j/2,l=12,m=[-.1252,.1252,-.3678,.3678,-.5873,.5873,-.7699,.7699,-.9041,.9041,-.9816,.9816],n=[.2491,.2491,.2335,.2335,.2032,.2032,.1601,.1601,.1069,.1069,.0472,.0472],o=0,p=0;l>p;p++){var q=k*m[p]+k,r=i(q,a,c,e,g),s=i(q,b,d,f,h),t=r*r+s*s;o+=n[p]*N.sqrt(t)}return k*o}function k(a,b,c,d,e,f,g,h,i){if(!(0>i||j(a,b,c,d,e,f,g,h)<i)){var k,l=1,m=l/2,n=l-m,o=.01;for(k=j(a,b,c,d,e,f,g,h,n);Q(k-i)>o;)m/=2,n+=(i>k?1:-1)*m,k=j(a,b,c,d,e,f,g,h,n);return n}}function l(a,b,c,d,e,f,g,h){if(!(O(a,c)<P(e,g)||P(a,c)>O(e,g)||O(b,d)<P(f,h)||P(b,d)>O(f,h))){var i=(a*d-b*c)*(e-g)-(a-c)*(e*h-f*g),j=(a*d-b*c)*(f-h)-(b-d)*(e*h-f*g),k=(a-c)*(f-h)-(b-d)*(e-g);if(k){var l=i/k,m=j/k,n=+l.toFixed(2),o=+m.toFixed(2);if(!(n<+P(a,c).toFixed(2)||n>+O(a,c).toFixed(2)||n<+P(e,g).toFixed(2)||n>+O(e,g).toFixed(2)||o<+P(b,d).toFixed(2)||o>+O(b,d).toFixed(2)||o<+P(f,h).toFixed(2)||o>+O(f,h).toFixed(2)))return{x:l,y:m}}}}function m(a,b,d){var e=c.bezierBBox(a),f=c.bezierBBox(b);if(!c.isBBoxIntersect(e,f))return d?0:[];for(var g=j.apply(0,a),h=j.apply(0,b),i=O(~~(g/5),1),k=O(~~(h/5),1),m=[],n=[],o={},p=d?0:[],q=0;i+1>q;q++){var r=c.findDotsAtSegment.apply(c,a.concat(q/i));m.push({x:r.x,y:r.y,t:q/i})}for(q=0;k+1>q;q++)r=c.findDotsAtSegment.apply(c,b.concat(q/k)),n.push({x:r.x,y:r.y,t:q/k});for(q=0;i>q;q++)for(var s=0;k>s;s++){var t=m[q],u=m[q+1],v=n[s],w=n[s+1],x=Q(u.x-t.x)<.001?"y":"x",y=Q(w.x-v.x)<.001?"y":"x",z=l(t.x,t.y,u.x,u.y,v.x,v.y,w.x,w.y);if(z){if(o[z.x.toFixed(4)]==z.y.toFixed(4))continue;o[z.x.toFixed(4)]=z.y.toFixed(4);var A=t.t+Q((z[x]-t[x])/(u[x]-t[x]))*(u.t-t.t),B=v.t+Q((z[y]-v[y])/(w[y]-v[y]))*(w.t-v.t);A>=0&&1.001>=A&&B>=0&&1.001>=B&&(d?p++:p.push({x:z.x,y:z.y,t1:P(A,1),t2:P(B,1)}))}}return p}function n(a,b,d){a=c._path2curve(a),b=c._path2curve(b);for(var e,f,g,h,i,j,k,l,n,o,p=d?0:[],q=0,r=a.length;r>q;q++){var s=a[q];if("M"==s[0])e=i=s[1],f=j=s[2];else{"C"==s[0]?(n=[e,f].concat(s.slice(1)),e=n[6],f=n[7]):(n=[e,f,e,f,i,j,i,j],e=i,f=j);for(var t=0,u=b.length;u>t;t++){var v=b[t];if("M"==v[0])g=k=v[1],h=l=v[2];else{"C"==v[0]?(o=[g,h].concat(v.slice(1)),g=o[6],h=o[7]):(o=[g,h,g,h,k,l,k,l],g=k,h=l);var w=m(n,o,d);if(d)p+=w;else{for(var x=0,y=w.length;y>x;x++)w[x].segment1=q,w[x].segment2=t,w[x].bez1=n,w[x].bez2=o;p=p.concat(w)}}}}}return p}function o(a,b,c,d,e,f){null!=a?(this.a=+a,this.b=+b,this.c=+c,this.d=+d,this.e=+e,this.f=+f):(this.a=1,this.b=0,this.c=0,this.d=1,this.e=0,this.f=0)}function p(){return this.x+H+this.y+H+this.width+" × "+this.height}function q(a,b,c,d,e,f){function g(a){return((l*a+k)*a+j)*a}function h(a,b){var c=i(a,b);return((o*c+n)*c+m)*c}function i(a,b){var c,d,e,f,h,i;for(e=a,i=0;8>i;i++){if(f=g(e)-a,Q(f)<b)return e;if(h=(3*l*e+2*k)*e+j,Q(h)<1e-6)break;e-=f/h}if(c=0,d=1,e=a,c>e)return c;if(e>d)return d;for(;d>c;){if(f=g(e),Q(f-a)<b)return e;a>f?c=e:d=e,e=(d-c)/2+c}return e}var j=3*b,k=3*(d-b)-j,l=1-j-k,m=3*c,n=3*(e-c)-m,o=1-m-n;return h(a,1/(200*f))}function r(a,b){var c=[],d={};if(this.ms=b,this.times=1,a){for(var e in a)a[z](e)&&(d[_(e)]=a[e],c.push(_(e)));c.sort(lb)}this.anim=d,this.top=c[c.length-1],this.percents=c}function s(a,d,e,f,g,h){e=_(e);var i,j,k,l,m,n,p=a.ms,r={},s={},t={};if(f)for(v=0,x=ic.length;x>v;v++){var u=ic[v];if(u.el.id==d.id&&u.anim==a){u.percent!=e?(ic.splice(v,1),k=1):j=u,d.attr(u.totalOrigin);break}}else f=+s;for(var v=0,x=a.percents.length;x>v;v++){if(a.percents[v]==e||a.percents[v]>f*a.top){e=a.percents[v],m=a.percents[v-1]||0,p=p/a.top*(e-m),l=a.percents[v+1],i=a.anim[e];break}f&&d.attr(a.anim[a.percents[v]])}if(i){if(j)j.initstatus=f,j.start=new Date-j.ms*f;else{for(var y in i)if(i[z](y)&&(db[z](y)||d.paper.customAttributes[z](y)))switch(r[y]=d.attr(y),null==r[y]&&(r[y]=cb[y]),s[y]=i[y],db[y]){case T:t[y]=(s[y]-r[y])/p;break;case"colour":r[y]=c.getRGB(r[y]);var A=c.getRGB(s[y]);t[y]={r:(A.r-r[y].r)/p,g:(A.g-r[y].g)/p,b:(A.b-r[y].b)/p};break;case"path":var B=Kb(r[y],s[y]),C=B[1];for(r[y]=B[0],t[y]=[],v=0,x=r[y].length;x>v;v++){t[y][v]=[0];for(var D=1,F=r[y][v].length;F>D;D++)t[y][v][D]=(C[v][D]-r[y][v][D])/p}break;case"transform":var G=d._,H=Pb(G[y],s[y]);if(H)for(r[y]=H.from,s[y]=H.to,t[y]=[],t[y].real=!0,v=0,x=r[y].length;x>v;v++)for(t[y][v]=[r[y][v][0]],D=1,F=r[y][v].length;F>D;D++)t[y][v][D]=(s[y][v][D]-r[y][v][D])/p;else{var K=d.matrix||new o,L={_:{transform:G.transform},getBBox:function(){return d.getBBox(1)}};r[y]=[K.a,K.b,K.c,K.d,K.e,K.f],Nb(L,s[y]),s[y]=L._.transform,t[y]=[(L.matrix.a-K.a)/p,(L.matrix.b-K.b)/p,(L.matrix.c-K.c)/p,(L.matrix.d-K.d)/p,(L.matrix.e-K.e)/p,(L.matrix.f-K.f)/p]}break;case"csv":var M=I(i[y])[J](w),N=I(r[y])[J](w);if("clip-rect"==y)for(r[y]=N,t[y]=[],v=N.length;v--;)t[y][v]=(M[v]-r[y][v])/p;s[y]=M;break;default:for(M=[][E](i[y]),N=[][E](r[y]),t[y]=[],v=d.paper.customAttributes[y].length;v--;)t[y][v]=((M[v]||0)-(N[v]||0))/p}var O=i.easing,P=c.easing_formulas[O];if(!P)if(P=I(O).match(Z),P&&5==P.length){var Q=P;P=function(a){return q(a,+Q[1],+Q[2],+Q[3],+Q[4],p)}}else P=nb;if(n=i.start||a.start||+new Date,u={anim:a,percent:e,timestamp:n,start:n+(a.del||0),status:0,initstatus:f||0,stop:!1,ms:p,easing:P,from:r,diff:t,to:s,el:d,callback:i.callback,prev:m,next:l,repeat:h||a.times,origin:d.attr(),totalOrigin:g},ic.push(u),f&&!j&&!k&&(u.stop=!0,u.start=new Date-p*f,1==ic.length))return kc();k&&(u.start=new Date-u.ms*f),1==ic.length&&jc(kc)}b("raphael.anim.start."+d.id,d,a)}}function t(a){for(var b=0;b<ic.length;b++)ic[b].el.paper==a&&ic.splice(b--,1)}c.version="2.1.0",c.eve=b;var u,v,w=/[, ]+/,x={circle:1,rect:1,path:1,ellipse:1,text:1,image:1},y=/\{(\d+)\}/g,z="hasOwnProperty",A={doc:document,win:a},B={was:Object.prototype[z].call(A.win,"Raphael"),is:A.win.Raphael},C=function(){this.ca=this.customAttributes={}},D="apply",E="concat",F="ontouchstart"in A.win||A.win.DocumentTouch&&A.doc instanceof DocumentTouch,G="",H=" ",I=String,J="split",K="click dblclick mousedown mousemove mouseout mouseover mouseup touchstart touchmove touchend touchcancel"[J](H),L={mousedown:"touchstart",mousemove:"touchmove",mouseup:"touchend"},M=I.prototype.toLowerCase,N=Math,O=N.max,P=N.min,Q=N.abs,R=N.pow,S=N.PI,T="number",U="string",V="array",W=Object.prototype.toString,X=(c._ISURL=/^url\(['"]?([^\)]+?)['"]?\)$/i,/^\s*((#[a-f\d]{6})|(#[a-f\d]{3})|rgba?\(\s*([\d\.]+%?\s*,\s*[\d\.]+%?\s*,\s*[\d\.]+%?(?:\s*,\s*[\d\.]+%?)?)\s*\)|hsba?\(\s*([\d\.]+(?:deg|\xb0|%)?\s*,\s*[\d\.]+%?\s*,\s*[\d\.]+(?:%?\s*,\s*[\d\.]+)?)%?\s*\)|hsla?\(\s*([\d\.]+(?:deg|\xb0|%)?\s*,\s*[\d\.]+%?\s*,\s*[\d\.]+(?:%?\s*,\s*[\d\.]+)?)%?\s*\))\s*$/i),Y={NaN:1,Infinity:1,"-Infinity":1},Z=/^(?:cubic-)?bezier\(([^,]+),([^,]+),([^,]+),([^\)]+)\)/,$=N.round,_=parseFloat,ab=parseInt,bb=I.prototype.toUpperCase,cb=c._availableAttrs={"arrow-end":"none","arrow-start":"none",blur:0,"clip-rect":"0 0 1e9 1e9",cursor:"default",cx:0,cy:0,fill:"#fff","fill-opacity":1,font:'10px "Arial"',"font-family":'"Arial"',"font-size":"10","font-style":"normal","font-weight":400,gradient:0,height:0,href:"http://raphaeljs.com/","letter-spacing":0,opacity:1,path:"M0,0",r:0,rx:0,ry:0,src:"",stroke:"#000","stroke-dasharray":"","stroke-linecap":"butt","stroke-linejoin":"butt","stroke-miterlimit":0,"stroke-opacity":1,"stroke-width":1,target:"_blank","text-anchor":"middle",title:"Raphael",transform:"",width:0,x:0,y:0},db=c._availableAnimAttrs={blur:T,"clip-rect":"csv",cx:T,cy:T,fill:"colour","fill-opacity":T,"font-size":T,height:T,opacity:T,path:"path",r:T,rx:T,ry:T,stroke:"colour","stroke-opacity":T,"stroke-width":T,transform:"transform",width:T,x:T,y:T},eb=/[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*,[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*/,fb={hs:1,rg:1},gb=/,?([achlmqrstvxz]),?/gi,hb=/([achlmrqstvz])[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029,]*((-?\d*\.?\d*(?:e[\-+]?\d+)?[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*,?[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*)+)/gi,ib=/([rstm])[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029,]*((-?\d*\.?\d*(?:e[\-+]?\d+)?[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*,?[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*)+)/gi,jb=/(-?\d*\.?\d*(?:e[\-+]?\d+)?)[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*,?[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*/gi,kb=(c._radial_gradient=/^r(?:\(([^,]+?)[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*,[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*([^\)]+?)\))?/,{}),lb=function(a,b){return _(a)-_(b)},mb=function(){},nb=function(a){return a},ob=c._rectPath=function(a,b,c,d,e){return e?[["M",a+e,b],["l",c-2*e,0],["a",e,e,0,0,1,e,e],["l",0,d-2*e],["a",e,e,0,0,1,-e,e],["l",2*e-c,0],["a",e,e,0,0,1,-e,-e],["l",0,2*e-d],["a",e,e,0,0,1,e,-e],["z"]]:[["M",a,b],["l",c,0],["l",0,d],["l",-c,0],["z"]]},pb=function(a,b,c,d){return null==d&&(d=c),[["M",a,b],["m",0,-d],["a",c,d,0,1,1,0,2*d],["a",c,d,0,1,1,0,-2*d],["z"]]},qb=c._getPath={path:function(a){return a.attr("path")},circle:function(a){var b=a.attrs;return pb(b.cx,b.cy,b.r)},ellipse:function(a){var b=a.attrs;return pb(b.cx,b.cy,b.rx,b.ry)},rect:function(a){var b=a.attrs;return ob(b.x,b.y,b.width,b.height,b.r)},image:function(a){var b=a.attrs;return ob(b.x,b.y,b.width,b.height)},text:function(a){var b=a._getBBox();return ob(b.x,b.y,b.width,b.height)},set:function(a){var b=a._getBBox();return ob(b.x,b.y,b.width,b.height)}},rb=c.mapPath=function(a,b){if(!b)return a;var c,d,e,f,g,h,i;for(a=Kb(a),e=0,g=a.length;g>e;e++)for(i=a[e],f=1,h=i.length;h>f;f+=2)c=b.x(i[f],i[f+1]),d=b.y(i[f],i[f+1]),i[f]=c,i[f+1]=d;return a};if(c._g=A,c.type=A.win.SVGAngle||A.doc.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure","1.1")?"SVG":"VML","VML"==c.type){var sb,tb=A.doc.createElement("div");if(tb.innerHTML='<v:shape adj="1"/>',sb=tb.firstChild,sb.style.behavior="url(#default#VML)",!sb||"object"!=typeof sb.adj)return c.type=G;tb=null}c.svg=!(c.vml="VML"==c.type),c._Paper=C,c.fn=v=C.prototype=c.prototype,c._id=0,c._oid=0,c.is=function(a,b){return b=M.call(b),"finite"==b?!Y[z](+a):"array"==b?a instanceof Array:"null"==b&&null===a||b==typeof a&&null!==a||"object"==b&&a===Object(a)||"array"==b&&Array.isArray&&Array.isArray(a)||W.call(a).slice(8,-1).toLowerCase()==b},c.angle=function(a,b,d,e,f,g){if(null==f){var h=a-d,i=b-e;return h||i?(180+180*N.atan2(-i,-h)/S+360)%360:0}return c.angle(a,b,f,g)-c.angle(d,e,f,g)},c.rad=function(a){return a%360*S/180},c.deg=function(a){return 180*a/S%360},c.snapTo=function(a,b,d){if(d=c.is(d,"finite")?d:10,c.is(a,V)){for(var e=a.length;e--;)if(Q(a[e]-b)<=d)return a[e]}else{a=+a;var f=b%a;if(d>f)return b-f;if(f>a-d)return b-f+a}return b},c.createUUID=function(a,b){return function(){return"xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(a,b).toUpperCase()}}(/[xy]/g,function(a){var b=0|16*N.random(),c="x"==a?b:8|3&b;return c.toString(16)}),c.setWindow=function(a){b("raphael.setWindow",c,A.win,a),A.win=a,A.doc=A.win.document,c._engine.initWin&&c._engine.initWin(A.win)};var ub=function(a){if(c.vml){var b,d=/^\s+|\s+$/g;try{var e=new ActiveXObject("htmlfile");e.write("<body>"),e.close(),b=e.body}catch(g){b=createPopup().document.body}var h=b.createTextRange();ub=f(function(a){try{b.style.color=I(a).replace(d,G);var c=h.queryCommandValue("ForeColor");return c=(255&c)<<16|65280&c|(16711680&c)>>>16,"#"+("000000"+c.toString(16)).slice(-6)}catch(e){return"none"}})}else{var i=A.doc.createElement("i");i.title="Raphaël Colour Picker",i.style.display="none",A.doc.body.appendChild(i),ub=f(function(a){return i.style.color=a,A.doc.defaultView.getComputedStyle(i,G).getPropertyValue("color")})}return ub(a)},vb=function(){return"hsb("+[this.h,this.s,this.b]+")"},wb=function(){return"hsl("+[this.h,this.s,this.l]+")"},xb=function(){return this.hex},yb=function(a,b,d){if(null==b&&c.is(a,"object")&&"r"in a&&"g"in a&&"b"in a&&(d=a.b,b=a.g,a=a.r),null==b&&c.is(a,U)){var e=c.getRGB(a);a=e.r,b=e.g,d=e.b}return(a>1||b>1||d>1)&&(a/=255,b/=255,d/=255),[a,b,d]},zb=function(a,b,d,e){a*=255,b*=255,d*=255;var f={r:a,g:b,b:d,hex:c.rgb(a,b,d),toString:xb};return c.is(e,"finite")&&(f.opacity=e),f};c.color=function(a){var b;return c.is(a,"object")&&"h"in a&&"s"in a&&"b"in a?(b=c.hsb2rgb(a),a.r=b.r,a.g=b.g,a.b=b.b,a.hex=b.hex):c.is(a,"object")&&"h"in a&&"s"in a&&"l"in a?(b=c.hsl2rgb(a),a.r=b.r,a.g=b.g,a.b=b.b,a.hex=b.hex):(c.is(a,"string")&&(a=c.getRGB(a)),c.is(a,"object")&&"r"in a&&"g"in a&&"b"in a?(b=c.rgb2hsl(a),a.h=b.h,a.s=b.s,a.l=b.l,b=c.rgb2hsb(a),a.v=b.b):(a={hex:"none"},a.r=a.g=a.b=a.h=a.s=a.v=a.l=-1)),a.toString=xb,a},c.hsb2rgb=function(a,b,c,d){this.is(a,"object")&&"h"in a&&"s"in a&&"b"in a&&(c=a.b,b=a.s,a=a.h,d=a.o),a*=360;var e,f,g,h,i;return a=a%360/60,i=c*b,h=i*(1-Q(a%2-1)),e=f=g=c-i,a=~~a,e+=[i,h,0,0,h,i][a],f+=[h,i,i,h,0,0][a],g+=[0,0,h,i,i,h][a],zb(e,f,g,d)},c.hsl2rgb=function(a,b,c,d){this.is(a,"object")&&"h"in a&&"s"in a&&"l"in a&&(c=a.l,b=a.s,a=a.h),(a>1||b>1||c>1)&&(a/=360,b/=100,c/=100),a*=360;var e,f,g,h,i;return a=a%360/60,i=2*b*(.5>c?c:1-c),h=i*(1-Q(a%2-1)),e=f=g=c-i/2,a=~~a,e+=[i,h,0,0,h,i][a],f+=[h,i,i,h,0,0][a],g+=[0,0,h,i,i,h][a],zb(e,f,g,d)},c.rgb2hsb=function(a,b,c){c=yb(a,b,c),a=c[0],b=c[1],c=c[2];var d,e,f,g;return f=O(a,b,c),g=f-P(a,b,c),d=0==g?null:f==a?(b-c)/g:f==b?(c-a)/g+2:(a-b)/g+4,d=60*((d+360)%6)/360,e=0==g?0:g/f,{h:d,s:e,b:f,toString:vb}},c.rgb2hsl=function(a,b,c){c=yb(a,b,c),a=c[0],b=c[1],c=c[2];var d,e,f,g,h,i;return g=O(a,b,c),h=P(a,b,c),i=g-h,d=0==i?null:g==a?(b-c)/i:g==b?(c-a)/i+2:(a-b)/i+4,d=60*((d+360)%6)/360,f=(g+h)/2,e=0==i?0:.5>f?i/(2*f):i/(2-2*f),{h:d,s:e,l:f,toString:wb}},c._path2string=function(){return this.join(",").replace(gb,"$1")},c._preload=function(a,b){var c=A.doc.createElement("img");c.style.cssText="position:absolute;left:-9999em;top:-9999em",c.onload=function(){b.call(this),this.onload=null,A.doc.body.removeChild(this)},c.onerror=function(){A.doc.body.removeChild(this)},A.doc.body.appendChild(c),c.src=a},c.getRGB=f(function(a){if(!a||(a=I(a)).indexOf("-")+1)return{r:-1,g:-1,b:-1,hex:"none",error:1,toString:g};if("none"==a)return{r:-1,g:-1,b:-1,hex:"none",toString:g};!(fb[z](a.toLowerCase().substring(0,2))||"#"==a.charAt())&&(a=ub(a));var b,d,e,f,h,i,j=a.match(X);return j?(j[2]&&(e=ab(j[2].substring(5),16),d=ab(j[2].substring(3,5),16),b=ab(j[2].substring(1,3),16)),j[3]&&(e=ab((h=j[3].charAt(3))+h,16),d=ab((h=j[3].charAt(2))+h,16),b=ab((h=j[3].charAt(1))+h,16)),j[4]&&(i=j[4][J](eb),b=_(i[0]),"%"==i[0].slice(-1)&&(b*=2.55),d=_(i[1]),"%"==i[1].slice(-1)&&(d*=2.55),e=_(i[2]),"%"==i[2].slice(-1)&&(e*=2.55),"rgba"==j[1].toLowerCase().slice(0,4)&&(f=_(i[3])),i[3]&&"%"==i[3].slice(-1)&&(f/=100)),j[5]?(i=j[5][J](eb),b=_(i[0]),"%"==i[0].slice(-1)&&(b*=2.55),d=_(i[1]),"%"==i[1].slice(-1)&&(d*=2.55),e=_(i[2]),"%"==i[2].slice(-1)&&(e*=2.55),("deg"==i[0].slice(-3)||"°"==i[0].slice(-1))&&(b/=360),"hsba"==j[1].toLowerCase().slice(0,4)&&(f=_(i[3])),i[3]&&"%"==i[3].slice(-1)&&(f/=100),c.hsb2rgb(b,d,e,f)):j[6]?(i=j[6][J](eb),b=_(i[0]),"%"==i[0].slice(-1)&&(b*=2.55),d=_(i[1]),"%"==i[1].slice(-1)&&(d*=2.55),e=_(i[2]),"%"==i[2].slice(-1)&&(e*=2.55),("deg"==i[0].slice(-3)||"°"==i[0].slice(-1))&&(b/=360),"hsla"==j[1].toLowerCase().slice(0,4)&&(f=_(i[3])),i[3]&&"%"==i[3].slice(-1)&&(f/=100),c.hsl2rgb(b,d,e,f)):(j={r:b,g:d,b:e,toString:g},j.hex="#"+(16777216|e|d<<8|b<<16).toString(16).slice(1),c.is(f,"finite")&&(j.opacity=f),j)):{r:-1,g:-1,b:-1,hex:"none",error:1,toString:g}},c),c.hsb=f(function(a,b,d){return c.hsb2rgb(a,b,d).hex}),c.hsl=f(function(a,b,d){return c.hsl2rgb(a,b,d).hex}),c.rgb=f(function(a,b,c){return"#"+(16777216|c|b<<8|a<<16).toString(16).slice(1)}),c.getColor=function(a){var b=this.getColor.start=this.getColor.start||{h:0,s:1,b:a||.75},c=this.hsb2rgb(b.h,b.s,b.b);return b.h+=.075,b.h>1&&(b.h=0,b.s-=.2,b.s<=0&&(this.getColor.start={h:0,s:1,b:b.b})),c.hex},c.getColor.reset=function(){delete this.start},c.parsePathString=function(a){if(!a)return null;var b=Ab(a);if(b.arr)return Cb(b.arr);var d={a:7,c:6,h:1,l:2,m:2,r:4,q:4,s:4,t:2,v:1,z:0},e=[];return c.is(a,V)&&c.is(a[0],V)&&(e=Cb(a)),e.length||I(a).replace(hb,function(a,b,c){var f=[],g=b.toLowerCase();if(c.replace(jb,function(a,b){b&&f.push(+b)}),"m"==g&&f.length>2&&(e.push([b][E](f.splice(0,2))),g="l",b="m"==b?"l":"L"),"r"==g)e.push([b][E](f));else for(;f.length>=d[g]&&(e.push([b][E](f.splice(0,d[g]))),d[g]););}),e.toString=c._path2string,b.arr=Cb(e),e},c.parseTransformString=f(function(a){if(!a)return null;var b=[];return c.is(a,V)&&c.is(a[0],V)&&(b=Cb(a)),b.length||I(a).replace(ib,function(a,c,d){var e=[];M.call(c),d.replace(jb,function(a,b){b&&e.push(+b)}),b.push([c][E](e))}),b.toString=c._path2string,b});var Ab=function(a){var b=Ab.ps=Ab.ps||{};return b[a]?b[a].sleep=100:b[a]={sleep:100},setTimeout(function(){for(var c in b)b[z](c)&&c!=a&&(b[c].sleep--,!b[c].sleep&&delete b[c])}),b[a]};c.findDotsAtSegment=function(a,b,c,d,e,f,g,h,i){var j=1-i,k=R(j,3),l=R(j,2),m=i*i,n=m*i,o=k*a+3*l*i*c+3*j*i*i*e+n*g,p=k*b+3*l*i*d+3*j*i*i*f+n*h,q=a+2*i*(c-a)+m*(e-2*c+a),r=b+2*i*(d-b)+m*(f-2*d+b),s=c+2*i*(e-c)+m*(g-2*e+c),t=d+2*i*(f-d)+m*(h-2*f+d),u=j*a+i*c,v=j*b+i*d,w=j*e+i*g,x=j*f+i*h,y=90-180*N.atan2(q-s,r-t)/S;return(q>s||t>r)&&(y+=180),{x:o,y:p,m:{x:q,y:r},n:{x:s,y:t},start:{x:u,y:v},end:{x:w,y:x},alpha:y}},c.bezierBBox=function(a,b,d,e,f,g,h,i){c.is(a,"array")||(a=[a,b,d,e,f,g,h,i]);var j=Jb.apply(null,a);return{x:j.min.x,y:j.min.y,x2:j.max.x,y2:j.max.y,width:j.max.x-j.min.x,height:j.max.y-j.min.y}},c.isPointInsideBBox=function(a,b,c){return b>=a.x&&b<=a.x2&&c>=a.y&&c<=a.y2},c.isBBoxIntersect=function(a,b){var d=c.isPointInsideBBox;return d(b,a.x,a.y)||d(b,a.x2,a.y)||d(b,a.x,a.y2)||d(b,a.x2,a.y2)||d(a,b.x,b.y)||d(a,b.x2,b.y)||d(a,b.x,b.y2)||d(a,b.x2,b.y2)||(a.x<b.x2&&a.x>b.x||b.x<a.x2&&b.x>a.x)&&(a.y<b.y2&&a.y>b.y||b.y<a.y2&&b.y>a.y)},c.pathIntersection=function(a,b){return n(a,b)},c.pathIntersectionNumber=function(a,b){return n(a,b,1)},c.isPointInsidePath=function(a,b,d){var e=c.pathBBox(a);return c.isPointInsideBBox(e,b,d)&&1==n(a,[["M",b,d],["H",e.x2+10]],1)%2},c._removedFactory=function(a){return function(){b("raphael.log",null,"Raphaël: you are calling to method “"+a+"” of removed object",a)}};var Bb=c.pathBBox=function(a){var b=Ab(a);if(b.bbox)return d(b.bbox);if(!a)return{x:0,y:0,width:0,height:0,x2:0,y2:0};a=Kb(a);for(var c,e=0,f=0,g=[],h=[],i=0,j=a.length;j>i;i++)if(c=a[i],"M"==c[0])e=c[1],f=c[2],g.push(e),h.push(f);else{var k=Jb(e,f,c[1],c[2],c[3],c[4],c[5],c[6]);g=g[E](k.min.x,k.max.x),h=h[E](k.min.y,k.max.y),e=c[5],f=c[6]}var l=P[D](0,g),m=P[D](0,h),n=O[D](0,g),o=O[D](0,h),p=n-l,q=o-m,r={x:l,y:m,x2:n,y2:o,width:p,height:q,cx:l+p/2,cy:m+q/2};return b.bbox=d(r),r},Cb=function(a){var b=d(a);return b.toString=c._path2string,b},Db=c._pathToRelative=function(a){var b=Ab(a);if(b.rel)return Cb(b.rel);c.is(a,V)&&c.is(a&&a[0],V)||(a=c.parsePathString(a));var d=[],e=0,f=0,g=0,h=0,i=0;"M"==a[0][0]&&(e=a[0][1],f=a[0][2],g=e,h=f,i++,d.push(["M",e,f]));for(var j=i,k=a.length;k>j;j++){var l=d[j]=[],m=a[j];if(m[0]!=M.call(m[0]))switch(l[0]=M.call(m[0]),l[0]){case"a":l[1]=m[1],l[2]=m[2],l[3]=m[3],l[4]=m[4],l[5]=m[5],l[6]=+(m[6]-e).toFixed(3),l[7]=+(m[7]-f).toFixed(3);break;case"v":l[1]=+(m[1]-f).toFixed(3);break;case"m":g=m[1],h=m[2];default:for(var n=1,o=m.length;o>n;n++)l[n]=+(m[n]-(n%2?e:f)).toFixed(3)}else{l=d[j]=[],"m"==m[0]&&(g=m[1]+e,h=m[2]+f);for(var p=0,q=m.length;q>p;p++)d[j][p]=m[p]}var r=d[j].length;switch(d[j][0]){case"z":e=g,f=h;break;case"h":e+=+d[j][r-1];break;case"v":f+=+d[j][r-1];break;default:e+=+d[j][r-2],f+=+d[j][r-1]}}return d.toString=c._path2string,b.rel=Cb(d),d},Eb=c._pathToAbsolute=function(a){var b=Ab(a);if(b.abs)return Cb(b.abs);if(c.is(a,V)&&c.is(a&&a[0],V)||(a=c.parsePathString(a)),!a||!a.length)return[["M",0,0]];var d=[],e=0,f=0,g=0,i=0,j=0;"M"==a[0][0]&&(e=+a[0][1],f=+a[0][2],g=e,i=f,j++,d[0]=["M",e,f]);for(var k,l,m=3==a.length&&"M"==a[0][0]&&"R"==a[1][0].toUpperCase()&&"Z"==a[2][0].toUpperCase(),n=j,o=a.length;o>n;n++){if(d.push(k=[]),l=a[n],l[0]!=bb.call(l[0]))switch(k[0]=bb.call(l[0]),k[0]){case"A":k[1]=l[1],k[2]=l[2],k[3]=l[3],k[4]=l[4],k[5]=l[5],k[6]=+(l[6]+e),k[7]=+(l[7]+f);break;case"V":k[1]=+l[1]+f;break;case"H":k[1]=+l[1]+e;break;case"R":for(var p=[e,f][E](l.slice(1)),q=2,r=p.length;r>q;q++)p[q]=+p[q]+e,p[++q]=+p[q]+f;d.pop(),d=d[E](h(p,m));break;case"M":g=+l[1]+e,i=+l[2]+f;default:for(q=1,r=l.length;r>q;q++)k[q]=+l[q]+(q%2?e:f)}else if("R"==l[0])p=[e,f][E](l.slice(1)),d.pop(),d=d[E](h(p,m)),k=["R"][E](l.slice(-2));else for(var s=0,t=l.length;t>s;s++)k[s]=l[s];switch(k[0]){case"Z":e=g,f=i;break;case"H":e=k[1];break;case"V":f=k[1];break;case"M":g=k[k.length-2],i=k[k.length-1];default:e=k[k.length-2],f=k[k.length-1]}}return d.toString=c._path2string,b.abs=Cb(d),d},Fb=function(a,b,c,d){return[a,b,c,d,c,d]},Gb=function(a,b,c,d,e,f){var g=1/3,h=2/3;return[g*a+h*c,g*b+h*d,g*e+h*c,g*f+h*d,e,f]},Hb=function(a,b,c,d,e,g,h,i,j,k){var l,m=120*S/180,n=S/180*(+e||0),o=[],p=f(function(a,b,c){var d=a*N.cos(c)-b*N.sin(c),e=a*N.sin(c)+b*N.cos(c);return{x:d,y:e}});if(k)y=k[0],z=k[1],w=k[2],x=k[3];else{l=p(a,b,-n),a=l.x,b=l.y,l=p(i,j,-n),i=l.x,j=l.y;var q=(N.cos(S/180*e),N.sin(S/180*e),(a-i)/2),r=(b-j)/2,s=q*q/(c*c)+r*r/(d*d);s>1&&(s=N.sqrt(s),c=s*c,d=s*d);var t=c*c,u=d*d,v=(g==h?-1:1)*N.sqrt(Q((t*u-t*r*r-u*q*q)/(t*r*r+u*q*q))),w=v*c*r/d+(a+i)/2,x=v*-d*q/c+(b+j)/2,y=N.asin(((b-x)/d).toFixed(9)),z=N.asin(((j-x)/d).toFixed(9));y=w>a?S-y:y,z=w>i?S-z:z,0>y&&(y=2*S+y),0>z&&(z=2*S+z),h&&y>z&&(y-=2*S),!h&&z>y&&(z-=2*S)}var A=z-y;if(Q(A)>m){var B=z,C=i,D=j;z=y+m*(h&&z>y?1:-1),i=w+c*N.cos(z),j=x+d*N.sin(z),o=Hb(i,j,c,d,e,0,h,C,D,[z,B,w,x])}A=z-y;var F=N.cos(y),G=N.sin(y),H=N.cos(z),I=N.sin(z),K=N.tan(A/4),L=4/3*c*K,M=4/3*d*K,O=[a,b],P=[a+L*G,b-M*F],R=[i+L*I,j-M*H],T=[i,j];if(P[0]=2*O[0]-P[0],P[1]=2*O[1]-P[1],k)return[P,R,T][E](o);o=[P,R,T][E](o).join()[J](",");for(var U=[],V=0,W=o.length;W>V;V++)U[V]=V%2?p(o[V-1],o[V],n).y:p(o[V],o[V+1],n).x;return U},Ib=function(a,b,c,d,e,f,g,h,i){var j=1-i;return{x:R(j,3)*a+3*R(j,2)*i*c+3*j*i*i*e+R(i,3)*g,y:R(j,3)*b+3*R(j,2)*i*d+3*j*i*i*f+R(i,3)*h}},Jb=f(function(a,b,c,d,e,f,g,h){var i,j=e-2*c+a-(g-2*e+c),k=2*(c-a)-2*(e-c),l=a-c,m=(-k+N.sqrt(k*k-4*j*l))/2/j,n=(-k-N.sqrt(k*k-4*j*l))/2/j,o=[b,h],p=[a,g];return Q(m)>"1e12"&&(m=.5),Q(n)>"1e12"&&(n=.5),m>0&&1>m&&(i=Ib(a,b,c,d,e,f,g,h,m),p.push(i.x),o.push(i.y)),n>0&&1>n&&(i=Ib(a,b,c,d,e,f,g,h,n),p.push(i.x),o.push(i.y)),j=f-2*d+b-(h-2*f+d),k=2*(d-b)-2*(f-d),l=b-d,m=(-k+N.sqrt(k*k-4*j*l))/2/j,n=(-k-N.sqrt(k*k-4*j*l))/2/j,Q(m)>"1e12"&&(m=.5),Q(n)>"1e12"&&(n=.5),m>0&&1>m&&(i=Ib(a,b,c,d,e,f,g,h,m),p.push(i.x),o.push(i.y)),n>0&&1>n&&(i=Ib(a,b,c,d,e,f,g,h,n),p.push(i.x),o.push(i.y)),{min:{x:P[D](0,p),y:P[D](0,o)},max:{x:O[D](0,p),y:O[D](0,o)}}}),Kb=c._path2curve=f(function(a,b){var c=!b&&Ab(a);if(!b&&c.curve)return Cb(c.curve);for(var d=Eb(a),e=b&&Eb(b),f={x:0,y:0,bx:0,by:0,X:0,Y:0,qx:null,qy:null},g={x:0,y:0,bx:0,by:0,X:0,Y:0,qx:null,qy:null},h=(function(a,b,c){var d,e;if(!a)return["C",b.x,b.y,b.x,b.y,b.x,b.y];switch(!(a[0]in{T:1,Q:1})&&(b.qx=b.qy=null),a[0]){case"M":b.X=a[1],b.Y=a[2];break;case"A":a=["C"][E](Hb[D](0,[b.x,b.y][E](a.slice(1))));break;case"S":"C"==c||"S"==c?(d=2*b.x-b.bx,e=2*b.y-b.by):(d=b.x,e=b.y),a=["C",d,e][E](a.slice(1));break;case"T":"Q"==c||"T"==c?(b.qx=2*b.x-b.qx,b.qy=2*b.y-b.qy):(b.qx=b.x,b.qy=b.y),a=["C"][E](Gb(b.x,b.y,b.qx,b.qy,a[1],a[2]));break;case"Q":b.qx=a[1],b.qy=a[2],a=["C"][E](Gb(b.x,b.y,a[1],a[2],a[3],a[4]));break;case"L":a=["C"][E](Fb(b.x,b.y,a[1],a[2]));break;case"H":a=["C"][E](Fb(b.x,b.y,a[1],b.y));break;case"V":a=["C"][E](Fb(b.x,b.y,b.x,a[1]));break;case"Z":a=["C"][E](Fb(b.x,b.y,b.X,b.Y))}return a}),i=function(a,b){if(a[b].length>7){a[b].shift();for(var c=a[b];c.length;)a.splice(b++,0,["C"][E](c.splice(0,6)));a.splice(b,1),l=O(d.length,e&&e.length||0)}},j=function(a,b,c,f,g){a&&b&&"M"==a[g][0]&&"M"!=b[g][0]&&(b.splice(g,0,["M",f.x,f.y]),c.bx=0,c.by=0,c.x=a[g][1],c.y=a[g][2],l=O(d.length,e&&e.length||0))},k=0,l=O(d.length,e&&e.length||0);l>k;k++){d[k]=h(d[k],f),i(d,k),e&&(e[k]=h(e[k],g)),e&&i(e,k),j(d,e,f,g,k),j(e,d,g,f,k);var m=d[k],n=e&&e[k],o=m.length,p=e&&n.length;f.x=m[o-2],f.y=m[o-1],f.bx=_(m[o-4])||f.x,f.by=_(m[o-3])||f.y,g.bx=e&&(_(n[p-4])||g.x),g.by=e&&(_(n[p-3])||g.y),g.x=e&&n[p-2],g.y=e&&n[p-1]}return e||(c.curve=Cb(d)),e?[d,e]:d},null,Cb),Lb=(c._parseDots=f(function(a){for(var b=[],d=0,e=a.length;e>d;d++){var f={},g=a[d].match(/^([^:]*):?([\d\.]*)/);if(f.color=c.getRGB(g[1]),f.color.error)return null;f.color=f.color.hex,g[2]&&(f.offset=g[2]+"%"),b.push(f)}for(d=1,e=b.length-1;e>d;d++)if(!b[d].offset){for(var h=_(b[d-1].offset||0),i=0,j=d+1;e>j;j++)if(b[j].offset){i=b[j].offset;break}i||(i=100,j=e),i=_(i);for(var k=(i-h)/(j-d+1);j>d;d++)h+=k,b[d].offset=h+"%"}return b}),c._tear=function(a,b){a==b.top&&(b.top=a.prev),a==b.bottom&&(b.bottom=a.next),a.next&&(a.next.prev=a.prev),a.prev&&(a.prev.next=a.next)}),Mb=(c._tofront=function(a,b){b.top!==a&&(Lb(a,b),a.next=null,a.prev=b.top,b.top.next=a,b.top=a)},c._toback=function(a,b){b.bottom!==a&&(Lb(a,b),a.next=b.bottom,a.prev=null,b.bottom.prev=a,b.bottom=a)},c._insertafter=function(a,b,c){Lb(a,c),b==c.top&&(c.top=a),b.next&&(b.next.prev=a),a.next=b.next,a.prev=b,b.next=a},c._insertbefore=function(a,b,c){Lb(a,c),b==c.bottom&&(c.bottom=a),b.prev&&(b.prev.next=a),a.prev=b.prev,b.prev=a,a.next=b},c.toMatrix=function(a,b){var c=Bb(a),d={_:{transform:G},getBBox:function(){return c}};return Nb(d,b),d.matrix}),Nb=(c.transformPath=function(a,b){return rb(a,Mb(a,b))},c._extractTransform=function(a,b){if(null==b)return a._.transform;b=I(b).replace(/\.{3}|\u2026/g,a._.transform||G);var d=c.parseTransformString(b),e=0,f=0,g=0,h=1,i=1,j=a._,k=new o;if(j.transform=d||[],d)for(var l=0,m=d.length;m>l;l++){var n,p,q,r,s,t=d[l],u=t.length,v=I(t[0]).toLowerCase(),w=t[0]!=v,x=w?k.invert():0;"t"==v&&3==u?w?(n=x.x(0,0),p=x.y(0,0),q=x.x(t[1],t[2]),r=x.y(t[1],t[2]),k.translate(q-n,r-p)):k.translate(t[1],t[2]):"r"==v?2==u?(s=s||a.getBBox(1),k.rotate(t[1],s.x+s.width/2,s.y+s.height/2),e+=t[1]):4==u&&(w?(q=x.x(t[2],t[3]),r=x.y(t[2],t[3]),k.rotate(t[1],q,r)):k.rotate(t[1],t[2],t[3]),e+=t[1]):"s"==v?2==u||3==u?(s=s||a.getBBox(1),k.scale(t[1],t[u-1],s.x+s.width/2,s.y+s.height/2),h*=t[1],i*=t[u-1]):5==u&&(w?(q=x.x(t[3],t[4]),r=x.y(t[3],t[4]),k.scale(t[1],t[2],q,r)):k.scale(t[1],t[2],t[3],t[4]),h*=t[1],i*=t[2]):"m"==v&&7==u&&k.add(t[1],t[2],t[3],t[4],t[5],t[6]),j.dirtyT=1,a.matrix=k}a.matrix=k,j.sx=h,j.sy=i,j.deg=e,j.dx=f=k.e,j.dy=g=k.f,1==h&&1==i&&!e&&j.bbox?(j.bbox.x+=+f,j.bbox.y+=+g):j.dirtyT=1}),Ob=function(a){var b=a[0];switch(b.toLowerCase()){case"t":return[b,0,0];case"m":return[b,1,0,0,1,0,0];case"r":return 4==a.length?[b,0,a[2],a[3]]:[b,0];case"s":return 5==a.length?[b,1,1,a[3],a[4]]:3==a.length?[b,1,1]:[b,1]}},Pb=c._equaliseTransform=function(a,b){b=I(b).replace(/\.{3}|\u2026/g,a),a=c.parseTransformString(a)||[],b=c.parseTransformString(b)||[];for(var d,e,f,g,h=O(a.length,b.length),i=[],j=[],k=0;h>k;k++){if(f=a[k]||Ob(b[k]),g=b[k]||Ob(f),f[0]!=g[0]||"r"==f[0].toLowerCase()&&(f[2]!=g[2]||f[3]!=g[3])||"s"==f[0].toLowerCase()&&(f[3]!=g[3]||f[4]!=g[4]))return;for(i[k]=[],j[k]=[],d=0,e=O(f.length,g.length);e>d;d++)d in f&&(i[k][d]=f[d]),d in g&&(j[k][d]=g[d])
}return{from:i,to:j}};c._getContainer=function(a,b,d,e){var f;return f=null!=e||c.is(a,"object")?a:A.doc.getElementById(a),null!=f?f.tagName?null==b?{container:f,width:f.style.pixelWidth||f.offsetWidth,height:f.style.pixelHeight||f.offsetHeight}:{container:f,width:b,height:d}:{container:1,x:a,y:b,width:d,height:e}:void 0},c.pathToRelative=Db,c._engine={},c.path2curve=Kb,c.matrix=function(a,b,c,d,e,f){return new o(a,b,c,d,e,f)},function(a){function b(a){return a[0]*a[0]+a[1]*a[1]}function d(a){var c=N.sqrt(b(a));a[0]&&(a[0]/=c),a[1]&&(a[1]/=c)}a.add=function(a,b,c,d,e,f){var g,h,i,j,k=[[],[],[]],l=[[this.a,this.c,this.e],[this.b,this.d,this.f],[0,0,1]],m=[[a,c,e],[b,d,f],[0,0,1]];for(a&&a instanceof o&&(m=[[a.a,a.c,a.e],[a.b,a.d,a.f],[0,0,1]]),g=0;3>g;g++)for(h=0;3>h;h++){for(j=0,i=0;3>i;i++)j+=l[g][i]*m[i][h];k[g][h]=j}this.a=k[0][0],this.b=k[1][0],this.c=k[0][1],this.d=k[1][1],this.e=k[0][2],this.f=k[1][2]},a.invert=function(){var a=this,b=a.a*a.d-a.b*a.c;return new o(a.d/b,-a.b/b,-a.c/b,a.a/b,(a.c*a.f-a.d*a.e)/b,(a.b*a.e-a.a*a.f)/b)},a.clone=function(){return new o(this.a,this.b,this.c,this.d,this.e,this.f)},a.translate=function(a,b){this.add(1,0,0,1,a,b)},a.scale=function(a,b,c,d){null==b&&(b=a),(c||d)&&this.add(1,0,0,1,c,d),this.add(a,0,0,b,0,0),(c||d)&&this.add(1,0,0,1,-c,-d)},a.rotate=function(a,b,d){a=c.rad(a),b=b||0,d=d||0;var e=+N.cos(a).toFixed(9),f=+N.sin(a).toFixed(9);this.add(e,f,-f,e,b,d),this.add(1,0,0,1,-b,-d)},a.x=function(a,b){return a*this.a+b*this.c+this.e},a.y=function(a,b){return a*this.b+b*this.d+this.f},a.get=function(a){return+this[I.fromCharCode(97+a)].toFixed(4)},a.toString=function(){return c.svg?"matrix("+[this.get(0),this.get(1),this.get(2),this.get(3),this.get(4),this.get(5)].join()+")":[this.get(0),this.get(2),this.get(1),this.get(3),0,0].join()},a.toFilter=function(){return"progid:DXImageTransform.Microsoft.Matrix(M11="+this.get(0)+", M12="+this.get(2)+", M21="+this.get(1)+", M22="+this.get(3)+", Dx="+this.get(4)+", Dy="+this.get(5)+", sizingmethod='auto expand')"},a.offset=function(){return[this.e.toFixed(4),this.f.toFixed(4)]},a.split=function(){var a={};a.dx=this.e,a.dy=this.f;var e=[[this.a,this.c],[this.b,this.d]];a.scalex=N.sqrt(b(e[0])),d(e[0]),a.shear=e[0][0]*e[1][0]+e[0][1]*e[1][1],e[1]=[e[1][0]-e[0][0]*a.shear,e[1][1]-e[0][1]*a.shear],a.scaley=N.sqrt(b(e[1])),d(e[1]),a.shear/=a.scaley;var f=-e[0][1],g=e[1][1];return 0>g?(a.rotate=c.deg(N.acos(g)),0>f&&(a.rotate=360-a.rotate)):a.rotate=c.deg(N.asin(f)),a.isSimple=!(+a.shear.toFixed(9)||a.scalex.toFixed(9)!=a.scaley.toFixed(9)&&a.rotate),a.isSuperSimple=!+a.shear.toFixed(9)&&a.scalex.toFixed(9)==a.scaley.toFixed(9)&&!a.rotate,a.noRotation=!+a.shear.toFixed(9)&&!a.rotate,a},a.toTransformString=function(a){var b=a||this[J]();return b.isSimple?(b.scalex=+b.scalex.toFixed(4),b.scaley=+b.scaley.toFixed(4),b.rotate=+b.rotate.toFixed(4),(b.dx||b.dy?"t"+[b.dx,b.dy]:G)+(1!=b.scalex||1!=b.scaley?"s"+[b.scalex,b.scaley,0,0]:G)+(b.rotate?"r"+[b.rotate,0,0]:G)):"m"+[this.get(0),this.get(1),this.get(2),this.get(3),this.get(4),this.get(5)]}}(o.prototype);var Qb=navigator.userAgent.match(/Version\/(.*?)\s/)||navigator.userAgent.match(/Chrome\/(\d+)/);v.safari="Apple Computer, Inc."==navigator.vendor&&(Qb&&Qb[1]<4||"iP"==navigator.platform.slice(0,2))||"Google Inc."==navigator.vendor&&Qb&&Qb[1]<8?function(){var a=this.rect(-99,-99,this.width+99,this.height+99).attr({stroke:"none"});setTimeout(function(){a.remove()})}:mb;for(var Rb=function(){this.returnValue=!1},Sb=function(){return this.originalEvent.preventDefault()},Tb=function(){this.cancelBubble=!0},Ub=function(){return this.originalEvent.stopPropagation()},Vb=function(a){var b=A.doc.documentElement.scrollTop||A.doc.body.scrollTop,c=A.doc.documentElement.scrollLeft||A.doc.body.scrollLeft;return{x:a.clientX+c,y:a.clientY+b}},Wb=function(){return A.doc.addEventListener?function(a,b,c,d){var e=function(a){var b=Vb(a);return c.call(d,a,b.x,b.y)};if(a.addEventListener(b,e,!1),F&&L[b]){var f=function(b){for(var e=Vb(b),f=b,g=0,h=b.targetTouches&&b.targetTouches.length;h>g;g++)if(b.targetTouches[g].target==a){b=b.targetTouches[g],b.originalEvent=f,b.preventDefault=Sb,b.stopPropagation=Ub;break}return c.call(d,b,e.x,e.y)};a.addEventListener(L[b],f,!1)}return function(){return a.removeEventListener(b,e,!1),F&&L[b]&&a.removeEventListener(L[b],e,!1),!0}}:A.doc.attachEvent?function(a,b,c,d){var e=function(a){a=a||A.win.event;var b=A.doc.documentElement.scrollTop||A.doc.body.scrollTop,e=A.doc.documentElement.scrollLeft||A.doc.body.scrollLeft,f=a.clientX+e,g=a.clientY+b;return a.preventDefault=a.preventDefault||Rb,a.stopPropagation=a.stopPropagation||Tb,c.call(d,a,f,g)};a.attachEvent("on"+b,e);var f=function(){return a.detachEvent("on"+b,e),!0};return f}:void 0}(),Xb=[],Yb=function(a){for(var c,d=a.clientX,e=a.clientY,f=A.doc.documentElement.scrollTop||A.doc.body.scrollTop,g=A.doc.documentElement.scrollLeft||A.doc.body.scrollLeft,h=Xb.length;h--;){if(c=Xb[h],F&&a.touches){for(var i,j=a.touches.length;j--;)if(i=a.touches[j],i.identifier==c.el._drag.id){d=i.clientX,e=i.clientY,(a.originalEvent?a.originalEvent:a).preventDefault();break}}else a.preventDefault();var k,l=c.el.node,m=l.nextSibling,n=l.parentNode,o=l.style.display;A.win.opera&&n.removeChild(l),l.style.display="none",k=c.el.paper.getElementByPoint(d,e),l.style.display=o,A.win.opera&&(m?n.insertBefore(l,m):n.appendChild(l)),k&&b("raphael.drag.over."+c.el.id,c.el,k),d+=g,e+=f,b("raphael.drag.move."+c.el.id,c.move_scope||c.el,d-c.el._drag.x,e-c.el._drag.y,d,e,a)}},Zb=function(a){c.unmousemove(Yb).unmouseup(Zb);for(var d,e=Xb.length;e--;)d=Xb[e],d.el._drag={},b("raphael.drag.end."+d.el.id,d.end_scope||d.start_scope||d.move_scope||d.el,a);Xb=[]},$b=c.el={},_b=K.length;_b--;)!function(a){c[a]=$b[a]=function(b,d){return c.is(b,"function")&&(this.events=this.events||[],this.events.push({name:a,f:b,unbind:Wb(this.shape||this.node||A.doc,a,b,d||this)})),this},c["un"+a]=$b["un"+a]=function(b){for(var d=this.events||[],e=d.length;e--;)d[e].name!=a||!c.is(b,"undefined")&&d[e].f!=b||(d[e].unbind(),d.splice(e,1),!d.length&&delete this.events);return this}}(K[_b]);$b.data=function(a,d){var e=kb[this.id]=kb[this.id]||{};if(0==arguments.length)return e;if(1==arguments.length){if(c.is(a,"object")){for(var f in a)a[z](f)&&this.data(f,a[f]);return this}return b("raphael.data.get."+this.id,this,e[a],a),e[a]}return e[a]=d,b("raphael.data.set."+this.id,this,d,a),this},$b.removeData=function(a){return null==a?kb[this.id]={}:kb[this.id]&&delete kb[this.id][a],this},$b.getData=function(){return d(kb[this.id]||{})},$b.hover=function(a,b,c,d){return this.mouseover(a,c).mouseout(b,d||c)},$b.unhover=function(a,b){return this.unmouseover(a).unmouseout(b)};var ac=[];$b.drag=function(a,d,e,f,g,h){function i(i){(i.originalEvent||i).preventDefault();var j=i.clientX,k=i.clientY,l=A.doc.documentElement.scrollTop||A.doc.body.scrollTop,m=A.doc.documentElement.scrollLeft||A.doc.body.scrollLeft;if(this._drag.id=i.identifier,F&&i.touches)for(var n,o=i.touches.length;o--;)if(n=i.touches[o],this._drag.id=n.identifier,n.identifier==this._drag.id){j=n.clientX,k=n.clientY;break}this._drag.x=j+m,this._drag.y=k+l,!Xb.length&&c.mousemove(Yb).mouseup(Zb),Xb.push({el:this,move_scope:f,start_scope:g,end_scope:h}),d&&b.on("raphael.drag.start."+this.id,d),a&&b.on("raphael.drag.move."+this.id,a),e&&b.on("raphael.drag.end."+this.id,e),b("raphael.drag.start."+this.id,g||f||this,i.clientX+m,i.clientY+l,i)}return this._drag={},ac.push({el:this,start:i}),this.mousedown(i),this},$b.onDragOver=function(a){a?b.on("raphael.drag.over."+this.id,a):b.unbind("raphael.drag.over."+this.id)},$b.undrag=function(){for(var a=ac.length;a--;)ac[a].el==this&&(this.unmousedown(ac[a].start),ac.splice(a,1),b.unbind("raphael.drag.*."+this.id));!ac.length&&c.unmousemove(Yb).unmouseup(Zb),Xb=[]},v.circle=function(a,b,d){var e=c._engine.circle(this,a||0,b||0,d||0);return this.__set__&&this.__set__.push(e),e},v.rect=function(a,b,d,e,f){var g=c._engine.rect(this,a||0,b||0,d||0,e||0,f||0);return this.__set__&&this.__set__.push(g),g},v.ellipse=function(a,b,d,e){var f=c._engine.ellipse(this,a||0,b||0,d||0,e||0);return this.__set__&&this.__set__.push(f),f},v.path=function(a){a&&!c.is(a,U)&&!c.is(a[0],V)&&(a+=G);var b=c._engine.path(c.format[D](c,arguments),this);return this.__set__&&this.__set__.push(b),b},v.image=function(a,b,d,e,f){var g=c._engine.image(this,a||"about:blank",b||0,d||0,e||0,f||0);return this.__set__&&this.__set__.push(g),g},v.text=function(a,b,d){var e=c._engine.text(this,a||0,b||0,I(d));return this.__set__&&this.__set__.push(e),e},v.set=function(a){!c.is(a,"array")&&(a=Array.prototype.splice.call(arguments,0,arguments.length));var b=new mc(a);return this.__set__&&this.__set__.push(b),b.paper=this,b.type="set",b},v.setStart=function(a){this.__set__=a||this.set()},v.setFinish=function(){var a=this.__set__;return delete this.__set__,a},v.setSize=function(a,b){return c._engine.setSize.call(this,a,b)},v.setViewBox=function(a,b,d,e,f){return c._engine.setViewBox.call(this,a,b,d,e,f)},v.top=v.bottom=null,v.raphael=c;var bc=function(a){var b=a.getBoundingClientRect(),c=a.ownerDocument,d=c.body,e=c.documentElement,f=e.clientTop||d.clientTop||0,g=e.clientLeft||d.clientLeft||0,h=b.top+(A.win.pageYOffset||e.scrollTop||d.scrollTop)-f,i=b.left+(A.win.pageXOffset||e.scrollLeft||d.scrollLeft)-g;return{y:h,x:i}};v.getElementByPoint=function(a,b){var c=this,d=c.canvas,e=A.doc.elementFromPoint(a,b);if(A.win.opera&&"svg"==e.tagName){var f=bc(d),g=d.createSVGRect();g.x=a-f.x,g.y=b-f.y,g.width=g.height=1;var h=d.getIntersectionList(g,null);h.length&&(e=h[h.length-1])}if(!e)return null;for(;e.parentNode&&e!=d.parentNode&&!e.raphael;)e=e.parentNode;return e==c.canvas.parentNode&&(e=d),e=e&&e.raphael?c.getById(e.raphaelid):null},v.getElementsByBBox=function(a){var b=this.set();return this.forEach(function(d){c.isBBoxIntersect(d.getBBox(),a)&&b.push(d)}),b},v.getById=function(a){for(var b=this.bottom;b;){if(b.id==a)return b;b=b.next}return null},v.forEach=function(a,b){for(var c=this.bottom;c;){if(a.call(b,c)===!1)return this;c=c.next}return this},v.getElementsByPoint=function(a,b){var c=this.set();return this.forEach(function(d){d.isPointInside(a,b)&&c.push(d)}),c},$b.isPointInside=function(a,b){var d=this.realPath=qb[this.type](this);return this.attr("transform")&&this.attr("transform").length&&(d=c.transformPath(d,this.attr("transform"))),c.isPointInsidePath(d,a,b)},$b.getBBox=function(a){if(this.removed)return{};var b=this._;return a?((b.dirty||!b.bboxwt)&&(this.realPath=qb[this.type](this),b.bboxwt=Bb(this.realPath),b.bboxwt.toString=p,b.dirty=0),b.bboxwt):((b.dirty||b.dirtyT||!b.bbox)&&((b.dirty||!this.realPath)&&(b.bboxwt=0,this.realPath=qb[this.type](this)),b.bbox=Bb(rb(this.realPath,this.matrix)),b.bbox.toString=p,b.dirty=b.dirtyT=0),b.bbox)},$b.clone=function(){if(this.removed)return null;var a=this.paper[this.type]().attr(this.attr());return this.__set__&&this.__set__.push(a),a},$b.glow=function(a){if("text"==this.type)return null;a=a||{};var b={width:(a.width||10)+(+this.attr("stroke-width")||1),fill:a.fill||!1,opacity:a.opacity||.5,offsetx:a.offsetx||0,offsety:a.offsety||0,color:a.color||"#000"},c=b.width/2,d=this.paper,e=d.set(),f=this.realPath||qb[this.type](this);f=this.matrix?rb(f,this.matrix):f;for(var g=1;c+1>g;g++)e.push(d.path(f).attr({stroke:b.color,fill:b.fill?b.color:"none","stroke-linejoin":"round","stroke-linecap":"round","stroke-width":+(b.width/c*g).toFixed(3),opacity:+(b.opacity/c).toFixed(3)}));return e.insertBefore(this).translate(b.offsetx,b.offsety)};var cc=function(a,b,d,e,f,g,h,i,l){return null==l?j(a,b,d,e,f,g,h,i):c.findDotsAtSegment(a,b,d,e,f,g,h,i,k(a,b,d,e,f,g,h,i,l))},dc=function(a,b){return function(d,e,f){d=Kb(d);for(var g,h,i,j,k,l="",m={},n=0,o=0,p=d.length;p>o;o++){if(i=d[o],"M"==i[0])g=+i[1],h=+i[2];else{if(j=cc(g,h,i[1],i[2],i[3],i[4],i[5],i[6]),n+j>e){if(b&&!m.start){if(k=cc(g,h,i[1],i[2],i[3],i[4],i[5],i[6],e-n),l+=["C"+k.start.x,k.start.y,k.m.x,k.m.y,k.x,k.y],f)return l;m.start=l,l=["M"+k.x,k.y+"C"+k.n.x,k.n.y,k.end.x,k.end.y,i[5],i[6]].join(),n+=j,g=+i[5],h=+i[6];continue}if(!a&&!b)return k=cc(g,h,i[1],i[2],i[3],i[4],i[5],i[6],e-n),{x:k.x,y:k.y,alpha:k.alpha}}n+=j,g=+i[5],h=+i[6]}l+=i.shift()+i}return m.end=l,k=a?n:b?m:c.findDotsAtSegment(g,h,i[0],i[1],i[2],i[3],i[4],i[5],1),k.alpha&&(k={x:k.x,y:k.y,alpha:k.alpha}),k}},ec=dc(1),fc=dc(),gc=dc(0,1);c.getTotalLength=ec,c.getPointAtLength=fc,c.getSubpath=function(a,b,c){if(this.getTotalLength(a)-c<1e-6)return gc(a,b).end;var d=gc(a,c,1);return b?gc(d,b).end:d},$b.getTotalLength=function(){var a=this.getPath();if(a)return this.node.getTotalLength?this.node.getTotalLength():ec(a)},$b.getPointAtLength=function(a){var b=this.getPath();if(b)return fc(b,a)},$b.getPath=function(){var a,b=c._getPath[this.type];if("text"!=this.type&&"set"!=this.type)return b&&(a=b(this)),a},$b.getSubpath=function(a,b){var d=this.getPath();if(d)return c.getSubpath(d,a,b)};var hc=c.easing_formulas={linear:function(a){return a},"<":function(a){return R(a,1.7)},">":function(a){return R(a,.48)},"<>":function(a){var b=.48-a/1.04,c=N.sqrt(.1734+b*b),d=c-b,e=R(Q(d),1/3)*(0>d?-1:1),f=-c-b,g=R(Q(f),1/3)*(0>f?-1:1),h=e+g+.5;return 3*(1-h)*h*h+h*h*h},backIn:function(a){var b=1.70158;return a*a*((b+1)*a-b)},backOut:function(a){a-=1;var b=1.70158;return a*a*((b+1)*a+b)+1},elastic:function(a){return a==!!a?a:R(2,-10*a)*N.sin((a-.075)*2*S/.3)+1},bounce:function(a){var b,c=7.5625,d=2.75;return 1/d>a?b=c*a*a:2/d>a?(a-=1.5/d,b=c*a*a+.75):2.5/d>a?(a-=2.25/d,b=c*a*a+.9375):(a-=2.625/d,b=c*a*a+.984375),b}};hc.easeIn=hc["ease-in"]=hc["<"],hc.easeOut=hc["ease-out"]=hc[">"],hc.easeInOut=hc["ease-in-out"]=hc["<>"],hc["back-in"]=hc.backIn,hc["back-out"]=hc.backOut;var ic=[],jc=a.requestAnimationFrame||a.webkitRequestAnimationFrame||a.mozRequestAnimationFrame||a.oRequestAnimationFrame||a.msRequestAnimationFrame||function(a){setTimeout(a,16)},kc=function(){for(var a=+new Date,d=0;d<ic.length;d++){var e=ic[d];if(!e.el.removed&&!e.paused){var f,g,h=a-e.start,i=e.ms,j=e.easing,k=e.from,l=e.diff,m=e.to,n=(e.t,e.el),o={},p={};if(e.initstatus?(h=(e.initstatus*e.anim.top-e.prev)/(e.percent-e.prev)*i,e.status=e.initstatus,delete e.initstatus,e.stop&&ic.splice(d--,1)):e.status=(e.prev+(e.percent-e.prev)*(h/i))/e.anim.top,!(0>h))if(i>h){var q=j(h/i);for(var r in k)if(k[z](r)){switch(db[r]){case T:f=+k[r]+q*i*l[r];break;case"colour":f="rgb("+[lc($(k[r].r+q*i*l[r].r)),lc($(k[r].g+q*i*l[r].g)),lc($(k[r].b+q*i*l[r].b))].join(",")+")";break;case"path":f=[];for(var t=0,u=k[r].length;u>t;t++){f[t]=[k[r][t][0]];for(var v=1,w=k[r][t].length;w>v;v++)f[t][v]=+k[r][t][v]+q*i*l[r][t][v];f[t]=f[t].join(H)}f=f.join(H);break;case"transform":if(l[r].real)for(f=[],t=0,u=k[r].length;u>t;t++)for(f[t]=[k[r][t][0]],v=1,w=k[r][t].length;w>v;v++)f[t][v]=k[r][t][v]+q*i*l[r][t][v];else{var x=function(a){return+k[r][a]+q*i*l[r][a]};f=[["m",x(0),x(1),x(2),x(3),x(4),x(5)]]}break;case"csv":if("clip-rect"==r)for(f=[],t=4;t--;)f[t]=+k[r][t]+q*i*l[r][t];break;default:var y=[][E](k[r]);for(f=[],t=n.paper.customAttributes[r].length;t--;)f[t]=+y[t]+q*i*l[r][t]}o[r]=f}n.attr(o),function(a,c,d){setTimeout(function(){b("raphael.anim.frame."+a,c,d)})}(n.id,n,e.anim)}else{if(function(a,d,e){setTimeout(function(){b("raphael.anim.frame."+d.id,d,e),b("raphael.anim.finish."+d.id,d,e),c.is(a,"function")&&a.call(d)})}(e.callback,n,e.anim),n.attr(m),ic.splice(d--,1),e.repeat>1&&!e.next){for(g in m)m[z](g)&&(p[g]=e.totalOrigin[g]);e.el.attr(p),s(e.anim,e.el,e.anim.percents[0],null,e.totalOrigin,e.repeat-1)}e.next&&!e.stop&&s(e.anim,e.el,e.next,null,e.totalOrigin,e.repeat)}}}c.svg&&n&&n.paper&&n.paper.safari(),ic.length&&jc(kc)},lc=function(a){return a>255?255:0>a?0:a};$b.animateWith=function(a,b,d,e,f,g){var h=this;if(h.removed)return g&&g.call(h),h;var i=d instanceof r?d:c.animation(d,e,f,g);s(i,h,i.percents[0],null,h.attr());for(var j=0,k=ic.length;k>j;j++)if(ic[j].anim==b&&ic[j].el==a){ic[k-1].start=ic[j].start;break}return h},$b.onAnimation=function(a){return a?b.on("raphael.anim.frame."+this.id,a):b.unbind("raphael.anim.frame."+this.id),this},r.prototype.delay=function(a){var b=new r(this.anim,this.ms);return b.times=this.times,b.del=+a||0,b},r.prototype.repeat=function(a){var b=new r(this.anim,this.ms);return b.del=this.del,b.times=N.floor(O(a,0))||1,b},c.animation=function(a,b,d,e){if(a instanceof r)return a;(c.is(d,"function")||!d)&&(e=e||d||null,d=null),a=Object(a),b=+b||0;var f,g,h={};for(g in a)a[z](g)&&_(g)!=g&&_(g)+"%"!=g&&(f=!0,h[g]=a[g]);return f?(d&&(h.easing=d),e&&(h.callback=e),new r({100:h},b)):new r(a,b)},$b.animate=function(a,b,d,e){var f=this;if(f.removed)return e&&e.call(f),f;var g=a instanceof r?a:c.animation(a,b,d,e);return s(g,f,g.percents[0],null,f.attr()),f},$b.setTime=function(a,b){return a&&null!=b&&this.status(a,P(b,a.ms)/a.ms),this},$b.status=function(a,b){var c,d,e=[],f=0;if(null!=b)return s(a,this,-1,P(b,1)),this;for(c=ic.length;c>f;f++)if(d=ic[f],d.el.id==this.id&&(!a||d.anim==a)){if(a)return d.status;e.push({anim:d.anim,status:d.status})}return a?0:e},$b.pause=function(a){for(var c=0;c<ic.length;c++)ic[c].el.id!=this.id||a&&ic[c].anim!=a||b("raphael.anim.pause."+this.id,this,ic[c].anim)!==!1&&(ic[c].paused=!0);return this},$b.resume=function(a){for(var c=0;c<ic.length;c++)if(ic[c].el.id==this.id&&(!a||ic[c].anim==a)){var d=ic[c];b("raphael.anim.resume."+this.id,this,d.anim)!==!1&&(delete d.paused,this.status(d.anim,d.status))}return this},$b.stop=function(a){for(var c=0;c<ic.length;c++)ic[c].el.id!=this.id||a&&ic[c].anim!=a||b("raphael.anim.stop."+this.id,this,ic[c].anim)!==!1&&ic.splice(c--,1);return this},b.on("raphael.remove",t),b.on("raphael.clear",t),$b.toString=function(){return"Raphaël’s object"};var mc=function(a){if(this.items=[],this.length=0,this.type="set",a)for(var b=0,c=a.length;c>b;b++)!a[b]||a[b].constructor!=$b.constructor&&a[b].constructor!=mc||(this[this.items.length]=this.items[this.items.length]=a[b],this.length++)},nc=mc.prototype;nc.push=function(){for(var a,b,c=0,d=arguments.length;d>c;c++)a=arguments[c],!a||a.constructor!=$b.constructor&&a.constructor!=mc||(b=this.items.length,this[b]=this.items[b]=a,this.length++);return this},nc.pop=function(){return this.length&&delete this[this.length--],this.items.pop()},nc.forEach=function(a,b){for(var c=0,d=this.items.length;d>c;c++)if(a.call(b,this.items[c],c)===!1)return this;return this};for(var oc in $b)$b[z](oc)&&(nc[oc]=function(a){return function(){var b=arguments;return this.forEach(function(c){c[a][D](c,b)})}}(oc));return nc.attr=function(a,b){if(a&&c.is(a,V)&&c.is(a[0],"object"))for(var d=0,e=a.length;e>d;d++)this.items[d].attr(a[d]);else for(var f=0,g=this.items.length;g>f;f++)this.items[f].attr(a,b);return this},nc.clear=function(){for(;this.length;)this.pop()},nc.splice=function(a,b){a=0>a?O(this.length+a,0):a,b=O(0,P(this.length-a,b));var c,d=[],e=[],f=[];for(c=2;c<arguments.length;c++)f.push(arguments[c]);for(c=0;b>c;c++)e.push(this[a+c]);for(;c<this.length-a;c++)d.push(this[a+c]);var g=f.length;for(c=0;c<g+d.length;c++)this.items[a+c]=this[a+c]=g>c?f[c]:d[c-g];for(c=this.items.length=this.length-=b-g;this[c];)delete this[c++];return new mc(e)},nc.exclude=function(a){for(var b=0,c=this.length;c>b;b++)if(this[b]==a)return this.splice(b,1),!0},nc.animate=function(a,b,d,e){(c.is(d,"function")||!d)&&(e=d||null);var f,g,h=this.items.length,i=h,j=this;if(!h)return this;e&&(g=function(){!--h&&e.call(j)}),d=c.is(d,U)?d:g;var k=c.animation(a,b,d,g);for(f=this.items[--i].animate(k);i--;)this.items[i]&&!this.items[i].removed&&this.items[i].animateWith(f,k,k),this.items[i]&&!this.items[i].removed||h--;return this},nc.insertAfter=function(a){for(var b=this.items.length;b--;)this.items[b].insertAfter(a);return this},nc.getBBox=function(){for(var a=[],b=[],c=[],d=[],e=this.items.length;e--;)if(!this.items[e].removed){var f=this.items[e].getBBox();a.push(f.x),b.push(f.y),c.push(f.x+f.width),d.push(f.y+f.height)}return a=P[D](0,a),b=P[D](0,b),c=O[D](0,c),d=O[D](0,d),{x:a,y:b,x2:c,y2:d,width:c-a,height:d-b}},nc.clone=function(a){a=this.paper.set();for(var b=0,c=this.items.length;c>b;b++)a.push(this.items[b].clone());return a},nc.toString=function(){return"Raphaël‘s set"},nc.glow=function(a){var b=this.paper.set();return this.forEach(function(c){var d=c.glow(a);null!=d&&d.forEach(function(a){b.push(a)})}),b},nc.isPointInside=function(a,b){var c=!1;return this.forEach(function(d){return d.isPointInside(a,b)?(console.log("runned"),c=!0,!1):void 0}),c},c.registerFont=function(a){if(!a.face)return a;this.fonts=this.fonts||{};var b={w:a.w,face:{},glyphs:{}},c=a.face["font-family"];for(var d in a.face)a.face[z](d)&&(b.face[d]=a.face[d]);if(this.fonts[c]?this.fonts[c].push(b):this.fonts[c]=[b],!a.svg){b.face["units-per-em"]=ab(a.face["units-per-em"],10);for(var e in a.glyphs)if(a.glyphs[z](e)){var f=a.glyphs[e];if(b.glyphs[e]={w:f.w,k:{},d:f.d&&"M"+f.d.replace(/[mlcxtrv]/g,function(a){return{l:"L",c:"C",x:"z",t:"m",r:"l",v:"c"}[a]||"M"})+"z"},f.k)for(var g in f.k)f[z](g)&&(b.glyphs[e].k[g]=f.k[g])}}return a},v.getFont=function(a,b,d,e){if(e=e||"normal",d=d||"normal",b=+b||{normal:400,bold:700,lighter:300,bolder:800}[b]||400,c.fonts){var f=c.fonts[a];if(!f){var g=new RegExp("(^|\\s)"+a.replace(/[^\w\d\s+!~.:_-]/g,G)+"(\\s|$)","i");for(var h in c.fonts)if(c.fonts[z](h)&&g.test(h)){f=c.fonts[h];break}}var i;if(f)for(var j=0,k=f.length;k>j&&(i=f[j],i.face["font-weight"]!=b||i.face["font-style"]!=d&&i.face["font-style"]||i.face["font-stretch"]!=e);j++);return i}},v.print=function(a,b,d,e,f,g,h,i){g=g||"middle",h=O(P(h||0,1),-1),i=O(P(i||1,3),1);var j,k=I(d)[J](G),l=0,m=0,n=G;if(c.is(e,"string")&&(e=this.getFont(e)),e){j=(f||16)/e.face["units-per-em"];for(var o=e.face.bbox[J](w),p=+o[0],q=o[3]-o[1],r=0,s=+o[1]+("baseline"==g?q+ +e.face.descent:q/2),t=0,u=k.length;u>t;t++){if("\n"==k[t])l=0,x=0,m=0,r+=q*i;else{var v=m&&e.glyphs[k[t-1]]||{},x=e.glyphs[k[t]];l+=m?(v.w||e.w)+(v.k&&v.k[k[t]]||0)+e.w*h:0,m=1}x&&x.d&&(n+=c.transformPath(x.d,["t",l*j,r*j,"s",j,j,p,s,"t",(a-p)/j,(b-s)/j]))}}return this.path(n).attr({fill:"#000",stroke:"none"})},v.add=function(a){if(c.is(a,"array"))for(var b,d=this.set(),e=0,f=a.length;f>e;e++)b=a[e]||{},x[z](b.type)&&d.push(this[b.type]().attr(b));return d},c.format=function(a,b){var d=c.is(b,V)?[0][E](b):arguments;return a&&c.is(a,U)&&d.length-1&&(a=a.replace(y,function(a,b){return null==d[++b]?G:d[b]})),a||G},c.fullfill=function(){var a=/\{([^\}]+)\}/g,b=/(?:(?:^|\.)(.+?)(?=\[|\.|$|\()|\[('|")(.+?)\2\])(\(\))?/g,c=function(a,c,d){var e=d;return c.replace(b,function(a,b,c,d,f){b=b||d,e&&(b in e&&(e=e[b]),"function"==typeof e&&f&&(e=e()))}),e=(null==e||e==d?a:e)+""};return function(b,d){return String(b).replace(a,function(a,b){return c(a,b,d)})}}(),c.ninja=function(){return B.was?A.win.Raphael=B.is:delete Raphael,c},c.st=nc,function(a,b,d){function e(){/in/.test(a.readyState)?setTimeout(e,9):c.eve("raphael.DOMload")}null==a.readyState&&a.addEventListener&&(a.addEventListener(b,d=function(){a.removeEventListener(b,d,!1),a.readyState="complete"},!1),a.readyState="loading"),e()}(document,"DOMContentLoaded"),b.on("raphael.DOMload",function(){u=!0}),function(){if(c.svg){var a="hasOwnProperty",b=String,d=parseFloat,e=parseInt,f=Math,g=f.max,h=f.abs,i=f.pow,j=/[, ]+/,k=c.eve,l="",m=" ",n="http://www.w3.org/1999/xlink",o={block:"M5,0 0,2.5 5,5z",classic:"M5,0 0,2.5 5,5 3.5,3 3.5,2z",diamond:"M2.5,0 5,2.5 2.5,5 0,2.5z",open:"M6,1 1,3.5 6,6",oval:"M2.5,0A2.5,2.5,0,0,1,2.5,5 2.5,2.5,0,0,1,2.5,0z"},p={};c.toString=function(){return"Your browser supports SVG.\nYou are running Raphaël "+this.version};var q=function(d,e){if(e){"string"==typeof d&&(d=q(d));for(var f in e)e[a](f)&&("xlink:"==f.substring(0,6)?d.setAttributeNS(n,f.substring(6),b(e[f])):d.setAttribute(f,b(e[f])))}else d=c._g.doc.createElementNS("http://www.w3.org/2000/svg",d),d.style&&(d.style.webkitTapHighlightColor="rgba(0,0,0,0)");return d},r=function(a,e){var j="linear",k=a.id+e,m=.5,n=.5,o=a.node,p=a.paper,r=o.style,s=c._g.doc.getElementById(k);if(!s){if(e=b(e).replace(c._radial_gradient,function(a,b,c){if(j="radial",b&&c){m=d(b),n=d(c);var e=2*(n>.5)-1;i(m-.5,2)+i(n-.5,2)>.25&&(n=f.sqrt(.25-i(m-.5,2))*e+.5)&&.5!=n&&(n=n.toFixed(5)-1e-5*e)}return l}),e=e.split(/\s*\-\s*/),"linear"==j){var t=e.shift();if(t=-d(t),isNaN(t))return null;var u=[0,0,f.cos(c.rad(t)),f.sin(c.rad(t))],v=1/(g(h(u[2]),h(u[3]))||1);u[2]*=v,u[3]*=v,u[2]<0&&(u[0]=-u[2],u[2]=0),u[3]<0&&(u[1]=-u[3],u[3]=0)}var w=c._parseDots(e);if(!w)return null;if(k=k.replace(/[\(\)\s,\xb0#]/g,"_"),a.gradient&&k!=a.gradient.id&&(p.defs.removeChild(a.gradient),delete a.gradient),!a.gradient){s=q(j+"Gradient",{id:k}),a.gradient=s,q(s,"radial"==j?{fx:m,fy:n}:{x1:u[0],y1:u[1],x2:u[2],y2:u[3],gradientTransform:a.matrix.invert()}),p.defs.appendChild(s);for(var x=0,y=w.length;y>x;x++)s.appendChild(q("stop",{offset:w[x].offset?w[x].offset:x?"100%":"0%","stop-color":w[x].color||"#fff"}))}}return q(o,{fill:"url(#"+k+")",opacity:1,"fill-opacity":1}),r.fill=l,r.opacity=1,r.fillOpacity=1,1},s=function(a){var b=a.getBBox(1);q(a.pattern,{patternTransform:a.matrix.invert()+" translate("+b.x+","+b.y+")"})},t=function(d,e,f){if("path"==d.type){for(var g,h,i,j,k,m=b(e).toLowerCase().split("-"),n=d.paper,r=f?"end":"start",s=d.node,t=d.attrs,u=t["stroke-width"],v=m.length,w="classic",x=3,y=3,z=5;v--;)switch(m[v]){case"block":case"classic":case"oval":case"diamond":case"open":case"none":w=m[v];break;case"wide":y=5;break;case"narrow":y=2;break;case"long":x=5;break;case"short":x=2}if("open"==w?(x+=2,y+=2,z+=2,i=1,j=f?4:1,k={fill:"none",stroke:t.stroke}):(j=i=x/2,k={fill:t.stroke,stroke:"none"}),d._.arrows?f?(d._.arrows.endPath&&p[d._.arrows.endPath]--,d._.arrows.endMarker&&p[d._.arrows.endMarker]--):(d._.arrows.startPath&&p[d._.arrows.startPath]--,d._.arrows.startMarker&&p[d._.arrows.startMarker]--):d._.arrows={},"none"!=w){var A="raphael-marker-"+w,B="raphael-marker-"+r+w+x+y;c._g.doc.getElementById(A)?p[A]++:(n.defs.appendChild(q(q("path"),{"stroke-linecap":"round",d:o[w],id:A})),p[A]=1);var C,D=c._g.doc.getElementById(B);D?(p[B]++,C=D.getElementsByTagName("use")[0]):(D=q(q("marker"),{id:B,markerHeight:y,markerWidth:x,orient:"auto",refX:j,refY:y/2}),C=q(q("use"),{"xlink:href":"#"+A,transform:(f?"rotate(180 "+x/2+" "+y/2+") ":l)+"scale("+x/z+","+y/z+")","stroke-width":(1/((x/z+y/z)/2)).toFixed(4)}),D.appendChild(C),n.defs.appendChild(D),p[B]=1),q(C,k);var E=i*("diamond"!=w&&"oval"!=w);f?(g=d._.arrows.startdx*u||0,h=c.getTotalLength(t.path)-E*u):(g=E*u,h=c.getTotalLength(t.path)-(d._.arrows.enddx*u||0)),k={},k["marker-"+r]="url(#"+B+")",(h||g)&&(k.d=c.getSubpath(t.path,g,h)),q(s,k),d._.arrows[r+"Path"]=A,d._.arrows[r+"Marker"]=B,d._.arrows[r+"dx"]=E,d._.arrows[r+"Type"]=w,d._.arrows[r+"String"]=e}else f?(g=d._.arrows.startdx*u||0,h=c.getTotalLength(t.path)-g):(g=0,h=c.getTotalLength(t.path)-(d._.arrows.enddx*u||0)),d._.arrows[r+"Path"]&&q(s,{d:c.getSubpath(t.path,g,h)}),delete d._.arrows[r+"Path"],delete d._.arrows[r+"Marker"],delete d._.arrows[r+"dx"],delete d._.arrows[r+"Type"],delete d._.arrows[r+"String"];for(k in p)if(p[a](k)&&!p[k]){var F=c._g.doc.getElementById(k);F&&F.parentNode.removeChild(F)}}},u={"":[0],none:[0],"-":[3,1],".":[1,1],"-.":[3,1,1,1],"-..":[3,1,1,1,1,1],". ":[1,3],"- ":[4,3],"--":[8,3],"- .":[4,3,1,3],"--.":[8,3,1,3],"--..":[8,3,1,3,1,3]},v=function(a,c,d){if(c=u[b(c).toLowerCase()]){for(var e=a.attrs["stroke-width"]||"1",f={round:e,square:e,butt:0}[a.attrs["stroke-linecap"]||d["stroke-linecap"]]||0,g=[],h=c.length;h--;)g[h]=c[h]*e+(h%2?1:-1)*f;q(a.node,{"stroke-dasharray":g.join(",")})}},w=function(d,f){var i=d.node,k=d.attrs,m=i.style.visibility;i.style.visibility="hidden";for(var o in f)if(f[a](o)){if(!c._availableAttrs[a](o))continue;var p=f[o];switch(k[o]=p,o){case"blur":d.blur(p);break;case"href":case"title":var u=q("title"),w=c._g.doc.createTextNode(p);u.appendChild(w),i.appendChild(u);break;case"target":var x=i.parentNode;if("a"!=x.tagName.toLowerCase()){var u=q("a");x.insertBefore(u,i),u.appendChild(i),x=u}"target"==o?x.setAttributeNS(n,"show","blank"==p?"new":p):x.setAttributeNS(n,o,p);break;case"cursor":i.style.cursor=p;break;case"transform":d.transform(p);break;case"arrow-start":t(d,p);break;case"arrow-end":t(d,p,1);break;case"clip-rect":var z=b(p).split(j);if(4==z.length){d.clip&&d.clip.parentNode.parentNode.removeChild(d.clip.parentNode);var A=q("clipPath"),B=q("rect");A.id=c.createUUID(),q(B,{x:z[0],y:z[1],width:z[2],height:z[3]}),A.appendChild(B),d.paper.defs.appendChild(A),q(i,{"clip-path":"url(#"+A.id+")"}),d.clip=B}if(!p){var C=i.getAttribute("clip-path");if(C){var D=c._g.doc.getElementById(C.replace(/(^url\(#|\)$)/g,l));D&&D.parentNode.removeChild(D),q(i,{"clip-path":l}),delete d.clip}}break;case"path":"path"==d.type&&(q(i,{d:p?k.path=c._pathToAbsolute(p):"M0,0"}),d._.dirty=1,d._.arrows&&("startString"in d._.arrows&&t(d,d._.arrows.startString),"endString"in d._.arrows&&t(d,d._.arrows.endString,1)));break;case"width":if(i.setAttribute(o,p),d._.dirty=1,!k.fx)break;o="x",p=k.x;case"x":k.fx&&(p=-k.x-(k.width||0));case"rx":if("rx"==o&&"rect"==d.type)break;case"cx":i.setAttribute(o,p),d.pattern&&s(d),d._.dirty=1;break;case"height":if(i.setAttribute(o,p),d._.dirty=1,!k.fy)break;o="y",p=k.y;case"y":k.fy&&(p=-k.y-(k.height||0));case"ry":if("ry"==o&&"rect"==d.type)break;case"cy":i.setAttribute(o,p),d.pattern&&s(d),d._.dirty=1;break;case"r":"rect"==d.type?q(i,{rx:p,ry:p}):i.setAttribute(o,p),d._.dirty=1;break;case"src":"image"==d.type&&i.setAttributeNS(n,"href",p);break;case"stroke-width":(1!=d._.sx||1!=d._.sy)&&(p/=g(h(d._.sx),h(d._.sy))||1),d.paper._vbSize&&(p*=d.paper._vbSize),i.setAttribute(o,p),k["stroke-dasharray"]&&v(d,k["stroke-dasharray"],f),d._.arrows&&("startString"in d._.arrows&&t(d,d._.arrows.startString),"endString"in d._.arrows&&t(d,d._.arrows.endString,1));break;case"stroke-dasharray":v(d,p,f);break;case"fill":var E=b(p).match(c._ISURL);if(E){A=q("pattern");var F=q("image");A.id=c.createUUID(),q(A,{x:0,y:0,patternUnits:"userSpaceOnUse",height:1,width:1}),q(F,{x:0,y:0,"xlink:href":E[1]}),A.appendChild(F),function(a){c._preload(E[1],function(){var b=this.offsetWidth,c=this.offsetHeight;q(a,{width:b,height:c}),q(F,{width:b,height:c}),d.paper.safari()})}(A),d.paper.defs.appendChild(A),q(i,{fill:"url(#"+A.id+")"}),d.pattern=A,d.pattern&&s(d);break}var G=c.getRGB(p);if(G.error){if(("circle"==d.type||"ellipse"==d.type||"r"!=b(p).charAt())&&r(d,p)){if("opacity"in k||"fill-opacity"in k){var H=c._g.doc.getElementById(i.getAttribute("fill").replace(/^url\(#|\)$/g,l));if(H){var I=H.getElementsByTagName("stop");q(I[I.length-1],{"stop-opacity":("opacity"in k?k.opacity:1)*("fill-opacity"in k?k["fill-opacity"]:1)})}}k.gradient=p,k.fill="none";break}}else delete f.gradient,delete k.gradient,!c.is(k.opacity,"undefined")&&c.is(f.opacity,"undefined")&&q(i,{opacity:k.opacity}),!c.is(k["fill-opacity"],"undefined")&&c.is(f["fill-opacity"],"undefined")&&q(i,{"fill-opacity":k["fill-opacity"]});G[a]("opacity")&&q(i,{"fill-opacity":G.opacity>1?G.opacity/100:G.opacity});case"stroke":G=c.getRGB(p),i.setAttribute(o,G.hex),"stroke"==o&&G[a]("opacity")&&q(i,{"stroke-opacity":G.opacity>1?G.opacity/100:G.opacity}),"stroke"==o&&d._.arrows&&("startString"in d._.arrows&&t(d,d._.arrows.startString),"endString"in d._.arrows&&t(d,d._.arrows.endString,1));break;case"gradient":("circle"==d.type||"ellipse"==d.type||"r"!=b(p).charAt())&&r(d,p);break;case"opacity":k.gradient&&!k[a]("stroke-opacity")&&q(i,{"stroke-opacity":p>1?p/100:p});case"fill-opacity":if(k.gradient){H=c._g.doc.getElementById(i.getAttribute("fill").replace(/^url\(#|\)$/g,l)),H&&(I=H.getElementsByTagName("stop"),q(I[I.length-1],{"stop-opacity":p}));break}default:"font-size"==o&&(p=e(p,10)+"px");var J=o.replace(/(\-.)/g,function(a){return a.substring(1).toUpperCase()});i.style[J]=p,d._.dirty=1,i.setAttribute(o,p)}}y(d,f),i.style.visibility=m},x=1.2,y=function(d,f){if("text"==d.type&&(f[a]("text")||f[a]("font")||f[a]("font-size")||f[a]("x")||f[a]("y"))){var g=d.attrs,h=d.node,i=h.firstChild?e(c._g.doc.defaultView.getComputedStyle(h.firstChild,l).getPropertyValue("font-size"),10):10;
if(f[a]("text")){for(g.text=f.text;h.firstChild;)h.removeChild(h.firstChild);for(var j,k=b(f.text).split("\n"),m=[],n=0,o=k.length;o>n;n++)j=q("tspan"),n&&q(j,{dy:i*x,x:g.x}),j.appendChild(c._g.doc.createTextNode(k[n])),h.appendChild(j),m[n]=j}else for(m=h.getElementsByTagName("tspan"),n=0,o=m.length;o>n;n++)n?q(m[n],{dy:i*x,x:g.x}):q(m[0],{dy:0});q(h,{x:g.x,y:g.y}),d._.dirty=1;var p=d._getBBox(),r=g.y-(p.y+p.height/2);r&&c.is(r,"finite")&&q(m[0],{dy:r})}},z=function(a,b){this[0]=this.node=a,a.raphael=!0,this.id=c._oid++,a.raphaelid=this.id,this.matrix=c.matrix(),this.realPath=null,this.paper=b,this.attrs=this.attrs||{},this._={transform:[],sx:1,sy:1,deg:0,dx:0,dy:0,dirty:1},!b.bottom&&(b.bottom=this),this.prev=b.top,b.top&&(b.top.next=this),b.top=this,this.next=null},A=c.el;z.prototype=A,A.constructor=z,c._engine.path=function(a,b){var c=q("path");b.canvas&&b.canvas.appendChild(c);var d=new z(c,b);return d.type="path",w(d,{fill:"none",stroke:"#000",path:a}),d},A.rotate=function(a,c,e){if(this.removed)return this;if(a=b(a).split(j),a.length-1&&(c=d(a[1]),e=d(a[2])),a=d(a[0]),null==e&&(c=e),null==c||null==e){var f=this.getBBox(1);c=f.x+f.width/2,e=f.y+f.height/2}return this.transform(this._.transform.concat([["r",a,c,e]])),this},A.scale=function(a,c,e,f){if(this.removed)return this;if(a=b(a).split(j),a.length-1&&(c=d(a[1]),e=d(a[2]),f=d(a[3])),a=d(a[0]),null==c&&(c=a),null==f&&(e=f),null==e||null==f)var g=this.getBBox(1);return e=null==e?g.x+g.width/2:e,f=null==f?g.y+g.height/2:f,this.transform(this._.transform.concat([["s",a,c,e,f]])),this},A.translate=function(a,c){return this.removed?this:(a=b(a).split(j),a.length-1&&(c=d(a[1])),a=d(a[0])||0,c=+c||0,this.transform(this._.transform.concat([["t",a,c]])),this)},A.transform=function(b){var d=this._;if(null==b)return d.transform;if(c._extractTransform(this,b),this.clip&&q(this.clip,{transform:this.matrix.invert()}),this.pattern&&s(this),this.node&&q(this.node,{transform:this.matrix}),1!=d.sx||1!=d.sy){var e=this.attrs[a]("stroke-width")?this.attrs["stroke-width"]:1;this.attr({"stroke-width":e})}return this},A.hide=function(){return!this.removed&&this.paper.safari(this.node.style.display="none"),this},A.show=function(){return!this.removed&&this.paper.safari(this.node.style.display=""),this},A.remove=function(){if(!this.removed&&this.node.parentNode){var a=this.paper;a.__set__&&a.__set__.exclude(this),k.unbind("raphael.*.*."+this.id),this.gradient&&a.defs.removeChild(this.gradient),c._tear(this,a),"a"==this.node.parentNode.tagName.toLowerCase()?this.node.parentNode.parentNode.removeChild(this.node.parentNode):this.node.parentNode.removeChild(this.node);for(var b in this)this[b]="function"==typeof this[b]?c._removedFactory(b):null;this.removed=!0}},A._getBBox=function(){if("none"==this.node.style.display){this.show();var a=!0}var b={};try{b=this.node.getBBox()}catch(c){}finally{b=b||{}}return a&&this.hide(),b},A.attr=function(b,d){if(this.removed)return this;if(null==b){var e={};for(var f in this.attrs)this.attrs[a](f)&&(e[f]=this.attrs[f]);return e.gradient&&"none"==e.fill&&(e.fill=e.gradient)&&delete e.gradient,e.transform=this._.transform,e}if(null==d&&c.is(b,"string")){if("fill"==b&&"none"==this.attrs.fill&&this.attrs.gradient)return this.attrs.gradient;if("transform"==b)return this._.transform;for(var g=b.split(j),h={},i=0,l=g.length;l>i;i++)b=g[i],h[b]=b in this.attrs?this.attrs[b]:c.is(this.paper.customAttributes[b],"function")?this.paper.customAttributes[b].def:c._availableAttrs[b];return l-1?h:h[g[0]]}if(null==d&&c.is(b,"array")){for(h={},i=0,l=b.length;l>i;i++)h[b[i]]=this.attr(b[i]);return h}if(null!=d){var m={};m[b]=d}else null!=b&&c.is(b,"object")&&(m=b);for(var n in m)k("raphael.attr."+n+"."+this.id,this,m[n]);for(n in this.paper.customAttributes)if(this.paper.customAttributes[a](n)&&m[a](n)&&c.is(this.paper.customAttributes[n],"function")){var o=this.paper.customAttributes[n].apply(this,[].concat(m[n]));this.attrs[n]=m[n];for(var p in o)o[a](p)&&(m[p]=o[p])}return w(this,m),this},A.toFront=function(){if(this.removed)return this;"a"==this.node.parentNode.tagName.toLowerCase()?this.node.parentNode.parentNode.appendChild(this.node.parentNode):this.node.parentNode.appendChild(this.node);var a=this.paper;return a.top!=this&&c._tofront(this,a),this},A.toBack=function(){if(this.removed)return this;var a=this.node.parentNode;return"a"==a.tagName.toLowerCase()?a.parentNode.insertBefore(this.node.parentNode,this.node.parentNode.parentNode.firstChild):a.firstChild!=this.node&&a.insertBefore(this.node,this.node.parentNode.firstChild),c._toback(this,this.paper),this.paper,this},A.insertAfter=function(a){if(this.removed)return this;var b=a.node||a[a.length-1].node;return b.nextSibling?b.parentNode.insertBefore(this.node,b.nextSibling):b.parentNode.appendChild(this.node),c._insertafter(this,a,this.paper),this},A.insertBefore=function(a){if(this.removed)return this;var b=a.node||a[0].node;return b.parentNode.insertBefore(this.node,b),c._insertbefore(this,a,this.paper),this},A.blur=function(a){var b=this;if(0!==+a){var d=q("filter"),e=q("feGaussianBlur");b.attrs.blur=a,d.id=c.createUUID(),q(e,{stdDeviation:+a||1.5}),d.appendChild(e),b.paper.defs.appendChild(d),b._blur=d,q(b.node,{filter:"url(#"+d.id+")"})}else b._blur&&(b._blur.parentNode.removeChild(b._blur),delete b._blur,delete b.attrs.blur),b.node.removeAttribute("filter");return b},c._engine.circle=function(a,b,c,d){var e=q("circle");a.canvas&&a.canvas.appendChild(e);var f=new z(e,a);return f.attrs={cx:b,cy:c,r:d,fill:"none",stroke:"#000"},f.type="circle",q(e,f.attrs),f},c._engine.rect=function(a,b,c,d,e,f){var g=q("rect");a.canvas&&a.canvas.appendChild(g);var h=new z(g,a);return h.attrs={x:b,y:c,width:d,height:e,r:f||0,rx:f||0,ry:f||0,fill:"none",stroke:"#000"},h.type="rect",q(g,h.attrs),h},c._engine.ellipse=function(a,b,c,d,e){var f=q("ellipse");a.canvas&&a.canvas.appendChild(f);var g=new z(f,a);return g.attrs={cx:b,cy:c,rx:d,ry:e,fill:"none",stroke:"#000"},g.type="ellipse",q(f,g.attrs),g},c._engine.image=function(a,b,c,d,e,f){var g=q("image");q(g,{x:c,y:d,width:e,height:f,preserveAspectRatio:"none"}),g.setAttributeNS(n,"href",b),a.canvas&&a.canvas.appendChild(g);var h=new z(g,a);return h.attrs={x:c,y:d,width:e,height:f,src:b},h.type="image",h},c._engine.text=function(a,b,d,e){var f=q("text");a.canvas&&a.canvas.appendChild(f);var g=new z(f,a);return g.attrs={x:b,y:d,"text-anchor":"middle",text:e,font:c._availableAttrs.font,stroke:"none",fill:"#000"},g.type="text",w(g,g.attrs),g},c._engine.setSize=function(a,b){return this.width=a||this.width,this.height=b||this.height,this.canvas.setAttribute("width",this.width),this.canvas.setAttribute("height",this.height),this._viewBox&&this.setViewBox.apply(this,this._viewBox),this},c._engine.create=function(){var a=c._getContainer.apply(0,arguments),b=a&&a.container,d=a.x,e=a.y,f=a.width,g=a.height;if(!b)throw new Error("SVG container not found.");var h,i=q("svg"),j="overflow:hidden;";return d=d||0,e=e||0,f=f||512,g=g||342,q(i,{height:g,version:1.1,width:f,xmlns:"http://www.w3.org/2000/svg"}),1==b?(i.style.cssText=j+"position:absolute;left:"+d+"px;top:"+e+"px",c._g.doc.body.appendChild(i),h=1):(i.style.cssText=j+"position:relative",b.firstChild?b.insertBefore(i,b.firstChild):b.appendChild(i)),b=new c._Paper,b.width=f,b.height=g,b.canvas=i,b.clear(),b._left=b._top=0,h&&(b.renderfix=function(){}),b.renderfix(),b},c._engine.setViewBox=function(a,b,c,d,e){k("raphael.setViewBox",this,this._viewBox,[a,b,c,d,e]);var f,h,i=g(c/this.width,d/this.height),j=this.top,l=e?"meet":"xMinYMin";for(null==a?(this._vbSize&&(i=1),delete this._vbSize,f="0 0 "+this.width+m+this.height):(this._vbSize=i,f=a+m+b+m+c+m+d),q(this.canvas,{viewBox:f,preserveAspectRatio:l});i&&j;)h="stroke-width"in j.attrs?j.attrs["stroke-width"]:1,j.attr({"stroke-width":h}),j._.dirty=1,j._.dirtyT=1,j=j.prev;return this._viewBox=[a,b,c,d,!!e],this},c.prototype.renderfix=function(){var a,b=this.canvas,c=b.style;try{a=b.getScreenCTM()||b.createSVGMatrix()}catch(d){a=b.createSVGMatrix()}var e=-a.e%1,f=-a.f%1;(e||f)&&(e&&(this._left=(this._left+e)%1,c.left=this._left+"px"),f&&(this._top=(this._top+f)%1,c.top=this._top+"px"))},c.prototype.clear=function(){c.eve("raphael.clear",this);for(var a=this.canvas;a.firstChild;)a.removeChild(a.firstChild);this.bottom=this.top=null,(this.desc=q("desc")).appendChild(c._g.doc.createTextNode("Created with Raphaël "+c.version)),a.appendChild(this.desc),a.appendChild(this.defs=q("defs"))},c.prototype.remove=function(){k("raphael.remove",this),this.canvas.parentNode&&this.canvas.parentNode.removeChild(this.canvas);for(var a in this)this[a]="function"==typeof this[a]?c._removedFactory(a):null};var B=c.st;for(var C in A)A[a](C)&&!B[a](C)&&(B[C]=function(a){return function(){var b=arguments;return this.forEach(function(c){c[a].apply(c,b)})}}(C))}}(),function(){if(c.vml){var a="hasOwnProperty",b=String,d=parseFloat,e=Math,f=e.round,g=e.max,h=e.min,i=e.abs,j="fill",k=/[, ]+/,l=c.eve,m=" progid:DXImageTransform.Microsoft",n=" ",o="",p={M:"m",L:"l",C:"c",Z:"x",m:"t",l:"r",c:"v",z:"x"},q=/([clmz]),?([^clmz]*)/gi,r=/ progid:\S+Blur\([^\)]+\)/g,s=/-?[^,\s-]+/g,t="position:absolute;left:0;top:0;width:1px;height:1px",u=21600,v={path:1,rect:1,image:1},w={circle:1,ellipse:1},x=function(a){var d=/[ahqstv]/gi,e=c._pathToAbsolute;if(b(a).match(d)&&(e=c._path2curve),d=/[clmz]/g,e==c._pathToAbsolute&&!b(a).match(d)){var g=b(a).replace(q,function(a,b,c){var d=[],e="m"==b.toLowerCase(),g=p[b];return c.replace(s,function(a){e&&2==d.length&&(g+=d+p["m"==b?"l":"L"],d=[]),d.push(f(a*u))}),g+d});return g}var h,i,j=e(a);g=[];for(var k=0,l=j.length;l>k;k++){h=j[k],i=j[k][0].toLowerCase(),"z"==i&&(i="x");for(var m=1,r=h.length;r>m;m++)i+=f(h[m]*u)+(m!=r-1?",":o);g.push(i)}return g.join(n)},y=function(a,b,d){var e=c.matrix();return e.rotate(-a,.5,.5),{dx:e.x(b,d),dy:e.y(b,d)}},z=function(a,b,c,d,e,f){var g=a._,h=a.matrix,k=g.fillpos,l=a.node,m=l.style,o=1,p="",q=u/b,r=u/c;if(m.visibility="hidden",b&&c){if(l.coordsize=i(q)+n+i(r),m.rotation=f*(0>b*c?-1:1),f){var s=y(f,d,e);d=s.dx,e=s.dy}if(0>b&&(p+="x"),0>c&&(p+=" y")&&(o=-1),m.flip=p,l.coordorigin=d*-q+n+e*-r,k||g.fillsize){var t=l.getElementsByTagName(j);t=t&&t[0],l.removeChild(t),k&&(s=y(f,h.x(k[0],k[1]),h.y(k[0],k[1])),t.position=s.dx*o+n+s.dy*o),g.fillsize&&(t.size=g.fillsize[0]*i(b)+n+g.fillsize[1]*i(c)),l.appendChild(t)}m.visibility="visible"}};c.toString=function(){return"Your browser doesn’t support SVG. Falling down to VML.\nYou are running Raphaël "+this.version};var A=function(a,c,d){for(var e=b(c).toLowerCase().split("-"),f=d?"end":"start",g=e.length,h="classic",i="medium",j="medium";g--;)switch(e[g]){case"block":case"classic":case"oval":case"diamond":case"open":case"none":h=e[g];break;case"wide":case"narrow":j=e[g];break;case"long":case"short":i=e[g]}var k=a.node.getElementsByTagName("stroke")[0];k[f+"arrow"]=h,k[f+"arrowlength"]=i,k[f+"arrowwidth"]=j},B=function(e,i){e.attrs=e.attrs||{};var l=e.node,m=e.attrs,p=l.style,q=v[e.type]&&(i.x!=m.x||i.y!=m.y||i.width!=m.width||i.height!=m.height||i.cx!=m.cx||i.cy!=m.cy||i.rx!=m.rx||i.ry!=m.ry||i.r!=m.r),r=w[e.type]&&(m.cx!=i.cx||m.cy!=i.cy||m.r!=i.r||m.rx!=i.rx||m.ry!=i.ry),s=e;for(var t in i)i[a](t)&&(m[t]=i[t]);if(q&&(m.path=c._getPath[e.type](e),e._.dirty=1),i.href&&(l.href=i.href),i.title&&(l.title=i.title),i.target&&(l.target=i.target),i.cursor&&(p.cursor=i.cursor),"blur"in i&&e.blur(i.blur),(i.path&&"path"==e.type||q)&&(l.path=x(~b(m.path).toLowerCase().indexOf("r")?c._pathToAbsolute(m.path):m.path),"image"==e.type&&(e._.fillpos=[m.x,m.y],e._.fillsize=[m.width,m.height],z(e,1,1,0,0,0))),"transform"in i&&e.transform(i.transform),r){var y=+m.cx,B=+m.cy,D=+m.rx||+m.r||0,E=+m.ry||+m.r||0;l.path=c.format("ar{0},{1},{2},{3},{4},{1},{4},{1}x",f((y-D)*u),f((B-E)*u),f((y+D)*u),f((B+E)*u),f(y*u)),e._.dirty=1}if("clip-rect"in i){var G=b(i["clip-rect"]).split(k);if(4==G.length){G[2]=+G[2]+ +G[0],G[3]=+G[3]+ +G[1];var H=l.clipRect||c._g.doc.createElement("div"),I=H.style;I.clip=c.format("rect({1}px {2}px {3}px {0}px)",G),l.clipRect||(I.position="absolute",I.top=0,I.left=0,I.width=e.paper.width+"px",I.height=e.paper.height+"px",l.parentNode.insertBefore(H,l),H.appendChild(l),l.clipRect=H)}i["clip-rect"]||l.clipRect&&(l.clipRect.style.clip="auto")}if(e.textpath){var J=e.textpath.style;i.font&&(J.font=i.font),i["font-family"]&&(J.fontFamily='"'+i["font-family"].split(",")[0].replace(/^['"]+|['"]+$/g,o)+'"'),i["font-size"]&&(J.fontSize=i["font-size"]),i["font-weight"]&&(J.fontWeight=i["font-weight"]),i["font-style"]&&(J.fontStyle=i["font-style"])}if("arrow-start"in i&&A(s,i["arrow-start"]),"arrow-end"in i&&A(s,i["arrow-end"],1),null!=i.opacity||null!=i["stroke-width"]||null!=i.fill||null!=i.src||null!=i.stroke||null!=i["stroke-width"]||null!=i["stroke-opacity"]||null!=i["fill-opacity"]||null!=i["stroke-dasharray"]||null!=i["stroke-miterlimit"]||null!=i["stroke-linejoin"]||null!=i["stroke-linecap"]){var K=l.getElementsByTagName(j),L=!1;if(K=K&&K[0],!K&&(L=K=F(j)),"image"==e.type&&i.src&&(K.src=i.src),i.fill&&(K.on=!0),(null==K.on||"none"==i.fill||null===i.fill)&&(K.on=!1),K.on&&i.fill){var M=b(i.fill).match(c._ISURL);if(M){K.parentNode==l&&l.removeChild(K),K.rotate=!0,K.src=M[1],K.type="tile";var N=e.getBBox(1);K.position=N.x+n+N.y,e._.fillpos=[N.x,N.y],c._preload(M[1],function(){e._.fillsize=[this.offsetWidth,this.offsetHeight]})}else K.color=c.getRGB(i.fill).hex,K.src=o,K.type="solid",c.getRGB(i.fill).error&&(s.type in{circle:1,ellipse:1}||"r"!=b(i.fill).charAt())&&C(s,i.fill,K)&&(m.fill="none",m.gradient=i.fill,K.rotate=!1)}if("fill-opacity"in i||"opacity"in i){var O=((+m["fill-opacity"]+1||2)-1)*((+m.opacity+1||2)-1)*((+c.getRGB(i.fill).o+1||2)-1);O=h(g(O,0),1),K.opacity=O,K.src&&(K.color="none")}l.appendChild(K);var P=l.getElementsByTagName("stroke")&&l.getElementsByTagName("stroke")[0],Q=!1;!P&&(Q=P=F("stroke")),(i.stroke&&"none"!=i.stroke||i["stroke-width"]||null!=i["stroke-opacity"]||i["stroke-dasharray"]||i["stroke-miterlimit"]||i["stroke-linejoin"]||i["stroke-linecap"])&&(P.on=!0),("none"==i.stroke||null===i.stroke||null==P.on||0==i.stroke||0==i["stroke-width"])&&(P.on=!1);var R=c.getRGB(i.stroke);P.on&&i.stroke&&(P.color=R.hex),O=((+m["stroke-opacity"]+1||2)-1)*((+m.opacity+1||2)-1)*((+R.o+1||2)-1);var S=.75*(d(i["stroke-width"])||1);if(O=h(g(O,0),1),null==i["stroke-width"]&&(S=m["stroke-width"]),i["stroke-width"]&&(P.weight=S),S&&1>S&&(O*=S)&&(P.weight=1),P.opacity=O,i["stroke-linejoin"]&&(P.joinstyle=i["stroke-linejoin"]||"miter"),P.miterlimit=i["stroke-miterlimit"]||8,i["stroke-linecap"]&&(P.endcap="butt"==i["stroke-linecap"]?"flat":"square"==i["stroke-linecap"]?"square":"round"),i["stroke-dasharray"]){var T={"-":"shortdash",".":"shortdot","-.":"shortdashdot","-..":"shortdashdotdot",". ":"dot","- ":"dash","--":"longdash","- .":"dashdot","--.":"longdashdot","--..":"longdashdotdot"};P.dashstyle=T[a](i["stroke-dasharray"])?T[i["stroke-dasharray"]]:o}Q&&l.appendChild(P)}if("text"==s.type){s.paper.canvas.style.display=o;var U=s.paper.span,V=100,W=m.font&&m.font.match(/\d+(?:\.\d*)?(?=px)/);p=U.style,m.font&&(p.font=m.font),m["font-family"]&&(p.fontFamily=m["font-family"]),m["font-weight"]&&(p.fontWeight=m["font-weight"]),m["font-style"]&&(p.fontStyle=m["font-style"]),W=d(m["font-size"]||W&&W[0])||10,p.fontSize=W*V+"px",s.textpath.string&&(U.innerHTML=b(s.textpath.string).replace(/</g,"&#60;").replace(/&/g,"&#38;").replace(/\n/g,"<br>"));var X=U.getBoundingClientRect();s.W=m.w=(X.right-X.left)/V,s.H=m.h=(X.bottom-X.top)/V,s.X=m.x,s.Y=m.y+s.H/2,("x"in i||"y"in i)&&(s.path.v=c.format("m{0},{1}l{2},{1}",f(m.x*u),f(m.y*u),f(m.x*u)+1));for(var Y=["x","y","text","font","font-family","font-weight","font-style","font-size"],Z=0,$=Y.length;$>Z;Z++)if(Y[Z]in i){s._.dirty=1;break}switch(m["text-anchor"]){case"start":s.textpath.style["v-text-align"]="left",s.bbx=s.W/2;break;case"end":s.textpath.style["v-text-align"]="right",s.bbx=-s.W/2;break;default:s.textpath.style["v-text-align"]="center",s.bbx=0}s.textpath.style["v-text-kern"]=!0}},C=function(a,f,g){a.attrs=a.attrs||{};var h=(a.attrs,Math.pow),i="linear",j=".5 .5";if(a.attrs.gradient=f,f=b(f).replace(c._radial_gradient,function(a,b,c){return i="radial",b&&c&&(b=d(b),c=d(c),h(b-.5,2)+h(c-.5,2)>.25&&(c=e.sqrt(.25-h(b-.5,2))*(2*(c>.5)-1)+.5),j=b+n+c),o}),f=f.split(/\s*\-\s*/),"linear"==i){var k=f.shift();if(k=-d(k),isNaN(k))return null}var l=c._parseDots(f);if(!l)return null;if(a=a.shape||a.node,l.length){a.removeChild(g),g.on=!0,g.method="none",g.color=l[0].color,g.color2=l[l.length-1].color;for(var m=[],p=0,q=l.length;q>p;p++)l[p].offset&&m.push(l[p].offset+n+l[p].color);g.colors=m.length?m.join():"0% "+g.color,"radial"==i?(g.type="gradientTitle",g.focus="100%",g.focussize="0 0",g.focusposition=j,g.angle=0):(g.type="gradient",g.angle=(270-k)%360),a.appendChild(g)}return 1},D=function(a,b){this[0]=this.node=a,a.raphael=!0,this.id=c._oid++,a.raphaelid=this.id,this.X=0,this.Y=0,this.attrs={},this.paper=b,this.matrix=c.matrix(),this._={transform:[],sx:1,sy:1,dx:0,dy:0,deg:0,dirty:1,dirtyT:1},!b.bottom&&(b.bottom=this),this.prev=b.top,b.top&&(b.top.next=this),b.top=this,this.next=null},E=c.el;D.prototype=E,E.constructor=D,E.transform=function(a){if(null==a)return this._.transform;var d,e=this.paper._viewBoxShift,f=e?"s"+[e.scale,e.scale]+"-1-1t"+[e.dx,e.dy]:o;e&&(d=a=b(a).replace(/\.{3}|\u2026/g,this._.transform||o)),c._extractTransform(this,f+a);var g,h=this.matrix.clone(),i=this.skew,j=this.node,k=~b(this.attrs.fill).indexOf("-"),l=!b(this.attrs.fill).indexOf("url(");if(h.translate(1,1),l||k||"image"==this.type)if(i.matrix="1 0 0 1",i.offset="0 0",g=h.split(),k&&g.noRotation||!g.isSimple){j.style.filter=h.toFilter();var m=this.getBBox(),p=this.getBBox(1),q=m.x-p.x,r=m.y-p.y;j.coordorigin=q*-u+n+r*-u,z(this,1,1,q,r,0)}else j.style.filter=o,z(this,g.scalex,g.scaley,g.dx,g.dy,g.rotate);else j.style.filter=o,i.matrix=b(h),i.offset=h.offset();return d&&(this._.transform=d),this},E.rotate=function(a,c,e){if(this.removed)return this;if(null!=a){if(a=b(a).split(k),a.length-1&&(c=d(a[1]),e=d(a[2])),a=d(a[0]),null==e&&(c=e),null==c||null==e){var f=this.getBBox(1);c=f.x+f.width/2,e=f.y+f.height/2}return this._.dirtyT=1,this.transform(this._.transform.concat([["r",a,c,e]])),this}},E.translate=function(a,c){return this.removed?this:(a=b(a).split(k),a.length-1&&(c=d(a[1])),a=d(a[0])||0,c=+c||0,this._.bbox&&(this._.bbox.x+=a,this._.bbox.y+=c),this.transform(this._.transform.concat([["t",a,c]])),this)},E.scale=function(a,c,e,f){if(this.removed)return this;if(a=b(a).split(k),a.length-1&&(c=d(a[1]),e=d(a[2]),f=d(a[3]),isNaN(e)&&(e=null),isNaN(f)&&(f=null)),a=d(a[0]),null==c&&(c=a),null==f&&(e=f),null==e||null==f)var g=this.getBBox(1);return e=null==e?g.x+g.width/2:e,f=null==f?g.y+g.height/2:f,this.transform(this._.transform.concat([["s",a,c,e,f]])),this._.dirtyT=1,this},E.hide=function(){return!this.removed&&(this.node.style.display="none"),this},E.show=function(){return!this.removed&&(this.node.style.display=o),this},E._getBBox=function(){return this.removed?{}:{x:this.X+(this.bbx||0)-this.W/2,y:this.Y-this.H,width:this.W,height:this.H}},E.remove=function(){if(!this.removed&&this.node.parentNode){this.paper.__set__&&this.paper.__set__.exclude(this),c.eve.unbind("raphael.*.*."+this.id),c._tear(this,this.paper),this.node.parentNode.removeChild(this.node),this.shape&&this.shape.parentNode.removeChild(this.shape);for(var a in this)this[a]="function"==typeof this[a]?c._removedFactory(a):null;this.removed=!0}},E.attr=function(b,d){if(this.removed)return this;if(null==b){var e={};for(var f in this.attrs)this.attrs[a](f)&&(e[f]=this.attrs[f]);return e.gradient&&"none"==e.fill&&(e.fill=e.gradient)&&delete e.gradient,e.transform=this._.transform,e}if(null==d&&c.is(b,"string")){if(b==j&&"none"==this.attrs.fill&&this.attrs.gradient)return this.attrs.gradient;for(var g=b.split(k),h={},i=0,m=g.length;m>i;i++)b=g[i],h[b]=b in this.attrs?this.attrs[b]:c.is(this.paper.customAttributes[b],"function")?this.paper.customAttributes[b].def:c._availableAttrs[b];return m-1?h:h[g[0]]}if(this.attrs&&null==d&&c.is(b,"array")){for(h={},i=0,m=b.length;m>i;i++)h[b[i]]=this.attr(b[i]);return h}var n;null!=d&&(n={},n[b]=d),null==d&&c.is(b,"object")&&(n=b);for(var o in n)l("raphael.attr."+o+"."+this.id,this,n[o]);if(n){for(o in this.paper.customAttributes)if(this.paper.customAttributes[a](o)&&n[a](o)&&c.is(this.paper.customAttributes[o],"function")){var p=this.paper.customAttributes[o].apply(this,[].concat(n[o]));this.attrs[o]=n[o];for(var q in p)p[a](q)&&(n[q]=p[q])}n.text&&"text"==this.type&&(this.textpath.string=n.text),B(this,n)}return this},E.toFront=function(){return!this.removed&&this.node.parentNode.appendChild(this.node),this.paper&&this.paper.top!=this&&c._tofront(this,this.paper),this},E.toBack=function(){return this.removed?this:(this.node.parentNode.firstChild!=this.node&&(this.node.parentNode.insertBefore(this.node,this.node.parentNode.firstChild),c._toback(this,this.paper)),this)},E.insertAfter=function(a){return this.removed?this:(a.constructor==c.st.constructor&&(a=a[a.length-1]),a.node.nextSibling?a.node.parentNode.insertBefore(this.node,a.node.nextSibling):a.node.parentNode.appendChild(this.node),c._insertafter(this,a,this.paper),this)},E.insertBefore=function(a){return this.removed?this:(a.constructor==c.st.constructor&&(a=a[0]),a.node.parentNode.insertBefore(this.node,a.node),c._insertbefore(this,a,this.paper),this)},E.blur=function(a){var b=this.node.runtimeStyle,d=b.filter;return d=d.replace(r,o),0!==+a?(this.attrs.blur=a,b.filter=d+n+m+".Blur(pixelradius="+(+a||1.5)+")",b.margin=c.format("-{0}px 0 0 -{0}px",f(+a||1.5))):(b.filter=d,b.margin=0,delete this.attrs.blur),this},c._engine.path=function(a,b){var c=F("shape");c.style.cssText=t,c.coordsize=u+n+u,c.coordorigin=b.coordorigin;var d=new D(c,b),e={fill:"none",stroke:"#000"};a&&(e.path=a),d.type="path",d.path=[],d.Path=o,B(d,e),b.canvas.appendChild(c);var f=F("skew");return f.on=!0,c.appendChild(f),d.skew=f,d.transform(o),d},c._engine.rect=function(a,b,d,e,f,g){var h=c._rectPath(b,d,e,f,g),i=a.path(h),j=i.attrs;return i.X=j.x=b,i.Y=j.y=d,i.W=j.width=e,i.H=j.height=f,j.r=g,j.path=h,i.type="rect",i},c._engine.ellipse=function(a,b,c,d,e){var f=a.path();return f.attrs,f.X=b-d,f.Y=c-e,f.W=2*d,f.H=2*e,f.type="ellipse",B(f,{cx:b,cy:c,rx:d,ry:e}),f},c._engine.circle=function(a,b,c,d){var e=a.path();return e.attrs,e.X=b-d,e.Y=c-d,e.W=e.H=2*d,e.type="circle",B(e,{cx:b,cy:c,r:d}),e},c._engine.image=function(a,b,d,e,f,g){var h=c._rectPath(d,e,f,g),i=a.path(h).attr({stroke:"none"}),k=i.attrs,l=i.node,m=l.getElementsByTagName(j)[0];return k.src=b,i.X=k.x=d,i.Y=k.y=e,i.W=k.width=f,i.H=k.height=g,k.path=h,i.type="image",m.parentNode==l&&l.removeChild(m),m.rotate=!0,m.src=b,m.type="tile",i._.fillpos=[d,e],i._.fillsize=[f,g],l.appendChild(m),z(i,1,1,0,0,0),i},c._engine.text=function(a,d,e,g){var h=F("shape"),i=F("path"),j=F("textpath");d=d||0,e=e||0,g=g||"",i.v=c.format("m{0},{1}l{2},{1}",f(d*u),f(e*u),f(d*u)+1),i.textpathok=!0,j.string=b(g),j.on=!0,h.style.cssText=t,h.coordsize=u+n+u,h.coordorigin="0 0";var k=new D(h,a),l={fill:"#000",stroke:"none",font:c._availableAttrs.font,text:g};k.shape=h,k.path=i,k.textpath=j,k.type="text",k.attrs.text=b(g),k.attrs.x=d,k.attrs.y=e,k.attrs.w=1,k.attrs.h=1,B(k,l),h.appendChild(j),h.appendChild(i),a.canvas.appendChild(h);var m=F("skew");return m.on=!0,h.appendChild(m),k.skew=m,k.transform(o),k},c._engine.setSize=function(a,b){var d=this.canvas.style;return this.width=a,this.height=b,a==+a&&(a+="px"),b==+b&&(b+="px"),d.width=a,d.height=b,d.clip="rect(0 "+a+" "+b+" 0)",this._viewBox&&c._engine.setViewBox.apply(this,this._viewBox),this},c._engine.setViewBox=function(a,b,d,e,f){c.eve("raphael.setViewBox",this,this._viewBox,[a,b,d,e,f]);var h,i,j=this.width,k=this.height,l=1/g(d/j,e/k);return f&&(h=k/e,i=j/d,j>d*h&&(a-=(j-d*h)/2/h),k>e*i&&(b-=(k-e*i)/2/i)),this._viewBox=[a,b,d,e,!!f],this._viewBoxShift={dx:-a,dy:-b,scale:l},this.forEach(function(a){a.transform("...")}),this};var F;c._engine.initWin=function(a){var b=a.document;b.createStyleSheet().addRule(".rvml","behavior:url(#default#VML)");try{!b.namespaces.rvml&&b.namespaces.add("rvml","urn:schemas-microsoft-com:vml"),F=function(a){return b.createElement("<rvml:"+a+' class="rvml">')}}catch(c){F=function(a){return b.createElement("<"+a+' xmlns="urn:schemas-microsoft.com:vml" class="rvml">')}}},c._engine.initWin(c._g.win),c._engine.create=function(){var a=c._getContainer.apply(0,arguments),b=a.container,d=a.height,e=a.width,f=a.x,g=a.y;if(!b)throw new Error("VML container not found.");var h=new c._Paper,i=h.canvas=c._g.doc.createElement("div"),j=i.style;return f=f||0,g=g||0,e=e||512,d=d||342,h.width=e,h.height=d,e==+e&&(e+="px"),d==+d&&(d+="px"),h.coordsize=1e3*u+n+1e3*u,h.coordorigin="0 0",h.span=c._g.doc.createElement("span"),h.span.style.cssText="position:absolute;left:-9999em;top:-9999em;padding:0;margin:0;line-height:1;",i.appendChild(h.span),j.cssText=c.format("top:0;left:0;width:{0};height:{1};display:inline-block;position:relative;clip:rect(0 {0} {1} 0);overflow:hidden",e,d),1==b?(c._g.doc.body.appendChild(i),j.left=f+"px",j.top=g+"px",j.position="absolute"):b.firstChild?b.insertBefore(i,b.firstChild):b.appendChild(i),h.renderfix=function(){},h},c.prototype.clear=function(){c.eve("raphael.clear",this),this.canvas.innerHTML=o,this.span=c._g.doc.createElement("span"),this.span.style.cssText="position:absolute;left:-9999em;top:-9999em;padding:0;margin:0;line-height:1;display:inline;",this.canvas.appendChild(this.span),this.bottom=this.top=null},c.prototype.remove=function(){c.eve("raphael.remove",this),this.canvas.parentNode.removeChild(this.canvas);for(var a in this)this[a]="function"==typeof this[a]?c._removedFactory(a):null;return!0};var G=c.st;for(var H in E)E[a](H)&&!G[a](H)&&(G[H]=function(a){return function(){var b=arguments;return this.forEach(function(c){c[a].apply(c,b)})}}(H))}}(),B.was?A.win.Raphael=c:Raphael=c,c});


/*
* Colorwheel
* Copyright (c) 2010 John Weir (http://famedriver.com)
* Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) license.
*
* requires jQuery & Raphael
*   http://jquery.com http://raphaeljs.com
*
* see http://jweir.github.com/colorwheel for Usage
*
*/

Raphael.colorwheel = function(target, color_wheel_size, no_segments){
  var canvas,
      current_color,
      current_color_hsb,
      size,
      segments = no_segments || 60,
      bs_square = {},
      hue_ring = {},
      tri_size,
      cursor = {},
      drag_target,
      input_target,
      center,
      parent,
      change_callback,
      drag_callbacks = [function(){}, function(){}],
      offset,
      padding = 2,
      sdim; // holds the dimensions for the saturation square

  function point(x, y){ return {x:x, y:y};}
  function radians(a){ return a * (Math.PI/180);}

  function angle(x,y){
    var q = x > 0 ? 0 : 180;
    return q+Math.atan((0 - y)/(0 - x))*180/(Math.PI);
  }

  function create(target, color_wheel_size){
    size     = color_wheel_size;
    tri_size = size/20;
    center   = size/2;
    parent   = $(target);
    canvas   = Raphael(parent[0],size, size);
    canvas.safari();

    create_bs_square();
    create_hue_ring();
    hue_ring.cursor = cursor_create(tri_size);
    bs_square.cursor = cursor_create(tri_size*0.5);
    events_setup();
    parent.css({height:size+"px", width:size+"px"});
    disable_select(parent);
    return public_methods();
  }

  function disable_select(target){
    $(target).css({"unselectable": "on","-moz-user-select": "none","-webkit-user-select": "none"});
  }

  function public_methods(){
    return {
      input: input,
      onchange: onchange,
      ondrag : ondrag,
      color : public_set_color,
      color_hsb : public_set_color_hsb
    };
  }

  // Sets a textfield for user input of hex color values
  // TODO don't clear the change callback
  // TODO allow a null target to unbind the input
  function input(target){
    change_callback = null;
    input_target = target;
    $(target).keyup(function(){
      if(this.value.match(/^#([0-9A-F]){3}$|^#([0-9A-F]){6}$/img)){
        set_color(this.value);
        update_color(true);
		run_onchange_event();
      }
    });
    set_color(target.value);
    update_color(true);

    return public_methods();
  }

  function onchange(callback){
    change_callback = callback;
    update_color(false);
    return public_methods();
  }

  function ondrag(start_callback, end_callback){
    drag_callbacks = [start_callback || function(){}, end_callback || function(){}];
    return public_methods();
  }

  function drag(e){
    var x, y, page;

    e.preventDefault(); // prevents scrolling on touch

    page = e.originalEvent.touches ? e.originalEvent.touches[0] : e;

    x = page.pageX - (parent.offset().left + center);
    y = page.pageY - (parent.offset().top + center);

    if(drag_target == hue_ring){
      set_hue_cursor(x,y);
      update_color();
      run_onchange_event();
      return true;
    }
    if(drag_target == bs_square){
      set_bs_cursor(x,y);
      update_color();
      run_onchange_event();
      return true;
    }
  }

  function start_drag(event, target){
    event.preventDefault(); // prevents scrolling on touch

    $(document).on('mouseup touchend',stop_drag);
    $(document).on('mousemove touchmove',drag);
    drag_target = target;
    drag(event);
    drag_callbacks[0](current_color);
  }

  function stop_drag(event){
    event.preventDefault(); // prevents scrolling on touch

    $(document).off("mouseup touchend",stop_drag);
    $(document).off("mousemove touchmove",drag);
    drag_callbacks[1](current_color);
    run_onchange_event();
  }

  function events_setup(){
    $([hue_ring.event.node,hue_ring.cursor[0].node]).on("mousedown touchstart",
                                                        function(e){start_drag(e,hue_ring);});
    $([bs_square.b.node, bs_square.cursor[0].node]).on("mousedown touchstart",
                                                       function(e){start_drag(e,bs_square);});
  }

  function cursor_create(size){
    var set = canvas.set().push(
        canvas.circle(0, 0, size).attr({"stroke-width":4, stroke:"#333"}),
        canvas.circle(0, 0, size+2).attr({"stroke-width":1, stroke:"#FFF", opacity:0.5})
    );

    set[0].node.style.cursor = "crosshair";

    return set;
  }

  function set_bs_cursor(x,y){
    x = x+center;
    y = y+center;
    if(x < sdim.x){x = sdim.x}
    if(x > sdim.x+sdim.l){x = sdim.x+sdim.l}
    if(y < sdim.y){y = sdim.y}
    if(y > sdim.y+sdim.l){y = sdim.y + sdim.l}

    bs_square.cursor.attr({cx:x, cy:y}).transform("t0,0");
  }


  function set_hue(color){
    var hex = Raphael.getRGB(color).hex;
    bs_square.h.attr("fill", hex);
  }

  function hue(){
    return Raphael.rgb2hsb(bs_square.h.attr("fill")).h;
  }

  function public_set_color(value){
    var ret = set_color(value, false);
    update_color(false);
    return ret;
  }

  function public_set_color_hsb(hsb){
    var ret = set_color(hsb, true);
    update_color(false);
    return ret;
  }

  function set_color(value, is_hsb){
    if(value === undefined){
        if(is_hsb){
            return current_color_hsb;
        } else {
            return current_color;
        }
    }

    var hsb, hex;
    if(is_hsb){
        hsb = value;
        // Allow v (value) instead of b (brightness), as v is sometimes
        // used by Raphael.
        if(hsb.b === undefined){ hsb.b = hsb.v; }
        var rgb = canvas.raphael.hsb2rgb(hsb.h, hsb.s, hsb.b);
        hex = rgb.hex;
    } else {
        hex = value;
        hsb = canvas.raphael.rgb2hsb(hex);
    }
    var temp = canvas.rect(1,1,1,1).attr({fill:hex});

    set_bs_cursor(
      (0-sdim.l/2) + (sdim.l*hsb.s),
      sdim.l/2 - (sdim.l*hsb.b));
    set_hue_cursor((360*(hsb.h))-90);
    temp.remove();
    return public_methods();
  }

  // Could optimize this method
  function update_color(dont_replace_input_value){
    var x = bs_square.cursor.items[0].attr("cx"),
        y = bs_square.cursor.items[0].attr("cy"),
        hsb = {
          b: 1-(y-sdim.y)/sdim.l,
          s: (x-sdim.x)/sdim.l,
          h: hue()
        };

    current_color_hsb = hsb;
    current_color = Raphael.hsb2rgb(hsb.h, hsb.s,hsb.b);

    if(input_target){
      var c = current_color.hex;
      if(dont_replace_input_value !== true) { input_target.value = c;}
       if(hsb.b < 0.5){
        $(input_target).css("color", "#FFF");
      } else {
        $(input_target).css("color", "#000");
      }
      input_target.style.background = c;
    }

  }

  // accepts either x,y or d (degrees)
  function set_hue_cursor(mixed_args){
    var d;
    if(arguments.length == 2){
      d = angle(arguments[0],arguments[1]);
    } else {
      d = arguments[0];
    }

    var x = Math.cos(radians(d)) * (center-tri_size-padding);
    var y = Math.sin(radians(d)) * (center-tri_size-padding);
    hue_ring.cursor.attr({cx:x+center, cy:y+center}).transform("t0,0");
    set_hue("hsb("+(d+90)/360+",1,1)");
  }

  function bs_square_dim(){
    if(sdim){ return sdim;}
    var s = size - (tri_size * 4);
    sdim = {
      x:(s/6)+tri_size*2+padding,
      y:(s/6)+tri_size*2+padding,
      l:(s * 2/3)-padding*2
    };
    return sdim;
  }

  function create_bs_square(){
    bs_square_dim();
    box = [sdim.x, sdim.y, sdim.l, sdim.l];

    bs_square.h = canvas.rect.apply(canvas, box).attr({
      stroke:"#EEE", gradient: "0-#FFF-#000", opacity:1});
    bs_square.s = canvas.rect.apply(canvas, box).attr({
      stroke:null, gradient: "0-#FFF-#FFF", opacity:0});
    bs_square.b = canvas.rect.apply(canvas, box).attr({
      stroke:null, gradient: "90-#000-#FFF", opacity:0});
    bs_square.b.node.style.cursor = "crosshair";
  }

  function hue_segement_shape(){
    var path = "M -@W 0 L @W 0 L @W @H L -@W @H z";
    return path.replace(/@H/img, tri_size*2).replace(/@W/img,tri_size);
  }

  function copy_segment(r, d, k){
    var n = r.clone();
    var hue = d*(255/k);

    var s = size/2,
      t = tri_size,
      p = padding;

    n.transform("t"+s+","+(s-t)+"r"+(360/k)*d+"t0,-"+(s-t-p)+"");

    n.attr({"stroke-width":0, fill:"hsb("+d*(1/k)+", 1, 0.85)"});
    hue_ring.hues.push(n);
  }

  function create_hue_ring(){
    var s = hue_segement_shape(),
        tri = canvas.path(s).attr({stroke:"rgba(0,0,0,0)"}).transform("t"+(size/2)+","+padding),
        k = segments; // # of segments to use to generate the hues

    hue_ring.hues = canvas.set();

    for(n=0; n<k; n++){ copy_segment(tri, n, k); }

    // IE needs a slight opacity to assign events
    hue_ring.event = canvas.circle(
      center,
      center,
      center-tri_size-padding).attr({"stroke-width":tri_size*2, opacity:0.01});

    hue_ring.outline = canvas.circle(
      center,
      center,
      center-tri_size-padding).attr({"stroke":"#000", "stroke-width":(tri_size*2)+3, opacity:0.1});
    hue_ring.outline.toBack();
    hue_ring.event.node.style.cursor = "crosshair";
  }

  function run_onchange_event(){
    if (({}).toString.call(change_callback).match(/function/i)){
      change_callback(current_color);
    }
  }

  return create(target, color_wheel_size);
};

//Generated by CoffeeScript 1.9.2
'use strict';
(function() {
  var ngColorwheelDirective;
  ngColorwheelDirective = function() {
    var directive, link;
    link = function(scope, elem, attrs, ngModelCtrl) {
      var cw, init, options, toView, updateModel;
      if ((typeof Raphael !== "undefined" && Raphael !== null ? Raphael.colorwheel : void 0) == null) {
        return;
      }
      options = null;
      try {
        options = scope.$eval(attrs.ngColorwheel);
      } catch (_error) {
        console.log('ERROR ON PARSING JSON-string:', attrs.ngColorwheel);
      }
      if (options == null) {
        options = {};
      }
      if (options.size == null) {
        options.size = 150;
      }
      cw = null;
      init = function() {
        cw = Raphael.colorwheel(elem[0], options.size, options.segments);
        ngModelCtrl.$formatters.push(toView);
        return cw.onchange(updateModel);
      };
      toView = function(modelValue) {
        if (modelValue != null) {
          cw.color(modelValue);
        }
        return modelValue;
      };
      updateModel = function(color) {
        return ngModelCtrl.$setViewValue(color.hex);
      };
      init();
    };
    directive = {
      link: link,
      restrict: 'EA',
      require: '?ngModel'
    };
    return directive;
  };
  return angular.module('directive.ngColorwheel', []).directive('ngColorwheel', ngColorwheelDirective);
})();
/*!
 * Bowser - a browser detector
 * https://github.com/ded/bowser
 * MIT License | (c) Dustin Diaz 2015
 */

!function (root, name, definition) {
  if (typeof module != 'undefined' && module.exports) module.exports = definition()
  else if (typeof define == 'function' && define.amd) define(name, definition)
  else root[name] = definition()
}(this, 'bowser', function () {
  /**
    * See useragents.js for examples of navigator.userAgent
    */

  var t = true

  function detect(ua) {

    function getFirstMatch(regex) {
      var match = ua.match(regex);
      return (match && match.length > 1 && match[1]) || '';
    }

    function getSecondMatch(regex) {
      var match = ua.match(regex);
      return (match && match.length > 1 && match[2]) || '';
    }

    var iosdevice = getFirstMatch(/(ipod|iphone|ipad)/i).toLowerCase()
      , likeAndroid = /like android/i.test(ua)
      , android = !likeAndroid && /android/i.test(ua)
      , nexusMobile = /nexus\s*[0-6]\s*/i.test(ua)
      , nexusTablet = !nexusMobile && /nexus\s*[0-9]+/i.test(ua)
      , chromeos = /CrOS/.test(ua)
      , silk = /silk/i.test(ua)
      , sailfish = /sailfish/i.test(ua)
      , tizen = /tizen/i.test(ua)
      , webos = /(web|hpw)os/i.test(ua)
      , windowsphone = /windows phone/i.test(ua)
      , samsungBrowser = /SamsungBrowser/i.test(ua)
      , windows = !windowsphone && /windows/i.test(ua)
      , mac = !iosdevice && !silk && /macintosh/i.test(ua)
      , linux = !android && !sailfish && !tizen && !webos && /linux/i.test(ua)
      , edgeVersion = getFirstMatch(/edge\/(\d+(\.\d+)?)/i)
      , versionIdentifier = getFirstMatch(/version\/(\d+(\.\d+)?)/i)
      , tablet = /tablet/i.test(ua) && !/tablet pc/i.test(ua)
      , mobile = !tablet && /[^-]mobi/i.test(ua)
      , xbox = /xbox/i.test(ua)
      , result

    if (/opera/i.test(ua)) {
      //  an old Opera
      result = {
        name: 'Opera'
      , opera: t
      , version: versionIdentifier || getFirstMatch(/(?:opera|opr|opios)[\s\/](\d+(\.\d+)?)/i)
      }
    } else if (/opr\/|opios/i.test(ua)) {
      // a new Opera
      result = {
        name: 'Opera'
        , opera: t
        , version: getFirstMatch(/(?:opr|opios)[\s\/](\d+(\.\d+)?)/i) || versionIdentifier
      }
    }
    else if (/SamsungBrowser/i.test(ua)) {
      result = {
        name: 'Samsung Internet for Android'
        , samsungBrowser: t
        , version: versionIdentifier || getFirstMatch(/(?:SamsungBrowser)[\s\/](\d+(\.\d+)?)/i)
      }
    }
    else if (/coast/i.test(ua)) {
      result = {
        name: 'Opera Coast'
        , coast: t
        , version: versionIdentifier || getFirstMatch(/(?:coast)[\s\/](\d+(\.\d+)?)/i)
      }
    }
    else if (/yabrowser/i.test(ua)) {
      result = {
        name: 'Yandex Browser'
      , yandexbrowser: t
      , version: versionIdentifier || getFirstMatch(/(?:yabrowser)[\s\/](\d+(\.\d+)?)/i)
      }
    }
    else if (/ucbrowser/i.test(ua)) {
      result = {
          name: 'UC Browser'
        , ucbrowser: t
        , version: getFirstMatch(/(?:ucbrowser)[\s\/](\d+(?:\.\d+)+)/i)
      }
    }
    else if (/mxios/i.test(ua)) {
      result = {
        name: 'Maxthon'
        , maxthon: t
        , version: getFirstMatch(/(?:mxios)[\s\/](\d+(?:\.\d+)+)/i)
      }
    }
    else if (/epiphany/i.test(ua)) {
      result = {
        name: 'Epiphany'
        , epiphany: t
        , version: getFirstMatch(/(?:epiphany)[\s\/](\d+(?:\.\d+)+)/i)
      }
    }
    else if (/puffin/i.test(ua)) {
      result = {
        name: 'Puffin'
        , puffin: t
        , version: getFirstMatch(/(?:puffin)[\s\/](\d+(?:\.\d+)?)/i)
      }
    }
    else if (/sleipnir/i.test(ua)) {
      result = {
        name: 'Sleipnir'
        , sleipnir: t
        , version: getFirstMatch(/(?:sleipnir)[\s\/](\d+(?:\.\d+)+)/i)
      }
    }
    else if (/k-meleon/i.test(ua)) {
      result = {
        name: 'K-Meleon'
        , kMeleon: t
        , version: getFirstMatch(/(?:k-meleon)[\s\/](\d+(?:\.\d+)+)/i)
      }
    }
    else if (windowsphone) {
      result = {
        name: 'Windows Phone'
      , windowsphone: t
      }
      if (edgeVersion) {
        result.msedge = t
        result.version = edgeVersion
      }
      else {
        result.msie = t
        result.version = getFirstMatch(/iemobile\/(\d+(\.\d+)?)/i)
      }
    }
    else if (/msie|trident/i.test(ua)) {
      result = {
        name: 'Internet Explorer'
      , msie: t
      , version: getFirstMatch(/(?:msie |rv:)(\d+(\.\d+)?)/i)
      }
    } else if (chromeos) {
      result = {
        name: 'Chrome'
      , chromeos: t
      , chromeBook: t
      , chrome: t
      , version: getFirstMatch(/(?:chrome|crios|crmo)\/(\d+(\.\d+)?)/i)
      }
    } else if (/chrome.+? edge/i.test(ua)) {
      result = {
        name: 'Microsoft Edge'
      , msedge: t
      , version: edgeVersion
      }
    }
    else if (/vivaldi/i.test(ua)) {
      result = {
        name: 'Vivaldi'
        , vivaldi: t
        , version: getFirstMatch(/vivaldi\/(\d+(\.\d+)?)/i) || versionIdentifier
      }
    }
    else if (sailfish) {
      result = {
        name: 'Sailfish'
      , sailfish: t
      , version: getFirstMatch(/sailfish\s?browser\/(\d+(\.\d+)?)/i)
      }
    }
    else if (/seamonkey\//i.test(ua)) {
      result = {
        name: 'SeaMonkey'
      , seamonkey: t
      , version: getFirstMatch(/seamonkey\/(\d+(\.\d+)?)/i)
      }
    }
    else if (/firefox|iceweasel|fxios/i.test(ua)) {
      result = {
        name: 'Firefox'
      , firefox: t
      , version: getFirstMatch(/(?:firefox|iceweasel|fxios)[ \/](\d+(\.\d+)?)/i)
      }
      if (/\((mobile|tablet);[^\)]*rv:[\d\.]+\)/i.test(ua)) {
        result.firefoxos = t
      }
    }
    else if (silk) {
      result =  {
        name: 'Amazon Silk'
      , silk: t
      , version : getFirstMatch(/silk\/(\d+(\.\d+)?)/i)
      }
    }
    else if (/phantom/i.test(ua)) {
      result = {
        name: 'PhantomJS'
      , phantom: t
      , version: getFirstMatch(/phantomjs\/(\d+(\.\d+)?)/i)
      }
    }
    else if (/slimerjs/i.test(ua)) {
      result = {
        name: 'SlimerJS'
        , slimer: t
        , version: getFirstMatch(/slimerjs\/(\d+(\.\d+)?)/i)
      }
    }
    else if (/blackberry|\bbb\d+/i.test(ua) || /rim\stablet/i.test(ua)) {
      result = {
        name: 'BlackBerry'
      , blackberry: t
      , version: versionIdentifier || getFirstMatch(/blackberry[\d]+\/(\d+(\.\d+)?)/i)
      }
    }
    else if (webos) {
      result = {
        name: 'WebOS'
      , webos: t
      , version: versionIdentifier || getFirstMatch(/w(?:eb)?osbrowser\/(\d+(\.\d+)?)/i)
      };
      /touchpad\//i.test(ua) && (result.touchpad = t)
    }
    else if (/bada/i.test(ua)) {
      result = {
        name: 'Bada'
      , bada: t
      , version: getFirstMatch(/dolfin\/(\d+(\.\d+)?)/i)
      };
    }
    else if (tizen) {
      result = {
        name: 'Tizen'
      , tizen: t
      , version: getFirstMatch(/(?:tizen\s?)?browser\/(\d+(\.\d+)?)/i) || versionIdentifier
      };
    }
    else if (/qupzilla/i.test(ua)) {
      result = {
        name: 'QupZilla'
        , qupzilla: t
        , version: getFirstMatch(/(?:qupzilla)[\s\/](\d+(?:\.\d+)+)/i) || versionIdentifier
      }
    }
    else if (/chromium/i.test(ua)) {
      result = {
        name: 'Chromium'
        , chromium: t
        , version: getFirstMatch(/(?:chromium)[\s\/](\d+(?:\.\d+)?)/i) || versionIdentifier
      }
    }
    else if (/chrome|crios|crmo/i.test(ua)) {
      result = {
        name: 'Chrome'
        , chrome: t
        , version: getFirstMatch(/(?:chrome|crios|crmo)\/(\d+(\.\d+)?)/i)
      }
    }
    else if (android) {
      result = {
        name: 'Android'
        , version: versionIdentifier
      }
    }
    else if (/safari|applewebkit/i.test(ua)) {
      result = {
        name: 'Safari'
      , safari: t
      }
      if (versionIdentifier) {
        result.version = versionIdentifier
      }
    }
    else if (iosdevice) {
      result = {
        name : iosdevice == 'iphone' ? 'iPhone' : iosdevice == 'ipad' ? 'iPad' : 'iPod'
      }
      // WTF: version is not part of user agent in web apps
      if (versionIdentifier) {
        result.version = versionIdentifier
      }
    }
    else if(/googlebot/i.test(ua)) {
      result = {
        name: 'Googlebot'
      , googlebot: t
      , version: getFirstMatch(/googlebot\/(\d+(\.\d+))/i) || versionIdentifier
      }
    }
    else {
      result = {
        name: getFirstMatch(/^(.*)\/(.*) /),
        version: getSecondMatch(/^(.*)\/(.*) /)
     };
   }

    // set webkit or gecko flag for browsers based on these engines
    if (!result.msedge && /(apple)?webkit/i.test(ua)) {
      if (/(apple)?webkit\/537\.36/i.test(ua)) {
        result.name = result.name || "Blink"
        result.blink = t
      } else {
        result.name = result.name || "Webkit"
        result.webkit = t
      }
      if (!result.version && versionIdentifier) {
        result.version = versionIdentifier
      }
    } else if (!result.opera && /gecko\//i.test(ua)) {
      result.name = result.name || "Gecko"
      result.gecko = t
      result.version = result.version || getFirstMatch(/gecko\/(\d+(\.\d+)?)/i)
    }

    // set OS flags for platforms that have multiple browsers
    if (!result.windowsphone && !result.msedge && (android || result.silk)) {
      result.android = t
    } else if (!result.windowsphone && !result.msedge && iosdevice) {
      result[iosdevice] = t
      result.ios = t
    } else if (mac) {
      result.mac = t
    } else if (xbox) {
      result.xbox = t
    } else if (windows) {
      result.windows = t
    } else if (linux) {
      result.linux = t
    }

    function getWindowsVersion (s) {
      switch (s) {
        case 'NT': return 'NT'
        case 'XP': return 'XP'
        case 'NT 5.0': return '2000'
        case 'NT 5.1': return 'XP'
        case 'NT 5.2': return '2003'
        case 'NT 6.0': return 'Vista'
        case 'NT 6.1': return '7'
        case 'NT 6.2': return '8'
        case 'NT 6.3': return '8.1'
        case 'NT 10.0': return '10'
        default: return undefined
      }
    }

    // OS version extraction
    var osVersion = '';
    if (result.windows) {
      osVersion = getWindowsVersion(getFirstMatch(/Windows ((NT|XP)( \d\d?.\d)?)/i))
    } else if (result.windowsphone) {
      osVersion = getFirstMatch(/windows phone (?:os)?\s?(\d+(\.\d+)*)/i);
    } else if (result.mac) {
      osVersion = getFirstMatch(/Mac OS X (\d+([_\.\s]\d+)*)/i);
      osVersion = osVersion.replace(/[_\s]/g, '.');
    } else if (iosdevice) {
      osVersion = getFirstMatch(/os (\d+([_\s]\d+)*) like mac os x/i);
      osVersion = osVersion.replace(/[_\s]/g, '.');
    } else if (android) {
      osVersion = getFirstMatch(/android[ \/-](\d+(\.\d+)*)/i);
    } else if (result.webos) {
      osVersion = getFirstMatch(/(?:web|hpw)os\/(\d+(\.\d+)*)/i);
    } else if (result.blackberry) {
      osVersion = getFirstMatch(/rim\stablet\sos\s(\d+(\.\d+)*)/i);
    } else if (result.bada) {
      osVersion = getFirstMatch(/bada\/(\d+(\.\d+)*)/i);
    } else if (result.tizen) {
      osVersion = getFirstMatch(/tizen[\/\s](\d+(\.\d+)*)/i);
    }
    if (osVersion) {
      result.osversion = osVersion;
    }

    // device type extraction
    var osMajorVersion = !result.windows && osVersion.split('.')[0];
    if (
         tablet
      || nexusTablet
      || iosdevice == 'ipad'
      || (android && (osMajorVersion == 3 || (osMajorVersion >= 4 && !mobile)))
      || result.silk
    ) {
      result.tablet = t
    } else if (
         mobile
      || iosdevice == 'iphone'
      || iosdevice == 'ipod'
      || android
      || nexusMobile
      || result.blackberry
      || result.webos
      || result.bada
    ) {
      result.mobile = t
    }

    // Graded Browser Support
    // http://developer.yahoo.com/yui/articles/gbs
    if (result.msedge ||
        (result.msie && result.version >= 10) ||
        (result.yandexbrowser && result.version >= 15) ||
		    (result.vivaldi && result.version >= 1.0) ||
        (result.chrome && result.version >= 20) ||
        (result.samsungBrowser && result.version >= 4) ||
        (result.firefox && result.version >= 20.0) ||
        (result.safari && result.version >= 6) ||
        (result.opera && result.version >= 10.0) ||
        (result.ios && result.osversion && result.osversion.split(".")[0] >= 6) ||
        (result.blackberry && result.version >= 10.1)
        || (result.chromium && result.version >= 20)
        ) {
      result.a = t;
    }
    else if ((result.msie && result.version < 10) ||
        (result.chrome && result.version < 20) ||
        (result.firefox && result.version < 20.0) ||
        (result.safari && result.version < 6) ||
        (result.opera && result.version < 10.0) ||
        (result.ios && result.osversion && result.osversion.split(".")[0] < 6)
        || (result.chromium && result.version < 20)
        ) {
      result.c = t
    } else result.x = t

    return result
  }

  var bowser = detect(typeof navigator !== 'undefined' ? navigator.userAgent || '' : '')

  bowser.test = function (browserList) {
    for (var i = 0; i < browserList.length; ++i) {
      var browserItem = browserList[i];
      if (typeof browserItem=== 'string') {
        if (browserItem in bowser) {
          return true;
        }
      }
    }
    return false;
  }

  /**
   * Get version precisions count
   *
   * @example
   *   getVersionPrecision("1.10.3") // 3
   *
   * @param  {string} version
   * @return {number}
   */
  function getVersionPrecision(version) {
    return version.split(".").length;
  }

  /**
   * Array::map polyfill
   *
   * @param  {Array} arr
   * @param  {Function} iterator
   * @return {Array}
   */
  function map(arr, iterator) {
    var result = [], i;
    if (Array.prototype.map) {
      return Array.prototype.map.call(arr, iterator);
    }
    for (i = 0; i < arr.length; i++) {
      result.push(iterator(arr[i]));
    }
    return result;
  }

  /**
   * Calculate browser version weight
   *
   * @example
   *   compareVersions(['1.10.2.1',  '1.8.2.1.90'])    // 1
   *   compareVersions(['1.010.2.1', '1.09.2.1.90']);  // 1
   *   compareVersions(['1.10.2.1',  '1.10.2.1']);     // 0
   *   compareVersions(['1.10.2.1',  '1.0800.2']);     // -1
   *
   * @param  {Array<String>} versions versions to compare
   * @return {Number} comparison result
   */
  function compareVersions(versions) {
    // 1) get common precision for both versions, for example for "10.0" and "9" it should be 2
    var precision = Math.max(getVersionPrecision(versions[0]), getVersionPrecision(versions[1]));
    var chunks = map(versions, function (version) {
      var delta = precision - getVersionPrecision(version);

      // 2) "9" -> "9.0" (for precision = 2)
      version = version + new Array(delta + 1).join(".0");

      // 3) "9.0" -> ["000000000"", "000000009"]
      return map(version.split("."), function (chunk) {
        return new Array(20 - chunk.length).join("0") + chunk;
      }).reverse();
    });

    // iterate in reverse order by reversed chunks array
    while (--precision >= 0) {
      // 4) compare: "000000009" > "000000010" = false (but "9" > "10" = true)
      if (chunks[0][precision] > chunks[1][precision]) {
        return 1;
      }
      else if (chunks[0][precision] === chunks[1][precision]) {
        if (precision === 0) {
          // all version chunks are same
          return 0;
        }
      }
      else {
        return -1;
      }
    }
  }

  /**
   * Check if browser is unsupported
   *
   * @example
   *   bowser.isUnsupportedBrowser({
   *     msie: "10",
   *     firefox: "23",
   *     chrome: "29",
   *     safari: "5.1",
   *     opera: "16",
   *     phantom: "534"
   *   });
   *
   * @param  {Object}  minVersions map of minimal version to browser
   * @param  {Boolean} [strictMode = false] flag to return false if browser wasn't found in map
   * @param  {String}  [ua] user agent string
   * @return {Boolean}
   */
  function isUnsupportedBrowser(minVersions, strictMode, ua) {
    var _bowser = bowser;

    // make strictMode param optional with ua param usage
    if (typeof strictMode === 'string') {
      ua = strictMode;
      strictMode = void(0);
    }

    if (strictMode === void(0)) {
      strictMode = false;
    }
    if (ua) {
      _bowser = detect(ua);
    }

    var version = "" + _bowser.version;
    for (var browser in minVersions) {
      if (minVersions.hasOwnProperty(browser)) {
        if (_bowser[browser]) {
          if (typeof minVersions[browser] !== 'string') {
            throw new Error('Browser version in the minVersion map should be a string: ' + browser + ': ' + String(minVersions));
          }

          // browser version and min supported version.
          return compareVersions([version, minVersions[browser]]) < 0;
        }
      }
    }

    return strictMode; // not found
  }

  /**
   * Check if browser is supported
   *
   * @param  {Object} minVersions map of minimal version to browser
   * @param  {Boolean} [strictMode = false] flag to return false if browser wasn't found in map
   * @param  {String}  [ua] user agent string
   * @return {Boolean}
   */
  function check(minVersions, strictMode, ua) {
    return !isUnsupportedBrowser(minVersions, strictMode, ua);
  }

  bowser.isUnsupportedBrowser = isUnsupportedBrowser;
  bowser.compareVersions = compareVersions;
  bowser.check = check;

  /*
   * Set our detect method to the main bowser object so we can
   * reuse it to test other user agents.
   * This is needed to implement future tests.
   */
  bowser._detect = detect;

  return bowser
});

angular.module('dnd', [])

.factory('dndFactory', function() {
	return {
		data : {content: null, pos:null, element : null},
		content : function(value) {
			this.data.content = value;
		},
		elmnSet : function(e) {
			this.data.element = e;
		},
		elmnGet : function() {
			return this.data.element;
		},
		get : function() {
			return this.data;
		},
		pos: function(pos) {
			this.data.pos = pos;
		}
	}
})

/**
 * Usage:
 * 
 * ```js
 * dnd dnd-model="data" dnd-isvalid="isValid(hover,dragged)" dnd-drag-disabled dnd-diable-drag-middle dnd-drop-disabled dnd-ondrop="dropItem(dragged,dropped,position)" dnd-css="{onDrag: 'drag-start', onHover: 'red', onHoverTop: 'red-top', onHoverMiddle: 'red-middle', onHoverBottom: 'red-bottom'}"
 * ```
 * 
 * + dnd-model: This is the model which will be used as "dropped", when drag is disabled this model is not needed
 * + dnd-disable-drag-middle
 * + dnd-drag-disabled
 * + dnd-is-valid
 */
.directive('dnd', function(dndFactory) {
	return {
		restrict : 'A',
		transclude: false,
		replace: false,
		template: false,
		templateURL: false,
		scope: {
			dndModel : '=',
			dndCss : '=',
			dndOndrop : '&',
			dndIsvalid : '&',
		},
		link: function(scope, element, attrs) {
			var isValid = true;
			
			var disableMiddleDrop = attrs.hasOwnProperty('dndDisableDragMiddle');
			
	        // this gives us the native JS object
	        var dragable = element[0];
	
	        /* DRAGABLE */
	        
	        if (!attrs.hasOwnProperty('dndDragDisabled')) {
	        	dragable.draggable = true;
	        }
	
	        dragable.addEventListener(
	            'dragstart',
	            function(e) {
	            	e.stopPropagation();
	            	isValid = true;
	            	dndFactory.content(scope.dndModel);
	            	dndFactory.elmnSet(dragable);
	                this.classList.add(scope.dndCss.onDrag);
	                
	                if (e.dataTransfer) {
	                	e.dataTransfer.setData('text', 1);
	                }
	                // return false;
	            },
	            false
	        );
	
	        dragable.addEventListener(
	            'dragend',
	            function(e) {
	                this.classList.remove(scope.dndCss.onDrag);
	                // return false;
	            },
	            false
	        );
	        
	        /* DROPABLE */
	        
	        var el = element[0];
	          
        	el.addEventListener(
    		    'dragover',
    		    function(e) {
    		        e.dataTransfer.dropEffect = 'move';
    		        // allows us to drop
    		        if (e.preventDefault) { e.preventDefault(); }
    		        if (!scope.dndIsvalid({hover:  scope.dndModel, dragged: dndFactory.get().content})) {
		        		e.stopPropagation();
		        		e.preventDefault();
		        		isValid = false;
		        		// return false;
		        	}
    		        
                    var re = el.getBoundingClientRect();
    		        var height = re.height;
    		        var mouseHeight = e.clientY - re.top;
    		        var percentage = (100 / height) * mouseHeight;
    		        if (disableMiddleDrop) {
    		        	if (percentage <= 50) {
        		        	this.classList.add(scope.dndCss.onHoverTop);
        		        	this.classList.remove(scope.dndCss.onHoverMiddle);
        		        	this.classList.remove(scope.dndCss.onHoverBottom);
        		        	dndFactory.pos('top');
        		        } else {
        		        	this.classList.remove(scope.dndCss.onHoverTop);
        		        	this.classList.remove(scope.dndCss.onHoverMiddle);
        		        	this.classList.add(scope.dndCss.onHoverBottom);
        		        	dndFactory.pos('bottom');
        		        }
    		        } else {
    		        	if (percentage <= 25) {
        		        	this.classList.add(scope.dndCss.onHoverTop);
        		        	this.classList.remove(scope.dndCss.onHoverMiddle);
        		        	this.classList.remove(scope.dndCss.onHoverBottom);
        		        	dndFactory.pos('top');
        		        } else if (percentage >= 65) {
        		        	this.classList.remove(scope.dndCss.onHoverTop);
        		        	this.classList.remove(scope.dndCss.onHoverMiddle);
        		        	this.classList.add(scope.dndCss.onHoverBottom);
        		        	dndFactory.pos('bottom');
        		        } else {
        		        	this.classList.remove(scope.dndCss.onHoverTop);
        		        	this.classList.add(scope.dndCss.onHoverMiddle);
        		        	this.classList.remove(scope.dndCss.onHoverBottom);
        		        	dndFactory.pos('middle');
        		        }
    		        }
    		        
    		        this.classList.add(scope.dndCss.onHover);
    		        // return false;
    		    },
    		    false
    		);
        	
        	el.addEventListener(
    		    'dragenter',
    		    function(e) {
    		        this.classList.add(scope.dndCss.onHover);
    		        // return false;
    		    },
    		    false
    		);

    		el.addEventListener(
    		    'dragleave',
    		    function(e) {
    		        this.classList.remove(scope.dndCss.onHover);
    		        this.classList.remove(scope.dndCss.onHoverTop);
    		        this.classList.remove(scope.dndCss.onHoverMiddle);
    		        this.classList.remove(scope.dndCss.onHoverBottom);
    		        // return false;
    		    },
    		    false
    		);

    		if (!attrs.hasOwnProperty('dndDropDisabled')) {
	            el.addEventListener(
	                'drop',
	                function(e) {
	                	if (e.preventDefault) { e.preventDefault(); }
	                    if (e.stopPropagation) { e.stopPropagation(); }
	                    this.classList.remove(scope.dndCss.onHover);
	    		        this.classList.remove(scope.dndCss.onHoverTop);
	    		        this.classList.remove(scope.dndCss.onHoverMiddle);
	    		        this.classList.remove(scope.dndCss.onHoverBottom);
	    		        if (isValid) {
		                	scope.$apply(function() {
		                		scope.dndOndrop({dragged: dndFactory.get().content, dropped: scope.dndModel, position: dndFactory.get().pos});
		                	});
	    		        }
	                	// return false;
	                },
	                false
	            );
    		}
		}
	};
});
var zaa = angular.module("zaa", ["ui.router", "dnd", "angular-loading-bar", "ngFileUpload", "ngWig", "flow", "angular.filter", "720kb.datepicker", "directive.ngColorwheel"]);

/**
 * guid creator
 * @returns {String}
 */
function guid() {
    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
    }

    return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
}

/**
 * i18n localisation with params.
 *
 * ```js
 * i18nParam('js_i18n_translation_name', {variable: value});
 * ```
 *
 * Translations File:
 *
 * ```php
 * 'js_i18n_translation_name' => 'Hello %variable%',
 * ```
 * @param varName
 * @param params
 * @returns
 */
function i18nParam(varName, params) {
    var varValue = i18n[varName];

    angular.forEach(params, function (value, key) {
        varValue = varValue.replace("%" + key + "%", value);
    });

    return varValue;
}

/**
 * Type cast numeric values to integer
 *
 * @param value
 * @returns
 */
function typeCastValue(value) {
    return $.isNumeric(value) ? parseInt(value) : value;
}

(function () {
    "use strict";

    /* CONFIG */
    
    zaa.config(function ($httpProvider, $stateProvider, $controllerProvider, $urlMatcherFactoryProvider) {
    	
        $httpProvider.interceptors.push("authInterceptor");

        zaa.bootstrap = $controllerProvider;

        $urlMatcherFactoryProvider.strictMode(false)

        $stateProvider
            .state("default", {
                url: "/default/:moduleId",
                templateUrl: function ($stateParams) {
                    return "admin/template/default";
                }
            })
            .state("default.route", {
                url: "/:moduleRouteId/:controllerId/:actionId",
                templateUrl: function ($stateParams) {
                    return $stateParams.moduleRouteId + "/" + $stateParams.controllerId + "/" + $stateParams.actionId;
                },
                parent: 'default',
                resolve: {
                    adminServiceResolver: adminServiceResolver
                }
            })
            .state("custom", {
                url: "/template/:templateId",
                templateUrl: function ($stateParams) {
                    return $stateParams.templateId;
                },
                resolve: {
                    adminServiceResolver: adminServiceResolver,
                    resolver: function (resolver) {
                        return resolver.then;
                    },
                }
            })
            .state("home", {
                url: "",
                templateUrl: "admin/default/dashboard"
            });
    });

    /* PROVIDERS */
    
    /**
     * attach custom callback function to the custom state resolve. Use the resolverProvider in
     * your configuration part:
     *
     * zaa.config(function(resolverProvider) {
	 *		resolverProvider.addCallback(function(ServiceMenuData, ServiceBlocksData) {
	 *			ServiceMenuData.load();
	 *			ServiceBlocksData.load();
	 *		});
	 * });
     */
    zaa.provider("resolver", function () {
        var list = [];

        this.addCallback = function (callback) {
            list.push(callback);
        }

        this.$get = function ($injector, $q, $state) {
            return $q(function (resolve, reject) {
                for (var i in list) {
                    $injector.invoke(list[i]);
                }
            })
        }
    });

    /* FACTORIES */
    
    /**
     * LUYA LOADING
     */
    zaa.factory("LuyaLoading", function ($timeout) {

        var state = false;
        var stateMessage = null;
        var timeoutPromise = null;

        return {
            start: function (myMessage) {
                if (myMessage == undefined) {
                    stateMessage = i18n['js_zaa_server_proccess'];
                } else {
                    stateMessage = myMessage;
                }
                // rm previous timeouts
                $timeout.cancel(timeoutPromise);

                timeoutPromise = $timeout(function () {
                    state = true;
                }, 2000);
            },
            stop: function () {
                $timeout.cancel(timeoutPromise);
                state = false;
            },
            getStateMessage: function () {
                return stateMessage;
            },
            getState: function () {
                return state;
            }
        }
    });
    
    /**
     * Inside your Directive or Controller:
     * 
     * ```js
     * AdminClassService.setClassSpace('modalBody', 'modal-open')
     * ```
     * 
     * Inside your HTML layout file:
     * 
     * ```html
     * <div class="{{AdminClassService.getClassSpace('modalBody')}}" />
     * ```
     * 
     * In order to clear the class space afterwards:
     * 
     * ```js
     * AdminClassService.clearSpace('modalBody');
     * ```
     */
    zaa.factory("AdminClassService", function () {

        var service = [];

        service.vars = {};

        service.getClassSpace = function (spaceName) {
            if (service.vars.hasOwnProperty(spaceName)) {
                return service.vars[spaceName];
            }
        };

        service.hasClassSpace = function(spaceName) {
        	 if (service.vars.hasOwnProperty(spaceName)) {
        		 return true;
        	 }
        	 
        	 return false;
        };
        
        service.setClassSpace = function (spaceName, className) {
            service.vars[spaceName] = className;
        };
        
        service.clearSpace = function(spaceName) {
        	if (service.vars.hasOwnProperty(spaceName)) {
        		service.vars[spaceName] = null;
        	}
        };
        
        service.removeSpace = function(spaceName) {
        	if (service.hasClassSpace(spaceName)) {
        		delete service.vars[spaceName];
        	}
        };

        return service;
    });
    
    zaa.factory('CacheReloadService', function ($http, $window) {

        var service = [];

        service.reload = function () {
            $http.get("admin/api-admin-common/cache").then(function (response) {
                $window.location.reload();
            });
        }

        return service;
    });
    
    zaa.factory("authInterceptor", function ($rootScope, $q, AdminToastService, AdminDebugBar) {
        return {
            request: function (config) {
            	if (!config.hasOwnProperty('ignoreLoadingBar')) {
            		config.debugId = AdminDebugBar.pushRequest(config);
            	}
                config.headers = config.headers || {};
                config.headers.Authorization = "Bearer " + $rootScope.luyacfg.authToken;
                config.headers['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr("content");
                
                return config || $q.when(config);
            },
            response: function(config) {
            	if (!config.hasOwnProperty('ignoreLoadingBar')) {
            		AdminDebugBar.pushResponse(config);
            	}
            	
            	return config || $q.when(config);
            },
            responseError: function (data) {
                if (data.status == 401 || data.status == 403 || data.status == 405) {
                    window.location = "admin/default/logout";
                } else if (data.status != 422) {
                	var message = data.data.hasOwnProperty('message');
                	if (message) {
                		AdminToastService.error(data.data.message, 10000);
                	} else {
                		AdminToastService.error("Response Error: " + data.status + " " + data.statusText, 10000);
                	}
                    
                }
                
                return data || $q.when(data);
            }
        };
    });

})();
// service resolver
function adminServiceResolver(ServiceFoldersData, ServiceImagesData, ServiceFilesData, ServiceFiltersData, ServiceLanguagesData, ServicePropertiesData, AdminLangService, ServiceFoldersDirecotryId) {
	ServiceFiltersData.load();
	ServiceFoldersData.load();
	ServiceImagesData.load();
	ServiceFilesData.load();
	ServiceLanguagesData.load();
	ServicePropertiesData.load();
	AdminLangService.load();
	ServiceFoldersDirecotryId.load();
};

/**
 * all global admin services
 * 
 * controller resolve: https://github.com/johnpapa/angular-styleguide#style-y080
 * 
 * Service Inheritance:
 * 
 * 1. Service must be prefix with Service
 * 2. Service must contain a forceReload state
 * 3. Service must broadcast an event 'service:FoldersData'
 * 4. Controller integration must look like
 * 
 * ```
 * $scope.foldersData = ServiceFoldersData.data;
 *				
 * $scope.$on('service:FoldersData', function(event, data) {
 *      $scope.foldersData = data;
 * });
 *				
 * $scope.foldersDataReload = function() {
 *     return ServiceFoldersData.load(true);
 * }
 * ```
 * 
 */
(function() {
	"use strict";
	
/*

$scope.foldersData = ServiceFoldersData.data;
					
$scope.$on('service:FoldersData', function(event, data) {
	$scope.foldersData = data;
});

$scope.foldersDataReload = function() {
	return ServiceFoldersData.load(true);
}

*/
zaa.factory("ServiceFoldersData", function($http, $q, $rootScope) {
	
	var service = [];
	
	service.data = null;
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data !== null && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-storage/data-folders").then(function(response) {
					service.data = response.data;
					$rootScope.$broadcast('service:FoldersData', service.data);
					resolve(service.data);
				});
			}
		});
	};
	
	return service;
});

/*

$scope.folderId = ServiceFoldersDirecotryId.folderId;
					
$scope.$on('FoldersDirectoryId', function(event, folderId) {
	$scope.folderId = folderId;
});

$scope.foldersDirecotryIdReload = function() {
	return ServiceFoldersDirecotryId.load(true);
}

*/
zaa.factory("ServiceFoldersDirecotryId", function($http, $q, $rootScope) {
	
	var service = [];
	
	service.folderId = false;
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.folderId !== false && forceReload !== true) {
				resolve(service.folderId);
			} else {
				$http.get("admin/api-admin-common/get-filemanager-folder-state").then(function(response) {
					service.folderId = response.data;
					$rootScope.$broadcast('service:FoldersDirectoryId', service.folderId);
					resolve(service.folderId);
				});
			}
		});
	};
	
	return service;
});

/*

$scope.imagesData = ServiceImagesData.data;
				
$scope.$on('service:ImagesData', function(event, data) {
	$scope.imagesData = data;
});

$scope.imagesDataReload = function() {
	return ServiceImagesData.load(true);
}

*/
zaa.factory("ServiceImagesData", function($http, $q, $rootScope) {
	var service = [];
	
	service.data = null;
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data !== null && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-storage/data-images").then(function(response) {
					service.data = response.data;
					$rootScope.$broadcast('service:ImagesData', service.data);
					resolve(service.data);
				});
			}
		});
	};
	
	return service;
});

/*

$scope.filesData = ServiceFilesData.data;
				
$scope.$on('service:FilesData', function(event, data) {
	$scope.filesData = data;
});

$scope.filesDataReload = function() {
	return ServiceFilesData.load(true);
}
				
*/
zaa.factory("ServiceFilesData", function($http, $q, $rootScope) {
	var service = [];
	
	service.data = null;
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data !== null && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-storage/data-files").then(function(response) {
					service.data = response.data;
					$rootScope.$broadcast('service:FilesData', service.data);
					resolve(service.data);
				});
			}
		});
	};
	
	return service;
});

/*

$scope.filtersData = ServiceFiltersData.data;
				
$scope.$on('service:FiltersData', function(event, data) {
	$scope.filtersData = data;
});

$scope.filtersDataReload = function() {
	return ServiceFiltersData.load(true);
}
				
*/
zaa.factory("ServiceFiltersData", function($http, $q, $rootScope) {
	var service = [];
	
	service.data = null;
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data !== null && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-storage/data-filters").then(function(response) {
					service.data = response.data;
					$rootScope.$broadcast('service:FiltersData', service.data);
					resolve(service.data);
				});
			}
		});
	};
	
	return service;
});

/*

$scope.languagesData = ServiceLanguagesData.data;
				
$scope.$on('service:LanguagesData', function(event, data) {
	$scope.languagesData = data;
});

$scope.languagesDataReload = function() {
	return ServiceLanguagesData.load(true);
}
				
*/
zaa.factory("ServiceLanguagesData", function($http, $q, $rootScope) {
	var service = [];
	
	service.data = [];
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data.length > 0 && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-common/data-languages").then(function(response) {
					service.data = response.data;
					$rootScope.$broadcast('service:LanguagesData', service.data);
					resolve(service.data);
				})
			}
		});
	};
	
	return service;
});

/*

$scope.propertiesData = ServicePropertiesData.data;
				
$scope.$on('service:PropertiesData', function(event, data) {
	$scope.propertiesData = data;
});

$scope.propertiesDataReload = function() {
	return ServicePropertiesData.load(true);
}
				
*/
zaa.factory("ServicePropertiesData", function($http, $q, $rootScope) {
	var service = [];
	
	service.data = null;
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data !== null && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-common/data-properties").then(function(response) {
					service.data = response.data;
					$rootScope.$broadcast('service:PropertiesData', service.data);
					resolve(service.data);
				})
			}
		});
	};
	
	return service;
});

zaa.factory("CrudTabService", function() {
	
	var service = [];
	
	service.tabs = [];
	
	service.remove = function(index, $scope) {
		service.tabs.splice(index, 1);
		
		if (service.tabs.length > 0) {
			var lastTab = service.tabs.slice(-1)[0];
			lastTab.active = true;
		} else {
			$scope.switchTo(0);
		}
	};
	
	service.addTab = function(id, api, arrayIndex, name, modelClass) {
		service.tabs.push({id: id, api: api, arrayIndex: arrayIndex, active: false, name: name, modelClass:modelClass});
	};
	
	service.clear = function() {
		service.tabs = [];
	};
	
	return service;
});

/*
 
 language service with selections
 
*/
zaa.factory("AdminLangService", function(ServiceLanguagesData, $rootScope) {
	
	var service = [];
	
	service.data = [];
	
	service.selection = [];
	
	service.toggleSelection = function(lang) {
		var exists = service.selection.indexOf(lang.short_code);
		
		if (exists == -1) {
			service.selection.push(lang.short_code);
			$rootScope.$broadcast('service:LoadLanguage', lang);
		} else {
			/* #531: unable to deselect language, as at least 1 langauge must be activated. */
			if (service.selection.length > 1) {
				service.selection.splice(exists, 1);
			}
		}
	};
	
	service.isInSelection = function(langShortCode) {
		var exists = service.selection.indexOf(langShortCode);
		if (exists == -1) {
			return false;
		}
		return true;
	};
	
	service.resetDefault = function() {
		service.selection = [];
		angular.forEach(ServiceLanguagesData.data, function(value, key) {
			if (value.is_default == 1) {
				if (!service.isInSelection(value.short_code)) {
					service.toggleSelection(value);
				}
			}
		})
	};
	
	service.load = function() {
		ServiceLanguagesData.load().then(function(data) {
			service.data = data;
			
			angular.forEach(data, function(value) {
				if (value.is_default == 1) {
					if (!service.isInSelection(value.short_code)) {
						service.toggleSelection(value);
					}
				}
			})
			
		});
	};
	
	return service;
});

/*
 * Admin Debug Bar provides an array with debug information from the last request in order to find bugs without the developer tools of the browser 
 */
zaa.factory("AdminDebugBar", function() {
	
	var service = [];
	
	service.data = [];
	
	service.clear = function() {
		service.data = [];
	};
	
	service.pushRequest = function(request) {
		return service.data.push({'url': request.url, 'requestData': request.data, 'responseData': null, 'responseStatus' : null, start:new Date(), end:null, parseTime: null});
	};
	
	service.pushResponse = function(response) {
		var responseCopy = response;
		
		var serviceData = service.data[responseCopy.config.debugId];
		
		if (serviceData) {
			serviceData.responseData = responseCopy.data;
			serviceData.responseStatus = responseCopy.status;
			serviceData.end = new Date();
			serviceData.parseTime = new Date() - serviceData.start;
		}
		
		return response;
	};
	
	return service;
});

/*

$scope.filesData = ServiceFilesData.data;
				
$scope.$on('service:AdminToast', function(event, data) {
	$scope.filesData = data;
});

Examples

AdminToastService.notify('Hello i am Message and will be dismissed in 2 Seconds', 2000');

AdminToastService.confirm('Hello i am a callback and wait for your', 'Das löschen?', function($q, $http) {
	// do some ajax call
	$http.get().then(function() {
		promise.resolve();
	}).error(function() {
		promise.reject();
	});
});

you can also close this dialog by sourself in the callback

AdminToastService.confi('Message', function() {
	// do something
	this.close();
});

instead of this you can also invoke $toast

function($toast) {
	$toast.close();
}

*/
zaa.factory("AdminToastService", function($q, $timeout, $injector) {
	var service = [];
	
	service.notify = function(message, timeout, type) {
		
		var uuid = guid();
		
		service.queue[uuid] = {message: message, timeout: timeout, uuid: uuid, type: type, close: function() {
			delete service.queue[this.uuid];
		}};
		
		$timeout(function() {
			delete service.queue[uuid];
		}, timeout);
	};
	
	service.success = function(message, timeout) {
		service.notify(message, timeout, 'success');
	};

    service.info = function(message, timeout) {
        service.notify(message, timeout, 'info');
    };

    service.warning = function(message, timeout) {
        service.notify(message, timeout, 'warning');
    };
	
	service.error = function(message, timeout) {
		service.notify(message, timeout, 'error');
	};
	
	service.errorArray = function(array, timeout) {
		angular.forEach(array, function(value, key) {
			service.error(value.message, timeout);
		});
	};
	
	service.confirm = function(message, title, callback) {
		var uuid = guid();
		service.queue[uuid] = {message: message, title:title, click: function() {
			var queue = this;
			var response = $injector.invoke(this.callback, this, { $toast : this });
			if (response !== undefined) {
				response.then(function(r) {
						queue.close();
					}, function(r) {
						queue.close();
					}, function(r) {
						// call loader later?
					});
			}
		}, uuid: uuid, callback: callback, type: 'confirm', close: function() {
			delete service.queue[this.uuid];
		}}
	};
	
	service.queue = {};
	
	return service;
});

/*
 * 
 * Saving data in Html Storage
 * 
 *	$scope.isHover = HtmlStorage.getValue('sidebarToggleState', false); 
 *		
 *	$scope.toggleMainNavSize = function() {
 *	    $scope.isHover = !$scope.isHover;
 *	    HtmlStorage.setValue('sidebarToggleState', $scope.isHover);
 *	}
 */
zaa.factory('HtmlStorage', function() {
	var service = {
		
		data: {},
		
		isLoaded : false,
		
		loadData : function() {
			if (!service.isLoaded) {
				if (localStorage.getItem("HtmlStorage")) {
					var data = angular.fromJson(localStorage.getItem('HtmlStorage'));
					
					service.data = data;
				}
			}
		},
		
		saveData : function() {
			localStorage.removeItem('HtmlStorage');
			localStorage.setItem('HtmlStorage', angular.toJson(service.data));
		},
		
		getValue : function(key, defaultValue) {
			service.loadData();
			
			if (service.data.hasOwnProperty(key)) {
				return service.data[key];
			}
			
			return defaultValue;
		},
		
		setValue : function(key, value) {
			service.loadData();
			
			service.data[key] = value;
			
			service.saveData();
		}
	};
	
	return service;
});

// end of use strict
})();
(function() {
    "use strict";
    
    zaa.filter("filemanagerdirsfilter", function() {
        return function(input, parentFolderId) {
            var result = [];
            angular.forEach(input, function(value, key) {
                if (value.parentId == parentFolderId) {
                    result.push(value);
                }
            });

            return result;
        };
    });

    zaa.filter("findthumbnail", function() {
    	return function(input, fileId, thumbnailFilterId) {
    		var result = false;
    		angular.forEach(input, function(value, key) {
    			if (!result) {
	    			if (value.fileId == fileId && value.filterId == thumbnailFilterId) {
	    				result = value;
	    			}
    			}
    		})

    		return result;
    	}
    });

    zaa.filter("findidfilter", function() {
        return function(input, id) {

            var result = false;

            angular.forEach(input, function(value, key) {
                if (value.id == id) {
                    result = value;
                }
            });

            return result;
        }
    });

    zaa.filter("filemanagerfilesfilter", function() {
        return function(input, folderId, onlyImages) {

            var result = [];

            angular.forEach(input, function(data) {
                if (onlyImages) {
                    if (data.folderId == folderId && data.isImage == true) {
                        result.push(data);
                    }
                } else {
                    if (data.folderId == folderId) {
                        result.push(data);
                    }
                }
            });

            return result;
        };
    });
    
    zaa.filter('trustAsUnsafe', function ($sce) {
        return function (val, enabled) {
            return $sce.trustAsHtml(val);
        };
    });
    
    zaa.filter('srcbox', function () {
        return function (input, search) {
            if (!input) return input;
            if (!search) return input;
            var expected = ('' + search).toLowerCase();
            var result = {};
            angular.forEach(input, function (value, key) {
                angular.forEach(value, function (kv, kk) {
                    var actual = ('' + kv).toLowerCase();
                    if (actual.indexOf(expected) !== -1) {
                        result[key] = value;
                    }
                });
            });
            return result;
        }
    });

    zaa.filter('trustAsResourceUrl', function ($sce) {
        return function (val, enabled) {
            if (!enabled) {
                return null;
            }
            return $sce.trustAsResourceUrl(val);
        };
    });

    zaa.filter('truncateMiddle', function () {
        return function (val, length, placeholder) {
            if(!length) {
                length = 30;
            }
            if(!placeholder) {
                placeholder = '...';
            }

            if(val.length <= length) {
                return val;
            }

            var targetLength = length - placeholder.length;
            var partLength = targetLength / 2;

            return (val.substring(0, partLength)) + placeholder + val.substring(val.length - partLength, val.length);
        };
    });
    
})();
(function() {
    "use strict";

    /* GLOBAL DIRECTIVES */
    
    /**
     * Controller: $scope.content = $sce.trustAsHtml(response.data);
     * Template: <div compile-html ng-bind-html="content | trustAsUnsafe"></div>
     */
    zaa.directive("compileHtml", function ($compile, $parse) {
        return {
            restrict: "A",
            link: function (scope, element, attr) {
                var parsed = $parse(attr.ngBindHtml);
                scope.$watch(function () {
                    return (parsed(scope) || "").toString();
                }, function () {
                    $compile(element, null, -9999)(scope);  //The -9999 makes it skip directives so that we do not recompile ourselves
                });
            }
        };
    });

    /**
     * Usage:
     *
     * ```
     * <div zaa-esc="methodClosesThisDiv()" />
     * ```
     */
    zaa.directive("zaaEsc", function () {
        return function (scope, element, attrs) {
            $(document).on("keyup", function (e) {
                if (e.keyCode == 27) {
                    scope.$apply(function () {
                        scope.$eval(attrs.zaaEsc);
                    });
                }
            });
        };
    });

    zaa.directive("linkObjectToString", function () {
        return {
            restrict: 'E',
            relace: true,
            scope: {
                'link': '='
            },
            template: function () {
                return '<span>' +
                	'<span ng-if="link.type==1"><show-internal-redirection nav-id="link.value" /></span>' +
                	'<span ng-if="link.type==2">{{link.value}}</span>' +
                    '<span ng-if="link.type==3"><storage-file-display file-id="{{link.value}}"></storage-file-display></span>' +
                    '<span ng-if="link.type==4">{{link.value}}</span>' +
                '</span>';
            }
        }
    });

    /**
     * Generate a Tool Tip – usage:
     *
     * The default tooltip is positioned on the right side of the element:
     *
     * ```html
     * <span tooltip tooltip-text="Tooltip">...</span>
     * ```
     *
     *
     * You can provide an Image URL beside or instead of text.
     *
     * ```html
     * <span tooltip tooltip-image-url="http://image.url">...</span>
     * ```
     *
     * Change the position (`top`, `right`, `bottom` or `left`):
     *
     * ```html
     * <span tooltip tooltip-text="Tooltip" tooltip-position="top">...</span>
     * ```
     *
     *
     * Add an offset to the generated position. The example below adds 5px offset from left and pulls the tooltip 5px up.
     *
     * ```html
     * <span tooltip tooltip-text="Tooltip" tooltip-offset-left="5" tooltip-offset-top="-5">...</span>
     * ```
     *
     *
     * In order to trigger an expression call instead of a static text use:
     *
     * ```html
     * <span tooltip tooltip-expression="scopeFunction(fooBar)">Span Text</span>
     * ```
     *
     *
     * Disable tooltip based on variable (two way binding):
     *
     * ```html
     * <span tooltip tooltip-text="Tooltip" tooltip-disabled="variableMightBeTrueMightBeFalseMightChange">Span Text</span>
     * ```
     */
    zaa.directive("tooltip", function ($document) {
        return {
            restrict: 'A',
            scope: {
                'tooltipText': '@',
                'tooltipExpression': '=',
                'tooltipPosition': '@',
                'tooltipOffsetTop': '@',
                'tooltipOffsetLeft': '@',
                'tooltipImageUrl': '@',
                'tooltipDisabled': '='
            },
            link: function (scope, element, attr) {
                var defaultPosition = 'right';

                var positions = {
                    top: function() {
                        var bcr = element[0].getBoundingClientRect();
                        return {
                            top: bcr.top - scope.pop.outerHeight(),
                            left: (bcr.left + (bcr.width / 2)) - (scope.pop.outerWidth() / 2),
                        }
                    },
                    bottom: function() {
                        var bcr = element[0].getBoundingClientRect();
                        return {
                            top: bcr.top + bcr.height,
                            left: (bcr.left + (bcr.width / 2)) - (scope.pop.outerWidth() / 2),
                        }
                    },
                    right: function() {
                        var bcr = element[0].getBoundingClientRect();
                        return {
                            top: (bcr.top + (bcr.height / 2)) - (scope.pop.outerHeight() / 2),
                            left: bcr.left + bcr.width
                        }
                    },
                    left: function() {
                        var bcr = element[0].getBoundingClientRect();
                        return {
                            top: (bcr.top + (bcr.height / 2)) - (scope.pop.outerHeight() / 2),
                            left: bcr.left - scope.pop.outerWidth()
                        }
                    }
                };

                var onScroll = function() {
                    var offset = {};
                    if(typeof positions[scope.tooltipPosition] === 'function') {
                        offset = positions[scope.tooltipPosition]();
                    } else {
                        offset = positions[defaultPosition]();
                    }

                    if (typeof scope.tooltipOffsetTop == 'number') {
                        offset.top = offset.top + scope.tooltipOffsetTop;
                    }

                    if (typeof scope.tooltipOffsetLeft == 'number') {
                        offset.left = offset.left + scope.tooltipOffsetLeft;
                    }

                    scope.pop.css(offset);
                };

                element.on('mouseenter', function () {

                    // Generate tooltip HTML for the first time
                    if(!scope.pop && (typeof scope.tooltipDisabled === 'undefined' || scope.tooltipDisabled === false)) {
                        if (scope.tooltipExpression) {
                            scope.tooltipText = scope.tooltipExpression;
                        }

                        var html =  '<div class="tooltip tooltip-' + (scope.tooltipPosition || defaultPosition) + (scope.tooltipImageUrl ? ' tooltip-image' : '') + '" role="tooltip">' +
                                        '<div class="tooltip-arrow"></div>' +
                                        '<div class="tooltip-inner">' +
                                        (scope.tooltipText ? ('<span class="tooltip-text">' + scope.tooltipText +  '</span>') : '') +
                                        '</div>' +
                                    '</div>';

                        var $html = $(html);

                        if(scope.tooltipImageUrl) {
                            var image = new Image();
                            image.onload = function() {
                                onScroll();
                            };
                            image.src = scope.tooltipImageUrl;
                            $html.find('.tooltip-inner').append(image);
                        }

                        scope.pop = $html;

                        $document.find('body').append(scope.pop);
                        scope.pop.hide();
                    }

                    // If tooltip shall be display...
                    if(scope.pop && (typeof scope.tooltipDisabled === 'undefined' || scope.tooltipDisabled === false)) {

                        // ..check position
                        onScroll();

                        // todo: Improve performance ...? x)
                        // ..register scroll listener
                        element.parents().on('scroll', onScroll);

                        // ..show popup
                        scope.pop.show();
                    }
                });

                element.on('mouseleave', function () {
                    element.parents().off('scroll', onScroll);

                    if(scope.pop) {
                        scope.pop.hide();
                    }
                });

                scope.$on('$destroy', function() {
                    if(scope.pop) {
                        scope.pop.remove();
                    }
                });
            }
        }
    });

    /**
     * Convert a string to number value, usefull in selects.
     *
     * ```
     * <select name="filterId" ng-model="filterId" convert-to-number>
     * ```
     */
    zaa.directive('convertToNumber', function () {
        return {
            require: 'ngModel',
            link: function (scope, element, attrs, ngModel) {
                ngModel.$parsers.push(function (val) {
                    return val != null ? parseInt(val, 10) : null;
                });
                ngModel.$formatters.push(function (val) {
                    return val != null ? '' + val : null;
                });
            }
        };
    });

    /**
     * Directive to trigger fixed table head
     */
    zaa.directive("fixedTableHead", function ($window) {
        return function (scope, element, attrs) {
            /**
             * Calculate the offset of the "thead" and apply it as transform
             */
            var onScroll = function () {
                var table = angular.element(element.find('table'));
                var thead = angular.element(table.find('thead'));

                if (table.length > 0 && thead.length > 0) {
                    thead.css('background-color', '#fff');

                    var tableOffset = table.offset().top - $('.navbar-fixed').height();

                    if (tableOffset <= 0) {
                        thead.css('transform', 'translateY(' + (-1 - tableOffset) + 'px)');
                        thead.css('box-shadow', '0 2px 2px 0 rgba(0, 0, 0, 0.05), 0 1px 5px 0 rgba(0, 0, 0, 0.04), 0 3px 1px -2px rgba(0, 0, 0, 0.1)');
                    } else {
                        thead.css('transform', 'none');
                        thead.css('box-shadow', 'none');
                    }
                }
            };

            onScroll();

            angular.element(element).bind("scroll", function () {
                onScroll();
            });
        };
    });

    /**
     * Apply auto generated height for textareas based on input values
     */
    zaa.directive('autoGrow', function () {
        return function (scope, element, attr) {
            var $shadow = null;

            var destroy = function () {
                if ($shadow != null) {
                    $shadow.remove();
                    $shadow = null;
                }
            };

            var update = function () {
                if ($shadow == null) {
                    $shadow = angular.element('<div></div>').css({
                        position: 'absolute',
                        top: -10000,
                        left: -10000,
                        resize: 'none'
                    });

                    angular.element(document.body).append($shadow);
                }

                $shadow.css({
                    fontSize: element.css('font-size'),
                    fontFamily: element.css('font-family'),
                    lineHeight: element.css('line-height'),
                    width: element.width(),
                    paddingTop: element.css('padding-top'),
                    paddingBottom: element.css('padding-bottom')
                });

                var times = function (string, number) {
                    for (var i = 0, r = ''; i < number; i++) {
                        r += string;
                    }
                    return r;
                };

                var val = element.val().replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/&/g, '&amp;')
                    .replace(/\n$/, '<br/>&nbsp;')
                    .replace(/\n/g, '<br/>')
                    .replace(/\s{2,}/g, function (space) {
                        return times('&nbsp;', space.length - 1) + ' '
                    });

                $shadow.html(val);

                element.css('height', $shadow.outerHeight() + 10 + 'px');
            };

            element.bind('keyup keydown keypress change click', update);
            element.bind('blur', destroy);
            update();
        }
    });

    zaa.directive('resizer', function ($document) {

        return {
            scope: {
                trigger: '@'
            },
            link: function ($scope, $element, $attrs) {

                $scope.$watch('trigger', function (n, o) {
                    if (n == 0) {
                        $($attrs.resizerLeft).removeAttr('style');
                        $($attrs.resizerRight).removeAttr('style');
                    }
                })

                $element.on('mousedown', function (event) {
                    event.preventDefault();
                    $document.on('mousemove', mousemove);
                    $document.on('mouseup', mouseup);
                });

                function mousemove(event) {

                    $($attrs.resizerCover).show();
                    // Handle vertical resizer
                    var x = event.pageX;
                    var i = window.innerWidth;

                    if (x < 600) {
                        x = 600;
                    }

                    if (x > (i - 400)) {
                        x = (i - 400);
                    }

                    var wl = $($attrs.resizerLeft).width();
                    var wr = $($attrs.resizerRight).width();

                    $($attrs.resizerLeft).css({
                        width: x + 'px'
                    });
                    $($attrs.resizerRight).css({
                        width: (i - x) + 'px'
                    });
                }

                function mouseup() {
                    $($attrs.resizerCover).hide();
                    $document.unbind('mousemove', mousemove);
                    $document.unbind('mouseup', mouseup);
                }
            }
        }
    });

    /**
     * Readded ng-confirm-click in order to provide quick ability to implement confirm boxes.
     *
     * ```
     * <button ng-confirm-click="Are you sure you want to to delete {{data.title}}?" confirmed-click="remove(data)">Remove</button>
     * ```
     */
    zaa.directive("ngConfirmClick", function () {
        return {
            link: function (scope, element, attr) {
                var msg = attr.ngConfirmClick || "Are you sure?";
                var clickAction = attr.confirmedClick;
                element.bind("click", function (event) {
                    if (window.confirm(msg)) {
                        scope.$eval(clickAction)
                    }
                });
            }
        };
    });

    /**
     * Focus a given input field if the statement is true.
     * 
     * ```
     * <input type="text" focus-me="searchInputOpen" />
     * ```
     */
    zaa.directive('focusMe', ['$timeout', '$parse', function ($timeout, $parse) {
        return {
            link: function (scope, element, attrs) {
                var model = $parse(attrs.focusMe);
                scope.$watch(model, function (value) {
                    if (value === true) {
                        $timeout(function () {
                            element[0].focus();
                        });
                    }
                });
                // on blur event:
                /*
                element.bind('blur', function () {
                    scope.$apply(model.assign(scope, false));
                });
                */
            }
        };
    }]);

    /**
     * ```
     * <a href="#" click-paste-pusher="foobar">Test</a>
     * ```
     */
    zaa.directive("clickPastePusher", ['$rootScope', '$compile', function ($rootScope, $compile) {
        return {
            restrict: 'A',
            replace: false,
            link: function (scope, element, attrs) {
                element.bind('click', function () {
                    $rootScope.$broadcast('insertPasteListener', attrs['clickPastePusher']);
                })
            }
        }
    }]);

    /**
     *
     * ```
     * $rootScope.$broadcast('insertPasteListener', $scope.someInput);
     * ```
     *
     * ```
     * <textarea insert-paste-listener></textarea>
     * ```
     */
    zaa.directive('insertPasteListener', ['$rootScope', function ($rootScope) {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                element.bind("focus", function () {
                    $rootScope.lastElement = element[0];
                    var offCallFn = $rootScope.$on('insertPasteListener', function (e, val) {
                        var domElement = $rootScope.lastElement;

                        if (domElement != element[0] || !domElement) {
                            return false;
                        }

                        $rootScope.$$listeners.insertPasteListener = [];

                        if (document.selection) {
                            domElement.focus();
                            var sel = document.selection.createRange();
                            sel.text = val;
                            domElement.focus();
                        } else if (domElement.selectionStart || domElement.selectionStart === 0) {
                            var startPos = domElement.selectionStart;
                            var endPos = domElement.selectionEnd;
                            var scrollTop = domElement.scrollTop;
                            domElement.value = domElement.value.substring(0, startPos) + val + domElement.value.substring(endPos, domElement.value.length);
                            domElement.focus();
                            domElement.selectionStart = startPos + val.length;
                            domElement.selectionEnd = startPos + val.length;
                            domElement.scrollTop = scrollTop;
                        } else {
                            domElement.value += val;
                            domElement.focus();
                        }
                    });
                });
            }
        }
    }]);
    

    /**
     * Example usage of luya admin modal:
     *
     * ```js
     * <button ng-click="modalState=!modalState">Toggle Modal</button>
     * <modal is-modal-hidden="modalState" modal-title="I am the Title">
     *     <h1>Modal Container</h1>
     *     <p>Hello world!</p>
     * </modal>
     * ```
     * 
     * If you want to hidden use ng-if with modals, you have to use ng-if inside the modal like:
     * 
     * ```js
     * <modal is-modal-hidden="modalState">
     *    <div ng-if="!modalState">
     *        <p>This is only linked when modalState is visible</p>
     *    </div>
     * </modal>
     * ```
     * 
     * > Using the ng-if outside of the modal wont work as it does not trigger the modalState due to child scope creation each time
     * > the ng-if is visible.
     * 
     */
    zaa.directive("modal", function ($timeout) {
        return {
            restrict: "E",
            scope: {
                isModalHidden: "=",
                title: '@modalTitle'
            },
            replace: true,
            transclude: true,
            templateUrl: "modal",
            controller : function($scope, AdminClassService) {
            	$scope.$watch('isModalHidden', function(n, o) {
            		if (n !== o) {
            			if (n) { // is hidden
            				if (AdminClassService.hasClassSpace('childModalBody')) {
            					AdminClassService.removeSpace('childModalBody');
            				} else {
            					AdminClassService.clearSpace('modalBody');
            					AdminClassService.removeSpace('childModalBody');
            				}
                		} else { // is visible
        					if (AdminClassService.getClassSpace('modalBody') == 'modal-open') {
                				AdminClassService.setClassSpace('childModalBody', true);
                			} else {
                				AdminClassService.setClassSpace('modalBody', 'modal-open');
                				AdminClassService.removeSpace('childModalBody');
                			}
                		}
            		}
            	});
            	
            	/* ESC Key will close ALL modals, therefore we ensure the correct spaces */
            	$scope.escModal = function() {
            		$scope.isModalHidden = true;
            		AdminClassService.removeSpace('childModalBody');
            		AdminClassService.clearSpace('modalBody');
            	};
            },
            link: function (scope, element) {
            	scope.$on('$destroy', function() {
            		element.remove();
            	});
            	angular.element(document.body).append(element);
            }
        }
    });
    
    /* CRUD, FORMS & FILE MANAGER */
    
    /**
     * If modelSelection and modelSetter is enabled, you can select a given row based in its primary key which will triggered the ngrest of the parent CRUD form.
     * 
     * ```
     * <crud-loader api="admin/api-admin-proxy" alias="Name of the CRUD Active Window"></crud-loader>
     * ```
     */
    zaa.directive("crudLoader", function($http, $sce) {
    	return {
    		restrict: "E",
    		replace: true,
    		transclude: false,
    		scope: {
    			"api": "@",
    			"alias" : "@",
    			"modelSelection" : "@",
    			"modelSetter": "="
    		},
    		controller: function($scope) {

    			$scope.input = { showWindow : true};

    			$scope.content = null;

    			$scope.toggleWindow = function() {
    				if ($scope.input.showWindow) {
    					$http.get($scope.api+'/?inline=1&modelSelection=' + $scope.modelSetter).then(function(response) {
    						$scope.content = $sce.trustAsHtml(response.data);
    						$scope.input.showWindow = false;
    					});
    				} else {
    					$scope.$parent.loadService();
    					$scope.input.showWindow = true;
    				}
    			};
    			
    			$scope.$watch('input.showWindow', function(n, o) {
    				if (n !== o && n == 1) {
    					$scope.$parent.loadService();
    				}
    			});
    			
    			/**
    			 * @param integer $value contains the primary key
    			 * @param array $row contains the full row from the crud loader model in order to display data.
    			 */
    			$scope.setModelValue = function(value, row) {
    				$scope.modelSetter = value;
    				$scope.toggleWindow();
    			};
    		},
    		template: function() {
    			return '<div class="crud-loader-tag"><button ng-click="toggleWindow()" type="button" class="btn btn-info btn-icon"><i class="material-icons">playlist_add</i></button><modal is-modal-hidden="input.showWindow" modal-title="{{alias}}"><div class="modal-body" compile-html ng-bind-html="content"></modal></div>';
    		}
    	}
    });
    
    zaa.directive("crudRelationLoader", function($http, $sce) {
    	return {
    		restrict: "E",
    		replace: true,
    		transclude: false,
    		scope: {
    			"api": "@api",
    			"arrayIndex": "@arrayIndex",
    			"modelClass" : "@modelClass",
    			"id": "@id"
    		},
    		controller: function($scope) {
    			$scope.content = null;
    			$http.get($scope.api+'/?inline=1&relation='+$scope.id+'&arrayIndex='+$scope.arrayIndex+'&modelClass='+$scope.modelClass).then(function(response) {
					$scope.content = $sce.trustAsHtml(response.data);
    			});
    		},
    		template: function() {
    			return '<div compile-html ng-bind-html="content"></div>';
    		}
    	}
    });

    /**
     * Generate form input types based on ZAA Directives.
     * 
     * Usage inside another Angular Template:
     * 
     * ```php
     * <zaa-injector dir="zaa-text" options="{}" fieldid="myFieldId" initvalue="0" label="My Label" model="mymodel"></zaa-injector>
     * ```
     */
    zaa.directive("zaaInjector", function($compile) {
        return {
            restrict: "E",
            replace: true,
            transclude: false,
            scope: {
                "dir": "=",
                "model": "=",
                "options": "=",
                "label": "@label",
                "grid": "@grid",
                "fieldid": "@fieldid",
                "placeholder": "@placeholder",
                "initvalue": "@initvalue"
            },
            link: function($scope, $element) {
                var elmn = $compile(angular.element('<' + $scope.dir + ' options="options" initvalue="{{initvalue}}" fieldid="{{fieldid}}" placeholder="{{placeholder}}" model="model" label="{{label}}" i18n="{{grid}}" />'))($scope);
                $element.replaceWith(elmn);
            },
        }
    });

    /**
     * @var object $model Contains existing data for the displaying the existing relations
     *
     * ```js
     * [
     * 	{'sortpos': 1, 'value': 1},
     *  {'sortpos': 2, 'value': 4},
     * ]
     * ```
     *
     * @var object $options Provides options to build the sort relation array:
     *
     * ```js
     * {
     * 	'sourceData': [
     * 		{'value': 1, 'label': 'Source Entry #1'}
     * 		{'value': 2, 'label': 'Source Entry #2'}
     * 		{'value': 3, 'label': 'Source Entry #3'}
     * 		{'value': 4, 'label': 'Source Entry #4'}
     * 	]
     * }
     * ```
     */
    zaa.directive("zaaSortRelationArray", function() {
    	return {
    		restrict: "E",
    		scope: {
    			"model": "=",
    			"options": "=",
    			"label": "@label",
    			"i18n": "@i18n",
                "id": "@fieldid"
    		},
    		controller: function($scope, $filter) {

    			$scope.searchString = null;

    			$scope.sourceData = [];

                $scope.dropdownOpen = false;

    			$scope.$watch(function() { return $scope.model }, function(n, o) {
    				if (n == undefined) {
    					$scope.model = [];
    				}
    			});

    			$scope.$watch(function() { return $scope.options }, function(n, o) {
    				if (n !== undefined && n !== null) {
    					$scope.sourceData = n.sourceData;
    				}
    			})

    			$scope.getSourceOptions = function() {
    				return $scope.sourceData;
    			};

    			$scope.getModelItems = function() {
    				return $scope.model;
    			}

    			$scope.addToModel = function(option) {

    				var match = false;

    				angular.forEach($scope.model, function(value, key) {
    					if (value.value == option.value) {
    						match = true;
    					}
    				})

    				if (!match) {
    					$scope.searchString = null;
    					$scope.model.push({'value': option.value, 'label': option.label});
    				}
    			};

    			$scope.removeFromModel = function(key) {
    				$scope.model.splice(key, 1);
    			}

    			$scope.moveUp = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index-1];
                    $scope.model[index-1] = oldRow;
                }

                $scope.moveDown = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index+1];
                    $scope.model[index+1] = oldRow;
                };

                $scope.showDownButton = function(index) {
                    if (parseInt(index) < Object.keys($scope.model).length - 1) {
                        return true;
                    }
                    return false;
                }

                $scope.elementInModel = function(item) {
            		var match = false;

    				angular.forEach($scope.model, function(value, key) {
    					if (value.value == item.value) {
    						match = true;
    					}
    				});

    				return !match;
                }
    		},
    		template: function() {
    			return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                    '<div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div>' +
                    '<div class="form-side">' +
                        '<div class="zaa-sortrelation">' +
                            '<ul class="zaa-sortrelation__list>">' +
                                '<li class="zaa-sortrelation__entry" ng-repeat="(key, item) in getModelItems() track by key">' +
                                    '<div class="zaa-sortrelation__arrows">' +
                                        '<i ng-show="{{key > 0}}" ng-click="moveUp(key)" class="material-icons" style="transform: rotate(270deg);">play_arrow</i>' +
                                        '<i ng-show="showDownButton(key)" ng-click="moveDown(key)" class="material-icons" style="transform: rotate(90deg);">play_arrow</i>' +
                                    '</div>' +

                                    '<span class="zaa-sortrelation__text">{{item.label}}</span>' +

                                    '<div class="zaa-sortrelation__trash">' +
                                        '<i ng-click="removeFromModel(key)" class="material-icons">delete</i>' +
                                    '</div>' +
                                '</li>' +
                                '<li class="zaa-sortrelation__dropdown-filter" ng-class="{\'zaa-sortrelation__dropdown-filter--open\': dropdownOpen}">' +
                                    '<input class="zaa-sortrelation__filter" type="search" ng-model="searchString" placeholder="Hinzufügen..." ng-focus="dropdownOpen = true" />' +
                                    '<ul class="zaa-sortrelation__dropdown">' +
                                        '<li class="zaa-sortrelation__dropdown-entry" ng-repeat="option in getSourceOptions() | filter:searchString" ng-show="dropdownOpen && elementInModel(option)" ng-click="addToModel(option)">' +
                                            '<i class="material-icons">add_circle</i><span>{{ option.label }}</span>' +
                                        '</li>' +
                                    '</ul>' +
                                    '<div class="zaa-sortrelation__dropdown-arrow" ng-class="{\'zaa-sortrelation__dropdown-arrow--active\': dropdownOpen}">' +
                                        '<i ng-click="dropdownOpen = !dropdownOpen" class="material-icons">arrow_drop_down</i>' +
                                    '</div>' +
                                '</li>' +
                            '</ul>' +
                        '</div>' +
                    '</div>';
    		}
    	}
    });

    zaa.directive("zaaLink", function(){
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid"
            },
            controller: function($scope) {
            	$scope.unset = function() {
            		$scope.model = false;
            		$scope.data.model = null;
            	};
            	
            	$scope.data = {
            		modalState: 1,
            		model: null
            	};
            	
            	$scope.$watch('model', function(n, o) {
            		if (n) {
            			$scope.data.model = n;
            		}
            	}, true);
            	
            	$scope.$watch('data.model', function(n, o) {
            		if (n) {
            			$scope.model = n;
            		}
            	}, true);
            },
            template: function() {
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><labelfor="{{id}}">{{label}}</label></div><div class="form-side">' +
                    '<div ng-if="model">' +
                        '<div class="link-selector">' +
                            '<div class="link-selector-actions">' +
                                '<div class="link-selector-btn btn btn-secondary" ng-click="data.modalState=0">' +
                                    '<i class="material-icons left">insert_link</i>' +
                                    '<span>' + i18n['js_link_set_value'] + '</span>' +
                                '</div>' +
                                '<span ng-hide="model | isEmpty" class="link-selector-reset" ng-click="unset()"><i class="material-icons">remove_circle</i></span>' + 
                            '</div><link-object-to-string class="ml-2" link="model"></link-object-to-string>' +
                        '</div>' +
                    '</div>' +
                    '<div ng-if="!model">' +
                        '<div class="link-selector">' +
                            '<div class="link-selector-actions">' +
                                '<div class="link-selector__btn btn btn-secondary" ng-click="data.modalState=0">' +
                                    '<i class="material-icons left">insert_link</i>' +
                                    '<span>'+i18n['js_link_set_value']+'</span>' +
                                '</div>' +
                                '<span style="margin-left:10px;">'+i18n['js_link_not_set']+'</span>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<modal is-modal-hidden="data.modalState" modal-title="{{label}}"><form ng-submit="data.modalState=1">'+
                        '<update-form-redirect data="data.model"></update-form-redirect>' +
                        '<button ng-click="data.modalState=1" class="btn btn-icon btn-save" type="submit">'+i18n['js_link_set_value']+'</button></form>' +
                    '</modal>'+
                '</div></div>';
            }
        }
    });

    zaa.directive("zaaSlug", function() {
    	return {
    		restrict: "E",
    		scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid"
            },
    		controller: function($scope, $filter) {
    			$scope.$watch(function() { return $scope.model; }, function(n, o) {
    				if (n!=o) {
    					$scope.model = $filter('slugify')(n);
    				}
    			});
    		},
    		template:function() {
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div><div class="form-side"><input id="{{id}}" insert-paste-listener ng-model="model" type="text" class="form-control" placeholder="{{placeholder}}" /></div></div>';
    		}
    	}
    });
    
    zaa.directive("zaaColor", function() {
    	return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid"
            },
            controller: function($scope) {
                function getTextColor(){
                    if(typeof $scope.model === 'undefined') {
                        return '#000';
                    }

                    var hex = $scope.model;

                    if(typeof $scope.model === 'string') {
                        hex = hex.substr(1);
                    }

                    if(hex.length === 3) {
                        var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
                        hex = hex.replace(shorthandRegex, function(m, r, g, b) {
                            return r + r + g + g + b + b;
                        });
                    }

                    if(hex.length === 6) {
                        var r = parseInt(hex.substr(0, 2), 16);
                        var g = parseInt(hex.substr(2, 2), 16);
                        var b = parseInt(hex.substr(4, 2), 16);
                        var yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;
                        return (yiq >= 128) ? '#000' : '#fff';
                    }

                    return '#000';
                }

                $scope.textColor = getTextColor();

                $scope.$watch(function() { return $scope.model; }, function(n, o) {
                    $scope.textColor = getTextColor();
                });
            },
            template: function() {
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label for="{{id}}">{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="colorwheel">' +
                                    '<div class="colorwheel-background" style="background-color: {{model}};">' +
                                        '<input class="colorwheel-input" type="text" ng-model="model" style="color: {{textColor}}; border-color: {{textColor}};" maxlength="7" />' +
                                    '</div>' +
                                    '<div class="colorwheel-wheel"><div ng-colorwheel="{ size: 150, segments: 120 }" ng-model="model"></div></div>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            }
        }
    });
    
    zaa.directive("zaaWysiwyg", function() {
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid"
            },
            template: function() {
                return '<ng-wig ng-disabled="false" ng-model="model" buttons="bold, italic, link, list1, list2"></ng-wig>';
            }
        }
    });

    zaa.directive("zaaNumber", function() {
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
                "placeholder": "@placeholder",
                "initvalue" : "@initvalue"
            }, link: function($scope) {
                $scope.$watch(function() { return $scope.model }, function(n, o) {
                	if (n == undefined) {
                		$scope.model = parseInt($scope.initvalue);
                	}
                    if(angular.isNumber($scope.model)) {
                        $scope.isValid = true;
                    } else {
                        $scope.isValid = false;
                    }
                })
            }, template: function() {
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div><div class="form-side"><input id="{{id}}" ng-model="model" type="number" min="0" class="form-control" ng-class="{\'invalid\' : !isValid }" placeholder="{{placeholder}}" /></div></div>';
            }
        }
    });

    zaa.directive("zaaDecimal", function() {
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
                "placeholder": "@placeholder"
            }, controller: function($scope) {
                if ($scope.options === null) {
                    $scope.steps = 0.01;
                } else {
                    $scope.steps = $scope.options['steps'];
                }
            }, link: function($scope) {
                $scope.$watch(function() { return $scope.model }, function(n, o) {
                    if(angular.isNumber($scope.model)) {
                        $scope.isValid = true;
                    } else {
                        $scope.isValid = false;
                    }
                })
            }, template: function() {
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div><div class="form-side"><input id="{{id}}" ng-model="model" type="number" min="0" step="{{steps}}" class="form-control" ng-class="{\'invalid\' : !isValid }" placeholder="{{placeholder}}" /></div></div>';
            }
        }
    });

    /**
     * <zaa-text model="itemCopy.title" label="<?= Module::t('view_index_page_title'); ?>" />
     */
    zaa.directive("zaaText", function(){
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
                "placeholder": "@placeholder"
            },
            template: function() {
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div><div class="form-side"><input id="{{id}}" insert-paste-listener ng-model="model" type="text" class="form-control" placeholder="{{placeholder}}" /></div></div>';
            }
        }
    });
    
    /**
     * <zaa-async-value model="theModel" label="Hello world" api="admin/admin-users" fields="[foo,bar]" />
     */
    zaa.directive("zaaAsyncValue", function(){
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "api" : "@",
                "fields" : "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid"
            },
            controller: function($scope, $timeout, $http) {
            	$timeout(function() {
            		$scope.$watch('model', function(n, o) {
            			if (n) {
                    		$scope.value = '';
            				$http.get($scope.api + "/" + n + "?fields=" + $scope.fields.join()).then(function(response) {
            					$scope.value;
            					angular.forEach(response.data, function(value) {
            						if (value) {
            							$scope.value = $scope.value + value + " ";
            						}
            					});
            				});
            			}
            		});
            	});
            	
            	$scope.resetValue = function() {
            		$scope.model = 0;
            		$scope.value = null;
            	};
            },
            template: function() {
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div><div class="form-side"><span ng-bind="value"></span><button type="button" class="btn btn-icon btn-cancel" ng-click="resetValue()" ng-show="model"></button></div></div>';
            }
        }
    });

    zaa.directive("zaaTextarea", function(){
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
                "placeholder": "@placeholder"
            },
            template: function() {
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div><div class="form-side"><textarea id="{{id}}" insert-paste-listener ng-model="model" type="text" class="form-control" auto-grow placeholder="{{placeholder}}"></textarea></div></div>';
            }
        }
    });

    zaa.directive("zaaPassword", function(){
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid"
            },
            template: function() {
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div><div class="form-side"><input id="{{id}}" ng-model="model" type="password" class="form-control" placeholder="{{placeholder}}" /></div></div>';
            }
        }
    });

    /**
     * <zaa-radio model="model" options="[{label:'foo', value: 'bar'}, {...}]">
     */
    zaa.directive("zaaRadio", function() {
    	return {
	    	restrict: "E",
	    	scope: {
	            "model": "=",
	            "options": "=",
	            "label": "@label",
	            "i18n": "@i18n",
	            "id": "@fieldid",
	            "initvalue": "@initvalue"
	    	},
	    	controller: function($scope) {
	    		$scope.setModelValue = function(value) {
	    			$scope.model = value;
	    		};
	    	},
	    	template: function() {
	    		return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
				            '<div class="form-side form-side-label">' +
				            	'<label for="{{id}}">{{label}}</label>' +
				            '</div>' +
				            '<div class="form-side">' +
					        	'<div ng-repeat="(key, item) in options" class="form-check">'+
                                    '<input value="{{item.value}}" type="radio" ng-click="setModelValue(item.value)" ng-checked="item.value == model" name="{{id}}_{{key}}" class="form-check-input" id="{{id}}_{{key}}">' +
					        		'<label class="form-check-label" for="{{id}}_{{key}}">' +
					        			'{{item.label}}' +
					        		'</label>'+
					        	'</div>'+
					        '</div>'+
				        '</div>';
	    	}
    	};
    });
    
    /**
     * 
     * Usage Example:
     * 
     * ```js
     * <zaa-select model="data.module_name" label="<?= Module::t('view_index_module_select'); ?>" options="modules" />
     * ```
     * 
     * Options value defintion:
     * 
     * ```js
     * options=[{"value":123,"label":123-Label}, {"value":abc,"label":ABC-Label}]
     * ```
     * 
     * In order to change the value and label keys which should be used to take the value and label keys within the given array use:
     * 
     * ```js
     * <zaa-select model="create.fromVersionPageId" label="My Label" options="typeData" optionslabel="version_alias" optionsvalue="id" />
     * ```
     */
    zaa.directive("zaaSelect", function($timeout, $rootScope) {
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "optionsvalue" : "@optionsvalue",
                "optionslabel" : "@optionslabel",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
                "initvalue": "@initvalue"
            },
            controller: function($scope) {
            	
            	$scope.isOpen = 0;
            	
            	$scope.$on('closeAllSelects', function() {
            		if ($scope.isOpen) {
            			$scope.closeSelect();
            		}
            	});
            	
            	$scope.toggleIsOpen = function() {
            		
            		if (!$scope.isOpen) {
            			$rootScope.$broadcast('closeAllSelects');
            		}
            		
            		$scope.isOpen = !$scope.isOpen;
            		
            	}
            		
            	$scope.closeSelect = function() {
            		$scope.isOpen = 0;
            	}
    			
            	if ($scope.optionsvalue == undefined) {
            		$scope.optionsvalue = 'value';
            	}
            	
            	if ($scope.optionslabel == undefined) {
            		$scope.optionslabel = 'label';
            	}
            	
		        if (jQuery.isNumeric($scope.model)){
		            $scope.model = typeCastValue($scope.model);
		        }

                $timeout(function(){
                    $scope.$watch(function() { return $scope.model }, function(n, o) {
                        if (n == undefined || n == null || n == '') {
                            if (jQuery.isNumeric($scope.initvalue)) {
                                $scope.initvalue = typeCastValue($scope.initvalue);
                            }
                            $scope.model = $scope.initvalue;
                        }
                    });
                });
                
                $scope.setModelValue = function(option) {
                	$scope.model = option[$scope.optionsvalue];
                	$scope.closeSelect();
                };
                
                $scope.getSelectedValue = function() {
                	var defaultLabel = i18n['ngrest_select_no_selection'];
                	angular.forEach($scope.options, function(item) {
                		if ($scope.model == item[$scope.optionsvalue]) {
                			defaultLabel = item[$scope.optionslabel];
                		}
                	})
                	
                	return defaultLabel;
                }

            },
            template: function() {

                // onclick ".zaaselect-selected" -> add class "open" to ".zaaselect"
                // "zaaselect-clear-icon" clears selection

                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label for="{{id}}">{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="zaaselect" ng-class="{\'open\':isOpen, \'selected\':model}">' +
                                    '<select class="zaaselect-select" ng-model="model">' +
                                        '<option ng-repeat="opt in options" ng-value="opt[optionsvalue]">{{opt[optionslabel]}}</option>' +
                                    '</select>' +
                                    '<div class="zaaselect-selected">' +
                                        '<span class="zaaselect-selected-text" ng-click="toggleIsOpen()">{{getSelectedValue()}}</span>' +
                                        '<i class="material-icons zaaselect-clear-icon" ng-click="model=initvalue">clear</i>' +
                                        '<i class="material-icons zaaselect-dropdown-icon" ng-click="toggleIsOpen()">keyboard_arrow_down</i>' +
                                    '</div>' +
                                    '<div class="zaaselect-dropdown">' +
                                        '<div class="zaaselect-search">' +
                                            '<input class="zaaselect-search-input" type="search" ng-model="searchQuery" />' +
                                        '</div>' +
                                        '<div class="zaaselect-overflow">' +
                                            '<div class="zaaselect-item" ng-repeat="opt in options | filter:searchQuery" ng-click="setModelValue(opt)">' +
                                                '<span ng-class="{\'zaaselect-active\': opt[optionsvalue] == model}">{{opt[optionslabel]}}</span>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    /**
     * options = {'true-value' : 1, 'false-value' : 0};
     */
    zaa.directive("zaaCheckbox", function($timeout) {
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "i18n": "@i18n",
                "id": "@fieldid",
                "label": "@label",
                "initvalue": "@initvalue"
            },
            controller: function($scope) {
                if ($scope.options === null || $scope.options === undefined) {
                    $scope.valueTrue = 1;
                    $scope.valueFalse = 0;
                } else {
                    $scope.valueTrue = $scope.options['true-value'];
                    $scope.valueFalse = $scope.options['false-value'];
                }

                $scope.init = function() {
            		if ($scope.model == undefined && $scope.model == null) {
            			$scope.model = typeCastValue($scope.initvalue);
            		}
                };
                $timeout(function() {
                	$scope.init();
            	})
            },
            template: function() {
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label for="{{id}}">{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="form-check">' +
                                    '<input id="{{id}}" ng-true-value="{{valueTrue}}" ng-false-value="{{valueFalse}}" ng-model="model" type="checkbox" class="form-check-input-standalone" />' +
                                    '<label for="{{id}}"></label>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    /**
     * options arg object:
     *
     * options.items[] = [{"value" : 1, "label" => 'Label for Value 1' }]
     */
    zaa.directive("zaaCheckboxArray", function(){
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "i18n": "@i18n",
                "id": "@fieldid",
                "label": "@label"
            },
            controller: function($scope, $filter) {

                if ($scope.model == undefined) {
                    $scope.model = [];
                }

                $scope.searchString = '';

                $scope.$watch('options', function(n, o) {
                	if (n != undefined && n.hasOwnProperty('items')) {
                    	$scope.optionitems = $filter('orderBy')(n.items, 'label');
                    }
                });

                $scope.filtering = function() {
                    $scope.optionitems = $filter('filter')($scope.options.items, $scope.searchString);
                }

                $scope.toggleSelection = function (value) {
                	if ($scope.model == undefined) {
                		$scope.model = [];
                	}

                    for (var i in $scope.model) {
                        if ($scope.model[i]["value"] == value.value) {
                            $scope.model.splice(i, 1);
                            return;
                        }
                    }
                    $scope.model.push({'value': value.value});
                }

                $scope.isChecked = function(item) {
                    for (var i in $scope.model) {
                        if ($scope.model[i]["value"] == item.value) {
                            return true;
                        }
                    }
                    return false;
                }
            },
            link: function(scope) {
                scope.random = Math.random().toString(36).substring(7);
            },
            template: function() {
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label for="{{id}}">{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +

                                '<div class="input-group mb-3">' +
                                    '<div class="input-group-addon">' +
                                        '<i class="material-icons">search</i>' +
                                    '</div>' +
                                    '<input class="form-control" type="text" ng-change="filtering()" ng-model="searchString" placeholder="Enter search term...">' +

                                    '<span class="zaa-checkbox-array-counter badge badge-secondary">{{optionitems.length}} ' + i18n['js_dir_till'] + ' {{options.items.length}}</span>' +
                                '</div>' +

                                '<div class="form-check" ng-repeat="(k, item) in optionitems track by k">' +
                                    '<input type="checkbox" class="form-check-input" ng-checked="isChecked(item)" id="{{random}}_{{k}}" ng-click="toggleSelection(item)" />' +
                                    '<label for="{{random}}_{{k}}">{{item.label}}</label>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    /**
     * https://github.com/720kb/angular-datepicker#date-validation - Date Picker
     * http://jsfiddle.net/bateast/Q6py9/1/ - Date Parse
     * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date - Date Objects
     * https://docs.angularjs.org/api/ng/filter/date - Angular Date Filter
     */
    zaa.directive("zaaDatetime", function() {
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "id": "@fieldid",
                "i18n": "@i18n"
            },
            controller: function($scope, $filter) {

            	$scope.isNumeric = function(num) {
            	    return !isNaN(num)
            	}
            	
            	$scope.$watch(function() { return $scope.model }, function(n, o) {
            		if (n != null && n != undefined) {
            			var datep = new Date(n*1000);
            			$scope.pickerPreselect = datep;
            			$scope.date = $filter('date')(datep, 'dd.MM.yyyy');
            			$scope.hour = $filter('date')(datep, 'H');
            			$scope.min = $filter('date')(datep, 'm');
            		} else {
            			$scope.date = null;
            			$scope.model = null;
            		}
            	});

            	$scope.refactor = function(n) {
            		if (!$scope.isNumeric($scope.hour) || $scope.hour == '') {
						$scope.hour = "0";
					}
					
					if (!$scope.isNumeric($scope.min)  || $scope.min == '') {
						$scope.min = "0";
					}
            		
            		if (n == 'Invalid Date' || n == "" || n == 'NaN') {
        				$scope.date = null;
        				$scope.model = null;
        			} else {
            			var res = n.split(".");
            			if (res.length == 3) {
            				if (res[2].length == 4) {

        						if (parseInt($scope.hour) > 23) {
        							$scope.hour = 23;
        						}

        						if (parseInt($scope.min) > 59) {
        							$scope.min = 59;
        						}

		        				var en = res[1] + "/" + res[0] + "/" + res[2] + " " + $scope.hour + ":" + $scope.min;
		        				$scope.model = (Date.parse(en)/1000);
		        				$scope.datePickerToggler = false;
            				}
            			}
        			}
            	}

            	$scope.$watch(function() { return $scope.date }, function(n, o) {
            		if (n != o && n != undefined && n != null) {
            			$scope.refactor(n);
            		}
            	});

            	$scope.autoRefactor = function() {
            		$scope.refactor($scope.date);
            	};

            	$scope.datePickerToggler = false;

            	$scope.toggleDatePicker = function() {
            		$scope.datePickerToggler = !$scope.datePickerToggler;
            	};

            	$scope.openDatePicker = function() {
                    $scope.datePickerToggler = true;
                };

                $scope.closeDatePicker = function() {
                    $scope.datePickerToggler = false;
                };

            	$scope.hour = "0";

            	$scope.min = "0";
            	
            	$scope.reset = function() {
            		$scope.model = null;
            	};
            },
            template: function() {
            	return  '<div class="form-group form-side-by-side zaa-datetime" ng-class="{\'input--hide-label\': i18n, \'input--with-time\': model!=null && date!=null}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side form-inline datepicker-wrapper">' +
                                '<datepicker date-set="{{pickerPreselect.toString()}}" datepicker-toggle="false" datepicker-show="{{datePickerToggler}}" date-format="dd.MM.yyyy">' +
                                        '<input class="form-control datepicker-date-input" ng-model="date" type="text" ng-focus="openDatePicker()" />' +
                                        '<div class="input-group-addon" ng-click="toggleDatePicker()">' +
                                            '<i class="material-icons" ng-hide="datePickerToggler">date_range</i>' +
                                            '<i class="material-icons" ng-show="datePickerToggler">close</i>' +
                                        '</div>' +
                                '</datepicker>' +
            	                '<div ng-show="model!=null && date!=null" class="hour-selection">' +
                                    '<div class="input-group">' +
                                        '<div class="input-group-addon">' +
                                            '<i class="material-icons">access_time</i>' +
                                        '</div>' +
                                        '<input class="form-control zaa-datetime-hour-input" type="text" ng-model="hour" ng-change="autoRefactor()" />' +
                                    '</div>' +
                                    '<div class="input-group">' +
                                        '<div class="input-group-addon zaa-datetime-time-colon">:</div>' +
                                        '<input class="form-control zaa-datetime-minute-input" type="text" ng-model="min" ng-change="autoRefactor()" />' +
                                    '</div>' +
            	                '</div>' +
            	                '<div ng-show="model"><button type="button" ng-click="reset()" class="ml-2 btn btn-icon btn-cancel"></nutton></div>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    zaa.directive("zaaDate", function() {
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "id": "@fieldid",
                "i18n": "@i18n"
            },
        	controller: function($scope, $filter) {

            	$scope.$watch(function() { return $scope.model }, function(n, o) {
            		
            		if (n != null && n != undefined) {
            			var datep = new Date(n*1000);
            			$scope.pickerPreselect = datep;
            			$scope.date = $filter('date')(datep, 'dd.MM.yyyy');
            		} else {
            			$scope.date = null;
            			$scope.model = null;
            		}
            	});

            	$scope.refactor = function(n) {
            		if (n == 'Invalid Date' || n == "") {
        				$scope.date = null;
        				$scope.model = null;
        			} else {
            			var res = n.split(".");
            			if (res.length == 3) {
            				if (res[2].length == 4) {
            					var en = res[1] + "/" + res[0] + "/" + res[2];
		        				$scope.model = (Date.parse(en)/1000);
		        				$scope.datePickerToggler = false;
            				}
            			}
        			}
            	}

            	$scope.$watch(function() { return $scope.date }, function(n, o) {
            		if (n != o && n != undefined && n != null) {
            			$scope.refactor(n);
            		}
            	});

            	$scope.autoRefactor = function() {
            		$scope.refactor($scope.date);
            	};

            	$scope.datePickerToggler = false;

            	$scope.toggleDatePicker = function() {
            		$scope.datePickerToggler = !$scope.datePickerToggler;
            	};

                $scope.openDatePicker = function() {
                    $scope.datePickerToggler = true;
                };

                $scope.closeDatePicker = function() {
                    $scope.datePickerToggler = false;
                };
                
                $scope.reset = function() {
            		$scope.model = null;
            	};

            },
            template: function() {
            	return  '<div class="form-group form-side-by-side zaa-date" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side datepicker-wrapper">' +
                                '<datepicker date-set="{{pickerPreselect.toString()}}" datepicker-toggle="false" datepicker-show="{{datePickerToggler}}" date-format="dd.MM.yyyy">' +
                                    '<input class="form-control datepicker-date-input" ng-model="date" type="text" ng-focus="openDatePicker()" />' +
                                    '<div class="input-group-addon" ng-click="toggleDatePicker()">' +
                                        '<i class="material-icons" ng-hide="datePickerToggler">date_range</i>' +
                                        '<i class="material-icons" ng-show="datePickerToggler">close</i>' +
                                    '</div>' +
                                '</datepicker>' +
                                '<div ng-show="model"><button type="button" ng-click="reset()" class="ml-2 btn btn-icon btn-cancel"></nutton></div>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    zaa.directive("zaaTable", function() {
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
            },
            controller: function($scope) {

                if ($scope.model == undefined) {
                    $scope.model = [{0:''}];
                }

                $scope.addColumn = function() {
                    var len = 0;
                    for (var o in $scope.model[0]) {
                        len++;
                    }

                    for(var i in $scope.model) {
                         $scope.model[i][len] = '';
                    }
                }

                $scope.addRow = function() {
                    var elmn = $scope.model[0];
                    var ins = {};
                    for (var i in elmn) {
                        ins[i] = '';
                    }

                    $scope.model.push(ins);
                }

                $scope.removeColumn = function(key) {
                    for (var i in $scope.model) {
                        var item = $scope.model[i];
                        if(item instanceof Array) {
                            item.splice(key, 1);
                        } else {
                            delete item[key];
                        }
                    }
                }

                $scope.moveLeft = function(index) {
                    index = parseInt(index);
                    for (var i in $scope.model) {
                        var oldValue = $scope.model[i][index];
                        $scope.model[i][index] = $scope.model[i][index-1];
                        $scope.model[i][index-1] = oldValue;
                    }
                }

                $scope.moveRight = function(index) {
                    index = parseInt(index);
                    for (var i in $scope.model) {
                        var oldValue = $scope.model[i][index];
                        $scope.model[i][index] = $scope.model[i][index+1];
                        $scope.model[i][index+1] = oldValue;
                    }
                }

                $scope.moveUp = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index-1];
                    $scope.model[index-1] = oldRow;
                }

                $scope.moveDown = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index+1];
                    $scope.model[index+1] = oldRow;
                }

                $scope.removeRow = function(key) {
                    $scope.model.splice(key, 1);
                }

                $scope.showRightButton = function(index) {
                    if (parseInt(index) < Object.keys($scope.model[0]).length - 1) {
                        return true;
                    }
                    return false;
                }
                $scope.showDownButton = function(index) {
                    if (parseInt(index) < Object.keys($scope.model).length - 1) {
                        return true;
                    }
                    return false;
                }
            },
            template: function() {
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label ng-if="label">{{label}}</label>' +
                                '<label ng-if="!label">Table</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="zaa-table-wrapper">' +
                                    '<table class="zaa-table table table-bordered">' +
                                        '<tbody>' +
                                            '<tr>' +
                                                '<th scope="col" width="35px"></th>' +
                                                '<th scope="col" data-ng-repeat="(hk, hr) in model[0] track by hk" class="zaa-table-buttons">' +
                                                    '<div class="btn-group" role="group">' +
                                                        '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveLeft(hk)" ng-if="hk > 0"><i class="material-icons">keyboard_arrow_left</i></button>' +
                                                        '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveRight(hk)" ng-if="showRightButton(hk)"><i class="material-icons">keyboard_arrow_right</i></button>' +
                                                        '<button type="button" class="btn btn-sm btn-outline-danger" ng-click="removeColumn(hk)"><i class="material-icons">remove</i></button>' +
                                                    '</div>' +
                                                '</th>' +
                                            '</tr>' +
                                            '<tr data-ng-repeat="(key, row) in model track by key">' +
                                                '<td width="35px" scope="row" class="zaa-table-buttons">' +
                                                    '<div class="btn-group-vertical" role="group">' +
                                                        '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveUp(key)" ng-if="key > 0"><i class="material-icons">keyboard_arrow_up</i></button>' +
                                                        '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveDown(key)" ng-if="showDownButton(key)"><i class="material-icons">keyboard_arrow_down</i></button>' +
                                                        '<button type="button" class="btn btn-sm btn-outline-danger" ng-click="removeRow(key)"><i class="material-icons">remove</i></button>' +
                                                    '</div>' +
                                                '</td>' +
                                                '<td data-ng-repeat="(field,value) in row track by field">'+
                                                    '<textarea ng-model="model[key][field]" class="zaa-table__textarea"></textarea>'+
                                                '</td>'+
                                            '</tr>' +
                                        '</tbody>' +
                                    '</table>' +
                                    '<button ng-click="addRow()" type="button" class="zaa-table-add-row btn btn-sm btn-success"><i class="material-icons">add</i></button>'+
                                    '<button ng-click="addColumn()" type="button" class="zaa-table-add-column btn btn-sm btn-success"><i class="material-icons">add</i></button>'+
                                '</div>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    zaa.directive("zaaFileUpload", function($compile){
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
            },
            template: function() {
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<storage-file-upload ng-model="model"></storage-file-upload>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    zaa.directive("zaaImageUpload", function($compile){
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
            },
            template: function() {
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<storage-image-upload options="options" ng-model="model"></storage-image-upload>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    zaa.directive("zaaImageArrayUpload", function(){
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
            },
            link: function(scope, element, attributes){
                scope.$watch('model', function(newValue, oldValue) {
                    if(newValue.length >= 1) {
                        $(element).removeClass('is-empty').addClass('is-not-empty');
                    } else {
                        $(element).removeClass('is-not-empty').addClass('is-empty');
                    }
                }, true);
            },
            controller: function($scope) {
                if ($scope.model == undefined) {
                    $scope.model = [];
                }

                $scope.add = function() {
                	if ($scope.model == null || $scope.model == '' || $scope.model == undefined) {
                		$scope.model = [];
                	}
                    $scope.model.push({ imageId : 0, caption : '' });
                };

                $scope.remove = function(key) {
                    $scope.model.splice(key, 1);
                };

                $scope.moveUp = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index-1];
                    $scope.model[index-1] = oldRow;
                };

                $scope.moveDown = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index+1];
                    $scope.model[index+1] = oldRow;
                };

                $scope.showDownButton = function(index) {
                    if (parseInt(index) < Object.keys($scope.model).length - 1) {
                        return true;
                    }
                    return false;
                };
            },
            template: function() {
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="list zaa-file-array-upload">' +
                                    '<p class="alert alert-info" ng-hide="model.length > 0">'+i18n['js_dir_no_selection']+'</p>' +
                                    '<div ng-repeat="(key,image) in model track by key" class="list-item">' +
                                        '<div class="list-section">' +
                                            '<div class="list-left">' +
                                                '<storage-image-upload ng-model="image.imageId" options="options"></storage-image-upload>' +
                                            '</div>' +
                                            '<div class="list-right">' +
                                                '<div class="form-group">' +
                                                    '<label for="{{image.id}}">' + i18n['js_dir_image_description'] + '</label>' +
                                                    '<textarea ng-model="image.caption" id="{{image.id}}" class="zaa-file-array-upload-description form-control" auto-grow></textarea>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="list-buttons">' +
                                            '<div class="btn-group" role="group">' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveUp(key)" ng-if="key > 0"><i class="material-icons">keyboard_arrow_up</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveDown(key)" ng-if="showDownButton(key)"><i class="material-icons">keyboard_arrow_down</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-danger" ng-click="remove(key)"><i class="material-icons">remove</i></button>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<button ng-click="add()" type="button" class="btn btn-sm btn-success list-add-button"><i class="material-icons">add</i></button>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    /**
     * Multiple selection of files.
     */
    zaa.directive("zaaFileArrayUpload", function(){
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
            },
            controller: function($scope, $element, $timeout) {

                if ($scope.model == undefined) {
                    $scope.model = [];
                }

                $scope.add = function() {
                	if ($scope.model == null || $scope.model == '' || $scope.model == undefined) {
                		$scope.model = [];
                	}
                    $scope.model.push({ fileId : 0, caption : '' });
                };

                $scope.remove = function(key) {
                    $scope.model.splice(key, 1);
                };

                $scope.moveUp = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index-1];
                    $scope.model[index-1] = oldRow;
                };

                $scope.moveDown = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index+1];
                    $scope.model[index+1] = oldRow;
                };

                $scope.showDownButton = function(index) {
                    if (parseInt(index) < Object.keys($scope.model).length - 1) {
                        return true;
                    }
                    return false;
                };
            },
            template: function() {
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="list zaa-file-array-upload">' +
                                    '<p class="alert alert-info" ng-hide="model.length > 0">'+i18n['js_dir_no_selection']+'</p>' +
                                    '<div ng-repeat="(key,file) in model track by key" class="list-item">' +
                                    	'<div class="list-section" ng-if="file.hiddenStorageUploadSource">' +
                                    		'<a ng-href="{{file.hiddenStorageUploadSource}}" target="_blank" class="btn btn-primary">{{file.hiddenStorageUploadName}}</a>'+
                                    	'</div>' + 
                                        '<div class="list-section" ng-if="!file.hiddenStorageUploadSource">' +
                                            '<div class="list-left">' +
                                                '<storage-file-upload ng-model="file.fileId"></storage-file-upload>' +
                                            '</div>' +
                                            '<div class="list-right">' +
                                                '<div class="form-group">' +
                                                    '<label for="{{file.id}}">' + i18n['js_dir_image_description'] + '</label>' +
                                                    '<textarea ng-model="file.caption" id="{{file.id}}" class="zaa-file-array-upload-description form-control" auto-grow></textarea>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="list-buttons"  ng-if="!file.hiddenStorageUploadSource">' +
                                            '<div class="btn-group" role="group">' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveUp(key)" ng-if="key > 0"><i class="material-icons">keyboard_arrow_up</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveDown(key)" ng-if="showDownButton(key)"><i class="material-icons">keyboard_arrow_down</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-danger" ng-click="remove(key)"><i class="material-icons">remove</i></button>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                                '<button ng-click="add()" type="button" class="btn btn-sm btn-success list-add-button"><i class="material-icons">add</i></button>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    /**
     * Generates an array where each array element can contain another directive from zaa types.
     * 
     * @retunr array
     */
    zaa.directive("zaaMultipleInputs", function() {
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
            },
            controller: function ($scope, $timeout) {
                $scope.init = function() {
                    if ($scope.model == undefined || $scope.model == null) {
                        $scope.model = [];
                    } else {
                    	angular.forEach($scope.model, function(value, key) {
                    		var len = Object.keys(value).length;
                    		/* issue #1519: if there are no keys, ensure the item is an object */
                    		if (len == 0) {
                    			$scope.model[key] = {};
                    		}
                    	})
                    }
                };

                $scope.add = function() {
                    if ($scope.model == null || $scope.model == '' || $scope.model == undefined) {
                        $scope.model = [];
                    }

                    $scope.model.push({});
                };

                $scope.remove = function(key) {
                    $scope.model.splice(key, 1);
                };

                $scope.moveUp = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index-1];
                    $scope.model[index-1] = oldRow;
                };

                $scope.moveDown = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index+1];
                    $scope.model[index+1] = oldRow;
                };

                $scope.showDownButton = function(index) {
                    return parseInt(index) < Object.keys($scope.model).length - 1;
                };

                $timeout(function() {
                	$scope.init();
                });
            },
            template: function() {
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="list zaa-multiple-inputs">' +
                                    '<p class="alert alert-info" ng-hide="model.length > 0">'+i18n['js_dir_no_selection']+'</p>' +
                                    '<div ng-repeat="(msortKey,row) in model track by msortKey" class="list-item" ng-init="ensureRow(row)">' +
                                        '<div ng-repeat="(mutliOptKey,opt) in options track by mutliOptKey"><zaa-injector dir="opt.type" options="opt.options" fieldid="id-{{msortKey}}-{{mutliOptKey}}" initvalue="{{opt.initvalue}}" label="{{opt.label}}" model="row[opt.var]"></zaa-injector></div>' +
                                        '<div class="list-buttons">' +
                                            '<div class="btn-group" role="group">' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveUp(msortKey)" ng-if="msortKey > 0"><i class="material-icons">keyboard_arrow_up</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveDown(msortKey)" ng-if="showDownButton(msortKey)"><i class="material-icons">keyboard_arrow_down</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-danger" ng-click="remove(msortKey)"><i class="material-icons">remove</i></button>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<button ng-click="add()" type="button" class="btn btn-sm btn-success list-add-button"><i class="material-icons">add</i></button>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    zaa.directive("zaaListArray", function() {
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
            },
            controller: function($scope, $element, $timeout) {

                $scope.init = function() {
                	if ($scope.model == undefined || $scope.model == null) {
                        $scope.model = [];
                    }
                };

                $scope.add = function() {
                	if ($scope.model == null || $scope.model == '' || $scope.model == undefined) {
                		$scope.model = [];
                	}
                    $scope.model.push({ value : '' });
                    $scope.setFocus();
                };

                $scope.remove = function(key) {
                    $scope.model.splice(key, 1);
                };

                $scope.refactor = function(key, row) {
                    if (key !== ($scope.model.length -1)) {
                        if (row['value'] == "") {
                            $scope.remove(key);
                        }
                    }
                };

                $scope.setFocus = function() {
                    $timeout(function() {
                        var input = $element.children('.list').children('.list__item:last-of-type').children('.list__left').children('input');

                        if(input.length == 1) {
                            input[0].focus();
                        }
                    }, 50);
                };

                $scope.moveUp = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index-1];
                    $scope.model[index-1] = oldRow;
                }

                $scope.moveDown = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index+1];
                    $scope.model[index+1] = oldRow;
                }

                $scope.showDownButton = function(index) {
                    if (parseInt(index) < Object.keys($scope.model).length - 1) {
                        return true;
                    }
                    return false;
                }

                $scope.init();

            },
            template: function() {
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="list zaa-file-array-upload">' +
                                    '<p class="alert alert-info" ng-hide="model.length > 0">'+i18n['js_dir_no_selection']+'</p>' +
                                    '<div ng-repeat="(key,row) in model track by key" class="list-item">' +
                                        '<input class="form-control list-input" type="text" ng-model="row.value" />' +
                                        '<div class="list-buttons">' +
                                            '<div class="btn-group" role="group">' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveUp(key)" ng-if="key > 0"><i class="material-icons">keyboard_arrow_up</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveDown(key)" ng-if="showDownButton(key)"><i class="material-icons">keyboard_arrow_down</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-danger" ng-click="remove(key)"><i class="material-icons">remove</i></button>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<button ng-click="add()" type="button" class="btn btn-sm btn-success list-add-button"><i class="material-icons">add</i></button>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            }
        }
    });
    // storage.js

    zaa.directive('storageFileUpload', function($http, ServiceFilesData, $filter) {
        return {
            restrict : 'E',
            scope : {
                ngModel : '='
            },
            link : function(scope) {
            },
            controller: function($scope) {


                // ServiceFilesData inhertiance

            	$scope.filesData = ServiceFilesData.data;

            	$scope.$on('service:FilesData', function(event, data) {
            		$scope.filesData = data;
                });

                // controller logic

            	$scope.modal = {state: 1};
            	
            	$scope.modalContainer = false;
            	
            	$scope.fileinfo = null;

            	$scope.select = function(fileId) {
                	$scope.toggleModal();
                	$scope.ngModel = fileId;
                };

            	$scope.reset = function() {
            		$scope.ngModel = 0;
            		$scope.fileinfo = null;
                };

            	$scope.toggleModal = function() {
            		$scope.modalContainer = !$scope.modalContainer;
            		$scope.modal.state = !$scope.modal.state;
                };

            	$scope.$watch(function() { return $scope.ngModel }, function(n, o) {
                    if (n != 0 && n != null && n !== undefined) {
                        var filtering = $filter('filter')($scope.filesData, {id: parseInt(n)}, true);
                        if (filtering && filtering.length == 1) {
                        	$scope.fileinfo = filtering[0];
                        }
                    }

                    /* reset file directive if an event resets the image model to undefined */
                    if (n == 0) {
                    	$scope.reset();
                    }
                });
            },
            templateUrl : 'storageFileUpload'
        }
    });

    zaa.directive('storageFileDisplay', function(ServiceFilesData) {
    	return {
    		restrict: 'E',
    		scope: {
    			fileId: '@fileId'
    		},
    		controller: function($scope, $filter) {

    			// ServiceFilesData inheritance

                $scope.filesData = ServiceFilesData.data;

                $scope.$on('service:FilesData', function(event, data) {
                    $scope.filesData = data;
                });

                // controller

                $scope.fileinfo = null;

                $scope.$watch('fileId', function(n, o) {
                    if (n != 0 && n != null && n !== undefined) {
                    	var filtering = $filter('filter')($scope.filesData, {id: parseInt(n)}, true);
                        if (filtering && filtering.length == 1) {
                        	$scope.fileinfo = filtering[0];
                        }
                    }
                });
    		},
    		template: function() {
                return '<div ng-show="fileinfo!==null">{{ fileinfo.name }}</div>';
            }
    	}
    });

    zaa.directive('storageImageThumbnailDisplay', function(ServiceImagesData, ServiceFilesData) {
        return {
            restrict: 'E',
            scope: {
                imageId: '@imageId'
            },
            controller: function($scope, $filter) {

                // ServiceFilesData inheritance

                $scope.filesData = ServiceFilesData.data;

                $scope.$on('service:FilesData', function(event, data) {
                    $scope.filesData = data;
                });

                // ServiceImagesData inheritance

                $scope.imagesData = ServiceImagesData.data;

                $scope.$on('service:ImagesData', function(event, data) {
                    $scope.imagesData = data;
                });

                // controller logic

                $scope.$watch(function() { return $scope.imageId }, function(n, o) {
                    if (n != 0 && n !== undefined) {

                        var filtering = $filter('findidfilter')($scope.imagesData, n, true);

                        var file = $filter('findidfilter')($scope.filesData, filtering.fileId, true);

                        if (file && file.thumbnail) {
                        	$scope.imageSrc = file.thumbnail.source;
                        }
                    }
                });

                $scope.imageSrc = null;
            },
            template: function() {
                return '<div ng-show="imageSrc!==false"><img ng-src="{{imageSrc}}" /></div>';
            }
        }
    });

    zaa.directive('storageImageUpload', function($http, $filter, ServiceFiltersData, ServiceImagesData, AdminToastService) {
        return {
            restrict : 'E',
            scope : {
                ngModel : '=',
                options : '=',
            },
            link : function(scope) {

                // ServiceImagesData inheritance

                scope.imagesData = ServiceImagesData.data;

                scope.$on('service:ImagesData', function(event, data) {
                    scope.imagesData = data;
                });

                scope.imagesDataReload = function() {
                    return ServiceImagesData.load(true);
                }

                // ServiceFiltesrData inheritance

                scope.filtersData = ServiceFiltersData.data;

                scope.$on('service:FiltersData', function(event, data) {
                    scope.filtersData = data;
                });

                // controller logic

                scope.noFilters = function() {
                    if (scope.options) {
                        return scope.options.no_filter;
                    }
                }

                scope.thumbnailfilter = null;

                scope.imageLoading = false;

                scope.fileId = 0;

                scope.filterId = 0;

                scope.imageinfo = null;

                scope.imageNotFoundError = false;

                scope.filterApply = function() {
                    var items = $filter('filter')(scope.imagesData, {fileId: scope.fileId, filterId: scope.filterId}, true);
                    if (items && items.length == 0) {
                        scope.imageLoading = true;
                        // image does not exists make request.
                        $http.post('admin/api-admin-storage/image-upload', $.param({ fileId : scope.fileId, filterId : scope.filterId }), {
                            headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                        }).then(function(transport) {
                            if (!transport.data.error) {
                                scope.imagesDataReload().then(function(r) {
                                    scope.ngModel = transport.data.id;
                                    AdminToastService.success(i18n['js_dir_image_upload_ok'], 2000);
                                    scope.imageLoading = false;
                                });
                            }
                        }, function(error) {
                        	AdminToastService.error(i18n['js_dir_image_filter_error'], 7000);
                            scope.imageLoading = false;
                        });
                    } else {
                        var item = items[0];
                        scope.ngModel = item.id
                        scope.imageinfo = item;
                    }
                };

                scope.$watch(function() { return scope.filterId }, function(n, o) {
                    if (n != null && n !== undefined && scope.fileId !== 0 && n !== o && n != o) {
                        scope.filterApply();
                    }
                });

                scope.$watch(function() { return scope.fileId }, function(n, o) {
                	if (n !== undefined && n != null && n != o) {
                		if (n == 0) {
                            scope.filterId = 0;
                            scope.imageinfo = null;
                            scope.ngModel = 0;
                        } else {
                        	scope.filterApply();
                        }
                    }
                });

                scope.$watch(function() { return scope.ngModel }, function(n, o) {
                    if (n != 0 && n != null && n !== undefined) {
                        var filtering = $filter('findidfilter')(scope.imagesData, n, true);
                        if (filtering) {
                            scope.imageinfo = filtering;
                            scope.filterId = filtering.filterId;
                            scope.fileId = filtering.fileId;
                        } else {
                        	scope.imageNotFoundError = true;
                        }
                    }
                    /* reset image preview directive if an event resets the image model to undefined */
                    if (n == undefined || n == 0) {
                    	scope.fileId = 0;
                        scope.filterId = 0;
                        scope.imageinfo = null;
                        scope.thumb = false;
                    }

                });

                scope.thumb = false;

                scope.getThumbnailFilter = function() {
                	if (scope.thumbnailfilter === null) {
                		if ('medium-thumbnail' in scope.filtersData) {
                			scope.thumbnailfilter = scope.filtersData['medium-thumbnail'];
                		}
                	}
                	return scope.thumbnailfilter;
                }

                scope.$watch('imageinfo', function(n, o) {
                	if (n != 0 && n != null && n !== undefined) {
                		if (n.filterId != 0) {
                			scope.thumb = n;
                		} else {
                			var result = $filter('findthumbnail')(scope.imagesData, n.fileId, scope.getThumbnailFilter().id);
                			if (!result) {
                				scope.thumb = n;
                			} else {
                				scope.thumb = result;
                			}
                		}
                	}
                })
            },
            templateUrl : 'storageImageUpload'
        }
    });

    /**
     * FILE MANAGER DIR
     */
    zaa.directive("storageFileManager", function(Upload, ServiceFoldersData, ServiceFilesData, LuyaLoading, AdminToastService, ServiceFoldersDirecotryId) {
        return {
            restrict : 'E',
            transclude : false,
            scope : {
                allowSelection : '@selection',
                onlyImages : '@onlyImages'
            },
            controller : function($scope, $http, $filter, $timeout) {

                // ServiceFoldersData inheritance

                $scope.foldersData = ServiceFoldersData.data;

                $scope.$on('service:FoldersData', function(event, data) {
                    $scope.foldersData = data;
                });

                $scope.foldersDataReload = function() {
                    return ServiceFoldersData.load(true);
                }

                // ServiceFilesData inheritance

                $scope.filesData = ServiceFilesData.data;

                $scope.$on('service:FilesData', function(event, data) {
                    $scope.filesData = data;
                });

                $scope.filesDataReload = function() {
                    return ServiceFilesData.load(true);
                }

                // ServiceFolderId

                $scope.currentFolderId = ServiceFoldersDirecotryId.folderId;

                $scope.$on('FoldersDirectoryId', function(event, folderId) {
                	$scope.currentFolderId = folderId;
                });

                $scope.foldersDirecotryIdReload = function() {
                	return ServiceFoldersDirecotryId.load(true);
                }
                
                // file replace logic

                $scope.folderCountMessage = function(folder) {
                	return i18nParam('js_filemanager_count_files_overlay', {count: folder.filesCount});
                }
                
                $scope.errorMsg = null;
                
                $scope.replaceFile = function(file, errorFiles) {
                	$scope.replaceFiled = file;
                	
                	if (!file) {
                		return;
                	}
                	
                	LuyaLoading.start();
                	
                	Upload.upload({
                		url: 'admin/api-admin-storage/file-replace',
                        data: {file: file, fileId: $scope.fileDetail.id}
                    }).then(function (response) {
                    	LuyaLoading.stop();
                    	if (response.status == 200) {
                            $scope.filesDataReload().then(function() {
                            	var fileref = $filter('findidfilter')($scope.filesData, $scope.fileDetail.id, true);
                            	var random = (new Date()).toString();
                            	if (fileref.isImage) {
	                            	fileref.thumbnail.source = fileref.thumbnail.source + "?cb=" + random;
	                            	fileref.thumbnailMedium.source = fileref.thumbnailMedium.source + "?cb=" + random;
	                            }
                            	$scope.fileDetail = fileref;
                            	AdminToastService.success('the file has been replaced successfull.', 4000);
                            });
                    	}
                    }, function() {
                    	LuyaLoading.stop();
                    });
                };

                // upload logic

                $scope.$watch('uploadingfiles', function (uploadingfiles) {
                    if (uploadingfiles != null) {
                        $scope.uploadResults = 0;
                        LuyaLoading.start(i18n['js_dir_upload_wait']);
                        for (var i = 0; i < uploadingfiles.length; i++) {
                            $scope.errorMsg = null;
                            (function (uploadingfiles) {
                                $scope.uploadUsingUpload(uploadingfiles);
                            })(uploadingfiles[i]);
                        }
                    }
                });

                $scope.$watch('uploadResults', function(n, o) {
                    if ($scope.uploadingfiles != null) {
                        if (n == $scope.uploadingfiles.length && $scope.errorMsg == null) {
                            $scope.filesDataReload().then(function() {
                            	AdminToastService.success(i18n['js_dir_manager_upload_image_ok'], 2000);
                                LuyaLoading.stop();
                            });
                        }
                    }
                })

                $scope.pasteUpload = function(e) {
                	
                    for (var i = 0 ; i < e.originalEvent.clipboardData.items.length ; i++) {
                        var item = e.originalEvent.clipboardData.items[i];
                        
                        if (item.kind == 'file') {
                        	LuyaLoading.start(i18n['js_dir_upload_wait']);
	                        Upload.upload({
	                            url: 'admin/api-admin-storage/files-upload',
	                            fields: {'folderId': $scope.currentFolderId},
	                            file: item.getAsFile()
	                        }).then(function(response) {
                        		if (response.data.upload) {
		                        	$scope.filesDataReload().then(function() {
		                            	AdminToastService.success(i18n['js_dir_manager_upload_image_ok'], 2000);
		                            	LuyaLoading.stop();
		                            });
                        		} else {
                        			AdminToastService.error(response.data.message, 6000);
                        			LuyaLoading.stop();
                        		}
	                        	
	                        })
                        }
                    }
                }
                
                $scope.uploadUsingUpload = function(file) {
                	file.upload = Upload.upload({
                        url: 'admin/api-admin-storage/files-upload',
                        fields: {'folderId': $scope.currentFolderId},
                        file: file
                    });

                    file.upload.then(function (response) {
                        $timeout(function () {
                            $scope.uploadResults++;
                            file.processed = true;
                            file.result = response.data;
                            if (!file.result.upload) {
                            	AdminToastService.error(file.result.message, 6000);
                            	LuyaLoading.stop();
                                $scope.errorMsg = true
                            }
                        });
                    }, function (response) {
                        if (response.status > 0) {
                            $scope.errorMsg = true;
                        }
                    });

                    file.upload.progress(function (evt) {
                        file.processed = false;
                        // Math.min is to fix IE which reports 200% sometimes
                        file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
                    });
                }

                // selector logic

                $scope.selectedFiles = [];

                $scope.toggleSelectionAll = function() {
                	var files = $filter('filemanagerfilesfilter')($scope.filesData, $scope.currentFolderId, $scope.onlyImages);
                	files.forEach(function(value, key) {
                		$scope.toggleSelection(value);
                	})
                }

                $scope.toggleSelection = function(file) {
                    if ($scope.allowSelection == 'true') {
                        // parent inject
                        $scope.$parent.select(file.id);
                        return;
                    }

                    var i = $scope.selectedFiles.indexOf(file.id);
                    if (i > -1) {
                        $scope.selectedFiles.splice(i, 1);
                    } else {
                        $scope.selectedFiles.push(file.id);
                    }
                };

                $scope.inSelection = function(file) {
                    var response = $scope.selectedFiles.indexOf(file.id);

                    if (response != -1) {
                        return true;
                    }

                    return false;
                };

                // folder add

                $scope.showFolderForm = false;

                $scope.createNewFolder = function(newFolderName) {
                	if (!newFolderName) {
                		return;
                	}
                    $http.post('admin/api-admin-storage/folder-create', $.param({ folderName : newFolderName , parentFolderId : $scope.currentFolderId }), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).then(function() {
                        $scope.foldersDataReload().then(function() {
                            $scope.folderFormToggler();
                            $scope.newFolderName = null;
                        })
                    });
                };

                $scope.folderFormToggler = function() {
                    $scope.showFolderForm = !$scope.showFolderForm;
                };

                // controller logic

                $scope.searchQuery = '';

                $scope.sortField = 'name';

                $scope.changeSortField = function(name) {
                	$scope.sortField = name;
                };

                $scope.changeCurrentFolderId = function(folderId, noState) {
                    $scope.currentFolderId = folderId;
                    if (noState !== true) {
                    	ServiceFoldersDirecotryId.folderId = folderId;
                    	$http.post('admin/api-admin-common/save-filemanager-folder-state', {folderId : folderId}, {ignoreLoadingBar: true});
                    }
                };

                $scope.toggleFolderItem = function(data) {
                    if (data.toggle_open == undefined) {
                        data['toggle_open'] = 1;
                    } else {
                        data['toggle_open'] = !data.toggle_open;
                    }
                    $http.post('admin/api-admin-common/filemanager-foldertree-history', {data : data}, {ignoreLoadingBar: true});
                };

                $scope.folderUpdateForm = false;

                $scope.folderDeleteForm = false;

                $scope.folderDeleteConfirmForm = false;

                /*
                $scope.toggleFolderMode = function(mode) {
                    if (mode == 'edit') {
                        $scope.folderUpdateForm = true;
                        $scope.folderDeleteForm = false;
                        $scope.folderDeleteConfirmForm = false;
                    } else if (mode == 'remove') {
                        $scope.folderUpdateForm = false;
                        $scope.folderDeleteForm = true;
                        $scope.folderDeleteConfirmForm = false;
                    } else if (mode == 'removeconfirm') {
                        $scope.folderUpdateForm = false;
                        $scope.folderDeleteForm = false;
                        $scope.folderDeleteConfirmForm = true;
                    } else {
                        $scope.folderUpdateForm = false;
                        $scope.folderDeleteForm = false;
                        $scope.folderDeleteConfirmForm = false;
                    }
                };
                
                */

                $scope.updateFolder = function(folder) {
                    $http.post('admin/api-admin-storage/folder-update?folderId=' + folder.id, $.param({ name : folder.name }), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).then(function(transport) {});
                }

                /*
                $scope.checkEmptyFolder = function(folder) {
                    $http.post('admin/api-admin-storage/is-folder-empty?folderId=' + folder.id, $.param({ name : folder.name }), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).then(function(transport) {
                        if (transport.data == true) {
                            $scope.deleteFolder(folder);
                        } else {
                            $scope.toggleFolderMode('removeconfirm');
                        }
                    });
                };
				*/
                $scope.deleteFolder = function(folder) {

                    // check if folder is empty
                	$http.post('admin/api-admin-storage/is-folder-empty?folderId=' + folder.id, $.param({ name : folder.name }), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).then(function(transport) {
                        if (transport.data == true) {

                            $http.post('admin/api-admin-storage/folder-delete?folderId=' + folder.id, $.param({ name : folder.name }), {
                                headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                            }).then(function(transport) {
                                $scope.foldersDataReload().then(function() {
                                    $scope.filesDataReload().then(function() {
                                        $scope.currentFolderId = 0;
                                    });
                                });
                            });

                        } else {
                            AdminToastService.confirm(i18nParam('layout_filemanager_remove_dir_not_empty', {folderName: folder.name, count: folder.filesCount}), i18n['js_dir_manager_rm_folder_confirm_title'], function($timeout, $toast) {
                                $http.post('admin/api-admin-storage/folder-delete?folderId=' + folder.id, $.param({ name : folder.name }), {
                                    headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                                }).then(function() {
                                    $scope.foldersDataReload().then(function() {
                                        $scope.filesDataReload().then(function() {
                                            $scope.currentFolderId = 0;
                                            $toast.close();
                                        });
                                    });
                                });
                            });
                        }
                    });
                };

                $scope.fileDetail = false;

                $scope.showFoldersToMove = false;

                $scope.openFileDetail = function(file) {
                	if ($scope.fileDetail.id == file.id) {
                		$scope.closeFileDetail();
                	} else {
                		$scope.fileDetail = file;
                	}
                };

                $scope.closeFileDetail = function() {
                    $scope.fileDetail = false;
                };

                $scope.moveFilesTo = function(folderId) {
                    $http.post('admin/api-admin-storage/filemanager-move-files', $.param({'fileIds' : $scope.selectedFiles, 'toFolderId' : folderId}), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).then(function(transport) {
                        $scope.filesDataReload().then(function() {
                            $scope.selectedFiles = [];
                            $scope.showFoldersToMove = false;
                        });
                    });
                };

                $scope.removeFiles = function() {
                    AdminToastService.confirm(i18n['js_dir_manager_rm_file_confirm'], i18n['js_dir_manager_rm_file_confirm_title'], function($timeout, $toast) {
                        $http.post('admin/api-admin-storage/filemanager-remove-files', $.param({'ids' : $scope.selectedFiles}), {
                            headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                        }).then(function(transport) {
                            $scope.filesDataReload().then(function() {
                                $toast.close();
                                AdminToastService.success(i18n['js_dir_manager_rm_file_ok'], 2000);
                                $scope.selectedFiles = [];
                            });
                        });
                    });
                }

                // file detail view logic

                $scope.storeFileCaption = function(fileDetail) {
                	$http.post('admin/api-admin-storage/filemanager-update-caption', $.param({'id': fileDetail.id, 'captionsText' : fileDetail.captionArray}), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).then(function(transport) {
                    	AdminToastService.success('Captions has been updated', 2000);
                    });
                }
               
                $scope.selectedFileFromParent = null;
                
                $scope.init = function() {
                	if ($scope.$parent.fileinfo) {
                		$scope.selectedFileFromParent = $scope.$parent.fileinfo;
                		$scope.changeCurrentFolderId($scope.selectedFileFromParent.folderId, true);
                	}
                }
                
                $scope.init();

            },
            templateUrl : 'storageFileManager'
        }
    });

    zaa.directive("hasEnoughSpace", function($window, $document, $timeout) {
        return {
            restrict: "A",
            scope: {
                "loadingCondition": "=",
                "isFlexBox": "="
            },
            link: function (scope, element, attrs) {
                scope.elementWidth = 0;

                var getElementOriginalWidth = function() {
                    var elementClone = element.clone().insertAfter(element);

                    elementClone.css({
                        'position': 'fixed',
                        'top': 0,
                        'left': 0,
                        'visibility': 'hidden'
                    });

                    if(elementClone.css('display') === 'none') {
                        elementClone.css('display', scope.isFlexBox ? 'flex' : 'block');
                    }

                    var elementOriginalWidth = elementClone.outerWidth();

                    elementClone.remove();

                    return elementOriginalWidth;
                };


                function checkSize() {
                    $timeout(function() {
                        if(!scope.elementOriginalWidth) {
                            scope.elementOriginalWidth = getElementOriginalWidth();
                        }

                        if(element.hasClass('not-enough-space')) {
                            element.removeClass('not-enough-space');
                            element.addClass('has-enough-space');
                        }

                        var currentElementSpace = element.parent().outerWidth();

                        if(currentElementSpace < scope.elementOriginalWidth) {
                            element.removeClass('has-enough-space').addClass('not-enough-space');
                        } else {
                            element.removeClass('not-enough-space').addClass('has-enough-space');
                        }
                    });
                }

                angular.element($window).on('resize', function() {
                    checkSize();
                });

                scope.$watch('loadingCondition', function(n) {
                    if(n == true) {
                        checkSize();
                    }
                });

            }
        }
    });

    zaa.directive('activeClass', function () {
        return {
            restrict: 'A',
            scope: {
                activeClass: '@'
            },
            link: function (scope, element) {
                element.on('mouseenter', function() {
                    element.addClass(scope.activeClass);
                });
                element.on('mouseleave', function() {
                    element.removeClass(scope.activeClass);
                });
                element.on('click', function() {
                    element.toggleClass(scope.activeClass);
                });
            }
        };
    });


})();

(function() {
	"use strict";

	zaa.config(function($stateProvider, resolverProvider) {
		$stateProvider
		.state("default.route.detail", {
			url: "/:id",
			parent: 'default.route',
			template: '<ui-view/>',
			controller:function($scope, $stateParams) {

				$scope.crud = $scope.$parent;

				$scope.init = function() {
					if (!$scope.crud.config.inline) {
						if ($scope.crud.data.updateId != $stateParams.id) {
							$scope.crud.toggleUpdate($stateParams.id);
						}
					}
				}

				$scope.init();
			}
		});
	});

	zaa.controller("DefaultDashboardObjectController", function($scope, $http, $sce) {

		$scope.data;

		$scope.loadData = function(dataApiUrl) {
			$http.get(dataApiUrl).then(function(success) {
				$scope.data = success.data;
			});
		};
	});

	/**
	 * Base Crud Controller
	 *
	 * Assigned config variables from the php view assigned from child to parent:
	 *
	 * + bool $config.inline Determines whether this crud is in inline mode orno
	 */
	zaa.controller("CrudController", function($scope, $filter, $http, $sce, $state, $timeout, $injector, $q, AdminLangService, LuyaLoading, AdminToastService, CrudTabService) {

		$scope.toast = AdminToastService;

		$scope.AdminLangService = AdminLangService;

		$scope.tabService = CrudTabService;

		/***** TABS AND SWITCHES *////

		/**
		 * 0 = list
		 * 1 = add
		 * 2 = edit
		 */
		$scope.crudSwitchType = 0;

		$scope.switchToTab = function(tab) {
			angular.forEach($scope.tabService.tabs, function(item) {
				item.active = false;
			});

			tab.active = true;

			$scope.switchTo(4);
		};

		$scope.closeTab = function(tab, index) {
			$scope.tabService.remove(index, $scope);
		};

		$scope.switchTo = function(type, reset) {
			if ($scope.config.relationCall) {
				$scope.crudSwitchType = type;
				return;
			}

			if (reset) {
				$scope.resetData();
			}

			if (type == 0) {
				$http.get($scope.config.apiEndpoint + '/unlock');
			}

			if (type == 0 || type == 1) {
				if (!$scope.config.inline) {
					$state.go('default.route');
				}
			}
			$scope.crudSwitchType = type;

			if (type !== 4) {
				angular.forEach($scope.tabService.tabs, function(item) {
					item.active = false;
				});
			}
		};

		$scope.closeUpdate = function () {
			$scope.switchTo(0, true);
	    };

		$scope.closeCreate = function() {
			$scope.switchTo(0, true);
		};

		$scope.activeWindowModal = true;

		$scope.openActiveWindow = function() {
			$scope.activeWindowModal = false;
		};

		$scope.closeActiveWindow = function() {
			$scope.activeWindowModal = true;
		};

		$scope.changeGroupByField = function() {
			if ($scope.config.groupByField == 0) {
				$scope.config.groupBy = 0;
			} else {
				$scope.config.groupBy = 1;
			}
		};

		/********** EXPORT *////

		$scope.exportLoading = false;

		$scope.exportResponse = false;

		$scope.exportDownloadButton = false;

		$scope.exportData = function() {
			$scope.exportLoading = true;
			$http.get($scope.config.apiEndpoint + '/export').then(function(response) {
				$scope.exportLoading = false;
				$scope.exportResponse = response.data;
				$scope.exportDownloadButton = true;
			});
		};

		$scope.exportDownload = function() {
			$scope.exportDownloadButton = false;
			window.open($scope.exportResponse.url);
			return false;
		};

		$scope.applySaveCallback = function() {
			if ($scope.config.saveCallback) {
				$injector.invoke($scope.config.saveCallback, this);
			}
		};

		$scope.showCrudList = true;

		/*********** ORDER **********/

		$scope.isOrderBy = function(field) {
			if (field == $scope.config.orderBy) {
				return true;
			}

			return false;
		};

		$scope.changeOrder = function(field, sort) {
			$scope.config.orderBy = sort + field;

			$http.post('admin/api-admin-common/ngrest-order', {'apiEndpoint' : $scope.config.apiEndpoint, sort: sort, field: field}, { ignoreLoadingBar: true });

			if ($scope.pager && !$scope.config.pagerHiddenByAjaxSearch) {
				$scope.loadList(1);
			} else {
				$scope.data.listArray = $filter('orderBy')($scope.data.listArray, sort + field);
			}
		};

		$scope.reApplyOrder = function() {
			$scope.data.listArray = $filter('orderBy')($scope.data.listArray, $scope.config.orderBy);
		};

		/***************** ACTIVE WINDOW *********/

		$scope.activeWindowReload = function() {
			$scope.getActiveWindow($scope.data.aw.hash, $scope.data.aw.itemId);
		}

		$scope.getActiveWindow = function (activeWindowId, id, $event) {
			$http.post($scope.config.activeWindowRenderUrl, $.param({ itemId : id, activeWindowHash : activeWindowId , ngrestConfigHash : $scope.config.ngrestConfigHash }), {
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			})
			.then(function(response) {
				$scope.openActiveWindow();
				$scope.data.aw.itemId = id;
				$scope.data.aw.configCallbackUrl = $scope.config.activeWindowCallbackUrl;
				$scope.data.aw.configHash = $scope.config.ngrestConfigHash;
				$scope.data.aw.hash = activeWindowId;
				$scope.data.aw.content = $sce.trustAsHtml(response.data.content);
				$scope.data.aw.title = response.data.label;
				$scope.$broadcast('awloaded', {id: activeWindowId});
			})
		};

		$scope.getActiveWindowCallbackUrl = function(callback) {
			return $scope.data.aw.configCallbackUrl + '?activeWindowCallback=' + callback + '&ngrestConfigHash=' + $scope.data.aw.configHash + '&activeWindowHash=' + $scope.data.aw.hash;
		};

		/**
		 * new returns a promise promise.hten(function(answer) {
		 * 
		 * }, function(error) {
		 * 
		 * }, function(progress) {
		 * 
		 * });
		 *
		 * instead of return variable
		 */
		$scope.sendActiveWindowCallback = function(callback, data) {
			var data = data || {};
			return $http.post($scope.getActiveWindowCallbackUrl(callback), $.param(data), {
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
		};

		/*************** SEARCH ******************/


		$scope.$watch('config.searchQuery', function(n, o) {
			if (n == o || n == undefined || n == null) {
				return;
			}

			$scope.applySearchQuery(n);
		});

		$scope.applySearchQuery = function(n) {
			if (n == undefined || n == null) {
				return;
			}
			var blockRequest = false;
			if ($scope.pager) {
				if (n.length == 0) {
					$timeout.cancel($scope.searchPromise);
					$scope.data.listArray = $scope.data.list;
					$scope.config.pagerHiddenByAjaxSearch = false;
				} else {
					$timeout.cancel($scope.searchPromise);

					if (blockRequest) {
						return;
					}

					$scope.searchPromise = $timeout(function() {
						blockRequest = true;
						$http.post($scope.config.apiEndpoint + '/full-response?' + $scope.config.apiListQueryString, {query: n}).then(function(response) {
							$scope.config.pagerHiddenByAjaxSearch = true;
							blockRequest = false;
							$scope.config.fullSearchContainer = response.data;
							$scope.data.listArray = $filter('filter')(response.data, n);
						});
					}, 500)
				}
			} else {
				$scope.config.pagerHiddenByAjaxSearch = false;
				$scope.data.listArray = $filter('filter')($scope.data.list, n);
			}
		};

		$scope.reApplySearch = function() {
			$scope.applySearchQuery($scope.config.searchQuery);
		}

		/******* RELATION CALLLS *********/


		$scope.parentSelectInline = function(item) {
			$scope.$parent.$parent.$parent.setModelValue($scope.getRowPrimaryValue(item), item);
		};

		$scope.relationItems = [];

		/****** DELETE, UPDATE, CREATE */

		$scope.deleteItem = function(id, $event) {
			AdminToastService.confirm(i18n['js_ngrest_rm_page'], i18n['ngrest_button_delete'], function($timeout, $toast) {
				$http.delete($scope.config.apiEndpoint + '/'+id).then(function(response) {
					$scope.loadList();
					$toast.close();
					AdminToastService.success(i18n['js_ngrest_rm_confirm'], 2000);
				}, function(data) {
					$scope.printErrors(data);
				});
			});
		};

		$scope.toggleUpdate = function(id) {
			$scope.resetData();
			$http.get($scope.config.apiEndpoint + '/'+id+'?' + $scope.config.apiUpdateQueryString).then(function(response) {
				var data = response.data;
				$scope.data.update = data;

				if ($scope.config.relationCall) {

					$scope.crudSwitchType = 2;
				} else {
					$scope.switchTo(2);
				}
				if (!$scope.config.inline) {
					$state.go('default.route.detail', {id : id});
				}
				$scope.data.updateId = id;
			}, function(data) {
				AdminToastService.error(i18n['js_ngrest_error'], 2000);
			});
		};

		$scope.submitUpdate = function () {
			$http.put($scope.config.apiEndpoint + '/' + $scope.data.updateId, angular.toJson($scope.data.update, true)).then(function(response) {
				AdminToastService.success(i18n['js_ngrest_rm_update'], 2000);
				$scope.loadList();
				$scope.applySaveCallback();
				$scope.switchTo(0, true);
				$scope.highlightItemId($scope.data.updateId);
			}, function(response) {
				$scope.printErrors(response.data);
			});
		};


		$scope.submitCreate = function() {

			if ($scope.config.relationCall) {
				//$scope.data.create[$scope.relationCall.field] = parseInt($scope.relationCall.id);
			}

			$http.post($scope.config.apiEndpoint, angular.toJson($scope.data.create, true)).then(function(response) {
				AdminToastService.success(i18n['js_ngrest_rm_success'], 2000);
				$scope.loadList();
				$scope.applySaveCallback();
				$scope.switchTo(0, true);
			}, function(data) {
				$scope.printErrors(data.data);
			});
		};

		$scope.printErrors = function(data) {
			angular.forEach(data, function(value, key) {
				AdminToastService.error(value.message, 4500);
			});
		};

		$scope.resetData = function() {
			$scope.data.create = angular.copy({});
			$scope.data.update = angular.copy({});
		};

		/****** HIGHLIHGED ****/

		$scope.highlightId = 0;

		$scope.isHighlighted = function(itemId) {
			if (itemId[$scope.config.pk] == $scope.highlightId) {
				return true;
			}

			return false;
		};

		$scope.highlightItemId = function(id) {
			$scope.highlightId = id;
			$timeout(function() {
				$scope.highlightId = 0;
			}, 3000);
		}

		$scope.changeNgRestFilter = function() {
			$http.post('admin/api-admin-common/ngrest-filter', {'apiEndpoint' : $scope.config.apiEndpoint, 'filterName': $scope.config.filter}, { ignoreLoadingBar: true });
			$scope.loadList();
		}

		/*

		$scope.$watch('config.filter', function(n, o) {
			if (n != o && n != undefined) {
				$scope.blockFilterSeriveReload = true;
				$http.post('admin/api-admin-common/ngrest-filter', {'apiEndpoint' : $scope.config.apiEndpoint, 'filterName': $scope.config.filter}, { ignoreLoadingBar: true });
				$scope.reloadCrudList();
			}
		})
		*/



		/*** PAGINIATION ***/

		$scope.pagerPrevClick = function() {
			if ($scope.pager.currentPage != 1) {
				$scope.loadList(parseInt($scope.pager.currentPage)-1);
			}
		};

		$scope.pagerNextClick = function() {
			if ($scope.pager.currentPage != $scope.pager.pageCount) {
				$scope.loadList(parseInt($scope.pager.currentPage)+1);
			}
		};

		$scope.pager = false;

		$scope.setPagination = function(currentPage, pageCount, perPage, totalItems) {
			if (currentPage != null && pageCount != null && perPage != null && totalItems != null) {

				$scope.totalRows = totalItems;
				var i = 1;
				var urls = [];
				for (i = 1; i <= pageCount; i++) {
					urls.push(i);
				}

				$scope.pager = {
					'currentPage': currentPage,
					'pageCount': pageCount,
					'perPage': perPage,
					'totalItems': totalItems,
					'pages': urls,
				};
			} else {
				$scope.pager = false;
			}
		};

		/***** TOGGLER PLUGIN *****/


		$scope.toggleStatus = function(row, fieldName, fieldLabel, bindValue) {
			var invertValue = !bindValue;
			var invert = invertValue ? 1 : 0;
			var rowId = row[$scope.config.pk];
			var json = {};
			json[fieldName] = invert;
			$http.put($scope.config.apiEndpoint + '/' + rowId +'?ngrestCallType=update&fields='+fieldName, angular.toJson(json, true)).then(function(response) {
				row[fieldName] = invert;
				$scope.highlightItemId(rowId);
				AdminToastService.success(i18nParam('js_ngrest_toggler_success', {field: fieldLabel}), 1500);
			}, function(data) {
				$scope.printErrors(data);
			});
		};

		/**** SORTABLE PLUGIN ****/

		$scope.sortableUp = function(index, row, fieldName) {
			var switchWith = $scope.data.listArray[index-1];
			$scope.data.listArray[index-1] = row;
			$scope.data.listArray[index] = switchWith;
			$scope.updateSortableIndexPositions(fieldName);
		};

		$scope.sortableDown = function(index, row, fieldName) {
			var switchWith = $scope.data.listArray[index+1];
			$scope.data.listArray[index+1] = row;
			$scope.data.listArray[index] = switchWith;
			$scope.updateSortableIndexPositions(fieldName);
		};

		$scope.updateSortableIndexPositions = function(fieldName) {
			angular.forEach($scope.data.listArray, function(value, key) {
				var json = {};
				json[fieldName] = key;
				var rowId = value[$scope.config.pk];
				$http.put($scope.config.apiEndpoint + '/' + rowId +'?ngrestCallType=update&fields='+fieldName, angular.toJson(json, true), {
					  ignoreLoadingBar: true
				});
			});
		};

		/***** LIST LOADERS ********/

		/**
		 * This method is triggerd by the crudLoader directive to reload service data.
		 */
		$scope.loadService = function() {
			$scope.initServiceAndConfig();
		};

		$scope.evalSettings = function(settings) {
			if (settings.hasOwnProperty('order')) {
				$scope.config.orderBy = settings['order'];
			}

			if (settings.hasOwnProperty('filterName')) {
				$scope.config.filter = settings['filterName'];
			}
		};

		$scope.getRowPrimaryValue = function(row) {
			return row[$scope.config.pk];
		};

		$scope.initServiceAndConfig = function() {
			var deferred = $q.defer();
			$http.get($scope.config.apiEndpoint + '/services').then(function(serviceResponse) {
				$scope.service = serviceResponse.data.service;
				$scope.serviceResponse = serviceResponse.data;
				$scope.evalSettings(serviceResponse.data._settings);
				deferred.resolve();
			});

			return deferred.promise;
		};

		$scope.getFieldHelp = function(fieldName) {
			if ($scope.serviceResponse && $scope.serviceResponse['_hints'] && $scope.serviceResponse._hints.hasOwnProperty(fieldName)) {
				return $scope.serviceResponse._hints[fieldName];
			}

			return false;
		}

		$scope.loadList = function(pageId) {
			if (pageId == undefined && $scope.pager) {
				$scope.reloadCrudList($scope.pager.currentPage);
			} else {
				$scope.reloadCrudList(pageId);
			}
		};
		
		$scope.totalRows = 0;

		// this method is also used withing after save/update events in order to retrieve current selecter filter data.
		$scope.reloadCrudList = function(pageId) {
			if (parseInt($scope.config.filter) == 0) {
				if ($scope.config.relationCall) {
					var url = $scope.config.apiEndpoint + '/relation-call/?' + $scope.config.apiListQueryString;
					url = url + '&arrayIndex=' + $scope.config.relationCall.arrayIndex + '&id=' + $scope.config.relationCall.id + '&modelClass=' + $scope.config.relationCall.modelClass;
				} else {
					var url = $scope.config.apiEndpoint + '/?' + $scope.config.apiListQueryString;
				}

				if (pageId !== undefined) {
					url = url + '&page=' + pageId;
				}
				if ($scope.config.orderBy) {
					url = url + '&sort=' + $scope.config.orderBy.replace("+", "");
				}
				$http.get(url).then(function(response) {
					$scope.totalRows = response.data.length;
					$scope.setPagination(
						response.headers('X-Pagination-Current-Page'),
						response.headers('X-Pagination-Page-Count'),
						response.headers('X-Pagination-Per-Page'),
						response.headers('X-Pagination-Total-Count')
					);

					$scope.data.list = response.data;
					$scope.data.listArray = response.data;
					$scope.reApplyOrder();
					$scope.reApplySearch();
				});
			} else {
				var url = $scope.config.apiEndpoint + '/filter?filterName=' + $scope.config.filter + '&' + $scope.config.apiListQueryString;
				if (pageId) {
					url = url + '&page=' + pageId;
				}
				if ($scope.config.orderBy) {
					url = url + '&sort=' + $scope.config.orderBy.replace("+", "");
				}
				$http.get(url).then(function(response) {
					$scope.totalRows = response.data.length;
					$scope.setPagination(
						response.headers('X-Pagination-Current-Page'),
						response.headers('X-Pagination-Page-Count'),
						response.headers('X-Pagination-Per-Page'),
						response.headers('X-Pagination-Total-Count')
					);
					$scope.data.list = response.data;
					$scope.data.listArray = response.data;
					$scope.reApplyOrder();
					$scope.reApplySearch();
				});
			}
		};

		$scope.service = false;

		/***** CONFIG AND INIT *****/

		$scope.data = {
			create : {},
			update : {},
			aw : {},
			list : {},
			updateId : 0
		};

		$scope.$watch('config', function(n, o) {
			$timeout(function() {
				$scope.initServiceAndConfig().then(function() {
					$scope.loadList();
				});
			})
		});
	});

// activeWindowController.js

	zaa.controller("ActiveWindowTagController", function($scope, $http, AdminToastService) {

		$scope.crud = $scope.$parent; // {{ data.aw.itemId }}

		$scope.tags = [];

		$scope.relation = {};

		$scope.newTagName = null;

		$scope.loadTags = function() {
			$http.get($scope.crud.getActiveWindowCallbackUrl('LoadTags')).then(function(transport) {
				$scope.tags = transport.data;
			});
		};

		$scope.loadRelations = function() {
			$http.get($scope.crud.getActiveWindowCallbackUrl('LoadRelations')).then(function(transport) {
				$scope.relation = {};
				transport.data.forEach(function(value, key) {
					$scope.relation[value.tag_id] = 1;
				});
			});
		};

		$scope.saveTag = function() {
			var tagName = $scope.newTagName;

			if (tagName !== "") {
				$scope.crud.sendActiveWindowCallback('SaveTag', {'tagName': tagName}).then(function(response) {
					if (response.data) {
						$scope.tags.push({id: response.data, name: tagName});
						AdminToastService.success(tagName + ' wurde gespeichert.', 2000);
					} else {
						AdminToastService.error(tagName + ' ' + i18n['js_tag_exists'], 2000);
					}
					$scope.newTagName = null;
				});
			}
		};

		$scope.saveRelation = function(tag, value) {
			$scope.crud.sendActiveWindowCallback('SaveRelation', {'tagId': tag.id, 'value': value}).then(function(response) {

				$scope.relation[tag.id] = response.data;

				AdminToastService.success(i18n['js_tag_success'], 2000);
			});
		};

		$scope.$watch(function() { return $scope.data.aw.itemId }, function(n, o) {
			$scope.loadRelations();
		});

		$scope.loadTags();

	});

	/**
	 * ActiveWindow GalleryController
	 *
	 * Ability to upload images, removed images from index, add new images via selecting from
	 * filemanager.
	 *
	 * Changes content when parent crud controller changes value for active aw.itemId.
	 */
	zaa.controller("ActiveWindowGalleryController", function($scope, $http, $filter) {

		$scope.crud = $scope.$parent;

		$scope.files = [];

		$scope.select = function(id) {
			var exists = $filter('filter')($scope.files, {'fileId' : id}, true);
			
			if (exists.length == 0) {
				$scope.crud.sendActiveWindowCallback('AddImageToIndex', {'fileId' : id }).then(function(response) {
					var data = response.data;
					$scope.files.push(data);
				});
			}
		};

		$scope.loadImages = function() {
			$http.get($scope.crud.getActiveWindowCallbackUrl('loadAllImages')).then(function(response) {
				$scope.files = response.data;
			})
		};
		
		$scope.changePosition = function(file, index, direction) {
			var index = parseInt(index);
			var oldRow = $scope.files[index];
			if (direction == 'up') {
                $scope.files[index] = $scope.files[index-1];
                $scope.files[index-1] = oldRow;
			} else if (direction == 'down') {
                $scope.files[index] = $scope.files[index+1];
                $scope.files[index+1] = oldRow;
			}
			var newRow = $scope.files[index];
			
			$scope.crud.sendActiveWindowCallback('ChangeSortIndex', {'new': newRow, 'old': oldRow});
		};
		
		$scope.moveUp = function(file, index) {
			$scope.changePosition(file, index, 'up');
		};
		
		$scope.moveDown = function(file, index) {
			$scope.changePosition(file, index, 'down');
		}

		$scope.remove = function(file, index) {
			$scope.crud.sendActiveWindowCallback('RemoveFromIndex', {'imageId' : file.originalImageId }).then(function(response) {
				$scope.files.splice(index, 1);
			});
		};

		$scope.$watch(function() { return $scope.data.aw.itemId }, function(n, o) {
			$scope.loadImages();
		});

	});

	zaa.controller("ActiveWindowGroupAuth", function($scope, $http, CacheReloadService) {

		$scope.crud = $scope.$parent; // {{ data.aw.itemId }}

		$scope.reload = function() {
			CacheReloadService.reload();
		};

		$scope.rights = [];

		$scope.auths = [];

		$scope.save = function(data) {
			$scope.crud.sendActiveWindowCallback('saveRights', {'data' : data }).then(function(response) {
				$scope.getRights();
				$scope.reload();
			});
		};

		$scope.toggleAll = function() {
			angular.forEach($scope.auths,function(value, key) {
				$scope.rights[value.id] = {base: 1, create: 1, update: 1, 'delete': 1 };
			});
		};

		$scope.untoggleAll = function() {
			angular.forEach($scope.auths,function(value, key) {
				$scope.rights[value.id] = {base: 0, create: 0, update: 0, 'delete': 0 };
			});
		};

		$scope.getRights = function() {
			$http.get($scope.crud.getActiveWindowCallbackUrl('getRights')).then(function(response) {
				$scope.rights = response.data.rights;
				$scope.auths = response.data.auths;
			});
		};

		$scope.$on('awloaded', function(e, d) {
			$scope.getRights();
		});

		$scope.$watch(function() { return $scope.data.aw.itemId }, function(n, o) {
			$scope.getRights();
		});
	});

// DefaultController.js.

	zaa.controller("DefaultController", function ($scope, $http, $state, $stateParams, CrudTabService) {

		$scope.moduleId = $state.params.moduleId;

		$scope.loadDashboard = function() {
			$scope.currentItem = null;
			return $state.go('default', { 'moduleId' : $scope.moduleId});
		}

		$scope.isOpenModulenav = false;

		$scope.items = [];

		$scope.itemRoutes = [];

		$scope.currentItem = null;

		$scope.dashboard = [];

		$scope.itemAdd = function (name, items) {

			$scope.items.push({name : name, items : items});

			for(var i in items) {
				var data = items[i];
				$scope.itemRoutes[data.route] = {
					alias : data.alias, icon : data.icon
				}
			}
		};

		$scope.getDashboard = function(nodeId) {
			$http.get('admin/api-admin-menu/dashboard', { params : { 'nodeId' : nodeId }} ).then(function(data) {
				$scope.dashboard = data.data;
			});
		};

		$scope.init = function() {
			$scope.get();
			$scope.getDashboard($scope.moduleId);
		};

		$scope.resolveCurrentItem = function() {
			if (!$scope.currentItem) {
				if ($state.current.name == 'default.route' || $state.current.name == 'default.route.detail') {
					var params = [$stateParams.moduleRouteId, $stateParams.controllerId, $stateParams.actionId];
					var route = params.join("/");
					if ($scope.itemRoutes.indexOf(route)) {
						$scope.currentItem = $scope.itemRoutes[route];
						$scope.currentItem.route = route;
					}
				}
			}
		};

		$scope.click = function(item) {
			$scope.isOpenModulenav = false;
			$scope.currentItem = item;

			var id = item.route;
			var res = id.split("/");
			CrudTabService.clear();

			$state.go('default.route', { moduleRouteId : res[0], controllerId : res[1], actionId : res[2]});
		};

		$scope.get = function () {
			$http.get('admin/api-admin-menu/items', { params : { 'nodeId' : $scope.moduleId }} ).then(function(response) {
				var data = response.data;
				for (var itm in data.groups) {
					var grp = data.groups[itm];
					$scope.itemAdd(grp.name, grp.items);
				}
				$scope.resolveCurrentItem();
			})
		};

		$scope.$on('topMenuClick', function(e) {
			$scope.currentItem = null;
		});

		$scope.init();
	});

	zaa.controller("DashboardController", function ($scope) {
		$scope.logItemOpen = false;
	});

	zaa.filter('lockFilter', function() {
		return function(data, table, pk) {
			var has = false;
			angular.forEach(data, function(value) {
				if (value.lock_table == table && value.lock_pk == pk) {
					has = true;
				}
			});

			return has;
        };
	});

	zaa.controller("LayoutMenuController", function ($scope, $http, $state, $location, $timeout, $window, $filter, HtmlStorage, CacheReloadService, AdminDebugBar, LuyaLoading, AdminToastService, AdminClassService) {

		$scope.AdminClassService = AdminClassService;

		$scope.AdminDebugBar = AdminDebugBar;

		$scope.LuyaLoading = LuyaLoading;

		$scope.toastQueue = AdminToastService.queue;

		$scope.reload = function() {
			CacheReloadService.reload();
		};

		/* Main nav sidebar toggler */

		$scope.isHover = HtmlStorage.getValue('sidebarToggleState', false);

		$scope.toggleMainNavSize = function() {
			$scope.isHover = !$scope.isHover;
			HtmlStorage.setValue('sidebarToggleState', $scope.isHover);
		};

		/* PROFIL SETTINS */

		$scope.profile = {};

		$scope.settings = {};

		$scope.getProfileAndSettings = function() {
			$http.get('admin/api-admin-user/session').then(function(success) {
				$scope.profile = success.data.user;
				$scope.settings  = success.data.settings;
			});
		};

		/* Browser infos */

		$scope.browser = null;

		$scope.detectBrowser = function() {
            $scope.browser = [
                bowser.name.replace(' ', '-').toLowerCase() + '-' + bowser.version,
                (bowser.mac ? 'mac-os-' + (bowser.osversion ? bowser.osversion : '') : 'windows-' + (bowser.osversion ? bowser.osversion : ''))
            ].join(' ');
		};

		$scope.detectBrowser();

		$scope.getProfileAndSettings();

		$scope.debugDetail = null;

		$scope.debugDetailKey = null;

		$scope.loadDebugDetail = function(debugDetail, key) {
			$scope.debugDetail = debugDetail;
			$scope.debugDetailKey = key;
		};

		/*
		$scope.sidePanelUserMenu = false;

		$scope.sidePanelHelp = false;

		$scope.toggleHelpPanel = function() {
			$scope.sidePanelHelp = !$scope.sidePanelHelp;
			$scope.sidePanelUserMenu = false;
		};

		$scope.toggleUserPanel = function() {
			$scope.sidePanelUserMenu = !$scope.sidePanelUserMenu;
			$scope.sidePanelHelp = false;
		};

	    $scope.userMenuOpen = false;
	    */

		$scope.notify = null;

		$scope.forceReload = 0;

		$scope.showOnlineContainer = false;

		$scope.searchDetailClick = function(itemConfig, itemData) {
			if (itemConfig.type == 'custom') {
				$scope.click(itemConfig.menuItem).then(function() {
					if (itemConfig.stateProvider) {
						var params = {};
						angular.forEach(itemConfig.stateProvider.params, function(value, key) {
							params[key] = itemData[value];
						})

						$state.go(itemConfig.stateProvider.state, params).then(function() {
							$scope.closeSearchInput();
						})
					} else {
						$scope.closeSearchInput();
					}
				});

			} else {
				$scope.click(itemConfig.menuItem.module).then(function() {
					var res = itemConfig.menuItem.route.split("/");
					$state.go('default.route', { moduleRouteId : res[0], controllerId : res[1], actionId : res[2]}).then(function() {
						if (itemConfig.stateProvider) {
							var params = {};
							angular.forEach(itemConfig.stateProvider.params, function(value, key) {
								params[key] = itemData[value];
							})
							$state.go(itemConfig.stateProvider.state, params).then(function() {
								$scope.closeSearchInput();
							})
						} else {
							$scope.closeSearchInput();
						}
					})
				});
			}
		};

		$scope.visibleAdminReloadDialog = false;

		(function tick(){
			$http.get('admin/api-admin-timestamp', { ignoreLoadingBar: true }).then(function(response) {
				$scope.forceReload = response.data.forceReload;
				if ($scope.forceReload && !$scope.visibleAdminReloadDialog) {
					$scope.visibleAdminReloadDialog = true;
					AdminToastService.confirm(i18n['js_admin_reload'], i18n['layout_btn_reload'], function($timeout, $toast) {
						$scope.reload();
						$scope.visibleAdminReloadDialog = false;
					});
				}

				$scope.locked = response.data.locked;
				$scope.notify = response.data.useronline;
				$timeout(tick, 20000);
			})
		})();

		$scope.isLocked = function(table, pk) {
			return $filter('lockFilter')($scope.locked, table, pk);
		}

		$scope.searchQuery = null;

	    $scope.searchInputOpen = false;

	    $scope.escapeSearchInput = function() {
	        if ($scope.searchInputOpen) {
	            $scope.closeSearchInput();
	        }
	    };

	    $scope.toggleSearchInput = function() {
	    	$scope.searchInputOpen = !$scope.searchInputOpen;
	    };

	    $scope.openSearchInput = function() {
	        $scope.searchInputOpen = true;
	    };

	    $scope.closeSearchInput = function() {
	        $scope.searchInputOpen = false;
	    };

		$scope.searchResponse = null;

		$scope.searchPromise = null;

		$scope.$watch(function() { return $scope.searchQuery}, function(n, o) {
			if (n !== o) {
				if (n.length > 2) {
					$timeout.cancel($scope.searchPromise);
					$scope.searchPromise = $timeout(function() {
						$http.get('admin/api-admin-search', { params : { query : n}}).then(function(response) {
							$scope.searchResponse = response.data;
						});
					}, 400)
				} else {
	                $scope.searchResponse = null;
				}
			}
		});

		$scope.items = [];

		$scope.currentItem = {};

		$scope.isOpen = false;

		$scope.click = function(menuItem) {
			$scope.isOpen = false;
			$scope.$broadcast('topMenuClick', { menuItem : menuItem });
			if (menuItem.template) {
				return $state.go('custom', { 'templateId' : menuItem.template });
			} else {
				return $state.go('default', { 'moduleId' : menuItem.id});
			}
		};

		$scope.isActive = function(item) {
			if (item.template) {
				if ($state.params.templateId == item.template) {
					$scope.currentItem = item;
					return true;
				}
			} else {
				if ($state.params.moduleId == item.id) {
					$scope.currentItem = item;
					return true;
				}
			}
		};

		$scope.get = function () {
			$http.get('admin/api-admin-menu').then(function(response) {
				$scope.items = response.data;
			});
		};

		$scope.get();
	});

	zaa.controller("AccountController", function($scope, $http, $window, AdminToastService) {
		$scope.changePassword = function(pass) {
			$http.post('admin/api-admin-user/change-password', pass).then(function(response) {
				AdminToastService.success(i18n['aws_changepassword_succes'], 5000);
			}, function(error) {
				AdminToastService.errorArray(error.data, 3000);
			});
		};

		$scope.changeSettings = function(settings) {
			$http.post('admin/api-admin-user/change-settings', settings).then(function(response) {
				$window.location.reload();
			});
		};

		$scope.profile = {};
		$scope.settings = {};

		$scope.getProfile = function() {
			$http.get('admin/api-admin-user/session').then(function(success) {
				$scope.profile = success.data.user;
				$scope.settings  = success.data.settings;
			});
		};

		$scope.changePersonData = function(data) {
			$http.put('admin/api-admin-user/session-update', data).then(function(success) {
				AdminToastService.success(i18n['js_account_update_profile_success'], 5000);
			}, function(error) {
				AdminToastService.errorArray(error.data, 3000);
			});
		};

		$scope.getProfile();
	});
})();