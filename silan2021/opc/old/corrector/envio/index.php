<?php
	set_time_limit(30000000000);
	session_start();
	if($_SESSION["Login"]!="Logueado"){
		header("Location: ../login.php");
		die();
	}
	require("../../conexion.php");
	require "../../clases/class.Cartas.php";
	
	$cartas = new cartas();
	
	$personas = $_POST["select"];
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
			$filtro .= " $sig id='".$pers."'";
			$i++;
		}
	}
	
	$sql = "SELECT * FROM evaluadores $filtro ORDER BY id;";
	//echo $sql;
	$query = $con->query($sql);
	$cants = $query->num_rows;
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Envio de Mail - Arroz 2018</title>
<link rel="stylesheet" href="estilos/envio.css" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.11.1.min.js" language="javascript"></script>
<script type="text/javascript" src="../../js/jquery.time.js" language="javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#all").click(function(){
		var checked_status = this.checked;
		$("input[name='box[]']").each(function(){
			this.checked = checked_status;
		});
	});
})
function box_mail(html){
	$("#estados").append(html);
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
<form action="process.php" method="post" target="envo">
<div class="contenedor">
<div class="tituloForm">Env&iacute;o de Mails</div>
<table width="457" border="0" cellspacing="1" cellpadding="2" style="float:left">
  <tr>
    <td width="94">Asunto</td>
    <td width="175"><input type="text" name="asunto" style="width:100%" /></td>
    <td width="172"><input type="checkbox" name="nombre_conferencista" value="1" />
      Nombre del evaluador</td>
  </tr>
  <tr>
    <td>Predefinido</td>
    <td colspan="2">
    	<select style="width:100%" name="predefinido">
        	<option value=""></option>
            <?php
				 $listaPredefinidas = $cartas->cargarPredefinidas("Conferencistas");
				  while ($predefinida = $listaPredefinidas->fetch_array()){
					  echo "<option value='".$predefinida["idCarta"]."'>".$predefinida["titulo"]."</strong> - ".$predefinida["subtitulo"]."</option>";
				  }
			?>
        </select>
    </td>
    </tr>
  <tr>
    <td colspan="2">Enviar a evaluadores seleccionados</td>
    <td><input type="checkbox" name="enviarEstablecimientos" value="1" /></td>
  </tr>
  <tr>
    <td>Enviar copia</td>
    <td colspan="2"><input type="text" name="mailA" style="width:90%" />      <input type="checkbox" name="enviarA" value="1" /></td>
    </tr>
  <tr>
    <td valign="top">Mensaje manual</td>
    <td colspan="2"><textarea style="width:100%; height:200px;" name="mensaje"></textarea></td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center"><input type="submit" value="Enviar" id="envio_s" onclick="limpiar()" style="width:150px;" /></td>
    <td align="center"><a href="../personal.php">volver</a></td>
  </tr>
</table>
<div style=" float:right; max-height:400px; overflow:auto;margin-left:10px;">
<table width="450" border="0" cellspacing="1" cellpadding="2" style="float:right; margin-left:10px;">
 <tr>
    <td><input id="all" type="checkbox" value="<?=$row->id?>" /></td>
    <td>Seleccionar todos (<?=$cants?>)</td>
  </tr>
<?php
	while($row = $query->fetch_object()){
?>
  <tr>
    <td width="20"><input type="checkbox" class="personas" value="<?=$row->id?>" name="box[]" /></td>
    <td width="469"><?="[".$row->id."] ".$row->nombre?></td>
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
<iframe name="envo" frameborder="0" width="100%"></iframe>
</div>
<input type="hidden" name="fin" id="fin" value="1" />
</form>
</body>
</html>