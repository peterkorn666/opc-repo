<?PHP

class objeto
{
	var $acciones=array(); // acciones y sus funciones.
	var $funcion_validar_eliminacion;
	var $funcion_posterior_eliminacion;
	var $id;
	var $accionPorDefecto;
	var $mensaje;
	var $tabla; // arma la búsqueda en base a la tabla y los campos
	var $sql; // para una búsqueda directa
	var $relaciones;
	var $agruparPor;
	var $condicionAgruparPor;
	var $campoClave;
	var $campoClaveAutonumerico;
	var $variables;
	var $variablesPorSQLAlias;
	var $origenDatos;
	var $filtro;
	var $database;
	var $campos;

	function objeto(){
		$this->variables=array();
		$this->variablesPorSQLAlias=array();
		$this->campoClaveAutonumerico=false;
		$this->relaciones=array();
	}

	function borrarDatosVariables() {
		foreach ( $this->darVariables() as $id => $var ){
			$this->asignarValorVariable($id,$var->valorPorDefecto);
        }
	}

	function deshabilitarVariables() {
		foreach ( $this->darVariables() as $id => $var ){
			$this->asignarPropiedadVariable($id,"habilitada",false);
        }
	}

	function agregarVariable($idVariable, $variable) {
		$variable->id=$idVariable;
		$this->variables[$idVariable]=$variable;
		$this->variablesPorSQLAlias[str_replace("`","",$variable->campoSQLAlias)]=$variable->id;
		
	}

	function agregarVariable2($variable,$idVariable="") {
		if ($idVariable!="") {
			$variable->id=$idVariable;
			$this->variables[$idVariable]=$variable;
		} else {
			if ($variable->campo!="") {
				$variable->id=$variable->campo;
				$this->variables[$variable->campo]=$variable;
			}
		}
		$this->variablesPorSQLAlias[str_replace("`","",$variable->campoSQLAlias)]=$variable->id;
	}

	function quitarVariable($idVariable) {
		$variable=$this->darVariable($idVariable);
		if ($variable) {
			unset($this->variablesPorSQLAlias[str_replace("`","",$variable->campoSQLAlias)]);
		}
		unset($this->variables[$idVariable]);
	}

	function darVariables() {
		return $this->variables;
	}

	function darVariable($idVariable) {
		$var=&$this->variables[$idVariable];
		if ($var) {
			return $var;
		} else {
			return null;
		}
	}

	function darVariablePorSQLAlias($SQLAlias) {
		return $this->darVariable($this->variablesPorSQLAlias[$SQLAlias]);
	}

	function asignarPropiedadVariable($idVariable,$propiedad,$valor) {
		$var=&$this->variables[$idVariable];
		if ($var) {
			if ($propiedad=="campoSQLAlias") {
				unset($this->variablesPorSQLAlias[$variable->campoSQLAlias]);
				$this->variablesPorSQLAlias[$valor]=$idVariable;
			}
			$var->$propiedad=$valor;
			if ($propiedad=="id") {
				$this->variablesPorSQLAlias[$variable->campoSQLAlias]=$valor;
			}
		} else {
			return null;
		}
	}

	function darValorVariable($idVariable) {
		if (array_key_exists ($idVariable, $this->variables)) {
			return $this->variables[$idVariable]->valor;
		} else {
			return null;
		}
	}

	function asignarValorVariable($idVariable,$valor) {
		if (array_key_exists ($idVariable, $this->variables)) {
			$this->variables[$idVariable]->valor=$valor;
			return true;
		} else {
			return false;
		}
	}

	function asignarValoresVariables($datos)
	{
	$this->borrarDatosVariables();
	if (is_array($datos)) {
		$campos=$this->darCampos();
		$keys=array_keys($campos);
		for ($i=0;$i<count($keys);$i++) {
			if (array_key_exists ( $keys[$i], $datos )) {
				$campos[$keys[$i]]=$datos[$keys[$i]];
			} else {
				$campos[$keys[$i]]="";
			}
		}
		$this->leerCampos($campos);

		if (count($this->campoClave)==1) {
			if (array_key_exists($this->campoClave, $datos )) {
				$this->id=$datos[$this->campoClave];
			}
		} else {
			$this->id=array();
			for ($i=0;$i<count($this->campoClave);$i++) {
				if (array_key_exists($this->campoClave[$i], $datos )) {
					$this->id[$i]=$datos[$this->campoClave[$i]];
				}
			}
		}
	}

	}

	function darNombresCampos($permitirDeshabilitados=false) { // por compatibilidad con funciones anteriores
			$campos=array();
		$i=0;
		foreach ( $this->variables as $id => $var ){
			if (($permitirDeshabilitados || $var->habilitada) && $var->campoSQL!="") {
				$campos[$i]=$var->campoSQL . " AS " . $var->campoSQLAlias;
				$i++;
			}
        }
		return $campos;
	}

	function darCampos($permitirDeshabilitados=false) { // por compatibilidad con funciones anteriores
		$campos=array();
		foreach ( $this->variables as $id => $var ){
			if (($permitirDeshabilitados || $var->habilitada) && $var->campoSQL!="") {
				//$campos[$id]=$var->valor;
				$campos[str_replace("`","",$var->campoSQLAlias)]=$var->valor;
			}
        }
		return $campos;
	}

