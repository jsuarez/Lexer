<?php
session_start();
$txt_reg_SocialReason= $_POST['txt_reg_SocialReason'];
$txt_nombre_destinatario=$_POST['name_to'];
$txt_reg_SocialReason2= $_POST['txt_reg_SocialReason2'];
$txt_nombre_apellido2=$_POST["txt_nombre_apellido2"];
$txt_reg_City=$_POST["txt_reg_City"];
$txt_reg_country=$_POST["txt_reg_country"];
$txt_reg_YearFoundation = $_POST["txt_reg_YearFoundation"];
$txt_category= $_POST["txt_category"];
$txt_reg_website = $_POST["txt_reg_website"];
$txt_reg_sport=$_POST["txt_reg_sport"];
$txt_nombre_apellido2=$_POST["txt_nombre_apellido2"];
$txt_reg_country2=$_POST["txt_reg_country2"];
$txt_reg_City2=$_POST["txt_reg_City2"];
$txt_nacionalidad=$_POST["txt_nacionalidad"];
$txt_reg_phone_pref1= $_POST["txt_reg_phone_pref1"];
$txt_reg_sport2=$_POST["txt_reg_sport2"];
$txt_contacto=$_POST["txt_contacto"];
$txt_reg_SocialReason3=$_POST["txt_reg_SocialReason3"];
$txt_reg_SocialReason4=$_POST["txt_reg_SocialReason4"];
$txt_nombre_responsable=$_POST["txt_nombre_responsable"];
$contacto_mail= $_SESSION["username"];

$html=<<<EOF
<p>
    	Asunto: <b>$txt_reg_SocialReason</b>desea contactarte para una posible incorporaci&oacute;n a su Instituci&oacute;n desde lexersports.com !!
    </p>
    <p>
    	Hola $txt_nombre_destinatario!
    </p>
    <p>
    El <b>$txt_reg_SocialReason2</b>, cree que tenes muy buenas condiciones para jugar al $txt_reg_sport y desea contactarte para hablar sobre la posibilidad de incorporarte a nuestra Instituci&oacute;n.
    </p>
    <p>
       Los Datos del Club son:
    </p>
    <p>
    Raz&oacute;n Social: <b>$txt_reg_SocialReason3</b>(Escudo) <br />
    Pa&iacute;s, Ciudad: <b>$txt_reg_country</b>,<b>$txt_reg_City</b> (bandera del pais)<br />
    A&ntilde;o de Fundaci&oacute;n: <b>$txt_reg_YearFoundation</b><br />
    Categor&iacute;a en la que compite: <b>$txt_category</b><br />
    Sitio Web: <b>$txt_reg_website</b><br />
    Tel&eacute;fono: <b>$txt_reg_phone_pref1</b><br />
    </p>
    <p>
    	Si realmente estás interesado en tu posible incorporación no dudes en contactarte con nosotros.
    </p>
    <p>
    	Mi E-mail de contacto es:<b>$contacto_mail</b>
    </p>
    <p>
    Esperando su respuesta, saluda a UD. atte.
    </p>
    <p>
    <b>$txt_reg_SocialReason4</b><br />
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