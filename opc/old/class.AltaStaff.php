<?
class inscripcion_persona{

	var $nCon;

	function inscripcion_persona(){
		$this->nCon = conectarDB();
	}	
	
	function personaSeleccionarUna($idInscripcion){
		$sql = "SELECT * FROM personas_staff WHERE id_persona = '$idInscripcion';";
		$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al seleccionar Una persona");
		return $resultado;
	}

function inscripcionInsertar($camposValores) //$camposValores es del tipo array("nombredelcampo1"=>"valor1","nombredelcampo2"=>"valor2")
{
	$resultado=false;
	if (is_array($camposValores)) {
		$campos="";
		$valores="";
		foreach($camposValores as $campo=>$valor) { // recorre el array de parametros y arma la consulta
			if ($campos!="") {
				$campos.=",";
			}
			$campos.=$campo;
			if ($valores!="") {
				$valores.=",";
			}
			$valores.="\"".$valor."\"";
		}
		$sql="INSERT INTO personas_staff ($campos) VALUES ($valores)";
		
		$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al insertar: $sql");
	}	
	return $resultado;
}
	
	function inscripcionModificar( $idInscripcion, $camposValores) //$camposValores es del tipo array("nombredelcampo1"=>"valor1","nombredelcampo2"=>"valor2"))
	{
	$resultado=false;
	if (is_numeric($idInscripcion) && is_array($camposValores)) {
		$update="";
		foreach($camposValores as $campo=>$valor) { // recorre el array de parametros y arma la consulta
			if ($update!="") {
				$update.=",";
			}
			$update.="$campo =\"$valor\"";
		}
		$sql="UPDATE personas_staff SET $update WHERE id_persona=$idInscripcion";
		
		$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al modificar: $sql");
	}			
		return $resultado;		
	}
	
	
	function inscripcionEliminar($idInscripcion){
		return $this->inscripcionModificar($idInscripcion,array("eliminado"=>1));	
	}
	
	function listadoparaExcel(){
		$sql = "SELECT * FROM personas_staff  WHERE eliminado != '1' ORDER BY id_persona ASC";
		$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ");
		return $result;
	}
	
	function busquedaInscriptos($fechaBusqueda, $tipoPagoBusqueda, $palabraClaveBusqueda, $paisBusqueda,$categoriaBusqueda, $estadoPagoBusqueda, $tipoInsBusqueda,$date1Busqueda,$date2Busqueda, $nroPagina=1,$registrosPorPagina=2){
	
	/*echo "Fecha busqueda es: ";
	echo $fechaBusqueda;
	echo "<br>";
		echo "tipoPagoBusqueda es: ";
	echo $tipoPagoBusqueda;
		echo "<br>";
		echo "palabraClaveBusqueda es: ";
	echo $palabraClaveBusqueda;
		echo "<br>";
		echo "paisBusqueda es: ";
	echo $paisBusqueda;
	echo "<br>";
	echo "institucionBusqueda es: ";
	echo $institucionBusqueda;
		echo "<br>";
		echo "estadoPagoBusqueda es: ";
	echo $estadoPagoBusqueda;
		echo "<br>";
		echo "nroPagina es: ";
	echo $nroPagina;
		echo "<br>";
	echo "registrosPorPagina es: ";
	echo $registrosPorPagina;
		echo "<br>";*/
		
		/*if($fechaBusqueda){
			$consulta .= " tipoInscripcion = '".$fechaBusqueda."' AND ";
		}*/
		if($fechaBusqueda){
			if($fechaBusqueda=='2010-01-01'){
				$consulta .= " fecha <= '$fechaBusqueda' AND ";
			}
			if($fechaBusqueda=='2010-07-14'){
				$consulta .= " fecha < '$fechaBusqueda' AND fecha > '2010-01-01' AND ";
			}
			if($fechaBusqueda=='2010-07-27'){
				$consulta .= " fecha < '$fechaBusqueda' AND fecha > '2010-07-14' AND ";
			}
			if($fechaBusqueda=='2010-07-28'){
				$consulta .= " fecha => '$fechaBusqueda' AND ";
			}
		}
		if($tipoInsBusqueda){
			$consulta .= " tipoInscripto LIKE '". $tipoInsBusqueda . "%' AND ";
		}
		if($tipoPagoBusqueda){
			$consulta .= " formaPago LIKE '". $tipoPagoBusqueda . "' AND ";
		}
		if($palabraClaveBusqueda){
			$consulta .= " (nombre LIKE '%" . $palabraClaveBusqueda . "%' OR apellido LIKE '%" . $palabraClaveBusqueda . "%' OR mail LIKE '%" . $palabraClaveBusqueda . "%' ) AND ";
		}
		if($paisBusqueda){
			$consulta .= " pais = '". $paisBusqueda ."' AND ";
		}
		if($categoriaBusqueda){
			$consulta .= " tipoInscripcion LIKE '".$categoriaBusqueda."%' AND ";
		}		
		
		if($estadoPagoBusqueda){
			$consulta .= " estadoPago = '".$estadoPagoBusqueda."' AND ";
		}
		
		if(($date1Busqueda)&&($date2Busqueda)){
			$consulta .= " fecha <= '$date2Busqueda' AND fecha >= '$date1Busqueda' AND ";
		}	
		
		if($consulta){
			$consulta = " AND " . substr($consulta, 0, -4);
		}
		
		$sql = "SELECT COUNT(*) as Cantidad FROM inscripciones_congreso WHERE eliminado != '1' $consulta";
		$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. 1");
		$row=mysql_fetch_array($result);
		$cantidad=$row["Cantidad"];
		
		$sql = "SELECT * FROM inscripciones_congreso WHERE eliminado != '1' $consulta ORDER BY id DESC";
		$sql .= " LIMIT " . (($nroPagina-1) * $registrosPorPagina)   . ",$registrosPorPagina";
		
		/*echo "<br>";
		echo $date1Busqueda;
		echo "<br>";
		
		echo "<br>";
		echo $date2Busqueda;
		echo "<br>";
		
		echo "<br>";
		echo $sql;
		echo "<br>";*/
				
		$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. 2");
		
		
		return array("cantidad"=>$cantidad,"registros"=>$result);
	}


	function seleccionar_inscriptos_del_filtrado($arrayIDS){
		foreach($arrayIDS as $i){
			$sql1 = "SELECT * FROM inscripciones_congreso WHERE id = '$i' AND mail <> ''";
			$rs1 = mysql_query($sql1,$this->nCon) or die("Ha ocurrido un error en mailContacto_tl");
			while($row1 = mysql_fetch_array($rs1)){				
					$filtro .= " id = $i OR ";				
			}
		}
		$largo = strlen($filtro) - 3;
		$filtro = substr($filtro, 0, $largo);
		
		$sql = "SELECT * FROM inscripciones_congreso WHERE $filtro ORDER BY id";
		$rs = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error en seleccionar_trabajos_libres_del_filtrado");	
		//$rs = mysql_query($sql,$this->nCon) or false;			
		return $rs;
	}
	
	
}
?>