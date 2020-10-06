<?php
session_start();
if($_SESSION["corrector"]["Login"]=="" && $_SESSION["corrector"]["Login"] != "Logueado"){
    header("Location: login.php");
    die();
}
if($_SESSION["corrector"]["nivel"] == 2){
    header("Location: personal.php");
    die();
}

header('Content-Type: text/html; charset=UTF-8');
include("../../init.php");
include("clases/Trabajos.php");
include("clases/evaluadores.class.php");
include("clases/Evaluaciones.php");

$trabajos_instancia = new Trabajos();
$evaluadores_instancia = new Evaluadores();
$evaluaciones_instancia = new Evaluaciones();

$trabajos_sin_evaluacion = $trabajos_instancia->getTrabajosSinEvaluacion();
$evaluadores = $evaluadores_instancia->getEvaluadores();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Evaluadores</title>
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css" />
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
        <div class="col-md-12" style="background-color: white;">
            <?php
            if($_GET['trabajo_eliminado']){
                $evaluador_con_trabajo_eliminado = $evaluadores_instancia->getEvaluadorByID($_GET["evaluador"]);
                ?>
                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="row">
                        <div class="col-md-12 alert alert-success">
                            Se eliminó el trabajo <?=$_GET['numero']?> al evaluador <?=$evaluador_con_trabajo_eliminado['nombre']?> con éxito.
                        </div>
                    </div>
                </div><br>
                <?php
            }
            ?>
            <?php
            if($_GET['trabajo_asignado']){
                $evaluador_con_trabajo_asignado = $evaluadores_instancia->getEvaluadorByID($_GET["evaluador"]);
                ?>
                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="row">
                        <div class="col-md-12 alert alert-success">
                            Se asignaron los trabajos al evaluador <?=$evaluador_con_trabajo_asignado['nombre']?> con éxito.
                        </div>
                    </div>
                </div><br>
                <?php
            }
            ?>
            <?php
            if($_GET['evaluador_editado']){
                $evaluador_con_trabajo_asignado = $evaluadores_instancia->getEvaluadorByID($_GET["evaluador"]);
                ?>
                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="row">
                        <div class="col-md-12 alert alert-success">
                            Se editó al evaluador <?=$evaluador_con_trabajo_asignado['nombre']?> con éxito.
                        </div>
                    </div>
                </div><br>
                <?php
            }
            ?>
            <div class="row">
                <div class="col-md-12">
                    Trabajos sin asignar:
                    <?php
                    if(count($trabajos_sin_evaluacion) > 0){
                        $area_anterior = "";
                        $primer_numero = true;
                        foreach($trabajos_sin_evaluacion as $trabajo_sin_evaluacion){
                            if($trabajo_sin_evaluacion['area_tl'] != $area_anterior){
                                echo "<br><br><span style='color: red; font-style: italic;'>".$trabajo_sin_evaluacion['Area_es']."</span><br>";
                                $primer_numero = true;
                            }
                            if($primer_numero === false){

                                echo " - ";
                            }else{

                                $primer_numero = false;
                            }
                            echo $trabajo_sin_evaluacion['numero_tl'];

                            $area_anterior = $trabajo_sin_evaluacion['area_tl'];
                        }
                    } else {
                        echo "<br><br><strong>Todos los trabajos están asignados a por lo menos un evaluador.</strong>";
                    }
                    ?>
                </div>
            </div><br><br>
            <div class="row" style="padding-bottom: 15px;">
                <div class="col-md-12">
                    <div clasS="row" style="background-color: #028DC8; color: white;">
                        <div class="col-md-1">

                        </div>
                        <div class="col-md-1">
                            ID:
                        </div>
                        <div class="col-md-2">
                            Nombre:
                        </div>
                        <div class="col-md-2">
                            Trabajos adjudicados:
                        </div>
                        <div class="col-md-2">
                            Trabajos revisados:
                        </div>
                        <div class="col-md-2">
                            Clave:
                        </div>
                        <div class="col-md-2">
                            <input id="preparar_mail" type="button" name="preparar_mail" value="Preparar mail" class="btn" style="text-align: left;">
                        </div>
                    </div>
                    <?php
                    foreach($evaluadores as $evaluador){
                        $txt_adjudicados = "";
                        $txt_revisados = "";
                        $evaluaciones_del_evaluador = $evaluaciones_instancia->getEvaluacionesByEvaluador($evaluador['id']);
                        foreach($evaluaciones_del_evaluador as $evaluacion){

                            if($evaluacion['evaluar_trabajo'] !== NULL && $evaluacion['evaluar_trabajo'] !== ""){ //Revisados
                                if($txt_revisados != ""){
                                    $txt_revisados .= " - ";
                                }
                                $txt_revisados .= '<span class="numeros" data-id="'.$evaluacion['numero_tl'].'" data-evaluador="'.$evaluador['id'].'" style="cursor: pointer;">'.$evaluacion['numero_tl'].'</span>';
                            } else {
                                //Adjudicados
                                if($txt_adjudicados != ""){
                                    $txt_adjudicados .= " - ";
                                }
                                $txt_adjudicados .= '<span class="numeros" data-id="'.$evaluacion['numero_tl'].'" data-evaluador="'.$evaluador['id'].'" style="cursor: pointer;">'.$evaluacion['numero_tl'].'</span>';
                            }
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-1">

                            </div>
                            <div class="col-md-1">
                                <?=$evaluador['id']?>
                            </div>
                            <div class="col-md-2">
                                <a href="crear_evaluador.php?key=<?=$evaluador['id']?>"><?=$evaluador['nombre']?></a>
                            </div>
                            <div class="col-md-2">
                                <?=$txt_adjudicados?>
                            </div>
                            <div class="col-md-2">
                                <?=$txt_revisados?>
                            </div>
                            <div class="col-md-2">
                                <?=$evaluador['clave']?>
                            </div>
                            <div class="col-md-2">
                                <a href="asignar_trabajo.php?id_evaluador=<?=$evaluador['id']?>">Asignar trabajo</a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div></div>
                </div>
            </div>
        </div><br>
    </div>
</body>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $(".numeros").click(function(){
            var numero = $(this).data('id');
            var id_evaluador = $(this).data('evaluador');

            if(confirm("¿Quiere eliminar el trabajo "+numero+" para este evaluador?")){
                window.location.href = "eliminar_trabajo.php?id_evaluador="+id_evaluador+"&numero_tl="+numero;
            }
        });

        $("#preparar_mail").click(function(){
            window.location.href = "../envio_mail/evaluadores/";
        });
    });
</script>
</html>
