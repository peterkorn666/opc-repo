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
include("../clases/Auxiliar.php");
include("../clases/Autor.php");

$cartas_instancia = new Cartas();
$auxiliar_instancia = new Auxiliar();
$autores_instancia = new Autor();

$config = $cartas_instancia->getConfig();
$cartas_predefinidas = $cartas_instancia->getCartasAutoresTrabajos();
$autores_mail = $autores_instancia->getAutoresConMail();

$paises = $auxiliar_instancia->getPaises();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Autores de Trabajos Libres - Envio de mail - <?=$config["nombre_congreso"]?></title>
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
            Autores y/o Co-Autores de Trabajos Libres
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
        <form id="formCarta" action="process.php" method="POST" enctype="multipart/form-data">
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
                        <input type="checkbox" name="enviar_a_personas" value="1"> Enviar el mail correspondiente a los autores/coautores seleccionados en el listado
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
                        <strong>Autores</strong><br>
                        Hay [<strong><?=count($autores_mail)?></strong>] autores y/o co-autores de trabajos que tienen e-mail de contacto.
                    </div>
                </div>
                <div class="row div_filtros">
                    <div class="col-md-6">
                        <label>Filtro inscripción:</label>
                        <select name="filtro_autores_inscriptos" class="form-control">
                            <option value=""></option>
                            <option value="1">Autores inscriptos</option>
                            <option value="0">Autores NO inscriptos</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Filtro por país:</label>
                        <select name="filtro_pais" class="form-control">
                            <option value=""></option>
                            <?php
                            foreach($paises as $pais){
                                ?>
                                <option value="<?=$pais["ID_Paises"]?>"><?=$pais["Pais"]?></option>
                                <?php
                            }
                            ?>
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
                foreach($autores_mail as $autor){
                    $pais_autor = $auxiliar_instancia->getPaisByID($autor["Pais"]);
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="checkbox" id="personas[]" name="personas[]" value="<?=$autor["ID_Personas"]?>" class="checkbox_personas" data-inscripto="<?=$autor["inscripto"]?>" data-pais="<?=$autor["Pais"]?>"> <?=$autor["Apellidos"]?>, <?=$autor["Nombre"]?> (<?=$pais_autor["Pais"]?>) [<?=$autor["Mail"]?>]
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

        $("#formCarta").submit(function(){
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
            var enviar_a_personas = $("input[name='enviar_a_personas']");
            if(!enviar_a_destinatario_especifico.is(':checked') && !enviar_a_personas.is(':checked')){
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

            var checkboxs_personas = $("input[name='personas[]']:checked");
            if(checkboxs_personas.length === 0){

                alert("Debe seleccionar al menos un autor a enviar el mail.");
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
                                "<input type='checkbox' name='asunto_nombre' value='1'> Agregar nombre y apellido - "+asunto+" [Apellido, Nombre]" +
                            "</div>" +
                        "</div>" +
                    "</div>");

            }
        }
    }

    function marcarTodos(){
        $(".checkbox_personas").each(function(){
            var se_marca = true;
            var filtro_autores_inscriptos = $("select[name='filtro_autores_inscriptos'] option:selected");
            if(filtro_autores_inscriptos.val() !== undefined && filtro_autores_inscriptos.val() !== ""){

                var estado_inscripcion = $(this).data('inscripto');
                if(parseInt(filtro_autores_inscriptos.val()) !== parseInt(estado_inscripcion)){
                    se_marca = false;
                }
            }
            if(se_marca === true){
                var filtro_pais = $("select[name='filtro_pais'] option:selected");
                if(filtro_pais.val() !== undefined && filtro_pais.val() !== ""){

                    var pais = $(this).data('pais');
                    if(parseInt(filtro_pais.val()) !== parseInt(pais)) {
                        se_marca = false;
                    }
                }
            }
            $(this).prop('checked', se_marca);
        })
    }

    function desmarcarTodos(){
        $(".checkbox_personas").each(function(){
            $(this).prop('checked', false);
        })
    }
</script>
</html>