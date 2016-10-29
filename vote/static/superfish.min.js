/*
 * jQuery Superfish Menu Plugin - v1.7.4
 * Copyright (c) 2013 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 *	http://www.opensource.org/licenses/mit-license.php
 *	http://www.gnu.org/licenses/gpl.html
 */

;(function(e){"use strict";var s=function(){var s={bcClass:"sf-breadcrumb",menuClass:"sf-js-enabled",anchorClass:"sf-with-ul",menuArrowClass:"sf-arrows"},o=function(){var s=/iPhone|iPad|iPod/i.test(navigator.userAgent);return s&&e(window).load(function(){e("body").children().on("click",e.noop)}),s}(),n=function(){var e=document.documentElement.style;return"behavior"in e&&"fill"in e&&/iemobile/i.test(navigator.userAgent)}(),t=function(e,o){var n=s.menuClass;o.cssArrows&&(n+=" "+s.menuArrowClass),e.toggleClass(n)},i=function(o,n){return o.find("li."+n.pathClass).slice(0,n.pathLevels).addClass(n.hoverClass+" "+s.bcClass).filter(function(){return e(this).children(n.popUpSelector).hide().show().length}).removeClass(n.pathClass)},r=function(e){e.children("a").toggleClass(s.anchorClass)},a=function(e){var s=e.css("ms-touch-action");s="pan-y"===s?"auto":"pan-y",e.css("ms-touch-action",s)},l=function(s,t){var i="li:has("+t.popUpSelector+")";e.fn.hoverIntent&&!t.disableHI?s.hoverIntent(u,p,i):s.on("mouseenter.superfish",i,u).on("mouseleave.superfish",i,p);var r="MSPointerDown.superfish";o||(r+=" touchend.superfish"),n&&(r+=" mousedown.superfish"),s.on("focusin.superfish","li",u).on("focusout.superfish","li",p).on(r,"a",t,h)},h=function(s){var o=e(this),n=o.siblings(s.data.popUpSelector);n.length>0&&n.is(":hidden")&&(o.one("click.superfish",!1),"MSPointerDown"===s.type?o.trigger("focus"):e.proxy(u,o.parent("li"))())},u=function(){var s=e(this),o=d(s);clearTimeout(o.sfTimer),s.siblings().superfish("hide").end().superfish("show")},p=function(){var s=e(this),n=d(s);o?e.proxy(f,s,n)():(clearTimeout(n.sfTimer),n.sfTimer=setTimeout(e.proxy(f,s,n),n.delay))},f=function(s){s.retainPath=e.inArray(this[0],s.$path)>-1,this.superfish("hide"),this.parents("."+s.hoverClass).length||(s.onIdle.call(c(this)),s.$path.length&&e.proxy(u,s.$path)())},c=function(e){return e.closest("."+s.menuClass)},d=function(e){return c(e).data("sf-options")};return{hide:function(s){if(this.length){var o=this,n=d(o);if(!n)return this;var t=n.retainPath===!0?n.$path:"",i=o.find("li."+n.hoverClass).add(this).not(t).removeClass(n.hoverClass).children(n.popUpSelector),r=n.speedOut;s&&(i.show(),r=0),n.retainPath=!1,n.onBeforeHide.call(i),i.stop(!0,!0).animate(n.animationOut,r,function(){var s=e(this);n.onHide.call(s)})}return this},show:function(){var e=d(this);if(!e)return this;var s=this.addClass(e.hoverClass),o=s.children(e.popUpSelector);return e.onBeforeShow.call(o),o.stop(!0,!0).animate(e.animation,e.speed,function(){e.onShow.call(o)}),this},destroy:function(){return this.each(function(){var o,n=e(this),i=n.data("sf-options");return i?(o=n.find(i.popUpSelector).parent("li"),clearTimeout(i.sfTimer),t(n,i),r(o),a(n),n.off(".superfish").off(".hoverIntent"),o.children(i.popUpSelector).attr("style",function(e,s){return s.replace(/display[^;]+;?/g,"")}),i.$path.removeClass(i.hoverClass+" "+s.bcClass).addClass(i.pathClass),n.find("."+i.hoverClass).removeClass(i.hoverClass),i.onDestroy.call(n),n.removeData("sf-options"),void 0):!1})},init:function(o){return this.each(function(){var n=e(this);if(n.data("sf-options"))return!1;var h=e.extend({},e.fn.superfish.defaults,o),u=n.find(h.popUpSelector).parent("li");h.$path=i(n,h),n.data("sf-options",h),t(n,h),r(u),a(n),l(n,h),u.not("."+s.bcClass).superfish("hide",!0),h.onInit.call(this)})}}}();e.fn.superfish=function(o){return s[o]?s[o].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof o&&o?e.error("Method "+o+" does not exist on jQuery.fn.superfish"):s.init.apply(this,arguments)},e.fn.superfish.defaults={popUpSelector:"ul,.sf-mega",hoverClass:"sfHover",pathClass:"overrideThisToUse",pathLevels:1,delay:800,animation:{opacity:"show"},animationOut:{opacity:"hide"},speed:"normal",speedOut:"fast",cssArrows:!0,disableHI:!1,onInit:e.noop,onBeforeShow:e.noop,onShow:e.noop,onBeforeHide:e.noop,onHide:e.noop,onIdle:e.noop,onDestroy:e.noop},e.fn.extend({hideSuperfishUl:s.hide,showSuperfishUl:s.show})})(jQuery);

