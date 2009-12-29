<?php
session_start();
switch($_SESSION["tableusers"]){
	case "users_sports"          : 
?>	
	<!--User Sport -->
	<ul>
	    <li><a href="#" onclick="Panel.show_section('recomendarme_sport_club.php'); return false;">Club</a> |</li>
	    <li><a href="#" onclick="Panel.show_section('recomendarme_sport_representante.php'); return false;">Representante</a> |</li>
	    <li><a href="#" onclick="Panel.show_section('recomendarme_sport_otrapersona.php'); return false;">Otra Persona</a></li>
	</ul>	
<?php
	break;
	case "users_representatives" : 
?>
	<!--User Representatives -->
	<ul>
	    <li><a href="#" onclick="Panel.show_section('recomendarme_repr_sport.php'); return false;">Deportista</a> |</li>
	    <li><a href="#" onclick="Panel.show_section('recomendarme_repr_otrapersona.php'); return false;">Otra Persona</a></li>
	</ul>
<?php
 	break;
 	case "users_club"            : 
?>
 	<!--User Club -->
	<ul>
	    <li><a href="#" onclick="Panel.show_section('recomendarme_club_sport.php'); return false;">Deportista</a> |</li>
	    <li><a href="#" onclick="Panel.show_section('recomendarme_club_otrapersona.php'); return false;">Otra Persona</a></li>
	</ul>
<?php
	break;
	case "users_sponsors"        :
?>
	<!--User Sponsors -->
	<ul>
	    <li><a href="#" onclick="Panel.show_section('recomendarme_sponsor_sport.php'); return false;">Deportista</a> |</li>
	    <li><a href="#" onclick="Panel.show_section('recomendarme_sponsor_club.php'); return false;">Club</a> |</li>
	    <li><a href="#" onclick="Panel.show_section('recomendarme_sponsor_otrapersona.php'); return false;">Otra Persona</a></li>
	</ul>
<?php	
	break;	
}
?>