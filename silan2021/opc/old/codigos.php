<?
include('inc/sesion.inc.php');
include("conexion.php");

$sql = "SELECT DISTINCT tema FROM listado_completo WHERE tema <> '';";
$rs = mysql_query($sql,$con);
while ($row = mysql_fetch_array($rs)){
	$existeArea=false;
		echo $row["tema"]."<br>";
		$sql2="SELECT Area FROM areas_trabjos_libres WHERE Area ='" . $row["tema"] . "';";
		echo $sql2."<br>";
		$rs2=mysql_query($sql2, $con);		
		while($row2 = mysql_fetch_array($rs2)){
			echo "Entro <br>";
		$existeArea = true;
		}
	if($existeArea==false){
	$sql0 = "INSERT INTO areas_trabjos_libres(Area) VALUES ('" . trim($row["tema"]) . "');";
	echo "Hago Insert<br>";
	//	mysql_query($sql0,$con);
		}
}


?>