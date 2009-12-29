<?php
session_start();
$txt_reg_SocialReason= $_POST['txt_reg_SocialReason'];
$txt_nombre_destinatario=$_POST['name_to'];;
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
$txt_reg_YearFoundation = $_POST["txt_reg_YearFoundation"];
$txt_reg_phone_pref1= $_POST["txt_reg_phone_pref1"];
$txt_reg_website = $_POST["txt_reg_website"];
$txt_reg_item=$_POST["txt_reg_item"];
$txt_nombre_apellido3=$_POST["txt_nombre_apellido3"];
$txt_contacto=$_POST["txt_contacto"];
$txt_reg_SocialReason3=$_POST["txt_reg_SocialReason3"];
$contacto_mail= $_SESSION["username"];
$txt_nombre_responsable=$_POST["txt_nombre_responsable"];

$html=<<<EOF
<p>
    	Asunto: <b>$txt_reg_SocialReason</b> quiere contactarte para publicitar en su Instituci&oacute;n desde LexerSports.com!!!
</p>
    <p>
    	Hola <b>$txt_nombre_destinatario</b>!
    </p>
    <p>
    Hemos visto su Registraci&oacute;n en lexersports.com y creemos que su Instituci&oacute;n tiene un buen futuro por delante en lo que respecta a los deportes. Es por eso que <b>$txt_reg_SocialReason2</b> desea comunicarse con Ud. para poder publicitar nuestra empresa en su Instituci&oacute;n.
    </p>
    <p>
      Nuestros Datos son:
    </p>
    <p>
    Raz&oacute;n Social: <b>$txt_reg_SocialReason2</b>(logo)<br />  
    Pa&iacute;s, Ciudad:<b>$txt_reg_country</b>, <b>$txt_reg_City</b> (bandera del pais)<br /> 
   	A&ntilde;o de Fundaci&oacute;n:<b>$txt_reg_YearFoundation</b><br />
    Rubro:<b>$txt_reg_item</b><br />
    Sitio Web:<b>$txt_reg_website</b><br />
    Tel&eacute;fono: <b>$txt_reg_phone_pref1</b><br />
  </p>
    <p>
    	Si realmente está interesado en que publicitemos en su Institución contáctese con nosotros.
	</p>
    <p>
    	Mi E-mail de contacto es:<b>$contacto_mail</b>
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