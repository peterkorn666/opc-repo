<?
include('inc/sesion.inc.php');
include('conexion.php');
$pais_ = $_POST["pais_"];
$pais_ing = $_POST["pais_ing"];
$sql = "INSERT INTO paises (Pais, Pais_ing) VALUES ";
$sql .= "('" . $pais_ . "', '" . $pais_ing . "');";
mysql_query($sql, $con);


if($_POST["sola"]==1){
	
	echo "<script>\n";
		echo "window.opener.llenarArrayPaises('$pais_');\n";
		echo "window.opener.llenarPaises();\n";
		echo "window.opener.seleccionarPaises('$pais_');\n";
		echo "window.close();\n";
	echo "</script>\n";

}else{
header ("Location:altaPais.php");
}
?>

