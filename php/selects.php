<?php
function get_options($option, $tableuser=""){
	global $data;
	
	switch($option){	
		case "list_sports":
			$sql = "SELECT DISTINCT codsport, name FROM(";
			$sql.= "SELECT ls.codsport, ls.name FROM list_sports ls ";
			$sql.= "INNER JOIN users_club_to_sport cs ON ls.codsport = cs.codsport ";
			$sql.= "INNER JOIN users_club c ON cs.codclub = c.codclub ";
			$sql.= "INNER JOIN users u ON c.coduser = u.coduser ";
			$sql.= "WHERE u.active=1 ";    
			$sql.= "UNION ";    
			$sql.= "SELECT ls.codsport, ls.name FROM list_sports ls ";
			$sql.= "INNER JOIN users_representatives_to_sport rs ON ls.codsport = rs.codsport ";
			$sql.= "INNER JOIN users_representatives r ON rs.codrepr = r.codrepr ";
			$sql.= "INNER JOIN users u ON r.coduser = u.coduser ";
			$sql.= "WHERE u.active=1 ";
			$sql.= ") a ORDER BY name";
			
			
			$result = $data->query($sql);
			
                        echo '<option value="0">Todos los deportes</option>';
                        while( $row=mysql_fetch_array($result) ){
                                echo '<option value="'.$row["codsport"].'">'.utf8_encode($row["name"]).'</option>'.chr(13);
                        }
		break;
		
		case "list_country":
			$sql = "SELECT DISTINCT codcountry, name FROM(";
    		$sql.= "SELECT lc.codcountry, lc.name FROM list_country lc ";
			$sql.= "INNER JOIN users_club c ON lc.codcountry = c.country ";
			$sql.= "INNER JOIN users u ON c.coduser = u.coduser ";
			$sql.= "WHERE u.active=1 ";						
			$sql.= "UNION ";						
			$sql.= "SELECT lc.codcountry, lc.name FROM list_country lc ";
			$sql.= "INNER JOIN users_representatives r ON lc.codcountry = r.country ";
			$sql.= "INNER JOIN users u ON r.coduser = u.coduser ";
			$sql.= "WHERE u.active=1 ";			
			$sql.= "UNION ";			
			$sql.= "SELECT lc.codcountry, lc.name FROM list_country lc ";
			$sql.= "INNER JOIN users_sports s ON lc.codcountry = s.country ";
			$sql.= "INNER JOIN users u ON s.coduser = u.coduser ";
			$sql.= "WHERE u.active=1 ";		
			$sql.= ") a ORDER BY name";
			
			$result = $data->query($sql);
			echo '<option value="0">Todos los paises</option>';
                        while( $row=mysql_fetch_array($result) ){
                                echo '<option value="'.$row["codcountry"].'">'.utf8_encode($row["name"]).'</option>'.chr(13);
                        }
		break;

		case "list_items":
			$sql = "SELECT i.coditem, i.name FROM list_companies_items i ";
			$sql.= "INNER JOIN users_sponsors u ON i.coditem=u.coditem ORDER BY i.name";
			
			$result = $data->query($sql);
			echo '<option value="0">Todos los Rubros</option>';
			while( $row=mysql_fetch_array($result) ){
				echo '<option value="'.$row["coditem"].'">'.utf8_encode($row["name"]).'</option>'.chr(13);
			}
		break;
		
		case "list_provinces":
			$sql = "SELECT p.codprovince, p.name FROM list_provinces p ";
			$sql.= "INNER JOIN ".$tableuser." u ON p.codprovince=u.province ORDER BY p.name";
			
			$result = $data->query($sql);
			echo '<option value="0">Todas las Provincias</option>';
			while( $row=mysql_fetch_array($result) ){
				echo '<option value="'.$row["codprovince"].'">'.utf8_encode($row["name"]).'</option>'.chr(13);
			}
		break;

		case "list_city":
			$sql = "SELECT DISTINCT city FROM ".$tableuser." ORDER BY city";
			$result = $data->query($sql);
			echo '<option value="0">Todos las Ciudades</option>';
			while( $row=mysql_fetch_array($result) ){
				echo '<option value="'.$row["city"].'">'.utf8_encode($row["city"]).'</option>'.chr(13);
			}
		break;

		case "list_work":
			$sql = "SELECT DISTINCT * FROM (";
			$sql.= "SELECT `work` as `work` FROM users_representatives ";
			$sql.= "UNION ";
			$sql.= "SELECT `work_new`  as `work` FROM users_representatives WHERE `work`='+' ";
			$sql.= ") a ORDER BY `work`";
			$result = $data->query($sql);
			
			echo '<option value="0">Todos los Trabajos</option>';
			while( $row=mysql_fetch_array($result) ){
				echo '<option value="'.$row["work"].'">'.utf8_encode($row["work"]).'</option>'.chr(13);
			}
		break;

		case "list_competition_category":
			$sql = "SELECT DISTINCT * FROM (";
			$sql.= "SELECT `competition_category` as `competition_category` FROM users_club ";
			$sql.= "UNION ";
			$sql.= "SELECT `competition_new_category`  as `competition_category` FROM users_club WHERE `competition_category`='+' ";
			$sql.= ") a ORDER BY `competition_category`";
			$result = $data->query($sql);
			
			echo '<option value="0">Todas las Categor&iacute;as</option>';
			while( $row=mysql_fetch_array($result) ){
			
				echo '<option value="'.$row["competition_category"].'">'.utf8_encode($row["competition_category"]).'</option>'.chr(13);
			}
		break;
		
		case "list_position":
			$sql = "SELECT * FROM list_position l ";
			$sql.= "INNER JOIN profile_sport p ON l.codposition = p.codposition";
			$result = $data->query($sql);
			echo '<option value="0">Todas las Posiciones</option>';
			while( $row=mysql_fetch_array($result) ){			
				echo '<option value="'.$row["codposition"].'">'.utf8_encode($row["name"]).'</option>'.chr(13);
			}
		break;
	}	
}
?>