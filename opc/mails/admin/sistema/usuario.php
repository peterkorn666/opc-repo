<?
require "inicializar.php";
controlarAcceso($sistema,3);
$presentacion->abrir("usuario.php","../paginas/","Principal");

require "../clases/form_abm.php";
$mensajeError="";
$form_abm_usuario= new form_abm_class();
$form_abm_usuario->action="usuario.php";
$form_abm_usuario->objDatos=$sistema->crearUsuarios();
$form_abm_usuario->script_OnLoad="eval('iniciar();');";
$form_abm_usuario->funcion_validar_alta="validarContrasenas";
$form_abm_usuario->funcion_validar_edicion="validarContrasenas";
$form_abm_usuario->leerDatos();

$form_abm_usuario->redirect=false;

$form_abm_usuario->procesar();


	$niveles="";
	//$niveles='<option value="">Cualquiera</option>';
	$sqlNiveles= "SELECT DISTINCT Id, Nivel";
	$sqlNiveles.= " FROM usuarios_niveles";

	$sistema->database->obtenerRecordset($sqlNiveles);
	$rs=new RS($sistema->database->rs);
	
	$niveles.=cargarListBoxRS($rs,$form_abm_usuario->objDatos->darValorVariable("IdNivel"));
	
	$presentacion->asignarValor("Niveles",$niveles);

	$estados="";
	//$estados='<option value="">Cualquiera</option>';
	$sqlEstados= "SELECT DISTINCT Id, Estado";
	$sqlEstados.= " FROM usuarios_estados";

	$sistema->database->obtenerRecordset($sqlEstados);
	$estados.=cargarListBoxRS(new RS($sistema->database->rs),$form_abm_usuario->objDatos->darValorVariable("IdEstadoUsuario"));
	
	$presentacion->asignarValor("Estados",$estados);

$form_abm_usuario->asignarValoresVariables($presentacion);

$presentacion->asignarValor("FormBuscador","");
$presentacion->asignarValor("Resultado","");

$presentacion->asignarValor("Mensaje",$form_abm_usuario->mensaje);

if ($form_abm_usuario->mostrar==1) {
	$presentacion->parse("FormEdicion",false);
} else {
	$presentacion->asignarValor("FormEdicion","");
}

$form_abm_usuario->mostrarEnPresentacion($presentacion);

$presentacion->mostrar();

          
function validarContrasenas() {
	global $form_abm_usuario;
	$resultado=true;
	$clave1=leerParametro("Clave1","");
	$clave2=leerParametro("Clave2","");

	$ahora=BD::fechaHoraBD();

	if ($clave1==$clave2) {
		$resultado=true;
	} else {
		$form_abm_usuario->mensaje.="Las contraseñas deben coincidir";
		$resultado=false;
	}	

	if ($resultado && $form_abm_usuario->accion=="altaAceptar") {
		if ($clave1 . $clave2!="") {
			$resultado=true;
			$form_abm_usuario->asignarValorVariable("Clave",$clave1);
			$form_abm_usuario->asignarValorVariable("Creacion",$ahora);
			$form_abm_usuario->asignarValorVariable("Actualizacion",$ahora);
		} else {
			$form_abm_usuario->mensaje.="Las contraseñas no pueden quedar vacías";
			$resultado=false;
		}
	}

	if ($resultado && $form_abm_usuario->accion=="editarAceptar") {
		if ($clave1!="") {
			$form_abm_usuario->asignarValorVariable("Clave",$clave1);
		} else {
			$form_abm_usuario->objDatos->quitarVariable("Clave");
		}
		$form_abm_usuario->objDatos->asignarValorVariable("Actualizacion",$ahora);
	}	
	
	
	
    return $resultado;
}



?>