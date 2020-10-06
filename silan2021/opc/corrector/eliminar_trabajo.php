<?php
if(empty($_GET['id_evaluador']) || empty($_GET['numero_tl'])){
    header("Location: login.php");
    die();
}

include('../../init.php');
include('clases/Evaluaciones.php');
$evaluaciones = new Evaluaciones();

$result = $evaluaciones->eliminarEvaluacion($_GET['numero_tl'], $_GET['id_evaluador']);
if($result){

    header("Location: evaluadores.php?trabajo_eliminado=true&evaluador=".$_GET['id_evaluador']."&numero=".$_GET['numero_tl']);
}else{

    header("Location: evaluadores.php?error=true&".$_GET['id_evaluador']."&numero=".$_GET['numero_tl']);
}
die();