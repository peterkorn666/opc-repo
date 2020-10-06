<?php
session_start();
if($_SESSION["corrector"]["Login"]=="" && $_SESSION["corrector"]["Login"] != "Logueado"){
    header("Location: login.php");
    die();
}

header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
include("../../../init.php");
include("../clases/evaluadores.class.php");
$instancia_evaluadores = new Evaluadores();

$evaluadores = $instancia_evaluadores->getEvaluadores();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Envio de mail a evaluadores</title>
    <link rel="stylesheet" type="text/css" href="../../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../DataTables/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="../../DataTables/Buttons-1.5.6/css/buttons.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="../../estilos/datatables_custom.css"/>
    <link rel="stylesheet" type="text/css" href="css/envio.css"/>
</head>
<body>
    <div class="container-fluid">
        <div class="col-md-12" style="text-align: center;">
            <img src="../../../imagenes/banner.jpg" style='width: 600px;'>
        </div><br>
        <form id="enviarMailEvaluadores" method="POST" action="process.php">
            <div class="col-md-10 offset-1">
                <div class="row">
                    <div id="div-opciones-mail" class="col-md-6">
                        <div class="row separador_fila">
                            <div class="col-md-2" style="vertical-align: middle;">
                                Asunto:
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="asunto" value="" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <input type="checkbox" name="nombre_evaluador"> Nombre evaluador
                            </div>
                        </div>
                        <div class="row separador_fila">
                            <div class="col-md-2" style="vertical-align: middle;">
                                Predefinida:
                            </div>
                            <div clasS="col-md-10">
                                <select name="predefinida" class="form-control">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="row separador_fila">
                            <div class="col-md-6" style="vertical-align: middle;">
                                <a href="" target="_blank">Nueva predefinida</a>
                            </div>
                            <div clasS="col-md-6">
                                <input type="checkbox" name="enviar_a_seleccionados"> Enviar a evaluadores seleccionados
                            </div>
                        </div>
                        <div class="row separador_fila">
                            <div class="col-md-3" style="vertical-align: middle;">
                                Enviar copia:
                            </div>
                            <div class="col-md-8" style="padding-right: 0px;">
                                <input type="text" name="email_copia" class="form-control">
                            </div>
                            <div class="col-md-1" style="padding-left: 0px;">
                                <input type="checkbox" name="enviar_a_email_copia" class="form-control">
                            </div>
                        </div>
                        <div class="row separador_fila">
                            <div class="col-md-3">
                                Mensaje manual:
                            </div>
                            <div class="col-md-9">
                                <textarea name="mensaje_manual" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row separador_fila">
                            <div class="col-md-6">
                                <input type="submit" value="Enviar" class="form-control btn btn-primary">
                            </div>
                            <div class="col-md-6">
                                <a href="../evaluadores.php" class="form-control btn">volver</a>
                            </div>
                        </div>
                    </div>
                    <div id="div-listado-emails" class="col-md-6" style="border-left: 1px black dashed;">
                        <?php
                        foreach($evaluadores as $evaluador){
                            ?>
                            <input type="checkbox" name="evaluadores[]" class="checkbox_evaluadores" value="<?=$evaluador['id']?>"> <?=$evaluador['nombre']?> - (<?=$evaluador['mail']?>)<br>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
<script type="text/javascript" src="../../js/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#enviarMailEvaluadores").submit(function(){

            var asunto = $("input[name='asunto']");
            if(asunto.val() === ""){
                alert('Debe escribir un asunto');
                asunto.focus();
                return false;
            }

            var predefinida = $("select[name='predefinida'] option:selected");
            var mensaje_manual = $("textarea[name='mensaje_manual']");
            if(predefinida.val() === "" && mensaje_manual.val() === ""){

                alert('Debe seleccionar una carta predefinida o escribir la carta manualmente.');
                $("select[name='predefinida']").focus();
                return false;
            }

            var enviar_a_seleccionados = $("input[name='enviar_a_seleccionados']");
            var enviar_a_email_copia = $("input[name='enviar_a_email_copia']");
            if(!enviar_a_seleccionados.is(':checked') && !enviar_a_email_copia.is(':checked')){

                alert('Debe marcar envio a email seleccionados o envio a email de copia.');
                asunto.focus();
                return false;
            } else {

                var checkbox_evaluadores = $("input[name='evaluadores[]']:checked");
                if(checkbox_evaluadores.length === 0){

                    alert("Debe seleccionar al menos un evaluador a enviar el mail.");
                    $("input[name='evaluadores[]']").eq(0).focus();
                    return false;
                }

                if (enviar_a_email_copia.is(':checked')){

                    var email_copia = $("input[name='email_copia']");
                    if(email_copia.val() === ""){

                        alert("Debe escribir el email.");
                        email_copia.focus();
                        return false;
                    } else if(!IsEmail(email_copia.val())){

                        alert("Debe escribir un email válido.");
                        email_copia.focus();
                        return false;
                    }
                }
            }

        });
    });

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
</script>
</html>