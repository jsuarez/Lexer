<?
include("../../configure.php");
include("../../connection/connection.php");
include("../../php/constructor_profile_sport.php");
header('Content-type: text/html; charset=utf-8');
session_start();
$result = $data->get_result("SELECT * FROM profile_sport WHERE coduser=".$_SESSION["coduser"]);
//print_r($result);
//die();
?>

<h3>Datos Deportivos</h3>
<ul class="form">
    <li>
        <div class="cell1"><span class="required">*</span>Deporte </div>
        <div class="cell2">    	
            <? $rst = $data->query("SELECT * FROM list_sports ORDER BY name");?>
            <select name="cboListSports" onchange="ProfileSport.change_sport(this)">
            <option value="0">Seleccione un Deporte</option>
            <? while( $row=mysql_fetch_array($rst) ){?>
                <option value="<? echo $row["codsport"];?>"<? if( $result["codsport"]==$row["codsport"]) echo 'selected="selected"';?>><? echo utf8_encode($row["name"]);?></option>
            <? }?>
            </select>        
        </div>
    </li>
    <li>
        <div class="cell1"><span class="required">*</span>Nivel</div>
        <div class="cell2">
            <span>
            	<input type="radio" name="opt_level" value="1" onclick="ShowContent('includes/ajax/profile_sport.php?action=category_boxeo&codsport=16&level=1','#category')" <? if( $result["level"]==1 ) echo 'checked="checked"';?>>Profesional&nbsp;&nbsp;</span>
            <span id="optionLevel" <?php if( $result["codsport"]!=16) echo 'class="styleDisplayNone""';?>>
            	<input type="radio" name="opt_level" value="2" onclick="ShowContent('includes/ajax/profile_sport.php?action=category_boxeo&codsport=16&level=2','#category')" <? if( $result["level"]==2 ) echo 'checked="checked"';?>>Aficionado&nbsp;&nbsp;</span>
            <span>
            	<input type="radio" name="opt_level" value="3" onclick="ShowContent('includes/ajax/profile_sport.php?action=category_boxeo&codsport=16&level=3','#category')" <? if( $result["level"]==3 ) echo 'checked="checked"';?>>Amateur</span>
        </div>
    </li>
