var ClassSlideGallery = function(options){

   /**************************************************************************
    *                               CONSTRUCTOR
    **************************************************************************/
    var DEFAULTS={
        selector_preview    :   '',	// [STRING]
        selector_conthumbs  :   '',	// [STRING]
        prefix              :   'jsg'	// [STRING]
    };
    options = $.extend({}, DEFAULTS, {}, options);
    
    $(document).ready(function(){
        container_thumbs = $(options.selector_conthumbs);
        container_preview = $(options.selector_preview).find("a");

        if( container_thumbs.length>0 && container_preview.length>0 ){
            Thumbs.el = container_thumbs.find("a");
            Thumbs.count = Thumbs.el.length;
            Thumbs.container = $(container_thumbs).find("ul");
            Thumbs.first = $(Thumbs.el[0]);
            Thumbs.last = $(Thumbs.el[Thumbs.count-1]);
            Thumbs.width = (Thumbs.el[0].offsetWidth+8);
            Thumbs.el.each(function(){
                $(this).bind("click", show_preview);
            });

            divLoading = container_preview.append('<div class="ajax-picture-loader"></div>').find(":last");
            
            container_preview.bind("click", zoom)

            divContZoom = document.createElement("DIV");
            $(divContZoom).addClass(options.prefix+"-previewzoom");
            var a = document.createElement("A");
                a.href = "#";
                a.innerHTML = "Cerrar ()";
                $(a).bind("click", closeZoom);

            $(divContZoom).append(a);
            $(document.body).append(divContZoom);

            if( Thumbs.count==0 || Thumbs.container.length==0 ) error=true;
        }else error=true;
    });
    

   /**************************************************************************
    *                            PUBLIC METHODS
    **************************************************************************/
    this.back = function(e){
        e.preventDefault();
        if( working||error ) return false;

        if( Thumbs.first.position().left < 0 ){
            working=true;
            Thumbs.container.animate({
                marginLeft : '+='+Thumbs.width
            }, 800, function(){working=false;});
        }

        return false;
    };

    this.next = function(e){
        e.preventDefault();
        if( working||error ) return false;

        if( Thumbs.last.position().left > container_thumbs.width() ){
            working=true;
            Thumbs.container.animate({
                marginLeft : '-='+Thumbs.width
            }, 800, function(){working=false;});
        }

        return false;
    };


   /**************************************************************************
    *                            PRIVATE PROPERTIES
    **************************************************************************/
    var working = false;
    var error = false;
    var Thumbs = {};
    var container_thumbs = false;
    var container_preview = false;
    var divContZoom = false;
    var divLoading = false;

   /**************************************************************************
    *                            PRIVATE METHODS
    **************************************************************************/
    var show_preview = function(e){
        e.preventDefault();
        container_preview.attr("href", $(this).attr("href"));

        divLoading.css("display", "block");
        container_preview.find("img").attr("src", $(this).find("img").attr("src")).each(function(){
            divLoading.css("display", "none");
        });
    };

    var zoom = function(e){
        e.preventDefault();
        if( working||error ) return false;
        working=true;

        var imgData = getDataPreview();

        var img = new Image();
            img.src = this.href;

        $(img).each(function(){
            $(divContZoom).append(this)
                          .css("display", "block");

            var divWidth  = divContZoom.offsetWidth;
            var divHeight = divContZoom.offsetHeight;
            var divLeft = ($(window).width()/2) - (divWidth/2);
            var divTop  = ($(window).height()/2) - (divHeight/2);

            $(divContZoom).css({
                              left      : imgData.left+"px",
                              top       : imgData.top+"px",
                              width     : imgData.width+"px",
                              height    : imgData.height+"px"
                           });

            $(divContZoom).animate({
                              left    : divLeft,
                              top     : divTop,
                              width   : divWidth,
                              height  : divHeight,
                              opacity : 1
                          }, 800, function(){working=false;});

        });
        
        return false;
    };

    var closeZoom = function(e){
        e.preventDefault();

        var imgData = getDataPreview();

        $(divContZoom).animate({
                          left    : imgData.left,
                          top     : imgData.top,
                          width   : imgData.width,
                          height  : imgData.height,
                          opacity : 0
                      }, 400, function(){
                          $(this).css({
                              display : "none",
                              width   : null,
                              height  : null
                          })
                          $(this).find("img").remove();
                      });
    };

    var getDataPreview = function(){
        return {
            left   : container_preview.offset().left - $(window).scrollLeft(),
            top    : container_preview.offset().top - $(window).scrollTop(),
            width  : container_preview[0].offsetWidth,
            height : container_preview[0].offsetHeight
        };
    };
};