/*!
 * kimsQ RC v1.0.0-alpha.3 (http://rc.kimsq.com)
 * Copyright 2016 kimsQ core team (https://github.com/kimsQ/rc/graphs/contributors)
 * Licensed under MIT (https://github.com/kimsQ/rc/blob/master/LICENSE)
 */

if (typeof jQuery === 'undefined') {
  throw new Error('kimsQ RC\'s JavaScript requires jQuery')
}

+function ($) {
  var version = $.fn.jquery.split(' ')[0].split('.')
  if ((version[0] < 2 && version[1] < 9) || (version[0] == 1 && version[1] == 9 && version[2] < 1) || (version[0] >= 3)) {
    throw new Error('kimsQ RC\'s JavaScript requires at least jQuery v1.9.1 but less than v3.0.0')
  }
}(jQuery);


+function ($) {

/*!
 * =====================================================
 * Ratchet v2.0.2 (http://goratchet.com)
 * Copyright 2016 Connor Sears
 * Licensed under MIT (https://github.com/twbs/ratchet/blob/master/LICENSE)
 *
 * v2.0.2 designed by @connors.
 * =====================================================
 */
/* ========================================================================
 * Ratchet: common.js v2.0.2
 * http://goratchet.com/
 * ========================================================================
 * Copyright 2015 Connor Sears
 * Licensed under MIT (https://github.com/twbs/ratchet/blob/master/LICENSE)
 * ======================================================================== */

!(function () {
  'use strict';

  // Compatible With CustomEvent
  if (!window.CustomEvent) {
    window.CustomEvent = function (type, config) {
      var e = document.createEvent('CustomEvent');
      e.initCustomEvent(type, config.bubbles, config.cancelable, config.detail);
      return e;
    };
  }

  // Create Ratchet namespace
  if (typeof window.RATCHET === 'undefined') {
    window.RATCHET = {};
  }

  // Original script from http://davidwalsh.name/vendor-prefix
  window.RATCHET.getBrowserCapabilities = (function () {
    var styles = window.getComputedStyle(document.documentElement, '');
    var pre = (Array.prototype.slice
        .call(styles)
        .join('')
        .match(/-(moz|webkit|ms)-/) || (styles.OLink === '' && ['', 'o'])
      )[1];
    return {
      prefix: '-' + pre + '-',
      transform: pre[0].toUpperCase() + pre.substr(1) + 'Transform'
    };
  })();

  window.RATCHET.getTransitionEnd = (function () {
    var el = document.createElement('ratchet');
    var transEndEventNames = {
      WebkitTransition : 'webkitTransitionEnd',
      MozTransition : 'transitionend',
      OTransition : 'oTransitionEnd otransitionend',
      transition : 'transitionend'
    };

    for (var name in transEndEventNames) {
      if (el.style[name] !== undefined) {
        return transEndEventNames[name];
      }
    }

    return transEndEventNames.transition;
  })();
}());

/**
 * History.js jQuery Adapter
 * @author Benjamin Arthur Lupton <contact@balupton.com>
 * @copyright 2010-2011 Benjamin Arthur Lupton <contact@balupton.com>
 * @license New BSD License <http://creativecommons.org/licenses/BSD/>
 */

// Closure
(function(window,undefined){
	"use strict";

	// Localise Globals
	var
		History = window.History = window.History||{},
		jQuery = window.jQuery;

	// Check Existence
	if ( typeof History.Adapter !== 'undefined' ) {
		throw new Error('History.js Adapter has already been loaded...');
	}

	// Add the Adapter
	History.Adapter = {
		/**
		 * History.Adapter.bind(el,event,callback)
		 * @param {Element|string} el
		 * @param {string} event - custom and standard events
		 * @param {function} callback
		 * @return {void}
		 */
		bind: function(el,event,callback){
			jQuery(el).bind(event,callback);
		},

		/**
		 * History.Adapter.trigger(el,event)
		 * @param {Element|string} el
		 * @param {string} event - custom and standard events
		 * @param {Object=} extra - a object of extra event data (optional)
		 * @return {void}
		 */
		trigger: function(el,event,extra){
			jQuery(el).trigger(event,extra);
		},

		/**
		 * History.Adapter.extractEventData(key,event,extra)
		 * @param {string} key - key for the event data to extract
		 * @param {string} event - custom and standard events
		 * @param {Object=} extra - a object of extra event data (optional)
		 * @return {mixed}
		 */
		extractEventData: function(key,event,extra){
			// jQuery Native then jQuery Custom
			var result = (event && event.originalEvent && event.originalEvent[key]) || (extra && extra[key]) || undefined;

			// Return
			return result;
		},

		/**
		 * History.Adapter.onDomLoad(callback)
		 * @param {function} callback
		 * @return {void}
		 */
		onDomLoad: function(callback) {
			jQuery(callback);
		}
	};

	// Try and Initialise History
	if ( typeof History.init !== 'undefined' ) {
		History.init();
	}

})(window);

/**
 * History.js Core
 * @author Benjamin Arthur Lupton <contact@balupton.com>
 * @copyright 2010-2011 Benjamin Arthur Lupton <contact@balupton.com>
 * @license New BSD License <http://creativecommons.org/licenses/BSD/>
 */

(function(window,undefined){
	"use strict";

	// ========================================================================
	// Initialise

	// Localise Globals
	var
		console = window.console||undefined, // Prevent a JSLint complain
		document = window.document, // Make sure we are using the correct document
		navigator = window.navigator, // Make sure we are using the correct navigator
		sessionStorage = false, // sessionStorage
		setTimeout = window.setTimeout,
		clearTimeout = window.clearTimeout,
		setInterval = window.setInterval,
		clearInterval = window.clearInterval,
		JSON = window.JSON,
		alert = window.alert,
		History = window.History = window.History||{}, // Public History Object
		history = window.history; // Old History Object

	try {
		sessionStorage = window.sessionStorage; // This will throw an exception in some browsers when cookies/localStorage are explicitly disabled (i.e. Chrome)
		sessionStorage.setItem('TEST', '1');
		sessionStorage.removeItem('TEST');
	} catch(e) {
		sessionStorage = false;
	}

	// MooTools Compatibility
	JSON.stringify = JSON.stringify||JSON.encode;
	JSON.parse = JSON.parse||JSON.decode;

	// Check Existence
	if ( typeof History.init !== 'undefined' ) {
		throw new Error('History.js Core has already been loaded...');
	}

	// Initialise History
	History.init = function(options){
		// Check Load Status of Adapter
		if ( typeof History.Adapter === 'undefined' ) {
			return false;
		}

		// Check Load Status of Core
		if ( typeof History.initCore !== 'undefined' ) {
			History.initCore();
		}

		// Check Load Status of HTML4 Support
		if ( typeof History.initHtml4 !== 'undefined' ) {
			History.initHtml4();
		}

		// Return true
		return true;
	};


	// ========================================================================
	// Initialise Core

	// Initialise Core
	History.initCore = function(options){
		// Initialise
		if ( typeof History.initCore.initialized !== 'undefined' ) {
			// Already Loaded
			return false;
		}
		else {
			History.initCore.initialized = true;
		}


		// ====================================================================
		// Options

		/**
		 * History.options
		 * Configurable options
		 */
		History.options = History.options||{};

		/**
		 * History.options.hashChangeInterval
		 * How long should the interval be before hashchange checks
		 */
		History.options.hashChangeInterval = History.options.hashChangeInterval || 100;

		/**
		 * History.options.safariPollInterval
		 * How long should the interval be before safari poll checks
		 */
		History.options.safariPollInterval = History.options.safariPollInterval || 500;

		/**
		 * History.options.doubleCheckInterval
		 * How long should the interval be before we perform a double check
		 */
		History.options.doubleCheckInterval = History.options.doubleCheckInterval || 500;

		/**
		 * History.options.disableSuid
		 * Force History not to append suid
		 */
		History.options.disableSuid = History.options.disableSuid || false;

		/**
		 * History.options.storeInterval
		 * How long should we wait between store calls
		 */
		History.options.storeInterval = History.options.storeInterval || 1000;

		/**
		 * History.options.busyDelay
		 * How long should we wait between busy events
		 */
		History.options.busyDelay = History.options.busyDelay || 250;

		/**
		 * History.options.debug
		 * If true will enable debug messages to be logged
		 */
		History.options.debug = History.options.debug || false;

		/**
		 * History.options.initialTitle
		 * What is the title of the initial state
		 */
		History.options.initialTitle = History.options.initialTitle || document.title;

		/**
		 * History.options.html4Mode
		 * If true, will force HTMl4 mode (hashtags)
		 */
		History.options.html4Mode = History.options.html4Mode || false;

		/**
		 * History.options.delayInit
		 * Want to override default options and call init manually.
		 */
		History.options.delayInit = History.options.delayInit || false;


		// ====================================================================
		// Interval record

		/**
		 * History.intervalList
		 * List of intervals set, to be cleared when document is unloaded.
		 */
		History.intervalList = [];

		/**
		 * History.clearAllIntervals
		 * Clears all setInterval instances.
		 */
		History.clearAllIntervals = function(){
			var i, il = History.intervalList;
			if (typeof il !== "undefined" && il !== null) {
				for (i = 0; i < il.length; i++) {
					clearInterval(il[i]);
				}
				History.intervalList = null;
			}
		};


		// ====================================================================
		// Debug

		/**
		 * History.debug(message,...)
		 * Logs the passed arguments if debug enabled
		 */
		History.debug = function(){
			if ( (History.options.debug||false) ) {
				History.log.apply(History,arguments);
			}
		};

		/**
		 * History.log(message,...)
		 * Logs the passed arguments
		 */
		History.log = function(){
			// Prepare
			var
				consoleExists = !(typeof console === 'undefined' || typeof console.log === 'undefined' || typeof console.log.apply === 'undefined'),
				textarea = document.getElementById('log'),
				message,
				i,n,
				args,arg
				;

			// Write to Console
			if ( consoleExists ) {
				args = Array.prototype.slice.call(arguments);
				message = args.shift();
				if ( typeof console.debug !== 'undefined' ) {
					console.debug.apply(console,[message,args]);
				}
				else {
					console.log.apply(console,[message,args]);
				}
			}
			else {
				message = ("\n"+arguments[0]+"\n");
			}

			// Write to log
			for ( i=1,n=arguments.length; i<n; ++i ) {
				arg = arguments[i];
				if ( typeof arg === 'object' && typeof JSON !== 'undefined' ) {
					try {
						arg = JSON.stringify(arg);
					}
					catch ( Exception ) {
						// Recursive Object
					}
				}
				message += "\n"+arg+"\n";
			}

			// Textarea
			if ( textarea ) {
				textarea.value += message+"\n-----\n";
				textarea.scrollTop = textarea.scrollHeight - textarea.clientHeight;
			}
			// No Textarea, No Console
			else if ( !consoleExists ) {
				alert(message);
			}

			// Return true
			return true;
		};


		// ====================================================================
		// Emulated Status

		/**
		 * History.getInternetExplorerMajorVersion()
		 * Get's the major version of Internet Explorer
		 * @return {integer}
		 * @license Public Domain
		 * @author Benjamin Arthur Lupton <contact@balupton.com>
		 * @author James Padolsey <https://gist.github.com/527683>
		 */
		History.getInternetExplorerMajorVersion = function(){
			var result = History.getInternetExplorerMajorVersion.cached =
					(typeof History.getInternetExplorerMajorVersion.cached !== 'undefined')
				?	History.getInternetExplorerMajorVersion.cached
				:	(function(){
						var v = 3,
								div = document.createElement('div'),
								all = div.getElementsByTagName('i');
						while ( (div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->') && all[0] ) {}
						return (v > 4) ? v : false;
					})()
				;
			return result;
		};

		/**
		 * History.isInternetExplorer()
		 * Are we using Internet Explorer?
		 * @return {boolean}
		 * @license Public Domain
		 * @author Benjamin Arthur Lupton <contact@balupton.com>
		 */
		History.isInternetExplorer = function(){
			var result =
				History.isInternetExplorer.cached =
				(typeof History.isInternetExplorer.cached !== 'undefined')
					?	History.isInternetExplorer.cached
					:	Boolean(History.getInternetExplorerMajorVersion())
				;
			return result;
		};

		/**
		 * History.emulated
		 * Which features require emulating?
		 */

		if (History.options.html4Mode) {
			History.emulated = {
				pushState : true,
				hashChange: true
			};
		}

		else {

			History.emulated = {
				pushState: !Boolean(
					window.history && window.history.pushState && window.history.replaceState
					&& !(
						(/ Mobile\/([1-7][a-z]|(8([abcde]|f(1[0-8]))))/i).test(navigator.userAgent) /* disable for versions of iOS before version 4.3 (8F190) */
						|| (/AppleWebKit\/5([0-2]|3[0-2])/i).test(navigator.userAgent) /* disable for the mercury iOS browser, or at least older versions of the webkit engine */
					)
				),
				hashChange: Boolean(
					!(('onhashchange' in window) || ('onhashchange' in document))
					||
					(History.isInternetExplorer() && History.getInternetExplorerMajorVersion() < 8)
				)
			};
		}

		/**
		 * History.enabled
		 * Is History enabled?
		 */
		History.enabled = !History.emulated.pushState;

		/**
		 * History.bugs
		 * Which bugs are present
		 */
		History.bugs = {
			/**
			 * Safari 5 and Safari iOS 4 fail to return to the correct state once a hash is replaced by a `replaceState` call
			 * https://bugs.webkit.org/show_bug.cgi?id=56249
			 */
			setHash: Boolean(!History.emulated.pushState && navigator.vendor === 'Apple Computer, Inc.' && /AppleWebKit\/5([0-2]|3[0-3])/.test(navigator.userAgent)),

			/**
			 * Safari 5 and Safari iOS 4 sometimes fail to apply the state change under busy conditions
			 * https://bugs.webkit.org/show_bug.cgi?id=42940
			 */
			safariPoll: Boolean(!History.emulated.pushState && navigator.vendor === 'Apple Computer, Inc.' && /AppleWebKit\/5([0-2]|3[0-3])/.test(navigator.userAgent)),

			/**
			 * MSIE 6 and 7 sometimes do not apply a hash even it was told to (requiring a second call to the apply function)
			 */
			ieDoubleCheck: Boolean(History.isInternetExplorer() && History.getInternetExplorerMajorVersion() < 8),

			/**
			 * MSIE 6 requires the entire hash to be encoded for the hashes to trigger the onHashChange event
			 */
			hashEscape: Boolean(History.isInternetExplorer() && History.getInternetExplorerMajorVersion() < 7)
		};

		/**
		 * History.isEmptyObject(obj)
		 * Checks to see if the Object is Empty
		 * @param {Object} obj
		 * @return {boolean}
		 */
		History.isEmptyObject = function(obj) {
			for ( var name in obj ) {
				if ( obj.hasOwnProperty(name) ) {
					return false;
				}
			}
			return true;
		};

		/**
		 * History.cloneObject(obj)
		 * Clones a object and eliminate all references to the original contexts
		 * @param {Object} obj
		 * @return {Object}
		 */
		History.cloneObject = function(obj) {
			var hash,newObj;
			if ( obj ) {
				hash = JSON.stringify(obj);
				newObj = JSON.parse(hash);
			}
			else {
				newObj = {};
			}
			return newObj;
		};


		// ====================================================================
		// URL Helpers

		/**
		 * History.getRootUrl()
		 * Turns "http://mysite.com/dir/page.html?asd" into "http://mysite.com"
		 * @return {String} rootUrl
		 */
		History.getRootUrl = function(){
			// Create
			var rootUrl = document.location.protocol+'//'+(document.location.hostname||document.location.host);
			if ( document.location.port||false ) {
				rootUrl += ':'+document.location.port;
			}
			rootUrl += '/';

			// Return
			return rootUrl;
		};

		/**
		 * History.getBaseHref()
		 * Fetches the `href` attribute of the `<base href="...">` element if it exists
		 * @return {String} baseHref
		 */
		History.getBaseHref = function(){
			// Create
			var
				baseElements = document.getElementsByTagName('base'),
				baseElement = null,
				baseHref = '';

			// Test for Base Element
			if ( baseElements.length === 1 ) {
				// Prepare for Base Element
				baseElement = baseElements[0];
				baseHref = baseElement.href.replace(/[^\/]+$/,'');
			}

			// Adjust trailing slash
			baseHref = baseHref.replace(/\/+$/,'');
			if ( baseHref ) baseHref += '/';

			// Return
			return baseHref;
		};

		/**
		 * History.getBaseUrl()
		 * Fetches the baseHref or basePageUrl or rootUrl (whichever one exists first)
		 * @return {String} baseUrl
		 */
		History.getBaseUrl = function(){
			// Create
			var baseUrl = History.getBaseHref()||History.getBasePageUrl()||History.getRootUrl();

			// Return
			return baseUrl;
		};

		/**
		 * History.getPageUrl()
		 * Fetches the URL of the current page
		 * @return {String} pageUrl
		 */
		History.getPageUrl = function(){
			// Fetch
			var
				State = History.getState(false,false),
				stateUrl = (State||{}).url||History.getLocationHref(),
				pageUrl;

			// Create
			pageUrl = stateUrl.replace(/\/+$/,'').replace(/[^\/]+$/,function(part,index,string){
				return (/\./).test(part) ? part : part+'/';
			});

			// Return
			return pageUrl;
		};

		/**
		 * History.getBasePageUrl()
		 * Fetches the Url of the directory of the current page
		 * @return {String} basePageUrl
		 */
		History.getBasePageUrl = function(){
			// Create
			var basePageUrl = (History.getLocationHref()).replace(/[#\?].*/,'').replace(/[^\/]+$/,function(part,index,string){
				return (/[^\/]$/).test(part) ? '' : part;
			}).replace(/\/+$/,'')+'/';

			// Return
			return basePageUrl;
		};

		/**
		 * History.getFullUrl(url)
		 * Ensures that we have an absolute URL and not a relative URL
		 * @param {string} url
		 * @param {Boolean} allowBaseHref
		 * @return {string} fullUrl
		 */
		History.getFullUrl = function(url,allowBaseHref){
			// Prepare
			var fullUrl = url, firstChar = url.substring(0,1);
			allowBaseHref = (typeof allowBaseHref === 'undefined') ? true : allowBaseHref;

			// Check
			if ( /[a-z]+\:\/\//.test(url) ) {
				// Full URL
			}
			else if ( firstChar === '/' ) {
				// Root URL
				fullUrl = History.getRootUrl()+url.replace(/^\/+/,'');
			}
			else if ( firstChar === '#' ) {
				// Anchor URL
				fullUrl = History.getPageUrl().replace(/#.*/,'')+url;
			}
			else if ( firstChar === '?' ) {
				// Query URL
				fullUrl = History.getPageUrl().replace(/[\?#].*/,'')+url;
			}
			else {
				// Relative URL
				if ( allowBaseHref ) {
					fullUrl = History.getBaseUrl()+url.replace(/^(\.\/)+/,'');
				} else {
					fullUrl = History.getBasePageUrl()+url.replace(/^(\.\/)+/,'');
				}
				// We have an if condition above as we do not want hashes
				// which are relative to the baseHref in our URLs
				// as if the baseHref changes, then all our bookmarks
				// would now point to different locations
				// whereas the basePageUrl will always stay the same
			}

			// Return
			return fullUrl.replace(/\#$/,'');
		};

		/**
		 * History.getShortUrl(url)
		 * Ensures that we have a relative URL and not a absolute URL
		 * @param {string} url
		 * @return {string} url
		 */
		History.getShortUrl = function(url){
			// Prepare
			var shortUrl = url, baseUrl = History.getBaseUrl(), rootUrl = History.getRootUrl();

			// Trim baseUrl
			if ( History.emulated.pushState ) {
				// We are in a if statement as when pushState is not emulated
				// The actual url these short urls are relative to can change
				// So within the same session, we the url may end up somewhere different
				shortUrl = shortUrl.replace(baseUrl,'');
			}

			// Trim rootUrl
			shortUrl = shortUrl.replace(rootUrl,'/');

			// Ensure we can still detect it as a state
			if ( History.isTraditionalAnchor(shortUrl) ) {
				shortUrl = './'+shortUrl;
			}

			// Clean It
			shortUrl = shortUrl.replace(/^(\.\/)+/g,'./').replace(/\#$/,'');

			// Return
			return shortUrl;
		};

		/**
		 * History.getLocationHref(document)
		 * Returns a normalized version of document.location.href
		 * accounting for browser inconsistencies, etc.
		 *
		 * This URL will be URI-encoded and will include the hash
		 *
		 * @param {object} document
		 * @return {string} url
		 */
		History.getLocationHref = function(doc) {
			doc = doc || document;

			// most of the time, this will be true
			if (doc.URL === doc.location.href)
				return doc.location.href;

			// some versions of webkit URI-decode document.location.href
			// but they leave document.URL in an encoded state
			if (doc.location.href === decodeURIComponent(doc.URL))
				return doc.URL;

			// FF 3.6 only updates document.URL when a page is reloaded
			// document.location.href is updated correctly
			if (doc.location.hash && decodeURIComponent(doc.location.href.replace(/^[^#]+/, "")) === doc.location.hash)
				return doc.location.href;

			if (doc.URL.indexOf('#') == -1 && doc.location.href.indexOf('#') != -1)
				return doc.location.href;

			return doc.URL || doc.location.href;
		};


		// ====================================================================
		// State Storage

		/**
		 * History.store
		 * The store for all session specific data
		 */
		History.store = {};

		/**
		 * History.idToState
		 * 1-1: State ID to State Object
		 */
		History.idToState = History.idToState||{};

		/**
		 * History.stateToId
		 * 1-1: State String to State ID
		 */
		History.stateToId = History.stateToId||{};

		/**
		 * History.urlToId
		 * 1-1: State URL to State ID
		 */
		History.urlToId = History.urlToId||{};

		/**
		 * History.storedStates
		 * Store the states in an array
		 */
		History.storedStates = History.storedStates||[];

		/**
		 * History.savedStates
		 * Saved the states in an array
		 */
		History.savedStates = History.savedStates||[];

		/**
		 * History.noramlizeStore()
		 * Noramlize the store by adding necessary values
		 */
		History.normalizeStore = function(){
			History.store.idToState = History.store.idToState||{};
			History.store.urlToId = History.store.urlToId||{};
			History.store.stateToId = History.store.stateToId||{};
		};

		/**
		 * History.getState()
		 * Get an object containing the data, title and url of the current state
		 * @param {Boolean} friendly
		 * @param {Boolean} create
		 * @return {Object} State
		 */
		History.getState = function(friendly,create){
			// Prepare
			if ( typeof friendly === 'undefined' ) { friendly = true; }
			if ( typeof create === 'undefined' ) { create = true; }

			// Fetch
			var State = History.getLastSavedState();

			// Create
			if ( !State && create ) {
				State = History.createStateObject();
			}

			// Adjust
			if ( friendly ) {
				State = History.cloneObject(State);
				State.url = State.cleanUrl||State.url;
			}

			// Return
			return State;
		};

		/**
		 * History.getIdByState(State)
		 * Gets a ID for a State
		 * @param {State} newState
		 * @return {String} id
		 */
		History.getIdByState = function(newState){

			// Fetch ID
			var id = History.extractId(newState.url),
				str;

			if ( !id ) {
				// Find ID via State String
				str = History.getStateString(newState);
				if ( typeof History.stateToId[str] !== 'undefined' ) {
					id = History.stateToId[str];
				}
				else if ( typeof History.store.stateToId[str] !== 'undefined' ) {
					id = History.store.stateToId[str];
				}
				else {
					// Generate a new ID
					while ( true ) {
						id = (new Date()).getTime() + String(Math.random()).replace(/\D/g,'');
						if ( typeof History.idToState[id] === 'undefined' && typeof History.store.idToState[id] === 'undefined' ) {
							break;
						}
					}

					// Apply the new State to the ID
					History.stateToId[str] = id;
					History.idToState[id] = newState;
				}
			}

			// Return ID
			return id;
		};

		/**
		 * History.normalizeState(State)
		 * Expands a State Object
		 * @param {object} State
		 * @return {object}
		 */
		History.normalizeState = function(oldState){
			// Variables
			var newState, dataNotEmpty;

			// Prepare
			if ( !oldState || (typeof oldState !== 'object') ) {
				oldState = {};
			}

			// Check
			if ( typeof oldState.normalized !== 'undefined' ) {
				return oldState;
			}

			// Adjust
			if ( !oldState.data || (typeof oldState.data !== 'object') ) {
				oldState.data = {};
			}

			// ----------------------------------------------------------------

			// Create
			newState = {};
			newState.normalized = true;
			newState.title = oldState.title||'';
			newState.url = History.getFullUrl(oldState.url?oldState.url:(History.getLocationHref()));
			newState.hash = History.getShortUrl(newState.url);
			newState.data = History.cloneObject(oldState.data);

			// Fetch ID
			newState.id = History.getIdByState(newState);

			// ----------------------------------------------------------------

			// Clean the URL
			newState.cleanUrl = newState.url.replace(/\??\&_suid.*/,'');
			newState.url = newState.cleanUrl;

			// Check to see if we have more than just a url
			dataNotEmpty = !History.isEmptyObject(newState.data);

			// Apply
			if ( (newState.title || dataNotEmpty) && History.options.disableSuid !== true ) {
				// Add ID to Hash
				newState.hash = History.getShortUrl(newState.url).replace(/\??\&_suid.*/,'');
				if ( !/\?/.test(newState.hash) ) {
					newState.hash += '?';
				}
				newState.hash += '&_suid='+newState.id;
			}

			// Create the Hashed URL
			newState.hashedUrl = History.getFullUrl(newState.hash);

			// ----------------------------------------------------------------

			// Update the URL if we have a duplicate
			if ( (History.emulated.pushState || History.bugs.safariPoll) && History.hasUrlDuplicate(newState) ) {
				newState.url = newState.hashedUrl;
			}

			// ----------------------------------------------------------------

			// Return
			return newState;
		};

		/**
		 * History.createStateObject(data,title,url)
		 * Creates a object based on the data, title and url state params
		 * @param {object} data
		 * @param {string} title
		 * @param {string} url
		 * @return {object}
		 */
		History.createStateObject = function(data,title,url){
			// Hashify
			var State = {
				'data': data,
				'title': title,
				'url': url
			};

			// Expand the State
			State = History.normalizeState(State);

			// Return object
			return State;
		};

		/**
		 * History.getStateById(id)
		 * Get a state by it's UID
		 * @param {String} id
		 */
		History.getStateById = function(id){
			// Prepare
			id = String(id);

			// Retrieve
			var State = History.idToState[id] || History.store.idToState[id] || undefined;

			// Return State
			return State;
		};

		/**
		 * Get a State's String
		 * @param {State} passedState
		 */
		History.getStateString = function(passedState){
			// Prepare
			var State, cleanedState, str;

			// Fetch
			State = History.normalizeState(passedState);

			// Clean
			cleanedState = {
				data: State.data,
				title: passedState.title,
				url: passedState.url
			};

			// Fetch
			str = JSON.stringify(cleanedState);

			// Return
			return str;
		};

		/**
		 * Get a State's ID
		 * @param {State} passedState
		 * @return {String} id
		 */
		History.getStateId = function(passedState){
			// Prepare
			var State, id;

			// Fetch
			State = History.normalizeState(passedState);

			// Fetch
			id = State.id;

			// Return
			return id;
		};

		/**
		 * History.getHashByState(State)
		 * Creates a Hash for the State Object
		 * @param {State} passedState
		 * @return {String} hash
		 */
		History.getHashByState = function(passedState){
			// Prepare
			var State, hash;

			// Fetch
			State = History.normalizeState(passedState);

			// Hash
			hash = State.hash;

			// Return
			return hash;
		};

		/**
		 * History.extractId(url_or_hash)
		 * Get a State ID by it's URL or Hash
		 * @param {string} url_or_hash
		 * @return {string} id
		 */
		History.extractId = function ( url_or_hash ) {
			// Prepare
			var id,parts,url, tmp;

			// Extract

			// If the URL has a #, use the id from before the #
			if (url_or_hash.indexOf('#') != -1)
			{
				tmp = url_or_hash.split("#")[0];
			}
			else
			{
				tmp = url_or_hash;
			}

			parts = /(.*)\&_suid=([0-9]+)$/.exec(tmp);
			url = parts ? (parts[1]||url_or_hash) : url_or_hash;
			id = parts ? String(parts[2]||'') : '';

			// Return
			return id||false;
		};

		/**
		 * History.isTraditionalAnchor
		 * Checks to see if the url is a traditional anchor or not
		 * @param {String} url_or_hash
		 * @return {Boolean}
		 */
		History.isTraditionalAnchor = function(url_or_hash){
			// Check
			var isTraditional = !(/[\/\?\.]/.test(url_or_hash));

			// Return
			return isTraditional;
		};

		/**
		 * History.extractState
		 * Get a State by it's URL or Hash
		 * @param {String} url_or_hash
		 * @return {State|null}
		 */
		History.extractState = function(url_or_hash,create){
			// Prepare
			var State = null, id, url;
			create = create||false;

			// Fetch SUID
			id = History.extractId(url_or_hash);
			if ( id ) {
				State = History.getStateById(id);
			}

			// Fetch SUID returned no State
			if ( !State ) {
				// Fetch URL
				url = History.getFullUrl(url_or_hash);

				// Check URL
				id = History.getIdByUrl(url)||false;
				if ( id ) {
					State = History.getStateById(id);
				}

				// Create State
				if ( !State && create && !History.isTraditionalAnchor(url_or_hash) ) {
					State = History.createStateObject(null,null,url);
				}
			}

			// Return
			return State;
		};

		/**
		 * History.getIdByUrl()
		 * Get a State ID by a State URL
		 */
		History.getIdByUrl = function(url){
			// Fetch
			var id = History.urlToId[url] || History.store.urlToId[url] || undefined;

			// Return
			return id;
		};

		/**
		 * History.getLastSavedState()
		 * Get an object containing the data, title and url of the current state
		 * @return {Object} State
		 */
		History.getLastSavedState = function(){
			return History.savedStates[History.savedStates.length-1]||undefined;
		};

		/**
		 * History.getLastStoredState()
		 * Get an object containing the data, title and url of the current state
		 * @return {Object} State
		 */
		History.getLastStoredState = function(){
			return History.storedStates[History.storedStates.length-1]||undefined;
		};

		/**
		 * History.hasUrlDuplicate
		 * Checks if a Url will have a url conflict
		 * @param {Object} newState
		 * @return {Boolean} hasDuplicate
		 */
		History.hasUrlDuplicate = function(newState) {
			// Prepare
			var hasDuplicate = false,
				oldState;

			// Fetch
			oldState = History.extractState(newState.url);

			// Check
			hasDuplicate = oldState && oldState.id !== newState.id;

			// Return
			return hasDuplicate;
		};

		/**
		 * History.storeState
		 * Store a State
		 * @param {Object} newState
		 * @return {Object} newState
		 */
		History.storeState = function(newState){
			// Store the State
			History.urlToId[newState.url] = newState.id;

			// Push the State
			History.storedStates.push(History.cloneObject(newState));

			// Return newState
			return newState;
		};

		/**
		 * History.isLastSavedState(newState)
		 * Tests to see if the state is the last state
		 * @param {Object} newState
		 * @return {boolean} isLast
		 */
		History.isLastSavedState = function(newState){
			// Prepare
			var isLast = false,
				newId, oldState, oldId;

			// Check
			if ( History.savedStates.length ) {
				newId = newState.id;
				oldState = History.getLastSavedState();
				oldId = oldState.id;

				// Check
				isLast = (newId === oldId);
			}

			// Return
			return isLast;
		};

		/**
		 * History.saveState
		 * Push a State
		 * @param {Object} newState
		 * @return {boolean} changed
		 */
		History.saveState = function(newState){
			// Check Hash
			if ( History.isLastSavedState(newState) ) {
				return false;
			}

			// Push the State
			History.savedStates.push(History.cloneObject(newState));

			// Return true
			return true;
		};

		/**
		 * History.getStateByIndex()
		 * Gets a state by the index
		 * @param {integer} index
		 * @return {Object}
		 */
		History.getStateByIndex = function(index){
			// Prepare
			var State = null;

			// Handle
			if ( typeof index === 'undefined' ) {
				// Get the last inserted
				State = History.savedStates[History.savedStates.length-1];
			}
			else if ( index < 0 ) {
				// Get from the end
				State = History.savedStates[History.savedStates.length+index];
			}
			else {
				// Get from the beginning
				State = History.savedStates[index];
			}

			// Return State
			return State;
		};

		/**
		 * History.getCurrentIndex()
		 * Gets the current index
		 * @return (integer)
		*/
		History.getCurrentIndex = function(){
			// Prepare
			var index = null;

			// No states saved
			if(History.savedStates.length < 1) {
				index = 0;
			}
			else {
				index = History.savedStates.length-1;
			}
			return index;
		};

		// ====================================================================
		// Hash Helpers

		/**
		 * History.getHash()
		 * @param {Location=} location
		 * Gets the current document hash
		 * Note: unlike location.hash, this is guaranteed to return the escaped hash in all browsers
		 * @return {string}
		 */
		History.getHash = function(doc){
			var url = History.getLocationHref(doc),
				hash;
			hash = History.getHashByUrl(url);
			return hash;
		};

		/**
		 * History.unescapeHash()
		 * normalize and Unescape a Hash
		 * @param {String} hash
		 * @return {string}
		 */
		History.unescapeHash = function(hash){
			// Prepare
			var result = History.normalizeHash(hash);

			// Unescape hash
			result = decodeURIComponent(result);

			// Return result
			return result;
		};

		/**
		 * History.normalizeHash()
		 * normalize a hash across browsers
		 * @return {string}
		 */
		History.normalizeHash = function(hash){
			// Prepare
			var result = hash.replace(/[^#]*#/,'').replace(/#.*/, '');

			// Return result
			return result;
		};

		/**
		 * History.setHash(hash)
		 * Sets the document hash
		 * @param {string} hash
		 * @return {History}
		 */
		History.setHash = function(hash,queue){
			// Prepare
			var State, pageUrl;

			// Handle Queueing
			if ( queue !== false && History.busy() ) {
				// Wait + Push to Queue
				//History.debug('History.setHash: we must wait', arguments);
				History.pushQueue({
					scope: History,
					callback: History.setHash,
					args: arguments,
					queue: queue
				});
				return false;
			}

			// Log
			//History.debug('History.setHash: called',hash);

			// Make Busy + Continue
			History.busy(true);

			// Check if hash is a state
			State = History.extractState(hash,true);
			if ( State && !History.emulated.pushState ) {
				// Hash is a state so skip the setHash
				//History.debug('History.setHash: Hash is a state so skipping the hash set with a direct pushState call',arguments);

				// PushState
				History.pushState(State.data,State.title,State.url,false);
			}
			else if ( History.getHash() !== hash ) {
				// Hash is a proper hash, so apply it

				// Handle browser bugs
				if ( History.bugs.setHash ) {
					// Fix Safari Bug https://bugs.webkit.org/show_bug.cgi?id=56249

					// Fetch the base page
					pageUrl = History.getPageUrl();

					// Safari hash apply
					History.pushState(null,null,pageUrl+'#'+hash,false);
				}
				else {
					// Normal hash apply
					document.location.hash = hash;
				}
			}

			// Chain
			return History;
		};

		/**
		 * History.escape()
		 * normalize and Escape a Hash
		 * @return {string}
		 */
		History.escapeHash = function(hash){
			// Prepare
			var result = History.normalizeHash(hash);

			// Escape hash
			result = window.encodeURIComponent(result);

			// IE6 Escape Bug
			if ( !History.bugs.hashEscape ) {
				// Restore common parts
				result = result
					.replace(/\%21/g,'!')
					.replace(/\%26/g,'&')
					.replace(/\%3D/g,'=')
					.replace(/\%3F/g,'?');
			}

			// Return result
			return result;
		};

		/**
		 * History.getHashByUrl(url)
		 * Extracts the Hash from a URL
		 * @param {string} url
		 * @return {string} url
		 */
		History.getHashByUrl = function(url){
			// Extract the hash
			var hash = String(url)
				.replace(/([^#]*)#?([^#]*)#?(.*)/, '$2')
				;

			// Unescape hash
			hash = History.unescapeHash(hash);

			// Return hash
			return hash;
		};

		/**
		 * History.setTitle(title)
		 * Applies the title to the document
		 * @param {State} newState
		 * @return {Boolean}
		 */
		History.setTitle = function(newState){
			// Prepare
			var title = newState.title,
				firstState;

			// Initial
			if ( !title ) {
				firstState = History.getStateByIndex(0);
				if ( firstState && firstState.url === newState.url ) {
					title = firstState.title||History.options.initialTitle;
				}
			}

			// Apply
			try {
				document.getElementsByTagName('title')[0].innerHTML = title.replace('<','&lt;').replace('>','&gt;').replace(' & ',' &amp; ');
			}
			catch ( Exception ) { }
			document.title = title;

			// Chain
			return History;
		};


		// ====================================================================
		// Queueing

		/**
		 * History.queues
		 * The list of queues to use
		 * First In, First Out
		 */
		History.queues = [];

		/**
		 * History.busy(value)
		 * @param {boolean} value [optional]
		 * @return {boolean} busy
		 */
		History.busy = function(value){
			// Apply
			if ( typeof value !== 'undefined' ) {
				//History.debug('History.busy: changing ['+(History.busy.flag||false)+'] to ['+(value||false)+']', History.queues.length);
				History.busy.flag = value;
			}
			// Default
			else if ( typeof History.busy.flag === 'undefined' ) {
				History.busy.flag = false;
			}

			// Queue
			if ( !History.busy.flag ) {
				// Execute the next item in the queue
				clearTimeout(History.busy.timeout);
				var fireNext = function(){
					var i, queue, item;
					if ( History.busy.flag ) return;
					for ( i=History.queues.length-1; i >= 0; --i ) {
						queue = History.queues[i];
						if ( queue.length === 0 ) continue;
						item = queue.shift();
						History.fireQueueItem(item);
						History.busy.timeout = setTimeout(fireNext,History.options.busyDelay);
					}
				};
				History.busy.timeout = setTimeout(fireNext,History.options.busyDelay);
			}

			// Return
			return History.busy.flag;
		};

		/**
		 * History.busy.flag
		 */
		History.busy.flag = false;

		/**
		 * History.fireQueueItem(item)
		 * Fire a Queue Item
		 * @param {Object} item
		 * @return {Mixed} result
		 */
		History.fireQueueItem = function(item){
			return item.callback.apply(item.scope||History,item.args||[]);
		};

		/**
		 * History.pushQueue(callback,args)
		 * Add an item to the queue
		 * @param {Object} item [scope,callback,args,queue]
		 */
		History.pushQueue = function(item){
			// Prepare the queue
			History.queues[item.queue||0] = History.queues[item.queue||0]||[];

			// Add to the queue
			History.queues[item.queue||0].push(item);

			// Chain
			return History;
		};

		/**
		 * History.queue (item,queue), (func,queue), (func), (item)
		 * Either firs the item now if not busy, or adds it to the queue
		 */
		History.queue = function(item,queue){
			// Prepare
			if ( typeof item === 'function' ) {
				item = {
					callback: item
				};
			}
			if ( typeof queue !== 'undefined' ) {
				item.queue = queue;
			}

			// Handle
			if ( History.busy() ) {
				History.pushQueue(item);
			} else {
				History.fireQueueItem(item);
			}

			// Chain
			return History;
		};

		/**
		 * History.clearQueue()
		 * Clears the Queue
		 */
		History.clearQueue = function(){
			History.busy.flag = false;
			History.queues = [];
			return History;
		};


		// ====================================================================
		// IE Bug Fix

		/**
		 * History.stateChanged
		 * States whether or not the state has changed since the last double check was initialised
		 */
		History.stateChanged = false;

		/**
		 * History.doubleChecker
		 * Contains the timeout used for the double checks
		 */
		History.doubleChecker = false;

		/**
		 * History.doubleCheckComplete()
		 * Complete a double check
		 * @return {History}
		 */
		History.doubleCheckComplete = function(){
			// Update
			History.stateChanged = true;

			// Clear
			History.doubleCheckClear();

			// Chain
			return History;
		};

		/**
		 * History.doubleCheckClear()
		 * Clear a double check
		 * @return {History}
		 */
		History.doubleCheckClear = function(){
			// Clear
			if ( History.doubleChecker ) {
				clearTimeout(History.doubleChecker);
				History.doubleChecker = false;
			}

			// Chain
			return History;
		};

		/**
		 * History.doubleCheck()
		 * Create a double check
		 * @return {History}
		 */
		History.doubleCheck = function(tryAgain){
			// Reset
			History.stateChanged = false;
			History.doubleCheckClear();

			// Fix IE6,IE7 bug where calling history.back or history.forward does not actually change the hash (whereas doing it manually does)
			// Fix Safari 5 bug where sometimes the state does not change: https://bugs.webkit.org/show_bug.cgi?id=42940
			if ( History.bugs.ieDoubleCheck ) {
				// Apply Check
				History.doubleChecker = setTimeout(
					function(){
						History.doubleCheckClear();
						if ( !History.stateChanged ) {
							//History.debug('History.doubleCheck: State has not yet changed, trying again', arguments);
							// Re-Attempt
							tryAgain();
						}
						return true;
					},
					History.options.doubleCheckInterval
				);
			}

			// Chain
			return History;
		};


		// ====================================================================
		// Safari Bug Fix

		/**
		 * History.safariStatePoll()
		 * Poll the current state
		 * @return {History}
		 */
		History.safariStatePoll = function(){
			// Poll the URL

			// Get the Last State which has the new URL
			var
				urlState = History.extractState(History.getLocationHref()),
				newState;

			// Check for a difference
			if ( !History.isLastSavedState(urlState) ) {
				newState = urlState;
			}
			else {
				return;
			}

			// Check if we have a state with that url
			// If not create it
			if ( !newState ) {
				//History.debug('History.safariStatePoll: new');
				newState = History.createStateObject();
			}

			// Apply the New State
			//History.debug('History.safariStatePoll: trigger');
			History.Adapter.trigger(window,'popstate');

			// Chain
			return History;
		};


		// ====================================================================
		// State Aliases

		/**
		 * History.back(queue)
		 * Send the browser history back one item
		 * @param {Integer} queue [optional]
		 */
		History.back = function(queue){
			//History.debug('History.back: called', arguments);

			// Handle Queueing
			if ( queue !== false && History.busy() ) {
				// Wait + Push to Queue
				//History.debug('History.back: we must wait', arguments);
				History.pushQueue({
					scope: History,
					callback: History.back,
					args: arguments,
					queue: queue
				});
				return false;
			}

			// Make Busy + Continue
			History.busy(true);

			// Fix certain browser bugs that prevent the state from changing
			History.doubleCheck(function(){
				History.back(false);
			});

			// Go back
			history.go(-1);

			// End back closure
			return true;
		};

		/**
		 * History.forward(queue)
		 * Send the browser history forward one item
		 * @param {Integer} queue [optional]
		 */
		History.forward = function(queue){
			//History.debug('History.forward: called', arguments);

			// Handle Queueing
			if ( queue !== false && History.busy() ) {
				// Wait + Push to Queue
				//History.debug('History.forward: we must wait', arguments);
				History.pushQueue({
					scope: History,
					callback: History.forward,
					args: arguments,
					queue: queue
				});
				return false;
			}

			// Make Busy + Continue
			History.busy(true);

			// Fix certain browser bugs that prevent the state from changing
			History.doubleCheck(function(){
				History.forward(false);
			});

			// Go forward
			history.go(1);

			// End forward closure
			return true;
		};

		/**
		 * History.go(index,queue)
		 * Send the browser history back or forward index times
		 * @param {Integer} queue [optional]
		 */
		History.go = function(index,queue){
			//History.debug('History.go: called', arguments);

			// Prepare
			var i;

			// Handle
			if ( index > 0 ) {
				// Forward
				for ( i=1; i<=index; ++i ) {
					History.forward(queue);
				}
			}
			else if ( index < 0 ) {
				// Backward
				for ( i=-1; i>=index; --i ) {
					History.back(queue);
				}
			}
			else {
				throw new Error('History.go: History.go requires a positive or negative integer passed.');
			}

			// Chain
			return History;
		};


		// ====================================================================
		// HTML5 State Support

		// Non-Native pushState Implementation
		if ( History.emulated.pushState ) {
			/*
			 * Provide Skeleton for HTML4 Browsers
			 */

			// Prepare
			var emptyFunction = function(){};
			History.pushState = History.pushState||emptyFunction;
			History.replaceState = History.replaceState||emptyFunction;
		} // History.emulated.pushState

		// Native pushState Implementation
		else {
			/*
			 * Use native HTML5 History API Implementation
			 */

			/**
			 * History.onPopState(event,extra)
			 * Refresh the Current State
			 */
			History.onPopState = function(event,extra){
				// Prepare
				var stateId = false, newState = false, currentHash, currentState;

				// Reset the double check
				History.doubleCheckComplete();

				// Check for a Hash, and handle apporiatly
				currentHash = History.getHash();
				if ( currentHash ) {
					// Expand Hash
					currentState = History.extractState(currentHash||History.getLocationHref(),true);
					if ( currentState ) {
						// We were able to parse it, it must be a State!
						// Let's forward to replaceState
						//History.debug('History.onPopState: state anchor', currentHash, currentState);
						History.replaceState(currentState.data, currentState.title, currentState.url, false);
					}
					else {
						// Traditional Anchor
						//History.debug('History.onPopState: traditional anchor', currentHash);
						History.Adapter.trigger(window,'anchorchange');
						History.busy(false);
					}

					// We don't care for hashes
					History.expectedStateId = false;
					return false;
				}

				// Ensure
				stateId = History.Adapter.extractEventData('state',event,extra) || false;

				// Fetch State
				if ( stateId ) {
					// Vanilla: Back/forward button was used
					newState = History.getStateById(stateId);
				}
				else if ( History.expectedStateId ) {
					// Vanilla: A new state was pushed, and popstate was called manually
					newState = History.getStateById(History.expectedStateId);
				}
				else {
					// Initial State
					newState = History.extractState(History.getLocationHref());
				}

				// The State did not exist in our store
				if ( !newState ) {
					// Regenerate the State
					newState = History.createStateObject(null,null,History.getLocationHref());
				}

				// Clean
				History.expectedStateId = false;

				// Check if we are the same state
				if ( History.isLastSavedState(newState) ) {
					// There has been no change (just the page's hash has finally propagated)
					//History.debug('History.onPopState: no change', newState, History.savedStates);
					History.busy(false);
					return false;
				}

				// Store the State
				History.storeState(newState);
				History.saveState(newState);

				// Force update of the title
				History.setTitle(newState);

				// Fire Our Event
				History.Adapter.trigger(window,'statechange');
				History.busy(false);

				// Return true
				return true;
			};
			History.Adapter.bind(window,'popstate',History.onPopState);

			/**
			 * History.pushState(data,title,url)
			 * Add a new State to the history object, become it, and trigger onpopstate
			 * We have to trigger for HTML4 compatibility
			 * @param {object} data
			 * @param {string} title
			 * @param {string} url
			 * @return {true}
			 */
			History.pushState = function(data,title,url,queue){
				//History.debug('History.pushState: called', arguments);

				// Check the State
				if ( History.getHashByUrl(url) && History.emulated.pushState ) {
					throw new Error('History.js does not support states with fragement-identifiers (hashes/anchors).');
				}

				// Handle Queueing
				if ( queue !== false && History.busy() ) {
					// Wait + Push to Queue
					//History.debug('History.pushState: we must wait', arguments);
					History.pushQueue({
						scope: History,
						callback: History.pushState,
						args: arguments,
						queue: queue
					});
					return false;
				}

				// Make Busy + Continue
				History.busy(true);

				// Create the newState
				var newState = History.createStateObject(data,title,url);

				// Check it
				if ( History.isLastSavedState(newState) ) {
					// Won't be a change
					History.busy(false);
				}
				else {
					// Store the newState
					History.storeState(newState);
					History.expectedStateId = newState.id;

					// Push the newState
					history.pushState(newState.id,newState.title,newState.url);

					// Fire HTML5 Event
					History.Adapter.trigger(window,'popstate');
				}

				// End pushState closure
				return true;
			};

			/**
			 * History.replaceState(data,title,url)
			 * Replace the State and trigger onpopstate
			 * We have to trigger for HTML4 compatibility
			 * @param {object} data
			 * @param {string} title
			 * @param {string} url
			 * @return {true}
			 */
			History.replaceState = function(data,title,url,queue){
				//History.debug('History.replaceState: called', arguments);

				// Check the State
				if ( History.getHashByUrl(url) && History.emulated.pushState ) {
					throw new Error('History.js does not support states with fragement-identifiers (hashes/anchors).');
				}

				// Handle Queueing
				if ( queue !== false && History.busy() ) {
					// Wait + Push to Queue
					//History.debug('History.replaceState: we must wait', arguments);
					History.pushQueue({
						scope: History,
						callback: History.replaceState,
						args: arguments,
						queue: queue
					});
					return false;
				}

				// Make Busy + Continue
				History.busy(true);

				// Create the newState
				var newState = History.createStateObject(data,title,url);

				// Check it
				if ( History.isLastSavedState(newState) ) {
					// Won't be a change
					History.busy(false);
				}
				else {
					// Store the newState
					History.storeState(newState);
					History.expectedStateId = newState.id;

					// Push the newState
					history.replaceState(newState.id,newState.title,newState.url);

					// Fire HTML5 Event
					History.Adapter.trigger(window,'popstate');
				}

				// End replaceState closure
				return true;
			};

		} // !History.emulated.pushState


		// ====================================================================
		// Initialise

		/**
		 * Load the Store
		 */
		if ( sessionStorage ) {
			// Fetch
			try {
				History.store = JSON.parse(sessionStorage.getItem('History.store'))||{};
			}
			catch ( err ) {
				History.store = {};
			}

			// Normalize
			History.normalizeStore();
		}
		else {
			// Default Load
			History.store = {};
			History.normalizeStore();
		}

		/**
		 * Clear Intervals on exit to prevent memory leaks
		 */
		History.Adapter.bind(window,"unload",History.clearAllIntervals);

		/**
		 * Create the initial State
		 */
		History.saveState(History.storeState(History.extractState(History.getLocationHref(),true)));

		/**
		 * Bind for Saving Store
		 */
		if ( sessionStorage ) {
			// When the page is closed
			History.onUnload = function(){
				// Prepare
				var	currentStore, item, currentStoreString;

				// Fetch
				try {
					currentStore = JSON.parse(sessionStorage.getItem('History.store'))||{};
				}
				catch ( err ) {
					currentStore = {};
				}

				// Ensure
				currentStore.idToState = currentStore.idToState || {};
				currentStore.urlToId = currentStore.urlToId || {};
				currentStore.stateToId = currentStore.stateToId || {};

				// Sync
				for ( item in History.idToState ) {
					if ( !History.idToState.hasOwnProperty(item) ) {
						continue;
					}
					currentStore.idToState[item] = History.idToState[item];
				}
				for ( item in History.urlToId ) {
					if ( !History.urlToId.hasOwnProperty(item) ) {
						continue;
					}
					currentStore.urlToId[item] = History.urlToId[item];
				}
				for ( item in History.stateToId ) {
					if ( !History.stateToId.hasOwnProperty(item) ) {
						continue;
					}
					currentStore.stateToId[item] = History.stateToId[item];
				}

				// Update
				History.store = currentStore;
				History.normalizeStore();

				// In Safari, going into Private Browsing mode causes the
				// Session Storage object to still exist but if you try and use
				// or set any property/function of it it throws the exception
				// "QUOTA_EXCEEDED_ERR: DOM Exception 22: An attempt was made to
				// add something to storage that exceeded the quota." infinitely
				// every second.
				currentStoreString = JSON.stringify(currentStore);
				try {
					// Store
					sessionStorage.setItem('History.store', currentStoreString);
				}
				catch (e) {
					if (e.code === DOMException.QUOTA_EXCEEDED_ERR) {
						if (sessionStorage.length) {
							// Workaround for a bug seen on iPads. Sometimes the quota exceeded error comes up and simply
							// removing/resetting the storage can work.
							sessionStorage.removeItem('History.store');
							sessionStorage.setItem('History.store', currentStoreString);
						} else {
							// Otherwise, we're probably private browsing in Safari, so we'll ignore the exception.
						}
					} else {
						throw e;
					}
				}
			};

			// For Internet Explorer
			History.intervalList.push(setInterval(History.onUnload,History.options.storeInterval));

			// For Other Browsers
			History.Adapter.bind(window,'beforeunload',History.onUnload);
			History.Adapter.bind(window,'unload',History.onUnload);

			// Both are enabled for consistency
		}

		// Non-Native pushState Implementation
		if ( !History.emulated.pushState ) {
			// Be aware, the following is only for native pushState implementations
			// If you are wanting to include something for all browsers
			// Then include it above this if block

			/**
			 * Setup Safari Fix
			 */
			if ( History.bugs.safariPoll ) {
				History.intervalList.push(setInterval(History.safariStatePoll, History.options.safariPollInterval));
			}

			/**
			 * Ensure Cross Browser Compatibility
			 */
			if ( navigator.vendor === 'Apple Computer, Inc.' || (navigator.appCodeName||'') === 'Mozilla' ) {
				/**
				 * Fix Safari HashChange Issue
				 */

				// Setup Alias
				History.Adapter.bind(window,'hashchange',function(){
					History.Adapter.trigger(window,'popstate');
				});

				// Initialise Alias
				if ( History.getHash() ) {
					History.Adapter.onDomLoad(function(){
						History.Adapter.trigger(window,'hashchange');
					});
				}
			}

		} // !History.emulated.pushState


	}; // History.initCore

	// Try to Initialise History
	if (!History.options || !History.options.delayInit) {
		History.init();
	}

})(window);

/*=======================================================================================
* Fire Tap Event
*! jquery.finger - v0.1.4 - 2015-12-02
* https://github.com/ngryman/jquery.finger
* Copyright (c) 2015 Nicolas Gryman; Licensed MIT
*=======================================================================================*/

!(function (factory) {
	if (typeof define === 'function' && define.amd)
		define(['jquery'], factory);
	else if (typeof exports === 'object')
		factory(require('jquery'));
	else
		factory(jQuery);
}(function ($) {

	var ua = navigator.userAgent,
		isChrome = /chrome/i.exec(ua),
		isAndroid = /android/i.exec(ua),
		hasTouch = 'ontouchstart' in window && !(isChrome && !isAndroid),
		startEvent = hasTouch ? 'touchstart' : 'mousedown',
		stopEvent = hasTouch ? 'touchend touchcancel' : 'mouseup mouseleave',
		moveEvent = hasTouch ? 'touchmove' : 'mousemove',

		namespace = 'finger',
		rootEl = $('html')[0],

		start = {},
		move = {},
		motion,
		cancel,
		safeguard,
		timeout,
		prevEl,
		prevTime,

		Finger = $.Finger = {
			pressDuration: 300,
			doubleTapInterval: 300,
			flickDuration: 150,
			motionThreshold: 5
		};

	function preventDefault(event) {
		event.preventDefault();
		$.event.remove(rootEl, 'click', preventDefault);
	}

	function page(coord, event) {
		return (hasTouch ? event.originalEvent.touches[0] : event)['page' + coord.toUpperCase()];
	}

	function trigger(event, evtName, remove) {
		var fingerEvent = $.Event(evtName, move);
		$.event.trigger(fingerEvent, { originalEvent: event }, event.target);

		if (fingerEvent.isDefaultPrevented()) {
			if (~evtName.indexOf('tap') && !hasTouch)
				$.event.add(rootEl, 'click', preventDefault);
			else
				event.preventDefault();
		}

		if (remove) {
			$.event.remove(rootEl, moveEvent + '.' + namespace, moveHandler);
			$.event.remove(rootEl, stopEvent + '.' + namespace, stopHandler);
		}
	}

	function startHandler(event) {
		var timeStamp = event.timeStamp || +new Date();

		if (safeguard == timeStamp) return;
		safeguard = timeStamp;

		//get event.target attribute by kiere@kimsq.com
		var isInSwiper=$(event.target).parent().data('swiper') || $(event.target).data('swiper');
		var pressDuration;
		if(isInSwiper)  pressDuration=150;
		else pressDuration=1000;

		// initializes data
		start.x = move.x = page('x', event);
		start.y = move.y = page('y', event);
		start.time = timeStamp;
		start.target = event.target;
		move.orientation = null;
		move.end = false;
		motion = false;
		cancel = false;
		timeout = setTimeout(function() {
			cancel = true;
			trigger(event, 'press');
		}, pressDuration);

		$.event.add(rootEl, moveEvent + '.' + namespace, moveHandler);
		$.event.add(rootEl, stopEvent + '.' + namespace, stopHandler);

		// global prevent default
		if (Finger.preventDefault) {
			event.preventDefault();
			$.event.add(rootEl, 'click', preventDefault);
		}
	}

	function moveHandler(event) {
		// motion data
		move.x = page('x', event);
		move.y = page('y', event);
		move.dx = move.x - start.x;
		move.dy = move.y - start.y;
		move.adx = Math.abs(move.dx);
		move.ady = Math.abs(move.dy);

		// security
		motion = move.adx > Finger.motionThreshold || move.ady > Finger.motionThreshold;
		if (!motion) return;

		// moves cancel press events
		clearTimeout(timeout);

		// orientation
		if (!move.orientation) {
			if (move.adx > move.ady) {
				move.orientation = 'horizontal';
				move.direction = move.dx > 0 ? +1 : -1;
			}
			else {
				move.orientation = 'vertical';
				move.direction = move.dy > 0 ? +1 : -1;
			}
		}

		// for delegated events, the target may change over time
		// this ensures we notify the right target and simulates the mouseleave behavior
		while (event.target && event.target !== start.target)
			event.target = event.target.parentNode;
		if (event.target !== start.target) {
			event.target = start.target;
			stopHandler.call(this, $.Event(stopEvent + '.' + namespace, event));
			return;
		}

		// fire drag event
		trigger(event, 'drag');
	}

	function stopHandler(event) {
		var timeStamp = event.timeStamp || +new Date(),
			dt = timeStamp - start.time,
			evtName;

		// always clears press timeout
		clearTimeout(timeout);

		// tap-like events
		// triggered only if targets match
		if (!motion && !cancel && event.target === start.target) {
			var doubleTap = prevEl === event.target && timeStamp - prevTime < Finger.doubleTapInterval;
			evtName = doubleTap ? 'doubletap' : 'tap';
			prevEl = doubleTap ? null : start.target;
			prevTime = timeStamp;
		}
		// motion events
		else {
			// ensure last target is set the initial one
			event.target = start.target;
			if (dt < Finger.flickDuration) trigger(event, 'flick');
			move.end = true;
			evtName = 'drag';
		}

		trigger(event, evtName, true);
	}

	// initial binding
	$.event.add(rootEl, startEvent + '.' + namespace, startHandler);

	// expose events as methods
	$.each('tap doubletap press drag flick'.split(' '), function(i, name) {
		$.fn[name] = function(fn) {
			return fn ? this.on(name, fn) : this.trigger(name);
		};
	});

	return Finger;

}));
/* ========================================================================
 * Ratchet Plus: Utility.js v1.0.0
 * http://rc.kimsq.com/controls/utility/
 * ========================================================================
 * inspired by @twbs's bootstrap & ratchet
 * Copyright 2016 redblock inc.
 * Author kiere (kiere@kimsq.com)
 * Licensed under MIT.
 * ======================================================================== */

!(function($){
      'use strict';
      var Utility = function(elem, options){
            this.elem = elem;
            this.$elem = $(elem);
            this.options = options;
            this.metadata=this.$elem.data('utility-option'); // 엘리먼트 기준
       };

      Utility.VERSION  = '1.1.0'
      Utility.DEFAULTS = {}

      Utility.prototype.init=function(){
            this.config=$.extend({}, this.defaults, this.options);
            return this;
      }

      Utility.prototype.setdataVal=function(component,dataAttr){
            $.each(dataAttr,function(key,val){
                 var target=$(component).find('[data-role="'+key+'"]');
                 var strVal=String(val);
                 var valArr=strVal.split('::');
                 if(valArr.length ==2){
                     var valType=valArr[0];
                     var valName=valArr[1];
                     if(valType=='bg') $(target).css('background-image','url('+val+')');
                     else if(valType=='img') $(target).attr('src',val);
                     else if(valType=='inputText') $(target).val(val);
                     else if(valType=='html') $(target).html(val);
                 }else{
                     $(target).text(val);
                 }
            });
      }

      Utility.prototype.addHistoryObject=function(object,title,url){
            var _url=url!=null?url:'##';
            History.pushState(object, title, _url);
      }

      Utility.prototype.resetHistoryObject=function(objType,objTarget){
            var ctime=300;
            if(objType=='page'){
                  var object=objTarget.load;
                  $(object).page('historyHide');
            }else if(objType=='modal'){
                  var object=objTarget;
                  $(object).removeClass('active');
                  setTimeout(function(){$(object).hide();},ctime);
                  $(object).modal('historyHide');
            }else if(objType=='popover' || objType=='popup' || objType=='sheet' || objType=='fbutton' || objType=='drawer'  ){
                  var object=objTarget.id;
                  var bcontainer=objTarget.bcontainer;
                  var backdrop=objTarget.backdrop;
                  var placement=objTarget.placement;
                  $(object).removeClass('active');
                  if(objType!='fbutton' && objType!='drawer') setTimeout(function(){$(object).hide();},ctime);
                  if(backdrop) $(bcontainer).find('.backdrop').remove();
                  if(objType=='popover') $(object).popover('historyHide');
                  else if(objType=='sheet') $(object).sheet('historyHide');
                  else if(objType=='popup') $(object).popup('historyHide');
                  else if(objType=='fbutton') $(object).fbutton('historyHide');
                  else if(objType=='drawer') $(object).drawer('historyHide');
            }
             // object 입력내용 초기화 (object 공통내용)
             $(object).find('[data-role="title"]').html('');
             $(object).find('[data-role="content"]').html('');
             $(object).find('[data-role="coverImg"]').css('background-image','url()'); // 커버이미지 초기화(배경타입)
             $(object).find('[data-role="cover-img"]').attr('src',''); // 커버이미지 초기화 (이미지 타입 )
             $(object).find('[data-role="focus"]').blur();// 포커싱한 것 초기화
      }

      Utility.prototype.popComponentState=function(e){
            var CurrentIndex=History.getCurrentIndex();
            var ForwardIndex=parseInt(CurrentIndex)-1;
            var ForwardObj=History.getStateByIndex(ForwardIndex); // 직전 object
            var ForwardObj=JSON.stringify(ForwardObj);
            var result=$.parseJSON(ForwardObj);
            //History.log('직전 history : state =' +ForwardObj+'/ index='+ForwardIndex);
            var objType=result.data.type; // modal, page, popover, popup,...
            var objTarget=result.data.target; // modal, page, popover..의 id 정보
            var utility=new Utility(objTarget,null).init();
            utility.resetHistoryObject(objType,objTarget);
      }

      // push bind Affix
      var checkScroll=function(){
          $('[data-control="scroll"]').each(function () {
		      var $spy = $(this)
		      var data = $spy.data()
                 data.offset = data.offset || {}

		      if (data.offsetBottom != null) data.offset.bottom = data.offsetBottom
		      if (data.offsetTop    != null) data.offset.top    = data.offsetTop

                 $spy.scroll($(this).data());

	    })
      }

      window.addEventListener('push', checkScroll);

       // history.back
      $(document).on('tap','[data-history="back"]',function(e){
             e.preventDefault();
             history.back();
       });


   // Scroll Top
 	$(document).on('tap click', '[data-scroll="top"]', function(e) {
     var button=e.currentTarget;
     var target=$(button).data('target')?$(button).data('target'):'';
     var speed=$(button).data('speed')?$(button).data('speed'):'fast';
     if (target) {
       $(target).find('.content').animate({scrollTop: 0},speed);
     } else {
       $('.content').animate({scrollTop: 0},speed);
     }
     return false;
 	});

	// Document Reload
	$(document).on('tap click', '[data-location="reload"]', function() {
    var text =  $(this).attr("data-text");
    if (text) $.loader({ text: text });
    window.location.reload();
	});

  var utility=new Utility(null,null).init();
  window.addEventListener('popstate', utility.popComponentState);

  window.Utility = Utility;

})(jQuery);

/* ========================================================================
 * Ratchet Plus: Push.js v1.0.0
 * http://rc.kimsq.com/controls/push/
 * ========================================================================
 * inspired by Ratchet push.js
 * Copyright 2016 redblock inc.
 * Author kiere (kiere@kimsq.com)
 * Licensed under MIT.
 * ======================================================================== */

/* global _gaq: true */

!(function () {
  'use strict';

  var noop = function () {};


  // Pushstate caching
  // ==================

  var isScrolling;
  var maxCacheLength = 20;
  var cacheMapping   = sessionStorage;
  var domCache       = {};
  var transitionMap  = {
    slideIn  : 'slide-out',
    slideOut : 'slide-in',
    fade     : 'fade'
  };

  var bars = {
    bartab             : '.bar-tab',
    barnav             : '.bar-nav',
    barfooter          : '.bar-footer',
    barheadersecondary : '.bar-header-secondary'
  };

  var cacheReplace = function (data, updates) {
    PUSH.id = data.id;
    if (updates) {
      data = getCached(data.id);
    }
    cacheMapping[data.id] = JSON.stringify(data);
    window.history.replaceState(data.id, data.title, data.url);
    domCache[data.id] = document.body.cloneNode(true);
  };

  var cachePush = function () {
    var id = PUSH.id;

    var cacheForwardStack = JSON.parse(cacheMapping.cacheForwardStack || '[]');
    var cacheBackStack    = JSON.parse(cacheMapping.cacheBackStack    || '[]');

    cacheBackStack.push(id);

    while (cacheForwardStack.length) {
      delete cacheMapping[cacheForwardStack.shift()];
    }
    while (cacheBackStack.length > maxCacheLength) {
      delete cacheMapping[cacheBackStack.shift()];
    }

    window.history.pushState(null, '', cacheMapping[PUSH.id].url);

    cacheMapping.cacheForwardStack = JSON.stringify(cacheForwardStack);
    cacheMapping.cacheBackStack    = JSON.stringify(cacheBackStack);
  };

  var cachePop = function (id, direction) {
    var forward           = direction === 'forward';
    var cacheForwardStack = JSON.parse(cacheMapping.cacheForwardStack || '[]');
    var cacheBackStack    = JSON.parse(cacheMapping.cacheBackStack    || '[]');
    var pushStack         = forward ? cacheBackStack    : cacheForwardStack;
    var popStack          = forward ? cacheForwardStack : cacheBackStack;

    if (PUSH.id) {
      pushStack.push(PUSH.id);
    }
    popStack.pop();

    cacheMapping.cacheForwardStack = JSON.stringify(cacheForwardStack);
    cacheMapping.cacheBackStack    = JSON.stringify(cacheBackStack);
  };

  var getCached = function (id) {
    return JSON.parse(cacheMapping[id] || null) || {};
  };

  var getTarget = function (e) {
    var target = findTarget(e.target);

    if (!target ||
        e.which > 1 ||
        e.metaKey ||
        e.ctrlKey ||
        isScrolling ||
        location.protocol !== target.protocol ||
        location.host     !== target.host ||
        !target.hash && /#/.test(target.href) ||
        target.hash && target.href.replace(target.hash, '') === location.href.replace(location.hash, '') ||
        target.getAttribute('data-ignore') === 'push') { return; }

    return target;
  };


  // Main event handlers (touchend, popstate)
  // ==========================================

  var touchend = function (e) {
    var target = getTarget(e);

    if (!target) {
      return;
    }

    e.preventDefault();

    PUSH({
      url        : target.href,
      hash       : target.hash,
      timeout    : target.getAttribute('data-timeout'),
      transition : target.getAttribute('data-transition')
    });
  };

   // popstate 이벤트(백버튼) 체크 함수
   var checkPopstate=function(){
        var CurrentIndex=History.getCurrentIndex();
        var CurrentObj=History.getStateByIndex(CurrentIndex);
        CurrentObj=JSON.stringify(CurrentObj);
        var ForwardIndex=parseInt(CurrentIndex)-1;
        var ForwardObj=History.getStateByIndex(ForwardIndex); // 직전 object
        var ForwardObj=JSON.stringify(ForwardObj);
        var result=$.parseJSON(ForwardObj);
        //History.log('직전 history : state =' +ForwardObj+'/ index='+ForwardIndex);
        var objType=result.data.type; // modal, page, popover, popup,...
        var objTarget=result.data.target; // modal, page, popover..의 id 정보
        return [objType,objTarget];
   };

  var popstate = function (e) {
    var key;
    var barElement;
    var activeObj;
    var activeDom;
    var direction;
    var transition;
    var transitionFrom;
    var transitionFromObj;
    var id = e.state;

    if (!id || !cacheMapping[id]) {
      return;
    }
    // 컴포넌트 back 버튼 회피
    var checkPop=checkPopstate();
    var objType=checkPop[0];

    if(objType!=undefined) return;
    else {
       direction = PUSH.id < id ? 'forward' : 'back';

        cachePop(id, direction);

        activeObj = getCached(id);
        activeDom = domCache[id];

        if (activeObj.title) {
          document.title = activeObj.title;
        }

        if (direction === 'back') {
          transitionFrom    = JSON.parse(direction === 'back' ? cacheMapping.cacheForwardStack : cacheMapping.cacheBackStack);
          transitionFromObj = getCached(transitionFrom[transitionFrom.length - 1]);
        } else {
          transitionFromObj = activeObj;
        }

        if (direction === 'back' && !transitionFromObj.id) {
          return (PUSH.id = id);
        }

        transition = direction === 'back' ? transitionMap[transitionFromObj.transition] : transitionFromObj.transition;
        //console.log(activeDom);

        if (!activeDom) {
          return PUSH({
            id         : activeObj.id,
            url        : activeObj.url,
            title      : activeObj.title,
            timeout    : activeObj.timeout,
            transition : transition,
            ignorePush : true
          });
        }

        if (transitionFromObj.transition) {
          activeObj = extendWithDom(activeObj, '[data-push="swap"]', activeDom.cloneNode(true));
          for (key in bars) {
            if (bars.hasOwnProperty(key)) {
              barElement = document.querySelector(bars[key]);
              if (activeObj[key]) {
                swapContent(activeObj[key], barElement);
              } else if (barElement) {
                barElement.parentNode.removeChild(barElement);
              }
            }
          }
        }

        swapContent(
          (activeObj.contents || activeDom).cloneNode(true),
          document.querySelector('[data-push="swap"]'),
          transition
        );

        PUSH.id = id;

        document.body.offsetHeight; // force reflow to prevent scroll
    }


  };


  // Core PUSH functionality
  // =======================

  var PUSH = function (options) {
    var key;
    var xhr = PUSH.xhr;

    options.container = options.container || options.transition ? document.querySelector('[data-push="swap"]') : document.body;

    for (key in bars) {
      if (bars.hasOwnProperty(key)) {
        options[key] = options[key] || document.querySelector(bars[key]);
      }
    }

    if (xhr && xhr.readyState < 4) {
      xhr.onreadystatechange = noop;
      xhr.abort();
    }

    xhr = new XMLHttpRequest();
    xhr.open('GET', options.url, true);
    xhr.setRequestHeader('X-PUSH', 'true');

    xhr.onreadystatechange = function () {
      if (options._timeout) {
        clearTimeout(options._timeout);
      }
      if (xhr.readyState === 4) {
        xhr.status === 200 ? success(xhr, options) : failure(options.url);
      }
    };

    if (!PUSH.id) {
      cacheReplace({
        id         : +new Date(),
        url        : window.location.href,
        title      : document.title,
        timeout    : options.timeout,
        transition : null
      });
    }

    if (options.timeout) {
      options._timeout = setTimeout(function () {  xhr.abort('timeout'); }, options.timeout);
    }

    xhr.send();

    if (xhr.readyState && !options.ignorePush) {
      cachePush();
    }
  };


  // Main XHR handlers
  // =================

  var success = function (xhr, options) {
    var key;
    var barElement;
    var data = parseXHR(xhr, options);

    if (!data.contents) {
      return locationReplace(options.url);
    }

    if (data.title) {
      document.title = data.title;
    }

    if (options.transition) {
      for (key in bars) {
        if (bars.hasOwnProperty(key)) {
          barElement = document.querySelector(bars[key]);
          if (data[key]) {
            swapContent(data[key], barElement);
          } else if (barElement) {
            barElement.parentNode.removeChild(barElement);
          }
        }
      }
    }

    swapContent(data.contents, options.container, options.transition, function () {
      cacheReplace({
        id         : options.id || +new Date(),
        url        : data.url,
        title      : data.title,
        timeout    : options.timeout,
        transition : options.transition
      }, options.id);
      triggerStateChange();
    });

    if (!options.ignorePush && window._gaq) {
      _gaq.push(['_trackPageview']); // google analytics
    }
    if (!options.hash) {
      return;
    }
  };

  var failure = function (url) {
    throw new Error('Could not get: ' + url);
  };


  // PUSH helpers
  // ============

  var swapContent = function (swap, container, transition, complete) {
    var enter;
    var containerDirection;
    var swapDirection;

    if (!transition) {
      if (container) {
        container.innerHTML = swap.innerHTML;
      } else if (swap.classList.contains('content')) {
        document.body.appendChild(swap);
      } else {
        document.body.insertBefore(swap, document.querySelector('[data-push="swap"]'));
      }
    } else {
      enter  = /in$/.test(transition);

      if (transition === 'fade') {
        container.classList.add('in');
        container.classList.add('fade');
        swap.classList.add('fade');
      }

      if (/slide/.test(transition)) {
        swap.classList.add('sliding-in', enter ? 'right' : 'left');
        swap.classList.add('sliding');
        container.classList.add('sliding');
      }

      container.parentNode.insertBefore(swap, container);
    }

    if (!transition) {
      complete && complete();
    }

    if (transition === 'fade') {
      container.offsetWidth; // force reflow
      container.classList.remove('in');
      var fadeContainerEnd = function () {
        container.removeEventListener('webkitTransitionEnd', fadeContainerEnd);
        swap.classList.add('in');
        swap.addEventListener('webkitTransitionEnd', fadeSwapEnd);
      };
      var fadeSwapEnd = function () {
        swap.removeEventListener('webkitTransitionEnd', fadeSwapEnd);
        container.parentNode.removeChild(container);
        swap.classList.remove('fade');
        swap.classList.remove('in');
        complete && complete();
      };
      container.addEventListener('webkitTransitionEnd', fadeContainerEnd);

    }

    if (/slide/.test(transition)) {
      var slideEnd = function () {
        swap.removeEventListener('webkitTransitionEnd', slideEnd);
        swap.classList.remove('sliding', 'sliding-in');
        swap.classList.remove(swapDirection);
        container.parentNode.removeChild(container);
        complete && complete();
      };

      container.offsetWidth; // force reflow
      swapDirection      = enter ? 'right' : 'left';
      containerDirection = enter ? 'left' : 'right';
      container.classList.add(containerDirection);
      swap.classList.remove(swapDirection);
      swap.addEventListener('webkitTransitionEnd', slideEnd);
    }
  };

  var triggerStateChange = function () {
    var e = new CustomEvent('push', {
      detail: { state: getCached(PUSH.id) },
      bubbles: true,
      cancelable: true
    });

    window.dispatchEvent(e);
  };

  var findTarget = function (target) {
    var i;
    var toggles = document.querySelectorAll('[data-control="push"]');

    for (; target && target !== document; target = target.parentNode) {
      for (i = toggles.length; i--;) {
        if (toggles[i] === target) {
          return target;
        }
      }
    }
  };

  var locationReplace = function (url) {
    window.history.replaceState(null, '', '#');
    window.location.replace(url);
  };

  var extendWithDom = function (obj, fragment, dom) {
    var i;
    var result = {};

    for (i in obj) {
      if (obj.hasOwnProperty(i)) {
        result[i] = obj[i];
      }
    }

    Object.keys(bars).forEach(function (key) {
      var el = dom.querySelector(bars[key]);
      if (el) {
        el.parentNode.removeChild(el);
      }
      result[key] = el;
    });

    result.contents = dom.querySelector(fragment);

    return result;
  };

  var parseXHR = function (xhr, options) {
    var head;
    var body;
    var data = {};
    var responseText = xhr.responseText;

    data.url = options.url;

    if (!responseText) {
      return data;
    }

    if (/<html/i.test(responseText)) {
      head           = document.createElement('div');
      body           = document.createElement('div');
      head.innerHTML = responseText.match(/<head[^>]*>([\s\S.]*)<\/head>/i)[0];
      body.innerHTML = responseText.match(/<body[^>]*>([\s\S.]*)<\/body>/i)[0];
    } else {
      head           = body = document.createElement('div');
      head.innerHTML = responseText;
    }

    data.title = head.querySelector('title');
    var text = 'innerText' in data.title ? 'innerText' : 'textContent';
    data.title = data.title && data.title[text].trim();

    if (options.transition) {
      data = extendWithDom(data, '[data-push="swap"]', body);
    } else {
      data.contents = body;
    }

    return data;
  };


  // Attach PUSH event handlers
  // ==========================

  window.addEventListener('touchstart', function () { isScrolling = false; });
  window.addEventListener('touchmove', function () { isScrolling = true; });
  window.addEventListener('touchend', touchend);
  window.addEventListener('click', touchend);
  window.addEventListener('popstate', popstate);
  window.PUSH = PUSH;

}());
/* ========================================================================
 * Ratchet Plus: Infinite-scroll.js v1.0.0
 * http://rc.kimsq.com/controls/infinite-scroll/
/*=======================================================================
 * Fuel UX Infinite Scroll (Need Above loader plugin )
 * https://github.com/ExactTarget/fuelux/blob/master/js/infinite-scroll.js
 *
 * Copyright (c) 2014 ExactTarget
 * Licensed under the BSD New license.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the
following conditions are met:

    1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following
        disclaimer.

    2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the
        following disclaimer in the documentation and/or other materials provided with the distribution.

    3. Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote
        products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *========================================================================*/


;(function ( $, window, document, undefined ) {

	var old = $.fn.infinitescroll;

	// INFINITE SCROLL CONSTRUCTOR AND PROTOTYPE

	var InfiniteScroll = function (element, options) {
		this.$element = $(element);
		this.$appendToEle=options.appendToEle;
		this.$element.addClass('infinitescroll');
		this.options = $.extend({}, $.fn.infinitescroll.defaults, options);

		this.curScrollTop = this.$element.scrollTop();
		this.curPercentage = this.getPercentage();
		this.fetchingData = false;

		this.$element.on('scroll.fu.infinitescroll', $.proxy(this.onScroll, this));
		this.onScroll();
	};

    // require tab.js & history.js & utilty.js
    if (!$.fn.loader=="undefined") throw new Error('infinite-scroll requires loader.js')


	InfiniteScroll.prototype = {

		constructor: InfiniteScroll,

		destroy: function () {
			this.$element.remove();
			// any external bindings
			// [none]

			// empty elements to return to original markup
			this.$element.empty();

			return this.$element[0].outerHTML;
		},

		disable: function () {
			this.$element.off('scroll.fu.infinitescroll');
		},

		enable: function () {
			this.$element.on('scroll.fu.infinitescroll', $.proxy(this.onScroll, this));
		},

		end: function (content) {
			var end = $('<div class="infinitescroll-end"></div>');
			if (content) {
				end.append(content);
			} else {
				end.append('');
			}

			this.$element.append(end);
			this.disable();
		},

		getPercentage: function () {
			var height = (this.$element.css('box-sizing') === 'border-box') ? this.$element.outerHeight() : this.$element.height();
			var scrollHeight = this.$element.get(0).scrollHeight;
			return (scrollHeight > height) ? ((height / (scrollHeight - this.curScrollTop)) * 100) : 0;
		},

		fetchData: function (force) {
			var load = $('<div class="infinitescroll-load"></div>');
			var self = this;
			var moreBtn;

			var fetch = function () {
				var helpers = {
					percentage: self.curPercentage,
					scrollTop: self.curScrollTop
				};
				var $loader=$('<div class="loader-container d-flex justify-content-center py-4"></div>');
				load.append($loader);
				//$loader.loader();
				$loader.html('<div class="spinner-border spinner-border-sm content-padded text-muted" style="width: 1.5rem; height: 1.5rem;" role="status"><span class="sr-only">Loading...</span></div>');
				if (self.options.dataSource) {
					self.options.dataSource(helpers, function (resp) {
						var end;
						if (resp.content) {
							if(self.$appendToEle) self.$appendToEle.append(resp.content);
							else self.$element.append(resp.content);
						}
            setTimeout(function(){ load.remove(); }, 10);

						if (resp.end) {
							end = (resp.end !== true) ? resp.end : undefined;
							self.end(end);
						}

						self.fetchingData = false;
					});
				}
			};

			this.fetchingData = true;
			this.$element.append(load);
			if (this.options.hybrid && force !== true) {
				moreBtn = $('<button type="button" class="btn btn-secondary btn-block"><span data-role="moreNUM"></span></button>');
				if (typeof this.options.hybrid === 'object') {
					moreBtn.append(this.options.hybrid.label);
				} else {
					moreBtn.append('<span class="rc-icon spinner"></span>');
				}

				moreBtn.on('click.fu.infinitescroll', function () {
					moreBtn.remove();
					fetch();
				});
				load.append(moreBtn);
			} else {
				fetch();
			}
		},

		onScroll: function (e) {
			this.curScrollTop = this.$element.scrollTop();
			this.curPercentage = this.getPercentage();
			if (!this.fetchingData && this.curPercentage >= this.options.percentage) {
				this.fetchData();
			}
		}
	};

	// INFINITE SCROLL PLUGIN DEFINITION

	$.fn.infinitescroll = function (option) {
		var args = Array.prototype.slice.call(arguments, 1);
		var methodReturn;

		var $set = this.each(function () {
			var $this = $(this);
			var data = $this.data('fu.infinitescroll');
			var options = typeof option === 'object' && option;

			if (!data) {
				$this.data('fu.infinitescroll', (data = new InfiniteScroll(this, options)));
			}

			if (typeof option === 'string') {
				methodReturn = data[option].apply(data, args);
			}
		});

		return (methodReturn === undefined) ? $set : methodReturn;
	};

	$.fn.infinitescroll.defaults = {
		dataSource: null,
		hybrid: false,//can be true or an object with structure: { 'label': (markup or jQuery obj) }
		percentage: 95//percentage scrolled to the bottom before more is loaded
	};

	$.fn.infinitescroll.Constructor = InfiniteScroll;

	$.fn.infinitescroll.noConflict = function () {
		$.fn.infinitescroll = old;
		return this;
	};

	// NO DATA-API DUE TO NEED OF DATA-SOURCE

	// -- BEGIN UMD WRAPPER AFTERWORD --
})( jQuery, window, document );
// -- END UMD WRAPPER AFTERWORD --

/* ========================================================================
 * Ratchet Plus: Loader.js v1.0.0
 * http://rc.kimsq.com/controls/loader/
/*=======================================================================

/* ========================================================================
* Loading plugin for jQuery
* version: v1.0.6
 * ========================================================================
* @author Laurent Blanes <laurent.blanes@gmail.com>
* Copyright 2013, Laurent Blanes ( https://github.com/hekigan/is-loading )
* The MIT License (MIT)
* Copyright (c) 2013 Laurent Blanes
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*/
/* ========================================================================*/

;(function ( $, window, document, undefined ) {

    // Create the defaults once
    var pluginName = "loader",
        defaults = {
            'position': "block",        // right | inside | overlay
            'text': "",                 // Text to display next to the loader
            'theme': "default",    // loader CSS class
            'tpl': '<span class="loader-wrapper %wrapper% %theme%"><i class="loader">Loading...</i>%text%</span>',    // loader base Tag
            'disableSource': true,      // true | false
            'disableOthers': []
        };

    // The actual plugin constructor
    function Plugin( element, options ) {
        this.element = element;

        // Merge user options with default ones
        this.options = $.extend( {}, defaults, options );

        this._defaults     = defaults;
        this._name         = pluginName;
        this._loader       = null;                // Contain the loading tag element

        this.init();
    }

    // Contructor function for the plugin (only once on page load)
    function contruct() {

        if ( !$[pluginName] ) {
            $.loader = function( opts ) {
                $( "body" ).loader( opts );
            };
        }
    }

    Plugin.prototype = {

        init: function() {

            if( $( this.element ).is( "body") ) {
                this.options.position = "overlay";
            }
            this.show();
        },

        show: function() {

            var self = this,
            tpl = self.options.tpl.replace( '%wrapper%', '' + 'loader-' + self.options.position );
            tpl = tpl.replace( '%theme%', self.options['theme'] );
            tpl = tpl.replace( '%text%', ( self.options.text !== "" ) ? self.options.text + ' ' : '' );
            self._loader = $( tpl );

            // Disable the element
            if( $( self.element ).is( "input, textarea" ) && true === self.options.disableSource ) {

                $( self.element ).attr( "disabled", "disabled" );

            }
            else if( true === self.options.disableSource ) {

                $( self.element ).addClass( "disabled" );

            }

            // Set position
            switch( self.options.position ) {

                case "inside":
                    $( self.element ).html( self._loader );
                    break;

                case "overlay":
                    var $wrapperTpl = null;

                    if( $( self.element ).is( "body") ) {

                        $wrapperTpl = $('<div class="loader-overlay">');

                        $( "body" ).prepend( $wrapperTpl );

                        $( window ).on('resize', function() {
                            $wrapperTpl.height( $(window).height() + 'px' );
                            self._loader.css({top: ($(window).height()/2 - self._loader.outerHeight()/2) + 'px' });
                        });
                    } else {
                        var cssPosition = $( self.element ).css('position'),
                            pos = {},
                            height = $( self.element ).outerHeight() + 'px',
                            width = '100%'; // $( self.element ).outerWidth() + 'px;

                        if( 'relative' === cssPosition || 'absolute' === cssPosition ) {
                            pos = { 'top': 0,  'left': 0 };
                        } else {
                            pos = $( self.element ).position();
                        }
                        $wrapperTpl = $('<div class="loader-overlay">');
                        $( self.element ).prepend( $wrapperTpl );

                        $( window ).on('resize', function() {
                            $wrapperTpl.height( $( self.element ).outerHeight() + 'px' );
                            self._loader.css({top: ($wrapperTpl.outerHeight()/2 - self._loader.outerHeight()/2) + 'px' });
                        });
                    }

                    $wrapperTpl.html( self._loader );
                    self._loader.css({top: ($wrapperTpl.outerHeight()/2 - self._loader.outerHeight()/2) + 'px' });
                    break;

                default:
                    $( self.element ).after( self._loader );
                    break;
            }

            self.disableOthers();
        },

        hide: function() {


            if( "overlay" === this.options.position ) {

                $( this.element ).find( ".loader-overlay" ).first().remove();

            } else {

                $( this._loader ).remove();
                $( this.element ).text( $( this.element ).attr( "data-isloading-label" ) );

            }

            $( this.element ).removeAttr("disabled").removeClass("disabled");

            this.enableOthers();
        },

        disableOthers: function() {
            $.each(this.options.disableOthers, function( i, e ) {
                var elt = $( e );
                if( elt.is( "button, input, textarea" ) ) {
                    elt.attr( "disabled", "disabled" );
                }
                else {
                    elt.addClass( "disabled" );
                }
            });
        },

        enableOthers: function() {
            $.each(this.options.disableOthers, function( i, e ) {
                var elt = $( e );
                if( elt.is( "button, input, textarea" ) ) {
                    elt.removeAttr( "disabled" );
                }
                else {
                    elt.removeClass( "disabled" );
                }
            });
        }
    };

    // Constructor
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if ( options && "hide" !== options || !$.data( this, "plugin_" + pluginName ) ) {
                $.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
            } else {
                var elt = $.data( this, "plugin_" + pluginName );

                if( "hide" === options )    { elt.hide(); }
                else                        { elt.show(); }
            }
        });
    };

    contruct();

})( jQuery, window, document );

/* ========================================================================
 * Ratchet Plus: Notify.js v1.0.0
 * http://rc.kimsq.com/controls/notify/
 * ========================================================================
 /*
 * Project: Bootstrap Notify = v3.1.5
 * Description: Turns standard Bootstrap alerts into "Growl-like" notifications.
 * Author: Mouse0270 aka Robert McIntosh
 * License: MIT License
 * Website: https://github.com/mouse0270/bootstrap-growl
 */

 /* global define:false, require: false, jQuery:false */

 (function (factory) {
 	if (typeof define === 'function' && define.amd) {
 		// AMD. Register as an anonymous module.
 		define(['jquery'], factory);
 	} else if (typeof exports === 'object') {
 		// Node/CommonJS
 		factory(require('jquery'));
 	} else {
 		// Browser globals
 		factory(jQuery);
 	}
 }(function ($) {
 	// Create the defaults once
 	var defaults = {
 		element: 'body',
 		position: null,
 		type: "default",
 		allow_dismiss: true,
 		allow_duplicates: true,
 		newest_on_top: false,
 		showProgressbar: false,
 		placement: {
 			from: "bottom",
 			align: "center"
 		},
 		offset: 20,
 		spacing: 10,
 		z_index: 1031,
 		delay: 1000,
 		timer: 1000,
 		url_target: '_blank',
 		mouse_over: null,
 		animate: {
 			enter: 'animated fadeInUp',
 			exit: 'animated fadeOutDown'
 		},
 		onShow: null,
 		onShown: null,
 		onClose: null,
 		onClosed: null,
           onClick: null,
 		icon_type: 'class',
 		template: '<span data-notify="container" class="alert alert-{0} col-xs-11 col-sm-4">{2}</span>'
 	};

 	String.format = function () {
 		var str = arguments[0];
 		for (var i = 1; i < arguments.length; i++) {
 			str = str.replace(RegExp("\\{" + (i - 1) + "\\}", "gm"), arguments[i]);
 		}
 		return str;
 	};

 	function isDuplicateNotification(notification) {
 		var isDupe = false;

 		$('[data-notify="container"]').each(function (i, el) {
 			var $el = $(el);
 			var title = $el.find('[data-notify="title"]').html().trim();
 			var message = $el.find('[data-notify="message"]').html().trim();

 			// The input string might be different than the actual parsed HTML string!
 			// (<br> vs <br /> for example)
 			// So we have to force-parse this as HTML here!
 			var isSameTitle = title === $("<div>" + notification.settings.content.title + "</div>").html().trim();
 			var isSameMsg = message === $("<div>" + notification.settings.content.message + "</div>").html().trim();
 			var isSameType = $el.hasClass('alert-' + notification.settings.type);

 			if (isSameTitle && isSameMsg && isSameType) {
 				//we found the dupe. Set the var and stop checking.
 				isDupe = true;
 			}
 			return !isDupe;
 		});

 		return isDupe;
 	}

 	function Notify(element, content, options) {
 		// Setup Content of Notify
 		var contentObj = {
 			content: {
 				message: typeof content === 'object' ? content.message : content,
 				title: content.title ? content.title : '',
 				icon: content.icon ? content.icon : '',
 				url: content.url ? content.url : '#',
 				target: content.target ? content.target : '-'
 			}
 		};

 		options = $.extend(true, {}, contentObj, options);
 		this.settings = $.extend(true, {}, defaults, options);
 		this._defaults = defaults;
 		if (this.settings.content.target === "-") {
 			this.settings.content.target = this.settings.url_target;
 		}
 		this.animations = {
 			start: 'webkitAnimationStart oanimationstart MSAnimationStart animationstart',
 			end: 'webkitAnimationEnd oanimationend MSAnimationEnd animationend'
 		};

 		if (typeof this.settings.offset === 'number') {
 			this.settings.offset = {
 				x: this.settings.offset,
 				y: this.settings.offset
 			};
 		}

 		//if duplicate messages are not allowed, then only continue if this new message is not a duplicate of one that it already showing
 		if (this.settings.allow_duplicates || (!this.settings.allow_duplicates && !isDuplicateNotification(this))) {
 			this.init();
 		}
 	}

 	$.extend(Notify.prototype, {
 		init: function () {
 			var self = this;

 			this.buildNotify();
 			if (this.settings.content.icon) {
 				this.setIcon();
 			}
 			if (this.settings.content.url != "#") {
 				this.styleURL();
 			}
 			this.styleDismiss();
 			this.placement();
 			this.bind();

 			this.notify = {
 				$ele: this.$ele,
 				update: function (command, update) {
 					var commands = {};
 					if (typeof command === "string") {
 						commands[command] = update;
 					} else {
 						commands = command;
 					}
 					for (var cmd in commands) {
 						switch (cmd) {
 							case "type":
 								this.$ele.removeClass('alert-' + self.settings.type);
 								this.$ele.find('[data-notify="progressbar"] > .progress-bar').removeClass('progress-bar-' + self.settings.type);
 								self.settings.type = commands[cmd];
 								this.$ele.addClass('alert-' + commands[cmd]).find('[data-notify="progressbar"] > .progress-bar').addClass('progress-bar-' + commands[cmd]);
 								break;
 							case "icon":
 								var $icon = this.$ele.find('[data-notify="icon"]');
 								if (self.settings.icon_type.toLowerCase() === 'class') {
 									$icon.removeClass(self.settings.content.icon).addClass(commands[cmd]);
 								} else {
 									if (!$icon.is('img')) {
 										$icon.find('img');
 									}
 									$icon.attr('src', commands[cmd]);
 								}
 								self.settings.content.icon = commands[command];
 								break;
 							case "progress":
 								var newDelay = self.settings.delay - (self.settings.delay * (commands[cmd] / 100));
 								this.$ele.data('notify-delay', newDelay);
 								this.$ele.find('[data-notify="progressbar"] > div').attr('aria-valuenow', commands[cmd]).css('width', commands[cmd] + '%');
 								break;
 							case "url":
 								this.$ele.find('[data-notify="url"]').attr('href', commands[cmd]);
 								break;
 							case "target":
 								this.$ele.find('[data-notify="url"]').attr('target', commands[cmd]);
 								break;
 							default:
 								this.$ele.find('[data-notify="' + cmd + '"]').html(commands[cmd]);
 						}
 					}
 					var posX = this.$ele.outerHeight() + parseInt(self.settings.spacing) + parseInt(self.settings.offset.y);
 					self.reposition(posX);
 				},
 				close: function () {
 					self.close();
 				}
 			};

 		},
 		buildNotify: function () {
 			var content = this.settings.content;
 			this.$ele = $(String.format(this.settings.template, this.settings.type, content.title, content.message, content.url, content.target));
 			this.$ele.attr('data-notify-position', this.settings.placement.from + '-' + this.settings.placement.align);
 			if (!this.settings.allow_dismiss) {
 				this.$ele.find('[data-notify="dismiss"]').css('display', 'none');
 			}
 			if ((this.settings.delay <= 0 && !this.settings.showProgressbar) || !this.settings.showProgressbar) {
 				this.$ele.find('[data-notify="progressbar"]').remove();
 			}
 		},
 		setIcon: function () {
 			if (this.settings.icon_type.toLowerCase() === 'class') {
 				this.$ele.find('[data-notify="icon"]').addClass(this.settings.content.icon);
 			} else {
 				if (this.$ele.find('[data-notify="icon"]').is('img')) {
 					this.$ele.find('[data-notify="icon"]').attr('src', this.settings.content.icon);
 				} else {
 					this.$ele.find('[data-notify="icon"]').append('<img src="' + this.settings.content.icon + '" alt="Notify Icon" />');
 				}
 			}
 		},
 		styleDismiss: function () {
 			this.$ele.find('[data-notify="dismiss"]').css({
 				position: 'absolute',
 				right: '10px',
 				top: '5px',
 				zIndex: this.settings.z_index + 2
 			});
 		},
 		styleURL: function () {
 			this.$ele.find('[data-notify="url"]').css({
 				backgroundImage: 'url(data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7)',
 				height: '100%',
 				left: 0,
 				position: 'absolute',
 				top: 0,
 				width: '100%',
 				zIndex: this.settings.z_index + 1
 			});
 		},
 		placement: function () {
 			var self = this,
 				offsetAmt = this.settings.offset.y,
 				css = {
 					display: 'inline-block',
 					margin: '0px auto',
 					position: this.settings.position ? this.settings.position : (this.settings.element === 'body' ? 'fixed' : 'absolute'),
 					transition: 'all .5s ease-in-out',
 					zIndex: this.settings.z_index
 				},
 				hasAnimation = false,
 				settings = this.settings;

 			$('[data-notify-position="' + this.settings.placement.from + '-' + this.settings.placement.align + '"]:not([data-closing="true"])').each(function () {
 				offsetAmt = Math.max(offsetAmt, parseInt($(this).css(settings.placement.from)) + parseInt($(this).outerHeight()) + parseInt(settings.spacing));
 			});
 			if (this.settings.newest_on_top === true) {
 				offsetAmt = this.settings.offset.y;
 			}
 			css[this.settings.placement.from] = offsetAmt + 'px';

 			switch (this.settings.placement.align) {
 				case "left":
 				case "right":
 					css[this.settings.placement.align] = this.settings.offset.x + 'px';
 					break;
 				case "center":
 					css.left = 0;
 					css.right = 0;
 					break;
 			}
 			this.$ele.css(css).addClass(this.settings.animate.enter);
 			$.each(Array('webkit-', 'moz-', 'o-', 'ms-', ''), function (index, prefix) {
 				self.$ele[0].style[prefix + 'AnimationIterationCount'] = 1;
 			});

 			$(this.settings.element).append(this.$ele);

 			if (this.settings.newest_on_top === true) {
 				offsetAmt = (parseInt(offsetAmt) + parseInt(this.settings.spacing)) + this.$ele.outerHeight();
 				this.reposition(offsetAmt);
 			}

 			if ($.isFunction(self.settings.onShow)) {
 				self.settings.onShow.call(this.$ele);
 			}

 			this.$ele.one(this.animations.start, function () {
 				hasAnimation = true;
 			}).one(this.animations.end, function () {
 				self.$ele.removeClass(self.settings.animate.enter);
 				if ($.isFunction(self.settings.onShown)) {
 					self.settings.onShown.call(this);
 				}
 			});

 			setTimeout(function () {
 				if (!hasAnimation) {
 					if ($.isFunction(self.settings.onShown)) {
 						self.settings.onShown.call(this);
 					}
 				}
 			}, 600);
 		},
 		bind: function () {
 			var self = this;

 			this.$ele.find('[data-notify="dismiss"]').on('tap', function () {
 				self.close();
 			});

 			if ($.isFunction(self.settings.onClick)) {
 			    this.$ele.on('tap', function (event) {
 			        if (event.target != self.$ele.find('[data-notify="dismiss"]')[0]) {
 			            self.settings.onClick.call(this, event);
 			        }
 			    });
 			}

 			this.$ele.mouseover(function () {
 				$(this).data('data-hover', "true");
 			}).mouseout(function () {
 				$(this).data('data-hover', "false");
 			});
 			this.$ele.data('data-hover', "false");

 			if (this.settings.delay > 0) {
 				self.$ele.data('notify-delay', self.settings.delay);
 				var timer = setInterval(function () {
 					var delay = parseInt(self.$ele.data('notify-delay')) - self.settings.timer;
 					if ((self.$ele.data('data-hover') === 'false' && self.settings.mouse_over === "pause") || self.settings.mouse_over != "pause") {
 						var percent = ((self.settings.delay - delay) / self.settings.delay) * 100;
 						self.$ele.data('notify-delay', delay);
 						self.$ele.find('[data-notify="progressbar"] > div').attr('aria-valuenow', percent).css('width', percent + '%');
 					}
 					if (delay <= -(self.settings.timer)) {
 						clearInterval(timer);
 						self.close();
 					}
 				}, self.settings.timer);
 			}
 		},
 		close: function () {
 			var self = this,
 				posX = parseInt(this.$ele.css(this.settings.placement.from)),
 				hasAnimation = false;

 			this.$ele.attr('data-closing', 'true').addClass(this.settings.animate.exit);
 			self.reposition(posX);

 			if ($.isFunction(self.settings.onClose)) {
 				self.settings.onClose.call(this.$ele);
 			}

 			this.$ele.one(this.animations.start, function () {
 				hasAnimation = true;
 			}).one(this.animations.end, function () {
 				$(this).remove();
 				if ($.isFunction(self.settings.onClosed)) {
 					self.settings.onClosed.call(this);
 				}
 			});

 			setTimeout(function () {
 				if (!hasAnimation) {
 					self.$ele.remove();
 					if (self.settings.onClosed) {
 						self.settings.onClosed(self.$ele);
 					}
 				}
 			}, 600);
 		},
 		reposition: function (posX) {
 			var self = this,
 				notifies = '[data-notify-position="' + this.settings.placement.from + '-' + this.settings.placement.align + '"]:not([data-closing="true"])',
 				$elements = this.$ele.nextAll(notifies);
 			if (this.settings.newest_on_top === true) {
 				$elements = this.$ele.prevAll(notifies);
 			}
 			$elements.each(function () {
 				$(this).css(self.settings.placement.from, posX);
 				posX = (parseInt(posX) + parseInt(self.settings.spacing)) + $(this).outerHeight();
 			});
 		}
 	});

 	$.notify = function (content, options) {
 		var plugin = new Notify(this, content, options);
 		return plugin.notify;
 	};
 	$.notifyDefaults = function (options) {
 		defaults = $.extend(true, {}, defaults, options);
 		return defaults;
 	};

 	$.notifyClose = function (selector) {

 		if (typeof selector === "undefined" || selector === "all") {
 			$('[data-notify]').find('[data-notify="dismiss"]').trigger('tap');
 		}else if(selector === 'success' || selector === 'info' || selector === 'warning' || selector === 'danger'){
 			$('.alert-' + selector + '[data-notify]').find('[data-notify="dismiss"]').trigger('tap');
 		} else if(selector){
 			$(selector + '[data-notify]').find('[data-notify="dismiss"]').trigger('tap');
 		}
 		else {
 			$('[data-notify-position="' + selector + '"]').find('[data-notify="dismiss"]').trigger('tap');
 		}
 	};

 	$.notifyCloseExcept = function (selector) {

 		if(selector === 'success' || selector === 'info' || selector === 'warning' || selector === 'danger'){
 			$('[data-notify]').not('.alert-' + selector).find('[data-notify="dismiss"]').trigger('tap');
 		} else{
 			$('[data-notify]').not(selector).find('[data-notify="dismiss"]').trigger('tap');
 		}
 	};


 }));

/* ========================================================================
 * Retchet Plust - Scroll.js
 * http://rc.kimsq.com/controls/affix/  (when data-type="affix")
 * http://rc.kimsq.com/controls/updown/  (when data-type="updown")
 * ========================================================================
 * Inspired by http://getbootstrap.com/javascript/#affix
 * Copyright 2016 redblock inc.
 * Author kiere (kiere@kimsq.com)
 * Licensed under MIT.
 * ======================================================================== */

+function ($) {
  'use strict';

      // SCROLL CLASS DEFINITION
      // ======================

      var Scroll = function (element, options) {
            this.options = $.extend({}, Scroll.DEFAULTS, options)

            this.$target = $(this.options.target)
                 .on('scroll.rc.scroll.data-api', $.proxy(this.checkPosition, this))
                 .on('tap.rc.scroll.data-api',  $.proxy(this.checkPositionWithEventLoop, this))

            this.$element     = $(element)
            this.type=this.options.type// affix , detect, ....
            this.scrolled      = null
            this.unpin        = null
            this.pinnedOffset = null
            this.lastScrollTop=0
            this.defaultHeight =this.options.defaultheight?this.options.defaultheight:280
            this.delta=this.options.delta?this.options.delta:5;

            this.checkPosition()
      }

      Scroll.VERSION  = '1.0.0'

      Scroll.Affix_RESET    = 'affix affix-top affix-bottom'

      Scroll.DEFAULTS = {
            offset: 0,
            target: '.content'
      }

      Scroll.prototype.getState = function (scrollHeight, height, offsetTop, offsetBottom) {
            var scrollTop    = this.$target.scrollTop()
            var position     = this.$element.offset()
            var targetHeight = this.$target.height()

            if (offsetTop != null && this.affixed == 'top') return scrollTop < offsetTop ? 'top' : false

            if (this.affixed == 'bottom') {
                 if (offsetTop != null) return (scrollTop + this.unpin <= position.top) ? false : 'bottom'
                 return (scrollTop + targetHeight <= scrollHeight - offsetBottom) ? false : 'bottom'
            }

            var initializing   = this.affixed == null
            var colliderTop    = initializing ? scrollTop : position.top
            var colliderHeight = initializing ? targetHeight : height

            if (offsetTop != null && scrollTop <= offsetTop) return 'top'
            if (offsetBottom != null && (colliderTop + colliderHeight >= scrollHeight - offsetBottom)) return 'bottom'

            return false
      }

      Scroll.prototype.getPinnedOffset = function () {
            if (this.pinnedOffset) return this.pinnedOffset
            this.$element.removeClass(Scroll.Affix_RESET).addClass('affix')
            var scrollTop = this.$target.scrollTop()
            var position  = this.$element.offset()
            return (this.pinnedOffset = position.top - scrollTop)
      }

      Scroll.prototype.checkPositionWithEventLoop = function () {
            setTimeout($.proxy(this.checkPosition, this), 1)
      }

      Scroll.prototype.checkPosition = function () {
            if (!this.$element.is(':visible')) return

            var height       = this.$element.height()
            var offset       = this.options.offset
            var offsetTop    = offset.top
            var offsetBottom = offset.bottom
            var scrollHeight = Math.max($(document).height(), $(document.body).height())

            if (typeof offset != 'object')         offsetBottom = offsetTop = offset
            if (typeof offsetTop == 'function')    offsetTop    = offset.top(this.$element)
            if (typeof offsetBottom == 'function') offsetBottom = offset.bottom(this.$element)

            var affix = this.getState(scrollHeight, height, offsetTop, offsetBottom)

            // when affix
            if(this.type=='affix'){
                  if (this.affixed != affix) {
                        if (this.unpin != null) this.$element.css('top', '')

                        var affixType = 'affix' + (affix ? '-' + affix : '')
                        var e         = $.Event(affixType + '.rc.scroll')

                        this.$element.trigger(e)

                        if (e.isDefaultPrevented()) return

                        this.affixed = affix
                        this.unpin = affix == 'bottom' ? this.getPinnedOffset() : null

                        this.$element
                          .removeClass(Scroll.Affix_RESET)
                          .addClass(affixType)
                          .trigger(affixType.replace('affix', 'affixed') + '.rc.scroll')
                  }

                  if (affix == 'bottom') {
                        this.$element.offset({
                          top: scrollHeight - height - offsetBottom
                        })
                  }
            }else if(this.type=='updown'){
                 var lastScrollTop=this.lastScrollTop,
                      nowScrollTop=$(this.$target).scrollTop(),
                      scrollEvent,
                      state=Math.abs(lastScrollTop - nowScrollTop) >= this.delta;
                       if(state==true){
                            if(nowScrollTop < this.defaultHeight) scrollEvent=$.Event('default.rc.scroll');
                            else{
                      	           if(nowScrollTop>lastScrollTop) scrollEvent=$.Event('down.rc.scroll');
                      	           else scrollEvent=$.Event('up.rc.scroll');
                      	      }
                      	      this.$element.trigger(scrollEvent); // trigger event
                            this.lastScrollTop=nowScrollTop;  // update lastScrollTop
                      }
            }

      }

      // SCROLL PLUGIN DEFINITION
      // =======================

      function Plugin(option) {
            return this.each(function () {
                  var $this   = $(this)
                  var data    = $this.data('rc.scroll')
                  var options = typeof option == 'object' && option

                  if (!data) $this.data('rc.scroll', (data = new Scroll(this, options)))
                  if (typeof option == 'string') data[option]()
            })
      }

      var old = $.fn.scroll

      $.fn.scroll             = Plugin
      $.fn.scroll.Constructor = Scroll


      // SCROLL NO CONFLICT
      // =================

      $.fn.scroll.noConflict = function () {
            $.fn.scroll = old
            return this
      }


      // SCROLL DATA-API
      // ==============

      $(window).on('load', function () {
            $('[data-control="scroll"]').each(function () {
                  var $spy = $(this)
                  var data = $spy.data()

                  data.offset = data.offset || {}

                  if (data.offsetBottom != null) data.offset.bottom = data.offsetBottom
                  if (data.offsetTop    != null) data.offset.top    = data.offsetTop
                  Plugin.call($spy, data)
            })
      })

}(jQuery);

/* ========================================================================
 * Ratchet Plus: transition.js v1.0.0
 * http://rc.kimsq.com/controls/transitions/
 * ========================================================================
 * inspired by @twbs's bootstrap & ratchet
 * Copyright 2016 redblock inc.
 * Author kiere (kiere@kimsq.com)
 * Licensed under MIT.
 * ======================================================================== */

+function ($) {
  'use strict';

  // CSS TRANSITION SUPPORT (Shoutout: http://www.modernizr.com/)
  // ============================================================

  function transitionEnd() {
    var el = document.createElement('rc')

    var transEndEventNames = {
      WebkitTransition : 'webkitTransitionEnd',
      MozTransition    : 'transitionend',
      OTransition      : 'oTransitionEnd otransitionend',
      transition       : 'transitionend'
    }

    for (var name in transEndEventNames) {
      if (el.style[name] !== undefined) {
        return { end: transEndEventNames[name] }
      }
    }

    return false // explicit for ie8 (  ._.)
  }

  // http://blog.alexmaccaw.com/css-transitions
  $.fn.emulateTransitionEnd = function (duration) {
    var called = false
    var $el = this
    $(this).one('rcTransitionEnd', function () { called = true })
    var callback = function () { if (!called) $($el).trigger($.support.transition.end) }
    setTimeout(callback, duration)
    return this
  }

  $(function () {
    $.support.transition = transitionEnd()

    if (!$.support.transition) return

    $.event.special.rcTransitionEnd = {
      bindType: $.support.transition.end,
      delegateType: $.support.transition.end,
      handle: function (e) {
        if ($(e.target).is(this)) return e.handleObj.handler.apply(this, arguments)
      }
    }
  })

}(jQuery);
/* ========================================================================
 * Ratchet Plus: Modal.js v1.0.0
 * http://rc.kimsq.com/components/modal/
 * ========================================================================
 * inspired by @twbs's bootstrap & ratchet
 * Copyright 2016 redblock inc.
 * Author kiere (kiere@kimsq.com)
 * Licensed under MIT.
 * ======================================================================== */

!(function ($) {
  'use strict';

      // Modal CLASS DEFINITION
      // ======================

      var Modal = function (element, options) {
            this.options          = options
            this.$body            = $(document.body)
            this.$element       = $(element)
            this.title               = this.options.title?this.options.title:null
            this.url               = this.options.url?this.options.url:null
            this.isShown             = null
     }

      // require tab.js & history.js & utilty.js
     if (!$.fn.tap || window.History=="undefined" || window.Utility=="undefined") throw new Error('Modal requires tab.js, history.js and utility.js')

      Modal.VERSION  = '1.0.0'
      Modal.DEFAULTS = {
            show: true,
            afterModal : true,
            history : true
      }

      Modal.prototype.toggle = function (_relatedTarget) {
            return this.isShown ? this.hide() : this.show(_relatedTarget)
      }

      Modal.prototype.show = function (_relatedTarget) {
            var $this = this
            var e    = $.Event('show.rc.modal', { relatedTarget: _relatedTarget })
            var title =this.title;
            var modal=this.options.target?this.options.target:'#'+this.$element.attr('id'); // 엘리먼트 클릭(target) & script 오픈 2 가지
            var url =this.url;
            if(url!=null) url=url.toString();
            var animation=this.options.animation?this.options.animation:'';
            var template=this.options.template;
            var tplContainer=this.options.tplcontainer?modal+' '+this.options.tplcontainer:modal;
            this.$element.trigger(e);
            this.isShown = true

           // init Utility
            var utility=new Utility(modal,this.options).init();
            if(!template){
                 utility.setdataVal(modal,$this.options); // data 값 세팅하는 전용함수 사용한다.
            }else{
               $(tplContainer).load(template,$.proxy(function(){
                    utility.setdataVal(modal,$this.options); // data 값 세팅하는 전용함수 사용한다.
                    this.afterTemplate(this,_relatedTarget);
               },this));
            }

            this.$element.on('tap.dismiss.rc.modal', '[data-dismiss="modal"]', $.proxy(this.hide, this))

            this.$element.addClass(animation); // 에니메이션 적용
            $(modal).show();
            setTimeout(function(){$(modal).addClass('active')}, 0);
            if(this.options.history){
                // 브라우저 history 객체에 추가
                var object = {'type': 'modal','target': modal}
                utility.addHistoryObject(object,title,url);
            }

           this.afterModal(this,_relatedTarget);
      }

      Modal.prototype.afterTemplate=function(obj,_relatedTarget){
            var e = $.Event('loaded.rc.modal', { relatedTarget: _relatedTarget })
            obj.$element.trigger('focus').trigger(e);
      }

      Modal.prototype.afterModal=function(obj,_relatedTarget){
            var e = $.Event('shown.rc.modal', { relatedTarget: _relatedTarget })
            obj.$element.trigger('focus').trigger(e);
      }

      Modal.prototype.hide = function (e) {
           if(this.options.history) history.back();
           else this.nonHistoryHide();
      }

     Modal.prototype.historyHide = function (e) {
            this.isShown = false
            if (e) e.preventDefault()
            var e    = $.Event('hide.rc.modal');
            this.$element.trigger(e)
            this.afterHide();
      }

      Modal.prototype.nonHistoryHide = function () {
            this.isShown = false
            var modal=this.$element;
            var e    = $.Event('hide.rc.modal');
            $(modal).trigger(e)
            $(modal).removeClass('active');
            setTimeout(function(){$(modal).hide();},300);
            this.afterHide();
      }

      Modal.prototype.afterHide=function(){
           var e = $.Event('hidden.rc.modal');
           this.$element.trigger(e);
      }

      var old = $.fn.modal

      $.fn.modal             = Plugin
      $.fn.modal.Constructor = Modal


        // MODAL NO CONFLICT
        // =================

      $.fn.modal.noConflict = function () {
            $.fn.modal = old
            return this
      }

      // MODAL PLUGIN DEFINITION
      // =======================

      function Plugin(option, _relatedTarget) {
            return this.each(function () {
                var $this   = $(this)
                var options = $.extend({}, Modal.DEFAULTS, $this.data(), typeof option == 'object' && option)
                var data = new Modal(this, options)
                if (typeof option == 'string' && option!='toggle') data[option](_relatedTarget)
                else if (options.show) data.show(_relatedTarget)
           })
       }

      // MODAL DATA-API
      // ==============

      $(document).on('click.rc.modal.data-api', '[data-toggle="modal"]', function (e) {
          var $this   = $(this)
          var href    = $this.attr('href')
          var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
          var option  = $target.data('rc.modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

          if ($this.is('a')) e.preventDefault()

           $target.one('show.rc.modal', function (showEvent) {
                  if (showEvent.isDefaultPrevented()) return // only register focus restorer if modal will actually get shown
                  $target.one('hidden.rc.modal', function () {
                   $this.is(':active') && $this.trigger('focus')
                })
            })

          Plugin.call($target, option, this)
      })

}(jQuery));
/* ========================================================================
 * Ratchet Plus: Popup.js v1.0.0
 * http://rc.kimsq.com/components/popup/
 * ========================================================================
 * inspired by @twbs's bootstrap & ratchet
 * Copyright 2016 redblock inc.
 * Author kiere (kiere@kimsq.com)
 * Licensed under MIT.
 * ======================================================================== */

!(function ($) {
  'use strict';

      // Popup CLASS DEFINITION
      // ======================

      var Popup = function (element, options) {
            this.options          = options
            this.$body            = $(document.body)
            this.$element       = $(element)
            this.title               = this.options.title?this.options.title:null
            this.url               = this.options.url?this.options.url:null
            this.isShown             = null
     }

     // require tab.js & history.js & utilty.js
     if (!$.fn.tap || window.History=="undefined" || window.Utility=="undefined") throw new Error('Popup requires tab.js, history.js and utility.js')

      Popup.VERSION  = '1.0.0'
      Popup.DEFAULTS = {
            show: true,
            backdrop : true,
            history : true
      }

      Popup.prototype.toggle = function (_relatedTarget) {
            return this.isShown ? this.hide() : this.show(_relatedTarget)
      }

      // 모달 호출
      Popup.prototype.show = function (_relatedTarget) {
            var $this = this
            var e    = $.Event('show.rc.popup', { relatedTarget: _relatedTarget })
            var title =this.title;
            var popup=this.options.target?this.options.target:'#'+this.$element.attr('id'); // 엘리먼트 클릭(target) & script 오픈 2 가지 ;
            var url =this.url;
            if(url!=null) url=url.toString();
            var bcontainer=this.options.bcontainer?this.options.bcontainer:'body';
            var template=this.options.template;
            var tplContainer=this.options.tplcontainer?popup+' '+this.options.tplcontainer:popup;
            this.$element.trigger(e);
            this.isShown = true

            // init Utility
            var utility=new Utility(popup,this.options).init();
            if(!template){
                 utility.setdataVal(popup,$this.options); // data 값 세팅하는 전용함수 사용한다.
            }else{
                 $(tplContainer).load(template,$.proxy(function(){
                      utility.setdataVal(popup,$this.options); // data 값 세팅하는 전용함수 사용한다.
                      this.afterTemplate(this,_relatedTarget);
                },this));
            }

            this.$element.on('tap.dismiss.rc.popup', '[data-dismiss="popup"]', $.proxy(this.hide, this))

            if(this.options.backdrop) this.backdrop();// add backdrop

            $(popup).css("display","block");
            setTimeout(function(){$(popup).addClass('active')}, 0);

            if(this.options.history){
                // 브라우저 history 객체에 추가
                var object = {'type': 'popup','target': {'id':popup,'bcontainer':bcontainer,'backdrop':this.options.backdrop}}
                utility.addHistoryObject(object,title,url);
            }
            this.afterPopup(this,_relatedTarget);
      }

      Popup.prototype.afterTemplate=function(obj,_relatedTarget){
            var e = $.Event('loaded.rc.popup', { relatedTarget: _relatedTarget })
            obj.$element.trigger('focus').trigger(e);
      }

      Popup.prototype.afterPopup=function(obj,_relatedTarget){
           var e = $.Event('shown.rc.popup', { relatedTarget: _relatedTarget })
           obj.$element.trigger('focus').trigger(e);
      }

      Popup.prototype.hide = function (e) {
           if(this.options.history) history.back();
           else this.nonHistoryHide();
           var backdrop=$('body').find('.backdrop');
           $(backdrop).remove();
      }

     Popup.prototype.historyHide = function (e) {
            this.isShown = false
            if (e) e.preventDefault()
            var e    = $.Event('hide.rc.popup');
            this.$element.trigger(e)
            this.afterHide();
      }

      Popup.prototype.nonHistoryHide = function () {
            this.isShown = false
            var popup=this.$element;
            var e    = $.Event('hide.rc.popup');
            $(popup).trigger(e)
            $(popup).removeClass('active');
            setTimeout(function(){$(popup).hide();},300);
            this.afterHide();
      }

      Popup.prototype.afterHide=function(){
           var e = $.Event('hidden.rc.popup');
           this.$element.trigger(e);
      }

      Popup.prototype.backdrop = function (callback) {
          if (this.isShown && this.options.backdrop) {
               this.$backdrop = $(document.createElement('div'))
                  .addClass('backdrop')
                  .appendTo(this.$body)
               this.$backdrop.on('click.dismiss.rc.popup', $.proxy(function (e) {
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

      var old = $.fn.popup

      $.fn.popup             = Plugin
      $.fn.popup.Constructor = Popup


        // Popup NO CONFLICT
        // =================

      $.fn.popup.noConflict = function () {
            $.fn.popup = old
            return this
      }

      // Popup PLUGIN DEFINITION
      // =======================

      function Plugin(option, _relatedTarget) {
            return this.each(function () {
                var $this   = $(this)
                var options = $.extend({}, Popup.DEFAULTS, $this.data(), typeof option == 'object' && option)
                var data = new Popup(this, options)
                if (typeof option == 'string' && option!='toggle') data[option](_relatedTarget)
                else if (options.show) data.show(_relatedTarget)
           })
       }

      // Popup DATA-API
      // ==============

      $(document).on('tap.rc.popup.data-api', '[data-toggle="popup"]', function (e) {
          var $this   = $(this)
          var href    = $this.attr('href')
          var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
          var option  = $target.data('rc.popup') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

          if ($this.is('a')) e.preventDefault()

           $target.one('show.rc.popup', function (showEvent) {
                  if (showEvent.isDefaultPrevented()) return // only register focus restorer if Popup will actually get shown
                  $target.one('hidden.rc.popup', function () {
                   $this.is(':active') && $this.trigger('focus')
                })
            })

          Plugin.call($target, option, this)
      })

}(jQuery));

/* ========================================================================
 * Ratchet Plus: Page.js v1.0.0
 * http://rc.kimsq.com/components/page/
 * ========================================================================
 * inspired by @twbs's bootstrap & ratchet
 * Copyright 2016 redblock inc.
 * Author kiere (kiere@kimsq.com)
 * Licensed under MIT.
 * ======================================================================== */

!(function ($) {
  'use strict';

      // Page CLASS DEFINITION
      // ======================

      var Page = function (element, options) {
          this.options          = options
          this.$body            = $(document.body)
          this.$element       = $(element)
          this.title               = this.options.title?this.options.title:null
          this.url               = this.options.url?this.options.url:null
     }

     // require tab.js & history.js & utilty.js
     if (!$.fn.tap || window.History=="undefined" || window.Utility=="undefined") throw new Error('Page requires tab.js, history.js and utility.js')

      Page.VERSION  = '1.0.0'
      Page.DEFAULTS = {
           show: true,
           history : true
      }

      // 페이지 호출
      Page.prototype.show = function (_relatedTarget) {
            var $this = this;
            var e    = $.Event('show.rc.page', { relatedTarget: _relatedTarget })
            var title =this.title;
            var startPage=this.options.start;
            var loadPage=this.options.target?this.options.target:'#'+this.$element.attr('id');
            var url =this.url;
            if(url!=null) url=url.toString();
            var transition=this.options.transition;
            var template=this.options.template;
            var tplContainer=this.options.tplcontainer?loadPage+' '+this.options.tplcontainer:loadPage;
            this.$element.trigger(e);
            this.isShown = true;

            var utility=new Utility(startPage,this.options).init();
            if(!template){
                 utility.setdataVal(loadPage,$this.options); // data 값 세팅하는 전용함수 사용한다.
            }else{
                 $(tplContainer).load(template,function(){
                       utility.setdataVal(loadPage,$this.options); // data 값 세팅하는 전용함수 사용한다.
                       this.afterTemplate(this,_relatedTarget);
                });
            }

            this.$element.on('tap.dismiss.rc.page', '[data-dismiss="page"]', $.proxy(this.hide, this))

            if(this.options.history){
                var object = {'type': 'page', 'target':{'start': startPage,'load':loadPage,'transition':transition}};  // 페이지 정보 : object 구분값 , 현재 페이지, 로드 페이지, 방향
                utility.addHistoryObject(object,title,url);//
            }
            this.getPage(startPage,loadPage,transition); // 타겟 페이지 호출
            this.afterPage(this,_relatedTarget);
      }

      Page.prototype.afterTemplate=function(obj,_relatedTarget){
             var e = $.Event('loaded.rc.page', { relatedTarget: _relatedTarget })
            obj.$element.trigger('focus').trigger(e);
      }

      Page.prototype.afterPage=function(obj,_relatedTarget){
            var e = $.Event('shown.rc.page', { relatedTarget: _relatedTarget })
            obj.$element.trigger('focus').trigger(e);
      }

      Page.prototype.hide=function(e){
           if(this.options.history) history.back();
           else this.nonHistoryHide();
      }

      Page.prototype.historyHide=function(e){
          this.isShown = false
          if (e) e.preventDefault()
          e = $.Event('hide.rc.page')
          this.$element.trigger(e)
          var CurrentIndex=History.getCurrentIndex();
          var ForwardIndex=parseInt(CurrentIndex)-1;
          var ForwardObj=History.getStateByIndex(ForwardIndex); // 직전 object
          var ForwardObj=JSON.stringify(ForwardObj);
          var result=$.parseJSON(ForwardObj);
          var objTarget=result.data.target; // modal, page, popover..의 id 정보
          var startPage=objTarget.start;
          var loadPage=objTarget.load;
          var transition=objTarget.transition;
          this.closePage(startPage,loadPage,transition);
          this.afterHide();
      }

     Page.prototype.nonHistoryHide = function () {
            this.isShown = false
            var sheet=this.$element;
            var e    = $.Event('hide.rc.page');
            $(sheet).trigger(e)
            var startPage=this.options.start;
            var loadPage=this.options.target?this.options.target:'#'+this.$element.attr('id');
            var transition=this.options.transition;
            this.closePage(startPage,loadPage,transition);
            this.afterHide();
      }

      Page.prototype.afterHide=function(e){
            var e = $.Event('hidden.rc.page');
           this.$element.trigger(e);
      }

      // 슬라이딩으로 페이지 호출(열기) 함수
      Page.prototype.getPage=function(startPage,loadPage,transition){
            $(loadPage).attr('class','page right'); // 출발 위치 세팅
            $(loadPage).attr('class','page transition center'); // 출발위치에서 중앙으로 이동
            $(startPage).attr('class','page transition left'); // start 페이지는 반대로 이동
      }

      // 슬라이딩으로 페이지 닫기 함수
      Page.prototype.closePage=function(startPage,loadPage,transition){
            $(startPage).attr('class','page left'); // 출발 위치 세팅
            $(startPage).attr('class','page transition center'); // 출발위치에서 중앙으로 이동
            $(loadPage).attr('class','page transition right'); // start 페이지는 반대로 이동
      }

      var old = $.fn.page

      $.fn.page             = Plugin
      $.fn.page.Constructor = Page


        // page NO CONFLICT
        // =================

        $.fn.page.noConflict = function () {
          $.fn.page = old
          return this
        }

      // MODAL PLUGIN DEFINITION
      // =======================

      function Plugin(option, _relatedTarget) {
            return this.each(function () {
                  var $this   = $(this)
                  var options = $.extend({}, Page.DEFAULTS, $this.data(), typeof option == 'object' && option)
                  var data = new Page(this, options)
                  if (typeof option == 'string' && option!='toggle') data[option](_relatedTarget)
                  else if (options.show) data.show(_relatedTarget);
            })
       }

      // Page DATA-API
      // ==============

      $(document).on('click.rc.page.data-api', '[data-toggle="page"]', function (e) {
          var $this   = $(this)
          var href    = $this.attr('href')
          var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
          var option  = $target.data('rc.page') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

          if ($this.is('a')) e.preventDefault()
           $target.one('show.rc.page', function (showEvent) {
                  if (showEvent.isDefaultPrevented()) return // only register focus restorer if modal will actually get shown
                  $target.one('hidden.rc.page', function () {
                   $this.is(':active') && $this.trigger('focus')
                })
            })
          Plugin.call($target, option, this)
      })

}(jQuery));
/* ========================================================================
 * Ratchet Plus: Sheet.js v1.0.0
 * http://rc.kimsq.com/components/sheet/
 * ========================================================================
 * inspired by @twbs's bootstrap & ratchet
 * Copyright 2016 redblock inc.
 * Author kiere (kiere@kimsq.com)
 * Licensed under MIT.
 * ======================================================================== */

!(function ($) {
  'use strict';

      // Sheet CLASS DEFINITION
      // ======================

      var Sheet = function (element, options) {
            this.options          = options
            this.$body            = $(document.body)
            this.$element       = $(element)
            this.title               = this.options.title?this.options.title:null
            this.url               = this.options.url?this.options.url:null
            this.isShown             = null
     }

     // require tab.js & history.js & utilty.js
     if (!$.fn.tap || window.History=="undefined" || window.Utility=="undefined") throw new Error('Sheet requires tab.js, history.js and utility.js')

      Sheet.VERSION  = '1.0.0'
      Sheet.DEFAULTS = {
            show: true,
            backdrop : true,
            history : true
      }

      Sheet.prototype.toggle = function (_relatedTarget) {
            return this.isShown ? this.hide() : this.show(_relatedTarget)
      }

      Sheet.prototype.show = function (_relatedTarget) {
            var $this = this
            var e    = $.Event('show.rc.sheet', { relatedTarget: _relatedTarget })
            var title =this.title;
            var sheet=this.options.target?this.options.target:'#'+this.$element.attr('id'); // 엘리먼트 클릭(target) & script 오픈 2 가지 ;
            var url=this.url;
            if(url!=null) url=url.toString();
            var placement=this.options.placement?this.options.placement:'bottom';
            var bcontainer=this.options.bcontainer?this.options.bcontainer:'body';
            var template=this.options.template;
            var tplContainer=this.options.tplcontainer?sheet+' '+this.options.tplcontainer:sheet;
            this.$element.trigger(e);
            this.isShown = true

            // init Utility
            var utility=new Utility(sheet,this.options).init();
            if(!template){
                 utility.setdataVal(sheet,$this.options); // data 값 세팅하는 전용함수 사용한다.
            }else{
                 $(tplContainer).load(template,$.proxy(function(){
                      utility.setdataVal(sheet,$this.options); // data 값 세팅하는 전용함수 사용한다.
                      this.afterTemplate(this,_relatedTarget);
                },this));
            }

            this.$element.on('tap.dismiss.rc.sheet', '[data-dismiss="sheet"]', $.proxy(this.hide, this))

            if(this.options.backdrop) this.backdrop();// add backdrop

            $(sheet).css("display","block");
            setTimeout(function(){$(sheet).addClass('active')}, 0);
            if(this.options.history){
               // 브라우저 history 객체에 추가
                var object = {'type': 'sheet','target': {'id':sheet,'bcontainer':bcontainer,'backdrop':this.options.backdrop}}
               utility.addHistoryObject(object,title,url);
            }
            this.afterSheet(this,_relatedTarget);
      }

      Sheet.prototype.afterTemplate=function(obj,_relatedTarget){
            var e = $.Event('loaded.rc.sheet', { relatedTarget: _relatedTarget })
            obj.$element.trigger('focus').trigger(e);
      }

      Sheet.prototype.afterSheet=function(obj,_relatedTarget){
           var e = $.Event('shown.rc.sheet', { relatedTarget: _relatedTarget })
           obj.$element.trigger('focus').trigger(e);
      }

      Sheet.prototype.hide = function (e) {
           if(this.options.history) history.back();
           else this.nonHistoryHide();
           var backdrop=$('body').find('.backdrop');
           $(backdrop).remove();
      }

      Sheet.prototype.historyHide = function () {
            this.isShown = false
            if (e) e.preventDefault()
            var e    = $.Event('hide.rc.sheet');
            this.$element.trigger(e)
            this.afterHide();
      }

      Sheet.prototype.nonHistoryHide = function () {
            this.isShown = false
            var sheet=this.$element;
            var e    = $.Event('hide.rc.sheet');
            $(sheet).trigger(e)
            $(sheet).removeClass('active');
            setTimeout(function(){$(sheet).hide();},300);
            this.afterHide();
      }

      Sheet.prototype.afterHide=function(){
           var e = $.Event('hidden.rc.sheet');
           this.$element.trigger(e);
      }

     Sheet.prototype.backdrop = function (callback) {
          if (this.isShown && this.options.backdrop) {
               this.$backdrop = $(document.createElement('div'))
                  .addClass('backdrop')
                  .appendTo(this.$body)
               this.$backdrop.on('click.dismiss.rc.sheet', $.proxy(function (e) {
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
      var old = $.fn.sheet

      $.fn.sheet             = Plugin
      $.fn.sheet.Constructor = Sheet


        // Sheet NO CONFLICT
        // =================

      $.fn.sheet.noConflict = function () {
            $.fn.sheet = old
            return this
      }

      // Sheet PLUGIN DEFINITION
      // =======================

      function Plugin(option, _relatedTarget) {
            return this.each(function () {
                var $this   = $(this)
                var options = $.extend({}, Sheet.DEFAULTS, $this.data(), typeof option == 'object' && option)
                var data = new Sheet(this, options)
                if (typeof option == 'string' && option!='toggle') data[option](_relatedTarget)
                else if (options.show) data.show(_relatedTarget)
           })
       }

      // Sheet DATA-API
      // ==============

      $(document).on('tap.rc.sheet.data-api', '[data-toggle="sheet"]', function (e) {
          var $this   = $(this)
          var href    = $this.attr('href')
          var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
          var option  = $target.data('rc.sheet') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

          if ($this.is('a')) e.preventDefault()

           $target.one('show.rc.sheet', function (showEvent) {
                  if (showEvent.isDefaultPrevented()) return // only register focus restorer if Sheet will actually get shown
                  $target.one('hidden.rc.sheet', function () {
                   $this.is(':active') && $this.trigger('focus')
                })
            })

          Plugin.call($target, option, this)
      })

}(jQuery));
/* ========================================================================
 * Ratchet Plus: Popover.js v1.0.0
 * http://rc.kimsq.com/components/popover/
 * ========================================================================
 * inspired by @twbs's bootstrap & ratchet
 * Copyright 2016 redblock inc.
 * Author kiere (kiere@kimsq.com)
 * Licensed under MIT.
 * ======================================================================== */

!(function ($) {
  'use strict';

      // Popover CLASS DEFINITION
      // ======================

      var Popover = function (element, options) {
            this.options          = options
            this.$body            = $(document.body)
            this.$element       = $(element)
            this.title               = this.options.title?this.options.title:null
            this.url               = this.options.url?this.options.url:null
            this.isShown             = null
     }

     // require tab.js & history.js & utilty.js
     if (!$.fn.tap || window.History=="undefined" || window.Utility=="undefined") throw new Error('Popover requires tab.js, history.js and utility.js')

      Popover.VERSION  = '1.1.0'
      Popover.DEFAULTS = {
            show: true,
            backdrop : true,
            history : true
      }

      Popover.prototype.toggle = function (_relatedTarget) {
            return this.isShown ? this.hide() : this.show(_relatedTarget)
      }

      Popover.prototype.show = function (_relatedTarget) {
            var $this = this
            var e    = $.Event('show.rc.popover', { relatedTarget: _relatedTarget })
            var title =this.title;
            var popover=this.options.target?this.options.target:'#'+this.$element.attr('id'); // 엘리먼트 클릭(target) & script 오픈 2 가지 ;
            var url=this.url;
            if(url!=null) url=url.toString();
            var placement=this.options.placement?this.options.placement:'bottom';
            var bcontainer=this.options.bcontainer?this.options.bcontainer:'body';
            var template=this.options.template;
            var tplContainer=this.options.tplcontainer?popover+' '+this.options.tplcontainer:popover;
            this.$element.trigger(e);
            this.isShown = true

            // init Utility
            var utility=new Utility(popover,this.options).init();
            if(!template){
                 utility.setdataVal(popover,$this.options); // data 값 세팅하는 전용함수 사용한다.
            }else{
                 $(tplContainer).load(template,$.proxy(function(){
                      utility.setdataVal(popover,$this.options); // data 값 세팅하는 전용함수 사용한다.
                      this.afterTemplate(this,_relatedTarget);
                },this));
            }

            this.$element.on('click.dismiss.rc.popover', '[data-dismiss="popover"]', $.proxy(this.hide, this))

            if(this.options.backdrop)  this.backdrop(); // add backdrop
            $(popover).show();
            setTimeout(function(){$(popover).addClass('active')}, 0);

            if(this.options.history){
                // 브라우저 history 객체에 추가
                var object = {'type': 'popover','target': {'id':popover,'bcontainer':bcontainer,'backdrop':this.options.backdrop}}
                utility.addHistoryObject(object,title,url);
            }
            this.afterPopover(this,_relatedTarget);
      }

      Popover.prototype.afterTemplate=function(obj,_relatedTarget){
            var e = $.Event('loaded.rc.popover', { relatedTarget: _relatedTarget })
            obj.$element.trigger('focus').trigger(e);
      }

      Popover.prototype.afterPopover=function(obj,_relatedTarget){
           var e = $.Event('shown.rc.popover', { relatedTarget: _relatedTarget })
           obj.$element.trigger('focus').trigger(e);
      }

      Popover.prototype.hide = function (e) {
          if(this.options.history) history.back();
          else this.nonHistoryHide();
          var backdrop=$('body').find('.backdrop');
          $(backdrop).remove();
      }
     Popover.prototype.historyHide = function (e) {
            this.isShown = false
            if (e) e.preventDefault()
            e = $.Event('hide.rc.popover')
            this.$element.trigger(e)
            this.afterHide();
      }

      Popover.prototype.nonHistoryHide = function () {
            this.isShown = false
            var popover=this.$element;
            var e    = $.Event('hide.rc.popover');
            $(popover).trigger(e)
            $(popover).removeClass('active');
            setTimeout(function(){$(popover).hide();},300);
            this.afterHide();
      }

      Popover.prototype.afterHide=function(){
           var e = $.Event('hidden.rc.popover');
           this.$element.trigger(e);
      }

      Popover.prototype.backdrop = function (callback) {
          if (this.isShown && this.options.backdrop) {
               this.$backdrop = $(document.createElement('div'))
                  .addClass('backdrop')
                  .appendTo(this.$body)
               this.$backdrop.on('click.dismiss.rc.popover', $.proxy(function (e) {
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

      var old = $.fn.popover

      $.fn.popover             = Plugin
      $.fn.popover.Constructor = Popover


        // Popover NO CONFLICT
        // =================

      $.fn.popover.noConflict = function () {
            $.fn.popover = old
            return this
      }

      // Popover PLUGIN DEFINITION
      // =======================

      function Plugin(option, _relatedTarget) {
            return this.each(function () {
                var $this   = $(this)
                var options = $.extend({}, Popover.DEFAULTS, $this.data(), typeof option == 'object' && option)
                var data = new Popover(this, options)
                if (typeof option == 'string' && option!='toggle') data[option](_relatedTarget)
                else if (options.show) data.show(_relatedTarget)
           })
       }

      // Popover DATA-API
      // ==============

      $(document).on('tap.rc.popover.data-api', '[data-toggle="popover"]', function (e) {
          var $this   = $(this)
          var href    = $this.attr('href')
          var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
          var option  = $target.data('rc.popover') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

          if ($this.is('a')) e.preventDefault()

           $target.one('show.rc.popover', function (showEvent) {
                  if (showEvent.isDefaultPrevented()) return // only register focus restorer if Popover will actually get shown
                  $target.one('hidden.rc.popover', function () {
                   $this.is(':active') && $this.trigger('focus')
                })
            })

          Plugin.call($target, option, this)
      })

}(jQuery));
/* ========================================================================
 * Ratchet Plus: Fbutton.js v1.0.0
 * http://rc.kimsq.com/components/fbutton/
 * ========================================================================
 * inspired by @twbs's bootstrap & ratchet
 * Copyright 2016 redblock inc.
 * Author kiere (kiere@kimsq.com)
 * Licensed under MIT.
 * ======================================================================== */

!(function ($) {
  'use strict';

      // Fbutton CLASS DEFINITION
      // ======================

      var Fbutton = function (element, options) {
            this.options          = options
            this.$body            = $(document.body)
            this.$element       = $(element)
            this.title               = this.options.title?this.options.title:null
            this.url               = this.options.url?this.options.url:null
            this.isShown             = null
     }

     // require tab.js & history.js & utilty.js
     if (!$.fn.tap || window.History=="undefined" || window.Utility=="undefined") throw new Error('Fbutton requires tab.js, history.js and utility.js')

      Fbutton.VERSION  = '1.0.0'
      Fbutton.DEFAULTS = {
            toggle : true,
            backdrop : true,
            history : true
      }

      Fbutton.prototype.toggle = function (_relatedTarget) {
            var isfbutton=sessionStorage.getItem('isfbutton');
            var isShown=isfbutton?isfbutton:'false';
            return isShown=='true' ? this.hide() : this.show(_relatedTarget)
      }

      Fbutton.prototype.show = function (_relatedTarget) {
            var $this = this
            var e    = $.Event('show.rc.fbutton', { relatedTarget: _relatedTarget })
            var title =this.title;
            var fbutton=this.options.target?this.options.target:'#'+this.$element.attr('id'); // 엘리먼트 클릭(target) & script 오픈 2 가지 ;
            var url=this.url;
            if(url!=null) url=url.toString();
            var placement=this.options.placement?this.options.placement:'bottom';
            var bcontainer=this.options.bcontainer?this.options.bcontainer:'body';
            var template=this.options.template;
            var tplContainer=this.options.tplcontainer?fbutton+' '+this.options.tplcontainer:fbutton;
            this.$element.trigger(e);
            if (this.isShown || e.isDefaultPrevented()) return
            this.isShown=true
            this.isShown='true';
            sessionStorage.setItem('isfbutton',this.isShown);
            // init Utility
            var utility=new Utility(fbutton,this.options).init();
            if(!template){
                 utility.setdataVal(fbutton,$this.options); // data 값 세팅하는 전용함수 사용한다.
            }else{
                 $(tplContainer).load(template,$.proxy(function(){
                      utility.setdataVal(fbutton,$this.options); // data 값 세팅하는 전용함수 사용한다.
                      this.afterTemplate(this,_relatedTarget);
                },this));
            }

            this.$element.on('tap.dismiss.rc.fbutton', '[data-dismiss="fbutton"]', $.proxy(this.hide, this))

            if(this.options.backdrop)  this.backdrop(); // add backdrop
            $(fbutton).addClass('active');

            if(this.options.history){
                // 브라우저 history 객체에 추가
                var object = {'type': 'fbutton','target': {'id':fbutton,'bcontainer':bcontainer,'backdrop':this.options.backdrop}}
                utility.addHistoryObject(object,title,url);
            }
            this.afterFbutton(this,_relatedTarget);

      }

      Fbutton.prototype.afterTemplate=function(obj,_relatedTarget){
            var e = $.Event('loaded.rc.fbutton', { relatedTarget: _relatedTarget })
            obj.$element.trigger('focus').trigger(e);
      }

      Fbutton.prototype.afterFbutton=function(obj,_relatedTarget){
           var e = $.Event('shown.rc.fbutton', { relatedTarget: _relatedTarget })
           obj.$element.trigger('focus').trigger(e);
      }

      Fbutton.prototype.hide = function (e) {
          if(this.options.history) history.back();
          else this.nonHistoryHide();
          var backdrop=$('body').find('.backdrop');
          $(backdrop).remove();
      }
     Fbutton.prototype.historyHide = function (e) {
            this.isShown = 'false'
            sessionStorage.setItem('isfbutton',this.isShown);
            if (e) e.preventDefault()
            e = $.Event('hide.rc.fbutton')
            this.$element.trigger(e)
            this.afterHide();
      }

      Fbutton.prototype.nonHistoryHide = function () {
            this.isShown = 'false'
            sessionStorage.setItem('isfbutton',this.isShown);
            var fbutton=this.$element;
            var e    = $.Event('hide.rc.fbutton');
            $(fbutton).trigger(e)
            $(fbutton).removeClass('active');
            this.afterHide();
      }

      Fbutton.prototype.afterHide=function(){
           var e = $.Event('hidden.rc.fbutton');
           this.$element.trigger(e);
      }

      Fbutton.prototype.backdrop = function (callback) {
          if (this.isShown && this.options.backdrop) {
               this.$backdrop = $(document.createElement('div'))
                  .addClass('backdrop')
                  .appendTo(this.$body)
                   this.$backdrop.on('click.dismiss.rc.fbutton', $.proxy(function (e) {
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

      var old = $.fn.fbutton

      $.fn.fbutton             = Plugin
      $.fn.fbutton.Constructor = Fbutton


        // Fbutton NO CONFLICT
        // =================

      $.fn.fbutton.noConflict = function () {
            $.fn.fbutton = old
            return this
      }

      // Fbutton PLUGIN DEFINITION
      // =======================

      function Plugin(option, _relatedTarget) {
            return this.each(function () {
                var $this   = $(this)
                var options = $.extend({}, Fbutton.DEFAULTS, $this.data(), typeof option == 'object' && option)
                var data = new Fbutton(this, options)
                 if (typeof option == 'string' && option!='toggle') data[option](_relatedTarget)
                else if (options.toggle) data.toggle(_relatedTarget)
           })
       }

      // Fbutton DATA-API
      // ==============

      $(document).on('tap.rc.fbutton.data-api', '[data-toggle="fbutton"]', function (e) {
          var $this   = $(this)
          var href    = $this.attr('href')
          var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
          var option  = $target.data('rc.fbutton') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

          if ($this.is('a')) e.preventDefault()

           $target.one('show.rc.fbutton', function (showEvent) {
                  if (showEvent.isDefaultPrevented()) return // only register focus restorer if Fbutton will actually get shown
                  $target.one('hidden.rc.fbutton', function () {
                   $this.is(':active') && $this.trigger('focus')
                })
            })

          Plugin.call($target, option, this)
      })

}(jQuery));
/* ========================================================================
 * Ratchet Plus: collapse.js v1.0.0
 * http://rc.kimsq.com/components/collapse/
 * ========================================================================
 * inspired by @twbs's bootstrap & ratchet
 * Copyright 2016 redblock inc.
 * Author kiere (kiere@kimsq.com)
 * Licensed under MIT.
 * ======================================================================== */

/* jshint latedef: false */

+function ($) {
  'use strict';

  // COLLAPSE PUBLIC CLASS DEFINITION
  // ================================

  var Collapse = function (element, options) {
    this.$element      = $(element)
    this.options       = $.extend({}, Collapse.DEFAULTS, options)
    this.$trigger      = $('[data-toggle="collapse"][href="#' + element.id + '"],' +
                           '[data-toggle="collapse"][data-target="#' + element.id + '"]')
    this.transitioning = null

    if (this.options.parent) {
      this.$parent = this.getParent()
    } else {
      this.addAriaAndCollapsedClass(this.$element, this.$trigger)
    }

    if (this.options.toggle) this.toggle()
  }

  if (!$.fn.emulateTransitionEnd) throw new Error('Collapse requires transition.js')

  Collapse.VERSION  = '1.0.0'

  Collapse.TRANSITION_DURATION = 350

  Collapse.DEFAULTS = {
    toggle: true
  }

  Collapse.prototype.dimension = function () {
    var hasWidth = this.$element.hasClass('width')
    return hasWidth ? 'width' : 'height'
  }

  Collapse.prototype.show = function () {
    if (this.transitioning || this.$element.hasClass('in')) return

    var activesData
    var actives = this.$parent && this.$parent.children().children('.in, .collapsing')

    if (actives && actives.length) {
      activesData = actives.data('rc.collapse')
      if (activesData && activesData.transitioning) return
    }

    var startEvent = $.Event('show.rc.collapse')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    if (actives && actives.length) {
      Plugin.call(actives, 'hide')
      activesData || actives.data('rc.collapse', null)
    }

    var dimension = this.dimension()

    this.$element
      .removeClass('collapse')
      .addClass('collapsing')[dimension](0)
      .attr('aria-expanded', true)

    this.$trigger
      .removeClass('collapsed')
      .attr('aria-expanded', true)

    this.transitioning = 1

    var complete = function () {
      this.$element
        .removeClass('collapsing')
        .addClass('collapse in')[dimension]('')
      this.transitioning = 0
      this.$element
        .trigger('shown.rc.collapse')
    }

    if (!$.support.transition) return complete.call(this)

    var scrollSize = $.camelCase(['scroll', dimension].join('-'))

    this.$element
      .one('rcTransitionEnd', $.proxy(complete, this))
      .emulateTransitionEnd(Collapse.TRANSITION_DURATION)[dimension](this.$element[0][scrollSize])
  }

  Collapse.prototype.hide = function () {
    if (this.transitioning || !this.$element.hasClass('in')) return

    var startEvent = $.Event('hide.rc.collapse')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    var dimension = this.dimension()

    this.$element[dimension](this.$element[dimension]())[0].offsetHeight

    this.$element
      .addClass('collapsing')
      .removeClass('collapse in')
      .attr('aria-expanded', false)

    this.$trigger
      .addClass('collapsed')
      .attr('aria-expanded', false)

    this.transitioning = 1

    var complete = function () {
      this.transitioning = 0
      this.$element
        .removeClass('collapsing')
        .addClass('collapse')
        .trigger('hidden.rc.collapse')
    }

    if (!$.support.transition) return complete.call(this)

    this.$element
      [dimension](0)
      .one('rcTransitionEnd', $.proxy(complete, this))
      .emulateTransitionEnd(Collapse.TRANSITION_DURATION)
  }

  Collapse.prototype.toggle = function () {
    this[this.$element.hasClass('in') ? 'hide' : 'show']()
  }

  Collapse.prototype.getParent = function () {
    return $(this.options.parent)
      .find('[data-toggle="collapse"][data-parent="' + this.options.parent + '"]')
      .each($.proxy(function (i, element) {
        var $element = $(element)
        this.addAriaAndCollapsedClass(getTargetFromTrigger($element), $element)
      }, this))
      .end()
  }

  Collapse.prototype.addAriaAndCollapsedClass = function ($element, $trigger) {
    var isOpen = $element.hasClass('in')

    $element.attr('aria-expanded', isOpen)
    $trigger
      .toggleClass('collapsed', !isOpen)
      .attr('aria-expanded', isOpen)
  }

  function getTargetFromTrigger($trigger) {
    var href
    var target = $trigger.attr('data-target')
      || (href = $trigger.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '') // strip for ie7

    return $(target)
  }


  // COLLAPSE PLUGIN DEFINITION
  // ==========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('rc.collapse')
      var options = $.extend({}, Collapse.DEFAULTS, $this.data(), typeof option == 'object' && option)

      if (!data && options.toggle && /show|hide/.test(option)) options.toggle = false
      if (!data) $this.data('rc.collapse', (data = new Collapse(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.collapse

  $.fn.collapse             = Plugin
  $.fn.collapse.Constructor = Collapse


  // COLLAPSE NO CONFLICT
  // ====================

  $.fn.collapse.noConflict = function () {
    $.fn.collapse = old
    return this
  }


  // COLLAPSE DATA-API
  // =================

  $(document).on('tap.rc.collapse.data-api', '[data-toggle="collapse"]', function (e) {
    var $this   = $(this)

    if (!$this.attr('data-target')) e.preventDefault()

    var $target = getTargetFromTrigger($this)
    var data    = $target.data('rc.collapse')
    var option  = data ? 'toggle' : $this.data()

    Plugin.call($target, option)
  })

}(jQuery);

/* ========================================================================
 * Ratchet Plus: Switch.js v1.0.0
 * http://http://rc.kimsq.com/components/switch/
 * ========================================================================
 * inspired by @twbs's bootstrap & ratchet
 * Copyright 2016 redblock inc.
 * Author kiere (kiere@kimsq.com)
 * Licensed under MIT.
 * ======================================================================== */

!(function () {
  'use strict';

  if (!window.RATCHET) throw new Error('Switch requires common.js')

  var start     = {};
  var touchMove = false;
  var distanceX = false;
  var toggle    = false;
  var transformProperty = window.RATCHET.getBrowserCapabilities.transform;
  var supportsTouch = false;
  if ('ontouchstart' in window) supportsTouch = true; //iOS & android
  else if(window.navigator.msPointerEnabled) supportsTouch = true; //Win8

  var findToggle = function (target) {
    var i;
    var toggles = document.querySelectorAll('[data-toggle="switch"]');

    for (; target && target !== document; target = target.parentNode) {
      for (i = toggles.length; i--;) {
        if (toggles[i] === target) {
          return target;
        }
      }
    }
  };

  window.addEventListener('touchstart', function (e) {
    e = e.originalEvent || e;

    toggle = findToggle(e.target);

    if (!toggle) {
      return;
    }

    var handle      = toggle.querySelector('.switch-handle');
    var toggleWidth = toggle.clientWidth;
    var handleWidth = handle.clientWidth;
    var offset      = toggle.classList.contains('active') ? (toggleWidth - handleWidth) : 0;

    start     = { pageX : e.touches[0].pageX - offset, pageY : e.touches[0].pageY };
    touchMove = false;
  });

  window.addEventListener('touchmove', function (e) {
    e = e.originalEvent || e;

    if (e.touches.length > 1) {
      return; // Exit if a pinch
    }

    if (!toggle) {
      return;
    }

    var handle      = toggle.querySelector('.switch-handle');
    var current     = e.touches[0];
    var toggleWidth = toggle.clientWidth;
    var handleWidth = handle.clientWidth;
    var offset      = toggleWidth - handleWidth;

    touchMove = true;
    distanceX = current.pageX - start.pageX;

    if (Math.abs(distanceX) < Math.abs(current.pageY - start.pageY)) {
      return;
    }

    e.preventDefault();

    if (distanceX < 0) {
      return (handle.style[transformProperty] = 'translate3d(0,0,0)');
    }
    if (distanceX > offset) {
      return (handle.style[transformProperty] = 'translate3d(' + offset + 'px,0,0)');
    }

    handle.style[transformProperty] = 'translate3d(' + distanceX + 'px,0,0)';

    toggle.classList[(distanceX > (toggleWidth / 2 - handleWidth / 2)) ? 'add' : 'remove']('active');
  });

  function touchend(e){

    if (!toggle) {
      return;
    }

    var handle      = toggle.querySelector('.switch-handle');
    var toggleWidth = toggle.clientWidth;
    var handleWidth = handle.clientWidth;
    var offset      = (toggleWidth - handleWidth);
    var slideOn     = (!touchMove && !toggle.classList.contains('active')) || (touchMove && (distanceX > (toggleWidth / 2 - handleWidth / 2)));

    if (slideOn) {
      handle.style[transformProperty] = 'translate3d(' + offset + 'px,0,0)';
    } else {
      handle.style[transformProperty] = 'translate3d(0,0,0)';
    }

    toggle.classList[slideOn ? 'add' : 'remove']('active');

    e = $.Event('changed.rc.switch', { relatedTarget: handle})
    $(toggle).trigger(e);

    touchMove = false;
    toggle    = false;
  }
  window.addEventListener('touchend', function(e){
     touchend(e);
  });

 function mouseHandler(e)
 {
    e = e.originalEvent || e;
    toggle = findToggle(e.target);
    touchend(e);
 }

 if(supportsTouch===false) window.addEventListener("click", mouseHandler, true);

}(jQuery));

/* ========================================================================
 * Ratchet: segmented-controllers.js v2.0.2
 * http://goratchet.com/components#segmentedControls
 * ========================================================================
 * Copyright 2014 Connor Sears
 * Licensed under MIT (https://github.com/twbs/ratchet/blob/master/LICENSE)
 * ======================================================================== */

!(function () {
  'use strict';

  var getTarget = function (target) {
    var i;
    var segmentedControls = document.querySelectorAll('.segmented-control .control-item');

    for (; target && target !== document; target = target.parentNode) {
      for (i = segmentedControls.length; i--;) {
        if (segmentedControls[i] === target) {
          return target;
        }
      }
    }
  };

  var activeSegment=function(e){

      var activeTab;
      var activeBodies;
      var targetBody;
      var targetTab     = getTarget(e.target);
      var className     = 'active';
      var classSelector = '.' + className;

      if (!targetTab) {
        return;
      }

      activeTab = targetTab.parentNode.querySelector(classSelector);

      if (activeTab) {
        activeTab.classList.remove(className);
      }

      targetTab.classList.add(className);

      if (!targetTab.hash) {
        return;
      }

      targetBody = document.querySelector(targetTab.hash);

      if (!targetBody) {
        return;
      }

      activeBodies = targetBody.parentNode.querySelectorAll(classSelector);

      for (var i = 0; i < activeBodies.length; i++) {
        activeBodies[i].classList.remove(className);
      }

      targetBody.classList.add(className);
}

window.addEventListener('touchend', activeSegment);
window.addEventListener('click', function (e) {
    if (getTarget(e.target)) {
      e.preventDefault();
    }
    activeSegment(e);
  });

}());

}(jQuery);

/* ========================================================================
 * RC: button.js v1.0.0
 * http://rc.kimsq.com/components/buttons/#toggle-states
 * ========================================================================
 * Copyright 2011-2016 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // BUTTON PUBLIC CLASS DEFINITION
  // ==============================

  var Button = function (element, options) {
    this.$element  = $(element)
    this.options   = $.extend({}, Button.DEFAULTS, options)
    this.isLoading = false
  }

  Button.VERSION  = '3.3.7'

  Button.DEFAULTS = {
    loadingText: 'loading...'
  }

  Button.prototype.setState = function (state) {
    var d    = 'disabled'
    var $el  = this.$element
    var val  = $el.is('input') ? 'val' : 'html'
    var data = $el.data()

    state += 'Text'

    if (data.resetText == null) $el.data('resetText', $el[val]())

    // push to event loop to allow forms to submit
    setTimeout($.proxy(function () {
      $el[val](data[state] == null ? this.options[state] : data[state])

      if (state == 'loadingText') {
        this.isLoading = true
        $el.addClass(d).attr(d, d).prop(d, true)
      } else if (this.isLoading) {
        this.isLoading = false
        $el.removeClass(d).removeAttr(d).prop(d, false)
      }
    }, this), 0)
  }

  Button.prototype.toggle = function () {
    var changed = true
    var $parent = this.$element.closest('[data-toggle="buttons"]')

    if ($parent.length) {
      var $input = this.$element.find('input')
      if ($input.prop('type') == 'radio') {
        if ($input.prop('checked')) changed = false
        $parent.find('.active').removeClass('active')
        this.$element.addClass('active')
      } else if ($input.prop('type') == 'checkbox') {
        if (($input.prop('checked')) !== this.$element.hasClass('active')) changed = false
        this.$element.toggleClass('active')
      }
      $input.prop('checked', this.$element.hasClass('active'))
      if (changed) $input.trigger('change')
    } else {
      this.$element.attr('aria-pressed', !this.$element.hasClass('active'))
      this.$element.toggleClass('active')
    }
  }


  // BUTTON PLUGIN DEFINITION
  // ========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('rc.button')
      var options = typeof option == 'object' && option

      if (!data) $this.data('rc.button', (data = new Button(this, options)))

      if (option == 'toggle') data.toggle()
      else if (option) data.setState(option)
    })
  }

  var old = $.fn.button

  $.fn.button             = Plugin
  $.fn.button.Constructor = Button


  // BUTTON NO CONFLICT
  // ==================

  $.fn.button.noConflict = function () {
    $.fn.button = old
    return this
  }


  // BUTTON DATA-API
  // ===============

  $(document)
    .on('click.rc.button.data-api', '[data-toggle^="button"]', function (e) {
      var $btn = $(e.target).closest('.btn')
      Plugin.call($btn, 'toggle')
      if (!($(e.target).is('input[type="radio"], input[type="checkbox"]'))) {
        // Prevent double click on radios, and the double selections (so cancellation) on checkboxes
        e.preventDefault()
        // The target component still receive the focus
        if ($btn.is('input,button')) $btn.trigger('focus')
        else $btn.find('input:visible,button:visible').first().trigger('focus')
      }
    })
    .on('focus.rc.button.data-api blur.rc.button.data-api', '[data-toggle^="button"]', function (e) {
      $(e.target).closest('.btn').toggleClass('focus', /^focus(in)?$/.test(e.type))
    })

}(jQuery);
