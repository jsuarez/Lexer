<?
include("../../configure.php");
include("../../connection/connection.php");
header('Content-type: text/html; charset=utf-8');

if (isset($_GET["codcapacity"])){
$codcapacity = $_GET["codcapacity"];
}else{
$codcapacity = 1;	
}
?>
<div id='test'>
<h3>Datos Test</h3>
<ul class="form">
    <li>
        <div class="cell1"><span class="required">*</span>Capacidad</div>
        <div class="cell2">    	
			<? $rst = $data->query("SELECT * FROM list_capacity ORDER BY name");?>
            <select name="cboListSports" onchange="Test.change_capacity(this);">
            <option value="0">Seleccione una Capacidad</option>
            <? while( $row=mysql_fetch_array($rst) ){?>
                <option value="<? echo $row["codcapacity"];?>"><? echo utf8_encode($row["name"]);?></option>
            <? }?>
            </select><div class="progress"></div>       
        </div>
    </li>
    <!--Tabla de test de acuerdo a la capacidad-->
    <li>
    		<div id="conteiner_table">
                
            </div>
                       	
    </li>
</ul>
</div>