/**
 * jQuery Mobile Menu 
 * Turn unordered list menu into dropdown select menu
 * version 1.0(31-OCT-2011)
 * 
 * Built on top of the jQuery library
 *   http://jquery.com
 * 
 * Documentation
 * 	 http://github.com/mambows/mobilemenu
 */

;(function(e){e.fn.mobileMenu=function(t){var n={defaultText:"Navigate to...",className:"select-menu",subMenuClass:"sub-menu",subMenuDash:"&ndash;"},r=e.extend(n,t),i=e(this);this.each(function(){i.find("ul").addClass(r.subMenuClass);e("<select />",{"class":r.className,id:"menu-"+i.attr("id")}).insertAfter(i);e("<option />",{value:"#",text:r.defaultText}).appendTo("#menu-"+i.attr("id"));i.find("a, .separator").each(function(){var t=e(this),n=""+t.text(),s=t.parents("."+r.subMenuClass),o=s.length,u;if(t.parents("ul").hasClass(r.subMenuClass)){u=Array(o+1).join(r.subMenuDash);n=u+n}if(!t.hasClass("separator")){e("<option />",{value:this.href,html:n,selected:this.href==window.location.href}).appendTo("#menu-"+i.attr("id"))}else{e("<option />",{value:"#",html:n}).appendTo("#menu-"+i.attr("id"))}});e("."+r.className).change(function(){var t=e(this).val();if(t!=="#"){window.location.href=e(this).val()}})});return this}})(jQuery)

/**
 * hoverIntent is similar to jQuery's built-in "hover" method except that
 * instead of firing the handlerIn function immediately, hoverIntent checks
 * to see if the user's mouse has slowed down (beneath the sensitivity
 * threshold) before firing the event. The handlerOut function is only
 * called after a matching handlerIn.
 *
 * hoverIntent r7 // 2013.03.11 // jQuery 1.9.1+
 * http://cherne.net/brian/resources/jquery.hoverIntent.html
 *
 * You may use hoverIntent under the terms of the MIT license. Basically that
 * means you are free to use hoverIntent as long as this header is left intact.
 * Copyright 2007, 2013 Brian Cherne
 *
 * // basic usage ... just like .hover()
 * .hoverIntent( handlerIn, handlerOut )
 * .hoverIntent( handlerInOut )
 *
 * // basic usage ... with event delegation!
 * .hoverIntent( handlerIn, handlerOut, selector )
 * .hoverIntent( handlerInOut, selector )
 *
 * // using a basic configuration object
 * .hoverIntent( config )
 *
 * @param  handlerIn   function OR configuration object
 * @param  handlerOut  function OR selector for delegation OR undefined
 * @param  selector    selector OR undefined
 * @author Brian Cherne <brian(at)cherne(dot)net>
 **/

