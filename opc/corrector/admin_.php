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
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
include("../../init.php");
include("clases/Trabajos.php");
include("clases/Evaluaciones.php");

$trabajos_instancia = new Trabajos();
$areas_tl = $trabajos_instancia->getAreasTL();

$estados_tl = [
    0 => 'Recibidos',
    1 => 'En revisión',
    2 => 'Aprobados',
    3 => 'Rechazados',
    4 => 'Notificados'
];

/*$parametros = array();
$txt_filtro = "";
if(count($_POST) > 0) {

    $filtros = array();
    foreach($_POST as $key => $value){
        $filtros[$key] = $value;
    }

    if($filtros['nombre_evaluador'] != ""){
        $txt_filtro .= " AND e.nombre LIKE %?%";
        $parametros[] = $filtros['nombre_evaluador'];
    }
    if($filtros['numero_tl'] != ""){
        $txt_filtro .= " AND t.numero_tl = ?";
        $parametros[] = $filtros['numero_tl'];
    }
    if($filtros['estado_ev'] != ""){
        $txt_filtro .= " AND ev.estadoEvaluacion = ?";
        $parametros[] = $filtros['estado_ev'];
    }
    if($filtros['estado_tl'] != ""){
        $txt_filtro .= " AND t.estado = ?";
        $parametros[] = $filtros['estado_tl'];
    }
    if($filtros['area_tl'] != ""){
        $txt_filtro .= " AND t.area_tl = ?";
        $parametros[] = $filtros['area_tl'];
    }
    if($filtros['resumen_revisado'] != ""){
        if ($filtros['resumen_revisado'] == "Si"){
            $txt_filtro .= " AND ev.estadoEvaluacion <> ''";
        } else if($filtros['resumen_revisado'] == "No") {
            $txt_filtro .= " AND ev.estadoEvaluacion = ''";
        }
    }
}*/

$evaluaciones_instancia = new Evaluaciones();
$evaluaciones = $evaluaciones_instancia->getEvaluaciones();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Administrador de evaluaciones</title>
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="../DataTables/Buttons-1.5.6/css/buttons.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="../estilos/datatables_custom.css"/>
    <link rel="stylesheet" type="text/css" href="css/admin.css" />
