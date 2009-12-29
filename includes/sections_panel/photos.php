<?
include("../../configure.php");
include("../../connection/connection.php");
session_start();

$table = isset($_GET["table"]) ? $_GET["table"] : "images_curri";

if( $table=="images_curri" && ($_SESSION["tableusers"]=="users_sports"||$_SESSION["tableusers"]=="users_representatives") ){
	$sql = "SELECT i.codimage, i.filename FROM images_curri i ";
	$sql.= "INNER JOIN ". $_SESSION["tableusers"] ." u ON i.codimage=u.codimage ";
	$sql.= "WHERE i.coduser=".$_SESSION["coduser"]." and u.coduser=".$_SESSION["coduser"];
	$info_imageselected = $data->get_result($sql);
}	

?>

<h3>Fotos</h3>

<div class="container_combo">
	<div class="cell_left">
        Seleccione una galer&iacute;a de foto&nbsp;
        <select id="cboGallery" class="combo" onchange="Panel.show_section('photos.php?table='+this.value)">
        <option value="images_curri" <? if( $_GET["table"]=="images_curri" ) echo 'selected="selected"';?>>Curriculum</option>
        <option value="images" <? if( $_GET["table"]=="images" ) echo 'selected="selected"';?>>Otras fotos</option>
        </select>
    </div>
    <? if( $table=="images_curri" && $info_imageselected!="N/A" ){?>
	<div class="cell_right"><b>Foto seleccionada:</b> <a href="#4" onclick="return false;"><? echo $info_imageselected["filename"];?></a></div>
    <? }?>
</div>

<fieldset class="field_gallery">
	<legend>Galer&iacute;a de Fotos</legend>
    
  	<? 
		$rstImages = $data->query("SELECT * FROM ".$table." WHERE coduser=".$_SESSION["coduser"]." ORDER BY codimage");
		$countImages = mysql_num_rows($rstImages);
	?>  
      
    <? if( $countImages>0 ){?>  
    <div id="gallery" class="content">
        <div id="controls" class="controls"></div>
        <div id="loading" class="loader"></div>
        <div id="slideshow" class="slideshow"></div>
		<div id="caption" class="embox"></div>
    </div>
    
    <div id="thumbs" class="navigation">
        <ul class="thumbs noscript">        
	       	<? while($row=mysql_fetch_array($rstImages)){?>        
            <li>
                <a class="thumb" href="container/images/<? echo $row["filename"];?>">
                    <img src="container/images/thumbs/<? echo $row["filename"];?>" alt="<? echo $row["filename"];?>" title="" width="75" height="75" />
                </a>
                
                <div class="caption">
                    <div class="image-title"><? echo $row["filename"];?></div>
                    <div class="image-desc">
                        <a href="#" class="link1" onclick="Media.image_delete(<? echo $row["codimage"];?>, '<? echo $row["filename"];?>', '<? echo $table;?>'); return false;"><img src="images/icons/delete.gif" alt="Eliminar" title="Eliminar Foto" border="0" /><span class="slink">Eliminar</span></a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <? if( $table=="images_curri" ){
							if( $row["codimage"]==$info_imageselected["codimage"] ){?>
                            
		                        <a href="#" class="link1" onclick="Media.sel_image(<? echo $row["codimage"];?>, 1); return false;"><img src="images/icons/remove.png" alt="Deseleccionar" title="Deseleccionar" border="0" /><span class="slink">Deseleccionar</span></a>
                                
                         <? }else{?>
                         
		                        <a href="#" class="link1" onclick="Media.sel_image(<? echo $row["codimage"];?>); return false;"><img src="images/icons/add.png" alt="Seleccionar" title="Seleccionar" border="0" /><span class="slink">Seleccionar</span></a>
                         
                        <?  }
						   }?>
                        
                        
                    </div>
                </div>        
            </li>
            <? }?>            
        </ul>
    </div><!--end #thumbs-->
    <? }else{?>
    	
        <div class="image_message">No hay im&aacute;genes.</div>
        
    <? }?>
</fieldset>

<? if( ($table=="images_curri" && $countImages<5) || ($table=="images" && $countImages<30) ){?>
<fieldset class="field_gallery">
	<legend>Subir Fotos</legend>

    <ul id="list1" class="list">
        <li><input type="file" class="inputbox" size="33" name="file_input_name[]" /></li>
    </ul>
    <div class="button_attach"><a href="#" onclick="Media.add_field(this, 'list1', 5); return false;">Adjuntar otra</a></div>
    
    <p><input type="button" onclick="Media.upload();" value="Subir" /></p>
    
    <iframe id="iframeUpload" name="iframeUpload" width="400" height="100" frameborder="1" style="display:none;float:left"></iframe>
    <input type="hidden" name="upload" value="foto">                        
    <input type="hidden" name="table" value="<? echo $table;?>">                        
</fieldset>
<? }?>