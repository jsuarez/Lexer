<?php
$txt_nombre_destinatario= $_POST['txt_nombre_destinatario'];
$txt_nombre_apellido= $_POST['txt_nombre_apellido'];
$txt_nombre_destinatario2=$_POST['name_to'];
$txt_nombre_apellido2=$_POST["txt_nombre_apellido2"];
$txt_reg_City=$_POST["txt_reg_City"];
$txt_reg_country=$_POST["txt_reg_country"];
$txt_reg_sport=$_POST["txt_reg_sport"];
$txt_nombre_apellido2=$_POST["txt_nombre_apellido2"];
$txt_reg_country2=$_POST["txt_reg_country2"];
$txt_reg_City2=$_POST["txt_reg_City2"];
$txt_edad=$_POST["txt_edad"];
$txt_peso=$_POST["txt_peso"];
$txt_altura=$_POST["txt_altura"];
$txt_reg_sport2=$_POST["txt_reg_sport2"];
$txt_posicion=$_POST["txt_posicion"];
$txt_pasaporte=$_POST["txt_pasaporte"];
$txt_nombre_apellido4=$_POST["txt_nombre_apellido4"];

$html=<<<EOF
 	<p>
    	Asunto:<b>$txt_nombre_apellido</b> est&aacute; buscando Representante en LexerSports.com!!!
    </p>

    <p>
    	Hola <b>$txt_nombre_destinatario2</b>!
    </p>
    <p>
    Mi nombre es <b>$txt_nombre_apellido2</b>, vivo en <b>$txt_reg_City</b>, <b>$txt_reg_country</b>, soy jugador de <b>$txt_reg_sport</b> y me gustar&iacute;a que analice la posibilidad de representarme.
    </p>
    <p>
        Mis Datos Personales son:
    </p>
    <p>
        Apellido/s y Nombre/s: <b>$txt_nombre_apellido2</b><br />
        Pa&iacute;s, Ciudad: <b>$txt_reg_country2</b>, <b>$txt_reg_City2</b>(bandera del pais)<br />
        Edad: <b>$txt_edad</b><br />
        Peso: <b>$txt_peso</b><br />
        Altura:<b>$txt_altura</b><br />
        Deporte:<b>$txt_reg_sport2</b><br /> 
        Posici&oacute;n:<b>$txt_posicion</b><br />
        Pasaporte:<b>$txt_pasaporte</b><br />
    </p>
    <p>
    	Para ver mi CVD (Curriculum Vitae Deportivo) completo siga el siguiente enlace:
    </p>
    <p>
    <a href="">http://www.lexersports.com/<Nombre y Apellido>.html</a>
    </p>
    <p>
    Si realmente esta interesado en mis condiciones no dude en contactarse conmigo.
Esperando su respuesta, saluda a UD. atte.
    </p>
    <p>
    <b>$txt_nombre_apellido4</b>
    </p>
    <p>
    <a href="">www.lexersports.com</a>
    </p>
    <p>
    Si tienes alguna duda consulta nuestras Políticas de Privacidad.  
    </p>
EOF;
    

if($_GET["action"]=="send"){

	include("../../../classphp/class.sendmail.php/");

	session_start();
	$sendmail = new Class_SendMail();
	$sendmail->from = $_SESSION["username"];
	$sendmail->name_from = $_SESSION["name"];
	//$sendmail->to = $_POST["cbo_to"]; //Direccion del remitente.
	//Prueba
	$sendmail->to = "ivan@mydesign.com.ar"; //Direccion del remitente.
	$sendmail->subject = "Recomendación";
	$sendmail->message = $html;

	if( $sendmail->send()){
	die("sendmail_ok");
	}else{
	die("sendmail_error");
	}
}else{
	echo $html;
}
?> 