<?
include('inc/sesion.inc.php');
include('conexion.php');
$id = $_GET["id"];
$modificar = $_GET["modificar"];
$rubro_ = $_POST["rubro_"];
$descripcion = $_POST["descripcion_"];
//$sala_ing = $_POST["sala_ing"];
//$orden_ = $_POST["orden_"];
//$obs_sala_ = $_POST["obssala_"];
//$sala_viejo = $_POST["sala_viejo"];
//$orden_viejo = $_POST["orden_viejo"];
//$obs_sala_viejo = $_POST["obssala_viejo"];


if ($modificar==true)
	{
	////ACTUALIZAR TABLA SALAS
	$sql = "UPDATE rubros SET rubro = '".$rubro_."', descripcion = '".$descripcion."' WHERE id_rubro = '" . $id."';";
	//////---------------------
		
		
	}
else
	{
	$sql = "DELETE FROM rubros WHERE id_rubro = " . $id;
	}
	
/*echo $sql;
exit();	*/
mysql_query($sql, $con);



header ("Location:altaRubro.php");
?>
