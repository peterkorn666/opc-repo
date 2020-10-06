<?PHP

function mysql_prep($value){
    $magic_quotes_active = get_magic_quotes_gpc();
    $new_enough_php = function_exists("mysql_real_escape_string");
    // i.e PHP >= v4.3.0
    if($new_enough_php){
    //undo any magic quote effects so mysql_real_escape_string can do the work
    if($magic_quotes_active){
        $value = stripslashes($value);
    }
    $value = mysql_real_escape_string($value);
    }else{ // before PHP v4.3.0
        // if magic quotes aren't already on this add slashes manually
        if(!$magic_quotes_active){
            $value = addslashes($value);
        } //if magic quotes are avtive, then the slashes already exist
			$buscar=array("\\", "'", "\"");
			$cambiar=array("\\\\", "\\'", "\\\"");
			$value=str_replace($buscar,$cambiar,$value);
    }
    return $value;
} 


class BD_relacion
{
	var $tipoRelacion;
	var $tablaSecundaria;
	var $condicionRelacion;

	function BD_relacion($tipoRelacion,  $tablaSecundaria,$condicionRelacion) {
		$this->tipoRelacion=$tipoRelacion;
		$this->tablaSecundaria=$tablaSecundaria;
		$this->condicionRelacion=$condicionRelacion;
	}
}


class BD
{
 	var $host;
	var $user;
	var $password;
	var $basedatos;
	var $link;
	var $query;
	var $rs;
	var $filas;
	var $filasAfectadas;
	var $conectado;
	var $hayBaseActiva;
	var $errornum;
	var $error;
	var $idInsert;

	function BD($host=null,$user=null,$password=null,$basedatos=null) {
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->basedatos = $basedatos;
		$this->link = null;
		$this->query = "";
		$this->rs = null;
		$this->filas = 0;
		$this->filasAfectadas = 0;
		$this->conectado = false;
		$this->hayBaseActiva = false;
		$this->errornum = 0;
		$this->error = "";
		$this->idInsert = 0;
	}

	function conectar() {
		$this->link = @mysql_connect($this->host ,$this->user,$this->password );
		//no es compatible con todas las versiones de mysql
		//mysql_query('SET NAMES "'.CHARSET_BD.'"', $this->link);

		$this->errornum=mysql_errno();
		$this->error=mysql_error();
		if ($this->errornum) {
			$this->conectado = false;
		} else {
			$this->conectado = true;
		}
		$this->hayBaseActiva = false;
		return $this->conectado;
	}

	function seleccionar($basedatos=null) {
		if (!$this->conectado) {
			$this->conectar();
		}
		if ($this->errornum==0) {
			if (!is_null($basedatos)) {
				$this->basedatos=$basedatos;
			}
			@mysql_select_db($this->basedatos,$this->link);
			$this->errornum=mysql_errno($this->link);
			$this->error=mysql_error($this->link);
			if ($this->errornum) {
				$this->hayBaseActiva = false;
			} else {
				$this->hayBaseActiva = true;
			}
		}
		return $this->hayBaseActiva;
	}

	function cerrar() {
		$this->liberarRecordset();
		@mysql_close($this->rs);
		$this->link=null;
		$this->errornum=mysql_errno();
		$this->error=mysql_error();
		$this->hayBaseActiva=false;
		$this->conectado = false;
		return ($this->errornum==0);
	}

	function ejecutarSentenciaSQL($query){
//	echo "<hr>$query<hr>";
		$this->errornum=0;
		$this->error="";
		if (!$this->hayBaseActiva) {
			$this->seleccionar();
		}
		if ($this->errornum==0) {
			$this->query = $query;
			

			$this->rs = @mysql_query($query,$this->link);
			$this->errornum=mysql_errno($this->link);
			$this->error=mysql_error($this->link);
			
			if ($this->errornum) {
			
				echo "<hr>";
				echo $query;
				echo "<hr>";
				echo $this->error;
				echo "<hr>";
			
				return false;
			} else {			
				if(strpos(ltrim(strtoupper($query)),"SELECT")===0) {
					$this->filas = mysql_num_rows($this->rs);
				} else {
					$this->filas = 0;
				}
				if(strpos(ltrim(strtoupper($query)),"UPDATE")===0 || strpos(ltrim(strtoupper($query)),"DELETE")===0 || strpos(ltrim(strtoupper($query)),"INSERT")===0 || strpos(ltrim(strtoupper($query)),"REPLACE")===0) {
					$this->filasAfectadas = mysql_affected_rows($this->link);
				} else {
					$this->filasAfectadas = 0;
				}
				if(strpos(ltrim(strtoupper($query)),"INSERT")===0) {
					$this->idInsert = mysql_insert_id($this->link);
				} else {
					$this->idInsert = 0;
				}
				return true;
			}
		} else {
			return false;
		}
	}


