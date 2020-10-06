<?PHP
// hace uso de objetos de la clase bd

class grilla {
	var $p; // pagina inicial
	var $t; // total registros
	var $tp; // total de páginas
	var $nombre;
	var $tipo;
	var $rs;
	var $registrosPorPagina;
	var $registrosPorPaginaPorDefecto;
	var $nombre_campo_agrupar;
	var $mensaje;
	var $plantilla;
	var $bloque_grilla;
	var $bloque_encabezado;
	var $bloque_resultados;
	var $bloque_encabezado_grupo;
	var $bloque_fila;
	var $bloque_pie_grupo;
	var $bloque_paginas;
	var $bloque_pagina;
	var $bloque_pie;
	var $bloque_nohay;
	var $funcion_encabezado;
	var $funcion_encabezado_grupo;
	var $funcion_fila;
	var $funcion_pie_grupo;
	var $funcion_pie;
	var $funcion_paginas;
	var $funcion_resultado;
	
	function grilla($nombre="") {
		$this->nombre=$nombre;
		$this->tipo="rs";
		$this->registrosPorPaginaPorDefecto=20;
		$this->funcion_encabezado=array(&$this,"funcionEncabezadoTabla");
		$this->funcion_encabezado_grupo=array(&$this,"funcionEncabezadoGrupoTabla");
		$this->funcion_fila=array(&$this,"funcionFilaTabla");
		$this->funcion_pie_grupo=array(&$this,"funcionPieGrupoTabla");
		$this->funcion_pie=array(&$this,"funcionPieTabla");
		$this->funcion_paginas=array(&$this,"funcionPaginasTabla");
		$this->funcion_resultado=array(&$this,"funcionResultadoTabla");
		$this->plantilla=null;
		$this->bloque_grilla=$nombre ."Grilla" ;
			$this->bloque_resultados=$nombre ."GrillaResultados";
				$this->bloque_encabezado=$nombre ."GrillaEncabezado" ;
					$this->bloque_encabezado_grupo=$nombre ."GrillaEncabezadoGrupo" ;
						$this->bloque_fila=$nombre ."GrillaFila" ;
					$this->bloque_pie_grupo=$nombre ."GrillaPieGrupo" ;
				$this->bloque_pie=$nombre ."GrillaPie" ;
				$this->bloque_paginas=$nombre ."GrillaPaginas" ;
					$this->bloque_pagina=$nombre ."GrillaPagina" ;
			$this->bloque_nohay=$nombre ."GrillaNoHay";
	}

	function asignarPlantilla($plantilla,$bloque_encabezado=null,$bloque_resultados=null,$bloque_encabezado_grupo=null,$bloque_fila=null,$bloque_pie_grupo=null,$bloque_paginas=null,$bloque_pagina=null,$bloque_pie=null,$bloque_nohay=null,$funcion_fila=null) {
		$this->plantilla=$plantilla;
		if ($bloque_encabezado!=null) {
			$this->bloque_encabezado=$bloque_encabezado;
		}
		if ($bloque_resultados!=null) {
			$this->bloque_resultados=$bloque_resultados;
		}
		if ($bloque_encabezado_grupo!=null) {
			$this->bloque_encabezado_grupo=$bloque_encabezado_grupo;
		}
		if ($bloque_fila!=null) {
			$this->bloque_fila=$bloque_fila;
		}
		if ($bloque_pie_grupo!=null) {
			$this->bloque_pie_grupo=$bloque_pie_grupo;
		}
		if ($bloque_paginas!=null) {
			$this->bloque_paginas=$bloque_paginas;
		}
		if ($bloque_pagina!=null) {
			$this->bloque_pagina=$bloque_pagina;
		}
		if ($bloque_pie!=null) {
			$this->bloque_pie=$bloque_pie;
		}
		if ($bloque_nohay!=null) {
			$this->bloque_nohay=$bloque_nohay;
		}

		$this->funcion_encabezado=array(&$this,"funcionEncabezadoPlantilla");
		$this->funcion_encabezado_grupo=array(&$this,"funcionEncabezadoGrupoPlantilla");
		if ($funcion_fila!=null) {
			$this->funcion_fila=$funcion_fila;
		} else {
			$this->funcion_fila=array(&$this,"funcionFilaPlantilla");
		}
		$this->funcion_pie_grupo=array(&$this,"funcionPieGrupoPlantilla");
		$this->funcion_paginas=array(&$this,"funcionPaginasPlantilla");
		$this->funcion_pie=array(&$this,"funcionPiePlantilla");
		$this->funcion_no_hay=array(&$this,"funcionNoHayPlantilla");
		$this->funcion_resultado=array(&$this,"funcionResultadoPlantilla");
	}
	
