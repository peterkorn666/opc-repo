<?PHP
//COMPATIBILIDAD PHP 4.2
require_once('../inc/4.2.php');

//CONFIGURACION GENERAL
require_once('../inc/inc_config.php');

//INICIALIZACION BD
require_once('inicializar_bd.php');

//PRESENTACION
require_once('../clases/presentacion.php');

// UTILIDADES GENERALES
require_once('../inc/inc_utilidades_generales.php');

//CONSTANTES
require_once("constantes.inc.php");

//SISTEMA
require_once('sistema.php');


//ARRANQUE SESION Y CONTROL DE ACCESO
session_start();
header("Cache-control: private"); //IE 6 Fix

$idioma=leerParametro("Idioma",isset($_SESSION['s_Idioma'])?$_SESSION['s_Idioma']:"");
if ($idioma=="") {
	$idioma=IDIOMA_POR_DEFECTO;
}
$_SESSION['s_Idioma']=$idioma;

$sistema=new sistema($conexion,$idioma);

$presentacion=new presentacion();

function controlarAcceso($sistema,$permiso,$login=PAGINA_LOGIN) {
  $qs="";
  if (isset($_SERVER['QUERY_STRING'])) {
      $qs="?" . $_SERVER['QUERY_STRING'];
  }
  if ($permiso!="") {
    if (!$sistema->esUsuarioValido($permiso)){
      header("Location: " . $login . "?paginaSolicitada=" . urlencode($_SERVER['PHP_SELF'] . $qs));
    }
  }
}

?>