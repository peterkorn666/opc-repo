<?php
session_start();
if($_SESSION["corrector"]["Login"]=="" && $_SESSION["corrector"]["Login"] != "Logueado"){
	header("Location: login.php");
	die();
}
if($_SESSION["corrector"]["nivel"] == 1){
    header("Location: admin.php");
    die();
}

header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
include("../../init.php");
include("clases/Auxiliar.php");
include("clases/Evaluaciones.php");
include("clases/Trabajos.php");

$evaluaciones_instancia = new Evaluaciones();
$trabajos_instancia = new Trabajos();
$auxiliar_instancia = new Auxiliar();

$config = $auxiliar_instancia->getConfig();
$evaluaciones = $evaluaciones_instancia->getEvaluacionesByEvaluador($_SESSION["corrector"]["idEvaluador"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Evaluación de trabajos - <?=$config['nombre_congreso']?></title>
    <link href="../../bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="css/personal.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <div align="center">
            <div class="col-md-8">
                <?php
                include("include/include_image.php");
                ?>
            </div>
        </div><br>
        <div class="col-md-12 div_evaluaciones">
            <div class="row">
                <div class="col-md-9">
                    Usuario: <strong><?=$_SESSION["corrector"]["nombreEvaluador"]?></strong><br>
                    <a href="cerrarSession.php">Cerrar Sesi&oacute;n</a>
                </div>
                <div class="col-md-3 text-right">
                    <a href="excel/misEvaluacionesXLS.php" target="_blank">Ver mis evaluaciones</a>
                </div>
            </div><br>
            <?php
            if($_GET["success"]){
                ?>
                <div class="row">
                    <div class="col-md-12 alert alert-success">
                        El trabajo ha sido evaluado con éxito.
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="row">
                <div class="col-md-12 div_txt_trabajos">
                    Trabajos para evaluar
                </div>
            </div>
            <div class="row div_labels">
                <div class="col-md-1 borde_derecho">
                    Nro.
                </div>
                <div class="col-md-2 borde_derecho">
                    Fecha asignado
                </div>
                <div class="col-md-2 borde_derecho">
                    Resumen revisado
                </div>
                <div class="col-md-3 borde_derecho">
                    Título del abstract
                </div>
                <div class="col-md-2 borde_derecho">
                    Estado
                </div>
                <div class="col-md-2">

                </div>
            </div>
            <?php
            if(count($evaluaciones) > 0){
                $area_tl_anterior = "";
                foreach($evaluaciones as $evaluacion){
                    if($evaluacion['area_tl'] != $area_tl_anterior){
                        $area_tl = $trabajos_instancia->getAreaTLByID($evaluacion['area_tl']);
                        ?>
                            <div class="row div_txt_area">
                                <div class="col-md-12">
                                    <strong><?=$area_tl['Area_es']?></strong>
                                </div>
                            </div>
                        <?php
                    }
                    ?>
                    <div class="row fila_contenido">
                        <div class="col-md-1 borde_derecho">
                            <?=$evaluacion["numero_tl"]?>
                        </div>
                        <div class="col-md-2 borde_derecho">
                            <?=$evaluacion["fecha_asignado"]?>
                        </div>
                        <div class="col-md-2 borde_derecho">
                            <?php
                            if($evaluacion["evaluar_trabajo"] != "" && $evaluacion["evaluar_trabajo"] != NULL){
                                echo "Si";
                            }else
                                echo "No";
                            ?>
                        </div>
                        <div class="col-md-3 borde_derecho" style="text-align: left; vertical-align: top;">
                            <?=$evaluacion["titulo_tl"]?>
                        </div>
                        <div class="col-md-2 borde_derecho">
                            <?=$evaluacion["estadoEvaluacion"]?>
                        </div>
                        <div class="col-md-2">
                            <input type="button" value="Evaluar" onClick="evaluar('<?=$evaluacion["numero_tl"]?>', '<?=$_SESSION["corrector"]['idEvaluador']?>');" name="btnEvaluar" class="form-control">
                        </div>
                    </div>
                    <?php
                    $area_tl_anterior = $evaluacion['area_tl'];
                } //end foreach
            }
            ?>
        </div>
    </div><br>
</body>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

    function evaluar(nro, idEvaluador){
        //document.form1.method = "POST";
        //document.location.href = "AUTOR_codigo_enviar2.php?txtCod="+nro;
        document.location.href = "evaluar_trabajo.php?numero_tl="+nro+"&evaluador="+idEvaluador;
    }

</script>
</html>