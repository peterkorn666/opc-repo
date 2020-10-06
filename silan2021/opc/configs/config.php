<?php
header('Content-Type: text/html; charset=UTF-8');

$core = new core();
$getConfig = $core->getConfig();
$getEstadisticas = $core->getEstadisticas();

$url_base = "http://silan2020.gegamultimedios.net/opc/";

$nombre_congreso = $getConfig["nombre_congreso"];
$mail_contacto = $getConfig["mail_contacto"];
$banner = $url_base."/img/banner.png";

$mail_congreso = "silan2020montevideo@gmail.com";

$pagina_web = $url_base."/programa";
$programa_online = $url_base."/programa/";
$pagina_abstract = $url_base."/programa/abstract/";
$alojamiento = "";
$consulta = $url_base."/consulta";
$tieneBanner = true;
$rutaBanner = $url_base."/banner_eng.jpg";

//Abstract
$nombre_abstract = "RESUMEN";

$mails_congreso = array("gegamultimedios@gmail.com");

?>