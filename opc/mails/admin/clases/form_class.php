<?PHP
require_once('variable.php');

class form_class
{
	var $elemento_singular="registro";
	var $elemento_plural="registros";
	var $elemento_articulo_singular="el";
	var $elemento_articulo_plural="los";
	var $formulario_nombre="";
	var $action="";
	var $acciones=array(); // acciones y sus funciones.

	var $funcion_validar_eliminacion;
	var $funcion_posterior_eliminacion;

	var $paginaRetorno;
	var $accion;
	var $method;
	var $enctype;
	var $accionAnterior;
	var $id;
	var $accionPorDefecto;
	var $tituloPagina;
	
	var $soloLectura;

	var $redirigir;

	var $mensaje;

	var $objDatos;

	var $origenDatos;
	var $filtro;

	//var $conexion;
	var $mostrar;  //0= nada, 1=formulario, 2=error

	var $template;

	var $script_OnLoad;

	var $max_file_size; // para uploads
	
	var $arrCamposOcultos;
	var $arrScripts;

	function form_class($nombre="form1"){
		//$this->variables=array();
		$this->formulario_nombre=$nombre;
		$this->enctype="application/x-www-form-urlencoded";
		$this->secciones=array();
		$this->script_OnLoad="";
		$this->max_file_size=2048000;
		$this->arrCamposOcultos=array();
		$this->arrScripts=array();
		$this->soloLectura=false;
	}

	function agregarCampoOculto($nombre,$valor) {
		$this->arrCamposOcultos[$nombre]=$valor;
	}
	
	function agregarScript($script) {
		array_push($this->arrScripts,$script);
	}
	
	function camposOcultos() {
		$resultado="<input type='hidden' id='id' name='id' value='" . $this->id . "' />
					<input type='hidden' id='pr' name='pr' value='" . htmlspecialchars($this->paginaRetorno) . "' />
					<input type='hidden' id='accion' name='accion' value='" . $this->accion . "' />
					<input type='hidden' id='accionAnterior' name='accionAnterior' value='" . $this->accionAnterior . "' />
					<input type='hidden' id='MAX_FILE_SIZE' name='MAX_FILE_SIZE' value='" . $this->max_file_size . "' />
		";
		foreach ( $this->arrCamposOcultos as $id => $valor ){
			$resultado .= "<input type='hidden' id='" . $id . "' name='" . $id . "' value='" . $valor . "' />";
        }

		return $resultado;
	}

