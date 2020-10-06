<script src="js/personas.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style>
body{
background-color:#666666;
 
}
</style>
<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
include "conexion.php";
	$act = "?";
	//aca hay que traer la actividad del casillero	
?>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="formAct" id="formAct" action="cargarActividad.php" method="post" >
<table width="300" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td>&nbsp;</td>
    <td>Nombre</td>
    <td>Actividad</td>
  </tr>
<?
 	$sql = "SELECT a.*, p.Nombre, p.Apellidos FROM actividades a , personas p WHERE a.idPersonaNueva = p.ID_Personas ORDER BY p.Apellidos";
 	$rs = mysql_query($sql, $con);
	while ($row = mysql_fetch_array($rs)){
 ?>
  <tr style="overflow:auto">
    <td>
    <input type="radio" name="idActividad" id="idActividad" value="<?=$row["id"]?>">
    <input type="hidden" name="Titulo_de_trabajo<?=$row["id"]?>" id="Titulo_de_trabajo<?=$row["id"]?>" value="<?=$row["Titulo_de_trabajo"]?>">
    <input type="hidden" name="Titulo_de_trabajo_ing<?=$row["id"]?>" id="Titulo_de_trabajo_ing<?=$row["id"]?>" value="<?=$row["Titulo_de_trabajo_ing"]?>">
    <input type="hidden" name="observaciones<?=$row["id"]?>" id="observaciones<?=$row["id"]?>" value="<?=$row["observaciones"]?>">
    <input type="hidden" name="mostrarOPC<?=$row["id"]?>" id="mostrarOPC<?=$row["id"]?>" value="<?=$row["mostrarOPC"]?>">
    <input type="hidden" name="participa<?=$row["id"]?>" id="participa<?=$row["id"]?>" value="<?=$row["participa"]?>">
    <input type="hidden" name="archivoPonencia<?=$row["id"]?>" id="archivoPonencia<?=$row["id"]?>" value="<?=$row["archivoPonencia"]?>">
    <input type="hidden" name="confirmado<?=$row["id"]?>" id="confirmado<?=$row["id"]?>" value="<?=$row["confirmado"]?>">
	<input type="hidden" name="comentarios<?=$row["id"]?>" id="comentarios<?=$row["id"]?>" value="<?=$row["comentarios"]?>">    
    </td>    
    <td><?=$row["Nombre"]?> <?=$row["Apellidos"]?></td>
    <td><?=$row["Titulo_de_trabajo"]?></td>
  </tr>
  <? } ?>
  <tr>
	<td>
    <input type="hidden" name="idCasillero" value="<?=$_GET["idCasillero"]?>" >
    <input type="hidden" name="nroActividad" value="<?=$_GET["nroActividad"]?>" >    
    <input type="submit" value="Cargar"> 
    </td>
  </tr>
</table>
</form>
</body>




<script>
function cargarActividad(act){
	//document.formP.target = "_parent";
	window.parent.frames["frameName"].document.form1.trabajo[act] = formAct.getElementById("Titulo_de_trabajo"+act).value;
	

}
</script>
