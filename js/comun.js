function isIE(){	
	if(navigator.appName.indexOf("Microsoft")>-1) return true;
	else return false;
}

Array.prototype.IsArray = function(){
	return typeof(this)=='object'&&(this instanceof Array);
}

if( typeof(remove_object)=="undefined" ){
	function remove_object(o){
		if( typeof(o)!="undefined" ){
			node = o.parentNode;
			if( node!=null)	node.removeChild(o);
		}
	}	
}

function addEvent(elemento, nombre_evento, funcion){ 
    // para IE 
    if (elemento.attachEvent){ 
        elemento.attachEvent('on' + nombre_evento, funcion); 
        return true; 
    }else   // para navegadores respetan Estándares DOM(Firefox,safari) 
        if (elemento.addEventListener){ 
            elemento.addEventListener(nombre_evento, funcion, true); 
            return true; 
        }else  return false; 
}  

function disabled_selected(o){
	if( typeof(o)=="string" ){
		o = document.getElementById(o);
	}
	if( !o ) return;
	
	if( document.all ) o.onselectstart=new Function ( "return false" )
	else{
		if (window.sidebar){
			o.onmousedown = function(){return false;}
			o.onclick = function(){return true;}
		}
	}
}

function setOpacity(el, opacity){
	var s = el.style;
	var alphaRe = /alpha\([^\)]*\)/gi;
	if(window.ActiveXObject){ // IE
		s.zoom = 1;
		s.filter = (s.filter || '').replace(alphaRe, '') +
				   (opacity == 1 ? '' : ' alpha(opacity=' + opacity * 10 + ')');
	}else{		
		s.opacity = opacity*0.1;
	}
}

function Trim(str){
       return(str.replace(/^\s+/,'').replace(/\s+$/,''));
}

Array.prototype.find = function(searchStr) {
  var returnArray = false;
  for (i=0; i<this.length; i++) {
    if (typeof(searchStr) == 'function') {
      if (searchStr.test(this[i])) {
        if (!returnArray) { returnArray = [] }
        returnArray.push(i);
      }
    } else {
      if (this[i]===searchStr) {
        if (!returnArray) { returnArray = [] }
        returnArray.push(i);
      }
    }
  }
  return returnArray;
}

function FormatNumber(o, decimal){
	if( Trim(o.value)=="" ) return;
	if( typeof decimal!="number" || decimal<0 ) decimal=2;	
	
	var d="";
	for( var n=1; n<=decimal; n++ ) {d+="0";}
	
	var value = o.value.replace(/,/g, '.');
	if( isNaN(o.value) ) {
		o.value = "0."+d;
		return;
	}	
	
	var p = new Array();
		p = value.split(".");
		
	if( p.length==1 ) {
		o.value = p[0]+"."+d;
		
	}else if( p.length==2 ) {
		if( p[1].length<decimal ){
			decimal -= p[1].length;			
			d="";
			for( var n=1; n<=decimal; n++ ) {d+="0";}
			o.value = p[0]+"."+p[1]+d;
		}else if( p[1].length>decimal ){
			document.title = decimal;
			o.value = p[0]+"."+p[1].substr(0,decimal);
		}
	}	
}

function ValidKey(e, type, options){
	var e = window.event || e;
	var code = e.keyCode || e.which;
	
	
	if( type=='number' ){
		var condition_signed = true;
		var condition_decimal = true;

		if( typeof options=="undefined" ){
			options = "signed,decimal";
		}
		options = options.split(",");
		
		for( var i=0; i<=options.length-1; i++){
			switch( Trim(options[i].toLowerCase()) ){
			case "signed":  condition_signed = (code!=45);break;
			case "decimal": condition_decimal = String.fromCharCode(code)!=".";break;
			case "unsigned":  condition_signed = true;break;
			case "nodecimal": condition_decimal = true;break;		
			}
		}				
		
		if( isNaN(String.fromCharCode(code)) && condition_decimal && 
			(code!=8&&code!=33&&code!=34&&code!=35&&code!=36&&code!=37&&code!=38&&code!=39&&code!=40&&condition_signed) ){
			//if( code==46&&String.fromCharCode(code)!="." ) {document.title="pase";return;}
			
			if( !isIE() ) e.preventDefault();
			else e.returnValue=false;
		}
							
	}
	else if( type=='string' ){
		if( !isNaN(String.fromCharCode(code)) && 
			(code!=8&&code!=33&&code!=34&&code!=35&&code!=36&&code!=37&&code!=38&&code!=39&&code!=40) ){
			if( !isIE() ) e.preventDefault();
			else e.returnValue=false;
		}			
	}
	
	return false;
}

function FormatUrl(el){
	if( el.value.length>0 ){
		el.value = (el.value.substr(0, 7).toLowerCase()!="http://") ? "http://"+el.value.toLowerCase() : el.value.toLowerCase();
	}
}

