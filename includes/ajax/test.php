<?php
include("../../configure.php");
include("../../connection/connection.php");

switch( $_GET["action"] ){
		case "test": ?>
                <table id="table" border="1">
                   <tr>
                        <td>Fecha</td>
                        <td id="test">
                             <? $rst = $data->query("SELECT * FROM list_test where codcapacity =".$_GET["codcapacity"]." AND 
							 level = 0 ORDER BY name");?>
				            <select name="cboListSports" onchange="Test.InsertCell(this);">
				            <option value="0">Seleccione un Test</option>
				            <? while( $row=mysql_fetch_array($rst) ){?>
								<optgroup label= "<? echo utf8_encode($row["name"]);?>">
								 <?php while( $row=mysql_fetch_array($rst) ){?>
								
								</optgroup>
								<?php
								
								?>	
									<option><? echo utf8_encode($row["name"]);?></option>	
							
								}
							
								 
				            <? }?>
				            	<option value="+">Otro</option>	
							</select> 
                        </td>
                   </tr>
                </table>
           		<a href="#" onClick="Test.InsertRow();return false;">A&ntilde;adir Fila</a>
		<?php
		die();
		break;
		}
die("ok");
?>