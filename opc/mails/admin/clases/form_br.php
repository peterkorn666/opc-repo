<?PHP
require_once('form_class.php');
class form_br_class extends form_class
{
	var $paginaRegistro="";
	var $p;
	var $t;
	var $o="";
	var $od="";
	var $limite="";
	var $registrosPorPagina=20;
	var $maximoNumeroLinksPaginas=10;
	var $nombre_campo_agrupar;	
	var $funcion_encabezado_listado;	
	var $funcion_encabezado_grupo;
	var $funcion_fila_resultado;
	var $funcion_pie_grupo;
	var $funcion_totales;
	var $funcion_pie_listado;
	var $funcion_no_hay_registros;
	var $expresionOrdenPorDefecto;
	var $columnaOrdenPorDefecto;
	var $direccionOrdenPorDefecto;
	var $mostrarForm;
	var $mostrarResultado;

	function form_br_class($nombre="frmBuscar") {
		parent::form_class($nombre);
		$this->method="get";
		$this->accionPorDefecto="mostrarForm";
		$this->funcion_totales="\$this->totales";
		$this->filtro="(1=1)";
		$this->columnaOrdenPorDefecto=-1;
		$this->direccionOrdenPorDefecto=1;
		$this->expresionOrdenPorDefecto=null;
	}

function scripts(){
	$resultado = parent::scripts();
	$resultado .= '

		<script type="text/javascript">
		function PageQuery(q) {
			if(q.length > 1) this.q = q.substring(1, q.length);
			else this.q = null;

			this.keyValuePairs = new Array();

			if(this.q) {
				for(var i=0; i < this.q.split("&").length; i++) {
					this.keyValuePairs[i] = this.q.split("&")[i];
				}
			}

			this.getKeyValuePairs = function() { return this.keyValuePairs; }

			this.getValue = function(s) {
				for(var j=0; j < this.keyValuePairs.length; j++) {
					if(this.keyValuePairs[j].split("=")[0] == s)
					return this.keyValuePairs[j].split("=")[1];
				}
				return false;
			}

			this.setValue = function(s,v) {
				for(var j=0; j < this.keyValuePairs.length; j++) {
					if(this.keyValuePairs[j].split("=")[0] == s) {
						this.keyValuePairs[j]=s+"="+v;
						return true;
					}
				}
				this.keyValuePairs[j]=s+"="+v;
				return false;
			}


			this.removeValue = function(s) {
				for(var j=0; j < this.keyValuePairs.length; j++) {
					if(this.keyValuePairs[j].split("=")[0] == s) {
						this.keyValuePairs[j]="";
						return true;
					}
				}
				return false;
			}

			this.getParameters = function() {
				var a = new Array(this.getLength());
				for(var j=0; j < this.keyValuePairs.length; j++) {
					a[j] = this.keyValuePairs[j].split("=")[0];
				}
				return a;
			}

			this.getQueryString = function() {
				r="";
				for(var j=0; j < this.keyValuePairs.length; j++) {
					if (this.keyValuePairs[j]!="") {
						if (r!="") {
							r=r+"&";
						}
						r=r+this.keyValuePairs[j];
					}
				}
				return r;
			}

			this.getLength = function() { return this.keyValuePairs.length; }
		}

		function qs_sin_PR(){
			var page = new PageQuery(window.location.search);
			page.removeValue("pr");
			return location.href.split("?")[0] + "?" + page.getQueryString();
		}

		</script>

	';
	$resultado .= '
	<script type="text/javascript">
		var js_br = {
			elemento_singular: "registro",
			elemento_plural: "registros",
			elemento_articulo_singular: "el",
			elemento_articulo_plural: "los",
			formulario_nombre: "frmBuscar",
			formulario:null,
			variable_accion_nombre: "accion",
			variable_pr_nombre: "pr",
			variable_accion: null,
			variable_pr: null,
			pagina_registro: "#",
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
			agregar:function() {
				//location.href="' . $this->paginaRegistro . '?pr=" + escape(location.href);
				location.href="' . $this->paginaRegistro . '?pr=" + escape(qs_sin_PR());
				return false;
			},
			mostrarTodos:function() {
				this.variable_accion.value="mostrarTodos";
				this.formulario.submit();
			    return false;
			},
			buscar:function() {
			    this.formulario.elements["p"].value="";
			    this.formulario.elements["t"].value="";
				this.variable_pr.value=escape(qs_sin_PR());
			    this.formulario.submit();
			    return false;
			},
			mostrarForm:function() {
			    this.variable_accion.value="mostrarForm";
			    this.formulario.submit();
			    return false;
			},
			cambiarOrden:function(o,od) {
				this.formulario.elements["o"].value=o;
				this.formulario.elements["od"].value=od;
				this.formulario.elements["p"].value="";
				this.formulario.elements["t"].value="";
				this.formulario.submit();
				return false;
			},
			verPagina:function(p,t) {
				this.formulario.elements["p"].value=p;
			    this.formulario.elements["t"].value=t;
			    this.formulario.submit();
			    return false;
			},
			editar:function(id) {
			    //location.href= this.pagina_registro + "?accion=editar&id="+id+ "&pr=" + escape(location.href);
				location.href= this.pagina_registro + "?accion=editar&id="+id+ "&pr=" + escape(qs_sin_PR());
			    return false;
			},
			mostrar:function(id) {
				location.href= this.pagina_registro + "?accion=mostrar&id="+id+ "&pr=" + escape(qs_sin_PR());
			    return false;
			},
			confirmarAccion:function(nombreAccion,valorAccion,id,detalle) {
				if (confirm("Confirma " + nombreAccion + " " + this.elemento_articulo_singular + " " + this.elemento_singular + " \n" + detalle + "?")) {
					this.formulario.id.value=id;
					this.variable_accion.value=valorAccion;
					this.formulario.submit();
				}
				else {
					return false;
				}
			},
			seleccionarTodos:function() {
			    elementos=this.formulario.elements["Id[]"];
				if (elementos) {
					if (elementos.length) { // si es array
						for ( i=0 ; i < elementos.length ; i++ )
							elementos[i].checked=true;
					} else {
						elementos.checked=true;
					}
				}
				return false;
			},
			desSeleccionarTodos:function() {
			    elementos=this.formulario.elements["Id[]"];
				if (elementos) {
					if (elementos.length) { // si es array
						for ( i=0 ; i < elementos.length ; i++ )
							elementos[i].checked=false;
					} else {
						elementos.checked=false;
					}
				}
				return false;
			},			
			cambiarCheck:function(check) {
			
			    elemento=$(check); //requiere prototype
				if (elemento) {
					elemento.checked=(!elemento.checked);
				}
				return false;
			},			
			confirmarAccionSeleccionadas:function(nombreAccion,valorAccion) {
			    seleccionados=0;
			    elementos=this.formulario.elements["Id[]"];
				if (elementos) {
					if (elementos.length) { // si es array
						for ( i=0 ; i < elementos.length ; i++ )
							if (elementos[i].checked)
								seleccionados++;
						if (seleccionados>0) {
							if (confirm("Confirma " + nombreAccion + " " + seleccionados + " " + this.elemento_plural +"?")) {
								this.variable_accion.value=valorAccion;
								this.formulario.submit();
							}
							else {
								return false;
							}
						}
						else {
							alert("No hay " + this.elemento_plural + " con marca");
							return false;
						}
					} else {
						return this.confirmarAccion(nombreAccion,valorAccion,elementos.value,"");
					}
				}
				else {
					alert ("No hay " + this.elemento_plural + " con marca");
					return false;
				}
			},
			borrar:function(id,detalle) {
				this.formulario.id.value=id;
				return this.confirmarAccion("borrar","borrarUna",id,detalle);
			},
			confirmarBorrarSeleccionadas:function() {
				return this.confirmarAccionSeleccionadas("borrar","borrarSeleccionadas");
			}
		}
		js_br.inicializar();
		js_br.pagina_registro="' . $this->paginaRegistro . '";
		function agregar() {
			return js_br.agregar();
		}
		function seleccionarTodos() {
			return js_br.seleccionarTodos();
		}
		function desSeleccionarTodos() {
			return js_br.desSeleccionarTodos();
		}
		function mostrarTodos() {
			return js_br.mostrarTodos();
		}
		function buscar() {
			return js_br.buscar();
		}
		function mostrarForm() {
			return js_br.mostrarForm();
		}
		function cambiarOrden(o,od) {
			return js_br.cambiarOrden(o,od);
		}
		function verPagina(p,t) {
			return js_br.verPagina(p,t);
		}
		function editar(id) {
			return js_br.editar(id);
		}
		function mostrar(id) {
			return js_br.mostrar(id);
		}
		function borrar(id,detalle) {
			js_br.formulario.id.value=id;
			return js_br.confirmarAccion("borrar","borrarUna",id,detalle);
		}
		function confirmarBorrarSeleccionadas() {
			return js_br.confirmarAccionSeleccionadas("borrar","borrarSeleccionadas");
		}
		';
		if (MOSTRAR_POPUP_ADMIN && $this->mensaje!="") {
		    $resultado.= "\nalert(\"" . str_replace("\n","\\n",$this->mensaje) . "\");";
		}
		$resultado.='</script>';
		return $resultado;
}



