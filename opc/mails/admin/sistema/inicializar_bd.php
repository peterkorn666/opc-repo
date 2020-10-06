<?PHP
//REQUIERE CONFIGURACION GENERAL
require_once('../inc/inc_config.php');

//INICIALIZACION BD

// CODIGO PARA ACCESO A LA BASE DE DATOS
require_once('../inc/inc_funciones_datos.php');
require_once('../clases/bd.php');

$basedatos=BASE_LOGIN;

//conexión a la base de datos
$conexion=new BD(SERVIDOR_LOGIN,USUARIO_LOGIN,PASSWORD_LOGIN);
$conexion->conectar();
if ($conexion->errornum==0) {
	$conexion->seleccionar($basedatos);
	if ($conexion->errornum==0) {
		// todo bien
	} else {
		echo "error " . $conexion->error;
		exit();
	}
} else {
	echo "error " . $conexion->error;
	exit();
}


?>