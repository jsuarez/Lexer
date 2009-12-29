<?php
include("../../configure.php");
include("../../connection/connection.php");
header('Content-type: text/html; charset=utf-8');
include("../../php/functions.php");
session_start();
	$result = $data->get_result("SELECT Concat(`users_representatives`.`lastname`, ' ',
										  `users_representatives`.`firstname`) AS `name`,
										 users_representatives.city,
										 users_representatives.birth,
										 users_representatives.nacionality,
										 Concat('(',`users_representatives`.`phone_pref1`, ')',
										 '(',`users_representatives`.`phone_pref2`, ')',
										  `users_representatives`.`phone`) AS `phone`,
										  Concat('(',`users_representatives`.`cel_pref1`, ')',
										 '(',`users_representatives`.`cel_pref2`, ')',
										  `users_representatives`.`cel`) AS `cel`,
										  users_representatives.website,
										  users_representatives.work,
									 (SELECT name FROM list_country WHERE codcountry=country) AS country
								FROM users_representatives
								WHERE coduser=".$_SESSION["coduser"]);
	$edad = get_age($result["birth"]);
?>
<div>
<!-- Asunto-->
    <p>
    	Asunto: <input name="txt_name" type="hidden" value="<? echo $result["name"];?>" /> <? echo $result["name"];?> te quiere contactar un Representante de lexersports.com!!!
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
    Mi nombre es <? echo $result["name"];?>, soy Representante <input name="txt_work" type="hidden" value="<? echo $result["work"];?>" /> <? echo $result["work"];?>  y he observado detenidamente tu Curriculum Vitae Deportivo (CVD) que tienes LexerSports.com. Creo que posees muy buenas condiciones para el <input type="text" class="inputbox"  name="txt_reg_sport" value="Deporte"/> y me gustaría que nos comuniquemos para que analices la posibilidad de representarte.
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
        Fecha de Nacimiento:<input name="txt_birth" type="hidden" value="<? echo $result["birth"];?>" /><? echo $result["birth"];?> <br /> 
        Edad: <input name="txt_edad" type="hidden" value="<? echo $edad;?>" /><? echo $edad;?><br />
        Nacionalidad:<input name="txt_nacionality" type="hidden" value="<? echo $result["nacionality"];?>" /><? echo $result["nacionality"];?>  (con el dibujo de la banderita)<br />
        Teléfono Fijo:<input name="txt_phone" type="hidden" value="<? echo $result["phone"];?>" /><? echo $result["phone"];?>  <br />
        Celular/Móvil:<input name="txt_cel" type="hidden" value="<? echo $result["cel"];?>" /><? echo $result["cel"];?>  <br />
        Sitio Web:<input name="txt_website" type="hidden" value="<? echo $result["website"];?>" /><? echo $result["website"];?> <br />
        Trabajo:<input name="txt_work" type="hidden" value="<? echo $result["work"];?>" /><? echo $result["work"];?><br />
        Deporte:<input type="text" class="inputbox"  name="txt_reg_sport2" value=""/><br />
    </p>
<!--Fin Datos Personales -->
<!-- Curriculum -->
    <p>
    	Para ver mis Datos Personales completos sigue el siguiente enlace:
    </p>
    <p>
    	<a href="">http://www.lexersports.com/<Nombre y Apellido>.html</a>
    </p>
    <p>
    	Si realmente estás interesado en mis servicios no dudes en contactarte conmigo.
    </p>
    <p>
    	Mi E-mail de contacto es: <?php echo $_SESSION["username"];?>
    </p>
    
<!-- Fin Curriculum-->
<!-- Saludos Finales-->
    <p>
    Esperando tu respuesta, te saludo atte.
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
<input name="" type="button" value="Preview" onclick="Recomendarme.mail('repr_sport.php');" />
<input name="" type="button" value="Enviar" onclick="Recomendarme.mail('repr_sport.php?action=send');" />
<div id="basic-modal-content"></div>