<?
include('inc/sesion.inc.php');
include('conexion.php');
require "clases/class.baseController.php";
$id = $_GET["id"];
$modificar = $_GET["modificar"];

$base = new baseController();

$tabla = "areas";
$valores = array(
	"Area"=>$_POST["area_"],
	"Area_ing"=>$_POST["area_ing"]
);
$endonde = $base->validarPedido("ID_Areas", $id);



if ($modificar==true)	{	
	$rs = $base->updateEnBase($tabla, $valores, $endonde);
} else 	{	
	$rs = $base->borrarEnBase($tabla, $endonde);
}


header ("Location:altaArea.php");
?>
