<?PHP
require "inicializar.php";
controlarAcceso($sistema,2);
$presentacion->abrir("subscriptos.php","../paginas/","Principal");

require "../clases/form_br.php";

$form_br_class1= new form_br_class();
$form_br_class1->action="subscriptos.php";
$form_br_class1->paginaRegistro="subscripto.php";
$form_br_class1->tabla="subscriptos";
$form_br_class1->accionPorDefecto="buscar";
$form_br_class1->campoClave="IdSubscripto";
$form_br_class1->conexion=$conexion;
$form_br_class1->mostrarForm=true;
$form_br_class1->mostrarResultado=true;
$form_br_class1->acctionPorDefecto="buscar";
$form_br_class1->funcion_fila_resultado="filaSubscripto";
$form_br_class1->funcion_no_hay_registros="noHayRegistros";
$form_br_class1->objDatos=$sistema->crearSubscriptos();

$form_br_class1->leerDatos();

if (leerParametro("accion","")==""){ // llamada directa, carga valores de la session	
	session::cargarValoresVariables($form_br_class1->objDatos->variables,"listado_subscriptos". "_");
	$form_br_class1->o=session::darValor("listado_subscriptos" . "_" . "o");	
	if ($form_br_class1->o=="") {
		$form_br_class1->o=$form_br_class1->columnaOrdenPorDefecto;
	}
	$form_br_class1->od=session::darValor("listado_subscriptos" . "_" . "od");
	if ($form_br_class1->od=="") {
		$form_br_class1->od=$form_br_class1->direccionOrdenPorDefecto;
	}
} else { 
	if (leerParametro("accion","")=="limpiarBusquedaGuardada") { // pido limpiar sesion
		session::eliminarValoresVariables($form_br_class1->objDatos->variables,"listado_subscriptos". "_");
		foreach($form_br_class1->objDatos->variables as $v) {
			$v->valor=$v->valorPorDefecto;
		}
		$form_br_class1->o=$form_br_class1->columnaOrdenPorDefecto;
		$form_br_class1->od=$form_br_class1->direccionOrdenPorDefecto;
		$form_br_class1->accion=$form_br_class1->accionPorDefecto;
	} else { //datos nuevos, los guarda en la session
		session::asignarValoresVariables($form_br_class1->objDatos->variables,"listado_subscriptos" . "_");
		session::asignarValor("listado_subscriptos" . "_" . "o", $form_br_class1->o);
		session::asignarValor("listado_subscriptos" . "_" . "od", $form_br_class1->od);
	}
}

$form_br_class1->procesar();

$presentacion->definirSecciones();

$form_br_class1->mostrarEnPresentacion($presentacion);
$presentacion->mostrar();

function filaSubscripto(&$presentacion,$rowsubscripto,$numeroFila){
//print_r($rowsubscripto);
	$arrUbicaciones=array();
	$arrClasificaciones=array();
	$presentacion->asignarValor("resultado_tipoFila",(($numeroFila + 1) % 2));
	$presentacion->asignarValor("resultado_scriptFila","onClick=\"return editar(" . $rowsubscripto["subscriptos.IdSubscripto"] . ");\"");
	$presentacion->asignarValor("resultado_Email",$rowsubscripto["subscriptos.Email"]);
	$presentacion->asignarValor("resultado_IdSubscripto",$rowsubscripto["subscriptos.IdSubscripto"]);
	$presentacion->asignarValor("resultado_Activo",((abs($rowsubscripto["subscriptos.Activo"])==1)?"si":"no"));
	$presentacion->parse("FilaResultado", true);
}

function noHayRegistros(&$presentacion){
	$presentacion->asignarValor("ArrayMasInfo","");
	$presentacion->asignarValor("PaginarResultado","");
	
}
?>