<?php
include("../../configure.php");
include("../../connection/connection.php");
header('Content-type: text/html; charset=utf-8');
session_start();
?>
<div>
<!-- los imput que se los puse así porq se repiten el mail-->
<!-- Asunto-->
    <p>
    	Asunto: <input type="text" class="inputbox"  name="txt_reg_SocialReason" value="Razon Social" /> quiere contactarte para publicitar en su Institución desde LexerSports.com!!!
    </p>
<!-- Fin Asunto-->
<!-- Saludo-->
    <p>
    	Hola 
        	<? $rst = $data->query("SELECT `users`.`email`, `users_club`.`codclub`, `users_club`.`business_name`
									FROM `users` 
									INNER JOIN `users_club` 
									ON `users_club`.`coduser` = `users`.`coduser`
									 ORDER BY business_name");?>
            <select id="cbo_to" name="cbo_to">
            <option value="0">Seleccione un Email</option>
            <? while( $row=mysql_fetch_array($rst) ){?>
                <option value="<? echo $row["email"];?>"><? echo utf8_encode($row["business_name"]);?></option>
            <? }?>
            </select>!
    </p>
<!-- Fin Saludo-->
<!-- Presentación-->
    <p>
    Hemos visto su Registración en lexersports.com y creemos que su Institución tiene un buen futuro por delante en lo que respecta a los deportes. Es por eso que <input type="text" class="inputbox"  name="txt_reg_SocialReason2" value="Razon Social" /> desea comunicarse con Ud. para poder publicitar nuestra empresa en su Institución.
    </p>
<!-- Fin Presentación-->
<!--Datos Personales -->
    <p>
      Nuestros Datos son:
    </p>
    <p>
    Raz&oacute;n Social: <input type="text" class="inputbox"  name="txt_reg_SocialReason2" value=""/>(logo)<br />
    Pa&iacute;s, Ciudad: <input type="text" class="inputbox" name="txt_reg_country" value=""/>, <input type="text" class="inputbox"  name="txt_reg_City" value=""/> (bandera del pais)<br />
   	Año de Fundación: <input type="text" class="inputbox" name="txt_reg_YearFoundation" onkeypress="ValidKey(event,'number','unsigned')" maxlength="4" value=""/><br />
    Rubro: <input type="text" class="inputbox" name="txt_reg_item" id="txt_reg_item" value=""/><br />
    Sitio Web: <input type="text" class="inputbox"  name="txt_reg_website" onblur="FormatUrl(this)" value="" /><br />
    Tel&eacute;fono: <input type="text" class="inputbox inputpref1"  name="txt_reg_phone_pref1" onkeypress="ValidKey(event,'number','unsigned')" maxlength="12" value="" /><br />
  </p>
<!--Fin Datos Personales -->
<!-- Curriculum -->
    <p>
    	Si realmente está interesado en que publicitemos en su Institución contáctese con nosotros.
	</p>
    <p>
    	Mi E-mail de contacto es: <?php echo $_SESSION["username"];?>
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
<input name="" type="button" value="Preview" onclick="Recomendarme.mail('sponsor_club.php');" />
<input name="" type="button" value="Enviar" onclick="Recomendarme.mail('sponsor_club.php?action=send');" />
<div id="basic-modal-content"></div>