<?PHP
ini_set('display_errors', 1);
error_reporting(E_ALL);
require "inicializar.php";
controlarAcceso($sistema,3);
$presentacion->abrir("archivosAdjuntos.php","../paginas/","Principal");
require "../clases/form_class.php";
$mensajeError="";
$form_abm_1= new form_class();
$form_abm_1->objDatos= new objeto();
$form_abm_1->action="archivos_adjuntos.php";
$form_abm_1->script_OnLoad="eval('iniciar();');";
$form_abm_1->accionPorDefecto="mostrar";
$form_abm_1->agregarScript(scripts());

$form_abm_1->redirect=false;
$form_abm_1->leerDatos();
$form_abm_1->procesar();

$presentacion->asignarValor("Mensaje",$form_abm_1->mensaje);

$form_abm_1->mostrar=1;
if ($form_abm_1->mostrar==1) {
	$presentacion->parse("FormEdicion",false);
} else {
	$presentacion->asignarValor("FormEdicion","");
}

$form_abm_1->mostrarEnPresentacion($presentacion);

$presentacion->mostrar();
function scripts() {
	global $form_abm_1;
	$resultado .= '<script  type="text/javascript">
var urlScriptArchivos="../ajax/archivos_adjuntos.php";
var nombreCarpetaInicial="adjuntos";
var rutaActual="";
var enActividad=0;
Ajax.Responders.register({
  onCreate: function(request){
	if (request.url.indexOf(urlScriptArchivos)>0) {
		if (request.parameters["accion"] && (request.parameters["accion"]=="eliminar" )) {
			enActividad=1;
		}
	}
  }, 
  onComplete: function(request){
	if (request.url.indexOf(urlScriptArchivos)>0) {
		if (request.parameters["accion"] && (request.parameters["accion"]=="eliminar" )) {
			enActividad=0;
		}
	}
  }
});

function cargarDirectorio(dir) {

	new Ajax.Request(urlScriptArchivos,
	  {
		method:"get",
		parameters: {accion: \'listar\', directorio: dir, tipo_respuesta: \'json\'},
		requestHeaders: {Accept: \'application/json\'},
		onSuccess: function(transport){

			var cliente_json = transport.responseText.evalJSON(true);

			ruta=unescape(cliente_json.archivos[0].Ruta);
			if (ruta!="") {
				ruta+="/";
			}
			
			rutaWeb=unescape(cliente_json.archivos[0].RutaWeb);

			legible=unescape(cliente_json.archivos[0].Legible);
			
			escribible=unescape(cliente_json.archivos[0].Escribible);
			if (escribible==1) {
				$("divUploadArchivos").show();
				$("divUploadArchivosSinPermiso").hide();
				$("divCrearDirectorio").show();
				$("divCrearDirectorioSinPermiso").hide();
			} else {
				$("divUploadArchivos").hide();
				$("divUploadArchivosSinPermiso").show();
				$("divCrearDirectorio").hide();
				$("divCrearDirectorioSinPermiso").show();
			}
			contenido=cliente_json.archivos[0].Contenido;
			
			camino="";
			if (ruta!="") {
				camino+="<a href=\'#\' onclick=\'javascript:cargarDirectorio(\"\");return false;\'>"+nombreCarpetaInicial+"</a>";
			} else {
				camino+=nombreCarpetaInicial;
			}
			aRuta=ruta.split("/");
			acumulado="";
			for (i=0;(i+2)<aRuta.length;i++) {
				camino+="/<a href=\'#\' onclick=\'javascript:cargarDirectorio(\"" +acumulado + aRuta[i]+ "\");return false;\'>" + aRuta[i] + "</a>";
				acumulado+=aRuta[i] + "/";
			}
			camino+="/" + aRuta[i];
			$("spanRuta").innerHTML=camino;

			resultado="";
			if (contenido.length>0)
			{
				for (i=0;i<contenido.length;i++) {
					if (contenido[i].Tipo=="dir") {
						resultado+="<div class=\'admArchivos_directorio\'>";
						resultado+="<a href=\'#\' onclick=\'javascript:cargarDirectorio(\"" + unescape(ruta)  + (contenido[i].Nombre) + "\");return false;\'>";
						resultado+=unescape(contenido[i].Nombre);
						resultado+="</a>";
						if (contenido[i].Escribible==1) {
							resultado+=" <a class=\'admArchivos_eliminar\' href=\'#\' onclick=\'javascript:eliminarDirectorio(\"" + contenido[i].Nombre + "\");return false;\' title=\'eliminar\'>&nbsp;</a>";
							resultado+=" <a class=\'admArchivos_renombrar\' href=\'#\' onclick=\'javascript:renombrar(\"" + contenido[i].Nombre + "\");return false;\' title=\'renombrar\'>&nbsp;</a>";
						}
						resultado+="</div>";
					} else {
						resultado+="<div class=\'admArchivos_archivo\'>";
						resultado+=contenido[i].Nombre;
						if (rutaWeb!="" && contenido[i].Legible==1) {
							resultado+=" <a class=\'admArchivos_descargar\' href=\'" + rutaWeb +   contenido[i].Nombre + "\' target=\'_blank\' title=\'descargar\'>&nbsp;</a>";
						}
						if (contenido[i].Escribible==1) {
							resultado+=" <a href=\'#\' class=\'admArchivos_eliminar\' onclick=\'javascript:eliminarArchivo(\"" + contenido[i].Nombre + "\");return false;\' title=\'eliminar\'>&nbsp;</a>";							
							resultado+=" <a href=\'#\' class=\'admArchivos_renombrar\' onclick=\'javascript:renombrar(\"" + contenido[i].Nombre + "\");return false;\' title=\'renombrar\'>&nbsp;</a>";
						}
						resultado+="</div>";
					}
				}
			} else {
				resultado="No hay archivos.";
			}

			$("divDirectorio").innerHTML=resultado;
			
			rutaActual=dir;
			
		},
		onFailure: function(){ alert(\'Error al conectarse...\') }
	  });
 
}

function crearDirectorio(nuevo) {

	new Ajax.Request(urlScriptArchivos,
	  {
		method:\'get\',
		parameters: {accion: \'crearDirectorio\', directorio: rutaActual, nuevo: nuevo, tipo_respuesta: \'json\'},
		requestHeaders: {Accept: \'application/json\'},
		onSuccess: function(transport){

			var cliente_json = transport.responseText.evalJSON(true);

			resultado=cliente_json.archivos[0].Resultado;
			
			if (resultado==1) {
				cargarDirectorio(rutaActual);
				alert("El directorio " + unescape(cliente_json.archivos[0].Nombre) + " fue creado exitosamente");
			} else {
				alert("No se pudo crear el directorio " + unescape(cliente_json.archivos[0].Nombre));
			}
			
		},
		onFailure: function(){ alert(\'Error al conectarse...\') }
	  });
 
}

function eliminarDirectorio(directorio) {
	confirma=confirm("Confirma que desea eliminar el directorio "+ directorio + "?");
	if (confirma) {
		new Ajax.Request(urlScriptArchivos,
		  {
			method:\'get\',
			parameters: {accion: \'eliminarDirectorio\', directorio: rutaActual, archivo: directorio, tipo_respuesta: \'json\'},
			requestHeaders: {Accept: \'application/json\'},
			onSuccess: function(transport){

				var cliente_json = transport.responseText.evalJSON(true);

				resultado=cliente_json.archivos[0].Resultado;
				
				if (resultado==1) {
					cargarDirectorio(rutaActual);
					alert("El directorio " + unescape(cliente_json.archivos[0].Nombre) + " fue eliminado exitosamente");
				} else {
					alert("No se pudo eliminar el directorio " + unescape(cliente_json.archivos[0].Nombre));
				}
				
			},
			onFailure: function(){ alert(\'Error al conectarse...\') }
		  });
	}
}

function eliminarArchivo(archivo) {
	confirma=confirm("Confirma que desea eliminar el archivo "+ archivo + "?");
	if (confirma) {
		new Ajax.Request(urlScriptArchivos,
		  {
			method:\'get\',
			parameters: {accion: \'eliminarArchivo\', directorio: rutaActual, archivo: archivo, tipo_respuesta: \'json\'},
			requestHeaders: {Accept: \'application/json\'},
			onSuccess: function(transport){

				var cliente_json = transport.responseText.evalJSON(true);

				resultado=cliente_json.archivos[0].Resultado;
				
				if (resultado==1) {
					cargarDirectorio(rutaActual);
					alert("El archivo " + unescape(cliente_json.archivos[0].Nombre) + " fue eliminado exitosamente");
				} else {
					alert("No se pudo eliminar el archivo " + unescape(cliente_json.archivos[0].Nombre));
				}
				
			},
			onFailure: function(){ alert(\'Error al conectarse...\') }
		  });
	}
}

function renombrar(actual) {
	nuevo=prompt("Nuevo nombre:",actual);
	if (nuevo!=null && nuevo!="") {
		new Ajax.Request(urlScriptArchivos,
		  {
			method:\'get\',
			parameters: {accion: \'renombrar\', directorio: rutaActual, archivo: actual, nuevo: nuevo, tipo_respuesta: \'json\'},
			requestHeaders: {Accept: \'application/json\'},
			onSuccess: function(transport){

				var cliente_json = transport.responseText.evalJSON(true);

				resultado=cliente_json.archivos[0].Resultado;
				
				if (resultado==1) {
					cargarDirectorio(rutaActual);
					alert( unescape(cliente_json.archivos[0].Anterior) + " se renombró a " +  unescape(cliente_json.archivos[0].Nuevo));
				} else {
					alert("No se pudo renombrar " + unescape(cliente_json.archivos[0].Anterior + " a " +  unescape(cliente_json.archivos[0].Nuevo)));
				}
				
			},
			onFailure: function(){ alert(\'Error al conectarse...\') }
		  });
	}
}

function uploadFile(id) {
	enActividad=1;
	$(\'formUpload\'+id).elements["directorio"].value=rutaActual;
    $(\'formUpload\'+id).submit();
	$(\'uploader\'+id).hide();
	$(\'other\'+id).hide();
	$(\'result\'+id).innerHTML = \'<img src="../img/cargando.gif" width="15" height="11" />Subiendo archivo \' + $("uploaderControl"+ id).value;
} 

function uploadError(id,file) {
	enActividad=0;
	$(\'result\'+id).innerHTML = file + \' no se pudo subir.\';
	$(\'other\'+id).show();
	alert(\'El archivo \' +  file + \'no se pudo subir.\');
}

function uploadComplete(id,file) {
	enActividad=0;
	cargarDirectorio(rutaActual);
	$(\'result\'+id).innerHTML = file + \' subido.\';
	$(\'other\'+id).show();
	alert(\'Archivo \' +  file + \' subido.\');
}

function subirOtro(id) {
	$(\'result\'+id).innerHTML = "";
	$(\'uploader\'+id).show();
	$(\'other\'+id).hide();
}

cargarDirectorio("");

</script>';

		return $resultado;

	}