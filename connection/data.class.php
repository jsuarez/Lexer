<?php
// Class: Administrador de Base de Dato
// Version: 3.0

class Data
{
	var $cnn;
	var $path_name;

	function Data($root)
	{
		$this->path_name=$root;
	}

	//
	// METODOS PUBLICOS	
	//
	function setConnection($host, $user, $pass, $bdd)
	{
		$this->cnn = mysql_connect($host, $user, $pass);
		mysql_select_db($bdd,$this->cnn);
		if(mysql_error())
		{
			die($this->ShowError("Error al tratar de establecer la conexi�n. ERROR NUMERO: ".mysql_errno(),mysql_error()));
		}
		return true;
	}

	function query($SQL)
	{
		$res=mysql_query($SQL,$this->cnn);
		if(mysql_error())
		{			
			die($this->ShowError("Error SQL. NUMERO: ".mysql_errno(), mysql_error()));
		}
		
		if( strtolower(substr($SQL,0,11))=="insert into" ){
			$res = mysql_insert_id();
		}
		
		return $res;
	}
	
	function consult($table, $field, $value)
	{
		if(!is_numeric($value)) $value="'".$value."'";
	
		$res = $this->query("SELECT * FROM ".$table." WHERE ".$field."=".$value);
		if(mysql_num_rows($res)>0)
			return true;
		else
			return;
	}
	
	function get_result($sql){
		if(empty($sql)) die($this-ShowError("Error.", "Ingrese una instruccion SQL."));

		$res = $this->query($sql);		
		if(mysql_num_rows($res)==0)
			return "N/A";
		else
			return mysql_fetch_array($res);
	}
	
	function count_reg($table)
	{
		$res = $this->query("SELECT count(*) FROM ".$table);
		$row = mysql_fetch_array($res);
		return $row[0];
	}	

	function get_value_string($value,$tipo){
		if(empty($value) && $value!=0) return "NULL";
		
		switch($tipo){
			case "numeric":
				return $value;
			case "string":
				$value = $this->filtrar_texto($value);
				return "'".$value."'";
			case "date":
				if(ereg("/",$value)){
					$date=split("/",$value);
					$parent="/";
				}
				else if(ereg("-",$value)){
					$date=split("-",$value);
					$parent="-";
				}				
				return "'".$date[2].$parent.$date[1].$parent.$date[0]."'";
		}
	}
	
	function getrow($row){
		if(empty($row)) return "&nbsp;";
		else{
			if( ereg("<!--", $row) ){
				$row = strip_tags($row, "<!--");
			}		
			
			return trim( $this->filtrar_texto($row) );
		}
	}
	
	function get_result_xml($sql){
		$rst = $this->query($sql);		
		if(mysql_num_rows($rst)>0) {
			$xml='<?xml version="1.0" encoding="iso-8859-1"?>';
			$xml.='<data>';
			while($row=mysql_fetch_array($rst, MYSQL_ASSOC)) {
				$xml.="<row>";
				
				while( list($key, $value) = each($row)){
					if( $value=="" ) $value = " ";
					$xml.= "<".$key.">".$value."</".$key.">";
				}
			
				$xml.="</row>";
			}
			$xml.="</data>";
			header('Content-type: text/xml');
			echo $xml;
		}else{
			return "N/A";
		}
	}
	
	function get_data($str, $value="NULL"){
		return empty($str) ? $value :  $str;
	}
	
	


	//
	// METODOS PRIVADOS
	//	
	function ShowError($title, $msg)
	{
		$img=$this->path_name."/exclamation.gif";		
		$salida='<table align="center" cellpadding="0" cellspacing="0" border="2" width="330px">';
		$salida.='<tr><td>';
		$salida.='<table style="font-family:Tahoma; font-size:12px" cellpadding="0" cellspacing="0" width="100%">';
		$salida.='<tr><td height="21" colspan="2" style="background:#0000FF; color:#FFFFFF; font-weight:bold">&nbsp;'.$title.'</td>';
		$salida.='</tr>';
		$salida.='<tr style="background:#CCCCCC; vertical-align:middle">';
		$salida.='	<td><img src="'.$img.'" /></td>';
		$salida.='	<td>&nbsp;'.$msg.'&nbsp;</td>';
		$salida.='</tr>';
		$salida.='</table>';
		$salida.='</td></tr>';
		$salida.='</table>';
		return $salida;
	}

	function filtrar_texto($text){
		if( empty($text) ) return "";
	
$enter="
";
		$text=ereg_replace("�","&aacute;",$text);
		$text=ereg_replace("�","&agrave;",$text);
		$text=ereg_replace("�","&eacute;",$text);
		$text=ereg_replace("�","&egrave;",$text);
		$text=ereg_replace("�","&iacute;",$text);
		$text=ereg_replace("�","&igrave;",$text);
		$text=ereg_replace("�","&oacute;",$text);
		$text=ereg_replace("�","&ograve;",$text);
		$text=ereg_replace("�","&uacute;",$text);
		$text=ereg_replace("�","&ugrave;",$text);
		$text=ereg_replace("�","&ntilde;",$text);
		$text=ereg_replace("�","&Ntilde;",$text);				
		$text=ereg_replace("�","&Aacute;",$text);
		$text=ereg_replace("�","&Agrave;",$text);
		$text=ereg_replace("�","&Eacute;",$text);
		$text=ereg_replace("�","&Egrave;",$text);
		$text=ereg_replace("�","&Iacute;",$text);
		$text=ereg_replace("�","&Igrave;",$text);
		$text=ereg_replace("�","&Oacute;",$text);
		$text=ereg_replace("�","&Ograve;",$text);
		$text=ereg_replace("�","&Uacute;",$text);
		$text=ereg_replace("�","&Ugrave;",$text);
		$text=ereg_replace("�","&rsquo;",$text);
		$text=ereg_replace("`","&lsquo;",$text);
		$text=ereg_replace("'","&middot;",$text);				
		$text=ereg_replace($enter,"<br>",$text);
//		$text=ereg_replace(chr(13),"",$text);
		return $text;	
	}	
}
?>