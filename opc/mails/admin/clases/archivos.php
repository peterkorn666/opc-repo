<?PHP

class SistemaArchivos
{
 	var $ruta;
	var $separadorDirectorios="/";
	var $mensaje="";

	function SistemaArchivos($nuevaRuta=null) {
		return $this->cambiarDirectorio($nuevaRuta);
	}
	
	function esEscribible($archivo) {
		//return (is_writable($archivo) && (!ini_get('safe_mode') || fileowner($archivo)==getmyuid() )); 
		return (is_writable($archivo) || (fileowner($archivo)==getmyuid() )); 
	}

	function esLegible($archivo) {
		return is_readable($archivo);
	}
	
	function cambiarDirectorio($nuevaRuta=null) {
		$nuevaRuta=$this->rutaAbsoluta($nuevaRuta);
		if (@chdir($nuevaRuta)) {
			$this->ruta=$nuevaRuta;
			return true;
		} else {
			$this->mensaje="No se pudo ir al directorio " . $nuevaRuta;
			return false;
		}
	}
	
	function darDirectorioActual() {
		return getcwd();
	}
	
	function darRutaReal($archivo) {
		return realpath($archivo);
	}

	function asignarPermisos($permisos,$objeto) {
		if (@chmod($objeto, $permisos)) {
			$this->mensaje="Se cambiaron los permisos a $permisos en $objeto";
			return true;
		} else {
			$this->mensaje="No se pudo cambiar permisos a $permisos en $objeto";
			return false;
		}
	}
	
	function crearDirectorio($nuevoDirectorio) {		
		if(@mkdir($nuevoDirectorio)) {
			$this->asignarPermisos(0777,$nuevoDirectorio);
			$resultado=true;
			$this->mensaje="Directorio creado $nuevoDirectorio" . "." . $this->mensaje;
		} else {
			$resultado=false;
			$this->mensaje="No se pudo crear el directorio $nuevoDirectorio";
		}
		return $resultado;
	}
	
	function crearSubDirectorio($nuevoDirectorio) {
		return $this->crearDirectorio($this->ruta . $this->separadorDirectorios . $nuevoDirectorio);
	}
	
	function vaciarDirectorioActual($recursivo=false) {
		$this->vaciarDirectorio($this->ruta,$recursivo);
	}
	
	function vaciarDirectorio($ruta=null,$recursivo=false) {
		$resultado=true;
		$ruta=$this->rutaAbsoluta($ruta);
		$d=dir($ruta);
		while (false !== ($entrada = $d->read())) {
			if(is_dir($ruta . $this->separadorDirectorios .  $entrada) && $entrada!="." && $entrada!=".." && $recursivo){
				$resultado=$resultado && SistemaArchivos::vaciarDirectorio($ruta. $this->separadorDirectorios .$entrada,$recursivo);
				$resultado=$resultado && rmdir($ruta. $this->separadorDirectorios .$entrada);
			}else{
				if(!is_dir($ruta . $this->separadorDirectorios .  $entrada) && $entrada!="." && $entrada!=".."){
					$resultado=$resultado && unlink($ruta . $this->separadorDirectorios .   $entrada);
				}
			}
		}
		$d->close();
		return $resultado;
	}
	
	function eliminarArchivo($archivo) {
		if (@unlink($archivo)) {
			$this->mensaje="El archivo $archivo fue eliminado.";
			return true;
		} else {
			$this->mensaje="No se pudo cambiar elminiar al archivo $archivo";
			return false;
		}
	}
	
	function eliminarDirectorio($directorio) {
		if (@rmdir($directorio)) {
			$this->mensaje="El directorio $directorio fue eliminado.";
			return true;
		} else {
			$this->mensaje="No se pudo elminiar al directorio $directorio";
			return false;
		}
	}
	
	function contenidoDirectorioActual($recursivo=false) {
		 return $this->contenido($this->ruta,$recursivo);
	}
	
