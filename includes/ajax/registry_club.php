<?
include("../../configure.php");
include("../../connection/connection.php");
include("../../js/catcha/securimage.php");
include("../../classphp/class.sendmail.php");
if( $_GET["action"]=="new" ) include("registry_user.php");


switch( $_GET["action"] ){
case "new":
	$img = new Securimage();
	if( !$img->check($_POST['code']) ) die("code invalid");

	$coduser = $User->insert(array('email' => $_POST["txt_reg_Email"], 
								   'pass'  => $_POST["txt_reg_Pass"], 
								   'newsletters' => $_POST["chkNewsletters"],
								   'tableusers'  => "users_club"));
	
	$data->query("UPDATE users SET id='".md5($coduser)."' WHERE coduser=".$coduser);

	$sendmail = new Class_SendMail();
	$sendmail->from = REGISTER_EMAIL_FROM;
	$sendmail->name_from = REGISTER_NAME_FROM;
	$sendmail->to = $_POST["txt_reg_Email"];
	$sendmail->subject = REGISTER_SUBJECT;
	$sendmail->message = sprintf(REGISTER_MESSAGE, md5($coduser));
	
	if( $sendmail->send() ){
		$sql = "INSERT INTO users_club(coduser, `business_name`, `cuit`, `fundation_years`, `president`, `name_stadium`, `addresse_sede`, `country`, `province`, `city`, `cp`, `phone_pref1`, `phone_pref2`, `phone`, `cel_pref1`, `cel_pref2`, `cel`, `competition_category`, `competition_new_category`, `titular_lastname`, `titular_firstname`, `titular_charge`, `titular_phone_pref1`, `titular_phone_pref2`, `titular_phone`, `titular_cel_pref1`, `titular_cel_pref2`, `titular_cel`, `titular_typedoc`, `titular_typedoc_new`, `titular_nrodoc`) ";
		$sql.= "VALUES(";
		$sql.= 		$coduser .",";
		$sql.= "'". $_POST["txt_reg_SocialReason"] ."',";
		$sql.= "'". $_POST["txt_reg_Cuit"] ."',";
		$sql.= 		$_POST["txt_reg_YearFoundation"] .",";
		$sql.= "'". $_POST["txt_reg_president"] ."',";
		$sql.= "'". $_POST["txt_reg_stadium"] ."',";
		$sql.= "'". $_POST["txt_reg_LocationHome"] ."',";
		$sql.= 		$_POST["codcountry"] .",";
		$sql.= 		$_POST["codprovince"] .",";
		$sql.= "'". $_POST["txt_reg_City"] ."',";
		$sql.= 		$data->get_data($_POST["txt_reg_CP"]) .",";
		$sql.= 		$data->get_data($_POST["txt_reg_phone_pref1"]) .",";
		$sql.= 		$data->get_data($_POST["txt_reg_phone_pref2"]) .",";
		$sql.= 		$_POST["txt_reg_phone_num"] .",";
		$sql.= 		$data->get_data($_POST["txt_reg_cel_pref1"]) .",";
		$sql.= 		$data->get_data($_POST["txt_reg_cel_pref2"]) .",";
		$sql.=		$data->get_data($_POST["txt_reg_cel_num"]) .",";
		$sql.= "'". $_POST["cbo_reg_CompetitionCategory"] ."',";
		$sql.= "'". $_POST["txt_reg_competetion_other"] ."',";
		$sql.= "'". $_POST["txt_reg_tit_LastName"] ."',";
		$sql.= "'". $_POST["txt_reg_tit_FirstName"] ."',";
		$sql.= "'". $_POST["txt_reg_tit_charge"] ."',";
		$sql.=		$data->get_data($_POST["txt_reg_tit_phone_pref1"]) .",";
		$sql.=		$data->get_data($_POST["txt_reg_tit_phone_pref2"]) .",";
		$sql.= 		$_POST["txt_reg_tit_phone_num"] .",";
		$sql.= 		$data->get_data($_POST["txt_reg_tit_cel_pref1"]) .",";
		$sql.= 		$data->get_data($_POST["txt_reg_tit_cel_pref2"]) .",";
		$sql.= 		$data->get_data($_POST["txt_reg_tit_cel_num"]) .",";
		$sql.= "'".	$_POST["cbo_reg_tit_TypeDoc"] ."',";
		$sql.= "'".	$_POST["txt_reg_tit_typedoc_other"] ."',";
		$sql.= "'".	$_POST["txt_reg_tit_nrodoc"]  ."'";
		$sql.= ")";
		$codclub = $data->query($sql);
		
		//--Guarda el listado de deportes seleccionados
		$codsports = explode(",", $_POST["codsports"]);
		$sql = "INSERT INTO users_club_to_sport(codclub, codsport) VALUES";
		for( $n=0; $n<=count($codsports)-2; $n++ ){
			$sql.="(".$codclub.",".$codsports[$n]."),";
		}
		$sql = substr($sql, 0, strlen($sql)-1);
		$data->query($sql);
				
		die("sendmail_ok");
	}else {
		$data->query("DELETE FROM users WHERE coduser=".$coduser);
		die("sendmail_error");
	}
break;

case "edit":
	$sql = "UPDATE users_club SET ";
	$sql.= "`business_name` = '". $_POST["txt_reg_SocialReason"] ."',";
	$sql.= "`cuit` = '". $_POST["txt_reg_Cuit"] ."',";
	$sql.= "`fundation_years` = ". $_POST["txt_reg_YearFoundation"] .",";
	$sql.= "`president` = '". $_POST["txt_reg_president"] ."',";
	$sql.= "`name_stadium` = '". $_POST["txt_reg_stadium"] ."',";
	$sql.= "`addresse_sede` = '". $_POST["txt_reg_LocationHome"] ."',";
	$sql.= "`country` = ". $_POST["codcountry"] .",";
	$sql.= "`province` = ". $_POST["codprovince"] .",";
	$sql.= "`city` = '". $_POST["txt_reg_City"] ."',";
	$sql.= "`cp` = ". $data->get_data($_POST["txt_reg_CP"]) .",";
	$sql.= "`phone_pref1` = ". $data->get_data($_POST["txt_reg_phone_pref1"]) .",";
	$sql.= "`phone_pref2` = ". $data->get_data($_POST["txt_reg_phone_pref2"]).",";
	$sql.= "`phone` = ". $_POST["txt_reg_phone_num"] .",";
	$sql.= "`cel_pref1` = ". $data->get_data($_POST["txt_reg_cel_pref1"]) .",";
	$sql.= "`cel_pref2` = ". $data->get_data($_POST["txt_reg_cel_pref2"]) .",";
	$sql.= "`cel` = ". $data->get_data($_POST["txt_reg_cel_num"]) .",";
	
	$sql.= "`competition_category` = '". $_POST["cbo_reg_CompetitionCategory"] ."',";
	$sql.= "`competition_new_category` = '". $_POST["txt_reg_competetion_other"] ."',";
	$sql.= "`titular_lastname` = '". $_POST["txt_reg_tit_LastName"] ."',";
	$sql.= "`titular_firstname` = '". $_POST["txt_reg_tit_FirstName"] ."',";
	$sql.= "`titular_charge` = '". $_POST["txt_reg_tit_charge"] ."',";

	$sql.= "`titular_phone_pref1` = ". $data->get_data($_POST["txt_reg_tit_phone_pref1"]) .",";
	$sql.= "`titular_phone_pref2` = ". $data->get_data($_POST["txt_reg_tit_phone_pref2"]).",";
	$sql.= "`titular_phone` = ". $_POST["txt_reg_tit_phone_num"] .",";
	$sql.= "`titular_cel_pref1` = ". $data->get_data($_POST["txt_reg_tit_cel_pref1"]) .",";
	$sql.= "`titular_cel_pref2` = ". $data->get_data($_POST["txt_reg_tit_cel_pref2"]) .",";
	$sql.= "`titular_cel` = ". $data->get_data($_POST["txt_reg_tit_cel_num"]) .",";

	$sql.= "`titular_typedoc` = '". $_POST["cbo_reg_tit_TypeDoc"] ."',";
	$sql.= "`titular_typedoc_new` = '". $_POST["txt_reg_tit_typedoc_other"] ."',";
	$sql.= "`titular_nrodoc` = '". $_POST["txt_reg_tit_nrodoc"] ."' ";
		
	$sql.= "WHERE coduser = ".$_POST["coduser"];
	$data->query($sql);


	//--Actualiza el listado de deportes seleccionados
	$codclub = $data->get_result("SELECT codclub FROM users_club WHERE coduser=".$_POST["coduser"]);
	$data->query("DELETE FROM users_club_to_sport WHERE codclub = ".$codclub[0]);

	$codsports = explode(",", $_POST["codsports"]);
	$sql = "INSERT INTO users_club_to_sport(codclub, codsport) VALUES";
	for( $n=0; $n<=count($codsports)-2; $n++ ){
		$sql.="(".$codclub[0].",".$codsports[$n]."),";
	}
	$sql = substr($sql, 0, strlen($sql)-1);
	$data->query($sql);

	die("ok_edit");
break;

case "delete":
break;
}

die("ok");
?>