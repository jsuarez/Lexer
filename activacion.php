<?
include("configure.php");
include("connection/connection.php");
session_start();
include("includes/validlogin.php");

if( isset($_GET["ckey"]) && $data->consult("users", "id", $_GET["ckey"]) ){
	$data->query("UPDATE users SET active=1 WHERE id='".$_GET["ckey"]."'");
}else{
	header("Location: index.php");
}
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
<!--inicio header-->
	<div id="header">
	<?  include("includes/header.php");?>
	</div>
<!--fin header-->


<!--inicio contenido-->
    <div id="mainContent">
    	<div class="column_left">
            <div id="banner-centro">
                <?php include("includes/banner.php");?>
            </div>
        
            <h2>El usuario ha sido activado con &eacute;xito.</h2>
	</div>

    	<div class="column_right">
            <div id="sidebar1">
                <? include("includes/right.php");?>
            </div>
        </div>
        <br class="clearfloat" />
    </div>
<!--fin contenido-->
    	
<!-- Este elemento de eliminación siempre debe ir inmediatamente después del div #mainContent para forzar al div #container a que contenga todos los elementos flotantes hijos <br class="clearfloat" />-->

<!--inicio pie-->
    <div id="footer">
    <? include("includes/footer.php");?>
    </div>
<!-- fin pie -->
</div>
<!-- end #container -->

</body>
</html>