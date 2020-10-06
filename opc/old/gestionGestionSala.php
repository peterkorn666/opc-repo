<?
include('inc/sesion.inc.php');
include('conexion.php');
$id = $_GET["id"];
$modificar = $_GET["modificar"];
$sala = $_POST["sala"];
$rubro = $_POST["rubro"];
$staff = $_POST["staff"];;
$hora_ini = $_POST["hora_inicio_"];;
$hora_fin = $_POST["hora_fin_"];;
$descripcion = $_POST["descripcion"];;

if ($modificar==true){
	$ArraySalasSeleccion = array ();
	$ArrayDiasSeleccion = array ();
//Recorro los arrays de los dias traidos y creo uno con los seleccionados
//***************************************
	$count = count($_SESSION["ArrayDias"]);
	for ($i=1; $i <= $count; $i++) {
		if ($_POST["dia".$i]<>""){
			$_SESSION["dia".$i] = $_POST["dia".$i];
			array_push($ArrayDiasSeleccion, $_POST["dia".$i]);
		}
	}
	$count = count($_SESSION["ArraySalas"]);
	for ($i=1; $i <= $count; $i++) {
		if ($_POST["sala".$i]<>""){
			$_SESSION["sala".$i] = $_POST["sala".$i];
			array_push($ArraySalasSeleccion, $_POST["sala".$i]);
		}
	}
/***************************/
	
//genero la cadena a guardar, EJ: Si eligen dia 1 y dia 3 queda asi : "1-3"
//***************************************
	$count = count($ArrayDiasSeleccion);
	for ($i=0; $i <= $count; $i++) {
		if ($i==$count){
			$DiasSeleccion .= $ArrayDiasSeleccion[$i];
		}else{
			$DiasSeleccion .= $ArrayDiasSeleccion[$i]."-";
		}	
	}
	$count = count($ArraySalasSeleccion);
	for ($i=0; $i <= $count; $i++) {
			if ($i==$count){
				$SalasSeleccion .= $ArraySalasSeleccion[$i];
			}else{
				$SalasSeleccion .= $ArraySalasSeleccion[$i]."-";
			}
	}
//***************************************


//Corto el ultimo caracter "-"
//****************************************
	$DiasSeleccion = substr( $DiasSeleccion, 0, strlen($DiasSeleccion)-1 );
	$SalasSeleccion = substr( $SalasSeleccion, 0, strlen($SalasSeleccion)-1 );
//****************************************
	
	
//saco los id's
//***************************************
	$sql = "SELECT id_rubro FROM rubros Where rubro = '".$rubro."' ";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
		$id_rubro = $row["id_rubro"];
	}
	
	$sql = "SELECT id_staff FROM staff Where nombre = '".$staff."' ";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
		$id_staff = $row["id_staff"];
	}
//***************************************
	
	$sql = "UPDATE gestion_sala SET id_dia = '".$DiasSeleccion."', id_sala = '".$SalasSeleccion."', sala = '".$sala."', id_rubro = '".$id_rubro."', rubro = '".	$rubro."', id_staff = '".$id_staff."', staff = '".$staff."', hora_inicio = '".$hora_ini."', hora_fin = '".$hora_fin."' , descripcion = '".$descripcion."' WHERE id_gestion_sala = '" . $id."';";

}else{
	$sql = "DELETE FROM gestion_sala WHERE id_gestion_sala  = " . $id;
}

mysql_query($sql, $con);
header ("Location:altaGestionSala.php");
?>
