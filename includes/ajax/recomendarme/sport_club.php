<?php
	include_once('../../../classphp/flourish/init.php');
	
	session_start();
	
	/*$sendmail = new Class_SendMail();
	$sendmail->from = $_SESSION["username"];
	$sendmail->name_from = $_SESSION["name"];
	//$sendmail->to = $_POST["cbo_to"]; //Direccion del remitente.
	//Prueba
	$sendmail->to = "ivan@mydesign.com.ar"; //Direccion del remitente.
	$sendmail->subject = "Recomendacin";
	$sendmail->message = $_POST["html"];

	if( $sendmail->send()){
	die("sendmail_ok");
	}else{
	die("sendmail_error");
	}*/
	
	
	//$to=$_POST["email_to"];	
	$to="ivan@mydesign.com.ar";	
	$to_name="Ivan";
	$subject="Recomendación";
	try {
	
		/* Envia email
		-------------------------------------------------------------- */
		$message_html = $_POST["html"];
	
		$message_plaintext = "&nbsp;";
	
		$email = new fEmail();
		$email->addRecipient($to, $_SESSION["name"]);  // Destinatario
		$email->setFromEmail($_SESSION["username"], $_SESSION["name"]);    // Remitente
		$email->setBounceToEmail($to);  // En caso de que rebote llegara a la direccion ingresada.
		$email->setSubject($subject);     // Asunto
		$email->setBody($message_plaintext);	 // Cuerpo del mensaje (texto plano)
		$email->setHTMLBody($message_html);	 // Cuerpo del mensaje (texto html)
		$email->send();
			
	
	}catch (fValidationException $e) {
		$message = $e->getMessage();
		die($message);
	}


?> 