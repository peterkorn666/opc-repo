<?PHP
require "inicializar.php";
controlarAcceso($sistema,2);
$presentacion->abrir("mails.php","../paginas/","Principal");

require "../clases/form_br.php";

$form_br_class1= new form_br_class();
$form_br_class1->action="mails.php";
$form_br_class1->paginaRegistro="mail.php";
$form_br_class1->tabla="mails";
$form_br_class1->accionPorDefecto="buscar";
$form_br_class1->campoClave="IdMail";
$form_br_class1->conexion=$conexion;
$form_br_class1->mostrarForm=true;
$form_br_class1->mostrarResultado=true;
$form_br_class1->acctionPorDefecto="buscar";
$form_br_class1->funcion_fila_resultado="filaMail";
$form_br_class1->funcion_no_hay_registros="noHayRegistros";

$form_br_class1->columnaOrdenPorDefecto="IdMail";
$form_br_class1->direccionOrdenPorDefecto=2;

$form_br_class1->objDatos=$sistema->crearMails();

$form_br_class1->objDatos->agregarRelacion(new BD_relacion("INNER","envios","mails.IdMail=envios.IdMail"));
$form_br_class1->objDatos->agregarRelacion(new BD_relacion("INNER","estadisticas_envios","envios.IdEnvio=estadisticas_envios.IdEnvio"));

$v=new Variable(2,"estadisticas_envios","EnviosTotales",1);
$form_br_class1->objDatos->agregarVariable2($v,"EnviosTotales");

$v=new Variable(2,"estadisticas_envios","Pendientes",1);
$form_br_class1->objDatos->agregarVariable2($v,"Pendientes");

$v=new Variable(2,"estadisticas_envios","Enviados",1);
$form_br_class1->objDatos->agregarVariable2($v,"Enviados");

$form_br_class1->leerDatos();

if (leerParametro("accion","")==""){ // llamada directa, carga valores de la session	
	session::cargarValoresVariables($form_br_class1->objDatos->variables,"listado_mails". "_");
	$form_br_class1->o=session::darValor("listado_mails" . "_" . "o");	
	if ($form_br_class1->o=="") {
		$form_br_class1->o=$form_br_class1->columnaOrdenPorDefecto;
	}
	$form_br_class1->od=session::darValor("listado_mails" . "_" . "od");
	if ($form_br_class1->od=="") {
		$form_br_class1->od=$form_br_class1->direccionOrdenPorDefecto;
	}
} else { 
	if (leerParametro("accion","")=="limpiarBusquedaGuardada") { // pido limpiar sesion
		session::eliminarValoresVariables($form_br_class1->objDatos->variables,"listado_mails". "_");
		foreach($form_br_class1->objDatos->variables as $v) {
			$v->valor=$v->valorPorDefecto;
		}
		$form_br_class1->o=$form_br_class1->columnaOrdenPorDefecto;
		$form_br_class1->od=$form_br_class1->direccionOrdenPorDefecto;
		$form_br_class1->accion=$form_br_class1->accionPorDefecto;
	} else { //datos nuevos, los guarda en la session
		session::asignarValoresVariables($form_br_class1->objDatos->variables,"listado_mails" . "_");
		session::asignarValor("listado_mails" . "_" . "o", $form_br_class1->o);
		session::asignarValor("listado_mails" . "_" . "od", $form_br_class1->od);
	}
}

// quita del buscador estas variables porque tienen valor por defecto cargado
$form_br_class1->objDatos->asignarPropiedadVariable("Prioridad","buscar",false);
$form_br_class1->objDatos->asignarPropiedadVariable("Importancia","buscar",false);

$form_br_class1->procesar();

$presentacion->definirSecciones();

$form_br_class1->mostrarEnPresentacion($presentacion);//aca

$presentacion->mostrar();

function filaMail(&$presentacion,$rowmail,$numeroFila){
//print_r($rowmail);
	$arrUbicaciones=array();
	$arrClasificaciones=array();
	$presentacion->asignarValor("resultado_tipoFila",(($numeroFila + 1) % 2));
	$presentacion->asignarValor("resultado_scriptFila","onClick=\"return editar(" . $rowmail["mails.IdMail"] . ");\"");
	$presentacion->asignarValor("resultado_IdMail",$rowmail["mails.IdMail"]);
	$presentacion->asignarValor("resultado_Asunto",$rowmail["mails.Asunto"]);
	$presentacion->asignarValor("resultado_Comentarios",$rowmail["mails.Comentarios"]);
	$presentacion->asignarValor("resultado_VerMail","<a target='_blank' href='ver_mail.php?idMail=" . $rowmail["mails.IdMail"] . "' onclick='event.cancelBubble=true;return true;'>ver</a>");

	$presentacion->asignarValor("resultado_EnviosTotales",$rowmail["estadisticas_envios.EnviosTotales"]);
	
	if ($rowmail["estadisticas_envios.Pendientes"]>0) {
		$presentacion->asignarValor("resultado_Pendientes",'<a href="bandejaDeSalida.php?accion=buscar&IdEnvio='.$rowmail["mails.IdMail"].'&incluidoEnvio=pendiente&IdGrupo=0" onclick="event.cancelBubble=true;return true;">' . $rowmail["estadisticas_envios.Pendientes"] . '</a>');
	} else {
		$presentacion->asignarValor("resultado_Pendientes",0);
	}
	
	if ($rowmail["estadisticas_envios.Enviados"]>0) {
		$presentacion->asignarValor("resultado_Enviados",'<a href="elementosEnviados.php?accion=buscar&IdEnvio='.$rowmail["mails.IdMail"].'&incluidoEnvio=enviado&IdGrupo=0" onclick="event.cancelBubble=true;return true;">' . $rowmail["estadisticas_envios.Enviados"] . '</a>');
	} else {
		$presentacion->asignarValor("resultado_Enviados",0);
	}
	
	if ($rowmail["estadisticas_envios.Pendientes"]>0) {
		$presentacion->asignarValor("resultado_Enviar",'<a target="_blank" href="enviar_mail.php?limite=10&id='.$rowmail["mails.IdMail"].'" onclick="event.cancelBubble=true;return true;">de 10</a> <a target="_blank" href="enviar_mail.php?limite=20&id='.$rowmail["mails.IdMail"].'" onclick="event.cancelBubble=true;return true;">de 20</a> <a target="_blank" href="enviar_mail.php?limite=30&id='.$rowmail["mails.IdMail"].'" onclick="event.cancelBubble=true;return true;">de 30</a> <a target="_blank" href="enviar_mail.php?limite=40&id='.$rowmail["mails.IdMail"].'" onclick="event.cancelBubble=true;return true;">de 40</a>');
	} else {
		$presentacion->asignarValor("resultado_Enviar",'&nbsp;');
	}

	$presentacion->parse("FilaResultado", true);
}

function noHayRegistros(&$presentacion){
	$presentacion->asignarValor("ArrayMasInfo","");
	$presentacion->asignarValor("PaginarResultado","");
	
}
?>