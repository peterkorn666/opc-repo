<?PHP
require_once('form_class.php');
class form_abm_class extends form_class
{
	var $funcion_previa_mostrar;
	var $funcion_previa_alta;
	var $funcion_validar_alta;
	var $funcion_posterior_alta;
	var $funcion_previa_edicion;
	var $funcion_validar_edicion;
	var $funcion_posterior_edicion;
	var $permitirMostrar;
	var $permitirAgregar;
	var $permitirEditar;
	var $permitirEliminar;

	function form_abm_class($nombre="formABM") {
		parent::form_class($nombre);
		$this->method="post";
		$this->enctype="multipart/form-data";
		$this->accionPorDefecto="alta";
		$this->permitirMostrar=true;
		$this->permitirAgregar=true;
		$this->permitirEditar=true;
		$this->permitirEliminar=true;
	}

	function scripts(){
	$resultado = parent::scripts();
	$resultado .= '

		<script type="text/javascript">

		var js_abm = {
			elemento_singular: "registro",
			elemento_plural: "registros",
			elemento_articulo_singular: "el",
			elemento_articulo_plural: "los",
			formulario_nombre: "formABM",
			formulario:null,
			variable_accion_nombre: "accion",
			variable_pr_nombre: "pr",
			variable_accion: null,
			variable_pr: null,
			listo: false,
			inicializar:function() {
				this.formulario=document.forms[this.formulario_nombre];
				if (this.formulario) {
					this.variable_accion=this.formulario.elements[this.variable_accion_nombre];
					this.variable_pr=this.formulario.elements[this.variable_pr_nombre];
					if (this.variable_accion) {
						this.listo=true;
					} else {
					}
				}
			},
			aceptar:function(){
				if (this.validar()) {
					this.formulario.submit();
				} else {

				}

			},
			confirmarAccion:function(nombreAccion,valorAccion,id,detalle) {
				if (pedirConfirmacion("Confirma " + nombreAccion + " " + this.elemento_articulo_singular + " " + this.elemento_singular + " \n" + detalle + "?")) {
					this.formulario.id.value=id;
					this.variable_accion.value=valorAccion;
					this.formulario.submit();
				}
				else {
					return false;
				}
			},
			borrar:function(id,detalle) {
				this.formulario.id.value=id;
				return confirmarAccion("borrar","borrarUna",id,detalle);
			},
			cancelar:function() {
				this.variable_accion.value="cancelar";
				this.formulario.submit();
			},
			validar:function() {
				return true;
			}
		};

		js_abm.inicializar();
		function aceptar() {
			return js_abm.aceptar();
		}
		function cancelar() {
			return js_abm.cancelar();
		}
		function borrar() {
			js_abm.formulario.id.value=id;
			return js_abm.confirmarAccion("borrar","borrarUna",id,detalle);
		}
		';

		if (MOSTRAR_POPUP_ADMIN && $this->mensaje!="") {
		    $resultado.="\nalert(\"". str_replace("\n","\\n",$this->mensaje) . "\");";
		}

		if ($this->redirigir && $this->paginaRetorno) {
		    $resultado.="\nlocation.href='" . $this->paginaRetorno . "'";
		}

		$resultado.='</script>';

		return $resultado;

	}


	function camposOcultos(){
		$resultado=parent::camposOcultos();
		return $resultado;
	}

	function leerDatos() {
		parent::leerDatos();
	}

