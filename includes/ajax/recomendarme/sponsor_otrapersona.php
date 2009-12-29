<?php
$txt_reg_SocialReason= $_POST['txt_reg_SocialReason'];
$txt_nombre_destinatario=$_POST["txt_nombre_destinatario"];
$txt_contacto_mail=$_POST['txt_contacto_mail'];
$txt_reg_SocialReason2= $_POST['txt_reg_SocialReason2'];
$txt_nombre_apellido_sport=$_POST["txt_nombre_apellido_sport"];
$txt_nombre_apellido2=$_POST["txt_nombre_apellido2"];
$txt_reg_City=$_POST["txt_reg_City"];
$txt_reg_country=$_POST["txt_reg_country"];
$txt_reg_sport=$_POST["txt_reg_sport"];
$txt_nombre_apellido2=$_POST["txt_nombre_apellido2"];
$txt_reg_country2=$_POST["txt_reg_country2"];
$txt_reg_City2=$_POST["txt_reg_City2"];
$txt_reg_sport2=$_POST["txt_reg_sport2"];
$txt_edad=$_POST["txt_edad"];
$txt_peso=$_POST["txt_peso"];
$txt_altura=$_POST["txt_altura"];
$txt_reg_sport2=$_POST["txt_reg_sport2"];
$txt_posicion=$_POST["txt_posicion"];
$txt_pasaporte=$_POST["txt_pasaporte"];
$txt_nombre_apellido3=$_POST["txt_nombre_apellido3"];
$txt_reg_SocialReason3=$_POST["txt_reg_SocialReason3"];
$txt_nombre_responsable=$_POST["txt_nombre_responsable"];

$html=<<<EOF
<p>
    	Asunto: <b>$txt_reg_SocialReason</b> te recomienda un Jugador de lexersports.com!!!
    </p>
    <p>
    	Hola <b>$txt_nombre_destinatario</b>! email <b>$txt_contacto_mail</b>
    </p>
    <p>
    <b>$txt_reg_SocialReason2</b> te recomienda que observes el Curr&iacute;culum Vitae Deportivo (CVD) de <b>$txt_nombre_apellido_sport</b> jugador de <b>$txt_reg_sport</b>, ya que tiene muy buenas condiciones.
    </p>
    <p>
      Los Datos del Jugador son:
    </p>
   <p>
        Apellido/s y Nombre/s: <b>$txt_nombre_apellido2</b><br />
        Pa&iacute;s,Ciudad:  <b>$txt_reg_country2</b>,<b>$txt_reg_City2</b>(bandera del pais)<br />
        Edad:  <b>$txt_edad</b><br />
		Peso:  <b>$txt_peso</b><br />
		Altura:  <b>$txt_altura</b><br />
		Deporte:  <b>$txt_reg_sport2</b><br /> 
		Posici&oacute;n:  <b>$txt_posicion</b><br />
		Pasaporte:  <b>$txt_pasaporte</b><br />
    </p>
    <p>
    	Para ver mi CVD completo debe registrarse en lexersports.com.
    </p>
    <p>
    	<b>La registración es totalmente gratuita.</b>
    </p>
    <p>
    	Si ya es un Usuario Registrado siga el siguiente enlace para verlo:
    </p>
    <p>
    	<a href="">http://www.lexersports.com/<Nombre y Apellido>.html</a>
    </p>
    <p>
    Para registrarte y ver el CVD de <b>$txt_nombre_apellido3</b> haga clic <a href="">aquí.</a>
    </p>
    <p>
    Esperando su respuesta, saluda a UD. atte.
    </p>
    <p>
    <b>$txt_reg_SocialReason3</b><br />
	<b>$txt_nombre_responsable</b> Responsable<br />
    </p>
    <p>
    <a href="">www.lexersports.com</a>
    </p>
    <p>
    Si tienes alguna duda consulta nuestras Políticas de Privacidad.  
    </p>
<!-- Fin Saludos Finales-->
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