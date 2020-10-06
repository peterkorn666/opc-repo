<?
include('inc/sesion.inc.php');
include('conexion.php');
$id = $_GET["id"];
$modificar = $_GET["modificar"];
$pais_ = $_POST["pais_"];
$pais_ing = $_POST["pais_ing"];
$pais_viejo = $_POST["pais_viejo"];

if ($modificar==true)
	{
	$sql =  "UPDATE paises SET ";
	$sql .= "Pais = '" . $pais_ . "', ";
	$sql .= "Pais_ing = '" . $pais_ing;
	$sql .= "' WHERE Pais = '" . $pais_viejo . "';";
	mysql_query($sql, $con);
	
	$sql2 =  "UPDATE congreso SET ";
	$sql2 .= "Pais = '" . $pais_;
	$sql2 .= "' WHERE Pais = '" . $pais_viejo . "';";
	mysql_query($sql2, $con);
	
	$sql3 =  "UPDATE personas SET ";
	$sql3 .= "Pais = '" . $pais_;
	$sql3 .= "' WHERE Pais = '" . $pais_viejo . "';";
	mysql_query($sql3, $con);
	
	$sql4 =  "UPDATE personas_trabajos_libres SET ";
	$sql4 .= "Pais = '" . $pais_;
	$sql4 .= "' WHERE Pais = '" . $pais_viejo . "';";
	mysql_query($sql4, $con);
	}
	
else{
	$sql = "DELETE FROM paises WHERE ID_Paises = " . $id;
	mysql_query($sql, $con);	
	}

header ("Location:altaPais.php");
?>
