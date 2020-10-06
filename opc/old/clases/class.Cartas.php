<?
function limpiar($valor) {
		// Retirar las barras 
		if (get_magic_quotes_gpc()) {
			$valor = stripslashes($valor);
		}	
		// Colocar comillas si no es un número o una cadena numérica
		/*if (!is_numeric($valor)) {
			$valor = "'" . mysql_real_escape_string($valor) . "'";
		}*/
		return $valor;
}

class cartas{

	var $nCon;
	
	function cartas(){
		$this->nCon = conectarDB();
	}
			
	function persistirCarta($parametros) {	
		$resultado=false;
		if (is_array($parametros)) {
			$campos="";
			$valores="";
			foreach($parametros as $campo=>$valor) { // recorre el array de parametros y arma la consulta
				if ($campos!="") {
					$campos.=",";
				}
				$campos.=$campo;
				if ($valores!="") {
					$valores.=",";
				}
				//$valores.="\"".$valor."\"";
				$valor = limpiar($valor);
				if(!is_numeric($valor)){
					$valor = "'" . $this->nCon->real_escape_string($valor) . "'";
				}
				$valores .= $valor;
			}
			$sql="INSERT INTO cartas ($campos) VALUES ($valores)";
				
			//$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al insertar una carta");
			$resultado = $this->nCon->query($sql);
			if(!$resultado){
				die("Ha ocurrido un error al insertar una carta");
			}
		}	
		return $resultado;
	}
	
	function editarCarta($parametros, $idCarta){
		$resultado=false;
		if (is_array($parametros)) {
			$campos="";
			foreach($parametros as $campo=>$valor) {
				$valor = limpiar($valor);
				if(!is_numeric($valor)){
					$valor = "'" . $this->nCon->real_escape_string($valor) . "'";
				}
				
				if ($campo!="") {					
					$campos.= $campo. "=" . $valor .", ";				
				}
				
			}			
		}
		if ($campos!=""){
			$campos = substr($campos,0, -2); 
		}		
		if ($campos!=""){
			$sql="UPDATE cartas SET $campos WHERE idCarta='$idCarta'";
			//$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al actualizar");
			$resultado = $this->nCon->query($sql);
			if(!$resultado){
				die("Ha ocurrido un error al actualizar");
			}
		}
		return $resultado;
	}
	
	function listarTodas(){
		$sql="SELECT * FROM cartas WHERE eliminada<>'1' ORDER BY titulo;";
		//$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al cargar las cartas");
		$resultado = $this->nCon->query($sql);
		if(!$resultado){
			die("Ha ocurrido un error al cargar las cartas");
		}
		return $resultado;
	}
	
	function cargarPredefinidas($destinatarios){
		$sql="SELECT * FROM cartas WHERE destinatarios = '$destinatarios' AND eliminada<>'1' ORDER BY titulo;";
		//$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al cargar las cartas ".mysql_error());
		$resultado = $this->nCon->query($sql);
		if (!$resultado){
			die("Ha ocurrido un error al cargar las cartas ".$this->nCon->error);
		}
		return $resultado;
	}
	
	function cargarUna($idCarta){
		$sql="SELECT * FROM cartas WHERE idCarta = '$idCarta';";
		//$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al una carta");
		$resultado = $this->nCon->query($sql);
		if (!$resultado){
			die("Ha ocurrido un error al cargar una carta ".$this->nCon->error);
		}	
		return $resultado;
	}
	
	function eliminarUna($idCarta){
		$sql="UPDATE cartas SET eliminada='1' WHERE idCarta = '$idCarta';";
		//$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al eliminar una carta");		
		$resultado = $this->nCon->query($sql);
		if (!$resultado){
			die("Ha ocurrido un error al eliminar una carta ".$this->nCon->error);
		}	
		return $resultado;
	}
	
