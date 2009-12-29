<?php
include("../../configure.php");
include("../../connection/connection.php");
header('Content-type: text/html; charset=utf-8');
?>
<div>
<!-- los imput que se los puse así porq se repiten el mail-->
<!-- Asunto-->
    <p>
    	Asunto: <input type="text" class="inputbox"  name="txt_reg_SocialReason" value="Razon Social" />  te recomienda un Jugador de lexersports.com!!!
    </p>
<!-- Fin Asunto-->
<!-- Saludo-->
    <p>
    	Hola <input name="txt_nombre_destinatario2" type="text" class="inputbox" value="Nombre destinatario"/>! email <input type="text" class=" inputbox" name="txt_contacto_mail"  value="contacto@sitioweb.com"/>
    </p>
<!-- Fin Saludo-->
<!-- Presentación-->
    <p>
    <input type="text" class="inputbox"  name="txt_reg_SocialReason2" value="Razon Social" /> te recomienda que observes el Curriculum Vitae Deportivo (CVD) de <input type="text" class="inputbox" name="txt_nombre_apellido_sport" value="Nombre del Jugador"/> jugador de <input type="text" class="inputbox"  name="txt_reg_sport" value="Deporte"/>, ya que tiene muy buenas condiciones.
    </p>
<!-- Fin Presentación-->
<!--Datos Personales -->
    <p>
       Los Datos del Jugador son:
    </p>
     <p>
        Apellido/s y Nombre/s: <input type="text" class=" inputbox" name="txt_nombre_apellido2"  value=""/> <br />
        País, Ciudad: <input type="text" class="inputbox" name="txt_reg_country2" value=""/>, <input type="text" class="inputbox"  name="txt_reg_City2" value=""/> (bandera del pais)<br />
        Edad: <input type="text" class="inputbox" name="txt_edad" onkeypress="ValidKey(event,'number','unsigned')" value=""/><br />
        Peso: <input type="text" class="inputbox" name="txt_peso" onkeypress="ValidKey(event,'number','unsigned')" value=""/> <br />
        Altura: <input type="text" class="validator {v_required:true} inputbox" name="txt_altura" onkeypress="ValidKey(event,'number','unsigned')" value=""/><br />
        Deporte: <input type="text" class="inputbox"  name="txt_reg_sport2" value=""/><br /> 
        Posición: <input type="text" class="inputbox" name="txt_posicion" value=""/><br />
        Pasaporte: <input type="text" class="inputbox" name="txt_pasaporte" value=""/><br />
    </p>
<!--Fin Datos Personales -->
<!-- Curriculum -->
    <p>
    	Para ver el CVD completo debes registrarte en lexersports.com.
    </p>
    <p>
    	<b>La registración es totalmente gratuita.</b>
    </p>
    <p>
    	Si ya es un Usuario Registrado siga el siguiente enlace para verlo:
    </p>
    <p>
    	<a href="">http://www.lexersports.com/<Nombre y Apellido>.html</a> (link del cv)
    </p>
    <p>
    Para registrarte y ver el CVD de <input type="text" class=" inputbox" name="txt_nombre_apellido3"  value="Nombre y Apellido"/>  haga clic <a href="">aquí.</a>
    </p>
<!-- Fin Curriculum-->
<!-- Saludos Finales-->
     <p>
    Esperando su respuesta, saluda a UD. atte.
    </p>
    <p>
    <input type="text" class="inputbox"  name="txt_reg_SocialReason3" value="Razon Social" /><br />
	<input type="text" class="inputbox" name="txt_nombre_responsable" value="Representante"/> Responsable<br />
    </p>
    <p>
    <a href="">www.lexersports.com</a>
    </p>
    <p>
    Si tienes alguna duda consulta nuestras Políticas de Privacidad.  
    </p>
<!-- Fin Saludos Finales-->
</div>
<input name="" type="button" value="Preview" onclick="Recomendarme.mail('club_otrapersona.php');" />
<input name="" type="button" value="Enviar" onclick="Recomendarme.mail('club_otrapersona.php?action=send');" />
<div id="basic-modal-content"></div>