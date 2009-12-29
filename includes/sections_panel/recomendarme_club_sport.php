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
    	Asunto:  <input type="text" class="inputbox"  name="txt_reg_SocialReason" value="Razon Social" /> desea contactarte para una posible incorporación a su Institución desde lexersports.com !!
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
    El <input type="text" class="inputbox"  name="txt_reg_SocialReason2" value="Razon Social" /> , cree que tenes muy buenas condiciones para jugar al <input type="text" class="inputbox"  name="txt_reg_sport" value="Deporte"/> y desea contactarte para hablar sobre la posibilidad de incorporarte a nuestra Institución.
    </p>
<!-- Fin Presentación-->
<!--Datos Personales -->
    <p>
       Los Datos del Club son:
    </p>
    <p>
    Razón Social: <input type="text" class="inputbox"  name="txt_reg_SocialReason3" value="" />  (Escudo) <br />
    País, Ciudad: <input type="text" class="inputbox" name="txt_reg_country" value=""/>, <input type="text" class="inputbox"  name="txt_reg_City" value=""/> (bandera del pais)<br />
    Año de Fundación: <input type="text" class="inputbox" name="txt_reg_YearFoundation" onkeypress="ValidKey(event,'number','unsigned')" maxlength="4" value=""/><br />
    Categoría en la que compite: <input type="text" class=" inputbox" name="txt_category"  value=""/><br />
    Sitio Web: <input type="text" class="inputbox"  name="txt_reg_website" onblur="FormatUrl(this)" value="" /><br />
    Teléfono: <input type="text" class="inputbox inputpref1"  name="txt_reg_phone_pref1" onkeypress="ValidKey(event,'number','unsigned')" maxlength="12" value="" /><br />
    </p>
<!--Fin Datos Personales -->
<!-- Curriculum -->
    <p>
    	Si realmente estás interesado en tu posible incorporación no dudes en contactarte con nosotros.
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
    <input type="text" class="inputbox"  name="txt_reg_SocialReason4" value="Razon Social" /><br />
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
<input name="" type="button" value="Preview" onclick="Recomendarme.mail('club_sport.php');" />
<input name="" type="button" value="Enviar" onclick="Recomendarme.mail('club_sport.php?action=send');" />
<div id="basic-modal-content"></div>