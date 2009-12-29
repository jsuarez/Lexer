<?php
include("../../configure.php");
include("../../connection/connection.php");
include("../../php/functions.php");
header('Content-type: text/html; charset=utf-8');

session_start();

$sql = "";
$sql.="SELECT";
$sql.=" 	Concat(u.`lastname`, ' ',u.`firstname`) AS `name`,";
$sql.="		u.city,";
$sql.="		u.birth,";
$sql.="		p.codsport,";
$sql.="		(SELECT name FROM list_sports WHERE codsport=p.codsport) AS sport,";
$sql.="		p.codposition,";
$sql.="		(SELECT name FROM list_position WHERE p.codposition=codposition) as position,";
$sql.="		(SELECT name FROM list_country WHERE codcountry=country) AS country,";
$sql.="		CASE u.passport WHEN 1 THEN 'Sin pasaporte' WHEN 2 THEN 'Comunitario' WHEN 3 THEN 'Extracomunitario' END AS passport ";
$sql.=" FROM users_sports u";
$sql.=" JOIN `profile_sport` p ON u.coduser=p.coduser";
$sql.="	WHERE u.coduser=".$_SESSION["coduser"];

$result = $data->get_result($sql);

?>
<div id="mail_recomendacion">
<!-- los imput que se los puse así porq se repiten el mail-->
<!-- Asunto-->
    <p>
    	Asunto: Hola 
        <input name="txt_nombre_destinatario" type="text" class="validator {v_required:true} inputbox" value="Club"/>! <? echo $result["name"];?> quiere tener una prueba en su Instituci&oacute;n. Deportista de LexerSports.com!
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
            <option value="0">Seleccione un Destinatario</option>
            <? while( $row=mysql_fetch_array($rst) ){?>
                <option value="<? echo $row["email"];?>"><? echo utf8_encode($row["business_name"]);?></option>
            <? }?>
            </select>
    </p>
<!-- Fin Saludo-->
<!-- Presentación-->
    <p>
    Mi nombre es <? echo $result["name"];?>, vivo en <? echo $result["city"];?>, <? echo $result["country"];?>, soy deportista de <? echo $result["sport"];?> y quiero tener la posibilidad de realizar una prueba en su Instituci&oacute;n.
    </p>
    <p>
        Le hago llegar mi CVD (Curr&iacute;culum Vitae Deportivo) para que UD. pueda analizarlo y darme la oportunidad de poder 				ofrecer mis habilidades. 
    </p>
<!-- Fin Presentación-->
<!--Datos Personales -->
    <p>
        Mis Datos Personales son:
    </p>
    <p>
        Apellido/s y Nombre/s: <? echo $result["name"];?> <br />
        Pa&iacute;s, Ciudad: <? echo $result["country"];?>, <? echo $result["city"];?> (bandera del pais)<br />
        Edad: <?php echo get_age ($result["birth"]);?><br />
        <!--Peso: <input type="text" class="inputbox" name="txt_peso" onkeypress="ValidKey(event,'number','unsigned')" value=""/> <br />
        Altura: <input type="text" class="validator {v_required:true} inputbox" name="" onkeypress="ValidKey(event,'number','unsigned')" value=""/><br />-->
        Deporte: <? echo $result["sport"];?><br /> 
        <?php if (!empty ($result["position"])){ ?>Posici&oacute;n:<?php echo utf8_encode($result["position"]);?><br><?php }?>
        Pasaporte: <? echo $result["passport"];?><br />
    </p>
<!--Fin Datos Personales -->
<!-- Curriculum -->
    <p>
    	Para ver mi CVD completo debe registrarse en lexersports.com.
    </p>
    <p>
    	La registraci&oacute;n es totalmente gratuita.
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
    Si tienes alguna duda consulta nuestras Pol&iacute;ticas de Privacidad.  
    </p>
<!-- Fin Saludos Finales-->
</div>

<input name="" type="button" value="Preview" onclick="Recomendarme.mail_preview();" />
<input name="" type="button" value="Enviar" onclick="Recomendarme.mail('sport_club.php?action=send');" />

<div id="basic-modal-content"></div>