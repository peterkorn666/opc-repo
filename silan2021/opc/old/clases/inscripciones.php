<?
class inscripciones{

	var $nCon;
	
	function inscripciones(){
		$this->nCon = conectarDB();
	}
	
	
	function cantidadinscripto(){
		$sql = "SELECT * FROM inscripciones_congreso";
		$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ");
		$cantidad = mysql_num_rows($result);
		return $cantidad;
	}
	
	function leeoInscripto($cual){
		
		$sql = "SELECT * FROM inscripciones_congreso where id=$cual";
		$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ");
		
		$sql2 = "UPDATE inscripciones_congreso SET leido = '1' WHERE `id` = '$cual' LIMIT 1 ;";
		mysql_query($sql2,$this->nCon);
		
		return $result;
	}
	
	function cantidadInscriptoSinLeer(){
		$sql = "SELECT * FROM inscripciones_congreso where leido = 0;";
		$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ");
		$cantidad = mysql_num_rows($result);
		return $cantidad;
	}

	
	
	function bandejaEntrada(){
		$sql = "SELECT * FROM inscripciones_congreso order by " . $_SESSION["ordenarPor"] . " " . $_SESSION["ordenarPos"];		
		$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ");
		return $result;
	}
		
	function listadoparaExcel(){
		$sql = "SELECT * FROM inscripciones_congreso  WHERE eliminado != '1' ORDER BY id ASC";
		$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ");
		return $result;
	}
	
	function busquedaInscriptos($fechaBusqueda, $gradoBusqueda, $tipoPagoBusqueda, $miembroBusqueda, $palabraClaveBusqueda, $paisBusqueda, $estadoPagoBusqueda){
		if($fechaBusqueda){
			if($fechaBusqueda=='2008-10-31'){
				$consulta .= " fecha <= '$fechaBusqueda' AND ";
			}
			if($fechaBusqueda=='2009-03-31'){
				$consulta .= " fecha < '$fechaBusqueda' AND fecha > '2008-10-31' AND ";
			}
			if($fechaBusqueda=='2009-04-01'){
				$consulta .= " fecha => '$fechaBusqueda' AND ";
			}
		}
		if($gradoBusqueda){
			$consulta .= " modoCargo LIKE '$gradoBusqueda' AND ";
		}
		if($tipoPagoBusqueda){
			$consulta .= " formaPago LIKE '". utf8_decode($tipoPagoBusqueda) . "' AND ";
		}
		if($miembroBusqueda){
			$consulta .= " miembro LIKE '$miembroBusqueda' AND ";
		}
		if($palabraClaveBusqueda){
			$consulta .= " (nombre LIKE '%" . utf8_decode($palabraClaveBusqueda) . "%' OR apellido LIKE '%" . utf8_decode($palabraClaveBusqueda) . "%' OR mail LIKE '%" . utf8_decode($palabraClaveBusqueda) . "%' OR mailAlternativo LIKE '%" . utf8_decode($palabraClaveBusqueda) . "%') AND ";
		}
		if($paisBusqueda){
			$consulta .= " pais = '". utf8_decode($paisBusqueda) ."' AND ";
		}
		if($estadoPagoBusqueda){
			$consulta .= " estadoPago = '$estadoPagoBusqueda' AND ";
		}
		if($consulta){
			$consulta = " AND " . substr($consulta, 0, -4);
		}
		
		$sql = "SELECT * FROM inscripciones_congreso WHERE eliminado != '1' $consulta ORDER BY id ASC";
		$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ");
		return $result;
	}
	function inscripcionEliminar($cualID){
		$sql = "UPDATE inscripciones_congreso SET eliminado = '1' WHERE id = '$cualID';";
		$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ");
		return $result;	
	}
}
?>