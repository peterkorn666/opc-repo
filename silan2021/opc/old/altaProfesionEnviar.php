<?
include('inc/sesion.inc.php');
include('conexion.php');

$profesion_ = $_POST["profesion_"];

$verf = mysql_query("SELECT * FROM profesiones WHERE Profesion='$profesion'",$con);
$verfCant = mysql_num_rows($verf);
if($verfCant>0){
	echo "Esta profesi&oacute;n ya existe.";
	die();
}

$sql = "INSERT INTO profesiones (Profesion) VALUES ";
$sql .= "('" . $profesion_ . "');";

mysql_query($sql, $con);


if($_POST["sola"]==1){
	
	echo "<script>\n";
		echo "window.opener.llenarArrayProfesiones('$profesion_');\n";
		echo "window.opener.llenarProfesiones();\n";
		echo "window.opener.seleccionarProfesiones('$profesion_');\n";
		echo "window.close();\n";
	echo "</script>\n";

}else{


header ("Location: altaProfesion.php");

}
?>