</ul>
<!--Etiqueta que se completara con Ajax los registros por cada deporte -->
<ul id="container_sport" class="form">
<?php 
if ($result!="N/A"){
$CODSPORT=$result["codsport"];
switch($CODSPORT){
			case "1": 
			// ========= Datos Sport Futbol =========
				// ========= Pierna Habil =========
				get_html("pierna_habil");
				
				// ========= MI pase pertenece =========
				get_html("mipase");
				
				// ========= Posicion =========
				get_html("posicion");
				
				// ========= Posicion =========
				get_html("posicion_avanzada");
			// ========= Fin Datos Sport Futbol =========
		    break;
			case "2":
			// ========= Datos Sport Futbol Americano =========
				// ========= MI pase pertenece =========
					get_html("mipase");
				// ========= Posicion =========
					get_html("posicion");
			// ========= Fin Datos Sport Futbol Americano =========
		    break;
			case "3": 
			// ========= Datos Sport Futbol de Salon =========
					// ========= MI pase pertenece =========
						get_html("mipase");
					// ========= Pierna Habil =========
						get_html("pierna_habil");
					// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos Sport Futbol de Salon =========
		    break;
			case "4":
			// ========= Datos Datos Sport VOLEY =========
					// ========= MI pase pertenece =========
						get_html("mipase");
					// ========= Alcance =========
						get_html("alcances");
					// ========= Debut Internacional =========
						get_html("debut_internacional"); 
					// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos Sport VOLEY =========
		    break;
			case "5":
			// ========= Datos Sport Voley de Playa =========
					// ========= MI pase pertenece =========
						get_html("mipase");
			// ========= Fin Datos Sport Voley de Playa =========					
		    break;
			case "6":
			// ========= Datos Sport RUGBY =========
					// ========= Mejor Golpe =========
						get_html("mejor_golpe");
					// ========= Alcance =========
						get_html("alcance");
		    		// ========= Entrenamientos =========
						get_html("entrenamientos");
					// ========= MI pase pertenece =========
						get_html("mipase");
					// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos Sport RUGBY =========
		    break;
			case "7":
			// ========= Datos Sport Softbol =========
					// ========= MI pase pertenece =========
						get_html("mipase");
					// ========= Mano habil =========	
						get_html("mano_habil");
					// ========= Seleccionado =========	
						get_html("seleccionado");
					// ========= Mayor Habilidad =========	
						get_html("mayor_habilidad");
					// ========= Entrenamientos =========
						get_html("entrenamientos");
					// ========= Años Jugando =========
						get_html("anios_jugando");
    				// ========= Posicion =========
						get_html("posicion");
    		// ========= Fin Datos Sport Softbol =========
		    break;
			case "8":
			// ========= Datos Sport TENIS =========
					// ========= MI pase pertenece =========
						get_html("mipase");
					// ========= Mano habil =========	
						get_html("mano_habil");
					// ========= Modalidad =========	
						get_html("modalidad");	
					// ========= Rankings =========	
						get_html("rankings");
					// ========= Seleccionado =========	
						get_html("seleccionado");
					// ========= Profesional desde =========	
						get_html("profesional");
					// ========= Ganancias =========	
						get_html("ganancias");	
    				// ========= Entrenamientos =========
						get_html("entrenamientos");
			// ========= Fin Datos TENIS =========
		    break;
			case "9":
			// ========= Datos Sport TENIS MESA =========
				// ========= MI pase pertenece =========
						get_html("mipase");
				// ========= Mano habil =========	
						get_html("mano_habil");
				// ========= Modalidad =========	
						get_html("modalidad");
				// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos TENIS MESA =========	
		    break;
			case "10":
			// ========= Datos Sport HOCKEY SOBRE CESPED =========
				// ========= Rankings =========	
						get_html("jugando_desde");
    			// ========= Seleccionado =========	
						get_html("seleccionado");
				// ========= Debut en primera =========			
						get_html("debut_primera");
				// ========= Debut Internacional =========
						get_html("debut_internacional"); 	
    			// ========= Mejor Golpe =========
						get_html("mejor_golpe");
				// ========= Entrenamientos =========
						get_html("entrenamientos");
				// ========= Rankings =========	
						get_html("rankings");
				// ========= MI pase pertenece =========
						get_html("mipase");
				// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos HOCKEY SOBRE CESPED =========	
		    break;
			case "11":
			// ========= Datos Sport HOCKEY SOBRE HIELO =========
				// ========= Posicion =========
						get_html("posicion");
			// ========= FIN Datos Sport HOCKEY SOBRE HIELO =========
			break;
			case "12":
			// ========= Datos Sport HOCKEY SOBRE PATINES =========
				// ========= Posicion =========
						get_html("posicion");
			// ========= FIN Datos Sport HOCKEY SOBRE PATINES =========
		    break;
			case "13":
			// ========= Datos Sport HANDBALL =========
				// ========= MI pase pertenece =========
						get_html("mipase");
				// ========= Mano habil =========	
						get_html("mano_habil");
				// ========= Seleccionado =========	
						get_html("seleccionado");
				// ========= Rankings =========	
						get_html("rankings");
				// ========= Entrenamientos =========
						get_html("entrenamientos");
				// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos Sport HANDBALL =========
		    break;
			case "14":
			// ========= Datos Sport GOLF =========
				// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos GOLF =========
		    break;
			case "15":
			// ========= Datos Sport CICLISMO =========
				// ========= Especialidad =========	
						get_html("especialidad");
				// ========= Rankings =========	
						get_html("categoria");
				// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos Sport CICLISMO =========
		    break;
			case "16":
			// ========= Datos Sport BOXEO =========
				// ========= Mano habil =========	
						get_html("mano_habil");
			?>
			<!-- Dato Categoria -->
            <li id="category">
            	<div class="cell1"><span class="required">*</span>Categor&iacute;a</div>
		        <div class="cell2">
		        	<? $rst = $data->query("SELECT * FROM list_category 
					where codsport =".$result["codsport"]." AND ".
					"level = ".$result["level"]." 
					ORDER BY name");?>
			       	<select class="validator {v_required:true}" name="cboCategory">
			         <option value="0">Seleccione Categor&iacute;a</option>
			          <? while( $row=mysql_fetch_array($rst) ){?>
			                <option value="<? echo $row["codcategory"];?><?php if($result["codcategory"]==$row["codcategory"]) echo 'selected="selected"';?> "><? echo utf8_encode($row["name"]);?></option>
			            <? }?>
			        </select>
				</div>  
		    </li>
    		<!-- Fin Dato Categoria -->
    		<?php
    			// ========= Mano habil =========	
						get_html("licencia");
    			// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos Sport BOXEO =========
		    break;
			case "17":
			// ========= Datos Sport ATLETISMO =========
				// ========= Rankings =========	
						get_html("disciplina");
    			// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos Sport ATLETISMO =========
		    break;
			case "18":
			// ========= Datos Sport AUTOMOVILISMO =========
				// ========= Modalidad =========	
						get_html("modalidad");
				// ========= Rankings =========	
						get_html("rankings");
			// ========= FIn Datos Sport AUTOMOVILISMO =========
		    break;
			case "19":
			// ========= Datos Sport MOTOCICLISMO =========
				// ========= Modalidad =========	
						get_html("modalidad");
				// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos Sport MOTOCICLISMO =========
		    break;
			case "20":
			// ========= Datos Sport BASQUET =========
				// ========= MI pase pertenece =========
						get_html("mipase");
				// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos Sport BASQUET =========
		    break;
			case "21":
			// ========= Datos Sport BEISBOL =========
				// ========= MI pase pertenece =========
						get_html("mipase");
				// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos Sport BEISBOL =========
		    break;
			case "22":
			// ========= Datos Sport WATERPOLO =========
				// ========= MI pase pertenece =========
						get_html("mipase");
				// ========= Posicion =========
						get_html("posicion");
			// ========= Fin Datos Sport WATERPOLO =========
		    break;
			case "23":
			// ========= Datos Sport PÁDLE =========
				// ========= Mano habil =========	
						get_html("mano_habil");
				// ========= Posicion en Cancha =========	
						get_html("posicion_cancha");
				// ========= Pala =========
						get_html("pala");
    			// ========= Mano habil =========	
						get_html("mano_habil");
				// ========= Mejor Golpe =========
						get_html("mejor_golpe");
				// ========= Compañero =========
						get_html("companiero");
    			// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos Sport PÁDLE =========
		    break;
			case "24":
			// ========= Datos Sport NATACIÓN =========
				// ========= Seleccionado =========	
						get_html("seleccionado");
				// ========= Nadando desde =========	
						get_html("nadando_desde");
				// ========= Nadando desde =========	
						get_html("entrenador");
    			// ========= Modalidad =========	
						get_html("modalidad");
				// ========= Rankings =========	
						get_html("rankings");
			// ========= Fin Datos Sport NATACIÓN =========
		    break;
			case "25":
			// ========= Datos Sport ESCALADA DEPORTIVA =========
				// ========= Años Escalando =========	
						get_html("anios_escalando");
    			// ========= Rankings =========	
						get_html("rankings");
				// ========= Modalidad =========	
						get_html("modalidad");
		    break;
		}
}?>
</ul>

<ul class="form">
    <li>
        <div class="cell1">Experiencia en el Exterior</div>
        <div class="cell2">
        	<span><input type="radio" name="optExperience" value="1" onclick="ShowOtro('+','#rowCountry');" <? if( $result["experience_abroad"]==1 ) echo 'checked="checked"';?>>Si&nbsp;&nbsp;</span>
            <span><input type="radio" name="optExperience" value="0" onclick="ShowOtro(0,'#rowCountry');" <?php if($result["experience_abroad"]==0 || !isset($result) ) echo 'checked="checked"';?>>No</span>
        </div>
    </li>

    <li id="rowCountry" <?php if( $result["experience_abroad"]==null) echo 'style="display:none"';?>>
        <div class="cell1"><span class="required">*</span>Paises</div>
        <div class="cell2">
            <div class="container_list1">        
                <? $rst = $data->query("SELECT * FROM list_country ORDER BY name");?>
                <select id="cboListCountry" class="validator {v_required:true} list_sports" multiple="multiple">
                <? while( $row=mysql_fetch_array($rst) ){?>
                    <option value="<? echo $row["codcountry"];?>"><? echo utf8_encode($row["name"]);?></option>
                <? }?>
                </select>        
            </div>
            <ul class="panel">
                <li><a href="#" onclick="ProfileSport.add_items('cboListCountry', 'cboListCountry_sel');return false;"><img src="images/icons/arrow_right.png" alt="Agregar" title="Agregar" border="0" /></a></li>
                <li><a href="#" onclick="ProfileSport.remove_items('cboListCountry', 'cboListCountry_sel');return false;"><img src="images/icons/arrow_left.png" alt="Quitar" title="Quitar" border="0" /></a></li>
            </ul>
            <div class="container_list2">                    
            <? if( $result["experience_abroad"] ) {?>
            	<? $rst = $data->query("SELECT * FROM profilesport_to_country INNER JOIN list_country ON profilesport_to_country.codcountry=list_country.codcountry WHERE codprofsport =".$result["codprofsport"]." ORDER BY list_country.name");?>
                <select id="cboListCountry_sel" name="cboListCountry_sel" class="list_sports" multiple="multiple">
                <? while( $row=mysql_fetch_array($rst) ){?>
                    <option value="<? echo $row["codcountry"];?>"><? echo utf8_encode($row["name"]);?></option>
                <? }?>                        
                </select>
            
            <?	}else{?>
                    <select id="cboListCountry_sel" name="cboListCountry_sel" class="list_sports" multiple="multiple"></select>
            <?  }?>
            </div>
        </div>
    </li>		

    <li>
        <div class="cell1"><span class="required">*</span>Lesiones</div>
        <div class="cell2">
            <ul class="container_list1">
                <li>
                    <div class="col1">Lesi&oacute;n</div>
                    
                    <? $rst = $data->query("SELECT * FROM list_lesions ORDER BY name");?>
                    <select id="cboListLesions" class="validator {v_required:true} list_lesions2" onclick="ProfileSport.ShowLesion(this.value,'#row_lesion');">
                    	<option value="0">Ninguna</option>
                    <? while( $row=mysql_fetch_array($rst) ){?>
                        <option value="<? echo $row["codlesion"];?>" title="<? echo utf8_encode($row["name"]);?>"><? echo utf8_encode($row["name"]);?></option>
                    <? }?>
                    </select>
                    
                    <div id="cont_lesion_textarea" class="styleDisplayNone">
                    	<input type="text" id="txtLesionName"  onkeyup="ProfileSport.lesion_key(event)" />                    
                    </div>
                    
                    <div id="container_icons1" class="container_icons">
                    <a href="#" onclick="ProfileSport.lesion_new();return false;"><img src="images/icons/add.png" alt="Agregar" title="Agregar" border="0" /></a>
                    <a href="#" onclick="ProfileSport.lesion_edit();return false;"><img src="images/icons/edit.png" alt="Modificar" title="Modificar" border="0" /></a>
                    <a href="#" onclick="ProfileSport.lesion_delete();return false;"><img src="images/icons/delete.gif" alt="Eliminar" title="Eliminar" border="0" /></a>
                    </div>
                    <div id="container_icons2" class="container_icons styleDisplayNone">
                    <a href="#" onclick="ProfileSport.lesion_save();return false;"><img src="images/icons/save.png" alt="Guardar" title="Guardar" border="0" /></a>
                    <a href="#" onclick="ProfileSport.lesion_cancel();return false;"><img src="images/icons/cancel.png" alt="Cancelar" title="Cancelar" border="0" /></a>
                    </div>

                    
                    <div class="container_errors"><div id="divContErr1"></div></div>                    
                </li>
                
                <li id="row_les_1" style="display:none">
                    <div class="col1">A&ntilde;o de Lesi&oacute;n</div>
                    <span>Desde&nbsp;</span><input type="text" id="txt_lesion_YearFrom" class="input_range_year" maxlength="4" onkeypress="ValidKey(event,'number','unsigned')" />
                    <span>&nbsp;-&nbsp;</span>
                    <span>Hasta&nbsp;</span><input type="text" id="txt_lesion_YearTo" class="input_range_year" maxlength="4" onkeypress="ValidKey(event,'number','unsigned')" />
                    <div class="container_errors"><div id="divContErr2"></div></div>
               </li>                
                <li id="row_les_2" style="display:none">
                    <div class="col1">Recuperaci&oacute;n</div>
                    <select id="cboRecuperation" class="validator {v_required:true} list_recuperation">
                    	<option value="0">Seleccione una opci&oacute;n</option>
                        <option value="1">&Oacute;ptima</option>
                        <option value="2">Muy Buena</option>
                        <option value="3">Buena</option>
                        <option value="4">Regular</option>
                        <option value="5">Mala</option>
                    </select>
                    <div class="container_errors"><div id="divContErr3"></div></div>                    
               </li>
			   <li id="row_les_3" style="display:none">           
		            <div class="container_list1">        
		                <select id="cboLesionsSelected" class="list_lesions1" multiple="multiple" onchange="ProfileSport.lesion_item_show(this)">
		                </select>        
		            </div>
		            
		            <div class="buttons">
		            	<input type="button" value="Nuevo" onclick="ProfileSport.lesion_item_clear()" />
		                <input type="button" id="btnLesionAdd" value="Agregar" onclick="ProfileSport.lesion_item_save()" />
		                <input type="button" value="Eliminar" onclick="ProfileSport.lesion_item_delete()" />
		            </div>
            	</li> 
            
            </ul><!--end .container_list1-->
    	</div>
   </li>

    <li>
        <div class="cell1"><span class="required">*</span>Enfermedad</div>
        <div class="cell2">          
        	<select id="cboAffiction"  onchange="ShowOtro(this.value,'#divContTag1');">
                <option value="0"<? if( $result["affliction"]==0) echo 'selected="selected"';?>>Ninguna</option>
                <option value="+"<? if( $result["affliction"]=="+") echo 'selected="selected"';?>>Detallar</option>
            </select>
            <div id="divContTag1" <?php if( $result["affliction"]!="+") echo 'class="styleContTag"';?>>
				<input type="text" class="validator {v_required:true}" name="txtAffiction_new" value="<?php echo $result["description_affliction"];?>"/>
			</div>
        </div>  
    </li>   
    <li>
        <div class="cell1"><span class="required">*</span>Operaciones</div>
        <div class="cell2">    	
            <? $rst = $data->query("SELECT * FROM list_operations ORDER BY name");?>
            <select name="cboListOperations" class="validator {v_required:true}"  onchange="ShowOtro(this.value,'#row_otro_operation');">
            <option value="0">Seleccione un Operacion</option>
            <? while( $row=mysql_fetch_array($rst) ){?>
                <option value="<? echo $row["codope"];?>"<?php if($result["codope"]==$row["codope"]) echo 'selected="selected"';?>><? echo utf8_encode($row["name"]);?></option>
            <? }?>
            <option value="+"<?php if($result["codope"]==null) echo 'selected="selected"';?>>Otra</option>
            </select>        
        </div>
    </li>
    <li id="row_otro_operation" <?php if( $result["codope"]==null) echo 'style="display:none"';?>>
    			<div class="cell1"><span class="required">*</span>Otra Operaci&oacute;n</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox"  name="txt_other_operation" value="<?php echo $result["other_operation"];?>"/>
				</div>
	</li>
    <li>
        <div class="cell1">Representante/Manager</div>
        <div class="cell2">
            <span><input type="radio" name="optRepresentative" value="+" onclick="ShowOtro('+','#representante_manager');" <? if( $result["representative"]!=null) echo 'checked="checked"';?>>Si&nbsp;&nbsp;</span>
            <span><input type="radio" name="optRepresentative" value="0" onclick="ShowOtro(0,'#representante_manager');" <? if( $result["representative"]==null || !$result["representative"] ) echo 'checked="checked"';?>>No</span>
        </div>
    </li>
    <li id="representante_manager" <?php if( $result["representative"]==null) echo 'style="display:none"';?>>
		<div class="cell1"><span class="required">*</span>Representante</div>
		<div class="cell2">
				  <input type="text" class="validator {v_required:true} inputbox inputsmall" name="txt_rep" id="txt_rep" value="<?php echo $result["representative"];?>"/>
		</div>
	</li>
    <li>
		<div class="cell1"><span class="required">*</span>Objetivo Profesional</div>
		<div class="cell2">
				  <textarea name="txt_objetivo"  cols="20" rows="5" class="validator {v_required:true} inputbox"><?php echo $result["professional_objective"];?></textarea>
		</div>
	</li>
     <li>
     	<div class="cell1"></div>
     	
		
		<div class="cell2">
		<?php 
		if ($result=="N/A"){?>
			<input type="button" value="Guardar" onclick="ProfileSport.save('new_profilesport');">
        <?php }else{?>
        	<input type="button" value="Modificar" onclick="ProfileSport.save('upd_profilesport');">
        <?php }?>
        	<input type="reset" value="Reset">
        </div>
    </li>
</ul>    
<input type="hidden" name="codprofsport" value="<?php echo $result["codprofsport"];?>">