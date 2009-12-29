/*
 * jQuery JavaScript Library v1.3
 * http://jquery.com/
 *
 * Copyright (c) 2009 Ivan Mattoni
 * Empresa MyDesign
 * Dual licensed under the MIT and GPL licenses.
 * http://docs.jquery.com/License
 *
 */
 
var Class_Browsing = function(options){
   /**************************************************************************
    *                               CONSTRUCTOR
    **************************************************************************/
    var DEFAULTS={
            container		:	'',	  // [STRING]
            basename		:	'/',      // [STRING]
            include_result	:	'',	  // [STRING]
            orderby 		: 	'',	  // [STRING]
            count_entries	:	10,	  // [INTEGER]
            callback		:	Function(),               // [FUNCTION]
            id_hidden           :       'browsing_count_entries', // [STRING]
            formdata		:	''	// [STRING] [MAP]
    };
    var container=false;

    options = $.extend({}, DEFAULTS, {}, options);
    if( options.include_result=="" ) {error=true;return;}

    $(document).ready(function(){
            container = $(options.container);
            if( container.length>0 ) show();
            else error=true;
    });


   /**************************************************************************
    *                            PUBLIC PROPERTIES
    **************************************************************************/

   /**************************************************************************
    *                            PUBLIC METHODS
    **************************************************************************/
    this.page_next = function(e){
            e.preventDefault();
            if( error || working ) return false;

            if( index_page<count_page ){
                    index_page++;
                    show();
            }
            return false;
    };
    this.page_back = function(e){
            e.preventDefault();
            if( error || working ) return false;

            if( index_page>0 ){
                    index_page--;
                    show();
            }
            return false;
    };

    this.page_first = function(e){
            e.preventDefault();
            if( error || working ) return false;
            index_page=0;
            show();
            return false;
    };
    this.page_last = function(e){
            e.preventDefault();
            if( error || working ) return false;
            index_page=count_page;
            show();
            return false;
    };
    this.update = function(new_options){
            if( error || working ) return false;
            options = $.extend(options, new_options);

            update_count_page();
            if( (count_page+1)>index_page ) index_page=0;
            show();

            return false;
    };
    this.change_page = function(page){
        if( !isNaN(parseInt(page)) && count_page>1 ) {
            index_page = page;
            this.update();
        }
        return false;
    }


   /**************************************************************************
    *                            PRIVATE PROPERTIES
    **************************************************************************/
    var error = false;
    var working = false;
    var index_page = 0;
    var count_page = 0;
    var count_reg = 0;


   /**************************************************************************
    *                            PRIVATE METHODS
    **************************************************************************/
    var show = function(){
            Loading();
            working=true;

            $.ajax({
                    type: "POST",
                    url: options.basename+"php/class.browsing.php?"+
                             "orderby="+ options.orderby +"&"+
                             "row_from="+ index_page*options.count_entries +"&"+
                             "row_to="+ options.count_entries +"&"+
                             "include="+ options.include_result +"&"+
                             "id_hidden="+ options.id_hidden +"&"+
                             "basename="+ options.basename
                    ,
                    data: options.formdata,
                    success: function(data){
                            container.html(data);

                            if( document.getElementById(options.id_hidden) ){
                                    count_reg = document.getElementById(options.id_hidden).value;
                                    update_count_page();
                            }else error=true;
                    },
                    complete: function(){
                            if( typeof options.callback=="function" ) options.callback(index_page+1, count_page+1, count_reg);
                            working=false;
                    }
            });
    }

    var update_count_page = function(){
            count_page = parseInt(parseFloat(count_reg) / options.count_entries);
    }

    var Loading = function(){
            var divMask = document.createElement("div");
            $(divMask).css("position", "absolute");
            $(divMask).css("left", "0px");
            $(divMask).css("top", "0px");
            $(divMask).css("width", container[0].offsetWidth+"px");
            $(divMask).css("height", container[0].offsetHeight+"px");
            $(divMask).css("background-color", "#ffffff");
            $(divMask).css("opacity", $.browser.msi ? "alpha(opacity=50)" : "0.5");
            $(divMask).css("z-index", "1000");

            var divImg = document.createElement("div");
            $(divImg).css("position", "absolute");
            $(divImg).css("left", "0px");
            $(divImg).css("top", "0px");
            $(divImg).css("width", container[0].offsetWidth +"px");
            $(divImg).css("height", container[0].offsetHeight +"px");
            $(divImg).css("background", "url("+options.basename+"img/ajax-loader.gif) no-repeat center");
            $(divImg).css("z-index", "1001");

            container.append(divMask);
            container.append(divImg);
    }
		
}