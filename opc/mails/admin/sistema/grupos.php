<?PHP
require "inicializar.php";
controlarAcceso($sistema,2);
$presentacion->abrir("grupos.php","../paginas/","Principal");

require "../clases/form_br.php";

$form_br_class1= new form_br_class();
$form_br_class1->action="grupos.php";
$form_br_class1->paginaRegistro="grupo.php";
$form_br_class1->tabla="grupos";
$form_br_class1->accionPorDefecto="buscar";
$form_br_class1->campoClave="IdGrupo";
$form_br_class1->conexion=$conexion;
$form_br_class1->mostrarForm=false;
$form_br_class1->mostrarResultado=true;
$form_br_class1->acctionPorDefecto="buscar";
$form_br_class1->funcion_fila_resultado="filaGrupo";
$form_br_class1->funcion_no_hay_registros="noHayRegistros";
$form_br_class1->objDatos=$sistema->crearGrupos();

$form_br_class1->leerDatos();

if (leerParametro("accion","")==""){ // llamada directa, carga valores de la session	
	session::cargarValoresVariables($form_br_class1->objDatos->variables,"listado_grupos". "_");
	$form_br_class1->o=session::darValor("listado_grupos" . "_" . "o");	
	if ($form_br_class1->o=="") {
		$form_br_class1->o=$form_br_class1->columnaOrdenPorDefecto;
	}
	$form_br_class1->od=session::darValor("listado_grupos" . "_" . "od");
	if ($form_br_class1->od=="") {
		$form_br_class1->od=$form_br_class1->direccionOrdenPorDefecto;
	}
} else { 
	if (leerParametro("accion","")=="limpiarBusquedaGuardada") { // pido limpiar sesion
		session::eliminarValoresVariables($form_br_class1->objDatos->variables,"listado_grupos". "_");
		foreach($form_br_class1->objDatos->variables as $v) {
			$v->valor=$v->valorPorDefecto;
		}
		$form_br_class1->o=$form_br_class1->columnaOrdenPorDefecto;
		$form_br_class1->od=$form_br_class1->direccionOrdenPorDefecto;
		$form_br_class1->accion=$form_br_class1->accionPorDefecto;
	} else { //datos nuevos, los guarda en la session
		session::asignarValoresVariables($form_br_class1->objDatos->variables,"listado_grupos" . "_");
		session::asignarValor("listado_grupos" . "_" . "o", $form_br_class1->o);
		session::asignarValor("listado_grupos" . "_" . "od", $form_br_class1->od);
	}
}

$form_br_class1->procesar();

$presentacion->definirSecciones();

$form_br_class1->mostrarEnPresentacion($presentacion);
$presentacion->mostrar();

function filaGrupo(&$presentacion,$rowgrupo,$numeroFila){
//print_r($rowgrupo);
	$presentacion->asignarValor("resultado_tipoFila",(($numeroFila + 1) % 2));
	$presentacion->asignarValor("resultado_scriptFila","onClick=\"return editar(" . $rowgrupo["grupos.IdGrupo"] . ");\"");
	$presentacion->asignarValor("resultado_Grupo",$rowgrupo["grupos.Grupo"]);
	$presentacion->asignarValor("resultado_IdGrupo",$rowgrupo["grupos.IdGrupo"]);
	$presentacion->parse("FilaResultado", true);
}

function noHayRegistros(&$presentacion){
	$presentacion->asignarValor("ArrayMasInfo","");
	$presentacion->asignarValor("PaginarResultado","");
	
}
?>