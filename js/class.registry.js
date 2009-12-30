// JavaScript Document

var ClassRegistry = function(){
	//________________________________ PROPERTIES PUBLIC ________________________________

	//________________________________ METHODS PUBLIC ________________________________
	this.show_form = function(pagename, coduser){
		if( working || pagename==0 ) return;
		
		if( !coduser ){
			Progress2.show(document.getElementById("cboRegCategory"));
			document.getElementById("cboRegCategory").disabled = true;
			var params = "?show_data_users=1&show_catcha=1";
		}else {
			Progress3.show();
			var params = "?coduser="+coduser;
		}
		
		
		var Ajax = new ClassAjax();
			Ajax.on_finalizer = function(){		
				
				var myFunc = function(){
					Validator = new Class_Validator({
						selectors:	'.validator',
						messagePos: 'right',
						messageClass: 'formError_Right',
						validationOne: true			
					});
				
					//--------- Autocomplete para "Idiomas" --------------------
					$("#txt_reg_language").autocomplete("includes/ajax/autocomplete.php?action=language", {
						width: 200,
						selectFirst: false
					});
					$("#txt_reg_language").result(function(event, data, formatted) {
						document.getElementById("txt_reg_language").setAttribute("attrCode", data[1]);
					});
												
					//--------- Autocomplete para "Paises" --------------------
					$("#txt_reg_country").autocomplete("includes/ajax/autocomplete.php?action=country", {
						width: 200,
						selectFirst: false
					});				
					$("#txt_reg_country").result(function(event, data, formatted) {
						document.getElementById("txt_reg_country").setAttribute("attrCode", data[1]);
					});
					//--------- Autocomplete para "Provincias" --------------------
					$("#txt_reg_province").autocomplete("includes/ajax/autocomplete.php?action=province", {
						width: 200,
						selectFirst: false
					});				
					$("#txt_reg_province").result(function(event, data, formatted) {
						document.getElementById("txt_reg_province").setAttribute("attrCode", data[1]);
					});
					//--------- Autocomplete para "Rubro" --------------------
					$("#txt_reg_item").autocomplete("includes/ajax/autocomplete.php?action=items", {
						width: 200,
						selectFirst: false
					});				
					$("#txt_reg_item").result(function(event, data, formatted) {
						document.getElementById("txt_reg_item").setAttribute("attrCode", data[1]);
					});
										
												
					/*Validator = new ClassValidator('#form_registry .inputbox', true);
					//Validator.validateOne = true;
					Validator.template = 2;
					Validator.messages.coustom = {
						txt_reg_Email: {
							compare: 'El email y la confirmaci&oacute;n no coinciden.'
						},
						txt_reg_RepeatEmail: {
							compare: 'El email y la confirmaci&oacute;n no coinciden.'
						}
					}*/
				
				}//end myFunc
				if( !coduser )	{
					document.getElementById("cboRegCategory").disabled = false;
					$("#form_registry").html(this.responseHTML).hide().slideToggle("normal",myFunc);
					Progress2.hidden(document.getElementById("cboRegCategory"));					
				}else{
					Progress3.hidden();
					$("#form_registry").html(this.responseHTML);
					myFunc();
					if( document.formRegistry.cboBirthDate_Day ) This.show_age();
					Progress3.hidden();
				}

			}			
			Ajax.execute("POST", "includes/registration_forms/"+pagename+params);
	}
	
	this.send = function(filename, action, coduser){							  
		var html_errorvalid = '<p>Han ocurrido errores de validaci&oacute;n, por favor, revise los campos del formulario.<p>'+
							  '<p><button onclick="Registry.close_win_loading();">Cerrar</button></p>';

		var html_sendimages = '<p><img src="images/ajax-loader2.gif" alt="" align="absmiddle" />&nbsp;Subiendo las im&aacute;genes.</p>';
		
		Validator.validate(function(error, elem){
			if( error ){
				Progress.show(html_errorvalid);
				return;
			}else{
				
					//-- Valida Fotos --//
			/*		if( document.getElementById("list1") ){
						var inputs = document.getElementById("list1").getElementsByTagName("input");
						var j=0;
						for( var i=0; i<=inputs.length-1; i++ ){
							if( inputs[i].value!="" ) {j=1;break;}
						}
						if( j==0 ){
							Validator.show_message({
								message: 'Debe ingresar al menos una im&aacute;gen.',
								element: inputs[0]
							});
							
							Progress.show(html_errorvalid);			
							return;
						}
					}*/
					
					//--- Valida el sexo ---//
					if( document.formRegistry.opt_reg_sex ){
						if( !document.formRegistry.opt_reg_sex[0].checked && !document.formRegistry.opt_reg_sex[1].checked ){
                                                        Validator.message.show(document.formRegistry.opt_reg_sex[0].parentNode, ['Este campo es obligatorio']);
							Progress.show(html_errorvalid);			
							return;
						}
					}
					
					//--- Valida la Fecha ---//
					if( document.formRegistry.cboBirthDate_Day ){
						var strDate = document.formRegistry.cboBirthDate_Day.value+"/"+document.formRegistry.cboBirthDate_Month.value+"/"+document.formRegistry.cboBirthDate_Year.value;
						if( !validate_date(strDate) ){
                                                        Validator.message.show(document.formRegistry.cboBirthDate_Year, ['La fecha seleccionada es incorrecta.']);
							Progress.show(html_errorvalid);
							return;
						}
					}
			
					//--- Valida campo "Pais" ---//
					if( document.formRegistry.txt_reg_country && document.formRegistry.txt_reg_country.getAttribute("attrCode")=="0" ){
                                                Validator.message.show(document.formRegistry.txt_reg_country, ['El pa&iacute;s ingresado no existe.']);
						Progress.show(html_errorvalid);
						return;
					}
					//--- Valida campo "Provincia" ---//
					if( document.formRegistry.txt_reg_province && document.formRegistry.txt_reg_province.getAttribute("attrCode")=="0" ){
                                                Validator.message.show(document.formRegistry.txt_reg_province, ['La provincia ingresada no existe.']);
						Progress.show(html_errorvalid);
						return;
					}
			
					//--- Valida campo "Pasaporte" ---//
					if( document.formRegistry.cbo_reg_Passport && document.formRegistry.cbo_reg_Passport.value=="0" ){
                                                Validator.message.show(document.formRegistry.cbo_reg_Passport, ['Este campo es obligatorio.']);
						Progress.show(html_errorvalid);
						return;
					}
			
					//--- Valida campo "Idioma" ---//
					if( document.formRegistry.txt_reg_language && document.formRegistry.txt_reg_language.getAttribute("attrCode")=="0" ){
                                                Validator.message.show(document.formRegistry.txt_reg_language, ['El idioma ingresado no existe.']);
						Progress.show(html_errorvalid);
						return;
					}
			
					//--- Valida campo "Trabajo" ---//
					if( document.formRegistry.cbo_reg_work ){
					   if( document.formRegistry.cbo_reg_work.value=="0" ) {
                                                Validator.message.show(document.formRegistry.cbo_reg_work, ['Este campo es obligatorio.']);
                                                Progress.show(html_errorvalid);
                                                return;
					   }
					   else if( document.formRegistry.cbo_reg_work.value=="+" ) {
						   if( document.formRegistry.txt_reg_work_other.value.length==0 ){
                                                       Validator.message.show(document.formRegistry.txt_reg_work_other, ['Este campo es obligatorio.']);
                                                        Progress.show(html_errorvalid);
                                                        return;
						   }
					   }
					}
			
					//--- Valida campo "Licencia" ---//
					if( document.formRegistry.opt_reg_licence ){
						if( !document.formRegistry.opt_reg_licence[0].checked && !document.formRegistry.opt_reg_licence[0].checked ){
                                                        Validator.message.show(document.formRegistry.opt_reg_licence[0].parentNode, ['Este campo es obligatorio']);
							Progress.show(html_errorvalid);			
							return;				
						}
						
						if( document.formRegistry.opt_reg_licence[0].checked ){
							if( document.formRegistry.txt_reg_licence.value.length==0 ){
                                                            Validator.message.show(document.formRegistry.txt_reg_licence, ['Este campo es obligatorio.']);
                                                            Progress.show(html_errorvalid);
                                                            return;
							}
						}
					}
			
					//--- Valida campo "Listados de deportes" ---//
					if( document.formRegistry.cboListSports_new && document.formRegistry.cboListSports_new.options.length==0 ){
                                                Validator.message.show(document.formRegistry.cboListSports_new, ['Debe seleccionar al menos un deporte.']);
						Progress.show(html_errorvalid);
						return;			
					}
					
					//--- Valida que este chequiado el check politicas de privacidad ---//
					if( document.formRegistry.chkPrivacity && !document.formRegistry.chkPrivacity.checked ){
                                                Validator.message.show(document.formRegistry.chkPrivacity, ['Este campo es obligatorio.']);
						Progress.show(html_errorvalid);
						return;
					}
					
					Params.filename = filename;
					Params.action = action;
					Params.coduser = coduser;		
					This.save();
				
			}
		});

	}

	this.save = function(){
		var html_sendform = '<p><img src="images/ajax-loader2.gif" alt="" align="absmiddle" />&nbsp;Guardando el formulario.</p>';
		var html_userexists = '<p>El nombre del usuario ingresado ya existe</p><br>'+
							  '<p><button onclick="Registry.close_win_loading();">Cerrar</button></p>';
		var html_success = '<p>El registro ha sido completado con &eacute;xito, en unos instantes resibir&aacute; un email para la activaci&oacute;n de su cuenta.</p>'+
						   '<p><button onclick="location.href=\'index.php\'">Aceptar</button></p>';

		var html_success_edit = '<p>Los datos han sido guardado con &eacute;xito.</p>'+
						   '<p><button onclick="location.href=\'user-account.php\'">Aceptar</button></p>';

		var html_errormail = '<p>Ha ocurrido un error durante el envio del email.</p><br>'+
					    	 '<p><button onclick="Registry.close_win_loading();">Cerrar</button></p>';
				
				
		//---------- Campos Adicionales ----------
		var others_fields="";		
		if( document.formRegistry.txt_reg_country )	 others_fields+="&codcountry="+document.formRegistry.txt_reg_country.getAttribute("attrCode");
		if( document.formRegistry.txt_reg_province ) others_fields+="&codprovince="+document.formRegistry.txt_reg_province.getAttribute("attrCode");
		if( document.formRegistry.txt_reg_language ) others_fields+="&codlanguage="+document.formRegistry.txt_reg_language.getAttribute("attrCode");
		if( document.formRegistry.txt_reg_language2 ) others_fields+="&codlanguage2="+document.formRegistry.txt_reg_language2.getAttribute("attrCode");
		if( document.formRegistry.txt_reg_language3 ) others_fields+="&codlanguage3="+document.formRegistry.txt_reg_language3.getAttribute("attrCode");
		if( document.formRegistry.txt_reg_language4 ) others_fields+="&codlanguage4="+document.formRegistry.txt_reg_language4.getAttribute("attrCode");
		if( document.formRegistry.txt_reg_item )	  others_fields+="&coditem="+document.formRegistry.txt_reg_item.getAttribute("attrCode");

		if( document.formRegistry.cboListSports_new ){
			var codes="";
			for( var i=0; i<=document.formRegistry.cboListSports_new.options.length-1; i++ ){
				codes+=document.formRegistry.cboListSports_new.options[i].value+",";
			}
			others_fields+="&codsports="+codes;
		}
		if( Params.coduser ) others_fields+="&coduser="+Params.coduser;
		
		
		//Progress.show(html_sendform);
		var Ajax = new ClassAjax();
			Ajax.on_finalizer = function(){
				if( this.responseHTML=="sendmail_ok" ){
					Progress.show(html_success);
					
				}
				else if( this.responseHTML=="sendmail_error" ){
					Progress.show(html_errormail);

				}else if( this.responseHTML=="ok_edit" ){
					Progress.show(html_success_edit);

				}
				else if( this.responseHTML=="code invalid" ){
					Validator.message.show(document.formRegistry.code, ["El c&oacute;digo ingresado es incorrecto."]);
					Progress.hidden();
					return;
				}
				else if( this.responseHTML=="user exists" ){
					Progress.show(html_userexists);
				}
				else{
					alert(this.responseHTML);
				}
			}
			Ajax.execute("POST", "includes/ajax/"+ Params.filename +"?action="+Params.action, 
						 		 Ajax.request_form(document.formRegistry) + others_fields);
	}
	
	this.show_age = function(){
		var day = document.formRegistry.cboBirthDate_Day.value;
		var month = document.formRegistry.cboBirthDate_Month.value;
		var year = document.formRegistry.cboBirthDate_Year.value;

		
		if( day>0 && month>0 && year>0 ){
			Validator.message.hidden($(document.formRegistry.cboBirthDate_Year));
			
			var str = day+"/"+month+"/"+year;
			
			if( validate_date(str) ){
				var dateToday = new Date();
				var age = dateToday.getFullYear()-parseFloat(year) -1;

				if( !(dateToday.getMonth() + 1 - parseInt(month) < 0) ) { //+ 1 porque los meses empiezan en 0
					if( (dateToday.getMonth() + 1 - parseInt(month) > 0) ) age+=1;
					else{
						if( dateToday.getUTCDate() - parseInt(day) >= 0 ) age+=1;
					}
				}
				document.formRegistry.txt_reg_Age.value = age;
			}else{
                                Validator.message.show(document.formRegistry.cboBirthDate_Year, ['La fecha seleccionada es incorrecta.']);
				document.formRegistry.txt_reg_Age.value = "";
			}
		}
	}
	
	this.ShowHidden_panel = function(option, id, func_extra){
			var IDs = new Array();
			var rows = new Array();
				IDs = id.split(",");
				
			for( var i=0; i<=IDs.length-1; i++ ){
				var newRow = document.getElementById(Trim(IDs[i]));
				if( newRow ) {
					if( (option=="show" && newRow.style.display=="none"||newRow.style.display=="") || (option=="hidden" && newRow.style.display=="block") ){
						rows.push(newRow);
					}
				}
			}
			
			if( rows.length>0 ){
				
				if( option=="show" ){
					var from = 0;
					var to = 10;
					
					if( func_extra ){
						var callback = function(){
							eval(func_extra);
						}
					}else var callback = function(){}
					
				}else{
					var from = 10;
					var to = 0;
					
					var callback = function(el){	
						el.style.cssText = "display:none;";
						if( func_extra ) eval(func_extra);
					}
				}
	
				for( var i=0; i<=rows.length-1; i++ ){
					if( option=="show" ){					
						setOpacity(rows[i], 0);
						rows[i].style.cssText = "display:block !important;";
					}
					
					var Anim = new Class_Animate();			
						Anim.Opacity({
							 element: rows[i],
							 from: from,
							 to: to,
							 duration: 800,
							 increment: 0.5,
							 callback: callback
						});
				}
			}
	}
	
	this.add_field = function(elButton, id, limit){
		if( working ) return;
		
		var ul = document.getElementById(id);
		var inputs = ul.getElementsByTagName("input");
		
		if( inputs.length < limit ){			
			var li = document.createElement("li");
			var input = document.createElement("input");
				input.className = inputs[0].className;
				input.setAttribute("type", inputs[0].getAttribute("type"));
			if( inputs[0].getAttribute("type").toLowerCase()=="file" ) input.size = "33";
				input.name = inputs[0].name+(inputs.length+1);
			if( inputs[0].id ) input.id = inputs[0].id+(inputs.length+1);
			li.appendChild(input);
						
			ul.appendChild(li);
			
			input.focus();
			
			if( inputs.length==limit ) elButton.parentNode.removeChild(elButton);
		}
		
		return false;
	}

	this.add_field_lang = function(elButton, id, limit){
		if( working ) return;
		
		var ul = document.getElementById(id);
		var countinput = ul.getElementsByTagName("input").length;
		
		if( countinput < limit ){
			//--Fila1
			var li = document.createElement("li");
			var input = document.createElement("input");
				input.className = "inputbox inputsmall";
				input.setAttribute("type", "text");
				input.name = "txt_reg_language"+(countinput+1);
				input.id = "txt_reg_language"+(countinput+1);
				input.setAttribute("attrTable", "list_languages");
				input.onblur = new Function("this.value = ucWords(this.value);");
				input.setAttribute("attrTable", "list_languages");
			li.appendChild(input);
			ul.appendChild(li);

			//--Fila2
			var li = document.createElement("li");			
			
			var span = document.createElement("span");
				span.innerHTML = "Nivel Hablado:&nbsp;";
			li.appendChild(span);
			var select_level_talk = document.createElement("select");
				select_level_talk.name = "cbo_reg_language"+(countinput+1)+"_talk";
				select_level_talk.innerHTML = document.formRegistry.cbo_reg_language_talk.innerHTML;
			li.appendChild(select_level_talk);
			
			var span = document.createElement("span");
				span.innerHTML = "&nbsp;&nbsp;Nivel Escrito:&nbsp;";
			li.appendChild(span);
			var select_level_write = document.createElement("select");
				select_level_write.name = "cbo_reg_language"+(countinput+1)+"_write";
				select_level_write.innerHTML = document.formRegistry.cbo_reg_language_write.innerHTML;
			li.appendChild(select_level_write);
			
			ul.appendChild(li);
			
			$("#"+input.id).autocomplete("includes/ajax/autocomplete.php?action=language", {
				width: 200,
				selectFirst: false
			});														
			$("#"+input.id).result(function(event, data, formatted) {
				document.getElementById(input.id).setAttribute("attrCode", data[1]);
			});			
			
			input.focus();
			
			if( countinput==(limit-1) ) elButton.parentNode.removeChild(elButton);
		}
		
		return false;
	}

	this.close_win_loading = function(){
		Progress.hidden();
	}
	this.show_win_loading = function(html){
		Progress.show(html);
	}
	
	this.show_other_field = function(value, id){
		if( value=="+" ) This.ShowHidden_panel('show', id, 'document.getElementById(\''+id+'\').getElementsByTagName(\'input\')[0].focus();');
		else This.ShowHidden_panel('hidden', id);
	}
	
	this.verify_data = function(input){
		if( input.getAttribute("attrTable")==null ) return;
		
		if( input.value!="" ){
			var Ajax = new ClassAjax();
				Ajax.on_finalizer = function(){
					if( isNaN(parseInt(this.responseHTML)) ){
						switch(input.getAttribute("attrTable")){
							case "list_companies_items": var msg = "El rubro ingresado no existe."; break;
							case "list_country": var msg = "El pa&iacute;s ingresado no existe."; break;
							case "list_provinces": var msg = "La provincia ingresada no existe."; break;
							case "list_sports": var msg = "El deporte ingresado no existe."; break;
							case "list_languages": var msg = "El idioma ingresado no existe."; break;
						}
						
						Validator.message.show(input, [msg]);
						input.setAttribute("attrCode", "0");
												
					}else{
						input.setAttribute("attrCode", this.responseHTML);
						Validator.message.hidden(input);
					}				
				}
				Ajax.execute("POST", "includes/ajax/autocomplete.php?action=verify_data", 
									 "table="+ input.getAttribute("attrTable") +"&"+
									 "value="+ input.value);
		}else{
			input.setAttribute("attrCode", "0");
			Validator.message.hidden(input);
		}
	}

	
	this.add_items = function(){
		var Select = document.getElementById("cboListSports");
		var Select2 = document.getElementById("cboListSports_new");
		
		for( var i=0; i<=Select.options.length-1; i++ ){
			if( Select.options[i].selected ){
				if( !exists_items(Select.options[i].value) ){
					Select2.options[Select2.options.length] = new Option(Select.options[i].text, Select.options[i].value);
				}
			}
		}
	}

	this.remove_items = function(){
		var Select = document.getElementById("cboListSports");
		var Select2 = document.getElementById("cboListSports_new");
		
		for( var i=Select2.options.length-1; i>=0; i-- ){
			if( Select2.options[i].selected ){
				Select2.options[i] = null;
			}
		}		
	}





	
	
	
	
	
	//________________________________ PROPERTIES PRIVATE ________________________________
	var working=false;
	var This=this;
	var Validator=false;
	var Elements = {};
	var Params = {};

	//________________________________ METHODS PRIVATE ________________________________
	var Progress={
		mask: false,
		win: false,
		message: false,
		Content: false,
		
		show: function(html){
			working=true;
			
			if( !this.mask ){
				this.mask = document.createElement("DIV");
				this.mask.style.cssText = "position: fixed;"+
										  "left: 0px;"+
										  "top: 0px;"+
										  "width: 100%;"+
										  "height: 100%;"+
										  "background-color: #cccccc;"+
										  "z-index: 2000;";
				setOpacity(this.mask, 4);
				this.win = document.createElement("DIV");
				this.win.className = "window_loading";
					var bTop = document.createElement("DIV");
						bTop.className = "top";
					this.Content = document.createElement("DIV");
					this.Content.className = "content";
						var bLeft = document.createElement("DIV");
							bLeft.className = "bLeft";
						var bRight = document.createElement("DIV");
							bRight.className = "bRight";
						this.message = document.createElement("DIV");
						this.message.innerHTML = html ? html : "";
						this.message.className = "message";
						this.Content.appendChild(bLeft);
						this.Content.appendChild(this.message);
						this.Content.appendChild(bRight);						
					var bBottom = document.createElement("DIV");
						bBottom.className = "bottom";
						
				this.win.appendChild(bTop);											
				this.win.appendChild(this.Content);
				this.win.appendChild(bBottom);
												
				document.body.appendChild(this.mask);
				document.body.appendChild(this.win);			
			}
			
			this.message.innerHTML = html ? html : "";			
			this.Content.style.height = this.message.offsetHeight+"px";
			this.win.style.marginTop = "-"+(parseInt(this.win.offsetHeight/2))+"px";
			
		},
		hidden: function(){
			working=false;
			document.body.removeChild(this.mask);
			document.body.removeChild(this.win);
			this.mask=false;
			this.win=false;
		}
	}
	
	var Progress2={
		show: function(el){
			working=true;			
			var p = getElementsByClassName("progress", "div", el.parentNode);
			if( p.length>0 ) p[0].style.display = "block";
		},
		hidden: function(el){
			working=false;
			var p = getElementsByClassName("progress", "div", el.parentNode);
			if( p.length>0 ) p[0].style.display = "none";			
		}		
	}

	var Progress3={
		show: function(){
			working=true;	
			document.getElementById("progress").style.display = "block";
		},
		hidden: function(){
			working=false;
			document.getElementById("progress").style.display = "none";
		}		
	}

	var disabled_files = function(value){
		var inputs = getElementsByClassName("inputbox", "input", document.getElementById("list_files"));
		for( var i=0; i<=inputs.length-1; i++ ){
			inputs[i].disabled = value;
		}
	}

	var exists_items = function(item_name){
		var Select = document.getElementById("cboListSports_new");
		for( var i=0; i<=Select.length-1; i++ ){
			if( Select.options[i].value==item_name ) return true;
		}
		return false;
	}

	var clear_field = function(id){
		document.formRegistry[id].value = "";
	}
	var set_field = function(id){
		document.formRegistry[id].value = "";
		document.formRegistry[id].focus();
	}

}
var Registry = new ClassRegistry();