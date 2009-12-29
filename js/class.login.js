// JavaScript Document

var ClassLogin = function(){
	//------------------------- PUBLIC PROPERTIES -----------------------------//	
	
	//------------------------- PUBLIC METHODS ------------------------------//
	this.validate = function(Form){
		Form.txtUser.focus();
		if( Form.txtUser.value.length==0 ){
			Dialog.show(Form.txtUser, "Este campo es obligatorio.");
			return false;
		}
		
		Form.txtPass.focus();
		if( Form.txtPass.value.length==0 ){
			Dialog.show(Form.txtPass, "Este campo es obligatorio.");
			return false;
		}
		
		Dialog.hidden();
		return true;
	}
	
	this.remember_pass={
		divDialog: false,
		mask: false,
		
		show_dialog: function(el){
			if( !this.divDialog ){
				this.mask = document.createElement("DIV");
				this.mask.style.cssText = "position: fixed;"+
										  "left: 0px;"+
										  "top: 0px;"+
										  "width: 100%;"+
										  "height: 100%;"+
										  "background-color: #cccccc;"+
										  "z-index: 2000;";
				this.mask.onclick = this.close_dialog;
				setOpacity(this.mask, 4);
				
				document.body.appendChild(this.mask);
				
				this.divDialog = document.createElement("DIV");
				this.divDialog.className = "dialogbox";
				el.parentNode.appendChild(this.divDialog);
				
				this.Progress.show();
				var Ajax = new ClassAjax();
					Ajax.on_finalizer = function(){
						This.remember_pass.Progress.divProgress = false;
						
						This.remember_pass.divDialog.innerHTML = this.responseHTML;
						
						setOpacity(document.getElementById("content_form"), 0);
						document.getElementById("content_form").style.display = "block";
						var Anim = new Class_Animate();	
							Anim.Opacity({
								 element: document.getElementById("content_form"),
								 from: 0,
								 to: 10,
								 duration: 800,
								 increment: 1
							});
					}
					Ajax.execute("POST", "includes/dialogbox.php");													
			}
		},
		
		close_dialog: function(){
			document.body.removeChild(This.remember_pass.mask);

			var Anim = new Class_Animate();			
				Anim.Opacity({
					 element: This.remember_pass.divDialog,
					 from: 10,
					 to: 0,
					 duration: 800,
					 increment: 1,
					 callback: function(){
						This.remember_pass.divDialog.parentNode.removeChild(This.remember_pass.divDialog);
						This.remember_pass.divDialog=false;
					 }
				});
				
			This.remember_pass.mask=false;
		},
		
		send: function(){
				if( document.getElementById("txtEmail").value.length==0 ){
					Dialog.show(document.getElementById("txtEmail"), "Este campo es obligatorio.");
					document.getElementById("txtEmail").focus();
					return;
				}
				if( /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById("txtEmail").value)==false ){
					Dialog.show(document.getElementById("txtEmail"), "El email ingresado es incorrecto.");
					document.getElementById("txtEmail").focus();
					return;					
				}
			
			
				this.Progress.show();
				var Ajax = new ClassAjax();
					Ajax.on_finalizer = function(){
						var html = "";
						if( this.responseHTML == "sendmail_ok" ){
							html = "<p>Se ha enviado el email con la nueva contrase&ntilde;a</p>";
						}else if( this.responseHTML == "sendmail_error" ){
							html = "<p>Ocurrio un error al tratar de enviar el email, por favor, intentelo mas tarde.</p>";
							
						}else if( this.responseHTML == "not exists" ){
							html = "<p>El email ingresado no existe en nuestra base de dato.</p>";
							
						}else {
							alert(this.responseHTML);
						}
						
						if( html!="" ) This.remember_pass.Progress.show(html, true);
						else This.remember_pass.Progress.hidden();
					}
					Ajax.execute("POST", "includes/dialogbox.php?action=send", "email="+document.getElementById("txtEmail").value);
			
		},
		
		Progress:{
			divProgress: false,
			show: function(msg, not_photo){
				if( !this.divProgress ){
					this.divProgress = document.createElement("DIV");
					this.divProgress.style.cssText = "position: absolute;"+
													  "left: 10px;"+
													  "top: 47px;"+
													  "width: 293px;"+
													  "height: 114px;"+
													  "z-index: 2001;";

					if( document.getElementById("content_form") ) document.getElementById("content_form").style.display = "none";				
					This.remember_pass.divDialog.appendChild(this.divProgress);
				}
				
				if( !not_photo ) this.divProgress.style.background = "url(images/ajax-loader2.gif) no-repeat center";
				else this.divProgress.style.background = "none";
				if( msg ) this.divProgress.innerHTML = msg;
				else this.divProgress.innerHTML="";
			},
			hidden: function(){
				This.remember_pass.Progress.divProgress.parentNode.removeChild(This.remember_pass.Progress.divProgress);
				This.remember_pass.Progress.divProgress=false;
				if( document.getElementById("content_form") ) document.getElementById("content_form").style.display = "block";
			}
		}
	}
	
	//------------------------- PRIVATE PROPERTIES -----------------------------//	
	var This = this;
	

	//------------------------- PRIVATE METHODS ------------------------------//

}
var Login = new ClassLogin();