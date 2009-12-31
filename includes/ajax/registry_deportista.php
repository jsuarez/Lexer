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
								   'tableusers'  => "users_sports"));
	
	$data->query("UPDATE users SET id='".md5($coduser)."' WHERE coduser=".$coduser);

	$sendmail = new Class_SendMail();
	$sendmail->from = REGISTER_EMAIL_FROM;
	$sendmail->name_from = REGISTER_NAME_FROM;
	$sendmail->to = $_POST["txt_reg_Email"];
	$sendmail->subject = REGISTER_SUBJECT;
	$sendmail->message = sprintf(REGISTER_MESSAGE, md5($coduser));
	
	if( $sendmail->send() ){
		
		$sql = "INSERT INTO users_sports (coduser, lastname, firstname, sex, birth, typedoc, typedoc_new, nrodoc, country, province, city, cp, nacionality, nacionality2, nacionality3, passport, phone_pref1, phone_pref2, phone, cel_pref1, cel_pref2, cel, website, `language`, `language2`, `language3`, `language4`, language_level_write, language2_level_write, language3_level_write, language4_level_write, language_level_talk, language2_level_talk, language3_level_talk, language4_level_talk, profession, studies, disability, typedisc, detaildisc) ";
		
		$sql.= "VALUES (";
		$sql.= 		$coduser  .",";
		$sql.= "'". $_POST["txt_reg_LastName"]  ."',";
		$sql.= "'". $_POST["txt_reg_FirstName"] ."',";
		$sql.= 	    $_POST["opt_reg_sex"]	.",";
		$sql.= "'". $_POST["cboBirthDate_Day"]."/".$_POST["cboBirthDate_Month"]."/".$_POST["cboBirthDate_Year"] ."',";
		$sql.= "'".	$_POST["cbo_reg_TypeDoc"]  ."',";
		$sql.= "'".	$_POST["txt_reg_typedoc_other"]  ."',";
		$sql.= "'". $_POST["txt_reg_nrodoc"]   ."',";
		$sql.= 		$_POST["codcountry"]  .",";
		$sql.= 		$_POST["codprovince"] .",";
		$sql.= "'". $_POST["txt_reg_City"]	."',";
		$sql.= 		$data->get_data($_POST["txt_reg_CP"])	.",";	
		
		//----- NACIONALIDAD
		$sql.= "'". $_POST["txt_reg_nationality"]  ."',";
		$sql.= "'". $_POST["txt_reg_nationality2"] ."',";
		$sql.= "'". $_POST["txt_reg_nationality3"] ."',";
		//-----
		$sql.= 		$_POST["cbo_reg_Passport"]	   .",";
		
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

		$sql.= "'". $_POST["txt_reg_website"]	."',";
		
		//----- IDIOMAS
		$sql.= 		$data->get_data($_POST["codlanguage"])	.",";
		$sql.= 		$data->get_data($_POST["codlanguage2"])	.",";
		$sql.= 		$data->get_data($_POST["codlanguage3"])	.",";
		$sql.= 		$data->get_data($_POST["codlanguage4"])	.",";		
		$sql.= 		$data->get_data($_POST["cbo_reg_language_write"]) .",";
		$sql.= 		$data->get_data($_POST["cbo_reg_language2_write"]) .",";
		$sql.= 		$data->get_data($_POST["cbo_reg_language3_write"]) .",";
		$sql.= 		$data->get_data($_POST["cbo_reg_language4_write"]) .",";		
		$sql.= 		$data->get_data($_POST["cbo_reg_language_talk"]) .",";
		$sql.= 		$data->get_data($_POST["cbo_reg_language2_talk"]) .",";
		$sql.= 		$data->get_data($_POST["cbo_reg_language3_talk"]) .",";
		$sql.= 		$data->get_data($_POST["cbo_reg_language4_talk"]) .",";
		//-----
		
		$sql.= "'". $_POST["txt_reg_Profession"] ."',";
		$sql.= "'". $_POST["txt_reg_Studies"] ."',";
		$sql.= 		$_POST["opt_reg_disability"]	.",";
		$sql.= 		$_POST["cbo_reg_TypeDisability"] .",";
		$sql.= "'".	$_POST["txt_reg_DetDisability"]  ."'";
		$sql.= ")";		
		$data->query($sql);
				
		die("sendmail_ok");
	}else {
		$data->query("DELETE FROM users WHERE coduser=".$coduser);
		die("sendmail_error");
	}
			
break;

