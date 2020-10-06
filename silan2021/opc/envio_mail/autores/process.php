<?php
if(empty($_POST["carta_a_enviar"]) || (empty($_POST["enviar_a_destinatario_especifico"]) && empty($_POST["enviar_a_personas"])) || empty($_POST["personas"])){
    header("Location: index.php?error=true");
    die();
}
$datos_carta_a_enviar = array();
$carta_a_enviar = $_POST["carta_a_enviar"];
$enviar_a_destinatario_especifico = $_POST["enviar_a_destinatario_especifico"];
$enviar_a_personas = $_POST["enviar_a_personas"];
$ids_personas = $_POST["personas"];

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
if($enviar_a_personas == '1'){
    $datos_carta_a_enviar["enviado_a_personas"] = 1;
}

if(!empty($_POST["asunto_nombre"])){
    $datos_carta_a_enviar["asunto_nombre"] = 1;
}
if($_FILES['adjunto']['error'] == UPLOAD_ERR_OK){
    $datos_carta_a_enviar["adjunto"] = $_FILES['adjunto']["name"];
    if($_FILES["adjunto"]["tmp_name"] != ""){
        copy($_FILES["adjunto"]["tmp_name"], "../adjuntos/autores/" . $_FILES["adjunto"]["name"]);
    } else {
        header("Location: index.php?error=true");
        die();
    }
}

session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

require "../../../init.php";
require "../clases/Cartas.php";
require "../clases/Auxiliar.php";
require "../clases/Trabajo.php";
require "../clases/Autor.php";
require "config.php";

$cartas_instancia = new Cartas();
$auxiliar_instancia = new Auxiliar();
$trabajos_instancia = new Trabajo();
$autores_instancia = new Autor();

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
$a_cambiar = array("•", "”", "′");
$nuevos = array("&bull;", "&Prime;", "&prime;");
$cuerpo_mail = str_replace($a_cambiar, $nuevos, $cuerpo_mail);

$result = $cartas_instancia->insertCartaEnviada($datos_carta_a_enviar);
if($result){
    $id_carta_enviada = $result;
} else {
    header("Location: index.php?error=true");
    die();
}

$cantidad_a_enviar = count($ids_personas);

unset($_SESSION["envio_mail"]["autores_trabajos_libres"]);
$_SESSION["envio_mail"]["autores_trabajos_libres"]["carta_enviada_id"] = $id_carta_enviada;
$_SESSION["envio_mail"]["autores_trabajos_libres"]["cantidad_a_enviar"] = $cantidad_a_enviar;
$_SESSION["envio_mail"]["autores_trabajos_libres"]["adjunto"] = $datos_carta_a_enviar["adjunto"];
$_SESSION["envio_mail"]["autores_trabajos_libres"]["personas"] = array();

$contador_mails_enviados = 0;
foreach($ids_personas as $id_autor){

    $row = $autores_instancia->getAutorByID($id_autor);
    $pais_autor = $auxiliar_instancia->getPaisByID($row["Pais"]);
    $institucion_autor = $auxiliar_instancia->getInstitucionByID($row["Institucion"]);
    $rowTrabajo = $autores_instancia->getTrabajoByAutorID($id_autor);

    //Autores tl
    $autoresTL = "";
    $autores_trabajo = $trabajos_instancia->getAutoresByTrabajoID($rowTrabajo["id_trabajo"]);
    foreach($autores_trabajo as $autor_trabajo){
        $autoresTL .= utf8_decode($autor_trabajo["Nombre"])." ".utf8_decode($autor_trabajo["Apellidos"]).", ";
    }
    $autoresTL = substr($autoresTL, 0, -2);

    //Archivo TL
    if($rowTrabajo["archivo_tl"]){
        $archivo_tl = "<a href='../../tl/".$rowTrabajo["archivo_tl"]."'>Descargue aquí el TRABAJO COMPLETO.</a>";
    } else {
        $archivo_tl = "";
    }

    $cuerpoMail = str_replace("<:dirBanner>", $config["banner_congreso"], $cartaEstandar);
    $cuerpoMail = str_replace("<:congreso>", utf8_decode($config["nombre_congreso"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:cuerpo>", utf8_decode(nl2br($cuerpo_mail)), $cuerpoMail);
    $cuerpoMail = str_replace("<:numero_tl>", $rowTrabajo["numero_tl"], $cuerpoMail);
    $cuerpoMail = str_replace("<:titulo_tl>", utf8_decode($rowTrabajo["titulo_tl"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:autores_tl>", $autoresTL, $cuerpoMail);
    $cuerpoMail = str_replace("<:link_trabajo_completo>", $archivo_tl, $cuerpoMail);
    $cuerpoMail = str_replace("<:profesion>", utf8_decode($row["Profesion"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:nombre>", utf8_decode($row["Nombre"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:apellidos>", utf8_decode($row["Apellidos"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:pais>", utf8_decode($pais_autor["Pais"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:institucion>", utf8_decode($institucion_autor["Institucion"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:email>", $row["Mail"], $cuerpoMail);

    $asunto_mail = utf8_decode($asunto);
    if($datos_carta_a_enviar["asunto_nombre"]){
        $asunto_mail .= " [".utf8_decode($row["Apellidos"]).", ".utf8_decode($row["Nombre"])."]";
    }

    unset($arrayMails);
    $arrayMails = array();
    if($datos_carta_a_enviar["enviado_a_personas"] == 1){
        $arrayMails[] = $row["Mail"];
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

    $_SESSION["envio_mail"]["autores_trabajos_libres"]["personas"][] = array(
        "mails_a_enviar" => $arrayMails,
        "cuerpoMail" => $cuerpoMail,
        "asunto" => $asunto_mail,
        "autor_id" => $row["ID_Personas"],
        "contador_mail" => $contador_mails_enviados,
        "persona_nombre" => $row["Nombre"],
        "persona_apellido" => $row["Apellidos"],
        "persona_email" => $row["Mail"]
    );
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Autores de Trabajos Libres - Envio de mail</title>
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
