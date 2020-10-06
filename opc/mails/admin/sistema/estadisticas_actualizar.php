<?
require "inicializar.php";
controlarAcceso($sistema,2);
echo "comenzando actualización de estadísticas de envíos";
$sistema->actualizarEstadisticasEnvios();
echo "<br>estadísticas de envíos actualizadas";
?>
