<?
include('inc/sesion.inc.php');
include "conexion.php";
require "clases/trabajosLibres.php";
$trabajos = new trabajosLibre;
if($_POST["area_"]=="Sin área"){
	$areaTrab = "";
}else{
	$areaTrab = $_POST["area_"];
}


		if($_POST["tl"]!=""){
			
			foreach($_POST["tl"] as $i){
			
				$trabajos->asignarAreaTL($i , $areaTrab);
			
			}
			
		}


header("Location: estadoTL.php?estado=" . $_POST["moverA"] . "&pagina=" . $_GET["pag"]);
?>