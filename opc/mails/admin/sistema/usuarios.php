<?
require "inicializar.php";
controlarAcceso($sistema,3);
$presentacion->abrir("usuarios.php","../paginas/","Principal");

require "../clases/form_br.php";

$form_br_class1= new form_br_class();
$form_br_class1->action="usuarios.php";
$form_br_class1->paginaRegistro="usuario.php";
$form_br_class1->tabla="usuarios";
$form_br_class1->accionPorDefecto="buscar";
$form_br_class1->campoClave="Id";
$form_br_class1->conexion=$conexion;
$form_br_class1->mostrarForm=true;
$form_br_class1->mostrarResultado=true;
$form_br_class1->funcion_fila_resultado="filaUsuario";
$form_br_class1->funcion_no_hay_registros="noHayRegistros";
$form_br_class1->objDatos=$sistema->crearUsuarios();

$v=new Variable(1,$form_br_class1->tabla,"NombreApellido",3);
$v->campoHTML="nombre";
$v->labelTemplate="Nombre";
$v->campoSQL="CONCAT(Nombre,' ',Apellido)";
$v->expresionBuscar="CONCAT(Nombre,' ',Apellido)";
$v->expresionOrdenar="CONCAT(Nombre,' ',Apellido)";
$form_br_class1->objDatos->agregarVariable("NombreApellido",$v);

	
$form_br_class1->leerDatos();
if (leerParametro("accion","")==""){ // llamada directa, carga valores de la session	
	session::cargarValoresVariables($form_br_class1->objDatos->variables,"listado_usuarios". "_");
	$form_br_class1->o=session::darValor("listado_usuarios" . "_" . "o");	
	if ($form_br_class1->o=="") {
		$form_br_class1->o=$form_br_class1->columnaOrdenPorDefecto;
	}
	$form_br_class1->od=session::darValor("listado_usuarios" . "_" . "od");
	if ($form_br_class1->od=="") {
		$form_br_class1->od=$form_br_class1->direccionOrdenPorDefecto;
	}
} else { 
	if (leerParametro("accion","")=="limpiarBusquedaGuardada") { // pido limpiar sesion
		session::eliminarValoresVariables($form_br_class1->objDatos->variables,"listado_usuarios". "_");
		foreach($form_br_class1->objDatos->variables as $v) {
			$v->valor=$v->valorPorDefecto;
		}
		$form_br_class1->o=$form_br_class1->columnaOrdenPorDefecto;
		$form_br_class1->od=$form_br_class1->direccionOrdenPorDefecto;
		$form_br_class1->accion=$form_br_class1->accionPorDefecto;
	} else { //datos nuevos, los guarda en la session
		session::asignarValoresVariables($form_br_class1->objDatos->variables,"listado_usuarios" . "_");
		session::asignarValor("listado_usuarios" . "_" . "o", $form_br_class1->o);
		session::asignarValor("listado_usuarios" . "_" . "od", $form_br_class1->od);
	}
}

$form_br_class1->procesar();

$presentacion->definirSecciones();

$niveles="";
$niveles='<option value="">Cualquiera</option>';
$sqlNiveles= "SELECT DISTINCT Id, Nivel";
$sqlNiveles.= " FROM usuarios_niveles";

$sistema->database->obtenerRecordset($sqlNiveles);
$rs=new RS($sistema->database->rs);

$niveles.=cargarListBoxRS($rs,$form_br_class1->objDatos->darValorVariable("IdNivel"));

$presentacion->asignarValor("Niveles",$niveles);

$estados="";
$estados='<option value="">Cualquiera</option>';
$sqlEstados= "SELECT DISTINCT Id, Estado";
$sqlEstados.= " FROM usuarios_estados";

$sistema->database->obtenerRecordset($sqlEstados);
$estados.=cargarListBoxRS(new RS($sistema->database->rs),$form_br_class1->objDatos->darValorVariable("IdEstadoUsuario"));

$presentacion->asignarValor("Estados",$estados);
	
$form_br_class1->mostrarEnPresentacion($presentacion);

$presentacion->mostrar();

function filaUsuario(&$presentacion,$rowUsuario,$numeroFila){
	$presentacion->asignarValor("Id",$rowUsuario["usuarios.Id"]);
	$presentacion->asignarValor("resultado_Usuario",$rowUsuario["usuarios.Usuario"]);
	$presentacion->asignarValor("resultado_Nombre",$rowUsuario["usuarios.NombreApellido"]);
	$presentacion->asignarValor("resultado_Nivel",$rowUsuario["Nivel"]);
	$presentacion->asignarValor("resultado_Estado",$rowUsuario["Estado"]);
	$presentacion->parse("FilaResultado", true);
}

function noHayRegistros(&$presentacion){
	$presentacion->asignarValor("ArrayMasInfo","");
	$presentacion->asignarValor("PaginarResultado","");	
}
?>