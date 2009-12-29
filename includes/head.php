<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV="Expires" CONTENT="0">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<link href="styles/style.css" rel="stylesheet" type="text/css" />
<!--[if IE]> 
<link rel="stylesheet" href="styles/styleIE.css" type="text/css" />
<![endif]-->
<!--[if IE 6]> 
<link rel="stylesheet" href="styles/styleIE6.css" type="text/css" />
<![endif]-->
<!--[if IE 8]> 
<link rel="stylesheet" href="style/styleIE8.css" type="text/css" />
<![endif]-->


<!--[if IE 6]> 
<script type="text/javascript" src="js/DD_belatedPNG.js"></script>
<script type="text/javascript"> 
    /*Load jQuery if not already loaded*/ if(typeof jQuery == 'undefined'){ document.write("<script type=\"text/javascript\"   src=\"js/ie6update/jquery.min.js\"></"+"script>"); var __noconflict = true; } 
    var IE6UPDATE_OPTIONS = {
        icons_path: "js/ie6update/ie6update/images/"
    }
</script>
<script type="text/javascript" src="js/ie6update/ie6update/ie6update.js"></script>
<![endif]-->

<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="js/comun.js"></script>
<script type="text/javascript" src="js/class.ajax.js"></script>
<script type="text/javascript" src="js/animate.script.js"></script>
<script type="text/javascript" src="js/class.login.js"></script>
<script type="text/javascript" src="js/slidermenu.js"></script>
<script type="text/javascript" src="js/class.search.js"></script>

<!--<script type="text/javascript" src="js/jquery.idTabs.min.js"></script>-->


<!--COMPONENETE PARA VALIDAR CAMPOS-->
<link href="js/jquery.validator/css/jquery.validate.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.validator/js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.validator/js/jquery.validate.messages.js"></script>
<!--END SCRIPT-->

<!--COMPONENTE DIALOG-->
<link href="js/dialog/dialog.style.css" rel="stylesheet" type="text/css" />
<script src="js/dialog/dialog.script.js" type="text/javascript"></script>
<!--END SCRIPT-->

<?php if( $status_login=="error" ){?>
<script type="text/javascript">
addEvent(window, "load", function(){
	Dialog.show(document.getElementById("login"), "El usuario y/o contrase&ntilde;a son incorrectos.");
});
</script>
<?php }?>

