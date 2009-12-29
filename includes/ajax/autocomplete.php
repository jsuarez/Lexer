<?php
include("../../configure.php");
include("../../connection/connection.php");
header('Content-type: text/html; charset=utf-8');

switch( $_GET["action"] ){

case "language":
	$result = $data->query("SELECT * FROM list_languages WHERE name like'%".$_GET["q"]."%' ORDER BY name");
	while( $row=mysql_fetch_array($result) ){
		echo utf8_encode($row["name"])."|".$row["codlang"]."\n";
	}
break;

case "country":
	$result = $data->query("SELECT * FROM list_country WHERE name like'%".$_GET["q"]."%' ORDER BY name");
	while( $row=mysql_fetch_array($result) ){
		echo utf8_encode($row["name"])."\n";
	}    
break;

case "province":
	$result = $data->query("SELECT * FROM list_provinces WHERE name like'%".$_GET["q"]."%' ORDER BY name");
	while( $row=mysql_fetch_array($result) ){
		echo utf8_encode($row["name"])."\n";
	}    
break;

case "items":
	$result = $data->query("SELECT * FROM list_companies_items WHERE name like'%".$_GET["q"]."%' ORDER BY name");
	while( $row=mysql_fetch_array($result) ){
		echo utf8_encode($row["name"])."\n";
	}    
break;

case "sports":
	$result = $data->query("SELECT * FROM list_sports WHERE name like'%".$_GET["q"]."%' ORDER BY name");
	while( $row=mysql_fetch_array($result) ){
		echo utf8_encode($row["name"])."\n";
	}    
break;

case "verify_data":
	$code = $data->get_result("SELECT * FROM ".$_POST["table"]." WHERE name='".utf8_decode($_POST["value"])."'");
	if( $code=="N/A" ) die("not exists");
	else{
		echo $code[0];
		die();
	}
break;

case "representatives":
	//$sql = "SELECT CONCAT(lastname,' ',firstname) as name FROM users_representatives WHERE name like'%".$_GET["q"]."%' ORDER BY name";
	//echo $sql;
	$result = $data->query("SELECT CONCAT(lastname,' ',firstname) as name FROM users_representatives WHERE lastname like'%".$_GET["q"]."%' ORDER BY name");
	while( $row=mysql_fetch_array($result) ){
		echo utf8_encode($row["name"])."\n";
	} 
break;


}


die();
?>