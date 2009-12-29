// JavaScript Document

var ClassSearch = function(){
	//------------------------- PUBLIC PROPERTIES -----------------------------//	
	
	
	//------------------------- PUBLIC METHODS ------------------------------//
	this.search = function(){
		document.form_search.hidden_form_search.value = $("#form_search").serialize();
		
		document.form_search.submit();
	}
	
	this.close_progress = function(){
		Progress.hidden();
	}
	
	this.slider_search_advanced = function (j){
		
                $("#cboSport")[0].disabled=false;
		switch(document.form_search.cboCategory.value){
			case "1": /*height = "310px";*/ height = "200px";  usertype="deportista"; break;	//DEPORTISTA
			case "2": height = "100px";  usertype="representante"; break;	//REPRESENTANTE		
			case "3": height = "50px";   usertype="club"; break;	//CLUB
			case "4": //SPONSOR
                            height = "50px";
                            usertype="sponsor";
                            $("#cboSport")[0].disabled=true;
                        break;
		}
		var div = $("#advanced_search .fields_advanced_search");
		
		if( !j ){
			if( parseInt(div.css("height"))!=0 ) height=0;
		}
		
		div.load("includes/ajax/search.php", {action: 'show_fields_advancedsearch', usertype: usertype})
		   .stop()
		   .animate({ height : height}, 800);
	}
	
	this.change_sport = function(value){
		
	}
	

	//------------------------- PRIVATE PROPERTIES -----------------------------//	
	var This = this;
	var working = false;
	

	//------------------------- PRIVATE METHODS ------------------------------//
	var Progress={
		divBack: false,
		divWindow: false,
		message: false,
		
		show: function(){
			working = true;
			this.divBack = document.createElement("DIV");
			this.divBack.style.position = "fixed";
			this.divBack.style.left = "0px";
			this.divBack.style.top = "0px";
			this.divBack.style.width = "100%";
			this.divBack.style.height = "100%";
			this.divBack.style.background = "#ffffff";
			this.divBack.style.zIndex = 1000;
			setOpacity(this.divBack, 2);
				
			this.divWindow = document.createElement("DIV");
			this.divWindow.className = "window_loader";
			//setOpacity(this.divWindow, 0);
				this.message = document.createElement("SPAN");
				this.message.innerHTML = "Aguarde, por favor....";
			this.divWindow.appendChild(this.message);	
				
			document.body.appendChild(this.divBack);
			document.body.appendChild(this.divWindow);
						
		},
		hidden: function(){
			document.body.removeChild(Progress.divBack);
			document.body.removeChild(Progress.divWindow);
			working = false;
			
		}
	}
	
	var Progress2={
		show: function(el){
			working=true;			
			var p = getElementsByClassName("loading", "div", el.parentNode);
			if( p.length>0 ) p[0].style.display = "block";
		},
		hidden: function(el){
			working=false;
			var p = getElementsByClassName("loading", "div", el.parentNode);
			if( p.length>0 ) p[0].style.display = "none";			
		}		
	}

}
var Search = new ClassSearch();