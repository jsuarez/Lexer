// JavaScript Document

var ClassMultimedia = function(){

	//________________________________ PROPERTIES PUBLIC ________________________________
	

	//________________________________ METHODS PUBLIC ________________________________
	this.upload = function(){
		if( working ) return;
		var inputFile = document.formRegistry["file_input_name[]"];
		
		var j=0;
		if( inputFile.length>0 ){
			for( var i=0; i<=inputFile.length-1; i++ ){
				if( inputFile[i].value.length>0 ) j=1;
			}
		}else {
			if( inputFile.value.length>0 ) j=1;
		}
		if( j==0 ){
			alert("Debe subir al menos un archivo.");
			return;
		}
		
		Progress.show();
		document.formRegistry.submit();
	}
	
	this.image_delete = function(codimage, filename, table){
		if( working ) return;
		
		if( confirm('¿Está seguro de eliminar la imagen "'+filename+'"?') ){
			Progress.show();
			var Ajax = new ClassAjax();
				Ajax.on_finalizer = function(){
					if( this.responseHTML=="ok" ){
						parent.document.getElementById("cboGallery").onchange();
					}else{
						//alert(this.responseHTML);
						alert("Ha ocurrido un error en el servidor. \nSi el error continua por favor, comun&iacute;quelo al administrador web.");
					}
					Progress.hidden();
				}
				Ajax.execute("POST", "includes/ajax/media.php?action=delete", 
							 		 "table="+ table +"&"+
							 		 "codimage="+ codimage +"&"+
									 "filename="+ filename);
			
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
				input.setAttribute("type", "file");
				input.size = "33";
				input.name = inputs[0].name;
			li.appendChild(input);
						
			ul.appendChild(li);
			input.focus();
			
			if( inputs.length==limit ) elButton.parentNode.removeChild(elButton);
		}
		
		return false;
	}
	
	this.sel_image = function(codimage, d){
		if( working ) return;
		
		var action = d==1 ? "deselected" : "selected";
		
		Progress.show();
		var Ajax = new ClassAjax();
			Ajax.on_finalizer = function(){
				if( this.responseHTML=="ok" ){
					parent.document.getElementById("cboGallery").onchange();
				}else{
					//alert(this.responseHTML);
					alert("Ha ocurrido un error en el servidor. \nSi el error continua por favor, comun&iacute;quelo al administrador web.");
				}
				Progress.hidden();
			}
			Ajax.execute("POST", "includes/ajax/media.php?action="+action, 
								 "codimage="+ codimage);
		
	}
	
	this.success_photos = function(){
		Progress.hidden();
		document.getElementById("cboGallery").onchange();
	}
	
	this.success_movies = function(){
 		$('#movies_list').hide().load('includes/ajax/media.php?action=movies_list'+"&cache="+Math.random(), function() {								
  				$(this).fadeIn();
  				
				var examinar = $('#list1 li');
				
				if (examinar.length > 1){
					for(var i=0; i<=examinar.length-2; i++ ){
						examinar[i].parentNode.removeChild(examinar[i]);
					}
				}
				$('#list1 li input').val("");
		});
		Progress.hidden();
	}
	
	this.delete_movie=function(codmovie, filename){
		if (confirm("Esta seguro de que desea eliminar el video: "+filename)){
		$.ajax({
   			type: "POST",
		   	url: "includes/ajax/media.php?action=movies_delete",
		   	data: "codmovie="+codmovie,
		   	success: function(data){
		     if(data=="ok"){
		     	This.success_movies();
			}else{
				alert("A ocurrido el siguiente error: "+data);
			}
			 
		   }
		 });
		 }

	}

	//________________________________ PROPERTIES PRIVATE ________________________________
	var working = false;
	var This = this;
	

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
	


}
var Media = new ClassMultimedia();