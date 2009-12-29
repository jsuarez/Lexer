<?php
include("data.class.php");

define("BDD_HOST", "localhost");
define("BDD_USER", "root");
define("BDD_PASS", "");
define("BDD_BASENAME", "pruebas");
define("BDD_PARAM", "connection");	

$data=new Data(BDD_PARAM);
$data->setConnection(BDD_HOST, BDD_USER, BDD_PASS, BDD_BASENAME);
?>