<?
if( $_SERVER['REQUEST_METHOD']=="POST" && $_POST["action"]=="login" ){
	$row = $data->get_result("SELECT * FROM users WHERE email='".$_POST["txtUser"]."' and pass='".md5($_POST["txtPass"])."'");
	
	if( $row!="N/A" ){
		ini_set("session.gc_maxlifetime", "900");
		$_SESSION["coduser"] = $row["coduser"];
		$_SESSION["username"] = $row["email"];
		$_SESSION["name"] = $row["name"];
		$_SESSION["tableusers"] = $row["tableuser"];
		
		$data->query("DELETE FROM login WHERE coduser=".$row["coduser"]);
		
		$sql = "INSERT INTO login(coduser,date_time,ip,browser,sessionid) VALUES(";
		$sql.= $row["coduser"].",";
		$sql.= "now(),";
		$sql.= "'". $_SERVER['REMOTE_ADDR'] ."',";
		$sql.= "'". $_SERVER['HTTP_USER_AGENT'] ."',";
		$sql.= "'". session_id() ."')";
		$data->query($sql);
		
		$status_login = "ok";
		header("Location: user-account.php");

	}else{
		$status_login = "error";
	}
}
?>