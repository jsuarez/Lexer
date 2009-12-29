<? if( $_GET["action"]=="send" ){

	include("../configure.php");
	include("../connection/connection.php");
	include("../php/functions.php");
	include("../classphp/class.sendmail.php");
	
	$sql = "SELECT coduser FROM users WHERE email = '".$_POST["email"]."' and active=1";
	$veri = $data->get_result($sql);

	if( $veri!="N/A" ){
		$newpass = generator_pass(6);
		
		$sendmail = new Class_SendMail();
		$sendmail->from = REMEMBERPASS_EMAIL_FROM;
		$sendmail->name_from = REMEMBERPASS_EMAIL_NAMEFROM;
		$sendmail->to = $_POST["email"];
		$sendmail->subject = REMEMBERPASS_SUBJECT;
		$sendmail->message = sprintf(REMEMBERPASS_MESSAGE, $newpass);
		
		if( $sendmail->send() ) {
			$data->query("UPDATE users SET pass='".md5($newpass)."' WHERE coduser=".$veri["coduser"]);		
			die("sendmail_ok");
		}
		else die("sendmail_error");
		
	}else die("not exists");
	
	
}else{?>

<div id="content_form">
	<div class="title">Para iniciar el proceso de recuperaci&oacute;n de contrase&ntilde;a, por favor, introduzca su direcci&oacute;n de email.</div>
	
    <ul>
        <li class="cell1">E-mail:</li>
        <li><input type="text" id="txtEmail" class="input" onblur="this.value=this.value.toLowerCase();" /></li>
	</ul>
    
    <div class="buttonsend">
    	<input id="btnSend" type="button" onclick="Login.remember_pass.send();" value="Enviar" />
    	<input type="button" onclick="Login.remember_pass.close_dialog();" value="Cerrar" />
    </div>	
</div>

<? }?>