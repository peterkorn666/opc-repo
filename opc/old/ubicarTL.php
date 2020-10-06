<?
include('inc/sesion.inc.php');
include "conexion.php";
require "clases/trabajosLibres.php";
$trabajos = new trabajosLibre;


		if($_POST["tl"]!=""){
			
			foreach($_POST["tl"] as $i){
			
				$estados[] = $trabajos->ubicarTL($i , $_POST["ID_casillero"]);
			
			}
			
		}
if(count($estados)>0){
	foreach($estados as $estado){
		if($estado=="ok"){
			$ok[] = $estado;
		}else{
			$error[] = $estado;
		}
	}
}
header("Location: estadoTL.php?idioma=&estado=cualquier&vacio=true");
//header("Location: estadoTL.php?estado=" . $_POST["moverA"]."&a=".count($ok)."&e=".count($error));
?>