function getKeyCode(e){
	if (!e) var e = window.event;						
	if( e.keyCode ) {
		return e.keyCode;  //DOM
	} else if( e.which ) { 
		return e.which;    //NS 4 compatible
	} else if( e.charCode ) {		
		return e.charCode; //also NS 6+, Mozilla 0.9+
	} else { //total failure, we have no way of obtaining the key code
		return false;
	}
}

function getElementsByClassName(cl, sTagName, el) {  
	var retnode = [];  
	var myclass = new RegExp('\\b'+cl+'\\b');  
	var elem = el.getElementsByTagName((sTagName===""||sTagName===null)?"*":sTagName);  
	for (var i = 0; i < elem.length; i++) {  
		 var classes = elem[i].className;  
		 if (myclass.test(classes)) retnode.push(elem[i]);  
	 } 
	 return retnode;  
};  

function getPropertyCss(el, prop){
	if( document.defaultView && document.defaultView.getComputedStyle ) {
		return document.defaultView.getComputedStyle(el,'').getPropertyValue(prop);
	}else{
		if( el.currentStyle ){
			eval("var result = el.currentStyle."+prop);
			return result;
		}else return "";
	}
}

function validate_date(str){
	 strExpReg = /^(((0[1-9]|[12][0-9]|3[01])([/])(0[13578]|10|12)([/])(\d{4}))|(([0][1-9]|[12][0-9]|30)([/])(0[469]|11)([/])(\d{4}))|((0[1-9]|1[0-9]|2[0-8])([/])(02)([/])(\d{4}))|((29)(\.|-|\/)(02)([/])([02468][048]00))|((29)([/])(02)([/])([13579][26]00))|((29)([/])(02)([/])([0-9][0-9][0][48]))|((29)([/])(02)([/])([0-9][0-9][2468][048]))|((29)([/])(02)([/])([0-9][0-9][13579][26])))$/;
	 
	 return strExpReg.test(str);
}

function ucWords(string){
	var arrayWords;
	var returnString = "";
	var len;
	arrayWords = string.split(" ");
	len = arrayWords.length;
	for( i=0; i < len ; i++ ){
		returnString = (i != (len-1)) ? returnString+ucFirst(arrayWords[i])+" " : returnString+ucFirst(arrayWords[i]);
	}
	
	return returnString;
}
function ucFirst(string){
	return string.substr(0,1).toUpperCase()+string.substr(1,string.length).toLowerCase();
}

function clear_input(e, isPass){
	if (!e) var e = window.event;
	if (e.target) var el = e.target;
	else if (e.srcElement) var el = e.srcElement;
	if(	el.nodeType == 3 )  // defeat Safari bug
		el = el.parentNode;
		
	if( el && (el.getAttribute("attrInputClear")==null || el.getAttribute("attrInputClear")=="1") ){
		el.value = "";
		
		if( isPass && el.getAttribute("type").toLowerCase()!="password" ) {
			if( document.all ){
				var input = document.createElement("input");
					input.setAttribute("type", "password");
					if( el.name ) input.name = el.name;
					if( el.id ) input.id = el.id;
					if( el.className ) input.className = el.className;
					input.value = el.value;
					input.onfocus = el.onfocus;
					input.onblur = el.onblur;
					if( el.getAttribute("attrInputClear")!=null ) input.setAttribute("attrInputClear", el.getAttribute("attrInputClear"));
					
				el.parentNode.replaceChild(input, el);
				setTimeout(function(){input.focus();}, 800);
				
			}else el.setAttribute("type", "password");
		}

		return false;
	}
}
function set_input(e, text, isPass){
	if (!e) var e = window.event;
	if (e.target) var el = e.target;
	else if (e.srcElement) var el = e.srcElement;
	if(	el.nodeType == 3 )  // defeat Safari bug
		el = el.parentNode;
	
	if( el ){
		if( el.value.length==0 ){
			if( isPass && el.getAttribute("type").toLowerCase()!="text" ) {
				var input = document.createElement("input");
					input.setAttribute("type", "text");
					if( el.name ) input.name = el.name;
					if( el.id ) input.id = el.id;
					if( el.className ) input.className = el.className;
					input.value = el.value;
					input.onfocus = el.onfocus;
					input.onblur = el.onblur;
				el.parentNode.replaceChild(input, el);
				input.value = text;
				input.setAttribute("attrInputClear", "1");
				
			}else {
				el.setAttribute("type", "text");
				el.value = text;
				el.setAttribute("attrInputClear", "1");
			}
						
		}else el.setAttribute("attrInputClear", "0");
		
		return false;
	}
}

//Función para el caso ej de Boxeo (Categoria)
function ShowContent (url, id){
	$(id).hide().load(url, function() {
	  	$(this).fadeIn();
	});
}

//Función para que aparezca un campo o se oculte.
function ShowOtro(value, id, p){
	
	if( value=="+" ){
		$(id+' .validator').each(function(){
			$(this).css("display","block");	
		});
		$(id).fadeIn("slow");
	}else {
		$(id+' .validator').each(function(){
			$(this).css("display","none");	
		});
		$(id).fadeOut("slow");
	
	}
}
