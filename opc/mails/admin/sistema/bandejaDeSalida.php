<?PHP
require "inicializar.php";
controlarAcceso($sistema,2);

$presentacion->abrir("bandejaDeSalida.php","../paginas/","Principal");

require "../clases/form_br.php";

$form_br_class1= new form_br_class();
$form_br_class1->action="bandejaDeSalida.php";
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

//deshabilita todas las variables y habilita solo las que se usan
$form_br_class1->objDatos->deshabilitarVariables();
$form_br_class1->objDatos->asignarPropiedadVariable("IdSubscripto","habilitada",true);
$form_br_class1->objDatos->asignarPropiedadVariable("Email","habilitada",true);
$form_br_class1->objDatos->asignarPropiedadVariable("Activo","habilitada",true);
$form_br_class1->objDatos->asignarPropiedadVariable("EnviosPendientes","habilitada",true);
$form_br_class1->objDatos->asignarPropiedadVariable("EnviosHechos","habilitada",true);
$form_br_class1->objDatos->asignarPropiedadVariable("EnviosRebotados","habilitada",true);

$incluidoEnvio=leerParametro("incluidoEnvio","");
$idEnvio=leerParametro("IdEnvio",0);

$form_br_class1->objDatos->agregarRelacion(new BD_relacion("LEFT","subscriptos_datos_personales","subscriptos_datos_personales.IdSubscripto=subscriptos.IdSubscripto"));

$v=new Variable(1,"subscriptos_datos_personales","NombreApellido",1);
$v->campoSQL="CONCAT(Nombre,Apellido)";
$v->expresionOrdenar="CONCAT(Nombre,Apellido)";
$v->expresionBuscar="Nombre,Apellido";
$form_br_class1->objDatos->agregarVariable2($v,"NombreApellido");

$v=new Variable(1,"subscriptos_datos_personales","Profesion",1);
$form_br_class1->objDatos->agregarVariable2($v,"Profesion");

$v=new Variable(1,"subscriptos_datos_personales","Especialidad",1);
$form_br_class1->objDatos->agregarVariable2($v,"Especialidad");

$v=new Variable(1,"subscriptos_datos_personales","Pais",1);
$form_br_class1->objDatos->agregarVariable2($v,"Pais");

$v=new Variable(1,"subscriptos_datos_personales","Idioma",1);
$form_br_class1->objDatos->agregarVariable2($v,"Idioma");

$v=new Variable(1,"subscriptos_datos_personales","Libre1",1);
$form_br_class1->objDatos->agregarVariable2($v,"Libre1");

$v=new Variable(1,"subscriptos_datos_personales","Libre2",1);
$form_br_class1->objDatos->agregarVariable2($v,"Libre2");

$form_br_class1->leerDatos();

$form_br_class1->limite=leerParametro("Limite","");
$presentacion->asignarValor("Limite",$form_br_class1->limite);

if (leerParametro("accion","")==""){ // llamada directa, carga valores de la session	
	session::cargarValoresVariables($form_br_class1->objDatos->variables,"seleccionar_subscriptos". "_");
	$form_br_class1->o=session::darValor("seleccionar_subscriptos" . "_" . "o");	
	if ($form_br_class1->o=="") {
		$form_br_class1->o=$form_br_class1->columnaOrdenPorDefecto;
	}
	$form_br_class1->od=session::darValor("seleccionar_subscriptos" . "_" . "od");
	if ($form_br_class1->od=="") {
		$form_br_class1->od=$form_br_class1->direccionOrdenPorDefecto;
	}
} else { 
	if (leerParametro("accion","")=="limpiarBusquedaGuardada") { // pido limpiar sesion
		session::eliminarValoresVariables($form_br_class1->objDatos->variables,"seleccionar_subscriptos". "_");
		foreach($form_br_class1->objDatos->variables as $v) {
			$v->valor=$v->valorPorDefecto;
		}
		$form_br_class1->o=$form_br_class1->columnaOrdenPorDefecto;
		$form_br_class1->od=$form_br_class1->direccionOrdenPorDefecto;
		$form_br_class1->accion=$form_br_class1->accionPorDefecto;
	} else { //datos nuevos, los guarda en la session
		session::asignarValoresVariables($form_br_class1->objDatos->variables,"seleccionar_subscriptos" . "_");
		session::asignarValor("seleccionar_subscriptos" . "_" . "o", $form_br_class1->o);
		session::asignarValor("seleccionar_subscriptos" . "_" . "od", $form_br_class1->od);
	}
}

$form_br_class1->acciones["agregarSusbscriptosSeleccionados"]="agregarSusbscriptosSeleccionados";
$form_br_class1->acciones["agregarSubscriptosTodos"]="agregarSubscriptosTodos";
$form_br_class1->acciones["quitarSubscriptosSeleccionados"]="quitarSubscriptosSeleccionados";
$form_br_class1->acciones["quitarSubscriptosTodos"]="quitarSubscriptosTodos";