case "edit":
	
	$sql = "UPDATE users_sports SET ";
	$sql.= "`lastname` = '". $_POST["txt_reg_LastName"] ."',";
	$sql.= "`firstname` = '". $_POST["txt_reg_FirstName"] ."',";
	$sql.= "`sex` = ". $_POST["opt_reg_sex"] .",";
	$sql.= "`birth` = '". $_POST["cboBirthDate_Day"]."/".$_POST["cboBirthDate_Month"]."/".$_POST["cboBirthDate_Year"] ."',";
	$sql.= "`typedoc` = '". $_POST["cbo_reg_TypeDoc"] ."',";
	$sql.= "`typedoc_new` = '". $_POST["txt_reg_typedoc_other"] ."',";
	$sql.= "`nrodoc` = '". $_POST["txt_reg_nrodoc"] ."',";
	$sql.= "`country` = ". $_POST["codcountry"] .",";
	$sql.= "`province` = ". $_POST["codprovince"] .",";
	$sql.= "`city` = '". $_POST["txt_reg_City"] ."',";
	$sql.= "`cp` = ". $data->get_data($_POST["txt_reg_CP"]) .",";
	$sql.= "`nacionality` = '". $_POST["txt_reg_nationality"] ."',";
	$sql.= "`nacionality2` = '". $_POST["txt_reg_nationality2"] ."',";
	$sql.= "`nacionality3` = '". $_POST["txt_reg_nationality3"] ."',";
	$sql.= "`passport` = ". $_POST["cbo_reg_Passport"] .",";
	$sql.= "`phone_pref1` = ". $data->get_data($_POST["txt_reg_phone_pref1"]) .",";
	$sql.= "`phone_pref2` = ". $data->get_data($_POST["txt_reg_phone_pref2"]).",";
	$sql.= "`phone` = ". $_POST["txt_reg_phone_num"] .",";
	$sql.= "`cel_pref1` = ". $data->get_data($_POST["txt_reg_cel_pref1"]) .",";
	$sql.= "`cel_pref2` = ". $data->get_data($_POST["txt_reg_cel_pref2"]) .",";
	$sql.= "`cel` = ". $data->get_data($_POST["txt_reg_cel_num"]) .","; 
	$sql.= "`website` = '". $_POST["txt_reg_website"] ."',";
	$sql.= "`language` = ". $data->get_data($_POST["codlanguage"]) .",";
	$sql.= "`language_level_write` = ". $data->get_data($_POST["cbo_reg_language_write"]) .",";
	$sql.= "`language_level_talk` = ". $data->get_data($_POST["cbo_reg_language_talk"]) .",";
	$sql.= "`language2` = ". $data->get_data($_POST["codlanguage2"]) .",";
	$sql.= "`language2_level_write` = ". $data->get_data($_POST["cbo_reg_language2_write"]) .",";
	$sql.= "`language2_level_talk` = ". $data->get_data($_POST["cbo_reg_language2_talk"]) .",";
	$sql.= "`language3` = ". $data->get_data($_POST["codlanguage3"]) .",";
	$sql.= "`language3_level_write` = ". $data->get_data($_POST["cbo_reg_language3_write"]) .",";
	$sql.= "`language3_level_talk` = ". $data->get_data($_POST["cbo_reg_language3_write"]) .",";
	$sql.= "`language4` = ". $data->get_data($_POST["codlanguage4"]) .",";
	$sql.= "`language4_level_write` = ". $data->get_data($_POST["cbo_reg_language4_write"]) .",";
	$sql.= "`language4_level_talk` = ". $data->get_data($_POST["cbo_reg_language4_write"]) .",";
	$sql.= "`profession` = '". $_POST["txt_reg_Profession"] ."',";
	$sql.= "`studies` = '". $_POST["txt_reg_Studies"] ."',";
	$sql.= "`disability` = ". $_POST["opt_reg_disability"] .",";
	$sql.= "`typedisc` = ". $_POST["cbo_reg_TypeDisability"] .",";
	$sql.= "`detaildisc` = '". $_POST["txt_reg_DetDisability"] ."' ";
	$sql.= "WHERE coduser = ".$_POST["coduser"];
	$data->query($sql);
	
	
	$filenames_real = explode(",", $_POST["filenames_real"]);
	$filenames_server = explode(",", $_POST["filenames_server"]);
	
	$sql = "INSERT INTO images(coduser,filename_server,filename_real) VALUES";
	for( $n=0; $n<=count($filenames_real)-1; $n++ ){
		$sql.= "(";
		$sql.=		$_POST["coduser"] .",";
		$sql.= "'". $filenames_server[$n] ."',";
		$sql.= "'". $filenames_real[$n] ."'";
		$sql.= "),";
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
