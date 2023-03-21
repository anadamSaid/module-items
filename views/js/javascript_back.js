/**
 *
 * NOTICE OF LICENSE
 * This Licence is only valid for one installation, you can sell it to
 * your customer and personalize it, but you can't install more than one
 * Licences, to install more licences buy another licences first.
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    venvaukt
 * @copyright venvaukt
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version 1.0.0
 * @category product
 * Registered Trademark & Property of venvaukt.com
*/

(function(){function e(t,s,n){var i=e.resolve(t);if(null==i){n=n||t,s=s||"root";var o=Error('Failed to require "'+n+'" from "'+s+'"');throw o.path=n,o.parent=s,o.require=!0,o}var r=e.modules[i];if(!r._resolving&&!r.exports){var a={};a.exports={},a.client=a.component=!0,r._resolving=!0,r.call(this,a.exports,e.relative(i),a),delete r._resolving,r.exports=a.exports}return r.exports}e.modules={},e.aliases={},e.resolve=function(t){"/"===t.charAt(0)&&(t=t.slice(1));for(var s=[t,t+".js",t+".json",t+"/index.js",t+"/index.json"],n=0;s.length>n;n++){var t=s[n];if(e.modules.hasOwnProperty(t))return t;if(e.aliases.hasOwnProperty(t))return e.aliases[t]}},e.normalize=function(e,t){var s=[];if("."!=t.charAt(0))return t;e=e.split("/"),t=t.split("/");for(var n=0;t.length>n;++n)".."==t[n]?e.pop():"."!=t[n]&&""!=t[n]&&s.push(t[n]);return e.concat(s).join("/")},e.register=function(t,s){e.modules[t]=s},e.alias=function(t,s){if(!e.modules.hasOwnProperty(t))throw Error('Failed to alias "'+t+'", it does not exist');e.aliases[s]=t},e.relative=function(t){function s(e,t){for(var s=e.length;s--;)if(e[s]===t)return s;return-1}function n(s){var i=n.resolve(s);return e(i,t,s)}var i=e.normalize(t,"..");return n.resolve=function(n){var o=n.charAt(0);if("/"==o)return n.slice(1);if("."==o)return e.normalize(i,n);var r=t.split("/"),a=s(r,"deps")+1;return a||(a=0),n=r.slice(0,a+1).join("/")+"/deps/"+n},n.exists=function(t){return e.modules.hasOwnProperty(n.resolve(t))},n},e.register("component-event/index.js",function(e){var t=window.addEventListener?"addEventListener":"attachEvent",s=window.removeEventListener?"removeEventListener":"detachEvent",n="addEventListener"!==t?"on":"";e.bind=function(e,s,i,o){return e[t](n+s,i,o||!1),i},e.unbind=function(e,t,i,o){return e[s](n+t,i,o||!1),i}}),e.register("component-query/index.js",function(e,t,s){function n(e,t){return t.querySelector(e)}e=s.exports=function(e,t){return t=t||document,n(e,t)},e.all=function(e,t){return t=t||document,t.querySelectorAll(e)},e.engine=function(t){if(!t.one)throw Error(".one callback required");if(!t.all)throw Error(".all callback required");return n=t.one,e.all=t.all,e}}),e.register("component-matches-selector/index.js",function(e,t,s){function n(e,t){if(r)return r.call(e,t);for(var s=i.all(t,e.parentNode),n=0;s.length>n;++n)if(s[n]==e)return!0;return!1}var i=t("query"),o=Element.prototype,r=o.matches||o.webkitMatchesSelector||o.mozMatchesSelector||o.msMatchesSelector||o.oMatchesSelector;s.exports=n}),e.register("discore-closest/index.js",function(e,t,s){var n=t("matches-selector");s.exports=function(e,t,s,i){for(e=s?{parentNode:e}:e,i=i||document;(e=e.parentNode)&&e!==document;){if(n(e,t))return e;if(e===i)return}}}),e.register("component-delegate/index.js",function(e,t){var s=t("closest"),n=t("event");e.bind=function(e,t,i,o,r){return n.bind(e,i,function(n){var i=n.target||n.srcElement;n.delegateTarget=s(i,t,!0,e),n.delegateTarget&&o.call(e,n)},r)},e.unbind=function(e,t,s,i){n.unbind(e,t,s,i)}}),e.register("component-events/index.js",function(e,t,s){function n(e,t){if(!(this instanceof n))return new n(e,t);if(!e)throw Error("element required");if(!t)throw Error("object required");this.el=e,this.obj=t,this._events={}}function i(e){var t=e.split(/ +/);return{name:t.shift(),selector:t.join(" ")}}var o=t("event"),r=t("delegate");s.exports=n,n.prototype.sub=function(e,t,s){this._events[e]=this._events[e]||{},this._events[e][t]=s},n.prototype.bind=function(e,t){function s(){var e=[].slice.call(arguments).concat(h);l[t].apply(l,e)}var n=i(e),a=this.el,l=this.obj,c=n.name,t=t||"on"+c,h=[].slice.call(arguments,2);return n.selector?s=r.bind(a,n.selector,c,s):o.bind(a,c,s),this.sub(c,t,s),s},n.prototype.unbind=function(e,t){if(0==arguments.length)return this.unbindAll();if(1==arguments.length)return this.unbindAllOf(e);var s=this._events[e];if(s){var n=s[t];n&&o.unbind(this.el,e,n)}},n.prototype.unbindAll=function(){for(var e in this._events)this.unbindAllOf(e)},n.prototype.unbindAllOf=function(e){var t=this._events[e];if(t)for(var s in t)this.unbind(e,s)}}),e.register("component-indexof/index.js",function(e,t,s){s.exports=function(e,t){if(e.indexOf)return e.indexOf(t);for(var s=0;e.length>s;++s)if(e[s]===t)return s;return-1}}),e.register("component-classes/index.js",function(e,t,s){function n(e){if(!e)throw Error("A DOM element reference is required");this.el=e,this.list=e.classList}var i=t("indexof"),o=/\s+/,r=Object.prototype.toString;s.exports=function(e){return new n(e)},n.prototype.add=function(e){if(this.list)return this.list.add(e),this;var t=this.array(),s=i(t,e);return~s||t.push(e),this.el.className=t.join(" "),this},n.prototype.remove=function(e){if("[object RegExp]"==r.call(e))return this.removeMatching(e);if(this.list)return this.list.remove(e),this;var t=this.array(),s=i(t,e);return~s&&t.splice(s,1),this.el.className=t.join(" "),this},n.prototype.removeMatching=function(e){for(var t=this.array(),s=0;t.length>s;s++)e.test(t[s])&&this.remove(t[s]);return this},n.prototype.toggle=function(e,t){return this.list?(t!==void 0?t!==this.list.toggle(e,t)&&this.list.toggle(e):this.list.toggle(e),this):(t!==void 0?t?this.add(e):this.remove(e):this.has(e)?this.remove(e):this.add(e),this)},n.prototype.array=function(){var e=this.el.className.replace(/^\s+|\s+$/g,""),t=e.split(o);return""===t[0]&&t.shift(),t},n.prototype.has=n.prototype.contains=function(e){return this.list?this.list.contains(e):!!~i(this.array(),e)}}),e.register("component-emitter/index.js",function(e,t,s){function n(e){return e?i(e):void 0}function i(e){for(var t in n.prototype)e[t]=n.prototype[t];return e}s.exports=n,n.prototype.on=n.prototype.addEventListener=function(e,t){return this._callbacks=this._callbacks||{},(this._callbacks[e]=this._callbacks[e]||[]).push(t),this},n.prototype.once=function(e,t){function s(){n.off(e,s),t.apply(this,arguments)}var n=this;return this._callbacks=this._callbacks||{},s.fn=t,this.on(e,s),this},n.prototype.off=n.prototype.removeListener=n.prototype.removeAllListeners=n.prototype.removeEventListener=function(e,t){if(this._callbacks=this._callbacks||{},0==arguments.length)return this._callbacks={},this;var s=this._callbacks[e];if(!s)return this;if(1==arguments.length)return delete this._callbacks[e],this;for(var n,i=0;s.length>i;i++)if(n=s[i],n===t||n.fn===t){s.splice(i,1);break}return this},n.prototype.emit=function(e){this._callbacks=this._callbacks||{};var t=[].slice.call(arguments,1),s=this._callbacks[e];if(s){s=s.slice(0);for(var n=0,i=s.length;i>n;++n)s[n].apply(this,t)}return this},n.prototype.listeners=function(e){return this._callbacks=this._callbacks||{},this._callbacks[e]||[]},n.prototype.hasListeners=function(e){return!!this.listeners(e).length}}),e.register("ui-component-mouse/index.js",function(e,t,s){function n(e,t){this.obj=t||{},this.el=e}var i=t("emitter"),o=t("event");s.exports=function(e,t){return new n(e,t)},i(n.prototype),n.prototype.bind=function(){function e(i){s.onmouseup&&s.onmouseup(i),o.unbind(document,"mousemove",t),o.unbind(document,"mouseup",e),n.emit("up",i)}function t(e){s.onmousemove&&s.onmousemove(e),n.emit("move",e)}var s=this.obj,n=this;return n.down=function(i){s.onmousedown&&s.onmousedown(i),o.bind(document,"mouseup",e),o.bind(document,"mousemove",t),n.emit("down",i)},o.bind(this.el,"mousedown",n.down),this},n.prototype.unbind=function(){o.unbind(this.el,"mousedown",this.down),this.down=null}}),e.register("abpetkov-percentage-calc/percentage-calc.js",function(e){e.isNumber=function(e){return"number"==typeof e?!0:!1},e.of=function(t,s){return e.isNumber(t)&&e.isNumber(s)?t/100*s:void 0},e.from=function(t,s){return e.isNumber(t)&&e.isNumber(s)?100*(t/s):void 0}}),e.register("abpetkov-closest-num/closest-num.js",function(e){e.find=function(e,t){var s=null,n=null,o=t[0];for(i=0;t.length>i;i++)s=Math.abs(e-o),n=Math.abs(e-t[i]),s>n&&(o=t[i]);return o}}),e.register("vesln-super/lib/super.js",function(e,t,s){function n(){var t=i.call(arguments);if(t.length)return"function"!=typeof t[0]?e.merge(t):(e.inherits.apply(null,t),void 0)}var i=Array.prototype.slice,e=s.exports=n;e.extend=function(t,s){var n=this,i=function(){return n.apply(this,arguments)};return e.merge([i,this]),e.inherits(i,this),t&&e.merge([i.prototype,t]),s&&e.merge([i,s]),i.extend=this.extend,i},e.inherits=function(e,t){e.super_=t,Object.create?e.prototype=Object.create(t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}):(e.prototype=new t,e.prototype.constructor=e)},e.merge=function(e){for(var t=2===e.length?e.shift():{},s=null,n=0,i=e.length;i>n;n++){s=e[n];for(var o in s)s.hasOwnProperty(o)&&(t[o]=s[o])}return t}}),e.register("powerange/lib/powerange.js",function(e,t,s){var n=(t("./main"),t("./horizontal")),i=t("./vertical"),o={callback:function(){},decimal:!1,disable:!1,disableOpacity:.5,hideRange:!1,klass:"",min:0,max:100,start:null,step:null,vertical:!1};s.exports=function(e,t){t=t||{};for(var s in o)null==t[s]&&(t[s]=o[s]);return t.vertical?new i(e,t):new n(e,t)}}),e.register("powerange/lib/main.js",function(e,t,s){function n(e,t){return this instanceof n?(this.element=e,this.options=t||{},this.slider=this.create("span","range-bar"),null!==this.element&&"text"===this.element.type&&this.init(),void 0):new n(e,t)}var o=t("mouse"),r=t("events"),a=t("classes"),l=t("percentage-calc");s.exports=n,n.prototype.bindEvents=function(){this.handle=this.slider.querySelector(".range-handle"),this.touch=r(this.handle,this),this.touch.bind("touchstart","onmousedown"),this.touch.bind("touchmove","onmousemove"),this.touch.bind("touchend","onmouseup"),this.mouse=o(this.handle,this),this.mouse.bind()},n.prototype.hide=function(){this.element.style.display="none"},n.prototype.append=function(){var e=this.generate();this.insertAfter(this.element,e)},n.prototype.generate=function(){var e={handle:{type:"span",selector:"range-handle"},min:{type:"span",selector:"range-min"},max:{type:"span",selector:"range-max"},quantity:{type:"span",selector:"range-quantity"}};for(var t in e)if(e.hasOwnProperty(t)){var s=this.create(e[t].type,e[t].selector);this.slider.appendChild(s)}return this.slider},n.prototype.create=function(e,t){var s=document.createElement(e);return s.className=t,s},n.prototype.insertAfter=function(e,t){e.parentNode.insertBefore(t,e.nextSibling)},n.prototype.extraClass=function(e){this.options.klass&&a(this.slider).add(e)},n.prototype.setRange=function(e,t){"number"!=typeof e||"number"!=typeof t||this.options.hideRange||(this.slider.querySelector(".range-min").innerHTML=e,this.slider.querySelector(".range-max").innerHTML=t)},n.prototype.setValue=function(e,t){var s=l.from(parseFloat(e),t),n=l.of(s,this.options.max-this.options.min)+this.options.min,i=!1;n=this.options.decimal?Math.round(100*n)/100:Math.round(n),i=this.element.value!=n?!0:!1,this.element.value=n,this.options.callback(),i&&this.changeEvent()},n.prototype.step=function(e,t){var s=e-t,n=l.from(this.checkStep(this.options.step),this.options.max-this.options.min),o=l.of(n,s),r=[];for(i=0;s>=i;i+=o)r.push(i);return this.steps=r,this.steps},n.prototype.checkValues=function(e){this.options.min>e&&(this.options.start=this.options.min),e>this.options.max&&(this.options.start=this.options.max),this.options.min>=this.options.max&&(this.options.min=this.options.max)},n.prototype.checkStep=function(e){return 0>e&&(e=Math.abs(e)),this.options.step=e,this.options.step},n.prototype.disable=function(){(this.options.min==this.options.max||this.options.min>this.options.max||this.options.disable)&&(this.mouse.unbind(),this.touch.unbind(),this.slider.style.opacity=this.options.disableOpacity,a(this.handle).add("range-disabled"))},n.prototype.unselectable=function(e,t){a(this.slider).has("unselectable")||t!==!0?a(this.slider).remove("unselectable"):a(this.slider).add("unselectable")},n.prototype.changeEvent=function(){if("function"!=typeof Event&&document.fireEvent)this.element.fireEvent("onchange");else{var e=document.createEvent("HTMLEvents");e.initEvent("change",!1,!0),this.element.dispatchEvent(e)}},n.prototype.init=function(){this.hide(),this.append(),this.bindEvents(),this.extraClass(this.options.klass),this.checkValues(this.options.start),this.setRange(this.options.min,this.options.max),this.disable()}}),e.register("powerange/lib/horizontal.js",function(e,t,s){function n(){a.apply(this,arguments),this.options.step&&this.step(this.slider.offsetWidth,this.handle.offsetWidth),this.setStart(this.options.start)}var i=t("super"),o=t("closest-num"),r=t("percentage-calc"),a=t("./main");s.exports=n,i(n,a),n.prototype.setStart=function(e){var t=null===e?this.options.min:e,s=r.from(t-this.options.min,this.options.max-this.options.min)||0,n=r.of(s,this.slider.offsetWidth-this.handle.offsetWidth),i=this.options.step?o.find(n,this.steps):n;this.setPosition(i),this.setValue(this.handle.style.left,this.slider.offsetWidth-this.handle.offsetWidth)},n.prototype.setPosition=function(e){this.handle.style.left=e+"px",this.slider.querySelector(".range-quantity").style.width=e+"px"},n.prototype.onmousedown=function(e){e.touches&&(e=e.touches[0]),this.startX=e.clientX,this.handleOffsetX=this.handle.offsetLeft,this.restrictHandleX=this.slider.offsetWidth-this.handle.offsetWidth,this.unselectable(this.slider,!0)},n.prototype.onmousemove=function(e){e.preventDefault(),e.touches&&(e=e.touches[0]);var t=this.handleOffsetX+e.clientX-this.startX,s=this.steps?o.find(t,this.steps):t;0>=t?this.setPosition(0):t>=this.restrictHandleX?this.setPosition(this.restrictHandleX):this.setPosition(s),this.setValue(this.handle.style.left,this.slider.offsetWidth-this.handle.offsetWidth)},n.prototype.onmouseup=function(){this.unselectable(this.slider,!1)}}),e.register("powerange/lib/vertical.js",function(e,t,s){function n(){l.apply(this,arguments),o(this.slider).add("vertical"),this.options.step&&this.step(this.slider.offsetHeight,this.handle.offsetHeight),this.setStart(this.options.start)}var i=t("super"),o=t("classes"),r=t("closest-num"),a=t("percentage-calc"),l=t("./main");s.exports=n,i(n,l),n.prototype.setStart=function(e){var t=null===e?this.options.min:e,s=a.from(t-this.options.min,this.options.max-this.options.min)||0,n=a.of(s,this.slider.offsetHeight-this.handle.offsetHeight),i=this.options.step?r.find(n,this.steps):n;this.setPosition(i),this.setValue(this.handle.style.bottom,this.slider.offsetHeight-this.handle.offsetHeight)},n.prototype.setPosition=function(e){this.handle.style.bottom=e+"px",this.slider.querySelector(".range-quantity").style.height=e+"px"},n.prototype.onmousedown=function(e){e.touches&&(e=e.touches[0]),this.startY=e.clientY,this.handleOffsetY=this.slider.offsetHeight-this.handle.offsetHeight-this.handle.offsetTop,this.restrictHandleY=this.slider.offsetHeight-this.handle.offsetHeight,this.unselectable(this.slider,!0)},n.prototype.onmousemove=function(e){e.preventDefault(),e.touches&&(e=e.touches[0]);var t=this.handleOffsetY+this.startY-e.clientY,s=this.steps?r.find(t,this.steps):t;0>=t?this.setPosition(0):t>=this.restrictHandleY?this.setPosition(this.restrictHandleY):this.setPosition(s),this.setValue(this.handle.style.bottom,this.slider.offsetHeight-this.handle.offsetHeight)},n.prototype.onmouseup=function(){this.unselectable(this.slider,!1)}}),e.alias("component-events/index.js","powerange/deps/events/index.js"),e.alias("component-events/index.js","events/index.js"),e.alias("component-event/index.js","component-events/deps/event/index.js"),e.alias("component-delegate/index.js","component-events/deps/delegate/index.js"),e.alias("discore-closest/index.js","component-delegate/deps/closest/index.js"),e.alias("discore-closest/index.js","component-delegate/deps/closest/index.js"),e.alias("component-matches-selector/index.js","discore-closest/deps/matches-selector/index.js"),e.alias("component-query/index.js","component-matches-selector/deps/query/index.js"),e.alias("discore-closest/index.js","discore-closest/index.js"),e.alias("component-event/index.js","component-delegate/deps/event/index.js"),e.alias("component-classes/index.js","powerange/deps/classes/index.js"),e.alias("component-classes/index.js","classes/index.js"),e.alias("component-indexof/index.js","component-classes/deps/indexof/index.js"),e.alias("ui-component-mouse/index.js","powerange/deps/mouse/index.js"),e.alias("ui-component-mouse/index.js","mouse/index.js"),e.alias("component-emitter/index.js","ui-component-mouse/deps/emitter/index.js"),e.alias("component-event/index.js","ui-component-mouse/deps/event/index.js"),e.alias("abpetkov-percentage-calc/percentage-calc.js","powerange/deps/percentage-calc/percentage-calc.js"),e.alias("abpetkov-percentage-calc/percentage-calc.js","powerange/deps/percentage-calc/index.js"),e.alias("abpetkov-percentage-calc/percentage-calc.js","percentage-calc/index.js"),e.alias("abpetkov-percentage-calc/percentage-calc.js","abpetkov-percentage-calc/index.js"),e.alias("abpetkov-closest-num/closest-num.js","powerange/deps/closest-num/closest-num.js"),e.alias("abpetkov-closest-num/closest-num.js","powerange/deps/closest-num/index.js"),e.alias("abpetkov-closest-num/closest-num.js","closest-num/index.js"),e.alias("abpetkov-closest-num/closest-num.js","abpetkov-closest-num/index.js"),e.alias("vesln-super/lib/super.js","powerange/deps/super/lib/super.js"),e.alias("vesln-super/lib/super.js","powerange/deps/super/index.js"),e.alias("vesln-super/lib/super.js","super/index.js"),e.alias("vesln-super/lib/super.js","vesln-super/index.js"),e.alias("powerange/lib/powerange.js","powerange/index.js"),"object"==typeof exports?module.exports=e("powerange"):"function"==typeof define&&define.amd?define([],function(){return e("powerange")}):this.Powerange=e("powerange")})();

