<?
include("../../configure.php");
include("../../connection/connection.php");
include("../../php/constructor.php");
header('Content-type: text/html; charset=utf-8');

if( isset($_GET["coduser"]) ){
	
	$sql = "SELECT ";
	$sql.= "s.*,";
	$sql.= "(select name from list_country where codcountry=s.country) as country_name,";
	$sql.= "(select name from list_provinces where codprovince=s.province) as province_name,";
	$sql.= "(select name from list_languages where codlang=s.`language`) as `language_name`,";
	$sql.= "(select name from list_languages where codlang=s.`language2`) as `language_name2`,";
	$sql.= "(select name from list_languages where codlang=s.`language3`) as `language_name3`,";
	$sql.= "(select name from list_languages where codlang=s.`language4`) as `language_name4` ";
	$sql.= "FROM users_sports s ";
	$sql.= "INNER JOIN users u ON s.coduser = u.coduser ";
	$sql.= "WHERE u.coduser = ".$_GET["coduser"];
	$result = $data->get_result($sql);
}
?>

<?
if( isset($_GET["show_data_users"]) ){
	include("../../includes/registration_forms/datos_usuario.php");
}
?>


<h3>Datos Personales</h3>

<ul class="form">

<?
	// ========= APELLIDO Y NOMBRE =========
	get_html("lastfirstname");
		
	// ========= SEXO (OPTIONS) =========
	get_html("sex");

	// ========= FECHA DE NACIMIENTO =========
	get_html("birthdate");

	// ========= TIPO Y NRO DOCUMENTO =========
	get_html("document");

	// ========= PAIS, PROVINCIA, CIUDAD Y CODIGO POSTAL =========
	get_html("location");

	// ========= NACIONALIDAD =========
	get_html("nacionality");

	// ========= PASAPORTE =========
	get_html("passport");

	// ========= TELEFONO FIJO Y CELULAR =========
	get_html("phones");

	// ========= PAGINA WEB =========
	get_html("website");

	// ========= IDIOMA =========
	get_html("language");

	// ========= PROFESION O ACTIVIDAD =========
	get_html("profession");

	// ========= ESTUDIOS =========
	get_html("studies");

	// ========= DISCAPACIDAD =========
	get_html("disability");

	// ========= CATCHA =========
	if( isset($_GET["show_catcha"]) ){	
		get_html("catcha");
	}
?>

</ul>

<div class="buttonRegister">
<? if( isset($_GET["coduser"]) ){?>
	<input type="button" value="Guardar" onclick="Registry.send('registry_deportista.php', 'edit', '<? echo $_GET["coduser"];?>');">
	<input type="reset" value="Reset">

<? }else{?>
	<input type="button" value="Registrarme" onclick="Registry.send('registry_deportista.php', 'new');">
<? }?>
</div>