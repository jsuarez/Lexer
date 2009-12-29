<?
$server = "no";

if( $server=="yes" ){
	define("HOSTNAME", "http://".$_SERVER['HTTP_HOST']."/lexer");
}else{
//	define("HOSTNAME", "http://192.168.0.2/trabajos/lexersports");
	define("HOSTNAME", "http://localhost/trabajos/lexersports");
}

if( $server=="yes" ){
	define("BDD_HOST", "localhost");
	define("BDD_USER", "demo_ivan");
	define("BDD_PASS", "octubre2008");
	define("BDD_BASENAME", "demo_modulos");
	define("BDD_PARAM", "connection");
	
}else{
	define("BDD_HOST", "localhost");
	define("BDD_USER", "root");
	define("BDD_PASS", "");
	define("BDD_BASENAME", "lexersport");
	define("BDD_PARAM", "connection");	
}

//--------- VARIABLES PARA EL FORMULARIO DE REGISTRO ----------
define("REGISTER_EMAIL_FROM", "users@lexersports.com");
define("REGISTER_NAME_FROM", "Lexer Sports");
define("REGISTER_SUBJECT", "Lexer Sports - Activaci�n de cuenta");
define("REGISTER_MESSAGE", '<a href="'.HOSTNAME.'/activacion.php?ckey=%s">Haga click aqu� para activar su cuenta</a>');

//-------- VARIABLES PARA EL FORMULARIO RECORDAR CONTRASE�A ----------
define("REMEMBERPASS_EMAIL_FROM", "users@lexersports.com");
define("REMEMBERPASS_EMAIL_NAMEFROM", "Lexer Sports");
define("REMEMBERPASS_SUBJECT", "Lexer Sports - Nueva contrase�a");
define("REMEMBERPASS_MESSAGE", 'Su nueva contrase�a es: %s');

define("UPLOAD_IMAGE_MAXSIZE", 2097152); //bytes
define("UPLOAD_MOVIE_MAXSIZE", 5242880); //bytes

//-------- VARIABLES PARA MAIL RECOMENDARME ----------
//define("REMEMBERPASS_SUBJECT", "Lexer Sports - Nueva contrase�a");
?>