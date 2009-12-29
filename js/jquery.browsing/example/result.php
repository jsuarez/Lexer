<?php 
include("connection/connection.php");

$browsing = new class_browsing($data);
$rstList = $browsing->get_query("SELECT * FROM usuarios");
?>

<table width="100%">
<tr>
	<td><b>Nombre</b></td>
	<td><b>Usuario</b></td>
	<td><b>Password</b></td>
	<td><b>Email</b></td>
</tr>
<?php while( $row=mysql_fetch_array($rstList) ){?>
<tr>
	<td><? echo $row["name"];?></td>
	<td><? echo $row["username"];?></td>
	<td><? echo $row["pass"];?></td>
	<td><? echo $row["email"];?></td>
</tr>	
<?php }?>
</table>
