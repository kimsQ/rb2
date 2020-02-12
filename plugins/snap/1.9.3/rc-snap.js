/* =============================================================================================
 * Snap.js
 *
 * Copyright 2013, Jacob Kelley - http://jakiestfu.com/
 * Released under the MIT Licence
 * http://opensource.org/licenses/MIT
 * ==============================================================================================
 * Github:  http://github.com/jakiestfu/Snap.js/
 * Version: 1.9.2
 *===============================================================================================*/

 /*
  * Snap.js
  *
  * Copyright 2013, Jacob Kelley - http://jakiestfu.com/
  * Released under the MIT Licence
  * http://opensource.org/licenses/MIT
  *
  * Github:  http://github.com/jakiestfu/Snap.js/
  * Version: 1.9.3
  */
 /*jslint browser: true*/
 /*global define, module, ender*/
 (function(win, doc) {
     'use strict';
     var Snap = Snap || function(userOpts) {
         var settings = {
             element: null,
             dragger: null,
             disable: 'none',
             addBodyClasses: true,
             hyperextensible: true,
             resistance: 0.5,
             flickThreshold: 50,
             transitionSpeed: 0.3,
             easing: 'ease',
             maxPosition: 266,
             minPosition: -266,
             tapToClose: true,
             touchToDrag: true,
             slideIntent: 40, // degrees
             minDragDistance: 5
         },
         cache = {
             simpleStates: {
                 opening: null,
                 towards: null,
                 hyperExtending: null,
                 halfway: null,
                 flick: null,
                 translation: {
                     absolute: 0,
                     relative: 0,
                     sinceDirectionChange: 0,
                     percentage: 0
                 }
             }
         },
         eventList = {},
         utils = {
             hasTouch: ('ontouchstart' in doc.documentElement || win.navigator.msPointerEnabled),
             eventType: function(action) {
                 var eventTypes = {
                         down: (utils.hasTouch ? 'touchstart' : 'mousedown'),
                         move: (utils.hasTouch ? 'touchmove' : 'mousemove'),
                         up: (utils.hasTouch ? 'touchend' : 'mouseup'),
                         out: (utils.hasTouch ? 'touchcancel' : 'mouseout')
                     };
                 return eventTypes[action];
             },
             page: function(t, e){
                 return (utils.hasTouch && e.touches.length && e.touches[0]) ? e.touches[0]['page'+t] : e['page'+t];
             },
             klass: {
                 has: function(el, name){
                     return (el.className).indexOf(name) !== -1;
                 },
                 add: function(el, name){
                     if(!utils.klass.has(el, name) && settings.addBodyClasses){
                         el.className += " "+name;
                     }
                 },
                 remove: function(el, name){
                     if(settings.addBodyClasses){
                         el.className = (el.className).replace(name, "").replace(/^\s+|\s+$/g, '');
                     }
                 }
             },
             dispatchEvent: function(type) {
                 if (typeof eventList[type] === 'function') {
                     return eventList[type].call();
                 }
             },
             vendor: function(){
                 var tmp = doc.createElement("div"),
                     prefixes = 'webkit Moz O ms'.split(' '),
                     i;
                 for (i in prefixes) {
                     if (typeof tmp.style[prefixes[i] + 'Transition'] !== 'undefined') {
                         return prefixes[i];
                     }
                 }
             },
             transitionCallback: function(){
                 return (cache.vendor==='Moz' || cache.vendor==='ms') ? 'transitionend' : cache.vendor+'TransitionEnd';
             },
             canTransform: function(){
                 return typeof settings.element.style[cache.vendor+'Transform'] !== 'undefined';
             },
             deepExtend: function(destination, source) {
                 var property;
                 for (property in source) {
                     if (source[property] && source[property].constructor && source[property].constructor === Object) {
                         destination[property] = destination[property] || {};
                         utils.deepExtend(destination[property], source[property]);
                     } else {
                         destination[property] = source[property];
                     }
                 }
                 return destination;
             },
             angleOfDrag: function(x, y) {
                 var degrees, theta;
                 // Calc Theta
                 theta = Math.atan2(-(cache.startDragY - y), (cache.startDragX - x));
                 if (theta < 0) {
                     theta += 2 * Math.PI;
                 }
                 // Calc Degrees
                 degrees = Math.floor(theta * (180 / Math.PI) - 180);
                 if (degrees < 0 && degrees > -180) {
                     degrees = 360 - Math.abs(degrees);
                 }
                 return Math.abs(degrees);
             },
             events: {
                 addEvent: function addEvent(element, eventName, func) {
                     if (element.addEventListener) {
                         return element.addEventListener(eventName, func, false);
                     } else if (element.attachEvent) {
                         return element.attachEvent("on" + eventName, func);
                     }
                 },
                 removeEvent: function addEvent(element, eventName, func) {
                     if (element.addEventListener) {
                         return element.removeEventListener(eventName, func, false);
                     } else if (element.attachEvent) {
                         return element.detachEvent("on" + eventName, func);
                     }
                 },
                 prevent: function(e) {
                     if (e.preventDefault) {
                         e.preventDefault();
                     } else {
                         e.returnValue = false;
                     }
                 }
             },
             parentUntil: function(el, attr) {
                 var isStr = typeof attr === 'string';
                 while (el.parentNode) {
                     if (isStr && el.getAttribute && el.getAttribute(attr)){
                         return el;
                     } else if(!isStr && el === attr){
                         return el;
                     }
                     el = el.parentNode;
                 }
                 return null;
             }
         },
         action = {
             translate: {
                 get: {
                     matrix: function(index) {

                         if( !utils.canTransform() ){
                             return parseInt(settings.element.style.left, 10);
                         } else {
                             var matrix = win.getComputedStyle(settings.element)[cache.vendor+'Transform'].match(/\((.*)\)/),
                                 ieOffset = 8;
                             if (matrix) {
                                 matrix = matrix[1].split(',');
                                 if(matrix.length===16){
                                     index+=ieOffset;
                                 }
                                 return parseInt(matrix[index], 10);
                             }
                             return 0;
                         }
                     }
                 },
                 easeCallback: function(){
                     settings.element.style[cache.vendor+'Transition'] = '';
                     cache.translation = action.translate.get.matrix(4);
                     cache.easing = false;
                     clearInterval(cache.animatingInterval);

                     if(cache.easingTo===0){
                         utils.klass.remove(doc.body, 'snapjs-right');
                         utils.klass.remove(doc.body, 'snapjs-left');
                     }

                     utils.dispatchEvent('animated');
                     utils.events.removeEvent(settings.element, utils.transitionCallback(), action.translate.easeCallback);
                 },
                 easeTo: function(n) {

                     if( !utils.canTransform() ){
                         cache.translation = n;
                         action.translate.x(n);
                     } else {
                         cache.easing = true;
                         cache.easingTo = n;

                         settings.element.style[cache.vendor+'Transition'] = 'all ' + settings.transitionSpeed + 's ' + settings.easing;

                         cache.animatingInterval = setInterval(function() {
                             utils.dispatchEvent('animating');
                         }, 1);

                         utils.events.addEvent(settings.element, utils.transitionCallback(), action.translate.easeCallback);
                         action.translate.x(n);
                     }
                     if(n===0){
                            settings.element.style[cache.vendor+'Transform'] = '';
                        }
                 },
                 x: function(n) {
                     if( (settings.disable==='left' && n>0) ||
                         (settings.disable==='right' && n<0)
                     ){ return; }

                     if( !settings.hyperextensible ){
                         if( n===settings.maxPosition || n>settings.maxPosition ){
                             n=settings.maxPosition;
                         } else if( n===settings.minPosition || n<settings.minPosition ){
                             n=settings.minPosition;
                         }
                     }

                     n = parseInt(n, 10);
                     if(isNaN(n)){
                         n = 0;
                     }

                     if( utils.canTransform() ){
                         var theTranslate = 'translate3d(' + n + 'px, 0,0)';
                         settings.element.style[cache.vendor+'Transform'] = theTranslate;
                     } else {
                         settings.element.style.width = (win.innerWidth || doc.documentElement.clientWidth)+'px';

                         settings.element.style.left = n+'px';
                         settings.element.style.right = '';
                     }
                 }
             },
             drag: {
                 listen: function() {
                     cache.translation = 0;
                     cache.easing = false;
                     utils.events.addEvent(settings.element, utils.eventType('down'), action.drag.startDrag);
                     utils.events.addEvent(settings.element, utils.eventType('move'), action.drag.dragging);
                     utils.events.addEvent(settings.element, utils.eventType('up'), action.drag.endDrag);
                 },
                 stopListening: function() {
                     utils.events.removeEvent(settings.element, utils.eventType('down'), action.drag.startDrag);
                     utils.events.removeEvent(settings.element, utils.eventType('move'), action.drag.dragging);
                     utils.events.removeEvent(settings.element, utils.eventType('up'), action.drag.endDrag);
                 },
                 startDrag: function(e) {
                     // No drag on ignored elements
                     var target = e.target ? e.target : e.srcElement,
                         ignoreParent = utils.parentUntil(target, 'data-snap-ignore');

                     if (ignoreParent) {
                         utils.dispatchEvent('ignore');
                         return;
                     }


                     if(settings.dragger){
                         var dragParent = utils.parentUntil(target, settings.dragger);

                         // Only use dragger if we're in a closed state
                         if( !dragParent &&
                             (cache.translation !== settings.minPosition &&
                             cache.translation !== settings.maxPosition
                         )){
                             return;
                         }
                     }

                     utils.dispatchEvent('start');
                     settings.element.style[cache.vendor+'Transition'] = '';
                     cache.isDragging = true;
                     cache.hasIntent = null;
                     cache.intentChecked = false;
                     cache.startDragX = utils.page('X', e);
                     cache.startDragY = utils.page('Y', e);
                     cache.dragWatchers = {
                         current: 0,
                         last: 0,
                         hold: 0,
                         state: ''
                     };
                     cache.simpleStates = {
                         opening: null,
                         towards: null,
                         hyperExtending: null,
                         halfway: null,
                         flick: null,
                         translation: {
                             absolute: 0,
                             relative: 0,
                             sinceDirectionChange: 0,
                             percentage: 0
                         }
                     };
                 },
                 dragging: function(e) {
                     if (cache.isDragging && settings.touchToDrag) {

                         var thePageX = utils.page('X', e),
                             thePageY = utils.page('Y', e),
                             translated = cache.translation,
                             absoluteTranslation = action.translate.get.matrix(4),
                             whileDragX = thePageX - cache.startDragX,
                             openingLeft = absoluteTranslation > 0,
                             translateTo = whileDragX,
                             diff;

                         // Shown no intent already
                         if((cache.intentChecked && !cache.hasIntent)){
                             return;
                         }

                         if(settings.addBodyClasses){
                             if((absoluteTranslation)>0){
                                 utils.klass.add(doc.body, 'snapjs-left');
                                 utils.klass.remove(doc.body, 'snapjs-right');
                             } else if((absoluteTranslation)<0){
                                 utils.klass.add(doc.body, 'snapjs-right');
                                 utils.klass.remove(doc.body, 'snapjs-left');
                             }
                         }

                         if (cache.hasIntent === false || cache.hasIntent === null) {
                             var deg = utils.angleOfDrag(thePageX, thePageY),
                                 inRightRange = (deg >= 0 && deg <= settings.slideIntent) || (deg <= 360 && deg > (360 - settings.slideIntent)),
                                 inLeftRange = (deg >= 180 && deg <= (180 + settings.slideIntent)) || (deg <= 180 && deg >= (180 - settings.slideIntent));
                             if (!inLeftRange && !inRightRange) {
                                 cache.hasIntent = false;
                             } else {
                                 cache.hasIntent = true;
                             }
                             cache.intentChecked = true;
                         }

                         if (
                             (settings.minDragDistance>=Math.abs(thePageX-cache.startDragX)) || // Has user met minimum drag distance?
                             (cache.hasIntent === false)
                         ) {
                             return;
                         }

                         utils.events.prevent(e);
                         utils.dispatchEvent('drag');

                         cache.dragWatchers.current = thePageX;
                         // Determine which direction we are going
                         if (cache.dragWatchers.last > thePageX) {
                             if (cache.dragWatchers.state !== 'left') {
                                 cache.dragWatchers.state = 'left';
                                 cache.dragWatchers.hold = thePageX;
                             }
                             cache.dragWatchers.last = thePageX;
                         } else if (cache.dragWatchers.last < thePageX) {
                             if (cache.dragWatchers.state !== 'right') {
                                 cache.dragWatchers.state = 'right';
                                 cache.dragWatchers.hold = thePageX;
                             }
                             cache.dragWatchers.last = thePageX;
                         }
                         if (openingLeft) {
                             // Pulling too far to the right
                             if (settings.maxPosition < absoluteTranslation) {
                                 diff = (absoluteTranslation - settings.maxPosition) * settings.resistance;
                                 translateTo = whileDragX - diff;
                             }
                             cache.simpleStates = {
                                 opening: 'left',
                                 towards: cache.dragWatchers.state,
                                 hyperExtending: settings.maxPosition < absoluteTranslation,
                                 halfway: absoluteTranslation > (settings.maxPosition / 2),
                                 flick: Math.abs(cache.dragWatchers.current - cache.dragWatchers.hold) > settings.flickThreshold,
                                 translation: {
                                     absolute: absoluteTranslation,
                                     relative: whileDragX,
                                     sinceDirectionChange: (cache.dragWatchers.current - cache.dragWatchers.hold),
                                     percentage: (absoluteTranslation/settings.maxPosition)*100
                                 }
                             };
                         } else {
                             // Pulling too far to the left
                             if (settings.minPosition > absoluteTranslation) {
                                 diff = (absoluteTranslation - settings.minPosition) * settings.resistance;
                                 translateTo = whileDragX - diff;
                             }
                             cache.simpleStates = {
                                 opening: 'right',
                                 towards: cache.dragWatchers.state,
                                 hyperExtending: settings.minPosition > absoluteTranslation,
                                 halfway: absoluteTranslation < (settings.minPosition / 2),
                                 flick: Math.abs(cache.dragWatchers.current - cache.dragWatchers.hold) > settings.flickThreshold,
                                 translation: {
                                     absolute: absoluteTranslation,
                                     relative: whileDragX,
                                     sinceDirectionChange: (cache.dragWatchers.current - cache.dragWatchers.hold),
                                     percentage: (absoluteTranslation/settings.minPosition)*100
                                 }
                             };
                         }
                         action.translate.x(translateTo + translated);
                     }
                 },
                 endDrag: function(e) {
                     if (cache.isDragging) {
                         utils.dispatchEvent('end');
                         var translated = action.translate.get.matrix(4);

                         // Tap Close
                         if (cache.dragWatchers.current === 0 && translated !== 0 && settings.tapToClose) {
                             utils.dispatchEvent('close');
                             utils.events.prevent(e);
                             action.translate.easeTo(0);
                             cache.isDragging = false;
                             cache.startDragX = 0;
                             $('.backdrop').remove() // RC Backdrop remove
                            return;
                         }
                         $('.backdrop').remove() // RC Backdrop remove

                         // Revealing Left
                         if (cache.simpleStates.opening === 'left') {
                             // Halfway, Flicking, or Too Far Out
                             if ((cache.simpleStates.halfway || cache.simpleStates.hyperExtending || cache.simpleStates.flick)) {
                                 if (cache.simpleStates.flick && cache.simpleStates.towards === 'left') { // Flicking Closed
                                     action.translate.easeTo(0);
                                 } else if (
                                     (cache.simpleStates.flick && cache.simpleStates.towards === 'right') || // Flicking Open OR
                                     (cache.simpleStates.halfway || cache.simpleStates.hyperExtending) // At least halfway open OR hyperextending
                                 ) {
                                     action.translate.easeTo(settings.maxPosition); // Open Left
                                 }
                             } else {
                                 action.translate.easeTo(0); // Close Left
                             }
                             // Revealing Right
                         } else if (cache.simpleStates.opening === 'right') {
                             // Halfway, Flicking, or Too Far Out
                             if ((cache.simpleStates.halfway || cache.simpleStates.hyperExtending || cache.simpleStates.flick)) {
                                 if (cache.simpleStates.flick && cache.simpleStates.towards === 'right') { // Flicking Closed
                                     action.translate.easeTo(0);
                                 } else if (
                                     (cache.simpleStates.flick && cache.simpleStates.towards === 'left') || // Flicking Open OR
                                     (cache.simpleStates.halfway || cache.simpleStates.hyperExtending) // At least halfway open OR hyperextending
                                 ) {
                                     action.translate.easeTo(settings.minPosition); // Open Right
                                 }
                             } else {
                                 action.translate.easeTo(0); // Close Right
                             }
                         }
                         cache.isDragging = false;
                         cache.startDragX = utils.page('X', e);
                     }
                 }
             }
         },
         init = function(opts) {
             if (opts.element) {
                 utils.deepExtend(settings, opts);
                 cache.vendor = utils.vendor();
                 action.drag.listen();
             }
         };
         /*
          * Public
          */
         this.open = function(side) {
             utils.dispatchEvent('open');
             utils.klass.remove(doc.body, 'snapjs-expand-left');
             utils.klass.remove(doc.body, 'snapjs-expand-right');

             if (side === 'left') {
                 cache.simpleStates.opening = 'left';
                 cache.simpleStates.towards = 'right';
                 utils.klass.add(doc.body, 'snapjs-left');
                 utils.klass.remove(doc.body, 'snapjs-right');
                 action.translate.easeTo(settings.maxPosition);
             } else if (side === 'right') {
                 cache.simpleStates.opening = 'right';
                 cache.simpleStates.towards = 'left';
                 utils.klass.remove(doc.body, 'snapjs-left');
                 utils.klass.add(doc.body, 'snapjs-right');
                 action.translate.easeTo(settings.minPosition);
             }
         };
         this.close = function() {
             utils.dispatchEvent('close');
             action.translate.easeTo(0);
         };
         this.expand = function(side){
             var to = win.innerWidth || doc.documentElement.clientWidth;

             if(side==='left'){
                 utils.dispatchEvent('expandLeft');
                 utils.klass.add(doc.body, 'snapjs-expand-left');
                 utils.klass.remove(doc.body, 'snapjs-expand-right');
             } else {
                 utils.dispatchEvent('expandRight');
                 utils.klass.add(doc.body, 'snapjs-expand-right');
                 utils.klass.remove(doc.body, 'snapjs-expand-left');
                 to *= -1;
             }
             action.translate.easeTo(to);
         };

         this.on = function(evt, fn) {
             eventList[evt] = fn;
             return this;
         };
         this.off = function(evt) {
             if (eventList[evt]) {
                 eventList[evt] = false;
             }
         };

         this.enable = function() {
             utils.dispatchEvent('enable');
             action.drag.listen();
         };
         this.disable = function() {
             utils.dispatchEvent('disable');
             action.drag.stopListening();
         };

         this.settings = function(opts){
             utils.deepExtend(settings, opts);
         };

         this.state = function() {
             var state,
                 fromLeft = action.translate.get.matrix(4);
             if (fromLeft === settings.maxPosition) {
                 state = 'left';
             } else if (fromLeft === settings.minPosition) {
                 state = 'right';
             } else {
                 state = 'closed';
             }
             return {
                 state: state,
                 info: cache.simpleStates
             };
         };
         init(userOpts);
     };
     if ((typeof module !== 'undefined') && module.exports) {
         module.exports = Snap;
     }
     if (typeof ender === 'undefined') {
         this.Snap = Snap;
     }
     if ((typeof define === "function") && define.amd) {
         define("snap", [], function() {
             return Snap;
         });
     }
 }).call(this, window, document);