	function contenido($ruta=null,$recursivo=false) {
		$ruta=$this->rutaAbsoluta($ruta);
		$d=dir($ruta);
		$aResultado=array();
		while (false !== ($entrada = $d->read())) {
			if($entrada!="." && $entrada!=".."){
				$tipo= filetype($ruta . $this->separadorDirectorios .$entrada);
				$tamanio= filesize($ruta . $this->separadorDirectorios .$entrada);
				$modificado=filemtime($ruta . $this->separadorDirectorios .$entrada);
				$permisos= substr(sprintf('%o', fileperms($ruta . $this->separadorDirectorios .$entrada)), -4); 
				$legible=($this->esLegible($ruta . $this->separadorDirectorios .   $entrada))?1:0;
				$propietario=fileowner($ruta . $this->separadorDirectorios .   $entrada);
				$escribible=($this->esEscribible($ruta . $this->separadorDirectorios .   $entrada))?1:0;
				if(is_dir($ruta . $this->separadorDirectorios .   $entrada) && $entrada!="." && $entrada!=".." && $recursivo){
					$aResultadoSub=SistemaArchivos::contenido($ruta. $this->separadorDirectorios . $entrada,$recursivo);
				}else{
					$aResultadoSub=null;
				}
				array_push($aResultado,array("nombre"=>$entrada,"tipo"=>$tipo,"tamaño"=>$tamanio,"modificado"=>$modificado,"propietario"=>$propietario,"permisos"=>$permisos,"legible"=>$legible,"escribible"=>$escribible,"sub"=>$aResultadoSub));
			}
		}
		$d->close();
		return $aResultado;
	}
	
	function copiar($actual,$nuevo) {
		return copy($actual,$nuevo);
	}
	
	function copiarDirectorioActual($recursivo=false) {
		$this->copiarDirectorio($this->ruta,$recursivo);
	}
	
	function copiarDirectorio($actual=null,$nuevo=null,$recursivo=false) {
		if ($nuevo!=null && file_exists($nuevo)) {
			$actual=$this->rutaAbsoluta($actual);
			$d=dir($actual);
			while (false !== ($entrada = $d->read())) {
			
				if(is_dir($actual . $this->separadorDirectorios .   $entrada) && $entrada!="." && $entrada!=".." && $recursivo){
					if (is_dir($nuevo . $this->separadorDirectorios .   $entrada) || SistemaArchivos::crearDirectorio($nuevo . $this->separadorDirectorios .   $entrada)) {
						SistemaArchivos::copiarDirectorio($actual. $this->separadorDirectorios .   $entrada, $nuevo . $this->separadorDirectorios .   $entrada,$recursivo);
					}
				}else{
					if(!is_dir($actual . $this->separadorDirectorios .   $entrada) && $entrada!="." && $entrada!=".."){
						copy($actual . $this->separadorDirectorios .   $entrada,$nuevo . $this->separadorDirectorios .   $entrada);
					}
				}
			}
			$d->close();
		}
	}
	
	function renombrar($actual=null,$nuevo=null) {
		if (file_exists($actual) && !file_exists($nuevo)) {
			if (rename($actual,$nuevo)) {
				$this->mensaje="El archivo $actual fue renombrado como $nuevo.";
				return true;
			} else {
				$this->mensaje="No se pudo renombrar al archivo $actual como $nuevo.";
				return false;
			}
		} else {
			$this->mensaje="No se pudo renombrar al archivo $actual como $nuevo. O ya existe el destino o no existe el origen.";
			return false;
		}
		

	}
	
	function rutaAbsoluta($ruta="") {
		$resultado="";
		if (substr($ruta,0,1)=="/") {
			$resultado=$ruta;
		} else if (substr($ruta,1,1)==":") {
			$resultado=$ruta;
		} else {
			if (!isset($this->ruta) || $this->ruta==null  || $this->ruta=="") {
				$rutaActual=getcwd();
			} else {
				$rutaActual=$this->ruta;
			}
			if (substr($rutaActual,-1,1)=="/" || substr($rutaActual,-1,1)=="\\") {
				$rutaActual=substr($rutaActual,0,strlen($rutaActual)-1);
			}
			$resultado=$rutaActual . $this->separadorDirectorios . $ruta;
		}
		return $resultado;
	}

}



?>