<? 	
include('inc/sesion.inc.php');
include "conexion.php"; 
?>
<script  src="js/instituciones.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style>
body{
background-color:#666666;
 
}
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#666666" bgcolor="#666666" style="font-family:Arial Narrow; font-size:14px">
  <tr valign="top">
    <td height="10" bordercolor="#999999" bgcolor="#FFFFFF">Con marca: <a href="#" onClick="unificarInstitucion()">Unificar Instituci&oacute;n</a></td>
  </tr>
  <tr valign="top">
    <td width="50%" height="10" bordercolor="#999999" bgcolor="#666666"><font color="#FFFFFF" size="2"><strong>Tipos de instituciones Existentes:</strong></font></td>
  </tr>
</table>
<div style="height:350px; overflow:auto;"> 
    <font size="2">
<form action="unificarInstituciones.php" method="post" name="formP" id="formP">
	   <table width="100%" border="0" cellspacing="0" cellpadding="0" bordercolor="#999999" bgcolor="#FFFFCC" style="font-family:Arial Narrow; font-size:14px">
<?	$sql = "SELECT * FROM instituciones ORDER by Institucion ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){ ?>
  <tr>
    <td width="20"><input name="uni[]" type="checkbox" id="uni[]" value="<?=$row["ID_Instituciones"]?>"></td>
    <td>&nbsp;<font size="2">
   <?	
	echo  "<a href='altaInstitucion.php?id=" . $row["ID_Instituciones"]  . "' target='_parent'><img src='img/modificar.png' border='0' alt='Modificar esta instituci&oacute;n'></a>";
	echo  "<a href='javascript:eliminar(" .  $row["ID_Instituciones"] . ")' target='_parent'><img src='img/eliminar.png' border='0'  alt='Eliminar esta instituci&oacute;n'></a> ";
	echo $row["Institucion"] . "<br>";
?>
    </font></td>
  </tr>	<? }
	  ?>
</table></form>
</font>
</div>
</body>
<script>
function unificarInstitucion(){
	document.formP.target = "_parent";
 	document.formP.submit();
}
</script>