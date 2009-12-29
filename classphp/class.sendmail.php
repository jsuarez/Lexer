<?
class Class_SendMail{
	
	public $from;
	public $to;
	public $subject;
	public $name_from;
	public $message;
	
	function __construct(){
	
	}

	public function send(){		
		$header  = "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset=utf-8\r\n";
		$header .= "From: ".$this->name_from."<".$this->from.">\r\n";
		
		$this->message = html_entity_decode($this->message);
		$this->message = str_replace(chr(13), "<br>", $this->message);
		
		//return $this->to ."<br><br>". $this->subject ."<br><br>". $this->message ."<br><br>". $header;
		
		return @mail($this->to, utf8_encode($this->subject), utf8_encode($this->message), $header);
	}

}

?>