if ($incluidoEnvio=="") {
	$form_br_class1->filtro="(1=2)";
}else if ($incluidoEnvio=="cualquiera") {
	$presentacion->asignarValor("checked_incluidoEnvio_cualquiera","checked");
	$form_br_class1->filtro="subscriptos.Activo<>0";
}else if ($incluidoEnvio=="no") {
	$presentacion->asignarValor("checked_incluidoEnvio_no","checked");
	$form_br_class1->filtro="subscriptos.Activo<>0 and not (subscriptos.EnviosPendientes like '%:$idEnvio:%' or subscriptos.EnviosHechos like '%:$idEnvio:%' or subscriptos.EnviosRebotados like '%:$idEnvio:%')";
}else if ($incluidoEnvio=="si") {
	$presentacion->asignarValor("checked_incluidoEnvio_si","checked");
	$form_br_class1->filtro="(subscriptos.Activo<>0 and (subscriptos.EnviosPendientes like '%:$idEnvio:%' or subscriptos.EnviosHechos like '%:$idEnvio:%' or subscriptos.EnviosRebotados like '%:$idEnvio:%'))";	
}else if ($incluidoEnvio=="pendiente") {
	$presentacion->asignarValor("checked_incluidoEnvio_pendiente","checked");
	$form_br_class1->filtro="(subscriptos.Activo<>0 and subscriptos.EnviosPendientes like '%:$idEnvio:%')";	
} else if ($incluidoEnvio=="enviado") {
	$presentacion->asignarValor("checked_incluidoEnvio_enviado","checked");
	$form_br_class1->filtro="(subscriptos.Activo<>0 and subscriptos.EnviosHechos like '%:$idEnvio:%')";
} else if ($incluidoEnvio=="rebotado") {
	$presentacion->asignarValor("checked_incluidoEnvio_rebotado","checked");
	$form_br_class1->filtro="(subscriptos.Activo<>0 and subscriptos.EnviosRebotados like '%:$idEnvio:%' and not ( subscriptos.EnviosHechos like '%:$idEnvio:%'))";	
}
/*
$arrGrupos=leerParametro("IdGrupo","");
$filtroGrupos="";
if (is_array($arrGrupos)) {
	for ($ig=0;$ig<count($arrGrupos);$ig++) {		
		if ($filtroGrupos!="") {
			$filtroGrupos.=",";
		}
		$filtroGrupos.= $arrGrupos[$ig] ;
	}
}
if ($filtroGrupos!="") {
	$form_br_class1->filtro.=" AND IdGrupo IN ($filtroGrupos)";
}
*/

$idGrupo=leerParametro("IdGrupo",0);

if ($idGrupo>0) {
	$form_br_class1->objDatos->agregarRelacion(new BD_relacion("LEFT","subscriptos_grupos","subscriptos_grupos.IdSubscripto=subscriptos.IdSubscripto"));

	$v=new Variable(2,"subscriptos_grupos","IdGrupo",1);
	$form_br_class1->objDatos->agregarVariable2($v,"IdGrupo");
	$form_br_class1->filtro.=" AND IdGrupo = $idGrupo";
}

$form_br_class1->procesar();

//$envios=$sistema->crearEnvios();
$envios=new objeto();
$envios->sistema=$sistema;
$envios->database=$sistema->database;
$envios->sql="select envios.IdEnvio as IdEnvio,concat(' (',envios.IdEnvio,') ',Descripcion,' -> (',Pendientes,' pendientes)') as Descripcion from envios inner join estadisticas_envios on envios.IdEnvio=estadisticas_envios.IdEnvio where Pendientes>0";

$presentacion->asignarValor("envios","<option value=-1>Seleccione mail</option>".cargarListBoxRS($envios->buscarDatos("IdEnvio,CONCAT('(',IdEnvio,') ',Descripcion)","","IdEnvio DESC"),$idEnvio));

$presentacion->definirSecciones();

$grupos=$sistema->crearGrupos();
$rs=$grupos->buscarDatos("IdGrupo,Grupo","","Grupo");
/*
$listadoGrupos="";
while ($row=$rs->darSiguienteFila()) {
	$listadoGrupos.= "<br/><input type='checkbox' name='IdGrupo[]' value='" . $row["IdGrupo"] . "' id='chk_grupo_" . $row["IdGrupo"] . "'". ((in_array($row["IdGrupo"], $arrGrupos))?"checked='checked'":"") . "/><label for='chk_grupo_" . $row["IdGrupo"] . "'>" . $row["Grupo"] . "</label>";
}
*/
$listadoGrupos="<select name='IdGrupo' id='IdGrupo'><option value='0'>Cualquiera</option>";
while ($row=$rs->darSiguienteFila()) {
	$listadoGrupos.= "<option value='" . $row["IdGrupo"] . "' " .  (($row["IdGrupo"]== $idGrupo)?"selected='selected'":"") . "/>" . $row["Grupo"] . "</option>";
}
$listadoGrupos.="</select>";

