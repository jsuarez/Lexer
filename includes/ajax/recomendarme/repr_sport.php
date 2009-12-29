<?php
session_start();
$txt_nombre_destinatario= $_POST['txt_nombre_destinatario'];
$txt_nombre_apellido= $_POST['txt_nombre_apellido'];
$txt_nombre_destinatario2=$_POST['name_to'];
$txt_nombre_apellido2=$_POST["txt_nombre_apellido2"];
$txt_rep= $_POST["txt_rep"];
$txt_trabajo = $_POST["txt_trabajo"];
$txt_reg_City=$_POST["txt_reg_City"];
$txt_reg_country=$_POST["txt_reg_country"];
$txt_reg_sport=$_POST["txt_reg_sport"];
$txt_apellido = $_POST["txt_apellido"];
$txt_nombre = $_POST["txt_nombre"];
$txt_fecha_nacimiento= $_POST["txt_fecha_nacimiento"];
$txt_nombre_apellido2=$_POST["txt_nombre_apellido2"];
$txt_reg_country2=$_POST["txt_reg_country2"];
$txt_reg_City2=$_POST["txt_reg_City2"];
$txt_edad=$_POST["txt_edad"];
$txt_nacionalidad=$_POST["txt_nacionalidad"];
$txt_reg_phone_pref1= $_POST["txt_reg_phone_pref1"];
$txt_reg_phone_movil= $_POST["txt_reg_phone_movil"];
$txt_trabajo2=$_POST["txt_trabajo2"];
$txt_reg_sport2=$_POST["txt_reg_sport2"];
$txt_nombre_apellido4=$_POST["txt_nombre_apellido4"];
$contacto_mail= $_SESSION["username"];

$html=<<<EOF

<p>
    	Asunto: <b>$txt_nombre_apellido</b> te quiere contactar un Representante de lexersports.com!!!
    </p>
    <p>
    	Hola <b>$txt_nombre_destinatario2</b>!
    </p>
    <p>
    Mi nombre es <b>$txt_nombre_apellido2</b>, soy <b>$txt_rep $txt_trabajo</b>  y he observado detenidamente tu Curriculum Vitae Deportivo (CVD) que tienes LexerSports.com. Creo que posees muy buenas condiciones para el <b>$txt_reg_sport</b> y me gustar&iacute;a que nos comuniquemos para que analices la posibilidad de representarte.
    </p>
    <p>
        Le hago llegar mi CVD (Curr&iacute;culum Vitae Deportivo) para que UD. pueda analizarlo y darme la oportunidad de poder ofrecer mis habilidades. 
    </p>
    <p>
        Mis Datos Personales son:
    </p>
    <p>
    	Apellido/s:<b>$txt_apellido</b><br />
        Nombre/s:<b>$txt_nombre</b><br /> 
        Fecha de Nacimiento:<b>$txt_fecha_nacimiento</b><br /> 
        Edad:<b>$txt_edad</b><br />
        Nacionalidad:<b>$txt_nacionalidad</b>(con el dibujo de la banderita)<br />
        Tel&eacute;fono Fijo:<b>$txt_reg_phone_pref1</b><br />
        Celular/M&oacute;vil:<b>$txt_reg_phone_movil</b><br />
        Sitio Web:<b>$txt_reg_website</b><br />
        Trabajo: <b>$txt_trabajo2</b><br />
        Deporte: <b>$txt_reg_sport2</b><br />
    </p>
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
    	Mi E-mail de contacto es: <b>$contacto_mail</b>
    </p>
    <p>
    Esperando tu respuesta, te saludo atte.
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