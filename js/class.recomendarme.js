// JavaScript Document

var ClassRecomendarme = function(){

	//________________________________ PROPERTIES PUBLIC ________________________________
	

	//________________________________ METHODS PUBLIC ________________________________
	this.mail = function(filename){
		if( working ) return;
		Progress.show();
		
		setHtml(function(){
			if ((filename !='sport_otrapersona.php')&&(filename !='sport_otrapersona.php?action=send')&& (filename !='repr_otrapersona.php') && (filename != 'repr_otrapersona.php?action=send') && (filename !='club_otrapersona.php')&& (filename !='club_otrapersona.php?action=send') && (filename !='sponsor_otrapersona.php') &&(filename !='sponsor_otrapersona.php?action=send')){
				var email_to = $('#cbo_to').val();
			}else{
				var email_to = $('#txt_contacto_mail').val();
			}
			var html = $("#basic-modal-content").html();
			
			$.ajax({
				type: "POST",
				url: "includes/ajax/recomendarme/"+filename,
				data: 'email_to='+email_to+'&html='+html,
				success: function(data, textStatus){
					alert(data);
					if (data == "sendmail_ok"){
						alert("Su recomendacion a sido enviada con exito");
					}else if (data == "sendmail_error"){
						alert("Su recomendacion no a sido enviada con exito");
					}			
				},
				complete: function(){
					Progress.hidden();
				}
			});
			
		});
	}

	this.mail_preview = function (){
		setHtml();
		$('#basic-modal-content').modal();
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
	
	var setHtml= function (callback){
		var el= new Array ();
		$("#mail_recomendacion select, #mail_recomendacion input:text").each(function(){ 
		  el.push ($(this).val());
		 });
	
		$('#basic-modal-content').append($('#mail_recomendacion')[0].innerHTML);
		$("#basic-modal-content select, #basic-modal-content input:text").each(function(i){
		  $(this).replaceWith(el[i]);
		});
	 	callback();
	}
	

}
var Recomendarme = new ClassRecomendarme();