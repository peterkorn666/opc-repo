<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
include "../conexion.php";
include "../envioMail_Config.php";
require "../clases/class.Conferencistas.php";
$conferencista = new conferencistas_congreso();
require "../clases/class.Cartas.php";
$cartas = new cartas();
if($_POST["select"]!=""){	
	$lista = $conferencista->seleccionar_evaluadores_del_filtrado($_POST["select"]);
	$_SESSION["listaConferncistas"] = $_POST["select"];
	$totalEncontrados = mysql_num_rows($conferencista->seleccionar_evaluadores_del_filtrado($_POST["select"]));		
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$congreso?> - Envio de mails</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="../../programa/js/ajax.js"></script>
<script language="javascript" type="text/javascript" src="funciones.js"></script>
</head>
<body style="background-color:#D9D8DC; font-family:Arial, Helvetica, sans-serif;">
<form name="form1" action="envioMail_2.php" method="post">
<center>
  <img src="<?=$dirBanner?>" alt="banner" id="banner" /><br />
  <br />
<table width="900px" cellpadding="5" cellspacing="0" style="border:1px; border-color:#999999; border-style:solid">
<tr>
<td align="center" bgcolor="#FFFFFF" class="marco" colspan="5">Envio de E-mails a conferencistas</td>
</tr>
<tr>
  <td colspan="2" align="right" valign="top" bgcolor="#FFFFFF" class="texto" ><span class="texto">
    <input type="checkbox" value="1" name="copia" />
  </span>Enviar  a la siguiente direcci&oacute;n:</td>
  <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF"><input name="direccion" type="text" class="texto" style="width:98%" value="" /></td>
  <td width="205" rowspan="5" align="left" valign="top" bgcolor="#FFFFFF" class="texto">
    <?
echo "<span style='color:#AD1019; font:Verdana, Arial, Helvetica, sans-serif; font-size:11px'> <strong>Se enviara el mail a:<br></span><span style='color:#003399; font:Verdana, Arial, Helvetica, sans-serif; font-size:11px'>";
echo $totalEncontrados." conferencista</strong><br></span>
<input type='checkbox' value='1' name='correos' /> Enviar a los siguientes destinatarios:
<br />
<ul style='color:#000000; font:Verdana, Arial, Helvetica, sans-serif; font-size:11px'>";
while ($row = mysql_fetch_object($lista)){
echo "<li>";
echo $row->mail;
echo "</li>";		
}
echo "</ul>";
?>    </td>
</tr>
<tr valign="top">
<td width="71" align="right" bgcolor="#FFFFFF" class="texto" ><strong>Asunto:</strong></td>
<td width="211" align="left" bgcolor="#FFFFFF"><input name="asuntoMail" type="text" class="texto" style="width:100%" value="<?=$asuntoMail?>"></td>
<td width="154" align="left" bgcolor="#FFFFFF" class="texto">Nombre Apellido</td>
<td width="207" align="left" bgcolor="#FFFFFF"><input name="asuntoMail2" type="text" class="texto" style="width:98%" value="<?=$asuntoMail2?>" /></td>
</tr>
<tr valign="top">
  <td colspan="2" align="right" bgcolor="#FFFFFF" class="texto">Enviar demo</td>
  <td colspan="2" align="left" bgcolor="#FFFFFF" class="texto"><input type="checkbox" name="demo" value="demo" /></td>
</tr>
<tr valign="top">
  <td colspan="2" align="right" bgcolor="#FFFFFF" class="texto">Seleccione una carta predefinida para enviar
    <?   $listaPredefinidas = $cartas->cargarPredefinidas("Conferencistas");
		 $listaPredefinidas2 = $cartas->cargarPredefinidas("Conferencistas");?></td>
  <td colspan="2" align="left" bgcolor="#FFFFFF" class="texto"><select name="carta" class="texto" style="width:98%" onchange="mostrarDivManual(this.value)">
<option value="manual" style="background-color:#F3F3F3">Carta Manual</option>
<?	while ($predefinida = mysql_fetch_array($listaPredefinidas)){ ?>     
	<option value="<?=$predefinida["idCarta"]?>"><?=$predefinida["titulo"]?> - <?=$predefinida["subtitulo"]?></option>
<?  }	?></select>
<?	while ($predefinida2 = mysql_fetch_array($listaPredefinidas2)){ ?> 
<input type="hidden" name="asunto_<?=$predefinida2["idCarta"]?>" id="asunto_<?=$predefinida2["idCarta"]?>" value="<?=$predefinida2["asunto"]?>" />
     <?  }	?></td>
  </tr>
<tr>
<td colspan="4" align="left" valign="top" bgcolor="#FFFFFF" class="texto">
<div id="divMensaje" style="display:none">
<strong>Mensaje:</strong>  <textarea name="cuerpoMail" rows="15" class="texto" style="padding:10px; width:98%; font-family:Arial, Helvetica, sans-serif; font-size:12px"><?=$cuerpoMail?></textarea></div></td>
</tr>
<tr>
<td colspan="5" align="center" valign="top" bordercolor="#FFFFFF" bgcolor="#FFFFFF"><input name="atrasMail" type="button" class="boton" onclick="VolverConsulta()" value="Volver">&nbsp;&nbsp;&nbsp;&nbsp;<input name="enviarMailBoton2" type="button" class="boton" onclick="ValidarForm()" value="Enviar E-mail" /></td>
</tr>
</table>
</center>
</form>
</body>
</html>
<script>
function ValidarForm(){
	if(document.form1.asuntoMail.value==""){
		alert("Debe ingresar un asunto");
		form1.asuntoMail.focus();
		return;
	}
	if((document.form1.copia.checked==false)&&(document.form1.correos.checked==false)){
		alert("Debe seleccionar algún destinatario.");
		return;
	}if((document.form1.copia.checked==true)&&(document.form1.direccion.value=="")){
		alert("Ingrese algúna direccion de correo");
		document.form1.direccion.focus();
		return;
	}
	document.form1.submit();
}
function VolverConsulta(){
	document.location.href="listado.php";	
}
function mostrarDivManual(cual){
	if(document.form1.carta.value=="manual"){
		document.getElementById("divMensaje").style.display = "block";
		document.form1.asuntoMail.value = "";
		document.form1.asuntoMail2.value = "";
	}else{
		document.getElementById("divMensaje").style.display = "none";
		document.form1.asuntoMail.value = document.getElementById("asunto_"+cual).value;
		document.form1.asuntoMail2.value = " ";
	}	
}
mostrarDivManual();
</script>