$presentacion->asignarValor("listadoGrupos",$listadoGrupos);


$form_br_class1->mostrarEnPresentacion($presentacion);
$presentacion->mostrar();

function filaSubscripto(&$presentacion,$rowsubscripto,$numeroFila){
	global $idEnvio;
//print_r($rowsubscripto);
	$arrUbicaciones=array();
	$arrClasificaciones=array();
	$presentacion->asignarValor("resultado_tipoFila",(($numeroFila + 1) % 2));
	$presentacion->asignarValor("resultado_scriptFila","onclick=\"js_br.cambiarCheck('Id_" . trim($rowsubscripto["subscriptos.IdSubscripto"]) . "');return false;\"");

	$presentacion->asignarValor("resultado_CheckSeleccion","<input type=\"checkbox\" id=\"Id_" .$rowsubscripto["subscriptos.IdSubscripto"]. "\" name=\"Id[]\" value=\"" . $rowsubscripto["subscriptos.IdSubscripto"] . "\" onClick=\"event.cancelBubble=true;\" />");

	$presentacion->asignarValor("resultado_Email",$rowsubscripto["subscriptos.Email"]);
	$presentacion->asignarValor("resultado_NombreApellido",$rowsubscripto["subscriptos_datos_personales.NombreApellido"]);
	$presentacion->asignarValor("resultado_Profesion",$rowsubscripto["subscriptos_datos_personales.Profesion"]);
	$presentacion->asignarValor("resultado_Especialidad",$rowsubscripto["subscriptos_datos_personales.Especialidad"]);
	$presentacion->asignarValor("resultado_Pais",$rowsubscripto["subscriptos_datos_personales.Pais"]);
	$presentacion->asignarValor("resultado_Idioma",$rowsubscripto["subscriptos_datos_personales.Idioma"]);
	$presentacion->asignarValor("resultado_EnviosPendientes",str_replace("(" . $idEnvio . ")","<span class='destacado_pendiente'>(" . $idEnvio . ")</span>",str_replace("()","","(".str_replace(":",") (",$rowsubscripto["subscriptos.EnviosPendientes"]).")") ));
	$presentacion->asignarValor("resultado_EnviosHechos",str_replace("(" . $idEnvio . ")","<span class='destacado_enviado'>(" . $idEnvio . ")</span>",str_replace("()","","(".str_replace(":",") (",$rowsubscripto["subscriptos.EnviosHechos"]).")") ));
	$presentacion->asignarValor("resultado_EnviosRebotados",str_replace("(" . $idEnvio . ")","<span class='destacado_rebotado'>(" . $idEnvio . ")</span>",str_replace("()","","(".str_replace(":",") (",$rowsubscripto["subscriptos.EnviosRebotados"]).")") ));
	$presentacion->parse("FilaResultado", true);
}


function noHayRegistros(&$presentacion){
	$presentacion->asignarValor("ArrayMasInfo","");
	$presentacion->asignarValor("PaginarResultado","");
	
}



function quitarSubscriptosSeleccionados() {
	global $form_br_class1,$sistema;
	$quitados=0;
	$subscriptos=leerParametro("Id","");
	$idEnvio=leerParametro("IdEnvio","");

	$sqlBase="delete from envios_subscriptos";
	$sqlBase.=" where IdEnvio=$idEnvio and IdEstadoEnvio=1 and IdSubscripto in ";

	$sqlBase2="update subscriptos set EnviosPendientes=IF(LOCATE(':$idEnvio:',EnviosPendientes)>0,
CONCAT(LEFT(EnviosPendientes,LOCATE(':$idEnvio:',EnviosPendientes)), RIGHT(EnviosPendientes, LENGTH(EnviosPendientes)-LOCATE(':$idEnvio:',EnviosPendientes)-LENGTH(':$idEnvio:')+1)),EnviosPendientes) where IdSubscripto in ";
	
	$largoMaximoSQL=1024;
	$in="";
	$i=0;
	while ($i<count($subscriptos)) {
		if ($in<>"" && strlen($sqlBase . " (" . $in . "," . $subscriptos[$i] . ")")>$largoMaximoSQL) {
			$sql=$sqlBase . " (" . $in .")";

			$sistema->database->ejecutarSentenciaSQL($sql);
			
			$quitados = $quitados + $sistema->database->filasAfectadas;
			
			$sql=$sqlBase2 . " (" . $in .")";

			$sistema->database->ejecutarSentenciaSQL($sql);
			
			$in=$subscriptos[$i];
		} else {
			if ($in<>"") {
				$in.=",";
			}
			$in.=$subscriptos[$i];
		}
		$i++;	
	}
	
	if ($in<>"") {
		$sql=$sqlBase . " (" . $in .")";
	
		$sistema->database->ejecutarSentenciaSQL($sql);
		
		$quitados = $quitados + $sistema->database->filasAfectadas;
		
		$sql=$sqlBase2 . " (" . $in .")";
	
		$sistema->database->ejecutarSentenciaSQL($sql);
	} 
	$sistema->actualizarEstadisticasEnviosCantidades($idEnvio,-$quitados,-$quitados,0,0);
	$form_br_class1->accion="buscar";

}


