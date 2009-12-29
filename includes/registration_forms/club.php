<?
include("../../configure.php");
include("../../connection/connection.php");
include("../../php/constructor.php");
session_start();
header('Content-type: text/html; charset=utf-8');

if( isset($_GET["coduser"]) ){	
	$sql = "SELECT ";
	$sql.= "c.*,";
	$sql.= "(select name from list_country where codcountry=c.country) as country_name,";
	$sql.= "(select name from list_provinces where codprovince=c.province) as province_name ";
	$sql.= "FROM users_club c ";
	$sql.= "INNER JOIN users u ON c.coduser = u.coduser ";
	$sql.= "WHERE u.coduser = ".$_GET["coduser"];
	$result = $data->get_result($sql);
}
?>

<? 
if( isset($_GET["show_data_users"]) ){
	include("../../includes/registration_forms/datos_usuario.php");
}
?>

<h3>Datos de la Instituci&oacute;n</h3>
<ul class="form">
<?
	// ========= RAZON SOCIAL =========
	get_html("socialreason");

	// ========= DEPORTE =========
	get_html("listsports");

	// ========= CUIT =========
	get_html("cuit");

	// ========= AÑO DE FUNDACION =========
	get_html("yearfundation");

	// ========= PRESIDENTE =========
	get_html("president");

	// ========= NOMBRE DEL ESTADIO =========
	get_html("stadium");

	// ========= DOMICILIO DE LA SEDE =========
	get_html("locationhome");

	// ========= PAIS, PROVINCIA, CIUDAD Y CODIGO POSTAL =========
	get_html("location");

	// ========= TELEFONO FIJO Y CELULAR =========
	get_html("phones");

	// ========= CATEGORIA EN LA QUE COMPITE =========
	get_html("competition_category");
?>
</ul>


<h3>Datos del Titular o Apoderado</h3>
<ul class="form">
<?
	// ========= CARGO =========
	get_html("charge");

	// ========= APELLIDO Y NOMBRE =========
	get_html("titular_lastfirstname");

	// ========= TELEFONO FIJO Y CELULAR =========
	get_html("titular_phones");

	// ========= TIPO Y NUMERO DE DOCUMENTO =========
	get_html("titular_document");

	// ========= CATCHA =========
	if( isset($_GET["show_catcha"]) ){	
		get_html("catcha");
	}
?>
</ul>

<div class="buttonRegister">
<? if( isset($_GET["coduser"]) ){?>
	<input type="button" value="Guardar" onclick="Registry.send('registry_club.php', 'edit', '<? echo $_GET["coduser"];?>');">
	<input type="reset" value="Reset">

<? }else{?>
	<input type="button" value="Registrarme" onclick="Registry.send('registry_club.php', 'new');">
<? }?>
</div>
