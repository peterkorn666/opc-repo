<?
include('inc/sesion.inc.php');
include('conexion.php');

$idViejo = $_POST["idViejo"];

$profesion_ = $_POST["profesion_"];
$nombre_ = $_POST["nombre_"];
$apellidos_ = $_POST["apellidos_"];
$cargo_ = $_POST["cargo_"];
$institucion_= $_POST["institucion_"];
$pais_ = $_POST["pais_"];
$mail_ = $_POST["mail_"];


$sql =  "UPDATE personas_trabajos_libres SET ";
$sql .= "Profesion = '" . $profesion_;
$sql .= "', Nombre = '" .$nombre_;
$sql .= "', Apellidos = '" . $apellidos_;
$sql .= "', Cargos = '" . $cargo_;
$sql .= "', Institucion = '" . $institucion_;
$sql .= "', Pais = '" . $pais_;
$sql .= "', Mail = '" . $mail_;

if($_POST["eliminar_curr"]=="si"){
	$sql .= "', Curriculum = '";
}

if($_POST["archivo"]["name"] != ""){
	$sql .= "', Curriculum = '" . $idViejo . "_" . $_POST["archivo"]["name"];
	copy($_POST["archivo"]["tmp_name"],"cv/" . $idViejo . "_" . $_POST["archivo"]["name"]);
}

$sql .= "' WHERE ID_Personas = $idViejo;";
mysql_query($sql, $con);


header("Location: altaPersonasTL.php");
?>