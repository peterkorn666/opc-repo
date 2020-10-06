<?php
session_start();
if(empty($_SESSION["corrector"]["nombreEvaluador"]) || empty($_SESSION["corrector"]["idEvaluador"])){
    header("Location: ../login.php");
    die();
}
$nombreEvaluador = $_SESSION["corrector"]["nombreEvaluador"];
header("Content-Disposition: attachment; filename=".$nombreEvaluador.".xls");
include "../../../init.php";
include "../clases/Evaluaciones.php";

$instancia_evaluaciones = new Evaluaciones();
$evaluaciones = $instancia_evaluaciones->getEvaluacionesByEvaluador($_SESSION["corrector"]['idEvaluador']);
?>
<table width="98%" height="39" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr>
            <td align="center"><strong>N&ordm; trabajo</strong></td>
            <td align="center"><strong>&iquest;Usted es autor de este trabajo?</strong></td>
            <td align="center"><strong>Estado</strong></td>
            <td align="center"><strong>Indicaciones / Modificaciones</strong></td>
            <td align="center"><strong>&Uacute;ltima modificaci&oacute;n</strong></td>
            <td align="center"><strong>Fecha asignado</strong></td>
        </tr>
    <?php
    foreach($evaluaciones as $evaluacion){
        ?>
        <tr>
            <td><?=$evaluacion['numero_tl']?></td>
            <td><?=$evaluacion['evaluar_trabajo']?></td>
            <td><?=$evaluacion['estadoEvaluacion']?></td>
            <td><?=$evaluacion['comentarios']?></td>
            <td><?=$evaluacion['fecha']?></td>
            <td><?=$evaluacion['fecha_asignado']?></td>
        </tr>
        <?php
    }
    ?>
</table>