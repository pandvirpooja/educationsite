/* ATTENTION! This file was generated automatically! Don&#039;t change it!!!
----------------------------------------------------------------------- */
/**
 * Full Background Video
 *
 * More info on Audio/Video Media Events/Attributes/Methods
 * - https://developer.mozilla.org/en-US/docs/Web/Guide/Events/Media_events
 * - http://www.w3schools.com/tags/ref_av_dom.asp
 */

(function (global) {
  "use strict";

  // Define Bideo constructor on the global object
  global.Bideo = function () {

    // Plugin options
    this.opt = null;
    // The Video element
    this.videoEl = null;

    // Approximate Loading Rate
    //
    // The value will be a number like 0.8
    // which means to load 4 seconds of the video
    // it takes 5 seconds. If the number is super low
    // like 0.2 (regular 3g connections) then you can
    // decide whether to play the video or not.
    // This behaviour will be controller with
    // the `acceptableLoadingRate` option.
    this.approxLoadingRate = null;

    // Methods to which `this` will be bound
    this._resize = null;
    this._progress = null;

    // Time at which video is initialized
    this.startTime = null;

    this.onLoadCalled = false;

    // Initialize and setup the video in DOM`
    this.init = function (opt) {
      // If not set then set to an empty object
      this.opt = opt = opt || {};

      var self = this;

      self._resize = self.resize.bind(this);

      // Video element
      self.videoEl = opt.videoEl;

      // Meta data event
      self.videoEl.addEventListener('loadedmetadata', self._resize, false);

      // Fired when enough has been buffered to begin the video
      // self.videoEl.readyState === 4 (HAVE_ENOUGH_DATA)
      self.videoEl.addEventListener('canplay', function () {
        // Play the video when enough has been buffered
        if (!self.opt.isMobile) {
          self.opt.onLoad && self.opt.onLoad();
          if (self.opt.autoplay !== false) self.videoEl.play();
        }
      });

      // If resizing is required (resize video as window/container resizes)
      if (self.opt.resize) {
        global.addEventListener('resize', self._resize, false);
      }

      // Start time of video initialization
      this.startTime = (new Date()).getTime();

      // Create `source` for video
      this.opt.src.forEach(function (srcOb, i, arr) {
        var key
          , val
          , source = document.createElement('source');

        // Set all the attribute key=val supplied in `src` option
        for (key in srcOb) {
          if (srcOb.hasOwnProperty(key)) {
            val = srcOb[key];

            source.setAttribute(key, val);
          }
        }

        self.videoEl.appendChild(source);
      });

      if (self.opt.isMobile) {
        if (self.opt.playButton) {
          self.opt.videoEl.addEventListener('timeupdate', function () {
            if (!self.onLoadCalled) {
              self.opt.onLoad && self.opt.onLoad();
              self.onLoadCalled = true;
            }
          });


          self.opt.playButton.addEventListener('click', function () {
            self.opt.pauseButton.style.display = 'inline-block';
            this.style.display = 'none';

            self.videoEl.play();
          }, false);

          self.opt.pauseButton.addEventListener('click', function () {
            this.style.display = 'none';
            self.opt.playButton.style.display = 'inline-block';

            self.videoEl.pause();
          }, false);
        }
      }

      return;
    };

    // Called once video metadata is available
    //
    // Also called when window/container is resized
    this.resize = function () {
      // IE/Edge still don't support object-fit: cover
      if ('object-fit' in document.body.style) return;

      // Video's intrinsic dimensions
      var w = this.videoEl.videoWidth
        , h = this.videoEl.videoHeight;

      // Intrinsic ratio
      // Will be more than 1 if W > H and less if H > W
      var videoRatio = (w / h).toFixed(2);

      // Get the container DOM element and its styles
      //
      // Also calculate the min dimensions required (this will be
      // the container dimentions)
      var container = this.opt.container
        , containerStyles = global.getComputedStyle(container)
        , minW = parseInt( containerStyles.getPropertyValue('width') )
        , minH = parseInt( containerStyles.getPropertyValue('height') );

      // If !border-box then add paddings to width and height
      if (containerStyles.getPropertyValue('box-sizing') !== 'border-box') {
        var paddingTop = containerStyles.getPropertyValue('padding-top')
          , paddingBottom = containerStyles.getPropertyValue('padding-bottom')
          , paddingLeft = containerStyles.getPropertyValue('padding-left')
          , paddingRight = containerStyles.getPropertyValue('padding-right');

        paddingTop = parseInt(paddingTop);
        paddingBottom = parseInt(paddingBottom);
        paddingLeft = parseInt(paddingLeft);
        paddingRight = parseInt(paddingRight);

        minW += paddingLeft + paddingRight;
        minH += paddingTop + paddingBottom;
      }

      // What's the min:intrinsic dimensions
      //
      // The idea is to get which of the container dimension
      // has a higher value when compared with the equivalents
      // of the video. Imagine a 1200x700 container and
      // 1000x500 video. Then in order to find the right balance
      // and do minimum scaling, we have to find the dimension
      // with higher ratio.
      //
      // Ex: 1200/1000 = 1.2 and 700/500 = 1.4 - So it is best to
      // scale 500 to 700 and then calculate what should be the
      // right width. If we scale 1000 to 1200 then the height
      // will become 600 proportionately.
      var widthRatio = minW / w;
      var heightRatio = minH / h;

      // Whichever ratio is more, the scaling
      // has to be done over that dimension
      if (widthRatio > heightRatio) {
        var new_width = minW;
        var new_height = Math.ceil( new_width / videoRatio );
      } else {
        var new_height = minH;
        var new_width = Math.ceil( new_height * videoRatio );
      }

      this.videoEl.style.width = new_width + 'px';
      this.videoEl.style.height = new_height + 'px';
    };

  };

}(window));/* jQuery tubular plugin
|* by Sean McCambridge
|* http://www.seanmccambridge.com/tubular
|* version: 1.0
|* updated: October 1, 2012
|* since 2010
|* licensed under the MIT License
|* Enjoy.
|* 
|* Thanks,
|* Sean */

