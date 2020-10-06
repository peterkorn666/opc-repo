<?php
if(count($_POST) == 0){
    header("Location: login.php");
    die();
}

$id_evaluacion = NULL;
$datos = array();

$faltan_datos = false;
if (empty($_POST["acepto_trabajo"]) || empty($_POST["id_evaluacion"])){

    $faltan_datos = true;
} else {

    $id_evaluacion = $_POST["id_evaluacion"];
    $datos = array(
        "evaluar_trabajo" => $_POST["acepto_trabajo"],
        "estadoEvaluacion" => $_POST["estadoEvaluacion"],
        "comentarios" => $_POST["comentarios"]
    );
    if ($datos["evaluar_trabajo"] == "No" && empty($_POST["estadoEvaluacion"])){
        $faltan_datos = true;
    } else if ($datos["evaluar_trabajo"] == "No") {
        if ($datos["estadoEvaluacion"] == "Aceptado con modificaciones" && empty($_POST["comentarios"])){
            $faltan_datos = true;
        }
    }
}
if($faltan_datos){
    header("Location: login.php");
    die();
}

include("../../init.php");
include("clases/Evaluaciones.php");

$tiempo = new DateTime("now", new DateTimeZone("America/Montevideo"));
$fecha = $tiempo->format('Y-m-d H:i:s');
$datos['fecha'] = $fecha;

$instancia_evaluaciones = new Evaluaciones();
$actualizado = $instancia_evaluaciones->actualizarEvaluacion($id_evaluacion, $datos);

if ($actualizado === false){
    header("Location: login.php?error=actualizarEvaluacion");
    die();
} else {
    header("Location: personal.php?success=true");
    die();
}