<?php
class class_browsing{
	
	function __construct($d){
		$this->data = $d;
	}

	//=============== PUBLIC ================
	public $select;
	
	public function get_query($sql){
				
		$row = $this->data->get_result("SELECT count(*) FROM (".$sql.") a");
		echo '<input type="hidden" id="'. $_GET["id_hidden"] .'" value="'. $row[0] .'" />';
		
		$order = $_GET["orderby"] ? "ORDER BY ".$_GET["orderby"] : "";	
		$sql = "SELECT * FROM (".$sql.") a ".$order." LIMIT ".$_GET["row_from"].",".$_GET["row_to"];
		return $this->data->query($sql);
	}	

	//=============== PRIVATE ===============
	private $data;
}

include($_SERVER['DOCUMENT_ROOT']."/".$_GET["include"]);
?>