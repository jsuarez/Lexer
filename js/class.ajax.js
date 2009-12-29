// Objeto Ajax

var ClassAjax = function(){
	//________________________________PROPERTIES PUBLIC________________________________
	this.on_finalizer = function(){};
	this.responseHTML = '';
	this.responseXML = '';
	

	//________________________________METHODS PUBLIC________________________________
	this.execute = function(method, link, send){
		XMLHttp = create_instance_ajax();
		if( XMLHttp ){
			if( typeof(send)=="undefined" ) send=null;
			XMLHttp.onreadystatechange = changing_state_ajax;
			XMLHttp.open(method, link, true);
			XMLHttp.send(send);
			return;
		}		
	};

	this.request_form = function(f){
		var get = "";
		if( f.nodeName && f.nodeName.toLowerCase()=="form" ){
			for( var i=0; i<=f.length-1; i++ ){
				if( f[i].getAttribute("type") && f[i].getAttribute("type").toLowerCase()=="radio" ){
					if( f[i].checked ) get+=f[i].name+"="+escape(f[i].value)+"&";
					
				}else if( f[i].getAttribute("type") && f[i].getAttribute("type").toLowerCase()=="checkbox" ){
					if( f[i].checked ) get+=f[i].name+"=1&";
					else get+=f[i].name+"=0&";
					
				}else{			
					get+=f[i].name+"="+escape(f[i].value)+"&";
				}
			}
			return get;
		}
		return false;
	};



	//________________________________PROPERTIES PRIVATE________________________________
	var XMLHttp = false;
	var This = this;
	
	
	//________________________________METHODS PRIVATE________________________________
	var create_instance_ajax = function(){
		XMLHttp = false;
		
		if( window.XMLHttpRequest ){
			return new XMLHttpRequest();
		}
		else if( window.ActiveXObject ){
			var versiones = ["Msxml2.XMLHTTP.7.0","Msxml2.XMLHTTP.6.0","Msxml2.XMLHTTP.5.0","Msxml2.XMLHTTP.4.0","MSXML2.XMLHTTP.3.0","MSXML2.XMLHTTP","Microsoft.XMLHTTP"];
			
			for(var i=0;i<versiones.length;i++){
				try {
					XMLHttp = new ActiveXObject(versiones[i]);
					if( XMLHttp ){
						return XMLHttp;
						break;
					}
				} catch(e){}
			}
		}
	};
	
	var changing_state_ajax = function(){
		//if( XMLHttp.readyState==1 ){
			try{
				XMLHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			}
			catch(e){}
		//}
		
		if( XMLHttp.readyState==4 ){
			if( XMLHttp.status==200 ){
				This.responseHTML = XMLHttp.responseText;
				This.responseXML = XMLHttp.responseXML;
				This.on_finalizer();
				
			}else{
				alert("Failed to receive response "+XMLHttp.statusText);
			}
		}
	};	
}