	function camposOcultos() {
		$resultado=parent::camposOcultos();
		$resultado.="
		<input type='hidden' name='p' value='" . $this->p . "'/> 
		<input type='hidden' name='t' value='" . $this->t . "'/>
		<input type='hidden' name='o' value='" . $this->o . "'/>
		<input type='hidden' name='od' value='" . $this->od . "'/>
		"; //		// si queda el primero, al cambiar de busqueda
        if ($this->mostrarResultado){
			// variables
			foreach ( $this->objDatos->darVariables() as $id => $var ){
				if ($var->habilitada) {
					$resultado.="\n<input type='hidden' name='" . $var->campoHTML . "' value='" . $var->valor . "'/>";
				}
	        }
			//
        }
        return $resultado;
	}

	function leerDatos() {
		parent::leerDatos();
		$this->p=leerParametro("p");
		$this->t=leerParametro("t");
		$this->o=leerParametro("o",$this->columnaOrdenPorDefecto);
		$this->od=leerParametro("od",$this->direccionOrdenPorDefecto);
	}



	function condicionBuscar(){
		// variables
		$condicion="(1=1)";
		foreach ( $this->objDatos->darVariables() as $id => $var ){
			if ($var->campoSQL) {
				if ($var->buscar) {
					switch($var->tipoDato) {
						case 1: // string
							$condicionTemp=bd::condicionTexto($var->expresionBuscar ,trim($var->valor));
							if ($condicionTemp!="") {
								$condicion.=" AND " . $condicionTemp;
							}
						break;
						case 2: // int
							if (is_numeric($var->valor) ) {
								$condicion.=" AND " . $var->expresionBuscar . "=" . $var->valor;
							} 
						break;
						case 3: // bool
							if (!is_null($var->valor)) {
								$condicion.=" AND " . $var->expresionBuscar . "=" . $var->valor;
							} 
						break;
						case 4: // dataTime *** REVISAR ****
							if (!is_null($var->valor)) {
								$condicion.=" AND " . $var->expresionBuscar . "='" . $var->valor & "'";
							}
						break;

// 5	excluyentes	Opciones excluyentes
// 6	no_excluyentes	Opciones no excluyentes

						case 7: // FECHA *** REVISAR ****
							if (!is_null($var->valor)) {
								$condicion.=" AND " . $var->expresionBuscar . "='" . $var->valor & "'";
							}
						break;
						case 8: // hora *** REVISAR ****
							if (!is_null($var->valor)) {
								$condicion.=" AND " . $var->expresionBuscar . "='" . $var->valor & "'";
							}
						break;
						case 9: // email *** REVISAR ****
							if (!is_null($var->valor)) {
								$condicion.=" AND " . $var->expresionBuscar . "='" . $var->valor & "'";
							}
						break;

// 10	file
					}
				}
			}
        }
		//
		if ($this->filtro!=""){
			$condicion="(" . $this->filtro . ") AND (" . $condicion . ")";
		}



		return $condicion;
	}

