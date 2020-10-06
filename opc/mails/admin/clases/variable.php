<?PHP
class Variable {
	var $id;
	var $valor;
	var $tabla;
	var $campo;
	var $clave;
	var $autonumerica;
	var $orden;
	var $labelMostrar;
	var $labelTemplate;
	var $expresionOrdenar;
	var $expresionBuscar;
	var $tipoDato;
/*
tipoDato	Nombre	Descripcion
1	string	Texto
2	int	Entero
3	bool	Boolean
4	dataTime	Fecha y Hora
5	excluyentes	Opciones excluyentes
6	no_excluyentes	Opciones no excluyentes
7	fecha	Fecha
8	hora	Hora
9	email
10	file
*/
	var $largoTotal;
	var $decimales;
	var $tipoControl;
	var $mascara;
	var $largoMascara;
	var $expresionesValidacion;
	var $expresionesFocus;
	var $valorPorDefecto;
	var $campoHTML;
	var $campoSQL;
	var $campoSQLAlias;
	var $visible;
	var $habilitada;
	var $requerida;
	var $valoresPosibles;
	var $textoAyuda;
	var $mostrarValor;

	function Variable($tipoDato=null,$tabla=null,$campo=null,$orden=null,$seleccionar=true,$labelMostrar=null,$labelTemplate=null,$ordenar=true,$expresionOrdenar=null,$buscar=true,$expresionBuscar=null, $largoTotal=null,$decimales=null,$tipoControl=null,$mascara=null,$largoMascara=null,$expresionesValidacion=null,$expresionesFocus=null,$valorPorDefecto="", $campoHTML=null,$campoSQL=null,$campoSQLAlias=null,$visible=true,$habilitada=true,$valoresPosibles=null,$textoAyuda=null,$mostrarValor=true) {
		$this->id=$campo;
		$this->tabla=$tabla;
		$this->campo=$campo;
		if ($campoSQL==null) {
			$this->campoSQL="`" . $tabla . "`.`" . $campo . "`";
			if ($campoSQLAlias==null) {
				$this->campoSQLAlias="`" . $tabla . "." . $campo . "`";
			} else {
				$this->campoSQLAlias=$campoSQLAlias;
			}
		} else {
			$this->campoSQL=$campoSQL;
			if ($campoSQLAlias==null) {
				$this->campoSQLAlias=$this->campoSQL;
			} else {
				$this->campoSQLAlias=$campoSQLAlias;
			}
		}

		$this->orden=$orden;
		if ($labelMostrar==null) {
			$this->labelMostrar=$campo;
		} else {
			$this->labelMostrar=$labelMostrar;
		}
		if ($labelTemplate==null) {
			$this->labelTemplate=$campo;
		} else {
			$this->labelTemplate=$labelTemplate;
		}
		if ($expresionOrdenar==null) {
			if ($campoSQLAlias==null) {
				$this->expresionOrdenar=$this->campoSQL;
			} else {
				$this->expresionOrdenar=$campoSQLAlias;
			}
		} else {
			$this->expresionOrdenar= "`" . $expresionOrdenar . "`";
		}
		if ($expresionBuscar==null) {
			if ($campoSQLAlias==null) {
				$this->expresionBuscar=$this->campoSQL;
			} else {
				$this->expresionBuscar=$campoSQLAlias;
			}
		} else {
			$this->expresionBuscar="`" . $expresionBuscar . "`";
		}
		$this->seleccionar=$seleccionar;
		$this->ordenar=$ordenar;
		$this->buscar=$buscar;
		$this->tipoDato=$tipoDato;
		$this->largoTotal=$largoTotal;
		$this->decimales=$decimales;
		$this->tipoControl=$tipoControl;
		$this->mascara=$mascara;
		$this->largoMascara=$largoMascara;
		if ($expresionesValidacion==null) {
			$this->expresionesValidacion=null;
		} else {
			$this->expresionesValidacion=array();
			if (is_array($expresionesValidacion)) {
				for ($i=0;$i<count($expresionesValidacion);$i++) {
					array_push($this->expresionesValidacion,$expresionesValidacion[$i]);
				}
			} else {
				array_push($this->expresionesValidacion,$expresionesValidacion);
			}
		}
		if ($expresionesFocus==null) {
			$this->expresionesFocus=null;
		} else {
			$this->expresionesFocus=array();
			if (is_array($expresionesFocus)) {
				for ($i=0;$i<count($expresionesFocus);$i++) {
					array_push($this->expresionesFocus,$expresionesFocus[$i]);
				}
			} else {
				array_push($this->expresionesFocus,$expresionesFocus);
			}
		}
		$this->valorPorDefecto=$valorPorDefecto;
		if ($campoHTML==null) {
			$this->campoHTML=$campo;
		} else {
			$this->campoHTML=$campoHTML;
		}

		$this->valoresPosibles=$valoresPosibles;
		if ($textoAyuda==null) {
			$this->textoAyuda="";
		} else {
			$this->textoAyuda=$textoAyuda;
		}

		$this->valor=$valorPorDefecto;

		$this->visible=$visible;
		$this->habilitada=$habilitada;
		$this->requerida=false;
		$this->mostrarValor=$mostrarValor;
	}

}
?>