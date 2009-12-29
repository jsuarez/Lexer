<?php
function get_html($tag){
	global $data;
	global $result;
	global $CODSPORT;
	switch($tag){
		case "pierna_habil":?>
		<!-- Dato Pierna Habil -->
			 <li>
		        <div class="cell1"><span class="required">*</span>Pierna H&aacute;bil</div>
		        <div class="cell2">
		            <select class="validator {v_required:true}" name="cboLegHabil">
		            <option value="0">Seleccione un Pierna habil</option>
		            <option value="1"<?php if( $result["leg_habil"]==1) echo 'selected="selected"';?>>Derecha</option>
		            <option value="2"<?php if( $result["leg_habil"]==2) echo 'selected="selected"';?>>Izquierda</option>
		            </select>
		        </div>
    		</li>
			<!-- Fin Pierna Habil -->
<?php break;
		case "mano_habil":?>			
			<!-- Dato Mano Habil -->
			 <li>
		        <div class="cell1"><span class="required">*</span>Mano H&aacute;bil</div>
		        <div class="cell2">
		            <select name="cboHandHabil">
		            <option value="0">Seleccione un Mano habil</option>
		            <option value="1"<?php if( $result["hand_habil"]==1) echo 'selected="selected"';?>>Derecha</option>
		            <option value="2"<?php if( $result["hand_habil"]==2) echo 'selected="selected"';?>>Izquierda</option>
		            </select>
		        </div>
    		</li>
			<!-- Fin Mano Habil -->
<?php break;
		case "mipase":?>
			<!-- Dato Mi pase Pertenece -->
			<li>
		        <div class="cell1"><span class="required">*</span>Mi pase pertenece a</div>
		        <div class="cell2">
					<select class="validator {v_required:true}"  onchange="ProfileSport.change_pass(this);" name="cbo_pase">
		         		<option value="0">Seleccione una Opci&oacute;n</option>
		                <option value="1"<?php if( $result["pase"]==1) echo 'selected="selected"';?>>Me pertenece</option>
		                <option value="2"<?php if( $result["pase"]==2) echo 'selected="selected"';?>>Mi Club De Origen</option>
		                <option value="3"<?php if( $result["pase"]==3) echo 'selected="selected"';?>>Mi Club Actual</option>
		                <option value="4"<?php if( $result["pase"]==4) echo 'selected="selected"';?>>Mi Representante</option>
		            </select>
		        </div>
		    </li>
		    
		    <li id="passDescription" <?php if( $result["pase"]==0) echo 'style="display:none"';?>>
		        <div class="cell1"><span class="required">*</span>
						<span id="Pass_description">
								<?php if( $result["pase"]!=0) echo 'Descripcion Pase:';?>
						</span>
				</div>
		        <div class="cell2">
		        	<input type="text" name="txtPass_description" value="<?php echo $result["pase_description"];?>"/>
		        </div>  
    		</li>
    		<!-- Fin Mi pase Pertenece -->
<?php break;
		case "posicion":?>
		<!-- Dato Position -->
            <li>
		        <div class="cell1"><span class="required">*</span>Posici&oacute;n</div>
		        <div class="cell2">
		        	<? $rst = $data->query("SELECT * FROM list_position where codsport =".$CODSPORT." ORDER BY name");?>
			       	<select class="validator {v_required:true}" name="cbo_posicion">
			         <option value="0">Seleccione Posicion</option>
			          <? while( $row=mysql_fetch_array($rst) ){?>
			                <option value="<? echo $row["codposition"];?>"<?php if( $result["codposition"]==$row["codposition"]) echo 'selected="selected"';?>><? echo utf8_encode($row["name"]);?></option>
			            <? }?>
			        </select>
		        </div>  
    		</li>
    		<!-- Fin Dato Position -->
<?php break;
		case "posicion_avanzada":?>
		<!-- Dato Position Avanzada-->					
			<li>
		        <div class="cell1"><span class="required">*</span>Posici&oacute;n Avanzada</div>
		        <div class="cell2">
		        <? $rst = $data->query("SELECT * FROM list_position_advanced 
										where codsport =".$CODSPORT." 
										ORDER BY name");?>
			       	<select class="validator {v_required:true}" name="cbo_posicion_avanzada">
			         <option value="0">Seleccione Posicion Avanzada</option>
			         <? while( $row=mysql_fetch_array($rst) ){?>
			                <option value="<? echo $row["codposition"];?>"<?php if( $result["codpositionavanzada"]==$row["codposition"]) echo 'selected="selected"';?>><? echo utf8_encode($row["name"]);?></option>
			        <? }?>
			       	</select>
		        </div>  
    		</li>
    		<!-- Fin Dato Position Avanzada-->	
  <?php break;
		case "alcances":?>
		<!-- Dato Alcances -->	
			<li>
		        <div class="cell1"><span class="required">*</span>Alcance de Bloqueo</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_alc_bloqueo" value="<?php echo $result["alc_bloqueo"];?>" />	    
		        </div>  
    		</li>
    		<li>
		        <div class="cell1"><span class="required">*</span>Alcance de Ataque</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_alc_ataque" value="<?php echo $result["alc_ataque"];?>" />	    
		        </div>  
    		</li>
    		<li>
		        <div class="cell1"><span class="required">*</span>Alcance Parado</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_alc_parado" value="<?php echo $result["alc_parado"];?>"/>	    
		        </div>  
    		</li>
 <?php break;
		case "mejor_golpe":?>		  	
			<!-- Dato Mejor Golpe -->
            <li>
		        <div class="cell1"><span class="required">*</span>Mejor Golpe</div>
		        <div class="cell2">
		        	<? $rst = $data->query("SELECT * FROM list_best_shot where codsport =".$CODSPORT." ORDER BY name");?>
			       	<select class="validator {v_required:true}"  name="cbo_golpe" onchange="ShowOtro(this.value,'#row_otro_golpe');">
			         	<option value="0">Seleccione Mejor Golpe</option>
			          <? while( $row=mysql_fetch_array($rst) ){?>
			                <option value="<? echo $row["code"];?>"<?php if($result["codbestshot"]==$row["code"]) echo 'selected="selected"';?>><? echo utf8_encode($row["name"]);?></option>
			            <? }?>
			        	<option value="+"<?php if($result["codbestshot"]==null) echo 'selected="selected"';?>>Otro</option>
					</select>
			        
			        
		        </div>  
    		</li>
    		<li id="row_otro_golpe" <?php if( $result["codbestshot"]!=null) echo 'style="display:none"';?>>
    			<div class="cell1"><span class="required">*</span>Otro Golpe</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox"  name="txt_other_shot" value="<?php echo $result["other_bestshot"];?>"/>
				</div>
			</li>
    		<!-- Fin Mejor Golpe --> 	
<?php break;
		case "entrenamientos":?>		  		
		  	<!-- Datos Tipos de Entrenamiento --> 
    		<li>
		        <div class="cell1">Entrenamiento F&iacute;sico</div>
		        <div class="cell2">
		        	<input type="text" class=" inputbox" name="txt_ent_fisico" onkeypress="ValidKey(event,'number','unsigned')" value="<?php echo $result["ent_fisico"];?>" /><span> Hs. Semanales</span> 	    
		        </div>  
    		</li>
    		<li>
		        <div class="cell1">Entrenamiento Gimnasio</div>
		        <div class="cell2">
		        	<input type="text" class="inputbox" name="txt_ent_gim" onkeypress="ValidKey(event,'number','unsigned')" value="<?php echo $result["ent_gim"];?>"/><span> Hs. Semanales</span> 	    
		        </div>  
    		</li>
    		<li>
		        <div class="cell1">Entrenamiento T&aacute;ctico</div>
		        <div class="cell2">
		        	<input type="text" class="inputbox" name="txt_ent_tactico" onkeypress="ValidKey(event,'number','unsigned')"value="<?php echo $result["ent_tactico"];?>" /><span> Hs. Semanales</span> 	    
		        </div>  
    		</li>
    		<li>
		        <div class="cell1">Entrenamiento T&eacute;cnico</div>
		        <div class="cell2">
		        	<input type="text" class="inputbox" name="txt_ent_tecnico" onkeypress="ValidKey(event,'number','unsigned')"value="<?php echo $result["ent_tecnico"];?>"/><span> Hs. Semanales</span> 	    
		        </div>  
    		</li>
    		<!-- Fin Datos Tipos de Entrenamiento -->
<?php break;
		case "seleccionado":?>		  	
		  	<!-- Dato Seleccionado -->
            <li>
		        <div class="cell1"><span class="required">*</span>Seleccionado</div>
		        <div class="cell2">
		        	<?php $rst = $data->query("SELECT * FROM list_selected where codsport =".$CODSPORT." ORDER BY name");?>
			       	<select class="validator {v_required:true}" name="cbo_seleccionado" onchange="ShowOtro(this.value,'#row_otro_seleccionado');" >
			         <option value="0">Seleccione Seleccionado</option>
			          <? while( $row=mysql_fetch_array($rst) ){?>
			                <option value="<? echo $row["codsel"];?>"<?php if($result["codsel"]==$row["codsel"]) echo 'selected="selected"';?>><? echo utf8_encode($row["name"]);?></option>
			            <? }?>
			        <option value="+"<?php if($result["codsel"]==null) echo 'selected="selected"';?>>Otro</option>
			        </select>
		        </div>  
    		</li>
    		<li id="row_otro_seleccionado" <?php if( $result["codsel"]!=null) echo 'style="display:none"';?>>
    			<div class="cell1"><span class="required">*</span>Otro Seleccionado</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox"  name="txt_other_seleccionado" value="<?php echo $result["other_sel"];?>"/>
				</div>
			</li>
    		<!-- Fin Dato Seleccionado -->
<?php break;
		case "mayor_habilidad":?>		  	
		  	<!-- Dato Mayor Habilidad -->
			<li>
		        <div class="cell1"><span class="required">*</span>Mayor Habilidad</div>
		        <div class="cell2">
		        	<? $rst = $data->query("SELECT * FROM list_greater_ability  where codsport =".$CODSPORT." ORDER BY name");?>
			       	<select class="validator {v_required:true}" name="cbo_mayor_habilidad" 
					   onchange="ShowOtro(this.value,'#row_otra_habilidad');ProfileSport.change_ability(this); ">
			         <option value="0">Seleccione Mayor Habilidad</option>
			          <? while( $row=mysql_fetch_array($rst) ){?>
			                <option value="<? echo $row["codability"];?>"<?php if($result["codability"]==$row["codability"]) echo 'selected="selected"';?>><? echo utf8_encode($row["name"]);?></option>
			            <? }?>
			         <option value="+"<?php if($result["codability"]==null) echo 'selected="selected"';?>>Otra</option>
			        </select>
		        </div>  
    		</li>
    		<li id="recursos" class="styleDisplayNone">
		        <div class="cell1"><span class="required">*</span>Recursos Disponibles</div>
		        <div class="cell2">
					<input type="checkbox" name="opc_rec_disp" value="recursos"><span>Slapper</span>
					<input type="checkbox" name="opc_rec_disp" value="recursos"><span>Toques</span>
					<input type="checkbox" name="opc_rec_disp" value="recursos"><span>Amagues de Toques y Bateo</span>
					<input type="checkbox" name="opc_rec_disp" value="recursos"><span>Robar Bases</span>
					<input type="checkbox" name="opc_rec_disp" value="recursos"><span>GranBateo</span>
		        </div>  
    		</li>
    		<li id="row_otra_habilidad" <?php if( $result["codability"]!=null) echo 'style="display:none"';?>>
    			<div class="cell1"><span class="required">*</span>Otra Mayor Habilidad</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox"  name="txt_other_ability" value="<?php echo $result["other_ability"];?>" />
				</div>
			</li>
    		<!-- Fin Dato Mayor Habilidad -->
<?php break;
		case "modalidad":?>		  	
		  	<!-- Dato Modalidad -->
            <li>
		        <div class="cell1"><span class="required">*</span>Modalidad</div>
		        <div class="cell2">
		        	<? $rst = $data->query("SELECT * FROM list_modality where codsport =".$CODSPORT." ORDER BY name");?>
			       	<select class="validator {v_required:true}"  name="cbo_modalidad" onchange="ShowOtro(this.value,'#row_otro_modality');">
			         	<option value="0">Seleccione Modalidad</option>
			          	<? while( $row=mysql_fetch_array($rst) ){?>
			                <option value="<? echo $row["codmod"];?>"<?php if($result["codmod"]==$row["codmod"]) echo 'selected="selected"';?>><? echo utf8_encode($row["name"]);?></option>
			            <? }?>
			        	<option value="+"<?php if($result["codmod"]==null) echo 'selected="selected"';?>>Otra</option>
			        </select>
		        </div>  
    		</li>
    		<li id="row_otro_modality" <?php if( $result["codmod"]!=null) echo 'style="display:none"';?>>
    			<div class="cell1"><span class="required">*</span>Otro Categor&iacute;a</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox"  name="txt_otro_modality"  value="<?php echo $result["other_mod"];?>"/>
				</div>
			</li>
    		<!-- Fin Dato Modalidad -->
<?php break;
		case "rankings":?>	    		
    		<!-- Dato Rankings -->
    		<li>
		        <div class="cell1">Ranking Internacional N&ordm;</div>
		        <div class="cell2">
		        	<input type="text" class="inputbox" name="txt_rank_int" onkeypress="ValidKey(event,'number','unsigned')"value="<?php echo $result["rank_int"];?>"/>
		        </div>  
    		</li>
    		<li>
		        <div class="cell1">Ranking Nacional N&ordm;</div>
		        <div class="cell2">
		        	<input type="text" class="inputbox" name="txt_rank_nac" onkeypress="ValidKey(event,'number','unsigned')"value="<?php echo $result["rank_nac"];?>" />
		        </div>  
    		</li>
    		<li>
		        <div class="cell1">Otro Ranking</div>
		        <div class="cell2">
		        	<input type="text" class="inputbox" name="txt_rank_nombre" value="<?php echo $result["rank_nombre"];?>"/>
		        	<span>Numero</span>
		        	<input type="text" class="inputbox" name="txt_rank_num" onkeypress="ValidKey(event,'number','unsigned')"value="<?php echo $result["rank_nombre_num"];?>"/>
		        </div>  
    		</li>
    		<!-- Fin Dato Rankings -->
<?php break;
		case "categoria":?>
    		<!-- Dato Categoria -->
            <li>
		        <div class="cell1"><span class="required">*</span>Categor&iacute;a</div>
		        <div class="cell2">
		        	<? $rst = $data->query("SELECT * FROM list_category where codsport =".$CODSPORT." ORDER BY name");?>
			       	<select class="validator {v_required:true}"  name="cboCategory" onchange="ShowOtro(this.value,'#row_otro_category');">
			         <option value="0">Seleccione Categor&iacute;a</option>
			          <? while( $row=mysql_fetch_array($rst) ){?>
			                <option value="<? echo $row["codcategory"];?>"<?php if($result["codcategory"]==$row["codcategory"]) echo 'selected="selected"';?>><? echo htmlentities($row["name"]);?></option>
			            <? }?>
			         <option value="+"<?php if($result["codcategory"]==null) echo 'selected="selected"';?>>Otra</option>
			        </select>
		        </div>  
    		</li>
    		<li id="row_otro_category" <?php if( $result["codcategory"]!=null) echo 'style="display:none"';?>>
    			<div class="cell1"><span class="required">*</span>Otro Categor&iacute;a</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox"  name="txt_otro_category" value="<?php echo $result["other_category"];?>"/>
				</div>
			</li>
    		<!-- Fin Dato Categoria -->
<?php break;
		case "debut_internacional":?>    		
    		<!-- Dato Debut Internacional -->
			<li>
		        <div class="cell1"><span class="required">*</span>Debut Internacional</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_debut_internacional" onkeypress="ValidKey(event,'number','unsigned')" value="<?php echo $result["international_debut"];?>"/>	    		</div>  
    		</li>
    		<!-- Fin Dato Debut Internacional -->
<?php break;
		case "alcance":?>     		
    		<!-- Dato Alcance -->
			<li>
		        <div class="cell1"><span class="required">*</span>Alcance</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_alcance" onkeypress="ValidKey(event,'number','unsigned')" value="<?php echo $result["alcance"];?>"/><span> Mts.</span> 	    
		        </div>  
    		</li>
    		<!-- Fin Dato Alcance -->
<?php break;
		case "anios_jugando":?>       		
    		<!-- Dato Anios Alcance-->
    		<li>
		        <div class="cell1"><span class="required">*</span>A&ntilde;os Jugando</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_anios_jugando" onkeypress="ValidKey(event,'number','unsigned')" value="<?php echo $result["years_playing"];?>"/> 	    
		        </div>  
    		</li>
    		<!-- Fin Dato Anios Alcance-->
<?php break;
		case "profesional":?>     		
    		<!-- Dato Profesional desde-->
    		<li>
		        <div class="cell1"><span class="required">*</span>Profesional desde</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_prof_anio" onkeypress="ValidKey(event,'number','unsigned')" value="<?php echo $result["prof_desde"];?>"/>
		        </div>  
    		</li>
    		<!-- Fin Dato Profesional desde -->
<?php break;
		case "ganancias":?>     		
    		<!-- Dato Ganancias USS -->
			<li>
		        <div class="cell1"><span class="required">*</span>Ganancias en U$S</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_ganancias_uss" onkeypress="ValidKey(event,'number','unsigned')"value="<?php echo $result["gainings"];?>"/>
		        </div>  
    		</li>
			<!-- Dato Ganancias USS -->
<?php break;
		case "jugando_desde":?>  			
			<!-- Dato Jugando desde -->
			<li>
		        <div class="cell1"><span class="required">*</span>Jugando desde</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_anios_jugando_desde" onkeypress="ValidKey(event,'number','unsigned')"value="<?php echo $result["playing_from"];?>"/><span>a</span>
					<input type="text" class="validator {v_required:true} inputbox" name="txt_anios_jugando_hasta" onkeypress="ValidKey(event,'number','unsigned')" value="<?php echo $result["playing_up"];?>"/> 
				</div>  
    		</li>
			<!-- Fin Dato Jugando desde -->
<?php break;
		case "debut_primera":?>
			<!-- Dato Debut en Primera -->	 			
			<li>
		        <div class="cell1"><span class="required">*</span>Debut En Primera Divisi&oacute;n</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_debut" onkeypress="ValidKey(event,'number','unsigned')"value="<?php echo $result["primera_liga_debut"];?>"/>
		        </div>  
    		</li>
			<!-- Fin Dato Debut en Primera -->
<?php break;
		case "especialidad":?>			
			<!-- Dato Especialidad -->
			 <li>
		        <div class="cell1"><span class="required">*</span>Especialidad</div>
		        <div class="cell2">
		            <select class="validator {v_required:true}" name="cbo_especialidad" onchange="ShowOtro(this.value,'#row_otro_especialidad');">
		            <option value="0">Seleccione una Especialidad</option>
		            <option<? if( $result["speciality"]=="BMX" ) echo 'selected="selected"';?>>BMX</option>
		            <option<? if( $result["speciality"]=="BMX Supercross" ) echo 'selected="selected"';?>>BMX Supercross</option>
		            <option<? if( $result["speciality"]=="Ciclo-cross" ) echo 'selected="selected"';?>>Ciclo-cross</option>
		            <option<? if( $result["speciality"]=="Continental Profesional" ) echo 'selected="selected"';?>>Continental Profesional</option>
		            <option<? if( $result["speciality"]=="Mountain Bike" ) echo 'selected="selected"';?>>Mountain Bike</option>
		            <option<? if( $result["speciality"]=="Pista" ) echo 'selected="selected"';?>>Pista</option>
		            <option<? if( $result["speciality"]=="Ruta" ) echo 'selected="selected"';?>>Ruta</option>
		            <option<? if( $result["speciality"]=="Ruta y Pista" ) echo 'selected="selected"';?>>Ruta y Pista</option>
		            <option value="+"<? if( $result["speciality"]==null ) echo 'selected="selected"';?>>Otra</option>
		            </select>
		        </div>
    		</li>
    		<li id="row_otro_especialidad" <?php if( $result["speciality"]!=null) echo 'style="display:none"';?>>
    			<div class="cell1"><span class="required">*</span>Otra Especialidad</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox"  name="txt_other_especialidad"value="<?php echo $result["other_speciality"];?>"/>
				</div>
			</li>
			<!-- Fin Especialidad -->
<?php break;
		case "licencia":?>				
			<!-- Dato Licencia -->
			<li>
		        <div class="cell1"><span class="required">*</span>Licencia de boxeador/a</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_licencia" value="<?php echo $result["license"];?>"/>
		        </div>  
    		</li>
			<!-- Fin Dato Licencia -->
<?php break;
		case "disciplina":?>
			<!-- Dato Disciplina -->
			<li>
		        <div class="cell1"><span class="required">*</span>Disciplina</div>
		        <div class="cell2">
		            <select class="validator {v_required:true}"  name="cbo_disciplina" onchange="ShowOtro(this.value,'#row_otro_disciplina');">
		            <option value="0">Seleccione una Disciplina</option>
		            <option<? if( $result["discipline"]=="100 Mts. Llanos" ) echo 'selected="selected"';?>>100 Mts. Llanos</option>
		            <option<? if( $result["discipline"]=="110 Mts. Vallas" ) echo 'selected="selected"';?>>110 Mts. Vallas</option>
		            <option<? if( $result["discipline"]=="200 Mts. Llanos" ) echo 'selected="selected"';?>>200 Mts. Llanos</option>
		            <option<? if( $result["discipline"]=="400 Mts. Llanos" ) echo 'selected="selected"';?>>400 Mts. Llanos</option>
		            <option<? if( $result["discipline"]=="400 Mts. Vallas" ) echo 'selected="selected"';?>>400 Mts. Vallas, Relevo 4 x 100</option>
		            <option<? if( $result["discipline"]=="800 Mts. Llanos" ) echo 'selected="selected"';?>>800 Mts. Llanos</option>
		            <option<? if( $result["discipline"]=="1.500 Mts. Llanos" ) echo 'selected="selected"';?>>1.500 Mts. Llanos</option>
		            <option<? if( $result["discipline"]=="2.000 Mts c/Obst." ) echo 'selected="selected"';?>>2.000 Mts c/Obst.</option>
		            <option<? if( $result["discipline"]=="3.000 Mts. Llanos" ) echo 'selected="selected"';?>>3.000 Mts. Llanos</option>
		            <option<? if( $result["discipline"]=="3.000 Mts. c/Obst." ) echo 'selected="selected"';?>>3.000 Mts. c/Obst.</option>
		            <option<? if( $result["discipline"]=="5.000 Mts. Llanos" ) echo 'selected="selected"';?>>5.000 Mts. Llanos</option>
		            <option<? if( $result["discipline"]=="10.000 Mts. Llanos" ) echo 'selected="selected"';?>>10.000 Mts. Llanos</option>
		            <option<? if( $result["discipline"]=="Marcha" ) echo 'selected="selected"';?>>Marcha</option>
		            <option<? if( $result["discipline"]=="Salto en Largo" ) echo 'selected="selected"';?>>Salto en Largo</option>
		            <option<? if( $result["discipline"]=="Salto en Alto" ) echo 'selected="selected"';?>>Salto en Alto</option>
		            <option<? if( $result["discipline"]=="Salto con Garrocha" ) echo 'selected="selected"';?>>Salto con Garrocha</option>
		            <option<? if( $result["discipline"]=="Bala" ) echo 'selected="selected"';?>>Bala</option>
		            <option<? if( $result["discipline"]=="Jabalina" ) echo 'selected="selected"';?>>Jabalina</option>
		            <option<? if( $result["discipline"]=="Disco" ) echo 'selected="selected"';?>>Disco</option>
		            <option<? if( $result["discipline"]=="Martillo" ) echo 'selected="selected"';?>>Martillo</option>
		            <option<? if( $result["discipline"]=="1/2 Marath&oacute;n" ) echo 'selected="selected"';?>>1/2 Marath&oacute;n</option>
		            <option<? if( $result["discipline"]=="Marath&oacute;n" ) echo 'selected="selected"';?>>Marath&oacute;n</option>
		            <option<? if( $result["discipline"]=="Duathl&oacute;n" ) echo 'selected="selected"';?>>Duathl&oacute;n</option>
					<option<? if( $result["discipline"]=="Triathl&oacute;n" ) echo 'selected="selected"';?>>Triathl&oacute;n</option>
					<option<? if( $result["discipline"]=="Decathl&oacute;n" ) echo 'selected="selected"';?>>Decathl&oacute;n</option>
					<option<? if( $result["discipline"]=="Hexathl&oacute;n" ) echo 'selected="selected"';?>>Hexathl&oacute;n</option>
					<option<? if( $result["discipline"]=="Octathl&oacute;n" ) echo 'selected="selected"';?>>Octathl&oacute;n</option>
					<option value="+"<? if( $result["discipline"]=="+") echo 'selected="selected"';?>>Otra</option>
		            </select>
		        </div>
    		</li>
    		<li id="row_otro_disciplina" <?php if( $result["discipline"]=="+" || $result["discipline"]==null) echo 'style="display:none"';?>>
    			<div class="cell1"><span class="required">*</span>Otra Disciplina</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox"  name="txt_otro_disciplina"value="<?php echo $result["other_discipline"];?>"/>
				</div>
			</li>
			<!-- Fin Dato Disciplina -->
<?php break;
		case "posicion_cancha":?>
			<!-- Dato Posicion en la Cancha -->
			<li>
		        <div class="cell1"><span class="required">*</span>Posici&oacute;n en la Cancha</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_posicion_cancha" value="<?php echo $result["position_court"];?>"/>
		        </div>  
    		</li>
    		<!-- Fin Dato Posicion en la Cancha -->
<?php break;
		case "pala":?>
			<!-- Dato Pala -->   		
    		<li>
		        <div class="cell1"><span class="required">*</span>Pala</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_pala" value="<?php echo $result["pala"];?>"/><span>Marca de la Paleta</span>
		        </div>  
    		</li>
			<!-- Fin Dato Pala -->
<?php break;
		case "companiero":?>
			<!--  Dato Compañero Actual -->
			 <li>
		        <div class="cell1"><span class="required">*</span>Compa&ntilde;ero de Equipo Actual</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_companiero" value="<?php echo $result["partner"];?>"/>
		        </div>  
    		</li>
			<!--  Fin Dato Compañero Actual -->
<?php break;
		case "nadando_desde":?>
			<!--  Dato Nadando desde -->
			<li>
		        <div class="cell1"><span class="required">*</span>Nadando desde</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_nadando_desde" onkeypress="ValidKey(event,'number','unsigned')"value="<?php echo $result["swimming_from"];?>"/>
		        </div>  
    		</li>
    		<!--  Fin Dato Nadando desde -->
<?php break;
		case "entrenador":?>
    		<!--  Dato Entrenador -->
			<li>
		        <div class="cell1"><span class="required">*</span>Entrenador Actual</div>
		        <div class="cell2">
		        	<input type="text" class="validator {v_required:true} inputbox" name="txt_entrenador" value="<?php echo $result["current_coach"];?>"/>
		        </div>  
    		</li>
			<!--  Fin Dato Entrenador -->
<?php break;
		case "anios_escalando":?>
			<!--  Dato Años Escalando -->
			<li>
		        <div class="cell1"><span class="required">*</span>A&ntilde;os Escalando</div>
		        <div class="cell2">
		        	<input name="txt_anios_escalando" type="text" class="validator {v_required:true} inputbox" onkeypress="ValidKey(event,'number','unsigned')" maxlength="2"value="<?php echo $result["years_climbing"];?>"/>
		        </div>  
    		</li>
			<!--  Fin Dato Años Escalando -->	
		<?php break;
	}	
}
?>