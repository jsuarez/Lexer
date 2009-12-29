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
    	Asunto:<? echo $result["name"];?>  est&aacute; buscando Representante en LexerSports.com!!!
    </p>
<!-- Fin Asunto-->
<!-- Saludo-->
    <p>
    	Hola 
        	<? $rst = $data->query("SELECT `users`.`email`, 
						  			concat(`users_representatives`.`lastname`,' ',`users_representatives`.`firstname`) AS name
									FROM `users` 
									INNER JOIN `users_representatives` ON `users`.`coduser` = `users_representatives`.`coduser`
									ORDER BY name");?>
            <select id="cbo_to" name="cbo_to">
            <option value="0">Seleccione un Representante</option>
            <? while( $row=mysql_fetch_array($rst) ){?>
                <option value="<? echo $row["email"];?>"><? echo utf8_encode($row["name"]);?></option>
            <? }?>
            </select> !
    </p>
<!-- Fin Saludo-->
<!-- Presentación-->
    <p>
    Mi nombre es <? echo $result["name"];?>, vivo en <? echo $result["city"];?>, <? echo $result["country"];?>, soy jugador de <input type="text" class="inputbox"  name="txt_reg_sport" value="Deporte"/> y me gustar&iacute;a que analice la posibilidad de
representarme.
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
    	Para ver mi CVD (Curriculum Vitae Deportivo) completo siga el siguiente enlace:
    </p>
    <p>
    <a href="">http://www.lexersports.com/<Nombre y Apellido>.html</a>
    </p>
<!-- Fin Curriculum-->
<!-- Saludos Finales-->
    <p>
    Si realmente esta interesado en mis condiciones no dude en contactarse conmigo.
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

<input name="" type="button" value="Preview" onclick="Recomendarme.mail('sport_representante.php');" />
<input name="" type="button" value="Enviar" onclick="Recomendarme.mail('sport_representante.php?action=send');" />

<div id="basic-modal-content"></div>
