<?php
if(empty($_GET["numero_tl"]) || empty($_GET["evaluador"])){
    header("Location: login.php");
    die();
}
session_start();
if($_SESSION["corrector"]['idEvaluador'] != $_GET["evaluador"]){ //controlo si son el mismo evaluador
    header("Location: personal.php");
    die();
}
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
include("../../init.php");
include("clases/Auxiliar.php");
include("clases/Evaluaciones.php");
include("clases/evaluadores.class.php");
include("clases/Trabajos.php");

$instancia_evaluaciones = new Evaluaciones();
$instancia_evaluadores = new Evaluadores();
$instancia_trabajos = new Trabajos();
$auxiliar_instancia = new Auxiliar();

$config = $auxiliar_instancia->getConfig();
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
        <div align="center">
            <div class="row">
                <div class="col-md-8">
                    <?php
                    include("include/include_image.php");
                    ?>
                </div>
                <div class="col-md-4">
                    <br>
                    Responsable de la Evaluaci&oacute;n:<br>
                    <strong><?=$evaluador['nombre']?></strong><br>
                    <a href="personal.php">salir</a>
                </div>
            </div>
        </div><br>
        <div class="col-md-12" style="border: 2px solid black; background-color: white;">
            <div class="row">
                <div class="col-md-4" style="background-color: #F4F4F4;">
                    Nº de trabajo: <strong><?=$evaluacion['numero_tl']?></strong><br>
                    Área: <strong><?=$area_tl['Area_es']?></strong><br>
                    Modalidad: <strong><?=$tipo_trabajo['tipoTL_es']?></strong><br>
                    <!--¿Postula a premio?: <strong><?=$trabajo['premio']?></strong><br>-->
                    ¿Soy autor de este trabajo?<br>
                    <form id="formEvaluacion" method="POST" action="guardar_evaluacion.php">
                        <?php
                        $chk_si = ""; $chk_no = "";
                        if ($evaluacion['evaluar_trabajo'] == "Si"){
                            $chk_si = 'checked';
                        }else if ($evaluacion['evaluar_trabajo'] == "No"){
                            $chk_no = 'checked';
                        }
                        ?>
                        <input type="radio" name="acepto_trabajo" value="Si" <?=$chk_si?>> Si &nbsp;&nbsp;
                        <input type="radio" name="acepto_trabajo" value="No" <?=$chk_no?>> No
                        <br><br>
                        <input type="hidden" name="id_evaluacion" value="<?=$evaluacion['idEvaluacion']?>">
                        <div class="div-evaluacion">
                                <div style="border: 1px solid black;">
                                    <div class="col-md-12" style="background-color: #028DC8; color: #FFF;">
                                        Recomendación
                                    </div>
                                    <?php
                                        $chk_aceptado = ""; $chk_aceptado_con_mod = ""; $chk_rechazado = "";
                                        if ($evaluacion['estadoEvaluacion'] == "Aceptado"){
                                            $chk_aceptado = 'checked';
                                        }/*else if ($evaluacion['estadoEvaluacion'] == "Aceptado con modificaciones"){
                                            $chk_aceptado_con_mod = 'checked';
                                        }*/else if ($evaluacion['estadoEvaluacion'] == "Rechazado"){
                                            $chk_rechazado = 'checked';
                                        }
                                    ?>
                                    <div class="col-md-12" style="background-color: white;">
                                        <input type="radio" name="estadoEvaluacion" value="Aceptado" <?=$chk_aceptado?>>Aceptado<br>
                                        <!--<input type="radio" name="estadoEvaluacion" value="Aceptado con modificaciones" <?=$chk_aceptado_con_mod?>>Aceptado con modificaciones<br>-->
                                        <input type="radio" name="estadoEvaluacion" value="Rechazado" <?=$chk_rechazado?>>Rechazado
                                    </div>
                                </div><br>
                                <div id="div-comentarios" style="border: 1px solid black;">
                                    <div class="col-md-12" style="background-color: #028DC8; color: #FFF;">
                                        Indicaciones / Modificaciones
                                    </div>
                                    <div style="background-color: white; margin: 5px;">
                                        <textarea name="comentarios" class="form-control"><?=$evaluacion['comentarios']?></textarea>
                                    </div>
                                </div>
                        </div><br>
                        <input type="submit" value="Guardar evaluación" class="form-control btn btn-danger">
                    </form>
                    <br>
                    <a href="personal.php" class="form-control btn btn-info">Salir sin guardar</a>
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
    </div><br>
</body>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<script>
    $(document).ready(function(){

        procesoEvaluacion();
        $("input[name='acepto_trabajo'], input[name='estadoEvaluacion']").change(function(){
            procesoEvaluacion();
        });

        $("#formEvaluacion").submit(function(){
            return guardarEvaluacion();
        });
    });

    function procesoEvaluacion(){
        var div_evaluacion = $(".div-evaluacion");
        div_evaluacion.hide();
        var div_comentarios = $("#div-comentarios");
        div_comentarios.hide();

        var acepto_trabajo = $("input[name='acepto_trabajo']:checked");
        if(acepto_trabajo.val() == "No"){
            div_evaluacion.show();
            var estado = $("input[name='estadoEvaluacion']:checked");
            if(estado.val() == "Aceptado con modificaciones"){
                div_comentarios.show();
            }else{
                $("textarea[name='comentarios']").val("");
            }
        }else{
            $("input[name='estadoEvaluacion']:checked").prop('checked', false);
            $("textarea[name='comentarios']").val("");
        }
    }

    function guardarEvaluacion(){
        var input_acepto_trabajo = $("input[name='acepto_trabajo']");
        if(input_acepto_trabajo.is(':checked')){

            var acepto_trabajo = $("input[name='acepto_trabajo']:checked");
            if(acepto_trabajo.val() == "No"){

                var input_estado_evaluacion = $("input[name='estadoEvaluacion']");
                if(input_estado_evaluacion.is(':checked')){

                    var estadoEvaluacion = $("input[name='estadoEvaluacion']:checked");
                    if(estadoEvaluacion.val() == "Aceptado con modificaciones"){

                        var comentarios = $("textarea[name='comentarios']");
                        if(comentarios.val() == undefined || comentarios.val() === ""){

                            alert("Debe indicar las modificaciones correspondientes.");
                            comentarios.focus();
                            return false;
                        }
                    }
                } else {

                    alert("Debe evaluar el trabajo.");
                    input_estado_evaluacion.focus();
                    return false;
                }
            }
        } else {

            alert("Debe marcar si es autor o no del trabajo.");
            input_acepto_trabajo.focus();
            return false;
        }


        return true;
    }
</script>
</html>