	function ordenBuscar(){
		$ordenar="";
		if ($this->o!=-1) {
			foreach ( $this->objDatos->darVariables() as $id => $var ){
				if ($var->ordenar && $id==$this->o) {
					$ordenar= $var->expresionOrdenar ;
					if ($this->od==2) {
						$ordenar.=" DESC";
					}
				}
			}
		} else {
			$ordenar=$this->expresionOrdenPorDefecto;
		}
		return $ordenar;
	}
	
	function procesar() {
		parent::procesar();

        switch($this->accion){
			case "mostrarForm":
				$this->mostrarForm=true;
				$this->mostrarResultado=false;
				$this->accion="buscar";
				break;
			case "mostrarTodos":
				$this->objDatos->borrarDatosVariables();
				$this->p="";
				$this->t="";
				$this->accion="buscar";
				break;
			case "buscar":
				break;
			case "cambiarOrden":
				break;
			case "borrarUna":
				$this->borrarRegistro();
				$this->accion="buscar";
				break;
			case "borrarSeleccionadas":
				$Id=leerParametro("Id");
				$resultado=true;
				for ($i=0;$i<count($Id);$i++) {
					$this->id=$Id[$i];
					$this->borrarRegistro();
				}
				$this->accion="buscar";
				break;
        }
        $this->accionAnterior=$this->accion;
	}