	function obtenerRecordset($query) {
		return $this->ejecutarSentenciaSQL($query);
	}

	function liberarRecordset(){
		if (!is_null($this->rs)) {
			@mysql_free_result($this->rs);
			$this->rs = null;
			$this->filas = 0;
			$this->hayBaseActiva=false;
			$this->errornum=mysql_errno();
			$this->error=mysql_error();
			$this->conectado = false;
			return ($this->errornum==0);
		} else {
			return false;
		}
	}

	function fechaHoraBD($fecha="",$formato="Y-m-d H:i:s") {
		if ($fecha=="") {
			return date($formato);
		} else {
			return date($formato,strtotime($fecha));
		}
	}

	function condicionFechas($campo,$desde=null,$hasta=null) {
		$condicion="(1=1)";
		if ($desde) {
			$condicion .= " AND $campo>='" . bd::fechaHoraBD(bd::dmy_mdy($desde) . " 00:00:00") . "'" ;
		}
		if ($hasta) {
			$condicion .= " AND $campo<='" . bd::fechaHoraBD(bd::dmy_mdy($hasta). " 23:59:59")  . "'" ;
		}

		return "($condicion)";
	}
	
	function dmy_mdy($dmy,$separador="/") {
		$arr=split($separador,$dmy);
		if (count($arr)==3) {
			return $arr[1] . "/" . $arr[0] . "/" . $arr[2];
		} else {
			return "";
		}
	}
	
	function dmy_ymd($dmy,$separador="/") {
		$arr=split($separador,$dmy);
		if (count($arr)==3) {
			return $arr[2] . "/" . $arr[1] . "/" . $arr[0];
		} else {
			return "";
		}
	}
	
	function ymd_dmy($ymd,$separador="/") {
		$arr=split($separador,$ymd);
		if (count($arr)==3) {
			return $arr[2] . "/" . $arr[1] . "/" . $arr[0];
		} else {
			return "";
		}
	}

	function darSiguienteFila() {
		return @mysql_fetch_array($this->rs);
	}

	function irAFila($numeroFila) {
		@mysql_data_seek ($this->rs,$numeroFila);
		$this->errornum=mysql_errno();
		$this->error=mysql_error();
		return ($this->errornum==0);
	}

	function cantidadCampos() {
		$cantidadCampos=mysql_num_fields($this->rs);
		$this->errornum=mysql_errno();
		$this->error=mysql_error();
		return cantidadCampos;
	}

	function darCampos() {
		$campos=array();
		$i = 0;
		while ($i < mysql_num_fields($this->rs)) {
			$f=mysql_fetch_field($this->rs, $i);
			array_push($campos,$f->name);
			$i++;
		}
		return $campos;
	}

	function condicionCampoClave($id,$campoClave){
		$resultado="1=2";
		if (count($id)==count($campoClave)) {
			if (count($id)==1) {
				$resultado=$campoClave . "='". $id ."'";
			} else {
				$resultado="";
				for ($i=0;$i<count($id);$i++) {
					if ($resultado!="") {
						$resultado.=" AND ";
					}
					$resultado.=$campoClave[$i]."='". $id[$i] ."'";
				}
			}
		}
		return "(" .  $resultado . ")";
	}

