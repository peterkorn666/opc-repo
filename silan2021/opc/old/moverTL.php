<?
include('inc/sesion.inc.php');
include "conexion.php";
require "clases/trabajosLibres.php";
$trabajos = new trabajosLibre;



		if($_POST["tl"]!=""){
			
			foreach($_POST["tl"] as $i){
			
				$trabajos->moverTL($i , $_POST["moverA"]);
			
			}
			
		}


//header("Location: estadoTL.php?estado=" . $_POST["moverA"]);
if($_GET['c'])
	header("Location: corrector/personal.php");
else
	header("Location: estadoTL.php?idioma=&estado=cualquier&vacio=true");
?>