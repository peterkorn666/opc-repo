<?php
session_start();
if(!$_SESSION["admin"]){
    header("Location: ../");
    die();
}

include("../../init.php");
include("clases/Cartas.php");
$cartas_instancia = new Cartas();
$config = $cartas_instancia->getConfig();

$destinatarios_cartas = $cartas_instancia->getCartasDestinatarios();
$cartas_creadas = $cartas_instancia->getCartas();

if($_GET["id_carta"]){
    $carta = $cartas_instancia->getCartaByID($_GET["id_carta"]);
    if(count($carta) == 0){
        header("Location: altaCarta.php");die();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Creado y edición de cartas - <?=$config["nombre_congreso"]?></title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/altaCarta.css" />
</head>
<body>
    <div class="container">
        <br>
        <div class="col-md-12" style="text-align: center;">
            <span style="font-weight: bold; font-size: 18px;">Alta Carta Predefinida</span><br>
            <a href="trabajos/">Contactos de trabajo</a> | <a href="autores/">Autores de trabajo</a> | <a href="conferencistas/">Conferencistas</a> <!--| <a href="inscriptos/">Inscriptos</a>--> | <a href="evaluadores/">Evaluadores</a>
            <br>
            <a href="../?page=buscarTL" target="_blank">Busqueda Avanzada de Trabajos</a>
        </div><br>
        <a href="altaCarta.php">Crear nueva</a>
        <div class="col-md-12" style="border: 2px solid black; background-color: #CCCCCC; padding-bottom: 15px;">
            <form id="formAltaCarta" action="altaCartaGuardar.php" method="POST">
                <?php
                if($_GET["error"]){
                    if($_GET["error"] == "camposVacios"){
                        ?>
                            <div class="row">
                                <div class="col-md-12 alert alert-danger" style="text-align: center;">
                                    Ha ocurrido un error con el campo <?=$_GET["campo"]?>.
                                </div>
                            </div>
                        <?php
                    } else if ($_GET["error"] == "eliminar") {
                        ?>
                            <div class="row">
                                <div class="col-md-12 alert alert-danger" style="text-align: center;">
                                    Ha ocurrido un error al eliminar la carta.
                                </div>
                            </div>
                        <?php
                    } else {
                        ?>
                            <div class="row">
                                <div class="col-md-12 alert alert-danger" style="text-align: center;">
                                    Ha ocurrido un error al guardar la carta.
                                </div>
                            </div>
                        <?php
                    }
                } //end error

                if($_GET["success"]){
                    if($_GET["success"] == "eliminar"){
                        ?>
                            <div class="row">
                                <div class="col-md-12 alert alert-success" style="text-align: center;">
                                    Se ha eliminado la carta con éxito.
                                </div>
                            </div>
                        <?php
                    } else {
                        ?>
                            <div class="row">
                                <div class="col-md-12 alert alert-success" style="text-align: center;">
                                    Se ha creado la carta con éxito.
                                </div>
                            </div>
                        <?php
                    }
                } //end success
                ?>
                <div class="tabla_campos">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Título de la carta</label><br>
                            <input type="text" name="titulo" value="<?=$carta["titulo"]?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Subtítulo de la carta</label><br>
                            <input type="text" name="subtitulo" value="<?=$carta["subtitulo"]?>" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>A quién está dirigida</label><br>
                            <select name="destinatarios" class="form-control">
                                <option value=""></option>
                                <?php
                                $selected = "";
                                foreach($destinatarios_cartas as $destinatario_carta){
                                    if($carta){
                                        if($carta["destinatarios"] == $destinatario_carta['id_destinatario']){
                                            $selected = 'selected';
                                        }
                                    }
                                    ?>
                                    <option value="<?=$destinatario_carta['id_destinatario']?>" <?=$selected?>>
                                        <?=$destinatario_carta['nombre_destinatario']?>
                                    </option>
                                    <?php
                                    $selected = "";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Asunto</label><br>
                            <input type="text" name="asunto" value="<?=$carta["asunto"]?>" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            Cuerpo de la Carta<br>
                            <textarea name="cuerpo" class="form-control"><?=$carta["cuerpo"]?></textarea>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-12">
                            <input type="submit" value="Guardar Carta" class="form-control btn btn-secondary">
                        </div>
                    </div>
                </div>
                <?php
                    if(count($carta) > 0){
                        ?>
                        <input type="hidden" name="id_carta" value="<?=$carta["idCarta"]?>">
                        <?php
                    }
                ?>
            </form>
            <br><br>

            <!-- Listado cartas creadas -->
            <div class="col-md-12 tabla_cartas">
                <div class="row titulo">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-4">
                        Título
                    </div>
                    <div class="col-md-3">
                        Asunto
                    </div>
                    <div class="col-md-3">
                        Destinatarios
                    </div>
                    <div class="col-md-1">

                    </div>
                </div>
                <?php
                foreach($cartas_creadas as $carta_creada){
                    $carta_creada_destinatarios = $cartas_instancia->getDestinatariosByID($carta_creada['destinatarios']);
                    ?>
                    <div class="row">
                        <div class="col-md-1">
                            <i class="fas fa-edit editar_carta" data-id="<?=$carta_creada["idCarta"]?>"></i>
                        </div>
                        <div class="col-md-4">
                            <?=$carta_creada['titulo']?>
                        </div>
                        <div class="col-md-3">
                            <?=$carta_creada['asunto']?>
                        </div>
                        <div class="col-md-3">
                            <?=$carta_creada_destinatarios['nombre_destinatario']?>
                        </div>
                        <div class="col-md-1">
                            <i class="fas fa-trash-alt eliminar_carta" data-id="<?=$carta_creada["idCarta"]?>" data-titulo="<?=$carta_creada["titulo"]?>"></i>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <br><br>

            <!-- Tabla trabajo libre -->
            <div id="div-trabajos-libres" class="col-md-12 tabla_etiquetas">
                <div class="row">
                   <div class="col-md-12 titulo">
                       Trabajos Libres: (clic para copiar y luego pegar)
                   </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Número de trabajo
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:numero_tl></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Título de trabajo
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:titulo_tl></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Autores del trabajo
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:autores_tl></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Presentador del trabajo
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:presentador_tl></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Nombre contacto
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:nombreContacto></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Apellido contacto
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:apellidoContacto></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Email contacto
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:mail></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Clave del trabajo
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:clave></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Link del trabajo completo (si tiene uno)
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:link_trabajo_completo></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Link para editar trabajo (texto 'aquí')
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:link_editar_trabajo_aqui></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Comentarios del evaluador (si existiesen)
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:comentarios_evaluador></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla autores -->
            <div id="div-autores" class="col-md-12 tabla_etiquetas">
                <div class="row">
                    <div class="col-md-12 titulo">
                        Autores: (clic para copiar y luego pegar)
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Nombre
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:nombre></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Apellidos
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:apellidos></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Profesión
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:profesion></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Email
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:email></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Institución
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:institucion></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                País
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:pais></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Número de trabajo
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:numero_tl></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Título de trabajo
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:titulo_tl></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Autores del trabajo
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:autores_tl></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Link del trabajo completo
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:link_trabajo_completo></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla conferencistas -->
            <div id="div-conferencistas" class="col-md-12 tabla_etiquetas">
                <div class="row">
                    <div class="col-md-12 titulo">
                        Conferencistas: (clic para copiar y luego pegar)
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Nombre
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:nombre></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Apellido
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:apellido></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Profesión
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:profesion></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Email
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:email></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Institución
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:institucion></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                País
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:pais></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Participaciones de actividades
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:participaciones></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Vínculo para editar (texto 'aquí')
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:link_conferencista_aqui></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla inscriptos -->
            <div id="div-inscriptos" class="col-md-12 tabla_etiquetas">
                <div class="row">
                    <div class="col-md-12 titulo">
                        Inscriptos: (clic para copiar y luego pegar)
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Nombre
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:nombre></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Apellido
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:apellido></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Pasaporte
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:pasaporte></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Email
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:email></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fila_separadora">
                    <div class="col-md-6 columna_separadora">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                Institución
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:institucion></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 nombre_etiqueta">
                                País
                            </div>
                            <div class="col-md-6">
                                <span class="etiqueta"><:pais></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end-->
        </div><br>
    </div>
</body>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        var destinatario;
        var div_etiquetas_trabajos_libres = $("#div-trabajos-libres");
        var div_etiquetas_autores = $("#div-autores");
        var div_etiquetas_conferencistas = $("#div-conferencistas");
        var div_etiquetas_inscriptos = $("#div-inscriptos");
        $("select[name='destinatarios']").change(function(){
            div_etiquetas_trabajos_libres.hide();
            div_etiquetas_autores.hide();
            div_etiquetas_conferencistas.hide();
            div_etiquetas_inscriptos.hide();
            destinatario = $("select[name='destinatarios'] option:selected");
            switch(destinatario.val()){
                case '1':
                    div_etiquetas_trabajos_libres.show();
                    break;
                case '2':
                    div_etiquetas_autores.show();
                    break;
                case '3':
                    div_etiquetas_conferencistas.show();
                    break;
                case '4':
                    div_etiquetas_inscriptos.show();
                    break;
                default:
                    div_etiquetas_trabajos_libres.show();
                    div_etiquetas_autores.show();
                    div_etiquetas_conferencistas.show();
                    div_etiquetas_inscriptos.show();
                    break;
            }
        });

        $(".etiqueta").click(function(){
            copyToClipboard($(this));
            alert("Etiqueta copiada!");
        });

        var id_a_editar;
        $(".editar_carta").click(function(){
            id_a_editar = $(this).data('id');
            window.location.href = "altaCarta.php?id_carta="+id_a_editar;
        });

        var id_a_eliminar, titulo_a_eliminar;
        $(".eliminar_carta").click(function(){
            id_a_eliminar = $(this).data('id');
            titulo_a_eliminar = $(this).data('titulo');
            if(confirm("¿Quiere eliminar la carta de título '"+titulo_a_eliminar+"'?")){
                window.location.href = "eliminarCarta.php?id_carta="+id_a_eliminar;
            }
        });

        $("#formAltaCarta").submit(function(){

            var titulo = $("input[name='titulo']");
            if(esVacio(titulo.val())){
                alert("Debe escribir el título de la carta.");
                titulo.focus();
                return false;
            }
            var subtitulo = $("input[name='subtitulo']");
            if(esVacio(subtitulo.val())){
                alert("Debe escribir el subtitulo de la carta.");
                subtitulo.focus();
                return false;
            }
            var destinatarios = $("select[name='destinatarios'] option:selected");
            if(esVacio(destinatarios.val())){
                alert("Debe seleccionar los destinatarios de la carta.");
                $("select[name='destinatarios']").focus();
                return false;
            }
            var asunto = $("input[name='asunto']");
            if(esVacio(asunto.val())){
                alert("Debe escribir el asunto de la carta.");
                asunto.focus();
                return false;
            }
            var cuerpo = $("textarea[name='cuerpo']");
            if(esVacio(cuerpo.val())){
                alert("Debe escribir el cuerpo de la carta.");
                cuerpo.focus();
                return false;
            }
        })
    });

    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }

    function esVacio(value){
        return (value === "" || value == undefined);
    }
</script>
</html>
