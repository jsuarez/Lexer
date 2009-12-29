<?php
include("../../configure.php");
include("../../connection/connection.php");
include("../../php/selects.php");
include("../../php/forms_advancedsearch.php");

switch($_POST["action"] ){
		case "list_sports":
			switch ($_POST["usertype"]){
				case "Deportista":
					$rst = $data->query("SELECT DISTINCT s.codsport,s.name FROM list_sports s 
	INNER JOIN profile_sport p ON s.codsport=p.codsport ORDER BY s.name");
					?>
		            <? while( $row=mysql_fetch_array($rst) ){?>
		                <option value="<? echo $row["codsport"];?>"><? echo utf8_encode($row["name"]);?></option>
		            <? }?>  
				<?php break;
            	case "Representante":
					$rst = $data->query("SELECT s.codsport, s.name FROM list_sports s 
INNER JOIN users_representatives_to_sport r ON s.codsport = r.codsport ORDER BY s.name");
	            ?>
	            	<? while( $row=mysql_fetch_array($rst) ){?>
	                <option value="<? echo $row["codsport"];?>"><? echo utf8_encode($row["name"]);?></option>
	            	<? }
					break; 
				}?>   
<?php 
die();
		break;
		
		case "show_fields_advancedsearch":
			get_form($_POST["usertype"]);
			
			die();
		break;
}		
die("ok");
?>