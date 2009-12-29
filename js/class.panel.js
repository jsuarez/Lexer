// JavaScript Document

var ClassPanel = function(){

	//________________________________ PROPERTIES PUBLIC ________________________________
	

	//________________________________ METHODS PUBLIC ________________________________
	this.show_section = function(pagename){
		if( working ) return;
		
		Progress.show();
		
		
		var Ajax = new ClassAjax();
			Ajax.on_finalizer = function(){
				document.getElementById("form_registry").innerHTML = this.responseHTML;
				
				if( pagename=="profile_sport.php" ){
					Progress.hidden();
					ProfileSport.execute_validate();
					//--------- Autocomplete para "Representantes" --------------------
					$("#txt_rep").autocomplete("includes/ajax/autocomplete.php?action=representatives", {
							width: 200,
							selectFirst: false
					});
					
					ProfileSport.change_sport(this);
						
				}if( pagename=="movies.php" ){
					Media.success_movies();
				}else if( pagename.indexOf("photos.php")>-1 ){
					// We only want these styles applied when javascript is enabled
					$('div.navigation').css({'width' : '300px', 'float' : 'left'});
					$('div.content').css('display', 'block');
		
					// Initially set opacity on thumbs and add
					// additional styling for hover effect on thumbs
					var onMouseOutOpacity = 0.67;
					$('#thumbs ul.thumbs li').css('opacity', onMouseOutOpacity)
						.hover(
							function () {
								$(this).not('.selected').fadeTo('fast', 1.0);
							}, 
							function () {
								$(this).not('.selected').fadeTo('fast', onMouseOutOpacity);
							}
						 );
						// Initialize Advanced Galleriffic Gallery
						var galleryAdv = $('#gallery').galleriffic('#thumbs', {
							delay:                  2000,
							numThumbs:              12,
							preloadAhead:           10,
							enableTopPager:         false,
							enableBottomPager:      true,
							imageContainerSel:      '#slideshow',
							controlsContainerSel:   '#controls',
							captionContainerSel:    '#caption',
							loadingContainerSel:    '#loading',
							renderSSControls:       false,
							renderNavControls:      true,
							playLinkText:           'Play Slideshow',
							pauseLinkText:          'Pause Slideshow',
							prevLinkText:           '&lsaquo; Foto Anterior',
							nextLinkText:           'Siguiente Foto &rsaquo;',
							nextPageLinkText:       'Siguiente &rsaquo;',
							prevPageLinkText:       '&lsaquo; Anterior',
							enableHistory:          true,
							autoStart:              false,
							onChange:               function(prevIndex, nextIndex) {
								$('#thumbs ul.thumbs').children()
									.eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
									.eq(nextIndex).fadeTo('fast', 1.0);
							},
							onTransitionOut:        function(callback) {
								$('#caption').fadeTo('fast', 0.0);
								$('#slideshow').fadeTo('fast', 0.0, callback);
							},
							onTransitionIn:         function() {
								$('#slideshow').fadeTo('fast', 1.0);
								$('#caption').fadeTo('fast', 1.0);
							},
							onPageTransitionOut:    function(callback) {
								$('#thumbs ul.thumbs').fadeTo('fast', 0.0, callback);
							},
							onPageTransitionIn:     function() {
								$('#thumbs ul.thumbs').fadeTo('fast', 1.0);
							}
						});
				}
				Progress.hidden();
			}
			Ajax.execute("POST", "includes/sections_panel/"+pagename);		
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
var Panel = new ClassPanel();