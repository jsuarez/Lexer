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

<!--SCRIPT BROWSING (PAGINADOR)-->
<script type="text/javascript" src="js/jquery.browsing/js/jquery.browsing.js"></script>

<?php if( $_SERVER['REQUEST_METHOD']=="POST" && isset($_POST["hidden_form_search"]) ){?>
<script type="text/javascript">
<!--
<?php 
    $hostname = HOSTNAME;
    $hostname = str_replace("http://".$_SERVER['HTTP_HOST'], "", $hostname);
    $hostname = str_replace("http://".$_SERVER['HTTP_HOST']."/", "", $hostname);
?>
    var Browsing = new Class_Browsing({
        container: '#resultsearch',
        basename: 'js/jquery.browsing/',
        include_result:'<?php echo $hostname;?>/includes/ajax/list_search.php',
        //orderby: 'coduser desc',
        count_entries: 10,
		formdata: "<?php echo $_POST["hidden_form_search"];?>",
        callback : function(index_page, count_page, count_reg){
            var tag="";
            for( n=1; n<=count_page; n++ ){
                tag+='<a href="#" onclick="Browsing.change_page('+n+'); return false;">'+n+'</a>';
            }

            $("#paginacion").html("Pagina: "+tag)
        }
    });
-->
</script>
<?php }?>
<!--END SCRIPT-->
</head>

<body>

<div id="container">
<!--inicio header-->
	<div id="header">
	<?php  include("includes/header.php");?>
	</div>
<!--fin header-->


<!--inicio contenido-->
    <div id="mainContent">
    	<div class="column_left">
            <div id="banner-centro">
                <?php include("includes/banner.php");?>
            </div>

            <?php if( $_SERVER['REQUEST_METHOD']=="POST" && isset($_POST["hidden_form_search"]) ){?>
                <div id="resultsearch"></div>
                <div id="paginacion" class="paginacion"></div>
            <?php }?>
        </div>
        
    	<div class="column_right">
            <div id="sidebar1">
            <?php include("includes/right.php");?>
            </div>
        </div>
        
	    <br class="clearfloat" />
    </div>         
<!--fin contenido-->

<!-- Para el Paginador -->
<!-- Fin Paginador-->	

<!-- Este elemento de eliminación siempre debe ir inmediatamente después del div #mainContent para forzar al div #container a que contenga todos los elementos flotantes hijos <br class="clearfloat" />-->

<!--inicio pie-->
	<div id="footer">
    <?php include("includes/footer.php");?>
    </div>
<!-- fin pie -->

</div>
<!-- end #container -->

</body>
</html>
