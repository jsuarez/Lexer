<?
include("../../configure.php");
include("../../connection/connection.php");
include("../../php/constructor_profile_sport.php");

session_start();

switch( $_GET["action"] ){
	case "new_profilesport":
		$sql = "INSERT INTO `profile_sport` (`coduser`,`codsport`,`level`, `leg_habil`, `hand_habil`, `pase`,`pase_description`, `codposition`, `codpositionavanzada`, `alc_bloqueo`, `alc_ataque`, `alc_parado`, `codbestshot`,`other_bestshot`, `ent_fisico`, `ent_gim`, `ent_tactico`, `ent_tecnico`, `codsel`,`other_sel`, `codability`,`other_ability`, `available_resources`, `codmod`,`other_mod`, `rank_int`, `rank_nac`, `rank_nombre`,`rank_nombre_num`, `codcategory`,`other_category`, `international_debut`, `alcance`, `years_playing`, `prof_desde`, `gainings`, `playing_from`,`playing_up`, `primera_liga_debut`, `speciality`,`other_speciality`, `discipline`,`other_discipline`, `position_court`, `pala`, `partner`, `swimming_from`, `current_coach`, `years_climbing`, `license`, `experience_abroad`, `affliction`, `codope`,`other_operation`, `representative`, `professional_objective`)";
		$sql.= " VALUES( ";
		$sql.= 	 	$_SESSION["coduser"].",";
		$sql.= 	 	$_POST["cboListSports"]	.",";
		$sql.= 	 	$_POST["opt_level"]	.",";
		$sql.=		$data->get_data($_POST["cboLegHabil"])	.",";
		$sql.=		$data->get_data($_POST["cboHandHabil"])	.",";
		$sql.=		$data->get_data($_POST["cbo_pase"])	.",";
		$sql.=		"'".	$_POST["txtPass_description"]	."',";
		$sql.=		$data->get_data($_POST["cbo_posicion"])	.",";
		$sql.=		$data->get_data($_POST["cbo_posicion_avanzada"])	.",";
		$sql.=		"'".	$_POST["txt_alc_bloqueo"]	."',";
		$sql.=		"'".	$_POST["txt_alc_ataque"]	."',";
		$sql.=		"'".	$_POST["txt_alc_parado"]	."',";
		
		$sql.= 		$_POST["cbo_golpe"]!="+" ? $data->get_data($_POST["cbo_golpe"])."," : "NULL,";
		$sql.=		"'".	$_POST["txt_other_shot"]	."',";
		
		$sql.=		$data->get_data($_POST["txt_ent_fisico"])	.",";
		$sql.=		$data->get_data($_POST["txt_ent_gim"])	.",";
		$sql.=		$data->get_data($_POST["txt_ent_tactico"])	.",";
		$sql.=		$data->get_data($_POST["txt_ent_tecnico"])	.",";
		
		$sql.= 		$_POST["cbo_seleccionado"]!="+" ? $data->get_data($_POST["cbo_seleccionado"])."," : "NULL,";
		$sql.=		"'".	$_POST["txt_other_seleccionado"]	."',";
		
		$sql.= 		$_POST["cbo_mayor_habilidad"]!="+" ? $data->get_data($_POST["cbo_mayor_habilidad"])."," : "NULL,";
		$sql.=		"'".	$_POST["txt_other_ability"]	."',";
		
		$sql.=		$data->get_data($_POST["opc_rec_disp"])	.",";
		
		$sql.= 		$_POST["cbo_modalidad"]!="+" ? $data->get_data($_POST["cbo_modalidad"])."," : "NULL,";
		$sql.=		"'".	$_POST["txt_otro_modality"]	."',";
		
		$sql.=		$data->get_data($_POST["txt_rank_int"])	.",";
		$sql.=		$data->get_data($_POST["txt_rank_nac"])	.",";
		$sql.=		"'".	$_POST["txt_rank_nombre"]	."',";
		$sql.=		$data->get_data($_POST["txt_rank_num"])	.",";
		
		$sql.= 		$_POST["cboCategory"]!="+" ? $data->get_data($_POST["cboCategory"])."," : "NULL,";
		$sql.=		"'".	$_POST["txt_otro_category"]	."',";
		
		$sql.=		$data->get_data($_POST["txt_debut_internacional"])	.",";
		$sql.=		$data->get_data($_POST["txt_alcance"])	.",";
		$sql.=		$data->get_data($_POST["txt_anios_jugando"])	.",";
		$sql.=		$data->get_data($_POST["txt_prof_anio"])	.",";
		$sql.=		$data->get_data($_POST["txt_ganancias_uss"])	.",";
		$sql.=		$data->get_data($_POST["txt_anios_jugando_desde"])	.",";
		$sql.=		$data->get_data($_POST["txt_anios_jugando_hasta"])	.",";
		$sql.=		$data->get_data($_POST["txt_debut"]).",";
		
		$sql.= 		$_POST["cbo_especialidad"]!="+" ? $data->get_data($_POST["cbo_especialidad"])."," : "NULL,";
		$sql.=		"'".	$_POST["txt_other_especialidad"]	."',";
		
	
		$sql.=		$data->get_data($_POST["cbo_disciplina"])	.",";
		$sql.=		"'".	$_POST["txt_otro_disciplina"]."',";
		$sql.=		"'".	$_POST["txt_posicion_cancha"]	."',";
		$sql.=		"'".	$_POST["txt_pala"]."',";
		$sql.=		"'".	$_POST["txt_companiero"]	."',";
		$sql.=		$data->get_data($_POST["txt_nadando_desde"])	.",";
		$sql.=		"'".	$_POST["txt_entrenador"]	."',";
		$sql.=		$data->get_data($_POST["txt_anios_escalando"])	.",";
		$sql.=		"'".	$_POST["txt_licencia"]	.",";
		$sql.=		$data->get_data($_POST["optExperience"])	.",";
		
		$sql.=		$data->get_data($_POST["cboAffiction"])	.",";
		$sql.= 		$_POST["cboListOperations"]!="+" ? $data->get_data($_POST["cboListOperations"])."," : "NULL,";
		$sql.=		"'".	$_POST["txt_other_operation"]	."',";
		
		
		$sql.=		"'".	$_POST["txt_rep"]	."',";
		$sql.=		"'".	$_POST["txt_objetivo"]	."'";
		$sql.= ")";
		$codprofsport = $data->query($sql);
	
		//Insert para los paises de profile sport
		
		$country_sel = explode(',', $_POST["country_sel"]);
		
		$sql = "INSERT INTO `profilesport_to_country` (`codprofsport`,`codcountry`) VALUES";
		
		foreach( $country_sel as $codcountry ){
			$sql.= "( ";
			$sql.=	"".	$codprofsport	.",";
			$sql.=	"". $codcountry ."";
			$sql.= "),";
		}
		$sql= substr($sql, 0, -1);
		$data->query($sql);
		
		
		
		die("newprofilesport_ok");
	
	break;
	case "upd_profilesport":
		$sql = "UPDATE profile_sport SET ";
		$sql.= "`codsport` 				= '". $_POST["cboListSports"] ."',";
		$sql.= "`level` 				= '". $_POST["opt_level"] ."',";
		$sql.= "`leg_habil` 			= 	". $data->get_data($_POST["cboLegHabil"]).",";
		$sql.= "`hand_habil` 			= 	". $data->get_data($_POST["cboHandHabil"]).",";
		$sql.= "`pase` 					= 	". $data->get_data($_POST["cbo_pase"])	.",";
		$sql.= "`pase_description` 		= '". $_POST["txtPass_description"] ."',";
		$sql.= "`codposition` 			= 	". $data->get_data($_POST["cbo_posicion"]).",";
		$sql.= "`codpositionavanzada` 	=	". $data->get_data($_POST["cbo_posicion_avanzada"]).",";
		$sql.= "`alc_bloqueo` 			= '".	$_POST["txt_alc_bloqueo"]."',";
		$sql.= "`alc_ataque` 			= '". $_POST["txt_alc_ataque"] ."',";
		$sql.= "`alc_parado` 			= '". $_POST["txt_alc_parado"] ."',";
		$sql.= $_POST["cbo_golpe"]!="+" ? "`codbestshot`=".$data->get_data($_POST["cbo_golpe"])."," : "`codbestshot` = NULL,";
		$sql.= "`other_bestshot` 		= '". $_POST["txt_other_shot"] ."',";
		$sql.= "`ent_fisico` 			= 	". $data->get_data($_POST["txt_ent_fisico"]).",";
		$sql.= "`ent_gim` 				=	". $data->get_data($_POST["txt_ent_gim"]).",";
		$sql.= "`ent_tactico` 			= 	". $data->get_data($_POST["txt_ent_tactico"]).",";
		$sql.= "`ent_tecnico` 			= 	". $data->get_data($_POST["txt_ent_tecnico"]).",";
		$sql.= $_POST["cbo_seleccionado"]!="+" ? "`codsel`=".$data->get_data($_POST["cbo_seleccionado"])."," : "`codsel`= NULL,";
		$sql.= "`other_sel` 			= '". $_POST["txt_other_seleccionado"] ."',";
		$sql.= $_POST["cbo_modalidad"]!="+" ? "`codability`= ".$data->get_data($_POST["cbo_modalidad"])."," : "`codability`= NULL,";
		$sql.= "`other_ability`			= '". $_POST["txt_other_ability"] ."',";
		$sql.= "`available_resources` 	= 	". $data->get_data($_POST["opc_rec_disp"]).",";
		$sql.= $_POST["cbo_modalidad"]!="+" ? "`codmod`=".$data->get_data($_POST["cbo_modalidad"])."," : "`codmod` = NULL,";
		$sql.= "`other_mod` 			= '". $_POST["txt_otro_modality"] ."',";
		$sql.= "`rank_int` 				= 	". $data->get_data($_POST["txt_rank_int"] ).",";
		$sql.= "`rank_nac` 				= 	". $data->get_data($_POST["txt_rank_nac"] ).",";
		$sql.= "`rank_nombre` 			= '". $_POST["txt_rank_nombre"] ."',";
		$sql.= "`rank_nombre_num` 		= 	". $data->get_data($_POST["txt_rank_num"]).",";
		$sql.= $_POST["cboCategory"]!="+" ? "`codcategory`=".$data->get_data($_POST["cboCategory"])."," : "`codcategory` = NULL,";
		$sql.= "`other_category` 		= '". $_POST["txt_otro_category"] ."',";
		$sql.= "`international_debut`	= 	". $data->get_data($_POST["txt_debut_internacional"]) .",";
		$sql.= "`alcance` 				= 	". $data->get_data($_POST["txt_alcance"]) .",";
		$sql.= "`years_playing` 		= 	". $data->get_data($_POST["txt_anios_jugando"]) .",";
		$sql.= "`prof_desde` 			= 	". $data->get_data($_POST["txt_prof_anio"]) .",";
		$sql.= "`gainings`				= 	". $data->get_data($_POST["txt_ganancias_uss"]) .",";
		$sql.= "`playing_from`			= 	". $data->get_data($_POST["txt_anios_jugando_desde"]) .",";
		$sql.= "`playing_up` 			= 	". $data->get_data($_POST["txt_anios_jugando_hasta"]) .",";
		$sql.= "`primera_liga_debut` 	= 	". $data->get_data($_POST["txt_debut"]) .",";
		$sql.= $_POST["cboListOperations"]!="+" ? "`speciality`=".$data->get_data($_POST["cboListOperations"])."," : "`speciality` = NULL,";
		$sql.= "`other_speciality` 		= '". $_POST["txt_other_especialidad"] ."',";
		$sql.= "`discipline` 			= ". $data->get_data($_POST["cbo_disciplina"]).",";
		$sql.= "`other_discipline`		= '". $_POST["txt_otro_disciplina"]."',";
		$sql.= "`position_court` 		= '". $_POST["txt_posicion_cancha"] ."',";
		$sql.= "`pala`					= '". $_POST["txt_pala"] ."',";
		$sql.= "`partner` 				= '". $_POST["txt_companiero"] ."',";
		$sql.= "`swimming_from` 		= '". $_POST["txt_nadando_desde"] ."',";
		$sql.= "`current_coach`			= '". $_POST["txt_entrenador"] ."',";
		$sql.= "`years_climbing` 		= ". $data->get_data($_POST["txt_anios_escalando"]) .",";
		$sql.= "`license` 				= '". $_POST["txt_licencia"] ."',";
		$sql.= "`experience_abroad` 	= 	". $data->get_data($_POST["optExperience"]) .",";
		$sql.= "`affliction` 			= 	". $data->get_data($_POST["cboAffiction"]).",";
		$sql.= $_POST["cboListOperations"]!="+" ? "`codope`=". $data->get_data($_POST["cboListOperations"])."," : "`codope` = NULL,";
		$sql.= "`other_operation` 		= '". $_POST["txt_other_operation"] ."',";
		$sql.= "`representative` 		= '". $_POST["txt_rep"] ."',";
		$sql.= "`professional_objective`= '". $_POST["txt_objetivo"] ."'";
		
		$sql.= " WHERE codprofsport = ".$_POST["codprofsport"];

		$data->query($sql);
		
		//Para el caso de Experiencia en el exterior.
		if ($data->get_data($_POST["optExperience"])=="NULL"){
			//Sin experiencia elimina la experiencia.
			$data->query("DELETE FROM profilesport_to_country WHERE codprofsport=".$_POST["codprofsport"]);	
		}else{
			//Tiene experiencia y se actualiza.
			$data->query("DELETE FROM profilesport_to_country WHERE codprofsport=".$_POST["codprofsport"]);	
			
			//Insert para los paises de profile sport
			$country_sel = explode(',', $_POST["country_sel"]);
			
			$sql = "INSERT INTO `profilesport_to_country` (`codprofsport`,`codcountry`) VALUES";
			
			foreach( $country_sel as $codcountry ){
				$sql.= "( ";
				$sql.=	"".	$_POST["codprofsport"]	.",";
				$sql.=	"". $codcountry ."";
				$sql.= "),";
			}
			$sql= substr($sql, 0, -1);
			$data->query($sql);
		}
			
		die("updprofilesport_ok");
	break;
	
	case "lesion_new":
		if( $data->consult("list_lesions", "name", $_POST["name"]) ) die("exists");
		
		$code = $data->query("INSERT INTO list_lesions(name) VALUES('". $_POST["name"] ."')");
		echo $code;
		die();
	break;
	
	case "lesion_edit":
		$veri = $data->get_result("SELECT 1 FROM list_lesions WHERE name='".$_POST["name"]."' and codlesion<>".$_POST["codlesion"]);
		if( $veri!="N/A") die("exists");
		
		$data->query("UPDATE list_lesions SET name='".$_POST["name"]."' WHERE codlesion=".$_POST["codlesion"]);		
	break;
	
	case "lesion_delete":
		$data->query("DELETE FROM list_lesions WHERE codlesion=".$_POST["codlesion"]);
	break;
	
	case "category_boxeo": ?>
		<div class="cell1"><span class="required">*</span>Categor&iacute;a</div>
		        <div class="cell2">
		        	<? $rst = $data->query("SELECT * FROM list_category 
					where codsport =".$_GET["codsport"]." AND ".
					"level = ".$_GET["level"]." 
					ORDER BY name");?>
			       	<select class="validator {v_required:true}" name="cboCategory">
			         <option value="0">Seleccione Categor&iacute;a</option>
			          <? while( $row=mysql_fetch_array($rst) ){?>
			                <option value="<? echo $row["codcategory"];?>"><? echo utf8_encode($row["name"]);?></option>
			            <? }?>
			        </select>
		</div>  
	<?php
	die();
	break;
	
	case "otro_golpe": ?>
		<div class="cell1">Otro Golpe</div>
		<div class="cell2"><input type="text" class="inputbox"  name="txt_other_shot" value="<? echo $result["typedoc_new"];?>" /></div>
	<?php
	die();
	break;
		
	case "sport_pass":
		$CODSPORT=$_GET["codsport"];
		switch($CODSPORT){
			case "1": 
			// ========= Datos Sport Futbol =========
				// ========= Pierna Habil =========
				get_html("pierna_habil");
				
				// ========= MI pase pertenece =========
				get_html("mipase");
				
				// ========= Posicion =========
				get_html("posicion");
				
				// ========= Posicion =========
				get_html("posicion_avanzada");
			// ========= Fin Datos Sport Futbol =========
		    break;
			case "2":
			// ========= Datos Sport Futbol Americano =========
				// ========= MI pase pertenece =========
					get_html("mipase");
				// ========= Posicion =========
					get_html("posicion");
			// ========= Fin Datos Sport Futbol Americano =========
		    break;
			case "3": 
			// ========= Datos Sport Futbol de Salon =========
					// ========= MI pase pertenece =========
						get_html("mipase");
					// ========= Pierna Habil =========
						get_html("pierna_habil");
					// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos Sport Futbol de Salon =========
		    break;
			case "4":
			// ========= Datos Datos Sport VOLEY =========
					// ========= MI pase pertenece =========
						get_html("mipase");
					// ========= Alcance =========
						get_html("alcances");
					// ========= Debut Internacional =========
						get_html("debut_internacional"); 
					// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos Sport VOLEY =========
		    break;
			case "5":
			// ========= Datos Sport Voley de Playa =========
					// ========= MI pase pertenece =========
						get_html("mipase");
			// ========= Fin Datos Sport Voley de Playa =========					
		    break;
			case "6":
			// ========= Datos Sport RUGBY =========
					// ========= Mejor Golpe =========
						get_html("mejor_golpe");
					// ========= Alcance =========
						get_html("alcance");
		    		// ========= Entrenamientos =========
						get_html("entrenamientos");
					// ========= MI pase pertenece =========
						get_html("mipase");
					// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos Sport RUGBY =========
		    break;
			case "7":
			// ========= Datos Sport Softbol =========
					// ========= MI pase pertenece =========
						get_html("mipase");
					// ========= Mano habil =========	
						get_html("mano_habil");
					// ========= Seleccionado =========	
						get_html("seleccionado");
					// ========= Mayor Habilidad =========	
						get_html("mayor_habilidad");
					// ========= Entrenamientos =========
						get_html("entrenamientos");
					// ========= Años Jugando =========
						get_html("anios_jugando");
    				// ========= Posicion =========
						get_html("posicion");
    		// ========= Fin Datos Sport Softbol =========
		    break;
			case "8":
			// ========= Datos Sport TENIS =========
					// ========= MI pase pertenece =========
						get_html("mipase");
					// ========= Mano habil =========	
						get_html("mano_habil");
					// ========= Modalidad =========	
						get_html("modalidad");	
					// ========= Rankings =========	
						get_html("rankings");
					// ========= Seleccionado =========	
						get_html("seleccionado");
					// ========= Profesional desde =========	
						get_html("profesional");
					// ========= Ganancias =========	
						get_html("ganancias");	
    				// ========= Entrenamientos =========
						get_html("entrenamientos");
			// ========= Fin Datos TENIS =========
		    break;
			case "9":
			// ========= Datos Sport TENIS MESA =========
				// ========= MI pase pertenece =========
						get_html("mipase");
				// ========= Mano habil =========	
						get_html("mano_habil");
				// ========= Modalidad =========	
						get_html("modalidad");
				// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos TENIS MESA =========	
		    break;
			case "10":
			// ========= Datos Sport HOCKEY SOBRE CESPED =========
				// ========= Rankings =========	
						get_html("jugando_desde");
    			// ========= Seleccionado =========	
						get_html("seleccionado");
				// ========= Debut en primera =========			
						get_html("debut_primera");
				// ========= Debut Internacional =========
						get_html("debut_internacional"); 	
    			// ========= Mejor Golpe =========
						get_html("mejor_golpe");
				// ========= Entrenamientos =========
						get_html("entrenamientos");
				// ========= Rankings =========	
						get_html("rankings");
				// ========= MI pase pertenece =========
						get_html("mipase");
				// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos HOCKEY SOBRE CESPED =========	
		    break;
			case "11":
			// ========= Datos Sport HOCKEY SOBRE HIELO =========
				// ========= Posicion =========
						get_html("posicion");
			// ========= FIN Datos Sport HOCKEY SOBRE HIELO =========
			break;
			case "12":
			// ========= Datos Sport HOCKEY SOBRE PATINES =========
				// ========= Posicion =========
						get_html("posicion");
			// ========= FIN Datos Sport HOCKEY SOBRE PATINES =========
		    break;
			case "13":
			// ========= Datos Sport HANDBALL =========
				// ========= MI pase pertenece =========
						get_html("mipase");
				// ========= Mano habil =========	
						get_html("mano_habil");
				// ========= Seleccionado =========	
						get_html("seleccionado");
				// ========= Rankings =========	
						get_html("rankings");
				// ========= Entrenamientos =========
						get_html("entrenamientos");
				// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos Sport HANDBALL =========
		    break;
			case "14":
			// ========= Datos Sport GOLF =========
				// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos GOLF =========
		    break;
			case "15":
			// ========= Datos Sport CICLISMO =========
				// ========= Especialidad =========	
						get_html("especialidad");
				// ========= Rankings =========	
						get_html("categoria");
				// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos Sport CICLISMO =========
		    break;
			case "16":
			// ========= Datos Sport BOXEO =========
				// ========= Mano habil =========	
						get_html("mano_habil");
			?>
			<!-- Dato Categoria -->
            <li id="category">
		    </li>
    		<!-- Fin Dato Categoria -->
    		<?php
    			// ========= Mano habil =========	
						get_html("licencia");
    			// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos Sport BOXEO =========
		    break;
			case "17":
			// ========= Datos Sport ATLETISMO =========
				// ========= Rankings =========	
						get_html("disciplina");
    			// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos Sport ATLETISMO =========
		    break;
			case "18":
			// ========= Datos Sport AUTOMOVILISMO =========
				// ========= Modalidad =========	
						get_html("modalidad");
				// ========= Rankings =========	
						get_html("rankings");
			// ========= FIn Datos Sport AUTOMOVILISMO =========
		    break;
			case "19":
			// ========= Datos Sport MOTOCICLISMO =========
				// ========= Modalidad =========	
						get_html("modalidad");
				// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos Sport MOTOCICLISMO =========
		    break;
			case "20":
			// ========= Datos Sport BASQUET =========
				// ========= MI pase pertenece =========
						get_html("mipase");
				// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos Sport BASQUET =========
		    break;
			case "21":
			// ========= Datos Sport BEISBOL =========
				// ========= MI pase pertenece =========
						get_html("mipase");
				// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos Sport BEISBOL =========
		    break;
			case "22":
			// ========= Datos Sport WATERPOLO =========
				// ========= MI pase pertenece =========
						get_html("mipase");
				// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos Sport WATERPOLO =========
		    break;
			case "23":
			// ========= Datos Sport PÁDLE =========
				// ========= Mano habil =========	
						get_html("mano_habil");
				// ========= Posicion en Cancha =========	
						get_html("posicion_cancha");
				// ========= Pala =========
						get_html("pala");
    			// ========= Mano habil =========	
						get_html("mano_habil");
				// ========= Mejor Golpe =========
						get_html("mejor_golpe");
				// ========= Compañero =========
						get_html("companiero");
    			// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos Sport PÁDLE =========
		    break;
			case "24":
			// ========= Datos Sport NATACIÓN =========
				// ========= Seleccionado =========	
						get_html("seleccionado");
				// ========= Nadando desde =========	
						get_html("nadando_desde");
				// ========= Nadando desde =========	
						get_html("entrenador");
    			// ========= Modalidad =========	
						get_html("modalidad");
				// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos Sport NATACIÓN =========
		    break;
			case "25":
			// ========= Datos Sport ESCALADA DEPORTIVA =========
				// ========= Años Escalando =========	
						get_html("anios_escalando");
    			// ========= Rankings =========	
						get_html("rankings");
				// ========= Modalidad =========	
						get_html("modalidad");
		    break;
		}
	die ();
	break;
	
		
}
die("ok");
?>