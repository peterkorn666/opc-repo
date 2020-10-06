<?PHP
function conectarDB($servidor=SERVIDOR_LOGIN,$usuario=USUARIO_LOGIN,$password=PASSWORD_LOGIN,$base=BASE_LOGIN) {
  $bd=new BD($servidor,$usuario,$password);
  $bd->conectar();
  $bd->seleccionar($base);
  return $bd;
}

// da el valor de la tabla de configuracion
function valorConfiguracion($clave) {
        global $conexion;
        $mensaje="";
        $rs=null;
        buscarDatos("configuracion","Valor","Clave='$clave'",$rs, $mensaje,$conexion);
        if ($rs && mysqli_num_rows($rs)>0) {
            $rowConf=mysqli_fetch_array($rs);
                return $rowConf["Valor"];
        } else {
                return "";
        }
}

// carga los valores por defecto
function valoresPorDefecto(&$campos,$porDefecto) {
  $keys=array_keys($campos);
  for ($i=0;$i<count($keys);$i++) {
  if (array_key_exists ( $keys[$i], $porDefecto )) {
          $campos[$keys[$i]]=$porDefecto[$keys[$i]];
        } else {
        $campos[$keys[$i]]="";
        }
  }
}

function leerParametro($parametro,$valorPorDefecto="", $method="post") {
	global $_POST,$_GET,$_FILES;
	$resultado=null;
	if ($method=="post") {
	  if(isset($_POST[$parametro])){
	    if ($_POST[$parametro]!="") {
	      $resultado= $_POST[$parametro];
	    } else {
	      $resultado= $valorPorDefecto;
	    }
	  } else  {
	    if(isset($_GET[$parametro])){
	      if ($_GET[$parametro]!="") {
	        $resultado= $_GET[$parametro];
	      } else {
	        $resultado= $valorPorDefecto;
	      }
	    } else {
	    	if(isset($_FILES[$parametro])){
		      if ($_FILES[$parametro]["name"]!="") {
		        $resultado= $_FILES[$parametro];
		      } else {
		        $resultado= $valorPorDefecto;
			  }
		    } else {
		      $resultado= $valorPorDefecto;
		    }
	     }
	   }
	} else if ($method=="GET") {
	  if(isset($_GET[$parametro])){
	    if ($_GET[$parametro]!="") {
	      $resultado= $_GET[$parametro];
	    } else {
	      $resultado= $valorPorDefecto;
	    }
	  } else  {
	    if(isset($_POST[$parametro])){
	      if ($_POST[$parametro]!="") {
	        $resultado= $_POST[$parametro];
	      } else {
	        $resultado= $valorPorDefecto;
	      }
	    } else {
	    	if(isset($_FILES[$parametro])){
		      if ($_FILES[$parametro]!="") {
		        $resultado= $_FILES[$parametro];
		      } else {
		        $resultado= $valorPorDefecto;
			  }
		    } else {
		      $resultado= $valorPorDefecto;
		    }
	     }
	   }
	}
	// lo replace que siguen están porque las comillas vienen con el escape
	$resultado=str_replace("\\\"","\"",$resultado) ;
	$resultado=str_replace("\\'","'",$resultado) ;
	$resultado=str_replace("\\\\'","\\'",$resultado) ;
	$resultado=str_replace("\\\\\"","\\\"",$resultado) ;	
	return $resultado;
}



//lee un parámetro buscándolo primero en el post y luego en el get
function leerParametroPostGet($parametro,$valorPorDefecto="") {
  return leerParametro($parametro,$valorPorDefecto="");
}

//lee un parámetro buscándolo primero en el post y luego en el get
function leerParametroGetPost($parametro,$valorPorDefecto="") {
global $_POST,$_GET;
  if(!empty($_GET[$parametro])){
    return $_GET[$parametro];
  } else  if(!empty($_POST[$parametro])){
    return $_POST[$parametro];
  } else {
    return $valorPorDefecto;
  }
}

// lee los parametros del get y post
function leerParametros(&$campos,$porDefecto) {
  $keys=array_keys($campos);
  for ($i=0;$i<count($keys);$i++) {
  if (array_key_exists ( $keys[$i], $porDefecto )) {
          $campos[$keys[$i]]=leerParametro($keys[$i],$porDefecto[$keys[$i]]);
        } else {
          $campos[$keys[$i]]=leerParametro($keys[$i]);
        }
        }
}
