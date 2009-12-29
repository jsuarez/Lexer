// JavaScript Document

var ClassCurriculum = function(){

    //________________________________ PROPERTIES PUBLIC ________________________________


    //________________________________ METHODS PUBLIC ________________________________
    this.show_datospersonales = function(coduser, tableuser) {  //Datos personales
        var Ajax = new ClassAjax();
        
        switch(tableuser){
            case "users_sports": pagename = "deportista.php"; break;
            case "users_club": pagename = "club.php"; break;
            case "users_representatives": pagename = "representante.php"; break;
            case "users_sponsors": pagename = "sponsor.php"; break;
        }

        //$("#form_registry").html("<p>tsdfasdfasdfsfd</p>");
        

        return;

        Ajax.on_finalizer = function(){

            $("#form_registry").html(this.responseHTML).ready(function(){

                    Validator = new Class_Validator({
                        selectors:	'.validator',
                        messagePos: 'right',
                        messageClass: 'formError_Right',
                        validationOne: true
                    });

                    //--------- Autocomplete para "Idiomas" --------------------
                    $("#txt_reg_language").autocomplete("includes/ajax/autocomplete.php?action=language", {
                        width: 200,
                        selectFirst: false
                    });
                    $("#txt_reg_language").result(function(event, data, formatted) {
                        document.getElementById("txt_reg_language").setAttribute("attrCode", data[1]);
                    });

                    //--------- Autocomplete para "Paises" --------------------
                    $("#txt_reg_country").autocomplete("includes/ajax/autocomplete.php?action=country", {
                        width: 200,
                        selectFirst: false
                    });
                    $("#txt_reg_country").result(function(event, data, formatted) {
                        document.getElementById("txt_reg_country").setAttribute("attrCode", data[1]);
                    });
                    //--------- Autocomplete para "Provincias" --------------------
                    $("#txt_reg_province").autocomplete("includes/ajax/autocomplete.php?action=province", {
                        width: 200,
                        selectFirst: false
                    });
                    $("#txt_reg_province").result(function(event, data, formatted) {
                        document.getElementById("txt_reg_province").setAttribute("attrCode", data[1]);
                    });
                    //--------- Autocomplete para "Rubro" --------------------
                    $("#txt_reg_item").autocomplete("includes/ajax/autocomplete.php?action=items", {
                        width: 200,
                        selectFirst: false
                    });
                    $("#txt_reg_item").result(function(event, data, formatted) {
                        document.getElementById("txt_reg_item").setAttribute("attrCode", data[1]);
                    });

                    if( document.formRegistry.cboBirthDate_Day ) This.show_age();
            });

        }
        Ajax.execute("POST", "includes/registration_forms/"+pagename+"?coduser="+coduser);
    };



    //________________________________ PROPERTIES PRIVATE ________________________________
    var working = false;
    var This = this;

    //________________________________ METHODS PRIVATE ________________________________

}
var Curriculum = new ClassCurriculum();