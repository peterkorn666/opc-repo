<?php

session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

date_default_timezone_set("America/Montevideo");
setlocale(LC_TIME, 'es_ES');

if(count($_SESSION["envio_mail"]["inscriptos"]["personas"]) == 0){

    unset($_SESSION["envio_mail"]["inscriptos"]);
    $div_fin = "<br><div style=\'text-align: center;\'>------------- El envio a finalizado correctamente -------------<br /><br /><a href=\'index.php\'>[ Volver al envio de e-mail para inscriptos]</a></div><br>";
    echo "<script>\n";
        echo "parent.document.getElementById('divEnvios').innerHTML += '".$div_fin."';\n";
    echo "</script>\n";
} else {

    echo "<script>\n";
        echo "setTimeout(function(){document.location.href = 'enviar.php'\n;},10000)";
    echo "</script>\n";

    $persona = array_shift($_SESSION["envio_mail"]["inscriptos"]["personas"]);

    require "../../../init.php";
    require "../clases/Cartas.php";
    require "../clases/smtp.class.php";
    require "../clases/phpmailer.class.php";

    $cartas_instancia = new Cartas();
    $config = $cartas_instancia->getConfig();

    $mailOBJ = new phpmailer();

    $mailOBJ->IsHTML(true);
    $mailOBJ->Timeout=120;
    $mailOBJ->ClearAttachments();
    $mailOBJ->ClearBCCs();
    $mailOBJ->From = $config["email_username"];
    $mailOBJ->FromName = $config["nombre_congreso"];
    $mailOBJ->Subject = $persona["asunto"];
    $mailOBJ->Body = $persona["cuerpoMail"];

    $mailOBJ->IsSMTP();
    $mailOBJ->SMTPDebug  = false;
    $mailOBJ->SMTPAuth   = true;
    $mailOBJ->SMTPAutoTLS = false;

    $mailOBJ->Host       = $config["email_host"];
    $mailOBJ->Username   = $config["email_username"];
    $mailOBJ->Password   = $config["email_password"];

    $mailOBJ->Port = 25;
    $mailOBJ->addReplyTo($config["email_congreso"], 'Contacto - ' . $config["nombre_congreso"]);

    $txt_a_devolver = "[".$persona["contador_mail"]." de ".$_SESSION["envio_mail"]["inscriptos"]["cantidad_a_enviar"]."] Se ha enviado el mail de ".$persona["persona_nombre"]." ".$persona["persona_apellido"]." (".$persona["persona_email"].") a ";
    $txt_error = "";

    foreach($persona["mails_a_enviar"] as $cualMail){
        if($_SESSION["envio_mail"]["inscriptos"]["adjunto"]){
            $mailOBJ->AddAttachment("../adjuntos/inscriptos/" . $_SESSION["envio_mail"]["inscriptos"]["adjunto"], $_SESSION["envio_mail"]["inscriptos"]["adjunto"]);
        }

        $mailOBJ->ClearAddresses();
        $mailOBJ->AddAddress($cualMail);
        if(!$mailOBJ->Send()){
            $txt_error .= "Ocurrió un error al enviar el mail a [".$cualMail."]<br>";
        } else {
            $txt_a_devolver .= "[".$cualMail."]";
            $campos_carta_enviada_personas = array(
                "carta_enviada_id" => $_SESSION["envio_mail"]["inscriptos"]["carta_enviada_id"],
                "inscripto_id" => $persona["inscripto_id"]
            );
            $cartas_instancia->insertCartaEnviadaPersonas($campos_carta_enviada_personas);
        }
    }
    $txt_a_devolver = $txt_a_devolver."<br>".$txt_error;
    echo "<script>\n";
        echo "parent.document.getElementById('divEnvios').innerHTML += '".$txt_a_devolver."'\n;";
    echo "</script>\n";
    //echo $txt_a_devolver."<br>".$txt_error;
}