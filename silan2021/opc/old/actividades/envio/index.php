<?php
	session_start();
	if($_SESSION["LogIn"]!="ok"){
		header("Location: ../login.php");
		die();
	}
	require("../../conexion.php");
	require "../../clases/class.Cartas.php";
	
	$cartas = new cartas();
	
	$personas = $_POST["personas"];
	//var_dump($_POST);
	//$filtro = "WHERE ". 1;
	
	if(count($personas)>0){
		$i = 0;
		foreach($personas as $pers){
			if($i==0){
				$sig = "WHERE ";
			}else{
				$sig = " OR ";
			}
			$filtro .= " $sig ID_Personas='".$pers."'";
			$i++;
		}
	}
	
	$sql = "SELECT * FROM personas $filtro ORDER BY ID_Personas;";
	//echo $sql;
	$query = mysql_query($sql,$con) or die(mysql_error());
	$cants = mysql_num_rows($query);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Envio de Mail -  Ingeniera 2014</title>
<link rel="stylesheet" href="estilos/envio.css" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.11.1.min.js" language="javascript"></script>
<script type="text/javascript" src="../../js/jquery.time.js" language="javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#all").click(function(){
		var checked_status = this.checked;
		$("input[name=box[]]").each(function(){
			this.checked = checked_status;
		});
	});
})
function box_mail(mail,estado){
	if(estado==1){
		$("#estados").append('<div class="estado_ok">Se envio correctamente a los mails: '+mail+'</div>').hide().fadeIn("slow");
	}else{
		$("#estados").fadeIn("slow").append('<div class="estado_error">Error al enviar a los mails: '+mail+'</div>').hide().fadeIn("slow");
	}
	$("#fin").val("1");
}
function vald(){
	//return $("#fin").is(':') ? this.wait('mouseleave') : this;
}
function limpiar(){
	$("#estados").html("");
	
	$("#envio_s").attr("disabled", "disabled");
	$("#envio_s").delay(5000).removeAttr("disabled");
	
	$(".personas:checked").each($).wait(3000, function(index){
			if($("#fin").val()==1){
				$(this).attr("checked",false);
				$("#fin").val("0");
			}else{
				return;
			}
		//	box_mail("gega",1);
	})
}

</script>
</head>

<body>
<form action="enviar.php" method="post" target="envo">
<div class="contenedor">
<div class="tituloForm">Env&iacute;o de CAU 2014</div>
<table width="383" border="0" cellspacing="1" cellpadding="2" style="float:left">
  <tr>
    <td width="61">Asunto</td>
    <td width="155"><input type="text" name="asunto" style="width:100%" /></td>
    <td width="151"><input type="checkbox" name="nombre_conferencista" value="1" />
      Nombre Conferencista</td>
  </tr>
  <tr>
    <td>Predefinido</td>
    <td colspan="2">
    	<select style="width:100%" name="predefinido">
        	<option value=""></option>
            <?php
				 $listaPredefinidas = $cartas->cargarPredefinidas("Conferencistas");
				  while ($predefinida = mysql_fetch_array($listaPredefinidas)){
					  echo "<option value='".$predefinida["idCarta"]."'>".$predefinida["titulo"]."</strong> - ".$predefinida["subtitulo"]."</option>";
				  }
			?>
        </select>
    </td>
    </tr>
  <tr>
    <td colspan="2">Enviar a conferencista</td>
    <td><input type="checkbox" name="enviarEstablecimientos" value="1" /></td>
  </tr>
  <tr>
    <td>Enviar a</td>
    <td colspan="2"><input type="text" name="mailA" style="width:90%" />      <input type="checkbox" name="enviarA" value="1" /></td>
    </tr>
  <tr>
    <td valign="top">Mensaje</td>
    <td colspan="2"><textarea style="width:100%; height:200px;" name="mensaje"></textarea></td>
    </tr>
  <tr>
    <td colspan="2" valign="top">Enviar ubicaci&oacute;n</td>
    <td align="left"><input type="checkbox" name="ubicacion" value="1" /></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center"><input type="submit" value="Enviar" id="envio_s" onclick="limpiar()" style="width:150px;" /></td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<div style=" float:right; max-height:400px; overflow:auto;margin-left:20px;">
<table width="500" border="0" cellspacing="1" cellpadding="2" style="float:right; margin-left:10px;">
 <tr>
    <td><input id="all" type="checkbox" value="<?=$row->id?>" /></td>
    <td>Seleccionar todos (<?=$cants?>)</td>
  </tr>
<?php
	while($row = mysql_fetch_object($query)){
?>
  <tr>
    <td width="20"><input type="checkbox" class="personas" value="<?=$row->ID_Personas?>" name="box[]" /></td>
    <td width="469"><?="[".$row->ID_Personas."] ".utf8_encode($row->nombre).", ".utf8_encode($row->apellido)?></td>
  </tr>
<?php
	}
?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<div style="clear:both"></div>
<p>&nbsp; </p>
<div id="estados"></div>
<iframe name="envo" style="display:none"></iframe>
</div>
<input type="hidden" name="fin" id="fin" value="1" />
</form>
</body>
</html>