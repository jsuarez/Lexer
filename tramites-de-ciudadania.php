<?
include("configure.php");
include("connection/connection.php");

session_start();
include("includes/validlogin.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Acerca de Lexer Sports</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

	<?php include("includes/head.php");?>
</head>

<body>

<div id="container">
	<div id="header">
	<?php  include("includes/header.php");?>
	</div>

    <!--inicio contenido-->
    <div id="mainContent">
    	<div class="column_left">        
	        <div id="banner-centro"><img src="images/banner-centro.jpg" alt="publicidad" /></div>
        
            <p><strong>Tr&aacute;mites de Ciudadan&iacute;a</strong></p>
            <p></p>
        </div>
        
        <div class="column_right">
            <div id="sidebar1">
            <?php include("includes/right.php");?>
            </div>        	
        </div>
        
	   <br class="clearfloat" /></div>
    </div>        
	<!--fin contenido-->

<!-- Este elemento de eliminación siempre debe ir inmediatamente después del div #mainContent para forzar al div #container a que contenga todos los elementos flotantes hijos <br class="clearfloat" />-->

	<div id="footer">
    <?php include("includes/footer.php");?>
    </div>
</div>
<!-- end #container -->

</body>
</html>