;(function(e){e.fn.hoverIntent=function(t,n,r){var i={interval:100,sensitivity:7,timeout:0};if(typeof t==="object"){i=e.extend(i,t)}else if(e.isFunction(n)){i=e.extend(i,{over:t,out:n,selector:r})}else{i=e.extend(i,{over:t,out:t,selector:n})}var s,o,u,a;var f=function(e){s=e.pageX;o=e.pageY};var l=function(t,n){n.hoverIntent_t=clearTimeout(n.hoverIntent_t);if(Math.abs(u-s)+Math.abs(a-o)<i.sensitivity){e(n).off("mousemove.hoverIntent",f);n.hoverIntent_s=1;return i.over.apply(n,[t])}else{u=s;a=o;n.hoverIntent_t=setTimeout(function(){l(t,n)},i.interval)}};var c=function(e,t){t.hoverIntent_t=clearTimeout(t.hoverIntent_t);t.hoverIntent_s=0;return i.out.apply(t,[e])};var h=function(t){var n=jQuery.extend({},t);var r=this;if(r.hoverIntent_t){r.hoverIntent_t=clearTimeout(r.hoverIntent_t)}if(t.type=="mouseenter"){u=n.pageX;a=n.pageY;e(r).on("mousemove.hoverIntent",f);if(r.hoverIntent_s!=1){r.hoverIntent_t=setTimeout(function(){l(n,r)},i.interval)}}else{e(r).off("mousemove.hoverIntent",f);if(r.hoverIntent_s==1){r.hoverIntent_t=setTimeout(function(){c(n,r)},i.timeout)}}};return this.on({"mouseenter.hoverIntent":h,"mouseleave.hoverIntent":h},i.selector)}})(jQuery)

/*
 * Supersubs v0.3b - jQuery plugin
 * Copyright (c) 2013 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 *
 * This plugin automatically adjusts submenu widths of suckerfish-style menus to that of
 * their longest list item children. If you use this, please expect bugs and report them
 * to the jQuery Google Group with the word 'Superfish' in the subject line.
 *
 */

;(function(e){e.fn.supersubs=function(t){var n=e.extend({},e.fn.supersubs.defaults,t);return this.each(function(){var t=e(this);var r=e.meta?e.extend({},n,t.data()):n;$ULs=t.find("ul").show();var i=e('<li id="menu-fontsize">&#8212;</li>').css({padding:0,position:"absolute",top:"-999em",width:"auto"}).appendTo(t)[0].clientWidth;e("#menu-fontsize").remove();$ULs.each(function(t){var n=e(this);var s=n.children();var u=s.children("a");var a=s.css("white-space","nowrap").css("float");n.add(s).add(u).css({"float":"none",width:"auto"});var f=n[0].clientWidth/i;f+=r.extraWidth;if(f>r.maxWidth){f=r.maxWidth}else if(f<r.minWidth){f=r.minWidth}f+="em";n.css("width",f);s.css({"float":a,width:"100%","white-space":"normal"}).each(function(){var t=e(this).children("ul");var n=t.css("left")!==undefined?"left":"right";t.css(n,"100%")})}).hide()})};e.fn.supersubs.defaults={minWidth:9,maxWidth:25,extraWidth:0}})(jQuery)

/*
 * sf-Touchscreen v1.0b - Provides touchscreen compatibility for the jQuery Superfish plugin. - LAST UPDATE: MARCH 23rd, 2011
 *
 * Developer's notes:
 * Built as a part of the Superfish project for Drupal (http://drupal.org/project/superfish) 
 * Found any bug? have any cool ideas? contact me right away! http://drupal.org/user/619294/contact
 *
 * jQuery version: 1.3.x or higher.
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
*/