</head>
<body>
    <div class="container-fluid">
        <div align="center">
            <div class="col-md-5">
                <?php
                include("include/include_image.php");
                ?>
            </div>
        </div><br>
        <div class="col-md-12" style="border: 2px solid black; background-color: white;">
            <div class="row">
                <div class="col-md-3 padding_top">
                    Usuario: <strong><?=$_SESSION["corrector"]["nombreEvaluador"]?></strong><br>
                    <a href="cerrarSession.php">Cerrar Sessi&oacute;n</a>
                </div>
                <div class="col-md-6 padding_top">
                    <div class="row separador_fila">
                        <div class="col-md-4">
                            Área de trabajo:
                        </div>
                        <div class="col-md-8">
                            <select name="area_tl" class="form-control">
                                <option value=""></option>
                                <?php
                                foreach($areas_tl as $area_tl){
                                    ?>
                                    <option value="<?=$area_tl['id']?>"><?=$area_tl['Area_es']?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!--<br>
                    <form action="admin.php" method="POST">
                        <div class="row separador_fila">
                            <div class="col-md-4">
                                Evaluador:
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="nombre_evaluador" class="form-control">
                            </div>
                        </div>
                        <div class="row separador_fila">
                            <div class="col-md-4">
                                Número de trabajo:
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="numero_tl" class="form-control">
                            </div>
                        </div>
                        <div class="row separador_fila">
                            <div class="col-md-4">
                                Estado Evaluación:
                            </div>
                            <div class="col-md-8">
                                <select name="estado_ev" class="form-control">
                                    <option value=""></option>
                                    <option value="Aceptado">Aceptado</option>
                                    <option value="Aceptado con modificaciones">Aceptado con modificaciones</option>
                                    <option value="Rechazado">Rechazado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row separador_fila">
                            <div class="col-md-4">
                                Estado de trabajo:
                            </div>
                            <div class="col-md-8">
                                <select name="estado_tl" class="form-control">
                                    <option value=""></option>
                                    <?php
                                    foreach($estados_tl as $key => $estado_tl){
                                        ?>
                                        <option value="<?=$key?>"><?=$estado_tl?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row separador_fila">
                            <div class="col-md-4">
                                Área de trabajo:
                            </div>
                            <div class="col-md-8">
                                <select name="area_tl" class="form-control">
                                    <option value=""></option>
                                    <?php
                                    foreach($areas_tl as $area_tl){
                                        ?>
                                        <option value="<?=$area_tl['id']?>"><?=$area_tl['Area_es']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row separador_fila">
                            <div class="col-md-4">
                                Resumen revisado:
                            </div>
                            <div class="col-md-8">
                                <input type="radio" name="resumen_revisado" value="Si"> Si &nbsp;
                                <input type="radio" name="resumen_revisado" value="No"> No
                            </div>
                        </div>
                        <div class="row separador_fila">
                            <div class="col-md-6">
                                <a href="javascript:void(0)" class="form-control btn btn-primary">Limpiar filtro</a>
                            </div>
                            <div class="col-md-6">
                                <input type="submit" value="Filtrar" class="form-control btn btn-primary">
                            </div>
                        </div>
                    </form>-->
                </div>
                <div class="col-md-3 padding_top" style="text-align: right;">
                    <a href="excel/evaluacionesXLS.php" target="_blank">Todas las evaluaciones</a><br>
                    <a href="asignar_trabajo.php" target="_blank">Asignar trabajos a evaluadores</a><br>
                    <a href="crear_evaluador.php" target="_blank">Agregar un evaluador</a>
                </div>
            </div><br>

            <form id="formEvaluaciones" name="formEvaluaciones">
                <div class="row">
                    <div class="col-md-2">
                        <label>Mover trabajos seleccionados a:</label>
                        <select id="mover_a" name="mover_a" class="form-control">
                            <option value=""></option>
                            <?php
                            foreach($estados_tl as $key => $estado_tl){
                                ?>
                                <option value="<?=$key?>"><?=$estado_tl?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <a id="mover_trabajos" href="javascript:void(0)" class="btn btn-info btn-block">Mover</a>
                    </div>
                    <div class="col-md-10" style="text-align: right; font-weight: bold;">
                        <a id="prerarar_mail" href="javascript:void(0)" style="color: black;">Preparar mail a contactos de trabajos</a>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table" id="listado-evaluaciones">
                            <thead>
                                <tr>
                                    <th data-nombre_buscador=""></th>
                                    <th data-nombre_buscador="Número">Nro.</th>
                                    <th data-nombre_buscador="Fecha asignado">Fecha asignado</th>
                                    <th data-nombre_buscador="Nombre del evaluador">Nombre del evaluador</th>
                                    <th data-nombre_buscador="Resumen revisado">Resumen revisado</th>
                                    <th data-nombre_buscador="autores de trabajo">¿Es autor del trabajo?</th>
                                    <th data-nombre_buscador="comentarios">Comentarios del evaluador</th>
                                    <th data-nombre_buscador="calificación">Evaluación</th>
                                    <th data-nombre_buscador="Fecha evaluado">Fecha evaluado</th>
                                    <th data-nombre_buscador="Estado">Estado</th>
                                    <th data-nombre_buscador="Área de trabajo">Área de trabajo</th>
                                    <th data-nombre_buscador=""></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($evaluaciones as $evaluacion){
                                $tl = $trabajos_instancia->getTrabajoByNumeroTL($evaluacion["numero_tl"]);
                                ?>
                                <tr>
                                    <td><input type="checkbox" name="tl[]" class="checkbox_trabajos" value="<?=$evaluacion['id_trabajo']?>"></td>
                                    <td><?=$evaluacion['numero_tl']?></td>
                                    <td><?=$evaluacion['fecha_asignado']?></td>
                                    <td><?=$evaluacion['nombre']?></td>
                                    <td>
                                        <?php
                                        if($evaluacion['evaluar_trabajo'] !== NULL && $evaluacion['evaluar_trabajo'] !== ""){
                                            echo "Si";
                                        } else {
                                            echo "No";
                                        }
                                        ?>
                                    </td>
                                    <td><?=$evaluacion['evaluar_trabajo']?></td>
                                    <td style="text-align: justify;"><?=$evaluacion['comentarios']?></td>
                                    <td><?=$evaluacion['estadoEvaluacion']?></td>
                                    <td><?=$evaluacion['fecha']?></td>
                                    <td><?=$estados_tl[$evaluacion['estado']]?></td>
                                    <td><?=$tl["area_tl"]?></td>
                                    <td><a href="admin_ver_trabajo.php?numero_tl=<?=$evaluacion['numero_tl']?>&evaluador=<?=$evaluacion['id']?>" class="form-control btn btn-info">Ver trabajo</a></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table><br>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../../bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../DataTables/datatables.min.js"></script>
<script type="text/javascript" src="../DataTables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="../DataTables/Buttons-1.5.6/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="../DataTables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="../DataTables/Buttons-1.5.6/js/buttons.print.min.js"></script>
<script type="text/javascript" src="../DataTables/Buttons-1.5.6/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="js/admin.js"></script>
</html>