<?PHP
$url_congreso = "http://fepal2020.programacientifico.info";
$ftp_url_config = "/fepal2020.programacientifico.info";

switch ($_SERVER["SERVER_NAME"]) {

	case "fepal2020.programacientifico.info":
   

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

$new_include_dir = DIR_ABSOLUTO;

if (function_exists("set_include_path")) {


	set_include_path(get_include_path() . ":" . $new_include_dir);
} else {
	ini_set("include_path",ini_get("include_path")  . ":" . $new_include_dir  );
}

define("ESTILOS",RAIZ_SITIO . "estilos.css");
define("SCRIPTS",RAIZ_SITIO . "scripts.js");
define("MOSTRAR_POPUP_ADMIN",false);
define("MOSTRAR_POPUP_USUARIOS",false);
define("PAGINA_LOGIN",RAIZ_SITIO . "sistema/login.php");
define("PAGINA_REGISTRO",RAIZ_SITIO . "registro.php");
define("PAGINA_CLAVE",RAIZ_SITIO . "cambiarClave.php");
define("PAGINA_NO_HABILITADO",RAIZ_SITIO . "noHabilitado.php");
define("PAGINA_OLVIDO_CLAVE",RAIZ_SITIO . "olvidoClave.php");

define("CHARSET","UTF-8");
define("CHARSET_BD","utf8");
define("CHARSET_MAIL","utf-8");

define("IDIOMA_POR_DEFECTO","es");
define("LARGO_GUID",16);

define("NOMBRE_SITIO","Difusión CCE");
define("LOGOTIPO","");

define("FROM_NOMBRE",NOMBRE_CONGRESO);
define("FROM_EMAIL",PHPMAILER_USERNAME);
define("REPLYTO_NOMBRE","Contacto - ".NOMBRE_CONGRESO);
define("REPLYTO_EMAIL",EMAIL_CONGRESO_RESPALDO);

define("MOSTRAR_UNSUBSCRIBE",true);

define("REEMPLAZO_BUSCAR_PREFIJO","%%..");
define("REEMPLAZO_BUSCAR_SUFIJO","..%%");
define("REEMPLAZO_VALORES","Nombre,Apellido,Pais,Ciudad,Direccion,CP,Telefono,Celular,Fax,Web,Idioma,Sexo,Edad,RangoEdad,Especialidad,Institucion,TipoInstitucion,Libre1,Libre2,Libre3,Libre4,Libre5");

define("MODO_PRUEBA",false);
?>