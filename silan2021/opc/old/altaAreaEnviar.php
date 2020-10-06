<?
include('conexion.php');
require "clases/class.baseController.php";
include('inc/sesion.inc.php');
$existe = false;
$orden_area = $_POST["orden_area"];
$area_ = $_POST["area_"];
$area_ing = $_POST["area_ing"];

$base = new baseController();
$tabla = "areas";
$valores = array(
	"Area"=>$area_ ,
	"Area_ing"=>$area_ing
);
$rs = $base->insertarEnBase($tabla, $valores);
	
		if($_POST["sola"]==1)
			{
				
				echo "<script>\n";
					echo "window.opener.llenarArrayAreas('$area_');\n";
					echo "window.opener.llenarAreas();\n";
					echo "window.opener.seleccionarAreas('$area_');\n";
					
					echo "window.close();\n";
				echo "</script>\n";
			
			}
			else
			{
			header ('Location:altaArea.php');
			}
		

?>