<?
include('inc/sesion.inc.php');
include('conexion.php');

$id = $_GET["id"];
$modificar = $_GET["modificar"];
$dia_ = $_POST["dia_"];
$dia_ing = $_POST["dia_ing"];
$orden_ = $_POST["orden_"];
$visible = $_POST["visible"];
$dia_viejo = $_POST["dia_viejo"];
$orden_viejo = $_POST["orden_viejo"];

if ($modificar==true){
	////ACTUALIZAR TABLA DIAS
	$sql =  "UPDATE dias SET ";
	$sql .= "Dia = '" . $dia_. "', ";
	$sql .= "Dia_ing = '" . $dia_ing ;
	$sql .= "', Dia_orden = '" .$orden_;	
	$sql .= "', visible = '" .$visible;
	$sql .= "' WHERE Dia = '" . $dia_viejo;
	$sql .= "' and Dia_orden = '" .$orden_viejo . "';";
	mysql_query($sql, $con);
	
	////ACTUALIZAR TABLA TRABAJOSLIBRES
	$sql3 = "SELECT c.Casillero , c.Sala_orden, c.Hora_inicio, tl.ID_casillero FROM congreso as c, trabajos_libres as tl";
	$sql3 .= " WHERE c.Dia = '" . $dia_viejo . "'  AND c.Casillero = tl.ID_casillero ";
	$rs3 = mysql_query($sql3, $con);
	while ($row4 = mysql_fetch_array($rs3)){ 
	
		$casillero_nuevo = $orden_ . $row4["Sala_orden"] . $row4["Hora_inicio"];
		$casillero_nuevo = str_replace(":","",$casillero_nuevo);
		$casillero_viejo = $row4["ID_casillero"];
		
		
	$sql4 = "UPDATE trabajos_libres SET ";
	$sql4 .= "ID_casillero = '" . $casillero_nuevo;
	$sql4 .= "'WHERE ID_casillero = '" . $casillero_viejo ."';";
	mysql_query($sql4, $con);
	}
	//////////////////////*-----------------------------
	
	////ACTUALIZAR TABLA CONGRESO	
	$sql0 = "SELECT * FROM congreso WHERE Dia = '" . $dia_viejo . "';";
	$rs0 = mysql_query($sql0,$con);
	while ($row0 = mysql_fetch_array($rs0)){
		$casillero =  $orden_  .$row0["Sala_orden"] . $row0["Hora_inicio"];
		$casillero = str_replace(":","",$casillero);
		$sql2 =  "UPDATE congreso SET ";
		$sql2 .= "Casillero = '" . $casillero ;
		$sql2 .= "', Dia = '" . $dia_;
		$sql2 .= "', Dia_orden = '" .$orden_;
		$sql2 .= "' WHERE ID = ".$row0["ID"].";";
		mysql_query($sql2, $con);
	
	}///////////////////////-----------------
}

else{
$sql = "DELETE FROM dias WHERE ID_Dias = " . $id;
}
mysql_query($sql, $con);

header ("Location:altaDia.php");
?>
