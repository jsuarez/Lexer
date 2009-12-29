// JavaScript Document

var Class_Animate = function(){
	
	//________________________________PROPERTIES PRIVATE________________________________
	var styleCache = {};
	var camelRe = /(-[a-z])/gi;
	var camelFn = function(m, a){
		return a.charAt(1).toUpperCase();
	};
	
	var view = document.defaultView;
	var alphaRe = /alpha\([^\)]*\)/gi;
	var timer;
	var timer2;
	var working = false;
	
	
	
	//________________________________METHODS PRIVATE________________________________
	var setOpacity = function(el, opacity){
		var s = el.style;
		if(window.ActiveXObject){ // IE
			s.zoom = 1;
			s.filter = (s.filter || '').replace(alphaRe, '') +
					   (opacity == 1 ? '' : ' alpha(opacity=' + opacity * 100 + ')');
		}else{
			s.opacity = opacity;
		}
	};

	var getStyle = function(){
		return view && view.getComputedStyle
			? function(el, style){
				var v, cs, camel;
				if(style == 'float') style = 'cssFloat';
				if(v = el.style[style]) return v;
				if(cs = view.getComputedStyle(el, '')){
					if(!(camel = styleCache[style])){
						camel = styleCache[style] = style.replace(camelRe, camelFn);
					}
					return cs[camel];
				}
				return null;
			}
			: function(el, style){
				var v, cs, camel;
				if(style == 'opacity'){
					if(typeof el.style.filter == 'string'){
						var m = el.style.filter.match(/alpha\(opacity=(.*)\)/i);
						if(m){
							var fv = parseFloat(m[1]);
							if(!isNaN(fv)) return fv ? fv / 100 : 0;
						}
					}
					return 1;
				}else if(style == 'float'){
					style = 'styleFloat';
				}
				if(!(camel = styleCache[style])){
					camel = styleCache[style] = style.replace(camelRe, camelFn);
				}
				if(v = el.style[camel]) return v;
				if(cs = el.currentStyle) return cs[camel];
				return null;
			};
	}();

	var setStyle = function(el, style, value){
		if(typeof style == 'string'){
			var camel;
			if(!(camel = styleCache[style])){
				camel = styleCache[style] = style.replace(camelRe, camelFn);
			}
			if(camel == 'opacity'){
				setOpacity(el, value);
			}else{
				el.style[camel] = value;
			}
		}else{
			for(var s in style){
				setStyle(el, s, style[s]);
			}
		}
	};

	var Ease = {
	
		/**
		 * A linear function.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		linear: function(x){
			return x;
		},
	
		/**
		 * A quadratic easing function. Eases on acceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		quadIn: function(x){
			return Math.pow(x, 2);
		},
	
		/**
		 * A quadratic easing function. Eases on deceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		quadOut: function(x){
			return 1 - Math.pow(x - 1, 2);
		},
	
		/**
		 * A quadratic easing function. Eases on both acceleration and deceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		quadInOut: function(x){
			return x < 0.5 ? 2 * Math.pow(x, 2) : 1 - 2 * Math.pow(x - 1, 2);
		},
	
		/**
		 * A cubic easing function. Eases on acceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		cubicIn: function(x){
			return Math.pow(x, 3);
		},
	
		/**
		 * A cubic easing function. Eases on deceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		cubicOut: function(x){
			return 1 + Math.pow(x - 1, 3);
		},
	
		/**
		 * A cubic easing function. Eases on both acceleration and deceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		cubicInOut: function(x){
			return x < 0.5 ? 4 * Math.pow(x, 3) : 1 + 4 * Math.pow(x - 1, 3);
		},
	
		/**
		 * A quartic easing function. Eases on acceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		quartIn: function(x){
			return Math.pow(x, 4);
		},
	
		/**
		 * A quartic easing function. Eases on deceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		quartOut: function(x){
			return 1 - Math.pow(x - 1, 4);
		},
	
		/**
		 * A quartic easing function. Eases on both acceleration and deceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		quartInOut: function(x){
			return x < 0.5 ? 8 * Math.pow(x, 4) : 1 - 8 * Math.pow(x - 1, 4);
		},
	
		/**
		 * A quintic easing function. Eases on acceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		quintIn: function(x){
			return Math.pow(x, 5);
		},
	
		/**
		 * A quintic easing function. Eases on deceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		quintOut: function(x){
			return 1 + Math.pow(x - 1, 5);
		},
	
		/**
		 * A quintic easing function. Eases on both acceleration and deceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		quintInOut: function(x){
			return x < 0.5 ? 16 * Math.pow(x, 5) : 1 + 16 * Math.pow(x - 1, 5);
		},
	
		/**
		 * A sinusoidal easing function. Eases on acceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		sineIn: function(x){
			return 1 - Math.cos(x * Math.PI / 2);
		},
	
		/**
		 * A sinusoidal easing function. Eases on deceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		sineOut: function(x){
			return Math.sin(x * Math.PI / 2);
		},
	
		/**
		 * A sinusoidal easing function. Eases on both acceleration and
		 * deceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		sineInOut: function(x){
			return 0.5 - Math.cos(x * Math.PI) / 2;
		},
	
		/**
		 * An exponential easing function. Eases on acceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		expoIn: function(x){
			return Math.pow(2, 10 * (x - 1));
		},
	
		/**
		 * An exponential easing function. Eases on deceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		expoOut: function(x){
			return 1 - Math.pow(2, -10 * x);
		},
	
		/**
		 * An exponential easing function. Eases both on acceleration and
		 * deceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		expoInOut: function(x){
			x = 2 * x - 1;
			return x < 0 ? Math.pow(2, 10 * x) / 2 : 1 - Math.pow(2, -10 * x) / 2;
		},
	
		/**
		 * A circular easing function. Eases on acceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		circIn: function(x){
			return 1 - Math.sqrt(1 - Math.pow(x, 2));
		},
	
		/**
		 * A circular easing function. Eases on deceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		circOut: function(x){
			return Math.sqrt(1 - Math.pow(x - 1, 2));
		},
	
		/**
		 * A circular easing function. Eases on both acceleration and deceleration.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		circInOut: function(x){
			return x < 0.5
				? 0.5 - Math.sqrt(1 - Math.pow(2 * x, 2)) * 0.5
				: 0.5 + Math.sqrt(1 - Math.pow(2 * x - 2, 2)) * 0.5;
		},
	
		/**
		 * A pulse easing function. Takes the number of pulses as an optional
		 * parameter.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @param   {Number}    n       (optional) The number of pulses, defaults
		 *                              to 1
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		pulse: function(x, n){
			if(!n) n = 1;
			return 0.5 - Math.cos(x * n * 2 * Math.PI) / 2;
		},
	
		/**
		 * A wobble easing function. Takes the number of wobbles as an optional
		 * parameter.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @param   {Number}    n       (optional) The number of wobbles, defaults
		 *                              to 3
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		wobble: function(x, n){
			if(!n) n = 3;
			return 0.5 - Math.cos((2 * n - 1) * x * x * Math.PI) / 2;
		},
	
		/**
		 * An elastic easing function. Takes the degree of elasticity as an optional
		 * parameter.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @param   {Number}    e       (optional) The degree of elasticity on
		 *                              [1, 10], defaults to 5
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		elastic: function(x, e){
			var a;
			if(!e){
				a = 30; // no elasticity given, same as e = 5
			}else{
				e = Math.round(Math.max(1, Math.min(10, e)));
				a = (11 - e) * 5;
			}
			return 1 - Math.cos(x * 8 * Math.PI) / (a * x + 1) * (1 - x);
		},
	
		/**
		 * A bounce easing function. Takes the number of bounces and the weight of
		 * the subject as optional parameters.
		 *
		 * @param   {Number}    x       The state of the animation on [0, 1]
		 * @param   {Number}    n       (optional) The number of bounces, defaults
		 *                              to 4
		 * @return  {Number}            The easing value on [0, 1]
		 * @public
		 */
		bounce: function(x, n){
			n = n ? Math.round(n) : 4;
			var c = 3 - Math.pow(2, 2 - n);
			var m = -1, d = 0, i = 0;
			while(m / c < x){
				d = Math.pow(2, 1 - i++);
				m += d;
			}
			if(m - d > 0) x -= ((m - d) + d / 2) / c;
			return c * c * Math.pow(x, 2) + (1 - Math.pow(0.25, i - 1));
			/*
			n = n ? Math.round(n) : 3;
			var a;
			if(!g){
				a = 0; // no gravity given, same as g = 5
			}else{
				g = Math.round(Math.max(1, Math.min(10, g))) - 5;
				a = g > 0 ? Math.pow(2, g) : g / 5;
			}
			return 1 - Math.abs(Math.cos(x * n * Math.PI) / (a * x + 1) * (1 - x));
			*/
		},
	
		bounce2: function(x, n, g){
			if(!n) n = 4;
			if(!g) g = 5;
			//n = n ? Math.round(n) : 4;
			//g = g ? Math.max(0, Math.min(10, g)) : 5;
			//Math.pow(2, 4 - 1) * 0.46875 - 1 = 2.75
			//Math.pow(2, 4 - 1) * 1 - 1 = 7
			/*
			10  => 0.46875
			9   => 0.68465319688
			8   => 0.82743772991
			0   => 1
			*/
			var c = Math.pow(2, n - 1) - 1;
		},
	
		bounce3: function(x){
			if(x < 1/2.75){
				return 7.5625 * Math.pow(x, 2);
			}else if(x < 2/2.75){
				return 7.5625 * Math.pow(x - 1.5/2.75, 2) + 0.75;
			}else if(x < 2.5/2.75){
				return 7.5625 * Math.pow(x - 2.25/2.75, 2) + 0.9375;
			}else{
				return 7.5625 * Math.pow(x - 2.625/2.75, 2) + 0.984375;
			}
		}
	
	};

	//________________________________PROPERTIES PUBLIC________________________________
	
	//________________________________METHODS PUBLIC________________________________
	this.animate = function(options){
		var from = parseFloat(getStyle(options.element, options.style));
		//var from = 0;
		var delta = options.to - from;
		var unit = options.style == 'opacity' ? '' : 'px'; // default unit is px
	
		var ease = Ease[options.effect];

		var fn = function(ease){
			setStyle(options.element, options.style, from + ease * (options.to - from) + unit);
		};
	
		//options.duration *= 1000; // convert to milliseconds
		var begin = new Date().getTime();
		var end = begin + options.duration;
	
		if(timer) clearInterval(timer); // clear old animation
	
		timer = setInterval(function(){
			var time = new Date().getTime();
			if(time >= end){ // end of animation
				clearInterval(timer);
				fn(ease(1));
				if(typeof options.callback == 'function') options.callback();
			}else{
				fn(ease((time - begin) / options.duration));
			}
		}, 10); // 10 millisecond interval
	};
	
	this.Opacity = function(options){
		if( working ) return;
		working=true;
		//Options:
		// * element   : object
		// * from     : int
		// * to       : int
		// * duration  : int
		// * increment : int
		// * callback  : function
		
		if( !options.element || typeof options.element=="undefined" ) return;
		
		var n = options.from;
		//var speed = Math.round(options.duration / Math.abs(options.from - options.to))-1;
		
		var count = Math.round(Math.abs(options.from - options.to)/options.increment)*2;
		var speed = Math.round(options.duration / count)-1;
		
		setOpacity(options.element, options.from*0.1);
		
		if(timer2) clearInterval(timer2); // clear old animation
		timer2 = setInterval(function(){
			if( options.from < options.to ){
				//if( n<options.to ){
					n+=Ease.quadIn(options.increment);
				//}
			}else if( options.from > options.to ){
				//if( n>options.to ){
					n-=Ease.quadIn(options.increment);
				//}
			}
			
			setOpacity(options.element, n*0.1);
		}, speed);
		
		setTimeout(function(){
						clearInterval(timer2);
						working=false;
						if( typeof options.callback == "function" ) options.callback(options.element);
				   }, options.duration);
	}
}
var Anim = new Class_Animate();
