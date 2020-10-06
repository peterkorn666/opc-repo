<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache"); 

require "clases/class.autores.php";
$autoresObj = new autores();
$autoresObj->setSessionAutores($_POST["id"], $_POST["nombre"],$_POST["apellido"],$_POST["institucion"],$_POST["mail"],$_POST["pais"],$_POST["ciudad"],$_POST["agradecimientos"],$_POST["lee"],$_POST["inscripto"]); 

include "inc.gestionAutores.php";

echo "<script>\n";

	echo "parent.cargarDivAutores('" . $gestionAutores . "');\n";
	echo "parent.cerrarVentanaAutores();\n";
	
echo "</script>\n";
?>