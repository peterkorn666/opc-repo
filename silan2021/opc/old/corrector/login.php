<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
require("../envioMail_Config.php");
$_SESSION["pasos"]=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link href="estilos.css" type="text/css" rel="stylesheet" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title><?=utf8_encode($congreso)?> - Evaluadores</title>
</head>
<body>
<form id="form1" name="form1" action="login02.php" method="post" onsubmit="return validarLoguin()"><br />
<center>
<table width="582px" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="2"><img src="<?=$rutaBanner?>" width="900"></td>
  </tr>
  <tr>
    <td colspan="2" align="center" bgcolor="#DBF4FF">
<br />
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border:1px #333 solid;">
    <tr>
    <td height="37" colspan="7" align="center" bgcolor="#028DC8" style="color:#FFFFFF">Ingrese su mail y contrase&ntilde;a para realizar las correcciones.&nbsp;</td> 
</tr>
<?php
if($_GET["error"]==true){
?>
<tr >
<td colspan="3" align="center" bgcolor="#FFFFFF"><font style="color:#F00; font-size:12px"> <strong>El usuario y/o contrase&ntilde;a son incorrectos.</strong></font></td>
</tr>
<? } ?>
<tr>
<td width="227" height="19" align="right" valign="middle" bgcolor="#FFFFFF" class="texto1">Usuario:</td>
<td width="199" align="left" valign="middle" bgcolor="#FFFFFF"><input type="text" name="txtUsuario" style="width:100%"/></td>
<td width="132" rowspan="2" align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
</tr>
<tr>
  <td height="24" align="right" valign="middle" bgcolor="#FFFFFF" class="texto1">Contrase&ntilde;a:</td>
<td align="left" valign="middle" bgcolor="#FFFFFF"><input type="password" name="txtPassword" style="width:100%"/></td>
</tr>
<tr>
<td height="48" colspan="3" align="center" valign="middle" bgcolor="#FFFFFF"><input type="submit" value="Conectarse"  class="boton"/></td>
</tr>
</table></td>
</tr>
</table>
</center>
</form>
</body>
</html>
<script language="javascript">
function validarLoguin() {
	/*CONTROL DE INSTITUCION*/
	if (document.form1.txtUsuario.value == ""){
		alert("No ha ingresado ningún usuario.");
		document.form1.txtUsuario.focus();
		return false;
	}	
	/*CONTROL DE PASSWORD*/
	if (document.form1.txtPassword.value == ""){
		alert("No ha ingresado ninguna contraseña.");
		document.form1.txtPassword.focus();
		return false;
	}
	document.form1.submit();
}
</script>