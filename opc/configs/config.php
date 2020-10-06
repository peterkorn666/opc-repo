<?php
header('Content-Type: text/html; charset=UTF-8');

$core = new core();
$getConfig = $core->getConfig();
//$getDias = $core->getDias();
$getEstadisticas = $core->getEstadisticas();

$url_base = "http://isa-ispid.gegamultimedios.net/";

$nombre_congreso = $getConfig["nombre_congreso"];
$mail_contacto = $getConfig["mail_contacto"];
$banner = $url_base."/img/banner.png";

$mail_congreso = "gegamultimedios@gmail.com";

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