;(function(e){e.fn.sftouchscreen=function(){return this.each(function(){e(this).find("li > ul").closest("li").children("a").each(function(){var t=e(this);t.click(function(e){if(t.hasClass("sf-clicked")){var n=t.attr("href");window.location=n}else{e.preventDefault();t.addClass("sf-clicked")}}).closest("li").mouseleave(function(){t.removeClass("sf-clicked")})})})}})(jQuery)

/*
 * ScrollToFixed
 * https://github.com/bigspotteddog/ScrollToFixed
 * 
 * Copyright (c) 2011 Joseph Cava-Lynch
 * MIT license
 */
;(function(e){e.isScrollToFixed=function(t){return!!e(t).data("ScrollToFixed")};e.ScrollToFixed=function(t,n){function m(){s.trigger("preUnfixed.ScrollToFixed");x();s.trigger("unfixed.ScrollToFixed");h=-1;f=s.offset().top;l=s.offset().left;if(r.options.offsets){l+=s.offset().left-s.position().left}if(c==-1){c=l}o=s.css("position");i=true;if(r.options.bottom!=-1){s.trigger("preFixed.ScrollToFixed");E();s.trigger("fixed.ScrollToFixed")}}function g(){var e=r.options.limit;if(!e)return 0;if(typeof e==="function"){return e.apply(s)}return e}function y(){return o==="fixed"}function b(){return o==="absolute"}function w(){return!(y()||b())}function E(){if(!y()){p.css({display:s.css("display"),width:(s.outerWidth(true)*100/s.parent().width()).toFixed(2)-.04+"%",height:s.outerHeight(true),"float":s.css("float")});cssOptions={position:"fixed",top:r.options.bottom==-1?N():"",bottom:r.options.bottom==-1?"":r.options.bottom,"margin-left":"0px"};if(!r.options.dontSetWidth){cssOptions["width"]=s.width()}s.css(cssOptions);s.addClass(r.options.baseClassName);if(r.options.className){s.addClass(r.options.className)}o="fixed"}}function S(){var e=g();var t=l;if(r.options.removeOffsets){t="";e=e-f}cssOptions={position:"absolute",top:e,left:t,"margin-left":"0px",bottom:""};if(!r.options.dontSetWidth){cssOptions["width"]=s.width()}s.css(cssOptions);o="absolute"}function x(){if(!w()){h=-1;p.css("display","none");s.css({width:"",position:u,left:"",top:a,"margin-left":""});s.removeClass("scroll-to-fixed-fixed");if(r.options.className){s.removeClass(r.options.className)}o=null}}function T(e){if(e!=h){s.css("left",l-e);h=e}}function N(){var e=r.options.marginTop;if(!e)return 0;if(typeof e==="function"){return e.apply(s)}return e}function C(){if(!e.isScrollToFixed(s))return;var t=i;if(!i){m()}var n=e(window).scrollLeft();var o=e(window).scrollTop();var a=g();if(r.options.minWidth&&e(window).width()<r.options.minWidth){if(!w()||!t){L();s.trigger("preUnfixed.ScrollToFixed");x();s.trigger("unfixed.ScrollToFixed")}}else if(r.options.maxWidth&&e(window).width()>r.options.maxWidth){if(!w()||!t){L();s.trigger("preUnfixed.ScrollToFixed");x();s.trigger("unfixed.ScrollToFixed")}}else if(r.options.bottom==-1){if(a>0&&o>=a-N()){if(!b()||!t){L();s.trigger("preAbsolute.ScrollToFixed");S();s.trigger("unfixed.ScrollToFixed")}}else if(o>=f-N()){if(!y()||!t){L();s.trigger("preFixed.ScrollToFixed");E();h=-1;s.trigger("fixed.ScrollToFixed")}T(n)}else{if(!w()||!t){L();s.trigger("preUnfixed.ScrollToFixed");x();s.trigger("unfixed.ScrollToFixed")}}}else{if(a>0){if(o+e(window).height()-s.outerHeight(true)>=a-(N()||-k())){if(y()){L();s.trigger("preUnfixed.ScrollToFixed");if(u==="absolute"){S()}else{x()}s.trigger("unfixed.ScrollToFixed")}}else{if(!y()){L();s.trigger("preFixed.ScrollToFixed");E()}T(n);s.trigger("fixed.ScrollToFixed")}}else{T(n)}}}function k(){if(!r.options.bottom)return 0;return r.options.bottom}function L(){var e=s.css("position");if(e=="absolute"){s.trigger("postAbsolute.ScrollToFixed")}else if(e=="fixed"){s.trigger("postFixed.ScrollToFixed")}else{s.trigger("postUnfixed.ScrollToFixed")}}var r=this;r.$el=e(t);r.el=t;r.$el.data("ScrollToFixed",r);var i=false;var s=r.$el;var o;var u;var a;var f=0;var l=0;var c=-1;var h=-1;var p=null;var d;var v;var A=function(e){if(s.is(":visible")){i=false;C()}};var O=function(e){C()};var M=function(){var e=document.body;if(document.createElement&&e&&e.appendChild&&e.removeChild){var t=document.createElement("div");if(!t.getBoundingClientRect)return null;t.innerHTML="x";t.style.cssText="position:fixed;top:100px;";e.appendChild(t);var n=e.style.height,r=e.scrollTop;e.style.height="3000px";e.scrollTop=500;var i=t.getBoundingClientRect().top;e.style.height=n;var s=i===100;e.removeChild(t);e.scrollTop=r;return s}return null};var _=function(e){e=e||window.event;if(e.preventDefault){e.preventDefault()}e.returnValue=false};r.init=function(){r.options=e.extend({},e.ScrollToFixed.defaultOptions,n);r.$el.css("z-index",r.options.zIndex);p=e("<div />");o=s.css("position");u=s.css("position");a=s.css("top");if(w())r.$el.after(p);e(window).bind("resize.ScrollToFixed",A);e(window).bind("scroll.ScrollToFixed",O);if(r.options.preFixed){s.bind("preFixed.ScrollToFixed",r.options.preFixed)}if(r.options.postFixed){s.bind("postFixed.ScrollToFixed",r.options.postFixed)}if(r.options.preUnfixed){s.bind("preUnfixed.ScrollToFixed",r.options.preUnfixed)}if(r.options.postUnfixed){s.bind("postUnfixed.ScrollToFixed",r.options.postUnfixed)}if(r.options.preAbsolute){s.bind("preAbsolute.ScrollToFixed",r.options.preAbsolute)}if(r.options.postAbsolute){s.bind("postAbsolute.ScrollToFixed",r.options.postAbsolute)}if(r.options.fixed){s.bind("fixed.ScrollToFixed",r.options.fixed)}if(r.options.unfixed){s.bind("unfixed.ScrollToFixed",r.options.unfixed)}if(r.options.spacerClass){p.addClass(r.options.spacerClass)}s.bind("resize.ScrollToFixed",function(){p.height(s.height())});s.bind("scroll.ScrollToFixed",function(){s.trigger("preUnfixed.ScrollToFixed");x();s.trigger("unfixed.ScrollToFixed");C()});s.bind("detach.ScrollToFixed",function(t){_(t);s.trigger("preUnfixed.ScrollToFixed");x();s.trigger("unfixed.ScrollToFixed");e(window).unbind("resize.ScrollToFixed",A);e(window).unbind("scroll.ScrollToFixed",O);s.unbind(".ScrollToFixed");p.remove();r.$el.removeData("ScrollToFixed")});A()};r.init()};e.ScrollToFixed.defaultOptions={marginTop:0,limit:0,bottom:-1,zIndex:1e3,baseClassName:"scroll-to-fixed-fixed"};e.fn.scrollToFixed=function(t){return this.each(function(){new e.ScrollToFixed(this,t)})}})(jQuery)