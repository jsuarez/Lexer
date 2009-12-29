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
	        <div id="banner-centro"><img src="images/banner-centro.jpg" alt="publicidad" /></div>
        
            <p><strong>Que es LexerSports.com?</strong></p>
            <p><strong>Es  una plataforma gratuita online</strong> donde todos los Deportistas  Profesionales y Amateurs, pueden realizar, modificar, actualizar, ofrecer y  mantener su <strong>Curriculum Vitae Deportivo</strong> (CVD) en Internet a la vista de todo el mundo, las 24 hs. del día, más específicamente  al alcance inmediato de Clubes, Representantes, Instituciones, Empresas  Patrocinadoras y demás gente allegada al deporte, con el fin de <strong>ofrecer sus habilidades deportivas</strong> de  una forma profesional y <strong>acortar tiempos</strong> en lo que respecta a <strong>posibles pruebas,  futuras transferencias, contratos</strong>, etc.,<br />
              Los Clubes, Instituciones, Representantes  y Empresas Patrocinadoras también podrán contactarse entre ellos para una  posible publicidad o futuro contrato.</p>
            <p><strong><u>La Misión</u></strong><strong><u> </u></strong></p>
            <p>Millones de deportistas desean llegar a  vivir del deporte y demostrarle al mundo y a ellos mismos el talento y las  habilidades que poseen. Ya sea por no tener Representante, por no conocer la  manera de venderse, por no tener cerca una Institución donde ofrecer su  talento, por razones económicas, o tal vez por falta de convencimiento, el  deportista deja pasar el tiempo sin siquiera intentar llegar a ser un  profesional. <br />
                <strong>LexerSports</strong> nació con la idea de darle la posibilidad a todos los deportistas  de las distintas disciplinas poder ofrecer su CVD a todo el mundo, los 365 días  del año. De esta manera podrán mostrarse y contactarse con Representantes,  Instituciones, Clubes, Sponsors y Empresas Patrocinadoras del Gran Mundo  Deportivo de una manera más <strong>simple</strong>, <strong>rápida</strong> y, por sobre todo, <strong>más profesional</strong>.</p>
            <p><strong><u>La Visión</u></strong><strong><u> </u></strong></p>
            <p><strong>LexerSports</strong> desea convertirse en la plataforma gratuita online más convocada  donde millones de niños, adolescentes, hombres y mujeres del mundo ofrezcan sus  habilidades deportivas a Clubes, Representantes, Instituciones y personas  allegadas al deporte para que estos puedan analizar, seleccionar, contactar, y  contratar a los deportistas profesionales más habilidosos de cada disciplina.</p>
       </div>
       
       <div class="column_right">
            <div id="sidebar1">
            <?php include("includes/right.php");?>
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
