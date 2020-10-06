<?php
if(empty($_POST["carta_a_enviar"]) || (empty($_POST["enviar_a_destinatario_especifico"]) && empty($_POST["enviar_a_contactos_trabajo"])) || empty($_POST["trabajo"])){
    header("Location: index.php?error=true");
    die();
}
$datos_carta_a_enviar = array();
$carta_a_enviar = $_POST["carta_a_enviar"];
$enviar_a_destinatario_especifico = $_POST["enviar_a_destinatario_especifico"];
$enviar_a_contactos_trabajo = $_POST["enviar_a_contactos_trabajo"];
$ids_trabajos = $_POST["trabajo"];

if($carta_a_enviar == "manual"){ //Caso manual
    if(empty($_POST["asunto"]) || empty($_POST["carta_manual"])){
        header("Location: index.php?error=true");
        die();
    }
    $datos_carta_a_enviar["asunto"] = $_POST["asunto"];
    $datos_carta_a_enviar["carta_manual"] = $_POST["carta_manual"];
} else { //Caso predefinida
    $datos_carta_a_enviar["carta_id"] = $carta_a_enviar;
}
if($enviar_a_destinatario_especifico == '1'){
    if(empty($_POST["destinatario_especifico"])){
        header("Location: index.php?error=true");
        die();
    }
    $datos_carta_a_enviar["destinatario_especifico"] = 1;
    $datos_carta_a_enviar["destinatario_especifico_emails"] = $_POST["destinatario_especifico"];
}
if($enviar_a_contactos_trabajo == '1'){
    $datos_carta_a_enviar["enviado_a_personas"] = 1;
}

if(!empty($_POST["asunto_trabajo"])){
    $datos_carta_a_enviar["asunto_trabajo"] = 1;
}
if(!empty($_POST["asunto_nombre"])){
    $datos_carta_a_enviar["asunto_nombre"] = 1;
}
if($_FILES['adjunto']['error'] == UPLOAD_ERR_OK){
    $datos_carta_a_enviar["adjunto"] = $_FILES['adjunto']["name"];
    if($_FILES["adjunto"]["tmp_name"] != ""){
        copy($_FILES["adjunto"]["tmp_name"], "../adjuntos/trabajos/" . $_FILES["adjunto"]["name"]);
    } else {
        header("Location: index.php?error=true");
        die();
    }
}
if(!empty($_POST["mostrar_ubicacion"])){
    $datos_carta_a_enviar["mostrar_ubicacion"] = 1;
}
if(!empty($_POST["mostrar_trabajo"])){
    $datos_carta_a_enviar["mostrar_trabajo"] = 1;
}

session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

require "../../../init.php";
require "../clases/Cartas.php";
require "../clases/Auxiliar.php";
require "../clases/Trabajo.php";
require "config.php";

$cartas_instancia = new Cartas();
$auxiliar_instancia = new Auxiliar();
$trabajos_instancia = new Trabajo();

$config = $cartas_instancia->getConfig();

$predefinida = NULL;
if($carta_a_enviar == "manual"){

    $asunto = $datos_carta_a_enviar["asunto"];
    $cuerpo_mail = $datos_carta_a_enviar["carta_manual"];
} else {

    $predefinida = $cartas_instancia->getCartaByID($datos_carta_a_enviar["carta_id"]);
    $asunto = $predefinida["asunto"];
    $cuerpo_mail = $predefinida["cuerpo"];
}
$result = $cartas_instancia->insertCartaEnviada($datos_carta_a_enviar);
if($result){
    $id_carta_enviada = $result;
} else {
    header("Location: index.php?error=true");
    die();
}

$cantidad_trabajos = count($_POST["trabajo"]);

unset($_SESSION["envio_mail"]["contactos_trabajos"]);
$_SESSION["envio_mail"]["contactos_trabajos"]["carta_enviada_id"] = $id_carta_enviada;
$_SESSION["envio_mail"]["contactos_trabajos"]["cantidad_trabajos"] = $cantidad_trabajos;
$_SESSION["envio_mail"]["contactos_trabajos"]["adjunto"] = $datos_carta_a_enviar["adjunto"];
$_SESSION["envio_mail"]["contactos_trabajos"]["trabajos"] = array();

