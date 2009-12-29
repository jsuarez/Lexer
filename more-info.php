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
</head>

<body>

<div id="container">
	<div id="header">
	<?  include("includes/header.php");?>
	</div>


<!--inicio contenido-->
  	<div id="mainContent">
  		<div class="column_left">
	        <div id="banner-centro"><img src="images/banner-centro.jpg" alt="publicidad" /></div>
            
	        <div class="more-info">
    	    </div>		
		</div>
        <div class="column_right">
            <div id="sidebar1">
            <? include("includes/right.php");?>
            </div>
        </div>
	</div>
<!--fin contenido-->
    	
<!-- Este elemento de eliminación siempre debe ir inmediatamente después del div #mainContent para forzar al div #container a que contenga todos los elementos flotantes hijos <br class="clearfloat" />-->

	<div id="footer">
    <? include("includes/footer.php");?>
    </div>

</div>
<!-- end #container -->

</body>
</html>
