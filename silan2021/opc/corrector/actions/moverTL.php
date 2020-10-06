<?php
if(empty($_POST["tl"]) || !isset($_POST["mover_a"])){
    header("Location: ../admin.php");
    die();
} else {


    header("Cache-Control: private, no-cache, must-revalidate");
    header("Pragma: no-cache");
    include("../../../init.php");
    include("../clases/Trabajos.php");

    $trabajos_instancia = new Trabajos();

    $nuevo_estado = $_POST["mover_a"];

    foreach($_POST["tl"] as $id_trabajo){

        $trabajos_instancia->updateEstadoTL($id_trabajo, $nuevo_estado);
    }

    header("Location: ../admin.php");
    die();
}