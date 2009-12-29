<?
function get_html($tag){
	global $data;
	global $result;
	
	switch($tag){
		case "lastfirstname":?>
			<li><div class="cell1"><span class="required">*</span>Apellido</div><div class="cell2"><input type="text" class="validator {v_required:true} inputbox" name="txt_reg_LastName" onblur="this.value = ucWords(this.value)" value="<? echo $result["lastname"];?>" /></div></li>		
			
			<li><div class="cell1"><span class="required">*</span>Nombre</div><div class="cell2"><input type="text" class="validator {v_required:true} inputbox" name="txt_reg_FirstName" onblur="this.value = ucWords(this.value)" value="<? echo $result["firstname"];?>" /></div></li>			
<?		break;

		case "sex":?>
			<li>
				<div class="cell1"><span class="required">*</span>Sexo</div>
				<div class="cell2">
					<span><input type="radio" name="opt_reg_sex" class="validator {v_required:true}" value="1" <? echo $result["sex"]==1 ? 'checked="checked"' : "";?>>Masculino&nbsp;&nbsp;</span>
					<span><input type="radio" name="opt_reg_sex" class="validator {v_required:true}" value="2" <? echo $result["sex"]==2 ? 'checked="checked"' : "";?>>Femenino</span>
				</div>
			</li>		
<?		break;	

		case "birthdate":?>
			<li>
				<div class="cell1"><span class="required">*</span>Fecha nacimiento</div>
				<div class="cell2">
                	<?
						if( $result["birth"] ){
							$day = substr($result["birth"], 0, 2);
							$month = substr($result["birth"], 3, 2);
							$year = substr($result["birth"], 6, 4);
						}
					?>
                
					<select name="cboBirthDate_Day" class="validator {v_required:true}" style="margin-right:8px" onchange="Registry.show_age()">
					<option value="0">--</option>
					<? for( $n=1; $n<=31; $n++ ){
							if( $n<=9 ){?>
							   <option value="0<? echo $n;?>" <? if( $day==$n ) echo 'selected="selected"';?>>0<? echo $n;?>&nbsp;</option>
						<?  }else{?>
							   <option value="<? echo $n;?>" <? if( $day==$n ) echo 'selected="selected"';?>><? echo $n;?>&nbsp;</option>				
						<?  }?>
					<? }?>
					</select>
					
					<select name="cboBirthDate_Month" class="validator {v_required:true}" style="margin-right:8px" onchange="Registry.show_age()">
					<option value="0">--</option>
					<? for( $n=1; $n<=12; $n++ ){
							if( $n<=9 ){?>
								<option value="0<? echo $n;?>" <? if( $month==$n ) echo 'selected="selected"';?>>0<? echo $n;?>&nbsp;</option>
						 <? }else{?>
							   <option value="<? echo $n;?>" <? if( $month==$n ) echo 'selected="selected"';?>><? echo $n;?>&nbsp;</option>				
						<?  }?>                
					<? }?>
					</select>
					
					<select name="cboBirthDate_Year" class="validator {v_required:true}" onchange="Registry.show_age()">
					<option value="0">--</option>
					<? for( $n=1933; $n<=date('Y'); $n++ ){?>
					<option value="<? echo $n;?>" <? if( $year==$n ) echo 'selected="selected"';?>><? echo $n;?>&nbsp;</option>
					<? }?>
					</select>
				</div>
			</li>		
			<li>
				<div class="cell1">Edad</div>
				<div class="cell2"><input type="text" class="inputbox age"  id="txt_reg_Age" readonly /></div>
			</li>			
<?		break;	

		case "document":?>
			<li>
				<div class="cell1">Tipo de Documento</div>
				<div class="cell2">
					<select name="cbo_reg_TypeDoc" onchange="Registry.show_other_field(this.value, 'rowOtherTypeDoc')">
					<option value="0">&nbsp;</option>
					<option value="DNI" <? if( $result["typedoc"]=="DNI" ) echo 'selected="selected"';?>>DNI</option>
					<option value="Libreta de Enrolamiento" <? if( $result["typedoc"]=="Libreta de Enrolamiento" ) echo 'selected="selected"';?>>Libreta de Enrolamiento</option>
					<option value="Libreta C&iacute;vica" <? if( $result["typedoc"]=="Libreta C&iacute;vica" ) echo 'selected="selected"';?>>Libreta C&iacute;vica</option>
					<option value="+" <? if( $result["typedoc_new"]!="" ) echo 'selected="selected"';?>>Otro</option>
					</select>
				</div>
			</li>		
			<li id="rowOtherTypeDoc" style="display:<? echo $result["typedoc_new"]!="" ? "block" : "none";?>">
				<div class="cell1">Otro Tipo de Documento</div>
				<div class="cell2"><input type="text" class="inputbox"  name="txt_reg_typedoc_other" value="<? echo $result["typedoc_new"];?>" /></div>
			</li>
			<li>
				<div class="cell1">Nro. Documento</div>
				<div class="cell2"><input type="text" class="inputbox" name="txt_reg_nrodoc" value="<? echo $result["nrodoc"];?>" /></div>
			</li>					
<?		break;	

		case "location":?>
			<li>
				<div class="cell1"><span class="required">*</span>Pa&iacute;s</div>
				<div class="cell2">
				  <input type="text" class="validator {v_required:true} inputbox inputsmall" name="txt_reg_country" id="txt_reg_country" onblur="this.value = ucWords(this.value)" attrtable="list_country" value="<? echo utf8_encode($result["country_name"]);?>" attrcode="<? echo $result["country"];?>" />
				</div>
			</li>
			<li>
				<div class="cell1"><span class="required">*</span>Provincia</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox inputsmall" name="txt_reg_province" id="txt_reg_province" onblur="this.value = ucWords(this.value)" attrTable="list_provinces" value="<? echo utf8_encode($result["province_name"]);?>" attrCode="<? echo $result["province"];?>" /></div>
			</li>    
			<li>
				<div class="cell1"><span class="required">*</span>Ciudad</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox"  name="txt_reg_City" onblur="this.value = ucWords(this.value)"  validator="required:true" value="<? echo $result["city"];?>" /></div>
			</li>			
			<li>
				<div class="cell1">C&oacute;digo Postal</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox inputsmall"  name="txt_reg_CP" onkeypress="ValidKey(event,'number','unsigned')" value="<? echo $result["cp"];?>" /></div>
			</li>
<?		break;	

		case "nacionality":?>
			<li>
				<div class="cell1"><span class="required">*</span>Nacionalidad</div>
				<div class="cell2">
					<ul id="list2" class="list">
                    <? 
					$count = 0;
					$to = !isset($result["nacionality"]) ? 1 : 3;
					for( $i=1; $i<=$to; $i++ ){
						if( $i>1 ) {
							$input_name = "txt_reg_nationality".$i;
							$value = $result["nacionality".$i];
						}else{
							$input_name = "txt_reg_nationality";
							$value = $result["nacionality"];						
						}
					?>
					
                    <? if( trim($value)!="" || $to==1 ){$count++;?>
	                    <li><input type="text" class="validator {v_required:true} inputbox inputsmall"  name="<? echo $input_name;?>" validator="required:true" value="<? echo $value;?>" /></li>
                    <? }?>
                        
                  <? }?>                     
					</ul>
                    
                    <? if( $count<3 ){?>
					<div class="button_attach"><a href="#" onclick="Registry.add_field(this, 'list2', 3); return false;">Otra Nacionalidad</a></div>
                    <? }?>
				</div>
			</li>
<?		break;	

		case "passport":?>
			<li>
				<div class="cell1"><span class="required">*</span>Pasaporte</div>
				<div class="cell2">
					<select class="validator {v_required:true}" name="cbo_reg_Passport">
					<option value="0">Seleccione un Pasaporte</option>
					<option value="1" <? if( $result["passport"]==1 ) echo 'selected="selected"';?>>Sin Pasaporte</option>
					<option value="2" <? if( $result["passport"]==2 ) echo 'selected="selected"';?>>Comunitario</option>
					<option value="3" <? if( $result["passport"]==3 ) echo 'selected="selected"';?>>Extracomunitario</option>
					</select>
				</div>
			</li>
<?		break;	

		case "phones":?>
			<li>
				<div class="cell1"><span class="required">*</span>Telefono fijo</div>
				<div class="cell2">
					<input type="text" class="validator {v_required:true} inputbox inputpref1"  name="txt_reg_phone_pref1" onkeypress="ValidKey(event,'number','unsigned')" maxlength="6" value="<? echo $result["phone_pref1"];?>" />
					<input type="text" class="validator {v_required:true} inputbox inputpref2"  name="txt_reg_phone_pref2" onkeypress="ValidKey(event,'number','unsigned')" maxlength="6" value="<? echo $result["phone_pref2"];?>" />
					<input type="text" class="validator {v_required:true} inputbox inputnum"  name="txt_reg_phone_num" onkeypress="ValidKey(event,'number','unsigned')" validator="required:true" maxlength="11" value="<? echo $result["phone"];?>" />
				</div>
			</li>
			
			<li>
				<div class="cell1">Celular/M&oacute;vil</div>
				<div class="cell2">
					<input type="text" class="inputbox inputpref1"  name="txt_reg_cel_pref1" onkeypress="ValidKey(event,'number','unsigned')" maxlength="6" value="<? echo $result["cel_pref1"];?>" />
					<input type="text" class="inputbox inputpref2"  name="txt_reg_cel_pref2" onkeypress="ValidKey(event,'number','unsigned')" maxlength="6" value="<? echo $result["cel_pref2"];?>" />
					<input type="text" class="inputbox inputnum"  name="txt_reg_cel_num" onkeypress="ValidKey(event,'number','unsigned')" maxlength="11" value="<? echo $result["cel"];?>" />
				</div>            
			</li>		
<?		break;	

		case "website":?>
			<li>
				<div class="cell1">Tu Sitio Web</div>
				<div class="cell2"><input type="text" class="inputbox"  name="txt_reg_website" onblur="FormatUrl(this)" value="<? echo $result["website"];?>" /></div>
			</li>		
<?		break;	

		case "language":?>
			<li>
				<div class="cell1">Idioma</div>
				<div class="cell2">
					<ul id="list3" class="list">
                    
                    <? 
					$count = 0;
					$to = !isset($result["language"]) ? 1 : 4;
					for( $i=1; $i<=$to; $i++ ){
					
						if( $i>1 ){
							$language = $result["language".$i];
							$language_name = utf8_encode($result["language_name".$i]);
							$language_level_talk = $result["language".$i."_level_talk"];
							$language_level_write = $result["language".$i."_level_write"];
							$input_name = "txt_reg_language".$i;
							$combo1_name = "cbo_reg_language".$i."_write";
							$combo2_name = "cbo_reg_language".$i."_talk";
						}else{
							$language = $result["language"];
							$language_name = utf8_encode($result["language_name"]);
							$language_level_talk = $result["language_level_talk"];
							$language_level_write = $result["language_level_write"];
							$input_name = "txt_reg_language";
							$combo1_name = "cbo_reg_language_write";
							$combo2_name = "cbo_reg_language_talk";						
						}					
						
						if( trim($language)!="" || $to==1 ){ $count++;
					?>
                                        
                        <li><input type="text" class="inputbox inputsmall"  name="<? echo $input_name;?>" id="<? echo $input_name;?>" onblur="this.value = ucWords(this.value);" attrTable="list_languages" value="<? echo $language_name;?>" attrCode="<? echo $language;?>" /></li>
                        <li>
                            <span>Nivel Hablado:&nbsp;</span>
                            <select name="<? echo $combo1_name;?>">
                                <option value="1" <? if( $language_level_talk==1 ) echo 'selected="selected"';?>>B&aacute;sico</option>
                                <option value="2" <? if( $language_level_talk==2 ) echo 'selected="selected"';?>>Intermedio</option>
                                <option value="3" <? if( $language_level_talk==3 ) echo 'selected="selected"';?>>Avanzado</option>
                            </select>
                            <span>&nbsp;&nbsp;Nivel Escrito:&nbsp;</span>
                            <select name="<? echo $combo2_name;?>">
                                <option value="1" <? if( $language_level_write==1 ) echo 'selected="selected"';?>>B&aacute;sico</option>
                                <option value="2" <? if( $language_level_write==2 ) echo 'selected="selected"';?>>Intermedio</option>
                                <option value="3" <? if( $language_level_write==3 ) echo 'selected="selected"';?>>Avanzado</option>
                            </select>            
                        </li>
                     <? }?>
                        
                    <? }?>                    
					</ul>
                    
                    <? if( $count<4 ){?>
						<div class="button_attach"><a href="#" onclick="Registry.add_field_lang(this, 'list3', 4); return false;">Otro Idioma</a></div>
                    <? }?>
				</div>
			</li>		
<?		break;	

		case "profession":?>
			<li>
				<div class="cell1">Profesi&oacute;n/Actividad</div>
				<div class="cell2"><input type="text" class="inputbox" name="txt_reg_Profession" value="<? echo $result["profession"];?>" /></div>
			</li>
<?		break;	

		case "studies":?>
			<li>
				<div class="cell1">Estudios</div>
				<div class="cell2"><input type="text" class="inputbox" name="txt_reg_Studies" value="<? echo $result["studies"];?>" /></div>
			</li>		
<?		break;	

		case "disability":?>
			<li>
				<div class="cell1">Posee alguna discapacidad</div>
				<div class="cell2">
					<span><input type="radio" name="opt_reg_disability" onclick="Registry.ShowHidden_panel('show', 'rowDisability_1,rowDisability_2');" value="1" <? if( $result["disability"]==1 ) echo 'checked="checked"';?>>Si&nbsp;&nbsp;</span>
					<span><input type="radio" name="opt_reg_disability" onclick="Registry.ShowHidden_panel('hidden', 'rowDisability_1,rowDisability_2');" value="0" <? if( $result["disability"]==0 || !isset($result["disability"]) ) echo 'checked="checked"';?>>No</span>
				</div>
			</li>	
			<li id="rowDisability_1" style="display:<? echo $result["disability"]==1 ? "block" : "none";?>">
				<div class="cell1">Tipo de discapacidad</div>
				<div class="cell2">
				<select name="cbo_reg_TypeDisability">
					<option value="1" <? if( $result["typedisc"]==1 ) echo 'selected="selected"';?>>Motora</option>
					<option value="2" <? if( $result["typedisc"]==2 ) echo 'selected="selected"';?>>Sensorial</option>
					<option value="3" <? if( $result["typedisc"]==3 ) echo 'selected="selected"';?>>Mental</option>
					<option value="4" <? if( $result["typedisc"]==4 ) echo 'selected="selected"';?>>Visceral</option>
				</select>
				</div>
			</li>		
			<li id="rowDisability_2" style="display:<? echo $result["disability"]==1 ? "block" : "none";?>">
				<div class="cell1">Detallar discapacidad</div>
				<div class="cell2"><input type="text" class="inputbox" name="txt_reg_DetDisability" value="<? echo $result["detaildisc"];?>" /></div>
			</li>						
<?		break;	

		case "catcha":?>
			<li>
				<div class="cell1"><span class="required">*</span>Ingrese el c&oacute;digo</div>
				<div class="cell2">
					 <img src="js/catcha/securimage_show.php?sid=<? echo md5(uniqid(time()));?>" id="image" align="absmiddle" />
						<a href="#" onclick="document.getElementById('image').src = 'js/catcha/securimage_show.php?sid=' + Math.random(); return false">Mostrar Otra</a><br />
						<input type="text" id="code" name="code" class="validator {v_required:true} inputbox inputcatcha" />
				</div>
			</li>	
            <li>
                <div class="cell1"><span class="required">*</span>Acepto las pol&iacute;ticas de Privacidad de LexerSports</div>
                <div class="cell2"><br /><input type="checkbox" name="chkPrivacity" /></div>
            </li>            	
<?		break;	

		case "socialreason":?>
			<li>
				<div class="cell1"><span class="required">*</span>Raz&oacute;n Social</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox"  name="txt_reg_SocialReason" value="<? echo $result["business_name"];?>" /></div>
			</li>		
<?		break;	

		case "listsports":?>
			<li>
				<div class="cell1"><span class="required">*</span>Deporte</div>
				<div class="cell2">
					<div class="container_list1">        
						<? $rst = $data->query("SELECT * FROM list_sports ORDER BY name");?>
						<select id="cboListSports" class="validator {v_required:true} list_sports" multiple="multiple">
						<? while( $row=mysql_fetch_array($rst) ){?>
							<option value="<? echo $row["codsport"];?>" title="<? echo $row["name"];?>"><? echo utf8_encode($row["name"]);?></option>
						<? }?>
						</select>        
					</div>
					<ul class="panel">
						<li><a href="#" onclick="Registry.add_items();return false;"><img src="images/icons/arrow_right.png" alt="Agregar" title="Agregar" border="0" /></a></li>
						<li><a href="#" onclick="Registry.remove_items();return false;"><img src="images/icons/arrow_left.png" alt="Quitar" title="Quitar" border="0" /></a></li>
					</ul>
					<div class="container_list2">        
					<? 
						if( isset($result) ){
							if( $_SESSION["tableusers"]=="users_representatives" ){
								$table = "users_representatives_to_sport";
								$field = "codrepr";
							}elseif( $_SESSION["tableusers"]=="users_club" ){
								$table = "users_club_to_sport";
								$field = "codclub";
							}
							$sql = "SELECT * FROM list_sports l INNER JOIN ".$table." r ON l.codsport = r.codsport ";
							$sql.= "WHERE r.".$field."=".$result[$field];
							$rst = $data->query($sql);
					?>
                    
                            <select id="cboListSports_new" name="cboListSports_new" class="list_sports" multiple="multiple">
                            <? while( $row=mysql_fetch_array($rst) ){?>
                                <option value="<? echo $row["codsport"];?>" title="<? echo $row["name"];?>"><? echo utf8_encode($row["name"]);?></option>
                            <? }?>
                            </select>
                    
					<?	}else{?>
							<select id="cboListSports_new" name="cboListSports_new" class="list_sports" multiple="multiple"></select>
                    <?  }?>
					</div>
				</div>
			</li>		
<?		break;	

		case "cuit":?>
			<li>
				<div class="cell1"><span class="required">*</span>CUIT</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox"  name="txt_reg_Cuit" value="<? echo $result["cuit"];?>" /></div>
			</li>
<?		break;	

		case "yearfundation":?>
			<li>
				<div class="cell1"><span class="required">*</span>A&ntilde;o de Fundaci&oacute;n</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox inputsmall" name="txt_reg_YearFoundation" onkeypress="ValidKey(event,'number','unsigned')" maxlength="4" value="<? echo $result["fundation_years"];?>" /></div>
			</li>
<?		break;	

		case "president":?>
			<li>
				<div class="cell1">Presidente</div>
				<div class="cell2"><input type="text" class="inputbox" name="txt_reg_president" onblur="this.value = ucWords(this.value)" value="<? echo $result["president"];?>" /></div>
			</li>		
<?		break;

		case "stadium":?>
			<li>
				<div class="cell1">Nombre del Estadio</div>
				<div class="cell2"><input type="text" class="inputbox" name="txt_reg_stadium" value="<? echo $result["name_stadium"];?>" /></div>
			</li>		
<?		break;		

		case "locationhome":?>
			<li>
				<div class="cell1"><span class="required">*</span>Domicilio Legal</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox" name="txt_reg_LocationHome" validator="required:true" value="<? echo $result["addresse_sede"];?>" /></div>
			</li>		
<?		break;		

		case "competition_category":?>
			<li>
				<div class="cell1">Categor&iacute;a en la que Compite</div>
				<div class="cell2">      
				  <select name="cbo_reg_CompetitionCategory" onchange="Registry.show_other_field(this.value, 'rowOtherCompetetion')">
					  <option value="0">Ninguna</option>
					  <option value="Primera Divisi&oacute;n" <? if( $result["competition_category"]=="Primera Divisi&oacute;n" ) echo 'selected="selected"';?>>Primera Divisi&oacute;n</option>
					  <option value="Segunda Divisi&oacute;n" <? if( $result["competition_category"]=="Segunda Divisi&oacute;n" ) echo 'selected="selected"';?>>Segunda Divisi&oacute;n</option>
					  <option value="Tercera Divisi&oacute;n" <? if( $result["competition_category"]=="Tercera Divisi&oacute;n" ) echo 'selected="selected"';?>>Tercera Divisi&oacute;n</option>
					  <option value="Cuarta Divisi&oacute;n" <? if( $result["competition_category"]=="Cuarta Divisi&oacute;n" ) echo 'selected="selected"';?>>Cuarta Divisi&oacute;n</option>
					  <option value="Quinta Divisi&oacute;n" <? if( $result["competition_category"]=="Quinta Divisi&oacute;n" ) echo 'selected="selected"';?>>Quinta Divisi&oacute;n</option>
					  <option value="Sexta Divisi&oacute;n" <? if( $result["competition_category"]=="Sexta Divisi&oacute;n" ) echo 'selected="selected"';?>>Sexta Divisi&oacute;n</option>
					  <option value="S&eacute;ptima Divisi&oacute;n" <? if( $result["competition_category"]=="S&eacute;ptima Divisi&oacute;n" ) echo 'selected="selected"';?>>S&eacute;ptima Divisi&oacute;n</option>
					  <option value="Octava Divisi&oacute;n" <? if( $result["competition_category"]=="Octava Divisi&oacute;n" ) echo 'selected="selected"';?>>Octava Divisi&oacute;n</option>
					  <option value="Novena Divisi&oacute;n" <? if( $result["competition_category"]=="Novena Divisi&oacute;n" ) echo 'selected="selected"';?>>Novena Divisi&oacute;n</option>
					  <option value="+" <? if( $result["competition_new_category"]!="" ) echo 'selected="selected"';?>>Otras</option>
				  </select>
				</div>
			</li>
			
			<li id="rowOtherCompetetion" style="display:<? echo $result["competition_new_category"]!="" ? "block" : "none";?>">
				<div class="cell1">Otras Categor&iacute;as</div>
				<div class="cell2"><input type="text" class="inputbox"  name="txt_reg_competetion_other" value="<? echo $result["competition_new_category"];?>" /></div>
			</li>
	<?		break;		

		case "charge":?>
			<li>
			  <div class="cell1"><span class="required">*</span>Cargo</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox"  name="txt_reg_tit_charge" value="<? echo $result["titular_charge"];?>" /></div>
			</li>		
<?		break;		

		case "titular_lastfirstname":?>
			<li>
				<div class="cell1"><span class="required">*</span>Apellido</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox"  name="txt_reg_tit_LastName" onblur="this.value = ucWords(this.value)" value="<? echo $result["titular_lastname"];?>" /></div>
			</li>
			
			<li>
				<div class="cell1"><span class="required">*</span>Nombre</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox"  name="txt_reg_tit_FirstName" onblur="this.value = ucWords(this.value)" value="<? echo $result["titular_firstname"];?>" /></div>
			</li>		
<?		break;		

		case "titular_phones":?>
			<li>
				<div class="cell1"><span class="required">*</span>Telefono fijo</div>
				<div class="cell2">
					<input type="text" class="validator {v_required:true} inputbox inputpref1"  name="txt_reg_tit_phone_pref1" onkeypress="ValidKey(event,'number','unsigned')" maxlength="6" value="<? echo $result["titular_phone_pref1"];?>" />
					<input type="text" class="inputbox inputpref2"  name="txt_reg_tit_phone_pref2" onkeypress="ValidKey(event,'number','unsigned')" maxlength="6" value="<? echo $result["titular_phone_pref1"];?>" />
					<input type="text" class="inputbox inputnum"  name="txt_reg_tit_phone_num" onkeypress="ValidKey(event,'number','unsigned')" validator="required:true" maxlength="11" value="<? echo $result["titular_phone"];?>" />
				</div>
			</li>
			<li>
				<div class="cell1">Celular/M&oacute;vil</div>
				<div class="cell2">
					<input type="text" class="inputbox inputpref1"  name="txt_reg_tit_cel_pref1" onkeypress="ValidKey(event,'number','unsigned')" maxlength="6" value="<? echo $result["titular_cel_pref1"];?>" />
					<input type="text" class="inputbox inputpref2"  name="txt_reg_tit_cel_pref2" onkeypress="ValidKey(event,'number','unsigned')" maxlength="6" value="<? echo $result["titular_cel_pref1"];?>" />
					<input type="text" class="inputbox inputnum"  name="txt_reg_tit_cel_num" onkeypress="ValidKey(event,'number','unsigned')" maxlength="11" value="<? echo $result["titular_cel"];?>" />
				</div>            
			</li>		
<?		break;		

		case "titular_document":?>
			<li>
				<div class="cell1">Tipo de Documento</div>
				<div class="cell2">      
				  <select name="cbo_reg_tit_TypeDoc"  onchange="Registry.show_other_field(this.value, 'rowOtherTypeDoc_titular')">
					<option value="0">&nbsp;</option>                    
					<option value="DNI" <? if( $result["titular_typedoc"]=="DNI" ) echo 'selected="selected"';?>>DNI</option>
					<option value="Libreta de Enrolamiento" <? if( $result["titular_typedoc"]=="Libreta de Enrolamiento" ) echo 'selected="selected"';?>>Libreta de Enrolamiento</option>
					<option value="Libreta C&iacute;vica" <? if( $result["titular_typedoc"]=="Libreta C&iacute;vica" ) echo 'selected="selected"';?>>Libreta C&iacute;vica</option>
					<option value="+" <? if( $result["titular_typedoc_new"]!="" ) echo 'selected="selected"';?>>Otro</option>                    
				  </select>
				</div>
			 </li>
             
			<li id="rowOtherTypeDoc_titular" style="display:<? echo $result["titular_typedoc_new"]!="" ? "block" : "none";?>">
				<div class="cell1">Otro Tipo de Documento</div>
				<div class="cell2"><input type="text" class="inputbox"  name="txt_reg_tit_typedoc_other" value="<? echo $result["titular_typedoc_new"];?>" /></div>
			</li>
			 
			 <li>
				<div class="cell1">Nro. de Documento</div>
				<div class="cell2"><input type="text" class="inputbox"  name="txt_reg_tit_nrodoc" value="<? echo $result["titular_nrodoc"];?>" /></div>
			 </li>		
<?		break;		

		case "work":?>
			<li>
				<div class="cell1"><span class="required">*</span>Trabajo</div>
				<div class="cell2">   
					<select class="validator {v_required:true}" name="cbo_reg_work" onchange="Registry.show_other_field(this.value, 'rowOtherWork')">
						<option value="0">Seleccione un Trabajo</option>
						<option value="Independiente" <? if( $result["work"]=="Independiente" ) echo 'selected="selected"';?>>Independiente</option>
						<option value="Club o Instituci&oacute;n" <? if( $result["work"]=="Club o Instituci&oacute;n" ) echo 'selected="selected"';?>>Club o Instituci&oacute;n</option>
						<option value="Grupo Empresario" <? if( $result["work"]=="Grupo Empresario" ) echo 'selected="selected"';?>>Grupo Empresario</option>
						<option value="+" <? if( $result["work_new"]!="" ){?> selected="selected"<? }?>>Otro</option>
					</select>            
				</div>
			</li>		
			<li id="rowOtherWork" style="display:<? echo $result["work_new"]!="" ? "block" : "none";?>">
				<div class="cell1"><span class="required">*</span>Otro trabajo</div>
				<div class="cell2"><input type="text" class="validator {v_required:true} inputbox"  name="txt_reg_work_other" value="<? echo $result["work_new"];?>" /></div>
			</li>
<?		break;		

		case "licence":?>
			<li>
				<div class="cell1"><span class="required">*</span>Posee Licencia</div>
				<div class="cell2">
					<span><input type="radio" name="opt_reg_licence" class="validator {v_required:true}" onclick="Registry.ShowHidden_panel('show', 'rowLicence', 'set_field(\'txt_reg_licence\')');" value="1" <? if( $result["licence_nro"]!="" ) echo 'checked="checked"';?>>Si&nbsp;&nbsp;</span>
					<span><input type="radio" name="opt_reg_licence" class="validator {v_required:true}" onclick="Registry.ShowHidden_panel('hidden', 'rowLicence', 'clear_field(\'txt_reg_licence\')');" value="0" <? if( $result["licence_nro"]=="" || !isset($result["licence_nro"]) ) echo 'checked="checked"';?>>No</span>
				</div>
			</li>
			<li id="rowLicence" style="display:<? echo $result["licence_nro"]!="" ? "block" : "none";?>">
				<div class="cell1">Nro. Licencia</div>
				<div class="cell2"><input type="text" class="inputbox inputsmall"  name="txt_reg_licence" value="<? echo $result["licence_nro"];?>" /></div>
			</li>		
<?		break;		

		case "level":?>
			<li>
				<div class="cell1">Nivel</div>
				<div class="cell2">
					<span><input type="radio" name="opt_reg_level" value="1" <? if( $result["level"]==1 ) echo 'checked="checked"';?>>Profesional&nbsp;&nbsp;</span>
					<span><input type="radio" name="opt_reg_level" value="2" <? if( $result["level"]==2 ) echo 'checked="checked"';?>>Amateur&nbsp;&nbsp;</span>
					<span><input type="radio" name="opt_reg_level" value="3" <? if( $result["level"]==3 || !isset($result["level"]) ) echo 'checked="checked"';?>>Ambos</span>
				</div>
			</li>		
<?		break;		

		case "address":?>
			<li>
				<div class="cell1"><span class="required">*</span>Domicilio Legal</div>
				<div class="cell2"><input type="text" class="inputbox" name="txt_reg_legalAddress" validator="required:true" value="<? echo $result["address"];?>" /></div>
			</li>		
<?		break;		

		case "item":?>
			<li>
				<div class="cell1">Rubro</div>
				<div class="cell2"><input type="text" class="inputbox" name="txt_reg_item" id="txt_reg_item" attrTable="list_companies_items" value="<? echo utf8_encode($result["item_name"]);?>" attrCode="<? echo $result["codcompanylist"];?>" /></div>
			</li>		
<?		break;		
		
		case "photo":?>
            <li>
                <div class="cell1"><span class="required">*</span>Fotos</div>
                <div class="cell2">
                    <ul id="list1" class="list">
                        <li><input type="file" class="validator {v_required:true} inputbox" size="33" name="txtFileUpload" /></li>
                    </ul>
                    <div class="button_attach"><a href="#" onclick="Registry.add_field(this, 'list1', 5); return false;">Adjuntar otra</a></div>
                    <iframe id="iframeUpload" name="iframeUpload" width="400" height="100" frameborder="1" style="display:none;float:left"></iframe>
                    <input type="hidden" name="upload" value="yes">
                </div>
            </li>
		<? break;		
	}	
}
?>