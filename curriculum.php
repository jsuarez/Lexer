<?php
include("configure.php");
include("connection/connection.php");

session_start();
include("includes/validlogin.php");
if( $_GET["id"]!="" ) $tableuser = $data->get_result("SELECT tableuser FROM users WHERE coduser=".$_GET["id"]);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Lexer Sports</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <?php include("includes/head.php");?>

    <!--=========SCRIPT "Slide Gallery"=========-->
    <link href="js/jquery.slide-gallery/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery.slide-gallery/js/jquery.slide-gallery.js"></script>
    <script type="text/javascript">
    <!--
        var SlideGallery = new ClassSlideGallery({
            selector_preview : '.picture_medium',
            selector_conthumbs : '.container-thumbs'
        });
       $(document).ready(function(){
           $(".picture_thumb .arrow.left a").bind("click", SlideGallery.back);
           $(".picture_thumb .arrow.right a").bind("click", SlideGallery.next);
       });
    -->
    </script>
    <!--================END SCRIPT===============-->

    
    <!-- COMPONENTE AUTOCOMPLETE-->
    <script type='text/javascript' src='js/autocomplete/lib/jquery.bgiframe.min.js'></script>
    <script type='text/javascript' src='js/autocomplete/lib/jquery.ajaxQueue.js'></script>
    <script type='text/javascript' src='js/autocomplete/lib/thickbox-compressed.js'></script>
    <script type='text/javascript' src='js/autocomplete/jquery.autocomplete.js'></script>
    <link rel="stylesheet" type="text/css" href="js/autocomplete/jquery.autocomplete.css" />
    <!--END SCRIPT-->

    <script type="text/javascript" src="js/class.curriculum.js"></script>
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
            
            <div id="curriculum_view">
            	<div id="curriculum_view_left">
                    <div class="curriculum_pictures">
                    	<div class="picture_medium">
                            <a href="container/images/thumbs/2800452127_865d013225.jpg" class="thumb-imagepreview"><img src="container/images/thumbs/2800452127_865d013225.jpg" alt="" width="200" height="145" /></a>
                        </div>
                    	<div class="picture_thumb">
                            <div class="arrow left"><a href="#"><img src="images/arrow_left.gif" alt="Atras" /></a></div>
                            <div class="container-thumbs">
                                <ul>
                                    <li><a href="container/images/thumbs/2800452127_865d013225.jpg"><img src="container/images/thumbs/2800452127_865d013225.jpg" alt="" width="50" height="48" /></a></li>
                                    <li><a href="container/images/thumbs/3369408747_83095f29a6.jpg"><img src="container/images/thumbs/3369408747_83095f29a6.jpg" alt="" width="50" height="48" /></a></li>
                                    <li><a href="container/images/thumbs/3465833837_17567e0d0d.jpg"><img src="container/images/thumbs/3465833837_17567e0d0d.jpg" alt="" width="50" height="48" /></a></li>
                                    <li><a href="container/images/thumbs/3687873529_f9fdf420c9.jpg"><img src="container/images/thumbs/3687873529_f9fdf420c9.jpg" alt="" width="50" height="48" /></a></li>
                                    <li><a href="container/images/thumbs/3926997014_81d65b265d.jpg"><img src="container/images/thumbs/3926997014_81d65b265d.jpg" alt="" width="50" height="48" /></a></li>
                                    <li><a href="container/images/thumbs/3989857323_156d28d272.jpg"><img src="container/images/thumbs/3989857323_156d28d272.jpg" alt="" width="50" height="48" /></a></li>
                                    <li><a href="container/images/thumbs/4086231325_7d997a047d.jpg"><img src="container/images/thumbs/4086231325_7d997a047d.jpg" alt="" width="50" height="48" /></a></li>
                                </ul>
                            </div>
                            <div class="arrow right"><a href="#"><img src="images/arrow_right.gif" alt="Siguiente" /></a></div>
                        </div>
                    </div>

                    <div class="curriculum_contact">
                        <h3>CONTACTO</h3>
                        FORMULARIO
                    </div>
                </div>
            	<div id="curriculum_view_right">
                    <div class="curriculum_tabs">
                        <ul>
                            <li<a href="#" onclick="Curriculum.show_datospersonales(<?php echo $_GET["id"];?>, '<?php echo $tableuser[0];?>'); return false;">Datos Personales</a></li>
                            <li<a href="#" onclick="Curriculum.showform(2); return false;">Datos Deportivos</a></li>
                            <li<a href="#" onclick="Curriculum.showform(3); return false;">Fotos</a></li>
                            <li<a href="#" onclick="Curriculum.showform(4); return false;">Videos</a></li>
                            <li<a href="#" onclick="Curriculum.showform(5); return false;">Test</a></li>
                        </ul>
                    </div>

                    <form id="form_registry" name="form_registry" action="" class="curriculum_content"></form>
                </div>
            </div>
            
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
