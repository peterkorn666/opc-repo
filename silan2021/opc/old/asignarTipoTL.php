<?
include('inc/sesion.inc.php');
include "conexion.php";
require "clases/trabajosLibres.php";
$trabajos = new trabajosLibre;

if($_POST["tipo_de_TL"]=="Sin tipo"){
	$tipoTrab = "";
}else{
	$tipoTrab = $_POST["tipo_de_TL"];
}

		if($_POST["tl"]!=""){
			
			foreach($_POST["tl"] as $i){
			
				$trabajos->asignarTipoTL($i , $tipoTrab);
			
			}
			
		}


header("Location: estadoTL.php?estado=" . $_POST["moverA"] . "&pagina=" . $_GET["pag"]);
?>