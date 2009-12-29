<h3>Videos</h3>

<fieldset class="field_gallery">
	<legend>Galer&iacute;a de Videos</legend>
    
    <div class="movies">
    	<ul class="header">
          <li class="movies_list">
          	<div class="cell1">Nombre</div> 
			<div class="cell2">Accion</div>	          
          </li>
    	</ul>
        
    	<ul id="movies_list" class="body">
          
    	</ul>
    </div>

</fieldset>

<fieldset class="field_gallery">
	<legend>Subir Videos</legend>

    <ul id="list1" class="list">
        <li><input type="file" class="inputbox" size="33" name="file_input_name[]" /></li>
    </ul>
    <div class="button_attach"><a href="#" onclick="Media.add_field(this, 'list1', 5); return false;">Adjuntar otra</a></div>
    
    <p><input type="button" onclick="Media.upload();" value="Subir" /></p>
    
    <iframe id="iframeUpload" name="iframeUpload" width="400" height="100" frameborder="1" style="display:;float:left"></iframe>
    <input type="hidden" name="upload" value="video">                        
    <input type="hidden" name="table" value="<? echo $table;?>">                        
</fieldset>
