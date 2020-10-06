<?php
if(empty($_GET["id_evaluador"])){
    header("Location: evaluadores.php");
    return false;
}
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
include("clases/Auxiliar.php");
$auxiliar_instancia = new Auxiliar();
$config = $auxiliar_instancia->getConfig();

include("clases/evaluadores.class.php");
$evaluadores_instancia = new Evaluadores();
$evaluador = $evaluadores_instancia->getEvaluadorByID($_GET['id_evaluador']);
if(count($evaluador) == 0){

    header("Location: evaluadores.php");
    return false;
}

include("clases/Evaluaciones.php");
$evaluaciones_instancia = new Evaluaciones();

if(count($_POST) > 0){
    $tiempo = new DateTime("now", new DateTimeZone("America/Montevideo"));
    $fecha = $tiempo->format('Y-m-d H:i:s');

    foreach($_POST['numeros_tl'] as $numero_tl){

        $campos = [
            'idEvaluador' => $evaluador['id'],
            'numero_tl' => $numero_tl,
            'fecha_asignado' => $fecha
        ];
        $result = $evaluaciones_instancia->crearEvaluacion($campos);
    }
    if($result)
        header("Location: evaluadores.php?trabajo_asignado=true&evaluador=".$evaluador['id']);
    else
        header("Location: evaluadores.php?error=true&evaluador".$evaluador['id']);
    die();
}

include("clases/Trabajos.php");
$trabajos_instancia = new Trabajos();

$trabajos_sin_evaluacion = $trabajos_instancia->getTrabajosSinEvaluacion();
$trabajos_no_asignados_a_evaluador = $trabajos_instancia->getTrabajosNoAsignadosAlEvaluador($evaluador['id']);

$areas_trabajos_libres = $trabajos_instancia->getAreasTL();


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Asignar trabajo a evaluador - <?=$config['nombre_congreso']?></title>
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
            <div class="row">
                <div class="col-md-12" style="text-align: right;">
                    <a href="evaluadores.php">Volver</a>
                </div>
                <div class="col-md-12">
                    Trabajos sin asignar:
                    <?php
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
                    ?>
                </div>
            </div><br><br>
            <form id="asignarTrabajo" name="asignarTrabajo" action="asignar_trabajo.php?id_evaluador=<?=$evaluador['id']?>" method="POST">
                <div class="col-md-6" style="padding-bottom: 15px;">
                    <div class="row">
                        <div class="col-md-12" style="font-weight: bold;">
                            Asignar trabajos a <?=$evaluador['nombre']?>
                        </div>
                    </div><br>
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-4">
                            Marcar por Área
                        </div>
                        <div class="col-md-8">
                            <select name="filtro_area_tl" class="form-control">
                                <option value=""></option>
                                <?php
                                foreach($areas_trabajos_libres as $area_tl){
                                    ?>
                                    <option value="<?=$area_tl["id"]?>"><?=$area_tl["Area_es"]?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="padding-right: 0px;">
                            <input type="button" name="marcar_todos" value="Marcar todos" class="form-control marcar_todos">
                        </div>
                        <div class="col-md-6" style="padding-left: 0px;">
                            <input type="button" name="desmarcar_todos" value="Desmarcar todos" class="form-control desmarcar_todos">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            Números de trabajo:
                        </div><br>
                        <div class="col-md-12">
                            <?php
                            foreach($trabajos_no_asignados_a_evaluador as $trabajo){
                                ?>
                                <input type="checkbox" name="numeros_tl[]" class="checkbox_numeros" value="<?=$trabajo['numero_tl']?>" data-area_tl="<?=$trabajo['area_tl']?>"> <?=$trabajo['numero_tl']?><br>
                                <?php
                            }
                            ?>
                        </div>
                    </div><br>
                    <?php
                    if(count($trabajos_no_asignados_a_evaluador) > 0){
                    ?>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="submit" value="Asignar" class="form-control">
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </form>
        </div><br>
    </div>
</body>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        var se_puede_marcar;
        var filtro_area;
        $(".marcar_todos").click(function(){

            filtro_area = $("select[name='filtro_area_tl'] option:selected");
            $(".checkbox_numeros").each(function(){
                se_puede_marcar = true;
                if(filtro_area.val() !== ""){
                    var area_tl_checkbox = $(this).data('area_tl');
                    if(area_tl_checkbox != filtro_area.val()){
                        se_puede_marcar = false;
                    }
                }
                $(this).prop('checked', se_puede_marcar);
            })
        });

        $(".desmarcar_todos").click(function(){

            $(".checkbox_numeros").each(function(){
                $(this).prop('checked', false);
            })
        });

        $("#asignarTrabajo").submit(function(){

            var inputs_numero_tl = $("input[name='numeros_tl[]']:checked");
            if(inputs_numero_tl.length === 0){

                alert("Debe seleccionar al menos un número de trabajo a asignar");
                $("input[name='numeros_tl[]']").eq(0).focus();
                return false;
            }
        });
    });
</script>
</html>
