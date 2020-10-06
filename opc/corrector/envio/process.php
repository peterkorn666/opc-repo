<?php
//Faltan datos básicos
if(empty($_POST["asunto"]) || (empty($_POST["enviar_a_seleccionados"]) && empty($_POST["enviar_a_email_copia"]))){
    header("Location: index.php");
    die();
}
//Faltan evaluadores
if(empty($_POST["evaluadores"])){
    header("Location: index.php");
    die();
}
//Falta email de copia
if(!empty($_POST["enviar_a_email_copia"]) && empty($_POST["email_copia"])){
    header("Location: index.php");
    die();
}
//Falta carta
if(empty($_POST["predefinida"]) && empty($_POST["mensaje_manual"])){
    header("Location: index.php");
    die();
}

header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
include("../../../init.php");
include("../clases/evaluadores.class.php");
include("clases/Cartas.php");

$instancia_evaluadores = new Evaluadores();
$instancia_cartas = new Cartas();

$config = $instancia_cartas->getConfig();
$url_corrector = $config['url_opc']."corrector/";
$dirBanner = $config['banner_congreso'];

session_start();
//Cargo datos a session
$_SESSION["envio_mail"]["asunto"] = $_POST["asunto"];
if(!empty($_POST["nombre_evaluador"])){
    $_SESSION["envio_mail"]["nombre_evaluador"] = true;
} else {
    $_SESSION["envio_mail"]["nombre_evaluador"] = false;
}

if(!empty($_POST["predefinida"])){
    $_SESSION["envio_mail"]["predefinida"] = $_POST["predefinida"];
    $predefinida = $instancia_cartas->cargarUna($_POST["predefinida"]);
    if($predefinida){
        $cartaMail = $predefinida["cuerpo"];

        $_SESSION["envio_mail"]["cuerpo"] = $cuerpo;
    } else {
        header("Location: index.php?error=predefinida");
        die();
    }

    $_SESSION["envio_mail"]["mensaje_manual"] = NULL;
} else {
    $_SESSION["envio_mail"]["predefinida"] = NULL;
    $_SESSION["envio_mail"]["mensaje_manual"] = $_POST["mensaje_manual"];
}

foreach($_POST["evaluadores"] as $id_evaluador){
    $evaluador = $instancia_evaluadores->getEvaluadorByID($id_evaluador);

    if($_SESSION["envio_mail"]["predefinida"] != NULL){

        $carta = str_replace("<:id>", $evaluador['id'] , $cartaMail);
        $carta = str_replace("<:nombre>", $evaluador['nombre'], $carta);
        $carta = str_replace("<:link_corrector>", "<a href='".$url_corrector."' target='_blank'>".$url_corrector."</a>" , $carta);
        $carta = str_replace("<:email>", $evaluador['mail'] , $carta);
        $carta = str_replace("<:clave>", $evaluador['clave'] , $carta);
    } else {

        $mensaje = $_SESSION["envio_mail"]["mensaje_manual"];
        $mensaje = nl2br($mensaje);
    }

    $cuerpo = '
            <table width="626" border="0" cellspacing="1" cellpadding="4" align="center">
              <tr>
                <td colspan="2" align="center" style="font-size:16px"><img src="'.$dirBanner.'" width="900"></td>
              </tr>
              <tr>
                <td colspan="2" align="left" valign="top">'.($mensaje!=""?$mensaje:nl2br($carta)).'</td>
              </tr>
            </table>
        ';

    $_SESSION["envio_mail"]["evaluadores"][] = array(
        "id" => $evaluador['id'],
        "nombre" => $evaluador['nombre'],
        "email" => $evaluador['mail'],
        "cuerpo_mail" => $cuerpo
    );
}

if(!empty($_POST["enviar_a_seleccionados"])){
    $_SESSION["envio_mail"]["enviar_a_seleccionados"] = true;
} else {
    $_SESSION["envio_mail"]["enviar_a_seleccionados"] = false;
}

if(!empty($_POST["enviar_a_email_copia"])){
    $_SESSION["envio_mail"]["enviar_a_email_copia"] = true;

    $_SESSION["envio_mail"]["email_copia"] = explode(";", $_POST["email_copia"]);
} else {
    $_SESSION["envio_mail"]["enviar_a_email_copia"] = false;
    $_SESSION["envio_mail"]["email_copia"] = NULL;
}

$_SESSION["envio_mail"]["habilitado"] = true;

header("Location: enviar.php");
die();