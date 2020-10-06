<?php
if(empty($_GET["numero_tl"]) || empty($_GET["evaluador"])){
    header("Location: login.php");
    die();
}
session_start();
if($_SESSION["corrector"]['nivel'] != 1){ //
    header("Location: login.php");
    die();
}
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
include("../../init.php");
include("clases/Auxiliar.php");
include("clases/Evaluaciones.php");
include("clases/evaluadores.class.php");
include("clases/Trabajos.php");

$auxiliar_instancia = new Auxiliar();
$config = $auxiliar_instancia->getConfig();

$instancia_evaluaciones = new Evaluaciones();
$instancia_evaluadores = new Evaluadores();
$instancia_trabajos = new Trabajos();

$evaluacion = $instancia_evaluaciones->getEvaluacion($_GET['numero_tl'], $_GET['evaluador']);
if (count($evaluacion) == 0){

    header("Location: login.php");
    die();
}

$evaluador = $instancia_evaluadores->getEvaluadorByID($evaluacion['idEvaluador']);
$trabajo = $instancia_trabajos->getTrabajoByNumeroTL($evaluacion['numero_tl']);

$area_tl = $instancia_trabajos->getAreaTLByID($trabajo['area_tl']);
$tipo_trabajo = $instancia_trabajos->getTipoTrabajo($trabajo["tipo_tl"]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Evaluación trabajo Nº <?=$_GET["numero_tl"]?> - <?=$config['nombre_congreso']?></title>
    <link href="../../bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="css/personal.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <div class="row" style="text-align: center; vertical-align: middle;">
            <div class="col-md-8">
                <div class="row">
                    <div align="center">
                        <div class="col-md-10">
                            <?php
                            include("include/include_image.php");
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <br>
                Responsable de la Evaluaci&oacute;n:<br>
                <strong><?=$evaluador['nombre']?></strong><br>
                <a href="admin.php">volver</a>
            </div>
        </div><br>
        <div class="col-md-12" style="border: 2px solid black; background-color: white;">
            <div class="row">
                <div class="col-md-4" style="background-color: #F4F4F4;">
                    Nº de trabajo: <strong><?=$evaluacion['numero_tl']?></strong><br>
                    Área: <strong><?=$area_tl['Area_es']?></strong><br>
                    Modalidad: <strong><?=$tipo_trabajo['tipoTL_es']?></strong><br>
                    ¿Postula a premio?: <strong><?=$trabajo['premio']?></strong><br>
                    ¿Soy autor de este trabajo?<br>
                    <strong><?=$evaluacion['evaluar_trabajo']?></strong>
                    <br><br>
                    <?php
                    if ($evaluacion['estadoEvaluacion'] !== ""){
                        ?>
                            <div class="div-evaluacion">
                                <div style="border: 1px solid black;">
                                    <div class="col-md-12" style="background-color: #028DC8; color: #FFF;">
                                        Recomendación
                                    </div>
                                    <div style="margin: 5px;">
                                        <strong><?=$evaluacion['estadoEvaluacion']?></strong>
                                    </div>
                                </div><br>
                                <?php
                                if($evaluacion['comentarios'] !== NULL && $evaluacion['comentarios'] !== "") {
                                    ?>

                                    <div id="div-comentarios" style="border: 1px solid black;">
                                        <div class="col-md-12" style="background-color: #028DC8; color: #FFF;">
                                            Indicaciones / Modificaciones
                                        </div>
                                        <div style="margin: 5px;">
                                            <strong><?=$evaluacion['comentarios']?></strong>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div><br>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-md-8">
                    <br>
                    <div class="col-md-12" style="text-align: center; font-weight: bold;">
                        <?=$trabajo['titulo_tl']?>
                    </div><br>
                    <div class="col-md-12 padding_horizontal" style="border-bottom: 1px dashed #CCC;">
                        <strong>Introducción</strong><br>
                        <?=$trabajo['resumen']?>
                    </div>
                    <div class="col-md-12 padding_horizontal" style="border-bottom: 1px dashed #CCC;">
                        <strong>Objetivo</strong><br>
                        <?=$trabajo['resumen2']?>
                    </div>
                    <div class="col-md-12 padding_horizontal" style="border-bottom: 1px dashed #CCC;">
                    	<strong>
							<?php
                            if ($tipo_trabajo["tipoTL_es"] === "Caso Clínico"){
                                echo "Caso(s) clínico(s)";
                            } else {
                                echo "Material y método";
                            }
                            ?>
                        </strong><br>
                        <?=$trabajo['resumen3']?>
                    </div>
                    <?php
					if ($tipo_trabajo["tipoTL_es"] !== "Caso Clínico"){
					?>
                        <div class="col-md-12 padding_horizontal" style="border-bottom: 1px dashed #CCC;">
                            <strong>Resultados</strong><br>
                            <?=$trabajo['resumen4']?>
                        </div>
                    <?php
					}
					?>
                    <div class="col-md-12 padding_horizontal" style="border-bottom: 1px dashed #CCC;">
                        <strong>Conclusiones</strong><br>
                        <?=$trabajo['resumen5']?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
</html>