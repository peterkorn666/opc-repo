<?
include('inc/sesion.inc.php');

include "conexion.php";

if($_POST["quien"]!=""){
	foreach($_POST["quien"] as $i){
	
		$sql ="DELETE FROM inscripciones_congreso WHERE id = '$i' LIMIT 1;";
		mysql_query($sql, $con);
	
	}
}

header ("Location: bandejaEntradaInscripciones.php");
?>