	function procesar() {
		parent::procesar();
	    switch($this->accion){
			case "alta":
				if ($this->permitirAgregar) {
					$this->accion="altaAceptar";
					$this->mostrar=1;
					if ($this->funcion_previa_alta!="" && function_exists($this->funcion_previa_alta)) {
						call_user_func($this->funcion_previa_alta);
					}
				} else {
					$this->mensaje="No se pueden crear registros nuevos";
					$this->mostrar=2;
				}
				break;
			case "altaAceptar":
				if ($this->permitirAgregar) {
					$this->mostrar=2;
					$validado=$this->validarDatos();
					if ($this->funcion_validar_alta!="" && function_exists($this->funcion_validar_alta)) {
						$validado=$validado && call_user_func($this->funcion_validar_alta);
					}
					if ($validado) {
						$this->nuevoId=$this->agregarRegistro();
						if ($this->nuevoId) {
							$this->accion="editarAceptar";
							$this->mostrar=1;
							$this->redirigir=true;
							if ($this->funcion_posterior_alta!="" && function_exists($this->funcion_posterior_alta)) {
								call_user_func($this->funcion_posterior_alta);
							}
						}
					}
				} else {
					$this->mensaje="No se pueden crear registros nuevos";
					$this->mostrar=2;
				}
				break;
			case "mostrar":
				if ($this->permitirMostrar) {
					$continua=true;
					if ($this->funcion_previa_mostrar!="" && function_exists($this->funcion_previa_mostrar)) {
						$continua=call_user_func($this->funcion_previa_mostrar);
					}
					if ($continua && $this->id!="") {
						if ($this->leerDatosBase()) {
							$this->accion="cancelar";
							$this->mostrar=1;
						} else {
							$this->mostrar=2;
						}
					}
				} else {
					$this->mensaje="No se pueden mostrar registros";
					$this->mostrar=2;
				}
				break;
			case "editar":
				if ($this->permitirEditar) {
					$continua=true;
					if ($this->funcion_previa_mostrar!="" && function_exists($this->funcion_previa_mostrar)) {
						$continua=call_user_func($this->funcion_previa_mostrar);
					}
					if ($continua && $this->id!="") {
						if ($this->leerDatosBase()) {
							$this->accion="editarAceptar";
							$this->mostrar=1;
						} else {
							$this->mostrar=2;
						}
						if ($this->funcion_previa_edicion!="" && function_exists($this->funcion_previa_edicion)) {
							call_user_func($this->funcion_previa_edicion);
						}
					}
				} else {
					$this->mensaje="No se pueden editar registros";
					$this->mostrar=2;
				}
				break;
			case "editarAceptar":
				if ($this->permitirEditar) {
					$this->mostrar=2;
					$validado=$this->validarDatos();
					if ($this->funcion_validar_edicion!="" && function_exists($this->funcion_validar_edicion)) {
						$validado=$validado && call_user_func($this->funcion_validar_edicion);
					}
					if ($validado) {
						if ($this->actualizarRegistro()) {
							$this->mostrar=1;
							$this->redirigir=true;
							if ($this->funcion_posterior_edicion!="" && function_exists($this->funcion_posterior_edicion)) {
								call_user_func($this->funcion_posterior_edicion);
							}
						}
					}
				} else {
					$this->mensaje="No se pueden editar registros";
					$this->mostrar=2;
				}
				break;
			case "eliminar":
				if ($this->permitirEliminar) {
					$this->mostrar=2;
					$validado=true;
					if ($this->funcion_validar_eliminacion!="" && function_exists($this->funcion_validar_eliminacion)) {
						$validado=$validado && call_user_func($this->funcion_validar_eliminacion);
					}
					if ($validado) {
						if ($this->borrarRegistro()) {
							$this->mostrar=1;
							$this->redirigir=true;
							if ($this->funcion_posterior_eliminacion!="" && function_exists($this->funcion_posterior_eliminacion)) {
								call_user_func($this->funcion_posterior_eliminacion);
							}
						}
					}
				} else {
					$this->mensaje="No se pueden eliminar registros";
					$this->mostrar=2;
				}
				break;
			case "cancelar":
				if ($this->accionAnterior=="altaAceptar" || $this->accionAnterior=="editarAceptar") {
				}
				if (($this->paginaRetorno!="")) {
					header("location:" . $this->paginaRetorno);
				}
				else {
					$this->mostrar=0;
				}
				break;
			case "error":
				$this->mostrar=2;
				break;
			default:
				;
        } // switch

        $this->accionAnterior=$this->accion;

		switch($this->accionAnterior){
			case "altaAceptar":
				$this->tituloPagina="Alta";
				break;
			case "editarAceptar":
				$this->tituloPagina="Edici&oacute;n";
				break;
			case "alta":
				$this->tituloPagina="Alta";
				break;
			case "mostrar":
				$this->tituloPagina="Visualizaci&oacute;n";
				break;
		}
	}

	function agregarRegistro($sobreEscribirAutonumerico=false) {
		return $this->objDatos->insert($sobreEscribirAutonumerico);
		//return agregarRegistro($this->mensaje,$this->tabla,$this->campoClave,$this->darCampos(),$this->conexion);
	}

	function actualizarRegistro() {
		return $this->objDatos->update($this->id);
		//return actualizarRegistro($this->id,$this->mensaje,$this->tabla,$this->campoClave,$this->darCampos(),$this->conexion);
	}

	function borrarRegistro() {
		return $this->objDatos->delete($this->id);
		//return borrarRegistro($this->id,$this->mensaje,$this->tabla,$this->campoClave,$this->conexion);
	}

	function leerDatosBase() {
		return $this->objDatos->select($this->id);
	}

	function validarDatos() {
		$resultado=true;
	    $this->mensaje.="";
	    return $resultado;
	}

}
?>