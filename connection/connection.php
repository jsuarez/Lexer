<?php
include("data.class.php");

$data=new Data(BDD_PARAM);
$data->setConnection(BDD_HOST, BDD_USER, BDD_PASS, BDD_BASENAME);
?>