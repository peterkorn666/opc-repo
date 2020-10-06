<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache"); 
$_SESSION["pasos"]=1;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="estilos.css" type="text/css" rel="stylesheet" />
<title>SUP 2015 - Log in</title>
<style type="text/css">
<!--
body {
	background-color: #006699;
	font-family: Arial, Helvetica, sans-serif;
	font-size:12px;
}
-->
</style>
</head>
<body style="background-image:url(../../imagenes/fondo.gif); background-repeat:repeat;">
<form id="form1" name="form1" action="login02.php" method="post">
<table width="700px" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td style="font-size:24px; text-align:center"><img src="../../images/banner.jpg"  /></td>
</tr>
<tr>
<td><br />
  <table width="100%" border="0"cellspacing="0" align="center" bgcolor="#CCCCCC" style="font-family:Verdana, Geneva, sans-serif">
    <tr>
      <td height="35" colspan="4" align="center" valign="middle" bgcolor="#005395" style="font-size:15px; color:#FFFFFF"><strong>Ingrese su usuario y contraseña para editar los datos de los conferencista.&nbsp;</strong></td>
    </tr>
    <?php
   if($_GET["error"]==true){
	 ?>
    <tr >
      <td height="26" colspan="4" align="center" bgcolor="#FFFFFF"><font style="color:#BD3038; font-size:12px"> <strong>El usuario y/o contraseña son incorrectos.</strong></font></td>
    </tr>
    <? } ?>
    <tr>
      <td colspan="4" bgcolor="#E2F8FE" >&nbsp;</td>
    </tr>
    <tr style="font-size:14px">
      <td width="26%" height="58" align="center" valign="middle" bgcolor="#E2F8FE">&nbsp;</td>
      <td width="17%" align="right" valign="middle" bgcolor="#E2F8FE" class="textoSubMargen"><strong>Usuario:&nbsp;<br />
          <br />
          Contraseña:</strong>&nbsp;</td>
      <td width="33%" align="left" bgcolor="#E2F8FE"><input type="text" name="txtUsuario" width="150px" /><br /><br />
        <input type="password" name="txtPassword" width="150px" /></td>
      <td width="24%" align="center" valign="middle" bgcolor="#E2F8FE">&nbsp;</td>
      </tr>
    <tr>
      <td height="48" colspan="4" align="center" valign="middle" bgcolor="#E2F8FE"><input type="submit" onClick="validarLoguin()" name="login" value="Ingresar" style="font-size:15px; font-family:Verdana, Geneva, sans-serif"  /></td>
    </tr>
  </table>
  <br />
</td></tr>
</table>
</form>
</body>
</html>

<script language="javascript">
function validarLoguin() {

	/*CONTROL DE INSTITUCION*/
	if (form1.txtUsuario.value == ""){
		alert("No ha ingresado ningún usuario.");
		form1.txtUsuario.focus();
		return;
	}	
	/*CONTROL DE PASSWORD*/
	if (form1.txtPassword.value == ""){
		alert("No ha ingresado ninguna contraseña.");
		form1.txtPassword.focus();
		return;
	}
	form1.submit();

}
</script>