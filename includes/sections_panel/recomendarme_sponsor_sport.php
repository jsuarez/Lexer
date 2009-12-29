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
    	Asunto:  <input type="text" class="inputbox"  name="txt_reg_SocialReason" value="Razon Social" /> quiere contactarte para ser tu Sponsor desde lexersports.com!!!
    </p>
<!-- Fin Asunto-->
<!-- Saludo-->
    <p>
    	Hola 
        	<? $rst = $data->query("SELECT
									  `users`.`email`, Concat(`users_sports`.`lastname`, ' ',
									  `users_sports`.`firstname`) AS `name`
									FROM
									  `users` INNER JOIN
									  `users_sports` ON `users`.`coduser` = `users_sports`.`coduser`
									ORDER BY name");?>
            <select id="cbo_to" name="cbo_to">
            <option value="0">Seleccione un Deportista</option>
            <? while( $row=mysql_fetch_array($rst) ){?>
                <option value="<? echo $row["email"];?>"><? echo utf8_encode($row["name"]);?></option>
            <? }?>
            </select> !
    </p>
<!-- Fin Saludo-->
<!-- Presentación-->
    <p>
    Hemos visto tu Curriculum Vitae Deportivo (CVD) en lexersports.com y notamos que tenes muy buenas condiciones en el <input type="text" class="inputbox"  name="txt_reg_sport" value="Deporte"/> y queremos ayudarte a que sigas creciendo como deportista profesional. Es por eso que <input type="text" class="inputbox"  name="txt_reg_SocialReason2" value="Razon Social" /> quiere contactarte para ser tu Sponsor.
    </p>
<!-- Fin Presentación-->
<!--Datos Personales -->
    <p>
      Nuestros Datos son:
    </p>
    <p>
   Razón Social: <input type="text" class="inputbox"  name="txt_reg_SocialReason2" value="" />(logo)<br />  
    Pa&iacute;s, Ciudad: <input type="text" class="inputbox" name="txt_reg_country" value=""/>, <input type="text" class="inputbox"  name="txt_reg_City" value=""/> (bandera del pais)<br /> 
   	A&ntilde;o de Fundaci&oacute;n: <input type="text" class="inputbox" name="txt_reg_YearFoundation" onkeypress="ValidKey(event,'number','unsigned')" maxlength="4" value=""/><br />
    Rubro: <input type="text" class="inputbox" name="txt_reg_item" id="txt_reg_item" value=""/><br />
    Sitio Web: <input type="text" class="inputbox"  name="txt_reg_website" onblur="FormatUrl(this)" value="" /><br />
    Tel&eacute;fono: <input type="text" class="inputbox inputpref1"  name="txt_reg_phone_pref1" onkeypress="ValidKey(event,'number','unsigned')" maxlength="12" value="" /><br />
  </p>
<!--Fin Datos Personales -->
<!-- Curriculum -->
    <p>
    	Si realmente estás interesado en tenernos como Sponsor contáctate con nosotros.
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
<input name="" type="button" value="Preview" onclick="Recomendarme.mail('sponsor_sport.php');" />
<input name="" type="button" value="Enviar" onclick="Recomendarme.mail('sponsor_sport.php?action=send');" />
<div id="basic-modal-content"></div>