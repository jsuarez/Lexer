<?php
include("configure.php");
include("connection/connection.php");
include("classphp/class.login.php");
include("php/functions.php");
session_start();


if( $_SERVER['REQUEST_METHOD']=="POST"  ){
	
	include_once('classphp/flourish/init.php');

  	switch ($_POST["upload"]) {
  		
  		case "foto":
                            try {
                                    $error = 0;
                                    // Create an fUpload object to handle the file upload
                                    $uploader = new fUpload();
                                    $uploader->setMaxFileSize(UPLOAD_IMAGE_MAXSIZE, "error2");

                                    // Require the user upload an image (with MIME type checking server-side)
                                    $uploader->setMIMETypes(
                                            array('image/jpeg', 'image/gif', 'image/png'), 'error1'
                                    );
                                    $Files    = array();

                                    $uploaded = fUpload::count('file_input_name');
                                    $Files = $_FILES['file_input_name']['name'];

                                    for ($i=0; $i < $uploaded; $i++) {

                                            $image = $uploader->move('container/images', 'file_input_name', $i);
                                            $thumb = $image->duplicate('container/images/thumbs')
                                                                       ->resize(250,0)
                                                                       ->saveChanges();

                                            $data->query("INSERT INTO ".$_POST["table"]."(coduser, filename) VALUES(".$_SESSION["coduser"] .",'". $Files[$i] ."')");
                                    }


                            }catch (fValidationException $e) {
                            $error = $e->getMessage();
		    	}
  		
		break;
		case "video":
				//die("Pase por aca Video");
				try { 
				$error = 0;
				// Create an fUpload object to handle the file upload
				$uploader = new fUpload();	
				$uploader->setMaxFileSize(UPLOAD_MOVIE_MAXSIZE, "error2");
				
				// Require the user upload an image (with MIME type checking server-side)
				/*$uploader->setMIMETypes(
					array('video/x-flv','video/mp4','video/x-ms-wmv'), 'error1'
				);*/
					$Files    = array();
					
					$uploaded = fUpload::count('file_input_name');
					$Files = $_FILES['file_input_name']['name'];
							
					for ($i=0; $i < $uploaded; $i++) {
						
						$ext = strtolower(substr($Files[$i], strrpos($Files[$i],".")+1));
						
						if ($ext=="flv"||$ext="wmv"||$ext=="mpg"||$ext=="mpeg"){
							$movie_name_file= date("dmYhi").$Files[$i];
							$movie = $uploader->move('container/movies', 'file_input_name', $i,$movie_name_file);			 
							$data->query("INSERT INTO movies (coduser, filename) VALUES(".$_SESSION["coduser"] .",'". $movie_name_file."')");
						}else{
							$error='error1_video';
						}
						
					}
				}catch (fValidationException $e) {
					//die ($e->getMessage());
			        $error = $e->getMessage();
			    }
		    	echo($error);
		break;	
  	}

	
?>

<html>
<head>
<script type="text/javascript">
<?
switch($error){
case 0:
	if($_POST["upload"]=="foto"){
?>
	parent.Media.success_photos();
<?php		
	}else{	
?>
	parent.Media.success_movies(["<? echo implode('","',$Files);?>"]);
<?php		
	}
break;
case "error1":?>
	var html = '<p>Las imagenes deben tener extenci&oacute;n .JPG, .PNG o .GIF</p>'+
			   '<p><button onclick="Registry.close_win_loading();">Cerrar</button></p>';
	parent.Registry.show_win_loading(html);
<? break;
case "error2":?>
	var html = '<p>El tamaño de la im&aacute;gen no debe superar los <? echo (UPLOAD_IMAGE_MAXSIZE/1024)/1024;?> Mb</p>'+
			   '<p><button onclick="Registry.close_win_loading();">Cerrar</button></p>';
	parent.Registry.show_win_loading(html);
<? break;
case "error3":?>
	var html = '<p>La im&aacute;gen no pudo ser subida al servidor.<br>Verifique que no este protegido contra escritura.</p>'+
			   '<p><button onclick="Registry.close_win_loading();">Cerrar</button></p>';
	parent.Registry.show_win_loading(html);
<? break;
case "error1_video":?>
	var html = '<p>Los videos deben tener la siguiente extenci&oacute;n .FLV, .WMV, .MPG o .MPEG</p>'+
			   '<p><button onclick="Registry.close_win_loading();">Cerrar</button></p>';
	parent.Registry.show_win_loading(html);
<? break;
}
?>
</script>
</head>
</html>


<? }else{

if( $_POST["action"]==session_id() ){
	$Login->logout();
	header("Location: index.php");
	
}else{
	if( !$Login->is_logged() ){
		header("Location: index.php");		
	}else $STATUSLOGIN = "ON";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Lexer Sports</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<? include("includes/head.php");?>

<script type="text/javascript" src="js/class.panel.js"></script>
<script type="text/javascript" src="js/class.registry.js"></script>
<script type="text/javascript" src="js/class.profile_sport.js"></script>
<script type="text/javascript" src="js/class.multimedia.js"></script>
<script type="text/javascript" src="js/class.recomendarme.js"></script>
<script type="text/javascript" src="js/class.test.js"></script>


<!-- COMPONENTE AUTOCOMPLETE-->
<!--<script type="text/javascript" src="js/autocomplete/lib/jquery.js"></script>-->
<script type='text/javascript' src='js/autocomplete/lib/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/autocomplete/lib/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/autocomplete/lib/thickbox-compressed.js'></script>
<script type='text/javascript' src='js/autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="js/autocomplete/jquery.autocomplete.css" />
<!--END SCRIPT-->

<!-- GALLERIFFIC -->
<link href="js/galleriffic/galleriffic.style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/galleriffic/jquery.galleriffic.js"></script>
<!--END SCRIPT-->

<!-- SIMPLEMODE -->
    <link type='text/css' href='js/simplemodal/css/basic.css' rel='stylesheet' media='screen' />   
    <!-- IE 6 "fixes" -->
    <!--[if lt IE 7]>
    <link type='text/css' href='js/simplemodal/css/basic_ie.css' rel='stylesheet' media='screen' />
    <![endif]-->
    <!--<script type='text/javascript' src='js/simplemodal/js/jquery.js'></script>-->
    <script type='text/javascript' src='js/simplemodal/js/jquery.simplemodal.js'></script>
<!-- END SCRIPT -->

<!--------- CALENDARIO --------->
<link rel="stylesheet" href="js/datepicker/style.css" type="text/css" media="all" />
<!--<script type="text/javascript" src="js/datepicker/jquery-1.3.2.min.js"></script>-->
<script type="text/javascript" src="js/datepicker/ui.datepicker.js"></script>
<!----------END SCRIPT----------->
<!--------- PROGRESSBAR --------->
<script type="text/javascript" src="js/jquery.progress/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript">
	$(function(){
		// Progressbar
		/*$("#progressbar").progressbar({
			value: 50 
		});*/
	});
</script>
<!--------- PROGRESSBAR --------->

</head>

<body>

<div id="container">
	<div id="header">
	<?  include("includes/header_panel.php");?>
	</div>

<!--inicio contenido-->
	<div id="mainContent">
    	<div class="column_left">
            <div class="user-menu">
                <ul>
                    <li><a href="#" onClick="slider_menu_ajax('includes/menuspanel/cargar_curri.php', 'menus', 30, 10); return false;">Cargar Curriculum</a> |</li>
                    <li><a href="#" onClick="slider_menu_ajax('includes/menuspanel/recomendarme.php', 'menus', 30, 10); return false;">Recomendarme</a> |</li>
                    <li><a href="#" onClick="Registry.show_form('datos_usuario.php', '<? echo $_SESSION["coduser"];?>'); return false;">Mi Cuenta</a></li>
                </ul>
                <ul>
                    <li>
                        Espacio utilizado&nbsp;<img src="images/disponible.png" alt="" align="absmiddle" />
                        <!--<div id="progressbar"></div>-->
                    </li>
                </ul>
            </div>        
            
        	<div id="menus" class="tab1"></div>
        
            <div class="registry">
                <div id="progress"><img src="images/ajax-loader2.gif" alt="" width="16" height="16" align="texttop" />&nbsp;Cargando...</div>
                <form name="formRegistry" id="form_registry" method="post" enctype="multipart/form-data" target="iframeUpload" action="user-account.php"></form>
            </div>
			<br class="clearfloat" />
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

	<div id="footer">
    <? include("includes/footer.php");?>
    </div>
</div>
<!-- end #container -->

</body>
</html>
<? }?>