$(document).ready(function(){
    $('.bootstrap .prestahope_items > tbody  tr  td.dragHandle').wrapInner('<div class="positions"/>');
    $('.bootstrap .prestahope_items > tbody  tr  td.dragHandle').wrapInner('<div class="dragGroup"/>');
    initAjaxTabs();
    if (document.querySelector("#module_form")) {
        let thisPageToChange = document.querySelector("#module_form").classList.contains('prestahope_items');
        if(thisPageToChange)
        {
            // Power ranger for Mobile

            // Speed Power ranger : Mobile
            let DefaultValue_Speed_M = document.querySelector('#speed_M').value;
            var Speed_M = document.querySelector('#speed_M');
            var init = new Powerange(Speed_M ,{start:DefaultValue_Speed_M,max:15,min:1});
            var changeInputSpeed_M = document.querySelector('#speed_M');
            document.querySelectorAll('.range-max')[0].innerHTML = changeInputSpeed_M.value +"s";
            changeInputSpeed_M.onchange = function() {
                document.querySelector('#speed_M').value = changeInputSpeed_M.value ;
                document.querySelectorAll('.range-max')[0].innerHTML = changeInputSpeed_M.value +"s";
            };

            //delay if nav
            let DefaultValue_delay_M = document.querySelector('#delay_M').value;
            var Delay_M = document.querySelector('#delay_M');
            var init = new Powerange(Delay_M ,{start:DefaultValue_delay_M,max:15,min:1});
            var changeInputDelay_M = document.querySelector('#delay_M');
            document.querySelectorAll('.range-max')[1].innerHTML = changeInputDelay_M.value +"s";
            changeInputDelay_M.onchange = function() {
                document.querySelector('#delay_M').value = changeInputDelay_M.value ;
                document.querySelectorAll('.range-max')[1].innerHTML = changeInputDelay_M.value +"s";
            };

            // Speed Power ranger : Mobile
            let DefaultValue_nbrProducts_M = document.querySelector('#nbr_product_M').value;
            var nbr_Products_M = document.querySelector('#nbr_product_M');
            var init = new Powerange(nbr_Products_M ,{start:DefaultValue_nbrProducts_M,max:20,min:1});    
            var changeInputnbrProducts_M = document.querySelector('#nbr_product_M');
            document.querySelectorAll('.range-max')[2].innerHTML = changeInputnbrProducts_M.value ;
            changeInputnbrProducts_M.onchange = function() {
                document.querySelector('#nbr_product_M').value = changeInputnbrProducts_M.value ;
                document.querySelectorAll('.range-max')[2].innerHTML = changeInputnbrProducts_M.value;
            };

            let DefaultValue_size_M = document.querySelector('#size_M').value;
            var nbrDesplayedProdcuts = document.querySelector('#size_M');
            var init = new Powerange (nbrDesplayedProdcuts ,{start:DefaultValue_size_M,min:1,max:2});        
            var changeInputSize_M = document.querySelector('#size_M');
            document.querySelectorAll('.range-max')[3].innerHTML = changeInputSize_M.value ;
            changeInputSize_M.onchange = function() {
                document.querySelector('#size_M').value = changeInputSize_M.value ;
                document.querySelectorAll('.range-max')[3].innerHTML = changeInputSize_M.value;
            };

            // Power ranger : Tabletten

            // Speed Power ranger      
            let DefaultValue_Speed_T = document.querySelector('#speed_T').value;
            var Speed_T = document.querySelector('#speed_T');
            var init = new Powerange(Speed_T ,{start:DefaultValue_Speed_T,max:15,min:1});
            var changeInputSpeed_T = document.querySelector('#speed_T');
            document.querySelectorAll('.range-max')[4].innerHTML = changeInputSpeed_T.value +"s";
            changeInputSpeed_T.onchange = function() {
                document.querySelector('#speed_T').value = changeInputSpeed_T.value ;
                document.querySelectorAll('.range-max')[4].innerHTML = changeInputSpeed_T.value +"s";
            };
            
            // nbrProduct Power ranger 
            let DefaultValue_nbrProducts_T = document.querySelector('#nbr_product_T').value;
            var nbr_Products_T = document.querySelector('#nbr_product_T');
            var init = new Powerange(nbr_Products_T ,{start:DefaultValue_nbrProducts_T,max:20,min:1});    
            var changeInputnbrProducts_T = document.querySelector('#nbr_product_T');
            document.querySelectorAll('.range-max')[5].innerHTML = changeInputnbrProducts_T.value ;
            changeInputnbrProducts_T.onchange = function() {
                document.querySelector('#nbr_product_T').value = changeInputnbrProducts_T.value ;
                document.querySelectorAll('.range-max')[5].innerHTML = changeInputnbrProducts_T.value;
            };

            let DefaultValue_delay_T = document.querySelector('#delay_T').value;
            var Delay_T = document.querySelector('#delay_T');
            var init = new Powerange(Delay_T ,{start:DefaultValue_delay_T,max:15,min:1});
            var changeInputDelay_T = document.querySelector('#delay_T');
            document.querySelectorAll('.range-max')[6].innerHTML = changeInputDelay_T.value +"s";
            changeInputDelay_T.onchange = function() {
                document.querySelector('#delay_T').value = changeInputDelay_T.value ;
                document.querySelectorAll('.range-max')[6].innerHTML = changeInputDelay_T.value +"s";
            };

            // Size Power ranger 
            let DefaultValue_size_T = document.querySelector('#size_T').value;
            var size_tamplete_T = document.querySelector('#size_T');
            var init = new Powerange (size_tamplete_T ,{start:DefaultValue_size_T,min:2,max:6});    
            var changeInputSize_T = document.querySelector('#size_T');
            document.querySelectorAll('.range-max')[7].innerHTML = changeInputSize_T.value ;
            changeInputSize_T.onchange = function() {
                document.querySelector('#size_T').value = changeInputSize_T.value ;
                document.querySelectorAll('.range-max')[7].innerHTML = changeInputSize_T.value;
            };

            // Power ranger : Desktop
            // Speed Power ranger : Disktop
            let DefaultValue_Speed = document.querySelector('#speed_C').value;
            var Speed = document.querySelector('#speed_C');
            var init = new Powerange(Speed ,{start:DefaultValue_Speed,max:15,min:1});
            var changeInputSpeed = document.querySelector('#speed_C');
            document.querySelectorAll('.range-max')[8].innerHTML = changeInputSpeed.value +"s";
            changeInputSpeed.onchange = function() {
                document.querySelector('#speed_C').value = changeInputSpeed.value ;
                document.querySelectorAll('.range-max')[8].innerHTML = changeInputSpeed.value +"s";
            };

            // nbr Product Power ranger : Disktop
            let DefaultValue_nbrProducts_C = document.querySelector('#nbr_product_C').value;
            var nbr_Products_C = document.querySelector('#nbr_product_C');
            var init = new Powerange(nbr_Products_C ,{start:DefaultValue_nbrProducts_C,max:20,min:1});    
            var changeInputnbrProducts_C = document.querySelector('#nbr_product_C');
            document.querySelectorAll('.range-max')[9].innerHTML = changeInputnbrProducts_C.value ;
            changeInputnbrProducts_C.onchange = function() {
                document.querySelector('#nbr_product_C').value = changeInputnbrProducts_C.value ;
                document.querySelectorAll('.range-max')[9].innerHTML = changeInputnbrProducts_C.value;
            };

            let DefaultValue_delay_C = document.querySelector('#delay_C').value;
            var Delay_C = document.querySelector('#delay_C');
            var init = new Powerange(Delay_C ,{start:DefaultValue_delay_C,max:15,min:1});
            var changeInputDelay_C = document.querySelector('#delay_C');
            document.querySelectorAll('.range-max')[10].innerHTML = changeInputDelay_C.value +"s";
            changeInputDelay_C.onchange = function() {
                document.querySelector('#delay_C').value = changeInputDelay_C.value ;
                document.querySelectorAll('.range-max')[10].innerHTML = changeInputDelay_C.value +"s";
            };
            
            // Size
            let DefaultValue_size_C = document.querySelector('#size_C').value;
            var size_tamplete_C = document.querySelector('#size_C');
            var init = new Powerange (size_tamplete_C ,{start:DefaultValue_size_C,min:2,max:8});        
            var changeInputSize_C = document.querySelector('#size_C');
            document.querySelectorAll('.range-max')[11].innerHTML = changeInputSize_C.value ;
            changeInputSize_C.onchange = function() {
                document.querySelector('#size_C').value = changeInputSize_C.value ;
                document.querySelectorAll('.range-max')[11].innerHTML = changeInputSize_C.value;
            };
            
           // Create the HTML code to insert
            let ListItems = document.querySelectorAll("#module_form.prestahope_items .form-wrapper > .form-group");

            let newHtmlCode = `
            <div id="Choose_Devise">		
                <div class="card p-1">
                        <div class="btn-group btn-group-sm">
                                        <button type="button" id="Mobile" class="btn-Normale">
                                                         <svg fill="#ffff" height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                                            viewBox="0 0 27.442 27.442" xml:space="preserve">
                                                        <g>
                                                            <path d="M19.494,0H7.948C6.843,0,5.951,0.896,5.951,1.999v23.446c0,1.102,0.892,1.997,1.997,1.997h11.546
                                                                c1.103,0,1.997-0.895,1.997-1.997V1.999C21.491,0.896,20.597,0,19.494,0z M10.872,1.214h5.7c0.144,0,0.261,0.215,0.261,0.481
                                                                s-0.117,0.482-0.261,0.482h-5.7c-0.145,0-0.26-0.216-0.26-0.482C10.612,1.429,10.727,1.214,10.872,1.214z M13.722,25.469
                                                                c-0.703,0-1.275-0.572-1.275-1.276s0.572-1.274,1.275-1.274c0.701,0,1.273,0.57,1.273,1.274S14.423,25.469,13.722,25.469z
                                                                M19.995,21.1H7.448V3.373h12.547V21.1z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                                                        </g>
                                                        </svg>
                                                        <h5>Mobile</h5>
                                        </button>
                                        <button type="button" id="Tablette" class="btn-Normale">
                                                <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                                    width="25px" height="25px" viewBox="0 0 24.000000 24.000000"
                                                    preserveAspectRatio="xMidYMid meet">
                                                
                                                <g transform="translate(0.000000,24.000000) scale(0.100000,-0.100000)"
                                                fill="#ffff" stroke="none">
                                                <path d="M26 224 c-8 -20 -8 -188 0 -208 9 -23 179 -23 188 0 8 20 8 188 0
                                                208 -9 23 -179 23 -188 0z m174 -94 l0 -90 -80 0 -80 0 0 90 0 90 80 0 80 0 0
                                                -90z m-70 -110 c0 -5 -4 -10 -10 -10 -5 0 -10 5 -10 10 0 6 5 10 10 10 6 0 10
                                                -4 10 -10z"/>
                                                </g>
                                                </svg> 
                                                <h5>Tablette</h5>
                                        </button>
                                        <button type="button" id="Computer" class="btn-Normale Active">
                                            <svg height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                                viewBox="0 0 34.418 34.418" xml:space="preserve">
                                            <g>
                                                <path style="fill:#ffff;" d="M32.335,11.606h-6.533v-1.009h6.533V11.606z M32.335,12.264h-6.533v1.011h6.533V12.264z
                                                    M32.331,7.687h-6.523V9.91h6.523V7.687z M34.418,5.297v23.827c-0.001,0.357-0.292,0.648-0.65,0.648h-9.397
                                                    c-0.359,0-0.649-0.291-0.649-0.649V5.297c0-0.358,0.29-0.65,0.649-0.65h9.397C34.127,4.647,34.418,4.939,34.418,5.297z
                                                    M33.119,5.944h-8.1v22.53h8.1V5.944z M32.335,13.932h-6.533v1.008h6.533V13.932z M31.272,21.45c0,1.162-0.939,2.099-2.097,2.099
                                                    c-1.16,0-2.099-0.938-2.099-2.099c0-1.158,0.94-2.098,2.099-2.098C30.333,19.352,31.272,20.293,31.272,21.45z M30.515,21.45
                                                    c0-0.739-0.6-1.341-1.341-1.341c-0.742,0-1.342,0.601-1.342,1.341s0.6,1.34,1.342,1.34C29.915,22.79,30.515,22.19,30.515,21.45z
                                                    M21.937,9.218v13.505c0,0.814-0.655,1.473-1.461,1.473H13.18c0,0-0.414,2.948,2.212,2.948v1.475H13.18H8.758H6.546v-1.473
                                                    c2.529,0,2.212-2.948,2.212-2.948H1.465C0.656,24.198,0,23.539,0,22.725V9.218c0-0.814,0.656-1.47,1.465-1.47h19.01
                                                    C21.282,7.748,21.937,8.404,21.937,9.218z M12.332,22.394c0-0.698-0.566-1.263-1.264-1.263c-0.699,0-1.266,0.565-1.266,1.263
                                                    s0.566,1.265,1.266,1.265C11.767,23.659,12.332,23.092,12.332,22.394z M20.371,9.311H1.568v11.387H20.37h0.001
                                                    C20.371,20.698,20.371,9.311,20.371,9.311z M11.081,21.603c-0.434,0-0.785,0.352-0.785,0.785s0.352,0.785,0.785,0.785
                                                    s0.785-0.352,0.785-0.785S11.515,21.603,11.081,21.603z"/>
                                            </g>
                                            </svg>
                                            <h5>Desktop</h5>
                                        </button>
                            </div>
                </div>			
            </div>` ;

            // Insert the new HTML code before the first item in ListItems
            ListItems[0].insertAdjacentHTML('beforebegin', newHtmlCode);

            // function to switch between Tabs Mobile / Desktop / Tablette
            function ChooseTab(Devise)
            {
                const mobileItems = document.querySelectorAll('.mobile_items');
                const tableteitems = document.querySelectorAll('.tablete_items');
                const computeritems = document.querySelectorAll('.computer_items');

                const Mobilebtn = document.querySelector('#Choose_Devise #Mobile');
                const Tableteebtn = document.querySelector('#Choose_Devise #Tablette');
                const Desktopbtn = document.querySelector('#Choose_Devise #Computer');

                if (Devise === "mobile") {
                    mobileItems.forEach(item => {
                      item.style.display = 'block';
                    });
                    tableteitems.forEach(item => {
                        item.style.display = 'none';
                      });
                    computeritems.forEach(item => {
                        item.style.display = 'none';
                      });

                    Mobilebtn.classList.add("Active");
                    Tableteebtn.classList.remove("Active");
                    Desktopbtn.classList.remove("Active");

                 }else if (Devise === "Tablette")
                 {
                    mobileItems.forEach(item => {
                      item.style.display = 'none';
                    });
                    tableteitems.forEach(item => {
                        item.style.display = 'block';
                      });
                    computeritems.forEach(item => {
                        item.style.display = 'none';
                      });

                    Mobilebtn.classList.remove("Active");
                    Tableteebtn.classList.add("Active");
                    Desktopbtn.classList.remove("Active");
                 }else if(Devise === "Computer")
                 {
                    mobileItems.forEach(item => {
                      item.style.display = 'none';
                    });
                    tableteitems.forEach(item => {
                        item.style.display = 'none';
                      });
                    computeritems.forEach(item => {
                        item.style.display = 'block';
                      });
                    Mobilebtn.classList.remove("Active");
                    Tableteebtn.classList.remove("Active");
                    Desktopbtn.classList.add("Active");  
                 }
            }
            
            ChooseTab("Computer");
            // Divide the NodeList into three equal parts
            let firstTenItems = Array.from(ListItems).slice(0, 13);
            let secondTenItems = Array.from(ListItems).slice(13, 26);
            let thirdTenItems = Array.from(ListItems).slice(26, 39);

            firstTenItems.forEach(function(item) {
                item.classList.add('mobile_items');
            });

            secondTenItems.forEach(function(item) {
            item.classList.add('tablete_items');
            });

            thirdTenItems.forEach(function(item) {
            item.classList.add('computer_items');
            });
            ChooseTab("Computer");
            const mobileButton = document.querySelector('#Choose_Devise #Mobile');
            const tableButton = document.querySelector('#Choose_Devise #Tablette');
            const computerItemsButton = document.querySelector('#Choose_Devise #Computer');

            mobileButton.addEventListener('click', function() {
                ChooseTab("mobile");
            });

            tableButton.addEventListener('click', function() {
                ChooseTab("Tablette");
            });

            computerItemsButton.addEventListener('click', function() {
                ChooseTab("Computer");
            });
        }
    }
});

function initAjaxTabs(){
    $('.prestahope_items > tbody tr').each(function(){
        var id = $(this).find('td:first').text();
        $(this).attr('id', 'item_'+id.trim());
    });
    var $tabslides = $('.prestahope_items > tbody');
    $tabslides.sortable({
        cursor: 'move',
        items: '> tr',
        update: function(event, ui){
            $('.prestahope_items > tbody > tr').each(function(index){
                $(this).find('.positions').text(index + 1);
            });
        }
    }).bind('sortupdate', function() {
        var orders = $(this).sortable('toArray');
        $.ajax({
            type: 'POST',
            url: ajax_theme_url + '&ajax',
            headers: { "cache-control": "no-cache" },
            dataType: 'json',
            data: {
                action: 'updatepositionform',
                item: orders,
            },
            success: function(msg){
                if (msg.error) {
                    showErrorMessage(msg.error);
                    return;
                }
                showSuccessMessage(msg.success);
            }
        });
    });
};