	function borrarRegistro() {
		$validado=true;
		if ($this->funcion_validar_eliminacion!="" && function_exists($this->funcion_validar_eliminacion)) {
			$validado=$validado && call_user_func($this->funcion_validar_eliminacion);
		}
		if ($validado) {
			if (borrarRegistro($this->id,$this->mensaje,$this->tabla,$this->campoClave,$this->conexion)) {
				$this->mensaje.= "\n" . $this->elemento_singular . " " . $this->id . " eliminado con éxito";
				if ($this->funcion_posterior_eliminacion!="" && function_exists($this->funcion_posterior_eliminacion)) {
					call_user_func($this->funcion_posterior_eliminacion);
				}
			}
		}
	}

	function mostrarEnPresentacion($presentacion){
		$this->mostrarResultado($presentacion);
		parent::mostrarEnPresentacion($presentacion);
	}

	function mostrarResultado($presentacion) {
		if ($this->mostrarForm){
			$this->asignarValoresVariables($presentacion);
			$presentacion->parse("FormBuscador", true);
		} else{
			$presentacion->asignarValor("FormBuscador","");
		}
		if ($this->mostrarResultado){
			// orden
			
			foreach ( $this->objDatos->darVariables() as $id => $var ){
				if ($var->orden) {
					//$presentacion->asignarValor("Orden_" . $var->labelTemplate,$this->orden($id,$this->o,$this->od));
					$presentacion->asignarValor("Orden_" . $var->labelTemplate . "_asc",$this->orden_asc($id,$this->o,$this->od));
					$presentacion->asignarValor("Orden_" . $var->labelTemplate . "_desc",$this->orden_desc($id,$this->o,$this->od));
				}
			}
			$this->paginar($presentacion);
			$presentacion->parse("Resultado", true);
		} else{
			$presentacion->asignarValor("Resultado","");
		}
	}


