<?php
//POST
$campos_obligatorios = array(
    "titulo", "subtitulo", "asunto", "destinatarios", "cuerpo"
);
$campos_carta = array();
foreach($campos_obligatorios as $campo_obligatorio){
    if(empty($_POST[$campo_obligatorio])){
        header("Location: altaCarta.php?error=camposVacios&campo=".$campo_obligatorio);
        die();
    } else {
        $campos_carta[$campo_obligatorio] = $_POST[$campo_obligatorio];
    }
}
if(empty($_POST["id_carta"])){
    $id_carta = NULL;
} else {
    $id_carta = $_POST["id_carta"];
}

include("../../init.php");
include("clases/Cartas.php");
$cartas_instancia = new Cartas();

if ($id_carta != NULL){
    $result = $cartas_instancia->editarCarta($id_carta, $campos_carta);
} else {
    $result = $cartas_instancia->crearCarta($campos_carta);
}
if($result){
    header("Location: altaCarta.php?success=true");die();
} else {
    header("Location: altaCarta.php?error=true");die();
}