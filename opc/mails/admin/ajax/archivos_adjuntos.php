<?PHP
$resultado="";
$accion="";
$directorio="";
$archivo="";
$nuevo="";
$permisos="";
$tipo_respuesta="";
if (isset($_REQUEST["accion"])) {
	$accion=$_REQUEST["accion"];
}	
if (isset($_REQUEST["directorio"])) {
	$directorio=urldecode($_REQUEST["directorio"]);
}	
if (isset($_REQUEST["archivo"])) {
	$archivo=urldecode($_REQUEST["archivo"]);
}	
if (isset($_REQUEST["nuevo"])) {
	$nuevo=urldecode($_REQUEST["nuevo"]);
}	
if (isset($_REQUEST["permisos"])) {
	$permisos=$_REQUEST['permisos'];
}
if (isset($_REQUEST["tipo_respuesta"])) {
	$tipo_respuesta=$_REQUEST['tipo_respuesta'];
}

if($tipo_respuesta=="") {
 $tipo_respuesta="html";
}
$resultado="";
/*
define("DIR_BASE",str_replace("\\","/",DIR_ADJUNTOS));
define("URL_ADJUNTOS","adjuntos");
*/
define("DIR_BASE",str_replace("\\","/",realpath("../../adjuntos")));
define("RUTA_WEB_BASE","../../adjuntos");

include "../clases/archivos.php";

$fs=new SistemaArchivos(DIR_BASE);