	function paginar(&$presentacion)
	{

	  // inicializacion de variables usadas en la paginacion
	  $mostrados=0;
	  if ($this->p==0)
	    $this->p=1;
	  $primero=0;
	  $totalpaginas=0;
	  $cantidadRegistros=0;
	  $i=0;
	  // CALCULA EL PRIMER Y ULTIMO REGISTRO A MOSTRAR
	  $primero=($this->p-1)*$this->registrosPorPagina;
	  $ultimo=$primero + $this->registrosPorPagina;

	  // REALIZA LA CONSULTA
	  $primeroConsulta="";
	  $ultimoConsulta="";
	  if ($this->nombre_campo_agrupar=="") {
		$primeroConsulta=$primero;
		$ultimoConsulta=$ultimo;
	  }

	 $RS=$this->objDatos->buscarDatos($this->objDatos->darNombresCampos(),$this->condicionBuscar(),$this->ordenBuscar(),$primeroConsulta,$ultimoConsulta,$this->limite);

	  if ($RS) {
		if ($primeroConsulta==$primero) {
			$primeroAux=0;
		} else {
			$primeroAux=$primero;
		}
	    $auxAgrupar="";
	    if ($this->t==0 || $this->t=="" || $this->nombre_campo_agrupar!="") {
		  $this->t=0;
	      if ($this->nombre_campo_agrupar!="") {
			// cuenta cantidad de registros cuando hay agrupados
	        $i=0;
	        $j=0;
	        while ($row = $RS->darSiguienteFila()) {
	          if ($auxAgrupar!=$row[$this->nombre_campo_agrupar]) {
	            $auxAgrupar=$row[$this->nombre_campo_agrupar];
	            if ($i==$primero)
	              $primeroAux=$j;
	            $i++;
	          }
	          $j++;
	        }
			$cantidadRegistros=$i;
			$cantidadRegistrosAgrupados=$i;
	      } else
	      {
	        $cantidadRegistros=$RS->filas;
			$cantidadRegistrosAgrupados=$cantidadRegistros;
	      }
	    } else {
	      $cantidadRegistros=$this->t;
		  $cantidadRegistrosAgrupados=$cantidadRegistros;
	    }
	  } else {
	    $cantidadRegistros=0;
		$cantidadRegistrosAgrupados=$cantidadRegistros;
		$this->mensaje="No se pudieron obtener los datos";
	  }

	  // se mueve hasta el primer registro
	  if ($cantidadRegistros>0 && $RS->filas>$primeroAux-1) {
	    $RS->irAFila($primeroAux);
	  }

	  $totalpaginas=$cantidadRegistrosAgrupados/$this->registrosPorPagina;
	  if (( $cantidadRegistrosAgrupados % $this->registrosPorPagina)>0)
	    $totalpaginas=floor($totalpaginas) + 1;
	  $i=$primero;
	  $iAnterior=$i;
	  $rowAnterior=null;
	  if (!($cantidadRegistrosAgrupados>$i && $cantidadRegistrosAgrupados>0)) {
	    $cantidadRegistros=0;
		$cantidadRegistrosAgrupados=0;
		eval($this->funcion_no_hay_registros . "(\$presentacion);");
	  }
	  else {
	    if ($cantidadRegistros>0) {
		  if (!is_null($this->funcion_encabezado_listado)) {
			eval($this->funcion_encabezado_listado . "(\$presentacion);");
		  }
	      if ($this->nombre_campo_agrupar!="") {
	        $auxAgrupar="";
	        // muestra los valores de los campos
	        while ( ($row = $RS->darSiguienteFila())  && ($i<$ultimo) ) {
	          if ($auxAgrupar!=$row[$this->nombre_campo_agrupar]) {
	            if ($i!=$primero && !is_null($this->funcion_pie_grupo)) {
	               eval($this->funcion_pie_grupo . "(\$presentacion,\$rowAnterior,\$iAnterior);");
	            }
	            $auxAgrupar=$row[$this->nombre_campo_agrupar];
	            eval($this->funcion_encabezado_grupo . "(\$presentacion,\$row,\$i);");
				  $iAnterior=$i;
				  $rowAnterior=$row;
				  $i++;
				  $mostrados++;
	          }
	          eval($this->funcion_fila_resultado . "(\$presentacion,\$row,\$i);");
	        }
			if ($i!=$primero && !is_null($this->funcion_pie_grupo)) {
			   eval($this->funcion_pie_grupo . "(\$presentacion,\$rowAnterior,\$iAnterior);");
			}
	      } else
	      {
	        while ( ($row = $RS->darSiguienteFila())  && ($i<$ultimo) ) {
	          eval($this->funcion_fila_resultado . "(\$presentacion,\$row,\$i);");
	          $i++;
			  $mostrados++;
	        }
	      }
		  if (!is_null($this->funcion_pie_listado)) {
			eval($this->funcion_pie_listado . "(\$presentacion);");
		  }
	    } else {
			eval($this->funcion_no_hay_registros . "(\$presentacion);");
		}
	  }
	  if (!is_null($this->funcion_totales)) {
		  eval($this->funcion_totales . "(\$presentacion,$cantidadRegistrosAgrupados,$primero,$totalpaginas,$i);");
	  }

	  return $mostrados;
	}


