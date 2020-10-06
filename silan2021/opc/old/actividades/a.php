<?
include('../conexion.php');
$sql = "SELECT * FROM personas WHERE 1";
$rs = $con->query($sql);
while($row = $rs->fetch_array()){
	echo $row["ID_Personas"]."####".$row["Apellidos"]."@@@@".$row["Apellidos2"]."<br>";
}
?>