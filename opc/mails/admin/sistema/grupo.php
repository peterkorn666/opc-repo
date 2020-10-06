<?PHP
require "inicializar.php";
controlarAcceso($sistema,2);
$presentacion->abrir("grupo.php","../paginas/","Principal");

require "../clases/form_abm.php";
$mensajeError="";
$form_abm_grupo= new form_abm_class();
$form_abm_grupo->action="grupo.php";
$form_abm_grupo->objDatos=$sistema->crearGrupos();
$form_abm_grupo->script_OnLoad="eval('iniciar();');";
$form_abm_grupo->funcion_posterior_alta="posteriorAlta";
$form_abm_grupo->funcion_validar_alta="validarAlta";
$form_abm_grupo->funcion_validar_edicion="validarEdicion";
$form_abm_grupo->funcion_posterior_edicion="posteriorEdicion";
$form_abm_grupo->leerDatos();

$form_abm_grupo->redirect=false;

$form_abm_grupo->procesar();

$form_abm_grupo->asignarValoresVariables($presentacion);

$presentacion->asignarValor("FormBuscador","");
$presentacion->asignarValor("Resultado","");

$presentacion->asignarValor("Mensaje",$form_abm_grupo->mensaje);

if ($form_abm_grupo->mostrar==1) {
	$presentacion->parse("FormEdicion",false);
} else {
	$presentacion->asignarValor("FormEdicion","");
}

$form_abm_grupo->mostrarEnPresentacion($presentacion);

$presentacion->mostrar();


function validarAlta() {
	global $sistema,$form_abm_grupo;
	$resultado=true;
	return $resultado;
}

function validarEdicion() {
	global $sistema,$form_abm_grupo;
	
	$resultado=true;

	return $resultado;
}

function posteriorAlta() {
	global $sistema,$form_abm_grupo;
	return true;
}

function posteriorEdicion() {
	global $sistema,$form_abm_grupo;


	$resultado=true;

	return $resultado;
}


?>