function quitarSubscriptosTodos() {
	global $form_br_class1,$sistema;
	$quitados=0;
	$idEnvio=leerParametro("IdEnvio","");
	$idGrupo=leerParametro("IdGrupo",0);

	$sqlJoinGrupos="";
	$whereGrupos="1=1";
	if ($idGrupo>0) {
		$sql="delete envios_subscriptos from envios_subscriptos";
		$sql.=" LEFT JOIN subscriptos ON envios_subscriptos.IdSubscripto=subscriptos.IdSubscripto ";
		$sql.=" LEFT JOIN subscriptos_grupos ON envios_subscriptos.IdSubscripto=subscriptos_grupos.IdSubscripto ";
		$sql.=" where IdEnvio=$idEnvio and IdEstadoEnvio=1 and IdGrupo=$idGrupo";
		$sql.=" and (" . $form_br_class1->condicionBuscar() . ")";
		if ($form_br_class1->limite!="") {
			$sql.=" LIMIT " . $form_br_class1->limite;
		}
		echo "<hr>" . $sql;
		//$sistema->database->ejecutarSentenciaSQL($sql);	
		$quitados = $quitados + $sistema->database->filasAfectadas;
				
		$sql="update subscriptos,subscriptos_grupos set EnviosPendientes=IF(LOCATE(':$idEnvio:',EnviosPendientes)>0,
CONCAT(LEFT(EnviosPendientes,LOCATE(':$idEnvio:',EnviosPendientes)), RIGHT(EnviosPendientes, LENGTH(EnviosPendientes)-LOCATE(':$idEnvio:',EnviosPendientes)-LENGTH(':$idEnvio:')+1)),EnviosPendientes)";
		$sql.=" where subscriptos_grupos.IdSubscripto=subscriptos.IdSubscripto and subscriptos_grupos.IdGrupo=$idGrupo and  (subscriptos.EnviosPendientes like '%:$idEnvio:%') ";
		$sql.=" and (" . $form_br_class1->condicionBuscar() . ")";
		if ($form_br_class1->limite!="") {
			$sql.=" LIMIT " . $form_br_class1->limite;
		}
		echo "<hr>" . $sql;
		//$sistema->database->ejecutarSentenciaSQL($sql);
		
	} else {
		$sql="delete envios_subscriptos from envios_subscriptos";
		$sql.=" LEFT JOIN subscriptos ON envios_subscriptos.IdSubscripto=subscriptos.IdSubscripto ";
		$sql.=" where IdEnvio=$idEnvio and IdEstadoEnvio=1";
		$sql.=" and (" . $form_br_class1->condicionBuscar() . ")";
		if ($form_br_class1->limite!="") {
			$sql.=" LIMIT " . $form_br_class1->limite;
		}

		$sistema->database->ejecutarSentenciaSQL($sql);	
		
		$quitados = $quitados + $sistema->database->filasAfectadas;
				
		$sql="update subscriptos set EnviosPendientes=IF(LOCATE(':$idEnvio:',EnviosPendientes)>0,
CONCAT(LEFT(EnviosPendientes,LOCATE(':$idEnvio:',EnviosPendientes)), RIGHT(EnviosPendientes, LENGTH(EnviosPendientes)-LOCATE(':$idEnvio:',EnviosPendientes)-LENGTH(':$idEnvio:')+1)),EnviosPendientes)";
		$sql.=" where (subscriptos.EnviosPendientes like '%:$idEnvio:%') ";
		$sql.=" and (" . $form_br_class1->condicionBuscar() . ")";
		if ($form_br_class1->limite!="") {
			$sql.=" LIMIT " . $form_br_class1->limite;
		}

		$sistema->database->ejecutarSentenciaSQL($sql);
	} 
	$sistema->actualizarEstadisticasEnviosCantidades($idEnvio,-$quitados,-$quitados,0,0);	
	$form_br_class1->accion="buscar";
}
?>