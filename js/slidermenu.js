// Desliza los menus

function slider_menu_ajax(filename, id, to, height){
	var el = document.getElementById(id);	

	var effect = "quartOut";
	
	var Ajax = new ClassAjax();
		Ajax.on_finalizer = function(){
			
			el.style.height = height+"px";
			el.innerHTML = this.responseHTML;

			var Anim = new Class_Animate();
			Anim.animate({
				element: el,
				style: 'height',
				to: to,
				duration: 900,
				effect: effect
			});
			
		}
		Ajax.execute("POST", filename);
		
}