	function totales(&$presentacion,$cantidadRegistros,$primero,$totalpaginas,$i) {
		if($cantidadRegistros==0){
			$presentacion->asignarValor("HayResultado","");
		} else {
			$presentacion->asignarValor("NoHayResultado","");
			$anterior="";
			$siguiente="";
			$totalRegistros="Total: " .$cantidadRegistros. " Registros.";
			if ($cantidadRegistros >= $i-$primero+1 ) {
				$totalRegistros.=" Mostrando desde " .($primero + 1). " hasta " . ( $i). " ";
				// hace links para todas las paginas si hay más de una página
				  $resultado="";
				  $primeraMostrar=max(1,($this->p-$this->maximoNumeroLinksPaginas/2));
				  $ultimaMostrar=min($totalpaginas,$this->p+$this->maximoNumeroLinksPaginas/2);
				  for ($i=$primeraMostrar;$i<=$ultimaMostrar;$i++) {
					if ($this->p==$i) {
						$resultado.="[" .$i. "]";
					} else {
						$resultado.="<A HREF=# onclick='return verPagina(".$i. "," . $cantidadRegistros . ");' >[" .$i. "]</A> ";
					}
				  }
				  if ($primeraMostrar>1) {
					if ($primeraMostrar>2) {
						$resultado="... " . $resultado;
					}
					$resultado="<A HREF=# onclick='return verPagina(". (1) . "," . $cantidadRegistros . ");' >[1]</A> " . $resultado;
				  }
				  if ($ultimaMostrar<$totalpaginas) {
					if ($ultimaMostrar<$totalpaginas-1) {
						$resultado.=" ...";
					}
					$resultado.=" <A HREF=# onclick='return verPagina(". ($totalpaginas) . "," . $cantidadRegistros . ");' >[".$totalpaginas."]</A> " ;
				  }
				  $presentacion->asignarValor("Pagina",$resultado);
				  $presentacion->parse("PaginarResultadoPaginas", true);
			   // si corresponde, hace un link a la página anterior
				if ($this->p > 1) {
					$anterior="<A HREF=# onclick='return verPagina(". (1) . "," . $cantidadRegistros . ");' >|&lt;</A> ";
					$anterior.="<A HREF=# onclick='return verPagina(". ($this->p-1) . "," . $cantidadRegistros . ");' >&lt;</A> ";
				} else {
					$anterior="|&lt; &lt; ";
				}
				// si corresponde, hace un link a la página siguiente
				if ($this->p < $totalpaginas) {
					$siguiente="<A HREF=# onclick='return verPagina(". ($this->p+1) . "," . $cantidadRegistros . ");' >&gt;</A> ";
					$siguiente.="<A HREF=# onclick='return verPagina(". ($totalpaginas) . "," . $cantidadRegistros . ");' >&gt;|</A> ";
				} else {
					$siguiente=" &gt; &gt;|";
				}
			}
			else{
				$totalRegistros.=" Todos desplegados.";
				$presentacion->asignarValor("PaginarResultadoPaginas","");
			}
			$presentacion->asignarValor("TotalRegistros",$totalRegistros);
			$presentacion->asignarValor("Anterior",$anterior);
			$presentacion->asignarValor("Siguiente",$siguiente);
			$presentacion->parse("PaginarResultado", true);
			$presentacion->parse("HayResultado", true);
		}
	}


