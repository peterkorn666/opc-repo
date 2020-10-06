<?php
session_start();
if(empty($_SESSION["corrector"]["nombreEvaluador"]) || empty($_SESSION["corrector"]["idEvaluador"])){
    header("Location: ../login.php");
    die();
}
header("Content-Disposition: attachment; filename=Todas_las_evaluaciones.xls");
include "../../../init.php";
include "../clases/Evaluaciones.php";

$instancia_evaluaciones = new Evaluaciones();
$evaluaciones = $instancia_evaluaciones->getEvaluaciones();
?>
<table width="98%" height="39" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr>
            <td align="center"><strong>N&ordm; trabajo</strong></td>
            <td align="center"><strong>&iquest;Es autor del trabajo?</strong></td>
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
            <td><?=utf8_decode($evaluacion['comentarios'])?></td>
            <td><?=$evaluacion['fecha']?></td>
            <td><?=$evaluacion['fecha_asignado']?></td>
        </tr>
        <?php
    }
    ?>
</table>