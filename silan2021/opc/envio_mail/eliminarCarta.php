<?php
$id_carta = trim($_GET["id_carta"]);
if(empty($id_carta)){
    header("Location: altaCarta.php");
    die();
}

session_start();
if(!$_SESSION["admin"]){
    header("Location: ../");
    die();
}

include("../../init.php");
include("clases/Cartas.php");
$cartas_instancia = new Cartas();

$result = $cartas_instancia->eliminarCarta($id_carta);
if($result){
    header("Location: altaCarta.php?success=eliminar");die();
} else {
    header("Location: altaCarta.php?error=eliminar");die();
}