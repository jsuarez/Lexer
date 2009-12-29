<?php
include("../../configure.php");
include("../../connection/connection.php");
header('Content-type: text/html; charset=utf-8');
session_start();
$result = $data->get_result("SELECT Concat(`users_sports`.`lastname`, ' ',
									  `users_sports`.`firstname`) AS `name`,
									 users_sports.city,
									 (SELECT name FROM list_country WHERE codcountry=country) AS country
							FROM users_sports
							WHERE coduser=".$_SESSION["coduser"]);
?>
<div>
<!-- los imput que se los puse así porq se repiten el mail-->
<!-- Asunto-->
    <p>
    	Asunto: Hola 
        <input name="txt_nombre_destinatario" type="text" class="inputbox" value="Persona"/>! <? echo $result["name"];?>
          quiere tener una prueba en su Instituci&oacute;n. Deportista de LexerSports.com!
    </p>
<!-- Fin Asunto-->
<!-- Saludo-->
    <p>
    	Hola <input name="txt_nombre_destinatario2" type="text" class="inputbox" value="Nombre destinatario"/>! email <input type="text" class=" inputbox" id="txt_contacto_mail" name="txt_contacto_mail"  value="contacto@sitioweb.com"/>
    </p>
<!-- Fin Saludo-->
<!-- Presentación-->
    <p>
    Mi nombre es <? echo $result["name"];?>, vivo en <? echo $result["city"];?>, <? echo $result["country"];?>, soy jugador de <input type="text" class="inputbox"  name="txt_reg_sport" value="Deporte"/> y quiero tener la posibilidad de realizar una prueba en su Institución.
    </p>
    <p>
        Le hago llegar mi CVD (Currículum Vitae Deportivo) para que UD. pueda analizarlo y darme la oportunidad de poder 				ofrecer mis habilidades. 
    </p>
<!-- Fin Presentación-->
<!--Datos Personales -->
    <p>
        Mis Datos Personales son:
    </p>
    <p>
        Apellido/s y Nombre/s: <? echo $result["name"];?> <br />
        País, Ciudad: <? echo $result["country"];?>, <? echo $result["city"];?> (bandera del pais)<br />
        Edad: <input type="text" class="inputbox" name="txt_edad" onkeypress="ValidKey(event,'number','unsigned')" value=""/><br />
        Peso: <input type="text" class="inputbox" name="txt_peso" onkeypress="ValidKey(event,'number','unsigned')" value=""/> <br />
        Altura: <input type="text" class="validator {v_required:true} inputbox" name="" onkeypress="ValidKey(event,'number','unsigned')" value=""/><br />
        Deporte: <input type="text" class="inputbox"  name="txt_reg_sport2" value=""/><br /> 
        Posición: <input type="text" class="inputbox" name="txt_posicion" value=""/><br />
        Pasaporte: <input type="text" class="inputbox" name="txt_pasaporte" value=""/><br />
    </p>
<!--Fin Datos Personales -->
<!-- Curriculum -->
    <p>
    	Para ver mi CVD completo debe registrarse en lexersports.com.
    </p>
    <p>
    	La registración es totalmente gratuita.
    </p>
    <p>
    	Si ya es un Usuario Registrado siga el siguiente enlace para verlo:
    </p>
    <p>
    	<a href="">http://www.lexersports.com/<Nombre y Apellido>.html</a>
    </p>
    <p>
    Para registrarte y ver el CVD de <? echo $result["name"];?>  haga clic <a href="">aqu&iacute;.</a>
    </p>
<!-- Fin Curriculum-->
<!-- Saludos Finales-->
    <p>
    Esperando su respuesta, saluda a UD. atte.
    </p>
    <p>
    <? echo $result["name"];?>
    </p>
    <p>
    <a href="">www.lexersports.com</a>
    </p>
    <p>
    Si tienes alguna duda consulta nuestras Políticas de Privacidad.  
    </p>
<!-- Fin Saludos Finales-->
</div>

<input name="" type="button" value="Preview" onclick="Recomendarme.mail('sport_otrapersona.php');" />
<input name="" type="button" value="Enviar" onclick="Recomendarme.mail('sport_otrapersona.php?action=send');" />

<div id="basic-modal-content"></div>