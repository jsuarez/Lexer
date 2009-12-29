// JavaScript Document

var ClassProfileSport = function(){

	//________________________________ PROPERTIES PUBLIC ________________________________
	
	
	//________________________________ METHODS PUBLIC ________________________________
	this.execute_validate = function(){
		var Validator_messages = new Class_Validator({
						selectors:	'.validator',
						messagePos: 'right',
						messageClass: 'formError_Right',
						validationOne: true			
		});
	}
	
	this.add_items = function(id1, id2){
		var Select = document.getElementById(id1);
		var Select2 = document.getElementById(id2);
		
		for( var i=0; i<=Select.options.length-1; i++ ){
			if( Select.options[i].selected ){
				if( !exists_items(Select.options[i].value, Select2) ){
					Select2.options[Select2.options.length] = new Option(Select.options[i].text, Select.options[i].value);
				}
			}
		}		
	}

	this.remove_items = function(id1, id2){
		var Select = document.getElementById(id1);
		var Select2 = document.getElementById(id2);
		
		for( var i=Select2.options.length-1; i>=0; i-- ){
			if( Select2.options[i].selected ){
				Select2.options[i] = null;
			}
		}		
	}
	
	this.lesion_item_save = function(){
		if( document.getElementById("cboListLesions").style.display!="none" ){
			if( document.getElementById("cboListLesions").value==0 ){
				Validator.show_message({
					message: 'Seleccione una opci&oacute;n.',
					element: document.getElementById("divContErr1")
				});
				document.getElementById("cboListLesions").focus();
				return;			
			}
		}else{
			Validator.show_message({
				message: 'Ingrese un nombre de una lesi&oacute;n.',
				element: document.getElementById("divContErr1")
			});
			document.getElementById("txtLesionName").focus();
			return;			
		}
		Validator.hidden_message(document.getElementById("divContErr1"), true);
		
		if( document.getElementById("txt_lesion_YearFrom").value.length==0 ){
			Validator.show_message({
				message: 'El A&ntilde;o Desde es obligatorio.',
				element: document.getElementById("divContErr2")
			});
			document.getElementById("txt_lesion_YearFrom").focus();
			return;
		}
		if( document.getElementById("txt_lesion_YearTo").value.length>0 ){
			if( document.getElementById("txt_lesion_YearFrom").value > document.getElementById("txt_lesion_YearTo").value ){
				Validator.show_message({
					message: 'El A&ntilde;o Desde debe ser menor o igual al A&ntilde;o Hasta.',
					element: document.getElementById("divContErr2")
				});
				document.getElementById("txt_lesion_YearTo").focus();
				return;				
			}
		}	
		Validator.hidden_message(document.getElementById("divContErr2"), true);		
		
		if( document.getElementById("cboRecuperation").value==0 ){
			Validator.show_message({
				message: 'Seleccione una opci&oacute;n.',
				element: document.getElementById("divContErr3")
			});
			document.getElementById("cboRecuperation").focus();
			return;			
		}
		Validator.hidden_message(document.getElementById("divContErr3"), true);
		
		
		
		var txtLesion = document.getElementById("cboListLesions").options[document.getElementById("cboListLesions").selectedIndex].text;
		var valueLesion = document.getElementById("cboListLesions").value;
		
		if( !edit_lesion ){
			var condition = exists_items(valueLesion, document.getElementById("cboLesionsSelected"));
			var option = document.createElement("OPTION");
			
		}else{
			var condition = exists_items2(valueLesion, document.getElementById("cboLesionsSelected").value, document.getElementById("cboLesionsSelected"));
			
			var option = document.getElementById("cboLesionsSelected").options[document.getElementById("cboLesionsSelected").selectedIndex];			
			
		}
		
		if( !condition ){
			option.value = valueLesion;
			option.text = txtLesion;
			option.setAttribute("attrRangeYearFrom", document.getElementById("txt_lesion_YearFrom").value);
			option.setAttribute("attrRangeYearTo", document.getElementById("txt_lesion_YearTo").value);				
			option.setAttribute("attrIndexSelect", document.getElementById("cboListLesions").selectedIndex);				
			option.setAttribute("attrIndexSelect2", document.getElementById("cboRecuperation").selectedIndex);				
			document.getElementById("cboLesionsSelected").appendChild(option);
												
			This.lesion_item_clear();
		}else{
			alert('La lesión "'+txtLesion+'" ya existe.');
		}
	}
	
	this.lesion_item_clear = function(){
		document.getElementById("cboListLesions").selectedIndex = 0;
		document.getElementById("txt_lesion_YearFrom").value = "";
		document.getElementById("txt_lesion_YearTo").value = "";
		document.getElementById("cboRecuperation").selectedIndex = 0;		
		document.getElementById("btnLesionAdd").value = "Agregar";
		
		for( var i=0; i<=document.getElementById("cboLesionsSelected").options.length-1; i++ ){
			document.getElementById("cboLesionsSelected").options[i].selected = false;
		}
		
		edit_lesion = false;
	}
	this.lesion_item_delete = function(){
		for( var i=document.getElementById("cboLesionsSelected").options.length-1; i>=0; i-- ){
			if( document.getElementById("cboLesionsSelected").options[i].selected ){
				document.getElementById("cboLesionsSelected").removeChild(document.getElementById("cboLesionsSelected").options[i]);
			}
		}
		
		This.lesion_item_clear();
	}
	this.lesion_item_show = function(el){
		edit_lesion = true;
		
		var option = el.options[el.selectedIndex];
		
		document.getElementById("cboListLesions").selectedIndex = option.getAttribute("attrIndexSelect");
		document.getElementById("txt_lesion_YearFrom").value = option.getAttribute("attrRangeYearFrom");
		document.getElementById("txt_lesion_YearTo").value = option.getAttribute("attrRangeYearTo");
		document.getElementById("cboRecuperation").selectedIndex = option.getAttribute("attrIndexSelect2");
		document.getElementById("btnLesionAdd").value = "Modificar";
	}
	
	
	this.lesion_new = function(edit){
		document.getElementById("cboListLesions").style.cssText = "display:none !important;";
		document.getElementById("cont_lesion_textarea").style.cssText = "display:block !important;";

		document.getElementById("container_icons1").style.cssText = "display:none !important;";
		document.getElementById("container_icons2").style.cssText = "display:block !important;";
		
		document.getElementById("txtLesionName").setAttribute("attrEdit", !edit ? "0" : "1");
		document.getElementById("txtLesionName").focus();
	}
	this.lesion_cancel = function(){
		document.getElementById("cboListLesions").style.cssText = "display:block !important;";
		document.getElementById("cont_lesion_textarea").style.cssText = "display:none !important;";

		document.getElementById("container_icons1").style.cssText = "display:block !important;";
		document.getElementById("container_icons2").style.cssText = "display:none !important;";
		document.getElementById("txtLesionName").value = "";
		Validator.hidden_message(document.getElementById("divContErr1"), true);
	}
	this.lesion_key = function(e){
		var e = window.event || e;
		var code = e.keyCode || e.which;
		if( code==27 ) This.lesion_cancel();
		else if( code==13 ) This.lesion_save();
	}
	this.lesion_edit = function(){
		var Select = document.getElementById("cboListLesions");
		
		if( Select.value==0 ){
			alert("Seleccione una opcion.");
			Select.focus();
			return;
		}
		This.lesion_new(1);
	}	
	this.lesion_save = function(){
		if( working ) return;
		
		var Select = document.getElementById("cboListLesions");
		var input = document.getElementById("txtLesionName");
		
		if( input.value.length==0 ){
			alert("Ingrese el nombre de la lesion");
			input.focus();
			return;
		}
		
		var action = input.getAttribute("attrEdit")==null||input.getAttribute("attrEdit")=="0" ? "lesion_new" : "lesion_edit";
		
		working=true;
		var Ajax = new ClassAjax();
			Ajax.on_finalizer = function(){
				if( this.responseHTML=="exists" ){
					alert('La lesion "'+input.value+'" ya existe.');
					
				}else if( this.responseHTML=="ok" ){
					document.getElementById("cboListLesions").options[Select.selectedIndex].text = input.value;
					
				}else if( !isNaN(parseInt(this.responseHTML)) ){
					var option = document.createElement("OPTION");
						option.value = this.responseHTML;
						option.text = input.value;
					Select.appendChild(option);
					Select.selectedIndex = Select.options.length-1;
				}else{
					alert(this.responseHTML);
				}
				
				This.lesion_cancel();
				working=false;
			}
			Ajax.execute("POST", "includes/ajax/profile_sport.php?action="+action,
						 "name="+ input.value +"&"+
						 "codlesion="+ Select.value);
		
	}
	this.lesion_delete = function(){
		if( working ) return;
		var Select = document.getElementById("cboListLesions");
		
		if( Select.value==0 ){
			alert("Seleccione una opcion.");
			Select.focus();
			return;
		}
		
		if( confirm("¿Esta seguro que desea eliminar el item seleccionado?") ){		
			working=true;
			var Ajax = new ClassAjax();
				Ajax.on_finalizer = function(){
					if( this.responseHTML=="ok" ){
						Select.removeChild(Select.options[Select.selectedIndex]);
					}else{
						alert(this.responseHTML);
					}
					
					working=false;
				}
				Ajax.execute("POST", "includes/ajax/profile_sport.php?action=lesion_delete", "codlesion="+ Select.value);
		}
	}
	
	this.change_sport = function(el){
		if (working)return;
		
		var action = "sport_pass";
		var codsport = el.options[el.selectedIndex].value;	
		working=true;
		
 	$('#container_sport').hide().load('includes/ajax/profile_sport.php?action='+action+'&codsport='+codsport+"&cache="+Math.random(), function() {																								    working=false;
  			$(this).fadeIn();
			ProfileSport.execute_validate();
		});
		
		//Para boxeo
		if( el.value =="16" ){
			document.getElementById("optionLevel").style.cssText = "display:block !important;";
		}else{
			document.getElementById("optionLevel").style.cssText = "display:none !important;";
		}
		
		
	}
		
	this.change_pass= function(el){
		document.getElementById('Pass_description').innerHTML=el.options[el.selectedIndex].text;
		document.formRegistry.txtPass_description.value="";
		$('#passDescription').fadeIn("slow");	
		//alert($('#passDescription').length);
	}
	this.change_ability= function(el){
		if(el.value == "4" ){
		Registry.ShowHidden_panel('show', 'recursos');
		}else{
		Registry.ShowHidden_panel('hidden', 'recursos');
		}
	}
		
	this.change_affiction = function(value){
		if( value==1 ){ 
			Registry.ShowHidden_panel('show', 'divContTag1', 'document.formRegistry.txtAffiction_new.focus();') 
		}else{ 
			Registry.ShowHidden_panel('hidden', 'divContTag1'); 
		}		
	}
	
	
	this.save = function(action){
		var country_sel="";
		for(var i=0; i<=document.getElementById("cboListCountry_sel").options.length-1; i++){
			country_sel +=document.getElementById("cboListCountry_sel").options[i].value + ",";
		}
		$.ajax({
			type: "POST",
			url: "includes/ajax/profile_sport.php?action="+action,
			data: $("#form_registry").serialize()+"&country_sel="+country_sel.substr(0,country_sel.length-1),
			success: function(data){
				alert(data);
				if( data=="newprofilesport_ok"){
					alert("Los datos deportivos se han guardado efectivamente!!!");	
				}else if( data=="updprofilesport_ok"){
					alert("Los datos deportivos se han modificado efectivamente!!!");
				}
				
			}
		});
			
	}


	this.ShowLesion = function (value, id, p){
	
		if( value!=0 ){
			$("#row_les_1,#row_les_2,#row_les_3").fadeIn("slow");
	
		}else {
			$("#row_les_1,#row_les_2,#row_les_3").fadeOut("slow",function (){
        		This.lesion_item_clear();
      			});
		
		}
	}


	//________________________________ PROPERTIES PRIVATE ________________________________
	var working = false;
	var This = this;
	var edit_lesion = false;
	var Validator = false;
	

	//________________________________ METHODS PRIVATE ________________________________
	var Progress={
		show: function(){
			working=true;			
			document.getElementById("progress").style.display = "block";
		},
		hidden: function(){
			working=false;
			document.getElementById("progress").style.display = "none";
		}		
	}
	
	var exists_items = function(item_value, Select){
		for( var i=0; i<=Select.length-1; i++ ){
			if( Select.options[i].value==item_value ) return true;
		}
		return false;
	}
	var exists_items2 = function(item_value, item_value2, Select){
		for( var i=0; i<=Select.length-1; i++ ){
			if( Select.options[i].value==item_value && item_value2!=Select.options[i].value ) return true;
		}
		return false;
	}


}
var ProfileSport = new ClassProfileSport();