// Function : Initialize Snap.js
var RC_initDrawer=function(){
    if(window.snapper==undefined){
        // Initialize Snap.js
        window.snapper = new Snap({
            element: $('[data-extension="drawer"]')[0]
        });
    } else {
        // Snap.js already exists, we just need to re-bind events
        window.snapper.enable();
    }
    var snap_update={
        tapToClose: true,
        touchToDrag: true
    }
    window.snapper.settings(snap_update);
}
window.addEventListener('push',RC_initDrawer);

/* ========================================================================
 * RC - Drawer.js
 * ========================================================================
 * Copyright 2016 redblock inc.
 * Author kiere (kiere@kimsq.com)
 * Licensed under MIT.
 * ======================================================================== */

!(function ($) {
  'use strict';

      // Drawer CLASS DEFINITION
      // ======================

      var Drawer = function (element, options) {
            this.options          = options
            this.$body            = $(document.body)
            this.$element       = $(element)
            this.title               = this.options.title?this.options.title:null
            this.url               = this.options.url?this.options.url:null
            this.isShown             = null
            this.showType           = this.options.showtype?this.options.showtype:'default'
            this.direction          = this.options.direction?this.options.direction:'left'
            this.snap_update = {
			    transitionSpeed: this.options.speed?this.options.speed:0.3,
                easing: this.options.animation?this.options.animation:'ease',
	        }
	        snapper.settings(this.snap_update);
      }

      Drawer.VERSION  = '1.1.0'
      Drawer.DEFAULTS = {
            show: true,
            afterDrawer : true,
            history : false,
            backdrop : true,
            bcontainer : '.snap-content'
      }

      Drawer.prototype.toggle = function (_relatedTarget) {
            return this.isShown ? this.hide() : this.show(_relatedTarget)
      }

      Drawer.prototype.show = function (_relatedTarget) {
            var $this = this
            var e    = $.Event('show.rc.drawer', { relatedTarget: _relatedTarget })
            var title =this.title;
            var drawer=this.options.target?this.options.target:'#'+this.$element.attr('id'); // 엘리먼트 클릭(target) & script 오픈 2 가지
            var url =this.url;
            if(url!=null) url=url.toString();
            var animation=this.options.animation?this.options.animation:'';
            var template=this.options.template;
            var bcontainer=this.options.bcontainer;
            var tplContainer=this.options.tplcontainer?drawer+' '+this.options.tplcontainer:drawer;
            this.$element.trigger(e);
            this.isShown = true

           // init Utility
            var utility=new Utility(drawer,this.options).init();
            if(!template){
                 utility.setdataVal(drawer,$this.options); // data 값 세팅하는 전용함수 사용한다.
            }else{
               $(tplContainer).load(template,$.proxy(function(){
                    utility.setdataVal(drawer,$this.options); // data 값 세팅하는 전용함수 사용한다.
                    this.afterTemplate(this,_relatedTarget);
               },this));
            }

            this.$element.on('click.dismiss.rc.drawer', '[data-dismiss="drawer"]', $.proxy(this.hide, this))

            if(this.options.backdrop) this.backdrop();// add backdrop

            // drawer open
            if(this.showType=='default') snapper.open(this.direction)
            else if(this.showType=='expand') snapper.expand(this.direction)
            else if(this.showType=='toggle') {
                if(snapper.state().state==this.direction) this.hide()
                else snapper.open(this.direction)
            }

            if(this.options.history){
                // 브라우저 history 객체에 추가
                var object = {'type': 'drawer','target': {'id':drawer,'bcontainer':bcontainer,'backdrop':this.options.backdrop}}
                utility.addHistoryObject(object,title,url);
            }

           this.afterDrawer(this,_relatedTarget);
      }

      Drawer.prototype.afterTemplate=function(obj,_relatedTarget){
            var e = $.Event('loaded.rc.drawer', { relatedTarget: _relatedTarget })
            obj.$element.trigger('focus').trigger(e);
      }

      Drawer.prototype.afterDrawer=function(obj,_relatedTarget){
            var e = $.Event('shown.rc.drawer', { relatedTarget: _relatedTarget })
            obj.$element.trigger('focus').trigger(e);
      }

      Drawer.prototype.hide = function (e) {
           if(this.options.history) history.back();
           else this.nonHistoryHide();
           var backdrop=$(this.options.bcontainer).find('.backdrop');
          $(backdrop).remove();
      }

      Drawer.prototype.historyHide = function (e) {
            this.isShown = false
            var direction=this.options.direction=='left'?'right':'left';
            snapper.close(direction)
            if (e) e.preventDefault()
            var e    = $.Event('hide.rc.drawer');
            this.$element.trigger(e)
            this.afterHide();
      }

      Drawer.prototype.nonHistoryHide = function () {
            this.isShown = false
            var direction=this.options.direction=='left'?'right':'left';
            snapper.close(direction)
            var drawer=this.$element;
            var e    = $.Event('hide.rc.drawer');
            $(drawer).trigger(e)
            this.afterHide();
      }

      Drawer.prototype.afterHide=function(){
           var e = $.Event('hidden.rc.drawer');
           this.$element.trigger(e);
      }

      Drawer.prototype.backdrop = function (callback) {
          if (this.isShown && this.options.backdrop) {
               this.$backdrop = $(document.createElement('div'))
                  .addClass('backdrop')
                  .appendTo(this.options.bcontainer)
               this.$backdrop.on('click.dismiss.rc.drawer', $.proxy(function (e) {
                    if (this.ignoreBackdropClick) {
                      this.ignoreBackdropClick = false
                      return
                    }
                    if (e.target !== e.currentTarget) return
                    this.options.backdrop == 'static'
                    ? this.$element[0].focus()
                    : this.hide()
               }, this))
          }
     }

      var old = $.fn.drawer

      $.fn.drawer             = Plugin
      $.fn.drawer.Constructor = Drawer


        // DRAWER NO CONFLICT
        // =================

      $.fn.drawer.noConflict = function () {
            $.fn.drawer = old
            return this
      }

      // DRAWER PLUGIN DEFINITION
      // =======================

      function Plugin(option, _relatedTarget) {
      	    return this.each(function () {
                var $this   = $(this)
                var options = $.extend({}, Drawer.DEFAULTS, $this.data(), typeof option == 'object' && option)

                var data = new Drawer(this, options)
                if (typeof option == 'string' && option!='toggle') data[option](_relatedTarget)
                else if (options.show) data.show(_relatedTarget)
            })
       }

      // DRAWER DATA-API
      // ==============

     $(document).on('click.rc.drawer.data-api', '[data-toggle="drawer"]', function (e) {
          var $this   = $(this)
          var href    = $this.attr('href')
          var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
          var option  = $target.data('rc.drawer') ? 'toggle' : $.extend({}, $target.data(), $this.data())

          if ($this.is('a')) e.preventDefault()

          $target.one('show.rc.drawer', function (showEvent) {
                if (showEvent.isDefaultPrevented()) return // only register focus restorer if Popup will actually get shown
                $target.one('hidden.rc.drawer', function () {
                   $this.is(':active') && $this.trigger('focus')
                })
          })
          Plugin.call($target, option, this)
      })

}(jQuery));
