<?
include("configure.php");
include("connection/connection.php");

session_start();
include("includes/validlogin.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Lexer Sports</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <? include("includes/head.php");?>

<!--FORMULARIO DE REGISTRO-->
<script type="text/javascript" src="js/class.registry.js"></script>
<script type="text/javascript">
addEvent(window, "load", function(){
	Registry.show_form(document.getElementById("cboRegCategory").value);
});
</script>
<!--END SCRIPT-->

<!-- COMPONENTE AUTOCOMPLETE-->
<script type='text/javascript' src='js/autocomplete/lib/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/autocomplete/lib/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/autocomplete/lib/thickbox-compressed.js'></script>
<script type='text/javascript' src='js/autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="js/autocomplete/jquery.autocomplete.css" />
<!--END SCRIPT-->

<script type="text/javascript" src="js/class.effect.fade.js"></script>
</head>

<body>

<div id="container">
	<div id="header">
	  <?  include("includes/header.php");?>
	</div>

	<!--inicio contenido-->
	<div id="mainContent">
		<div class="column_left">
			<div id="banner-centro"><?php include("includes/banner.php");?></div>
            <div class="registry">
                <div class="div_combo"><span>Categor&iacute;a</span>
                    <select id="cboRegCategory" onChange="Registry.show_form(this.value);">
                    <option value="0">Seleccione una categor&iacute;a</option>
                    <option value="deportista.php">Deportista</option>
                    <option value="club.php">Club</option>
                    <option value="representante.php">Representante</option>
                    <option value="sponsor.php">Sponsor</option>
                    </select><div class="progress"></div>
                </div>
                <form id="form_registry" name="formRegistry" method="post" enctype="multipart/form-data" target="iframeUpload" action="registro.php"></form>
            </div>
        </div>
        
        <div class="column_right">
            <div id="sidebar1">
            <? include("includes/right.php");?>
            </div>        
        </div>

		<br class="clearfloat" />
    </div>
    <!--end mainContent-->
    
<!-- Este elemento de eliminación siempre debe ir inmediatamente después del div #mainContent para forzar al div #container a que contenga todos los elementos flotantes hijos <br class="clearfloat" />-->
    
	<div id="footer">
    <? include("includes/footer.php");?>
    </div>

</div>

</body>
</html>