<?
function narrow_text($str, $length, $points){
	$n = 0;
	 
	$arrayText = array();
	$arrayText = explode(' ', $str);	
	$str = '';
	
	while($length >= strlen($str) + strlen($arrayText[$n])){
		$str .= ' '.$arrayText[$n];
		$n++;
	}		
	return $str.$points;
}
function narrow_text2($str, $length){
	$str = ereg_replace("</p>", chr(13), $str);
	$str = ereg_replace("<br>", chr(13), $str);
	$str = ereg_replace("<br />", chr(13), $str);
	$str = strip_tags($str);
	$str = ereg_replace(chr(13), "<br>", $str);	
	return substr($str, 0, $length);
}

function getMonth($lang){
	$m = date("n");
	switch( strtolower(trim($lang)) ){
	case "english":
		if( $m==1 ) return "January";
		else if( $m==2 ) return "February";
		else if( $m==3 ) return "March";
		else if( $m==4 ) return "April";
		else if( $m==5 ) return "may";
		else if( $m==6 ) return "June";
		else if( $m==7 ) return "July";
		else if( $m==8 ) return "August";
		else if( $m==9 ) return "September";
		else if( $m==10 ) return "October";
		else if( $m==11 ) return "November";
		else if( $m==12 ) return "December";
	break;
	case "spanish":
		if( $m==1 ) return "Enero";
		else if( $m==2 ) return "Febrero";
		else if( $m==3 ) return "Marzo";
		else if( $m==4 ) return "Abril";
		else if( $m==5 ) return "Mayo";
		else if( $m==6 ) return "Junio";
		else if( $m==7 ) return "Julio";
		else if( $m==8 ) return "Agosto";
		else if( $m==9 ) return "Septiembre";
		else if( $m==10 ) return "Octubre";
		else if( $m==11 ) return "Noviembre";
		else if( $m==12 ) return "Diciembre";
	break;
	}
}

function remove_accents($str){
	$tofind = "�����������������������������������������������������";
	$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
	return(strtr($str,$tofind,$replac));
}

function generator_pass($rang=12){
	$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	$pass = "";
	for( $i=0; $i<=$rang; $i++ ) {
		$pass .= substr($str, rand(0,62), 1);
	}
	return $pass;
}

function resize_image($filename_source, $filename_destiny, $width=130, $height=100, $resolution=75, $proportion=true){
	
	$data = getimagesize($filename_source);
	
	if( $data[2]!=1 && $data[2]!=2 && $data[2]!=3 ) return false;
	
	if($data[2]==1){$image_source = @imagecreatefromgif($filename_source);}
    if($data[2]==2){$image_source = @imagecreatefromjpeg($filename_source);}
    if($data[2]==3){$image_source = @imagecreatefrompng($filename_source);}	
	
	$width_size = imagesx($image_source);
	$height_size = imagesy($image_source);
	
	if( $proportion ){
		if( $width_size > $height_size ){
			$height = ($width * $height_size) / $width_size;
		
		}elseif($width_size < $height_size){
			$width = ($height * $width_size) / $height_size;
		}
	}
			
	$image_destiny = imagecreatetruecolor($width, $height);
	
	if( $data[2]==1 || $data[2]==3 ){
		$colorTransparancia=imagecolortransparent($image_source);
		
		if($colorTransparancia!=-1){ //TIENE TRANSPARENCIA
			$colorTransparente = imagecolorsforindex($image_source, $colorTransparancia); //devuelve un array con las componentes de lso colores RGB + alpha
			$idColorTransparente = imagecolorallocatealpha($image_destiny, $colorTransparente['red'], $colorTransparente['green'], $colorTransparente['blue'], $colorTransparente['alpha']); // Asigna un color en una imagen retorna identificador de color o FALSO o -1 apartir de la version 5.1.3
			imagefill($image_destiny, 0, 0, $idColorTransparente);// rellena de color desde una cordenada, en este caso todo rellenado del color que se definira como transparente
			imagecolortransparent($image_destiny, $idColorTransparente); //Ahora definimos que en el nueva imagen el color transparente ser� el que hemos pintado el fondo.
			//imagecopyresampled($image_destiny, $image_source,0,0,0,0,$midaHoritzontal,$midaVertical,$mides[0],$mides[1]);// copia y redimensiona un 	
						
		}
	}
	
	imagecopyresized($image_destiny, $image_source, 0,0,0,0, $width, $height, $width_size, $height_size);
	
	if( $data[2]==1 ) {header("Content-type: image/gif");imagegif($image_destiny, $filename_destiny);}
	if( $data[2]==3 ) {header("Content-type: image/png");imagepng($image_destiny, $filename_destiny);}
	if( $data[2]==2 ) {header("Content-type: image/jpeg");imagejpeg($image_destiny, $filename_destiny, $resolution);}
	
	imagedestroy($image_destiny);	
}

function get_age($fecha_nac){
	$dia=date("j");
	$mes=date("n");
	$anno=date("Y");
	$dia_nac=substr($fecha_nac, 0, 2);
	//echo "Dia:".$dia_nac."</br>";
	$mes_nac=substr($fecha_nac, 3, 2);
	//echo "Mes:".$mes_nac."</br>";
	$anno_nac=substr($fecha_nac, 6, 4);
	//echo "Anio:".$anno_nac."</br>";
	if($mes_nac>$mes){
		$calc_edad= $anno-$anno_nac-1;
	}else{
		if($mes==$mes_nac AND $dia_nac>$dia){
		$calc_edad= $anno-$anno_nac-1;
		}else{
		$calc_edad= $anno-$anno_nac;
		}
	}
	return $calc_edad;
}

function get_username($coduser, $table){
	global $data;

	if( $table=="users_sports" || $table=="users_representatives" ) $field = "CONCAT(firstname, ' ', lastname)";
	elseif( $table=="users_club" || $table=="users_sponsors" ) $field = "business_name";

	$sql = "SELECT ".$field." FROM ".$table." WHERE coduser=".$coduser;
	$res = $data->get_result($sql);
	return $res[0];
}
?>