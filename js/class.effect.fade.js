// JavaScript Document

var ClassEffectFade = function(){

	//________________________________ PROPERTIES PUBLIC ________________________________
	

	//________________________________ METHODS PUBLIC ________________________________
	this.show = function(el, html, func){
		if( !el || working ) return;		
		working = true;
	
		if( el.innerHTML=="" ){
			setOpacity(el, 0);
			el.innerHTML = html;
			
			var Anim = new Class_Animate();
				Anim.Opacity({
					element: el,
					from: 0,
					to: 10,
					duration: 800,
					increment: 1,
					callback: function(){
						working=false;
						document.getElementById("cboRegCategory").disabled = false;
						func();
					}
				});
		}else{
			var Anim = new Class_Animate();
				Anim.Opacity({
					element: el,
					from: 10,
					to: 0,
					duration: 800,
					increment: 1,
					callback: function(){
						el.innerHTML = html;
						
						var Anim = new Class_Animate();
							Anim.Opacity({
								element: el,
								from: 0,
								to: 10,
								duration: 800,
								increment: 1,
								callback: function(){
									working=false;
									document.getElementById("cboRegCategory").disabled = false;
									func();
								}
							});						
					}
				});			
			
		}
		
			

	}
	this.hidden = function(){
		
	}


	//________________________________ PROPERTIES PRIVATE ________________________________
	var working = false;
	var This = this;
	

	//________________________________ METHODS PRIVATE ________________________________


}
var fxFade = new ClassEffectFade();