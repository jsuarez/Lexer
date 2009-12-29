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

<div id="topmenu">
    <ul>
    <li><a href="preguntas-frecuentes.php"><img src="images/preguntasfrecuentes.jpg" alt="Preguntas Frecuentes" border="0" /></a></li>
    <li><a href="recomendar-mi-cv.php"><img src="images/comorecomendar.jpg" alt="Como Recomendar mi CV" border="0" /></a></li>
    <li><a href="como-funciona.php"><img src="images/comofunciona.jpg" alt="Como Funciona LexerSports" border="0" /></a></li>
    <li><a href="acerca-de-lexer-sports.php"><img src="images/acercade.jpg" alt="Acerca de LexerSports" border="0" /></a></li>
  </ul>
</div>

<div id="search2">
</div>