	// arma la condicion de busqueda de texto para los campos dados  en el formato "campo1,campo2,campo3"
	// la condicion final selecciona los registro que contenga alguna de las palabras en alguno de los campos
	function condicionTexto($campos,$texto) {
		$texto = trim($texto);
		//Obtengo un array que contiene en cada posición una palabra del string
		$palabras = explode(" ", $texto);
		//Obtengo un array que contiene en cada posición un campo
		$camposArray = explode(",",$campos);
		$cantidadPalabras = sizeof($palabras);
		$cantidadCampos=sizeof($camposArray);
		$condicionFinal = "";
		// para cada campo armo la condicion con cada palabra
		for ($j=0;$j<$cantidadCampos;$j++) {
				if ($condicionFinal!="")
						$condicionFinal = $condicionFinal . " OR ";

				$condicionCampo="";
				for ($i=0;$i<$cantidadPalabras;$i++){
					if ($palabras[$i]!="") {
						if ($condicionCampo!="")
								$condicionCampo = $condicionCampo . " OR ";
						$condicionCampo = $condicionCampo .  $camposArray[$j] . " LIKE '%" . mysql_prep($palabras[$i]) . "%'";
					}
				}
				if ($condicionCampo!="") {
					$condicionFinal = $condicionFinal . " ( " . $condicionCampo . " ) ";
				}

		}

		if ($condicionFinal!="")
				$condicionFinal =  " ( " . $condicionFinal . " ) ";
		return $condicionFinal;
	}

	// sentencia order by
	function orderBy($arrayOrden=null,$columna=null,$direccion=null) {
		global $orden,$o,$od; // $orden = array con ordenes , $o = numero de columna  a usar , $od direccion 1=asc 2=desc
			if (is_null($arrayOrden) && isset($orden)) {
				$arrayOrden=$orden;
			}
			if (is_null($columna) && isset($o)) {
				$columna=$o;
			}
			if (is_null($direccion) && isset($od)) {
				$direccion=$od;
			}
		$resultado="";
		if ($columna>0) {
		$resultado.=" ORDER BY " . $arrayOrden[$o];
			 if ($direccion==2) {
				$resultado.=" DESC";
			 }
		}
		return $resultado;
	}

	function buscarDatos($tabla,$campos,$condiciones,$orden="",$relaciones=array(),$agruparPor="",$condicionAgruparPor="",$primero="",$ultimo="", $limite="") {
		$resultado=false;
		$sql="";

		if (count($campos)==1) {
			$sql=$campos;
		} else {
			$keys=array_keys($campos);
			for ($i=0;$i<count($keys);$i++) {
				if ($sql!="") {
					$sql .= ",";
				}
				$sql .=  $campos[$keys[$i]];
			}
		}

		$sql="SELECT " . $sql . " FROM ". $tabla;

		for ($i=0;$i<count($relaciones);$i++) {
			$relacion=$relaciones[$i];
			$sql.= " " . $relacion->tipoRelacion . " JOIN " . $relacion->tablaSecundaria  ." ON " . $relacion->condicionRelacion;
		}

		if ($condiciones!="") {
			$sql.=" WHERE " . $condiciones;
		}

		if ($agruparPor!="") {
			$sql.=" GROUP BY " . $agruparPor;
			if ($condicionAgruparPor!="") {
				$sql.=" HAVING " . $condicionAgruparPor;
			}
		}
		
		if ($orden!="") {
				$sql.=" ORDER BY " . $orden;
		}
		if ($ultimo!="" && $primero!="") {
			if ($limite!="") {
				if ($primero+$ultimo>$limite) {
					$sql.=" LIMIT $primero," . ($limite-$primero);
				} else {
					$sql.=" LIMIT $primero,$ultimo";
				}
			} else {			
				$sql.=" LIMIT $primero,$ultimo";
			}
		} else {
			if ($limite!="") {
				$sql.=" LIMIT 0,$limite";
			}
		}

		if ($this->obtenerRecordset($sql)) {
			if ($this->filas>0) {
					$this->mensaje .= $this->filas . " Registro(s) encontrado(s)";
			}else {
					$this->mensaje .= "No se encontró ningún registro ";
			}
			$resultado=true;
		}
		
		//echo "<br>" . $sql;
		return $resultado;
	}

