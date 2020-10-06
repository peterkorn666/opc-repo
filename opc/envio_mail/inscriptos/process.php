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

if(!empty($_POST["asunto_numero_inscripto"])){
    $datos_carta_a_enviar["asunto_numero_inscripto"] = 1;
}
if(!empty($_POST["asunto_nombre"])){
    $datos_carta_a_enviar["asunto_nombre"] = 1;
}
if($_FILES['adjunto']['error'] == UPLOAD_ERR_OK){
    $datos_carta_a_enviar["adjunto"] = $_FILES['adjunto']["name"];
    if($_FILES["adjunto"]["tmp_name"] != ""){
        copy($_FILES["adjunto"]["tmp_name"], "../adjuntos/inscriptos/" . $_FILES["adjunto"]["name"]);
    } else {
        header("Location: index.php?error=true");
        die();
    }
}

session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

date_default_timezone_set("America/Montevideo");
setlocale(LC_TIME, 'es_ES');

require "../../../init.php";
require "../clases/Cartas.php";
require "../clases/Auxiliar.php";
require "../clases/Inscripto.php";
require "config.php";

$cartas_instancia = new Cartas();
$auxiliar_instancia = new Auxiliar();
$inscripto_instancia = new Inscripto();

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

unset($_SESSION["envio_mail"]["inscriptos"]);
$_SESSION["envio_mail"]["inscriptos"]["carta_enviada_id"] = $id_carta_enviada;
$_SESSION["envio_mail"]["inscriptos"]["cantidad_a_enviar"] = $cantidad_a_enviar;
$_SESSION["envio_mail"]["inscriptos"]["adjunto"] = $datos_carta_a_enviar["adjunto"];
$_SESSION["envio_mail"]["inscriptos"]["personas"] = array();

$contador_mails_enviados = 0;
foreach($ids_personas as $id_inscripto){

    $row = $inscripto_instancia->getInscriptoByID($id_inscripto);
    $pais_inscripto = $auxiliar_instancia->getPaisByID($row["pais"]);

    $cuerpoMail = str_replace("<:dirBanner>", $config["banner_congreso"], $cartaEstandar);
    $cuerpoMail = str_replace("<:congreso>", utf8_decode($config["nombre_congreso"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:cuerpo>", utf8_decode(nl2br($cuerpo_mail)), $cuerpoMail);
    $cuerpoMail = str_replace("<:nombre>", utf8_decode($row["nombre"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:apellido>", utf8_decode($row["apellido"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:pais>", utf8_decode($pais_inscripto["Pais"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:institucion>", utf8_decode($row["institucion"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:pasaporte>", $row["numero_pasaporte"], $cuerpoMail);
    $cuerpoMail = str_replace("<:email>", $row["email"], $cuerpoMail);

    $asunto_mail = utf8_decode($asunto);
    if($datos_carta_a_enviar["asunto_numero_inscripto"]){
        $asunto_mail .= " [".str_pad($row["id"], 4, 0, STR_PAD_LEFT)."]";
    }
    if($datos_carta_a_enviar["asunto_nombre"]){
        $asunto_mail .= " [".utf8_decode($row["apellido"]).", ".utf8_decode($row["nombre"])."]";
    }

    unset($arrayMails);
    $arrayMails = array();
    if($datos_carta_a_enviar["enviado_a_personas"] == 1){
        $arrayMails[] = $row["email"];
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

    $_SESSION["envio_mail"]["inscriptos"]["personas"][] = array(
        "mails_a_enviar" => $arrayMails,
        "cuerpoMail" => $cuerpoMail,
        "asunto" => $asunto_mail,
        "inscripto_id" => $row["id"],
        "contador_mail" => $contador_mails_enviados,
        "persona_nombre" => $row["nombre"],
        "persona_apellido" => $row["apellido"],
        "persona_email" => $row["email"]
    );
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Inscriptos - Envio de mail</title>
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
