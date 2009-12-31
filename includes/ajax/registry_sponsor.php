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
								   'tableusers'  => "users_sponsors"));
								   
	$data->query("UPDATE users SET id='".md5($coduser)."' WHERE coduser=".$coduser);

	$sendmail = new Class_SendMail();
	$sendmail->from = REGISTER_EMAIL_FROM;
	$sendmail->name_from = REGISTER_NAME_FROM;
	$sendmail->to = $_POST["txt_reg_Email"];
	$sendmail->subject = REGISTER_SUBJECT;
	$sendmail->message = sprintf(REGISTER_MESSAGE, md5($coduser));
	
	if( $sendmail->send() ){
		$sql = "INSERT INTO `users_sponsors`(`coduser`, `business_name`, `cuit`, `address`, `country`,`province`,`city`,`cp`, `phone_pref1`, `phone_pref2`, `phone`, `cel_pref1`, `cel_pref2`, `cel`, `codcompanylist`, `titular_lastname`, `titular_firstname`, `titular_charge`, `titular_phone_pref1`, `titular_phone_pref2`, `titular_phone`, `titular_cel_pref1`, `titular_cel_pref2`, `titular_cel`, `titular_typedoc`, `titular_typedoc_new`, `titular_nrodoc`,`coditem`) ";
		$sql.= "VALUES(";

		$sql.= 		$coduser  .",";
		$sql.= "'". $_POST["txt_reg_SocialReason"]  ."',";
		$sql.= "'". $_POST["txt_reg_Cuit"]  ."',";
		$sql.= "'". $_POST["txt_reg_legalAddress"]  ."',";
		
		// PAIS, PROVINCIA, CIUDAD Y CODIGO POSTAL
		$sql.= 		$_POST["codcountry"]  .",";
		$sql.= 		$_POST["codprovince"] .",";
		$sql.= "'". $_POST["txt_reg_City"]	."',";
		$sql.= 		$data->get_data($_POST["txt_reg_CP"])	.",";	
				
		//----- TELEFONO
		$sql.= 		$data->get_data($_POST["txt_reg_phone_pref1"])  .",";			
		$sql.= 		$data->get_data($_POST["txt_reg_phone_pref2"])  .",";
		$sql.= 		$_POST["txt_reg_phone_num"]	   .",";
		//-----
		
		//----- CELULAR
		$sql.= 		$data->get_data($_POST["txt_reg_cel_pref1"])   .",";	
		$sql.= 		$data->get_data($_POST["txt_reg_cel_pref2"])   .",";	
		$sql.= 		$data->get_data($_POST["txt_reg_cel_num"])	   .",";	
		//-----

		$sql.= 		$data->get_data($_POST["coditem"]) .",";
		$sql.= "'". $_POST["txt_reg_tit_LastName"]  ."',";
		$sql.= "'". $_POST["txt_reg_tit_FirstName"]  ."',";
		$sql.= "'". $_POST["txt_reg_tit_charge"]  ."',";

		//----- TELEFONO (TITULAR)
		$sql.= 		$data->get_data($_POST["txt_reg_tit_phone_pref1"])  .",";			
		$sql.= 		$data->get_data($_POST["txt_reg_tit_phone_pref1"])  .",";
		$sql.= 		$_POST["txt_reg_tit_phone_num"]	   .",";
		//-----
		
		//----- CELULAR (TITULAR)
		$sql.= 		$data->get_data($_POST["txt_reg_tit_cel_pref1"])   .",";	
		$sql.= 		$data->get_data($_POST["txt_reg_tit_cel_pref2"])   .",";	
		$sql.= 		$data->get_data($_POST["txt_reg_tit_cel_num"])	   .",";	
		//-----
		
		$sql.= "'".	$_POST["cbo_reg_tit_TypeDoc"]  ."',";
		$sql.= "'".	$_POST["txt_reg_tit_typedoc_other"]  ."',";
		$sql.= "'". $_POST["txt_reg_tit_nrodoc"]   ."',";
		$sql.= "". $data->get_data($_POST["coditem"])."";
		$sql.= ")";
		die($sql);
		$data->query($sql);
		
		die("sendmail_ok");
	}else {
		$data->query("DELETE FROM users WHERE coduser=".$coduser);
		die("sendmail_error");
	}
break;

case "edit":
	$sql = "UPDATE users_sponsors SET ";
	$sql.= "`business_name` = '". $_POST["txt_reg_SocialReason"] ."',";
	$sql.= "`cuit` = '". $_POST["txt_reg_Cuit"] ."',";
	$sql.= "`address` = '". $_POST["txt_reg_legalAddress"] ."',";
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
	$sql.= "`codcompanylist` = ". $data->get_data($_POST["coditem"]) .",";
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
	$sql.= "`titular_nrodoc` = '". $_POST["txt_reg_tit_nrodoc"] ."', ";
	$sql.= "`coditem` = ". $_POST["coditem"] ."";
	$sql.= "WHERE coduser = ".$_POST["coduser"];
	die($sql);
	$data->query($sql);

	die("ok_edit");
break;
/*--------------------------------- END SPONSOR -------------------------------*/

case "delete":
	
break;
}

die("ok");
?>