	function buscarDatosSQL($sql,$orden="",$agruparPor="",$condicionAgruparPor="",$primero="",$ultimo="",$limite="") {
		$resultado=false;

		if ($agruparPor!="") {
			$sql.=" GROUP BY " . $agruparPor;
			if ($condicionAgruparPor!="") {
				$sql.=" HAVING " . $condicionAgruparPor;
			}
		}
		
		if ($orden!="") {
				$sql.=" ORDER BY " . $orden;
		}
		if ($ultimo!="" && $primero!="") {
			if ($limite!="") {
				if ($primero+$ultimo>$limite) {
					$sql.=" LIMIT $primero," . ($limite-$primero);
				} else {
					$sql.=" LIMIT $primero,$ultimo";
				}
			} else {			
				$sql.=" LIMIT $primero,$ultimo";
			}
		} else {
			if ($limite!="") {
				$sql.=" LIMIT 0,$limite";
			}
		}

		if ($this->obtenerRecordset($sql)) {
			if ($this->filas>0) {
					$this->mensaje .= $this->filas . " Registro(s) encontrado(s)";
			}else {
					$this->mensaje .= "No se encontró ningún registro ";
			}
			$resultado=true;
		}
		
		//echo "<br>" . $sql;
		return $resultado;
	}
	
	function cargarDatos($datos,&$campos) {
		$keys=array_keys($campos);
		for ($i=0;$i<count($keys);$i++) {
			if ($datos && array_key_exists ( $keys[$i], $datos )) {
				$campos[$keys[$i]]=$datos[$keys[$i]];
			} else {
				$campos[$keys[$i]]="";
			}
		}
	}

	function leerDatos($id, &$mensaje, $tabla,$campoClave,&$campos) {
		$resultado=false;
		$keys=array_keys($campos);
		$sql="";
		for ($i=0;$i<count($keys);$i++) {
		if ($sql!="") {
			$sql .= ",";
		}
			$sql .= str_replace(".","`.`","`" . $keys[$i] . "`");
		}

		$sql="SELECT " . $sql . " FROM " . $tabla;

		$sql.=" WHERE " . $this->condicionCampoClave($id,$campoClave);

		if($this->obtenerRecordset($sql)) {

			if ($this->filas>0) {
				$datos=$this->darSiguienteFila();
				$keys=array_keys($campos);
				$this->cargarDatos($datos,$campos);
				$resultado=true;
			} else {
				$mensaje .= "No se encontró ningún registro ";
			}
		}
		return $resultado;
	}

	function agregarRegistro(&$mensaje,$tabla,$campoClave,$campos) {
		$resultado=false;
		$nombresCampos="";
		$valores="";
		$keys=array_keys($campos);
		for ($i=0;$i<count($keys);$i++) {
			if ($nombresCampos!="") {
				$nombresCampos .= ",";
			}
	        $nombresCampos .=  str_replace(".","`.`","`" . $keys[$i] . "`");
			if ($valores!="") {
				$valores .= ",";
			}
			if (is_null($campos[$keys[$i]])) {
				$valores .= "null";
			} else {
				$valores .=  "'" . mysql_prep($campos[$keys[$i]]) . "'";
			}
	    }

	    $sql="INSERT INTO " . $tabla . "(" . $nombresCampos . ") VALUES (" . $valores . ")";

		$this->ejecutarSentenciaSQL($sql);

		if ($this->idInsert>0) {
			$resultado=$this->idInsert;
			$mensaje .= "El nuevo registro tiene el id: " . $resultado;
		} else {
			$agregados=$this->filasAfectadas;
			if ($agregados>0) {
				$resultado=true;
				$mensaje .= "$agregados Registro(s) agregados";
			}
		}
		return $resultado;
	}

	function actualizarRegistro($id, &$mensaje,$tabla,$campoClave,$campos) {
		$resultado=false;
		$keys=array_keys($campos);
		$sql="";
		for ($i=0;$i<count($keys);$i++) {
			if ($sql!="") {
				$sql .= ",";
			}

			if (is_null($campos[$keys[$i]])) {
				$sql .=  str_replace(".","`.`","`" . $keys[$i] . "`") . "=null";
			} else {
				$sql .=  str_replace(".","`.`","`" . $keys[$i] . "`") . "=" ."'" . mysql_prep($campos[$keys[$i]]) . "'";
			}
		}

		if ($sql=="") {
			$resultado=true;
			$mensaje .= "No se modificó ningún registro";
		} else {
			$sql="UPDATE " . $tabla . " SET " . $sql;
			$sql.=" WHERE ". $this->condicionCampoClave($id,$campoClave);
			if($this->ejecutarSentenciaSQL($sql)) {
				$resultado=true;
				if ($this->filasAfectadas>0) {
					$mensaje .= "$this->filasAfectadas Registro(s) modificado";
				}
				else {
					$mensaje .= "No se modificó ningún registro";
				}
			} else {
				$mensaje .= $this->error;
			}
		}
		return $resultado;
	}

