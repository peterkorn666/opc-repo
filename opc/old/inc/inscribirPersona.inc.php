<?
include "../conexion.php";

$tabla = $_GET["tabla"];
$id = $_GET["id"];
$tipo= $_GET["tipo"];

echo " $tabla - $id - $tipo";


$sql = "UPDATE $tabla SET inscripto = $tipo WHERE ID_Personas = $id LIMIT 1 ";
mysql_query($sql, $con);


echo "<script>parent.document.getElementById('Guardando').style.visibility='hidden';</script>"

?>