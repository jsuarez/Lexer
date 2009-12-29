// JavaScript Document

var ClassTest = function(){

	//________________________________ PROPERTIES PUBLIC ________________________________
	

	//________________________________ METHODS PUBLIC ________________________________
	this.InsertRow= function(){
		var tabla = document.getElementById('table');
		var indice= tabla.rows.length;
		var row = tabla.insertRow(indice);
		
		var countcells= tabla.rows[0].cells.length;
	
		for(var i=0; i <= countcells-1; i++){
			var col = row.insertCell(i);
			if (i==0){
				// Caso para la fecha
				col.innerHTML='<input class="datepicker" name="datepicker" type="text">';
				$(".datepicker").datepicker({dateFormat: 'dd/mm/yy'});		
			}else if (i== countcells-1){
				//Ultimo celda
				col.innerHTML='&nbsp;';
			}else{
				col.innerHTML='<input name="" type="text">';
			}				
		}	
	}

	
	
	this.InsertCell= function(el){
		var tabla = document.getElementById('table');
		
		if (el.options[el.selectedIndex].value != 0){
			var col = tabla.rows[0].insertCell(tabla.rows[0].cells.length-1);
			var countcells= tabla.rows[0].cells.length;
			col.innerHTML= el.options[el.selectedIndex].text;
			
			//Si existe mas de una fila
			var countrow = tabla.rows.length;
			if (countrow!=1){
				for (var i=1; i<=countrow-1;i++ ){
					
						var col= tabla.rows[i].insertCell(countcells-2);
						col.innerHTML='<input name="" type="text">';				
						
				}
			}
		}
		
	}
	
	this.change_capacity = function(el){
		if (working)return;
		var codcapacity = el.options[el.selectedIndex].value;	
		working=true;
		Progress2.show(el);
		el.disabled = true;
		
 		$('#conteiner_table').hide().load('includes/ajax/test.php?action=test&codcapacity='+codcapacity+"&cache="+Math.random(), function() {																								working=false;
  			$(this).fadeIn();
  			el.disabled = false;
  			Progress2.hidden(el);
  			
		});
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

}
var Test = new ClassTest();