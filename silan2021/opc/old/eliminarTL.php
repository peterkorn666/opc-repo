<?
include('inc/sesion.inc.php');
include('conexion.php');

$id = $_GET["id"];
$estado = $_GET["estado"];

$tl = $_POST["tl"];

require "clases/trabajosLibres.php";

$trabajos = new trabajosLibre;


if($id==""){

	if($tl!=""){

		foreach($tl as $i){
			$trabajos->eliminarTL($i);
		}

	}

}else{
	$trabajos->eliminarTL($id);
}




header ("Location: estadoTL.php?idioma=&estado=cualquier&vacio=true");
?>
