<?php
header('Content-Type: text/html; charset=iso-8859-1');
require("../conexion.php");
require("../envioMail_Config.php");
$id = $_GET["id"];
$sql = "SELECT * FROM evaluaciones as e JOIN trabajos_libres as t ON e.numero_tl=t.numero_tl JOIN evaluadores as v ON v.id=e.idEvaluador WHERE e.idEvaluador='$id'";
$query = mysql_query($sql,$con) or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
   $(".trabajos").on("keyup",function(){
		if(this.value==" "){
			this.value = "";
			return false;
		}
		var caracter = /^([0-9])*$/;
		if (!this.value.match(caracter)){
			this.value = "";
			return false;
		}
   });
});
</script>
</head>

<body>

<form target="frame" method="post" name="form1" id="form1">
<table width="900" border="0" cellspacing="0" cellpadding="5" align="center" id="tablaevaluadores">
  <tr>
    <td colspan="5" align="center" bgcolor="#00289A"><iframe name="frame" id="frame" frameborder="0" class="frame"></iframe><img src="<?=$rutaBanner?>" alt="banner" style="margin-top:-150px" /></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" bgcolor="#FFFFFF">
    <table width="98%" border="0" cellspacing="1" cellpadding="5">
      <tr>
        <td width="31" valign="top" bgcolor="#F0F4FF"><strong>ID</strong></td>
        <td width="80" valign="top" bgcolor="#F0F4FF"><strong>Nombre</strong></td>
        <td width="143" valign="top" bgcolor="#F0F4FF"><strong>Mail</strong></td>
        <td width="65" valign="top" bgcolor="#F0F4FF"><strong>Clave</strong></td>
        <td width="63" valign="top" bgcolor="#F0F4FF"><strong>Pais</strong></td>
        </tr>
<?
$i = 0;
while($row = mysql_fetch_object($query)){
	if($i==0){
?>
      <tr>
        <td style="border-bottom:1px dashed black"><?=$row->id?></td>
        <td style="border-bottom:1px dashed black"><?=$row->nombre?></td>
        <td style="border-bottom:1px dashed black"><?=$row->mail?></td>
        <td style="border-bottom:1px dashed black"><?=$row->clave?></td>
        <td style="border-bottom:1px dashed black"><?=$row->pais?></td>
	  </tr>
      <tr>
        <td bgcolor="#F0F4FF" style="border-bottom:1px dashed black"><strong>Numero</strong></td>
        <td bgcolor="#F0F4FF" style="border-bottom:1px dashed black"><strong>Titulo</strong></td>
        <td bgcolor="#F0F4FF" style="border-bottom:1px dashed black"><strong>Tipo</strong></td>
        <td bgcolor="#F0F4FF" style="border-bottom:1px dashed black"><strong>&Aacute;rea</strong></td>
        <td bgcolor="#F0F4FF" style="border-bottom:1px dashed black">&nbsp;</td>
	  </tr>
<?
	}
?>
      <tr>
        <td style="border-bottom:1px dashed black"><?=$row->numero_tl?></td>
        <td style="border-bottom:1px dashed black"><?=mb_strtolower($row->titulo_tl,"iso-8859-1")?></td>
        <td style="border-bottom:1px dashed black"><?=$row->tipo_tl?></td>
        <td style="border-bottom:1px dashed black"><?=$row->area_tl?></td>
        <td style="border-bottom:1px dashed black"></td>
      </tr>
<?
$i = $i+1;
}
?>
    </table>
   </td>
  </tr>
  <tr>
  	<td colspan="5" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
<script type="text/javascript">
function addinput(id){
	var inpt = document.createElement('input');
		inpt.type="text";
		inpt.name="trabajos"+id+"[]";
		inpt.maxLength = 3;
		inpt.className = "trabajos";
		document.getElementById("moreinput_"+id).appendChild(inpt);
}
function guardarWork(id){
	var trabajos = document.form1["trabajos"+id+"[]"];
	var minimo = false;
	for(i=0;i<trabajos.length;i++){
		if(document.form1["trabajos"+id+"[]"][i].value!=""){
			if(document.form1["trabajos"+id+"[]"][i].value.length<3){
				minimo = true;
			}
		}
	}
	
	if(minimo){
		alert("Los campos deben contener 3 numeros");
		return false;
	}
	document.form1.action = "guardarWork.php?id="+id;
	document.form1.submit();
}

</script>