<?
class Class_Login
{
	var $data;

	function Class_Login($o)
	{
		$this->data = $o;
	}

	function is_logged(){
		$row = $this->data->get_result("SELECT * FROM login WHERE sessionid='".session_id()."'");
		return ($row=="N/A") ? false : true;
	}
	
	function logout(){
		$this->data->query("DELETE FROM login WHERE coduser=".$_SESSION["coduser"]);
		session_destroy();
	}
}
$Login = new Class_Login($data);
?>