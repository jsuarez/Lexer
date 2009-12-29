<?php
function get_form($name){

    echo '<form id="formAdvancedSearch" method="post" action="index.php" enctype="application/x-www-form-urlencoded">';
	
	switch(strtolower($name)){
	case "deportista":?>

            <!--<p>
            	<span>Peso&nbsp;</span><input type="text" name="txtWeight" onkeypress="ValidKey(event,'number','decimal')" />&nbsp;&nbsp;
                <span>Altura&nbsp;</span><input type="text" name="txtHeight" onkeypress="ValidKey(event,'number','decimal')" />&nbsp;&nbsp;
            </p>            
            <p>
            	<span>Edad&nbsp;</span><input type="text" name="txtAge" onkeypress="ValidKey(event,'number','unsigned')" />&nbsp;&nbsp;                
	            <span>Sexo&nbsp;</span><input type="radio" name="chkSex" value="1" checked="checked" />&nbsp;Masculino&nbsp;<input type="radio" name="chkSex" value="2" />&nbsp;Femenino
            </p>-->
            <p>
	        <span>Posici&oacute;n/Disciplina&nbsp;</span>
                <select name="cboPosition">
                    <?php get_options("list_position");?>
                </select>
                
	        <span>Categor&iacute;a&nbsp;</span>
                <select name="cboCategorySport">
                    <?php //get_options("list_provinces", "users_club");?>
                </select>

                <span>Provincia</span>
                <select name="cboProvince">
                    <?php get_options("list_provinces", "users_club");?>
                </select>
            </p>
            <p>
	        <span>Pierna/Mano H&aacute;bil&nbsp;</span>
                <select name="cboLegHand">
                	<option value="0">Ambos</option>
                	<option value="1">Derecha</option>
                	<option value="2">Izquierda</option>
                </select>
                
	        <span>Nivel&nbsp;</span>
                <select name="cboLevel">
                    <option value="0">Todos los Niveles</option>
                    <option value="1">Profesional</option>
                    <option value="2">Amateur</option>
                    <option value="3">Ambos</option>
                </select>

                <span>Ciudad</span>
                <select name="cboCity">
                    <?php get_options("list_city", "users_club");?>
                </select>
            </p>
            
            <p>                
                <!--PASAPORTE-->
                <span>Pasaporte</span>
                <select name="cboPassport">
                    <option value="0">Todos los Pasaportes</option>
                    <option value="1">Sin pasaporte</option>
                    <option value="2">Comunitario</option>
                    <option value="3">Extra comunitario</option>
                </select>            
            </p>
            
            <p>
            	<!--<input type="checkbox" name="chkConRepr" /><span>&nbsp;Con representante</span><br />
            	<input type="checkbox" name="chkHisDep" /><span>&nbsp;Con historial deportivo</span><br />-->
            	<input type="checkbox" name="chkMovie" /><span>&nbsp;Con videos</span><br />
            	<input type="checkbox" name="chkPhoto" /><span>&nbsp;Con fotos</span>
            </p>

            
<?php   break;
	case "club":?>

            <!--PROVINCIAS-->
            <select name="cboProvince">
                <?php get_options("list_provinces", "users_club");?>
            </select>
            
            <!--CIUDADES-->
            <select name="cboCity">
                <?php get_options("list_city", "users_club");?>
            </select>

            <!--CATEGORIA-->
            <select name="cboCompetitionCategory">
                <?php get_options("list_competition_category");?>
            </select>
            
<?php   break;
	case "sponsor":?>		
            <!--RUBROS-->
            <select name="cboItem">
                <?php get_options("list_items");?>
            </select>
            
            <!--PROVINCIAS-->
            <select name="cboProvince">
                <?php get_options("list_provinces", "users_sponsors");?>
            </select>
            
            <!--CIUDADES-->
            <select name="cboCity">
                <?php get_options("list_city", "users_sponsors");?>
            </select>
        
<?php	break;
	case "representante":?>

            <!--TRABAJO-->
            <select name="cboWork">
                <?php get_options("list_work");?>
            </select>
            
            <!--LICENCIA-->
            <input type="checkbox" name="chkLicence" /><span>Con Licencia&nbsp;</span>
            
            <br /><br />
            
             <!--PROVINCIAS-->
            <select name="cboProvinces">
                <?php get_options("list_provinces", "users_representatives");?>
            </select>

            <!--CIUDADES-->
            <select name="cboCity">
                <?php get_options("list_city", "users_representatives");?>
            </select>

            <!--NIVEL-->
            <select name="cboLevel">
                <option value="all">Todos los Niveles</option>
                <option value="1">Profesional</option>
                <option value="2">Amateur</option>
                <option value="3">Ambos</option>
            </select>
<?php   break;
	}
}
	echo '</form>';
?>