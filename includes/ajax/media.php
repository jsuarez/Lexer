<?
include("../../configure.php");
include("../../connection/connection.php");
session_start();

switch($_GET["action"]){
case "delete":
	$data->query("DELETE FROM ".$_POST["table"]." WHERE codimage=".$_POST["codimage"]);
	
	$filename_original = "../../container/images/".$_POST["filename"];
	$filename_thumb    = "../../container/images/thumbs/".$_POST["filename"];
	if( file_exists($filename_original) ) unlink($filename_original);
	if( file_exists($filename_thumb) ) unlink($filename_thumb);

	die("ok");
break;	

case "selected";
	$data->query("UPDATE ".$_SESSION["tableusers"]." SET codimage=".$_POST["codimage"]." WHERE coduser=".$_SESSION["coduser"]);
	die("ok");
break;

case "deselected";
	$data->query("UPDATE ".$_SESSION["tableusers"]." SET codimage=NULL WHERE coduser=".$_SESSION["coduser"]);
	die("ok");
break;

case "movies_list":?>
					<? $rst = $data->query("SELECT * FROM movies ORDER BY filename");?>
			          <? while( $row=mysql_fetch_array($rst) ){?>
			    		<li class="row">
				          	<div class="cell1"><?php echo $row["filename"];?></div> 
							<div class="cell2"><a href="#" onclick="Media.delete_movie(<?php echo $row["codmovie"];?>,'<?php echo $row["filename"];?>');return false;">Eliminar</a></div>	          
				        </li>
			        <? }?>
<?php
break;
case "movies_delete":

	$filename_movie   = "../../container/movies/".$_POST["filename"];
	if( file_exists($filename_movie)){
		unlink($filename_movie);
		$data->query("DELETE FROM movies WHERE codmovie=".$_POST["codmovie"]);
		die("ok");
	}else{
		die("El archivo a eliminar no existe");
	}	
	
break;


}
	
?>