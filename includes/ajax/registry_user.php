<?
if( isset($_POST["coduser"]) ){
	include("../../configure.php");
	include("../../connection/connection.php");
}

class ClassUsers{
	
	private $data;
	
	function __construct($object){
		$this->data = $object;
	}
	
	public function insert($fields){	
		if( !$this->data->consult("users", "email", $fields['email']) ){
			
			$sql = "INSERT INTO users(email,pass,newsletters,tableuser) VALUES(";
			$sql.= "'".	$fields['email']	   ."',";
			$sql.= "'".	md5($fields['pass'])   ."',";
			$sql.= 		$fields['newsletters'] .",";
			$sql.= "'".	$fields['tableusers']  ."')";
			return $this->data->query($sql);
		}else{
			die("user exists");
		}	
	}

	public function update($fields){	
		$veri = $this->data->get_result("SELECT 1 FROM users WHERE email='". $fields["email"] ."' and coduser<>". $fields["coduser"]);
		if( $veri=="N/A" ){
			$sql = "UPDATE users SET ";
			$sql.= "email = '". $fields["email"] ."',";
			if( $fields["pass"]!="" ) $sql.= "pass = '". md5($fields["pass"]) ."', ";
			$sql.= "newsletters = ". $fields["newsletters"]." ";
			$sql.= "WHERE coduser = ".$_POST["coduser"];
			$this->data->query($sql);
			die("ok_edit");
			
		}else die("user exists");
	}

	public function delete($coduser){
		$data->query("DELETE FROM users WHERE coduser=".$coduser);
	}
}
$User = new ClassUsers($data);


if( isset($_POST["coduser"]) ){
	switch( $_GET["action"] ){
	case "edit": 
		$User->update(array('email' => $_POST["txt_reg_Email"],
						    'pass'  => $_POST["txt_reg_Pass"],
						    'newsletters'  => $_POST["chkNewsletters"],
						    'coduser'      => $_POST["coduser"]));
	break;
	case "delete": 
		$User->delete($_POST["coduser"]);
	break;
	}
}
?>