<?php
session_start();
$txt_nombre_destinatario= $_POST['txt_nombre_destinatario'];
$txt_nombre_apellido= $_POST['txt_nombre_apellido'];
$txt_contacto_mail= $_POST['txt_contacto_mail'];
$txt_nombre_apellido2=$_POST["txt_nombre_apellido2"];
$txt_nombre_apellido_sport= $_POST["txt_nombre_apellido_sport"];
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
$txt_reg_sport2=$_POST["txt_reg_sport2"];
$txt_nombre_apellido4=$_POST["txt_nombre_apellido4"];

$html=<<<EOF
	<p>
    	Asunto: <b>$txt_nombre_apellido</b> te recomienda un Jugador de lexersports.com!!!
    </p>
    <p>
    	Hola <b>$txt_nombre_destinatario</b>! email <b>$txt_contacto_mail</b>
    </p>
    <p>
    Soy <b>$txt_nombre_apellido2</b>, te recomienda que observes el Curr&iacute;culum Vitae Deportivo (CVD) de <b>$txt_nombre_apellido_sport</b> jugador de <b>$txt_reg_sport</b>, ya que tiene muy buenas condiciones.
    </p>
    <p>
        Le hago llegar mi CVD (Curr&iacute;culum Vitae Deportivo) para que UD. pueda analizarlo y darme la oportunidad de poder ofrecer mis habilidades. 
    </p>
    <p>
        Los Datos del Jugador son:
    </p>
    <p>
        Apellido/s y Nombre/s: <b>$txt_nombre_apellido2</b><br />
        Pa&iacute;s, Ciudad: <b>$txt_reg_country2</b>,<b>$txt_reg_City2</b> (bandera del pais)<br />
        Edad:<b>$txt_edad</b><br />
        Peso:<b>$txt_peso</b><br />
        Altura:<b>$txt_altura</b><br />
        Deporte:<b>$txt_reg_sport2</b><br /> 
        Posici&oacute;n:<b>$txt_posicion</b><br />
        Pasaporte:<b>$txt_pasaporte</b><br />
    </p>
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
    <p>
    Esperando su respuesta, saluda a UD. atte.
    </p>
    <p>
    <b>$txt_nombre_apellido4</b>
    </p>
    <p>
    <a href="">www.lexersports.com</a>
    </p>
    <p>
    Si tienes alguna duda consulta nuestras Pol&iacute;ticas de Privacidad.  
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