	function mostrarCampos() {
		switch($this->tipo) {
			case "rs":
				$campos=$this->rs->darCampos();
				foreach($campos as $f) {
					$this->plantilla->set_var( $f,$f);
				}
			break;
			case "arr":
				//$campos=array_keys($this->rs);
				//foreach($campos as $f) {
				//	$this->plantilla->set_var( $f,$f);
				//}
			break;
		}
	}

	function mostrarValores($row) {
		switch($this->tipo) {
			case "rs":
				$campos=$this->rs->darCampos();
				foreach($campos as $f) {
					$this->plantilla->set_var( $f,$row[$f]);
				}
			break;
			case "arr":
				$campos=$row->darCampos();
				foreach($campos as $f=> $valor) {
					$this->plantilla->set_var($f,$valor);
				}
			break;
		}
	}
	
	function paginar($registrosPorPagina=null,$primeraPagina=1,$campoAgrupar="") {
		switch($this->tipo) {
			case "rs":
				$this->paginarRS($registrosPorPagina,$primeraPagina,$campoAgrupar);
			break;
			case "arr":
				$this->paginarArr($registrosPorPagina,$primeraPagina,$campoAgrupar);
			break;
		}
		
	}
	
	function paginarRS($registrosPorPagina=null,$primeraPagina=1,$campoAgrupar="") {

		if ($registrosPorPagina==null) {
			$this->registrosPorPagina=$this->registrosPorPaginaPorDefecto;
		} else {
			$this->registrosPorPagina=$registrosPorPagina;
		}
		$this->p=$primeraPagina;
		if ($this->nombre_campo_agrupar==null || $this->nombre_campo_agrupar=="") {
			$this->nombre_campo_agrupar=$campoAgrupar;
		}

		// inicializacion de variables usadas en la paginacion
		$mostrados=0;
		$primero=0;
		$this->tp=0;
		$cantidadRegistros=0;
		$i=0;

		$this->mensaje="";

		// CALCULA EL PRIMER Y ULTIMO REGISTRO A MOSTRAR
		$primero=($this->p-1)*$this->registrosPorPagina;
		$ultimo=$primero + $this->registrosPorPagina;

		$this->t=$this->rs->filas;
		if ($this->t>0) {
		    $primeroAux=$primero;
		    $auxAgrupar="";
			// cuenta registros agrupados
			if ($this->nombre_campo_agrupar!="") {
				$i=0;
				$j=0;
				while ($row = $this->rs->darSiguienteFila()) {
					if ($auxAgrupar!=$row[$this->nombre_campo_agrupar]) {
						$auxAgrupar=$row[$this->nombre_campo_agrupar];
						if ($i==$primero) {
							$primeroAux=$j;
						}
						$i++;
					}
					$j++;
				}
				$this->t=$i;
			}
			// se mueve hasta el primer registro
			if ($this->rs->filas>$primeroAux-1 && $this->rs->filas<$primeroAux) {
				$this->rs->irAFila($primeroAux);
			} else {
				$primero=0;
				$primeroAux=0;
				$this->rs->irAFila($primeroAux);
				$this->mensaje="Número de página incorrecto";
			}
			$this->tp=$this->t/$this->registrosPorPagina;
			if (($this->t % $this->registrosPorPagina)>0) {
				$this->tp=floor($this->tp) + 1;
			}
			$i=$primero;
			$iAnterior=$i;
			$rowAnterior=null;
			$auxAgrupar="";
			$mostrados=0;
			ejecutar($this->funcion_encabezado);
			while ( ($row = $this->rs->darSiguienteFila())  && ($mostrados<$this->registrosPorPagina) ) {
				if ($this->nombre_campo_agrupar!=null && $this->nombre_campo_agrupar!="") {
					if ($auxAgrupar!=$row[$this->nombre_campo_agrupar]) {
						if ($i!=$primero) {
							ejecutar($this->funcion_pie_grupo,$rowAnterior,$iAnterior);
						}
						$auxAgrupar=$row[$this->nombre_campo_agrupar];
						ejecutar($this->funcion_encabezado_grupo ,$row,$i);
						$mostrados++;
					}
				} else {
					$mostrados++;
				}
				ejecutar($this->funcion_fila ,$this->plantilla, $row,$i);
				$iAnterior=$i;
				$rowAnterior=$row;
				$i++;
			}
			if ($this->nombre_campo_agrupar!=null && $this->nombre_campo_agrupar!="" && $i!=$primero) {
				ejecutar($this->funcion_pie_grupo,$rowAnterior,$iAnterior);
			}
			ejecutar($this->funcion_pie);
			ejecutar($this->funcion_paginas ,$this->t,$primero,$this->tp,$this->p,$mostrados);
		} else {
		}	
		ejecutar($this->funcion_resultado ,$mostrados);
		return $mostrados;
	}

