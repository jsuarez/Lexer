<?
if( isset($_GET["coduser"]) ){
	require_once("../../configure.php");
	require_once("../../connection/connection.php");
	header('Content-type: text/html; charset=utf-8');
	
	$result = $data->get_result("SELECT * FROM users WHERE coduser=".$_GET["coduser"]);
}

?>

<h3>Datos del Usuario</h3>
<ul class="form">
	<li>
    	<div class="cell1"><span class="required">*</span>E-mail</div>
        <div class="cell2"><input type="text" class="validator {v_required:true, v_email:true} inputbox" id="txt_reg_Email" name="txt_reg_Email"  onblur="this.value=this.value.toLowerCase();" value="<? echo $result["email"];?>" /></div>
    </li>
    
	<li>
    	<div class="cell1"><span class="required">*</span>Repite tu E-mail</div>
        <div class="cell2"><input type="text" class="validator {v_required:true, v_email:true,v_compare:'txt_reg_Email'} inputbox" id="txt_reg_RepeatEmail"  name="txt_reg_RepeatEmail" onblur="this.value=this.value.toLowerCase();" /></div>
    </li>
    
	<li>
    	<div class="cell1"><? if( !isset($_GET["coduser"]) ){?><span class="required">*</span><? }?>Contrase&ntilde;a</div>
        <div class="cell2"><input type="password" class="validator {v_required:true, v_password:[6,10]} inputbox" id="txt_reg_Pass" name="txt_reg_Pass" validator="<? if( !isset($_GET["coduser"]) ){?>required:true,<? }?>compare:'txt_reg_Pass2'" /></div>
    </li>
    
	<li>
    	<div class="cell1"><? if( !isset($_GET["coduser"]) ){?><span class="required">*</span><? }?>Confirmar contrase&ntilde;a</div>
        <div class="cell2"><input type="password" class="validator {v_required:true, v_password:[6,10], v_compare:'txt_reg_Pass'} inputbox" id="txt_reg_Pass2" name="txt_reg_Pass2"/></div>
    </li>
    
	<li>
    	<div class="cell1">Deseo recibir Novedades de LexerSports</div>
        <div class="cell2"><br /><input type="checkbox" name="chkNewsletters" <? echo $result["newsletters"]==1 || !isset($result) ? 'checked="checked"' : '';?>" /></div>
    </li>
</ul>

<? if( isset($_GET["coduser"]) ){?>

    <div class="buttonRegister">
        <input type="button" value="Guardar" onclick="Registry.send('registry_user.php', 'edit', '<? echo $_GET["coduser"];?>');">
        <input type="reset" value="Reset">
    
    </div>
        
<? }?>