$rutaWeb="";

  switch ($accion) {
	case "listar":		  
			$aContenido=null;
			if ($fs->cambiarDirectorio($directorio)) {
				
				$rutaFisica=str_replace("\\","/",$fs->darDirectorioActual());

				if (strpos($rutaFisica,DIR_BASE)===false) {
					$fs->cambiarDirectorio(DIR_BASE);
					$directorio="";
				}
				
				$rutaFisica=str_replace("\\","/",$fs->darDirectorioActual());
				$rutaFisica=str_replace("//","/",$rutaFisica);
				
				if (RUTA_WEB_BASE!="") {
					$rutaWeb=str_replace("//","/",RUTA_WEB_BASE . "/" . $directorio);
				} else {
					$rutaWeb="";
				}
				
				$aContenido=$fs->contenidoDirectorioActual();
				
				if (count($aContenido)>0) {
					foreach ($aContenido as $llave => $fila) {
						$tipo[$llave]  = $fila['tipo'];
						$nombre[$llave] = $fila['nombre'];
					}
					array_multisort($tipo, SORT_ASC, $nombre, SORT_ASC, $aContenido);
				}
			}
		
		 
		  if ($aContenido!=null) { 
		   switch ($tipo_respuesta) {
			case "html":
				$resultado.= "<br />Ruta: ". $directorio ."<br />RutaFisica: ".  urlencode($rutaFisica)."<br />Ruta Web: ".  urlencode($rutaWeb) . "<br />Es Legible: " . $fs->esLegible($rutaFisica) . "<br />Es Escribible: " . $fs->esEscribible($rutaFisica) ; 

				foreach($aContenido as $k=>$v) {
					$resultado.= "<br />" . $k . " " . urlencode($v["nombre"]) . " " . $v["tipo"] . " " . $v["tamaño"] . "  Propietario: " . $v["propietario"] . "  Permisos: " . $v["permisos"] . "  Legible: " . $v["legible"] . " Escribible: " . $v["escribible"];
				}
			break;
			case "json":
			 $arr = array();  
				foreach($aContenido as $k=>$v) {
					$arr1[] = "{\"IdListado\": \"". $k ."\", \"Nombre\": \"".  urlencode($v["nombre"]) ."\", \"Tipo\": \"". $v["tipo"] ."\", \"Tamanio\": \"". $v["tamaño"]."\", \"Propietario\": \"". $v["propietario"]."\", \"Permisos\": \"". $v["permisos"]."\", \"Legible\": \"". $v["legible"]."\", \"Escribible\": \"". $v["escribible"]."\"}"; 
				}   
			 $contenido= implode(", ", $arr1);
			 $arr2[] = "{\"Ruta\": \"". urlencode($directorio) ."\", \"RutaFisica\": \"".  urlencode($rutaFisica) ."\", \"RutaWeb\": \"".  urlencode($rutaWeb) ."\", \"Legible\": \"".  $fs->esLegible($rutaFisica) ."\", \"Escribible\": \"".  $fs->esEscribible($rutaFisica) ."\", \"Contenido\": [". $contenido ."]}"; 
			 $resultado.= implode(", ", $arr2);
			break;
			case "xml": 
				$resultado.= "<directorio Ruta=\"". $directorio ."\" RutaFisica=\"".  urlencode($rutaFisica)  ."\" RutaWeb=\"".  urlencode($rutaWeb) ."\" />";  
				foreach($aContenido as $k=>$v) {
					$resultado.= "<archivos Nombre=\"".urlencode($v["nombre"]) ."\" Tipo=\"". $v["tipo"] ."\" Tamanio=\"". $v["tamaño"]."\" />"; 
				}
			break;		
		   }
		} else {
		   switch ($tipo_respuesta) {
			case "html":
				$resultado.= "<br />Ruta: ". $directorio ."<br />RutaFisica: ".  urlencode($rutaFisica)."<br />Ruta Web: ".  urlencode($rutaWeb) . "<br />Es Legible: " . $fs->esLegible($rutaFisica) . "<br />Es Escribible: " . $fs->esEscribible($rutaFisica) ; 

				$resultado.= "<br />No hay archivos.";
			break;
			case "json":
			 $arr = array();  
			 $contenido= "";
			 $arr2[] = "{\"Ruta\": \"". urlencode($directorio) ."\", \"RutaFisica\": \"".  urlencode($rutaFisica) ."\", \"RutaWeb\": \""."\", \"RutaWeb\": \"".  urlencode($rutaWeb) ."\", \"Legible\": \"".  $fs->esLegible($rutaFisica) ."\", \"Escribible\": \"".  $fs->esEscribible($rutaFisica) ."\", \"Contenido\": [". $contenido ."]}";
			 $resultado.= implode(", ", $arr2);
			break;
			case "xml": 
				$resultado.= "<directorio Ruta=\"". $directorio ."\" RutaFisica=\"".  urlencode($rutaFisica)  ."\" RutaWeb=\"".  urlencode($rutaWeb) ."\" />";  
			break;	
		   }
		  } 
	break;
	case "crearDirectorio":	
		if ($fs->cambiarDirectorio($directorio)) {
			if (strpos($nuevo,"/")!==false) {
				$resultadoCreacion=0;
			} else {
				$resultadoCreacion=($fs->crearSubDirectorio($nuevo))?1:0;
			}
			$resultado.=prepararRespuesta($tipo_respuesta,array("Resultado"=>$resultadoCreacion,"Nombre"=>urlencode($nuevo),"Mensaje"=>$fs->mensaje));
		}
	break;
	case "asignarPermisos":	
		if (strpos($archivo,"/")!==false) {
			$resultadoCambioPermisos=0;
		} else {
			$resultadoCambioPermisos=($fs->asignarPermisos($permisos,$archivo))?1:0;
		}
		$resultado.=prepararRespuesta($tipo_respuesta,array("Resultado"=>$resultadoCambioPermisos,"Nombre"=>urlencode($nuevo),"Mensaje"=>$fs->mensaje));
	break;
	
	case "renombrar":	

			if ($fs->cambiarDirectorio($directorio)) {

				if (strpos($nuevo,"/")!==false || strpos($archivo,"/")!==false) {
					$resultadoRenombrar=0;
				} else {
					$resultadoRenombrar=($fs->renombrar($archivo,$nuevo))?1:0;
				}
			   $resultado.=prepararRespuesta($tipo_respuesta,array("Resultado"=>$resultadoRenombrar,"Anterior"=>urlencode($archivo),"Nuevo"=>urlencode($nuevo),"Mensaje"=>$fs->mensaje));
		}
	break;
	case "eliminarArchivo":		  
			if ($fs->cambiarDirectorio($directorio)) {
				
				$rutaFisica=str_replace("\\","/",$fs->darRutaReal($archivo));
				
				if (strpos($rutaFisica,DIR_BASE)===false || strpos($archivo,"/")!==false) {
					$resultadoEliminacion=0;
				} else {
					$resultadoEliminacion=($fs->eliminarArchivo($archivo))?1:0;
				}
				$resultado.=prepararRespuesta($tipo_respuesta,array("Resultado"=>$resultadoEliminacion,"Nombre"=>urlencode($archivo),"Mensaje"=>$fs->mensaje));
		}
	break;
	
	case "eliminarDirectorio":		  
			if ($fs->cambiarDirectorio($directorio)) {		

				$rutaFisica=str_replace("\\","/",$fs->darRutaReal($archivo));
				
				if (strpos($rutaFisica,DIR_BASE)===false  || strpos($archivo,"/")!==false) {
					$resultadoEliminacion=0;
				} else {
					$resultadoEliminacion=($fs->vaciarDirectorio($archivo) && $fs->eliminarDirectorio($archivo))?1:0;
				}
				$resultado.=prepararRespuesta($tipo_respuesta,array("Resultado"=>$resultadoEliminacion,"Nombre"=>urlencode($archivo),"Mensaje"=>$fs->mensaje));
		}
	break;

	case "upload":
			$directorio=$_POST['directorio'];

			if ($fs->cambiarDirectorio($directorio)) {	
				$rutaFisica=str_replace("\\","/",$fs->darDirectorioActual());

				if (strpos($rutaFisica,DIR_BASE)===false) {
					$resultado = "<script language='javascript'>parent.uploadError(" . $_POST['id'] . ",'Directorio " . $rutaFisica  . " no valido');</script>" ;
				} else {
					ini_set("max_execution_time", "10000");

					ini_set("max_input_time", "10000");

					ini_set("post_max_size", "512M");

					ini_set("upload_max_filesize", "10M");

					ini_set("memory_limit", "64M");

					$array_extension = explode(".", utf8_decode($_FILES["uploaderControl" . $_POST['id']]["name"]));

					$extension = array_pop($array_extension);
					
					$nombreArchivo_original = utf8_decode($_FILES["uploaderControl" . $_POST['id']]["name"]);

					$uploadFile = str_replace("//","/",$rutaFisica . "/" .   $nombreArchivo_original) ;
					if(move_uploaded_file($_FILES["uploaderControl" . $_POST['id']]['tmp_name'], $uploadFile)){
						@chmod($uploadFile, 0777);
						$resultado = "<script language='javascript'>parent.uploadComplete(" . $_POST['id'] . ",'" . $nombreArchivo_original . " en " . $directorio  . "');</script>";
					} else {
						$resultado = "<script language='javascript'>parent.uploadError(" . $_POST['id'] . ",'" . $nombreArchivo_original  . "');</script>" ;
					}
				}
		}
	break;
  }

 header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
 header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
 header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1 
 header ("Pragma: no-cache"); // HTTP/1.0
 
 switch ($tipo_respuesta) {
  case "html":
   echo $resultado;
  break;
  case "xml":
   header("Content-Type: text/xml"); 
   echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><archivos>";
   echo $resultado;
   echo "</archivos>";
  break;
  case "json";
   header("Content-Type: application/json");
   echo "{\"archivos\": [";
   echo $resultado;
   echo "]}";
  break;
  default:
   echo $resultado;
  break;
 }
 
function prepararRespuesta($tipo_respuesta,$datos) {
	$resultado="";
	switch ($tipo_respuesta) {
		case "html":
			foreach ($datos as $key => $value) {
				$resultado.= "<br />$key: ". $value;
			}
		break;
		case "json":
			$txtArr="";
		 	foreach ($datos as $key => $value) {
				if ($txtArr!="") {
					$txtArr.=",";
				}
				$txtArr.="\"$key\": \"$value\"";
			}
			$arr2[] = "{".$txtArr."}"; 
			$resultado= implode(", ", $arr2);
		break;
		case "xml": 
			$txtXML="";
			foreach ($datos as $key => $value) {
				$txtXML.= "$key=\"$value\" ";
			}
			$resultado= "<resultado $txtXML />";  
		break;
		default:
			$resultado="Tipo de respuesta desconocido: $tipo_respuesta";
		break;
	}
	return $resultado;
}


 
?>
