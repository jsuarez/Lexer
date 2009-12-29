// Muestra o Oculta un cuadro de dialogo

var ClassDialog = function(){
	//------------------------- PUBLIC PROPERTIES -----------------------------//	
	this.style_name = "my_dialog";

	//------------------------- PUBLIC METHODS ------------------------------//
	this.show = function(el, text){
		if( !el ) return;
		el.parentNode.style.position = "relative";
		
		if( divDialog ) this.hidden();
		
		divDialog = document.createElement("DIV");
		divDialog.className = this.style_name;
		divDialog.style.top = el.parentNode.offsetHeight+"px";
		divDialog.style.left = el.offsetLeft+"px";
		divDialog.onclick = This.hidden;	

			var divArrow = document.createElement("DIV");
				divArrow.className = "arrow";			
			var divSpan = document.createElement("span");
				divSpan.innerHTML = text;
				
		if( el.attachEvent ){
			el.attachEvent('onkeypress', this.hidden); 
		}else{   // para navegadores respetan Estándares DOM(Firefox,safari) 
			if( el.addEventListener ){ 
				el.addEventListener("keypress", This.hidden, true); 
			}
		}
				
		divDialog.appendChild(divArrow);
		divDialog.appendChild(divSpan);
		el.parentNode.appendChild(divDialog);
		divDialog.focus();
	}
	
	this.hidden = function(){
		if( divDialog ){
			divDialog.parentNode.removeChild(divDialog);
			divDialog = false;

			if( this.removeEventListener ){
			  this.removeEventListener("keypress", This.hidden, true);
			}else if( this.detachEvent ){
			  this.detachEvent("onkeypress", this.hidden);
			}
		}
	}


	//------------------------- PRIVATE PROPERTIES -----------------------------//
	var This = this;
	var divDialog = false;


	//------------------------- PRIVATE METHODS ------------------------------//

		
	
}
var Dialog = new ClassDialog();