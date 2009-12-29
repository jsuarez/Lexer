<?
require_once("php/selects.php");
require_once("php/forms_advancedsearch.php");
?>

<div id="top">
    <div class="topmenu-top">
        <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="preguntas-frecuentes.php">Ayuda</a></li>
        <li><a href="contacto.php">Contacto</a></li>
        </ul>
    </div>
    <div class="login">
        <? if( $STATUSLOGIN=="ON" ){?>
        
            <form name="formLogin" method="post" enctype="application/x-www-form-urlencoded">
                <div class="username">Hola:&nbsp;&nbsp;<b><? echo get_username($_SESSION["coduser"], $_SESSION["tableusers"]);?></b></div>         
                <input type="submit" value="Salir" id="login" />
                <input type="hidden" name="action" value="<? echo session_id();?>" />
            </form> 
                    
        <? }else{?>
	        <div class="login-opcional"><a href="#" onclick="Login.remember_pass.show_dialog(this);return false;">Olvidaste tu Contrase&ntilde;a?</a></div>
            <form name="formLogin" method="post" enctype="application/x-www-form-urlencoded" onsubmit="return Login.validate(this);">
                <input class="input" type="text" name="txtUser" value="Usuario" onfocus="clear_input(event)" onblur="set_input(event, 'Usuario')" />
                <input class="input" type="text" name="txtPass" value="Contrase&ntilde;a" onfocus="clear_input(event, 1)" onblur="set_input(event, 'Contrase&ntilde;a', 1)" />
                <input type="submit" value="Entrar" id="login" />            
                <input type="hidden" name="action" value="login" />
            </form>
        <? }?>        
    </div>
</div>

<div id="logo"><a href="user-account.php"><img src="images/logo.png" alt="Lexer Sports" border="0" width="250" /></a></div>
<? if( !isset($STATUSLOGIN) ){?>
<div id="bannertop"><a href="registro.php"><img src="images/bannertop.png" alt="Registrate Gratis!" border="0" /></a></div>
<? }?>

<div id="topmenu">
    <ul>
    <li><a href="preguntas-frecuentes.php"><img src="images/preguntasfrecuentes.jpg" alt="Preguntas Frecuentes" border="0" /></a></li>
    <li><a href="recomendar-mi-cv.php"><img src="images/comorecomendar.jpg" alt="Como Recomendar mi CV" border="0" /></a></li>
    <li><a href="como-funciona.php"><img src="images/comofunciona.jpg" alt="Como Funciona LexerSports" border="0" /></a></li>
    <li><a href="acerca-de-lexer-sports.php"><img src="images/acercade.jpg" alt="Acerca de LexerSports" border="0" /></a></li>
  </ul>
</div>

<div id="search">
    <form method="post" action="index.php" id="form_search" name="form_search" enctype="application/x-www-form-urlencoded">
        <input type="text" name="txtName" value="Nombre..." onfocus="clear_input(event)" onblur="set_input(event, 'Nombre...')" />
        
        <select name="cboCategory" onchange="Search.slider_search_advanced(1)">
            <option value="1">Deportista</option>
            <option value="2">Representante</option>
            <option value="3">Club</option>
            <option value="4">Sponsor</option>
        </select>
        
        <select id="cboSport" name="cboSport">
        <? get_options("list_sports");?>
        </select>
        
        <select id="cboCountry" name="cboCountry">
        <? get_options("list_country");?>
        </select>
        
        <input class="buscar" type="button" onclick="Search.search()" value="Buscar" />
        <input name="hidden_form_search" type="hidden" value="" />
        <input name="action" type="hidden" value="search" />
    </form> 
</div>

<div id="advanced_search">
    <div class="fields_advanced_search">
    <?php get_form("deportista");?>
	</div>
	<div class="button_search"><a href="#" onclick="Search.slider_search_advanced(); return false;">Busqueda Avanzada</a></div>
</div>
