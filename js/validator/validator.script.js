/*
  --- SCRIPT      : Validador de datos
  --- Version     : 2.0
  --- Creado por  : Ivan Mattoni
  --- Empresa     : MyDesign
*/

var ClassValidator = function(id, direct){	
	if( typeof id=="undefined" || typeof id!="string" ) return;


	//________________________________ PROPERTIES PUBLIC ________________________________
	this.styleName = "validator";	
	this.messages = {
		required   : 'Este campo es obligatorio.',
		mail       : 'El email ingresado es incorrecto.',
		string     : 'Este campo debe tener caracteres alfabeticos.',
		numeric    : 'Este campo debe tener caracteres num&eacute;ricos.',
		date       : 'El formato de la fecha es incorrecto.',
		compare    : 'El password y la confirmaci&oacute;n no coinciden',
		password   : 'El password debe tener entre 6 y 10 caracteres, por lo menos un d&iacute;gito y un alfanum&eacute;rico, y no  puede contener caracteres espaciales.',
		coustom    : ''
	}
	this.setStyle = {};
	this.validateOne = false;
	this.error = 0;
	this.template = 1;  // 1=Rectangulo con bordes, 2=Rectangulo simple

	//________________________________ METHODS PUBLIC ________________________________
	this.validate = function(e){	
		if( e ){			
			if( !e ) var e = window.event;
			if( e.target ) el = e.target;
			else if( e.srcElement ) el = e.srcElement;
			if( el.nodeType == 3 ) // defeat Safari bug
				el = el.parentNode;			
		}
		
	
		var condition = true;
		var all_OK=true;
				
		for( var i=0; i<=Inputs.length-1; i++ ){
			if( e ) condition = Inputs[i]==el;
			else var el = Inputs[i];
			
			if( This.validateOne && lastError && lastError!=Inputs[i] ) continue;
			
			if( condition ){
				Elements.inputCurrent = Inputs[i];
				
				var Attr = Inputs[i].getAttribute("validator");
				if( Attr!=null ){				
					eval('var params = {'+Attr+'}');
					
					for( p in params ){
						eval('var value = params.'+p);
												
						var r = validate_field(p, value, el);
						if( !r ) {
							This.error=1;
							all_OK=false;
							if( This.validateOne ) {
								Elements.inputCurrent.focus();
								return false;
							}
							break;
						}else This.error=0;
						
					}
					if( r ) show_icon();						
				}
				
				if( e ) return true;
			}			
		}
		
		if( all_OK ) lastError=false;
		
		return all_OK;
	};

	this.show_message = function(param){
		if( param.message && param.element ){
			
			/*if( lastInputMessage ){
				lastInputMessage.parentNode.removeChild(lastInputMessage.parentNode.contentDialog);
			}
			
			lastInputMessage = param.element;*/
			
			show_dialog(param.message, param.element);
		}
	};
	
	this.hidden_message = function(el, hidden_icon){
		if( !el ) return false;		
		show_icon(el, hidden_icon);
	};




	//________________________________ PROPERTIES PRIVATE ________________________________
	var This = this;
	var working = false;
	var myArray = new Array();
	var Id = "";
	var Class = "";
	var Inputs = new Array();
	var Elements = {};
	var lastError = false;
	var lastInputMessage = false;
	

	//________________________________ METHODS PRIVATE ________________________________
	var validate_field = function(p, value, el){
		switch(p){
		case 'required':
			if( value ){				
				if( Trim(el.value).length==0 ) {
					show_dialog(get_message('required'));
					return false;
				}
			}
		break;						

		case 'string':
			if( value ){								
				if( !isNaN(el.value) ){
					show_dialog(get_message('string'));
					return false;
				}
			}
		break;

		case 'numeric':
			if( value ){								
				if( isNaN(el.value) ){
					show_dialog(get_message('numeric'));
					return false;
				}
			}
		break;	

		case 'mail':
			if( value ){								
				if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(el.value) == false ){
					show_dialog(get_message('mail'));
					return false;
				}
			}
		break;	

		case 'date':
			if( value.length==10 ){				
				value = Trim(value.toLowerCase());
				var pattern = "";
				
				switch( value ){
				case 'dd/mm/yyyy': pattern = "/"; break;
				case 'dd-mm-yyyy': pattern = "-"; break;
				case 'dd.mm.yyyy': pattern = "."; break;
				case 'mm/dd/yyyy': pattern = "/"; break;
				case 'mm-dd-yyyy': pattern = "-"; break;
				case 'mm.dd.yyyy': pattern = "."; break;
				}			
				if( pattern=="" ) {show_dialog(get_message('date')); return false;}
				
				myArray = el.value.split(pattern);
				if( myArray.length!=3 ) {show_dialog(get_message('date')); return false;}
				
				if( value.substr(0,2)=="dd" ){
					var Day = myArray[0];
					var Month = myArray[1];
					var Year = myArray[2];
				}else{
					var Day = myArray[1];
					var Month = myArray[0];
					var Year = myArray[2];					
				}
								
				if( isNaN(Year) || Year.length<4 || parseFloat(Year)<1900 ) {show_dialog(get_message('date')); return false;}
				if( isNaN(Month) || parseFloat(Month)<1 || parseFloat(Month)>12 ) {show_dialog(get_message('date')); return false;}
				if( isNaN(Day) || parseInt(Day, 10)<1 || parseInt(Day, 10)>31 ) {show_dialog(get_message('date')); return false;}
				if( Month==4 || Month==6 || Month==9 || Month==11 || Month==2 ) {
					if( Month==2 && Day > 28 || Day>30 ) {show_dialog(get_message('date')); return false;}
				}
			}
		break;
		
		case 'compare':
			if( value ){
				var el2 = document.getElementById(value);
				if( el2 ){
					if( el2.value.length!="" && el.value.length!="" ){
						if( el2.value!=el.value ){
							show_dialog(get_message('compare')); 
							return false;
						}else{
							
							show_icon(el2);
							
						}
					}
				}
			}
		break;
		
		case 'password':
			if( value ){
				var RegExPattern = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{6,10})$/;
				
				if( (el.value.match(RegExPattern)) && (el.value!='') ){
					show_icon(el2);
				} else {
					show_dialog(get_message('password')); 
					return false;					
				}
			}
		break;		
		}
			
		return true;
	};
	
	var get_message = function(value){
		var id = "";
		if( Elements.inputCurrent.id ) var id = Elements.inputCurrent.id;
		else if( Elements.inputCurrent.name ) var id = Elements.inputCurrent.name;

		eval('var message = This.messages.'+value);		

		if( id!="" ){
			eval('var newMsg = (This.messages.coustom.'+id+') ? This.messages.coustom.'+id+'.'+value+' : false');
			if( newMsg ) message = newMsg;
		}
		
		return message;
	}
	
	
	var show_dialog = function(text, el){
		if( This.validateOne && !el) {
			if( This.error>0 && lastError!=Elements.inputCurrent ){
				return false;
			}
		}
		
		if( !el ) el = Elements.inputCurrent;
				
		if( el.parentNode.contentDialog ){
			el.parentNode.removeChild(el.parentNode.contentDialog);
		}
				
		el.style.cssText = "float:left;";
		
		var contentDialog = document.createElement("DIV");
			contentDialog.className = This.styleName;
			
			var Dialog = document.createElement("DIV");
				Dialog.className = "dialog";			
			
			if( This.template==1 ){
				
				setOpacity(contentDialog, 0);
				
				var Top = document.createElement("DIV");
					Top.className = "top";
				var Content = document.createElement("DIV");
					Content.className = "content";
				var Bottom = document.createElement("DIV");
					Bottom.className = "bottom";
					
				var bLeft = document.createElement("DIV");
					bLeft.className = "bLeft";
				var bRight = document.createElement("DIV");
					bRight.className = "bRight";					
				Top.appendChild(bLeft);
				Top.appendChild(bRight);
				
				var bLeft = document.createElement("DIV");
					bLeft.className = "bLeft";
				var icon = document.createElement("DIV");
					icon.className = "icon";
				var Msg = document.createElement("DIV");
					Msg.className = "text";
					Msg.innerHTML = text;
				var bRight = document.createElement("DIV");
					bRight.className = "bRight";
				Content.appendChild(bLeft);
				Content.appendChild(icon);
				Content.appendChild(Msg);
				Content.appendChild(bRight);
								
				var bLeft = document.createElement("DIV");
					bLeft.className = "bLeft";
				var bRight = document.createElement("DIV");
					bRight.className = "bRight";					
				Bottom.appendChild(bLeft);
				Bottom.appendChild(bRight);
							
				Dialog.appendChild(Top);
				Dialog.appendChild(Content);
				Dialog.appendChild(Bottom);
			}else{
				var arrow = document.createElement("DIV");
					arrow.className = "arrow";
				var span = document.createElement("SPAN");
					span.className = "text";
					span.innerHTML = text;
				Dialog.appendChild(arrow);
				Dialog.appendChild(span);				
			}
				
			contentDialog.appendChild(Dialog);
		
		el.parentNode.appendChild(contentDialog);		
		//el.parentNode.insertBefore(contentDialog, el);		
		el.parentNode.contentDialog = contentDialog;
		
		if( This.template==1 ){
			for( elem in This.setStyle ){
				if( el.name==elem || el.id==elem ){
					eval('var height = This.setStyle.'+elem+'.height ? This.setStyle.'+elem+'.height : false');
					eval('var marginTop = This.setStyle.'+elem+'.marginTop ? This.setStyle.'+elem+'.marginTop : false');
					if( height ) Content.style.height = height;
					if( marginTop ) Dialog.style.marginTop = marginTop;
					
					break;
				}
			}
		}
						
		lastError = el;
		
		if( This.template==1 ){		
			var Anim = new Class_Animate();
				Anim.Opacity({
					element: el.parentNode.contentDialog,
					from: 0,
					to: 10,
					duration: 800,
					increment: 1
				});		
		}else{
			var Anim = new Class_Animate();
				Anim.animate({
					element: Dialog,
					style: 'margin-left',
					to: 0,
					duration: 800,
					effect: 'bounce',
					callback: function(){
					}
				});
		}
	};
	
	var show_icon = function(el, hidden_icon){
		if( This.validateOne && This.error>0 && !el ) return false;
		
		if( !el ) el = Elements.inputCurrent;
		
		if( el.parentNode.contentDialog ){
			el.parentNode.removeChild(el.parentNode.contentDialog);
		}
				
		if( !hidden_icon ){
			el.style.cssText = "float:left";
			
			var contentDialog = document.createElement("DIV");
				contentDialog.className = This.styleName;
				var div = document.createElement("DIV");
					div.className = "icon_ok";
				contentDialog.appendChild(div);
							
			el.parentNode.appendChild(contentDialog);
			el.parentNode.contentDialog = contentDialog;
		}else{
			el.parentNode.contentDialog = false;			
		}
	};
	






	/*------------------------------------ FRAMEWORK ------------------------------------*/
	var getElementsByClassName = function(cl, sTagName, el) {
		if( !el ) el = document.body;
		
		var retnode = [];  
		var myclass = new RegExp('\\b'+cl+'\\b');  
		var elem = el.getElementsByTagName((sTagName===""||sTagName===null)?"*":sTagName);  
		for (var i = 0; i < elem.length; i++) {  
			 var classes = elem[i].className;  
			 if (myclass.test(classes)){
	 			if( elem[i].nodeName && elem[i].nodeName.toLowerCase()=="input" && (elem[i].getAttribute("type")=="text"||elem[i].getAttribute("type")=="password"||elem[i].getAttribute("type")=="file") && elem[i].getAttribute("validator")!=null )
					 retnode.push(elem[i]); 
			 }
		 } 
		 return retnode;
	};

	var addEvent = function(elemento, nombre_evento, funcion){ 
		// para IE 
		if (elemento.attachEvent){ 
			elemento.attachEvent('on' + nombre_evento, funcion); 
			return true; 
		}else   // para navegadores respetan Estándares DOM(Firefox,safari) 
			if (elemento.addEventListener){ 
				elemento.addEventListener(nombre_evento, funcion, true); 
				return true; 
			}else  return false; 
	};

	var setOpacity = function(el, opacity){
		var s = el.style;
		var alphaRe = /alpha\([^\)]*\)/gi;
		if(window.ActiveXObject){ // IE
			s.zoom = 1;
			s.filter = (s.filter || '').replace(alphaRe, '') +
					   (opacity == 1 ? '' : ' alpha(opacity=' + opacity * 10 + ')');
		}else{		
			s.opacity = opacity*0.1;
		}
	};

	var Trim = function(str){
		   return(str.replace(/^\s+/,'').replace(/\s+$/,''));
	};
	/*--------------------------------------- FIN FREAMWORK --------------------------------------*/



	//________________________________ INTIALIZER ________________________________
	var initializer = function(){
		if( id.indexOf(" ")>-1 ){
			myArray = id.split(" ");
			if( myArray.length>2 ) return;		
			Class = myArray[1].substr(1);
			Id = document.getElementById(myArray[0].substr(1));
		}else{
			if( id.indexOf(".")>-1 ){
				Class = id;
				Id = false;
			}else{
				Class="";
				Id = id;
			}
		}
					  
		if( Class!="" ){
			Inputs = getElementsByClassName( Class, "input", Id );
			if( direct ){
				for( var i=0; i<=Inputs.length-1; i++ ){
					addEvent( Inputs[i], "blur", This.validate );
				}
			}
			
		}else Inputs[0] = document.getElementById(Id);
	}
	
	if( document.body ){
		initializer();
	}else{		
		addEvent(window, "load", initializer);
	}


}