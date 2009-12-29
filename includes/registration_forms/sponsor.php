<?
include("../../configure.php");
include("../../connection/connection.php");
include("../../php/constructor.php");
session_start();
header('Content-type: text/html; charset=utf-8');
?>

<?
if( isset($_GET["coduser"]) ){	
	$sql = "SELECT ";
	$sql.= "s.*,";
	$sql.= "(select name from list_companies_items where coditem=s.codcompanylist) as item_name ";
	$sql.= "FROM users_sponsors s ";
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

<h3>Datos de la Instituci&oacute;n</h3>
<ul class="form">
<?
	// ========= RAZON SOCIAL =========
	get_html("socialreason");

	// ========= CUIT =========
	get_html("cuit");

	// ========= DOMICILIO LEGAL =========
	get_html("address");

	// ========= PAIS, PROVINCIA, CIUDAD Y CODIGO POSTAL =========
	get_html("location");

	// ========= TELEFONO FIJO Y CELULAR =========
	get_html("phones");

	// ========= RUBRO =========
	get_html("item");
	

?>    
</ul>

<h3>Datos del Titular o Apoderado</h3>
<ul class="form">
<?
	// ========= CARGO =========
	get_html("charge");

	// ========= APELLIDO Y NOMBRE (TITULAR) =========
	get_html("titular_lastfirstname");

	// ========= TELEFONO FIJO Y CELULAR (TITULAR) =========
	get_html("titular_phones");

	// ========= TIPO Y NRO DE DOCUMENTO (TITULAR) =========
	get_html("titular_document");

	// ========= CATCHA =========
	if( isset($_GET["show_catcha"]) ){	
		get_html("catcha");
	}
?>
</ul>

<div class="buttonRegister">
<? if( isset($_GET["coduser"]) ){?>
	<input type="button" value="Guardar" onclick="Registry.send('registry_sponsor.php', 'edit', '<? echo $_GET["coduser"];?>');">
	<input type="reset" value="Reset">

<? }else{?>
	<input type="button" value="Registrarme" onclick="Registry.send('registry_sponsor.php', 'new');">
<? }?>
</div>
