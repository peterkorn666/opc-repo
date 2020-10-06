<?PHP
require "inicializar.php";
controlarAcceso($sistema,2);
$presentacion->abrir("subscripto.php","../paginas/","Principal");

require "../clases/form_abm.php";
$mensajeError="";
$form_abm_subscripto= new form_abm_class();
$form_abm_subscripto->action="subscripto.php";
$form_abm_subscripto->objDatos=$sistema->crearSubscriptos();

$form_abm_subscripto->objDatos->asignarPropiedadVariable("Password","habilitada",false);
$form_abm_subscripto->objDatos->asignarPropiedadVariable("IdEstadoSuscripto","habilitada",false);
$form_abm_subscripto->objDatos->asignarPropiedadVariable("FechaHoraSolicitudAlta","habilitada",false);
$form_abm_subscripto->objDatos->asignarPropiedadVariable("IPSolicitudAlta","habilitada",false);
$form_abm_subscripto->objDatos->asignarPropiedadVariable("ClaveConfirmacionAlta","habilitada",false);
$form_abm_subscripto->objDatos->asignarPropiedadVariable("FechaHoraConfirmacionAlta","habilitada",false);
$form_abm_subscripto->objDatos->asignarPropiedadVariable("IPConfirmacionAlta","habilitada",false);
$form_abm_subscripto->objDatos->asignarPropiedadVariable("FechaHoraSolicitudBaja","habilitada",false);
$form_abm_subscripto->objDatos->asignarPropiedadVariable("IPSolicitudBaja","habilitada",false);
$form_abm_subscripto->objDatos->asignarPropiedadVariable("FechaHoraConfirmacionBaja","habilitada",false);
$form_abm_subscripto->objDatos->asignarPropiedadVariable("IPConfirmacionBaja","habilitada",false);
$form_abm_subscripto->objDatos->asignarPropiedadVariable("Comentarios","habilitada",false);
$form_abm_subscripto->objDatos->asignarPropiedadVariable("EnviosPendientes","habilitada",false);
$form_abm_subscripto->objDatos->asignarPropiedadVariable("EnviosHechos","habilitada",false);
$form_abm_subscripto->objDatos->asignarPropiedadVariable("EnviosRebotados","habilitada",false);


$form_abm_subscripto->script_OnLoad="eval('iniciar();');";
$form_abm_subscripto->funcion_posterior_alta="posteriorAlta";
$form_abm_subscripto->funcion_validar_alta="validarAlta";
$form_abm_subscripto->funcion_previa_edicion="previaEdicion";
$form_abm_subscripto->funcion_validar_edicion="validarEdicion";
$form_abm_subscripto->funcion_posterior_edicion="posteriorEdicion";
$form_abm_subscripto->leerDatos();

$form_abm_subscripto->redirect=false;

$form_abm_subscripto->procesar();

$form_abm_subscripto->asignarValoresVariables($presentacion);

$presentacion->asignarValor("FormBuscador","");
$presentacion->asignarValor("Resultado","");

$presentacion->asignarValor("Mensaje",$form_abm_subscripto->mensaje);

if ($form_abm_subscripto->mostrar==1) {
	$presentacion->parse("FormEdicion",false);
} else {
	$presentacion->asignarValor("FormEdicion","");
}

$form_abm_subscripto->mostrarEnPresentacion($presentacion);

$presentacion->mostrar();


function validarAlta() {
	global $sistema,$form_abm_subscripto;
	$form_abm_subscripto->objDatos->asignarValorVariable("EnviosPendientes",":");
	$form_abm_subscripto->objDatos->asignarValorVariable("EnviosHechos",":");
	$form_abm_subscripto->objDatos->asignarValorVariable("EnviosRebotados",":");

	$resultado=true;
	return $resultado;
}

function validarEdicion() {
	global $sistema,$form_abm_subscripto;
	//no son modificables por el usuario
	$form_abm_subscripto->objDatos->quitarVariable("EnviosHechos");	
	$form_abm_subscripto->objDatos->quitarVariable("EnviosRebotados");
	
	if($form_abm_subscripto->objDatos->darValorVariable("Activo")!=1) {
		$form_abm_subscripto->objDatos->asignarValorVariable("EnviosPendientes",":");
		$sql="DELETE FROM envios_subscriptos WHERE IdEstadoEnvio=1 AND Email='" . $mail . "'";
		$sistema->database->ejecutarSentenciaSQL($sql);
	} else {
		$form_abm_subscripto->objDatos->quitarVariable("EnviosPendientes");
	}
	
	$resultado=true;
	return $resultado;
}

function posteriorAlta() {
	global $sistema,$form_abm_subscripto;

	//da de alta a subscripto_datos_personales asociado a este subscripto
	$sdp=$sistema->crearSubscriptosDatosPersonales();
	$form_abm_subscripto->leerDatosVariables($sdp,"sdp_");
	$sdp->setIdSubscripto($form_abm_subscripto->objDatos->id);

	$sdp->insert();
	
	return true;
}

function previaEdicion() {
	global $sistema,$form_abm_subscripto,$presentacion;
	//busca subscripto_datos_personales asociado a este subscripto
	$sdp=$sistema->crearSubscriptosDatosPersonales();
	$sdp->select($form_abm_subscripto->objDatos->id);
	$form_abm_subscripto->asignarValoresVariables($presentacion,$sdp->variables,"sdp_") ;
}

function posteriorEdicion() {
	global $sistema,$form_abm_subscripto;

	//actualiza subscripto_datos_personales asociado a este subscripto
	$sdp=$sistema->crearSubscriptosDatosPersonales();
	$form_abm_subscripto->leerDatosVariables($sdp,"sdp_");
	$sdp->setIdSubscripto($form_abm_subscripto->objDatos->darValorVariable("IdSubscripto"));
	$sdp->id=$form_abm_subscripto->objDatos->darValorVariable("IdSubscripto");
	$sdp->update($sdp->id);

	return true;
}
?>