	function paginarArr($registrosPorPagina=null,$primeraPagina=1,$campoAgrupar="") {

		if ($registrosPorPagina==null) {
			$this->registrosPorPagina=$this->registrosPorPaginaPorDefecto;
		} else {
			$this->registrosPorPagina=$registrosPorPagina;
		}
		$this->p=$primeraPagina;
		if ($this->nombre_campo_agrupar==null || $this->nombre_campo_agrupar=="") {
			$this->nombre_campo_agrupar=$campoAgrupar;
		}

		// inicializacion de variables usadas en la paginacion
		$mostrados=0;
		$primero=0;
		$this->tp=0;
		$cantidadRegistros=0;
		$i=0;

		$this->mensaje="";

		// CALCULA EL PRIMER Y ULTIMO REGISTRO A MOSTRAR
		$primero=($this->p-1)*$this->registrosPorPagina;
		$ultimo=$primero + $this->registrosPorPagina;

		$this->t=count($this->rs);
		
		if ($this->t>0) {
		    $primeroAux=$primero;
		    $auxAgrupar="";
			// cuenta registros agrupados
			if ($this->nombre_campo_agrupar!="") {
				$i=0;
				$j=0;
				foreach ($this->rs as $row) {
					if ($auxAgrupar!=$row[$this->nombre_campo_agrupar]) {
						$auxAgrupar=$row[$this->nombre_campo_agrupar];
						if ($i==$primero) {
							$primeroAux=$j;
						}
						$i++;
					}
					$j++;
				}
				$this->t=$i;
			}
			// se mueve hasta el primer registro
			/*
			if (count($this->rs)>$primeroAux-1 && count($this->rs)<$primeroAux) {
				$this->rs->irAFila($primeroAux);
			} else {
				$primero=0;
				$primeroAux=0;
				$this->rs->irAFila($primeroAux);
				$this->mensaje="Número de página incorrecto";
			}
			*/
			$this->tp=$this->t/$this->registrosPorPagina;
			if (($this->t % $this->registrosPorPagina)>0) {
				$this->tp=floor($this->tp) + 1;
			}
			$i=$primero;
			$iAnterior=$i;
			$rowAnterior=null;
			$auxAgrupar="";
			$mostrados=0;
			ejecutar($this->funcion_encabezado);
			$actual=0;
			while ($actual<count($this->rs)  && $mostrados<$this->registrosPorPagina) {
				if ($actual==0) {
					$row=current($this->rs);
				} else {
					$row=next($this->rs);
				}
				if (!($actual<$primeroAux)) { // saltea los anteriores al primero
					if ($this->nombre_campo_agrupar!=null && $this->nombre_campo_agrupar!="") {
						if ($auxAgrupar!=$row[$this->nombre_campo_agrupar]) {
							if ($i!=$primero) {
								ejecutar($this->funcion_pie_grupo,$rowAnterior,$iAnterior);
							}
							$auxAgrupar=$row[$this->nombre_campo_agrupar];
							ejecutar($this->funcion_encabezado_grupo ,$row,$i);
							$mostrados++;
						}
					} else {
						$mostrados++;
					}
					ejecutar($this->funcion_fila ,$this->plantilla,$row,$i);
					$iAnterior=$i;
					$rowAnterior=$row;
					$i++;
				}
				$actual++;
			}
			if ($this->nombre_campo_agrupar!=null && $this->nombre_campo_agrupar!="" && $i!=$primero) {
				ejecutar($this->funcion_pie_grupo,$rowAnterior,$iAnterior);
			}
			ejecutar($this->funcion_pie);
			ejecutar($this->funcion_paginas ,$this->t,$primero,$this->tp,$this->p,$mostrados);
		} else {
		}	
		ejecutar($this->funcion_resultado ,$mostrados);
		return $mostrados;
	}
	