	// genera el icono para ordenar 
	function orden($campo,$columna=null,$direccion=null) {
		global $o,$od; // $o = numero de columna  a usar , $od direccion 1=asc 2=desc
		$resultado="";
		if (is_null($columna)  && isset($o)) {
			$columna=$o;
		}
		if (is_null($direccion) && isset($od)) {
			$direccion=$od;
		}
		if ($campo==$columna) {
			$nuevoOrden="1";
			if ($campo==$columna && $direccion==1) {
				$nuevoOrden="2";
			}
			$resultado.= '<a href="#" onClick="return cambiarOrden(\'' . $campo . '\',' . $nuevoOrden . ');">';
			if ($nuevoOrden==2) {
					$resultado.= '<img src="' . RAIZ . 'img/o_desc.gif" width="11" height="10" border="0" align="middle" />';
			} else {
					$resultado.= '<img src="' . RAIZ . 'img/o_asc.gif" width="11" height="10" border="0" align="middle" />';
			}
			$resultado.= '</a>';
		} else {
			$resultado.= '<a href="#" onClick="return cambiarOrden(\'' . $campo . '\',1);">';
			$resultado.= '<img src="' . RAIZ . 'img/o_asc.gif" width="11" height="8" border="0" align="middle" />';
			$resultado.= '</a>';
			$resultado.= '<a href="#" onClick="return cambiarOrden(\'' . $campo . '\',2);">';
			$resultado.= '<img src="' . RAIZ . 'img/o_desc.gif" width="11" height="8" border="0" align="middle" />';
			$resultado.= '</a>';
		}
		return $resultado;
	}
	
// genera el icono para ordenar ascendente
	function orden_asc($campo,$columna=null,$direccion=null) {
		global $o,$od; // $o = numero de columna  a usar , $od direccion 1=asc 2=desc
		$resultado="";
		if (is_null($columna)  && isset($o)) {
			$columna=$o;
		}
		if (is_null($direccion) && isset($od)) {
			$direccion=$od;
		}
		if ($campo==$columna) {
			$nuevoOrden="1";
			if ($campo==$columna && $direccion==1) {
				$nuevoOrden="2";
			}
			if ($nuevoOrden==2) {
					$resultado.= '<img src="' . RAIZ . 'img/o_asc_on.gif" width="36" height="8" border="0" align="middle" />';
			} else {
					$resultado.= '<a href="#" onClick="return cambiarOrden(\'' . $campo . '\',' . $nuevoOrden . ');">';
					$resultado.= '<img src="' . RAIZ . 'img/o_asc.gif" width="36" height="8" border="0" align="middle" />';
					$resultado.= '</a>';
			}
			
		} else {
			$resultado.= '<a href="#" onClick="return cambiarOrden(\'' . $campo . '\',1);">';
			$resultado.= '<img src="' . RAIZ . 'img/o_asc.gif" width="36" height="8" border="0" align="middle" />';
			$resultado.= '</a>';
		}
		return $resultado;
	}
	
// genera el icono para ordenar ascendente
	function orden_desc($campo,$columna=null,$direccion=null) {
		global $o,$od; // $o = numero de columna  a usar , $od direccion 1=asc 2=desc
		$resultado="";
		if (is_null($columna)  && isset($o)) {
			$columna=$o;
		}
		if (is_null($direccion) && isset($od)) {
			$direccion=$od;
		}
		if ($campo==$columna) {
			$nuevoOrden="1";
			if ($campo==$columna && $direccion==1) {
				$nuevoOrden="2";
			}
			if ($nuevoOrden==2) {
					$resultado.= '<a href="#" onClick="return cambiarOrden(\'' . $campo . '\',' . $nuevoOrden . ');">';
					$resultado.= '<img src="' . RAIZ . 'img/o_desc.gif" width="36" height="10" border="0" align="middle" />';
					$resultado.= '</a>';
			} else {
				$resultado.= '<img src="' . RAIZ . 'img/o_desc_on.gif" width="36" height="10" border="0" align="middle" />';
			}
			
		} else {
			$resultado.= '<a href="#" onClick="return cambiarOrden(\'' . $campo . '\',2);">';
			$resultado.= '<img src="' . RAIZ . 'img/o_desc.gif" width="36" height="10" border="0" align="middle" />';
			$resultado.= '</a>';
		}
		return $resultado;
	}
}
?>