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
	<div id="header">
	<?  include("includes/header.php");?>
	</div>


    <!--inicio contenido-->
    <div id="mainContent">
        <div class="column_left">
            <div id="banner-centro"><img src="images/banner-centro.jpg" alt="publicidad" /></div>
        
            <p><strong>Como  funciona Lexersports.com?</strong></p>
            <p>Cada deportista podrá realizar su CVD  (Currículum Vitae Deportivo) gratuitamente incorporando sus Datos Personales,  Perfil e Historial Deportivo, Estadísticas, Premios y/o Reconocimientos,  Videos, Fotos, agregar enlaces de: Fotos, Entrevistas, Recomendaciones,  Revistas, Diarios, Sitios, etc., y todo lo que el deportista crea conveniente  para poder ofrecer sus habilidades deportivas.</p>
            <p>El CVD podrá modificarse y mantenerse  actualizado con solo agregar el nombre de usuario y la contraseña que cada  deportista deberá proporcionar al crear su CVD.</p>
            <p>Para poder ver todos los CVD todos los  Usuarios deberán estar registrados en <strong>LexerSports</strong> sin excepción alguna. Te podrás registrar como Jugador, como Club, como  Representante o como Sponsor. </p>
            <ul>
              <li>Si formas parte de una <strong>Institución</strong> o <strong>Club</strong> podrás ver todos los CVD completos de todos los Jugadores  registrados en <strong>LexerSports</strong> sin  importar el Deporte que realicen. Así, podrás contactarte con los Deportistas  que hayas seleccionado para que puedan llegar a un acuerdo e incorporarlo a tu  Institución.</li><br />
              <li>Si eres un <strong>Representante</strong> <strong>Independiente</strong> o formas parte de un <strong>Grupo Empresario</strong> o <strong>Agencia </strong>podrás  ver todos los CVD completos de todos los Jugadores registrados en <strong>LexerSports </strong>sin importar el Deporte que  realicen. Así, podrás buscar, analizar, seleccionar y contactar a los  Deportistas que a tu entender tengan las condiciones necesarias para que lo  puedas representar. </li><br />
              <li>Si tienes una <strong>Empresa</strong> y quieres patrocinar o  sponsorear algún Deportista que la represente también te podrás registrar y  poner en contacto con los Deportistas más destacados de <strong>LexerSports</strong> que harán de tu Empresa, una “Marca” más reconocida y a  la vez, lo estarás ayudando a seguir creciendo como Deportista Profesional.</li>
        </ul>
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
