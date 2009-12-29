<?
session_start();
switch($_SESSION["tableusers"]){
	case "users_club"            :  $pagename = "club.php"; break;
	case "users_representatives" :  $pagename = "representante.php"; break;
	case "users_sponsors"        :  $pagename = "sponsor.php"; break;
	case "users_sports"          :  $pagename = "deportista.php"; break;
}
?>

<ul>
    <li><a href="#" onclick="Registry.show_form('<? echo $pagename;?>', '<? echo $_SESSION["coduser"];?>'); return false;">Datos Personales</a> |</li>
    <li><a href="#" onclick="Panel.show_section('profile_sport.php'); return false;">Datos Deportivos</a> |</li>
    <!--<li><a href="#" onclick="Panel.show_section('test.php'); return false;">Test y Pruebas fisicas</a> |</li>-->
    <li><a href="#" onclick="Panel.show_section('photos.php'); return false;">Fotos</a> |</li>
    <li><a href="#" onclick="Panel.show_section('movies.php'); return false;">Videos</a></li>
</ul>