	function borrarRegistro($id, &$mensaje,$tabla,$campoClave) {
		$resultado=false;
		$sql="DELETE FROM " . $tabla;
		$sql.=" WHERE " . $this->condicionCampoClave($id,$campoClave);
		if ($this->ejecutarSentenciaSQL($sql)) {
			$eliminados=$this->filasAfectadas;
			if ($eliminados>0) {
				$mensaje .= "$eliminados Registros eliminado(s)";
				$resultado=true;
			}
			else {
				$mensaje .= "No se eliminó ningún registro";
			}
		} else {
			$mensaje .= $this->error;
		}
		return $resultado;
	}
	
	function borrarCondicion(&$mensaje,$tabla,$condicion) {
		$resultado=false;
		$sql="DELETE FROM " . $tabla;
		$sql.=" WHERE " . $condicion;
		if ($this->ejecutarSentenciaSQL($sql)) {
			$eliminados=$this->filasAfectadas;
			if ($eliminados>0) {
				$mensaje .= "$eliminados Registros eliminado(s)";
				$resultado=true;
			}
			else {
				$mensaje .= "No se eliminó ningún registro";
			}
		} else {
			$mensaje .= $this->error;
		}
		return $resultado;
	}
}

class RS
{
	var $rs;
	var $filas;

	function RS($rs=null) {
		$this->rs = $rs;
		if (!is_null($rs)) {
			$this->filas = mysql_num_rows($rs);
		} else {
			$this->filas = 0;
		}
	}

	function liberarRecordset(){
		if (!is_null($this->rs)) {
			@mysql_free_result($this->rs);
			$this->rs = null;
			$this->filas = 0;
			$this->errornum=mysql_errno();
			$this->error=mysql_error();
			return ($this->errornum==0);
		} else {
			return false;
		}
	}

	function darSiguienteFila() {
		return @mysql_fetch_array($this->rs);
	}

	function irAFila($numeroFila) {
		@mysql_data_seek ($this->rs,$numeroFila);
		$this->errornum=mysql_errno();
		$this->error=mysql_error();
		return ($this->errornum==0);
	}

	function cantidadCampos() {
		$cantidadCampos=mysql_num_fields($this->rs);
		$this->errornum=mysql_errno();
		$this->error=mysql_error();
		return cantidadCampos;
	}

	function darCampos() {
		$campos=array();
		$i = 0;
		while ($i < mysql_num_fields($this->rs)) {
			$f=mysql_fetch_field($this->rs, $i);
			array_push($campos,$f->name);
			$i++;
		}
		return $campos;
	}

}

/*
insert en varias sentencias
$maximoLargoSQL=400;
$sqlBase="INSERT IGNORE into subscriptos (Email) VALUES ";
$sql=$sqlBase;
while ($i<count($arrMails)) {
	$mail=$arrMails[$i];
	
	echo "<br>" . strtolower($mail);
	
	preg_match($reg, $mail,$coincidencias);	
	if ($mail==$coincidencias[0]) {
		echo " valido";
		$sqlAgregado="('" . $mail . "')";
	
		if (strlen($sql . $sqlAgregado)>$maximoLargoSQL) {
			echo "<br>Ejecutar " . $sql;
			echo "<br>agregados: " . ejecutarSentenciaSQL($sql,$conexion);
			$sql=$sqlBase;
		}
		if ($sql!=$sqlBase) {
			$sqlAgregado="," . $sqlAgregado;
		}	
		$sql.=$sqlAgregado;
		
	} else {
		echo " invalido";
	}
	$i++;
}
*/

?>