;(function ($, window) {

    "use strict";

    // test for feature support and return if failure
    
    // defaults
    var defaults = {
        ratio: 16/9, // usually either 4/3 or 16/9 -- tweak as needed
        videoId: 'ZCAnLxRvNNc', // toy robot in space is a good default, no?
        mute: true,
        repeat: true,
        width: $(window).width(),
        wrapperZIndex: 99,
        playButtonClass: 'tubular-play',
        pauseButtonClass: 'tubular-pause',
        muteButtonClass: 'tubular-mute',
        volumeUpClass: 'tubular-volume-up',
        volumeDownClass: 'tubular-volume-down',
        increaseVolumeBy: 10,
        start: 0
    };

    // methods

    var tubular = function(node, options) { // should be called on the wrapper div
        var options = $.extend({}, defaults, options),
            $body = $('body'), // cache body node
            $node = $(node); // cache wrapper node

        // build container
        var tubularContainer = '<div id="tubular-container" style="overflow: hidden; position: fixed; z-index: 1; width: 100%; height: 100%"><div id="tubular-player" style="position: absolute"></div></div><div id="tubular-shield" style="width: 100%; height: 100%; z-index: 2; position: absolute; left: 0; top: 0;"></div>';

        // set up css prereq's, inject tubular container and set up wrapper defaults
        $('html,body').css({'width': '100%', 'height': '100%'});
        $body.prepend(tubularContainer);
        $node.css({position: 'relative', 'z-index': options.wrapperZIndex});

        // set up iframe player, use global scope so YT api can talk
        window.player;
        window.onYouTubeIframeAPIReady = function() {
            var player = new YT.Player('tubular-player', {
                width: options.width,
                height: Math.ceil(options.width / options.ratio),
                videoId: options.videoId,
                playerVars: {
                    controls: 0,
                    showinfo: 0,
                    modestbranding: 1,
                    wmode: 'transparent'
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        };

        window.onPlayerReady = function(e) {
            resize();
            if (options.mute) e.target.mute();
            e.target.seekTo(options.start);
            e.target.playVideo();
        };

        window.onPlayerStateChange = function(state) {
            if (state.data === 0 && options.repeat) { // video ended and repeat option is set true
                player.seekTo(options.start); // restart
            }
        };

        // resize handler updates width, height and offset of player after resize/init
        var resize = function() {
            var width = $(window).width(),
                pWidth, // player width, to be defined
                height = $(window).height(),
                pHeight, // player height, tbd
                $tubularPlayer = $('#tubular-player');

            // when screen aspect ratio differs from video, video must center and underlay one dimension

            if (width / options.ratio < height) { // if new video height < window height (gap underneath)
                pWidth = Math.ceil(height * options.ratio); // get new player width
                $tubularPlayer.width(pWidth).height(height).css({left: (width - pWidth) / 2, top: 0}); // player width is greater, offset left; reset top
            } else { // new video width < window width (gap to right)
                pHeight = Math.ceil(width / options.ratio); // get new player height
                $tubularPlayer.width(width).height(pHeight).css({left: 0, top: (height - pHeight) / 2}); // player height is greater, offset top; reset left
            }

        };

        // events
        $(window).on('resize.tubular', function() {
            resize();
        });

        $('body').on('click','.' + options.playButtonClass, function(e) { // play button
            e.preventDefault();
            player.playVideo();
        }).on('click', '.' + options.pauseButtonClass, function(e) { // pause button
            e.preventDefault();
            player.pauseVideo();
        }).on('click', '.' + options.muteButtonClass, function(e) { // mute button
            e.preventDefault();
            (player.isMuted()) ? player.unMute() : player.mute();
        }).on('click', '.' + options.volumeDownClass, function(e) { // volume down button
            e.preventDefault();
            var currentVolume = player.getVolume();
            if (currentVolume < options.increaseVolumeBy) currentVolume = options.increaseVolumeBy;
            player.setVolume(currentVolume - options.increaseVolumeBy);
        }).on('click', '.' + options.volumeUpClass, function(e) { // volume up button
            e.preventDefault();
            if (player.isMuted()) player.unMute(); // if mute is on, unmute
            var currentVolume = player.getVolume();
            if (currentVolume > 100 - options.increaseVolumeBy) currentVolume = 100 - options.increaseVolumeBy;
            player.setVolume(currentVolume + options.increaseVolumeBy);
        });
    };

    // load yt iframe js api

    var tag = document.createElement('script');
    tag.src = "//www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // create plugin

    $.fn.tubular = function (options) {
        return this.each(function () {
            if (!$.data(this, 'tubular_instantiated')) { // let's only run one
                $.data(this, 'tubular_instantiated', tubular(this, options));
            }
        });
    };

})(jQuery, window);/**
 * Javascript utilities
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

/* global jQuery:false */
/* global HOGWORDS_STORAGE:false */

/* Global variables manipulations
---------------------------------------------------------------- */

(function(){
	"use strict";

	// Global variables storage
	if (typeof HOGWORDS_STORAGE == 'undefined') window.HOGWORDS_STORAGE = {};
	
	// Get global variable
	window.hogwords_storage_get = function(var_name) {
		return hogwords_isset(HOGWORDS_STORAGE[var_name]) ? HOGWORDS_STORAGE[var_name] : '';
	};
	
	// Set global variable
	window.hogwords_storage_set = function(var_name, value) {
		HOGWORDS_STORAGE[var_name] = value;
	};
	
	// Inc/Dec global variable with specified value
	window.hogwords_storage_inc = function(var_name) {
		var value = arguments[1]===undefined ? 1 : arguments[1];
		HOGWORDS_STORAGE[var_name] += value;
	};
	
	// Concatenate global variable with specified value
	window.hogwords_storage_concat = function(var_name, value) {
		HOGWORDS_STORAGE[var_name] += ''+value;
	};
	
	// Get global array element
	window.hogwords_storage_get_array = function(var_name, key) {
		return hogwords_isset(HOGWORDS_STORAGE[var_name][key]) ? HOGWORDS_STORAGE[var_name][key] : '';
	};
	
	// Set global array element
	window.hogwords_storage_set_array = function(var_name, key, value) {
		if (!hogwords_isset(HOGWORDS_STORAGE[var_name])) HOGWORDS_STORAGE[var_name] = {};
		HOGWORDS_STORAGE[var_name][key] = value;
	};
	
	// Inc/Dec global array element with specified value
	window.hogwords_storage_inc_array = function(var_name, key) {
		var value = arguments[2]===undefined ? 1 : arguments[2];
		HOGWORDS_STORAGE[var_name][key] += value;
	};
	
	// Concatenate global array element with specified value
	window.hogwords_storage_concat_array = function(var_name, key, value) {
		HOGWORDS_STORAGE[var_name][key] += ''+value;
	};
	
	
	
	/* PHP-style functions
	---------------------------------------------------------------- */
	window.hogwords_isset = function(obj) {
		return typeof(obj) != 'undefined';
	};
	
	window.hogwords_empty = function(obj) {
		return typeof(obj) == 'undefined' || (typeof(obj)=='object' && obj == null) || (typeof(obj)=='array' && obj.length == 0) || (typeof(obj)=='string' && hogwords_alltrim(obj)=='') || obj===0;
	};
	
	window.hogwords_is_array = function(obj)  {
		return typeof(obj)=='array';
	};
	
	window.hogwords_is_object = function(obj)  {
		return typeof(obj)=='object';
	};
	
	window.hogwords_clone_object = function(obj) {
		if (obj == null || typeof(obj) != 'object') {
			return obj;
		}
		var temp = {};
		for (var key in obj) {
			temp[key] = hogwords_clone_object(obj[key]);
		}
		return temp;
	};
	
	window.hogwords_merge_objects = function(obj1, obj2)  {
		for (var i in obj2) obj1[i] = obj2[i];
		return obj1;
	};
	
	// Generates a storable representation of a value
	window.hogwords_serialize = function(mixed_val) {
		var obj_to_array = arguments.length==1 || argument[1]===true;
	
		switch (typeof(mixed_val)) {
	
			case "number":
				if (isNaN(mixed_val) || !isFinite(mixed_val))
					return false;
				else
					return (Math.floor(mixed_val) == mixed_val ? "i" : "d") + ":" + mixed_val + ";";
	
			case "string":
				return "s:" + mixed_val.length + ":\"" + mixed_val + "\";";
	
			case "boolean":
				return "b:" + (mixed_val ? "1" : "0") + ";";
	
			case "object":
				if (mixed_val == null)
					return "N;";
				else if (mixed_val instanceof Array) {
					var idxobj = { idx: -1 };
					var map = [];
					for (var i=0; i < mixed_val.length; i++) {
						idxobj.idx++;
						var ser = hogwords_serialize(mixed_val[i]);
						if (ser)
							map.push(hogwords_serialize(idxobj.idx) + ser);
					}                                      
					return "a:" + mixed_val.length + ":{" + map.join("") + "}";
				} else {
					var class_name = hogwords_get_class(mixed_val);
					if (class_name == undefined)
						return false;
					var props = new Array();
					for (var prop in mixed_val) {
						var ser = hogwords_serialize(mixed_val[prop]);
						if (ser)
							props.push(hogwords_serialize(prop) + ser);
					}
					if (obj_to_array)
						return "a:" + props.length + ":{" + props.join("") + "}";
					else
						return "O:" + class_name.length + ":\"" + class_name + "\":" + props.length + ":{" + props.join("") + "}";
				}
	
			case "undefined":
				return "N;";
		}
		return false;
	};
	
	// Returns the name of the class of an object
	window.hogwords_get_class = function(obj) {
		if (obj instanceof Object && !(obj instanceof Array) && !(obj instanceof Function) && obj.constructor) {
			var arr = obj.constructor.toString().match(/function\s*(\w+)/);
			if (arr && arr.length == 2) return arr[1];
		}
		return false;
	};
	
	
	/* String functions
	---------------------------------------------------------------- */
	
	window.hogwords_in_list = function(str, list) {
		var delim = arguments[2]!==undefined ? arguments[2] : '|';
		var icase = arguments[3]!==undefined ? arguments[3] : true;
		var retval = false;
		if (icase) {
			if (typeof(str)=='string') str = str.toLowerCase();
			list = list.toLowerCase();
		}
		var parts = list.split(delim);
		for (var i=0; i < parts.length; i++) {
			if (parts[i]==str) {
				retval=true;
				break;
			}
		}
		return retval;
	};
	
	window.hogwords_alltrim = function(str) {
		var dir = arguments[1]!==undefined ? arguments[1] : 'a';
		var rez = '';
		var i, start = 0, end = str.length-1;
		if (dir=='a' || dir=='l') {
			for (i=0; i < str.length; i++) {
				if (str.substr(i,1)!=' ') {
					start = i;
					break;
				}
			}
		}
		if (dir=='a' || dir=='r') {
			for (i=str.length-1; i >= 0; i--) {
				if (str.substr(i,1)!=' ') {
					end = i;
					break;
				}
			}
		}
		return str.substring(start, end+1);
	};
	
	window.hogwords_ltrim = function(str) {
		return hogwords_alltrim(str, 'l');
	};
	
	window.hogwords_rtrim = function(str) {
		return hogwords_alltrim(str, 'r');
	};
	
	window.hogwords_padl = function(str, len) {
		var ch = arguments[2]!==undefined ? arguments[2] : ' ';
		var rez = str.substr(0,len);
		if (rez.length < len) {
			for (var i=0; i < len-str.length; i++)
				rez += ch;
		}
		return rez;
	};
	
	window.hogwords_padr = function(str, len) {
		var ch = arguments[2]!==undefined ? arguments[2] : ' ';
		var rez = str.substr(0,len);
		if (rez.length < len) {
			for (var i=0; i < len-str.length; i++)
				rez = ch + rez;
		}
		return rez;
	};
	
	window.hogwords_padc = function(str, len) {
		var ch = arguments[2]!==undefined ? arguments[2] : ' ';
		var rez = str.substr(0,len);
		if (rez.length < len) {
			for (var i=0; i < Math.floor((len-str.length)/2); i++)
				rez = ch + rez + ch;
		}
		return rez+(rez.length<len ? ch : '');
	};
	
	window.hogwords_replicate = function(str, num) {
		var rez = '';
		for (var i=0; i < num; i++) {
			rez += str;
		}
		return rez;
	};
	
	window.hogwords_prepare_macros = function(str) {
		return str
			.replace(/\{\{/g, "<i>")
			.replace(/\}\}/g, "</i>")
			.replace(/\(\(/g, "<b>")
			.replace(/\)\)/g, "</b>")
			.replace(/\|\|/g, "<br>");
	};
	
	
	
	/* Numbers functions
	---------------------------------------------------------------- */
	
	// Round number to specified precision.
	window.hogwords_round_number = function(num) {
		var precision = arguments[1]!==undefined ? arguments[1] : 0;
		var p = Math.pow(10, precision);
		return Math.round(num*p)/p;
	};
	
	// Clear number from any characters and append it with 0 to desired precision
	window.hogwords_clear_number = function(num) {
		var precision = arguments[1]!==undefined ? arguments[1] : 0;
		var defa = arguments[2]!==undefined ? arguments[2] : 0;
		var res = '';
		var decimals = -1;
		num = ""+num;
		if (num=="") num=""+defa;
		for (var i=0; i < num.length; i++) {
			if (decimals==0) break;
			else if (decimals>0) decimals--;
			var ch = num.substr(i,1);
			if (ch=='.') {
				if (precision>0) {
					res += ch;
				}
				decimals = precision;
			} else if ((ch>=0 && ch<=9) || (ch=='-' && i==0))
				res+=ch;
		}
		if (precision>0 && decimals!=0) {
			if (decimals==-1) {
				res += '.';
				decimals = precision;
			}
			for (i=decimals; i > 0; i--)
				res +='0'; 
		}
		return res;
	};
	
	// Convert number from decimal to hex
	window.hogwords_dec2hex = function(n) { 
		return Number(n).toString(16);
	};
	
	// Convert number from hex to decimal
	window.hogwords_hex2dec = function(hex) {
		return parseInt(hex,16); 
	};
	
	
	
	/* Array manipulations
	---------------------------------------------------------------- */
	
	window.hogwords_in_array = function(val, thearray)  {
		var rez = false;
		for (var i=0; i < thearray.length-1; i++)  {
			if (thearray[i] == val)  {
				rez = true;
				break;
			}
		}
		return rez;
	};
	
	window.hogwords_sort_array = function(thearray)  {
		var caseSensitive = arguments[1]!==undefined ? arguments[1] : false;
		var tmp = '';
		for (var x=0; x < thearray.length-1; x++)  {
			for (var y=(x+1); y < thearray.length; y++)  {
				if (caseSensitive) {
					if (thearray[x] > thearray[y])  {
						tmp = thearray[x];
						thearray[x] = thearray[y];
						thearray[y] = tmp;
					}  
				} else {
					if (thearray[x].toLowerCase() > thearray[y].toLowerCase())  {
						tmp = thearray[x];
						thearray[x] = thearray[y];
						thearray[y] = tmp;
					}  
				}
			}  
		}
		return thearray;
	};
	
	
	
	/* Date manipulations
	---------------------------------------------------------------- */
	
	// Return array[Year, Month, Day, Hours, Minutes, Seconds]
	window.hogwords_parse_date = function(dt) {
		dt = dt.replace(/\//g, '-').replace(/\./g, '-').replace(/T/g, ' ').split('+')[0];
		var dt2 = dt.split(' ');
		var d = dt2[0].split('-');
		var t = dt2[1].split(':');
		d.push(t[0], t[1], t[2]);
		return d;
	};
	
	// Return difference string between two dates
	window.hogwords_get_date_difference = function(dt1) {
		var dt2 = arguments[1]!==undefined ? arguments[1] : '';
		var short_date = arguments[2]!==undefined ? arguments[2] : true;
		var sec = arguments[3]!==undefined ? arguments[3] : false;
		var a1 = hogwords_parse_date(dt1);
		dt1 = Date.UTC(a1[0], a1[1], a1[2], a1[3], a1[4], a1[5]);
		if (dt2 == '') {
			dt2 = new Date();
			var a2 = [dt2.getFullYear(), dt2.getMonth()+1, dt2.getDate(), dt2.getHours(), dt2.getMinutes(), dt2.getSeconds()];
		} else
			var a2 = hogwords_parse_date(dt2);
		dt2 = Date.UTC(a2[0], a2[1], a2[2], a2[3], a2[4], a2[5]);
		var diff = Math.round((dt2 - dt1)/1000);
		var days = Math.floor(diff / (24*3600));
		diff -= days * 24 * 3600;
		var hours = Math.floor(diff / 3600);
		diff -= hours * 3600;
		var minutes = Math.floor(diff / 60);
		diff -= minutes * 60;
		var rez = '';
		if (days > 0)
			rez += (rez!='' ? ' ' : '') + days + ' day' + (days > 1 ? 's' : '');
		if ((!short_date || rez=='') && hours > 0)
			rez += (rez!='' ? ' ' : '') + hours + ' hour' + (hours > 1 ? 's' : '');
		if ((!short_date || rez=='') && minutes > 0)
			rez +=  (rez!='' ? ' ' : '') + minutes + ' minute' + (minutes > 1 ? 's' : '');
		if (sec || rez=='')
			rez +=  rez!='' || sec ? (' ' + diff + ' second' + (diff > 1 ? 's' : '')) : 'less then minute';
		return rez;
	};
	
	
	
	/* Colors functions
	---------------------------------------------------------------- */
	
	window.hogwords_hex2rgb = function(hex) {
		hex = parseInt(((hex.indexOf('#') > -1) ? hex.substring(1) : hex), 16);
		return {r: hex >> 16, g: (hex & 0x00FF00) >> 8, b: (hex & 0x0000FF)};
	};

	window.hogwords_hex2rgba = function(hex, alpha) {
		var rgb = hogwords_hex2rgb(hex);
		return 'rgba('+rgb.r+','+rgb.g+','+rgb.b+','+alpha+')';
	};

	window.hogwords_rgb2hex = function(color) {
		var aRGB;
		color = color.replace(/\s/g,"").toLowerCase();
		if (color=='rgba(0,0,0,0)' || color=='rgba(0%,0%,0%,0%)')
			color = 'transparent';
		if (color.indexOf('rgba(')==0)
			aRGB = color.match(/^rgba\((\d{1,3}[%]?),(\d{1,3}[%]?),(\d{1,3}[%]?),(\d{1,3}[%]?)\)$/i);
		else	
			aRGB = color.match(/^rgb\((\d{1,3}[%]?),(\d{1,3}[%]?),(\d{1,3}[%]?)\)$/i);
		
		if(aRGB) {
			color = '';
			for (var i=1; i <= 3; i++) 
				color += Math.round((aRGB[i][aRGB[i].length-1]=="%"?2.55:1)*parseInt(aRGB[i])).toString(16).replace(/^(.)$/,'0$1');
		} else 
			color = color.replace(/^#?([\da-f])([\da-f])([\da-f])$/i, '$1$1$2$2$3$3');
		return (color.substr(0,1)!='#' ? '#' : '') + color;
	};
	
	window.hogwords_components2hex = function(r,g,b) {
		return '#'+
			Number(r).toString(16).toUpperCase().replace(/^(.)$/,'0$1') +
			Number(g).toString(16).toUpperCase().replace(/^(.)$/,'0$1') +
			Number(b).toString(16).toUpperCase().replace(/^(.)$/,'0$1');
	};
	
	window.hogwords_rgb2components = function(color) {
		color = hogwords_rgb2hex(color);
		var matches = color.match(/^#?([\dabcdef]{2})([\dabcdef]{2})([\dabcdef]{2})$/i);
		if (!matches) return false;
		for (var i=1, rgb = new Array(3); i <= 3; i++)
			rgb[i-1] = parseInt(matches[i],16);
		return rgb;
	};
	
	window.hogwords_hex2hsb = function(hex) {
		var h = arguments[1]!==undefined ? arguments[1] : 0;
		var s = arguments[2]!==undefined ? arguments[2] : 0;
		var b = arguments[3]!==undefined ? arguments[3] : 0;
		var hsb = hogwords_rgb2hsb(hogwords_hex2rgb(hex));
		hsb.h = Math.min(359, hsb.h + h);
		hsb.s = Math.min(100, hsb.s + s);
		hsb.b = Math.min(100, hsb.b + b);
		return hsb;
	};
	
	window.hogwords_hsb2hex = function(hsb) {
		var rgb = hogwords_hsb2rgb(hsb);
		return hogwords_components2hex(rgb.r, rgb.g, rgb.b);
	};
	
	window.hogwords_rgb2hsb = function(rgb) {
		var hsb = {};
		hsb.b = Math.max(Math.max(rgb.r,rgb.g),rgb.b);
		hsb.s = (hsb.b <= 0) ? 0 : Math.round(100*(hsb.b - Math.min(Math.min(rgb.r,rgb.g),rgb.b))/hsb.b);
		hsb.b = Math.round((hsb.b /255)*100);
		if ((rgb.r==rgb.g) && (rgb.g==rgb.b))  hsb.h = 0;
		else if (rgb.r>=rgb.g && rgb.g>=rgb.b) hsb.h = 60*(rgb.g-rgb.b)/(rgb.r-rgb.b);
		else if (rgb.g>=rgb.r && rgb.r>=rgb.b) hsb.h = 60  + 60*(rgb.g-rgb.r)/(rgb.g-rgb.b);
		else if (rgb.g>=rgb.b && rgb.b>=rgb.r) hsb.h = 120 + 60*(rgb.b-rgb.r)/(rgb.g-rgb.r);
		else if (rgb.b>=rgb.g && rgb.g>=rgb.r) hsb.h = 180 + 60*(rgb.b-rgb.g)/(rgb.b-rgb.r);
		else if (rgb.b>=rgb.r && rgb.r>=rgb.g) hsb.h = 240 + 60*(rgb.r-rgb.g)/(rgb.b-rgb.g);
		else if (rgb.r>=rgb.b && rgb.b>=rgb.g) hsb.h = 300 + 60*(rgb.r-rgb.b)/(rgb.r-rgb.g);
		else 								   hsb.h = 0;
		hsb.h = Math.round(hsb.h);
		return hsb;
	};
	
	window.hogwords_hsb2rgb = function(hsb) {
		var rgb = {};
		var h = Math.round(hsb.h);
		var s = Math.round(hsb.s*255/100);
		var v = Math.round(hsb.b*255/100);
		if (s == 0) {
			rgb.r = rgb.g = rgb.b = v;
		} else {
			var t1 = v;
			var t2 = (255-s)*v/255;
			var t3 = (t1-t2)*(h%60)/60;
			if (h==360) h = 0;
			if (h<60) 		{ rgb.r=t1;	rgb.b=t2;   rgb.g=t2+t3; }
			else if (h<120) { rgb.g=t1; rgb.b=t2;	rgb.r=t1-t3; }
			else if (h<180) { rgb.g=t1; rgb.r=t2;	rgb.b=t2+t3; }
			else if (h<240) { rgb.b=t1; rgb.r=t2;	rgb.g=t1-t3; }
			else if (h<300) { rgb.b=t1; rgb.g=t2;	rgb.r=t2+t3; }
			else if (h<360) { rgb.r=t1; rgb.g=t2;	rgb.b=t1-t3; }
			else 			{ rgb.r=0;  rgb.g=0;	rgb.b=0;	 }
		}
		return { r:Math.round(rgb.r), g:Math.round(rgb.g), b:Math.round(rgb.b) };
	};
	
	window.hogwords_color_picker = function(){
		var id = arguments[0]!==undefined ? arguments[0] : "iColorPicker"+Math.round(Math.random()*1000);
		var colors = arguments[1]!==undefined ? arguments[1] : 
		'#f00,#ff0,#0f0,#0ff,#00f,#f0f,#fff,#ebebeb,#e1e1e1,#d7d7d7,#cccccc,#c2c2c2,#b7b7b7,#acacac,#a0a0a0,#959595,'
		+'#ee1d24,#fff100,#00a650,#00aeef,#2f3192,#ed008c,#898989,#7d7d7d,#707070,#626262,#555,#464646,#363636,#262626,#111,#000,'
		+'#f7977a,#fbad82,#fdc68c,#fff799,#c6df9c,#a4d49d,#81ca9d,#7bcdc9,#6ccff7,#7ca6d8,#8293ca,#8881be,#a286bd,#bc8cbf,#f49bc1,#f5999d,'
		+'#f16c4d,#f68e54,#fbaf5a,#fff467,#acd372,#7dc473,#39b778,#16bcb4,#00bff3,#438ccb,#5573b7,#5e5ca7,#855fa8,#a763a9,#ef6ea8,#f16d7e,'
		+'#ee1d24,#f16522,#f7941d,#fff100,#8fc63d,#37b44a,#00a650,#00a99e,#00aeef,#0072bc,#0054a5,#2f3192,#652c91,#91278f,#ed008c,#ee105a,'
		+'#9d0a0f,#a1410d,#a36209,#aba000,#588528,#197b30,#007236,#00736a,#0076a4,#004a80,#003370,#1d1363,#450e61,#62055f,#9e005c,#9d0039,'
		+'#790000,#7b3000,#7c4900,#827a00,#3e6617,#045f20,#005824,#005951,#005b7e,#003562,#002056,#0c004b,#30004a,#4b0048,#7a0045,#7a0026';
		var colorsList = colors.split(',');
		var tbl = '<table class="colorPickerTable"><thead>';
		for (var i=0; i < colorsList.length; i++) {
			if (i%16==0) tbl += (i>0 ? '</tr>' : '') + '<tr>';
			tbl += '<td style="background-color:'+colorsList[i]+'">&nbsp;</td>';
		}
		tbl += '</tr></thead><tbody>'
			+ '<tr style="height:60px;">'
			+ '<td colspan="8" id="'+id+'_colorPreview" style="vertical-align:middle;text-align:center;border:1px solid #000;background:#fff;">'
			+ '<input style="width:55px;color:#000;border:1px solid rgb(0, 0, 0);padding:5px;background-color:#fff;font:11px Arial, Helvetica, sans-serif;" maxlength="7" />'
			+ '<a href="#" id="'+id+'_moreColors" class="iColorPicker_moreColors"></a>'
			+ '</td>'
			+ '<td colspan="8" id="'+id+'_colorOriginal" style="vertical-align:middle;text-align:center;border:1px solid #000;background:#fff;">'
			+ '<input style="width:55px;color:#000;border:1px solid rgb(0, 0, 0);padding:5px;background-color:#fff;font:11px Arial, Helvetica, sans-serif;" readonly="readonly" />'
			+ '</td>'
			+ '</tr></tbody></table>';
	
		jQuery(document.createElement("div"))
			.attr("id", id)
			.css('display','none')
			.html(tbl)
			.appendTo("body")
			.addClass("iColorPickerTable")
			.on('mouseover', 'thead td', function(){
				var aaa = hogwords_rgb2hex(jQuery(this).css('background-color'));
				jQuery('#'+id+'_colorPreview').css('background',aaa);
				jQuery('#'+id+'_colorPreview input').val(aaa);
			})
			.on('keypress', '#'+id+'_colorPreview input', function(key){
				var aaa = jQuery(this).val();
				if (aaa.length<7 && ((key.which>=48 && key.which<=57) || (key.which>=97 && key.which<=102) || (key.which===35 || aaa.length===0))) {
					aaa += String.fromCharCode(key.which);
				} else if (key.which == 8 && aaa.length>0) {
					aaa = aaa.substring(0, aaa.length-1);
				} else if (key.which===13 && (aaa.length===4 || aaa.length===7)) {
					var fld  = jQuery('#'+id).data('field');
					var func = jQuery('#'+id).data('func');
					if (func!=null && func!='undefined') {
						func(fld, aaa);
					} else {
						fld.val(aaa).css('backgroundColor', aaa).trigger('change');
					}
					jQuery('#'+id+'_Bg').fadeOut(500);
					jQuery('#'+id).fadeOut(500);
					
				} else {
					key.preventDefault();
					return false;
				}
				if (aaa.substr(0,1)==='#' && (aaa.length===4 || aaa.length===7)) {
					jQuery('#'+id+'_colorPreview').css('background',aaa);
				}
			})
			.on('click', 'thead td', function(e){
				var fld  = jQuery('#'+id).data('field');
				var func = jQuery('#'+id).data('func');
				var aaa  = hogwords_rgb2hex(jQuery(this).css('background-color'));
				if (func!=null && func!='undefined') {
					func(fld, aaa);
				} else {
					fld.val(aaa).css('backgroundColor', aaa).trigger('change');
				}
				jQuery('#'+id+'_Bg').fadeOut(500);
				jQuery('#'+id).fadeOut(500);
				e.preventDefault();
				return false;
			})
			.on('click', 'tbody .iColorPicker_moreColors', function(e){
				var thead  = jQuery(this).parents('table').find('thead');
				var out = '';
				if (thead.hasClass('more_colors')) {
					for (var i=0; i < colorsList.length; i++) {
						if (i%16==0) out += (i>0 ? '</tr>' : '') + '<tr>';
						out += '<td style="background-color:'+colorsList[i]+'">&nbsp;</td>';
					}
					thead.removeClass('more_colors').empty().html(out+'</tr>');
					jQuery('#'+id+'_colorPreview').attr('colspan', 8);
					jQuery('#'+id+'_colorOriginal').attr('colspan', 8);
				} else {
					var rgb=[0,0,0], i=0, j=-1;	// Set j=-1 or j=0 - show 2 different colors layouts
					while (rgb[0]<0xF || rgb[1]<0xF || rgb[2]<0xF) {
						if (i%18==0) out += (i>0 ? '</tr>' : '') + '<tr>';
						i++;
						out += '<td style="background-color:'+hogwords_components2hex(rgb[0]*16+rgb[0],rgb[1]*16+rgb[1],rgb[2]*16+rgb[2])+'">&nbsp;</td>';
						rgb[2]+=3;
						if (rgb[2]>0xF) {
							rgb[1]+=3;
							if (rgb[1]>(j===0 ? 6 : 0xF)) {
								rgb[0]+=3;
								if (rgb[0]>0xF) {
									if (j===0) {
										j=1;
										rgb[0]=0;
										rgb[1]=9;
										rgb[2]=0;
									} else {
										break;
									}
								} else {
									rgb[1]=(j < 1 ? 0 : 9);
									rgb[2]=0;
								}
							} else {
								rgb[2]=0;
							}
						}
					}
					thead.addClass('more_colors').empty().html(out+'<td  style="background-color:#ffffff" colspan="8">&nbsp;</td></tr>');
					jQuery('#'+id+'_colorPreview').attr('colspan', 9);
					jQuery('#'+id+'_colorOriginal').attr('colspan', 9);
				}
				jQuery('#'+id+' table.colorPickerTable thead td')
					.css({
						'width':'12px',
						'height':'14px',
						'border':'1px solid #000',
						'cursor':'pointer'
					});
				e.preventDefault();
				return false;
			});
		jQuery(document.createElement("div"))
			.attr("id", id+"_Bg")
			.on('click', function(e) {
				jQuery("#"+id+"_Bg").fadeOut(500);
				jQuery("#"+id).fadeOut(500);
				e.preventDefault();
				return false;
			})
			.appendTo("body");
		jQuery('#'+id+' table.colorPickerTable thead td')
			.css({
				'width':'12px',
				'height':'14px',
				'border':'1px solid #000',
				'cursor':'pointer'
			});
		jQuery('#'+id+' table.colorPickerTable')
			.css({'border-collapse':'collapse'});
		jQuery('#'+id)
			.css({
				'border':'1px solid #ccc',
				'background':'#333',
				'padding':'5px',
				'color':'#fff'
			});
		jQuery('#'+id+'_colorPreview')
			.css({'height':'50px'});
		return id;
	};
	
	window.hogwords_color_picker_show = function(id, fld, func) { 
		if (id===null || id==='') {
			id = jQuery('.iColorPickerTable').attr('id');
		}
		var eICP = fld.offset();
		var w = jQuery('#'+id).width();
		var h = jQuery('#'+id).height();
		var l = eICP.left + w < jQuery(window).width()-10 ? eICP.left : jQuery(window).width()-10 - w;
		var t = eICP.top + fld.outerHeight() + h < jQuery(document).scrollTop() + jQuery(window).height()-10 ? eICP.top + fld.outerHeight() : eICP.top - h - 13;
		jQuery("#"+id)
			.data({field: fld, func: func})
			.css({
				'top':t+"px",
				'left':l+"px",
				'position':'absolute',
				'z-index':999999
			})
			.fadeIn(500);
		jQuery("#"+id+"_Bg")
			.css({
				'position':'fixed',
				'z-index':999998,
				'top':0,
				'left':0,
				'width':'100%',
				'height':'100%'
			})
			.fadeIn(500);
		var def = fld.val().substr(0, 1)=='#' ? fld.val() : hogwords_rgb2hex(fld.css('backgroundColor'));
		jQuery('#'+id+'_colorPreview input,#'+id+'_colorOriginal input').val(def);
		jQuery('#'+id+'_colorPreview,#'+id+'_colorOriginal').css('background',def);
	};
	
	
	
	/* Cookies manipulations
	---------------------------------------------------------------- */
	
	window.hogwords_get_cookie = function(name) {
		var defa = arguments[1]!==undefined ? arguments[1] : null;
		var start = document.cookie.indexOf(name + '=');
		var len = start + name.length + 1;
		if ((!start) && (name != document.cookie.substring(0, name.length))) {
			return defa;
		}
		if (start == -1)
			return defa;
		var end = document.cookie.indexOf(';', len);
		if (end == -1)
			end = document.cookie.length;
		return unescape(document.cookie.substring(len, end));
	};
	
	
	window.hogwords_set_cookie = function(name, value) {
		var expires = arguments[2]!==undefined ? arguments[2] : 0;
		var path    = arguments[3]!==undefined ? arguments[3] : '/';
		var domain  = arguments[4]!==undefined ? arguments[4] : '';
		var secure  = arguments[5]!==undefined ? arguments[5] : '';
		var today = new Date();
		today.setTime(today.getTime());
		if (expires) {
			expires = expires * 1000 * 60 * 60 * 24;
		}
		var expires_date = new Date(today.getTime() + (expires));
		document.cookie = name + '='
				+ escape(value)
				+ ((expires) ? ';expires=' + expires_date.toGMTString() : '')
				+ ((path)    ? ';path=' + path : '')
				+ ((domain)  ? ';domain=' + domain : '')
				+ ((secure)  ? ';secure' : '');
	};
	
	
	window.hogwords_del_cookie = function(name, path, domain) {
		var path   = arguments[1]!==undefined ? arguments[1] : '/';
		var domain = arguments[2]!==undefined ? arguments[2] : '';
		if (hogwords_get_cookie(name))
			document.cookie = name + '=' + ((path) ? ';path=' + path : '')
					+ ((domain) ? ';domain=' + domain : '')
					+ ';expires=Thu, 01-Jan-1970 00:00:01 GMT';
	};
	
	
	
	/* ListBox and ComboBox manipulations
	---------------------------------------------------------------- */
	
	window.hogwords_clear_listbox = function(box) {
		for (var i=box.options.length-1; i >= 0; i--)
			box.options[i] = null;
	};
	
	window.hogwords_add_listbox_item = function(box, val, text) {
		var item = new Option();
		item.value = val;
		item.text = text;
		box.options.add(item);
	};
	
	window.hogwords_del_listbox_item_by_value = function(box, val) {
		for (var i=0; i < box.options.length; i++) {
			if (box.options[i].value == val) {
				box.options[i] = null;
				break;
			}
		}
	};
	
	window.hogwords_del_listbox_item_by_text = function(box, txt) {
		for (var i=0; i < box.options.length; i++) {
			if (box.options[i].text == txt) {
				box.options[i] = null;
				break;
			}
		}
	};
	
	window.hogwords_find_listbox_item_by_value = function(box, val) {
		var idx = -1;
		for (var i=0; i < box.options.length; i++) {
			if (box.options[i].value == val) {
				idx = i;
				break;
			}
		}
		return idx;
	};
	
	window.hogwords_find_listbox_item_by_text = function(box, txt) {
		var idx = -1;
		for (var i=0; i < box.options.length; i++) {
			if (box.options[i].text == txt) {
				idx = i;
				break;
			}
		}
		return idx;
	};
	
	window.hogwords_select_listbox_item_by_value = function(box, val) {
		for (var i = 0; i < box.options.length; i++) {
			box.options[i].selected = (val == box.options[i].value);
		}
	};
	
	window.hogwords_select_listbox_item_by_text = function(box, txt) {
		for (var i = 0; i < box.options.length; i++) {
			box.options[i].selected = (txt == box.options[i].text);
		}
	};
	
	window.hogwords_get_listbox_values = function(box) {
		var delim = arguments[1]!==undefined ? arguments[1] : ',';
		var str = '';
		for (var i=0; i < box.options.length; i++) {
			str += (str ? delim : '') + box.options[i].value;
		}
		return str;
	};
	
	window.hogwords_get_listbox_texts = function(box) {
		var delim = arguments[1]!==undefined ? arguments[1] : ',';
		var str = '';
		for (var i=0; i < box.options.length; i++) {
			str += (str ? delim : '') + box.options[i].text;
		}
		return str;
	};
	
	window.hogwords_sort_listbox = function(box)  {
		var temp_opts = new Array();
		var temp = new Option();
		for(var i=0; i<box.options.length; i++)  {
			temp_opts[i] = box.options[i].clone();
		}
		for(var x=0; x<temp_opts.length-1; x++)  {
			for(var y=(x+1); y<temp_opts.length; y++)  {
				if(temp_opts[x].text > temp_opts[y].text)  {
					temp = temp_opts[x];
					temp_opts[x] = temp_opts[y];
					temp_opts[y] = temp;
				}  
			}  
		}
		for(var i=0; i<box.options.length; i++)  {
			box.options[i] = temp_opts[i].clone();
		}
	};
	
	window.hogwords_get_listbox_selected_index = function(box) {
		for (var i = 0; i < box.options.length; i++) {
			if (box.options[i].selected)
				return i;
		}
		return -1;
	};
	
	window.hogwords_get_listbox_selected_value = function(box) {
		for (var i = 0; i < box.options.length; i++) {
			if (box.options[i].selected) {
				return box.options[i].value;
			}
		}
		return null;
	};
	
	window.hogwords_get_listbox_selected_text = function(box) {
		for (var i = 0; i < box.options.length; i++) {
			if (box.options[i].selected) {
				return box.options[i].text;
			}
		}
		return null;
	};
	
	window.hogwords_get_listbox_selected_option = function(box) {
		for (var i = 0; i < box.options.length; i++) {
			if (box.options[i].selected) {
				return box.options[i];
			}
		}
		return null;
	};
	
	
	
	/* Radio buttons manipulations
	---------------------------------------------------------------- */
	
	window.hogwords_get_radio_value = function(radioGroupObj) {
		for (var i=0; i < radioGroupObj.length; i++)
			if (radioGroupObj[i].checked) return radioGroupObj[i].value;
		return null;
	};
	
	window.hogwords_set_radio_checked_by_num = function(radioGroupObj, num) {
		for (var i=0; i < radioGroupObj.length; i++)
			if (radioGroupObj[i].checked && i!=num) radioGroupObj[i].checked=false;
			else if (i==num) radioGroupObj[i].checked=true;
	};
	
	window.hogwords_set_radio_checked_by_value = function(radioGroupObj, val) {
		for (var i=0; i < radioGroupObj.length; i++)
			if (radioGroupObj[i].checked && radioGroupObj[i].value!=val) radioGroupObj[i].checked=false;
			else if (radioGroupObj[i].value==val) radioGroupObj[i].checked=true;
	};
	
	
	
	/* Form manipulations
	---------------------------------------------------------------- */
	
	window.hogwords_form_validate = function(form, opt) {
		var error_msg = '';
		form.find(":input").each(function() {
			if (error_msg!='' && opt.exit_after_first_error) return;
			for (var i = 0; i < opt.rules.length; i++) {
				if (jQuery(this).attr("name") == opt.rules[i].field) {
					var val = jQuery(this).val();
					var error = false;
					if (typeof(opt.rules[i].min_length) == 'object') {
						if (opt.rules[i].min_length.value > 0 && val.length < opt.rules[i].min_length.value) {
							if (error_msg=='') jQuery(this).get(0).focus();
							error_msg += '<p class="error_item">' + (typeof(opt.rules[i].min_length.message)!='undefined' ? opt.rules[i].min_length.message : opt.error_message_text ) + '</p>';
							error = true;
						}
					}
					if ((!error || !opt.exit_after_first_error) && typeof(opt.rules[i].max_length) == 'object') {
						if (opt.rules[i].max_length.value > 0 && val.length > opt.rules[i].max_length.value) {
							if (error_msg=='') jQuery(this).get(0).focus();
							error_msg += '<p class="error_item">' + (typeof(opt.rules[i].max_length.message)!='undefined' ? opt.rules[i].max_length.message : opt.error_message_text ) + '</p>';
							error = true;
						}
					}
					if ((!error || !opt.exit_after_first_error) && typeof(opt.rules[i].mask) == 'object') {
						if (opt.rules[i].mask.value != '') {
							var regexp = new RegExp(opt.rules[i].mask.value);
							if (!regexp.test(val)) {
								if (error_msg=='') jQuery(this).get(0).focus();
								error_msg += '<p class="error_item">' + (typeof(opt.rules[i].mask.message)!='undefined' ? opt.rules[i].mask.message : opt.error_message_text ) + '</p>';
								error = true;
							}
						}
					}
					if ((!error || !opt.exit_after_first_error) && typeof(opt.rules[i].state) == 'object') {
						if (opt.rules[i].state.value=='checked' && !jQuery(this).get(0).checked) {
							if (error_msg=='') jQuery(this).get(0).focus();
							error_msg += '<p class="error_item">' + (typeof(opt.rules[i].state.message)!='undefined' ? opt.rules[i].state.message : opt.error_message_text ) + '</p>';
							error = true;
						}
					}
					if ((!error || !opt.exit_after_first_error) && typeof(opt.rules[i].equal_to) == 'object') {
						if (opt.rules[i].equal_to.value != '' && val!=jQuery(jQuery(this).get(0).form[opt.rules[i].equal_to.value]).val()) {
							if (error_msg=='') jQuery(this).get(0).focus();
							error_msg += '<p class="error_item">' + (typeof(opt.rules[i].equal_to.message)!='undefined' ? opt.rules[i].equal_to.message : opt.error_message_text ) + '</p>';
							error = true;
						}
					}
					if (opt.error_fields_class != '') jQuery(this).toggleClass(opt.error_fields_class, error);
				}
			}
		});
		if (error_msg!='' && opt.error_message_show) {
			var error_message_box = form.find(".result");
			if (error_message_box.length == 0) error_message_box = form.parent().find(".result");
			if (error_message_box.length == 0) {
				form.append('<div class="result"></div>');
				error_message_box = form.find(".result");
			}
			if (opt.error_message_class) error_message_box.toggleClass(opt.error_message_class, true);
			error_message_box.html(error_msg).fadeIn();
			setTimeout(function() { error_message_box.fadeOut(); }, opt.error_message_time);
		}
		return error_msg!='';
	};
	
	
	
	/* Document manipulations
	---------------------------------------------------------------- */
	
	// Animated scroll to selected id
	window.hogwords_document_animate_to = function(id, callback) {
		var oft = !isNaN(id) ? Number(id) : 0;
		if (isNaN(id)) {
			if (id.indexOf('#')==-1) id = '#' + id;
			var obj = jQuery(id).eq(0);
			if (obj.length == 0) return;
			oft = obj.offset().top;
		}
		var st  = jQuery(window).scrollTop();
		var oft2 = Math.max(0, oft - hogwords_fixed_rows_height());
		var speed = Math.min(1200, Math.max(300, Math.round(Math.abs(oft2-st) / jQuery(window).height() * 300)));
		if (st == 0) {
			setTimeout(function() {
				if (isNaN(id)) oft = obj.offset().top;
				oft2 = Math.max(0, oft - hogwords_fixed_rows_height());
				jQuery('body,html').stop(true).animate( {scrollTop: oft2}, Math.floor(speed/2), 'linear', callback );
			}, Math.floor(speed/2));
		}
		jQuery('body,html').stop(true).animate( {scrollTop: oft2}, speed, 'linear', callback );
	};
	
	// Detect fixed rows height
	window.hogwords_fixed_rows_height = function() {
		var with_admin_bar = arguments.length>0 ? arguments[0] : true;
		var with_fixed_rows = arguments.length>1 ? arguments[1] : true;
		var oft = 0;
		// Admin bar height (if visible and fixed)
		if (with_admin_bar) {
			var admin_bar = jQuery('#wpadminbar');
			oft += admin_bar.length > 0 && admin_bar.css('display')!='none' && admin_bar.css('position')=='fixed' 
							? admin_bar.height()
							: 0;
		}
		// Fixed rows height
		if (with_fixed_rows) {
			jQuery('.sc_layouts_row_fixed_on').each(function() {
				if (jQuery(this).css('position')=='fixed')
					oft += jQuery(this).height();
			});
		}
		return oft;
	};
	
	// Change browser address without reload page
	window.hogwords_document_set_location = function(curLoc){
		try {
			history.pushState(null, null, curLoc);
			return;
		} catch(e) {}
		location.href = curLoc;
	};
	
	// Add/Change arguments to the url address
	window.hogwords_add_to_url = function(loc, prm) {
		var ignore_empty = arguments[2]!==undefined ? arguments[2] : true;
		var q = loc.indexOf('?');
		var attr = {};
		if (q > 0) {
			var qq = loc.substr(q+1).split('&');
			var parts = '';
			for (var i=0; i < qq.length; i++) {
				var parts = qq[i].split('=');
				attr[parts[0]] = parts.length>1 ? parts[1] : ''; 
			}
		}
		for (var p in prm) {
			attr[p] = prm[p];
		}
		loc = (q > 0 ? loc.substr(0, q) : loc) + '?';
		var i = 0;
		for (p in attr) {
			if (ignore_empty && attr[p]=='') continue;
			loc += (i++ > 0 ? '&' : '') + p + '=' + attr[p];
		}
		return loc;
	};
	
	// Check if url is page-inner (local) link
	window.hogwords_is_local_link = function(url) {
		var rez = url!==undefined;
		if (rez) {
			var url_pos = url.indexOf('#');
			if (url_pos == 0 && url.length == 1)
				rez = false;
			else {
				if (url_pos < 0) url_pos = url.length;
				var loc = window.location.href;
				var loc_pos = loc.indexOf('#');
				if (loc_pos > 0) loc = loc.substring(0, loc_pos);
				rez = url_pos==0;
				if (!rez) rez = loc == url.substring(0, url_pos);
			}
		}
		return rez;
	};
	
	
	
	/* Browsers detection
	---------------------------------------------------------------- */
	
	window.hogwords_browser_is_mobile = function() {
		var check = false;
		(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
		return check;
	};

	window.hogwords_browser_is_ios = function() {
		return navigator.userAgent.match(/iPad|iPhone|iPod/i) != null;
	};

	window.hogwords_is_retina = function() {
		var mediaQuery = '(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-resolution: 1.5dppx)';
		return (window.devicePixelRatio > 1) || (window.matchMedia && window.matchMedia(mediaQuery).matches);
	};
	
	
	
	/* File functions
	---------------------------------------------------------------- */
	
	window.hogwords_get_file_name = function(path) {
		path = path.replace(/\\/g, '/');
		var pos = path.lastIndexOf('/');
		if (pos >= 0)
			path = path.substr(pos+1);
		return path;
	};
	
	window.hogwords_get_file_ext = function(path) {
		var pos = path.lastIndexOf('.');
		path = pos >= 0 ? path.substr(pos+1) : '';
		return path;
	};
	
	
	
	/* Image functions
	---------------------------------------------------------------- */
	
	// Return true, if all images in the specified container are loaded
	window.hogwords_check_images_complete = function(cont) {
		var complete = true;
		cont.find('img').each(function() {
			if (!complete) return;
			if (!jQuery(this).get(0).complete) complete = false;
		});
		return complete;
	};
	
	
	
	/* Debug functions
	---------------------------------------------------------------- */
	window.hogwords_debug_object = function(obj) {
		var recursive = arguments[1] ? arguments[1] : 0;			// Show inner objects (arrays) in depth
		var showMethods = arguments[2] ? arguments[2] : false;		// Show object's methods
		var level = arguments[3] ? arguments[3] : 0;				// Nesting level (for internal usage only)
		var dispStr = "";
		var addStr = "";
		var curStr = "";
		if (level > 0) {
			dispStr += (obj===null ? "null" : typeof(obj)) + "\n";
			addStr = hogwords_replicate(' ', level*2);
		}
		if (obj!==null && (typeof(obj)=='object' || typeof(obj)=='array')) {
			for (var prop in obj) {
				if (!showMethods && typeof(obj[prop])=='function')	// || prop=='innerHTML' || prop=='outerHTML' || prop=='innerText' || prop=='outerText')
					continue;
				if (level<recursive && (typeof(obj[prop])=='object' || typeof(obj[prop])=='array') && obj[prop]!=obj)
					dispStr += addStr + prop + '=' + hogwords_debug_object(obj[prop], recursive, showMethods, level+1);
				else {
					try {
						curStr = "" + obj[prop];
					} catch (e) {
						curStr = "--- Not evaluate ---";
					}
					dispStr += addStr+prop+'='+(typeof(obj[prop])=='string' ? '"' : '')+curStr+(typeof(obj[prop])=='string' ? '"' : '')+"\n";
				}
			}
		} else if (typeof(obj)!='function')
			dispStr += addStr+(typeof(obj)=='string' ? '"' : '')+obj+(typeof(obj)=='string' ? '"' : '')+"\n";
			
		return dispStr;	//decodeURI(dispStr);
	};
	
	
	window.hogwords_debug_log = function(s, clr) {
		if (HOGWORDS_STORAGE['user_logged_in']) {
			if (jQuery('#debug_log').length == 0) {
				jQuery('body').append('<div id="debug_log"><span id="debug_log_close">x</span><pre id="debug_log_content"></pre></div>'); 
				jQuery("#debug_log_close").on('click', function(e) {
					jQuery('#debug_log').hide();
					e.preventDefault();
					return false;
				});
			}
			if (clr) jQuery('#debug_log_content').empty();
			jQuery('#debug_log_content').prepend(s+' ');
			jQuery('#debug_log').show();
		}
	};
	
	window.dcl===undefined && (window.dcl = function(s) { console.log(s); });
	window.dco===undefined && (window.dco = function(s,r) { console.log(hogwords_debug_object(s,r)); });
	window.dal===undefined && (window.dal = function(s) { if (HOGWORDS_STORAGE['user_logged_in']) alert(s); });
	window.dao===undefined && (window.dao = function(s,r) { if (HOGWORDS_STORAGE['user_logged_in']) alert(hogwords_debug_object(s,r)); });
	window.ddl===undefined && (window.ddl = function(s,c) { hogwords_debug_log(s,c); });
	window.ddo===undefined && (window.ddo = function(s,r,c) { hogwords_debug_log(hogwords_debug_object(s,r),c); });

})();/* global jQuery:false */
/* global HOGWORDS_STORAGE:false */

jQuery(document).ready(function() {
	"use strict";

	var theme_init_counter = 0;
	
	hogwords_init_actions();



	jQuery(function(){
			jQuery('.specialsparallax_true').stellar();
	});

	
	// Theme init actions
	function hogwords_init_actions() {

		if (HOGWORDS_STORAGE['vc_edit_mode'] && jQuery('.vc_empty-placeholder').length==0 && theme_init_counter++ < 30) {
			setTimeout(hogwords_init_actions, 200);
			return;
		}

		// Check fullheight elements
		jQuery(document).on('action.init_hidden_elements', hogwords_stretch_height);
		jQuery(document).on('action.init_shortcodes', hogwords_stretch_height);
		jQuery(document).on('action.sc_layouts_row_fixed_off', hogwords_stretch_height);
		jQuery(document).on('action.sc_layouts_row_fixed_on', hogwords_stretch_height);
	
		// Add resize on VC action vc-full-width-row
		// But we emulate 'action.resize_vc_row_start' and 'action.resize_vc_row_end'
		// to correct resize sliders and video inside 'boxed' pages
		var vc_resize = false;
		jQuery(document).on('action.resize_vc_row_start', function(e, el) {
			vc_resize = true;
			hogwords_resize_actions(el);
		});
	
		// Resize handlers
		jQuery(window).resize(function() {
			if (!vc_resize) {
				hogwords_resize_actions();
			}
		});
		
		// Scroll handlers
		jQuery(window).scroll(function() {
			hogwords_scroll_actions();
		});
		
		// First call to init core actions
		hogwords_ready_actions();
		hogwords_resize_actions();
		hogwords_scroll_actions();
		hogwords_init_parallax();
		hogwords_vc_tour();


		// Wait for logo load
		if (jQuery('body').hasClass('menu_style_side') && !hogwords_check_images_complete(jQuery('.menu_side_wrap .sc_layouts_logo'))) {
			setTimeout(function() {
				hogwords_stretch_sidemenu();
			}, 500);
		}
	}




	var featureParallaxScroll = false;
	function hogwords_init_parallax() {

		if (jQuery('.specialsparallax_true').length > 0) {

		var section = jQuery('.specialsparallax_true'),
			scroll = false,
			smallDelay,
			$window = jQuery(window),
			sectionHeight = section.height();

		// Create Parallax Wrapper
		section
			.css( { 'height': sectionHeight + 'px' } )
				.children()
					.not('.eut-separator-bottom')
					.wrapAll('<div class="eut-parallax-wrapper"></div>');

		updateParallax();

		// Add window events
		$window
			.on('resize', function(){
				window.clearTimeout(smallDelay);
				smallDelay = window.setTimeout( function () {
					updateParallax();
				}, 100);
			})
			.on('scroll', onWindowScroll);

		function onWindowScroll(){
			if( window.requestAnimationFrame ) {
				if(!scroll){
					window.requestAnimationFrame( updateParallax );
					scroll = true;
				}
			} else {
				updateParallax();
			}
		}

		function updateParallax(){
			var wrapper = section.find('.eut-parallax-wrapper'),
				parallaxType;

			if( section.hasClass('eut-bg-advanced-parallax') ){
				parallaxType = 'advanced';
			} else if( section.hasClass('eut-bg-fixed-section') ){
				parallaxType = 'fixed';
			} else {
				parallaxType = 'classic';
			}

			if( inViewport( section ) ){
				// References
				var scrollTop = $window.scrollTop(),
					sectionTop = section.offset().top,
					sectionW = section.outerWidth(),
					sectionH = section.outerHeight(),
					position = scrollTop * 0.2,
					elementH = sectionH + sectionTop,
					opacity = ( ( ( sectionH + sectionTop ) - scrollTop ) / sectionH ).toFixed(2),
					content = section.find('.eut-wrapper, .eut-background-wrapper');


					if( parallaxType == 'advanced' ) {
						wrapper.css({
							'position' : 'fixed',
							'top' : sectionTop,
							'height' : elementH,
							'width' : sectionW,
							transform: 'translate3d( 0px' + ', ' + -position + 'px' + ', 0px)',
							visibility: 'visible'
						});
						content.css({
							// 'opacity' : opacity
						});
					} else if( parallaxType == 'fixed' ) {
						wrapper.css({
							'position' : 'fixed',
							'top' : sectionTop,
							'height' : elementH,
							'width' : sectionW,
							visibility: 'visible'
						});
					} else {
						wrapper.css({
							'position' : 'relative',
							'height' : elementH,
							'width' : sectionW,
							transform: 'translate3d( 0px' + ', ' + position + 'px' + ', 0px)',
							visibility: 'visible'
						});
					}
			} else {
				wrapper.css({
					'position' : 'relative'
				});
			}
			scroll = false;
		}

		function inViewport( element ){
			var winTop = $window.scrollTop(),
				winBottom = winTop + $window.height(),
				elTop = element.offset().top,
				elBottom = elTop + element.outerHeight();

			return ( winBottom >= elTop && winTop <= elBottom );
		}
	}
	};

	function hogwords_vc_tour() {
		jQuery( '.vc_tta-change_on_hover' )
			.on( 'click', '.vc_tta-tab a', function(){
				var $this = jQuery( this ),
					href = $this.data( 'href' );

				if( href ){
					window.location.replace( href );
				}

				event.stopPropagation();
				return false;
			})
			.on( 'mouseover', '.vc_tta-tab a', function(){
				var $this = jQuery( this ),
					id = $this.attr( 'href' ),
					parentTab = $this.parents('.vc_tta-tabs');

				parentTab.find('.vc_tta-panels-container .vc_tta-panel.vc_active').removeClass('vc_active');

				if( id ){
					parentTab.find('.vc_tta-panels-container .vc_tta-panel' + id ).addClass('vc_active');
				}

				return false;
			});
	}



	// Theme first load actions
	//==============================================
	function hogwords_ready_actions() {
	
		// Add scheme class and js support
		//------------------------------------
		document.documentElement.className = document.documentElement.className.replace(/\bno-js\b/,'js');
		if (document.documentElement.className.indexOf(HOGWORDS_STORAGE['site_scheme'])==-1)
			document.documentElement.className += ' ' + HOGWORDS_STORAGE['site_scheme'];

		// Init background video
		//------------------------------------
		// Use Bideo to play local video
		if (HOGWORDS_STORAGE['background_video'] && jQuery('.top_panel.with_bg_video').length > 0 && window.Bideo) {
			// Waiting 10ms after mejs init
			setTimeout(function() {
				jQuery('.top_panel.with_bg_video').prepend('<video id="background_video" loop muted></video>');
				var bv = new Bideo();
				bv.init({
					// Video element
					videoEl: document.querySelector('#background_video'),
					
					// Container element
					container: document.querySelector('.top_panel'),
					
					// Resize
					resize: true,
					
					// autoplay: false,
					
					isMobile: window.matchMedia('(max-width: 768px)').matches,
					
					playButton: document.querySelector('#background_video_play'),
					pauseButton: document.querySelector('#background_video_pause'),
					src: [
						{
							src: HOGWORDS_STORAGE['background_video'],
							type: 'video/'+hogwords_get_file_ext(HOGWORDS_STORAGE['background_video'])
						}
					],
					
					// What to do once video loads (initial frame)
					onLoad: function () {
					}
				});
			}, 10);
		
		// Use Tubular to play video from Youtube
		} else if (jQuery.fn.tubular) {
			jQuery('div#background_video').each(function() {
				var youtube_code = jQuery(this).data('youtube-code');
				if (youtube_code) {
					jQuery(this).tubular({videoId: youtube_code});
					jQuery('#tubular-player').appendTo(jQuery(this)).show();
					jQuery('#tubular-container,#tubular-shield').remove();
				}
			});
		}
	
		// Tabs
		//------------------------------------
		if (jQuery('.hogwords_tabs:not(.inited)').length > 0 && jQuery.ui && jQuery.ui.tabs) {
			jQuery('.hogwords_tabs:not(.inited)').each(function () {
				// Get initially opened tab
				var init = jQuery(this).data('active');
				if (isNaN(init)) {
					init = 0;
					var active = jQuery(this).find('> ul > li[data-active="true"]').eq(0);
					if (active.length > 0) {
						init = active.index();
						if (isNaN(init) || init < 0) init = 0;
					}
				} else {
					init = Math.max(0, init);
				}
				// Init tabs
				jQuery(this).addClass('inited').tabs({
					active: init,
					show: {
						effect: 'fadeIn',
						duration: 300
					},
					hide: {
						effect: 'fadeOut',
						duration: 300
					},
					create: function( event, ui ) {
						if (ui.panel.length > 0) jQuery(document).trigger('action.init_hidden_elements', [ui.panel]);
					},
					activate: function( event, ui ) {
						if (ui.newPanel.length > 0) jQuery(document).trigger('action.init_hidden_elements', [ui.newPanel]);
					}
				});
			});
		}
		// AJAX loader for the tabs
		jQuery('.hogwords_tabs_ajax').on( "tabsbeforeactivate", function( event, ui ) {
			if (ui.newPanel.data('need-content')) hogwords_tabs_ajax_content_loader(ui.newPanel, 1, ui.oldPanel);
		});
		// AJAX loader for the pages in the tabs
		jQuery('.hogwords_tabs_ajax').on( "click", '.nav-links a', function(e) {
			var panel = jQuery(this).parents('.hogwords_tabs_content');
			var page = 1;
			var href = jQuery(this).attr('href');
			var pos = -1;
			if ((pos = href.lastIndexOf('/page/')) != -1 ) {
				page = Number(href.substr(pos+6).replace("/", ""));
				if (!isNaN(page)) page = Math.max(1, page);
			}
			hogwords_tabs_ajax_content_loader(panel, page);
			e.preventDefault();
			return false;
		});
	
		// Menu
		//----------------------------------------------
	
		// Add TOC in the side menu
		if (jQuery('.menu_side_inner').length > 0 && jQuery('#toc_menu').length > 0)
			jQuery('#toc_menu').appendTo('.menu_side_inner');
	
		// Open/Close side menu
		jQuery('.menu_side_button').on('click', function(e){
			jQuery(this).parent().toggleClass('opened');
			e.preventDefault();
			return false;
		});

		// Add images to the menu items with classes image-xxx
		jQuery('.sc_layouts_menu li[class*="image-"]').each(function() {
			var classes = jQuery(this).attr('class').split(' ');
			var icon = '';
			for (var i=0; i < classes.length; i++) {
				if (classes[i].indexOf('image-') >= 0) {
					icon = classes[i].replace('image-', '');
					break;
				}
			}
			if (icon) jQuery(this).find('>a').css('background-image', 'url('+HOGWORDS_STORAGE['theme_url']+'/trx_addons/css/icons.png/'+icon+'.png');
		});
	
		// Add arrows to the mobile menu
		jQuery('.menu_mobile .menu-item-has-children > a').append('<span class="open_child_menu"></span>');
	
		// Open/Close mobile menu
		jQuery('.sc_layouts_menu_mobile_button > a,.menu_mobile_button,.menu_mobile_description').on('click', function(e) {
			if (jQuery(this).parent().hasClass('sc_layouts_menu_mobile_button_burger') && jQuery(this).next().hasClass('sc_layouts_menu_popup')) return;
			jQuery('.menu_mobile_overlay').fadeIn();
			jQuery('.menu_mobile').addClass('opened');
			jQuery(document).trigger('action.stop_wheel_handlers');
			e.preventDefault();
			return false;
		});
		jQuery(document).on('keypress', function(e) {
			if (e.keyCode == 27) {
				if (jQuery('.menu_mobile.opened').length == 1) {
					jQuery('.menu_mobile_overlay').fadeOut();
					jQuery('.menu_mobile').removeClass('opened');
					jQuery(document).trigger('action.start_wheel_handlers');
					e.preventDefault();
					return false;
				}
			}
		});;
		jQuery('.menu_mobile_close, .menu_mobile_overlay').on('click', function(e){
			jQuery('.menu_mobile_overlay').fadeOut();
			jQuery('.menu_mobile').removeClass('opened');
			jQuery(document).trigger('action.start_wheel_handlers');
			e.preventDefault();
			return false;
		});
	
		// Open/Close mobile submenu
		jQuery('.menu_mobile').on('click', 'li a, li a .open_child_menu', function(e) {
			var $a = jQuery(this).hasClass('open_child_menu') ? jQuery(this).parent() : jQuery(this);
			if ($a.parent().hasClass('menu-item-has-children')) {
				if ($a.attr('href')=='#' || jQuery(this).hasClass('open_child_menu')) {
					if ($a.siblings('ul:visible').length > 0)
						$a.siblings('ul').slideUp().parent().removeClass('opened');
					else {
						jQuery(this).parents('li').siblings('li').find('ul:visible').slideUp().parent().removeClass('opened');
						$a.siblings('ul').slideDown().parent().addClass('opened');
					}
				}
			}
			if (!jQuery(this).hasClass('open_child_menu') && hogwords_is_local_link($a.attr('href')))
				jQuery('.menu_mobile_close').trigger('click');
			if (jQuery(this).hasClass('open_child_menu') || $a.attr('href')=='#') {
				e.preventDefault();
				return false;
			}
		});
	
		if (!HOGWORDS_STORAGE['trx_addons_exist'] || jQuery('.top_panel.top_panel_default .sc_layouts_menu_default').length > 0) {
			// Init superfish menus
			hogwords_init_sfmenu('.sc_layouts_menu:not(.inited) > ul:not(.inited)');
			// Show menu		
			jQuery('.sc_layouts_menu:not(.inited)').each(function() {
				if (jQuery(this).find('>ul.inited').length == 1) jQuery(this).addClass('inited');
			});
			// Generate 'scroll' event after the menu is showed
			jQuery(window).trigger('scroll');
		}

		
		// Forms
		//----------------------------------------------
	
		// Wrap select with .select_container
		jQuery('select:not(.esg-sorting-select):not([class*="trx_addons_attrib_"])').each(function() {
			var s = jQuery(this);
			if (s.css('display') != 'none' 
				&& !s.next().hasClass('select2') 
				&& !s.hasClass('select2-hidden-accessible'))
				s.wrap('<div class="select_container"></div>');
		});
	
		// Comment form
		jQuery("form#commentform").submit(function(e) {
			var rez = hogwords_comments_validate(jQuery(this));
			if (!rez)
				e.preventDefault();
			return rez;
		});
	
		jQuery("form").on('keypress', '.error_field', function() {
			if (jQuery(this).val() != '')
				jQuery(this).removeClass('error_field');
		});
	
	
		// Blocks with stretch width
		//----------------------------------------------
		// Action to prepare stretch blocks in the third-party plugins
		jQuery(document).trigger('action.prepare_stretch_width');
		// Wrap stretch blocks
		jQuery('.trx-stretch-width').wrap('<div class="trx-stretch-width-wrap"></div>');
		jQuery('.trx-stretch-width').after('<div class="trx-stretch-width-original"></div>');
		hogwords_stretch_width();
			
	
		// Pagination
		//------------------------------------
	
		// Load more
		jQuery('.nav-links-more a').on('click', function(e) {
			if (HOGWORDS_STORAGE['load_more_link_busy']) return;
			HOGWORDS_STORAGE['load_more_link_busy'] = true;
			var more = jQuery(this);
			var page = Number(more.data('page'));
			var max_page = Number(more.data('max-page'));
			if (page >= max_page) {
				more.parent().hide();
				return;
			}
			more.parent().addClass('loading');
			var panel = more.parents('.hogwords_tabs_content');
			if (panel.length == 0) {															// Load simple page content
				jQuery.get(location.href, {
					paged: page+1
				}).done(function(response) {
					// Get inline styles and add to the page styles
					var selector = 'hogwords-inline-styles-inline-css';
					var p1 = response.indexOf(selector);
					if (p1 < 0) {
						selector = 'trx_addons-inline-styles-inline-css';
						p1 = response.indexOf(selector);
					}
					if (p1 > 0) {
						p1 = response.indexOf('>', p1) + 1;
						var p2 = response.indexOf('</style>', p1);
						var inline_css_add = response.substring(p1, p2);
						var inline_css = jQuery('#'+selector);
						if (inline_css.length == 0)
							jQuery('body').append('<style id="'+selector+'" type="text/css">' + inline_css_add + '</style>');
						else
							inline_css.append(inline_css_add);
					}
					// Get new posts and append to the .posts_container
					hogwords_loadmore_add_items(jQuery('.content .posts_container').eq(0),
											   jQuery(response).find('.content .posts_container > article,'
											   						+'.content .posts_container > div[class*="column-"],'
																	+'.content .posts_container > .masonry_item')
												);
				});
			} else {																			// Load tab's panel content
				jQuery.post(HOGWORDS_STORAGE['ajax_url'], {
					nonce: HOGWORDS_STORAGE['ajax_nonce'],
					action: 'hogwords_ajax_get_posts',
					blog_template: panel.data('blog-template'),
					blog_style: panel.data('blog-style'),
					posts_per_page: panel.data('posts-per-page'),
					cat: panel.data('cat'),
					parent_cat: panel.data('parent-cat'),
					post_type: panel.data('post-type'),
					taxonomy: panel.data('taxonomy'),
					page: page+1
				}).done(function(response) {
					var rez = {};
					try {
						rez = JSON.parse(response);
					} catch (e) {
						rez = { error: HOGWORDS_STORAGE['strings']['ajax_error'] };
						console.log(response);
					}
					if (rez.error !== '') {
						panel.html('<div class="hogwords_error">'+rez.error+'</div>');
					} else {
						hogwords_loadmore_add_items(panel.find('.posts_container'), jQuery(rez.data).find('article'));
					}
				});
			}
			// Append items to the container
			function hogwords_loadmore_add_items(container, items) {
				if (container.length > 0 && items.length > 0) {
					container.append(items);
					if (container.hasClass('portfolio_wrap') || container.hasClass('masonry_wrap')) {
						container.masonry( 'appended', items ).masonry();
						if (container.hasClass('gallery_wrap')) {
							HOGWORDS_STORAGE['GalleryFx'][container.attr('id')].appendItems();
						}
					}
					more.data('page', page+1).parent().removeClass('loading');
					// Remove TOC if exists (rebuild on init_shortcodes)
					jQuery('#toc_menu').remove();
					// Trigger actions to init new elements
					HOGWORDS_STORAGE['init_all_mediaelements'] = true;
					jQuery(document).trigger('action.init_shortcodes', [container.parent()]);
					jQuery(document).trigger('action.init_hidden_elements', [container.parent()]);
				}
				if (page+1 >= max_page)
					more.parent().hide();
				else
					HOGWORDS_STORAGE['load_more_link_busy'] = false;
				// Fire 'window.scroll' after clearing busy state
				jQuery( window ).trigger( 'scroll' );

				//ADD THIS
				// Fire 'window.resize'
				jQuery( window ).trigger( 'resize' );
			}
			e.preventDefault();
			return false;
		});
	
		// Infinite scroll
		jQuery(document).on('action.scroll_hogwords', function(e) {
			if (HOGWORDS_STORAGE['load_more_link_busy']) return;
			var container = jQuery('.content > .posts_container').eq(0);
			var inf = jQuery('.nav-links-infinite');
			if (inf.length == 0) return;
			if (container.offset().top + container.height() < jQuery(window).scrollTop() + jQuery(window).height()*1.5)
				inf.find('a').trigger('click');
		});

        // Comments
        //------------------------------------

        // Checkbox with "I agree..."
        if (jQuery('input[type="checkbox"][name="i_agree_privacy_policy"]:not(.inited),input[type="checkbox"][name="gdpr_terms"]:not(.inited),input[type="checkbox"][name="wpgdprc"]:not(.inited)').length > 0) {
            jQuery('input[type="checkbox"][name="i_agree_privacy_policy"]:not(.inited),input[type="checkbox"][name="gdpr_terms"]:not(.inited),input[type="checkbox"][name="wpgdprc"]:not(.inited)')
                .addClass('inited')
                .on('change', function(e) {
                    if (jQuery(this).get(0).checked)
                        jQuery(this).parents('form').find('button,input[type="submit"]').removeAttr('disabled');
                    else
                        jQuery(this).parents('form').find('button,input[type="submit"]').attr('disabled', 'disabled');
                }).trigger('change');
        }

        // Other settings
		//------------------------------------
	
		jQuery(document).trigger('action.ready_hogwords');
	
		// Init post format specific scripts
		jQuery(document).on('action.init_hidden_elements', hogwords_init_post_formats);
	
		// Init hidden elements (if exists)
		jQuery(document).trigger('action.init_hidden_elements', [jQuery('body').eq(0)]);
		
	} //end ready
	
	
	
	
	// Scroll actions
	//==============================================
	
	// Do actions when page scrolled
	function hogwords_scroll_actions() {

		var scroll_offset = jQuery(window).scrollTop();
		var adminbar_height = Math.max(0, jQuery('#wpadminbar').height());
	
		// Call theme/plugins specific action (if exists)
		//----------------------------------------------
		jQuery(document).trigger('action.scroll_hogwords');
		
		// Fix/unfix sidebar
		hogwords_fix_sidebar();
	
		// Shift top and footer panels when header position equal to 'Under content'
		if (jQuery('body').hasClass('header_position_under') && !hogwords_browser_is_mobile()) {
			var delta = 50;
			var adminbar = jQuery('#wpadminbar');
			var adminbar_height = adminbar.length == 0 && adminbar.css('position') == 'fixed' ? 0 : adminbar.height();
			var header = jQuery('.top_panel');
			var header_height = header.height();
			var mask = header.find('.top_panel_mask');
			if (mask.length==0) {
				header.append('<div class="top_panel_mask"></div>');
				mask = header.find('.top_panel_mask');
			}
			if (scroll_offset > adminbar_height) {
				var offset = scroll_offset - adminbar_height;
				if (offset <= header_height) {
					var mask_opacity = Math.max(0, Math.min(0.8, (offset-delta)/header_height));
					// Don't shift header with Revolution slider in Chrome
					if ( !(/Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor)) || header.find('.slider_engine_revo').length == 0 )
						header.css('top', Math.round(offset/1.2)+'px');
					mask.css({
						'opacity': mask_opacity,
						'display': offset==0 ? 'none' : 'block'
					});
				} else if (parseInt(header.css('top')) != 0) {
					header.css('top', Math.round(offset/1.2)+'px');
				}
			} else if (parseInt(header.css('top')) != 0 || mask.css('display')!='none') {
				header.css('top', '0px');
				mask.css({
					'opacity': 0,
					'display': 'none'
				});
			}
			var footer = jQuery('.footer_wrap');
			var footer_height = Math.min(footer.height(), jQuery(window).height());
			var footer_visible = (scroll_offset + jQuery(window).height()) - (header.outerHeight() + jQuery('.page_content_wrap').outerHeight());
			if (footer_visible > 0) {
				mask = footer.find('.top_panel_mask');
				if (mask.length==0) {
					footer.append('<div class="top_panel_mask"></div>');
					mask = footer.find('.top_panel_mask');
				}
				if (footer_visible <= footer_height) {
					var mask_opacity = Math.max(0, Math.min(0.8, (footer_height - footer_visible)/footer_height));
					// Don't shift header with Revolution slider in Chrome
					if ( !(/Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor)) || footer.find('.slider_engine_revo').length == 0 )
						footer.css('top', -Math.round((footer_height - footer_visible)/1.2)+'px');
					mask.css({
						'opacity': mask_opacity,
						'display': footer_height - footer_visible <= 0 ? 'none' : 'block'
					});
				} else if (parseInt(footer.css('top')) != 0 || mask.css('display')!='none') {
					footer.css('top', 0);
					mask.css({
						'opacity': 0,
						'display': 'none'
					});
				}
			}
		}
	}
	
	
	// Resize actions
	//==============================================
	
	// Do actions when page scrolled
	function hogwords_resize_actions(cont) {
		hogwords_check_layout();
		hogwords_fix_sidebar();
		hogwords_fix_footer();
		hogwords_stretch_width(cont);
		hogwords_resize_video( cont );
		hogwords_stretch_height(null, cont);
		hogwords_stretch_bg_video();
		hogwords_vc_row_fullwidth_to_boxed(cont);
		if (HOGWORDS_STORAGE['menu_side_stretch']) hogwords_stretch_sidemenu();
	
		// Call theme/plugins specific action (if exists)
		//----------------------------------------------
		jQuery(document).trigger('action.resize_hogwords', [cont]);
	}
	
	// Stretch sidemenu (if present)
	function hogwords_stretch_sidemenu() {
		var toc_items = jQuery('.menu_side_wrap.menu_side_icons .toc_menu_item');
		if (toc_items.length < 5) return;
		var toc_items_height = jQuery(window).height() 
								- hogwords_fixed_rows_height(true, false) 
								- jQuery('.menu_side_wrap .sc_layouts_logo').outerHeight() 
								- toc_items.length;
		var th = Math.floor(toc_items_height / toc_items.length);
		var th_add = toc_items_height - th*toc_items.length;
		toc_items.find(".toc_menu_description,.toc_menu_icon").css({
			'height': th+'px',
			'lineHeight': th+'px'
		});
		toc_items.eq(0).find(".toc_menu_description,.toc_menu_icon").css({
			'height': (th+th_add)+'px',
			'lineHeight': (th+th_add)+'px'
		});
	}
	
	// Check for mobile layout
	function hogwords_check_layout() {
		var resize = true;
		if (jQuery('body').hasClass('no_layout')) {
			jQuery('body').removeClass('no_layout');
			resize = false;
		}
		var w = window.innerWidth;
		if (w == undefined) 
			w = jQuery(window).width()+(jQuery(window).height() < jQuery(document).height() || jQuery(window).scrollTop() > 0 ? 16 : 0);
		if (HOGWORDS_STORAGE['mobile_layout_width'] >= w) {
			if (!jQuery('body').hasClass('mobile_layout')) {
				jQuery('body').removeClass('desktop_layout').addClass('mobile_layout');
				if (resize) jQuery(window).trigger('resize');
			}
		} else {
			if (!jQuery('body').hasClass('desktop_layout')) {
				jQuery('body').removeClass('mobile_layout').addClass('desktop_layout');
				jQuery('.menu_mobile').removeClass('opened');
				jQuery('.menu_mobile_overlay').hide();
				if (resize) jQuery(window).trigger('resize');
			}
		}
		if (HOGWORDS_STORAGE['mobile_device'] || hogwords_browser_is_mobile()) 
			jQuery('body').addClass('mobile_device');
	}
	
	// Stretch area to full window width
	function hogwords_stretch_width(cont) {
		if (cont===undefined) cont = jQuery('body');
		cont.find('.trx-stretch-width').each(function() {
			var $el = jQuery(this);
			var $el_cont = $el.parents('.page_wrap');
			var $el_cont_offset = 0;
			if ($el_cont.length == 0) 
				$el_cont = jQuery(window);
			else
				$el_cont_offset = $el_cont.offset().left;
			var $el_full = $el.next('.trx-stretch-width-original');
			var el_margin_left = parseInt( $el.css( 'margin-left' ), 10 );
			var el_margin_right = parseInt( $el.css( 'margin-right' ), 10 );
			var offset = $el_cont_offset - $el_full.offset().left - el_margin_left;
			var width = $el_cont.width();
			if (!$el.hasClass('inited')) {
				$el.addClass('inited invisible');
				$el.css({
					'position': 'relative',
					'box-sizing': 'border-box'
				});
			}
			$el.css({
				'left': offset,
				'width': $el_cont.width()
			});
			if ( !$el.hasClass('trx-stretch-content') ) {
				var padding = Math.max(0, -1*offset);
				var paddingRight = Math.max(0, width - padding - $el_full.width() + el_margin_left + el_margin_right);
				$el.css( { 'padding-left': padding + 'px', 'padding-right': paddingRight + 'px' } );
			}
			$el.removeClass('invisible');
		});
	}
	
	// Resize video frames
	function hogwords_resize_video(cont) {
		if (cont === undefined) {
			cont = jQuery( 'body' );
		}
		// Resize tags 'video'
		cont.find( 'video' ).each( function() {
			var $self = jQuery( this );
			// If item now invisible
			if ( $self.parents('.mejs-mediaelement').length === 0
				|| $self.hasClass( 'trx_addons_resize' )
				|| $self.hasClass( 'trx_addons_noresize' )
				|| $self.parents( 'div:hidden,section:hidden,article:hidden' ).length > 0
			) {
				return;
			}
			var video     = $self.addClass( 'hogwords_resize' ).eq( 0 );
			var ratio     = (video.data( 'ratio' ) !== undefined ? video.data( 'ratio' ).split( ':' ) : [16,9]);
			ratio         = ratio.length != 2 || ratio[0] === 0 || ratio[1] === 0 ? 16 / 9 : ratio[0] / ratio[1];
			var mejs_cont = video.parents( '.mejs-video' ).eq(0);
			var mfp_cont  = video.parents( '.mfp-content' ).eq(0);
			var w_attr    = video.data( 'width' );
			var h_attr    = video.data( 'height' );
			if ( ! w_attr || ! h_attr) {
				w_attr = video.attr( 'width' );
				h_attr = video.attr( 'height' );
				if ( ! w_attr || ! h_attr) {
					return;
				}
				video.data( {'width': w_attr, 'height': h_attr} );
			}
			var percent = ('' + w_attr).substr( -1 ) == '%';
			w_attr      = parseInt( w_attr, 10 );
			h_attr      = parseInt( h_attr, 10 );
			var w_real  = Math.ceil(
							mejs_cont.length > 0
									? Math.min( percent ? 10000 : w_attr, mejs_cont.parents( 'div,article' ).eq(0).width() )
									: Math.min( percent ? 10000 : w_attr, video.parents( 'div,article' ).eq(0).width() )
			);
			if ( mfp_cont.length > 0 ) {
				w_real  = Math.max( mfp_cont.width(), w_real );
			}
			var h_real  = Math.ceil( percent ? w_real / ratio : w_real / w_attr * h_attr );
			if ( parseInt( video.attr( 'data-last-width' ), 10 ) == w_real ) {
				return;
			}
			if ( percent ) {
				video.height( h_real );
			} else if ( video.parents( '.wp-video-playlist' ).length > 0 ) {
				if ( mejs_cont.length === 0 ) {
					video.attr( {'width': w_real, 'height': h_real} );
				}
			} else {
				video.attr( {'width': w_real, 'height': h_real} ).css( {'width': w_real + 'px', 'height': h_real + 'px'} );
				if ( mejs_cont.length > 0 ) {
					hogwords_set_mejs_player_dimensions( video, w_real, h_real );
				}
			}
			video.attr( 'data-last-width', w_real );
		} );

		// Resize tags 'iframe'
			cont.find( '.video_frame iframe,iframe' ).each( function() {
				var $self = jQuery( this );
				// If item now invisible
				if ( $self.hasClass( 'trx_addons_resize' ) || $self.hasClass( 'trx_addons_noresize' ) || $self.addClass( 'hogwords_resize' ).parents( 'div:hidden,section:hidden,article:hidden' ).length > 0 ) {
					return;
				}
				var iframe = $self.eq( 0 );
				if (iframe.length === 0 || iframe.attr( 'src' ) === undefined || iframe.attr( 'src' ).indexOf( 'soundcloud' ) > 0) {
					return;
				}
				var w_attr = iframe.attr( 'width' );
				var h_attr = iframe.attr( 'height' );
				if ( ! w_attr || ! h_attr || w_attr <= 325 ) {
					return;
				}
				var ratio  = iframe.data( 'ratio' ) !== undefined
								? iframe.data( 'ratio' ).split( ':' )
								: ( iframe.parent().data( 'ratio' ) !== undefined
									? iframe.parent().data( 'ratio' ).split( ':' )
									: ( iframe.find( '[data-ratio]' ).length > 0
										? iframe.find( '[data-ratio]' ).data( 'ratio' ).split( ':' )
										: [w_attr, h_attr]
										)
									);
				ratio      = ratio.length != 2 || ratio[0] === 0 || ratio[1] === 0 ? 16 / 9 : ratio[0] / ratio[1];
				var percent   = ( '' + w_attr ).slice( -1 ) == '%';
				w_attr        = parseInt( w_attr, 10 );
				h_attr        = parseInt( h_attr, 10 );
				var par       = iframe.parents( 'div,section' ).eq(0),
					contains  = iframe.data('contains-in-parent')=='1' || iframe.hasClass('contains-in-parent'),
					nostretch = iframe.data('no-stretch-to-parent')=='1' || iframe.hasClass('no-stretch-to-parent'),
					pw        = Math.ceil( par.width() ),
					ph        = Math.ceil( par.height() ),
					w_real    = nostretch ? Math.min( w_attr, pw ) : pw,
					h_real    = Math.ceil( percent ? w_real / ratio : w_real / w_attr * h_attr );
				if ( contains && par.css( 'position' ) == 'absolute' && h_real > ph) {
					h_real = ph;
					w_real = Math.ceil( percent ? h_real * ratio : h_real * w_attr / h_attr );
				}
				if (parseInt( iframe.attr( 'data-last-width' ), 10 ) == w_real) {
					return;
				}
				iframe.css( {'width': w_real + 'px', 'height': h_real + 'px'} );
				iframe.attr( 'data-last-width', w_real );
			} );
	}  // hogwords_resize_video

		// Set Media Elements player dimensions
		function hogwords_set_mejs_player_dimensions(video, w, h) {
			if (mejs) {
				for (var pl in mejs.players) {
					if (mejs.players[pl].media.src == video.attr( 'src' )) {
						if (mejs.players[pl].media.setVideoSize) {
							mejs.players[pl].media.setVideoSize( w, h );
						} else if (mejs.players[pl].media.setSize) {
							mejs.players[pl].media.setSize( w, h );
						}
						mejs.players[pl].setPlayerSize( w, h );
						mejs.players[pl].setControlsSize();
					}
				}
			}
		}

	// Stretch area to the full window height
	function hogwords_stretch_height(e, cont) {
		if (cont===undefined) cont = jQuery('body');
		cont.find('.hogwords-full-height').each(function () {
			var fullheight_item = jQuery(this);
			// If item now invisible
			if (jQuery(this).parents('div:hidden,section:hidden,article:hidden').length > 0) {
				return;
			}
			var fullheight_row = jQuery(this).parents('.vc_row-o-full-height');
			if (fullheight_row.length > 0)
				fullheight_item.height(fullheight_row.height());
			else {
				var fh = hogwords_fixed_rows_height();
				var wh = jQuery(window).width() >= 960
							? jQuery(window).height() - fh
							: 'auto';
				if (wh > 0) {
					if (fullheight_item.data('display') != fullheight_item.css('display'))
						fullheight_item.css('display', fullheight_item.data('display'));
					fullheight_item.css('height', wh);
				} else if (wh=='auto' && fullheight_item.css('height')!='auto') {
					if (fullheight_item.data('display')==undefined)
						fullheight_item.attr('data-display', fullheight_item.css('display'));
					fullheight_item.css({'height': wh, 'display': 'block'});
				}
			}
		});
	}
	
	// Stretch background video
	function hogwords_stretch_bg_video() {
		var video_wrap = jQuery('div#background_video,.tourmaster-background-video');
		if (video_wrap.length == 0) return;
		var cont = video_wrap.hasClass('tourmaster-background-video') ? video_wrap.parent() : video_wrap,
			w = cont.width(),
			h = cont.height(),
			video = video_wrap.find('>iframe,>video');
		if (w/h < 16/9)
			w = h/9*16;
		else
			h = w/16*9;
		video
			.attr({'width': w, 'height': h})
			.css({'width': w, 'height': h});
	}
		
	// Recalculate width of the vc_row[data-vc-full-width="true"] when content boxed or menu_style=='left|right'
	function hogwords_vc_row_fullwidth_to_boxed(cont) {
		if (jQuery('body').hasClass('body_style_boxed') || jQuery('body').hasClass('menu_style_side')) {
			if (cont === undefined || !cont.hasClass('.vc_row') || !cont.data('vc-full-width'))
				cont = jQuery('.vc_row[data-vc-full-width="true"]');
			var width_content = jQuery('.page_wrap').width();
			var width_content_wrap = jQuery('.page_content_wrap .content_wrap').width();
			var indent = ( width_content - width_content_wrap ) / 2;
			var rtl = jQuery('html').attr('dir') == 'rtl';
			cont.each( function() {
				var mrg = parseInt(jQuery(this).css('marginLeft'));
				var stretch_content = jQuery(this).attr('data-vc-stretch-content');
				var in_content = jQuery(this).parents('.content_wrap').length > 0;
				jQuery(this).css({
					'width': width_content,
					'left': rtl ? 'auto' : (in_content ? -indent : 0) - mrg,
					'right': !rtl ? 'auto' : (in_content ? -indent : 0) - mrg,
					'padding-left': stretch_content ? 0 : indent + mrg,
					'padding-right': stretch_content ? 0 : indent + mrg
				});
			});
		}
	}
	
	
	// Fix/unfix footer
	function hogwords_fix_footer() {
		if (jQuery('body').hasClass('header_position_under') && !hogwords_browser_is_mobile()) {
			var ft = jQuery('.footer_wrap');
			if (ft.length > 0) {
				var ft_height = ft.outerHeight(false),
					pc = jQuery('.page_content_wrap'),
					pc_offset = pc.offset().top,
					pc_height = pc.height();
				if (pc_offset + pc_height + ft_height < jQuery(window).height()) {
					if (ft.css('position')!='absolute') {
						ft.css({
							'position': 'absolute',
							'left': 0,
							'bottom': 0,
							'width' :'100%'
						});
					}
				} else {
					if (ft.css('position')!='relative') {
						ft.css({
							'position': 'relative',
							'left': 'auto',
							'bottom': 'auto'
						});
					}
				}
			}
		}
	}
	
	
	// Fix/unfix sidebar
	function hogwords_fix_sidebar() {
		var sb = jQuery('.sidebar');
		var content = sb.siblings('.content');
		if (sb.length > 0) {
	
			// Unfix when sidebar is under content
			if (content.css('float') == 'none') {

				var old_style = sb.data('old_style');
				if (old_style !== undefined) sb.attr('style', old_style).removeAttr('data-old_style');
	
			} else {
	
				var sb_height = sb.outerHeight();
				var content_height = content.outerHeight();
				var content_top = content.offset().top;
				var scroll_offset = jQuery(window).scrollTop();
				
				var top_panel_fixed_height = hogwords_fixed_rows_height();
				
				// If sidebar shorter then content and page scrolled below the content's top
				if (sb_height < content_height && scroll_offset + top_panel_fixed_height > content_top) {
					
					var sb_init = {
							'position': 'undefined',
							'float': 'none',
							'top': 'auto',
							'bottom' : 'auto'
							};
					
					if (typeof HOGWORDS_STORAGE['scroll_offset_last'] == 'undefined') {
						HOGWORDS_STORAGE['sb_top_last'] = content_top;
						HOGWORDS_STORAGE['scroll_offset_last'] = scroll_offset;
						HOGWORDS_STORAGE['scroll_dir_last'] = 1;
					}
					var scroll_dir = scroll_offset - HOGWORDS_STORAGE['scroll_offset_last'];
					if (scroll_dir == 0)
						scroll_dir = HOGWORDS_STORAGE['scroll_dir_last'];
					else
						scroll_dir = scroll_dir > 0 ? 1 : -1;
					
					var sb_big = sb_height + 30 >= jQuery(window).height() - top_panel_fixed_height,
						sb_top = sb.offset().top;
						
					if (sb_top < 0) sb_top = HOGWORDS_STORAGE['sb_top_last'];

					// If sidebar height greater then window height
					if (sb_big) {
	
						// If change scrolling dir
						if (scroll_dir != HOGWORDS_STORAGE['scroll_dir_last'] && sb.css('position') == 'fixed') {
							sb_init.top = sb_top - content_top;
							sb_init.position = 'absolute';
	
						// If scrolling down
						} else if (scroll_dir > 0) {
							if (scroll_offset + jQuery(window).height() >= content_top + content_height + 30) {
								sb_init.bottom = 0;
								sb_init.position = 'absolute';
							} else if (scroll_offset + jQuery(window).height() >= (sb.css('position') == 'absolute' ? sb_top : content_top) + sb_height + 30) {
								
								sb_init.bottom = 30;
								sb_init.position = 'fixed';
							}
						
						// If scrolling up
						} else {
							if (scroll_offset + top_panel_fixed_height <= sb_top) {
								sb_init.top = top_panel_fixed_height;
								sb_init.position = 'fixed';
							}
						}
					
					// If sidebar height less then window height
					} else {
						if (scroll_offset + top_panel_fixed_height >= content_top + content_height - sb_height) {
							sb_init.bottom = 0;
							sb_init.position = 'absolute';
						} else {
							sb_init.top = top_panel_fixed_height;
							sb_init.position = 'fixed';
						}
					}
					
					if (sb_init.position != 'undefined') {
						// Detect horizontal position when resize
						var pos = 0;
						if (sb_init.position == 'fixed' || (!jQuery('body').hasClass('body_style_wide') && !jQuery('body').hasClass('body_style_boxed'))) {
							var sb_parent = sb.parent();
							pos = sb_parent.position();
							pos = pos.left + Math.max(0, parseInt(sb_parent.css('paddingLeft'), 10)) 
											+ Math.max(0, parseInt(sb_parent.css('marginLeft'), 10))
											+ (jQuery('body').hasClass('menu_style_right')
												? Math.max(0, parseInt(jQuery('body').css('marginRight'), 10))
												: 0);
						}
						if (sb.hasClass('right'))	sb_init.right = pos;
						else						sb_init.left = pos;
						
						// Set position
						if (sb.css('position') != sb_init.position || HOGWORDS_STORAGE['scroll_dir_last'] != scroll_dir) {
							if (sb.data('old_style') === undefined) {
								var style = sb.attr('style');
								if (!style) style = '';
								sb.attr('data-old_style', style);
							}
							sb.css(sb_init);
						}
					}

					HOGWORDS_STORAGE['sb_top_last'] = sb_top;
					HOGWORDS_STORAGE['scroll_offset_last'] = scroll_offset;
					HOGWORDS_STORAGE['scroll_dir_last'] = scroll_dir;
	
				} else {
	
					// Unfix when page scrolling to top
					var old_style = sb.data('old_style');
					if (old_style !== undefined)
						sb.attr('style', old_style).removeAttr('data-old_style');
	
				}
			}
		}
	}
	
	
	
	
	
	// Navigation
	//==============================================
	
	// Init Superfish menu
	function hogwords_init_sfmenu(selector) {
		jQuery(selector).show().each(function() {
			var animation_in = jQuery(this).parent().data('animation_in');
			if (animation_in == undefined) animation_in = "none";
			var animation_out = jQuery(this).parent().data('animation_out');
			if (animation_out == undefined) animation_out = "none";
			jQuery(this).addClass('inited').superfish({
				delay: 500,
				animation: {
					opacity: 'show'
				},
				animationOut: {
					opacity: 'hide'
				},
				speed: 		animation_in!='none' ? 500 : 200,
				speedOut:	animation_out!='none' ? 500 : 200,
				autoArrows: false,
				dropShadows: false,
				onBeforeShow: function(ul) {
					if (jQuery(this).parents("ul").length > 1){
						var w = jQuery('.page_wrap').width();  
						var par_offset = jQuery(this).parents("ul").offset().left;
						var par_width  = jQuery(this).parents("ul").outerWidth();
						var ul_width   = jQuery(this).outerWidth();
						if (par_offset+par_width+ul_width > w-20 && par_offset-ul_width > 0)
							jQuery(this).addClass('submenu_left');
						else
							jQuery(this).removeClass('submenu_left');
					}
					if (animation_in!='none') {
						jQuery(this).removeClass('animated fast '+animation_out);
						jQuery(this).addClass('animated fast '+animation_in);
					}
				},
				onBeforeHide: function(ul) {
					if (animation_out!='none') {
						jQuery(this).removeClass('animated fast '+animation_in);
						jQuery(this).addClass('animated fast '+animation_out);
					}
				}
			});
		});
	}



	// Post formats init
	//=====================================================
	
	function hogwords_init_post_formats(e, cont) {
	
		// MediaElement init
		hogwords_init_media_elements(cont);
		
		// Video play button
		cont.find('.format-video .post_featured.with_thumb .post_video_hover:not(.inited)')
			.addClass('inited')
			.on('click', function(e) {
				jQuery(this).parents('.post_featured')
					.addClass('post_video_play')
					.find('.post_video').html(jQuery(this).data('video'));
				jQuery(window).trigger('resize');
				e.preventDefault();
				return false;
			});
	}


	// Init media elements
	//--------------------------------------------
	HOGWORDS_STORAGE['mejs_attempts'] = 0;
	function hogwords_init_media_elements(cont) {
		var audio_selector = 'audio:not(.inited)',
			video_selector = 'video:not(.inited):not([nocontrols]):not([controls="0"]):not([controls="false"]):not([controls="no"])',	//:not([autoplay])
			media_selector = audio_selector + ( audio_selector && video_selector ? ',' : '') + video_selector;
		if (HOGWORDS_STORAGE['use_mediaelements'] && cont.find( media_selector ).length > 0) {
			if ( window.mejs ) {
				if (window.mejs.MepDefaults) {
					window.mejs.MepDefaults.enableAutosize = true;
				}
				if (window.mejs.MediaElementDefaults) {
					window.mejs.MediaElementDefaults.enableAutosize = true;
				}
				// Disable init for video[autoplay]
				cont.find(
						  // Old shortcode 'wp-video'
						  'video.wp-video-shortcode[autoplay],'
						+ 'video.wp-video-shortcode[nocontrols],'
						+ 'video.wp-video-shortcode[controls="0"],'
						+ 'video.wp-video-shortcode[controls="false"],'
						+ 'video.wp-video-shortcode[controls="no"],'
						// New block 'video'
						+ '.wp-block-video > video[autoplay],'
						+ '.wp-block-video > video[nocontrols],'
						+ '.wp-block-video > video[controls="0"],'
						+ '.wp-block-video > video[controls="false"],'
						+ '.wp-block-video > video[controls="no"]'
						)
					.removeClass('wp-video-shortcode');
				// Init mediaelements
				cont.find( media_selector ).each(
					function() {
						var $self = jQuery( this );
						// If item now invisible
						if ($self.parents( 'div:hidden,section:hidden,article:hidden' ).length > 0) {
							return;
						}
						if (   ! $self.hasClass( 'no-mejs' )
							&& ! $self.hasClass( 'no-mediaelement' )
							&& ! $self.hasClass( 'wp-block-cover__video-background' )
							&& $self.addClass( 'inited' ).parents( '.mejs-mediaelement' ).length === 0
							&& $self.parents( '.wp-block-video' ).length === 0
							&& $self.parents( '.elementor-background-video-container' ).length === 0
							&& $self.parents( '.elementor-widget-video' ).length === 0
							// Prevent init media elements on the video with autoplay
							// Case 1: Don't init media elements on video with autoplay is inside a slider
							// && ( $self.parents( '.with_video_autoplay' ).length === 0 || $self.parents( '.slider-slide' ).length === 0 )
							// Case 2: Don't init media elements on video with autoplay anyway
							&& $self.parents( '.with_video_autoplay' ).length === 0
							// Comment a next row if you want to init mediaelements on the background video inside a layouts title
							&& $self.parents( '.sc_layouts_title' ).length === 0
							// Uncomment the next row to 
							// disable mediaelements init on the Elementor's video shortcode
							// to support a video ratio, specified in a shortcode parameters
							// && $self.parents( '.elementor-fit-aspect-ratio' ).length === 0
							&& ( HOGWORDS_STORAGE['init_all_mediaelements']
								|| ( ! $self.hasClass( 'wp-audio-shortcode' )
									&& ! $self.hasClass( 'wp-video-shortcode' )
									&& ! $self.parent().hasClass( 'wp-playlist' )
									)
								)
						) {
							var media_cont = $self.parents('.post_video').eq(0);
							if ( media_cont.length === 0 ) {
								media_cont = $self.parents('.video_frame').eq(0);
								if ( media_cont.length === 0 ) {
									media_cont = $self.parent();
								}
							}
							var //video_w = $self.width(),
								//video_h = $self.height(),
								cont_w = media_cont.length > 0 ? media_cont.width() : -1,
								// If video is inside a container, get the container's height
								//cont_h = media_cont.length > 0 ? Math.floor( cont_w / video_w * video_h ) : -1,
								cont_h = media_cont.length > 0 ? media_cont.height() : -1,
								settings = {
									enableAutosize: true,
									videoWidth:     cont_w,   // if set, overrides <video width>
									videoHeight:    cont_h,   // if set, overrides <video height>
									audioWidth:     '100%',   // width of audio player
									audioHeight:    40,	      // height of audio player
									success: function(mejs) {
										if ( mejs.pluginType && 'flash' === mejs.pluginType && mejs.attributes ) {
											mejs.attributes.autoplay
												&& 'false' !== mejs.attributes.autoplay
												&& mejs.addEventListener( 'canplay', function () { mejs.play(); }, false );
											mejs.attributes.loop
												&& 'false' !== mejs.attributes.loop
												&& mejs.addEventListener( 'ended', function () { mejs.play(); }, false );
										}
									}
								};
							$self.mediaelementplayer( settings );
						}
					}
				);
			} else if ( HOGWORDS_STORAGE['mejs_attempts']++ < 5 ) {
				setTimeout( function() { hogwords_init_media_elements( cont ); }, 400 );
			}
		}
		// Init all media elements after first run
		setTimeout( function() { HOGWORDS_STORAGE['init_all_mediaelements'] = true; }, 1000 );
	}
	
	
	// Load the tab's content
	function hogwords_tabs_ajax_content_loader(panel, page, oldPanel) {
		if (panel.html().replace(/\s/g, '')=='') {
			var height = oldPanel === undefined ? panel.height() : oldPanel.height();
			if (isNaN(height) || height < 100) height = 100;
			panel.html('<div class="hogwords_tab_holder" style="min-height:'+height+'px;"></div>');
		} else
			panel.find('> *').addClass('hogwords_tab_content_remove');
		panel.data('need-content', false).addClass('hogwords_loading');
		jQuery.post(HOGWORDS_STORAGE['ajax_url'], {
			nonce: HOGWORDS_STORAGE['ajax_nonce'],
			action: 'hogwords_ajax_get_posts',
			blog_template: panel.data('blog-template'),
			blog_style: panel.data('blog-style'),
			posts_per_page: panel.data('posts-per-page'),
			cat: panel.data('cat'),
			parent_cat: panel.data('parent-cat'),
			post_type: panel.data('post-type'),
			taxonomy: panel.data('taxonomy'),
			page: page
		}).done(function(response) {
			panel.removeClass('hogwords_loading');
			var rez = {};
			try {
				rez = JSON.parse(response);
			} catch (e) {
				rez = { error: HOGWORDS_STORAGE['strings']['ajax_error'] };
				console.log(response);
			}
			if (rez.error !== '') {
				panel.html('<div class="hogwords_error">'+rez.error+'</div>');
			} else {
				panel.prepend(rez.data).fadeIn(function() {
					jQuery(document).trigger('action.init_shortcodes', [panel]);
					jQuery(document).trigger('action.init_hidden_elements', [panel]);
					jQuery(window).trigger('scroll');
					setTimeout(function() {
						panel.find('.hogwords_tab_holder,.hogwords_tab_content_remove').remove();
						jQuery(window).trigger('scroll');
					}, 600);
				});
			}
		});
	}
	
	
	// Forms validation
	//-------------------------------------------------------
	
	// Comments form
	function hogwords_comments_validate(form) {
		form.find('input').removeClass('error_field');
		var comments_args = {
			error_message_text: HOGWORDS_STORAGE['strings']['error_global'],	// Global error message text (if don't write in checked field)
			error_message_show: true,									// Display or not error message
			error_message_time: 4000,									// Error message display time
			error_message_class: 'hogwords_messagebox hogwords_messagebox_style_error',	// Class appended to error message block
			error_fields_class: 'error_field',							// Class appended to error fields
			exit_after_first_error: false,								// Cancel validation and exit after first error
			rules: [
				{
					field: 'comment',
					min_length: { value: 1, message: HOGWORDS_STORAGE['strings']['text_empty'] },
					max_length: { value: HOGWORDS_STORAGE['comment_maxlength'], message: HOGWORDS_STORAGE['strings']['text_long']}
				}
			]
		};
		if (form.find('.comments_author input[aria-required="true"]').length > 0) {
			comments_args.rules.push(
				{
					field: 'author',
					min_length: { value: 1, message: HOGWORDS_STORAGE['strings']['name_empty']},
					max_length: { value: 60, message: HOGWORDS_STORAGE['strings']['name_long']}
				}
			);
		}
		if (form.find('.comments_email input[aria-required="true"]').length > 0) {
			comments_args.rules.push(
				{
					field: 'email',
					min_length: { value: 1, message: HOGWORDS_STORAGE['strings']['email_empty']},
					max_length: { value: 60, message: HOGWORDS_STORAGE['strings']['email_long']},
					mask: { value: HOGWORDS_STORAGE['email_mask'], message: HOGWORDS_STORAGE['strings']['email_not_valid']}
				}
			);
		}
		var error = hogwords_form_validate(form, comments_args);
		return !error;
	}

	// Bubble submit() up for widget "Categories"
	var s = jQuery("select:not(.esg-sorting-select)");

	if ( s.parents( '.widget_categories' ).length > 0 ) {

		s.parent().each( function (ind, item) { jQuery(item).get(0).submit = function() {

			jQuery(item).closest('form').submit();

		}; }); }

	//Open new windows in new tab
	jQuery('a').filter(function() {
		"use strict";
		return this.hostname && this.hostname !== location.hostname;
	}).attr('target','_blank');

});


