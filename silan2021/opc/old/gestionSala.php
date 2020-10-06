<?
include('inc/sesion.inc.php');
include('conexion.php');
$id = $_GET["id"];
$modificar = $_GET["modificar"];
$sala_ = $_POST["sala_"];
$sala_ing = $_POST["sala_ing"];
$orden_ = $_POST["orden_"];
$obs_sala_ = $_POST["obssala_"];
$sala_viejo = $_POST["sala_viejo"];
$orden_viejo = $_POST["orden_viejo"];
$obs_sala_viejo = $_POST["obssala_viejo"];
$visible = $_POST["visible"];



if ($modificar==true)
	{
	////ACTUALIZAR TABLA SALAS
	//$sql = "UPDATE salas SET Sala = '$sala_', Sala_orden = $orden_ WHERE ID_Salas = " . $id;
	//$sql = "UPDATE salas SET Sala = '$sala_', Sala_orden = $orden_, Sala_obs='$obs_sala_' WHERE ID_Salas = " . $id;
	$sql = "UPDATE salas SET Sala = '".$sala_."', Sala_ing = '".$sala_ing."', Sala_orden = '".$orden_."', Sala_obs='".$obs_sala_."'  WHERE ID_Salas = '" . $id."';";
	//////---------------------
		/////SELECCIONO LOS ID_CASILLERO DONDE HAYA TRABAJOS LIBRES Y LOS MODIFICO
		$sql3 = "SELECT c.Casillero , c.Dia_orden, c.Hora_inicio, tl.ID_casillero FROM congreso as c, trabajos_libres as tl";
		$sql3 .= " WHERE c.Sala = '" . $sala_viejo . "'  AND c.Casillero = tl.ID_casillero ";
		$rs3 = mysql_query($sql3, $con);
		while ($row4 = mysql_fetch_array($rs3))
		{ 
		
			$casillero_nuevo = $row4["Dia_orden"] . $orden_ . $row4["Hora_inicio"];
			$casillero_nuevo = str_replace(":","",$casillero_nuevo);
			
			$casillero_viejo = $row4["ID_casillero"];
			
			
		$sql4 = "UPDATE trabajos_libres SET ";
		$sql4 .= "ID_casillero = '" . $casillero_nuevo;
		$sql4 .= "'WHERE ID_casillero = '" . $casillero_viejo ."';";
		mysql_query($sql4, $con);
		}
		///////------------
		
		//////ACTUALIZO LA TABLA CONGRESO
		$sql0 = "SELECT * FROM congreso WHERE Sala = '" . $sala_viejo . "';";
		$rs0 = mysql_query($sql0,$con);
		///echo $sql0;
		while ($row0 = mysql_fetch_array($rs0)){
		
			$casillero = $row0["Dia_orden"] . $orden_ . $row0["Hora_inicio"];
			$casillero = str_replace(":","",$casillero);
			
			$sql2 =  "UPDATE congreso SET ";
			$sql2 .= "Casillero = '" . $casillero ;
			$sql2 .= "', Sala = '" . $sala_;
			$sql2 .= "', Sala_orden = '" .$orden_;
			$sql2 .= "' WHERE ID = ".$row0["ID"].";";
			mysql_query($sql2, $con);
		}
		/////////-----------

	}
else
	{
	$sql = "DELETE FROM salas WHERE ID_Salas = " . $id;
	}
	
/*echo $sql;
exit();	*/
mysql_query($sql, $con);



header ("Location:altaSala.php");
?>
