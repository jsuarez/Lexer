<?
include("configure.php");
include("connection/connection.php");
session_start();
include("includes/validlogin.php");


if( $_SERVER['REQUEST_METHOD']=="POST" && $_POST["send"]=="ok" ){
	
	/*include("includes/class.sendmail.php");
	$SendMail = new Class_SendMail();
	$SendMail->to = "guillermo@mydesign.com.ar";
	$SendMail->from = strtolower($_POST["txtEmail"]);
	$SendMail->name_from = ucwords($_POST["txtName"]);
	$SendMail->subject = $_POST["txtSubject"];
	
	$message = "<b>Nombre:</b> ".ucwords($_POST["txtName"])."<br>";
	$message.= "<b>Email:</b> ".ucwords($_POST["txtEmail"])."<br>";
	$message.= '<hr color="#5A5721">';
	$message.= $_POST["txtConsult"];	
	$SendMail->message = $message;
		
	$status_sendmail = $SendMail->send();		*/			
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Lexer Sports</title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<? include("includes/head.php");?>
<script type="text/javascript">
function validate(f){		
	if( f.txtName.value.length==0 ){
		alert('Field "Name" is required.');
		f.txtName.focus();
		return false;
	}
	if( f.txtEmail.value.length==0 ){
		alert('Field "Email" is required.');
		f.txtEmail.focus();
		return false;
	}
	if( /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(f.txtEmail.value)==false ){
		alert('Field "Email" is incorrect.');
		f.txtEmail.focus();
		return false;
	}
	if( f.txtSubject.value.length==0 ){
		alert('Field "Subject" is required.');
		f.txtSubject.focus();
		return false;
	}
	if( f.txtConsult.value.length==0 ){
		alert('Field "Consult" is required.');
		f.txtConsult.focus();
		return false;
	}
	
	return true;
}
</script>
</head>

<body>

<div id="container">
	<div id="header">
	<?  include("includes/header.php");?>
	</div>


<!--inicio contenido-->
<div id="mainContent">
	<div class="column_left">
        <div class="contact_form">
            <h2>Cont&aacute;ctenos</h2>
            <form method="post" enctype="application/x-www-form-urlencoded" onsubmit="return validate(this)">
            <ul class="container_contact">
                <li><span class="cell">Nombre</span><input type="text" name="txtName" /><span class="required">&nbsp;*</span></li>
                <li><span class="cell">Email</span><input type="text" name="txtEmail" /><span class="required">&nbsp;*</span><li>
                <li><span class="cell">Asunto</span><input type="text" name="txtSubject" /><span class="required">&nbsp;*</span></li>
                <li>
                    <span class="cell">Email y &Aacute;rea de Contacto</span>
                    <select name="cboArea">
                    <option value="0">Seleccione area</option>
                    <option value="publicidad@lexersports.com">Publicidad</option>
                    <option value="info@lexersports.com">Administracion</option>
                    <option value="denuncia@lexesports.com">Denuncias</option>
                    <option value="ayuda@lexersports.com">Ayuda</option>
                    <option value="support@lexesports.com">Soporte Tecnico</option>
                    </select><span class="required">&nbsp;*</span>
                <li>                    
                <li>
                	<span class="cell">Consulta</span>
	                <textarea name="txtConsult" rows="5"></textarea>
                </li>
                <li><input type="submit" class="button" value="Enviar" /></li>                    
                <li class="legend">(*) Campos obligatorios</li>                    
            </ul>
            <input type="hidden" name="send" value="ok" />
            </form>
        </div>
      </div>
      
      <div class="column_right">
            <div id="sidebar1">
            <? include("includes/right.php");?>
            </div>      
      </div>
    
    <br class="clearfloat" />
</div>
<!--fin contenido-->
    	
<!-- Este elemento de eliminación siempre debe ir inmediatamente después del div #mainContent para forzar al div #container a que contenga todos los elementos flotantes hijos <br class="clearfloat" />-->

	<div id="footer">
    <? include("includes/footer.php");?>
    </div>

</div>
<!-- end #container -->
</body>
</html>
