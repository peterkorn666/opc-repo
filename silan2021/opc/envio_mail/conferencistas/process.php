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
        copy($_FILES["adjunto"]["tmp_name"], "../adjuntos/conferencistas/" . $_FILES["adjunto"]["name"]);
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
require "../clases/Conferencista.php";
require "config.php";

$cartas_instancia = new Cartas();
$auxiliar_instancia = new Auxiliar();
$conferencista_instancia = new Conferencista();

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

unset($_SESSION["envio_mail"]["conferencistas"]);
$_SESSION["envio_mail"]["conferencistas"]["carta_enviada_id"] = $id_carta_enviada;
$_SESSION["envio_mail"]["conferencistas"]["cantidad_a_enviar"] = $cantidad_a_enviar;
$_SESSION["envio_mail"]["conferencistas"]["adjunto"] = $datos_carta_a_enviar["adjunto"];
$_SESSION["envio_mail"]["conferencistas"]["personas"] = array();

$contador_mails_enviados = 0;
foreach($ids_personas as $id_conf){

    $row = $conferencista_instancia->getConferencistaByID($id_conf);
    $pais_conf = $auxiliar_instancia->getPaisByID($row["pais"]);
    $institucion_conf = $auxiliar_instancia->getInstitucionByID($row["institucion"]);

    //Participaciones
    $participaciones = "";
    $infoCrono = $conferencista_instancia->getCronoByConfID($row["id_conf"]);
    if(count($infoCrono) > 0){
        $helper = 0;
        $dia_ = "";
        $sala_ = "";
        $participaciones = '<div style="font-family: Candara, Calibri, Segoe, Segoe UI, Optima, Verdana, Arial, Helvetica, sans-serif; font-size: 16px;">';
        foreach($infoCrono as $crono){
            $participaciones .= $conferencista_instancia->programaExtendidoMail($crono, $dia_, $sala_, $helper);

            $dia_ = substr($crono["start_date"], 0, 10);
            $sala_ = $crono['section_id'];
            $helper++;
        }
        $participaciones .= '</div>';
    }

    //Link conferencista
    $link_conferencista_aqui = "<a href='".$config["url_opc"]."?page=conferencistasManager&key=".base64_encode($row["id_conf"])."'>aquí</a>";

    //Certificado
    $link_certificado = "";
    //$link_certificado = "<a href='".$config["url_opc"]."?page=conferencistasCertificado&key=".md5($row["id_conf"])."'>a este link</a>";

    $cuerpoMail = str_replace("<:dirBanner>", $config["banner_congreso"], $cartaEstandar);
    $cuerpoMail = str_replace("<:congreso>", utf8_decode($config["nombre_congreso"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:cuerpo>", utf8_decode(nl2br($cuerpo_mail)), $cuerpoMail);
    $cuerpoMail = str_replace("<:profesion>", utf8_decode($row["profesion"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:nombre>", utf8_decode($row["nombre"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:apellido>", utf8_decode($row["apellido"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:pais>", utf8_decode($pais_conf["Pais"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:institucion>", utf8_decode($institucion_conf["Institucion"]), $cuerpoMail);
    $cuerpoMail = str_replace("<:email>", $row["email"], $cuerpoMail);
    $cuerpoMail = str_replace("<:participaciones>", $participaciones, $cuerpoMail);
    $cuerpoMail = str_replace("<:link_conferencista_aqui>", utf8_decode($link_conferencista_aqui), $cuerpoMail);
    $cuerpoMail = str_replace("<:link_certificado>", $link_certificado, $cuerpoMail);

    $asunto_mail = utf8_decode($asunto);
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

    $_SESSION["envio_mail"]["conferencistas"]["personas"][] = array(
        "mails_a_enviar" => $arrayMails,
        "cuerpoMail" => $cuerpoMail,
        "asunto" => $asunto_mail,
        "conferencista_id" => $row["id_conf"],
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
        <title>Conferencistas - Envio de mail</title>
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
