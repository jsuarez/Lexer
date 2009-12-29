<?php
include("../../configure.php");
include("../../connection/connection.php");
header('Content-type: text/html; charset=utf-8');
?>
<div>
<!-- los imput que se los puse así porq se repiten el mail-->
<!-- Asunto-->
    <p>
    	Asunto: <input type="text" class="inputbox" name="txt_nombre_apellido" value="Nombre y Apellido"/> te recomienda un Jugador de lexersports.com!!!
    </p>
<!-- Fin Asunto-->
<!-- Saludo-->
    <p>
    	Hola <input name="txt_nombre_destinatario" type="text" class="inputbox" value="Nombre destinatario"/>! email <input type="text" class=" inputbox" name="txt_contacto_mail"  value="contacto@sitioweb.com"/>
    </p>
<!-- Fin Saludo-->
<!-- Presentación-->
    <p>
    Soy <input type="text" class=" inputbox" name="txt_nombre_apellido2"  value="Nombre y Apellido"/>, te recomienda que observes el Curriculum Vitae Deportivo (CVD) de <input type="text" class="inputbox" name="txt_nombre_apellido_sport" value="Nombre del Jugador"/> jugador de <input type="text" class="inputbox"  name="txt_reg_sport" value="Deporte"/>, ya que tiene muy buenas condiciones.
    </p>
    <p>
        Le hago llegar mi CVD (Curr&iacute;culum Vitae Deportivo) para que UD. pueda analizarlo y darme la oportunidad de poder ofrecer mis habilidades. 
    </p>
<!-- Fin Presentación-->
<!--Datos Personales -->
    <p>
        Los Datos del Jugador son:
    </p>
    <p>
        Apellido/s y Nombre/s: <input type="text" class=" inputbox" name="txt_nombre_apellido2"  value=""/> <br />
        Pa&iacute;s, Ciudad: <input type="text" class="inputbox" name="txt_reg_country2" value=""/>, <input type="text" class="inputbox"  name="txt_reg_City2" value=""/> (bandera del pais)<br />
        Edad: <input type="text" class="inputbox" name="txt_edad" onkeypress="ValidKey(event,'number','unsigned')" value=""/><br />
        Peso: <input type="text" class="inputbox" name="txt_peso" onkeypress="ValidKey(event,'number','unsigned')" value=""/> <br />
        Altura: <input type="text" class="inputbox" name="txt_altura" onkeypress="ValidKey(event,'number','unsigned')" value=""/><br />
        Deporte: <input type="text" class="inputbox"  name="txt_reg_sport2" value=""/><br /> 
        Posici&oacute;n: <input type="text" class="inputbox" name="txt_posicion" value=""/><br />
        Pasaporte: <input type="text" class="inputbox" name="txt_pasaporte" value=""/><br />
    </p>
<!--Fin Datos Personales -->
<!-- Curriculum -->
    <p>
    	Para ver el CVD completo debes registrarte en lexersports.com.
    </p>
    <p>
    	<b>La registraci&oacute;n es totalmente gratuita.</b>
    </p>
    <p>
    	Si ya eres un Usuario Registrado sigue el siguiente enlace para verlo:
    </p>
    <p>
    	<a href="">http://www.lexersports.com/<Nombre y Apellido>.html</a>
    </p>
    <p>
    	Si no eres Usuario, para registrarte y ver el CVD has clic <a href="">aqu&iacute;.</a>
    </p>
<!-- Fin Curriculum-->
<!-- Saludos Finales-->
    <p>
    Esperando su respuesta, saluda a UD. atte.
    </p>
    <p>
    <input type="text" class=" inputbox" name="txt_nombre_apellido4"  value="Nombre y Apellido"/>
    </p>
    <p>
    <a href="">www.lexersports.com</a>
    </p>
    <p>
    Si tienes alguna duda consulta nuestras Pol&iacute;ticas de Privacidad.  
    </p>
<!-- Fin Saludos Finales-->
</div>
<input name="" type="button" value="Preview" onclick="Recomendarme.mail('repr_otrapersona.php');" />
<input name="" type="button" value="Enviar" onclick="Recomendarme.mail('repr_otrapersona.php?action=send');" />
<input name="" type="button" value="Cancelar" onclick="" />

<div id="basic-modal-content"></div>