	function funcionEncabezadoTabla() {
		echo "<table border=1>";
		echo "<tr>";
		$campos=$this->rs->darCampos();
		foreach($campos as $f) {
			echo "<td>" ;
			echo $f;
			echo "</td>";
		}
		echo "</tr>";
	}

	function funcionEncabezadoGrupoTabla($row,$i) {
		echo "<tr><td>Encabezado Grupo</td></tr>";
	}

	function funcionFilaTabla(&$tpl,$row,$i) {
		echo "<tr>";
		$campos=$this->rs->darCampos();
		foreach($campos as $f) {
			echo "<td>" ;
			echo $row[$f];
			echo "</td>";
		}
		echo "</tr>";
	}

	function funcionPieGrupoTabla($row,$i) {
		echo "<tr><td>Pie Grupo</td></tr>";
	}

	function funcionPieTabla() {
		echo "</table>";
	}

	function funcionPaginasTabla($cantidadRegistros,$primero,$totalpaginas,$paginaActual,$mostrados) {
		$anterior="";
		$siguiente="";
		$totalRegistros="Total: " .$cantidadRegistros. " Registros.";
		if ($cantidadRegistros >= $mostrados-$primero+1 ) {
			$totalRegistros.=" Mostrando desde " .($primero + 1). " hasta " .($primero + $mostrados). " ";
			// hace links para todas las paginas si hay más de una página
			if ($totalpaginas>1) {
				$resultado="";
			  for ($i=1;$i<=$totalpaginas;$i++) {
				if ($paginaActual==$i)
					$resultado.="[" .$i. "] ";
				else
					$resultado.="<A HREF=# onclick='return verPagina(".$i. "," . $cantidadRegistros . ");' >[" .$i. "]</A> ";
			  }
			}
		   // si corresponde, hace un link a la página anterior
			if ($paginaActual > 1)
				$anterior="<A HREF=# onclick='return verPagina(". ($paginaActual-1) . "," . $cantidadRegistros . ");' >&lt; anterior</A> ";
			else
				$anterior="&lt; anterior ";
			// si corresponde, hace un link a la página siguiente
			if ($paginaActual < $totalpaginas)
				$siguiente="<A HREF=# onclick='return verPagina(". ($paginaActual+1) . "," . $cantidadRegistros . ");' >siguiente &gt;</A> ";
			else
				$siguiente=" siguiente &gt;";
		} else{
			$totalRegistros.=" Todos desplegados.";
		}
		echo "<br/>" . $resultado;
		echo "<br/>" . $totalRegistros;
		echo "<br/>" . $anterior;
		echo "<br/>" . $siguiente;
	}	
	
	function funcionResultadoTabla($cantidad) {
		if ($cantidad>0) {
			
		} else {
			echo "No hay registros";
		}
	}

	function funcionEncabezadoPlantilla() {
		$this->mostrarCampos(); 
		//echo "<br> parse encabezado " . $this->bloque_encabezado;
		$this->plantilla->parse($this->bloque_encabezado,false);		
	}

	function funcionEncabezadoGrupoPlantilla($row,$i) {
		$this->mostrarValores($row);
		//echo "<br> parse ecabezado grupo " . $this->bloque_encabezado_grupo;
		$this->plantilla->parse($this->bloque_encabezado_grupo,true);
	}

	function funcionFilaPlantilla(&$tpl,$row,$i) {
		$this->mostrarValores($row);
		//echo "<br> parse fila plantilla " . $this->bloque_fila;
		$tpl->parse($this->bloque_fila,true);
	}

	function funcionPieGrupoPlantilla($row,$i) {
		$this->mostrarValores($row);
		//echo "<br> parse pie grupo " . $this->bloque_pie_grupo;
		$this->plantilla->parse($this->bloque_pie_grupo,true);
	}

	function funcionPiePlantilla() {
		$this->mostrarCampos(); 
		//echo "<br> parse pie " . $this->bloque_pie;
		$this->plantilla->parse($this->bloque_pie,true);
	}

