<?php
$url_congreso = "http://opc.tea2018.org";
$ftp_url_config = "/home/dh_tea2018/opc.tea2018.org";

switch ($_SERVER["SERVER_NAME"]) {
  case "www.gegamultimedios.net":
  case "opc.tea2018.org":

	define("RAIZ","/mails/admin/");
    define("RAIZ_SITIO","/mails/admin/");
    define("URL_ABSOLUTA",$url_congreso."/mails/admin/");
    define("DIR_ABSOLUTO",$ftp_url_config."/mails/admin/");

	define("DIR_ADJUNTOS",$ftp_url_config."/mails/adjuntos/");
	define("DIR_PLANTILLAS",$ftp_url_config."/mails/plantillas/");

	define("SERVIDOR_LOGIN","mysql.gegamultimedios.net");
	define("BASE_LOGIN","bd_tea2018_mails");
	define("USUARIO_LOGIN","tea2018");
	define("PASSWORD_LOGIN","gabrielatea");

	define("URL_SCRIPTS_TRACKING",$url_congreso."/mails/");
	define("ENVIOS_POR_VEZ",8);
	define("TIEMPO_ESPERA_ENTRE_MAILS",1);
	define("TIEMPO_REFRESH",45);	

	define("PHPMAILER_TIPO","smtp");
	define("PHPMAILER_HOST","mail.opc.tea2018.org");
	define("PHPMAILER_USERNAME","contacto@opc.tea2018.org");
	define("PHPMAILER_PASSWORD","aC5w#h66");
	
	define("NOMBRE_CONGRESO", "TEA 2018");
	define("EMAIL_CONGRESO_RESPALDO", "tea2018mvd@gmail.com");

	error_reporting  (E_ERROR );
  break;


}

include('4.2.php');

$new_include_dir = DIR_ABSOLUTO;
set_include_path(get_include_path() . ":" . $new_include_dir);



include('inc_bd.php');


include('inc_utiles.php');


include('inc_utilidades_generales.php');





$conexion=conectarDB();
$basedatos=BASE_LOGIN;

define("LARGO_GUID",16);

define("FROM_NOMBRE",NOMBRE_CONGRESO);
define("FROM_EMAIL",PHPMAILER_USERNAME);
define("REPLYTO_NOMBRE","Contacto - ".NOMBRE_CONGRESO);
define("REPLYTO_EMAIL",EMAIL_CONGRESO_RESPALDO);
define("REEMPLAZO_BUSCAR_PREFIJO","%%..");
define("REEMPLAZO_BUSCAR_SUFIJO","..%%");

?>