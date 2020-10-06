<?
include('inc/sesion.inc.php');
include('conexion.php');

require("clases/personas.php");

$persona = new personas();
$persona->selectUnificarEnviar($_POST["uni"], $_POST["uniSel"]);


header("Location: altaPersonas.php");
?>
