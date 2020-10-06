<?php
	session_start();
	if($_SESSION["nivel"]!=1){
		header("Location: login.php");
		die();		
	}
	require("../envioMail_Config.php");
	require("../conexion.php");
	if($_GET["key"]){
		$sql = $con->query("SELECT * FROM evaluadores WHERE id='{$_GET["key"]}'");
		$row = $sql->fetch_array();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Crear Evaluador</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="crearEvaluadorEnviar.php" method="post">
<div align="center"><img src="<?=$rutaBanner?>" style='width: 580px;' alt="banner" /></div>
<br />
<table width="290" border="0" cellspacing="0" cellpadding="5" align="center" bgcolor="#FFFFFF" style="border:1px solid">
  <tr>
    <td colspan="2" align="center"><strong>
      <? if($_GET["estado"]==1){echo "<span style='color:darkgreen'>Se guard&oacute; el evaluador correctamente.</span>";}else if($_GET["estado"]==2){echo "<span style='color:red'>Hubo un problema al agregar el evaluador</span>";}?>
    </strong></td>
    </tr>
  <tr>
    <td width="80">Nombre</td>
    <td width="200"><input type="text" style="width:90%" name="nombre" value="<?=$row["nombre"]?>" /></td>
  </tr>
  <tr>
    <td>Mail</td>
    <td><input type="text" style="width:90%" name="mail" value="<?=$row["mail"]?>" /></td>
  </tr>
  <tr>
    <td>Pais</td>
    <td><input type="text" style="width:90%" name="pais" value="<?=$row["pais"]?>" /></td>
  </tr>
  <tr>
    <td>Nivel</td>
    <td><input type="text" style="width:14%" maxlength="1" name="nivel"  value="<?=$row["nivel"]?>"/> (1-2-3)</td>
  </tr>
  <tr>
    <td>Clave</td>
    <td><input type="text" style="width:90%" name="clave" value="<?=$row["clave"]?>" /></td>
  </tr>
  <tr>
    <td height="50" colspan="2" align="center">&nbsp;&nbsp;&nbsp;      <input type="submit" value="Guardar" style="width:150px;" /></td>
  </tr>
</table>
<input type="hidden" name="key" value="<?=$row["id"]?>" />
</form>
</body>
</html>