$contador_mails_enviados = 0;
foreach($_POST["trabajo"] as $id_trabajo){

    $row = $trabajos_instancia->getTrabajoByID((int)$id_trabajo);

    //Mostrar ubicación
    $ubicacion = "";
    if($datos_carta_a_enviar["mostrar_ubicacion"] === 1 && ($row["id_crono"] != 0)) {

        $casillero = $auxiliar_instancia->getCasilleroByID($row["id_crono"]);
        setlocale(LC_TIME, 'es_ES');
        $ubicacion = "<br>";
        $fecha_inicio = substr($casillero["start_date"],0,10);
        $dia_inicio = ucwords(utf8_encode(strftime("%A %d", strtotime($fecha_inicio))));
        $sala = $casillero["name"];
        $hora_inicio = substr($casillero["start_date"], 10, 6);
        $hora_fin = substr($casillero["end_date"], 10, 6);
        $ubicacion .= $dia_inicio.' | '.$sala.' | '.$hora_inicio.' - '.$hora_fin;
        if($casillero["tipo_actividad"]){
            $tipo_actividad = $auxiliar_instancia->getTipoActividad($casillero["tipo_actividad"]);
            $ubicacion .= " - ".$tipo_actividad["tipo_actividad"];
        }

        $ubicacion .= "<div style='border-bottom: 1px solid; margin-bottom:25px;'></div>";
        if($casillero["titulo_actividad"])
            $ubicacion .= $casillero["titulo_actividad"]."<br><br>";

        $trabajos_en_casillero = $trabajos_instancia->getTrabajosByCronoID($row["id_crono"]);
        foreach($trabajos_en_casillero as $trabajo_en_casillero){

            $ubicacion .= "<strong>".$trabajo_en_casillero["titulo_tl"]." &nbsp;&nbsp; (#".$trabajo_en_casillero["numero_tl"].")</strong><br><br>";

            //Autores
                $txt_autores = $trabajos_instancia->getTemplateAutores($trabajo_en_casillero["id_trabajo"]);
                $ubicacion .= "<div style='font-size: 14px;'>";
                    $ubicacion .= $txt_autores;
                $ubicacion .= "</div>";
                $ubicacion .= "<br>";
            //--Autores

            $ubicacion .= "<div style='text-align: justify;'>";
                $ubicacion .= "<strong>Resumen:</strong><br>";
                $ubicacion .= $trabajo_en_casillero["resumen"]."<br><br>";
            $ubicacion .= "</div>";
            $ubicacion .= "<div style='border-bottom:1px solid;margin-bottom:25px'></div>";
        }
    }
    $ubicacion .= "<br>";

    //Mostrar trabajo
    $muestroPantalla = "";
    if($datos_carta_a_enviar["mostrar_trabajo"] === 1) {
        $muestroPantalla .= "<br>";
        $muestroPantalla .= "Trabajo Nº: ".$row["numero_tl"];
        $muestroPantalla .= "<br><br>";
        $muestroPantalla .= "<div align='center'>";
            $muestroPantalla .= "<span style='font-weight: bold;'>".$row["titulo_tl"]."</span><br><br>";
            //Autores
            $txt_autores = $trabajos_instancia->getTemplateAutores($row["id_trabajo"]);
            $muestroPantalla .= "<div style='font-size: 14px;'>";
                $muestroPantalla .= $txt_autores;
            $muestroPantalla .= "</div>";
            $muestroPantalla .= "<br>";
            //--Autores
            //Resumen
            $muestroPantalla .= "<div align='justify'>";
                $muestroPantalla .= "<strong>RESUMEN:</strong><br>";
                $muestroPantalla .= $row["resumen"];
            $muestroPantalla .= "</div><br>";
            //--Resumen
        $muestroPantalla .= '</div>';
    }

    //Comentarios evaluador
    $contador_evaluadores_que_comentaron = 0;
    $comentarios_evaluador = "";
    $evaluaciones = $trabajos_instancia->getEvaluacionesByNumeroTL($row["numero_tl"]);
    foreach($evaluaciones as $evaluacion){
        if ($evaluacion["comentarios"] != "") {
            $contador_evaluadores_que_comentaron++;
            if($comentarios_evaluador === ""){

                $comentarios_evaluador = "<br>A continuación, le detallamos las correcciones que deberá tener en cuenta:<br><br>Evaluador 1: <br>" . $evaluacion["comentarios"];
            } else {

                $comentarios_evaluador .= "<br><br>Evaluador " . $contador_evaluadores_que_comentaron . ": <br>" . $evaluacion["comentarios"];
            }
        }
    }

    //Autores tl
    $autoresTL = "";
    $presentador_trabajo = "";
    $autores_trabajo = $trabajos_instancia->getAutoresByTrabajoID($row["id_trabajo"]);
    foreach($autores_trabajo as $autor_trabajo){
        if ($autor_trabajo["lee"] == '1'){
            $presentador_trabajo = $autor_trabajo["Nombre"]." ".$autor_trabajo["Apellidos"];
        }
        $autoresTL .= $autor_trabajo["Nombre"]." ".$autor_trabajo["Apellidos"].", ";
    }
    $autoresTL = substr($autoresTL, 0, -2);

    //Archivo TL
    if($row["archivo_tl"]){
        $archivo_tl = "<a href='../../tl/".$row["archivo_tl"]."'>Descargue aquí el TRABAJO COMPLETO para su evaluación.</a>";
    } else {
        $archivo_tl = "";
    }

    $cuerpoMail = str_replace("<:dirBanner>", $config["banner_congreso"] , $cartaEstandar);
    $cuerpoMail = str_replace("<:congreso>", $config["nombre_congreso"] , $cuerpoMail);
    $cuerpoMail = str_replace("<:cuerpo>", utf8_decode(nl2br($cuerpo_mail)) , $cuerpoMail);
    $cuerpoMail = str_replace("<:ubicacion>", utf8_decode($ubicacion), $cuerpoMail);
    $cuerpoMail = str_replace("<:pantalla>", utf8_decode($muestroPantalla) , $cuerpoMail);
    $cuerpoMail = str_replace("<:numero_tl>", $row["numero_tl"] , $cuerpoMail);
    $cuerpoMail = str_replace("<:clave>", $row["clave"] , $cuerpoMail);
    $cuerpoMail = str_replace("<:nombreContacto>", $row["contacto_nombre"] , $cuerpoMail);
    $cuerpoMail = str_replace("<:apellidoContacto>", $row["contacto_apellido"] , $cuerpoMail);
    $cuerpoMail = str_replace("<:emailContacto>", $row["contacto_mail"] , $cuerpoMail);
    $cuerpoMail = str_replace("<:titulo_tl>", $row["titulo_tl"] , $cuerpoMail);
    $cuerpoMail = str_replace("<:autores_tl>", $autoresTL , $cuerpoMail);
    $cuerpoMail = str_replace("<:presentador_tl>", $presentador_trabajo , $cuerpoMail);
    $cuerpoMail = str_replace("<:tipo_tl>", $row["tipo_tl"] , $cuerpoMail);
    $cuerpoMail = str_replace("<:comentarios_evaluador>", $comentarios_evaluador , $cuerpoMail);
    $cuerpoMail = str_replace("<:link_trabajo_completo>", $archivo_tl, $cuerpoMail);
    $link_editar_trabajo = "<a href='".$config["url_opc"]."abstract/login.php?id=".base64_encode($id_trabajo)."'>".utf8_decode("aquí")."</a>";
    $cuerpoMail = str_replace("<:link_editar_trabajo_aqui>", $link_editar_trabajo, $cuerpoMail);

    $asunto_mail = utf8_decode($asunto);
    if($datos_carta_a_enviar["asunto_trabajo"]){
        $asunto_mail .= " [".$row["numero_tl"]."]";
    }
    if($datos_carta_a_enviar["asunto_nombre"]){
        $asunto_mail .= " [".$row["contacto_apellido"].", ".$row["contacto_nombre"]."]";
    }

    unset($arrayMails);
    $arrayMails = array();
    if($datos_carta_a_enviar["enviado_a_personas"] == 1){
        $arrayMails[] = $row["contacto_mail"];
    }
    if($datos_carta_a_enviar["destinatario_especifico"] == 1){
        $mails_especificos = explode(";", $datos_carta_a_enviar["destinatario_especifico_emails"]);
        foreach($mails_especificos as $mail_especifico){
            $arrayMails[] = trim($mail_especifico);
        }
    }
    $arrayMails[] = $config['email_respaldo'];
    $arrayMails = array_unique($arrayMails);

    $contador_mails_enviados++;

    $_SESSION["envio_mail"]["contactos_trabajos"]["trabajos"][] = array(
        "mails_a_enviar" => $arrayMails,
        "cuerpoMail" => $cuerpoMail,
        "asunto" => utf8_decode($asunto_mail),
        "trabajo_id" => $row["id_trabajo"],
        "contador_mail" => $contador_mails_enviados,
        "contacto_nombre" => $row["contacto_nombre"],
        "contacto_apellido" => $row["contacto_apellido"],
        "contacto_mail" => $row["contacto_mail"]
    );
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Contactos de Trabajos Libres - Envio de mail</title>
        <link rel="stylesheet" type="text/css" href="../../../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/envioMail.css"/>
    </head>
    <body>
        <div class="container">
            <div align="center">
                <div id="divEnvios" class="col-md-12" style="font-size: 16px; text-align: left;">

                </div>
                <iframe name="frameEnvio" style="display:none;"></iframe>
            </div>
            <form action="enviar.php" method="post" enctype="multipart/form-data" id="form1" name="form1" target="frameEnvio">
            </form>
        </div>
    </body>
    <script type="text/javascript" src="../../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#form1").submit();
        });
    </script>
</html>
