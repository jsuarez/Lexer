<?php
chdir("../../../");
include("configure.php");
include("connection/connection.php");
include("php/functions.php");

switch ($_POST["cboCategory"]){				
	case "1": //////////////////////////// DEPORTISTA ////////////////////////////
		
		$sql = "SELECT ";
		$sql.=			"s.codsport,";
		$sql.=			"CONCAT(s.firstname,', ',s.lastname) AS name,";
		$sql.=			"CASE s.sex WHEN 1 THEN 'Masculino' ELSE 'Femenino' END AS sex,";
		$sql.=			"s.`birth` AS birth_sport,"; 
		$sql.=			"f_getage(s.`birth`) AS age,"; 
		$sql.=			"(SELECT name FROM list_sports WHERE p.codsport=codsport) as sport,";
		$sql.=			"(SELECT name FROM list_country WHERE s.country=codcountry) as country_name,";
		$sql.=			"(SELECT name FROM list_provinces WHERE s.province=codprovince) as province_name,";
		
		if( isset($_POST["chkMovie"]) ) $sql.= "(SELECT count(*) FROM movies WHERE p.coduser=movies.coduser) as count_movies,";
		if( isset($_POST["chkPhoto"]) ) $sql.= "(SELECT count(*) FROM images WHERE p.coduser=images.coduser) as count_images,";
		
		$sql.=			"s.city,";
		$sql.=			"p.codcategory,";
		$sql.=			"(SELECT name FROM list_category WHERE p.codcategory=codcategory) as category,";
		$sql.=			"p.codposition,";
		$sql.=			"(SELECT name FROM list_position WHERE p.codposition=codposition) as position,";
		$sql.=			"CASE p.leg_habil WHEN 1 THEN 'Derecha' ELSE 'Izquierda' END AS leg,";
		$sql.=			"CASE p.hand_habil WHEN 1 THEN 'Derecha' ELSE 'Izquierda' END AS hand,";
		$sql.=			"CASE s.passport WHEN 1 THEN 'Sin pasaporte' WHEN 2 THEN 'Comunitario' WHEN 3 THEN 'Extracomunitario' END AS passport ";		
		$sql.=" FROM users u";
		$sql.=" JOIN `users_sports` s ON u.coduser=s.coduser";
		$sql.=" JOIN `profile_sport` p ON u.coduser=p.coduser";
	
		$where = array();
		if( $_POST["txtName"]!="Nombre..." ) array_push($where, " s.firstname LIKE '%".$_POST["txtName"]."' OR s.lastname LIKE '%".$_POST["txtName"]."'");
		if( $_POST["cboSport"]!=0 ) array_push($where, "s.codsport = ".$_POST["cboSport"]);
		if( $_POST["cboCountry"]!=0 ) array_push($where, "s.country = ".$_POST["cboCountry"]);
		
		//Busqueda Avanzada
		if( $_POST["txtAge"]>0&&$_POST["txtAge"]!="" ) array_push($where, "age = ".$_POST["txtAge"]);
		if( $_POST["cboSex"]!=0 ) array_push($where, "s.sex = ".$_POST["cboSex"]);
		if( $_POST["cboPosition"]!=0 ) array_push($where, "p.codposition = ".$_POST["cboPosition"]);
		if( $_POST["cboCategorySport"]!=0 ) array_push($where, "p.codcategory = ".$_POST["cboCategorySport"]);	
		if( $_POST["cboLegHand"]!=0 ) array_push($where, "(p.leg_habil = ".$_POST["cboLegHand"] ." OR ". "p.hand_habil = ".$_POST["cboLegHand"].")");
		if( $_POST["cboLevel"]!=0 ) array_push($where, "p.level = ".$_POST["cboLevel"]);		
		if( $_POST["cboProvince"]!=0 ) array_push($where, "s.province = ".$_POST["cboProvince"]);
		if( $_POST["cboCity"]!="" ) array_push($where, " s.city LIKE '%".$_POST["cboCity"]."%'");
		if( $_POST["cboPassport"]!=0 ) array_push($where, "s.passport = ".$_POST["cboPassport"]);
		if( isset($_POST["chkMovie"]) ) array_push($where, "count_movies>0");
		if( isset($_POST["chkPhoto"]) ) array_push($where, "count_images>0");
		
		if( count($where)>0 ) $sql.= " WHERE ".implode(" AND ", $where);
		
		$sql.= " ORDER BY name";		
		//die($sql);
		
		$browsing = new class_browsing($data);
		$rstList = $browsing->get_query($sql);
	
		while( $row=mysql_fetch_array($rstList)){?>
        
			<div class="anunciante">
				<div class="imganunciante"><img src="images/images.jpg" height="100" alt="" /></div>
				<div class="datosanunciante">
					<h3><?php echo utf8_encode($row["name"]);?></h3>
				
					<div class="datosanunciante_list">                        
						<span>Edad: </span><?php echo $row["age"];?><br>
						<!--<span>Peso: </span><?php //echo utf8_encode($row["birth_sport"]);?><br>
						<span>Altura: </span><?php //echo utf8_encode($row["birth_sport"]);?><br>-->
						<span>Sexo: </span><?php echo utf8_encode($row["sex"]);?><br>
					</div>
					
					<div class="datosanunciante_list">
						<span>Deporte: </span><?php echo utf8_encode($row["sport"]);?><br>
						<?php if (!empty ($row["category"])){ ?><span>Categor&iacute;a: </span><?php echo utf8_encode($row["category"]);?><br> <?php }?>
						<?php if (!empty ($row["position"])){ ?><span>Posici&oacute;n: </span><?php echo utf8_encode($row["position"]);?><br><?php }?>
						<span>Pierna/Mano: </span><?php echo utf8_encode($row["leg"])." / ";?><?php echo utf8_encode($row["hand"]);?><br>
					</div>
					
					<div class="datosanunciante_list">                            
						<span>Pa&iacute;s: </span><?php echo utf8_encode($row["country_name"]);?><br>
						<span>Provincia: </span><?php echo utf8_encode($row["province_name"]);?><br>
						<span>Ciudad: </span><?php echo utf8_encode($row["city"]);?><br>
						<span>Pasoporte: </span><?php echo utf8_encode($row["passport"]);?><br>
					</div>
				</div>
				<div class="masinfo"><a href="curriculum.php?id=<?php echo $row["codsport"];?>&u=s">+ mas info</a></div>
			</div>
            
	<?php }
	break;
	
	
	case "2": //////////////////////////// REPRESENTANTE ////////////////////////////
	
		$sql = "SELECT ";
		$sql.=			"r.codrepr,";
		$sql.=			"r.work,";
		$sql.=			"r.licence_nro,";  	
		$sql.=			"CONCAT(r.firstname,', ',r.lastname) AS name,";
		$sql.=			"r.`birth` AS birth_sport,"; 
		$sql.=			"f_getage(r.`birth`) AS age,"; 
		$sql.=			"(SELECT name FROM list_country WHERE r.country=codcountry) as country_name,";
		$sql.=			"(SELECT name FROM list_provinces WHERE r.province=codprovince) as province_name,";
		$sql.=			"r.city,";
		$sql.=			"CASE r.level WHEN 1 THEN 'Profesional' WHEN 2 THEN 'Amateur' WHEN 3 THEN 'Ambos' END AS txt_level ";
		$sql.=" FROM users u";
		$sql.=" JOIN `users_representatives` r ON u.coduser=r.coduser";
		
		$where = array();
		if( $_POST["txtName"]!="Nombre..." ) array_push($where, " r.firstname LIKE '%".$_POST["txtName"]."' OR r.lastname LIKE '%".$_POST["txtName"]."'");
		if( $_POST["cboSport"]!=0 ) array_push($where, "r.codrepr in (SELECT codrepr FROM  users_representatives_to_sport rs WHERE rs.codrepr=r.codrepr AND codsport=".$_POST["cboSport"].") ");
		if( $_POST["cboCountry"]!=0 ) array_push($where, "r.country = ".$_POST["cboCountry"]);
		
		//Busqueda Avanzada
		if( $_POST["txtWork"]!=0) array_push($where, " r.work LIKE '%".$_POST["txtWork"]."%'");
		if( isset($_POST["chkLicence"]) ) array_push($where, " r.licence_nro<>''");
		if( $_POST["cboProvince"]!=0 ) array_push($where, "r.province = ".$_POST["cboProvince"]);
		if( $_POST["cboCity"]!=0 ) array_push($where, " r.city LIKE '%".$_POST["cboCity"]."%'");
		if( $_POST["cboLevel"]!=0 ) array_push($where, "r.level = ".$_POST["cboLevel"]);
		
		if( count($where)>0 ) $sql.= " WHERE ".implode(" AND ", $where);

		//die($sql);
		$browsing = new class_browsing($data);
		$rstList = $browsing->get_query($sql);

		while( $row=mysql_fetch_array($rstList) ){

                    $rst = $data->query("SELECT name FROM list_sports l INNER JOIN users_representatives_to_sport r ON l.codsport=r.codsport WHERE r.codrepr=".$row["codrepr"]);
                    $txt_sport = "";
                    while( $row2=mysql_fetch_array($rst) ){
                        $txt_sport.= $row2["name"].",";
                    }
                    $txt_sport = substr($txt_sport, 0, -1);
?>
			<div class="anunciante">
				<div class="imganunciante"><img src="images/images.jpg" height="100" alt="foto" /></div>
				<div class="datosanunciante">
					<h3><?php echo utf8_encode($row["name"]);?></h3>
					
					<div class="datosanunciante_list">                            
						<span>Edad: </span><?php echo $row["age"];?><br>
						<?php if( $txt_sport!="" ){?><span>Deporte: </span><?php echo utf8_encode($txt_sport);?><br><?php }?>
						<span>Trabajo: </span><?php echo utf8_encode($row["work"]);?><br>
						<span>Licencia: </span><?php echo utf8_encode($row["licence_nro"]);?><br>
					</div>
					<div class="datosanunciante_list">                            
						<span>Pa&iacute;s: </span><?php echo utf8_encode($row["country_name"]);?><br>
						<span>Provincia: </span><?php echo utf8_encode($row["province_name"]);?><br>
						<span>Ciudad: </span><?php echo utf8_encode($row["city"]);?><br>
						<span>Nivel: </span><?php echo utf8_encode($row["txt_level"]);?><br>
					</div>
				</div>
				<div class="masinfo"><a href="#">+ mas info</a></div>
			</div>

	<?php }	
	break;
	
	case "3":  //////////////////////////// CLUB ////////////////////////////
		$sql = "SELECT ";
		$sql.=			"c.codclub,";
		$sql.=			"c.business_name,";
		$sql.=			"(SELECT name FROM list_country WHERE c.country=codcountry) as country_name,";
		$sql.=			"(SELECT name FROM list_provinces WHERE c.province=codprovince) as province_name,";
		$sql.=			"c.city,";
		$sql.=			"c.competition_category";
		$sql.=" FROM users u";
		$sql.=" JOIN `users_club` c ON u.coduser=c.coduser";
		
		$where = array();
		if( $_POST["txtName"]!="Nombre..." ) array_push($where, " c.business_name LIKE '%".$_POST["txtName"]."%'");
		if( $_POST["cboSport"]!=0 ) array_push($where, "r.codclub in (SELECT codclub FROM  users_club_to_sport rs WHERE rs.codclub=r.codclub AND codsport=".$_POST["cboSport"].") ");
		if( $_POST["cboCountry"]!=0 ) array_push($where, "c.country = ".$_POST["cboCountry"]);
		
		//Busqueda Avanzada
		if( $_POST["cboProvince"]!=0 )array_push($where, "c.province = ".$_POST["cboProvince"]);
		if( $_POST["cboCity"]!=0 ) array_push($where, " c.city LIKE '%".$_POST["cboCity"]."%'");
		if( $_POST["cboCompetitionCategory"]!=0 ) array_push($where, " c.competition_category LIKE '%".$_POST["cboCompetitionCategory"]."%'");
		
		if( count($where)>0 ) $sql.= " WHERE ".implode(" AND ", $where);
		
		
		$browsing = new class_browsing($data);
		$rstList = $browsing->get_query($sql);

		while( $row=mysql_fetch_array($rstList) ){

                    $rst = $data->query("SELECT name FROM list_sports l INNER JOIN users_club_to_sport r ON l.codsport=r.codsport WHERE r.codclub=".$row["codclub"]);
                    $txt_sport = "";
                    while( $row2=mysql_fetch_array($rst) ){
                        $txt_sport.= $row2["name"].",";
                    }
                    $txt_sport = substr($txt_sport, 0, -1);
?>
			<div class="anunciante">
				<div class="imganunciante"><img src="images/images.jpg" height="100" alt="foto" /></div>
				<div class="datosanunciante">
					<h3><?php echo utf8_encode($row["business_name"]);?></h3>
					<div class="datosanunciante_list">                                                        
						<span>Pa&iacute;s: </span><?php echo utf8_encode($row["country_name"]);?><br>
						<span>Provincia: </span><?php echo utf8_encode($row["province_name"]);?><br>
						<span>Ciudad: </span><?php echo utf8_encode($row["city"]);?><br>
					</div>
					<div class="datosanunciante_list">                                                        
						<?php if( $txt_sport!="" ){?><span>Deporte: </span><?php echo utf8_encode($txt_sport);?><br><?php }?>
						<span>Categor&iacute;a: </span><?php echo utf8_encode($row["competition_category"]);?><br>
					</div>
				</div>
				<div class="masinfo"><a href="#">+ mas info</a></div>
			</div>
            
	<?php }?>
    
    
	<?php break;
	case "4":  //////////////////////////// SPONSOR ////////////////////////////
		$sql = "SELECT ";
		$sql.=			"sp.codsponsor,";
		$sql.=			"sp.business_name,";
		$sql.=			"i.coditem,";
		$sql.=			"i.name as rubro,";
		$sql.=			"(SELECT name FROM list_country WHERE sp.country=codcountry) as country_name,";
		$sql.=			"(SELECT name FROM list_provinces WHERE sp.province=codprovince) as province_name,";
		$sql.=			"sp.city";
		$sql.=" FROM users u";
		$sql.=" JOIN `users_sponsors` sp ON u.coduser=sp.coduser";
		$sql.=" JOIN `list_companies_items` i ON sp.coditem=i.coditem";
		
		
		$where = array();
		if( $_POST["txtName"]!="Nombre..." ) array_push($where, " sp.business_name LIKE '%".$_POST["txtName"]."%'");
        	if( $_POST["cboCountry"]!=0 ) array_push($where, "sp.country = ".$_POST["cboCountry"]);

                //Busqueda Avanzada
                if( $_POST["cboItem"]!=0) array_push($where, " i.coditem = ".$_POST["cboItem"]);
		if( $_POST["cboProvince"]!=0 )array_push($where, "sp.province = ".$_POST["cboProvince"]);
		if( $_POST["cboCity"]!=0 ) array_push($where, " sp.city LIKE '%".$_POST["cboCity"]."%'");
		
		
		if( count($where)>0 ) $sql.= " WHERE ".implode(" AND ", $where);
		
		$browsing = new class_browsing($data);
		$rstList = $browsing->get_query($sql);

		while( $row=mysql_fetch_array($rstList) ){?>

			<div class="anunciante">
				<div class="imganunciante"><img src="images/images.jpg" height="100" alt="foto" /></div>
				<div class="datosanunciante">
					<h3><?php echo utf8_encode($row["business_name"]);?></h3>
					<div class="datosanunciante_list">                                                        
						<span>Rubro: </span><?php echo utf8_encode($row["rubro"]);?><br>
						<span>Pa&iacute;s: </span><?php echo utf8_encode($row["country_name"]);?><br>
						<span>Provincia: </span><?php echo utf8_encode($row["province_name"]);?><br>
						<span>Ciudad: </span><?php echo utf8_encode($row["city"]);?><br>
					</div>
				</div>
				<div class="masinfo"><a href="#">+ mas info</a></div>
			</div>

	<?php }
	break;	
}

 if( mysql_num_rows($rstList)==0 ){?>
    <div class="anunciante">
            <div class="imganunciante">&nbsp;</div>
            <div class="datosanunciante"><h3>Disculpe, no se hallaron resultados.</h3></div>
    </div>
<?php }?>