	function funcionPaginasPlantilla($cantidadRegistros,$primero,$totalpaginas,$paginaActual,$mostrados) {
		$anterior="";
		$siguiente="";
		$totalRegistros="Total: " .$cantidadRegistros. " Registros.";
		if ($cantidadRegistros >= $mostrados-$primero+1 ) {
		//
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
				  $this->plantilla->set_var("Pagina",$resultado);
				  $this->plantilla->parse($this->bloque_pagina,true);

				if ($paginaActual > 1) {
					$anterior="<A HREF=# onclick='return verPagina(". (1) . "," . $cantidadRegistros . ");' >|&lt;</A> ";
					$anterior.="<A HREF=# onclick='return verPagina(". ($paginaActual-1) . "," . $cantidadRegistros . ");' >&lt;</A> ";
				} else {
					$anterior="|&lt; &lt; ";
				}
				// si corresponde, hace un link a la página siguiente
				if ($paginaActual < $totalpaginas) {
					$siguiente="<A HREF=# onclick='return verPagina(". ($paginaActual+1) . "," . $cantidadRegistros . ");' >&gt;</A> ";
					$siguiente.="<A HREF=# onclick='return verPagina(". ($totalpaginas) . "," . $cantidadRegistros . ");' >&gt;|</A> ";
				} else {
					$siguiente=" &gt; &gt;|";
				}

		} else{
			$totalRegistros.=" Todos desplegados.";
			$this->plantilla->set_var($this->bloque_pagina,"");
		}
		$this->plantilla->set_var("TotalRegistros",$totalRegistros);
		$this->plantilla->set_var("Anterior",$anterior);
		$this->plantilla->set_var("Siguiente",$siguiente);
		$this->plantilla->parse($this->bloque_paginas,false);
	}
	
	function xfuncionPaginasPlantilla($cantidadRegistros,$primero,$totalpaginas,$paginaActual,$mostrados) {
		$anterior="";
		$siguiente="";
		$totalRegistros="Total: " .$cantidadRegistros. " Registros.";
		if ($cantidadRegistros >= $mostrados-$primero+1 ) {
			$totalRegistros.=" Mostrando desde " .($primero + 1). " hasta " .($primero + $mostrados). " ";
			// hace links para todas las paginas si hay más de una página
			if ($totalpaginas>1) {
				$resultado="";
			  for ($i=1;$i<=$totalpaginas;$i++) {
				if ($paginaActual==$i)
					$resultado.="[" .$i. "] ";
				else
					$resultado.="<A HREF=# onclick='return verPagina(".$i. "," . $cantidadRegistros . ");' >[" .$i. "]</A> ";
				$this->plantilla->set_var("Pagina",$resultado);
				$this->plantilla->parse($this->bloque_pagina,true);
			  }
			} else {
				$this->plantilla->set_var($this->bloque_pagina,"");
			}
		   // si corresponde, hace un link a la página anterior
			if ($paginaActual > 1)
				$anterior="<A HREF=# onclick='return verPagina(". ($paginaActual-1) . "," . $cantidadRegistros . ");' >&lt; anterior</A> ";
			else
				$anterior="&lt; anterior ";
			// si corresponde, hace un link a la página siguiente
			if ($paginaActual < $totalpaginas)
				$siguiente="<A HREF=# onclick='return verPagina(". ($paginaActual+1) . "," . $cantidadRegistros . ");' >siguiente &gt;</A> ";
			else
				$siguiente=" siguiente &gt;";
		} else{
			$totalRegistros.=" Todos desplegados.";
			$this->plantilla->set_var($this->bloque_pagina,"");
		}
		$this->plantilla->set_var("TotalRegistros",$totalRegistros);
		$this->plantilla->set_var("Anterior",$anterior);
		$this->plantilla->set_var("Siguiente",$siguiente);
		$this->plantilla->parse($this->bloque_paginas,false);
	}
	
	function funcionResultadoPlantilla($cantidad) {
		if ($cantidad>0) {
			$this->plantilla->set_var($this->bloque_nohay,"");
			//echo "<br> parse " . $this->bloque_resultados;
			$this->plantilla->parse($this->bloque_resultados,false);
		} else {
			$this->plantilla->set_var($this->bloque_resultados,"");
			//echo "<br> parse " . $this->bloque_nohay;
			$this->plantilla->parse($this->bloque_nohay,true);
		}
		//echo "<br> parse " . $this->bloque_grilla;
		$this->plantilla->parse($this->bloque_grilla,false);
	}

}

?>