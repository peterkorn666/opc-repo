<?
require "inicializar.php";
controlarAcceso($sistema,2);
echo "comenzando actualizaci�n de estad�sticas de env�os";
$sistema->actualizarEstadisticasEnvios();
echo "<br>estad�sticas de env�os actualizadas";
?>