	function personificarPorPersona($cartaMail, $idPersona){	
		$sql="SELECT * FROM conferencistas WHERE id_conf = '$idPersona';";
		//$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al personificar una carta");	
		$resultado = $this->nCon->query($sql);
		if (!$resultado){
			die("Ha ocurrido un error al personificar una carta ".$this->nCon->error);
		}
		/*  $pers = mysql_fetch_array($resultado) */
		if ($pers = $resultado->fetch_array()){
			$cartaMail = str_replace("<:profesion>", $pers["profesion"] , $cartaMail);
			$cartaMail = str_replace("<:nombre>", $pers["nombre"] , $cartaMail);
			$cartaMail = str_replace("<:apellido>", $pers["apellido"] , $cartaMail);
			if($pers["pais"])
			{
				//$gPais = mysql_query("SELECT * FROM paises WHERE ID_Paises='{$pers["pais"]}'");
				$gPais = $this->nCon->query("SELECT * FROM paises WHERE ID_Paises='{$pers["pais"]}'");
				/* $pais = mysql_fetch_array($gPais) */
				if ($pais = $gPais->fetch_array())
					$pers["pais"] = $pais['Pais'];
			}
			$cartaMail = str_replace("<:pais>", $pers["pais"] , $cartaMail);
			$cartaMail = str_replace("<:institucion>", $pers["institucion"] , $cartaMail);
			$cartaMail = str_replace("<:mail>", $pers["email"] , $cartaMail);
			$cartaMail = str_replace("<:ciudad>", $pers["ciudad"] , $cartaMail);
			$cartaMail = str_replace("<:cargos>", $pers["cargos"] , $cartaMail);
			$cartaMail = str_replace("<:clave>", $pers["clave"] , $cartaMail);
			$cartaMail = str_replace("<:link>", base64_encode($pers["ID_Personas"]) , $cartaMail);			
			$cartaMail = str_replace("<:habitacion>", $pers["habitacion"] , $cartaMail);
			
			
			
			
			$cartaMail = str_replace("<:hotel>", $pers["hotel"] , $cartaMail);
			$cartaMail = str_replace("<:hotel_in>", $pers["hotel_in"] , $cartaMail);
			$cartaMail = str_replace("<:hotel_out>", $pers["hotel_out"] , $cartaMail);
			$cartaMail = str_replace("<:cantidad_noches>", $pers["cantNoches"] , $cartaMail);
			$cartaMail = str_replace("<:costo_hotel>", $pers["costoHotel"] , $cartaMail);
			$cartaMail = str_replace("<:codigo_reserva>", $pers["codReserva"] , $cartaMail);
			$cartaMail = str_replace("<:forma_pago>", $pers["formaPagoTras"] , $cartaMail);
			$cartaMail = str_replace("<:aeropuero>", $pers["ciudadViene"] , $cartaMail);
			$cartaMail = str_replace("<:compania_arribo>", $pers["comp_ll"] , $cartaMail);
			$cartaMail = str_replace("<:vuelo_arribo>", $pers["vuelo_ll"] , $cartaMail);
			$cartaMail = str_replace("<:fecha_arribo>", $pers["fecha_ll"] , $cartaMail);
			$cartaMail = str_replace("<:hora_arribo>", $pers["hora_ll"] , $cartaMail);
			$cartaMail = str_replace("<:quien_se_hace_cargo_arribo>", $pers["cargoTraslado1"] , $cartaMail);
			$cartaMail = str_replace("<:hora_traslado_1>", $pers["horaTraslado1"] , $cartaMail);
			$cartaMail = str_replace("<:compania_partida>", $pers["comp_sal"] , $cartaMail);
			$cartaMail = str_replace("<:vuelo_partida>", $pers["vuelo_sal"] , $cartaMail);
			$cartaMail = str_replace("<:fecha_partida>", $pers["fecha_sal"] , $cartaMail);
			$cartaMail = str_replace("<:hora_partida>", $pers["hora_sal"] , $cartaMail);
			$cartaMail = str_replace("<:quien_se_hace_cargo_partida>", $pers["cargoTraslado2"] , $cartaMail);
			$cartaMail = str_replace("<:hora_traslado_2>", $pers["horaTraslado2"] , $cartaMail);
			$cartaMail = str_replace("<:nombre_acompañante>", $pers["nombreCompa"] , $cartaMail);
			$cartaMail = str_replace("<:fecha_Nacimiento>", $pers["fechaNacimiento"] , $cartaMail);
			$cartaMail = str_replace("<:carta_Mail>", $pers["cartaMail"] , $cartaMail);
			$cartaMail = str_replace("<:estado_Pago>", $pers["estadoPago"] , $cartaMail);
			$cartaMail = str_replace("<:monto_Pago>", $pers["montoPago"] , $cartaMail);
			$cartaMail = str_replace("<:numero_Recibo>", $pers["numRecibo"] , $cartaMail);
		}
		return $cartaMail;
	}
	
	function personificarPorPersonaTL($cartaMail, $idPersona){	
		$sql="SELECT * FROM personas_trabajos_libres p JOIN instituciones i ON p.Institucion=i.ID_Instituciones WHERE p.ID_Personas = '$idPersona';";
		//$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al personificar una carta");
		$resultado = $this->nCon->query($sql);
		if (!$resultado){
			die("Ha ocurrido un error al personificar una carta ".$this->nCon->error);
		}
		/* $pers = mysql_fetch_array($resultado) */
		if ($pers = $resultado->fetch_array()){
			$cartaMail = str_replace("<:profesion>", $pers["Profesion"] , $cartaMail);
			$cartaMail = str_replace("<:nombre>", $pers["Nombre"] , $cartaMail);
			$cartaMail = str_replace("<:apellidos>", $pers["Apellidos"] , $cartaMail);
			$cartaMail = str_replace("<:pais>", $pers["Pais"] , $cartaMail);
			$cartaMail = str_replace("<:institucion>", $pers["Institucion"] , $cartaMail);
			$cartaMail = str_replace("<:mail>", $pers["Mail"] , $cartaMail);
			$cartaMail = str_replace("<:ciudad>", $pers["ciudad"] , $cartaMail);
			$cartaMail = str_replace("<:cargos>", $pers["Cargos"] , $cartaMail);
		}
		return $cartaMail;
	}
	
	function personificarPorInscripto($cartaMail, $idInscripto){	
		$sql="SELECT i.nombre, i.apellido, p.Pais as pais_inscripto FROM inscriptos i LEFT JOIN paises p ON i.pais=p.ID_Paises WHERE i.id = '$idInscripto';";
		$resultado = $this->nCon->query($sql);
		if (!$resultado){
			die("Ha ocurrido un error al personificar una carta ".$this->nCon->error);
		}
		if ($inscripto = $resultado->fetch_array()){
			$cartaMail = str_replace("<:nombre>", $inscripto['nombre'], $cartaMail);
			$cartaMail = str_replace("<:apellido>", $inscripto['apellido'], $cartaMail);
			$cartaMail = str_replace("<:pais>", $inscripto['pais_inscripto'], $cartaMail);
			$cartaMail = str_replace("<:email>", $inscripto['email'], $cartaMail);
		}
		return $cartaMail;
	}
	
	function guardarCopia($email,$id){
		$fecha = date("Y/m/d");
		$sql = "UPDATE personas SET cartaEnviada=CONCAT(cartaEnviada,'')";
		
	}
}	

?>