	// da las variables necesarias para hacer insert, dependiendo del parametro sobrescribirCamposAutonumericos agrega o no variables autonumericas
	function darCamposInsert($tabla,$permitirDeshabilitados=false,$sobreEscribirAutonumerico=false) { // por compatibilidad con funciones anteriores
		$campos=array();
		foreach ( $this->variables as $id => $var ){
			if ($var->tabla==$tabla && ($permitirDeshabilitados || $var->habilitada) && $var->campoSQL!="" && ($sobreEscribirAutonumerico || !$var->autonumerica)) {
				$campos[$id]=$var->valor;
			}
        }
		return $campos;
	}

	// da las variables necesarias para hacer update
	function darCamposUpdate($tabla,$permitirDeshabilitados=false,$sobreEscribirAutonumerico=false) { // por compatibilidad con funciones anteriores
		$campos=array();
		foreach ( $this->variables as $id => $var ){
			if ($var->tabla==$tabla && ($permitirDeshabilitados || $var->habilitada) && $var->campoSQL!="" && ($sobreEscribirAutonumerico || !$var->autonumerica)) {
				$campos[$id]=$var->valor;
			}
        }
		return $campos;
	}

	function leerCampos($campos) { // por compatibilidad con funciones anteriores
		foreach ( $campos as $id => $valor ){
			$var=$this->darVariablePorSQLAlias($id);
			if ($var!=null) {
				$this->variables[$var->id]->valor=$valor;
			}
        }
	}


	function agregarRelacion($relacion) {
		array_push($this->relaciones,$relacion);
	}


// **********************
// SELECT METHOD / LOAD
// **********************
function buscarDatos($camposSeleccionar,$condiciones="",$orden="",$primero="",$ultimo="",$limite="") {

$this->borrarDatosVariables();
$this->id=null;

	if ($this->tabla!=null && $this->tabla!="") {	
		if ($this->database->buscarDatos($this->tabla,$camposSeleccionar,$condiciones,$orden,$this->relaciones,$this->agruparPor,$this->condicionAgruparPor,$primero,$ultimo,$limite)) {
			return new RS($this->database->rs);
		} else {
			return null;
		}
	} else if ($this->sql!="") {
		if ($this->database->buscarDatosSQL($this->sql,$orden,$this->agruparPor,$this->condicionAgruparPor,$primero,$ultimo,$limite)) {
			return new RS($this->database->rs);
		} else {
			return null;
		}
	} else {
		return null;
	}
}


function selectAll()
{
return $this->buscarDatos("*","");
}

function select($id)
{
$this->borrarDatosVariables();
$campos=$this->darNombresCampos();
$this->database->buscarDatos($this->tabla,$campos,$this->database->condicionCampoClave($id,$this->campoClave),"",$this->relaciones,$this->agruparPor,$this->condicionAgruparPor );
if ($this->database->filas>0) {
	$datos=$this->database->darSiguienteFila();
	$campos=$this->darCampos();
	$this->database->cargarDatos($datos,$campos);
	$this->leerCampos($campos);
	$this->id=$id;
	return true;
} else {
	$this->id=null;
	return false;
}

}


function buscarUna($condiciones)
{
	$this->borrarDatosVariables();
	$campos=$this->darNombresCampos();
	$this->database->buscarDatos($this->tabla,$campos,$condiciones,"",$this->relaciones,$this->agruparPor,$this->condicionAgruparPor );
	if ($this->database->filas>0) {
		$datos=$this->database->darSiguienteFila();
		$campos=$this->darCampos();
		$this->database->cargarDatos($datos,$campos);
		$this->leerCampos($campos);
		//asignar id
		return true;
	} else {
		$this->id=null;
		return false;
	}
}

// **********************
// DELETE
// **********************

function delete($id)
{
	$resultado=$this->database->borrarRegistro($id, $mensaje,$this->tabla,$this->campoClave);
	$this->select($this->id);
	$this->borrarDatosVariables();
	return $resultado;
}

function deleteWhere($condicion)
{
	$this->borrarDatosVariables();
	$this->id=null;
	$resultado=$this->database->borrarCondicion( $mensaje,$this->tabla,$condicion);
	$this->select($this->id);
	return $resultado;
}

// **********************
// INSERT
// **********************

function insert($sobreEscribirAutonumerico=false)
{
	if ($this->database->agregarRegistro($mensaje,$this->tabla,$this->campoClave,$campos=$this->darCamposInsert($this->tabla,false,$sobreEscribirAutonumerico))) {			
		$this->id = $this->database->idInsert;
		return true;
	} else {
		return false;
	}
}

// **********************
// UPDATE
// **********************

function update($id=null)
{
if ($id==null) {
	$id=$this->id;
}

if ($id!=null) {
	return $this->database->actualizarRegistro($id, $mensaje,$this->tabla,$this->campoClave,$this->darCamposUpdate($this->tabla,false,true));
} else {
	return false;
}


}




}
?>