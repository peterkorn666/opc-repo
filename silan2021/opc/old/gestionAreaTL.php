<?
include('inc/sesion.inc.php');
include('conexion.php');

$id = $_GET["id"];
$modificar = $_GET["modificar"];
$ordenNueva = $_POST["orden_area"];
$AreaNueva = $_POST["area_"];

if ($modificar==true){
	
	/*$sql2 = "SELECT Area FROM areas_trabjos_libres WHERE id =". $id ." LIMIT 1";
	$rs = mysql_query($sql2, $con);
	while($row=mysql_fetch_array($rs)){
		$sql3 = "UPDATE trabajos_libres SET orden='$ordenNueva', area_tl = '$AreaNueva' WHERE area_tl = '". $row["Area"] . "';";
		mysql_query($sql3, $con);
	}*/
	
		
	$sql = "UPDATE areas_trabjos_libres SET orden='$ordenNueva', Area = '$AreaNueva' WHERE id = " . $id;
	
	}else{
	
		$sql2 = "SELECT Area FROM areas_trabjos_libres WHERE id =". $id ." LIMIT 1";
		$rs = mysql_query($sql2, $con);
		while($row=mysql_fetch_array($rs)){
			$sql3 = "UPDATE trabajos_libres SET area_tl = '' WHERE area_tl = '". $row["Area"]. "';";
			mysql_query($sql3, $con);
		}
		
		$sql = "DELETE FROM areas_trabjos_libres WHERE id = " . $id ." LIMIT 1";
	
}

mysql_query($sql, $con);

header ("Location:altaAreaTL.php");
?>