	function leerPaginaRetorno() {
		$pr=leerParametro("pr","");
		if ($pr=="") {
			if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!="") {
				$this->paginaRetorno=$_SERVER['HTTP_REFERER'];
			} else {
				$this->paginaRetorno=false;
			}
		} else {
		    $this->paginaRetorno=$pr;
		}
	}
	
	function leerDatosVariables(&$objDatos,$prefijo="",$sufijo="") {
		// variables
		if (isset($objDatos)) {
			foreach ( $objDatos->darVariables() as $id => $var ){
				$objDatos->asignarValorVariable($id,leerParametro($prefijo . $var->campoHTML . $sufijo,$var->valorPorDefecto));
	        }
		}
	}
	
	function leerDatos() {
		$this->leerPaginaRetorno();
		$this->accion=leerParametro("accion",$this->accionPorDefecto);
		$this->id=leerParametro("id","");
		// variables
		if (isset($this->objDatos)) {
			foreach ( $this->objDatos->darVariables() as $id => $var ){
				$this->objDatos->asignarValorVariable($id,leerParametro($var->campoHTML,$var->valorPorDefecto));
	        }
		}
	}

	function procesar() {
		// acciones redefinidas
		if(isset($this->acciones[$this->accion])) {
			$f= $this->acciones[$this->accion];
			if ($f) {
				call_user_func($f);
			}
		}
	}
	
	function scripts() {
		$resultado="";
		if ($this->script_OnLoad!="") {
			$resultado='<script type="text/javascript">window.onload=function(){' . $this->script_OnLoad . '}</script>';
		}
		for ($i=0;$i<count($this->arrScripts);$i++) {
			$resultado.=$this->arrScripts[$i];
		}
		return $resultado;
	}

	function asignarValoresVariables(&$presentacion,$variables=null,$prefijo="",$sufijo="",$arrBuscar=null,$arrReemplazar=null) {
		if ($variables==null) {
			$variables=$this->objDatos->darVariables();
		}
	
		if (!(is_null($arrBuscar) || is_null($arrReemplazar))) {
			foreach ( $variables as $id => $var ){
				$presentacion->asignarValor($prefijo . $var->labelTemplate . $sufijo,str_replace($arrBuscar,$arrReemplazar,$var->valor));
	        }	
		} else {
			foreach ( $variables as $id => $var ){
				$presentacion->asignarValor($prefijo . $var->labelTemplate . $sufijo,$var->valor);
	        }
		}
	}
	
	function inicioForm() {
		$resultado="";
		if (!$this->soloLectura) {
			$resultado = '<form name="' . $this->formulario_nombre . '" id="' . $this->formulario_nombre . '" action="' . $this->action . '" method="' . $this->method . '"  enctype="' . $this->enctype . '">';
		} else {
			$resultado = '<form name="' . $this->formulario_nombre . '" id="' . $this->formulario_nombre . '" action="" method=""  enctype="' . $this->enctype . '">';
		}
		return $resultado;
	}

	function cierreForm() {
		return '</form>';
	}

	function mostrarEnPresentacion(&$presentacion){
		$presentacion->asignarValor("Id_Titulo",$this->id . " -- " . $this->tituloPagina);
		$presentacion->asignarValor("Form",$this->inicioForm());
		$presentacion->asignarValor("FormCierre",$this->cierreForm());
		$presentacion->asignarValor("Scripts",$this->scripts() . $this->prepararScriptVariables());
		$presentacion->asignarValor("CamposOcultos",$this->camposOcultos());
	}

	function prepararScriptVariables($permitirDeshabilitados=false) {
		$resultado = '<script type="text/javascript">';
		if (isset($this->objDatos)) {
			foreach ( $this->objDatos->darVariables() as $id => $var ){
				if (($permitirDeshabilitados || $var->habilitada) && $var->campoHTML!="") {
				//str_replace(chr(13).chr(10),"<br/>",$str);

					$resultado .= 'agregarVariable("' . $var->tabla . '","' . $var->campoHTML . '","' . $var->labelMostrar . '","' . $var->valorPorDefecto . '","' . rawurlencode($var->textoAyuda) . '","' . '' . '","' . '' . '","' . '' . '","' . '' . '","' . $var->tipoDato . '","' . $var->requerida . '","' . $var->largoTotal . '","' . $var->decimales . '","' . $var->valoresPosibles . '",' . $this->codigoJSExpresionesValidacion ($var) . ',' . $this->codigoJSExpresionesFocus ($var) . ',"'. $var->habilitada . '","' . $var->visible . '");';
					if ($var->mostrarValor) {
						//$resultado .= 'asignarValor("' . $this->formulario_nombre . '","' . $var->campoHTML . '","' . str_replace(chr(13).chr(10),"\\n",$var->valor) . '");';
						$resultado .= 'asignarValor("' . $this->formulario_nombre . '","' . $var->campoHTML . '","' . str_replace(array(chr(13).chr(10),"\""),array("\\n","&quot;"),$var->valor) . '");';
					}
					$resultado .= 'asignarEstado("' . $var->campoHTML . '","' . ($var->habilitada==true) . '");';
					//asignarVisibilidadSeccion(nombreSeccion,estado)

					if ($var->tipoControl=="CHECKBOX" || $var->tipoControl=="RADIO") {
						$resultado .= 'asignarFuncion("' . $var->campoHTML . '","onclick","blurCampo");';
						$resultado .= 'asignarFuncion("' . $var->campoHTML . '","onmouseover","overCampo");';
						$resultado .= 'asignarFuncion("' . $var->campoHTML . '","onmouseout","outCampo");';
					}
				}
	        }
			$resultado .= '
					var i=0;
					for (i=0;i<variables.length;i++) {
							asignarFuncion(variables[i],"onblur","blurCampo");
							asignarFuncion(variables[i],"onfocus","focusCampo");
							asignarFuncion(variables[i],"onchange","changeCampo");
							asignarFuncion(variables[i],"onkeypress","keyPressCampo");
					}
				';
		}
		$resultado .= '</script>';

		return $resultado;

	}


/*
	$var->tipoControl;
	$var->mascara;
	$var->largoMascara;


	$var->visible;
	$var->habilitada;
*/

	function codigoJSExpresionesValidacion ($var) {
		$resultado="";
		if ($var->expresionesValidacion==null) {
			$resultado="\"\"";
		} else {
			if (is_array($var->expresionesValidacion)) {
				for ($i=0;$i<count($var->expresionesValidacion);$i++) {
					if ($resultado!="") {
						$resultado.=",";
					}
					$resultado.='"' . $var->expresionesValidacion[$i] . '"';
				}
			} else {
				$resultado.='"' . $var->expresionesValidacion . '"';
			}
			$resultado="new Array(" . $resultado. ")";
		}
		return $resultado;
	}

	function codigoJSExpresionesFocus ($var) {
		$resultado="";
		if ($var->expresionesFocus==null) {
			$resultado="\"\"";
		} else {
			if (is_array($var->expresionesFocus)) {
				for ($i=0;$i<count($var->expresionesFocus);$i++) {
					if ($resultado!="") {
						$resultado.=",";
					}
					$resultado.='"' . $var->expresionesFocus[$i] . '"';
				}
			} else {
				$resultado.='"' . $var->expresionesFocus . '"';
			}
			$resultado="new Array(" . $resultado. ")";
		}
		return $resultado;
	}

}
?>