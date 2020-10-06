<?php



function conectarDB($servidor=SERVIDOR_LOGIN,$usuario=USUARIO_LOGIN,$password=PASSWORD_LOGIN,$base=BASE_LOGIN) {
  //Conexión prsistente al servidor mysql
  $conexion=mysqli_connect($servidor, $usuario, $password)
    or die ("Error al conectarse al servidor mysql");
  //Selección de la base de datos
  mysqli_select_db($base)
    or die ("Error al conectarse a la base de datos");
  return $conexion;
}


function ejecutarSentenciaSQL($sql, $conexion){
	$upd=mysqli_query($conexion, $sql);
	if (mysqli_error()!="") {
		$resultado=0;
	} else {
		$resultado=mysqli_affected_rows($conexion);
	}
	return $resultado;
}


function obtenerRecordset($sql, $conexion){
  return mysqli_query($conexion, $sql);
}



function fechaHoraBD() {
 return date('Y-m-d H:i:s');
}



?>