<?php
session_start();
if(!$_SESSION["admin"]){
    header("Location: ../../");
    die();
}

header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
include("../../../init.php");
include("../clases/Cartas.php");
include("../clases/Trabajo.php");

$cartas_instancia = new Cartas();
$trabajos_instancia = new Trabajo();

$config = $cartas_instancia->getConfig();
$cartas_predefinidas = $cartas_instancia->getCartasContactosTrabajo();

if(count($_POST["tl"]) > 0){
    $trabajos_mail = $trabajos_instancia->getTrabajosMailByIDS($_POST["tl"]);
} else {
    $trabajos_mail = $trabajos_instancia->getTrabajosMail();
}

$estados_tl = array(
    0 => "Recibidos",
    1 => "En revisión",
    2 => "Aprobados",
    3 => "Rechazados",
    4 => "Notificados"
);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Contactos de Trabajos Libres - Envio de mail - <?=$config["nombre_congreso"]?></title>
    <link rel="stylesheet" type="text/css" href="../../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/envioMail.css"/>
</head>
<body>
    <div class="container">
        <div align="center" style="margin-bottom: 10px;">
            <div class="col-md-8">
                <img src="../../imagenes/banner.jpg" class="img-fluid">
            </div>
        </div>
        <div class="col-md-12" style="text-align: center;">
            <h3>Envio de e-mails</h3>
            Contactos de Trabajos Libres
        </div>
        <?php
        if($_GET["error"]){
            ?>
            <div class="col-md-12 alert alert-danger">
                Ocurrió un error al procesar los datos.
            </div>
            <?php
        }
        ?>
        <div class="col-md-12">
            <a href="../altaCarta.php">Crear nueva predefinida</a>
        </div>
        <form id="formCartaTrabajos" action="process.php" method="POST" enctype="multipart/form-data">
            <!-- Recuadro 1 - Datos carta -->
            <div class="col-md-12 datos_carta">
                <div clasS="row">
                    <div class="col-md-12">
                        Seleccione la carta:<br>
                        <input type="radio" name="carta_a_enviar" value="manual"> Carta Manual<br>
                        <?php
                        foreach($cartas_predefinidas as $carta_predefinida){
                            ?>
                            <input type="radio" name="carta_a_enviar" data-asunto="<?=$carta_predefinida['asunto']?>" value="<?=$carta_predefinida['idCarta']?>"> <?=$carta_predefinida["titulo"]?><br>
                            <?php
                        }
                        ?>
                    </div>
                </div><br>
                <div class="row" id="div_carta_a_enviar">

                </div><br>
                <div class="row">
                    <div class="col-md-12">
                        Adjuntar un archivo:<br>
                        <input type="file" name="adjunto" >
                    </div>
                </div>
            </div>
            <!-- end Recuadro 1 -->
            <br>
            <!-- Recuadro 2 - Datos envio -->
            <div class="col-md-12 datos_envio">
                <div class="row">
                    <div class="col-md-8">
                        <input type="checkbox" name="enviar_a_destinatario_especifico" value="1">  Enviar mail de cada trabajo seleccionado a un solo destinatario, el cual es:<br>
                        <input type="text" name="destinatario_especifico" class="form-control">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-8">
                        <input type="checkbox" name="enviar_a_contactos_trabajo" value="1"> Enviar el mail correspondiente al contacto del trabajo seleccionado
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-3">
                        <strong>Datos del trabajo en el mail:</strong>
                    </div>
                    <div class="col-md-2">
                        <input type="checkbox" name="mostrar_ubicacion" value="1"> Mostrar ubicación
                    </div>
                    <div class="col-md-2">
                        <input type="checkbox" name="mostrar_trabajo" value="1"> Mostrar trabajo
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-12">
                        <input type="submit" value="Enviar mails" class="btn btn-info btn-block">
                    </div>
                </div>
            </div>
            <!-- end Recuadro 2 -->
            <br>
            <!-- Recuadro 3 - Datos de los contactos de trabajo -->
            <div class="col-md-12 datos_listado">
                <div class="row div_info">
                    <div class="col-md-12">
                        <strong>Trabajos</strong><br>
                        Hay [<strong><?=count($trabajos_mail)?></strong>] trabajos que tienen e-mail de contacto (puede que no esten ubicados todavía).
                    </div>
                </div>
                <div class="row div_filtros">
                    <div class="col-md-6">
                        <label>Trabajos con estado:</label>
                        <select name="filtro_estado" class="form-control">
                            <option value=""></option>
                            <?php
                            foreach($estados_tl as $key => $estado){
                                ?>
                                <option value="<?=$key?>"><?=$estado?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Trabajos con autores:</label>
                        <select name="filtro_autores_inscriptos" class="form-control">
                            <option value=""></option>
                            <option value="todos_inscriptos">Todos inscriptos</option>
                            <option value="1">Por lo menos 1 inscripto</option>
                            <option value="0">Ningún inscripto</option>
                        </select>
                    </div>
                </div>
                <div class="row div_marcar">
                    <div class="col-md-12">
                        <a href="javascript:void(0)" class="marcar_todos">Marcar todos</a> / <a href="javascript:void(0)" class="desmarcar_todos">Desmarcar todos</a>
                    </div>
                </div>
                <div id="listado">
                <?php
                foreach($trabajos_mail as $trabajo){
                    $autores = $trabajos_instancia->getAutoresByTrabajoID($trabajo["id_trabajo"]);
                    $cont_inscriptos = 0;
                    foreach($autores as $autor){
                        if((int)$autor["inscripto"] === 1){
                            $cont_inscriptos++;
                        }
                    }
                    $txt_autores = "";
                    if(count($autores) === $cont_inscriptos){
                        $txt_autores = "todos_inscriptos";
                    } else {
                        $txt_autores = $cont_inscriptos;
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="checkbox" id="trabajo[]" name="trabajo[]" value="<?=$trabajo["id_trabajo"]?>" class="checkbox_trabajos" data-estado="<?=$trabajo["estado"]?>" data-autores_inscriptos="<?=$txt_autores?>"> <?=$trabajo["numero_tl"]?> - <?=$trabajo["titulo_tl"]?> [Contacto: <?=$trabajo["contacto_mail"]?>]
                        </div>
                    </div>
                    <?php
                }
                ?>
                </div>
                <div class="row div_marcar">
                    <div class="col-md-12">
                        <a href="javascript:void(0)" class="marcar_todos">Marcar todos</a> / <a href="javascript:void(0)" class="desmarcar_todos">Desmarcar todos</a>
                    </div>
                </div>
            </div>
            <!-- end Recuadro 3 -->
        </form>
        <br>
    </div>
</body>
<script type="text/javascript" src="../../js/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        cartaEnviar();
        $("input[name='carta_a_enviar']").change(function(){
            cartaEnviar();
        });

        var asunto_manual;
        var div_carta_a_enviar = $("#div_carta_a_enviar");
        div_carta_a_enviar.on('keyup', "input[name='asunto']", function(){
            asunto_manual = $("input[name='asunto']").val();
            $(".asunto_muestra").each(function(){
                $(this).html(asunto_manual);
            });
        });

        $(".marcar_todos").click(function(){
            marcarTodos();
        });
        $(".desmarcar_todos").click(function(){
            desmarcarTodos();
        });

        $("#formCartaTrabajos").submit(function(){
            var carta_a_enviar = $("input[name='carta_a_enviar']:checked");
            if(carta_a_enviar.val() === undefined || carta_a_enviar.val() === ""){
                alert("Debe seleccionar la carta manual o una predefinida.");
                return false;
            } else if(carta_a_enviar.val() === "manual") {

                var asunto = $("input[name='asunto']");
                if(asunto.val() === undefined || asunto.val() === ""){
                    alert("Debe escribir un asunto.");
                    asunto.focus();
                    return false;
                }
                var carta_manual = $("textarea[name='carta_manual']");
                if(carta_manual.val() === undefined || carta_manual.val() === ""){
                    alert("Debe escribir cuerpo para la carta.");
                    carta_manual.focus();
                    return false;
                }
            }

            var enviar_a_destinatario_especifico = $("input[name='enviar_a_destinatario_especifico']");
            var enviar_a_contactos_trabajo = $("input[name='enviar_a_contactos_trabajo']");
            if(!enviar_a_destinatario_especifico.is(':checked') && !enviar_a_contactos_trabajo.is(':checked')){
                alert("Debe elegir o escribir a quien enviar el mail.");
                return false;
            } else if(enviar_a_destinatario_especifico.is(':checked')){
                var destinatario_especifico = $("input[name='destinatario_especifico']");
                if(destinatario_especifico.val() === undefined || destinatario_especifico.val() === ""){
                    alert("Debe escribir el destinatario específico a enviar el mail.");
                    destinatario_especifico.focus();
                    return false;
                }
            }

            var checkboxs_trabajos = $("input[name='trabajo[]']:checked");
            if(checkboxs_trabajos.length === 0){

                alert("Debe seleccionar al menos un trabajo a enviar el mail.");
                return false;
            }
        });
    });

    function cartaEnviar(){
        var div_carta_a_enviar = $("#div_carta_a_enviar");
        div_carta_a_enviar.empty();

        var carta_a_enviar = $("input[name='carta_a_enviar']:checked");
        if(carta_a_enviar.val() != undefined && carta_a_enviar.val() !== ""){
            if(carta_a_enviar.val() == "manual"){
                div_carta_a_enviar.append("" +
                    "<div class='col-md-12'>" +
                        "<div class='row'>" +
                            "<div class='col-md-12'>" +
                                "Asunto: <input type='text' name='asunto' class='form-control'>" +
                                "<input type='checkbox' name='asunto_trabajo' value='1'> Agregar trabajo - <span class='asunto_muestra'></span> [Cod.Trabajo]<br>" +
                                "<input type='checkbox' name='asunto_nombre' value='1'> Agregar nombre y apellido - <span class='asunto_muestra'></span> [Apellido, Nombre]" +
                            "</div>" +
                        "</div><br>" +
                        "<div class='row'>" +
                            "<div class='col-md-12'>" +
                                "Cuerpo de la carta:" +
                                "<textarea name='carta_manual' class='form-control'></textarea>" +
                            "</div>" +
                        "</div>" +
                    "</div>");
            } else {
                var asunto = carta_a_enviar.data('asunto');
                div_carta_a_enviar.append("" +
                    "<div class='col-md-12'>" +
                        "<div class='row'>" +
                            "<div class='col-md-12'>" +
                                "Asunto: <strong>"+asunto+"</strong><br>" +
                                "<input type='checkbox' name='asunto_trabajo' value='1'> Agregar trabajo - "+asunto+" [Cod.Trabajo]<br>" +
                                "<input type='checkbox' name='asunto_nombre' value='1'> Agregar nombre y apellido - "+asunto+" [Apellido, Nombre]" +
                            "</div>" +
                        "</div>" +
                    "</div>");

            }
        }
    }

    function marcarTodos(){
        $(".checkbox_trabajos").each(function(){
            var se_marca = true;
            var filtro_estado = $("select[name='filtro_estado'] option:selected");
            if(filtro_estado.val() !== undefined && filtro_estado.val() !== ""){

                var estado = $(this).data('estado');
                if(parseInt(filtro_estado.val()) !== estado){
                    se_marca = false;
                }
            }
            if(se_marca === true){
                var filtro_autores_inscriptos = $("select[name='filtro_autores_inscriptos'] option:selected");
                if(filtro_autores_inscriptos.val() !== undefined && filtro_autores_inscriptos.val() !== ""){

                    var autores_inscriptos = $(this).data('autores_inscriptos');
                    if(autores_inscriptos === "todos_inscriptos"){
                        if(parseInt(filtro_autores_inscriptos.val()) === 0){
                            se_marca = false;
                        }
                    } else {
                        if(filtro_autores_inscriptos.val() === "todos_inscriptos"){
                            se_marca = false;
                        } else if(parseInt(filtro_autores_inscriptos.val()) === 0 && (parseInt(autores_inscriptos) > 0)){
                            se_marca = false;
                        } else if(parseInt(filtro_autores_inscriptos.val()) > parseInt(autores_inscriptos)) {
                            se_marca = false;
                        }
                    }
                }
            }
            $(this).prop('checked', se_marca);
        })
    }

    function desmarcarTodos(){
        $(".checkbox_trabajos").each(function(){
            $(this).prop('checked', false);
        })
    }
</script>
</html>